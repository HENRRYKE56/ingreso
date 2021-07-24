<?php
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/sb_ii_refresh.php");
} else {
    if (trim($a_key[4]) == '100') {
        include_once("config/cfg.php");
        include_once("lib/lib_pgsql.php");
        include_once("lib/lib_entidad.php");
        $lbl_tit_mov = ""; //"[ Criterios de Reporte ]";

        /* < --- Inicia mensaje de error de accion--- > */

        if (strlen($__SESSION->getValueSession('msg')) > 1) {
            $str_msg_red = "";
            $i_intstyle = 19;
            $i_intcolor = 6;
            for ($i = 0; $i < (strlen($__SESSION->getValueSession('msg')) / 3); $i++) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red.=',&nbsp;&nbsp;';
                $str_msg_red.=$CFG_MSG[(substr($__SESSION->getValueSession('msg'), $i * 3, 3) * 1)];
            }
            $__SESSION->setValueSession('msg', 0);
            include("includes/sb_msg_bob.php");
        }
        /* < --- Termina mensaje de error --- > */

        /* < --- Inicia mensaje de error de validacion --- > */

        if ($__SESSION->getValueSession('msgval') && strlen($__SESSION->getValueSession('msgval')) > 0) {
            $str_msg_red = "";
            $i_intstyle = 29;
            $i_intcolor = 6;
            $a_msgval = explode(',', $__SESSION->getValueSession('msgval'));
            foreach ($a_msgval as $ifield) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red.=',<br>';
                $str_msg_red.=$field[$ifield][1] . ": " . $CFG_MSG[6];
            }
            $__SESSION->setValueSession('msgval', '');
            include("includes/sb_msg_bob.php");

        }
        /* < --- Termina mensaje de error --- > */


        /* -------------valores de session, si es que los hay------------- */
        if ($__SESSION->getValueSession('a_tmpValues')) {
            if (!is_null($__SESSION->getValueSession('a_tmpValues'))) {
                $add_tmpValues = $__SESSION->getValueSession('a_tmpValues');
                //print_r($_SESSION['a_tmpValues']);
                $__SESSION->getValueSession('a_tmpValues') == "";
                $allvalues = array();
                $cont = 0;
                //print_r($a_tmpValues);
                foreach ($field as $afield) {
                    if ($afield[4] == '1' || $afield[4] == '2') {
                        $allvalues[] = $add_tmpValues[$cont];
                        $cont++;
                    } else {
                        $allvalues[] = $afield[7];
                    }
                }
            }
        }
        //print_r($allvalues);
        $classind = new Entidad($allfields, $allvalues);


        /* ------------------------------- */
        $twidth = ($awidths[1] + $awidths[2] > 800 ? ($awidths[1] + $awidths[2]) : 800);


        $vars_obj = "";
        $array_obj = $field;

        $bdate = 0;
        $vars_post = "";
        foreach ($array_obj as $afield) {
                if (($afield[6] == 'date' || $afield[6] == 'datetime') && $afield[3] == 'text') {
                $conf_d='';
                if($afield[6]=='date'){
                    $conf_d="changeMonth: true,
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
            timeText:'',";
                }else{
                    $conf_d="changeMonth: true,
            changeYear: true,
            controlType: 'select',
            oneLine: true,
            dateFormat: 'dd/mm/yy',
            timeFormat: 'HH:mm',
            buttonText: '<i class=\'fa icon-calendar\'></i>',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            showOn: 'button',
            showClose: true,
            closeText:'Cerrar',            
            timeText:'Hora',";                    
//                    $conf_d="changeMonth: true,
//                            changeYear: true,
//                            controlType: 'select',
//                            oneLine: true,
//                            dateFormat: 'dd/mm/yy',
//                            timeFormat: 'HH:mm',";                    
                }
                $ar_date_t[] = array($afield[0], isset($afield[25])?$afield[25]:$conf_d, isset($afield[26])?$afield[26]:'');                    
                }                         
			if ($afield[6]=='date' && $afield[3]=='text')$bdate=1;
			if (($afield[3]=='text' || $afield[3]=='textarea' || ($afield[3]=='hidden' && $afield[12]==1) || ($afield[3]=='label' && $afield[12]==1) || (($afield[3]=='select' || $afield[3]=='lst2') && $afield[12]==1)) || ($afield[3]=='check')){

				if (strlen($vars_obj)>0)$vars_obj.=",";
				$vars_obj.="'".$afield[0]."','".$afield[7]."','".($afield[12]==1?'R':'').(($afield[3]=='select' || $afield[3]=='lst2')?'isSelect':($afield[6]=='int' || $afield[6]=='money'?'isNum':($afield[6]=='date'?'isDate':($afield[3]=='check'?'isCheck':'isTxt'))))."' ,'".$afield[1]."','".$afield[11]."'";
			}
			if ($afield[3]=='file')$fileExist=true;
        }
        if (isset($a_check)) {
            foreach ($a_check as $cont_chk => $afield) {
                if (strlen($vars_post) > 0)
                    $vars_post.=",";
                $vars_post.="'chk" . $cont_chk . "'";
                foreach ($afield[1] as $afield2) {
                    if (strlen($vars_post) > 0)
                        $vars_post.=",";
                    $vars_post.="'" . $afield2 . "'";
                }
            }
        }

        if (isset($vparitem)) {
            //$str_vparfile='vparfile'.$field[$vparitem][7];
            $str_vparfile = $field[$vparitem][0];
        }

        if (!isset($ValsendRep2))
            $ValsendRep2 = "sendRep2";
        if (strlen($vars_obj) > 0) {
            $vars_obj = "onClick=\"".$ValsendRep2 . "(function(){obj_valObj(2," . $vars_obj . ");},'" .
                    $stropen . "','" . (isset($vparitem) ? $str_vparfile : '') . "'," . $vars_post . ");\"";
        } else {
            $vars_obj = "onClick=\"" . $ValsendRep2 . "('" .
                    $stropen . "','" . (isset($vparitem) ? $str_vparfile : '') . "'," . $vars_post . ");\"";
        }
