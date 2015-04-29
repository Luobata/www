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

<div class="width">
	<form action="http://localhost/myxiuno/admin/?user-list-page-<?php echo isset($page) ? $page : '';?>.htm" method="post" id="userform">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		<div style="width: 780px; margin: auto;">
			<h2>
				<form action="http://localhost/myxiuno/admin/?user-list.htm" method="post">
					<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
					搜索用户：<input type="text" name="keyword" value="<?php echo isset($keyword) ? $keyword : '';?>" size="16" /> <input type="submit" name="srchsubmit" id="srchsubmit" value="搜索" />
				</form>
			</h2>
			<div class="list">
				<table class="table">
					<tr class="header">
						<td width="130">用户名</td>
						<td width="150">Email</td>
						<td width="100">用户组</td>
						<td width="100">注册时间</td>
						<td width="100">注册IP</td>
						<td width="100">操作</td>
					</tr>
					<?php if(!empty($userlist)) { foreach($userlist as &$user) {?>
					<tr>
						<td><a href="../?you-index-uid-<?php echo isset($user['uid']) ? $user['uid'] : '';?>.htm"><?php echo isset($user['username']) ? $user['username'] : '';?></a></td>
						<td><?php echo isset($user['email']) ? $user['email'] : '';?></td>
						<td><?php echo isset($user['groupname']) ? $user['groupname'] : '';?></td>
						<td><?php echo isset($user['regdate_fmt']) ? $user['regdate_fmt'] : '';?></td>
						<td><?php echo isset($user['regip']) ? $user['regip'] : '';?></td>
						<td>
							<a type="button" value="编辑" class="button smallblue" onclick="window.location='http://localhost/myxiuno/admin/?user-update-uid-<?php echo isset($user['uid']) ? $user['uid'] : '';?>.htm';return false;" href="javascript:void(0)" role="button"><span>编辑</span></a>
						 </td>
					</tr>
					<?php }} ?>
				</table>
			</div>
			<div>
				<?php if($pages) { ?><div class="page" style="text-align: center;"><?php echo isset($pages) ? $pages : '';?></div><?php } ?>
			</div>
		</div>
	</form>
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

<script type="text/javascript">
$('#checkall').click(function() {
	$('#userform input[name="uids[]"]').attr('checked', this.checked);
});
</script>
</body>
</html>