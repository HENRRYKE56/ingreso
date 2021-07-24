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
    $classind->Consultar($campos_nuevos_en, $id_prin, $tabla, " Where ".$_POST['varval']);
   
    
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
    echo '<div id="espacio_' . $frmname . '" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
            <p id="texto_' . $frmname . '" class="color_negro"></p>
          </div>  ';
    $ar_obli=['','obligatorio_oscuro','obligatorio_claro'];
    
    $str_requeridos = "Los campos con&nbsp;&nbsp;<i class='fa fa-asterisk' aria-hidden='true' style='color:red;'></i>&nbsp;&nbsp;son obligatorios";
    $requeridos = '<div class="alert obligatorio_sys '.$ar_obli[$__SESSION->getValueSession('theme') * 1].'"  role="alert" style="padding: .4rem .4rem;margin-bottom: .9rem;margin-top: -12px;background-color:#66cdaa;color:#000000;">
                                ' . $str_requeridos . '
                            </div>';
    echo $requeridos;
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
    $val_text = '';
    for ($index2 = 0; $index2 < count($a_separs); $index2++) {
        if ($index2 != 0) {
            $ariaexpanded = "false";
            $d_hidden = "hidden";
        }
        $ar_car=array("","oscuro_bread","claro_bread");  
        $ar_bot=array("","punteados_l oscuro_b","punteados_s claro_b");
        $pinta_form .= '<div class="card '.$ar_car[$__SESSION->getValueSession('theme') * 1].'">
                <h3 class="color_negro h3">
                                            <button type="button" aria-label="' . ($ariaexpanded == "true" ? 'Contraer' : 'Expandir') . '" aria-expanded="' . $ariaexpanded . '" class="btn card-header ' . $a_separs[$index2][3] . ' Accordion-trigger punteados w-100 '.$ar_bot[$__SESSION->getValueSession('theme') * 1].'" aria-controls="a_' . $a_separs[$index2][0] . '" id="accordion' . ($a_separs[$index2][0]) . 'id">
                                                <span style="width:50% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;' . $a_separs[$index2][1] . '</span><span style="width:50% !important;text-align: right !important;pointer-events: none;" class="Accordion-icon"><i class="' . ($ariaexpanded == "true" ? 'fa fa-chevron-up' : 'fa fa-chevron-down') . '" id="i_' . $a_separs[$index2][0] . '" aria-hidden="true"></i></span>
                                            </button>  
                </h3>';
        $pinta_form .= '<div class="card-body card-block" role="region" aria-labelledby="accordion' . ($a_separs[$index2][0]) . 'id" class="Accordion-panel" id="a_' . $a_separs[$index2][0] . '" ' . $d_hidden . '>';
        $pinta_form .= '<div class="row form-group">';
        for ($cont = $inicio; $cont < ($a_separs[$index2][2]) + $inicio; $cont++) {
            $afield = $field[$cont];
            if ($afield[4] == '1' || $afield[4] == '2') {
                if ($afield[3] == 'hidden') {
                    $arreglo_hidden_label = $afield[0];
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
                    $ar_lab=array("","label_oscuro","label_claro");
                    $pinta_form .= '<div class="row ' . $afield[13][2] . '" id="div_' . $afield[0] . '">
                                        <div class="col-12" style="min-height: 30px;"><label for="' . $afield[0] . '" id="l_' . $afield[0] . '" class="form-control-label f_cmb_l '.$ar_lab[$__SESSION->getValueSession('theme') * 1].'" ' . $l_des . '>' .
                            (($afield[4] <> 0 ? $descripcion : '')
                            . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-label="*" aria-hidden="true" style="font-size:10px;color:red;"></i>' : ''))
                            . '&nbsp;<i id="i_a' . $afield[0] . '" aria-hidden="true"></i></label>' . $span_des . '</div>
                                        <div class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') . $afield[13][1] . '">';
                    $ar_input=array("","input_t_osc","input_t_claro");
                    switch ($afield[3]) {
                        case 'text':
                            if ($afield[6] == 'money') {
                                $classind->$afield[0] = number_format(str_replace(array('$', ','), array('', ''), $classind->$afield[0]) * 1, 2, '.', '');
                            }
                            if ($afield[4] == 1) {
                                $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                $pinta_form .= genInput($afield[3], $afield[0], (strlen($afield[7]) > 0 ? $afield[7] : $classind->$afield[0])
                                        , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control '.$ar_input[$__SESSION->getValueSession('theme') * 1], (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
                                        , ($afield[6] == 'date' ? $frmname : $afield[1]), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"'))
                                ;
                            } else {
                                $pinta_form .= "<span tabindex='0' >" . $classind->$afield[0] . "</span>";
                            }
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;


                        case 'select':
                            $stronclick = "";
                            if (isset($afield[5][2])) {
                                if ($afield[5][2] == 1)
                                    $stronclick = 'onChange="document.' . $frmname . '.sel.value=\'' . $afield[0] . '\';submit();return false;"';
                            }
                            $strAddSel = '';
                            if (isset($afield[5][3]))
                                $strAddSel = $afield[5][3];
                            #----------------------------------------------------------------------------#
                            $pinta_form .= ("" . ((isset($a_pop) && in_array($afield[0], $a_pop)) ? "<a style=\"background-color:" . $CFG_BGC[7] .
                                    "; color:black;\" href=\"#\" onClick=\"toolTipAdd('<img src=img/arrow_green.gif border=0> cargando datos ...',this,'" .
                                    $a_popTitle[array_search($afield[0], $a_pop)] .
                                    "','toolTipBox','" . $a_popContent[array_search($afield[0], $a_pop)] .
                                    "','" . $a_popObVal[array_search($afield[0], $a_pop)] . "',0," . $a_popPos[array_search($afield[0], $a_pop)] . "," . $__SESSION->getValueSession('mod') . "); return true;\"  alt=\"agregar " . $afield[1] . "\"><img src=\"img/add.gif\" border='0'" .
                                    " alt=\"agregar " . $afield[1] . "\" ></a>" : ""));
                            if ($afield[4] == 1) {
                                $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                if (isset($afield[5][4]) && sizeof($afield[5][4]) > 0) {
                                    $cont_txts = 0;
                                    foreach ($afield[5][4] as $item_texts_a) {
                                        $pinta_form .= ($cont_txts > 0 ? "&nbsp;" : '') . $item_texts_a[0];
                                        $pinta_form .= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'form-control '.$ar_input[$__SESSION->getValueSession('theme') * 1], '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $afield[1], ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                        $cont_txts++;
                                    }
                                }
                                if ((isset($afield[5][0]) && count($afield[5][0]) > 25) && (isset($hab_select2) && $hab_select2)) {
                                    $select2 .= '$("#' . $afield[0] . '").select2();';
                                }

                                $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                        genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], $classind->$afield[0], (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control '.$ar_input[$__SESSION->getValueSession('theme') * 1].'" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', (isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : '', (isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : '', ((isset($afield[5][7]) && strlen($afield[5][7]) > 0) ? $afield[5][7] : ''));
                                $pinta_form .= "</div>";
                                $pinta_form .= genCCol() . genCRen();
                            } else {
                                $pinta_form .= '<label>' . getDescript($classind->$afield[0], $afield[5][0], $afield[5][1]) . '</label>';
                            }
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
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
                            if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2_m) && $hab_select2_m)) {
//                                        echo $afield[0].'<pre>';
//                                        print_r($classind);
                                $select2 .= "$('.c_" . $afield[0] . "').select2();var cadena_m='" . $classind->$afield[0] . "';var selectedValues = cadena_m.split('@|');$('.c_" . $afield[0] . "').val(selectedValues).trigger('change');";
                            }
                            $pinta_form .= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                    genSelect($afield[0] . "[]", '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="js-example-basic-multiple form-control c_' . $afield[0] . ' '.$ar_input[$__SESSION->getValueSession('theme') * 1].'" multiple="multiple" size="6"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                            $pinta_form .= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';


                            break;
                        case 'textarea':
                            $val_text.= (is_array($afield[10]) ? "displaylimit('document." . $frmname . "." . $afield[0] . "'," . $afield[10][0] . "," . $afield[10][1] . ",'cuenta_" . $afield[0] . "');" : '');
                            if ($afield[4] == 1) {
                                $pinta_form .= genTArea($afield[0], $classind->$afield[0], '', $afield[9][0], $afield[9][1], 'form-control ' . $style_all." ".$ar_input[$__SESSION->getValueSession('theme') * 1]);
                            } else {
                                $pinta_form .= '<label>' . $classind->$afield[0] . '</label>';
                            }

                            $pinta_form .= '<small style="" class="form-text" id="cuenta_' . $afield[0] . '">&nbsp;</small>' . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'file':
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
//(genInput('checkbox',"chk_upd_file",'1','','','','form-control','',($classind->$afield[0]==1?'checked':''),'8').
//									    "<span style=\"font-size: 11px; font-weight:bold; color:#627832; font-variant:none; text-decoration: none;\">
//												&nbsp;Para agregar un nuevo archivo marque esta opci�n y seleccione el archivo desde el boton \"Examinar\"</br></span>".
//							             "<span style=\"font-size: 11px; font-weight:bold; color:#820000; font-variant:none; text-decoration: none;\">
//												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
//												� para borrar un archivo marque esta opcion y no adjunte nigun archivo</br></span>"                                          
                            $pinta_form .= (genInput('file', $afield[0], $afield[7], '', $afield[9], '', 'form-control', '', '', '9', '', '', '', '', '', (isset($afield[15]) ? $afield[15] : '') . (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"'));
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'check':$accion = '';
                            if (isset($afield[21]))
                                $accion = $afield[21];
                            $str_obj_jsrpt .= (strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt .= "{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            if (isset($afield[16]) && $afield[16] == 1) {
                                if ($afield[4] == 1) {
                                    $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0 and $classind->$afield[0] <> '0') ? $classind->$afield[0] : '1')), '', '', '', ' checks_forms ', '', (($afield[5] == '1') ? 'checked' : (($afield[5] == '0') ? '' : ($classind->$afield[0] > 0 ? 'checked' : ''))), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                                } else {
                                    $pinta_form .= genInput('checkbox', $afield[0], '', '', '', '', '', 'DISABLED', ($classind->$afield[0] > 0 ? 'checked' : ''), '8');
                                }
                            } else if (isset($afield[16]) && $afield[16] == 2) {
                                if ($afield[4] == 1) {
                                    $pinta_form .= (isset($afield[22]) ? $afield[22] : '') . genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0 and $classind->$afield[0] <> '0') ? $classind->$afield[0] : '1')), '', '', '', ' checks_forms ', '', (($afield[5] == '1') ? 'checked' : (($afield[5] == '0') ? '' : ($classind->$afield[0] > 0 ? 'checked' : ''))), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . '<span style="font-size: 11px;">&nbsp;' . $afield[1] . '&nbsp;</span>';
                                } else {
                                    $pinta_form .= (isset($afield[22]) ? $afield[22] : '') . genInput('checkbox', $afield[0], '', '', '', '', '', 'DISABLED', ($classind->$afield[0] > 0 ? 'checked' : ''), '8') . '<span style="font-size: 11px;">&nbsp;' . $afield[1] . '&nbsp;</span>';
                                }
                            } else {
                                if ($afield[4] == 1) {
                                    $pinta_form .= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0 and $classind->$afield[0] <> '0') ? $classind->$afield[0] : '1')), '', '', '', ' checks_forms ', '', (($afield[5] == '1') ? 'checked' : (($afield[5] == '0') ? '' : ($classind->$afield[0] > 0 ? 'checked' : ''))), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                                } else {
                                    $pinta_form .= genInput('checkbox', $afield[0], '', '', '', '', '', 'DISABLED', ($classind->$afield[0] > 0 ? 'checked' : ''), '5');
                                }
                            }
                            $pinta_form .= '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'label':

                            $arreglo_hidden_label = $afield[0];
                            $pinta_form .= genInput('hidden', $afield[0], $classind->$afield[0]) . $classind->$afield[0];
                            break;
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

