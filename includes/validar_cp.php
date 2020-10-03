<?php

if (isset($_POST['comprobar_CP']) && $_POST['comprobar_CP'] == 'COMP_CP') {

    $cp = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : null;

    $endpoint_sepomex = "http://api-sepomex.hckdrk.mx/query/";
	$method_sepomex = 'info_cp/';
	$variable_string = '?type=simplified';
	
	$url = $endpoint_sepomex . $method_sepomex . $cp . $variable_string;
	$response = file_get_contents($url);

	if($response){
        header('HTTP/1.1 200 Ok');
        header('Content-Type: application/json; charset=UTF-8');
        die($response);
	}else{
		header('HTTP/1.1 400 Error');
        header('Content-Type: application/json; charset=UTF-8');
        die($response);
	}

}


?>