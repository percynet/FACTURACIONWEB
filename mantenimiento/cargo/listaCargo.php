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

		<div id="jqxGridListaCargo"></div>
        
        <input type="hidden" id="filtro" value="<?=$filtro;?>" />
        <input type="hidden" id="valor" value="<?=$valor;?>" />
        <input type="hidden" id="accion" />

        <div id="popupCargoDiv">
            <div style="overflow: hidden;"></div>
            <div id="formCargoDiv"></div>
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
        
		$("#jqxGridListaCargo").jqxGrid('clear');
	
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		        
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idCargo'},
				{ name: 'codigo', type: 'string'},
				{ name: 'cargo', type: 'string'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro, valor: valor },
			url: "mantenimiento/cargo/dataListaCargo.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaCargo").jqxGrid(
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
					Abrir_Popup_Cargo('0');
				});
				
				$("#btnEditar").on('click', function () {
				    Abrir_Popup_Cargo('1');
				});
                
                $("#btnEliminar").on('click', function () {
					Eliminar_Cargo();
				});
				
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaCargo", "Listado de Cargos");
				});
				
			},	
            ready: function () {
                $("#jqxGridListaCargo").jqxGrid('hidecolumn', 'idCargo');
            },
			columns: [
				{ text: 'ID', datafield: 'idCargo', width: '0%'},
				{ text: 'Codigo', datafield: 'codigo', width: '30%'},
				{ text: 'Cargo', datafield: 'cargo', width: '50%'},
				{ text: 'Estado', datafield: 'estado', width: '20%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaCargo").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaCargo").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaCargo").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});


	$("#popupCargoDiv").jqxWindow({
		width: "550", height:"250", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupCargoDiv").on('open', function () {
		Limpiar_Popups();
				
		var idCargo = Obtener_Cargo_Fila();
		var accion = $("#accion").val();
        //alert("accion:"+accion);
        //alert("idCargo:"+idCargo);
		$("#formCargoDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formCargoDiv").load("mantenimiento/cargo/formCargo.php?p="+Math.random(),
				{ idCargo: idCargo, accion: accion });
        
	});	
	
	function Abrir_Popup_Cargo(accion){
		Limpiar_Popups();
        
        $("#accion").val(accion);
        var idCargo = Obtener_Cargo_Fila();
        
        if(accion == "1" && idCargo == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        $('#popupCargoDiv').jqxWindow('setTitle', 'Mantenimiento de cargo');
        $("#popupCargoDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Cargo(){
		$("#popupCargoDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formCargoDiv").html("");
	}

    function Obtener_Cargo_Fila(){
        var idCargo = "0";
		var rowscount = $("#jqxGridListaCargo").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaCargo").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaCargo").jqxGrid('getrowid', selectedrowindex);
			var dataListaCargo = $("#jqxGridListaCargo").jqxGrid('getrowdata', selectedrowindex);
            idCargo = dataListaCargo.idCargo;
		}
        
        return idCargo;
    }
    
    function Eliminar_Cargo(){
        var idCargo = Obtener_Cargo_Fila();
        if(idCargo == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al cargo ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "mantenimiento/cargo/deleteCargo.php?p="+Math.random(),
			data : { idCargo: idCargo },
			success: function(result){
                
				if(result == 1){
					alert("Se elimino al cargo satisfactoriamente" );
                    
					$("#jqxGridListaCargo").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al cargo");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idCargo){
		
		var newWindow = window.open("ventas/comprobanteVenta/impresionCargo.php?idCargo="+idCargo,
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