<?php
session_start(); 
include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/lib32.php");
$CFG_STYLE_DEF='arial11px';
$CFG_STYLE_NUM='arial11pxRight';
$CFG_STYLE_DATE='arial11pxCenter';
if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
include_once($_GET['fparam'].".php");
require('lib/Reporte.php');

header("Pragma: ");
header("Cache-Control: ");

//header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
//header("Content-type: application/vnd.ms-excel");

header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");
//header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=".$_GET['fparam'].".xls" );
//header ("Content-Description: PHP/INTERBASE Generated Data" );
?>
<head>
<style type="text/css" >
	.arial11px{
	font-family:Arial, Helvetica, sans-serif;
	color:#666666;
	font-size:11px;
	}
	.arial11pxnormal{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	font-weight:normal;
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
	color:#000000;
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
	.arial11pxGrayC{
	font-family:Arial, Helvetica, sans-serif;
	color:#999;
	font-size:11px;
	font-weight:normal;
	text-align:center;
	}
	a:link, a:hover, a:visited, a:active{
	color:#336600;
	font
	}
	.arial11px_azul_c{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#0070C0;
	color:#FFFFFF;
	font-size:11px;
	text-align:center;
	}
	.arial11px_verde_c{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#76933C;
	color:#FFFFFF;
	font-size:11px;
	text-align:center;
	}
	.arial11px_azul{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#0070C0;
	color:#FFFFFF;
	font-size:11px;
	text-align:right;
	}
	.arial11px_verde{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#76933C;
	color:#FFFFFF;
	font-size:11px;
	text-align:right;
	}
	.arial11px_azul0{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#8DB4E2;
	color:#000000;
	font-size:11px;
	text-align:right;
	}
	.arial11px_white{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#FFFFFF;
	color:#000000;
	font-size:11px;
	text-align:right;
	}
		.arial11px_naranja{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#E37326;
	color:#FFFFFF;
	font-size:11px;
	text-align:center;
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<?php

//session_start(); 
//include_once("../config/cfg.php");
//include_once("../lib/lib_pgsql.php");
//include_once("../lib/lib_entidad.php");
//include_once("lib/lib32.php");
//$CFG_STYLE_DEF='arial11px';
//$CFG_STYLE_NUM='arial11pxRight';
//$CFG_STYLE_DATE='arial11pxCenter';
//if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
//include_once($_GET['fparam'].".php");
//require('lib/Reporte.php');



$A_CFGTIT=array('align'=>'center','bgcolor'=>'#F1EFED','class'=>'arial10pxup');
$A_CFGALLROWS=array('bgcolor'=>'#FFFFFF','class'=>'arial10px');
if (isset($str_Qry) && strlen(trim($str_Qry))>0){
$resultado=array();
$classent = new Entidad($a_getn_fields,$a_getv_fields);
$classent->ListaEntidades(array(),"","","","no","",$str_Qry);
$strParamGet="";
foreach ($_GET as $item=>$value){
		if (strlen($strParamGet)>0)
			$strParamGet.="&";
		$strParamGet.=$item."=".$value;
		}
//echo "<pre>";
//print_r($classent);
//echo "</pre>";
$strlink01="<a href='rep_con.php?";
$strlink02="'>";
$strlink03="</a>";
$boolDrill=false;
$boolFormatCol=false;
$boolvalArray=false;
//if (count($array_drill)>0) $boolDrill=true;$in_valArray
if (isset($in_valArray) && count($in_valArray)>0) $boolvalArray=true;
if (isset($array_format_col) && count($array_format_col)>0) $boolFormatCol=true;
$array_format_cols=array();
if ($boolFormatCol){
	foreach($array_format_col as $item_format_col){
			$array_format_cols[$item_format_col[0]]=0;
		}
}
for ($i=0; $i<$classent->NumReg; $i++){
	$a_XtmpResult=$classent->getRow($i,$a_getn_fields,$no_print);
	if(isset($boolreplaceFirstCol) && !$boolreplaceFirstCol){}else{
	$a_XtmpResult[0]="SSA_".str_pad($i+1, 10, "0", STR_PAD_LEFT);}
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
//echo "<pre>";
//print_r($in_valArray);
//echo "</pre>";
	if($boolvalArray){
		foreach($in_valArray as $item_valArray){
			if (!is_null($resultado[$i][$item_valArray]))
			$resultado[$i][$item_valArray]=${$field_rep[$item_valArray][15]}[$resultado[$i][$item_valArray]];
//echo "<pre>s";
//print_r($resultado[$i][$item_valArray]);
//echo "</pre>";
//
//echo "<pre>";
//print_r($resultado[$i]);
//echo "</pre>";
		}
	}
	
}
}
$a_array_suma_col=array();
if (sizeof($array_format_cols)>0){
$str_total="<span style='font-weight:bold; color:#000;'>TOTAL</span>";
$readyTotal=false;
if (sizeof($resultado)>0){
	foreach($suma_actxls  as $item_des => $item_val){
				$array_format_cols[$item_des]=($array_format_cols[$item_val[0]]/$array_format_cols[$item_val[1]])*100;
				}
foreach ($resultado[$i-1] as $cnr_col => $item_col){

	if (isset($array_format_cols[$cnr_col])){
		
		if (in_array($cnr_col,$a_percentxls)){
				$a_array_suma_col[$cnr_col]=format_num_p_0d($array_format_cols[$cnr_col]);
			}else{
				$a_array_suma_col[$cnr_col]=format_num($array_format_cols[$cnr_col]);}
		}
	else{if(!$readyTotal){$a_array_suma_col[$cnr_col]=$str_total; $readyTotal=true;}else{$a_array_suma_col[$cnr_col]='';}}	
}
}
$resultado[$i]=$a_array_suma_col;
}

//$a_head[]=array($CFG_TITLE); 
//$a_head[]=array($TITULO); 
//$mireporte= new Reporte(array('width'=>'100%','border'=>'0','cellpadding'=>'3','cellspacing'=>'0'));
//$mireporte->setTitulos(array('',''));
//$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>'20'));
//
//$mireporte->setDatos($a_head);
//$mireporte->displayDatos(array(),array(),'no');
//$periodo='';
//$periodo=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fechaini']))?' DEL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fechaini']))):'';
//$periodo.=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fechafin']))?' AL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fechafin']))):'';
//echo "<pre>";
//print_r($CFG_TABLA_FIELD);
//die();
/* tabla afield
foreach ($CFG_TABLA_FIELD as $ITEM_CFG_TABLA_FIELD){
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
}
tabla afield */
//echo "<a href=\"repxls.php?\"><img src=\"../img/img30.gif\" border =\"0\" />ss</a>";

$wtabla=0;
if(isset($a_width_table_col)){
	foreach($a_width_table_col as $nitem => $vitem){
		$wtabla+=$vitem;
	}
}



//$a_head0[]=array(strtoupper($CFG_TITLE));
$mireporte= new Reporte(array('width'=>'100%','border'=>'0','cellpadding'=>'0','cellspacing'=>'1'));
$mireporte->setTitulos(array(''));
$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>sizeof($a_getl_fields)));
$mireporte->setDatos($a_head0);
$mireporte->SetCellAttributesR ( sizeof($a_head0),1,array('class'=>'arial11pxGrayC'));
$mireporte->displayDatos(array(),array('class'=>'arial11pxboldC'),'no');
//echo "</BR>";
if (function_exists('fnPrintHeadersXls')){
					fnPrintHeadersXls();
			}
