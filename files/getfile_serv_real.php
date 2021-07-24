<?php 
session_start(); 
if (isset($_SESSION['cveperfil']) && isset($_SESSION['mod'])){
	include_once("../config/cfg.php");
	include_once("../lib/lib_pgsql.php");
	include_once("../lib/lib_entidad.php");
	include_once("../rep/lib/lib32.php");
	$field[]=array('cve_perfil','perfil_modulo','0',0);
	$field[]=array('cve_modulo','perfil_modulo','1',"");
	$field[]=array('key_modulo','perfil_modulo','1',"");
	$allf=array();
	$allv=array();
	$tabla='perfil_modulo,modulo';
	$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
	$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
	$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
	$strWhere.=" and modulo.sta_modulo<>0";
	$classval = new Entidad($allf,$allv);
	$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
	$str_valmodulo="MOD_NOVALIDO";
	if ($classval->NumReg>0){
		if (isset($_GET['cve_serv_real'])){
			$classent = new Entidad(array('file_type','content_file','file_name'),array('','',''));
			$classent->ListaEntidades(array(),"","","","no","","select file_type, content_file, file_name from serv_real where cve_serv_real=".$_GET['cve_serv_real']);
			$tipo      = mysql_result($classent->Lista, 0, "file_type");
			$contenido = mysql_result($classent->Lista, 0, "content_file");
			$nombre    = mysql_result($classent->Lista, 0, "file_name");
			header("Content-type: ".$tipo);
			header("Content-Disposition: ; filename=\"" . $nombre . "\""); 
			print $contenido; 
		}
	}
}
?>
