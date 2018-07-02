-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.28-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema dbfacturacionweb
--

-- CREATE DATABASE IF NOT EXISTS dbfacturacionweb;
-- USE dbfacturacionweb;

--
-- Temporary table structure for view `vw_cargo`
--
DROP TABLE IF EXISTS `vw_cargo`;
DROP VIEW IF EXISTS `vw_cargo`;
CREATE TABLE `vw_cargo` (
  `idEmpresa` smallint(6),
  `idCargo` smallint(6),
  `codigo` varchar(3),
  `cargo` varchar(100),
  `idEstado` smallint(6),
  `estado` varchar(20)
);

--
-- Temporary table structure for view `vw_distrito`
--
DROP TABLE IF EXISTS `vw_distrito`;
DROP VIEW IF EXISTS `vw_distrito`;
CREATE TABLE `vw_distrito` (
  `idDistrito` smallint(6),
  `codigo` varchar(6),
  `distrito` varchar(100),
  `idEstado` smallint(6),
  `estado` varchar(20)
);

--
-- Temporary table structure for view `vw_empresa`
--
DROP TABLE IF EXISTS `vw_empresa`;
DROP VIEW IF EXISTS `vw_empresa`;
CREATE TABLE `vw_empresa` (
  `idEmpresa` smallint(6),
  `codigo` varchar(10),
  `razonSocial` varchar(200),
  `ruc` varchar(11),
  `direccion` varchar(200),
  `telefonoFijo` varchar(15),
  `telefonoCelular` varchar(15),
  `email` varchar(100),
  `titulo` varchar(200),
  `descripcion` blob,
  `rutaLogo` varchar(200),
  `idEstado` smallint(6),
  `estado` varchar(20)
);

--
-- Temporary table structure for view `vw_estado`
--
DROP TABLE IF EXISTS `vw_estado`;
DROP VIEW IF EXISTS `vw_estado`;
CREATE TABLE `vw_estado` (
  `idTipoEstado` smallint(6),
  `tipoEstado` varchar(20),
  `idEstado` smallint(6),
  `estado` varchar(20)
);

--
-- Temporary table structure for view `vw_usuario`
--
DROP TABLE IF EXISTS `vw_usuario`;
DROP VIEW IF EXISTS `vw_usuario`;
CREATE TABLE `vw_usuario` (
  `idEmpresa` smallint(6),
  `idUsuario` smallint(6),
  `usuario` varchar(100),
  `passwd` varchar(100),
  `idRol` smallint(6),
  `rol` varchar(50),
  `idEmpleado` smallint(6),
  `codigoEmpleado` varchar(6),
  `nombres` varchar(100),
  `apellidoPaterno` varchar(100),
  `apellidoMaterno` varchar(100),
  `nombresApellidos` varchar(302),
  `estado` varchar(20)
);

--
-- Definition of table `acceso_rol_modulo`
--

