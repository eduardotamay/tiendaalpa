<?php
session_start(); //Iniciar sesion o reanudar
include "../includes/funciones.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
if(isset($_SESSION['nombre_cliente'])){
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/clientes.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/main.js"></script>
    <title>Tienda Alpa - Cuenta</title>
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
    <div class="container" style="margin-top:120px;">
        <div class="row" style="margin-bottom:30px; color:#666;">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">Mi Cuenta</div>
            <div class="col-sm-7" style="text-align:right;">
            <img src="https://www.tiendaalpa.com/img/cuenta.svg" style="height:15px;margin-right:10px;"><?php echo $_SESSION['nombre_cliente']; ?>
            </div class="col-sm-1">
            <div></div>
        </div>
        <div class="row" style="margin-top:25px;margin-bottom:25px;">
            <div class="col-md-10 offset-md-1">
                <div class="caja-blanca" style="font-size:0.8rem;text-align:center;">
                    <div class="row">
                        <div class="col-sm-2 my-auto">
                            <img src="https://www.tiendaalpa.com/img/cuenta.svg" style="height:60px;">
                        </div>
                        <div class="col-sm-8" style="text-align:left;">
                            <h3>Mis datos</h3>
                            <p style="font-size:0.8rem;color:#666">Cambiar contraseña, editar correo electrónico, administra datos de facturación</p>
                        </div>
                        <div class="col-sm-2 my-auto">
                        <a style="margin-left:15px;"  class="btn btn-primary btn-sm" href="misdatos.php" role="button">Ver</a>       
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:25px;margin-bottom:25px;">
            <div class="col-md-10 offset-md-1">
                <div class="caja-blanca" style="font-size:0.8rem;text-align:center;">
                    <div class="row">
                        <div class="col-sm-2 my-auto">
                            <img src="https://www.tiendaalpa.com/img/pedidos.png" style="height:60px;">
                        </div>
                        <div class="col-sm-8" style="text-align:left;">
                            <h3>Mis Pedidos</h3>
                            <p style="font-size:0.8rem;color:#666">Rastrear paquetes, descargar facturas, ver productos comprados</p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a style="margin-left:15px;"  class="btn btn-primary btn-sm" href="misdatos.php" role="button">Ver</a>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:25px;margin-bottom:25px;">
            <div class="col-md-10 offset-md-1">
                <div class="caja-blanca" style="font-size:0.8rem;text-align:center;">
                    <div class="row">
                        <div class="col-sm-2 my-auto">
                            <img src="https://www.tiendaalpa.com/img/direcciones.png" style="height:60px;">
                        </div>
                        <div class="col-sm-8" style="text-align:left;">
                            <h3>Mis Direcciones</h3>
                            <p style="font-size:0.8rem;color:#666">Administrar direcciones de pedidos</p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a id="misdirecciones" style="margin-left:15px;"  class="btn btn-primary btn-sm" href="misdirecciones.php" role="button">Ver</a>
                        </div>
                    </div>
                </div>
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
    <!-- Optional JavaScript -->
    <script src="../bootbox/bootbox.min.js"></script>
    <script src="../js/cartAdd.js"></script>
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