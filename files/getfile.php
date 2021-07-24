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
	$IdPrin='cve_modulo';
	$tabla='perfil_modulo,modulo';
	$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
	$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
	$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
	$strWhere.=" and modulo.sta_modulo<>0";
	$classval = new Entidad($allf,$allv);
	$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
	$str_valmodulo="MOD_NOVALIDO";
//print_r ($classval);
	
	if ($classval->NumReg>0){
	
	
		if (isset($_GET['file_get']) && strlen(trim($_GET['file_get']))>0){
		
			
			$a_fields_get=array();
			$a_fields_get_type=array();
			$a_tables_get=array();
			
			$a_fields_get['adjuntossolicitud']=array('cveAdjunto','cveSolicitud');//file_get
			$a_fields_get_type['adjuntossolicitud']=array('num','num');//text, num
			$a_tables_get['adjuntossolicitud']='adjuntossolicitud';	
			
			$a_fields_get['asignacion']=array('cveAdjuntoAsignacion','cveAsignacion');//file_get
			$a_fields_get_type['asignacion']=array('num','num','num');//text, num
			$a_tables_get['asignacion']='adjuntosasignacion';	
			
			$a_fields_get['adjuntofallo']=array('cveAdjuntoFallo','cveFallo');//file_get
			$a_fields_get_type['adjuntofallo']=array('num','num');//text, num
			$a_tables_get['adjuntofallo']='adjuntofallo';	
			
			$strWhereValues="";
			$boolParameters=true;
		//	print_r($boolParameters);
			foreach ($a_fields_get[$_GET['file_get']] as $cont => $item){
				if (strlen(trim($_GET[$item]))==0){
					$boolParameters=false; break;}
				if (strlen($strWhereValues)>0) $strWhereValues.=" and ";
					if ($a_fields_get_type[$_GET['file_get']][$cont]=='num'){
						$strWhereValues.= $item . "=" . $_GET[$item];
					}else{
						$strWhereValues.= $item . "='" . $_GET[$item]."'";
					}
			}
			
			if ($boolParameters){
				
				
				$classent = new Entidad(array('file_type','content_file','file_name'),array('','',''));
				$classent->ListaEntidades(array(),"","","","no","","select file_type, content_file, file_name from ". $a_tables_get[$_GET['file_get']] . " where ". $strWhereValues);
			//	print_r($classent);
				if ($classent->NumReg>0){
					$tipo      = mysql_result($classent->Lista, 0, "file_type");
					$contenido = mysql_result($classent->Lista, 0, "content_file");
					$nombre    = mysql_result($classent->Lista, 0, "file_name");
					header("Content-type: ".$tipo);
					header("Content-Disposition: ; filename=\"" . $nombre . "\""); 
					print $contenido; 
				}else{header("HTTP/1.0 404 Not Found");}
			}else{header("HTTP/1.0 404 Not Found");}
		}else{header("HTTP/1.0 404 Not Found");}
	}else{header("HTTP/1.0 404 Not Found");}
}else{header("HTTP/1.0 404 Not Found");}
?>