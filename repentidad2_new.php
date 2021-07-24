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
                            showTime: false,";
                }else{
                    $conf_d="changeMonth: true,
                            changeYear: true,
                            controlType: 'select',
                            oneLine: true,
                            dateFormat: 'dd/mm/yy',
                            timeFormat: 'HH:mm',";                    
                }
                $ar_date_t[] = array($afield[0], isset($afield[25])?$afield[25]:$conf_d, $afield[26]);                    
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
//if (strlen($vars_obj)>0){
//		$vars_obj="onClick=\"obj_valObj(".$vars_obj.");\"";
//}
        if (!isset($ValsendRep2))
            $ValsendRep2 = "sendRep2";
        if (strlen($vars_obj) > 0) {
            $vars_obj = "onClick=\"obj_valObj(" . $vars_obj . ");" . $ValsendRep2 . "('" .
                    $stropen . "','" . (isset($vparitem) ? $str_vparfile : '') . "'," . $vars_post . "); return false;\"";
        } else {
            $vars_obj = "onClick=\"" . $ValsendRep2 . "('" .
                    $stropen . "','" . (isset($vparitem) ? $str_vparfile : '') . "'," . $vars_post . "); return false;\"";
        }
    echo' <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb" style="margin-bottom: 12px;padding: 0.5rem 1rem;">
              <li class="breadcrumb-item active h5 font-weight-bold">'.$entidad.'</li>
            </ul>
          </div>
          ';     
        $str_requeridos = "Los campos con&nbsp;&nbsp;<i class='fa fa-asterisk' aria-hidden='true' style='color:red;'></i>&nbsp;&nbsp;son obligatorios";
        $requeridos = '<div class="alert alert-success" role="alert" style="padding: .4rem .4rem;margin-bottom: .9rem;margin-top: -12px;">
                                ' . $str_requeridos . '
                            </div>';
        echo $requeridos;    
        $frmname = 'frmcon';

        echo '<div class="content m-1">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-lg-12">';
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
            $a_separs[] = array(0, '', count($field), 'bg-dark');
        }
        $inicio=0;
        $pinta_form="";

        for ($index2 = 0; $index2 < count($a_separs); $index2++) {
            $pinta_form.= '<div class="card">
                                            <div class="card-header text-light ' . $a_separs[$index2][3] . '" onclick="oculta(\'a_'.$a_separs[$index2][0].'\',\'i_'.$a_separs[$index2][0].'\')">
                                                <strong><i class="fa fa-minus-square text-danger" id="i_'.$a_separs[$index2][0].'" aria-hidden="true"></i>&nbsp;' . $a_separs[$index2][1] . '</strong>
                                            </div>  ';
            $pinta_form.= '<div class="card-body card-block" id="a_'.$a_separs[$index2][0].'">';      
            $pinta_form.= '<div class="row form-group">';
            for ($cont = $inicio; $cont < $a_separs[$index2][2]; $cont++) {
                $afield=$field[$cont];
            if ($afield[4] == '1' || $afield[4] == '2') {
                if ($afield[3] == 'hidden') {
                    $strFieldsInput.= genInput($afield[3], $afield[0], $afield[7]) . " \n";
                } else {
                        $pinta_form.=  '<div class="row '.$afield[13][2].'">
                                        <div class="col-12" style="height: 30px;"><label for="disabled-input" class=" form-control-label">'.(($afield[4] <> 0 ? '<label id="l_'.$afield[0].'" class="f_cmb_l">'.$afield[1].'<label>' : '') . (($afield[12] == 1) ? '&nbsp;<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px;color:red;"></i>' : '')).'</label>&nbsp;<i id="i_a'.$afield[0].'" aria-hidden="true"></i></div>
                                        <div class="' . ($afield[6] == 'date' || $afield[6] == 'datetime' ? ' input-group ' : '') .$afield[13][1].'">';
                        switch ($afield[3]) {
                            case 'text':
                                $pinta_form.= genInput($afield[3], $afield[0], $classind->$afield[0]
                                        , '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12]==1?'11':'0'))))))
                                        , ($afield[6] == 'date' ? $frmname : $afield[1]), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"')).
                                        '<small class="form-text" style="display:none" id="e_'.$afield[0].'"></small>';
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
                                $pinta_form.= "<div id=\"div_" . $afield[0] . "\" class=\"midiv\">" .
                                genSelect($afield[0], '', '', $afield[5][0], $afield[5][1], $classind->$afield[0], (($afield[10] == 0) ? 'yes' : ''), '', $stronclick . $strAddSel . ' class="form-control" onKeyPress="return objKeyPressed(event,this,\'' . $frmname . '\');"', ((isset($afield[5][5]) && strlen($afield[5][5]) > 0) ? $afield[5][5] : ''), ((isset($afield[5][6]) && strlen($afield[5][6]) > 0) ? $afield[5][6] : ''));
                                $pinta_form.= "</div>".'<small style="display:none" class="form-text" id="e_'.$afield[0].'"></small>';
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
                                $pinta_form.='<small style="display:none" class="form-text" id="e_'.$afield[0].'"></small>';
                                break;
                            case 'label':
                                $arreglo_hidden_label = $afield[0];
                                $pinta_form.= genInput('hidden', $afield[0], $classind->$afield[0]) . " \n";
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
            
		echo 	 $strFieldsInput.
			 genInput('hidden','op','1').
			 genInput('hidden','nivPo',($__SESSION->getValueSession('niv') && strlen($__SESSION->getValueSession('niv'))>0)?$__SESSION->getValueSession('niv'):'0').
			 genInput('hidden','sel','0').
			 genInput('hidden','btnGenRep','btnGenRep','','','','');
        echo '          
            <div class="card"><div class="form-group row" style="padding:.5rem .5rem .5rem 1rem; margin-bottom: 0rem;">
                          <div class="col-12 col-sm-12">
'.        "<button id=\"submit\" class=\"btn btn-success\" type=\"submit\" alt=\"Generar Reporte\" border='0' name=\"submit\" value=\"\"" . " $vars_obj><i class='fa fa-download'></i>&nbsp;Generar</button>" . '
                        ' . ("<a id=\"\" class=\"btn btn-danger\" href=\"" . $_SERVER['PHP_SELF'] . "?op=1&btnCancela=btnCancela\" ><i class='fa fa-window-close'></i>&nbsp;Cancelar</a>"
        . ((isset($selrowadd) && $selrowadd == 1) ? (
                genInput('checkbox', 'hiddrowadd', 1, '', '', '', '', '', 'checked', '8', '', '', '', '0', '', '') .
                "<span style=\"color:#838383; font-variant:small-caps; font-size: 10px;\"> continuar agregando registros en el mismo modulo</span>") : '')).'
                          </div>
                        </div></div>';                
                
                
//                echo '<div class="control-group span12 pull-center">'. '<div class="span4">'     .          
//			 "<button id=\"submit\" class=\"btn btn-success span12\"  style=\"\" type=\"submit\" border='0' name=\"submit\" value=\"\"". " $vars_obj><i class='fa fa-download'></i>&nbsp;Generar</button></div><div class='span4'></div>".
//                         "<div class='span4'><a id=\"acancelar\" style=\"min\" class=\"btn btn-danger span12\" href=\"".$_SERVER['PHP_SELF']."?op=1&btnCancela=btnCancela\" ><i class='fa fa-window-close'></i>&nbsp;Cancelar</a></div>";
//			 
//                echo '</br>&nbsp;
//                      </div>';                
		
    
        echo '              </form>'
        . '             </div>';
        echo '<div class="col-lg-12">';
        if (isset($ValsendRep2) && $ValsendRep2 <> "sendRep2") {
            $iframe = "<iframe id=\"miiframe\" name=\"miiframe\" class='col-12' height=\"370px\" SCROLLING=\"auto\" frameborder=\"0\" src=\"inicio_blank.php\" style=\"border: 0px solid #E0E4D1;z-index:10;\"></iframe>";
        } else {
            $iframe = "<div id=\"miiframe\" name=\"miiframe\" style=\"border: 1px solid #E0E4D1;z-index:10; overflow:scroll; height:400px;\"></div>" .
                    '		 <div title="Generando reporte..." id="preparing-file-modal" style="display: none;">
   Se esta generando el reporte, este proceso puede tardar dependiendo del volumen de informaci&oacute;n, espere...
    <div class="ui-progressbar-value ui-corner-left ui-corner-right" style="margin-top: 40px; text-align:center;">
    <img id="img-spinner" src="./img/corner.gif" title="Cargando ..."/></div>
</div>
<div title="Archivo" id="download-file-modal" style="display: none;">
   La descarga puede tardar dependiendo del volumen de informaci&oacute;n.
</div>
<div title="Error" id="error-modal" style="display: none;">
    Error al general el reporte, intente nuevamente.
</div>';
        }
        echo $iframe.'</div>';        
        echo '         </div>'
        . '     </div>'
        . '</div>';



    }
}
if(count($ar_date_t)){
    echo "<script language='JavaScript'>";
    echo "$(document).ready(function (){";    
    for ($index1 = 0; $index1 < count($ar_date_t); $index1++) {
echo "var ".$ar_date_t[$index1][0]." = $('#" . $ar_date_t[$index1][0] . "').datetimepicker({".
        $ar_date_t[$index1][1]."
        });
        ".$ar_date_t[$index1][2]."       
        ";          
    }
    echo " });"
    . "function mensaje(div_s){".'$("#"+div_s).datepicker("show");'."}</script>";
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
