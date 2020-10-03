<?php

require_once("includes/conexion_db.php");

    class Usuario
    {
        private $name;
        private $email;
        private $password;

        public function __construct(){}

        public function Usuario($name, $email, $password){
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
        }

        //Accesadores
        public function getName_User() {return $this->name;}
        public function getEmail_User() {return $this->email;}
        public function getPassword_User() {return $this->password;}

        //Mutantes
        public function setName_User($name){return $this->name;}
        public function setEmail_User($email){return $this->email;}
        public function setPassword_User($password){return $this->password;}

        public function registrar_Usuario(){
            $objConexion = new Conexion();
            $sql = "INSERT INTO usuarios (nombre_cliente,email,contraseña) 
                    VALUES ('".$this->name."','".$this->email."','".$this->password."')";
            $resul = $objConexion->generarTransaccion($sql);
            return $resul;
        }

        public function comprobar_Email($email)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM usuarios WHERE email='".$email."'";
            $resul = $objConexion->generarTransaccion($sql);
            $vector=mysqli_fetch_array($resul);
    		if($vector>0){
      			return true;
    		}else{
    		    return false;
    		}
        }

        public function buscar_Usuario($id)
        {
            $objConexion = new Conexion();
            $sql = "SELECT * FROM usuarios WHERE id_usuario='".$id."' and status_usuario=1";
            $resul = $objConexion->generarTransaccion($sql);
            return $resul;
        }

        public function iniciar_Sesion($email,$password){
            session_start();
            $objConexion = new Conexion();
            $activo = 1; //me indica que está activo en el sistema
            $sql = "SELECT * FROM usuarios WHERE email='".$email."'";
            $resul = $objConexion->generarTransaccion($sql);
            $vector = mysqli_fetch_array($resul); 

            //lo comparo con el que está en la BD
            $pass = password_verify($password,$vector['contraseña']);
            
            if($vector['email']==$email && $vector['status_usuario']==$activo && $vector['contraseña']==$pass) {
                
                $name = $vector['nombre_cliente'];
                $password = $vector['contraseña']; 
                $email  = $vector['email'];

                //Le asigno valores a la sesion
                $_SESSION['nombre_cliente'] = $name;
                $_SESSION['apellido_cliente'] = $vector['apellido'];
                $_SESSION['password'] = $password;
                $_SESSION['email'] = $email;
                $_SESSION['id_usuario'] = $vector['id_usuario'];
                
                return true;
            }else{
                return false; 
            }
        }

        public function actualizarDatos($id_cliente,$nombre_cliente,$apellido,$email,$password,$rfc,$razon_social,$cfdi,$calle,$num_exterior,$num_interior,$colonia,$ciudad,$municipio,$cp,$estado,$pais)
        {
            $objConexion = new Conexion();
            $activo = 1; //me indica que está activo en el sistem
            if ($password=="") {
                $sql = "UPDATE usuarios SET nombre_cliente='".$nombre_cliente."',apellido='".$apellido."',email='".$email."',
                rfc='".$rfc."',razon_social='".$razon_social."',cfdi='".$cfdi."',calle='".$calle."',num_exterior='".$num_exterior."',num_interior='".$num_interior."',colonia='".$colonia."',
                ciudad='".$ciudad."',delegacion='".$municipio."',cp='".$cp."',estado='".$estado."',pais='".$pais."' WHERE id_usuario='".$id_cliente."' and status_usuario='".$activo."'";
                $resul = $objConexion->generarTransaccion($sql);
                if($resul){
                    return true;
                }else{
                    return false;
                }
            }else{
                $sql = "UPDATE usuarios SET nombre_cliente='".$nombre_cliente."',apellido='".$apellido."',email='".$email."',contraseña='".$password."',
                rfc='".$rfc."',razon_social='".$razon_social."',cfdi='".$cfdi."',calle='".$calle."',num_exterior='".$num_exterior."',num_interior='".$num_interior."',colonia='".$colonia."',
                ciudad='".$ciudad."',delegacion='".$municipio."',cp='".$cp."',estado='".$estado."',pais='".$pais."' WHERE id_usuario='".$id_cliente."' and status_usuario='".$activo."'";
                $resul = $objConexion->generarTransaccion($sql);
                if($resul){
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function actualizarDatosFactura($id_cliente,$razon_social,$cfdi,$rfc,$calle,$num_exterior,$num_interior,$ciudad,$cp,$estado)
        {
            $objConexion = new Conexion();
            $activo = 1; //me indica que está activo en el sistem
            $sql = "UPDATE usuarios SET rfc='".$rfc."',razon_social='".$razon_social."',cfdi='".$cfdi."',calle='".$calle."',num_exterior='".$num_exterior."',num_interior='".$num_interior."',
            ciudad='".$ciudad."',cp='".$cp."',estado='".$estado."' WHERE id_usuario='".$id_cliente."' and status_usuario='".$activo."'";
            $resul = $objConexion->generarTransaccion($sql);
            return $resul;
        }

    }
    
?>