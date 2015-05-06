<?php

    /*
     * @名稱：DB 產生器 (操作頁)
     * @編寫：林廷鴻
     * @日期：2013/01/21
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

     class db_creator{
         
         public function get_sql($db_name,$db_schema)
         {
             $sql = "CREATE TABLE IF NOT EXISTS `$db_name` (";
             
             $index = 0;
             $primarykey = "";
             foreach ($db_schema as $k => $v)
             {
                 $sql .= "`$k` $v";
                 
                 if(strpos($v,"varchar") !== false)
                 {
                    $sql .= " CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                 }
                 
                 $sql .= " NOT NULL";
                 
                 if($index == 0){ 
                    $primarykey = $k;
                    $sql .= ' AUTO_INCREMENT';
                 }
                  $sql .= ',';
                 
                 $index++;
             }
             
              $sql .= "PRIMARY KEY (`$primarykey`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1" ;
             
              return $sql;
         }   

     }
?>
