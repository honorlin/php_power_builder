<?php

//**檔案上傳物件**//

class file_uploader{

	private $upload_dir;
	
	public function __construct($dir)//建構子,設定上傳存放的目錄
	{
		$this -> upload_dir = $dir;		
	}
	
	public function get_temp_save_name() //取得上傳時存放的檔名
	{
		return $_SESSION["file_uploader_temp_save_name"];		
	}
	
	public function new_file()
	{		
		$_SESSION["file_uploader_temp_save_name"]  = "";
	}
	
	public function set_temp_save_name($name)
	{
		$_SESSION["file_uploader_temp_save_name"] = $name;
	}
	
	public function change_temp_to_real_file()
	{
		$ok_name = $this -> get_temp_save_name();
		
		if($this -> get_temp_save_name() != "")
		{
			if(strpos($this -> get_temp_save_name(),"temp_") >= 0)
			{
				$ok_name = substr($this -> get_temp_save_name(),4);
				rename($this -> upload_dir . $this -> get_temp_save_name(),$this -> upload_dir . $ok_name);
			}
			
			
		}
		
		return $ok_name;
		
	}

	public function upload()
	{
		$msg = ""; //回傳的訊息
		

	
			if ($_FILES['upload']['name'] == "")
			{
				$msg = "請選擇檔案";
			}
			elseif($_FILES["upload"]["size"] != 0)
			{
		    
				$save_file_name =  null;
			
				if($this -> get_temp_save_name() == "") // 假如沒有暫存檔名
				{
	            	//**產生一個亂數的暫存名稱,將檔案存放起來**//
	
	            	//產生0~9長度10的數字亂數的名稱
					for($i = 0 ; $i < 10 ;$i++)
						$rand_name .= (string)rand(0,9);
	
	            	//取出上傳檔案的副檔名,和亂數名稱結合在一起
					if (!strpos($_FILES['upload']['name'],"."))
						$save_file_name = $rand_name;
					else
						$save_file_name = $rand_name . substr($_FILES['upload']['name'],strrpos($_FILES['upload']['name'],".",-1));	
					
					//將存放的檔名存入SESSION
					$this -> set_temp_save_name($save_file_name);
				}
				else
				{
					$save_file_name = $this -> get_temp_save_name();	
				}
				
	
	            //將檔案存入亂數產生的檔名
				$upload_file = $this -> upload_dir . $save_file_name;
				move_uploaded_file( $_FILES["upload"]["tmp_name"],$upload_file);
		
            
		
				$msg = "上傳成功!!";		
			}
		
	
		return $msg;	
	
	}
	
	public function delete_temp_save_file()	
	{
		$msg = "";
		if( $this -> get_temp_save_name() != "")
		{
			if(file_exists($this -> upload_dir . $this -> get_temp_save_name())) // 假如暫存檔名存在
			{
				unlink($this -> upload_dir . $this -> get_temp_save_name()); // 刪除檔案
			
				$this -> set_temp_save_name("");//清除,代表目前沒有上傳的檔案
				$msg = "success";
			}
			else
			{
				$this -> set_temp_save_name("");//清除,代表目前沒有上傳的檔案
				$msg = "No Such file";	
			}
		}
		
		return $msg;
	}
	

}
?>