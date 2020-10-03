<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Registro - Alpha</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/floating-labels/">
    <script src="js/jquery.js"></script>
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
    <div class="col-md-12">
        <form id="register_form" class="form-signin" action="" method="post" autocomplete="off">
            <div id="alerta" class="text-center alert alert-dismissible fade hide" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>¡Error!</strong> No se pudo crear la cuenta
            </div>
            <div id="alerta_ok" class="text-center alert alert-dismissible fade hide" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>¡Bien!</strong> La Cuenta ha sido creada
            </div>
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal" style="color:#9E1F1A">Crear cuenta</h1>
            </div>
            <div class="form-label-group">
                <input autocomplete="off" name="name" type="text" id="name" class="form-control" placeholder="Nombre"
                    required="true">
                <label id="inputUser" for="inputUser">Nombre</label>
            </div>
            <div class="form-label-group">
                <input autocomplete="off" name="email" type="email" id="email" class="form-control"
                    placeholder="ejemplo@gmail.com" required="true">
                <label for="inputEmail">Correo</label>
            </div>
            <div class="form-label-group">
                <input autocomplete="off" name="password" type="password" id="password" class="form-control"
                    placeholder="Contraseña" required="true">
                <label for="inputPassword">Contraseña</label>
            </div><br>
            <button style="color:white;background:#9E1F1A" name="register" value="Register" id="enviar-btn"
                class="btn btn-lg btn-block" type="submit">Registrarse
                ahora</button>
        </form>
        <p class="mt-2 text-center text-muted font-weight-lighter">
            Ya tienes una cuenta?<a href="login.php" class="text-reset text-decoration-none"> Inicia Sesión</a>
        </p>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="js/insertData.js"></script>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
</body>

</html>