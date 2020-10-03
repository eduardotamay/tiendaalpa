<?php
session_start(); //Iniciar sesion o reanudar
include('dhl.php');
include "../MDir_envio.php";
    include "../MUsuario.php";
    include "../MCarrito.php";
    include "../MProducto.php";
    $objDireccion = new DireccionEnvio();
    $objUsuario = new Usuario();
    $objCarrito = new Carrito();
    $objProducto = new Producto();
    $id_cliente = $_SESSION['id_usuario'];
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
<form action="pago.php" method="post">
    <input hidden type="text" name="subtotal" value="<?php echo number_format($subtotal_pedido,2);?>">
    <input hidden type="text" name="iva" value="<?php echo $ivaPedido  = ($subtotal_pedido*0.16)?>">
    <input hidden type="text" name="total" value="<?php echo number_format(($ivaPedido+$subtotal_pedido),2)?>">
    <input hidden type="text" name="id_cliente" value="<?php echo $id_cliente ?>">
    <div class="row" style="margin-top: 25px; text-align: left;">     
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h5 style="text-align: center;">Datos de contacto</h5>
                <hr>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6  mb-3">
            <label for="firstName">Enviar a*</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="" value="" required="">
          </div>
          <div class="col-md-6  mb-3">
            <label for="lastName">Ubicación*</label>
            <input type="text" class="form-control" name="ubicacion" id="telefono" placeholder="" value="" onblur="buscar_local(this.value)">
          </div>
        </div>
   </div>         
  </div>
    <div class="row">
            <div class="col-md-12">
                <h5 style="text-align: center;">Sucursales Ocurre DHL Disponibles</h5>
                <hr>
            </div>
        </div>
    <div id="sucursal1" class="row invisible" style="background-color: #f6f6f6; border-radius: 5px; padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="sucursal" required="">
        </div>
        <input id="nom_envio1" hidden="true" type="text" name="nombre_tienda_envio1">
        <input id="cp_envio1" hidden="true" type="text" name="cp_envio">    
        <div id="nombre_tienda1" class="col-md-2 my-auto" style="font-weight: bolder;"></div>
        <div class="col-md-4 my-auto direccion-envio">
                <span style="font-weight:bolder;">Calle:</span>
                <input id="calle_envio1" hidden="true" type="text" name="calle_envio">  
                <span id="calle1"></span>
                <br>
                <span style="font-weight:bolder;">Ciudad: </span>
                <input id="ciudad_envio1" hidden="true" type="text" name="ciudad_envio">     
                <span id="ciudad1"></span> 
                <span style="font-weight:bolder;">Estado: </span>
                <input id="edo_envio1" hidden="true" type="text" name="estado_envio">   
                <span id="estado1"></span><br>
                <a class="btn btn-secondary btn-sm" style="font-size:0.5rem; padding:4px;" href="#" role="button">
                    Como llegar
                </a>
        </div>
        <div class="col-md-3 my-auto">
            <span style="font-weight:bolder;">
                Entrega aprox:<br>
            </span>
            Lunes 1 de julio - Jueves 4 de julio
        </div>
        <div class="col-md-2 my-auto">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <input hidden="true" type="text" name="costo_envio" value="169.00">
            <br>$169.00
        </div>
    </div>
    <div id="sucursal2" class="row invisible" style="background-color: #f6f6f6; border-radius: 5px; padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="sucursal" required="">
        </div>
        <input id="nom_envio2" hidden="true" type="text" name="nombre_tienda_envio2">
        <input id="cp_envio2" hidden="true" type="text" name="cp_envio">
        <div id="nombre_tienda2" class="col-md-2 my-auto" style="font-weight: bolder;"></div>
        <div class="col-md-4 my-auto direccion-envio">
                <span style="font-weight:bolder;">Calle:</span>
                <input id="calle_envio2" hidden="true" type="text" name="calle_envio">
                <span id="calle2"></span>
                <br>
                <span style="font-weight:bolder;">Ciudad: </span> 
                <input id="ciudad_envio2" hidden="true" type="text" name="ciudad_envio"> 
                <span id="ciudad2"></span> 
                <span style="font-weight:bolder;">Estado: </span>
                <input id="edo_envio2" hidden="true" type="text" name="estado_envio">
                <span id="estado2"></span><br>
                <a class="btn btn-secondary btn-sm" style="font-size:0.5rem; padding:4px;" href="#" role="button">
                    Como llegar
                </a>
        </div>
        <div class="col-md-3 my-auto">
            <span style="font-weight:bolder;">
                Entrega aprox:<br>
            </span>
            Lunes 1 de julio - Jueves 4 de julio
        </div>
        <div class="col-md-2 my-auto">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <input hidden="true" type="text" name="costo_envio" value="169.00">
            <br>$169.00
        </div>
    </div>
    <div id="sucursal3" class="row invisible" style="background-color: #f6f6f6; border-radius: 5px; padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="sucursal" required="">
        </div>
        <input id="nom_envio3" hidden="true" type="text" name="nombre_tienda_envio3">
        <input id="cp_envio3" hidden="true" type="text" name="cp_envio">
        <div id="nombre_tienda3" class="col-md-2 my-auto" style="font-weight: bolder;"></div>
        <div class="col-md-4 my-auto direccion-envio">
                <span style="font-weight:bolder;">Calle:</span>
                <input id="calle_envio3" hidden="true" type="text" name="calle_envio">
                <span id="calle3"></span>
                <br>
                <span style="font-weight:bolder;">Ciudad: </span>
                <input id="ciudad_envio3" hidden="true" type="text" name="ciudad_envio"> 
                <span id="ciudad3"></span> 
                <span style="font-weight:bolder;">Estado: </span>
                <input id="edo_envio3" hidden="true" type="text" name="estado_envio">
                <span id="estado3"></span><br>
                <a class="btn btn-secondary btn-sm" style="font-size:0.5rem; padding:4px;" href="#" role="button">
                    Como llegar
                </a>
        </div>
        <div class="col-md-3 my-auto">
            <span style="font-weight:bolder;">
                Entrega aprox:<br>
            </span>
            Lunes 1 de julio - Jueves 4 de julio
        </div>
        <div class="col-md-2 my-auto">
            <span style="font-weight:bolder;">
                Costo de envio
            </span>
            <input hidden="true" type="text" name="costo_envio" value="169.00">
            <br>$169.00
        </div>
    </div>
    <button value="PAQUETERIA" name="seleccion_envio" class="btn btn-primary btn-sm" type="submit" style="margin-top: 25px;">
        Confirmar envío
    </button>
</form>
<script>
    function buscar_local(direcc) { 
        var direccion = direcc;
        if (direccion.legth!=0) {
            $.ajax({
                type: "POST",
                url: "dhl.php",
                data: {buscar_local:'BLOCAL',
                        direccion},
                cache: false,
                success: function (response) {
                    var locales  = response;
                    for (let i = 1; i <=3; i++) {
                        $("#nom_envio").val(locales[i].nombre_tienda);
                        $("#nombre_tienda"+i).html(locales[i].nombre_tienda);
                        $("#calle_envio"+i).val(locales[i].direccion);
                        $("#calle"+i).html(locales[i].direccion);
                        $("#ciudad_envio"+i).val(locales[i].ciudad);
                        $("#ciudad"+i).html(locales[i].ciudad);
                        $("#edo_envio"+i).val(locales[i].nombre_tienda);
                        $("#estado"+i).html(locales[i].estado);
                        $("#cp_envio"+i).val(locales[i].codigo_postal);
                        $("#sucursal"+i).removeClass("invisible");
                    }
                    $("#telefono").removeClass("tel_error");
                },
                error:function(response){
                    $("#telefono").addClass("tel_error");
                    $("#telefono").val("");
                }
            });
        }
     }
</script>