<?php

$field[] = array('cve_perfil', 'perfil_modulo', '0', 0);
$field[] = array('cve_modulo', 'perfil_modulo', '1', "");
$field[] = array('key_modulo', 'perfil_modulo', '1', "");
$allf = array();
$allv = array();
foreach ($field as $afield) {
    $allf[] = $afield[0];
    $allv[] = $afield[3];
}
$IdPrin = '';
$where_entrar = " and sb_perfil_modulo.cve_modulo=" . $__SESSION->getValueSession('mod') . "";
$tabla = 'sb_perfil_modulo,sb_modulo';
$strWhere = "Where sb_perfil_modulo.cve_perfil=" . $__SESSION->getValueSession('cveperfil');
$strWhere .= $where_entrar;
$strWhere .= " and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
$strWhere .= " and sb_modulo.sta_modulo<>0";
$classval = new Entidad($allf, $allv);
$classval->Consultar($allf, $IdPrin, $tabla, $strWhere);
$str_valmodulo = "MOD_NOVALIDO";
//die(" lis tado"); 
//echo '<pre>';
//print_r($classval);die();
if ($classval->NumReg > 0) {
    $str_valmodulo = "MOD_VALIDO";
    $a_key = explode(',', $classval->key_modulo);
    $nombre = "Reporte de conciliaci&oacute;n";
    $desc_vehiculo = "";
    $unidad = "";
    $agrupado = array();


    $fechaInicio = "2021-01-28";
    $fechaFin = "" . date("Y-m-d");
    $tiempoInicio = strtotime($fechaInicio);
    $tiempoFin = strtotime($fechaFin);
    $dia = 86400;
    $arreglo_dias = array();
    while ($tiempoInicio <= $tiempoFin) {
        $fechaActual = date("Y-m-d", $tiempoInicio);
        $arreglo_dias[] = $fechaActual;
        $tiempoInicio += $dia;
    }
    
    $classconsul = new Entidad(array('fecha_dato'), array('', ''));
    $classconsul->ListaEntidades(array('fecha_dato'), 'master_datos');
    $fechas_a_procesar = array();
    $fecha_ya_insert = array();
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('fecha_dato'));
        $fecha_ya_insert[] = $classconsul->fecha_dato;
    }
    if ($fecha_ya_insert > 0) {
        for ($index = 0; $index < count($arreglo_dias); $index++) {
            if (!in_array($arreglo_dias[$index], $fecha_ya_insert)) {
                $fechas_a_procesar[] = $arreglo_dias[$index];
            }
        }
    } else {
        $fechas_a_procesar = $arreglo_dias;
    }
    $name_archivo = "ContactosCovid19EdoMex.csv";
    if (count($fechas_a_procesar) > 0) {
        $connection = ssh2_connect('ddsisem.edomex.gob.mx', 2021);
        ssh2_auth_password($connection, 'tdelacruz', 'T@mas2021');
        $sftp = ssh2_sftp($connection);
    }
    $cveusuario = $__SESSION->getValueSession('cveusuario');
    $id_session = ((session_id() <> "") ? session_id() : rand(5642, 9826));
    $_TABLE_LOAD = 'datos_sei';

    for ($index1 = 0; $index1 < count($fechas_a_procesar); $index1++) {
        $name_archivo_real = str_replace("-", "", $fechas_a_procesar[$index1]) . $name_archivo;
        //241die("f dsf ds fds ".$name_archivo_real);
        $stream = fopen("ssh2.sftp://$sftp/" . $name_archivo_real, 'r');
        if (!$stream) {
            
        } else {
            $allfields3 = array('fecha_dato', 'cve_usuario', 'id_session');
            $atypes3 = array('char', 'num', 'char');
            $allvalues3 = array($fechas_a_procesar[$index1], $cveusuario, $id_session);
            $classent3 = new Entidad($allfields3, $allvalues3);
            $classent3->Adicionar($allvalues3, $allfields3, $atypes3, 'master_datos');
            // empieza importacion
            $cont_lines = 0;
            $cont_insert = 0;
            $_FIELDS_LOAD = array(
                'key_sei'
                , 'telefono'
                , 'fecha_visita'
                , 'hora_visita'
                , 'fechreg'
                , 'clave_scian'
                , 'nombre_sucursal'
            );
            $fields = '`key_sei`,'
                    . 'telefono,'
                    . 'fecha_visita,'
                    . 'hora_visita,'
                    . 'fechreg,'
                    . 'clave_scian,'
                    . 'nombre_sucursal,';
            $_MAX_LEN = array(
                '0' => 50,
                '1' => 50,
                '2' => 50,
                '3' => 50,
                '4' => 50,
                '5' => 50,
                '6' => 2000
            );


            $rc = 0;
            $start_row = 1;
            // die("sales ");
            while ($data = fgetcsv($stream, (1024 * 1024 * 900), ",")) {
//                echo '<pre>';
//                print_r($_FIELDS_LOAD);
//                die();
                if ($rc < $start_row) {
                    $rc++; // se pasa la cabecera
                } else {
                    $values = array();
                    if (count($data) == count($_FIELDS_LOAD)) {
                        for ($i = 0; $i < count($data); $i++) {
                            //  If data is wanted, put data into array                      
                            if (array_key_exists($i, $_FIELDS_LOAD)) {

                                // Insercion de datos en el aarreglo de valores
                                $values[$_FIELDS_LOAD[$i]] = substr(trim(str_replace(array('á', 'ó', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', chr(hexdec('A0')), chr(hexdec('D1'))), array('A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', ' ', "Ñ"), $data[$i])), 0, $_MAX_LEN[$i]);
                            }
                        }
                        $batch[] = '("' . implode('", "', str_replace('"', '\"', $values)) . '"' . ',\'' . $fechas_a_procesar[$index1] . '\',' . $cveusuario . ',\'' . $id_session . '\')';
                        if ($cont_lines == 1000) {
                            $sql = 'INSERT INTO `' . $_TABLE_LOAD . '` (' . $fields . '`fecha_master_datos`,`cve_usuario`,`id_session`) VALUES ' . implode(', ', $batch);
                            $classconsulXtmp = new Entidad(array('key_sei'), array(''));
                            $classconsulXtmp->ExecuteQryDB($sql, true);

                            $cont_insert += $classconsulXtmp->RowsAfected;
                            $cont_lines = 0;
                            $batch = array();
                        } else {
                            $cont_lines++;
                        }
                    }
                }
            }
            fclose($stream);
            if ($cont_lines > 0) {
                $sql = 'INSERT INTO `' . $_TABLE_LOAD . '` (' . $fields . '`fecha_master_datos`,`cve_usuario`,`id_session`) VALUES ' . implode(', ', $batch);
                $classconsulXtmp = new Entidad(array('key_sei'), array(''));
                $classconsulXtmp->ExecuteQryDB($sql, true);
                $cont_insert += $classconsulXtmp->RowsAfected;
                $batch = array();
            }
        }
    }
//
//    $_GET['fec_ini'] = implode('-', array_reverse(explode('/', $_GET['fec_ini'])));
//    $_GET['fec_fin'] = implode('-', array_reverse(explode('/', $_GET['fec_fin'])));
    $a_qry = array();
//    $a_qry[] = array("date_format(o.fecha_solicitud,'%Y-%m-%d') ", 'fec_ini', 'date', 'text', '>=', 'orden_servicio', '', '', '', '', '', '');
//    $a_qry[] = array("date_format(o.fecha_solicitud,'%Y-%m-%d') ", 'fec_fin', 'date', 'text', '<=', 'orden_servicio', '', '', '', '', '', '');
//
//    $a_qry[] = array('cve_estatus', 'cve_estatus', 'num', 'select', '=', 'orden_servicio', 'o', '', '', '', '');

    if (sizeof($a_qry) > 0) {/* crea cadena de qry */
        foreach ($a_qry as $element_aqry) {
            if (isset($_GET[$element_aqry[1]])) {

                if (strlen(trim($str_pcWhere)) > 0)
                    if (isset($element_aqry[11]) and $element_aqry[11] == 1)
                        $str_pcWhere .= " or ";
                    else
                        $str_pcWhere .= " and ";
                if ($element_aqry[2] == 'num') {
                    $str_pcWhere .= $element_aqry[7] . $element_aqry[$NTU] . (isset($element_aqry[$NTU]) && $element_aqry[$NTU] <> '' ? '.' : '') . $element_aqry[0] . $element_aqry[8] . " " . $element_aqry[4] . " " . $element_aqry[9] . ($_GET[$element_aqry[1]] * 1) . $element_aqry[9];
                } else {
                    $str_pcWhere .= $element_aqry[7] . $element_aqry[$NTU] . (isset($element_aqry[$NTU]) && $element_aqry[$NTU] <> '' ? '.' : '') . $element_aqry[0] . $element_aqry[8] . " " . $element_aqry[4] . " "
                            . (strlen(trim($element_aqry[9])) == 0 ? "'" : $element_aqry[9]) . $_GET[$element_aqry[1]] . (strlen(trim($element_aqry[10])) == 0 ? "'" : $element_aqry[10]);
                }
            }
        }
    }
//die($str_pcWhere);

    /*     * ***********FINALIZA SECCION********** */


    $tab_asoc = array();
    $arr_bg_color = array();


    $order_qry = array();

    $str_Fields = "";
    $str_Qry = "";

    $agrupacion_val = array();
    $agrupacion_sum = array();
    $agrupacion_des = array();

    $a_getn_fields = array('fecha_dato', 'fecha_registro');
    $a_getn_fields2 = array('fecha_dato', 'fecha_registro');
// // des_marca des_tipo_vehiculo   modelo   placas   num_serie
    $str_Fields = " fecha_dato,fecha_registro ";



    $a_getl_fields = array('Fecha del archivo', 'Fecha importado');


    $a_getv_fields = array(' ', ' ');
    $a_align_fields = array('C', 'C');
    $a_width_fields = array('100', '100');

    $boolPDF = false;
    $pdfprint = 'reptcpdf.php';

    $tablas_qry = " master_datos
";

    $str_pcWhere .= " 1=1 ";
//$str_pcWhere= " nivel=0 or nivel=1 ";

    $paso = false;
    $str_groupby = " order by fecha_dato desc  limit 365";
//$str_groupby = " GROUP BY pis.cve_orden_servicio,pis.cve_ingeniero_servicio,pis.cve_estatus order by d.cve_det_orden_soporte desc ";



    if (sizeof($tab_asoc) > 0) {/* crea cadena de tablas asociadas */
        foreach ($tab_asoc as $element_aqry) {
            if (strlen(trim($str_pcWhere)) > 0)
                $str_pcWhere .= " and ";
            $str_pcWhere .= $element_aqry[$NTUA] . "." . $element_aqry[2] . " = " . $element_aqry[$NTUA + 3] . "." . $element_aqry[5];
        }
    }/* fin de cadena de tablas asociadas */

    if (strlen(trim($str_pcWhere)) > 0)
        $str_pcWhere = " WHERE " . $str_pcWhere;

    $str_Qry = "SELECT " . $str_Fields . " FROM " . $tablas_qry . $str_pcWhere . $str_groupby;

    //die($str_Qry);

    $classent = new Entidad($a_getn_fields, $a_getv_fields);
    $classent->ListaEntidades(array(), "", "", "", "no", "", $str_Qry);
    $ar_th = ['', 'oscuro_1', 'claro_1'];
    $ar_tha = ['', 'table_hover_oscuro', 'table_hover_claro'];
    $tabla_pintar_tit = "";
    
    
    $tabla_pintar_tit = '<table width="100%" border="0" class="table table-hover color_negro tabla_sys_en rounded"  style="">';
    $caption_table='<caption class="color_negro" style="caption-side: top;padding-top: .1rem;padding-bottom: .1rem;height:40px;"><h4 class="h5 font-weight-bold rounded claro_3" style="background-color:#ffffe0;color:#000000;padding-top:.15em;padding-bottom: 7px;">Datos de archivos</h4></caption>';
    $tabla_pintar_tit.=''.$caption_table;
    $tabla_pintar_tit .= '<tr>';
    for ($index2 = 0; $index2 < count($a_getl_fields); $index2++) {
        $tabla_pintar_tit .= '<th style="text-align:left;" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">' . $a_getl_fields[$index2] . '</th>';
    }
    $tabla_pintar_tit .= '</tr>';
    $tabla_pintarxls = $tabla_pintar_tit;
    $ar_bot=array("","punteados_l oscuro_b","punteados_s claro_b");

    $pos_actual = 0;
    for ($i = 0; $i < $classent->NumReg; $i++) {
        $classent->VerDatosEntidad($i, $a_getn_fields2);
        $tabla_pintar_tit .= '<tr class="' . $ar_tha[$__SESSION->getValueSession('theme') * 1] . '">';
        $tabla_pintarxls .= '<tr>';
        foreach ($a_getn_fields as $key => $value) {
            if ($key == 0) {
                $var_form = '<form action="index.php?mod=12" method="post"><input type="hidden" id="fecha_ar" name="fecha_ar" value="' . ($classent->$value) . '"><button type="submit" class="btn boton_act punteados '.$ar_bot[$__SESSION->getValueSession('theme') * 1].'">' . ($classent->$value) . '</button></form>';
                $tabla_pintar_tit .= '<th colspan="" style="text-align:left;">' . $var_form . '</th>';
            } else {
                $tabla_pintar_tit .= '<th colspan="" style="text-align:left;">' . ($classent->$value) . '</th>';
            }



            $tabla_pintarxls .= '<th colspan="" style="text-align:left;">' . utf8_encode($classent->$value) . '</th>';
        }
        $tabla_pintar_tit .= '</tr>';
        $tabla_pintarxls .= '</tr>';
    }
    $tabla_pintar_tit .= '</table>';
    $tabla_pintarxls .= '</table>';
    $tabla_pintarxls = $TITULO . $tabla_pintarxls;
    $tabla_pintar2 = $tabla_pintar_tit;
    $tabla_pintar = $TITULO . $tabla_pintar_tit;

    die($tabla_pintar);
    // die($tabla_pintar);
}
?>