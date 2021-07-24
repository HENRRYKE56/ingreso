<?php

include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$str_login = 'NOTHING';
$field = array();
/* $field[]=array('0 - nombre','1 - tabla',
  '2 - posicion en el registro','3 - valor inicial' */
$field[] = array('cve_usuario', 'usuario', '1', 0);
$field[] = array('nom_usuario', 'usuario', '0', "");
$field[] = array('passwd', 'usuario', '1', "");
$field[] = array('des_usuario', 'usuario', '1', "");
$field[] = array('sta_usuario', 'usuario', '1', "");
$field[] = array('cve_perfil', 'perfil', '1', 0);
$field[] = array('cve_usergroup', 'usuario', '1', 0);
$field[] = array('des_perfil', 'perfil', '1', "");
$field[] = array('cveuni', 'usergroup', '1', "");
$field[] = array('color_menu', 'color_menu', '1', "");
$field[] = array('color_f_menu', 'color_f_menu', '1', "");
$field[] = array('f_size_menu', 'f_size_menu', '1', "");
$field[] = array('f_size_label', 'f_size_label', '1', "");
$field[] = array('cve_medico', 'cve_medico', '1', "");
$field[] = array('m_active99', 'm_active99', '1', "");
$field[] = array('theme', 'theme', '1', "");


/* comentar linea de arriba si no es funcional */
$allf0 = array();
$allv0 = array();
foreach ($field as $afield) {
    $allf0[] = $afield[0];
    $allv0[] = $afield[3];
}

$allf = array();
$allv = array();
foreach ($field as $afield) {
    $allf[] = $afield[0];
    $allv[] = $afield[3];
}
$IdPrin = '';
foreach ($field as $afield)
    if ($afield[2] == '0') {
        $IdPrin = $afield[0];
        break;
    }

if (isset($_POST['txtnomusuario']) && isset($_POST['txtpasswd']) && isset($_POST['hidlogin']) && isset($_POST['hid_login'])) {
    if (!is_null($_POST['txtnomusuario']) && !is_null($_POST['txtpasswd']) && !is_null($_POST['hidlogin'])) {
        if (strlen(trim($_POST['txtnomusuario'])) > 0 && strlen(trim($_POST['txtpasswd'])) > 0 && strlen(trim($_POST['hidlogin'])) > 0) { //						&& (trim($_POST['a_year'])*1)>0
            if (intval($_POST['hidlogin']) >= 0 && intval($_POST['hidlogin'] <= 2)) {
                if (fnIdentifyOldSession($_POST['hid_login'])) {
                    $$IdPrin = $_POST['txtnomusuario'];
                    $pwd = md5($_POST['txtpasswd']);
                    //$aa_year=(trim($_POST['a_year'])*1);
                    $numLogin = $_POST['hidlogin'] + 1;
                    $tabla = 'sb_perfil_usuario pu,sb_perfil p, sb_usergroup g,sb_usuario u ';
                    $strWhere = " Where u.nom_usuario='" . $$IdPrin . "'";
                    $strWhere .= " and u.sta_usuario <> 0";
                    $strWhere .= " and u.passwd = '" . ($pwd) . "'";
                    $strWhere .= " and u.cve_usuario = pu.cve_usuario";
                    $strWhere .= " and p.cve_perfil = pu.cve_perfil";
                    $strWhere .= " and p.sta_perfil <> 0";
                    $strWhere .= " and u.cve_usergroup = g.cve_usergroup";
                    $strWhere = "select u.cve_usuario, u.des_usuario, u.nom_usuario, u.sta_usuario, u.passwd, u.cve_usergroup," .
                            " p.des_perfil, p.cve_perfil, u.cveuni, g.cve_jurisdiccion,u.color_menu,u.color_f_menu,u.f_size_menu,u.f_size_label,u.m_active99,u.theme from " . $tabla . " " . $strWhere;
                    $classval = new Entidad($allf, $allv);
                    $classval->Set_Item($IdPrin, $$IdPrin);
                    $classval->Consultar($allf0, $IdPrin, $tabla, '', $strWhere);
                    $str_gets = "";

                    if ($classval->NumReg > 0) {
                        if ($classval->NumReg == 1) {
                            $str_login = 'SESSION_00';
                        }
                    } else {
                        $str_gets = "?hidlogin=" . $numLogin;
                        $str_gets .= "&txtnomusuario=" . $$IdPrin;
                        //$str_gets.="&a_year=".$aa_year;
                    }
                } else {
                    $str_login = 'SIN_DATOS';
                    //session_regenerate_id(true);
                }
            } else {
                $str_login = 'DATOS_INT';
            }
        } else {
            $str_login = 'DATOS_INC';
        }
    } else {
        $str_login = 'SIN_DATOS';
    }
} else {
    $str_login = 'SIN_DATOS';
}

function fnIdentifyOldSession($id_sess) {
//		echo session_id(); die();
//		$retVal=false;
//		$classent = new Entidad(array('idmax'),array(0));
//		$classent->Consultar(array('idmax'),'','','',"Select max(cve_audit_session) as idmax from sb_audit_session where status_session=1 and id_session='".$id_sess."'");
    //$retVal=($classent->idmax==""?true:false);
    $retVal = true;
//		if ($classent->idmax==""){
    if (isset($_SESSION[_CFGSBASE]))
        unset($_SESSION[_CFGSBASE]);
    $array_valuesxTmp = array(0);
    $array_namesxTmp = array('status_session');
    $array_typetxTmp = array('int');
    $array_defaultxTmp = array('0');
    $classent = new Entidad($array_namesxTmp, $array_defaultxTmp);
    $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_audit_session', " status_session=1 and id_session='" . $id_sess . "'");
//		}
    return $retVal;
}

?>