<?php
class Conexion
{
  
  private $serv="localhost";
  private $usuario="root";
  private $clave="";
  private $bdatos="tienda_alpha";
  private $conex="";
  public function __construct(){}
  
  public function abrirConexion()
  { $this->conex=mysqli_connect($this->serv,$this->usuario,$this->clave,$this->bdatos) or die ('ERROR DE UBICACION DEL URL :'.mysqli_error());
    mysqli_select_db($this->conex,$this->bdatos);
    mysqli_set_charset($this->conex,'utf8');
	return $this->conex;  
  }
  public function cerrarConexion()
  {  
     mysqli_close($this->conex);
  }
  public function generarTransaccion($sql)
  { $this->abrirConexion();
    $resul=mysqli_query($this->conex,$sql) or die ('ERROR DE CONEXION/SENTENCIA :'.mysqli_error());  
    $this->cerrarConexion();
	return $resul;
  }

 }

//$con = new Conexion();
//if ($con->abrirConexion()) {
    //echo "Se conecto";
//}else{
    //echo "Revisar datos de conexion";
//}

?>