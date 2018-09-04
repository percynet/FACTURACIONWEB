<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	$idUsuario = $_SESSION['USUARIO']['idUsuario'];
    
   	//if(isset($_POST['idTransportista']) && isset($_POST['chofer'])){
    //if(isset($_POST['filtro'])){   
		$filtroJSON = $_POST['filtro'];
		$filtroJSON['idEmpresa'] = $idEmpresa;
    	$filtroJSON['idUsuario'] = $idUsuario;
				
		//print_r($filtroJSON);
		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsListaChofer =  $objdb -> sqlFiltrarChofer($filtroJSON);
			
            while ($row = mysql_fetch_array($rsListaChofer, MYSQL_ASSOC)){
            	$listaChofer[] = array(
                    'idChofer' => $row['idChofer'],
					'idTransportista' => $row['idTransportista'],
					'rucTransportista' => $row['rucTransportista'],
					'razonSocialTransportista' => $row['razonSocialTransportista'],
					'codigo' => $row['codigo'],
					'chofer' => $row['chofer'],
					'licenciaConducir' => $row['licenciaConducir'],
            		'estado' => $row['estado']
            	);
                
            }
            mysql_free_result($rsListaChofer);
			
    	}
		
    //}
}

echo json_encode($listaChofer);
?>