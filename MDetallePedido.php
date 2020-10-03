<?php

require_once("includes/conexion_db.php");

    class DetallePedido
    {
        private $id_pedido;
        private $sku;
        private $descripcion;
        private $precioU;
        private $cantidad;
        private $importe;
        private $iva;

        public function __construct(){}

        public function DetallePedido($id_pedido,$sku,$descripcion,$precioU,$cantidad,$importe,$iva)
        {
            $this->id_pedido    = $id_pedido;
            $this->sku          = $sku;
            $this->descripcion  = $descripcion;
            $this->precioU      = $precioU;
            $this->cantidad     = $cantidad;
            $this->importe      = $importe;
            $this->iva          = $iva;
        }

        // ACCESADORES
        public function getIdPedido()   { return $this->id_pedido; }
        public function getSku()        { return $this->sku;}
        public function getDescripcion(){ return $this->descripcion;}
        public function getPrecioU()    { return $this->precioU;}
        public function getCantidad()   { return $this->cantidad;}
        public function getImporte()    { return $this->importe;}
        public function getIva()        { return $this->iva;}

        // MUTANTES
        public function setIdPedido( $id_pedido )       { return $this->id_pedido;}
        public function setSku( $sku )                  { return $this->sku; }
        public function setDescripcion( $descripcion )  { return $this->descripcion; }
        public function setPrecioU( $precioU )          { return $this->precioU; }
        public function setCantiddad( $cantidad )       { return $this->cantidad; }
        public function setImporte( $importe )          { return $this->importe; }
        public function setIva( $iva )                  { return $this->iva; }

        public function insertarDetallePedido(){
            $objConexion = new Conexion();
            $sql = "INSERT INTO detallepedidos (id_pedido,sku,descripcion,precio_unitario,cantidad,importe,iva) 
                    VALUES ('".$this->id_pedido."','".$this->sku."','".$this->descripcion."','".$this->precioU."','".$this->cantidad."','".$this->importe."','".$this->iva."')";
            $result = $objConexion->generarTransaccion($sql);
            var_dump($result);
            return $result;
        }

    }
?>