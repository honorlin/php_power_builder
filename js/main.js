$(document).ready(function () {
	

    $(".topselect").click(function (event) {

        $(".topselect").each(function (intIndex) {
            $(this).removeClass("pre_sel");
 
        })

        $(this).addClass("pre_sel");
  
    })
	
});

