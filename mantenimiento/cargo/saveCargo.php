<?php
session_start();

include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceSP.php');
//include_once('../../interfaceSP.php');

$cargo = array();
$bResult = '0';
if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) ){
   
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    $idUsuario = $_SESSION['USUARIO']['idUsuario'];
    
	$accion = $_POST['accion'];
    //echo "ACCION:".$accion;	
	$cargoJSON = $_POST["cargo"];
    //print_r($cargoJSON);
    //$countArray = count($cargoJSON);
    //echo $countArray;
    
    $cargoJSON['idEmpresa'] = $idEmpresa;
    $cargoJSON['idUsuario'] = $idUsuario;
    //print_r($cargoJSON);
    //echo $cargoJSON['nombres'];    
    
	$objdbSP = new DBsp($_SESSION['paramdb']);
	$objdbSP -> db_connect_sp();
	if ($objdbSP -> is_connection_sp()){
	   
        if ($accion=="1"){
            $text_accion = "Modificacion";
            $rsResult =  $objdbSP -> execSP_UpdateCargo($cargoJSON);
        }else{
            if ($accion=="0"){
                $text_accion = "Nuevo";
                $rsResult =  $objdbSP -> execSP_InsertCargo($cargoJSON);
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
