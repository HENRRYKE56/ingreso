<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
            <link href="../css/front.css" rel="stylesheet">
                <link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
                    <title>REPORTE</title>

                    </head>
                    <body>
                        <?php
                        include_once("../config/cfg.php");
                        include_once("../lib/lib_pgsql.php");
                        include_once("../lib/lib_entidad.php");
                        include_once("lib/lib32.php");
                        $CFG_STYLE_DEF = 'arial11px';
                        $CFG_STYLE_NUM = 'arial11pxRight';
                        $CFG_STYLE_DATE = 'arial11pxCenter';

                        if (isset($_GET['fparam']) && !is_null($_GET['fparam'])) {
                            $strParamGet = "";
                            foreach ($_GET as $item => $value) {
                                if (strlen($strParamGet) > 0)
                                    $strParamGet .= "&";
                                $strParamGet .= $item . "=" . $value;
                            }
//echo '<pre>';
//print_r($_GET);die();
                            include_once($_GET['fparam'] . ".php");


//require('lib/Reporte.php');
                            $ar_bot = array("", "punteados_l oscuro_b", "punteados_s claro_b");
                            echo "<a href=\"rep_xlshtml.php?" . $strParamGet . "\" class='btn boton_act punteados " . $ar_bot[$__SESSION->getValueSession('theme') * 1] . "'>" . '<i class="fa fa-file-excel-o" aria-hidden="true"></i>' . "</a>";
                            $barra .= (($boolPDF) ? ("<a href=\"javascript:abrir2('./rep/" . (isset($pdfprint) ? $pdfprint : 'reppdf.php') . "?" . $strParamGet . "')\"><img src=\"./img/img32.gif\" border =\"0\" /></a>") : '');
                            echo '' . $barra;

                            echo '' . $tabla_pintar;
                        }
                        ?>


                    </body>
    <style>
        .rojin{
            background-color:red !important;color:white !important;
        }
    </style>
                    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>
                    <script language="javascript">
                        function actualiza_folios(fol) {
                            var val = fol.value;
                            var datos = "type=a_f";
                            datos += "&val=" + val;
                            $.ajax({
                                url: 'e_folio.php',
                                type: 'POST',
                                dataType: 'json',
                                data: datos,
                                beforeSend: function () {
                                    $('#'+fol.id).attr('disabled', 'disabled');
                                },
                                success: function (response) {//echo json_encode(array('successful' => $success, 'estado' => $estado_proceso));
                                    if (response.successful == 'true') {
                                        var ar_vl= val.split('_');
                                        if(ar_vl[1] == '1'){
                                            $( "#tr_"+ar_vl[0] ).addClass( "rojin" );
                                        }else{
                                            $( "#tr_"+ar_vl[0] ).removeClass( "rojin" );
                                        }
                                    } 
                                    // alertify.success("! el registro se guardo!");
                                }, error: function (e) {
                                    alert("bondad al cambiar estatus ");
                                },
                                complete: function () {
                                    $('#'+fol.id).removeAttr('disabled');
                                },
                            });
                        }

                    </script>
                    </html>
