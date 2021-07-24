<?php
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
//die();
session_start();
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");

$StrMsgErrorAll=array();
$StrMsgErrorAll[]="NO se encontraron coincidencias ";
$StrMsgErrorAll[]="NO se encontraron coincidencias ";
// lo que pinta
$objname=array();
//$objname[]='cve_mun';//campo que envia valor
//cve_servicio
$objname[]='cve_servicio';
$objname[]='cve_medico';//campo que envia valor
//select DISTINCT (c.cve_servicio),sa.des_servicio from citas c inner join servicio_atencion sa on c.cve_servicio=sa.cve_servicio 
//where c.cve_medico=9 
//SELECT DISTINCT (dms.cve_servicio), sa.des_servicio
//FROM detmedicos_servicios dms, servicio_atencion sa
//WHERE dms.cve_servicio=sa.cve_servicio and sa.cve_unidad='MCSSA007982' and dms.cve_medico=1



$tablename=array();
$tablename[]='consultorios';// nombre de la tabla
$tablename[]='detmedicos_servicios dms, servicios sa';// n

//select * from 
//(select DISTINCT c.cve_medico, c.cve_servicio , sa.des_servicio
//from citas c inner join servicio_atencion sa on c.cve_servicio=sa.cve_servicio )q1 where q1.cve_medico=9 

$StrAdd=array();

$StrStyle=array();

$StrAdd[]='';

$StrMsgError=array();
$StrMsgError[]="seleccione un consultorio valido";
$StrMsgError[]="seleccionar una especialida valida";

$fieldCond=array();
$fieldCond[]=array('cve_servicio');//campo que condiciona
$fieldCond[]=array('dms.cve_medico');

$typeFieldCond=array();
$typeFieldCond[]=array('num'); //0
$typeFieldCond[]=array('num'); //0


$StrFisrst=array();
$StrFisrst[]=" -Seleccionar consultorio- ";
$StrFisrst[]=" -Seleccionar una especialidad- ";


$StrWhereCond=array();
$StrWhereCond[]=" AND cve_unidad ='".$__SESSION->getValueSession('cveunidad')."' ";
$StrWhereCond[]=" AND dms.cve_servicio=sa.cve_servicios and sa.cve_unidad='".$__SESSION->getValueSession('cveunidad')."'";

if($_POST['numAdd']==0 && ($__SESSION->getValueSession('cveperfil')==518 || $__SESSION->getValueSession('cveperfil')==519 || $__SESSION->getValueSession('cveperfil')==517))
    $StrWhereCond[0].=" and cve_medico=".$__SESSION->getValueSession('cve_medico');

//$a_strWhere['visita2']=" cve_unidad='".$_SESSION['cveunidad']."' ";

$ArrStrCve=array();
$ArrStrCve[]='cve_consultorio';//campo que se depliega
$ArrStrCve[]='dms.cve_servicio';
//$objname[]='cve_servicio'; 'DISTINCT(c.cve_servicio)','sa.des_servicio

$ArrStrDes=array();
$ArrStrDes[]=array('no_consultorio');////valores
$ArrStrDes[]=array('sa.servicio');////valores


$ArrFields=array();
$ArrFields[]=array('cve_consultorio','no_consultorio');//valores
$ArrFields[]=array('dms.cve_servicio','sa.servicio');//valores

$ArrFieldsreal=array();
$ArrFieldsreal[]=('cve_consultorio,concat(no_consultorio,\' \',des_consultorio) as no_consultorio');//valores
$ArrFieldsreal[]=('dms.cve_servicio,sa.servicio');//valores


$ArrDefValues=array();
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');

$ArrStrOrd=array();
$ArrStrOrd[]=array('des_consultorio');
$ArrStrOrd[]=array('sa.servicio');

$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';
$StrStyle[]='style="color:#2E3C00;"';


$array_val=array();
$array_des=array();


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
	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,  $ArrFieldsreal[$_POST['numAdd']],'',$strlimit);
//echo "<pre>";
//print_r($classconsul->ListaEntidades);
//echo "</pre>";
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