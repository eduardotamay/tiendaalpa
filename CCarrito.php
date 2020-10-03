<?php
    include_once('MCarrito.php');
    include_once('MUsuario.php');
    include_once('MProducto.php');

    if (isset($_POST['insertCarrito']) && $_POST['insertCarrito'] == 'INSERTCARRITO') {

        $id_cliente = isset($_POST['id_user']) ? $_POST['id_user'] : null;
        $id_temporal = isset($_POST['id_temporal']) ? $_POST['id_temporal'] : null;
        $cantidades = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $sku = isset($_POST['sku']) ? $_POST['sku'] : null;

        //Hago una instancia a las instancias
        $objCarrito = new Carrito();
        $objUsuario = new Usuario();

        if ($id_cliente!='') {
            $result = $objUsuario->buscar_Usuario($id_cliente);
            $row =mysqli_fetch_array($result);
            $id_cliente = intval($row['id_usuario']);
        }else{
            $id_cliente = $id_temporal;
        }
        // Segundo consulto si hay producto con ese #id y si hay en stock
        $objProducto = new Producto();
        $resultP = $objProducto->buscar_Producto($sku,$cantidades);
        $rowp = mysqli_fetch_array($resultP);
        if($rowp>0){
            //Convertir el id_temporal a Timestamp
            $fecha_actual = new DateTime();
            $fecha_actual->getTimestamp();
            $fecha  = date_format($fecha_actual, 'Y-m-d H:i:s');
            $sku = $rowp['sku'];
            $descripcion = $rowp['descripcion'];
            $unidad = $rowp['unidad'];
            $cantidad = intval($cantidades);
            $peso = intval($rowp['peso']);
            $precio = floatval($rowp['precio1']);
            $existencia = $rowp['existencia'];
            $existencia = $existencia-$cantidad;
            $subtotal_producto = $cantidad*$precio;

            //Antes de insertar producto al carrito verificamos para evitar duplicidad
            if ($objCarrito->verificar_producto_carrito($id_cliente,$sku)) {
                //Si existe producto en carrito, update (cantidad,peso,precio,fecha_registro)
                if ($objCarrito->actualizar_producto_existente($id_cliente,$sku,$cantidad,$peso,$precio,$existencia)) {
                    header('HTTP/1.1 200 Ok1');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'OK1')));
                }else{
                    header('HTTP/1.1 401 Error1');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'ERROR1')));
                }
            }else{
                //Insertamos producto al carrito
                $objCarrito->Carrito($id_cliente,$sku,$descripcion,$unidad,$cantidad,$peso,$precio,$fecha,$subtotal_producto);
                $result = $objCarrito->insertar_carrito();
                if ($result) {
                    header('HTTP/1.1 200 Ok2');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'OK2')));
                }else{
                    header('HTTP/1.1 401 Error2');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'ERROR2')));
                }
            }
        }else{
            header('HTTP/1.1 401 Error3');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR3')));
        }
    }else if (isset($_POST['deleteCarr']) && $_POST['deleteCarr'] == 'DELETECAR') {
        
        $id_cliente = isset($_POST['id_user']) ? $_POST['id_user'] : null;
        $id_temporal = isset($_POST['id_temporal']) ? $_POST['id_temporal'] : null;
        $sku = isset($_POST['skuProd']) ? $_POST['skuProd'] : null;

        //Hago una instancia a las instancias
        $objCarrito = new Carrito();
        $objUsuario = new Usuario();

        if ($id_cliente!='') { //Si el usuario inició sesión [Obtengo su ID tabla Usuarios]
            $result = $objUsuario->buscar_Usuario($id_cliente);
            $row =mysqli_fetch_array($result);
            $id_cliente = intval($row['id_usuario']);
        }else{
            $id_cliente = $id_temporal;
        }

        // $fecha = date("Y-m-d H:i:s",$id_temporal);

        //Antes de eliminar producto al carrito verificamos para si existe
        if ($objCarrito->verificar_producto_carrito($id_cliente,$sku)) {
            //Obtengo la cantidad que tengo en el carrito para pasarselo a la tabla productos
            $resultP = $objCarrito->obtener_datos_producto_carrito($id_cliente,$sku);
            $rowp = mysqli_fetch_array($resultP);
            $cantidad = intval($rowp['cantidad']);

            //Si existe producto en carrito, update (delete)
            if ($objCarrito->eliminar_producto_existente($id_cliente,$sku,$cantidad)) {
                header('HTTP/1.1 200 Ok1');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'OK1'))); //Se eliminó el producto
            }else{
                header('HTTP/1.1 401 Error1');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR1'))); //No se eliminó el producto
            }
        }else{
            header('HTTP/1.1 401 Error2');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR2'))); //No existe ese producto
        }
    }else if (isset($_GET['verCarrito']) && $_GET['verCarrito'] == 'VERCARRITO') {
        
        $id_cliente = isset($_GET['id_user']) ? $_GET['id_user'] : null;
        $id_temporal = isset($_GET['id_temporal']) ? $_GET['id_temporal'] : null;

        $objCarrito = new Carrito();
        $objUsuario = new Usuario();

        if ($id_cliente!='') { //Si el usuario inició sesión [Obtengo su ID tabla Usuarios]
            $result = $objUsuario->buscar_Usuario($id_cliente);
            $row =mysqli_fetch_array($result);
            $id_cliente = intval($row['id_usuario']);
        }else{
            $id_cliente = $id_temporal;
        }
        $contadorProd = 0;
        $resultP = $objCarrito->ver_producto_en_carrito($id_cliente);
        while ($row=mysqli_fetch_array($resultP)) {
            $contadorProd = $row['cantidad']+$contadorProd;
        }
        header('HTTP/1.1 200 Ok1');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('cantidadproducto' => $contadorProd)));

    }else{ //No llegaron los datos
        header('HTTP/1.1 401 Error4');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR4')));
    }

?>