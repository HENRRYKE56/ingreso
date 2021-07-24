<?php
/* -------------------------------------------------------
  -------------------------------------------------------
  -------------------------------------------------------
 */
$horaini = date("H:i:s");
//echo "la hora es:" . $horaini;
include_once("config/cfg.php");
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("lib/lib_function.php");
    include_once("includes/sb_refresh.php");
} else {

    include_once("lib/lib_function.php");
//include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
//include_once("rep/lib/lib32.php");
    $afields = array();
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
    if (isset($array_recarga) && $sel == '0' && $regarga35 == true) {
        foreach ($array_recarga as $array_item) {
            $tmpvar_a1 = array();
            $tmpvar_a2 = array();
            $classconsul = new Entidad($array_item[0], $array_item[1]);
            $consulWhere = " ";
            if (isset($array_item[7]))
                $consulWhere.=$array_item[7];

            $classconsul->ListaEntidades($array_item[5], $array_item[4], $consulWhere, "", "yes");
            for ($i = 0; $i < $classconsul->NumReg; $i++) {
                $classconsul->VerDatosEntidad($i, $array_item[0]);
                $tmpvar_a1[] = $classconsul->$array_item[0][0];
                $tmpvar_a2[] = $classconsul->$array_item[0][1];
                $tmpvar_a3[] = $classconsul->$array_item[0][2];
            }
            $field[$array_item[6]][5][0] = $tmpvar_a1;
            $field[$array_item[6]][5][1] = $tmpvar_a2;
        }
    }
//    echo '<pre>';
//    print_r($_POST);die();
    $ar_post = array_keys($_POST);

    $where_add_c_s = "";
    foreach ($ar_post as $key_p => $value_p) {
        if (stripos($value_p, 'i_input_') === false) {
            
        } else {
            if (strlen($_POST[$value_p]) > 0) {
                $ar_campo_bus_aux = explode('|', $value_p);
                $ar_campo_bus = $ar_campo_bus_aux[1];
                $ar_campo_bus = str_replace(':-:', '.', $ar_campo_bus);
                $orden_campo = array();
                $ar_campo_bus_aux = explode("_", $ar_campo_bus_aux[0]);
                $ar_campo_bus_aux = $ar_campo_bus_aux[2];
                //     die($ar_campo_bus_aux);
                switch ($ar_campo_bus_aux) {
                    case 'txt':
                        $where_add_c_s = " " . $ar_campo_bus . " like '%" . $_POST[$value_p] . "%' ";
                        break;
                    case 'che':
                        $where_add_c_s = " " . $ar_campo_bus . " = 1 ";
                        break;
                    case 'sel':
                        $where_add_c_s = " " . $ar_campo_bus . " = " . $_POST[$value_p] . " ";
                        break;
                }

                $__SESSION->setValueSession('where_add', $where_add_c_s);
            }
        }
    }
    if (isset($_GET['clear_cmp']) && $_GET['clear_cmp'] == 'true') {
        $__SESSION->unsetSession('orden_c');
        $__SESSION->unsetSession('where_add');
    }


    $widthEditableIni = $widthEditable;
    $classent = new Entidad(array('count_r'), array('0'));
//$classent->ListaEntidades(array(),$tablas_c,$strWhere,"count_r(DISTINCT ".$tabla.".".$id_prin.")","no");    
    if ($__SESSION->getValueSession('where_add') <> "") {
        if (stripos($strDistintic, "where") === false) {
            $strDistintic.=" where " . $__SESSION->getValueSession('where_add');
        } else {
            $strDistintic.=" and " . $__SESSION->getValueSession('where_add');
        }
    }
    $reg_found = 0;
    $classent->ListaEntidades(array(), "", "", "", "no", "", $strDistintic);
//    echo '<pre>';
//    print_r($classent);die();

    $pag_id = $__SESSION->getValueSession('mod') . $__SESSION->getValueSession('niv');
    /* <--------------se define pagina-------------> */
    if (isset($_GET['intpag' . $pag_id]))
        if (!is_null($_GET['intpag' . $pag_id]))
            if (intval($_GET['intpag' . $pag_id]) > 0)
                $__SESSION->setValueSession('pag' . $pag_id, intval($_GET['intpag' . $pag_id]));
    if (isset($_POST['intpag' . $pag_id]))
        if (!is_null($_POST['intpag' . $pag_id]))
            if (intval($_POST['intpag' . $pag_id]) > 0)
                $__SESSION->setValueSession('pag' . $pag_id, intval($_POST['intpag' . $pag_id]));

    if ($__SESSION->getValueSession('pag' . $pag_id) <> "")
        $intpag[$pag_id] = $__SESSION->getValueSession('pag' . $pag_id);

    $ar_get = array_keys($_GET);
    foreach ($ar_get as $key_g => $value_g) {
        if (stripos($value_g, 'order_') === false) {
            
        } else {
            $ar_campo_ord = explode('|', $value_g);
            $ar_campo_ord = str_replace(':-:', '.', $ar_campo_ord[1]);
            $orden_campo = array();
            $orden_campo[] = " " . $ar_campo_ord . " " . $_GET[$value_g] . " ";

            $__SESSION->setValueSession('orden_c', $orden_campo);
        }
    }



    if ($classent->NumReg > 0) {
        $classent->VerDatosEntidad(0, array('count_r'));
        $reg_found = $classent->count_r;
    }
    $decdiv = intval($reg_found / $intlimit);
    $intmod = ($reg_found / $intlimit) - $decdiv;
    if ($intmod > 0) {
        $decdiv+=1;
    }
    if (!isset($intpag[$pag_id]))
        $intpag[$pag_id] = 1;
    if ($intpag[$pag_id] > $decdiv || $intpag[$pag_id] < 0 || !isset($intpag[$pag_id]))
        $intpag[$pag_id] = 1;
    $intOffset = ($intlimit * $intpag[$pag_id]) - $intlimit;
    $strlimit = " LIMIT $intlimit OFFSET $intOffset";

    $primeros = "";
    $segundos = "";
    if ($intpag[$pag_id] > 1) {
        $primeros = "<li class='page-item punteados'><a href='#' aria-label='Primera p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag" . $pag_id . "=1" . "'\" ><i class='fa fa-fast-backward' style='color:inherit;'></i></a></li>";
        $primeros.="<li class='page-item punteados'><a href='#' aria-label='Retroceder p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag" . $pag_id . "=" . ($intpag[$pag_id] - 1) . "'\" ><i class='fa fa-backward' style='color:inherit;'></i></a></li>";
    } else {
        $primeros = "<li class='page-item disabled punteados'><a href='#' aria-label='Primera p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-fast-backward' style='color:#a9a9a9;'></i></a></li>";
        $primeros.="<li class='page-item disabled punteados'><a href='#' aria-label='Retroceder p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-backward' style='color:#a9a9a9;'></i></a></li>";
    }
    if ($intpag[$pag_id] < $decdiv) {
        $segundos = "<li class='page-item punteados'><a href='#' aria-label='Siguiente p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag" . $pag_id . "=" . ($intpag[$pag_id] + 1) . "'\"><i class='fa fa-forward'></i></a></li>";
        $segundos.="<li class='page-item punteados'><a href='#' aria-label='Ultima p&aacute;gina' class='page-link paginacion_m rounded' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag" . $pag_id . "=" . $decdiv . "'\" ><i class='fa fa-fast-forward'></i></a></li>";
    } else {
        $segundos = "<li class='page-item punteados'><a href='#' aria-label='Siguiente p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-forward' style='color:#a9a9a9;'></i></a></li>";
        $segundos.="<li class='page-item punteados'><a href='#' aria-label='Ultima p&aacute;gina deshabilitada' class='page-link'><i class='fa fa-fast-forward' style='color:#a9a9a9;'></i></a></li>";
    }
    /* inicia paginacion */
    $paginas = 20;
    $inipag = 1;
    $finpag = $paginas;
    if ($decdiv >= $paginas) {
        if ($intpag[$pag_id] - ($paginas / 2) >= 1 && $intpag[$pag_id] + ($paginas / 2) <= $decdiv) {
            $inipag = $intpag[$pag_id] - ($paginas / 2);
            $finpag = $intpag[$pag_id] + ($paginas / 2);
        } else {
            if ($intpag[$pag_id] - ($paginas / 2) < 1) {
                $inipag = 1;
                $finpag = $paginas;
            }
            if (($intpag[$pag_id] + ($paginas / 2)) > $decdiv) {
                $inipag = $decdiv - $paginas;
                $finpag = $decdiv;
            }
        }
    } else {
        $finpag = $decdiv;
    }
    $paginas = "";
//die($inipag." ".$finpag);
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

    $classent = new Entidad($allfields, $allvalues);
    foreach ($field as $afield)
        if ($afield[2] == '1' || $afield[2] == '2')
            $afields[] = $afield[0];
    //   echo 'condicion: '.$tablas_c;
    //    echo '</br>condicion: '.$strWhere;
    if (is_array($__SESSION->getValueSession('orden_c')) && count($__SESSION->getValueSession('orden_c')) > 0) {
        $a_order = $__SESSION->getValueSession('orden_c');
    }

    if ($__SESSION->getValueSession('where_add') <> "") {
        if (stripos($strWhere, "where") === false) {
            $strWhere.=" where " . $__SESSION->getValueSession('where_add');
        } else {
            $strWhere.=" and " . $__SESSION->getValueSession('where_add');
        }
    }
    $classent->ListaEntidades($a_order, $tablas_c, $strWhere, (isset($items0) ? $items0 : ''), '', $strlimit, "", (isset($tipo_order) ? $tipo_order : ''));
//
//    echo '<pre>';
//    print_r($classent);
//    die();
    $str_closeform = "";
    $b_printline = 0;
    $b_printline = 1;
    $str_closeform = "</form>";

    /* < --- Inicia mensaje de error --- > */

    if (strlen($__SESSION->getValueSession('msg')) > 1) {

        $str_msg_red = "";
        $i_intstyle = 29;
        $i_intcolor = 6;
        for ($i = 0; $i < (strlen($__SESSION->getValueSession('msg')) / 3); $i++) {
            if (strlen($str_msg_red) > 0)
                $str_msg_red.=',&nbsp;&nbsp;';
            $str_msg_red.=$CFG_MSG[(substr($__SESSION->getValueSession('msg'), $i * 3, 3) * 1)];
        }
        $__SESSION->setValueSession('msg', 0);
        include("includes/sb_msg_bob.php");
    }
    $__SESSION->unsetSession('valAlert');
    //nombres de modulos y cabezeras
//    echo' <div class="breadcrumb-holder container-fluid">
//            <ul class="breadcrumb" style="margin-bottom: 12px;padding: 0.5rem 1rem;">
//              <li class="breadcrumb-item active h5 font-weight-bold">' . $entidad . '</li>
//            </ul>
//          </div>';
    echo '<nav aria-label="breadcrumb" >
        <ol class="breadcrumb" style="background-color:#4c4c4c;margin-bottom: .5rem !important;padding: .5rem 1rem;">
            <li class="breadcrumb-item active" style="color:#ffffff;" aria-current="page">' . $entidad . '</li>
        </ol>
      </nav>';
    /* inicia formulario de busqueda */

    $barra_busqueda_only = '';
    if (isset($a_search)) {
        $barra_busqueda = '<div class="card" style="margin-top:-6px;margin-bottom:14px;">
                        <div class="row">
                            <div class="col-12 col-md-1">';
        if (trim($a_key[0]) == '100' && !$boolNoEditable && !$boolNoNew) {
            $barra_busqueda.= "<div style='padding-top:10px;width:100%;height:100%;text-align:center;'>";
            $barra_busqueda.="<form method=\"post\" aria-labelledby = 'legend_b_nuevo' action=\"" . $_SERVER['PHP_SELF'] . "\" style=\"margin:0px;\">";
            $barra_busqueda.='<fieldset><legend id = "legend_b_nuevo" style="display:none;" >Agregar nuevo registro</legend>';
            $barra_busqueda.=genInput('hidden', array('op', 'op_00'), '1');
            $barra_busqueda.=genInput('hidden', array('nivPo', 'nivPo_00'), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            $barra_busqueda.=genInput('hidden', 'btnAdd', 'btnAdd');
            $barra_busqueda.= '<button style="min-height:40px !important;background-color: #008000;border: none;padding: 1px 1px;color:#8b4513;" type="submit" class="btn punteados"><i class="fa fa-plus-circle text-white" aria-hidden="true"></i>&nbsp;<span class="text-white" style="">Nuevo&nbsp;</span></button>';
            $barra_busqueda.="</fieldset></form></div>";
        }
        $barra_busqueda.='  </div>';
        if ($__SESSION->getValueSession('valSearch') <> "") {
            $strObjSearch = genInput('text', 'txtsearch', ($__SESSION->getValueSession('valSearch')), '', '40', '80', 'form-control', '', '', '0', 'Valor', '', '', '', '', "aria-label='texto de busqueda'");
            if ($__SESSION->getValueSession('valSearch') <> "" && isset($a_search[4][$__SESSION->getValueSession('itemSearch')]) && $a_search[4][$__SESSION->getValueSession('itemSearch')] == 'select') {
                $strObjSearch = genSelect('txtsearch', '', '', $array_search_val, $array_search_des, ($__SESSION->getValueSession('valSearch')), '', '', ' class="form-control" aria-label="opciones de busqueda"  ', '', '');
            }
        } else {
            $strObjSearch = genInput('search', 'txtsearch', '', '', '40', '80', 'form-control', '', '', '0', 'Valor', '', '', '', '', "aria-label='texto de busqueda'");
            if (isset($a_search[0]) && isset($a_search[4][$a_search[0][0]]) && $a_search[4][$a_search[0][0]] == 'select') {
                $strObjSearch = genSelect('txtsearch', '', '', $array_search_val, $array_search_des, $a_search[0][0], '', '', ' class="form-control" aria-label="opciones de busqueda" ', '', '');
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
                    genInput('checkbox', 'chkperiodo', 1, '', '', '', ' checks_forms ', '', (is_array($atmp_asrchperiodo) ? 'checked' : ''), '8', '', '', '', '0', '', ' aria-label="Habilitar periodo" style=" width: 35%; height:35%;" ') .
                    "" .
                    '           <label for="datepicker" class=" form-control-label text-80">&nbsp;&nbsp;F. Ini</label>'
                    . '<span class="input-group-text" style="display:none;" id="desc_botton_fini">Fecha inicio en formato dd/mm/YYYY</span></div>'
                    . '<div class="input-group col-12 col-md-2">' . genInput('text', isset($conf_date_b[0][0]) ? $conf_date_b[0][0] : 'txtinicio', (is_array($atmp_asrchperiodo) ? $atmp_asrchperiodo['inicio'] : date("d/m/Y")), '', '10', '10', 'form-control h5', 'readonly', '', '6', $frmname, '', '', 1, '', ' aria-label="Fecha Inicio"') . ''
                    . '   <div class="input-group-append">
                            <button type="button" class="btn punteados" style="background-color:#008000;border-width:3px;" aria-label="Fecha inicio" aria-describedby="desc_botton_fini" onclick="mensaje(\'' . (isset($conf_date_b[0][0]) ? $conf_date_b[0][0] : 'txtinicio') . '\')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button>
                        </div>  
                    </div>' .
                    '<div class="col col-md-1"><label for="text-input" class=" form-control-label text-80">F. Fin</label>' . ''
                    . '<span class="input-group-text" style="display:none;" id="desc_botton_ffin">Fecha fin en formato dd/mm/YYYY</span></div>' .
                    '<div class="input-group col-12 col-md-2">' . genInput('text', isset($conf_date_b[1][0]) ? $conf_date_b[1][0] : 'txtfin', (is_array($atmp_asrchperiodo) ? $atmp_asrchperiodo['fin'] : date("d/m/Y")), '', '10', '10', 'form-control h5', 'readonly', '', '6', $frmname, '', '', 2, '', ' aria-label="Fecha Fin"') .
                    '<div class="input-group-append">
                            <button type="button" class="btn punteados" style="background-color:#008000;border-width:3px;" aria-label="Fecha fin" aria-describedby="desc_botton_ffin" onclick="mensaje(\'' . (isset($conf_date_b[1][0]) ? $conf_date_b[1][0] : 'txtfin') . '\')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button>
                        </div>'
                    . '</div>' .
                    "";
        }


        $barra_busqueda.='  <div class="col-12 col-md-11">
                                <div class="card-body card-block" id="d_gen" style="padding: .5rem;">
                                    <form role = "search" enctype="multipart/form-data" aria-labelledby ="legend_f_b_entidad" class="form-horizontal" id="' . $frmname . '" name="' . $frmname . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                        <fieldset><legend id = "legend_f_b_entidad" style="display:none;" >Busqueda en ' . $entidad . '</legend>
                                        <div class="row form-group" style="margin-bottom: 0px;">
                                            <div class="input-group">
                                                <div class="input-group-append col-3 col-md-1">
                                                    <span tabindex="0" class=" input-group-text rounded-left color_negro" style="background-color:#d0d0d0;font-size:14px;padding-right: 6px;padding-left: 6px;">Buscar por:</span>
                                                </div>
                                                ' . genSelect('selsearch', '', '', $a_search[0], $a_search[1], ($__SESSION->getValueSession('itemSearch') <> "" ? $__SESSION->getValueSession('itemSearch') : $a_search[0]), '', '', ((isset($ajaxSerach) and $ajaxSerach == 1) ?
                                ' onChange="reloadObjSearch(\'search\',\'content_search\',\'selsearch\',2,0,\'txtsearch\');"' : '') . (' class="form-control col-9 col-md-2" aria-label="Opciones de busqueda" ')) . '
                                                <div class=" input-group col-12 col-md-3">
                                                    ' . $strObjSearch . '
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn punteados" style="background-color:#f08080;border-width:3px;" data-toggle="tooltip" title="Realizar busqueda" aria-label="Realizar busqueda"><i class="fa fa-filter text-white" style="font-size: 1rem;"></i><span class="input-group-text" style="display:none;" id="desc_botton_busqueda">Realizar busqueda</span></button>
                                                    </div>                                                        
                                                </div>      
                                                    ' . $strsrchperiodo . '
                                              ' . genInput('hidden', array('op', 'op_01'), '1') .
                genInput('hidden', 'nivPo', (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0') .
                genInput('hidden', 'btnSearch', 'btnSearch') . '
                                              
                                            </div>';
        $barra_busqueda.= '                                  </div>  
                                    </fieldset></form>     
                                 </div>
                                 </div>';

        $barra_busqueda.='</div>'
                . '</div>';
    } else {
        if (trim($a_key[0]) == '100' && !$boolNoEditable && !$boolNoNew) {
            $barra_busqueda_only.= "";
            $barra_busqueda_only.="<form method=\"post\" aria-labelledby = 'legend_b_nuevo' action=\"" . $_SERVER['PHP_SELF'] . "\" style=\"margin:0px;\">";
            $barra_busqueda.='<fieldset><legend id = "legend_b_nuevo" style="display:none;" >Agregar nuevo registro</legend>';
            $barra_busqueda_only.=genInput('hidden', array('op', 'op_02'), '1');
            $barra_busqueda_only.=genInput('hidden', array('nivPo', 'nivPo_02'), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            $barra_busqueda_only.=genInput('hidden', 'btnAdd', 'btnAdd');
            $barra_busqueda_only.= '<button style="height:100% !important;background-color: #008000;border: none;padding: 1px 1px;color:#8b4513;" type="submit" class="btn punteados"><i class="fa fa-plus-circle text-white" aria-hidden="true"></i>&nbsp;<span class="text-white" style="font-size:12px;">Nuevo registro<span></button>';
            $barra_busqueda_only.="</fieldset></form>";
        }
    }

    echo $barra_busqueda;
    //informacion de la tabla
    echo '<div class="card">
      <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12" style="overflow:auto;">';
    /* titulos de entidad */
    ////cabeceras antes de titulos de columnas
    if (isset($a_grphcol01) && sizeof($a_grphcol01) > 0) {
        echo genOTable('0', '', '', 'table', '#D6D6D6', '0', '1', '');
        echo genORen('', '', '', '', '', '');
        foreach ($a_grphcol01 as $item_a_grphcol) {
            echo genCol($item_a_grphcol[0], $item_a_grphcol[1], '', '', $item_a_grphcol[3], '', '', $item_a_grphcol[4], $item_a_grphcol[2], $item_a_grphcol[5]);
        }
        echo genCRen();
        echo genCTable();
    }
    if (isset($a_grphcol02) && sizeof($a_grphcol02) > 0) {
        echo genORen('', '', '', '', '', '');
        foreach ($a_grphcol02 as $item_a_grphcol) {
            echo genCol($item_a_grphcol[0], $item_a_grphcol[1], '', '', $item_a_grphcol[3], '', '', $item_a_grphcol[4], $item_a_grphcol[2], $item_a_grphcol[5]);
        }
        echo genCRen();
        echo genCTable();
    }

    ////fin de cabeceras
    if (!isset($boolColHeaders)) {
        $boolColHeaders = true;
    }
    if ($boolColHeaders) {
        echo '<div class="card-body" style="padding: 0rem;">';
        echo '<div class="table-responsive" id="tabla_datos_entidad">';
        echo genOTable('0', '', '', 'table table-hover  color_negro', '#FFFFFF', '0', '3', '', ((($i + 1) == $classent->NumReg) ? '' : 'margin-bottom:' . (isset($str_margin_reg) ? $str_margin_reg : "10px") . ';'));
        echo "<caption class='color_negro' style='caption-side: top;padding-top: .1rem;padding-bottom: .1rem;height:40px;'>" . $barra_busqueda_only . "<h1 class='h5' style='" . (strlen($barra_busqueda_only) > 0 ? 'position: relative;top: -27px;left:110px;' : '') . "'>Listado de: " . $entidad . "</h1></caption>";
        echo '<thead>' . genORen('', '', '', 'success', '', ' background-color:#008000; ');
        /* revisar la posibilidad de nuevo registro */
        if (isset($intNivel) || isset($a_print) || $widthEditable <> 0) {
            echo genCol_T("Acciones", '', '', '', '', '', '', ' text-white font-weight-bold', '', "padding-bottom:12px;padding-left:10px;", '', 'id="c_00"');
        }
        $countcell = 1;

        foreach ($field as $key => $afield)
            if (!in_array($afield[0], $array_noprint_ent) && $afield[2] == '1') {
                $en_sel = false;
                $descripcion = "";
                if (is_array($afield[1])) {
                    $descripcion = $afield[1][1];
                } else {
                    $descripcion = $afield[1];
                }
                if (isset($hab_bus_only) && $hab_bus_only) {
                    $campo_full = (isset($afield[13][3]) && $afield[13][3] <> "" ? $afield[13][3] . ':-:' : '') . $afield[0];
                    $type_input = '';
                    if ($afield[3] == 'text' || $afield[3] == 'label') {
                        $type_input = '<input type="text" id="i_input_txt|' . $campo_full . '" name="i_input_txt|' . $campo_full . '" value="" size="" maxlength="50" class="form-control">';
                    } else if ($afield[3] == 'select') {

                        if (isset($afield[5][0]) && count($afield[5][0]) > 10) {
                            $select2.='$(".' . $afield[0] . '").select2();';
                            $en_sel = true;
                        }
                        // echo $select2.'<pre>';die();                    
                        $type_input = genSelect('i_input_sel|' . (isset($afield[5][8]) && strlen($afield[5][8]) > 0 ? '' . $afield[5][8] . ':-:' : '') . $campo_full, '', '', $afield[5][0], $afield[5][1], '', '', '', ' class="form-control ' . $afield[0] . '"');
                    } else if ($afield[3] == 'check') {
                        $type_input = '<input type="checkbox" class="form-check-input form-control ' . $afield[0] . '" id="i_input_che|' . $campo_full . '" name="i_input_che|' . $campo_full . '">';
                    }
                    $boton_b_alter = '';
                    if (!$en_sel) {
                        $type_input.=' 
	<div class="input-group-append">
        <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="" data-original-title="Filtrar"><i class="fa fa-search-plus text-white" style="font-size: 1rem;"></i></button>
    </div>';
                    } else {
                        $boton_b_alter = ('<button type="submit" style="padding: .1rem .1rem;" class="text-left btn bg-white text-success font-weight-bold w-100" ><i class="fa fa-search-plus text-warning" style="font-size: 1rem;"></i>&nbsp;Buscar</button>');
                    }
                    $tit_b = '<ul style="margin-bottom: 0rem;" class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">'
                            . '<li class="nav-item dropdown">'
                            . '<a style="padding: .5rem .5rem;" id="op_title_' . $key . '" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle text-white">' . (isset($afield[17]) ? $afield[17] : $descripcion) . '</a>'
                            . '<ul aria-labelledby="op_title_' . $key . '" class="dropdown-menu border border-light" style="z-index:1100;padding:1px;">
                            <li><a style="padding: .1rem .1rem;font-size:.9em;" rel="nofollow" href="' . $_SERVER['PHP_SELF'] . '?order_|' . $campo_full . '=asc" class="dropdown-item text-success font-weight-bold" alt="Ordenar ascendente"> <i class="fa fa-arrow-down text-info "></i>&nbsp;A-Z</a></li>
                            <li><a style="padding: .1rem .1rem;font-size:.9em;" rel="nofollow" href="' . $_SERVER['PHP_SELF'] . '?order_|' . $campo_full . '=desc" class="dropdown-item text-success font-weight-bold" alt="Ordenar descendente"><i class="fa fa-arrow-up text-dark"></i>&nbsp;Z-A</a></li>
                            <li><a style="padding: .1rem .1rem;font-size:.9em;" rel="nofollow" href="' . $_SERVER['PHP_SELF'] . '?clear_cmp=true" class="dropdown-item text-success font-weight-bold"><i class="fa fa-check-square-o text-danger" alt="Limpiar busqueda"></i>&nbsp;Limpiar</a>' . '' . '</li>
                            <li><form enctype="multipart/form-data" id="frm_' . $afield[0] . '" name="frm_' . $afield[0] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '" aria-labelledby ="legend_fil_' . $afield[0] . '"><fieldset><legend id = "legend_fil_' . $afield[0] . '" style="display:none;" >Busqueda en la columna ' . $descripcion . ' </legend><div class="form-row"><div class="input-group col-12">' . $boton_b_alter . $type_input . '</div></div></fieldset></form></li>
                        </ul>'
                            . '</li>'
                            . '</ul>';
                } else {
                    $tit_b = (isset($afield[17]) ? $afield[17] : $descripcion);
                }
                if ($afield[3] == 'attached') {
                    echo genCol_T("<div style='width:" . $afield[8] . "px;' class='text-white " . ($CFG_STYLE[2] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1] . ' ' . ($countcell == $numcols ? $CFG_STYLE[5] : $CFG_STYLE[4])) . "'>" . $afield[1] . "</div>", '', '', '', (isset($afield[20]) && strlen($afield[20]) > 0) ? $afield[20] : '', $afield[8], '', ' ', '', '', '', 'id="c_' . $key . '"');
                } else {
                    echo genCol_T("<div style='width:" . $afield[8] . "px;' class='text-white " . ($CFG_STYLE[2] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1] . ' ' . ($countcell == $numcols ? $CFG_STYLE[5] : $CFG_STYLE[4])) . "'>" . $tit_b . "</div>", '', '', '', (isset($afield[20]) && strlen($afield[20]) > 0) ? $afield[20] : '', $afield[8], '', ' ', '', '', '', 'id="c_' . $key . '"');
                }

                $countcell++;
            }
        echo genCRen() . "</thead>" . '<tbody>';
    }
    /* terminan titulos */
    if (!isset($keyFieldsAdd))
        $keyFieldsAdd = array();
    $tmp_boolNoUpdate = $boolNoUpdate;
    $tmp_boolNoDelete = $boolNoDelete;
    $tmp_widthEditable = $widthEditable;
    $tmp_style = $CFG_LBL[30];
    $array_combos_ids = array();

////
////
    $subniveles = "";
    $subniveles_1 = "";
//    echo '<pre>';
//    print_r($classent);die();
    for ($i = 0; $i < $classent->NumReg; $i++) {/////##########################################///////////

        $boolNoUpdate = $tmp_boolNoUpdate;
        $boolNoDelete = $tmp_boolNoDelete;
        $widthEditable = $tmp_widthEditable;
        $classent->VerDatosEntidad($i, $afields);

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

            //$str_onclick="onclick=\"window.location='".$_SERVER['PHP_SELF']."?nivel=".$intNivel;

            $str_href = $_SERVER['PHP_SELF'] . "?nivel=" . $intNivel;
            foreach ($keyFields as $cont => $item) {
                $str_onclick.="&it" . $cont . "=" . $classent->$item;
                $str_href.="&it" . $cont . "=" . $classent->$item;
            }
            //echo "asasd".$str_href;die();
            $contAdd = $cont;

            foreach ($keyFieldsAdd as $cont => $item) {
                $contAdd++;
                $str_onclick.="&it" . $contAdd . "=" . $classent->$item;
                $str_href.="&it" . $contAdd . "=" . $classent->$item;
            }

            $str_onclick.="'\"";
        }



// --- COMIENZA RENGLON
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
        if (!$boolColHeaders) {
            echo genOTable('0', $twidth . 'px', '', '', '#FFFFFF', '0', '3', '', ((($i + 1) == $classent->NumReg) ? '' : 'margin-bottom:' . (isset($str_margin_reg) ? $str_margin_reg : "10px") . ';'));
        }
        if (function_exists('addRowSepar')) {
            addRowSepar($classent);
        }

        if (strlen($CFG_LBL[30]) == 0)
            $CFG_LBL[30] = $tmp_style;
        //abrir tr
        echo genORen('', '', '', 'table_hover_cab', ($i % 2) ? $strColorRow1 : $strColorRow2, '', "row_" . $i);
        if (function_exists('fnBeforeButtons')) {
            fnBeforeButtons($classent);
        }
        $ban_scope = false;

        if (!isset($intNW))
            $intNW = 40;
        if (!isset($suma_width_aux))
            $suma_width_aux = 40;
        if (isset($intNivel) || (isset($a_print) && count($a_print) > 0) || $widthEditable > 0) {
            $ban_scope = true;
            echo genOCol('', 'center', '', '', (isset($suma_width_aux) ? ($suma_width_aux + $widthEditable) : $widthEditable) . 'px', '', ($CFG_STYLE[7] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]), '', '', 'headers="c_00"');
            /* referencias de IMPRESION Y LEYENDAS DE NIVEL' */
            echo "<div  style=\"width:" . ($suma_width_aux + $widthEditable + 30) . "px; margin:0px;\">";
            if (sizeof($a_print) > 0) {
                $str_print = "";
                foreach ($a_print as $cont_item_a => $item_a) {
                    $str_explodevalues = "";
                    foreach ($item_a[2] as $cont_e => $item_e) {
                        if ($cont_e > 0)
                            $str_explodevalues.=':';
                        $str_explodevalues = $classent->$item_e;
                    }
                    $str_print.="<a id='menu_sub_i_" . $cont_item_a . "' style='' class='dropdown-item punteados'  href=" . ((isset($item_a[4]) && $item_a[4] == 1) ? "" : "\"javascript:abrir(\'");
                    $str_print.=$item_a[0];
                    $str_print.="rowid=" . base64_encode(addslashes($str_explodevalues)) . "&";
                    foreach ($item_a[2] as $cont_e => $item_e) {
                        if ($cont_e > 0)
                            $str_print.='&';
                        $str_print.=$item_e . '=' . $classent->$item_e;
                    }
                    $str_print.=((isset($item_a[4]) && $item_a[4] == 1) ? ">" : "\')" . "\">") . "<i style='color:black;' class='" . (isset($item_a[5]) && strlen($item_a[5]) > 0 ? $item_a[5] : 'fa fa-print') . "'></i>&nbsp;" . (isset($item_a[4]) && strlen($item_a[4]) > 0 ? $item_a[4] : 'Imprimir') . "</a>";
                }
            }
//            print($str_print);
//            die();
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
                        $icon_niveles.="<a style='display: inline-block;' class='dropdown-item punteados' id='menu_sub_n_" . $i . "' href='" . $str_href . $trs_ref_add . "'><span><i id='sub_icon_" . $i . "_" . $nx . "' style='" . $var_n_e . "' class='" . (isset($$stridniv) ? $$stridniv : "") . "'></i>&nbsp;&nbsp;" . ($var_n) . "</span></a>";
                    }
                }
                echo '<div class="dropdown">
                        <button id="submen35' . $i . '" style="margin:0px;float:left;" class="dropdown-toggle punteados" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Dezplegar acciones del registro">
                            <i class="fa fa-bars" id="barras_menu_sub_' . $i . '" ></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="submen35' . $i . '">';
                echo $icon_niveles . $str_print;
                echo '      <a class="dropdown-item punteados" style="border-top: 1px solid #A6A6A6;" href="#"><i class="fa fa-window-close" style="color:red;"></i>&nbsp;&nbsp;Cerrar men&uacute;</a>';
                echo '  </div>
                      </div>	';
            }
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
                if ($strKeysRow <> "")
                    $strKeysRow.="@:";
                $strKeysRow.=$item . "=" . $classent->$item;
            }
        }

        //---- COMIENZA LA COLUMNA BOTONES DE EDICION
