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
	
    $classent = new Entidad(array('count_r'), array('0'));
    $classent->ListaEntidades(array(), "", "", "", "no", "", $strDistintic);
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
//  print_r($classent);die();
    //paginacion
    /* inicia paginacion */
    $primeros = "";
    $segundos = "";
    if ($intpag_s[$pag_id] > 1) {
        $primeros = "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=1" . "'\" ><i class='fa fa-fast-backward'></i></a></li>";
        $primeros.= "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag_s[$pag_id] - 1) . "'\" ><i class='fa fa-backward'></i></a></li>";
    } else {
        $primeros = "<li class='page-item disabled'><a href='#' class='page-link'><i class='fa fa-fast-backward'></i></li>";
        $primeros.= "<li class='page-item disabled'><a href='#' class='page-link'><i class='fa fa-backward'></i></li>";
    }
    if ($intpag_s[$pag_id] < $decdiv) {
        $segundos = "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag_s[$pag_id] + 1) . "'\"><i class='fa fa-forward'></i></a></li>";
        $segundos.= "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . $decdiv . "'\" ><i class='fa fa-fast-forward'></i></a></li>";
    } else {
        $segundos = "<li class='page-item'><a href='#' class='page-link'><i class='fa fa-forward'></i></a></li>";
        $segundos.= "<li class='page-item'><a href='#' class='page-link'><i class='fa fa-fast-forward'></i></a></li>";
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
        if ($intpag_s[$pag_id] == $i) {
            $paginas.="<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
        } else {
            $paginas.="<li class='page-item'><a class='page-link' href='#' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . $i . "'\">" . $i . "</a></li>";
        }
    }
    $paginacion = '<nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm justify-content-left">
			' . $primeros . $paginas . $segundos . '
                        </ul>
                   </nav>  ';

    $str_closeform = "";
    $b_printline = 1;
    $str_closeform = "</form>";
    /* < --- Inicia mensaje de error --- > */
	
if (isset($_SESSION['SYS_SECCAPA']['msg']) && strlen($_SESSION['SYS_SECCAPA']['msg'])>1){
        $str_msg_red = "";
        $i_intstyle = 19;
        $i_intcolor = 6;
        for ($i=0; $i<(strlen($_SESSION['SYS_SECCAPA']['msg'])/3);$i++){
            if (strlen($str_msg_red) > 0)
                $str_msg_red.='&nbsp;&nbsp;';
            $str_msg_red.=$CFG_MSG[(substr($_SESSION['SYS_SECCAPA']['msg'],$i*3,3)*1)];
        }
        $__SESSION->setValueSession('msg', 0);
        include("includes/sb_msg_bob.php");
    }
	
	

/* < --- Termina mensaje de error --- >*/


$twidth = ($suma_width + $widthEditable > 600 ? ($suma_width + $widthEditable) : 600);
    /* termina linea de titulo de cabecera */
    /* inicia  renglon de master */
    /* inicia formulario de busqueda */
    $barra_busqueda = "";
    if (isset($a_search)) {
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
        $barra_busqueda = '       <div class="card">
                                <div class="card-body card-block" id="d_gen">
                                    <form enctype="multipart/form-data" class="form-horizontal" id="' . $frmname . '" name="' . $frmname . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
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
                                    </form>                            
                                </div>
                            </div>';
    }
    $niveles_s = array();
    $lis = "";


foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
//        echo $item."|".$strSelf."|".$cont; die();



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
                $icono = '<i class="fa fa-home text-info" style="font-size:1.3em;"></i>&nbsp;';
            } else {
                $icono = '';
            }
            $lis.= '&nbsp;<a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' class="tip-bottom text-secondary" data-toggle="tooltip" title="' . $niveles_a[$index] . '" style="font-size:17px;text-decoration: none;">&nbsp;' . $icono . $niveles_s[$index] . '</a>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i>';
        }
    }
    $lis.= '&nbsp;<a href="#" class="tip-bottom text-dark" style="font-size:14px;font-weight: bold;text-decoration: none;">' . $entidad . $lbl_tit_mov . '</a>';
    echo' <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb" style="margin-bottom: 12px;padding: 0.5rem 1rem;">
              <li class="breadcrumb-item active h5 font-weight-bold">' . $str_a_onclick . "" . $lis . '</li>
            </ul>
          </div>
          ';
    echo $barra_busqueda;

    echo '<div class="card">
      <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12" style="overflow:auto;">';

