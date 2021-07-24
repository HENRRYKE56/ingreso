<?php 
session_start(); 
include_once("../config/cfg.php");


if ($__SESSION->getValueSession('cveperfil') && $__SESSION->getValueSession('mod')){
//echo '<pre>';
//print_r($_GET);
//die("qqqqq").$__SESSION->getValueSession('cveperfil');    
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
	$tabla='sb_perfil_modulo,sb_modulo';
$strWhere="Where sb_perfil_modulo.cve_perfil=".$__SESSION->getValueSession('cveperfil');
//$strWhere.=" and sb_perfil_modulo.cve_modulo=".$__SESSION->getValueSession('mod');
$strWhere.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
$strWhere.=" and sb_modulo.sta_modulo<>0";
	$classval = new Entidad($allf,$allv);
	$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
	$str_valmodulo="MOD_NOVALIDO";
//        echo '<pre>';
//print_r ($classval);die();
//            die("aa   asdas");
        
	if ($classval->NumReg>0){
	
		if (isset($_GET['file_get']) && strlen(trim($_GET['file_get']))>0){
			$a_fields_get=array();
			$a_fields_get_type=array();
			$a_tables_get=array();
			
			/*modificar arreglos de acuerdo a lo que se defina en solucion*/

			$a_fields_get['adj_unico']=array('unico','unico');//file_get
			$a_fields_get_type['adj_unico']=array('text','text');//text, num
			$a_tables_get['adj_unico']='adjuntos';	
                        
//			$a_fields_get['open_all']=array('unico','unico');//file_get
//			$a_fields_get_type['open_all']=array('text','text');//text, num
//			$a_tables_get['open_all']='adjuntos';                          
//			


			
			////////////////////////////////////////////////
			$strWhereValues="";
			$boolParameters=true;
//                        echo '<pre>';
//                        print_r($_GET);
//                        print_r($a_fields_get[$_GET['file_get']]);die();
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
//                       die($strWhereValues);
			if ($boolParameters){
				$fields_files=array('file_type','file_name','path','internal_name','file_name');
				$fields_default=array('','','','');
				$classent = new Entidad($fields_files,$fields_default);
				$classent->ListaEntidades(array(),"","","","no","","select * from ". $a_tables_get[$_GET['file_get']] . " where ". $strWhereValues);
				if ($classent->NumReg>0){
					$classent->VerDatosEntidad(0,$fields_files);
//                                echo '<pre>';
//                                print_r($classent);die();                                        
					$file_type=('file_type');
					$internal_name=('internal_name');		
					$imagen_file=('file_name');		
					$path =('path');
					$tipo      = $classent->$file_type;
					$internal_name = $classent->$internal_name;
					$nombre    =$_GET['nom_part'].$classent->$imagen_file;
					$path    = $classent->$path;
//                                        echo 'asdas<pre>';
//                                        print_r($classent);
//                                       die($path."  ----  ".$nombre);
                                        $pat_sis=FILE_SISTEMAS;
					if(isset($pat_sis) && strlen($pat_sis)>0){
						$path_file=$CFG_REPOSITORIO_RAIZ.$path.$CFG_SLASH.$nombre;
                                               // die($path_file);
						if(is_file($path_file)){
							header("Content-type: ".$tipo);
							header("Content-Disposition: ; filename=\"" . $internal_name . "\"");
							header('Content-Length: ' . filesize($path_file));
							ob_end_clean();
							flush();
						    readfile($path_file);
//							$fo = @fopen($path_file, "r");
//							if ($fo) {
//								while (($búfer = fgets($fo, 4096)) !== false) {
//									echo $búfer;
//								}
//								if (!feof($fo)) {
//									echo "Error: fallo inesperado de fgets()\n";
//								}
//								fclose($fo);
//							}
						}else{header("HTTP/1.0 404 Not Found");}
					}else{header("HTTP/1.0 404 Not Found");}
					//print $contenido; 
				}else{header("HTTP/1.0 404 Not Found");}
			}else{header("HTTP/1.0 404 Not Found");}
		}else{header("HTTP/1.0 404 Not Found");}
	}else{header("HTTP/1.0 404 Not Found");}
}else{header("HTTP/1.0 404 Not Found");}
?>
