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
		$a_search[0]=array('nom_usuario','des_usuario');
		$a_search[1]=array('Usuario','Descripcion');
		$a_search[2]=array('text','text');
		$field=array();
		$allf=array();
		$allv=array();
		

		
		$usergroup_val=array();
		$usergroup_des=array();
		$strPcWhere="";
		$classconsul = new Entidad(array('cve_usergroup','des_usergroup'),array(0,''));
		$classconsul->ListaEntidades(array('des_usergroup'),'sb_usergroup g',$strPcWhere," g.cve_usergroup, g.des_usergroup ",'');
		for ($i=0; $i<$classconsul->NumReg; $i++) {
			$classconsul->VerDatosEntidad($i,array('cve_usergroup','des_usergroup'));
			$usergroup_val[]=$classconsul->cve_usergroup;
			$usergroup_des[]=$classconsul->des_usergroup;
		}
	
		
		/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
		'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
		'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
		'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
		$entidad='USUARIOS';
		$id_prin='cve_usuario';
		$strWhere="Where ";
		$a_order=array();
		
		switch ($__SESSION->getValueSession('cveperfil')){
			case 1:
				$tablas_c='sb_usuario';
				$a_order[]=$id_prin;
				break;
			case 528:
				$tablas_c='sb_usuario';
				$a_order[]=$id_prin;
				break;	
			case 506:
				$strWhere.=" cve_usuario > 1 ";
				$tablas_c='sb_usuario';
				$a_order[]=$id_prin;
				break;
			case $__SESSION->getValueSession('cveperfil')<>1:
				$strWhere.=" cve_usuario=".$__SESSION->getValueSession('cveusuario');
				$tablas_c='sb_usuario';
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
		$tabla='sb_usuario';
		$strDistintic="SELECT count(*) as count_r FROM sb_usuario ".$strWhere;
		$intlimit=20;
		$a_separs=array();
		$a_separs[]=array(1,'Datos Generales',12,'separ_verde');

		$field[]=array('cve_usuario','Clave','1','label','0','','int',0,50,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('nom_usuario','Usuario','1','text','1','','char',"",100,100,16,'valid:Objnom_usuario:msgExampleLa secuencia debe esta formada por caracteres contenidos en\n [a-zA-Z0-9]:regExp^[a-zA-Z0-9]*$',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('des_usuario','Descripci&oacute;n de Cuenta','1','text','1','','char',"",350,100,60,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);	
		if (($__SESSION->getValueSession('opc')==2 ) || isset($_POST['btnGuarda'])){
		$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);	
		}else if (($__SESSION->getValueSession('opc')==3 ) || isset($_POST['btnActualiza'])){
		$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);	
                }
		$field[]=array('sta_usuario','Status','1','check','1','','char',"",100,200,0,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('cve_usergroup','Grupo de usuarios','1','select','1',array($usergroup_val,$usergroup_des),'int',0,400,20,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('email','e-mail','1','text','1','','email',"",100,60,60,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
		$field[]=array('adv_email','avisos e-mail','1','check','1','','char',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
               // $field[] = array('id_area', 'Area', '1', 'select', '1', array($area_val, $area_des), 'char', "", 150, 20, 2, '', 0, 1, array(1, 1, 1), '', 0, 'Area');                        
                //$field[]=array('adv_asigna','avisos asignacion','1','check','1','','char',"",100,200,0,'',0);
                $field[]=array('cveuni','unidad','1','hidden','1','','char',$__SESSION->getValueSession('cveunidad'),100,20,0,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'));  				
                $a_print = array();
		$a_identifyRow=array('nom_usuario');

		$setdel='';
		$keyFields=array('cve_usuario');
		$keyFieldsUnique=array('nom_usuario');
		$keyTypeFieldsUnique=array('text');	//int,text
		$keyTypeFields=array('num');	//int,text
		$array_noprint_ent=array('null');
		$suma_width=0;
		$rwitem='nom_usuario';
			$intNW=40;
			$str_idniv1="program";
	     $str_titleniv1="Acceso de perfil";
		$strwentidad="entidad35.php";
		$boolNoEditable=FALSE;
		$ent_add="addentidad0002.php";
		$ent_upd="updentidad0002.php";
		
	//	$boolNoUpdate=FALSE;
	//	$boolNoDelete=FALSE;
		$strSelf="sb_usuario.php";
		$__SESSION->setValueSession('niveles',array('sb_usuario.php','sb_perfil_usuario.php'));
	$str_idniv1="fa fa-user";
        $str_titleniv1="Perfil";
        $str_estilo1="color:green;";      
		$intNivel=1;
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

function fnImplementInAdd_(){

	
			$intMaxId=0;
			$classent = new Entidad(array('maxid'),array(0));
			$classent->Set_Entidad(array(0),array('maxid'));
			$classent->Consultar(array('maxid'),'','','',"Select max(cve_usuario) as maxid from usuario ");
			$intMaxId=$classent->maxid;
			$array_namesxTmp=array('des_notificador','cve_usuario_n','estatus');
			$array_typetxTmp=array('char','int','check');
			$array_defaultxTmp=array(' ');
			$array_valuesxTmp=array($_POST['des_usuario'],$intMaxId,$_POST['sta_usuario']);
			$classent = new Entidad($array_namesxTmp,$array_defaultxTmp,$array_defaultxTmp,$array_defaultxTmp,$array_defaultxTmp,	$array_defaultxTmp,$array_defaultxTmp);
			$classent->Adicionar($array_valuesxTmp,$array_namesxTmp,$array_typetxTmp,'notificador');
			$classent->Set_Entidad(array(0),array('cve_usuario'));
			$classent->Consultar(array('cve_usuario_n'),'','','',"Select cve_notificador from notificador where des_notificador= '".$_POST['des_notificador']."'" );									 
			$strResult=$classent->cve_usuario;
			$array_namesxTmp=array('cve_notificador');
			$array_typetxTmp=array('int');
			$array_valuesxTmp=array($_POST['cve_usuario']);
//echo"<pre>";
//print_r($_POST);
//print_r($array_valuesxTmp);
//echo"<pre>";
//die();
			//$classent->Modificar($array_valuesxTmp,$array_namesxTmp,$array_typetxTmp,'notificador'," des_notificador=".$intMaxId);
		}




?>