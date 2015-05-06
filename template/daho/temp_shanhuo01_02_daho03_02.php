<?php

    /* 名稱：資料表項目UI界面自動產生（操作頁）模板(業務案件管理專用樣板)
     * 編寫：林廷鴻
     * 日期：2012/11/06
     * 
     * 用於一些參數的對應可以自動的產生各種資料表項目的UI編輯設定
     * 
     * 
     * 
     * 
     * 
     * 
     */
?>
<?php
        
        // --- 處理Ajax的回呼操作
        
        
        if(isset($_POST["work"])) // 本頁的載入是由Ajax呼叫的
        {

            $postValue = array(); // 接收Ajax傳來的值
            
            $ajax_op_id = $_POST["ajax_op_id"];
            
            $worktype = $_POST["work"];
            
                
            for($i=0;$i<count($show_db_item);$i++)
            {
                if($show_db_item[$i][0] == ""){}             
                else if($show_db_item[$i][4] == "upload") // 如果是上傳的則讀取對應SESSION的值
                    $postValue[$show_db_item[$i][0]] = $_SESSION["upload_$i"];               
                else if($show_db_item[$i][4] == "SubOperation" || $show_db_item[$i][4] == "span" ){}
                else                  
                    //// 其餘則讀取POST回傳的值
                    $postValue[$show_db_item[$i][0]] = $_POST["item_$i"];
                
            }
            
            $ret = FALSE;
            $msg = "";
            
            if($worktype == "新增") // 處理新增
            {
                $work_type_id = $postValue["work_type_id"]; // 此案件的工法id 
                 // 產生新的報價編號
                $preEngNumber = daho::getQuotedNumber($work_type_id,$ajax_op_id); 
                $msg .=  "此案件報價編號為:$preEngNumber \n";
                $postValue["project_number"] = $preEngNumber; // 將此報價編號寫入資料庫
                
                $ret = $SHANDataOP1->addDataReturnKey($db_table,$postValue);        
            }   
            else if($worktype == "更新") // 處理更新
            {
                                   

                // 讀取此案件的工法id 

                $on_work_type_id =  $SHANDataOP1->getColumnDataWithKey($db_table,"work_type_id",$ajax_op_id);                

               
                $work_type_id = $postValue["work_type_id"]; // 此案件的工法id                      

                 
                if($on_work_type_id != $work_type_id) // 工法id有異動
                {   
                    // 產生新的報價編號
                    $preEngNumber = daho::getQuotedNumber($work_type_id,$ajax_op_id); 
                    $msg .=  "此案件報價編號為:$preEngNumber \n";
                    $postValue["project_number"] = $preEngNumber; // 將此報價編號寫入資料庫
                }  
                
                if($postValue["project_status"] == "已承攬" )
                {
                    /*
                    // 取得此案件的工程編號
                    $this_project_quoted_number =  $SHANDataOP1->getColumnDataWithKey($db_table,"project_quoted_number",$ajax_op_id); 
                    // 取得此案件的承攬公司
                    $this_project_quoted_company =  $SHANDataOP1->getColumnDataWithKey($db_table,"project_quoted_company",$ajax_op_id); 
                    
                    $new_project_quoted_number = "";
                    $is_creat_new_project_quoted_number = false;
                    
                    if($this_project_quoted_number == "") // 目前無工程編號
                       $is_creat_new_project_quoted_number = true;
                    else if($on_work_type_id != $work_type_id) // 工法id有異動                
                       $is_creat_new_project_quoted_number = true;
                    else if($this_project_quoted_company != $postValue["project_quoted_company"]) // 承攬公司有異動
                        $is_creat_new_project_quoted_number = true;
                    
                    if($is_creat_new_project_quoted_number) // 產生新的工程編號
                    {
                        // 產生新的工程編號
                        $preEngNumber = daho::getEngineerNumber($work_type_id,$postValue["project_quoted_company"],$ajax_op_id); 
                        $msg .=  "此案件工程編號為:$preEngNumber \n";
                        $postValue["project_quoted_number"] = $preEngNumber; // 將此工程編號寫入資料庫
                        $postValue["project_quoted_time"] = 'now()';
                                                
                    }
                     * 
                     */
                    
                }
              
                              
                $ret = $SHANDataOP1->updateDataWithKey($db_table,$postValue ,$ajax_op_id);
            }
            
            if($ret)
                echo "success!\a{$msg}";
            
            
            exit; // 不再處理以下操作,僅處理Ajax操作
        }
        
       
        
        // --- 處理Ajax的回呼操作 end
        

        $worktype = "新增";
        
        $action = $_GET["ac"];
 
        // 清除檔案上傳的存取SESSION
        
        for($i=0;$i<count($show_db_item);$i++)
        {
             $_SESSION["upload_$i"] = "";            
        }
        
        // 處理使用者動作
        if(isset($action))
        {
            switch ($action)
            {
                case "edit":
                             
                    $item_id = $_GET["id"];

                    $ds = $SHANDataOP1->getDataWithKey($db_table,$show_db_item,$item_id);
                    
                    
                    // 有資料
                    if(count($ds) > 0)
                    {
                        
                        for($i=0;$i<count($ds[0]);$i++)
                        {
                            if($show_db_item[$i][4] == "upload")
                            {
                                $show_db_item[$i][3] = $ds[0][$i+1];
                               $_SESSION["upload_$i"] = $ds[0][$i+1];
                            }
                            else    
                                $show_db_item[$i][3] = $ds[0][$i+1];
                            
                        }
                                                                  
                    }
                               
                                        
                    $worktype = "更新";
                
                    break;
                
                
                
            }
        }	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="javascript/jquery-ui-1.9.0.custom/css/start/jquery-ui-1.9.0.custom.css" rel="stylesheet" type="text/css" />    
    <script src="javascript/jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
    <script src="javascript/jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.js" type="text/javascript"></script>
    <script src="js/jquery.autoheight.js" type="text/javascript"></script>
