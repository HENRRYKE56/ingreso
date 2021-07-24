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
		$sel=0;
		$a_search=array();
		
		$field=array();
		$allf=array();
		$allv=array();
		
	        $a_search = array();
        $a_search[0] = array('curp','folio','nombre');
        $a_search[1] = array('Curp','Folio','Nombre');
        $a_search[2] = array('text','','text');
		
        $strWhere="Where ";
		if ($__SESSION->getValueSession('valSearch') <> "") {
            foreach ($a_search[0] as $cont_search => $itemTmpSearch) {
                if ($__SESSION->getValueSession('itemSearch') == $itemTmpSearch) {
                    if ($strWhere <> "Where ")
                        $strWhere .= " and ";
                    if ($a_search[2][$cont_search] == 'num') {
                        $strWhere .= $__SESSION->getValueSession('itemSearch') . " = " . ($__SESSION->getValueSession('valSearch') * 1);
                    } else {
                        $strWhere .=  $__SESSION->getValueSession('itemSearch') . " like '%" . trim($__SESSION->getValueSession('valSearch')) . "%'";
                   
					
					}
                    break;
                }
            }
        }



	
		
		$entidad='Seguimiento Ingreso 2021';
		$id_prin='nombre ';
		$a_order=array("nombre asc");
		
		
				$tablas_c='alumnos_ingreso';
				$a_order[]=$id_prin;

				


if($__SESSION->getValueSession('cveunidad')==0){
				$strWhere="";
		}
		else{
			$strWhere="Where  sala=".$__SESSION->getValueSession('cveunidad');
	}
/*	echo"<pre>unidad=";
	print_r($__SESSION->getValueSession('cveunidad'));
	die();		
/******inicia condicion de busqueda*/

		

                                   
			/******termina condicion de busqueda*/
		if ($strWhere=="Where ")
			$strWhere="  ";
		//$strWhere.=" prioridad.estado <> FALSE";
		//$items0='perfil.*';
		$tabla='alumnos_ingreso';
		$strDistintic="SELECT count(*) as count_r FROM alumnos_ingreso ".$strWhere;
		$intlimit=40;
		$a_separs=array();
		$a_separs[]=array(1,'Datos Generales',12,'separ_verde');

			/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
		'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
		'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
		'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	
		$field[]=array('cve_alumno','cve_alumno','1','text','char','',200,100,100,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('curp','Curp','1','label','char','',200,100,100,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		 $field[]=array('folio','Folio','1','label','1','','char',"",200,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		 
		 
		 $field[]=array('nombre','Nombre','1','text','1','','char','',300,300,300,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),5);
     	 $field[]=array('plan_estudio','Plan_estudio','1','label','1','','char',"",350,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		  $field[]=array('sala','Sala','1','label','1','','char',"",350,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		  $field[]=array('asistencia','Asistencia','1','text','1','','char',0,400,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		  $field[]=array('observaciones','Observaciones','1','text','1','','char',0,400,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
         
		  $keyFieldsPop = array('cve_alumno');
        $a_print = array('cve_alumno');
		$a_identifyRow=array('cve_alumno');
        $array_noprint_ent=array('plan_estudio');
		$setdel='';
		$keyFields=array('curp');
		$keyFieldsUnique=array('curp');
		$keyTypeFieldsUnique=array('text');	//int,text
		$keyTypeFields=array('text');	//int,text
		
		$suma_width=0;
		$rwitem='curp';
			$intNW=40;
		//	$str_idniv1="program";
	  //   $str_titleniv1="Acceso de perfil";
		$strwentidad="entidad35.php";
		$ent_add = "addentidad0002.php";
        $ent_upd = "updentidad0002.php";
		$boolNoEditable=FALSE;
	
		
		$boolNoUpdate=FALSE;
		$boolNoDelete=true;
		$strSelf="i_pase_asistencia.php";
	//	$__SESSION->setValueSession('niveles',array('sb_usuario.php','sb_perfil_usuario.php'));
	
		$suma_width=0;
		$numcols=0;
		foreach ($field as $afield){
			if ($afield[2]=='1'){
				$suma_width+=$afield[8];
				$numcols+=1;
			}
		}
		$awidths=array('300','150','650');
	//	$str_ent=$PHP_SELF."?ent=i_indicador&id=";
	//	if (isset($_GET['opccal']) && $_GET['opccal']==1)
	//		$str_ent=$PHP_SELF."?opccal=".$_GET['opccal']."&ent=i_proyecto&id=";
	//	}
	}
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("sb_refresh.php");
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
	


   
        $a_pop_e3 = array('nombre'); //campo donde pinta icon =>para llamar modal
        $a_popTitle_e3 = array('Asistencia'); //titulo del modal
        $a_popObVal_e3 = array('asistencia'); //return
        $a_popContent_e3 = array('lst_datos2'); //archivo php en raiz
        $a_popPos_e3 = array(2); //pos del arreglo para llamar il en archivo lst_datos2.php
    
}

?>	

<SCRIPT SRC="js/poptext.js"></SCRIPT>
