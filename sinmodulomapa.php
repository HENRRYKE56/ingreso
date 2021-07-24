<?php
if (strlen(session_id()) == 0) {
    session_start();
    include_once("config/cfg.php");
} if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/i_refresh.php");
} else {
    $where_add = "";
    $valor_ini = "";
    $valor_fin = "";
    if (isset($_POST['fecha_ini']) && isset($_POST['fecha_fin'])) {
        $valor_ini = trim($_POST['fecha_ini']);
        $valor_fin = trim($_POST['fecha_fin']);
        $_POST['fecha_ini'] = implode('-', array_reverse(explode('/', $_POST['fecha_ini'])));
        $_POST['fecha_fin'] = implode('-', array_reverse(explode('/', $_POST['fecha_fin'])));
        $where_add = " DATE_FORMAT(c.fecha_hora_cues,'%Y-%m-%d') >= '" . $_POST['fecha_ini'] . "' and " . " DATE_FORMAT(c.fecha_hora_cues,'%Y-%m-%d') <= '" . $_POST['fecha_fin'] . "'";
    } else {
        $where_add = " DATE_FORMAT(c.fecha_hora_cues,'%Y') = '" . date('Y') . "'";
        $valor_ini = "01" . date("/m/Y");
        //$valor_fin = $strfechaini;
        $month = date("Y-m");
        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
        $last_day = date('d/m/Y', strtotime("{$aux} - 1 day"));
        $valor_fin = $last_day;
    }
    $fecha_ini = implode('-', array_reverse(explode("/", $valor_ini)));
    $fecha_fin = implode('-', array_reverse(explode("/", $valor_fin)));
    $str_where = " where e1.estatus=3 AND (date_format(e1.fecha_registro,'%Y-%m-%d')>='" . $fecha_ini . "' AND 
date_format(e1.fecha_registro,'%Y-%m-%d')<='" . $fecha_fin . "') and 1=1 ";


    $classconsul = new Entidad(array('cuenta_mujer', 'cuenta_hombre'), array('', ''));
    $classconsul->ListaEntidades(array('p.cve_persona'), ' persona p
JOIN estatus_persona e1 ON p.cve_persona=e1.cve_persona
JOIN (
SELECT MAX(e.id_estatus_persona) AS id_estatus_persona_max
FROM estatus_persona e
GROUP BY e.cve_persona) AS q1 ON e1.id_estatus_persona=q1.id_estatus_persona_max 
', $str_where, ' sum(if(p.sexo=1,1,0))AS cuenta_mujer,sum(if(p.sexo=2,1,0))AS cuenta_hombre ', 'no');
    $html_p = '<h5>Personas registradas</h5><table border="1" style="width:100%;"><tr><th>Total mujeres</th><th>Total hombres</th></tr>';
    $tot_hombres='';
    $tot_mujeres='';
    $tot_per='';
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('cuenta_mujer', 'cuenta_hombre'));
        $tot_hombres=(($classconsul->cuenta_hombre) * 1);
        $tot_mujeres=(($classconsul->cuenta_mujer) * 1);
    }
    $tot_per=$tot_hombres+$tot_mujeres;
    $por_h=($tot_hombres*100)/$tot_per;
    $por_m=($tot_mujeres*100)/$tot_per;    
//    echo '<pre>';
//    print_r($classconsul);die();

    $ar_municipio=array();
    $classconsul = new Entidad(array('cve_municipio', 'tot'), array('', ''));
    $classconsul->ListaEntidades(array('p.cve_municipio'), ' persona p
JOIN estatus_persona e1 ON p.cve_persona=e1.cve_persona
JOIN (
SELECT MAX(e.id_estatus_persona) AS id_estatus_persona_max
FROM estatus_persona e
GROUP BY e.cve_persona) AS q1 ON e1.id_estatus_persona=q1.id_estatus_persona_max
', $str_where." GROUP BY p.cve_municipio ", ' p.cve_municipio,COUNT(*) AS tot ', 'no');
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('cve_municipio', 'tot'));
        $ar_municipio[$classconsul->cve_municipio]=$classconsul->tot;
    }    
//    echo '<pre>';
//    print_r($ar_municipio);die();
    
    
    $classconsul = new Entidad(array('cve_muns', 'nom_muns', 'vectores_hig', 'fill', 'stroke','cve_municipio'), array('', ''));
    $classconsul->ListaEntidades(array("cve_muns"), 'cat_mapa', " ", "cve_muns,nom_muns,vectores_hig,fill,stroke,cve_municipio");
    $datos_serie = array();
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('cve_muns', 'nom_muns', 'vectores_hig', 'fill', 'stroke','cve_municipio'));
        $datos_serie[$i]['name'] = eliminar_acentos($classconsul->nom_muns);
        $datos_serie[$i]['path'] = $classconsul->vectores_hig;
        $datos_serie[$i]['color'] = $classconsul->fill;
        $datos_serie[$i]['id'] = eliminar_acentos($classconsul->cve_muns);
        if(isset($ar_municipio[$classconsul->cve_municipio])){
            $datos_serie[$i]['value'] = $ar_municipio[$classconsul->cve_municipio];
        }else{
           // $datos_serie[$i]['value'] = rand(0, 1000);  
            $datos_serie[$i]['value'] = 0;
        }
              
    }
