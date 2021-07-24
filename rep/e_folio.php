<?php

$success = 'true';
$type = codifica(filter_input(INPUT_POST, 'type'));
//echo '<pre>';
//print_r($_POST);die();
if ($type == 'a_f') {
    try {
        include_once("../config/cfg.php");
        include_once("../lib/lib_pgsql.php");
        include_once("../lib/lib_entidad.php");

        $val_folios = addslashes(codifica(filter_input(INPUT_POST, 'val')));
        $ar_folios = explode("_", $val_folios);
        if (count($ar_folios) > 0) {
            $array_namesxTmp = array('ELIMINADO');
            $array_typetxTmp = array('int');
            $array_valuesxTmp = array($ar_folios[1]);
            $classent = new Entidad(array('ELIMINADO'), array(''),1);
            $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, ' folios_anteriores ', " FOLIO_SINAVE =" . $ar_folios[0]);
        }
    } catch (Exception $ex) {
        $success = "false";
    }
    echo json_encode(array('successful' => $success));
}

function generar_password($cadena) {
    $con_pass = "";
    for ($index = 0; $index < (strlen($cadena) > 6 ? 6 : strlen($cadena)); $index++) {
        $con_pass .= ord($cadena[$index]);
    }
    $con_pass = $con_pass * 1;
    $con_pass = dechex($con_pass);
    return ($con_pass);
}

function codifica($cad) {
    return utf8_decode($cad);
}
