<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'C:/Users/yaogou/Documents/SoftWare/wamp/wamp/www/myxiuno/tmp/control_common_control.class.php';

class forum_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->_checked['bbs'] = ' class="checked"';
	}
	
	// 列表
	public function on_index() {
		

		
		// 主题分类, typeid 将决定 fid，优先级高于 fid
		$typeid1 = intval(core::gpc('typeid1'));
		$typeid2 = intval(core::gpc('typeid2'));
		$typeid3 = intval(core::gpc('typeid3'));
		$typeid4 = intval(core::gpc('typeid4'));
		$typeidsum = $typeid1 + $typeid2 + $typeid3 + $typeid4;
		
		$this->_checked['typecate'] = $this->_checked['threadtype'] = array();
		empty($typeid1) ? $this->_checked['typecates'][1] = ' class="checked"' :  $this->_checked['types'][$typeid1] = ' class="checked"';
		empty($typeid2) ? $this->_checked['typecates'][2] = ' class="checked"' :  $this->_checked['types'][$typeid2] = ' class="checked"';
		empty($typeid3) ? $this->_checked['typecates'][3] = ' class="checked"' :  $this->_checked['types'][$typeid3] = ' class="checked"';
		empty($typeid4) ? $this->_checked['typecates'][4] = ' class="checked"' :  $this->_checked['types'][$typeid4] = ' class="checked"';
		
		// fid
		$fid = intval(core::gpc('fid'));
		$forum = $this->mcache->read('forum', $fid);
		$this->check_forum_exists($forum);
		$this->check_access($forum, 'read');
		
		// digest
		$digest = misc::mid(intval(core::gpc('digest')), 0, 3);
		
		// orderby
		$orderby = core::gpc('orderby', 'C');
		$orderby = $orderby === NULL ? $forum['orderby'] : intval($orderby);
		$this->_checked['orderby'][$orderby] = ' checked';
		
		$this->_title[] = $forum['seo_title'] ? $forum['seo_title'] : $forum['name'];
		$this->_seo_keywords = $forum['seo_keywords'] ?  $forum['seo_keywords'] : $forum['name'];
		$this->_seo_description = $forum['brief'];
		

		
		$pagesize = $this->conf['forum_index_pagesize'];
		$page = misc::page();
		misc::setcookie($this->conf['cookie_pre'].'page', $page, $_SERVER['time'] + 86400 * 7, $this->conf['cookie_path'], $this->conf['cookie_domain']);


		
		$start = ($page - 1) * $pagesize;
		$limit = $pagesize;
		if($typeidsum > 0) {
			$threads = $this->thread_type_count->get_threads($fid, $typeidsum);
			$threadlist = $this->thread_type_data->get_threadlist_by_fid($fid, $typeidsum, $start, $limit);
		} else {
			$threads = $forum['threads'];
			if($digest) {
				$threadlist = $this->thread_digest->get_list_by_fid($fid, $start, $limit);
			} else {
				$threadlist = $this->thread->get_threadlist_by_fid($fid, $orderby, $start, $limit, $threads);
			}
		}
		
		$toplist = $page == 1 && empty($typeidsum) ? $this->get_toplist($forum) : array();
		$toplist = array_filter($toplist);
		$threadlist = array_diff_key($threadlist, $toplist);
		$threadlist = array_filter($threadlist);
		
		// 点击次数
		$readtids = '';
		foreach($toplist as &$thread) {
			$readtids .= ','.$thread['tid'];
			// 获取置顶版块
			$topforum = $this->mcache->read('forum', $thread['fid']);
			$this->thread->format($thread, $topforum);
		}
		foreach($threadlist as $k=>&$thread) {
			if($thread['top'] > 0 && $typeidsum == 0) {
				unset($threadlist[$k]);
				continue;
			}
			$readtids .= ','.$thread['tid'];
			$this->thread->format($thread, $forum);
		}
		$readtids = substr($readtids, 1); 
		$click_server = $this->conf['click_server']."?db=tid&r=$readtids";

		$digestadd = $digest > 0 ? "-digest-$digest" : '';
		$typeidadd = $typeidsum > 0 ? "-typeid1-$typeid1-typeid2-$typeid2-typeid3-$typeid3-typeid4-$typeid4" : '';
		if(empty($digest)) {
			$pages = misc::pages("http://localhost/myxiuno/?forum-index-fid-$fid$digestadd$typeidadd.htm", $threads, $page, $pagesize);
		} else {
			$pages = misc::simple_pages("http://localhost/myxiuno/?forum-index-fid-$fid$digestadd$typeidadd.htm", count($threadlist), $page, $pagesize);
		}
		$ismod = $this->is_mod($forum, $this->_user);
		$this->view->assign('fid', $fid);
		$this->view->assign('typeid1', $typeid1);
		$this->view->assign('typeid2', $typeid2);
		$this->view->assign('typeid3', $typeid3);
		$this->view->assign('typeid4', $typeid4);
		$this->view->assign('forum', $forum);
		$this->view->assign('page', $page);
		$this->view->assign('pages', $pages);
		$this->view->assign('limit', $limit);
		$this->view->assign('toplist', $toplist);
		$this->view->assign('threadlist', $threadlist);
		$this->view->assign('ismod', $ismod);
		$this->view->assign('orderby', $orderby);
		$this->view->assign('click_server', $click_server);
	$this->thread_blog = core::model($this->conf, 'thread_blog', array('fid', 'tid'));
	
	if(!empty($threadlist)) {
		foreach($threadlist as $k=>&$thread) {
			$forum = $this->mcache->read('forum', $thread['fid']);
			$this->thread->format($thread, $forum);
			// 查询封面 简介信息
			$threadblog = $this->thread_blog->read($thread['fid'], $thread['tid']);
			$thread['coverimg'] = $threadblog['coverimg'];
			$thread['brief'] = $threadblog['brief'];
		}
	}

	// 当前板块下 一级主题分类
	$forum = $this->mcache->read('forum', $fid);
	if(!empty($forum) && !empty($forum['types'][1])) {	// 只取一级分类
		$category = $forum['types'][1];
		$typelist = array();
		foreach($category as $catekey => $cateval) {
			$threads = $this->thread_type_count->get_threads($fid, $catekey);
			$typelist[] = array('name' => $cateval, 'num' => $threads, 'typeid' => $catekey, 'fid' => $fid);
		}
	}
	$this->view->assign('typelist', $typelist);

	// 评论总数 - 帖子总数 = 正常评论数
	$pcount = $this->conf['posts'] - $this->conf['threads'];
	$this->view->assign('pcount', $pcount);

	// 友情链接 先安装友情链接插件
        try {
        	$friendlinklist = array();
		$friendlinklist = $this->friendlink->index_fetch(array('type'=>0), array('rank'=>1), 0, 1000);
		foreach($friendlinklist as &$friendlink) {
			$this->friendlink->format($friendlink);
		}
		$this->view->assign('friendlinklist', $friendlinklist);
        } catch (Exception $e) {
        	$this->message('请安装友情链接插件。');
        }
        
        // 评论排行  取最新300条数据 按posts量排序   todo
	$postlist = $this->thread->get_newlist(0, 300);
	if($postlist) {
		foreach($postlist as $pk => $pv) {
			$posts[$pk] = $pv['posts'];	//比较大小的key
		}
		arsort($posts);				// 对数组进行逆向排序并保持索引关系   todo 如果值相同 怎么排序？
		// 排序后  根据key还原数组 
		$plist = array();
		$num = 0;		// 取前10条数据
		foreach ($posts as $postk => $postv){
			$plist[$postk] = $postlist[$postk];
			$plist[$postk]['posts'] = $plist[$postk]['posts'] -1;	// 评论减一
			$plist[$postk]['subject_substr']  = utf8::substr($plist[$postk]['subject'], 0, 15);
			$num++;
			if($num == 11) {
				break;
			}
		}
	}
	$this->view->assign('plist', $plist);	// 评论排行
	$this->view->display('blog_list.htm');
	exit;
		$this->view->display('forum_index.htm');
	}
		
	private function get_toplist($forum = array()) {
		$fidtids = array();
		// 3 级置顶
		$fidtids = $this->get_fidtids($this->conf['toptids']);
		
		// 1 级置顶
		$fidtids += $this->get_fidtids($forum['toptids']);
		$toplist = $this->thread->mget($fidtids);
		
		return $toplist;
	}
	
	// index_control.class copyed
	private function get_fidtids($s) {
		$fidtids = array();
		if($s) {
			$fidtidlist = explode(' ', trim($s));
			foreach($fidtidlist as $fidtid) {
				if(empty($fidtid)) continue;
				list($fid, $tid) = explode('-', $fidtid);
				$fidtids["$fid-$tid"] = array($fid, $tid);
			}
		}
		return $fidtids;
	}
	

}

?>