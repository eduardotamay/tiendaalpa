<?php 

$host = 'localhost';
$user = 'minoxidi_root';
$pass = 'G0Swim22--';
$bd = "minoxidi_tienda";
$conexion_db = mysqli_connect($host, $user, $pass, $bd);

if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
} else{
    $conexion_db->set_charset("utf8");
}

?>