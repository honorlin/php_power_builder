<?php

function get_time()
{

	$time = getdate();

	return $time[year] . '-' . $time[mon] . '-' . $time[mday] . ' ' . ((int)$time[hours] + 8) . ':' . $time[minutes] . ':' . $time[seconds] ;
	
}
?>