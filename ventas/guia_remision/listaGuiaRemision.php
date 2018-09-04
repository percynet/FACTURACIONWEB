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

		<div id="jqxGridListaGuiaRemision"></div>

        <input type="hidden" id="accion" />

        <div id="popupGuiaRemisionDiv">
            <div style="overflow: hidden;"></div>
            <div id="formGuiaRemisionDiv"></div>
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
        
		$("#jqxGridListaGuiaRemision").jqxGrid('clear');
		
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
				{ name: 'idCabeceraGR'},				
				{ name: 'fechaEmision', type: 'date', format: 'yyyy-MM-dd'},
				{ name: 'fechaTraslado', type: 'date', format: 'yyyy-MM-dd'},
				{ name: 'serieNumero', type: 'string'},				
				{ name: 'clienteRemitente', type: 'string'},
				{ name: 'documentoIdentidad', type: 'string'},
				{ name: 'numeroDocumentoIdentidad', type: 'string'}
				//{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro },
			url: "ventas/guia_remision/dataListaGuiaRemision.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaGuiaRemision").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCabeceraGR',
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
					var idCabeceraGR = "0";
					$("#containerMain").load('ventas/guia_remision/cabeceraGuiaRemision'+".php?p="+Math.random(), {accion:accion, idCabeceraGR: idCabeceraGR} );
					//Ir_A_Pagina('ventas/guia_remision/cabeceraGuiaRemision');
				});
				
				$("#btnEditar").on('click', function () {
					var accion = "1";
					var idCabeceraGR = Obtener_Comprobante_Venta_Fila();					
					
					if(idCabeceraGR == "0"){
						alert("No ha seleccionado una fila");
						return false;
					}
					$("#containerMain").load('ventas/guia_remision/cabeceraGuiaRemision'+".php?p="+Math.random(), {accion: accion, idCabeceraGR: idCabeceraGR} );
				    //Ir_A_Pagina_Con_Parametros('ventas/guia_remision/cabeceraGuiaRemision', parametros);
				});
                /*
                $("#btnEliminar").on('click', function () {
					Eliminar_Comprobante_Venta();
				});
				*/
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaGuiaRemision", "Listado de GuiaRemisions");
				});
			},	
            ready: function () {
                $("#jqxGridListaGuiaRemision").jqxGrid('hidecolumn', 'idCabeceraGR');
            },
			columns: [
				{ text: 'ID', datafield: 'idCabeceraGR', width: '0%'},
				{ text: 'Fecha Emision', datafield: 'fechaEmision', width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Fecha Traslado', datafield: 'fechaTraslado', width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Serie-Numero', datafield: 'serieNumero', width: '20%'},
				{ text: 'Cliente Remitente', datafield: 'clienteRemitente', width: '40%'},
				{ text: 'Doc.Ident.', datafield: 'documentoIdentidad', width: '10%'},
				{ text: 'Nro Doc.Ident.', datafield: 'numeroDocumentoIdentidad', width: '10%'}
				//{ text: 'Estado', datafield: 'estado', width: '6%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaGuiaRemision").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaGuiaRemision").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaGuiaRemision").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();

	});


	$("#popupGuiaRemisionDiv").jqxWindow({
		width: "350", height:"220", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'),
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupGuiaRemisionDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formGuiaRemisionDiv").load("ventas/guia_remision/nuevoGuiaRemision.php?p="+Math.random());
        
	});	
	
	function Abrir_Popup_Nuevo_Comprobante_Venta(){
		Limpiar_Popups();

        $('#popupGuiaRemisionDiv').jqxWindow('setTitle', 'Nuevo Comprobante de Venta');
        $("#popupGuiaRemisionDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Comprobante_Venta(){
		$("#popupGuiaRemisionDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formGuiaRemisionDiv").html("");
	}

    function Obtener_Comprobante_Venta_Fila(){
        var idCabeceraGR = "0";
		var rowscount = $("#jqxGridListaGuiaRemision").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaGuiaRemision").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaGuiaRemision").jqxGrid('getrowid', selectedrowindex);
			var dataListaGuiaRemision = $("#jqxGridListaGuiaRemision").jqxGrid('getrowdata', selectedrowindex);
            idCabeceraGR = dataListaGuiaRemision.idCabeceraGR;
		}
        
        return idCabeceraGR;
    }
    
    function Eliminar_Comprobante_Venta(){
        var idCabeceraGR = Obtener_Comprobante_Venta_Fila();
        if(idCabeceraGR == "0"){
            alert("No ha seleccionado una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al guia_remision ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "ventas/guia_remision/deleteGuiaRemision.php?p="+Math.random(),
			data : { idCabeceraGR: idCabeceraGR },
			success: function(result){
               
				if(result == 1){
					alert("Se elimino al guia_remision satisfactoriamente" );
                    
					$("#jqxGridListaGuiaRemision").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    alert("Ocurrio un error al grabar al guia_remision");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idCabeceraGR){
		
		var newWindow = window.open("ventas/guia_remision/impresionGuiaRemision.php?idCabeceraGR="+idCabeceraGR,
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
			url: "ventas/guia_remision/dataListaGuiaRemision.php?p="+Math.random(),
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