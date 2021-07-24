<?php 

//print_r($_POST);
//die();
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
$a_table['ciee1']='cat_cie ce';
$a_table['ciee2']='cat_cie ce';
$a_table['ciee3']='cat_cie ce';
$a_table['ciee4']='cat_cie ce';
$a_table['ciee5']='cat_cie ce';
$a_table['ciee6']='cat_cie ce';
$a_table['ciee7']='cat_cie ce';
$a_table['ciee8']='cat_cie ce';
$a_table['ciee9']='cat_cie ce';
$a_table['ciee10']='cat_cie ce';
$a_table['ciee11']='cat_cie ce';
$a_table['ciee12']='cat_cie ce';
$a_table['ciee13']='cat_cie ce';
$a_table['ciee14']='cat_cie ce';
$a_table['ciee15']='cat_cie ce';
$a_table['ciee16']='cat_cie ce';
$a_table['ciee17']='cat_cie ce';
$a_table['ciee18']='cat_cie ce';
$a_table['ciee19']='cat_cie ce';
$a_table['ciee20']='cat_cie ce';
$a_table['ciee21']='cat_cie ce';
$a_table['ciee22']='cat_cie ce';
$a_table['ciee23']='cat_cie ce';
$a_table['ciee24']='cat_cie ce';
$a_table['ciee25']='cat_cie ce';
$a_table['ciee26']='cat_cie ce';
$a_table['ciee27']='cat_cie ce';
$a_table['ciee28']='cat_cie ce';




$a_fields=array();
$a_fields['ciee1']=array('cvecie','cvecied','descie');
$a_fields['ciee2']=array('cvecie2','cvecied2','descie2');
$a_fields['ciee3']=array('cvecie3','cvecied3','descie3');
$a_fields['ciee4']=array('cvecie4','cvecied4','descie4');
$a_fields['ciee5']=array('cvecie5','cvecied5','descie5');
$a_fields['ciee6']=array('cvecie6','cvecied6','descie6');
$a_fields['ciee7']=array('cvecie7','cvecied7','descie7');
$a_fields['ciee8']=array('cvecie8','cvecied8','descie8');
$a_fields['ciee9']=array('cvecie9','cvecied9','descie9');
$a_fields['ciee10']=array('cvecie10','cvecied10','descie10');
$a_fields['ciee11']=array('cvecie11','cvecied11','descie11');
$a_fields['ciee12']=array('cvecie12','cvecied12','descie12');
$a_fields['ciee13']=array('cvecie13','cvecied13','descie13');
$a_fields['ciee14']=array('cvecie14','cvecied14','descie14');
$a_fields['ciee15']=array('cvecie15','cvecied15','descie15');
$a_fields['ciee16']=array('cvecie16','cvecied16','descie16');
$a_fields['ciee17']=array('cvecie17','cvecied17','descie17');
$a_fields['ciee18']=array('cvecie18','cvecied18','descie18');
$a_fields['ciee19']=array('cvecie19','cvecied19','descie19');
$a_fields['ciee20']=array('cvecie20','cvecied20','descie20');
$a_fields['ciee21']=array('cvecie21','cvecied21','descie21');
$a_fields['ciee22']=array('cvecie22','cvecied22','descie22');
$a_fields['ciee23']=array('cvecie23','cvecied23','descie23');
$a_fields['ciee24']=array('cvecie24','cvecied24','descie24');
$a_fields['ciee25']=array('cvecie25','cvecied25','descie25');
$a_fields['ciee26']=array('cvecie26','cvecied26','descie26');
$a_fields['ciee27']=array('cvecie27','cvecied27','descie27');
$a_fields['ciee28']=array('cvecie28','cvecied28','descie28');






$a_fieldsValDef=array();
$a_fieldsValDef['ciee1']=array('','','');
$a_fieldsValDef['ciee2']=array('','','');
$a_fieldsValDef['ciee3']=array('','','');
$a_fieldsValDef['ciee4']=array('','','');
$a_fieldsValDef['ciee5']=array('','','');
$a_fieldsValDef['ciee6']=array('','','');
$a_fieldsValDef['ciee7']=array('','','');
$a_fieldsValDef['ciee8']=array('','','');
$a_fieldsValDef['ciee9']=array('','','');
$a_fieldsValDef['ciee10']=array('','','');
$a_fieldsValDef['ciee11']=array('','','');
$a_fieldsValDef['ciee12']=array('','','');
$a_fieldsValDef['ciee13']=array('','','');
$a_fieldsValDef['ciee14']=array('','','');
$a_fieldsValDef['ciee15']=array('','','');
$a_fieldsValDef['ciee16']=array('','','');
$a_fieldsValDef['ciee17']=array('','','');
$a_fieldsValDef['ciee18']=array('','','');
$a_fieldsValDef['ciee19']=array('','','');
$a_fieldsValDef['ciee20']=array('','','');
$a_fieldsValDef['ciee21']=array('','','');
$a_fieldsValDef['ciee22']=array('','','');
$a_fieldsValDef['ciee23']=array('','','');
$a_fieldsValDef['ciee24']=array('','','');
$a_fieldsValDef['ciee25']=array('','','');
$a_fieldsValDef['ciee26']=array('','','');
$a_fieldsValDef['ciee27']=array('','','');
$a_fieldsValDef['ciee28']=array('','','');


