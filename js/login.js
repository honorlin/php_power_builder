$(document).ready(function () {
	
	$("#ok_login").click(function() { 
            
            if(check_value())
            {

                $.post("b_login.php", { login_account: $("#login_account").val() , login_password:$("#login_password").val()},
                
                    function(data){	
                          
                        if(data.indexOf("success") >=0)
                        {
                            location.href="main.php";
                            $("#msg").html("登入成功!");
                        }
                        else
                        {
                             $("#msg").html("請檢查帳號或密碼!");                            
                        }
                     
                });
            }
			
	});

	
});


function check_value()
{
    var msg = "";
    
    if($("#login_account").val() == "")
        msg +=  "帳號未填寫！\n";
    
    if($("#login_password").val() == "")
        msg +=  "密碼未填寫！\n";
    
    if(msg != "")
    {
        alert(msg);
        return false;
    }
    else
    {
        return true;        
    }
    
    
    
}