DROP TABLE IF EXISTS `acceso_rol_modulo`;
CREATE TABLE `acceso_rol_modulo` (
  `idAcceso` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idRol` smallint(6) NOT NULL,
  `modMantenimientos` smallint(6) NOT NULL DEFAULT '0',
  `modVentas` smallint(6) NOT NULL DEFAULT '0',
  `modProcesos` smallint(6) NOT NULL DEFAULT '0',
  `modReportes` smallint(6) NOT NULL DEFAULT '0',
  `modSeguridad` smallint(6) NOT NULL DEFAULT '0',
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `idUsuarioModificacion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idAcceso`,`idEmpresa`,`idRol`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acceso_rol_modulo`
--

/*!40000 ALTER TABLE `acceso_rol_modulo` DISABLE KEYS */;
INSERT INTO `acceso_rol_modulo` (`idAcceso`,`idEmpresa`,`idRol`,`modMantenimientos`,`modVentas`,`modProcesos`,`modReportes`,`modSeguridad`,`fechaCreacion`,`idUsuarioCreacion`,`fechaModificacion`,`idUsuarioModificacion`,`idEstado`) VALUES 
 (1,1,1,1,1,1,1,1,'2015-09-01 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `acceso_rol_modulo` ENABLE KEYS */;


--
-- Definition of table `cabecera_factura_boleta`
--

DROP TABLE IF EXISTS `cabecera_factura_boleta`;
CREATE TABLE `cabecera_factura_boleta` (
  `idCabeceraFB` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idComprobantePago` smallint(6) NOT NULL,
  `serieFB` varchar(4) DEFAULT NULL,
  `numeroFB` varchar(6) DEFAULT NULL,
  `fechaEmision` date DEFAULT NULL,
  `idCliente` smallint(6) DEFAULT NULL,
  `codigoCliente` varchar(15) DEFAULT NULL,
  `idDireccionCliente` smallint(6) DEFAULT NULL,
  `direccionCliente` varchar(200) DEFAULT NULL,
  `idDocumentoIdentidad` smallint(6) DEFAULT NULL,
  `documentoIdentidad` varchar(50) DEFAULT NULL,
  `numeroDocumentoIdentidad` varchar(11) DEFAULT NULL,
  `idCabeceraGRef` smallint(6) DEFAULT NULL,
  `serieGRef` varchar(4) DEFAULT NULL,
  `numeroGRef` varchar(8) DEFAULT NULL,
  `idMoneda` smallint(6) DEFAULT NULL,
  `moneda` varchar(15) DEFAULT NULL,
  `opcionDescuento` smallint(6) DEFAULT NULL,
  `idTipoDescuento` smallint(6) DEFAULT NULL,
  `tipoDescuento` varchar(50) DEFAULT NULL,
  `porcentajeDescuento` decimal(12,2) DEFAULT NULL,
  `importeBase` decimal(12,2) DEFAULT NULL,
  `importeDescuento` decimal(12,2) DEFAULT NULL,
  `porcentajeIGV` decimal(12,2) DEFAULT NULL,
  `importeIGV` decimal(12,2) DEFAULT NULL,
  `importeTotal` decimal(12,2) DEFAULT NULL,
  `idFormaPago` smallint(6) DEFAULT NULL,
  `formaPago` varchar(50) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idCabeceraFB`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cabecera_factura_boleta`
--

/*!40000 ALTER TABLE `cabecera_factura_boleta` DISABLE KEYS */;
/*!40000 ALTER TABLE `cabecera_factura_boleta` ENABLE KEYS */;


--
-- Definition of table `cabecera_guia_remision`
--

DROP TABLE IF EXISTS `cabecera_guia_remision`;
CREATE TABLE `cabecera_guia_remision` (
  `idCabeceraGR` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `serieGR` varchar(4) DEFAULT NULL,
  `numeroGR` varchar(6) DEFAULT NULL,
  `fechaEmision` date DEFAULT NULL,
  `fechaTraslado` date DEFAULT NULL,
  `idClienteRemitente` smallint(6) DEFAULT NULL,
  `clienteRemitente` varchar(200) DEFAULT NULL,
  `idDireccionPartida` smallint(6) DEFAULT NULL,
  `idClienteDestinatario` smallint(6) DEFAULT NULL,
  `clienteDestinatario` varchar(200) DEFAULT NULL,
  `idDireccionLlegada` smallint(6) DEFAULT NULL,
  `observaciones` blob,
  `idTipoTraslado` smallint(6) DEFAULT NULL,
  `tipoTraslado` varchar(50) DEFAULT NULL,
  `idCabeceraFB` smallint(6) DEFAULT NULL,
  `serieFB` varchar(4) DEFAULT NULL,
  `numeroFB` varchar(6) DEFAULT NULL,
  `idTransportista` smallint(6) DEFAULT NULL,
  `codigoTransportista` varchar(10) DEFAULT NULL,
  `idVehiculo` smallint(6) DEFAULT NULL,
  `codigoVehiculo` varchar(10) DEFAULT NULL,
  `idMarcaVehiculo` smallint(6) DEFAULT NULL,
  `marcaVehiculo` varchar(50) DEFAULT NULL,
  `placaTracto` varchar(10) DEFAULT NULL,
  `placaRemolque` varchar(10) DEFAULT NULL,
  `configuracionVehicular` varchar(50) DEFAULT NULL,
  `certificadoInscripcion` varchar(50) DEFAULT NULL,
  `idChofer` smallint(6) DEFAULT NULL,
  `codigoChofer` varchar(10) DEFAULT NULL,
  `chofer` varchar(50) DEFAULT NULL,
  `licenciaConducirChofer` varchar(50) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idCabeceraGR`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='										';

--
-- Dumping data for table `cabecera_guia_remision`
--

/*!40000 ALTER TABLE `cabecera_guia_remision` DISABLE KEYS */;
/*!40000 ALTER TABLE `cabecera_guia_remision` ENABLE KEYS */;


--
-- Definition of table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `idCargo` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `codigo` varchar(3) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `idUsuarioModificacion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`idCargo`,`idEmpresa`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo`
--

/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` (`idCargo`,`idEmpresa`,`codigo`,`cargo`,`fechaCreacion`,`idUsuarioCreacion`,`fechaModificacion`,`idUsuarioModificacion`,`idEstado`) VALUES 
 (3,1,'ADM','ADMINISTRADOR','2015-06-09 00:00:00',1,'2015-06-09 00:00:00',1,1),
 (4,1,'GTE','GERENTE','2015-06-10 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;


--
-- Definition of table `chofer`
--

DROP TABLE IF EXISTS `chofer`;
CREATE TABLE `chofer` (
  `idChofer` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) DEFAULT NULL,
  `idTransportista` smallint(6) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `licencia` varchar(100) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idChofer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='				';

--
-- Dumping data for table `chofer`
--

/*!40000 ALTER TABLE `chofer` DISABLE KEYS */;
/*!40000 ALTER TABLE `chofer` ENABLE KEYS */;


--
-- Definition of table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `idCliente` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idDocumentoIdentidad` smallint(6) NOT NULL,
  `numeroDocumentoIdentidad` varchar(15) NOT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `cliente` varchar(200) NOT NULL,
  `idDireccionActual` smallint(6) DEFAULT NULL,
  `idDireccionPartida` smallint(6) DEFAULT NULL,
  `idDireccionLlegada` smallint(6) DEFAULT NULL,
  `telefonoFijo` varchar(15) DEFAULT NULL,
  `telefonoCelular` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `representanteLegal` varchar(200) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cliente`
--

/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;


--
-- Definition of table `comprobante_pago`
--

DROP TABLE IF EXISTS `comprobante_pago`;
CREATE TABLE `comprobante_pago` (
  `idComprobantePago` smallint(6) NOT NULL AUTO_INCREMENT,
  `idTipoOperacion` smallint(6) NOT NULL,
  `codigo` varchar(3) DEFAULT NULL,
  `comprobantePago` varchar(100) DEFAULT NULL,
  `serie` smallint(6) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` datetime DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`idComprobantePago`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comprobante_pago`
--

/*!40000 ALTER TABLE `comprobante_pago` DISABLE KEYS */;
INSERT INTO `comprobante_pago` (`idComprobantePago`,`idTipoOperacion`,`codigo`,`comprobantePago`,`serie`,`numero`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,1,'01','FACTURA',1,0,'2018-06-25 00:00:00',1,NULL,NULL,1),
 (2,1,'03','BOLETA',1,0,'2018-06-25 00:00:00',1,NULL,NULL,1),
 (3,1,'07','NOTA DE CREDITO',1,0,'2018-06-25 00:00:00',1,NULL,NULL,1),
 (4,1,'08','NOTA DE DEBITO',1,0,'2018-06-25 00:00:00',1,NULL,NULL,1),
 (5,1,'09','GUIA DE REMISION',1,0,'2018-06-25 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `comprobante_pago` ENABLE KEYS */;


--
-- Definition of table `detalle_factura_boleta`
--

DROP TABLE IF EXISTS `detalle_factura_boleta`;
CREATE TABLE `detalle_factura_boleta` (
  `idDetalleFB` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idCabeceraFB` int(11) NOT NULL,
  `item` smallint(6) DEFAULT NULL,
  `idProducto` smallint(6) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `producto` varchar(200) DEFAULT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `precioUnitario` decimal(12,2) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idDetalleFB`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalle_factura_boleta`
--

/*!40000 ALTER TABLE `detalle_factura_boleta` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_factura_boleta` ENABLE KEYS */;


--
-- Definition of table `detalle_guia_remision`
--

DROP TABLE IF EXISTS `detalle_guia_remision`;
CREATE TABLE `detalle_guia_remision` (
  `idDetalleGR` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idCabeceraGR` smallint(6) NOT NULL,
  `serieGR` varchar(4) DEFAULT NULL,
  `numeroGR` varchar(6) DEFAULT NULL,
  `item` smallint(6) DEFAULT NULL,
  `idProducto` smallint(6) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `producto` varchar(50) DEFAULT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `peso` decimal(12,2) DEFAULT NULL,
  `idUnidadMedida` smallint(6) DEFAULT NULL,
  `unidadMedida` varchar(50) DEFAULT NULL,
  `contraCosto` varchar(50) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idDetalleGR`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalle_guia_remision`
--

/*!40000 ALTER TABLE `detalle_guia_remision` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_guia_remision` ENABLE KEYS */;


--
-- Definition of table `direccion_lugar`
--

DROP TABLE IF EXISTS `direccion_lugar`;
CREATE TABLE `direccion_lugar` (
  `idDireccion` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idTipoDireccion` smallint(6) NOT NULL,
  `idTipoVia` smallint(6) NOT NULL,
  `nombreVia` varchar(200) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `interior` varchar(50) DEFAULT NULL,
  `zona` varchar(200) DEFAULT NULL,
  `idDistrito` smallint(6) DEFAULT NULL,
  `idDepartamento` smallint(6) DEFAULT NULL,
  `idProvincia` smallint(6) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idDireccion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `direccion_lugar`
--

/*!40000 ALTER TABLE `direccion_lugar` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion_lugar` ENABLE KEYS */;


--
-- Definition of table `distrito`
--

DROP TABLE IF EXISTS `distrito`;
CREATE TABLE `distrito` (
  `idDistrito` smallint(6) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(6) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `idUsuarioModificacion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idDistrito`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distrito`
--

/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
INSERT INTO `distrito` (`idDistrito`,`codigo`,`distrito`,`fechaCreacion`,`idUsuarioCreacion`,`fechaModificacion`,`idUsuarioModificacion`,`idEstado`) VALUES 
 (1,'01','LIMA','2015-06-09 00:00:00',1,'2015-06-09 00:00:00',1,1),
 (2,'02','ANCON','2015-06-10 00:00:00',1,NULL,NULL,1),
 (3,'03','ATE','2015-06-10 00:00:00',1,NULL,NULL,1),
 (4,'04','BREÃ‘A','2015-06-10 00:00:00',1,NULL,NULL,1),
 (5,'05','CARABAYLLO','2015-06-10 00:00:00',1,NULL,NULL,1),
 (6,'06','COMAS','2015-06-10 00:00:00',1,NULL,NULL,1),
 (7,'07','CHACLACAYO','2015-06-10 00:00:00',1,NULL,NULL,1),
 (8,'08','CHORRILLOS','2015-06-10 00:00:00',1,NULL,NULL,1),
 (9,'09','LA VICTORIA','2015-06-10 00:00:00',1,'2015-06-10 00:00:00',1,1),
 (10,'10','LA MOLINA','2015-06-10 00:00:00',1,'2015-06-10 00:00:00',1,1),
 (11,'11','LINCE','2015-06-10 00:00:00',1,NULL,NULL,1),
 (12,'12','LURIGANCHO','2015-06-10 00:00:00',1,NULL,NULL,1),
 (13,'13','LURIN','2015-06-10 00:00:00',1,NULL,NULL,1),
 (14,'14','MAGDALENA DEL MAR','2015-06-10 00:00:00',1,NULL,NULL,1),
 (15,'15','MIRAFLORES','2015-06-10 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `distrito` ENABLE KEYS */;


--
-- Definition of table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `idEmpleado` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idCargo` smallint(6) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidoPaterno` varchar(100) DEFAULT NULL,
  `apellidoMaterno` varchar(100) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `idDepartamento` smallint(6) DEFAULT NULL,
  `idProvincia` smallint(6) DEFAULT NULL,
  `idDistrito` smallint(6) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `idSexo` smallint(6) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `idUsuarioModificacion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idEmpleado`,`idEmpresa`,`idCargo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empleado`
--

/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` (`idEmpleado`,`idEmpresa`,`idCargo`,`codigo`,`nombres`,`apellidoPaterno`,`apellidoMaterno`,`dni`,`idDepartamento`,`idProvincia`,`idDistrito`,`direccion`,`idSexo`,`telefono`,`fechaNacimiento`,`fechaIngreso`,`fechaCreacion`,`idUsuarioCreacion`,`fechaModificacion`,`idUsuarioModificacion`,`idEstado`) VALUES 
 (1,1,1,'01','ADMIN',NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,'2015-06-01 00:00:00',1,NULL,NULL,1),
 (2,1,4,'02','RAUL','VASQUEZ','A','12045220',NULL,NULL,1,NULL,1,NULL,NULL,'2015-07-01','2015-08-01 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;


--
-- Definition of table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `idEmpresa` smallint(6) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `ruc` varchar(11) NOT NULL,
  `razonSocial` varchar(200) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefonoFijo` varchar(15) DEFAULT NULL,
  `telefonoCelular` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descripcion` blob,
  `rutaLogo` varchar(200) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idEmpresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empresa`
--

/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`idEmpresa`,`codigo`,`ruc`,`razonSocial`,`direccion`,`telefonoFijo`,`telefonoCelular`,`fax`,`email`,`titulo`,`descripcion`,`rutaLogo`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,'EMP001','20307248957','TRANSPORTES VIRGEN DE LAS PEÑAS S.R.L.','Av. San Bernardo Nro 170 Urb. Santa Luisa','5369970',NULL,NULL,NULL,NULL,NULL,NULL,'2018-06-18',1,NULL,NULL,1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;


--
-- Definition of table `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `idEstado` smallint(6) NOT NULL AUTO_INCREMENT,
  `idTipoEstado` smallint(6) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estado`
--

/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`idEstado`,`idTipoEstado`,`estado`) VALUES 
 (1,1,'ACTIVO'),
 (2,1,'INACTIVO');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;


--
-- Definition of table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `idModulo` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `codigo` varchar(3) DEFAULT NULL,
  `modulo` varchar(20) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `idUsuarioModificacion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`idModulo`,`idEmpresa`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modulo`
--

/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` (`idModulo`,`idEmpresa`,`codigo`,`modulo`,`fechaCreacion`,`idUsuarioCreacion`,`fechaModificacion`,`idUsuarioModificacion`,`idEstado`) VALUES 
 (1,1,'MAN','MANTENIMIENTOS','2015-09-01 00:00:00',1,NULL,NULL,1),
 (2,1,'ALM','ALMACEN','2015-09-01 00:00:00',1,NULL,NULL,1),
 (3,1,'COM','COMPRAS','2015-09-01 00:00:00',1,NULL,NULL,1),
 (4,1,'VEN','VENTAS','2015-09-01 00:00:00',1,NULL,NULL,1),
 (5,1,'CJA','CAJAS','2015-09-01 00:00:00',1,NULL,NULL,1),
 (6,1,'PRO','PROCESOS','2015-09-01 00:00:00',1,NULL,NULL,1),
 (7,1,'REP','REPORTES','2015-09-01 00:00:00',1,NULL,NULL,1),
 (8,1,'SEG','SEGURIDAD','2015-09-01 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;


--
-- Definition of table `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `idProducto` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `descripcion` blob,
  `costo` varchar(45) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaModificacion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `producto`
--

/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;


--
-- Definition of table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `idRol` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='																	q';

--
-- Dumping data for table `rol`
--

/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` (`idRol`,`idEmpresa`,`rol`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,1,'ADMINISTRADOR','2018-06-18',1,NULL,NULL,1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;


--
-- Definition of table `tabla`
--

DROP TABLE IF EXISTS `tabla`;
CREATE TABLE `tabla` (
  `idTabla` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idTipoTabla` smallint(6) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `referencia1` varchar(200) DEFAULT NULL,
  `referencia2` varchar(200) DEFAULT NULL,
  `referencia3` varchar(200) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idTabla`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabla`
--

/*!40000 ALTER TABLE `tabla` DISABLE KEYS */;
INSERT INTO `tabla` (`idTabla`,`idEmpresa`,`idTipoTabla`,`codigo`,`descripcion`,`referencia1`,`referencia2`,`referencia3`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,1,1,'01','DOCUMENTO NACIONAL DE IDENTIDAD (DNI)',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (2,1,1,'04','CARNET DE EXTRANJERIA','',NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (3,1,1,'06','REGISTRO ÚNICO DE CONTRIBUYENTES',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (4,1,1,'07','PASAPORTE',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (9,1,3,'02','JIRÓN',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (5,1,1,'00','OTROS TIPOS DE DOCUMENTOS',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (6,1,2,'1','NUEVOS SOLES',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (7,1,2,'2','DÓLARES AMERICANOS',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (8,1,3,'01','AVENIDA',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (10,1,3,'03','CALLE',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (11,1,3,'04','PASAJE',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (12,1,3,'05','ALAMEDA',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (13,1,3,'06','MALECÓN',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (14,1,3,'07','OVALO',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (15,1,3,'08','PARQUE',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (16,1,3,'09','PLAZA',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (17,1,3,'10','CARRETERA',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1),
 (18,1,3,'11','BLOCK',NULL,NULL,NULL,'2018-06-25',1,NULL,NULL,1);
/*!40000 ALTER TABLE `tabla` ENABLE KEYS */;


--
-- Definition of table `tipo_estado`
--

DROP TABLE IF EXISTS `tipo_estado`;
CREATE TABLE `tipo_estado` (
  `IdTipoEstado` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoEstado` varchar(20) NOT NULL,
  PRIMARY KEY (`IdTipoEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_estado`
--

/*!40000 ALTER TABLE `tipo_estado` DISABLE KEYS */;
INSERT INTO `tipo_estado` (`IdTipoEstado`,`tipoEstado`) VALUES 
 (1,'MANTENIMIENTO'),
 (2,'PROCESO');
/*!40000 ALTER TABLE `tipo_estado` ENABLE KEYS */;


--
-- Definition of table `tipo_operacion`
--

DROP TABLE IF EXISTS `tipo_operacion`;
CREATE TABLE `tipo_operacion` (
  `idTipoOperacion` smallint(6) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(3) CHARACTER SET latin1 DEFAULT NULL,
  `tipoOperacion` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` datetime DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`idTipoOperacion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_operacion`
--

/*!40000 ALTER TABLE `tipo_operacion` DISABLE KEYS */;
INSERT INTO `tipo_operacion` (`idTipoOperacion`,`codigo`,`tipoOperacion`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,'01','Ventas','2018-06-25 00:00:00',1,NULL,NULL,1),
 (2,'02','Compras','2018-06-25 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `tipo_operacion` ENABLE KEYS */;


--
-- Definition of table `tipo_tabla`
--

DROP TABLE IF EXISTS `tipo_tabla`;
CREATE TABLE `tipo_tabla` (
  `idTipoTabla` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) DEFAULT NULL,
  `tipoTabla` varchar(100) NOT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idTipoTabla`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_tabla`
--

/*!40000 ALTER TABLE `tipo_tabla` DISABLE KEYS */;
INSERT INTO `tipo_tabla` (`idTipoTabla`,`idEmpresa`,`tipoTabla`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,1,'documento_identidad','2018-06-25',1,NULL,NULL,1),
 (2,1,'moneda','2018-06-25',1,NULL,NULL,1),
 (3,1,'tipo_via','2018-06-25',1,NULL,NULL,1),
 (4,1,'marca_vehiculo','2018-06-25',1,NULL,NULL,1),
 (5,1,'tipo_descuento','2018-06-25',1,NULL,NULL,1),
 (6,1,'tipo_traslado','2018-06-25',1,NULL,NULL,1),
 (7,1,'motivo_nota','2018-06-25',1,NULL,NULL,1),
 (8,1,'configuracion','2018-06-25',1,NULL,NULL,1),
 (9,1,'forma_pago','2018-06-25',1,NULL,NULL,1),
 (14,1,'percepcion','2018-06-25',1,NULL,NULL,1),
 (10,1,'unidad_medida','2018-06-25',1,NULL,NULL,1),
 (11,1,'tipo_operacion','2018-06-25',1,NULL,NULL,1),
 (12,1,'tipo_descuento','2018-06-25',1,NULL,NULL,1),
 (13,1,'igv','2018-06-25',1,NULL,NULL,1);
/*!40000 ALTER TABLE `tipo_tabla` ENABLE KEYS */;


--
-- Definition of table `transportista`
--

DROP TABLE IF EXISTS `transportista`;
CREATE TABLE `transportista` (
  `idTransportista` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `razonSocial` varchar(200) DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `idUsuarioCreacion` smallint(6) DEFAULT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idTransportista`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transportista`
--

/*!40000 ALTER TABLE `transportista` DISABLE KEYS */;
/*!40000 ALTER TABLE `transportista` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `idUsuario` smallint(6) NOT NULL AUTO_INCREMENT,
  `idEmpresa` smallint(6) NOT NULL,
  `idEmpleado` smallint(6) NOT NULL,
  `idRol` smallint(6) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` datetime DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idUsuario`,`idEmpleado`,`idEmpresa`,`idRol`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idUsuario`,`idEmpresa`,`idEmpleado`,`idRol`,`usuario`,`passwd`,`fechaCreacion`,`idUsuarioCreacion`,`fechaEdicion`,`idUsuarioEdicion`,`idEstado`) VALUES 
 (1,1,1,1,'ADMIN','ADMIN','2018-06-20 00:00:00',1,NULL,NULL,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;


--
-- Definition of table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE `vehiculo` (
  `idVehiculo` smallint(6) NOT NULL,
  `idEmpresa` smallint(6) NOT NULL,
  `idTransportista` smallint(6) NOT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `idMarcaVehiculo` smallint(6) DEFAULT NULL,
  `placaTracto` varchar(10) DEFAULT NULL,
  `placaRemolque` varchar(10) DEFAULT NULL,
  `configuracionVehicular` varchar(45) DEFAULT NULL,
  `certificadoInscripcion` varchar(45) DEFAULT NULL,
  `anioFabricacion` varchar(10) DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `idUsuarioCreacion` smallint(6) NOT NULL,
  `fechaEdicion` date DEFAULT NULL,
  `idUsuarioEdicion` smallint(6) DEFAULT NULL,
  `idEstado` smallint(6) NOT NULL,
  PRIMARY KEY (`idVehiculo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='																																																																																				';

--
-- Dumping data for table `vehiculo`
--

/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;


--
-- Definition of function `fn_addzero`
--

DROP FUNCTION IF EXISTS `fn_addzero`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` FUNCTION `fn_addzero`(v_semilla BIGINT, v_longitud INT) RETURNS char(10) CHARSET utf8
BEGIN

  DECLARE sCad   CHAR(10);
  DECLARE nCad   BIGINT;
  DECLARE iCount BIGINT;
  

  SET sCad = CAST(v_semilla AS CHAR(10));
  SET nCad = LENGTH(sCad);
  SET iCount = 1;

  WHILE iCount <= v_longitud - nCad
  DO
    SET sCad = CONCAT('0', sCad);

    SET iCount = iCount + 1;
  END WHILE;

  RETURN sCad;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_delete_cargo`
--

DROP PROCEDURE IF EXISTS `sp_delete_cargo`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_delete_cargo`(
  IN v_idEmpresa SMALLINT,
  IN v_idCargo SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;

    DELETE FROM cargo
    WHERE  idEmpresa = v_idEmpresa AND idCargo = v_idCargo;

    SET p_result = 1;

    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_delete_departamento`
--

DROP PROCEDURE IF EXISTS `sp_delete_departamento`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_delete_departamento`(
  IN v_idEmpresa SMALLINT,
  IN v_idDepartamento SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;

    DELETE FROM departamento
    WHERE  idEmpresa = v_idEmpresa AND idDepartamento = v_idDepartamento;

    SET p_result = 1;

    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_delete_distrito`
--

DROP PROCEDURE IF EXISTS `sp_delete_distrito`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_delete_distrito`(
  IN v_idEmpresa SMALLINT,
  IN v_idDistrito SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;

    DELETE FROM distrito
    WHERE  idEmpresa = v_idEmpresa AND idDistrito = v_idDistrito;

    SET p_result = 1;

    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_delete_empleado`
--

DROP PROCEDURE IF EXISTS `sp_delete_empleado`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_delete_empleado`(
  IN v_idEmpresa SMALLINT,
  IN v_idEmpleado SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;

    DELETE FROM empleado
    WHERE  idEmpresa = v_idEmpresa AND idEmpleado = v_idEmpleado;

    SET p_result = 1;

    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_insert_cargo`
--

DROP PROCEDURE IF EXISTS `sp_insert_cargo`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_insert_cargo`(
  IN v_idEmpresa SMALLINT,
  IN v_codigo VARCHAR(3),
  IN v_cargo VARCHAR(100),
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;
    DECLARE p_idCargo SMALLINT DEFAULT 0;
    DECLARE p_fechaCreacion DATE;
    DECLARE p_idUsuarioCreacion SMALLINT;
    DECLARE p_idEstado SMALLINT;
    DECLARE p_estado_activo VARCHAR(10) DEFAULT 'ACTIVO ';

    SET p_fechaCreacion = DATE_FORMAT(CURDATE(), '%Y-%m-%d');
    SET p_idUsuarioCreacion = v_idUsuario;

    SELECT idEstado INTO p_idEstado
    FROM   estado
    WHERE  estado = p_estado_activo;

    IF EXISTS(SELECT * FROM cargo WHERE cargo = v_cargo AND codigo = v_codigo ) THEN

      SET p_result = 2;

    ELSE
      BEGIN

        INSERT INTO cargo (idEmpresa, codigo, cargo, fechaCreacion, idUsuarioCreacion, fechaModificacion, idUsuarioModificacion, idEstado)
        VALUES(v_idEmpresa, v_codigo, v_cargo, p_fechaCreacion, p_idUsuarioCreacion, null, null, p_idEstado);

        SET p_result = 1;

      END;
    END IF;


    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_insert_distrito`
--

DROP PROCEDURE IF EXISTS `sp_insert_distrito`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_insert_distrito`(
  IN v_codigo VARCHAR(10),
  IN v_distrito VARCHAR(100),
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;
    DECLARE p_idDistrito SMALLINT DEFAULT 0;
    DECLARE p_fechaCreacion DATE;
    DECLARE p_idUsuarioCreacion SMALLINT;
    DECLARE p_idEstado SMALLINT;
    DECLARE p_estado_activo VARCHAR(10) DEFAULT 'ACTIVO ';

    SET p_fechaCreacion = DATE_FORMAT(CURDATE(), '%Y-%m-%d');
    SET p_idUsuarioCreacion = v_idUsuario;

    SELECT idEstado INTO p_idEstado
    FROM   estado
    WHERE  estado = p_estado_activo;

    IF EXISTS(SELECT * FROM distrito WHERE distrito = v_distrito AND codigo = v_codigo ) THEN

      SET p_result = 2;

    ELSE
      BEGIN

        INSERT INTO distrito (codigo, distrito, fechaCreacion, idUsuarioCreacion, fechaModificacion, idUsuarioModificacion, idEstado)
        VALUES(v_codigo, v_distrito, p_fechaCreacion, p_idUsuarioCreacion, null, null, p_idEstado);

        SET p_result = 1;

      END;
    END IF;


    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_update_cargo`
--

DROP PROCEDURE IF EXISTS `sp_update_cargo`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_update_cargo`(
  IN v_idEmpresa SMALLINT,
  IN v_idCargo SMALLINT,
  IN v_codigo VARCHAR(10),
  IN v_cargo VARCHAR(100),
  IN v_idEstado SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;
    DECLARE p_fechaModificacion DATE;
    DECLARE p_idUsuarioModificacion SMALLINT;

    SET p_fechaModificacion = DATE_FORMAT(CURDATE(), '%Y-%m-%d');
    SET p_idUsuarioModificacion = v_idUsuario;

    IF EXISTS(SELECT * FROM cargo WHERE codigo = v_codigo AND cargo = v_cargo AND idCargo  <> v_idCargo ) THEN

      SET p_result = 2;

    ELSE
      BEGIN

        UPDATE cargo
        SET    codigo = v_codigo, cargo = v_cargo, fechaModificacion = p_fechaModificacion,
               idUsuarioModificacion = p_idUsuarioModificacion, idEstado = v_idEstado
        WHERE  idEmpresa = v_idEmpresa AND idCargo = v_idCargo;

        SET p_result = 1;

      END;
    END IF;


    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sp_update_distrito`
--

DROP PROCEDURE IF EXISTS `sp_update_distrito`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`easolutioncenter`@`localhost` PROCEDURE `sp_update_distrito`(
  IN v_idDistrito SMALLINT,
  IN v_codigo VARCHAR(10),
  IN v_distrito VARCHAR(100),
  IN v_idEstado SMALLINT,
  IN v_idUsuario SMALLINT
)
BEGIN
    DECLARE p_result SMALLINT DEFAULT 0;
    DECLARE p_fechaModificacion DATE;
    DECLARE p_idUsuarioModificacion SMALLINT;

    SET p_fechaModificacion = DATE_FORMAT(CURDATE(), '%Y-%m-%d');
    SET p_idUsuarioModificacion = v_idUsuario;

    IF EXISTS(SELECT * FROM distrito WHERE codigo = v_codigo AND distrito = v_distrito AND idDistrito  <> v_idDistrito ) THEN

      SET p_result = 2;

    ELSE
      BEGIN

        UPDATE distrito
        SET    codigo = v_codigo, distrito = v_distrito, fechaModificacion = p_fechaModificacion,
               idUsuarioModificacion = p_idUsuarioModificacion, idEstado = v_idEstado
        WHERE  idDistrito = v_idDistrito;

        SET p_result = 1;

      END;
    END IF;


    SELECT p_result;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of view `vw_cargo`
--

DROP TABLE IF EXISTS `vw_cargo`;
DROP VIEW IF EXISTS `vw_cargo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`easolutioncenter`@`localhost` SQL SECURITY DEFINER VIEW `vw_cargo` AS select `cg`.`idEmpresa` AS `idEmpresa`,`cg`.`idCargo` AS `idCargo`,`cg`.`codigo` AS `codigo`,`cg`.`cargo` AS `cargo`,`cg`.`idEstado` AS `idEstado`,`es`.`estado` AS `estado` from (`cargo` `cg` join `estado` `es` on((`cg`.`idEstado` = `es`.`idEstado`)));

--
-- Definition of view `vw_distrito`
--

DROP TABLE IF EXISTS `vw_distrito`;
DROP VIEW IF EXISTS `vw_distrito`;
CREATE ALGORITHM=UNDEFINED DEFINER=`easolutioncenter`@`localhost` SQL SECURITY DEFINER VIEW `vw_distrito` AS select `ds`.`idDistrito` AS `idDistrito`,`ds`.`codigo` AS `codigo`,`ds`.`distrito` AS `distrito`,`ds`.`idEstado` AS `idEstado`,`es`.`estado` AS `estado` from (`distrito` `ds` join `estado` `es` on((`ds`.`idEstado` = `es`.`idEstado`)));

--
-- Definition of view `vw_empresa`
--

DROP TABLE IF EXISTS `vw_empresa`;
DROP VIEW IF EXISTS `vw_empresa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`easolutioncenter`@`localhost` SQL SECURITY DEFINER VIEW `vw_empresa` AS select `em`.`idEmpresa` AS `idEmpresa`,`em`.`codigo` AS `codigo`,`em`.`razonSocial` AS `razonSocial`,`em`.`ruc` AS `ruc`,`em`.`direccion` AS `direccion`,`em`.`telefonoFijo` AS `telefonoFijo`,`em`.`telefonoCelular` AS `telefonoCelular`,`em`.`email` AS `email`,`em`.`titulo` AS `titulo`,`em`.`descripcion` AS `descripcion`,`em`.`rutaLogo` AS `rutaLogo`,`em`.`idEstado` AS `idEstado`,`es`.`estado` AS `estado` from (`estado` `es` join `empresa` `em` on((`es`.`idEstado` = `em`.`idEstado`)));

--
-- Definition of view `vw_estado`
--

DROP TABLE IF EXISTS `vw_estado`;
DROP VIEW IF EXISTS `vw_estado`;
CREATE ALGORITHM=UNDEFINED DEFINER=`easolutioncenter`@`localhost` SQL SECURITY DEFINER VIEW `vw_estado` AS select `te`.`IdTipoEstado` AS `idTipoEstado`,`te`.`tipoEstado` AS `tipoEstado`,`es`.`idEstado` AS `idEstado`,`es`.`estado` AS `estado` from (`estado` `es` join `tipo_estado` `te` on((`es`.`idTipoEstado` = `te`.`IdTipoEstado`)));

--
-- Definition of view `vw_usuario`
--

DROP TABLE IF EXISTS `vw_usuario`;
DROP VIEW IF EXISTS `vw_usuario`;
CREATE ALGORITHM=UNDEFINED DEFINER=`easolutioncenter`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuario` AS select `usr`.`idEmpresa` AS `idEmpresa`,`usr`.`idUsuario` AS `idUsuario`,`usr`.`usuario` AS `usuario`,`usr`.`passwd` AS `passwd`,`usr`.`idRol` AS `idRol`,`rol`.`rol` AS `rol`,`usr`.`idEmpleado` AS `idEmpleado`,`edo`.`codigo` AS `codigoEmpleado`,`edo`.`nombres` AS `nombres`,`edo`.`apellidoPaterno` AS `apellidoPaterno`,`edo`.`apellidoMaterno` AS `apellidoMaterno`,concat(`edo`.`nombres`,_utf8' ',`edo`.`apellidoPaterno`,_utf8' ',`edo`.`apellidoMaterno`) AS `nombresApellidos`,`es`.`estado` AS `estado` from (((`rol` join `usuario` `usr` on((`rol`.`idRol` = `usr`.`idRol`))) join `empleado` `edo` on((`edo`.`idEmpleado` = `usr`.`idEmpleado`))) join `estado` `es` on((`es`.`idEstado` = `usr`.`idEstado`)));



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
