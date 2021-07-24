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
        $valor_ini = $_POST['fecha_ini'];
        $valor_fin = $_POST['fecha_fin'];
        $_POST['fecha_ini'] = implode('-', array_reverse(explode('/', $_POST['fecha_ini'])));
        $_POST['fecha_fin'] = implode('-', array_reverse(explode('/', $_POST['fecha_fin'])));
        $where_add = " DATE_FORMAT(c.FECENTRADA,'%Y-%m-%d') >= '" . $_POST['fecha_ini'] . "' and " . " DATE_FORMAT(c.FECENTRADA,'%Y-%m-%d') <= '" . $_POST['fecha_fin'] . "'";
    } else {
        $where_add = " DATE_FORMAT(c.FECENTRADA,'%Y') = '" . $__SESSION->getValueSession('anios_sys') . "'";
        $valor_ini = date("d/m/Y");
        $valor_fin = date("d/m/Y");
    }

    $classconsul = new Entidad(array('mes', 'tot'), array('', ''));
    $classconsul->ListaEntidades(array("DATE_FORMAT(c.FECENTRADA,'%m')"), ' entradas2 c', " where c.estatus=1 and " . $where_add . " group by DATE_FORMAT(c.FECENTRADA,'%m')", "(DATE_FORMAT(c.FECENTRADA,'%m')*1)as mes,count(c.CVEENT)as tot");

//    echo '<pre>';
//    print_r($classconsul);die();

    $arreglomes = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('mes', 'tot'));
        $mes = "";
        switch (($classconsul->mes) * 1) {
            case 1:$mes = "Enero";
                break;
            case 2:$mes = "Febrero";
                break;
            case 3:$mes = "Marzo";
                break;
            case 4:$mes = "Abril";
                break;
            case 5:$mes = "Mayo";
                break;
            case 6:$mes = "Junio";
                break;
            case 7:$mes = "Julio";
                break;
            case 8:$mes = "Agosto";
                break;
            case 9:$mes = "Septiembre";
                break;
            case 10:$mes = "Octubre";
                break;
            case 11:$mes = "Noviembre";
                break;
            case 12:$mes = "Diciembre";
                break;
        }
        if ($i == ($classconsul->NumReg) - 1 || $classconsul->NumReg == 1)
            $arreglomes .= "[\"" . $mes . "\"," . $classconsul->tot . "]";
        else
            $arreglomes .= "[\"" . $mes . "\"," . $classconsul->tot . "],";
    }
    $arreglomes = "[" . $arreglomes . "]";
    //die($arreglomes);
    // circular por tipo
    $classconsul = new Entidad(array('des_usuario', 'tot'), array('', ''));
    $classconsul->ListaEntidades(array("sb.des_usuario"), 'entradas2 c
JOIN sb_usuario sb ON c.cve_usuario=sb.cve_usuario AND c.anios_sys=\'' . $__SESSION->getValueSession('anios_sys') . "'", " where " . $where_add . " and c.estatus=1 group by c.cve_usuario", "sb.des_usuario,COUNT(c.CVEENT)as tot");
//    echo '<pre>';
//    print_r($classconsul);die();
    $arreglocues = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('des_usuario', 'tot'));

        if ($i == ($classconsul->NumReg) - 1 || $classconsul->NumReg == 1)
            $arreglocues .= "{name:\"" . utf8_encode($classconsul->des_usuario) . "\",y:" . $classconsul->tot . "}";
        else
            $arreglocues .= "{name:\"" . utf8_encode($classconsul->des_usuario) . "\",y:" . $classconsul->tot . "},";
    }

    // circular por sexo
    $classconsul = new Entidad(array('des_usuario', 'tot'), array('', ''));
    $classconsul->ListaEntidades(array("sb.des_usuario"), ' entradas2 c
JOIN sb_usuario sb ON c.cve_usuario=sb.cve_usuario AND c.anios_sys=\'' . $__SESSION->getValueSession('anios_sys') . "'", " where " . $where_add . " and c.estatus=0 group by c.cve_usuario", "sb.des_usuario,COUNT(c.CVEENT)as tot");

