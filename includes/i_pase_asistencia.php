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
	$entidad='Lista de Asistencia';
	$id_prin='cve_alumno';
	$strWhere="Where ";
	$a_order=array();
        
	if ($strWhere=="Where ")
		$strWhere="";
       
	
			$tablas_c='alumnos_ingreso';
			$a_order[]=$id_prin;

			
if($__SESSION->getValueSession('cveunidad')==0){
	$strWhere="";
}
else{
$strWhere="Where  sala=".$__SESSION->getValueSession('cveunidad');
}	

			/******termina condicion de busqueda*/
                                               

	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tabla='alumnos_ingreso';
	$strDistintic="SELECT count(*) as count_r  FROM alumnos_ingreso ".$strWhere;
	$intlimit=2000;
	$a_separs=array();
	$a_separs[]=array(1,'datos generales',3,'separ_verde');
		
	$field[]=array('cve_alumno','No','1','hidden','2','','char','',1,0,100,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	$field[]=array('curp','Curp','1','label','1','','char','',20,30,100,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	 $field[]=array('folio','Folio','1','label','1','','char',"",400,100,200,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	 
	 
	 $field[]=array('nombre','Nombre','1','text','1','','char','',70,70,70,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	 $field[]=array('correo','Email','1','text','1','','char','',20,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-3'),5);
	  $field[]=array('ruta','ruta','1','hidden','1','','char','',70,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-3'),5);
	  
	  $field[]=array('sala','Sala','1','label','1','','char',"",30,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  $field[]=array('asistencia','Asistencia','1','text','1','','char','',0,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  $field[]=array('observaciones','Observaciones','1','text','1','','char','',200,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  $field[]=array('link_clase','Link de la Clase','1','f_archivo1','1','','char','',200,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  $field[]=array('plan_estudio','Plan_estudio','1','label','1','','char',"",350,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  
	 
	  $keyFieldsPop = array('cve_alumno');


	
	
	$a_print = array();
	$setdel='';
	$keyFields=array('cve_alumno');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('ruta','cve_alumno');
	$rwitem='null';
	$suma_width=0;
	$strwentidad="entidad35.php";
	$ent_add="addentidad0002.php";
	$ent_upd="updentidad0002.php";	
	$boolNoEditable=FALSE;
//	$str_self="i_perfil";
	$strSelf="i_pase_asistencia.php";
	$boolNoUpdate=false;
	$boolNoDelete=true;
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
function fnBeforeButtons($objectTmp) {
    global $boolResetButtons;
    global $intNivel;
    global $lblNivel2;
    global $lblNivel3;
    //global $lblNivel4;
    global $intNivelTmp;
    global $lblNivel2Tmp;
    global $lblNivel3Tmp;
    //global $lblNivel4Tmp;
    global $suma_width_aux;
    global $suma_width_aux2;
    global $suma_width_auxTmp;

    global $a_pop_e3;
    global $a_popTitle_e3;
    global $a_popObVal_e3;
    global $a_popContent_e3;
    global $a_popPos_e3;

    $boolResetButtons = false;
	


   
        $a_pop_e3 = array('asistencia'); //campo donde pinta icon =>para llamar modal
        $a_popTitle_e3 = array('Asistencia'); //titulo del modal
        $a_popObVal_e3 = array('asistencia'); //return
        $a_popContent_e3 = array('lst_datos2'); //archivo php en raiz
        $a_popPos_e3 = array(2); //pos del arreglo para llamar il en archivo lst_datos2.php
    
}

?>	

<SCRIPT SRC="js/poptext.js"></SCRIPT>