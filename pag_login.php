<?php
if (strlen(session_id()) == 0) {
    session_start();
    include_once("config/cfg.php");
    if (isset($_SESSION[_CFGSBASE]))
        unset($_SESSION[_CFGSBASE]);
} else {
    include_once("config/cfg.php");
    if (isset($_SESSION[_CFGSBASE]))
        unset($_SESSION[_CFGSBASE]);
}

//Destruye todas las variables de la sesi&oacute;n
//session_start(); _CFGSBASE
$intlogin = 0;
$struser = "";
if (isset($_GET['hidlogin']))
    $intlogin = $_GET['hidlogin'];
if (isset($_GET['txtnomusuario']))
    $struser = $_GET['txtnomusuario'];


include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$div_ima = '';
$div_cir = '';
$div_indicator = '';
$classconsul = new Entidad(array('ruta', 'file_name', 'orden', 'href', 'desc_ima'), array('', '', ''));
$classconsul->ListaEntidades(array('i.orden limit 0,5'), 'sb_carousel i', ' where i.estatus=1 ', 'i.ruta,i.file_name,i.orden,i.href,i.desc_ima');
for ($i = 0; $i < $classconsul->NumReg; $i++) {
    $classconsul->VerDatosEntidad($i, array('ruta', 'file_name', 'orden', 'href', 'desc_ima'));
    if ($i == 0) {
        $claseslider = "active";
        $classindicator = 'class="active"';
    } else {
        $claseslider = "";
        $classindicator = '';
    }
    $img = '<img class="d-block w-100"  src="' . (($classconsul->ruta) . ($classconsul->file_name)) . '" alt="' . ($classconsul->desc_ima) . '" />';

    if ($classconsul->href != "") {
        $ref = '<a href="' . (strlen($classconsul->href) > 0 ? $classconsul->href : '#') . '" target="_blank">';
        $ref .= $img;
        $ref .= '</a>';
    } else {
        $ref = $img;
    }
    if ($classconsul->desc_ima != "") {
        $ref .= '<div class="carousel-caption d-md-block">' . $classconsul->desc_ima . '</div>';
    }

    $div_cir .= '<div class="carousel-item ' . $claseslider . '">';
    $div_cir .= $ref;
    $div_cir .= '</div>';
    $div_indicator .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" ' . $classindicator . '>' . ($i + 1) . '</li>';
}

//$CFG_BGC[0] = '#009999#A6C370
?>
<!DOCTYPE html>
<html class="no-js" lang="es-MX">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $abre_s; ?></title>
    <meta name="description" content="<?php print $CFG_TITLE; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?php print $CFG_TITLE; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="<?php print $CFG_TITLE; ?>" />

    <link rel="icon" type="image/svg+xml" href="images/favicon_edomex.svg" sizes="any"> 
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/fontastic.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/front.css">
    <link rel="stylesheet" href="css/alertify.css" />
</head>
<?php if ($classconsul->NumReg == 0) { ?>
    <style>
        #div-carousel {display: none;}
        #div-formlogin {flex: none; max-width: 100%;}
    </style>
<?php } else if ($classconsul->NumReg == 1) { ?>
    <style>.carousel-indicators, .carousel-control-prev, .carousel-control-next {display: none;}</style>
<?php } ?>

