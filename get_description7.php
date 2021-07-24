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
$a_table['unidad_usuario']=array('unidad');
$a_lbl=array();
$a_lbl['equipo']='';
$field=array();
	$field[]=array('desuni','unidad_solicitante','1','label','1','','char','','u',20,0,'',0,0,0,'','',1,1,1);
		

$a_fieldsXtmp=array();

$sqlQryFields="select u.desuni";
$sqlQryFrom=" from ";
$sqlQryWhere=" where ";
$sqlQryOrder=" order by u.desuni";


	$allfields=array();
	$allvalues=array();
	foreach ($field as $afield){
		$allfields[]=$afield[0];
		$allvalues[]=$afield[7];
	}
	$bdate=0;
	$strCondConsul="";
   $classind = new Entidad($allfields,$allvalues);
   $avalues=array();
   $afields=array();
	foreach ($field as $afield){
		if ($afield[4]=='1'){
			$afields[]=$afield[0];
			if (isset($_POST[$afield[1]]) && strlen(trim($_POST[$afield[1]]))>0){
				if (strlen($strCondConsul)>0) 
					$strCondConsul.=" and ";
				switch ($afield[6]){
					case in_array($afield[6],array('char','mail','nombre','ip','date')):
						$strCondConsul.=$afield[8].'.'.$afield[0]." like '%".$_POST[$afield[1]]."%'";
					break;
					case in_array($afield[6],array('int','money')):
						$strCondConsul.=$afield[8].'.'.$afield[0]."=".$_POST[$afield[1]];
					break;
				}
			}
		}
	}

$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';
foreach ($a_table[$_POST['entvalue']] as $tableItem){
	$sqlQry= $sqlQryFields.$sqlQryFrom . ' ' . $tableItem . ' u' .$sqlQryWhere. $strCondConsul . $sqlQryOrder;
	//$classind->Consultar($afields,$IdPrin,$tableItem,'',$sqlQry);
	$classind->ListaEntidades(array(),$tableItem,"",'','','',$sqlQry,'');
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$afields);
		$xml .= '<elemento>';
		foreach ($field as $cnt_field => $item_field){
			if ($item_field[2]==2){$xml .=$classind->$item_field[0].'@:::@';}else{$xml .= str_replace(array("&",">","<"),array("&amp;","&gt;","&lt;"),$classind->$item_field[0]);}
		}
		$xml .= '</elemento>';
	}
}
////////////////////////////////////////////////
$a_table=array();
$a_table['unidad_usuario']=array('ticket');
$a_lbl=array();
$a_lbl['unidad_usuario']='';
$field=array();
	$field[]=array('unidad_solicitante','unidad_solicitante','1','label','1','','char','','t',20,0,'',0,0,0,'','',1,1,1);	

$a_fieldsXtmp=array();

$sqlQryFields="select distinct(t.unidad_solicitante)";
$sqlQryFrom=" from ";
$sqlQryWhere=" where ";
$sqlQryOrder=" order by t.unidad_solicitante";


	$allfields=array();
	$allvalues=array();
	foreach ($field as $afield){
		$allfields[]=$afield[0];
		$allvalues[]=$afield[7];
	}
	$bdate=0;
	$strCondConsul="";
   $classind = new Entidad($allfields,$allvalues);
   $avalues=array();
   $afields=array();
	foreach ($field as $afield){
		if ($afield[4]=='1'){
			$afields[]=$afield[0];
			if (isset($_POST[$afield[1]]) && strlen(trim($_POST[$afield[1]]))>0){
				if (strlen($strCondConsul)>0) 
					$strCondConsul.=" and ";
				switch ($afield[6]){
					case in_array($afield[6],array('char','mail','nombre','ip','date')):
						$strCondConsul.=$afield[8].'.'.$afield[0]." like '%".$_POST[$afield[1]]."%'";
					break;
					case in_array($afield[6],array('int','money')):
						$strCondConsul.=$afield[8].'.'.$afield[0]."=".$_POST[$afield[1]];
					break;
				}
			}
		}
	}

foreach ($a_table[$_POST['entvalue']] as $tableItem){
	$sqlQry= $sqlQryFields.$sqlQryFrom . ' ' . $tableItem . ' t' .$sqlQryWhere. $strCondConsul . $sqlQryOrder;
	//$classind->Consultar($afields,$IdPrin,$tableItem,'',$sqlQry);
	$classind->ListaEntidades(array(),$tableItem,"",'','','',$sqlQry,'');
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$afields);
		$xml .= '<elemento>';
		foreach ($field as $cnt_field => $item_field){
			if ($item_field[2]==2){$xml .=$classind->$item_field[0].'@:::@';}else{$xml .= str_replace(array("&",">","<"),array("&amp;","&gt;","&lt;"),$classind->$item_field[0]);}
		}
		$xml .= '</elemento>';
	}
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