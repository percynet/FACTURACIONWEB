<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['idCabeceraGR'])){
		
		$idCabeceraGR = $_POST['idCabeceraGR'];
        		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsDetalleGuiaRemision =  $objdb -> sqlGetDetalleGuiaRemision($idEmpresa, $idCabeceraGR);
			
            while ($row = mysql_fetch_array($rsDetalleGuiaRemision, MYSQL_ASSOC)){
            	$detalleGuiaRemision[] = array(
                    'idProducto' => $row['idProducto'],
                    'codigo' => $row['codigo'],
					'descripcion' => $row['descripcion'],
					'cantidad' => $row['cantidad'],
					'peso' => $row['peso'],
					'unidadMedida' => $row['unidadMedida'],
					'costoUnitario' => $row['costoUnitario']
            	);
            }
			
            mysql_free_result($rsDetalleGuiaRemision);
			
    	}
		
    }
}

echo json_encode($detalleGuiaRemision);
?>