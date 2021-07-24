<?php
$str_check = FALSE;
include_once("sb_ii_check.php");

if ($str_check) {
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
        /* ----------JURISDICCION--------------------- */
        $obligatorio = 0;
        $entidad = 'Informes';

        $str_valmodulo = "MOD_VALIDO";
        $a_key = explode(',', $classval->key_modulo);

        /* -------------valores de session, si es que los hay------------- */
        $sel = '0';

        if (isset($vintParam)) {
            switch ($vintParam) {
                case 2:
                    break;
            }
        }


        $date = date('d-m-Y');
        $field = array();
        $allf = array();
        $allv = array();
        /* $field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
          '3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
          '5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
          '10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered); */
        //$id_prin='cve_jurisdiccion';
        $strWhere = "Where";
        $a_order = array();
        $intWLblEntidad = 900;
//        echo '<pre>';
//        print_r($__SESSION->getAll());die();
        $sin_val = array("");
        $sin_des = array("Seleccionar tipo");
        $campos = array('id_control_importaciones', 'fecha_ini', 'nombre_archivo_origin', 'fecha_importacion', 'estatus', 'tipo', 'observaciones','folio_inexistentes');
        $classconsul = new Entidad($campos, array(0, ''));
        $classconsul->ListaEntidades(array('fecha_importacion'), 'control_importaciones c
 ', " where 1=1 group by c.id_control_importaciones order by c.fecha_ini desc limit 365 ",
                " c.id_control_importaciones ,
c.fecha_ini,
c.nombre_archivo_origin,
c.fecha_importacion,
if(c.estatus_import=1,'Procesando','Error') AS estatus,
c.observaciones,
C.folio_inexistentes", 'no');
//echo '<pre>';
//print_r($classconsul);die();
        $tabla_im = '<table class="table table-hover color_negro tabla_sys_en rounded"><thead><tr class="bg-success">'
                . '<th scope="col">FECHA IMPORTACION</th>'
                . '<th scope="col">NOMBRE ARCHIVO</th>'
                . '<th scope="col">ESTADO. IMPORTACION</th>'
                . '<th scope="col">OBSERVACIONES</th>'
                . '<th scope="col">FOLIOS INEXISTENTES</th>'                
                . '<th scope="col">ACCIONES</th>'
                . '</tr></thead><tbody>';
        $ar_bot = array("", "punteados_l oscuro_b", "punteados_s claro_b");
        for ($i = 0; $i < $classconsul->NumReg; $i++) {
            $classconsul->VerDatosEntidad($i, $campos);
            $tabla_im .= '<tr class="table_hover_cab table_hover_sys">';
            $tabla_im .= '<td>' . $classconsul->fecha_importacion . '</td>';
            $tabla_im .= '<td>' . $classconsul->nombre_archivo_origin . '</td>';

            if ($classconsul->estatus == "Error") {
                $contenido_es = $classconsul->estatus;
                $tabla_im .= '<td style="background-color:#8b0000;color: #ffffff;">' . $contenido_es . '</td>';
            } else if ($classconsul->estatus == "Importado") {
                $contenido_es = 'Importado';
                $tabla_im .= '<td style="background-color:#3cb371;color: #000000;">' . $contenido_es . '</td>';
            } else {
                $contenido_es = 'Terminado';
                $tabla_im .= '<td style="background-color:#3cb371;color: #000000;">' . $contenido_es . '</td>';
            }

            $tabla_im .= '<td>' . $classconsul->observaciones . '</td>';
            $tabla_im .= '<td>' . $classconsul->folio_inexistentes . '</td>';
            $str_fecha= explode(" ", $classconsul->fecha_importacion);
            $tabla_im .= '<td><input id="f_'.$i.'" name="f_'.$i.'" type="hidden" value="'.$str_fecha[0].'">' . '<button type="submit" class="btn boton_act punteados ' . $ar_bot[$__SESSION->getValueSession('theme') * 1] . "\" onclick=\"abre_reporte(".$i.");\">Ver tabla</button>" . '</td>';


            $tabla_im .= '<tr>';
        }
        $tabla_im .= '</tbody></table>';
        //die($anio_actual);
        $a_separs = array();
        $a_separs[] = array(0, 'Informes', 6, 'separ_verde');
        $field[] = array('idopc', 'idopc', '1', 'hidden', '1', '', 'int', 1, 200, 10, 2, '', 1, 1, 1, '');

        $des_boton="Actualizar";






        for ($x = 0; $x < 10; $x++) {
            $str_file_name = 'vparfile' . $x;
            if (isset($$str_file_name))
                $field[] = array($str_file_name, $str_file_name, '1', 'hidden', '2', '', 'char', $$str_file_name, 100, 20, 0, '', 0, 1, 1, 0, $str_file_name);
        }


//echo("sstr".$$str_file_name);
        $stropen = 'rep/rep_todos_mod.php?';
        $keyFields = array('null');
        $keyTypeFields = array('text'); //int,text
        $keyFieldsUnique = array('null');
        $keyTypeFieldsUnique = array('text'); //int,text
        $array_noprint_ent = array('null');
        $suma_width = 0;
        $rwitem = 'null';
        $strwentidad = "repentidad_import.php";

//$vparitem=0;
        $strSelf = "i_importaciones.php";
        $ValsendRep2 = 'sendRep2';
        $numcols = 0;
        foreach ($field as $afield) {
            if ($afield[2] == '1') {
                $suma_width += $afield[8];
                $numcols += 1;
            }
        }
        if (isset($vpar_int01) and $vpar_int01 == 2) {
            $awidths = array('100', '150', '950');
        } else {
            $awidths = array('100', '150', '950');
        }

        function fnBeforeLoad() {
//die("qqqqqqqqqqqqqqqqqqqqq");
            echo '<script type="text/javascript">crea_progress();'
            . '</script>';
            //   array( 245 , 221 , 112 ) 
        }

    }
} else {
    include_once("../config/cfg.php");
    include_once("../lib/lib_function.php");
    include_once("sb_refresh.php");
}
?>
<style>
    #myBar{
        border: none !important;
        border-width: 2px;
    }
    #barra{
        height: 100%;
    }
    #s_por{
        height: 85%;
        line-height: 8px;
        margin-top: 0px;
        padding-top: 8px;
    }
    #re_acep{
        color: #808080;
        font-weight: bold;
        font-size: 12px;
        background-color: #E6FDE9;
        text-align: center;
        line-height: 20px;
    }
    #re_acep1{
        color: #808080;
        font-weight: bold;
        font-size: 12px;
        background-color: white;

    }    

    #contenedor_res div{ float:left; }
    #folio_error{
        border-style: solid;
        /*border-right-color: #A6A6A6;*/
        border-color: white #A6A6A6 white white;
    }
