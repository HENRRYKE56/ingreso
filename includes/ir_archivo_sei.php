<?php
$str_check = FALSE;
include_once("sb_ii_check.php");

if ($str_check) {
    $field[] = array('cve_perfil', 'perfil_modulo', '0', 0);

    $field[] = array('cve_modulo', 'perfil_modulo', '1', "");
    $field[] = array('key_modulo', 'perfil_modulo', '1', "");
    $allf = array();
    $allv = array();
    foreach ($field as $afield) {
        $allf[] = $afield[0];
        $allv[] = $afield[3];
    }
    $IdPrin = '';
    $tabla = 'sb_perfil_modulo,sb_modulo';
    $strWhere = "Where sb_perfil_modulo.cve_perfil=" . $__SESSION->getValueSession('cveperfil');
    $strWhere .= " and sb_perfil_modulo.cve_modulo=" . $__SESSION->getValueSession('mod');
    $strWhere .= " and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
    $strWhere .= " and sb_modulo.sta_modulo<>0";
    $classval = new Entidad($allf, $allv);
    $classval->Consultar($allf, $IdPrin, $tabla, $strWhere);
    $str_valmodulo = "MOD_NOVALIDO";
    if ($classval->NumReg > 0) {
        /* ----------JURISDICCION--------------------- */
        $obligatorio = 0;
        $entidad = " DATOS SEI";

        $str_valmodulo = "MOD_VALIDO";
        $a_key = explode(',', $classval->key_modulo);

        /* -------------valores de session, si es que los hay------------- */
        $sel = '0';

        if (isset($vintParam)) {
            switch ($vintParam) {
                case 2:
                    break;
            }
        }


        $field = array();
        $allf = array();
        $allv = array();
        /* $field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
          '3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
          '5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
          '10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered); */
        //$id_prin='cve_jurisdiccion';
        $strWhere = "Where";
        $a_order = array();
        $intWLblEntidad = 900;

        $a_separs = array();
        $a_separs[] = array(0, 'Ver información', 6, 'separ_verde');
        $field[] = array('idopc', 'idopc', '1', 'hidden', '1', '', 'int', 1, 200, 10, 2, '', 0, 1, 1, '');

        $field[] = array('cve_persona', 'cve_persona', '1', 'hidden', '1', '', 'char', '1', 200, 100, 100, '', 1, array(1, 'col-12 col-sm-12', 'col-12 col-sm-6'), array(1, 1, 6));

        $a_check = array(); // si un elemento empieza por uno  los elementos siempre se cosideraran para el reporte sean obligatorios o no 
        $a_check[] = array(1, array('idopc', 'cve_persona'));




//echo("sstr".$$str_file_name);
        for ($x = 0; $x < 10; $x++) {
            $str_file_name = 'vparfile' . $x;

            if (isset($$str_file_name))
                $field[] = array($str_file_name, $str_file_name, '1', 'hidden', '2', '', 'char', $$str_file_name, 100, 20, 0, '', 0, 1, 1, 0, $str_file_name);
        }



        $stropen = 'rep/rep_todos_mod_im.php?';
        $keyFields = array('null');
        $keyTypeFields = array('text'); //int,text
        $keyFieldsUnique = array('null');
        $keyTypeFieldsUnique = array('text'); //int,text
        $array_noprint_ent = array('null');
        $suma_width = 0;
        $rwitem = 'null';
        $strwentidad = "repentidad2_info.php";

//$vparitem=0;
        $strSelf = "ir_impresion.php";
        $ValsendRep2 = 'sendRep2';
        $numcols = 0;
        foreach ($field as $afield) {
            if ($afield[2] == '1') {
                $suma_width += $afield[8];
                $numcols += 1;
            }
        }
        if (isset($vpar_int01) and $vpar_int01 == 2) {
            $awidths = array('100', '150', '950');
        } else {
            $awidths = array('100', '150', '950');
        }




        $a_getn_fields = array('fecha_dato', 'fecha_registro');
        $a_getn_fields2 = array('fecha_dato', 'fecha_registro');
// // des_marca des_tipo_vehiculo   modelo   placas   num_serie
        $str_Fields = " fecha_dato,fecha_registro ";



        $a_getl_fields = array('Fecha del archivo', 'Fecha importado');


        $a_getv_fields = array(' ', ' ');
        $a_align_fields = array('C', 'C');
        $a_width_fields = array('100', '100');


        $tablas_qry = " master_datos
";

        $str_pcWhere .= " 1=1 ";
//$str_pcWhere= " nivel=0 or nivel=1 ";

        $paso = false;
        $str_groupby = " order by fecha_dato desc  limit 365";
//$str_groupby = " GROUP BY pis.cve_orden_servicio,pis.cve_ingeniero_servicio,pis.cve_estatus order by d.cve_det_orden_soporte desc ";





        if (strlen(trim($str_pcWhere)) > 0)
            $str_pcWhere = " WHERE " . $str_pcWhere;

        $str_Qry = "SELECT " . $str_Fields . " FROM " . $tablas_qry . $str_pcWhere . $str_groupby;

        //die($str_Qry);

        $classent = new Entidad($a_getn_fields, $a_getv_fields);
        $classent->ListaEntidades(array(), "", "", "", "no", "", $str_Qry);
        $ar_th = ['', 'oscuro_1', 'claro_1'];
        $ar_tha = ['', 'table_hover_oscuro', 'table_hover_claro'];
        $tabla_pintar_tit = "";
        $tabla_pintar_tit = '<table width="100%" border="0" class="table table-hover color_negro tabla_sys_en rounded"  style="">';
        $caption_table = '<caption class="color_negro" style="caption-side: top;padding-top: .1rem;padding-bottom: .1rem;height:40px;"><h4 class="h5 font-weight-bold rounded claro_3" style="background-color:#ffffe0;color:#000000;padding-top:.15em;padding-bottom: 7px;">Datos de archivos</h4></caption>';
        $tabla_pintar_tit .= '' . $caption_table;
        $tabla_pintar_tit .= '<tr>';
        for ($index2 = 0; $index2 < count($a_getl_fields); $index2++) {
            $tabla_pintar_tit .= '<th style="text-align:left;" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">' . $a_getl_fields[$index2] . '</th>';
        }
        $tabla_pintar_tit .= '</tr>';
        $ar_bot = array("", "punteados_l oscuro_b", "punteados_s claro_b");

        $pos_actual = 0;
        for ($i = 0; $i < $classent->NumReg; $i++) {
            $classent->VerDatosEntidad($i, $a_getn_fields2);
            $tabla_pintar_tit .= '<tr class="' . $ar_tha[$__SESSION->getValueSession('theme') * 1] . '">';
            foreach ($a_getn_fields as $key => $value) {
                if ($key == 0) {
                    $var_form = '<form action="index.php?mod=12" method="post"><input type="hidden" id="fecha_ar" name="fecha_ar" value="' . ($classent->$value) . '"><button type="submit" class="btn boton_act punteados ' . $ar_bot[$__SESSION->getValueSession('theme') * 1] . '">' . ($classent->$value) . '</button></form>';
                    $tabla_pintar_tit .= '<th colspan="" style="text-align:left;">' . $var_form . '</th>';
                } else {
                    $tabla_pintar_tit .= '<th colspan="" style="text-align:left;">' . ($classent->$value) . '</th>';
                }
            }
            $tabla_pintar_tit .= '</tr>';
        }
        $tabla_pintar_tit .= '</table>';
        $tabla_pintar2 = $tabla_pintar_tit;
        $tabla_pintar = $TITULO . $tabla_pintar_tit;
        // die($tabla_pintar);
    }
} else {
    include_once("../config/cfg.php");
    include_once("../lib/lib_function.php");
    include_once("sb_refresh.php");
}

