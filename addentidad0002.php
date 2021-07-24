<?php
$str_check = FALSE;
include_once("config/cfg.php");
include_once("includes/sb_iii_check.php");
if ($str_check) {
    if (trim($a_key[0]) == '100') {

        include_once("lib/lib_pgsql.php");
        include_once("lib/lib_entidad.php");
        $lbl_tit_mov = "&nbsp; [ nuevo ]";

//        echo genOTable(0, $awidths[1] + $awidths[2], '', '', $CFG_BGC[6], '0', '1');

        /* < --- Inicia mensaje de error de accion--- > */

        if (strlen($__SESSION->getValueSession('msg')) > 1) {
            $str_msg_red = "";
            $i_intstyle = 29;
            $i_intcolor = 6;
            for ($i = 0; $i < (strlen($__SESSION->getValueSession('msg')) / 3); $i++) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red .= ',&nbsp;&nbsp;';
                $str_msg_red .= $CFG_MSG[(substr($__SESSION->getValueSession('msg'), $i * 3, 3) * 1)];
            }
            $__SESSION->SetValueSession('msg', '0');

            include("includes/sb_msg_bob.php");
        }
        /* < --- Termina mensaje de error --- > */

        /* < --- Inicia mensaje de error de validacion --- > */

        if (strlen($__SESSION->getValueSession('msgval')) > 0) {

            $str_msg_red = "";
            $i_intstyle = 29;
            $i_intcolor = 6;
            $a_msgval = explode(',', $__SESSION->getValueSession('msgval'));
            foreach ($a_msgval as $ifield) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red .= ',<br>';
                $str_msg_red .= $field[$ifield][1] . ": " . $CFG_MSG[6];
            }
            $__SESSION->unsetSession('msgval');
            include("includes/sb_msg_bob.php");
        }

        /* < --- Termina mensaje de error --- > */
        $__SESSION->unsetSession('valAlert');

        /* -------------valores de session, si es que los hay------------- */
        if ($__SESSION->getValueSession('a_tmpValues') <> "") {
            $add_tmpValues = $__SESSION->getValueSession('a_tmpValues');
            $__SESSION->unsetSession('a_tmpValues');
            $allvalues = array();
            $cont = 0;
            //print_r($a_tmpValues);
            foreach ($field as $afield) {

                if ($afield[4] == '1' || $afield[4] == '2') {
                    if ($afield[3] == 'hidden' and $afield[5] == 'textarea') {
                        $allvalues[] = str_replace("'", " ", stripcslashes($add_tmpValues[$cont]));
                    } else {
                        $allvalues[] = $add_tmpValues[$cont];
                    }

                    $cont++;
                } else {
                    $allvalues[] = $afield[7];
                }
            }
        }

        //print_r($allvalues);
        $classind = new Entidad($allfields, $allvalues);

        /* ------------------------------- */
        $niveles_s = array();
        $lis = "";
        foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
            //echo $item."|".$strSelf."|".$cont; //die();
            if ($cont > 0) {
                /* primer renglon en blanco */
                $strfields_prin2 = ""; //cambiar los arreglos de session 

                $atmp_mdFields = $__SESSION->getValueSession('mdFields');
                $atmp_mdTFields = $__SESSION->getValueSession('mdTFields');
                $atmp_mdKeyFields = $__SESSION->getValueSession('mdKeyFields');
                $atmp_mdKeyFields2 = $__SESSION->getValueSession('mdKeyFields2');
                $atmp_mdKeyTFields = $__SESSION->getValueSession('mdKeyTFields');
                $atmp_mdValFields = $__SESSION->getValueSession('mdValFields');
                $atmp_mdStrFields = $__SESSION->getValueSession('mdStrFields');
                $atmp_mdTable = $__SESSION->getValueSession('mdTable');
                $atmp_m_NokeyFields = $__SESSION->getValueSession('m_NokeyFields');

                if (isset($atmp_mdFields[$cont]) && isset($atmp_mdKeyFields[$cont]) && isset($atmp_mdValFields[$cont])) {
                    foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                        if (strlen($strfields_prin2) > 0)
                            $strfields_prin2 .= ", ";
                        $strfields_prin2 .= $afield;
                        if ($atmp_mdTFields[$cont][$cont2] == 'num') {
                            $avalues_prin2[] = 0;
                        } else {
                            $avalues_prin2[] = '';
                        }
                    }
                    $strWherePrin2 = "";
                    if (!isset($atmp_m_NokeyFields[$cont]))
                        $atmp_m_NokeyFields[$cont] = array();
                    $arraytmpX = $atmp_m_NokeyFields[$cont];
                    foreach ($atmp_mdKeyFields[$cont] as $cont2 => $afield) {
                        if (isset($atmp_mdKeyFields2) && is_array($atmp_mdKeyFields2) && (count($atmp_mdKeyFields2[$cont]) == count($atmp_mdKeyFields[$cont])) && isset($atmp_mdKeyFields2[$cont][$cont2])) {
                            $afield = $atmp_mdKeyFields2[$cont][$cont2];
                        }
                        if (!in_array($afield, $arraytmpX)) {
                            if (strlen($strWherePrin2) > 0)
                                $strWherePrin2 .= " and ";
                            if ($atmp_mdKeyTFields[$cont][$cont2] == 'num') {
                                if (isset($cambi_nombre))
                                    $strWherePrin2 .= $cambi_nombre . "=" . $atmp_mdValFields[$cont][$cont2];
                                else
                                    $strWherePrin2 .= $afield . "=" . $atmp_mdValFields[$cont][$cont2];
                            } else {
                                $strWherePrin2 .= $afield . "='" . $atmp_mdValFields[$cont][$cont2] . "'";
                            }
                        }
                    }
                } else {
                    $__SESSION->unsetSession('niv');
                    $str_msg_red = 'DATOS NO VALIDOS';
                    include_once("includes/sb_msg_red.php");
                    echo "<meta http-equiv='refresh' content='2;URL=" . $_SERVER['PHP_SELF'] . "'>";
                    die();
                }

                if (isset($atmp_mdStrFields[$cont])) {
                    $strfields_prin2 = $atmp_mdStrFields[$cont];
                    $strfields_prin2 = is_array($strfields_prin2) ? implode(",", $strfields_prin2) : $strfields_prin2;
                }
                if (isset($atmp_mdTable[$cont])) {
                    $tmp_tables = $atmp_mdTable[$cont];
                    $tmp_tables = is_array($tmp_tables) ? implode(",", $tmp_tables) : $tmp_tables;
                }

                $strWherePrin2 = 'Where ' . $strWherePrin2;
                $classconsul = new Entidad($atmp_mdFields[$cont], $avalues_prin2);
                $classconsul->ListaEntidades(array(), $tmp_tables, $strWherePrin2, $strfields_prin2, "no");
                $classconsul->VerDatosEntidad(0, $atmp_mdFields[$cont]);
                $strvalcol = (isset($a_mdLabel) ? $a_mdLabel[$cont - 1] : '');
                $niveles_s[] = $strvalcol;
                foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                    if ($classconsul->$afield <> 'null' && $classconsul->$afield <> "") {
                        $niveles_a[] = $classconsul->$afield;
                    }
                }
                /* termina primer renglon en blanco */
            }
            if ($item == $strSelf)
                break;
        }
        $link_niv = array();
        if ($__SESSION->getValueSession('niveles') <> "")
            foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
                if ($cont > 0)
                    $link_niv[] = $_SERVER['PHP_SELF'] . '?nivel=' . ($cont - 1);
            }


        if (isset($niveles_s) || isset($niveles_a)) {
            $icono = "";
            for ($index = 0; $index < count($niveles_a); $index++) {
                if ($index == 0) {
                    $icono = '<i class="fa fa-home" style="font-size:1.3em;color:#7fffd4;"></i>&nbsp;';
                } else {
                    $icono = '';
                }
                $lis .= '<li class="breadcrumb-item"><a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' style="color:#f5f5dc;" data-toggle="tooltip" title="' . $niveles_a[$index] . '">' . $icono . $niveles_s[$index] . '</a></li>';
                //  $lis.= '<a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' class="tip-bottom text-secondary" data-toggle="tooltip" title="' . $niveles_a[$index] . '" style="font-size:17px;text-decoration: none;">&nbsp;' . $icono . $niveles_s[$index] . '</a>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i>';
            }
        }
        $frmname = 'frmadd';
    

          echo '<h2>'.$entidad . $lbl_tit_mov.'</h2>';
        echo '<div id="espacio_' . $frmname . '" class="alert alert-dismissible fade show rounded alert_warning_sys" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
            <p id="texto_' . $frmname . '" class="color_negro"></p>
          </div>  ';
        /* termina renglon master */
        $vars_obj = "";
        $array_obj = $field;

        $bdate = 0;
        $fileExist = false;
        $ar_date_t = array();
        foreach ($array_obj as $afield) {
            if (($afield[6] == 'date' || $afield[6] == 'datetime') && $afield[3] == 'text') {
                $conf_d = '';
                if ($afield[6] == 'date') {
                    $conf_d = "changeMonth: true,
                            changeYear: true,
                            controlType: 'select',
                            oneLine: true,
                            dateFormat: 'dd/mm/yy',
                            timeFormat: '',
                            showTime: false,";
                } else {
                    $conf_d = "changeMonth: true,
                            changeYear: true,
                            controlType: 'select',
                            oneLine: true,
                            dateFormat: 'dd/mm/yy',
                            timeFormat: 'HH:mm',";
                }
                $ar_date_t[] = array($afield[0], isset($afield[25]) ? $afield[25] : $conf_d, $afield[26]);
            }
            if ($afield[6] == 'date' && $afield[3] == 'text')
                $bdate = 1;
            if (($afield[3] == 'text' || $afield[3] == 'textarea' || ($afield[3] == 'hidden' && $afield[12] == 1) || ($afield[3] == 'label' && $afield[12] == 1) || (($afield[3] == 'select' || $afield[3] == 'lst2') && $afield[12] == 1)) || ($afield[3] == 'check')) {

                if (strlen($vars_obj) > 0)
                    $vars_obj .= ",";
                $vars_obj .= "'" . $afield[0] . "','" . $afield[7] . "','" . ($afield[12] == 1 ? 'R' : '') . (($afield[3] == 'select' || $afield[3] == 'lst2') ? 'isSelect' : ($afield[6] == 'int' || $afield[6] == 'money' ? 'isNum' : ($afield[6] == 'date' ? 'isDate' : ($afield[3] == 'check' ? 'isCheck' : 'isTxt')))) . "' ,'" . (is_array($afield[1]) ? $afield[1][0] : $afield[1]) . "','" . $afield[11] . "'";
            }
            if ($afield[3] == 'file')
                $fileExist = true;
        }
        if (strlen($vars_obj) > 0) {
            $vars_obj = "onSubmit=\"obj_valObj(2," . $vars_obj . ");show_confirm2('MODULO DE " . strtoupper($entidad) . " :' + String.fromCharCode(10) + String.fromCharCode(13) + '&lt; mensaje de confirmaci&oacute;n &gt;',String.fromCharCode(191) + 'Esta seguro que desea guardar los cambios?');return document.obj_retVal;\"";
        } else {
            $vars_obj = "onSubmit=\"show_confirm('MODULO DE " . strtoupper($entidad) . " :' + String.fromCharCode(10) + String.fromCharCode(13) + '&lt; mensaje de confirmaci&oacute;n &gt;',String.fromCharCode(191) + 'Esta seguro que desea guardar los cambios?');return document.obj_retVal;\"";
        }
        $str_requeridos = "Los campos con&nbsp;&nbsp;<i class='fa fa-asterisk' aria-hidden='true' style='color:red;'></i>&nbsp;&nbsp;son obligatorios";
        $requeridos = '<div class="alert obligatorio_sys"  role="alert" style="padding: .4rem .4rem;margin-bottom: .9rem;margin-top: -12px;color:#000000;">
                                ' . $str_requeridos . '
                            </div>';
        echo $requeridos;
        echo '<div class="content m-1" id="app_datos">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-lg-12">';
        echo '<div id="accordionGroup" class="Accordion">';
        $en_form = "<form id=\"$frmname\" name=\"$frmname\" aria-labelledby = \"legend_" . $frmname . "\" method=\"post\" style=\"margin:0px;\" action=\"" . $_SERVER['PHP_SELF'] . "\"" . (($fileExist) ? " enctype=\"multipart/form-data\"" : "") . " $vars_obj> \n";
        echo '' . $en_form . "";
        echo '<fieldset><legend id = "legend_' . $frmname . '" style="display:none;" >Agregar ' . $entidad . '</legend>';
        $style = $CFG_FSIZE[0];
        $style_all = $CFG_FSIZE[0];
        $bgstyle = '';
        $bgstyle_lbl = '';
        $row_open = 0;
        $cont_separs = 0;
        $strFieldsInput = "";
        $str_obj_jsrpt = "";
        $separador_im = "";
        $arreglo_hidden_label = array();
        $select2 = '';
        //separadores por cada separa
        if (isset($a_separs) && count($a_separs) > 0 && is_array($a_separs)) {
            
        } else {
            $a_separs[] = array(0, '', count($field), 'separ_verde');
        }
        $inicio = 0;
        $pinta_form = "";
        $ariaexpanded = "true";
        $d_hidden = "";
        for ($index2 = 0; $index2 < count($a_separs); $index2++) {
            if ($index2 != 0) {
                $ariaexpanded = "false";
                $d_hidden = "hidden";
            }
            $pinta_form .= '<div class="card div_form_sys">
                <h3 class="color_negro h3">
                                            <button aria-label="' . ($ariaexpanded == "true" ? 'Contraer' : 'Expandir') . '" aria-expanded="' . $ariaexpanded . '" class="btn card-header ' . $a_separs[$index2][3] . ' Accordion-trigger punteados w-100 accordeon_f_' . $index2 . ' b_s_sys" aria-controls="a_' . $a_separs[$index2][0] . '" id="accordion' . ($a_separs[$index2][0]) . 'id">
                                                <span style="width:50% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;' . $a_separs[$index2][1] . '</span><span style="width:50% !important;text-align: right !important;pointer-events: none;" class="Accordion-icon"><i class="' . ($ariaexpanded == "true" ? 'fa fa-chevron-up' : 'fa fa-chevron-down') . '" id="i_' . $a_separs[$index2][0] . '" aria-hidden="true"></i></span>
                                            </button>  
                </h3>';
            $pinta_form .= '<div class="card-body card-block" role="region" aria-labelledby="accordion' . ($a_separs[$index2][0]) . 'id" class="Accordion-panel" id="a_' . $a_separs[$index2][0] . '" ' . $d_hidden . '>';
            $pinta_form .= '<div class="row form-group div_form_acor_sys">';
            for ($cont = $inicio; $cont < ($a_separs[$index2][2]) + $inicio; $cont++) {
                $afield = $field[$cont];
                if ($afield[4] == '1' || $afield[4] == '2') {
                    if ($afield[3] == 'hidden') {
                        $arreglo_hidden_label = $afield[0];
                        $pinta_form .= genInput($afield[3], $afield[0], $classind->$afield[0]) . " \n";
                    } else {
                        $l_des = "";
                        $span_des = "";
                        $descripcion = "";
                        $tags_acce = "";
                        $div_tags_acce = "";
                        if (is_array($afield[1])) {
                            if ($afield[1][1] <> null || strlen($afield[1][1] > 1)) {
                                $l_des = ' aria-describedby="a_d_' . $afield[1][0] . '" ';
                                $span_des = '<span id="a_d_' . $afield[1][0] . '" >' . $afield[1][1] . '</span>';
                            }
                            if ($afield[1][2] == "acce") {
                                $tags_acce = " aria-autocomplete=\"list\" aria-controls=\"popover_webui_acce\" ";
                                $div_tags_acce = " role=\"combobox\" aria-expanded=\"false\" aria-owns=\"popover_webui_acce\" aria-haspopup=\"grid\" ";
                            }
                            $descripcion = $afield[1][0];
                        } else {
                            $descripcion = $afield[1];
                        }
                        $pinta_form .= '<div class="row ' . $afield[13][2] . '" id="div_p_' . $afield[0] . '">
                                        <div class="col-12" style="min-height: 20px;"><label for="' . $afield[0] . '" id="l_' . $afield[0] . '" class="form-control-label f_cmb_l text-80 label_sys" ' . $l_des . '>' .
                                (($afield[4] <> 0 ? $descripcion : '')
                                . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-label="*" aria-hidden="true" style="font-size:10px;color:red;"></i>' : ''))
                                . '&nbsp;<i id="i_a' . $afield[0] . '" aria-hidden="true"></i></label>' . $span_des . '</div>
                                        <div ' . $div_tags_acce . ' class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') . $afield[13][1] . '">';
                        switch ($afield[3]) {
                            case 'text':
                                $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                $pinta_form .= genInput($afield[3], $afield[0], $classind->$afield[0]
                                                , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control input_text_sys', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
                                                , ($afield[6] == 'date' ? $frmname : $descripcion), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') . " " . $tags_acce, ($afield[12] == 1 ? $afield[12] : 0)) .
                                        '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>' . "<span id=\"span_" . $afield[0] . "\" class=\"span_msgval\"></span>";
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
                                        $pinta_form .= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'txtbox', '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $descripcion, ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                        $cont_txts++;
                                    }
                                }
                                //$("#cveArea").select2();
                                if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                    $select2 .= '$("#' . $afield[0] . '").select2();';
                                }
                                $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                        genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control text-80 input_text_sys" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''), ((isset($afield[5][7]) && strlen($afield[5][7]) > 0) ? $afield[5][7] : ''));
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
                                        $pinta_form .= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'txtbox', '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $descripcion, ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                        $cont_txts++;
                                    }
                                }
                                //$("#cveArea").select2();
                                if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                    $select2 .= '$("#' . $afield[0] . '").select2();';
                                }
                                $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                        genSelect($afield[0] . "[]", '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="js-example-basic-multiple form-control input_text_sys" multiple="multiple" size="6"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                                $pinta_form .= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';

                                break;
                            case 'check':
                                $accion = '';
                                if (isset($afield[21]))
                                    $accion = $afield[21];
                                $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                if (isset($afield[16]) && $afield[16] == 1) {
                                    $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms input_text_sys checks_forms_sys', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                                } else if (isset($afield[16]) && $afield[16] == 2) {
                                    $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms input_text_sys checks_forms_sys', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . '<span style="font-size: 11px;">&nbsp;' . $descripcion . '&nbsp;</span>';
                                } else {
                                    $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms input_text_sys checks_forms_sys', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
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
                                $pinta_form .= genTArea($afield[0], '', '', $afield[9][0], $afield[9][1], 'form-control input_text_sys ' . $style_all) . (is_array($afield[10]) ? "<br/><script language=\"javascript\">displaylimit('document." . $frmname . "." . $afield[0] . "'," . $afield[10][0] . "," . $afield[10][1] . ")</script>" : '');
                                $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                                break;
                        }
                        $pinta_form .= '</div></div>';
                    }
                }
            }
            $inicio = $cont;
            $pinta_form .= '';
            $pinta_form .= '</div>';
            $pinta_form .= '</div>';
            $pinta_form .= '</div>';
        }
        echo '' . $pinta_form;
        $strhidden = "";


        if (isset($m_keyFields2))
            $m_keyFields = $m_keyFields2;
        if (isset($boolkeyValNiv) && $boolkeyValNiv) {
            $atmp_keyValNiv = $__SESSION->getValueSession('keyValNiv');
            foreach ($m_keyFields as $cont => $itemKeyFields)
                $strhidden .= genInput('hidden', $itemKeyFields . "", $atmp_keyValNiv[$__SESSION->getValueSession('intSelfNivel')][$cont]);
        }
        if (isset($keyFields0) && sizeof($keyFields0) > 0) {
            $atmp_keyValNiv = $__SESSION->getValueSession('s_keyNameValFields0');
            foreach ($keyFields0 as $cont => $itemKeyFields)
                $strhidden .= genInput('hidden', $itemKeyFields, $atmp_keyValNiv[$itemKeyFields]);
        }
        
        

