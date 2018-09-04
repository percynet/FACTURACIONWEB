<?php 
session_start();
include("numerosALetras.php");

$totalVentaNumero = $_POST['totalVentaNumero'];

$totalLetras = numerosALetras($totalVentaNumero, 'SOLES');

echo $totalLetras;

?>