$a_strFields=array();
$a_strFields['ciee1']=" ce.id_cie as cvecie , ce.cvecie as cvecied  , ce.descie as descie ";
$a_strFields['ciee2']=" ce.id_cie as cvecie2 , ce.cvecie as cvecied2  , ce.descie as descie2 ";
$a_strFields['ciee3']=" ce.id_cie as cvecie3 , ce.cvecie as cvecied3  , ce.descie as descie3 ";
$a_strFields['ciee4']=" ce.id_cie as cvecie4 , ce.cvecie as cvecied4  , ce.descie as descie4 ";
$a_strFields['ciee5']=" ce.id_cie as cvecie5 , ce.cvecie as cvecied5  , ce.descie as descie5 ";
$a_strFields['ciee6']=" ce.id_cie as cvecie6 , ce.cvecie as cvecied6  , ce.descie as descie6 ";
$a_strFields['ciee7']=" ce.id_cie as cvecie7 , ce.cvecie as cvecied7  , ce.descie as descie7 ";
$a_strFields['ciee8']=" ce.id_cie as cvecie8 , ce.cvecie as cvecied8  , ce.descie as descie8 ";
$a_strFields['ciee9']=" ce.id_cie as cvecie9 , ce.cvecie as cvecied9  , ce.descie as descie9 ";
$a_strFields['ciee10']=" ce.id_cie as cvecie10 , ce.cvecie as cvecied10  , ce.descie as descie10 ";
$a_strFields['ciee11']=" ce.id_cie as cvecie11 , ce.cvecie as cvecied11  , ce.descie as descie11 ";
$a_strFields['ciee12']=" ce.id_cie as cvecie12 , ce.cvecie as cvecied12  , ce.descie as descie12 ";
$a_strFields['ciee13']=" ce.id_cie as cvecie13 , ce.cvecie as cvecied13  , ce.descie as descie13 ";
$a_strFields['ciee14']=" ce.id_cie as cvecie14 , ce.cvecie as cvecied14  , ce.descie as descie14 ";
$a_strFields['ciee15']=" ce.id_cie as cvecie15 , ce.cvecie as cvecied15  , ce.descie as descie15 ";
$a_strFields['ciee16']=" ce.id_cie as cvecie16 , ce.cvecie as cvecied16  , ce.descie as descie16 ";
$a_strFields['ciee17']=" ce.id_cie as cvecie17 , ce.cvecie as cvecied17  , ce.descie as descie17 ";
$a_strFields['ciee18']=" ce.id_cie as cvecie18 , ce.cvecie as cvecied18  , ce.descie as descie18 ";
$a_strFields['ciee19']=" ce.id_cie as cvecie19 , ce.cvecie as cvecied19  , ce.descie as descie19 ";
$a_strFields['ciee20']=" ce.id_cie as cvecie20 , ce.cvecie as cvecied20  , ce.descie as descie20 ";
$a_strFields['ciee21']=" ce.id_cie as cvecie21 , ce.cvecie as cvecied21  , ce.descie as descie21 ";
$a_strFields['ciee22']=" ce.id_cie as cvecie22 , ce.cvecie as cvecied22  , ce.descie as descie22 ";
$a_strFields['ciee23']=" ce.id_cie as cvecie23 , ce.cvecie as cvecied23  , ce.descie as descie23 ";
$a_strFields['ciee24']=" ce.id_cie as cvecie24 , ce.cvecie as cvecied24  , ce.descie as descie24 ";
$a_strFields['ciee25']=" ce.id_cie as cvecie25 , ce.cvecie as cvecied25  , ce.descie as descie25 ";
$a_strFields['ciee26']=" ce.id_cie as cvecie26 , ce.cvecie as cvecied26  , ce.descie as descie26 ";
$a_strFields['ciee27']=" ce.id_cie as cvecie27 , ce.cvecie as cvecied27  , ce.descie as descie27 ";
$a_strFields['ciee28']=" ce.id_cie as cvecie28 , ce.cvecie as cvecied28  , ce.descie as descie28 ";



