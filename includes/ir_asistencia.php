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
    $strWhere.=" and sb_perfil_modulo.cve_modulo=" . $__SESSION->getValueSession('mod');
    $strWhere.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
    $strWhere.=" and sb_modulo.sta_modulo<>0";
    $classval = new Entidad($allf, $allv);
    $classval->Consultar($allf, $IdPrin, $tabla, $strWhere);
    $str_valmodulo = "MOD_NOVALIDO";
    if ($classval->NumReg > 0) {
        /* ----------JURISDICCION--------------------- */
        $obligatorio = 0;
        $entidad="<B> KARDEX DE ASISTENCIA</B>";

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


        $date = date('d-m-Y');


        $str_iconos = "<span style=\"color:#356191;font-family:arial; background-color:#FEFFDF;font-size: 11px;line-height:10px;height:11px;border:#A9C472 1px solid;\">" .
                "<img alt=' Generar reporte ' height='16' width='16' border='0' src='img/img21.gif'> Generar reporte  &nbsp; &nbsp; " .
                "<img alt=' Cancelar reporte' height='16' width='16' border='0' src='img/img08.gif'> Cancelar reporte   " .
                "</span>";
     

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
      //  $a_separs[] = array(0, 'Criterios para generar reporte', 6, $CFG_BGC[10]);
        $field[] = array('idopc', 'idopc', '1', 'hidden', '1', '', 'int', 1, 200, 10, 2, '', 0, 1, 1, '');
        $conf_date = "
            changeMonth: true,
            changeYear: true,
            controlType: 'select',
            oneLine: true,
            dateFormat: 'dd/mm/yy',
            timeFormat: '',
            buttonText: '<i class=\'fa icon-calendar\'></i>',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            showOn: 'button',
            showClose: true,
            closeText:'Cerrar',            
            timeText:'',
            " .
//"            beforeShow: valid_fecha,".
//"            onSelect: accion_select,"
//            timeFormat: 'HH:mm',                 
                "";
//         $conf_funciones="function valid_fecha() {
//            }";
        $conf_funciones = "";
        $field[] = array('fecha_ini', 'Fecha Inicial', '1', 'text', '1', '', 'date', date("d/m/Y"), 100, 10, 0, '', 1, array(1, 'col-12 col-sm-12','col-12 col-sm-6'), array(1, 1, 1), '', 0, 'Fecha de nacimiento', 0, '',
            '', '', '', '', '', /* conf date jquery */ $conf_date, /* funcion */ $conf_funciones);        
        $field[] = array('fecha_fin', 'Fecha Final', '1', 'text', '1', '', 'date', date("d/m/Y"), 100, 10, 0, '', 1, array(1, 'col-12 col-sm-12','col-12 col-sm-6'), array(1, 1, 1), '', 0, 'Fecha de nacimiento', 0, '',
            '', '', '', '', '', /* conf date jquery */ $conf_date, /* funcion */ $conf_funciones);           
        $a_check = array();
        $a_check[] = array(1, array('idopc','fecha_ini','fecha_fin' ));        

        for ($x = 0; $x < 10; $x++) {
            $str_file_name = 'vparfile' . $x;

            if (isset($$str_file_name))
                $field[] = array($str_file_name, $str_file_name, '1', 'hidden', '2', '', 'char', $$str_file_name, 100, 20, 0, '', 0, 1, 1, 0, $str_file_name);
        }



      

        $stropen = 'rep/rep_todos_mod.php?';
        $keyFields = array('null');
        $keyTypeFields = array('text'); //int,text
        $keyFieldsUnique = array('null');
        $keyTypeFieldsUnique = array('text'); //int,text
        $array_noprint_ent = array('null');
        $suma_width = 0;
        $rwitem = 'null';
        $strwentidad = "repentidad2.php";

//$vparitem=0;
        $strSelf = "ir_asistencia.php";
        $ValsendRep2 = 'sendRep2';
        $numcols = 0;
        foreach ($field as $afield) {
            if ($afield[2] == '1') {
                $suma_width+=$afield[8];
                $numcols+=1;
            }
        }
        if (isset($vpar_int01) and $vpar_int01 == 2) {
            $awidths = array('100', '150', '950');
        } else {
            $awidths = array('100', '150', '950');
        }

    }
} else {
    include_once("../config/cfg.php");
    include_once("../lib/lib_function.php");
    include_once("sb_refresh.php");
}
?>
<script language="javascript">//titlesAsis

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
