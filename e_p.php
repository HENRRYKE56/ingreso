<?php

$success = 'true';
$type = codifica(filter_input(INPUT_POST, 'type'));
if ($type == 'r_p') {
    try {
        include_once("config/cfg.php");
        include_once("lib/lib_pgsql.php");
        include_once("lib/lib_entidad.php");

        $user = addslashes(codifica(filter_input(INPUT_POST, 'user')));
        //consultar si existe correo
        $classconsul = new Entidad(array('email', 'des_usuario'), array(''));
        $classconsul->ListaEntidades(array('email'), 'sb_usuario', ' where nom_usuario = \'' . $user . '\'', ' email,des_usuario ', 'no');
        if ($classconsul->NumReg > 0) {//hay concidencia
            $estado_proceso = "1";
            if ($classconsul->NumReg == 1) {
                $classconsul->VerDatosEntidad(0, array('email', 'des_usuario'));
                $nombre = $classconsul->des_usuario;
                $email = $classconsul->email;
                $con_pass = $nombre[0] . "_" . generar_password(($nombre)) . "";
                $asunto = "Usuario de Acceso " . $CFG_TITLE;
                $tabla_cita = "<html><body><div id='flip-scroll' style='margin: 0 auto;' class='widget-content nopadding'><p>" . $asunto . "</p><p>" . $nombre . "</p>
<table style='left:0px;' width='100%' class='table-bordered table-striped table-hover table-condensed cf'>
<thead class='cf'>
    <tr><th>Usuario:</th><th>" . $user . "</th></tr>
</thead>
<tbody>
    <tr><th>Password:</th><th>" . $con_pass . "</th></tr>
    <tr><th>Liga de acceso:</th><th><a href='".$direccion_s."'>".$direccion_s."</a></th></tr>
</tbody>
</table></div></body></html>";

                $reg_en = envia_correo($email, $tabla_cita, $asunto, $nombre);
                if ($reg_en) {
                    $array_namesxTmp = array('recuperado');
                    $array_typetxTmp = array('int');
                    $array_valuesxTmp = array(1);
                    $classent = new Entidad(array('recuperado'), array(''));
                    $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, ' sb_usuario ', " nom_usuario ='" . $user . "'");
                }
                $allfields = array('passwd');
                $atypes = array('char');
                $allvalues = array($con_pass);
                $classent = new Entidad($allfields, $allvalues);
                $classent->Modificar($allvalues, $allfields, $atypes, 'sb_usuario', " nom_usuario = '" . $user . "'");
            } else {
                $estado_proceso = "2"; //no hay concidencia
            }
        } else {
            //generar contraseña
            $estado_proceso = "2"; //no hay concidencia
        }
    } catch (Exception $ex) {
        $success = "false";
    }
    echo json_encode(array('successful' => $success, 'estado' => $estado_proceso));
}

function generar_password($cadena) {
    $con_pass = "";
    for ($index = 0; $index < (strlen($cadena) > 6 ? 6 : strlen($cadena)); $index++) {
        $con_pass.=ord($cadena[$index]);
    }
    $con_pass = $con_pass * 1;
    $con_pass = dechex($con_pass);
    return ($con_pass);
}

function codifica($cad) {
    return utf8_decode($cad);
}