$a_fieldsCond0=array();
$a_fieldsCond0['ciee1']=array('descie');
$a_fieldsCond0['ciee2']=array('descie2');
$a_fieldsCond0['ciee3']=array('descie3');
$a_fieldsCond0['ciee4']=array('descie4');
$a_fieldsCond0['ciee5']=array('descie5');
$a_fieldsCond0['ciee6']=array('descie6');
$a_fieldsCond0['ciee7']=array('descie7');
$a_fieldsCond0['ciee8']=array('descie8');
$a_fieldsCond0['ciee9']=array('descie9');
$a_fieldsCond0['ciee10']=array('descie10');
$a_fieldsCond0['ciee11']=array('descie11');
$a_fieldsCond0['ciee12']=array('descie12');
$a_fieldsCond0['ciee13']=array('descie13');
$a_fieldsCond0['ciee14']=array('descie14');
$a_fieldsCond0['ciee15']=array('descie15');
$a_fieldsCond0['ciee16']=array('descie16');
$a_fieldsCond0['ciee17']=array('descie17');
$a_fieldsCond0['ciee18']=array('descie18');
$a_fieldsCond0['ciee19']=array('descie19');
$a_fieldsCond0['ciee20']=array('descie20');
$a_fieldsCond0['ciee21']=array('descie21');
$a_fieldsCond0['ciee22']=array('descie22');
$a_fieldsCond0['ciee23']=array('descie23');
$a_fieldsCond0['ciee24']=array('descie24');
$a_fieldsCond0['ciee25']=array('descie25');
$a_fieldsCond0['ciee26']=array('descie26');
$a_fieldsCond0['ciee27']=array('descie27');
$a_fieldsCond0['ciee28']=array('descie28');

$a_fieldsCond1=array();
$a_fieldsCond1['ciee1']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee2']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee3']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee4']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee5']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee6']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee7']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee8']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee9']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee10']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee11']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee12']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee13']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee14']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee15']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee16']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee17']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee18']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee19']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee20']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee21']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee22']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee23']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee24']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee25']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee26']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee27']=array(array('ce.cvecie','ce.descie'));
$a_fieldsCond1['ciee28']=array(array('ce.cvecie','ce.descie'));


$a_fieldsConTtype=array();
$a_fieldsConTtype['ciee1']=array('text','text');
$a_fieldsConTtype['ciee2']=array('text','text');
$a_fieldsConTtype['ciee3']=array('text','text');
$a_fieldsConTtype['ciee4']=array('text','text');
$a_fieldsConTtype['ciee5']=array('text','text');
$a_fieldsConTtype['ciee6']=array('text','text');
$a_fieldsConTtype['ciee7']=array('text','text');
$a_fieldsConTtype['ciee8']=array('text','text');
$a_fieldsConTtype['ciee9']=array('text','text');
$a_fieldsConTtype['ciee10']=array('text','text');
$a_fieldsConTtype['ciee11']=array('text','text');
$a_fieldsConTtype['ciee12']=array('text','text');
$a_fieldsConTtype['ciee13']=array('text','text');
$a_fieldsConTtype['ciee14']=array('text','text');
$a_fieldsConTtype['ciee15']=array('text','text');
$a_fieldsConTtype['ciee16']=array('text','text');
$a_fieldsConTtype['ciee17']=array('text','text');
$a_fieldsConTtype['ciee18']=array('text','text');
$a_fieldsConTtype['ciee19']=array('text','text');
$a_fieldsConTtype['ciee20']=array('text','text');
$a_fieldsConTtype['ciee21']=array('text','text');
$a_fieldsConTtype['ciee22']=array('text','text');
$a_fieldsConTtype['ciee23']=array('text','text');
$a_fieldsConTtype['ciee24']=array('text','text');
$a_fieldsConTtype['ciee25']=array('text','text');
$a_fieldsConTtype['ciee26']=array('text','text');
$a_fieldsConTtype['ciee27']=array('text','text');
$a_fieldsConTtype['ciee28']=array('text','text');

$a_condOper=array();
$a_condOper['ciee1']=array(array('like','like'));
$a_condOper['ciee2']=array(array('like','like'));
$a_condOper['ciee3']=array(array('like','like'));
$a_condOper['ciee4']=array(array('like','like'));
$a_condOper['ciee5']=array(array('like','like'));
$a_condOper['ciee6']=array(array('like','like'));
$a_condOper['ciee7']=array(array('like','like'));
$a_condOper['ciee8']=array(array('like','like'));
$a_condOper['ciee9']=array(array('like','like'));
$a_condOper['ciee10']=array(array('like','like'));
$a_condOper['ciee11']=array(array('like','like'));
$a_condOper['ciee12']=array(array('like','like'));
$a_condOper['ciee13']=array(array('like','like'));
$a_condOper['ciee14']=array(array('like','like'));
$a_condOper['ciee15']=array(array('like','like'));
$a_condOper['ciee16']=array(array('like','like'));
$a_condOper['ciee17']=array(array('like','like'));
$a_condOper['ciee18']=array(array('like','like'));
$a_condOper['ciee19']=array(array('like','like'));
$a_condOper['ciee20']=array(array('like','like'));
$a_condOper['ciee21']=array(array('like','like'));
$a_condOper['ciee22']=array(array('like','like'));
$a_condOper['ciee23']=array(array('like','like'));
$a_condOper['ciee24']=array(array('like','like'));
$a_condOper['ciee25']=array(array('like','like'));
$a_condOper['ciee26']=array(array('like','like'));
$a_condOper['ciee27']=array(array('like','like'));
$a_condOper['ciee28']=array(array('like','like'));


