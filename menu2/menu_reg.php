<?php

if (strlen(session_id()) == 0)
    session_start();
include_once("config/cfg.php");
if ($__SESSION->getValueSession('nomusuario') <> "" && $__SESSION->getValueSession('passwd') <> "" && $__SESSION->getValueSession('cveperfil') <> "") {
    //if (!is_null($_SESSION['no_expediente']) && !is_null($_SESSION['curp']) && !is_null($_SESSION['cveperfil'])) {	
    $fieldm = array();
    /* $field[]=array('0 - nombre', '2 - valor inicial' */
    $fieldm[] = array('cve_perfil', 0);
    $fieldm[] = array('cve_modulo', 0);
    $fieldm[] = array('des_modulo', "");
    $fieldm[] = array('url_modulo', "");
    $fieldm[] = array('grp_modulo', 0);
    $fieldm[] = array('pos_modulo', 0);
    $fieldm[] = array('niv_modulo', 0);
    $fieldm[] = array('url_include', 0);
    $fieldm[] = array('cve_modulo_padre', 0);
    $fieldm[] = array('icono', 0);
    $fieldm[] = array('color_icono', 0);
    $allfm = array();
    $allvm = array();
    foreach ($fieldm as $afieldm) {
        $allfm[] = $afieldm[0];
        $allvm[] = $afieldm[1];
    }
    $perfil = $__SESSION->getValueSession('cveperfil');
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    $tablam = 'sb_perfil_modulo,sb_modulo';
    $strWherem = "Where sb_modulo.display=1 and sb_perfil_modulo.cve_perfil=" . $perfil;
    $strWherem.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
    $strWherem.=" and sb_modulo.sta_modulo<>0";
    $a_orderm = array("grp_modulo", "pos_modulo", "niv_modulo");
    $classval2 = new Entidad($allfm, $allvm);
    //$classval->Set_Item($IdPrin,$$IdPrin);
    $classval2->ListaEntidades($a_orderm, $tablam, $strWherem, "", "yes", "");
//		$strWhere="";
//		$tabla='';
//		$a_order=array();
    // die("asdada");
    $arreglo_menu = array();
    for ($i = 0; $i < $classval2->NumReg; $i++) {
        $classval2->VerDatosEntidad($i, $allfm, false);
        foreach ($allfm as $cntitem_val => $item_des) {
            $arreglo_menu[$classval2->cve_modulo][$item_des] = $classval2->$item_des;
        }
    }
    //die("asdas".$__SESSION->getValueSession('nomusuario'));
    $cve_persona = '';
    $end_1step = '';
    $end_2step = '';
    $end_3step = '';
    $end_4step = '';
    $end_5step = '';
    $end_6step = '';
    $end_7step = '';
    $classconsul = new Entidad(array('cve_persona', 'end_1step', 'end_2step', 'end_3step', 'end_4step', 'end_5step', 'end_6step', 'end_7step'), array(''));
    $classconsul->ListaEntidades(array('cve_persona'), 'persona', ' where curp = \'' . ($__SESSION->getValueSession('nomusuario')) . '\'', ' cve_persona,end_1step,end_2step,end_3step,end_4step,end_5step,end_6step,end_7step ', 'no');
    if ($classconsul->NumReg == 1) {
        $classconsul->VerDatosEntidad(0, array('cve_persona', 'end_1step', 'end_2step', 'end_3step', 'end_4step', 'end_5step', 'end_6step', 'end_7step'));
        $cve_persona = $classconsul->cve_persona;
        $end_1step = $classconsul->end_1step;
        $end_2step = $classconsul->end_2step;
        $end_3step = $classconsul->end_3step;
        $end_4step = $classconsul->end_4step;
        $end_5step = $classconsul->end_5step;
        $end_6step = $classconsul->end_6step;
        $end_7step = $classconsul->end_7step;
    }
    $menu2 = '<ul id="menu">';
    $menu2.= '<li class="rounded border col-12 col-md-1 completado_mod">
                <a href="registro.php" class="f_cmb border-bottom w-100 punteados_m" style="height: 100%;text-decoration: inherit;color: inherit;" id="dI">
                   <div class="numberStep">I</div><div class="texto_step text-80">Inicio</div>
                </a>
             </li>';
    $e_n = '';
    $classconsul = new Entidad(array('e_n', 'cap_juridica'), array(''));
    $classconsul->ListaEntidades(array('e_n'), 'consentimiento', ' where cve_persona=' . $cve_persona, ' e_n,cap_juridica ', 'no');
//    echo '<pre>';
//    print_r($classconsul);die();
    if ($classconsul->NumReg == 1) {
        $classconsul->VerDatosEntidad(0, array('e_n', 'cap_juridica'));
        $e_n = $classconsul->e_n;
        $e_n_aux = $classconsul->e_n;
        if (($e_n == 1 && $classconsul->cap_juridica == 1) || ($e_n == 1 && $classconsul->cap_juridica == 0)) {
            $e_n = " completado_mod ";
        }
    }
    //die("SDFSDFS".$e_n);
   // die($e_n."---as".strlen($e_n));
    if (($end_1step * 1) == 1 && ($end_2step * 1) == 1 && ($end_3step * 1) == 1 && ($end_4step * 1) == 1 && ($end_5step * 1) == 1 && ($end_6step * 1) == 1 && ($end_7step * 1) == 1 && ($e_n_aux * 1) == 1) {
        //modificar estatus
        $classconsul = new Entidad(array('estatus'), array(''));
        $classconsul->ListaEntidades(array('estatus'), 'estatus_persona s JOIN (
SELECT MAX(e.id_estatus_persona)AS ul_es
FROM estatus_persona e
WHERE e.cve_persona = ' . $cve_persona . ') AS t1 ON s.id_estatus_persona=t1.ul_es', ' ', ' s.estatus ', 'no');
        if ($classconsul->NumReg > 0) {
            $classconsul->VerDatosEntidad(0, array('estatus'));
            $estado_per = $classconsul->estatus;
        }
        if ($estado_per == 1 || $estado_per == 4) {
            $a_key_session_id = ((session_id() <> "") ? session_id() : rand(5642, 9826));
            $a_key_session_usuario = $__SESSION->getValueSession('cveusuario');
            $allfields = array('cve_persona', 'estatus', 'observacion', 'cve_usuario', 'id_session');
            $atypes = array('int', 'int', 'char', 'int', 'char');
            $allvalues = array($cve_persona, 2, 'Se completa el registro', $a_key_session_usuario, $a_key_session_id);
            $classent = new Entidad($allfields, $allvalues);
            $classent->Adicionar($allvalues, $allfields, $atypes, 'estatus_persona');
        }
    }

    $menu2.= '<li class="rounded border col-12 col-md-1 ' . ($__SESSION->getValueSession('mod') == 9999 ? ' active ' : $e_n) . "" . '">
                <a href="index.php?mod=-1" class="f_cmb border-bottom w-100 punteados_m" style="height: 100%;text-decoration: inherit;color: inherit;" id="dII">
                   <div class="numberStep">II</div><div class="texto_step text-80">Consentimiento' . (strlen($e_n_aux) > 0 && $e_n_aux*1==1 ? '<br />¡Completado!<br /><i class="fa fa-thumbs-up" style="font-size:18px;" aria-hidden="true"></i>' : '<br />¡Completar!') . '</div>
                </a>
             </li>';
    $con_m = 1;

    foreach ($arreglo_menu as $key => $value) {
        $m_c = '';
        switch ($value['cve_modulo']) {
            case 208:
                if ($end_1step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 209:
                if ($end_2step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 210:
                if ($end_3step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 211:
                if ($end_4step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 212:
                if ($end_5step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 213:
                if ($end_6step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
            case 214:
                if ($end_7step == 1) {
                    $m_c = " completado_mod ";
                }
                break;
        }
        if (strlen($e_n) > 0) {//<p class="rounded" style="background-color:#f4a460;color:#000;font-weight:bold;padding-top:.2em;padding-bottom:.2em;">Pendiente</p>   <br /><i class="fa fa-thumbs-down" style="font-size:18px;" aria-hidden="true"></i>
            $menu2.='<li class="' . ($__SESSION->getValueSession('mod') == $value['cve_modulo'] ? 'active' : $m_c) . ' rounded border col-12 col-md-1 ' . ("") . '">
                                            <a href="index.php?mod=' . $value['cve_modulo'] . '" class="f_cmb border-bottom w-100 punteados_m" style="height: 100%;text-decoration: inherit;color: inherit;" id="modulos_' . $key . '">
                                                <div class="numberStep">' . $con_m . '</div><div class="texto_step text-80" style="line-height:22px;">' . $value['des_modulo'] . (strlen($m_c) > 0 ? '<br />¡Completado!' . '<br /><i class="fa fa-thumbs-up" style="font-size:18px;" aria-hidden="true"></i>' : '<br />¡Completar!') . '</div>
                                            </a>
                                        </li>';
        }

        $con_m++;
    }
    $menu2.='</ul>';
}
?>

