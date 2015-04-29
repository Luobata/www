<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!DOCTYPE html>
<head>   
	<title><?php if(!empty($_title)) { foreach($_title as &$title) {?><?php echo isset($title) ? $title : '';?><?php }} ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<link href="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/common.css" type="text/css" rel="stylesheet" />
	<style>
		#body {margin: 0px;}
		/* accordion 仅后台使用 */
		#accordion h3, #accordion ul {padding:0px;margin:0px;}
		#accordion h3 {font-size:12px; color:#FFFFFF; line-height: 20px; height: 20px; text-indent: 4px; padding:0px; cursor:pointer; background:url('../view/image/page.gif') repeat-x;}
		#accordion h3 a {color:#FFFFFF;}
		#accordion ul {padding-bottom:2px; border-left:1px #CCCCCC solid; border-right:1px #CCCCCC solid;}
		#accordion li {font-size:12px; padding-left:10px; list-style-type:none; background-color:#FFFFFF; line-height:1.8;}
		.width {width: 800px; margin: auto; overflow: hidden;}
	</style>
	<script type="text/javascript">
	var cookie_pre = '<?php echo isset($conf['cookie_pre']) ? $conf['cookie_pre'] : '';?>';
	</script>
</head>
<body>
<div id="body">
<style>
#body {padding: 0px;}
#menu td.center a {padding-left: 20px; padding-right: 20px;}
</style>
<div id="menu">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="left" valign="top" style="width: 88px; height: 35px; overflow: hidden;"><a href="../" target="_blank"><span id="logo"></span></a></td>
			<td class="center" style="text-align: left;" id="topmenu">
				<span class="sep"></span>
				<?php if($_group['groupid'] == 1) { ?>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-conf.htm" target="frame_menu" class="a_conf">设置</a>				<span class="sep"></span>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-forum.htm" target="frame_menu" class="a_forum">版块</a>			<span class="sep"></span>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-post.htm" target="frame_menu" class="a_post">帖子</a>				<span class="sep"></span>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-user.htm" target="frame_menu" class="a_user">用户</a>				<span class="sep"></span>
	<?php if(!IN_SAE) { ?>	<a href="http://localhost/myxiuno/admin/?index-menu-type-log.htm" target="frame_menu" class="a_log">日志</a>				<span class="sep"></span>	<?php } ?>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-other.htm" target="frame_menu" class="a_other">其他</a>			<span class="sep"></span>
				<?php } ?>
				<?php if($_group['groupid'] > 0 && $_group['groupid'] < 6) { ?>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-mod.htm" target="frame_menu" class="a_mod">版主管理</a>			<span class="sep"></span>
				<?php } ?>
				<?php if($_group['groupid'] == 1) { ?>
				<a href="http://localhost/myxiuno/admin/?index-menu-type-plugin.htm" target="frame_menu" class="a_plugin">插件</a>			<span class="sep"></span>
				<?php } ?>
				
				
				
				
			</td>
			<td class="right" width="160">
				<span id="user" style="margin-top: 8px; padding-right: 8px;">
				<?php echo isset($_user['username']) ? $_user['username'] : '';?> (<?php echo isset($_group['name']) ? $_group['name'] : '';?>), <a href="http://localhost/myxiuno/admin/?index-logout.htm" target="_top">退出</a></span>
			</td>
		</tr>
	</table>
</div>

</div>
<div id="footer">

	<div style="height: 35px; padding: 8px;">
		<div style="width: 40%; float: left;">
			<?php echo isset($conf['app_copyright']) ? $conf['app_copyright'] : '';?><br />
			Powered by  <a href="http://www.xiuno.com" target="_blank" class="grey">Xiuno BBS <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></a>
		</div>
		<div style="width: 60%; float: right; text-align: right;">
			<?php echo isset($conf['china_icp']) ? $conf['china_icp'] : '';?><br />
			<?php echo isset($_SERVER['time_fmt']) ? $_SERVER['time_fmt'] : '';?>, 耗时:<?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>s
		</div>
	</div>

	<?php if(DEBUG) { ?>

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

<b>_user</b> = <?php print_r($_user);?>

<b>include:</b> = <?php print_r(get_included_files());?>

</pre>
	
</div>

<?php } ?>
</div>

<?php if(DEBUG) { ?>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/jquery-1.4.full.js" type="text/javascript" ></script>
<?php } else { ?>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/jquery-1.4.min.js" type="text/javascript" ></script>
<?php } ?>

<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/dialog.js" type="text/javascript"></script>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/common.js" type="text/javascript"></script>

<script type="text/javascript">

$('a.ajaxdialog, input.ajaxdialog').die('click').live('click', ajaxdialog_click);
$('a.ajaxtoggle').die('click').live('click', ajaxtoggle_event);

$('div.list .table tr:odd').not('tr.header').addClass('odd');	/* 奇数行的背景色 */
$('div.list .table tr:last').addClass('last');	/* 奇数行的背景色 */


</script>

<script>
$('#topmenu a').click(function() {
	$('#topmenu a').removeClass('checked');
	$(this).addClass('checked');
});
<?php if($_group['groupid'] == 1) { ?>
$('#topmenu a.a_conf').addClass('checked');
<?php } else { ?>
$('#topmenu a.a_mod').addClass('checked');
top.frame_menu.location = 'http://localhost/myxiuno/admin/?index-menu-type-mod.htm';
top.main.location = 'http://localhost/myxiuno/admin/?mod-setforum.htm';
<?php } ?>
</script>

</body>
</html>