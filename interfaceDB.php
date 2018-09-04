<?php
class DBSql
{
	var $db;
	var $query_id = 0;

  	//Clase Constructor
	function DBSql($opt_db){
		$this->db['host'] = trim($opt_db['host']);
		$this->db['user'] = trim($opt_db['user']);
		$this->db['pass'] = trim($opt_db['pass']);
		$this->db['dbas'] = trim($opt_db['dbas']);
		$this->db['connection'] = false;
		$this->db['linkConex'] = "1";
		$this->db['error'] = (bool)false;
	}

	//Abre la conexion con la base de datos
	function db_connect(){
		$this->db['linkConex'] = @mysql_pconnect($this->db['host'],$this->db['user'],$this->db['pass']);
		if (!$this->db['linkConex']){
 			$errno = mysql_errno().": ".mysql_error();
 			$this->db['connection'] = false;
	  	    $this->db['error'] = "Error conectando a la base de datos (".$errno.")";
	 		return(false);
		}else {
            if (!@mysql_select_db($this->db['dbas'],$this->db['linkConex'])){
	            $errno = mysql_errno().": ".mysql_error();
                $this->db['connection'] = false;
                $this->db['error'] = "Error seleccionando la base de datos (".$errno.")";
                return(false);
             }
        }
                                                         
	 	$this->db['connection'] = true;
        return($this->db['error']);
	}	

	//Cierra la conexion con la base de datos
	function db_disconnect(){
		if ($this->db['linkConex']) @mysql_close($this->db['linkConex']);
		return((bool)true);
	}

	//Devuelve true o false segun si esta o no abierta o conectada la base da datos
	function is_connection(){
		return($this->db['connection']);
  	}

	//Devuelve un mensaje si sa ha producido o no un error en la conexion con la BD
  	function msg_error(){
		return($this->db['error']);
	}

  //Ejecuta una sentencia SQL. La funcion recibe como parametro de entrada la SQL a ejecutar
  	function db_executequery($query){
  		$this->query_id = @mysql_query($query, $this->db['linkConex']);
    	if ($this->query_id != NULL){
    		while($tmp = $this->db_next()){
      			$info_elements[]=$tmp;
      		}
      		return $info_elements;
    	}
 	}

	/*
	 * Devuelve un array con los resultados de la ejecucion de una query.
	 * Cada columna es etiquetada con el nombre de la columna de la BD
	 * El array contendra el resultado o NULL si no hay filas o no se haya
	 * podido ejecutar la consulta
	 */
	function db_next(){
		//$query_id es el id de la consulta que se ha ejecutado
	  	if ($this->query_id != NULL){
	  		$row = @mysql_fetch_row($this->query_id);
      		if ($row != NULL){
	      		foreach($row as $i => $value){
	       			$column = @mysql_field_name($this->query_id,$i);
	        		$resultado["$column"] = $value;
        		}
        		return ($resultado);
	    	}else{
      			return NULL;
			}
		}else{
			return NULL;
		}
	}


	/***********  FUNCIONES DE MANEJOS USUARIOS  *************/

	/*
    function sqlUsuario($idEmpresa,$usuario,$password){
        $sel_query = " SELECT U.idUsuario, U.usuario, R.rol, E.idEmpresa, E.razonSocial, E.titulo ";
        $sel_query.= " FROM usuario U INNER JOIN empresa E ON (U.idEmpresa=E.idEmpresa) INNER JOIN rol R ON (U.idRol=R.idRol) ";
        $sel_query.= " WHERE E.idEmpresa = '".$idEmpresa."' AND U.usuario = '".$usuario."' AND U.passw = '".$passw."' AND U.idEstado = 1";
        
        $result = mysql_query($sel_query);
        return $result;
    }
	*/
	 
    function sqlExisteUsuario($idEmpresa, $usuario){
        $sel_where = "";
        if(strtoupper($usuario) != "ADMIN"){
            $sel_where = " AND US.idEmpresa = '".$idEmpresa."' ";
        }
        
        $sel_query = " SELECT US.idUsuario, ES.estado";
        $sel_query.= " FROM usuario US INNER JOIN estado ES ON (US.idEstado = ES.idEstado) ";
        $sel_query.= " WHERE US.usuario = '".strtoupper($usuario)."' ".$sel_where;
        //echo "sel_query:".$sel_query;
        $result = mysql_query($sel_query);
        return $result;
    }
     
