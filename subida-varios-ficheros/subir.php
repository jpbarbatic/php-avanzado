<?php

function multiplesFiles($files)
{
	foreach($files as $key => $all ){
		foreach( $all as $i => $val ){
			$new[$i][$key] = $val;    
		}    
	}
	return $new;
}
	
print_r(multiplesFiles($_FILES['fotos']));