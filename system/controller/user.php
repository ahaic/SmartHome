<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Base
{
	private $_user_level;
	private $_user_obj;
	public $head_rs;
	function __construct()
	{		
		$this->_user_obj = $this->load_model('Q_User');
		self::load_config();
		$this->head_rs = $this->header();
		$this->_user_level = array($this->p_lang['level_user'] => '0', $this->p_lang['level_admin'] => '1', $this->p_lang['level_compile'] => '2', $this->p_lang['level_prevent'] => '-1');
		$this->_user_login();	
	}
	
	public function index()
	{		
		$qcms['rs'] = $this->_user_obj->select(array('uid' => $_COOKIE['user']['uid']));
		$this->load_php('user/index', $qcms);
	}
	
	public function edit()
	{
		$qcms['rs'] = $this->_user_obj->select(array('uid' => $_COOKIE['user']['uid']));
		if(!empty($_POST))
		{
			$update_arr = array('sex' => $_POST['sex'], 'email' => $_POST['email'], 'qq' => $_POST['qq'], 'tel' => $_POST['tel'], 'address' => $_POST['address']);
			$result = $this->_user_obj->update($update_arr, array('uid' => $_COOKIE['user']['uid']));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('user', 'index')).'";');return;
			}
		}
		$this->load_php('user/edit', $qcms);
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
		$cond_arr['uid'] = $_COOKIE['user']['uid'];
		$qcms['rs'] = $news_obj->select_all($cond_arr, array($offset, $this->p_num), 'nid,ntitle,cid,ntime,nsort,type,outlink', $count);
		$qcms['count'] = $count[0]['count'];
		$qcms['cate_str'] = self::_cate_list(1);
		$this->load_php('user/news', $qcms);
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
				exec_script('window.location.href = "'.url(array('user', 'news')).'";');
			}
		}
		$this->load_php('user/news_add', $qcms);
		
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
				exec_script('window.location.href = "'.url(array('user', 'news')).'";');
			}
		}
		$this->load_php('user/news_edit', $qcms);
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
				exec_script('window.location.href = "'.url(array('user', 'news')).'";');
			}
			exec_script('window.location.href = "'.url(array('user', 'news')).'";');
		}
	}
	
	public function order()
	{
		$order_obj = $this->load_model("Q_Order");
		$news_obj = $this->load_model("Q_News");
		$count = '';
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $this->page_num;
		$qcms['rs'] = $order_obj->select_all(array('uid' => $_COOKIE['user']['uid']), array($offset, $this->page_num), 'oid,ono,onum,uid,otime,nid,omoney', $count);
		if(!empty($qcms['rs'])){
			foreach($qcms['rs'] as $key => $val)
			{
				$nid[$val['nid']] = $val['nid'];
			}
			$qcms['news_arr'] = $news_obj->select(array('nid' => $nid), '', '*', '', 'nid');
			$qcms['count'] = empty($count[0]['count']) ? 0 : $count[0]['count'];
		}		
		$this->load_php('user/order', $qcms);
	}
	
	public function money()
	{
		$result = $this->_user_obj->select(array('uid' => $_COOKIE['user']['uid']));
		$qcms['money'] = $result[0]['money'];
		$this->load_php('user/money', $qcms);
	}
	
	public function password()
	{
		if(!empty($_POST))
		{
			if($_POST['password'] != $_POST['password2'])
			{
				exec_script('alert("'.$this->p_lang['password'].$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
			}
			$result = $this->_user_obj->update(array('password' => md5($_POST['password'])), array('uid' => $_COOKIE['user']['uid']));
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				$this->p_logout();
				exec_script('window.location.href = "'.url(array('user', 'index')).'";');return;
			}
		}
		$this->load_php('user/password');
	}
	
	public function cart()
	{
		$order_obj = $this->load_model("Q_Order");
		if(!empty($_POST))
		{
			$user_rs = $this->_user_obj->select(array('uid' => $_COOKIE['user']['uid']));
			$money = $user_rs[0]['money'];
			if($money < $_POST['toall'])
			{
				exec_script('alert("'.$this->p_lang['money'].$this->p_lang['short'].'!");history.back();');return ;
			}
			$money = $money - $_POST['toall'];
			foreach($_POST['nid'] as $key => $val)
			{
				$order_obj->insert(array('onum' => $_POST['num'][$key], 'ono' => uniqid('qcms'.rand(100,999)), 'uid' => $_COOKIE['user']['uid'], 'otime' => date('Y-m-d H:i:s'), 'flag' => 1, 'nid' => $_POST['nid'][$key], 'ol' => $this->lid));
			}
			$result = $this->_user_obj->update(array('money' => $money), array('uid' => $_COOKIE['user']['uid']));
			foreach ($_COOKIE['cart'] as $key => $val)
			{
				setcookie("cart[".$key."]", '', time(), "/");
			}
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['buy'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url('home', 'index').'";');return;
			}

			return;
		}
		if(!empty($_GET['id']))
		{
			setcookie ("cart[".$_GET['id']."]", $_GET['id'], time() + 86400, "/");
			exec_script('window.location.href = "'.url('user', 'cart').'";');return;
		}
		if(isset($_GET['clear']))
		{
			if(empty($_GET['clear']))
			{
				foreach ($_COOKIE['cart'] as $key => $val)
				{
					setcookie("cart[".$key."]", '', time(), "/");
				}
			}
			else
			{
				setcookie("cart[".$_GET['clear']."]", '', time(), "/");
			}			
			exec_script('window.location.href = "'.url('user', 'cart').'";');return;
		}
		if(empty($_COOKIE['cart']))
		{
			exec_script('alert("'.$this->p_lang['cart'].$this->p_lang['isnull'].'!");history.back();');return ;
			return;
		}
		$qcms['cart_arr'] = $_COOKIE['cart'];
		$news_obj = $this->load_model("Q_News");
		$cond_arr = array();
		foreach ($_COOKIE['cart'] as $key => $val)
		{
			$cond_arr[] = $key;
		}
		$qcms['news_rs'] = $news_obj->select(array('nid' => $cond_arr), '', 'nid,ntitle,nfield', 0, 'nid');
		$this->load_php('user/cart', $qcms);
	}	
	
	public function header()
	{
		$cate_obj = $this->load_model("Q_Cate");
		$rs = $cate_obj->select(array('con' => '1', 'pcid' => 0), '', '*', 0, 0, array('csort' => 'ASC', 'cid' => 'ASC'));
		return $rs;
	}	
	
	private function _user_login()
	{
		if(empty($_COOKIE['user']['username']) || empty($_COOKIE['user']['password']))
		{
			exec_script('window.top.location.href="'.SITEPATH.'"');exit();
		}
		$user_obj = self::load_model('Q_User');	
		$result = $user_obj->select(array('username' => $_COOKIE['user']['username'], 'password' => $_COOKIE['user']['password'], 'level' => $_COOKIE['user']['level']));
		if(!$result)
		{
			exec_script('window.top.location.href="'.SITEPATH.'"');exit();
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
	
}
?>