//---Empiezan botones de edicion
        if ($b_printline == 1 && !$boolNoUpdate && $widthEditable > 0) {
            echo"<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\" style='margin:0px; float:left;'> \n";
            foreach ($keyFields as $cont => $item) {
                echo genInput('hidden', array($item, $item . "_u_" . $i), $classent->$item);
            }
            echo genInput('hidden', array('op', 'op_u_' . $i), '1');
            echo genInput('hidden', array('nivPo', 'nivPo_u_' . $i), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            echo genInput('hidden', array('btnUpd', 'btnUpd_u_' . $i), 'btnUpd', '', '', '', 'btn') . "<button class='punteados' type='submit' aria-label='Editar registro' title='Editar registro' data-toggle='tooltip' data-placement='right' ><i class='fa fa-pencil-square-o' id='botones_accion_abc_" . $i . "'></i></button>";
//						 "<input type=\"submit\" value=\"\" class=\"botones2 iconoeditar icon-adjust\" border='0'> \n"; 
            echo $str_closeform;
        }
        if (trim($a_key[2]) == '100' && !$boolNoEditable && !$boolNoDelete) {
            echo"<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\" style='margin:0px; float:left;'> \n";
            $strHiden = "";
            foreach ($keyFields as $cont => $item)
                $strHiden.=genInput('hidden', array($item, $item . "_d_" . $i), $classent->$item);
            echo $strHiden .
            genInput('hidden', array('op', 'op_d_' . $i), '1');
            echo genInput('hidden', array('nivPo', 'nivPo_d_' . $i), (strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0');
            echo genInput('hidden', array('btnDel', 'btnDel_d_' . $i), 'btnDel', '', '', '', 'btn') .
            "<button type=\"submit\" value=\"\" title='Borrar registro' aria-label='Borrar registro' data-toggle='tooltip' data-placement='right' class='punteados'   onclick=\"show_confirm('MODULO DE " . strtoupper($entidad) . " : < mensaje de confirmacion >','Esta seguro que desea borrar el registro" . addslashes($strIdentifyRow) . "?');return document.obj_retVal;\"><i class='fa fa-eraser' id='botones_accion_abc_d_" . $i . "'></i></button>";
            //"<input type=\"submit\" value=\"\" class=\"botones2 iconotrash\" border='0' onclick=\"show_confirm('MODULO DE ". strtoupper($entidad) ." : < mensaje de confirmación >','Esta seguro que desea borrar el registro".addslashes($strIdentifyRow)."?');return document.obj_retVal;\"> \n";
            echo $str_closeform;
        }
        echo "</div>";

        /* fin de col de botones */
        echo genCCol();
//--   termina columna de botones de edicion
        //    echo 'ENTRAR|';

        foreach ($field as $count_fields => $afield) {
            if (!in_array($afield[0], $array_noprint_ent) && $afield[2] == '1') {
                $style = $CFG_LBL[30];
                if (isset($boolfnSetRowColorField) && $boolfnSetRowColorField && function_exists('fnSetRowColorField')) {
                    $boolSetColor = false;
                    fnSetRowColorField($classent, $afield[0]);
                }
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
                                                "color:black;\"  class='punteados' role='button' aria-label='Mostrar ventana " . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "' href=\"#\" onClick=\"toolTipAdd2('<img src=img/arrow_green.gif border=0 > cargando datos ...',this,'" .
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
                                                                $CFG_LBL[41] : $CFG_LBL[30])), '', '', " id='" . $afield[0] . "_row_" . $i . "' ", " headers='c_" . $count_fields . "'");
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
                                                            $CFG_LBL[41] : $CFG_LBL[30])), '', '', '', " headers='c_" . $count_fields . "'");
                        }

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
                                                        $CFG_LBL[41] : $CFG_LBL[30])), '', '', '', " headers='c_" . $count_fields . "'");

                        break;
                    case 'check':
                        echo genCol(genInput('checkbox', array($afield[0] . "_t_" . $i, $afield[0] . "_t_" . $i), '', '', '', '', '', 'DISABLED', ($classent->$afield[0] == 1 ? 'checked' : ''), '5', '', '', '', '', '', ' aria-label="Campo ' . $descripcion . '"')
                                , '', '', '', '', $afield[8], '', ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]), '', '', '', " headers='c_" . $count_fields . "'");
                        break;
                    case 'attached':
                        $classconsul_adj = new Entidad(array('cve_tipo_archivo', 'desc_tipo_archivo'), array(0, ''));
                        $classconsul_adj->ListaEntidades(array('cve_tipo_archivo'), 'tipo_archivo ', "", " cve_tipo_archivo,desc_tipo_archivo ", '');
                        $array_tipo_files = array();
                        for ($i_aux = 0; $i_aux < $classconsul_adj->NumReg; $i_aux++) {
                            $classconsul_adj->VerDatosEntidad($i_aux, array('cve_tipo_archivo', 'desc_tipo_archivo'));
                            $array_tipo_files[$classconsul_adj->cve_tipo_archivo] = $classconsul_adj->desc_tipo_archivo;
                        }
                        $var_pes="";
                        foreach ($array_tipo_files as $key_adj => $value_adj) {
                            $ar_capos_ad=array("unico_".$key_adj,"file_name_".$key_adj,"internal_name_".$key_adj,"path_".$key_adj);
                            $string_adj=  implode(",", $ar_capos_ad);
                            $classconsul_adj = new Entidad($ar_capos_ad, array('','','',''));
                            $classconsul_adj->ListaEntidades(array('a.unico'), ' adjuntos a
JOIN tipo_archivo t ON a.cve_tipo_archivo=t.cve_tipo_archivo ', " where a.id_consentimiento=".$classent->$keyAdjuntos[0]." AND a.status=1 AND a.cve_tipo_archivo=".$key_adj,  "a.unico as unico_".$key_adj.",a.file_name as file_name_".$key_adj.",a.internal_name AS internal_name_".$key_adj.",a.path AS path_".$key_adj, '');
                            $array_tipo_files = array();
                            if ($classconsul_adj->NumReg > 0) {
                                $classconsul_adj->VerDatosEntidad(0, $ar_capos_ad);
                                $unico_adj="unico_".$key_adj;
                                $parte_validacion='<a style="color:black;" id="i_validacion_'.$key_adj.'" class="punteados" role="button" aria-label="Validar registro" href="#" 
onclick="toolTipAdd2(\'<img src=img/arrow_green.gif border=0 > cargando datos ...\',this,\''.$value_adj.'\',\'toolTipBox\',\'lst_validacion\',
					 \'i_validacion_'.$key_adj.'\',\'cve_persona='.$classent->cve_persona.'@:cve_tipo_archivo='.$key_adj.'@:unico='.$classconsul_adj->$unico_adj.'\',1,2); return true;" alt="Desactivar modulo">
	<img src="img/editfld.gif" border="0" alt="Desactivar modulo">
</a>';
//                            echo '<pre>';
//                            print_r($classconsul_adj);die();                                
                                $var_pes.=$value_adj.":&nbsp;<a href='files/getfile_r_adj.php?unico=". $classconsul_adj->$ar_capos_ad[0]. "&file_get=adj_unico&type_adj=".$key_adj."&imagen_file=" . "" . "' target='_blank'>" . $classconsul_adj->$ar_capos_ad[2]. "</a><br />";
                            }
                            $var_pes.="";
                        }
                        echo genCol($var_pes, '', '', '', '', '', '', '', '', '', '', " headers='c_" . $count_fields . "'");
                        break;
                    case 'imagen_file':
                        $nom_field = $afield[0];
                        $ar_adjunto = explode("_", $afield[0]);
                        $string_concat = "";
                        if (count($ar_adjunto) > 1) {
                            $string_concat = "_" . $ar_adjunto[1];
                        }
                        $str_print_foto = 'id=' . $id_prin . '&idval=' . $classent->$id_prin . '&tabla=' . $tablas_c;
                        $path = 'path' . $string_concat;
                        $file = 'file' . $string_concat;
                        $internal_name = 'internal_name' . $string_concat;

                        if (isset($file_get) and strlen(trim($file_get)) > 0 and ( $classent->$afield[0] <> "")) {
                            $strlnk_getfile = "<a href='files/getfile_r.php?" . $strGetValues . "&file_get=" . $file_get . "&imagen_file=" . $string_concat . "' target='_blank'>" . $classent->$internal_name . "</a>";
                        } else {
                            $strlnk_getfile = ($classent->$afield[0] <> "" ? $classent->$afield[0] : '');
                        }

                        echo genCol($strlnk_getfile
                                , '', '', '', '', $afield[8], '', ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]));

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
                                                        $CFG_LBL[41] : $CFG_LBL[30])), '', '', '', " headers='c_" . $count_fields . "'");
                        break;
                    case 'join':

                        break;
                    case 'f_archivo': echo genCol($classent->$afield[0] . '<a target="_blank" href="' . $classent->ruta . $classent->$afield[0] . '"><img style="4em;height:3em;" src="' . $classent->ruta . $classent->$afield[0] . '" alt="" class="img-thumbnail"></a>', '', '', '', '', '', '', '', '', '', '', " headers='c_" . $count_fields . "'");
                        break;
                    default:
                        if (isset($afield[18]) && $afield[18] == 1) {
                            $str_implodevalues = "";
                            echo genOCol('', '', '', '', $afield[8], '', $CFG_LBL[30], '', '', " headers='c_" . $count_fields . "'");
                            foreach ($afield[19][0] as $count_int_aafield => $int_aafield) {
                                if ($count_int_aafield > 0)
                                    $str_implodevalues.=$afield[19][1];
                                $str_implodevalues.=$classent->$field[$int_aafield][0];
                            }
                            echo $str_implodevalues;
                            echo genCCol();
                        } else {

                            //$strFieldValue = str_replace("\n", "<br/>", ($afield[6] == 'date' ? implode('/', array_reverse(explode('-', $classent->$afield[0]))) : $classent->$afield[0]));
                            $strFieldValue = $classent->$afield[0];
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
                                            "color:black;\" class='punteados' role='button' aria-label='Mostrar ventana " . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "' href=\"#\" onClick=\"toolTipAdd2('<img src=img/arrow_green.gif border=0 > cargando datos ...',this,'" .
                                            $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] .
                                            "','toolTipBox','" . $a_popContent_e3[array_search($afield[0], $a_pop_e3)] .
                                            "','" . $a_popObVal_e3[array_search($afield[0], $a_pop_e3)] . $i . "','" . $strKeysRow . "'," . $a_popPos_e3[array_search($afield[0], $a_pop_e3)] . "," . $__SESSION->getValueSession('mod') . "); return true;\"  alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\"><img src=\"img/editfld.gif\" border='0' " .
                                            " alt=\"" . $a_popTitle_e3[array_search($afield[0], $a_pop_e3)] . "\" ></a>" : ""), '', '', '', (isset($afield[21]) && strlen($afield[21]) > 0) ?
                                            ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetColor : $afield[21]) :
                                            (isset($a_alertas) and ( in_array($afield[0], $a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1]) ? $a_bg_alertas[$afield[0]][2] : '')
                                    , $afield[8], '', (isset($afield[22]) && strlen($afield[22]) > 0) ?
                                            ((isset($a_filed_bg_color) and sizeof($a_filed_bg_color) > 0 and in_array($afield[0], $a_filed_bg_color) and $boolSetColor) ? $strSetStyle : $afield[22]) : (($afield[6] == 'money' or $afield[6] == 'int') ?
                                                    ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]) : (($afield[6] == 'date' or $afield[6] == 'email') ?
                                                            ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]) : ($CFG_STYLE[6] . ' ' . $CFG_FSIZE[0] . ' ' . $CFG_FCOLOR[1]))), '', '', " id='" . $afield[0] . $i . "'", " headers='c_" . $count_fields . "'");
                        }
                        break;
                }
            }
        }
        if (function_exists('fnAfterButtons')) {
            fnAfterButtons($classent);
        }
        echo genCRen();
       //        echo $i.'REG|'.$classent->NumReg;
    }

    echo '</tbody>' . genCTable() . "</div></div>";
    echo '          </div>'
    . '          </div>'
    . '       </div>'
    . '    </section>'
    . '</div>';
    //paginacion
    $barra_registros = '       <div class="card">
                                <div class="card-body card-block" id="d_gen_b" style="padding-top: .5rem;padding-bottom: 0rem;">
                                    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                        <div class="row form-group" style="margin-bottom: 0px;">
                                    
                                                <div class="col-12 col-md-2">
                                                    <div class="form-group" style="margin-bottom: 0rem;">
                                                        <div class="input-group">
							     ' . genInput('text', 'intpag' . $pag_id, '', '', '5', '5', 'form-control', '', '', '0', 'Valor', '', '', '', '', 'style="width:20px;" aria-label="N&uacute;mero de p&aacute;gina"') . '
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

