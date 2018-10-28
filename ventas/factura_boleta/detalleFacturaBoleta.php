<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
?>

        <div id="jqxGridDetalle"></div>
        
        <input type="hidden" id="tipoProductoB" value="" />

<div id="popupBuscarProductoDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarProductoDiv"></div>
</div>

<div id="popupBuscarGRDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarGRDiv"></div>
</div>
<!--
<div id="popupBuscarServicioDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarServicioDiv"></div>
</div>
-->
<?php

}else{
    $sMessage = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>

<script type="text/javascript">

	$(document).ready(function(){
        
		var idCabeceraFB = $("#idCabeceraFB").val();
		
		$("#jqxGridDetalle").jqxGrid('clear');
								
		var data = {};
        //var theme = 'classic';
        var idProductoe = new Array();
		var tipoProductoe = new Array();
        var codigoe = new Array();
		var descripcione = new Array();
		var cantidade = new Array();
		var pesoe = new Array();
		var unidade = new Array();
		var importee = new Array();
        
        var generaterow = function (i) {
			var row = {};
			var firtnameindex = idProductoe.length-1;			
			row["idProducto"] = idProductoe[firtnameindex];
			row["tipoProducto"] = tipoProductoe[firtnameindex];
			//row["item"] = i + 1 ;   //iteme[firtnameindex];
			row["codigo"] = codigoe[firtnameindex];			
			row["descripcion"] = descripcione[firtnameindex];
			row["cantidad"] = cantidade[firtnameindex];
			//row["peso"] = pesoe[firtnameindex];
			row["precioUnitario"] = precioUnitarioe[firtnameindex];
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
				{ name: 'idProducto', type: 'string'},
				{ name: 'tipoProducto', type: 'string'},
				{ name: 'codigo', type: 'string'},
				{ name: 'cantidad', type: 'string'},
				{ name: 'descripcion', type: 'string'},
				{ name: 'precioUnitario', type: 'number'},
				{ name: 'importe', type: 'number'}
			],
            sortname: 'descripcion',
			type: "POST",
			data: { idCabeceraFB: idCabeceraFB },
			url: "ventas/factura_boleta/dataDetalleFacturaBoleta.php?p="+Math.random(),
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
            //ide: 'idProducto',         
			width: '99%',
			height: '310px',
            showtoolbar: true,
            statusbarheight: 40,
            selectionmode: 'singlerow',
            editable: false,
            editmode: 'selected cell click',     //'Click' ,  //'Double-Click', //'Selected Cell Click',   //'click',  //'selectedrow',
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
				
				//container.append('<button id="btnAgregarProducto" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Agregar</button>&nbsp;');
				container.append('<button id="btnAgregarGR" type="button" class="btn btn-info" ><i class="fa fa-ok"></i>&nbsp;Agregar Producto</button>&nbsp;');
				container.append('<button id="btnAgregarServicio" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Agregar Servicio</button>&nbsp;');
												
				//container.append('<button id="btnEliminarProducto" type="button" class="btn btn-danger" ><i class="fa fa-ok"></i>&nbsp;Eliminar</button>&nbsp;');
				container.append('<button id="btnLimpiarDetalle" type="button" class="btn btn-danger" ><i class="fa fa-ok"></i>&nbsp;Limpiar</button>&nbsp;');
								
				/*
				$("#btnAgregarProducto").click(function () {					
					Abrir_Popup_Buscar_Producto();
				});
				*/
				$("#btnAgregarGR").click(function () {
					//Limpiar_Popups();		
					if(Validar_Cliente_Seleccionado()){			
						Abrir_Popup_Buscar_GR();
					}
				});
				
				$("#btnAgregarServicio").click(function () {
					//Limpiar_Popups();				
					Abrir_Popup_Buscar_Producto("SERVICIO");
				});
				/*
				$("#btnEliminarProducto").click(function () {
					//Limpiar_Popups();
					Eliminar_Producto();					
				});
				*/
				$("#btnLimpiarDetalle").click(function () {	
					if(!confirm(" ¿ Esta seguro de limpiar el detalle ?")){
						return false;
					}		
					$("#jqxGridDetalle").jqxGrid('clear');
					Sumar_Totales();
					Obtener_Numero_A_Letras();
				});
				
				
            },
            ready: function () {
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'idProducto');
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'tipoProducto');
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'codigo');
            },
			columns: [
				{ text: 'ID', datafield: 'idProducto', width: '0' },
				{ text: 'Tipo Producto', datafield: 'tipoProducto', width: '0' },
				{ text: 'Codigo', datafield: 'codigo', width: '0' },
				{ text: 'Cantidad', datafield: 'cantidad', width: '10%', cellsalign: 'left', columntype: 'integer', cellsformat: 'n' },
				{ text: 'Descripcion', datafield: 'descripcion', width: '70%' },
				{ text: 'Precio Unitario', datafield: 'precioUnitario', width: '10%', cellsalign: 'right', cellsformat: 'd2' },
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
			
			/*
			var dataRecord = $("#jqxGridDetalle").jqxGrid('getrowdata', rowindex);
            //var itemU = dataRecord.item;
			//alert("dataRecord:"+dataRecord);
			
            if(column == "cantidad" || column == "importe"){
				//alert(dataRecord.idProducto);
				if($.trim(dataRecord.descripcion)!=""){
					if($.trim(value)!=""){					
						if(!isNaN(value)){
							if(parseInt(value) >= 0){
								var cantidad = 0;																																															
								var importe = 0.00;
								if(column=="cantidad"){
									var cantidad = parseInt(value);
									var importe = 0.00 + parseFloat(dataRecord.importe);
								}else{
									if(column=="importe"){
										var cantidad = 0 + parseInt(dataRecord.cantidad);
										var importe = parseFloat(value);
									}
								}							
								
								//var cantidad = parseInt(value);
								//var importe = parseFloat(dataRecord.importe);
								var importe = parseFloat((cantidad*importe));
								if(!isNaN(importe)){
									dataRecord.importe = importe;
								}else{
									dataRecord.importe = "0.00";
								}
							}else{
								dataRecord.cantidad = "0";
								dataRecord.importe = "0.00";
								alert("La cantidad debe ser entero mayor a cero");
							}
					
						}else{
							dataRecord.cantidad = "0";
							dataRecord.importe = "0.00";
							alert("La cantidad no es numerico");
						}
					}
					
				}else{
					dataRecord.cantidad = "";
					dataRecord.importe = "";
					//$.prompt("No hay producto");
				}
				
				var rowID = $('#jqxGridDetalle').jqxGrid('getrowid', rowindex);
				$('#jqxGridDetalle').jqxGrid('updaterow', rowID, dataRecord);
				//Sumar_Totales();
				
            }
        	*/
        });
        //TestLista();
		
	});

	/*
	//Popup Buscar Producto
	$("#popupBuscarProductoDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900",
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25, position: 'center', showCollapseButton: true
	});
    
	$("#popupBuscarProductoDiv").on('open', function () {
		Limpiar_Popups();
		
		$("#formBuscarProductoDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarProductoDiv").load("ventas/buscar_producto/filtroProducto.php?p="+Math.random());
        
	});		
	
	function Abrir_Popup_Buscar_Producto(){
		Limpiar_Popups();

        $('#popupBuscarProductoDiv').jqxWindow('setTitle', 'Buscar Producto');
        $("#popupBuscarProductoDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Producto(){
		$("#popupBuscarProductoDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Producto(){
		$("#idProducto").val("");
		$("#producto").val("");
		$("#rucProducto").val("");
	}
	
	function Seleccionar_Producto(){
		Limpiar_Producto();
		
		var rowscount = $("#jqxGridListaProducto").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaProducto").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaProducto").jqxGrid('getrowid', selectedrowindex);
			var dataListaProducto = $("#jqxGridListaProducto").jqxGrid('getrowdata', selectedrowindex);
			
			var idProducto = $.trim(dataListaProducto.idProducto);
			//alert("idProducto:"+idProducto);
			//alert(Existe_Producto_En_Detalle(idProducto));
			//if(!Existe_Producto_En_Detalle(idProducto)){
			if(!Existe_Fila_Duplicado_En_Grid("jqxGridDetalle", "idProducto", idProducto)){			
				var datarow = 	{
									idProducto	: $.trim(dataListaProducto.idProducto),
									codigo 		: $.trim(dataListaProducto.codigo),
									descripcion : $.trim(dataListaProducto.producto),
									cantidad 	: "0",
									peso 		: "0",
									precioUnitario: $.trim(dataListaProducto.precioUnitario),
									importe 		: $.trim(dataListaProducto.importe)
								};
			
				var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
			}
			
			Cerrar_Popup_Buscar_Producto();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
		}
	}
	*/
	
	

	//Popup Buscar Producto
	$("#popupBuscarProductoDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900",
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25, position: 'center', showCollapseButton: true
	});
    
	$("#popupBuscarProductoDiv").on('open', function () {
		Limpiar_Popups();
		var tipoProducto = $.trim($("#tipoProductoB").val());
		
		$("#formBuscarProductoDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarProductoDiv").load("ventas/buscar_producto/filtroProducto.php?p="+Math.random(), { tipoProducto: tipoProducto } );
        
	});		
	
	function Abrir_Popup_Buscar_Producto(tipoProducto){
		Limpiar_Popups();
		$("#tipoProductoB").val(tipoProducto);
		
        $('#popupBuscarProductoDiv').jqxWindow('setTitle', 'Buscar '+tipoProducto);
        $("#popupBuscarProductoDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_Producto(){
		$("#popupBuscarProductoDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_Producto(){
		$("#idProducto").val("");
		$("#razonSocialProducto").val("");
		$("#rucProducto").val("");
	}
	
	function Seleccionar_Producto(){
		Limpiar_Producto();
		
		var rowscount = $("#jqxGridListaProducto").jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#jqxGridListaProducto").jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#jqxGridListaProducto").jqxGrid('getrowid', selectedrowindex);
			var dataListaProducto = $("#jqxGridListaProducto").jqxGrid('getrowdata', selectedrowindex);
			
			var idProducto = $.trim(dataListaProducto.idProducto);
			//alert("idProducto:"+idProducto);
			//alert(Existe_Producto_En_Detalle(idProducto));
			//if(!Existe_Producto_En_Detalle(idProducto)){
			if(!Existe_Fila_Duplicado_En_Grid("jqxGridDetalle", "idProducto", idProducto)){			
				var datarow = 	{
									idProducto		: $.trim(dataListaProducto.idProducto),
									tipoProducto	: $.trim(dataListaProducto.tipoProducto),
									codigo			: $.trim(dataListaProducto.codigo),
									cantidad 		: "1",
									descripcion 	: $.trim(dataListaProducto.descripcion),
									precioUnitario	: $.trim(dataListaProducto.precioUnitario),
									importe			: $.trim(dataListaProducto.precioUnitario)		//SOLO PARA SERVICIO
								};
			
				var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
			}
			
			Sumar_Totales();
			Obtener_Numero_A_Letras();
					
			Cerrar_Popup_Buscar_Producto();
			
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
		
		var comprobante = $.trim($("#cboComprobantePago").val());
		if(comprobante == '0'){
			Mostrar_Mensaje_Notificacion("warning","Debe seleccionar el comprobante");
			return false;
		}
		return true;
		
	}
	
	//Popup Buscar GR
	$("#popupBuscarGRDiv").jqxWindow({
		width: "950", height:"480", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900",
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25, position: 'center', showCollapseButton: true
	});
    
	$("#popupBuscarGRDiv").on('open', function () {
		Limpiar_Popups();
		
		var filtro = {
			idCliente : $.trim($("#idCliente").val()),
			cliente: $.trim($("#cliente").val())
        };
		//console.log(filtro);
		
		$("#formBuscarGRDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		//$("#formBuscarGRDiv").load("ventas/buscar_guia_remision/filtroBuscarGR.php?p="+Math.random());
		$("#formBuscarGRDiv").load("ventas/buscar_guia_remision/listaBuscarGR.php?p="+Math.random(), { filtro: filtro });
        
	});		
	
	function Abrir_Popup_Buscar_GR(){
		Limpiar_Popups();

        $('#popupBuscarGRDiv').jqxWindow('setTitle', 'Agregar Productos de la Guia de Remision');
        $("#popupBuscarGRDiv").jqxWindow('open');
        
        return true;
	}

	function Cerrar_Popup_Buscar_GR(){
		$("#popupBuscarGRDiv").jqxWindow('hide');
		Limpiar_Popups();
	}
	
	function Limpiar_BuscarGR(){
		$("#idGR").val("");
		$("#razonSocialGR").val("");
		$("#rucGR").val("");
	}
	

	function Seleccionar_BuscarGR(){
		Limpiar_BuscarGR();
		
		var cabecerasGR = ""
		var selectedrows = Obtener_Filas_Seleccionadas("jqxGridListaGR");
		//console.log(selectedrows.length);
		//console.log("*****************************");
		
		if(selectedrows.length > 0){
			for(var i = 0; i < selectedrows.length; i++){
				cabecerasGR = selectedrows[i]['idCabeceraGR'] + "," + cabecerasGR  ;
			}
			cabecerasGR = cabecerasGR.substring(0, cabecerasGR.length - 1);
		}
		
		console.log(cabecerasGR);
		//alert("ok");
		//console.log("*****************************");
		//return false;
		
		$.ajax({
			type: "POST",            
			url: "ventas/buscar_guia_remision/dataDetalleGRforFB.php?p="+Math.random(),
			data: { cabecerasGR: cabecerasGR },
			success: function(result){
				//alert(dataListaProducto);
				//$('#debug').html(dataListaProducto);
				//console.log(result);
				//console.log("*****************************");
				var jsonData = JSON.parse(result);
				//console.log("data:"+jsonData);
				//console.log("*****************************");
				//console.log("length:"+jsonData.length);
				if(jsonData.length > 0){
					for(var i = 0; i < jsonData.length; i++){
						//console.log(jsonData[i].idProducto);
						//console.log("111*****************************");
						var datarow = {
										idProducto		: $.trim(jsonData[i].idProducto),
										tipoProducto	: $.trim(jsonData[i].tipoProducto),
										codigo			: $.trim(jsonData[i].codigo),
										cantidad 		: $.trim(jsonData[i].cantidad),
										descripcion 	: $.trim(jsonData[i].descripcion),
										precioUnitario	: $.trim(jsonData[i].precioUnitario),
										importe 		: $.trim(jsonData[i].importe)
									  };
						//console.log(datarow);
						var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);						
					}
					Sumar_Totales();
					Obtener_Numero_A_Letras();
				}
			},
			error: function(){
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error");
			}
		})
			
		Cerrar_Popup_Buscar_GR();

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
				Mostrar_Mensaje_Notificacion("error","Se ha producido un error");
			}
		})	
			
	}
	
	/*
	function Obtener_Detalle_GR(idCabeceraGR){
		
		//var idCabecera = $("#idCabeceraFB").val();
		//alert(idCabeceraFB);
		//$('#debug').html(idCabeceraFB);
        //console.log(idCabeceraFB);
		
		$.ajax({
			type: "POST",
			data: { idCabeceraGR: idCabeceraGR },
			url: "ventas/factura_boleta/dataDetalleFacturaBoleta.php?p="+Math.random(),
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
		
		var comprobante = $.trim($('select[name="cboComprobantePago"] option:selected').text());
		
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
	function Existe_Producto_En_Detalle(idProducto){
		
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;

		for(i=0; i<rowscount; i++){
			var rowId = $('#jqxGridDetalle').jqxGrid('getrowid', i);
			var rowDetalle = $('#jqxGridDetalle').jqxGrid('getrowdatabyid', rowId);
			if( $.trim(idProducto) == $.trim(rowDetalle.idProducto) ){
				return true;
			}
		}
		return false;
	}
	*/
	
    function Eliminar_Producto(){
		
		/*
        var idProducto =  Obtener_Columna_ObjGrid_Fila_Sel("jqxGridListaProducto", "idProducto");
		alert(idProducto);
		//Obtener_VentaServicio_Fila();
        if(idProducto == "0" || idProducto == ""){
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
					Obtener_Numero_A_Letras();
				}
			}
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
			return false;
		}
    }

	


/*
-------------------------------------------------------------------------------------------------------
*/
	
		
   
	function TestLista(){
	
		var idCabeceraFB = $("#idCabeceraFB").val();
		alert(idCabeceraFB);
		$('#debug').html(idCabeceraFB);
        console.log(idCabeceraFB);
		
		$.ajax({
			type: "POST",
			data: { idCabeceraFB: idCabeceraFB },
			url: "ventas/factura_boleta/dataDetalleFacturaBoleta.php?p="+Math.random(),
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