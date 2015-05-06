<?php



    function string_limit($source,$length)
    {
          
        if(strlen($source)>$length)
        {
            $source = substr($source, 0, $length) . "...";
        }
        
        return $source;
        
    }



?>
