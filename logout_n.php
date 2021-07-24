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
<html lang="es-MX">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistema de diplomas</title>
        <meta name="description" content="Cuestionario Hostigamiento">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">        
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/fontastic.css">
        <link rel="stylesheet" href="css/custom.css">
   

        <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="js/plugins.js"></script>

    </head>
    <body>
        <div class="page bg-white">
            <header class="header">
                <nav class="navbar bg-white">
                    <div class="container-fluid">
                        <div class="navbar-holder d-flex align-items-center justify-content-between">
                            <div class="navbar-header"></div>
                            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                <li class="nav-item"><a class="nav-link logout text-success" data-target="#mediumModal" href="#" data-toggle="modal"  id="language" aria-haspopup="true" aria-expanded="true"> <i class="fa fa-cog"></i>&nbsp;Logout</a></li>
                                <li class="nav-item">                            
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img class="user-avatar rounded" style="width:32px;" src="img/gemc.jpg.jpg" alt="Usuario">
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>
            </header>  
            <div class="bg-light">
                <div class="col-sm-12">
                    <div class="page-header bg-light">
                        <div class="page-title text-center">
                            <h2 class=""><?php echo ''.$nombre; ?></h2>
                        </div>
                    </div>
                </div>
            </div>             
            <div class="content m-1">
                <div class="animated fadeIn">


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body card-block" id="d_gen">

                                        <div class="row form-group">
                                            <div class="col-12 col-md-12 text-center"><h1><?php include_once("includes/sb_msg_red.php"); ?></h1></div>
                                        
                                        </div>     
 
                          
                                </div>
                            </div>
                         
                            
                    </div>                   

                </div>
            </div>
        </div>
           
        </div>      
    
    </body>



</html>

