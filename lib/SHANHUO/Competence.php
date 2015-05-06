<?php



class Competence
{
    
           
    function checkCompetence($system_user_id)
    {

        global $SHANDataOP1;

        $SHANDataOP1->clearSetting();
        $SHANDataOP1->setCondition(
                array(
                    array("competence","system_user_id=$system_user_id")
                    )
                );

        $ds =  $SHANDataOP1->getData2("competence",
                array(
                    array("system_user_id","user",0),                         
                    )               
                );   


        if(count($ds[0]) == 0)
        {
            $SHANDataOP1->addDataReturnKey("competence",
                array(
                    "system_user_id"=>$system_user_id,
                    "competence_01"=>0,
                    "competence_02"=>0,     
                    "competence_03"=>0,
                    "competence_04"=>0, 
                    "competence_05"=>0,
                    "competence_06"=>0,     
                    "competence_07"=>0,
                    "competence_08"=>0,
                    "competence_09"=>0,
                    "competence_10"=>0,     
                    "competence_11"=>0,
                    "competence_12"=>0, 
                    "competence_13"=>0,
                    "competence_14"=>0,     
                    "competence_15"=>0,
                    "competence_16"=>1, 
                    "competence_17"=>0,
                    "competence_18"=>0,
                    "competence_19"=>0,
                    "competence_20"=>0,
                    "competence_21"=>0
                    )               
                );   


        }

    }

    function getCompetence($system_user_id)
    {

        global $SHANDataOP1;

        $SHANDataOP1->clearSetting();
        $SHANDataOP1->setCondition(
                array(
                    array("competence","system_user_id=$system_user_id")
                    )
                );

        $ds =  $SHANDataOP1->getData2("competence",
                array(
                    array("competence_01","業務案件管理",0),
                    array("competence_02","業務案件(鑽探)",1),
                    array("competence_03","工程管理",2),
                    array("competence_04","工程日報表",3),
                    array("competence_05","材料耗用量表",4),
                    array("competence_06","耗油量統計表",5),
                    array("competence_07","計價數量明細表",6),
                    array("competence_08","工程進度表",7),
                    array("competence_09","公司管理",8),
                    array("competence_10","工法設定",9),
                    array("competence_11","專案工程師管理",10),
                    array("competence_12","工班管理",11),
                    array("competence_13","業務案件統計",12),
                    array("competence_14","系統權限設定",13),
                    array("competence_15","使用者管理",14),
                    array("competence_16","個人管理",15),
                    array("competence_17","職務管理",16),
                    array("competence_18","附檔類型",17),
                    array("competence_19","工程材料",18),
                    array("competence_20","客戶管理",19),
                    array("competence_21","證照類型",20)  
                    )               
                );   

        $_SESSION["competence"] = $ds;


    }





    
}



?>
