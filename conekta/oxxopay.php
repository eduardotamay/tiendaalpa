<?php
    session_start(); //Iniciar sesion o reanudar
    include "../includes/conexion_db.php";
    include "../MPedido.php";
    include "../MUsuario.php";
    include "../MCarrito.php";

    require_once("lib/Conekta.php");
        \Conekta\Conekta::setApiKey("key_muLvTTcfeiXgQzGwjDkGxQ");
        \Conekta\Conekta::setApiVersion("2.0.0");
        \Conekta\Conekta::setLocale('es');

    if(isset($_SESSION['nombre_cliente'])){
        $id_cliente = $_SESSION['id_usuario'];
        $idpedido = $_GET['pedido'];
        $objPedido = new Pedido();
            $resultado = $objPedido->buscar_pedido_cliente($id_cliente,$idpedido);
            $row = mysqli_fetch_array($resultado);
        $objUsuario = new Usuario();
            $result = $objUsuario->buscar_Usuario($id_cliente);
            $rowUser =mysqli_fetch_array($result);
    
        //id_cliente,nombre_cliente,teléfono,email,amount,envio,pago_oxxo, lista_productos
        // calle, num_int,num_ext,cp,cuidad,colonia,estado
        //Recibo los datos de compras
        $nombre_completo = $row['a_nombre_de'];
        $direccion = "Calle:".$row['calle'].", Num Ext:".$row['num_ext'].", Num Int:".$row['num_int'].", Colonia:".$row['colonia'].", Ciudad:".$row['municipio'].", Estado:".$row['estado'];
        $tel = $rowUser['telefono'];
        $email = $rowUser['email'];
        $caracteres = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U",".","C","P","c","p");
        $cp = str_replace($caracteres,"",$row['codigo_postal']);
        $total_pagar = $row['total'];
        $fenvio = $row['forma_envio'];
        $envio = $row['costo_envio'];
        $amount = $total_pagar;

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
        try{
            $dias_expiracion = (new DateTime())->add(new DateInterval('P5D'))->getTimestamp(); 
          
            $order = \Conekta\Order::create(
              [
                "line_items" => $newArray,//Lista de productos
                "shipping_lines" => [ //Lista costos de envío
                  [
                    "amount" =>$envio,
                    "carrier" => $fenvio
                  ]
                ],
                "currency" => "MXN", //Tipo de moneda
                "customer_info" => [ //Info del cliente
                  "name" => $nombre_completo,
                  "email" => $email,
                  "phone" => $tel
                ],
                "shipping_contact" => [ //Detalles del envío
                  "address" => [
                    "street1" => $direccion,
                    "postal_code" => $cp,
                    "country" => "MX"
                  ]
                ],
                "charges" => [ //Lista de cargos
                  [
                    "payment_method" => [
                      "type" => "oxxo_cash",
                      "expires_at" => $dias_expiracion
                    ]
                  ]
                ]
              ]
            );
            if (!$order) {
                return false;
            }else{
              $order_id = $order->id;
              echo "<script language='javascript'>window.location='../checkout/confirmacion.php?order=".$order_id."&pedido=".$idpedido."'</script>";
            }
          } catch (\Conekta\ParameterValidationError $error){
            echo $error->getMessage();
          } catch (\Conekta\Handler $error){
            echo $error->getMessage();
          }
    ?>
<!-- <html>
<head>
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
</head>

<body>
    <div class="opps">
        <div class="opps-header">
            <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info">
                <div class="opps-brand">
                    <img src="img/oxxopay_brand.png" alt="OXXOPay">
                </div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2>$ <?php echo number_format(($order->amount/100),2) ?> <sup><?php echo $order->currency; ?></sup>
                    </h2>
                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h1><?php echo $order->charges[0]->payment_method->reference; ?></h1>
            </div>
            <div class="opps-reference">
                <h4>Expira el:</h4>
                <h1 class="expira"><?php echo date('d-M-Y H:i A',$order->charges[0]->payment_method->expires_at)?></h1>
            </div>
        </div>
        <div class="opps-instructions">
            <h3>Instrucciones</h3>
            <ol>
                <li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/"
                        target="_blank">Encuéntrala aquí</a>.</li>
                <li>Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                <li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de
                    venta.</li>
                <li>Realiza el pago correspondiente con dinero en efectivo.</li>
                <li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar
                        que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
            </ol>
            <div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Autopartes Alpa S.A. de
                    C.V.</strong> confirmando tu pago.</div>
        </div>
    </div>
</body>

</html> -->
<?php
    }else{
      header("location:../login.php?location=".urlencode($_SERVER['REQUEST_URI']));
    }
?>