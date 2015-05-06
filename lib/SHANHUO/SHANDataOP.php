<?php

/* 名稱：善活系統資料操作者
 * 編寫：林廷鴻
 * 日期：2012/10/11
 * 
 * 此物件的功能是用在善活系統的開發時的特殊操作
 * 和簡化工作的流程
 * 
 * 
 * 
 * 
 * 
 * 
 */

class SHANDataOP
{
    
    private $sqlop;

    public function __construct($sqlop)
    {
        $this->sqlop = $sqlop; 
    }
    
    public function clearSetting()
    {
        $this->sqlop->setRelation(null);
        $this->sqlop->set_order_by(null);
        $this->sqlop->set_condition(null); 
    }
    
    public function setRelation($relation)
    {
         $this->sqlop->setRelation($relation);        
    }
    
    public function setOrderBy($orderBy)
    {
        $this->sqlop->set_order_by($orderBy);        
    }
    
    public function setCondition($condition)
    {
         $this->sqlop->set_condition($condition); 
    }
    
    public function getData($db_table,$show_db_item)
    {
        $this->sqlop->set_condition(array(array($db_table,$db_table . "_valid>=0")));
        
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");                
    }
    
    public function getSeqData($db_table,$show_db_item)
    {
        $this->sqlop->set_order_by(array(array($db_table,$db_table . "_seq desc")));
        $this->sqlop->set_condition(array(array($db_table,$db_table . "_valid>=0")));
        
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");                
    }
    
    public function getData2($db_table,$show_db_item)
    {        
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");    
    }
    
    public function getSeqDataInCondition($db_table,$show_db_item,$condition)
    {        
        $condition[] = array($db_table,$db_table . "_valid>=0");        
        $this->sqlop->set_condition($condition);
        $this->sqlop->set_order_by(array(array($db_table,$db_table . "_seq desc")));
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");    
    }
    
    public function getDataInCondition($db_table,$show_db_item,$condition)
    {        
        $condition[] = array($db_table,$db_table . "_valid>=0");        
        $this->sqlop->set_condition($condition);
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");    
    }
    
        
    public function getDataInConditionHasHeader($db_table,$show_db_item,$condition)
    {        
        $condition[] = array($db_table,$db_table . "_valid>=0");        
        $this->sqlop->set_condition($condition);
        return $this->sqlop->getData("showHeader",$db_table,$show_db_item,$db_table . "_id");    
    }
    public function getColumnDataInCondition($db_table,$columnName,$condition)
    {               
        $condition[] = array($db_table,$db_table . "_valid>=0");        
        $this->sqlop->set_condition($condition);        
        $show_db_item[] = array($columnName,"noName","0");
        $data = $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");    
        return $data[0][1];
    }
    
    //public function getDataInCondition($db_table,$show_db_item,$condition)
    //{        
    //    $this->sqlop->set_condition($condition); 
    //    return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");    
    //}
    
        //取得指定欄位的資料(多重欄位)
    public function getDataWithKey($db_table,$show_db_item,$primaryKeyValue)
    {
        $this->sqlop->set_condition(array(array($db_table,$db_table . "_id=" . $primaryKeyValue)));
        
        return $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");                
    }
    
    //取得指定欄位的資料(多重欄位)
    public function getDataWithKeyHasHeader($db_table,$show_db_item,$primaryKeyValue)
    {
        $this->sqlop->set_condition(array(array($db_table,$db_table . "_id=" . $primaryKeyValue)));
        
        return $this->sqlop->getData("showHeader",$db_table,$show_db_item,$db_table . "_id");                
    }

    //取得指定欄位的資料(單一欄位)
    public function getColumnDataWithKey($db_table,$columnName,$primaryKeyValue)
    {
        $this->clearSetting();
        
        $this->sqlop->set_condition(array(array($db_table,$db_table . "_id=" . $primaryKeyValue)));
        
        $show_db_item[] = array($columnName,"noName","0");
        
        $dt = $this->sqlop->getData("noneHeader",$db_table,$show_db_item,$db_table . "_id");       
        
        return $dt[0][1];
    }
    
    public function updateDataWithKey($TableName, $Update,$primaryKeyValue)
    {
        $Update[$TableName . "_udate"] = "now()";
        
        return $this->sqlop->updateData($TableName, $Update,$TableName . "_id", $primaryKeyValue);
    }
    
    public function updateDataInCondition($TableName, $Update,$column,$value)
    {
        $Update[$TableName . "_udate"] = "now()";
        
        return $this->sqlop->updateData($TableName, $Update,$column, $value);
    }
    
    public function deleteDataWithKey($db_table,$primaryKeyValue)
    {
        $updateData[$db_table . "_valid"] = "-1";
                
        return $this->updateDataWithKey($db_table,$updateData,$primaryKeyValue);        
    }
    
    public function deleteDataInCondition($db_table,$column,$value)
    {
        $updateData[$db_table . "_valid"] = "-1";
                
        return $this->updateDataInCondition($db_table,$updateData,$column,$value);        
    }
    
    public function addDataReturnKey($db_table,$data)
    {
        $data[$db_table . "_cdate"] = "now()";
        
        return $this->sqlop->AddData($db_table,$data);
    }
    
    // 判斷此資料表的欄位是否已擁有此值
    public function hasValue($db_table,$columnName,$checkVaue,$preID)
    {
        $this->clearSetting();
        
        $condition[] = array($db_table, $db_table . "_valid>=0");
        $condition[] = array($db_table, $columnName . "='$checkVaue'");
        if($preID != null) $condition[] = array($db_table, $db_table . "_id != $preID");               
        
        $this->setCondition($condition);
            
        $dt = $this->getData2($db_table,
                    array(
                        array($columnName,"",0)
                    )                
                );
       
        
        if(count($dt[0]) > 0) return true; // 有此值
        else return false;              // 無此值        
    }

}
?>
