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
        '發送Email','發送狀態','訊息'
        );
    
    // 使用者排序的項目
    
    $order_by_item = array(
        '發送Email','發送狀態','訊息'
        );    
    
    // 產生的表格項目
    
    $show_db_item = array(
        array("e_paper_send_task_email_name","發送Email",2),
        array("e_paper_send_task_status","發送狀態",3), 
        array("e_paper_send_task_msg","訊息",4)
       );
    
    // 資料關聯設定
    
    $relation = array(
        array("e_paper_send_task","e_paper_task_id","e_paper_task","e_paper_task_id","e_paper_task_title","電子報任務",0),  
        array("e_paper_send_task","e_paper_id","e_paper","e_paper_id","e_paper_name","電子報",1)           
    );  
    
    // 作特殊處理
    
    $process[]= array("replaceWord","4","0",'等待中');
    $process[]= array("replaceWord","4","1",'發送中');
    $process[]= array("replaceWord","4","2",'發送成功');
    $process[]= array("replaceWord","4","3",'發送失敗');
      
    // 靜態條件設定
        
    
    
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php';
    
    //
    
    $op_add = FALSE;
    $op_edit = FALSE;
    $op_delete = FALSE;
?>
<?php
    require 'template/shanhuo/temp_shanhuo01_01.php'; // 載入模板0101
?>