echo genORen();
echo genOCol('','','','','100%');
echo genOTable('0','100%','','','#FFFFF','0','0');
echo genORen();

echo genCol("",'','','','#FFFFFF','20','',$CFG_LBL[31]);
//echo genCol($str_a_onclick,'','','',$CFG_BGC[0],'20','20',$CFG_LBL[31]);
echo genCol("<span style='background-color: #ffffff;font-size: 28px;font-weight: 650;'>&nbsp;HISTORIA CL&Iacute;NICA M&Eacute;DICO-PSIQUI&Aacute;TRICA&nbsp;</span>" .$lbl_tit_mov,'','','','#FFFFFF',250,'',$CFG_LBL[8],'','valign="bottom" bgcolor="#FFFFF"');
//echo genCol("<img border='0' src='img/latder.jpg'>",'','','',$CFG_BGC[1],'10','',$CFG_LBL[31]);
//echo genCol("&nbsp;".(function_exists('fnSetRowColors')?fnSetRowColors():''),'','','',$CFG_BGC[1],'100%','',$CFG_LBL[31],'','background="img/bg04.jpg"');
//echo genCol("<img border='0' src='img/supder.jpg'>",'','','',$CFG_BGC[1],'20','',$CFG_LBL[31]);
echo genCRen();
echo genCTable().genCCol().genCRen();
/*termina linea de titulo de cabecera*/
/*inicia  renglon de master*/


		foreach ($_SESSION['SYS_SECCAPA']['niveles'] as $cont => $item){
			//echo $item."|".$strSelf."|".$cont; //die();
			if ($cont >0 ){ 
			//echo $item."|".$strSelf."|".$cont; //die();
				/*primer renglon en blanco*/
					$strfields_prin2="";//cambiar los arreglos de session 
					
//	echo $cont."<pre>";	
//	print_r($_SESSION['SYS_SECCAPA']['mdTFields']);
//	echo "</pre>";	
					foreach ($_SESSION['SYS_SECCAPA']['mdFields'][$cont] as $cont2 => $afield){
						if (strlen($strfields_prin2)>0)
							$strfields_prin2.=", ";
						$strfields_prin2.=$afield;
						if ($_SESSION['SYS_SECCAPA']['mdTFields'][$cont][$cont2]=='num'){
							$avalues_prin2[]=0;
						}else{
							$avalues_prin2[]='';
						}
						
					}
					$strWherePrin2="";
					foreach ($_SESSION['SYS_SECCAPA']['mdKeyFields'][$cont] as $cont2 => $afield){
						if (strlen($strWherePrin2)>0)
							$strWherePrin2.=" and ";
						if ($_SESSION['SYS_SECCAPA']['mdKeyTFields'][$cont][$cont2]=='num'){
							$strWherePrin2.=$afield . "=". $_SESSION['SYS_SECCAPA']['mdValFields'][$cont][$cont2];
						}else{
							$strWherePrin2.=$afield . "='". $_SESSION['SYS_SECCAPA']['mdValFields'][$cont][$cont2]."'";
						}
					}
					$strWherePrin2='Where '. $strWherePrin2;
					$classconsul = new Entidad($_SESSION['SYS_SECCAPA']['mdFields'][$cont],$avalues_prin2);
					$classconsul->ListaEntidades(array(),$_SESSION['SYS_SECCAPA']['mdTable'][$cont],$strWherePrin2,$strfields_prin2,"no");
					$classconsul->VerDatosEntidad(0,$_SESSION['SYS_SECCAPA']['mdFields'][$cont]);
			
					
					$strvalcol=(str_repeat('&nbsp;',($cont*2))).'<i class="fa fa-location-arrow" style="font-size: 1.5rem;color: darkgreen;" aria-hidden="true"></i>'.(isset($a_mdLabel)?str_repeat('&nbsp;',2).$a_mdLabel[$cont-1].'&nbsp;':'')
																 
	
								."".str_repeat('&nbsp;',($cont*2)).str_repeat('&nbsp;',4);//
					foreach ($_SESSION['SYS_SECCAPA']['mdFields'][$cont] as $cont2 => $afield){
						if ($cont2>0)
							$strvalcol.= " * ";//<br>
							
							$str_value_field=($_SESSION['SYS_SECCAPA']['mdTFields'][$cont][$cont2]=='money')?number_format((($classconsul->$afield)*1), 0):$classconsul->$afield;
							if (strlen($classconsul->$afield)>16){$strvalcol.="<span style='text-align:left;width:300;background-color:#F8F9D9; border:1px #A9C472 solid;'>".$str_value_field."</span>";}
						else{$strvalcol.="<span ".(in_array($afield,$keyFields)?("class=\"" . $CFG_LBL[28] . "\" style=\"width:120;border:1px #A9C472 solid; background-color:".$CFG_BGC[21].";\""):"style=\"width:120;border:1px #A9C472 solid; background-color:#F8F9D9;\"")."'>".$str_value_field."</span>";}
					}
					
					
					
					if (isset($astr_MDIcon) and (sizeof($astr_MDIcon)>0))$strvalcol.=$astr_MDIcon[$cont];
				
					echo genORen();
					echo genOCol('','','','',$suma_width+$widthEditable);
					echo genOTable('0','100%','','',$CFG_BGC[6],'1','0');
	
	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0','100%','','',"FFFFFF",'0','0');
	echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
	echo genORen();
	echo genCol(genOTable('0','100%','','table table-hover bg-success',"FFFFFF",'0','1','left').genORen()
			.genOCol('','center','',"FFFFFF",'40','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='#dee2e6'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			
		 genInput('hidden','op','1').
		 genInput('hidden','nivPo',(isset($_SESSION['SYS_SECCAPA']['niv']) && strlen($_SESSION['SYS_SECCAPA']['niv'])>0)?$_SESSION['SYS_SECCAPA']['niv']:'0').
		  genInput('hidden','btnAddDetalle2','btnAddDetalle2').
		genCol($strvalcol."<input id = 'editar' type=\"image\" alt=\"Actualizar Registro\"  src=\"img/editar.gif\" onmouseover=\"this.style.backgroundColor='#dee2e6'; \" 
		onmouseout=\"this.style.backgroundColor='';\" border='0'> \n",'2','','100%',$CFG_BGC[11],'','100%',$CFG_LBL[25]).
		genCCol().
		 genCRen().genCTable(),'','','',"FFFFFF",'','',$CFG_LBL[14]);
	echo genCRen();
	echo "</form>";
	
	echo genCTable().genCCol().genCRen();
	
	

					echo genCTable().genCCol().genCRen(); 
					//
				/*termina primer renglon en blanco*/
			}
			if ($item==$strSelf)
				break;
		}

/*termina renglon master*/

/* echo "<pre>";
print_r($_SERVER);
die(); */

if (true){
	/* 
	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0','100%','','',"FFFFFF",'0','0');
	echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
	echo genORen();
	echo genCol(genOTable('0','100%','','table table-hover bg-success',"FFFFFF",'0','1','left').genORen()
			.genOCol('','center','',"FFFFFF",'40','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='#dee2e6'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			
		 genInput('hidden','op','1').
		 genInput('hidden','nivPo',(isset($_SESSION['SYS_SECCAPA']['niv']) && strlen($_SESSION['SYS_SECCAPA']['niv'])>0)?$_SESSION['SYS_SECCAPA']['niv']:'0').
		  genInput('hidden','btnAddDetalle2','btnAddDetalle2').
		 "<input type=\"image\" alt=\"Actualizar Registro\"  src=\"img/editar.gif\" border='0'> \n".
 
		 genCCol().
		 genCRen().genCTable(),'','','',"FFFFFF",'','',$CFG_LBL[14]);
	echo genCRen();
	echo "</form>";
	echo genCTable().genCCol().genCRen(); */
}

	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0',$suma_width+$widthEditable,'','table table-hover bg-success',$CFG_BGC[10],'2','1');
	/*titulos de entidad*/
	echo genORen('','','','',$CFG_BGC[1]);
//	if ($widthEditable<>0)
//		echo genCol('','','','','',$widthEditable,'',$CFG_LBL[34]);
//	foreach ($field as $afield)
//		if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
//			echo genCol(isset($afield[16])?$afield[16]:$afield[1],'','','','',$afield[8],'',$CFG_LBL[28]);
//		if (isset($intNivel) || (isset($a_print) && count($a_print)>0))
//			echo genCol('','','','','',(isset($suma_width_aux)?$suma_width_aux:0),'',$CFG_LBL[34],'','background="img/bg02.jpg"');
//		if ($widthEditable<>0)
//			echo genCol('','','','','',$widthEditable,'',$CFG_LBL[34],'','background="img/bg02.jpg"');
		foreach ($field as $afield)
			if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
				echo genCol(isset($afield[17])?$afield[17]:$afield[1],'','','','#208637',
								$afield[8],'','text-white cell_titulo fsize07em fontblack border_tlr','',(isset($afield[29]) && strlen($afield[29])>0)?$afield[29]:'style="
    text-align: center;
    font-size: 25px;
    font-weight: 600;
"');
		echo genCRen();	
	/*terminan titulos*/
	
$tmp_boolNoUpdate=$boolNoUpdate;
$tmp_boolNoDelete=$boolNoDelete;
$tmp_widthEditable=$widthEditable;
	$tmp_style=$CFG_LBL[30];
	
	/*  echo "<pre>";
	print_r($classent);  */
	
for ($i=0; $i<$classent->NumReg; $i++) {
	$boolNoUpdate=$tmp_boolNoUpdate;
	$boolNoDelete=$tmp_boolNoDelete;
	$widthEditable=$tmp_widthEditable;
	$classent->VerDatosEntidad($i,$afields,false);
	$boolSetColor=false;
	$strSetColor="";
	$strSetStyle="";
	$CFG_LBL[30]=$tmp_style;
	$strColorRow1=$CFG_BGC[27];
	$strColorRow2=$CFG_BGC[6];
	if (function_exists('fnSetRowColor')){
		fnSetRowColor($classent);
	}
	
//	if (isset($a_boolNoDelete0)){
//		foreach ($a_boolNoDelete0 as $cntbnd => $itembnd){
//			if ($itembnd!=$classent->$a_boolNoDelete1[$cntbnd]){
//				$boolNoDelete=true;
//				if ($widthEditable>20)
//					$widthEditable-=20;
//				break;
//			}	
//		}
//	}
//	if (isset($a_boolNoUpdate0)){
//		foreach ($a_boolNoUpdate0 as $cntbnd => $itembnd){
//			if ($itembnd!=$classent->$a_boolNoUpdate1[$cntbnd]){
//				$boolNoUpdate=true;
//				if ($widthEditable>20)
//					$widthEditable-=20;
//				break;
//			}	
//		}
//	}
// --- COMIENZA RENGLON
	if ($boolSetColor){
		if (isset($a_filed_bg_color) and sizeof($a_filed_bg_color)>0){}else{
			$CFG_LBL[30]=$strSetStyle;
			$strColorRow1=$strSetColor;
			$strColorRow2=$strSetColor;
		}
	}else{
		$CFG_LBL[30]=$tmp_style;
		$strColorRow1=$CFG_BGC[27];
		$strColorRow2=$CFG_BGC[6];
	}//		echo "<pre>";
//		print_r($classent);
//		echo "</pre>";   
	$str_onclick="";
	$str_href="";
//	if (isset($intNivel)){
//	
//		//$str_onclick="onclick=\"window.location='".$_SERVER['PHP_SELF']."?nivel=".$intNivel;
//
//		$str_href=$_SERVER['PHP_SELF']."?nivel=".$intNivel;
//		foreach ($keyFields as $cont => $item){
//				$str_onclick.="&it".$cont."=".$classent->$item;
//				$str_href.="&it".$cont."=".$classent->$item;
//		}
//		$str_onclick.="'\"";
//	}



//	$str_onclick="";
//	$str_href="";
//	if (isset($intNivel)){
//		$str_onclick="onclick=\"window.location='".$_SERVER['PHP_SELF']."?nivel=".$intNivel;
//		$str_href=$_SERVER['PHP_SELF']."?nivel=".$intNivel;
//		foreach ($keyFields as $cont => $item){
//				$str_onclick.="&it".$cont."=".$classent->$item;
//				$str_href.="&it".$cont."=".$classent->$item;
//		}
//		$str_onclick.="'\"";
//	}
	
	
///* referencias de impresion DOCUMENT_ROOT' */
//	$str_print="";
//	if (isset($rpitem)){
//		foreach ($a_print as $item_a){
//			$str_print.="&nbsp;&nbsp;<a style=\"font-weight: normal;\" href=\"javascript:abrir('";
//			$str_print.=$item_a[0];
//			foreach ($item_a[2] as $cont_e => $item_e){
//				if ($cont_e>0) $str_print.='&';
//					$str_print.=$item_e.'='.$classent->$item_e;
//			}
//			$str_print.="')\">".$item_a[1]." </a>";
//		}
//		
//	}
///* termina referencias de impresion*/
	
// --- COMIENZA RENGLON
//	if ($boolSetColor){
//		$strColorRow1=$strSetColor;
//		$strColorRow2=$strSetColor;
//	}else{
//		$strColorRow1=$CFG_BGC[27];
//		$strColorRow2=$CFG_BGC[6];
//	}
	if (function_exists('addRowSepar')){
		addRowSepar($classent);
	}
	
	echo genORen('','','','',($i%2)?$strColorRow1:$strColorRow2,"id=\"row_".$i."\" onClick=\"A(this,
					".$i.",'".$CFG_BGC[7]."','".$strColorRow2."','".$strColorRow1."','".$CFG_STRRGB[1]."');\" onMouseOver=\"B(this,
					".$i.",'".$CFG_BGC[7]."','".$CFG_BGC[25]."','".$CFG_STRRGB[1]."'); "."\" onMouseOut=\"C(this,
					".$i.",'".$CFG_BGC[7]."','".$strColorRow2."','".$strColorRow1."','".$CFG_STRRGB[1]."');\"");
	
