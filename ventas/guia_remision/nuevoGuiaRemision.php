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

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr style="height:30px;">  
                                           	<td style="width: 100px;" >Almacen:</td>
                                       		<td style="width: 400px;">
                                                <select name="cboAlmacenNuevo" id="cboAlmacenNuevo" style="width:150px;" >
                                                  <!--<option value="0">[SELECCIONE]</option>-->
                                                    <?php
                                                        $rsListaAlmacen= $objdb -> sqlListaAlmacen($idEmpresa, 'ACTIVO');
                                                        if (mysql_num_rows($rsListaAlmacen)!=0){
                                                        	while ($rowAlmacen = mysql_fetch_array($rsListaAlmacen)){
                                                        		$idAlmacenX = $rowAlmacen["idAlmacen"];
                                                        		$almacenX = $rowAlmacen["almacen"];
                                                        ?>			
                                                        		<option value="<?= $idAlmacenX; ?>" ><?= $almacenX; ?></option>
                                                        <?php
                                                        	}
                                                        	mysql_free_result($rsListaAlmacen);
                                                        }
                                                    ?>
                                                </select> 
                                               </td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">  
                                           	<td style="width: 100px;" >Comprobante:</td>
                                       		<td style="width: 400px;">
                                                <select name="cboComprobanteNuevo" id="cboComprobanteNuevo" style="width:150px;" >
                                                  <option value="0">[SELECCIONE]</option>
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
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>
                                    </table>
                                     
                                </div>
                            
                            </div>
                            
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>            
                    <!-- /.row -->
                    
                    <div style="margin-top:5px; margin-right:15px;" align="right">
                        <p>
                            <button class="btn" id="btnAceptar" onclick="Crear_Nuevo_Comprobante_Venta();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Comprobante_Venta();">
                            		<i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
                        </p>
                    </div>
        
                </div>
            </div>
            <!-- /.panel-body -->

            <input type="hidden" id="idAlmacenNuevo" value="" />
            <input type="hidden" id="idComprobanteNuevo" value="" />

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
    $(document).ready(function () {
        
    });

    
    function Crear_Nuevo_Comprobante_Venta() {
	
		$("#idAlmacenNuevo").val($("#cboAlmacenNuevo").val());
        var idAlmacenNuevo = $.trim($("#idAlmacenNuevo").val());
		
        if($.trim($("#cboAlmacenNuevo").val())=="0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el almacen");
            $("#cboAlmacenNuevo").focus();
            return false;
        }
			
        $("#idComprobanteNuevo").val($("#cboComprobanteNuevo").val());		        
        //var idComprobante = $.trim($("#idComprobanteNuevo").val());        
        if($.trim($("#cboComprobanteNuevo").val())=="0"){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el comprobante");
            $("#idComprobanteNuevo").focus();
            return false;
        }
        
		//var comprobante = $("#cboComprobanteNuevo option:selected").text();
		
        //$('#debug').html(modelo);
        //console.log(modelo);
 
		var parametros = {
			idAlmacen: $.trim($("#idAlmacenNuevo").val()),
			almacen: $("#cboAlmacenNuevo option:selected").text(),
            idComprobante: $.trim($("#idComprobanteNuevo").val()),
			comprobante: $("#cboComprobanteNuevo option:selected").text()
        };
		
		Ir_A_Pagina_Con_Parametros('ventas/comprobanteVenta/cabeceraComprobanteVenta', parametros );
		
		Cerrar_Popup_Comprobante_Venta();		
        
    }


    
</script>