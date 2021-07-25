<?php
/**
  -----------------------------------------------------------------
  Configuraci&oacute;n para la Conexi&oacute;n a la Base de Datos//$CFG_HOST = "localhost";
  -----------------------------------------------------------------
 */
//$CFG_HOST = array("127.0.0.1","127.0.0.1");
//$CFG_USER = array("sisepi","uepi");
//$CFG_DBPWD = array("s1s3p1","123");
//$CFG_DBASE = array("sisepi_db","db_epi");
//31.170.161.43
$CFG_HOST = array("127.0.0.1");
$CFG_USER = array("u208944395_ingreso");
$CFG_DBPWD = array("Ingreso2021");
$CFG_DBASE = array("u208944395_ingreso");





define("_CFGSBASE", "SYS_NUEVA");
$NOM_SYS = "SYS_NUEVA";
include_once("session.php");
$__SESSION = new Session(_CFGSBASE);
$nombre = "Examen de Ingreso ENSVT";
$path = "/ingreso";
error_reporting(0);
ini_set('upload_max_filesize', '900M');
ini_set('post_max_size ', '900M');
$abre_s = "Examen de ingreso ENSVT";
$CFG_WEBMASTER = "root@localhost.com";
$CFG_ANYO = "2020";
$CFG_TITLE = $nombre;
$nombre_corto = "Examen de Ingreso ENSVT";
$pasword_encript['persona']="I_p3rs0n4_@";
//Mensajes del sistema
$CFG_MSG[1] = "El usuario no esta registrado";
$CFG_MSG[2] = "Password incorrecto";
$CFG_MSG[3] = "";

$sh_errores_sys=1;// 0-no desplegar sqls, 1- desplegar si hay errores de sql en sistema
$crear_logs_sys=1;//0-no crear, 1- Generar completos(con exito y errores), 2.- solo errores


$direccion_s="http://ddsisem.edomex.gob.mx/sisepi";
//$host_correo='smtp.gmail.com';
//$puerto_correo=465;
//$correo_e='sicoaa.web@gmail.com';
//$con_correo='s1c004w3b';
//$metodo_cif='ssl';

$host_correo='smtp-mail.outlook.com';
$puerto_correo=587;
$correo_e='isem.ventanillaqr@edomex.gob.mx';
$con_correo='HP8Z$q8Z';
$metodo_cif='tls';

$dir_file="D:/repositorio_archivos/sisepi/";
if(file_exists($dir_file)){
    define("FILE_SISTEMAS",$dir_file);
}else{
    $dir_file="E:/repositorio_archivos/sisepi/";       
    define("FILE_SISTEMAS",$dir_file); 
}



$CFG_MAX_FILE_UPLOAD_SIZE = (1024 * 1024 * 10);
$CFG_MIME_TYPE = ARRAY();
$CFG_MIME_TYPE[] = "application/pdf";
$CFG_MIME_TYPE[] = "image/jpeg";
$CFG_MIME_TYPE[] = "image/jpg";
$CFG_MIME_TYPE[] = "image/png";
$CFG_MIME_TYPE[] = "image/gif";

//$CFG_PERIODO=ARRAY('fec_ini','fec_fin');
$CFG_TABLA_FIELD = array();
$CFG_TABLA_FIELD[] = array('Area :', 'cve_area', array('cve_area'), array('area'), 'area', 'a', array('num'));
$CFG_TABLA_FIELD[] = array('Servicio :', 'cve_servicios', array('cve_servicios'), array('servicio'), 'servicios', 's', array('num'));
$CFG_TABLA_FIELD[] = array('Sexo :', 'cve_sexo', array('cve_sexo'), array('sexo'), 'sexo', 'e', array('num'));
$CFG_TABLA_FIELD[] = array('Prefijo :', 'cve_prefijo', array('cve_prefijo'), array('cve_prefijo'), 'prefijos', 'r', array('num'));

