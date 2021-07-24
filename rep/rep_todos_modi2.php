<?php 
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css" >
	.arial11px{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
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
	color:#000000;
	font-size:11px;
	text-align:center;
	}
	.arial11px2Center{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	text-align:center;
	}
	.arial11pxRight{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
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
        .letra_cabezera{
            text-align: center;
                background-color: #7A9C17;
                color: #000;
                font-size: 14px;
                font-weight: bolder;
                padding: 5px;
            }

            .subcabezera{
                text-align: center;
                background-color: #C4BD97;
                color: #000;
                font-size: 13px;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .datos{
                text-align: center;
                background-color: #F0F0F0;
                padding: 5px;
                font-size: 12px;
            }       
            .datos1{
                text-align: center;
                background-color: red;
                padding: 5px;
                font-size: 12px;
                font-weight: bold;
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
.w3-table,.w3-table-all{border-collapse:collapse;border-spacing:0;width:100%;display:table}
.w3-table-all{border:1px solid #ccc}
.w3-bordered tr,.w3-table-all tr{border-bottom:1px solid #ddd}
.w3-striped tbody tr:nth-child(even){background-color:#f1f1f1}
.w3-table-all tr:nth-child(odd){background-color:#fff}
.w3-table-all tr:nth-child(even){background-color:#f1f1f1}
.w3-hoverable tbody tr:hover,
.w3-ul.w3-hoverable li:hover{background-color:#ccc;}
.w3-centered tr th,.w3-centered tr td{text-align:center;}
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th{padding:8px 8px;display:table-cell;text-align:left;vertical-align:top;border:1px solid #ddd;}
.w3-table th:first-child,.w3-table td:first-child,.w3-table-all th:first-child,.w3-table-all td:first-child{padding-left:16px;border:1px solid #ddd;}

</style>
<script type="text/javascript">
			function openInIframe2 (URL){
				//window.parent.document.location.href = URL;
				window.parent.frames.miiframe2.location.href = URL;
				window.parent.document.getElementById('miiframe').style.width = "500px";
				window.parent.document.getElementById('miiframe2').style.width="500px";
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
//die("dfgdfgdfgdf11111g".$_GET['fparam']);
include_once($_GET['fparam'].".php");


require('lib/Reporte.php');
echo "<br><a href=\"./rep_xlshtml.php?".$strParamGet."\"> <img src=\"../img/img30.gif\"  border =\"0\" ></a>";



 $barra.=(($boolPDF)?("<a href=\"javascript:abrir2('./".(isset($pdfprint)?$pdfprint:'reppdf_detalle.php')."?".$strParamGet."')\"><img src=\"../img/img32.gif\" border =\"0\" /></a>"):'');
 echo ''.$barra;
 
echo ($tabla_pintar);
//$mibase= new MySqlCon('localhost','root','','encuesta');
//$mibase->Consulta("select * from modulo order by cve_modulo");
//$miresult=$mibase->getRstSQL();
//$rows=$mibase->getNumRows();
//if (isset($str_Qry) && strlen(trim($str_Qry))>0){
//
//$resultado=array();
//$classent = new Entidad($a_getn_fields,$a_getv_fields);
///*if ($_GET['fparam']<>'i_grafico1'){}*/
//$classent->ListaEntidades(array(),"","","","no","",$str_Qry);
//
//
//
///*echo "<pre>";
//print_r($_GET);
//echo "</pre>";
//die();*/
//
//$strlink01="<a href='rep_todos.php?".((isset($str_drill_def) and strlen(trim($str_drill_def))>0)?$str_drill_def.'&':'');
//$strlink02="'>";
//$strlink03="</a>";
//$boolDrill=false;
//$boolGrp=false;
//$boolFormatCol=false;
//if (isset($array_drill) && count($array_drill)>0) $boolDrill=true;
//if (isset($array_grp) && count($array_grp)>0) $boolGrp=true;
//if (isset($array_format_col) && count($array_format_col)>0) $boolFormatCol=true;
//$array_format_cols=array();
//if ($boolFormatCol){
//	foreach($array_format_col as $item_format_col){
//			$array_format_cols[$item_format_col[0]]=0;
//		}
//}
//$a_XtmpResult=array();
//for ($i=0; $i<$classent->NumReg; $i++){
//	$a_XtmpResult=$classent->getRow($i,$a_getn_fields,$no_print);
//	//if(isset($boolreplaceFirstCol) && !$boolreplaceFirstCol){}else{
////	$a_XtmpResult[0]="SSA_".str_pad($i+1, 10, "0", STR_PAD_LEFT);}
//	if (isset($boolreplaceLn) and $boolreplaceLn){
//		foreach($a_XtmpResult as $xTmpName => $xTmpValue)
//			$a_XtmpResult[$xTmpName]=replaceLnxBr($xTmpValue);
//	}
//	$resultado[]=$a_XtmpResult;
//	if ($boolFormatCol){
//		foreach($array_format_col as $item_format_col){
//			$getValorCell0=$resultado[$i][$item_format_col[0]];
//			$array_format_cols[$item_format_col[0]]+=($getValorCell0*1);
//			eval('$getValorCell='.$item_format_col[1].'($getValorCell0);');
//			$resultado[$i][$item_format_col[0]]= $getValorCell;
//		}
//	}
//	
////		foreach($sumaxls as $cont =>$itemw){
////			$sumas0[$itemw]+=$a_XtmpResult[$cont];
////		}			
//	
//	
//	
////	echo "<pre>";
////print_r($resultado);
////echo "</pre>";
//	if ($boolDrill) {
//		foreach($array_drill as $item_drill){
//			$tmp_val_drill=$resultado[$i][$item_drill[0]];
//			$resultado[$i][$item_drill[0]]=$strlink01 . $item_drill[2] ; 
//			foreach($item_drill[1] as $cnt_item_item => $item_drill_item){
//			/*****************************/
//				$resultado[$i][$item_drill[0]].= "&". $item_drill[4][$cnt_item_item] . "=" . $classent->$item_drill_item;
//			}
//			$resultado[$i][$item_drill[0]].= $strlink02 . $tmp_val_drill . $strlink03;
//		}
//	}
//}
//}
//
//
///*	echo "<pre>";
//print_r($a_getn_fields);
//echo "</pre>";*/
//
//
//
//
//
//$a_array_suma_col=array();
//if (sizeof($array_format_cols)>0){
//$str_total="<span style='font-weight:bold; color:#000;'>TOTAL</span>";
//$readyTotal=false;
//if (sizeof($resultado)>0){
//	foreach($suma_actxls  as $item_des => $item_val){
//				$array_format_cols[$item_des]=($array_format_cols[$item_val[0]]/$array_format_cols[$item_val[1]])*100;
//				}
//	
//foreach ($resultado[$i-1] as $cnr_col => $item_col){
//
//	if (isset($array_format_cols[$cnr_col])){
//		if (in_array($cnr_col,$a_percentxls)){
//				$a_array_suma_col[$cnr_col]=format_num_p_0d($array_format_cols[$cnr_col]);
//			}else{
//				$a_array_suma_col[$cnr_col]=format_num($array_format_cols[$cnr_col]);}
//		}
//	else{if(!$readyTotal){$a_array_suma_col[$cnr_col]=$str_total; $readyTotal=true;}else{$a_array_suma_col[$cnr_col]='';}}	
//}
//}
////if (sizeof($array_format_cols)>0)
//$resultado[$i]=$a_array_suma_col;
//}
//
////foreach($sumaxls as $cont =>$itemw){
////			$sumas0[$itemw]+=$a_XtmpResult[$cont];
////		}
//
////$periodo='';
////$periodo=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))?' DEL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))):'';
////$periodo.=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))?' AL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))):'';
//$wtabla=0;
//if(isset($a_width_table_col)){
//	foreach($a_width_table_col as $nitem => $vitem){
//		$wtabla+=$vitem;
//
//	}
//}
//$a_head=array();
//
//if($_GET['fparam']=='il_regis_pacientes' ){

//}
//if($_GET['fparam']=='ir_calzado'){
//$barra="<a href=\"rep_xls.php?".$strParamGet."\"> <img src=\"../img/img30.gif\" border =\"0\" /></a>"
//	.(($boolPDF)?"<a href=\"javascript:abrir2('reppdf_calzado.php?".$strParamGet."')\"><img src=\"../img/img32.gif\" border =\"0\" /></a>":'');
//}
//if($_GET['fparam']=='ir_calzado2'){
//$barra="<a href=\"rep_xls.php?".$strParamGet."\"> <img src=\"../img/img30.gif\" border =\"0\" /></a>"
//	.(($boolPDF)?"<a href=\"javascript:abrir2('reppdf_calzadoh.php?".$strParamGet."')\"><img src=\"../img/img32.gif\" border =\"0\" /></a>":'');
//}
//if($_GET['fparam']=='il_reporte_2' ){
//$barra="<a href=\"rep_xls.php?".$strParamGet."\"> <img src=\"../img/img30.gif\" border =\"0\" /></a>";
//}
///*if ($_GET['fparam']=='i_grafico1' ){
//$barra="<a href=\"rep_xls.php?".$strParamGet."\"> <img src=\"../img/img30.gif\" border =\"0\" /></a>"
//	.(($boolGrp)?"<a href=\"javascript:openInIframe2('rep_grp1.php?".$strParamGet."')\"><img src=\"../img/img31.gif\" border =\"0\" /></a>":'');
//		 
//}
//else if($_GET['fparam']=='i_grafico2' ){
//$barra="<a href=\"rep_xls.php?".$strParamGet."\"> <img src=\"../img/img30.gif\" border =\"0\" /></a>"
//	.(($boolGrp)?"<a href=\"javascript:openInIframe2('rep_grp2.php?".$strParamGet."')\"><img src=\"../img/img31.gif\" border =\"0\" /></a>":'');
//}*/
//
//
//$a_head[]=array($barra);//explode(':::',$barra);	 
//$mireporte= new Reporte(array('width'=>($wtabla.'px'),'border'=>'0','cellpadding'=>'0','cellspacing'=>'0', 'background'=>"../img/bg06.gif"));
//$mireporte->setTitulos(array('',''));
//$mireporte->SetDefaultCellAttributes (array('style'=>'font-size:10px;'));
//$mireporte->setDatos($a_head);
//$mireporte->displayDatos(array(),array(),'no');
//if ($_GET['fparam']=='il_benef_prosal')die();
///*foreach ($CFG_TABLA_FIELD as $ITEM_CFG_TABLA_FIELD){
//	
//	if (isset ($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]])){
//		$classconsul = new Entidad($ITEM_CFG_TABLA_FIELD[3],array(''));
//		$strWhere="";
//		foreach ($ITEM_CFG_TABLA_FIELD[2] as $cnt_tmp => $VALUE_ITEM_CFG_TABLA_FIELD ){
//			if (strlen($strWhere)>0)
//				$strWhere.=" and ";
//				if ($ITEM_CFG_TABLA_FIELD[6][$cnt_tmp]=='num'){
//					$strWhere.=$VALUE_ITEM_CFG_TABLA_FIELD . "=" . trim($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]]);}
//				else{
//					$strWhere.=$VALUE_ITEM_CFG_TABLA_FIELD . "='" . trim($_SESSION['a_ses_criterios'][$_SESSION['GO']][$ITEM_CFG_TABLA_FIELD[1]])."'";}
//		}
//		$strWhere="Where ".$strWhere;
////		echo $strWhere;
//		$classconsul->ListaEntidades(array(),$ITEM_CFG_TABLA_FIELD[4],$strWhere,$ITEM_CFG_TABLA_FIELD[3][0],"no");
//		$classconsul->VerDatosEntidad(0,$ITEM_CFG_TABLA_FIELD[3]);
//		$a_head[]=array($ITEM_CFG_TABLA_FIELD[0],$classconsul->$ITEM_CFG_TABLA_FIELD[3][0]);
//	}
//}*/ //COMENTO INTERUMPE LA CREACION DE ENCABEZADOS DINAMICOS
////$a_head0[]=array(strtoupper($CFG_TITLE));
//
//$mireporte= new Reporte(array('width'=>($wtabla)."px",'border'=>'0','cellpadding'=>'0','cellspacing'=>'1'));
//$mireporte->setTitulos(array(''));
//$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>sizeof($a_getl_fields)));
//$mireporte->setDatos($a_head0);
//
//$mireporte->displayDatos(array(),array('class'=>'arial11pxboldC'),'no');
////echo "</BR>";
//
////$mireporte= new Reporte(array('width'=>$wtabla,'border'=>'0','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));
////$mireporte->setTitulos(array(''));
//if (function_exists('fnPrintHeaders')){
//					fnPrintHeaders();
//			}
////$mireporte->setDatos(array($a_colheaders));
////$mireporte->SetCellAttributesR(1,1,array('class'=>'arial11px_white', 'width'=>((($a_width_fields[0]*5)-6).'px')));
////$mireporte->SetCellAttributesR(1,2,array('class'=>'arial11px_azul', 'width'=>(($width_headersgroup[0]*5).'px')));
//////$mireporte->SetCellAttributesR(1,3,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
////$mireporte->SetCellAttributesR(1,3,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
////$mireporte->SetCellAttributesR(1,4,array('class'=>'arial11px_azul', 'width'=>(($width_headersgroup[2]*5).'px')));
////$mireporte->SetCellAttributesR(1,5,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[3]*5).'px')));
////
////$mireporte->displayDatos(array(),array('class'=>'arial11px_azul'),'no');
//
//$mireporte= new Reporte(array('width'=>($wtabla)."px",'border'=>'0','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));//
//$mireporte->setTitulos($a_getl_fields);
//
//
//
//$mireporte->setDatos($resultado);
//
//$cnt_xTemp=1;
//
////DEBO DELCARAR UN ARRAY DE TIPO DE DATOS
//
///*foreach ($tipo_datos_fields as $i_c => $element_rep){
//	if (!in_array($i_c,$no_print)){
//		switch($element_rep){
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
//} */
//
//if(isset($a_width_table_col)){
//	foreach($a_width_table_col as $nitem => $vitem){
//		$mireporte->SetCellAttributesR(1,$nitem+1,array('class'=>'arial11pxbold', 'width'=>($vitem.'px')));
//	}
//}
//for ($i=0; $i<($classent->NumReg); $i++){
//	$str_classstyle="arial11px_white";
//	if(($i+2)%2 == 0){$str_classstyle="arial11px_white";}
//		for ($j=0; $j<sizeof($a_getl_fields); $j++){
//		$a_styles_table_cell[]=array($i+2,$j+1,'class',$str_classstyle);
//		}
//	
//}
//if (isset($a_fondo_verde)){
//foreach ($a_getl_fields as $cnt_lbls=>$item_lbs){
//	  if($cnt_lbls>0){	
//		  $a_styles_table_cell[]=array($classent->NumReg + 2,$cnt_lbls+1,'class',(in_array( $cnt_lbls,$a_fondo_verde))?'arial11px_verde':'arial11px_white');
//	  }
//	  }
//}
//
////$mireporte->Set2RowColorsR( "#8DB4E2", "#FFFFFF", 1);
//if(isset($a_styles_table_cell)){
//	foreach($a_styles_table_cell as $nitem => $vitem){
//		//$mireporte->SetColAttributesR($nitem,array('class'=>$vitem));
//		$mireporte->SetCellAttributesR($vitem[0],$vitem[1],array($vitem[2]=>$vitem[3]));
//	}
//}
//
//if(isset($a_styles_table_cell2)){
//	foreach($a_styles_table_cell2 as $nitem => $vitem){
//		//$mireporte->SetColAttributesR($nitem,array('class'=>$vitem));
//		$mireporte->SetCellAttributesR($vitem[0],$vitem[1],array($vitem[2]=>$vitem[3]));
//	}
//}
//
//	echo "<div style=\"float:left;  width:100%;\">";
//
//$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#FFFFFF','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFFF','class'=>'arial11pxnormal'));//
//echo "</div>";
//if (function_exists('fnPrintFooter') ){ 
//	fnPrintFooter(); }
//}


//if ($_GET['fparam']=='i_grafico1' || $_GET['fparam']=='i_grafico2' ){
/*	echo "<div style=\"float:left; margin-top:20px; width:100%;\">";
$mireporte= new Reporte(array('width'=>($wtabla)."px",'border'=>'0','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));//
$mireporte->setTitulos($a_getl_fields);
	$mireporte->setDatos($resultado);
$mireporte->displayDatos(array('align'=>'center','bgcolor'=>'#FFFFFF','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFFF','class'=>'arial11pxnormal'));//
echo"</div>";*/

}
?>


</body>
    <script language="javascript">


</script>
</html>
