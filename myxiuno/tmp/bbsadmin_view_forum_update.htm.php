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
<style type="text/css">
dt{width: 15%;}
dd{width: 84%;}
</style>
<div class="width">
	<form action="http://localhost/myxiuno/admin/?forum-update-fid-<?php echo isset($forum['fid']) ? $forum['fid'] : '';?>.htm" method="post" id="forum_update_form">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		
		<div class="div" style="width: 700px;">
			<div class="header">编辑版块 - <?php echo isset($forum['name']) ? $forum['name'] : '';?></div>
			<div class="body">
				<dl class="dl28">
					
					<dt><label for="name">名称：</label></dt>
					<dd><input type="text" name="name" id="name" value="<?php echo isset($forum['name']) ? $forum['name'] : '';?>" style="width: 150px" /> <a href="../?forum-index-fid-<?php echo isset($forum['fid']) ? $forum['fid'] : '';?>.htm" target="_blank">点击访问</a></dd>
					
					<dt><label for="rank">排序：</label></dt>
					<dd><input type="text" name="rank" id="rank" value="<?php echo isset($forum['rank']) ? $forum['rank'] : '';?>" style="width: 30px" /> <span class="grey">0-255, 正序</span></dd>
					
					<div style="clear: both; overflow: hidden;">
						<dt><label for="brief">版块简介：</label></dt>
						<dd><textarea name="brief" id="brief" style="width: 400px; height: 40px; font-size: 12px;"><?php echo isset($forum['brief']) ? $forum['brief'] : '';?></textarea></dd>
					</div>

					
					
					<div style="clear: both; overflow: hidden;">
						<dt><label for="orderby">主题排序方式：</label></dt>
						<dd>
							<?php echo isset($input['orderby']) ? $input['orderby'] : '';?>
						</dd>
					</div>
					
					<dt><label for="recentthreads">版主：</label></dt>
					<dd>
						<input type="text" name="modnames" id="modnames" value="<?php echo isset($forum['modnames']) ? $forum['modnames'] : '';?>" style="width: 200px" />
						<span class="grey">最多 6 个，用户名空格隔开；</span>
					</dd>
					
					<dt><label for="seo_title">SEO 标题：</label></dt>
					<dd><input type="text" name="seo_title" id="seo_title" value="<?php echo isset($forum['seo_title']) ? $forum['seo_title'] : '';?>" style="width: 200px" /> <span class="grey">搜索引擎优化</span></dd>
					
					<dt><label for="seo_keywords">SEO 关键词：</label></dt>
					<dd><input type="text" name="seo_keywords" id="seo_keywords" value="<?php echo isset($forum['seo_keywords']) ? $forum['seo_keywords'] : '';?>" style="width: 200px" /> <span class="grey">搜索引擎优化，可以填写多个关键词</span></dd>
					
					
					
					<dt>设置主题分类：</dt>
					<dd class="grey">
						<?php if($forum['typelist']) { ?>
							<input type="checkbox" name="typeon" id="typeon" value="1" checked="checked"/>
						<?php } else { ?>
							<input type="checkbox" name="typeon" id="typeon" value="1" />
						<?php } ?>
						<br />
						<div id="typeon_div" <?php if(empty($forum['typelist'])) { ?> style="display: none;" <?php } ?>>
							<?php if(!empty($forum['typelist'])) { foreach($forum['typelist'] as $typecateid=>&$typelist) {?>
							<div class="div">
								<div class="header">
									大分类名称：<input type="text" name="typecatename[<?php echo isset($typecateid) ? $typecateid : '';?>]" value="<?php echo isset($forum["typecatelist"]["$typecateid"]["catename"]) ? $forum["typecatelist"]["$typecateid"]["catename"] : '';?>" size="8" />
									顺序：<input type="text" name="typecaterank[<?php echo isset($typecateid) ? $typecateid : '';?>]" value="<?php echo isset($forum["typecatelist"]["$typecateid"]["rank"]) ? $forum["typecatelist"]["$typecateid"]["rank"] : '';?>" size="4" />
									启用：<input type="checkbox" name="typecateenable[<?php echo isset($typecateid) ? $typecateid : '';?>]" value="1" <?php if($forum["typecatelist"]["$typecateid"]["enable"]) { ?>checked="checked"<?php } ?> />
									版主权限：<input type="checkbox" name="typecatemod[<?php echo isset($typecateid) ? $typecateid : '';?>]" value="1" <?php if($forum["typecatelist"]["$typecateid"]["enable"] & 2) { ?>checked="checked"<?php } ?> title="开启版主权限以后，只有版主才能管理此分类" />
								</div>
								<div class="body">
									<table width="200">
										<tr>
											<td width="60">小分类名称</td>
											<td width="60">顺序</td>
											<td width="30" align="center">启用</td>
										</tr>
										<?php if(!empty($typelist)) { foreach($typelist as $typeid=>&$type) {?>
										<tr <?php if(empty($type['typename'])) { ?> style="display: none;"<?php } ?> typeid="<?php echo isset($type['typeid']) ? $type['typeid'] : '';?>" typename="<?php echo isset($type['typename']) ? $type['typename'] : '';?>">
											<td><input type="text" name="typename[<?php echo isset($type['typeid']) ? $type['typeid'] : '';?>]" value="<?php echo isset($type['typename']) ? $type['typename'] : '';?>" size="8" /></td>
											<td><input type="text" name="typerank[<?php echo isset($type['typeid']) ? $type['typeid'] : '';?>]" value="<?php echo isset($type['rank']) ? $type['rank'] : '';?>" size="4" /></td>
											<td><input type="checkbox" name="typeenable[<?php echo isset($type['typeid']) ? $type['typeid'] : '';?>]" value="1" <?php if($type['enable']) { ?>checked="checked"<?php } ?> /></td>
										</tr>
										<?php }}?>
										<tr>
											<td colspan="3"><a href="javascript: void(0)" class="addtype">[+]增加</a></td>
										</tr>
									</table>
								</div>
							</div>
							<?php }}?>
						</div>
					</dd>
					
					<dt><label for="accesson">开启权限限制：</label></dt>
					<dd>
						<input type="checkbox" name="accesson" id="accesson" value="1" <?php if($forum['accesson']) { ?>checked="checked"<?php } ?> />
						<span class="grey">不利于缓存，不利于SEO。</span>
						<div class="list" id="accesstable" style="width: 580px; <?php if(!$forum['accesson']) { ?>display: none;<?php } ?>">
							<table class="table">
								<tr class="header">
									<td>用户组</td>
									<td width="80"><input type="checkbox" id="checkread" />访问</td>
									<td width="80"><input type="checkbox" id="checkpost" />回帖</td>
									<td width="80"><input type="checkbox" id="checkthread" />发主题</td>
									<td width="80"><input type="checkbox" id="checkattach" />上传</td>
									<td width="80"><input type="checkbox" id="checkdown" />下载</td>
								</tr>
								<?php if(!empty($grouplist)) { foreach($grouplist as &$group) {?>
								<?php if($group['groupid'] == 11) { ?>
								<tr>
									<td colspan="6">&nbsp;</td>
								</tr>
								<?php } ?>
								<tr align="center">
									<td align="right"><?php echo isset($group['name']) ? $group['name'] : '';?> <input type="hidden" name="groupids[]" value="<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>"></td>
									<td><input type="checkbox" name="allowread[<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>]" value="1" <?php if(isset($accesslist[$group['groupid']]) && $accesslist[$group['groupid']]['allowread']) { ?>checked="checked"<?php } ?> /></td>
									<td><input type="checkbox" name="allowpost[<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>]" value="1" <?php if(isset($accesslist[$group['groupid']]) && $accesslist[$group['groupid']]['allowpost']) { ?>checked="checked"<?php } ?> /></td>
									<td><input type="checkbox" name="allowthread[<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>]" value="1" <?php if(isset($accesslist[$group['groupid']]) && $accesslist[$group['groupid']]['allowthread']) { ?>checked="checked"<?php } ?> /></td>
									<td><input type="checkbox" name="allowattach[<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>]" value="1" <?php if(isset($accesslist[$group['groupid']]) && $accesslist[$group['groupid']]['allowattach']) { ?>checked="checked"<?php } ?> /></td>
									<td><input type="checkbox" name="allowdown[<?php echo isset($group['groupid']) ? $group['groupid'] : '';?>]" value="1" <?php if(isset($accesslist[$group['groupid']]) && $accesslist[$group['groupid']]['allowdown']) { ?>checked="checked"<?php } ?> /></td>
								</tr>
								
								<?php if($group['groupid'] == 0) { ?>
								<tr>
									<td colspan="6">&nbsp;</td>
								</tr>
								<?php } ?>
								<?php }} ?>
							</table>
						</div>
					</dd>
					
					
					
					<dt></dt>
					<dd>
						<a type="submit" class="button bigblue" id="forum_update_submit" value="编辑版块" href="javascript:void(0)" role="button"><span>编辑版块</span></a>
						<a type="button" class="button biggrey" value="返回" onclick="history.back();return false;" href="javascript:void(0)" role="button"><span>返回</span></a>
						<div class="notice" id="notice" style="display: none;"></div>
					</dd>
				</dl>
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
$('#forum_update_submit').click(function() {
	/*$('#accesstable input[type=checkbox]').each(function() {
		this.value = this.checked ? 1 : 0;
	});*/
	$('#forum_update_form').submit();
	return false;
});

