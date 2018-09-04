<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    if(isset($_POST['filtro']) && isset($_POST['valor'])){
        
		$filtro = $_POST['filtro'];
        $valor = $_POST['valor'];
    
?>

		<div id="jqxGridListaTransportista"></div>
        
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
        
		$("#jqxGridListaTransportista").jqxGrid('clear');
	
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		//var idDocumentoIdentidad = $("#idDocumentoIdentidadFiltro").val();
		 
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idTransportista'},
				{ name: 'codigo', type: 'string'},
				{ name: 'ruc', type: 'string'},
				{ name: 'razonSocial', type: 'string'},				
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro, valor: valor},
			url: "ventas/buscar_transportista/dataListaTransportista.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaTransportista").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idTransportista',
            width: '100%%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            //showtoolbar: true,
            selectionmode: 'singlerow',
            //editable: true,
            editmode: 'selected cell click',
			/*
            rendertoolbar: function (toolbar) {
                var me = this;
                var container = $("<div style='margin: 5px;'></div>");
                toolbar.append(container);
			},	
			*/
            ready: function () {
                $("#jqxGridListaTransportista").jqxGrid('hidecolumn', 'idTransportista');
            },
			columns: [
				{ text: 'ID', datafield: 'idTransportista', width: '0%'},
				{ text: 'Codigo', datafield: 'codigo', width: '10%'},
				{ text: 'R.U.C.', datafield: 'ruc', width: '30%'},
				{ text: 'Razon Social', datafield: 'razonSocial', width: '50%'},
				{ text: 'Estado', datafield: 'estado', width: '10%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaTransportista").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaTransportista").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaTransportista").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});
  	/*
	function TestLista(){
	   
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();
		var idDocumentoIdentidad = $("#idDocumentoIdentidadFiltro").val();
        alert(filtro);
        alert(valor);
		alert(idDocumentoIdentidad);
		$.ajax({
			type: "POST",            
			url: "ventas/buscar_transportista/dataListaTransportista.php?p="+Math.random(),
			data: { filtro: filtro, valor: valor, idDocumentoIdentidad: idDocumentoIdentidad },
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