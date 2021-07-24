<?php if(strlen(session_id())==0){session_start(); include_once("config/cfg.php");} if ($__SESSION->getValueSession('nomusuario')==""){
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}else{
?>
<div class="alert alert_warning_sys">
    <p id="area_info">
    <?php echo  $__SESSION->getValueSession('desusuario')."<br>Bienvenido(a)<br>".$CFG_TITLE; ?>  
    </p>
</div>
<?php
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
}?>
<div class="row justify-content-md-center">
<div class="col-12 col-md-8" id="div-carousel">
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
</div>
<?php
}
?>