//	echo genORen('','','','',$CFG_BGC[9]," onMouseOver=\"this.style.backgroundColor='".
//			 $CFG_BGC[4]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
			 
			 
			 
/*col de botones*/
		
//	if ($b_printline==1  && !$boolNoEditable && $widthEditable>0){
//		echo genOCol('','center','','','','',$CFG_LBL[35]);
//			echo genOTable('0',$widthEditable,'','',$CFG_BGC[6],'0','1','center').genORen();
//			
//			
//			if (trim($a_key[1])=='100' && !$boolNoEditable  && !$boolNoUpdate){
//				echo"<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
//				echo genOCol('','center','',$CFG_BGC[1],'50','',$CFG_LBL[14]);
//				foreach ($keyFields as $cont => $item)
//					echo genInput('hidden',$item,$classent->$item);
//				echo genInput('hidden','op','1');
//				echo genInput('hidden','btnUpd','btnUpd','','','','btn').
//						 "<input type=\"image\" alt=\"Modificar Registro\" height='15' width='15' src=\"img/img02.gif\" border='0'> \n";
//				echo genCCol();
//				echo $str_closeform;
//			}
//			
//			
//			
//			if (trim($a_key[2])=='100'  && !$boolNoEditable && !$boolNoDelete){
//				echo"<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
//				
//					$strHiden="";
//					foreach ($keyFields as $cont => $item)
//								$strHiden.=genInput('hidden',$item,$classent->$item);
//				echo genOCol('','center','',$CFG_BGC[1],'50','',$CFG_LBL[14]);
//				echo $strHiden. 
//					genInput('hidden','op','1');
//				echo genInput('hidden','btnDel','btnDel','','','','btn').
//					 "<input type=\"image\" alt=\"Borrar Registro\" height='15' width='15' src=\"img/img06.gif\" border='0'> \n";
//				echo genCCol();
//				echo $str_closeform;
//			}
//			echo genCRen().genCTable();
//		echo genCCol();
//	}
//
//		//---- COMIENZA LA COLUMNA IMPRESION Y LEYENDAS DE NIVEL
//		if (isset($intNivel) || (isset($a_print) && count($a_print)>0)){
//			echo genOCol('','center','','',(isset($suma_width_aux)?$suma_width_aux:0),'','');
//			echo genOTable('0',(isset($suma_width_aux)?$suma_width_aux:0),'','','','0','1','left').genORen();
///* referencias de IMPRESION Y LEYENDAS DE NIVEL' */
//	
//			if (isset($a_print) && sizeof($a_print)>0){
//			
//				foreach ($a_print as $cont_item_a => $item_a){
//					$str_splitvalues="";
//					foreach ($item_a[2] as $cont_e => $item_e){
//						if ($cont_e>0) $str_splitvalues.=':';
//							$str_splitvalues=$classent->$item;
//					}
//					echo genOCol('','center','',$CFG_BGC[1],$item_a[3],'',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
//						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
//					$str_print="<a style=\"font-weight: normal;\"  href=\"javascript:abrir('";
//					$str_print.=$item_a[0];
//					$str_print.="rowid=" . base64_encode(addslashes($str_splitvalues)) . "&";
//					foreach ($item_a[2] as $cont_e => $item_e){
//						if ($cont_e>0) $str_print.='&';
//							$str_print.=$item_e.'='.$classent->$item_e;
//					}
//					$str_print.="')\">".$item_a[1]."</a>";
//					echo $str_print;
//					echo genCCol();
//				}
//			}
//			
//			if (isset($intNivel)){
//				echo genOCol('','center','',$CFG_BGC[1],(isset($intNW))?$intNW:80,'',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
//						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
//				echo "<a href=\"".$str_href ."\" >".(isset($lblNivel)?$lblNivel:"<img alt='consultar' height='16' width='16' border='0' src='img/img26.jpg'>"). "</a>";
//						//" <img alt='consultar' height='16' width='16' border='0' src='img/img26.jpg'></a>";
//				echo genCCol();
//			}
///* termina referencias de impresion*/
//			echo genCRen().genCTable();
//		echo genCCol();
//	}
////--   termina columna de botones de edicion, impresion y leyenda de nivel
//			 $strIdentifyRow="";
//	    if (isset($a_identifyRow)){
//			foreach ($a_identifyRow as $cont => $item){
//				$strIdentifyRow.= " " . $classent->$item;
//		}}
//
//		//---- COMIENZA LA COLUMNA BOTONES DE EDICION
//if (trim($a_key[1])=='100' && !$boolNoEditable && (!$boolNoUpdate or !$boolNoDelete)){		
//		echo genOCol('','center','',$CFG_BGC[1],$widthEditable,'',$CFG_LBL[29]);
//			echo genOTable('0',$widthEditable,'','',$CFG_BGC[6],'0','1','left').genORen();
////---Empiezan botones de edicion
//	if ($b_printline==1  && !$boolNoUpdate && $widthEditable>0){
//
//				echo"<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
//				echo genOCol('','center','',$CFG_BGC[1],'20','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
//						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
//						 $strGetValues="";
//				foreach ($keyFields as $cont => $item){
//					echo genInput('hidden',$item,$classent->$item);
//						if (strlen($strGetValues)>0) $strGetValues.="&";
//						$strGetValues.= $item . "=" . $classent->$item;
//					}
//				echo genInput('hidden','op','1');
//				echo genInput('hidden','nivPo',(isset($_SESSION['SYS_SECCAPA']['niv']) && strlen($_SESSION['SYS_SECCAPA']['niv'])>0)?$_SESSION['SYS_SECCAPA']['niv']:'0');
//				echo genInput('hidden','btnUpd','btnUpd','','','','btn').
//						 "<input type=\"image\" alt=\"Modificar Registro\" height='16' width='16' src=\"img/img02_16.gif\" border='0'> \n";
//				echo genCCol();
//				echo $str_closeform;
//			}
//			if (trim($a_key[2])=='100'  && !$boolNoEditable && !$boolNoDelete){
//				echo"<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
//					$strHiden="";
//					foreach ($keyFields as $cont => $item)
//								$strHiden.=genInput('hidden',$item,$classent->$item);
//				echo genOCol('','center','',$CFG_BGC[1],'20','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
//						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"");
//				echo $strHiden. 
//					genInput('hidden','op','1');
//				echo genInput('hidden','nivPo',(isset($_SESSION['SYS_SECCAPA']['niv']) && strlen($_SESSION['SYS_SECCAPA']['niv'])>0)?$_SESSION['SYS_SECCAPA']['niv']:'0');
//				echo genInput('hidden','btnDel','btnDel','','','','btn').
//					 "<input type=\"image\" alt=\"Borrar Registro\" height='16' width='16' src=\"img/img06_16.gif\" border='0' onclick=\"show_confirm('MODULO DE ". strtoupper($entidad) ." : < mensaje de confirmación >','¿Esta seguro que desea borrar el registro".addslashes($strIdentifyRow)."?');return document.obj_retVal;\"> \n";
//				echo genCCol();
//				echo $str_closeform;
//			}
//	
//	/*fin de col de botones*/
//			echo genCRen().genCTable();
//		echo genCCol();
//	}	
////--   termina columna de botones de edicion
//

