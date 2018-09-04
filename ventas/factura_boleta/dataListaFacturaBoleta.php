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

            $rsListaFacturaBoleta =  $objdb -> sqlFiltrarCabeceraFB($idEmpresa, $filtro);
			
            while ($row = mysql_fetch_array($rsListaFacturaBoleta, MYSQL_ASSOC)){
            	$listaFacturaBoleta[] = array(
                    'idCabeceraFB' => $row['idCabeceraFB'],
                    'fechaEmision' => $row['fechaEmision'],
					'serieNumero' => $row['serieNumeroFB'],
					'comprobante' => $row['comprobantePago'],
					'cliente' => $row['cliente'],
					'formaPago' => $row['formaPago'],
					'moneda' => $row['moneda'],
					'totalVenta' => $row['totalVenta']
					//'estado' => $row['estado']
            	);
            }
			
            mysql_free_result($rsListaFacturaBoleta);
			
    	}
		
    }
}

echo json_encode($listaFacturaBoleta);
?>