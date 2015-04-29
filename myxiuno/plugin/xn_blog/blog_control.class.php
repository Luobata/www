<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'admin/control/admin_control.class.php';

class blog_control extends admin_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->check_admin_group();
	}
	
	public function on_index() {
		$this->on_set();
	}
	
	public function on_set() {
		// 简介内容
		$brief = array();
		if($this->form_submit()) {
			$brief['title'] = core::gpc('title', 'P');
			$brief['brief'] = core::gpc('brief', 'P');
			$xnblog = $brief;
			$this->kv->set('xnblog', $xnblog);
		} else {
			$xnblog = $this->kv->get('xnblog');
		}
		$this->view->assign('setting', $xnblog);
		$this->view->display('blog_set.htm');
	}
	//hook admin_blog_control_after.php
}

?>