//$horafin = date("H:i:s");
//$_SESSION['tiempos'][]="35:".RestarHoras35($horaini, $horafin);
//echo '<pre>';
//print_r($_SESSION['tiempos']);
//echo '</pre>';


function RestarHoras35($horaini, $horafin) {
    $horai = substr($horaini, 0, 2);
    $mini = substr($horaini, 3, 2);
    $segi = substr($horaini, 6, 2);

    $horaf = substr($horafin, 0, 2);
    $minf = substr($horafin, 3, 2);
    $segf = substr($horafin, 6, 2);

    $ini = ((($horai * 60) * 60) + ($mini * 60) + $segi);
    $fin = ((($horaf * 60) * 60) + ($minf * 60) + $segf);

    $dif = $fin - $ini;

    $difh = floor($dif / 3600);
    $difm = floor(($dif - ($difh * 3600)) / 60);
    $difs = $dif - ($difm * 60) - ($difh * 3600);
    return date("H-i-s", mktime($difh, $difm, $difs));
}

function armar_arreglo($tem1, $temp2, $tem3, $valor) {
    $values = array();
    $desc = array();
    $con = 0;
    for ($index = 0; $index < count($tem3); $index++) {
        if ($tem3[$index] == $valor) {
            $values[$con] = $tem1[$index];
            $desc[$con] = $temp2[$index];
            $con++;
        }
    }
    return array($values, $desc);
}

