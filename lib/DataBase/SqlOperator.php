<?php

/* 名稱：資料庫的SQL語法封裝操作
 * 編寫：林廷鴻
 * 日期：2012/10/10 修改
 * 
 * 封裝對資料庫操作的常用SQL語法
 * 目的達到系統開發時,SQL語法的使用度為0
 * 
 * 具有無限多層關聯的功能
 * 
 * 
 * 建構子 __construct($db_worker)
 *      
 *      $db_worker：SQL操作物件
 * 
 * 公用方法1 set_condition(array $condition) 功能：設定靜態條件
 * 
 *      $condition:用來設定取得資料的靜態條件 格式：array(array()) 範例：array(array(資料表,欄位>=0"))
 * 
 *      回傳:NONE
 * 
 * 公用方法2 set_order_by(array $by) 功能：設定動態條件
 * 
 *      $by:用來設定取得資料的靜態排序條件 格式：array(array()) 範例：array(array(資料表,欄位 desc"))
 * 
 *      回傳:NONE
 * 
 * 公用方法3 dyn_condition($dynSearchItem,$dynConditionText) 功能：設定動態條件
 * 
 *      $dynSearchItem:要搜尋的欄位代表名稱 範例：客戶名稱 注意：如果此值為 "全部" 則會搜尋所有設定的欄位
 *      $dynConditionText:要搜尋的值
 * 
 *      回傳:NONE
 * 
 * 公用方法4 dyn_order_by($dynOrderByItem,$dynOrderByType) 功能：設定動態排序
 * 
 *      $dynOrderByItem:要排序的欄位代表名稱 範例：客戶名稱
 *      $dynOrderByType:要排序的形態 例如:asc,desc
 * 
 *      回傳:NONE
 * 
 * 公用方法5 getData($withHeader,$table_name,$show_name)
 * 	
 *      $withHeader = showHeader:代表有欄位名稱,noneHeader代表無欄位名稱
 *	$encode:代表回傳的編碼:有big5和utf8
 *      $table_name:要操作的資料表
 *      $show_name: 要操作的資料表欄位, 格式：array(array("資料庫攔位名稱1","此欄位顯示的名稱1",排序),array("此欄位顯示的名稱2","此欄位顯示的名稱2",排序)
 * 
 *      回傳:array(array())
 * 
 * 公用方法6 delData($TableName, $ConditionColumnName, $ConditionValue) 功能:刪除資料表的資料
 * 
 *      $TableName:資料表名稱
 *      $ConditionColumnName:條件欄位
 *      $ConditionValue:條件欄位的值
 * 
 *      回傳:成功(true),失敗(false)
 * 
 * 公用方法7 updateData($TableName, $Update,$ConditionColumnName, $ConditionValue) 功能:更新資料表裡的資料
 * 
 *      $TableName:資料表名稱
 *      $Update:要更新的資料 格式:array(array() 範例:array(array(資料庫攔位名稱1,更新值1),array("資料庫攔位名稱2",更新值2))
 *      $ConditionColumnName:條件欄位
 *      $ConditionValue:條件欄位的值
 * 
 *      回傳:成功(true),失敗(false)
 * 
 * 公用方法8 addData($TableName,$Data)
 * 
 *      $TableName:資料表名稱
 *      $Data:要新增的資料 格式:array(array() 範例:array(array(資料庫攔位名稱1,新增值1),array("資料庫攔位名稱2",新增值2))
 * 
 *      回傳：成功(回傳新增後的ID值),失敗(false)
 * 
 * 公有方法9 setRelation($relation)
 * 
 *      $relation:資料庫的關聯設定,可以無限的關聯
 * 
 *      回傳：無
 * 
 * 私有方法1 get_encode_str($encode,$str) 功能:將字串作編碼轉換
 * 
 *      $encode:編碼形態 可傳入utf8和big5兩種 
 *      $str:要轉換的字串
 * 
 *      回傳:轉換後的值
 *        
 * 私有方法2 getSearchString($search_item,$search_text) 功能:根據資料表欄位的形態來產生對應的條件語法
 * 
 *      $search_item:欄位代表名稱 範例：客戶名稱
 *      $search_text:條件值
 * 
 *      回傳: $search_item 的欄位格式是 varchar 和 date, 回傳 xxxx($search_itemy在資料表裡的名稱) like '%$search_text%'
 *  
 * 私有方法3 get_Row_Type($table,$column) 功能: 取得此資料表欄位的格式 
 * 
 *      $table:欄位所在的資料表    
 *      $column:資料表欄位
 * 
 *      回傳:欄位的格式
 * 
 */
