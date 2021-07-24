<?php

session_start();
include_once("../config/cfg.php");

if (strlen($__SESSION->getValueSession('cveperfil')) > 0 && strlen($__SESSION->getValueSession('mod')) > 0) {

    include_once("../lib/lib_pgsql.php");
    include_once("../lib/lib_entidad.php");
    include_once("../rep/lib/lib32.php");
//	$field[]=array('cve_perfil','perfil_modulo','0',0);
//	$field[]=array('cve_modulo','perfil_modulo','1',"");
//	$field[]=array('key_modulo','perfil_modulo','1',"");
//	$allf=array();
//	$allv=array();
//	$IdPrin='cve_modulo';
//	$tabla='perfil_modulo,modulo';
//	$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
//	$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
//	$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
//	$strWhere.=" and modulo.sta_modulo<>0";
//	$classval = new Entidad($allf,$allv);
//	$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
//	$str_valmodulo="MOD_NOVALIDO";
//	if ($classval->NumReg>0){

    if (isset($_GET['rowid']) && strlen(trim($_GET['rowid'])) > 10) {
        $strrowid = substr($_GET['rowid'], 5, (strlen($_GET['rowid']) - 5));
        $a_rowidXtmp = explode("::", base64_decode($strrowid));
        $a_rowid = array();
        foreach ($a_rowidXtmp as $value_x) {
            $a_item_rowid = explode("=", $value_x);
            if (sizeof($a_item_rowid) == 2)
                $a_rowid[$a_item_rowid[0]] = $a_item_rowid[1];
        }
        if (sizeof($a_rowid) == 2 && array_key_exists("cve_usuario", $a_rowid) && array_key_exists("file_get", $a_rowid)) {

            $a_fields_get = array();
            $a_fields_get_type = array();
            $a_tables_get = array();

            /* modificar arreglos de acuerdo a lo que se defina en solucion */

            $a_fields_get['img_usuario'] = array('cve_usuario'); //file_get
            $a_fields_get_type['img_usuario'] = array('text'); //text, num
            $a_tables_get['img_usuario'] = 'sb_foto_usuario'; //file_get






            $strWhereValues = "";


            $boolParameters = true;
            foreach ($a_fields_get[$a_rowid['file_get']] as $cont => $item) {
                if (strlen(trim($a_rowid[$item])) == 0) {
                    $boolParameters = false;
                    break;
                }
                if (strlen($strWhereValues) > 0)
                    $strWhereValues.=" and ";
                if ($a_fields_get_type[$a_rowid['file_get']][$cont] == 'num') {
                    $strWhereValues.= $item . "=" . $a_rowid[$item];
                } else {
                    $strWhereValues.= $item . "='" . $a_rowid[$item] . "'";
                }
            }
            if ($boolParameters) {
                $classent = new Entidad(array('file_type', 'content_file', 'file_name'), array('', '', ''));
                $classent->ListaEntidades(array(), "", "", "", "no", "", "select file_type, content_file, file_name from " . $a_tables_get[$a_rowid['file_get']] . " where " . $strWhereValues);
                if ($classent->NumReg > 0) {
                    $fila = mysqli_fetch_array($classent->Con->RtaSql);
                    $tipo =$fila['file_type'];
                    $contenido =$fila['content_file'];
                    $nombre =$fila['file_name'];
                    header("Content-type: " . $tipo);
                    header("Content-Disposition: ; filename=\"" . $nombre . "\"");
                    print $contenido;
                } else {
                    $tipo = "image/png";
                    header("Content-type: " . $tipo);
                    header("Content-Disposition: ; filename=\"_foto");
                    echo readfile("../images/usuario_img.png");
                }
            } else {
                header("HTTP/1.0 404 Not Found");
            }
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    } else {
        header("HTTP/1.0 404 Not Found");
    }
} else {
    header("HTTP/1.0 404 Not Found");
}
?>
