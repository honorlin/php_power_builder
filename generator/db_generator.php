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

    require_once'db_creator.php';

    class db_generator
    {
        
        
        // 可以指定各種資料欄位的資料表產生
        public function generator($table_name,$schema)
        {            
            $sql = db_creator::get_sql($table_name,$schema);
            
            global $db_worker;

            $db_worker->perform($sql);            
            
        }
        
        // 善活系統專用 '樣式01' 資料表產生
        public function generator_type01($table_name)
        {
            $schema["{$table_name}_id"] = 'bigint(20)';
            $schema["{$table_name}_class_id"] = 'int(11)';
            $schema["{$table_name}_title"] = 'varchar(200)';
            $schema["{$table_name}_content"] = 'varchar(5000)';
            $schema["{$table_name}_valid"] = 'int(11)';
            $schema["{$table_name}_cdate"] = 'datetime';
            $schema["{$table_name}_udate"] = 'datetime';
            
            $sql = db_creator::get_sql($table_name,$schema);
            
            global $db_worker;

            $db_worker->perform($sql);            
            
        }
        
        // 善活系統專用 '樣式02' 資料表產生
        public function generator_type02($table_name)
        {
            $schema["{$table_name}_id"] = 'bigint(20)';
            $schema["{$table_name}_title"] = 'varchar(200)';
            $schema["{$table_name}_seq"] = 'int(11)';
            $schema["{$table_name}_valid"] = 'int(11)';
            $schema["{$table_name}_cdate"] = 'datetime';
            $schema["{$table_name}_udate"] = 'datetime';
            
            $sql = db_creator::get_sql($table_name,$schema);
            
            global $db_worker;

            $db_worker->perform($sql);            
            
        }
        
        
        
        
    }
    
?>

