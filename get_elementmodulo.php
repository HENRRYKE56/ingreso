<?php 
                       

session_start();
$str_check=FALSE;

include_once("config/cfg.php");

include_once("includes/sb_check.php");

if ($str_check) {
       
	
	include_once("lib/lib_pgsql.php");
	include_once("lib/lib_entidad.php");
	include_once("lib/lib_function.php");
	include_once("rep/lib/lib32.php");

   
$a_table=array();
//tabla evento
$a_table['des_modulo_padre']='sb_modulo m ';


$a_fields=array();
//tabla evento
$a_fields['des_modulo_padre']=array('des_modulo','cve_modulo');

$a_fieldsValDef=array();
//tabla evento
$a_fieldsValDef['des_modulo_padre']=array('', '');

$a_strFields=array();
//tabla evento
$a_strFields['titulo_desc']='m.des_modulo_padre, m.cve_modulo_padre';

$a_fieldsCond0=array();
//tabla evento
$a_fieldsCond0['des_modulo_padre']=array('des_modulo_padre');

$a_fieldsCond1=array();
//tabla evento
$a_fieldsCond1['des_modulo_padre']=array('m.des_modulo');

$a_fieldsConTtype=array();
//tabla evento
$a_fieldsConTtype['des_modulo_padre']=array('text');

$a_condOper=array();
//tabla evento
$a_condOper['des_modulo_padre']=array('like');

$a_Order=array();
//tabla evento
$a_Order['des_modulo_padre']=array('m.des_modulo');

$a_strWhere=array();
//tabla evento
$a_strWhere['des_modulo_padre']="";

$a_strGroup=array();
//tabla evento
$a_strGroup['des_modulo_padre']="";

//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	

	$strWhere= $a_strWhere[$_POST['entvalue']];
    
    $classind = new Entidad($a_fields[$_POST['entvalue']],$a_fieldsValDef[$_POST['entvalue']]);
	foreach ($a_fieldsCond0[$_POST['entvalue']] as $cnt_afield => $afield){    
		if (strlen($strWhere)>0){$strWhere.=" and ";}
		switch( $a_fieldsConTtype[$_POST['entvalue']][$cnt_afield]){
			case 'text':
				if  ($a_condOper[$_POST['entvalue']][$cnt_afield]=='like'){$strWhere.=" ".  $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '%" .  addslashes($_POST[$afield]) . "%'";}
				else{$strWhere.=" ". $afield . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '" . addslashes($_POST[$afield]) . "'";}
			break;
			case 'num':
				$strWhere.=" ". $afield . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." " .  addslashes($_POST[$afield]);
			break;
		}
		
	}
	if (strlen($strWhere)>0) $strWhere = " Where " . $strWhere;
	
        


//	echo "<pre>";	
//	print_r($strWhere);
//	echo "</pre>";	//$classconsul->NumReg; &amp;
//die();
$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';
	$classind->ListaEntidades($a_Order[$_POST['entvalue']],$a_table[$_POST['entvalue']],$strWhere,$a_strFields[$_POST['entvalue']]);
       // $classind->ListaEntidades("descripcion_esc","cat_escolaridad"," where id_escolaridad<4 ","descripcion_esc");
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$a_fields[$_POST['entvalue']], FALSE);
		$xml .= '<elemento>';
		foreach ($a_fields[$_POST['entvalue']] as $cnt_field => $item_field){
				if ($cnt_field>0) {$xml .='@:::@';}
                                
			$xml .= ($item_field=="des_modulo"?'des_modulo_padre':($item_field=="cve_modulo"?'cve_modulo_padre':$item_field))."@===@".str_replace(array("&",">","<"),array(" ","&gt;","&lt;"),$classind->$item_field);
		}
		$xml .= '</elemento>';
	}
   //     print_r($classind);
$xml .= '</datos>';      
header('Content-type: text/xml');
echo $xml;die();		


} else{
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}
?>