require 'SQLCommond.php';


class SqlOperator
{
	private $db_work; //此是用來存取資料庫之用
	private $dynConditionAllItem; //用來設定那些可以用來搜尋的顯示名稱,
	//private $db_name; //用來設定所對應的資料庫欄位
	//用來設定資料庫的關聯,例如:array(poster,member,id,name,show_name,seq),
	//就是$table_name的資料表的poster欄位,對應到member資料表的id主索引的name欄位
	//show_name是此欄位要顯示的名稱
	//seq代表此欄位要顯示在表單的第幾欄
	private $relational = null;//array(array());
	private $show_name = null;//array(array());//設定資料庫對應要顯示的名稱
        private $table_name;
        private $primary_key;
	private $order_by = null;//array(); //排序的條件
	private $condition = null;//array();//另外的條件
        private $in_condition = null;

        private $seq1 = null;
        private $seq2 = null;
        private $seq3 = null;
        private $seq4 = null;
        private $seq5 = null;
        
        private $withHeader;
        
        // 2012/10/10 add by Ten.        
        private $dynConditionItem = "";
        private $dynConditionText = "";
        
        private $dynOrderByItem = "";
        private $dynOrderByType = "";
        
        // 2013/01/15 add by Ten.
        
        private $dynSearch;
       
	public function __construct($db_worker)//建構子,傳入資料庫存取的物件
	{
		$this -> db_work = $db_worker;	
	
	}       

        // 設定靜態條件
	public function set_condition($condition)
	{
		$this -> condition = $condition;
	}
        // 設定靜態條件
	public function set_incondition($in_condition)
	{
		$this -> in_condition = $in_condition;
	}
                     
        // 設定靜態排序
        public function set_order_by($by)
	{
		$this -> order_by = $by;
		
	}
                
        // 動態條件,在靜態條件的前題下附加此動態條件
        public function dyn_condition($dynConditionItem,$dynConditionText)                
        {
            //$this->dynConditionItem = $dynConditionItem;
            //$this->dynConditionText = $dynConditionText;
            
            $this->dynSearch[$dynConditionItem] = $dynConditionText;
        }    
        
        // 清除搜尋條件
        
        public function clear_dyn_condition()
        {
             $this->dynSearch = array();            
        }

        // 動態排序,在靜態排序的前題下附加此動態排序
        public function dyn_order_by($dynOrderByItem,$dynOrderByType)
        {    
            $this->dynOrderByItem = $dynOrderByItem;
            $this->dynOrderByType = $dynOrderByType;
        }
        
        public function setDynConditionAllItem($dynConditionAllItem)
        {
            $this->dynConditionAllItem = $dynConditionAllItem;            
        }    
        
        // 設定資料庫關聯
        public function setRelation($relation)
        {
            $this->relational = $relation;            
        }

        // $withHeader = showHeader:代表有欄位名稱,noneHeader代表無欄位名稱
	//$encode:代表回傳的編碼:有big5和utf8
	public function getData($withHeader,$table_name,$show_name,$primary_key) //取得db search的結果
	{ 
            $this->withHeader = $withHeader;
            $this -> primary_key = $primary_key;
            $this -> table_name = $table_name;
            $this -> show_name = $show_name;
            return $this->performGetData();                
	}   
        
        
        //public function getdata2($table_name,$show_name)
        //{
        //    $this->withHeader = "noneHeader"; 
        //    $this -> primary_key = $table_name . "_id";
        //    $this -> table_name = $table_name;
        //    $this -> show_name = $show_name;
        //    return $this->performGetData(); 
        //}
        


