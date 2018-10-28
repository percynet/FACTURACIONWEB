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
                Listado de Vehiculos
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
                                            <td width="100">Marca:</td>                          
                                          	<td width="200">
                                               
                                                <select id="cboMarca" style="width:200px;" onchange="Limpiar_Resultados();" >
                                                  <option value="0">[TODOS]</option>	
                                                    <?php
                                                        $rsListaMarca= $objdb -> sqlListaMarca($idEmpresa, 'ACTIVO');
                                                        if (mysql_num_rows($rsListaMarca)!=0){
                                                        	while ($rowMarca = mysql_fetch_array($rsListaMarca)){
                                                        		$idMarcaX = $rowMarca["idMarca"];
                                                        		$marcaX = $rowMarca["marca"];
                                                        		
                                                        		if($idMarcaX==$cliente['idMarca']){
                                                        ?>			
                                                        			<option value="<?= $idMarcaX; ?>" selected="selected"><?= $marcaX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idMarcaX; ?>" ><?= $marcaX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaMarca);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                            <td width="100">Modelo:</td>                          
                                          	<td width="200">
                                                <select id="cboModelo" style="width:200px;" onchange="Limpiar_Resultados();" >
                                                	<option value="0">[TODOS]</option>	
                                                    <?php
                                                        $rsListaModelo= $objdb -> sqlListaModelo($idEmpresa, $idMarca);
                                                        if (mysql_num_rows($rsListaModelo)!=0){
                                                        	while ($rowModelo = mysql_fetch_array($rsListaModelo)){
                                                        		$idModeloX = $rowModelo["idModelo"];
                                                        		$modeloX = $rowModelo["modelo"];
                                                        		
                                                        		if($idModeloX==$cliente['idModelo']){
                                                        ?>			
                                                        			<option value="<?= $idModeloX; ?>" selected="selected"><?= $modeloX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idModeloX; ?>" ><?= $modeloX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaModelo);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
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
                            <button class="btn" id="btnAceptar" onclick="Seleccionar_Vehiculo();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Buscar_Vehiculo();">
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
		/*
        var idTransportista = $("#cboTransportista").val();
        var idMarca = $("#cboMarca").val();
		var idModelo = $("#cboModelo").val();
		*/
		var filtro = {            
            idTransportista: $.trim($("#cboTransportista").val()),
			idMarca: $.trim($("#cboMarca").val()),
			idModelo: $.trim($("#cboModelo").val())
        };
        
        $("#resultadoFiltroDiv").load("ventas/buscar_vehiculo/listaVehiculo.php?p="+Math.random(), 
			{ filtro: filtro });
		
    });	
		
	function Actualizar_Modelo(){
		
        var tabla = "modelo";
        var nombreCampoPadre = "idMarca";
        var valorIdPadre = $("#cboMarca").val();
        var nombreIdPrincipal = "idModelo";
        var nombreCampoDescripcion = "modelo";
                   
        $.ajax({
	  		type: "POST",
	   		url : "comunes/combos/dataComboDependiente.php?p="+Math.random(),
            data: {tabla:tabla, nombreCampoPadre:nombreCampoPadre, valorIdPadre:valorIdPadre, nombreIdPrincipal:nombreIdPrincipal,nombreCampoDescripcion:nombreCampoDescripcion},           
	   		success: function(dataResult){
                //console.log(dataResult);
                $("#cboModelo").html("");
				$("#cboModelo").append("<option value='0'>[TODOS]</option>");
                $("#cboModelo").append(dataResult);
	   		},
	   		error: function(){
	   			Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
	   		}
	 	});
				
	}
	
		
	function Enter_Buscar(e){
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}
	}
			
    function Buscar_Resultados(){
		
    	var idTransportista = $("#cboTransportista").val();
		var idMarca = $("#cboMarca").val();
		var idModelo = $("#cboModelo").val();
		
		if(idTransportista == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el transportista");
			return false;
		}
		/*
		if(idMarcaB == "0"){
			alert("Seleccione la marca");
			return false;
		}
		if(idModeloB == "0"){
			alert("Seleccione el modelo");
			return false;
		}
		*/
		 
		var filtro = {            
            idTransportista: $.trim($("#cboTransportista").val()),
			idMarca: $.trim($("#cboMarca").val()),
			idModelo: $.trim($("#cboModelo").val())
        };
		
		//$('#debug').html(filtro);
        //console.log(filtro);
			
		$("#resultadoFiltroDiv").html("");
        //$("#resultadoFiltroDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#resultadoFiltroDiv").load("ventas/buscar_vehiculo/listaVehiculo.php?p="+Math.random(), 
			{ filtro: filtro });
		
    }
	
	function Limpiar_Resultados(){
		$("#jqxGridListaVehiculo").jqxGrid('clear');
	}
	
    
            
</script>
