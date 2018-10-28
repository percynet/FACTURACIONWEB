<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
?>

        <div id="jqxGridDetalle"></div>
        
        <input type="hidden" id="tipoDetalleB" value="" />

<div id="popupBuscarDetalleDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarDetalleDiv"></div>
</div>

<?php

}else{
    $sMessage = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>

<script type="text/javascript">

	$(document).ready(function(){
        
		var idCabeceraNota = $("#idCabeceraNota").val();
		
		$("#jqxGridDetalle").jqxGrid('clear');
								
		var data = {};
        //var theme = 'classic';
        var idDetallee = new Array();
		//var iteme = new Array();
		var descripcione = new Array();
		var importee = new Array();
        
        var generaterow = function (i) {
			var row = {};
			var firtnameindex = idDetallee.length-1;
			row["idDetalle"] = idDetallee[firtnameindex];			
			//row["item"] = i + 1 ;   //iteme[firtnameindex];			
			row["descripcion"] = descripcione[firtnameindex];			
			row["importe"] = importee[firtnameindex];

			return row;
		}
        /* 
		for (var i = 0; i < 10; i++) {
			var row = generaterow(i);
			data[i] = row;
		}
		*/
		
		var source = 
		{
			//localdata: data,
            //datatype: "local",
			datatype: "json",            
			datafields: [
				{ name: 'idDetalle', type: 'string'},
				//{ name: 'item', type: 'string'},
				{ name: 'descripcion', type: 'string'},
				{ name: 'importe', type: 'number'}
			],
            sortname: 'descripcion',
			type: "POST",
			data: { idCabeceraNota: idCabeceraNota },
			url: "ventas/nota/dataDetalleNota.php?p="+Math.random(),
			cache: false,
            addrow: function (rowid, rowdata, position, commit) {
                // synchronize with the server - send insert command
                // call commit with parameter true if the synchronization with the server is successful 
                //and with parameter false if the synchronization failed.
                // you can pass additional argument to the commit callback which represents the new ID if it is generated from a DB.
                commit(true);
            },
            deleterow: function (rowid, commit) {
                // synchronize with the server - send delete command
                // call commit with parameter true if the synchronization with the server is successful 
                //and with parameter false if the synchronization failed.
                commit(true);
            },
            updaterow: function (rowid, newdata, commit) {
                // synchronize with the server - send update command
                // call commit with parameter true if the synchronization with the server is successful 
                // and with parameter false if the synchronization failed.
                commit(true);
            }
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
					//var records = dataAdapter.records;
                }
       	});
				
		$("#jqxGridDetalle").jqxGrid(
		{
            source: dataAdapter,
            //ide: 'idDetalle',         
			width: '99%',
			height: '310px',
            showtoolbar: true,
            statusbarheight: 40,
            selectionmode: 'singlerow',
            editable: true,
            editmode: 'selected cell click',     //'Click' ,  //'Double-Click', //'Selected Cell Click',   //'click',  //'selectedrow',
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
				
				//container.append('<button id="btnAgregarDetalle" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Agregar</button>&nbsp;');
				container.append('<button id="btnAgregarDetalle" type="button" class="btn btn-info" ><i class="fa fa-ok"></i>&nbsp;Agregar</button>&nbsp;');							
				container.append('<button id="btnEliminarDetalle" type="button" class="btn btn-danger" ><i class="fa fa-ok"></i>&nbsp;Eliminar</button>&nbsp;');
				container.append('<button id="btnLimpiarDetalle" type="button" class="btn btn-warning" ><i class="fa fa-ok"></i>&nbsp;Limpiar</button>&nbsp;');
				
				$("#btnAgregarDetalle").click(function () {
					var datarow = generaterow();
                    var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
					Mostrar_Mensaje_Notificacion("warning","Debe ingresar la descripcion e importe");
				});
				
				$("#btnEliminarDetalle").click(function () {
					Eliminar_Detalle();					
				});
				
				$("#btnLimpiarDetalle").click(function () {	
					if(!confirm(" ¿ Esta seguro de limpiar el detalle ?")){
						return false;
					}		
					$("#jqxGridDetalle").jqxGrid('clear');
					Sumar_Totales();
				});
				
            },
            ready: function () {
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'idDetalle');
            },
			columns: [
				{ text: 'ID', datafield: 'idDetalle', width: '0' },
				//{ text: 'Item', datafield: 'item', width: '10%' },				
				{ text: 'Descripcion', datafield: 'descripcion', width: '90%' },				
				{ text: 'Importe', datafield: 'importe', width: '10%', cellsalign: 'right', cellsformat: 'd2' }
			]
        
		});
		
		//$("#jqxGridDetalle .jqx-widget-content").css("font-size","12px");
		
        // display selected row index.
        $("#jqxGridDetalle").on('	', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridDetalle").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridDetalle").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;         
        });
		
	
        $("#jqxGridDetalle").on('cellvaluechanged', function (event) {
            var column = event.args.datafield;
			var rowindex = event.args.rowindex;
			var value = event.args.newvalue;
			var oldvalue = event.args.oldvalue;
						
			var dataRecord = $("#jqxGridDetalle").jqxGrid('getrowdata', rowindex);
            //var itemU = dataRecord.item;
			//alert("dataRecord:"+dataRecord);
			
            if(column == "importe"){
				//alert(dataRecord.idDetalle);
				if($.trim(dataRecord.descripcion)!=""){
					if($.trim(value)!=""){					
						if(!isNaN(value)){
							if(parseInt(value) >= 0){
								Sumar_Totales();
							}else{
								dataRecord.cantidad = "0";
								dataRecord.importe = "0.00";
								Mostrar_Mensaje_Notificacion("warning","El importe debe ser entero mayor a cero");
							}
					
						}else{
							dataRecord.importe = "0.00";
							Mostrar_Mensaje_Notificacion("warning","El importe no es numerico");
						}
					}
					
				}else{
					dataRecord.importe = "";
					//$.prompt("No hay producto");
				}
				
				var rowID = $('#jqxGridDetalle').jqxGrid('getrowid', rowindex);
				$('#jqxGridDetalle').jqxGrid('updaterow', rowID, dataRecord);
				Sumar_Totales();
				
            }
        	
        });
        //TestLista();
		
	});

	/*
	function Seleccionar_Detalle(){
		Limpiar_Detalle();
		
		var rowscount = $("#jqxGridListaDetalle").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaDetalle").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaDetalle").jqxGrid('getrowid', selectedrowindex);
			var dataListaDetalle = $("#jqxGridListaDetalle").jqxGrid('getrowdata', selectedrowindex);
			
			var idDetalle = $.trim(dataListaDetalle.idDetalle);
			//alert("idDetalle:"+idDetalle);
			//alert(Existe_Detalle_En_Detalle(idDetalle));
			//if(!Existe_Detalle_En_Detalle(idDetalle)){
			if(!Existe_Fila_Duplicado_En_Grid("jqxGridDetalle", "idDetalle", idDetalle)){			
				var datarow = 	{
									idDetalle	: $.trim(dataListaDetalle.idDetalle),
									codigo 		: $.trim(dataListaDetalle.codigo),
									descripcion : $.trim(dataListaDetalle.producto),
									cantidad 	: "0",
									peso 		: "0",
									precioUnitario: $.trim(dataListaDetalle.precioUnitario),
									importe 		: $.trim(dataListaDetalle.importe)
								};
			
				var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
			}
			
			Cerrar_Popup_Buscar_Detalle();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
		}
	}
	*/
	
	
	function Limpiar_Detalle(){
		$("#idDetalle").val("");
	}
	
	function Seleccionar_Detalle(){
		Limpiar_Detalle();
		
		var rowscount = $("#jqxGridListaDetalle").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaDetalle").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaDetalle").jqxGrid('getrowid', selectedrowindex);
			var dataListaDetalle = $("#jqxGridListaDetalle").jqxGrid('getrowdata', selectedrowindex);
			
			var idDetalle = $.trim(dataListaDetalle.idDetalle);
			//alert("idDetalle:"+idDetalle);
			//alert(Existe_Detalle_En_Detalle(idDetalle));
			//if(!Existe_Detalle_En_Detalle(idDetalle)){
			if(!Existe_Fila_Duplicado_En_Grid("jqxGridDetalle", "idDetalle", idDetalle)){			
				var datarow = 	{
									idDetalle		: $.trim(dataListaDetalle.idDetalle),
									tipoDetalle	: $.trim(dataListaDetalle.tipoDetalle),
									codigo			: $.trim(dataListaDetalle.codigo),
									cantidad 		: "1",
									descripcion 	: $.trim(dataListaDetalle.descripcion),
									precioUnitario	: $.trim(dataListaDetalle.precioUnitario),
									importe			: $.trim(dataListaDetalle.precioUnitario)		//SOLO PARA SERVICIO
								};
			
				var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
			}
			
			Sumar_Totales();
								
			Cerrar_Popup_Buscar_Detalle();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
		}
	}
	
	
	
	function Validar_Cliente_Seleccionado(){
		var idCliente = $("#idCliente").val();
		//alert(idCliente);
		
		if(idCliente == "0" | idCliente == ""){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar un cliente");
			return false;
		}
		
		var comprobante = $.trim($("#cboComprobantePagoRef").val());
		if(comprobante == '0'){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el comprobante");
			return false;
		}
		return true;
		
	}
	
	function Obtener_Numero_A_Letras(){
		
		var totalVentaNumero = $("#totalVenta").val();
		if(totalVentaNumero == "0.00"){
			$("#totalLetras").val("");
			return false;	
		}
		
		$.ajax({
			type: "POST",
			data: { totalVentaNumero: totalVentaNumero },
			url: "utiles/getNumerosALetras.php?p="+Math.random(),
			success: function(result){
				//alert(result);
				//$('#debug').html(result);
        		//console.log(result);
				
				$("#totalLetras").val(result);
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error. No puede continuar con el proceso.");
			}
		})	
			
	}
	
	
	function Limpiar_Totales(){
		$("#totalImporte").val("0.00");
		$("#totalIGV").val("0.00");
		$("#totalVenta").val("0.00");
	}	
		
	function Sumar_Totales(){
		
		Limpiar_Totales();
		
		var totalImporte = 0;
		var porcIgv = 0;			//parseFloat($("#porcIgv").val());

		var totalIGV = 0;
		var totalVenta = 0;
		
		var comprobante = $.trim($('select[name="cboComprobantePagoRef"] option:selected').text());
		
		if(comprobante == "FACTURA"){
			porcIgv = 0.18;				//solo para facturas
		}
		
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;

		for(i=0; i<rowscount; i++){
			var rowId = $('#jqxGridDetalle').jqxGrid('getrowid', i);
			var rowDetalle = $('#jqxGridDetalle').jqxGrid('getrowdatabyid', rowId);
			//alert(rowDetalle.importe);
			if(!isNaN(rowDetalle.importe)){
				totalVenta = parseFloat(totalVenta) + parseFloat(rowDetalle.importe);
			}
		}
		
		//totalImporte = totalVenta/(1+(porcIgv/100));
		//totalIGV = totalVenta - totalImporte;
		
		totalIGV = (totalVenta)*(porcIgv);
		totalImporte = totalVenta - totalIGV;
			
		$("#totalImporte").val(parseFloat(totalImporte).toFixed(2));
		$("#totalIGV").val(parseFloat(totalIGV).toFixed(2));
		$("#totalVenta").val(parseFloat(totalVenta).toFixed(2));
	}
		
		
	/*
	function Existe_Detalle_En_Detalle(idDetalle){
		
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;

		for(i=0; i<rowscount; i++){
			var rowId = $('#jqxGridDetalle').jqxGrid('getrowid', i);
			var rowDetalle = $('#jqxGridDetalle').jqxGrid('getrowdatabyid', rowId);
			if( $.trim(idDetalle) == $.trim(rowDetalle.idDetalle) ){
				return true;
			}
		}
		return false;
	}
	*/
	
    function Eliminar_Detalle(){
		
		/*
        var idDetalle =  Obtener_Columna_ObjGrid_Fila_Sel("jqxGridListaDetalle", "idDetalle");
		alert(idDetalle);
		//Obtener_VentaServicio_Fila();
        if(idDetalle == "0" || idDetalle == ""){
            //alert("No ha seleccionado una fila");
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
            return false;
        }
        */
		var selectedrowindex = $("#jqxGridDetalle").jqxGrid('getselectedrowindex');
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridDetalle").jqxGrid('getrowid', selectedrowindex);
			if(id > -1){
				var producto = Obtener_Columna_ObjGrid_Fila_Sel("jqxGridDetalle", "descripcion");
				
				if(!confirm(" Esta seguro de eliminar el producto " + producto + " de la lista ?")){
					return false;
				}else{
					var commit = $("#jqxGridDetalle").jqxGrid('deleterow', id);
					
					Sumar_Totales();
					
				}
			}
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
			return false;
		}
    }
	
    /*
	function TestLista(){
	
		var idCabeceraNota = $("#idCabeceraNota").val();
		//alert(idCabeceraNota);
		$('#debug').html(idCabeceraNota);
        console.log(idCabeceraNota);
		
		$.ajax({
			type: "POST",
			data: { idCabeceraNota: idCabeceraNota },
			url: "ventas/nota/dataDetalleNota.php?p="+Math.random(),
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