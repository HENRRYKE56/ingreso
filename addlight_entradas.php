<?php

//die("asdas asd asd as");
$str_check = TRUE;
//include_once("includes/iii_check.php");
if ($str_check) {

    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    $lbl_tit_mov = "[ nuevo registro ]";
    $frmname = "frmadd_ligth";
    $vars_obj = "";
    $array_obj = $field;
    $campos_nuevos_en = array();
    for ($index = 0; $index < count($field); $index++) {
        $campos_nuevos_en[] = $field[$index][0];
    }

    $bdate = 0;
    $vars_post = "";
    $classind = new Entidad($campos_nuevos_en, $campos_nuevos_en);
    $classind->Consultar($campos_nuevos_en, $id_prin, $tabla, $strCondConsul);
//                echo '<pre>';
//                print_r($classind);die();
    foreach ($array_obj as $afield) {
        if (($afield[6] == 'date' || $afield[6] == 'datetime') && $afield[3] == 'text') {
            $conf_d = ''; //$("#pag_dialog").attr("tabindex","0");
            $fun_adicional = 'onClose:function(){$("#pag_dialog").attr("tabindex","-1");},';
            if ($afield[6] == 'date') {

                $conf_d = "changeMonth: true,
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
            " . $fun_adicional . "
            ";
            } else {
                $conf_d = "changeMonth: true,
                            changeYear: true,
                            controlType: 'select',
                            oneLine: true,
                            dateFormat: 'dd/mm/yy',
                            timeFormat: 'HH:mm',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], "
                        . $fun_adicional . " ";
            }
            $ar_date_t[] = array($afield[0], isset($afield[25]) ? $afield[25] : $conf_d, $afield[26]);
        }
        if ($afield[6] == 'date' && $afield[3] == 'text')
            $bdate = 1;
        if (($afield[3] == 'text' || $afield[3] == 'textarea' || ($afield[3] == 'hidden' && $afield[12] == 1) || ($afield[3] == 'label' && $afield[12] == 1) || (($afield[3] == 'select' || $afield[3] == 'lst2') && $afield[12] == 1)) || ($afield[3] == 'check')) {

            if (strlen($vars_obj) > 0)
                $vars_obj .= ",";
            $vars_obj .= "'" . $afield[0] . "','" . $afield[7] . "','" . ($afield[12] == 1 ? 'R' : '') . (($afield[3] == 'select' || $afield[3] == 'lst2') ? 'isSelect' : ($afield[6] == 'int' || $afield[6] == 'money' ? 'isNum' : ($afield[6] == 'date' ? 'isDate' : ($afield[3] == 'check' ? 'isCheck' : 'isTxt')))) . "' ,'" . $afield[1] . "','" . $afield[11] . "'";
        }
        if ($afield[4] == '1' || $afield[4] == '2') {
            if (strlen($vars_post) > 0)
                $vars_post .= ",";
            $vars_post .= "'" . $afield[0] . $strkey . "'";
        }
        if ($afield[3] == 'file')
            $fileExist = true;
    }
    $vars_post .= ",'btnActualizaLight'";
    if (strlen($vars_obj) > 0) {
        $vars_obj = "onClick=\"obj_valObj(2," . $vars_obj . ");sendAdm2('" .
                $_POST['objname'] . "','adm_light','" . $_POST['objname'] . "','" .
                $_POST['numpar'] . "','" . $_POST['numAdd'] . "'," . $vars_post . "); return false;\""; //document.obj_retVal;\"";
    } else {
        $vars_obj = "onClick=\"sendAdm2('" .
                $_POST['objname'] . "','adm_light','" . $_POST['objname'] . "','" .
                $_POST['numpar'] . "','" . $_POST['numAdd'] . "'," . $vars_post . "); return false;\""; //document.obj_retVal;\"";
    }
   // die($vars_obj);
    echo '<div id="espacio_' . $frmname . '" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
            <p id="texto_' . $frmname . '" class="color_negro"></p>
          </div>  ';

    echo '<div class="content m-1" id="app_datos">
                        <div class="animated fadeIn">
                            <div class="row">
                                <div class="col-lg-12">';
    echo '                      <div id="accordionGroup" class="Accordion">';
    echo "<form name=\"$frmname\" id=\"$frmname\" method=\"post\" aria-labelledby = \"legend_" . $frmname . "\" style=\"margin:0; padding:0;\" " . (($fileExist) ? " enctype=\"multipart/form-data\"" : "") . " > \n";
    echo '<fieldset><legend id = "legend_' . $frmname . '" style="display:none;" >Modificar ' . $entidad . '</legend>';
    $style = $CFG_LBL[30];
    $bgstyle = $CFG_BGC[6];
    $row_open = 0;
    $cont_separs = 0;
    $strhidden = "";
    $arreglo_hidden_label = array();
    $select2 = '';
    //separadores por cada separa
    if (isset($a_separs) && count($a_separs) > 0 && is_array($a_separs)) {
        
    } else {
        $a_separs[] = array(0, '', count($field), 'bg-dark');
    }
    $inicio = 0;
    $pinta_form = "";
    if (isset($a_separs) && count($a_separs) > 0 && is_array($a_separs)) {
        
    } else {
        $a_separs[] = array(0, '', count($field), 'separ_verde');
    }
    for ($index2 = 0; $index2 < count($a_separs); $index2++) {
        $ariaexpanded = 'Expandir';
        $d_hidden = '';
        $pinta_form .= '<div class="card">
                <h3 class="color_negro h3">
                                            <span aria-label="' . ($ariaexpanded == "true" ? 'Contraer' : 'Expandir') . '" aria-expanded="' . $ariaexpanded . '" class="btn card-header ' . $a_separs[$index2][3] . ' Accordion-trigger punteados w-100">
                                                <span style="width:100% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;' . $a_separs[$index2][1] . '</span>
                                            </span>  
                </h3>';
        $pinta_form .= '<div class="card-body card-block" role="region" aria-labelledby="accordion' . ($a_separs[$index2][0]) . 'id" class="Accordion-panel" id="a_' . $a_separs[$index2][0] . '" ' . $d_hidden . '>';
        $pinta_form .= '<div class="row form-group">';
        for ($cont = $inicio; $cont < $a_separs[$index2][2] + $inicio; $cont++) {//echo '<br />'.$cont;
            $afield = $field[$cont];
            if ($afield[4] == '1' || $afield[4] == '2') {
                if ($afield[3] == 'hidden') {
                    $pinta_form .= genInput($afield[3], $afield[0], $afield[7]) . " \n";
                } else {
                    $l_des = "";
                    $span_des = "";
                    $descripcion = "";
                    if (is_array($afield[1])) {
                        $l_des = ' aria-describedby="a_d_' . $afield[0] . '" ';
                        $span_des = '<span id="a_d_' . $afield[0] . '" >' . $afield[1][1] . '</span>';
                        $descripcion = $afield[1][0];
                    } else {
                        $descripcion = $afield[1];
                    }
                    $input_check = '';
                    //$for_label='';
                    if (in_array($afield[0], array('NUMFAC', 'identificador', 'CVEUNI'))) {
                        $input_check = '<input class="checks_forms" type="checkbox" id="l_c_' . $afield[0] . '" name="l_c_' . $afield[0] . '">';
                        //$for_label=' for="l_c_'.$afield[0].'" ';
                    }
                    $pinta_form .= '<div class="row ' . $afield[13][2] . '" id="div_' . $afield[0] . '">
                                        <div class="col-12" style="min-height: 30px;">' . $input_check . '<label for="' . $afield[0] . '" id="l_' . $afield[0] . '" class="form-control-label f_cmb_l" ' . $l_des . '>' .
                            (($afield[4] <> 0 ? $descripcion : '')
                            . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-label="*" aria-hidden="true" style="font-size:10px;color:red;"></i>' : ''))
                            . '&nbsp;<i id="i_a' . $afield[0] . '" aria-hidden="true"></i></label>' . $span_des . '</div>
                                        <div class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') . $afield[13][1] . '">';

                    switch ($afield[3]) {
                        case 'text':
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            $pinta_form .= genInput($afield[3], $afield[0], $afield[7]
                                            , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
                                            , ($afield[6] == 'date' ? $frmname : $afield[1]), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"'), ($afield[12] == 1 ? $afield[12] : 0)) .
                                    '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'file':
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            $pinta_form .= genInput('file', $afield[0], $afield[7], '', $afield[9], '', 'form-control-file', '', '', '9', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"') .
                                    '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'select':
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            $stronclick = "";
                            if (isset($afield[5][2])) {
                                if ($afield[5][2] == 1)
                                    $stronclick = 'onChange="document.' . $frmname . '.sel.value=\'' . $afield[0] . '\';submit();return false;"';
                            }
                            $strAddSel = '';
                            if (isset($afield[5][3]))
                                $strAddSel = $afield[5][3];
                            #----------------------------------------------------------------------------#
                            if (isset($afield[5][4]) && sizeof($afield[5][4]) > 0) {
                                $cont_txts = 0;
                                foreach ($afield[5][4] as $item_texts_a) {
                                    $pinta_form .= ($cont_txts > 0 ? "&nbsp;" : '') . $item_texts_a[0];
                                    $pinta_form .= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'txtbox', '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $afield[1], ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                    $cont_txts++;
                                }
                            }
                            //$("#cveArea").select2();
                            if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                $select2 .= "$('#" . $afield[0] . "').select2();";
                            }
                            $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                    genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''), ((isset($afield[5][7]) && strlen($afield[5][7]) > 0) ? $afield[5][7] : ''));
                            $pinta_form .= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'lst2':

                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            $stronclick = "";
                            if (isset($afield[5][2])) {
                                if ($afield[5][2] == 1)
                                    $stronclick = 'onChange="document.' . $frmname . '.sel.value=\'' . $afield[0] . '\';submit();return false;"';
                            }
                            $strAddSel = '';
                            if (isset($afield[5][3]))
                                $strAddSel = $afield[5][3];
                            #----------------------------------------------------------------------------#
                            if (isset($afield[5][4]) && sizeof($afield[5][4]) > 0) {
                                $cont_txts = 0;
                                foreach ($afield[5][4] as $item_texts_a) {
                                    $pinta_form .= ($cont_txts > 0 ? "&nbsp;" : '') . $item_texts_a[0];
                                    $pinta_form .= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'txtbox', '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $afield[1], ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                    $cont_txts++;
                                }
                            }
                            //$("#cveArea").select2();
                            if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                $select2 .= '$("#' . $afield[0] . '").select2();';
                            }
                            $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                    genSelect($afield[0] . "[]", '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="js-example-basic-multiple form-control" multiple="multiple" size="6"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                            $pinta_form .= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';

                            break;
                        case 'check':
                            $accion = '';
                            if (isset($afield[21]))
                                $accion = $afield[21];
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            if (isset($afield[16]) && $afield[16] == 1) {
                                $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                            } else if (isset($afield[16]) && $afield[16] == 2) {
                                $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . '<span style="font-size: 11px;">&nbsp;' . $afield[1] . '&nbsp;</span>';
                            } else {
                                $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                            }
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'label':
                            $arreglo_hidden_label = $afield[0];
                            $pinta_form .= genInput('hidden', $afield[0], $afield[7]) . $afield[7] . "";
                            break;
                        case 'textarea':
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            $pinta_form .= genTArea($afield[0], '', '', $afield[9][0], $afield[9][1], 'form-control ' . $style_all) . (is_array($afield[10]) ? "<br/><script language=\"javascript\">displaylimit('document." . $frmname . "." . $afield[0] . "'," . $afield[10][0] . "," . $afield[10][1] . ")</script>" : '');
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
//                        case 'button':
//                            $pinta_form .= '<button id="btn_bus" type="button" class="col-12  btn separ_amarillo punteados border border-dark" onclick="busca_entrada(1);" alt="Buscar entrada" style="font-size:13px;">Buscar</button>'
//                                    . '<button id="btn_new" type="button" class="col-12  btn separ_azul punteados border border-dark" alt="Nueva entrada" onclick="nueva_entrada();" style="font-size:12px;">Habilitar</button>'
//                                    . '<button id="btn_sv" type="button" class="col-12 btn separ_verde_claro punteados border border-dark" alt="Limpiar registro" onclick="proc_guarda();" style="font-size:13px;" disabled>Guardar</button>'
//                                    . '<button id="btn_lim" type="button" class="col-12  btn separ_naranja punteados border border-dark" alt="Limpiar registro" onclick="limpia_registro();" style="font-size:13px;">Limpiar</button>'
//                                    . '<button id="btn_det" type="button" class="col-12  btn separ_rojo_claro punteados border border-dark" alt="Limpiar registro" onclick="detalle_registro();" style="font-size:13px;">Detalle</button>'
//                                    . '';
//                            break;
                    }
                    $pinta_form .= '</div></div>';
                }
            }
        }
        $inicio = $cont;
        $pinta_form .= '</div>';
        $pinta_form .= '</div>';
        $pinta_form .= '</div>';
    }
    echo '' . $pinta_form;

    echo '<button id="btn_sv_det" type="button" class="col-12 col-sm-3 btn separ_verde_claro punteados border border-dark" alt="Guardar detalle de entrada" onclick="proc_guarda_det();" style="font-size:13px;" disabled>Guardar</button>';
    echo '<button id="btn_new" type="button" class="col-12 col-sm-3  btn separ_azul punteados border border-dark" alt="Habilitar detalle de entrada" onclick="nueva_entrada_det();" style="font-size:12px;">Habilitar</button>';
    echo '<button id="btn_lim" type="button" class="col-12 col-sm-3  btn separ_naranja punteados border border-dark" alt="Limpiar detalle de entrada" onclick="limpia_registro_det();" style="font-size:13px;">Limpiar/Nuevo</button>';
    
    echo '<button type="button" class="col-12 col-sm-3  btn separ_rojo punteados border border-dark" data-dismiss="modal" alt="Cerrar ventana de detalle de entrada">Cerrar</button>';

    echo "</fieldset></form></div></div></div></div></div>";

    echo "<script language=\"JavaScript\">\n";
    echo "var FORM_OBJECTS = [\n" . $str_obj_jsrpt . "]\n";
    echo "objSelIni ();\n";
    echo "</script>\n";
    if (count($ar_date_t) || strlen($select2) > 0) {
        echo "<script language='JavaScript'>";
        echo "$(document).ready(function (){";
        echo '' . $select2;
        if (count($ar_date_t)) {
            for ($index1 = 0; $index1 < count($ar_date_t); $index1++) {
                echo "var " . $ar_date_t[$index1][0] . " = $('#" . $ar_date_t[$index1][0] . "').datetimepicker({" .
                $ar_date_t[$index1][1] . "
        });
        " . $ar_date_t[$index1][2] . "       
        ";
            }//
        }
        echo " });"
        . "function mensaje(div_s){" . 'jQuery("#"+div_s).datetimepicker("show");$("#pag_dialog").removeAttr("tabindex");dayTripper(div_s);' . "}</script>";
    }
}
//$("#pag_dialog").attr("tabindex","0");$(".ui-datepicker-div").attr("tabindex","-1");$("#pag_dialog").attr("aria-hidden","true");$("#skipnav").attr("aria-hidden","true");
?>
      