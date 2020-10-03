<?php
include "includes/conexion_db.php";
include "includes/funciones.php";

$producto = isset($_REQUEST['q']) ? $_REQUEST['q'] :FALSE;

$objConexion = new Conexion();
$sql = "SELECT * FROM productos WHERE descripcion LIKE '%".$producto."%' || pal_clave LIKE '%".$producto."%' LIMIT 5";
$resultB = $objConexion->generarTransaccion($sql);

// Path
$path = isset($_REQUEST['path']) ? $_REQUEST['path'] :FALSE;

if ($resultB->num_rows > 0) {
    echo '<hr>';
    while($row = $resultB->fetch_assoc()) {
        if ($path) {
            echo '<a class="resultado-live" href="../detalles.php?producto='.$row['sku'].'">('.$row['pal_clave'].") ".$row['descripcion'].'<a><hr>';
        }else{
            echo '<a class="resultado-live" href="detalles.php?producto='.$row['sku'].'">('.$row['pal_clave'].") ".$row['descripcion'].'<a><hr>';
        }
    }
    if ($path) {
        echo '<a class="resultado-live" style="color:#9E1F1A;" href="../busqueda.php?producto='.$producto.'">VER RESULTADOS COMPLETOS DE '.$producto.'<a><hr>';
    }else{
        echo '<a class="resultado-live" style="color:#9E1F1A;" href="busqueda.php?producto='.$producto.'">VER RESULTADOS COMPLETOS DE '.$producto.'<a><hr>';
    }
}
else{
    echo 'No se encontraron resultados';
}     


?>