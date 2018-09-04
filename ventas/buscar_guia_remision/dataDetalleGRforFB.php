<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    //if(isset($_POST['idCabeceraFB'])){
		
		$cabecerasGR = $_POST['cabecerasGR'];
        
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsDetalleGRforFB =  $objdb -> sqlGetDetalleGRforFB($idEmpresa, $cabecerasGR);
			
            while ($row = mysql_fetch_array($rsDetalleGRforFB, MYSQL_ASSOC)){
            	$detalleFB[] = array(
                    'idProducto' => $row['idProducto'],
					'tipoProducto' => $row['tipoProducto'],
					'codigo' => $row['codigo'],
                    'cantidad' => $row['cantidadFB'],
					'descripcion' => $row['descripcionFB'],
					'precioUnitario' => $row['precioUnitarioFB'],
					'importe' => $row['importeFB']
            	);
            }
			
            mysql_free_result($rsDetalleGRforFB);
			
    	}
		
    //}
}

echo json_encode($detalleFB);
?>