function fnBeforeLoad() {
    echo '<script>valida_impresion();</script>';
}
?>
<script language="javascript">//titlesAsis
    function valida_impresion() {
        if (<?php echo $mos_boton; ?> + "" == '1') {
            $("#submit").css("display", "none");
            $("#cancela_e2").css("display", "none");
        }

    }
    document.notBussyKeyEnter = true;
    document.reTKey = true;
    //document.entidades=<?php echo "{" . $document_entidades . "};"; ?>
    var posicionListaFilling = 0;
    var datos = new Array();
    var theObj;
    var listaE = new Array();
    var textoAnt = "";
    window.onload = function () {
        var divAuto = document.createElement("div");
        divAuto.id = "div_LstAuto";
        document.body.appendChild(divAuto);
        document.onReady = function (objItem) {
        }
    }
</script>
<script language="JavaScript" src="js/auto_disp.js"></script>
<script language="JavaScript">
    function getSelect(target, liga, obj, entvalue, numAdd, initialize) {
        cadena = '';
        if (varval = document.getElementById(obj).value) {
            cadena = 'varval=' + varval + '&entvalue=' + entvalue + '&numAdd=' + numAdd + '&initialize=' + initialize;
            selflink = liga + '.php';
            cargar_xml(target, selflink, cadena);
        }
    }
    function initializeObjText() {
        args = initializeObjText.arguments;
        for (i = 0; i < args.length; i += 2) {
            document.getElementById(args[i]).value = args[i + 1];
        }
    }
