<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

	//$idAlmacen = $_SESSION['ALMACEN']['idAlmacen'];
    
?>

        <div id="jqxGridDetalle"></div>
                    
        <div id="summaryDiv" style='margin-top: 10px; float: right;' >
            <table align="right" border="0" width="100%">
                <tr>
                    <td width="100" align="right"><div id="labelSubTotalDiv">Sub-Total:</div></td>
                    <td width="10%">
                    	<div id="subTotalDiv">
                        	<div style='margin-top: 3px;' id='totalImporte'></div>
                        </div>
                    </td>
                    <td width="100">&nbsp;</td>                                
                    <td width="100" align="right"><div id="labelTotalIGVDiv">IGV:</div></td>
                    <td width="10%">
                        <div id="totalIGVDiv">
                        	<div style='margin-top: 3px;' id='totalIGV'></div>
                        </div>
                    </td>
                    <td width="100">&nbsp;</td>                    
                    <td width="100" align="right"><div id="labelImpuestoDiv">Impuesto:</div></td>
                    <td width="10%">
                        <div id="totalImpuestoDiv">
                        	<div style='margin-top: 3px;' id='totalImpuesto'></div>
                        </div>
                    </td>                                
                    <td width="100">&nbsp;</td>
                    <td width="100" align="right">Total:</td>
                    <td width="10%">
                        <div style='margin-top: 3px;' id='totalVenta'></div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
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
        
		$("#jqxGridDetalle").jqxGrid('clear');
		
		$("#totalImporte").jqxNumberInput({ width: '120px', height: '20px', inputMode: 'simple', digits: 8, decimal: 2 , readOnly: true });
		$("#totalIGV").jqxNumberInput({ width: '90px', height: '20px', inputMode: 'simple', digits: 8, decimal: 2 , readOnly: true});
		$("#totalImpuesto").jqxNumberInput({ width: '90px', height: '20px', inputMode: 'simple', digits: 8, decimal: 2 , readOnly: true });
		$("#totalVenta").jqxNumberInput({ width: '120px', height: '20px', inputMode: 'simple', digits: 8, decimal: 2 , readOnly: true });
		
		$("#totalImporte").val("0.00");
		$("#totalIGV").val("0.00");
		$("#totalImpuesto").val("0.00");
		$("#totalVenta").val("0.00");
								
		var data = {};
        //var theme = 'classic';
        var idProductoe = new Array();
        var descripcione = new Array();
		var cantidade = new Array();
		var precioe = new Array();
		var importee = new Array();
        
        var generaterow = function (i) {
			var row = {};
			var firtnameindex = idProductoe.length-1;
			row["idProducto"] = idProductoe[firtnameindex];
			//row["item"] = i + 1 ;   //iteme[firtnameindex];
			//row["codigo"] = codigoe[firtnameindex];
			row["cantidad"] = cantidade[firtnameindex];
			row["descripcion"] = descripcione[firtnameindex];
			row["precio"] = precioe[firtnameindex];
			row["importe"] = importee[firtnameindex];

			return row;
		}
           
		for (var i = 0; i < 10; i++) {
			var row = generaterow(i);
			data[i] = row;
		}
		 
		var source = 
		{
			localdata: data,
            datatype: "local",
			//datatype: "json",            
			datafields: [
				{ name: 'idProducto', type: 'string'},
				{ name: 'cantidad', type: 'number'},				
				{ name: 'descripcion', type: 'string'},
				{ name: 'precio', type: 'number'},
				{ name: 'importe', type: 'number'}
			],
            sortname: 'descripcion',
            //data: { filtro:filtro, valor:valor },
			//url: 'ventas/notaPedido/dataProductos.php',
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

                container.append('<button id="btnNuevo" type="button" class="btn btn-warning" ><i class="fa fa-ok"></i>&nbsp;Nuevo</button>&nbsp;');
				container.append('<button id="btnGrabar" type="button" class="btn btn-info" ><i class="fa fa-ok"></i>&nbsp;Grabar</button>&nbsp;');
				container.append('<button id="btnRegresar" type="button" class="btn btn-danger" ><i class="fa fa-ok"></i>&nbsp;Regresar</button>&nbsp;');
				container.append('<button id="btnImprimirCV" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Imprimir B/F</button>&nbsp;');
				
				container.append('<button id="btnImprimirGR" type="button" class="btn btn-success" ><i class="fa fa-ok"></i>&nbsp;Imprimir G/R</button>&nbsp;');
								
				
				$("#btnNuevo").click(function () {
					if (confirm(" Esta seguro de limpiar los datos del comprobante para crear uno nuevo ?")) {
						
						Limpiar_Cabecera_Comprobante_Venta();
						Limpiar_Totales();
						
						$("#jqxGridDetalle").jqxGrid('clear');
						for (var i = 0; i < 10; i++) {
							var datarow = generaterow(i);
							$("#jqxGridDetalle").jqxGrid('addrow', null, datarow);					
						}
						
						$("#btnGrabar").show();
					}
				});
				
				$("#btnGrabar").click(function () {
					Grabar_Comprobante_Venta();					
				});
				
				$("#btnRegresar").click(function () {
					Ir_A_Pagina('ventas/factura_boleta/filtroFacturaBoleta');
				});
				
				$("#btnImprimirCV").click(function () {
					Imprimir_FacturaBoleta();
				});
				
				$("#btnImprimirGR").click(function () {
					Imprimir_GuiaRemision();
				});
				
            },
            ready: function () {                
				$("#jqxGridDetalle").jqxGrid('hidecolumn', 'idProducto');
            },
			columns: [
				{ text: 'ID', datafield: 'idProducto', width: '0%', editable: false },
				{ text: 'Cantidad', datafield: 'cantidad', width: '10%', cellsalign: 'center', columntype: 'integer', cellsformat: 'n' },
				{ text: 'Descripcion', datafield: 'descripcion', width: '60%' },
				{ text: 'Precio', datafield: 'precio', width: '15%', cellsalign: 'right', cellsformat: 'd2' },
				{ text: 'Importe', datafield: 'importe', width: '15%', editable: false, cellsalign: 'right', cellsformat: 'd2' }
			]
                
		});
	
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
		

        $("#jqxGridDetalle").on('cellvaluechanged', function (event) {
            var column = event.args.datafield;
			var rowindex = event.args.rowindex;
			var value = event.args.newvalue;
			var oldvalue = event.args.oldvalue;
			
			var dataRecord = $("#jqxGridDetalle").jqxGrid('getrowdata', rowindex);
            //var itemU = dataRecord.item;
			//alert("dataRecord:"+dataRecord);

			
            if(column=="cantidad" || column =="precio"){
				//alert(dataRecord.idProducto);
				//if($.trim(dataRecord.descripcion)!=""){
					if($.trim(value)!=""){					
						if(!isNaN(value)){
							if(parseInt(value) >= 0){
								var cantidad = 0;
								var precio = 0.00;
								if(column=="cantidad"){
									var cantidad = parseInt(value);
									var precio = 0.00 + parseFloat(dataRecord.precio);
								}else{
									if(column=="precio"){
										var cantidad = 0 + parseInt(dataRecord.cantidad);
										var precio = parseFloat(value);
									}
								}							
								
								//var cantidad = parseInt(value);
								//var precio = parseFloat(dataRecord.precio);
								var importe = parseFloat((cantidad*precio));
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
				/*	
				}else{
					dataRecord.cantidad = "";
					dataRecord.importe = "";
					//$.prompt("No hay producto");
				}
				*/
				var rowID = $('#jqxGridDetalle').jqxGrid('getrowid', rowindex);
				$('#jqxGridDetalle').jqxGrid('updaterow', rowID, dataRecord);
				Sumar_Totales();
            }
									
                        
        });		
        //TestLista();
        
		$("#labelImpuestoDiv").hide();
		$("#totalImpuestoDiv").hide();
		
		var comprobante = $.trim($("#comprobanteCab").val());
		
		if(comprobante == "BOLETA"){
		
			$("#labelSubTotalDiv").hide();		
			$("#labelTotalIGVDiv").hide();
			//$("#labelImpuestoDiv").hide();
			$("#subTotalDiv").hide();
			$("#totalIGVDiv").hide();
			//$("#totalImpuestoDiv").hide();
			$("#btnImprimirCV").html("Imprimir Boleta");
			$("#btnImprimirGR").hide();
		}else{
			if(comprobante == "FACTURA"){
				$("#labelSubTotalDiv").show();
				$("#labelTotalIGVDiv").show();
				//$("#labelImpuestoDiv").show();
				$("#subTotalDiv").show();
				$("#totalFacturaDiv").show();
				//$("#totalImpuestoDiv").show();
				$("#btnImprimirCV").html("Imprimir Factura");
				$("#btnImprimirGR").show();
			}				
		}
		
		//$("#btnImprimirCV").hide();
		//$("#btnImprimirGR").hide();
		
	});

	function Limpiar_Totales(){
		$("#totalImporte").val("0.00");
		$("#totalIGV").val("0.00");
		$("#totalImpuesto").val("0.00");
		$("#totalVenta").val("0.00");
	}
	
	function Sumar_Totales(){
		
		var totalImporte = 0;
		var porcIgv = 0;			//parseFloat($("#porcIgv").val());
		var porcImpuesto = 0;		//parseFloat($("#porcImpuesto").val());

		var totalIGV = 0;
		var totalImpuesto = 0;
		var totalVenta = 0;
		
		var comprobante = $.trim($("#comprobanteCab").val());
		if(comprobante == "FACTURA"){
			porcIgv = 0.18;				//solo para facturas
			porcImpuesto = 0;			//solo para facturas
		}
		
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;
		//alert("counts:"+rowscount);
		for(i=0; i<rowscount; i++){
			var rowId = $('#jqxGridDetalle').jqxGrid('getrowid', i);
			var rowDetalle = $('#jqxGridDetalle').jqxGrid('getrowdatabyid', rowId);
			if(!isNaN(rowDetalle.importe)){
				totalVenta = parseFloat(totalVenta) + parseFloat(rowDetalle.importe);
			}
		}
		
		totalImpuesto = totalVenta*porcImpuesto;
		//totalImporte = totalVenta/(1+(porcIgv/100));
		//totalIGV = totalVenta - totalImporte;
		
		totalIGV = (totalVenta)*(porcIgv);
		totalImporte = totalVenta - totalIGV;
			
		$("#totalImporte").val(totalImporte);
		$("#totalIGV").val(totalIGV);
		$("#totalImpuesto").val(totalImpuesto);
		$("#totalVenta").val(totalVenta);

	}
	
	
   	function Imprimir_FacturaBoleta(){
		var accion = "2";
		var idFacturaBoleta = $.trim($("#idFacturaBoletaCab").val());
		var comprobante = $.trim($("#comprobanteCab").val());
		
		//idFacturaBoleta = "18";		
		//alert(idFacturaBoleta);
		//alert(comprobante);
		if(idFacturaBoleta != "" && idFacturaBoleta != "0"){
		
			var cabecera = {
				idFacturaBoleta : idFacturaBoleta,
				comprobante : comprobante
			}
			
			$.ajax({
				type: "POST",            
				url: "ventas/factura_boleta/saveCabeceraFacturaBoleta.php?p="+Math.random(),
				data: { accion: accion, cabecera: cabecera },
				success: function(resultGen){
					//alert(resultGen);
					/*
					resultado = resultCab;				/*		
					$('#debug').html(resultCab);
					console.log(resultCab);
					*/
					if(resultGen != ""){
						//alert("Se genero la serie-numero satisfactoriamente del comprobante de venta");
						
						if(comprobante == "BOLETA"){
							ImprimirBoleta(idFacturaBoleta);
						}else{
							if(comprobante == "FACTURA"){			
								ImprimirFactura(idFacturaBoleta);
							}				
						}
						
						//$("#btnImprimirCV").hide();
						
					}else{
						alert("No se generar la serie-numero del comprobante de venta");
					}
					
				},
				error: function(){
					alert("Se ha producido un error");
				}
			});
		}else{
			alert("Aun no se ha generado el comprobante de venta para imprimir");
		}
	}
	
	
	function Imprimir_GuiaRemision(){
		var accion = "2";
		var idGuiaRemision = $.trim($("#idGuiaRemisionCab").val());
		var comprobante = "GUIA REMISION";
		
		//idGuiaRemision = "8";
		//alert(idGuiaRemision);
		//alert(comprobante);
		if(idGuiaRemision != "" && idGuiaRemision != "0"){
		
			var cabecera = {
				idFacturaBoleta : idGuiaRemision,
				comprobante : comprobante
			}
			
			$.ajax({
				type: "POST",            
				url: "ventas/factura_boleta/saveCabeceraFacturaBoleta.php?p="+Math.random(),
				data: { accion: accion, cabecera: cabecera },
				success: function(resultGen){
					//alert(resultGen);
					/*
					resultado = resultCab;				/*		
					$('#debug').html(resultCab);
					console.log(resultCab);
					*/
					if(resultGen != ""){
						//alert("Se genero la serie-numero satisfactoriamente del comprobante de venta");
						ImprimirGR(idGuiaRemision);
						
						//$("#btnImprimirGR").hide();
						
					}else{
						alert("No se generar la serie-numero de la guia de remision");
					}
					
				},
				error: function(){
					alert("Se ha producido un error");
				}
			});
		}else{
			alert("Aun no se ha generado la guia de remision para imprimir");
		}
			
	}
	
	function ImprimirBoleta(idFacturaBoleta){
		var newWindow = window.open("ventas/factura_boleta/impresionBoleta.php?idFacturaBoleta="+idFacturaBoleta,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		newWindow.print();
	}
	
	function ImprimirFactura(idFacturaBoleta){		
		var newWindow = window.open("ventas/factura_boleta/impresionFactura.php?idFacturaBoleta="+idFacturaBoleta,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		newWindow.print();
	}	
		
	function ImprimirGR(idGuiaRemision){
		var idGuiaRemision = $.trim($("#idGuiaRemisionCab").val());
		var newWindow = window.open("ventas/factura_boleta/impresionGuiaRemision.php?idGuiaRemision="+idGuiaRemision,
									"sub","HEIGHT=200,WIDTH=200,SCROLLBARS");
		newWindow.print();
	}
	
	function Validar_Datos(){
		
		var idCliente = $.trim($("#idClienteCab").val());
		//alert(idCliente);
		if(idCliente == ""){
			alert("Debe seleccionar un cliente");
			return false;
		}
		
		var cliente = $.trim($("#clienteCab").val());
		//alert(cliente);
		if(cliente == ""){
			alert("Debe seleccionar un cliente");
			return false;
		}
				
		var idMoneda = $.trim($("#cboMonedaCab").val());
		//alert(idMoneda);
		if(idMoneda == "0"){
			alert("Debe seleccionar la moneda");
			return false;
		}
		var fechaEmision = $.trim($("#fechaEmisionCab").val());
		//alert(fechaEmision);
		if(fechaEmision == ""){
			alert("Debe seleccionar la fecha de emision");
			return false;
		}

		var generarGR = $.trim($("#generarGRCab").val());
		//alert(generarGR);
		if(generarGR == "1"){
			var idAgencia = $.trim($("#idAgenciaCab").val());
			//alert(idAgencia);
			if(idAgencia == ""){
				alert("Debe seleccionar una agencia");
				return false;
			}
			
			var agencia = $.trim($("#agenciaCab").val());
			//alert(agencia);
			if(agencia == ""){
				alert("Debe seleccionar una agencia");
				return false;
			}

			var marcaNroPlaca = $.trim($("#marcaNroPlacaCab").val());
			//alert(marcaNroPlaca);
			if(marcaNroPlaca == ""){
				alert("Debe ingresar una marca y nro de placa");
				return false;
			}
			
			var nroConstanciaInscripcion = $.trim($("#nroConstanciaInscripcionCab").val());
			//alert(nroConstanciaInscripcion);
			if(nroConstanciaInscripcion == ""){
				alert("Debe ingresar un nro constacia de inscripcion");
				return false;
			}
			
			var nroLicenciasConducir = $.trim($("#nroLicenciasConducirCab").val());
			//alert(nroLicenciaConducir);
			if(nroLicenciasConducir == ""){
				alert("Debe ingresar un nro licencia de conducir");
				return false;
			}			
		}
		
		var cantidadProductos = Cantidad_Productos_En_Detalle();
		//alert("cantidadProductos:"+cantidadProductos);
		if(cantidadProductos==0){
			alert('Debe agregar productos al detalle');
			return false;
		}
		
		return true;
	}
	
	function Cantidad_Productos_En_Detalle(){
	
		var rowscount = $("#jqxGridDetalle").jqxGrid('getdatainformation').rowscount;
		var total = 0;
		//alert("counts:"+rowscount);
		for(i=0; i<rowscount; i++){
			var rowId = $('#jqxGridDetalle').jqxGrid('getrowid', i);
			var rowData = $('#jqxGridDetalle').jqxGrid('getrowdatabyid', rowId);
			//if(!isNaN(rowData.idProducto)){
			if($.trim(rowData.descripcion) != ""){
				total++;
			}
		}
		return total;
	}	
	
	function Grabar_Comprobante_Venta(){

		if(Validar_Datos()){
		
			if (confirm(" Esta seguro de grabar el comprobante ?")) {

				var cabecera = {
					idComprobante : $.trim($("#idComprobanteCab").val()),
					comprobante : $.trim($("#comprobanteCab").val()),
					fechaEmision : $.trim($("#fechaEmisionCab").val()),
					idAlmacen : $.trim($("#idAlmacenCab").val()),
					idCliente : $.trim($("#idClienteCab").val()),
					cliente : $.trim($("#clienteCab").val()),
					idDocumentoIdentidadCliente : $.trim($("#idDocumentoIdentidadCab").val()),
					nroDocumentoIdentidadCliente : $.trim($("#nroDocumentoIdentidadClienteCab").val()),
					direccionCliente : $.trim($("#direccionClienteCab").val()),
					idMoneda : $.trim($("#cboMonedaCab").val()),
					moneda :  $("#cboMonedaCab option:selected").text(),
					generarGR : $.trim($("#generarGRCab").val()),					
					totalImporte : $.trim($("#totalImporte").val()),
					totalIGV : $.trim($("#totalIGV").val()),
					totalImpuesto : $.trim($("#totalImpuesto").val()),
					totalVenta : $.trim($("#totalVenta").val()),
					idAgencia : $.trim($("#idAgenciaCab").val()),
					agencia : $.trim($("#agenciaCab").val()),
					rucAgencia : $.trim($("#rucAgenciaCab").val()),
					direccionAgencia : $.trim($("#direccionAgenciaCab").val()),
					idMotivoTraslado : $.trim($("#cboMotivoTrasladoCab").val()),
					motivoTraslado :  $("#cboMotivoTrasladoCab option:selected").text(),
					marcaPlaca : $.trim($("#marcaNroPlacaCab").val()),
					nroConstanciaInscripcion : $.trim($("#nroConstanciaInscripcionCab").val()),
					nroLicenciasConducir : $.trim($("#nroLicenciasConducirCab").val())
				}
				
				Grabar_Cabecera_Comprobante_Venta(cabecera);

			}		
		}
	
	}
	
	function Grabar_Cabecera_Comprobante_Venta(cabecera){
	
		var accion = "0";

		$.ajax({
			type: "POST",            
			url: "ventas/factura_boleta/saveCabeceraFacturaBoleta.php?p="+Math.random(),
			data: { accion: accion, cabecera: cabecera },
			success: function(resultCab){
				//alert(resultCab);
				/*
				resultado = resultCab;				/*		
				$('#debug').html(resultCab);
        		console.log(resultCab);
				*/
				if(resultCab != "" && resultCab != "0"){
					//alert("Comprobante de venta fue creado satisfactoriamente");
					var idFacturaBoleta = resultCab;
					cabecera.idFacturaBoleta = idFacturaBoleta;
					Grabar_Detalle_Comprobante_Venta(cabecera);
				
				}else{
					alert("No se genero el comprobante de venta");
				}
				
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});

	}
	
	function Grabar_Detalle_Comprobante_Venta(cabecera){
	
		var idFacturaBoleta = cabecera.idFacturaBoleta;
		var dataDetalle = $("#jqxGridDetalle").jqxGrid('exportdata', 'json');
		//$('#debug').html(dataDetalle);
		//console.log(dataDetalle);
		$.ajax({
			type: "POST",
			url : "ventas/factura_boleta/saveDetalleFacturaBoleta.php?p="+Math.random(),
			data : {idFacturaBoleta: idFacturaBoleta, dataDetalle: dataDetalle},
			success: function(resultDet){
				//alert(resultDet);							
				if(resultDet == 1){
					//alert("Se genero satisfactoriamente el detalle del comprobante de venta");
					alert(cabecera.comprobante.toLowerCase() + " creada satisfactoriamente");
					$("#idFacturaBoletaCab").val(idFacturaBoleta);
					//$("#btnImprimirCV").show();
					
					if(cabecera.generarGR == "1"){
						Generar_Guia_Remision(idFacturaBoleta, cabecera);
					}
					
					$("#btnGrabar").hide();
				}else{
					alert("Ocurrio un error al generar el detalle del comprobante de venta");
				}
				
			},
			error: function(){
				alert("Se ha producido un error. No puede continuar con el proceso.");
			}
		});

	}
	
	function Generar_Guia_Remision(idFacturaBoleta, cabecera){
						
		$.ajax({
			type: "POST",
			url : "ventas/factura_boleta/saveGuiaRemision.php?p="+Math.random(),
			//url: "ventas/guiaRemision/saveGuiaRemison.php?p="+Math.random(),
			data: { idFacturaBoleta: idFacturaBoleta, cabecera: cabecera },
			success: function(result){
				//alert(result);
				/*
				$('#debug').html(result);
        		console.log(result);
				*/
				if(result != "" && result != "0"){
					alert("guia de remision creada satisfactoriamente");
					var idGuiaRemision = result;
					$("#idGuiaRemisionCab").val(idGuiaRemision);					
					//$("#btnImprimirGR").show();
				}else{
					alert("No se genero el comprobante de venta");
				}
			
			},
			error: function(){
				alert("Se ha producido un error");
			}
		});
	}
		
	function Limpiar_Cabecera_Comprobante_Venta(){
		$("#idFacturaBoletaCab").val("");
		$("#idGuiaRemisionCab").val("");
		$("#idClienteCab").val("");
		$("#clienteCab").val("");
		$("#nroDocumentoIdentidadClienteCab").val("");
		$("#direccionClienteCab").val("");
		$("#idAgenciaCab").val("");
		$("#agenciaCab").val("");
		$("#rucAgenciaCab").val("");
		$("#direccionAgenciaCab").val("");
	}
	
		
    /*
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
	*/
		
	
</script>