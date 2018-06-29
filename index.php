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
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxcalendar.js"></script>        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxdata.export.js"></script>
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxgrid.export.js"></script>    
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/jqxtooltip.js"></script> 
        
    <script type="text/javascript" src="theme/jquery/jqwidgets/jqwidgets/globalization/globalize.js"></script>

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
        $("#containerMain").load(pagina+".php?p="+Math.random(), {parametros: parametros} );
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

</body>

</html>