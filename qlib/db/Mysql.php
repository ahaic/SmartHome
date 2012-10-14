<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mysql
{
	private $_db_config;
	private $_j;
	private $_dir;
	private $_sql_name;
	private $_size;
	public static $s_db_connection;

	function __construct($db_config)
	{
		$this->_db_config = $db_config;
		$this->connection();
	}
		
	public function connection()
	{
		if(isset(self::$s_db_connection))
		{
			return;
		}
		self::$s_db_connection = @mysql_connect(
						$this->_db_config['qcms']['host'].':'.$this->_db_config['qcms']['db_port'],
						$this->_db_config['qcms']['username'],
						$this->_db_config['qcms']['password']);
		if(!self::$s_db_connection)
		{
			msg('DB : '.$this->_db_config['qcms']['db_name'].' err .<br>');return;
		}
		mysql_select_db($this->_db_config['qcms']['db_name'], self::$s_db_connection);
		mysql_query("set names utf8"); 		
		return;
	}
	
	public function select($sql, $fetch = 0)
	{			
		$ls = array();
		$result = @mysql_query($sql);
		if($fetch == 1)
		{
			return mysql_fetch_array($result);
			return;
		}	
		if(empty($result))
		{
			return FALSE;
		}
		while(($rs = mysql_fetch_array($result, MYSQL_ASSOC)) != FALSE)
		{
			$ls[] = $rs;
		}
		return $ls;
	}
	
	public function exec($sql)
	{		
		return mysql_query($sql);
	}
	/************backup******************/
	public function bakout()
	{
		$this->_j = 1;		
		$this->_sql_name = date('YmdHis');
		$this->_dir = 'static/backup/'.$this->_sql_name.'/';
		$this->_size = 1024 * 1024;
	    $result = self::get_table();
		if(!mkdir($this->_dir, 0777))
		{
			return FALSE;
		}
		if(!is_dir($this->_dir) || !is_writable($this->_dir))
		{
			return FALSE;
		}	 
   		for ($i = 0; $i < mysql_num_rows($result); $i++)
		{	
			$table = mysql_tablename($result,$i);
			self::_table2sql($table);
		}	
		for ($i = 0; $i < mysql_num_rows($result); $i++)
		{	
			$table = mysql_tablename($result,$i);
			self::_data2sql($table);   
		}
   		return TRUE;
	}
	
	public function get_table()
	{
		return mysql_list_tables($this->_db_config['qcms']['db_name']); 		    	
	}
	
	private function _table2sql($table)
	{
		$tabledump = "DROP TABLE IF EXISTS ".$table.";\n";
		$query = mysql_query("SHOW CREATE TABLE ".$table);
		$rows = mysql_fetch_array($query);
		$oldumask=umask(0);
		$sql_str=fopen($this->_dir.$this->_sql_name.'_'.$this->_j.'.sql',"a") or die("die");   
		fwrite($sql_str,str_replace($this->_db_config['qcms']['db_prefix'], '{qcms}_', $rows[1]).";\n\n");   
		fclose($sql_str);
		umask($oldumask);
		clearstatcache();
        if(filesize($this->_dir.$this->_sql_name.'_'.$this->_j.'.sql') > $this->_size)
		{
			$this->_j = $this->_j + 1;				
		}
		return TRUE;
	}
	
	private function _data2sql($table)
	  {
	    $fields = mysql_list_fields($this->_db_config['qcms']['db_name'],$table);
	    $num=mysql_num_fields($fields); 
	    $exec="select * from $table";
	    $result=mysql_query($exec);
	    while(($rs = mysql_fetch_array($result)) != false)
	      {
	        $aa='';			
		    for($i=0;$i<$num-1;$i++)
	          {
		        $aa.="'".$rs[$i]."',";
		      }    
			
			$oldumask=umask(0);
			$sql_str=fopen($this->_dir.$this->_sql_name.'_'.$this->_j.'.sql',"a") or die("die");   
			fwrite($sql_str,"INSERT INTO ".$table_pre = str_replace($this->_db_config['qcms']['db_prefix'], '{qcms}_', $table)." VALUES (".$aa."'".$rs[$num-1]."');\n");   
			fclose($sql_str);
			umask($oldumask);
			clearstatcache();
	        if(filesize($this->_dir.$this->_sql_name.'_'.$this->_j.'.sql') > $this->_size)
			{
				$this->_j = $this->_j + 1;				
			}
	      }
	    return TRUE;
	  }
	
	
	public function bakin($no = '', $id = 1)
	{
		$query = '';
		$this->_dir = 'static/backup/';
		if(!file_exists($this->_dir.$no.'/'.$no.'_'.$id.'.sql'))
		{
			return FALSE;
		}
		$result = file($this->_dir.$no.'/'.$no.'_'.$id.'.sql');
		foreach($result as $key => $value)
		{
			$value=trim($value);
			if(!$value || $value[0]=='#') continue;
			if(eregi("\;$",$value))
			{
				$query.=$value;
				if(eregi("^CREATE",$query))
				{
					$extra = substr(strrchr($query,')'),1);
					$query = str_replace($extra,'',$query);
					$extra = "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
					$query .= $extra;
				}
				elseif(eregi("^INSERT",$query))
				{
					$query='REPLACE '.substr($query,6);
				}
				$query = str_replace('{qcms}_', $this->_db_config['qcms']['db_prefix'], $query);								
				mysql_query($query);				
				$query='';
			} 
			else
			{
				$query.= $value;
			}
	
		}
		if(file_exists($this->_dir.$no.'/'.$no.'_'.($id+1).'.sql'))
		{
			$this->bakin($no, ($id+1));			
		}
		return true;
	}
}
?>