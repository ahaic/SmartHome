<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload
{
	private $_type = array('jpg', 'png', 'swf', 'gif', 'pjpeg', 'x-png');
	private $_size = 200;
	private $_dir;
	private $_name;
	function __construct()
	{
		$this->_name =  'qcms'.uniqid(rand(100,999));
		$this->_dir = 'static/upload/'.date('Ym').'/';
	}
	public function upload_file($file_arr)
	{
		$type = explode('/', $file_arr['type']);
		$ext =  substr(strrchr($file_arr['name'], '.'), 1); 
		if(!is_uploaded_file($file_arr['tmp_name']) || !in_array($ext, $this->_type))
		{
			return 1;
		}
		if($file_arr['size'] > ($this->_size * 1024))
		{
			return 2;
		}
		if(IS_SINA_APP){
			$s = isSInaApp();
			return $s->upload(SINA_APP_DOMAIN, $this->_dir.$this->_name.'.'.$ext, $file_arr['tmp_name']);
		}else{
			return self::_move_file($file_arr['tmp_name'], $ext);
		}		
	}
	
	private function _move_file($file, $ext)
	{
		$url = $this->_dir.$this->_name.'.'.$ext;
		if(!is_dir($this->_dir))
		{
			mkdir($this->_dir, 0777);
		}
		if (!move_uploaded_file($file, $url))
		{
			return 3;
		}
		return '/'.$url;
	}
}
?>