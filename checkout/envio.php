<?php
session_start(); //Iniciar sesion o reanudar
include "../includes/conexion_db.php";
include "../MCarrito.php";
include "../MProducto.php";
include "../includes/funciones.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
if(isset($_SESSION['nombre_cliente'])){
    $objCarrito = new Carrito();
    $objProducto = new Producto();
    $id_cliente = $_SESSION['id_usuario'];
    $resultado = $objCarrito->ver_producto_en_carrito($id_cliente);
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
                <div style="width:35%; height:10px; background-color:rgb(158, 31, 26); border-radius:5px;"></div>
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
        <div class="row" style="margin-top:40px; margin-bottom:80px; text-align:center;color:#666;">
            <div class="col-md-8" style="margin-bottom:25px;">
                <div class="caja-blanca" style="font-size:0.8rem">
                    <h5>Selecciona forma de envío</h5>
                    <div class="row" style="margin-top:33px;">
                        <div class="col-md-4" >
                            <div id="domicilio" class="opcion-envio" onclick="carga_forma_envio('domicilio');">
                                <svg version="1.1" class="icono-envio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <path class="st0" d="M208 448V320h96v128h97.6V256H464L256 64 48 256h62.4v192z"></path>
                                </svg><br>
                                Domicilio
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="ocurre" class="opcion-envio" onclick="carga_forma_envio('ocurre');">
                                <svg version="1.1" class="icono-envio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <path class="st0" d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                    c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                    c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                </svg><br>
                                Sucursal DHL
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="sucursal" class="opcion-envio" onclick="carga_forma_envio('sucursal');">
                                <svg version="1.1" class="icono-envio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <path class="st0" d="M433.5,25.5h-408v51h408V25.5z M459,280.5v-51L433.5,102h-408L0,229.5v51h25.5v153h255v-153h102v153h51v-153H459z
                                    M229.5,382.5h-153v-102h153V382.5z"></path>
                                </svg><br>
                                Sucursal Alpa
                            </div>
                        </div>
                    </div>
                    <div id="detalle-envio"></div>
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
                </div>
            </div>
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