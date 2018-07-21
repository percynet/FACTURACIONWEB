<?php
session_start();

include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

$listaHTML = '';
//$listaHTML = '<option value="0">[SELECCIONAR]</option>';

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO']) && isset($_POST['tabla']) && 
    isset($_POST['nombreCampoPadre']) && isset($_POST['valorIdPadre']) && isset($_POST['nombreIdPrincipal']) && isset($_POST['nombreIdPrincipal']) ){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];

	$tabla = $_POST["tabla"];
    $nombreCampoPadre = $_POST["nombreCampoPadre"];
    $valorIdPadre = $_POST["valorIdPadre"];
    $nombreIdPrincipal = $_POST["nombreIdPrincipal"];
    $nombreCampoDescripcion = $_POST["nombreCampoDescripcion"];	
   
	$objdb = new DBSql($_SESSION['paramdb']);
	$objdb -> db_connect();
	if ($objdb -> is_connection()){

        $rsListaData =  $objdb -> sqlListaTablaDependiente($idEmpresa, $tabla, $nombreCampoPadre, $valorIdPadre );
        
        while ($row = mysql_fetch_array($rsListaData)){
            $listaHTML .= '<option value="'.$row[$nombreIdPrincipal].'">'.$row[$nombreCampoDescripcion].'</option>';
        }
        mysql_free_result($rsListaData);
        
    }
  
}
echo $listaHTML;
?>	