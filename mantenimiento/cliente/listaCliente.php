<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

	$idAlmacen = $_SESSION['ALMACEN']['idAlmacen'];
    
    if(isset($_POST['filtro']) && isset($_POST['valor'])){
        
		$filtro = $_POST['filtro'];
        $valor = $_POST['valor'];
    
?>

		<div id="jqxGridListaCliente"></div>
        
        <input type="hidden" id="filtro" value="<?=$filtro;?>" />
        <input type="hidden" id="valor" value="<?=$valor;?>" />
        <input type="hidden" id="accion" />

        <div id="popupClienteDiv">
            <div style="overflow: hidden;"></div>
            <div id="formClienteDiv"></div>
        </div>

<?php
    }else{
        
        $sMessage = MSG_FILTERS_NOT_FOUND;
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
        
		$("#jqxGridListaCliente").jqxGrid('clear');
	
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		        
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idCliente'},				
				{ name: 'nombres', type: 'string'},
				{ name: 'apellidoPaterno', type: 'string'},
				{ name: 'apellidoMaterno', type: 'string'},
				{ name: 'documentoIdentidad', type: 'string'},
				{ name: 'nroDocumentoIdentidad', type: 'string'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro, valor: valor },
			url: "mantenimiento/cliente/dataListaCliente.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaCliente").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCliente',
            width: '100%%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            showtoolbar: true,
            selectionmode: 'singlerow',
            //editable: true,
            editmode: 'selected cell click',
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
				//container.append('<button id="btnEditar" type="button" class="btn" ><i class="icon-pencil"></i>&nbsp;Editar</button>&nbsp;');
				//container.append('<button id="btnAbrir" type="button" class="btn btn-success" ><i class="fa fa-share"></i>&nbsp;Abrir</button>&nbsp;');
				container.append('<button id="btnNuevo" type="button" class="btn btn-info" ><i class="fa fa-ok"></i>&nbsp;Nuevo</button>&nbsp;');  
                container.append('<button id="btnEditar" type="button" class="btn btn-warning" ><i class="fa fa-remove"></i>&nbsp;Editar</button>&nbsp;'); 
                container.append('<button id="btnEliminar" type="button" class="btn btn-danger" ><i class="fa fa-remove"></i>&nbsp;Eliminar</button>&nbsp;'); 
				//container.append('<button id="btnImprimir" type="button" class="btn" ><i class="fa-print"></i>&nbsp;Imprimir</button>&nbsp;');
				container.append('<button id="btnImprimirLista" type="button" class="btn btn-success" ><i class="fa fa-print"></i>&nbsp;Imprimir Lista</button>&nbsp;'); 
				
				$("#btnNuevo").on('click', function () {
					Abrir_Popup_Cliente('0');
				});
				
				$("#btnEditar").on('click', function () {
				    Abrir_Popup_Cliente('1');
				});
                
                $("#btnEliminar").on('click', function () {
					Eliminar_Cliente();
				});
				
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaCliente", "Listado de Clientes");
				});
			},	
            ready: function () {
                $("#jqxGridListaCliente").jqxGrid('hidecolumn', 'idCliente');
            },
			columns: [
				{ text: 'ID', datafield: 'idCliente', width: '0%'},
				{ text: 'Nombres', datafield: 'nombres', width: '20%'},
				{ text: 'Apellido Paterno', datafield: 'apellidoPaterno', width: '25%'},
				{ text: 'Apellido Paterno', datafield: 'apellidoMaterno', width: '25%'},
				{ text: 'Documento', datafield: 'documentoIdentidad', width: '10%'},
				{ text: 'Nro. Doc.', datafield: 'nroDocumentoIdentidad', width: '12%'},
				{ text: 'Estado', datafield: 'estado', width: '8%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaCliente").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaCliente").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaCliente").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});


	$("#popupClienteDiv").jqxWindow({
		width: "550", height:"430", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupClienteDiv").on('open', function () {
		Limpiar_Popups();
				
		var idCliente = Obtener_Cliente_Fila();
		var accion = $("#accion").val();
        //alert("accion:"+accion);
        //alert("idCliente:"+idCliente);
		$("#formClienteDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formClienteDiv").load("mantenimiento/cliente/formCliente.php?p="+Math.random(),
				{ idCliente: idCliente, accion: accion });
        
	});	
	
	function Abrir_Popup_Cliente(accion){
		Limpiar_Popups();
        
        $("#accion").val(accion);
        var idCliente = Obtener_Cliente_Fila();
        
        if(accion == "1" && idCliente == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        $('#popupClienteDiv').jqxWindow('setTitle', 'Mantenimiento de cliente');
        $("#popupClienteDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Cliente(){
		$("#popupClienteDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formClienteDiv").html("");
	}

    function Obtener_Cliente_Fila(){
        var idCliente = "0";
		var rowscount = $("#jqxGridListaCliente").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaCliente").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaCliente").jqxGrid('getrowid', selectedrowindex);
			var dataListaCliente = $("#jqxGridListaCliente").jqxGrid('getrowdata', selectedrowindex);
            idCliente = dataListaCliente.idCliente;
		}
        
        return idCliente;
    }
    
    function Eliminar_Cliente(){
        var idCliente = Obtener_Cliente_Fila();
        if(idCliente == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al cliente ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "mantenimiento/cliente/deleteCliente.php?p="+Math.random(),
			data : { idCliente: idCliente },
			success: function(result){
               
				if(result == 1){
					alert("Se elimino al cliente satisfactoriamente" );
                    
					$("#jqxGridListaCliente").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al cliente");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idCliente){
		
		var newWindow = window.open("ventas/comprobanteVenta/impresionCliente.php?idCliente="+idCliente,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		
		newWindow.print();
	}
	
	
    /*      
	function TestLista(){
	   
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
        alert(filtro);
        alert(valor);
		$.ajax({
			type: "POST",            
			url: "mantenimiento/cliente/dataListaCliente.php?p="+Math.random(),
			data: { filtro: filtro, valor: valor },
			success: function(result){
				alert(result);
				$('#debug').html(result);
        		console.log(result);
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		})	
	}
	*/
		
	
</script>