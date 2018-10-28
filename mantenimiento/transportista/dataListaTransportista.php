<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['filtro']) && isset($_POST['valor'])){
        
		$filtro = array();
		$filtro['filtro'] = $_POST['filtro'];
		$filtro['valor'] = $_POST['valor'];

		//print_r($filtro);
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsListaTransportista =  $objdb -> sqlFiltrarTransportista($idEmpresa, $filtro);
	
            while ($row = mysql_fetch_array($rsListaTransportista, MYSQL_ASSOC)){
            	$listaTransportista[] = array(
                    'idTransportista' => $row['idTransportista'],                    
					'codigo' => $row['codigo'],
                    'razonSocial' => $row['razonSocial'],
                    'ruc' => $row['ruc'],
            		'estado' => $row['estado']
            	);                              
                
            }
            mysql_free_result($rsListaTransportista);
    	}
    }
}

echo json_encode($listaTransportista);
?>