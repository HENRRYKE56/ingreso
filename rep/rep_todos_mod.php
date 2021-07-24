<?php 
session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/front.css" rel="stylesheet">
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
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


//require('lib/Reporte.php');
$ar_bot=array("","punteados_l oscuro_b","punteados_s claro_b");
echo "<a href=\"rep/rep_xlshtml.php?".$strParamGet."\" class='btn boton_act punteados ".$ar_bot[$__SESSION->getValueSession('theme') * 1]."'>".'<i class="fa fa-file-excel-o" aria-hidden="true"></i>'."</a>";
 $barra.=(($boolPDF)?("<a href=\"javascript:abrir2('./rep/".(isset($pdfprint)?$pdfprint:'reppdf.php')."?".$strParamGet."')\"><img src=\"./img/img32.gif\" border =\"0\" /></a>"):'');
 echo ''.$barra;
 
echo ''.$tabla_pintar;


}
?>


</body>
    <script language="javascript">


</script>
</html>
