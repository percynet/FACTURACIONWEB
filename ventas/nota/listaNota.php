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

		<div id="jqxGridListaNota"></div>

        <input type="hidden" id="accion" />

        <div id="popupNotaDiv">
            <div style="overflow: hidden;"></div>
            <div id="formNotaDiv"></div>
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
        
		$("#jqxGridListaNota").jqxGrid('clear');
		
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			idTipoNota: $.trim($("#cboTipoNotaFiltro").val()),
			tipoNota: $.trim($( "#cboTipoNotaFiltro option:selected" ).text()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val()),
			idEstado: $.trim($("#cboEstadoFiltro").val()),
			estado: $.trim($("#cboEstadoFiltro option:selected").text())
        };
		  
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idCabeceraNota'},				
				{ name: 'fechaEmision', type: 'date', format: 'yyyy-MM-dd'},
				{ name: 'tipoNota', type: 'string'},
				{ name: 'serieNumeroNota', type: 'string'},
				{ name: 'comprobantePagoRef', type: 'string'},
				{ name: 'cliente', type: 'string'},
				{ name: 'moneda', type: 'string'},
				{ name: 'totalVenta', type: 'string'}
				//{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro },
			url: "ventas/nota/dataListaNota.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaNota").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCabeceraNota',
            width: '100%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            showtoolbar: true,
            //editable: true,
            editmode: 'selected cell click',
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
				//container.append('<button id="btnEditar" type="button" class="btn" ><i class="icon-pencil"></i>&nbsp;Editar</button>&nbsp;');
				//container.append('<button id="btnAbrir" type="button" class="btn btn-success" ><i class="fa fa-share"></i>&nbsp;Abrir</button>&nbsp;');
            selectionmode: 'singlerow',
				container.append('<button id="btnNuevo" type="button" class="btn btn-info" ><i class="fa fa-ok"></i>&nbsp;Nuevo</button>&nbsp;');  
                container.append('<button id="btnEditar" type="button" class="btn btn-warning" ><i class="fa fa-remove"></i>&nbsp;Editar</button>&nbsp;'); 
                //container.append('<button id="btnEliminar" type="button" class="btn btn-danger" ><i class="fa fa-remove"></i>&nbsp;Eliminar</button>&nbsp;');
				//container.append('<button id="btnImprimir" type="button" class="btn" ><i class="fa-print"></i>&nbsp;Imprimir</button>&nbsp;');
				container.append('<button id="btnImprimirLista" type="button" class="btn btn-success" ><i class="fa fa-print"></i>&nbsp;Imprimir Lista</button>&nbsp;'); 
				
				$("#btnNuevo").on('click', function () {
					var accion = "0";
					var idCabeceraNota = "0";
					var idTipoNota = $("#cboTipoNotaFiltro").val();
					var tipoNota = $("#cboTipoNotaFiltro option:selected").text();
					
					if(idTipoNota == "0"){
						Mostrar_Mensaje_Notificacion("warning","Debe seleccionar un tipo de nota");
						return false;
					}
					$("#containerMain").load('ventas/nota/cabeceraNota'+".php?p="+Math.random(), 
						{accion:accion, idCabeceraNota: idCabeceraNota, idTipoNota: idTipoNota, tipoNota: tipoNota} );
					//Ir_A_Pagina('ventas/nota/cabeceraNota');
				});
				
				$("#btnEditar").on('click', function () {
					var accion = "1";
					var idCabeceraNota = Obtener_Nota_Fila();					
					var idTipoNota = $("#cboTipoNotaFiltro").val();
					var tipoNota = $("#cboTipoNotaFiltro option:selected").text();
					
					if(idCabeceraNota == "0"){
						Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
						return false;
					}
					$("#containerMain").load('ventas/nota/cabeceraNota'+".php?p="+Math.random(), 
						{accion:accion, idCabeceraNota: idCabeceraNota, idTipoNota: idTipoNota, tipoNota: tipoNota} );
				    //Ir_A_Pagina_Con_Parametros('ventas/nota/cabeceraNota', parametros);
				});
                /*
                $("#btnEliminar").on('click', function () {
					Eliminar_Nota();
				});
				*/
				$("#btnImprimirLista").on('click', function () {
					Imprimir_Lista_Resultados("jqxGridListaNota", "Listado de Notas");
				});
			},	
            ready: function () {
                $("#jqxGridListaNota").jqxGrid('hidecolumn', 'idCabeceraNota');
            },
			columns: [
				{ text: 'ID', datafield: 'idCabeceraNota', width: '0%'},
				{ text: 'Fecha Emision', datafield: 'fechaEmision', width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Tipo Nota', datafield: 'tipoNota', width: '10%'},
				{ text: 'S/N Nota', datafield: 'serieNumeroNota', width: '10%'},
				{ text: 'Comprobante', datafield: 'comprobantePagoRef', width: '10%'},
				{ text: 'Cliente', datafield: 'cliente', width: '40%'},				
				{ text: 'Moneda', datafield: 'moneda', width: '10%'},
				{ text: 'Total Venta', datafield: 'totalVenta', width: '10%'}
				//{ text: 'Estado', datafield: 'estado', width: '6%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaNota").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaNota").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaNota").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();

	});


	$("#popupNotaDiv").jqxWindow({
		width: "350", height:"220", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'),
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25
	});
	
	$("#popupNotaDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formNotaDiv").load("ventas/nota/nuevoNota.php?p="+Math.random());
        
	});	
	
	function Abrir_Popup_Nuevo_Nota(){
		Limpiar_Popups();

        $('#popupNotaDiv').jqxWindow('setTitle', 'Nueva Nota');
        $("#popupNotaDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Nota(){
		$("#popupNotaDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Popups(){
		$("#formNotaDiv").html("");
	}

    function Obtener_Nota_Fila(){
        var idCabeceraNota = "0";
		var rowscount = $("#jqxGridListaNota").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaNota").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaNota").jqxGrid('getrowid', selectedrowindex);
			var dataListaNota = $("#jqxGridListaNota").jqxGrid('getrowdata', selectedrowindex);
            idCabeceraNota = dataListaNota.idCabeceraNota;
		}
        
        return idCabeceraNota;
    }
    
    function Eliminar_Nota(){
        var idCabeceraNota = Obtener_Nota_Fila();
        if(idCabeceraNota == "0"){
            Mostrar_Mensaje_Notificacion("warning","Debe seleccionar una fila");
            return false;
        }
        
        if(!confirm(" Esta seguro de eliminar al nota ?")){
            return false;
        }
        
        $.ajax({
			type: "POST",
			url : "ventas/nota/deleteNota.php?p="+Math.random(),
			data : { idCabeceraNota: idCabeceraNota },
			success: function(result){
               
				if(result == 1){
					Mostrar_Mensaje_Notificacion("sucess","Se elimino la fila satisfactoriamente");
                    
					$("#jqxGridListaNota").jqxGrid('updatebounddata', 'cells');
  
				}else{
                    Mostrar_Mensaje_Notificacion("error","Ocurrio un error al grabar la nota");
				}
				
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error");
			}
		});
        
    }

	
   	function Imprimir(idCabeceraNota){
		
		var newWindow = window.open("ventas/nota/impresionNota.php?idCabeceraNota="+idCabeceraNota,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		
		newWindow.print();
	}
	
	
	/*
	function TestLista(){
	
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			idTipoNota: $.trim($("#cboTipoNotaFiltro").val()),
			tipoNota: $.trim($( "#cboTipoNotaFiltro option:selected" ).text()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		
		$('#debug').html(filtro);
        console.log(filtro);
		console.log("*********************");
		$.ajax({
			type: "POST",            
			url: "ventas/nota/dataListaNota.php?p="+Math.random(),
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