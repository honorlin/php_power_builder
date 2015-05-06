// @design: Ten.
// @date: 2013/03/04
//
//
//


$(document).ready(function () {
	
    $(".select_value2").css("display","none");    
        
    $(".list_selector").click(function () {
        
        var ref = $(this).attr("ref"); 
                
        var data = $("#" + "item_select_data_" + ref).html();
                  
        putItemToListWthKeyWord("list_item_" + ref, "",JSON.parse(data));
        
        $("#item_selector_" + ref).show(500);
                  
    });
    
    $(".list_item").click(function () {

        var ref = $(this).attr("ref"); 
        
        var selected_value = $("option:selected",this).text(); 
        
        $("#item_" + ref).val(selected_value);
                   
        show_ajax_data("list_item2_" + ref,$(this).val(),'company_tel'); 
        show_ajax_data("list_item3_" + ref,$(this).val(),'contact_person');  
      // $("#item_selector_" + ref).hide(500);
        
    });
    
    $(".list_item2").click(function () {

        var ref = $(this).attr("ref"); 
        
        var selected_value = $("option:selected",this).text();   
        
        var pre_data = $("#item_" + ref).val(); // 目前的選擇結果 
        
        // 先將結果有此select的item部分都先清除掉
        
            $(this).children().each(function(){                
                pre_data = pre_data.replace($(this).text(),'');
            });
        //
        
        
        if(selected_value != "") $("#item_" + ref).val(pre_data + "" + selected_value);                 

        
        
        
              
    });
    
     $(".list_item3").click(function () {

        var ref = $(this).attr("ref"); 
        
        var selected_value = $("option:selected",this).text();        
        
        if(selected_value != "") $("#item_" + ref).val($("#item_" + ref).val() + "" + selected_value);                 
        
        $("#list_item2_" + ref).hide(500);
        $("#list_item3_" + ref).hide(500);
        $("#item_selector_" + ref).hide(500);
              
    });
    
    $(".item_selector_close").click(function () {
        var ref = $(this).attr("ref"); 
        $("#list_item2_" + ref).hide(500);
        $("#item_selector_" + ref).hide(500);
    });
    // 關鍵字過濾
    $(".list_filter_value").change(function () {        
        var ref = $(this).attr("ref");  
        var data = $("#" + "item_select_data_" + ref).html();
       
        putItemToListWthKeyWord("list_item_" + ref, $(this).val(),JSON.parse(data));
    });
	
});

function show_company(keyword)
{
       
}

function show_ajax_data(select_id,this_customer_company_id,this_work_type)
{
    var pre_page = $("#pre_page").val();       
                 
    $.post(pre_page, { ac:this_work_type,customer_company_id: this_customer_company_id},
        
        function(data){	                       

            putItemToListWthKeyWord(select_id, '',JSON.parse(data));

            $("#" +select_id).show(500); 
        }
    );
        
 
    
}

// 放入篩選後的資料到選擇清單
function putItemToSelect(keyword) {
    
}

function putItemToListWthKeyWord(list_id,keyword,result_json) { 

    $("#" + list_id).get(0).options.length = 0;

    if (keyword == "" || keyword == null) {        
        for(var v in result_json)
        {
            $("#" + list_id).append(
                $('<option></option>').val(v).html(result_json[v])
            );            
        }
    } else {
        if (keyword != "") {            
            for(var v in result_json)
            {
                if (result_json[v].indexOf(keyword) >= 0) {
                    $("#" + list_id).append(
                        $('<option></option>').val(v).html(result_json[v])
                    ); 
                }
            }            
        }
    }
}


