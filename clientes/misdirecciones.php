<?php
session_start(); //Iniciar sesion o reanudar
include "../includes/conexion_db.php";
include "../MDir_envio.php";
include "../includes/funciones.php";
$datos = asignar_obtener_id(); //Obtengo los datos que me regresa la funcion
if (is_array($datos)){$id_cliente=$datos[0];$id_temporal=$datos[1];}else{$id_cliente="";$id_temporal=$datos;}
if(isset($_SESSION['nombre_cliente'])){
    $objDireccion = new DireccionEnvio();
    $id_cliente = $_SESSION['id_usuario'];
    if (isset($_GET['id_direccion'])){
        if (isset($_GET['del'])) {
            $id_direccion = $_GET['id_direccion'];
            $objDireccion->eliminarDireccion($id_cliente,$id_direccion);
            $sin_datos="";
        }else{
            $id_direccion = $_GET['id_direccion'];
            $resultDire = $objDireccion->editarMiDirecciones($id_direccion,$id_cliente);
            $rowP = mysqli_fetch_array($resultDire);
            $sin_datos="Editando";
        }
    }else{
        $sin_datos="";
    }
    $misDirecciones = $objDireccion->listarMisDirecciones($id_cliente);
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
    <title>Tienda Alpa - Mis direcciones</title>
    <style>
    .form-control {
        font-size: 0.75rem;
    }

    h5 {
        text-align: center;
    }

    h4 {
        font-size: 1rem;
    }

    .describe-pago {
        font-weight: bolder;
        font-size: 0.9rem;
    }

    .opcion-pago {
        color: #444;
    }

    .opcion-pago:hover {
        color: #9E1F1A;
    }

    .sin-cuadro {
        border: 0px;
        border-bottom: 1px #ccc solid;
        border-radius: 0px;
        font-size: 1rem;

    }

    .titulo-entrada {
        margin-top: 9px;
        text-align: left;
        margin-right: 5px;
        font-weight: bolder;
    }

    .fila-pago {
        padding-bottom: 20px;
        padding-top: 20px;
        transition: 0.5s;
        border-bottom: 1px #eee solid;
    }

    .fila-pago:hover {
        background-color: #f2f2f2;
        border-radius: 5px;
    }

    .fila-activa {
        background-color: #f2f2f2;
        border-radius: 5px;
        color: #9E1F1A;
        border-bottom: 0;
    }

    .nombre-cliente {
        text-align: right;
        margin-top: 10px;
        font-size: 1.2rem;
    }

    @media(max-width: 576px) {
        .nombre-cliente {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

    }
    /* ENvio */
    #cp.cp_error{
        border: 1px solid red;
    }
    </style>
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
        <div class="row" style="color:#666;">
            <div class="col-sm-1"></div>
            <div class="col-sm-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background:transparent">
                        <li class="breadcrumb-item"><a href="./">Mi Cuenta</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mis Direcciones</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-5 nombre-cliente">
                <img src="https://www.tiendaalpa.com/img/cuenta.svg"
                    style="height:22px;margin-right:10px;"><?php echo $_SESSION['nombre_cliente']; ?>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <div id="caja_alerta" class="col-md-10 offset-md-1">
            <div id="alerta" class="mb-0 alert alert-dismissible invisible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p class="text-center m-0" id="mensaje_texto"></p>
            </div>
        </div>
        <div class="row">
            <div class="row mb-3 justify-content-center">
                <?php while ($row = mysqli_fetch_array($misDirecciones)) { ?>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                                <div class="form-check">
                                    <?php if(isset($_GET['elegir_dirreccion'])){?>
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" <?php if($row['selected']==1){ echo "checked"; }?>>
                                    <?php }?>
                                    <h6 class="card-subtitle mb-2 text-muted">Dirección <?php echo $row['id_direccion']; ?></h6>
                                </div>
                            <p class="card-text">
                                <?php echo $row['nom_direccion'].", ".$row['calle'].", ".$row['num_ext'].", ".$row['num_int'].", ".$row['colonia'].", ".$row['cp'].", ".$row['ciudad'].", ".$row['estado'].", ".$row['pais'].", ".$row['referencia']?>
                            </p>
                            <a href="misdirecciones.php?del=delete&id_direccion=<?php echo $row['id_direccion'];?>"
                                class="card-link">Eliminar</a>
                            <a href="misdirecciones.php?id_direccion=<?php echo $row['id_direccion'];?>"
                                class="card-link">Editar</a>
                            <?php if(isset($_GET['elegir_dirreccion'])){?>
                            <button id="<?php echo $row['id_direccion'];?>" class="btn btn-sm btn-block mt-2 btn-info elegirDir">Elegir y continuar</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="caja-blanca col-md-10 offset-md-1">
                <div class="col-md-12">
                    <form class="needs-validation" novalidate>
                        <h4 class="mb-3">Dirección de envío</h4>
                        <input type="text" hidden id="num_cliente" name="num_cliente" value="<?php echo $id_cliente;?>">
                        <input type="text" hidden id="id_direccion" name="id_direccion"
                            value="<?php if($sin_datos!=''){ echo $id_direccion;}?>">
                        <div class="row" style="margin-top:0px;margin-bottom:15px;">
                            <div class="col-md-6 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Calle:</div>
                                <input type="text" name="calle" class="form-control sin-cuadro" id="calle"
                                    placeholder="Calle" value="<?php if($sin_datos!=''){ echo $rowP['calle']; } ?>"
                                    required>
                            </div>
                            <div class="col-md-3 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Ext.:</div>
                                <input type="text" name="num_ext" class="form-control sin-cuadro" id="num_ext"
                                    placeholder="# Ext." value="<?php if($sin_datos!=''){ echo $rowP['num_ext']; } ?>"
                                    required>
                            </div>
                            <div class="col-md-3 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Int:</div>
                                <input type="text" name="num_int" class="form-control sin-cuadro" id="num_int"
                                    placeholder="# Int." value="<?php if($sin_datos!=''){ echo $rowP['num_int']; }?>">
                            </div>
                        </div>
                        <div class="row" style="margin-top:0px;margin-bottom:15px;">
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Codigo Postal:</div>
                                <input type="text" name="cp" class="form-control sin-cuadro" style="width:50%" id="cp"
                                    placeholder="Codigo Postal" id="cp" value="<?php if($sin_datos!=''){ echo $rowP['cp'];}?>"
                                    required onblur="compruebaCP(this.value)">
                            </div>
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Colonia:</div>
                                <input type="text" name="colonia" class="form-control sin-cuadro" id="colonia"
                                    placeholder="Colonia" value="<?php if($sin_datos!=''){ echo $rowP['colonia']; } ?>"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Ciudad:</div>
                                <input type="text" name="ciudad" class="form-control sin-cuadro" id="ciudad"
                                    placeholder="Ciudad" value="<?php if($sin_datos!=''){ echo $rowP['ciudad']; }?>"
                                    required>
                            </div>
                        </div>
                        <div class="row" style="margin-top:0px;margin-bottom:15px;">
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Municipio:</div>
                                <input type="text" name="municipio" class="form-control  sin-cuadro" id="municipio"
                                    placeholder="Municipio"
                                    value="<?php if($sin_datos!=''){ echo $rowP['municipio'];}?>" required>
                            </div>
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Estado:</div>
                                <input type="text" name="estado" class="form-control sin-cuadro" id="estado"
                                    placeholder="Estado" value="<?php if($sin_datos!=''){ echo $rowP['estado'];}?>"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Pais:</div>
                                <input type="text" name="pais" class="form-control  sin-cuadro" id="pais"
                                    placeholder="Pais" value="<?php if($sin_datos!=''){ echo $rowP['pais'];}?>"
                                    required>
                            </div>
                        </div>
                        <div class="row" style="margin-top:0px;margin-bottom:15px;">
                            <div class="col-md-6 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Entre calles:</div>
                                <input type="text" name="entrecalles" class="form-control  sin-cuadro" style="width:70%"
                                    id="entrecalles" placeholder="Entre calles"
                                    value="<?php if($sin_datos!=''){ echo $rowP['entre_calles'];}?>">
                            </div>
                            <div class="col-md-6 mb-3" style="display:inline-flex;">
                                <div class="titulo-entrada">Referencia:</div>
                                <input type="text" name="referencia" class="form-control sin-cuadro" id="referencia"
                                    placeholder="Referencia"
                                    value="<?php if($sin_datos!=''){ echo $rowP['referencia']; } ?>">
                            </div>
                        </div>
                        <button id="misDirecciones" name="insertDir" value="INSERTDIRECC"
                            class="btn btn-primary btn-lg btn-block" type="submit">Guardar cambios</button>
                    </form>
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
                    response.response.asentamiento.forEach(asentamiento => {
                        $("#colonia").append('<option value="'+asentamiento+'">'+asentamiento+'</option>');
                    });
                    $("#ciudad").val(response.response.ciudad);
                    $("#municipio").val(response.response.municipio).prop("readonly","readonly")
                    $("#estado").val(response.response.estado).prop("readonly","readonly");
                    $("#pais").val(response.response.pais).prop("readonly","readonly");
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
        $("#colonia").empty();
        $("#ciudad").val("");
        $("#estado").val("");
        $("#pais").val("");
    }
    </script>
    <script src="../js/misDirecciones.js"></script>
    <!-- Optional JavaScript -->
    <script src="../bootbox/bootbox.min.js"></script>
    <script src="../js/cartAdd.js"></script>
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