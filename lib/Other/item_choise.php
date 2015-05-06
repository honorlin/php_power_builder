<?php

class item_choise{
	
	private $item;

	public function __construct($item)
	{
		$this -> item = $item;
		
		echo '<script src="javascript/item_choise.js" type="text/javascript"></script>';
	}

	//$item的結構欄位為[][0]是分類2主索引
	//$item的結構欄位為[][1]是分類2名稱
	//$item的結構欄位為[][2]是分類1主索引
	//$item的結構欄位為[][3]是分類1名稱
	
	
	public function show_personal_list($size)
	{
		
		$html = "";
		
		$html .= '<select name="drop1" id="drop1" size="' . $size . '" multiple style="width:200px;">' . "\n";
	
		//for($i = 0 ; $i < count($this -> item)  ;$i++ )
		//{
		//	$html .=  '<option value="' . $this -> item[$i][0] . '">' . $this -> item[$i][3] . " - " .$this -> item[$i][1] . '</option>' . "\n";
		//}		

		$html .=  '</select>' . "\n";
		return $html;
		
	}
	
	public function show_classes_list($size)
	{
		
		$html = "";
		
		$html .= '<select name="drop2" id="drop2" size="' . $size . '" style="width:200px;" onchange="item_class_select(this.options[this.options.selectedIndex].value);">' . "\n";
	
		$temp = "";
		
		$temp2 = "";
		
		for($i = 0 ; $i < count($this -> item)  ;$i++ )
		{			
			if ($this -> item[$i][2] != $temp)
			{
				
				$html .=  '<option value="' . $this -> item[$i][2] . '">' . $this -> item[$i][3] . '</option>' . "\n";
				$temp = $this -> item[$i][2];
			}
		}		 
		
		for($i = 0 ; $i < count($this -> item)  ;$i++ )
		{			
			
			$temp2 .= "%%%" . $this -> item[$i][0] . "@@@" . $this -> item[$i][1] . "@@@" . $this -> item[$i][2] . "@@@" . $this -> item[$i][3];
		}	
		

		$html .=  '</select>' . "\n";
		
		$html .= '<input type="hidden" id="h_class_data" name="h_class_data" value="' . $temp2 . '"/>'. "\n";
		return $html;
		
	}
	
	
	
	public function show_control()
	{
		
		
		$html = "";
	
		$html .= '<button type="button" onclick="item_choise_work(1);">Add</button><br />'. "\n";
     	$html .= '<button type="button" onclick="item_choise_work(2);">Remove</button>'. "\n";
		
     	return $html;
		
	}

	
	public function show_choise_collection($size)
	{
		$html = "";
		$html .= '<input type="hidden" id="h_choise_items" name="h_choise_items" value=""/>'. "\n";
		$html .= '<select name="drop3" id="drop3" size="' . $size . '" multiple style="width:200px;">' . "\n";
		$html .=  '</select>' . "\n";
		return $html;
	}
	
	public function get_select_items()
	{
		$h_choise_items = $_POST["h_choise_items"];
		
		$ar = split(",",$h_choise_items);
		
		return $ar;
		
	}




}
?>