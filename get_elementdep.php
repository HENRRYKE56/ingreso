<?php

include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
include_once("lib/lib_function.php");
include_once("rep/lib/lib32.php");


$a_table = array();
//tabla evento
$a_table['desArea'] = ' area a ';


$a_fields = array();
//tabla evento
$a_fields['desArea'] = array('cveArea', 'desArea');

$a_fieldsValDef = array();
//tabla evento
$a_fieldsValDef['desArea'] = array('', '');

$a_strFields = array();
//tabla evento
$a_strFields['desArea'] = 'a.cveArea, a.desArea';

$a_fieldsCond0 = array();
//tabla evento
$a_fieldsCond0['desArea'] = array('desArea');

$a_fieldsCond1 = array();
//tabla evento
$a_fieldsCond1['desArea'] = array('a.desArea');

$a_fieldsConTtype = array();
//tabla evento
$a_fieldsConTtype['desArea'] = array('text');

$a_condOper = array();
//tabla evento
$a_condOper['desArea'] = array('like');

$a_Order = array();
//tabla evento
$a_Order['desArea'] = array('a.desArea');

$a_strWhere = array();
//tabla evento
$a_strWhere['desArea'] = " a.sta_area=1";

$a_strGroup = array();
//tabla evento
$a_strGroup['desArea'] = "";

//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	

$strWhere = $a_strWhere[$_POST['entvalue']];

$classind = new Entidad($a_fields[$_POST['entvalue']], $a_fieldsValDef[$_POST['entvalue']]);
foreach ($a_fieldsCond0[$_POST['entvalue']] as $cnt_afield => $afield) {
    if (strlen($strWhere) > 0) {
        $strWhere.=" and ";
    }
    switch ($a_fieldsConTtype[$_POST['entvalue']][$cnt_afield]) {
        case 'text':
            if ($a_condOper[$_POST['entvalue']][$cnt_afield] == 'like') {
                $strWhere.=" " . $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " '%" . addslashes($_POST[$afield]) . "%'";
            } else {
                $strWhere.=" " . $afield . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " '" . addslashes($_POST[$afield]) . "'";
            }
            break;
        case 'num':
            $strWhere.=" " . $afield . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " " . addslashes($_POST[$afield]);
            break;
    }
}
if (strlen($strWhere) > 0)
    $strWhere = " Where " . $strWhere;

$xml = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';
$classind->ListaEntidades($a_Order[$_POST['entvalue']], $a_table[$_POST['entvalue']], $strWhere, $a_strFields[$_POST['entvalue']]);

for ($i = 0; $i < $classind->NumReg; $i++) {/////##########################################///////////
    $classind->VerDatosEntidad($i, $a_fields[$_POST['entvalue']], FALSE);
    $xml .= '<elemento>';
    foreach ($a_fields[$_POST['entvalue']] as $cnt_field => $item_field) {
        if ($cnt_field > 0) {
            $xml .='@:::@';
        }

        $xml .= $item_field."@===@".str_replace(array("&",">","<"),array(" ","&gt;","&lt;"),$classind->$item_field);
    }
    $xml .= '</elemento>';
}
//     print_r($classind);
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;
die();
?>
