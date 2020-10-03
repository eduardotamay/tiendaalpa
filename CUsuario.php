<?php  
    include_once("MUsuario.php");

    //Para hacer el registro de usuario
    if (isset($_POST["register"]) && $_POST["register"]=="Register") {
        
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $email =  isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if ($name!='' && $email!='' && $password!='') {
        
            $name =  $name;
            $email = $email;
            $password = $password;
            
            //Llamo a la clase User con las funciones registrar y comprobar email
            $objUsuario = new Usuario;

            if (!$objUsuario->comprobar_Email($email)) {

                //Ciframos el password
                $password = password_hash($password,PASSWORD_DEFAULT);
                $objUsuario->Usuario($name,$email,$password);
                $resul = $objUsuario->registrar_Usuario();
                if ($resul) {
                    header('HTTP/1.1 200 Ok');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'UPDATE1')));
                }else{
                    header('HTTP/1.1 401 Error al registrarse');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'ERROR1')));
                }
            }else{
                header('HTTP/1.1 401 Email ya registrado');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR2')));
            }
        }else{
            header('HTTP/1.1 401 Faltaron algunos datos');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR3')));
        }
        
    }

    //Para iniciar sesión
    if (isset($_POST["login"]) && $_POST["login"]== "Login") {
        
      $email = isset($_POST['email']) ? $_POST['email']:null;
      $password = isset($_POST['password']) ? $_POST['password']:null;

        //Llamo a la clase Usuario
        $objUsuario = new Usuario();

        if ($email!='' && $password!='') {
            $val = 0;
            $val = $objUsuario->iniciar_Sesion($email,$password);
            if ($val) {
                $redirect = $_POST['location'];
                $_SESSION['email'] = $email;
                header('HTTP/1.1 200 Ok');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'OK','url'=>$redirect)));
            }else{
                header('HTTP/1.1 401 Error al iniciar sesion');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR1')));
            }
        }else{
            header('HTTP/1.1 400 Faltaron datos');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR2')));
        }

    }

    if (isset($_POST['updateUser']) && $_POST['updateUser']=="UPDATEUSER") {
        
        $id_cliente =   isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
        $name      =    isset($_POST['name']) ? $_POST['name'] : null;
        $email     =    isset($_POST['email']) ? $_POST['email'] : null;
        $password  =    isset($_POST['password']) ? $_POST['password'] : null;
        $confPassword  =    isset($_POST['confPassword']) ? $_POST['confPassword'] : null;  
        $apellido  =    isset($_POST['apellido']) ? $_POST['apellido'] : null;
        $rfc       =    isset($_POST['rfc']) ? $_POST['rfc'] : null;
        $razon_social = isset($_POST['razon_social']) ? $_POST['razon_social'] : null;
        $cfdi      =    isset($_POST['cfdi']) ? $_POST['cfdi'] : null;
        $calle     =    isset($_POST['calle']) ? $_POST['calle'] : null;
        $num_exterior = isset($_POST['num_ext']) ? $_POST['num_ext'] : null;
        $num_interior = isset($_POST['num_int']) ? $_POST['num_int'] : null;
        $ciudad    =    isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
        $municipio    =    isset($_POST['municipio']) ? $_POST['municipio'] : null;
        $cp        =    isset($_POST['cp']) ? $_POST['cp'] : null;
        $colonia   =    isset($_POST['colonia']) ? $_POST['colonia'] : null;
        $estado    =    isset($_POST['estado']) ? $_POST['estado'] : null;
        $pais      =    isset($_POST['pais']) ? $_POST['pais'] : null;

        $objUsuario = new Usuario();
        if ($password!="" and $confPassword!="") {
            if ($password==$confPassword) {
                $password = password_hash($password,PASSWORD_DEFAULT);   
            }else{
                echo "<script language='javascript'>alert('Las contraseñas no coinciden');
                     window.location='clientes/misdatos.php'</script>";
            } 
        }
        //TRUE HAGO UPDATE
        $resultado = $objUsuario->actualizarDatos(intval($id_cliente),$name,$apellido,$email,$password,$rfc,$razon_social,
        $cfdi,$calle,$num_exterior,$num_interior,$colonia,$ciudad,$municipio,$cp,$estado,$pais);
        if ($resultado) {
            echo "<script language='javascript'>alert('Bien: Datos actualizados');
            window.location='clientes/misdatos.php'</script>";
        }else{
            echo "<script language='javascript'>alert('No se actualizaron los datos');
            window.location='clientes/misdatos.php'</script>";
        }
    }
?>