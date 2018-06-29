<?php
session_start();

// Parametros de configuracion
include_once('configuracion.php');

// Funciones de acceso a BD
include_once('interfaceDB.php');

$bContinue = false;
$sError = "";

if (isset($_POST['usuario']) && isset($_POST['password'])){

	$objdb = new DBSql($_SESSION['paramdb']);
	$objdb -> db_connect();
	if ($objdb -> is_connection()){
		
  		$usuario = $_POST['usuario'];
		$password = $_POST['password'];  
        
		$idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
		
        $rsMyUsuario = $objdb -> sqlExisteUsuario($idEmpresa, $usuario);
		
		if ($rsMyUsuario != null){
				
			if(intval(mysql_num_rows($rsMyUsuario))==1){
						
				$rowMyUsuario = mysql_fetch_array($rsMyUsuario);
				$idUsuario = $rowMyUsuario['idUsuario'];
				
				if($idUsuario > 0){
				
					$rsUsuario = $objdb -> sqlGetUsuario($idEmpresa, $usuario, $password);
			
					if ($rsUsuario != null){
					
						if (intval(mysql_num_rows($rsUsuario))==1){
							
							$rowUsuario = mysql_fetch_array($rsUsuario);
			
							if ($rowUsuario['idUsuario'] != ""){
							
								$usuarioSession['idEmpresa'] = $rowUsuario['idEmpresa'];
								$usuarioSession['idUsuario'] = $rowUsuario['idUsuario'];
								$usuarioSession['usuario'] = $rowUsuario['usuario'];
								$usuarioSession['idRol'] = $rowUsuario['idRol'];
								$usuarioSession['rol'] = $rowUsuario['rol'];
								$usuarioSession['idEmpleado'] = $rowUsuario['idEmpleado'];
								$usuarioSession['codigoEmpleado'] = $rowUsuario['codigoEmpleado'];
								$usuarioSession['nombresApellidos'] = $rowUsuario['nombresApellidos'];

								$_SESSION['USUARIO']= $usuarioSession;
								
								$_SESSION['AUTENTICADO']= "SIP";
								
								$bContinue = true;                       
								header("Location: principal.php?".SID);
								exit();
							}else{
								$sError = MSG_USER_NOT_VALID;
							}
						}else{
							$sError = MSG_USER_NOT_VALID;
						}
					}else{
						$sError = MSG_USER_NOT_VALID;
					}				
				}else{
					$sError = MSG_USER_NOT_VALID;
				}
			}else{
				$sError = MSG_USER_NOT_EXISTS;
			}
			
		}else{
			$sError = MSG_USER_NOT_EXISTS;
		}
		
	}else{
		$sError = MSG_DB_NOT_CONNECTION;
	}
}else{
	$sError = "nombre de usuario y password no validos";
}

if(!$bContinue){
	header("Location: login.php?sError=".$sError);
	exit();
}

?>