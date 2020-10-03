<?php

    include_once("MDir_envio.php");

    //Para insertar la dirección
    if (isset($_POST["insertDir"]) && $_POST["insertDir"]=="INSERTDIRECC") {
        
        $id_direcc    = isset($_POST['id_direccion'])   ? $_POST['id_direccion']: null;
        $num_cliente  = isset($_POST['num_cliente'])    ? $_POST['num_cliente'] : null;
        $calle        = isset($_POST['calle'])          ? $_POST['calle']       : null;
        $num_ext      = isset($_POST['num_ext'])        ? $_POST['num_ext']     : null;
        $num_int      = isset($_POST['num_int'])        ? $_POST['num_int']     : null;
        $colonia      = isset($_POST['colonia'])        ? $_POST['colonia']     : null;
        $cp           = isset($_POST['cp'])             ? $_POST['cp']          : null;
        $ciudad       = isset($_POST['ciudad'])         ? $_POST['ciudad']      : null;
        $municipio    = isset($_POST['municipio'])      ? $_POST['municipio']   : null;
        $entre_calle  = isset($_POST['entrecalles'])    ? $_POST['entrecalles'] : null;
        $estado       = isset($_POST['estado'])         ? $_POST['estado']      : null;
        $pais         = isset($_POST['pais'])           ? $_POST['pais']        : null;
        $referen      = isset($_POST['referencia'])     ? $_POST['referencia']  : null;


        //Verificar la direccion sino existe hacer registro
        $objDireccion = new DireccionEnvio;
        $resul = $objDireccion->listarMisDirecciones($num_cliente);
        $contador = 1;
        $direc=1;
        while ($row = mysqli_fetch_array($resul)) {
            $contador =$contador +1;
            if ($row['id_direccion']==1) {
                $direc = 2;
            }else{
                $direc = 1;
            }
        }
        if ($cp!=null and $pais!=null and $estado!=null and $num_cliente!=null and $municipio!=null and $calle!=null) {
            $resul2 = $objDireccion->editarMiDirecciones($id_direcc,$num_cliente);
            $rowd = mysqli_fetch_array($resul2);
            if ($rowd['id_direccion']==$id_direcc and $id_direcc!='') {
                $res_actual = $objDireccion->actualizarMisDirecciones(intval($num_cliente),intval($id_direcc),$calle,$num_ext,$num_int,$colonia,$cp,$ciudad,$municipio,$estado,$pais,$entre_calle,$referen);
                if ($res_actual) {
                    header('HTTP/1.1 200 Ok');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'OK1'))); //Se actualizó
                }else{
                    header('HTTP/1.1 401 Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'ERROR1'))); //No se actualizó la info
                }
            }else{
                if ($contador<=2) {
                    $objDireccion->DireccionEnvio($direc,$num_cliente,$calle,$num_ext,$num_int,
                    $colonia,$cp,$ciudad,$municipio,$estado,$pais,$entre_calle,$referen);
                    $result = $objDireccion->insertarDireccionEnvio();
                    if ($result) {
                        header('HTTP/1.1 200 Ok');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'OK2')));//Se insertaron los datos
                    }else{
                        header('HTTP/1.1 401 Error');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'ERROR2'))); //Algo falló
                    }   
                }else{
                    header('HTTP/1.1 401 Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'ERROR3'))); //No puedes agregar otra dirección
                }
            }
        }else{
            header('HTTP/1.1 401 Error4');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR4'))); //Faltaton datos
        }
        // Fin
    }

    if (isset($_POST["elegirDireccion"]) && $_POST["elegirDireccion"]=="ELEGIRDIRECCION") {
        $id_direcc    = isset($_POST['id'])   ? $_POST['id']: null;
        $num_cliente  = isset($_POST['num_cliente'])    ? $_POST['num_cliente'] : null;
        $objDireccion = new DireccionEnvio;
        $res_actual = $objDireccion->elegir_direccion(intval($num_cliente),intval($id_direcc));
        if ($res_actual) {
            header('HTTP/1.1 200 Ok');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'OK'))); //Se actualizó
        }else{
            header('HTTP/1.1 401 Error4');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR'))); //NO SE PUDO ELEGIR LA DIRECCION
        }
    }
?>