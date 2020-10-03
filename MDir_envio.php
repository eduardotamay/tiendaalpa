<?php

require_once("includes/conexion_db.php");

class DireccionEnvio
{
    
    private $id_direccion;
    private $num_cliente;
    private $calle;
    private $num_ext;
    private $num_int;
    private $colonia;
    private $cp;
    private $ciudad;
    private $municipio;
    private $estado;
    private $pais;
    private $entre_calles;
    private $referencia;


    public function __construct(){}
    
    public function DireccionEnvio($id_direccion,$num_cliente,$calle,$num_ext,$num_int,$colonia,$cp,$ciudad,$municipio,$estado,$pais,$entre_calles,$referencia)
    {
        $this->id_direccion = $id_direccion;
        $this->num_cliente  = $num_cliente;
        $this->calle        = $calle;
        $this->num_ext      = $num_ext;
        $this->num_int      = $num_int;
        $this->colonia      = $colonia;
        $this->cp           = $cp;
        $this->ciudad       = $ciudad;
        $this->municipio    = $municipio;
        $this->estado       = $estado;
        $this->pais         = $pais;
        $this->entre_calles = $entre_calles;
        $this->referencia   = $referencia;
    }

    // Accesadores
    public function getIdDireccion()    {return $this->id_direccion;}
    public function getNumCliente()     {return $this->num_cliente;}
    public function getCalle()          {return $this->calle;}
    public function getNumExt()         {return $this->num_ext;}
    public function getNumInt()         {return $this->num_int;}
    public function getColonia()        {return $this->colonia;}
    public function getCp()             {return $this->cp;}
    public function getCiudad()         {return $this->ciudad;}
    public function getMunicipio()      {return $this->municipio;}
    public function getEstado()         {return $this->estado;}
    public function getPais()           {return $this->pais;}
    public function getEntreCalles()    {return $this->entre_calles;}
    public function getReferencia()     {return $this->referencia;}

    // Mutantes
    public function setIdDireccion($id_direccion)   { return $this->id_direccion;}
    public function setNumCliente($num_cliente)     { return $this->num_cliente;}
    public function setCalle($calle)                { return $this->calle;}
    public function setNumExt($num_ext)             { return $this->num_ext;}
    public function setNumInt($num_int)             { return $this->num_int;}
    public function setColonia($colonia)            { return $this->colonia;}
    public function setCP($cp)                      { return $this->cp;}
    public function setCiudad($ciudad)              { return $this->ciudad;}
    public function setMunicipio($municipio)        { return $this->municipio;}
    public function setEstado($estado)              { return $this->estado;}
    public function setPais($pais)                  { return $this->pais;}
    public function setEntreCalles($entre_calles)   { return $this->entre_calles;}
    public function setReferencia($referencia)      { return $this->referencia;}


    public function insertarDireccionEnvio()
    {
        $status=1;
        $objConexion = new Conexion();
        $sql = "INSERT INTO direcciones_envio (id_direccion,num_cliente,
        calle,num_ext,num_int,colonia,cp,ciudad,municipio,estado,pais,entre_calles,referencia,statusdir) 
        VALUES ('".$this->id_direccion."','".$this->num_cliente."','".$this->calle."',
                '".$this->num_ext."','".$this->num_int."','".$this->colonia."','".$this->cp."',
                '".$this->ciudad."','".$this->municipio."','".$this->estado."','".$this->pais."','".$this->entre_calles."','".$this->referencia."','".$status."')";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function verMisDirecciones($num_cliente)
    {
        $objConexion = new Conexion();
        $sql = "SELECT * FROM direcciones_envio WHERE num_cliente='".$num_cliente."' AND selected=1";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function editarMiDirecciones($id_direccion,$num_cliente)
    {
        $objConexion = new Conexion();
        $sql = "SELECT * FROM direcciones_envio WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function listarMisDirecciones($num_cliente)
    {
        $objConexion = new Conexion();
        $sql = "SELECT * FROM direcciones_envio WHERE num_cliente='".$num_cliente."' AND statusdir=1";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function actualizarMisDirecciones($num_cliente,$id_direccion,$calle,$num_ext,$num_int,$colonia,$cp,$ciudad,$municipio,$estado,$pais,$entre_calles,$referencia)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET calle='".$calle."',num_ext='".$num_ext."',
        num_int='".$num_int."',colonia='".$colonia."',cp='".$cp."',ciudad='".$ciudad."',municipio='".$municipio."',
            estado='".$estado."',pais='".$pais."',entre_calles='".$entre_calles."',referencia='".$referencia."' WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        if ($resul) {
            return true;
        }else{
            return false;
        }
    }

    public function actualizar_dire_cliente($num_cliente,$id_direccion,$calle,$num_ext,$num_int,$colonia,$cp,$ciudad,$estado)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET calle='".$calle."',num_ext='".$num_ext."',num_int='".$num_int."',
        colonia='".$colonia."',cp='".$cp."',ciudad='".$ciudad."',estado='".$estado."'
        WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function actualizar_dire_cliente_sucursal_dhl($num_cliente,$id_direccion,$calle,$ciudad,$estado,$cp)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET calle='".$calle."',num_ext='',num_int='',
        colonia='',cp='".$cp."',ciudad='".$ciudad."',municipio='".$ciudad."',estado='".$estado."',entre_calles='',referencia=''
        WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function actualizar_dire_cliente_sucursal_alpa($num_cliente,$id_direccion,$calle,$colonia,$cp,$ciudad,$pais)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET calle='".$calle."',num_ext='',num_int='',
        colonia='".$colonia."',cp='".$cp."',ciudad='".$ciudad."',municipio='".$ciudad."',estado='',pais='".$pais."',entre_calles='',referencia=''
        WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        return $resul;
    }

    public function eliminarDireccion($num_cliente,$id_direccion)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET statusdir=0 
                WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        if ($resul) {
            return true;
        }else{
            return false;
        }
    }

    public function elegir_direccion($num_cliente,$id_direccion)
    {
        $objConexion = new Conexion();
        $sql = "UPDATE direcciones_envio SET selected=1
                WHERE num_cliente='".$num_cliente."' AND id_direccion='".$id_direccion."'";
        $resul = $objConexion->generarTransaccion($sql);
        if ($resul) {
            $sql = "UPDATE direcciones_envio SET selected=0
                WHERE num_cliente='".$num_cliente."' AND id_direccion!='".$id_direccion."'";
            $resul = $objConexion->generarTransaccion($sql);
            return true;
        }else{
            return false;
        }
    }
}
?>