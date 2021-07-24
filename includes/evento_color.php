<?php
//ok
session_start();
$str_check = FALSE;
include_once("sb_check_ajax.php");
if ($str_check) {
    $type = $_POST['type'];
    $resultado = array();
    if ($type == 'color') {
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $classent = new Entidad(array('cve_usuario'), array('0'));
        $array_namesxTmp = array('color_menu');
        $array_typetxTmp = array('char');
        $array_valuesxTmp = array($_POST['color']);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('color_menu', $_POST['color']);

        $classconsul = new Entidad(array('m_active99'), array(''));
        $classconsul->ListaEntidades(array('m_active99'), 'sb_usuario', ' where cve_usuario = ' . $__SESSION->getValueSession('cveusuario'), ' m_active99 ', 'no');
        $classconsul->VerDatosEntidad(0, array('m_active99'));
        $m_active = $classconsul->m_active99;

        echo json_encode(array('successful' => 'true', 'm_active' => $m_active));
    } else if ($type == 'm_t') {
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $classent = new Entidad(array('cve_usuario'), array('0'));
        $array_namesxTmp = array('m_active99');
        $array_typetxTmp = array('int');
        $array_valuesxTmp = array($_POST['val']);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('m_active', $_POST['val']);

        echo json_encode(array('successful' => 'true', 'm_active' => $_POST['val']));
    } else if ($type == 'color_f') {
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $classent = new Entidad(array('color_f_menu'), array('0'));
        $array_namesxTmp = array('color_f_menu');
        $array_typetxTmp = array('char');
        $array_valuesxTmp = array($_POST['color']);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('color_f', $_POST['color']);
        echo json_encode(array('successful' => 'true'));
    } else if ($type == 'f_s') {//f_l
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $classent = new Entidad(array('f_size_menu'), array('0'));
        $array_namesxTmp = array('f_size_menu');
        $array_typetxTmp = array('char');
        $array_valuesxTmp = array($_POST['f_s']);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('f_s', $_POST['f_s']);
        echo json_encode(array('successful' => 'true'));
    } else if ($type == 'f_l') {//
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $classent = new Entidad(array('f_size_menu'), array('0'));
        $array_namesxTmp = array('f_size_label');
        $array_typetxTmp = array('char');
        $array_valuesxTmp = array($_POST['f_l']);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('f_l', $_POST['f_l']);
        echo json_encode(array('successful' => 'true'));
    } else if ($type == 'cmb_t') {//
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");
        $type = addslashes(trim(filter_input(INPUT_POST, 't')));

        $classent = new Entidad(array('theme'), array(''));
        $array_namesxTmp = array('theme');
        $array_typetxTmp = array('int');
        $array_valuesxTmp = array($type);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_usuario', " cve_usuario='" . $__SESSION->getValueSession('cveusuario') . "'");
        $__SESSION->setValueSession('theme', $type);
        echo json_encode(array('successful' => 'true'));
    } else if ($type == 'b_menu') {
        $success = 'true';
        $menu = "";
        $color = "";
        $num_reg = '';
        try {

            include_once("../config/cfg.php");
            include_once("../lib/lib_pgsql.php");
            include_once("../lib/lib_entidad.php");
            $classconsul = new Entidad(array('color_menu'), array(''));
            $classconsul->ListaEntidades(array('color_menu'), 'sb_usuario', ' where cve_usuario = ' . $__SESSION->getValueSession('cveusuario'), ' color_menu ', 'no');
            $classconsul->VerDatosEntidad(0, array('color_menu'));
            $color = $classconsul->color_menu;
            $des_modulo = addslashes(utf8_decode(filter_input(INPUT_POST, 'des_modulo')));
            $menu = crea_menu($des_modulo);
            $menu[0] = utf8_encode($menu[0]);
            $num_reg = $menu[1];
        } catch (Exception $ex) {
            $success = "false";
        }
        echo json_encode(array('successful' => $success, 'menu' => $menu[0], 'color' => $color, 'n_r' => $num_reg));
    }
} else {
    echo json_encode(array('successful' => 'no muchacho'));
}

