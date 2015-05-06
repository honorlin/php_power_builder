<?php
/*
 * 
 * 
 *  modify:2012/10/09 by Ten.
 * 
 * 
 * 
 */

	interface Db_Connecter {

		public function perform($sql);
   
	}

        class db_worker
	{
		private $db_c;
	
	        public function __construct($db_c)
		{
			$this -> db_c = $db_c;
		}
	
		
		public function perform($sql)
		{
			return $this -> db_c -> perform($sql);
		}
	
		public function get_value_big5($table,$conditions,$get_column)
		{
			$result = $this -> db_c -> perform('SELECT * FROM ' . $table . ' Where ' . $conditions);
			
			if (mysql_num_rows($result) > 0)
			 	return iconv("UTF-8","big5",mysql_result($result,0,$get_column));
			 else
			 	return null;			 	
		}
		
		public function get_value_utf8($table,$conditions,$get_column)
		{
			$result = $this -> db_c -> perform('SELECT * FROM ' . $table . ' Where ' . $conditions);
			
			if (mysql_num_rows($result) > 0)
			 	return mysql_result($result,0,$get_column);
			 else
			 	return null;			 	
		}
		
		public function get_table($table,$conditions)
		{
			$result = $this -> db_c -> perform('SELECT * FROM ' . $table . ' Where ' . $conditions);
			return $result;
		}
		
		public function getInsertID()
		{
			return $this -> db_c -> getInsertID();
		}	
	}
	
	
	
	class MySql_Worker implements Db_Connecter
	{	
                private $server;
                private $user;
                private $passwd;
                private $link;
                private $db_name;
                private $insert_id;
		
	        public function __construct($server,$user,$passwd,$db_name)
		{
			$this -> server = $server;
			$this -> user =  $user;
			$this -> passwd = $passwd;
			$this -> db_name = $db_name;
		}
		
		public function perform($sql)
		{
                      //  echo $sql;
                    
                        $this -> insert_id = null;
                    
			$this -> link = mysql_connect($this -> server, $this -> user , $this -> passwd)
				or die('無法連接：錯誤原因'. mysql_error());
		
			mysql_query("SET NAMES utf8", $this -> link);
			mysql_select_db($this -> db_name) or die('找不到此資料庫');

			$result = mysql_query($sql) or die('指令錯誤:錯誤原因'.mysql_error() . "<p>$sql</p>");
			
			if(strrpos(strtolower($sql),"insert")>=0)
			{			
                            $this -> insert_id = mysql_insert_id();			
			}
			
			
			mysql_close($this -> link); 
			
			return $result;
			
			
		}
		
		public function getInsertID()
		{
			return $this -> insert_id;
		}		
		
	}

?>
