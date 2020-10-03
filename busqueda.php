<?php
session_start();
include "includes/conexion_db.php";
include "includes/funciones.php";
include "pagination.php";
include "MCarrito.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
#FIN
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}

$objCarrito = new Carrito();
if (isset($_SESSION['email'])) {
    // echo $id_cliente.$fecha;
    $objCarrito->actualizar_id_cliente($id_cliente,$id_temporal);
}
$producto = isset($_REQUEST['producto']) ? $_REQUEST['producto'] :FALSE;
$pagina       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$enlaces      = ( isset( $_GET['enlaces'] ) ) ? $_GET['enlaces'] : 8;
//
$objConexion = new Conexion(); //Conexion
if (isset($_GET['campofiltro'])) {
    $ordenarPor = $_GET['campofiltro']; //Le asigno el valor segun elegido
}else{
    $ordenarPor=''; //por defualt
}
if(isset($_POST["campofiltro"]) || $ordenarPor!='') {//post [ordenar por]
    if (isset($_POST["campofiltro"])) {
        $ordenarPor = $_POST["campofiltro"];
        foreach ($ordenarPor as $key => $value) {
            $value;
        }
        $ordenarPor=$value;  //agarro ese valor
    }else{
        $value = $ordenarPor;
    }
    $pagina       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $enlaces      = ( isset( $_GET['enlaces'] ) ) ? $_GET['enlaces'] : 8;
   if($value=='2'){ //Mayor a menor [DESC]
        $sql = "SELECT * FROM productos WHERE descripcion LIKE '%".$producto."%'  || pal_clave LIKE '%".$producto."%' ORDER BY precio1 DESC";
   }else if($value=='3'){//Menor a mayor [ASC]
        $sql = "SELECT * FROM productos WHERE descripcion LIKE '%".$producto."%'  || pal_clave LIKE '%".$producto."%' ORDER BY precio1 ASC";
   }else if($value=='5'){
        $sql = "SELECT * FROM productos WHERE descripcion LIKE '%".$producto."%'  || pal_clave LIKE '%".$producto."%' ORDER BY sku ASC";
   } 
}else{
    if($producto){
        $sql = "SELECT * FROM productos WHERE descripcion LIKE '%".$producto."%'  || pal_clave LIKE '%".$producto."%'";
    }
}
$paginar  = new Paginar($sql);
$resultados    = $paginar->getDatos($pagina,$producto,$ordenarPor);
$num = count((array)$resultados);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/busqueda.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="js/main.js"></script>
    <title>Búsqueda | Tienda Alpa</title>
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
            <?php
                define('PATH','./'); //Lo uso para que el path sea DINÁMICO
                define('PATH_CAR','./'); 
                include("includes/ul.php"); 
            ?>
        </div>
    </nav>
    <div class="container" style="margin-top:120px;">
        <div class="row" id="cuerpo-resultado">
            <div class="col-sm-8" id="resultado-de-busqueda">
                <form class="form-inline">
                    <input class="form-control ml-2 mr-2" style="width:77%; max-width:360px;" name="producto"
                        id="barra-busqueda" autocomplete="off" type="search" placeholder="Buscar..."
                        aria-label="Search" onkeyup="showResult(this.value)">
                    <button id="boton" class="btn btn-secondary" style="padding:5px; height:calc(2.25rem + 2px)"
                        type="submit">
                        <span class="material-icons" style="line-height:0; padding-top:13px;">search</span>
                    </button>
                </form>
                <div style="z-index:1; margin-left:7px;" id="livesearch"></div>
            </div>
           
            <div class="col-sm-4">
                <form method="POST" class="form-inline" id="filtro-busqueda">
                    Ordenar por
                    <select class="form-control" name='campofiltro[]' id="campo-filtro" onchange="this.form.submit()">
                        <option value="" selected="selected" disabled="disabled"> --- Seleccionar --- </option>
                        <option disabled="disabled" value="1">Relevancia</option>
                        <option value="2" <?php if ($ordenarPor=='2') {echo "selected='selected'";}?>>Precio mayor a menor</option>
                        <option value="3" <?php if ($ordenarPor=="3") {echo "selected='selected'";}?>>Precio menor a mayor</option>
                        <option disabled="disabled" value="4">Línea</option>
                        <option value="5" <?php if ($ordenarPor=="5") {echo "selected='selected'";}?>>Alfabeticamente</option>
                    </select>
                    <input hidden type="text" name="producto" value="<?php echo $producto?>" />
                    <input hidden type="text" name="pages" value="<?php echo $pagina?>" />
                    <input hidden type="text" name="enlaces" value="<?php echo $enlaces?>" />
                    <noscript><input type="submit" value="Filtrar" /></noscript>
                </form>
            </div>
        </div>
        <div id="caja_alerta" class="col-12">
            <div id="alerta" class="mb-0 alert alert-dismissible invisible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p class="text-center m-0" id="mensaje_texto"></p>
            </div>
        </div>
        <?php 
            if($num > 0){
                echo '
                <div class="row" id="titulo-resultado">
                    <div class="col-sm-4">
                        <div class="row ajusta-margen">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">Productos</div>
                        </div>   
                    </div>
                    <div class="col-sm-3">
                        <div class="row ajusta-margen">
                            <div class="col-sm-6 centra">Marca</div>
                            <div class="col-sm-6 centra">Línea</div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row ajusta-margen">
                            <div class="col-sm-4 centra">Precio</div>
                            <div class="col-sm-4 centra">Cantidad</div>
                            <div class="col-sm-4 centra"></div>
                        </div>
                    </div>
                </div>
                ';
            echo '<div id="list">';
            // while($row=$consulta->fetch_assoc()){
            for( $i = 0; $i < count($resultados->datos); $i++ ):
                $precio = number_format($resultados->datos[$i]['precio1'],2);
                $precio_fi= str_replace(',','',$precio);
            echo'<div id="categorie-'.$precio_fi.'" class="row item-resultado">
                    <div class="col-sm-4">
                        <a href="detalles.php?producto='.$resultados->datos[$i]['sku'].'">
                            <div class="row ajusta-margen">
                                <div class="col-sm-3">';
                                    if(buscarFotoProducto($resultados->datos[$i]['sku'].".jpg")){
                                       echo '<img class="imagen-resultado" src="fotos/'.$resultados->datos[$i]['sku'].'.jpg">';
                                    }else{
                                        echo '<img class="imagen-resultado" src="img/'.$resultados->datos[$i]['marca'].'.jpg">';
                                    }
                                echo '</div>
                                <div class="col-sm-9">
                                    <div class="resultado-clave-producto">'.$resultados->datos[$i]['clavegates'].'</div>
                                    <div class="resultado-desc-producto">'.$resultados->datos[$i]['descripcion'].'</div>
                                    <div style="display:inline-flex">
                                        <div style="font-size:0.7rem;color:#777; padding-top:4px;padding-right:10px;">SKU: <span id="sku-detalle" style="font-weight:bolder;">'.$resultados->datos[$i]['sku'].'</span></div>
                                        <div class="resultado-cuadro-unidad">'.strtoupper($resultados->datos[$i]['unidad']).'</div>
                                    </div>
                                </div>
                            </div>
                        </a>  
                    </div>
                    <div class="col-sm-3">
                        <div class="row ajusta-margen">
                            <div class="col-6 centra"><img src="img/'.$resultados->datos[$i]['marca'].'.jpg" class="resultado-marca"></div>
                            <div class="col-6 resultado-linea">'.dame_linea($resultados->datos[$i]['linea']).'</div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row ajusta-margen">
                            <div id="precio_final" class="col-4 resultado-precio">$'.number_format($resultados->datos[$i]['precio1'],2).'</div>
                            <div class="col-4 centra">
                                <select class="form-control resultado-cantidad" id="cantidad'.$resultados->datos[$i]['sku'].'">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-4 centra">
                                <a id="'.$resultados->datos[$i]['sku'].'" class="btn btn-primary btn-sm addCar" href="#" role="button">Agregar a carrito</a>
                            </div>
                        </div>
                    </div>
                </div>';
            endfor;
                // }
            echo '</div>';
            echo '<div class="row pag-navigation">
                    <nav aria-label="Page navigation example" style="margin: 0 auto">
                        <ul class="pagination">
                            '.$paginar->crearLinks($enlaces).'
                        </ul>
                    </nav>
                </div>';
            }
            else{
            
                echo '<div style="height:460px; text-align:center; width:100%; font-size:2rem; padding-top:3rem;">No hay resultados que mostrar</div>';

            }
            ?>
            <!-- Me sirve para obtener los id's -->
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