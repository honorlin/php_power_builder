

function box_search1()
{
	var ac = document.getElementById("find_item").options[document.getElementById("find_item").selectedIndex].text;
	var value = document.getElementById("search_text").value;			
	document.getElementById("h_search_item").value = ac;
	document.getElementById("h_search_text").value = value;
	PostToServer('search',null);//�u�O���F��^�쪫��B�z	
}

function box_search2()
{	
	var ac = getCheckedValue(document.form1.find_item);
	var value = document.getElementById("search_text").value;			
	document.getElementById("h_search_item").value = ac;
	document.getElementById("h_search_text").value = value;
	PostToServer('search',null);//�u�O���F��^�쪫��B�z	
}

function box_order_by()
{
	var item = document.getElementById("by_item").options[document.getElementById("by_item").selectedIndex].value;
	var type = document.getElementById("by_type").options[document.getElementById("by_type").selectedIndex].value;		
	document.getElementById("h_order_by_item").value = item;
	document.getElementById("h_order_by_type").value = type;
	PostToServer('orderby',null);//�u�O���F��^�쪫��B�z	

}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function setCheckedValue(radioObj, newValue) {
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}