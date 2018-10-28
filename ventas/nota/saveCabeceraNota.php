<?php
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceSP.php');

$jsonResult = array();
if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) ){
   
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    $idUsuario = $_SESSION['USUARIO']['idUsuario'];
    
	$accion = $_POST["accion"];
    //echo "ACCION:".$accion;	
	$cabeceraJSON = $_POST["cabecera_nota"];
    
    //$countArray = count($cabeceraJSON);
    //echo $countArray;
    
    $cabeceraJSON['idEmpresa'] = $idEmpresa;
    $cabeceraJSON['idUsuario'] = $idUsuario;

    //print_r($cabeceraJSON);
    //echo $cabeceraJSON['nombres'];    
  	
	$objdbSP = new DBsp($_SESSION['paramdb']);
	$objdbSP -> db_connect_sp();
	
	if ($objdbSP -> is_connection_sp()){
		if($accion == "0"){
			$rsResultInsert = $objdbSP -> execSP_InsertCabeceraNota($cabeceraJSON);
			
			if (mysqli_num_rows($rsResultInsert)==1){
				$jsonResult["success"] = true;
				$jsonResult["data"]["message"] = sprintf("Se ha creado %d registro satisfactoriamente", $rsResultInsert->num_rows);
				
				$row = mysqli_fetch_array($rsResultInsert);
				
				$jsonResult["data"]["entity"] = array(
					"idCabeceraNota" => $row[1],
					"serieNumeroNota" => $row[2]
				);
				
				//$resultado['result'] = $row[0];		
			}else{ 
				$jsonResult["success"] = false;
			 	$jsonResult["data"] = array(
			   		'message' => 'No se grabo el registro.'
			 	);
		    }
			mysqli_free_result($rsResultInsert);
			
		}else{
			if($accion == "1"){
				$rsResultUpdate = $objdbSP -> execSP_UpdateCabeceraNota($cabeceraJSON);
			
				if (mysqli_num_rows($rsResultUpdate)==1){
					$jsonResult["success"] = true;
					$jsonResult["data"]["message"] = sprintf("Se ha actualizado %d registro satisfactoriamente.", $rsResultUpdate->num_rows);
					
					$row = mysqli_fetch_array($rsResultUpdate);
					
					$jsonResult["data"]["entity"] = array(
						"idCabeceraNota" => $row[1],
						"serieNumeroNota" => $row[2]
					);
					
					//$resultado['result'] = $row[0];
				}else{ 
					$jsonResult["success"] = false;
					$jsonResult["data"] = array(
						'message' => 'No se actualizo el registro.'
					);
				}
				mysqli_free_result($rsResultUpdate);
			}
		}
    }
	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonResult, JSON_FORCE_OBJECT);

?>	
