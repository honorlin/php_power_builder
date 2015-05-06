$(document).ready(function () {
	
	$("#upload").change(function() { 
						
		PostToServer('upload','logo');
	}); 
	
});



function delete_img()
{	
	PostToServer('delete','logo');
}
