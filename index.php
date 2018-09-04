<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Web</title>

    <link href="theme/css/style.css" rel="stylesheet" />
    
    <!-- Bootstrap Core CSS -->
    <link href="theme/bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="theme/bootstrap/dist/css/sb-admin-2.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="theme/bootstrap/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript 
    <script src="theme/bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    -->

    <!-- Custom Theme JavaScript 
    <script src="theme/bootstrap/dist/js/sb-admin-2.js"></script>-->
        
    <link rel="stylesheet" href="theme/jquery/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <!--<link rel="stylesheet" href="theme/jquery/jqwidgets/jqwidgets/styles/jqx.classic.css" type="text/css" />-->
    
    <script type="text/javascript" src="theme/jquery/jqwidgets/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/scripts/demos.js"></script>
        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxscrollbar.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdatatable.js"></script>    
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxknockout.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxcheckbox.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdropdownlist.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxmaskedinput.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxmaskedinput.js"></script>        
    <!--<script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxtextarea.js"></script>-->
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxcalendar.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdata.export.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.export.js"></script>    
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxtooltip.js"></script> 
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxnotification.js"></script>
        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/globalization/globalize.culture.es.js"></script>


	<script type="text/javascript">
        $(document).ready(function() {
			$("#menuMain").html("");			
			$("#containerMain").load("login.php?p="+Math.random());			
        });
 
 	function Ir_A_Pagina(pagina){
 	  
		$("#containerMain").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
        $("#containerMain").load(pagina+".php?p="+Math.random());
    }
	
 	function Ir_A_Pagina_Con_Parametros(pagina, parametros){
 	  	
		$("#containerMain").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
        $("#containerMain").load(pagina+".php?p="+Math.random(), { parametros : parametros});
    }	
	
	function Iniciar_Session(){	   
		var usuario = $("#usuario").val();
		var password = $("#password").val();

		if(usuario == ""){
			alert("Ingrese su usuario");
			$("#usuario").focus();
			return false;
		}
		
		if(password == ""){
			alert("Ingrese su password");
			$("#password").focus();
			return false;
		}
		
		$("#containerMain").html("<center><b>Actualizando informacion</b><br/>Por favor espere...<br/><img src='theme/images/loading.gif' /></center>");
		$("#containerMain").load("validarLogin.php?p="+Math.random(), {usuario: usuario, password: password});
		/*
		console.log("usuario:"+usuario);
		console.log("password:"+password);
        $.ajax({
			type: "POST",
			url : "validarLogin.php?p="+Math.random(),
			data : {usuario: usuario, password: password},
			success: function(result){
			    //alert(result); 
				console.log("result:"+result);
				
                if(result == 1){
					$("#menuMain").load("menuPrincipal.php?p="+Math.random());
					$("#containerMain").load("bienvenido.php?p="+Math.random());
					//$("#tituloWeb").html("<?//=$empresa['razonSocial']; ?>"+ " - SISTEMA WEB");							
				}else{
                    alert("Usuario y/o password no valido");
				}
				
			},
			error: function(){
				alert("Se ha producido un error. No puede continuar con el proceso.");
			}
		});	
		*/
	}
	
	function Evento_Enter(e){
		var keynum;
		var keychar;
		var numcheck;
		
		if(window.event){ // IE		
			keynum = e.keyCode;
		}else{
			if(e.which){ // Netscape/Firefox/Opera		
				keynum = e.which;
			}else{
				if(event.charCode){ // Chrome	
					keynum = e.charCode;
				}
			}
		}
		
		if(keynum == 13){
			return true;
		}
		
		return false;
	}	
    
	function Convertir_String_Fecha_Correcta(strFecha){
	   	correctFormat = strFecha.replace(/(\d+)\/(\d+)\/(\d+)/, "$3/$2/$1"),
		dateFecha = new Date(correctFormat);
	    return dateFecha;
	}
    
	function Imprimir_Lista_Resultados(jqxResult, titleResult){
		var rowscount = $("#"+jqxResult+"").jqxGrid('getdatainformation').rowscount;
		
		if(rowscount > 0){
		
			var gridContent = $("#"+jqxResult+"").jqxGrid('exportdata', 'html');
			var newWindow = window.open('', '', 'width=800, height=500'),
			document = newWindow.document.open(),
			pageContent =
				'<!DOCTYPE html>\n' +
				'<html>\n' +
				'<head>\n' +
				'<meta charset="utf-8" />\n' +
				'<title>'+titleResult+'</title>\n' +
				'</head>\n' +
				'<body>\n' + gridContent + '\n</body>\n</html>';
			document.write(pageContent);
			document.close();
			newWindow.print();
		
		}else{
			alert("No se encontraron datos para la impresion");
		}
	}    
	
	function soloLetras(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toString();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
		especiales = [8, 9, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.
	
		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
	
		if(letras.indexOf(tecla) == -1 && !tecla_especial){
			alert('Este campo solo permite letras');
			return false;
		}
	}


	function SoloNumeros(evt){
		if(window.event){//asignamos el valor de la tecla a keynum
	  		keynum = evt.keyCode; //IE
	 	}else{
	  		keynum = evt.which; //FF
	 	} 
	 	//comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
	 	if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 ){
	  		return true;
	 	}else{
	  		return false;
	 	}
 	}
	
	function Mostrar_Mensaje_Notificacion(newTemplate, newText){
		$("#textNotification").html(newText);
		$("#messageNotification").jqxNotification({position: "bottom-right", template: newTemplate });
		// template: "info", "warning", "success", "error", "mail", "time", "null"
		$("#messageNotification").jqxNotification("open");
	}
	

    function Obtener_Columna_ObjGrid_Fila_Sel(objGrid, columna){
        var idColumna = "0";
		var rowscount = $("#"+objGrid).jqxGrid('getdatainformation').rowscount;
		var selectedrowindex = $("#"+objGrid).jqxGrid('getselectedrowindex');
		if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			var id = $("#"+objGrid).jqxGrid('getrowid', selectedrowindex);
			var dataLista = $("#"+objGrid).jqxGrid('getrowdata', selectedrowindex);
            idColumna = dataLista[columna];
		}
        
        return idColumna;
    }
	
    function Obtener_Valor_Celda_ObjGrid(objGrid, nroFila, nombreColumna){
        var idColumna = "0";		
		var displayValue = $("#"+objGrid).jqxGrid('getcellvalue', nroFila, nombreColumna);
       
        return displayValue;
    }
	
	function Obtener_Data_Grid(objGrid){
		var totalFilas = $("#"+objGrid).jqxGrid('getdatainformation').rowscount;
		var dataGrid = [];
		
		for ( var nroFila = 0, total = totalFilas; nroFila < totalFilas; nroFila++ ) {
			var dataRow = $("#"+objGrid).jqxGrid('getrowdata', nroFila);
			//console.log(dataRow);
			dataGrid[nroFila] = dataRow;
		};
		return dataGrid;
	
	}
	
	function Get_Data_Grid(objGrid){
		var gridData = $("#"+objGrid).jqxGrid('getdatainformation');
		var rows = [];
		for (var i = 0; i < gridData.rowscount; i++)
			rows.push($('#jqxGrid').jqxGrid('getrenderedrowdata', i));
			console.log(JSON.parse(rows)
		);
		return rows;
	}
	
	function Existe_Fila_Duplicado_En_Grid(objGrid, nameColumn, valueColumn){
		var totalFilas = $("#"+objGrid).jqxGrid('getdatainformation').rowscount;

		for(i=0; i<totalFilas; i++){
			var rowId = $("#"+objGrid).jqxGrid('getrowid', i);
			var rowGrid = $("#"+objGrid).jqxGrid('getrowdatabyid', rowId);
			if( $.trim(valueColumn) == $.trim(rowGrid[nameColumn]) ){
				return true;
			}
		}
		return false;
	}
	
	function Obtener_Filas_Seleccionadas(objGrid){
		var selectedrows = new Array();
		var rowindexes = $("#"+objGrid).jqxGrid('getselectedrowindexes');
		//alert("rowindexes:"+rowindexes);
		
		if(rowindexes.length > 0){
			var boundrows = $("#"+objGrid).jqxGrid('getboundrows');
			
			for(var i =0; i < rowindexes.length; i++){
				var row = boundrows[rowindexes[i]];				
				selectedrows.push(row);
			}			
		}
		return selectedrows;
	}
	
	
	
	function createCenterPosWindow(){
        var html = '<div id="myCenterPosWindow">' +
                   '<div id="title">@Center</div>' +
                   '<div id="content"></div>' +
                   '</div>';
        $(document.body).append(html);

        //Works only on horizontal position
        $('#myCenterPosWindow').jqxWindow({width: '200px', height: '100px', autoOpen: false, resizable: false, position: 'center'});
        $('#myCenterPosWindow').jqxWindow('open');
	};
      
	function createRightPosWindow(){
        var html = '<div id="myRightPosWindow">' +
                   '<div id="title">@Right</div>' +
                   '<div id="content"></div>' +
                   '</div>';
        $(document.body).append(html);

        //Works
        $('#myRightPosWindow').jqxWindow({width: '200px', height: '100px', autoOpen: false, resizable: false, position: 'right'});
        $('#myRightPosWindow').jqxWindow('open');
	};
      
	function createBottomPosWindow(){
        var html = '<div id="myBottomPosWindow">' +
                   '<div id="title">@Bottom</div>' +
                   '<div id="content"></div>' +
                   '</div>';
        $(document.body).append(html);
        
        //Works
        $('#myBottomPosWindow').jqxWindow({width: '200px', height: '100px', autoOpen: false, resizable: false, position: 'bottom'});
        $('#myBottomPosWindow').jqxWindow('open');
	};
      
	function createRightBottomPosWindow(){
        var html = '<div id="myRightBottomPosWindow">' +
                   '<div id="title">@RightBottom</div>' +
                   '<div id="content"></div>' +
                   '</div>';
        $(document.body).append(html);
        /*
         * This position just doesn't work
         * I tried:
         *   position: 'right-bottom'
         *   position: 'right bottom'
         *   position: 'right/bottom'
         *   position: 'right_bottom'
         *   position: 'bottom-right'
         *   position: 'bottom right'
         *   position: 'bottom/right'
         *   position: 'bottom_right'
         *   position: ['bottom', 'right']
         *   position: ['right', 'bottom']
         *   position: {x: 'right', y: 'bottom'}
         */
        $('#myRightBottomPosWindow').jqxWindow({width: '200px', height: '100px', autoOpen: false, resizable: false, position: 'right-bottom'});
        $('#myRightBottomPosWindow').jqxWindow('open');
	};
      
	 
    </script>
</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header" style="margin-left:27%;" >
                <h3><span id="tituloWeb"></span></h3>
            </div>
        </nav>

        <div id="page-wrapper">
        
            <div class="row">
                <div id="menuMain">
                </div>
            </div>
        
            <!--<div class="row">-->
            
                <div id="containerMain" class="container_main">
                </div>
                
            <!--</div>-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div id="messageNotification">
        <div id="textNotification"></div>
    </div>
																																																																																																																																																																																																																																									
</body>

</html>