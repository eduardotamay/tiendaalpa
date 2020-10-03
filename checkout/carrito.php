<?php
session_start(); //Iniciar sesion o reanudar
#PARA ASIGNAR ID's
include "../includes/conexion_db.php";
include "../includes/funciones.php";
include "../MCarrito.php";
include "../MUsuario.php";
include "../MProducto.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
//Me sirve para obtener id usuario al iniciar sesión, sino uso el temporal(timetimes)
$objUsuario = new Usuario();
if ($id_cliente!='') {
    $result = $objUsuario->buscar_Usuario($id_cliente);
    $row =mysqli_fetch_array($result);
    $id_cliente = intval($row['id_usuario']);
}else{
    $id_cliente = $id_temporal;
}
$objCarrito = new Carrito();
// $fecha = date("Y-m-d H:i:s",$id_temporal);
if (isset($_SESSION['email'])) {
   $objCarrito->actualizar_id_cliente($id_cliente,$id_temporal);
}
$resultado = $objCarrito->ver_producto_en_carrito($id_cliente);
$objProducto = new Producto();
if (isset($_POST["campofiltro"])) {
    $cantidades = $_POST['campofiltro']; //Le asigno el valor segun elegido
    foreach ($cantidades as $key => $value) {
        $value;
    }
    $cantidades=$value;
    $precio = $_POST['precio'];
    $sku_producto = $_POST['sku_producto'];
    $resultP = $objProducto->buscar_Producto($sku_producto,$cantidades);
    $rowp = mysqli_fetch_array($resultP);
        if($rowp>0){
            //Convertir el id_temporal a Timestamp
            $unidad = $rowp['unidad'];
            $cantidad = intval($cantidades);
            $peso = intval($rowp['peso']);
            $precio = floatval($rowp['precio1']);
            $existencia = $rowp['existencia'];
            $existencia = $existencia-$cantidad;

            //Antes de insertar producto al carrito verificamos para evitar duplicidad
            $objCarrito->verificar_producto_carrito($id_cliente,$sku_producto);
            //Si existe producto en carrito, update (cantidad,peso,precio,fecha_registro)
            $objCarrito->actualizar_producto_existente($id_cliente,$sku_producto,$cantidad,$peso,$precio,$existencia);
            header("Location: carrito.php");
        }   
                    
}else{
    $precio ='';
    $sku_producto ='';
    $_POST['campofiltro']='';
}
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
    <script src="https://kit.fontawesome.com/bd6298d1af.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/main.js"></script>
    <title>Tienda Alpa</title>
</head>

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
                <div style="width:0%; height:10px; background-color:rgb(158, 31, 26); border-radius:5px;"></div>
                </div>
                <div class="row" style="margin-top:-20px; color:#ddd;">
                    <div class="col">
                        <img src="../img/carritoblanco.png" style="width:20px; margin-top:5px; margin-left:5px; position:absolute;">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="rgb(158, 31, 26)" /> 
                        </svg>
                        <br><span style="color:rgb(158, 31, 26)">Carrito</span>
                    </div>
                    <div class="col">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="#ddd" />
                        </svg>
                        <br>Envío
                    </div>
                    <div class="col">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="#ddd" />
                        </svg>
                        <br>Pago
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
        <div class="row" style="margin-top:40px; margin-bottom:80px; text-align:center;">
            <div class="col-md-8" style="margin-bottom:25px;">
                <div id="caja_alerta" class="col-12">
                    <div id="alerta" class="mb-0 alert alert-dismissible invisible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p class="text-center m-0" id="mensaje_texto"></p>
                    </div>
                </div>
                <div class="caja-blanca" style="font-size:0.8rem">
                    <div class="row" id="titulo-productos-carrito">
                        <div class="col-md-2"></div>
                        <div class="col-md-4 izquierda">Producto</div>
                        <div class="col-md-2">Cantidad</div>
                        <div class="col-md-2 derecha">Subtotal</div>
                    </div>
                <?php
                    $subtotal_pedido = 0;
                    while ($row=mysqli_fetch_array($resultado)) {
                    $busquedaSKU = $objProducto->buscar_producto_sku($row['sku']);
                    $subtotal_pedido = $subtotal_pedido + ($row['cantidad']*$row['precio']);
                ?>
                    <hr id="linea-titulos-carrito">
                    <div id="boxProd" class="row">
                    <div class="col-md-2 my-auto">
                        <img src="<?php if(buscarFotoProductoCarrito($row['sku'].".jpg")){echo '../fotos/'.$row['sku'].".jpg";}else{echo "../img/".$busquedaSKU['marca'].".jpg";}?>" class="imagen-carrito">
                    </div>
                    <div class="col-md-4 my-auto producto-carrito">
                        <span style="color:rgb(158, 31, 26); font-weight:bolder; font-size:0.9rem;"><?php echo $busquedaSKU['clavegates']; ?></span><br>
                        <span id="skuProdCar" style="color:#777;font-size:0.7rem;"><?php echo $row['sku'] ?></span>
                    </div>
                    <div class="col-md-2 my-auto cantidad-carrito">
                    <form method="POST">
                        <select class="form-control cantidadProd" name='campofiltro[]' onchange="this.form.submit()">
                            <?php for ($i=1; $i <=$busquedaSKU['existencia'] ; $i++) { ?>
                                <option value="<?php echo $i ?>" <?php if($row['cantidad']==$i){ echo "selected";}?>><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                        <input hidden type="text" name="sku_producto" value="<?php echo $row['sku']?>" />
                        <input hidden type="text" name="precio" value="<?php echo number_format($row['precio'],2)?>" />
                        <noscript><input type="submit" value="Filtrar" /></noscript>
                    </form>
                    </div>
                    <div id="subtotalProdCar" class="col-md-2 derecha my-auto subtotal-carrito">$<?php echo number_format($row['subtotal_producto'],2)?></div>
                    <div id="<?php echo $row['sku'] ?>" class="col-md-2 my-auto deleteCar"><img src="../img/delete.ico" alt="delete"></div>
                    <hr>
                    </div>
                <?php } ?>
                </div>  
            </div>
            <div class="col-md-4">
                <div class="caja-blanca" id="cuadro-resumen">
                <h5>Resumen del pedido</h5>
                <hr>
                    <div class="row">
                        <div class="col-6 izquierda">SUBTOTAL:</div>
                        <div id="subtotal" class="col-6 derecha">$<?php echo number_format($subtotal_pedido,2); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 izquierda">IVA:</div>
                        <div id="iva" class="col-6 derecha">$<?php echo $ivaPedido  = ($subtotal_pedido*0.16)?></div>
                    </div>
                    <div id="costo-total">
                        <div class="row">
                            <div class="col-6 izquierda">TOTAL:</div>
                            <div id="totalPagar" class="col-6 derecha">$<?php echo number_format(($ivaPedido+$subtotal_pedido),2)?></div>
                        </div>
                    </div>
                    <br>
                    <a class="btn btn-primary btn-sm <?php if(($ivaPedido+$subtotal_pedido)<=0){ echo 'disabled';}?> " id="" href="envio.php" role="button">Comprar</a>
                </div>  
            </div>
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
    </div>
    <!-- Include footer -->
    <?php
        define('PATH_INDEX_FOOTHER','../');
        define('PATH_FOOTHER','../');
        include("../includes/footer.php")
    ?>
    <!-- Include footer -->
    <script>
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