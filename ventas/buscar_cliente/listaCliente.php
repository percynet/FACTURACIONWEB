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

		<div id="jqxGridListaCliente"></div>
        
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
        
		$("#jqxGridListaCliente").jqxGrid('clear');
	
		var filtro = $("#filtro").val();
		var valor = $("#valor").val();		
		 
		var source = 
		{
			datatype: "json",            
			datafields: [
				{ name: 'idCliente'},
				{ name: 'codigo', type: 'string'},
				{ name: 'cliente', type: 'string'},
				{ name: 'telefonoCelular', type: 'string'},				
				{ name: 'documentoIdentidad', type: 'string'},
				{ name: 'numeroDocumentoIdentidad', type: 'string'},
				{ name: 'direccionActual', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'idDireccionActual', type: 'string'},
				{ name: 'idDireccionPartida', type: 'string'},
				{ name: 'idDireccionLlegada', type: 'string'}
				//{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro, valor: valor},
			url: "ventas/buscar_cliente/dataListaCliente.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaCliente").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idCliente',
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
                $("#jqxGridListaCliente").jqxGrid('hidecolumn', 'idCliente');
            },
			columns: [
				{ text: 'ID', datafield: 'idCliente', width: '0%'},
				{ text: 'Codigo', datafield: 'codigo', width: '7%'},
				{ text: 'Cliente', datafield: 'cliente', width: '25%'},
				{ text: 'Telf. Celular', datafield: 'telefonoCelular', width: '10%'},
				{ text: 'Documento', datafield: 'documentoIdentidad', width: '10%'},
				{ text: 'Nro. Doc.', datafield: 'numeroDocumentoIdentidad', width: '10%'},
				{ text: 'Dir. Actual', datafield: 'direccionActual', width: '20%'},
				{ text: 'Email', datafield: 'email', width: '18%'},
				{ text: 'idDireccionActual', datafield: 'idDireccionActual', width: '0%'},
				{ text: 'idDireccionPartida', datafield: 'idDireccionPartida', width: '0%'},
				{ text: 'idDireccionLlegada', datafield: 'idDireccionLlegada', width: '0%'}
				//{ text: 'Estado', datafield: 'estado', width: '10%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaCliente").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaCliente").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaCliente").on("cellclick", function (event){
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
			url: "ventas/buscar_cliente/dataListaCliente.php?p="+Math.random(),
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