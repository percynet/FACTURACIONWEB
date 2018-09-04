<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
	$idCabeceraGR = $_POST['idCabeceraGR'];
	$accion = $_POST['accion'];
	$cabeceraGR['idCabeceraGR'] = "0";
	
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){

			$rsCabeceraGR =  $objdb -> sqlGetCabeceraGuiaRemision($idEmpresa, $idCabeceraGR);
			
			if (mysql_num_rows($rsCabeceraGR)==1){
				$cabeceraGR = mysql_fetch_array($rsCabeceraGR);
				//print_r(json_encode($cabeceraGR));	
            }	
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<b>Nueva Guia de Remisión</b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    
                    					<tr style="height:20px;">                                           
                                    		<td width="120">Fecha Emision:</td>
                                       		<td width="150">
                                                <div id="fechaEmisionDiv">
                                                    <div style='margin-top: 3px;' id='fechaEmision' />
                                                </div>
                                            </td>      
                                            <td width="70">&nbsp;</td>
                                    		<td width="120">Fecha Traslado:</td>
                                       		<td width="150">
                                                <div id="fechaTrasladoDiv">
                                                    <div style='margin-top: 3px;' id='fechaTraslado' />
                                                </div>
                                            </td>
                                            <td width="70">&nbsp;</td>
                                    		<td width="200">N° Guia Remision(Cliente):</td>
                                       		<td>
                                                <div id="nroGRDiv">
                                                    <input type="text" id="serieNumeroGRCliente" value="<?= $cabeceraGR['serieNumeroGRCliente']; ?>" />
                                                </div>
                                            </td>
                                            <td width="70">&nbsp;</td>
                                    		<td width="200">N° Guia Remision(Transportista):</td>
                                       		<td>
                                                <div id="nroGRDiv">
                                                    <input type="text" id="serieNumeroGRTransportista"  value="<?= $cabeceraGR['serieNumeroGRTransportista']; ?>" readonly="readonly" />
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
                    
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;CLIENTE REMITENTE</b>
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="100">Razon Social:</td>
                                        	<td width="300" colspan="4">                                           		
                                            	<input id="clienteRemitente"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['clienteRemitente']; ?>" />
                                            </td>
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Cliente('PAR');">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Doc. Identidad:</td>
                                        	<td>
                                            	<input id="documentoIdentidadCR"  maxlength="200" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['documentoIdentidadCR']; ?>" />
                                            </td>
	                                        <td>&nbsp;</td>
                                            <td>Nro Documento:</td>
                                        	<td>
                                            	<input id="numeroDocumentoIdentidadCR"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['numeroDocumentoIdentidadCR']; ?>" />
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                           
                        </div>
                        <!-- /.col-lg-6 -->

                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;CLIENTE DESTINATARIO</b>
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="100">Razon Social:</td>
                                        	<td width="300" colspan="4">
                                            	<input id="clienteDestinatario"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['clienteDestinatario']; ?>" />
                                            </td>
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Cliente('LLE');">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Doc. Identidad:</td>
                                        	<td>
                                            	<input id="documentoIdentidadCD"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['documentoIdentidadCD']; ?>" />
                                            </td>
	                                        <td>&nbsp;</td>
                                            <td>Nro Documento:</td>
                                        	<td>
                                            	<input id="numeroDocumentoIdentidadCD"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['numeroDocumentoIdentidadCD']; ?>" />
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                           
                        </div>
                        <!-- /.col-lg-6 -->
                        
                    </div>            
                    <!-- /.row -->
                    
                    <div class="row">
                    
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;DIRECCION DE PARTIDA</b>
                                    &nbsp;&nbsp;&nbsp;<span id="messagePAR" />
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">
                                            <td>Tipo Via:</td>
                                        	<td colspan="2">
                                            	<input id="tipoViaPAR"  maxlength="100"  readonly="readonly" value="<?= $cabeceraGR['tipoViaPAR']; ?>" />
                                            </td>
                                            <td align="right">Nombre Via:</td>
                                        	<td colspan="2">
                                            	<input id="nombreViaPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['nombreViaPAR']; ?>" />
                                            </td>   	
                                        </tr>                                        
                                        <tr style="height:25px;">
                                            <td>Nro:</td>
                                        	<td>
                                            	<input id="numeroPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['numeroPAR']; ?>" />
                                            </td>
	                                        
                                            <td>Interior:</td>
                                        	<td>
                                            	<input id="interiorPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['interiorPAR']; ?>" />
                                            </td>
                                            
                                            <td>Zona:</td>
                                        	<td>
                                            	<input id="zonaPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['zonaPAR']; ?>" />
                                            </td>
                                            <!--  <td>&nbsp;</td>-->
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Departamento:</td>
                                        	<td>
                                            	<input id="departamentoPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['departamentoPAR']; ?>" />
                                            </td>
	                                        
                                            <td>Provincia:</td>
                                        	<td>
                                                <input id="provinciaPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['provinciaPAR']; ?>" />
                                            </td>
                                            
                                            <td>Distrito:</td>
                                        	<td>
                                            	<input id="distritoPAR"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['distritoPAR']; ?>" />
                                            </td>
                                            <!--  <td>&nbsp;</td>-->
                                        </tr>
                                   	</table>
                                    
                               	</div>
                            </div>
                           
                        </div>
                        <!-- /.col-lg-6 -->
                    
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;DIRECCION DE LLEGADA</b>
                                    &nbsp;&nbsp;&nbsp;<span id="messageLLE"  />
                            	</div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">
                                            <td>Tipo Via:</td>
                                        	<td colspan="2">
                                            	<input id="tipoViaLLE"  maxlength="100"  readonly="readonly" value="<?= $cabeceraGR['tipoViaLLE']; ?>" />
                                            </td>
                                            <td align="right">Nombre Via:</td>
                                        	<td colspan="2">
                                            	<input id="nombreViaLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['nombreViaLLE']; ?>" />
                                            </td>
                                            <!--                                              
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Buscar_Resultados();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                            --> 	
                                        </tr>                                        
                                        <tr style="height:25px;">
                                            <td>Nro:</td>
                                        	<td>
                                            	<input id="numeroLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['numeroLLE']; ?>" />
                                            </td>
	                                        
                                            <td>Interior:</td>
                                        	<td>
                                            	<input id="interiorLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['interiorLLE']; ?>" />
                                            </td>
                                            
                                            <td>Zona:</td>
                                        	<td>
                                            	<input id="zonaLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['zonaLLE']; ?>" />
                                            </td>
                                            <!--  <td>&nbsp;</td>-->
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Departamento:</td>
                                        	<td>
                                            	<input id="departamentoLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['departamentoLLE']; ?>" />
                                            </td>
	                                        
                                            <td>Provincia:</td>
                                        	<td>
                                                <input id="provinciaLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['provinciaLLE']; ?>" />
                                            </td>
                                            
                                            <td>Distrito:</td>
                                        	<td>
                                            	<input id="distritoLLE"  maxlength="100" readonly="readonly" value="<?= $cabeceraGR['distritoLLE']; ?>" />
                                           	</td>
                                            <!--  <td>&nbsp;</td>-->
                                        </tr>
                                   	</table>
                                    
                               	</div>
                            </div>
                           
                        </div>
                        <!-- /.col-lg-6 -->
                                            
                    </div>
					<!-- /.row -->
                                
                    <div class="row">    
                        <div class="col-lg-12">
                            <div class="panel-body">
								<div id="detalleGuiaRemisionDiv"></div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                        
                    </div>            
                    <!-- /.row -->
                    
                    <div class="row">    

                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;DATOS DE LA EMPRESA SUBCONTRATADA</b>
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="100">Razon Social:</td>
                                        	<td width="300" colspan="4">
                                            	<input id="razonSocialTransportista"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['razonSocialTransportista']; ?>" />
                                            </td>
                                            <td>
                                            	<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Transportista();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>R.U.C:</td>
                                        	<td>
                                            	<input id="rucTransportista"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['rucTransportista']; ?>" />
                                            </td>
	                                        <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        	<td>&nbsp;</td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                            
                            <div class="panel panel-default">
                            	<!--
                            	<div class="panel-head">
                                	<b>&nbsp;&nbsp;&nbsp;</b>
                                </div>
                                -->
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="100">Observaciones:</td>
                                        	<td width="400" colspan="4">                                           		
                                            	<textarea id="observaciones"  style="width:500px;"> <?= $cabeceraGR['observaciones']; ?></textarea></td>
                                            </td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                            
                        </div>
                        <!-- /.col-lg-6 -->
                                              			
                        
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                            	<div class="panel-head" style="padding-top:5px;">
                                	<b>&nbsp;&nbsp;&nbsp;DATOS DE IDENTIFICACION DE LA UNIDAD DE TRANSPORTE Y DEL CONDUCTOR</b>
                                </div>
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:25px;">    
                                   			<td width="200">Marca del Vehiculo:</td>
                                        	<td width="200" colspan="4">                                           		
                                            	<input id="marca"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['marca']; ?>" />
                                            </td>
                                          	<td width="100">
                                           		<div id="btnBuscarVehiculoDiv" style="display:none; padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Vehiculo();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                           	</td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td width="100">Placa Tracto:</td>
                                        	<td width="150">
                                            	<input id="placaTracto"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['placaTracto']; ?>" />
                                            </td>
	                                        <td width="30">&nbsp;</td>
                                            <td width="100">Placa Remolque:</td>
                                        	<td width="150">
                                            	<input id="placaRemolque"  maxlength="100" style="width:250px;" readonly="readonly" value="<?= $cabeceraGR['placaRemolque']; ?>" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Configuracion Vehicular:</td>
                                        	<td colspan="4">
                                            	<input id="configuracionVehicular"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['configuracionVehicular']; ?>" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Nro Certificado de Inscripcion:</td>
                                        	<td colspan="4">
                                            	<input id="certificadoInscripcion"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['certificadoInscripcion']; ?>" />
                                            </td>
                                            <td>&nbsp;</td>                                         
                                        </tr>                                        
                                        <tr style="height:25px;">
                                            <td>Nombre Chofer:</td>
                                        	<td colspan="4">
                                            	<input id="chofer"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['chofer']; ?>" />
                                            </td>
                                            <td>
                                            	<div id="btnBuscarChoferDiv" style="display:none; padding:5px;">
                                                    <button class="btn btn-primary" onclick="Abrir_Popup_Buscar_Chofer();">
                                                    	<i class="icon-search"></i> Buscar</button>
                                                </div>
                                            </td>                                     
                                        </tr>
                                        <tr style="height:25px;">
                                            <td>Nro licencia de Conducir:</td>
                                        	<td colspan="4">
                                            	<input id="licenciaConducir"  maxlength="100" style="width:200px;" readonly="readonly" value="<?= $cabeceraGR['licenciaConducir']; ?>" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                   	</table>
                               	</div>
                            </div>
                           
                        </div>
                        <!-- /.col-lg-6 -->
                                                                        
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
<a href="#punto1">Ir a Punto 1</a>
                    
                    <input type="hidden" id="idCabeceraGR" value="<?= $cabeceraGR['idCabeceraGR']; ?>" />
                    <input type="hidden" id="tipoCliente" />
                    <input type="hidden" id="accion" value="<?= $accion; ?>" />
                   	
                    <input type="hidden" id="idClienteRemitente"  value="<?= $cabeceraGR['idClienteRemitente']; ?>" />
                    <input type="hidden" id="idDireccionPartida"  value="<?= $cabeceraGR['idDireccionPartida']; ?>" />
                    <input type="hidden" id="idDepartamentoPAR" value="<?= $cabeceraGR['idDepartamentoPAR']; ?>" />
                    <input type="hidden" id="idProvinciaPAR" value="<?= $cabeceraGR['idProvinciaPAR']; ?>" />
                    <input type="hidden" id="idDistritoPAR" value="<?= $cabeceraGR['idDistritoPAR']; ?>" />
                    
                    <input type="hidden" id="idClienteDestinatario"  value="<?= $cabeceraGR['idClienteDestinatario']; ?>" />
                    <input type="hidden" id="idDireccionLlegada"  value="<?= $cabeceraGR['idDireccionLlegada']; ?>" />
                    <input type="hidden" id="idDepartamentoLLE" value="<?= $cabeceraGR['idDepartamentoLLE']; ?>" />
                    <input type="hidden" id="idProvinciaLLE" value="<?= $cabeceraGR['idProvinciaLLE']; ?>" />
                    <input type="hidden" id="idDistritoLLE" value="<?= $cabeceraGR['idDistritoLLE']; ?>" />
                    
                    <input type="hidden" id="idTransportista"  value="<?= $cabeceraGR['idTransportista']; ?>" />
                    <input type="hidden" id="idVehiculo" value="<?= $cabeceraGR['idVehiculo']; ?>" />
                    <input type="hidden" id="idMarca" value="<?= $cabeceraGR['idMarca']; ?>" />
                    <input type="hidden" id="idChofer" value="<?= $cabeceraGR['idChofer']; ?>" />
                    
         
<div id="popupBuscarClienteDiv">
    <div style="overflow: hidden;">	</div>
    <div id="formBuscarClienteDiv"></div>
</div>

<div id="popupBuscarTransportistaDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarTransportistaDiv"></div>
</div>

<div id="popupBuscarVehiculoDiv">
    <div style="overflow: hidden;">	</div>
    <div id="formBuscarVehiculoDiv"></div>
</div>

<div id="popupBuscarChoferDiv">
    <div style="overflow: hidden;">	</div>
    <div id="formBuscarChoferDiv"></div>
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
					
		$("#serieNumeroGRCliente").jqxInput({ width: '100px', height: '20px' });
		$("#serieNumeroGRTransportista").jqxInput({ width: '100px', height: '20px' });
			
		$("#fechaEmision").jqxDateTimeInput( {width: '100px', height: '20px', formatString: "dd/MM/yyyy" });
		$("#fechaEmision").jqxDateTimeInput({ culture: 'es-ES' });
		
		$("#fechaTraslado").jqxDateTimeInput( {width: '100px', height: '20px', formatString: "dd/MM/yyyy" });
		$("#fechaTraslado").jqxDateTimeInput({ culture: 'es-ES' });
		
		$("#tipoViaPAR").jqxInput({ width: '200px', height: '20px' });
		$("#nombreViaPAR").jqxInput({ width: '200px', height: '20px' });
		$("#numeroPAR").jqxInput({ width: '130px', height: '20px' });
		$("#interiorPAR").jqxInput({ width: '130px', height: '20px' });
		$("#zonaPAR").jqxInput({ width: '130px', height: '20px' });
		$("#departamentoPAR").jqxInput({ width: '130px', height: '20px' });
		$("#provinciaPAR").jqxInput({ width: '130px', height: '20px' });
		$("#distritoPAR").jqxInput({ width: '130px', height: '20px' });
		
		$("#tipoViaLLE").jqxInput({ width: '200px', height: '20px' });
		$("#nombreViaLLE").jqxInput({ width: '200px', height: '20px' });
		$("#numeroLLE").jqxInput({ width: '130px', height: '20px' });
		$("#interiorLLE").jqxInput({ width: '130px', height: '20px' });
		$("#zonaLLE").jqxInput({ width: '130px', height: '20px' });
		$("#departamentoLLE").jqxInput({ width: '130px', height: '20px' });
		$("#provinciaLLE").jqxInput({ width: '130px', height: '20px' });
		$("#distritoLLE").jqxInput({ width: '130px', height: '20px' });
		
		$("#clienteRemitente").jqxInput({ width: '400px', height: '20px' });
		$("#documentoIdentidadCR").jqxInput({ width: '100px', height: '20px' });
		$("#numeroDocumentoIdentidadCR").jqxInput({ width: '150px', height: '20px' });
		
		$("#clienteDestinatario").jqxInput({ width: '400px', height: '20px' });
		$("#documentoIdentidadCD").jqxInput({ width: '100px', height: '20px' });
		$("#numeroDocumentoIdentidadCD").jqxInput({ width: '150px', height: '20px' });
				
		$("#marca").jqxInput({ width: '350px', height: '20px' });
		$("#placaTracto").jqxInput({ width: '120px', height: '20px' });
		$("#placaRemolque").jqxInput({ width: '120px', height: '20px' });
		$("#configuracionVehicular").jqxInput({ width: '300px', height: '20px' });
		$("#chofer").jqxInput({ width: '350px', height: '20px' });
		$("#certificadoInscripcion").jqxInput({ width: '350px', height: '20px' });
		$("#licenciaConducir").jqxInput({ width: '350px', height: '20px' });
				
		$("#razonSocialTransportista").jqxInput({ width: '400px', height: '20px' });
		$("#rucTransportista").jqxInput({ width: '150px', height: '20px' });
		
		//$('#observaciones').jqxTextArea({ placeHolder: 'Comentarios', height: 100, width: 400, minLength: 1 });
		
		$("#btnBuscarVehiculoDiv").hide();
		$("#btnBuscarChoferDiv").hide();
		
		
		$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
		
		
		var fechaEmision = "<?= $cabeceraGR['fechaEmision']; ?>";
		if(fechaEmision !=""){
			var fechaEmisionArray = fechaEmision.split('-');
			$("#fechaEmision").jqxDateTimeInput('setDate', new Date(fechaEmisionArray[0], fechaEmisionArray[1]-1, fechaEmisionArray[2]));
		}
		var fechaTraslado = "<?= $cabeceraGR['fechaTraslado']; ?>";
		if(fechaTraslado !=""){
			var fechaTrasladoArray = fechaTraslado.split('-');
			$("#fechaTraslado").jqxDateTimeInput('setDate', new Date(fechaTrasladoArray[0], fechaTrasladoArray[1]-1, fechaTrasladoArray[2]));
		}
	
		var accion = $("#accion").val();
		if(accion == "1"){
			$("#btnBuscarVehiculoDiv").show();
			$("#btnBuscarChoferDiv").show();
			$("#fechaEmision").jqxDateTimeInput({ disabled: true });			
		}
		
		
		var idCabeceraGR = $("#idCabeceraGR").val();
		
		$("#detalleGuiaRemisionDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#detalleGuiaRemisionDiv").load("ventas/guia_remision/detalleGuiaRemision.php?p="+Math.random(), {idCabeceraGR: idCabeceraGR});
    });
	
	
	$("#btnNuevo").click(function () {
		if (confirm(" Esta seguro de limpiar los datos del comprobante para crear uno nuevo ?")) {
			Ir_A_Pagina('ventas/guia_remision/cabeceraGuiaRemision');
		}
	});
	
	$("#btnGrabar").click(function () {
		Grabar_Guia_Remision();					
	});
	
	$("#btnRegresar").click(function () {
		Ir_A_Pagina('ventas/guia_remision/filtroGuiaRemision');
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
	
	function Abrir_Popup_Buscar_Cliente(tipoCliente){
		Limpiar_Popups();
		$("#tipoCliente").val("");
		$("#tipoCliente").val(tipoCliente);
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
	
	function Limpiar_Cliente_Remitente(){
		$("#idClienteRemitente").val("");
		$("#clienteRemitente").val("");
		$("#documentoIdentidadCR").val("");
		$("#numeroDocumentoIdentidadCR").val("");
	}
	
	function Limpiar_Cliente_Destinatario(){
		$("#idClienteDestinatario").val("");
		$("#clienteDestinatario").val("");
		$("#documentoIdentidadCD").val("");
		$("#numeroDocumentoIdentidadCD").val("");
	}
	
	function Seleccionar_Cliente(){
		var tipoCliente = $("#tipoCliente").val();
		//alert("tipoCliente selec:"+tipoCliente);
		
		if(tipoCliente == "PAR"){
			Limpiar_Cliente_Remitente();
		}else{
			if(tipoCliente == "LLE"){
				Limpiar_Cliente_Destinatario();
			}
		}
		
		var rowscount = $("#jqxGridListaCliente").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaCliente").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaCliente").jqxGrid('getrowid', selectedrowindex);
			var dataListaCliente = $("#jqxGridListaCliente").jqxGrid('getrowdata', selectedrowindex);
		
			if(tipoCliente == "PAR"){
							
				if($.trim(dataListaCliente.idDireccionPartida) > 0){
					
					$("#idClienteRemitente").val($.trim(dataListaCliente.idCliente));
					$("#clienteRemitente").val($.trim(dataListaCliente.cliente));			
					$("#documentoIdentidadCR").val($.trim(dataListaCliente.documentoIdentidad));
					$("#numeroDocumentoIdentidadCR").val($.trim(dataListaCliente.numeroDocumentoIdentidad));
					$("#idDireccionPartida").val($.trim(dataListaCliente.idDireccionPartida));
									
					Obtener_Direccion_Cliente(dataListaCliente.idDireccionPartida, "PAR");
				}else{
					Mostrar_Mensaje_Notificacion("warning","No se econtro la direccion de partida del cliente");
				}
			}else{
				if(tipoCliente == "LLE"){
					
					if($.trim(dataListaCliente.idDireccionLlegada) > 0){
						
						$("#idClienteDestinatario").val($.trim(dataListaCliente.idCliente));
						$("#clienteDestinatario").val($.trim(dataListaCliente.cliente));			
						$("#documentoIdentidadCD").val($.trim(dataListaCliente.documentoIdentidad));
						$("#numeroDocumentoIdentidadCD").val($.trim(dataListaCliente.numeroDocumentoIdentidad));
						$("#idDireccionLlegada").val($.trim(dataListaCliente.idDireccionLlegada));
						
						Obtener_Direccion_Cliente(dataListaCliente.idDireccionLlegada, "LLE");
						
					}else{
						Mostrar_Mensaje_Notificacion("warning","No se econtro la direccion de llegada del cliente");
					}
				}
			}
			
			$("#tipoCliente").val("");
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
					console.log(response.data.message);
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
					/*
					$("#tipoViaPAR").val(response.data.entity.tipoVia);
					$("#nombreViaPAR").val(response.data.entity.nombreVia);
					$("#numeroPAR").val(response.data.entity.numero);
					$("#interiorPAR").val(response.data.entity.interior);
					$("#zonaPAR").val(response.data.entity.zona);
					$("#departamentoPAR").val(response.data.entity.departamento);
					$("#provinciaPAR").val(response.data.entity.provincia);
					$("#distritoPAR").val(response.data.entity.distrito);
					*/
										
					/*
					$.each(response.data.entity, function(key, value) {						
						//console.log("*********"+value['ID']+"**********");
						//console.log(response.data.entity['nombreVia']);						
						// recorremos los valores de cada usuario
						$.each(value, function(entitykey,entityvalue) {
							
							console.log(entitykey+"-->"+entityvalue);

						});
						
					});
					*/
					
				}																																																																																
			                
	   		},
	   		error: function(){	   			
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error");
	   		}
	 	});
    }
		
		
		
	//Popup Buscar Transportista
	$("#popupBuscarTransportistaDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900",
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarTransportistaDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formBuscarTransportistaDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarTransportistaDiv").load("ventas/buscar_transportista/filtroTransportista.php?p="+Math.random());
        
	});		
	
	function Abrir_Popup_Buscar_Transportista(){
		Limpiar_Popups();

        $('#popupBuscarTransportistaDiv').jqxWindow('setTitle', 'Buscar Empresa Subcontratada');
        $("#popupBuscarTransportistaDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Transportista(){
		$("#popupBuscarTransportistaDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Transportista(){
		$("#idTransportista").val("");
		$("#razonSocialTransportista").val("");
		$("#rucTransportista").val("");
	}
	
	function Seleccionar_Transportista(){
		Limpiar_Transportista();
		
		var rowscount = $("#jqxGridListaTransportista").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaTransportista").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaTransportista").jqxGrid('getrowid', selectedrowindex);
			var dataListaTransportista = $("#jqxGridListaTransportista").jqxGrid('getrowdata', selectedrowindex);
						
			$("#idTransportista").val(dataListaTransportista.idTransportista);
			$("#razonSocialTransportista").val(dataListaTransportista.razonSocial);
			$("#rucTransportista").val(dataListaTransportista.ruc);

			Cerrar_Popup_Buscar_Transportista();

			$("#btnBuscarVehiculoDiv").show();
			$("#btnBuscarChoferDiv").show();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
		}		
	}	
			
			
	//Popup Buscar Vehiculo
	$("#popupBuscarVehiculoDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900", 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarVehiculoDiv").on('open', function () {
		Limpiar_Popups();
		var idTransportista = $("#idTransportista").val();
		//alert("idTransportista:"+idTransportista);
		
		if(idTransportista != ""){
					
			$("#formBuscarVehiculoDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
			$("#formBuscarVehiculoDiv").load("ventas/buscar_vehiculo/filtroVehiculo.php?p="+Math.random(), {idTransportista: idTransportista});
        
		}else{
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar al transportista");
			return false;
		}
	});	
				
	function Abrir_Popup_Buscar_Vehiculo(){
		Limpiar_Popups();		
		
        $('#popupBuscarVehiculoDiv').jqxWindow('setTitle', 'Buscar Vehiculo');
        $("#popupBuscarVehiculoDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Vehiculo(){
		$("#popupBuscarVehiculoDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Vehiculo(){
		$("#idVehiculo").val("");
		//$("#idTransportista").val("");
		//$("#rucTransportista").val("");
		//$("#razonSocialTransportista").val("");
		$("#idMarca").val("");
		$("#marca").val("");
		$("#idModeloMarca").val("");
		$("#modelo").val("");
		$("#codigo").val("");
		$("#placaTracto").val("");
		$("#placaRemolque").val("");
		$("#configuracionVehicular").val("");
		$("#certificadoInscripcion").val("");
		$("#configuracionVehicular").val("");
	}
	
	function Seleccionar_Vehiculo(){

		Limpiar_Vehiculo();

		var rowscount = $("#jqxGridListaVehiculo").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaVehiculo").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaVehiculo").jqxGrid('getrowid', selectedrowindex);
			var dataListaVehiculo = $("#jqxGridListaVehiculo").jqxGrid('getrowdata', selectedrowindex);
			
			if(dataListaVehiculo.idVehiculo > 0){
				
				$("#idVehiculo").val(dataListaVehiculo.idVehiculo);
				//$("#idTransportista").val(dataListaVehiculo.idTransportista);			
				//$("#rucTransportista").val(dataListaVehiculo.rucTransportista);
				//$("#razonSocialTransportista").val(dataListaVehiculo.razonSocialTransportista);
				$("#idMarca").val(dataListaVehiculo.idMarca);
				$("#marca").val(dataListaVehiculo.marca);
				$("#idModeloMarca").val(dataListaVehiculo.idModeloMarca);
				$("#modelo").val(dataListaVehiculo.modelo);
				$("#codigo").val(dataListaVehiculo.codigo);
				$("#placaTracto").val(dataListaVehiculo.placaTracto);
				$("#placaRemolque").val(dataListaVehiculo.placaRemolque);
				$("#configuracionVehicular").val(dataListaVehiculo.configuracionVehicular);
				$("#certificadoInscripcion").val(dataListaVehiculo.certificadoInscripcion);				
				$("#anioFabricacion").val(dataListaVehiculo.anioFabricacion);						
			
			}else{
				Mostrar_Mensaje_Notificacion("warning","No se encontro el vehiculo");		
			}
						
			Cerrar_Popup_Buscar_Vehiculo();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
		}		
	}
	
	
	//Popup Buscar Chofer
	$("#popupBuscarChoferDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900", 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
    
	$("#popupBuscarChoferDiv").on('open', function () {
		Limpiar_Popups();
		var idTransportista = $("#idTransportista").val();
		//alert("idTransportista:"+idTransportista);
		
		if(idTransportista == ""){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar al transportista");
			return false;			
		}
		
		$("#formBuscarChoferDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarChoferDiv").load("ventas/buscar_chofer/filtroChofer.php?p="+Math.random(), {idTransportista: idTransportista});
        
	});	
				
	function Abrir_Popup_Buscar_Chofer(){
		Limpiar_Popups();		
		
        $('#popupBuscarChoferDiv').jqxWindow('setTitle', 'Buscar Chofer');
        $("#popupBuscarChoferDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Chofer(){
		$("#popupBuscarChoferDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Chofer(){
		$("#idChofer").val("");
		//$("#idTransportista").val("");
		//$("#rucTransportista").val("");
		//$("#razonSocialTransportista").val("");
		$("#chofer").val("");
		$("#licenciaConducir").val("");
	}
	
	function Seleccionar_Chofer(){
		Limpiar_Chofer();

		var rowscount = $("#jqxGridListaChofer").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaChofer").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaChofer").jqxGrid('getrowid', selectedrowindex);
			var dataListaChofer = $("#jqxGridListaChofer").jqxGrid('getrowdata', selectedrowindex);
			
			if(dataListaChofer.idChofer > 0){
				
				$("#idChofer").val(dataListaChofer.idChofer);
				//$("#idTransportista").val(dataListaChofer.idTransportista);			
				//$("#rucTransportista").val(dataListaChofer.rucTransportista);
				//$("#razonSocialTransportista").val(dataListaChofer.razonSocialTransportista);
				$("#chofer").val(dataListaChofer.chofer);
				$("#licenciaConducir").val(dataListaChofer.licenciaConducir);							
			
			}else{				
				Mostrar_Mensaje_Notificacion("warning","no se encontro al chofer");
			}
						
			Cerrar_Popup_Buscar_Chofer();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
		}		
	}
				
	function Limpiar_Popups(){
		$("#formBuscarClienteDiv").html("");
		$("#formBuscarTransportistaDiv").html("");
		$("#formBuscarVehiculoDiv").html("");
		$("#formBuscarChoferDiv").html("");
	}	
		
	function Enter_Buscar(e){	
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}		
	}
	
	
	function Validar_Cabecera_Guia_Remision(){
		
		if($.trim($("#serieNumeroGRCliente").val()) == ""){
			Mostrar_Mensaje_Notificacion("warning","Debe ingresar la serie/numero de la guia de remision del cliente");
			return false;	
		}
		if($.trim($("#idClienteRemitente").val()) == "" || $.trim($("#idClienteRemitente").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el cliente remitente");
			return false;	
		}
		if($.trim($("#idDireccionPartida").val()) == "" || $.trim($("#idDireccionPartida").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","El cliente remitente no tiene direccion de partida");
			return false;	
		}
		if($.trim($("#idClienteDestinatario").val()) == "" || $.trim($("#idClienteDestinatario").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el cliente destinatario");
			return false;	
		}
		if($.trim($("#idDireccionLlegada").val()) == "" || $.trim($("#idDireccionLlegada").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","El cliente destinatario no tiene direccion de llegada");
			return false;	
		}
		if($.trim($("#idTransportista").val()) == "" || $.trim($("#idTransportista").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el transportista");
			return false;	
		}
		if($.trim($("#idVehiculo").val()) == "" || $.trim($("#idVehiculo").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el vehiculo asociado");
			return false;	
		}
		if($.trim($("#idChofer").val()) == "" || $.trim($("#idChofer").val()) == "0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el chofer asociado");
			return false;	
		}
		return true;
	}
	
	
	
	function Grabar_Guia_Remision(){
		
		var accion = $("#accion").val();
		
		if(!Validar_Cabecera_Guia_Remision()){
			return false;
		}
		if(!Validar_Detalle_Guia_Remision()){
			return false;
		}		
		
		if(!confirm(" ¿ Esta seguro de grabar la guia de remision ?")){
            return false;
        }
		
		
		
		var cabecera_guia_remision = 
		{
			idCabeceraGR			: $.trim($("#idCabeceraGR").val()),
			serieNumeroGRCliente	: $.trim($("#serieNumeroGRCliente").val()),
			fechaEmision			: $.trim($("#fechaEmision").val()),
			fechaTraslado			: $.trim($("#fechaTraslado").val()),
			idClienteRemitente		: $.trim($("#idClienteRemitente").val()),
			clienteRemitente		: $.trim($("#clienteRemitente").val()),
			documentoIdentidadCR	: $.trim($("#documentoIdentidadCR").val()),
			numeroDocumentoIdentidadCR: $.trim($("#numeroDocumentoIdentidadCR").val()),
			idDireccionPartida		: $.trim($("#idDireccionPartida").val()),
			tipoViaPAR				: $.trim($("#tipoViaPAR").val()),
			nombreViaPAR			: $.trim($("#nombreViaPAR").val()),
			numeroPAR				: $.trim($("#numeroPAR").val()),
			interiorPAR				: $.trim($("#interiorPAR").val()),
			zonaPAR					: $.trim($("#zonaPAR").val()),
			departamentoPAR			: $.trim($("#departamentoPAR").val()),
			provinciaPAR			: $.trim($("#provinciaPAR").val()),
			distritoPAR				: $.trim($("#distritoPAR").val()),			
			idClienteDestinatario	: $.trim($("#idClienteDestinatario").val()),
			clienteDestinatario		: $.trim($("#clienteDestinatario").val()),
			documentoIdentidadCD	: $.trim($("#documentoIdentidadCD").val()),
			numeroDocumentoIdentidadCD: $.trim($("#numeroDocumentoIdentidadCD").val()),
			idDireccionLlegada		: $.trim($("#idDireccionLlegada").val()),
			tipoViaLLE				: $.trim($("#tipoViaLLE").val()),
			nombreViaLLE			: $.trim($("#nombreViaLLE").val()),
			numeroLLE				: $.trim($("#numeroLLE").val()),
			interiorLLE				: $.trim($("#interiorLLE").val()),
			zonaLLE					: $.trim($("#zonaLLE").val()),
			departamentoLLE			: $.trim($("#departamentoLLE").val()),
			provinciaLLE			: $.trim($("#provinciaLLE").val()),
			distritoLLE				: $.trim($("#distritoLLE").val()),
			idTransportista			: $.trim($("#idTransportista").val()),
			razonSocialTransportista: $.trim($("#razonSocialTransportista").val()),
			rucTransportista		: $.trim($("#rucTransportista").val()),
			observaciones			: $.trim($("#observaciones").val()),
			idVehiculo				: $.trim($("#idVehiculo").val()),
			idMarca					: $.trim($("#idMarca").val()),
			marca				   	: $.trim($("#marca").val()),
			placaTracto				: $.trim($("#placaTracto").val()),
			placaRemolque			: $.trim($("#placaRemolque").val()),
			configuracionVehicular	: $.trim($("#configuracionVehicular").val()),
			certificadoInscripcion	: $.trim($("#certificadoInscripcion").val()),
			idChofer				: $.trim($("#idChofer").val()),
			chofer					: $.trim($("#chofer").val()),
			licenciaConducir		: $.trim($("#licenciaConducir").val())
		};
				
		//console.log("***INICIO CAB GR***");
		//console.log(cabecera_guia_remision);
		//console.log("***FIN CAB GR***");
		
		Grabar_Cabecera_Guia_Remision(accion, cabecera_guia_remision);
		
	}
	
	function Grabar_Cabecera_Guia_Remision(accion, cabecera_guia_remision){
		//alert(accion);
		$.ajax({
			type: "POST",            
			url: "ventas/guia_remision/saveCabeceraGuiaRemision.php?p="+Math.random(),
			data: { accion: accion, cabecera_guia_remision: cabecera_guia_remision },
			success: function(response){				
				//console.log("***INICIO CAB GR***");
				//console.log("accion: "+accion+" ****");
				//console.log(response);
				//console.log("***FIN CAB GR***");
				
				if (response.success) {
					//console.log(response.data.entity);
					//console.log(response.data.message);
					//console.log(response.data.entity.idCabeceraGR);						
					var idCabeceraGR = response.data.entity.idCabeceraGR;
					//console.log("idCabeceraGR:"+idCabeceraGR);
					Grabar_Detalle_Guia_Remision(accion, idCabeceraGR);
  
				}else{
                    Mostrar_Mensaje_Notificacion("error","No se logro grabar la guia de remision");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso");
			}
		})
		
	}
	
	function Validar_Detalle_Guia_Remision(){
		
		var totalFilas = parseInt($("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount);
		
		if(totalFilas == 0){
			Mostrar_Mensaje_Notificacion("warning","Debe agregar productos al detalle.");
			return false;
		}
		
		for(i=0; i<totalFilas; i++){
			var rowId = $("#jqxGridDetalle").jqxGrid('getrowid', i);
			var rowGrid = $("#jqxGridDetalle").jqxGrid('getrowdatabyid', rowId);
			if( $.trim(rowGrid['cantidad']) == 0 ){
				Mostrar_Mensaje_Notificacion("warning","Debe ingresar la cantidad del producto "+ $.trim(rowGrid['descripcion']) +" en el detalle.");
				return false;
			}
		}
		
		/*
		if(Validar_Valor_Columna_Mayor_Cero_En_Grid("jqxGridDetalle", "cantidad", "descripcion")){
			
			return false;	
		}
		*/
		return true;
	}
	
	function Grabar_Detalle_Guia_Remision(accion, idCabeceraGR){
		//alert(accion);
		var dataDetalle = Obtener_Data_Grid("jqxGridDetalle");
		//console.log(dataDetalle);
		//var exportedXML = 																																																															($("#jqxGridDetalle").jqxGrid("exportdata", "json"));
		//console.log(exportedXML);
		
		$.ajax({
			type: "POST",
			url : "ventas/guia_remision/saveDetalleGuiaRemision.php?p="+Math.random(),
			data : {accion: accion,  idCabeceraGR: idCabeceraGR, dataDetalle: dataDetalle},
			success: function(response){
				//console.log("***INICIO DET GR***");
				//console.log("accion: "+accion+" ****");
				//console.log(response);
				//console.log("***FIN DET GR***");
							
				if (response.success) {
					Mostrar_Mensaje_Notificacion("success","Se grabo la guia de remision satisfactoriamente");
					Ir_A_Pagina('ventas/guia_remision/filtroGuiaRemision');
				}else{
                    Mostrar_Mensaje_Notificacion("error","Ocurrio un error al generar el detalle de la guia de remision");
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
			$("#seccionGRDiv").load("ventas/guia_remision/seccionGR.php?p="+Math.random());
			
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
