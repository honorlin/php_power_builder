<?php

	require 'mail_com.php';

       

	function send_register_pass_email($mailto,$name,$account)
	{


    //產生0~9長度15的數字亂數的名稱
    for($i = 0 ; $i < 20 ;$i++)
			$rand_name .= (string)rand(0,9);
    
    $html = "";
    
    $html .= "您好!";
    $html .= "<br />";
    $html .= "<br />";
    $html .= "您在億進EIP系統的權限已審核通過!";
    $html .= "<br />";
    $html .= "<br />";
 	$html .= "<strong>第四步</strong>";
 	$html .= "<br />";
 	$html .= "<br />";
    $html .= "請點選已下連結，作email的驗證，即可登入 EIP系統";
	$html .= "<br />";
	$html .= "<br />";
    $html .= "<a href=\"163.26.231.197/eip/check_mail.php?account=" . $account . "&chv=$rand_name\">點選</a>";
	$html .= "<br />";
	$html .= "<br />";
    $html .= "或是複製以下連結至瀏覽器";
    $html .= "<br />";
    $html .= "<br />";
    $html .= "163.26.231.197/eip/check_mail.php?account=" . $account . "&chv=" . $rand_name;
    $html .= "<br />";
    $html .= "<br />";
    $html .= "如果您並未註冊此系統，對此信您可以不理會";
    
    
    
    $MySql_Worker = new MySql_Worker('localhost','eip','11041104','eip');
	$db_worker = new db_worker($MySql_Worker);	
    
	$sql = "update mail_pass set code='" . $rand_name . "' where account='" . $account . "'";
	$tt = $db_worker -> perform($sql);
	
	if($tt == 1)
	{
		$sql = "insert into mail_pass(code,account) values('" . $rand_name . "','" .  $account . "')";
		$tt = $db_worker -> perform($sql);
	}
     

	
		return mail_send($name,$mailto,$html);
		
	}
	
	function send_forget_passwd($account)
	{
	    $MySql_Worker = new MySql_Worker('localhost','eip','11041104','eip');
		$db_worker = new db_worker($MySql_Worker);	
		
		$result = $db_worker -> perform("select * from member where account='" . $account . "'");
		
		if ((mysql_num_rows($result) == 0))
			return 0;
		
		 for($i = 0 ; $i < 8 ;$i++)
			$rand_name .= (string)rand(0,9);
		
		
		 $html = "";
    
    $html .= "您好!";
    $html .= "<br />";
    $html .= "<br />";
    $html .= "您的密碼我們已幫你更新為 ";
    $html .= "<br />";
    $html .= "<br />";
    $html .= $rand_name;
    $html .= "<br />";
    $html .= "<br />";
    $html .= "您登入系統後可以至個人管理，修改密碼";
	$html .= "<br />";
	$html .= "<br />";
    $html .= "如果您並未申請取得密碼，對此信您可以不理會";
    
    $result2 = $db_worker -> perform("update member set passwd='" . $rand_name . "' where account='" . $account . "'");
    
    
     if (mail_send(mysql_result($result,0,'name'),mysql_result($result,0,'email'),$html))
     	return 2;
     else
     	return 1;	
    
	}

?>