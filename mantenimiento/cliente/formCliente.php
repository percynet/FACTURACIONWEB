<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
    $accion = $_POST['accion'];
    
    $cliente['idCliente'] = "0";
	$cliente['nombres'] = "";
	$cliente['apellidoPaterno'] = "";
	$cliente['apellidoMaterno'] = "";
	$cliente['idDocumentoIdentidad'] = "0";
	$cliente['nroDocumentoIdentidad'] = "";
	$cliente['idDistrito'] = "0";
	$cliente['direccion'] = "";
	$cliente['telefonoFijo'] = "";	
	$cliente['telefonoCelular'] = "";	
	$cliente['email'] = "";	
	$cliente['fechaIngreso'] = "";	
	$cliente['idEstado'] = "1";
    
    $fechaIngreso = "";
    
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){
        
        if($accion == "1"){
            $idCliente = $_POST['idCliente'];
            //echo "ID:".$idCliente;
			$text_accion = "Editar";   
		
			$rsCliente = $objdb -> sqlGetClienteXID($idEmpresa, $idCliente);
            //print_r($rsCliente);
			if (mysql_num_rows($rsCliente)==1){
				$row = mysql_fetch_array($rsCliente);				
            
                $cliente['idCliente'] = $row['idCliente'];
				$cliente['nombres'] = $row['nombres'];
				$cliente['apellidoPaterno'] = $row['apellidoPaterno'];
				$cliente['apellidoMaterno'] = $row['apellidoMaterno'];
				$cliente['idDocumentoIdentidad'] = $row['idDocumentoIdentidad'];
				$cliente['nroDocumentoIdentidad'] = $row['nroDocumentoIdentidad'];
				$cliente['idDistrito'] = $row['idDistrito'];
				$cliente['direccion'] = $row['direccion'];
				$cliente['telefonoFijo'] = $row['telefonoFijo'];
				$cliente['telefonoCelular'] = $row['telefonoCelular'];
				$cliente['email'] = $row['email'];
				$cliente['fechaIngreso'] = $row['fechaIngreso'];
                $cliente['idEstado'] = $row['idEstado'];
            }
        }
		
		$idDistrito = $cliente['idDistrito'];
  
?>

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body" id="cabeceraCliente">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                        
                                        <tr style="height:30px;">
                                    		<td width="200">Nombres:</td>
                                       		<td><input  id="nombres" value="<?= $cliente['nombres']; ?>" maxlength="100" /></td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr> 
                                        <tr style="height:30px;">
                                    		<td width="200">Apellido Paterno:</td>
                                       		<td><input  id="apellidoPaterno" value="<?= $cliente['apellidoPaterno']; ?>" maxlength="100" /></td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">
                                    		<td width="200">Apellido Materno:</td>
                                       		<td><input  id="apellidoMaterno" value="<?= $cliente['apellidoMaterno']; ?>" maxlength="100" /></td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>  
                                        <tr style="height:30px;">
                                    		<td width="200">
                                            	<select name="cboDocumentoIdentidad" id="cboDocumentoIdentidad" style="width:120px;" >
                                                  <option value="0">[DOC. IDENT]</option>	
                                                    <?php
                                                        $rsListaDocumentoIdentidad= $objdb -> sqlListaDocumentoIdentidad($idEmpresa, 'ACTIVO');
                                                        if (mysql_num_rows($rsListaDocumentoIdentidad)!=0){
                                                        	while ($rowDocumentoIdentidad = mysql_fetch_array($rsListaDocumentoIdentidad)){
                                                        		$idDocumentoIdentidadX = $rowDocumentoIdentidad["idDocumentoIdentidad"];
                                                        		$documentoIdentidadX = $rowDocumentoIdentidad["documentoIdentidad"];
                                                        		
                                                        		if($idDocumentoIdentidadX==$cliente['idDocumentoIdentidad']){
                                                        ?>			
                                                        			<option value="<?= $idDocumentoIdentidadX; ?>" selected="selected"><?= $documentoIdentidadX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idDocumentoIdentidadX; ?>" ><?= $documentoIdentidadX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaDocumentoIdentidad);
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                       		<td>
                                            	<input  id="nroDocumentoIdentidad" value="<?= $cliente['nroDocumentoIdentidad']; ?>" maxlength="11" />
                                            </td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">    
                                    		<td width="200">Distrito:</td>
                                       		<td>
                                                <select name="cboDistrito" id="cboDistrito" style="width:250px;" >
                                                  <option value="0">[SELECCIONAR]</option>
                                                    <?php
                                                        $rsListaDistrito= $objdb -> sqlListaDistrito('ACTIVO');
                                                        if (mysql_num_rows($rsListaDistrito)!=0){
                                                        	while ($rowDistrito = mysql_fetch_array($rsListaDistrito)){
                                                        		$idDistritoX = $rowDistrito["idDistrito"];
                                                        		$distritoX = $rowDistrito["distrito"];
                                                        		
                                                        		if($idDistritoX==$cliente['idDistrito']){
                                                        ?>			
                                                        			<option value="<?= $idDistritoX; ?>" selected="selected"><?= $distritoX; ?></option>
                                                        <?php	
                                                        		}else{
                                                        ?>			
                                                        			<option value="<?= $idDistritoX; ?>" ><?= $distritoX; ?></option>
                                                        <?php										
                                                        		}
                                                        	
                                                        	}
                                                        	mysql_free_result($rsListaDistrito);
                                                        }
                                                    ?>
                                                </select>                                            	
                                            </td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>                                        
                                        <tr style="height:30px;">
                                    		<td width="200">Direccion:</td>
                                       		<td><input  id="direccion" value="<?= $cliente['direccion']; ?>" maxlength="100" /></td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr>  
                                        <tr style="height:30px;">
                                    		<td width="200">Telefono Fijo:</td>
                                       		<td><input  id="telefonoFijo" value="<?= $cliente['telefonoFijo']; ?>" maxlength="100" /></td>
                                            <td style="width: 30px;">&nbsp;</td>
                                        </tr> 
                                        <tr style="height:30px;">
                                    		<td width="200">Telefono Celular:</td>
                                       		<td><input  id="telefonoCelular" value="<?= $cliente['telefonoCelular']; ?>" maxlength="100" /></td>
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
                            <button class="btn" id="btnAceptar" onclick="Guardar_Cliente();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Cliente();">
                            		<i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
                        </p>
                    </div>
        
                </div>
            </div>
            <!-- /.panel-body -->

            <input type="hidden" id="accion" value="<?= $accion; ?>" />
            <input type="hidden" id="idCliente" value="<?= $cliente['idCliente']; ?>" />
            <input type="hidden" id="idDocumentoIdentidad" value="<?= $cliente['idDocumentoIdentidad']; ?>" />
            <input type="hidden" id="idDistrito" value="<?= $cliente['idDistrito']; ?>" />
            <input type="hidden" id="idEstado" value="<?= $cliente['idEstado']; ?>" />
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
        $("#nombres").jqxInput({ width: '200px', height: '20px' });
		$("#apellidoPaterno").jqxInput({ width: '320px', height: '20px' });
		$("#apellidoMaterno").jqxInput({ width: '320px', height: '20px' });
		$("#nroDocumentoIdentidad").jqxInput({ width: '320px', height: '20px' });
		$("#direccion").jqxInput({ width: '320px', height: '20px' });
		$("#telefonoFijo").jqxInput({  width: '100px', height: '20px' });
		$("#telefonoCelular").jqxInput({  width: '100px', height: '20px' });
                           
        $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
        
        
    });

    
    function Guardar_Cliente() {
        var accion = $("#accion").val();
        //alert(accion);
        var idCliente = $.trim($("#idCliente").val());		
		var nombres = $.trim($("#nombres").val()); 
        if(nombres==""){
            alert("Debe ingresar el nombre del cliente");
            $("#nombres").focus();
            return false;
        }
		
		var apellidoPaterno = $.trim($("#apellidoPaterno").val()); 
		if(apellidoPaterno==""){
            alert("Debe ingresar el apellido paterno del cliente");
            $("#apellidoPaterno").focus();
            return false;
        }
		
		var apellidoMaterno = $.trim($("#apellidoMaterno").val()); 
        if(apellidoMaterno==""){
            alert("Debe ingresar el apellido materno del cliente");
            $("#apellidoMaterno").focus();
            return false;
        }
		
		$("#idDocumentoIdentidad").val($("#cboDocumentoIdentidad").val());
        var idDocumentoIdentidad = $.trim($("#idDocumentoIdentidad").val());
		
		if(idDocumentoIdentidad=="0"){
            alert("Debe seleccionar el documento de identidad");
            $("#cboDocumentoIdentidad").focus();
            return false;
        }
				
		var nroDocumentoIdentidad = $.trim($("#nroDocumentoIdentidad").val()); 
		if(nroDocumentoIdentidad==""){
            alert("Debe ingresar el nrro documento de identidad del cliente");
            $("#nroDocumentoIdentidad").focus();
            return false;
        }

		$("#idDistrito").val($("#cboDistrito").val());		        
        var idDistrito = $.trim($("#idDistrito").val()); 
		
		if(idDistrito=="0"){
            alert("Debe seleccionar el distrito");
            $("#cboDistrito").focus();
            return false;
        }
				
		var direccion = $.trim($("#direccion").val()); 
		if(direccion==""){
            alert("Debe ingresar la direccion del cliente");
            $("#direccion").focus();
            return false;
        }
		
		var telefonoFijo = $.trim($("#telefonoFijo").val()); 
		if(telefonoFijo==""){
            alert("Debe ingresar el telefono fijo del cliente");
            $("#telefonoFijo").focus();
            return false;
        }
		/*
		var telefonoCelular = $.trim($("#telefonoCelular").val()); 
		if(telefonoCelular==""){
            alert("Debe ingresar el telefono celular del cliente");
            $("#telefonoCelular").focus();
            return false;
        }		
    	*/
        if (!confirm(String.fromCharCode(191) + ' Desea grabar la informacion del cliente ' + String.fromCharCode(63))){
    		return false;
    	}
        
		
        var cliente = {            
            idCliente: $.trim($("#idCliente").val()),
			nombres: $.trim($("#nombres").val()),
			apellidoPaterno: $.trim($("#apellidoPaterno").val()),
			apellidoMaterno: $.trim($("#apellidoMaterno").val()),
			idDocumentoIdentidad : $.trim($("#idDocumentoIdentidad").val()),
			nroDocumentoIdentidad: $.trim($("#nroDocumentoIdentidad").val()),
			idDistrito: $.trim($("#idDistrito").val()),
			direccion: $.trim($("#direccion").val()),
			telefonoFijo: $.trim($("#telefonoFijo").val()),
			telefonoCelular: $.trim($("#telefonoCelular").val()),
            idEstado: $.trim($("#idEstado").val())
        };
    
        $('#debug').html(cliente);
        console.log(cliente);
  
        $.ajax({
			type: "POST",
            //contentType: "application/json; charset=utf-8",
            //dataType: "json",
			url : "mantenimiento/cliente/saveCliente.php?p="+Math.random(),
			data : {cliente: cliente, accion: accion},
            //data: JSON.stringify(cliente),
			success: function(result){
			    //alert(result);
                if(result == 1){
					alert("Se grabaron los datos del cliente satisfactoriamente" );
                    
					$("#jqxGridListaCliente").jqxGrid('updatebounddata', 'cells');
                    Cerrar_Popup_Cliente();
				}else{
                    if(result == 2){
                        alert("El cliente ya existe" );
                    }else{
                        alert("Ocurrio un error al grabar la cliente");
                    }
				}
			
			},
			error: function(){
				alert("Se ha producido un error. No puede continuar con el proceso.");
			}
		});
        
             
    }


    
</script>