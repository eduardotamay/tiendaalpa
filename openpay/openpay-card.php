<?php
    session_start();
    include "../MUsuario.php";
    include "../MPedido.php";
    
if(isset($_SESSION['nombre_cliente'])){
    $objUsuario = new Usuario();
        $id_cliente = $_SESSION['id_usuario'];
        $result = $objUsuario->buscar_Usuario($id_cliente);
        $row =mysqli_fetch_array($result);
        $objPedido = new Pedido();
        $resultado = $objPedido->buscar_pedido_cliente($id_cliente);
        $rowPedido = mysqli_fetch_array($resultado);
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="https://resources.openpay.mx/lib/openpay-js/1.2.38/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <!--Librerias para deviceData-->
    <script type="text/javascript">
        $(document).ready(function() {
            OpenPay.setId('mmdooaiwikxp3waryv1f');
            OpenPay.setApiKey('pk_9a3eca91675446499f87d9b617735849');
            OpenPay.setSandboxMode(true);
            //Se genera el id de dispositivo
            var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

            $('#pay-button').on('click', function(event) {
                event.preventDefault();
                $("#pay-button").prop("disabled", true);
                OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
            });


            var sucess_callbak = function(response) {
                var token_id = response.data.id;
                results = document.getElementById('resultDetail');
                $('#token_id').val(token_id);
                $('#payment-form').submit();
            };

            var error_callbak = function(response) {
                var desc = response.data.description != undefined ? response.data.description : response
                    .message;
                alert("Fallo en la transacción [" + response.status + "] " + desc);
                $("#pay-button").prop("disabled", false);
            };
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="pay.php" method="POST" id="payment-form">
                    <input type="hidden" name="token_id" id="token_id">
                    <input type="hidden" name="amount" id="amount" value="<?php echo $rowPedido['total'];?>">
                    <input type="hidden" name="description" id="description" value="Pago de articulos">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Pagon con Tarjeta de crédito o débito</h2>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label>Datos del cliente</label>
                        <div class="col-5">
                            <input class="form-control" value="<?php echo $row['nombre_cliente']; ?>" type="text" name="name" placeholder="Nombre"
                                autocomplete="off">
                        </div>
                        <div class="col-5">
                            <input class="form-control" value="<?php echo $row['apellido']; ?>" type="text" name="last_name"
                                placeholder="Apellido" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label>Datos de contacto:</label>
                        <div class="col-4">
                            <input class="form-control" value="Juan Perez Ramirez" type="text" name="name"
                                placeholder="Tal como aparece en la tarjeta" autocomplete="off"
                                data-openpay-card="holder_name">
                        </div>
                        <div class="col-3">
                            <input class="form-control" value="<?php echo $row['telefono']; ?>" type="text" name="phone_number"
                                placeholder="Teléfono" autocomplete="off">
                        </div>
                        <div class="col-3">
                            <input class="form-control" value="<?php echo $row['email']; ?>" type="email" name="email"
                                placeholder="Correo electrónico" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <label>Número de tarjeta</label>
                            <input class="form-control" value="4111111111111111" type="text" autocomplete="off"
                                data-openpay-card="card_number">
                        </div>
                        <div class="col-4">
                            <label>Fecha de expiración</label>
                            <div class="row">
                                <div class="col">
                                    <input class="form-control" value="11" type="text" placeholder="Mes"
                                    data-openpay-card="expiration_month">
                                </div>
                                <div class="col">
                                    <input class="form-control" value="24" type="text" placeholder="Año"
                                    data-openpay-card="expiration_year">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <label>Código de seguridad</label>
                            <input class="form-control" value="513" type="text" placeholder="3 dígitos"
                                autocomplete="off" data-openpay-card="cvv2">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block" id="pay-button">Pagar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}else{
    header("location:../login.php?location=".urlencode($_SERVER['REQUEST_URI']));
}
?>