/*fin de col de botones*/
	foreach ($field as $count_fields => $afield){
		if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1'){
			$style=$CFG_LBL[30];
			switch ($afield[3]){
				case 'select':
				echo genOCol('','','','',$afield[8],'',$CFG_LBL[30]);
				if (isset($afield[5][8]) && $classent->$afield[5][8] == 5){
								if (strlen(trim($classent->$afield[0]))>0) $asplit_valselect=explode(',',$classent->$afield[0]);
								else $asplit_valselect=array();
								$cnteeselect=2;
								foreach(${$afield[5][0].$classent->$afield[5][7]} as $count_eselect => $val_eselect){
									if ($count_eselect>0){
										$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
										if (($cnteeselect%2)==0){$strsstyle="background-color:#FFFFCC;border: 1px solid  #DADADA;";}
										if (in_array($val_eselect,$asplit_valselect)){
											echo "<span style=\"".$strsstyle."\">".
												${$afield[5][1].$classent->$afield[5][7]}[$count_eselect].
												"</span>";
											$cnteeselect++;	
										}
									}}
								}
								
								
							else{
								
						echo getDescript($classent->$afield[0],${$afield[5][0].$classent->$afield[5][7]},${$afield[5][1].$classent->$afield[5][7]});
							}
##########################################################################RESPUESTAS###################################################################################################																
							if (isset($afield[5][10]) && strlen($afield[5][10])>0 && $classent->$afield[5][9]==1){
											$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
										echo "<span style=\"".$strsstyle."\">".
											$classent->$afield[5][10]."".
											"</span>";
									}
##########################################################################RESPUESTAS###################################################################################################									
					echo genCCol();		
				break;
				case 'check':
						echo genCol(genInput('checkbox',$afield[0],'','','','','','DISABLED',($classent->$afield[0]>0?'checked':''),'5')
						,'','','','',$afield[8],'',$style);
				break;
				case 'file':
						$strlnk_getfile="";
						if (isset($file_get) and strlen(trim($file_get))>0 and ($classent->$afield[0]<>"")){
							$strlnk_getfile="<a href='files/getfile.php?".$strGetValues."&file_get=".$file_get."' target='_blank'>" . $classent->$afield[0] . "</a>";
						}else{$strlnk_getfile=($classent->$afield[0]<>""?$classent->$afield[0]:'');}
						echo genCol(($strlnk_getfile<>""?$strlnk_getfile:''),'','','','',$afield[8],'',$style);
				break;
				default:
					if (isset($afield[18]) && $afield[18]==1){
						$str_implodevalues="";
						echo genOCol('','','','',$afield[8],'',$CFG_LBL[30]);
						
							foreach ($afield[19][0] as $count_int_aafield => $int_aafield){ 
								if ($count_int_aafield>0)
									$str_implodevalues.=$afield[19][1];
								$str_implodevalues.=$classent->$field[$int_aafield][0];
							}
							echo $str_implodevalues;
						echo genCCol();
					} else {
					
						$strFieldValue=$classent->$afield[0];
						$strFieldValue=str_replace("\n","<br/>",$strFieldValue);
						if (isset($afield[23]) and strlen(trim($afield[23]))>0){eval("\$strFieldValue=".$afield[23].'('.$classent->$afield[0].');');}
//						if (strlen($strFieldValue)>70){
//							$strFieldValue=substr($strFieldValue,0,60).
//							"&nbsp;&nbsp;<a href=\"javascript:ver('id_col".$afield[0]."_div".$i."')\" style=\"font-size:10px;text-decoration:none;\" >[+/-]</a>".
//							formatDiv('id_col'.$afield[0].'_div'.$i,str_replace("\n","<br/>",$strFieldValue),$afield[1],$i,"div11px");
//						}

						if($strFieldValue == '01.10'){

						}
						echo genCol($strFieldValue,'','','',(isset($afield[21]) && strlen($afield[21])>0)?
														((isset($a_filed_bg_color) and sizeof($a_filed_bg_color)>0 and in_array($afield[0],$a_filed_bg_color) and $boolSetColor)?$strSetColor:$afield[21]):
								(isset($a_alertas) and (in_array($afield[0],$a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1])?$a_bg_alertas[$afield[0]][2]:''),$afield[8],'',
							(isset($afield[22]) && strlen($afield[22])>0)?
								$afield[22]:(($afield[6]=='money' or $afield[6]=='int')?
									$CFG_LBL[45]:(($afield[6]=='date' or $afield[6]=='email')?
										$CFG_LBL[41]:$CFG_LBL[30])));
										
						
					}
				break;
				}

		}
		
	}
	echo genCRen()." \n";
}
/* echo genCTable().genCCol().genCRen();
	//
	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditableIni);
	echo genOTable('0',$suma_width+$widthEditableIni,'','',$CFG_BGC[1],'0','0');
	echo genORen();
	echo genCol("<img height='10' width='20' border='0' src='img/infizq.jpg'>",'','','',$CFG_BGC[3],'20','10',$CFG_LBL[2]);
	echo genCol('','','','',$CFG_BGC[1],"".($suma_width+100-40)."",'20',$CFG_LBL[2]);
	echo genCol("<img height='10' width='20' border='0' src='img/infder.jpg'>",'','','',$CFG_BGC[3],'20','10',$CFG_LBL[2]);
	echo genCRen();
	echo genCTable().genCCol().genCRen();
echo genCTable(); */
}
function formatDiv($target,$data,$label,$idrow,$classDiv){
return "<div id=\"" . $target . "\" class=\"".$classDiv."\"><div style='font-weight:bold;font-variant:small-caps'>".$label.":</div>".$data."</div>";
}

?>
<script language="JavaScript">

var visto = null;
function ver(objname) {
  obj = document.getElementById(objname);
  obj.style.display = (obj==visto) ? 'none' : 'block';
  if (visto != null)
    visto.style.display = 'none';
  visto = (obj==visto) ? null : obj;
}
</script>
<script>
  $(document).ready(function () {
    $("#toolHelp").hide();
	$("#toolTipBox").hide();
  });
</script>