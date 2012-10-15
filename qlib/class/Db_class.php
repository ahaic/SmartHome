<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Db_class extends Db_base
{
	private $_db_config = '';
	public $db_obj = '';
	public $db_prefix = '';
	protected $p_table_name;
	function __construct()
	{
		 self::_db_driver();	
	}
	
	public function _db_driver()
	{
		static $sql_arr = array();		
		if(!file_exists(LIB."site/config.php"))
		{
			echo '<script>window.location.href="install/index.php";</script>';
			exit();
		}
		$this->_db_config = require LIB."site/config.php";
		if(file_exists(LIB.'db/'.$this->_db_config['qcms']['db_driver'].EXT))
		{		
			if(!isset($sql_arr[$this->_db_config['qcms']['db_driver']]))
			{
				require LIB.'db/'.$this->_db_config['qcms']['db_driver'].EXT;
			}				
			$this->db_obj = new $this->_db_config['qcms']['db_driver']($this->_db_config);	
			$this->db_prefix = $this->_db_config['qcms']['db_prefix'];
			$sql_arr[$this->_db_config['qcms']['db_driver']] = $this->_db_config['qcms']['db_driver'];
			$this->db_driver = $this->_db_config['qcms']['db_driver'];
			return;
		}
		else
		{
			msg('db_driver : '.$this->_db_config['qcms']['db_driver'].' err');
			return;
		}
	
	}
	
	public function exec_select($cond_arr=array(), $field='*', $tb_name = 0,  $index = 0, $limit = '', $sort='', $fetch = 0)
	{
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		if(is_array($limit)){
			$limit_str = empty($limit) ? '' : ' limit '.$limit[0].','.$limit[1].'';
		}else{
			$limit_str = $limit;
		}		
		$sort_str = $this->sort($sort);
		$sql = "SELECT ".$field." FROM ".$this->_db_config['qcms']['db_prefix'].$this->p_table_name[$tb_name].$this->get_sql_cond($cond_arr).$sort_str.$limit_str."";
		if($fetch == 1)
		{
			return $this->db_obj->select($sql, 1);
		}
		if(empty($index))
		{
			return $this->db_obj->select($sql);
		}
		else
		{
			return $this->set_index($this->db_obj->select($sql), $index);
		}
	}
	
	public function exec_insert($insert_arr = array(), $tb_name = 0)
	{
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		$value_str = parent::get_sql_insert($insert_arr);
		$sql = "INSERT INTO ".$this->_db_config['qcms']['db_prefix'].$this->p_table_name[$tb_name].$value_str."";
		return $this->db_obj->exec($sql);
	}
	
	public function exec_update($update_arr = array(), $cond_arr = array(), $tb_name = 0)
	{
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		$update_str = parent::get_sql_update($update_arr);
		$cond_str = parent::get_sql_cond($cond_arr);
		$sql = "UPDATE ".$this->_db_config['qcms']['db_prefix'].$this->p_table_name[$tb_name]." SET ".$update_str.$cond_str."";
		return $this->db_obj->exec($sql);
	}
	
	public function exec_del($cond_arr = array(), $tb_name = 0)
	{
		$sql = "DELETE FROM ".$this->_db_config['qcms']['db_prefix'].$this->p_table_name[$tb_name].parent::get_sql_cond($cond_arr)."";
		return $this->db_obj->exec($sql);
	}
	
	public function search($str)
	{
		$sql = "SELECT * FROM ".$this->_db_config['qcms']['db_prefix']."news WHERE ntitle like '%".$str."%'" ;
		return $this->db_obj->select($sql);
	}
	
	public function sql_bakup()
	{
		return $this->db_obj->bakout();		
	}
	
	public function sql_bakin($no)
	{
		return $this->db_obj->bakin($no);
	}
}
?>