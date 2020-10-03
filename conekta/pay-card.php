<?php
session_start(); //Iniciar sesion o reanudar
include "../includes/conexion_db.php";
include "../MPedido.php";
include "../MUsuario.php";
include "../MCarrito.php";
//Inicialización del cliente Conekta a través de la adición de la llave privada y versión del API.
require_once("lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_muLvTTcfeiXgQzGwjDkGxQ");
\Conekta\Conekta::setApiVersion("2.0.0");
\Conekta\Conekta::setLocale('es');

//Para los siguientes pasos en la integración un token_id de prueba se provee. 
//Para tener acceso al token que se generó en el paso 1.0 → es necesario accesarlo en el objeto conektaSuccessResponseHandler["id"] 
//Generación del cliente y la información de pago.

if(isset($_SESSION['nombre_cliente'])){
  $id_cliente = $_SESSION['id_usuario'];
  $idpedido = $_POST['pedido'];
  $objPedido = new Pedido();
      $resultado = $objPedido->buscar_pedido_cliente($id_cliente,$idpedido);
      $row = mysqli_fetch_array($resultado);
  $objUsuario = new Usuario();
      $result = $objUsuario->buscar_Usuario($id_cliente);
      $rowUser =mysqli_fetch_array($result);

  $nombre_completo = $row['a_nombre_de'];
  $direccion = "Calle:".$row['calle'].", Num Ext:".$row['num_ext'].", Num Int:".$row['num_int'].", Colonia:".$row['colonia'].", Ciudad:".$row['municipio'].", Estado:".$row['estado'];
  $tel = $rowUser['telefono'];
  $email = $rowUser['email'];
  $caracteres = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U",".","C","P","c","p");
  $cp = str_replace($caracteres,"",$row['codigo_postal']);
  $total_pagar = $row['total'];
  $fenvio = $row['forma_envio'];
  $envio = intval($row['costo_envio']);
  $iva = intval($row['iva']);

  // Obtener lista de mis productos a pagar
  $objCarrito = new Carrito();
      $resulCar = $objPedido->ver_detalle_pedido($idpedido);
      $newArray = [];
      while ($row = mysqli_fetch_array($resulCar)) {
        $newArray[] = [
            'name' => $row['descripcion'],
            'unit_price' =>intval($row['precio_unitario'])*100,
            'quantity' =>intval($row['cantidad'])
          ];
      }

$token_id = $_POST['conektaTokenId'];

try {
  $customer = \Conekta\Customer::create(
    [
      "name" => $nombre_completo,
      "email" => $email,
      "phone" => $tel,
      "payment_sources" => [
        [
          "type" => "card",
          "token_id" => $token_id
        ]
        ],//payment_sources
        'shipping_contacts' => [
        [
          'phone' => $tel,
          'receiver' => $nombre_completo,
          'address' => [
            'street1' => $direccion,
            'country' => "MX",
            'postal_code' => $cp
          ]
        ]
      ]//customer
    ]
  );
} catch (\Conekta\ProccessingError $error){
  echo $error->getMesage();
} catch (\Conekta\ParameterValidationError $error){
  echo $error->getMessage();
} catch (\Conekta\Handler $error){
  echo $error->getMessage();
}

foreach ($customer as $key) {
  $custom_id = $customer->id;
}
// $customer = \Conekta\Customer::find("cus_2oAPABUxohUV8UhdP");

// Implementación de una orden.

try{
  $order = \Conekta\Order::create([
      "line_items" =>$newArray,
      "shipping_lines" => [ //Costos de envío
        [
          "amount" =>$envio,
           "carrier" => $fenvio
        ]
      ],//shipping_lines - physical goods only
      "currency" => "MXN",
      "customer_info" => [
        "customer_id" => $custom_id
      ], 
      //shipping_contact - required only for physical goods
      // "metadata" => ["reference" => "12987324097", "more_info" => "lalalalala"],
      "charges" => [
        [
          "payment_method" => [
            "type" => "default"
           ] //payment_method - use customer's default - a card
             //to charge a card, different from the default,
             //you can indicate the card's source_id as shown in the Retry Card Section
        ]
      ]
    ]);
} catch (\Conekta\ProcessingError $error){
  echo $error->getMessage();
} catch (\Conekta\ParameterValidationError $error){
  echo $error->getMessage();
} catch (\Conekta\Handler $error){
  echo $error->getMessage();
}
// var_dump($order);
  if ($order) {
      $order_id = $order->id;
      echo "<script language='javascript'>window.location='../checkout/confirmaciontarjeta.php?id_order=".$order_id."&pedido=".$idpedido."'</script>";
  }else{
      echo "<script language='javascript'>window.location='../conekta/card-form.php?pedido=$idpedido'</script>";
  }
}else{
  header("location:../login.php?location=".urlencode($_SERVER['REQUEST_URI']));
}
?>