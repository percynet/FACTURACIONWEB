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
    
		if(isset($_POST['parametros'])){
			$parametros = $_POST['parametros'];
			//print_r($parametros);
			//echo "COMP:".$parametros['comprobante'];
			
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            	Almacen : <?= $parametros['almacen']; ?>  /  Nueva <?= $parametros['comprobante']; ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:30px;">    
                                   			<td width="70">Cliente:</td>
                                        	<td>
                                           		<input type="hidden" id="idClienteCab"  value="" />
                                            	<input id="clienteCab"  maxlength="100" style="width:200px;" readonly />
                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>
                                   		  	<td width="30"><div id='lblDocumentoIdentidadCab' ></div></td>
                                       	  	<td>
                                          		<input id="nroDocumentoIdentidadClienteCab"  maxlength="11" style="width:20px;" readonly />
                                            </td>                                          	
                                            <td style="width: 20px;">
                                           		<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Cliente();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>
                                    		<td width="100">Fecha Emision:</td>
                                       		<td>
                                                <div id="fechaEmisionDiv">
                                                    <div style='margin-top: 3px;' id='fechaEmisionCab' />
                                                </div>
                                            </td>
                                            <td style="width: 20px;">
                                            </td>
                                        </tr>
                                        <tr style="height:30px;">
   											<td width="70">Direccion:</td>
                                       		<td colspan="1">
                                            	<input  id="direccionClienteCab" maxlength="100" style="width:300px;" readonly />                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>
                                   		  	<td width="30">Moneda:</td>
                                       	  	<td>
                                            	<select name="cboMonedaCab" id="cboMonedaCab" style="width:100px;" >
												<?php
                                                    $rsListaMoneda = $objdb -> sqlListaMoneda('ACTIVO');
                                                    if (mysql_num_rows($rsListaMoneda)!=0){
                                                        while ($rowMoneda = mysql_fetch_array($rsListaMoneda)){
                                                            $idMonedaX = $rowMoneda["idMoneda"];
                                                            $monedaX = $rowMoneda["moneda"];
                                                ?>
                                                             <option value="<?= $idMonedaX; ?>" ><?= $monedaX; ?></option>
                                                <?php
                                                        }
                                                        mysql_free_result($rsListaMoneda);
                                                    }
                                                ?>
                                                </select>
                                            </td>
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-success" onclick="Limpiar_Cliente();">
                                                    	<i class="icon-search"></i> Limpiar</button>
                                                </div>
                                            </td>
                                            <td>&nbsp;</td>
                                           
                                            <td width="100"><div id="generarGRDiv">Generar G/R:</div></td>
                                       		<td>   
                                            	<div id="facturaDiv">
                                               	<select name="generarGRCab" id="generarGRCab" style="width:50px;" onchange="Actualizar_DataGR();" >
                                                  <option value="0">NO</option>
                                                  <option value="1">SI</option>
                                                </select>
                                                </div>
                                            </td>
                                            
                                            <td width="10">
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                            <div id="seccionGRDiv">

                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>            
                    <!-- /.row -->
                    <input type="hidden" id="idFacturaBoletaCab" value="" />
                    <input type="hidden" id="idGuiaRemisionCab" value="" />
                	<input type="hidden" id="idComprobanteCab" value="<?= $parametros['idComprobante']; ?>" />
                    <input type="hidden" id="comprobanteCab" value="<?= $parametros['comprobante']; ?>" />
                    <input type="hidden" id="idAlmacenCab" value="<?= $parametros['idAlmacen']; ?>" />
                    <input type="hidden" id="almacenCab" value="<?= $parametros['almacen']; ?>" />
                    <input type="hidden" id="idDocumentoIdentidadCab" value="" />
                    <!--<input type="hidden" id="idMonedaCab" value="" />-->
                    
                   	<div id="detalleFacturaBoletaDiv"></div>
                    
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
         
        <div id="popupBuscarClienteDiv">
            <div style="overflow: hidden;"></div>
            <div id="formBuscarClienteDiv"></div>
        </div>
        
        <div id="popupBuscarAgenciaDiv">
            <div style="overflow: hidden;"></div>
            <div id="formBuscarAgenciaDiv"></div>
        </div>        
                 
<?php
		}else{
			$sMessage = "No se enviaron los parametros";
			header("Location: error.php?msgError=".$sMessage);
			exit();
		}


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
			
		$("#fechaEmisionCab").jqxDateTimeInput( {width: '100px', height: '20px' });
		
		$("#clienteCab").jqxInput({ width: '300px', height: '20px' });
		$("#nroDocumentoIdentidadClienteCab").jqxInput({ width: '100px', height: '20px' });
		$("#direccionClienteCab").jqxInput({ width: '400px', height: '20px' });
		
		//$("#monedaCab").jqxInput({ width: '70px', height: '20px' });
		
		/*
        $("#agenciaCab").jqxInput({  width: '200px', height: '20px' });
		$("#marcaNroPlacaCab").jqxInput({  width: '100px', height: '20px' });
		$("#nroConstacioaInscripcionCab").jqxInput({  width: '100px', height: '20px' });
		$("#nroLicenciaConducirCab").jqxInput({  width: '100px', height: '20px' });
		*/
		
		$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
		
		//$("#seccionGRDiv").hide();
		$("#seccionGRDiv").html("");
        
		var comprobante = $.trim($("#comprobanteCab").val());
		
		if(comprobante == "BOLETA"){
			$("#generarGRDiv").hide();
			$("#facturaDiv").hide();
			$("#lblDocumentoIdentidadCab").html("DNI");
			$("#idDocumentoIdentidadCab").val("1");
		}else{
			if(comprobante == "FACTURA"){
				$("#generarGRDiv").show();
				$("#facturaDiv").show();
				$("#lblDocumentoIdentidadCab").html("RUC");
				$("#idDocumentoIdentidadCab").val("2");
			}				
		}	
		
		$("#detalleFacturaBoletaDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#detalleFacturaBoletaDiv").load("ventas/factura_boleta/detalleFacturaBoleta.php?p="+Math.random());
    });

	//Popup Buscar CLiente
	$("#popupBuscarClienteDiv").jqxWindow({
		width: "700", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'),
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarClienteDiv").on('open', function () {
		Limpiar_Popups();
		var idDocumentoIdentidad = $("#idDocumentoIdentidadCab").val();
		var documentoIdentidad = $("#lblDocumentoIdentidadCab").html();

		$("#formBuscarClienteDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarClienteDiv").load("ventas/buscarCliente/filtroCliente.php?p="+Math.random(), 
							{idDocumentoIdentidad: idDocumentoIdentidad, documentoIdentidad: documentoIdentidad});
        
	});		
	
	function Abrir_Popup_Buscar_Cliente(){
		Limpiar_Popups();

        $('#popupBuscarClienteDiv').jqxWindow('setTitle', 'Buscar Cliente');
        $("#popupBuscarClienteDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Cliente(){
		$("#popupBuscarClienteDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Cliente(){
		$("#idClienteCab").val("");
		$("#clienteCab").val("");
		$("#nroDocumentoIdentidadClienteCab").val("");
		$("#direccionClienteCab").val("");
	}
	
	function Seleccionar_Cliente(){
		Limpiar_Cliente();
		
		var rowscount = $("#jqxGridListaCliente").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaCliente").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaCliente").jqxGrid('getrowid', selectedrowindex);
			var dataListaCliente = $("#jqxGridListaCliente").jqxGrid('getrowdata', selectedrowindex);
						
			$("#idClienteCab").val(dataListaCliente.idCliente);
			$("#clienteCab").val(dataListaCliente.cliente);			
			$("#nroDocumentoIdentidadClienteCab").val(dataListaCliente.nroDocumentoIdentidad);
			$("#direccionClienteCab").val(dataListaCliente.direccion);

			Cerrar_Popup_Buscar_Cliente();
			
		}else{
			alert("Debe seleccionar una fila");
		}		
	}	
		
		
	//Popup Buscar Agencia
	$("#popupBuscarAgenciaDiv").jqxWindow({
		width: "700", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarAgenciaDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formBuscarAgenciaDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarAgenciaDiv").load("ventas/buscarAgencia/filtroAgencia.php?p="+Math.random());
        
	});		
	
	function Abrir_Popup_Buscar_Agencia(){
		Limpiar_Popups();

        $('#popupBuscarAgenciaDiv').jqxWindow('setTitle', 'Buscar Agencia');
        $("#popupBuscarAgenciaDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Agencia(){
		$("#popupBuscarAgenciaDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
		
	function Limpiar_Agencia(){
		$("#idAgenciaCab").val("");
		$("#agenciaCab").val("");
		$("#rucAgenciaCab").val("");
		$("#direccionAgenciaCab").val("");
	}
	
	function Seleccionar_Agencia(){
		Limpiar_Agencia();
		
		var rowscount = $("#jqxGridListaAgencia").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaAgencia").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaAgencia").jqxGrid('getrowid', selectedrowindex);
			var dataListaAgencia = $("#jqxGridListaAgencia").jqxGrid('getrowdata', selectedrowindex);
						
			$("#idAgenciaCab").val(dataListaAgencia.idAgencia);
			$("#agenciaCab").val(dataListaAgencia.agencia);
			$("#rucAgenciaCab").val(dataListaAgencia.ruc);
			$("#direccionAgenciaCab").val(dataListaAgencia.direccion);

			Cerrar_Popup_Buscar_Agencia();
			
		}else{
			alert("Debe seleccionar una fila");
		}		
	}	
			
	function Limpiar_Popups(){
		$("#formBuscarClienteDiv").html("");
		$("#formBuscarAgenciaDiv").html("");
	}	
		
	function Enter_Buscar(e){	
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}		
	}
	
	function Actualizar_DataGR(){	
		generarGR = $.trim($("#generarGRCab").val());
				
		if(generarGR == "1"){
			$("#seccionGRDiv").show();
			$("#seccionGRDiv").load("ventas/factura_boleta/seccionGR.php?p="+Math.random());
			
		}else{
			$("#seccionGRDiv").html("");
		}
		
	}

            
</script>
