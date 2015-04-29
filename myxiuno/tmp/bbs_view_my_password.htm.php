<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?php echo isset($_seo_keywords) ? $_seo_keywords : '';?>" />
	<meta name="description" content="<?php echo isset($_seo_description) ? $_seo_description : '';?> " />
	<meta name="generator" content="Xiuno BBS" />
	<meta name="author" content="Xiuno Team" />
	<meta name="copyright" content="2008-2012 xiuno.com" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->
	<meta xxx="xxx" /><meta xxx="xxx" />
	<link href="http://localhost/myxiuno/view/common.css" type="text/css" rel="stylesheet" />
	<link rel="shortcut icon" href="favicon.ico" />
	<style>
.icon-weibo {background: url(plugin/xn_weibo_login/sina_logo.png);}
</style>
	<script type="text/javascript">
	var cookie_pre = '<?php echo isset($conf['cookie_pre']) ? $conf['cookie_pre'] : '';?>';
	var g_uid = <?php echo isset($_user['uid']) ? $_user['uid'] : '';?>;
	</script>
	<title><?php if(!empty($_title)) { foreach($_title as &$title) {?><?php echo isset($title) ? $title : '';?> <?php }} ?></title>
</head>
<body>


<div id="wrapper1">
	
	<div id="wrapper2">
		
		<div id="menu" role="navigation">
			<div class="width">
				<table cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
					<tr>
						<td class="left"></td>
						<td class="logo"><a href="<?php echo isset($conf['logo_url']) ? $conf['logo_url'] : '';?>" title="<?php echo isset($conf['app_name']) ? $conf['app_name'] : '';?>"><span id="logo"></span></a></td>
						<td class="center">
							
							<span class="sep"></span>
							<a href="./" <?php echo isset($_checked['index']) ? $_checked['index'] : '';?>>首页</a>
							
							<?php if(!empty($conf['forumarr'])) { foreach($conf['forumarr'] as $_fid=>&$_name) {?>
							<span class="sep"></span>
							<a href="http://localhost/myxiuno/?forum-index-fid-<?php echo isset($_fid) ? $_fid : '';?>.htm" <?php echo isset($_checked["forum_$_fid"]) ? $_checked["forum_$_fid"] : '';?>><?php echo isset($_name) ? $_name : '';?></a>	
							<?php }}?>
							
						</td>
						<td class="center2">
							
							<?php if($conf['search_type']) { ?>
							<form action="http://localhost/myxiuno/?search-index.htm" target="_blank" id="search_form" method="post">
								<div id="search"><input type="text" id="search_keyword" name="keyword" x-webkit-speech lang="zh-CN" /></div>
								
							</form>
							<?php } ?>
							
						</td>
						<td class="right"></td>
					</tr>
				</table>
			</div>
		</div>
							
		
		
		<div id="body" role="main">
		
		

<link href="http://localhost/myxiuno/view/my.css" type="text/css" rel="stylesheet" />

