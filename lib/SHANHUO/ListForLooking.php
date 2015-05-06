<?php

/* 名稱：可以快速產生查找清單和搜尋功能排序功能的UI自動產生物件
 * 編寫：林廷鴻
 * 日期：2012/10/10
 * 
 * 
 * 
 * 
 * 
 */

//require '../DataBase/SqlOperator.php';
//require '../UI/HtmlTable.php';

class ListForLooking
{
    // 基本設定,針對 SqlOperator

    private $tableName;
    private $relational = null;//array(array()); 
    private $tableShow = null;//array(array());//設定資料庫對應要顯示的名稱
    private $sqlop = null;
    private $order_by = null;//array(); //靜態的排序
    private $condition = null;//array();//靜態的條件
    private $in_condition = null;

    // UI 界面設定
    private $htmlTable = null;
    private $tableCount = 0  ;  // 每頁顯示的資料列數目
    private $tableShowLimit =10; // 表格的資料顯示長度限制
    private $tablePreProcess =null; // 表格的預處理
    private $thisPageName;    
    
    // 使用者鍵入的搜尋和排序資料
    
    private $UIsearchItem = "";  // 搜尋的項目
    private $UIsearchText = "";  // 搜尋的資料      
    private $UIorderByItem = ""; // 排序的項目
    private $UIorderBytext = ""; // 排序的型式
    
    // 自動搜尋
    
    private $autoSearchItem;
    private $autoSearchText;
    private $autoOrderByItem;
    private $autoOrderByType;
        
    // 多重搜尋 2013/01/17 By Ten.
    private $UIsearch = array();
        
    public function __construct($sqlop)
    {
        $this->sqlop = $sqlop; 
    }
    
    // 模擬使用者自動搜尋
    public function autoSearch($autoSearchItem,$autoSearchText)
    {
        $this->autoSearchItem=$autoSearchItem;
        $this->autoSearchText=$autoSearchText;
    }
    
    // 模擬使用者自動排序
    
    public function autoOrderBy($autoOrderByItem,$autoOrderByType)
    {
        $this->autoOrderByItem=$autoOrderByItem;
        $this->autoOrderByType=$autoOrderByType;
    }
    
    // 初始使用者的keyin 資料,如果沒有輸入就利用cookie的記憶
    private function initUserKeyIn()
    {
        
        // 根據每個頁面產生不同的cookie對應        
                
        $this_page = str_replace('.php', '',basename($_SERVER['REQUEST_URI'])); // 取得當前頁面名稱,用來區分每個條件的暫存Cookie
  
        $temp = explode("?",$this_page);
        
        $this_page = $temp[0];   

       
        // 取得搜尋和排序物件的使用者操作資料的回呼
        
        if(isset($this->autoSearchItem)) 
        {           
            $source = $this->autoSearchItem;        
        }else $source = $_POST["h_search_item"];
        
        if(isset($this->autoSearchText)) $target = $this->autoSearchText;
        else $target = $_POST["h_search_text"];

        if(isset($this->autoOrderByItem)) $by_item = $this->autoOrderByItem;
        else $by_item = $_POST["h_order_by_item"];
        
        if(isset($this->autoOrderByType)) $by_type = $this->autoOrderByType;
        else $by_type = $_POST["h_order_by_type"];
        
          // 刪除搜尋條件
        
        if(isset($_GET['delsearch']))
        {           
            $del_index = $_GET['delsearch'];
             
            if(isset($_COOKIE["h_search_$this_page"]))
                $op_item = unserialize($_COOKIE["h_search_$this_page"]);
            
            
            $index = 0;
            foreach($op_item as $key => $value)
            {
                if($index == $del_index)
                    unset($op_item[$key]);
                $index++;
            }
            
            $this->UIsearch = $op_item;                        
            
            setcookie("h_search_$this_page", serialize($op_item),  time()+7200);
        
        }
        else if ($target != "") // 搜尋並記憶
        {   
            $op_item = array();
            
            if(isset($_COOKIE["h_search_$this_page"]))
                $op_item = unserialize($_COOKIE["h_search_$this_page"]);
            
           // $op_item .= $source . "\a" . $target . "\b";
            
            $op_item[$source] = $target;
                        
            setcookie("h_search_$this_page", serialize($op_item),  time()+7200);
            
            $this->UIsearch = $op_item;
        }
        //else if($_POST["eventTarget"] == "search") // 清除
        //{
        //    setcookie("h_search_$this_page", '',  time()+7200);
        //    $this->UIsearch = "";
        //}
        else // 從記憶讀取
        {
            $this->UIsearch= unserialize($_COOKIE["h_search_$this_page"]);      
        }

        if($by_item != "")
        {
            setcookie("h_order_by_item_$this_page", $by_item,  time()+7200);
            setcookie("h_order_by_type_$this_page", $by_type,  time()+7200);
            $this->UIorderByItem = $by_item;
            $this->UIorderBytext = $by_type;
        }
        else if($_POST["eventTarget"] == "orderby")
        {
            setcookie("h_order_by_item_$this_page", "",  time()+7200);
            setcookie("h_order_by_type_$this_page", "",  time()+7200);
            $this->UIorderByItem = "";
            $this->UIorderBytext = "";
        }
        else
        {
            $this->UIorderByItem = $_COOKIE["h_order_by_item_$this_page"];
            $this->UIorderBytext = $_COOKIE["h_order_by_type_$this_page"];               
        }
    }

