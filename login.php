<?php
session_start(); //Iniciar sesion o reanudar
if (isset($_SESSION['email'])) { //En caso de que existe una sesion se redirecciona
    header("Location:index.php");
}else{
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login - Alpa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .alert-dismissible{
        display:none;
    }
    .alert-success{
        display:inherit;
    }
    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    
    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.3/examples/floating-labels/floating-labels.css" rel="stylesheet">
</head>

<body style="padding-top: 0;">
    <div class="container">
        <div class="row">
        <div class="col-md-6 offset-md-3" style="border-radius:10px; background-color:white;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
        <form class="form-signin" id="loginform" action="" method="post" autocomplete="off">
        <?php //Obtener url
        if (isset($_GET['location'])!='') {
            $location = $_GET['location']; //Toma el url donde quiere ir el usuario
        }else if(isset($_SERVER['HTTP_REFERER'])!=''){ //Toma el url donde viene el usuario
            $location = $_SERVER['HTTP_REFERER'];
        }else{
            $location = 'index.php'; //Se le asigna uno url cuando no está dentro de nuestro sistema
        }
        ?>
        <input name="location" type="hidden" value="<?php echo $location ?>"  id="location" class="form-control">
            <div style="width:100%; text-align:center;">
                <a href="./">
                    <img src="https://www.tiendaalpa.com/img/logo.png" style="width:70%;max-width:200px;">
                </a>
            </div>
            <br>
            <div id="alerta" class="text-center alert alert-dismissible fade hide" role="alert">
                <strong>¡Error!</strong> Email o Password incorrecto
            </div>
            <div id="alerta_ok" class="alert alert-dismissible" role="alert">
                Iniciando sesión...
            </div>
            <div class="text-center">
                <h1 class="h3 mb-3 font-weight-normal" style="color:#9E1F1A">Iniciar sesión</h1>
            </div>
            <div class="form-label-group">
                <input name="email" type="email" id="email" class="form-control" placeholder="Email address" required
                    autofocus>
                <label for="inputEmail">Email</label>
            </div>
            <div class="form-label-group">
                <input name="password" autocomplete="off" type="password" id="password" class="form-control"
                    placeholder="Password" required>
                <label for="inputPassword">Password</label>
            </div><br>
            <button style="color:white;background:#9E1F1A" name="login" value="Login" class="btn btn-lg btn-block"
                type="submit">Iniciar
                Sesión</button>
        </form>
        <p class="mt-2 text-center text-muted font-weight-lighter">
            Aún no tienes una cuenta? <a href="register.php" class="text-reset text-decoration-none"> Haz clic aquí</a>
        </p>
    </div>
        </div>
    </div>
    
    <script src="js/login.js"></script>
    <script src="js/jquery.js"></script>
</body>

</html>
<?php
    }
?>