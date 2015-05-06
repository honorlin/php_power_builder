<?php
	require 'class.phpmailer.php';  

	
	function mail_send($name,$mailto,$html)
	{
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; //啟用SMTP認証
	$mail->CharSet="utf-8";
	//設定e-mail編碼
	//設定信件編碼，大部分郵件工具都支援此編碼方式
	$mail->SMTPSecure = "ssl"; //以SSL加密連線
	$mail->Host = "smtp.gmail.com"; // Gmail的SMTP Server address
	$mail->Port = 465; // Gmail的SMTP port
	$mail->Username = "countessnew@gmail.com"; // GMAIL 帳號
	$mail->Password = "ichin111"; // GMAIL 密碼
	$mail->From = "countessnew@gmail.com"; //從誰寄來
	$mail->FromName = "億進EIP系統-網站管理"; //從誰寄來(名字)
	$mail->Body = $html; //信件內容
	$mail->Subject = "億進EIP系統  - 網站訊息"; //信件主旨
	$mail->IsHTML(true);
	//$mail->WordWrap = 50; // 設定斷字的長度
	$mail->AddAddress($mailto, $name); //設定收件人的Email和Name
	$mail->setLanguage('zh'); //我自己翻譯的中文錯誤訊息(可不加)


	if(!$mail->Send())  //寄信成功與否
		return false;
 	else 
		return true;
	}
?>