<?php
include_once("../config/cfg.php");
$var_ajax[]="".$path."/includes/evento_color.php";
$var_ajax[]="".$path."/includes/get-events.php";
$var_ajax[]="".$path."/includes/evento_entradas.php";
$var_ajax[]="".$path."/includes/evento_entradas_det.php";
$var_ajax[]="".$path."/includes/evento_pedidos.php";
$var_ajax[]="".$path."/includes/evento_pedidos_det.php";
if (in_array($_SERVER['PHP_SELF'],$var_ajax)  && isset($__SESSION)){
	if ($__SESSION->getValueSession('nomusuario') <> "" && $__SESSION->getValueSession('passwd') <> "" && $__SESSION->getValueSession('cveperfil') <> "") {
				$str_check=TRUE;
	}
}

?>