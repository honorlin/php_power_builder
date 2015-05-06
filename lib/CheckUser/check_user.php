<?php

//** 這個物件是用來判斷使用者的權限之用 **//


class check_user
{
	private $re_page; //此為不符合條件時,所要跳至的頁面
	//private $check_source; // 用來判斷的被判值
	//private $check_condition = array(); //用來判斷的判斷值
	
	//$re_page : 跳至的頁面
	//$check_source : 用來判斷的被判值
	//$check_condition : 用來判斷的判斷值
	public function __construct($re_page)
	{
		$this -> re_page = $re_page;
		//$this -> check_source = $check_source;
		//$this -> check_condition = $check_condition;
	}

	//用來啟動判斷
	public function check($check_source,array $check_condition)
	{
		$b = false;	
		
		if ($check_source != null)
		foreach($check_condition as $item)
		{
			if($item == $check_source)
			{
				$b = true;
				break;
			}
		}
		
		if($b == false) //都沒有其中之一的條件符合
		{
			header("Location: login.php");
			//echo '<script language="javascript">window.main.location.href="login.php";</script>';		
		}
	}









}





?>