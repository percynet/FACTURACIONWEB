<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
    
    if(isset($_POST['filtro']) && isset($_POST['valor'])){
        
		$filtro = $_POST['filtro'];
        $valor = $_POST['valor'];
    
?>

		<div id="jqxGridListaTransportista"></div>
        
        <input type="hidden" id="filtro" value="<?=$filtro;?>" />
        <input type="hidden" id="valor" value="<?=$valor;?>" />
        <input type="hidden" id="accion" />

        <div id="popupTransportistaDiv">
            <div style="overflow: hidden;"></div>
            <div id="formTransportistaDiv"></div>
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
        
		$("#jqxGridListaTransportista").jqxGrid('clear');
	
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		        
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idTransportista'},
				{ name: 'codigo', type: 'string'},
				{ name: 'razonSocial', type: 'string'},
				{ name: 'ruc', type: 'string'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro, valor: valor },
			url: "mantenimiento/transportista/dataListaTransportista.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaTransportista").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCargo',
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
				/*
				var toTheme = function (className) {
					if (theme == "") return className;
					return className + " " + className + "-" + theme;
				}
				//append buttons
 				var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
				var buttonTemplate = "<div style='float: left; padding: 3px; margin: 2px'><div style='margin: 4px; width: 16px; height 16px;'></div></div>";
				var addButton = $(buttonTemplate);
				var editButton = $(buttonTemplate);
				var deleteButton = $(buttonTemplate);
				var cancelButton = $(buttonTemplate);
				var updateButton = $(buttonTemplate);
				container.append(addButton);
				container.append(editButton);
				container.append(deleteButton);
				container.append(cancelButton);
				container.append(updateButton);
				toolbar.append(container);
				addButton.jqxButton({ cursor: "pointer", enableDefault: false, height: 25, width: 25 });
				addButton.find('div:first').addClass(toTheme('jqx-icon-search'));
				addButton.jqxTooltip({ position: 'bottom', content: "Add" });
				editButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false, height: 25, width: 25 });
				editButton.find('div:first').addClass(toTheme('jqx-icon-edit'));
				editButton.jqxTooltip({ position: 'bottom', content: "Edit" });
				deleteButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false, height: 25, width: 25 });
				deleteButton.find('div:first').addClass(toTheme('jqx-icon-edit'));
				deleteButton.jqxTooltip({ position: 'bottom', content: "Delete" });
				cancelButton.jqxButton({ cursor: 'pointer', disabled: true, enableDefault: false, height: 25, width: 25 });
				cancelButton.find('div:first').addClass(toTheme('jqx-icon-cancel'));
				cancelButton.jqxTooltip({ position: 'bottom', content: "Cancel" });
				*/
				
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
					Abrir_Popup_Transportista('0');
				});
				
				$("#btnEditar").on('click', function () {
				    Abrir_Popup_Transportista('1');
				});
                
                $("#btnEliminar").on('click', function () {
					Eliminar_Transportista();
				});
				
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaTransportista", "Listado de Transportistas");
				});
				
			},	
            ready: function () {
                $("#jqxGridListaTransportista").jqxGrid('hidecolumn', 'idTransportista');
            },
			columns: [
				{ text: 'ID', datafield: 'idTransportista', width: '0%'},
				{ text: 'Codigo', datafield: 'codigo', width: '30%'},
				{ text: 'Razon Social', datafield: 'razonSocial', width: '50%'},
				{ text: 'Numero de RUC', datafield: 'ruc', width: '50%'},
				{ text: 'Estado', datafield: 'estado', width: '20%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaTransportista").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaTransportista").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaTransportista").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});


	$("#popupTransportistaDiv").jqxWindow({
		width: "650", height:"260", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupTransportistaDiv").on('open', function () {
		Limpiar_Popups();
				
		var idTransportista = Obtener_Transportista_Fila();
		var accion = $("#accion").val();
        //alert("accion:"+accion);
        //alert("idCargo:"+idCargo);
		$("#formTransportistaDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formTransportistaDiv").load("mantenimiento/transportista/formTransportista.php?p="+Math.random(),
				{ idTransportista: idTransportista, accion: accion });
        
	});	
	
	function Abrir_Popup_Transportista(accion){
		Limpiar_Popups();
        
        $("#accion").val(accion);
        var idTransportista = Obtener_Transportista_Fila();
        
        if(accion == "1" && idTransportista == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        $('#popupTransportistaDiv').jqxWindow('setTitle', 'Mantenimiento de Transportista');
        $("#popupTransportistaDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Transportista(){
		$("#popupTransportistaDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formTransportistaDiv").html("");
	}

    function Obtener_Transportista_Fila(){
        var idTransportista = "0";
		var rowscount = $("#jqxGridListaTransportista").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaTransportista").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaTransportista").jqxGrid('getrowid', selectedrowindex);
			var dataListaTransportista = $("#jqxGridListaTransportista").jqxGrid('getrowdata', selectedrowindex);
            idTransportista = dataListaTransportista.idTransportista;
		}
        
        return idTransportista;
    }
    
    function Eliminar_Transportista(){
        var idTransportista = Obtener_Transportista_Fila();
        if(idTransportista == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al transportista ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "mantenimiento/transportista/deleteTransportista.php?p="+Math.random(),
			data : { idTransportista: idTransportista },
			success: function(result){
                
				if(result == 1){
					alert("Se elimino al transportista satisfactoriamente" );
                    
					$("#jqxGridListaTransportista").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al transportista");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idTransportista){
		
		var newWindow = window.open("ventas/comprobanteVenta/impresionTransportista.php?idTransportista="+idTransportista,
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
			url: "mantenimiento/cargo/dataListaCargo.php?p="+Math.random(),
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