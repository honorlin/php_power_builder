<?php

//** �o�Ӫ���O�ΨӧP�_�ϥΪ̪��v������ **//


class check_user
{
	private $re_page; //�������ŦX�����,�ҭn���ܪ�����
	//private $check_source; // �ΨӧP�_���Q�P��
	//private $check_condition = array(); //�ΨӧP�_���P�_��
	
	//$re_page : ���ܪ�����
	//$check_source : �ΨӧP�_���Q�P��
	//$check_condition : �ΨӧP�_���P�_��
	public function __construct($re_page)
	{
		$this -> re_page = $re_page;
		//$this -> check_source = $check_source;
		//$this -> check_condition = $check_condition;
	}

	//�ΨӱҰʧP�_
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
		
		if($b == false) //���S���䤤���@������ŦX
		{
			header("Location: login.php");
			//echo '<script language="javascript">window.main.location.href="login.php";</script>';		
		}
	}









}





?>