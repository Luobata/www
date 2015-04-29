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

	<div style="width: 700px; margin: auto;">
		<h1><?php echo isset($conf['app_name']) ? $conf['app_name'] : '';?> 管理系统</h1>
		<div class="div">
			<div class="header"> 当前环境信息 </div>
			<div class="body">
				<dl>
					<dt>OS: </dt><dd> <?php echo PHP_OS;?></dd>
					<dt>Web Server: </dt><dd> <?php echo isset($info['SERVER_SOFTWARE']) ? $info['SERVER_SOFTWARE'] : '';?></dd>
					<dt>PHP: </dt><dd> <?php echo PHP_VERSION;?> (<a href="http://localhost/myxiuno/admin/?index-phpinfo.htm">查看PHP.ini</a>)</dd>
					<dt>DB: </dt><dd> <?php echo isset($conf['db']['type']) ? $conf['db']['type'] : '';?> (<?php echo isset($info['dbversion']) ? $info['dbversion'] : '';?>)</dd>
					<dt>disable_functions: </dt><dd style="white-space: normal; word-break: break-word;"><?php echo isset($info['disable_functions']) ? $info['disable_functions'] : '';?> exec,system,passthru,shell_exec,system,cmd,popen,dl,proc_open,curl_execexec,system,passthru,shell_exec,system,cmd,popen,dl,proc_open,curl_execexec,system,passthru,shell_exec,system,cmd,popen,dl,proc_open,curl_execexec,system,passthru,shell_exec,system,cmd,popen,dl,proc_open,curl_exec<br /> 
						<br /><span class="grey" style="white-space: normal; word-break:break-word;">建议禁用如下函数：<br />passthru,exec,system,chroot,scandir,chgrp,chown,shell_exec,proc_open,proc_get_status,ini_alter,ini_alter,ini_restore,dl,pfsockopen,openlog,syslog,readlink,symlink,popepassthru,stream_socket_server</span></dd>
					<dt>upload_max_filesize: </dt><dd><?php echo isset($info['upload_max_filesize']) ? $info['upload_max_filesize'] : '';?></dd>
					<dt>post_max_size: </dt><dd><?php echo isset($info['post_max_size']) ? $info['post_max_size'] : '';?></dd>
					<dt>allow_url_fopen: </dt><dd><?php echo isset($info['allow_url_fopen']) ? $info['allow_url_fopen'] : '';?> <span class="grey">(建议不要开启，某些主机会导致CPU 100%，并且导致不安全)</span></dd>
					<dt>safe_mode: </dt><dd><?php echo isset($info['safe_mode']) ? $info['safe_mode'] : '';?> <span class="grey">(建议开启)</span></dd>
					<dt>max_execution_time: </dt><dd><?php echo isset($info['max_execution_time']) ? $info['max_execution_time'] : '';?> <span class="grey">(建议为10秒)</span></dd>
					<dt>memory_limit: </dt><dd><?php echo isset($info['memory_limit']) ? $info['memory_limit'] : '';?> <span class="grey">(建议为10M)</span></dd>
					<dt>客户端IP: </dt><dd>REMOTE_ADDR: <?php echo isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';?>, HTTP_X_FORWARDED_FOR: <?php echo isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';?>, ip: <?php echo isset($_SERVER['ip']) ? $_SERVER['ip'] : '';?></dd>
					<dt>服务端IP: </dt><dd><?php echo isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';?></dd>
				</dl>
			</div>
		</div>
		
		<div class="div">
			<div class="header"> 潜在错误检查： </div>
			<div class="body">
				<dl>
					<dt>上传目录可写检测: </dt><dd> <?php echo isset($check['upload_path_check']) ? $check['upload_path_check'] : '';?></dd>
				</dl>
			</div>
		</div>
		
		<div class="div">
			<div class="header"> 站点统计信息 </div>
			<div class="body">
				<dl>
					<dt>主题总数: </dt><dd> <?php echo isset($stat['threads']) ? $stat['threads'] : '';?></dd>
					<dt>帖子总数: </dt><dd> <?php echo isset($stat['posts']) ? $stat['posts'] : '';?></dd>
					<dt>会员总数: </dt><dd> <?php echo isset($stat['users']) ? $stat['users'] : '';?></dd>
					<dt>附件总数: </dt><dd> <?php echo isset($stat['attachs']) ? $stat['attachs'] : '';?></dd>
					<dt>磁盘剩余空间: </dt><dd> <?php echo isset($stat['disk_free_space']) ? $stat['disk_free_space'] : '';?></dd>
				</dl>
			</div>
		</div>
		
		<div class="div" style="display: none;">
			<div class="header"> 资源状况 </div>
			<div class="body">
				<dl>
					<dt>带宽: </dt><dd>100M</dd>
					<dt>Ping: </dt><dd>10ms</dd>
					<dt>CPU: </dt><dd>8颗, 2.x</dd>
					<dt>CPU使用率: </dt><dd>30%</dd>
					<dt>loadavg: </dt><dd>2.0</dd>
					<dt>内存: </dt><dd>4G/16G</dd>
					<dt>磁盘空间: </dt><dd>30G/100G RAID1</dd>
					<dt>磁盘IO负载: </dt><dd>100k/s</dd>
					<dt>网卡每秒流量: </dt><dd>总：110k/s, 读:100k/s 写：10k/s</dd>
					<dt>网络连接数: </dt><dd>8000</dd>
					<dt>开启的端口: </dt><dd>21, 22, 80</dd>
				</dl>
			</div>
		</div>
		
		<div class="div">
			<div class="header"> 开发信息 </div>
			<div class="body">
				<dl>
					<dt>开发者: </dt><dd> axiuno#gmail.com</dd>
					<dt>官方站点: </dt><dd> <a href="http://www.xiuno.com" target="_blank">http://www.xiuno.com/</a></dd>
					<dt>感谢: </dt><dd>所有曾经帮助过我的人！</dd>
				</dl>
			</div>
		</div>
		
		
	</div>

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

<?php echo isset($lastversion) ? $lastversion : '';?>

</body>
</html>