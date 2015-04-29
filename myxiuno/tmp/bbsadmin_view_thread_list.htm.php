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
	<form action="http://localhost/myxiuno/admin/?thread-list.htm" method="post" id="srchform">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		<input type="hidden" name="srchstring" value="<?php echo isset($srchstring) ? $srchstring : '';?>" />
		<input type="hidden" name="replacestring" value="<?php echo isset($replacestring) ? $replacestring : '';?>" />
		<div class="div" style="width: 780px; margin: 0px;">
			<div class="header">搜索帖子</div>
			<div class="body">
				<dt>关键词：</dt>
				<dd>
					<input type="text" name="keyword" value="<?php echo isset($keyword) ? $keyword : '';?>" size="32" />
				</dd>
				<dt>UID/用户名/Email：</dt>
				<dd>
					<input type="text" name="uid" value="<?php echo isset($uid) ? $uid : '';?>" size="32" />
				</dd>
				<dt>TID 范围：</dt>
				<dd>
					<input type="text" name="tidfrom" value="<?php echo isset($tidfrom) ? $tidfrom : '';?>" size="8" /> - 
					<input type="text" name="tidto" value="<?php echo isset($tidto) ? $tidto : '';?>" size="8" /> (起始/结束值) 
					<br /><span class="grey">每次列出200个结果集，如果结果集很大，请注意调整TID范围，进行多次操作。</span>
				</dd>
				<dt></dt>
				<dd>
					<a type="submit" value=" 查找主题 " class="button bigblue" id="srchubmit" href="javascript:void(0)" role="button"><span> 查找主题 </span></a>
				</dd>
			</div>
		</div>
	</form>
	
	<!-- 搜索结果 -->
	
<?php if($threadlist) { ?>
	<form action="http://localhost/myxiuno/admin/?thread-replace.htm" method="post" id="resultform">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		<input type="hidden" name="uid" value="<?php echo isset($uid) ? $uid : '';?>" />
		<input type="hidden" name="tidfrom" value="<?php echo isset($tidfrom) ? $tidfrom : '';?>" />
		<input type="hidden" name="tidto" value="<?php echo isset($tidto) ? $tidto : '';?>" />
		<div class="list" style="width: 780px; margin-top: 16px;">
			<table class="table">
				<tr class="header">
					<td width="50"><input type="checkbox" value="1" title="全选" id="checkall" checked="checked" /></td>
					<td width="100">版块</td>
					<td>标题</td>
					<td width="50">作者</td>
					<td width="50">时间</td>
				</tr>
				<?php if(!empty($threadlist)) { foreach($threadlist as &$thread) {?>
				<tr>
					<td><input type="checkbox" name="fidtids[]" value="<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>_<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>" checked="checked" /></td>
					<td><a href="../?forum-index-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>.htm" target="_blank"><?php echo isset($thread['forumname']) ? $thread['forumname'] : '';?></a></td>
					<td><a href="../?thread-index-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>-tid-<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>.htm" target="_blank"><?php echo isset($thread['subject']) ? $thread['subject'] : '';?></a></td>
					<td><?php echo isset($thread['username']) ? $thread['username'] : '';?></td>
					<td><?php echo isset($thread['dateline']) ? $thread['dateline'] : '';?></td>
				</tr>
				<?php }} ?>
			</table>
		</div>
		<div style="width: 780px; margin-top: 0px; text-align: center;">
			<div style="text-align: left;"> &nbsp;<input type="checkbox" value="1" title="全选" id="checkall2" checked="checked" /> 全选</div>
			<p>
				<a type="submit" value=" 批量删除 " class="button bigblue" id="mdelete" href="javascript:void(0)" role="button"><span> 批量删除 </span></a> &nbsp; &nbsp;
				查找字符：<input type="text" name="srchstring" value="<?php echo isset($srchstring) ? $srchstring : '';?>" size="16" />
				替换为：<input type="text" name="replacestring" value="<?php echo isset($replacestring) ? $replacestring : '';?>" size="16" />
				<a type="submit" value=" 批量替换 " class="button bigblue" id="mreplace" href="javascript:void(0)" role="button"><span> 批量替换 </span></a>
			</p>
		</div>
	</form>
<?php } else { ?>
<?php } ?>
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
$('#srchubmit').click(function() {
	$('#srchform').submit();
	return false;
});
$('#checkall, #checkall2').click(function() {
	$('#resultform input[name="fidtids[]"]').attr('checked', this.checked);
});
$('#mdelete').click(function() {
	$('#resultform').attr('action', 'http://localhost/myxiuno/admin/?thread-delete.htm');
	$('#resultform').submit();
	return false;
});

$('#mreplace').click(function() {
	$('#resultform').attr('action', 'http://localhost/myxiuno/admin/?thread-replace.htm');
	$('#resultform').submit();
	return false;
});
</script>
</body>
</html>