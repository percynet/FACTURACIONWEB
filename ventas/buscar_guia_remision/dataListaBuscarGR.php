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

            $rsListaGuiaRemision =  $objdb -> sqlFiltrarGR($idEmpresa, $filtro);
			
            while ($row = mysql_fetch_array($rsListaGuiaRemision, MYSQL_ASSOC)){
            	$listaGuiaRemision[] = array(
                    'idCabeceraGR' => $row['idCabeceraGR'],
                    'fechaEmision' => $row['fechaEmision'],
					'fechaTraslado' => $row['fechaTraslado'],
					'serieNumero' => $row['serieNumeroGRTransportista'],
					'clienteRemitente' => $row['clienteRemitente'],
					'documentoIdentidad' => $row['documentoIdentidadCR'],
					'numeroDocumentoIdentidad' => $row['numeroDocumentoIdentidadCR']
					//'estado' => $row['estado']
            	);
            }
			
            mysql_free_result($rsListaGuiaRemision);
			
    	}
		
    }
}

echo json_encode($listaGuiaRemision);
?>