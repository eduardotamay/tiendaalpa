<?php
session_start();
//Para cerrar sesion
include "MCarrito.php";
$objCarrito = new Carrito();
$id_temporal=$_GET['id_t'];$id_cliente=$_GET['id_c'];
$objCarrito->actualizar_id_cliente_cerrar($id_cliente,$id_temporal);
session_destroy();
header('location: index.php');
?>
