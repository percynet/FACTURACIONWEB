<?php 
session_start();
include("../../seguridad.php");

// Funciones de acceso a BD
include_once('../../interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){

    //if(isset($_POST['idTransportista']) && isset($_POST['idMarca']) && isset($_POST['idModelo'])){
	//if(isset($_POST['filtro'])){
	//if (empty($_POST['filtro']) ){
			
		$filtroJSON = $_POST['filtro'];
		
    	//print_r($filtroJSON);
?>

		<div id="jqxGridListaVehiculo"></div>
        
        <input type="hidden" id="idTransportistaB" value="<?=$filtroJSON['idTransportista'];?>" />
        <input type="hidden" id="idMarcaB" value="<?=$filtroJSON['idMarca'];?>" />
        <input type="hidden" id="idModeloB" value="<?=$filtroJSON['idModelo'];?>" />
        
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
        
		$("#jqxGridListaVehiculo").jqxGrid('clear');
		
		var filtro = {            
            idTransportista: $.trim($("#idTransportistaB").val()),
			idMarca: $.trim($("#idMarcaB").val()),
			idModelo: $.trim($("#idModeloB").val())
        };
		
		//$('#debug').html(filtro);
        //console.log(filtro);
		
		var source = 
		{
			datatype: "json",         
			datafields: [
				{ name: 'idVehiculo'},
				{ name: 'idTransportista', type: 'string'},
				{ name: 'rucTransportista', type: 'string'},
				{ name: 'razonSocialTransportista', type: 'string'},
				{ name: 'idMarca', type: 'string'},
				{ name: 'marca', type: 'string'},
				{ name: 'idModeloMarca', type: 'string'},
				{ name: 'modelo', type: 'string'},
				{ name: 'codigo', type: 'string'},
				{ name: 'placaTracto', type: 'string'},
				{ name: 'placaRemolque', type: 'string'},
				{ name: 'configuracionVehicular', type: 'string'},
				{ name: 'certificadoInscripcion', type: 'string'},
				{ name: 'anioFabricacion', type: 'string'},
				{ name: 'estado', type: 'string'}
			],
            sortname: 'estado',
			type: "POST",
			data: { filtro: filtro },
			url: "ventas/buscar_vehiculo/dataListaVehiculo.php?p="+Math.random(),
			cache: false
		};
        
        var editrow = -1;
        var action = "";
        
        var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
       	});

		$("#jqxGridListaVehiculo").jqxGrid(
		{
            source: dataAdapter,   
            //ide: 'idVehiculo',
            width: '100%%',
			height: '350px',
            pageable: true,
            pagerButtonsCount: 10,
            //showtoolbar: true,
            selectionmode: 'singlerow',
            //editable: true,
            editmode: 'selected cell click',
            ready: function () {
                $("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'idVehiculo');
				$("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'idTransportista');
				$("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'rucTransportista');
				$("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'razonSocialTransportista');
				$("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'idMarca');
				$("#jqxGridListaVehiculo").jqxGrid('hidecolumn', 'idModeloMarca');
            },
			columns: [
				{ text: 'ID', datafield: 'idVehiculo', width: '0'},
				{ text: 'idTransportista', datafield: 'idTransportista', width: '0'},
				{ text: 'rucTransportista', datafield: 'rucTransportista', width: '0'},
				{ text: 'Razon Social', datafield: 'razonSocialTransportista', width: '0'},
				{ text: 'idMarca', datafield: 'idMarca', width: '0'},
				{ text: 'Marca', datafield: 'marca', width: '15%'},
				{ text: 'idModeloMarca', datafield: 'idModeloMarca', width: '0'},
				{ text: 'Modelo', datafield: 'modelo', width: '15%'},
				{ text: 'Codigo', datafield: 'codigo', width: '10%'},
				{ text: 'Placa Tracto', datafield: 'placaTracto', width: '10%'},
				{ text: 'Placa Remolque', datafield: 'placaRemolque', width: '10%'},
				{ text: 'Conf.Vehicular', datafield: 'configuracionVehicular', width: '10%'},
				{ text: 'Cert.Inscripcion', datafield: 'certificadoInscripcion', width: '15%'},
				{ text: 'Anio Fabr.', datafield: 'anioFabricacion', width: '8%'},
				{ text: 'Estado', datafield: 'estado', width: '7%'}
			]
		});
		
        // display selected row index.
        $("#jqxGridListaVehiculo").on('rowselect', function (event) {
            $("#selectrowindex").text(event.args.rowindex);
        });

        // display unselected row index.
        $("#jqxGridListaVehiculo").on('rowunselect', function (event) {
            $("#unselectrowindex").text(event.args.rowindex);
        });
        
        $("#jqxGridListaVehiculo").on("cellclick", function (event){
            var column = event.args.column;
            var rowindex = event.args.rowindex;
            var columnindex = event.args.columnindex;
        });
		
        //TestLista();
        
	});
	
	
    
  	
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
			url: "ventas/buscar_vehiculo/dataListaVehiculo.php?p="+Math.random(),
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
	
</script>