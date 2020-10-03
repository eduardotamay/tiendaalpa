<?php
       
    require_once("includes/conexion_db.php");

    class Carrito
    {
        private $cliente;
        private $sku;
        private $descripcion;
        private $unidad;
        private $cantidad;
        private $peso;
        private $precio;
        private $fecha_registro;
        private $subtotal_producto;

        public function __construct(){}

        public function Carrito($cliente,$sku,$descripcion,$unidad,$cantidad,$peso,$precio,$fecha_registro,$subtotal_producto)
        {
            $this->cliente      = $cliente;
            $this->sku          = $sku;
            $this->descripcion  = $descripcion;
            $this->unidad       = $unidad;
            $this->cantidad     = $cantidad;
            $this->peso         = $peso;
            $this->precio       = $precio;
            $this->fecha_registro = $fecha_registro;
            $this->subtotal_producto = $subtotal_producto;
        }

        //Accesadores
        public function getCliente()        {return $this->cliente;}
        public function getSku()            {return $this->sku;}
        public function getDescripcion()    {return $this->descripcion;}
        public function getUnidad()         {return $this->unidad;}
        public function getCantidad()       {return $this->cantidad;}
        public function getPeso()           {return $this->peso;}
        public function getPrecio()         {return $this->precio;}
        public function getFecha_Registro() {return $this->fecha_registro;}
        public function getSubtotal_Producto() {return $this->subtotal_producto;}

        //Mutantes
        public function setCliente($cliente)        {return $this->cliente;}
        public function setSku($sku)                {return $this->sku;}
        public function setDescripcion($descripcion){return $this->descripcion;}
        public function setUnidad($unidad)          {return $this->$unidad;}
        public function setCantidad($cantidad)      {return $this->cantidad;}
        public function setPeso($peso)              {return $this->peso;}
        public function setPrecio($precio)          {return $this->precio;}
        public function setFecha_Registro($fecha_registro){return $this->fecha_registro;}
        public function setSubtotal_Producto($subtotal_producto){ return $this->subtotal_producto;}


        public function insertar_carrito()
        {
            $objConexion = new Conexion();
            $sql = "INSERT INTO carrito (cliente,sku,descripcion,unidad,cantidad,peso,precio,fecha_registro,subtotal_producto)
            VALUES ('".$this->cliente."','".$this->sku."','".$this->descripcion."','".$this->unidad."',
                    '".$this->cantidad."','".$this->peso."','".$this->precio."','".$this->fecha_registro."','".$this->subtotal_producto."')";
            $resul = $objConexion->generarTransaccion($sql);
            return $resul;
        }

        public function verificar_producto_carrito($cliente,$sku)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM carrito WHERE cliente='".$cliente."' AND sku='".$sku."'";
            $resul = $objConexion->generarTransaccion($sql);
            $vector=mysqli_fetch_array($resul);
    		 if($vector>0){
      			return true;
    		}else{
    		    return false;
    		}
        }

        public function obtener_datos_producto_carrito($cliente,$sku)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM carrito WHERE cliente='".$cliente."' AND sku='".$sku."'";
            $resul = $objConexion->generarTransaccion($sql);
            return $resul;
        }

        public function actualizar_producto_existente($cliente,$sku,$cantidad,$peso,$precio,$existencia)
        {
            $objConexion = new Conexion();
            $sql = "UPDATE carrito SET cantidad='".$cantidad."',peso='".$peso."',precio='".$precio."',fecha_registro=now(),subtotal_producto='".($cantidad*$precio)."'
                    WHERE cliente='".$cliente."' AND sku='".$sku."'";
            $resul = $objConexion->generarTransaccion($sql);
            if ($resul) { //Actualizo stock de productos
                // $sql2 = "UPDATE productos SET existencia='".$existencia."' WHERE sku='".$sku."'";
                // $resul2 = $objConexion->generarTransaccion($sql2);
                return true;
            }else{
                return false;
            }
        }

        public function eliminar_producto_existente($cliente,$sku,$cantidad)
        {
            $objConexion = new Conexion();
            $sql = "UPDATE carrito SET cantidad=0,fecha_registro=now(),subtotal_producto=0
                    WHERE cliente='".$cliente."' AND sku='".$sku."'";
            $resul = $objConexion->generarTransaccion($sql);
            if ($resul) { //Actualizo stock de productos
                // $sql2 = "UPDATE productos SET existencia=existencia+'".$cantidad."' WHERE sku='".$sku."'";
                // $resul2 = $objConexion->generarTransaccion($sql2);
                //Elimino el de la tabla carrito si cantidad = 0
                $sql = "DELETE FROM carrito where cliente='".$cliente."' AND sku='".$sku."' and cantidad<=0";
                $resul = $objConexion->generarTransaccion($sql);
                return true;
            }else{
                return false;
            }
        }

        public function ver_producto_en_carrito($cliente)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM carrito WHERE cliente='".$cliente."' AND cantidad>0 AND estado_car=0";
            $resul = $objConexion->generarTransaccion($sql);
      		return $resul;
        }

        public function ver_producto_en_carrito_campo_limitado($cliente)
        {
            $objConexion = new Conexion();
            $sql = "SELECT cliente,sku,descripcion,cantidad,precio FROM carrito WHERE cliente='".$cliente."' AND cantidad>0";
            $resul = $objConexion->generarTransaccion($sql);
      		return $resul;
        }
    
        // Cuando inicie sesion el usuario - Que se actualice la tabla Carrito
        public function actualizar_id_cliente($cliente,$id_temporal)
        {
            $objConexion = new Conexion();
            $sql = "UPDATE carrito SET cliente='".$cliente."' WHERE cliente='".$id_temporal."'";
            $resul = $objConexion->generarTransaccion($sql);
      		return $resul;
        }

        // Cuando cierre sesion el usuario - Que se actualice la tabla Carrito
        public function actualizar_id_cliente_cerrar($cliente,$id_temporal)
        {
            $objConexion = new Conexion();
            $sql = "UPDATE carrito SET cliente='".$id_temporal."' WHERE cliente='".$cliente."'";
            $resul = $objConexion->generarTransaccion($sql);
      		return $resul;
        }

        public function actualizarEstadoCarrito($cliente)
        {
            $objConexion = new Conexion();
            $sql = "UPDATE carrito SET estado_car=1 WHERE cliente='".$cliente."'";
            $resul = $objConexion->generarTransaccion($sql);
      		return $resul;
        }
    }
?>