$CFG_PARAMETER = array();
//$CFG_TIPO_INSTALL=1;
//'1 - Domingo', '2 - Lunes', '3 - Martes', '4 - Mi�rcoles', '5 - Jueves', '6 - Viernes', '7 - S�bado'
//$CFG_DIAS_CAPTURA=array(1,2,3,4,5);
//$CFG_DIAS_CAPTURA=array(1,2,3);
//Colores de BGCOLOR
//Colores de BGCOLOR
$CFG_CONFIG = array();
$CFG_CONFIG['errors'] = TRUE;



$CFG_BGC[0] = '#959C89'; //verde encabezados #006633
$CFG_BGC[1] = '#D8DCC1'; //gris encabezados #E9E7E0
$CFG_BGC[2] = '#E1E6D2'; //verde fondo etiquetas laterales #449955
$CFG_BGC[3] = '#F7F8F3'; //verde fondo columna de datos #99CC99
$CFG_BGC[4] = '#F3FBE3'; //verde fondo de cajas de texto
$CFG_BGC[5] = '#848484'; //gris oscuro, encabezados
$CFG_BGC[6] = '#FFFFFF'; //blanco fondo tablas
$CFG_BGC[7] = '#CADE85'; //fondo onmouseover row #C1D59B#AECD43
$CFG_BGC[8] = '#D70000'; //fondo rojo
$CFG_BGC[9] = '#FFFEEA'; //amarillo claro #D8DCC1
//$CFG_BGC[8] = '#000000';
//$CFG_BGC[9] = '#999999';
$CFG_BGC[10] = '#CCD5B3'; //fondo de tablas ***** #A9C472
$CFG_BGC[11] = '#F8F9F2';
//
//$CFG_BGC[12] = '#649C04';#A5B476
//
//$CFG_BGC[10] = '#CCD5B3';//fondo de tablas ***** #A9C472
//$CFG_BGC[11] = '#F8F9F2';
$CFG_BGC[12] = '#59712F';
$CFG_BGC[13] = '#CEE18E';
$CFG_BGC[14] = '#6D8A39'; //;'#A4C16C'
$CFG_BGC[15] = '#FDFEC7'; #FFF8BF
$CFG_BGC[16] = '#DEEBB4';
$CFG_BGC[17] = '#FFFACE'; //#FFF3D9#FED3A5
$CFG_BGC[18] = '#EFF3CF'; //#FFF3D9#FED3A5
$CFG_BGC[19] = '#B6D158'; //#FFF3D9#FED3A5
$CFG_BGC[20] = '#959F59'; //#FFF3D9#FED3A5
$CFG_BGC[21] = '#959C8A'; //#89C156
$CFG_BGC[22] = '#578D05'; //#89C156 #EFD3D3
$CFG_BGC[23] = '#EFD3D3'; //#89C156 rosa
$CFG_BGC[24] = '#A40000'; //fondo rojo
$CFG_BGC[25] = '#FF993A'; //fondo naranja 
$CFG_BGC[26] = '#6699D2'; //fondo AZUL
$CFG_BGC[27] = '#FCFCF3'; //
$CFG_BGC[28] = '#356191';
$CFG_BGC[29] = '#C1DDA4'; //verde li CLARO
$CFG_BGC[30] = '#FDF053'; //verde li CLARO
$CFG_BGC[31] = '#EAEDE0'; //verde li CLARO#FFFF00
$CFG_BGC[32] = '#FFFF00'; //verde li CLARO
$CFG_BGC[33] = '#04B404'; //verde li CLARO
//#649C04
//$CFG_BGC[12] = '#F7F5F2';
//$CFG_BGC[13] = '#D70000';//fondo rojo
//$CFG_BGC[14] = '#FFFEEA';
//$CFG_BGC[15] = '#D3D6C5';
//$CFG_BGC[16] = '#B7B7B7';
//$CFG_BGC[17] = '#C1D59B';
//Colores de RGB
$CFG_RGB = array();
$CFG_RGB[] = array(0, 0, 0); //Negro //0
$CFG_RGB[] = array(255, 255, 255); //Blanco //1
$CFG_RGB[] = array(255, 0, 0); //Rojo //2
$CFG_RGB[] = array(255, 128, 0); //Naranja //3
$CFG_RGB[] = array(255, 255, 0); //Amarillo Amarillo //4
$CFG_RGB[] = array(255, 255, 210); //Amarillo Claro //5
$CFG_RGB[] = array(0, 128, 0); //Verde //6
$CFG_RGB[] = array(0, 0, 128); //Azul Obscuro //7
$CFG_RGB[] = array(217, 242, 255); //Azul claro //8
$CFG_RGB[] = array(125, 125, 125); //Gris oBSCURO //9
$CFG_RGB[] = array(200, 200, 200); //Gris Mediano //10
$CFG_RGB[] = array(240, 240, 240); //Gris Claro //11
//colores de fuente
$CFG_FCOLOR = array();
$CFG_FCOLOR[0] = 'fontwhite';
$CFG_FCOLOR[1] = 'fontblack';
$CFG_FSIZE = array();
$CFG_FSIZE[0] = 'fsize07em';
$CFG_FSIZE[1] = 'fsize02em';

