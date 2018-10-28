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
 			//$errno = mysql_errno().": ".mysql_error();
			$errno = mysqli_connect_errno().": ".mysqli_connect_error();
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
                        $detalle['tipoProducto']."','".
						$detalle['idProducto']."','".
						$detalle['codigo']."','".
						$detalle['descripcion']."','".
						$detalle['cantidad']."','".
						$detalle['peso']."','".
						$detalle['unidadMedida']."','".
						$detalle['costoUnitario']."','".
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

	function execSP_InsertCabeceraFacturaBoleta($cabecera){
       	$sel_query = " CALL sp_insert_cabecera_factura_boleta( '".
                        $cabecera['idEmpresa']."','".
						$cabecera['serieNumeroGRef']."','".
                        $cabecera['fechaEmision']."','".
						$cabecera['idComprobantePago']."','".
						$cabecera['comprobantePago']."','".
						$cabecera['idFormaPago']."','".
						$cabecera['formaPago']."','".
						$cabecera['idMoneda']."','".
						$cabecera['moneda']."','".
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['documentoIdentidad']."','".
						$cabecera['numeroDocumentoIdentidad']."','".
						$cabecera['idDireccionActual']."','".
						$cabecera['direccionActual']."','".
						$cabecera['totalLetras']."','".
						$cabecera['totalImporte']."','".
						$cabecera['totalIGV']."','".
						$cabecera['totalVenta']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}

	function execSP_UpdateCabeceraFacturaBoleta($cabecera){
       	$sel_query = " CALL sp_update_cabecera_factura_boleta( '".
                        $cabecera['idEmpresa']."','".
						$cabecera['idCabeceraFB']."','".
						$cabecera['serieNumeroGRef']."','".
                        $cabecera['fechaEmision']."','".
						$cabecera['idComprobantePago']."','".
						$cabecera['comprobantePago']."','".
						$cabecera['idFormaPago']."','".
						$cabecera['formaPago']."','".
						$cabecera['idMoneda']."','".
						$cabecera['moneda']."','".
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['documentoIdentidad']."','".
						$cabecera['numeroDocumentoIdentidad']."','".
						$cabecera['idDireccionActual']."','".
						$cabecera['direccionActual']."','".
						$cabecera['totalLetras']."','".
						$cabecera['totalImporte']."','".
						$cabecera['totalIGV']."','".
						$cabecera['totalVenta']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
		
	function execSP_InsertDetalleFacturaBoleta($detalle){
       	$sel_query = " CALL sp_insert_detalle_factura_boleta( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraFB']."','".
                        $detalle['tipoProducto']."','".
						$detalle['idProducto']."','".						
						$detalle['codigo']."','".
						$detalle['descripcion']."','".
						$detalle['cantidad']."','".
						$detalle['precioUnitario']."','".
						$detalle['importe']."','".
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

	function execSP_DeleteDetalleFacturaBoleta($detalle){
       	$sel_query = " CALL sp_delete_detalle_factura_boleta( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraFB']."','".
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

	function execSP_InsertCabeceraNota($cabecera){
       	$sel_query = " CALL sp_insert_cabecera_nota( '".
						$cabecera['idEmpresa']."','".
						$cabecera['idTipoNota']."','".
						$cabecera['tipoNota']."','".
						$cabecera['fechaEmision']."','".
						$cabecera['idComprobantePagoRef']."','".
						$cabecera['comprobantePagoRef']."','".
						$cabecera['serieNumeroCPRef']."','".
						$cabecera['fechaEmisionCPRef']."','".						
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['documentoIdentidad']."','".
						$cabecera['numeroDocumentoIdentidad']."','".
						$cabecera['idDireccionActual']."','".
						$cabecera['direccionActual']."','".
						$cabecera['idMotivoNota']."','".
						$cabecera['motivoNota']."','".
						$cabecera['idMoneda']."','".
						$cabecera['moneda']."','".			
						$cabecera['totalImporte']."','".
						$cabecera['totalIGV']."','".
						$cabecera['totalVenta']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	

	function execSP_InsertDetalleNota($detalle){
       	$sel_query = " CALL sp_insert_detalle_nota( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraNota']."','".
						$detalle['descripcion']."','".
						$detalle['importe']."','".
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


	function execSP_UpdateCabeceraNota($cabecera){
       	$sel_query = " CALL sp_update_cabecera_nota( '".
						$cabecera['idEmpresa']."','".
						$cabecera['idCabeceraNota']."','".
						$cabecera['idComprobantePagoRef']."','".
						$cabecera['comprobantePagoRef']."','".
						$cabecera['serieNumeroCPRef']."','".
						$cabecera['fechaEmisionCPRef']."','".						
						$cabecera['idCliente']."','".
						$cabecera['cliente']."','".
						$cabecera['documentoIdentidad']."','".
						$cabecera['numeroDocumentoIdentidad']."','".
						$cabecera['idDireccionActual']."','".
						$cabecera['direccionActual']."','".
						$cabecera['idMotivoNota']."','".
						$cabecera['motivoNota']."','".
						$cabecera['idMoneda']."','".
						$cabecera['moneda']."','".			
						$cabecera['totalImporte']."','".
						$cabecera['totalIGV']."','".
						$cabecera['totalVenta']."','".
						$cabecera['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}
	
	
	function execSP_DeleteDetalleNota($detalle){
       	$sel_query = " CALL sp_delete_detalle_nota( '".
                        $detalle['idEmpresa']."','".
						$detalle['idCabeceraNota']."','".
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

/* Tabla de Tranportista */
	function execSP_InsertTransportista($transportista){
       	$sel_query = " CALL sp_insert_transportista( '".
                        $transportista['idEmpresa']."','".
                        $transportista['codigo']."','".                       
                        $transportista['ruc']."','".
						$transportista['razonSocial']."','".
						$transportista['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);
     	return $result;
   	}	
	
	function execSP_UpdateTransportista($transportista){
       	$sel_query = " CALL sp_update_transportista( '".
                        $transportista['idEmpresa']."','".
                        $transportista['idTransportista']."','".
                        $transportista['codigo']."','".
						$transportista['ruc']."','".
                        $transportista['razonSocial']."','".                        
                        $transportista['idEstado']."','".
						$transportista['idUsuario']."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}	
	
	function execSP_DeleteTransportista($idEmpresa, $idTransportista, $idUsuario){
       	$sel_query = " CALL sp_delete_transportista( '".
                        $idEmpresa."','".
                        $idTransportista."','".
						$idUsuario."' ) ";
						
        //echo "***query:".$sel_query;		
       	$result = mysqli_query($this->dbSP['linkConex'], $sel_query);		
     	return $result;
   	}



/*---------------------------------------------------------------------------*/




























/*---------------------------------------------------------------------------*/
	/*
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
	*/

	
/*---------------------------------------------------------------------------*/

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
	

	*/
	
}

?>