<?php 
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$StrMsgErrorAll=array();
$StrMsgErrorAll[]="NO se encontraron coincidencias ";


// lo que pinta
$objname=array();
$objname[]='cve_municipio';
$objname[]='cve_coordinacion';
$objname[]='cve_localidad';
$objname[]='cve_ageb';
$objname[]='no_manzana';
$objname[]='cve_centro';
$objname[]='cve_tap';
$objname[]='cve_biologico';
$objname[]='cve_grupo_edad';

// lo que pinta
$tablename=array();
$tablename[]='municipio';
$tablename[]='coordinacion';
$tablename[]='localidad';
$tablename[]='ageb a, manzanas m';
$tablename[]='manzanas';
$tablename[]='centro';
$tablename[]='tap';
$tablename[]='biologico b, biologico_edad be';
$tablename[]='detecciones_cancer_edad de,detecciones_cancer dc';

$StrAdd=array();
$StrStyle=array();
$StrAdd[]='';

//$StrAdd[]=' onChange="reloadSel(\'cve_uni_exp_m\',\'content\',\'cve_uni_exp_m\',\'unidad\',50,8,3);"';
$StrMsgError=array();
$StrMsgError[]="seleccione una jurisdiccion valida";
$StrMsgError[]="seleccione un municipio valido";
$StrMsgError[]="seleccione un municipio valido";
$StrMsgError[]="seleccione un localidad valida";
$StrMsgError[]="seleccione un ageb valido";
$StrMsgError[]="seleccione un municipio valido";
$StrMsgError[]="seleccione un ageb valido";
$StrMsgError[]="seleccione un grupo de edad valido";
$StrMsgError[]="seleccione un grupo de edad valido";

$fieldCond=array();
$fieldCond[]=array('cve_jurisdiccion');
$fieldCond[]=array('cve_jurisdiccion','cve_municipio');//
$fieldCond[]=array('cve_jurisdiccion','cve_municipio');//
$fieldCond[]=array('m.cve_jurisdiccion','m.cve_municipio','m.cve_localidad','m.cve_tap');//ageb
$fieldCond[]=array('cve_jurisdiccion','cve_municipio','cve_localidad','cve_ageb','cve_tap');//manzana
$fieldCond[]=array('cve_jurisdiccion','cve_municipio');//
$fieldCond[]=array('cve_jurisdiccion','cve_municipio','cve_coordinacion');// 6,'cve_localidad'
$fieldCond[]=array('be.cve_grupo_edad');// 6,'cve_localidad'
$fieldCond[]=array('de.cve_grupo_edad');// 6,'cve_localidad'

$typeFieldCond=array();
$typeFieldCond[]=array('text'); //0
$typeFieldCond[]=array('text','text');// //1
$typeFieldCond[]=array('text','text');//2
$typeFieldCond[]=array('text','text','text','text');//3
$typeFieldCond[]=array('text','text','text','text','text');//4
$typeFieldCond[]=array('text','text');//5$StrFirs=array();
$typeFieldCond[]=array('text','text','text');//6,'text'
$typeFieldCond[]=array('num');//7,'text'
$typeFieldCond[]=array('num');//7,'text'


$StrFisrst[]=" seleccionar municipio";
$StrFisrst[]=" seleccionar coordinacion";
$StrFisrst[]=" seleccionar localidad";
$StrFisrst[]=" seleccionar ageb";
$StrFisrst[]=" seleccionar manzana";
$StrFisrst[]=" seleccionar unidad";
$StrFisrst[]="--";
$StrFisrst[]=" seleccionar biologico";
$StrFisrst[]=" seleccionar una deteccion";

$StrWhereCond=array();
$StrWhereCond[]="";
$StrWhereCond[]="";
$StrWhereCond[]="";
$StrWhereCond[]= " and a.cve_jurisdiccion = m.cve_jurisdiccion and a.cve_municipio = m.cve_municipio and a.cve_localidad=m.cve_localidad" .
				 " and a.cve_ageb=m.cve_ageb group by a.cve_ageb";
$StrWhereCond[]="";
$StrWhereCond[]="";
$StrWhereCond[]="";
$StrWhereCond[]=" and be.cve_biologico = b.cve_biologico ";
$StrWhereCond[]=" and de.cve_deteccion_cancer=dc.cve_deteccion_cancer";

//$StrWhereCond[]=" where tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";
//$StrWhereCond[]=" and tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";
//$StrWhereCond[]=" where tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";


$ArrStrCve=array();
$ArrStrCve[]='cve_municipio';
$ArrStrCve[]='cve_coordinacion';
$ArrStrCve[]='cve_localidad';
$ArrStrCve[]='cve_ageb';
$ArrStrCve[]='no_manzana';
$ArrStrCve[]='cve_centro';
$ArrStrCve[]='cve_tap';
$ArrStrCve[]='cve_biologico';
$ArrStrCve[]='cve_deteccion_cancer';

