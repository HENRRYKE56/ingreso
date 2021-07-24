<?php 
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css" >
	.arial11px{
	font-family:Arial, Helvetica, sans-serif;
	color:#666666;
	font-size:11px;
	}
	.arial11pxCenter{
	font-family:Arial, Helvetica, sans-serif;
	color:#666666;
	font-size:11px;
	text-align:center;
	}
	.arial11pxRight{
	font-family:Arial, Helvetica, sans-serif;
	color:#666666;
	font-size:11px;
	text-align:right;
	}
	.arial11pxbold{
	font-family:Arial, Helvetica, sans-serif;
	color:#000066;
	font-variant:small-caps;
	font-size:11px;
	font-weight:bold;
	}
	.arial11pxboldC{
	font-family:Arial, Helvetica, sans-serif;
	color:#3A3A3A;
	font-size:11px;
	font-weight:bold;
	text-align:center;
	}
	a:link, a:hover, a:visited, a:active{
	color:#336600;
	font
	}
</style>
<style type="text/css">
body{
	/*background-color:#FCFFE8;*/
	margin-bottom:0px;
	margin-left:0px;
	margin-right:0px;
	margin-top:0px;
}

</style>
<script type="text/javascript">
			function openInIframe2 (URL){
				//window.parent.document.location.href = URL;
				window.parent.frames.miiframe2.location.href = URL;
				window.parent.document.getElementById('miiframe').style.width = "500";
				window.parent.document.getElementById('miiframe2').style.width="500";
			}
			function abrir (URL){ 
				
				winform=window.open('',"_blank","top=280,left=180,width=570,height=230,status=no,"
										+"resizable=yes,location=no,menubar=no,titlebar=no,toolbar=no",false)
				winform.window.location.assign(URL)
				winform.focus();
			}	
			
			function abrir2 (URL){ 
				
				winform=window.open(URL,"_new","top=280,left=180,width=570,height=230,status=no,"
										+"resizable=yes,location=no,menubar=no,titlebar=no,toolbar=no",false)
				winform.window.location.assign(URL)
				winform.focus();
			}
</script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REPORTE</title>
</head>
<body>
<?php

include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/lib32.php");
$CFG_STYLE_DEF='arial11px';
$CFG_STYLE_NUM='arial11pxRight';
$CFG_STYLE_DATE='arial11pxCenter';

if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
$strParamGet="";
foreach ($_GET as $item=>$value){
	if (strlen($strParamGet)>0)
		$strParamGet.="&";
	$strParamGet.=$item."=".$value;
}
include_once($_GET['fparam'].".php");


require('lib/Reporte.php');
//$mibase= new MySqlCon('localhost','root','','encuesta');
//$mibase->Consulta("select * from modulo order by cve_modulo");
//$miresult=$mibase->getRstSQL();
//$rows=$mibase->getNumRows();
if (isset($str_Qry) && strlen(trim($str_Qry))>0){

$resultado=array();
$classent = new Entidad($a_getn_fields,$a_getv_fields);
$classent->ListaEntidades(array(),"","","","no","",$str_Qry);


//echo "<pre>";
//print_r($classent);
//echo "</pre>";

$strlink01="<a href='rep_todos.php?".((isset($str_drill_def) and strlen(trim($str_drill_def))>0)?$str_drill_def.'&':'');
$strlink02="'>";
$strlink03="</a>";
$boolDrill=false;
$boolGrp=false;
$boolFormatCol=false;
if (isset($array_drill) && count($array_drill)>0) $boolDrill=true;
if (isset($array_grp) && count($array_grp)>0) $boolGrp=true;
if (isset($array_format_col) && count($array_format_col)>0) $boolFormatCol=true;
$array_format_cols=array();
if ($boolFormatCol){
	foreach($array_format_col as $item_format_col){
			$array_format_cols[$item_format_col[0]]=0;
		}
}
$a_XtmpResult=array();
for ($i=0; $i<$classent->NumReg; $i++){
	$a_XtmpResult=$classent->getRow($i,$a_getn_fields,$no_print);
	//$a_XtmpResult[0]=$i+1;
	if (isset($boolreplaceLn) and $boolreplaceLn){
		foreach($a_XtmpResult as $xTmpName => $xTmpValue)
			$a_XtmpResult[$xTmpName]=replaceLnxBr($xTmpValue);
	}
	$resultado[]=$a_XtmpResult;
	if ($boolFormatCol){
		foreach($array_format_col as $item_format_col){
			$getValorCell0=$resultado[$i][$item_format_col[0]];
			$array_format_cols[$item_format_col[0]]+=($getValorCell0*1);
			eval('$getValorCell='.$item_format_col[1].'($getValorCell0);');
			$resultado[$i][$item_format_col[0]]= $getValorCell;
		}
	}
	
	if ($boolDrill) {
		foreach($array_drill as $item_drill){
			$tmp_val_drill=$resultado[$i][$item_drill[0]];
			$resultado[$i][$item_drill[0]]=$strlink01 . $item_drill[2] ; 
			foreach($item_drill[1] as $cnt_item_item => $item_drill_item){
			/*****************************/
				$resultado[$i][$item_drill[0]].= "&". $item_drill[4][$cnt_item_item] . "=" . $classent->$item_drill_item;
			}
			$resultado[$i][$item_drill[0]].= $strlink02 . $tmp_val_drill . $strlink03;
		}
	}
}
}
//	echo "<pre>";
//print_r($a_getn_fields);
//echo "</pre>";

