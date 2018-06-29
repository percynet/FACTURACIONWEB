<?php
session_start();

include("seguridad.php");

// Funciones de acceso a BD
include_once('interfaceDB.php');

if(isset($_SESSION['paramdb'])){
	$usuario = $_SESSION['USUARIO'];
    $empresa = $_SESSION['EMPRESA'];
	
    if($usuario['idUsuario'] != ""){
        //echo "entrando al sistema";
        //print_r($usuario);        
?>
    <script type="text/javascript">
    
        $(document).ready(function(){            		
            $("#menuMain").load("menuPrincipal.php?p="+Math.random());
            $("#containerMain").load("bienvenido.php?p="+Math.random());
    		$("#tituloWeb").html("<?=$empresa['razonSocial']; ?>"+ " - SISTEMA WEB");
        });
    
    </script>
<?php
    }else{
        $msgError = MSG_USER_NOT_VALID;
        header("Location: error.php?msgError=".$msgError);
		exit();
    }

}else{
    $msgError = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$msgError);
	exit();
}
?>