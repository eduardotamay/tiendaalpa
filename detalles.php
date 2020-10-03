<?php
session_start();//Iniciar sesion o reanudar
#PARA ASIGNAR ID's
include "includes/conexion_db.php";
include "includes/funciones.php";
include "MCarrito.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
#FIN

$producto = isset($_REQUEST['producto']) ? $_REQUEST['producto'] :FALSE;
$objCarrito = new Carrito();
if (isset($_SESSION['email'])) {
    // echo $id_cliente.$fecha;
    $objCarrito->actualizar_id_cliente($id_cliente,$id_temporal);
}

if($producto){
    $objConexion = new Conexion();
    $sql = "SELECT * FROM productos WHERE sku='".$producto."'";
    $consulta = $objConexion->generarTransaccion($sql);
}
if($consulta->num_rows != 1){
    header('Location: index.php');
}
$row=$consulta->fetch_assoc();

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/detalle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <title>Tienda Alpa</title>
</head>

<body>
    <div id="barra-contacto">
        <div id="contacto-tel"><img src="img/call.svg" style="height:18px;"> Tel. 5560 681643</div>
        <div id="pagina-contacto"><a href="contacto/">Contacto</a></div>
    </div>
    <nav id="barra-menu" class="navbar fixed-top navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="./">
            <img src="img/logo.png" width="120" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline">
                <input class="form-control mr-0" id="barra-busqueda" type="search" onkeyup="showResult(this.value)"
                placeholder="Buscar..." aria-label="Search">
                <div class="buscar_detalle" id="livesearch"></div>
            </form>
            <?php
                define('PATH','./'); //Lo uso para que el path sea DINÁMICO
                define('PATH_CAR','./');
                include("includes/ul.php"); 
            ?>
        </div>
    </nav>
    <div class="container" style="margin-top:120px;">
        <div class="row">
            <div class="col" id="detalle-linea">
                <a href="./">Inicio</a> > <a
                    href="busqueda.php?producto=<?php echo dame_linea($row['linea']); ?>"><?php echo dame_linea($row['linea']); ?></a>
                > <a href="#">Sublínea</a>
                <div class="alerta">
                </div>
            </div>
            <div id="caja_alerta" class="col-12">
                <div id="alerta" class="mb-0 alert alert-dismissible invisible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p class="text-center m-0" id="mensaje_texto"></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="cuadro-detalle">
                <div class="row">
                    <div class="col-sm-5">
                        <img id="imgProd" src="<?php if(buscarFotoProducto($row['sku'].".jpg")){echo 'fotos/'.$row['sku'].".jpg";}else{echo "img/".$row['marca'].".jpg";}?>" class="imagen-detalle">
                        <div class="row">
                            <div class="col-3">
                                <div class="describe-envios-cuadros">
                                    <div class="cuadro-gris">
                                        <img src="img/envios-pais.png" class="imagen-formas-envios"><br>
                                        Envio a todo <br>el pais
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="describe-envios-cuadros">
                                    <div class="cuadro-gris">
                                        <img src="img/compra-segura.png" class="imagen-formas-envios"><br>
                                        Compra <br>segura
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="describe-envios-pagos">
                                    Formas de Pago:<br>
                                    <img src="img/formas-pago/citibanamex.png" class="imagen-formas-pago-mini">
                                    <img src="img/formas-pago/paypal.png" class="imagen-formas-pago-mini"><br>
                                    <img src="img/formas-pago/oxxo.png" class="imagen-formas-pago-mini">
                                    <img src="img/formas-pago/spei.png" class="imagen-formas-pago-mini">
                                    <img src="img/formas-pago/visa.png" class="imagen-formas-pago-mini">
                                    <img src="img/formas-pago/mastercard.png" class="imagen-formas-pago-mini">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-8" id="clave-producto">
                                <span class="indicador">Producto</span>
                                <h2 id="claveGates"><?php echo $row['clavegates']; ?></h2>
                            </div>
                            <div class="col-4 ">
                                <img src="img/<?php echo $row['marca']; ?>.jpg" id="marca-detalle">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" id="descripcion-detalle">
                                <?php echo $row['descripcion']; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="indicador">SKU: </span><span
                                    id="sku-detalle"><?php echo $row['sku']; ?></span>
                                <span class="indicador">Unidad: </span><span
                                    class="cuadro-detalle-unidad"><?php echo strtoupper($row['unidad']); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3><?php echo dame_linea($row['linea']); ?></h3>
                                <p>El funcionamiento de las bandas Micro-V® de Gates supera otras bandas con bordes en
                                    V, dado que las costillas de la banda son más cortas. Esta característica de su
                                    diseño proporciona a las bandas Micro-V® mayor flexibilidad, reduciendo la
                                    acumulación de calor y permitiendo que operen a altas velocidades en poleas de
                                    diámetro menor</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-3 cuadro-precios-detalle">
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-4 alinea-derecha">Precio</div>
                            <div class="col-8 alinea-izquierda" id="precio-detalle">
                                $<?php echo number_format($row['precio1'],2); ?>
                            </div>
                            <?php 
                                $cantidad = intval(3);
                                $precio = floatval($row['precio1']);
                                $total = $cantidad*$precio; 
                            ?>
                        </div>
                        <div class="row" style="margin-top: 50px;">
                            <div class="col-4 alinea-derecha" style="padding-top:8px;">Cantidad</div>
                            <div class="col-8 alinea-izquierda">
                                <select class="form-control resultado-cantidad" id="cantidad">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="text-align: center;">
                            <a id="AddCar" class="btn btn-primary btn-sm" href="#" style="margin: 50px auto;"
                                role="button">Agregar
                                a carrito</a>
                        </div>
                        <div class="idUser">
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
            </div>
        </div>
    </div>
    <!-- Include footer -->
    <?php 
        define('PATH_INDEX_FOOTHER','./');
        define('PATH_FOOTHER','../');
        include("includes/footer.php")
    ?>
    <!-- Include footer -->
    <script src="bootbox/bootbox.min.js"></script>
    <script src="js/addToCar.js"></script>
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