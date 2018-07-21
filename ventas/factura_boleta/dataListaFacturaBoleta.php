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

            $rsListaFacturaBoleta =  $objdb -> sqlFiltrarFacturaBoleta($idEmpresa, $filtro);
			
            while ($row = mysql_fetch_array($rsListaFacturaBoleta, MYSQL_ASSOC)){
            	$listaFacturaBoleta[] = array(
                    'idFacturaBoleta' => $row['idFacturaBoleta'],
                    'comprobante' => $row['comprobante'],
					'serieNumero' => $row['serieNumero'],
					'fechaEmision' => $row['fechaEmision'],
					'cliente' => $row['cliente'],
					'documentoIdentidad' => $row['documentoIdentidad'],
					'nroDocumentoIdentidad' => $row['nroDocumentoIdentidad'],
                    'moneda' => $row['moneda'],
					'totalVenta' => $row['totalVenta'],
					'estado' => $row['estado']
            	);
            }
			
            mysql_free_result($rsListaFacturaBoleta);
			
    	}
		
    }
}

echo json_encode($listaFacturaBoleta);
?>