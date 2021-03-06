<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


   // 取得此項目的Html項目編輯語法
    // getThisHtml(項目名稱,初始值,html樣式,順序)
    function getThisHtml($itemName,$InitialValue,$Htmltype,$seq)
    {
        global $htmlSpecialSet;
        global $itemUnit;
        global $itemUnit_left;

        // 讀取此項目的特殊設定
        
        $htmlSpeSet = "";
        
        $thisSpeSet = $htmlSpecialSet[$itemName];
        
        if(isset ($thisSpeSet))
        {
             foreach($thisSpeSet as $value)
             {
                 $htmlSpeSet .= $value . " ";
             }
        }
        
        // 讀取單位設定
        
        $thisItemUnit = $itemUnit[$itemName];  
        $thisItemUnit_left = $itemUnit_left[$itemName];  
        
        $ret_html = "";
        $ret_html .= "<div class=\"set\">";
        $ret_html .= "<div class=\"set_title\">$itemName</div>";
        $ret_html .= "<div class=\"set_content\">";
        
         if(isset($thisItemUnit_left))  $ret_html .= "<span class=\"item_unit\">$thisItemUnit_left</span>";
        
        switch($Htmltype)
        {        
            case "span":  // 顯示出來且可以更新和新增進入資料庫的值
                $ret_html .= "<span class=\"span_show\" $htmlSpeSet>$InitialValue</span>";
                $ret_html .= "<input type=\"hidden\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\">";                
                break;
            case "show":  // 顯示出來但不更新和新增進入資料庫
                $ret_html .= "<span class=\"span_show\" $htmlSpeSet>$InitialValue</span>"; 
                $ret_html .= "<input type=\"hidden\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\">"; 
                break;
            case "text":           
                $ret_html .= "<input type=\"text\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\" $htmlSpeSet>";                
                break;
            case "password":           
                $ret_html .= "<input type=\"password\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\" $htmlSpeSet>";                
                break; 
            case "text Read Only":               
                $ret_html .= "<input type=\"text\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\" readonly=\"readonly\" $htmlSpeSet>";                                                              
                break;
            
            case "textarea":               
                $ret_html .= "<textarea class=\"item_value_area\" id=\"item_$seq\" name=\"item_$seq\" $htmlSpeSet>$InitialValue</textarea>";                
                break;
            
            case "DropList":     
                
                global $DropListData;
                $data = $DropListData[$itemName];
       
                $ret_html .= "<select class=\"select_value\" id=\"item_$seq\" name=\"item_$seq\" $htmlSpeSet>\n";
                foreach ($data as $d)
                {                    
                    if($InitialValue == $d[0])$ret_html .= "<option value=\"" . $d[0] . "\" selected>" . $d[1]. "</option>";    
                    else $ret_html .= "<option value=\"" . $d[0] . "\">" . $d[1]. "</option>"; 
                }
                
                $ret_html .= "</select>\n";
                
                break;    
            case "DropList Read Only":     
                
                global $DropListData;
                $data = $DropListData[$itemName];
       
                $ret_html .= "<select class=\"select_value\" id=\"item_$seq\" name=\"item_$seq\" disabled $htmlSpeSet>\n";
                foreach ($data as $d)
                {                    
                    if($InitialValue == $d[0])$ret_html .= "<option value=\"" . $d[0] . "\" selected>" . $d[1]. "</option>";    
                    else $ret_html .= "<option value=\"" . $d[0] . "\">" . $d[1]. "</option>"; 
                }
                
                $ret_html .= "</select>\n";
                $ret_html .= "<input type=\"hidden\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\">";
                break;  
            case "List Show":     
                
                global $DropListData;
                $data = $DropListData[$itemName];
       
                
                foreach ($data as $d)
                {                    
                    if($InitialValue == $d[0])
                    {
                        $ret_html .= "<span class=\"span_show\" $htmlSpeSet>". $d[1] . "</span>";   
           
                    }                    
                }
                $ret_html .= "<input type=\"hidden\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\">";
                break;  
                
            case "DateTime":               
                $ret_html .= "<input type=\"text\" class=\"date_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\" $htmlSpeSet>";                                                              
                break;
            case "SubOperation":    
                global $SubOperationData;
                $data = $SubOperationData[$itemName];                
                $ret_html .= "<iframe src=\"$data\" id=\"item_$seq\" name=\"item_$seq\" class=\"autoHeight subOp\" frameborder=\"0\" $htmlSpeSet></iframe>";                                                              
                break;
            case "upload":                
                  $ret_html .= "<iframe src=\"file_upload.php?index=upload_$seq\" frameborder=\"0\" width=\"300\" height=\"60\" $htmlSpeSet></iframe>";
                  if($InitialValue != "") $ret_html .= "<a href=\"$InitialValue\">下載</a>"; 
                break;
            case "checklist":
                global $DropListData;
                $data = $DropListData[$itemName];
                
                $index = 0;  
              
                foreach ($data as $d)
                {
                    if($InitialValue[$index] == 'on')
                        $ret_html .= "<input type=\"checkbox\" name=\"item_$seq" . "_" . $d[0] . "\" $htmlSpeSet id=\"item_$seq" . "_" . $d[0] . "\" checked>" . $d[1];
                    else
                        $ret_html .= "<input type=\"checkbox\" name=\"item_$seq" . "_" . $d[0] . "\" $htmlSpeSet id=\"item_$seq" . "_" . $d[0] . "\">" . $d[1];
                    
                    $index++;
                }
                                
                break;
                
             case "list_selector":
                global $DropListData;
                $data = $DropListData[$itemName];
                
                $ret_html .= "<input type=\"text\" class=\"item_value\" id=\"item_$seq\" name=\"item_$seq\" value=\"$InitialValue\" readonly=\"readonly\" $htmlSpeSet>";                                                                                  
                $ret_html .= "<img src=\"img/1362383307_preferences-contact-list.png\" style=\"display: inline-block; margin-left:2px;\" width=\"18\" height=\"16\" class=\"list_selector\" ref=\"$seq\" />";                
                $ret_html .= "<div id=\"item_selector_$seq\" style=\"display:none;\">";
                
                $ret_html .= "<select class=\"select_value list_item\" id=\"list_item_$seq\" name=\"list_item_$seq\" size=\"10\" ref=\"$seq\">\n";                
                
                $ret_html .= "</select>\n";                
                $ret_html .= "<br/>關鍵字篩選 <input type=\"text\" class=\"list_filter_value\" id=\"list_filter_$seq\" name=\"list_filter_$seq\" ref=\"$seq\">";                                                                                                                    
                
                //$hidden_d = "";
                
                foreach ($data as $d)
                {               
                    $hidden_d[$d[0]] = $d[1];
                }
                
                $hidden_d_json =  json_encode($hidden_d);
                
                $ret_html .= "<span style=\"display:none;\" id=\"item_select_data_$seq\">$hidden_d_json</span>";
                
                $ret_html .= "</div>";
                
                break;   
                
              case 'image_upload':
                  $_SESSION["image_upload_{$seq}"] = $InitialValue;
                 
                  $ret_html .= "<iframe src=\"image_upload.php?index=image_upload_$seq\" frameborder=\"0\" width=\"800\" height=\"300\" $htmlSpeSet></iframe>";
                 
                 break; 
             
              case 'mix_upload':
                  $_SESSION["mix_upload_{$seq}"] = $InitialValue;
                 
                  $ret_html .= "<iframe src=\"mix_upload.php?index=mix_upload_$seq\" frameborder=\"0\" width=\"800\" height=\"300\" $htmlSpeSet></iframe>";
                 
                 break; 
        }
        
        if(isset($thisItemUnit))  $ret_html .= "<span class=\"item_unit\"> / $thisItemUnit</span>";
        
        $ret_html .= "</div>\n"; 
        $ret_html .= "</div>\n"; 
        
        return $ret_html;
        
        
    }
    
    
?>
