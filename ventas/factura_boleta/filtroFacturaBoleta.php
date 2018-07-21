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
    
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Boletas y Facturas
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
                                    		<td width="100">Fecha Desde:</td>
                                       		<td>
                                                <div id="fechaDesdeDiv">
                                                    <div style='margin-top: 3px;' id='fechaDesde' />
                                                </div>                                            	

                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>    
                                    		<td width="100">Fecha Hasta:</td>
                                       		<td>
                                                <div id="fechaHastaDiv">
                                                    <div style='margin-top: 3px;' id='fechaHasta' />
                                                </div>                                            
                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>
                                    		<td width="100">Comprobante:</td>
                                       		<td>
                                                <select name="cboComprobanteFiltro" id="cboComprobanteFiltro" style="width:150px;" >
                                                  <option value="0">[TODOS]</option>
                                                    <?php
                                                        $rsListaComprobante= $objdb -> sqlListaComprobante($idEmpresa, 'U');
                                                        if (mysql_num_rows($rsListaComprobante)!=0){
                                                        	while ($rowComprobante = mysql_fetch_array($rsListaComprobante)){
                                                        		$idComprobanteX = $rowComprobante["idComprobante"];
                                                        		$comprobanteX = $rowComprobante["comprobante"];
                                                        ?>			
                                                        		<option value="<?= $idComprobanteX; ?>" ><?= $comprobanteX; ?></option>
                                                        <?php
                                                        	}
                                                        	mysql_free_result($rsListaComprobante);
                                                        }
                                                    ?>
                                                </select>                                            	
                                            </td>
                                            <td style="width: 10px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">
   											<td width="100">Serie-Numero:</td>
                                       		<td>
                                            	<input  id="serieNumeroFiltro" maxlength="10" style="width:100px;" onkeypress="Enter_Buscar(event);" />
                                            </td>
                                            <td style="width: 20px;">&nbsp;</td>
                                            <td width="100">Cliente:</td>
                                       		<td colspan="3">
                                            	<input  id="clienteFiltro"  maxlength="100" style="width:350px;" onkeypress="Enter_Buscar(event);" />
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
                    
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
         
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
	
		$("#fechaDesde").jqxDateTimeInput({width: '100px', height: '20px'});
		$("#fechaHasta").jqxDateTimeInput({width: '100px', height: '20px'});
		
		$("#serieNumeroFiltro").jqxInput({  width: '100px', height: '20px' });
		$("#clienteFiltro").jqxInput({  width: '320px', height: '20px' });
        
		$('.solo-numero').keyup(function (){             
            this.value = (this.value + '').replace(/[^0-9]/g, '');           
        });
		
		Buscar_Resultados();
        
    });

    
	function Enter_Buscar(e){	
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}		
	}
	
    function Buscar_Resultados() {
		
        var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			idComprobante: $.trim($("#cboComprobanteFiltro").val()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
    
        $("#resultadoFiltroDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#resultadoFiltroDiv").load("ventas/factura_boleta/listaFacturaBoleta.php?p="+Math.random(), { filtro: filtro });
		            
    }
		
            
</script>
