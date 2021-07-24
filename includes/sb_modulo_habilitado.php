<?php 
$str_check=FALSE;
include_once("ii_check.php");
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
$tabla='perfil_modulo,modulo';
$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
$strWhere.=" and modulo.sta_modulo<>0";
$classval = new Entidad($allf,$allv);
$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
$str_valmodulo="MOD_NOVALIDO";
if ($classval->NumReg>0){
	$str_valmodulo="MOD_VALIDO";
	$a_key=explode(',',$classval->key_modulo);
	
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered, 13- salto de linea, 14 - inicia renglon nuevo, 15 - colspan realiza,  );
	*/
	$entidad='habilitados';
	$strSelf="i_modulo_habilitado.php";
	$id_prin='cve_modulo';
	$strWhere="Where";
	$a_order=array();
	$date2=date('Y-m-d H:i:s');
	

			$tablas_c='habilitado as a left outer join modulo_habilitado as ad
on (a.cve_habilitado = ad.habilitado)';
			
			$a_order[]="a.fecha_inicial";




// Pinta el encabezado con la modulo_habilitado que envia proceso anterior
	$sel=0;
	$boolkeyValNiv=TRUE;
	$a_mdLabel=array("<span style='width:200px;background-color:#B6BAAC;'>modulo</span>");
//	$astr_MDIcon=array();
//	$astr_MDIcon[0]="";
//	$astr_MDIcon[1]="<img alt='familia' border='0' src='img/home.png'>";
//	$astr_MDIcon[2]="<img alt='integrante' border='0' src='img/group.png'>";
	$m_keyFields=array('cve_modulo');
	$m_Table='modulo';
	$m_Fields=array('des_modulo');
	$m_keyTypeFields=array('num');	//num,text
	$m_TypeFields=array('text');	//num,text
	$a_keyValNiv=array();
	
	
	$keyFields=array('cve_modulo');
	$keyTypeFields=array('num');	//num,text
/*SI EXISTEN IT SE CREA CONDICION*/
	if (isset($_GET['it0'])){
		foreach ($m_keyFields as $cont => $item){
			$a_keyValNiv[]=$_GET['it'.$cont];
			if ($strWhere!="Where")
				$strWhere.=" and ";
				if ($m_keyTypeFields[$cont]=='num'){
					$strWhere.= " " . $item."=".$_GET['it'.$cont];
				}
				else{
					$strWhere.= " " . $item."='".$_GET['it'.$cont]."'";
				}
		}
		
	$_SESSION['s_keyFields']=$a_keyValNiv;

		
		foreach ($_SESSION['niveles'] as $cont => $item){
			if ($item==$strSelf){
				$_SESSION['mdKeyFields'][$cont]=$m_keyFields;
				$_SESSION['mdKeyTFields'][$cont]=$m_keyTypeFields;
				$_SESSION['mdFields'][$cont]=$m_Fields;
				$_SESSION['mdTFields'][$cont]=$m_TypeFields;
				$_SESSION['mdValFields'][$cont]=$a_keyValNiv;
				$_SESSION['mdTable'][$cont]=$m_Table;
				$_SESSION['keyValNiv'][$cont]=$a_keyValNiv;
				$_SESSION['intSelfNivel']=$cont;
				break;
			}
		}
	} else{
		foreach ($_SESSION['niveles'] as $cont => $item){
			if ($item==$strSelf){
                                                                $_SESSION['intSelfNivel']=$cont;
				if (isset($_SESSION['keyValNiv'][$cont])){
					foreach ($m_keyFields as $contVal => $itemVal){
						if ($strWhere!="Where")
							$strWhere.=" and ";
						if ($m_keyTypeFields[$contVal]=='num'){
							$strWhere.= " " . $itemVal."=".$_SESSION['keyValNiv'][$cont][$contVal];
						}
						else{
							$strWhere.= " " . $itemVal."='".$_SESSION['keyValNiv'][$cont][$contVal]."'";
						}
						//break;
					}
				}
				break;	
			}
			
		}
	}
		
	
