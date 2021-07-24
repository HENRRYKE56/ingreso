<?php 
session_start();
$str_check=FALSE;
include_once("includes/i_check.php");
if ($str_check) {
	include_once("config/cfg.php");
	include_once("lib/lib_pgsql.php");
	include_once("lib/lib_entidad.php");
	include_once("lib/lib_function.php");
	include_once("rep/lib/lib32.php");
	
$a_table=array();
$a_table['visita2']='pacientes v ';
$a_table['get_to2']='catenf ct';


$a_fields=array();
$a_fields['visita2']=array('cve_paciente','nombre','app_pat','app_mat','cve_sexo','sexo','fecha_nacimiento','curp','no_seguro',
'cve_identificacion',
'ife','expediente_paciente','telefono_celular','fecha_registro','nombre_parentesco',
'cve_estado_civil','cve_nacionalidad','cve_entidad_federativa','cve_municipio','cve_localidad',
'calle',
'cve_estado_exp',
'res_expediente',
'cve_n_social','grupo_v');
$a_fields['get_to2']=array('cvecied','descied');


$a_fieldsValDef=array();
$a_fieldsValDef['visita2']=array(0,'','','','','','','',
0,
'','','','','',
0,0,0,0,0,
'',
0,
'',
0,0);
$a_fieldsValDef['get_to2']=array('','');

$a_strFields=array();
$a_strFields['visita2']='v.cve_paciente, v.nombre,v.app_pat,v.app_mat,v.cve_sexo, v.fecha_nacimiento, v.curp, v.no_seguro, v.cve_identificacion, v.ife, v.expediente_paciente ,v.telefono_celular, v.fecha_registro ,v.nombre_parentesco, v.cve_estado_civil, v.cve_nacionalidad,v.cve_entidad_federativa,v.cve_municipio,v.cve_localidad,v.calle,v.cve_estado_exp, v.res_expediente, v.cve_n_social, v.grupo_v';
$a_strFields['get_to2']='ct.cvecied, ct.descied';

$a_fieldsCond0=array();
$a_fieldsCond0['visita2']=array('nombre');
$a_fieldsCond0['get_to2']=array('descied');

$a_fieldsCond1=array();
$a_fieldsCond1['visita2']=array('v.nombre');
$a_fieldsCond1['get_to2']=array('ct.descied');


$a_fieldsConTtype=array();
$a_fieldsConTtype['visita2']=array('text');//
$a_fieldsConTtype['get_to2']=array('text');//

$a_condOper=array();
$a_condOper['visita2']=array('like');
$a_condOper['get_to2']=array('like');

$a_Order=array();
$a_Order['visita2']=array('cve_paciente');
$a_Order['get_to2']=array('cvecied');


$a_strWhere=array();
$a_strWhere['visita2']=" v.cve_unidad='".$_SESSION['cveunidad']."' ";
$a_strWhere['get_to2']="";


$a_strGroup=array();
$a_strGroup['visita2']="";
$a_strGroup['get_to2']="";


/*	echo "<pre>";	
	print_r($_POST);
	echo "</pre>";	*/
	
	
	$strWhere= $a_strWhere[$_POST['entvalue']];
    $classind = new Entidad($a_fields[$_POST['entvalue']],$a_fieldsValDef[$_POST['entvalue']]);
	foreach ($a_fieldsCond0[$_POST['entvalue']] as $cnt_afield => $afield){
		if (strlen($strWhere)>0){$strWhere.=" and ";}
		switch( $a_fieldsConTtype[$_POST['entvalue']][$cnt_afield]){
			case 'text':
				if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])){
					$strWhere.=" (";
					foreach($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1){
						if ($countCond1>0){$strWhere.=" or ";}
						if  ($a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1]=='like'){$strWhere.=" ".  $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." '%" .  addslashes($_POST[$afield]) . "%'";}
						else{$strWhere.=" ". $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." '" . addslashes($_POST[$afield]) . "'";}
						}
					$strWhere.=" )";
				}else{
					if  ($a_condOper[$_POST['entvalue']][$cnt_afield]=='like'){$strWhere.=" ".  $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '%" .  addslashes($_POST[$afield]) . "%'";}
					else{$strWhere.=" ". $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '" . addslashes($_POST[$afield]) . "'";}
				}
			break;
			case 'num':
				if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])){
					$strWhere.=" (";
					foreach($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1){
						if ($countCond1>0){$strWhere.=" or ";}
						$strWhere.=" ". $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." " .  addslashes($_POST[$afield]);
						}
					$strWhere.=" )";
				}else{
					$strWhere.=" ". $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." " .  addslashes($_POST[$afield]);
				}	
				break;
		}
		
	}
	if (strlen($strWhere)>0) $strWhere = " Where " . $strWhere;
	$strWhere .= $a_strGroup[$_POST['entvalue']];
	
	
$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';

	$classind->ListaEntidades($a_Order[$_POST['entvalue']],$a_table[$_POST['entvalue']],$strWhere,$a_strFields[$_POST['entvalue']]);
//	echo "<pre>";
//	print_r($classind);
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$a_fields[$_POST['entvalue']], FALSE);
		$xml .= '<elemento>';
		foreach ($a_fields[$_POST['entvalue']] as $cnt_field => $item_field){
				if ($cnt_field>0) {$xml .='@:::@';}
			$xml .= $item_field."@===@".str_replace(array("&",">","<"),array(" ","&gt;","&lt;"),$classind->$item_field);
		}
		$xml .= '</elemento>';
	}
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;		


} else{
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}
?>