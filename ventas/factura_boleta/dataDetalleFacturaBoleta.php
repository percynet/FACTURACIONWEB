<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['idCabeceraFB'])){
		
		$idCabeceraFB = $_POST['idCabeceraFB'];
        		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsDetalleFacturaBoleta =  $objdb -> sqlGetDetalleFacturaBoleta($idEmpresa, $idCabeceraFB);
			
            while ($row = mysql_fetch_array($rsDetalleFacturaBoleta, MYSQL_ASSOC)){
            	$detalleFacturaBoleta[] = array(
					'idProducto' => $row['idProducto'],
					'tipoProducto' => $row['tipoProducto'],
					'codigo' => $row['codigo'],
                    'cantidad' => $row['cantidad'],
					'descripcion' => $row['descripcion'],
					'precioUnitario' => $row['precioUnitario'],
					'importe' => $row['importe']
            	);
            }
			
            mysql_free_result($rsDetalleFacturaBoleta);
			
    	}
		
    }
}

echo json_encode($detalleFacturaBoleta);
?>