//$mireporte= new Reporte(array('width'=>$wtabla,'border'=>'1','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));
////$mireporte->setTitulos(array(''));
//
//$mireporte->setDatos(array($a_colheaders));
//$mireporte->SetCellAttributesR(1,1,array('class'=>'arial11px_white', 'width'=>((($a_width_fields[0]*5)-6).'px')));
//$mireporte->SetCellAttributesR(1,2,array('colspan'=>3,'class'=>'arial11px_azul', 'width'=>(($width_headersgroup[0]*5).'px')));
////$mireporte->SetCellAttributesR(1,3,array('colspan'=>3,'class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
//$mireporte->SetCellAttributesR(1,3,array('colspan'=>3,'class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
//$mireporte->SetCellAttributesR(1,4,array('colspan'=>3,'class'=>'arial11px_azul', 'width'=>(($width_headersgroup[2]*5).'px')));
//$mireporte->SetCellAttributesR(1,5,array('colspan'=>4,'class'=>'arial11px_verde', 'width'=>(($width_headersgroup[3]*5).'px')));
//
//$mireporte->displayDatos(array(),array('class'=>'arial11px_azul'),'no');


$mireporte= new Reporte(array('width'=>$wtabla,'border'=>'1','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));
foreach($a_getl_fields as $ikey => $ivalue)
	$a_getl_fields[$ikey]=strtoupper($ivalue);
$mireporte->setTitulos($a_getl_fields);
//$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>sizeof($a_getl_fields)));
$mireporte->setDatos($resultado);
$cnt_xTemp=1;
//foreach ($tipo_datos_fields as $i_c => $element_rep){
//	if (!in_array($i_c,$no_print)){
//		switch($element_rep[4]){
//			case 'num':
//				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_NUM));
//				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
//			break;
//			case 'date':
//				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_DATE));
//				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
//			break;
//			default:
//				$mireporte->SetColAttributesR($cnt_xTemp,array('class'=>$CFG_STYLE_DEF));
//				$mireporte->SetCellAttributesR(1,$cnt_xTemp,array('class'=>'arial11pxbold', 'width'=>($element_rep[7].'px')));
//			break;
//		}
//		$cnt_xTemp+=1;
//	}
//} 
//$mireporte->displayDatos($A_CFGTIT,$A_CFGALLROWS,'yes',$A_TIT0,$A_COLSP,$A_CFGLINE0);
if(isset($a_width_table_col)){
	foreach($a_width_table_col as $nitem => $vitem){
		$mireporte->SetCellAttributesR(1,$nitem+1,array('class'=>'arial11pxbold', 'width'=>($vitem.'px')));
	}
}
for ($i=0; $i<($classent->NumReg); $i++){
	$str_classstyle="arial11px_white";
	if(($i+2)%2 == 0){$str_classstyle="arial11px_azul0";}
		for ($j=0; $j<sizeof($a_getl_fields); $j++){
		$a_styles_table_cell[]=array($i+2,$j+1,'class',$str_classstyle);
		}
	
}
if (isset($a_fondo_verde)){
foreach ($a_getl_fields as $cnt_lbls=>$item_lbs){
	  if($cnt_lbls>0){	
		  $a_styles_table_cell[]=array($classent->NumReg + 2,$cnt_lbls+1,'class',(in_array( $cnt_lbls,$a_fondo_verde))?'arial11px_verde':'arial11px_azul');
	  }
	  }
}
//$mireporte->Set2RowColorsR( "#8DB4E2", "#FFFFFF", 1);
if(isset($a_styles_table_cell)){
	foreach($a_styles_table_cell as $nitem => $vitem){
		//$mireporte->SetColAttributesR($nitem,array('class'=>$vitem));
		$mireporte->SetCellAttributesR($vitem[0],$vitem[1],array($vitem[2]=>$vitem[3]));
	}
}

if(isset($a_styles_table_cell2)){
	foreach($a_styles_table_cell2 as $nitem => $vitem){
		//$mireporte->SetColAttributesR($nitem,array('class'=>$vitem));
		$mireporte->SetCellAttributesR($vitem[0],$vitem[1],array($vitem[2]=>$vitem[3]));
	}
}


$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#FFFFFF','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFFF','class'=>'arial11pxnormal'));//
if (function_exists('fnPrintFooterXls')){ 	fnPrintFooterXls(); }
}
	if ($_GET['fparam']=='i_grafico1' || $_GET['fparam']=='i_grafico3' || $_GET['fparam']=='i_grafico9'){
		
		$classconsul = new Entidad(array('mes','dia'),array('',''));
		$consulWhere=" SELECT substring(fechaf,6,2)  mes, substring(fechaf,9,2)  dia 
 						 FROM control_importacion  where    SEMANA=".$_GET['semanaF']." and anio=".$_GET['anio'];
		$classconsul->ListaEntidades(array(''),'control_importacion','','','','',$consulWhere);
		if($classconsul->NumReg>0){
			$classconsul->VerDatosEntidad(0,array('dia','mes'));
		  		$dia=$classconsul->dia;
				$mes1=$classconsul->mes;
		}
	
		if($mes1==1){ $mes='Enero';}else if($mes1==2){ $mes='Febrero';}else if($mes1==3){ $mes='Marzo';}else if($mes1==4){ $mes='Abril';
		} else if($mes1==5){ $mes='Mayo';}else if($mes1==6){ $mes='Junio';}else if($mes1==7){ $mes='Julio';}else if($mes1==8){ $mes='Agosto';
		}else if($mes1==9){ $mes='Septiembre';}else if($mes1==10){ $mes='Octubre';}else if($mes1==11){ $mes='Noviembre';
		}else if($mes1==12){ $mes='Diciembre';} 
		
}
if ($_GET['fparam']=='i_grafico1'){
	echo "<br><br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>* Comprende USMIS a Nivel Nacional. SINAVE, SSA Corte al ".$dia." de ".$mes." de ".$_GET['anio']."</div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico2'){
	echo "<br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left; '>Fuente: SUIVE/DGE/Sistema de Notificación Semanal de Casos Nuevos.  ".$_GET['semana']." Epidemiológica </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico3'){
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SINAVE SSA, Información al corte del ".$dia." de ".$mes." de ".$_GET['anio']." </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico4'){
	echo "<br><br><br><br><br><br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SINAVE SSA, Información al corte del ".$dia." de ".$mes." de ".$_GET['anio']." </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico6'){
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SINAVE/DGE/Sistema de Vigilancia de Influneza, corte del ".$dia." de ".$mes." de ".$_GET['anio']." </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico7'){
	echo "<br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SUIVE SSA Corte a la  ".$_GET['semana']." Epidemiológica </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico9'){
	echo "<br><br><br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SUIVE SSA Información al corte del  ".$dia." de ".$mes." de ".$_GET['anio']."</div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico10'){
	echo "<br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SINAVE SSA, Información al corte del ".$dia." de ".$mes." de ".$_GET['anio']." </div>";
	echo "</td>";
}else if ($_GET['fparam']=='i_grafico11'){
	echo "<br><br><br><br><br>";
	echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'>SINAVE SSA, Información al corte del ".$dia." de ".$mes." de ".$_GET['anio']." </div>";
	echo "</td>";
}
?>
</body>
</html>