</script>
<script language="JavaScript">
    function getKeyFalse(e) {
        document.reTKey = true;
        if (window.event) {
            keynum = e.keyCode;
        } else if (e.which) {
            keynum = e.which;
        }
        if (keynum == 13) {
            if (document.notBussyKeyEnter == false) {
                document.reTKey = false;
            }
        }
    }//return reTKey;}

</script>
<script language="javascript">
    function initializeObjText() {
        args = initializeObjText.arguments;
        e = args[0];
        if (window.event) {
            keynum = e.keyCode;
        } else if (e.which) {
            keynum = e.which;
        }
        if (document.notBussyKeyEnter && keynum != 13) {
            for (i = 1; i < args.length; i += 2) {
                document.getElementById(args[i]).value = args[i + 1];
            }
        }
    }
    function fnValida() {
        args = fnValida.arguments;
        if (document.getElementById(args[0]).value.length == 0) {
            hideMeAutoLst();
            xSpan = document.getElementById("span_" + args[1]);
            setMsgSpan(xSpan, '<img src="img/img43.gif" border="0" >', '#FF0000');
        }
    }


    function getSelectXiniX() {
        args = getSelectXiniX.arguments;
        target = args[0];
        liga = args[1];
        numAdd = args[2];
        initialize = args[3];
        var varval = "";
        var xPos = 0;
        for (i = 4; i <= (args.length - 1); i++) {

            if (args[i].indexOf("objIni_") == -1 && args[i].indexOf("objGet_") == -1) {
                val = findObj(args[i]);
                if (val) {
                    if ((val = val.value.trim()) != "") {
                        if (i > 4)
                            varval += "::";
                        varval += val;
                    } else {
                        return;
                    }
                } else {
                    return;
                }
            } else {
                xPos = args[i].indexOf("objIni_");
                if (xPos == -1)
                    xPos = args[i].indexOf("objGet_");
                disableSelect(document.getElementById(args[i].substring(xPos + 7)), "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            }
        }
        cadena = '';
        cadena = 'varval=' + varval + '&numAdd=' + numAdd + '&initialize=' + initialize;
        selflink = liga + '.php';
        cargar_xml(target, selflink, cadena);
        for (i = 4; i <= (args.length - 1); i++) {
            if (args[i].indexOf("objGet_") != -1) {
                varval = "";
                xPos = 0;
                cadena = "";
                for (j = 4; j <= (args.length - 1); j++) {
                    if (args[j].indexOf("objIni_") == -1 && args[j].indexOf("objGet_") == -1) {
                        val = findObj(args[j]);
                        if (val) {
                            if ((val = val.value.trim()) != "") {
                                if (j > 4)
                                    varval += "::";
                                varval += val;
                            } else {
                                return;
                            }
                        } else {
                            return;
                        }
                    }
                }

                xPos = args[i].indexOf("objGet_");
                cadena = 'varval=' + varval + '&numAdd=' + args[i].substring(0, xPos - 1) + '&initialize=' + initialize;
                cargar_xml(args[i].substring(xPos + 7), selflink, cadena);
            }
        }
    }

</script>
