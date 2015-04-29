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
	<form action="http://localhost/myxiuno/admin/?conf-base.htm" method="post" id="conf_form">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		<div class="div" style="width: 700px;">
			<div class="header">基本设置</div>
			<div class="body">
				<dl>
					<dt><label for="app_name">站点名称：</label></dt>
					<dd><?php echo isset($input['app_name']) ? $input['app_name'] : '';?></dd>
					
					<dt><label for="site_runlevel">站点访问限制：</label></dt>
					<dd><?php echo isset($input['site_runlevel']) ? $input['site_runlevel'] : '';?></dd>
					
					<dt><label for="app_copyright">公司版权信息：</label></dt>
					<dd><?php echo isset($input['app_copyright']) ? $input['app_copyright'] : '';?></dd>
					
					<dt><label for="china_icp">ICP 备案号：</label></dt>
					<dd><?php echo isset($input['china_icp']) ? $input['china_icp'] : '';?></dd>
					
					<dt><label for="footer_js">页脚代码：</label></dt>
					<dd><textarea name="footer_js" style="width: 305px; height: 80px;"><?php echo isset($kvconf['footer_js']) ? $kvconf['footer_js'] : '';?></textarea><span class="grey">可以放统计JS之类的代码</span></dd>
					
					<dt><label for="forum_index_pagesize">每页主题数：</label></dt>
					<dd><?php echo isset($input['forum_index_pagesize']) ? $input['forum_index_pagesize'] : '';?> <span class="grey">建议不要超过100。</span></dd>
					
					<dt><label for="threadlist_hotviews">热帖回复数：</label></dt>
					<dd><?php echo isset($input['threadlist_hotviews']) ? $input['threadlist_hotviews'] : '';?> <span class="grey">回帖数达到多少算热帖</span></dd>
					
					<dt><label for="post_update_expiry">多长时间后禁止编辑帖子：</label></dt>
					<dd><?php echo isset($input['post_update_expiry']) ? $input['post_update_expiry'] : '';?> 秒，<span class="grey">0为不限制，一天为 86400 秒。</span></dd>
					
					
				</dl>
			</div>
		</div>
		
		<div class="div" style="width: 700px;">
			<div class="header">SEO 相关</div>
			<div class="body">
				<p class="grey">搜索引擎优化相关，对于站点搜录很有帮助。</p>
				
				<dt><label for="seo_title">SEO title：</label></dt>
				<dd><?php echo isset($input['seo_title']) ? $input['seo_title'] : '';?></dd>
				
				<dt><label for="seo_keywords">SEO keywords：</label></dt>
				<dd><?php echo isset($input['seo_keywords']) ? $input['seo_keywords'] : '';?> <span class="grey">建议在五个以内</span></dd>
				
				<dt><label for="seo_description">SEO description：</label></dt>
				<dd><?php echo isset($input['seo_description']) ? $input['seo_description'] : '';?></dd>
				
				
				
			</div>
		</div>	
		
		<div class="div" style="width: 700px;">
			<div class="header">注册设置</div>
			<div class="body">
				<p class="grey">开启Email验证后，注册后的初始化用户组为“待验证用户组”。</p>
				<dt><label for="reg_on">是否开启注册：</label></dt>
				<dd><?php echo isset($input['reg_on']) ? $input['reg_on'] : '';?></dd>
				
				<dt><label for="reg_email_on">是否开启 Email 注册验证：</label></dt>
				<dd><?php echo isset($input['reg_email_on']) ? $input['reg_email_on'] : '';?> <a href="http://localhost/myxiuno/admin/?conf-mail.htm" class="red">SMTP设置</a></dd>
				
				
				<dt><label for="reg_init_golds">注册送金币：</label></dt>
				<dd><?php echo isset($input['reg_init_golds']) ? $input['reg_init_golds'] : '';?> 枚</dd>
				
				
				<dt><label for="resetpw_on">是否开启密码找回：</label></dt>
				<dd><?php echo isset($input['resetpw_on']) ? $input['resetpw_on'] : '';?> (需要设置SMTP)</dd>
				
				
			</div>
		</div>	
		
		<div class="div" style="width: 700px;">
			<div class="header">积分策略</div>
			<div class="body">
				<p class="grey">积分可以影响到普通用户的用户组，不可以消费，金币可以消费，由充值金钱兑换（如果开启了支付）</p>
				
				<table width="100%">
					<tr>
						<td width="30%"></td>
						<td width="15%">积分</td>
						<td>金币</td>
					</tr>
					
					<tr>
						<td align="right">发主题：</td>
						<td><?php echo isset($input['credits_policy_thread']) ? $input['credits_policy_thread'] : '';?></td>
						<td><?php echo isset($input['golds_policy_thread']) ? $input['golds_policy_thread'] : '';?></td>
					</tr>
					
					<tr>
						<td align="right">回帖：</td>
						<td><?php echo isset($input['credits_policy_post']) ? $input['credits_policy_post'] : '';?></td>
						<td><?php echo isset($input['golds_policy_post']) ? $input['golds_policy_post'] : '';?></td>
					</tr>
					
					<tr>
						<td align="right">一级精华：</td>
						<td><?php echo isset($input['credits_policy_digest_1']) ? $input['credits_policy_digest_1'] : '';?></td>
						<td><?php echo isset($input['golds_policy_digest_1']) ? $input['golds_policy_digest_1'] : '';?></td>
					</tr>
					
					<tr>
						<td align="right">二级精华：</td>
						<td><?php echo isset($input['credits_policy_digest_2']) ? $input['credits_policy_digest_2'] : '';?></td>
						<td><?php echo isset($input['golds_policy_digest_2']) ? $input['golds_policy_digest_2'] : '';?></td>
					</tr>
					
					<tr>
						<td align="right">三级精华：</td>
						<td><?php echo isset($input['credits_policy_digest_3']) ? $input['credits_policy_digest_3'] : '';?></td>
						<td><?php echo isset($input['golds_policy_digest_3']) ? $input['golds_policy_digest_3'] : '';?></td>
					</tr>
					
					
				
				</table>
			</div>
		</div>
		
		<div class="div" style="width: 700px;">
			<div class="header">搜索设置</div>
			<div class="body">
				<p class="grey">标题搜索比较耗费资源，建议使用<a href="http://www.xiuno.com/thread-index-fid-2-tid-18.htm" target="_blank">Sphinx</a>（需要独立主机）</p>
					
				<dt><label for="search_type">搜索方法：</label></dt>
				<dd><?php echo isset($input['search_type']) ? $input['search_type'] : '';?></dd>
				
				<dt><label for="sphinx_host">Sphinx 主机：</label></dt>
				<dd><?php echo isset($input['sphinx_host']) ? $input['sphinx_host'] : '';?></dd>
				
				<dt><label for="sphinx_port">Sphinx 端口：</label></dt>
				<dd><?php echo isset($input['sphinx_port']) ? $input['sphinx_port'] : '';?></dd>
				
				<dt><label for="sphinx_datasrc">Sphinx 数据源：</label></dt>
				<dd><?php echo isset($input['sphinx_datasrc']) ? $input['sphinx_datasrc'] : '';?></dd>
				
				<dt><label for="sphinx_deltasrc">Sphinx 增量索引数据源：</label></dt>
				<dd><?php echo isset($input['sphinx_deltasrc']) ? $input['sphinx_deltasrc'] : '';?></dd>
				
				
			</div>
		</div>
		
		<div class="div" style="width: 700px;">
			<div class="header">缓存设置</div>
			<div class="body">
				
				<dt><label for="site_pv">站点近期每日PV：</label></dt>
				<dd><?php echo isset($input['site_pv']) ? $input['site_pv'] : '';?> <span class="grey">该值将影响到缓存更新的频度，对性能影响比较大。</span></dd>
				
				
			</div>
		</div>
		
		
		
		<dt></dt>
		<dd>
			<a type="submit" class="button bigblue" id="conf_submit" value="确认设置" href="javascript:void(0)" role="button"><span>确认设置</span></a>
			<a type="button" class="button biggrey" value="取消" onclick="history.back();return false;" href="javascript:void(0)" role="button"><span>取消</span></a>
			<div id="notice" class="notice" style="display: none;"></div>
		</dd>
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
$('#conf_submit').click(function() {
	$('#conf_form').submit();
	return false;
});

<?php if(!empty($error)) { foreach($error as $k=>&$v) {?>
<?php if($v) { ?>
	$('#<?php echo isset($k) ? $k : '';?>').alert('<?php echo isset($v) ? $v : '';?>');
<?php } ?>
<?php }}?>

<?php if(!empty($_POST)) { ?>
<?php if(empty($error)) { ?>
	$('#notice').html('设置成功！').show();
<?php } else { ?>
	$('#notice').html('设置失败！').show();
<?php } ?>
<?php } ?>

</script>



</body>
</html>