<script type="text/javascript">
     
        $(document).ready(function () {
            
            $(".date_value").datepicker({
                showOn: "button",
                dateFormat:"yy/mm/dd"
            });                   
	               
            $("#op_type").click(function() { 

            if(check_value())
            {        
                        $("#msg").html('');
                        
                        $.post("<?php echo $second_page; ?>", {                           
                            <?php                              
                            echo "work:$(\"#op_type\").html()\n";
                            echo ",ajax_op_id:$(\"#op_item_id\").val()\n";
                            for($i=0;$i<count($show_db_item);$i++)
                                 echo ",item_$i:$(\"#item_$i\").val()\n";                           
                            ?>
                                                
                        },
                          function(data){ 
                              
                                //alert(data);
                              
                                if(data.indexOf("success") >= 0)
                                {
                                    var msg = data.split("\a")[1];
                                    
                                    if(msg != "")
                                        alert(msg);
                                    
                                    $("#msg").html($("#op_type").html() + "成功!");                                             
                                    location.href="<?php echo $first_page ;?>";
                                }
                                else
                                {
                                    $("#msg").html($("#op_type").html() + "失敗!");  
                                }
                          });
                    }    
            })                	                      
        });

function check_value()
{
    var msg = "";
    
    <?php
        for($i=0;$i<count($show_db_item);$i++)
        {
            if($show_db_item[$i][5] == "need to enter")
            {
                 $ch_name = $show_db_item[$i][1];  
                 echo "if($(\"#item_$i\").val() == \"\")msg+=\"$ch_name 欄位不得為空!\\n\";\n";
            }   
        }  
    ?>
      

    if(msg != "")
     {
        alert(msg);
        return false;
     }
     else
         return true;
    
    
}
</script>

</head>
<body>
    <div id="main">
        <input type="hidden" id="op_item_id" name="op_item_id" value="<?php echo $_GET["id"];?>" />        
        
        <?php 
        
            for($i=0;$i<count($show_db_item);$i++)
            {
                
                // 取得此項目的Html項目編輯語法
                // getThisHtml(項目名稱,初始值,html樣式,順序)
                
                echo getThisHtml($show_db_item[$i][1],$show_db_item[$i][3],$show_db_item[$i][4],$i);
                
                
            }
            
        
        ?>
            
        <div class="set">
           <a href="javascript:void(0);" id="op_type"><?php echo $worktype;?></a>     <a href="<?php echo $first_page;?>">返回</a>
        </div>     
        <div class="set">
            <div id="msg"></div>
        </div>
    </div>
</body>
</html>
