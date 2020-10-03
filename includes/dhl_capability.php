<?php

function dhl_capability($cp_cliente,$fecha){

    $url="https://xmlpi-ea.dhl.com/XMLShippingServlet";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $texto='<?xml version="1.0" encoding="UTF-8"?>
    <p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes"
        xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.dhl.com DCT-req.xsd ">
        <GetCapability>
            <Request>
                <ServiceHeader>
                    <MessageTime>2002-08-20T11:28:56.000-08:00</MessageTime>
                    <MessageReference>1234567890123456789012345678901</MessageReference>
                    <SiteID>v62_CXzSlVRamJ</SiteID>
			        <Password>i2z7HSFZOw</Password>
                </ServiceHeader>
            </Request>
            <From>
                <CountryCode>MX</CountryCode>
                <Postalcode>04369</Postalcode>
                <City>04369</City>
            </From>
            <BkgDetails>
                <PaymentCountryCode>MX</PaymentCountryCode>
                <Date>'.$fecha.'</Date>
                <ReadyTime>PT10H21M</ReadyTime>
                <DimensionUnit>CM</DimensionUnit>
                <WeightUnit>KG</WeightUnit>
                <Pieces>
                    <Piece>
                        <PieceID>1</PieceID>
                        <Height>30</Height>
                        <Depth>20</Depth>
                        <Width>10</Width>
                        <Weight>1.0</Weight>
                    </Piece>
                </Pieces>
                <IsDutiable>N</IsDutiable>
                <NetworkTypeCode>AL</NetworkTypeCode>
            </BkgDetails>
            <To>
                <CountryCode>MX</CountryCode>
                <Postalcode>'.$cp_cliente.'</Postalcode>
            </To>
            <Dutiable>
                <DeclaredCurrency>MXN</DeclaredCurrency>
                <DeclaredValue>0</DeclaredValue>
            </Dutiable>
        </GetCapability>
    </p:DCTRequest>';

    curl_setopt($ch, CURLOPT_POSTFIELDS,$texto);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
    $respuesta=curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $ocho=utf8_encode($respuesta);
    $xml = simplexml_load_string($ocho);

    $Obtener_dato = $xml->children()->GetCapabilityResponse->BkgDetails->QtdShp;
    return $Obtener_dato->DeliveryDate;
}
?>