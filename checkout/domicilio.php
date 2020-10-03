<?php
session_start(); //Iniciar sesion o reanudar
include('../includes/validar_cp.php');
include('../includes/funciones.php');
include "../MDir_envio.php";
include "../MUsuario.php";
include "../MCarrito.php";
include "../MProducto.php";
    $objDireccion = new DireccionEnvio();
    $objUsuario = new Usuario();
    $objCarrito = new Carrito();
    $objProducto = new Producto();
    $id_cliente = $_SESSION['id_usuario'];
    $resultDire = $objDireccion->verMisDirecciones($id_cliente);
    $row_dire = mysqli_fetch_array($resultDire);
    $result = $objUsuario->buscar_Usuario($id_cliente);
    $row_user =mysqli_fetch_array($result);
    $id_cliente = $_SESSION['id_usuario'];
    $resultado = $objCarrito->ver_producto_en_carrito($id_cliente);
    $subtotal_pedido = 0;
    while ($row=mysqli_fetch_array($resultado)) {
        $busquedaSKU = $objProducto->buscar_producto_sku($row['sku']);
        $subtotal_pedido = $subtotal_pedido + ($row['cantidad']*$row['precio']);
    }
?>
<form id="domicilio" action="pago.php" method="post">
<input hidden type="text" name="subtotal" value="<?php echo number_format($subtotal_pedido,2);?>">
<input hidden type="text" name="iva" value="<?php echo $ivaPedido  = ($subtotal_pedido*0.16)?>">
<input hidden type="text" name="total" value="<?php echo number_format(($ivaPedido+$subtotal_pedido),2)?>">
    <div class="row" style="margin-top: 25px; text-align: left;"> 
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h5 style="text-align: center;">Datos de contacto</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1  mb-3"></div>
          <div class="col-md-5  mb-3">
            <label for="firstName">Enviar a*</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="" value="<?php echo $row_user['nombre_cliente']; ?>" required="">
          </div>
          <div class="col-md-5  mb-3">
            <label for="lastName">Teléfono</label>
            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="" value="<?php echo $row_user['telefono'];?>">
            <input type="text" hidden class="form-control" name="correo" id="correo" placeholder="" value="<?php echo $row_user['email'];?>">
          </div>
          <div class="col-md-1  mb-3"></div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <h5 style="text-align: center;">Dirección de envío</h5>
                <a style="text-align: center; color: #3483fa;font-size: 15px;" href="../clientes/misdirecciones.php?elegir_dirreccion=change"><p>Editar o elegir otro</p></a>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5  mb-3">
                <label for="address">Calle*</label>
                <input type="text" class="form-control" name="calle" id="calle" value="<?php echo $row_dire['calle']; ?>" placeholder="" required="">
            </div>
            <div class="col-md-2  mb-3">
                <label for="address">Num. Ext.*</label>
                <input type="text" class="form-control" name="exterior" id="exterior" placeholder="" value="<?php echo $row_dire['num_ext']; ?>" required="">
            </div>
            <div class="col-md-2  mb-3">
                <label for="address">Num. Int.</label>
                <input type="text" class="form-control" name="interior" id="interior" value="<?php echo $row_dire['num_int']; ?>" placeholder="" required="">
            </div>
            <div class="col-md-3 mb-3">
            <label for="zip">Código Posal</label>
            <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="" onblur="compruebaCP(this.value)">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="country">Colonia</label>
            <!-- <input type="text" class="form-control" name="colonia" id="colonia" placeholder="" required=""> -->
            <select class="custom-select d-block w-100" name="colonia" id="colonia" required=""> 
            </select>
          </div>
            <div class="col-md-4 mb-3">
            <label for="country">Ciudad / Municipio</label>
            <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="" required="">
            <!-- <select class="custom-select d-block w-100" name="ciudad" id="ciudad" required="">
              <option value="">Selecciona...</option>
            </select> -->
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">Estado</label>
            <input type="text" class="form-control" name="estado" id="estado" placeholder="" required="">
            <!-- <select class="custom-select d-block w-100" name="estado" id="estado" required="">
              <option value="">Selecciona...</option>
            </select> -->
          </div>  
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <h5 style="text-align: center;">Opción de envío</h5>
                <hr>
            </div>
        </div>
        <div class="row" style=" padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="dhl" required="">
        </div>
        <div class="col-md-2 my-auto">
           <img src="../img/dhl.svg" style="width: 80%;">
        </div>
        <div class="col-md-6 my-auto direccion-envio">
                <span style="font-weight:bolder;">
                    Entrega aprox: 
                </span><br>
                Lunes 1 de julio - Jueves 4 de julio
        </div>
            <div class="col-md-3 my-auto" style="text-align:center;">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <br>$140.00
        </div>
    </div>
        <hr>
        <div class="row" style=" padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="ivoy"  required="">
        </div>
        <div class="col-md-2 my-auto">
           <img src="../img/ivoy.png" style="width: 80%;">
        </div>
        <div class="col-md-6 my-auto direccion-envio">
                <span style="font-weight:bolder;">
                    Entrega aprox: 
                </span><br>
                <?php entrega_aprox(); ?>  
                <!-- En 3:00 hrs -->
        </div>
            <div class="col-md-3 my-auto" style="text-align:center;">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <br>$199.00
        </div>
    </div>
        <hr>
        <div class="row" style=" padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="alpa" required="">
        </div>
        <div class="col-md-2 my-auto">
           <img src="https://www.tiendaalpa.com/img/logo.png" style="width: 80%;">
        </div>
        <div class="col-md-6 my-auto direccion-envio">
                <span style="font-weight:bolder;">
                    Entrega aprox: 
                </span><br>
                <?php
                    entrega_aprox();
                ?>
        </div>
            <div class="col-md-3 my-auto" style="text-align:center;">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <br>$69.00
        </div>
    </div>
        <hr>
    </div>
  </div>
    <button value="DOMICILIO" name="seleccion_envio" class="btn btn-primary btn-sm" type="submit" style="margin-top: 25px;">
        Confirmar envío
    </button>
</form>
<script>
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
                $("#ciudad").val(response.response.municipio).prop("readonly","readonly")
                $("#estado").val(response.response.estado).prop("readonly","readonly");
                $("#codigo_postal").removeClass("cp_error");
                cp_anterior = response.response.cp;
            },
            error:function(response){
                if (response.statusText="Error") {
                    $("#codigo_postal").addClass("cp_error");
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
 }
</script>