<?php

    require_once("includes/conexion_db.php");

    class Factura
    {
        private $num_factura;
        private $id_cliente;
        private $fecha;
        
        public function __construct(){}

        public function Factura($num_factura,$id_cliente,$fecha)
        {
            $this->num_factura = $num_factura;
            $this->id_cliente = $id_cliente;
            $this->fecha = $fecha;
        }

        //Accesadores
        public function getNumFactura(){return $this->num_factura;}
        public function getIdCliente(){return $this->id_cliente;}
        public function getFecha(){return $this->fecha;}

        //Mutantes
        public function setNumFactura($num_factura){ return $this->num_factura;}
        public function setIdCliente($id_cliente){ return $this->id_cliente;}
        public function setFecha($fecha){ return $this->fecha;}

        // Insertar datos factura
        public function registrar_factura()
        {
            $objConexion = new Conexion();
            $sql = "INSERT INTO factura (num_factura,id_cliente,fecha) 
            VALUES ('".$this->num_factura."','".$this->id_cliente."','".$this->fecha."')";
            $result = $objConexion->generarTransaccion($sql);
            return $result;
        }
    }


?>