        private function performGetData()
        {
            $encode = "utf8";
            
            // 產生基本的資料庫join語法
                
                        //$table = array(); //資料表所對應的a?名稱,例如:disscussion -> a1,member -> a2,shop -> a3

                        $table = array(); //例如: 0 =>主資料庫名稱(disscusion),1 => member ,2 => shop
                        $table[] = $this -> table_name;
                        $table_index = array(); //資料庫名稱所對應的代碼,例如:disscussion => a1,member => a2;

                        if(count($this -> relational) != null)//帶表有設關聯式的資料
                        {
                                for($i = 0 ; $i < count($this -> relational) ; $i++)
                                {
                                        $re = $this -> relational[$i];

                                        if(!in_array($re[2],$table))
                                                $table[] = $re[2];
                                }
                        }

                        for($i = 0 ; $i < count($table) ; $i++)
                        {
                                $table_index[$table[$i]] = "a" . (string)($i+1);				
                        }



                        $this->seq1 = array(); //顯示欄位順序所對應的顯示名稱,例如: 1 => "標題"
                        $this->seq2 = array(); //顯示欄位順序所對應的資料庫搜尋時的對應名稱,例如:1 => "a1.title"
                        $this->seq3 = array();//顯示搜尋欄位所對應的資料表欄位代號,例如:"標題" => "a1.title"
                        $this->seq4 = array();//顯示搜尋欄位所對應的資料表名稱,例如:"標題" => "disscusion"
                        $this->seq5 = array();//顯示搜尋欄位所對應的資料表欄位,例如:"標題" => "title"

                        //先作初步的搜尋		
                        $result = null;
                        $sql = "";//sql的搜尋語法
                        $sql .= " from " . $this -> table_name . " a1";//初步的語法

                        //主資料表的欄位對應
                        $field = ""; // 欄位取得的語法

                        
                        
                        $f = $this -> show_name[0];
                        $field .= "a1.".$f[0];
                        $this->seq1[$f[2]] = $f[1];
                        $this->seq2[$f[2]] = "a1.".$f[0];
                        $this->seq3[$f[1]] = "a1.".$f[0];;
                        $this->seq4[$f[1]] = $this -> table_name;
                        $this->seq5[$f[1]] = $f[0];


                        for ($i = 1 ; $i < count($this -> show_name) ;$i++)
                        {
                                $f = $this -> show_name[$i];
                                $field .= ",a1.".$f[0];
                                $this->seq1[$f[2]] = $f[1];
                                $this->seq2[$f[2]] = "a1.".$f[0];
                                $this->seq3[$f[1]] = "a1.".$f[0];;
                                $this->seq4[$f[1]] = $this -> table_name;
                                $this->seq5[$f[1]] = $f[0];

                        }
                        
                        
                        // 補上主索引的欄位
                        $field .= ",a1." . $this -> primary_key;

                        //關聯式資料表取得的欄位對應
                        $field2 = "";

                        //加上關聯式資料庫語法
                        if(count($this -> relational) != null)//帶表有設關聯式的資料
                        {
                                for($i = 0 ; $i < count($this -> relational) ; $i++)
                                {
                                        $re = $this -> relational[$i]; 
                                        $sql2 = $re[2] . " " . $table_index[$re[2]];
                                        if(strpos($sql, $sql2) === false)$sql .= "," . $sql2;

                                }

                                //加上關聯對應的索引
                                $sql .=" where ";

                                $re = $this -> relational[0];
                                $sql .= " " . $table_index[$re[0]] . "." . $re[1] . "=" . $table_index[$re[2]] . "." . $re[3];
                                $field2 .= $table_index[$re[2]] . "." . $re[4];
                                $this->seq1[$re[6]] = $re[5];
                                $this->seq2[$re[6]] = $table_index[$re[2]] . "." . $re[4];
                                $this->seq3[$re[5]] = $table_index[$re[2]] . "." . $re[4];
                                $this->seq4[$re[5]] = $re[2];
                                $this->seq5[$re[5]] = $re[4];

                                for($i = 1 ; $i < count($this -> relational) ; $i++)
                                {
                                        $re = $this -> relational[$i];

                                        $sql2 = $table_index[$re[0]] . "." . $re[1] . "=" . $table_index[$re[2]] . "." . $re[3];
                                        if(strpos($sql, $sql2) === false) $sql .= " and " . $sql2;
                                        $field2 .= "," . $table_index[$re[2]] . "." . $re[4];
                                        $this->seq1[$re[6]] = $re[5];
                                        $this->seq2[$re[6]] = $table_index[$re[2]] . "." . $re[4];
                                        $this->seq3[$re[5]] = $table_index[$re[2]] . "." . $re[4];
                                        $this->seq4[$re[5]] = $re[2];
                                        $this->seq5[$re[5]] = $re[4];
                                }

                        }


                        //補上取得的欄位和所對應的名稱



                        if ($field2 != "") //有關聯式資料
                                $sql = "select " . $field . "," . $field2 . " " . $sql;
                        else
                                $sql = "select " . $field . " " . $sql;

                        $flag = 0;
                
                
                // 產生基本的資料庫join語法 end 

               	
		// 靜態條件
		
		$condition_str = "";
		
		if($this -> condition != null) //代表有設定特殊條件
		{
			
			$condition1 = $this -> condition[0][0];
			$condition2 = $this -> condition[0][1];
				
			$condition_str .= $table_index[$condition1] . "." . $condition2;
			
			
			for($i = 1 ; $i < count($this -> condition) ; $i++)
			{
				$condition1 = $this -> condition[$i][0];
				$condition2 = $this -> condition[$i][1];
				
				$condition_str .= " and " . $table_index[$condition1] . "." . $condition2;
			}
		}
                
                 $in_condition_str = "";
		
		if($this -> in_condition != null) //代表有設定特殊條件
		{
			
			$condition1 = $this -> in_condition[0][0];
			$condition2 = $this -> in_condition[0][1];
                        $condition3 = $this -> in_condition[0][2];                                                
                        
                        $s = "";
                        foreach($condition3 as $s1)
                        {
                            $s .= $s1 . ",";
                        }
                        
                        $s = substr($s, 0,  strlen($s)-1);
				
			$in_condition_str .= $table_index[$condition1] . "." . $condition2 . " in ({$s})";
			
			
			for($i = 1 ; $i < count($this -> in_condition) ; $i++)
			{
				$condition1 = $this -> in_condition[$i][0];
				$condition2 = $this -> in_condition[$i][1];
                                $condition3 = $this -> in_condition[$i][2];
                        
                                $s = "";
                                foreach($condition3 as $s1)
                                {
                                    $s .= $s1 . ",";
                                }
				
				$in_condition_str .= " and " . $table_index[$condition1] . "." . $condition2 .  " in ({$s})";
			}
		}
                
                // 靜態排序
		
		$order_by_str = "";
		
		if($this -> order_by != null) //代表有設定排序
		{
                        $order_by1 = $this -> order_by[0];
                  	
                        $order_by_str = $table_index[$order_by1[0]] . "." . $order_by1[1];
                    
                    
                         for($i = 1 ; $i < count($this -> order_by) ; $i++)
                        {			
                                  $order_by1 = $this -> order_by[$i];
                  	
                                  $order_by_str .= "," . $table_index[$order_by1[0]] . "." . $order_by1[1];
                    
                        }
		}
                 
		// 動態條件		
		
                $dyn_condition_string = "";
                
                if($this->dynSearch != null)
                foreach($this->dynSearch as $key => $value)
                {
                    $this->dynConditionItem = $key;
                    $this->dynConditionText = $value;
                    
                    if ($this->dynConditionItem != "全部" && $this->dynConditionText != "")
                    {
                        $flag = 1;                    

                        // 利用使用者傳遞的搜尋名稱,反找其在資料庫對應的欄位,例如:a1.name;		
                        $ss = $this->getSearchString($this->dynConditionItem,$this->dynConditionText);    
                        
                        if($ss != "")
                        {
                            $dyn_condition_string .= $ss;                                              
                            $dyn_condition_string .= " and ";  
                        }
                    }
                    else if ($this->dynConditionItem == "全部" && $this->dynConditionText != "")
                    {                 
                      if($this->dynConditionAllItem != null){
                        $search_string_sub =  "";

                        foreach($this->dynConditionAllItem as $n)
                        {
                            $ss = $this->getSearchString($n, $this->dynConditionText);

                            if($ss != "") $search_string_sub .=  $ss . " or ";
                        }

                        $ss = substr($search_string_sub, 0,  strlen($search_string_sub) - 3); 
                        if($ss != "")
                        {
                            $dyn_condition_string .=  "(" . $ss . ")";
                            $dyn_condition_string .= " and ";
                        }
                        // echo $search_string;
                      }
                    }
                    
                    
                }                                               
                
                if(substr($dyn_condition_string, strlen($dyn_condition_string) - 5) == " and ")
                {
                    $dyn_condition_string = substr($dyn_condition_string, 0,strlen($dyn_condition_string) - 5);             
                }
              
                // 動態排序
                
                $dyn_order_by_str = "";
                
                if($this->dynOrderByItem != "" && $this->dynOrderByType != "") //使用者有設定外部搜尋box項目,先優先使用
                {
                   if($this->seq3[$this->dynOrderByItem] != "") $dyn_order_by_str = $this->seq3[$this->dynOrderByItem] . " " . $this->dynOrderByType;       
                }
		
                
                // 將條件和排序的SQL語法做附加
                                
                        if ($condition_str != "")  // 有靜態條件
                        {

                            if(strpos($sql,"where") > 0) 
                            {

                                $sql .= " and " . $condition_str;                        
                            }
                            else{

                                $sql .= " where " . $condition_str;
                            }
                        }
                        
                        if ($in_condition_str != "")  // 有靜態條件
                        {

                            if(strpos($sql,"where") > 0) 
                            {

                                $sql .= " and " . $in_condition_str;                        
                            }
                            else{

                                $sql .= " where " . $in_condition_str;
                            }
                        }
                        
                        if($dyn_condition_string != "") // 有動態條件
                        {

                            if(strpos($sql,"where") > 0)
                            {
                                $sql .= " and " . $dyn_condition_string;                        
                            }
                            else
                                $sql .= " where " . $dyn_condition_string;

                        }


                        if($dyn_order_by_str != "" && $order_by_str != "")    
                                $sql .= " order by " . $order_by_str . "," . $dyn_order_by_str; 				
                        else if ($order_by_str != "") 
                                $sql .= " order by " . $order_by_str;
                        else if ($dyn_order_by_str != "") 
                                $sql .= " order by " . $dyn_order_by_str;

             
                // 將條件和排序的SQL語法做附加 end
                
		
                // *** 執行SQL                                
                        
                //echo $sql;       
                        
                $result = $this -> db_work -> perform($sql) or die ("<p>" . $sql . "</p>");
		
		
                // 產生要回傳的資料格式 array(array())
                
                        $data = array(array());

                        if($this->withHeader == "showHeader")//有欄位名稱
                        {

                                //設定攔位名稱
                                $data[0][] = 0;
                                for($j = 0 ; $j < count($this->seq1) ;$j++)
                                {					
                                        $data[0][] = $this->seq1[$j];
                                }


                        //將資料轉成2維陣列的格式


                                for($i = 0 ; $i < mysql_num_rows($result) ;$i++ )
                                {
                                        $data[$i + 1][] = mysql_result($result,$i,"a1." . $this -> primary_key);
                                        for($j = 0 ; $j < count($this->seq2) ;$j++)
                                        {				
                                                $data[$i + 1][] = $this -> get_encode_str($encode,mysql_result($result,$i,$this->seq2[$j])); 
                                        }
                                }
                        }
                        else if($this->withHeader == "noneHeader")//無欄位名稱
                        {                            
                            
                                for($i = 0 ; $i < mysql_num_rows($result) ;$i++ )
                                {
                                        $data[$i][] = mysql_result($result,$i,"a1." . $this -> primary_key);
                                        for($j = 0 ; $j < count($this->seq2) ;$j++)
                                        {					
                                                $data[$i][] = $this -> get_encode_str($encode,mysql_result($result,$i,$this->seq2[$j]));
                                        }
                                }


                        }
                
                // 產生要回傳的資料格式 array(array()) end
		
		return $data;
		
            
            
        }


        
    // 刪除資料
    public function delData($TableName, $ConditionColumnName, $ConditionValue)
    {               
        $sql = "delete from " + $TableName + " where " + $ConditionColumnName + "=@" + $ConditionColumnName;
        $sqlcom = new SQLCommond($sql,$this->db_work);    
        $sqlcom->AddWithValue($TableName,$ConditionColumnName,"@".$ConditionColumnName,$ConditionValue);

        return $this->db_work->perform($sqlcom->GetSql());
    }

