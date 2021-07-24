<?php if(strlen(session_id())==0)session_start();
include_once("config/cfg.php");
if ($__SESSION->getValueSession('nomusuario')<>"" && $__SESSION->getValueSession('passwd')<>"" && $__SESSION->getValueSession('cveperfil')<>"") {
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
    $arreglo_comienza=formar_arreglo($arreglo_menu, 0,$allfm);
    global $menu2;
    $menu2='<nav aria-label="Menu del Sistema">'
            . '<ul class="list-unstyled" id="menuaccess">'
            . '<li><a href="index.php?mod=-1" class="f_cmb border-bottom" id="mod_0"> <i class="fa fa-home f_cmb_icon_in"></i>Principal </a></li>';
    foreach ($arreglo_comienza as $con_datos => $item_des) {
        $nodo_buscar1=$item_des['cve_modulo'];
        $arreglo_busqueda1=formar_arreglo($arreglo_menu,$nodo_buscar1,$allfm);     
        if($arreglo_busqueda1==false){
        $menu2.='<li>';
        $color_icono=($item_des['color_icono']=='null' || $item_des['color_icono']==''?'':' style="font-size:18px;" ');
        $url=('null'==$item_des['url_modulo']?'#':substr($item_des['url_modulo'],3).(($item_des['url_include']=='null')?'':('?mod='.$item_des['cve_modulo'])));
        $menu2.='<a href="'.$url.'" class="f_cmb border-bottom" id="mod_'.$item_des['cve_modulo'].'"><i  '.$color_icono.' class="gira f_cmb_icon_in menu-icon '.$item_des['icono'].'"></i><span>'.$item_des['des_modulo'].'</span></a>'.'</li>';
        }else{
        $menu2.='<li>';
        $color_icono=($item_des['color_icono']=='null' || $item_des['color_icono']==''?'':' style="font-size:18px;" ');
        $url=('null'==$item_des['url_modulo']?'#sm'.$item_des['cve_modulo']:substr($item_des['url_modulo'],3).(($item_des['url_include']=='null')?'':('?mod='.$item_des['cve_modulo'])));
        $menu2.='<a class="sub_menu_a f_cmb border-bottom" id="mod_'.$item_des['cve_modulo'].'" href="'.$url.'" aria-expanded="false" data-toggle="collapse"><i  '.$color_icono.' class="gira f_cmb_icon_in menu-icon '.$item_des['icono'].'"></i><span>'.$item_des['des_modulo'].'</span></a>';
            pinta_ul($arreglo_busqueda1,$allfm,$arreglo_menu,$item_des['cve_modulo']);
        }
    }//<li><a href="#"><i id="icon_prin_h" class="fa fa-home" style="font-size:5mm;color:#f77825;"></i> <span>Principal</span></a></li>'
	$menu2.='<li>
                    <a href="logout.php" class="f_cmb"> <i class="gira menu-icon f_cmb_icon_in fa fa-power-off"></i>Cerrar sesi&oacute;n</a>
                </li>';
    $menu2.='  </ul></nav>';



} else {
    include_once('../includes/sb_ii_refresh.php');
}
//}else{include_once('../includes/ii_refresh.php');}
function pinta_ul($arreglo_comienza,$allfm,$arreglo_datos,$cve_m){
    global $menu2;
    $menu2.='<ul id="sm'.$cve_m.'" class="collapse list-unstyled ">';
    foreach ($arreglo_comienza as $con_datos => $item_des) {
        $nodo_buscar =$item_des['cve_modulo'];
        $arreglo_busqueda=formar_arreglo($arreglo_datos,$nodo_buscar,$allfm);
        if($arreglo_busqueda==false){
            $color_icono=($item_des['color_icono']=='null' || $item_des['color_icono']==''?'':' style="left:6px;" ');
            $icono_submenu=($item_des['icono']=='null' || $item_des['icono']==''?'':'<i  '.$color_icono.' class="gira f_cmb_icon_in '.$item_des['icono'].'"></i>' );
        $menu2.='<li>';
        $url=('null'==$item_des['url_modulo']?'#':substr($item_des['url_modulo'],3).(($item_des['url_include']=='null')?'':('?mod='.$item_des['cve_modulo'])));
        $menu2.='<a class="sub_menu_a f_cmb border-bottom" id="mod_'.$item_des['cve_modulo'].'" href="'.$url.'">'.$icono_submenu.$item_des['des_modulo'].'</a>'.'</li>';
        }else{
            $color_icono=($item_des['color_icono']=='null' || $item_des['color_icono']==''?'':' style="left:6px;" ');
            $icono_submenu=($item_des['icono']=='null' || $item_des['icono']==''?'':'<i '.$color_icono.' class="gira f_cmb_icon_in '.$item_des['icono'].'"></i>' );
            $menu2.='<li>';
            $url=('null'==$item_des['url_modulo']?'#sm'.$item_des['cve_modulo']:substr($item_des['url_modulo'],3).(($item_des['url_include']=='null')?'':('?mod='.$item_des['cve_modulo'])));

            $menu2.='<a class="sub_menu_a f_cmb border-bottom" id="mod_'.$item_des['cve_modulo'].'" onmouseover="" href="'.'#sm'.$item_des['cve_modulo'].'" aria-expanded="false" data-toggle="collapse">'.$icono_submenu.$item_des['des_modulo'].'</a>'; 
            pinta_ul($arreglo_busqueda,$allfm,$arreglo_datos,$item_des['cve_modulo']);
        }

        $menu2.='';
        }

    $menu2.='</ul>'; 
    
}
    function formar_arreglo($arreglo_datos, $nodo_padre,$campos) {
        $arreglo_nuevo=array();
        foreach ($arreglo_datos as $con_datos => $item_des) {
            if($item_des['cve_modulo_padre']==$nodo_padre){
                foreach ($campos as $con_campos => $descampos) {
                    $arreglo_nuevo[$item_des['cve_modulo']][$descampos]=$item_des[$descampos];
                }
            }
        }

        if(count($arreglo_nuevo)>0)return $arreglo_nuevo;
        else return false;
    }
?>

