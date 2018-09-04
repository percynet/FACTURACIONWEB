<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
	
    if(isset($_POST['filtro']) && isset($_POST['valor']) && isset($_POST['tipoProducto'])){
        
		$tipoProducto = $_POST['tipoProducto'];
		
		$filtro = $_POST['filtro'];
        $valor = $_POST['valor'];
    
?>

		<div id="jqxGridListaProducto"></div>
        
        <input type="hidden" id="filtro" value="<?=$filtro;?>" />
        <input type="hidden" id="valor" value="<?=$valor;?>" />
        <input type="hidden" id="accion" />


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
        
		$("#jqxGridListaProducto").jqxGrid('clear');
	
		var tipoProducto = $("#tipoProducto").val();
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		 
		var source = 
		{
			datatype: "json",
			datafields: [
				{ name: 'idProducto'},
				{ name: 'tipoProducto', type: 'string'},
				{ name: 'codigo', type: 'string'},
				{ name: 'descripcion', type: 'string'},
				{ name: 'moneda', type: 'string'},
				{ name: 'costoUnitario', type: 'string'},
				{ name: 'precioUnitario', type: 'string'},
				{ name: 'unidadMedida', type: 'string'},	
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { tipoProducto: tipoProducto, filtro: filtro, valor: valor},
			url: "ventas/buscar_producto/dataListaProducto.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaProducto").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idProducto',
            width: '100%%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            //showtoolbar: true,
            selectionmode: 'singlerow',
            //editable: true,
            editmode: 'selected cell click',
            ready: function () {
                $("#jqxGridListaProducto").jqxGrid('hidecolumn', 'idProducto');
				$("#jqxGridListaProducto").jqxGrid('hidecolumn', 'tipoProducto');
				
				if(tipoProducto == "PRODUCTO"){
					$("#jqxGridListaProducto").jqxGrid('hidecolumn', 'precioUnitario');
				}else{
					if(tipoProducto == "SERVICIO"){
						$("#jqxGridListaProducto").jqxGrid('hidecolumn', 'costoUnitario');
					}
				}
            },
			columns: [
				{ text: 'ID', datafield: 'idProducto', width: '0%'},
				{ text: 'Tipo Producto', datafield: 'tipoProducto', width: '0%'},
				{ text: 'Codigo', datafield: 'codigo', width: '10%'},
				{ text: 'Descripcion', datafield: 'descripcion', width: '50%'},
				{ text: 'Moneda', datafield: 'moneda', width: '10%'},
				{ text: 'Costo', datafield: 'costoUnitario', width: '10%'},
				{ text: 'Precio', datafield: 'precioUnitario', width: '10%'},
				{ text: 'Unidad Medida', datafield: 'unidadMedida', width: '10%'},
				{ text: 'Estado', datafield: 'estado', width: '10%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaProducto").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaProducto").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaProducto").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});
 
 	/*
	function TestLista(){
	   
		var tipoProducto = $("#tipoProducto").val();
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		
		//var idDocumentoIdentidad = $("#idDocumentoIdentidadFiltro").val();
        //alert(filtro);
        //alert(valor);
		//alert(idDocumentoIdentidad);
		alert(tipoProducto);
		$.ajax({
			type: "POST",            
			url: "ventas/buscar_producto/dataListaProducto.php?p="+Math.random(),
			data: { tipoProducto: tipoProducto, filtro: filtro, valor: valor},
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