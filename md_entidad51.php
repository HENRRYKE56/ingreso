<?php


include_once("config/cfg.php");
if ($__SESSION->getValueSession('nomusuario') == "") {
    //include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/i_refresh.php");
} else {
    include_once("lib/lib_function.php");
//include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");

    if (function_exists('fnValidateFiatRegistroMD')) {
        fnValidateFiatRegistroMD();
    }
    $afields = array();
    $allvalues = array();
    $allfields = array();
    $widthEditable = 80;
    if (!isset($boolNoNew))
        $boolNoNew = false;
    if (!isset($boolNoEditable))
        $boolNoEditable = false;
    if (!isset($boolNoUpdate))
        $boolNoUpdate = false;
    if (!isset($boolNoDelete))
        $boolNoDelete = false;
    if ($boolNoEditable || ($a_key[1] <> '100' && $a_key[2] <> '100') || ($boolNoUpdate && $boolNoDelete)) {
        $widthEditable = 0;
    } else {
        if ($a_key[1] <> '100' || $a_key[2] <> '100' || $boolNoUpdate || $boolNoDelete)
            $widthEditable = 40;
    }
    foreach ($field as $afield) {
        $allfields[] = $afield[0];
        $allvalues[] = $afield[7];
    }
    $widthEditableIni = $widthEditable;
//    echo 'qwerty<pre>';
//    print_r($strDistintic);die();

    $classent = new Entidad(array('count_r'), array('0'));
    $classent->ListaEntidades(array(), "", "", "", "no", "", $strDistintic);
    
//    echo '<pre>';
//    print_r($classent);die();
    
    $reg_found = 0;
    if ($classent->NumReg > 0) {
        $classent->VerDatosEntidad(0, array('count_r'));
        $reg_found = $classent->count_r;
    }
    $decdiv = intval($reg_found / $intlimit);
    $intmod = ($reg_found / $intlimit) - $decdiv;
    if ($intmod > 0) {
        $decdiv+=1;
    }
    $pag_id = $__SESSION->getValueSession('mod') . $__SESSION->getValueSession('niv');
    /* <--------------se define pagina-------------> */
    if (isset($_GET['intpag_s' . $pag_id]))
        if (!is_null($_GET['intpag_s' . $pag_id]))
            if (intval($_GET['intpag_s' . $pag_id]) > 0)
                $__SESSION->setValueSession('pag' . $pag_id, intval($_GET['intpag_s' . $pag_id]));
    if (isset($_POST['intpag_s' . $pag_id]))
        if (!is_null($_POST['intpag_s' . $pag_id]))
            if (intval($_POST['intpag_s' . $pag_id]) > 0)
                $__SESSION->setValueSession('pag' . $pag_id, intval($_POST['intpag_s' . $pag_id]));

    if ($__SESSION->getValueSession('pag' . $pag_id) <> "")
        $intpag_s[$pag_id] = $__SESSION->getValueSession('pag' . $pag_id);
    /**/

    if (!isset($intpag_s[$pag_id]))
        $intpag_s[$pag_id] = 1;
    if ($intpag_s[$pag_id] > $decdiv || $intpag_s[$pag_id] < 0 || !isset($intpag_s[$pag_id]))
        $intpag_s[$pag_id] = 1;

    $intOffset = ($intlimit * $intpag_s[$pag_id]) - $intlimit;
    $strlimit = " LIMIT $intlimit OFFSET $intOffset";

    $classent = new Entidad($allfields, $allvalues);

    $allvalues = array();
    foreach ($field as $afield)
        if ($afield[2] == '1' || $afield[2] == '2')
            $afields[] = $afield[0];
    //  echo 'm5'.$strWhere;die();
    $classent->ListaEntidades($a_order, $tablas_c, $strWhere, (isset($items0) ? $items0 : ''), '', $strlimit, "", (isset($tipo_order) ? $tipo_order : ''));
//	echo '<pre>';
//        print_r($classent);die();
    //paginacion
    /* inicia paginacion */
    $primeros = "";
    $segundos = "";

    if ($intpag_s[$pag_id] > 1) {
        $primeros = "<li class='page-item punteados'><a href='#' aria-label='Primera p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=1" . "'\" ><i class='fa fa-fast-backward' style='color:inherit;'></i></a></li>";
        $primeros.="<li class='page-item punteados'><a href='#' aria-label='Retroceder p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag[$pag_id] - 1) . "'\" ><i class='fa fa-backward' style='color:inherit;'></i></a></li>";
    } else {
        $primeros = "<li class='page-item disabled punteados'><a href='#' aria-label='Primera p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-fast-backward' style='color:#a9a9a9;'></i></a></li>";
        $primeros.="<li class='page-item disabled punteados'><a href='#' aria-label='Retroceder p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-backward' style='color:#a9a9a9;'></i></a></li>";
    }
    if ($intpag_s[$pag_id] < $decdiv) {
        $segundos = "<li class='page-item punteados'><a href='#' aria-label='Siguiente p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag[$pag_id] + 1) . "'\"><i class='fa fa-forward'></i></a></li>";
        $segundos.="<li class='page-item punteados'><a href='#' aria-label='Ultima p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . $decdiv . "'\" ><i class='fa fa-fast-forward'></i></a></li>";
    } else {
        $segundos = "<li class='page-item punteados'><a href='#' aria-label='Siguiente p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-forward' style='color:#a9a9a9;'></i></a></li>";
        $segundos.="<li class='page-item punteados'><a href='#' aria-label='Ultima p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-fast-forward' style='color:#a9a9a9;'></i></a></li>";
    }    
    $paginas = 20;
    $inipag = 1;
    $finpag = $paginas;
    if ($decdiv >= $paginas) {
        if ($intpag_s[$pag_id] - ($paginas / 2) >= 1 && $intpag_s[$pag_id] + ($paginas / 2) <= $decdiv) {//1-10=-9
            $inipag = $intpag_s[$pag_id] - ($paginas / 2);
            $finpag = $intpag_s[$pag_id] + ($paginas / 2);
        } else {
            if ($intpag_s[$pag_id] - ($paginas / 2) < 1) {
                $inipag = 1;
                $finpag = $paginas;
            }
            if (($intpag_s[$pag_id] + ($paginas / 2)) > $decdiv) {
                $inipag = $decdiv - $paginas;
                $finpag = $decdiv;
            }
        }
    } else {
        $finpag = $decdiv;
    }
    $paginas = "";
    for ($i = $inipag; $i <= $finpag; $i++) {
        if ($intpag[$pag_id] == $i) {
            $paginas.="<li class='page-item punteados'><a class='page-link paginacion_m paginacion_m_active rounded' href='#'>" . $i . "</a></li>";
        } else {
            $paginas.="<li class='page-item punteados'><a class='page-link paginacion_m rounded ' href='#' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag" . $pag_id . "=" . $i . "'\">" . $i . "</a></li>";
        }
    }
    $paginacion = '<nav aria-label="Paginaci&oacute;n">
                        <ul class="pagination pagination-sm justify-content-left">
			' . $primeros . $paginas . $segundos . '
                        </ul>
                   </nav>  ';

    $str_closeform = "";
    $b_printline = 1;
    $str_closeform = "</form>";
    /* < --- Inicia mensaje de error --- > */

    if (strlen($__SESSION->getValueSession('msg')) > 1) {
        $str_msg_red = "";
        $i_intstyle = 19;
        $i_intcolor = 6;
        for ($i = 0; $i < (strlen($__SESSION->getValueSession('msg')) / 3); $i++) {
            if (strlen($str_msg_red) > 0)
                $str_msg_red.='&nbsp;&nbsp;';
            $str_msg_red.=$CFG_MSG[(substr($__SESSION->getValueSession('msg'), $i * 3, 3) * 1)];
        }
        $__SESSION->setValueSession('msg', 0);
        include("includes/sb_msg_bob.php");
    }
    /* < --- Termina mensaje de error --- > */
    /* revisar la posibilidad de nuevo registro */
    /*     * ************************************** */

    /* < --- Termina mensaje de error --- > */
    /* Linea de titulo de cabecera */
    $twidth = ($suma_width + $widthEditable > 600 ? ($suma_width + $widthEditable) : 600);
    /* termina linea de titulo de cabecera */
    /* inicia  renglon de master */
    /* inicia formulario de busqueda */
   $barra_busqueda_only='';
    if (isset($a_search)) {
    $barra_busqueda='<div class="card" style="margin-top:-6px;margin-bottom:14px;">
                        <div class="row">
                            <div class="col-12 col-md-1">';
        if (trim($a_key[0]) == '100' && !$boolNoEditable && !$boolNoNew) {
            $barra_busqueda.= "<div style='padding-top:13px;width:100%;height:100%;text-align:center;'>";
            $barra_busqueda.="<form method=\"post\" aria-labelledby = 'legend_b_nuevo' action=\"" . $_SERVER['PHP_SELF'] . "\" style=\"margin:0px;\">";
            $barra_busqueda.='<fieldset><legend id = "legend_b_nuevo" style="display:none;" >Agregar nuevo registro</legend>';
            $barra_busqueda.=genInput('hidden', array('op','op_00'), '1');
            $barra_busqueda.=genInput('hidden', array('nivPo','nivPo_00'), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            $barra_busqueda.=genInput('hidden', 'btnAdd', 'btnAdd');
            $barra_busqueda.= '<button style="height:100% !important;background-color: #008000;border: none;padding: 1px 1px;color:#8b4513;" type="submit" class="btn punteados"><i class="fa fa-plus-circle text-white" aria-hidden="true"></i>&nbsp;<span class="text-white" style="font-size:12px;">Nuevo registro</span></button>';
            $barra_busqueda.="</fieldset></form></div>";
        }          
            $barra_busqueda.='  </div>';         
        if ($__SESSION->getValueSession('valSearch') <> "") {
            $strObjSearch = genInput('text', 'txtsearch', ($__SESSION->getValueSession('valSearch')), '', '40', '80', 'form-control', '', '', '0', 'Valor', '', '', '');
            if ($__SESSION->getValueSession('valSearch') <> "" && isset($a_search[4][$__SESSION->getValueSession('itemSearch')]) && $a_search[4][$__SESSION->getValueSession('itemSearch')] == 'select') {
                $strObjSearch = genSelect('txtsearch', '', '', $array_search_val, $array_search_des, ($__SESSION->getValueSession('valSearch')), '', '', ' class="form-control" ', '', '');
            }
        } else {
            $strObjSearch = genInput('text', 'txtsearch', '', '', '40', '80', 'form-control', '', '', '0', 'Valor', '', '', '');
            if (isset($a_search[0]) && isset($a_search[4][$a_search[0][0]]) && $a_search[4][$a_search[0][0]] == 'select') {
                $strObjSearch = genSelect('txtsearch', '', '', $array_search_val, $array_search_des, $a_search[0][0], '', '', ' class="form-control" ', '', '');
            }
        }

        $frmname = 'frmsearch';
        $strsrchperiodo = "";
        if (isset($srchperiodo) && $srchperiodo == 1) {
            if (isset($conf_date_b[0]) && is_array($conf_date_b[0])) {
                $ar_date_t[] = array($conf_date_b[0][0], $conf_date_b[0][1], $conf_date_b[0][2]);
            } else {
                $ar_date_t[] = array('txtinicio', "", "");
            }
            if (isset($conf_date_b[1]) && is_array($conf_date_b[1])) {
                $ar_date_t[] = array($conf_date_b[1][0], $conf_date_b[1][1], $conf_date_b[1][2]);
            } else {
                $ar_date_t[] = array('txtfin', "", "");
            }


            $atmp_asrchperiodo = $__SESSION->getValueSession('asrchperiodo');
            $strsrchperiodo = '<div class="col-12 col-md-1">' .
                    genInput('checkbox', 'chkperiodo', 1, '', '', '', '', '', (is_array($atmp_asrchperiodo) ? 'checked' : ''), '8', '', '', '', '0', '', '') .
                    "" .
                    '           <label for="text-input" class=" form-control-label">&nbsp;&nbsp;F. Ini</label></div>' .
                    '<div class="input-group col-12 col-md-2">' . genInput('text', isset($conf_date_b[0][0]) ? $conf_date_b[0][0] : 'txtinicio', (is_array($atmp_asrchperiodo) ? $atmp_asrchperiodo['inicio'] : date("d/m/Y")), '', '10', '10', 'form-control h5', 'readonly', '', '6', $frmname, '', '', 1) . ''
                    . '   <div class="input-group-append">
                            <button type="button" class="btn btn-success" onclick="mensaje(\'' . (isset($conf_date_b[0][0]) ? $conf_date_b[0][0] : 'txtinicio') . '\')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button>
                        </div>  
                    </div>' .
                    '<div class="col col-md-1"><label for="text-input" class=" form-control-label">F. Fin</label>' . '</div>' .
                    '<div class="input-group col-12 col-md-2">' . genInput('text', isset($conf_date_b[1][0]) ? $conf_date_b[1][0] : 'txtfin', (is_array($atmp_asrchperiodo) ? $atmp_asrchperiodo['fin'] : date("d/m/Y")), '', '10', '10', 'form-control h5', 'readonly', '', '6', $frmname, '', '', 2) .
                    '<div class="input-group-append">
                            <button type="button" class="btn btn-success" onclick="mensaje(\'' . (isset($conf_date_b[1][0]) ? $conf_date_b[1][0] : 'txtfin') . '\')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button>
                        </div>'
                    . '</div>' .
                    "";
        }
        $barra_busqueda.='  <div class="col-12 col-md-11">
                                <div class="card-body card-block" id="d_gen" style="padding: .5rem;">
                                    <form enctype="multipart/form-data" aria-labelledby ="legend_f_b_entidad" class="form-horizontal" id="' . $frmname . '" name="' . $frmname . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                    <fieldset><legend id = "legend_f_b_entidad" style="display:none;" >Busqueda en ' . $entidad . '</legend>
                                        <div class="row form-group" style="margin-bottom: 0px;">
                                            <div class="input-group">
                                                <div class="input-group-append col-1 col-md-1">
                                                    <span class=" input-group-text rounded-left bg-light">Buscar:</span>
                                                </div>
                                                ' . genSelect('selsearch', '', '', $a_search[0], $a_search[1], ($__SESSION->getValueSession('itemSearch') <> "" ? $__SESSION->getValueSession('itemSearch') : $a_search[0]), '', '', ((isset($ajaxSerach) and $ajaxSerach == 1) ?
                                ' onChange="reloadObjSearch(\'search\',\'content_search\',\'selsearch\',2,0,\'txtsearch\');"' : '') . (' class="form-control col-11 col-md-2" ')) . '
                                                <div class=" input-group col-12 col-md-3">
                                                    ' . $strObjSearch . '
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Filtrar"><i class="fa fa-filter text-white" style="font-size: 1rem;"></i></button>
                                                    </div>                                                        
                                                </div>      
                                                    ' . $strsrchperiodo . '
                                              ' . genInput('hidden', 'op', '1') .
                genInput('hidden', 'nivPo', (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0') .
                genInput('hidden', 'btnSearch', 'btnSearch') . '
                                              
                                            </div>';
        $barra_busqueda.= '                                  </div>  
                                    </fieldset></form>                            
                                </div>
                            </div>';
    $barra_busqueda.='</div>'
    .'</div>';        
    }else{
        if (trim($a_key[0]) == '100' && !$boolNoEditable && !$boolNoNew) {
            $barra_busqueda_only.= "";
            $barra_busqueda_only.="<form method=\"post\" aria-labelledby = 'legend_b_nuevo' action=\"" . $_SERVER['PHP_SELF'] . "\" style=\"margin:0px;\"> \n";
            $barra_busqueda_only.='<fieldset><legend id = "legend_b_nuevo" style="display:none;" >Agregar nuevo registro</legend>';
            $barra_busqueda_only.=genInput('hidden', array('op','op_02'), '1');
            $barra_busqueda_only.=genInput('hidden', array('nivPo','nivPo_02'), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            $barra_busqueda_only.=genInput('hidden', 'btnAdd', 'btnAdd');
            $barra_busqueda_only.= '<button style="height:100% !important;background-color: #008000;border: none;padding: 1px 1px;color:#8b4513;" type="submit" class="btn punteados"><i class="fa fa-plus-circle text-white" aria-hidden="true"></i>&nbsp;<span class="text-white" style="font-size:12px;">Nuevo registro</span></button>';
            $barra_busqueda_only.="</fieldset></form>";
        }             
    }

  //  echo $barra_busqueda;        
    $niveles_s = array();
    $lis = "";

    /* echo "<pre>";
      print_r($__SESSION->getValueSession('niveles'));
      die(); */

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
//            echo '<pre>';
//            print_r($atmp_mdFields);die();
            if (isset($atmp_mdFields[$cont]) && isset($atmp_mdKeyFields[$cont]) && isset($atmp_mdValFields[$cont])) {
                foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                    if (strlen($strfields_prin2) > 0)
                        $strfields_prin2.=", ";
                    $strfields_prin2.=$afield;
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
                            $strWherePrin2.=" and ";
                        if ($atmp_mdKeyTFields[$cont][$cont2] == 'num') {
                            if (isset($cambi_nombre))
                                $strWherePrin2.=$cambi_nombre . "=" . $atmp_mdValFields[$cont][$cont2];
                            else
                                $strWherePrin2.=$afield . "=" . $atmp_mdValFields[$cont][$cont2];
                        } else {
                            $strWherePrin2.=$afield . "='" . $atmp_mdValFields[$cont][$cont2] . "'";
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
//            echo '<pre>';            
//            print_r($classconsul);die();

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
//    echo '<pre>';        
//    print_r($niveles_a);die();
    if (isset($niveles_s) || isset($niveles_a)) {
        $icono = "";
        for ($index = 0; $index < count($niveles_a); $index++) {
            if ($index == 0) {
                $icono = '<i class="fa fa-home" style="font-size:1.3em;color:#7fffd4;"></i>&nbsp;';
            } else {
                $icono = '';
            }
            $lis.= '<li class="breadcrumb-item"><a href="#" '." onClick=\"window.location='" . $link_niv[$index] . "'\"" .' style="color:#f5f5dc;" data-toggle="tooltip" title="' . $niveles_a[$index] . '">' . $icono . $niveles_s[$index] . '</a></li>';
          //  $lis.= '<a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' class="tip-bottom text-secondary" data-toggle="tooltip" title="' . $niveles_a[$index] . '" style="font-size:17px;text-decoration: none;">&nbsp;' . $icono . $niveles_s[$index] . '</a>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i>';
        }
    }
    echo '<nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background-color:#4c4c4c;margin-bottom: .5rem !important;padding: .5rem 1rem;">
                '.$lis.'
                <li class="breadcrumb-item active" style="color:#ffffff;" aria-current="page">'.$entidad.'</li>
            </ol>
          </nav>';
    
    echo $barra_busqueda;

    echo '<div class="card">
      <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12" style="overflow:auto;">';

    ////fin de cabeceras
    if (!isset($boolColHeaders))
        $boolColHeaders = true;
    if ($boolColHeaders) {
        echo '<div class="card-body" style="padding: 0rem;">';
        echo '<div class="table-responsive" id="tabla_datos_entidad" style="min-height:500px;">';
        echo genOTable('0', '', '', 'table table-hover  color_negro', '#FFFFFF', '0', '3', '', ((($i + 1) == $classent->NumReg) ? '' : 'margin-bottom:' . (isset($str_margin_reg) ? $str_margin_reg : "10px") . ';'));
        echo "<caption class='color_negro' style='caption-side: top;padding-top: .1rem;padding-bottom: .1rem;height:40px;'>".$barra_busqueda_only."<h1 class='h5' style='".(strlen($barra_busqueda_only)>0?'position: relative;top: -27px;left:110px;':'')."'>Listado de: ".$entidad."</h1></caption>";
        echo '<thead>' . genORen('', '', '', 'success', '', ' background-color:#008000; ');
        /* revisar la posibilidad de nuevo registro */

        if (isset($intNivel) || isset($a_print) || $widthEditable <> 0){
            echo genCol_T("Acciones", '', '', '', '', '', '', ' text-white font-weight-bold', '', "padding-bottom:12px;padding-left:10px;",'','id="c_00"');
        }
        $countcell = 1;
        foreach ($field as $key => $afield)
            if (!in_array($afield[0], $array_noprint_ent) && $afield[2] == '1') {
                $descripcion = "";
                if (is_array($afield[1])) {
                    $descripcion = $afield[1][0];
                } else {
                    $descripcion = $afield[1];
                }                
                echo genCol_T("<div style='width:" . $afield[8] . "px;' class='text-white " . ($CFG_STYLE[2] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1] . ' ' . ($countcell == $numcols ? $CFG_STYLE[5] : $CFG_STYLE[4])) . "'>" . (isset($afield[17]) ? $afield[17] :$descripcion) . "</div>", '', '', '', (isset($afield[20]) && strlen($afield[20]) > 0) ? $afield[20] : '', $afield[8], '', '', '','','','id="c_'.$key.'"');
                $countcell++;
            }
        echo genCRen() . "</thead>".'<tbody>';
    }

    /* terminan titulos */
    $tmp_boolNoUpdate = $boolNoUpdate;
    $tmp_boolNoDelete = $boolNoDelete;
    $tmp_widthEditable = $widthEditable;
    $tmp_style = $CFG_LBL[30];
    /* echo "<pre>";
      print_r($classent);  */
    for ($i = 0; $i < $classent->NumReg; $i++) {
        $boolNoUpdate = $tmp_boolNoUpdate;
        $boolNoDelete = $tmp_boolNoDelete;
        $widthEditable = $tmp_widthEditable;
        $classent->VerDatosEntidad($i, $afields);
        if (function_exists('fnpintaeditar')) {
            fnpintaeditar($classent, $__SESSION->getAll());
        }
        $boolSetColor = false;
        $strSetColor = "";
        $strSetStyle = "";
        $CFG_LBL[30] = $tmp_style;
        $strColorRow1 = $CFG_BGC[27];
        $strColorRow2 = $CFG_BGC[6];
        if (isset($a_boolNoDelete0)) {
            foreach ($a_boolNoDelete0 as $cntbnd => $itembnd) {
                if (is_array($itembnd)) {
                    if (!in_array($classent->$a_boolNoDelete1[$cntbnd], $itembnd)) {
                        $boolNoDelete = true;
                        break;
                    }
                } else {
                    if ($itembnd != $classent->$a_boolNoDelete1[$cntbnd]) {
                        $boolNoDelete = true;
                        break;
                    }
                }
            }
        }
        if (isset($a_boolNoUpdate0)) {
            foreach ($a_boolNoUpdate0 as $cntbnd => $itembnd) {
                if (is_array($itembnd)) {
                    if (!in_array($classent->$a_boolNoUpdate1[$cntbnd], $itembnd)) {
                        $boolNoUpdate = true;
                        break;
                    }
                } else {
                    if ($itembnd != $classent->$a_boolNoUpdate1[$cntbnd]) {
                        $boolNoUpdate = true;
                        break;
                    }
                }
            }
        }
        if (function_exists('fnSetRowColor')) {
            fnSetRowColor($classent);
        }
//		echo "<pre>";
//		print_r($classent);
//		echo "</pre>";   
        $str_onclick = "";
        $str_href = "";
        if (isset($intNivel)) {

            $str_href = $_SERVER['PHP_SELF'] . "?nivel=" . $intNivel;


            foreach ($keyFields as $cont => $item) {
                $str_onclick.="&it" . $cont . "=" . $classent->$item;
                $str_href.="&it" . $cont . "=" . $classent->$item;
            }
            $contAdd = $cont;
            //print_r($keyFieldsAdd);

            if (!isset($keyFieldsAdd)) {
                $keyFieldsAdd = array();
            }
            foreach ($keyFieldsAdd as $cont => $item) {
                $contAdd++;
                $str_onclick.="&it" . $contAdd . "=" . $classent->$item;
                $str_href.="&it" . $contAdd . "=" . $classent->$item;
            }
            $str_onclick.="'\"";
        }
        //	echo "asasd".$str_href;die();


        if ($boolSetColor) {
            if (isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0) {
                
            } else {
                $CFG_LBL[30] = $strSetStyle;
                $strColorRow1 = $strSetColor;
                $strColorRow2 = $strSetColor;
            }
        } else {
            $CFG_LBL[30] = $tmp_style;
            $strColorRow1 = $CFG_BGC[6];
            $strColorRow2 = $CFG_BGC[6];
        }

        //echo genOTable('0',$twidth.'px','','','#FFFFFF','0','3','',((($i+1)==$classent->NumReg)?'':'style="margin-bottom:'.(isset($str_margin_reg)?$str_margin_reg:"10px").';"'));
        if (!$boolColHeaders) {
            echo genOTable('0', $twidth . 'px', '', '', '#FFFFFF', '0', '3', '', ((($i + 1) == $classent->NumReg) ? '' : 'style="margin-bottom:' . (isset($str_margin_reg) ? $str_margin_reg : "10px") . ';"'));
        }
        if (function_exists('addRowSepar')) {
            addRowSepar($classent);
        }

        if (strlen($CFG_LBL[30]) == 0)
            $CFG_LBL[30] = $tmp_style;

        echo genORen('', '', '', 'table_hover_cab', ($i % 2) ? $strColorRow1 : $strColorRow2,'', "row_" . $i);
        if (function_exists('fnBeforeButtons')) {

            fnBeforeButtons($classent);
            // echo 'estado: '.$boolNoEditable;die();
        }

        /* col de botones */

        if (!isset($intNW))
            $intNW = 40;
        //---- COMIENZA LA COLUMNA IMPRESION Y LEYENDAS DE NIVEL
        if (!isset($suma_width_aux))
            $suma_width_aux = 40;
        if (isset($intNivel) || (isset($a_print) && count($a_print) > 0) || $widthEditable > 0) {
            echo genOCol('', 'center', '', '', (isset($suma_width_aux) ? ($suma_width_aux + $widthEditable) : $widthEditable) . 'px', '', ($CFG_STYLE[7] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]));
            /* referencias de IMPRESION Y LEYENDAS DE NIVEL' */
            echo "<div style=\"width:" . ($suma_width_aux + $widthEditable + 50) . "px; margin:0px;\">";
            if (sizeof($a_print) > 0) {
                $str_print = "";
                foreach ($a_print as $cont_item_a => $item_a) {
                    $str_explodevalues = "";
                    foreach ($item_a[2] as $cont_e => $item_e) {
                        if ($cont_e > 0)
                            $str_explodevalues.=':';
                        $str_explodevalues = $classent->$item_e;
                    } 
                    $str_print.="<a id='menu_sub_i_".$cont_item_a."' style='' class='dropdown-item punteados'  href=".((isset($item_a[4]) && $item_a[4]==1)?"":"\"javascript:abrir(\'");
                    $str_print.=$item_a[0];
                    $str_print.="rowid=" . base64_encode(addslashes($str_explodevalues)) . "&";
                    foreach ($item_a[2] as $cont_e => $item_e) {
                        if ($cont_e > 0)
                            $str_print.='&';
                        $str_print.=$item_e . '=' . $classent->$item_e;
                    }
                    $str_print.=((isset($item_a[4]) && $item_a[4]==1)?">":"\')"."\">")."<i style='color:black;' class='" . (isset($item_a[5]) && strlen($item_a[5]) > 0 ? $item_a[5] : 'fa fa-print') . "'></i>&nbsp;" . (isset($item_a[4]) && strlen($item_a[4]) > 0 ? $item_a[4] : 'Imprimir') . "</a>";
                }
            }
            if ((isset($intNivel) && $intNivel > 0) || sizeof($a_print) > 0) {
                $icon_niveles = "";
                for ($nx = 1; $nx <= 100; $nx++) {
                    $trs_ref_add = "";
                    $stridniv = "str_idniv" . $nx;
                    if ($nx > 1) {
                        $trs_ref_add = "&nivtg=" . $nx;
                    }
                    if (isset($$stridniv)) {
                        $var_n = (isset(${"str_titleniv" . $nx}) ? ${"str_titleniv" . $nx} : "") . "";
                        $var_n_e = (isset(${"str_estilo" . $nx}) ? ${"str_estilo" . $nx} : "") . "";
                        $icon_niveles.="<a style='display: inline-block;' class='dropdown-item punteados' id='menu_sub_n_".$nx."' href='" . $str_href . $trs_ref_add . "'><span><i id='sub_icon_".$i."_".$nx."' style='" . $var_n_e . "' class='" . (isset($$stridniv) ? $$stridniv : "") .  "'></i>&nbsp;&nbsp;" . ($var_n) . "</span></a>";
                    }
                }
                echo '<div class="dropdown">
                        <button id="submen35' . $i . '" style="margin:0px;float:left;" class="dropdown-toggle punteados" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Dezplegar acciones del registro">
                            <i class="fa fa-bars" id="barras_menu_sub_'.$i.'" ></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="submen35' . $i . '">';
                echo $icon_niveles . $str_print;
                echo '      <a class="dropdown-item punteados" style="border-top: 1px solid #A6A6A6;" href="#"><i class="fa fa-window-close" style="color:red;"></i>&nbsp;&nbsp;Cerrar men&uacute;</a>';
                echo '  </div>
                      </div>	';
            }

            /* termina referencias de impresion */
        }
//--   termina columna de botones de edicion, impresion y leyenda de nivel
        $strGetValues = "";
        foreach ($keyFields as $cont => $item) {
            if (strlen($strGetValues) > 0)
                $strGetValues.="&";
            $strGetValues.= $item . "=" . $classent->$item;
        }

        $strIdentifyRow = "";
        if (isset($a_identifyRow)) {
            foreach ($a_identifyRow as $cont => $item) {
                $strIdentifyRow.= " " . $classent->$item;
            }
        }

        $strKeysRow = "";
        if (isset($keyFieldsPop)) {
            foreach ($keyFieldsPop as $cont => $item) {
                //$strHiden.=genInput('hidden',$item,$classent->$item);
                if ($strKeysRow <> "")
                    $strKeysRow.="@:";
                $strKeysRow.=$item . "=" . $classent->$item;
            }
        }

        //---- COMIENZA LA COLUMNA BOTONES DE EDICION
//if (trim($a_key[1])=='100' && !$boolNoEditable ){		//&& (!$boolNoUpdate or !$boolNoDelete)
//---Empiezan botones de edicion
        if ($b_printline == 1 && !$boolNoUpdate && $widthEditable > 0) {
            ?>
            <!--                <div class="botones2 iconoeditar" onclick='javascript:$("#"+"botonesmd4_<?php echo $i; ?>").show("slow");'></div>
            -->                <?php
            echo"<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\" style='margin:0px; float:left;'> \n";
            //echo genOCol('','center','',$CFG_BGC[1],'18','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
            //		 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
            foreach ($keyFields as $cont => $item) {
                echo genInput('hidden', array($item,$item."_u_".$i), $classent->$item);
            }
            echo genInput('hidden',array('op','op_u_'.$i), '1');
            echo genInput('hidden',array('nivPo','nivPo_u_'.$i), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            echo genInput('hidden',array('btnUpd','btnUpd_u_'.$i), 'btnUpd', '', '', '', 'btn') . "<button type='submit' class='bg-light boder' aria-label='Editar registro' title='Editar registro' data-toggle='tooltip' data-placement='right' ><i id='botones_accion_abc_".$i."' class='fa fa-pencil-square-o'></i></button>";
            //echo genCCol();
            echo $str_closeform;
        }
        if (trim($a_key[2]) == '100' && !$boolNoEditable && !$boolNoDelete) {
            echo"<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\" style='margin:0px; float:left;'> \n";
            $strHiden = "";
            foreach ($keyFields as $cont => $item)
                $strHiden.=genInput('hidden', $item, $classent->$item);
//				echo genOCol('','center','',$CFG_BGC[1],'18','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
//						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
            echo $strHiden .
            genInput('hidden',array('op','op_d_'.$i), '1');
            echo genInput('hidden',array('nivPo','nivPo_d_'.$i), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            echo genInput('hidden',array('btnDel','btnDel_d_'.$i), 'btnDel', '', '', '', 'btn') .
            "<button type=\"submit\" value=\"\" title='Borrar registro' aria-label='Borrar registro' data-toggle='tooltip' data-placement='right' class='' onclick=\"show_confirm('MODULO DE " . strtoupper($entidad) . " : < mensaje de confirmacion >','Esta seguro que desea borrar el registro" . addslashes($strIdentifyRow) . "?');return document.obj_retVal;\"><i id='botones_accion_abc' class='fa fa-eraser'></i></button>";
//				echo genCCol();
            echo $str_closeform;
        }
        echo "</div>";
        /* fin de col de botones */
//			echo genCRen().genCTable();
        echo genCCol();
//	}	
//--   termina columna de botones de edicion


        /* fin de col de botones */
        foreach ($field as $count_fields => $afield) {
            if (!in_array($afield[0], $array_noprint_ent) && $afield[2] == '1') {
                $style = $CFG_LBL[30];
                $descripcion = "";
                if (is_array($afield[1])) {
                    $descripcion = $afield[1][0];
                } else {
                    $descripcion = $afield[1];
                }                  
                switch ($afield[3]) {
                    case 'select':
                        if (isset($array_recarga) && $sel == '0' && isset($afield[24]) && $afield[24] == true and $regarga35 == true) {
                            foreach ($array_recarga as $array_item) {
                                $arraglo_temp = array();
                                foreach ($array_item[2] as $cont => $itemCondicion) {
                                    $valor = "" . $classent->$itemCondicion[1];
                                    if (strlen($valor) > 0) {
                                        $arraglo_temp = armar_arreglo($tmpvar_a1, $tmpvar_a2, $tmpvar_a3, $valor);
                                    }
                                }
                                $afield[5][0] = $arraglo_temp[0];
                                $afield[5][1] = $arraglo_temp[1];
                            }
                        }
                        $cont = 0;
                        $intFound = true;
                        foreach ($afield[5][0] as $isel) {
                            if ($isel == $classent->$afield[0]) {
                                echo genCol($afield[5][1][$cont] . ((isset($a_pop_e3) && in_array($afield[0], $a_pop_e3)) ? (strlen($afield[5][1][$cont]) > 0 ? '&nbsp;' : '') . "<a style=\"" .
                                                "color:black;\" class='punteados' role='button' aria-label='Mostrar ventana ".$a_popTitle_e3[array_search($afield[0], $a_pop_e3)]."' href=\"#\" onClick=\"toolTipAdd2('<img src=img/arrow_green.gif border=0 > cargando datos ...',this,'" .
                                                $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] .
                                                "','toolTipBox','" . $a_popContent_e3[array_search($afield[0], $a_pop_e3)] .
                                                "','" . $a_popObVal_e3[array_search($afield[0], $a_pop_e3)] . "_row_" . $i . "','" . $strKeysRow . "'," . $a_popPos_e3[array_search($afield[0], $a_pop_e3)] . "," . $__SESSION->getValueSession('mod') . ",true,'','','" . $afield[0] . "_row_" . $i . "'); return true;\"  alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\"><img src=\"img/editfld.gif\" border='0' " .
                                                " alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\" ></a>" : "")
                                        , '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ?
                                                ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetColor : $afield[21]) :
                                                (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                        , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                                ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetStyle : $afield[22]) : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                        $CFG_LBL[45] : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                                $CFG_LBL[41] : $CFG_LBL[30])), '','', " id='" . $afield[0] . "_row_" . $i . "' "," headers='c_".$count_fields."'");
                                $intFound = false;
                            }
                            $cont+=1;
                        }
                        if ($intFound) {
                            echo genCol('&nbsp;', '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ? $afield[21] :
                                            (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                    , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                            $afield[22] : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                    $CFG_LBL[45] : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                            $CFG_LBL[41] : $CFG_LBL[30])), '', '',''," headers='c_".$count_fields."'");
                        }
                        $var_scope="";
                        break;
                    case 'lst2':
                        $a_xTmpLstValues = explode('@|', $classent->$afield[0]);
                        $line_tetxtcontent = "";
                        if (strlen($classent->$afield[0]) > 0) {
                            foreach ($a_xTmpLstValues as $isel) {
                                if (in_array($isel, $afield[5][0])) {
                                    if (strlen($line_tetxtcontent) > 0)
                                        $line_tetxtcontent.="<br>";
                                    $line_tetxtcontent.=$afield[5][1][array_search($isel, $afield[5][0])];
                                }
                            }
                        }else {
                            $line_tetxtcontent = '&nbsp;';
                        }

                        echo genCol($line_tetxtcontent, '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ?
                                        ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetColor : $afield[21]) :
                                        (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                        ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetStyle : $afield[22]) : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                $CFG_LBL[45] : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                        $CFG_LBL[41] : $CFG_LBL[30])), '', '','', " headers='c_".$count_fields."'");
                        $var_scope="";
                        break;
                    case 'check':
                        echo genCol(genInput('checkbox', $afield[0], '', '', '', '', '', 'DISABLED', ($classent->$afield[0] == 1 ? 'checked' : ''), '5')
                                , '', '', '', '', $afield[8], '', ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]), '', '',''," headers='c_".$count_fields."'");
                        $var_scope="";
                        break;
                    case 'file':
                        $strlnk_getfile = "";
                        if (isset($file_get) and strlen(trim($file_get)) > 0 and ( $classent->$afield[0] <> "")) {
                            $strlnk_getfile = "<a href='files/getfile.php?" . $strGetValues . "&file_get=" . $file_get . "' target='_blank'>" . $classent->$afield[0] . "</a>";
                        } else {
                            $strlnk_getfile = ($classent->$afield[0] <> "" ? $classent->$afield[0] : '');
                        }
                        echo genCol(($strlnk_getfile <> "" ? $strlnk_getfile : ''), '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ? $afield[21] :
                                        (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                        $afield[22] : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                $CFG_LBL[45] : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                        $CFG_LBL[41] : $CFG_LBL[30])), '', '','', " headers='c_".$count_fields."'");
                        $var_scope="";
                        break;
                    case 'join':

                        break;
                    case 'f_archivo':                        echo genCol($classent->$afield[0] . '<a target="_blank" href="' . $classent->ruta . $classent->$afield[0] . '"><img style="4em;height:3em;" src="' . $classent->ruta . $classent->$afield[0] . '" alt="" class="img-thumbnail"></a>', '', '', '', '', '', '', '', '','',''," headers='c_".$count_fields."'");
                        $var_scope="";
                        break;
                    default:
                        if (isset($afield[18]) && $afield[18] == 1) {
                            $str_implodevalues = "";
                            echo genOCol('', '', '', '', $afield[8], '', $CFG_LBL[30], '', ''," headers='c_".$count_fields."'");
                            foreach ($afield[19][0] as $count_int_aafield => $int_aafield) {
                                if ($count_int_aafield > 0)
                                    $str_implodevalues.=$afield[19][1];
                                $str_implodevalues.=$classent->$field[$int_aafield][0];
                            }
                            echo $str_implodevalues;
                            echo genCCol();
                            $var_scope="";
                        } else {

                            //$strFieldValue = str_replace("\n", "<br/>", ($afield[6] == 'date' ? implode('/', array_reverse(explode('-', $classent->$afield[0]))) : $classent->$afield[0]));
                            $strFieldValue=$classent->$afield[0];
                            if (strlen($strFieldValue) == 0)
                                $strFieldValue = "&nbsp;";
                            if (isset($afield[23]) and strlen(trim($afield[23])) > 0) {
                                eval("\$strFieldValue=" . $afield[23] . '(' . $classent->$afield[0] . ');');
                            }
                            if (strlen($strFieldValue) > 120) {
                                $strFieldValue = "<div class=\"div11px\"><div id=\"id_col" . $afield[0] . "_div" . $i . "\">" . substr($strFieldValue, 0, 120) . "</div>" .
                                        "&nbsp;&nbsp;<a href=\"javascript:ver('id_col" . $afield[0] . "_span" . $i . "','id_col" . $afield[0] . "_div" . $i . "')\" style=\"font-size:10px;text-decoration:none;\" >[+/-]" . $afield[0] . "</a>" .
                                        formatDiv('id_col' . $afield[0] . '_span' . $i, str_replace("\n", "<br/>", $strFieldValue), $descripcion, $i, "span11px") . "</div>";
                            }
                            echo genCol(str_replace("\n", '<br>', $strFieldValue) . ((isset($a_pop_e3) && in_array($afield[0], $a_pop_e3)) ? (strlen($strFieldValue) > 0 ? '&nbsp;' : '') . "<a style=\"" .
                                            "color:black;\" class='punteados' role='button' aria-label='Mostrar ventana ".$a_popTitle_e3[array_search($afield[0], $a_pop_e3)]."' href=\"#\" onClick=\"toolTipAdd2('<img src=img/arrow_green.gif border=0 > cargando datos ...',this,'" .
                                            $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] .
                                            "','toolTipBox','" . $a_popContent_e3[array_search($afield[0], $a_pop_e3)] .
                                            "','" . $a_popObVal_e3[array_search($afield[0], $a_pop_e3)] . $i . "','" . $strKeysRow . "'," . $a_popPos_e3[array_search($afield[0], $a_pop_e3)] . "," . $__SESSION->getValueSession('mod') . "); return true;\"  alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\"><img src=\"img/editfld.gif\" border='0' " .
                                            " alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\" ></a>" : ""), '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ?
                                            ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetColor : $afield[21]) :
                                            (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                    , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                            ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetStyle : $afield[22]) : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                    ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]) : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                            ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]) : ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]))), '','', " id='" . $afield[0] . $i . "'"," headers='c_".$count_fields."'");
                            $var_scope="";
                        }
                        break;
                }
            }
        }
        if (function_exists('fnAfterButtons')) {
            fnAfterButtons($classent);
        }
        echo genCRen();
    }

    //echo genCCol() . genCRen();

    echo '</tbody>' . genCTable()."</div></div>";
    echo '      </div>'
    . '       </div>'
    . '</div>'
    . '</section></div>';
    //paginacion
    $barra_registros = '       <div class="card">
                                <div class="card-body card-block" id="d_gen" style="padding-top: .5rem;padding-bottom: 0rem;">
                                    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                        <div class="row form-group" style="margin-bottom: 0px;">
                                    
                                                <div class="col-12 col-md-2">
                                                    <div class="form-group" style="margin-bottom: 0rem;">
                                                        <div class="input-group">
							     ' . genInput('text', 'intpag_s' . $pag_id, '', '', '5', '5', 'form-control', '', '', '0', 'Valor', '', '', '', '', 'style="width:20px;" aria-label="N&uacute;mero de p&aacute;gina"') .
            genInput('hidden', 'nivPo', (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0') . '
                                                            <div class="input-group-append">
                                                                <button type="submit" class="btn paginacion_m" title="Buscar n&uacute;mero de p&aacute;gina">Ir</button>
                                                            </div>  
                                                        </div>
                                                    </div>                                                    
                                                </div>                                                    
                                                <div class="col-12 col-md-7">
                                                    ' . $paginacion . '
                                                </div>                                                 
                                                <div class="col-12 col-md-3 text-right">
                                                    <p class="color_negro">' . $reg_found . " registro(s) encontrado(s)" . '</p>
                                                </div>';

    $barra_registros.= '                    </div>  
                                    </form>                            
                                </div>
                            </div>';
    echo '' . $barra_registros;


}

function formatDiv($target, $data, $label, $idrow, $classDiv) {
    return "<div id=\"" . $target . "\" class=\"" . $classDiv . "\"><div style='font-weight:bold;font-variant:small-caps'>" . $label . ":</div>" . $data . "</div>";
}

function convierte_imagen($id, $id_val, $tabla) {
    $classent = new Entidad(array('file_type', 'content_file', 'file_name'), array('', '', ''));
    $classent->ListaEntidades(array(), "", "", "", "no", "", "select file_type, content_file, file_name from " . $tabla . " where " . $id . "=" . $id_val);
//                                
//                                echo '<pre>';
//                                print_r($classent);
//                                echo '</pre>';
//                                die();
    if ($classent->NumReg > 0) {
        $tipo = mysql_result($classent->Lista, 0, "file_type");
        $contenido = mysql_result($classent->Lista, 0, "content_file");
        $nombre = mysql_result($classent->Lista, 0, "file_name");
//					header("Content-type: ".$tipo);
//					header("Content-Disposition: ; filename=\"" . $nombre . "\""); 
//					print $contenido; 
        $tipo = "image/png";
        header("Content-type: " . $tipo);
        header("Content-Disposition: ; filename=\"_foto");
        echo readfile("../images/usuario_img.png");
    } else {
        $tipo = "image/png";
        header("Content-type: " . $tipo);
        header("Content-Disposition: ; filename=\"_foto");
        echo readfile("../images/usuario_img.png");
    }
}
?>
<script>



    var visto = null;
    function ver(objname, objname2) {
        obj = document.getElementById(objname);
        //obj.style.display = (obj==visto) ? 'none' : 'block';
        if (obj == visto) {
            $("#" + objname2).slideDown("slow");
            $("#" + objname2).css('color', 'black');
            $("#" + objname).css('color', 'white');
            $("#" + objname).slideUp("slow");
        } else {
            $("#" + objname).css('color', 'black');
            $("#" + objname).slideDown("slow");
            $("#" + objname2).css('color', 'white');
            $("#" + objname2).slideUp("slow");
        }
//  if (visto != null)
//    visto.style.display = 'none';
        visto = (obj == visto) ? null : obj;
    }

</script>
