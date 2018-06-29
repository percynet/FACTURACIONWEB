<?php session_start();

if($_SESSION["AUTENTICADO"] != "SIP"){
	header("Location: login.php");
	exit();
}
?>