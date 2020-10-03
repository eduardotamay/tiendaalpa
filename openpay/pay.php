<?php
require('Openpay.php');

$openpay = Openpay::getInstance('mmdooaiwikxp3waryv1f', 
  'sk_287795ee172f4eb1a6e4ac57fb37f23b');

  $amount = $_POST["amount"];
  $valor= round($amount,2);
  $valor_s = strval($valor);

try{
    $customer = array( //Datos del cliente
     'name' => $_POST["name"],
     'last_name' => $_POST["last_name"],
     'phone_number' => $_POST["phone_number"],
     'email' => $_POST["email"],);

    $chargeData = array(
        'method' => 'card',
        'source_id' => $_POST["token_id"],
        'amount' => $valor_s,
        'description' => $_POST["description"],
        'device_session_id' => $_POST["deviceIdHiddenFieldName"],
        'customer' => $customer );

    $charge = $openpay->charges->create($chargeData);
    echo "Cargo solicitado | ";

    if($charge){
        echo("<strong>Bien, se hizo el cargo</strong>"); //Si todo sale bien
        echo "<script language='javascript'>window.location='../checkout/confirmacion.php'</script>";
    }

} catch (OpenpayApiTransactionError $e) { //Error al no acompletar la transacción
	error_log('ERROR on the transaction: ' . $e->getMessage() . 
	      ' [error code: ' . $e->getErrorCode() . 
	      ', error category: ' . $e->getCategory() . 
	      ', HTTP code: '. $e->getHttpCode() . 
	      ', request ID: ' . $e->getRequestId() . ']', 0);
    echo "ERROR1";

} catch (OpenpayApiRequestError $e) { //Error cuando el request API
	error_log('ERROR on the request: ' . $e->getMessage(), 0);
    echo "ERROR2";
    echo $e;

} catch (OpenpayApiConnectionError $e) { //Error al no poder conectarse con la API (timeouts)
	error_log('ERROR while connecting to the API: ' . $e->getMessage(), 0);
    echo "ERROR3";

} catch (OpenpayApiAuthError $e) { //Error al autenticarse (ID or Private_Key)
	error_log('ERROR on the authentication: ' . $e->getMessage(), 0);
	echo "ERROR4";
} catch (OpenpayApiError $e) {  //Error general (API)
	error_log('ERROR on the API: ' . $e->getMessage(), 0);
    echo "ERROR5";
	
} catch (Exception $e) { //Error en el script
	error_log('Error on the script: ' . $e->getMessage(), 0);
    echo "ERROR6";
}
?>