$ArrStrDes=array();
$ArrStrDes[]='municipio';
$ArrStrDes[]='coordinacion';
$ArrStrDes[]='localidad';
$ArrStrDes[]=array('ageb','cve_ageb');
$ArrStrDes[]='no_manzana';
$ArrStrDes[]='centro';
$ArrStrDes[]=array('tap','cve_tap');
$ArrStrDes[]='des_biologico';
$ArrStrDes[]=array('des_deteccion');

$ArrFields=array();
$ArrFields[]=array('cve_municipio','municipio');
$ArrFields[]=array('cve_coordinacion','coordinacion');
$ArrFields[]=array('cve_localidad','localidad');
$ArrFields[]=array('cve_ageb','ageb');
$ArrFields[]=array('no_manzana');
$ArrFields[]=array('cve_centro','centro');
$ArrFields[]=array('cve_tap','tap');
$ArrFields[]=array('cve_biologico','des_biologico');
$ArrFields[]=array('cve_deteccion_cancer','des_deteccion');

$ArrDefValues=array();
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0);
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');


$ArrStrOrd=array();
$ArrStrOrd[]=array('municipio');
$ArrStrOrd[]=array('coordinacion');
$ArrStrOrd[]=array('localidad');
$ArrStrOrd[]=array('ageb');
$ArrStrOrd[]=array('no_manzana');
$ArrStrOrd[]=array('centro');
$ArrStrOrd[]=array('tap');
$ArrStrOrd[]=array('des_biologico');
$ArrStrOrd[]=array('dc.cve_deteccion_cancer');

//$ArrStrOrd[]=array('cve_municipio','cve_coord','cve_tipo_unidad','des_unidad');
//$ArrStrOrd[]=array('cve_municipio','cve_coord','cve_tipo_unidad','des_unidad');
//$ArrStrOrd[]=array('cve_municipio','cve_coord','cve_tipo_unidad','des_unidad');

$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';



$array_val=array();
$array_des=array();
//switch ($_POST['numAdd']){
//case 2:
//	$array_val[]='ALL';
//	$array_des[]=$StrFisrst[$_POST['numAdd']];// .' - ' . $classconsul->$varname1;
//break;
//case 4:
//	$array_val[]='ALL';
//	$array_des[]=$StrFisrst[$_POST['numAdd']];// .' - ' . $classconsul->$varname1;
//break;
//default:
	$array_val[]=-1;
	$array_des[]=$StrFisrst[$_POST['numAdd']];// .' - ' . $classconsul->$varname1;
//break;
//}
$initial_value='0';
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
if (isset($_POST['numAdd']) && in_array($_POST['numAdd'],array(0,1,2,3,4,5,6,7,8))){

if (isset($_POST['initialize']) and $_POST['initialize']==0){
//$classconsul = new Entidad(array($ArrStrCve[$_POST['numAdd']],$ArrStrDes[$_POST['numAdd']]),array('',''));
$classconsul = new Entidad($ArrFields[$_POST['numAdd']],$ArrDefValues[$_POST['numAdd']]);
$consulWhere='';
$strlimit="";
$a_vals=explode("::",trim($_POST['varval']));
########//recuerda que debes incluir los numeros adicionales###################
foreach ($fieldCond[$_POST['numAdd']] as $cont_val=> $item_name ){
	if ($typeFieldCond[$_POST['numAdd']][$cont_val]=='num'){
		$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name. " = ".trim($a_vals[$cont_val]);}
	else{
		$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name. " = '".trim($a_vals[$cont_val])."'";}
	
}
 
$consulWhere=" where ". $consulWhere . $StrWhereCond[$_POST['numAdd']];
//echo "asdfafasfsd".$consulWhere;die();
	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,'','',$strlimit);
        
        
        
$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>\n<elemento value="-1">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
//$xml .= "<datos>\n";
	for ($i=0; $i<$classconsul->NumReg; $i++) {
		$classconsul->VerDatosEntidad($i,$ArrFields[$_POST['numAdd']]);
		$varname1 = $ArrStrCve[$_POST['numAdd']];
		//$varname2 = $ArrStrDes[$_POST['numAdd']];
		$xml .= '<elemento value="'.$classconsul->$varname1.'">';
		if (is_array($ArrStrDes[$_POST['numAdd']])){
			foreach($ArrStrDes[$_POST['numAdd']] as $cntDes => $itemDes){
				if ($cntDes > 0) $xml .= " ";
				$xml .= $classconsul->$itemDes;
			}
		}else{$varname2 = $ArrStrDes[$_POST['numAdd']]; $xml .= $classconsul->$varname2;}
		$xml .= '</elemento>';
	}

$xml .= "</datos>";
header('Content-type: text/xml');
echo $xml;		

}


}
?>

