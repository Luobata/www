<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Admin Control Pannel</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<frameset rows="35,*" frameborder="1" border="1" framespacing="0">
	<frame name="top" scrolling="no" src="http://localhost/myxiuno/admin/?index-top.htm" frameborder="1" border="1" />
	<frameset cols="160,*" frameborder="0" border="0" framespacing="0">
		<frame name="frame_menu" scrolling="no" src="http://localhost/myxiuno/admin/?index-menu.htm" frameborder="0" border="1"/>
		<frame name="main" scrolling="yes" src="http://localhost/myxiuno/admin/?index-main.htm" frameborder="0" border="0" />
	</frameset>
</frameset>

<noframes>not support frameset</noframes>

</html>
