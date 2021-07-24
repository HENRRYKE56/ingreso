<?php

session_start();
$success = 'true';
$estado_proceso = 0;
$mensaje = "";
header('Content-Type: text/html; charset=UTF-8"');
$us_p = "";
try {
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");

    if (isset($_POST['txtnomusuario']) && isset($_POST['hidlogin']) && isset($_POST['hid_login'])) {
        if (!is_null($_POST['txtnomusuario']) && !is_null($_POST['hidlogin'])) {
            if (strlen(trim($_POST['txtnomusuario'])) > 0 && strlen(trim($_POST['hidlogin'])) > 0) {
                if (intval($_POST['hidlogin']) >= 0 && intval($_POST['hidlogin'] <= 2)) {
                    if (fnIdentifyOldSession($_POST['hid_login'])) {

                        $$IdPrin = addslashes($_POST['txtnomusuario']);
                        $pwd = $_POST['txtnomusuario'];
                        //$aa_year=(trim($_POST['a_year'])*1);
                        $numLogin = $_POST['hidlogin'] + 1;
                        $tabla = 'sb_perfil_usuario pu,sb_perfil p, sb_usergroup g,sb_usuario u';
                        $strWhere = "Where u.nom_usuario='" . $$IdPrin . "'";
                        $strWhere.=" and u.sta_usuario <> 0";
                        $strWhere.=" and u.passwd = '" . md5($pwd) . "'";
                        $strWhere.=" and u.cve_usuario = pu.cve_usuario";
                        $strWhere.=" and p.cve_perfil = pu.cve_perfil";
                        $strWhere.=" and p.sta_perfil <> 0 and u.cve_usergroup=1973";
//					$strWhere.=" and usuario.int_ref = personal.cvepersonal";
                        $strWhere.=" and u.cve_usergroup = g.cve_usergroup";
                        //$strWhere.=" and u.cve_medico=m.cve_medico";
//					$strWhere.=" and usergroup.cveArea = area.cveArea";
                        $strWhere = "select u.cve_usuario, u.des_usuario, u.nom_usuario, u.sta_usuario, u.passwd, u.cve_usergroup," .
                                " p.des_perfil, p.cve_perfil, g.cveuni, g.cve_jurisdiccion from " . $tabla . " " . $strWhere;
                        $classval = new Entidad($allf, $allv);
                        $classval->Set_Item($IdPrin, $$IdPrin);
                        $classval->Consultar($allf, $IdPrin, $tabla, '', $strWhere);
                        $str_gets = "";
                        if ($classval->NumReg > 0) {
                            if ($classval->NumReg == 1) {
                                $estado_proceso = 1;
                                $us_p = $_POST['txtnomusuario'];
                            }
                        } else {
//                        echo 'sip<pre>';
//                        print_r($classval);die();                            
                            $allfields = array('nom_usuario', 'des_usuario', 'passwd', 'sta_usuario', 'cve_usergroup', 'email');
                            $atypes = array('char', 'char', 'char', 'int', 'int', 'char');
                            $allvalues = array(addslashes($_POST['txtnomusuario']), (addslashes($_POST['txtnomusuario'])), (addslashes($_POST['txtnomusuario'])), 1, 1973, '');
                            $classent = new Entidad($allfields, $allvalues);
                            $classent->Adicionar($allvalues, $allfields, $atypes, 'sb_usuario');
                            $classconsul = new Entidad(array('cve_usuario'), array(''));
                            $classconsul->ListaEntidades(array('cve_usuario'), 'sb_usuario', ' where nom_usuario = \'' . (addslashes($_POST['txtnomusuario'])) . '\'', ' cve_usuario ', 'no');
                            //inserta perfil usuario
                            if ($classconsul->NumReg == 1) {
                                $allfields = array('cve_perfil', 'cve_usuario');
                                $classconsul->VerDatosEntidad(0, $allfields);
                                $atypes = array('int', 'int');
                                $cve_us=$classconsul->cve_usuario;
                                $allvalues = array(565, $cve_us);
                                $classent = new Entidad($allfields, $allvalues);
                                $classent->Adicionar($allvalues, $allfields, $atypes, 'sb_perfil_usuario');
                                $estado_proceso = 1;
                                $us_p = $_POST['txtnomusuario'];

                                $classconsul = new Entidad(array('cve_persona'), array(''));
                                $classconsul->ListaEntidades(array('cve_persona'), 'persona', ' where curp = \'' . (addslashes($_POST['txtnomusuario'])) . '\'', ' cve_persona ', 'no');
                                //inserta perfil usuario
                                $cve_persona = '';
                                if ($classconsul->NumReg == 1) {
                                    $classconsul->VerDatosEntidad(0, array('cve_persona'));
                                    $allfields = array('cve_persona', 'estatus','observacion','cve_usuario','id_session');
                                    $atypes = array('int', 'int','char','int','char');
                                    $allvalues = array($classconsul->cve_persona,1,'Se crea persona',$cve_us,'1111');
                                    $classent = new Entidad($allfields, $allvalues);
                                    $classent->Adicionar($allvalues, $allfields, $atypes, 'estatus_persona');
                                }
                            }
                        }
                    } else {
                        // ya hay session activa
                        $mensaje = "NO SE PUEDE REALIZAR EL REGISTRO";
                    }
                } else {
                    $mensaje = "NO SE PUEDE REALIZAR EL REGISTRO";
                }
            } else {//que las cadenas sen mayores a 0
                $mensaje = "NO SE PUEDE REALIZAR EL REGISTRO";
            }
        } else {//no null
            $mensaje = "NO SE PUEDE REALIZAR EL REGISTRO";
        }
    } else {//existan credenciales
        $mensaje = "NO SE PUEDE REALIZAR EL REGISTRO";
    }
} catch (Exception $ex) {
    $success = "false";
}
echo json_encode(array('successful' => $success, 'estado' => $estado_proceso, 'mensaje' => $mensaje, 'd_t' => $us_p));

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
