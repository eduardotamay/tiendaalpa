<?php

if (isset($_POST["data"]) && $_POST["data"]!="") {
    $datos = $_POST['data'];
    //Imprimir los datos
    header('HTTP/1.1 200 Ok');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'OK')));
}else{
    echo "No llegaron los datos";
}

?>