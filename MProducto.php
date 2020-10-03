<?php

require_once("includes/conexion_db.php");


class Producto 
{
    private $sku;
    private $descripcion;
    private $clavegates;
    private $descripciongates;
    private $peso;
    private $alto;
    private $ancho;
    private $angulo;
    private $existencia;
    private $unidad;
    private $color;
    private $diametro;
    private $precio1;
    private $precio2;
    private $precio3;
    private $precio4;
    private $linea;
    private $pal_clave;
    private $marca;
    private $tiemposurtido;
    private $fechaalta;
    private $estado;
    private $destacado;


    public function __construct(){}

    public function Producto($sku,$descripcion,$clavegates,$descripciongates,$peso,$alto,$ancho,
    $angulo,$existencia,$unidad,$color,$diametro,$precio1,$precio2,$precio3,$precio4,
    $linea,$pal_clave,$marca,$tiemposurtido,$fechaalta,$estado,$destacado)
    {
        $this->sku = $sku;
        $this->descripcion = $descripcion;
        $this->clavegates = $clavegates;
        $this->descripciongates = $descripciongates;
        $this->peso = $peso;
        $this->alto = $alto;
        $this->ancho = $ancho;
        $this->angulo = $angulo;
        $this->existencia = $existencia;
        $this->unidad = $unidad;
        $this->color = $color;
        $this->diametro = $diametro;
        $this->precio1 = $precio1;
        $this->precio2 = $precio2;
        $this->precio3 = $precio3;
        $this->precio4 = $precio4;
        $this->linea = $linea;
        $this->pal_clave = $pal_clave;
        $this->marca = $marca;
        $this->tiemposurtido = $tiemposurtido;
        $this->fechaalta = $fechaalta;
        $this->estado = $estado;
        $this->destacado= $destacado;
    }

    //ACCESADORES
    public function getSku()                {return $this->sku;}
    public function getDescripcion()        {return $this->descripcion;}
    public function getClavegates()         {return $this->clavegates;}
    public function getDescripciongates()   {return $this->descripciongates;}
    public function getPeso()               {return $this->peso;}
    public function getAlto()               {return $this->alto;}
    public function getAncho()              {return $this->ancho;}
    public function getAngulo()             {return $this->angulo;}
    public function getExistencia()         {return $this->existencia;}
    public function getUnidad()             {return $this->unidad;}
    public function getColor()              {return $this->color;}
    public function getDiametro()           {return $this->diametro;}
    public function getPrecio1()            {return $this->getPrecio1;}
    public function getPrecio2()            {return $this->getPrecio2;}
    public function getPrecio3()            {return $this->getPrecio3;}
    public function getPrecio4()            {return $this->getPrecio4;}
    public function getLinea()              {return $this->linea;}
    public function getPal_clave()          {return $this->pal_clave;}
    public function getMarca()              {return $this->marca;}
    public function getTiemposurtido()      {return $this->tiemposurtido;}
    public function getFechaalta()          {return $this->fechaalta;}
    public function getEstado()             {return $this->estado;}
    public function getDestacado()          {return $this->destacado;}


     //MUTANTES
     public function setSku($sku)                              {$this->sku=$sku;}
     public function setDescripcion($descripcion)              {$this->descripcion=$descripcion;}
     public function setClavegates($clavegates)                {$this->clavegates=$clavegates;}
     public function setDescripciongates($descripciongates)    {$this->descripciongates=$descripciongates;}
     public function setPeso($peso)                            {$this->peso=$peso;}
     public function setAlto($alto)                            {$this->alto=$alto;}
     public function setAncho($ancho)                          {$this->ancho=$ancho;}
     public function setAngulo($angulo)                        {$this->angulo=$angulo;}
     public function setExistencia($existencia)                {$this->existencia=$existencia;}
     public function setUnidad($unidad)                        {$this->unidad=$unidad;}
     public function setColor($color)                          {$this->color=$color;}
     public function setDiametro($diametro)                    {$this->diametro=$diametro;}
     public function setPrecio1($precio1)                      {$this->precio1=$precio1;}
     public function setPrecio2($precio2)                      {$this->precio2=$precio2;}
     public function setPrecio3($precio3)                      {$this->precio3=$precio3;}
     public function setPrecio4($precio4)                      {$this->precio4=$precio4;}
     public function setLinea($linea)                          {$this->linea=$linea;}
     public function setPal_clave($pal_clave)                  {$this->pal_clave=$pal_clave;}
     public function setMarca($marca)                          {$this->marca=$marca;}
     public function setTiemposurtido($tiemposurtido)          {$this->tiemposurtido=$tiemposurtido;}
     public function setFechaalta($fechaalta)                  {$this->fechaalta=$fechaalta;}
     public function setEstado($estado)                        {$this->estado=$estado;}
     public function setDestacado($destacado)                  {$this->destacado=$destacado;}


     public function listarProductoDestacado()
     {
        $objConexion = new Conexion();
        $sql = "SELECT * FROM productos where (destacado=1 and estado='A')";
        $vector = $objConexion->generarTransaccion($sql);
        return $vector;
     }

     public function buscar_Producto($sku,$cantidad)
     {
        $objConexion = new Conexion();
        $sql = "SELECT * FROM productos WHERE sku='".$sku."' AND existencia >= '".$cantidad."'";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
     }

      public function buscar_producto_sku($sku)
      {
         $objConexion = new Conexion();
         $sql = "SELECT * FROM productos WHERE sku='".$sku."' ";
         $resul = $objConexion->generarTransaccion($sql);
         $vector=mysqli_fetch_array($resul);
    		 if($vector>0){
      			return $vector;
    		}else{
    		    return false;
    		}
      }


}



?>