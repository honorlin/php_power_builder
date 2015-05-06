<?php ob_start() ?>
<?php

    /* @系統：iweb
     * @名稱：@SYSNAME管理 (操作頁)
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
    
    
    // --- 此物件的特殊處理

            // 產生此案件的報價編號

                   

            // 產生此案件的編號 end

            // 產生選單的資料

                
            // 產生選單的資料 end
    
    // --- 此物件的特殊處理 end
    
    // 產生的表格項目
    
 
        $show_db_item = array(
        array("@SYSDBNAME_name","@SYSNAME分類",0,"","text","need to enter"),
        array("@SYSDBNAME_seq","分類順序",1,"0","text","need to enter")
       );
     
    // 項目的html元件屬性特殊設定
    

    
    // 單位特殊設定
    

     
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php';
?>
<?php
 
    require 'template/shanhuo/temp_shanhuo01_02.php'; // 載入daho專用模版0302

?>