<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plus extends Base
{	
	public function index()
	{
		if(empty($_GET['p']))
		{
			exec_script('alert("plus lost !");history.back();');return ;
		}
		if(!is_dir('plus/'.$_GET['p'].'/'))
		{
			echo 'plus/'.$_GET['p'].'/ lost';
			return;
		}
		$act = empty($_GET['act']) ? 'index.php' : $_GET['act'].EXT;
		require 'plus/'.$_GET['p'].'/'.$act;
		
	}
	
	public function return_address()
	{
	
	}

	public function test()
	{
		$this->load_php('home/pay');
	}
	
}
?>