</style>

<script type="text/javascript">

    function crea_progress() {//background-color: #4CAF50;   background: url(images/circular_up.gif);
        //   alert("a as as as as ddddddddd");
        var str_htmls='<?php echo $tabla_im; ?>';
        $('#miiframe').append('<div id="myProgress" style="width:99%">' +
                '<div id="myBar" style="width:100%"></div>' +
                '</div><hr><div id="obs_up" style="width=100%">' +
                '</div></br></br><div id="contenedor_res" style="width:100%;background-color:white;">' +str_htmls+
                '</div> ');
    }
    var width;
    var index_w = 0;
    var tam_fin = 0;
    var folios_error = [];
    var folios_aceptados = [];
    var nombre_archivo = '';
    var nombre_archivo_ok = '';
    var id_control_gasolinas = '';
    function manda_datos() {

        $('#myBar').css('box-shadow', '0px 0px 0px white');
        $(".ui-progressbar-value").html("<p id='s_por'>0%</p>");
        $('.ui-progressbar-value').attr('id', 'barra');
        $('.ui-progressbar-value').css('width', '1%');
        $('.ui-progressbar-value').css('background', '#D4EDDA');
        //$("#image_car").css("display", 'none');
        $('#folio_error').html("");
        $('#folio_ok').html("");
        $('#obs_up').html("");
        //if ($('#csv_file').val() != '' && $('#tipo_importacion').val() != '' && $('#anio').val() != '') {
        if ($('#csv_file').val() != '') {
            $("#envia_datos").prop("disabled", true);
            $("#envia_datos").css("display", 'none');
            //$("#image_car").css("display", 'block');
            //  $("#envia_datos").css('background-color', '#C1C2C2');
            var form_data = new FormData();
            var file_data = $('#csv_file').prop('files')[0];//frmcon
            $('#frmcon').serializeArray();
            //   alert('asdas');
//
//            form_data.append('id_guias', $('#id_guias').val());
//            form_data.append('id_periodo', $('#id_periodo').val());
//            form_data.append('origen_info', $('#origen_info').val());
            form_data.append('file', file_data);

            $('#obs_up').append('<p id="re_acep">Iniciando proceso</p>');
            $('#obs_up').append('<p id="re_acep"> Subiendo archivo al Sistema --Iniciando--</p>');
            $.ajax({
                url: 'includes/up_importaciones.php', // point to server-side PHP script 
                dataType: 'json', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                beforeSend: function () {
                    $('#ocultar_load').addClass('fa fa-spinner fa-spin');
                    $('#boton_terminar').attr('disabled', 'disabled');
                },
                success: function (response) {
                    $('#obs_up').append('<p id="re_acep">Subiendo archivo al Sistema --Terminado--</p>');
                    if (response.successful == 'true') {
                        if (response.procede == 1) {
                            window.location.href = "index.php?mod=9";
//                                $('#obs_up').append("Procesando archivo ...<br><a href='#' alt='Cargas realizadas'>Monitorear carga</a>");
//                                $("#envia_datos").prop("disabled", false);
//                                $("#envia_datos").css("display", 'block');
//                                $("#image_car").css("display", 'none');                                
                        } else {
                            $('#obs_up').append(response.error_t + " <span style='font-weight:bold;'>  en las lineas" + response.lineas_e + "</span>");
                            $("#envia_datos").prop("disabled", false);
                            $("#envia_datos").css("display", 'block');
                            //   $("#image_car").css("display", 'none');
                            $('.ui-progressbar-value').css('background', '#FF0000');
                        }



                    }
                },
                error: function (response) {
                    $('#obs_up').append('<p id="re_acep" style="background-color: #F2DEDE;">Bondad en el servidor (datos)</p>');
                    $("#envia_datos").prop("disabled", false);
                    $("#envia_datos").css("display", 'block');
                    // $("#image_car").css("display", 'none');
                    $('.ui-progressbar-value').css('background', '#FF0000');
                },
                complete: function () {
                    $('.ui-progressbar-value').css('background', '#28B463');
                    $('#ocultar_load').removeClass('fa-spinner fa-spin');
                    $('#boton_terminar').removeAttr("disabled");
                }
            });
        } else {
            $('#obs_up').append('<table class="table table-hover" width="100%" style="text-align: center;"><tr><th style="background-color: #F2DEDE;">Observaciones</th></tr><tr><th style="background-color: #F2DEDE;">Difultad al leer datos</th></tr></table>');
            return false;
        }
    }
    function abre_reporte(id) {

        //rep/rep_todos_lista.php?idopc=1&fecha_ini=01/01/2020&fecha_fin=31/01/2020&cve_municipio=106&fparam=il_listado
        cadena1 = 'rep/rep_todos_ap.php?idopc=1&fecha_ar=' + $("#f_"+id).val() + '&fparam=il_importaciones_cuadro';
        abrir(cadena1);
    }

</script>