function crea_menu($des_modulo) {
    global $__SESSION;
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
    $where_m = "";
    $where_m1 = " 1=1 ";
    if ($des_modulo <> "") {
        $where_m = " and sm.des_modulo like('%" . $des_modulo . "%') ";
        $where_m1 = " sm.des_modulo like('%" . $des_modulo . "%') ";
    }
    $perfil = $__SESSION->getValueSession('cveperfil');
    $tablam = '(
SELECT sbm.cve_perfil,sm.cve_modulo,sm.des_modulo,sm.url_modulo,sm.grp_modulo,sm.pos_modulo,sm.niv_modulo,sm.url_include,sm.cve_modulo_padre,sm.icono,sm.color_icono
FROM sb_perfil_modulo sbm
join sb_modulo sm on sbm.cve_modulo=sm.cve_modulo
WHERE sm.display=1 AND sbm.cve_perfil=' . $perfil . ' ' . $where_m . '
AND sm.sta_modulo<>0

union 

SELECT sbm.cve_perfil,smp.cve_modulo,smp.des_modulo,smp.url_modulo,smp.grp_modulo,smp.pos_modulo,smp.niv_modulo,smp.url_include,smp.cve_modulo_padre,smp.icono,smp.color_icono
FROM sb_perfil_modulo sbm
join sb_modulo sm on sbm.cve_modulo=sm.cve_modulo
join sb_modulo smp on sm.cve_modulo_padre=smp.cve_modulo
WHERE sm.display=1 AND sbm.cve_perfil=' . $perfil . ' ' . $where_m . '
AND sm.sta_modulo<>0

union

SELECT sbm.cve_perfil,sm1.cve_modulo,sm1.des_modulo,sm1.url_modulo,sm1.grp_modulo,sm1.pos_modulo,sm1.niv_modulo,sm1.url_include,sm1.cve_modulo_padre,sm1.icono,sm1.color_icono
FROM sb_perfil_modulo sbm
JOIN sb_modulo sm1 ON sbm.cve_modulo=sm1.cve_modulo
WHERE sm1.display=1 AND sbm.cve_perfil=' . $perfil . ' AND sm1.grp_modulo IN 
(
SELECT sm.grp_modulo
FROM sb_perfil_modulo sbm
JOIN sb_modulo sm ON sbm.cve_modulo=sm.cve_modulo
WHERE sm.display=1 AND sbm.cve_perfil=' . $perfil . ' AND IF(sm.niv_modulo=1,' . $where_m1 . ',1=2) AND sm.sta_modulo <> 0
GROUP BY sm.grp_modulo) AND sm1.sta_modulo <> 0

) as q1';
    $strWherem = " ";
    $strWherem .= " ";
    $strWherem .= " ";
    $a_orderm = array("grp_modulo", "pos_modulo", "niv_modulo");
    $classval2 = new Entidad($allfm, $allvm);
    //$classval->Set_Item($IdPrin,$$IdPrin);
    $classval2->ListaEntidades($a_orderm, $tablam, $strWherem, " cve_perfil,cve_modulo,des_modulo,url_modulo,grp_modulo,pos_modulo,niv_modulo,url_include,cve_modulo_padre,icono,color_icono ", "yes", "");
