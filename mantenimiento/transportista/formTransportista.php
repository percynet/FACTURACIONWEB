<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
    $accion = $_POST['accion'];
    
    $transportista['idTransportista'] = "0";
    $transportista['codigo'] = "";
	$transportista['ruc'] = "";    
    $transportista['razonSocial'] = "";    
    $transportista['idEstado'] = "1";
    
    $fechaIngreso = "";
    
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){
        
        if($accion == "1"){
            $idTransportista = $_POST['idTransportista'];
            //echo "ID:".$idTransportista;
			$text_accion = "Editar";   
		
			$rsTransportista = $objdb -> sqlGetTransportistaXID($idTransportista);
            //print_r($rsTransportista);

			if (mysql_num_rows($rsTransportista)==1){
				$row = mysql_fetch_array($rsTransportista);

                $transportista['idTransportista'] = $row['idTransportista'];
                $transportista['codigo'] = $row['codigo'];
				$transportista['ruc'] = $row['ruc'];
                $transportista['razonSocial'] = $row['razonSocial'];
                $transportista['idEstado'] = $row['idEstado'];
            }
        }
  
?>

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body" id="cabeceraTransportista">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    	<tr style="height:30px;">
                                        	<td style="width: 200px;">Codigo:</td>
                                       		<td style="width: 150px;"><input id="codigo" value="<?= $transportista['codigo']; ?>" maxlength="6"  /></td>
                                           	<td style="width: 100px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">    
                                    		<td>Razon Social:</td>
                                       		<td><input  id="razonSocial" value="<?= $transportista['razonSocial']; ?>" maxlength="100" /></td>
                                            <td style="width: 100px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">
                                          <td>Numero de RUC:</td>
                                    	  <td><input  id="ruc" value="<?= $transportista['ruc']; ?>" maxlength="20" /></td>
                                            <td style="width: 15px;">&nbsp;</td>

                                          <td>&nbsp;</td>
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
                            <button class="btn" id="btnAceptar" onclick="Guardar_Transportista();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Transportista();">
                            		<i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
                        </p>
                    </div>
        
                </div>
            </div>
            <!-- /.panel-body -->

            <input type="hidden" id="accion" value="<?= $accion; ?>" />
            <input type="hidden" id="idTransportista" value="<?= $transportista['idTransportista']; ?>" />
            <input type="hidden" id="idEstado" value="<?= $transportista['idEstado']; ?>" />
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
        // Create jqxExpander.
        //$("#createAccount").jqxExpander({  toggleMode: 'none', width: '350px', showArrow: false });
        // Create jqxInput.
        
        $("#codigo").jqxInput({  width: '100px', height: '20px' });
        $("#ruc").jqxInput({  width: '150px', height: '20px' });
		$("#razonSocial").jqxInput({  width: '400px', height: '20px' });
                           
        $('.solo-numero').keyup(function (){             
            this.value = (this.value + '').replace(/[^0-9]/g, '');           
        });
        
        
    });

    
    function Guardar_Transportista() {      
        var accion = $("#accion").val();
        //alert(accion);
        var idTransportista = $.trim($("#idTransportista").val());        
        
        if($.trim($("#codigo").val())==""){
            alert("Debe ingresar el codigo");
            $("#codigo").focus();
            return false;
        }
        if($.trim($("#razonSocial").val())==""){
            alert("Debe ingresar la razon social");
            $("#razonSocial").focus();
            return false;
        }
    
	    if($.trim($("#ruc").val())==""){
            alert("Debe ingresar numero de ruc");
            $("#ruc").focus();
            return false;
        }
    
        if (!confirm(String.fromCharCode(191) + ' Desea grabar la informacion del transportista ' + String.fromCharCode(63))){
    		return false;
    	}
        
        var transportista = {
            idTransportista: $("#idTransportista").val(),
            codigo: $("#codigo").val(),
            razonSocial: $("#razonSocial").val(),
            ruc: $("#ruc").val(),
            idEstado: $("#idEstado").val()
        };
    
        //$('#debug').html(cargo);
        //console.log(cargo);
  
        $.ajax({
			type: "POST",
            //contentType: "application/json; charset=utf-8",
            //dataType: "json",
			url : "mantenimiento/transportista/saveTransportista.php?p="+Math.random(),
			data : {transportista: transportista, accion: accion},
            //data: JSON.stringify(cargo),
			success: function(result){
			     //alert(result);
                
                if(result == 1){
					alert("Se grabaron los datos del transportista satisfactoriamente" );
                    
					$("#jqxGridListaTransportista").jqxGrid('updatebounddata', 'cells');
                    Cerrar_Popup_Transportista();
				}else{
                    if(result == 2){
                        alert("El Transportista ya existe" );
                    }else{
                        alert("Ocurrio un error al grabar el Transportista");
                    }
				}
			
			},
			error: function(){
				alert("Se ha producido un error. No puede continuar con el proceso.");
			}
		});
        
             
    }


    
</script>