<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
?>

        <div id="jqxGridDetalle"></div>

<div id="popupBuscarProductoDiv">
    <div style="overflow: hidden;"></div>
    <div id="formBuscarProductoDiv"></div>
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
        
		var idCabeceraGR = $("#idCabeceraGR").val();
		
		$("#jqxGridDetalle").jqxGrid('clear');
								
		var data = {};
        //var theme = 'classic';
        var idProductoe = new Array();
        var codigoe = new Array();
		var descripcione = new Array();
		var cantidade = new Array();
		var pesoe = new Array();
		var unidade = new Array();
		var costoUnitarioe = new Array();
        
        var generaterow = function (i) {
			var row = {};
			var firtnameindex = idProductoe.length-1;
			row["idProducto"] = idProductoe[firtnameindex];
			//row["item"] = i + 1 ;   //iteme[firtnameindex];
			row["codigo"] = codigoe[firtnameindex];			
			row["descripcion"] = descripcione[firtnameindex];
			row["cantidad"] = cantidade[firtnameindex];
			row["peso"] = pesoe[firtnameindex];
			row["unidad"] = unidade[firtnameindex];
			row["costoUnitario"] = costoUnitarioe[firtnameindex];

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
				{ name: 'codigo', type: 'string'},
				{ name: 'descripcion', type: 'string'},
				{ name: 'cantidad', type: 'number'},
				{ name: 'peso', type: 'number'},
				{ name: 'unidadMedida', type: 'string'},
				{ name: 'costoUnitario', type: 'number'}
			],
            sortname: 'descripcion',
			type: "POST",
			data: { idCabeceraGR: idCabeceraGR },
			url: "ventas/guia_remision/dataDetalleGuiaRemision.php?p="+Math.random(),
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
            editable: true,
            editmode: 'selected cell click',     //'Click' ,  //'Double-Click', //'Selected Cell Click',   //'click',  //'selectedrow',
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
				
				container.append('<button id="btnAgregarProducto" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Agregar</button>&nbsp;');
				container.append('<button id="btnEliminarProducto" type="button" class="btn btn-danger" ><i class="fa fa-ok"></i>&nbsp;Eliminar</button>&nbsp;');
				
				
				$("#btnAgregarProducto").click(function () {					
					Abrir_Popup_Buscar_Producto();
				});
				
				$("#btnEliminarProducto").click(function () {
					Eliminar_Producto();					
				});
				
            },
            ready: function () {
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'idProducto');
            },
			columns: [
				{ text: 'ID', datafield: 'idProducto', width: '0', editable: false },
				{ text: 'Codigo', datafield: 'codigo', width: '10%', editable: false },				
				{ text: 'Descripcion', datafield: 'descripcion', width: '50%', editable: false },
				{ text: 'Cantidad', datafield: 'cantidad', width: '10%', cellsalign: 'center', columntype: 'integer', cellsformat: 'n' },
				{ text: 'Peso', datafield: 'peso', width: '10%', cellsalign: 'right', cellsformat: 'n' },
				{ text: 'Unidad Medida', datafield: 'unidadMedida', width: '10%', editable: false },
				{ text: 'Costo', datafield: 'costoUnitario', width: '10%', cellsalign: 'right', cellsformat: 'd2' }
			]
        
		});
		
		//$("#jqxGridDetalle .jqx-widget-content").css("font-size","12px");
		
        // display selected row index.
        $("#jqxGridDetalle").on('rowselect', function (event) {
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
		
		/*
        $("#jqxGridDetalle").on('cellvaluechanged', function (event) {
            var column = event.args.datafield;
			var rowindex = event.args.rowindex;
			var value = event.args.newvalue;
			var oldvalue = event.args.oldvalue;
			
			var dataRecord = $("#jqxGridDetalle").jqxGrid('getrowdata', rowindex);
            //var itemU = dataRecord.item;
			//alert("dataRecord:"+dataRecord);
			
            if(column == "cantidad" || column == "costoUnitario"){
				//alert(dataRecord.idProducto);
				//if($.trim(dataRecord.descripcion)!=""){
					if($.trim(value)!=""){					
						if(!isNaN(value)){
							if(parseInt(value) >= 0){
								var cantidad = 0;																																															
								var costoUnitario = 0.00;
								if(column=="cantidad"){
									var cantidad = parseInt(value);
									var costoUnitario = 0.00 + parseFloat(dataRecord.costoUnitario);
								}else{
									if(column=="costoUnitario"){
										var cantidad = 0 + parseInt(dataRecord.cantidad);
										var costoUnitario = parseFloat(value);
									}
								}							
								
								//var cantidad = parseInt(value);
								//var costoUnitario = parseFloat(dataRecord.costoUnitario);
								var importe = parseFloat((cantidad*costoUnitario));
								if(!isNaN(importe)){
									dataRecord.importe = importe;
								}else{
									dataRecord.importe = "0.00";
								}
							}else{
								dataRecord.cantidad = "0";
								dataRecord.importe = "0.00";
								Mostrar_Mensaje_Notificacion("warning","La cantidad debe ser entero mayor a cero");
							}
					
						}else{
							dataRecord.cantidad = "0";
							dataRecord.importe = "0.00";
							Mostrar_Mensaje_Notificacion("warning","La cantidad no es numerica");
						}
					}
				
				//}else{
				//	dataRecord.cantidad = "";
				//	dataRecord.importe = "";
				//$.prompt("No hay producto");
				//}
				
				var rowID = $('#jqxGridDetalle').jqxGrid('getrowid', rowindex);
				$('#jqxGridDetalle').jqxGrid('updaterow', rowID, dataRecord);
				//Sumar_Totales();
            }
        
        });
        //TestLista();
		*/
	});


	//Popup Buscar Producto
	$("#popupBuscarProductoDiv").jqxWindow({
		width: "950", height:"570", resizable: false,  isModal: true, autoOpen: false, okButton: $('#btnAceptar'), maxWidth:"1200", maxHeight:"900",
		cancelButton: $("#btnCancelar"), modalOpacity: 0.25, position: 'center', showCollapseButton: true
	});
    
	$("#popupBuscarProductoDiv").on('open', function () {
		Limpiar_Popups();
		var tipoProducto = "PRODUCTO";
		
		$("#formBuscarProductoDiv").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#formBuscarProductoDiv").load("ventas/buscar_producto/filtroProducto.php?p="+Math.random(), { tipoProducto: tipoProducto } );
        
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
									idProducto	: $.trim(dataListaProducto.idProducto),
									codigo 		: $.trim(dataListaProducto.codigo),
									descripcion : $.trim(dataListaProducto.descripcion),
									cantidad 	: "0",
									peso 		: "0",
									unidadMedida: $.trim(dataListaProducto.unidadMedida),
									costoUnitario 		: $.trim(dataListaProducto.costoUnitario)
								};
			
				var commit = $("#jqxGridDetalle").jqxGrid('addrow', null, datarow);
			}
			
			Cerrar_Popup_Buscar_Producto();
			
		}else{
			Mostrar_Mensaje_Notificacion("warning","No ha seleccionado una fila");
		}
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
				var descripcion = Obtener_Columna_ObjGrid_Fila_Sel("jqxGridDetalle", "descripcion");
				
				if(!confirm(" Esta seguro de eliminar " + descripcion + " de la lista ?")){
					return false;
				}else{
					var commit = $("#jqxGridDetalle").jqxGrid('deleterow', id);
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
	
		
   	/*
	function TestLista(){
	
		var idCabeceraGR = $("#idCabeceraGR").val();
		alert(idCabeceraGR);
		$('#debug').html(idCabeceraGR);
        console.log(idCabeceraGR);
		
		$.ajax({
			type: "POST",
			data: { idCabeceraGR: idCabeceraGR },
			url: "ventas/guia_remision/dataDetalleGuiaRemision.php?p="+Math.random(),
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