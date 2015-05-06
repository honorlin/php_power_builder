	function item_choise_work(x)
	{	
		if(x == 1)
		{
			var myselect=document.getElementById("drop1")
			
			var nn = myselect.options.length;
			
			for (var k = 0; k < myselect.options.length; k++){
			 if (myselect.options[k].selected==true){
					 
					 
						var a1 = k;
						
						var a2 = document.getElementById("h_choise_items").value;
						var a3 = document.getElementById("drop1").options[a1].value;
						var a4 = document.getElementById("drop1").options[a1].text;

						var a5 = a2.toString().split(",");

						var ss = false;
						
						for(var i = 0 ; i < a5.length ;i++)
						{
							if(a5[i] != "" && a5[i] == a3)
							{
								ss = true;
							}
						}

						if(!ss)
						{
							a2 = a2 + "," + a3;
						}
						

						document.getElementById("h_choise_items").value = a2;

						//alert(document.getElementById("h_choise_items").value);

						//document.getElementById("drop1").remove(a1);
						
						
						
						html_select_list_add("drop3",a3,a4);
					 
						
					 
						
					 
					 
				
			  
			 }
			
			
			}
			
			for(var i = 0 ; i < nn ;i++)
				remove_selected_item("drop1");
				

		}
		else if(x == 2)
		{
			var myselect=document.getElementById("drop3")
			
			var nn = myselect.options.length;
			
			for (var k = 0; k < myselect.options.length; k++){
				
				if (myselect.options[k].selected==true){

			//if(a1 == -1)
			//{
			//	alert("please choise item!");
			//	return;
			//}
					var a1 = k;
					var a2 = document.getElementById("h_choise_items").value;
					var a3 = document.getElementById("drop3").options[a1].value;
					var a4 = document.getElementById("drop3").options[a1].text;

					var a5 = a2.toString().split(",");

					var a6 = "";
			
					for(var i = 0 ; i < a5.length ;i++)
					{
						if(a5[i] != "" && a5[i] != a3)
							a6 += "," + a5[i];
					}

					document.getElementById("h_choise_items").value = a6;
			

			 	}
			}
			
			for(var i = 0 ; i < nn ;i++)
				remove_selected_item("drop3");
				
			item_class_select(document.getElementById("drop2").options[document.getElementById("drop2").options.selectedIndex].value)
		}
		
	}
	
	function remove_selected_item(id)
	{
		var myselect= document.getElementById(id);
		for (var k = 0; k < myselect.options.length; k++){
		 if (myselect.options[k].selected == true)
			 document.getElementById(id).remove(k);
		 		break;
		}	
	}
	
	
	
	function html_select_list_add(html_id,value,text)
	{
		//var myForm = document.form1; //Form Name
        var mySel = document.getElementById(html_id); // Listbox Name 
        var myOption; 

        myOption = document.createElement("Option"); 
        myOption.text = text; //Textbox's value
        myOption.value = value; //Textbox's value
        mySel.add(myOption)
		
	}
	
	function item_class_select(x)
	{
		document.getElementById("drop1").options.length = 0;
		
		var a1 = document.getElementById("h_class_data").value;
		var a2 = a1.toString().split("%%%");
		
		var b1 = document.getElementById("h_choise_items").value;
		var b2 = b1.toString().split(",");
		
		for(var i = 0 ; i < a2.length ;i++)
		{
			if(a2[i] != "")
			{
				var a3 = a2[i].toString().split("@@@");
				
				if(a3[2] == x)
				{
					//判斷是否已有選此人員
					var check = false;
					
					for(var j = 0 ; j < b2.length ; j++)
					{
						if(b2[j] != "")
							if(b2[j] == a3[0])
								check = true;
					}
					
					if(!check) //尚未選擇此人員
						html_select_list_add("drop1",a3[0],a3[3] + "-" + a3[1]);
				}
				
			}
		}
		
		
		
		
		
		
		
		
		
		
		
	}