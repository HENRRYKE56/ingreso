<?php

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

    $bdate = 0;
    $vars_post = "";
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
                    $vars_obj.=",";
                $vars_obj.="'" . $afield[0] . "','" . $afield[7] . "','" . ($afield[12] == 1 ? 'R' : '') . (($afield[3] == 'select' || $afield[3] == 'lst2') ? 'isSelect' : ($afield[6] == 'int' || $afield[6] == 'money' ? 'isNum' : ($afield[6] == 'date' ? 'isDate' : ($afield[3] == 'check' ? 'isCheck' : 'isTxt')))) . "' ,'" . $afield[1] . "','" . $afield[11] . "'";
            }
        if ($afield[4] == '1' || $afield[4] == '2') {
            if (strlen($vars_post) > 0)
                $vars_post.=",";
            $vars_post.="'" . $afield[0] . $strkey . "'";
        }
            if ($afield[3] == 'file')
                $fileExist = true;        
    }
    $vars_post.=",'btnGuardaLight'";
    if (strlen($vars_obj) > 0) {
        $vars_obj = "onClick=\"obj_valObj(2," . $vars_obj . ");sendAdm2('" .
                $_POST['objname'] . "','adm_light','" . $_POST['objname'] . "','" .
                $_POST['numpar'] . "','" . $_POST['numAdd'] . "'," . $vars_post . "); return false;\""; //document.obj_retVal;\"";
    } else {
        $vars_obj = "onClick=\"sendAdm2('" .
                $_POST['objname'] . "','adm_light','" . $_POST['objname'] . "','" .
                $_POST['numpar'] . "','" . $_POST['numAdd'] . "'," . $vars_post . "); return false;\""; //document.obj_retVal;\"";
    }


    echo "<form name=\"$frmname\" id=\"$frmname\" method=\"post\" style=\"margin:0; padding:0;\" " . (($fileExist) ? " enctype=\"multipart/form-data\"" : "") . " > \n";

    $style = $CFG_LBL[30];
    $bgstyle = $CFG_BGC[6];
    $row_open = 0;
    $cont_separs = 0;
    $strhidden = "";
    $arreglo_hidden_label = array();
    $select2 = '';
    $str_obj_jsrpt = "";
    //separadores por cada separa
    if (isset($a_separs) && count($a_separs) > 0 && is_array($a_separs)) {
        
    } else {
        $a_separs[] = array(0, '', count($field), 'bg-dark');
    }
    $inicio = 0;
    $pinta_form = "";

    for ($index2 = 0; $index2 < count($a_separs); $index2++) {
        $pinta_form.= '<div class="card">
                                            <div class="card-header text-dark ' . $a_separs[$index2][3] . '" onclick="oculta(\'a_' . $a_separs[$index2][0] . '\',\'i_' . $a_separs[$index2][0] . '\')">
                                                <strong><i class="fa fa-minus-square text-danger" id="i_' . $a_separs[$index2][0] . '" aria-hidden="true"></i>&nbsp;' . $a_separs[$index2][1] . '</strong>
                                            </div>  ';
        $pinta_form.= '<div class="card-body card-block" id="a_' . $a_separs[$index2][0] . '">';
        $pinta_form.= '<div class="row form-group">';
        for ($cont = $inicio; $cont < ($a_separs[$index2][2]) + $inicio; $cont++) {
            $afield = $field[$cont];
            if ($afield[4] == '1' || $afield[4] == '2') {
                if ($afield[3] == 'hidden') {
                    $arreglo_hidden_label = $afield[0];
                    $pinta_form.= genInput($afield[3], $afield[0], $afield[7]) . " \n";
                } else {
                    $pinta_form.= '<div class="row ' . $afield[13][2] . '">
                                        <div class="col-12" style="height: 30px;"><label for="disabled-input" class=" form-control-label">' . (($afield[4] <> 0 ? '<label id="l_' . $afield[0] . '" class="f_cmb_l">' . $afield[1] . '<label>' : '') . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px;color:red;"></i>' : '')) . '</label>&nbsp;<i id="i_a' . $afield[0] . '" aria-hidden="true"></i></div>
                                        <div class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') . $afield[13][1] . '">';
                    switch ($afield[3]) {
                        case 'text':
                            $pinta_form.= genInput($afield[3], $afield[0], $afield[7]
                                            , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
                                            , ($afield[6] == 'date' ? $frmname : $afield[1]), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"'), ($afield[12] == 1 ? $afield[12] : 0)) .
                                    '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'file':
                            $pinta_form.=genInput('file', $afield[0], $afield[7], '', $afield[9], '', 'form-control-file', '', '', '9', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"');
                            break;
                        case 'select':
                            $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
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
                                    $pinta_form.= ($cont_txts > 0 ? "&nbsp;" : '') . $item_texts_a[0];
                                    $pinta_form.= genInput('txtbox', $item_texts_a[1], '', '', $item_texts_a[3], $item_texts_a[4], 'txtbox', '', '', ($afield[6] == 'date' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : '0')), $afield[1], ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), '', $cont, (isset($afield[15]) ? $afield[15] : ''), $item_texts_a[2]) . '<br>';
                                    $cont_txts++;
                                }
                            }
                            //$("#cveArea").select2();
                            if (isset($afield[5][0]) && count($afield[5][0]) > 20) {
                                $select2.='$("#' . $afield[0] . '").select2();';
                            }
                            $pinta_form.= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                    genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], $classind->$afield[0], (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                            $pinta_form.= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'check':
                            $accion = '';
                            if (isset($afield[21]))
                                $accion = $afield[21];
                            $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                            $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                            if (isset($afield[16]) && $afield[16] == 1) {
                                $pinta_form.= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0) ? $classind->$afield[0] : '1')), '', '', 'custom-control-input', '', '', ($classind->$afield[0] == 1 ? 'checked' : ''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                            } else if (isset($afield[16]) && $afield[16] == 2) {
                                $pinta_form.= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0) ? $classind->$afield[0] : '1')), '', '', 'custom-control-input', '', '', ($classind->$afield[0] == 1 ? 'checked' : ''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . '<span style="font-size: 11px;">&nbsp;' . $afield[1] . '&nbsp;</span>';
                            } else {
                                $pinta_form.= '<label>' . genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : ((strlen($classind->$afield[0]) > 0) ? $classind->$afield[0] : '1')), '', '', 'custom-control-input', '', '', ($classind->$afield[0] == 1 ? 'checked' : ''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . ($afield[1]) . "</label>";
                            }
                            $pinta_form.='<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                        case 'label':
                            $arreglo_hidden_label = $afield[0];
                            $pinta_form.= genInput('hidden', $afield[0], $afield[7]) . $afield[7] . "";
                            break;
                        case 'textarea':

                            $pinta_form.=genTArea($afield[0], '', '', $afield[9][0], $afield[9][1], 'form-control ' . $style_all) . (is_array($afield[10]) ? "<br/><script language=\"javascript\">displaylimit('document." . $frmname . "." . $afield[0] . "'," . $afield[10][0] . "," . $afield[10][1] . ")</script>" : '');
                            $pinta_form.='<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                            break;
                    }
                    $pinta_form.= '</div></div>';
                }
            }
        }
        $inicio = $cont;
        $pinta_form.='</div>';
        $pinta_form.='</div>';
        $pinta_form.='</div>';
    }
    echo '' . $pinta_form;

//        echo '<div class="card">
//                <div class="col-12 col-sm-6">';        
    echo genInput('hidden', 'btnGuardaLight', 'btnGuarda', '', '', '', '') .
    "<a href='#' id='btn_actualiza_l' class='btn btn-success col-12 col-sm-3' alt=\"Guardar Registro\" name=\"submit\" value=\"0\" $vars_obj>Guardar</a>";
//        echo   '</div>';
//        echo '  <div class="col-12 col-sm-6">';        
    echo '<span class="col-12 col-sm-6"></span><button type="button" class="btn btn-danger col-12 col-sm-3" data-dismiss="modal">Cerrar</button>';
//        echo   '</div>';        
//        echo '</div>';

    echo "</form>";
}
echo "<script language=\"JavaScript\">\n";
echo "var FORM_OBJECTS = [\n" . $str_obj_jsrpt . "]\n";
echo "objSelIni ();\n";
echo "</script>\n";
if (count($ar_date_t) || strlen($select2)>0) {
    echo "<script language='JavaScript'>";
    echo "$(document).ready(function (){";
    echo ''.$select2;
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
    . "function mensaje(div_s){" . '$("#"+div_s).datepicker("show");' . "}</script>";
}
?>
