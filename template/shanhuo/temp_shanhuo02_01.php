<?php

    /* 名稱：資料表項目UI界面自動產生（清單列）模板
     * 編寫：林廷鴻
     * 日期：2013/01/05
     * 
     * 新增和更新完成後可以在做特殊處理的功能
     * 
     * 
     * 
     * 
     * 
     * 
     */
?>
<?php


        
        $action = $_GET["ac"];
        
        
        if(isset($action))
        {
            switch ($action)
            {
                // 刪除項目
                case "del":
                    $item_id = $_GET["id"];                                        
                
                    $SHANDataOP1->deleteDataWithKey($db_table,$item_id);
                    finish_process($item_id);                     
                    break;

            }
        }        
                
?>
<?php 
        // 如果沒有設定 新增 修改 刪除的功能開啓或關閉,則預設都是開啓
        if(!isset($op_add)) $op_add = true;
        if(!isset($op_edit)) $op_edit = true;
        if(!isset($op_delete)) $op_delete = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="javascript/jquery.js" type="text/javascript"></script>	   
        <script src="js/op01.js" type="text/javascript"></script>
</head>
<body>
    <form name="form1" id="form1" method="post" action="<?php echo $first_page;?>">

<script type="text/javascript">

	function PostToServer(Target, Argument) {
		$('#eventTarget').val(Target);
		$('#eventArgument').val(Argument);    	
        $('form').submit();
	}

</script>
<input type="hidden" id="eventTarget" name="eventTarget" />
<input type="hidden" id="eventArgument" name="eventArgument" />
<div id="main">
      <?php if($op_add) {?><div class="op_add" ><a href="<?php echo $second_page;?>">新增項目</a></div><?php }?>
<?php 
	$sqlop1 = new SqlOperator($db_worker);
        
        $ListForLooking1 = new ListForLooking($sqlop1);
        
        $ListForLooking1->dbInit($db_table, $show_db_item, $relation, $order_by, $condition);
        
        // 將所有換行字元換成網頁的換行標籤
        $process[] =  array("replaceWord","all","\n","<br/>");                                              
       
        if(strrpos($second_page,"?") === FALSE)
        {
            $pageIndex = $second_page . "?";         
        }
        else
        {
            $pageIndex = $second_page . "&";
        }
        
        if($op_edit) $process[] = array("add","編輯","<a href=\"$pageIndex" . "ac=edit&id=@primarykey@\"><img src=\"img/edit2.png\" border=\"0\" width=\"25\"/></a>");
        if($op_delete) $process[] =  array("add","刪除","<a href=\"javascript:del_item('@primarykey@','$first_page');\"><img src=\"img/delete.gif\" border=\"0\" width=\"20\"/></a>");
                
        
        $ListForLooking1->UIInit($search_item, $order_by_item, 10, 300, $process, $first_page);
        
        $ListForLooking1->autoSearch($autoSearchItem,$autoSearchText);
        
        $ListForLooking1->Process();
       
        echo $ListForLooking1->showSearchUerItem();
	echo $ListForLooking1->show_search_boc_with_radio_list();
	echo $ListForLooking1->show_orderby_box();
	echo $ListForLooking1->UITable();
	echo $ListForLooking1->UIPageList();
?> 
</div>

    </form>
</body>
</html>
        