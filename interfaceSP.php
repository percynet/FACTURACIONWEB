<?php
class DBsp
{
	var $dbSP;
	var $query_id = 0;

  	//Clase Constructor
	function DBsp($opt_db){
		$this->dbSP['host'] = trim($opt_db['host']);
		$this->dbSP['user'] = trim($opt_db['user']);
		$this->dbSP['pass'] = trim($opt_db['pass']);
		$this->dbSP['dbas'] = trim($opt_db['dbas']);
		$this->dbSP['connection'] = false;
		$this->dbSP['linkConex'] = "1";
		$this->dbSP['error'] = (bool)false;
	}
	
	//Abre la conexion con la base de datos
	function db_connect_sp(){
		//$this->dbSP['linkConex'] = new mysqli($this->dbSP['host'],$this->dbSP['user'],$this->dbSP['pass'], $this->dbSP['dbas']);
		$this->dbSP['linkConex'] = mysqli_connect($this->dbSP['host'],$this->dbSP['user'],$this->dbSP['pass'], $this->dbSP['dbas']);
		
		if (!$this->dbSP['linkConex']){
 			$errno = mysql_errno().": ".mysql_error();
 			$this->dbSP['connection'] = false;
	  	    $this->dbSP['error'] = "Error conectando a la base de datos (".$errno.")";
	 		return(false);
		}
		
	 	$this->dbSP['connection'] = true;
        return($this->dbSP['error']);
	}	

	//Cierra la conexion con la base de datos
	function db_disconnect_sp(){
		if ($this->dbSP['linkConex']) mysqli_close($this->dbSP['linkConex']);
		return((bool)true);
	}

	//Devuelve true o false segun si esta o no abierta o conectada la base da datos
	function is_connection_sp(){
		return($this->dbSP['connection']);
  	}

	//Devuelve un mensaje si sa ha producido o no un error en la conexion con la BD
  	function msg_error(){
		return($this->dbSP['error']);
	}


	/***********  FUNCIONES DE MANEJOS USUARIOS  *************/

/*---------------------------------------------------------------------------*/

	function execSP_InsertCabeceraGuiaRemision($cabecera){
       	$sel_query = " CALL sp_insert_cabecera_guia_remision( '".
                        $cabecera['idEmpresa']."','".
						$cabecera['serieNumeroGRCliente']."','".
                        $cabecera['fechaEmision']."','".
						$cabecera['fechaTraslado']."','".
						$cabecera['idClienteRemitente']."','".
						$cabecera['clienteRemitente']."','".
						$cabecera['documentoIdentidadCR']."','".
						$cabecera['numeroDocumentoIdentidadCR']."','".
						$cabecera['idDireccionPartida']."','".
						$cabecera['tipoViaPAR']."','".
						$cabecera['nombreViaPAR']."','".
						$cabecera['numeroPAR']."','".
						$cabecera['interiorPAR']."','".
						$cabecera['zonaPAR']."','".
						$cabecera['departamentoPAR']."','".
						$cabecera['provinciaPAR']."','".
						$cabecera['distritoPAR']."','".
						$cabecera['idClienteDestinatario']."','".
						$cabecera['clienteDestinatario']."','".
						$cabecera['documentoIdentidadCD']."','".
						$cabecera['numeroDocumentoIdentidadCD']."','".
						$cabecera['idDireccionLlegada']."','".
						$cabecera['tipoViaLLE']."','".
						$cabecera['nombreViaLLE']."','".
						$cabecera['numeroLLE']."','".
						$cabecera['interiorLLE']."','".
						$cabecera['zonaLLE']."','".
						$cabecera['departamentoLLE']."','".
						$cabecera['provinciaLLE']."','".
						$cabecera['distritoLLE']."','".
						$cabecera['idTransportista']."','".
						$cabecera['razonSocialTransportista']."','".
						$cabecera['rucTransportista']."','".
						$cabecera['observaciones']."','".
						$cabecera['idVehiculo']."','".
						$cabecera['idMarca']."','".
						$cabecera['marca']."','".
						$cabecera['placaTracto']."','".
						$cabecera['placaRemolque']."','".
						$cabecera['configuracionVehicular']."','".
						$cabecera['certificadoInscripcion']."','".
						$cabecera['idChofer']."','".
						$cabecera['chofer']."','".
						$cabecera['licenciaConducir']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}

