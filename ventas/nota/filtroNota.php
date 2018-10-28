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
                <b>Listado de Nota Credito / Debito</b>
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
                                    		<td width="70">Fecha Desde:</td>
                                       		<td width="100">
                                                <div id="fechaDesdeDiv">
                                                    <div style='margin-top: 3px;' id='fechaDesde' />
                                                </div>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                    		<td width="70">Fecha Hasta:</td>
                                       		<td width="100">
                                                <div id="fechaHastaDiv">
                                                    <div style='margin-top: 3px;' id='fechaHasta' />
                                                </div>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                    		<td width="70">Tipo de Nota:</td>
                                       		<td width="150">
                                            	<select id="cboTipoNotaFiltro" name="cboTipoNotaFiltro" style="width:150px;">
                                                  <!--<option value="0">[SELECCIONAR]</option>	-->
                                                    <?php
                                                        $rsListaTipoNota= $objdb -> sqlListaTipoNota($idEmpresa, "U");
                                                        if (mysql_num_rows($rsListaTipoNota)!=0){
                                                        	while ($rowTipoNota = mysql_fetch_array($rsListaTipoNota)){
                                                        		$idTipoNotaX = $rowTipoNota["idTipoNota"];
                                                        		$tipoNotaX = $rowTipoNota["tipoNota"];
                                                        		
                                                        		if($idTipoNotaX==$idTipoNota){
                                                        ?>			
                                                        			<option value="<?= $idTipoNotaX; ?>" selected="selected"><?= $tipoNotaX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idTipoNotaX; ?>" ><?= $tipoNotaX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaTipoNota);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="10">&nbsp;</td>
                                            <td width="70">Estado:</td>
                                       		<td width="200">
                                            	<select id="cboEstadoFiltro" name="cboEstadoFiltro" style="width:150px;">
                                                  <option value="T">[TODOS]</option>	
                                                    <?php
                                                        $rsListaEstado= $objdb -> sqlFiltrarEstado('PROCESO');
                                                        if (mysql_num_rows($rsListaEstado)!=0){
                                                        	while ($rowEstado = mysql_fetch_array($rsListaEstado)){
                                                        		$idEstadoX = $rowEstado["idEstado"];
                                                        		$estadoX = $rowEstado["estado"];
                                                        		
                                                        		if($idEstadoX==$idEstado){
                                                        ?>			
                                                        			<option value="<?= $idEstadoX; ?>" selected="selected"><?= $estadoX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idEstadoX; ?>" ><?= $estadoX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaEstado);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>&nbsp;</td>                           
                                        </tr>
                                        <tr style="height:30px;">
   											<td>Serie-Numero:</td>
                                       		<td>
                                            	<input  id="serieNumeroFiltro" maxlength="10" style="width:200px;" onkeypress="Enter_Buscar(event);" />
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>Cliente:</td>
                                       		<td colspan="4">
                                            	<input  id="clienteFiltro"  maxlength="100" style="width:350px;" onkeypress="Enter_Buscar(event);" />
                                            </td>           
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td width="80">
                                          		<div style="padding:5px;">
                                                    <button class="btn btn-primary" onclick="Buscar_Resultados();">
                                                    	<i class="icon-search"></i> Buscar</button>
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
		$("#fechaDesde").jqxDateTimeInput({culture: 'es-ES'});
		$("#fechaHasta").jqxDateTimeInput({culture: 'es-ES'});
		
		$("#serieNumeroFiltro").jqxInput({  width: '150px', height: '20px' });
		$("#clienteFiltro").jqxInput({  width: '400px', height: '20px' });
        
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
			idTipoNota: $.trim($("#cboTipoNotaFiltro").val()),
			tipoNota: $.trim($( "#cboTipoNotaFiltro option:selected" ).text()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val()),
			idEstado: $.trim($("#cboEstadoFiltro").val()),
			estado: $.trim($("#cboEstadoFiltro option:selected").text())
        };
    
        $("#resultadoFiltroDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#resultadoFiltroDiv").load("ventas/nota/listaNota.php?p="+Math.random(), { filtro: filtro });
		            
    }
		
            
</script>