if ( (isset($ar_date_t) && count($ar_date_t)>0) || ( isset($select2) && strlen($select2) > 0)) {
    echo "<script language='JavaScript'>";
    echo "jQuery(document).ready(function (){";
    echo '' . $select2;
    for ($index1 = 0; $index1 < count($ar_date_t); $index1++) {
        echo "var " . $ar_date_t[$index1][0] . " = jQuery('#" . $ar_date_t[$index1][0] . "').datetimepicker({" .
        $ar_date_t[$index1][1] . "
        });
        " . $ar_date_t[$index1][2] . "       
        ";
    }
    if (count($ar_date_t) > 0) {
        //  echo 'dayTripper();';
    }

    echo " });"
    . "function mensaje(div_s){" . 'jQuery("#"+div_s).datetimepicker("show");dayTripper(div_s);' . "}</script>";
}
?>

<script>
//document.onkeydown = TeclaPulsada
    function reloadObjSearch(target, liga, obj, numpar, numAdd, objname) {
        cadena = '';
        if (varval = document.getElementById(obj).value) {
            cadena = 'objname=' + objname + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd;
            selftarget = 'div_' + target;
            selflink = liga + '.php';
            cargar_general(selftarget, selflink, cadena);

            //contenedor = document.getElementById("frmsearch");
            //myPara.removeChild(myform);
            //objTarg = document.getElementById("txtsearch");
            //contenedor.appendChild(objTarg);
        }
    }
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