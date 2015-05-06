function del_item(item_id,page_url)
{   
    if(confirm("您好! 您確定要刪除嗎？"))
    {
        if(page_url.indexOf("?") < 0)
            location.href = page_url + "?ac=del&id=" + item_id;        
        else
            location.href = page_url + "&ac=del&id=" + item_id; 
    }
   
}