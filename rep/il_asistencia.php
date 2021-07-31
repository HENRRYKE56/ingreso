<?php

//die("asdasdas llega");
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
    $pdfprint = 'reptcpdf.php';
    $fecha_ini = "";
    if (isset($_GET['fecha_ini'])) {
        $fecha_ini =  $_GET['fecha_ini'];
    }
    $tit = "";
    if (isset($_GET['tipo_reporte'])) {
        $tipo_reporte =  $_GET['tipo_reporte'];
       switch  ($tipo_reporte){
           case 1:
            $tit="Reporte de Asistencias por Sala del Examen de Admisión a la ENSVT";
            break;
            case 2:
            $tit="Reporte de Insidencias del Examen de Admisión a la ENSVT";
            break;
       }
       
        
       
    }
    
global $reporte_hl;
    $ar_label=['',' label_oscuro ',' label_claro '];
    $TITULO = '<table width="100%" border="0" class="table-hover">' . '<tr><th colspan="4" style="text-align:center;"  class="'.$ar_label[$__SESSION->getValueSession('theme') * 1].'"> '.$tit.'  </th></tr>';
    $TITULO .= '<tr><th colspan="4" style="text-align:center;" class="'.$ar_label[$__SESSION->getValueSession('theme') * 1].'"> ' . ( $__SESSION->getValueSession('desusuario')) . '</th></tr><tr><th colspan="4" style="text-align:center;" class="'.$ar_label[$__SESSION->getValueSession('theme') * 1].'"></th></tr></table>';

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

    /*     * ***********FINALIZA SECCION********** */
    if (isset($_GET['tipo_reporte'])) {
        $tipo_reporte =  $_GET['tipo_reporte'];
      if($tipo_reporte==1){
               $a_getn_fields = array('sala','des_usuario','asistencia','total','link_clase');
                $str_Fields = "sala,des_usuario,asistencia,total,link_clase";
                $a_getl_fields = array('Sala','Responsable de la Sala','Asistencia','Total','Link');
                $a_getv_fields = array(' ', ' ', ' ', ' ', ' ', ' ');
                $a_align_fields = array('C', 'L', 'C', 'C', 'C', 'C');
                $a_width_fields = array('10', '40', '15', '10', '25');

                $str_Qry = "SELECT sala,concat(des_usuario, '  Cel: ',color_menu)des_usuario,COUNT(asistencia)asistencia,COUNT(a.nombre)total,link_clase
                FROM alumnos_ingreso a
                INNER join sb_usuario b ON a.sala=b.cveuni
                GROUP BY a.sala";

$t_asistencia=0;
$t_registro=0;
$classconsul = new Entidad(array('asistencia','total'),array(0,''));
$classconsul->ListaEntidades(array('asistencia'),' alumnos_ingreso a','  GROUP BY a.sede'," sum(asistencia)asistencia,COUNT(a.nombre)total ");
if ( $classconsul->NumReg>0) {
    $classconsul->VerDatosEntidad(0,array('asistencia','total'));
    $t_asistencia=$classconsul->asistencia;
    $t_registro=$classconsul->total;
}


      }
      else{
                 $a_getn_fields = array('cve_incidencia','des_incidencia','des_usuario');
                $str_Fields = "cve_incidencia,des_incidencia,des_usuario";
                $a_getl_fields = array('No','Incidencia','Usuario');
                $a_getv_fields = array(' ', ' ', ' ', ' ', ' ', ' ');
                $a_align_fields = array('C', 'L', 'C');
                $a_width_fields = array('5', '70','25');

                $str_Qry = "SELECT a.cve_incidencia,a.des_incidencia,b.des_usuario
                FROM incidencias a INNER JOIN sb_usuario b ON a.cveusuario=b.nom_usuario order by cve_incidencia desc";
          
       }
       
        
       
    }

    

  

   $paso = true;
 
  $boolPDF = true;


   
    
    $arreglo_preguntas = array();
    $arreglo_datos = array();
    $arreglo_datos_p = array();
    $classent = new Entidad($a_getn_fields, $a_getv_fields);

   
    $classent->ListaEntidades(array(), "", "", "", "no", "", $str_Qry);
    $tabla_pintar_tit = "";
    $ar_th = ['', 'oscuro_1', 'claro_1'];
    $ar_tha = ['', 'table_hover_oscuro', 'table_hover_claro'];    
    $tabla_pintar_tit = '<table width="100%" CELLPADDING="5" border="1" class="table table-hover color_negro tabla_sys_en rounded"  style="">';
    $tabla_pintar_tit .= '<tr>';
    for ($index2 = 0; $index2 < count($a_getl_fields); $index2++) {
        $tabla_pintar_tit .= '<th style="text-align:center; width:'. $a_width_fields[$index2].'%" class="' . $ar_th[$__SESSION->getValueSession('theme') * 1] . '">' . $a_getl_fields[$index2] . '</th>';
    }
    $tabla_pintar_tit .= '</tr>';
    $tabla_pintarxls = $tabla_pintar_tit;

    $color_f_array = array("background-color:#ECECEC;", "background-color:#fff;");
    $pos_actual = 0;
    for ($i = 0; $i < $classent->NumReg; $i++) {
        $classent->VerDatosEntidad($i, $a_getn_fields);
        $tabla_pintar_tit .= '<tr class="' . $ar_tha[$__SESSION->getValueSession('theme') * 1] . '">';
        $tabla_pintarxls .= '<tr>';
        foreach ($a_getn_fields as $key => $value) {
         
             $tabla_pintar_tit .= '<th style="width:'. $a_width_fields[$key].'%" >' . ($classent->$value) . '</th>';
            $tabla_pintarxls .= '<th style="width:'. $a_width_fields[$key].'%" >' . ($classent->$value) . '</th>';
        }
        $tabla_pintar_tit .= '</tr>';
        $tabla_pintarxls .= '</tr>';
    }
    if($tipo_reporte==1){
      
    $tabla_pintar_tit .= '<tr>
                                <td colspan="2" style="text-align: right;"><b >Total</b></td>
                                <td><b>'.$t_asistencia.'</b></td>
                                <td><b>'.$t_registro.'</b></td>
                                <td></td>
                        </tr>';
    $tabla_pintarxls .= '<tr>
                            <td colspan="2" style="text-align: right;"><b >Total</b></td>
                            <td><b>'.$t_asistencia.'</b></td>
                            <td><b>'.$t_registro.'</b></td>
                            <td></td>
                        </tr>';
    }
    $tabla_pintar_tit .= '</table>';
    $tabla_pintarxls .= '</table>';
    $tabla_pintarxls = $TITULO .($tabla_pintarxls);
    $tabla_pintar2 = $tabla_pintar_tit;
    $tabla_pintar = $TITULO . $tabla_pintar_tit;
    $tabla_pintar2 = ($TITULO . $tabla_pintar_tit);
    $reporte_hl=$tabla_pintar2;
   //    echo $tabla_pintar;

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