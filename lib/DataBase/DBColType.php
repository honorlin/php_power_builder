<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class DBColtype
{
    private $db_worker = null;
    
    public function __construct($db_worker)
    {
        $this->db_worker =$db_worker;
                
    }
    
    
      // get the column type of db table
    public function GetTbColType($table,$col)
    {
            
        $dd = $this -> db_worker -> perform("SHOW FIELDS FROM " . $table);
				
	$row_type;//欄位的格式
			
        while ($row = mysql_fetch_array($dd)) {

            if($row['Field'] == $col)	
            {
                $row_type = $row['Type'];
                break;
            }
        }
        
        return $row_type;
    }
    
    //  test the column type is int or char
    public function TestTbColTye($table,$col)
    {
        
        $row_type = $this->GetTbColType($table,$col);
        
        $row_type = strtolower($row_type);
        
        if(strpos($row_type,"varchar") !== false || strpos($row_type,"text") !== false )
	{	      
            return "string"; 
	}
	else
        {             
           
             return "integer";
	}     
        
    }
    
    
    
}


?>
