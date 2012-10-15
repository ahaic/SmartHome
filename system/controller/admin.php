<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Base
{
	function __construct()	{
		
		self::load_config();
		self::_admin_login();
		$this->_user_level = array($this->p_lang['level_user'] => '0', $this->p_lang['level_admin'] => '1', $this->p_lang['level_compile'] => '2', $this->p_lang['level_prevent'] => '-1');	
	}
	public function index()
	{
		$this->load_php('admin/index');
	}
	
	public function plus($action = '')
	{
		if(empty($action)){
			self::_plus();
		}elseif($action == 'install'){
			self::_install();
		}elseif($action == 'uninstall'){
			self::_uninstall();
		}
	}
	
	public function menu()
	{		
		$qcms = array();
		$moduleObj = $this->load_model('Q_Module');
		$qcms['rs'] = $moduleObj->select();
		$this->load_php('admin/menu', $qcms);	
	
	}
	
	public function main()
	{
		$qcms['title'] = $this->p_lang['backend'].$this->p_lang['home'];
		$this->load_php('admin/main',$qcms);
	}
	
	public function top()
	{
		$this->load_php('admin/top');
	}
	
	public function basic()
	{	
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$l_id = empty($_GET['lang'])? 0 : $_GET['lang'];	
		$mode = '';
		switch($this->p_site['mode'])
		{
			case 1:
				$mode = $this->p_lang['rewrite'];
				break;
			case 2:
				$mode = $this->p_lang['py'].$this->p_lang['rewrite'];
				break;
			default:
				$mode = 'PHP';
		}	
		if(is_dir(LIB.'language'))
		{
			$language = opendir(LIB.'language/');						
		}
		$lang_arr = array($this->p_site['language'] => $this->p_site['language']);
		while (false !== ($file = readdir($language))) 
		{
			if($file != '.' && $file != '..' && $file != '.svn')
			{
				$name = substr($file, 0, -4);
				$lang_arr[$name] = $name;
			}
		}
		closedir($language);
		$qcms['post_arr'] = array(
			array('webname', 'input', $this->p_site['webname'], 200, $this->p_lang['webname'], '', 0),
			array('keyword', 'input', $this->p_site['keyword'], 200, $this->p_lang['keyword'], '', 0),
			array('email', 'input', $this->p_site['email'], 200, $this->p_lang['email'], '', 0),	
			array('icp', 'input', $this->p_site['icp'], 200, $this->p_lang['icp'], '', 0),
			array('count', 'text', stripslashes($this->p_site['count']), 400, $this->p_lang['count'], 50, 0),
			array('cache_time', 'input', $this->p_site['cache_time'], 200, $this->p_lang['cache'].$this->p_lang['time'], '', 0),
			array('mode', 'select', array($mode => $this->p_site['mode'], 'PHP' => 0, $this->p_lang['rewrite'] => 1, $this->p_lang['py'].$this->p_lang['rewrite'] => 2), 200, $this->p_lang['mode'], '', 0),
			array('language', 'select', $lang_arr, 200, $this->p_lang['language'], '', 0),
			array('code', 'input', $this->p_site['code'], 200, $this->p_lang['code'], '', 0),
			array('tempdir', 'input', $this->p_site['tempdir'], 200, $this->p_lang['temp'].$this->p_lang['path'], '', 0),
			array('infolen', 'input', $this->p_site['infolen'], 200, $this->p_lang['info'].$this->p_lang['length'], '', 0),
			array('shorturl', 'input', $this->p_site['shorturl'], 200, $this->p_lang['shorturl'], '', 0),
			array('veri', 'input', $this->p_site['veri'], 200, $this->p_lang['veri'], '', 0),
			array('time_zone', 'input', $this->p_site['time_zone'], 200, $this->p_lang['time_zone'], '', 0),
			array('connect', 'input', $this->p_site['connect'], 200, $this->p_lang['connect'], '', 0),
		);
		if(!empty($_POST))
		{
			$insert_arr = $this->post_verify($qcms['post_arr']);
			$result = $this->fp_write(serialize($insert_arr), LIB.'config.qcms');
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['config'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'basic')).'";');
			}
		}	
		$this->load_php('admin/basic', $qcms);
	}	
	
	public function callback($name, $method = 'index', $action = ''){
		parent::p_callback($name, $method, $action);
	}
	
	public function cache()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$cache = new Cache();
		$cache->flush();
		$temp['lang'] = $this->p_lang;
		$this->load_php('admin/cache', $temp);
	}
	
	public function data($type = '', $name = '')
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		set_time_limit(0);
		$admin_obj = $this->load_model('Q_Cate');
		if($type == 'backup')
		{
			$result = $admin_obj->sql_bakup();
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['data'].' err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'data')).'";');
				return;
			}			
		}
		elseif($type == 'backin')
		{
			$result = $admin_obj->sql_bakin($name);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['data'].' err !");history.back();');return ;
			}
			else
			{
				exec_script('alert("ok !");window.location.href = "'.url(array('admin', 'data')).'";');
				return;
			}
		}
		$dir_arr = array();
		$handle = opendir('static/backup/');
		while(false !== ($file = readdir($handle))) 
		{
			if($file == '.' || $file == '..' || $file == '.svn')
			{
				continue;
			}
			{
				$dir_arr[] = $file;
			}			
		}
		$qcms['dir_arr'] = $dir_arr;
		$this->load_php('admin/data', $qcms);
	}	
	
	public function cate()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$qcms['table'] = $this->_cate_list();
		$this->load_php('admin/cate', $qcms);
	}
	
	public function order()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$order_obj = $this->load_model("Q_Order");
		$count = '';
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->p_num;
		$qcms['rs'] = $order_obj->select_all(array(), array($offset, $this->p_num), 'oid,ono,onum,uid,otime,nid', $count);
		$qcms['count'] = $count[0]['count'];
		$this->load_php('admin/order', $qcms);
	}
	
	public function cate_add()
	{		
		$level = array(1);
		
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$form_obj = $this->load_model('Q_Form');
		$form_rs = $form_obj->select(array('type' => 0), 'id, name, type', 0, 'id');
		$form_rs[0] = array('id' => '0', 'name' => '默认', 'type' => '0');
		ksort($form_rs);
		$qcms['form_rs'] = $form_rs;
		$qcms['cate_str'] = self::_cate_list(1);
		$qcms['title'] = $this->p_lang['class'].$this->p_lang['add'];		
		if(!empty($_POST))
		{
			if(!empty($_POST['clinkture']))
			{
				if(empty($_POST['cname']) || empty($_POST['clink']))
				{
					exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
				}				
			}
			else
			{
				if(empty($_POST['cname']) || empty($_POST['ctemp']) || empty($_POST['ntemp']))
				{
					exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
				}
			}
			$pinyin_obj = new Pinyin();
			$cate_obj = $this->load_model('Q_Cate');
			$insert_arr = array(
			'pcid'		=> empty($_POST['cate']) ? 0 : $_POST['cate'],
			'cname' 	=> $_POST['cname'],
			'cimg' 		=> $_POST['cimg'],
			'clink' 	=> $_POST['clink'],
			'ckeyword' 	=> $_POST['ckeyword'],
			'cinfo' 	=> $_POST['cinfo'],
			'con' 		=> empty($_POST['con']) ? 0 : $_POST['con'],
			'csort' 	=> $_POST['csort'],
			'ctemp' 	=> $_POST['ctemp'],
			'ntemp' 	=> $_POST['ntemp'],
			'clinkture'	=> empty($_POST['clinkture']) ? 0 : $_POST['clinkture'],
			'cpy' 		=> $pinyin_obj->py($_POST['cname'], $this->p_py_type),
			'cfield' 	=> $_POST['cfield']);
			$result = $cate_obj->insert($insert_arr);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['class'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'cate')).'";');
			}
		}
		$this->load_php('admin/cate_add', $qcms);
	}
	
	public function cate_edit($cid)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($cid))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$form_obj = $this->load_model('Q_Form');
		$form_rs = $form_obj->select(array('type' => 0), 'id, name, type', 0, 'id');
		$form_rs[0] = array('id' => '0', 'name' => '默认', 'type' => '0');
		ksort($form_rs);
		$qcms['form_rs'] = $form_rs;
		$qcms['title'] = $this->p_lang['class'].$this->p_lang['edit'];
		$cate_obj = $this->load_model('Q_Cate');
		$qcms['rs'] = $cate_obj->select(array('cid' => $cid));		
		$qcms['cate_str'] = self::_cate_list(1, $qcms['rs'][0]['pcid']);
		if(!empty($_POST))
		{
			if(!empty($_POST['clinkture']))
			{
				if(empty($_POST['cname']) || empty($_POST['clink']))
				{
					exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
				}				
			}
			else
			{
				if(empty($_POST['cname']) || empty($_POST['ctemp']) || empty($_POST['ntemp']))
				{
					exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
				}
			}
			$pinyin_obj = new Pinyin();
			$cate_obj = $this->load_model('Q_Cate');
			$insert_arr = array(
			'pcid'		=> $_POST['cate'],
			'cname' 	=> $_POST['cname'],
			'cimg' 		=> $_POST['cimg'],
			'clink' 	=> $_POST['clink'],
			'ckeyword' 	=> $_POST['ckeyword'],
			'cinfo' 	=> $_POST['cinfo'],
			'con' 		=> empty($_POST['con']) ? 0 : $_POST['con'],
			'csort' 	=> $_POST['csort'],
			'ctemp' 	=> $_POST['ctemp'],
			'ntemp' 	=> $_POST['ntemp'],
			'clinkture'	=> empty($_POST['clinkture']) ? 0 : $_POST['clinkture'],
			'cpy' 		=> $pinyin_obj->py($_POST['cname'], $this->p_py_type),
			'cfield' 	=> $_POST['cfield']);
			$result = $cate_obj->update($insert_arr, array('cid' => $cid));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['class'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'cate')).'";');
			}
		}
		$this->load_php('admin/cate_edit', $qcms);
	}
	
	public function cate_del($cid)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($cid))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$cate_obj = $this->load_model('Q_Cate');
		$news_obj = $this->load_model('Q_News');
		$c_rs = $cate_obj->select(array('pcid' => $cid));
		$n_rs = $news_obj->select(array('cid' => $cid));
		if(!empty($c_rs) || !empty($c_rs))
		{
			exec_script('alert("'.$this->p_lang['delete'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$result = $cate_obj->del(array('cid' => $cid));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['class'].' delete err !");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'cate')).'";');
		}
	}
	
	public function news()
	{
		$level = array(1,2);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$news_obj = $this->load_model('Q_News');
		$count = '';
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->p_num;
		if(!empty($_GET['cid']))
		{
			$this->_all_cid($_GET['cid']);
			$cond_arr['cid'] = $this->_cid_all;
		}
		$qcms['rs'] = $news_obj->select_all($cond_arr, array($offset, $this->p_num), 'nid,ntitle,cid,ntime,nsort,type,outlink', $count);
		$qcms['count'] = $count[0]['count'];
		$qcms['cate_str'] = self::_cate_list(1);
		$this->load_php('admin/news', $qcms);
	}
	
	public function news_add($cid = 0)
	{
		session_start();
		$cid = empty($_GET['cid']) ? $cid : $_GET['cid'];
		$level = array(1,2);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$crs = '';
		if(!empty($cid))
		{
			$cate_obj = $this->load_model('Q_Cate');
			$form_obj = $this->load_model('Q_Form');
			$crs = $cate_obj->select(array('cid' => $cid), '', 'cfield, cid');
			$forms_rs = $form_obj->select(array('id' => $crs[0]['cfield'], 'type' => 0));
			$qcms['cfield'] = empty($forms_rs[0]['field']) ? array() : @unser_str($forms_rs[0]['field']);
		}	
		$pinyin_obj = new Pinyin();
		$qcms['cate_str'] = self::_cate_list(1, $cid , 1);
		$qcms['title'] = $this->p_lang['content'].$this->p_lang['add'];
		if(!empty($_POST))
		{
			if(empty($_POST['ntitle']) || empty($_POST['cate']))
			{
				exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
			}
			$news_obj = $this->load_model('Q_News');
			if(empty($_POST['outlink'])){
				$outlink = 0;
				$py = $pinyin_obj->py($_POST['ntitle'], $this->p_py_type);
			}else{
				$outlink = 1;
				$py = $_POST['clink'];
			}
			if(empty($_POST['nimg'])){
				$isimg = 0;
			}else{
				$isimg = 1;
			}
			$insert_arr = array(
			'ntitle'	=>	$_POST['ntitle'],
			'nkeyword'	=>	$_POST['nkeyword'],
			'ncontent'	=>	$_POST['ncontent'],
			'ntime'		=>	$_POST['ntime'],
			'cid'		=>	$_POST['cate'],
			'nimg'		=>	$_POST['nimg'],
			'npy'		=>	$py,
			'nsort'		=>	$_POST['nsort'],
			'nfield'	=>	@serialize($_POST['nfield']),	
			'uid'		=>	$_COOKIE['user']['uid'],
			'outlink'	=>	$outlink,	
			'isimg'		=>	$isimg,
			);			
			$result = $news_obj->insert($insert_arr);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
			}
		}
		$this->load_php('admin/news_add', $qcms);
		
	}
	
	public function news_edit($id, $cid = 0)
	{
		$qcms['id'] = $id;
		$cid = empty($_GET['cid']) ? $cid : $_GET['cid'];
		$level = array(1,2);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($id) || empty($cid))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$news_obj = $this->load_model('Q_News');
		$cate_obj = $this->load_model('Q_Cate');
		$cate_obj = $this->load_model('Q_Cate');
		$form_obj = $this->load_model('Q_Form');		
		$crs = $cate_obj->select(array('cid' => $cid), '', 'cfield, cid');
		if(!empty($crs[0]['cfield'])){
			$forms_rs = $form_obj->select(array('id' => $crs[0]['cfield'], 'type' => 0));
			$qcms['cfield'] = empty($forms_rs[0]['field']) ? array() : @unser_str($forms_rs[0]['field']);
		}		
		$pinyin_obj = new Pinyin();
		$qcms['cate_str'] = self::_cate_list(1, $cid , 1);
		$qcms['title'] = $this->p_lang['content'].$this->p_lang['edit'];
		$qcms['rs'] = $news_obj->select(array('nid' => $id));
		if(!empty($_POST))
		{
			if(empty($_POST['ntitle']) || empty($_POST['cate']))
			{
				exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
			}
			if(empty($_POST['outlink'])){
				$outlink = 0;
				$py = $pinyin_obj->py($_POST['ntitle'], $this->p_py_type);
			}else{
				$outlink = 1;
				$py = $_POST['clink'];
			}
			if(empty($_POST['nimg'])){
				$isimg = 0;
			}else{
				$isimg = 1;
			}
			$update_arr = array(
			'ntitle'	=>	$_POST['ntitle'],
			'nkeyword'	=>	$_POST['nkeyword'],
			'ncontent'	=>	$_POST['ncontent'],
			'ntime'		=>	$_POST['ntime'],
			'cid'		=>	$_POST['cate'],
			'nimg'		=>	$_POST['nimg'],
			'npy'		=>	$py,
			'nsort'		=>	$_POST['nsort'],
			'nfield'	=>	@serialize($_POST['nfield']),
			'outlink'	=> 	$outlink,		
			'isimg'		=>	$isimg,
			);
			$result = $news_obj->update($update_arr, array('nid' => $id));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
			}
		}
		$this->load_php('admin/news_edit', $qcms);
	}
	
	public function news_edit_all(){
		$news_obj = $this->load_model('Q_News');
		if(empty($_GET['act']) || empty($_GET['id'])){
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$id = explode('|', substr($_GET['id'], 0, -1));
		$qcms['title'] = '批量修改';
		$qcms['cate_str'] = self::_cate_list(1, 0 , 1);
		if(!empty($_POST)){
			if(empty($_POST['cate'])){
				exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
			}
			$result = $news_obj->update(array('cid' => $_POST['cate']), array('nid' => $id));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
			}
		}
		$this->load_php('admin/news_edit_all', $qcms);
	}
	
	public function news_hot($id){
		$news_obj = $this->load_model('Q_News');
		if(empty($id)){
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$rs = $news_obj->select(array('nid' => $id), '', 'nid, type');
		$type = ($rs[0]['type'] == 1) ? 0 : 1;
		$result = $news_obj->update(array('type' => $type), array('nid' => $id));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
		}
	}
	
	public function news_recommend($id){
		$news_obj = $this->load_model('Q_News');
		if(empty($id)){
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$rs = $news_obj->select(array('nid' => $id), '', 'nid, type');
		$type = ($rs[0]['type'] == 2) ? 0 : 2;
		$result = $news_obj->update(array('type' => $type), array('nid' => $id));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
		}
	}
	
	public function news_del($id, $cid)//-- 0:单个操作，1:批量操作 --
	{
		$level = array(1,2);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(!empty($_GET['act']) && !empty($_GET['id'])){
			$id = explode('|', substr($_GET['id'], 0, -1));
		}
		$news_obj = $this->load_model('Q_News');		
		$result = $news_obj->del(array('nid' => $id));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
		}
		else
		{	
			if(!empty($_GET['act'])){
				exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
			}
			exec_script('window.location.href = "'.url(array('admin', 'news')).'";');
		}
	}
	
	private function _cate_list($type = 0, $cid = 0, $have_top = 0)
	{
		$cate_obj = $this->load_model('Q_Cate');
		$have_js = '';
		$cond_arr = array('pcid' => 0);
		$result = $cate_obj->select($cond_arr, '', '*', '', '', array('csort' => 'ASC', 'cid' => 'ASC'));
		$return_str = '';
		$is_select = '';
		$select_str = (empty($have_top)) ? '<option value="0">&nbsp;&nbsp;'.$this->p_lang['top'].$this->p_lang['class'].'&nbsp;&nbsp;</option>' : '<option value="0">&nbsp;&nbsp;'.$this->p_lang['please'].$this->p_lang['class'].'&nbsp;&nbsp;</option>';
		$td_style = ' style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"';
		if(empty($result))
		{
			return;
		}
		foreach ($result as $key => $val)
		{
			if($val['cid'] == $cid)
			{
				$is_select = 'selected="selected"';
			}
			else
			{
				$is_select = '';
			}
			$select_str .= '<option value="'.$val['cid'].'" '.$is_select.'>&nbsp;&nbsp;'.$val['cname'].'&nbsp;&nbsp;</option>';
			$select_str .= self::_sub_cate_list($val['cid'], $type, $cid);
			$return_str .= '<tr bgcolor="#F9F9F9"><td  '.$td_style.'>'.$val['cid'].'</td><td  '.$td_style.'>'.$val['cname'].'</td><td  '.$td_style.'><a href="'.url(array('admin', 'cate_edit', $val['cid'])).'">'.$this->p_lang['edit'].'</a> <a href="'.url(array('admin', 'cate_del', $val['cid'])).'">'.$this->p_lang['delete'].'</a></td><td '.$td_style.'>'.$val['csort'].'</td></tr>';
			$return_str .= self::_sub_cate_list($val['cid'], $type, $cid);
		}		
		if($type == 1)
		{
			if(!empty($have_top))
			{
				$have_js = 'onChange="cate_channge()"';
			}
			return '<select name="cate" id="cate" '.$have_js.'>'.$select_str.'</select>';
		}
		return '<table class="table" width="100%" border="0" cellspacing="0">'.$return_str.'</table>';
	}
	
	private function _sub_cate_list($cid, $type = 0, $select_cid = 0, $html = '&nbsp;&nbsp;├&nbsp;&nbsp;')
	{
		$return_str = '';
		$select_str = '';
		$is_select = '';
		$cate_obj = $this->load_model('Q_Cate');
		$cond_arr = array('pcid' => $cid);
		$result = $cate_obj->select($cond_arr, '', '*', '', '', array('csort' => 'ASC', 'cid' => 'ASC'));
		if(empty($result)) return ;
		$td_style = ' style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 5px;padding-bottom: 5px;"';
		$sub_html = '&nbsp;&nbsp;&nbsp;&nbsp;';
		$sub_html .= $html;
		foreach ($result as $key => $val)
		{		
			if($val['cid'] == $select_cid)
			{
				$is_select = 'selected="selected"';
			}	
			else
			{
				$is_select = '';
			}
			$select_str .= '<option value="'.$val['cid'].'" '.$is_select.'>&nbsp;&nbsp;'.$html.$val['cname'].'&nbsp;&nbsp;</option>';
			$select_str .= self::_sub_cate_list($val['cid'], $type, $select_cid, $sub_html);
			$return_str .= '<tr bgcolor="#ffffff"><td '.$td_style.'>'.$val['cid'].'</td><td '.$td_style.'>'.$html.$val['cname'].'</td><td '.$td_style.'><a href="'.url(array('admin', 'cate_edit', $val['cid'])).'">'.$this->p_lang['edit'].'</a> <a href="'.url(array('admin', 'cate_del', $val['cid'])).'">'.$this->p_lang['delete'].'</a></td><td '.$td_style.'>'.$val['csort'].'</td></tr>';
			$return_str .= self::_sub_cate_list($val['cid'], $type, $select_cid, $sub_html);
		}
		if($type == 1)
		{
			return $select_str;
		}
		return $return_str; 		
	}
	
	public function user()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$count = '';
		$user_obj = $this->load_model('Q_User');
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->page_num;
		$qcms['rs'] = $user_obj->select_all('', array($offset, $this->p_num), 'uid, username, level, sex, email, money, add_time', $count);
		$qcms['count'] = $count[0]['count'];
		$this->load_php('admin/user', $qcms);
	}
	
	public function user_add()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$qcms['rs'] = array(
		array('username', 'input', '', 200, $this->p_lang['user'], '', 0),
		array('password', 'password', '', 200, $this->p_lang['password'], '', 0),
		array('sex', 'select', array($this->p_lang['boy'] => '0', $this->p_lang['girl'] => '1'), 200, $this->p_lang['sex'], '', 0),
		array('email', 'input', '', 200, $this->p_lang['email'], '', 0),
		array('qq', 'input', '', 200, $this->p_lang['qq'], '', 0),
		array('tel', 'input', '', 200, $this->p_lang['tel'], '', 0),
		array('address', 'input', '', 200, $this->p_lang['address'], '', 0),
		array('money', 'input', 0, 200, $this->p_lang['money'], '', 0),
		array('add_time', 'input', date('Y-m-d H:i:s'), 200, $this->p_lang['time'], '', 0),		
		array('level', 'select', $this->_user_level, 200, $this->p_lang['user'], '', 0),
		);
		if(!empty($_POST))
		{
			$user_obj = $this->load_model('Q_User');			
			$update_arr = $this->post_verify($qcms['rs']);
			if(!$update_arr)
			{
				exec_script('alert("add is err");history.back();');return;
			}
			$result = $user_obj->insert($update_arr);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['user'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'user')).'";');
			}
		}
		$this->load_php('admin/user_add', $qcms);
	}
	
	public function user_del($uid)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($uid))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}		
		$user_obj = $this->load_model('Q_User');
		$result = $user_obj->del(array('uid' => $uid));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['user'].$this->p_lang['delete'].$this->p_lang['err'].'!");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'user')).'";');
		}
	}
	
	public function user_edit($uid)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($uid))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$user_obj = $this->load_model('Q_User');
		$result = $user_obj->select(array('uid' => $uid), '', 'username, password, sex, email, qq, tel, address, money, add_time, level');
		foreach ($result[0] as $key => $val)
		{//0:name,1:type,2:value,3:width,4:chinese,5:height,6:isnull
			if($key == 'sex')
			{
				$sex_str = ($val == 0) ? $this->p_lang['boy'] : $this->p_lang['girl'];
				$rs[] = array($key, 'select', array($sex_str => $val, $this->p_lang['boy'] => '0', $this->p_lang['girl'] => '1'), 200, $key, '', 0);
			}
			elseif($key == 'password')
			{
				$rs[] = array($key, 'input', '', 200, $key, '', 1);
			}
			else
			{
				$rs[] = array($key, 'input', $val, 200, $key, '', 0);
			}			
		}
		$qcms['rs'] = $rs;
		if(!empty($_POST))
		{
			$update_arr = $this->post_verify($qcms['rs']);
			if(!$update_arr)
			{
				exec_script('alert("edit is err");history.back();');return;
			}
			$result = $user_obj->update($update_arr, array('uid' => $uid));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['user'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'user_edit', $uid)).'";');
			}
		}
		$this->load_php('admin/user_edit', $qcms);
	}
	
	public function ext($type = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$ext_name = '';
		switch($type)
		{
			case 1:
				$ext_name = $this->p_lang['page'];
				break;
			case 2:
				$ext_name = 'JS';
				break;
			case 3:
				$ext_name = 'XML';
				break;
			default:
				$ext_name = $this->p_lang['tag'];
				break;
		}
		$qcms['title'] = $ext_name;
		$tag_obj = self::load_model('Q_Tag');
		$qcms['rs'] = $tag_obj->select(array('etype' => $type), '', 'eid, etitle, etype');
		$qcms['ext_name'] = $ext_name;
		$this->load_php('admin/ext', $qcms);
	}
	
	public function ext_add($type = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$ext_name = '';
		switch($type)
		{
			case 1:
				$ext_name = $this->p_lang['page'];
				break;
			case 2:
				$ext_name = 'JS';
				break;
			case 3:
				$ext_name = 'XML';
				break;
			default:
				$ext_name = $this->p_lang['tag'];
				break;
		}
		$qcms['title'] = $ext_name;
		$ext_name = ($type == 1) ? $this->p_lang['page'] : 'JS';

		$qcms['rs'] = array(
		array('etitle', 'input', '', 200, $this->p_lang['title'], '', 0),
		array('einfo', 'editor', '', 600, $this->p_lang['content'], 400, 0),
		);
		if(!empty($_POST))
		{
			$tag_obj = $this->load_model('Q_Tag');			
			$update_arr = $this->post_verify($qcms['rs']);
			if(!$update_arr)
			{
				exec_script('alert("add is err");history.back();');return;
			}
			$update_arr['etype'] = $type;
			$result = $tag_obj->insert($update_arr);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['ext'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'ext', $type)).'";');
			}
		}
		$qcms['ext_name'] = $ext_name;
		$this->load_php('admin/ext_add', $qcms);
	}
	
	public function ext_edit($id, $type = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($id))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		switch($type)
		{
			case 1:
				$ext_name = $this->p_lang['page'];
				break;
			case 2:
				$ext_name = 'JS';
				break;
			case 3:
				$ext_name = 'XML';
				break;
			default:
				$ext_name = $this->p_lang['tag'];
				break;
		}
		$qcms['title'] = $ext_name;
		$tag_obj = $this->load_model('Q_Tag');
		$result = $tag_obj->select(array('eid' => $id), '', 'etitle, einfo');
		foreach ($result[0] as $key => $val)
		{//0:name,1:type,2:value,3:width,4:chinese,5:height,6:isnull
			if($key == 'einfo')
			{
				$rs[] = array($key, 'editor', $val, 600, $key, 400, 0);
			}
			else
			{
				$rs[] = array($key, 'input', $val, 200, $key, '', 0);
			}			
		}
		$qcms['rs'] = $rs;
		if(!empty($_POST))
		{
			$update_arr = $this->post_verify($qcms['rs']);
			if(!$update_arr)
			{
				exec_script('alert("edit is err");history.back();');return;
			}
			$result = $tag_obj->update($update_arr, array('eid' => $id));
			if(!$result)
			{
				exec_script('alert("edit err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'ext', $type)).'";');
			}
		}
		$this->load_php('admin/ext_edit', $qcms);
	}
	
	public function ext_del($id, $type = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($id))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$tag_obj = $this->load_model('Q_Tag');
		$result = $tag_obj->del(array('eid' => $id));
		if(!$result)
		{
			exec_script('alert("del err !");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'ext', $type)).'";');
		}
	}
	
	public function temp()
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$result = @opendir(BASEPATH.'view/home/'.$this->p_site['tempdir']);
		if(!$result)return;
		$i = 0;
		while (false !== ($file = readdir($result)))
		{			
			if($file != '.' && $file != '..' && is_file(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$file))
			{
				$filename = substr($file, 0, -5);
				$i += 1;
				$rs[] = array('id' => $i, 'name' => $filename);
			}			
		}
		$qcms['rs'] = $rs;
		$qcms['manage_title'] = $this->p_lang['temp'].$this->p_lang['manage'];
		$this->load_php('admin/temp', $qcms);
	}
	
	public function temp_add()
	{		
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$qcms['rs'] = array(
		array('name', 'input', '', 200, $this->p_lang['title'], '', 0),
		array('temp_str', 'text', '', 600, $this->p_lang['content'], 400, 0),
		);
		$qcms['manage_title'] = $this->p_lang['temp'].$this->p_lang['add'];
		if(!empty($_POST))
		{
			$insert_arr = $this->post_verify($qcms['rs']);
			$result = file_put_contents(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$insert_arr['name'].'.html', stripslashes($insert_arr['temp_str']), LOCK_EX);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['temp'].' save err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'temp')).'";');return;
			}
		}
		$this->load_php('admin/temp_add', $qcms);
	}
	
	public function temp_edit($filename)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($filename) || !is_file(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$filename.'.html'))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$qcms['rs'] = array(
		array('name', 'input', $filename, 200, $this->p_lang['title'], '', 0),
		array('temp_str', 'text', htmlentities(file_get_contents(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$filename.'.html'), ENT_COMPAT, 'utf-8'), 600, $this->p_lang['content'], 400, 0),
		);		
		$qcms['manage_title'] = $this->p_lang['temp'].$this->p_lang['edit'];
		if(!empty($_POST))
		{
			$insert_arr = $this->post_verify($qcms['rs']);
			$result = file_put_contents(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$insert_arr['name'].'.html', stripslashes($insert_arr['temp_str']), LOCK_EX);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['temp'].' edit err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'temp')).'";');return;
			}
		}
		$this->load_php('admin/temp_add', $qcms);
	}
	
	public function temp_del($filename)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($filename) || !is_file(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$filename.'.html'))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$result = unlink(BASEPATH.'view/home/'.$this->p_site['tempdir'].'/'.$filename.'.html');
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['temp'].' del err !");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'temp')).'";');return;
		}
	}
	
	public function guest($gtype = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$count = '';
		$gtype = empty($gtype) ? 0 : 1;
		$guest_obj = $this->load_model('Q_Guest');
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->page_num;
		if($gtype == 0)
		{
			$fied = 'gid, gtitle, uid, gtype, gtime';	
			$qcms['title'] = $this->p_lang['guest'].$this->p_lang['manage'];
		}
		else
		{
			$fied = 'gid, gtitle, uid, nid, gtype, gtime';
			$qcms['title'] = $this->p_lang['review'].$this->p_lang['manage'];
		}
		$qcms['rs'] = $guest_obj->select_all(array('gtype' => $gtype), array($offset, $this->p_num), $fied, $count);
		$qcms['count'] = $count[0]['count'];
		$this->load_php('admin/guest', $qcms);		
	}
	
	public function guest_edit($id, $gtype = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($id))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}
		$gtype = empty($gtype) ? 0 : 1;
		$guest_obj = $this->load_model('Q_Guest');
		$result = $guest_obj->select(array('gid' => $id), '', 'gtitle, ginfo');
		foreach ($result[0] as $key => $val)
		{//0:name,1:type,2:value,3:width,4:chinese,5:height,6:isnull
			if($key == 'ginfo')
			{				
				$rs[] = array($key, 'editor', $val, 600, $key, 400, 0);
			}
			else
			{
				$rs[] = array($key, 'input', $val, 200, $key, '', 0);
			}			
		}
		$qcms['rs'] = $rs;
		if(!empty($_POST))
		{
			$update_arr = $this->post_verify($qcms['rs']);
			if(!$update_arr)
			{
				exec_script('alert("edit is err");history.back();');return;
			}
			$result = $guest_obj->update($update_arr, array('gid' => $id));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['user'].' sava err !");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'guest', $gtype)).'";');
			}
		}
		$this->load_php('admin/guest_edit', $qcms);
	}
	
	public function guest_del($id, $gtype = 0)
	{
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(empty($id))
		{
			exec_script('alert("'.$this->p_lang['parameter'].$this->p_lang['err'].' !");history.back();');return ;
		}		
		$gtype = empty($gtype) ? 0 : 1;
		$guest_obj = $this->load_model('Q_Guest');
		$result = $guest_obj->del(array('gid' => $id));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['guest'].$this->p_lang['delete'].$this->p_lang['err'].'!");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'guest', $gtype)).'";');
		}
	}	
	
	public function forms($type = 0){
		$level = array(1);
		$qcms['type'] = $type;
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(!empty($type)){
			$qcms['title'] = $this->p_lang['forms'].$this->p_lang['manage'];
		}else{
			$qcms['title'] = $this->p_lang['model'].$this->p_lang['manage'];
		}		
		$form_obj = $this->load_model('Q_Form');
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->page_num;
		$count = '';
		$qcms['rs'] = $form_obj->select_all(array('type' => $type), array($offset, $this->p_num), 'id, name, type', $count);
		$qcms['count'] = $count[0]['count'];
		$this->load_php('admin/forms', $qcms);	
	}
	
	public function forms_add($type = 0){
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		if(!empty($_POST['field_info'][0]))
		{
			$i = 0;
			while($i < count($_POST['field_info']))
			{
				$c_field[$i] = array('field_info' => $_POST['field_info'][$i], 'field_name' => $_POST['field_name'][$i], 'field_type' => $_POST['field_type'][$i], 'field_parameter' => $_POST['field_parameter'][$i]);
				$i++;
			}
			$login = empty($_POST['login']) ? 0 : $_POST['login'];
			$form_obj = $this->load_model('Q_Form');
			$result = $form_obj->insert(array('name' => $_POST['name'], 'field' => serialize($c_field), 'login' => $login, 'type' => $type));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['add'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'forms', $type)).'";');
			}
		}
		if(empty($type)){
			$qcms['title'] = $this->p_lang['model'].$this->p_lang['add'];
		}else{
			$qcms['title'] = $this->p_lang['forms'].$this->p_lang['add'];
		}		
		$qcms['type'] = $type;
		$this->load_php('admin/forms_add', $qcms);	
	}
	
	public function forms_edit($id = 0, $type = 0){
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$form_obj = $this->load_model('Q_Form');
		$qcms['rs'] = $form_obj->select(array('id' => $id));
		if(empty($type)){
			$qcms['title'] = $this->p_lang['model'].$this->p_lang['edit'];
		}else{
			$qcms['title'] = $this->p_lang['forms'].$this->p_lang['edit'];
		}
		if(!empty($_POST['field_info'][0]))
		{
			$i = 0;
			while($i < count($_POST['field_info']))
			{
				$c_field[$i] = array('field_info' => $_POST['field_info'][$i], 'field_name' => $_POST['field_name'][$i], 'field_type' => $_POST['field_type'][$i], 'field_parameter' => $_POST['field_parameter'][$i]);
				$i++;
			}
			$login = empty($_POST['login']) ? 0 : $_POST['login'];			
			$result = $form_obj->update(array('name' => $_POST['name'], 'field' => serialize($c_field), 'login' => $login, 'type' => $type), array('id' => $id));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['edit'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('admin', 'forms_edit', $id, $type)).'";');return;
			}
		}		
		$qcms['type'] = $type;	
		$this->load_php('admin/forms_edit', $qcms);	
	}
	
	public function forms_del($id = 0, $type = 0){
		$level = array(1);
		if(!in_array($_COOKIE['user']['level'], $level))
		{
			echo 'No permission !';return;
		}
		$form_obj = $this->load_model('Q_Form');
		$result = $form_obj->del(array('id' => $id));
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['delete'].$this->p_lang['err'].'!");history.back();');return ;
		}
		else
		{
			exec_script('window.location.href = "'.url(array('admin', 'forms', 1)).'";');return;
		}
	}
	
	public function form_code($id){
		$form_obj = $this->load_model('Q_Form');
		$rs = $form_obj->select(array('id' => $id));
		$str = empty($rs[0]['field']) ? '' : @unserialize($rs[0]['field']);
		if(empty($str)){
			return;
		}
		$this->load_php('admin/form_code', array('str' => $str, 'id' => $id));	
	}
	
	public function form_review($id){
		$form_obj = $this->load_model('Q_Form');
		$rs = $form_obj->select(array('id' => $id));
		$str = empty($rs[0]['field']) ? '' : @unserialize($rs[0]['field']);
		if(empty($str)){
			return;
		}
		$count = '';
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->p_num;
		$review_rs = $form_obj->select_all(array('form_id' => $id), array($offset, $this->p_num), '*', $count, 1);
		$page = page_bar($count[0]['count'], $this->p_num, '');
		$this->load_php('admin/form_review', array('str' => $str, 'id' => $id, 'review_rs' => $review_rs, 'page' => $page));	
		
	}
	
	
	public function ajax_upload()
	{
		if(empty($_FILES['filedata']))return msg('Uplod err');
		$err = '';
		$msg = '';
		$upload_obj = new Upload();
		$result = $upload_obj->upload_file($_FILES['filedata']);
		switch($result)
		{
			case '1':
				$err = $this->p_lang['upload'].$this->p_lang['type'].$this->p_lang['err'];
				break;
			case '2':
				$err = $this->p_lang['file'].$this->p_lang['too'].$this->p_lang['big'];
				break;
			case '3':
				$err = $this->p_lang['write'].$this->p_lang['file'].$this->p_lang['err'];
				break;
			default:
				$msg = $result;
		}
		echo json_encode(array('err'=>$err,'msg'=>$msg));
	}
	
	public function upload_swf()
	{
		if(empty($_FILES['Filedata']))return msg('Uplod err');
		if (isset($_POST["PHPSESSID"])) 
		{		
			session_id($_POST["PHPSESSID"]);
		}
		session_start();
		$msg = '';
		$upload_obj = new Upload();
		$pic_obj = $this->load_model('Q_Pic');
		$result = $upload_obj->upload_file($_FILES['Filedata']); 
		switch($result)
		{
			case '1':
				break;
			case '2':
				break;
			case '3':
				break;
			default:
				$pic_obj->insert(array('url' => $result));
		}		
	}
	
	public function pic(){
		$pic_obj = $this->load_model('Q_Pic');
		$rs = $pic_obj->select();
		if(empty($rs)){
			return;
		}
		$pic_arr = array();
		$pic_id = array();
		foreach($rs as $key => $val){
			$pic_arr[] = $val['url'];
			$pic_id[] = $val['pid'];
		}
		echo implode('|', $pic_arr);
		$pic_obj->del(array('pid' => $pic_id));
	}

	private function _admin_login()
	{
		if((!empty($_REQUEST['api']) || $_REQUEST['api'] == $this->p_site['connect']) || $_COOKIE['api'] == $this->p_site['connect']){
			setcookie ("api", $this->p_site['connect'], time() + 31536000, "/");
			return;
		}
		if(empty($_COOKIE['user']['username']) || empty($_COOKIE['user']['level']) || empty($_COOKIE['user']['password']))
		{
			exec_script('window.top.location.href="'.SITEPATH.'"');exit;
		}
		$user_obj = self::load_model('Q_User');	
		$result = $user_obj->select(array('username' => $_COOKIE['user']['username'], 'password' => $_COOKIE['user']['password'], 'level' => $_COOKIE['user']['level']));
		if(!$result)
		{
			exec_script('window.top.location.href="'.SITEPATH.'"');exit;
		}	
	}
	
	private function _all_cid($cid)
	{
		$this->_cid_all[] = $cid;
		$cate_obj = $this->load_model('Q_Cate');
		$cid_arr = $cate_obj->select(array('pcid' => $cid), '', 'cid');
		if(empty($cid_arr)) return ;
		foreach ($cid_arr as $key => $val)
		{
			$this->_cid_all[] = $val['cid'];
			self::_sub_cid($val['cid']);
		}
		return;
	}
	
	private function _sub_cid($cid)
	{
		$cate_obj = $this->load_model('Q_Cate');
		$cid_arr = $cate_obj->select(array('pcid' => $cid), '', 'cid');
		if(empty($cid_arr)) return ;
		foreach ($cid_arr as $key => $val)
		{
			$this->_cid_all[] = $val['cid'];
			self::_sub_cid($val['cid']);
		}
		return;
	}
	
	private function _plus(){
		$moduleObj = $this->load_model('Q_Module');
		$rs = $moduleObj->select('', '', '*', 0, 'mtitle');
		$plusArr = array();
		if(is_dir('module/'))
		{
			if ($dh = opendir('module/')) {
	        	while (($file = readdir($dh)) !== false) {
	        		if($file != '.' && $file != '..' && $file != '.svn'){
	        			//$qcms['plus'][] = $file;
	        			if(!empty($rs[$file]['status'])){
	        				$plusArr[$file] = 1;
	        			}else{
	        				$plusArr[$file] = 0;
	        			}
	        		}	           		
	        	}
	        	closedir($dh);
	    	}								
		}
		$qcms['module'] = $plusArr;
		$this->load_php('admin/plus', $qcms);
	}
	
	private function _install(){
		if(!empty($_POST)){
			$moduleName = $_POST['module'];
			$moduleObj = $this->load_model('Q_Module');
			if(file_exists('module/'.$moduleName.'/config'.EXT)){
				$result = require 'module/'.$moduleName.'/config'.EXT;
				$config['status'] = 1;
				$config['mtitle'] = $moduleName;
				$result = $moduleObj->insert($config);
				if($result){
					echo 1;
				}else{
					echo 0;
				}
			}else{
				echo -1;
			}
		}
	}
	
	private function _uninstall(){
		if(!empty($_POST)){
			$moduleName = $_POST['module'];
			$moduleObj = $this->load_model('Q_Module');
			$result = $moduleObj->del(array('mtitle' => $moduleName));
			if($result){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
}
?>