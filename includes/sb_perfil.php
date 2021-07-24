<?php 
$str_check=FALSE;
include_once("sb_ii_check.php");
//echo $_SERVER['PHP_SELF'].$str_check.'hola'; die();
if ($str_check) {
	$field[]=array('cve_perfil','perfil_modulo','0',0);

$field[]=array('cve_modulo','perfil_modulo','1',"");
$field[]=array('key_modulo','perfil_modulo','1',"");
$allf=array();
$allv=array();
foreach ($field as $afield){
	$allf[]=$afield[0];
	$allv[]=$afield[3];
}
$IdPrin='';
$tabla='sb_perfil_modulo,sb_modulo';
$strWhere="Where sb_perfil_modulo.cve_perfil=".$__SESSION->getValueSession('cveperfil');
$strWhere.=" and sb_perfil_modulo.cve_modulo=".$__SESSION->getValueSession('mod');
$strWhere.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
$strWhere.=" and sb_modulo.sta_modulo<>0";
$classval = new Entidad($allf,$allv);
$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
$str_valmodulo="MOD_NOVALIDO";
if ($classval->NumReg>0){
	$str_valmodulo="MOD_VALIDO";
	$a_key=explode(',',$classval->key_modulo);
	$a_search=array();
	$a_search[0]=array('cve_perfil','des_perfil');
	$a_search[1]=array('Clave','Descripcion');
	$a_search[2]=array('num','text');
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	$entidad='P E R F I L E S';
	$id_prin='cve_perfil';
	$strWhere="Where ";
	$a_order=array();
        
////no refresacar
//if ($__SESSION->getValueSession('opc') == 2){
//    $_SESSION['forinsert']=1;
//}else if(isset($_POST['btnGuarda'])){
//    if($_SESSION['forinsert']!=1){
//        $_SESSION['forinsert']=3;
//    }else{
//        $_SESSION['forinsert']=2;
//    }
//    
//} 
///////
       
	switch ($__SESSION->getValueSession('cveperfil')){
		case 1:
			$tablas_c='sb_perfil';
			$a_order[]=$id_prin;
			break;
		case $__SESSION->getValueSession('cveperfil')<>1:
			$strWhere.=" cve_perfil=".$__SESSION->getValueSession('cveperfil');
			$tablas_c='sb_perfil';
			$a_order[]=$id_prin;
			break;
	}
/******inicia condicion de busqueda*/
						if ($__SESSION->getValueSession('valSearch')<>""){
							foreach($a_search[0] as $cont_search => $itemTmpSearch){
								if($__SESSION->getValueSession('itemSearch')==$itemTmpSearch){
									if ($strWhere<>"Where ")
										$strWhere.=" and ";
									if($a_search[2][$cont_search]=='num'){
										$strWhere.=$__SESSION->getValueSession('itemSearch')." = ".($__SESSION->getValueSession('valSearch')*1);
									}else{
										$strWhere.='upper('.$__SESSION->getValueSession('itemSearch').") like upper('%".trim($__SESSION->getValueSession('valSearch'))."%')";
									}
									break;
								}
							}
						}
			/******termina condicion de busqueda*/
                                               
	if ($strWhere=="Where ")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tabla='sb_perfil';
	$strDistintic="SELECT count(*) as count_r  FROM sb_perfil ".$strWhere;
	$intlimit=20;
	$a_separs=array();
	$a_separs[]=array(1,'datos generales',3,'separ_verde');
	$field[]=array('cve_perfil','Clave','1','label','0','','int',0,100,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	$field[]=array('des_perfil','Descripcion','1','text','1','','char',"",600,100,150,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));
	$field[]=array('sta_perfil','Status','1','check','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));
        $a_print = array();
	$setdel='';
	$keyFields=array('cve_perfil');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('null');
	$rwitem='null';
	$suma_width=0;
	$strwentidad="entidad35.php";
	$ent_add="addentidad0002.php";
	$ent_upd="updentidad0002.php";	
	$boolNoEditable=FALSE;
//	$str_self="i_perfil";
	$strSelf="sb_perfil.php";
	$__SESSION->setValueSession('niveles',array('sb_perfil.php'));
//	$_SESSION['mdKeyFields']=array();
//	$_SESSION['mdFields']=array();
//	$_SESSION['mdValFields']=array();
//	$_SESSION['mdTable']=array();
//	$_SESSION['keyValNiv']=array();
	$suma_width=0;
	$numcols=0;
	foreach ($field as $afield){
		if ($afield[2]=='1'){
			$suma_width+=$afield[8];
			$numcols+=1;
		}
	}
	$awidths=array('300','150','650');

	}
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("sb_ii_refresh.php");
}

?>