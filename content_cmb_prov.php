<?php
//echo '<pre>';
//print_r($_POST);die();
session_start();
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");

$StrMsgErrorAll=array();
$StrMsgErrorAll[]="NO se encontraron coincidencias ";

// lo que pinta
$objname=array();

$objname[]='CVEPROV';//campo que envia valor
$objname[]='CVEUNI';

$tablename=array();
$tablename[]='pedido';// nombre de la tabla
$tablename[]=' pedido p 
JOIN cat_proveedor cp ON p.CVEPROV=cp.CVEPROV AND cp.anios_sys='.$__SESSION->getValueSession('anios_sys').' AND cp.estatus=1 '.
        ' JOIN detped d ON d.estatus=1 and p.CVEPED=d.CVEPED AND d.anios_sys=' . $__SESSION->getValueSession('anios_sys');

$StrAdd=array();
$StrAdd[]='';
$StrAdd[]='';

$StrStyle=array();
$StrStyle[]=array();
$StrStyle[]=array();

$StrMsgError=array();
$StrMsgError[]="seleccione un contrato valido";
$StrMsgError[]="seleccione un proveedor valido";


$fieldCond=array();
$fieldCond[]=array('CVEPROV');//campo que condiciona
$fieldCond[]=array('p.CVEUNI');//campo que condiciona


$typeFieldCond=array();
$typeFieldCond[]=array('char'); //0

$StrFisrst=array();
$StrFisrst[]=" Seleccionar pedido ";
$StrFisrst[]=" Seleccionar contrato ";

//$StrFisrst[]=" - Seleccionar el tipo de consulta- "; 


$StrWhereCond=array();
$StrWhereCond[]=" AND es_logico=1 AND anios_sys=".$__SESSION->getValueSession('anios_sys');
$StrWhereCond[]=" AND p.es_logico=1 AND p.anios_sys=".$__SESSION->getValueSession('anios_sys').' GROUP BY p.CVEPROV ';


$ArrStrCve=array();
$ArrStrCve[]='CVEPED';//campo que se depliega
$ArrStrCve[]='CVEPROV';//campo que se depliega


$ArrStrDes=array();
$ArrStrDes[]=array('FECPED');////valores
$ArrStrDes[]=array('NOMPRO');////valores


$ArrFields=array();
$ArrFields[]=array('CVEPED','FECPED');//valores
$ArrFields[]=array('CVEPROV','NOMPRO');//valores

$ArrDefValues=array();
$ArrDefValues[]=array('','');
$ArrDefValues[]=array('','');

$ArrStrOrd=array();
$ArrStrOrd[]=array('CVEPED');
$ArrStrOrd[]=array('p.CVEPROV');

$str_select=array();
$str_select[]="CVEPED,concat(CVEPED,' - ',date_format(FECPED,'%d/%m/%Y')) AS FECPED";
$str_select[]="cp.CVEPROV,CONCAT(cp.CVEPROV,' - ',cp.NOMPRO) AS NOMPRO";

$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';


$array_val=array();
$array_des=array();

$initial_value='0';

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
//die($str_select[$_POST['numAdd']]);
$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,$str_select[$_POST['numAdd']],'',$strlimit);
//
//echo "<pre>";
//print_r($classconsul);
//echo "</pre>";
//
//die();

$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");

$xml .= '<datos>\n';
if(strlen($StrFisrst[$_POST['numAdd']])>0)
$xml .= '<elemento value="">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
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


