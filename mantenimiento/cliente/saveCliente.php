<?php
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceSP.php');
//include_once('../../interfaceSP.php');

$cliente = array();
$bResult = '0';
if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) ){
   
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    $idUsuario = $_SESSION['USUARIO']['idUsuario'];
    
	$accion = $_POST['accion'];
    //echo "ACCION:".$accion;	
	$clienteJSON = $_POST["cliente"];
    //print_r($clienteJSON);
    //$countArray = count($clienteJSON);
    //echo $countArray;
    
    $clienteJSON['idEmpresa'] = $idEmpresa;
    $clienteJSON['idUsuario'] = $idUsuario;
    //print_r($clienteJSON);
    //echo $clienteJSON['nombres'];    
    
	$objdbSP = new DBsp($_SESSION['paramdb']);
	$objdbSP -> db_connect_sp();
	if ($objdbSP -> is_connection_sp()){
	   
        if ($accion=="1"){
            $text_accion = "Modificacion";
            $rsResult =  $objdbSP -> execSP_UpdateCliente($clienteJSON);
        }else{
            if ($accion=="0"){
                $text_accion = "Nuevo";
                $rsResult =  $objdbSP -> execSP_InsertCliente($clienteJSON);
            }
        }
		
		if (mysqli_num_rows($rsResult)==1){
			$row = mysqli_fetch_array($rsResult);
			$resultado['resultado'] = $row[0];
		}
    }
   	
}

echo $resultado['resultado'];

?>	