    // 更新資料
    public function updateData($TableName, $Update,$ConditionColumnName, $ConditionValue)
    {
        $sql = "update " . $TableName . " set ";

        $index = 0;
        foreach ($Update as $key => $value)
        {
            $sql .= $key . "=@" . $index . $key . ",";
            $index ++;             
        }

        $sql = substr_replace($sql ,"",-1);
        
        $sql .= " where " . $ConditionColumnName . "=@" . $ConditionColumnName;

       
        
        $sqlcom = new SQLCommond($sql,$this->db_work);

        $index = 0;
        foreach ($Update as $key => $value)
        {
            $sqlcom->AddWithValue($TableName,$key,"@" . $index . $key, $Update[$key]);
            $index++;            
        }

         $sqlcom->AddWithValue($TableName,$ConditionColumnName,"@" . $ConditionColumnName, $ConditionValue);
         
         return $this->db_work->perform($sqlcom->GetSql());    
    }

    // 新增資料,回傳新增後的主索引鍵
    public function addData($TableName,$Data)
    {
        $sql = "insert into " . $TableName . "(";

        foreach ($Data as $key => $value)
        {
            $sql .= $key . ",";
        }

        $sql = substr_replace($sql ,"",-1);
        
        $sql .= ") values(";
        $index = 0;
        foreach ($Data as $key => $value)
        {
            $sql .= "@" . $index .  $key . ",";
            $index ++;
            
        }

        $sql = substr_replace($sql ,"",-1);
        
        $sql .= ")";

        $sqlcom = new SQLCommond($sql,$this->db_work);
        $index = 0;
        foreach ($Data as $key => $value)
        {
            $sqlcom->AddWithValue($TableName,$key,"@" . $index . $key, $Data[$key]);
            $index ++;            
        }
        
       // echo $sqlcom->GetSql();

        if($this->db_work->perform($sqlcom->GetSql()))
        {
            return $this->db_work-> getInsertID();            
        }
        else
            return FALSE;

    }
    
