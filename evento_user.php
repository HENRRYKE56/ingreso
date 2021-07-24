<?php

session_start();
$success = 'true';
$estado_proceso = 0;
$mensaje = "";
header('Content-Type: text/html; charset=UTF-8"');
try {
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    if (isset($_POST['txtnomusuario']) && isset($_POST['txtpasswd']) && isset($_POST['hidlogin']) && isset($_POST['hid_login'])) {
        if (!is_null($_POST['txtnomusuario']) && !is_null($_POST['txtpasswd']) && !is_null($_POST['hidlogin'])) {
            if (strlen(trim($_POST['txtnomusuario'])) > 0 && strlen(trim($_POST['txtpasswd'])) > 0 && strlen(trim($_POST['hidlogin'])) > 0) { //						&& (trim($_POST['a_year'])*1)>0
                if (intval($_POST['hidlogin']) >= 0 && intval($_POST['hidlogin'] <= 2)) {
                    if (fnIdentifyOldSession($_POST['hid_login'])) {
                        $$IdPrin = $_POST['txtnomusuario'];
                        $pwd = md5($_POST['txtpasswd']);
                        //$aa_year=(trim($_POST['a_year'])*1);
                        $numLogin = $_POST['hidlogin'] + 1;
                        $tabla = 'sb_perfil_usuario pu,sb_perfil p, sb_usergroup g,sb_usuario u';
                        $strWhere = "Where u.nom_usuario='" . $$IdPrin . "'";
                        $strWhere .= " and u.sta_usuario <> 0";
                        $strWhere .= " and u.passwd = '" . ($pwd) . "'";
                        $strWhere .= " and u.cve_usuario = pu.cve_usuario";
                        $strWhere .= " and p.cve_perfil = pu.cve_perfil";
                        $strWhere .= " and p.sta_perfil <> 0";
//					$strWhere.=" and usuario.int_ref = personal.cvepersonal";
                        $strWhere .= " and u.cve_usergroup = g.cve_usergroup";
                        //$strWhere.=" and u.cve_medico=m.cve_medico";
//					$strWhere.=" and usergroup.cveArea = area.cveArea";
                        $strWhere = "select u.cve_usuario, u.des_usuario, u.nom_usuario, u.sta_usuario, u.passwd, u.cve_usergroup," .
                                " p.des_perfil, p.cve_perfil, g.cveuni, g.cve_jurisdiccion from " . $tabla . " " . $strWhere;
                        $classval = new Entidad($allf, $allv);
                        $classval->Set_Item($IdPrin, $$IdPrin);
                        $classval->Consultar($allf, $IdPrin, $tabla, '', $strWhere);
//                        echo '<pre>';
//                        print_r($classval);die();

                        $str_gets = "";
                        if ($classval->NumReg > 0) {
                            if ($classval->NumReg == 1) {
                                $estado_proceso = 1;
							
                            }
                        } else {
                            //usuarios repetido
                            $mensaje = "Usuario y/o clave incorrecto";
                        }
                    } else {
                        // ya hay session activa
                        $mensaje = "Usuario y/o clave y/o a&ntilde; incorrecto";
                    }
                } else {
                    $mensaje = "Usuario y/o clave y/o a&ntilde; incorrecto";
                }
            } else {//que las cadenas sen mayores a 0
                $mensaje = "Usuario y/o clave y/o a&ntilde; incorrecto";
            }
        } else {//no null
            $mensaje = "Usuario y/o clave y/o a&ntilde; incorrecto";
        }
    } else {//existan credenciales
        $mensaje = "Usuario y/o clave y/o a&ntilde; incorrecto";
    }
} catch (Exception $ex) {
    $success = "false";
}
echo json_encode(array('successful' => $success, 'estado' => $estado_proceso, 'mensaje' => $mensaje));

function fnIdentifyOldSession($id_sess) {
//		echo session_id(); die();
    $retVal = false;
    $classent = new Entidad(array('idmax'), array(0));
    $classent->Consultar(array('idmax'), '', '', '', "Select if(max(cve_audit_session) is null,-1,max(cve_audit_session)) as idmax from sb_audit_session where status_session=1 and id_session='" . $id_sess . "'");
    $retVal = ($classent->idmax == "" ? true : false);
    $retVal = true;
    if (($classent->idmax) * 1 == -1) {
        if (isset($_SESSION[_CFGSBASE]))
            unset($_SESSION[_CFGSBASE]);
        $array_valuesxTmp = array(0);
        $array_namesxTmp = array('status_session');
        $array_typetxTmp = array('int');
        $array_defaultxTmp = array('0');
        $classent = new Entidad($array_namesxTmp, $array_defaultxTmp);
        $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_audit_session', " status_session=1 and id_session='" . $id_sess . "'");
    }
    return $retVal;
}
