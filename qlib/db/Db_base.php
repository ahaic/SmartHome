<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
abstract class Db_base
{
	public $db_driver;
	public function get_sql_insert($insert_arr = array())
	{
		$insert_str = '';
		$value_str = '';
		if(is_array($insert_arr))
		{
			foreach($insert_arr as $key => $val)
			{
				$insert_str .= $key.',';
				if($this->db_driver == 'Mysql')
				{
					$value_str .= "'".$val."',";
				}
				elseif($this->db_driver == 'DB_Pdo')
				{
					$value_str .= "'".$val."',";
				}
				
			}
			return " (".substr($insert_str, 0, -1).") values (".substr($value_str, 0, -1).")";
		}		
	}
	
	public function get_sql_cond($cond_arr = array())
	{
		if(empty($cond_arr))
		{
			return;
		}
		$sql = '';
		$cond_str = '';
		foreach($cond_arr as $key => $val)
		{
			if(is_array($val))
			{
				foreach($val as $k => $v)
				{
					if($this->db_driver == 'Mysql')
					{
						$cond_str .= addslashes($v).',';
					}
					elseif($this->db_driver == 'DB_Pdo')
					{
						$cond_str .= addslashes($v).',';
					}					
				}
				$sql .= $key." IN (".substr($cond_str, 0, -1).") AND ";
			}
			else
			{
				if($this->db_driver == 'Mysql')
				{
					$sql .= $key." = '".addslashes($val)."' AND ";
				}
				elseif($this->db_driver == 'DB_Pdo')
				{
					$sql .= $key." = '".addslashes($val)."' AND ";
				}				
			}
			
		}		
		return ' WHERE '.substr($sql, 0, -5);
	}
	
	public function get_sql_update($update_arr = array())
	{
		$sql = '';
		if(!is_array($update_arr))
		{
			return $update_arr;
		}
		foreach($update_arr as $key => $val)
		{
			if($this->db_driver == 'Mysql')
			{
				$sql .= $key." = '".$val."',";
			}
			elseif($this->db_driver == 'DB_Pdo')
			{
				$sql .= $key." = '".$val."',";
			}
			
		}
		return substr($sql, 0, -1);
	}
	
	public static function set_index($arr, $key)
	{
		if(empty($arr)){
			return $arr;
		}
		$temp = array();
		foreach($arr as $val)
		{
			if (!isset($val[$key]))
			{
				return $arr;
			}
			$temp[$val[$key]] = $val;
		}
		return $temp;
	}
	
	public static function sort($sort)
	{
		$sort_str = '';
		if(is_array($sort))
		{
			foreach($sort as $key => $val)
			{
				$sort_str .= $key.' '.$val.',';
			}
			return ' ORDER BY '.substr($sort_str, 0, -1);
		}
		else
		{
			return ' '.$sort;
		}
	}
	
	public function __destruct()
	{
		$this->_pdo_obj = NULL;
	}
}
?>