    // 取得在此條件下的列的數量
    public function getColumnNumber($TableName,$Condition)
    {
        $sql = "select count(*) from $TableName where " . $Condition;
                
        $dt = $this->db_work->perform($sql);
        
        return mysql_result($dt, 0, "count(*)");
    }
     
   
    
// ------ private ------  
   
                
    private function get_encode_str($encode,$str)
    {
		if($encode == "utf8")
			return $str;
		else if($encode == "big5")	
			return iconv("UTF-8","big5",$str);	
		
    }
  
    // 取的搜尋的SQL字串
    private function getSearchString($search_item,$search_text)
    {
        $search_string = "";
        
        // 利用使用者傳遞的搜尋名稱,反找其在資料庫對應的欄位,例如:a1.name;
        $search_item_db_name = $this->seq3[$search_item];
        
        //echo $search_item_db_name . "<br/>";
        
        //echo $search_item . ":" . $search_text . "<br/>";
        
        //找出要搜尋的資料表的欄位格式
        $row_type = $this->get_Row_Type($this->seq4[$search_item], $this->seq5[$search_item]);                    

        if(strpos($row_type,"varchar") !== false)
        {                          
            $search_string = $search_item_db_name . " like '%" . $search_text . "%'";								
        }
        else if(strpos($row_type,"date")!== false)
        {	 
            $search_string = $search_item_db_name . " like '%" . $search_text . "%'";						
        }
        else if(strpos($row_type,"int")!== false)
        {
            if(is_numeric($search_text))
            {
                $search_string = $search_item_db_name . " = " . $search_text ;
            }
        }
     
        //echo $search_string . "<br/>";

        return $search_string;
   }
        
    // 取的資料表的型別
    private function get_Row_Type($table,$column)
    {
        $dd = $this -> db_work -> perform("SHOW FIELDS FROM " . $table);

        $row_type;//欄位的格式

        while ($row = mysql_fetch_array($dd)) {

                if($row['Field'] == $column)	
                {
                        $row_type = $row['Type'];
                        break;
                }
        }    

        return $row_type;
    }

}




?>