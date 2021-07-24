<?php if (!isset($_SESSION)) session_start(); if (!isset($_SESSION['nomusuario'])){
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $CFG_TITLE;?></title>
<style type="text/css">
<!--
#midiv0 {
	font-family: Arial, Helvetica, sans-serif;
	/*background-color:#FEFFF9;*/
	width:650px;
	text-align:justify;
/*	color:#52672C;
*/	font-size:12px;
	color:#606060;
	line-height:18px;
}
.br {
	font-family: Arial, Helvetica, sans-serif;
	color:#52672C;
	font-size:12px;
}
.span {
	text-align:center;
	font-family: Arial, Helvetica, sans-serif;
	color:#151C00;
	font-size:11px;
	font-weight:bold;
}
-->
</style>
</head>
<body background="img/bg.gif" bgproperties="fixed" style="background-repeat:no-repeat; background-position:center">
</body>
</html>
<?php 
}
?>