$a_Order=array();
$a_Order['ciee1']=array('descie');
$a_Order['ciee2']=array('descie2');
$a_Order['ciee3']=array('descie3');
$a_Order['ciee4']=array('descie4');
$a_Order['ciee5']=array('descie5');
$a_Order['ciee6']=array('descie6');
$a_Order['ciee7']=array('descie7');
$a_Order['ciee8']=array('descie8');
$a_Order['ciee9']=array('descie9');
$a_Order['ciee10']=array('descie10');
$a_Order['ciee11']=array('descie11');
$a_Order['ciee12']=array('descie12');
$a_Order['ciee13']=array('descie13');
$a_Order['ciee14']=array('descie14');
$a_Order['ciee15']=array('descie15');
$a_Order['ciee16']=array('descie16');
$a_Order['ciee17']=array('descie17');
$a_Order['ciee18']=array('descie18');
$a_Order['ciee19']=array('descie19');
$a_Order['ciee20']=array('descie20');
$a_Order['ciee21']=array('descie21');
$a_Order['ciee22']=array('descie22');
$a_Order['ciee23']=array('descie23');
$a_Order['ciee24']=array('descie24');
$a_Order['ciee25']=array('descie25');
$a_Order['ciee26']=array('descie26');
$a_Order['ciee27']=array('descie27');
$a_Order['ciee28']=array('descie28');




$a_strWhere=array();
$a_strWhere['ciee1']="";
$a_strWhere['ciee2']="";
$a_strWhere['ciee3']="";
$a_strWhere['ciee4']="";
$a_strWhere['ciee5']="";
$a_strWhere['ciee6']="";
$a_strWhere['ciee7']="";
$a_strWhere['ciee8']="";
$a_strWhere['ciee9']="";
$a_strWhere['ciee10']="";
$a_strWhere['ciee11']="";
$a_strWhere['ciee12']="";
$a_strWhere['ciee13']="";
$a_strWhere['ciee14']="";
$a_strWhere['ciee15']="";
$a_strWhere['ciee16']="";
$a_strWhere['ciee17']="";
$a_strWhere['ciee18']="";
$a_strWhere['ciee19']="";
$a_strWhere['ciee20']="";
$a_strWhere['ciee21']="";
$a_strWhere['ciee22']="";
$a_strWhere['ciee23']="";
$a_strWhere['ciee24']="";
$a_strWhere['ciee25']="";
$a_strWhere['ciee26']="";
$a_strWhere['ciee27']="";
$a_strWhere['ciee28']="";


$a_strGroup=array();
$a_strGroup['ciee1']="";
$a_strGroup['ciee2']="";
$a_strGroup['ciee3']="";
$a_strGroup['ciee4']="";
$a_strGroup['ciee5']="";
$a_strGroup['ciee6']="";
$a_strGroup['ciee7']="";
$a_strGroup['ciee8']="";
$a_strGroup['ciee9']="";
$a_strGroup['ciee10']="";
$a_strGroup['ciee11']="";
$a_strGroup['ciee12']="";
$a_strGroup['ciee13']="";
$a_strGroup['ciee14']="";
$a_strGroup['ciee15']="";
$a_strGroup['ciee16']="";
$a_strGroup['ciee17']="";
$a_strGroup['ciee18']="";
$a_strGroup['ciee19']="";
$a_strGroup['ciee20']="";
$a_strGroup['ciee21']="";
$a_strGroup['ciee22']="";
$a_strGroup['ciee23']="";
$a_strGroup['ciee24']="";
$a_strGroup['ciee28']="";
$a_strGroup['ciee26']="";
$a_strGroup['ciee27']="";
$a_strGroup['ciee28']="";




//	
//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	
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
	//die($strWhere);
	
$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';

	$classind->ListaEntidades($a_Order[$_POST['entvalue']],$a_table[$_POST['entvalue']],$strWhere,$a_strFields[$_POST['entvalue']]);
	//echo "<pre>";
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
