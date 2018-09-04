<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

	//$idAlmacen = $_SESSION['ALMACEN']['idAlmacen'];
    
    //if(isset($_POST['filtro'])){
        
		$filtro = $_POST['filtro'];
		//print_r($filtro);
?>

<div class="panel-body">
	<div class="dataTable_wrapper">
                
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
        
                    <div id="jqxGridListaGR"></div>
        
                </div>
            </div>
        </div>
        
        <div style="margin-top:5px; margin-right:15px;" align="right">
            <p>
                <button class="btn" id="btnAceptar" onclick="Seleccionar_BuscarGR();">
                        <i class="icon-ok"></i> Aceptar</button>&nbsp;
                                                
                <button class="btn" id="btnCancelar" onclick="Cerrar_Popup_Buscar_GR();">
                        <i class="icon-eye-close"></i> Cancelar</button>&nbsp;                
            </p>
        </div>
	</div>
</div>
		
        <input type="hidden" id="idClienteFiltro"  value="<?= $filtro['idCliente']; ?>" />
        <input type="hidden" id="clienteFiltro"  value="<?= $filtro['cliente']; ?>" />

<?php
	/*
    }else{
        
        $sMessage = MSG_FILTERS_NOT_FOUND;
        header("Location: error.php?msgError=".$sMessage);
    	exit();
    }
	*/
}else{
    $sMessage = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>

<script type="text/javascript">

	$(document).ready(function(){
       	
		$("#jqxGridListaGR").jqxGrid('clear');
		
		var filtro = {
            idCliente: $.trim($("#idClienteFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		//console.log(filtro);
		 
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'idCabeceraGR'},	
				//{ name: 'selectGR', type: 'bool' },			
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
			url: "ventas/buscar_guia_remision/dataListaBuscarGR.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaGR").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCabeceraGR',
            width: '100%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            //showtoolbar: true,
            //selectionmode: 'singlerow',
			selectionmode: 'checkbox',
            editable: true,
            editmode: 'selected cell click',
            ready: function () {
                $("#jqxGridListaGR").jqxGrid('hidecolumn', 'idCabeceraGR');
            },
			columns: [
				{ text: 'ID', datafield: 'idCabeceraGR', width: '0%'},
				//{ text: '', datafield: 'selectGR', columntype: 'checkbox', width: '2%' },
				{ text: 'Fecha Emision', datafield: 'fechaEmision', editable: false, width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Fecha Traslado', datafield: 'fechaTraslado', editable: false, width: '10%', cellsalign: 'center', cellsformat: 'dd/MM/yyyy' },
				{ text: 'Serie-Numero', datafield: 'serieNumero', editable: false, width: '20%'},
				{ text: 'Cliente Remitente', datafield: 'clienteRemitente', editable: false, width: '40%'},
				{ text: 'Doc.Ident.', datafield: 'documentoIdentidad', editable: false, width: '10%'},
				{ text: 'Nro Doc.Ident.', datafield: 'numeroDocumentoIdentidad', editable: false, width: '10%'}
				//{ text: 'Estado', datafield: 'estado', width: '6%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaGR").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);	
			/*
			var idCabeceraGR = event.args.row.idCabeceraGR;
			alert("idCabeceraGR:"+idCabeceraGR);
			var length = dataAdapter.records.length;
			alert("length:"+length);
			*/
        });

        // display unselected row index.
        $("#jqxGridListaGR").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaGR").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
		$("#jqxGridListaGR").bind('cellendedit', function (event) {
			if (event.args.value) {
				$("#jqxGridListaGR").jqxGrid('selectrow', event.args.rowindex);
			}
			else {
				$("#jqxGridListaGR").jqxGrid('unselectrow', event.args.rowindex);
			}
		});
		
		$("#jqxGridListaGR").on('change', function (event) {
			//var checked = event.args.checked;
			//alert('checked: ' + checked);
		});

		
		
		// select or unselect rows when the checkbox is clicked.
		$("#jqxGridListaGR").bind('cellendedit', function (event) {
			if (event.args.value) {
				$("#jqxGridListaGR").jqxGrid('selectrow', event.args.rowindex);
			}
			else {
				$("#jqxGridListaGR").jqxGrid('unselectrow', event.args.rowindex);
			}
		});
		// get all selected records.
		
				
        //TestLista();

	});
	
	/*
	function Get_Selected_Rows(){
		var selectedrows = new Array();
		var rowindexes = $('#jqxGridListaGR').jqxGrid('getselectedrowindexes');
		//alert("rowindexes:"+rowindexes);
		
		if(rowindexes.length > 0){
			var boundrows = $('#jqxGridListaGR').jqxGrid('getboundrows');
			
			for(var i =0; i < rowindexes.length; i++){
				var row = boundrows[rowindexes[i]];
				//alert("row:"+JSON.stringify(row));
				selectedrows.push(row);
				//alert("value:"+$('#jqxGridListaVentaServicio').jqxGrid('getcellvalue', rowindexes[i], "idVentaServicio"))
				var idCabeceraGR = $('#jqxGridListaGR').jqxGrid('getcellvalue', rowindexes[i], "idCabeceraGR");
				//alert(idCabeceraGR);
			}
			//alert("Selected Rows: " + JSON.stringify(selectedrows));
			
		}
		return selectedrows;
	}
	*/

	/*
	function TestLista(){
	
		var filtro = {
            fechaDesde: $.trim($("#fechaDesde").val()),
			fechaHasta: $.trim($("#fechaHasta").val()),
			serieNumero: $.trim($("#serieNumeroFiltro").val()),
			cliente: $.trim($("#clienteFiltro").val())
        };
		
		//$('#debug').html(filtro);
        //console.log(filtro);
		console.log("*********************");
		$.ajax({
			type: "POST",            
			url: "ventas/buscar_guia_remision/dataListaBuscarGR.php?p="+Math.random(),
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