    // 操作的資料表的初始設定
    
    public function dbInit($tableName,$tableShow,$relational,$order_by,$condition,$in_condition=null)
    {
        $this->tableName = $tableName;
        $this->tableShow = $tableShow;       
        $this->relational = $relational;
        $this->order_by = $order_by;
        $this->condition = $condition;
        $this->in_condition = $in_condition;
    }
    
    // UI 界面的初始設定
    
    public function UIInit($searchItem,$orderByItem,$tableCount,$tableShowLimit,$tablePreProcess,$thisPageName)
    {
        $this->searchItem = $searchItem;
        $this->orderByItem = $orderByItem;
        $this->tableCount= $tableCount;
        $this->tableShowLimit = $tableShowLimit;
        $this->tablePreProcess = $tablePreProcess;
        $this->thisPageName = $thisPageName;
        
        $this->htmlTable  = new HtmlTable();	
	$this->htmlTable -> set_show_count($this->tableCount);
	$this->htmlTable -> set_limit($this->tableShowLimit);
    }

    private function throw_js()
    {
        if($show_js == false)
        {
            $show_js = true;
            echo '<script src="javascript/SHANHUO_ListForLooking.js" type="text/javascript"></script>' . "\n";	;//javascript的控件
        }
    }

    public function show_search_box_with_droplist()//顯示出html的搜尋盒子 ,使用選單的方式
    {
        $this->throw_js();
        $html .= '<div id="search_box">' . "\n";	
        $html .= '<input type="hidden" id="h_search_item" name="h_search_item"/>' . "\n";	
        $html .= '<input type="hidden" id="h_search_text" name="h_search_text"/>' . "\n";			
        $html .= '<span id="search_item">' . "\n";
        $html .= '<select id="find_item" name="find_item">' . "\n";	 
        $html .= '<option value="' . "全部" . '">' . "全部" . '</option>' . "\n";      	
        foreach($this -> searchItem as $item)
            if ( $this->UIsearchItem == $item)
                $html .= '<option value="' . $item . '" selected>' . $item . '</option>' . "\n";	
            else
                $html .= '<option value="' . $item . '">' . $item . '</option>' . "\n";	
        $html .= '</select>' . "\n";	
        $html .= '</span>' . "\n";

        $html .= '<span class="search_text">' . "\n";
        $html .= '<input type="text" id="search_text" name="search_text" size="20" maxlength="20" value="' . $this->UIsearchText . '"/>' . "\n";
        $html .= '</span>' . "\n";	
        $html .= '<span class="search_button">' . "\n";
        $html .= '<input type="button" value="搜尋" onclick="box_search1();"/>' . "\n";
        $html .= '</span>' . "\n";	
        $html .= "</div>" . "\n";

        return $html;
    }

    public function show_search_boc_with_radio_list()//顯示出html的搜尋盒子 ,使用點選清單的方式
    {
        $this->throw_js();
        $html .= '<div id="search_box">' . "\n";	
        $html .= '<input type="hidden" id="h_search_item" name="h_search_item"/>' . "\n";	
        $html .= '<input type="hidden" id="h_search_text" name="h_search_text"/>' . "\n";			

        $html .= '<div id="search_control">' . "\n";
        $html .= '<span class="search_text">' . "\n";
        $html .= '<input type="text" id="search_text" name="search_text" size="20" maxlength="20" value="' . $this->UIsearchText . '"/>' . "\n";
        $html .= '</span>' . "\n";	
        $html .= '<span class="search_button">' . "\n";
        $html .= '<input type="button" value="搜尋" onclick="box_search2();"/>' . "\n";
        $html .= '</span>' . "\n";	
        $html .= '</div>' . "\n";	


        $html .= '<div id="search_item">' . "\n";
        $html .= '<input type=radio id="find_item" name="find_item" value="' . "全部" . '" checked>' . "全部" . "\n";      	
        foreach($this -> searchItem as $item)
            if ( $this->UIsearchItem == $item)
                $html .='<input type=radio id="find_item" name="find_item" value="' . $item . '" checked>' . $item . "\n";
            else
                $html .='<input type=radio id="find_item" name="find_item" value="' . $item . '">' . $item . "\n";	
        $html .= '</div>' . "\n";		 

        $html .= "</div>" . "\n";


        return $html;
    }