//        die($vars_obj);
   
        $frmname = 'frmcon';        
        echo '<nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background-color:#4c4c4c;">
                <li class="breadcrumb-item active" style="color:#ffffff;" aria-current="page"><i class="fa fa-home" style="font-size:1.3em;color:#7fffd4;"></i>&nbsp;' . $entidad . '</li>
            </ol>
          </nav>';
        echo '<div id="espacio_' . $frmname . '" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
            <p id="texto_' . $frmname . '" class="color_negro"></p>
          </div>  ';        
        $str_requeridos = "Los campos con&nbsp;&nbsp;<i class='fa fa-asterisk' aria-hidden='true' style='color:red;'></i>&nbsp;&nbsp;son obligatorios";
        $requeridos = '<div class="alert"  role="alert" style="padding: .4rem .4rem;margin-bottom: .9rem;margin-top: -12px;background-color:#66cdaa;color:#000000;">
                                ' . $str_requeridos . '
                            </div>';
        echo $requeridos;   
        $frmname = 'frmcon';
        echo '<div class="content m-1" id="app_datos">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-lg-12">';
        echo '<div id="accordionGroup" class="Accordion">';
        echo "<form name=\"$frmname\" id=\"$frmname\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\"> \n";
        $style = $CFG_FSIZE[0];
        $style_all = $CFG_FSIZE[0];
        $bgstyle = '';
        $bgstyle_lbl = '';
        $row_open = 0;
        $cont_separs = 0;
        $strFieldsInput = "";
        $str_obj_jsrpt = "";
        $arreglo_hidden_label = array();
       //separadores por cada separa
        if (isset($a_separs) && count($a_separs) > 0 && is_array($a_separs)) {} else {
            $a_separs[] = array(0, 'Datos generales', count($field)+1, 'separ_verde');
        }
        $inicio=0;
        $pinta_form="";