//    echo '<pre>';
//    print_r($classval2);die();

    if ($classval2->NumReg > 0) {
        global $menu2;
        $menu2[0] = '';
        $arreglo_menu = array();
        for ($i = 0; $i < $classval2->NumReg; $i++) {
            $classval2->VerDatosEntidad($i, $allfm, false);
            foreach ($allfm as $cntitem_val => $item_des) {
                $arreglo_menu[$classval2->cve_modulo][$item_des] = $classval2->$item_des;
            }
        }
        $arreglo_comienza = formar_arreglo($arreglo_menu, 0, $allfm);
        $menu2[0] = '<nav aria-label="Menu del Sistema">'
                . '<ul class="list-unstyled" id="menuaccess">'
                . '<li><a href="index.php?mod=-1" class="f_cmb border-bottom" id="mod_0"> <i class="f_cmb_icon_in fa fa-home"></i>Principal </a></li>';
        foreach ($arreglo_comienza as $con_datos => $item_des) {
            $nodo_buscar1 = $item_des['cve_modulo'];
            $arreglo_busqueda1 = formar_arreglo($arreglo_menu, $nodo_buscar1, $allfm);
            if($des_modulo!=""){
                $descripcionmod=find_text($item_des['des_modulo'],$des_modulo);
            }else{
                $descripcionmod=$item_des['des_modulo'];
            }
            if ($arreglo_busqueda1 == false) {
                $menu2[0] .= '<li>';
                //$color_icono = ($item_des['color_icono'] == 'null' || $item_des['color_icono'] == '' ? '' : ' style="font-size:18px;color:#' . ($item_des['color_icono']) . ';" ');
                $url = ('null' == $item_des['url_modulo'] ? '#' : substr($item_des['url_modulo'], 3) . (($item_des['url_include'] == 'null') ? '' : ('?mod=' . $item_des['cve_modulo'])));
                $menu2[0] .= '<a href="' . $url . '"  class="f_cmb border-bottom"><i  ' . $color_icono . ' class="f_cmb_icon_in gira menu-icon ' . $item_des['icono'] . '"></i><span>' . $descripcionmod . '</span></a>' . '</li>';
            } else {            
                $menu2[0] .= '<li>';
                if($des_modulo!=""){$muestrasub="true";}else{$muestrasub="false";}
                //$color_icono = ($item_des['color_icono'] == 'null' || $item_des['color_icono'] == '' ? '' : ' style="font-size:18px;color:#' . ($item_des['color_icono']) . ';" ');
                $url = ('null' == $item_des['url_modulo'] ? '#sm' . $item_des['cve_modulo'] : substr($item_des['url_modulo'], 3) . (($item_des['url_include'] == 'null') ? '' : ('?mod=' . $item_des['cve_modulo'])));
                $menu2[0] .= '<a class="sub_menu_a f_cmb border-bottom" href="' . $url . '" aria-expanded="'.$muestrasub.'" data-toggle="collapse"><i  ' . $color_icono . ' class="f_cmb_icon_in gira menu-icon ' . $item_des['icono'] . '"></i><span>' . $descripcionmod . '</span></a>';
                pinta_ul($arreglo_busqueda1, $allfm, $arreglo_menu, $item_des['cve_modulo'],$des_modulo);
            }
        }//<li><a href="#"><i id="icon_prin_h" class="fa fa-home" style="font-size:5mm;color:#f77825;"></i> <span>Principal</span></a></li>'
       if($des_modulo!=""){
        $menu2[0] .= '<li>
                    <a href="javascript:f_menu(\'\');$(\'.search-box\').fadeOut();" class="f_cmb border-bottom"> <i class="f_cmb_icon_in gira menu-icon fa fa-times"></i>Limpiar busqueda</a>
                </li>';
       }
        $menu2[0] .= '<li>
                    <a href="logout.php" class="f_cmb"> <i class="f_cmb_icon_in gira menu-icon fa fa-power-off"></i>Cerrar sesi&oacute;n</a>
                </li>';
        $menu2[0] .= '  </ul></nav>';
        $menu2[1] = $classval2->NumReg;
//        echo '<pre>';
//        print_r($menu2);die();
        return $menu2;
    } else {
        $menu_s = '<ul class="nav navbar-nav">' .
                '<li class="active">' .
                '<a href="index.php" class="text-danger font-weight-bold"> <i class="gira f_cmb_icon_in  menu-icon fa fa-exclamation-triangle text-danger"></i>'.$des_modulo.'0 encontrados ...</a>' .
                '</li></ul>';

        return array($menu_s, $classval2->NumReg);
    }
}