<div class="width">

		<table id="nav" cellpadding="0" cellspacing="0" style="margin-bottom: 4px; clear: both;">
		<tr>
			<td class="left"></td>
			<td class="center">
				<a href="./" class="icon icon-home"></a>
				<span class="sep"></span>
				
				<a href="http://localhost/myxiuno/?my-profile.htm">我的空间</a>
				<?php if(!empty($_nav)) { foreach($_nav as &$nav) {?>
				<span class="sep"></span>
				<span><?php echo isset($nav) ? $nav : '';?></span>
				<?php }} ?>
			</td>
			<td class="center2">				<span id="user">
					<?php if(!empty($conf['qqlogin_enable']) && $_user['groupid'] == 0) { ?>
<a href="http://localhost/myxiuno/?user-qqlogin.htm" target="_blank" title="qq 登录"><span class="icon icon-qq"></span> QQ登录</a>
<?php } ?><?php if(!empty($conf['weibologin_enable']) && $_user['groupid'] == 0) { ?>
<a href="http://localhost/myxiuno/?user-weibologin.htm" target="_blank" title="weibo 登录"><span class="icon icon-weibo"></span> 登录</a>
<?php } ?>
				<?php if($_user['groupid'] == 0) { ?>
					<a href="http://localhost/myxiuno/?user-login.htm" class="ajaxdialog" onclick="return false" rel="nofollow"><span class="icon icon-user-user"></span> 登录</a>
					<a href="http://localhost/myxiuno/?user-create.htm" class="ajaxdialog" onclick="return false" rel="nofollow"><span class="icon icon-user-create"></span> 注册</a>
				<?php } else { ?>
					
					<a href="http://localhost/myxiuno/?my-profile.htm" title="<?php echo isset($_user['groupname']) ? $_user['groupname'] : '';?>"><span class="icon icon-user-user"></span> <?php echo isset($_user['username']) ? $_user['username'] : '';?></a>
					
					<?php if($_user['groupid'] == 6) { ?>
					<a href="http://localhost/myxiuno/?user-reactive.htm">邮箱激活</a>
					<?php } ?>
					
					<span id="pm">
						<a href="http://localhost/myxiuno/?my-pm.htm" class="pm"><span class="icon icon-pm"></span> 消息</a><a href="http://localhost/myxiuno/?my-pm.htm" style="display: none;" aria-label="消息" class="newpm"><span class="icon icon-newpm"></span> 消息</a>
					</span>
				
					<?php if($_user['groupid'] > 0 && $_user['groupid'] < 6) { ?>
					<a href="admin/" target="_blank"><span class="icon icon-setting"></span> 管理</a>
					<?php } ?>
				
					<a href="http://localhost/myxiuno/?user-logout.htm" class="ajaxdialog" onclick="return false"><span class="icon icon-user-logout"></span> 退出</a>
				<?php } ?>
					
				</span></td>
			<td class="right"></td>
		</tr>
	</table>


	<div class="left border shadow bg2">
		<div style="margin-top: 4px; text-align: center;">
	<span class="avatar_big border" id="avatar_menu" style="<?php if($_user['avatar_big']) { ?>background-image: url(<?php echo isset($_user['avatar_big']) ? $_user['avatar_big'] : '';?>)<?php } ?>"></span>
</div>

<div style="text-align: center; margin-bottom: 8px;" class="grey">
	<?php echo isset($_user['username']) ? $_user['username'] : '';?>
</div>

<ul class="left_menu">
	
	<li <?php echo isset($_checked['my_profile']) ? $_checked['my_profile'] : '';?>><a href="http://localhost/myxiuno/?my-profile.htm">我的资料</a></li>
	<li <?php echo isset($_checked['my_post']) ? $_checked['my_post'] : '';?>><a href="http://localhost/myxiuno/?my-post.htm">我的发帖</a></li>
	<li <?php echo isset($_checked['my_follow']) ? $_checked['my_follow'] : '';?>><a href="http://localhost/myxiuno/?my-follow.htm">我的联系人</a></li>
	<li <?php echo isset($_checked['my_wealth']) ? $_checked['my_wealth'] : '';?>><a href="http://localhost/myxiuno/?my-income.htm">我的财富</a></li>
	<li <?php echo isset($_checked['my_file']) ? $_checked['my_file'] : '';?>><a href="http://localhost/myxiuno/?my-upload.htm">我的文件</a></li>
	
</ul>
	</div>
	
	<div class="right">
		
				<div class="page tab" style="margin-bottom: 4px;">
			<a href="http://localhost/myxiuno/?my-profile.htm" <?php echo isset($_checked['profile']) ? $_checked['profile'] : '';?>>基本信息</a>
			<a href="http://localhost/myxiuno/?my-homepage.htm" <?php echo isset($_checked['homepage']) ? $_checked['homepage'] : '';?>>个人信息</a>
			<a href="http://localhost/myxiuno/?my-password.htm" <?php echo isset($_checked['password']) ? $_checked['password'] : '';?>>修改密码</a>
			<a href="http://localhost/myxiuno/?my-avatar.htm" <?php echo isset($_checked['avatar']) ? $_checked['avatar'] : '';?>>修改头像</a>
			
		</div>
		
		<div class="bg1 border shadow">
			<form action="http://localhost/myxiuno/?my-password.htm" method="post" id="my_password_form">
				<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
				
				<div class="body" style="width: 500px;">
					<dl>
						<br>

						<dt><label for="username">用户名：</label></dt>
						<dd><?php echo isset($_user['username']) ? $_user['username'] : '';?></dd>
						
						<?php if($_user['password']) { ?>
						<dt><label for="password">旧密码：</label></dt>
						<dd><input type="password" name="password" id="password" size="24" value="" title="请输入密码" style="width: 250px;" /></dd>
						<?php } ?>
						
						<dt><label for="newpassword">新密码：</label></dt>
						<dd><input type="password" name="newpassword" id="newpassword" size="24" value="" title="请输入新密码" style="width: 250px;" /></dd>
						
						<dt><label for="newpassword2">重复新密码：</label></dt>
						<dd><input type="password" name="newpassword2" id="newpassword2" size="24" value="" title="请重复输入新密码" style="width: 250px;" /></dd>
						
						
						
						<dt></dt>
						<dd>
							<a type="submit" class="button bigblue" id="my_password_submit" value="修改密码" href="javascript:void(0)" role="button"><span>修改密码</span></a>
							<a type="button" class="button biggrey" value="取消" onclick="history.back();return false;" href="javascript:void(0)" role="button"><span>取消</span></a>
							<div class="notice" id="notice" style="display: none;"></div>
						</dd>
					</dl>
					
				</div>
			</form>
		</div>
	</div>