//    echo '<pre>';
//    print_r($classconsul);die();
    $d_s = json_encode($datos_serie);
    //die($d_s);
    ?>

    <div class="content m-1" style="padding-top:10px;">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <form id="frmcon" method="post" action="index.php?mod=-1">                            
                        <div class="card">
                            <div class="card-header bg-dark text-light" onclick="oculta('d_gen', 'i_d_gen')">
                                <strong><i class="fa fa-minus-square text-danger" id="i_d_gen" aria-hidden="true"></i>&nbsp;<i class="fa fa-asterisk text-danger" aria-hidden="true"></i> los campos son obligatorios</strong>
                            </div>    
                            <div class="card-body card-block" id="d_gen">

                                <div class="row form-group">
                                    <div class="row col-12 col-md-6">
                                        <div class="col-12" style="height: 30px;"><label for="disabled-input" class=" form-control-label"><label id="l_fecha_ini">Fecha de Terminacion De:<label>&nbsp;<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px;color:red;"></i></label>&nbsp;<i id="i_afecha_ini" aria-hidden="true"></i></label></label></div>
                                        <div class=" input-group col-12 col-md-12"><input type="text" id="fecha_ini" name="fecha_ini" size="10" maxlength="10" class="form-control" onclick="mensaje('fecha_ini')" value="<?php echo $valor_ini; ?>"><div class="input-group-append"><button type="button" class="btn btn-success" onclick="mensaje('fecha_ini')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button></div><small class="form-text" style="display:none" id="e_fecha_ini"></small>
                                        </div>
                                    </div>  
                                    <div class="row col-12 col-md-6">
                                        <div class="col-12" style="height: 30px;"><label for="disabled-input" class=" form-control-label"><label id="l_fecha_ini">A:<label>&nbsp;<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px;color:red;"></i></label>&nbsp;<i id="i_afecha_ini" aria-hidden="true"></i></label></label></div>
                                        <div class=" input-group col-12 col-md-12"><input type="text" id="fecha_fin" name="fecha_fin" size="10" maxlength="10" class="form-control" onclick="mensaje('fecha_fin')" value="<?php echo $valor_fin; ?>"><div class="input-group-append"><button type="button" class="btn btn-success" onclick="mensaje('fecha_fin')"><i class="fa fa-calendar text-white" style="font-size: 1rem;"></i></button></div><small class="form-text" style="display:none" id="e_fecha_fin"></small>
                                        </div>
                                    </div>                                      
                                </div>     
                            </div>
                        </div>     



                        <div class="card"><div class="form-group row" style="padding:.5rem .5rem .5rem 1rem; margin-bottom: 0rem;">
                                <div class="col-12 col-sm-12 text-center">
                                    <button id="submit" class="btn btn-success" type="submit" name="submit" value="Generar"><i id="ocultar_load" class="fa fa-download"></i>&nbsp;Generar</button>
                                </div>
                            </div></div>    
                    </form> 
                </div>    
                <div class="col-lg-12" >
                    <div class="row">
                        <div class="chart col-lg-12 col-12">
                            <section class="dashboard-counts no-padding-bottom">
                                <div class="container-fluid">
                                    <div class="row bg-white has-shadow">
                                        <!-- Item -->
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-violet"><i class="icon-user"></i></div>
                                                <div class="title"><span>Personas<br>registradas</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="<?php echo $tot_per; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $tot_per; ?></strong></div>
                                            </div>
                                        </div>
                                        <!-- Item -->
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-red"><i class="icon-padnote"></i></div>
                                                <div class="title"><span>Hombres<br>Registrados</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: <?php echo $por_h; ?>%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $tot_hombres; ?></strong></div>
                                            </div>
                                        </div>
                                        <!-- Item -->
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-green"><i class="icon-bill"></i></div>
                                                <div class="title"><span>Mujeres<br>Registradas</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: <?php echo $por_m; ?>%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $tot_mujeres; ?></strong></div>
                                            </div>
                                        </div>
                                        <!-- Item -->

                                    </div>
                                </div>
                            </section>
                        </div>    

                    </div>
                </div>      

                <div class="col-lg-12" style="padding-top: 8px;height: 1000px;">
                    <div class="row">
                        <div class="chart col-lg-12 col-12" style="padding-top: 8px;">
                            <div id="container_mes" class="" style="height: 1000px;"></div>
                        </div>                            
                    </div>
                </div>                   
            </div>
        </div>
        <script src="js/highmaps.js"></script>
        <script src="js/data.js"></script>
        <script src="js/exporting.js"></script>
        <script src="js/highcharts.js"></script>

        <script>
                                            var datos_edomex =<?php echo $d_s ?>;
                                            var html_pintar_mapa = '';
                                            $(document).ready(function () {
                                                $('#container_mes').highcharts('Map', {
                                                    plotOptions: {
                                                        series: {
                                                            point: {
                                                                events: {
                                                                    click: function () {
                                                                        abre_reporte(this.options.id);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    },
                                                    colorAxis: {},
                                                    mapNavigation: {
                                                        enabled: true,
                                                        buttonOptions: {
                                                            verticalAlign: 'bottom'
                                                        }
                                                    },
                                                    legend: {
                                                        align: 'center',
                                                        floating: true,
                                                        title: {
                                                            text: 'Personas registradas'
                                                        },
                                                    },
                                                    title: {
                                                        text: 'RESULTADOS DE REGISTRO ESTATAL DE DISCAPACIDAD'
                                                    },
                                                    tooltip: {
                                                        split: true,
                                                        useHTML: true,
                                                        pointFormatter: function () {
                                                            html_pintar_mapa = pintar_tabla_html(this.options.id);
                                                            //console.log(html_pintar_mapa);
                                                            return html_pintar_mapa;
                                                            // return this.series.name + ': <table border="1"><tr><th>Total mujeres</th><th>Total hombres</th></tr><tr><td>0</td><td>0</td></tr></table>';
                                                        }
                                                    },
                                                    series: [
                                                        {
                                                            "type": "map",
                                                            "data": datos_edomex,
                                                            borderColor: '#fff',
                                                            states: {
                                                                hover: {
                                                                    borderColor: "#000",
                                                                    borderWidth: 0,
                                                                    brightness: 0.2
                                                                }
                                                            },
                                                            dataLabels: {
                                                                enabled: true,
                                                                format: '{point.name}'
                                                            },
                                                            name: 'Personas registradas',
                                                            //                                                            tooltip: {
                                                            //                                                                pointFormat: '{point.name}: {point.value}'
                                                            //                                                            }
                                                        }
                                                    ]
                                                });



                                                var fecha_ini = $('#fecha_ini').datetimepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    controlType: 'select',
                                                    oneLine: true,
                                                    dateFormat: 'dd/mm/yy',
                                                    timeFormat: '',
                                                    showTime: false,
                                                });

                                                var fecha_fin = $('#fecha_fin').datetimepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    controlType: 'select',
                                                    oneLine: true,
                                                    dateFormat: 'dd/mm/yy',
                                                    timeFormat: '',
                                                    showTime: false,
                                                });

                                            });
                                            function mensaje(div_s) {
                                                $("#" + div_s).datepicker("show");
                                            }
                                            function abre_reporte(id) {
                                                var fecha_ini = $('#fecha_ini').val();
                                                var fecha_fin = $('#fecha_fin').val();
                                                //rep/rep_todos_lista.php?idopc=1&fecha_ini=01/01/2020&fecha_fin=31/01/2020&cve_municipio=106&fparam=il_listado
                                                cadena1 = 'rep/rep_todos_lista.php?idopc=1&fecha_ini=' + fecha_ini + '&fecha_fin=' + fecha_fin + '&cve_municipio=' + id + '&fparam=il_listado';
                                                abrir(cadena1);
                                            }

                                            function pintar_tabla_html(cve_muns) {
                                                var fecha_ini = $('#fecha_ini').val();
                                                var fecha_fin = $('#fecha_fin').val();
                                                var datos = "type=datos_m";
                                                datos += "&cve_muns=" + cve_muns;
                                                datos += "&fecha_ini=" + fecha_ini;
                                                datos += "&fecha_fin=" + fecha_fin;

                                                $.ajax({
                                                    url: 'includes/evento_mapa.php',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: datos,
                                                    beforeSend: function () {

                                                    },
                                                    success: function (response) {
                                                        if (response.successful == 'true') {
                                                            $('#carga_mapa').html(response.html_p);

                                                        }
                                                    }, error: function (e) {
                                                        alertify.error("bondad al terminar false");
                                                    },
                                                    complete: function () {
                                                    },
                                                });
                                                return '<div id="carga_mapa"><h5>Personas registradas</h5><table border="1"><tr><th>Total mujeres</th><th>Total hombres</th></tr><tr><td>0</td><td>0</td></tr></table></div>';
                                            }
        </script>
        <?php
    }

    function eliminar_acentos($cadena) {

        //Reemplazamos la A y a
        $cadena = str_replace(
                array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'), array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'), $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
                array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'), array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'), $cadena);

        //Reemplazamos la I y i
        $cadena = str_replace(
                array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'), array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'), $cadena);

        //Reemplazamos la O y o
        $cadena = str_replace(
                array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'), array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'), $cadena);

        //Reemplazamos la U y u
        $cadena = str_replace(
                array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'), array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'), $cadena);

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
                array('Ñ', 'ñ', 'Ç', 'ç'), array('N', 'n', 'C', 'c'), $cadena
        );

        return $cadena;
    }
    ?>
