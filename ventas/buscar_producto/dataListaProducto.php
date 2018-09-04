<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['filtro']) && isset($_POST['valor']) && isset($_POST['tipoProducto'])){
        
		$tipoProducto = $_POST['tipoProducto'];
		
		$filtro = array();
		$filtro['filtro'] = $_POST['filtro'];
		$filtro['valor'] = $_POST['valor'];
				
		//print_r($filtro);
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsListaProducto =  $objdb -> sqlFiltrarProducto($idEmpresa, $tipoProducto, $filtro);
	
            while ($row = mysql_fetch_array($rsListaProducto, MYSQL_ASSOC)){
            	$listaProducto[] = array(
                    'idProducto' => $row['idProducto'],
					'tipoProducto' => $row['tipoProducto'],
					'codigo' => $row['codigo'],
					'descripcion' => $row['descripcion'],
					'moneda' => $row['moneda'],
					'costoUnitario' => $row['costoUnitario'],
					'precioUnitario' => $row['precioUnitario'],
					'unidadMedida' => $row['unidadMedida'],
            		'estado' => $row['estado']
            	);
                
            }
            mysql_free_result($rsListaProducto);
    	}
    }
}

echo json_encode($listaProducto);
?>