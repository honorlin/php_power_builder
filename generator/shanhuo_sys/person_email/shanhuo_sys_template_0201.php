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
    
    $db_table = "person_email";
    
    // 使用者搜尋的項目
    
    $search_item = array(
        '識別名稱','Email','備註','群組'
        );
    
    // 使用者排序的項目
    
    $order_by_item = array(
        '識別名稱','Email','備註','群組'
        );    
    
    // 產生的表格項目
    
    $show_db_item = array(
        array("person_email_name","識別名稱",0),
        array("person_email_address","Email",1), 
        array("person_email_remark","備註",2),
        array("person_email_group","群組",3)
       );
    
    // 資料關聯設定
    
    $relation = array(
             
    );  
    
    // 作特殊處理
    
  // $process[]= array("replace","2","<img src=\"images/@source@\" width=\"60\"/>");
    
    // 靜態條件設定
        
    
    
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php'
?>
<?php
    require 'template/shanhuo/temp_shanhuo01_01.php'; // 載入模板0101
?>