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

            $rsListaCliente =  $objdb -> sqlFiltrarCliente($idEmpresa, $filtro);
	
            while ($row = mysql_fetch_array($rsListaCliente, MYSQL_ASSOC)){
            	$listaCliente[] = array(
                    'idCliente' => $row['idCliente'],
                    'nombres' => $row['nombres'],
					'apellidoPaterno' => $row['apellidoPaterno'],
					'apellidoMaterno' => $row['apellidoMaterno'],
					'documentoIdentidad' => $row['documentoIdentidad'],
					'nroDocumentoIdentidad' => $row['nroDocumentoIdentidad'],
            		'estado' => $row['estado']
            	);
                
            }
            mysql_free_result($rsListaCliente);
    	}
    }
}

echo json_encode($listaCliente);
?>