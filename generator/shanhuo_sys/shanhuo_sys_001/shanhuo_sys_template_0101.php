<?php ob_start()?>
<?php
    /* @系統：iweb
     * @名稱：@SYSNAME管理 (清單頁)
     * @編寫：林廷鴻
     * @日期：@CREATEDATE
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
?>
<?php 

        session_start(); 
	
	require 'common.php';
        
        

?>
<?php

    // 本物件使用的資料表
    
    $db_table = "@SYSDBNAME";
    
    // 使用者搜尋的項目
    
    $search_item = array(
        "@SYSNAME名稱","@SYSNAME分類"
    );
    
    // 使用者排序的項目
    
    $order_by_item = array(
        "@SYSNAME名稱","@SYSNAME分類"
    );
       
    // 產生的表格項目
    
    $show_db_item = array(
                        array("@SYSDBNAME_name","@SYSNAME名稱",1)
                    );  
           
    // 資料關聯設定
    
    $relation = array(
                    array("@SYSDBNAME","@SYSDBNAME_class_id","@SYSDBNAME_class","@SYSDBNAME_class_id","@SYSDBNAME_class_name","@SYSNAME分類",0), 
                );
    
    // 作特殊處理 
        
    $process[] = @PROCESS;

    // 靜態條件設定
        
    $condition[] = array($db_table,$db_table . "_valid>=0");
    
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php'
?>
<?php
    require 'template/shanhuo/temp_shanhuo01_01.php'; // 載入模板0101
?>