</div>	

		
		</div>
		
	</div>
	
</div>




<div id="footer" role="contentinfo">
	
	<table class="width">
		<tr>
			<td class="left">
				<?php echo isset($conf['app_copyright']) ? $conf['app_copyright'] : '';?><br />
				Powered by  <a href="http://bbs.xiuno.com" target="_blank" class="grey">Xiuno BBS <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></a>
				
			</td>
			<td class="right">
				<?php echo isset($conf['china_icp']) ? $conf['china_icp'] : '';?><br />
				<?php echo isset($_SERVER['time_fmt']) ? $_SERVER['time_fmt'] : '';?>, 耗时:<?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>s
				
			</td>
		</tr>
	</table>
	
</div>

<?php if(DEBUG == 1 && $_user['groupid'] == 1 || DEBUG == 2) { ?>

<div class="box">
<h3>Debug Information: </h3>
<pre>

<b>Memory</b> = <?php echo memory_get_usage();?>

<b>Processtime</b> = <?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>

<b>REQUEST_URI:</b> = <a href="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?>" target="_blank" style="color: #888888"><?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?></a>

<b>_GET</b> = <?php echo htmlspecialchars(print_r($_GET, 1));?>

<b>_POST</b> = <?php echo htmlspecialchars(print_r($_POST, 1));?>

<b>_COOKIE</b> = <?php echo htmlspecialchars(print_r($_COOKIE, 1));?>

<b>SQL:</b> = <?php isset($_SERVER['sqls']) && print_r($_SERVER['sqls']);?>

<?php if(DEBUG == 2) { ?>
<b>time:</b> = <?php echo isset($_SERVER['time']) ? $_SERVER['time'] : '';?><br />
<b>_user</b> = <?php print_r($_user);?>
<b>conf</b> = <?php unset($conf['db'], $conf['cache']);print_r($conf);?>
<?php } ?>

<b>include:</b> = <?php print_r(get_included_files());?>

</pre>
	
</div>

<?php } ?>

<?php if(DEBUG) { ?>
<script src="http://localhost/myxiuno/view/js/jquery-1.4.full.js" type="text/javascript" ></script>
<?php } else { ?>
<script src="http://localhost/myxiuno/view/js/jquery-1.4.min.js" type="text/javascript" ></script>
<?php } ?>

<script src="http://localhost/myxiuno/view/js/common.js" type="text/javascript"></script>

<script src="http://localhost/myxiuno/view/js/dialog.js" type="text/javascript"></script>

<script type="text/javascript">

$('#search input').focus(function() {$('#search').addClass('hover');});
$('#search input').blur(function() {$('#search').removeClass('hover');});
$('#search input').keyup(function(e) {
	if(e.which == 13 || e.which == 10) {
		var val = encodeURIComponent($(this).val());
		$('#search_form').attr('action', 'http://localhost/myxiuno/?search-index-keyword-'+val+'.htm');
		$('#search_form').submit();
		return false;
	}
});

