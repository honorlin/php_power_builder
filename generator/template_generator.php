<?php

    /* @系統：iweb
     * @名稱：善活系統樣板樣版產生器
     * @編寫：林廷鴻
     * @日期：2013/01/21
     * 
     * 根據 shanhuo_sys_template_01,和 shanhuo_sys_template_02
     * 兩個基本樣板,產生進階樣板
     * 
     * 
     * 
     * 
     * 
     * 
     */
/*
     class template_generator
     {
         
         // 根據基本樣板產生樣板01產生 type_01
         public function generator_type_01()
         {             
            $file = file_get_contents('shanhuo_sys_template_01.php', true);    
             
            $data['@SEARCHITEM'] = '"@SYSNAME名稱","@SYSNAME分類"';
            $data['@ORDERBYITEM']  = '"@SYSNAME名稱","@SYSNAME分類"';
            $data['@SHOWDBITEM'] = 'array(("@SYSDBNAME_title","@SYSNAME名稱",1))';
            $data['@RELATION'] = 'array(
                                        array("@SYSDBNAME","@SYSDBNAME_class_id","@SYSDBNAME_class","@SYSDBNAME_class_id","@SYSDBNAME_class_title","@SYSNAME分類",0), 
                                  );';
            
            $data['@@PROCESS'] = "";
            $data['@@CONDITION'] = "";
            
            foreach($data as $k => $v)
            {
                $file = str_replace($k, $v, $file);                
            }            
         }
         
         // 根據基本樣板產生樣板02產生 type_02
         public function generator_type_02()
         {             
            $file = file_get_contents('shanhuo_sys_template_02.php', true);    
   
            $data['@SHOWDBITEM'] =
            'array(
                array("@SYSDBNAME_class_id","@SYSNAME分類",0,"","DropList",""),   
                array("@SYSDBNAME_title","@SYSNAME標題",1,"","text",""),   
                array("@SYSDBNAME_content","@SYSNAME內容",2,"","html_editor",""),                      
            );';
            
            $data['@RELATION'] = 'array(
                                        array("@SYSDBNAME","@SYSDBNAME_class_id","@SYSDBNAME_class","@SYSDBNAME_class_id","@SYSDBNAME_class_title","@SYSNAME分類",0), 
                                  );';
            
            $data['@@PROCESS'] = "";
            $data['@@CONDITION'] = "";
            
            foreach($data as $k => $v)
            {
                $file = str_replace($k, $v, $file);                
            }    
             
         }
         
         
         
     }

*/
?>
