<?php

		function basic_editor($value)
		{

			include("fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('FCKeditor1');
			$oFCKeditor->BasePath = './fckeditor/';
			$oFCKeditor->Value = $value;
			$oFCKeditor->Width  = '600';
			$oFCKeditor->Height = '300';
			$oFCKeditor->Config['SkinPath'] = 'skins/silver/';
			$oFCKeditor->ToolbarSet = 'Basic';
			return $oFCKeditor->Create();

		}
		
	    function advance_editor($value)
		{

			include("fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('FCKeditor1');
			$oFCKeditor->BasePath = './fckeditor/';
			$oFCKeditor->Value = $value;
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height = '800';
			$oFCKeditor->Config['SkinPath'] = 'skins/silver/';
			$oFCKeditor->ToolbarSet = '';
			return $oFCKeditor->Create();

		}
		
		function basic_editor2($value,$id,$width,$height)
		{

			include("fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor($id);
			$oFCKeditor->BasePath = './fckeditor/';
			$oFCKeditor->Value = $value;
			$oFCKeditor->Width  = $width;
			$oFCKeditor->Height = $height;
			$oFCKeditor->Config['SkinPath'] = 'skins/silver/';
			$oFCKeditor->ToolbarSet = 'Basic';
			return $oFCKeditor->Create();

		}
		
		function advance_editor2($value,$id,$width,$height)
		{

			include("fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor($id);
			$oFCKeditor->BasePath = './fckeditor/';
			$oFCKeditor->Value = $value;
			$oFCKeditor->Width  = $width;
			$oFCKeditor->Height = $height;
			$oFCKeditor->Config['SkinPath'] = 'skins/silver/';
			$oFCKeditor->ToolbarSet = '';
			return $oFCKeditor->Create();

		}
		

?>