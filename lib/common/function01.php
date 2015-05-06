<?php


function getWeek($timestamp){
    $srttime=date("w",$timestamp);
    $array=array('日','一','二','三','四','五','六');
    return "({$array[$srttime]})";

}

function array_insert($array,$pos,$val)
{
    $array2 = array_splice($array,$pos);
    $array[] = $val;
    $array = array_merge($array,$array2);
    
    return $array;
}

function check_date_is_between($check_date,$start_date,$end_date)
{
   // if($start_date != null && $end_date != null && $check_date != null )
    //{

    
        $s_date = strtotime($start_date);

        $e_date = strtotime($end_date);

        $date = strtotime($check_date);

        if($date >= $s_date && $date <= $e_date)
        {
            return true;
        }
        else
        {
           return false;
        }
   // }
    
   // return false;
   
}

 
?>
