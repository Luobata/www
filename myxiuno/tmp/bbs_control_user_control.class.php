<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'C:/Users/yaogou/Documents/SoftWare/wamp/wamp/www/myxiuno/tmp/control_common_control.class.php';

class user_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		
		// resetpw_on, reg_email_on, resetpw_on, reg_email_on
		$this->conf += $this->kv->xget('conf_ext');
		
	}
	
	// ajax 登录
	public function on_login() {

		if(!$this->form_submit()) {
			

			if(core::gpc('ajax')) {
				$this->view->display('user_login_ajax.htm');
			} else {
				$referer = $this->get_referer();
				$this->view->assign('referer', $referer);
				$this->view->display('user_login.htm');
			}
		} else {
			$userdb = $error = array();
			$email = core::gpc('email', 'P');
			$password = core::gpc('password', 'P');
			$clienttime = core::gpc('clienttime', 'P');
			
			if(empty($email)) {
				$error['email'] = '请填写用户名或Email';
				$this->message($error);
			}
			

			$userdb = $this->user->get_user_by_email($email);
			if(empty($userdb)) {
				$userdb = $this->user->get_user_by_username($email);
				if(empty($userdb)) {
					$error['email'] = '用户名/Email 不存在';
					log::write('EMAIL不存在:'.$email, 'login.php');
					$this->message($error);
				}
			}
			$uid = $userdb['uid'];
			
			if(!$this->user->verify_password($password, $userdb['password'], $userdb['salt'])) {
				$error['password'] = '密码错误!';
				$log_password = '******'.substr($password, 6);
				log::write("密码错误：$email - $log_password", 'login.php');
				$this->message($error);
			}
			

			if(!array_filter($error)) {
				$error = array();
				$error['user']['username'] =  $userdb['username'];
				$error['user']['auth'] =  $this->user->get_xn_auth($userdb);
				$error['user']['groupid'] =  $userdb['groupid'];
				

				$this->user->set_login_cookie($userdb, $clienttime + 86400 * 30);
				
				// 更新在线列表
				$this->update_online();
			}
			$this->message($error);
			
		}
	}
	
	public function on_logout() {
		

		$error = array();
		if(!$this->form_submit()) {
			

			if(core::gpc('ajax')) {
				$this->view->display('user_logout_ajax.htm');
			} else {
				$referer = $this->get_referer();
				$this->view->assign('referer', $referer);
				$this->view->display('user_logout.htm');
			}
		} else {
			
			// 清除 online username
			$sid = $this->_sid;
			$online = $this->online->read($sid);
			if($online) {
				$online['groupid'] = 0;
				$online['uid'] = 0;
				$online['username'] = '';
				$this->online->update($online);
			}
			

			misc::setcookie($this->conf['cookie_pre'].'auth', '', 0, $this->conf['cookie_path'], $this->conf['cookie_domain']);
			$this->message($error);
		}
	}
	
	// ajax 注册
	public function on_create() {
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		if(!$this->conf['reg_on']) {
			$this->message('当前注册功能已经关闭。', 0);
		}

		if(!$this->form_submit()) {
			

			if(core::gpc('ajax')) {
				$this->view->display('user_create_ajax.htm');
			} else {
				$referer = $this->get_referer();
				$this->view->assign('referer', $referer);
				$this->view->display('user_create.htm');
			}
		} else {
			
			// 接受数据
			$userdb = $error = array();
			$email = core::gpc('email', 'P');
			$username = core::gpc('username', 'P');
			$password= core::gpc('password', 'P');
			$password2 = core::gpc('password2', 'P');
			$clienttime = core::gpc('clienttime', 'P');
			
			// check 数据格式
			$error['email'] = $this->user->check_email($email);
			$error['email_exists'] = $this->user->check_email_exists($email);
			
			// 如果email存在
			if($error['email_exists']) {
				// 如果该Email一天内没激活，则删除掉，防止被坏蛋“占坑”。
				$uid = $this->user->get_uid_by_email($email);
				$_user = $this->user->read($uid);
				if($_user['groupid'] == 6 && $_SERVER['time'] - $_user['regdate'] > 86400) {
					$this->user->delete($uid);
					$error['email_exists'] = '';
				}
			}
			$error['username'] = $this->user->check_username($username);
			$error['username_exists'] = $this->user->check_username_exists($username);
			$error['password'] = $this->user->check_password($password);
			$error['password2'] = $this->user->check_password2($password, $password2);
			
			$groupid = $this->conf['reg_email_on'] ? 6 : 11;
			$salt = substr(md5(rand(10000000, 99999999).$_SERVER['time']), 0, 8);
			$user = array(
				'username'=>$username,
				'email'=>$email,
				'password'=>$this->user->md5_md5($password, $salt),
				'groupid'=>$groupid,
				'salt'=>$salt,
			);
			

			
			// 判断结果
			if(!array_filter($error)) {
				$error = array();
				$uid = $this->user->xcreate($user);
				if($uid) {
					// 发送激活邮件
					if($this->conf['reg_email_on']) {
						try {
							$this->send_active_mail($uid, $username, $email, $error);	// $error['email_smtp_url']
						} catch(Exception $e) {
							$error['emailsend'] = '激活邮件发送失败！';
						}
					}
					
					// 此处由 $error 携带部分用户信息返回。
					$userdb = $this->user->read($uid);
					$error['user'] = array();
					$error['user']['username'] = $userdb['username'];
					$error['user']['auth'] = $this->user->get_xn_auth($userdb);
					$error['user']['groupid'] = $userdb['groupid'];
					$error['user']['uid'] = $uid; // 此处遗漏，感谢杨永全细心指正。
					
					$this->user->set_login_cookie($userdb, $clienttime + 86400 * 30);
					$this->runtime->xset('users', '+1');
					$this->runtime->xset('todayusers', '+1');
					$this->runtime->xset('newuid', $uid);
					$this->runtime->xset('newusername', $userdb['username']);
					// $this->runtime->xsave();
					

					
				}
			}
			$this->message($error);
		}
	}
	
	// 重新发送激活连接
	public function on_reactive() {
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		// 检查是否已经激活
		$user = $this->user->read($this->_user['uid']);
		if(empty($user)) {
			$this->message('用户不存在！');
		}
		if($user['groupid'] != 6) {
			$this->message('您的账户已经激活，无需再次获取激活码！');
		}
		
		// 判断上次激活的时间（这里重用注册时间）
		if($_SERVER['time'] - $user['regdate'] > 86400) {
			$error = array();
			try {
				

				$this->send_active_mail($user['uid'], $user['username'], $user['email'], $error);
				
				// 更新最后发送的时间，防止重复发送
				$user['regdate'] = $_SERVER['time'];
				$this->user->update($user);
			} catch(Exception $e) {
				
				log::write('发送激活码失败:'.$user['email'].', error:'.$e->getMessage(), 'login.php');
				
				$this->message('可能服务器繁忙，发送邮件失败，请您明天再来尝试获取激活码！');
			}
			
			if(empty($error)) {
				$this->message($error);
			} else {
				$emailarr = explode('@', $user['email']);
				$emailinfo = $this->mmisc->get_email_site($emailarr[1]);
				$url = "<a href=\"$emailinfo[url]\" target=\"_blank\"><b>【$emailinfo[name]】</b></a>";
				$this->message('已经重新给您的信箱 ('.$user['email'].') 发送了激活码邮件：登录：'.$url);
			}
			
		} else {
			$this->message('一天只能获取激活一次激活码！');
		}
	}
	
	// 重设密码，邮箱验证
	public function on_resetpw() {
		// 输入邮箱，发送重设密码连接
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		$mail = $this->kv->get('mail_conf');
		
		if(empty($mail['smtplist'])) {
			$this->message('站点没有设置 SMTP，无法使用此功能，如果有疑问请联系管理员。');
		}
		
		if(empty($this->conf['resetpw_on'])) {
			$this->message('站点没有开启密码找回的功能，如果有疑问请联系管理员。');
		}
		
		$error = array();
		$email = '';
		if($this->form_submit()) {
			$email = core::gpc('email', 'P');
			// 发送验证邮箱，todo:如何防止重复不停的发送？每天只能找回一次。tmp 目录保存今日的 username，每日计划任务清空一次
			// 保存用户 uid
			// 发送链接
			$userdb = $this->user->get_user_by_email($email);
			if(empty($userdb)) {
				$userdb = $this->user->get_user_by_username($email);
				if(empty($userdb)) {
					$error['email'] = '用户名/Email 不存在';
					$this->message($error);
				}
			}
			$username = $userdb['username'];
			$time = substr($_SERVER['time'], 0, -4);
			$verify = md5($username.$time.md5($this->conf['auth_key']));
			
			$username_url = core::urlencode($username);
			$url = "http://localhost/myxiuno/?user-resetpw2-username-$username_url-verify-$verify.htm";
			
			$emailarr = explode('@',$email);
			$emailinfo = $this->mmisc->get_email_site($emailarr[1]);	
			$email_smtp_url = $emailinfo['url'];
			$email_smtp_name = $emailinfo['name'];
			
			$subject = "您的找回密码邮件！-".$this->conf['app_name'];
			$message = "
				<html>
					<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
					</head>
					<body>
						<h2>尊敬的用户 $username, 您好！</h2>
						<h3>点击以下链接找回您在【".$this->conf['app_name']."】的密码（该链接有效时间：三小时）：<br /><a href=\"$url\" target=\"_blank\">$url</a></h3>
					</body>
				</html>
			";
			$emailsend = $this->mmisc->sendmail($username, $email, $subject, $message);
			if(empty($emailsend)) {
				$this->message("密码重设邮件发送成功！<a href=\"$email_smtp_url\" target=\"_blank\">请点击进入【{$email_smtp_name}】查收</a>", 1, $email_smtp_url);
			} else {
				$this->message("发送邮件碰到了错误：$emailsend", 0);
			}
		}
		
		$this->view->assign('email', $email);
		$this->view->assign('error', $error);
		$this->view->display('user_resetpw.htm');
	}
	
	// 邮箱跳转过来
	public function on_resetpw2() {
		$username_url = core::gpc('username');
		$username = core::urldecode($username_url);
		$verify = core::gpc('verify');
		$time = substr($_SERVER['time'], 0, -4);
		$verify2 = md5($username.$time.md5($this->conf['auth_key']));
		
		if($verify != $verify2) {
			$this->message('链接可能已经过期，请返回。', 0);
		}
		
		// 重设密码！给出重设密码的表单！
		$error = array();
		if($this->form_submit()) {
			$password = core::gpc('password', 'P');
			$password2 = core::gpc('password2', 'P');
			$error['password'] = $this->user->check_password($password);
			if(empty($error['password'])) {
				if($password != $password2) {
					$error['password2'] = '两次输入的不一致';
				} else {
					// 设置密码
					$user = $this->user->get_user_by_username($username);
					if(empty($user)) {
						$this->message('该用户不存在！', 0);
					} else {
						$user['password'] = $this->user->md5_md5($password, $user['salt']);
						$this->user->update($user);
						$error = array();
						
						// 重新设置 cookie
						$this->user->set_login_cookie($user);
						$this->message($user['username'].'，您好，修改密码成功！', 1, './');
					}
				}
			}
		}
		
		$this->view->assign('username_url', $username_url);
		$this->view->assign('username', $username);
		$this->view->assign('verify', $verify);
		$this->view->assign('email', $email);
		$this->view->assign('error', $error);
		$this->view->display('user_resetpw2.htm');
		
	}
	
	// email 激活
	public function on_active() {
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		$code = core::gpc('code');
		if(empty($code)) {
			$this->message('缺少参数 code。');
		}
		$s = decrypt($code, $this->conf['auth_key']);
		$arr = explode("\t",  $s);
		if(empty($arr) || empty($s)) {
			$this->message('参数解密错误。');
		}
		
		$uid = $arr[0];
		$time = $arr[1];
		if($_SERVER['time'] - $time > 86400) {
			$this->message('激活链接已经过期（超过一天），请重新注册。');
		}
		
		$user = $this->user->read($uid);
		$this->check_user_exists($user);
		if($user['groupid'] != 6) {
			$this->message('您的账户已经激活，不需要重新激活。');
		}
		$user['groupid'] = 11;
		$this->user->update($user);
		

		
		// 手工设置 cookie.
		$this->user->set_login_cookie($user);
		
		$this->message($user['username'].'，您好！您的账号激活成功！', 1, $this->conf['app_url']);
	}
	
	public function on_uploadavatar() {
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		$uid = $this->_user['uid'];
		$this->check_login();
		
		$this->check_forbidden_group();
		$user = $this->user->read($uid);
		if(!$this->check_user_access($user, 'attach', $message)) {
			$this->message($message, 0);
		}
		

		
		$dir = image::set_dir($uid, $this->conf['upload_path'].'avatar/');
		$destfile = $this->conf['upload_path']."avatar/$dir/{$uid}_tmp.jpg";
		$desturl = $this->conf['upload_url']."avatar/$dir/{$uid}_tmp.jpg?".$_SERVER['time'];
		
		if(empty($_FILES['Filedata']['tmp_name'])) {
			$this->message('请上传图片！', 0);
		}
		if(!$this->attach->is_safe_image($_FILES['Filedata']['tmp_name'])) {
			$this->message('系统检测到你上传的图片不是安全的，请更换其他图片试试！', 0);
		}
				
		$arr = image::thumb($_FILES['Filedata']['tmp_name'], $destfile, 800, 800);
		$json = array('width'=>$arr['width'], 'height'=>$arr['height'], 'body'=>$desturl);
		

		$this->message($json, 1);
	}
	
	public function on_clipavatar() {
		
		// 检查IP 屏蔽
		$this->check_ip();
		
		$uid = $this->_user['uid'];
		$this->check_login();
		$user = $this->user->read($uid);
		$this->check_user_exists($user);
		
		$x = intval(core::gpc('x', 'P'));
		$y = intval(core::gpc('y', 'P'));
		$w = intval(core::gpc('w', 'P'));
		$h = intval(core::gpc('h', 'P'));
		$dir = image::get_dir($uid);
		
		$srcfile = $this->conf['upload_path']."avatar/$dir/$user[uid]_tmp.jpg";
		$tmpfile = $this->conf['upload_path']."avatar/$dir/$user[uid]_tmp_tmp.jpg";
		$smallfile = $this->conf['upload_path']."avatar/$dir/$user[uid]_small.gif";
		$middlefile = $this->conf['upload_path']."avatar/$dir/$user[uid]_middle.gif";
		$bigfile = $this->conf['upload_path']."avatar/$dir/$user[uid]_big.gif";
		$hugefile = $this->conf['upload_path']."avatar/$dir/$user[uid]_huge.gif";
		$hugeurl = $this->conf['upload_url']."avatar/$dir/$user[uid]_huge.gif?".$_SERVER['time'];
		

		
		image::clip($srcfile, $tmpfile, $x, $y, $w, $h);
		
		image::thumb($tmpfile, $smallfile, $this->conf['avatar_width_small'], $this->conf['avatar_width_small']);
		image::thumb($tmpfile, $middlefile, $this->conf['avatar_width_middle'], $this->conf['avatar_width_middle']);
		image::thumb($tmpfile, $bigfile, $this->conf['avatar_width_big'], $this->conf['avatar_width_big']);
		image::thumb($tmpfile, $hugefile, $this->conf['avatar_width_huge'], $this->conf['avatar_width_huge']);
		
		unlink($srcfile);
		unlink($tmpfile);
		
		if(is_file($middlefile)) {
			$user['avatar'] = $_SERVER['time'];
			$this->user->update($user);
			

			$this->message($hugeurl, 1);
		} else {
			$this->message('保存失败', 0);
		}
	}
	
	// 检测用户是否可以注册
	public function on_checkname() {
		$username = core::urldecode(core::gpc('username'));
		$error = $this->user->check_username($username);
		empty($error) && $error = $this->user->check_username_exists($username);
		if(empty($error)) {
			$this->message('可以注册', 1);
		} else {
			$this->message($error, 0);
		}
	}
	
	// 检测 email 是否已经被注册
	public function on_checkemail() {
		$email = core::urldecode(core::gpc('email'));
		$emailerror = $this->user->check_email($email);
		if($emailerror) {
			$this->message($emailerror, 0);
		}
		$error = $this->user->check_email_exists($email);
		if(empty($error)) {
			$this->message('可以注册', 1);
		} else {
			$this->message('已经被注册', 0);
		}
	}
	
	// 发送激活连接 $user[username]
	private function send_active_mail($uid, $username, $email, &$error) {
		$emailarr = explode('@',$email);
		$emailinfo = $this->mmisc->get_email_site($emailarr[1]);	
		$error['email_smtp_url'] = $emailinfo['url'];
		$error['email_smtp_name'] = $emailinfo['name'];
		$code = encrypt("$uid	$_SERVER[time]", $this->conf['auth_key']);
		$url = "http://localhost/myxiuno/?user-active-code-$code.htm";
		$subject = '请激活您在'.$this->conf['app_name'].'注册的账号！';
		$message = "
			<html>
				<head>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
				</head>
				<body>
					尊敬的用户 {$username}，您好！<br />
					您在本站注册的账号还需一步完成注册，请点击以下链接激活您的账号：<br />
					<a href=\"$url\">$url</a>
				</body>
			</html>";

		$error['emailsend'] = $this->mmisc->sendmail($username, $email, $subject, $message);
	}
	
	private function get_referer() {
		$referer = core::gpc('HTTP_REFERER', 'S');
		(empty($referer) || strpos($referer, 'user-login') !== FALSE || strpos($referer, 'user-logout') !== FALSE ||  strpos($referer, 'user-create') !== FALSE) && $referer = $this->conf['app_url'];
		return $referer;
	}
	public function on_qqlogin() {
		$qqlogin = $this->kv->get('qqlogin');
		$appid = $qqlogin['appid'];
		$appkey = $qqlogin['appkey'];
		$callback = DEBUG ? urlencode('http://www.xiuno.com/user-qqtoken.htm') : urlencode('http://localhost/myxiuno/?user-qqtoken.htm');
		
		$scope = "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";
		$state = md5(uniqid(rand(), TRUE)); //CSRF protection
		$login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=$appid&redirect_uri=$callback&state=$state&scope=$scope";
		header("Location:$login_url");
	}
	
	public function on_qqtoken() {
	
		$qqlogin = $this->kv->get('qqlogin');
		$appid = $qqlogin['appid'];
		$appkey = $qqlogin['appkey'];
		$callback = DEBUG ? urlencode('http://www.xiuno.com/user-qqtoken.htm') : urlencode('http://localhost/myxiuno/?user-qqtoken.htm');
		
		$state = core::gpc('state', 'R');
		$code = core::gpc('code', 'R');
		
		$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=$appid&redirect_uri=$callback&client_secret=$appkey&code=$code";
		$s = misc::https_fetch_url($token_url);
		if(strpos($s, "callback") !== false) {
			$lpos = strpos($s, "(");
			$rpos = strrpos($s, ")");
			$s  = substr($s, $lpos + 1, $rpos - $lpos -1);
			$arr = core::json_decode($s);
			if(isset($arr['error'])) {
				$error = $arr['error'].'<br />'.$arr['error_description'];
				throw new Exception($error);
			}
		}
	
		$params = array();
		parse_str($s, $params);
		
		if(empty($params["access_token"])) {
			throw new Exception('access_token 解码出错。'.$s);
		}
	
		// token 有效期三个月
		$token = $params["access_token"];
		
		// 获取 openid
		$openid = $this->qqlogin_get_openid_by_token($token);
		
		/*
		Array
		(
		    [access_token] => F6890DF038193C8CEB040F2344592714
		    [expires_in] => 7776000
		)
		openid: 6AD06D578F81042387C7F7BFD6D99E38 Array
		(
		    [ret] => 0
		    [msg] => 
		    [nickname] => 黄
		    [gender] => 男
		    [figureurl] => http://qzapp.qlogo.cn/qzapp/100287386/6AD06D578F81042387C7F7BFD6D99E38/30
		    [figureurl_1] => http://qzapp.qlogo.cn/qzapp/100287386/6AD06D578F81042387C7F7BFD6D99E38/50
		    [figureurl_2] => http://qzapp.qlogo.cn/qzapp/100287386/6AD06D578F81042387C7F7BFD6D99E38/100
		    [figureurl_qq_1] => http://q.qlogo.cn/qqapp/100287386/6AD06D578F81042387C7F7BFD6D99E38/40
		    [figureurl_qq_2] => http://q.qlogo.cn/qqapp/100287386/6AD06D578F81042387C7F7BFD6D99E38/100
		    [is_yellow_vip] => 0
		    [vip] => 0
		    [yellow_vip_level] => 0
		    [level] => 0
		    [is_yellow_year_vip] => 0
		)
		*/
		
		// 查询数据表，
		$this->user_qqlogin = core::model($this->conf, 'user_qqlogin', 'uid', 'uid');
		$arrlist = $this->user_qqlogin->index_fetch(array('openid'=>$openid), array(), 0, 1);
		$arr = array_pop($arrlist);
		if(empty($arr)) {
			// 自动注册账户，如果用户名没被注册，则直接生成用户名，完成登录
			if(DEBUG) {
				$qquser = array('nickname'=>'张三', 'figureurl_1'=>'http://www.baidu.com/img/baidu_jgylogo3.gif', 'figureurl_2'=>'http://www.baidu.com/img/baidu_jgylogo3.gif');
			} else {
				$qquser = $this->qqlogin_get_user_by_openid($openid, $token, $appid);
			}
			$username = $qquser['nickname'];
			$figureurl_qq_2 = $qquser['figureurl_qq_2'];
			if(!$this->user->check_username_exists($username) && !$this->user->check_username($username)) {
				$this->qq_create_user($username, $figureurl_qq_2, $openid);
				$url = core::gpc('HTTP_REFERER', 'S') ? core::gpc('HTTP_REFERER', 'S') : './';
				header("Location:$url");
			} else {
				// 新用户名
				$args = encrypt("$openid\t$token", $this->conf['auth_key']);
				$url = "http://localhost/myxiuno/?user-qqreg-args-$args.htm";
				header("Location:$url");
			}
		} else {
			// 登陆成功，设置 cookie
			$user = $this->user->read($arr['uid']);
			$this->check_user_exists($user);
			$this->user->set_login_cookie($user);
			$url = "./";
			header("Location:$url");
		}
		
	}
	
	public function on_qqreg() {
		$qqlogin = $this->kv->get('qqlogin');
		$appid = $qqlogin['appid'];
		$appkey = $qqlogin['appkey'];
		
		$args = core::gpc('args');
		$s = decrypt($args, $this->conf['auth_key']);
		$arr = explode("\t", $s);
		if(DEBUG) {
			$openid = $token = '';
		} else {
			if(count($arr) < 2) {
				$this->message('参数错误', 0);
			}
			list($openid, $token) = $arr;
		}
		
		$input = $error = array();
		if(!$this->form_submit()) {
			if(DEBUG) {
				$qquser = array('nickname'=>'张三', 'figureurl_1'=>'http://www.baidu.com/img/baidu_jgylogo3.gif', 'figureurl_2'=>'http://www.baidu.com/img/baidu_jgylogo3.gif');
			} else {
				$qquser = $this->qqlogin_get_user_by_openid($openid, $token, $appid);
			}
			$username = $qquser['nickname'];
			$avatar_url_1 = $qquser['figureurl_1'];
			$avatar_url_2 = $qquser['figureurl_2'];
			$error['username'] = $this->user->check_username($username);
		// 头像
		} else {
			$username = core::gpc('username', 'P');
			$avatar_url_1 = core::gpc('avatar_url_1', 'P');
			$avatar_url_2 = core::gpc('avatar_url_2', 'P');
			
			$conf = $this->conf;
			
			if($avatar_url_2 && !check::is_url($avatar_url_2)) {
				$this->message('avatar_url_2 格式有误');
			}
			
			$error['username'] = $this->user->check_username($username) OR $error['username'] = $this->user->check_username_exists($username);
			if(!array_filter($error)) {
				$this->qq_create_user($username, $avatar_url_2, $openid);
			}
		}
		
		// 筛选用户名, 用户名，提示是否被注册
		
		$this->view->assign('username', $username);
		$this->view->assign('avatar_url_1', $avatar_url_1);
		$this->view->assign('avatar_url_2', $avatar_url_2);
		$this->view->assign('args', $args);
		$this->view->assign('input', $input);
		$this->view->assign('error', $error);
		$this->view->display('xn_qq_login_reg.htm');
	}
	
	private function qqlogin_get_openid_by_token($token) {
		$url = "https://graph.qq.com/oauth2.0/me?access_token=$token";
		$s  = misc::https_fetch_url($url);
		if(strpos($s, "callback") !== false) {
			$lpos = strpos($s, "(");
			$rpos = strrpos($s, ")");
			$s  = substr($s, $lpos + 1, $rpos - $lpos -1);
		}
		
		$arr = core::json_decode($s);
		if (isset($arr['error'])) {
			$error = $arr['error'].'<br />'.$arr['error_description'];
			throw new Exception($error);
		}
		
		return $arr['openid'];
	}
	
	private function qqlogin_get_user_by_openid($openid, $token, $appid) {
		$get_user_info = "https://graph.qq.com/user/get_user_info?access_token=$token&oauth_consumer_key=$appid&openid=$openid&format=json";
		$s = misc::https_fetch_url($get_user_info);
		$arr = json_decode($s, true);
		return $arr;
	}
	
	
	private function qq_create_user($username, $avatar_url_2, $openid) {
		$conf = $this->conf;
		$groupid = 11;
		$salt = rand(100000, 999999);
		$password = ''; // 密码为空，第一次修改，不需要输入密码。
		$email = '';	// email 为空
		$user = array(
			'username'=>$username,
			'email'=>$email,
			'password'=>$password,
			'groupid'=>$groupid,
			'salt'=>$salt,
		);
		
		$uid = $this->user->xcreate($user);
		
		$this->user_qqlogin = core::model($this->conf, 'user_qqlogin', 'uid', 'uid');
		$this->user_qqlogin->create(array('uid'=>$uid, 'openid'=>$openid));
		
		// hook user_create_after.php
		
		$userdb = $this->user->read($uid);
		$this->user->set_login_cookie($userdb);
		
		$this->runtime->xset('users', '+1');
		$this->runtime->xset('todayusers', '+1');
		$this->runtime->xset('newuid', $uid);
		$this->runtime->xset('newusername', $userdb['username']);
		
		// hook user_create_succeed.php
		
		// 更新头像
		/*
		if($avatar_url_2) {
			$dir = image::get_dir($uid);
			$smallfile = $conf['upload_path']."avatar/$dir/{$uid}_small.gif";
			$middlefile = $conf['upload_path']."avatar/$dir/{$uid}_middle.gif";
			$bigfile = $conf['upload_path']."avatar/$dir/{$uid}_big.gif";
			$hugefile = $conf['upload_path']."avatar/$dir/{$uid}_huge.gif";
			
			
			try {
				$s = misc::fetch_url($avatar_url_2, 5);
				file_put_contents($bigfile, $s);
				image::thumb($bigfile, $smallfile, $conf['avatar_width_small'], $conf['avatar_width_small']);
				image::thumb($bigfile, $middlefile, $conf['avatar_width_middle'], $conf['avatar_width_middle']);
				image::thumb($bigfile, $bigfile, $conf['avatar_width_big'], $conf['avatar_width_big']);
				image::thumb($bigfile, $hugefile, $conf['avatar_width_huge'], $conf['avatar_width_huge']);
				$user['avatar'] = $_SERVER['time'];
			} catch (Exception $e) {
				$userdb['avatar'] = 0;
			}
			
			$this->user->update($userdb);
		}
		*/
		
	}	public function on_weibologin() {
		$weibologin = $this->kv->get('weibologin');
		$appsecret = $weibologin['appsecret'];
		$appkey = $weibologin['appkey'];
		$callback = DEBUG ? urlencode('http://www.xiuno.com/user-weibotoken.htm') : urlencode('http://localhost/myxiuno/?user-weibotoken.htm');
		
		$state = md5(uniqid(rand(), TRUE)); //CSRF protection
		$login_url = "https://api.weibo.com/oauth2/authorize?response_type=code&client_id=$appkey&redirect_uri=$callback&state=$state&display=";
		header("Location:$login_url");
	}
	
	public function on_weibotoken() {
	
		$weibologin = $this->kv->get('weibologin');
		$appsecret = $weibologin['appsecret'];
		$appkey = $weibologin['appkey'];
		$callback = DEBUG ? urlencode('http://www.xiuno.com/user-weibotoken.htm') : urlencode('http://localhost/myxiuno/?user-weibotoken.htm');
		
		$state = core::gpc('state', 'R');
		$code = core::gpc('code', 'R');
		
		$token_url = "https://api.weibo.com/oauth2/access_token";
		$postStr="grant_type=authorization_code&client_id=$appkey&redirect_uri=$callback&client_secret=$appsecret&code=$code";
		$ch = curl_init(); //初始化curl
		curl_setopt($ch, CURLOPT_URL, $token_url);//设置链接
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
		curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);//POST数据
		$s = curl_exec($ch);//接收返回信息
		if(curl_errno($ch)) {
			throw new Exception('Errno'.curl_error($ch));//捕抓异常
		}
		if(!$s) {
			curl_close($ch);
			return false;
		}
		
		curl_close($ch);
		$params = json_decode($s,true);
		if(empty($params["access_token"])) {
			throw new Exception('读取access_token 出错。'.$s);
		}
	
		// token 有效期三个月
		$token = $params["access_token"];
		
		// 获取 openid
		$openid = $this->weibologin_get_openid_by_token($token);
		
		// 查询数据表，
		$this->user_weibologin = core::model($this->conf, 'user_weibologin', 'uid', 'uid');
		$arrlist = $this->user_weibologin->index_fetch(array('openid'=>$openid), array(), 0, 1);
		$arr = array_pop($arrlist);
		if(empty($arr)) {
			// 自动注册账户，如果用户名没被注册，则直接生成用户名，完成登录
			if(DEBUG) {
				$weibouser = array('nickname'=>'张三', 'figureurl_1'=>'http://www.baidu.com/img/baidu_jgylogo3.gif', 'figureurl_2'=>'http://www.baidu.com/img/baidu_jgylogo3.gif');
			} else {
				$weibouser = $this->weibologin_get_user_by_openid($openid, $token);
			}
			$username = $weibouser['name'];
			$figureurl_weibo_2 = $weibouser['profile_image_url'];
			if(!$this->user->check_username_exists($username) && !$this->user->check_username($username)) {
				$this->weibo_create_user($username, $figureurl_weibo_2, $openid);
				$url = core::gpc('HTTP_REFERER', 'S') ? core::gpc('HTTP_REFERER', 'S') : './';
				header("Location:$url");
			} else {
				// 新用户名
				$args = encrypt("$openid\t$token", $this->conf['auth_key']);
				$url = "http://localhost/myxiuno/?user-weiboreg-args-$args.htm";
				header("Location:$url");
			}
		} else {
			// 登陆成功，设置 cookie
			$user = $this->user->read($arr['uid']);
			$this->check_user_exists($user);
			$this->user->set_login_cookie($user);
			$url = "./";
			header("Location:$url");
		}
		
	}
	
	public function on_weiboreg() {
		$weibologin = $this->kv->get('weibologin');
		$appsecret = $weibologin['appsecret'];
		$appkey = $weibologin['appkey'];
		
		$args = core::gpc('args');
		$s = decrypt($args, $this->conf['auth_key']);
		$arr = explode("\t", $s);
		if(DEBUG) {
			$openid = $token = '';
		} else {
			if(count($arr) < 2) {
				$this->message('参数错误', 0);
			}
			list($openid, $token) = $arr;
		}
		
		$input = $error = array();
		if(!$this->form_submit()) {
			if(DEBUG) {
				$weibouser = array('nickname'=>'张三', 'figureurl_1'=>'http://www.baidu.com/img/baidu_jgylogo3.gif', 'figureurl_2'=>'http://www.baidu.com/img/baidu_jgylogo3.gif');
			} else {
				$weibouser = $this->weibologin_get_user_by_openid($openid, $token);
			}
			$username = $weibouser['name'];
			$avatar_url_1 = $weibouser['profile_image_url'];
			$avatar_url_2 = $weibouser['avatar_large'];
			$error['username'] = $this->user->check_username($username);
		// 头像
		} else {
			$username = core::gpc('username', 'P');
			$avatar_url_1 = core::gpc('avatar_url_1', 'P');
			$avatar_url_2 = core::gpc('avatar_url_2', 'P');
			
			$conf = $this->conf;
			
			if($avatar_url_2 && !check::is_url($avatar_url_2)) {
				$this->message('avatar_url_2 格式有误');
			}
			
			$error['username'] = $this->user->check_username($username) OR $error['username'] = $this->user->check_username_exists($username);
			if(!array_filter($error)) {
				$this->weibo_create_user($username, $avatar_url_2, $openid);
			}
		}
		
		// 筛选用户名, 用户名，提示是否被注册
		
		$this->view->assign('username', $username);
		$this->view->assign('avatar_url_1', $avatar_url_1);
		$this->view->assign('avatar_url_2', $avatar_url_2);
		$this->view->assign('args', $args);
		$this->view->assign('input', $input);
		$this->view->assign('error', $error);
		$this->view->display('xn_weibo_login_reg.htm');
	}
	
	private function weibologin_get_openid_by_token($token) {
		$url = "https://api.weibo.com/2/account/get_uid.json?access_token={$token}";
		$s = misc::https_fetch_url($url);
		$arr = core::json_decode($s);
		if (isset($arr['error_code'])&&$arr['error_code'] > 0) {
			$error = $arr['error'];
			throw new Exception($error);
		}
		return $arr['uid'];
	}
	
	private function weibologin_get_user_by_openid($openid, $token) {
		$url = "https://api.weibo.com/2/users/show.json?access_token={$token}&uid={$openid}";
		$s = misc::https_fetch_url($url);
		$arr = core::json_decode($s);
		return $arr;
	}
	
	
	private function weibo_create_user($username, $avatar_url_2, $openid) {
		$conf = $this->conf;
		$groupid = 11;
		$salt = rand(100000, 999999);
		$password = ''; // 密码为空，第一次修改，不需要输入密码。
		$email = '';	// email 为空
		$user = array(
			'username'=>$username,
			'email'=>$email,
			'password'=>$password,
			'groupid'=>$groupid,
			'salt'=>$salt,
		);
		
		$uid = $this->user->xcreate($user);
		
		$this->user_weibologin = core::model($this->conf, 'user_weibologin', 'uid', 'uid');
		$this->user_weibologin->create(array('uid'=>$uid, 'openid'=>$openid));
		
		// hook user_create_after.php
		
		$userdb = $this->user->read($uid);
		$this->user->set_login_cookie($userdb);
		
		$this->runtime->xset('users', '+1');
		$this->runtime->xset('todayusers', '+1');
		$this->runtime->xset('newuid', $uid);
		$this->runtime->xset('newusername', $userdb['username']);
		
		// hook user_create_succeed.php
		// 更新头像
		/*
		if($avatar_url_2) {
			$dir = image::get_dir($uid);
			$smallfile = $conf['upload_path']."avatar/$dir/{$uid}_small.gif";
			$middlefile = $conf['upload_path']."avatar/$dir/{$uid}_middle.gif";
			$bigfile = $conf['upload_path']."avatar/$dir/{$uid}_big.gif";
			$hugefile = $conf['upload_path']."avatar/$dir/{$uid}_huge.gif";
			
			
			try {
				$s = misc::fetch_url($avatar_url_2, 5);
				file_put_contents($bigfile, $s);
				image::thumb($bigfile, $smallfile, $conf['avatar_width_small'], $conf['avatar_width_small']);
				image::thumb($bigfile, $middlefile, $conf['avatar_width_middle'], $conf['avatar_width_middle']);
				image::thumb($bigfile, $bigfile, $conf['avatar_width_big'], $conf['avatar_width_big']);
				image::thumb($bigfile, $hugefile, $conf['avatar_width_huge'], $conf['avatar_width_huge']);
				$user['avatar'] = $_SERVER['time'];
			} catch (Exception $e) {
				$userdb['avatar'] = 0;
			}
			$this->user->update($userdb);
		}
		*/
		
	}

	
}

?>