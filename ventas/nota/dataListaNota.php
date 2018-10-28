<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['filtro'])){
        
		//$filtro = array();
		$filtro = $_POST['filtro'];
		//print_r($filtro );
		
        $objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){

            $rsListaNota =  $objdb -> sqlFiltrarCabeceraNota($idEmpresa, $filtro);
			
            while ($row = mysql_fetch_array($rsListaNota, MYSQL_ASSOC)){
            	$listaNota[] = array(
                    'idCabeceraNota' => $row['idCabeceraNota'],
					'fechaEmision' => $row['fechaEmision'],
                    'tipoNota' => $row['tipoNota'],					
					'serieNumeroNota' => $row['serieNumeroNota'],
					'comprobantePagoRef' => $row['comprobantePagoRef'],
					'cliente' => $row['cliente'],
					'motivoNota' => $row['motivoNota'],
					'moneda' => $row['moneda'],
					'totalVenta' => $row['totalVenta']
					//'estado' => $row['estado']
            	);
            }
			
            mysql_free_result($rsListaNota);
			
    	}
		
    }
}

echo json_encode($listaNota);
?>