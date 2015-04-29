<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'C:/Users/yaogou/Documents/SoftWare/wamp/wamp/www/myxiuno/tmp/control_common_control.class.php';

class index_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->_checked['bbs'] = ' class="checked"';
		$this->_title[] = $this->conf['seo_title'] ? $this->conf['seo_title'] : $this->conf['app_name'];
		$this->_seo_keywords = $this->conf['seo_keywords'];
		$this->_seo_description = $this->conf['seo_description'];
	}
	
	// 给插件预留个位置
	public function on_index() {


		
		$this->on_bbs();
	}
	
	// 首页
	public function on_bbs() {
		$this->_checked['index'] = ' class="checked"';
		

		$friendlinklist = array();
		$friendlinklist[0] = $this->friendlink->index_fetch(array('type'=>0), array('rank'=>1), 0, 1000);
		foreach($friendlinklist[0] as &$friendlink) {
			$this->friendlink->format($friendlink);
		}
		
		$friendlinklist[1] = $this->friendlink->index_fetch(array('type'=>1), array('rank'=>1), 0, 1000);
		foreach($friendlinklist[1] as &$friendlink) {
			$this->friendlink->format($friendlink);
		}
		
		$this->view->assign('friendlinklist', $friendlinklist);	$this->thread_blog = core::model($this->conf, 'thread_blog', array('fid', 'tid'));	// 实例化thread_blog model
	$pagesize = 10;
	$toplist = array();
	$readtids = '';
	$page = misc::page();
	$start = ($page -1 ) * $pagesize;
	$threadlist = $this->thread->get_newlist($start, $pagesize);	// 最新三天数据 更多分板块看信息
	foreach($threadlist as $k=>&$thread) {
		$forum = $this->mcache->read('forum', $thread['fid']);
		$this->thread->format($thread, $forum);
		
		// 附件aid 简介
		$threadblog = $this->thread_blog->read($thread['fid'], $thread['tid']);
		if(!empty($threadblog)) {
			$thread['coverimg'] = $threadblog['coverimg'];
			$thread['brief'] = $threadblog['brief'];
		}

		$readtids .= ','.$thread['tid'];
	}
	$totalnum = $this->thread->count();
	// 翻页有可能为空 查看更多分板块
        $pages = misc::pages('http://localhost/myxiuno/?index-index.htm', $totalnum, $page, $pagesize);
        
        // 获取文章的点击量
        $readtids = substr($readtids, 1); 
	$click_server = $this->conf['click_server']."?db=tid&r=$readtids";
        
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
        
        /*  首页不显示分类信息
	// 分类信息 每个板块下 只查询一级分类   权限没有检测
	if(!empty($this->conf['forumarr'])) {
		$category = array();
		foreach($this->conf['forumarr'] as $k => $v) {
			$cate = $this->mcache->read('forum', $k);
			if(!empty($cate) && !empty($cate['types'][1])) {	// 只取一级分类
				$category[$cate['fid']] = $cate['types'][1];
			}
		}
		$typelist = array();
		foreach($category as $catekey => $cateval) {
			foreach($cateval as $typekey => $typeval) {
				$threads = $this->thread_type_count->get_threads($catekey, $typekey);
				$typelist[] = array('name' => $typeval, 'num' => $threads, 'typeid' => $typekey, 'fid' => $catekey);
			}
		}
	}
	$this->view->assign('typelist', $typelist);
	*/
	
	// XiunoBlog简介
	$xnblog = $this->kv->get('xnblog');
	if(empty($xnblog)) {
		$xnblog = array('title'=>'Xiuno Blog 简介标题', 'brief'=>'Xiuno Blog 简介内容，登录后台可修改');
	}
	$this->view->assign('setting', $xnblog);
	
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
	$pcount = $this->conf['posts'] - $this->conf['threads'];	// 评论总数 - 帖子总数 = 正常评论数
	$this->view->assign('pcount', $pcount);
	$this->view->assign('threadlist', $threadlist);
	$this->view->assign('pages', $pages);
	$this->view->assign('click_server', $click_server);
	$this->view->display('blog_list.htm');
	exit;
		
		$pagesize = 30;
		$toplist = array(); // only top 3
		$readtids = '';
		$page = misc::page();
		$start = ($page -1 ) * $pagesize;
		$threadlist = $this->thread->get_newlist($start, $pagesize);
		foreach($threadlist as $k=>&$thread) {
			$this->thread->format($thread);
			
			// 去掉没有权限访问的版块数据
			$fid = $thread['fid'];
			
			// 那就多消耗点资源吧，谁让你不听话要设置权限。
			if(!empty($this->conf['forumaccesson'][$fid])) {
				$access = $this->forum_access->read($fid, $this->_user['groupid']); // 框架内部有变量缓存，此处不会重复查表。
				if($access && !$access['allowread']) {
					unset($threadlist[$k]);
					continue;
				}
			}
			
			$readtids .= ','.$thread['tid'];
			if($thread['top'] == 3) {
				unset($threadlist[$k]);
				$toplist[] = $thread;
				continue;
			}
		}
		
		$toplist = $page == 1 ? $this->get_toplist() : array();
		$toplist = array_filter($toplist);
		foreach($toplist as $k=>&$thread) {
			$this->thread->format($thread);
                        $readtids .= ','.$thread['tid'];
                }
                
		$readtids = substr($readtids, 1); 
		$click_server = $this->conf['click_server']."?db=tid&r=$readtids";
		
		$pages = misc::simple_pages('http://localhost/myxiuno/?index-index.htm', count($threadlist), $page, $pagesize);

		// 在线会员
		$ismod = ($this->_user['groupid'] > 0 && $this->_user['groupid'] <= 4);
		$fid = 0;
		$this->view->assign('ismod', $ismod);
		$this->view->assign('fid', $fid);
		$this->view->assign('threadlist', $threadlist);
		$this->view->assign('toplist', $toplist);
		$this->view->assign('click_server', $click_server);
		$this->view->assign('pages', $pages);
		

		
		$this->view->display('index_index.htm');
	}
	
	public function on_test() {
		$this->view->display('test_drag.htm');
	}
	
	private function get_toplist($forum = array()) {
		$fidtids = array();
		// 3 级置顶
		$fidtids = $this->get_fidtids($this->conf['toptids']);
		
		// 1 级置顶
		if($forum) {
			$fidtids += $this->get_fidtids($forum['toptids']);
		}
		
		$toplist = $this->thread->mget($fidtids);
		return $toplist;
	}
	
	private function get_fidtids($s) {
		$fidtids = array();
		if($s) {
			$fidtidlist = explode(' ', trim($s));
			foreach($fidtidlist as $fidtid) {
				if(empty($fidtid)) continue;
				$arr = explode('-', $fidtid);
				list($fid, $tid) = $arr;
				$fidtids["$fid-$tid"] = array($fid, $tid);
			}
		}
		return $fidtids;
	}

}

?>