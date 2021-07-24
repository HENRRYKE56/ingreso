<?php
session_start();
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$StrMsgErrorAll=array();
$StrMsgErrorAll[]="NO se encontraron coincidencias ";

// lo que pinta
$objname=array();
$objname[]='cve_mun';//campo que envia valor


// lo que pinta
$tablename=array();
//$tablename[]='jurisdiccion';
//$tablename[]='municipio';
$tablename[]='localidad';// nombre de la tabla
//$tablename[]='unidad';

$StrAdd=array();
$StrStyle=array();
$StrAdd[]='';
//$StrAdd[]='';
//$StrAdd[]='';

//$StrAdd[]=' onChange="reloadSel(\'cve_uni_exp_m\',\'content\',\'cve_uni_exp_m\',\'unidad\',50,8,3);"';
$StrMsgError=array();
//$StrMsgError[]="seleccione una jurisdicci&oacute;n valida";
//$StrMsgError[]="seleccione un municipio valido";
//$StrMsgError[]="seleccione una unidad valida";
$StrMsgError[]="seleccione una localidad valida";

$fieldCond=array();
//$fieldCond[]=array('cve_jurisdiccion');
//$fieldCond[]=array('cve_mun');//
$fieldCond[]=array('cve_mun');//campo que condiciona

$typeFieldCond=array();
//$typeFieldCond[]=array('text'); //0
//$typeFieldCond[]=array('text');// //1
$typeFieldCond[]=array('text'); //0


$StrFisrst=array();
//$StrFisrst[]=" - Seleccionar jurisdiccion - ";
//$StrFisrst[]=" - Seleccionar municipio - ";
$StrFisrst[]=" - Seleccionar localidad - ";
//$StrFisrst[]=" - Seleccionar unidad - ";


$StrWhereCond=array();
$StrWhereCond[]="";
//$StrWhereCond[]=" and cve_jurisdiccion='".$_SESSION['nomusuario']."'";
//$StrWhereCond[]=" and nivel<>3 and estatus=1 and cve_jurisdiccion='".$_SESSION['nomusuario']."'";

//$StrWhereCond[]=" where tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";
//$StrWhereCond[]=" and tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";
//$StrWhereCond[]=" where tu = 501 and cve_tipo_unidad in (2,3,4,8,9,10)";


$ArrStrCve=array();
///$ArrStrCve[]='cve_mun';
$ArrStrCve[]='cve_localidad';//campo que se depliega
//$ArrStrCve[]='cve_uni';

$ArrStrDes=array();
//$ArrStrDes[]='des_mun';
$ArrStrDes[]=array('cve_localidad',". - .",'des_localidad');////valores
//$ArrStrDes[]=array('cve_uni'," - ",'des_uni');////o 

$ArrFields=array();
//$ArrFields[]=array('cve_mun','des_mun');
$ArrFields[]=array('cve_localidad','des_localidad');//valores
//$ArrFields[]=array('cve_uni','des_uni');

$ArrDefValues=array();
//$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
//$ArrDefValues[]=array(0,'');

$ArrStrOrd=array();
//$ArrStrOrd[]=array('des_mun');
$ArrStrOrd[]=array('des_localidad');
//$ArrStrOrd[]=array('des_uni');
//$ArrStrOrd[]=array('cve_mun','cve_coord','cve_tipo_unidad','des_unidad');
//$ArrStrOrd[]=array('cve_mun','cve_coord','cve_tipo_unidad','des_unidad');
//$ArrStrOrd[]=array('cve_mun','cve_coord','cve_tipo_unidad','des_unidad');

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
//if (strlen($StrFisrst[$_POST['numAdd']])>0){
//	$array_val[]=-1;
//	$array_des[]=$StrFisrst[$_POST['numAdd']];// .' - ' . $classconsul->$varname1;
//}
//break;
//}
$initial_value='0';
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
if (isset($_POST['numAdd']) && in_array($_POST['numAdd'],array(0,1,2,3,4,5,6,7))){
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
//echo $consulWhere;
	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,'','',$strlimit);
//echo "<pre>";
//print_r($classconsul->ListaEntidades);
//echo "</pre>";

//die();

$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");

$xml .= '<datos>\n';
if(strlen($StrFisrst[$_POST['numAdd']])>0)
$xml .= '<elemento value="-1">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
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

