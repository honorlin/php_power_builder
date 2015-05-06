<?php

/* ＠大合 工程管理暨業務成案查詢整合系統 專用函式
 * ＠編寫：林廷鴻
 * ＠日期：2013/03/20
 * 
 * 
 * ＠2013/4/11: 
 * 增加客戶編號更新功能
 * 傳入客戶編號就可以判斷原來的編號和最新的客戶分類
 * 是否是同一組編號,如果換分類,自動更新編號
 * 
 * 增加取得客戶編號的功能
 * 傳入分類ID就可以回傳最新的編號
 * 編號法則是,取得此分類編號的最大值+1回傳
 * 
 * 
 * 
 */


    class crm
    {
        
        public function get_contact_person_info($customer_company_id)
        {
            if(isset($customer_company_id))
            {
                global $SHANDataOP1;

                $dt = $SHANDataOP1->getDataInConditionHasHeader("customer_contact_person",
                            array(
                                array("customer_contact_person_name","聯絡人",0),
                                array("customer_contact_person_ext","分機",1),
                                array("customer_contact_personmobile_tel","行動",2),
                                array("customer_contact_person_email","Email",3)
                            )
                            ,
                            array(
                                array("customer_contact_person","customer_company_id=$customer_company_id")                            
                            )
                        );

                $data = array();
                
                for($i=1;$i<count($dt);$i++)
                {
                    $s = "";
                    for($j=1;$j<=3;$j++)
                        if($dt[$i][$j] != "")
                        {
                            $header = $dt[0][$j];
                            $s .= "｜{$header}：{$dt[$i][$j]}";
                        }
                
                    $data[$dt[$i][0]] = $s;
                }   

                echo json_encode($data);

                exit;
            }                        
        }
        
        // 取得公司電話
        public function get_company_tel($customer_company_id)
        {
            if(isset($customer_company_id))
            {
                global $SHANDataOP1;

                $dt = $SHANDataOP1->getDataWithKeyHasHeader("customer_company",
                            array(
                                array("customer_company_tel_01","電話1",0),
                                array("customer_company_tel_02","電話2",1),
                                array("customer_company_tel_03","電話3",2),
                                array("customer_company_tel_04","電話4",3)
                            )
                            ,
                            $customer_company_id
                        );

                $data = array();
                
                for($i=1;$i<count($dt);$i++)
                {                    
                    for($j=1;$j<=3;$j++)
                        if($dt[1][$j] != "")
                        {
                            $s = "";
                            
                            $header = $dt[0][$j];
                            $s = "｜{$header}：{$dt[$i][$j]}";
                            
                           $data[] = $s;
                        }
                
                   
                }   

                echo json_encode($data);

                exit;
            }                        
        }
        
    // 更新客戶編號
    public static function updateCustomerCompanyNumber($CustomerCompanyID)
    {
        global $SHANDataOP1;

        
        // 讀出客戶分類和編號
                
        $dt = $SHANDataOP1->getDataWithKey("customer_company",
                array(
                    array('customer_company_class','',0),
                    array('customer_company_number','',1)
                )
                ,$CustomerCompanyID);
        
        $customer_compnay_class = $dt[0][1]; 
        $customer_company_number = $dt[0][2];
        
        // 假如客戶分類有更新
        if(strrpos($customer_company_number,$customer_compnay_class) === FALSE)
        {            
            // 取得最新的客戶編號
            $new_customer_companny_number = crm::getTheNewestCustomerCompanyNumber($customer_compnay_class,$CustomerCompanyID);

            // 更新此新的客戶編號進入資料庫
            
            $ret = $SHANDataOP1->updateDataWithKey("customer_company",array('customer_company_number' =>$new_customer_companny_number),$CustomerCompanyID);
        }
               
        return $ret;             
    }
    
    // 取得此客戶分類的最新的編號
    public function getTheNewestCustomerCompanyNumber($CustometCompanyClass,$CustomerCompanyID)
    {
        global $db_worker;
        
        $dt = $db_worker->perform("select customer_company_number from customer_company where customer_company_class='$CustometCompanyClass' and customer_company_id <> $CustomerCompanyID order by customer_company_number desc");             
        
        if(mysql_num_rows($dt) > 0)
        {
            $d = mysql_result($dt,0,'customer_company_number');
        
            $c = substr($d, 1);
        
            $count = intval($c);
            $count ++;
        }
        else 
            $count = 1;
        
        if(strlen($count) == 1)
            $proCount = "000" . $count;
        elseif(strlen($count) == 2)
            $proCount = "00" . $count;
        elseif(strlen($count) == 3)
            $proCount = "0" . $count;
     
        return $CustometCompanyClass . $proCount;
        
    }
    
    }    
    
    
?>