    public function show_orderby_box()//顯示出選則搜尋的項目
    {
        $this->throw_js();
        $html .= '<div id="order_by_box">' . "\n";	
        $html .= '<input type="hidden" id="h_order_by_item" name="h_order_by_item"/>' . "\n";	
        $html .= '<input type="hidden" id="h_order_by_type" name="h_order_by_type"/>' . "\n";			
        $html .= '<span id="order_by_item">' . "\n";
        $html .= '<select id="by_item" name="by_item">' . "\n";	 
        $html .= '<option value="' . "" . '">' . "" . '</option>' . "\n";      	
        foreach($this -> orderByItem as $item)
            if($this->UIorderByItem == $item )   
                $html .= '<option value="' . $item . '" selected>' . $item . '</option>' . "\n";	
            else    
                $html .= '<option value="' . $item . '">' . $item . '</option>' . "\n";	
        $html .= '</select>' . "\n";	
        $html .= '</span>' . "\n";

        $html .= '<span id="order_by_type">' . "\n";
        $html .= '<select id="by_type" name="by_type">' . "\n";	 
        
        if($this->UIorderBytext == "asc")
        {
            $html .= '<option value="' . "asc" . '" selected>' . "小至大" . '</option>' . "\n";  
            $html .= '<option value="' . "desc" . '">' . "大至小" . '</option>' . "\n";         	
        }
        else if($this->UIorderBytext == "desc")
        {
            $html .= '<option value="' . "asc" . '">' . "小至大" . '</option>' . "\n";  
            $html .= '<option value="' . "desc" . '" selected>' . "大至小" . '</option>' . "\n";     
        }
        else
        {
            $html .= '<option value="' . "asc" . '">' . "小至大" . '</option>' . "\n";  
            $html .= '<option value="' . "desc" . '">' . "大至小" . '</option>' . "\n";                
        }
        $html .= '</select>' . "\n";	
        $html .= '</span>' . "\n";

        $html .= '<span class="order_by_button">' . "\n";
        $html .= '<input type="button" value="排序" onclick="box_order_by();"/>' . "\n";
        $html .= '</span>' . "\n";	
        $html .= "</div>" . "\n";

        return $html;

    }

    public function Process()
    {
        // 初始使用者的keyin 資料,如果沒有輸入就利用cookie的記憶
        $this->initUserKeyIn(); 
        
         // 開始根據使用者的操作資料和基本的設定操作SqlOperator
        $this->sqlop->setRelation($this->relational);
        $this->sqlop->setDynConditionAllItem($this->searchItem);
        $this->sqlop->set_condition($this->condition); // 設定靜態條件
        $this->sqlop->set_order_by($this->order_by);   // 設定靜態排序
        $this->sqlop->set_incondition($this->in_condition);
        
        if($this->UIsearch != null)
        foreach($this->UIsearch as $key => $value)
            $this->sqlop->dyn_condition($key,$value);      // 設定動態條件 (根據使用者操作的UI回呼)
        
        $this->sqlop->dyn_order_by($this->UIorderByItem,$this->UIorderBytext);   // 設定動態排序 (根據使用者操作的UI回呼)
      
        
        // 用SqlOperator取得結果資料
        $data = $this->sqlop->getData("showHeader",$this->tableName,$this->tableShow,$this->tableName . "_id");

       
        // UI HTML表格表物件初始化
       
	$this->htmlTable -> set_data($data);
        $this->htmlTable->PrProcess($this->tablePreProcess);
    }
    
    // 顯示使用者設定的搜尋條件
    public function showSearchUerItem()
    {
        $html = '<div id="searchSetting">';
        $index = 0;
        if($this->UIsearch != null)
        foreach($this->UIsearch as $key => $value)
        {    
            $html .=  "<span class=\"searchChirdItem\">{$key} => {$value} <a href=\"?delsearch={$index}\"><img src=\"img/1358437262_delete.png\" border=\"0\" width=\"15\" height=\"15\" style=\"\"/></a></span> 且<br/>";                
            $index++;            
        }
        
        $html = substr($html, 0,  strlen($html) - 8);
        
        $html .= '</div>';
        
        return $html;
    }
    
    public function UITable()
    {
        // 目前要顯示的頁數
        
        $page = $_GET['page'];	
	
	if (!isset($page))
		$page = 1;
        
            
        
	return $this->htmlTable->show_table($page,null,null);
	
    }   
    
    public function UIPageList()
    {
        // 目前要顯示的頁數
        
        $page = $_GET['page'];	
	
	if (!isset($page))
		$page = 1;
        
        return $this->htmlTable->show_list($this->thisPageName ,"page",$page);
        
        
    }
}





?>