//fuentes  Arial11CenterWhiteUPBold 
$CFG_STYLE = array();
$CFG_STYLE[0] = 'modulo_titulo';
$CFG_STYLE[1] = 'modulo_rtitulo';
$CFG_STYLE[2] = 'cell_titulo';
$CFG_STYLE[3] = 'radius_tl';
$CFG_STYLE[4] = 'border_tlr';
$CFG_STYLE[5] = 'radius_tr';
$CFG_STYLE[6] = 'cell_all';
$CFG_STYLE[7] = 'cell_niv';
$CFG_STYLE[8] = 'radius_bl';
$CFG_STYLE[9] = 'radius_br';
$CFG_STYLE[10] = 'border_tb';
$CFG_STYLE[11] = 'modulo_rltitulo';
$CFG_STYLE[12] = 'cell_allEdit';
$CFG_STYLE[13] = 'border_tb_edit';
$CFG_STYLE[14] = 'modulo_rtitulo2';


$CFG_LBL = array();
$CFG_LBL[0] = 'Arial11GreyUP'; //Arial11WhiteUP
$CFG_LBL[1] = 'Arial11pxLeftBoldUP';
$CFG_LBL[2] = 'Arial11CenterWhiteUP';
$CFG_LBL[3] = 'Arial11CenterWhite';
$CFG_LBL[4] = 'Arial11pxJOxide';
$CFG_LBL[5] = 'Arial11';
$CFG_LBL[6] = 'Arial11pxRed';
$CFG_LBL[7] = 'Arial11Center';
$CFG_LBL[8] = 'Arial11pxLeftEFF3CFBoldUP';
$CFG_LBL[9] = 'Arial11RedUP';
$CFG_LBL[10] = 'Arial11CenterWhiteUPBold';
$CFG_LBL[11] = 'Arial12CenterUP';
$CFG_LBL[12] = 'Arial12CenterWhiteUP';
$CFG_LBL[13] = 'Arial11Black';
$CFG_LBL[14] = 'Arial11CenterBlackUP';
$CFG_LBL[15] = 'Arial11RBlack';
$CFG_LBL[16] = 'Arial11CenterBlack';
$CFG_LBL[17] = 'Arial11LBlackUP'; //
$CFG_LBL[18] = 'Arial11CenterOxideUP'; //
$CFG_LBL[19] = 'Arial11pxLeftOxideUP';
$CFG_LBL[20] = 'Arial11RightOxideUP'; //
$CFG_LBL[21] = 'Arial11RBlackUP';
$CFG_LBL[22] = 'Arial11CenterVerde627832UP'; //
$CFG_LBL[23] = 'Arial11LeftVerde627832UP';
$CFG_LBL[24] = 'Arial11RightVerde627832UP'; //
$CFG_LBL[25] = 'Arial11pxJBlack';
$CFG_LBL[26] = 'Arial11White';
$CFG_LBL[27] = 'Arial11pxRBlack';
$CFG_LBL[28] = 'Arial12pxCenterBlackUP';
$CFG_LBL[29] = 'Arial11pxLeftOxideUP'; //Arial11pxLeftVerde627832
$CFG_LBL[30] = 'Arial11pxDarkGray'; //$CFG_LBL[30]='Arial9px';
$CFG_LBL[31] = 'Arial11pxWhiteUP';
$CFG_LBL[32] = 'Arial11pxGrey';
$CFG_LBL[33] = 'Arial11pxLeftVerde627832';
$CFG_LBL[34] = 'Arial11pxLeftVerde2E3C00';
$CFG_LBL[35] = 'Arial11pxCenterVerde627832';
$CFG_LBL[36] = 'Arial11pxBlackUP';
$CFG_LBL[37] = 'Arial12pxCenterGreyB';
$CFG_LBL[38] = 'Arial9pxCenterBlackUP';
$CFG_LBL[39] = 'Arial11WhiteUP';
$CFG_LBL[40] = 'Arial9pxRight';
$CFG_LBL[41] = 'Arial9pxCenter';
$CFG_LBL[42] = 'Arial10pxCenterVerde627832';
$CFG_LBL[43] = 'Arial9pxDarkOxide'; //Arial9pxDarkOxide
$CFG_LBL[44] = 'Arial9pxBlack'; //Arial10pxDarkGrayR
$CFG_LBL[45] = 'Arial10pxDarkGrayR'; //
$CFG_LBL[46] = 'Arial11pxCenter';
$CFG_LBL[47] = 'Arial9pxln_hgCenterUP';
$CFG_LBL[48] = 'Arial11LeftOxide';

