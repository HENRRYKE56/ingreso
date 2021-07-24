<?php

$success = 'true';
$estado_proceso = "0";
header('Content-Type: text/html; charset=UTF-8"');
try {
    $ar_errores = array();
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
//    echo '<pre>';
//    print_r($_POST);
//    die();
    $sexo = addslashes(codifica(filter_input(INPUT_POST, 'sexo')));
    //$desArea = addslashes(codifica(filter_input(INPUT_POST, 'desArea')));
    $cveArea = addslashes(codifica(filter_input(INPUT_POST, 'cveArea')));
    $entidad = addslashes(codifica(filter_input(INPUT_POST, 'entidad')));
    $antiguedad = addslashes(codifica(filter_input(INPUT_POST, 'antiguedad')));
    $direccion_i = addslashes(codifica(filter_input(INPUT_POST, 'ds')));
    $sigue = true;
    if ($sexo == "")
        $ar_errores['sexo'] = 'false';
//    if ($desArea == "")
//        $ar_errores['desArea'] = 'false';
    if ($cveArea == "")
        $ar_errores['cveArea'] = 'false';
    if ($entidad == "")
        $ar_errores['entidad'] = 'false';
    if ($antiguedad == "")
        $ar_errores['antiguedad'] = 'false';
    if ($direccion_i == "")
        $ar_errores['ds'] = 'false';
    foreach ($ar_errores as $key => $value) {
        if ($value == 'false') {
            $sigue = false;
            break;
        }
    }
    $array_colum = array('cvePregunta', 'numPregunta');
    $classconsul = new Entidad($array_colum, array('', ''));
    $classconsul->ListaEntidades(array('(p.numPregunta*1)'), 'pregunta p', ' WHERE p.staPregunta=1  ', " p.cvePregunta,p.numPregunta ", '');

    $arreglo_preg = array();
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, $array_colum);
        $arreglo_preg[$classconsul->numPregunta] = $classconsul->numPregunta;
        $resul_a=buscar_top($classconsul->numPregunta, $_POST);
        $resul = implode(',', $resul_a);
        foreach ($resul_a as $key => $value) {
            if ($value == 'false') {
                $sigue = false;
            }
        }
        $ar_errores[$classconsul->numPregunta] = (count($resul) > 1 ? implode(",", $resul) : $resul);
    }
//    echo '<pre>';
//    print_r($ar_errores);die();
    if (!$sigue) {
        $estado_proceso = 2;
    } else {
        $cveunico = $direccion_i . microtime(true);
        $allfields = array('sexo', 'desArea', 'cveArea', 'entidad', 'antiguedad', 'direccion_i', 'cveunica', 'staPersona');
        $atypes = array('int', 'char', 'char', 'int', 'int', 'char', 'char', 'int');
        $allvalues = array($sexo, $desArea, $cveArea, $entidad, $antiguedad, $direccion_i, $cveunico, $staPersona);
        $classent = new Entidad($allfields, $allvalues);
        $classent->Adicionar($allvalues, $allfields, $atypes, 'persona');
        //consultarcve_persona
        $classconsul = new Entidad(array('cvePersona'), array(''));
        $classconsul->ListaEntidades(array('cvePersona'), 'persona', ' where cveunica = \'' . $cveunico . '\'', ' cvePersona ', 'no');
        if ($classconsul->NumReg == 1) {
            $allfields_1 = array('cvePersona');
            $classconsul->VerDatosEntidad(0, $allfields_1);
            $cve_Persona = $classconsul->cvePersona;
            $cvetipoCuestionario = 1;
            $allfields = array('cvePersona', 'cvetipoCuestionario', 'staCuestionario');
            $atypes = array('int', 'int', 'int');
            $allvalues = array($cve_Persona, $cvetipoCuestionario, 1);
            $classent = new Entidad($allfields, $allvalues);
            $classent->Adicionar($allvalues, $allfields, $atypes, 'cuestionario');

            $classconsul = new Entidad(array('cveCuestionario'), array(''));
            $classconsul->ListaEntidades(array('cveCuestionario'), 'cuestionario', ' where cvePersona = ' . $cve_Persona, ' cveCuestionario ', 'no');
            $classconsul->VerDatosEntidad(0, array('cveCuestionario'));
            $cveCuestionario = $classconsul->cveCuestionario;
            $contador = 1;
//            echo '<pre>';
//            print_r($_POST);die();
            foreach ($_POST as $key => $value) {
                if ($contador > 6) {
                    $campo_cmp="";
                    $var_k_l=  explode("_", $key);
                    if(is_array($var_k_l)){
                        $campo_cmp=$var_k_l[1];
                    }
                    if ($campo_cmp <> 'ca') {
                        $v_v = explode("_", $value); //$sub_a['cvePregunta']."_".$sub_a['numPregunta']."_".$sub_a['cveRespuesta']."_".$sub_a['abrRespuesta']
                        $otros_res = '';
                        if ($v_v[1] == '12') {
                            $otros_res = isset($_POST['12_ca']) ? $_POST['12_ca'] : '';
                        } else if ($v_v[1] == '15') {
                            $otros_res = isset($_POST['15_ca']) ? $_POST['15_ca'] : '';
                        }

                        $allfields = array('cveCuestionario', 'cvePregunta', 'cveRespuesta', 'otros_res');
                        $atypes = array('int', 'int', 'int', 'char');
                        $allvalues = array($cveCuestionario, $v_v[0], $v_v[2], $otros_res);
                        $classent = new Entidad($allfields, $allvalues);
                        $classent->Adicionar($allvalues, $allfields, $atypes, 'detcuestionario');
                    }
                }
                $contador++;
            }
            $estado_proceso = 1;
        } else {
            $estado_proceso = 3;
        }
    }
} catch (Exception $ex) {
    $success = "false";
}
echo json_encode(array('successful' => $success, 'estado' => $estado_proceso, 'a_c_e' => $ar_errores));

function buscar_top($p, $a_post) {
    $reg = array();
    foreach ($a_post as $key => $value) {
        $pre_r = explode('_', $value);
        if ($p == $pre_r[1]) {
            $reg[] = 'true';
            if ($p == '12') {
                if (isset($a_post['12_ca']) && $a_post['12_ca'] <> '') {
                    $reg[] = 'true';
                    break;
                } else {
                    $reg[] = 'false';
                    break;
                }
            } else if ($p == '15') {
                if (isset($a_post['15_47']) && $a_post['15_47'] <> '') {
                    $reg[] = 'true';
                    if (isset($a_post['15_ca']) && $a_post['15_ca'] <> '') {
                        $reg[] = 'true';
                        break;
                    } else {
                        $reg[] = 'false';
                        break;
                    }
                }
            }
        }
    }
    if (count($reg) > 0) {
        
    } else {
        $reg[] = 'false';
    }
    return $reg;
}

function codifica($cad) {
    return utf8_decode($cad);
}
