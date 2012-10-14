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
	public $plusArr;
	public $temp_arr = array();
	
	public function load_config()
	{		
		if(IS_SINA_APP){
			$s = isSInaApp();
			$this->p_site = unser_str($s->read( SINA_APP_DOMAIN , 'config.qcms')) ;
			if(empty($this->p_site)){
				$config = array (
					  'webname' => 'QCMS网站管理系统',
					  'keyword' => 'QCMS,网站,管理,系统',
					  'email' => 'qesy@163.com',
					  'icp' => 'copyright',
					  'cache_time' => '0',
					  'code' => 'qcms',
					  'tempdir' => 'default',
					  'infolen' => '100',
					  'time_zone' => '-8',
					  'connect' => '274266bde8a19975d5296a51fc12f499',
					  'veri' => '1',
					  'language' => 'cn',
					  'mode' => '0',
					  'logo' => '/static/images/logo.jpg',
					  'file_input' => '',
					  'info' => '       成立于1985年的上海大众汽车有限公司（以下简称上海大众）是一家中德合资企业，中德双方投资比例为：上海汽车集团股份有限公司50%，德国大众汽车集团40%、大众汽车（中国）投资有限公司10%。经过多年的发展，目前已经形成了以上海安亭为总部，辐射上海安亭和南京的两大生产基地。<br>        上海大众是国内规模最大的现代化轿车生产基地之一。基于大众汽车、斯柯达两大品牌，公司目前拥有帕萨特、波罗、途安、LAVIDA朗逸、TIGUAN途观和Octavia明锐、Fabia晶锐、Superb昊锐等十大系列产品，覆盖A0级、A级、B级、SUV等不同细分市场。<br>
					       成熟而有口皆碑的大众汽车品牌不仅引入了制造精良、个性突出的多款车型，而且针对中国道路特点与中国消费者审美需求，对系列车型进行了出色的本土化设计与调校，完美的融入了中国本土市场。<br>',
					  'count' => 'QCMS网站管理系统',
					);
				$result = $s->write(SINA_APP_DOMAIN, 'config.qcms', serialize($config));
				$userObj = $this->load_model('Q_User');
				$result = $userObj->sql_bakin('qcms_database');
				$userObj->insert(array('admin' => 'admin', 'password' => '21232f297a57a5a743894a0e4a801fc3', 'level' => 1));
				if(!$result){
					exec_script('alert("err !");window.location.href = "'.url(array('home', 'index')).'";');
				}
				else{
					file_put_contents('lock.txt', '');
					exec_script('alert("ok !");window.location.href = "'.url(array('home', 'index')).'";');
					return;
				}				
			}
			$this->p_lang = require LIB.'language/'.$this->p_site['language'].EXT;
			date_default_timezone_set('Etc/GMT'.$this->p_site['time_zone']);
		}else{
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
		if(!empty($model_arr[$model])){
			return $model_arr[$model];
		}		
		if(file_exists(BASEPATH.'model/'.$model.EXT)){
			require BASEPATH.'model/'.$model.EXT;
			$model_arr[$model] = new $model();
			return $model_arr[$model];
		}else{
			msg('Model : '.$model.' err !');
			return;
		}
		
	}
	
	public function load_php($view,$data='')
	{
		if(!empty($data)){
			$this->temp_arr = $data;						
		}
		foreach ($this->temp_arr as $key=>$val){
				$$key = $val;
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
	
	protected function p_login($result, $type = 0)
	{
		$userTye = empty($type) ? 'user' : 'admin';
		setcookie ($userTye.'[uid]', $result[0]["uid"], time() + 31536000, "/");
		setcookie ($userTye.'[username]', $result[0]["username"], time() + 31536000, "/");
		setcookie ($userTye.'[password]', $result[0]["password"], time() + 31536000, "/");
		setcookie ($userTye.'[level]', $result[0]["level"], time() + 31536000, "/");
		return;
	}
	
	protected function p_logout()
	{
		setcookie ("user[uid]", '', time(), "/");
		setcookie ("user[username]", '', time(), "/");
		setcookie ("user[password]", '', time(), "/");
		setcookie ("user[level]", '', time(), "/");
		setcookie ("admin[uid]", '', time(), "/");
		setcookie ("admin[username]", '', time(), "/");
		setcookie ("admin[password]", '', time(), "/");
		setcookie ("admin[level]", '', time(), "/");
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
		$class->plusArr = $this->plusArr;
		call_user_func_array(array($class, $method), $action);
	}
}
?>