//        if (isset($m_keyFields2))
//            $m_keyFields = $m_keyFields2;
//        if (isset($boolkeyValNiv) && $boolkeyValNiv) {
//            foreach ($m_keyFields as $cont => $itemKeyFields)
//                $strhidden .= genInput('hidden', $itemKeyFields, $_SESSION['keyValNiv'][$_SESSION['intSelfNivel']][$cont]);
//        }
//        if (isset($keyFields0) && sizeof($keyFields0) > 0) {
//            foreach ($keyFields0 as $cont => $itemKeyFields)
//                $strhidden .= genInput('hidden', $itemKeyFields, $_SESSION['s_keyNameValFields0'][$itemKeyFields]);
//        }

        echo $strhidden;
        echo genInput('hidden', 'op', '1') .
        genInput('hidden', 'nivPo', ((strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0')) .
        genInput('hidden', 'sel', '0') .
        genInput('hidden', 'btnGuarda', 'btnGuarda', '', '', '', '');
        echo '          
            <div class="card div_form_acor_sys"><div class="form-group row" style="padding:.5rem .5rem .5rem 1rem; margin-bottom: 0rem;">
                          <div class="col-12 col-sm-12">
' . "<button id=\"submit_a\" class=\"btn boton_act punteados b_s_sys\" type=\"submit\" alt=\"Guardar Registro\" border='0' name=\"submit_a\" value=\"Guardar\"" . " $vars_obj >Guardar&nbsp;<i id='ocultar_load' class='fa fa-upload'></i></button>" . '                          
' . ("<a id=\"\" class=\"btn boton_can punteados b_s_sys\" role='button' aria-label='Cancelar' href=\"" . $_SERVER['PHP_SELF'] . "?op=1&btnCancela=btnCancela\" >Cancelar&nbsp;<i class='fa fa-window-close'></i></a>"
        . ((isset($selrowadd) && $selrowadd == 1) ? (
                genInput('checkbox', 'hiddrowadd', 1, '', '', '', '', '', 'checked', '8', '', '', '', '0', '', '') .
                "<span style=\"color:#838383; font-variant:small-caps; font-size: 10px;\"> continuar agregando registros en el mismo modulo</span>") : '')) . '
                          </div>
                        </div>
                        </div>';

        echo '</fieldset></form>';

        echo ''
        . '             </div>'
        . '         </div>'
        . '     </div>'
        . '</div>';
        echo '</div>';

//        
//        echo '</div>';
//        echo '</div>';
//        echo '</div>';
//        echo '</div>';
//        echo '</div>';
    }
} else {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/sb_refresh.php");
}//accordeon_f_
echo "<script language=\"JavaScript\">\n";

echo " ";
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
        }
    }
    echo " });"
    . "function mensaje(div_s){" . 'jQuery("#"+div_s).datetimepicker("show");dayTripper(div_s);' . "}</script>";
}

function busca_separ($arreglo, $busca) {
    $regresa = false;
    for ($index1 = 0; $index1 < count($arreglo); $index1++) {
        if ($arreglo[$index1][0] == $busca) {
            $regresa = $arreglo[$index1];
        }
    }
    return $regresa;
}
?><script>
    $(".js-example-basic-multiple-limit").select2(
            {
                maximumSelectionLength: 10
            });

</script>
<script>
    $(function ()
    {
        $(".js-example-basic-multiple").select2();
    });
</script>