$('#accesson').click(function() {
	if($(this).attr('checked')) {
		$('#accesstable').show();
	} else {
		$('#accesstable').hide();
	}
});

$('#checkread').click(function() {
	$('#accesstable input[name^=allowread]').attr('checked', $(this).attr('checked'));
});
$('#checkpost').click(function() {
	$('#accesstable input[name^=allowpost]').attr('checked', $(this).attr('checked'));
});
$('#checkthread').click(function() {
	$('#accesstable input[name^=allowthread]').attr('checked', $(this).attr('checked'));
});
$('#checkattach').click(function() {
	$('#accesstable input[name^=allowattach]').attr('checked', $(this).attr('checked'));
});
$('#checkdown').click(function() {
	$('#accesstable input[name^=allowdown]').attr('checked', $(this).attr('checked'));
});

<?php if(!empty($error)) { foreach($error as $k=>&$v) {?>
<?php if($v) { ?>
	$('#<?php echo isset($k) ? $k : '';?>').alert('<?php echo isset($v) ? $v : '';?>');
<?php } ?>
<?php }}?>

<?php if(!empty($_POST)) { ?>
<?php if(empty($error)) { ?>
	$('#notice').html('编辑成功！').show();
<?php } else { ?>
	$('#notice').html('编辑失败！').show();
<?php } ?>
<?php } ?>

// 主题分类
$('a.addtype').click(function() {
	var find = 0;
	var jtable = $(this).closest('table');
	$('tr', jtable).each(function() {
		var typeid = $(this).attr('typeid');
		var typename = $(this).attr('typename');
		if(!typeid) return;
		if(find) return;
		if($(this).css('display') == 'none') {
			$(this).show();
			find = 1;
		}
	})
	if(!find) {
		alert('每个大分类下只能有40个个小主题分类。');
	}
});

$('#typeon').click(function() {
	if(!$(this).attr('checked')) {
		$('#typeon_div').hide();
	} else {
		$('#typeon_div').show();
	}
	return true;
});

</script>

</body>
</html>