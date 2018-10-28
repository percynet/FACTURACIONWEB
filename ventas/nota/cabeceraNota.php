<?php
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
	$idCabeceraNota = $_POST['idCabeceraNota'];
	$idTipoNota = $_POST['idTipoNota'];
	$tipoNota = $_POST['tipoNota'];
	
	$accion = $_POST['accion'];
	$textoAccion = "Nuevo ";
	$cabeceraNota['idCabeceraNota'] = "0";
	$cabeceraNota['idTipoNota'] = $idTipoNota;
	$cabeceraNota['tipoNota'] = $tipoNota;
	$cabeceraNota['totalImporte'] = "0.00";
	$cabeceraNota['totalIGV'] = "0.00";
	$cabeceraNota['totalVenta'] = "0.00";
	//echo "idCabeceraNota: ".$idCabeceraNota;
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){

		if($accion == "1"){
			$textoAccion = "Editar ";
			$rsCabeceraNota =  $objdb -> sqlGetCabeceraNota($idEmpresa, $idCabeceraNota);
			
			if (mysql_num_rows($rsCabeceraNota)==1){
				$cabeceraNota = mysql_fetch_array($rsCabeceraNota);
				//print_r(json_encode($cabeceraNota));	
				$idComprobantePagoRef = $cabeceraNota['idComprobantePagoRef'];
				$idTipoNota = $cabeceraNota['idTipoNota'];
				$idMotivoNota = $cabeceraNota['idMotivoNota'];
				$idMoneda = $cabeceraNota['idMoneda'];
			}
		}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<b><?=$textoAccion; ?>&nbsp;<?=$tipoNota; ?></b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    
                    					<tr style="height:25px;">
                                    		<td width="120">Fecha Emision:</td>
                                       		<td width="150">
                                                <div id="fechaEmisionDiv">
                                                    <div style='margin-top: 3px;' id='fechaEmision' />
                                                </div>
                                            </td>
                                            <td width="50">&nbsp;</td>
                                    		<td width="120">Serie Numero:</td>
                                       		<td>
                                                <div id="nroNotaDiv">
                                                    <input type="text" id="serieNumeroNota" value="<?= $cabeceraNota['serieNumeroNota']; ?>" readonly="readonly" style="background-color : #d1d1d1;" />
                                                </div>
                                            </td>
                                            <td width="50">&nbsp;</td>
                                    		<td width="150">Comprobante que mod.:</td>
                                       		<td width="150">
                                                <select id="cboComprobantePagoRef" name="cboComprobantePagoRef" style="width:150px;" onchange="Sumar_Totales();">
                                                  <option value="0">[SELECCIONAR]</option>
                                                    <?php
                                                        $rsListaComprobantePago= $objdb -> sqlListaComprobantePago($idEmpresa, 'U');
                                                        if (mysql_num_rows($rsListaComprobantePago)!=0){
                                                        	while ($rowComprobantePago = mysql_fetch_array($rsListaComprobantePago)){
                                                        		$idComprobantePagoX = $rowComprobantePago["idComprobantePago"];
                                                        		$comprobantePagoX = $rowComprobantePago["comprobantePago"];
                                                        		
                                                        		if($idComprobantePagoX==$idComprobantePagoRef){
                                                        ?>			
                                                        			<option value="<?= $idComprobantePagoX; ?>" selected="selected"><?= $comprobantePagoX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idComprobantePagoX; ?>" ><?= $comprobantePagoX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaComprobantePago);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="50">&nbsp;</td>
                                    		<td width="120">S/N Comp. mod.:</td>
                                       		<td>
                                                <div id="nroCPRefDiv">
                                                    <input type="text" id="serieNumeroCPRef" value="<?= $cabeceraNota['serieNumeroCPRef']; ?>" />
                                                </div>
                                            </td>
                                        </tr>
                    					<tr style="height:25px;">
                                    		<td width="120">Motivo Nota:</td>
                                       		<td width="150">
                                            	<select id="cboMotivoNota" name="cboMotivoNota" style="width:150px;">
                                                  <option value="0">[SELECCIONAR]</option>	
                                                    <?php
                                                        $rsListaMotivoNota= $objdb -> sqlListaMotivoNota($idEmpresa);
                                                        if (mysql_num_rows($rsListaMotivoNota)!=0){
                                                        	while ($rowMotivoNota = mysql_fetch_array($rsListaMotivoNota)){
                                                        		$idMotivoNotaX = $rowMotivoNota["idMotivoNota"];
                                                        		$motivoNotaX = $rowMotivoNota["motivoNota"];
                                                        		
                                                        		if($idMotivoNotaX==$idMotivoNota){
                                                        ?>			
                                                        			<option value="<?= $idMotivoNotaX; ?>" selected="selected"><?= $motivoNotaX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idMotivoNotaX; ?>" ><?= $motivoNotaX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaMotivoNota);
                                                        }
                                                    ?>
                                                </select>
                                            </td>                                            
                                            <td width="50">&nbsp;</td>
                                    		<td width="120">Moneda:</td>
                                       		<td width="150">
												<select id="cboMoneda" name="cboMoneda" style="width:150px;">
                                                  <!--<option value="0">[SELECCIONAR]</option>	-->
                                                    <?php
                                                        $rsListaMoneda= $objdb -> sqlListaMoneda($idEmpresa);
                                                        if (mysql_num_rows($rsListaMoneda)!=0){
                                                        	while ($rowMoneda = mysql_fetch_array($rsListaMoneda)){
                                                        		$idMonedaX = $rowMoneda["idMoneda"];
                                                        		$monedaX = $rowMoneda["moneda"];
                                                        		
                                                        		if($idMonedaX==$idMoneda){
                                                        ?>			
                                                        			<option value="<?= $idMonedaX; ?>" selected="selected"><?= $monedaX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idMonedaX; ?>" ><?= $monedaX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaMoneda);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="50">&nbsp;</td>
                                    		<td width="120">&nbsp;</td>
                                       		<td>&nbsp;</td>
                                            <td width="50">&nbsp;</td>
                                    		<td width="120">F.E. Comp. mod:</td>
                                       		<td>
                                                <div id="fechaEmisionCPRefDiv">
                                                    <div style='margin-top: 3px;' id='fechaEmisionCPRef' />
                                                </div>
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>

                        </div>
                        <!-- /.col-lg-12 -->
                        
						<div class="col-lg-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">                    
                    					<tr style="height:30px;" align="center">
                                       		<td>
                                                <div style="padding:0px;">
                                                    <button id="btnNuevo" class="btn btn-warning" style="width:100px;" >
                                                    	<i class="icon-search"></i> Nuevo &nbsp;</button>&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </td>
                                        </tr>                                        
                                        <tr style="height:30px;" align="center">
                                       		<td>
                                                <div style="padding:0px;">
                                                    <button id="btnGrabar" class="btn btn-info" style="width:100px;" >
                                                    	<i class="icon-search"></i> Guardar</button>&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height:30px;" align="center">
                                       		<td>
                                                <div style="padding:0px;">
                                                    <button id="btnRegresar" class="btn btn-danger" style="width:100px;" >
                                                    	<i class="icon-search"></i> Regresar</button>&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </td>
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
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;CLIENTE</b>
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="100">Razon Social:</td>
                                        	<td width="300">
                                            	<input id="cliente"  maxlength="100" readonly="readonly" value="<?= $cabeceraNota['cliente']; ?>" style="background-color: #d1d1d1;" />
                                            </td>
                                            <td width="70">&nbsp;</td>
                                            <td width="100">Doc. Identidad:</td>
                                        	<td>
                                            	<input id="documentoIdentidad"  maxlength="200" readonly="readonly" value="<?= $cabeceraNota['documentoIdentidad']; ?>" style="background-color: #d1d1d1;" />
                                            </td>
	                                        <td width="70">&nbsp;</td>
                                            <td width="100">Nro Documento:</td>
                                        	<td>
                                            	<input id="numeroDocumentoIdentidad"  maxlength="100" readonly="readonly" value="<?= $cabeceraNota['numeroDocumentoIdentidad']; ?>" style="background-color: #d1d1d1;" />
                                            </td>                                            
                                            <td width="70">&nbsp;</td>
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Cliente();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Direccion:</td>
                                        	<td width="300" colspan="8">
                                            	<input id="direccionActual"  maxlength="200" readonly="readonly" value="<?= $cabeceraNota['direccion']; ?>" style="background-color: #d1d1d1;" />
                                            </td>
	                                        <td>&nbsp;</td>
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
                            <div class="panel-body">
								<div id="detalleNotaDiv"></div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                        
                    </div>            
                    <!-- /.row -->
                    
                    <div class="row">    

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                            	<!--
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;TOTALES</b>
                                </div>
                                -->
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">
                                            <td width="70">&nbsp;</td>
                                            <td width="70">Sub Total:</td>
                                        	<td>
                                            	<input id="totalImporte"  maxlength="100" readonly="readonly" value="<?= $cabeceraNota['totalImporte']; ?>" style="background-color: #d1d1d1;" />
                                            </td>
                                            <td width="70">&nbsp;</td>
	                                        <td width="70">I.G.V. %:</td>
                                            <td>
                                            	<input id="totalIGV"  maxlength="100" readonly="readonly" value="<?= $cabeceraNota['totalIGV']; ?>" style="background-color: #d1d1d1;" /></td>
                                            <td width="70">&nbsp;</td>
                                            <td width="70">Total Venta:</td>
                                            <td>
                                            	<input id="totalVenta"  maxlength="100" readonly="readonly" value="<?= $cabeceraNota['totalVenta']; ?>" style="background-color: #d1d1d1;" /></td>
                                        	<td>&nbsp;</td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                  
                        </div>
                        <!-- /.col-lg-12 -->
                  
                    </div>            
                    <!-- /.row -->
      
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

                    <input type="hidden" id="idCabeceraNota" value="<?= $cabeceraNota['idCabeceraNota']; ?>" />
                    <input type="hidden" id="idTipoNota" value="<?= $cabeceraNota['idTipoNota']; ?>" />
                    <input type="hidden" id="tipoNota" value="<?= $cabeceraNota['tipoNota']; ?>" />
                    <input type="hidden" id="idComprobantePagoRef" value="<?= $cabeceraNota['idComprobantePagoRef']; ?>" />
                    <input type="hidden" id="accion" value="<?= $accion; ?>" />
                   	
                    <input type="hidden" id="idCliente"  value="<?= $cabeceraNota['idCliente']; ?>" />
                    <input type="hidden" id="idDireccionActual"  value="<?= $cabeceraNota['idDireccionActual']; ?>" />
                    <input type="hidden" id="idDepartamento" value="<?= $cabeceraNota['idDepartamento']; ?>" />
                    <input type="hidden" id="idProvincia" value="<?= $cabeceraNota['idProvincia']; ?>" />
                    <input type="hidden" id="idDistrito" value="<?= $cabeceraNota['idDistrito']; ?>" />
                    
                    
         
<div id="popupBuscarClienteDiv">
    <div style="overflow: hidden;">	</div>
    <div id="formBuscarClienteDiv"></div>
</div>

         
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
		
		$("#serieNumeroNota").jqxInput({ width: '120px', height: '20px' });
		$("#serieNumeroCPRef").jqxInput({ width: '120px', height: '20px' });
			
		$("#fechaEmision").jqxDateTimeInput( {width: '100px', height: '20px', formatString: "dd/MM/yyyy" });
		$("#fechaEmision").jqxDateTimeInput({ culture: 'es-ES' });
		
		$("#fechaEmisionCPRef").jqxDateTimeInput( {width: '100px', height: '20px', formatString: "dd/MM/yyyy" });
		$("#fechaEmisionCPRef").jqxDateTimeInput({ culture: 'es-ES' });
		
		/*
		$("#tipoVia").jqxInput({ width: '200px', height: '20px' });
		$("#nombreVia").jqxInput({ width: '200px', height: '20px' });
		$("#numero").jqxInput({ width: '130px', height: '20px' });
		$("#interior").jqxInput({ width: '130px', height: '20px' });
		$("#zonaP").jqxInput({ width: '130px', height: '20px' });
		$("#departamento").jqxInput({ width: '130px', height: '20px' });
		$("#provincia").jqxInput({ width: '130px', height: '20px' });
		$("#distrito").jqxInput({ width: '130px', height: '20px' });
		*/
		
		$("#cliente").jqxInput({ width: '600px', height: '20px' });
		$("#documentoIdentidad").jqxInput({ width: '100px', height: '20px' });
		$("#numeroDocumentoIdentidad").jqxInput({ width: '150px', height: '20px' });
		$("#direccionActual").jqxInput({ width: '900px', height: '20px' });
		
		//$("#totalLetras").jqxInput({ width: '90%', height: '20px' });
		$("#totalImporte").jqxInput({ width: '150px', height: '20px', rtl: true });
		$("#totalIGV").jqxInput({ width: '150px', height: '20px', rtl: true });
		$("#totalVenta").jqxInput({ width: '150px', height: '20px', rtl: true });
		
		$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
		
		
		var fechaEmision = "<?= $cabeceraNota['fechaEmision']; ?>";
		if(fechaEmision !=""){
			var fechaEmisionArray = fechaEmision.split('-');
			$("#fechaEmision").jqxDateTimeInput('setDate', new Date(fechaEmisionArray[0], fechaEmisionArray[1]-1, fechaEmisionArray[2]));
		}
			                                                                                          
		var accion = $("#accion").val();
		if(accion == "1"){
			//$("#btnBuscarClienteDiv").show();
			$("#fechaEmision").jqxDateTimeInput({ disabled: true });
		}
		
		var idCabeceraNota = $("#idCabeceraNota").val();
		
		$("#detalleNotaDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#detalleNotaDiv").load("ventas/nota/detalleNota.php?p="+Math.random(), {idCabeceraNota: idCabeceraNota});
    });
	
	
	$("#btnNuevo").click(function () {
		if (confirm(" Esta seguro de limpiar los datos del comprobante para crear uno nuevo ?")) {
			Ir_A_Pagina('ventas/nota/cabeceraNota');
		}
	});
	
	$("#btnGrabar").click(function () {
		Grabar_Nota();					
	});
	
	$("#btnRegresar").click(function () {
		Ir_A_Pagina('ventas/nota/filtroNota');
	});	
		

	//Popup Buscar CLiente
	$("#popupBuscarClienteDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900", 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarClienteDiv").on('open', function () {
		Limpiar_Popups();
		//var tipoCliente = $("#tipoClienteBuscar").val();
		//alert("tipoCliente 2:"+tipoCliente);
		$("#formBuscarClienteDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarClienteDiv").load("ventas/buscar_cliente/filtroCliente.php?p="+Math.random());
        
	});		
	
	function Abrir_Popup_Buscar_Cliente(){
		Limpiar_Popups();
		//$("#tipoCliente").val("");
		//$("#tipoCliente").val(tipoCliente);
		//alert("tipoCliente seteado:"+$("#tipoCliente").val());
		//alert("tipoCliente enviado:"+tipoCliente);
		
        $('#popupBuscarClienteDiv').jqxWindow('setTitle', 'Buscar Cliente');
        $("#popupBuscarClienteDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Cliente(){
		$("#popupBuscarClienteDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Cliente(){
		$("#idCliente").val("");
		$("#cliente").val("");
		$("#documentoIdentidad").val("");
		$("#numeroDocumentoIdentidad").val("");
	}	

	function Seleccionar_Cliente(){
		//var tipoCliente = $("#tipoCliente").val();
		//alert("tipoCliente selec:"+tipoCliente);
		Limpiar_Cliente();
		
		var rowscount = $("#jqxGridListaCliente").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaCliente").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaCliente").jqxGrid('getrowid', selectedrowindex);
			var dataListaCliente = $("#jqxGridListaCliente").jqxGrid('getrowdata', selectedrowindex);
			//alert("idDireccionActual: "+dataListaCliente.idDireccionActual);
			if($.trim(dataListaCliente.idDireccionActual) > 0){
				
				$("#idCliente").val($.trim(dataListaCliente.idCliente));
				$("#cliente").val($.trim(dataListaCliente.cliente));			
				$("#documentoIdentidad").val($.trim(dataListaCliente.documentoIdentidad));
				$("#numeroDocumentoIdentidad").val($.trim(dataListaCliente.numeroDocumentoIdentidad));
				$("#idDireccionActual").val($.trim(dataListaCliente.idDireccionActual));
				$("#direccionActual").val($.trim(dataListaCliente.direccionActual));
				
								
				Obtener_Direccion_Cliente(dataListaCliente.idDireccionActual, "ACT");
			}else{				
				Mostrar_Mensaje_Notificacion("warning","No se econtro la direccion actual del cliente");
			}

						
			Cerrar_Popup_Buscar_Cliente();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
		}		
	}
	
	
    function Obtener_Direccion_Cliente(idDireccion, claveTipoDireccion){
       		
        $.ajax({
	  		type: "POST",
	   		url : "ventas/buscar_cliente/dataDireccionCliente.php?p="+Math.random(),
            data: {idDireccion:idDireccion, claveTipoDireccion:claveTipoDireccion},
	   		success: function(response){
                //console.log(response);																																																																					
				
				$("#message"+claveTipoDireccion).text(response.data.message);
				
				if (response.success) {
					//console.log(response.data.entity);
					//console.log(response.data.entity['nombreVia']);
					//console.log(response.data.message);
					//console.log(response.data.entity.nombreVia);	
					
					$("#tipoVia"+claveTipoDireccion).val(response.data.entity.tipoVia);
					$("#nombreVia"+claveTipoDireccion).val(response.data.entity.nombreVia);
					$("#numero"+claveTipoDireccion).val(response.data.entity.numero);
					$("#interior"+claveTipoDireccion).val(response.data.entity.interior);
					$("#zona"+claveTipoDireccion).val(response.data.entity.zona);
					$("#departamento"+claveTipoDireccion).val(response.data.entity.departamento);
					$("#provincia"+claveTipoDireccion).val(response.data.entity.provincia);
					$("#distrito"+claveTipoDireccion).val(response.data.entity.distrito);
					
					$("#message"+claveTipoDireccion).hide();
			
				}																																																																																
			                
	   		},
	   		error: function(){	   			
				Mostrar_Mensaje_Notificacion("warning","Se ha producido un error");
	   		}
	 	});
    }
		

				
	function Limpiar_Popups(){
		$("#formBuscarClienteDiv").html("");
		$("#formBuscarGRDiv").html("");
		$("#formBuscarProductoDiv").html("");
	}	
		
	function Enter_Buscar(e){	
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}		
	}
	
	
	function Validar_Cabecera_Nota(){
		
		if($.trim($("#cboComprobantePagoRef").val()) == "" || $.trim($("#cboComprobantePagoRef").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el comprobante de pago que modifica");
			return false;	
		}
		if($.trim($("#serieNumeroCPRef").val()) == ""){
			Mostrar_Mensaje_Notificacion("warning","Debe ingresar la S/N del comprobante de pago que modifica");
			return false;	
		}
		if($.trim($("#cboMotivoNota").val()) == "" || $.trim($("#cboMotivoNota").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el motivo");
			return false;	
		}
		if($.trim($("#cboMoneda").val()) == "" || $.trim($("#cboMoneda").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar la moneda");
			return false;	
		}
		if($.trim($("#idCliente").val()) == "" || $.trim($("#idCliente").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el cliente");
			return false;	
		}
		if($.trim($("#cboComprobantePagoRef option:selected").text()) == "FACTURA" && $.trim($("#documentoIdentidad").val()) == "DNI"){
			Mostrar_Mensaje_Notificacion("warning","No se puede emitir FACTURA para el cliente con DNI");
			return false;	
		}
		if($.trim($("#cboComprobantePagoRef option:selected").text()) == "BOLETA" && $.trim($("#documentoIdentidad").val()) == "RUC"){
			Mostrar_Mensaje_Notificacion("warning","No se puede emitir BOLETA para el cliente con RUC");
			return false;	
		}
		
		return true;
	}
	
	
	
	function Grabar_Nota(){
		
		var accion = $("#accion").val();
				
		if(!Validar_Cabecera_Nota()){
			return false;
		}
		if(!Validar_Detalle_Nota()){
			return false;
		}		
		
		if(!confirm(" ¿ Esta seguro de grabar la factura/boleta ?")){
            return false;
        }
		
		
		var cabecera_nota = 
		{
			idCabeceraNota			: $.trim($("#idCabeceraNota").val()),
			idTipoNota				: $.trim($("#idTipoNota").val()),
			tipoNota				: $.trim($("#tipoNota").val()),
			serieNumeroNota			: $.trim($("#serieNumeroNota").val()),
			fechaEmision			: $.trim($("#fechaEmision").val()),
			idComprobantePagoRef	: $.trim($("#cboComprobantePagoRef").val()),
			comprobantePagoRef		: $.trim($('select[name="cboComprobantePagoRef"] option:selected').text()),
			serieNumeroCPRef		: $.trim($("#serieNumeroCPRef").val()),
			fechaEmisionCPRef		: $.trim($("#fechaEmisionCPRef").val()),
			idCliente				: $.trim($("#idCliente").val()),
			cliente					: $.trim($("#cliente").val()),
			documentoIdentidad		: $.trim($("#documentoIdentidad").val()),
			numeroDocumentoIdentidad: $.trim($("#numeroDocumentoIdentidad").val()),
			idDireccionActual		: $.trim($("#idDireccionActual").val()),
			direccionActual			: $.trim($("#direccionActual").val()),
			idMotivoNota			: $.trim($("#cboMotivoNota").val()),
			motivoNota				: $.trim($('select[name="cboMotivoNota"] option:selected').text()),
			idMoneda				: $.trim($("#cboMoneda").val()),
			moneda					: $.trim($('select[name="cboMoneda"] option:selected').text()),
			totalImporte			: $.trim($("#totalImporte").val()),
			totalIGV				: $.trim($("#totalIGV").val()),
			totalVenta				: $.trim($("#totalVenta").val())
		};
		/*	
		console.log("***INICIO CAB Nota***");
		console.log(cabecera_nota);
		console.log("***FIN CAB Nota***");
		*/
		Grabar_Cabecera_Nota(accion, cabecera_nota);
		
		//Grabar_Detalle_Nota("0", "1");
		
	}
	
	function Grabar_Cabecera_Nota(accion, cabecera_nota){
		//alert(accion);
		$.ajax({
			type: "POST",            
			url: "ventas/nota/saveCabeceraNota.php?p="+Math.random(),
			data: { accion: accion, cabecera_nota: cabecera_nota },
			success: function(response){
				/*
				console.log("***RPTA CAB Nota***");
				console.log("accion: "+accion+" ****");
				console.log(response);
				console.log("***RPTA CAB Nota***");
				*/
				if (response.success) {
					//console.log(response.data.entity);
					//console.log(response.data.message);
					//console.log(response.data.entity.idCabeceraNota);						
					var idCabeceraNota = response.data.entity.idCabeceraNota;
					//console.log("idCabeceraNota:"+idCabeceraNota);
					Grabar_Detalle_Nota(accion, idCabeceraNota);
  
				}else{
                    Mostrar_Mensaje_Notificacion("error","No se logro grabar la guia de remision");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso");
			}
		})
		
	}
	
	function Validar_Detalle_Nota(){
		
		var totalFilas = parseInt($("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount);
		
		if(totalFilas == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe agregar un detalle.");
			return false;
		}
		
		for(i=0; i<totalFilas; i++){
			var rowId = $("#jqxGridDetalle").jqxGrid('getrowid', i);
			var rowGrid = $("#jqxGridDetalle").jqxGrid('getrowdatabyid', rowId);
			if( $.trim(rowGrid['descripcion']) == "" ){
				Mostrar_Mensaje_Notificacion("warning","Debe ingresar la descripcion en el detalle.");
				//Mostrar_Mensaje_Notificacion("warning","Debe ingresar la descripcion "+ $.trim(rowGrid['descripcion']) +" en el detalle.");
				return false;
			}
			if( $.trim(rowGrid['importe']) == "" || $.trim(rowGrid['importe']) == "0" || $.trim(rowGrid['importe']) == "0.00" ){
				Mostrar_Mensaje_Notificacion("warning","Debe ingresar el importe en el detalle.");
				//Mostrar_Mensaje_Notificacion("warning","Debe ingresar la descripcion "+ $.trim(rowGrid['descripcion']) +" en el detalle.");
				return false;
			}
		}
		
		return true;
	}
	
	function Grabar_Detalle_Nota(accion, idCabeceraNota){
		
		var dataDetalle = Obtener_Data_Grid("jqxGridDetalle");
		console.log(dataDetalle);
		//var exportedXML = JSON.parse($("#jqxGridDetalle").jqxGrid("exportdata", "json"));
		//console.log(exportedXML);
		
		$.ajax({
			type: "POST",
			url : "ventas/nota/saveDetalleNota.php?p="+Math.random(),
			data : {accion: accion,  idCabeceraNota: idCabeceraNota, dataDetalle: dataDetalle},
			success: function(response){
				/*
				console.log("***INICIO DET Nota***");
				console.log("accion: "+accion+" ****");
				console.log(response);
				console.log("***FIN DET Nota***");
				*/
				
				if (response.success) {
					Mostrar_Mensaje_Notificacion("success","Se grabo la nota satisfactoriamente");
					Ir_A_Pagina('ventas/nota/filtroNota');
				}else{
                    Mostrar_Mensaje_Notificacion("error","Ocurrio un error al generar el detalle de la nota");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
			}
		});
		
		
	}

            
</script>
