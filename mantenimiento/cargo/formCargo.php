<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	
    $accion = $_POST['accion'];
    
    $cargo['idCargo'] = "0";
    $cargo['codigo'] = "";
    $cargo['cargo'] = "";    
    $cargo['idEstado'] = "1";
    
    $fechaIngreso = "";
    
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();
        		
    if ($objdb -> is_connection()){
        
        if($accion == "1"){
            $idCargo = $_POST['idCargo'];
            //echo "ID:".$idCargo;
			$text_accion = "Editar";   
		
			$rsCargo = $objdb -> sqlGetCargoXID($idCargo);
            //print_r($rsCargo);
			if (mysql_num_rows($rsCargo)==1){
				$row = mysql_fetch_array($rsCargo);
            
                $cargo['idCargo'] = $row['idCargo'];
                $cargo['codigo'] = $row['codigo'];
                $cargo['cargo'] = $row['cargo'];                
                $cargo['idEstado'] = $row['idEstado'];
            }
        }
  
?>

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body" id="cabeceraCargo">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    	<tr style="height:30px;">
                                        	<td style="width: 120px;">Codigo:</td>
                                       		<td style="width: 150px;"><input id="codigo" value="<?= $cargo['codigo']; ?>" maxlength="3"  /></td>
                                           	<td style="width: 100px;">&nbsp;</td>
                                        </tr>
                                        <tr style="height:30px;">    
                                    		<td>Cargo:</td>
                                       		<td><input  id="cargo" value="<?= $cargo['cargo']; ?>" maxlength="100" /></td>
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
                            <button class="btn" id="btnAceptar" onclick="Guardar_Cargo();">
                            		<i class="icon-ok"></i> Aceptar</button>&nbsp;
                            <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Cargo();">
                            		<i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
                        </p>
                    </div>
        
                </div>
            </div>
            <!-- /.panel-body -->

            <input type="hidden" id="accion" value="<?= $accion; ?>" />
            <input type="hidden" id="idCargo" value="<?= $cargo['idCargo']; ?>" />
            <input type="hidden" id="idEstado" value="<?= $cargo['idEstado']; ?>" />
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
        
        $("#codigo").jqxInput({  width: '50px', height: '20px' });
        $("#cargo").jqxInput({  width: '400px', height: '20px' });
                           
        $('.solo-numero').keyup(function (){             
            this.value = (this.value + '').replace(/[^0-9]/g, '');           
        });
        
        
    });

    
    function Guardar_Cargo() {      
        var accion = $("#accion").val();
        //alert(accion);
        var idCargo = $.trim($("#idCargo").val());        
        
        if($.trim($("#codigo").val())==""){
            Mostrar_Mensaje_Notificacion("warning","Debe ingresar el codigo");
            $("#codigo").focus();
            return false;
        }
        if($.trim($("#cargo").val())==""){
			 Mostrar_Mensaje_Notificacion("warning","Debe ingresar el cargo");
            $("#cargo").focus();
            return false;
        }
    
        if (!confirm(String.fromCharCode(191) + ' Desea grabar la informacion de la cargo ' + String.fromCharCode(63))){
    		return false;
    	}
        
        var cargo = {
            idCargo: $("#idCargo").val(),
            codigo: $("#codigo").val(),
            cargo: $("#cargo").val(),
            idEstado: $("#idEstado").val()
        };
    
        //$('#debug').html(cargo);
        //console.log(cargo);
  
        $.ajax({
			type: "POST",
            //contentType: "application/json; charset=utf-8",
            //dataType: "json",
			url : "mantenimiento/cargo/saveCargo.php?p="+Math.random(),
			data : {cargo: cargo, accion: accion},
            //data: JSON.stringify(cargo),
			success: function(result){
			     //alert(result);
                
                if(result == 1){
                    Mostrar_Mensaje_Notificacion("success","Se grabaron los datos del cargo satisfactoriamente");
					$("#jqxGridListaCargo").jqxGrid('updatebounddata', 'cells');
                    Cerrar_Popup_Cargo();
				}else{
                    if(result == 2){
						Mostrar_Mensaje_Notificacion("success","El cargo ya existe");
                    }else{ 
						Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
                    }
				}
			
			},
			error: function(){ Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
			}
		});
        
             
    }


    
</script>