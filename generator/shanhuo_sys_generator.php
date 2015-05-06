<?php

    /*
     * @名稱：善活系統系統產生器
     * @編寫：林廷鴻
     * @日期：2013/01/21
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

     class shanhuo_sys_generator
     {
         // 電子報管理產生
         public function e_paper() 
         {
                 
            $systitle = "24";
            $systitle_2 = "25";
            $sysengname = 'e_paper';
            $sysname = '電子報';
                     
            // 主項目管理資料表產生
            
            db_generator::generator_type01($sysengname);
            
            // 分類管理資料表產生
            
            db_generator::generator_type02("{$sysengname}_class");
            
            // 主項目管理程式檔產生
                
                // 01 產生               

                $file = file_get_contents('shanhuo_sys/shanhuo_sys_001/shanhuo_sys_template_0101.php', true); 

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}01.php",$file);

                // 02產生

                $file = file_get_contents('shanhuo_sys/shanhuo_sys_001/shanhuo_sys_template_0102.php', true);

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}02.php",$file);

           // 分類管理程式檔產生
           
                // 01 產生

                $file = file_get_contents('shanhuo_sys/shanhuo_sys_001/shanhuo_sys_template_0201.php', true); 

                $file = str_replace('@SYSTITLE', $systitle_2, $file);
                $file = str_replace('@SYSDBNAME', "{$sysengname}_class", $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle_2}01.php",$file);

                // 02產生

                $file = file_get_contents('shanhuo_sys/shanhuo_sys_001/shanhuo_sys_template_0202.php', true);

                $file = str_replace('@SYSTITLE', $systitle_2, $file);
                $file = str_replace('@SYSDBNAME', "{$sysengname}_class", $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle_2}02.php",$file);
    
         }
         
         // 個人EMAIL管理
         public function person_email() 
         {
            $systitle = "26";
            $sysengname = 'person_email';
            $sysname = 'EMAiL管理';
             
            // 資料表產生

            $schema['person_email_id'] = 'bigint(20)';
            $schema['person_email_name'] = 'varchar(200)';
            $schema['person_email_address'] = 'varchar(200)';
            $schema['person_email_remark'] = 'varchar(3000)';
            $schema['person_email_group'] = 'varchar(200)';
            $schema['person_email_valid'] = 'int(11)';
            $schema['person_email_cdate'] = 'datetime';
            $schema['person_email_udate'] = 'datetime';             

            db_generator::generator('person_email',$schema);                          
             
              // 主項目管理程式檔產生
                
                // 01 產生               

                $file = file_get_contents('shanhuo_sys/person_email/shanhuo_sys_template_0201.php', true); 

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}01.php",$file);

                // 02產生

                $file = file_get_contents('shanhuo_sys/person_email/shanhuo_sys_template_0202.php', true);

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}02.php",$file);
             
             
         }
         
          // 電子報任務
         public function e_paper_task() 
         {
            $systitle = "27";
            $sysengname = 'e_paper_task';
            $sysname = '電子報發送任務';
             
            // 資料表產生

            $schema['e_paper_task_id'] = 'bigint(20)';
            $schema['e_paper_task_title'] = 'varchar(200)';
            $schema['e_paper_id'] = 'bigint(20)';
            $schema['e_paper_task_status'] = 'int(11)';
            $schema['e_paper_task_progress'] = 'int(11)';
            $schema['e_paper_task_remark'] = 'varchar(3000)';
            $schema['e_paper_task_valid'] = 'int(11)';
            $schema['e_paper_task_cdate'] = 'datetime';
            $schema['e_paper_task_udate'] = 'datetime';             

            db_generator::generator('e_paper_task',$schema);                          
             
              // 主項目管理程式檔產生
                
                // 01 產生               

                $file = file_get_contents('shanhuo_sys/e_paper_task/shanhuo_sys_template_0101.php', true); 

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}01.php",$file);

                // 02產生

                $file = file_get_contents('shanhuo_sys/e_paper_task/shanhuo_sys_template_0102.php', true);

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}02.php",$file);
             
             
         }
         
          // 電子報發送詳細
         public function e_paper_task_detail() 
         {
             
             $systitle = "28";
             $sysengname = 'e_paper_send_task';
             $sysname = '電子報發送詳細';
             
             // 資料表產生
             
               // 資料表產生

            $schema['e_paper_send_task_id'] = 'bigint(20)';
            $schema['e_paper_task_id'] = 'bigint(20)';
            $schema['e_paper_id'] = 'bigint(20)';
            $schema['e_paper_send_task_email_name'] = 'varchar(200)';
            $schema['e_paper_send_task_email_address'] = 'varchar(200)';
            $schema['e_paper_send_task_status'] = 'int(11)';
            $schema['e_paper_send_task_msg'] = 'varchar(3000)';
            $schema['e_paper_send_task_valid'] = 'int(11)';
            $schema['e_paper_send_task_cdate'] = 'datetime';
            $schema['e_paper_send_task_udate'] = 'datetime';             

            db_generator::generator('e_paper_send_task',$schema);  
                        
             
              // 主項目管理程式檔產生
                
                // 01 產生               

                $file = file_get_contents('shanhuo_sys/e_paper_task/shanhuo_sys_template_0201.php', true); 

                $file = str_replace('@SYSTITLE', $systitle, $file);
                $file = str_replace('@SYSDBNAME', $sysengname, $file);
                $file = str_replace('@SYSNAME', $sysname, $file);
                $file = str_replace('@CREATEDATE', date('Y/m/d H:i:s'), $file);

                file_put_contents("{$systitle}01.php",$file);
            
             
         }
         
           // 電子報發送詳細
         public function e_paper_smpt() 
         {
             
     
             
               // 資料表產生

            $schema['e_paper_smpt_id'] = 'bigint(20)';
            $schema['e_paper_smtp'] = 'varchar(50)';
            $schema['e_paper_smtp_is_ssl'] = 'varchar(10)';
            $schema['e_paper_smtp_port'] = 'int(11)';
            $schema['e_paper_smtp_account'] = 'varchar(200)';
            $schema['e_paper_smpt_password'] = 'varchar(200)';
            $schema['e_paper_smpt_valid'] = 'int(11)';
            $schema['e_paper_smpt_cdate'] = 'datetime';
            $schema['e_paper_smpt_udate'] = 'datetime';             

            db_generator::generator('e_paper_smpt',$schema);  
                        
             
           
            
             
         }
         
         
      
     }
     
?>