function pinta_ul($arreglo_comienza, $allfm, $arreglo_datos, $cve_m, $des_modulo) {
    global $menu2;
    if($des_modulo!=""){$muestrasub="show";}else{$muestrasub="";}
    $menu2[0] .= '<ul id="sm' . $cve_m . '" class="collapse list-unstyled '.$muestrasub.'">';
    foreach ($arreglo_comienza as $con_datos => $item_des) {
        $nodo_buscar = $item_des['cve_modulo'];
        $arreglo_busqueda = formar_arreglo($arreglo_datos, $nodo_buscar, $allfm);
        if($des_modulo!=""){
            $descripcionmod=find_text($item_des['des_modulo'],$des_modulo);
        }else{
            $descripcionmod=$item_des['des_modulo'];
        }
        if ($arreglo_busqueda == false) {
            //$color_icono = ($item_des['color_icono'] == 'null' || $item_des['color_icono'] == '' ? '' : ' style="left:6px;color:#' . ($item_des['color_icono']) . ';" ');
            $icono_submenu = ($item_des['icono'] == 'null' || $item_des['icono'] == '' ? '' : '<i  ' . $color_icono . ' class="f_cmb_icon_in gira ' . $item_des['icono'] . '"></i>' );
            $menu2[0] .= '<li>';
            $url = ('null' == $item_des['url_modulo'] ? '#' : substr($item_des['url_modulo'], 3) . (($item_des['url_include'] == 'null') ? '' : ('?mod=' . $item_des['cve_modulo'])));
            $menu2[0] .= '<a class="sub_menu_a f_cmb border-bottom" href="' . $url . '">' . $icono_submenu . $descripcionmod . '</a>' . '</li>';
        } else {
           // $color_icono = ($item_des['color_icono'] == 'null' || $item_des['color_icono'] == '' ? '' : ' style="left:6px;color:#' . ($item_des['color_icono']) . ';" ');
            $icono_submenu = ($item_des['icono'] == 'null' || $item_des['icono'] == '' ? '' : '<i ' . $color_icono . ' class="f_cmb_icon_in gira ' . $item_des['icono'] . '"></i>' );
            $menu2[0] .= '<li>';
            $url = ('null' == $item_des['url_modulo'] ? '#sm' . $item_des['cve_modulo'] : substr($item_des['url_modulo'], 3) . (($item_des['url_include'] == 'null') ? '' : ('?mod=' . $item_des['cve_modulo'])));

            $menu2[0] .= '<a class="sub_menu_a f_cmb border-bottom" onmouseover="" href="' . '#sm' . $item_des['cve_modulo'] . '" aria-expanded="false" data-toggle="collapse">' . $icono_submenu . $descripcionmod . '</a>';
            pinta_ul($arreglo_busqueda, $allfm, $arreglo_datos, $item_des['cve_modulo'], $des_modulo);
        }
        $menu2[0] .= '';
    }
    $menu2[0] .= '</ul>';
}

function formar_arreglo($arreglo_datos, $nodo_padre, $campos) {
    $arreglo_nuevo = array();
    foreach ($arreglo_datos as $con_datos => $item_des) {
        if ($item_des['cve_modulo_padre'] == $nodo_padre) {
            foreach ($campos as $con_campos => $descampos) {
                $arreglo_nuevo[$item_des['cve_modulo']][$descampos] = $item_des[$descampos];
            }
        }
    }
    if (count($arreglo_nuevo) > 0)
        return $arreglo_nuevo;
    else
        return false;
}

function find_text ($cadena, $buscado) {
    $acentos = array("á", "é", "í", "ó", "ú");
    $noacentos = array("a", "e", "i", "o", "u");
    $cadena2 = str_replace($acentos, $noacentos, strtolower($cadena));
    $encontradas=array();
    $indice=0;
    while(strpos($cadena2, $buscado,$indice) !== false){
            $encontradas[]=strpos($cadena2, $buscado,$indice);
            $indice=strpos($cadena2, $buscado,$indice)+1;
    }
    $cadenautf8=($cadena);
   if(count($encontradas)>0){
        $nuevacadena=substr($cadenautf8,0,$encontradas[0]);
        foreach($encontradas as $indice => $val){
            $nuevacadena.="<span class='resalta_busqueda'>".substr($cadenautf8,$val,strlen($buscado))."</span>";
            if($indice<count($encontradas)-1){
                $nuevacadena.=substr($cadenautf8,$val+strlen($buscado),$encontradas[$indice+1]-($val+strlen($buscado)));
            }
        }
        $nuevacadena.=substr($cadenautf8,$encontradas[count($encontradas)-1]+strlen($buscado),strlen($cadena));
        return $nuevacadena;
    }else{
        return $cadena;
    }
}
?>