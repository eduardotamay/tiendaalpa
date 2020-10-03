<?php

require_once("includes/conexion_db.php");

    class Pedido
    {
        // private $id_pedido;
        // private $status;
        private $id_usuario;
        private $a_nombre_de;
        private $requiere_factura;
        private $num_partidas;
        private $calle;
        private $num_ext;
        private $num_int;
        private $codigo_postal;
        private $colonia;
        private $municipio;
        private $estado;
        private $pais;
        private $forma_envio;
        private $forma_pago;
        private $factura;
        private $fecha;
        private $subtotal;
        private $iva;
        private $total;
        private $costo_envio;
        private $costo_sobrepeso;
        private $fecha_entrega;
        private $fecha_estimada; 


        public function __construct(){}

        public function Pedido($id_usuario,$a_nombre_de,$requiere_factura,$num_partidas,$calle,$num_ext,$num_int,
                            $codigo_postal,$colonia,$municipio,$estado,$pais,$forma_envio,$forma_pago,$factura,$fecha,$subtotal,
                            $iva,$total,$costo_envio,$costo_sobrepeso,$fecha_entrega,$fecha_estimada)
        {
            // $this->id_pedido         =$id_pedido;
            // $this->status            =$status;
            $this->id_usuario        =$id_usuario;
            $this->a_nombre_de       =$a_nombre_de;
            $this->requiere_factura  =$requiere_factura;
            $this->num_partidas      =$num_partidas;
            $this->calle             =$calle;
            $this->num_ext           =$num_ext;
            $this->num_int           =$num_int;
            $this->codigo_postal     =$codigo_postal;
            $this->colonia           =$colonia;
            $this->municipio         =$municipio;
            $this->estado            =$estado;
            $this->pais              =$pais;
            $this->forma_envio       =$forma_envio;
            $this->forma_pago        =$forma_pago;
            $this->factura           =$factura;
            $this->fecha             =$fecha;
            $this->subtotal          =$subtotal;
            $this->iva               =$iva;
            $this->total             =$total;
            $this->costo_envio       =$costo_envio;
            $this->costo_sobrepeso   =$costo_sobrepeso;
            $this->fecha_entrega     =$fecha_entrega;
            $this->fecha_estimada    =$fecha_estimada;   
        }

        //Accesadores
        // public function getIdPedido()       { return $this->id_pedido;}
        // public function getStatus()         { return $this->status;}
        public function getIdUsuario()      { return $this->id_usuario;}
        public function getNombreDe()       { return $this->a_nombre_de;}
        public function getRequiereFactura(){ return $this->requiere_factura;}
        public function getNumPartidas()    { return $this->num_partidas;}
        public function getCalle()          { return $this->calle;}
        public function getNumExt()         { return $this->num_ext;}
        public function getNumInt()         { return $this->num_int;}
        public function getCodigoPostal()   { return $this->codigo_postal;}
        public function getColonia()        { return $this->colonia;}
        public function getMunicipio()      { return $this->municipio;}
        public function getEstado()         { return $this->estado;}
        public function getPais()           { return $this->pais;}       
        public function getFormaEnvio()     { return $this->forma_envio;}
        public function getFormaPago()      { return $this->forma_pago;}
        public function getFactura()        { return $this->factura;}
        public function getFecha()          { return $this->fecha;}
        public function getSubtotal()       { return $this->subtotal;}
        public function getIva()            { return $this->iva;}
        public function getTotal()          { return $this->total;}
        public function getCostoEnvio()     { return $this->costo_envio;}
        public function getCostoSobrepeso() { return $this->costo_sobrepeso;}
        public function getFechaEntrega()   { return $this->fecha_entrega;}
        public function getFechaEstimada()  { return $this->fecha_estimada;}


        //Mutantes
        // public function setIdPedido         ( $id_pedido )      { return $this->id_pedido;}
        // public function setStatus           ( $status )         { return $this->status;}
        public function setIdUsuario        ( $id_usuario )     { return $this->id_usuario;}
        public function setNombreDe         ( $a_nombre_de )    { return $this->a_nombre_de;}
        public function setRequiereFactura  ( $requiere_factura){ return $this->requiere_factura;}
        public function setNumPartidas      ( $num_partidas )   { return $this->num_partidas;}
        public function setCalle            ( $calle )          { return $this->calle;}
        public function setNumExt           ( $num_ext )        { return $this->num_ext;}
        public function setNumInt           ( $num_int )        { return $this->num_int;}
        public function setCodigoPostal     ( $codigo_postal )  { return $this->codigo_postal;}
        public function setColonia          ( $colonia )        { return $this->colonia;}
        public function setMunicipio        ( $municipio )      { return $this->municipio;}
        public function setEstado           ( $estado )         { return $this->estado;}
        public function setPais             ( $pais )           { return $this->pais;}       
        public function setFormaEnvio       ( $forma_envio )    { return $this->forma_envio;}
        public function setFormaPago        ( $forma_pago )     { return $this->forma_pago;}
        public function setFactura          ( $factura )        { return $this->factura;}
        public function setFecha            ( $fecha )          { return $this->fecha;}
        public function setSubtotal         ( $subtotal )       { return $this->subtotal;}
        public function setIva              ( $iva )            { return $this->iva;}
        public function setTotal            ( $total )          { return $this->total;}
        public function setCostoEnvio       ( $costo_envio )    { return $this->costo_envio;}
        public function setCostoSobrepeso   ( $costo_sobrepeso ){ return $this->costo_sobrepeso;}
        public function setFechaEntrega     ( $fecha_entrega )  { return $this->fecha_entrega;}
        public function setFechaEstimada    ( $fecha_estimada ) { return $this->fecha_estimada;}

        public function insertar_pedido()
        {
            $objConexion = new Conexion();
            $slq = "INSERT INTO pedidos (id_usuario,a_nombre_de,requiere_factura,num_partidas,calle,num_ext,num_int,
            codigo_postal,colonia,municipio,estado,pais,forma_envio,forma_pago,factura,fecha,subtotal,
            iva,total,costo_envio,costo_sobrepeso,fecha_entrega,fecha_estimada) 
            VALUES ('".$this->id_usuario."','".$this->a_nombre_de."','".$this->requiere_factura."','".$this->num_partidas."','".$this->calle."','".$this->num_ext."','".$this->num_int."',
            '".$this->codigo_postal."','".$this->colonia."','".$this->municipio."','".$this->estado."','".$this->pais."','".$this->forma_envio."',
            '".$this->forma_pago."','".$this->factura."','".$this->fecha."','".$this->subtotal."','".$this->iva."','".$this->total."',
            '".$this->costo_envio."','".$this->costo_sobrepeso."','".$this->fecha_entrega."','".$this->fecha_estimada."')";
            $result = $objConexion->generarTransaccion($slq);
            if ($result) {
                $sql_ultimo = "SELECT MAX(id_pedido) AS id_pedido FROM pedidos";
                $resul = $objConexion->generarTransaccion($sql_ultimo);
                return $resul;
            }
        }

        public function buscar_pedido_cliente($id_usuario,$id_pedido)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM pedidos WHERE id_usuario=$id_usuario and id_pedido=$id_pedido";
            $result = $objConexion->generarTransaccion($sql);
            return $result;
        }

        public function ver_detalle_pedido($id_pedido)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM detallepedidos WHERE id_pedido=$id_pedido";
            $result = $objConexion->generarTransaccion($sql);
            return $result;
        }
        
    }
?>