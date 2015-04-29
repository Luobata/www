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
		
		



<div class="width">
	<div class="box bg2 border shadow">
		<div style="margin: 2em; height: 300px;" id="msgbox"></div>
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
$('#msgbox').height($(window).height() -  $('#header').height() - 300 - $('#menu').height());
ajaxdialog_request('http://localhost/myxiuno/?user-login-ajax-1.htm', function() {
	window.location = '<?php echo isset($referer) ? $referer : '';?>';
});
</script>



</body>
</html>