<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class links_module extends Base{
	public $p_module;
	function __construct(){
		self::load_config();
		$this->p_module = 'links';
	}
	public function index($id = 0){		
		parent::hava_cookie();
		$file = self::_get();		
		$linksArr = empty($file) ? array() : @unserialize(self::_get());
		if(!empty($_POST)){
			if($_POST['act'] == 'add'){
				$linksArr[] = array($_POST['name'], $_POST['link']);
				$linksStr = serialize($linksArr);
				$result = self::_save($linksStr);
				if($result){
					exec_script('window.location.href="'.url(array('admin', 'callback', $this->p_module, 'index')).'";');
				}else{
					exec_script('history.back();');
				}
				return;
			}
			if($_POST['act'] == 'edit'){
				$linksArr[$_POST['id']] = array($_POST['name'], $_POST['link']);
				$linksStr = serialize($linksArr);
				$result = self::_save($linksStr);
				if($result){
					exec_script('window.location.href="'.url(array('admin', 'callback', $this->p_module, 'index')).'";');
				}else{
					exec_script('history.back();');
				}
				return;
			}
			if($_POST['act'] == 'del'){
				$linksArr_new = array();
				foreach($linksArr as $k => $v){
					if($k != $_POST['id']){
						$linksArr_new[] = $v;
					}
				}
				$linksStr = serialize($linksArr_new);
				$result = self::_save($linksStr);
				if($result){
					echo 1;
				}else{
					echo 0;
				}
				return;
			}
		}
		parent::module_view('index', array('linksArr' => $linksArr));
	}
	
	public function temp(){
		$tempStr = file_get_contents('module/'.$this->p_module.'/view/temp.html');
		$file = self::_get();
		$linksArr = empty($file) ? array() : @unserialize(self::_get());
		$str = '';
		foreach($linksArr as $k => $v){
			$str .= str_replace(array('{qcms:name}', '{qcms:link}'), array($v[0], $v[1]), $tempStr);
		}
		return $str;
	}
	
	private function _get(){
		$str = '';
		if(file_exists('module/'.$this->p_module.'/view/link.txt')){
			$str = file_get_contents('module/'.$this->p_module.'/view/link.txt');
		}
		return $str;
	}
	
	private function _save($str){
		return file_put_contents('module/'.$this->p_module.'/view/link.txt', $str);
	}
}