<?php
$fichero_conf = "sistema.properties";
$param_db ['host']= "";
$param_db ['user']= "";
$param_db ['pass']= "";
$param_db ['dbas']= "";
$param_db ['ciempresa']= "";
$param_db ['connection'] = (bool)false;

ini_set('session.gc_maxlifetime', 180);
ini_set('session.cache_expire', 30);

//Abrimos el archivo en modo lectura para obtener las propiedades de la aplicacion
$fp = fopen($fichero_conf,"r");

//Leemos linea por linea el contenido del archivo
while ($linea= fgets($fp,1024)){
		global $param_db; // variable global al proyecto
   	list($prop,$valor) = explode('=',$linea);
    switch ($prop){
    	case 'host':
        	$param_db ['host'] = trim($valor);
	    	break;
       	case 'user':
          	$param_db ['user'] = trim($valor);
       		break;
       	case 'pass':
          	$param_db ['pass'] = trim($valor);
       		break;
       	case 'dbas':
          	$param_db ['dbas'] = trim($valor);
       		break;
       	case 'ciempresa':
          	$param_db ['ciempresa'] = trim($valor);
       		break;			
	}
}
//print_r($param_db);
$_SESSION['paramdb'] = $param_db;
?>