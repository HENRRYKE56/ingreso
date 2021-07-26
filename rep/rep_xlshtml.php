<?php
session_start(); 
include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/lib32.php");
header("Pragma: ");
header("Cache-Control: ");

//header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=glo_".$__SESSION->getValueSession('nomusuario').".xls" );
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
                background-color: #C4BD97;#F0F0F0
                color: #000;
                font-size: 13px;
               // font-weight: bold;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .datos{
                text-align: center;
                background-color: #F0F0F0;
                padding: 5px;
                font-size: 12px;
             //   font-weight: bold;
            }       
            .datos1{
                text-align: center;
                background-color: #F0F0F0;
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

</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ENSVT</title>
</head>
<body>
<?php

//session_start(); 

$CFG_STYLE_DEF='arial11px';
$CFG_STYLE_NUM='arial11pxRight';
$CFG_STYLE_DATE='arial11pxCenter';
if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
include_once($_GET['fparam'].".php");
//require('lib/Reporte.php');

echo ''.$tabla_pintarxls;

}
?>


</body>
</html>