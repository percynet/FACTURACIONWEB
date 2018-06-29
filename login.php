<?php
session_start();

// Parametros de configuracion
include_once('configuracion.php');

// Funciones de acceso a BD
include_once('interfaceDB.php');

include_once('constantes.php');

$sError = "";
if(isset($_GET['sError'])){
   $sError = $_GET['sError'];
}

$sMessage = "";
$bContinue = false;
$idEmpresa = "";

if (isset($_SESSION['paramdb'])){
	
	$codigoInterno = $_SESSION['paramdb']['ciempresa'];
	//echo "codigoInterno:".$codigoInterno;
	if($codigoInterno != ""){
	
		$objdb = new DBSql($_SESSION['paramdb']);
		$objdb -> db_connect();
		
		if ($objdb -> is_connection()){
			
			$rsEmpresa =  $objdb -> sqlGetEmpresa($codigoInterno);
			
			if (mysql_num_rows($rsEmpresa) == 1){
							
				$rowEmpresa = mysql_fetch_array($rsEmpresa);
				$idEmpresa = $rowEmpresa["idEmpresa"];
				//echo "idEmpresa:".$idEmpresa;
				if($idEmpresa != ""){
					$_SESSION['EMPRESA'] = $rowEmpresa;
					$bContinue = true;
?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="login-panel panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Inicio de Session</h3>                        
                                    </div>
                                    <br />
                                    <div class="panel-body">
                                        
                                            <fieldset>
                                            <!--
                                                <div class="form-group">
                                                    <select name="cboAlmacen" id="cboAlmacen" class="form-control" style="width:330px;" placeholder="Almacen">
                                                      <option value="0">[ALMACEN]</option>
                                                        <?php
                                                            /*$rsListaAlmacen= $objdb -> sqlListaAlmacen($idEmpresa, 'ACTIVO');
                                                            if (mysql_num_rows($rsListaAlmacen)!=0){
                                                                while ($rowAlmacen = mysql_fetch_array($rsListaAlmacen)){
                                                                    $idAlmacenX = $rowrowAlmacenComprobante["idAlmacen"];
                                                                    $almacenX = $rowAlmacen["almacen"];
                                                            ?>			
                                                                    <option value="<?= $idAlmacenX; ?>" ><?= $almacenX; ?></option>
                                                            <?php
                                                                }
                                                                mysql_free_result($rsListaComprobante);
                                                            }*/
                                                        ?>
                                                    </select> 
                                                </div>
                                                -->
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Usuario" id="usuario" type="usuario" 
                                                    	onkeypress="Enter_Usuario(event);" autofocus >
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Password" id="password" type="password" 
                                                    	value="" onkeypress="Enter_Password(event);" >
                                                </div>
                                                <!-- Change this to a button or input when using this as a form -->                                
                                                <button class="btn btn-primary" type="button" onClick="Iniciar_Session();">Iniciar</button>
                                                <button class="btn btn-" type="button">Salir</button>
                                            </fieldset>
                                        
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>
<?php
				}else{
					$sMessage = MSG_EMPRESA_NOT_INFORMATION;
				}
				
			}else{
				$sMessage = MSG_EMPRESA_NOT_REGISTER;
			}
		
		}else{
			$sMessage = MSG_DB_NOT_CONNECTION;
		}
	
	}else{
		$sMessage = MSG_SYSTEM_NOT_ACCESS_CONFIG;
	}
	
}else{
	$sMessage = MSG_PARAMETER_NOT_CONNECTION;
}

if(!$bContinue){
	header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		<?php
			if($sError != ""){
		?>
				alert('Usuario no valido');
				$("#usuario").focus();
		<?php
			}
		?>
	});
	
		
	function Enter_Usuario(e){
		if(Evento_Enter(e)){
			$("#password").focus();
		}
	}
	
	function Enter_Password(e){	
		if(Evento_Enter(e)){
			Iniciar_Session();
		}		
	}
</script>