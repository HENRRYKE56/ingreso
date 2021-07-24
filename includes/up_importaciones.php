<?php

header('Content-Type: text/html; charset=iso-8859-1');
ini_set('upload_max_filesize', '900M');
ini_set('post_max_size ', '900M');
error_reporting(0);
include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
session_start();
$error = '';
$proceder = 0;

$array_folios = array();
$array_correctos = array();
$resultado = array();
$id_control_gasolinas = '';
if (sizeof($_FILES) > 0 and $_FILES['file']["error"] == "0") {
    $fileXTmp = $_FILES['file']["tmp_name"];
    $file_size = $_FILES['file']["size"];
    $file_type = $_FILES['file']["type"];
    $file_name = $_FILES['file']["name"];
//(1024*1024*10)      
    if ($file_size <= (1024 * 1024 * 900)) {//hasta 900 megas
        if ($file_type == 'text/plain') {
            if ($fileXTmp != "none") {
                $archivo = $_FILES['file'];
                if (!($fp = @fopen($fileXTmp, "rb"))) {
                    
                } else {
//                    $cveunidad = $__SESSION->getValueSession('cveunidad');
                    $cveusuario = $__SESSION->getValueSession('cveusuario');

                    $id_session = ((session_id() <> "") ? session_id() : rand(5642, 9826));
                    $microtime = microtime();
                    $ar_m = explode(" ", $microtime);
                    $n_ar = "im" . $cveusuario . "_" . date("Y_m_d_H_i_s") . "_" . $ar_m[1] . "_" . $file_name;
                    $fechas_i_f = date("Y-m-d H:i:s");


                    $direccion_file = FILE_SISTEMAS . "importaciones/epi_" . $cveusuario . "/";

                    $classconsulXtmp = new Entidad(array('status'), array(''));
                    $sql_insert = "INSERT INTO control_importaciones "
                            . "(fecha_ini, fecha_fin, nombre_archivo_origin, nombre_alter, cve_usuario,id_session,estatus_import,ruta) VALUES "
                            . "( '" . $fechas_i_f . "','" . $fechas_i_f . "' ,'" . $file_name . "','" . $n_ar . "',"
                            . $cveusuario . ",'" . ($id_session) . "',1,'" . $direccion_file . "')";
                    $classconsulXtmp->ExecuteQryDB($sql_insert);
                    //validar si el max llevaria en el where tipo de importacion

                    $num_c = '';
                    $classconsulx = new Entidad(array('num_c'), array(0));
                    $pcWhere = " select max(id_control_importaciones) num_c from control_importaciones where cve_usuario=" . $cveusuario . " and id_session='" . $id_session . "'";
                    $classconsulx->ListaEntidades(array(''), 'control_importaciones', '', '', 'no', '', $pcWhere);
                    if ($classconsulx->NumReg > 0) {
                        $classconsulx->VerDatosEntidad(0, array('num_c'));
                        $num_c = $classconsulx->num_c;
                    }

                    $linea = '';
                    $palabras_r = array("truncate", "alter table", "create table", "drop table", "alter database", "create database", "drop database", "rename table", "drop index", "delete", "insert into");
                    $sigue1 = true;
                    $linea_aux = array();
                    $contador_l = 0;
                    $columnas_nombres = "";

                    $classconsulx = new Entidad(array('tot_campos', 'columnas'), array('', ''));
                    $pcWhere = " select tot_campos,columnas from total_campos where id_total_campos=1 ";
                    $classconsulx->ListaEntidades(array(''), 'total_campos', '', '', 'no', '', $pcWhere);
                    if ($classconsulx->NumReg > 0) {
                        $classconsulx->VerDatosEntidad(0, array('tot_campos', 'columnas'));
                        $cantidad_c = $classconsulx->tot_campos;
                        $columnas_nombres = $classconsulx->columnas;
                    }
                    $linea_aux = array();
                    //empezar con el tratamiento del archivo
                    while (!feof($fp)) {
                        if ($contador_l <= 1) {

                            $cad_total = fgets($fp);

                            $cuenta = explode("|", $cad_total);
                            $cuenta = count($cuenta);


                            if ($cuenta * 1 == $cantidad_c + 0) {
                                
                            } else {
                                $linea_aux[] = $contador_l;
                                $sigue1 = false;
                                $error = '<table class="table table-hover" width="100%" style="text-align: center;"><tr><th style="backgrou nd-color: #F2DEDE;">Observaciones</th></tr><tr><th style="background-color: #F2DEDE;">Verificar contenido del archivo<br> El archivo deve contener filas con ' . $cantidad_c . ' columnas</th></tr></table>';
                            }
                        } else {
                            break;
                        }
                        $contador_l++;
                    }
                    fclose($fp);
                    if ($sigue1 && (mkdir($direccion_file, 0777, true) || file_exists($direccion_file))) {

                        if (!file_exists($direccion_file)) {
                            mkdir($direccion_file, 0777);
                        }
                        move_uploaded_file($fileXTmp, $direccion_file . $n_ar);

                        //limpiar tabla de paso
                        $query_import = " delete from `db_epi`.`tab_epi` where 1=1 ";
                        $classconsulXtmp = new Entidad(array('id_tab_epi'), array(''), 1);
                        $classconsulXtmp->ExecuteQryDB($query_import);



                        $terminated = '|';
                        $string_cmp = $columnas_nombres;

                        $query_import = "LOAD DATA LOCAL INFILE 
'" . $direccion_file . $n_ar . "' 
INTO TABLE `db_epi`.`tab_epi` 
CHARACTER SET latin1     
FIELDS TERMINATED BY '" . $terminated . "' 
LINES TERMINATED BY '\n' 
IGNORE 1 LINES 
(" . $string_cmp . ");";


                        $classconsulXtmp = new Entidad(array('id_tab_epi'), array(''), 1);
                        $classconsulXtmp->ExecuteQryDB($query_import);

                        $query_import = " INSERT INTO folios_anteriores
	(SECTOR, UNIDAD, FOLIO_SINAVE, APEPATER, APEMATER, NOMBRE, SEXO, MPIORESI, FECDEF, EDAD, OCUPACIO, FECINGRE, DIABETES, EPOC, ASMA, 
	INMUSUPR, HIPERTEN, VIH_SIDA, OTRACON, ENFCARDI, OBESIDAD, INSRENCR, TABAQUIS, FECHA_FOLIOS)
SELECT t.SECTOR, t.UNIDAD, t.FOLIO_SINAVE, t.APEPATER, t.APEMATER, t.NOMBRE, t.SEXO,t.MPIORESI, t.FECDEF, t.EDAD, t.OCUPACIO, t.FECINGRE, t.DIABETES, t.EPOC, t.ASMA, t.INMUSUPR, t.HIPERTEN, 
t.VIH_SIDA, t.OTRACON, t.ENFCARDI,t.OBESIDAD, t.INSRENCR, t.TABAQUIS,date_format(t.FECHA_ACTUAL,'%Y-%m-%d')AS FECHA_FOLIOS
FROM folios_anteriores f 
RIGHT JOIN tab_epi t ON f.FOLIO_SINAVE=t.FOLIO_SINAVE
WHERE t.ENTIDAD='MEXICO' AND t.EVOLUCI='DEFUNCION' AND t.RESDEFIN='SARS-CoV-2' AND f.FOLIO_SINAVE IS NULL; ";


                        $classconsulXtmp = new Entidad(array('id_folios_anteriores'), array(''), 1);
                        $classconsulXtmp->ExecuteQryDB($query_import);

                        $classconsul = new Entidad(array('FOLIO_SINAVE'), array(''),1);
                        $str_where = ' where  q1.FOLIO_SINAVE IS null AND f.CONTADO <> 1 AND f.ELIMINADO <> 1 ';
                        $classconsul->ListaEntidades(array('num_decimales'), " folios_anteriores f
LEFT JOIN 
(SELECT t.FOLIO_SINAVE
FROM tab_epi t
WHERE t.ENTIDAD='MEXICO' AND t.EVOLUCI='DEFUNCION' AND t.RESDEFIN='SARS-CoV-2')AS q1 ON f.FOLIO_SINAVE=q1.FOLIO_SINAVE ", $str_where, "f.FOLIO_SINAVE", 'no');
                        $f_sinave = array();
                        for ($i = 0; $i < $classconsul->NumReg; $i++) {
                            $classconsul->VerDatosEntidad($i, array('FOLIO_SINAVE'));
                            $f_sinave[] = ($classconsul->FOLIO_SINAVE);
                            
                            
                            $allfields = array('CONTADO');
                            $allvalues = array(1);
                            $array_typetxTmp = array('int');
                            $classent = new Entidad($allfields, $allvalues,1);
                            $classent->Modificar($allvalues, $allfields, $array_typetxTmp, ' folios_anteriores ', " FOLIO_SINAVE =" . ($classconsul->FOLIO_SINAVE));                            
                        }

                        if (count($f_sinave) > 0) {
                            $allfields = array('folio_inexistentes');
                            $allvalues = array(''. implode(",", $f_sinave));
                            $array_typetxTmp = array('char');
                            $classent = new Entidad($allfields, $allvalues);
                            $classent->Modificar($allvalues, $allfields, $array_typetxTmp, ' control_importaciones ', " id_control_importaciones =" . $num_c);
                        }

                        $proceder = 1;
                    } else {
                        $allfields = array('observaciones', 'estatus_import');
                        $allvalues = array('Verificar contenido del archivo, El archivo deve contener filas con ' . $cantidad_c . ' columnas en las lineas: ' . implode(', ', $linea_aux), 2);
                        $array_typetxTmp = array('char', 'int');
                        $classent = new Entidad($allfields, $allvalues);
                        $classent->Modificar($allvalues, $allfields, $array_typetxTmp, ' control_importaciones ', " id_control_importaciones =" . $num_c);
                    }
                }
            }
        } else {
            $error = '<table class="table table-hover" width="100%" style="text-align: center;"><tr><th style="backgrou nd-color: #F2DEDE;">Observaciones</th></tr><tr><th style="background-color: #F2DEDE;">Tipo de archivo no soportado</th></tr></table>';
        }
    } else {
        $error = '<table class="table table-hover" width="100%" style="text-align: center;"><tr><th style="backgrou nd-color: #F2DEDE;">Observaciones</th></tr><tr><th style="background-color: #F2DEDE;">Tamaño de archivo no soportado</th></tr></table>';
    }
} else {
    $error = '<table class="table table-hover" width="100%" style="text-align: center;"><tr><th style="background-color: #F2DEDE;">Observaciones</th></tr><tr><th style="background-color: #F2DEDE;">Tam de archivo no soportado</th></tr></table>';
}

echo json_encode(array('successful' => 'true', 'error_t' => $error, 'procede' => $proceder, 'lineas_e' => implode(', ', $linea_aux)));

function busca_reservadas($cadena, $ar_cadenas) {
    $sigue = true;
    for ($index = 0; $index < count($ar_cadenas); $index++) {
        $pos1 = stripos($cadena, $ar_cadenas);
        if ($pos1 !== false) {
            $sigue = false;
            break;
        }
    }
    return $sigue;
}

?>
                         