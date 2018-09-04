<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

    //if(isset($_POST['idTransportista']) && isset($_POST['chofer'])){
	//if(isset($_POST['filtro'])){
	//if (empty($_POST['filtro']) ){
			
		$filtroJSON = $_POST['filtro'];
		
    	//print_r($filtroJSON);
?>

		<div id="jqxGridListaChofer"></div>
        
        <input type="hidden" id="idTransportistaB" value="<?=$filtroJSON['idTransportista'];?>" />
        <input type="hidden" id="choferB" value="<?=$filtroJSON['chofer'];?>" />
        
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
        
		$("#jqxGridListaChofer").jqxGrid('clear');
		
		var filtro = {            
            idTransportista: $.trim($("#idTransportistaB").val()),
			chofer: $.trim($("#choferB").val())
        };
		
		//$('#debug').html(filtro);
        //console.log(filtro);
		
		var source = 
		{
			datatype: "json",         
			datafields: [
				{ name: 'idChofer'},
				{ name: 'idTransportista', type: 'string'},
				{ name: 'rucTransportista', type: 'string'},
				{ name: 'razonSocialTransportista', type: 'string'},
				{ name: 'codigo', type: 'string'},
				{ name: 'chofer', type: 'string'},
				{ name: 'licenciaConducir', type: 'string'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro },
			url: "ventas/buscar_chofer/dataListaChofer.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaChofer").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idChofer',
            width: '100%%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            //showtoolbar: true,
            selectionmode: 'singlerow',
            //editable: true,
            editmode: 'selected cell click',
            ready: function () {
                $("#jqxGridListaChofer").jqxGrid('hidecolumn', 'idChofer');
				$("#jqxGridListaChofer").jqxGrid('hidecolumn', 'idTransportista');
				$("#jqxGridListaChofer").jqxGrid('hidecolumn', 'rucTransportista');
				$("#jqxGridListaChofer").jqxGrid('hidecolumn', 'razonSocialTransportista');
            },
			columns: [
				{ text: 'ID', datafield: 'idChofer', width: '0'},
				{ text: 'idTransportista', datafield: 'idTransportista', width: '0'},
				{ text: 'rucTransportista', datafield: 'rucTransportista', width: '0'},
				{ text: 'Razon Social', datafield: 'razonSocialTransportista', width: '0'},
				{ text: 'Codigo', datafield: 'codigo', width: '20%'},
				{ text: 'Chofer', datafield: 'chofer', width:'50%'},
				{ text: 'Licencia Conducir', datafield: 'licenciaConducir', width: '20%'},
				{ text: 'Estado', datafield: 'estado', width: '10%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaChofer").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaChofer").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaChofer").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});
  	/*
	function TestLista(){
	   
		var filtro = {            
            idTransportista: $.trim($("#idTransportistaB").val()),
			idMarca: $.trim($("#idMarcaB").val()),
			idModelo: $.trim($("#idModeloB").val())
        };
		//$('#debug').html(filtro);
        //console.log(filtro);
		
		$.ajax({
			type: "POST",            
			url: "ventas/buscar_chofer/dataListaChofer.php?p="+Math.random(),
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