<?php
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
$objname[]='cve_servicio';//campo que envia valor
$objname[]='cve_medico';//campo que envia valor
$objname[]='cve_consultorio';//campo que envia valor
$objname[]='cve_consultorio';//campo que envia valor

$tablename=array();
$tablename[]='consultorios';// nombre de la tabla
$tablename[]='detmedicos_servicios dm, medico m';// nombre de la tabla
$tablename[]='detmedicos_servicios dm, medico m,consultorios c';// nombre de la tabla
$tablename[]='consultorios c, tipo_consulta tc';// nombre de la tabla

$StrAdd=array();

$StrStyle=array();

$StrAdd[]='';
$StrAdd[]='';

$StrMsgError=array();
$StrMsgError[]="seleccione un consultorio valido";
$StrMsgError[]="seleccione un servicio valido";
$StrMsgError[]="seleccione un consultorio valido";
$StrMsgError[]="seleccione un consultorio valido";

$fieldCond=array();
$fieldCond[]=array('cve_servicio');//campo que condiciona
$fieldCond[]=array('dm.cve_servicios');//campo que condiciona
$fieldCond[]=array('m.cve_medico','dm.cve_servicios');//campo que condiciona
$fieldCond[]=array('c.cve_consultorio');//campo que condiciona

$typeFieldCond=array();
$typeFieldCond[]=array('text'); //0
$typeFieldCond[]=array('text'); //0
$typeFieldCond[]=array('text'); //0
$typeFieldCond[]=array('text'); //0


$StrFisrst=array();
$StrFisrst[]=" - Seleccionar consultorio- ";
$StrFisrst[]=" - Seleccionar medico- ";
$StrFisrst[]=" - Seleccionar consultorio- ";
//$StrFisrst[]=" - Seleccionar el tipo de consulta- "; 


$StrWhereCond=array();
$StrWhereCond[]=" AND cve_unidad ='".$__SESSION->getValueSession('cveunidad')."' and cve_estatus=1";

$StrWhereCond[]=" AND dm.cve_unidad ='".$__SESSION->getValueSession('cveunidad')."' and m.estatus=1 AND dm.estatus_dms=1 and dm.cve_medico=m.cve_medico";

$StrWhereCond[]=" AND c.cve_estatus=1 AND dm.cve_unidad ='".$__SESSION->getValueSession('cveunidad')."' and m.estatus=1 AND dm.estatus_dms=1 and dm.cve_medico=m.cve_medico and dm.cve_servicios=c.cve_servicio and m.cve_medico=c.cve_medico ";

$StrWhereCond[]=" and c.cve_estatus=1 and c.cve_tipo_consulta=tc.cve_tipo_consulta ";

if($_POST['numAdd']==0 && ($__SESSION->getValueSession('cveperfil')==518 || $__SESSION->getValueSession('cveperfil')==519 || $__SESSION->getValueSession('cveperfil')==517))
    $StrWhereCond[1].=" and cve_medico=".$__SESSION->getValueSession('cve_medico');
if($_POST['numAdd']==1 && ($__SESSION->getValueSession('cveperfil')==518 || $__SESSION->getValueSession('cveperfil')==519 || $__SESSION->getValueSession('cveperfil')==517))
    $StrWhereCond[1].=" and m.cve_medico=".$__SESSION->getValueSession('cve_medico');
//$a_strWhere['visita2']=" cve_unidad='".$_SESSION['cveunidad']."' ";

$ArrStrCve=array();
$ArrStrCve[]='cve_consultorio';//campo que se depliega
$ArrStrCve[]='cve_medico';//campo que se depliega
$ArrStrCve[]='cve_consultorio';//campo que se depliega
$ArrStrCve[]='cve_tipo_consulta';//campo que se depliega

$ArrStrDes=array();
$ArrStrDes[]=array('no_consultorio');////valores
$ArrStrDes[]=array('des_medico');////valores
$ArrStrDes[]=array('no_consultorio');////valores
$ArrStrDes[]=array('des_tipo_consulta');////valores

$ArrFields=array();
$ArrFields[]=array('cve_consultorio','no_consultorio');//valores
$ArrFields[]=array('cve_medico','des_medico');//valores
$ArrFields[]=array('cve_consultorio','no_consultorio');//valores
$ArrFields[]=array('cve_tipo_consulta','des_tipo_consulta');//valores


$ArrDefValues=array();
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');
$ArrDefValues[]=array(0,'');


$ArrStrOrd=array();
$ArrStrOrd[]=array('des_consultorio');
$ArrStrOrd[]=array('m.des_medico');
$ArrStrOrd[]=array('c.des_consultorio');
$ArrStrOrd[]=array('tc.cve_tipo_consulta');

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
//echo $consulWhere;

//if(isset($_POST['numAdd']) && $_POST['numAdd']==2){
//	
//	$consulWhere=$consulWhere." group by cve_consultorio ";
//	
//	}
	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,'','',$strlimit);
        if($_POST['numAdd']==3 && $classconsul->NumReg == 0){
            $classconsul->ListaEntidades(array('cve_tipo_consulta'),'tipo_consulta',' where cve_tipo_consulta=3','','',$strlimit);
        }
        
//echo "<pre>";
//print_r($classconsul);
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


