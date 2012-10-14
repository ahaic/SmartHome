<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temp extends Temp_base
{
	public $sitepath;	
	function __construct(){
		$this->load_config();
		if(empty($this->p_site['mode'])){
			$this->sitepath = 'index.php?q=';
		}else{
			$this->sitepath = SITEPATH;
		}
		$this->p_skin = BASEPATH.'view/home/'.$this->p_site['tempdir'].'/';
		$this->p_skin_img = SITEPATH.'static/temp/'.$this->p_site['tempdir'].'/';
	}
	public function index($temp, $type=0)
	{
		$str = self::_tempView($temp);
		if($type == 1)
		{
			return $str;
		}
		echo $str;
		return;
	}
	
	public function other($temp, $type)
	{
		$str = self::_tempView($temp, 4);
		if($type == 1)
		{
			return $str;
		}
		echo $str;
		return;
	}
	
	public function cate($temp)
	{				
		echo self::_tempView($temp, 1);
		return;
	}
	
	public function view($temp)
	{		
		echo self::_tempView($temp, 2);
		return;
	}
	
	public function diy($temp){
		echo self::_tempView($temp, 3);
		return;
	}
	
	public function search($temp){
		echo self::_tempView($temp, 4);
		return;
	}
	
	private function _tempView($temp, $type = '0'){
		
		$str = $this->temp_include($temp);
		$str = $this->temp_common($str);
		switch($type){
			case 1:
				$str = $this->temp_cate($str);
				$str = self::temp_copyright($str, 0);
				break;
			case 2:
				$str = $this->temp_view($str);
				$str = self::temp_copyright($str, 0);
				break;
			case 3:
				$str = $this->temp_diy($str);
				$str = self::temp_copyright($str, 0);
				break;
			case 4:
				$str = $this->temp_search($str);
				$str = self::temp_copyright($str, 0);
				break;
			case 4:
				$str = $this->temp_index($str);
				$str = self::temp_copyright($str, 0);
				break;
			default:
				$str = $this->temp_index($str);
				$str = self::temp_copyright($str, 1);
				break;
		}	
		$str = $this->temp_tag($str);
		$str = $this->temp_menu($str);
		$str = $this->temp_class($str);
		$str = $this->temp_list($str);
		$str = $this->temp_loop($str);
		$str = $this->temp_table($str);
		$str = $this->temp_global($str);
		$str = str_replace(array('@{@', '@}@'), array('{', '}'), $str);
		$str = $this->temp_module($str);
		$str = $this->temp_pic($str);
		return $this->temp_php($str);		
	}
}
?>