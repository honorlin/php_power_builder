<?php
	class HtmlTable
	{
		private $show_count = 2;	
		private $out_html = "";
		private $data = array(array());
		private $limit = 10; //超過這個數字的資料長度,或自動裁減
		//private $page_name;
		//private $page_index;
                private $pageCount = 11;
		
		public function __construct()
		{
		
		}
		
		//public function __construct($page_name,$page_index)
		//{
		//	$this -> page_name = $page_name;
		//	$this -> page_index = $page_index;
		//}
		
		public function set_show_count($count)
		{
			$this -> show_count = $count;
		}
		
		public function set_data(array $data)
		{				
			$this -> data = $data;
		}
		
		public function set_limit($limit)
		{				
			$this -> limit = $limit;
		}
		//如果$link_page,和$page_index有一個是null的話就不會自動將其加上連結
		public function show_table($page,$link_page,$page_index)
		{		
			$start = ($page - 1) * $this -> show_count;
			$end = 	$start + ($this -> show_count) - 1;
			
			$start ++;
			$end ++;
			
			
			if ($end > count($this -> data) - 1)
				$end = count($this -> data) - 1;
			
			$this -> out_html = "";
			
			$this -> out_html .= '<table id="show_table">' . "\n";
			$this -> out_html .= '<tr>' . "\n";
			//foreach($this -> header as $tt)
			//{
			//	$this -> out_html .= '<td class="header">' . (string) $tt . '</td>' . "\n";	
			//}
			
			//設定標題,傳進來的2維陣列的第一筆資料就是欄位名稱
			for($j = 1 ; $j < count($this -> data[0]) ; $j++)
			{
				$this -> out_html .= '<td class="header h' . $j . '">' . (string) $this -> data[0][$j] . '</td>' . "\n";	
			}
			
			$this -> out_html .= '</tr>' . "\n";
		
			for($i = $start ; $i <= $end ; $i++)
			{
				$this -> out_html .= '<tr>' . "\n";
				
				for($j = 1 ; $j < count($this -> data[$i]) ; $j++)
				{
					$show = (string) $this -> data[$i][$j];									
					
					if(!strrpos($show,"a href") && !strrpos($show,"img src") && !strrpos($show,"<input")) //代表沒有崁入html語法
					{                                                                                                                                   
						if(mb_strlen($show) > $this -> limit)
							$show =  mb_substr($show,0,$this -> limit,"UTF-8") . " ..."; 
						if($link_page != null && $page_index != null)
							$this -> out_html .= '<td class="row r' . $j . '"><a href="' . $link_page . '?' .  $page_index . "=" . (string) $this -> data[$i][0] . '">' . $show . '</a></td>' . "\n";			
						else
							$this -> out_html .= '<td class="row r' . $j . '">' . $show . '</td>' . "\n";
					}else
						$this -> out_html .= '<td class="row r' . $j . '">' . $show . '</td>' . "\n";				
				
							
				}
				
				$this -> out_html .= '</tr>' . "\n";
			
			}
			
			$this -> out_html .= '</table>' . "\n";
				
	
			return $this -> out_html;
		}
		
		public function show_list($page_name,$page_index,$pre_page)
		{
			
			$this -> out_html = "";
		
			$all_page = (int)((count($this -> data) - 1 )/ $this -> show_count);
					
			if ((count($this -> data) - 1 ) % $this -> show_count > 0)
				$all_page ++;
		
			$this -> out_html .= '<div id="page_list">' . "\n";		
			$this -> out_html .= '<span class="all_page">共' . (string)(count($this -> data) - 1)  . '筆資料 </span> /' . "\n";
			$this -> out_html .= '<span class="all_page">共' . $all_page  . '頁 </span> /' . "\n";

                        if(strpos($page_name, "?") === false) $page_name = $page_name . "?";
                        else $page_name = $page_name . "&";
                        

                                            $start = $pre_page;
                                            
                                            $checkCount = ($this->pageCount-1)/2;
                                        
                                            if($all_page <= $this->pageCount)
                                            {
                                               $start = 1;
                                               $end = $all_page;
                                                
                                            }                                       
                                            else if($pre_page > $checkCount && $pre_page<=($all_page-$checkCount))
                                            {
                                               $start =  $pre_page - $checkCount;
                                               $end = $pre_page + $checkCount;
                                                
                                            }
                                            else if($pre_page > $checkCount && $pre_page>($all_page-$checkCount))
                                            {
                                                $end = $all_page;
                                                $start = $all_page - ($checkCount*2);                                        
                                                if($start < 1) $start =1;    
                                            }
                                            else if($pre_page <= $checkCount && $pre_page<=($all_page-$checkCount))
                                            {
                                                $start = 1;
                                                $end = $start + ($checkCount*2);
                                                if($end > $all_page) $end = $all_page;
                                                
                                            }
                                            
                                            
                                      
					
					if($pre_page > 1) // 加上上一頁
					{
						$this -> out_html .=  '<span class="page">' . "\n";
						$this -> out_html .=  '<a href="' .$page_name . $page_index . '=' . ($pre_page - 1) . '"' . ">上一頁</a>" . "\n";
						$this -> out_html .=  '</span>' . "\n";			
					}
                                        else
                                        {
                                            $this -> out_html .=  '<span class="page">' . "\n";
			                    $this -> out_html .=  '上一頁' . "\n";
                                            $this -> out_html .=  '</span>' . "\n";
                                        }
                                        
					for($i = $start ; $i <= $end ; $i++)
					{	
					
						if ($i == $pre_page)
						{
							$this -> out_html .=  '<span class="pre_page">' .  $i  . '</span>' . "\n";
							
						}
						else
						{
							$this -> out_html .=  '<span class="page">' . "\n";
							$this -> out_html .=  '<a href="' .$page_name . $page_index . '=' . $i . '">' . $i . '</a>' . "\n";
							$this -> out_html .=  '</span>' . "\n";
						}
					}
					
					if($all_page > $pre_page) // 加上下一頁
					{
						$this -> out_html .=  '<span class="page">' . "\n";
						$this -> out_html .=  '<a href="' . $page_name . $page_index . '=' . ($pre_page + 1) . '"' . ">下一頁</a>" . "\n";
						$this -> out_html .=  '</span>' . "\n";			
                                        }
                                        else
                                        {
                                            $this -> out_html .=  '<span class="page">' . "\n";
			                    $this -> out_html .=  '下一頁' . "\n";
                                            $this -> out_html .=  '</span>' . "\n";
                                        }
	
	
			
			$this -> out_html .= ' / <span class="pre_page2"> 目前第' . $pre_page . "頁</span>" . "\n";	
			
			$this -> out_html .=  '</div>' . "\n";	
			
			$_SESSION[$page_name] = $pre_page; // 將此頁存進session
			
			return $this -> out_html;			
		
		}
                
                public function PrProcess($process)
                {
                    foreach ($process as $work)
                    {
                         // 作函數處理
                        if ($work[0] == "function")
                        {                                                             
                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];
                                    $ar[$work[2]] = call_user_func($work[1],$ar[$work[2]]);
                                    $this->data[$i] = $ar;
                                }

                        }
                        // 作函數處理
                        elseif ($work[0] == "headerText")
                        {                                                             
                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];
                                    
                                    $d = explode($work[1],$ar[$work[2]]);
                                    
                                    
                                    $ar[$work[2]] = $d[0];
                                    
                                    
                                    $this->data[$i] = $ar;
                                }

                        }
                        elseif ($work[0] == "date_fomat")
                        {  
                                date_default_timezone_set('Asia/Taipei');
                                 
                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];
                                    
                                    $d = strtotime($ar[$work[2]]);
                                    
                                    $ar[$work[2]] = date($work[1],$d);
                                    $this->data[$i] = $ar;
                                }
                        }
                        else
                        // 作資料的置換作業
                        if ($work[0] == "replace")
                        {                                                             
                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];
                                    $ar[$work[1]] = str_replace("@source@", $ar[$work[1]], $work[2]);
                                    $this->data[$i] = $ar;
                                }

                        }
                        else if($work[0] == "replaceWord")
                        {
                            if($work[1] == "all") // 全部
                            {



                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];

                                    for($j=1;$j<count($ar);$j++)
                                    {
                                        $ar[$j] = str_replace($work[2], $work[3], $ar[$j]);

                                    }

                                    $this->data[$i] = $ar;
                                }
                            }
                            else  // 有指定欄位
                            {                               
                                for ($i = 1; $i < count($this->data); $i++)
                                {
                                    $ar = $this->data[$i];

                                        $ar[$work[1]] = str_replace($work[2], $work[3], $ar[$work[1]]);


                                    $this->data[$i] = $ar;
                                }                       
                            }                                               
                        }                                        
                        // 作資料的增加作業
                        else if ($work[0] == "add")
                        {
                            { // 增加欄位名稱
                                $ar = $this->data[0];
                                $ar[] = $work[1];
                                $this->data[0] = $ar;
                            }

                            // 增加新增後的資料

                            // 條件式增加
                            if (count($work) > 3)
                            {
                                if ($work[3] == "if")
                                {
                                    for ($i = 1; $i < count($this->data); $i++)
                                    {
                                        $ar = $this->data[$i];
                                        if ($ar[$work[4]] == $work[5])
                                            $ar[] = str_replace ("@primarykey@", $ar[0], $work[2]);
                                        else
                                            $ar[] = "";

                                        $this->data[$i] = $ar;
                                    }
                                }
                            }
                            // 無條件式增加
                            else
                            {
                                for ($i = 1; $i < count($this->data); $i++)
                                {

                                    $ar = $this->data[$i];                                
                                    $ar[] = str_replace("@primarykey@", $ar[0], $work[2]);
                                    $this->data[$i] = $ar;
                                }
                            }


                        }
                        // 作資料的判斷更改作業
                        else if ($work[0] == "if")
                        {
                            for ($i = 1; $i < count($this->data); $i++)
                            {
                                $ar = $this->data[$i];

                                if ($ar[$work[1]] == $work[2])
                                    $ar[$work[1]] = $work[3];

                                $this->data[$i] = $ar;
                            }

                        }
                         // 作資料欄位的合並作業 例如:{combine,1,2,合併後名稱}
                        else if ($work[0] == "combine")
                        {   
                            $a1 = $work[1];
                            $a2 = $work[2];

                            for ($i = 1; $i < count($this->data); $i++)
                            {
                                $ar = $this->data[$i];
                                $ar[$a1] = $ar[$a1] + "<br/>" + $ar[$a2];

                                unset($ar[$a2]);

                                $this->data[$i] = $ar;
                            }

                            $ar2 = $this->data[0];

                            $ar2[$a1] = $work[3];
                        }
                        // 作資料欄位的合並作業 例如:{combine2,合並欄位1,合併欄位2,合併後名稱}
                        else if ($work[0] == "combine2")
                        {
                            $ar_header = $this->data[0];
                            $a1=100;
                            $a2=100;

                            for ($i = 0; $i < count(ar_header); $i++ )
                            {
                                if ($ar_header[$i] == $work[1])
                                    $a1 = $i;
                                if ($ar_header[$i] == $work[2])
                                    $a2 = $i;
                            }

                            for ($i = 1; $i < count($this->data); $i++)
                            {
                                $ar = $this->data[$i];

                                $ar[$a1] = $ar[$a1] + "<br/>" + $ar[$a2];

                                unset($a[$a2]);

                                $this->data[$i] = $ar;

                            }



                            $ar2 = $this->data[0];
                            unset($ar2[$a2]);
                            $ar2[$a1] = $work[3];

                            $this->data[0] = $ar;
                        }
                    }

                    
                }
	
		
	}
?>