	function sqlGetUsuario($idEmpresa, $usuario, $passwd){
        $sel_where = "";
        if(strtoupper($usuario) != "ADMIN"){
            $sel_where = " AND idEmpresa = '".$idEmpresa."' ";
        }
        //$sel_query = " SELECT idEmpresa, idUsuario, usuario, idRol, rol, idEmpleado, codigoEmpleado, nombresApellidos ";
		$sel_query = " SELECT * ";
        $sel_query.= " FROM vw_usuario ";
        $sel_query.= " WHERE usuario = '".strtoupper($usuario)."' AND passwd = '".strtoupper($passwd)."' AND estado = 'ACTIVO' ".$sel_where;
        //echo "sel_query:".$sel_query;
        $result = mysql_query($sel_query);
        return $result;
    }

	/*
   	function sqlGetEmpresa($codigoInterno){
        $sel_query = " SELECT EM.idEmpresa, EM.razonSocial, EM.ruc, EM.direccion, EM.telefonoFijo, EM.telefonoCelular, EM.email, EM.titulo, EM.descripcion, EM.rutaLogo, ES.estado ";
        $sel_query.= " FROM empresa em INNER JOIN estado ES ON (EM.idEstado = ES.idEstado)";
        $sel_query.= " WHERE EM.codigo = '".$codigoInterno."' AND ES.estado = 'ACTIVO'  ";
        //echo "query:".$sel_query;
        $result = mysql_query($sel_query);
        return $result;		
   	}

	function sqlListaMoneda($estado){
       	$sel_query = " SELECT mn.idMoneda, mn.simbolo, mn.moneda ";
		$sel_query.= " FROM moneda mn INNER JOIN estado es ON (mn.idEstado = es.idEstado)";
		$sel_query.= " WHERE es.estado = '".$estado."' ";
		//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}	
	*/
	
   	function sqlGetEmpresa($codigoInterno){
        $sel_query = " SELECT * ";
        $sel_query.= " FROM vw_empresa ";
        $sel_query.= " WHERE codigo = '".$codigoInterno."' AND estado = 'ACTIVO' ";
        //echo "query:".$sel_query;
        $result = mysql_query($sel_query);
        return $result;		
   	}	

	/*
	function sqlListaMoneda($estado){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_moneda ";
		$sel_query.= " WHERE estado = '".$estado."' ";
		//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	*/	
	
	/*--------------------------ADMINISTRACION----------------------------------------------------------*/
	
   	function sqlListaEstado(){
       	$sel_query = " SELECT idEstado, estado ";
		$sel_query.= " FROM estado ";

       	$result = mysql_query($sel_query);
     	return $result;		
   	}	
	
