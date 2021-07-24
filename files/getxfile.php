<?php 
// 
//$idx=addslashes($_GET['idx']);
//$aidx = explode(":", $idx);
//if (isset($arowid[0]) && strlen(trim($aidx[0]))>0){
//	$arowid[0]=(addslashes($aidx[0]);
//	session_id (trim($aidx[0]));
	session_start();
//	if (isset($_SESSION['cveperfil']) && isset($_SESSION['mod'])){
		include_once("../config/cfg.php");
		include_once("../lib/lib_pgsql.php");
		include_once("../lib/lib_entidad.php");
		include_once("../rep/lib/lib32.php");
//		$field[]=array('cve_perfil','perfil_modulo','0',0);
//		$field[]=array('cve_modulo','perfil_modulo','1',"");
//		$field[]=array('key_modulo','perfil_modulo','1',"");
//		$allf=array();
//		$allv=array();
//		$tabla='perfil_modulo,modulo';
//		$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
//		$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
//		$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
//		$strWhere.=" and modulo.sta_modulo<>0";
//		$classval = new Entidad($allf,$allv);
//		$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
//		$str_valmodulo="MOD_NOVALIDO";
//		if ($classval->NumReg>0){
	
			$boolFileVarExists=false;
	
		
			if (isset($_GET['file_get']) && strlen(trim($_GET['file_get']))>0){
				$a_fields_get=array();
				$a_fields_get_type=array();
				$a_tables_get=array();
				$a_fields_get['img_compromiso']=array('cve_compromiso','cve_file_compromiso');//file_get
				$a_fields_get_type['img_compromiso']=array('num','num');//text, num
				$a_tables_get['img_compromiso']='file_compromiso';//file_get			
				$strWhereValues="";
				foreach($a_fields_get as $name => $value){
					if ($name==trim($_GET['file_get'])) {$boolFileVarExists=true; break; echo $_GET['file_get'];}
				}
				if ($boolFileVarExists){
					$boolParameters=true;
					foreach ($a_fields_get[trim($_GET['file_get'])] as $cont => $item){
						if (strlen(trim($_GET[$item]))==0){
							$boolParameters=false; break;}
						if (strlen($strWhereValues)>0) $strWhereValues.=" and ";
							if ($a_fields_get_type[trim($_GET['file_get'])][$cont]=='num'){
								$strWhereValues.= $item . "=" . trim($_GET[$item]);
							}else{
								$strWhereValues.= $item . "='" . trim($_GET[$item])."'";
							}
					}
					if ($boolParameters){
						$classent = new Entidad(array('file_type','content_file','file_name'),array('','',''));
						$classent->ListaEntidades(array(),"","","","no","","select file_type, content_file, file_name from ". $a_tables_get[trim($_GET['file_get'])] . " where ". $strWhereValues);
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
//		}else{header("HTTP/1.0 404 Not Found");}
//	}else{header("HTTP/1.0 404 Not Found");}
//}else{header("HTTP/1.0 404 Not Found");}

?>
