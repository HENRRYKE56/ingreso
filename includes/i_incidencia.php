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
		$entidad='Incidencias del Examen de Ingreso ENSVT';
		$id_prin='cve_incidencia ';
			$strWhere="";
		

	$a_order=array("cve_incidencia desc");
		
		
				$tablas_c='incidencias';
				$a_order[]=$id_prin;
			

/******inicia condicion de busqueda*/
		
  
                                   
			/******termina condicion de busqueda*/
		if ($strWhere=="Where ")
			$strWhere="";
		//$strWhere.=" prioridad.estado <> FALSE";
		//$items0='perfil.*';
		$tabla='incidencias';
		$strDistintic="SELECT count(*) as count_r FROM incidencias ";
		$intlimit=20;
		$a_separs=array();
		$a_separs[]=array(1,'Datos Generales',12,'separ_verde');
       
        $field[]=array('cve_incidencia','No de incidencia','1','hidden','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        
		$field[]=array('cveusuario','Usuario','1','hidden','1','','char',$__SESSION->getValueSession('nomusuario'),100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        
		$field[]=array('des_incidencia','Incidencia','1','textarea','1','','char','',100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		
		if (($__SESSION->getValueSession('opc') == 2 ) || isset($_POST['btnGuarda'])) {
            $field[]=array('file_name','Archivo 1089x451','1','file','1','','char',null,200,83,2,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo');  
        }else{
            if (($__SESSION->getValueSession('opc') == 3 ) || isset($_POST['btnActualiza'])) {
                $field[]=array('file_name','Archivo','1','text','2','','char',null,200,83,2,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo'); 
            }else{
                $field[]=array('file_name','Archivo','1','f_archivo','1','','char',null,200,83,2,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo'); 
            }
        }
        
        $field[]=array('ruta','Ruta','1','hidden','2','','char',"",200,100,90,'','',array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));       
      
	   $a_print = array();
		$a_identifyRow=array('cve_incidencia');
        $array_noprint_ent=array('ruta');
		$setdel='';
		$keyFields=array('cve_incidencia');
		$keyTypeFields=array('num');	//int,text
		
		$suma_width=0;
		$rwitem='cve_incidencia';
			$intNW=40;
		//	$str_idniv1="program";
	  //   $str_titleniv1="Acceso de perfil";
		$strwentidad="entidad35.php";
		$boolNoEditable=FALSE;
		$ent_add="addentidad0002.php";
		$ent_upd="updentidad0002.php";
		
		$boolNoUpdate=FALSE;
		$boolNoDelete=FALSE;
		$strSelf="i_incidencia.php";
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
function fnValidBeforeAdd(){

	if ($_FILES['file_name']["error"] >0){
		unset($_FILES);
	}

    if(isset($_FILES['file_name'])){

    $tipo_ar=$_FILES['file_name']["type"];
    $tipo_ar=  explode("/", $tipo_ar);
if ($_FILES['file_name']["error"] > 0){
    $msg='123';
}else if($tipo_ar[0]=='image'){
    move_uploaded_file($_FILES['file_name']['tmp_name'],'images/carousel/'."" . $_FILES['file_name']['name']);    

}else{
    $msg='123';
}
}
    
    
}



?>