<?php
session_start();

include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceSP.php');
//include_once('../../interfaceSP.php');

$bResult = '0';
if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) ){
   
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    $idUsuario = $_SESSION['USUARIO']['idUsuario'];
    	
	$idCargo = $_POST["idCargo"];
   
    
	$objdbSP = new DBsp($_SESSION['paramdb']);
	$objdbSP -> db_connect_sp();
	if ($objdbSP -> is_connection_sp()){
   
        $text_accion = "Eliminacion";
        $rsResult =  $objdbSP -> execSP_DeleteCargo($idEmpresa, $idCargo, $idUsuario);
		
		if (mysqli_num_rows($rsResult)==1){
			$row = mysqli_fetch_array($rsResult);
			$resultado['resultado'] = $row[0];
		}
    }
   	
}

echo $resultado['resultado'];

?>	
