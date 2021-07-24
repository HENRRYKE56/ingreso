<?php
if (strlen(session_id()) == 0) {
    session_start();
    include_once("config/cfg.php");
} if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/i_refresh.php");
} else {
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    $mensajes = false;
    $dis_input = ' disabled ';
    $classconsul = new Entidad(array('cve_persona', 'edad'), array(''));
    $classconsul->ListaEntidades(array('edad'), 'persona', ' where curp = \'' . ($__SESSION->getValueSession('nomusuario')) . '\'', ' cve_persona,edad ', 'no');
    //inserta perfil usuario
    //die($__SESSION->getValueSession('nomusuario'));
    $edad = 0;
    $muestra_juridico = true;
    $mostrar_con = false;
    $cve_persona = '';
    $id_consentimiento = '';
    $cap_juridica = '';
    $otorgo_cons = '';
    $n_n_a_p = '';
    $ap_n_a_p = '';
    $am_n_a_p = '';
    $acepto_y_protesto = '';
    $email = '';
    $email = '';
    $num_tel = '';
    $e_n = '';
    $adjuntos = 1;
    $adj = '';
    $unico = '';
    $si_adj = 1;
    if ($classconsul->NumReg == 1) {
        $classconsul->VerDatosEntidad(0, array('cve_persona', 'edad'));
        $edades = 'edad';
        $edad = ($classconsul->$edades) * 1;
//        die($edad.":asa");
        $cve_persona = $classconsul->cve_persona;
        if ($edad <= 17) {
            $muestra_juridico = false;
            $mostrar_con = true;
        }
        // die("asdasdas".$mostrar_con);
        $campos = array('id_consentimiento', 'cap_juridica', 'otorgo_cons', 'n_n_a_p', 'ap_n_a_p', 'am_n_a_p', 'acepto_y_protesto', 'email', 'num_tel', 'e_n');
        $classconsul = new Entidad($campos, array('', '', '', '', '', '', '', '', '', ''));
        $consulWhere = " where cve_persona=" . $cve_persona;
        $classconsul->ListaEntidades(array('id_consentimiento'), ' consentimiento ', $consulWhere, " id_consentimiento,cap_juridica,otorgo_cons,n_n_a_p,ap_n_a_p,am_n_a_p,acepto_y_protesto,email,num_tel,e_n ");
        if ($classconsul->NumReg > 0) {
            $classconsul->VerDatosEntidad(0, $campos);
//            echo '<pre>';
//            print_r($classconsul);die();
            $id_consentimiento = $classconsul->id_consentimiento;
            $cap_juridica = $classconsul->cap_juridica;
            $otorgo_cons = $classconsul->otorgo_cons;
            $n_n_a_p = $classconsul->n_n_a_p;
            $ap_n_a_p = $classconsul->ap_n_a_p;
            $am_n_a_p = $classconsul->am_n_a_p;
            $acepto_y_protesto = $classconsul->acepto_y_protesto;
            $email = $classconsul->email;
            $num_tel = $classconsul->num_tel;
            $e_n = $classconsul->e_n;

            $campos = array('cve_tipo_archivo', 'unico', 'file_name', 'internal_name', 'path', 'obs', 'validacion');
            $classconsul = new Entidad($campos, array('', '', '', '', '', '', '', '', '', ''));
            $consulWhere = " where id_consentimiento=" . $id_consentimiento . " and status=1";
            $classconsul->ListaEntidades(array('cve_tipo_archivo'), ' adjuntos ', $consulWhere, " cve_tipo_archivo,unico,file_name,internal_name,path,validacion,obs ");
            for ($i = 0; $i < $classconsul->NumReg; $i++) {
                $classconsul->VerDatosEntidad($i, $campos);
                $si_adj = 2;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->unico;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->file_name;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->internal_name;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->path;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->validacion;
                $adj[$classconsul->cve_tipo_archivo][] = $classconsul->obs;
                if (in_array(($classconsul->cve_tipo_archivo) * 1, array(2, 3, 4)))
                    $adjuntos = 1;
                else if (in_array(($classconsul->cve_tipo_archivo) * 1, array(5, 6, 7)))
                    $adjuntos = 2;
            }
        }
        $classconsul = new Entidad(array('estatus'), array(''));
        $classconsul->ListaEntidades(array('estatus'), 'estatus_persona s JOIN (
SELECT MAX(e.id_estatus_persona)AS ul_es
FROM estatus_persona e
WHERE e.cve_persona = ' . $cve_persona . ') AS t1 ON s.id_estatus_persona=t1.ul_es', ' ', ' s.estatus ', 'no');
        if ($classconsul->NumReg > 0) {
            $classconsul->VerDatosEntidad(0, array('estatus'));
            $estado_per = $classconsul->estatus;
//        echo '<pre>';
//        print_r($classconsul);die();            
            if (($estado_per) * 1 == 1 || ($estado_per) * 1 == 4) {
                $dis_input = '';
            } else {
                if ($estado_per == 2) {
                    $mensajes = true;
                    echo '<script>window.location = "index.php?mod=216";</script>';
                }
            }
        }
    }
    if ($mensajes) {
        $msn_per = '';
        if ($estado_per == 2) {
            $msn_per = "La informacion esta siendo validada por el personal normativo";
        }
        echo '    <div class="row" >
                    <div class="col-1"></div>
                    <div class="col-10" style="background-color: #fff8dc;" class="border rounded text-center font-weight-bold"><h2 class="h5 text-80 text-center" aria-describedby="seg">Seguimiento de la informacion</h2><p class="text-80 h6 text-center font-weigh-bold" id="seg">' . $msn_per . '.<br />Consultar mas tarde</p>
                    </div>
                    <div class="col-1"></div>
                 </div>';
    } else {
        ?>

        <div class="row" >
            <div class="col-1"></div>
            <div class="col-10" style="background-color: #fff8dc;" class="border rounded">

                <?php
                //die("asda".  ($cap_juridica));
                if ($muestra_juridico) {
                    echo '<label class="text-80 font-weight-bold" for="cap_juridica">¿Cuenta usted con capacidad jurídica?</label>
                        <select class="form-control" id="cap_juridica" ' . $dis_input . '>
  <option value="" ' . (strlen($cap_juridica) == 0 || ($estado_per == 4 && $cap_juridica = 0) ? '' : '') . '>Seleccione opcion</option>
  <option value="1" ' . ($cap_juridica == 1 && strlen($cap_juridica) > 0 ? 'selected' : '') . ' >SI</option>
  <option value="0" ' . (($cap_juridica == 0 && $estado_per != 4) && strlen($cap_juridica) > 0 ? 'selected' : '') . ' >NO</option>
</select>';
                }
                // die($cap_juridica."asdasda");
                ?>
                <br />
                <button type="button" id="btn_cont_f" class="btn boton_act punteados" style="<?php echo ($cap_juridica == 1 ? 'display:block;' : 'display:none;'); ?>" onclick="sigue_mod();"><span id="i_cont_f"></span>CONTINUAR</button>
                <div id="c_show" style="<?php echo ($mostrar_con ? 'display:block;' : ($cap_juridica == 1 && strlen($cap_juridica) > 0 ? 'display:none;' : (strlen($cap_juridica) == 0 ? 'display:none' : 'display:block;'))) ?>;">            
                    <h2 class="h5 text-center font-weight-bold">CONSENTIMIENTO INFORMADO PARA REGISTRAR A PERSONAS CON DISCAPACIDAD EN EL ESTADO DE MÉXICO</h2>
                    <h3 class="h6 text-center">(CUANDO SE TRATE DE NIÑAS, NIÑOS, ADOLESCENTES O PERSONAS MAYORES DE EDAD SIN CAPACIDAD JURÍDICA)</h3>
                    <p class="text-justify text-80">
                        Con fundamento en lo dispuesto por el artículo 32 de la Ley para la Protección, Integración y Desarrollo de las Personas con Discapacidad del Estado de México, el Registro Estatal de Discapacidad, es implementado por el Instituto Mexiquense para la Protección e Integración al Desarrollo de las Personas con Discapacidad, con la finalidad de poder detectar y evaluar la condición de discapacidad de las personas, y coadyuvarán para su actualización La Secretaría de Salud, el DIFEM así como los Sistemas para el Desarrollo Integral de la Familia municipales.<br /><br />

                        Para ello, es indispensable poder obtener la información especificada en la plataforma del Registro Estatal de Discapacidad, ahora bien, al tratarse de datos personales ya sea de niñas, niños, adolescentes, o bien, de personas mayores de edad sin capacidad jurídica, y a efecto de privilegiar el interés superior de éstos, con fundamento en lo dispuesto en la Ley General de los Derechos de Niñas, Niños y Adolescentes, la Ley de Niñas, Niños y Adolescentes del Estado de México, así como lo dispuesto por los artículos 4.204, 4.240, 4.242, 4.244, 4.253, 4.262 y 4.269 del Código Civil del Estado de México, en relación con los artículos 7 y 8 de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de México y Municipios, es necesario otorgar el consentimiento para el tratamiento de sus datos personales por conducto de la o el titular de la patria potestad o tutela, en este sentido, no es posible publicar los datos personales de niñas, niños, adolescentes, o bien, de personas mayores sin capacidad jurídica, con discapacidad, a menos que exista el consentimiento expreso de su representante.<br /><br />

                        Razón por la cual, resulta inminente otorgar el consentimiento expreso para poder realizar el tratamiento de los datos personales, con la finalidad especificada en el Aviso de Privacidad del Registro Estatal de Discapacidad.<br /><br />

                        Ante estas circunstancias se solicita a usted otorgar de forma libre, específica, informada e inequívoca, su consentimiento para el tratamiento de los datos de la niña, niño, adolescente, o bien, persona mayor de edad sin capacidad jurídica, con algún tipo de discapacidad que representa en este acto.<br /><br />

                        Ante tales circunstancias, si usted entiende todos y cada uno de los alcances anteriormente especificados, presione "OTORGO EL CONSENTIMIENTO", precisamente para otorgar el consentimiento respecto del tratamiento de datos personales de la niña, niño, adolescente, o bien, de la persona mayor de edad sin capacidad jurídica, con discapacidad, que usted representa.

                    </p>
                    <input type="checkbox" onclick="otorgar(0);" name="otorgo_c" id="otorgo_c" value="0" class="checks_forms" aria-label="OTORGO EL CONSENTIMIENTO" <?php echo (($otorgo_cons) * 1 == 1 ? 'checked' : '') . $dis_input; ?> >&nbsp;&nbsp;<button onclick="otorgar(1);" class="btn boton_act punteados" <?php echo $dis_input; ?>>OTORGO EL CONSENTIMIENTO</button><br>
                    <?php
                    //die("asdasda".$otorgo_cons);
                    $dis_parte_2 = (($otorgo_cons) * 1 == 1 ? 'display:block;' : 'display:none;');
                    ?>
                    <div id="parte_2" style="<?php echo $dis_parte_2; ?>;">
                        <br /><p class="text-justify text-80">Ahora bien, a efecto de dar cabal cumplimiento a lo establecido en el artículo 8º segundo párrafo de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de México y Municipios, con la finalidad de verificar que el consentimiento anteriormente otorgado, fue dado o autorizado por la o el titular de la patria potestad o tutela sobre la niña, niño, adolescente, o mayor de edad sin capacidad jurídica, con discapacidad, ADJUNTE los documentos que legalmente lo acreditan como tal.</p>
                        <h3 class="h5 text-center">ADJUNTAR DOCUMENTOS QUE ACREDITAN LA PATRIA POTESTAD</h3>
                        <div id="espacio_frmadj" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
                            <p id="texto_frmadj" class="color_negro"></p>
                        </div>                       
                        <p class="h6">Los datos o documentos marcados con  (*) ser&aacute;n obligatorios</p>
                        <label class="text-80" for="acta_name">&#8226;ACTA DE NACIMIENTO (De la niña, niño, adolescente, o bien, de la persona mayor de edad sin capacidad jurídica, con discapacidad, sobre quien usted tiene la patria potestad o tutela a registrar). (*)</label>
                        Seleccione acta de nacimiento en formato pdf (5Megas)(*): 




                        <div id="accordionGroup" class="Accordion" style="padding-top: 20px;">
                            <fieldset><legend>Ajuntar archivos</legend>
                                <form id="frmfiles" enctype="multipart/form-data" name="frmfiles" aria-labelledby="legend_frmadd" method="post" style="margin:0px;" action="/redis/index.php" onsubmit=""> 
                                    <input type="file" name="acta_name" accept="application/pdf" id="acta_name" class="form-control" onClick="select_check('acta_name');" <?php echo $dis_input; ?> >
                                    <?php
                                    if (is_array($adj) && isset($adj[1])) {
                                        $adj1 = $adj[1];
                                        echo '<input type="checkbox" onclick="" name="acta_name_check" id="acta_name_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO" ' . $dis_input . '>&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=acta_name" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                    }
                                    if (is_array($adj) && isset($adj[1]) && ($adj[1][4]) * 1 == 1) {
                                        echo '<br /><span id="acta_name_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[1][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'acta_name\');">Actualizar adjunto</button>';
                                    } else if (is_array($adj) && isset($adj[1]) && ($adj[1][4]) * 1 == 2) {
                                        echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                    }
                                    ?>
                                    <small class="form-text font-weight-bold" style="" id="e_acta_name">&nbsp;</small><br />                         
                                    <fieldset><legend id="legend_frmadd" style="display:none;">Agregar MODULOS</legend>
                                        <div class="card">
                                            <h3 class="color_negro h3 text-right">
                                                <button aria-label="Contraer" aria-expanded="<?php echo ($adjuntos == 1 ? 'true' : 'false'); ?>" class="btn card-header separ_verde Accordion-trigger punteados w-100 accordeon_f_0" aria-controls="a_1" id="accordion1id">
                                                    <input type="checkbox" onclick="" name="usted_p" id="usted_p" <?php echo (($adjuntos) * 1 == 1 ? 'checked' : ''); ?> value="" class="checks_forms" aria-label="USTED EJERCE LA PATRIA POTESTAD SOBRE LA PERSONA CON DISCAPACIDAD" <?php echo $dis_input; ?>>
                                                    <span style="width:50% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;1.- SI USTED EJERCE LA PATRIA POTESTAD SOBRE LA PERSONA CON DISCAPACIDAD&nbsp;</span><span style="width:50% !important;text-align: right !important;pointer-events: none;" class="Accordion-icon"><i class="fa fa-chevron-down" id="i_1" aria-hidden="true"></i></span>
                                                </button>  
                                                <button aria-label="Ayuda" type="button" class="btn card-header bg-white punteados" onclick="$('#modal_ayuda_1').modal('show');"><i class="fa fa-play" style="color:#32cd32;font-size: .8em;" aria-hidden="true"></i>&nbsp;<i class="fa fa-question-circle-o" style="color: #8b4513;z-index: 9999;" aria-hidden="true"></i></button>
                                            </h3>
                                            <div class="card-body card-block" role="region" aria-labelledby="accordion1id" id="a_1" <?php echo ($adjuntos == 1 ? '' : 'hidden=""'); ?>>
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_acta_representante">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="acta_representante" id="l_acta_representante" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">1. ACTA DE NACIMIENTO DEL REPRESENTANTE. Seleccione acta de nacimiento en formato pdf (5Megas)(*)&nbsp;<i id="i_aacta_representante" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="acta_representante" id="acta_representante" class="form-control" onClick="select_check('acta_representante');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[2])) {
                                                                $adj1 = $adj[2];
                                                                echo '<input type="checkbox" onclick="" name="acta_representante_check" ' . $dis_input . ' id="acta_representante_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=acta_representante" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[2]) && ($adj[2][4]) * 1 == 1) {
                                                                echo '<br /><span id="acta_representante_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[2][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'acta_representante\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[2]) && ($adj[2][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                      
                                                            <small class="form-text font-weight-bold" style="" id="e_acta_representante">&nbsp;</small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_id_representante">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="id_representante" id="l_id_representante" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">2. IDENTIFICACIÓN OFICIAL DEL REPRESENTANTE. Seleccione acta de nacimiento en formato pdf (5Megas)&nbsp;(*)<i id="i_aid_representante" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="id_representante" id="id_representante" class="form-control" onClick="select_check('id_representante');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[3])) {
                                                                $adj1 = $adj[3];
                                                                echo '<input type="checkbox" onclick="" name="id_representante_check" ' . $dis_input . ' id="id_representante_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=id_representante" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[3]) && ($adj[3][4]) * 1 == 1) {
                                                                echo '<br /><span id="id_representante_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[3][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'id_representante\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[3]) && ($adj[3][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                           
                                                            <small class="form-text font-weight-bold" style="" id="e_id_representante">&nbsp;</small>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_res_judicial">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="res_judicial" id="l_res_judicial" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">3. RESOLUCIÓN JUDICIAL. Seleccione acta de nacimiento en formato pdf (5Megas)&nbsp;<i id="i_ares_judicial" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="res_judicial" id="res_judicial" class="form-control" onClick="select_check('res_judicial');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[4])) {
                                                                $adj1 = $adj[4];
                                                                echo '<input type="checkbox" onclick="" name="res_judicial_check" ' . $dis_input . ' id="res_judicial_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=res_judicial" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[4]) && ($adj[4][4]) * 1 == 1) {
                                                                echo '<br /><span id="res_judicial_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[4][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'res_judicial\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[4]) && ($adj[4][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                            
                                                            <small class="form-text font-weight-bold" style="" id="e_res_judicial">&nbsp;</small>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </div>
                                        </div>

                                        <div class="card">
                                            <h3 class="color_negro h3 text-right">
                                                <button aria-label="Expandir" aria-expanded="<?php echo ($adjuntos == 2 ? 'true' : 'false'); ?>" class="btn card-header separ_verde Accordion-trigger punteados w-100 accordeon_f_1" aria-controls="a_2" id="accordion2id" aria-disabled="true">
                                                    <input type="checkbox" onclick="" name="usted_t" id="usted_t" <?php echo (($adjuntos) * 1 == 2 ? 'checked' : ''); ?>  value="" class="checks_forms" aria-label="SI USTED ES TUTOR DE LA PERSONA CON DISCAPACIDAD" <?php echo $dis_input; ?>>
                                                    <span style="width:50% !important;pointer-events: none;text-align:left !important;" class="font-weight-bold Accordion-title">&nbsp;2.- SI USTED ES TUTOR DE LA PERSONA CON DISCAPACIDAD&nbsp;</span><span style="width:50% !important;text-align: right !important;pointer-events: none;" class="Accordion-icon"><i class="fa fa-chevron-up" id="i_2" aria-hidden="true"></i></span>
                                                </button>  
                                                <button aria-label="Ayuda" type="button" class="btn card-header bg-white punteados" onclick="$('#modal_ayuda_2').modal('show');"><i class="fa fa-play" style="color:#32cd32;font-size: .8em;" aria-hidden="true"></i>&nbsp;<i class="fa fa-question-circle-o punteados" style="color: #8b4513;" aria-hidden="true" ></i></button>
                                            </h3>
                                            <div class="card-body card-block" role="region" aria-labelledby="accordion2id" id="a_2"  <?php echo ($adjuntos == 2 ? '' : 'hidden=""'); ?>>
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_acta_persona">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="acta_persona" id="l_acta_persona" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">1. ACTA DE NACIMIENTO DE LA PERSONA QUE EJERCE LA TUTELA. Seleccione acta de nacimiento en formato pdf (5Megas)(*)&nbsp;<i id="i_aacta_persona" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="acta_persona" id="acta_persona" class="form-control" onClick="select_check('acta_persona');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[5])) {
                                                                $adj1 = $adj[5];
                                                                echo '<input type="checkbox" onclick="" name="acta_persona_check" ' . $dis_input . ' id="acta_persona_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=acta_persona" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[5]) && ($adj[5][4]) * 1 == 1) {
                                                                echo '<br /><span id="acta_persona_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[5][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'acta_persona\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[5]) && ($adj[5][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                               
                                                            <small class="form-text font-weight-bold" style="" id="e_acta_persona">&nbsp;</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_iden_tutela">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="iden_tutela" id="l_iden_tutela" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">2. IDENTIFICACIÓN OFICIAL DE QUIEN EJERCE LA TUTELA. Seleccione acta de nacimiento en formato pdf (5Megas)(*)&nbsp;<i id="i_aiden_tutela" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="iden_tutela" id="iden_tutela" class="form-control" onClick="select_check('iden_tutela');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[6])) {
                                                                $adj1 = $adj[6];
                                                                echo '<input type="checkbox" onclick="" name="iden_tutela_check" ' . $dis_input . ' id="iden_tutela_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=iden_tutela" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[6]) && ($adj[6][4]) * 1 == 1) {
                                                                echo '<br /><span id="iden_tutela_msg"  tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[6][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'iden_tutela\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[6]) && ($adj[6][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                               
                                                            <small class="form-text font-weight-bold" style="" id="e_iden_tutela">&nbsp;</small>
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="row form-group">
                                                    <div class="row col-12 col-md-12" id="div_p_aprob_jud">
                                                        <div class="col-12" style="min-height: 30px;">
                                                            <label for="aprob_jud" id="l_aprob_jud" class="form-control-label f_cmb_l text-80" style="font-size: 1.1em;">3. APROBACIÓN JUDICIAL, ACTA DE MATRIMONIO O DOCUMENTO DE REPRESENTACIÓN JURIDÍCA O ESCRITURA PÚBLICA (según corresponda a la clase de tutela que ejerza). Seleccione acta de nacimiento en formato pdf (5Megas)&nbsp;<i id="i_aaprob_jud" aria-hidden="true"></i></label></div>
                                                        <div class="col-12 col-md-12">
                                                            <input type="file" accept="application/pdf" name="aprob_jud" id="aprob_jud" class="form-control" onClick="select_check('aprob_jud');" <?php echo $dis_input; ?>>
                                                            <?php
                                                            if (is_array($adj) && isset($adj[7])) {
                                                                $adj1 = $adj[7];
                                                                echo '<input type="checkbox" onclick="" name="aprob_jud_check" ' . $dis_input . ' id="aprob_jud_check" value="" class="checks_forms" aria-label="REMPLAZAR ARCHIVO">&nbsp;&nbsp;Remplazar archivo&nbsp;&nbsp;&nbsp;<a href="files/getfile_r_1.php?unico=' . $adj1[0] . '&file_get=adj_unico&imagen_file=adj_unico&nom_part=aprob_jud" target="_blank" class="font-weight-bold text-80 punteados">Archivo actual: ' . $adj1[2] . '</a>';
                                                            }
                                                            if (is_array($adj) && isset($adj[7]) && ($adj[7][4]) * 1 == 1) {
                                                                echo '<br /><span id="aprob_jud_msg" tabindex="0" style="text-align:center;width:100%;background-color:#ff8080;color:#000000;font-weight:bold;" class="rounded">No valido: ' . $adj[7][5] . '</span><p style=""></p><button style="" type="button" class="btn boton_act punteados" onclick="act_one_adj(\'aprob_jud\');">Actualizar adjunto</button>';
                                                            } else if (is_array($adj) && isset($adj[7]) && ($adj[7][4]) * 1 == 2) {
                                                                echo '<br /><span tabindex="0" style="text-align:center;width:100%;background-color:#3cb371;color:#000000;font-weight:bold;" class="rounded">Valido</span>';
                                                            }
                                                            ?>                                                               
                                                            <small class="form-text font-weight-bold" style="" id="e_aprob_jud">&nbsp;</small>
                                                        </div>
                                                    </div>
                                                </div>                                   
                                            </div>
                                        </div>
                                        <?php
                                        if ($estado_per * 1 == 4) {
                                            
                                        } else {
                                            ?>
                                            <button id="guardar_ad" type="button" style="<?php echo (is_array($adj) ? 'display:block;' : 'display:block;') ?>" class="btn boton_act punteados" onclick="rep_tut();" <?php echo $dis_input; ?>><?php echo (is_array($adj) ? 'ACTUALIZAR ADJUNTOS' : 'GUARDAR ADJUNTOS') ?></button>
                                            <?php }
                                        ?>                                        

                                    </fieldset></form></fieldset>          
                        </div>                     
                        <br />
                        <div id="rep_tut" style="border-style: solid;  border-color: #32cd32;padding: 10px 10px 10px 10px;border-radius: 20px;<?php echo ($acepto_y_protesto * 1 == 1 ? 'diplay:block;' : 'display:none;'); ?>">

                            <p class="text-80 text-justify">ANTE EL CONSENTIMIENTO PREVIAMENTE OTORGADO, Y UNA VEZ ADJUNTOS LOS DOCUMENTOS QUE ACREDITAN LA REPRESENTACIÓN O TUTELA SOBRE LA PERSONA CON DISCAPACIDAD A REGISTRAR, EN ESTE ACTO Y BAJO PROTESTA DE DECIR VERDAD, YO (VINCULAR NOMBRE COMPLETO) REPRESENTANTE/TUTOR DE</p>
                            <div id="espacio_frmregis" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
                                <p id="texto_frmregis" class="color_negro"></p>
                            </div>                          
                            <form id="frmregis">
                                <fieldset><legend style="display:none;">Nombre completo de la persona a registrar</legend>                                
                                    <label for="n_n_a_p" class="text-80">(Nombre de la niña, niño, adolescente, o persona mayor de edad sin capacidad jurídica con discapacidad)(*)</label>
                                    <input maxlength="50" style="text-transform: uppercase;" type="text" name="n_n_a_p" id="n_n_a_p" value="<?php echo $n_n_a_p; ?>" class="form-control" <?php echo $dis_input; ?>>
                                    <small class="form-text font-weight-bold" style="" id="e_n_n_a_p">&nbsp;</small>
                                    <label for="ap_n_a_p"  class="text-80">(Apellido paterno)(*)</label>
                                    <input maxlength="50" style="text-transform: uppercase;" type="text" name="ap_n_a_p" id="ap_n_a_p" value="<?php echo $ap_n_a_p; ?>" class="form-control" <?php echo $dis_input; ?>>
                                    <small class="form-text font-weight-bold" style="" id="e_ap_n_a_p">&nbsp;</small>
                                    <label for="am_n_a_p"  class="text-80">(Apellido materno)(*)</label>
                                    <input maxlength="50" style="text-transform: uppercase;" type="text" name="am_n_a_p" id="am_n_a_p" value="<?php echo $am_n_a_p; ?>" class="form-control" <?php echo $dis_input; ?>>     
                                    <small class="form-text font-weight-bold" style="" id="e_am_n_a_p">&nbsp;</small>
                                    <p class="text-80 text-justify">MANIFIESTO QUE LA INFORMACIÓN Y DOCUMENTACIÓN PROPORCIONADA ES VERÍDICA, ES POR ESO, QUE A PARTIR DE ESTE ACTO, ME HAGO RESPONSABLE SOBRE LA FALSEDAD DE INFORMACIÓN Y/O DOCUMENTACIÓN PROPORCIONADA POR EL SUSCRITO EN ESTA PLATAFORMA, LO ANTERIOR PARA TODOS LOS EFECTOS LEGALES A QUE HAYA LUGAR.</p>
                                    <button type="button" id="btn_regn" class="btn boton_act punteados" style="<?php echo ($acepto_y_protesto * 1 == 1 ? 'diplay:block;' : 'display:block;'); ?>" onclick="ley_prot();" <?php echo $dis_input; ?>><span id="i_reg"></span>ACEPTO Y PROTESTO</button>
                                </fieldset></form>
                        </div><br />                 

                        <div id="ley_prot" style="border-style: solid;  border-color: #32cd32;padding: 10px 10px 10px 10px;border-radius: 20px;<?php echo ($acepto_y_protesto * 1 == 1 ? 'diplay:block;' : 'display:none;'); ?>">
                            <p class="text-80 text-justify">NOTA: Tomando en consideración que el articulo 8º segundo párrafo de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de México y Municipios, establece que el responsable del tratamiento de sus datos verificará que el consentimiento fue dado  o autorizado por la o el titular de la Patria Potestad o Tutela sobre la niña, niño o adolescente, y en su caso persona mayor de edad sin capacidad jurídica, con discapacidad, UNA VEZ VERIFICADA y corroborada la información y documentación proporcionada, y si Usted realmente cuenta con la representación jurídica para realizar el registro, al terminar el registro, se le hará llegar al correo que en seguida proporcione y/o al número telefónico, la Clave Única de Registro de Discapacidad (CURED), de lo contrario, se enviará correo con las observaciones necesarias para poder realizar el registro.</p>
                            <div id="espacio_frmcont" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
                                <p id="texto_frmcont" class="color_negro"></p>
                            </div>                          
                            <form id="frmcont">
                                <fieldset><legend style="display:none;">Datos de contacto de la persona a registrar</legend>                            
                                    <label for="email" class="text-80">Correo electrónico (*):</label>
                                    <input maxlength="100" type="text" name="email" id="email" value="<?php echo $email; ?>" class="form-control" <?php echo $dis_input; ?>>
                                    <small class="form-text font-weight-bold" style="" id="e_email">&nbsp;</small>
                                    <label for="num_tel" class="text-80">Número Telefónico</label>
                                    <input maxlength="10" type="text" name="num_tel" id="num_tel" value="<?php echo $num_tel; ?>" class="form-control" <?php echo $dis_input; ?>>     
                                    <small class="form-text font-weight-bold" style="" id="e_num_tel">&nbsp;</small>
                                    <br />
                                    <?php
                                    if ($estado_per * 1 == 4) {
                                        
                                    } else {
                                        echo '<button type="button" id="btn_cont" class="btn boton_act punteados" onclick="reg_contac();" <?php echo $dis_input; ?><span id="i_cont"></span>CONTINUAR</button>';
                                    }
                                    ?>

                                </fieldset>
                            </form>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="col-1"></div>

        </div>





        <div class="modal fade bd-example-modal-lg" id="modal_ayuda_1" tabindex="-1" role="dialog" aria-labelledby="label_ayuda_1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="border: 1px solid orange !important;">
                    <div class="modal-header">
                        <h5 class="modal-title h5" id="label_ayuda_1 text-80">Ayuda</h5>
                        <button type="button" class="close punteados" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-80">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="text-center">
                            <table class="table_a" style="width: 100%;">
                                <caption style="caption-side:top;color: black;" class="h5">Documentos a escanear</caption>
                                <tr>
                                    <th id="c1" class="b_a_1">Parentesco</th>
                                    <th id="c2" class="b_a_1">Documento(s) que usted tiene que Adjuntar</th>
                                </tr>   
                                <tr>
                                    <td class="b_a_1">Padre o Madre</td><td rowspan="3">1.	Acta de Nacimiento del Representante.<br />2.	Identificación OFICIAL y, en su caso,<br />3.	Resolución Judicial que acredite la Patria Potestad.</td>
                                </tr>
                                <tr>
                                    <td class="b_a_1">Abuelo</td>
                                </tr>
                                <tr>
                                    <td class="b_a_1">Familiar Consanguíneo (hasta tercer grado colateral)</td>
                                </tr>  
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn boton_can punteados" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>






        <div class="modal fade bd-example-modal-lg" id="modal_ayuda_2" tabindex="-1" role="dialog" aria-labelledby="label_ayuda_2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="border: 1px solid orange !important;">
                    <div class="modal-header">
                        <h5 class="modal-title h5" id="label_ayuda_2 text-80">Ayuda</h5>
                        <button type="button" class="close punteados" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-80">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="text-center">
                            <table id="table_a" style="width: 100%;">
                                <caption style="caption-side:top;color: black;" class="h5">Documentos a escanear</caption>
                                <tr>
                                    <th id="c3" class="b_a_1">CLASE DE TUTELA</th>
                                    <th id="c4" class="b_a_1">SUPUESTOS</th>
                                    <th id="c5" class="b_a_1">Documento(s) que usted tiene que Adjuntar</th>
                                </tr>  
                                <tr>
                                    <td class="b_a_1">TESTAMENTARIA</td>
                                    <td class="b_a_1">&#8226;&nbsp;Cuando se ejerce la patria potestad a través de un testamento</td>
                                    <td class="b_a_1">&#8226;&nbsp;TESTAMENTO.</td>
                                </tr>
                                <tr>
                                    <td class="b_a_1" rowspan="3">LEGÍTIMA</td>
                                    <td class="b_a_1">
                                        <p>Cuando no haya quien ejerza la patria potestad, ni tutor testamentario:</p>
                                        <p class="text-justify">Para las personas con discapacidad mayores de edad, incapacitadas legalmente, casados:</p>
                                        <p class="text-justify">&#8226;&nbsp;Ejerce la patria potestad el cónyuge (1) o uno de sus hijos (2).</p>
                                        </p>
                                    </td>
                                    <td class="b_a_1"><p>1. ACTA DE MATRIMONIO.<br />
                                            (de quien ejerce la tutela).<br />
                                            o<br />
                                            2. ACTA DE NACIMIENTO.<br />
                                            (del hijo que ejerce la tutela).
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="b_a_1">
                                        <p class="text-justify">Para las personas con discapacidad mayores de edad, incapacitadas legalmente, solteros o viudos, cuando tengan hijos que no puedan desempeñar la Tutela:<br />
                                            &#8226;&nbsp;Ejercen la patria potestad los padres. (1)<br/>
                                            &#8226;&nbsp;A falta de cónyuge, hijos y padres, la patria potestad la ejerce algún familiar consanguíneo colateral hasta 4º grado. (2)
                                        </p>
                                    </td>
                                    <td class="b_a_1">1. ACTA DE NACIMIENTO.<br />
                                        (del familiar consanguíneo que ejerce la tutela).<br />
                                        o<br />
                                        2. ACTA DE NACIMIENTO QUE ACREDITE EL PARENTESCO.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="b_a_1"><p class="text-justify">
                                            Personas que hayan sido entregadas voluntariamente al DIF.
                                        </p>
                                    </td>
                                    <td class="b_a_1">DOCUMENTO DE REPRESENTACIÓN JURÍDICA.
                                        (Expedido por la Procuraduría para protección de niñas, niños y adolescentes del DIF).
                                    </td>                                
                                </tr>
                                <tr>
                                    <td class="b_a_1">DATIVA</td>
                                    <td class="b_a_1"><p class="text-justify">Cuando no haya tutor testamentario ni persona a quien conforme a la ley corresponda la tutela legítima.<br />
                                            O bien, cuando el tutor testamentario esté impedido temporalmente para ejercer su cargo y no haya ningún pariente para representarlo legalmente.<br />
                                            &#8226;&nbsp;El Tutor puede ser nombrado por el menor cuando tenga 12 años, mediante aprobación del Juez competente.<br />
                                            &#8226;&nbsp;Si el menor tiene menos de 12 años el Juez competente lo designará.
                                        </p></td>
                                    <td class="b_a_1"><p>&#8226;&nbsp;APROBACIÓN JUDICIAL.<br />
                                            &#8226;&nbsp;ACTA DE NACIMIENTO.<br />
                                            (de la persona que ejerce la tutela).
                                        </p></td>
                                </tr>  
                                <tr>
                                    <td class="b_a_1">VOLUNTARIA</td>
                                    <td class="b_a_1"><p class="text-justify">Cuando una persona capaz jurídicamente, hace la designación de otra persona que va a representarlo legalmente para el caso de llegar a caer en estado de interdicción.
                                        </p></td>
                                    <td class="b_a_1"><p>&#8226;&nbsp;ESCRITURA PÚBLICA.
                                            &#8226;&nbsp;ACTA DE NACIMIENTO<br />
                                            (de la persona que ejerce la tutela).
                                        </p>
                                    </td>
                                </tr>                             
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn boton_can punteados" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .table_a,.b_a_1{
                border: 1px solid black !important;     
                color: black;
                font-size: 11px;
            }
            .b_a_1>p{
                color: black;
                font-size: 11px;
            }
        </style>
        <script>
            function sigue_mod() {
                window.location = "index.php?mod=208";
            }
            $("#cap_juridica").change(function () {
                var valores = "" + $("#cap_juridica").val();
                var val = valores;
                if (valores.length == 0) {//btn_cont_f
                    $("#c_show").css("display", "none");
                    $("#btn_cont_f").css("display", "none");
                    val = 0;
                } else if (valores == 1) {
                    $("#c_show").css("display", "none");
                    $("#btn_cont_f").css("display", "block");

                } else if (valores == 0) {
                    $("#c_show").css("display", "block");
                    $("#btn_cont_f").css("display", "none");
                }
                guarda(1, val);
            });
            function otorgar(p) {
                if (p == 1) {
                    var check_id = $('#otorgo_c').is(':checked');
                    if (check_id) {
                        $('#otorgo_c').prop('checked', false);
                        guarda(2, 0);
                    } else {
                        $('#otorgo_c').prop('checked', true);
                        guarda(2, 1);
                    }
                }
                var check_id = $('#otorgo_c').is(':checked');
                if (check_id) {
                    $("#parte_2").css("display", "block");
                } else {
                    $("#parte_2").css("display", "none");
                }
            }
            function rep_tut() {
                var typo_adj =<?php echo $si_adj; ?>;
                var adj_12 =<?php echo $adjuntos; ?>;
                adj_12 = adj_12 * 1;
                typo_adj = typo_adj * 1;
                var sigue = val_inputs(typo_adj, adj_12);
                //var sigue = true;
                if (sigue) {
                    $("#rep_tut").css("display", "block");
                }
            }
            function ley_prot() {
                //validacion
                var datos = "type=nom_cmpl";
                datos += "&nombre=" + $("#n_n_a_p").val();
                datos += "&ap_p=" + $("#ap_n_a_p").val();
                datos += "&ap_m=" + $("#am_n_a_p").val();
                a_R = $.ajax({
                    url: 'includes/evento_consen.php',
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    beforeSend: function (res) {//entrar
                        $('#i_reg').addClass('fa fa-spinner fa-spin');
                        $("#btn_regn").attr('disabled', 'disabled');
                        obj_valObj(2, 'n_n_a_p', '', 'RisTxt', 'Nombre', ''
                                , 'ap_n_a_p', '', 'RisTxt', 'Apellido paterno', ''
                                , 'am_n_a_p', '', 'RisTxt', 'Apellido materno', '');
                        if (!document.obj_retVal) {
                            $('#i_reg').removeClass('fa fa-spinner fa-spin');
                            $('#btn_regn').removeAttr('disabled');
                            $("#ley_prot").css("display", "none");
                            res.abort();
                        }

                    },
                    success: function (response) {
                        var msj = response.mensaje;
                        if (response.successful == "true") {
                            $("#ley_prot").css("display", "block");
                            alertify.success(msj);
                        } else {
                            alertify.error(msj);
                        }
                    }, error: function (e) {
                        alertify.error("bondad al registrar datos");
                        a_R.abort();
                    },
                    complete: function () {
                        $('#i_reg').removeClass('fa fa-spinner fa-spin');
                        $('#btn_regn').removeAttr('disabled');
                    }
                });

            }
            function reg_contac() {
                //validacion
                var datos = "type=reg_cont";
                datos += "&correo=" + $("#email").val();
                datos += "&tel=" + $("#num_tel").val();
                a_R = $.ajax({
                    url: 'includes/evento_consen.php',
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    beforeSend: function (res) {//entrar
                        $('#i_cont').addClass('fa fa-spinner fa-spin');
                        $("#btn_cont").attr('disabled', 'disabled');
                        obj_valObj(2, 'email', '', 'RisTxt', 'Correo', '',
                                'num_tel', '', 'isTxt', 'Telefono', '');
                        if (!document.obj_retVal) {
                            $('#i_cont').removeClass('fa fa-spinner fa-spin');
                            $('#btn_cont').removeAttr('disabled');
                            res.abort();
                        }

                    },
                    success: function (response) {
                        var msj = response.mensaje;
                        if (response.successful == "true") {
                            alertify.success(msj);
                            window.location = "index.php?mod=208";
                        } else {
                            alertify.error(msj);
                        }
                    }, error: function (e) {
                        alertify.error("bondad al registrar datos");
                        a_R.abort();
                    },
                    complete: function () {
                        $('#i_cont').removeClass('fa fa-spinner fa-spin');
                        $('#btn_cont').removeAttr('disabled');
                    }
                });
            }
            $(document).ready(function () {//usted_t   
                $("#accordion1id").click(function () {
                    $('#usted_p').prop('checked', true);
                    $('#usted_t').prop('checked', false);
                });
                $("#accordion2id").click(function () {
                    $('#usted_p').prop('checked', false);
                    $('#usted_t').prop('checked', true);
                });
            });
            function guarda(option, v_c) {
                var datos = "type=activa";
                datos += "&option=" + option;
                datos += "&v_c=" + v_c;
                $.ajax({
                    url: 'includes/evento_consen.php',
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (response) {//echo json_encode(array('successful' => $success, 'estado' => $estado_proceso));
                        if (response.successful == 'true') {
                        } else {
                        }
                        // alertify.success("! el registro se guardo!");
                    }, error: function (e) {
                        alertify.error("bondad al procesar 1 ");
                    },
                    complete: function () {
                    },
                });
            }
            function sav_arch() {
                var form_data = new FormData();
                //            var file_data = $('#acta_name').prop('files')[0];//frmcon
                $('#frmfiles').serializeArray();
                var adjuntos = [];
                form_data.append('type', 'adj');
                form_data.append('acta_name', $('#acta_name').prop('files')[0]);
                if ($('#usted_p').is(':checked')) {
                    form_data.append('s_b', 1);
                    form_data.append('acta_representante', $('#acta_representante').prop('files')[0]);
                    form_data.append('id_representante', $('#id_representante').prop('files')[0]);
                    form_data.append('res_judicial', $('#res_judicial').prop('files')[0]);
                }
                if ($('#usted_t').is(':checked')) {
                    form_data.append('s_b', 2);
                    form_data.append('acta_persona', $('#acta_persona').prop('files')[0]);
                    form_data.append('iden_tutela', $('#iden_tutela').prop('files')[0]);
                    form_data.append('aprob_jud', $('#aprob_jud').prop('files')[0]);
                }

                $.ajax({
                    url: 'includes/evento_consen.php',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    beforeSend: function () {
                        $('#guardar_ad').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.successful == 'true') {
                            alertify.success("! adjuntos guardados!");
                            $("#rep_tut").css("display", "block");
                        }
                    },
                    error: function (response) {
                    },
                    complete: function () {
                        $('#guardar_ad').removeAttr('disabled');
                    }
                });
            }
            var err = "";
            var cmp = [];
            var ids = [];
            function val_inputs(exis_adj, t_adj) {
                var sigue = true;
                if (exis_adj == 1) {
                    ids = ['acta_name'];
                    if ($('#usted_p').is(':checked')) {
                        ids.push('acta_representante');
                        ids.push('id_representante');
                        ids.push('res_judicial');
                    }
                    if ($('#usted_t').is(':checked')) {
                        ids.push('acta_persona');
                        ids.push('iden_tutela');
                        ids.push('aprob_jud');
                    }
                } else if (exis_adj == 2) {
                    ids = [];
                    if ($('#acta_name_check').is(':checked')) {
                        ids.push('acta_name');
                    }
                    var t_adj_aux = '';
                    if ($('#usted_p').is(':checked')) {
                        t_adj_aux = 1;
                    }
                    if ($('#usted_t').is(':checked')) {
                        t_adj_aux = 2;
                    }
                    if (t_adj == t_adj_aux) {

                        if (t_adj_aux == 1) {
                            if ($('#acta_representante_check').is(':checked')) {
                                ids.push('acta_representante');
                            }
                            if ($('#id_representante_check').is(':checked')) {
                                ids.push('id_representante');
                            }
                            if ($('#res_judicial_check').is(':checked')) {
                                ids.push('res_judicial');
                            }
                        } else {
                            if ($('#acta_persona_check').is(':checked')) {
                                ids.push('acta_persona');
                            }
                            if ($('#iden_tutela_check').is(':checked')) {
                                ids.push('iden_tutela');
                            }
                            if ($('#aprob_jud_check').is(':checked')) {
                                ids.push('aprob_jud');
                            }
                        }
                    } else {
                        if ($('#usted_p').is(':checked')) {
                            ids.push('acta_representante');
                            ids.push('id_representante');
                            ids.push('res_judicial');
                        }
                        if ($('#usted_t').is(':checked')) {
                            ids.push('acta_persona');
                            ids.push('iden_tutela');
                            ids.push('aprob_jud');
                        }
                    }
                }
                //            console.log(ids);
                //            alert(ids.length);
                for (var i = 0; i < ids.length; i++) {
                    if (!val_input(ids[i])) {
                        sigue = false;
                    } else {
                        $("#e_" + ids[i]).html("Correcto");
                        jQuery("#e_" + ids[i]).css('display', 'block');
                        jQuery("#e_" + ids[i]).css('color', '#643200');
                    }
                }//texto_frmadj
                //&alert(err);
                if (err.length > 0) {
                    jQuery("#espacio_frmadj").css('display', 'block');
                    jQuery("#texto_frmadj").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i></br>' + err);
                    document.getElementById(cmp[0]).focus();
                    $("#espacio_frmadj").attr('tabindex', '-1');

                }
                if (ids.length == 0) {
                    jQuery("#espacio_frmadj").css('display', 'none');
                    return true;
                } else {
                    if (sigue) {
                        err = "";
                        cmp = [];
                        sav_arch();
                        jQuery("#espacio_frmadj").css('display', 'none');
                        ids = [];
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            function val_input(ids) {
                var file = $("#" + ids).val();  //Fetch the filename of the submitted file
                var sigue = true;
                if (file == '') {    //Check if a file was selected
                    err += getDes(ids) + ": Seleccionar un archivo<br />";
                    $("#e_" + ids).html("Seleccionar un archivo");
                    jQuery("#e_" + ids).css('display', 'block');
                    jQuery("#e_" + ids).css('color', '#8b0000');
                    sigue = false;
                    cmp.push(ids);
                } else {
                    var ext = file.split('.').pop().toLowerCase();   //Check file extension if valid or expected
                    if ($.inArray(ext, ['pdf']) == -1) {
                        err += getDes(ids) + ": Selecciona un archivo pdf valido<br />";
                        $("#e_" + ids).html("Selecciona un archivo pdf valido");
                        jQuery("#e_" + ids).css('display', 'block');
                        jQuery("#e_" + ids).css('color', '#8b0000');
                        sigue = false;
                        cmp.push(ids);
                    }
                }
                return sigue;
            }
            function getDes(type) {
                var tipo = "";
                switch (type) {
                    case 'acta_name':
                        tipo = "Acta de nacimiento";
                        break;
                    case 'acta_representante':
                        tipo = "Acta de nacimiento representante";
                        break;
                    case 'id_representante':
                        tipo = "Identificacion oficial del representante";
                        break;
                    case 'res_judicial':
                        tipo = "Resolucion judicial";
                        break;
                    case 'acta_persona':
                        tipo = "Acta de nacimiento de la persona que ejerce la tutela";
                        break;
                    case 'iden_tutela':
                        tipo = "Identificacion oficial de quien ejerce la tutela";
                        break;
                    case 'aprob_jud':
                        tipo = "Aprobacion  judicial, acta de matrimonio o documento de representacion juridica o escritura publica";
                        break;
                }
                return tipo;
            }
            function select_check(id) {
                $("#" + id + "_check").prop('checked', true);
            }
            function act_one_adj(id) {
                if ($('#' + id + '_check').is(':checked')) {
                    var pasa_val = val_input(id);
                    if (pasa_val) {
                        sav_arch_one(id);
                    }
                }
            }
            function sav_arch_one(id) {
                var form_data = new FormData();
                $('#frmfiles').serializeArray();
                var adjuntos = [];
                form_data.append('type', 'adj');
                form_data.append(id, $('#' + id).prop('files')[0]);
                $.ajax({
                    url: 'includes/evento_consen.php',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    beforeSend: function () {
                        $('#guardar_ad').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.successful == 'true') {
                            alertify.success("! adjunto guardado!");
                            if ((response.num_n_val) * 1 == 0) {
                                window.location = "index.php?mod=208";
                            }
                            $("#" + id + "_msg").css("background-color", "#3cb371");
                            $("#" + id + "_msg").html("En proceso de validacion");
                        }
                    },
                    error: function (response) {
                    },
                    complete: function () {
                        $('#guardar_ad').removeAttr('disabled');
                    }
                });
            }
            //
        </script>
        <?php
    }
}
?>