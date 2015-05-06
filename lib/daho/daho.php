<?php

/* 大合 工程管理暨業務成案查詢整合系統 專用函式
 * 編寫：林廷鴻
 * 日期：2012/10/16
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */

class daho {
    //put your code here
    
    // 根據工法id和承攬公司的id去產生新的工程編號
    public static function getEngineerNumber($work_type_id,$project_quoted_company_id,$preProjectID)
    {
        global $SHANDataOP1;
        
         date_default_timezone_set('Asia/Taipei');;
        
        // 取得此工法的代碼
        $work_type_code = $SHANDataOP1->getColumnDataWithKey("work_type","work_type_code",$work_type_id);
        
        // 取得此公司的代碼
        $company_code = $SHANDataOP1->getColumnDataWithKey("company","company_code",$project_quoted_company_id);
            
        // 取得年份代碼        
        $year_code =substr(date("Y"),2,2);
        
        // 產生工程編號標頭
        $projectNumberHeader = $work_type_code.$year_code; // 工法代碼 + 年份代碼 
        
        global $db_worker;                
        
        // 取得目前系統裡有此工程編號標頭的數量
        if($preProjectID == null) // 新案件
            $dt = $db_worker->perform("select count(*) from project where project_quoted_number like '$projectNumberHeader%' and project_valid>=0");
        else  // 已存在案件,所以不能算到本身的案件
             $dt = $db_worker->perform("select count(*) from project where project_quoted_number like '$projectNumberHeader%' and project_id != $preProjectID and project_valid>=0");
        
        $pre_count = mysql_result($dt, 0,"count(*)");
        
        $new_count = $pre_count + 1; // 將目前的數量+1來產生新的流水號
        
        if(strlen($new_count) == 1)
            $new_count = "00$new_count";
        else if(strlen($new_count) == 2)
            $new_count = "0$new_count";
                       
        return  $projectNumberHeader . $new_count . $company_code; // 回傳產生的工程編號
    }
    
    // 根據功法id去產生報價編號
    public static function getQuotedNumber($work_type_id,$preProjectID)
    {
        global $SHANDataOP1;
        global $sqlop;
        global $db_worker;
        
        date_default_timezone_set('Asia/Taipei');;       
         
        // 取得此工法的代碼
        $work_type_code = $SHANDataOP1->getColumnDataWithKey("work_type","work_type_code",$work_type_id);
          
        //$sql = "select project_number from project where year(project_cdate)=year(now()) and month(project_cdate)=month(now()) and project_number like '%$work_type_code%' and project_valid>=0 order by project_number desc"; 

        //echo $sql;
        
        if($preProjectID == null) // 新案件
            $dt = $db_worker->perform("select project_number,project_cdate from project where year(project_cdate)=year(now()) and month(project_cdate)=month(now()) and project_number like '%$work_type_code%' and project_valid>=0 order by project_number desc");
        else 
            $dt = $db_worker->perform("select project_number,project_cdate from project where year(project_cdate)=year(now()) and month(project_cdate)=month(now()) and project_id != $preProjectID and project_number like '%$work_type_code%' and project_valid>=0 order by project_number desc");
       
        //echo mysql_result($dt, 0,"project_number");
        
        if(mysql_num_rows($dt) == 0)
            $count = 0;
        else
        {
           $dd = split("-", mysql_result($dt, 0,"project_number"));            
           $v = (int)$dd[1];
           $count = $v;
        }     
        
        //echo $count;
        
        $count = $count + 1;      
        
        $timeHeader =(date("Y") - 1911) . date("m"); 
        $proCount = "";

        if(strlen($count) == 1)
            $proCount = "00" . $count;
        elseif(strlen($count) == 2)
            $proCount = "0" . $count;
        elseif(strlen($count) == 3)
            $proCount = $count;
        
     
        $thisProjectNumber = $work_type_code . $timeHeader . "-" . $proCount;
        
        return $thisProjectNumber;
        
    }
    
    // 根據組別的id取得此組的進機日
function getIntoMachineDayByGroupId($group_id)
{
    global $SHANDataOP1;


    // 進機日

    $SHANDataOP1->clearSetting();
    $SHANDataOP1->setOrderBy(
            array(
                array("engineering_daily_report","engineering_daily_report_id asc")                          
            )
        );
    $SHANDataOP1->setCondition(
        array(
                array("engineering_daily_report","engineering_daily_report_project_group_id=" . $group_id),
                array("engineering_daily_report","engineering_daily_report_valid>=0")
            )
        );
    $dt5 = $SHANDataOP1->getData2(
    "engineering_daily_report",
        array(
            array("engineering_daily_report_work_day","工作日期",0)
        )
    );

    $inday = $dt5[0][1];
    
    return $inday;
    
}

// 根據組別的id取得此組的撤機日
function getToruMachineDayByGroupId($group_id)
{
    
     global $SHANDataOP1;
    
 // 撤機日
                    
    $SHANDataOP1->clearSetting();

    $SHANDataOP1->setCondition(
                array(
                        array("engineering_daily_report","engineering_daily_report_project_group_id=" . $group_id),
                        array("engineering_daily_report","engineering_daily_report_valid>=0"),
                        array("engineering_daily_report","engineering_daily_report_toru_machine=1")
                    )
                );
    $dt6 = $SHANDataOP1->getData2(
            "engineering_daily_report",
                array(
                    array("engineering_daily_report_work_day","工作日期",0)
                )
            );

    $outDay = $dt6[0][1];
    
    return $outDay;

    
}

    
}

?>