	function execSP_UpdateCabeceraGuiaRemision($cabecera){
       	$sel_query = " CALL sp_update_cabecera_guia_remision( '".
                        $cabecera['idEmpresa']."','".
						$cabecera['idCabeceraGR']."','".
						$cabecera['serieNumeroGRCliente']."','".
                        $cabecera['fechaEmision']."','".
						$cabecera['fechaTraslado']."','".
						$cabecera['idClienteRemitente']."','".
						$cabecera['clienteRemitente']."','".
						$cabecera['documentoIdentidadCR']."','".
						$cabecera['numeroDocumentoIdentidadCR']."','".
						$cabecera['idDireccionPartida']."','".
						$cabecera['tipoViaPAR']."','".
						$cabecera['nombreViaPAR']."','".
						$cabecera['numeroPAR']."','".
						$cabecera['interiorPAR']."','".
						$cabecera['zonaPAR']."','".
						$cabecera['departamentoPAR']."','".
						$cabecera['provinciaPAR']."','".
						$cabecera['distritoPAR']."','".
						$cabecera['idClienteDestinatario']."','".
						$cabecera['clienteDestinatario']."','".
						$cabecera['documentoIdentidadCD']."','".
						$cabecera['numeroDocumentoIdentidadCD']."','".
						$cabecera['idDireccionLlegada']."','".
						$cabecera['tipoViaLLE']."','".
						$cabecera['nombreViaLLE']."','".
						$cabecera['numeroLLE']."','".
						$cabecera['interiorLLE']."','".
						$cabecera['zonaLLE']."','".
						$cabecera['departamentoLLE']."','".
						$cabecera['provinciaLLE']."','".
						$cabecera['distritoLLE']."','".
						$cabecera['idTransportista']."','".
						$cabecera['razonSocialTransportista']."','".
						$cabecera['rucTransportista']."','".
						$cabecera['observaciones']."','".
						$cabecera['idVehiculo']."','".
						$cabecera['idMarca']."','".
						$cabecera['marca']."','".
						$cabecera['placaTracto']."','".
						$cabecera['placaRemolque']."','".
						$cabecera['configuracionVehicular']."','".
						$cabecera['certificadoInscripcion']."','".
						$cabecera['idChofer']."','".
						$cabecera['chofer']."','".
						$cabecera['licenciaConducir']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
		
	function execSP_InsertDetalleGuiaRemision($detalle){
       	$sel_query = " CALL sp_insert_detalle_guia_remision( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraGR']."','".
                        $detalle['idProducto']."','".
						$detalle['codigo']."','".
						$detalle['descripcion']."','".
						$detalle['cantidad']."','".
						$detalle['peso']."','".
						$detalle['unidadMedida']."','".
						$detalle['costo']."','".
						$detalle['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
		//print_r($result);
		
		if ($result){
			mysqli_query($this->dbSP['linkConex'],"COMMIT");
	  	}else{
			mysqli_query($this->dbSP['linkConex'],"ROLLBACK");
		}
		
     	return $result;
   	}

	function execSP_DeleteDetalleGuiaRemision($detalle){
       	$sel_query = " CALL sp_delete_detalle_guia_remision( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraGR']."','".
						$detalle['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
		//print_r($result);
		
		if ($result){
			mysqli_query($this->dbSP['linkConex'],"COMMIT");
	  	}else{
			mysqli_query($this->dbSP['linkConex'],"ROLLBACK");
		}
		
     	return $result;
   	}













/*---------------------------------------------------------------------------*/


	function execSP_InsertCalidad($calidad){
       	$sel_query = " CALL sp_insert_calidad( '".
                        $calidad['idEmpresa']."','".
                        $calidad['calidad']."','".
						$calidad['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateCalidad($calidad){
       	$sel_query = " CALL sp_update_calidad( '".
                        $calidad['idEmpresa']."','".
                        $calidad['idCalidad']."','".
                        $calidad['calidad']."','".
                        $calidad['idEstado']."','".
						$calidad['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteCalidad($idEmpresa, $idCalidad, $idUsuario){
       	$sel_query = " CALL sp_delete_calidad( '".
                        $idEmpresa."','".
                        $idCalidad."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_InsertColor($color){
       	$sel_query = " CALL sp_insert_color( '".
                        $color['idEmpresa']."','".
                        $color['color']."','".
						$color['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateColor($color){
       	$sel_query = " CALL sp_update_color( '".
                        $color['idEmpresa']."','".
                        $color['idColor']."','".
                        $color['color']."','".
                        $color['idEstado']."','".
						$color['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteColor($idEmpresa, $idColor, $idUsuario){
       	$sel_query = " CALL sp_delete_color( '".
                        $idEmpresa."','".
                        $idColor."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_InsertMarca($marca){
       	$sel_query = " CALL sp_insert_marca( '".
                        $marca['idEmpresa']."','".
                        $marca['marca']."','".
						$marca['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateMarca($marca){
       	$sel_query = " CALL sp_update_marca( '".
                        $marca['idEmpresa']."','".
                        $marca['idMarca']."','".
                        $marca['marca']."','".
                        $marca['idEstado']."','".
						$marca['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteMarca($idEmpresa, $idMarca, $idUsuario){
       	$sel_query = " CALL sp_delete_marca( '".
                        $idEmpresa."','".
                        $idMarca."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}

/*---------------------------------------------------------------------------*/

	function execSP_InsertModelo($modelo){
       	$sel_query = " CALL sp_insert_modelo( '".
                        $modelo['idEmpresa']."','".
                        $modelo['idMarca']."','".
                        $modelo['modelo']."','".
						$modelo['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateModelo($modelo){
       	$sel_query = " CALL sp_update_modelo( '".
                        $modelo['idEmpresa']."','".                        
					 	$modelo['idModelo']."','".
						$modelo['idMarca']."','".
                        $modelo['modelo']."','".
                        $modelo['idEstado']."','".
						$modelo['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteModelo($idEmpresa, $idModelo, $idUsuario){
       	$sel_query = " CALL sp_delete_modelo( '".
                        $idEmpresa."','".
                        $idModelo."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_InsertTipoProducto($tipoProducto){
       	$sel_query = " CALL sp_insert_tipo_producto( '".
                        $tipoProducto['idEmpresa']."','".
                        $tipoProducto['tipoProducto']."','".
						$tipoProducto['nombreCorto']."','".
						$tipoProducto['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateTipoProducto($tipoProducto){
       	$sel_query = " CALL sp_update_tipo_producto( '".
                        $tipoProducto['idEmpresa']."','".
                        $tipoProducto['idTipoProducto']."','".
                        $tipoProducto['tipoProducto']."','".
						$tipoProducto['nombreCorto']."','".
                        $tipoProducto['idEstado']."','".
						$tipoProducto['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_DeleteTipoProducto($idEmpresa, $idTipoProducto, $idUsuario){
       	$sel_query = " CALL sp_delete_tipo_producto( '".
                        $idEmpresa."','".
                        $idTipoProducto."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_InsertProducto($producto){
       	$sel_query = " CALL sp_insert_producto( '".
                        $producto['idEmpresa']."','".
                        //$producto['idProducto']."','".
						$producto['idTipoProducto']."','".
						$producto['idMarca']."','".
						$producto['idModelo']."','".
						$producto['idColor']."','".
						$producto['idCalidad']."','".
						$producto['codigo']."','".
						$producto['producto']."','".
						$producto['anio']."','".
						$producto['precioUnitario']."','".
						$producto['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateProducto($producto){
       	$sel_query = " CALL sp_update_producto( '".
                        $producto['idEmpresa']."','".
                        $producto['idProducto']."','".
						$producto['idTipoProducto']."','".
						$producto['idMarca']."','".
						$producto['idModelo']."','".
						$producto['idColor']."','".
						$producto['idCalidad']."','".
						$producto['codigo']."','".
						$producto['producto']."','".
						$producto['anio']."','".
						$producto['precioUnitario']."','".
						$producto['idEstado']."','".
						$producto['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_DeleteProducto($idEmpresa, $idProducto, $idUsuario){
       	$sel_query = " CALL sp_delete_producto( '".
                        $idEmpresa."','".
                        $idProducto."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
		
/*---------------------------------------------------------------------------*/

	function execSP_InsertAgencia($agencia){
       	$sel_query = " CALL sp_insert_agencia( '".
                        $agencia['idEmpresa']."','".
                        $agencia['agencia']."','".
						$agencia['direccion']."','".
						$agencia['ruc']."','".
						$agencia['telefonoFijo']."','".
						$agencia['telefonoCelular']."','".
						$agencia['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateAgencia($agencia){
       	$sel_query = " CALL sp_update_agencia( '".
                        $agencia['idEmpresa']."','".
                        $agencia['idAgencia']."','".
                        $agencia['agencia']."','".
						$agencia['direccion']."','".
						$agencia['ruc']."','".
						$agencia['telefonoFijo']."','".
						$agencia['telefonoCelular']."','".
                        $agencia['idEstado']."','".
						$agencia['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_DeleteAgencia($idEmpresa, $idAgencia, $idUsuario){
       	$sel_query = " CALL sp_delete_agencia( '".
                        $idEmpresa."','".
                        $idAgencia."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_Test(){
       	$sel_query = " CALL SP_test() ";
        //echo "query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/
	
	function execSP_InsertCliente($cliente){
       	$sel_query = " CALL sp_insert_cliente( '".
                        $cliente['idEmpresa']."','".
                        $cliente['nombres']."','".
                        $cliente['apellidoPaterno']."','".
                        $cliente['apellidoMaterno']."','".
                        $cliente['idDocumentoIdentidad']."','".
						$cliente['nroDocumentoIdentidad']."','".
                        $cliente['idDistrito']."','".
                        $cliente['direccion']."','".
                        $cliente['telefonoFijo']."','".
						$cliente['telefonoCelular']."','".
                        //$cliente['idEstado']."','".  
						$cliente['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateCliente($cliente){
       	$sel_query = " CALL sp_update_cliente( '".
                        $cliente['idEmpresa']."','".
                        $cliente['idCliente']."','".
                        $cliente['nombres']."','".
                        $cliente['apellidoPaterno']."','".
                        $cliente['apellidoMaterno']."','".
                        $cliente['idDocumentoIdentidad']."','".
						$cliente['nroDocumentoIdentidad']."','".
                        $cliente['idDistrito']."','".
                        $cliente['direccion']."','".
                        $cliente['telefonoFijo']."','".
						$cliente['telefonoCelular']."','".
                        $cliente['idEstado']."','".
						$cliente['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteCliente($idEmpresa, $idCliente, $idUsuario){
       	$sel_query = " CALL sp_delete_cliente( '".
                        $idEmpresa."','".
                        $idCliente."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
    
/*---------------------------------------------------------------------------*/

	function execSP_InsertDistrito($distrito){
       	$sel_query = " CALL sp_insert_distrito( '".
                        $distrito['codigo']."','".
                        $distrito['distrito']."','".
						$distrito['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateDistrito($distrito){
       	$sel_query = " CALL sp_update_distrito( '".
                        $distrito['idDistrito']."','".
                        $distrito['codigo']."','".
                        $distrito['distrito']."','".
                        $distrito['idEstado']."','".
						$distrito['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteDistrito($idDistrito, $idUsuario){
       	$sel_query = " CALL sp_delete_distrito( '".
                        $idDistrito."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}

/*---------------------------------------------------------------------------*/

	function execSP_InsertCargo($cargo){
       	$sel_query = " CALL sp_insert_cargo( '".
                        $cargo['idEmpresa']."','".
                        $cargo['codigo']."','".
                        $cargo['cargo']."','".
						$cargo['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateCargo($cargo){
       	$sel_query = " CALL sp_update_cargo( '".
                        $cargo['idEmpresa']."','".
                        $cargo['idCargo']."','".
                        $cargo['codigo']."','".
                        $cargo['cargo']."','".
                        $cargo['idEstado']."','".
						$cargo['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteCargo($idEmpresa, $idCargo, $idUsuario){
       	$sel_query = " CALL sp_delete_cargo( '".
                        $idEmpresa."','".
                        $idCargo."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}

/*---------------------------------------------------------------------------*/

	function execSP_UpdateComprobante($comprobante){
       	$sel_query = " CALL sp_update_comprobante( '".
                        $comprobante['idEmpresa']."','".
                        $comprobante['idComprobante']."','".
                        $comprobante['comprobante']."','".
						$comprobante['serie']."','".
						$comprobante['numero']."','".
                        $comprobante['idEstado']."','".
						$comprobante['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}

/*---------------------------------------------------------------------------*/

	function execSP_InsertCabeceraComprobanteVenta($cabecera){
       	$sel_query = " CALL sp_insert_cabecera_comprobante_venta( '".
                        $cabecera['idEmpresa']."','".
                        $cabecera['idComprobante']."','".
						$cabecera['comprobante']."','".
						$cabecera['fechaEmision']."','".
						$cabecera['idAlmacen']."','".
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['idDocumentoIdentidadCliente']."','".
						$cabecera['nroDocumentoIdentidadCliente']."','".
						$cabecera['direccionCliente']."','".
						$cabecera['idMoneda']."','".
						$cabecera['moneda']."','".
						$cabecera['generarGR']."','".
						$cabecera['totalImporte']."','".
						$cabecera['totalIGV']."','".
						$cabecera['totalImpuesto']."','".
						$cabecera['totalVenta']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
/*---------------------------------------------------------------------------*/

	function execSP_GeneraSerieNumeroCabeceraComprobanteVenta($cabecera){
       	$sel_query = " CALL sp_generar_serie_numero_documento( '".
                        $cabecera['idEmpresa']."','".
                        $cabecera['idComprobanteVenta']."','".
						$cabecera['comprobante']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	

/*---------------------------------------------------------------------------*/
	
	function execSP_InsertDetalleComprobanteVenta($values){
       	$sel_query = " CALL sp_insert_detalle_comprobante_venta ".$values;
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}

/*---------------------------------------------------------------------------*/

	function execSP_GenerarGuiaRemision($cabecera){
       	$sel_query = " CALL sp_generar_guia_remision ( '".
                        $cabecera['idEmpresa']."','".
                        $cabecera['idComprobante']."','".
						$cabecera['comprobante']."','".
						$cabecera['fechaEmision']."','".
						$cabecera['idComprobanteVenta']."','".
						$cabecera['idAlmacen']."','".
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['nroDocumentoIdentidadCliente']."','".
						$cabecera['direccionCliente']."','".
						$cabecera['idAgencia']."','".
						$cabecera['agencia']."','".
						$cabecera['rucAgencia']."','".
						$cabecera['direccionAgencia']."','".
						$cabecera['marcaPlaca']."','".
						$cabecera['nroConstanciaInscripcion']."','".
						$cabecera['nroLicenciasConducir']."','".
						$cabecera['idMotivoTraslado']."','".
						$cabecera['motivoTraslado']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}

    /*
	function execSP_InsertEmpleado($empleado, $idUsuario){
       	$sel_query = " CALL sp_insert_empleado( ".
						$empleado['idEmpresa'].",".
						$empleado['idTipoEmpleado'].",".
						$empleado['idCargo'].",'".
						$empleado['nombres']."','".
						$empleado['apellidoPaterno']."','".
						$empleado['apellidoMaterno']."','".
						$empleado['dni']."','".
						$empleado['ruc']."',".
						$empleado['idDepartamento'].",".
						$empleado['idProvincia'].",".
						$empleado['idDistrito'].",'".
						$empleado['direccion']."',".
						$empleado['idSexo'].",".
						$empleado['idEstadoCivil'].",'".
						$empleado['telefono']."','".
						$empleado['fechaNacimiento']."','".
						$empleado['fechaIngreso']."','".
						$empleado['nroLibretaMilitar']."','".
						$empleado['nroBrevete']."','".
						$empleado['nroCarnetIPSS']."','".
						$empleado['nroPasaporte']."',".
						$empleado['idAfp'].",'".
						$empleado['fechaInscripcionAfp']."',".
						$empleado['nroTotalHijos'].",".
						$empleado['nroHijosEnEdadEscolar'].",".
						$empleado['idTipoPlanilla'].",".
						$empleado['idArea'].",'".
						$empleado['fechaIngresoPlanilla']."',".						
						$idUsuario." ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	

	function execSP_UpdateEmpleado($empleado, $idUsuario){
       	$sel_query = " CALL sp_update_empleado( ".
						$empleado['idEmpresa'].",".
						$empleado['idEmpleado'].",".
						$empleado['idTipoEmpleado'].",".
						$empleado['idCargo'].",'".
						$empleado['nombres']."','".
						$empleado['apellidoPaterno']."','".
						$empleado['apellidoMaterno']."','".
						$empleado['dni']."','".
						$empleado['ruc']."',".
						$empleado['idDepartamento'].",".
						$empleado['idProvincia'].",".
						$empleado['idDistrito'].",'".
						$empleado['direccion']."',".
						$empleado['idSexo'].",".
						$empleado['idEstadoCivil'].",'".
						$empleado['telefono']."','".
						$empleado['fechaNacimiento']."','".
						$empleado['fechaIngreso']."','".
						$empleado['nroLibretaMilitar']."','".
						$empleado['nroBrevete']."','".
						$empleado['nroCarnetIPSS']."','".
						$empleado['nroPasaporte']."',".
						$empleado['idAfp'].",'".
						$empleado['fechaInscripcionAfp']."',".
						$empleado['nroTotalHijos'].",".
						$empleado['nroHijosEnEdadEscolar'].",".
						$empleado['idTipoPlanilla'].",".
						$empleado['idArea'].",'".
						$empleado['fechaIngresoPlanilla']."',".
						$empleado['idEstado'].",".
						$idUsuario." ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}		
	
	
	function execSP_InsertCabeceraNotaPedido($idEmpresa, $notaPedido, $idUsuario){
       	$sel_query = " CALL sp_insert_cabecera_nota_pedido( '".
						$idEmpresa."','".
						$notaPedido['idPeriodo']."','".
						$notaPedido['fechaFacturacion']."','".
						$notaPedido['idAlmacen']."','".
						$notaPedido['idCliente']."','".
						$notaPedido['idVendedor']."','".
						$notaPedido['idDepartamento']."','".
						$notaPedido['idProvincia']."','".
						$notaPedido['idDistrito']."','".
						$notaPedido['idZona']."','".
						$notaPedido['idRuta']."','".
						$notaPedido['nroSegmento']."','".
						$notaPedido['idFormaPago']."','".
						$notaPedido['idComprobante']."','".
						$notaPedido['idMoneda']."','".
						$notaPedido['idGenerarGR']."','".
						$notaPedido['tipoCambio']."','".
						$notaPedido['totalImporte']."','".
						$notaPedido['totalIGV']."','".
						$notaPedido['totalImpuesto']."','".
						$notaPedido['totalDescuento']."','".
						$notaPedido['totalVenta']."','".
						$idUsuario."' ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	function execSP_InsertDetalleNotaPedido($values){
		$rsx = mysql_query("START TRANSACTION"); 
       	$sel_query = " CALL sp_insert_detalle_nota_pedido ".$values;
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
		if ($result){
			$rsx = mysql_query("COMMIT");
	  	}else{
			$rsx = mysql_query("ROLLBACK");
		}
     	return $result;
   	}

	
	function execSP_EjecutarAccionNotaPedido($idEmpresa, $idNotaPedido, $accion, $idUsuario){
       	$sel_query = " CALL sp_ejecutar_accion_nota_pedido( ".
						$idEmpresa.",".
						$idNotaPedido.",'".
						$accion."',".
						$idUsuario." ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	
	function execSP_EjecutarAccionComprobanteVenta($idEmpresa, $idComprobanteVenta, $accion, $idUsuario){
       	$sel_query = " CALL sp_ejecutar_accion_comprobante_venta( ".
						$idEmpresa.",".
						$idComprobanteVenta.",'".
						$accion."',".
						$idUsuario." ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	

	function execSP_EjecutarAccionGuiaRemision($idEmpresa, $idGuiaRemision, $accion, $idUsuario){
       	$sel_query = " CALL sp_ejecutar_accion_guia_remision( ".
						$idEmpresa.",".
						$idGuiaRemision.",'".
						$accion."',".
						$idUsuario." ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	

	function execSP_EjecutarAccionCuentaXCobrar($idEmpresa, $idCuentaXCobrar, $accion, $idUsuario){
       	$sel_query = " CALL sp_ejecutar_accion_cuenta_x_cobrar( ".
						$idEmpresa.",".
						$idCuentaXCobrar.",'".
						$accion."',".
						$idUsuario." ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
		
	function execSP_InsertRutaEmpleado($rutaEmpleado, $idUsuario){
       	$sel_query = " CALL sp_insert_ruta_empleado( '".
							$rutaEmpleado['idEmpresa']."','".
                            $rutaEmpleado['idDepartamento']."','".
                            $rutaEmpleado['idProvincia']."','".
                            $rutaEmpleado['idDistrito']."','".
							$rutaEmpleado['idZona']."','".
                            $rutaEmpleado['idRuta']."','".
							$rutaEmpleado['idTipoEmpleado']."','".
							$rutaEmpleado['idCargo']."','".
							$rutaEmpleado['idEmpleado']."','".
                            $idUsuario."')";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	
	function execSP_DeleteRutaEmpleado($rutaEmpleado, $idUsuario){
       	$sel_query = " CALL sp_delete_ruta_empleado( '".
							$rutaEmpleado['idEmpresa']."','".
							$rutaEmpleado['idRutaEmpleado']."','".
                            $idUsuario."')";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}		
	
	
	function execSP_CrearPeriodo($idEmpresa, $idUsuario){
       	$sel_query = " CALL sp_insert_periodo( '".
							$idEmpresa."','".
                            $idUsuario."')";
													
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_CerrarPeriodo($idEmpresa, $idPeriodo, $idUsuario){
       	$sel_query = " CALL sp_cerrar_periodo( '".
							$idEmpresa."','".
							$idPeriodo."','".
                            $idUsuario."')";
													
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	function execSP_CerrarOperacionDia($idEmpresa, $idOperacionDia, $fechaOperacionDiaNew, $idUsuario){
       	$sel_query = " CALL sp_cerrar_operacion_dia( '".
							$idEmpresa."','".
							$idOperacionDia."','".
							$fechaOperacionDiaNew."','".
                            $idUsuario."')";
													
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	
	function execSP_InsertDetalleCuentaXCobrar($idEmpresa, $detalleCuentaXCobrar, $idUsuario){
       	$sel_query = " CALL sp_insert_detalle_cuenta_x_cobrar( '".
						$idEmpresa."','".
						$detalleCuentaXCobrar['idCuentaXCobrar']."','".
						$detalleCuentaXCobrar['fechaPago']."','".
						$detalleCuentaXCobrar['idMedioPago']."','".
						$detalleCuentaXCobrar['medioPago']."','".
						$detalleCuentaXCobrar['numeroDocumentoPago']."','".
						$detalleCuentaXCobrar['idMoneda']."','".
						$detalleCuentaXCobrar['moneda']."',".
						$detalleCuentaXCobrar['montoPago'].",'".
						$idUsuario."' ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	

	function execSP_UpdateGuiaRemision($idEmpresa, $guiaRemision, $idUsuario){
       	$sel_query = " CALL sp_update_cabecera_guia_remision( '".
						$idEmpresa."','".
						$guiaRemision['idGuiaRemision']."','".
						$guiaRemision['idMotivoTraslado']."','".
						$guiaRemision['motivoTraslado']."','".
						$guiaRemision['idTransportista']."','".
						$guiaRemision['transportista']."','".
						$guiaRemision['marca']."','".
						$guiaRemision['placa']."','".
						$guiaRemision['fechaTraslado']."','".
						$idUsuario."' ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	
	function execSP_UpdateProductoAlmacen($values){
		$rsx = mysql_query("START TRANSACTION"); 
       	$sel_query = " CALL sp_update_producto_almacen ".$values;
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
		if ($result){
			$rsx = mysql_query("COMMIT");
	  	}else{
			$rsx = mysql_query("ROLLBACK");
		}
     	return $result;
   	}	
	*/
	
}

?>