$a_array_suma_col=array();
if (sizeof($array_format_cols)>0){
$str_total="<span style='font-weight:bold; color:#000;'>TOTAL</span>";
$readyTotal=false;
if (sizeof($resultado)>0){
foreach ($resultado[$i-1] as $cnr_col => $item_col){

	if (isset($array_format_cols[$cnr_col])){
		$a_array_suma_col[$cnr_col]=format_num($array_format_cols[$cnr_col]);}
	else{if(!$readyTotal){$a_array_suma_col[$cnr_col]=$str_total; $readyTotal=true;}else{$a_array_suma_col[$cnr_col]='';}}	
}
}
//if (sizeof($array_format_cols)>0)
$resultado[$i]=$a_array_suma_col;
}

//$periodo='';
//$periodo=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))?' DEL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))):'';
//$periodo.=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))?' AL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))):'';

$a_head=array();
$barra="<a href=\"rep_xls.php?".$strParamGet."\"><img src=\"../img/img30.gif\" border =\"0\" /></a>"
		 .(($boolPDF)?"<a href=\"javascript:abrir2('reppdf.php?".$strParamGet."')\"><img src=\"../img/img32.gif\" border =\"0\" /></a>":'');
$a_head[]=array($barra);//explode(':::',$barra);	 
$mireporte= new Reporte(array('width'=>'100%','border'=>'0','cellpadding'=>'0','cellspacing'=>'0', 'background'=>"../img/bg06.gif"));
$mireporte->setTitulos(array('',''));
$mireporte->SetDefaultCellAttributes (array('style'=>'font-size:10px;'));
$mireporte->setDatos($a_head);
$mireporte->displayDatos(array(),array(),'no');

/*foreach ($CFG_TABLA_FIELD as $ITEM_CFG_TABLA_FIELD){
	
	if (isset ($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]])){
		$classconsul = new Entidad($ITEM_CFG_TABLA_FIELD[3],array(''));
		$strWhere="";
		foreach ($ITEM_CFG_TABLA_FIELD[2] as $cnt_tmp => $VALUE_ITEM_CFG_TABLA_FIELD ){
			if (strlen($strWhere)>0)
				$strWhere.=" and ";
				if ($ITEM_CFG_TABLA_FIELD[6][$cnt_tmp]=='num'){
					$strWhere.=$VALUE_ITEM_CFG_TABLA_FIELD . "=" . trim($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]]);}
				else{
					$strWhere.=$VALUE_ITEM_CFG_TABLA_FIELD . "='" . trim($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]])."'";}
		}
		$strWhere="Where ".$strWhere;
//		echo $strWhere;
		$classconsul->ListaEntidades(array(),$ITEM_CFG_TABLA_FIELD[4],$strWhere,$ITEM_CFG_TABLA_FIELD[3][0],"no");
		$classconsul->VerDatosEntidad(0,$ITEM_CFG_TABLA_FIELD[3]);
		$a_head[]=array($ITEM_CFG_TABLA_FIELD[0],$classconsul->$ITEM_CFG_TABLA_FIELD[3][0]);
	}
}*/ //COMENTO INTERUMPE LA CREACION DE ENCABEZADOS DINAMICOS
$mireporte= new Reporte(array('width'=>'100%','border'=>'0','cellpadding'=>'0','cellspacing'=>'1'));
$mireporte->setTitulos(array('',''));
$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>'20'));
$mireporte->setDatos($a_head0);
$mireporte->SetColAttributesR ( 2,array('style'=>''));
$mireporte->displayDatos(array(),array('class'=>'arial11pxboldC'),'no');
//echo "</BR>";
$mireporte= new Reporte(array('width'=>($WIDTH_TABLE>$WIDTH_TABLE_DEF?$WIDTH_TABLE:$WIDTH_TABLE_DEF),'border'=>'0','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#336600'));
$mireporte->setTitulos($a_getl_fields);

if(sizeof($resultado)>0){
$mireporte->setDatos($resultado);
}else{
foreach($a_getl_fields as $tmpx){
	$resultado[]='&nbsp;';
}
$mireporte->setDatos(array($resultado));
}
$cnt_xTemp=1;

//DEBO DELCARAR UN ARRAY DE TIPO DE DATOS
foreach ($tipo_datos_fields as $i_c => $element_rep){
	if (!in_array($i_c,$no_print)){
		switch($element_rep[4]){
			case 'num':
				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_NUM));
				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
			break;
			case 'date':
				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_DATE));
				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
			break;
			default:
				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_DEF));
				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
			break;
		}
		$cnt_xTemp+=1;
	}
} 
if(isset($pos)&& sizeof($pos)>0){
	foreach ($pos as $itempos){
		
		$mireporte->SetCellAttributesR($itempos,1,array('align'=>'center','bgcolor'=>'#FFF','class'=>'arial11pxbold'));
		for($k=1;$k<sizeof($a_getl_fields)+1;$k++){
	
		$mireporte->SetCellAttributesR($itempos+1,$k,array('align'=>'center','bgcolor'=>'#E4F1BE','class'=>'arial11pxbold'));
		}
		
	}
}
if(isset($boolsincabecera) and $boolsincabecera){
	$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#E4F1BE','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFCC','class'=>'arial11px'),'no',array(),((isset($collsp) && sizeof($collsp)>0)?$collsp:array()));
}else{
	if(isset($collsp) && sizeof($collsp)){
	$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#E4F1BE','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFCC','class'=>'arial11px'),'yes',array(),((isset($collsp) && sizeof($collsp)>0)?$collsp:array()));}else{
		$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#E4F1BE','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFCC','class'=>'arial11px'));
	}

}

}
//echo "<div class='arial11pxbold' style='font-style: italic; display:block;'>resultado:&nbsp;".(isset(	$secuencialx)?	$secuencialx:($classent->NumReg))." registros.</div>";
?>


</body>
</html>