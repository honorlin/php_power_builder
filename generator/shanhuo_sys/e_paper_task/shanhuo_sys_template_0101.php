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
        '任務名稱','電子報','任務狀態','任務進度','任務備註'
        );
    
    // 使用者排序的項目
    
    $order_by_item = array(
         '任務名稱','電子報','任務狀態','任務進度','任務備註'
        );    
    
    // 產生的表格項目
    
    $show_db_item = array(
        array("e_paper_task_title","任務名稱",0),
        array("e_paper_task_status","任務狀態",2), 
        array("e_paper_task_progress","任務進度",3),
        array("e_paper_task_remark","任務備註",4)
       );
    
    // 資料關聯設定
    
    $relation = array(
        array("e_paper_task","e_paper_id","e_paper","e_paper_id","e_paper_name","電子報",1)           
    );  
    
    // 作特殊處理
    
    $process[]= array("replaceWord","3","0",'停止');
    $process[]= array("replaceWord","3","1",'進行');
    $process[]= array("replaceWord","3","2",'完成');
    
    // 靜態條件設定
        
    
    
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php'
?>
<?php
    require 'template/iweb/temp_shanhuo01_01_iweb01_01.php'; // 載入模板0101
?>