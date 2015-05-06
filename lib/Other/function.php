<?php
function unescape($str){
    $str = rawurldecode($str);
    preg_match_all("/%u.{4}|&#x.{4};|&#\d+;|.+/U",$str,$r);
    $ar = $r[0];

    foreach($ar as $k=>$v){
        /* �U���� UTF-8 �i�w��A�������s�X�覡�@�ܧ� */
        if(substr($v,0,2)=="%u"){
            $ar[$k]=iconv("UCS-2","big5",pack("H4",substr($v,-4)));}
        elseif(substr($v,0,3)=="&#x"){
            $ar[$k]=iconv("UCS-2","big5",pack("H4",substr($v,3,-1)));}
        elseif(substr($v,0,2)=="&#"){
            $ar[$k]=iconv("UCS-2","big5",pack("n",substr($v,2,-1)));}
    }
    return join("",$ar);
}

function unescape_utf8($str){
    $str = rawurldecode($str);
    preg_match_all("/%u.{4}|&#x.{4};|&#\d+;|.+/U",$str,$r);
    $ar = $r[0];

    foreach($ar as $k=>$v){
        /* �U���� UTF-8 �i�w��A�������s�X�覡�@�ܧ� */
        if(substr($v,0,2)=="%u"){
            $ar[$k]=iconv("UCS-2","utf-8",pack("H4",substr($v,-4)));}
        elseif(substr($v,0,3)=="&#x"){
            $ar[$k]=iconv("UCS-2","utf-8",pack("H4",substr($v,3,-1)));}
        elseif(substr($v,0,2)=="&#"){
            $ar[$k]=iconv("UCS-2","utf-8",pack("n",substr($v,2,-1)));}
    }
    return join("",$ar);
}



?>
