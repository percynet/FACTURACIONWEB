<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

	//$idAlmacen = $_SESSION['ALMACEN']['idAlmacen'];
    
    if(isset($_POST['filtro'])){
        
		$filtro = $_POST['filtro'];

?>

		<div id="jqxGridListaFacturaBoleta"></div>

        <input type="hidden" id="accion" />

        <div id="popupFacturaBoletaDiv">
            <div style="overflow: hidden;"></div>
            <div id="formFacturaBoletaDiv"></div>
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
        
		$("#jqxGridListaFacturaBoleta").jqxGrid('clear');
		
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			idComprobante: $.trim($("#cboComprobanteFiltro").val()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		  
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idFacturaBoleta'},				
				{ name: 'comprobante', type: 'string'},
				{ name: 'serieNumero', type: 'string'},
				{ name: 'fechaEmision', type: 'date'},
				{ name: 'cliente', type: 'string'},
				{ name: 'documentoIdentidad', type: 'string'},
				{ name: 'nroDocumentoIdentidad', type: 'string'},
				{ name: 'moneda', type: 'string'},
				{ name: 'totalVenta', type: 'number'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro },
			url: "ventas/factura_boleta/dataListaFacturaBoleta.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaFacturaBoleta").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idFacturaBoleta',
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
                //container.append('<button id="btnEditar" type="button" class="btn btn-warning" ><i class="fa fa-remove"></i>&nbsp;Editar</button>&nbsp;'); 
                //container.append('<button id="btnEliminar" type="button" class="btn btn-danger" ><i class="fa fa-remove"></i>&nbsp;Eliminar</button>&nbsp;'); 
				//container.append('<button id="btnImprimir" type="button" class="btn" ><i class="fa-print"></i>&nbsp;Imprimir</button>&nbsp;');
				container.append('<button id="btnImprimirLista" type="button" class="btn btn-success" ><i class="fa fa-print"></i>&nbsp;Imprimir Lista</button>&nbsp;'); 
				
				$("#btnNuevo").on('click', function () {
					Abrir_Popup_Nuevo_Comprobante_Venta();
					//Ir_A_Pagina('ventas/factura_boleta/cabeceraFacturaBoleta');
				});
				/*
				$("#btnEditar").on('click', function () {
				    Abrir_Popup_Nuevo_Comprobante_Venta('1');
				});
                
                $("#btnEliminar").on('click', function () {
					Eliminar_Comprobante_Venta();
				});
				*/
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaFacturaBoleta", "Listado de FacturaBoletas");
				});
			},	
            ready: function () {
                $("#jqxGridListaFacturaBoleta").jqxGrid('hidecolumn', 'idFacturaBoleta');
            },
			columns: [
				{ text: 'ID', datafield: 'idFacturaBoleta', width: '0%'},
				{ text: 'Comprobante', datafield: 'comprobante', width: '10%'},
				{ text: 'Serie-Numero', datafield: 'serieNumero', width: '10%'},
				{ text: 'Fecha', datafield: 'fechaEmision', width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Cliente', datafield: 'cliente', width: '30%'},
				{ text: 'Documento', datafield: 'documentoIdentidad', width: '10%'},
				{ text: 'Nro Doc.', datafield: 'nroDocumentoIdentidad', width: '10%'},
				{ text: 'Moneda', datafield: 'moneda', width: '8%'},
				{ text: 'Total Venta', datafield: 'totalVenta', width: '12%', cellsalign: 'right', cellsformat: 'd2' },
				{ text: 'Estado', datafield: 'estado', width: '10%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaFacturaBoleta").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaFacturaBoleta").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaFacturaBoleta").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});


	$("#popupFacturaBoletaDiv").jqxWindow({
		width: "350", height:"220", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), 
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupFacturaBoletaDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formFacturaBoletaDiv").load("ventas/factura_boleta/nuevoFacturaBoleta.php?p="+Math.random());
        
	});	
	
	function Abrir_Popup_Nuevo_Comprobante_Venta(){
		Limpiar_Popups();

        $('#popupFacturaBoletaDiv').jqxWindow('setTitle', 'Nuevo Comprobante de Venta');
        $("#popupFacturaBoletaDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Comprobante_Venta(){
		$("#popupFacturaBoletaDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formFacturaBoletaDiv").html("");
	}

    function Obtener_Comprobante_Venta_Fila(){
        var idFacturaBoleta = "0";
		var rowscount = $("#jqxGridListaFacturaBoleta").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaFacturaBoleta").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaFacturaBoleta").jqxGrid('getrowid', selectedrowindex);
			var dataListaFacturaBoleta = $("#jqxGridListaFacturaBoleta").jqxGrid('getrowdata', selectedrowindex);
            idFacturaBoleta = dataListaFacturaBoleta.idFacturaBoleta;
		}
        
        return idFacturaBoleta;
    }
    
    function Eliminar_Comprobante_Venta(){
        var idFacturaBoleta = Obtener_Comprobante_Venta_Fila();
        if(idFacturaBoleta == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al facturaBoleta ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "ventas/factura_boleta/deleteFacturaBoleta.php?p="+Math.random(),
			data : { idFacturaBoleta: idFacturaBoleta },
			success: function(result){
               
				if(result == 1){
					alert("Se elimino al facturaBoleta satisfactoriamente" );
                    
					$("#jqxGridListaFacturaBoleta").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al facturaBoleta");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idFacturaBoleta){
		
		var newWindow = window.open("ventas/factura_boleta/impresionFacturaBoleta.php?idFacturaBoleta="+idFacturaBoleta,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		
		newWindow.print();
	}
	
	
    
	function TestLista(){
	
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			idComprobante: $.trim($("#cboComprobanteFiltro").val()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		
		$('#debug').html(filtro);
        console.log(filtro);
		
		$.ajax({
			type: "POST",            
			url: "ventas/factura_boleta/dataListaFacturaBoleta.php?p="+Math.random(),
			data: { filtro: filtro },
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
	
		
	
</script>