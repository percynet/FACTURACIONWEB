<?php
session_start();

include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceSP.php');

$bResult = '0';
$jsonResult = array();
if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) ){
   
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    $idUsuario = $_SESSION['USUARIO']['idUsuario'];

	$idCabeceraFB = $_POST["idCabeceraFB"];
	$detalleJSON = $_POST["dataDetalle"];
	$accion = $_POST["accion"];
	
	//print_r($detalleJSON);
	
	$countDetalle = count($detalleJSON);
	//echo "countDetalle:".$countDetalle;
	
	$countInsert = 0;

	for($i=0; $i<$countDetalle; $i++){
		$detalleRow = $detalleJSON[$i];
		$detalleRow['idEmpresa'] = $idEmpresa;
		$detalleRow['idCabeceraFB'] = $idCabeceraFB;
		//$detalleRow['tipoProducto'] = $tipoProducto;
		$detalleRow['idUsuario'] = $idUsuario;
		//print_r($detalleRow);
		
		$objdbSP = new DBsp($_SESSION['paramdb']);
		$objdbSP -> db_connect_sp();
		
		if ($objdbSP -> is_connection_sp()){
			if($accion == "1"){
				$rsDeleteFacturaBoleta = $objdbSP -> execSP_DeleteDetalleFacturaBoleta($detalleRow);
				//print_r($rsDetalleFacturaBoleta);
				
				if (mysqli_num_rows($rsDeleteFacturaBoleta)==1){
					$row = mysqli_fetch_array($rsDeleteFacturaBoleta);
					//$resultado['resultado'] = $row[0];
				}

			}
		}
		$objdbSP -> db_disconnect_sp();
		
		$objdbSP = new DBsp($_SESSION['paramdb']);
		$objdbSP -> db_connect_sp();
		
		if ($objdbSP -> is_connection_sp()){
			
			$rsDetalleFacturaBoleta =  $objdbSP -> execSP_InsertDetalleFacturaBoleta($detalleRow);
			//print_r($rsDetalleFacturaBoleta);
			
			if (mysqli_num_rows($rsDetalleFacturaBoleta)==1){
				$row = mysqli_fetch_array($rsDetalleFacturaBoleta);

				if($row[0] == 1){
					$countInsert++;
				}
			}

		}
		$objdbSP -> db_disconnect_sp();
		
	}
	//echo "countInsert:".$countInsert;
	if($countInsert == $countDetalle){
		$bResult = '1';
		$jsonResult["success"] = true;
		$jsonResult["data"]["message"] = sprintf("Se han actualizado los registros satisfactoriamente.");
	}else{
		$jsonResult["success"] = false;
		$jsonResult["data"]["message"] = sprintf("No se actualizaron los registros.");
	}
	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonResult, JSON_FORCE_OBJECT);

?>	