//    echo '<pre>';    
//    print_r($classconsul);die();
    $arreglosex = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('des_usuario', 'tot'));

        if ($i == ($classconsul->NumReg) - 1 || $classconsul->NumReg == 1)
            $arreglosex .= "{name:\"" . utf8_encode($classconsul->des_usuario) . "\",y:" . $classconsul->tot . "}";
        else
            $arreglosex .= "{name:\"" . utf8_encode($classconsul->des_usuario) . "\",y:" . $classconsul->tot . "},";
    }


    $classconsul = new Entidad(array('tot'), array(''));
    $classconsul->ListaEntidades(array("c.estatus"), ' entradas2 c  ', " WHERE c.estatus IN (0,1) AND DATE_FORMAT(c.FECENTRADA,'%Y') ='" . $__SESSION->getValueSession('anios_sys') . "'", "count(*) as tot");
    $total_per_d = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('tot'));
        $total_per_d = $classconsul->tot;
    }
    $classconsul = new Entidad(array('tot'), array(''));
    $classconsul->ListaEntidades(array("c.estatus"), ' entradas2 c  ', " WHERE c.estatus IN (1) AND DATE_FORMAT(c.FECENTRADA,'%Y') ='" . $__SESSION->getValueSession('anios_sys') . "'", "count(*) as tot");
    $total_per_a = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('tot'));
        $total_per_a = $classconsul->tot;
    }
    $classconsul = new Entidad(array('tot'), array(''));
    $classconsul->ListaEntidades(array("c.estatus"), ' entradas2 c  ', " WHERE c.estatus IN (0) AND DATE_FORMAT(c.FECENTRADA,'%Y') ='" . $__SESSION->getValueSession('anios_sys') . "'", "count(*) as tot");

    $total_per_db = "";
    for ($i = 0; $i < $classconsul->NumReg; $i++) {
        $classconsul->VerDatosEntidad($i, array('tot'));
        $total_per_db = $classconsul->tot;
    }

    $tot_pac = $total_per_d;
    $por = 100;
    $por_p = ($total_per_a * 100) / $tot_pac;
    $por_n = ($total_per_db * 100) / $tot_pac;
    ?>
    <div class="content m-1" style="padding-top:80px;">
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
                                        <div class="col-12" style="height: 30px;"><label for="disabled-input" class=" form-control-label"><label id="l_fecha_ini">Fecha de Entrada De:<label>&nbsp;<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px;color:red;"></i></label>&nbsp;<i id="i_afecha_ini" aria-hidden="true"></i></label></label></div>
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
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-violet"><i class="icon-user"></i></div>
                                                <div class="title"><span>Total<br>entradas</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="<?php echo $tot_pac; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $tot_pac; ?></strong></div>
                                            </div>
                                        </div>
                                        <!-- Item -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-red"><i class="icon-padnote"></i></div>
                                                <div class="title"><span>Activos</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: <?php echo $por_p; ?>%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $total_per_a; ?></strong></div>
                                            </div>
                                        </div>
                                        <!-- Item -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="item d-flex align-items-center">
                                                <div class="icon bg-green"><i class="icon-bill"></i></div>
                                                <div class="title"><span>Canceladas</span>
                                                    <div class="progress">
                                                        <div role="progressbar" style="width: <?php echo $por_n; ?>%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                                                    </div>
                                                </div>
                                                <div class="number"><strong><?php echo $total_per_db; ?></strong></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </section>
                        </div>    

                    </div>
                </div>      

                <div class="col-lg-12" style="padding-top: 8px;height: 1000px;">
                    <div class="row">
                        <div class="chart col-12 col-lg-12" style="padding-top: 8px;">
                            <div id="container_mes" class="" style="height: 500px;"></div>
                        </div>          
                        
                        <div class="chart col-12 col-lg-6" style="padding-top: 8px;">
                            <div id="container_cues" class="" style="height: 500px;"></div>
                        </div>    
                        
                        <div class="chart col-12 col-lg-6" style="padding-top: 8px;">
                            <div id="container_sex" class="" style="height: 500px;"></div>
                        </div>                          
                    </div>
                </div>                   
            </div>
        </div>
    </div>
    <script src="js/highcharts.js"></script>
    <script src="js/exporting.js"></script>
    <script src="js/export-data.js"></script>
      
    <script type="text/javascript">
                                            $(document).ready(function () {
                                                var data =<?php echo $arreglomes; ?>;
                                                Highcharts.chart('container_mes', {
                                                    chart: {
                                                        type: 'column'
                                                    },
                                                    title: {
                                                        text: 'Entradas registradas por mes'
                                                    },
                                                    subtitle: {
                                                        text: ''
                                                    },
                                                    xAxis: {
                                                        type: 'category',
                                                        labels: {
                                                            rotation: 0,
                                                            style: {
                                                                fontSize: '13px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Entradas'
                                                        }
                                                    },
                                                    legend: {
                                                        layout: 'vertical',
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: 'Entradas = {point.y:.1f}'
                                                    },
                                                    series: [{
                                                            name: 'Entradas',
                                                            data: data,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: -90,
                                                                color: '#FFFFFF',
                                                                align: 'right',
                                                                format: '{point.y:.1f}', // one decimal
                                                                y: 10, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '13px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                }
                                                            }
                                                        }]
                                                });
                                                //grafica de                 

                                                var data = [<?php echo $arreglocues; ?>];
                                                Highcharts.chart('container_cues', {
                                                    chart: {
                                                        plotBackgroundColor: null,
                                                        plotBorderWidth: null,
                                                        plotShadow: false,
                                                        type: 'pie'
                                                    },
                                                    title: {
                                                        text: 'Entradas realizadas por usuarios'
                                                    },
                                                    tooltip: {
                                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                                    },
                                                    plotOptions: {
                                                        pie: {
                                                            allowPointSelect: true,
                                                            cursor: 'pointer',
                                                            dataLabels: {
                                                                enabled: true,
                                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                                style: {
                                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                                }
                                                            }
                                                        }
                                                    },
                                                    series: [{
                                                            name: 'Entradas',
                                                            colorByPoint: true,
                                                            data: data
                                                        }]
                                                });
                                                var data = [<?php echo $arreglosex; ?>];
                                                Highcharts.chart('container_sex', {
                                                    chart: {
                                                        plotBackgroundColor: null,
                                                        plotBorderWidth: null,
                                                        plotShadow: false,
                                                        type: 'pie'
                                                    },
                                                    title: {
                                                        text: 'Entradas canceladas por usuario'
                                                    },
                                                    tooltip: {
                                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                                    },
                                                    plotOptions: {
                                                        pie: {
                                                            allowPointSelect: true,
                                                            cursor: 'pointer',
                                                            dataLabels: {
                                                                enabled: true,
                                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                                style: {
                                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                                }
                                                            }
                                                        }
                                                    },
                                                    series: [{
                                                            name: 'Entradas',
                                                            colorByPoint: true,
                                                            data: data
                                                        }]
                                                });
                                            });
                                            $(function () {

                                                $('#fecha_ini').datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    controlType: 'select',
                                                    oneLine: true,
                                                    timeFormat: '',
                                                    dateFormat: 'dd/mm/yy',
                                                    buttonText: '<i class=\'fa icon-calendar\'></i>',
                                                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                                                    yearRange: '<?php echo $__SESSION->getValueSession('anios_sys') . ":" . $__SESSION->getValueSession('anios_sys'); ?>',
                                                });
                                                $('#fecha_fin').datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    controlType: 'select',
                                                    oneLine: true,
                                                    timeFormat: '',
                                                    dateFormat: 'dd/mm/yy',
                                                    buttonText: '<i class=\'fa icon-calendar\'></i>',
                                                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                                                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                                                    yearRange: '<?php echo $__SESSION->getValueSession('anios_sys') . ":" . $__SESSION->getValueSession('anios_sys'); ?>',
                                                });
                                            });
                                            function mensaje(div_s) {
                                                $("#" + div_s).datepicker("show");
                                            }
    </script>
    <?php
}
?>