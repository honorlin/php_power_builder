<?php
        require 'lib/DataBase/DBWorker.php';
        require 'lib/SHANHUO/ListForLooking.php';   
        require 'lib/DataBase/SqlOperator.php';
        require 'lib/UI/HtmlTable_2.php';
        require 'lib/SHANHUO/SHANDataOP.php';
        require 'lib/daho/daho.php';
        require 'lib/daho/EngineeringDailyReport.php';
        require 'lib/file/file_uploader.php';
        require 'lib/common/function01.php';
        require 'template/common/HtmlUIElement.php';
        require 'template/common/HtmlUIElement2.php';
        require 'lib/SHANHUO/Competence.php';
        require 'lib/SHANHUO/pageOP.php';
        require 'config.php';
?>

<?php 
        $MySql_Worker = new MySql_Worker(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$db_worker = new db_worker($MySql_Worker);      
        $sqlop = new SqlOperator($db_worker);        
        $SHANDataOP1 = new SHANDataOP($sqlop); // 善活系統專用資料操作者
?>


<?php

// 不判斷使用權限的頁面

$no_check_competence = array('main','manager_menu','manager_main','image_upload','file_upload',"1601","1602");

// 判斷使用者是否有登入
    
    $this_page = str_replace('.php', '',basename($_SERVER['REQUEST_URI']));
    
    $d = explode('?', $this_page);
    
    $this_page = $d[0];

    if($this_page != "b_login" && $this_page != "login")
    {
        if(!isset($_SESSION["user_name"]))
        {           
            header("location:login.php");
            exit;
        }
         
        // 這幾個頁面載入不判斷權限
        if(!in_array($this_page, $no_check_competence))
        {
            // 判斷使用者是否有權限

            $page_competence['0301'] = 1;
            $page_competence['0302'] = 1;
            $page_competence['0601'] = 1;
            $page_competence['0602'] = 1;
            
            $page_competence['2501'] = 2;
            $page_competence['2502'] = 2;
            $page_competence['2901'] = 2; //施工規格設定
            $page_competence['2902'] = 2; //施工規格設定
            
            $page_competence['0501'] = 3;
            $page_competence['0502'] = 3;
            $page_competence['2601'] = 3;
            $page_competence['0701'] = 3;
            $page_competence['0702'] = 3;
            $page_competence['0901'] = 3;
            $page_competence['0902'] = 3;
            
            $page_competence['1001'] = 4;
            $page_competence['1002'] = 4;
            $page_competence['1003'] = 4;
            $page_competence['1004'] = 4;
            $page_competence['1101'] = 4;
            $page_competence['1102'] = 4;
            $page_competence['1201'] = 4;
            $page_competence['1202'] = 4;
            
            $page_competence['2001'] = 5;
            $page_competence['2002'] = 5;
            
            $page_competence['1901'] = 6;
            $page_competence['1902'] = 6;
            
            $page_competence['2301'] = 7;
            $page_competence['2302'] = 7;
            
            $page_competence['1801'] = 8;
            $page_competence['1802'] = 8;
            
            $page_competence['0201'] = 9;
            $page_competence['0202'] = 9;
            
            $page_competence['0101'] = 10;
            $page_competence['0102'] = 10;
            
            $page_competence['0801'] = 11;
            $page_competence['0802'] = 11;
            $page_competence['3201'] = 12;
            $page_competence['3202'] = 12;
            
            $page_competence['0401'] = 12;
            $page_competence['0402'] = 12;
            $page_competence['3101'] = 12;
            $page_competence['3102'] = 12;
            
            $page_competence['2401'] = 13;
            $page_competence['2402'] = 13;
            
            $page_competence['2101'] = 14;
            $page_competence['2102'] = 14;
            
            $page_competence['1301'] = 15;
            $page_competence['1302'] = 15;
            
            $page_competence['1501'] = 16;
            $page_competence['1502'] = 16;

            $page_competence['1401'] = 17;
            $page_competence['1402'] = 17;
            
            $page_competence['1701'] = 18;
            $page_competence['1702'] = 18;
            
            $page_competence['2201'] = 19;
            $page_competence['2202'] = 19;
            
            $page_competence['2701'] = 20;
            $page_competence['2702'] = 20;
            $page_competence['2801'] = 20;
            $page_competence['2802'] = 20;

            // 案件單複製
            $page_competence['3301'] = 21;
            $page_competence['3301'] = 21;

            // 判斷使用者是否有權限

            $competence = $_SESSION["competence"];                  

            $this_index = $page_competence[$this_page];          

           if($competence[0][$this_index] == 0)
           {        
               header("location:login.php");
               exit;
           }  
        }
    }
?>

 