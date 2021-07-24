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
$tabla = 'sb_perfil_modulo,sb_modulo';
$strWhere = "Where sb_perfil_modulo.cve_perfil=" . $__SESSION->getValueSession('cveperfil');
$strWhere .= " and sb_perfil_modulo.cve_modulo=" . $__SESSION->getValueSession('mod');
$strWhere .= " and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
$strWhere .= " and sb_modulo.sta_modulo<>0";
$classval = new Entidad($allf, $allv);
$classval->Consultar($allf, $IdPrin, $tabla, $strWhere);
$str_valmodulo = "MOD_NOVALIDO";
if ($classval->NumReg > 0) {
    $str_valmodulo = "MOD_VALIDO";
    $a_key = explode(',', $classval->key_modulo);
    $nombre = "";
    $nom_uni = "";
    //'fecha_visita','telefono'


    $ar_label = ['', ' label_oscuro ', ' label_claro '];
    $TITULO = '<table width="100%" border="0" class="table-hover">' . '<tr><th colspan="14" style="text-align:center;"  class="' . $ar_label[$__SESSION->getValueSession('theme') * 1] . '">REPORTE DE DEFUNCIONES POR COVID-19 AL ' . $_GET['fecha_ar'] . '</th></tr>';
    $TITULO .= '<tr><th colspan="14" style="text-align:center;" class="' . $ar_label[$__SESSION->getValueSession('theme') * 1] . '">' . ('ESTADO DE MÉXICO') . '</th></tr></table>';
    
    $TITULOxls = '<table width="100%" border="0" class="table-hover">' . '<tr><th colspan="14" style="text-align:center;"  class="' . $ar_label[$__SESSION->getValueSession('theme') * 1] . '">REPORTE DE DEFUNCIONES POR COVID-19 AL ' . $_GET['fecha_ar'] . '</th></tr>';
    $TITULOxls .= '<tr><th colspan="14" style="text-align:center;" class="' . $ar_label[$__SESSION->getValueSession('theme') * 1] . '">' . utf8_encode('ESTADO DE MÉXICO') . '</th></tr></table>';    

    $AGRUPACION = "\n";
    $boolreplaceFirstCol = FALSE;
    $AGRUPACION .= "\n";
    $top_postprint = 70;
    $HGT_LBL = 3;
    $HGT_LBL2 = 3;
    $HGT_ALL = 3;
    $HGT_TIT = 3;

    $FONT_LBL_SZ = 5.5;
    $FONT_TIT_SZ = 6;
    $FONT_LBL = array('arial', 'B');
    $BGC_LBL = $CFG_RGB[11];
    $BGC_SUBLBL = $CFG_RGB[5];
    $BGC_ALL = $CFG_RGB[1];
    $FONT_ALL_SZ = 4.5;
    $FONT_ALL = 'arial';
    $ALIGN_LBL = 'C';
    $WDT_LBL_GRP = 15;
    $WDT_VAL_GRP = 145;
    $LEFT_ROW = 12;
    $LEFT_SUBROW = 15;
    $DRW_ROW = array();
    $DRW_ROW[] = $CFG_RGB[0];
    $DRW_ROW[] = $CFG_RGB[0];
    $NTU = 6; // Nombre de Tabla a Usar (Posicion del tipo de uso en el arreglo $a_qry (5|6))
    $NTUA = 1; // Nombre de Tabla a Usar en tablas asociadas y order(Posicion del tipo de uso en el arreglo $a_qry (0|1))
    $BORDERBODY = 1; // Se imprimira borde de la tabla del body (0|1)

    $p_orientacion = 'L';
    $p_tamano = 'letter';
    $a_qry = array();
    $a_qry[] = array("FECHA_FOLIOS", 'fecha_ar', 'date', 'text', '=', 'folios_anteriores', 'f', '', '', '', '', '');



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

    /*     * ***********FINALIZA SECCION********** */


    $tab_asoc = array();
    $arr_bg_color = array();


    $order_qry = array();

    $str_Fields = "";
    $str_Qry = "";

    $agrupacion_val = array();
    $agrupacion_sum = array();
    $agrupacion_des = array();

    $a_getn_fields = array(
        'SECTOR'
        , 'UNIDAD'
        , 'FOLIO_SINAVE'
        , 'APEPATER'
        , 'APEMATER'
        , 'NOMBRE'
        , 'SEXO'
        , 'MPIORESI'
        , 'FECDEF'
        , 'EDAD'
        , 'OCUPACIO'
        , 'FECINGRE'
        , 'COMORBILIDAD');
    $a_getn_fields1 = array(
        'SECTOR'
        , 'UNIDAD'
        , 'FOLIO_SINAVE'
        , 'APEPATER'
        , 'APEMATER'
        , 'NOMBRE'
        , 'SEXO'
        , 'MPIORESI'
        , 'FECDEF'
        , 'EDAD'
        , 'OCUPACIO'
        , 'FECINGRE'
        , 'COMORBILIDAD'
        , 'ELIMINADO');    


// // des_marca des_tipo_vehiculo   modelo   placas   num_serie
    $str_Fields = " f.SECTOR, f.UNIDAD, f.FOLIO_SINAVE, f.APEPATER, f.APEMATER, f.NOMBRE, f.SEXO, f.MPIORESI, f.FECDEF, f.EDAD, f.OCUPACIO, f.FECINGRE
,IF((if (f.DIABETES = 'SI',0,1) + if (f.EPOC = 'SI',0,1) + if (f.ASMA = 'SI',0,1) + if (f.HIPERTEN = 'SI',0,1) + if (f.VIH_SIDA = 'SI',0,1) + if (f.ENFCARDI = 'SI',0,1) + 
if (f.OBESIDAD = 'SI',0,1) + if (f.INSRENCR = 'SI',0,1) + if (f.TABAQUIS = 'SI',0,1))=9,'NO',
CONCAT(if (f.DIABETES = 'SI','DIABETES\n',''),if (f.EPOC = 'SI','EPOC\n',''),if (f.ASMA = 'SI','ASMA\n',''),if (f.HIPERTEN = 'SI','HIPERTENCION\n',''),if (f.VIH_SIDA = 'SI','VIH SIDA\n',''),
if (f.ENFCARDI = 'SI','ENF. CARDIACA\n',''),if (f.OBESIDAD = 'SI','OBESIDAD\n',''),if (f.INSRENCR = 'SI','INS. RENAL CRONICA\n',''),if (f.TABAQUIS = 'SI','TABAQUISMO',''))
) AS COMORBILIDAD,f.ELIMINADO ";
    $a_getl_fields = array('No.', 'INSTITUCIÓN', 'UNIDAD', 'FOLIO SINAVE', 'APELLIDO PATERNO', 'APELLIDO MATERNO', 'NOMBRE', 'SEXO', 'MUNICIPIO RESIDENCIA', 'FECHA  DE DEFUNCIÓN', 'EDAD',
        'OCUPACION', 'FECHA INGRESO', 'COMORBILIDAD');


    $boolPDF = false;
    $pdfprint = 'reptcpdf.php';

    $tablas_qry = " folios_anteriores f ";
    //$str_pcWhere= " nivel=0 or nivel=1 ";

    $paso = false;
    $str_groupby = " ORDER BY f.APEPATER, f.APEMATER, f.NOMBRE asc ";



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
    //  die($str_Qry);
    $arreglo_preguntas = array();
    $arreglo_datos = array();
    $arreglo_datos_p = array();
    $classent = new Entidad($a_getn_fields, $a_getv_fields,1);
    $classent->ListaEntidades(array(), "", "", "", "no", "", $str_Qry);
    $tabla_pintar_tit = "";
    $tabla_pintarxls ="";
    $ar_th = ['', 'oscuro_1', 'claro_1'];
    $ar_tha = ['', 'table_hover_oscuro', 'table_hover_claro'];
    $tabla_pintar_tit = '<table width="100%" border="1" class="table table-hover color_negro tabla_sys_en rounded"  style="">';
    $tabla_pintar_tit .= '<tr>';
    
    $tabla_pintarxls = '<table width="100%" border="1" class="table table-hover color_negro tabla_sys_en rounded"  style="">';
    $tabla_pintarxls .= '<tr>';    
    for ($index2 = 0; $index2 < count($a_getl_fields); $index2++) {
        $tabla_pintar_tit .= '<th style="text-align:center;" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">' . $a_getl_fields[$index2] . '</th>';
        $tabla_pintarxls .= '<th style="text-align:center;" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">' . utf8_encode($a_getl_fields[$index2]) . '</th>';
    }
    $tabla_pintar_tit .= '<th style="text-align:center;" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">Acciones</th>';
    $tabla_pintar_tit .= '</tr>';
    $tabla_pintarxls .= '</tr>';

    $color_f_array = array("background-color:#ECECEC;", "background-color:#fff;");
    $pos_actual = 0;
    for ($i = 0; $i < $classent->NumReg; $i++) {
        $classent->VerDatosEntidad($i, $a_getn_fields1);
        $back_trs='';
        if( ($classent->ELIMINADO)*1 == 1){
            $back_trs='rojin';
        }
        $tabla_pintar_tit .= '<tr class="' . $ar_tha[$__SESSION->getValueSession('theme') * 1] .' '.$back_trs.'" id="tr_'.$classent->FOLIO_SINAVE.'">';
        $tabla_pintarxls .= '<tr>';
        $tabla_pintar_tit .= '<th colspan="" style="text-align:center;">' . ($i+1) . '</th>';
        $tabla_pintarxls .= '<th colspan="" style="text-align:center;">' . ($i+1) . '</th>';
        foreach ($a_getn_fields as $key => $value) {
            $tabla_pintar_tit .= '<th colspan="" style="text-align:center;">' . ($classent->$value) . '</th>';
            $tabla_pintarxls .= '<th colspan="" style="text-align:center;">' . utf8_encode($classent->$value) . '</th>';
        }
        $selected_s=" ";
        if( ($classent->ELIMINADO)*1 == 1){
            $selected_s="selected";
        }
        $tabla_pintar_tit .= '<th colspan="" style="text-align:center;"><select name="elimina_'.$i.'" id="elimina_'.$i.'" onchange="actualiza_folios(this);">
  <option value="'.$classent->FOLIO_SINAVE.'_0">Activo</option>
  <option value="'.$classent->FOLIO_SINAVE.'_1" '.$selected_s.'>Inactivo</option>
</select></th>';
        $tabla_pintar_tit .= '</tr>';
        $tabla_pintarxls .= '</tr>';
    }
    $tabla_pintar_tit .= '</table>';
    $tabla_pintarxls .= '</table>';
    $tabla_pintarxls = $TITULOxls . $tabla_pintarxls;
    $tabla_pintar2 = $tabla_pintar_tit;
    $tabla_pintar = $TITULO . $tabla_pintar_tit;
    // die($tabla_pintar);
################################################################################################################
}

function write_saltos($num) {
    $salto = "";
    for ($i = 0; $i < $num; $i++) {
        $salto .= "\n";
    }
    return $salto;
}

?>