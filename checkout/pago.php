<?php
session_start(); //Iniciar sesion o reanudar
    include "../includes/conexion_db.php";
    include "../MUsuario.php";
    include "../MCarrito.php";
    include "../MProducto.php";
    include "../includes/funciones.php";
    include "../MDir_envio.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
if(isset($_SESSION['nombre_cliente'])){
    $objUsuario = new Usuario();
        $id_cliente = $_SESSION['id_usuario'];
        $result = $objUsuario->buscar_Usuario($id_cliente);
        $row =mysqli_fetch_array($result);

        $objCarrito = new Carrito();
        $objProducto = new Producto();
        $resultado = $objCarrito->ver_producto_en_carrito($id_cliente);

    if ($_POST['seleccion_envio']=="DOMICILIO") {
        $seleccion_envio = $_POST['seleccion_envio'];
        switch ($_POST['envio']) {
            case 'dhl':
                $forma_envio=$_POST['envio'];
                $envio = 140;
                break;
            case 'ivoy':
                $forma_envio=$_POST['envio'];
                $envio=199;
                break;
            case 'alpa':
                $forma_envio=$_POST['envio'];
                $envio = 69;
                break;
            }
            $a_nombre_de = $_POST['nombre'];
            $calle_pedido = $_POST['calle'];
            $ext_pedido = $_POST['exterior'];
            $int_pedido = $_POST['interior'];
            $cp_pedido = $_POST['codigo_postal']; 
            $colonia_pedido = $_POST['colonia'];
            $ciudad_pedido = $_POST['ciudad'];
            $estado_pedido = $_POST['estado'];
        
            //Actualizar direccion de envio en caso de tenerlo.
            $objDireccion = new DireccionEnvio;
            $resul = $objDireccion->verMisDirecciones($id_cliente);
            $row_dir = mysqli_fetch_array($resul);
            //Comparo las direcciones con la de mi BD
        if ($_POST['calle']!=$row_dir['calle'] || $_POST['exterior']!=$row_dir['num_ext'] || $_POST['interior']!=$row_dir['num_int'] ||
        $_POST['codigo_postal']!=$row_dir['cp'] || $_POST['colonia']!=$row_dir['colonia'] || $_POST['ciudad']!=$row_dir['ciudad'] || $_POST['estado']!=$row_dir['estado']) {
            //actualizo los datos
            $objDireccion->actualizar_dire_cliente($id_cliente,1,$_POST['calle'],$_POST['exterior'],$_POST['interior'],$_POST['colonia'],$_POST['codigo_postal'],$_POST['ciudad'],$_POST['estado']);
        }   
    }elseif($_POST['seleccion_envio']=="PAQUETERIA"){
        //Obtener los datos y actuazlizo datos T. misDirecciones (si es que existe cambios)
        $seleccion_envio = $_POST['seleccion_envio'];
        $forma_envio    = "Sucursal DHL";
        $subtotal       = isset($_POST['subtotal']) ? $_POST['subtotal'] : null;
        $iva            = isset($_POST['iva']) ? $_POST['iva'] : null;
        $total          = isset($_POST['total']) ? $_POST['total'] : null;
        $envio    = isset($_POST['costo_envio']) ? $_POST['costo_envio'] : null;
        if(isset($_POST['nombre_tienda_envio1'])!=""){
            $a_nombre_de = isset($_POST['nombre']) ? $_POST['nombre'] : null;
            $nombre_tienda = isset($_POST['nombre_tienda_envio1']) ? $_POST['nombre_tienda_envio1'] : null;
            $calle = isset($_POST['calle_envio']) ? $_POST['calle_envio'] : null;
            $cp = isset($_POST['cp_envio']) ? $_POST['cp_envio'] : null;
            $estado = isset($_POST['estado_envio']) ? $_POST['estado_envio'] : null;
            $ciudad = isset($_POST['ciudad_envio']) ? $_POST['ciudad_envio'] : null;
        }elseif(isset($_POST['nombre_tienda_envio2'])!=""){
            $a_nombre_de = isset($_POST['nombre']) ? $_POST['nombre'] : null;
            $nombre_tienda = isset($_POST['nombre_tienda_envio2']) ? $_POST['nombre_tienda_envio1'] : null;
            $calle = isset($_POST['calle_envio']) ? $_POST['calle_envio'] : null;
            $estado = isset($_POST['estado_envio']) ? $_POST['estado_envio'] : null;
            $ciudad = isset($_POST['ciudad_envio']) ? $_POST['ciudad_envio'] : null;
        }elseif(isset($_POST['nombre_tienda_envio3'])!=""){
            $a_nombre_de = isset($_POST['nombre']) ? $_POST['nombre'] : null;
            $nombre_tienda = isset($_POST['nombre_tienda_envio3']) ? $_POST['nombre_tienda_envio1'] : null;
            $calle = isset($_POST['calle_envio']) ? $_POST['calle_envio'] : null;
            $estado = isset($_POST['estado_envio']) ? $_POST['estado_envio'] : null;
            $ciudad = isset($_POST['ciudad_envio']) ? $_POST['ciudad_envio'] : null;
        }
        //Actualizar direccion de envio (en su caso).
        $objDireccion = new DireccionEnvio;
        $resul = $objDireccion->verMisDirecciones($id_cliente);
        $row_dir = mysqli_fetch_array($resul);
        if ($_POST['calle_envio']!=$row_dir['calle'] || $_POST['ciudad_envio']!=$row_dir['ciudad'] || $_POST['estado_envio']!=$row_dir['estado'] || $_POST['cp_envio']!=$row_dir['cp'] ) {
            //actualizo los datos
            $objDireccion->actualizar_dire_cliente_sucursal_dhl($id_cliente,1,$_POST['calle_envio'],$_POST['ciudad_envio'],$_POST['estado_envio'],$_POST['cp_envio']);
        }

    }elseif(isset($_POST['seleccion_envio'])=="SUCURSAL_ALPA"){
        $seleccion_envio = $_POST['seleccion_envio'];
        $nombre_tienda = "Sucursal CDMX";
        $calle  = "Calle: Av. Escuinapa #53";
        $colonia = "Col. Pedregal de Santo Domingo";
        $cp = "04369";
        $ciudad = "Ciudad de México, México";
        $pais = "México";
        $envio = 0;
        $forma_envio = "Sucursal Alpa";
        $a_nombre_de=$row['nombre_cliente'];

        //Actualizar direccion de envio (en su caso).
        $objDireccion = new DireccionEnvio;
        $resul = $objDireccion->verMisDirecciones($id_cliente);
        $row_dir = mysqli_fetch_array($resul);
        if ($calle!=$row_dir['calle'] || $colonia!=$row_dir['colonia'] || $ciudad!=$row_dir['ciudad'] || $ciudad!=$row_dir['ciudad'] || $cp!=$row_dir['cp'] ) {
            //actualizo los datos
            $objDireccion->actualizar_dire_cliente_sucursal_alpa($id_cliente,1,$calle,$colonia,$cp,$ciudad,$pais);
        }

    }
    // Hacer el del envio gratis(Sucursal alpa)
    header('Cache-Control: no cache');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/checkout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/main.js"></script>
    <title>Tienda Alpa</title>
</head>
<style>
    .form-control{
        font-size:0.75rem;
    }
    h5{
        text-align:center;
    }
    h4{
        font-size: 0.95rem;
    }
    .describe-pago{
        font-weight: bolder;
        font-size: 0.9rem;
    }
    .opcion-pago{
        color:#444;
    }
    .opcion-pago:hover{
        color:#9E1F1A;
    }
    .sin-cuadro{
        border:0px; border-bottom: 1px #ccc solid; border-radius: 0px;
    }
    .titulo-entrada{
        margin-top:9px; 
        text-align: right;
        padding-right: 0px;
    }
    .fila-pago{
        padding-bottom: 20px;
        padding-top: 20px;
        transition: 0.5s;
    }
    .fila-pago:hover{
        background-color: #f2f2f2;
        border-radius: 5px;
    }
    .fila-activa{
        background-color: #f2f2f2;
        border-radius: 5px;
        color:#9E1F1A;
    }
    #cp.cp_error{
    border: 1px solid red;
}
</style>
<body>
    <div id="barra-contacto">
        <div id="contacto-tel"><img src="../img/call.svg" style="height:18px;"> Tel. 5560 681643</div>
        <div id="pagina-contacto"><a href="../contacto/">Contacto</a></div>
    </div>
    <nav id="barra-menu" class="navbar fixed-top navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="../">
            <img src="../img/logo.png" width="120" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form>
                <input class="form-control mr-0" id="barra-busqueda" type="search" onkeyup="showResult2(this.value)"
                    placeholder="Buscar..." aria-label="Search">
                <div id="livesearch"></div>
            </form>
            <?php
                define('PATH','../'); //Lo uso para que el path sea DINÁMICO
                define('PATH_CAR','../'); //Lo uso para que el path sea DINÁMICO
                include("../includes/ul.php");
            ?>
        </div>
    </nav>
    <div class="container margen-top">
        <div class="row">
            <div class="col-md-6 offset-md-3" id="carrito-status" style="margin-top:15px;" >
                <div style="background-color:#ddd; width:80%; margin:0 auto; height:10px; border-radius:5px;">
                <div style="width:70%; height:10px; background-color:rgb(158, 31, 26); border-radius:5px;"></div>
                </div>
                <div class="row" style="margin-top:-20px; color:#ddd;">
                    <div class="col">
                        <img src="../img/carritoblanco.png" style="width:18px; margin-top:5px; margin-left:5px; position:absolute;">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="rgb(158, 31, 26)" /> 
                        </svg>
                        <br><span style="color:rgb(158, 31, 26)">Carrito</span>
                    </div>
                    <div class="col">
                    <img src="../img/envio.png" style="width:18px; margin-top:9px; margin-left:7px; position:absolute;">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="rgb(158, 31, 26)" />
                        </svg>
                        <br><span style="color:rgb(158, 31, 26)">Envío</span>
                    </div>
                    <div class="col">
                        <img src="../img/pago.png" style="width:12px; margin-top:6px; margin-left:9px; position:absolute;">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="rgb(158, 31, 26)" />
                        </svg>
                        <br><span style="color:rgb(158, 31, 26)">Pago</span>
                    </div>
                    <div class="col">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="#ddd" />
                        </svg>
                        <br>Confirmación
                    </div>
                </div>
            </div>
        </div>
        <form action="../CPedido.php" method="POST">
            <input type="text" name="id_usuario" hidden="true" value="<?php echo $id_cliente?>">
            <input type="text" name="a_nombre_de" hidden="true" value="<?php echo $a_nombre_de?>">
            <input type="text" name="forma_envio" hidden="true" value="<?php echo $forma_envio?>">
            <input type="text" name="envio" hidden="true" value="<?php echo $envio?>">
            <?php if(($_POST['seleccion_envio'])=="PAQUETERIA" || ($_POST['seleccion_envio'])=="SUCURSAL_ALPA"){?>
                <input type="text" name="nom_tienda" hidden="true" value="<?php echo $nombre_tienda?>">
            <?php }?>
            <div class="row" style="margin-top:40px; margin-bottom:80px;color:#666;">
                <div class="col-md-8" style="margin-bottom:25px;">
                    <div class="caja-blanca" style="font-size:0.8rem;">
                        <h5>¿Deseas Facturar?</h5>
                        <div class="row" style="margin-top:25px;">
                            <div class="col-md-4 mb-3"></div>
                            <div class="col-md-2 mb-3" style="text-align:center">
                                <label class="radio-inline">
                                    <input type="radio" name="factura" id="factura_no" value="si" checked="" onclick="opciones_facturacion('SI')" onload=""> 
                                    <span style="font-weight: Bold;">Sí</span>
                                </label>
                            </div>
                            <div class="col-md-2 mb-3" style="text-align:center">
                                <label class="radio-inline">
                                    <input type="radio" name="factura" id="factura_no" value="no" onclick="opciones_facturacion('NO')" onload=""> 
                                    <span style="font-weight: Bold;">No</span>
                                </label>
                            </div>
                            <div class="col-md-4 mb-3"></div>
                        </div>
                        <div id="facturacion">
                            <div class="row" style="margin-top:0px;margin-bottom:15px;">
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    RFC*:
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" name="rfc" class="form-control sin-cuadro" id="rfc" placeholder="RFC" value="<?php echo $row['rfc'];?>" required>
                                </div>
                                <div class="col-md-2 mb-3 titulo-entrada">
                                    Razón Social*:
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="razon_social" class="form-control sin-cuadro" id="razon-social" placeholder="Razón Social" value="<?php echo $row['razon_social']; ?>" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;margin-bottom:15px;">
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    Calle:
                                </div>
                                <div class="col-md-5 mb-3">
                                    <input type="text" name="calle" class="form-control sin-cuadro" id="lastName" placeholder="Calle" value="<?php echo $row['calle'];?>" required>
                                </div>
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    # Ext:
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="text" name="num_ext" class="form-control sin-cuadro" id="lastName" placeholder="# Ext." value="<?php echo $row['num_exterior']; ?>" required>
                                </div>
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    # Int:
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="text" name="num_int" class="form-control sin-cuadro" id="lastName" placeholder="# Int." value="<?php echo $row['num_interior'];?>">
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;margin-bottom:15px;">
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    Ciudad:
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" id="ciudad" name="ciudad" class="form-control sin-cuadro" id="zip" placeholder="Ciudad" value="<?php echo $row['ciudad']; ?>" required>
                                </div>
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    C.P.:
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="text" name="cp" class="form-control sin-cuadro" id="cp" placeholder="C.P." value="<?php echo $row['cp'];?>" onblur="compruebaCP(this.value)" required>
                                </div>
                                <div class="col-md-1 mb-3 titulo-entrada">
                                    Estado:
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="text" name="estado" id="estado" class="form-control sin-cuadro" id="zip" placeholder="Estado" value="<?php echo $row['estado']; ?>" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;margin-bottom:15px;">
                                <div class="col-md-3 mb-3"></div>
                                <div class="col-md-2 mb-3 titulo-entrada">
                                    Uso de CFDI*:
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select name="cfdi" class="custom-select d-block w-100" id="state" required>
                                        <option value="">Selecciona...</option>
                                        <option value="G01" <?php if ($row['cfdi']=="G01") {echo "Selected";} ?> >Adquisición de mercancía</option>
                                        <option value="G03" <?php if ($row['cfdi']=="G03") {echo "Selected";} ?>>Gastos generales</option>
                                        <option value="I04" <?php if ($row['cfdi']=="I04") {echo "Selected";} ?>>Equipo de cómputo y accesorio</option>
                                        <option value="P01" <?php if ($row['cfdi']=="P01") {echo "Selected";} ?>>Por definir</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3"></div>
                            </div>
                        </div>
                        <h5>Forma de Pago</h5>
                        <a href="#Tarjeta" class="opcion-pago" onclick="selecciona('tarjeta')">
                            <div class="row fila-pago" id="tarjeta">
                                <div class="col-md-1 my-auto"></div>
                                <div class="col-md-1 my-auto">
                                    <input style="margin:0 auto;" type="radio" name="pago" value="tarjeta" required="">
                                </div>
                                <div class="col-md-6 my-auto" style="text-align:left;">
                                    <span class="describe-pago">
                                        Tarjeta Debito/Credito
                                    </span>
                                </div>
                                <div class="col-md-3 my-auto" style="text-align:right;">
                                <img src="../img/visa.png" style="height:20px;">
                                <img src="../img/mastercard.png" style="height:25px;">
                                </div>
                                <div class="col-md-1 my-auto"></div>
                            </div>
                        </a>
                        <a href="#Tarjeta" class="opcion-pago" onclick="selecciona('oxxo')">
                        <div class="row fila-pago"  id="oxxo">
                            <div class="col-md-1 my-auto"></div>
                            <div class="col-md-1 my-auto">
                                <input style="margin:0 auto;" type="radio" name="pago" value="oxxo" required="">
                            </div>
                            <div class="col-md-6 my-auto" style="text-align:left;">
                                <span  class="describe-pago">
                                    OXXO
                                </span>
                            </div>
                            <div class="col-md-3 my-auto" style="text-align:right;">
                            <img src="../img/oxxo.png" style="height:25px;">
                            </div>
                            <div class="col-md-1 my-auto"></div>
                        </div>
                        </a>
                        <a href="#Tarjeta" class="opcion-pago" onclick="selecciona('spei')">
                        <div class="row fila-pago" id="spei">
                            <div class="col-md-1 my-auto"></div>
                            <div class="col-md-1 my-auto">
                                <input style="margin:0 auto;" type="radio" name="pago" value="spei" required="">
                            </div>
                            <div class="col-md-6 my-auto" style="text-align:left;">
                                <span class="describe-pago">
                                    Transferencia bancaria
                                </span>
                            </div>
                            <div class="col-md-3 my-auto" style="text-align:right;">
                            <img src="../img/spei.png" style="height:25px;">
                            </div>
                            <div class="col-md-1 my-auto"></div>
                        </div>
                        </a>
                        <a href="#Tarjeta" class="opcion-pago" onclick="selecciona('deposito')">
                        <div class="row fila-pago" id="deposito">
                            <div class="col-md-1 my-auto"></div>
                            <div class="col-md-1 my-auto">
                                <input style="margin:0 auto;" type="radio" name="pago" id="deposito" value="deposito" required="">
                            </div>
                            <div class="col-md-6 my-auto" style="text-align:left;">
                                <span  class="describe-pago">
                                    Deposito en ventanilla
                                </span>
                            </div>
                            <div class="col-md-3 my-auto" style="text-align:right;">
                            <img src="../img/citibanamex.png" style="height:25px;">
                            </div>
                            <div class="col-md-1 my-auto"></div>
                        </div>
                        </a>
                        <a href="#Tarjeta" class="opcion-pago" onclick="selecciona('paypal')">
                        <div class="row fila-pago" id="paypal">
                            <div class="col-md-1 my-auto"></div>
                            <div class="col-md-1 my-auto">
                                <input style="margin:0 auto;" type="radio" name="pago" id="paypal" value="paypal" required="">
                            </div>
                            <div class="col-md-6 my-auto" style="text-align:left;">
                                <span  class="describe-pago">
                                    Paypal
                                </span>
                            </div>
                            <div class="col-md-3 my-auto" style="text-align:right;">
                            <img src="../img/paypal.png" style="height:25px;">
                            </div>
                            <div class="col-md-1 my-auto"></div>
                        </div>
                        </a>
                        <div style="width:100%; text-align:center">
                            <button class="btn btn-primary btn-sm" type="submit" style="margin-top: 20px;">
                                Confirmar pago
                            </button>
                        </div>
                    </div>
                </div>
                <?php
                    $subtotal_pedido = 0;
                    while ($row=mysqli_fetch_array($resultado)) {
                        $busquedaSKU = $objProducto->buscar_producto_sku($row['sku']);
                        $subtotal_pedido = $subtotal_pedido + ($row['cantidad']*$row['precio']);
                    }
                ?>
                <div class="col-md-4">
                    <div class="caja-blanca sticky-top" style="top:100px;" id="cuadro-resumen">
                    <h5>Resumen del pedido</h5>
                    <hr>
                        <div class="row">
                            <div class="col-6 izquierda">SUBTOTAL:</div>
                            <div id="subtotal" class="col-6 derecha">$<?php echo $subtotal = number_format($subtotal_pedido,2); ?></div>
                            <input name="subtotal" type="text" value="<?php echo $subtotal ?>" hidden="true">
                        </div>
                        <div class="row">
                            <div class="col-6 izquierda">ENVIO:</div>
                            <div id="envio" class="col-6 derecha"><?php if($envio<=0){echo "GRATIS";$costo_envio=0;}else{echo "$". $costo_envio = number_format($envio,2); }?></div>
                            <input name="costo_envio" type="text" value="<?php echo $costo_envio ?>" hidden="true">
                        </div>
                        <div class="row">
                            <div class="col-6 izquierda">IVA:</div>
                            <div id="iva" class="col-6 derecha">$<?php echo $ivaPedido  = number_format(($subtotal_pedido*0.16),2)?></div>
                            <input name="iva" type="text" value="<?php echo $ivaPedido ?>" hidden="true">
                        </div>
                        <div id="costo-total">
                            <div class="row">
                                <div class="col-6 izquierda">TOTAL:</div>
                                <div id="totalPagar" class="col-6 derecha">$<?php echo $total = number_format(floatval($envio+(floatval(str_replace(',','',$ivaPedido))+$subtotal_pedido)),2)?></div>
                                <input name="total" type="text" value="<?php echo $total ?>" hidden="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="idUser invisible">
                <?php
                    if (is_array($datos)){
                        $id_user=$datos[0]; 
                        $id_temporal=$datos[1];
                        echo "<input id='id_user' type='text' value='".$id_user."'>";
                        echo "<input id='id_temporal' type='text' value='".$id_temporal."'>";
                    }else{
                        $id_temporal=$datos;
                        echo "<input id='id_temporal' type='text' value='".$id_temporal."'>";
                    }
                ?>
            </div>
    </div>
    <!-- Include footer -->
    <?php 
        define('PATH_INDEX_FOOTHER','../');
        define('PATH_FOOTHER','../'); 
        include("../includes/footer.php")
    ?>
    <div class="modal"></div>
    <!-- Include footer -->
    <script>
    $body = $("body");
    $(document).ready(function() {
        var scroll_start = 0;
        var startchange = $('#barra-menu');
        var offset = startchange.offset();
        if (startchange.length) {
            $(document).scroll(function() {
                scroll_start = $(this).scrollTop();
                if (scroll_start > offset.top) {
                    $(".navbar-light").css('top', '0px');
                    $('.navbar-light').css('backdrop-filter', 'saturate(180%) blur(20px)');
                    $('.navbar-light').css('background', 'rgba(255,255,255,0.5)');
                } else {
                    $('.navbar-light').css('top', '30px');
                }
            });
        }
    });
    $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
