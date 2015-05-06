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
    
                // 任務狀態
    
                if(isset($_GET['id']))
                    $e_paper_task_status = $SHANDataOP1->getColumnDataWithKey('e_paper_task','e_paper_task_status',$_GET['id']);           

                if($e_paper_task_status == 2) // 發送完成
                     $DropListData["任務狀態"] = array(array("2","完成"));
                else
                     $DropListData["任務狀態"] = array(array("0","停止"),array("1","啟動")); 
                
      
                // 電子報
                
                $dt = $SHANDataOP1->getData("e_paper",
                            array(
                                array("e_paper_name","電子報")
                                )                                                        
                            );
                    
                 $DropListData["電子報"] = $dt;
            
            // 產生選單的資料 end
    
    // --- 此物件的特殊處理 end
    
    // 產生的表格項目
        if($e_paper_task_status == 2)
        {
            $show_db_item = array(
                array("e_paper_task_title","任務名稱",0,"","text","need to enter"),
                array("e_paper_id","電子報",1,"","List Show",""), 
                array("e_paper_task_status","任務狀態",2,"","List Show",""), 
                array("e_paper_task_remark","任務備註",3,"","textarea",""),           
           ); 
        }
        else
        {
            $show_db_item = array(
                array("e_paper_task_title","任務名稱",0,"","text","need to enter"),
                array("e_paper_id","電子報",1,"","DropList",""), 
                array("e_paper_task_status","任務狀態",2,"","DropList",""), 
                array("e_paper_task_remark","任務備註",3,"","textarea",""),           
           );
        }
     
    // 項目的html元件屬性特殊設定
    

    
    // 單位特殊設定
    

     
    // 第一頁的名稱
    
    $first_page = '@SYSTITLE01.php';
    
    // 操作頁的名稱（用於新增項目和修改）
    
    $second_page = '@SYSTITLE02.php';
    
    // 
    
    $no_use_html_editor = true;
?>
<?php
 
    require 'template/shanhuo/temp_shanhuo01_02.php'; // 載入daho專用模版0302

?>