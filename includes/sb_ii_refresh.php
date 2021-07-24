<?php
	echo "<body topmargin=\"0\" leftmargin=\"0\">";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/estilo.css\" />";
	$str_msg_red='ERROR ( PAGINA NO DISPONIBLE )';
	include_once("sb_msg_red.php");
	$str_refresh="../login.php";
	echo "<meta http-equiv='refresh' content='0;URL=".$str_refresh."'>";
	echo "</body>";
?>