<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
	$idCabeceraFB = $_POST['idCabeceraFB'];
	$accion = $_POST['accion'];
	$cabeceraFB['idCabeceraFB'] = "0";
	
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){

			$rsCabeceraFB =  $objdb -> sqlGetCabeceraFacturaBoleta($idEmpresa, $idCabeceraFB);
			
			if (mysql_num_rows($rsCabeceraFB)==1){
				$cabeceraFB = mysql_fetch_array($rsCabeceraFB);
				//print_r(json_encode($cabeceraFB));	
				$idComprobantePago = $cabeceraFB['idComprobantePago'];
				$idFormaPago = $cabeceraFB['idFormaPago'];
				$idMoneda = $cabeceraFB['idMoneda'];
            }	
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<b>Nueva Factura / Boleta</b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-9">
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
                                            <td width="70">&nbsp;</td>
                                    		<td width="120">Comprobante:</td>
                                       		<td width="150">
                                                <select id="cboComprobantePago" name="cboComprobantePago" style="width:150px;">
                                                  <option value="0">[SELECCIONAR]</option>	
                                                    <?php
                                                        $rsListaComprobantePago= $objdb -> sqlListaComprobantePago($idEmpresa, "U");
                                                        if (mysql_num_rows($rsListaComprobantePago)!=0){
                                                        	while ($rowComprobantePago = mysql_fetch_array($rsListaComprobantePago)){
                                                        		$idComprobantePagoX = $rowComprobantePago["idComprobantePago"];
                                                        		$comprobantePagoX = $rowComprobantePago["comprobantePago"];
                                                        		
                                                        		if($idComprobantePagoX==$idComprobantePago){
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
                                            <td width="70">&nbsp;</td>
                                    		<td width="120">Serie Numero:</td>
                                       		<td>
                                                <div id="nroFBDiv">
                                                    <input type="text" id="serieNumeroFB" value="<?= $cabeceraFB['serieNumeroFB']; ?>" readonly="readonly" />
                                                </div>
                                            </td>
                                        </tr>
                    					<tr style="height:25px;">
                                    		<td width="120">Forma Pago:</td>
                                       		<td width="150">
                                            	<select id="cboFormaPago" name="cboFormaPago" style="width:150px;">
                                                  <option value="0">[SELECCIONAR]</option>	
                                                    <?php
                                                        $rsListaFormaPago= $objdb -> sqlListaFormaPago($idEmpresa);
                                                        if (mysql_num_rows($rsListaFormaPago)!=0){
                                                        	while ($rowFormaPago = mysql_fetch_array($rsListaFormaPago)){
                                                        		$idFormaPagoX = $rowFormaPago["idFormaPago"];
                                                        		$formaPagoX = $rowFormaPago["formaPago"];
                                                        		
                                                        		if($idFormaPagoX==$idFormaPago){
                                                        ?>			
                                                        			<option value="<?= $idFormaPagoX; ?>" selected="selected"><?= $formaPagoX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idFormaPagoX; ?>" ><?= $formaPagoX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaFormaPago);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="70">&nbsp;</td>
                                    		<td width="120">Moneda:</td>
                                       		<td width="150">
												<select id="cboMoneda" name="cboMoneda" style="width:150px;">
                                                  <option value="0">[SELECCIONAR]</option>	
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
                                            <td width="70">&nbsp;</td>
                                    		<td width="120">S/N Guia Ref:</td>
                                       		<td>
                                                <div id="nroFBDiv">
                                                    <input type="text" id="serieNumeroGRef" value="<?= $cabeceraFB['serieNumeroGRef']; ?>" />
                                                </div>
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>

                        </div>
                        <!-- /.col-lg-12 -->
                        
						<div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">                    
                    					<tr style="height:20px;" align="center">
                                       		<td>
                                                <div style="padding:0px;">
                                                    <button id="btnNuevo" class="btn btn-warning" >
                                                    	<i class="icon-search"></i> Nuevo &nbsp;</button>&nbsp;&nbsp;&nbsp;
                                                    <button id="btnGrabar" class="btn btn-info" >
                                                    	<i class="icon-search"></i> Guardar</button>&nbsp;&nbsp;&nbsp;
                                                    <button id="btnRegresar" class="btn btn-danger" >
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
                                            	<input id="cliente"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraFB['cliente']; ?>" />
                                            </td>
                                            <td width="70">&nbsp;</td>
                                            <td width="100">Doc. Identidad:</td>
                                        	<td>
                                            	<input id="documentoIdentidad"  maxlength="200" style="width:250px;" readonly="readonly" value="<?= $cabeceraFB['documentoIdentidad']; ?>" />
                                            </td>
	                                        <td width="70">&nbsp;</td>
                                            <td width="100">Nro Documento:</td>
                                        	<td>
                                            	<input id="numeroDocumentoIdentidad"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraFB['numeroDocumentoIdentidad']; ?>" />
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
                                            	<input id="direccionActual"  maxlength="200" style="width:600px;" readonly="readonly" value="<?= $cabeceraFB['direccion']; ?>" />
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
								<div id="detalleFacturaBoletaDiv"></div>
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
                                   			<td width="100">SON:</td>
                                        	<td width="800" colspan="8">
                                            	<input id="totalLetras"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraFB['totalLetras']; ?>" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td width="70">&nbsp;</td>
                                            <td width="70">Sub Total:</td>
                                        	<td>
                                            	<input id="totalImporte"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraFB['totalImporte']; ?>" />
                                            </td>
                                            <td width="70">&nbsp;</td>
	                                        <td width="70">I.G.V. %:</td>
                                            <td>
                                            	<input id="totalIGV"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraFB['totalIGV']; ?>" /></td>
                                            <td width="70">&nbsp;</td>
                                            <td width="70">Total Venta:</td>
                                            <td>
                                            	<input id="totalVenta"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraFB['totalVenta']; ?>" /></td>
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

                    <input type="hidden" id="idCabeceraFB" value="<?= $cabeceraFB['idCabeceraFB']; ?>" />
                    <input type="hidden" id="idComprobantePago" value="<?= $cabeceraFB['idComprobantePago']; ?>" />
                    <input type="hidden" id="accion" value="<?= $accion; ?>" />
                   	
                    <input type="hidden" id="idCliente"  value="<?= $cabeceraFB['idCliente']; ?>" />
                    <input type="hidden" id="idDireccionActual"  value="<?= $cabeceraFB['idDireccionActual']; ?>" />
                    <input type="hidden" id="idDepartamento" value="<?= $cabeceraFB['idDepartamento']; ?>" />
                    <input type="hidden" id="idProvincia" value="<?= $cabeceraFB['idProvincia']; ?>" />
                    <input type="hidden" id="idDistrito" value="<?= $cabeceraFB['idDistrito']; ?>" />
                    
                    
         
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
		
		$("#serieNumeroFB").jqxInput({ width: '120px', height: '20px' });
		$("#serieNumeroGRef").jqxInput({ width: '120px', height: '20px' });
			
		$("#fechaEmision").jqxDateTimeInput( {width: '100px', height: '20px', formatString: "dd/MM/yyyy" });
		$("#fechaEmision").jqxDateTimeInput({ culture: 'es-ES' });
		
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
		
		$("#totalLetras").jqxInput({ width: '90%', height: '20px' });
		$("#totalImporte").jqxInput({ width: '150px', height: '20px' });
		$("#totalIGV").jqxInput({ width: '150px', height: '20px' });
		$("#totalVenta").jqxInput({ width: '150px', height: '20px' });
		
		$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
		
		
		var fechaEmision = "<?= $cabeceraFB['fechaEmision']; ?>";
		if(fechaEmision !=""){
			var fechaEmisionArray = fechaEmision.split('-');
			$("#fechaEmision").jqxDateTimeInput('setDate', new Date(fechaEmisionArray[0], fechaEmisionArray[1]-1, fechaEmisionArray[2]));
		}
			                                                                                          
		var accion = $("#accion").val();
		if(accion == "1"){
			//$("#btnBuscarClienteDiv").show();
			$("#fechaEmision").jqxDateTimeInput({ disabled: true });
		}
		
		var idCabeceraFB = $("#idCabeceraFB").val();
		
		$("#detalleFacturaBoletaDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#detalleFacturaBoletaDiv").load("ventas/factura_boleta/detalleFacturaBoleta.php?p="+Math.random(), {idCabeceraFB: idCabeceraFB});
    });
	
	
	$("#btnNuevo").click(function () {
		if (confirm(" Esta seguro de limpiar los datos del comprobante para crear uno nuevo ?")) {
			Ir_A_Pagina('ventas/factura_boleta/cabeceraFacturaBoleta');
		}
	});
	
	$("#btnGrabar").click(function () {
		Grabar_Factura_Boleta();					
	});
	
	$("#btnRegresar").click(function () {
		Ir_A_Pagina('ventas/factura_boleta/filtroFacturaBoleta');
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
				alert("No se econtro la direccion actual del cliente");
				
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
	
	
	function Validar_Cabecera_Factura_Boleta(){
		
		if($.trim($("#cboComprobantePago").val()) == "" || $.trim($("#cboComprobantePago").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el comprobante");
			return false;	
		}
		if($.trim($("#cboFormaPago").val()) == "" || $.trim($("#cboFormaPago").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar la forma de pago");
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
		return true;
	}
	
	
	
	function Grabar_Factura_Boleta(){
		
		var accion = $("#accion").val();
				
		if(!Validar_Cabecera_Factura_Boleta()){
			return false;
		}
		if(!Validar_Detalle_Factura_Boleta()){
			return false;
		}		
		
		if(!confirm(" ¿ Esta seguro de grabar la factura/boleta ?")){
            return false;
        }
		
		
		var cabecera_factura_boleta = 
		{
			idCabeceraFB			: $.trim($("#idCabeceraFB").val()),
			serieNumeroFB			: $.trim($("#serieNumeroFB").val()),
			serieNumeroGRef			: $.trim($("#serieNumeroGRef").val()),
			fechaEmision			: $.trim($("#fechaEmision").val()),
			idComprobantePago		: $.trim($("#cboComprobantePago").val()),
			comprobantePago			: $.trim($('select[name="cboComprobantePago"] option:selected').text()),
			idFormaPago				: $.trim($("#cboFormaPago").val()),
			formaPago				: $.trim($('select[name="cboFormaPago"] option:selected').text()),
			idMoneda				: $.trim($("#cboMoneda").val()),
			moneda					: $.trim($('select[name="cboMoneda"] option:selected').text()),
			idCliente				: $.trim($("#idCliente").val()),
			cliente					: $.trim($("#cliente").val()),
			documentoIdentidad		: $.trim($("#documentoIdentidad").val()),
			numeroDocumentoIdentidad: $.trim($("#numeroDocumentoIdentidad").val()),
			idDireccionActual		: $.trim($("#idDireccionActual").val()),
			direccionActual			: $.trim($("#direccionActual").val()),
			totalLetras				: $.trim($("#totalLetras").val()),
			totalImporte			: $.trim($("#totalImporte").val()),
			totalIGV				: $.trim($("#totalIGV").val()),
			totalVenta				: $.trim($("#totalVenta").val())
		};
		/*		
		console.log("***INICIO CAB FB***");
		console.log(cabecera_factura_boleta);
		console.log("***FIN CAB FB***");
		*/
		Grabar_Cabecera_Factura_Boleta(accion, cabecera_factura_boleta);
		
	}
	
	function Grabar_Cabecera_Factura_Boleta(accion, cabecera_factura_boleta){
		//alert(accion);
		$.ajax({
			type: "POST",            
			url: "ventas/factura_boleta/saveCabeceraFacturaBoleta.php?p="+Math.random(),
			data: { accion: accion, cabecera_factura_boleta: cabecera_factura_boleta },
			success: function(response){
				/*
				console.log("***INICIO CAB FB***");
				console.log("accion: "+accion+" ****");
				console.log(response);
				console.log("***FIN CAB FB***");
				*/
				if (response.success) {
					//console.log(response.data.entity);
					//console.log(response.data.message);
					//console.log(response.data.entity.idCabeceraFB);						
					var idCabeceraFB = response.data.entity.idCabeceraFB;
					//console.log("idCabeceraFB:"+idCabeceraFB);
					Grabar_Detalle_Factura_Boleta(accion, idCabeceraFB);
  
				}else{
                    Mostrar_Mensaje_Notificacion("error","No se logro grabar la guia de remision");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso");
			}
		})
		
	}
	
	function Validar_Detalle_Factura_Boleta(){
		
		var totalFilas = parseInt($("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount);
		
		if(totalFilas == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe agregar productos y/o servicios al detalle.");
			return false;
		}
		/*
		for(i=0; i<totalFilas; i++){
			var rowId = $("#jqxGridDetalle").jqxGrid('getrowid', i);
			var rowGrid = $("#jqxGridDetalle").jqxGrid('getrowdatabyid', rowId);
			if( $.trim(rowGrid['cantidad']) == 0 ){
				Mostrar_Mensaje_Notificacion("warning","Debe ingresar la cantidad del producto "+ $.trim(rowGrid['descripcion']) +" en el detalle.");
				return false;
			}
		}
		*/		
		return true;
	}
	
	function Grabar_Detalle_Factura_Boleta(accion, idCabeceraFB){
		
		var dataDetalle = Obtener_Data_Grid("jqxGridDetalle");
		//console.log(dataDetalle);
		//var exportedXML = JSON.parse($("#jqxGridDetalle").jqxGrid("exportdata", "json"));
		//console.log(exportedXML);
		
		$.ajax({
			type: "POST",
			url : "ventas/factura_boleta/saveDetalleFacturaBoleta.php?p="+Math.random(),
			data : {accion: accion,  idCabeceraFB: idCabeceraFB, dataDetalle: dataDetalle},
			success: function(response){
				/*
				console.log("***INICIO DET FB***");
				console.log("accion: "+accion+" ****");
				console.log(response);
				console.log("***FIN DET FB***");
				*/
				if (response.success) {
					Mostrar_Mensaje_Notificacion("success","Se grabo la factura/boleta satisfactoriamente");
					Ir_A_Pagina('ventas/factura_boleta/filtroFacturaBoleta');
				}else{
                    Mostrar_Mensaje_Notificacion("error","Ocurrio un error al generar el detalle de la factura/boleta");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
			}
		});
		
		
	}
	
	
	
	/*
	function Actualizar_DataGR(){
		generarGR = $.trim($("#generarGRCab").val());
				
		if(generarGR == "1"){
			$("#seccionGRDiv").show();
			$("#seccionGRDiv").load("ventas/factura_boleta/seccionGR.php?p="+Math.random());
			
		}else{
			$("#seccionGRDiv").html("");
		}		
	}
	

    function Actualizar_Provincia_PAR(){
        var tabla = "provincia";
        var nombreCampoPadre = "idDepartamento";
        var valorIdPadre = $("#cboDepartamentoPAR").val();
        var nombreIdPrincipal = "idProvincia";
        var nombreCampoDescripcion = "provincia";
       
       	$("#cboDistritoPAR").html("");
       	$("#cboDistritoPAR").append("<option value='0'>[SELECCIONAR]</option>");
        
        $.ajax({
	  		type: "POST",
	   		url : "comunes/combos/dataComboUbigeoDependiente.php?p="+Math.random(),
            data: {tabla:tabla, nombreCampoPadre:nombreCampoPadre, valorIdPadre:valorIdPadre, nombreIdPrincipal:nombreIdPrincipal,nombreCampoDescripcion:nombreCampoDescripcion},
            //url: "maestros/distrito/cmbProvincias.php?p="+Math.random(),
	   		//data: {idDepartamento:idDepartamento},            
	   		success: function(dataResult){
                //console.log(dataResult);
                $("#cboProvinciaPAR").html("");
                $("#cboProvinciaPAR").append(dataResult);
	   		},
	   		error: function(){
	   			alert("Se ha producido un error");
	   		}
	 	});
    }
                                        
    function Actualizar_Distrito_PDA(){
        var tabla = "distrito";
        var nombreCampoPadre = "idProvincia";
        var valorIdPadre = $("#cboProvinciaPAR").val();
        var nombreIdPrincipal = "idDistrito";
        var nombreCampoDescripcion = "distrito";
       
        $.ajax({
	  		type: "POST",
	   		url : "comunes/combos/dataComboUbigeoDependiente.php?p="+Math.random(),
            data: {tabla:tabla, nombreCampoPadre:nombreCampoPadre, valorIdPadre:valorIdPadre, nombreIdPrincipal:nombreIdPrincipal,nombreCampoDescripcion:nombreCampoDescripcion},            
	   		success: function(dataResult){
                console.log(dataResult);
                $("#cboDistritoPAR").html("");
                $("#cboDistritoPAR").append(dataResult);
	   		},
	   		error: function(){
	   			alert("Se ha producido un error");
	   		}
	 	});
    }	

    function Actualizar_Provincia_LLE(){
        var tabla = "provincia";
        var nombreCampoPadre = "idDepartamento";
        var valorIdPadre = $("#cboDepartamentoLLE").val();
        var nombreIdPrincipal = "idProvincia";
        var nombreCampoDescripcion = "provincia";
       
       $("#cboDistritoLLE").html("");
       $("#cboDistritoLLE").append("<option value='0'>[SELECCIONAR]</option>");
         
       
        $.ajax({
	  		type: "POST",
	   		url : "comunes/combos/dataComboUbigeoDependiente.php?p="+Math.random(),
            data: {tabla:tabla, nombreCampoPadre:nombreCampoPadre, valorIdPadre:valorIdPadre, nombreIdPrincipal:nombreIdPrincipal,nombreCampoDescripcion:nombreCampoDescripcion},
            //url: "maestros/distrito/cmbProvincias.php?p="+Math.random(),
	   		//data: {idDepartamento:idDepartamento},            
	   		success: function(dataResult){
                //console.log(dataResult);
                $("#cboProvinciaLLE").html("");
                $("#cboProvinciaLLE").append(dataResult);
	   		},
	   		error: function(){
	   			alert("Se ha producido un error");
	   		}
	 	});
    }
                                        
    function Actualizar_Distrito_LLE(){
        var tabla = "distrito";
        var nombreCampoPadre = "idProvincia";
        var valorIdPadre = $("#cboProvinciaLLE").val();
        var nombreIdPrincipal = "idDistrito";
        var nombreCampoDescripcion = "distrito";
       
        $.ajax({
	  		type: "POST",
	   		url : "comunes/combos/dataComboUbigeoDependiente.php?p="+Math.random(),
            data: {tabla:tabla, nombreCampoPadre:nombreCampoPadre, valorIdPadre:valorIdPadre, nombreIdPrincipal:nombreIdPrincipal,nombreCampoDescripcion:nombreCampoDescripcion},            
	   		success: function(dataResult){
                console.log(dataResult);
                $("#cboDistritoLLE").html("");
                $("#cboDistritoLLE").append(dataResult);
	   		},
	   		error: function(){
	   			alert("Se ha producido un error");
	   		}
	 	});
	}
	*/
            
</script>