$CFG_STRRGB = array();
//$CFG_STRRGB[1]='RGB(182, 209, 88)';
$CFG_STRRGB[1] = 'RGB(202, 222, 133)';
$CFG_STRRGB[2] = 'RGB(239, 243, 207)';


//estilos |
//$CFG_STYLE[0]='opt';
//$CFG_STYLE[1]='opt_F3FBE3';
//mensajes
//mensajes de error
//$CFG_MSG[0]='<span style=\'color:#000000;\'>+  accion realizada con exito</span>';
//$CFG_MSG[1]='<span style=\'font-weight:bold; font-size=13px\'>* la accion solicitada no es valida</span>';
//$CFG_MSG[2]='<span style=\'font-weight:bold; font-size=13px\'>* accion cancelada</span>';
//$CFG_MSG[3]='<span style=\'font-weight:bold; font-size=13px;color:#627832;\'>! el registro se guardo!</span>';
//$CFG_MSG[4]='<span style=\'font-weight:bold; font-size=13px;color:#627832;\'>! el registro se modifico!</span>';
//$CFG_MSG[5]='<span style=\'font-weight:bold; font-size=13px;color:#627832;\'>! el registro se dio de baja!</span>';
//$CFG_MSG[6]='<span style=\'font-weight:bold; font-size=13px\'>* el valor es requerido</span>';
//$CFG_MSG[7]='<span style=\'font-weight:bold; font-size=13px\'>* busqueda vacia</span>';
//$CFG_MSG[8]='<span style=\'font-weight:bold; font-size=13px\'>* la clave ya existe</span>';

