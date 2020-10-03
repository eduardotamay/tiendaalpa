<?php

    include_once("MUsuario.php");
    include_once("MDir_envio.php");
    include_once("MFactura.php");
    include_once("MCarrito.php");
    include_once("MPedido.php");
    include_once("MDetallePedido.php");
    include_once("includes/dhl_capability.php");

    $id_usuario    = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
    $a_nombre_de  = isset($_POST['a_nombre_de']) ? $_POST['a_nombre_de'] : null;
    $factura = md5($a_nombre_de); //Para generar codigo único
    $fecha_actual = new DateTime();
    $fecha_actual->getTimestamp();
    $fecha      = date_format($fecha_actual, 'Y-m-d H:i:s');
    #Ver si necesita factura
    if(isset($_POST['factura'])=="si") {
    #Almaceno datos de factura
        $requiere_factura= 1;
        $datos_factura = isset($_POST['datos_factura']) ? $_POST['datos_factura'] : null;
        $rfc = isset($_POST['rfc']) ? $_POST['rfc'] : null;
        $razon_social = isset($_POST['razon_social']) ? $_POST['razon_social'] : null;
        $calle_fac = isset($_POST['calle']) ? $_POST['calle'] : null;
        $num_int_fac = isset($_POST['num_int']) ? $_POST['num_int'] : null;
        $num_ext_fac = isset($_POST['num_ext']) ? $_POST['num_ext'] : null;
        $ciudad_fac = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
        $cp_fac = isset($_POST['cp']) ? $_POST['cp'] : null;
        $estado_fac = isset($_POST['estado']) ? $_POST['estado'] : null;
        $cdfi = isset($_POST['cfdi']) ? $_POST['cfdi'] : null;
        // Validar sus datos de factura
        $objUsuario = new Usuario();
        $resultado = $objUsuario->buscar_Usuario($id_usuario);
        $row = mysqli_fetch_array($resultado);
        if ($razon_social!=$row['razon_social'] || $cdfi!=$row['cfdi'] || $rfc!=$row['rfc'] || $calle_fac!=$row['calle'] || 
        $num_int_fac!=$row['num_interior'] || $num_ext_fac!=$row['num_exterior'] || $ciudad_fac!=$row['ciudad'] || $cp_fac!=$row['cp'] || $estado_fac!=$row['estado']) {
            $objUsuario->actualizarDatosFactura($id_usuario,$razon_social,$cdfi,$rfc,$calle_fac,$num_int_fac,$num_ext_fac,$ciudad_fac,$cp_fac,$estado_fac);
        }
        $objFactura = new Factura();
        $objFactura->Factura($factura,$id_usuario,$fecha);
        $resultado = $objFactura->registrar_factura();
    }else{
        $requiere_factura = 0;
    }

    #Obtener datos de direccion de envío segun el id_cliente 
    $objDireccion = new DireccionEnvio();
    $resultado_dir = $objDireccion->verMisDirecciones($id_usuario);
    $row = mysqli_fetch_array($resultado_dir);
    
    # Obtener datos del form
        $calle = $row['calle'];
        $num_ext = $row['num_ext'];
        $num_int = $row['num_int'];
        $cp = $row['cp'];
        $colonia = $row['colonia'];
        $municipio = $row['municipio'];
        $estado = $row['estado'];
        $pais = $row['pais'];
        $forma_envio = isset($_POST['forma_envio']) ? $_POST['forma_envio'] : null;
        $nombre_tienda  = isset($_POST['nom_tienda']) ? $_POST['nom_tienda'] : null;
        $subtotal       = isset($_POST['subtotal']) ? $_POST['subtotal'] : null;
        $iva            = isset($_POST['iva']) ? $_POST['iva'] : null;
        $total          = isset($_POST['total']) ? $_POST['total'] : null;
        $costo_envio    = isset($_POST['costo_envio']) ? $_POST['costo_envio'] : null;
        // echo $costo_sobrepeso= isset($_POST['costo_sobrepreso']) ? $_POST['costo_sobrepreso'] : null;
        // echo $fecha_entrega  = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : null;
        // echo $fecha_estimada = isset($_POST['fecha_estimada']) ? $_POST['fecha_estimada'] : null;

        // Hasta que se inserte los detalles pedido, se reedirecciona a la pagina segun
        $forma_pago  = isset($_POST['pago']) ? $_POST['pago'] : null;

    
    #Calcular num partidas
        $objCarrito = new Carrito();
        $resultado = $objCarrito->ver_producto_en_carrito($id_usuario);
        $contPartidas = 0;
        foreach ($resultado as $prod_carriro) {
            $contPartidas = $contPartidas+1;
        }

    #Calcular sobre preso > 1k(+$20) =< +0
        $resultadoSobrePeso = $objCarrito->ver_producto_en_carrito($id_usuario);
        $sobrepesoKg = 0;
        foreach ($resultadoSobrePeso as $sobrepeso) {
            $sobrepesoKg = $sobrepesoKg + $sobrepeso['peso'];
        };
        //Le resto los 1000g = 1kg que no se cobra 
        // Saco los g extras que tiene, x cada 1000g = $20
        if ($sobrepesoKg>1000) {
            $sobrepesoKgExtra = $sobrepesoKg-1000;
            $sobrepesoKg = ($sobrepesoKgExtra * 20)/1000;
        }else{
            $sobrepesoKg = 0;
        }

    #Calcular las fecha y hora de entrega
        if ($forma_envio=="Sucursal Alpa") {
            $fecha_estimada = new DateTime($fecha);
            $fecha_estimada = date_format($fecha_estimada->add(new DateInterval('PT1H')),'Y-m-d H:i:s');
        }elseif ($forma_envio=="ivoy") {
            $fecha_estimada = calcular_dias_entrega();
        }elseif ($forma_envio=="alpa") {
            $fecha_estimada = calcular_dias_entrega();
        }elseif ($forma_envio=="Sucursal DHL") {
            $fecha_estimada = calcular_dias_entrega(); //Pendiente por calcular
        }elseif($forma_envio=="dhl"){
            $fecha_ac = date_format($fecha_actual, 'Y-m-d');
            $fecha_estimada = dhl_capability($cp,$fecha_ac);
        }
    
    // else{//Fecha actual (cambiarlo despues de calcular la fecha exacta)
    //     $fecha_entrega = new DateTime($fecha);
    //     $fecha_entrega = date_format($fecha_entrega,'Y-m-d H:i:s');
    // }// Sucursal-DHL Sucursal-Alpa ivoy alpa
    
    //Convertir los num a flotante - double DB
    $subtotal = floatval(str_replace(',',"",$subtotal));
    $iva      = floatval(str_replace(',',"",$iva));
    $total    = floatval(str_replace(',',"",$total));

    //Registrar el pedido(insertar en la bd)
    $objPedido = new Pedido();
    $objPedido->Pedido($id_usuario,$a_nombre_de,$requiere_factura,$contPartidas,$calle,$num_ext,$num_int,
        $cp,$colonia,$municipio,$estado,$pais,$forma_envio,$forma_pago,$factura,$fecha,$subtotal,$iva,$total,$costo_envio,
        $sobrepesoKg,'N/D',$fecha_estimada);
    $result = $objPedido->insertar_pedido();

    // REGISTRAR DETALLE DEL PEDIDO
    if ($result) {
        $row = mysqli_fetch_array($result);
        $idPedido = $row['id_pedido'];
        if ($idPedido) {
            // recorrer todo el array e ir insertando en detalle pedido
            //Obtener detalles productos (carrito=id_cliente)
            $objCarrito = new Carrito();
            $resultado = $objCarrito->ver_producto_en_carrito($id_usuario);
            $link = mysqli_connect("localhost", "root", "", "tienda_alpha");
            foreach ($resultado as $prod_carrito) {
                $idP = $idPedido;
                $sku = $prod_carrito['sku'];
                $descripcion = $prod_carrito['descripcion'];
                $precioU = $prod_carrito['precio'];
                $cantidad = $prod_carrito['cantidad'];
                $importe = $prod_carrito['subtotal_producto'];
                $iva = floatval(str_replace(',','',$importe))*0.16;
                $query1 = "INSERT INTO detallepedidos (id_pedido,sku,descripcion,precio_unitario,cantidad,importe,iva) 
                            VALUES ('".$idP."','".$sku."','".$descripcion."','".$precioU."','".$cantidad."','".$importe."','".number_format($iva,2)."')";
                $q = mysqli_query($link, $query1) or die (mysqli_error($link));
            }
        }
    }

    // Actualizar estado carrito de mis productos despues de hacer el pedido
    $objCarrito->actualizarEstadoCarrito($id_usuario);

    // Dependiendo el método de pago se redirige el usuario
    switch ($forma_pago) {
        case 'tarjeta':
            echo "<h3>Espere lo estamos redirigiendo...</h3>";
            header( "refresh:2;url=conekta/card-form.php?pedido=$idPedido" );
            // header( "refresh:2;url=checkout/confirmacion.php" );
            break;
        case 'oxxo':
            echo "<h3>Espere lo estamos redirigiendo...</h3>";
            header( "refresh:2;url=conekta/oxxopay.php?pedido=$idPedido");
            break;
        case 'spei':
            header( "refresh:2;url=checkout/confirmacionspei.php?pedido=$idPedido" );
            break;
        case 'deposito':
            echo "Depósito en ventanilla";
            break;
        case 'paypal':
            echo "Pago con paypal";
            break;
    }


    function calcular_dias_entrega() //alpa&Ivoy
    {
        $fecha_actual = new DateTime();
        $fecha_actual->getTimestamp();
        $fecha      = date_format($fecha_actual, 'Y-m-d H:i:s');
        $fecha_estimada=0;
        $dia=date('l');
        $hora = date("H:i:s");
        if($dia=="Monday" || $dia=="Tuesday" || $dia=="Wednesday" || $dia=="Thursday" || $dia=="Friday" and $hora<"16:00:00"){
            $fecha_estimada = new DateTime($fecha);
            $fecha_estimada = date_format($fecha_estimada,'Y-m-d'); //Entrega mismo dia
        }elseif($hora>="16:00:00" and $dia=="Friday"){
            $fecha_estimada = new DateTime($fecha); //Se entrega al dia siguiente
            $fecha_estimada = date_format($fecha_estimada->add(new DateInterval('P3D')),'Y-m-d');
        }elseif($dia=="Saturday"){
            $fecha_estimada = new DateTime($fecha);
            $fecha_estimada = date_format($fecha_estimada->add(new DateInterval('P2D')),'Y-m-d');
        }else{
            // Se entrega siguiente dia
            $fecha_estimada = date_format($fecha_estimada->add(new DateInterval('P1D')),'Y-m-d');
        }
        return $fecha_estimada;
    }


    #if(isset($_POST['paqueteria'])=="PAQUETERIA") {
        //     //Obtener los datos segun el número de tienda elegida
        //     $nombre_tienda = isset($_POST['nom_tienda']) ? $_POST['nom_tienda'] : null;
        //     $status         = isset($_POST['status']) ? $_POST['status'] : null;
        //     $id_usuario     = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
        //     $num_partidas   = isset($_POST['num_partidas']) ? $_POST['num_partidas'] : null;
        //     $pais           = "México";
        //     $forma_envio    = "Sucursal DHL";
        //     $forma_pago     = isset($_POST['pago']) ? $_POST['pago'] : null;
        //     $fecha_actual = new DateTime();$fecha_actual->getTimestamp();
        //     $fecha          = date_format($fecha_actual, 'Y-m-d H:i:s');
        //     $subtotal       = isset($_POST['subtotal']) ? $_POST['subtotal'] : null;
        //     $iva            = isset($_POST['iva']) ? $_POST['iva'] : null;
        //     $total          = isset($_POST['total']) ? $_POST['total'] : null;
        //     $costo_envio    = isset($_POST['costo_envio']) ? $_POST['costo_envio'] : null;
        //     $costo_sobrepeso= isset($_POST['costo_sobrepreso']) ? $_POST['costo_sobrepreso'] : null;
        //     $fecha_entrega  = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : null;
        //     $fecha_estimada = isset($_POST['fecha_estimada']) ? $_POST['fecha_estimada'] : null;
        // }
        // elseif(isset($_POST['domicilio'])=="DOMICILIO"){
        //     // Autoincremento  $id_pedido      = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : null;
        //     $status         = isset($_POST['status']) ? $_POST['status'] : null;
        //     $id_usuario     = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
        //     $a_nombre_de    = isset($_POST['a_nombre_de']) ? $_POST['a_nombre_de'] : null;
        //     $requiere_factura= isset($_POST['factura']) ? $_POST['factura'] : null;
        //     if ($requiere_factura) { #En caso de requerir factura
        //         // Almaceno datos de factura
        //         $datos_factura = isset($_POST['datos_factura']) ? $_POST['datos_factura'] : null;
        //         $rfc = isset($_POST['rfc']) ? $_POST['rfc'] : null;
        //         $razon_social = isset($_POST['razon_social']) ? $_POST['razon_social'] : null;
        //         $calle_fac = isset($_POST['calle']) ? $_POST['calle'] : null;
        //         $num_int_fac = isset($_POST['num_int']) ? $_POST['num_int'] : null;
        //         $num_ext_fac = isset($_POST['num_ext']) ? $_POST['num_ext'] : null;
        //         $ciudad_fac = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
        //         $cp_fac = isset($_POST['cp']) ? $_POST['cp'] : null;
        //         $estado_fac = isset($_POST['estado']) ? $_POST['estado'] : null;
        //         $cdfi = isset($_POST['cfdi']) ? $_POST['cfdi'] : null;
        //         //Insertar en una tabla [FACTURAS]
        //     }
        //     $num_partidas   = isset($_POST['num_partidas']) ? $_POST['num_partidas'] : null;
        //     $calle          = isset($_POST['calle_pedido']) ? $_POST['calle_pedido'] : null;
        //     $num_ext        = isset($_POST['ext_pedido']) ? $_POST['ext_pedido'] : null;
        //     $num_int        = isset($_POST['int_pedido']) ? $_POST['int_pedido'] : null;
        //     $codigo_postal  = isset($_POST['cp_pedido']) ? $_POST['cp_pedido'] : null;
        //     $colonia        = isset($_POST['colonia_pedido']) ? $_POST['colonia_pedido'] : null;
        //     $municipio      = isset($_POST['ciudad_mun_pedido']) ? $_POST['ciudad_mun_pedido'] : null;
        //     $estado         = isset($_POST['estado_pedido']) ? $_POST['estado_pedido'] : null;
        //     $pais           = "México";
        //     $forma_envio    = isset($_POST['forma_envio']) ? $_POST['forma_envio'] : null;
        //     $forma_pago     = isset($_POST['pago']) ? $_POST['pago'] : null;
        //     $fecha_actual = new DateTime();$fecha_actual->getTimestamp();
        //     $fecha          = date_format($fecha_actual, 'Y-m-d H:i:s');
        //     $subtotal       = isset($_POST['subtotal']) ? $_POST['subtotal'] : null;
        //     $iva            = isset($_POST['iva']) ? $_POST['iva'] : null;
        //     $total          = isset($_POST['total']) ? $_POST['total'] : null;
        //     $costo_envio    = isset($_POST['costo_envio']) ? $_POST['costo_envio'] : null;
        //     $costo_sobrepeso= isset($_POST['costo_sobrepreso']) ? $_POST['costo_sobrepreso'] : null;
        //     $fecha_entrega  = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : null;
        //     $fecha_estimada = isset($_POST['fecha_estimada']) ? $_POST['fecha_estimada'] : null;
        //     echo $status,$id_usuario,$a_nombre_de,$requiere_factura,$num_partidas,$calle,$num_ext,$num_int,
        //     $codigo_postal,$colonia,$municipio,$estado,$pais,$forma_envio,$forma_pago,$fecha,$subtotal,
        //     $iva,$total,$costo_envio,$costo_sobrepeso,$fecha_entrega,$fecha_estimada;
        // }
        // elseif(isset($_POST['sucursal_alpa'])=="SUCURSAL_ALPA"){
        //     $nombre_tienda = "Sucursal CDMX";
        //     $calle  = "Calle: Av. Escuinapa #53";
        //     $colonia = "Col. Pedregal de Santo Domingo";
        //     $cp = "CP. 04369, Coyoacan";
        //     $ciudad = "Ciudad de México, México";
        //     $pais = "México";
        //     $tipo_envio = "Envío gratis";
        // }

    #Dependiendo de la forma de pago (tarjeta-openpay,spei,OXXO,Paypal), 
    #reenviar al usuario a la página indicada
    

?>