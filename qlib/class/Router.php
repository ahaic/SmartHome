<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Router
{
	private static $s_url = '/';
	private $_default;
	private static $s_instance;	
	
	function __construct()
	{
		self::view_controller();
	}

	public static function get_instance()
	{
		if (null === self::$s_instance)
		{
			self::$s_instance = new self();
		}
		return self::$s_instance;
	}
	
	private function _parse_request_uri()
	{
		return str_replace(SITEPATH, '/', $_GET['q']);
	} 
	
	private function _fetch_url()
	{
		$url = '';
		$controller_arr = array();
		$url_arr = explode('.', self::_parse_request_uri());
		$uri = $url_arr[0];
		if($uri == FALSE)
		{				
			$controller_arr['name'] = 'home';
			$controller_arr['url'] = BASEPATH.'controller/home'.EXT;
			$controller_arr['method'] = 'index';			
		}
		else
		{			
			$uri_arr = explode(self::$s_url, $uri);	
			$uri_arr_temp = array();
			$temp_uri_arr = array();
			foreach ($uri_arr as $v){
				if(!empty($v)){
					$temp_uri_arr[] = $v;
				}
			}
			$uri_arr = $temp_uri_arr;
			if(!in_array($uri_arr[0], array('home', 'admin', 'plus', 'user'))){
				$uri_arr_temp[0] = 'home';
				$j = 1;
				for($i=0;$i<=count($uri_arr);$i++){
					if(!empty($uri_arr[$i])){
						$uri_arr_temp[$j] = $uri_arr[($j-1)];
						$j++;
					}					
				}				
				$uri_arr = $uri_arr_temp;
				$uri = implode(self::$s_url, $uri_arr);
			}
			foreach($uri_arr as $key => $val)
			{			 
				$file = $url.$val;					
				$url .= $val.'/';
				if(file_exists(BASEPATH.'controller/'.$file.EXT))
				{			
					$controller_arr['name'] = $val;
					$controller_arr['url'] = BASEPATH.'controller/'.$file.EXT;
					$fun_url = substr($uri, strlen($file)+1);	
					$fun_arr = explode(self::$s_url, $fun_url);	
					$controller_arr['method'] = empty($fun_arr[0]) ? 'index' : $fun_arr[0];
					$controller_arr['fun_arr'] = array_splice($fun_arr, 1); 				
					break;
				}
			}
		}	
		//var_dump($controller_arr);exit;	
		return $controller_arr;
	}
	
	private function view_controller()
	{
		$class = '';
		$controller_arr = self::_fetch_url();
		if(empty($controller_arr))
		{
			$controller_arr = array('name' => 'home', 'url' => 'system/controller/home.php', 'method' => 'err');			
			//return;
		}		
		require $controller_arr['url'];
		if(method_exists($controller_arr['name'], $controller_arr['method']))
		{
			Base::insert_func_array($controller_arr);
		}
		else
		{
			$controller_arr = array('name' => 'home', 'url' => 'system/controller//home.php', 'method' => 'err');	
			Base::insert_func_array($controller_arr);
			return;
		}
	}
}