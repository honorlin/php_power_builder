<?php

    /* 名稱：資料表項目UI界面自動產生（操作頁）模板
     * 編號：0102
     * 編寫：林廷鴻
     * 日期：2012/10/09
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
                else if($show_db_item[$i][4] == "upload" ) // 如果是上傳的則讀取對應SESSION的值                    
                    $postValue[$show_db_item[$i][0]] = $_SESSION["upload_$i"];            
                else if($show_db_item[$i][4] == "image_upload") // 如果是上傳的則讀取對應SESSION的值
                    $postValue[$show_db_item[$i][0]] = $_SESSION["image_upload_$i"];
                else if($show_db_item[$i][4] == "SubOperation" || $show_db_item[$i][4] == "show"){}
                else                  
                    //// 其餘則讀取POST回傳的值
                    $postValue[$show_db_item[$i][0]] = $_POST["item_$i"];
            }        
            
            // --- 寫入DB時的預先判別
            
            
            for($i=0;$i<count($show_db_item);$i++)
            {
               if(isset($show_db_item[$i][6])){ // 有設定DB時的預先判別規則
                
                   switch ($show_db_item[$i][6])
                   {
                       case "DB NO DUPLICATE": // 此值在資料庫不得重複
                            if($SHANDataOP1->hasValue($db_table,$show_db_item[$i][0],$postValue[$show_db_item[$i][0]],$ajax_op_id))
                            {
                                echo "falid!:此" . $show_db_item[$i][1] . "已有人使用";
                                exit;    
                            }                       
                            break;
                       
                   }
                   
                   
               } 
            }   
            
            
            //---  寫入DB時的預先判別 end
            
            $ret = FALSE;
            
            if($worktype == "新增") // 處理新增
            {
                $ret = $SHANDataOP1->addDataReturnKey($db_table,$postValue);        
            }   
            else if($worktype == "更新") // 處理更新
            {
                $ret = $SHANDataOP1->updateDataWithKey($db_table,$postValue ,$ajax_op_id);
            }
            
            if($ret)
                echo "success!";
            
            // 完成後,callback處理程序
            
            if(function_exists('callback_process'))
            {  
                if(isset($ajax_op_id)) $ret = $ajax_op_id;
                // $ret: 新增後的primary key , 更新後的資料變動數量
                call_user_func('callback_process',$ret);
            }
            
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
                            else if($show_db_item[$i][4] == "show"){}
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
    <script src="js/json2.js" type="text/javascript"></script>
    <script src="js/ui_common.js" type="text/javascript"></script>
<script type="text/javascript">
     
        $(document).ready(function () {
	               
            $(".date_value").datepicker({
                showOn: "button",
                dateFormat:"yy/mm/dd"
            });   
            
            // 輸入承攬金額

            $("#item_12").change(function(){
                
                if( $("#item_12").val() == "" || $("#item_12").val() == "0")
                {
                    $("#item_13").val("追踪中");    
                                    
                }
                else
                {
                    $("#item_13").val("已承攬");            
                }  
            });


            $("#op_type").click(function() { 

            if(check_value())
            {        
                        $("#msg").html('');
                        
                         <?php
                        // for($i=0;$i<count($show_db_item);$i++)
                        //    {
                         //echo "alert('item_$i:' + $(\"#item_$i\").val());";
                         //   }
                         ?>
                        $.post("<?php echo $second_page; ?>", {                           
                            <?php                              
                            echo "work:$(\"#op_type\").html()\n";
                            echo ",ajax_op_id:$(\"#op_item_id\").val()\n";
                            for($i=0;$i<count($show_db_item);$i++)
                                echo ",item_$i:$(\"#item_$i\").val()\n"; 
                            ?>                                                                                  
                        },
                          function(data){  
                              
                                // alert(data);
                                            
                                if(data.indexOf("success") >= 0)
                                {
                                    $("#msg").html($("#op_type").html() + "成功!");                                             
                                    location.href="<?php echo $first_page ;?>";
                                }
                                else
                                {
                                    var msg = data.split(":")[1];
                                    
                                    $("#msg").html($("#op_type").html() + "失敗! , 原因："  + msg);  
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
        <input type="hidden" id="pre_page" name="pre_page" value="<?php echo $second_page; ?>" />   
        <input type="hidden" id="op_item_id" name="op_item_id" value="<?php echo $_GET["id"];?>" />        
        
        <?php        
        
            for($i=0;$i<count($show_db_item);$i++)
            {
                
                // 取得此項目的Html項目編輯語法
                // getThisHtml(項目名稱,初始值,html樣式,順序)
                if($show_db_item[$i][0] == null) continue;
                    
                if(isset($layout))    
                    echo getThisHtml2($show_db_item[$i][1],$show_db_item[$i][3],$show_db_item[$i][4],$i);
                else 
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