// 登陆后才能发帖
$('#create_thread').click(function() {
	if(g_uid == 0) {
		ajaxdialog_request('http://localhost/myxiuno/?user-login.htm', function() {
			$('#create_thread').unbind('click');
			ajaxdialog_request($('#create_thread').attr('href'));
			$('#create_thread').click(function() {
				ajaxdialog_request($('#create_thread').attr('href'));
			});
		}, {fullicon: 1});
		return false;
	} else {
		ajaxdialog_request($('#create_thread').attr('href'), null);
		return false;
	}
});

$('a.ajaxdialog, input.ajaxdialog').die('click').live('click', ajaxdialog_click);
$('a.ajaxtoggle').die('click').live('click', ajaxtoggle_event);

//$('div.list .table tr:odd').not('tr.header').addClass('odd');	/* 奇数行的背景色 */
//$('div.list .table tr:last').addClass('last');	/* 奇数行的背景色 */

<?php if($_user['uid']) { ?>
// ------------------------> 短消息 start
	
	function userlist_to_html(userlist) {
		var s = '<div id="pm_userlist">';
		for(k in userlist) {
			var user = userlist[k];
			s += '<a href="http://localhost/myxiuno/?pm-ajaxlist-uid-'+user.uid+'-ajax-1.htm" uid="'+user.uid+'" class="ajaxdialog" ajaxdialog="{position: \'center\', modal: false, cache: false}"><span class="avatar_small" style="'+(user.avatar_small ? 'background-image: url('+user.avatar_small+')' : '')+'"></span> '+user.username+' (<b class="red">'+user.newpms+'</b>)</a>';
		}
		s += '</div>';
		return s;
	}
	
	// 如果有新短消息，除了全局提示以外，再做一个全局标记，实现模拟即时聊天。
	var g_newpm_userlist = null;	// 全局变量
	
	// 心跳频率  根据负载来调整，如果PV <10W: 1秒, <100w 2秒, <600w 3秒, 600w+, 5秒
	var g_newpm_delay = <?php echo isset($pm_delay) ? $pm_delay : '';?>;
	
	function newpm() {
		var _this = this;
		_this.delay = g_newpm_delay;
		_this.t = null;
		_this.stop = function() {
			if(_this.t) clearTimeout(_this.t);
		};
		_this.run = function() {
			_this.stop();
			_this.t = setTimeout(function() {
				//print_r('http://localhost/myxiuno/?pm-new-ajax-1.htm');
				$.get('http://localhost/myxiuno/?pm-new-ajax-1.htm', function(s) {
					var json = json_decode(s);
					if(error = json_error(json)) {return false;}
					// alert(error);
					
					if(json.status == 1) {
						

						
						var userlist = json.message;
						g_newpm_userlist = userlist;
						var s = userlist_to_html(userlist);
						$('#pm a.pm').hide();
						$('#pm a.newpm').show().unbind('mouseover').mouseover(function() {
							$('#pm a.newpm').alert(s, {"width": 150, "pos": 7, "delay": 1000, "alerticon": 0});
						});
						_this.delay = g_newpm_delay;
						_this.run();
					} else if(json.status == 2) {
						g_newpm_userlist = null;
						_this.delay = _this.delay * 2;
						_this.run();
					} else if(json.status == -1) {
						// 退出登录，什么都不做
					} else {
						// 发生错误，不提示，否则太频繁，影响用户体验。可以在后台查看PHP错误日志
						// alert(json.message);
					}
				});
			}, _this.delay);
		};
		return this;
	}
	
	
	var newpm_instance = new newpm(); 
	newpm_instance.run();
	
	<?php if(DEBUG == 2) { ?>
	//newpm_instance.stop();
	<?php } ?>
	// ----------------> 短消息 end
	
	// 鼠标放在上面，显示最后联系的5个人。

<?php } ?>

</script>

<?php echo isset($conf['footer_js']) ? $conf['footer_js'] : '';?>

<script type="text/javascript" src="plugin/fspk_retop/retop.js"></script>

<script type="text/javascript">
$('#my_password_submit').click(function() {
	$('#my_password_form').submit();
	return false;
});

<?php if(!empty($error)) { foreach($error as $k=>&$v) {?>
<?php if($v) { ?>
	$('#<?php echo isset($k) ? $k : '';?>').alert('<?php echo isset($v) ? $v : '';?>');
<?php } ?>
<?php }}?>

<?php if(!empty($_POST) && empty($error)) { ?>
	$('#notice').html('修改密码成功。').show();
<?php } ?>
</script>



</body>
</html>