<?php 
$str_check=FALSE;
include_once("sb_ii_check.php");
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
	
	//$per_val=array();
	//$per_des=array();
	//$classconsul = new Entidad(array('cve_personal','nom_personal'),array(0,''));
	//$classconsul->ListaEntidades(array('nom_personal'),'personal','');
	//for ($i=0; $i<$classconsul->NumReg; $i++) {
	//	$classconsul->VerDatosEntidad($i,array('cve_personal','nom_personal'));
	//	$per_val[]=$classconsul->cve_personal;
	//	$per_des[]=$classconsul->nom_personal;
	//}
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	$entidad='CAMBIO DE CONTRASE&Ntilde;A';
	$id_prin='cve_usuario';
	$strWhere="Where ";
	$a_order=array();
	
//	echo $_SESSION['cveperfil'];
	switch ($__SESSION->getValueSession('cveperfil')){
		case 1:
			$tablas_c='sb_usuario';
			$a_order[]=$id_prin;
			$a_search=array();
			$a_search[0]=array('nom_usuario','des_usuario');
			$a_search[1]=array('Usuario','Descripcion');
			$a_search[2]=array('text','text');
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
			
			break;
		case in_array($__SESSION->getValueSession('cveperfil'), array(400,401)):
			//$strWhere.=" cve_usuario>=400";
			$strWhere.=" cve_usergroup = ".$__SESSION->getValueSession('cveusergroup');
			$tablas_c='sb_usuario';
			$a_order[]=$id_prin;
			$a_search=array();
			$a_search[0]=array('nom_usuario','des_usuario');
			$a_search[1]=array('Usuario','Descripcion');
			$a_search[2]=array('text','text');
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
			
			break;
		case $__SESSION->getValueSession('cveperfil')>=410:
			$strWhere.=" cve_usuario=".$__SESSION->getValueSession('cveusuario');
			$tablas_c='sb_usuario';
			$a_order[]=$id_prin;
			break;
	}
	if ($strWhere=="Where ")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tabla='sb_usuario';
	$strDistintic="SELECT count(*) as count_r FROM sb_usuario ".$strWhere;
        //die($strDistintic);
	$intlimit=20;
	$a_separs=array();
	$a_separs[]=array(0,'Datos Generales',4,'separ_verde');
	
//	echo $strWhere;
        $field[]=array('cve_usuario','cve_usuario','1','label','0','','int',0,100,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	if (!($__SESSION->getValueSession('opc')==2 || $__SESSION->getValueSession('opc')==3 || (isset($_POST['op']) && $_POST['op']==1))){
		$field[]=array('nom_usuario','Usuario','1','text','1','','char',"",100,100,16,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('des_usuario','Descripcion de Cuenta','1','text','1','','char',"",450,100,60,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));	
	}
	if ($__SESSION->getValueSession('opc')==2 || $__SESSION->getValueSession('opc')==3 || (isset($_POST['op']) && $_POST['op']==1)){
		$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));	
	} else {
		$field[]=array('sta_usuario','Status','1','check','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));
		//$field[]=array('cve_personal','Personal Asociado','1','select','1',array($per_val,$per_des),'int',0,200,20,2,'',1);
	}
	$setdel='';
	
	
	
	$keyFields=array('cve_usuario');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('cve_usuario');
	$suma_width=0;
	$rwitem='null';
	$strwentidad="entidad35.php";
	$ent_add="addentidad0002.php";
	$ent_upd="updentidad0002.php";	
	
	$boolNoEditable=FALSE;
	$boolNoUpdate=FALSE;
	$boolNoDelete=TRUE;
	$strSelf="sb_passwd.php";
	$__SESSION->setValueSession('niveles',array('sb_usuario.php'));
//	$_SESSION['mdKeyFields']=array(array('cve_usuario'));
//	$_SESSION['mdFields']=array(array('des_usuario'));
//	$_SESSION['mdValFields']=array(array('*'));
//	$_SESSION['mdTable']=array('usuario');
//	$_SESSION['keyValNiv']=array();
//	$_SESSION['keyValNiv'][0]=array('');
//	$intNivel=1;
	$suma_width=0;
	$numcols=0;
	foreach ($field as $afield){
		if ($afield[2]=='1' && !in_array($afield[0],$array_noprint_ent)){
			$suma_width+=$afield[8];
			$numcols+=1;
		}
	}
	$suma_width_aux=0;
	if (isset($a_print))
		foreach ($a_print as $aa_print){
			$suma_width+=$aa_print[3];
			$suma_width_aux+=$aa_print[3];
		}
	if (isset($intNW))
			$suma_width+=$intNW;			
	if (isset($intNW2)){
			$suma_width+=$intNW2;
			$suma_width_aux+=$intNW2;
	}
	if (isset($intNW3)){
			$suma_width+=$intNW3;
			$suma_width_aux+=$intNW3;
	}
	if (isset($intNW))
		$suma_width_aux+=$intNW;		
	$awidths=array('300','150','700');
	//	$str_ent=$PHP_SELF."?ent=i_indicador&id=";
	//	if (isset($_GET['opccal']) && $_GET['opccal']==1)
	//		$str_ent=$PHP_SELF."?opccal=".$_GET['opccal']."&ent=i_proyecto&id=";
	//	}
	//echo "hola"; die();
	}
	
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("sb_ii_refresh.php");
}
?>