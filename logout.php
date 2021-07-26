<?php
if (strlen(session_id()) == 0)
    session_start();
/* -------------------------------------------------------
  -------------------------------------------------------
  -------------------------------------------------------
 */
include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$str_msg_red = "";
$time = 0;
if ($__SESSION->getValueSession('nomusuario') <> "") {
    fnEndSession($__SESSION->getAll());
    if (isset($_SESSION[_CFGSBASE]))
        unset($_SESSION[_CFGSBASE]);
    //$_SESSION=array();				
    //session_regenerate_id(true);
    //session_destroy();
    $i_intcolor = 21;
    $str_msg_red.='CERRANDO SESION ...';
    $str_refresh = "index.php";
    $time = 1;
}else {
    $i_intcolor = 25;
    if (strlen(session_id()) == 0)
        session_start();
    if (isset($_SESSION[_CFGSBASE]))
        unset($_SESSION[_CFGSBASE]);
    //$_SESSION=array();				
    //session_regenerate_id(true);
    //session_destroy();

    $str_msg_red.='PROCESANDO SOLICITUD ...';
    $str_refresh = "index.php";
    $time = 1;
}
echo "<html>
	<head>
	<title>" . $CFG_TITLE . " - [ CIERRE DE SESSION ]</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilo.css\" />";
echo "<meta http-equiv='refresh' content='" . $time . ";URL=" . $str_refresh . "'>";

function fnEndSession($obj) {
    $array_valuesxTmp = array(2, date('Y-m-d H:i:s'));
    $array_namesxTmp = array('status_session', 'fecha_fin');
    $array_typetxTmp = array('int', 'char');
    $array_defaultxTmp = array('0', date('Y-m-d H:i:s'));
    $classent = new Entidad($array_namesxTmp, $array_defaultxTmp);
    $classent->Modificar($array_valuesxTmp, $array_namesxTmp, $array_typetxTmp, 'sb_audit_session', " cve_usuario=" . $obj['cveusuario'] .
            " and cve_perfil=" . $obj['cveperfil'] . " and id_session='" . session_id() . "'");
}
?>
<!DOCTYPE html>
<html class="no-js" lang="es-MX">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $abre_s; ?></title>
        <meta name="description" content="Registro Estatal de Discapacidad">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:title" content="Registro Estatal de Discapacidad " />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="Ayudamos a la poblacion del estado a realizar el registro Estatal de Discapacidad en linea" />        

        <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">        
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/fontastic.css">
        <link rel="stylesheet" href="css/custom.css">
        <link rel="stylesheet" href="css/front.css">

    </head>
    <body>
        <div class="page bg-white">
        <header class="header encabezado-login">
            <div class="container-fluid">
                <div>
                    <img class="encabezado-escudo" src="images/escudo_edomex.svg" alt="Gobierno del Estado de México">
                 </div>
            </div>
        </header>   
            <div class="bg-light">
                <div class="col-sm-12">
                    <div class="page-header bg-light">
                        <div class="page-title text-center">
                            <h2 class=""><?php echo '' . $nombre; ?></h2>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="content m-1 bg-white">
                <div class="animated fadeIn">


                    <div class="row" style="height: 50%">
                        <div class="col-sm-12 text-center"><h1 style="color:#8b0000;"><?php include_once("includes/sb_msg_bob.php"); ?></h1></div>


                    </div>
                </div>
            </div>            

            <footer id="pie_pag" class="main-footer" role="contentinfo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img class="pie-logo" src="images/logoedomex_plasta.svg" alt="Gobierno del Estado de México">
                        <p style="font-weight: bold;" class="main-footer_c text-white">ISEM <?php echo date("Y"); ?></p>
                        <p>Departamento de Ingenieria de Software<br>
                                Correo: isem.desarrollosistemas@edomex.gob.mx<br>
                                Teléfono: 2-26-25-00 Ext: 64121, 64141</p>
                    </div>
                </div>
            </div>
        </footer>               
        </div>      

    </body>



</html>

