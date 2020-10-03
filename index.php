<?php
    session_start(); //Iniciar sesion o reanudar
    #PARA ASIGNAR ID's
    include "includes/funciones.php";
    include "MCarrito.php";
    include "MUsuario.php";
    include "MProducto.php";
    $datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
    if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
    #FIN
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
    $objProducto = new Producto();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="favicon.png" sizes="64x64">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bd6298d1af.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <title>Tienda Alpa</title>
</head>

<body>
    <div id="barra-contacto">
        <div id="contacto-tel"><img src="img/call.svg" style="height:18px;"> Tel. 55 5619 0502</div>
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
            <form autocomplete="off">
                <input  class="form-control mr-0" id="barra-busqueda" type="search" onkeyup="showResult(this.value)"
                    placeholder="Buscar..." aria-label="Search">
                <div id="livesearch"></div>
            </form>
            <?php
                define('PATH','./'); //Lo uso para que el path sea DINÁMICO
                define('PATH_CAR','./');
                include("includes/ul.php"); 
            ?>
        </div>
    </nav>
    <div id="myCarousel" style="margin-top: 90px;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-item active">
            <div style="background: url('img/slides/1.jpg') 50% 0%; height:400px;">
                <div class="fondo-c" style="height:400px;"></div>
            </div>

            <div class="container">
                <div class="row carousel-caption">
                    <div class="col-sm-6"><img src="img/bandas.png" class="imagen-carousel"></div>
                    <div class="col-sm-6">
                        <h1>Bandas MicroV</h1>
                        <p class="detalle-baner">Banda ranurada para transmitir potencia a uno o varios de los
                            accesorios del motor.</p>
                        <p><a class="btn btn-lg btn-primary" style="background-color:#9E1F1A;border:0px;" href="#"
                                role="button">Ver productos</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div style="background: url('img/slides/2.jpg') 50% 0%; height:400px;">
                <div class="fondo-c" style="height:400px;"></div>
            </div>
            <div class="container">
                <div class="row carousel-caption">
                    <div class="col-sm-6"><img src="img/manguera.png" class="imagen-carousel"></div>
                    <div class="col-sm-6">
                        <h1>Mangueras</h1>
                        <p class="detalle-baner">En la selección de las Mangueras, una característica importante es la
                            Presión de Trabajo.</p>
                        <p><a class="btn btn-lg btn-primary" style="background-color:#9E1F1A;border:0px;" href="#"
                                role="button">Ver productos</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div style="background: url('img/slides/3.jpg') 50% 0%;height:400px;">
                <div class="fondo-c" style="height:400px;"></div>
            </div>
            <div class="container">
                <div class="row carousel-caption">
                    <div class="col-sm-6"><img src="img/equipo.png" class="imagen-carousel"></div>
                    <div class="col-sm-6">
                        <h1>GC32</h1>
                        <p class="detalle-baner">Equipo de crimpado inteligente, contiene toda la información en su
                            pantalla tablet digital para realizar el trabajo en serie</p>
                        <p><a class="btn btn-lg btn-primary" style="background-color:#9E1F1A;border:0px;" href="#"
                                role="button">Ver detalles</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="container" style="margin-top:36px;">
        <div class="row">
            <h2 class="titulo-seccion">
                DESTACADOS
            </h2>
        </div>
        <div id="caja_alerta" class="col-12">
            <div id="alerta" class="mb-0 alert alert-dismissible invisible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p class="text-center m-0" id="mensaje_texto"></p>
            </div>
        </div>
        <div class="row">
            
        <?php
            $vector = $objProducto->listarProductoDestacado();
            while ($row=mysqli_fetch_array($vector)) {
            $skuProducto = $row['sku'].".jpg";
        ?>
            <div class="col-sm-3 cuadro-producto">
                <div class="caja">     <!--Si la funcion devuelve algo imprimo img producto, sino sería la marca-->
                    <a href="detalles.php?producto=<?php echo $row['sku']?>" >
                    <img src="<?php if(buscarFotoProducto($skuProducto)){echo 'fotos/'.$row['sku'].".jpg";}else{echo "img/".$row['marca'].".jpg";}?>" class="imagen-caja">
                    <h3 class="titulo-producto"><?php echo $row['clavegates'] ?></h3>
                    <p class="descripcion-producto"><?php echo $row['descripcion'] ?></p>
                    <p class="descripcion-producto"><span class="negrita">SKU:</span><?php echo $row['sku'] ?></p>
                    </a>
                    <div class="precio-caja">
                        $<?php echo number_format($row['precio1'],2);?><br>
                        <span style="color:#888;font-size:0.8rem;text-decoration: line-through">$<?php echo number_format($row['precio1']*1.1,2);?></span>
                    
                    </div>
                    <div class="unidad-caja">
                        <div class="cuadro-unidad">PIEZA</div>
                    </div>
                    <div style="margin-top:-10px;margin-bottom: 15px;width:50%;float:left;text-align: right; padding-right: 10px;padding-top: 5px; font-size:0.9rem;">
                        Cantidad
                    </div>
                    <div style="margin-top:-10px;margin-bottom: 15px;width:50%;float:left;">
                        <select style="width:65px;height:30px;font-size: 0.7rem;" class="form-control resultado-cantidad" id="cantidad<?php echo $row['sku'];?>">
                            <?php 
                            for($i=1;$i<=$row['existencia'];$i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }              
                            ?>
                        </select>
                    </div>
                    <br style="clear: both;">
                    <a id="<?php echo $row['sku'];?>" class="btn btn-primary btn-sm agregar_car addCar" href="#" role="button">Agregar a carrito</a>
                </div>
            </div>
        <?php
            }
        ?>  
            <!-- <div class="col-md-3 cuadro-producto">
                <div class="caja">
                    <img src="img/FLH516.png" class="imagen-caja">
                    <h3 class="titulo-producto">FLH5/16</h3>
                    <p class="descripcion-producto">MANGUERA GASOLINA HULE</p>
                    <p class="descripcion-producto"><span class="negrita">SKU:</span> FLH5/16</p>
                    <div class="precio-caja">$45.20<br><span class="sin-descuento">$49.99</span></div>
                    <div class="unidad-caja">
                        <div class="cuadro-unidad">METRO</div>
                    </div>
                    <br style="clear: both;">
                    <a class="btn btn-primary btn-sm" href="#" role="button">Detalles</a>
                </div>
            </div>
            <div class="col-md-3 cuadro-producto">
                <div class="caja">
                    <img src="img/35B38.jpg" class="imagen-caja">
                    <h3 class="titulo-producto">35B3/8</h3>
                    <p class="descripcion-producto">MANGUERA PARA AGUA DE 3/8"</p>
                    <p class="descripcion-producto"><span class="negrita">SKU:</span> 35B3/8</p>
                    <div class="precio-caja">$53.00<br></div>
                    <div class="unidad-caja">
                        <div class="cuadro-unidad">METRO</div>
                    </div>
                    <br style="clear: both;">
                    <a class="btn btn-primary btn-sm" href="#" role="button">Detalles</a>
                </div>
            </div>
            <div class="col-md-3 cuadro-producto">
                <div class="caja">
                    <img src="img/730054590006.jpg" class="imagen-caja">
                    <h3 class="titulo-producto">730054590006</h3>
                    <p class="descripcion-producto">G-4-459F-6-B</p>
                    <p class="descripcion-producto"><span class="negrita">SKU:</span> 730054590006</p>
                    <div class="precio-caja">$11.80<br></div>
                    <div class="unidad-caja">
                        <div class="cuadro-unidad">PIEZA</div>
                    </div>
                    <br style="clear: both;">
                    <a class="btn btn-primary btn-sm" href="#" role="button">Detalles</a>
                </div>
            </div> -->
        </div>
    </div>
    <div class="container" id="lineas-productos" style="margin-top: 36px;">
        <div class="row">
            <h2 class="titulo-seccion">
                LÍNEAS DE PRODUCTOS
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=automotriz">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas" style="background: url('img/automotriz.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Automotriz
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=hidraulica">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas" style="background: url('img/hidraulica.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Hidráulica
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=industrial">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas" style="background: url('img/industrial.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Industrial
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=neumatica">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas" style="background: url('img/neumatica.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Neumática
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=camiones">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas" style="background: url('img/camiones.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Camiones
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 menu-lineas">
                <a href="busqueda.php?producto=otrasmarcas">
                    <div style="background-color: black; width: 100%; height: 100%;">
                        <div class="fondo-lineas"
                            style="background: url('img/otrasmarcas.jpg');background-size:cover; ">
                            <div class="texto-lineas">
                                Otras marcas
                            </div>
                        </div>
                    </div>
                </a>
            </div>
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
    <!-- Include footer -->
    <?php
        define('PATH_INDEX_FOOTHER','./');
        define('PATH_FOOTHER','../');
        include("includes/footer.php")
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
    <!-- Agregar productos en el carrito funcionando -->
    <script src="bootbox/bootbox.min.js"></script>
    <script src="js/addToCar.js"></script>
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