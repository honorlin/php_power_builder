<?php
    /*
     * @名稱：善活系統系統產生器
     * @編寫：林廷鴻
     * @日期：2013/02/06
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */


     require_once 'db_generator.php';
     require_once 'template_generator.php';
     
     date_default_timezone_set('Asia/Taipei');

     class daho_sys_generator
     {
        
         // 廠商資料表
         public function customer_company() 
         {
                               
            // 資料表產生

            $schema['customer_company_id'] = 'bigint(20)';
            $schema['customer_company_number'] = 'varchar(50)';
            $schema['customer_company_name'] = 'varchar(10)';
            $schema['customer_company_person_in_charge'] = 'int(11)';
            $schema['customer_company_unified_numbering'] = 'varchar(200)';
            $schema['customer_company_tel_01'] = 'varchar(200)';
            $schema['customer_company_tel_02'] = 'varchar(200)';
            $schema['customer_company_tel_03'] = 'varchar(200)';       
            $schema['customer_company_tel_04'] = 'varchar(200)';
            $schema['customer_company_fax'] = 'varchar(200)';
            $schema['customer_company_address'] = 'varchar(200)';  
            $schema['customer_company_address_area_code'] = 'varchar(200)';
            $schema['customer_company_site contact'] = 'varchar(200)';
            $schema['customer_company_jobsite_director'] = 'varchar(200)';      
            $schema['customer_company_valid'] = 'int(11)';
            $schema['customer_company_cdate'] = 'datetime';
            $schema['customer_company_udate'] = 'datetime';             

            db_generator::generator('customer_company',$schema);  
             
         }
                  
         // 廠商聯絡人資料表         
         public function customer_contact()
         {
             
              // 資料表產生

            $schema['customer_contact_person_id'] = 'bigint(20)';
            $schema['customer_company_id'] = 'bigint(20)';
            $schema['customer_contact_person_name'] = 'varchar(100)';
            $schema['customer_contact_person_ext'] = 'varchar(100)';
            $schema['customer_contact_personmobile_tel'] = 'varchar(100)';
            $schema['customer_contact_person_email'] = 'varchar(100)';
            $schema['customer_contact_person_valid'] = 'int(11)';
            $schema['customer_contact_person_cdate'] = 'datetime';
            $schema['customer_contact_person_udate'] = 'datetime';             

            db_generator::generator('customer_contact',$schema);  
             
         }
         
      
     }
     



?>
