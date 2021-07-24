<?php

if (strlen(session_id()) == 0) {
    session_start();
    include_once("config/cfg.php");
} else {
    include_once("config/cfg.php");
}//if (isset($_SESSION[_CFGSBASE]))unset($_SESSION[_CFGSBASE]);
/* -------------------------------------------------------
  -------------------------------------------------------
  Principal - Index.php
 */
include_once("lib/lib_function.php");
//include_once("config/cfg.php");

if (isset($_POST['hidlogin']) && !is_null($_POST['hidlogin'])) {
    unset($_SESSION[_CFGSBASE]);

    //$_SESSION[_CFGSBASE]=array();
    //Destruye todas las variables de la sesi&oacute;n
    //session_destroy();
    //if(strlen(session_id())==0)session_start();
    //session_start();
}
//echo '<pre>';
//print_r($_POST);die();

if ($__SESSION->getValueSession('nomusuario') == "" || $__SESSION->getValueSession('passwd') == "") {
    $str_login = "";
    $str_gets = "";
    include_once("includes/sb_acceso.php");
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO_8859_5\" />
<title>" . $CFG_TITLE . "</title>
</head>";

    echo "<body topmargin=\"0\" leftmargin=\"0\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilo.css\" />";
    $str_refresh = "pag_login.php" . $str_gets;
    switch ($str_login) {
        case 'SESSION_00':

            //session_start();
            $_SESSION[_CFGSBASE] = array();
            $__SESSION->setValueSession('cveusuario', $classval->cve_usuario);
            $__SESSION->setValueSession('nomusuario', $classval->nom_usuario);
            $__SESSION->setValueSession('desusuario', $classval->des_usuario);
            $__SESSION->setValueSession('desperfil', $classval->des_perfil);
            $__SESSION->setValueSession('passwd', $classval->passwd);
            $__SESSION->setValueSession('cveperfil', $classval->cve_perfil);
            $__SESSION->setValueSession('cveusergroup', $classval->cve_usergroup);
            $__SESSION->setValueSession('cveunidad', $classval->cveuni);
            $__SESSION->setValueSession('id_area', $classval->id_area);
            $__SESSION->setValueSession('color_menu', $classval->color_menu);
            $__SESSION->setValueSession('color_f', $classval->color_f_menu);
            $__SESSION->setValueSession('f_s', $classval->f_size_menu);
            $__SESSION->setValueSession('f_l', $classval->f_size_label);
            $__SESSION->setValueSession('m_active', $classval->m_active99);
            
            $__SESSION->setValueSession('cvetap', $classval->cve_tap);
            $__SESSION->setValueSession('cvejurisdiccion', $classval->cve_jurisdiccion);
            $__SESSION->setValueSession('cvecoordinacion', $classval->cve_coordinacion);
            $__SESSION->setValueSession('cvemunicipio', $classval->cve_municipio);
            $__SESSION->setValueSession('theme', $classval->theme);

            fnInitSession($classval);
            $str_refresh = "index.php";
            break;
        case 'NOTHING':
            $str_msg_red = 'ACCESO NO VALIDO';
            include_once("includes/sb_msg_red.php");
            break;
        case 'DATOS_INT';
            $str_msg_red = 'INTENTOS EXCEDIDOS';
            include_once("includes/sb_msg_red.php");
            break;
        case 'DATOS_INC':
            $str_msg_red = 'DATOS INCOMPLETOS';
            include_once("includes/sb_msg_red.php");
            break;
    }
//echo '<pre>';
//print_r($__SESSION->getAll());               
    echo "<meta http-equiv='refresh' content='0;URL=" . $str_refresh . "'>";
    echo "</body>";
} else {

    if (isset($_POST['hididen']) && !is_null($_POST['hididen'])) {
        if (isset($_POST['cmbperfil']) && !is_null($_POST['cmbperfil'])) {
            if (isset($_POST['btnAcceptar'])) {
                //$_SESSION['cveperfil']=$_POST['cmbperfil'];
            } else {
                if (isset($_POST['btnCancelar'])) {
                    $str_msg_red = 'INICIO DE SESION CANCELADA';
                } else {
                    $str_msg_red = 'SESION INVALIDA';
                }
                echo "<body topmargin=\"0\" leftmargin=\"0\">";
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilo.css\" />";
                include_once("includes/sb_msg_red.php");
                $str_refresh = "pag_login.php";
                echo "<meta http-equiv='refresh' content='0;URL=" . $str_refresh . "'>";
                echo "</body>";
            }
        }
    }

    include_once("includes/sb_valusu.php");
    switch ($str_session) {
        case 'SIN_SESSION':
            $str_msg_red = 'NO SE PUDO INICIAR UNA SESION';
            break;
        case 'SIN_DATOS':
            $str_msg_red = 'SESION NO VALIDA';
            break;
    }
    if ($str_session == 'SESSION_OK') {
        include_once("wprincipal.php");
    } else {
        echo "<body topmargin=\"0\" leftmargin=\"0\">";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilo.css\" />";
        include_once("includes/sb_msg_red.php");
        $str_refresh = "pag_login.php";
        echo "<meta http-equiv='refresh' content='0;URL=" . $str_refresh . "'>";
        echo "</body>";
    }
}
echo "</html>";

function fnInitSession($obj) {

    $array_valuesxTmp = array(0);
    $array_namesxTmp = array('status_session');
    $array_typetxTmp = array('int');
    $array_defaultxTmp = array('0');
    $classent = new Entidad($array_namesxTmp, $array_defaultxTmp);
    $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_audit_session', " cve_usuario=" . $obj->cve_usuario .
            " and cve_perfil=" . $obj->cve_perfil . " and id_session='" . session_id() . "'");
    $array_valuesxTmp = array(((session_id() <> "") ? session_id() : rand(5642, 9826)), $obj->cve_usuario, $obj->cve_perfil, $obj->nom_usuario, 1, date('Y-m-d H:i:s'));
    $array_namesxTmp = array('id_session', 'cve_usuario', 'cve_perfil', 'nom_usuario', 'status_session', 'fecha_inicio');
    $array_typetxTmp = array('char', 'int', 'int', 'char', 'char', 'char');
    $array_defaultxTmp = array('0', '0', '0', 'anonymous', '0', date('Y-m-d H:i:s'));
    $classent = new Entidad($array_namesxTmp, $array_defaultxTmp);
    $classent->Adicionar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_audit_session');
}


?>