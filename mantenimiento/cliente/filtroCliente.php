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
                Listado de Clientes
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <!--<h4>Filtro</h4>-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td height="35" width="10">&nbsp;</td>
                                            <td width="80">Buscar por: </td>                          
                                          	<td width="120">
                                                <select id="cboFiltro" style="width:200px;" onchange="Actualizar_Valor();" >
                                                	<option value="0">[TODOS]</option>
                                                  	<option value="1">DNI</option>
                                                    <option value="2">RUC</option>
                                                    <option value="3">CLIENTE</option>
                                                </select>
                                            </td>
                                            <td width="10">&nbsp;</td>           
                                            <td width="400">
                                                <input class="input-large focused" id="valor" type="text" value="" onkeypress="Enter_Buscar(event);" />                               
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
		
        $("#valor").jqxInput({  width: '400px', height: '20px' });
        
        $("#valor").hide();
        
        var filtro = "0";
        var valor = "";
        
        $("#resultadoFiltroDiv").load("mantenimiento/cliente/listaCliente.php?p="+Math.random(), { filtro: filtro, valor: valor });
    });

	
	function Nuevo_Documento(){
		var accion = 0;
		var idDocumento = 0;

		var bContinue = false;
		//Iniciar_Variables_Documento();
	
		$("#content").html("<center><img src='theme/images/loading.gif'><br><b>Actualizando informacion</b>"+
													"<br>Por favor espere...</center>");
		$("#content").load("mantenimiento/cliente/formCliente.php?p="+Math.random(), { accion: accion, idDocumento: idDocumento });
			
	}
	
	
    function Actualizar_Valor(){
       
        var filtro = $("#cboFiltro").val();
		   
		$("#valor").hide();
        
		if(filtro == 1 || filtro == 2 || filtro == 3){
			$("#valor").show();
		}
   
        $("#valor").val("");
    }
    

    function Validar_Filtro(){
        
		var filtro = $("#cboFiltro").val();
		var valor = $("#valor").val();
		
		if(filtro == 1 || filtro == 2 || filtro == 3){
			if(valor == ""){
				alert("Debe ingresar el valor del filtro");
				return false;
			}
		}
		return true;
	}
	
	function Enter_Buscar(e){
		if(Evento_Enter(e)){
			Buscar_Resultados();
		}
	}	
		
    function Buscar_Resultados(){
           
		var filtro = $("#cboFiltro").val();
		var valor = "";
		
		if(filtro == 1 || filtro == 2 || filtro == 3){
			valor = $("#valor").val();
		}
  	
		if(!Validar_Filtro()){
			return false;
		}
		
        $("#resultadoFiltroDiv").html("<center><b>Actualizando informacion</b><br>Por favor espere...<br><img src='theme/images/loading.gif'></center>");

        $("#resultadoFiltroDiv").load("mantenimiento/cliente/listaCliente.php?p="+Math.random(), { filtro: filtro, valor: valor });
		
    }
    
    function Nueva_Cliente(){

        Ir_A_Pagina("cliente/formCliente");
        
    }
    
            
</script>
