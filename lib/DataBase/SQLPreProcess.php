<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SQLPreProcess
{
    
    public function __construct()
    {
        
    }
    
    public function PreProcess($data)
    {
        
       // $data = mysql_real_escape_string($data);
        
        $data = str_replace("'", "\'", $data);
        
        return $data;
        
    }
}






?>
