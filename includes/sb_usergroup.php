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
	$a_search=array();
	$a_search[0]=array('des_usergroup');
	$a_search[1]=array('Descripcion');
	$a_search[2]=array('text');
	$field=array();
	$allf=array();
	$allv=array();
	
	
	

	
	
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	$entidad='grupos de usuarios';
	$id_prin='cve_usergroup';
	$strWhere="Where ";
	$a_order=array();
	switch ($__SESSION->getValueSession('cveperfil')){
		case 1:
			$tablas_c='sb_usergroup';
			$a_order[]='cve_usergroup';
			break;
//		case $_SESSION['cveperfil']<>1:
//			$strWhere.=" cve_usuario=".$_SESSION['cveusuario'];
//			$tablas_c='usuario';
//			$a_order[]=$id_prin;
//			break;
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
//echo $strWhere;
	if ($strWhere=="Where ")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tabla='sb_usergroup';
	$strDistintic="SELECT count(*) as count_r FROM sb_usergroup ".$strWhere;
	$intlimit=20;
	$a_separs=array();
	$a_separs[]=array(1,'Datos Generales',2,'bg-dark');
	
	$field[]=array('cve_usergroup','Clave','1','label','0','','int',0,50,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);		
	$field[]=array('des_usergroup','Descripcion de usergroup','1','text','1','','char',"",650,100,100,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));
	
        $a_print = array();
	
//	$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',1);	
//	$field[]=array('sta_usuario','Status','1','check','1','','char',"",100,200,0,'',0);
	$setdel='';
	$keyFields=array('cve_usergroup');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('null');
	$suma_width=0;
	$rwitem='des_usergroup';
	$strwentidad="entidad35.php";
	$ent_add="addentidad0002.php";
	$ent_upd="updentidad0002.php";	
	$boolNoEditable=FALSE;
//	$boolNoUpdate=FALSE;
//	$boolNoDelete=FALSE;
	$strSelf="sb_usergroup.php";
	$__SESSION->setValueSession('niveles',array('sb_usergroup.php','sb_perfil_usergroup.php'));
	$intNivel=1;
			$intNW=40;
			$str_idniv1="fa fa-user-plus";
                        $str_titleniv1="Acceso de perfil";
                        $str_estilo1="color:green;";
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
	include_once("sb_ii_refresh.php");
}
?>
<script language="JavaScript">
function getSelectXiniX(){
	args=getSelectXiniX.arguments; target=args[0]; liga=args[1]; numAdd=args[2]; initialize=args[3];
	var varval=""; var xPos=0;
	for (i=4; i<=(args.length-1); i++) { 
		if (args[i].indexOf("objIni_")==-1 && args[i].indexOf("objGet_")==-1){val=findObj(args[i]);
			if (val) {if ((val=val.value.trim())!="") {
				if (i>4) varval+="::"; varval+=val;
			}else{return;}}else{return;}
		}else{xPos=args[i].indexOf("objIni_"); if (xPos==-1) xPos=args[i].indexOf("objGet_");
			disableSelect(document.getElementById(args[i].substring(xPos + 7)),"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");}
	}
	cadena='';
	cadena='varval=' + varval + '&numAdd=' + numAdd + '&initialize=' + initialize;
	selflink = liga + '.php';
	cargar_xml(target, selflink,cadena);
	for (i=4; i<=(args.length-1); i++) { 
		if (args[i].indexOf("objGet_")!=-1){varval=""; xPos=0; cadena="";
			for (j=4; j<=(args.length-1); j++) { 
				if (args[j].indexOf("objIni_")==-1 && args[j].indexOf("objGet_")==-1){val=findObj(args[j]);
					if (val) {if ((val=val.value.trim())!="") {
						if (j>4) varval+="::"; varval+=val;
					}else{return;}}else{return;}
				}
			}			
			
			xPos=args[i].indexOf("objGet_");
			cadena='varval=' + varval + '&numAdd=' + args[i].substring(0,xPos - 1) + '&initialize=' + initialize;
			cargar_xml(args[i].substring(xPos + 7), selflink, cadena);
		}
	}
}			
	
</script>