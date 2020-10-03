<?php

function dame_linea($linea){
    
    $caracter=substr($linea,1,1);
    
    if($caracter=='A') return 'Automotriz';
    elseif($caracter=='H') return 'Hidráulica';
    elseif($caracter=='I') return 'Industrial';
    elseif($caracter=='N') return 'Neumática';
    else{
        return '';
    }
}

function asignar_obtener_id()
{
    if (!isset($_SESSION['email'])) {
        if(isset( $_COOKIE['id_user'])){
            $id_temporal = $_COOKIE['id_user'];
        }
        else{
            $fecha = new DateTime();
            $timesTamp = $fecha->getTimestamp();
            // Crea una Cookie con un tiempo de vida de 2 minutos
            setcookie("id_user", $timesTamp, time() + (86400 * 30));
            $id_temporal = $_COOKIE['id_user'];
        }
        return $id_temporal;
    }else{
        if(isset( $_COOKIE['id_user'])){
            $id_temporal = $_COOKIE['id_user'];
        }
        else{
            $fecha = new DateTime();
            $timesTamp = $fecha->getTimestamp();
            // Crea una Cookie con un tiempo de vida de 2 minutos
            setcookie("id_user", $timesTamp, time() + (86400 * 30));
            $id_temporal = $_COOKIE['id_user'];
        }
        $id_user = $_SESSION['id_usuario'];
        return array($id_user,$id_temporal);
    }
    
    // $fecha = new DateTime();
    // $timesTamp = $fecha->getTimestamp();
    // $id_temporal = "";
    // if (!isset($_SESSION['email'])) {//En caso de que no tenga iniciado sesion
    //     $id_temporal = session_id($timesTamp); //Establezco un nuevo id
    //     return $id_temporal;
    // }else{
    //     $id_user = $_SESSION['id_usuario'];
    //     $id_temporal = session_id($timesTamp);
    //     return array($id_user,$id_temporal);
    // }
}


//Para buscar fotos de productos en la carpeta ../fotos/
function buscarFotoProducto($skuProducto)
{
    $path = "fotos/";
    // Abrimos la carpeta que nos pasan como parámetro
    $dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos .
        if( $elemento != "."){
            // Comparo el elemento de la carpeta con el sku de mi bd
            if($elemento==$skuProducto){
                // Si existe retorno el link y sku
                return $elemento; 
            }
        }
    }
}

//Cambiar el path y buscar foto desde el carrito de compras
function buscarFotoProductoCarrito($skuProducto){
    $path = "../fotos/";
    // Abrimos la carpeta que nos pasan como parámetro
    $dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos .
        if( $elemento != "."){
            // Comparo el elemento de la carpeta con el sku de mi bd
            if($elemento==$skuProducto){
                // Si existe retorno el link y sku
                return $elemento; 
            }
        }
    }
}

function obtener_Id_Temporal()
{
    return $id_tempo=$id_temporal;
}

function entrega_aprox()
{
    setlocale(LC_TIME, "spanish");
        $fecha_actual = new DateTime();
        $fecha_actual->getTimestamp();
        $fecha      = date_format($fecha_actual, 'Y-m-d H:i:s');
        $fecha_entrega=0;
        $dia=date('l');
        $hora = date("H:i:s");

        $fecha_entrega = new DateTime($fecha);
        if($dia=="Monday" || $dia=="Tuesday" || $dia=="Wednesday" || $dia=="Thursday" || $dia=="Friday" and $hora<"16:00:00"){
            //Entrega mismo dia
            $fecha_entrega = date_format($fecha_entrega,'Y-m-d');
        }elseif($hora>="16:00:00" and $dia=="Friday"){
                //Se entrega el lunes
            $fecha_entrega = date_format($fecha_entrega->add(new DateInterval('P3D')),'Y-m-d');
        }elseif($dia=="Saturday"){
            // Se entrega el lunes
            $fecha_entrega = date_format($fecha_entrega->add(new DateInterval('P2D')),'Y-m-d');
        }else{
            // Se entrega siguiente dia
            $fecha_entrega = date_format($fecha_entrega->add(new DateInterval('P1D')),'Y-m-d');
        }
        $formatoFecha = date("d-m-Y", strtotime($fecha_entrega));
        echo $fechaES = strftime("%A, %d de %B", strtotime($formatoFecha));
        // echo date('l', strtotime($fecha_entrega))." ".date('d', strtotime($fecha_entrega))." de ".date('F', strtotime($fecha_entrega));
}

?>