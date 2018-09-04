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
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		  
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idCabeceraFB'},				
				{ name: 'fechaEmision', type: 'date', format: 'yyyy-MM-dd'},
				{ name: 'serieNumero', type: 'string'},
				{ name: 'comprobante', type: 'string'},
				{ name: 'cliente', type: 'string'},
				{ name: 'formaPago', type: 'string'},
				{ name: 'moneda', type: 'string'},
				{ name: 'totalVenta', type: 'string'}
				//{ name: 'estado', type: 'string'}
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
            //ide: 'idCabeceraFB',
            width: '100%',
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
                //container.append('<button id="btnEliminar" type="button" class="btn btn-danger" ><i class="fa fa-remove"></i>&nbsp;Eliminar</button>&nbsp;'); 
				//container.append('<button id="btnImprimir" type="button" class="btn" ><i class="fa-print"></i>&nbsp;Imprimir</button>&nbsp;');
				container.append('<button id="btnImprimirLista" type="button" class="btn btn-success" ><i class="fa fa-print"></i>&nbsp;Imprimir Lista</button>&nbsp;'); 
				
				$("#btnNuevo").on('click', function () {
					var accion = "0";
					var idCabeceraFB = "0";
					$("#containerMain").load('ventas/factura_boleta/cabeceraFacturaBoleta'+".php?p="+Math.random(), {accion:accion, idCabeceraFB: idCabeceraFB} );
					//Ir_A_Pagina('ventas/factura_boleta/cabeceraFacturaBoleta');
				});
				
				$("#btnEditar").on('click', function () {
					var accion = "1";
					var idCabeceraFB = Obtener_Comprobante_Venta_Fila();					
					
					if(idCabeceraFB == "0"){
						alert("No ha seleccionado una fila");
						return false;
					}
					$("#containerMain").load('ventas/factura_boleta/cabeceraFacturaBoleta'+".php?p="+Math.random(), {accion: accion, idCabeceraFB: idCabeceraFB} );
				    //Ir_A_Pagina_Con_Parametros('ventas/factura_boleta/cabeceraFacturaBoleta', parametros);
				});
                /*
                $("#btnEliminar").on('click', function () {
					Eliminar_Comprobante_Venta();
				});
				*/
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaFacturaBoleta", "Listado de FacturaBoletas");
				});
			},	
            ready: function () {
                $("#jqxGridListaFacturaBoleta").jqxGrid('hidecolumn', 'idCabeceraFB');
            },
			columns: [
				{ text: 'ID', datafield: 'idCabeceraFB', width: '0%'},
				{ text: 'Fecha Emision', datafield: 'fechaEmision', width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Serie-Numero', datafield: 'serieNumero', width: '10%'},
				{ text: 'Comprobante', datafield: 'comprobante', width: '10%'},
				{ text: 'Cliente', datafield: 'cliente', width: '40%'},
				{ text: 'Forma Pago', datafield: 'formaPago', width: '10%'},
				{ text: 'Moneda', datafield: 'moneda', width: '10%'},
				{ text: 'Total Venta', datafield: 'totalVenta', width: '10%'}
				//{ text: 'Estado', datafield: 'estado', width: '6%'}
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
        var idCabeceraFB = "0";
		var rowscount = $("#jqxGridListaFacturaBoleta").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaFacturaBoleta").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaFacturaBoleta").jqxGrid('getrowid', selectedrowindex);
			var dataListaFacturaBoleta = $("#jqxGridListaFacturaBoleta").jqxGrid('getrowdata', selectedrowindex);
            idCabeceraFB = dataListaFacturaBoleta.idCabeceraFB;
		}
        
        return idCabeceraFB;
    }
    
    function Eliminar_Comprobante_Venta(){
        var idCabeceraFB = Obtener_Comprobante_Venta_Fila();
        if(idCabeceraFB == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al factura_boleta ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "ventas/factura_boleta/deleteFacturaBoleta.php?p="+Math.random(),
			data : { idCabeceraFB: idCabeceraFB },
			success: function(result){
               
				if(result == 1){
					alert("Se elimino al factura_boleta satisfactoriamente" );
                    
					$("#jqxGridListaFacturaBoleta").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al factura_boleta");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idCabeceraFB){
		
		var newWindow = window.open("ventas/factura_boleta/impresionFacturaBoleta.php?idCabeceraFB="+idCabeceraFB,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		
		newWindow.print();
	}
	
	/*
	function TestLista(){
	
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		
		$('#debug').html(filtro);
        console.log(filtro);
		console.log("*********************");
		$.ajax({
			type: "POST",            
			url: "ventas/factura_boleta/dataListaFacturaBoleta.php?p="+Math.random(),
			data: { filtro: filtro },
			success: function(result){
				//alert(result);
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