    function sqlListaTabla($idEmpresa, $tipoTabla, $estado){
       	$sel_query = " SELECT * FROM vw_tabla ";
		$sel_query.= " WHERE tipoTabla = '".$tipoTabla."' AND ";
        $sel_query.= " idEmpresa = '".$idEmpresa."' AND estado = '".$estado."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}	
		
    /*-------------------------MAESTROS-----------------------------------------------------------------*/
	
	
	/*----DEPARTAMENTO---*/
	
	function sqlListaDepartamento($estado){
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_departamento ";
        $sel_query.= " WHERE estado = '".$estado."' ";
        $sel_query.= " ORDER BY departamento ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
	}
	
	
    /*----PROVINCIA---*/
    
    function sqlListaProvincia($idDepartamento, $estado){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_provincia ";
        $sel_query.= " WHERE estado = '".$estado."' AND idDepartamento = '".$idDepartamento."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	
	
	
	


	
	/*---TRANSPORTISTA--------*/	

    function sqlListaTransportista($idEmpresa, $estado){
       	$sel_query = " SELECT * FROM vw_transportista ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND estado = '".$estado."'";
        echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}	

	/*---MARCA--------*/	

    function sqlFiltrarMarca($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND marca like '%".$filtro['valor']."%' ";
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_marca ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
 	
    function sqlGetMarcaXID($idMarca, $estado){
       	$sel_query = " SELECT * FROM vw_marca ";
        $sel_query.= " WHERE idMarca = '".$idMarca."' AND estado = '".$esatdo."´";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
    function sqlListaMarca($idEmpresa){
       	$sel_query = " SELECT * FROM vw_marca ";
         $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}	

	/*---MODELO--------*/	

    function sqlFiltrarModelo($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND modelo like '%".$filtro['valor']."%' ";
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_modelo ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
 	
    function sqlGetModeloXID($idModelo){
       	$sel_query = " SELECT * FROM vw_modelo ";
        $sel_query.= " WHERE idModelo = '".$idModelo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
    function sqlListaModelo($idEmpresa, $idMarca){
       	$sel_query = " SELECT * FROM vw_modelo ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND ";
		$sel_query.= " idMarca = '".$idMarca."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
/*---------------------------------------------------------*/

	/*---VEHICULO--------*/	

    function sqlFiltrarVehiculo($filtro){
		//print_r($filtro);
        $where = "";
		$where .= " AND idTransportista = '".$filtro['idTransportista']."' ";
        
		if($filtro['idMarca'] != "0"){
			$where .= " AND idMarca = '".$filtro['idMarca']."' ";
        }
		if($filtro['idModelo'] != "0"){
			$where .= " AND idModelo = '".$filtro['idModelo']."' ";
        }
				
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_vehiculo ";
        $sel_query.= " WHERE idEmpresa = '".$filtro['idEmpresa']."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
		
     	return $result;
   	}


	/*---CHOFER--------*/	

    function sqlFiltrarChofer($filtro){
		//print_r($filtro);
        $where = "";
		$where .= " AND idTransportista = '".$filtro['idTransportista']."' ";
        
		if($filtro['chofer'] != ""){
			$where .= " AND chofer = '".$filtro['chofer']."' ";
        }
				
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_chofer ";
        $sel_query.= " WHERE idEmpresa = '".$filtro['idEmpresa']."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
		
     	return $result;
   	}
	
	
	










	/*---TIPO_PRODUCTO--------*/	

    function sqlFiltrarTipoProducto($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND tipoProducto like '%".$filtro['valor']."%' ";
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_tipo_producto ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
 	
    function sqlGetTipoProductoXID($idTipoProducto){
       	$sel_query = " SELECT * FROM vw_tipo_producto ";
        $sel_query.= " WHERE idTipoProducto = '".$idTipoProducto."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
    function sqlListaTipoProducto($idEmpresa){
       	$sel_query = " SELECT * FROM vw_tipo_producto ";
         $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	

	/*---AGENCIA--------*/	

    function sqlFiltrarAgencia($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND agencia like '%".$filtro['valor']."%' ";
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_agencia";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
 	
    function sqlGetAgenciaXID($idAgencia){
       	$sel_query = " SELECT * FROM vw_agencia ";
        $sel_query.= " WHERE idAgencia = '".$idAgencia."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}


	/*---PRODUCTO--------*/	

    function sqlListaProductos($idEmpresa){
       	$sel_query = " SELECT * FROM vw_producto ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
    function sqlFiltrarProducto($idEmpresa, $tipoProducto, $filtro){
		//print_r($filtro);
        $where = "";
		
		if($filtro['codigo'] == "1"){
			$where .= " AND codigo  like '%".$filtro['codigo']."%' ";
		}else{		
			if($filtro['producto'] == "2"){
				$where .= " AND producto like '%".$filtro['producto']."%' ";
			}
		}

		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_producto ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND tipoProducto = '".$tipoProducto."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}   
 	
    function sqlGetProductoXID($idProducto){
       	$sel_query = " SELECT * FROM vw_producto ";
        $sel_query.= " WHERE idProducto = '".$idProducto."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

 /*--------------------------------------------------------------------------------------------------*/

    function sqlListaComprobantePago($idEmpresa, $tipoComprobantePago){
       	$sel_query = " SELECT * FROM comprobante_pago ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND tipoComprobantePago = '".$tipoComprobantePago."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

 /*--------------------------------------------------------------------------------------------------*/

    function sqlListaFormaPago($idEmpresa){
       	$sel_query = " SELECT idRegistroTabla as idFormaPago, descripcion as formaPago FROM vw_registro_tabla ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND nombreTabla = 'forma_pago' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
 /*--------------------------------------------------------------------------------------------------*/

    function sqlListaMoneda($idEmpresa){
       	$sel_query = " SELECT idRegistroTabla as idMoneda, descripcion as moneda FROM vw_registro_tabla ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND nombreTabla = 'moneda' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}	
	
 /*--------------------------------------------------------------------------------------------------*/

	function sqlListaAlmacen($idEmpresa, $estado){
		$where = '';
		if($estado != ''){
			$where = " AND estado = '".$estado."' ";
		}
       	$sel_query = " SELECT * FROM vw_almacen ";
		$sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		$sel_query.= " ORDER BY almacen ";
		//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

 /*--------------------------------------------------------------------------------------------------*/
	
    function sqlListaMotivoTraslado($idEmpresa, $estado){
        $where = "";
        if($estado != ""){
            $where = "  AND estado = '".$estado."' ";
        }
        
       	$sel_query = " SELECT * FROM vw_motivo_traslado mt ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}	

 	/*--------------------------------------------------------------------------------------------------*/
	/*---PRODUCTO--------*/	

    function sqlFiltrarComprobanteVenta($idEmpresa, $filtro){
		//print_r($filtro);
       // $where = "";
        $where = "  AND STR_TO_DATE(fechaEmision, '%d/%m/%Y') ";
		$where .= " BETWEEN STR_TO_DATE('".$filtro['fechaDesde']."', '%d/%m/%Y') AND STR_TO_DATE('".$filtro['fechaHasta']."', '%d/%m/%Y') ";
			
		if($filtro['idComprobante'] != "0"){
			$where .= " AND idComprobante = '".$filtro['idComprobante']."' ";
		}
		
		if($filtro['serieNumero'] != ""){
			$where .= " AND serieNumero = '".$filtro['serieNumero']."' ";
		}
		
		if($filtro['cliente'] != ""){
			$where .= " AND cliente = '".$filtro['cliente']."' ";
		}
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_comprobante_venta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	} 

        
    /*--------------------------------------------------------------------------------------------------*/

    function sqlFiltrarCabeceraGR($idEmpresa, $filtro){
		//print_r($filtro);
        // $where = "";
        $where = "  AND DATE_FORMAT(fechaEmision, '%Y-%m-%d') ";
		$where .= " BETWEEN STR_TO_DATE('".$filtro['fechaDesde']."', '%d/%m/%Y') AND STR_TO_DATE('".$filtro['fechaHasta']."', '%d/%m/%Y') ";
		
		if($filtro['serieNumero'] != ""){
			$where .= " AND serieNumero = '".$filtro['serieNumero']."' ";
		}
		
		if($filtro['cliente'] != ""){
			$where .= " AND clienteRemitente = '".$filtro['cliente']."' ";
		}
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM cabecera_guia_remision ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where. " AND idEstado = '3'";
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	
    function sqlFiltrarGR($idEmpresa, $filtro){
		//print_r($filtro);
        // $where = "";
        
		if($filtro['cliente'] != ""){
			$where .= " AND clienteRemitente = '".$filtro['cliente']."' ";
		}
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM cabecera_guia_remision ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where. " AND idEstado = '3'";
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}	

	/*--------------------------------------------------------------------------------------------------*/
	
	function sqlGetCabeceraGuiaRemision($idEmpresa, $idCabeceraGR){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM cabecera_guia_remision ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCabeceraGR = '".$idCabeceraGR."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetDetalleGuiaRemision($idEmpresa, $idCabeceraGR){
	 	$sel_query = " SELECT * ";
		$sel_query.= " FROM detalle_guia_remision ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCabeceraGR = '".$idCabeceraGR."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
	}
	
	function sqlGetDetalleGRforFB($idEmpresa, $cabecerasGR){
		
	 	$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_detalle_gr_for_fb ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCabeceraGR IN (".$cabecerasGR.")";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
	}
	
	
	
    /*--------------------------------------------------------------------------------------------------*/

    function sqlFiltrarCabeceraFB($idEmpresa, $filtro){
		//print_r($filtro);
        // $where = "";
        $where = "  AND DATE_FORMAT(fechaEmision, '%Y-%m-%d') ";
		$where .= " BETWEEN STR_TO_DATE('".$filtro['fechaDesde']."', '%d/%m/%Y') AND STR_TO_DATE('".$filtro['fechaHasta']."', '%d/%m/%Y') ";
		
		if($filtro['serieNumero'] != ""){
			$where .= " AND serieNumeroFB = '".$filtro['serieNumero']."' ";
		}
		
		if($filtro['cliente'] != ""){
			$where .= " AND cliente = '".$filtro['cliente']."' ";
		}
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM cabecera_factura_boleta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where. " AND idEstado = '3'";
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	
    /*--------------------------------------------------------------------------------------------------*/

	function sqlGetCabeceraFacturaBoleta($idEmpresa, $idCabeceraFB){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM cabecera_factura_boleta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCabeceraFB = '".$idCabeceraFB."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetDetalleFacturaBoleta($idEmpresa, $idCabeceraFB){
	 	$sel_query = " SELECT * ";
		$sel_query.= " FROM detalle_factura_boleta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCabeceraFB = '".$idCabeceraFB."' ";
		$sel_query.= " ORDER BY idDetalleFB ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
	}
	  
    /*--------------------------------------------------------------------------------------------------*/



    /*--------------------------------------------------------------------------------------------------*/

    /*--------------------------------------------------------------------------------------------------*/






    /*--------------------------------------------------------------------------------------------------*/

    /*--------------------------------------------------------------------------------------------------*/
	   
    /*--------------------------------------------------------------------------------------------------*/
    /*----COMUNES----*/
        function sqlListaTablaUbigeoIndependiente($tabla){        
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM ".$tabla;
        $sel_query.= " WHERE idEstado = '1' ";
        
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
    
    function sqlListaTablaUbigeoDependiente($tabla, $nombreCampoPadre, $valorIdPadre ){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM ".$tabla;
        $sel_query.= " WHERE idEstado = '1' AND ".$nombreCampoPadre." = '".$valorIdPadre."' ";
        
       	$result = mysql_query($sel_query);
     	return $result;
   	}    
    
    function sqlListaTablaIndependiente($idEmpresa, $tabla){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM ".$tabla;
        $sel_query.= " WHERE idEstado = '1' AND idEmpresa = '".$idEmpresa."' ";
        
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
    
    function sqlListaTablaDependiente($idEmpresa, $tabla, $nombreCampoPadre, $valorIdPadre ){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM ".$tabla;
        $sel_query.= " WHERE idEstado = '1' AND idEmpresa = '".$idEmpresa."' AND ".$nombreCampoPadre." = '".$valorIdPadre."' ";
        //echo $sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
    
    /*--------------------------------------------------------------------------------------------------*/
    /*----CLIENTE----*/ 
	
     function sqlFiltrarCliente($idEmpresa, $filtro){
		//print_r($filtro);
        $where = " ";
        
		if($filtro['filtro'] == "1" || $filtro['filtro'] == "2"){
			$where .= " AND numeroDocumentoIdentidad like '%".$filtro['valor']."%' ";
		}else{
			if($filtro['filtro'] == "3"){
				$where .= " AND cliente like '%".$filtro['valor']."%' ";
            }
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_cliente ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	 }   

     function sqlFiltrarClienteXDoc($idEmpresa, $filtro, $idDocumentoIdentidad){
		//print_r($filtro);
        $where = " ";
        
		if($filtro['filtro'] == "1" || $filtro['filtro'] == "2"){
			$where .= " AND nroDocumentoIdentidad like '%".$filtro['valor']."%' ";
		}else{
			if($filtro['filtro'] == "3"){
				$where .= " AND cliente like '%".$filtro['valor']."%' ";
            }
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_cliente ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idDocumentoIdentidad = '".$idDocumentoIdentidad."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
 	
    function sqlGetClienteXID($idEmpresa, $idCliente){
       	$sel_query = " SELECT * FROM vw_cliente ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idCliente = '".$idCliente."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetClienteXCodigo($idEmpresa, $codigo){
       	$sel_query = " SELECT * FROM vw_cliente ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND codigo = '".$codigo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

/*--------------------------------------------------------------------------------------*/

	function sqlGetDireccionClienteXID($idEmpresa, $idDireccion){
       	$sel_query = " SELECT * FROM vw_direccion_lugar ";
        $sel_query.= " WHERE idDireccionLugar = '".$idDireccion."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
/*--------------------------------------------------------------------------------------*/
    /*----TRANSPORTISTA----*/ 
	
     function sqlFiltrarTransportista($idEmpresa, $filtro){
		//print_r($filtro);
        $where = " ";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND codigo like '%".$filtro['valor']."%' ";			
		}else{
			if($filtro['filtro'] == "2"){
				$where .= " AND ruc like '%".$filtro['valor']."%' ";
			}else{
				if($filtro['filtro'] == "3"){
					$where .= " AND razonSocial like '%".$filtro['valor']."%' ";
    	        }
			}
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_transportista ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	 }  
	
/*--------------------------------------------------------------------------------------*/	
	function sqlListaSexo(){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM  sexo ";
		//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}

/*--------------------------------------------------------------------------------------*/	

    function sqlFiltrarDistrito($filtro){
		//print_r($filtro);
        $where = " 1=1  ";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND codigo like '%".$filtro['valor']."%' ";
		}else{
			if($filtro['filtro'] == "2"){
				$where .= " AND distrito like '%".$filtro['valor']."%' ";
            }
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_distrito ";
        $sel_query.= " WHERE ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
    
    function sqlListaDistrito($estado){
       	$sel_query = " SELECT DT.idDistrito, DT.distrito, ES.estado ";
		$sel_query.= " FROM distrito DT INNER JOIN estado ES ON (DT.idEstado = ES.idEstado)";
        $sel_query.= " WHERE ES.estado = '".$estado."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
 	
    function sqlGetDistritoXID($idDistrito){
       	$sel_query = " SELECT * FROM vw_distrito ";
        $sel_query.= " WHERE idDistrito = '".$idDistrito."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetDistritoXCodigo($codigo){
       	$sel_query = " SELECT * FROM vw_distrito ";
        $sel_query.= " WHERE codigo = '".$codigo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

/*--------------------------------------------------------------------------------------*/	

    function sqlFiltrarCargo($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND codigo like '%".$filtro['valor']."%' ";
		}else{
			if($filtro['filtro'] == "2"){
				$where .= " AND cargo like '%".$filtro['valor']."%' ";
            }
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_cargo ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   

	function sqlListaCargo($estado){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_cargo ";
		$sel_query.= " WHERE estado = '".$estado."' ";
		//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}	
 	
    function sqlGetCargoXID($idCargo){
       	$sel_query = " SELECT * FROM vw_cargo ";
        $sel_query.= " WHERE idCargo = '".$idCargo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetCargoXCodigo($codigo){
       	$sel_query = " SELECT * FROM vw_cargo ";
        $sel_query.= " WHERE codigo = '".$codigo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

/*--------------------------------------------------------------------------------------*/	

     function sqlFiltrarEmpleado($idEmpresa, $filtro){
		//print_r($filtro);
        $where = " ";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND dni like '%".$filtro['valor']."%' ";
		}else{
			if($filtro['filtro'] == "2"){
				$where .= " AND empleado like '%".$filtro['valor']."%' ";
            }
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_empleado ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}   
 	
    function sqlGetEmpleadoXID($idEmpresa, $idEmpleado){
       	$sel_query = " SELECT * FROM vw_empleado ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idEmpleado = '".$idEmpleado."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetEmpleadoXCodigo($idEmpresa, $codigo){
       	$sel_query = " SELECT * FROM vw_empleado ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND codigo = '".$codigo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

/*--------------------------------------------------------------------------------------*/

    function sqlGetAccesoRolModulo($idEmpresa, $idRol){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM acceso_rol_modulo ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idRol = '".$idRol."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	
/*--------------------------------------------------------------------------------------*/
	
    function sqlFiltrarComprobante($idEmpresa, $filtro){
		//print_r($filtro);
        $where = "";
        
		if($filtro['filtro'] == "1"){
			$where .= " AND comprobante like '%".$filtro['valor']."%' ";
        }
		
		$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_comprobante ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' ".$where;
		
       	//echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
	
    function sqlGetComprobanteXID($idComprobante){
       	$sel_query = " SELECT * FROM vw_comprobante ";
        $sel_query.= " WHERE idComprobante = '".$idComprobante."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}
	
	function sqlGetComprobanteXCodigo($codigo){
       	$sel_query = " SELECT * FROM vw_comprobante ";
        $sel_query.= " WHERE codigo = '".$codigo."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

	
	
/*--------------------------------------------------------------------------------------*/

	function sqlGetCabeceraComprobanteVenta($idEmpresa, $idComprobanteVenta){
       	$sel_query = " SELECT * ";
		$sel_query.= " FROM vw_comprobante_venta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idComprobanteVenta = '".$idComprobanteVenta."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
   	}

/*--------------------------------------------------------------------------------------*/
	
	function sqlGetDetalleComprobanteVenta($idEmpresa, $idComprobanteVenta){
	 	$sel_query = " SELECT * ";
		$sel_query.= " FROM detalle_comprobante_venta ";
        $sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idComprobanteVenta = '".$idComprobanteVenta."' ";
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;
	}
	

/*--------------------------------------------------------------------------------------*/	
  







































  
/*--------------------------------------------------------------------------------------*/	

/*--------------------------------------------------------------------------------------*/	

/*--------------------------------------------------------------------------------------*/	
    /*
	function sqlFiltrarCargo($idEmpresa, $filtro, $valor){
        $where = " ";
        
        if($filtro == "1"){
            $where .= " AND CG.codigo = '".$valor."' ";
        }else{
            if($filtro == "2"){
                $where .= " AND CG.cargo like '%".$valor."%' ";
            }else{
                if($filtro == "3"){
                    $where .= " AND CG.idEstado = '".$valor."' ";
                }
            }
        }
        
       	$sel_query = " SELECT CG.idCargo, CG.codigo, TE.tipoEmpleado, CG.cargo, ES.estado ";
		$sel_query.= " FROM cargo CG INNER JOIN tipo_empleado TE ON (CG.idTipoEmpleado = TE.idTipoEmpleado) ";
        $sel_query.= " INNER JOIN estado ES ON (CG.idEstado = ES.idEstado) ";
        $sel_query.= " WHERE CG.idEmpresa = '".$idEmpresa."' ".$where;
        //echo "query:".$sel_query;
       	$result = mysql_query($sel_query);
     	return $result;		
   	}
    */

/*--------------------------------------------------------------------------------------*/	


	
	
	
/*--------------------------------------------------------------------------------------*/	

/*--------------------------------------------------------------------------------------*/	
	
/*--------------------------------------------------------------------------------------*/	
	

/*--------------------------------------------------------------------------------------*/	
    
    /*
    function sqlInsertCliente($idEmpresa, $cliente, $idUsuario){
		$sel_query  = " INSERT INTO cliente (idEmpresa, nombres, apellidoPaterno, apellidoMaterno, dni, idDistrito, idUrbanizacion, direccion, ";
		$sel_query .= " telefonoFijo, telefonoCelular, marcaAntena, codigoMACAntena, ipAntena, frecuenciaAntena, marcaRouter, codigoMACRouter, ";
	    $sel_query .= " ipRouter, fechaIngreso, diaPago, idEstado, idUsuario)";
		$sel_query .= " VALUES('".
                            $cliente['idEmpresa']."','".
                            $cliente['nombres']."','".
                            $cliente['apellidoPaterno']."','".
                            $cliente['apellidoMaterno']."','".
                            $cliente['dni']."','".
                            $cliente['idDistrito']."','".
                            $cliente['idUrbanizacion']."','".
                            $cliente['direccion']."','".
                            $cliente['telefonoFijo']."','".
							$cliente['telefonoCelular']."','".
                            $cliente['marcaAntena']."','".
							$cliente['codigoMACAntena']."','".
                            $cliente['ipAntena']."','".
							$cliente['frecuenciaAntena']."','".                            
                            $cliente['marcaRouter']."','".
                            $cliente['codigoMACRouter']."','".                            
                            $cliente['ipRouter']."','".
                            $cliente['fechaIngreso']."','".
                            $cliente['diaPago']."','".
                            //$cliente['idEstado']."','".                            
                            $idUsuario."')";
	    //echo "CREAR:".$sel_query ;	
		$result = mysql_query($sel_query);
		return $result;
	}
    
    function sqlUpdateCliente($cliente, $idUsuario){
		$sel_query  = " UPDATE cliente ";
		$sel_query .= " SET   idTipoCliente = '".$cliente['idTipoCliente']."', ".
                            " codigo = '".$cliente['codigo']."', ".
                            " ruc = '".$cliente['ruc']."', ".
                            " dni = '".$cliente['dni']."', ".
                            " razonSocial = '".$cliente['razonSocial']."', ".
                            " idDepartamento = '".$cliente['idDepartamento']."', ".
                            " idProvincia = '".$cliente['idProvincia']."', ".
                            " idDistrito = '".$cliente['idDistrito']."', ".
							" idZona = '".$cliente['idZona']."', ".
                            " idRuta = '".$cliente['idRuta']."', ".
							" nroSegmento = '".$cliente['nroSegmento']."', ".
                            " direccionFiscal = '".$cliente['direccionFiscal']."', ".
							" direccionEntrega = '".$cliente['direccionEntrega']."', ".                            
                            " ubicacion = '".$cliente['ubicacion']."', ".                            
                            " telefono = '".$cliente['telefono']."', ".
                            " celular = '".$cliente['celular']."', ".
                            " email = '".$cliente['email']."', ".
                            " contacto = '".$cliente['contacto']."', ".
                            " paginaWeb = '".$cliente['paginaWeb']."', ".
                            " idPercepcionImpuesto = '".$cliente['idPercepcionImpuesto']."', ".
							" idFormaPago = '".$cliente['idFormaPago']."', ".
                            " idEstado = '".$cliente['idEstado']."', ".                       
                            " idUsuarioModificacion= '".$idUsuario."' ";
                            //" fechaModificacion= '".date("Y-m-d")."' ";
		$sel_query .= " WHERE idCliente = '".$cliente['idCliente']."' ";
	    //echo "ACTUALIZAR:".$sel_query ;
		$result = mysql_query($sel_query);
		return $result;
	}
    
    
    function sqlDeleteCliente($idCliente){
   	    $sel_query  = " DELETE FROM cliente ";
        $sel_query .= " WHERE idCliente = '".$idCliente."' ";
        //echo "ELIMINAR:".$sel_query ;
        $result = mysql_query($sel_query);
		return $result;
    }
    */
    
    /*--------------------------------------------------------------------------------------------------*/
    

    
    /*--------------------------------------------------------------------------------------------------*/
    

		

				
    /*	
	function sqlListaRoles()
   	{
       	$sel_query = " SELECT R.idRol, R.rol, E.estado ";
		$sel_query.= " FROM rol R INNER JOIN estado E ON (R.idEstado=E.idEstado) ";
		$sel_query.= " WHERE E.idEstado = 1 ";
		$sel_query.= " ORDER BY R.rol ";

       	$result = mysql_query($sel_query);
     	return $result;
   	}	
	
	function sqlListaUsuarios($idEmpresa)
   	{
       	$sel_query = " SELECT U.idUsuario, R.rol, U.usuario, E.estado ";
		$sel_query.= " FROM usuario U INNER JOIN rol R ON (U.idRol=R.idRol) INNER JOIN estado E ON(U.idEstado=E.idEstado) ";
		$sel_query.= " WHERE U.idEmpresa = '".$idEmpresa."' ";
		$sel_query.= " ORDER BY R.rol, U.usuario ";

       	$result = mysql_query($sel_query);
     	return $result;
   	}
		
	function sqlInfoUsuario($idEmpresa,$idUsuario)
   	{
		$sel_query = " SELECT idUsuario, usuario, passw, idRol, idEstado ";
		$sel_query.= " FROM usuario ";
		$sel_query.= " WHERE idEmpresa = '".$idEmpresa."' AND idUsuario = $idUsuario ";
		
       	$result = mysql_query($sel_query);
     	return $result;
   	}	
	
	
	function sqlInsertUsuario($idEmpresa,$idUsuario,$idRol,$usuario,$passw,$idEstado)
	{
		$sel_query  = " INSERT INTO usuario (idEmpresa,idRol,usuario,passw,idEstado )";
		$sel_query .= " VALUES ('".$idEmpresa."','".$idRol."','".$usuario."','".$passw."','".$idEstado."')";
					
		$result = mysql_query($sel_query);
		return $result;
	}	
	
	function sqlUpdateUsuario($idEmpresa,$idUsuario,$idRol,$usuario,$passw,$idEstado)
	{
		$sel_query  = " UPDATE usuario ";
		$sel_query .= " SET usuario = '".$usuario."', idRol = '".$idRol."', passw = '".$passw."', ";
		$sel_query .= " idEstado = '".$idEstado."' ";
		$sel_query .= " WHERE idEmpresa = '".$idEmpresa."' AND idUsuario = '".$idUsuario."' ";
					
		$result = mysql_query($sel_query);
		return $result;
	}
	
	function sqlDeleteUsuario($idEmpresa,$idUsuario)
	{
		$sel_query  = " DELETE FROM usuario ";
		$sel_query .= " WHERE idEmpresa = '".$idEmpresa."' AND idUsuario = '".$idUsuario."' ";
					
		$result = mysql_query($sel_query);
		return $result;
	}
	
	function sqlUpdateCambiarPassword($idEmpresa,$idUsuario,$passw)
	{
		$sel_query  = " UPDATE usuario ";
		$sel_query .= " SET passw = '".$passw."' ";
		$sel_query .= " WHERE idEmpresa = '".$idEmpresa."' AND idUsuario = '".$idUsuario."' ";
					
		$result = mysql_query($sel_query);
		return $result;
	}
	
	*/
	
	
	
	
}

?>