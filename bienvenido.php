<?php
session_start();

include("seguridad.php");

if($_SESSION["AUTENTICADO"] == "SIP"){
    if(isset($_SESSION['USUARIO'])){
        $usuario = $_SESSION['USUARIO'];
        $empresa = $_SESSION['EMPRESA'];        
?>

		<div class="row">
            <div class="col-lg-6" style="width:100%">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        SISTEMA WEB
                    </div>
                    <div class="panel-body">
                        <h4>Bienvenidos al sistema web para su empresa</h4><br />
                        <div class="alert alert-success">
                            <strong><?=$empresa['razonSocial']; ?></strong><br />
                            Sr. <?=$usuario['usuario']; ?>
                        </div>
                        <div align="center">
                        	<img src="theme/images/facturacion.jpg"  />
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>
                </div>
            </div>          
        </div>
<?php
    }else{
        
    }
}
?>