<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){
    	
		$idTransportista = $_POST['idTransportista'];

?>
<!--
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Chofers
            </div>
-->            
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <!--<h4>Filtro</h4>-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td height="35" width="10">&nbsp;</td>
                                            <td width="100">Transportista: </td>
                                          	<td width="200">
                                                <select id="cboTransportista" style="width:200px;" disabled>
                                                  <option value="0">[SELECCIONAR]</option>	
                                                    <?php
                                                        $rsListaTransportista= $objdb -> sqlListaTransportista($idEmpresa, 'ACTIVO');
                                                        if (mysql_num_rows($rsListaTransportista)!=0){
                                                        	while ($rowTransportista = mysql_fetch_array($rsListaTransportista)){
                                                        		$idTransportistaX = $rowTransportista["idTransportista"];
                                                        		$transportistaX = $rowTransportista["razonSocial"];
                                                        		
                                                        		if($idTransportistaX==$idTransportista){
                                                        ?>			
                                                        			<option value="<?= $idTransportistaX; ?>" selected="selected"><?= $transportistaX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idTransportistaX; ?>" ><?= $transportistaX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaTransportista);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                            <td width="80">Chofer: </td>
                                            <td width="400">
                                                <input class="input-large focused" id="choferFiltro" type="text" value="" 
                                                onkeypress="return Validar_Chofer(event);" />                               
                                            </td>
                                            <td width="10">&nbsp;</td>
                                            <td width="80">
                                          		<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Buscar_Resultados();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                        </tr>
                                     </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>            
                    <!-- /.row -->       
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                    
                                <div id="resultadoFiltroDiv"></div>
                    
                            </div>
                        </div>
                    </div>
                    
                 	<div style="margin-top:5px; margin-right:15px;" align="right">
                        <p>
                            <button class="btn" id="btnAceptar" onclick="Seleccionar_Chofer();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Buscar_Chofer();">
                            		<i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
                        </p>
                    </div>
                    
                </div>
            </div>

<!--
        </div>

    </div>
</div>
-->
            
                
<?php
    }else{
        $sMessage = MSG_DB_NOT_CONNECTION;
        header("Location: error.php?msgError=".$sMessage);
    	exit();
    }
}else{
    $sMessage = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>


<script type="text/javascript">
    
    $(document).ready(function(){	  

		$("#choferFiltro").jqxInput({  width: '400px', height: '20px' });
		
		var filtro = {            
            idTransportista: $.trim($("#cboTransportista").val()),
			chofer: $.trim($("#choferFiltro").val())
        };
        
        $("#resultadoFiltroDiv").load("ventas/buscar_chofer/listaChofer.php?p="+Math.random(), 
			{ filtro: filtro });
		
    });	
		
	function Enter_Buscar(e){
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}
	}
			
    function Buscar_Resultados(){
		
    	var idTransportista = $("#cboTransportista").val();
		var chofer = $("#choferFiltro").val();
		
		if(idTransportista == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el transportista");
			return false;
		}

		var filtro = {            
            idTransportista: $.trim($("#cboTransportista").val()),
			chofer: $.trim($("#choferFiltro").val())
        };
		
		//$('#debug').html(filtro);
        //console.log(filtro);
			
		$("#resultadoFiltroDiv").html("");
        //$("#resultadoFiltroDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#resultadoFiltroDiv").load("ventas/buscar_chofer/listaChofer.php?p="+Math.random(), 
			{ filtro: filtro });
		
    }
    
	function Validar_Chofer(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toString();
		
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
		especiales = [8, 9, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.
	
		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
	
		
		if(letras.indexOf(tecla) > 0 || !tecla_especial){
			//alert('Este campo solo permite letras');
			
			Limpiar_Resultados();
			return false;
		}
		
	}
		
	function Limpiar_Resultados(){
		$("#jqxGridListaChofer").jqxGrid('clear');
	}
            
</script>