//        echo '<pre>';
//        print_r($a_separs);die();

        for ($index2 = 0; $index2 < count($a_separs); $index2++) {
            $ariaexpanded='Expandir';
            $d_hidden='';
            $pinta_form.= '<div class="card">
                <h3 class="color_negro h3">
                                            <span aria-label="' . ($ariaexpanded == "true" ? 'Contraer' : 'Expandir') . '" aria-expanded="' . $ariaexpanded . '" class="btn card-header ' . $a_separs[$index2][3] . ' Accordion-trigger punteados w-100">
                                                <span style="width:100% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;' . $a_separs[$index2][1] . '</span>
                                            </span>  
                </h3>';
            $pinta_form.= '<div class="card-body card-block" role="region" aria-labelledby="accordion' . ($a_separs[$index2][0]) . 'id" class="Accordion-panel" id="a_' . $a_separs[$index2][0] . '" ' . $d_hidden . '>';
            $pinta_form.= '<div class="row form-group">';
            for ($cont = $inicio; $cont < $a_separs[$index2][2]+$inicio; $cont++) {//echo '<br />'.$cont;
                $afield=$field[$cont];
            if ($afield[4] == '1' || $afield[4] == '2') {
                if ($afield[3] == 'hidden') {
                    $pinta_form.= genInput($afield[3], $afield[0], $afield[7]) . " \n";
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
                        $input_check='';
                        //$for_label='';
                        if(in_array($afield[0], array('NUMFAC','identificador','CVEUNI'))){
                            $input_check='<input class="checks_forms" type="checkbox" id="l_c_'.$afield[0].'" name="l_c_'.$afield[0].'"  '.($afield[0]=='identificador'?'checked':'').'>';
                            //$for_label=' for="l_c_'.$afield[0].'" ';
                        }                        
                        $pinta_form.= '<div class="row ' . $afield[13][2] . '" id="div_' . $afield[0] . '">
                                        <div class="col-12" style="min-height: 30px;">'.$input_check.'<label for="' . $afield[0] . '" id="l_' . $afield[0] . '" class="form-control-label f_cmb_l" ' . $l_des . '>' .
                                (($afield[4] <> 0 ? $descripcion : '')
                                . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-label="*" aria-hidden="true" style="font-size:10px;color:red;"></i>' : ''))
                                . '&nbsp;<i id="i_a' . $afield[0] . '" aria-hidden="true"></i></label>' . $span_des . '</div>
                                        <div class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') . $afield[13][1] . '">';

                        switch ($afield[3]) {
                            case 'text':
                                $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                $pinta_form.=genInput($afield[3], $afield[0], ''
                                                , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
                                                , ($afield[6] == 'date' ? $frmname : $afield[1]), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"'), ($afield[12] == 1 ? $afield[12] : 0)) .
                                        '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>';
                                break;
                            case 'file':
                                $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                $pinta_form.=genInput('file', $afield[0], $afield[7], '', $afield[9], '', 'form-control-file', '', '', '9', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"') .
                                        '<small class="form-text" style="" id="e_' . $afield[0] . '">&nbsp;</small>';
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
                                if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                    $select2.='$("#' . $afield[0] . '").select2();';
                                }
                                $pinta_form.= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                        genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''), ((isset($afield[5][7]) && strlen($afield[5][7]) > 0) ? $afield[5][7] : ''));
                                $pinta_form.= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                                break;
                            case 'lst2':

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
                                if ((isset($afield[5][0]) && count($afield[5][0]) > 20) || (isset($hab_select2) && $hab_select2)) {
                                    $select2.='$("#' . $afield[0] . '").select2();';
                                }
                                $pinta_form.= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                        genSelect($afield[0] . "[]", '', '', $afield[5][0], $afield[5][1], '', (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="js-example-basic-multiple form-control" multiple="multiple" size="6"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                                $pinta_form.= "</div>" . '<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';

                                break;
                            case 'check':
                                $accion = '';
                                if (isset($afield[21]))
                                    $accion = $afield[21];
                                $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                if (isset($afield[16]) && $afield[16] == 1) {
                                    $pinta_form.= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                                } else if (isset($afield[16]) && $afield[16] == 2) {
                                    $pinta_form.= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion) . '<span style="font-size: 11px;">&nbsp;' . $afield[1] . '&nbsp;</span>';
                                } else {
                                    $pinta_form.= genInput('checkbox', $afield[0], ((strlen($afield[5]) > 0) ? $afield[7] : '1'), '', '', '', ' checks_forms ', '', (''), '8', '', '', '', '0', '', (isset($afield[24]) ? $afield[24] : '') . ' onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"' . $accion);
                                }
                                $pinta_form.='<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                                break;
                            case 'label':
                                $arreglo_hidden_label = $afield[0];
                                $pinta_form.= genInput('hidden', $afield[0], $afield[7]) . $afield[7] . "";
                                break;
                            case 'textarea':
                                $str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
                                $str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
                                $pinta_form.=genTArea($afield[0], '', '', $afield[9][0], $afield[9][1], 'form-control ' . $style_all) . (is_array($afield[10]) ? "<br/><script language=\"javascript\">displaylimit('document." . $frmname . "." . $afield[0] . "'," . $afield[10][0] . "," . $afield[10][1] . ")</script>" : '');
                                $pinta_form.='<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
                                break;
                            case 'button':
                                $pinta_form.='<button id="btn_bus" type="button" class="col-12  btn separ_amarillo punteados border border-dark" onclick="busca_entrada(1);" alt="Buscar entrada" style="font-size:13px;">Buscar</button>'
                                           . '<button id="btn_new" type="button" class="col-12  btn separ_azul punteados border border-dark" alt="Habilitar entrada" onclick="nueva_entrada();" style="font-size:12px;">Habilitar</button>'
                                           . '<button id="btn_sv" type="button" class="col-12 btn separ_verde_claro punteados border border-dark" alt="Guardar entrada" onclick="proc_guarda();" style="font-size:13px;" disabled>Guardar</button>'
                                           . '<button id="btn_lim" type="button" class="col-12  btn separ_naranja punteados border border-dark" alt="Limpiar registro" onclick="limpia_registro();" style="font-size:13px;">Limpiar</button>'
                                           . '<button id="btn_det" type="button" class="col-12  btn separ_rojo_claro punteados border border-dark" alt="Detalle de entrada" onclick="detalle_registro();" style="font-size:13px;">Detalle</button>'
                                           . '';
                                break;
                        }
                        $pinta_form.= '</div></div>';
                }
            }
        }
            $inicio=$cont;
            $pinta_form.='</div>';
            $pinta_form.='</div>';
            $pinta_form.='</div>';        
    }
       echo '' . $pinta_form;
          
                
                
//                echo '<div class="control-group span12 pull-center">'. '<div class="span4">'     .          
//			 "<button id=\"submit\" class=\"btn btn-success span12\"  style=\"\" type=\"submit\" border='0' name=\"submit\" value=\"\"". " $vars_obj><i class='fa fa-download'></i>&nbsp;Generar</button></div><div class='span4'></div>".
//                         "<div class='span4'><a id=\"acancelar\" style=\"min\" class=\"btn btn-danger span12\" href=\"".$_SERVER['PHP_SELF']."?op=1&btnCancela=btnCancela\" ><i class='fa fa-window-close'></i>&nbsp;Cancelar</a></div>";
//			 
//                echo '</br>&nbsp;
//                      </div>';                
		
    
        echo '              </form>'
        . '             </div>';
    
        echo '         </div>'
        . '     </div>'
        . '</div>'
                . '</div>';



    }
}
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
echo "<script language=\"JavaScript\">\n";
echo "var FORM_OBJECTS = [\n" . $str_obj_jsrpt . "]\n";
echo "objSelIni ();\n";
echo "</script>\n";

function busca_separ($arreglo, $busca) {
    $regresa = false;
    for ($index1 = 0; $index1 < count($arreglo); $index1++) {
        if ($arreglo[$index1][0] == $busca) {
            $regresa = $arreglo[$index1];
        }
    }
    return $regresa;
}
?>
<SCRIPT LANGUAGE="JavaScript" SRC="js/jsSendRep.js"></SCRIPT>
