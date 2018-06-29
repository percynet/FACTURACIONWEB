<?php
$error = "";
if (isset($_GET['msgError']) ){
	$error = $_GET['msgError'];
}
?>
<script language="JavaScript">
function IrAPagina(pagina){
	document.location.href=pagina + "?";
}
</script>

<html>
<head>
<title></title>
</head>
<body bgcolor="#E5E5E5" text="#000000">
	<table class="forumline" width="1000px" cellspacing="1" cellpadding="0" border="0" align="left">
		<tr>	
            <td>
                <table class="forumline" width="1100" cellspacing="1" cellpadding="0" border="0" align="center">
                <tr>
                    <td width="115" valign="top" class="celda1"><img src="theme/images/error.png" height="100" width="100"></td>
                    <td class="celda2" align="center" valign="middle">
                        <table border="0" cellpadding="3" cellspacing="1" width="100%" class="borderLinea">
                            <tr><td class="celda2" align="left" valign="middle"><span class="txtEncabecadoRojo"> <h4>Error encontrado </h4></span></td></tr>
                            <tr><td class="separador" height="25" valign="middle"><hr>&nbsp;</td></tr>
                            <tr><td class="celda2">Motivo: &nbsp;&nbsp;<?=$error?></span></td></tr>
                            <tr><td class="celda2"><br /></td></tr>
                            <tr><td class="celda2"><button class="btn btn-" type="button" onclick="IrAPagina('index.php');">Ir a Login</button></td></tr>
                        </table>
                    </td>
                </tr>
                </table>
            </td>
		</tr>
		<tr>
        	<td class="separador" height="28">&nbsp;</td>
        </tr>
	</table>
</body>
</html>