//        echo '<div class="card">
//                <div class="col-12 col-sm-6">';        
    echo genInput('hidden', 'btnActualizaLight', 'btnGuarda', '', '', '', '') .
    "<a href='#' id='btn_actualiza_l' role='button' class='btn boton_act punteados col-12 col-sm-3 text-white ".$ar_bot[$__SESSION->getValueSession('theme') * 1]."' alt=\"Guardar Registro\" name=\"submit\" value=\"0\" $vars_obj>Guardar&nbsp;<i id='ocultar_load' class='fa fa-upload'></i></a>";
//        echo   '</div>';
//        echo '  <div class="col-12 col-sm-6">';        
    echo '<span class="col-12 col-sm-6"></span><button type="button" class="btn boton_can punteados col-12 col-sm-3 '.$ar_bot[$__SESSION->getValueSession('theme') * 1].'" data-dismiss="modal">Cerrar&nbsp;<i class="fa fa-window-close"></i></button>';
//        echo   '</div>';        
//        echo '</div>';

    echo "</fieldset></form></div></div></div></div></div>";

    echo "<script language=\"JavaScript\">\n";
    echo "var FORM_OBJECTS = [\n" . $str_obj_jsrpt . "]\n";
    echo "objSelIni ();\n";
    echo "</script>\n"."<script>". $val_text."</script>";
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
      