<?php
session_start();

// Funciones de acceso a BD
include_once('interfaceDB.php');

if(isset($_SESSION['paramdb']) && isset($_SESSION['USUARIO'])){
    
    $idEmpresa = $_SESSION['EMPRESA']['idEmpresa'];
	$idRol = $_SESSION['USUARIO']['idRol'];
    
    $objdb = new DBSql($_SESSION['paramdb']);
    $objdb -> db_connect();

    if ($objdb -> is_connection()){
	
		$rsAcceso = $objdb -> sqlGetAccesoRolModulo($idEmpresa, $idRol);
		
		if (intval(mysql_num_rows($rsAcceso))==1){
			$row = mysql_fetch_array($rsAcceso);

			$acceso['modMantenimientos'] = $row['modMantenimientos'];
			$acceso['modAlmacen'] = $row['modAlmacen'];
			$acceso['modCompras'] = $row['modCompras'];
			$acceso['modVentas'] = $row['modVentas'];
			$acceso['modCajas'] = $row['modCajas'];
			$acceso['modProcesos'] = $row['modProcesos'];
			$acceso['modReportes'] = $row['modReportes'];
			$acceso['modSeguridad'] = $row['modSeguridad'];
			
			$acceso['idEstado']  = $row["idEstado"];
		}
		//print_r($acceso);
?>
<div id='content'>
        <script type="text/javascript">
            $(document).ready(function () {
                // Create a jqxMenu
                
                $("#jqxMenu").css('visibility', 'visible');
                $("#jqxMenu").jqxMenu({ width: '100%', height: '30px', showTopLevelArrows: true });
            
                var centerItems = function () {
                    var firstItem = $($("#jqxMenu ul:first").children()[0]);
                    firstItem.css('margin-left', 0);
                    var width = 0;
                    var borderOffset = 2;
                    $.each($("#jqxMenu ul:first").children(), function () {
                        width += $(this).outerWidth(true) + borderOffset;
                    });
                    var menuWidth = $("#jqxMenu").outerWidth();
                    firstItem.css('margin-left', (menuWidth / 2 ) - (width / 2));
                }
                centerItems();
                $(window).resize(function () {
                    centerItems();
                });
				
            });
        </script>
        <div id='jqxWidget' style='height: 50px;'>
            <div id='jqxMenu' style='visibility: hidden; margin-left: 5px;'>
                <ul>
                    <li><a href="#" onclick="Ir_A_Pagina('bienvenido');">Inicio</a></li>
<?php
				if($acceso['modMantenimientos'] == "1"){
?>
					<li>Mantenimientos
                        <ul style='width: 250px;'>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/agencia/filtroAgencia');">Agencias</a></li>
                            <li type='separator'></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/transportista/filtroTransportista');">Transportistas</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/calidad/filtroCalidad');">Calidades</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/color/filtroColor');">Colores</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/marca/filtroMarca');">Marcas</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/modelo/filtroModelo');">Modelos</a></li>
                            <li type='separator'></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/cargo/filtroCargo');">Cargos</a></li>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('mantenimiento/empleado/filtroEmpleado');">Empleados</a></li>-->
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/empleado/filtroEmpleado');">Empleados</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/cliente/filtroCliente');">Clientes</a></li>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Clientes</a></li>-->
                            <li type='separator'></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/distrito/filtroDistrito');">Distritos</a></l>                                         
                            <li type='separator'></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/tipo_producto/filtroTipoProducto');">Tipo de Productos</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/producto/filtroProducto');">Productos</a></li>
                            <li type='separator'></li>
                             <li><a href="#" onclick="Ir_A_Pagina('mantenimiento/comprobante/filtroComprobante');">Correlativos</a></li>
                            <li type='separator'></li>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('mantenimiento/rol/filtroRol');">Roles</a></li>-->
                            <!--<li><a href="#" onclick="Ir_A_Pagina('mantenimiento/usuario/filtroUsuario');">Usuarios</a></li>-->
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Usuarios</a></li>
                        </ul>
                    </li>
<?php
				}
				if($acceso['modAlmacen'] == "1"){
?>
                    <li>Almacen
                        <ul style='width: 200px;'>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('facturacion/filtroFacturacion');">Facturas y Boletas</a></li>-->
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Ingresos y Salidas</a></li>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('buscarCliente/filtroCliente');">Buscar Clientes</a></li>-->
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Control de Stock</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Inventarios</a></li>
                        </ul>
                    </li>
<?php
				}
				if($acceso['modCompras'] == "1"){
?>
                    <li>Compras
                        <ul style='width: 200px;'>                            
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Facturas y Boletas</a></li>
                            <!--<li><a href="#" onclick="Ir_A_Pagina('buscarCliente/filtroCliente');">Buscar Clientes</a></li>-->
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Buscar Proveedores</a></li>
                        </ul>
                    </li>
<?php
				}
				if($acceso['modVentas'] == "1"){
?>
                    <li>Ventas
                        <ul style='width: 200px;'>
                            <li><a href="#" onclick="Ir_A_Pagina('ventas/factura_boleta/filtroFacturaBoleta');">Facturas y Boletas</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('ventas/guia_remision/filtroGuiaRemision');">Guias de Remisión</a></li>
                            <li type='separator'></li>
                            <li><a href="#" onclick="Ir_A_Pagina('ventas/nota/filtroNota');">Nota de Credito / Debito</a></li>
                        </ul>
                    </li>
<?php
				}
				if($acceso['modCajas'] == "1"){
?>
                    <li>Cajas
                        <ul style='width: 200px;'>
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Apertura de Caja</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Entradas / Salidas de Caja</a></li>
                            <li><a href="#" onclick="Ir_A_Pagina('enContruccion');">Saldos de Caja a la fecha</a></li>
                        </ul>
                    </li>
<?php
				}
				if($acceso['modReportes'] == "1"){
?>
                    <li>Reportes
                        <ul style='width: 200px;'>
                            <li><a href="#">Reporte 1</a></li>
                            <li>Compras
                                <ul style='width: 200px;'>
                                    <li><a href="#">Reporte 1</a></li>
                                    <li><a href="#">Reporte 2</a></li>
                                    <li><a href="#">Reporte 3</a></li>
                                    <li><a href="#">Reporte 4</a></li>
                                    <li><a href="#" onclick="Ir_A_Pagina('comunes/pruebas/prueba1');">Prueba 1</a></li>
                                    <li><a href="#" onclick="Ir_A_Pagina('comunes/pruebas/prueba2');">Prueba 2</a></li>
                                </ul>
                            </li>  
                            <li>Ventas
                                <ul style='width: 200px;'>
                                    <li><a href="#">Reporte 1</a></li>
                                    <li><a href="#">Reporte 2</a></li>
                                    <li><a href="#">Reporte 3</a></li>
                                    <li><a href="#">Reporte 4</a></li>
                                    <li><a href="#">Reporte 5</a></li>
									<li><a href="#">Reporte 6</a></li>
                                </ul>
                            </li>                            
                        </ul>
                    </li>
<?php
				}				
?>
                    <li>Salir
                        <ul style='width: 180px;'>
                            <li><a href="salir.php">Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
</div>
<?php
    }else{
        $sMessage = MSG_DB_NOT_CONNECTION;
        header("Location: error.php?msgError=".$sMessage);
    	exit();
    }
}else{
    $sMessage = MSG_PARAMETER_NOT_CONNECTION;
    header("Location: error.php?msgError=".$sMessage);
	exit();
}
?>