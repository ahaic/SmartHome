<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Q_Form extends Db_class
{
	protected $p_table_name = array('form', 'forminfo');
	
	public function select($cond_arr=array(), $field='*', $tb_name = 0,  $index = 0, $sort='', $limit = '', $fetch = 0)
	{
		return self::exec_select($cond_arr, $field, $tb_name,  $index, $limit, $sort, $fetch);
	}
	
	public function insert($insert_arr = array(), $tb_name = 0)
	{
		return self::exec_insert($insert_arr, $tb_name);
	}
	
	public function update($update_arr = array(), $cond_arr = array(), $tb_name = 0)
	{
		return self::exec_update($update_arr, $cond_arr, $tb_name);
	}
	
	public function del($cond_arr = array(), $tb_name = 0)
	{
		return self::exec_del($cond_arr, $tb_name);
	}
	
	public function select_all($cond_arr=array(), $limit = '', $field='*', &$count, $tb_name = 0,  $index = 0, $sort='', $fetch = 0)
	{
		$count = self::select($cond_arr, 'COUNT(*) AS count', $tb_name);
		$rs = self::select($cond_arr, $field, $tb_name, 0, array('id' => 'DESC'), $limit);		
		return $rs;
	}
}
?>