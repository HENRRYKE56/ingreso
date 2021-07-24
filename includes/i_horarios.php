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
		$a_search[0]=array();
		$a_search[1]=array();
		$a_search[2]=array('text','text');
		$field=array();
		$allf=array();
		$allv=array();
		

	
		
		/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
		'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
		'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
		'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
		$entidad='HORARIOS DE '.$__SESSION->getValueSession('desusuario');
		$id_prin='cve_horarios ';
		$strWhere="Where cve_semestre=2 and rfc='".$__SESSION->getValueSession('nomusuario')."'";
		$a_order=array("cve_dia asc");
		
		
				$tablas_c='horarios';
				$a_order[]=$id_prin;
			

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
              
                        $tipo_registro_val=array("",1,2);
                        $tipo_registro_des=array("Seleccione","Entrada","Salida");
		
		$dias_val=array("");
		$dias_des=array("Seleccione");
		$strPcWhere="";
		$classconsul = new Entidad(array('cve_dia','base'),array(0,''));
		$classconsul->ListaEntidades(array('cve_dia'),'cat_dias g',$strPcWhere," g.cve_dia, g.des_dia ",'');
		for ($i=0; $i<$classconsul->NumReg; $i++) {
			$classconsul->VerDatosEntidad($i,array('cve_dia','des_dia'));
			$dias_val[]=$classconsul->cve_dia;
			$dias_des[]=( $classconsul->des_dia);
		}
		$semestre_val=array("");
		$semestre_des=array("Seleccione");
		$strPcWhere="";
		$classconsul = new Entidad(array('cve_semestre','base'),array(0,''));
		$classconsul->ListaEntidades(array('cve_semestre'),'cat_semestres g',$strPcWhere," * ",'');
		for ($i=0; $i<$classconsul->NumReg; $i++) {
			$classconsul->VerDatosEntidad($i,array('cve_semestre','des_semestre'));
			$semestre_val[]=$classconsul->cve_semestre;
			$semestre_des[]=( $classconsul->des_semestre);
		}
                                   
			/******termina condicion de busqueda*/
		if ($strWhere=="Where ")
			$strWhere="";
		//$strWhere.=" prioridad.estado <> FALSE";
		//$items0='perfil.*';
		$tabla='horarios';
		$strDistintic="SELECT count(*) as count_r FROM horarios ".$strWhere;
		$intlimit=20;
		$a_separs=array();
		$a_separs[]=array(1,'Datos Generales',12,'separ_verde');
       
        $field[]=array('cve_horarios','Rfc','1','hidden','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        $field[]=array('rfc','RFC','1','label','1','','char',$__SESSION->getValueSession('nomusuario'),100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
	  
		  $field[]=array('cve_dia','Día'			   ,'1','select','1',array($dias_val,$dias_des),'int','',100,50,5,'',1,array(1,'col-12 col-md-12','col-12 col-md-4'),array(1,1,6));
			
		$field[]=array('entrada','Hora de Entrada','1','hidden','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        $field[]=array('salida','Hora de Salida','1','text','char',"",400,200,200,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        $field[]=array('cve_semestre','Semestre'			   ,'1','select','1',array($semestre_val,$semestre_des),'int','',100,50,5,'',1,array(1,'col-12 col-md-12','col-12 col-md-4'),array(1,1,6));
	
        $a_print = array();
		$a_identifyRow=array('cve_horarios');
        $array_noprint_ent=array('rfc','cve_horarios');
		$setdel='';
		$keyFields=array('cve_dia','rfc');
		$keyFieldsUnique=array('cve_dia','rfc','cve_semestre');
		$keyTypeFieldsUnique=array('text',"text","text");	//int,text
		$keyTypeFields=array('text',"text");	//int,text
		
		$suma_width=0;
		$rwitem='rfc';
			$intNW=40;
		//	$str_idniv1="program";
	  //   $str_titleniv1="Acceso de perfil";
		$strwentidad="entidad35.php";
		$boolNoEditable=FALSE;
		$ent_add="addentidad0002.php";
		$ent_upd="updentidad0002.php";
		
		$boolNoUpdate=FALSE;
		$boolNoDelete=FALSE;
		$strSelf="i_horarios.php";
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
function fnValidBeforeAdd (){
  
        



        
     
    
    
  


}



?>