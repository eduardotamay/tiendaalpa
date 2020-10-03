<?php
session_start(); //Iniciar sesion o reanudar
include "../includes/conexion_db.php";
    include "../MUsuario.php";
    include "../includes/funciones.php";
    include "../MProducto.php";
    include "../MPedido.php";
    include "../MCarrito.php";
    include "../MDir_envio.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
if(isset($_SESSION['nombre_cliente'])){
    $id_cliente = $_SESSION['id_usuario'];
    $idpedido = $_GET['pedido'];
    $objUsuario = new Usuario();
        $result = $objUsuario->buscar_Usuario($id_cliente);
        $row =mysqli_fetch_array($result);
    $objProducto = new Producto();
    $objPedido = new Pedido();
        $resultPedido = $objPedido->buscar_pedido_cliente($id_cliente,$idpedido);
        $rowPedido = mysqli_fetch_array($resultPedido);
        $resultado = $objPedido->ver_detalle_pedido($idpedido);
    $objDireccion = new DireccionEnvio;
        $resul = $objDireccion->verMisDirecciones($id_cliente);
        $row_dir = mysqli_fetch_array($resul);
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
    h5{
        font-size:1.4rem;
        color:black;
    }
    h6{
        font-size:0.8rem;
        color:#666;
    }
    .numero-pedido{
        text-align:left;
    }
    .fecha-pedido{
        text-align:right;
        margin-top: 7px;
    }
    #productos-box{
       border-right:1px #ccc solid;
    }
    .fila-producto{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .imagen-confirmacion{
        width: 100%;
    }
    .sku-producto{
        color:#9E1F1A;
        font-weight: bold;
        font-size: 0.8rem;
    }
    .desc-producto{
        font-size: 0.7rem;
    }
    .cant-producto{
        font-weight: bold;
        font-size: 0.8rem;
    }
    .cantidad{
        color:black;
        font-weight: bold;
        font-size: 0.8rem;
    }
    .col-subtotal{
        text-align: center;
    }
    @media(max-width: 576px) {
        .numero-pedido{
        text-align:center;
        }
        .fecha-pedido{
            text-align:center;
        }
        #productos-box{
       border-right:0px;
    }
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
            <div class="col-md-6 offset-md-3" id="carrito-status" style="margin-top:20px;" >
                <div style="background-color:#ddd; width:80%; margin:0 auto; height:5px; border-radius:5px;">
                    <div style="width:100%; height:5px; background-color:rgb(158, 31, 26); border-radius:5px;"></div>
                </div>
                <div class="row" style="margin-top:-18px; color:#ddd;">
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
                        <img src="../img/confirmacion.png" style="width:12px; margin-top:6px; margin-left:9px; position:absolute;">
                        <svg width="30" height="30">
                            <circle cx="15" cy="15" r="15" fill="rgb(158, 31, 26)" />
                        </svg>
                        <br><span style="color:rgb(158, 31, 26)">Confirmación</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:40px;">
            <div class="col" style="text-align: center;">
                <h2>Confirmación del pedido</h2>
                <p style="font-size: 0.75rem;">
                    ¡Gracias <span style="color:black;font-weight: bolder;"><?php echo $row['nombre_cliente']." ".$row['apellido'];?></span>! Tu pedido ha sido realizado. Esta confirmación será enviada al correo <?php echo $row['email'];?>.
                    Una vez recibida tu confirmación del pago , procesaremos tu pedido y te avisaremos por correo.
                    Recuerda que la vigencia de esta confirmación es de 5 días naturales.
                </p>
            </div>
        </div>
        <div class="row" style="margin-top:20px; margin-bottom:80px;color:#666;">
            <div class="col-md-8" style="margin-bottom:25px;">
                <div class="caja-blanca" style="font-size:0.8rem;">
                    <div class="row">
                        <div class="col-md-6 numero-pedido">
                            <h5 style="font-weight:bold;">Pedido #<?php echo $rowPedido['id_pedido'];?></h5>
                            <h6><span style="color:black">A nombre de:</span> <?php echo $rowPedido['a_nombre_de']; ?></h6>
                        </div>
                        <div class="col-md-6 fecha-pedido">
                            <h6 style="color:black">Fecha estimada de entrega:</h6>
                            <h6>
                                <?php
                                    setlocale(LC_TIME, "spanish");
                                    $formatoFecha = date("d-m-Y", strtotime($rowPedido['fecha_estimada']));
                                    $fechaES = strftime("%A, %d de %B", strtotime($formatoFecha));
                                    echo utf8_encode($fechaES);
                                ?>
                            </h6>
                        </div>
                    </div>
                    <hr style="margin-top:0.2rem;">
                    <div class="row">
                        <div class="col-md-7" id="productos-box" style="">
                            <div class="row" style="margin-bottom:15px;">
                                <div class="col-8" style="font-size:1rem;color:black;font-weight: bold;">Producto</div>
                                <div class="col-4" style="text-align:center;color:black;font-size:1rem;font-weight: bold;">Subtotal</div>
                            </div>
                            <?php
                            $subtotal_pedido = 0;
                            while ($row=mysqli_fetch_array($resultado)) {
                                $busquedaSKU = $objProducto->buscar_producto_sku($row['sku']);
                                $subtotal_pedido = $subtotal_pedido + ($row['cantidad']*$row['precio_unitario']);
                            ?>
                            <div class="row fila-producto">
                                <div class="col-8 my-auto col-producto">
                                    <div class="row">
                                        <div class="col-3 my-auto"><img src="<?php if(buscarFotoProductoCarrito($row['sku'].".jpg")){echo '../fotos/'.$row['sku'].".jpg";}else{echo "../img/".$busquedaSKU['marca'].".jpg";}?>"" class="imagen-confirmacion"></div>
                                        <div class="col-9 my-auto">
                                            <span class="sku-producto"><?php echo $row['sku'];?></span><br>
                                            <span class="desc-producto"><?php echo $row['descripcion'];?></span><br>
                                            <span class="cant-producto">Cantidad: </span><span class="cantidad"><?php echo $row['cantidad'];?></span>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 my-auto col-subtotal">$<?php echo number_format($row['importe']+$row['iva'],2);?></div>
                            </div>
                            <hr>
                            <?php } ?>
                        </div>
                        <div class="col-md-5">
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-6" style="color:black;font-size:1rem;font-weight: bold;">Envío</div>
                                <div class="col-6" style="text-align:right;"><img src="<?php if($rowPedido['forma_envio']=='dhl'){echo '../img/dhl.svg';}elseif($rowPedido['forma_envio']=='Sucursal Alpa'){echo '../img/logo.png';}elseif($rowPedido['forma_envio']=='Sucursal DHL'){echo '../img/dhl.svg';}elseif($rowPedido['forma_envio']=='ivoy'){echo '../img/ivoy.png';}elseif($rowPedido['forma_envio']=='alpa'){echo '../img/logo.png';}?>" style="height:12px;"></div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h6 style="color:black">Dirección:</h6>
                                    <p style="font-size:0.8rem;"><span style="font-weight: bold;">Calle:</span><?php echo $row_dir['calle'].", ".$row_dir['num_int'] ?><br>
                                        <span style="font-weight: bold;">Col.</span> <?php echo $row_dir['colonia']; ?> <span style="font-weight: bold;">CP.</span> <?php echo $row_dir['cp'];?>,<br>
                                        <span style="font-weight: bold;"><?php echo $row_dir['ciudad'];?>,</span><?php echo $row_dir['estado'];?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="caja-blanca sticky-top" style="top:100px;">
                    <div class="row">
                        <div class="col" style="color:#ff9900;font-size:1rem;font-weight: bold;text-align: center;">Pago pendiente</div>
                    </div>
                    <hr>
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-6" style="color:black;font-size:1rem;font-weight: bold;">Transferencia</div>
                        <div class="col-6" style="text-align:right;"><img src="https://www.tiendaalpa.com/img/spei.png" style="height:20px;"></div>
                    </div>
                    <p style="font-size:0.8rem;text-align:center; color:black;font-weight: bolder;">A nombre de:<br><span style="font-weight: bolder;"> AUTOPARTES ALPA S.A. DE C.V</span></p>
                    <p style="font-size:0.8rem;text-align:left; color:black;font-weight: bolder;">Clabe:<span style="font-weight: bolder;"> 002180034633555324</span></p>
                    <p style="font-size:0.8rem;text-align:left; color:black;font-weight: bolder;">Referencia:<span style="font-weight: bolder;">10000</span></p>
                    <p style="font-size:0.6rem;text-align:left; color:#444;font-weight: bolder;">Para poder localizar tu pago, es muy importante que lo hagas por la cantidad exacta en pesos y centavos.</p>
                    <p style="font-size:0.6rem;text-align:left; color:#444;font-weight: bolder;">Una vez realizado el pago, tardaremos 1 día habil en validar el pago y surtir el pedido</p>
                    <div class="row" style="padding-top:15px;padding-bottom: 15px; font-weight: bolder;">
                        <div class="col-1"></div>
                        <div class="col-5">SUBTOTAL:</div>
                        <div class="col-5 derecha">$<?php echo number_format($rowPedido['subtotal'],2);?></div>
                        <div class="col-1"></div>
                    </div>
                    <div class="row" style="padding-top:15px;padding-bottom: 15px;font-weight: bolder;">
                        <div class="col-1"></div>
                        <div class="col-5">ENVIO:</div>
                        <div class="col-5 derecha"><?php if($rowPedido['costo_envio']<=0){echo "GRATIS";$costo_envio=0;}else{echo "$". $costo_envio = number_format($rowPedido['costo_envio'],2); }?></div>
                        <div class="col-1"></div>
                    </div>
                    <div class="row" style="padding-top:15px;padding-bottom: 15px;font-weight: bolder;">
                        <div class="col-1"></div>
                        <div class="col-5">IVA:</div>
                        <div class="col-5 derecha">$<?php echo $rowPedido['iva'];?></div>
                        <div class="col-1"></div>
                    </div>
                    <div id="costo-total">
                        <div class="row" style="padding-top:15px;padding-bottom: 15px;">
                            <div class="col-1"></div>
                            <div class="col-5">TOTAL:</div>
                            <div class="col-5 derecha">$<?php echo $rowPedido['total'];?></div>
                            <div class="col-1"></div>
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
        include("../includes/footer.php");
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
    }
    </script>
    <script src="../js/addToCar.js"></script>
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