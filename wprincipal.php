<?php
//die("SADSAD AS");
if (strlen(session_id()) == 0) {
    session_start();
    include_once("config/cfg.php");
}

//else{include_once("config/cfg.php"); if (isset($_SESSION[_CFGSBASE]))unset($_SESSION[_CFGSBASE]);}
//	echo "<pre>";	
//	print_r($__SESSION->getAll());
//	echo "</pre>";	
//	die();
/* -------------------------------------------------------
  -------------------------------------------------------
  -------------------------------------------------------
  Principal - Distribucion de espacios
 */
//echo '<pre>';
//print_r($__SESSION->getAll());die();
$str_check = FALSE;
include_once("lib/lib32.php");
include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("includes/sb_check.php");
ini_set("display_errors", 1);

//echo "<pre>";
//print_r($__SESSION->getAll());
//die($str_check);
if ($str_check) {
    ?>
    <!DOCTYPE html>
    <html lang="es-MX">

        <head>

            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?php
                $desc_titulo = "";
                if ($_GET['mod'] > 0) {
                    $classconsul = new Entidad(array('des_modulo'), array(''));
                    $classconsul->ListaEntidades(array('des_modulo'), 'sb_modulo', " where cve_modulo=" . $_GET['mod']);
                    $desc_titulo = "";
                    if ($classconsul->NumReg > 0) {
                        $classconsul->VerDatosEntidad(0, array('des_modulo'));
                        $desc_titulo = " Modulo " . $classconsul->des_modulo;
                    }
                    $desc_titulo = $CFG_TITLE . $desc_titulo;
                } else {
                    $desc_titulo = $CFG_TITLE;
                }
                print $desc_titulo;
                ?>
            </title>
            <meta property="og:title" content="<?php print $CFG_TITLE; ?>" />
            <meta property="og:type" content="website" />            
            <meta property="og:description" content="<?php print $CFG_TITLE; ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="icon" type="image/svg+xml" href="images/favicon_edomex.svg" sizes="any"> 
            <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">      
            <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />      
            <link rel="stylesheet" type="text/css" href="css/contextMenu.min.css" />            
            <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
            <link rel="stylesheet" href="css/fontastic.css">
            <link rel="stylesheet" href="css/custom.css">
            <?php 
            if ($__SESSION->getValueSession('theme')*1 ==2){
                echo '<link href="css/jquery-ui_light.css" rel="stylesheet">';
            }else if($__SESSION->getValueSession('theme')*1 ==1){
                echo '<link href="css/jquery-ui_dark.css" rel="stylesheet">';
            }else if($__SESSION->getValueSession('theme')*1 ==0){
                echo '<link href="css/jquery-ui.min.css" rel="stylesheet">';
            }
            ?>
            <link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker-addon.css"/>
            <link rel="stylesheet" href="css/alertify.css"/>
            <link rel="stylesheet" type="text/css" href="css/jquery.webui-popover.min.css"/>        
            <link href="css/uploadfile.css" rel="stylesheet">
            <link href="css/front.css" rel="stylesheet">
            <link rel="stylesheet" href="css/select2.min.css">

            <!--<link rel="stylesheet" href="css/colorpicker.css" type="text/css" />-->
            <!--<link href="css/bootstrap-colorpicker.min.css" rel="stylesheet">-->

            <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
            <script src="vendor/popper-js/umd/popper.min.js"></script>
            <script src="js/jquery.ui.position.min.js"></script>                 
            <script src="js/contextMenu.min.js"></script>
            <script src="js/jquery-ui.min.js"></script>
            <script src="js/jquery-ui-timepicker-addon.js"></script>               
            <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
            <script src="vendor/jquery.cookie/jquery.cookie.js"></script>
            <script src="js/jscolor.js"></script>
            <script src="js/alertify.js"></script>  
            <script src="js/jsval_mod.js"></script>
            <script src="ajax.js"></script>
            <script src="js/select2.full.js"></script>
            <script src="js/jquery.webui-popover.min.js"></script>            
            <script src="vendor/jquery/uploadfile.min.js"></script>


            <script>
            <?php 
            if ($__SESSION->getValueSession('theme')*1 ==2){
                echo 'var v_tc=2;';
            }else if($__SESSION->getValueSession('theme')*1 ==1){
                echo 'var v_tc=1;';
            }else if($__SESSION->getValueSession('theme')*1 ==0){
                echo 'var v_tc=0;';
            }
            ?>                
                document.reTKey = true;
                function openInIframe(URL) {
                    window.frames.miiframe.location.href = URL;
                }
                function openInIframe5(cadena1) {
                    var $preparingFileModal = $("#preparing-file-modal");
                    $preparingFileModal.dialog({height: 300, width: 350, modal: true});
                    load_response('miiframe', cadena1);
                }
                function load_response(target, cadena1) {
                    var myConnection = new XHConn();
                    if (!myConnection)
                        alert("XMLHTTP no esta disponible. Int�ntalo con un navegador m�s nuevo.");
                    var peticion = function (oXML) {
                        $("#" + target).html(oXML.responseText);

                        var $preparingFileModal = $("#preparing-file-modal");
                        $preparingFileModal.dialog('close');
                    };
                    var pars = cadena1.split('?');
                    myConnection.connect(pars[0], "GET", pars[1], peticion);
                }
                function hideBox(objBox) {
                    document.getElementById(objBox).style.display = "none";
                }
                function abrir(URL) {
                    winform = window.open(URL, "_blank", "top=10,left=180,width=980,height=780,status=no,"
                            + "resizable=yes,location=no,menubar=no,titlebar=no,toolbar=no, scrollbars=yes", false)
                    winform.window.location.assign(URL);
                    winform.focus();
                }
                function actopt(cmb) {
                    var mival = "";
                    if (cmb.options.length > 0) {
                        for (var i = 0; i < cmb.options.length; i++) {
                            if (mival.length > 0)
                                mival = mival + "@|";
                            mival = mival + cmb.options[i].value;
                        }
                    }
                    return mival;
                }
                function A(e, ind, CACT, CDES, CDES2, strRGB) {
                    var C = CACT;
                    var color = document.getElementById(e.id).style.backgroundColor;
                    if (color.toUpperCase().toString() == CACT || color.toUpperCase().toString() == strRGB) {
                        C = CDES;
                        if (ind % 2) {
                            C = CDES2;
                        }
                    } else {
                        C = CACT;
                    }
                    document.getElementById(e.id).style.backgroundColor = C;
                }
                function B(e, ind, CACT, CACT2, strRGB) {
                    var C = CACT;
                    var color = document.getElementById(e.id).style.backgroundColor;
                    if (color.toUpperCase().toString() == CACT || color.toUpperCase().toString() == strRGB) {
                    } else {
                        C = CACT2;
                    }
                    document.getElementById(e.id).style.backgroundColor = C;
                }
                function C(e, ind, CACT, CDES, CDES2, strRGB) {
                    var C = CACT;
                    var color = document.getElementById(e.id).style.backgroundColor;
                    if (color.toUpperCase().toString() == CACT || color.toUpperCase().toString() == strRGB) {
                    } else {
                        C = CDES;
                        if (ind % 2) {
                            C = CDES2;
                        }
                    }
                    document.getElementById(e.id).style.backgroundColor = C;
                }



                function abrir2(URL) {
                    winform = window.open(URL, "_blank", "top=10,left=180,width=980,height=780,status=no,"
                            + "resizable=yes,location=no,menubar=no,titlebar=no,toolbar=no, scrollbars=yes", false)
                    winform.window.location.assign(URL);
                    winform.focus();
                }

            </script>                 

            <?php
            $field = array();
            /* $field[]=array('0 - nombre','1 - tabla',
              '2 - posicion en el registro','3 - valor inicial' */
            $modulo = 0;
            $dmenu = false;
            // $pag_centro="sinmodulo.php";
            //$pag_centro = "includes/diagrama_prin.php";

            /* echo "<pre>";
              print_r($_GET);
              die(); */

            if (isset($_GET['mod']) && $_GET['mod'] <> -1) {
                $modulo = $_GET['mod'];
                $__SESSION->setValueSession('opc', '0');
                $__SESSION->setValueSession('msg', '0');
                $__SESSION->setValueSession('pag', '1');
                $__SESSION->setValueSession('mod', $modulo);
                if ($__SESSION->getValueSession('niv') <> "")
                    $__SESSION->unsetSession('niv');
                if ($__SESSION->getValueSession('valSearch') <> "") {
                    $__SESSION->unsetSession('valSearch');
                    $__SESSION->unsetSession('itemSearch');
                }
                if ($__SESSION->getValueSession('orden_c') <> "") {
                    $__SESSION->unsetSession('orden_c');
                }
                if ($__SESSION->getValueSession('where_add') <> "") {
                    $__SESSION->unsetSession('where_add');
                }
            } else {
//                            echo '<pre>';
//                            print_r($__SESSION->getAll());die();                    
                if ($__SESSION->getValueSession('mod') <> "") {
//                    echo '<pre>';
//                    print_r($_GET);die();
                    if ($_GET['mod'] == -1) {
                        $__SESSION->unsetSession('mod');
                        $__SESSION->setValueSession('mod', 9999);
                        $modulo = $__SESSION->getValueSession('mod');
                        if ($__SESSION->getValueSession('cveusergroup') == 1975) {
                            $pag_centro = "sinmodulonada.php";
                        } else {
                            $pag_centro = "sinmodulo.php";
                        }
                    } else {
                        if ($__SESSION->getValueSession('mod') == 9999) {
                            if ($__SESSION->getValueSession('cveusergroup') == 1975) {
                                //$pag_centro = "index.php?mod=208";
                                $pag_centro = "sinmodulonada.php";
                            } else {
                                $pag_centro = "sinmodulo.php";
                            }
                        } else {
                            $modulo = $__SESSION->getValueSession('mod');
                        }
                    }
                } else {
                    if ($__SESSION->getValueSession('cveperfil') == 567) {
                        $__SESSION->setValueSession('mod', 9999);
                        $pag_centro = "sinmodulonada.php";
                    } else {

                        $__SESSION->setValueSession('mod', 9999);
                        $modulo = $__SESSION->getValueSession('mod');
                        //die($__SESSION->getValueSession('cveusergroup')."rrr");
                        if ($__SESSION->getValueSession('cveusergroup') <> 1975)
                            $pag_centro = "sinmodulo.php";
                    }
                }
            }

            $str_print = "";
            if ($modulo > 0) {
                $field[] = array('cve_perfil', 'modulo', '0', 0);
                $field[] = array('cve_modulo', 'modulo', '1', 0);
                $field[] = array('url_include', 'modulo', '1', "");
                $field[] = array('parametro', 'modulo', '1', "");
                $field[] = array('hiddhab', 'modulo', '1', "");
                $allf = array();
                $allv = array();
                foreach ($field as $afield) {
                    $allf[] = $afield[0];
                    $allv[] = $afield[3];
                }
                $IdPrin = '';
                $strInclude = "";
                foreach ($field as $afield)
                    if ($afield[2] == '0') {
                        $IdPrin = $afield[0];
                        break;
                    }
                $$IdPrin = $__SESSION->getValueSession('cveperfil');
                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");
                $tabla = 'sb_perfil_modulo,sb_modulo';
                $strWhere = "Where sb_perfil_modulo.cve_perfil=" . $$IdPrin;
                $strWhere .= " and sb_perfil_modulo.cve_modulo=" . $modulo;
                $strWhere .= " and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
                $strWhere .= " and sb_modulo.sta_modulo <>0";
                $classmod = new Entidad($allf, $allv);
                $classmod->Set_Item($IdPrin, $$IdPrin);
                $classmod->Consultar($allf, $IdPrin, $tabla, $strWhere);

                /* echo "<pre>";
                  print_r($classmod);
                  die(); */

                $inthiddhab = $classmod->hiddhab;
                if ($classmod->NumReg > 0) {
                    $strInclude = $classmod->url_include;
                    if (!is_null($classmod->parametro) && $classmod->parametro <> "") {
                        $a_params_mod = array();
                        $a_params_mod = explode('::', $classmod->parametro);
                        foreach ($a_params_mod as $item_param_mod) {
                            $a_param_mod = explode('=', $item_param_mod);
                            $$a_param_mod[0] = $a_param_mod[1];
                        }
                    }
                }


                if (strlen($strInclude) > 0) {

                    /* <--------------se define nivel-------------> */
                    if (isset($_GET['nivel'])) {
                        if (!is_null($_GET['nivel']))
                            $__SESSION->setValueSession('niv', intval($_GET['nivel']));
                        $__SESSION->unsetSession('valSearch');
                        $__SESSION->unsetSession('itemSearch');
                        $__SESSION->unsetSession('orden_c');
                        $__SESSION->unsetSession('where_add');
                        $opc = 0;
                    } else {
                        if (isset($_POST['nivPo'])) {
                            $__SESSION->setValueSession('niv', intval($_POST['nivPo']));
                        }
                    }

                    /* <---------------------------> */
                    /* <--------------se define nivel-------------> */
                    if (isset($_GET['nivtg']))
                        if (!is_null($_GET['nivtg'])) {
                            $__SESSION->setValueSession('niveles', $__SESSION->getValueSession('niveles' . $_GET['nivtg']));
                            $__SESSION->setValueSession('nivtg_s', $_GET['nivtg']);
                        }
                    /* <---------------------------> */

                    $string_comp = "";
                    if (!is_array($__SESSION->getValueSession('niveles')) && !is_array($__SESSION->getValueSession('nivtg_s'))) {
                        $string_comp = "" . $__SESSION->getValueSession($__SESSION->getValueSession('niveles') . $__SESSION->getValueSession('nivtg_s'));
                    }
                    $vac_n = "";
                    if (!is_array($__SESSION->getValueSession('niveles'))) {
                        $vac_n = $__SESSION->getValueSession('niveles');
                    }
//                                    echo '<pre>';
//                                    print_r($__SESSION->getValueSession('niveles'));die();
                    if ($string_comp == $vac_n && $vac_n <> "") {
                        
                    } else {
                        $__SESSION->setValueSession('nivtg_s', 1);
                    }

                    /* <---------------------------> */
                    if ($__SESSION->getValueSession('niv') <> "") { //if (!is_null($_SESSION['niv']))
                        $xtmsession = $__SESSION->getValueSession('niveles');
                        if (isset($xtmsession[$__SESSION->getValueSession('niv')]))
                            $strInclude = $xtmsession[$__SESSION->getValueSession('niv')];
                    }


                    //									echo "<pre>";					
//print_r('includes/' . $strInclude);
//die();                    $str_print = "";
//$strInclude = "ir_manto_local";

                    include_once('includes/' . $strInclude);
                    //die("aaa_ddd_111");

                    if (!isset($boolkeyValNiv)) {
                        $boolkeyValNiv = false;
                    }

                    if (!isset($intNivel) and (!$boolkeyValNiv)) {
                        $__SESSION->setValueSession('niveles', array($strSelf));
                    }
//die("asd");////////////////////ya no paso

                    if (isset($CFG_DIAS_CAPTURA) && in_array(date("w"), $CFG_DIAS_CAPTURA)) {
                        
                    } else {
                        if (isset($CFG_DIAS_CAPTURA)) {
                            $boolNoEditable = true;
                        }
                    }

                    if (isset($CFG_PERIODO_CAPTURA) && $CFG_PERIODO_CAPTURA == 1 && $inthiddhab == 1) {
                        $strXPcwhere = " select mh.habilitado from modulo_habilitado mh, habilitado h "; //, modulos_apertura msa";
                        $strXPcwhere .= " Where mh.habilitado=h.cve_habilitado and ";
                        //$strXPcwhere.=" am.cve_modulo=msa.cve_modulo and msa.intParam='".$intParam."' and msa.niveles=";
                        $strXPcwhere .= " and h.fecha_inicial <= '" . date("Y-m-d") . "' and";

                        $strXPcwhere .= " h.fecha_final >= '" . date("Y-m-d") . "' and mh.cve_modulo='" . $modulo . "'";
                        //$area_val=array();
                        //$area_des=array();
                        $classXconsul = new Entidad(array('cve_habilitado'), array(0));
                        $classXconsul->ListaEntidades(array(), 'modulo_habilitado', '', '', '', '', $strXPcwhere);
                        if ($classXconsul->NumReg <= 0) {
                            $boolNoEditable = true;
                            $__SESSION->setValueSession('msg', "51");
                        }
                    }

                    $allfields = array();
                    $allvalues = array();
                    foreach ($field as $afield) {
                        $allfields[] = $afield[0];
                        $allvalues[] = $afield[7];
                    }
                    $wtable = $awidths[1] + $awidths[2];
                    $pag_centro = $strwentidad;
                    //
                    /* define cadena back */
                    $str_back = "";
                    if ($__SESSION->getValueSession('niveles') <> "")
//		echo $strSelf;
//		die();
                        foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
                            if ($item == $strSelf) {
                                if ($cont > 0)
                                    $str_back = $_SERVER['PHP_SELF'] . '?nivel=' . ($cont - 1);
                                break;
                            }
                        }

                    /**/
//echo "<pre>";
//print_r($__SESSION->getAll());
//die($pag_centro);
//echo $_SESSION['opc'];				
                    $footer = true;
                    if ($__SESSION->getValueSession('opc') <> "") {
                        switch ($__SESSION->getValueSession('opc')) {
                            case 2:
                                $pag_centro = "addentidad.php";
                                if (isset($ent_add) && strlen($ent_add) > 0)
                                    $pag_centro = $ent_add;
                                $__SESSION->setValueSession('opc', '0');
                                //$footer=false;
                                break;
                            case 3:

                                $pag_centro = "updentidad.php";
                                if (isset($ent_upd) && strlen($ent_upd) > 0)
                                    $pag_centro = $ent_upd;
                                $__SESSION->setValueSession('opc', '0');
                                $footer = false;
                                break;
                            case 4:
                                $pag_centro = "updentidad2.php";
                                $__SESSION->setValueSession('opc', '0');
                                //$footer=false;
                                break;
                            case 10:
                                $pag_centro = "updentidad5.php";
                                if (isset($ent_upd) && strlen($ent_upd) > 0)
                                    $pag_centro = $ent_upd;
                                $__SESSION->setValueSession('opc', '0');
                                //$footer=false;

                                break;
                            case 11:
                                $pag_centro = "updentidad5.php";
                                $footer = false;
                                $__SESSION->setValueSession('opc', '0');
                                $footer = false;
                                break;
                            /* ----------------------------------- */
                        }
                    }
                    if (isset($_GET['op'])) {
                        switch ($_GET['op']) {
                            case 1:
                                $pag_centro = "admentidad.php";
                                //$footer=false;
                                break;
                            /* ----------------------------------- */
                        }
                    }
                    if (isset($_POST['op'])) {
                        switch ($_POST['op']) {
                            case 1:
                                $pag_centro = "admentidad.php";
                                //$footer=false;
                                break;
                            /* ----------------------------------- */
                        }
                    }
                }/* termina conf modulo a visualizar */
                /* <------------ codigo de carga del body -------------> */
                if (function_exists('self_function')) {
                    self_function();
                }
                //if($_SESSION['cveusuario']==1){echo "<style type=\"text/css\">div#top {overflow:scroll; height: 137px;} div#center {top:137;}</style>";}
                //if (in_array($pag_centro,array("entidad3.php","entidad3_p.php")) && isset($content_refresh) && $content_refresh==1){echo "<meta http-equiv='refresh' content='60;URL=". $_SERVER['PHP_SELF'] ."'>";}
            }
            echo "</head><body " . $str_print . " class='main-footer-1'>";
            ?>     

        <div class="page">             
            <!-- Main Navbar-->
            <div id="skip-nav" class="text-center">  
               
            </div>             
            <header class="header" role="banner" id="encabezado-interno">
                <?php
                if ($__SESSION->getValueSession('cveusergroup') == 1973) {
                    echo '<nav class="navbar" style="background-color: #d0d0d0;">
                    <div class="container-fluid">
                        <div class="navbar-holder d-flex align-items-center justify-content-between" style="color:#3CB371;">



                        </div>
                    </div>
                </nav>       ';
                } else {
                    ?>                
                    <div id="barra_top" class="navbar nav_sys">
                        <!-- Search Box-->
                       

                        <div class="container-fluid encabezado">
                            <div class="d-flex justify-content-between barrabotones">
                           

                                <!-- Navbar Header-->
                                <div class="navbar-header">
                                    <!-- Navbar Brand -->
                                        <div class="brand-text d-lg-inline-block">
                                        <img class="encabezado-escudo" src="images/escudo_edomex.svg" alt="Gobierno del Estado de M�xico">
                                       
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="navbar-holder d-flex align-items-center justify-content-between barrabotones">        
                                <div class="botones-derecha">
                                <!-- Navbar Menu -->
                                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                    <!-- Search-->
                                     <?php
                                    if ($__SESSION->getValueSession('cveperfil') == 1 or 1 == 1)
                                        echo '<li id="set_ilum" class="nav-item d-flex align-items-center punteados aj_sys" style="background:inherit;border-radius: 8px;"><a rel="nofollow" href="javascript:a_b();" class="" role="button" aria-label="Cambiar ajustes" title="Cambiar ajustes"> <i class="fa fa-cog fa-spin" style="font-size:20px;" aria-hidden="true"></i></a></li>';
                                    ?>
                                    <?php
                                        $usuario = explode(" ", $__SESSION->getValueSession('desusuario'));
                                        //   echo '' . $usuario[0];
                                    ?>                                    
                                                                   
                                    </ul>
                                </div>   
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </header>          
            <div class="page-content d-flex align-items-stretch bg-white" style="min-height: 590px !important;"> 
                <?php
                if ($__SESSION->getValueSession('cveusergroup') == 1973) {
                    
                } else {
                    ?>
                    <nav id="panel_menu" class="side-navbar menu_sys rounded-bottom" id="left-panel" role="navigation">
                        <!-- Sidebar Header-->
                        <div class="sidebar-header d-flex align-items-center menu_sub_u">
                            <div class="avatar" id="fileuploader"><span class="foto_c">
                                    <?php
                                    $a_idfoto = implode('::', array(('cve_usuario=' . $__SESSION->getValueSession('cveusuario')), ('file_get=img_usuario')));
                                    $str_print_foto = "rowid=" . substr(md5(substr(base64_encode($a_idfoto), 5, 20)), 5, 5) . base64_encode($a_idfoto);
                                    echo "<img alt='Imagen de perfil' class='img-fluid rounded-circle' src=\"./files/getfoto.php?" . $str_print_foto . "\">";
                                    ?></span>
                            </div>	
                            <div class="title">
                                <span class="h6" id="nom_usu_login"><?php
                            echo $__SESSION->getValueSession('nomusuario');
                                    ?></span>
                                <p>                                        <?php
                            $usuario = explode(" ", $__SESSION->getValueSession('desusuario'));
                            // echo '' . $usuario[0];
                            echo $__SESSION->getValueSession('desusuario');
                                    ?></p>
                            </div>
                        </div>
                        
                        <!-- Sidebar Navidation Menus--><span class="heading text-center menu_sub_u">Menu</span>
                        <div id="main-menu" class="menu_prin_sys">
                            <?php
                            include_once("menu2/menu.php");
                            echo $menu2;
                            ?>
                        </div>

                    </nav>    
                    <?php
                }
                ?>
<?php
                    echo '<div class="content-inner principal_sys" style="" id="d_principal" role="main">';

                if ($modulo > 0) {
                    global $str_back;
                    /* <---------------- termina codigo de carga del body ---------------> */
                    //             echo genOTable('0', '', '', '', '', '0', '6', '', "style=\"width:100%; background-color: #FFFFFF;\"");
                    $str_a_onclick = "&nbsp;";
                    if (strlen($str_back) > 0) {
                        $str_a_onclick = "<a href='#' onClick=\"window.location='" . $str_back . "'\" style=\"text-decoration: none;margin:0px; padding:0px;\">" .
                                '<i style="font-size:26px;" aria-hidden="true" class="fa fa-arrow-left text-success"></i>' . "</a>";
                        //$strnuevo.= '<button style="background-color: transparent;border: none;padding: 1px 1px;" type="submit" class="btn btn-default" data-toggle="tooltip" title="Nuevo"><i style="font-size:18px;" aria-hidden="true" class="fa fa-file text-light"></i><i style="margin-left:-5px;font-size:12px;color:red;" class="fa fa-plus-circle"></i></button>';
                    }
                    $str_a_onclick = "";
//                            echo genORen() . genOCol('', '', '', '', '', '0', '0', '');

                    include($pag_centro);
                    if (function_exists("fnBeforeLoad_include")) {
                        fnBeforeLoad_include();
                    }
//                            echo genCCol() . genCRen();
//                            echo genCTable();
                } else {
                    include($pag_centro);
                }
                echo "<div id=\"toolTipBox\" style=\"z-index:100;width:300px;display:none;\"></div>";
                echo "<span id=\"toolHelp\" style=\"color:#000;width:300px;display:none;\"></span></div>";
                ?>
                <!-- Page Footer-->

            </div>     
            <footer id="pie_pag" class="main-footer" role="contentinfo" style="position: fixed;z-index: 2;background-color: #4c4c4c;">
                <div class="container-fluid">
                    <div class="row">
                        <!--                           <div class="col-sm-2">
                                                            <ul class="div_ul text-right">
                                                                <li id="hours" class="div_li rounded">10</li>
                                                                <li class="point div_li rounded">:</li>
                                                                <li id="min" class="div_li rounded">10</li>
                                                                <li class="point div_li rounded">:</li>
                                                                <li id="sec" class="div_li rounded">10</li>
                                                            </ul>                                      
                                                        </div>                                
                                                        <div class="col-sm-5 text-left">
                                                            <div class="clock">
                                                                <div id="Date" class="text-left">sdfs fsdfsdf sdfsd</div>
                        
                                                            </div>                                    
                                                        </div>-->
                        <!--            by |no  -->

                        <div class="col-sm-12 text-center">
                            <p style="font-weight: bold;" class="main-footer_c text-white">ENSVT <?php echo date("Y"); ?></p>
                            <p>Departamento de Ingeniería del Software<br>
                        </div>

                    </div>
                </div>
            </footer> 
        </div>

        <div class="modal" id="pag_prin_m_o" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-light">
                        <h5 class="modal-title">Advertencia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true" class="punteados">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="body_e">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>            
        <!--modal content -->
        <div class="modal fade bd-example-modal-lg" id="pag_dialog" tabindex="-1" aria-labelledby="tit_pag_dialog" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white b_s_sys" style="background-color: #008000;">
                        <h5 class="modal-title" id="tit_pag_dialog">Titulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true" class="text-white punteados">&times;</span>
                        </button>
                    </div>
                    <?php
                    $ar_divs=['','oscuro_3 oscuro_4'];
                    ?>
                    <div class="modal-body <?php echo $ar_divs[$__SESSION->getValueSession('theme') * 1];?>" id="bod_pag_dialog">

                    </div>

                </div>
            </div>
        </div>            
        <!--modal right-->
        <div class="modal fixed-left fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content">

                    <div class="modal-header separ_vera">
                        <p class="modal-title text-white font-weight-bold" id="myModalLabel2">Ajustes del men�</p>
                        <button type="button" class="close text-white font-weight-bold" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true" class="punteados">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <p class="fs--1 text-80">Elige el modo de color para el sistema. </p>
                        <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
                            <div class="btn btn-theme-default custom-control custom-radio custom-radio-success active punteados " onclick="cambia_theme(3);">
                                <label class="cursor-pointer hover-overlay" for="theme-mode-default">
                                    <img class="w-100 rounded" src="images/claro.jpg" alt="">
                                </label>
                                <label class="cursor-pointer mb-0 d-flex justify-content-center pl-3" for="theme-mode-default">
                                    <input class="custom-control-input" id="theme-mode-default" type="radio" name="colorScheme" data-mode="DEFAULT" <?php echo ($__SESSION->getValueSession('theme')*1 ==2?'checked':''); ?> value="theme-mode-default" data-page-url="../index.html">
                                    <span class="custom-control-label">Claro</span>
                                </label>
                            </div>
                            <div class="btn btn-theme-dark custom-control custom-radio custom-radio-success punteados" onclick="cambia_theme(3);">
                                <label class="cursor-pointer hover-overlay" for="theme-mode-dark">
                                    <img class="w-100 rounded" src="images/obscuro.jpg" alt="">
                                </label>
                                <label class="cursor-pointer mb-0 d-flex justify-content-center pl-3" for="theme-mode-dark">
                                    <input class="custom-control-input" id="theme-mode-dark" type="radio" name="colorScheme" data-mode="DEFAULT" <?php echo ($__SESSION->getValueSession('theme')*1 == 1?'checked':''); ?> value="theme-mode-dark" data-page-url="../documentation/dark-mode.html">
                                    <span class="custom-control-label">Oscuro</span>
                                </label>
                            </div>
                            <div class="btn btn-theme-dark custom-control custom-radio custom-radio-success punteados" onclick="cambia_theme(0);">
                                <label class="cursor-pointer hover-overlay" for="theme-mode-normal">
                                    <img class="w-100 rounded" src="images/normal.jpg" alt="">
                                </label>
                                <label class="cursor-pointer mb-0 d-flex justify-content-center pl-3" for="theme-mode-dark">
                                    <input class="custom-control-input" id="theme-mode-normal" type="radio" name="colorScheme" data-mode="DEFAULT" <?php echo ($__SESSION->getValueSession('theme')*1 == 0?'checked':''); ?> value="theme-mode-dark" data-page-url="../documentation/dark-mode.html">
                                    <span class="custom-control-label">Normal</span>
                                </label>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <p class="col-form-label text-80" id="desc_colores_m">Colores del men�:</p>
                            
                            <div role="button" tabindex="0" class="selector_menu_color menu_verde punteados" onclick="cambia_color('');" aria-label="Verde" title="Verde"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_rojo" onclick="cambia_color('menu_rojo');" aria-label="Rojo" title="Rojo"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_aqua" onclick="cambia_color('menu_aqua');" aria-label="Aqua" title="Aqua"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_azul" onclick="cambia_color('menu_azul');" aria-label="Azul" title="Azul"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_morado" onclick="cambia_color('menu_morado');" aria-label="Morado" title="Morado"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_cafe" onclick="cambia_color('menu_cafe');" aria-label="Caf�" title="Caf�"></div>
                            <div role="button" tabindex="0" class="selector_menu_color menu_negro" onclick="cambia_color('menu_negro');" aria-label="Negro" title="Negro"></div>
                            
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="color_f_menu"  class="col-form-label">Color de fuente:</label>
                            <input type="text" class="form-control" id="color_f_menu" value="<?php echo $__SESSION->getValueSession('color_f'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tam_f" class="col-form-label">Tama&ntilde;o de fuente menu:</label>
                            <select id="tam_f" name="tam_f" class="form-control" onChange="cambi_f_s(1, '');">
                                <option value=".6">6</option>
                                <option value=".7">7</option>
                                <option value=".8">8</option>
                                <option value=".9">9</option>
                                <option value="1">10</option>
                                <option value="1.1">11</option>
                                <option value="1.2">12</option>
                                <option value="1.3">13</option>
                            </select>
                        </div>       
                        <div class="form-group">
                            <label for="tam_l" class="col-form-label">Tama&ntilde;o de fuente etiquetas:</label>
                            <select id="tam_l" name="tam_f_l" class="form-control" onChange="cambi_f_l(1, '');">
                                <option value=".6">6</option>
                                <option value=".7">7</option>                                        
                                <option value=".8">8</option>
                                <option value=".9">9</option>
                                <option value="1">10</option>
                                <option value="1.1">11</option>
                                <option value="1.2">12</option>
                                <option value="1.3">13</option>                                        
                            </select>
                        </div>                                     
                    </div>

                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->      


        <script src="js/front.js"></script>    
        <script src="js/menu/MenubarLinks.js"></script>  
        <script src="js/menu/MenubarItemLinks.js"></script>        
        <script src="js/menu/PopupMenuItemLinks.js"></script>  
        <script src="js/menu/PopupMenuLinks.js"></script>     
        
        <script src="css/datatables/jquery.dataTables.min.js"></script>
<script src="css/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="css/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="css/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="css/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="css/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script src="css/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="css/datatables-buttons/js/buttons.print.min.js"></script>
<script src="css/datatables-buttons/js/buttons.colVis.min.js"></script>

        <script>
                                var menubar = new Menubar(document.getElementById('menuaccess'));
                                //menubar.init();
        </script>          
        <script>

           cambia_color('<?php echo $__SESSION->getValueSession('color_menu'); ?>',<?php
                              if ($__SESSION->getValueSession('mod') <> 9999 && $__SESSION->getValueSession('mod') <> -1) {
                                  echo ($__SESSION->getValueSession('mod')) * 1;
                              } else {
                                  echo 0;
                              }
                              ?>);
            //   pinta_modulo();


    <?php
    if (isset($subniveles_1)) {
        echo "$(function() {";
        echo $subniveles_1;
        echo $subniveles;
        echo '});';
    }
    ?>

        </script>
        <script>
           // update_f1('<?php echo $__SESSION->getValueSession('color_f'); ?>');
            cambi_f_s(2, '<?php echo $__SESSION->getValueSession('f_s'); ?>');
            cambi_f_l(2, '<?php echo $__SESSION->getValueSession('f_l'); ?>');
            <?php // 
                $t_theme=0;
                if($__SESSION->getValueSession('theme')*1 ==1){
                    $t_theme=1;
                }else if($__SESSION->getValueSession('theme ')*1 ==2){
                    $t_theme=2;
                }
                echo 'cambia_theme('.$t_theme.');';
            ?>
        </script> 
        <script src="js/accordion.js"></script>
 

        <?php
        if (function_exists("fnBeforeLoad")) {
            //   die("sssssssssssssssssssssssssssssssss");
            fnBeforeLoad();
        } else {
            
        }
        echo "</body>";
    } else {
        include_once("includes/sb_refresh.php");
    }
    ?>

