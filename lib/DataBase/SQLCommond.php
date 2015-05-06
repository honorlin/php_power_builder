<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'DBColType.php';
require 'SQLPreProcess.php';

class SQLCommond
{
     private $sql = null;
     private $DBColType= null;
     private $SQLPreprocess = null;
     
    
     public function __construct($sql,$db_Worker)
     {
        $this -> sql = $sql;        
        $this -> DBColType = new DBColType($db_Worker);
        $this -> SQLPreprocess = new SQLPreprocess();
     }
     
     public function AddWithValue($table,$Column,$parameter,$value)
     {
         $type = $this -> DBColType->TestTbColTye($table,$Column);
         $value = $this -> SQLPreprocess->PreProcess($value);
        
         
         if($type == "string")
         {
             $this->sql = str_replace($parameter,"'$value'" , $this->sql);          
         }
         else
         {
             $this->sql = str_replace($parameter, $value , $this->sql);              
         }
     }
     
     public function GetSql()
     {         
         return $this->sql;
     }
    
    
}



?>
