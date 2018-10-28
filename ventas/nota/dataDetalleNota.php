<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['idCabeceraNota'])){
		
		$idCabeceraNota = $_POST['idCabeceraNota'];
        		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsDetalleNota =  $objdb -> sqlGetDetalleNota($idEmpresa, $idCabeceraNota);
			
            while ($row = mysql_fetch_array($rsDetalleNota, MYSQL_ASSOC)){
            	$detalleNota[] = array(
					'idProducto' => $row['idProducto'],
					'tipoProducto' => $row['tipoProducto'],
					'codigo' => $row['codigo'],
                    'cantidad' => $row['cantidad'],
					'descripcion' => $row['descripcion'],
					'precioUnitario' => $row['precioUnitario'],
					'importe' => $row['importe']
            	);
            }
			
            mysql_free_result($rsDetalleNota);
			
    	}
		
    }
}

echo json_encode($detalleNota);																																																							
?>