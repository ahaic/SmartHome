<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Base
{
	private $_temp;
	
	protected $p_site;
	protected $p_py_type = 0;
	protected $p_num = 15;
	protected $p_lang;
	protected $p_cid;
	protected $p_nid;
	protected $p_eid;
	protected $p_module;
	
	public function load_config()
	{		
		if(is_file(LIB.'config.qcms'))
		{
			$this->p_site = unser_str(file_get_contents(LIB.'config.qcms'));
			$this->p_lang = require LIB.'language/'.$this->p_site['language'].EXT;
			date_default_timezone_set('Etc/GMT'.$this->p_site['time_zone']); 
		}else{
			echo 'SYS ERROR!';
			exit();
		}	
		return $this->p_site;
	}
	
	public function load_view($temp, $type = 'index')
	{
		$this->_temp = new Temp();			
		switch ($type){
			case 'cate':
				$this->_temp->p_cid = $this->p_cid;
				break;
			case 'view':
				$this->_temp->p_nid = $this->p_nid;
				break;
			case 'diy':
				$this->_temp->p_eid = $this->p_eid;
				break;
			default:
				break;
		}				
		if(file_exists(BASEPATH.'view/'.$temp.'.html'))
		{			
			$this->_temp->$type(file_get_contents(BASEPATH.'view/'.$temp.'.html'));
			if(empty($this->_temp->y)){
				while (true){					
				}
			}
			return;
		}
		else
		{
			msg('View : '.$temp.' err !');
			return;
		}		
	}
	
	public function load_model($model)
	{
		static $model_arr = '';
		if(!empty($model_arr[$model]))
		{
			return $model_arr[$model];
		}
		if(file_exists(BASEPATH.'model/'.$model.EXT))
		{
			require BASEPATH.'model/'.$model.EXT;
			$model_arr[$model] = new $model();
			return $model_arr[$model];
		}
		else
		{
			msg('Model : '.$model.' err !');
			return;
		}
	}
	
	public function load_php($view,$data='')
	{
		if(is_array($data))
		{
			foreach ($data as $key=>$val)
			{
				$$key = $val;
			}
		}				
		(file_exists(BASEPATH.'view/'.$view.EXT)) ? require BASEPATH.'view/'.$view.EXT : msg( BASEPATH.'view/'.$view.EXT.' fail');
	}
	
	public function module_view($view, $data=''){
		if(is_array($data))
		{
			foreach ($data as $key=>$val)
			{
				$$key = $val;
			}
		}				
		(file_exists('module/'.$this->p_module.'/view/'.$view.EXT)) ? require 'module/'.$this->p_module.'/view/'.$view.EXT : msg('module/'.$this->p_module.'/'.$view.EXT.' fail');
	}	
	
	public function load_css($str)
	{
		if(is_array($str))
		{
			foreach($str as $key=>$val)
			{
				echo "<link href='".CSS_PATH.$val.".css' rel='stylesheet' type='text/css' />";
			}
		}
		else 
		{
			echo "<link href='".CSS_PATH.$str.".css' rel='stylesheet' type='text/css' />";
		}
	}
	
	public function load_js($str)
	{
		if(is_array($str))
		{
			foreach($str as $key=>$val)
			{
				echo "<script type='text/javascript' charset='utf-8' src='".JS_PATH.$val.".js'></script>";
			}
		}
		else 
		{
			echo "<script type='text/javascript' charset='utf-8' src='".JS_PATH.$str.".js'></script>";
		}
	}
	
	public function load_form($post_arr)//0:name,1:type,2:value,3:width,4:chinese,5:height,6:isnull
	{
		$str = '';
		$js_str = '';
		$style = 'style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"';
		$i = 0;
		foreach ($post_arr as $key => $val)
		{
			$i += 1;
			$bg_color = ($i%2 == 1) ? '#f9f9f9' : '#ffffff';
			$value = ($val[2] == '') ? '' : $val[2];
			$height = empty($val[5]) ? '' : 'height:'.$val[5].'px;';
			$width = empty($val[3]) ? '' : 'width:'.$val[3].'px;';
			if($val[1] == 'text')
			{	
				if(empty($val[6]))
				{
					$js_str .= 'if ($("#'.$val[0].'").val() == ""){	alert ("'.$val[4].' is NUll");return false;}';
				}										
				$str .= '<tr bgcolor="'.$bg_color.'"><td '.$style.' width="200">'.$val[4].'</td><td '.$style.'><textarea name="'.$val[0].'" id="'.$val[0].'" style="'.$width.$height.'" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"/>'.$value.'</textarea></td></tr>';
			}
			elseif($val[1] == 'editor')
			{	
				if(empty($val[6]))
				{
					$js_str .= 'if ($("#'.$val[0].'").val() == ""){	alert ("'.$val[4].' is NUll");return false;}';
				}	
				$editor = 'tools:\'Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,SelectAll,Removeformat,Align,List,|,Link,Unlink,Img,Flash,Media,Table,|,Fontface,FontSize,|,Source\',upImgUrl:\''.url(array('admin', 'ajax_upload')).'\',upImgExt:\'jpg,jpeg,gif,png\'';						
				$str .= '<tr bgcolor="'.$bg_color.'"><td '.$style.' width="200">'.$val[4].'</td><td '.$style.'><textarea name="'.$val[0].'" id="'.$val[0].'" style="'.$width.$height.'" onBlur="this.className=\'kuang\'" class="xheditor {skin:\'nostyle\','.$editor.'}">'.$value.'</textarea></td></tr>';
			}
			elseif ($val[1] == 'select')
			{
				if(empty($val[6]))
				{
					$js_str .= 'if ($("#'.$val[0].'").val() == ""){	alert ("'.$val[4].' is NUll");return false;}';
				}	
				$select_str = '';
				foreach ($value as $nkey => $nval)
				{
					$select_str .= '<option value="'.$nval.'">'.$nkey.'</option>';
				}	
				$str .= '<tr bgcolor="'.$bg_color.'"><td '.$style.' width="200">'.$val[4].'</td><td '.$style.'><select name="'.$val[0].'" id="'.$val[0].'" style="'.$width.$height.'">'.$select_str.'</select></td></tr>';
			}
			else 
			{
				if(empty($val[6]))
				{
					$js_str .= 'if ($("#'.$val[0].'").val() == ""){	alert ("'.$val[4].' is NUll");return false;}';
				}				
				$str .= '<tr bgcolor="'.$bg_color.'"><td '.$style.' width="200">'.$val[4].'</td><td '.$style.'><input type="'.$val[1].'" name="'.$val[0].'" id="'.$val[0].'" value="'.$value.'" style="'.$width.$height.'" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"/></td></tr>';
			}
			
		}
		echo '<script>function form_onsubmit(){'.$js_str.'}</script>';
		echo '<form action="" method="post" name="form1" id="form1" onSubmit="return form_onsubmit()"><table class="table" width="100%" border="0" cellspacing="0">'.$str.'<tr><td colspan="2" align="center" '.$style.'><input type="submit" value="'.$this->p_lang['submit'].'" style="border:1px #000000 solid;vertical-align:middle;height:25px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="button2" id="button2" value="'.$this->p_lang['reset'].'" style="border:1px #000000 solid;vertical-align:middle;height:25px"/></td></tr></table></form>';
		return;
	}
	
	public function load_list($list_arr, $type, $link_arr, $append_arr = '', $select = 0, $from = 'admin')
	{
		if($select == 1){
			$cateObj = $this->load_model('Q_Cate');
			$cateArr = $cateObj->select('', '', 'cid,cname', 0, 'cid');
		}
		if(empty($list_arr))return;
		$str = '';
		$title = '';
		$title_arr = array();
		$i = 0;
		$style = 'style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"';
		$idArr = array();
		foreach($list_arr AS $key => $val)
		{
			$i += 1;
			$bg_color = ($i%2 == 1) ? '#ffffff' : '#f9f9f9';
			$str .= '<tr bgcolor="'.$bg_color.'">';
			$link_str = '';
			if(!empty($select)){
				$str .= '<td '.$style.'><input type="checkbox" id="nid_'.$val['nid'].'" value="'.$val['nid'].'" /></td>';
				$idArr[] = $val['nid'];
			}
			foreach ($val AS $skey => $sval)
			{			
				$title_str_ = '';	
				$title_arr[$skey] = $sval;					
				if($skey == 'type'){
					if($sval == 1){
						$str .= '<td '.$style.'><font color="red">'.$this->p_lang['hot'].'</font></td>';
					}elseif($sval == 2){
						$str .= '<td '.$style.'><font color="red">'.$this->p_lang['recommend'].'</font></td>';
					}else{
						$str .= '<td '.$style.'>'.$this->p_lang['no'].'</td>';
					}	
				}elseif($skey == 'outlink'){
					if(empty($sval)){
						$str .= '<td '.$style.'>'.$this->p_lang['no'].'</td>';
					}else{
						$str .= '<td '.$style.'><font color="red">'.$this->p_lang['outlink'].'</font></td>';
					}					
				}elseif($skey == 'ntitle'){
					$str .= '<td '.$style.'>'.$sval.'</td>';
				}elseif($skey == 'cid' && $select == 1){
					$str .= '<td '.$style.'><a href="'.url(array('admin', 'news')).'&cid='.$sval.'">'.$cateArr[$sval]['cname'].'</a></td>';
				}else{					
					$str .= '<td '.$style.'>'.$sval.'</td>';
				}
			}
			if(!empty($link_arr))
			{
				$edit_arr = array($from, $type.'_edit');
				$del_arr = array($from, $type.'_del');
				if(is_array($link_arr)){
					foreach($link_arr as $sval){
						$edit_arr[] = $val[$sval];
						$del_arr[] = $val[$sval];
					}					
				}else{
					$edit_arr[] = $link_arr;
					$del_arr[] = $link_arr;
				}
				$append = '';
				if(!empty($append_arr)){
					foreach($append_arr as $ak => $av){
						$append .= '<a href="'.url(array('admin', $av[0], $val[$av[2]])).'">'.$av[1].'</a> ';
					}					
				}
				$str .= '<td '.$style.'><a href="'.url($edit_arr).'">'.$this->p_lang['edit'].'</a> <a href="'.url($del_arr).'" onclick="return confirm(\'Confirm Delete ?\');">'.$this->p_lang['delete'].'</a> '.$append.'</td></tr>';
			}	
			else
			{
				$str .= '<td '.$style.'>&nbsp;&nbsp;</td></tr>';
			}		
		}		
		//-- title Start --
		$input_style = 'style="border:1px #000000 solid;vertical-align:middle;height:25px"';
		if(!empty($select)){
			$count = count($list_arr[0])+2;
			$str .= '<tr id="actionAll"><td '.$style.' colspan="'.$count.'" align="center"><input type="button" id="delAll" value="批量删除" '.$input_style.'/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="editAll" value="批量修改" '.$input_style.'/></td></tr>';
			$title .= '<td '.$style.'><input type="checkbox" id="select_all" onclick="selectAll()"/></td>';			
		}
		foreach($title_arr as $key => $val)
		{
			$title .= '<td '.$style.'>'.$this->p_lang[$key].'</td>';			
		}
		echo '<table class="table" width="100%" border="0" cellspacing="0">
		<tr bgcolor="'.$bg_color.'">'.$title.'<td '.$style.'>'.$this->p_lang['config'].'</td></tr>
		'.$str.'</table>';
		if(!empty($select)){
		echo '
		<script>
		var selectStarus = 0;
		var idJson = '.json_encode($idArr).';
		$(function(){
			$("#delAll").click(function(){
				selected = "";
				$.each(idJson, function(i, n){
					if($("#nid_"+n).attr(\'checked\') == true){
						selected += n+"|";
					}
				})
				window.location.href="'.url(array('admin', 'news_del',0,0)).'&act=1&id="+selected;
			})
			$("#editAll").click(function(){
				selected = "";
				$.each(idJson, function(i, n){
					if($("#nid_"+n).attr(\'checked\') == true){
						selected += n+"|";
					}
				})
				window.location.href="'.url(array('admin', 'news_edit_all',0,0)).'&act=1&id="+selected;
			})
		})
		function selectAll(){
			if(selectStarus == 0){
				selectStarus = 1;
			}else{
				selectStarus = 0;
			}			
			$.each(idJson, function(i, n){
				if(selectStarus == 1){
					$("#nid_"+n).attr(\'checked\', true);
				}else{
					$("#nid_"+n).attr(\'checked\', false);
				}
			})
		}
		</script>';
		}
		return;
	}
	
	public function post_verify($post_arr)
	{
		foreach ($post_arr as $key => $val)
		{
			if(empty($val[6]))
			{
				if($_POST[$val[0]] == '')
				{
					exec_script('alert("'.$val[4].' is NUll");history.back();');return FALSE;
				}
			}
			if($val[0] == 'password')
			{
				if(!empty($_POST[$val[0]]))
				{
					$str_arr[$val[0]] = md5($_POST[$val[0]]);
				}				
			}
			else
			{
				$str_arr[$val[0]] = stripslashes($_POST[$val[0]]);
			}			
		}
		return $str_arr;
	}
	
	public function fp_write($str, $url)
	{
		file_put_contents($url, $str);	
		return TRUE;				
	}
	
	protected function p_login($result)
	{
		setcookie ("user[uid]", $result[0]["uid"], time() + 31536000, "/");
		setcookie ("user[username]", $result[0]["username"], time() + 31536000, "/");
		setcookie ("user[password]", $result[0]["password"], time() + 31536000, "/");
		setcookie ("user[level]", $result[0]["level"], time() + 31536000, "/");
		return;
	}
	
	protected function p_logout()
	{
		setcookie ("user[uid]", '', time(), "/");
		setcookie ("user[username]", '', time(), "/");
		setcookie ("user[password]", '', time(), "/");
		setcookie ("user[level]", '', time(), "/");
		return ;
	}

	public function html_2_js($str)
	{
		$a=array('/"/','/\//',"/\r\n/",'/\'/');
		$b=array('\"','\/','','\\\'');
		$text=preg_replace($a, $b,$str);
		return $text;
		
	}
	
	public static function insert_func_array($controller_arr)
	{
		$fun_arr = isset($controller_arr['fun_arr']) ? $controller_arr['fun_arr'] : array();
		$clss = new $controller_arr['name']();
		call_user_func_array(array($clss, $controller_arr['method']), $fun_arr);
	}
	
	public function hava_cookie(){
		if($_COOKIE['user']['level'] != 1)die();
	}
	
	protected  function p_callback($name, $method = 'index', $action = ''){
		require 'module/'.$name.'/'.$name.'_module'.EXT;
		$m = $name.'_module';
		$class = new $m();
		call_user_func_array(array($class, $method), $action);
	}
}
?>