$CFG_MSG[0] = '<script>alertify.success("+  accion realizada con exito");</script>';
$CFG_MSG[1] = '<script>alertify.error("* la accion solicitada no es valida");</script>';
$CFG_MSG[2] = '<script>alertify.error("accion cancelada");</script>';
$CFG_MSG[3] = '<script>alertify.success("! el registro se guardo!");</script>';
$CFG_MSG[4] = '<script>alertify.success("! el registro se modifico!");</script>';
$CFG_MSG[5] = '<script>alertify.success("! el registro se dio de baja!");</script>';
$CFG_MSG[6] = '<div class="alert alert-danger" style="margin-bottom:1px;    padding: .2rem .2rem;" role="alert">* el valor es requerido</div>';
$CFG_MSG[7] = '<div class="alert alert-danger" style="margin-bottom:1px;    padding: .2rem .2rem;" role="alert">&nbsp;&nbsp;* busqueda vacia</div>';
$CFG_MSG[8] = '<script>alertify.error("* la clave ya existe");</script>';
$CFG_MSG[9] = '<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #FE8484;">
                            <h4 class="modal-title text-light" id="mediumModalLabel">Advertencia</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="sufee-login d-flex align-content-center flex-wrap" >
                            <div class="container" id="login_id" style="display: block;">
                                <div class="login-content">
                                    <div class="login-logo">
                                        <div class="text-center">
                                            <h5 class="text-dark">� I M P O R T A N T E !</h5>
                                            <p class="text-danger">n&uacute;mero de solicitud de servicio generada:</p>
                                            <div class="alert alert-danger text-center" role="alert">
                                                ' . ($__SESSION->getValueSession('valAlert')) . '
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>';
$CFG_MSG[10] = '<script>alertify.error("* datos incompletos<");</script>';
$CFG_MSG[11] = '<script>alertify.error("* no es valido");</script>';
$CFG_MSG[12] = '<script>alertify.error("se envio aviso de correo por asignaci�n");</script>';
$CFG_MSG[13] = '<script>alertify.error("ocurrio un error al intentar enviar el correo de aviso de asignacion");</script>';
$CFG_MSG[14] = '<script>alertify.error("* el archivo execede el tama&ntilde;o maximo de archivo que es de: ' . ($CFG_MAX_FILE_UPLOAD_SIZE / (1024 * 1024)) . ' MB ");</script>';
$CFG_MSG[15] = '<script>alertify.error("* no es un tipo de archivo valido");</script>';
$CFG_MSG[16] = '<script>alertify.error("* ocurrio un error inesperado");</script>';
$CFG_MSG[17] = '<script>alertify.error("� de todas formas desea guardar el registro ?");</script>';
$CFG_MSG[52] = '<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #FE8484;">
                            <h4 class="modal-title text-light" id="mediumModalLabel">Advertencia</h4>
                            <button type="button" onclick="$("#modal_msg").modal("hide");limpia();" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="sufee-login d-flex align-content-center flex-wrap" >
                            <div class="container" id="login_id" style="display: block;">
                                <div class="login-content">
                                    <div class="login-logo">
                                        <div class="text-center">
                                            <p class="text-dark">&iexcl; No se puede realizar el cambio !</p>
                                            <div class="alert alert-danger text-dark" role="alert">
                                                El folio ya existe
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>';

function envia_correo($correo,$mensaje, $sistema, $other = '',$archivo='') {
    global $host_correo;
    global $puerto_correo;
    global $correo_e;
    global $con_correo;
    global $metodo_cif;    
    $enviado=false;
    include("class/class.phpmailer.php");
    include("class/class.smtp.php");
    //die($host_correo." ".$puerto_correo." ".$correo_e." ".$con_correo);
    // smtp-mail.outlook.com 587 isem.ventanillaqr@edomex.gob.mx HP8Z$q8Z
    $asunto = $sistema;
    $tabla_men = $mensaje;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $metodo_cif;
    $mail->Host = $host_correo;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Port = $puerto_correo;
    $mail->Username = $correo_e;
    $mail->Password = $con_correo;
    $mail->From = $correo_e;
    $mail->AddBCC = $correo_e;
    $mail->AddReplyTo = $correo_e;
    $mail->FromName = "".$sistema;
    $mail->Subject = $asunto;
    $mail->MsgHTML($tabla_men);
    $mail->AddAddress($correo, $other);
    if(strlen(trim($archivo))>0){
        $mail->AddAttachment($archivo);
    }
    
    $mail->IsHTML(true);
    if (!$mail->Send()) {
        //   echo " \r\n" . date('Y-m-d H:i:s') . "\t Error: " . $mail->ErrorInfo . " \r\n";
    } else {
        $enviado=true;
        // echo date('Y-m-d H:i:s') . "\t Mensaje enviado correctamente \r\n";
    }
    return $enviado;
}
?>