function carga_forma_envio(envio){
    var url="";
    if(envio=='domicilio'){url="domicilio.php";quita_clase();$("#domicilio").addClass("opcion-envio-activa")}
    else if(envio=='ocurre'){url="paqueteria.php";quita_clase(); $("#ocurre").addClass("opcion-envio-activa")}
    else if(envio=='sucursal'){url="sucursal.php"; quita_clase();$("#sucursal").addClass("opcion-envio-activa")}
    $.ajax({
            data:  { parte: "ok" },
            url: url,
            type:  'get',
            beforeSend: function () {
                    //$("#load").html('Procesando, espere por favor...');
            },
            success:  function (response) {
                $("#detalle-envio").html(response);
            }
    });
}
function quita_clase(){
    $("#domicilio").removeClass("opcion-envio-activa");
     $("#ocurre").removeClass("opcion-envio-activa");
     $("#sucursal").removeClass("opcion-envio-activa");
}
function selecciona(opcion){
    var $radios = $('input:radio[name=pago]');
    $radios.filter('[value='+opcion+']').prop('checked', true);
    $(".fila-pago").removeClass("fila-activa");
    $("#"+opcion).addClass("fila-activa");
    }
function opciones_facturacion(opcion){
    if(opcion==='SI'){
        $('#facturacion').show(1000);
    }
    else{
         $('#facturacion').hide(1000);
    }
}
// VALIDAR CP
function compruebaCP(cp) {
    var codigo_postal = cp;
    if (codigo_postal.length!=0) {
        vaciarCampos();
        $.ajax({
            type: "POST",
            url: "../includes/validar_cp.php",
            data: {
                comprobar_CP: "COMP_CP",
                codigo_postal
            },
            cache: false,
            success: function (response) {
                $("#ciudad").val(response.response.municipio).prop("readonly","readonly")
                $("#estado").val(response.response.estado).prop("readonly","readonly");
                $("#cp").removeClass("cp_error");
                cp_anterior = response.response.cp;
            },
            error:function(response){
                if (response.statusText="Error") {
                    $("#cp").addClass("cp_error");
                    vaciarCampos();
                }
            }
        });   
    }
}
function vaciarCampos() {
    $("#ciudad").val("");
    $("#estado").val("");
 }
    </script>
    <script src="../bootbox/bootbox.min.js"></script>
    <script src="../js/cartAdd.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>
</html>
<?php
}else{
    header("location:../login.php?location=".urlencode($_SERVER['REQUEST_URI']));
}
?>