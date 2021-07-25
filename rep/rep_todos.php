<?php
session_start(); 
header("Content-Type: text/html; charset=utf-8");
//if (!isset($_GET['divsnivel'])){
if (false){	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php }?>
<style type="text/css" >
    
        /*titulo reportes*/
	.arial16title{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
        font-size:  16px;
        font-weight:bold;
        text-align:center;
	}    
	.arial15enca11{
	font-family:Arial, Helvetica, sans-serif;
	color:white;
        font-size:  15px;
        font-weight:bold;
        text-align:center;
        background: #DD1319;
	}             
        /*titulo departamentos*/
	.arial15enca{
	font-family:Arial, Helvetica, sans-serif;
	color:#565656;
        font-size:  11px;
        text-align:center;
        background: #E6E6E6;
	} 
	.arial14area{
	font-family:Arial, Helvetica, sans-serif;
	color:white;
        font-size:  11px;
        text-align:center;
        background: #7A9C17;
	}   //demas dep
             
        
        
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
	a:link, a:hover, a:visited, a:active{
	color:#336600;
	/*font*/
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
	font-family:Arial, Helvetica, sans-serif;	background-color:#FFFFFF;
	color:#000000;
	font-size:11px;
	text-align:right;
	}
	  .arial11px_grisclaro{
	font-family:Arial, Helvetica, sans-serif;
	background-color:#D9D9D9;
	color:#000000;
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
<?php if (false){	 ?>
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REPORTE</title>
</head>
<body>

<?php
}

include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/lib32.php");

$CFG_STYLE_DEF='arial11px';
$CFG_STYLE_NUM='arial11pxRight';
$CFG_STYLE_DATE='arial11pxCenter';

//echo "<pre>";
//print_r($_GET['fparam']);
//echo "</pre>"; die();

if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
$strParamGet="";
foreach ($_GET as $item=>$value){
	if($item<>"divsnivel"){
		if (strlen($strParamGet)>0)
			$strParamGet.="&";
		$strParamGet.=$item."=".$value;
	}
}

include_once($_GET['fparam'].".php");

//die($str_Qry);
require('lib/Reporte.php');
//$mibase= new MySqlCon('localhost','root','','encuesta');
//$mibase->Consulta("select * from modulo order by cve_modulo");
//$miresult=$mibase->getRstSQL();
//$rows=$mibase->getNumRows();
if (isset($str_Qry01) && strlen(trim($str_Qry01))>0){

$resultado=array();
$classent = new Entidad($a_getn_fields,$a_getv_fields);
$classent->ListaEntidades(array(),"","","","no","",$str_Qry01);



//echo "<pre>";
//print_r($classent_1);
//echo '</pre>';die();

$strlink01="<a id='{P1}' class=\"ar2\" name='{P1}' href=\"#{P1}\" onclick=\"openrefInDiv('{P2}','{P1}','./rep/rep_todos.php?{P3}&".((isset($strParamGet) and strlen(trim($strParamGet))>0)?$strParamGet.'&':'')
.((isset($str_drill_def) and strlen(trim($str_drill_def))>0)?$str_drill_def.'&':'');
$strlink02="')\">";
$strlink03="</a><div  style=\"position:absolute; padding-left:20px; padding-bottom:20px; z-index:{P2}; display:none;\" id='{P1}'></div>";
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
$zindex=1;
if (isset($_GET['divsnivel']) && strlen($_GET['divsnivel'])>0){
	$a_zindex=explode("_",trim($_GET['divsnivel']));
	$zindex=(($a_zindex[0]*1)>0?($a_zindex[0]+1):5);
}
for ($i=0; $i<$classent->NumReg; $i++){
	$a_XtmpResult=$classent->getRow($i,$a_getn_fields,$no_print);
	if(isset($boolreplaceFirstCol) && !$boolreplaceFirstCol){}else{
	//$a_XtmpResult[0]="SSA_".str_pad($i+1, 10, "0", STR_PAD_LEFT);
	}
	if (isset($boolreplaceLn) and $boolreplaceLn){
		foreach($a_XtmpResult as $xTmpName => $xTmpValue)
			$a_XtmpResult[$xTmpName]=replaceLnxBr($xTmpValue);
	}
	$resultado[]=$a_XtmpResult;
	if ($boolFormatCol){
		foreach($array_format_col as $item_format_col){echo ' @ 0o'.$item_format_col[1];
			$getValorCell0=$resultado[$i][$item_format_col[0]];
			$array_format_cols[$item_format_col[0]]+=($getValorCell0*1);
			eval('$getValorCell='.$item_format_col[1].'($getValorCell0);');
			$resultado[$i][$item_format_col[0]]= $getValorCell;
		}die();
	}
        
//$resultado[]=array('n','n','n','n','n','n','n');
        
	
//		foreach($sumaxls as $cont =>$itemw){
//			$sumas0[$itemw]+=$a_XtmpResult[$cont];
//		}			
	
	

	if ($boolDrill) {
		foreach($array_drill as $cnt_drill => $item_drill){
			$tmp_val_drill=$resultado[$i][$item_drill[0]];
			//$resultado[$i][$item_drill[0]]=$strlink01 . $item_drill[2] ; 
			$resultado[$i][$item_drill[0]]= str_replace(array("{P1}","{P2}","{P3}"),array(($zindex."refRow_".$i."_".$cnt_drill),($zindex."_divRow_".$i."_".$cnt_drill),("divsnivel=".$zindex."_divRow_".$i."_".$cnt_drill)),$strlink01) . $item_drill[2] ; 
			
			foreach($item_drill[1] as $cnt_item_item => $item_drill_item){
			/*****************************/
				$resultado[$i][$item_drill[0]].= "&". $item_drill[4][$cnt_item_item] . "=" . $classent->$item_drill_item;
			}
			//$resultado[$i][$item_drill[0]].= $strlink02 . $tmp_val_drill . $strlink03;
			$resultado[$i][$item_drill[0]].= $strlink02 . $tmp_val_drill . str_replace(array("{P1}","{P2}"),array(($zindex."_divRow_".$i."_".$cnt_drill),($zindex*10)),$strlink03);
		}
	}
}
//$arr_aux[0][0]="NOMBRE";
//$arr_aux[0][1]="ENCARGADO";
//$arr_aux[0][2]="DIRECCION";
//$arr_aux[0][3]="TELEFONO";
//$arr_aux[0][4]="CORREO";
//$contt=1;
//for($i=0;$i<count($resultado);$i++){
//    $arr_aux[$contt]=$resultado[$i];
//    $contt++;
//}
//$resultado=$arr_aux;
//echo '<pre>';
//print_r($resultado);
//echo '</pre>';
//die();

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
//if (sizeof($array_format_cols)>0)
$resultado[$i]=$a_array_suma_col;
}

//foreach($sumaxls as $cont =>$itemw){
//			$sumas0[$itemw]+=$a_XtmpResult[$cont];
//		}

//$periodo='';
//$periodo=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))?' DEL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_i_r']))):'';
//$periodo.=(isset($_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))?' AL ' . implode('/', array_reverse(explode('-', $_SESSION['a_ses_criterios'][$_SESSION['GO']]['fecha_f_r']))):'';
$wtabla=0;
if(isset($a_width_table_col)){
	foreach($a_width_table_col as $nitem => $vitem){
		$wtabla+=$vitem;
	}
}

$a_head=array();
if (isset($_GET['divsnivel']) && strlen($_GET['divsnivel'])>0){
	
$barraCerrar="<a href=\"#\" class=\"refcerrar\" onclick=\"closeMe('".(trim($_GET['divsnivel']))."')\"><div class=\"btncerrar\"></div></a>";
$a_head[]=array($barraCerrar);
$mireporte= new Reporte(array('width'=>($wtabla.'px'),'border'=>'0','cellpadding'=>'0','cellspacing'=>'0'));
$mireporte->setTitulos(array('',''));
$mireporte->SetDefaultCellAttributes (array('style'=>'font-size:10px;'));
$mireporte->setDatos($a_head);
$mireporte->displayDatos(array(),array(),'no');	
	
	}


$a_head=array();
//if ($_GET['fparam']=='il_entrada'){
if($xlsprint<>" ")
		$barra="<a href=\"./rep/".(isset($xlsprint)?$xlsprint:'rep_xls.php')."?".$strParamGet."\"><img src=\"./img/img30.gif\" border =\"0\" /></a>"
		 .(($boolPDF)?("<a href=\"javascript:abrir2('./rep/".(isset($pdfprint)?$pdfprint:'reppdf.php')."?".$strParamGet."')\"><img src=\"./img/img32.gif\" border =\"0\" /></a>"):'');
//}
$a_head[]=array($barra);//split(':::',$barra);	 
$mireporte= new Reporte(array('width'=>($wtabla.'px'),'border'=>'0','cellpadding'=>'0','cellspacing'=>'0', 'background'=>"./img/bg06.gif"));
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
//$a_head0[]=array(strtoupper($CFG_TITLE));

$mireporte= new Reporte(array('width'=>'100%','border'=>'0','cellpadding'=>'0','cellspacing'=>'1'));
$mireporte->setTitulos(array(''));
$mireporte->SetDefaultCellAttributes (array('class'=>'arial11pxboldC','colspan'=>sizeof($a_getl_fields)));
$mireporte->setDatos($a_head0);

$mireporte->displayDatos(array(),array('class'=>'arial16title'),'no');
//echo "</BR>";

//$mireporte= new Reporte(array('width'=>$wtabla,'border'=>'0','align'=>'left','cellspacing'=>'1', 'bgcolor'=>'#000000'));
//$mireporte->setTitulos(array(''));
if (function_exists('fnPrintHeaders')){
    fnPrintHeaders();
}
//$mireporte->setDatos(array($a_colheaders));
//$mireporte->SetCellAttributesR(1,1,array('class'=>'arial11px_white', 'width'=>((($a_width_fields[0]*5)-6).'px')));
//$mireporte->SetCellAttributesR(1,2,array('class'=>'arial11px_azul', 'width'=>(($width_headersgroup[0]*5).'px')));
////$mireporte->SetCellAttributesR(1,3,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
//$mireporte->SetCellAttributesR(1,3,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[1]*5).'px')));
//$mireporte->SetCellAttributesR(1,4,array('class'=>'arial11px_azul', 'width'=>(($width_headersgroup[2]*5).'px')));
//$mireporte->SetCellAttributesR(1,5,array('class'=>'arial11px_verde', 'width'=>(($width_headersgroup[3]*5).'px')));
//
//$mireporte->displayDatos(array(),array('class'=>'arial11px_azul'),'no');


//$mireporte = new Reporte(array('width' => '100%', 'border' => '1', 'cellpadding' => '0', 'cellspacing' => '1'));
//$mireporte->SetDefaultCellAttributes(array('class' => 'arial11pxboldC', 'colspan' => sizeof($a_getl_fields)));    
//$mireporte->SetCellAttributesR(sizeof($a_head0), 1, array('class' => 'arial11pxGrayC'));
//$mireporte->setTitulos($a_getl_fields);
//$mireporte->displayDatos(array('align' => 'center', 'bgcolor' => '#A6A6A6', 'class' => 'arial15enca'), array('bgcolor' => '#FFFFFF', 'class' => 'arial11pxnormal'));


$mireporte= new Reporte(array('border'=>'0','align'=>'center','cellspacing'=>'2', 'bgcolor'=>'#E6E6E6', 'style'=>("width:".$wtabla.'px;')));//
$mireporte->setTitulos($a_getl_fields);
$mireporte->setDatos($resultado);
$cnt_xTemp=1;

//DEBO DELCARAR UN ARRAY DE TIPO DE DATOS

/*foreach ($tipo_datos_fields as $i_c => $element_rep){
	if (!in_array($i_c,$no_print)){
		switch($element_rep){
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
} */

if ($_GET['fparam']=='il_tablero02' || $_GET['fparam']=='il_tablero05' || $_GET['fparam']=='il_tablero04' ){
}else{
for ($i=-1; $i<=($classent->NumReg); $i++){
    if($i==-1){
        $str_classstyle="arial14area";
    }else if($i>=0 && $i<($classent->NumReg)){
             //   $classent->VerDatosEntidad($i, $a_getl_fields);
//        if($classent->nivel==1 or $classent_1->nivel==0)$str_classstyle="arial11pxCenter";//arial14area
//        else $str_classstyle="arial11pxCenter";
$str_classstyle="arial11pxCenter";
    }
	
	//if(($i+2)%2 == 0){$str_classstyle="arial11px_verde_claro";}
		for ($j=0; $j<sizeof($a_getl_fields); $j++){
		$a_styles_table_cell[]=array($i+2,$j+1,'class',$str_classstyle);
		}
	
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


if ($_GET['fparam']=='il_tablero02'  || $_GET['fparam']=='il_tablero05'  || $_GET['fparam']=='il_tablero04' ){
}else{
for ($i=0; $i<($classent->NumReg); $i++){
	$str_classstyle="arial11px_white";
	if(($i+2)%2 == 0){$str_classstyle="arial11px_azul0";}
		for ($j=0; $j<sizeof($a_getl_fields); $j++){
		//$a_styles_table_cell[]=array($i+2,$j+1,'class',$str_classstyle);
		}
	
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


if(isset($a_width_table_col)){
	foreach($a_width_table_col as $nitem => $vitem){
		$mireporte->SetCellAttributesR(1,$nitem+1,array('style'=>("width:".$vitem.'px;')));
	}
}

echo "<div style=\"float:left; \">";
$mireporte->displayDatos(array('align'=>'left','bgcolor'=>'#FFFFFF','class'=>'arial11pxbold'),array('bgcolor'=>'#FFFFFF','class'=>'arial11pxnormal'));//
echo "</div>";
echo "<div class='arial11pxbold' style='font-style: italic; display:block; float:left;'> ";
echo "Numero de registros: ".$classent->NumReg;
echo "</div>";
if (function_exists('fnPrintFooter')){ 
	fnPrintFooter(); }
}
//echo "<div class='arial11pxbold' style='font-style: italic; display:block;'>resultado:&nbsp;".(isset(	$secuencialx)?	$secuencialx:($classent->NumReg))." registros.</div>";
if (false){
	 ?>
<div title="Archivo" id="download-file-modal" style="display: none;">
   La descarga puede tardar dependiendo del volumen de informaci&oacute;n.
</div>
</body>
</html
><?php }?>