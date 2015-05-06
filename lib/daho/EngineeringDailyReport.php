<?php

 /* 大合日報表專用物件
  * 編寫：林廷鴻
  * 日期：2012/10/31
  * 
  * 
  * 
  * 
  * 
  */

    class EngineeringDailyReport
    {
        
        
        // 取得此案件最後一個日報表原物料庫存
        public function getLastReportMaterialInventory($engineering_daily_report_id)
        {
            global $SHANDataOP1;         
            
            // 讀取此日報表的案件ID和組別索引
    
            
             $dt0 = $SHANDataOP1->getDataWithKey("engineering_daily_report",
                    array(
                        array("engineering_daily_report_project_id","案件ID",0),  
                        array("engineering_daily_report_project_group_id","案件組別ID",1)
                        ),
                     $engineering_daily_report_id
                    );
             
            $engineering_daily_report_project_id = $dt0[0][1];
            $engineering_daily_report_project_group_id = $dt0[0][2];

            // 取得此案件最後一個日報表ID
            $SHANDataOP1->setCondition(
                    array(
                        array("engineering_daily_report","engineering_daily_report_valid>=0"),      
                        array("engineering_daily_report","engineering_daily_report_project_id=" . $engineering_daily_report_project_id),
                        array("engineering_daily_report","engineering_daily_report_project_group_id=" . $engineering_daily_report_project_group_id) 
                        )
                    );          
       
            $SHANDataOP1->setOrderBy(
                     array(
                        array("engineering_daily_report","engineering_daily_report_work_day desc")                            
                        )                    
                    );
            $dt = $SHANDataOP1->getData2("engineering_daily_report",
                    array(
                        array("engineering_daily_report_id","工程日報表ID",0)        
                        )
                    );
            
             //       var_dump($dt);
            
            if(count($dt) <= 1) return null;
            
            $lastReportID = $dt[1][0];
                        
            
            // 取得此日報表的原物料庫存
            
            $SHANDataOP1->setCondition(
                    array(
                        array("material_information","material_information_valid>=0"),      
                        array("material_information","engineering_daily_report_id=" . $lastReportID)
                        )
                    );
            $SHANDataOP1->setOrderBy(null);
            
            $dt = $SHANDataOP1->getData2("material_information",
                    array(
                        array("material_information_name","原物料名稱",0),
                        array("material_information_balances_amount","當日結存",1)
                        )
                    );
            
            // var_dump($dt);
            
            $reData = array();
            
            foreach($dt as $dd)
            {
                $reData[$dd[1]] = $dd[2];                
            }
            
            return $reData;                     
                                    
        }

          // 取得此案件在日期排序後的此案件的上一個日報表原物料庫存
        public function getDateSortLastReportMaterialInventory($engineering_daily_report_id)
        {
            date_default_timezone_set('Asia/Taipei');
     

            global $SHANDataOP1;         
            
            // 讀取此日報表的案件ID和組別索引
    
            
             $dt0 = $SHANDataOP1->getDataWithKey("engineering_daily_report",
                    array(
                        array("engineering_daily_report_project_id","案件ID",0),  
                        array("engineering_daily_report_project_group_id","案件組別ID",1)
                        ),
                     $engineering_daily_report_id
                    );
             
            $engineering_daily_report_project_id = $dt0[0][1];
            $engineering_daily_report_project_group_id = $dt0[0][2];

            // 取得此案件最後一個日報表ID
            $SHANDataOP1->setCondition(
                    array(
                        array("engineering_daily_report","engineering_daily_report_valid>=0"),      
                        array("engineering_daily_report","engineering_daily_report_project_id=" . $engineering_daily_report_project_id),
                        array("engineering_daily_report","engineering_daily_report_project_group_id=" . $engineering_daily_report_project_group_id) 
                        )
                    );          
       
            $SHANDataOP1->setOrderBy(
                     array(
                        array("engineering_daily_report","engineering_daily_report_work_day asc")                            
                        )                    
                    );
            $dt = $SHANDataOP1->getData2("engineering_daily_report",
                    array(
                        array("engineering_daily_report_id","工程日報表ID",0), 
                        array("engineering_daily_report_work_day","工程日報表日期",1)        
                        )
                    );
        
            
            if(count($dt) <= 1) return null;        
            
            // 取得此案件在指定日期的上一個日報表原物料庫存

            
            $is_find = false;

            for($i = 0;$i < count($dt) ;$i++)
            {                
                
                if($engineering_daily_report_id == $dt[$i][0])
                {

                     if($i == 0) return null; // 代表此日報表已是最前面的那一個  

                     //echo  $dt[$i][2] , " , "; 
                     $is_find = true;  

                     //echo  "找到";
                     $lastReportID = $dt[$i-1][0];

                    // echo  "lastReportID:" . $lastReportID;
                     break;
                }
            }

           // if($is_find == false)
           // {
                //echo  $is_find;
           //     $lastReportID = $dt[count($dt)-1][0];
           // }

            // 取得此日報表的原物料庫存
            
            $SHANDataOP1->setCondition(
                    array(
                        array("material_information","material_information_valid>=0"),      
                        array("material_information","engineering_daily_report_id=" . $lastReportID)
                        )
                    );
            $SHANDataOP1->setOrderBy(null);
            
            $dt = $SHANDataOP1->getData2("material_information",
                    array(
                        array("material_information_name","原物料名稱",0),
                        array("material_information_balances_amount","當日結存",1)
                        )
                    );
            
            // var_dump($dt);
            
            $reData = array();
            
            foreach($dt as $dd)
            {
                $reData[$dd[1]] = $dd[2];                
            }
            
            return $reData;                     
                                    
        }
        
        // 取得日報表材料的使用情況
        public function getMaterialInfo($report_id,$material_name)
        {
            
            global $SHANDataOP1; 
            
            $SHANDataOP1->clearSetting();
            
            $SHANDataOP1->setCondition(
                    array(
                        array("material_information","engineering_daily_report_id=$report_id"),      
                        array("material_information","material_information_name='$material_name'")
                        
                        )
                    );

            $dt = $SHANDataOP1->getData2(
                "material_information",
                array(
                    array("material_information_pre_inventory","前期庫存",0),
                    array("material_information_Into_amount","當日進量",1),
                    array("material_information_use_amount","當日用量",2),
                    array("material_information_balances_amount","當日結存",3)
                )
            );
            
            $data[] = $dt[0][1];
            $data[] = $dt[0][2];
            $data[] = $dt[0][3];
            $data[] = $dt[0][4];
            
            return $data;
            
        }
        
        // 取得日報表樁施工完成情況        
        public function getPileInfo($report_id)
        {
            
            global $SHANDataOP1; 
            
            $SHANDataOP1->clearSetting();
            
            $SHANDataOP1->setCondition(
                    array(
                        array("pile_construction_completed","engineering_daily_report_id=$report_id"),   
                        array("pile_construction_completed","pile_construction_completed_valid>=0")                                             
                        )
                    );

            $dt = $SHANDataOP1->getData2(
                "pile_construction_completed",
                array(
                    array("pile_construction_completed_number","樁號",0),
                    array("pile_construction_completed_parameter_01","樁徑/CM",1),
                    array("pile_construction_completed_parameter_02","樁長/M",2),
                    array("pile_construction_completed_parameter_03","支數",3),
                    array("pile_construction_completed_parameter_04","M數",4)
                )
            );
            
            return $dt;
            
        }
        
        // 將此案件的所有日報表做重整

        function re_update_this_project_meterial_inventory_in_engineering_daily_report_id($engineering_daily_report_id)
        {
            // $engineering_daily_report_id =  $_GET["op"];
        
            global $SHANDataOP1;

            // 取得此工程日報表的案件id
            $this_Project_Id = $SHANDataOP1->getColumnDataWithKey('engineering_daily_report','engineering_daily_report_project_id',$engineering_daily_report_id);
            
            // 取得此案件的日報表群組ID
            $this_engineering_daily_report_project_group_id = $SHANDataOP1->getColumnDataWithKey('engineering_daily_report','engineering_daily_report_project_group_id',$engineering_daily_report_id);
                        
            // 取得此案件ID的所有日報表
            $SHANDataOP1->setOrderBy(array(array('engineering_daily_report','engineering_daily_report_work_day asc')));           
            $all_daily_report_id = $SHANDataOP1->getDataInCondition('engineering_daily_report',array(array('engineering_daily_report_id','',0)),array(array('engineering_daily_report','engineering_daily_report_project_id=' . $this_Project_Id),array('engineering_daily_report','engineering_daily_report_project_group_id=' . $this_engineering_daily_report_project_group_id)));
                    
            $SHANDataOP1->clearSetting();
            
            $material_information_balances_amount = 0;
            $material_information_name = "";
            $start_work = false;


            // 取得此案件的工法ID    
            
            $workTypeId = $SHANDataOP1->getColumnDataWithKey("project","work_type_id",$this_Project_Id);
         
            // 取的此工法所使用的原物料
            
            $dt =  $SHANDataOP1-> getDataWithKey("work_type",
                        array(
                             array("work_type_object_1","工法用料1",0),
                             array("work_type_object_2","工法用料2",1),
                             array("work_type_object_3","工法用料3",2),
                             array("work_type_object_4","工法用料4",3),
                             array("work_type_object_5","工法用料5",4),
                             array("work_type_object_6","工法用料6",5),
                             array("work_type_object_7","工法用料7",6),
                             array("work_type_object_8","工法用料8",7),
                             array("work_type_object_9","工法用料9",8),
                             array("work_type_object_10","工法用料10",9),
                        )
                    ,$workTypeId);


            // 將此案件的每個原物料逐步調整

            for($i=1;$i<count($dt[0]);$i++)
            {
                if($dt[0][$i] != "")
                {

                    $material_information_name = $dt[0][$i];

                    $strar_index = 0;
                        
                    foreach($all_daily_report_id as $data)
                    {
                        // 找到更新後的日報表id
                        if($strar_index == 0)
                        {
                            
                            
                            // 開始工作
                            $start_work = true;
                            
                            // 讀取出最新的庫存

                            // 判斷此日報表是否已被刪除

                            //$valid = $SHANDataOP1->getColumnDataWithKey("engineering_daily_report","engineering_daily_report_valid",$engineering_daily_report_id);       

                            //if($valid < 0) // 已被刪除
                            //{
                            //    $material_information_balances_amount = 0;            
                            //}   
                            //else
                            //{
                                    $material_information_balances_amount = $SHANDataOP1->getColumnDataInCondition('material_information',                             
                                         'material_information_balances_amount'
                                     ,                             
                                     array(array('material_information','engineering_daily_report_id=' . $data[0]),array('material_information',"material_information_name='{$material_information_name}'")));
                            //}

                             echo "start:" . $material_information_balances_amount;       

                             // 讀取出材料的名稱
                             
                             
                             
                        }
                        else    
                        {
                            echo $data[0] . ',';
                            
                            $this_ma_data = $SHANDataOP1->getDataInCondition('material_information',
                                    array(
                                        array('material_information_pre_inventory','',0),
                                        array('material_information_Into_amount','',1),
                                        array('material_information_use_amount','',2),
                                        array('material_information_balances_amount','',3)
                                        )
                                    ,
                                    array(array('material_information','engineering_daily_report_id=' . $data[0]),array('material_information',"material_information_name='{$material_information_name}'")));
                        
                            // 庫存沒有變動,結束
                            //if($this_ma_data[0][1] == $material_information_balances_amount)
                            //{
                            //    break;                        
                            //}
                            //else
                            //{
                                // 更新材料資訊
                                
                                $d = ($material_information_balances_amount + $this_ma_data[0][2] - $this_ma_data[0][3]);
                                
                                $SHANDataOP1->updateDataWithKey('material_information',
                                        array('material_information_pre_inventory' => $material_information_balances_amount,
                                              'material_information_balances_amount' => $d
                                            )
                                        ,$this_ma_data[0][0]);
                                
                                $material_information_balances_amount = $d;
                                
                            //}                                                
                        
                        }

                        $strar_index ++;
                        
                        
                    }
            
                }
            }            


        }
        
        
        
        
        
        
   
    }
    
?>
