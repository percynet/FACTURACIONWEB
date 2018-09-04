<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	$idUsuario = $_SESSION['USUARIO']['idUsuario'];
    
   	//if(isset($_POST['idTransportista']) && isset($_POST['idMarca']) && isset($_POST['idModelo'])){
    //if(isset($_POST['filtro'])){   
		$filtroJSON = $_POST['filtro'];
		$filtroJSON['idEmpresa'] = $idEmpresa;
    	$filtroJSON['idUsuario'] = $idUsuario;
				
		//print_r($filtroJSON);
		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsListaVehiculo =  $objdb -> sqlFiltrarVehiculo($filtroJSON);
			
            while ($row = mysql_fetch_array($rsListaVehiculo, MYSQL_ASSOC)){
            	$listaVehiculo[] = array(
                    'idVehiculo' => $row['idVehiculo'],
					'idTransportista' => $row['idTransportista'],
					'rucTransportista' => $row['rucTransportista'],
					'razonSocialTransportista' => $row['razonSocialTransportista'],
					'idMarca' => $row['idMarca'],
					'marca' => $row['marca'],
					'idModeloMarca' => $row['idModeloMarca'],
					'modelo' => $row['modelo'],
					'codigo' => $row['codigo'],
					'placaTracto' => $row['placaTracto'],
					'placaRemolque' => $row['placaRemolque'],
					'configuracionVehicular' => $row['configuracionVehicular'],
					'certificadoInscripcion' => $row['certificadoInscripcion'],
					'anioFabricacion' => $row['anioFabricacion'],
            		'estado' => $row['estado']
            	);
                
            }
            mysql_free_result($rsListaVehiculo);
			
    	}
		
    //}
}

echo json_encode($listaVehiculo);
?>