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
$objname[]='se.cve_servicios';
$objname[]='cve_uni';



// lo que pinta
$tablename=array();
$tablename[]='servicios se, detmedicos_servicios dm ';
$tablename[]='unidad';

$StrAdd=array();

$StrStyle=array();

$StrAdd[]='';
$StrAdd[]='';


//$StrAdd[]=' onChange="reloadSel(\'cve_uni_exp_m\',\'content\',\'cve_uni_exp_m\',\'unidad\',50,8,3);"';
$StrMsgError=array();
$StrMsgError[]="-- seleccione un servicio valido --";
$StrMsgError[]="-- seleccione una unidad valido --";


$fieldCond=array();
$fieldCond[]=array('dm.cve_medico');//
$fieldCond[]=array('cve_mun');

$typeFieldCond=array();
$typeFieldCond[]=array('text'); //0
$typeFieldCond[]=array('text');// //1


$a_condOper=array();
$a_condOper[]=array('=');
$a_condOper[]=array('=');


$StrFisrst=array();
$StrFisrst[]=" -- Seleccionar servicio -- ";
$StrFisrst[]=" -- Seleccionar unidad -- ";


$StrWhereCond=array();
$StrWhereCond[]=" AND se.cve_servicios=dm.cve_servicio ";
$StrWhereCond[]="  ";


$ArrStrCve=array();
$ArrStrCve[]='se.cve_servicios';//ojo aki va unicamente el campo que se despliega en el comb
$ArrStrCve[]='cve_uni';


$ArrStrDes=array();
$ArrStrDes[]=array('se.servicio');
$ArrStrDes[]=array('des_uni');


$ArrFields=array();
$ArrFields[]=array('se.cve_servicios','se.servicio');
$ArrFields[]=array('cve_uni','des_uni');


$ArrDefValues=array();
$ArrDefValues[]=array('','');
$ArrDefValues[]=array('','');


$ArrStrOrd=array();
$ArrStrOrd[]=array('se.servicio');
$ArrStrOrd[]=array('des_uni');



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
		if($a_condOper[$_POST['numAdd']][$cont_val]=='like'){
			$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name. " like '%".trim($a_vals[$cont_val])."%'";
			
			}else{
			
		$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name." ". $a_condOper[$_POST['numAdd']][$cont_val]. " '".trim($a_vals[$cont_val])."'";}
	}
	
}

$consulWhere=" where ". $consulWhere . $StrWhereCond[$_POST['numAdd']];
//if ($_POST['numAdd']==4){
//echo $consulWhere;
//}
	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,'','',$strlimit);
/*echo "<pre>";
print_r($classconsul);
echo "</pre>";*/

//die();

$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");

$xml .= '<datos>\n';
if(strlen($StrFisrst[$_POST['numAdd']])>0)
$xml .= '<elemento value="">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
//$xml .= "<datos>\n";
//if ($_POST['numAdd']==4){
//echo $classconsul->Con->Sql;
//die();
//}
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