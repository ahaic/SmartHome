<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DB_Pdo
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
		try
		{
			self::$s_db_connection = new PDO('sqlite:'.LIB.$this->_db_config['qcms']['db_name'].'.db3');
		}
		catch (PDOException $e) 
		{
    		echo 'Connection failed: ' . $e->getMessage();
		}				
		return;
	}
	
	public function select($sql, $fetch = 0)
	{			
		$ls = array();
		$result = self::$s_db_connection->query($sql);
		if($fetch == 1)
		{
			$rs = $result->fetch(PDO::FETCH_ASSOC);
		}else{
			$rs = $result->fetchAll(PDO::FETCH_ASSOC);
		}		
		return $rs;
	}
	
	public function exec($sql)
	{
		return self::$s_db_connection->exec($sql);
	}
}
?>