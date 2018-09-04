<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

$jsondata = array();

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['idDireccion']) ){
        
		$idDireccion = $_POST['idDireccion'];
		$claveTipoDireccion = $_POST['claveTipoDireccion'];

		///echo "idServicio:".$idServicio;
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsDireccionCliente =  $objdb -> sqlGetDireccionClienteXID($idEmpresa, $idDireccion);
			if (mysql_num_rows($rsDireccionCliente)==1){
				$jsondata["success"] = true;
				$jsondata["data"]["message"] = sprintf("Se han encontrado %d registros", $rsDireccionCliente->num_rows+1);
				//$jsondata["data"]["entity"] = array();
				//$row = mysql_fetch_array($rsDireccionCliente, MYSQL_ASSOC);
				$row = mysql_fetch_array($rsDireccionCliente);
				//$jsondata["data"]["entity"][] = $row;
				
				$jsondata["data"]["entity"] = array(
					"tipoVia" => $row["tipoVia"],
					"nombreVia" => $row["nombreVia"],
					"numero" => $row["numero"],
					"interior" => $row["interior"],
					"zona" => $row["zona"],
					"departamento" => $row["departamento"],
					"provincia" => $row["provincia"],
					"distrito" => $row["distrito"]			
				);
				
			}else{ 
				$jsondata["success"] = false;
			 	$jsondata["data"] = array(
			   		'message' => 'No se encontró ningún resultado.'
			 	);
		   	}
			
            mysql_free_result($rsDireccionCliente);
    	}
    }
}
//print_r($dataResult);
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
//echo json_encode($dataResult);
?>