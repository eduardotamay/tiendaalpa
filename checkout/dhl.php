<?php

if (isset($_POST['buscar_local']) && $_POST['buscar_local'] == 'BLOCAL') {
    $direccion = $_POST['direccion'];
    tiendas_dhl_2($direccion);
}

function tiendas_dhl_2($ubicacion){
    $search_point=urlencode($ubicacion);
    $url='https://wsbexpress.dhl.com/ServicePointLocator/restV3/servicepoints?servicePointResults=10&address='.$search_point.'&countryCode=MX&physicalProcessCapabilities=78&resultUom=km&key=963d867f-48b8-4f36-823d-88f311d9f6ef';
    $result=file_get_contents($url);

    $tiendas=json_decode($result);
    $i=0;
    foreach($tiendas->servicePoints as $tienda){
        $arreglo[$i]["nombre_tienda"]=$tienda->localName;
        $direccion_completa=$tienda->address->addressLine1." ".$tienda->address->addressLine2." ".$tienda->address->addressLine3." ".$tienda->address->city." CP.".$tienda->address->zipCode;
        $arreglo[$i]["direccion"]=$direccion_completa;
        $arreglo[$i]["latitud"]=$tienda->geoLocation->latitude;
        $arreglo[$i]["longuitud"]=$tienda->geoLocation->longitude;
        $arreglo[$i]["codigo_postal"]=$tienda->address->zipCode;
        $arreglo[$i]["ciudad"]=$tienda->address->city;
        $arreglo[$i]["estado"]=$tienda->address->city;
        $i++;
        }
    if ($arreglo) {
        header('HTTP/1.1 200 Ok');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($arreglo));
    }else{
        header('HTTP/1.1 400 Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR')));
    }
}


?>