$tablas_c='habilitado as a left outer join (select * from modulo_habilitado '.$strWhere.' order by habilitado) as ad
on (a.cve_habilitado = ad.habilitado) ';

	
		$strWhere="";
	
	$items0='a.cve_habilitado,a.fecha_inicial,a.fecha_final, ad.habilitado';
	
	$intNW = 0;
	$intWLblEntidad=280;
	$tabla='modulo_habilitado';
	$intlimit=1000;
	
	$a_separs=array();
	$a_separs[]=array(11,'datos generales de modulo periodo',6,'separ_verde');
	
	
if (isset($_POST['btnGuardaDetalleMD'])){
	$field[]=array('cve_modulo','ID','2','hidden','3','','char',0,35,20,0,'',0,1,1,'');	
	$field[]=array('habilitado','seleccionar','1','check','3','','int','cve_habilitado',60,10,9,'',1,1,5,'',0,'seleccionar');
}else{
	$field[]=array('fecha_inicial','inicial','1','text','3','','char',"",200,20,0,'',1,1,0,'',0,'inicial',0,'',
						'','',$CFG_LBL[43],'','','','','','','background="img/bg09.jpg"',0);
	$field[]=array('fecha_final','final','1','text','3','','char',"",200,20,0,'',1,1,0,'',0,'final',0,'',
						'','',$CFG_LBL[43],'','','','','','','background="img/bg09.jpg"',0);
	
	$field[]=array('cve_habilitado','cve habilitado','1','hidden','3','','int',1,70,10,9,'',1,1,5,'',0,'cve habilitado');	
	$field[]=array('habilitado','seleccionar','1','check','3','','int','cve_habilitado',60,10,9,'',1,1,5,'',0,'seleccionar');
}

	
	$setdel='';


	$array_key_add=array();
	$array_noprint_ent=array('cve_habilitado');

// asigna valor para llamar liga para llamar proceso
    $rptitem = array('null');
	$rwitem=array('null');
	$strwentidad="md_entidad_d2.php";
	 /*para impresion*/
	$a_print=array();
	$rpitem='NULL';
	
	
	
				$boolNoEditable=false; 
				$boolNoDelete=false;
				$boolNoUpdate=false;
				$boolNoNew=false;



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
	$suma_width_aux+=$intNW;		
	$awidths=array('100','180','430');
	
	}
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("ii_refresh.php");
}
function fnOnSaveDetalle(){
	global $keyFields;
	global $keyTypeFields;
	$strConUpd="";
	foreach ($keyFields as $cont => $item){
		if (strlen($strConUpd)>0) 
			$strConUpd.=" and ";
		switch ($keyTypeFields[$cont]){
			case 'text':
				$strConUpd.=$item."='".$_SESSION['s_keyFields'][$cont]."'";
			break;
			case 'num':
				$strConUpd.=$item."=".$_SESSION['s_keyFields'][$cont];
			break;
		}
	}
	$array_namesxTmp=array('habilitado');
	$array_defaultxTmp=array('0');
	$classenttmp = new Entidad($array_namesxTmp,$array_defaultxTmp);
	$classenttmp->Eliminar('modulo_habilitado','','habilitado',1,$strConUpd);	
	//fnImplementInUpd();
}
//function fnImplementInUpd(){
//		$array_namesxTmp=array('last_date');
//		$array_typetxTmp=array('char');
//		$array_defaultxTmp=array(' ');
//		$array_valuesxTmp=array(date("Y-m-d"));
//		$classent = new Entidad($array_namesxTmp,$array_defaultxTmp);
//		$classent->Modificar($array_valuesxTmp,$array_namesxTmp,$array_typetxTmp,'casa'," no_folio='".$_SESSION['s_keyFields'][1]."'");
//}

?>
