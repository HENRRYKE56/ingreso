<?php
include_once("config/cfg.php");    
//if (isset($_SESSION['nomusuario']) && isset($_SESSION['cveperfil']) && isset($_SESSION['passwd'])){
//	if (!empty($_SESSION['nomusuario']) && !empty($_SESSION['cveperfil']) && !empty($_SESSION['passwd'])){
//		if (strlen($_SESSION['nomusuario'])>0 && strlen($_SESSION['cveperfil'])>0 && strlen($_SESSION['passwd'])>0){
	if ($__SESSION->getValueSession('nomusuario')<>"" && $__SESSION->getValueSession('passwd')<>"" && $__SESSION->getValueSession('cveperfil')<>"") {
			$str_check=TRUE;

	}$str_check=TRUE;
//require_once('/lib/FirePHP.class.php');
//ob_start();
//$mifirePHP = FirePHP::getInstance(true);                             
//    $mifirePHP->log($str_check, "Lo que trae en ckeck");         
//		}
//	}
//

?>