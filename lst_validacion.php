<?php 
session_start();
include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
/*	echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

$strMsgErrorAll=array();
$strMsgErrorAll[]="NO se encontraron coincidencias ";
$a_vals=explode("::",trim($_POST['varval']));
$objInclude=array();
$objInclude[1]="i_validacion_light";


include_once("includes/".$objInclude[$_POST['numAdd']].".php");

include_once("addentidad_light3.php");
	//echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";


?>