<body class="fondo_login" style="min-height: 100%;">
    <div class="encapsulado">

        <header class="header encabezado-login">
            <div class="container-fluid">
                <div>
                    <img class="encabezado-escudo" src="images/escudo_edomex.svg" alt="Gobierno del Estado de M�xico">
                     <h1><?php echo $nombre; ?></h1>
                </div>
            </div>
        </header>

        <main role="main" class="d-flex align-items-center bg-auth border-top border-top-2" style="min-height: 90vh;">
            <div class="container">
                <div class="row align-items-center rounded">

                    <div class="col-12 col-md-6 order-md-2" id="div-carousel">
                        <div class="text-center">
                            <div class="col-sm-12">

                                <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php echo $div_indicator; ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php echo $div_cir; ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 order-md-1" id="div-formlogin">
                        <div class="container" id="login_id" style="display: block;">
                            <div class="login-content" style="margin: 6vh auto;">

                                <div class="login-form">
                                    <i class="fa fa-user-circle iconlogin"></i>
                                    <h2 class="text-muted text-center loginh2">Inicio de Sesi&oacute;n</h2>
                                    <form class="form-vertical" name="frmlogin" id="frmlogin" method="POST" action="index.php">
                                        <div class="form-group">
                                            <div class="contusuario">
                                                <input aria-label="Usuario" id="txtnomusuario" name="txtnomusuario" type="text" class="form-control text-80" onblur="obj_valObj(1, 'txtnomusuario', '', 'RisTxt', 'Usuario', '')" placeholder="Usuario" maxlength="20" size="20" value="<?php echo $struser; ?>">
                                            </div>
                                            <small class="form-text" style="display:none" id="e_txtnomusuario"></small>
                                            <input type="hidden" name="hidlogin" value="<?php echo $intlogin; ?>">
                                            <input type="hidden" name="hid_login" value="<?php echo session_id() ?>">
                                        </div>
                                        <div class="form-group">
                                            <div class="contcontrasena">
                                                <input aria-label="Contrase&ntilde;a" type="password" class="form-control text-80s" id="txtpasswd" name="txtpasswd" placeholder="Contrase&ntilde;a" onblur="obj_valObj(1, 'txtpasswd', '', 'RisTxt', 'Contrase&ntilde;a', '')" maxlength="20" size="20" value="" maxlength="16">
                                            </div>
                                            <small class="form-text" style="display:none;" id="e_txtpasswd"></small>
                                        </div>
                                        <button class="btn btn-flat m-b-30 m-t-30 entrar boton_act punteados" onclick="valida_antes();"><i class="fa fa-sign-in camb-sing-in" aria-hidden="true"></i>&nbsp;Entrar</button>
                                        <div class="checkbox">
                                            <a role="button" href="javascript:firts_d();">&iquest;Olvid&oacute; contrase&ntilde;a?</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <div class="modal fade" id="rec_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel_r" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title h4" id="mediumModalLabel_r">Recuperar contrase&ntilde;a</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true" class="punteados"><i class="fa fa-window-close"></i></span>
                        </button>
                    </div>
                    <div class="sufee-login d-flex align-content-center flex-wrap">
                        <div class="container" id="login_rec" style="display: block;">
                            <div class="login-content">
                                <div class="login-form recupera">
                                    <div class="login-logo">
                                        <div class="text-center">
                                            <h2><?php echo $nombre; ?></h2>
                                            <label class="text-80">Se enviar&aacute; correo al usuario registrado</label>
                                        </div>
                                    </div>
                                    <form class="form-vertical" name="frmrec" id="frmrec" method="POST" action="index.php">
                                        <div class="form-group">
                                            <div class="contusuario">
                                                <input id="txtnomusuario_r" name="txtnomusuario_r" type="text" class="form-control" placeholder="Usuario" aria-label="Usuario" size="20" value="<?php echo $struser; ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn text-80 font-weight-bold btn-flat m-b-30 m-t-30 boton_war punteados" id="rec_passw"><i class="fa fa-envelope"></i> Recuperar</button>
                                        <div class="checkbox">
                                            <a role="button" href="javascript:second_d();">Regresar a inicio de sesi&oacute;n</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer id="pie_pag" class="main-footer" role="contentinfo">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="pie-logo" src="images/logoedomex_plasta.svg" alt="Gobierno del Estado de M�xico">
                    <p style="font-weight: bold;" class="main-footer_c text-white">ISEM <?php echo date("Y"); ?></p>
                    <p>Departamento de Ingenieria de Software<br>
                        </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="vendor/jquery/jquery-migrate-3.0.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jsval_mod.js"></script>
    <script src="js/alertify.js"></script>

    <script>
        function firts_d() {
            $('#mediumModal').modal('hide');
            $('#rec_modal').modal('show');
        }

        function second_d() {
            $('#rec_modal').modal('hide');
            $('#mediumModal').modal('show');
        }
        $(function() {
            $(".close").on("click", function() {
                /*jQuery(this).parent().css('display', 'none');*/
            });
        });

        function oculta(div, i) {
            var visible = 'none';
            var tam = '0%';
            var op = '0.5';
            if (jQuery('#' + div).css('display') == 'none') {
                jQuery('#' + i).removeClass('fa-plus-square');
                jQuery('#' + i).removeClass('text-success');
                jQuery('#' + i).addClass('fa-minus-square');
                jQuery('#' + i).addClass('text-danger');
                visible = 'block';
                tam = '100%';
                op = '1';
            } else {
                jQuery('#' + i).removeClass('fa-minus-square');
                jQuery('#' + i).removeClass('text-danger');
                jQuery('#' + i).addClass('fa-plus-square');
                jQuery('#' + i).addClass('text-success');
            }
            jQuery("#" + div).animate({
                opacity: op,
            }, 300, function() {
                if (visible == 'none') {
                    jQuery("#" + div).hide();
                } else {
                    jQuery("#" + div).show();
                }

            });
        }
        //   valida_antes();
        function valida_antes() {
            var formElement = document.getElementById("frmlogin");
            var formData = new FormData(formElement);
            a_R = 'Cancel_peticion';
            a_R = $.ajax({
                type: "POST",
                url: "evento_user.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function(res) { //entrar
                    $('.camb-sing-in').addClass('fa-spinner fa-spin');
                    $(".camb-sing-in").attr('disabled', 'disabled');
                    obj_valObj(2,
                        'txtnomusuario', '', 'RisTxt', 'Usuario', '',
                        'txtpasswd', '', 'RisTxt', 'Contrase&ntilde;a', ''
                    );
                    if (!document.obj_retVal) {
                        $('.camb-sing-in').removeClass('fa-spinner fa-spin');
                        $('.camb-sing-in').removeAttr('disabled');
                        res.abort();
                    }
                },
                success: function(response) {
                    var sigue = true;
                    var msj = response.mensaje;
                    if (response.successful == "true" && (response.estado) == 1) {
                        $('#frmlogin').submit();
                    } else {
                        sigue = false;
                        jQuery("#espacio_frmlogin").css('display', 'block');
                        jQuery("#texto_frmlogin").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;' + msj);
                        document.getElementById("txtnomusuario").focus();
                        $("#espacio_frmlogin").attr('tabindex', '-1');

                    }
                },
                error: function(e) {
                    a_R.abort();
                },
                complete: function() {
                    $('.camb-sing-in').removeClass('fa-spinner fa-spin');
                    $('.camb-sing-in').removeAttr('disabled');
                }
            });
        }
    </script>
    <script src="r_datos_c.js"></script>
</body>

</html>