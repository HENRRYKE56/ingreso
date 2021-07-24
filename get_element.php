<?php

session_start();
$str_check = FALSE;
include_once("includes/sb_check.php");
if ($str_check) {
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    include_once("lib/lib_function.php");
    include_once("rep/lib/lib32.php");

    if (isset($_POST['entvalue'])) {
		/*
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		die();
		*/
		
        if (isset($_POST['nivel_pago']) && ($_POST['nivel_pago'] <> 0))
            $nivel = $_POST['nivel_pago'];

        if (isset($_POST['cve_programa_prioritario']) && ($_POST['cve_programa_prioritario'] <> 0))
            $prio = $_POST['cve_programa_prioritario'];
        else {
            $prio = "null";
        }
        
        if ($_POST['cve_derechohabiente'] != 10 && $_POST['cve_derechohabiente'] != 11 && $_POST['cve_derechohabiente'] != 9  )
            $nivel = 6;
	    }

  
  
    $a_table = array();
    $a_table['partida'] = ' partidas p';
    $a_table['unidad'] = ' unidad u';
    $a_table['paciente'] = ' paciente p, sexo s';
    $a_table['paciente2'] = ' paciente p, sexo s, parentesco r';
    $a_table['paciente3'] = ' paciente p, sexo s, expediente e, prefijos j, area a';
    $a_table['paciente_cit'] = ' paciente p, sexo s,expediente e';
    $a_table['cie'] = 'cat_cie ce';

    if (isset($_POST['causes'])) {
        $a_table['cie2'] = 'cat_cie ce, det_intercauses_cies de, cat_inter_causes cat';
    } else {
        $a_table['cie2'] = 'cat_cie ce';
    }

    if (isset($_POST['causes'])) {
        $a_table['cie21'] = 'cat_padecimientos ce,  det_intercauses_cies de, cat_cie f,cat_inter_causes cat';
    } else {
        $a_table['cie21'] = 'cat_cie f';
    }


    $a_table['cie100'] = " catenf_genc ce 
left outer join  cat_intervencion_cie a on (ce.id_cie=a.id_cie and ce.cvecie=a.cvecie)
left outer join cat_intervencion i on (a.id_intervencion=i.id_intervencion and a.cve_intervencion=i.cve_intervencion)
left outer join cartera r on (a.cve_cartera=r.cve_cartera) ";

//$a_table['cie100']='cat_padecimientos ce 
//inner JOIN  cat_cie f ON (ce.CLAVE_CIE like concat(f.cvecie,"%") and ce.CLAVE_CIE=f.cvecied)
//LEFT OUTER JOIN det_intercauses_cies de ON (ce.ID_PADECIMIENTO=de.id_padecimiento)
//left outer join cat_inter_causes cat on (de.id_inter_causes=cat.id_inter_causes )   ';

    $a_table['cie22'] = 'cat_cie ce';
    $a_table['cieh2'] = 'cat_cie ce';
    $a_table['cieh3'] = 'cat_cie ce';
    $a_table['cieh4'] = 'cat_cie ce';
    $a_table['cieh5'] = 'cat_cie ce';
    $a_table['cieh6'] = 'cat_cie ce';
    $a_table['cieh7'] = 'cat_cie ce';
    $a_table['cieh8'] = 'cat_cie ce';
    $a_table['cieh9'] = 'cat_cie ce';
    $a_table['cieh10'] = 'cat_cie ce';
    $a_table['cieh11'] = 'cat_cie ce';
    $a_table['cieh12'] = 'cat_cie ce';
    $a_table['cieh13'] = 'cat_cie ce';
    $a_table['cieh14'] = 'cat_cie ce';
    $a_table['cieh15'] = 'cat_cie ce';
    $a_table['cieh16'] = 'cat_cie ce';
    $a_table['cieh17'] = 'cat_cie ce';
    $a_table['cieh18'] = 'cat_cie ce';
    $a_table['cieh19'] = 'cat_cie ce';

    $a_table['element'] = 'medico r';
    $a_table['articulo_urg'] = 'articulo a, articulonivel an, unidad u'; //, '.
    $a_table['articulo_urg2'] = 'articulo a, articulonivel an, unidad u'; //, '.
    $a_table['articulo_urg3'] = 'articulo a, articulonivel an, unidad u'; //, '.
    $a_table['articulo_r'] = 'articulo a, receta r, articulonivel an, unidad u'; //, '.
    $a_table['articulo_enf'] = 'articulo a, registro_enfermeria r, articulonivel an, unidad u'; //, '.
    $a_table['articulo_rx'] = 'articulo a, receta_colectiva r, articulonivel an, unidad u'; //, '
    $a_table['paciente_1'] = ' paciente p, sexo s ';
    
    if(isset($prio))
        $a_table['cuota'] = ' cuotas p JOIN capitulo_cuota t on p.cve_cap_cuota=t.cve_cap_cuota '
            . 'LEFT OUTER JOIN cuotas_programa cp ON cp.noIdentificacion = p.noIdentificacion and cp.cve_programa_prioritario = '.$prio." "
            . "LEFT OUTER JOIN cat_programa_prioritario pp on pp.cve_programa_prioritario = cp.cve_programa_prioritario ";
  
    $a_table['causes'] = ' cat_inter_causes p';
    $a_table['articulo_ry'] = 'articulo a, pastilleo r, articulonivel an, unidad u'; //, '.
    $a_table['articulo_rz'] = 'articulo a, receta_urgencias r, articulonivel an, unidad u'; //, '.
    $a_table['articulo_rx1'] = 'articulo a, receta_mat_curacion r, articulonivel an, unidad u'; //, '.
    $a_table['articulo_rz1'] = 'articulo a, receta_urg_material r, articulonivel an, unidad u'; //, '.
    $a_table['paciente4'] = ' paciente p, sexo s ';
    $a_table['cie4'] = 'cat_cie ce';
    $a_table['cie5'] = 'cat_cie ce';
    $a_table['autofirma'] = 'autofirma a';
    $a_table['guia'] = 'guias_practicas g';
    $a_table['refiere'] = 'unidades_refiere u';
    $a_table['medicamento_urg'] = 'cat_medicamentos a';
    $a_table['medicamento_urg2'] = 'cat_medicamentos a';
    $a_table['medicamento_urg3'] = 'cat_medicamentos a';
	$a_table['presta'] = ' expediente e 
						   left join paciente p on (e.cve_paciente = p.cve_paciente) ';



    $a_fields = array();
    $a_fields['partida'] = array('cvePar', 'desPar');
    $a_fields['unidad'] = array('cve_uni', 'des_uni');
    $a_fields['paciente'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'fecha_nacimiento', 'poliza', 'sexo', 'cve_sexo');
    $a_fields['paciente2'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'edad', 'fecha_nacimiento', 'sexo', 'cve_sexo', 'telefono_particular', 'telefono_celular', 'parentesco', 'cve_parentesco', 'nombre_parentesco ');
    $a_fields['paciente3'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'poliza', 'p.calle', 'p.num_ext', 'sexo', 'cve_sexo', 'num_expediente', 'cve_expediente', 'prefijo', 'cve_prefijo', 'area', 'cve_area');
    $a_fields['paciente_cit'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'fecha_nacimiento', 'poliza', 'sexo', 'cve_sexo', 'expediente');
    $a_fields['cie'] = array('cvecie', 'cvecied', 'descied');

    if (isset($_POST['causes'])) {
        $a_fields['cie2'] = array('cvecied', 'cvecied', 'descied', 'id_inter_causes', 'des_inter_causes');
    } else {
        $a_fields['cie2'] = array('cvecie', 'cvecied', 'descied', 'id_inter_causes');
    }

    if (isset($_POST['causes'])) {
        $a_fields['cie21'] = array('cvecie', 'cvecied', 'descied', 'id_inter_causes', 'des_inter_causes');
    } else {
        $a_fields['cie21'] = array('cvecie', 'cvecied', 'descied', 'id_inter_causes');
    }

    $a_fields['cie100'] = array('id_cie', 'cvecie', 'descie', 'id_intervencion', 'des_intervencion');

    $a_fields['cie22'] = array('id_cie9', 'cvecie9', 'descie');

    $a_fields['cieh2'] = array('cvecie2', 'cvecied2', 'descied2');
    $a_fields['cieh3'] = array('cvecie3', 'cvecied3', 'descied3');
    $a_fields['cieh4'] = array('cvecie4', 'cvecied4', 'descied4');
    $a_fields['cieh5'] = array('cvecie5', 'cvecied5', 'descied5');
    $a_fields['cieh6'] = array('cvecie6', 'cvecied6', 'descied6');
    $a_fields['cieh7'] = array('cvecie7', 'cvecied7', 'descied7');
    $a_fields['cieh8'] = array('cvecie8', 'cvecied8', 'descied8');
    $a_fields['cieh9'] = array('cvecie9', 'cvecied9', 'descied9');
    $a_fields['cieh10'] = array('cvecie10', 'cvecied10', 'descied10');
    $a_fields['cieh11'] = array('cvecie11', 'cvecied11', 'descied11');
    $a_fields['cieh12'] = array('cvecie12', 'cvecied12', 'descied12');
    $a_fields['cieh13'] = array('cvecie13', 'cvecied13', 'descied13');
    $a_fields['cieh14'] = array('cvecie14', 'cvecied14', 'descied14');
    $a_fields['cieh15'] = array('cvecie15', 'cvecied15', 'descied15');
    $a_fields['cieh16'] = array('cvecie16', 'cvecied16', 'descied16');
    $a_fields['cieh17'] = array('cvecie13', 'cvecied13', 'descied13');
    $a_fields['cieh18'] = array('cvecie14', 'cvecied14', 'descied14');
    $a_fields['cieh19'] = array('cvecie15', 'cvecied15', 'descied15');


    $a_fields['element'] = array('des_medico', 'cve_medico', 'cedula', 'rfc');
    $a_fields['paciente_1'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'fecha_nacimiento', 'poliza', 'sexo', 'cve_sexo');
    $a_fields['cuota'] = array('cve_cap_cuota','des_cap_cuota','noIdentificacion', 'descripcion', 'nivel','nivel_pro','programa'); //'if(d.nivel=1,p.nivel1,if(d.nivel=2,p.nivel2,if(d.nivel=3,p.nivel3,if(d.nivel=4,p.nivel4,if(d.nivel=5,p.nivel5,if(d.nivel=6,p.nivel6,0)))))) as nivel');
    $a_fields['causes'] = array('id_inter_causes', 'cve_inter_causes', 'des_inter_causes', 'alcance_exencion', 'servicio_cubre');
    $a_fields['articulo_urg'] = array('des_articulo', 'cve_articulo');
    $a_fields['articulo_urg2'] = array('des_articulo2', 'cve_articulo2');
    $a_fields['articulo_urg3'] = array('des_articulo3', 'cve_articulo3');
    $a_fields['articulo_r'] = array('des_articulo', 'cve_articulo', 'preart', 'unmed');
    $a_fields['articulo_enf'] = array('des_articulo', 'cve_articulo', 'preart', 'unmed');
    $a_fields['articulo_rx'] = array('des_articulo', 'cve_articulo', 'preart', 'unmed');
    $a_fields['articulo_ry'] = array('des_articulo', 'cve_articulo');
    $a_fields['articulo_rz'] = array('des_articulo', 'cve_articulo', 'preart');
    $a_fields['articulo_rx1'] = array('des_articulo', 'cve_articulo', 'preart');
    $a_fields['articulo_rz1'] = array('des_articulo', 'cve_articulo', 'preart');
    $a_fields['paciente4'] = array('cve_paciente', 'nombre', 'app_pat', 'app_mat', 'fecha_nacimiento', 'poliza', 'sexo', 'cve_sexo');
    $a_fields['cie4'] = array('id_cie', 'cvecie', 'descie');
    $a_fields['cie5'] = array('cvecie', 'cvecied', 'descie');
    $a_fields['autofirma'] = array('cve_autofirma', 'des_autofirma');
    $a_fields['guia'] = array('cve_guia_practica', 'des_guia_practica');
    $a_fields['refiere'] = array('clues_refiere', 'des_uni_refiere');
    $a_fields['medicamento_urg'] = array('descripcion', 'cve_medicamento1');
    $a_fields['medicamento_urg2'] = array('descripcion2', 'cve_medicamento2');
    $a_fields['medicamento_urg3'] = array('descripcion3', 'cve_medicamento3');
	$a_fields['presta'] = array('num_expediente','cve_expediente','cve_paciente','nombre','app_pat','app_mat');



    $a_fieldsValDef = array();
    $a_fieldsValDef['partida'] = array('', ' ');
    $a_fieldsValDef['unidad'] = array('', ' ');
    $a_fieldsValDef['paciente'] = array(0, '', '', '', '', '', '', '', 0);
    $a_fieldsValDef['paciente2'] = array(0, '', '', '', '', '', '', '', '', '');
    $a_fieldsValDef['paciente3'] = array(0, '', '', '', '', '', '', '', '', '', '', '');
    $a_fieldsValDef['paciente_cit'] = array(0, '', '', '', '', '', '', '', 0, '');
    $a_fieldsValDef['cie'] = array('', 0, 0, '');
    $a_fieldsValDef['cie2'] = array('', '', '', '', '');
    $a_fieldsValDef['cie21'] = array('', '', '', '', '');
    $a_fieldsValDef['cie100'] = array('', '', '', '', '');
    $a_fieldsValDef['cie22'] = array('', '', '', '');
    $a_fieldsValDef['cieh2'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh3'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh4'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh5'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh6'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh7'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh8'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh9'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh10'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh11'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh12'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh13'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh14'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh15'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh16'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh17'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh18'] = array('', 0, 0, '');
    $a_fieldsValDef['cieh19'] = array('', 0, 0, '');
    $a_fieldsValDef['element'] = array('', 0, '', '');
    $a_fieldsValDef['paciente_1'] = array(0, '', '', '', '', '', '', 0);
    $a_fieldsValDef['cuota'] = array('', ' ', '','','');
    $a_fieldsValDef['causes'] = array('', ' ', '', '', '');
    $a_fieldsValDef['articulo_urg'] = array('', '');
    $a_fieldsValDef['articulo_urg2'] = array('', '');
    $a_fieldsValDef['articulo_urg3'] = array('', '');
    $a_fieldsValDef['articulo_r'] = array('', 0, '', '');
    $a_fieldsValDef['articulo_enf'] = array('', 0, '', '');
    $a_fieldsValDef['articulo_rx'] = array('', 0, '', '');
    $a_fieldsValDef['articulo_ry'] = array('', 0);
    $a_fieldsValDef['articulo_rz'] = array('', 0);
    $a_fieldsValDef['articulo_rx1'] = array('', 0, '', '');
    $a_fieldsValDef['articulo_rz1'] = array('', 0);
    $a_fieldsValDef['paciente4'] = array(0, '', '', '', '', '', '', 0);
    $a_fieldsValDef['cie4'] = array('', 0, 0, '');
    $a_fieldsValDef['cie5'] = array('', '', '');
    $a_fieldsValDef['guia'] = array('', '');
    $a_fieldsValDef['refiere'] = array('', '');
    $a_fieldsValDef['medicamento_urg'] = array('', '');
    $a_fieldsValDef['medicamento_urg2'] = array('', '');
    $a_fieldsValDef['medicamento_urg3'] = array('', '');
	$a_fieldsValDef['presta'] = array('', '','', '','', '');


    $a_strFields = array();
    $a_strFields['partida'] = ' p.cvePar, p.desPar';
    $a_strFields['unidad'] = ' u.cve_uni, u.des_uni';
    $a_strFields['paciente'] = 'p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo ';
    $a_strFields['paciente2'] = 'p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.edad,p.fecha_nacimiento,s.sexo, s.cve_sexo, p.telefono_particular, p.telefono_celular, r.parentesco, r.cve_parentesco,p.nombre_parentesco ';
    $a_strFields['paciente3'] = 'p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.poliza,concat(p.calle,"#",p.num_ext) as domicilio,s.sexo, s.cve_sexo, e.num_expediente, e.cve_expediente, j.prefijo, j.cve_prefijo, a.area, a.cve_area';
    $a_strFields['paciente_cit'] = 'p.cve_paciente,p.nombre,p.app_pat,p.app_mat,DATE_FORMAT(p.fecha_nacimiento, "%d/%m/%Y")as fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo, e.num_exp_hosp as expediente ';
    $a_strFields['cie'] = " ce.cvecie, ce.cvecied, ce.descied ";

    if (isset($_POST['causes'])) {
        $a_strFields['cie2'] = " ce.cvecie  , ce.cvecied  , ce.descied, cat.id_inter_causes, cat.des_inter_causes  ";
    } else {
        $a_strFields['cie2'] = " ce.cvecie  , ce.cvecied  , ce.descied, 0 as id_inter_causes";
    }


    if (isset($_POST['causes'])) {
        $a_strFields['cie21'] = " f.cvecie,f.cvecied,f.descied,cat.id_inter_causes,cat.des_inter_causes   ";
    } else {
        $a_strFields['cie21'] = " f.cvecie  , f.cvecied  ,f.descied, 0 as id_inter_causes";
    }

    $a_strFields['cie100'] = "ce.id_cie, ce.cvecie,ce.descie,i.id_intervencion,i.des_intervencion   ";


    $a_strFields['cie22'] = " ce.id_cie as id_cie9  , ce.cvecie as cvecie9 , ce.descie";

    $a_strFields['cieh2'] = " ce.id_cie as cvecie2 , ce.cvecie as cvecied2  , ce.descie as descied2 ";
    $a_strFields['cieh3'] = " ce.id_cie as cvecie3 , ce.cvecie as cvecied3  , ce.descie as descied3 ";
    $a_strFields['cieh4'] = " ce.id_cie as cvecie4 , ce.cvecie as cvecied4  , ce.descie as descied4 ";
    $a_strFields['cieh5'] = " ce.id_cie as cvecie5 , ce.cvecie as cvecied5  , ce.descie as descied5 ";
    $a_strFields['cieh6'] = " ce.id_cie as cvecie6 , ce.cvecie as cvecied6  , ce.descie as descied6 ";
    $a_strFields['cieh7'] = " ce.id_cie as cvecie7 , ce.cvecie as cvecied7  , ce.descie as descied7 ";
    $a_strFields['cieh8'] = " ce.id_cie as cvecie8 , ce.cvecie as cvecied8  , ce.descie as descied8 ";
    $a_strFields['cieh9'] = " ce.id_cie as cvecie9 , ce.cvecie as cvecied9  , ce.descie as descied9 ";
    $a_strFields['cieh10'] = " ce.id_cie as cvecie10 , ce.cvecie as cvecied10  , ce.descie as descied10 ";
    $a_strFields['cieh11'] = " ce.id_cie as cvecie11 , ce.cvecie as cvecied11  , ce.descie as descied11 ";
    $a_strFields['cieh12'] = " ce.id_cie as cvecie12 , ce.cvecie as cvecied12  , ce.descie as descied12 ";
    $a_strFields['cieh13'] = " ce.id_cie as cvecie13 , ce.cvecie as cvecied13  , ce.descie as descied13 ";
    $a_strFields['cieh14'] = " ce.id_cie as cvecie14 , ce.cvecie as cvecied14 , ce.descie as descied14 ";
    $a_strFields['cieh15'] = " ce.id_cie as cvecie15 , ce.cvecie as cvecied15  , ce.descie as descied15 ";
    $a_strFields['cieh16'] = " ce.id_cie as cvecie16 , ce.cvecie as cvecied16  , ce.descie as descied16 ";
    $a_strFields['cieh17'] = " ce.id_cie as cvecie17 , ce.cvecie as cvecied17  , ce.descie as descied17 ";
    $a_strFields['cieh18'] = " ce.id_cie as cvecie18 , ce.cvecie as cvecied18 , ce.descie as descied18 ";
    $a_strFields['cieh19'] = " ce.id_cie as cvecie19 , ce.cvecie as cvecied19  , ce.descie as descied19 ";



    $a_strFields['element'] = ' r.des_medico, r.cve_medico, r.cedula, r.rfc';
    $a_strFields['paciente_1'] = 'p.cve_paciente,p.nombre ,p.app_pat, p.app_mat,p.fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo ';
    $a_strFields['cuota'] = 't.cve_cap_cuota,t.des_cap_cuota, p.noIdentificacion, p.descripcion, IF(cp.cve_cuotas_programa IS NULL,p.nivel'.$nivel.',if(pp.nivel = 1,p.nivel1,
if(pp.nivel = 2,p.nivel2,
if(pp.nivel = 3,p.nivel3,
if(pp.nivel = 4,p.nivel4,
if(pp.nivel = 5,p.nivel5,
if(pp.nivel = 6,p.nivel6,""))))))) AS nivel,IF(cp.cve_cuotas_programa IS NULL,'.$nivel.',pp.nivel) as nivel_pro,cp.cve_cuotas_programa as programa';
    // 'if(d.nivel=2,p.nivel2,if(d.nivel=3,p.nivel3,if(d.nivel=4,p.nivel4,if(d.nivel=5,p.nivel5,if(d.nivel=6,p.nivel6,0)))))) ;
    $a_strFields['causes'] = ' p.id_inter_causes,p.cve_inter_causes,p.des_inter_causes,p.alcance_exencion,p.servicio_cubre';
    $a_strFields['articulo_urg'] = 'distinct(a.cve_articulo), a.des_articulo';
    $a_strFields['articulo_urg2'] = 'distinct(a.cve_articulo) as cve_articulo2 , a.des_articulo as des_articulo2';
    $a_strFields['articulo_urg3'] = 'distinct(a.cve_articulo) as cve_articulo3 , a.des_articulo as des_articulo3';
    $a_strFields['articulo_r'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart, a.unmed';
    $a_strFields['articulo_enf'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart, a.unmed';
    $a_strFields['articulo_rx'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart, a.unmed';
    $a_strFields['articulo_ry'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart';
    $a_strFields['articulo_rx1'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart';
    $a_strFields['articulo_rz1'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart';
    $a_strFields['articulo_rz'] = 'distinct(a.cve_articulo), a.des_articulo, a.preart';
    $a_strFields['paciente4'] = 'p.cve_paciente,p.nombre ,p.app_pat, p.app_mat,p.fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo ';
    $a_strFields['cie4'] = " ce.id_cie, ce.cvecie, ce.descie";
    $a_strFields['cie5'] = " ce.id_cie as cvecie, ce.cvecie as cvecied, ce.descie ";
    $a_strFields['autofirma'] = " a.cve_autofirma, a.des_autofirma ";
    $a_strFields['guia'] = " g.cve_guia_practica, g.des_guia_practica ";
    $a_strFields['refiere'] = " u.clues_refiere, u.des_uni_refiere ";
    $a_strFields['medicamento_urg'] = 'distinct(a.cve_medicamento) as cve_medicamento1, a.descripcion';
    $a_strFields['medicamento_urg2'] = 'distinct(a.cve_medicamento) as cve_medicamento2 , a.descripcion as descripcion2';
    $a_strFields['medicamento_urg3'] = 'distinct(a.cve_medicamento) as cve_medicamento3 , a.descripcion as descripcion3';
	$a_strFields['presta'] =  ' if(e.cve_prefijo=2,e.num_exp_hosp,e.num_expediente) as num_expediente, e.cve_expediente,p.cve_paciente,p.nombre,p.app_pat,p.app_mat';


    $a_fieldsCond0 = array();
    $a_fieldsCond0['partida'] = array('desPar');
    $a_fieldsCond0['unidad'] = array('des_uni');
    $a_fieldsCond0['paciente'] = array('nombre');
    $a_fieldsCond0['paciente2'] = array('nombre');
    $a_fieldsCond0['paciente3'] = array('nombre');
    $a_fieldsCond0['paciente_cit'] = array('nombre');
    $a_fieldsCond0['cie'] = array('descied');

    $a_fieldsCond0['cie2'] = array('descied');
    $a_fieldsCond0['cie21'] = array('descied');
    $a_fieldsCond0['cie100'] = array('descie');
    $a_fieldsCond0['cie22'] = array('descie');

    $a_fieldsCond0['cieh2'] = array('descied2');
    $a_fieldsCond0['cieh3'] = array('descied3');
    $a_fieldsCond0['cieh4'] = array('descied4');
    $a_fieldsCond0['cieh5'] = array('descied5');
    $a_fieldsCond0['cieh6'] = array('descied6');
    $a_fieldsCond0['cieh7'] = array('descied7');
    $a_fieldsCond0['cieh8'] = array('descied8');
    $a_fieldsCond0['cieh9'] = array('descied9');
    $a_fieldsCond0['cieh10'] = array('descied10');
    $a_fieldsCond0['cieh11'] = array('descied11');
    $a_fieldsCond0['cieh12'] = array('descied12');
    $a_fieldsCond0['cieh13'] = array('descied13');
    $a_fieldsCond0['cieh14'] = array('descied14');
    $a_fieldsCond0['cieh15'] = array('descied15');
    $a_fieldsCond0['cieh16'] = array('descied16');
    $a_fieldsCond0['cieh17'] = array('descied17');
    $a_fieldsCond0['cieh18'] = array('descied18');
    $a_fieldsCond0['cieh19'] = array('descied19');


    $a_fieldsCond0['element'] = array('des_medico');
    $a_fieldsCond0['paciente_1'] = array('nombre');
    $a_fieldsCond0['cuota'] = array('descripcion');
    $a_fieldsCond0['causes'] = array('des_inter_causes');
    $a_fieldsCond0['articulo_urg'] = array('des_articulo');
    $a_fieldsCond0['articulo_urg2'] = array('des_articulo2');
    $a_fieldsCond0['articulo_urg3'] = array('des_articulo3');
    $a_fieldsCond0['articulo_r'] = array('des_articulo', 'cve_receta');
    $a_fieldsCond0['articulo_enf'] = array('des_articulo', 'cve_registro_enfermeria');
    $a_fieldsCond0['articulo_rx'] = array('des_articulo', 'cve_recolectiva');
    $a_fieldsCond0['articulo_ry'] = array('des_articulo', 'cve_pastilleo');
    $a_fieldsCond0['articulo_rz'] = array('des_articulo', 'cve_recurgencias');
    $a_fieldsCond0['articulo_rx1'] = array('des_articulo', 'cve_recmaterial');
    $a_fieldsCond0['articulo_rz1'] = array('des_articulo', 'cve_recurgmaterial');
    $a_fieldsCond0['paciente4'] = array('nombre');
    $a_fieldsCond0['cie4'] = array('descie');
    $a_fieldsCond0['cie5'] = array('descie');
    $a_fieldsCond0['autofirma'] = array('des_autofirma');
    $a_fieldsCond0['guia'] = array('des_guia_practica');
    $a_fieldsCond0['refiere'] = array('des_uni_refiere');
    $a_fieldsCond0['medicamento_urg'] = array('descripcion');
    $a_fieldsCond0['medicamento_urg2'] = array('descripcion2');
    $a_fieldsCond0['medicamento_urg3'] = array('descripcion3');
	$a_fieldsCond0['presta'] = array('num_expediente');



    $a_fieldsCond1 = array();
    $a_fieldsCond1['partida'] = array(array('p.cvePar', 'p.desPar'));
    $a_fieldsCond1['unidad'] = array(array('u.cve_uni', 'u.des_uni'));
    $a_fieldsCond1['paciente'] = array(array('p.cve_paciente', 'p.nombre'));
    $a_fieldsCond1['paciente2'] = array(array('p.cve_paciente', 'p.nombre'));
    $a_fieldsCond1['paciente3'] = array(array('p.cve_paciente', 'p.nombre'));
    $a_fieldsCond1['paciente_cit'] = array(array('p.expediente', 'concat(p.nombre," ",p.app_pat," ",p.app_mat)'));
    $a_fieldsCond1['cie'] = array(array('ce.cvecied', 'ce.descied'));

    $a_fieldsCond1['cie2'] = array(array('ce.cvecied', 'ce.descied'));
    $a_fieldsCond1['cie21'] = array(array('f.cvecied', 'f.descied'));
    $a_fieldsCond1['cie100'] = array(array('ce.cvecie', 'ce.descie', 'i.des_intervencion'));
    $a_fieldsCond1['cie22'] = array(array('ce.cvecie', 'ce.descie'));

    $a_fieldsCond1['cieh2'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh3'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh4'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh5'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh6'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh7'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh8'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh9'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh10'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh11'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh12'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh13'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh14'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh15'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh16'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh17'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh18'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cieh19'] = array(array('ce.cvecie', 'ce.descie'));

    $a_fieldsCond1['element'] = array(array('r.des_medico'));
    $a_fieldsCond1['paciente_1'] = array(array('p.cve_paciente', 'p.nombre'));
    $a_fieldsCond1['cuota'] = array(array('p.noIdentificacion', 'p.descripcion'));
    $a_fieldsCond1['causes'] = array(array('p.des_inter_causes'));
    $a_fieldsCond1['articulo_urg'] = array(array('a.cve_articulo', 'a.des_articulo'));
    $a_fieldsCond1['articulo_urg2'] = array(array('a.cve_articulo', 'a.des_articulo'));
    $a_fieldsCond1['articulo_urg3'] = array(array('a.cve_articulo', 'a.des_articulo'));
    $a_fieldsCond1['articulo_r'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_receta');
    $a_fieldsCond1['articulo_enf'] = array(array('a.cve_articulo', 'a.des_articulo'), 'cve_registro_enfermeria');
    $a_fieldsCond1['articulo_rx'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_recolectiva');
    $a_fieldsCond1['articulo_ry'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_pastilleo');
    $a_fieldsCond1['articulo_rz'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_recurgencias');
    $a_fieldsCond1['articulo_rx1'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_recmaterial');
    $a_fieldsCond1['articulo_rz1'] = array(array('a.cve_articulo', 'a.des_articulo'), 'r.cve_recurgmaterial');
    $a_fieldsCond1['paciente4'] = array(array('p.cve_paciente', 'p.nombre'));
    $a_fieldsCond1['cie4'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['cie5'] = array(array('ce.cvecie', 'ce.descie'));
    $a_fieldsCond1['autofirma'] = array(array('a.des_autofirma'));
    $a_fieldsCond1['guia'] = array(array('g.des_guia_practica'));
    $a_fieldsCond1['refiere'] = array(array('u.des_uni_refiere'));
    $a_fieldsCond1['medicamento_urg'] = array(array('a.cve_medicamento', 'a.descripcion'));
    $a_fieldsCond1['medicamento_urg2'] = array(array('a.cve_medicamento', 'a.descripcion'));
    $a_fieldsCond1['medicamento_urg3'] = array(array('a.cve_medicamento', 'a.descripcion'));
	$a_fieldsCond1['presta'] = array(array('if(e.cve_prefijo=2,e.num_exp_hosp,e.num_expediente)','p.nombre'));





    $a_fieldsConTtype = array();
    $a_fieldsConTtype['partida'] = array('text', 'num');
    $a_fieldsConTtype['unidad'] = array('text');
    $a_fieldsConTtype['paciente'] = array('text');
    $a_fieldsConTtype['paciente2'] = array('text');
    $a_fieldsConTtype['paciente3'] = array('text');
    $a_fieldsConTtype['paciente_cit'] = array('text', 'text');
    $a_fieldsConTtype['cie'] = array('text', 'text');
    $a_fieldsConTtype['cie2'] = array('text', 'text');
    $a_fieldsConTtype['cie21'] = array('text', 'text');
    $a_fieldsConTtype['cie100'] = array('text', 'text', 'text');
    $a_fieldsConTtype['cie22'] = array('text', 'text');

    $a_fieldsConTtype['cieh2'] = array('text', 'text');
    $a_fieldsConTtype['cieh3'] = array('text', 'text');
    $a_fieldsConTtype['cieh4'] = array('text', 'text');
    $a_fieldsConTtype['cieh5'] = array('text', 'text');
    $a_fieldsConTtype['cieh6'] = array('text', 'text');
    $a_fieldsConTtype['cieh7'] = array('text', 'text');
    $a_fieldsConTtype['cieh8'] = array('text', 'text');
    $a_fieldsConTtype['cieh9'] = array('text', 'text');
    $a_fieldsConTtype['cieh10'] = array('text', 'text');
    $a_fieldsConTtype['cieh11'] = array('text', 'text');
    $a_fieldsConTtype['cieh12'] = array('text', 'text');
    $a_fieldsConTtype['cieh13'] = array('text', 'text');
    $a_fieldsConTtype['cieh14'] = array('text', 'text');
    $a_fieldsConTtype['cieh15'] = array('text', 'text');
    $a_fieldsConTtype['cieh16'] = array('text', 'text');
    $a_fieldsConTtype['cieh17'] = array('text', 'text');
    $a_fieldsConTtype['cieh18'] = array('text', 'text');
    $a_fieldsConTtype['cieh19'] = array('text', 'text');

    $a_fieldsConTtype['element'] = array('text');
    $a_fieldsConTtype['paciente_1'] = array('text');
    $a_fieldsConTtype['cuota'] = array('text', 'text');
    $a_fieldsConTtype['causes'] = array('text', 'text');
    $a_fieldsConTtype['articulo_urg'] = array('text', 'text');
    $a_fieldsConTtype['articulo_urg2'] = array('text', 'text');
    $a_fieldsConTtype['articulo_urg3'] = array('text', 'text');
    $a_fieldsConTtype['articulo_r'] = array('text', 'text');
    $a_fieldsConTtype['articulo_enf'] = array('text', 'text');
    $a_fieldsConTtype['articulo_rx'] = array('text', 'text');
    $a_fieldsConTtype['articulo_ry'] = array('text', 'text');
    $a_fieldsConTtype['articulo_rz'] = array('text', 'text');
    $a_fieldsConTtype['articulo_rx1'] = array('text', 'text');
    $a_fieldsConTtype['articulo_rz1'] = array('text', 'text');
    $a_fieldsConTtype['paciente4'] = array('text');
    $a_fieldsConTtype['cie4'] = array('text', 'text');
    $a_fieldsConTtype['cie5'] = array('text', 'text');
    $a_fieldsConTtype['autofirma'] = array('text');
    $a_fieldsConTtype['guia'] = array('text');
    $a_fieldsConTtype['refiere'] = array('text');
    $a_fieldsConTtype['medicamento_urg'] = array('text', 'text');
    $a_fieldsConTtype['medicamento_urg2'] = array('text', 'text');
    $a_fieldsConTtype['medicamento_urg3'] = array('text', 'text');
	$a_fieldsConTtype['presta'] = array('text','text');







    $a_condOper = array();
    $a_condOper['partida'] = array(array('like', 'like'));
    $a_condOper['unidad'] = array(array('like', 'like'));
    $a_condOper['paciente'] = array(array('like', 'like'));
    $a_condOper['paciente2'] = array(array('like', 'like'));
    $a_condOper['paciente3'] = array(array('like', 'like'));
    $a_condOper['paciente_cit'] = array(array('like', 'like'));
    $a_condOper['cie'] = array(array('like', 'like'));


    $a_condOper['cie2'] = array(array('like', 'like'));
    $a_condOper['cie21'] = array(array('like', 'like'));
    $a_condOper['cie100'] = array(array('like', 'like', 'like'));
    $a_condOper['cie22'] = array(array('like', 'like'));


    $a_condOper['cieh2'] = array(array('like', 'like'));
    $a_condOper['cieh3'] = array(array('like', 'like'));
    $a_condOper['cieh4'] = array(array('like', 'like'));
    $a_condOper['cieh5'] = array(array('like', 'like'));
    $a_condOper['cieh6'] = array(array('like', 'like'));
    $a_condOper['cieh7'] = array(array('like', 'like'));
    $a_condOper['cieh8'] = array(array('like', 'like'));
    $a_condOper['cieh9'] = array(array('like', 'like'));
    $a_condOper['cieh10'] = array(array('like', 'like'));
    $a_condOper['cieh11'] = array(array('like', 'like'));
    $a_condOper['cieh12'] = array(array('like', 'like'));
    $a_condOper['cieh13'] = array(array('like', 'like'));
    $a_condOper['cieh14'] = array(array('like', 'like'));
    $a_condOper['cieh15'] = array(array('like', 'like'));
    $a_condOper['cieh16'] = array(array('like', 'like'));
    $a_condOper['cieh17'] = array(array('like', 'like'));
    $a_condOper['cieh18'] = array(array('like', 'like'));
    $a_condOper['cieh19'] = array(array('like', 'like'));

    $a_condOper['element'] = array(array('like'));
    $a_condOper['paciente_1'] = array(array('like', 'like'));
    $a_condOper['cuota'] = array(array('=', 'like'));
    $a_condOper['causes'] = array(array('like', 'like'));
    $a_condOper['articulo_urg'] = array(array('like', 'like'));
    $a_condOper['articulo_urg2'] = array(array('like', 'like'));
    $a_condOper['articulo_urg3'] = array(array('like', 'like'));
    $a_condOper['articulo_r'] = array(array('like', 'like'), '=');
    $a_condOper['articulo_enf'] = array(array('like', 'like'), '=');
    $a_condOper['articulo_rx'] = array(array('=', 'like'), '=');
    $a_condOper['articulo_ry'] = array(array('=', 'like'), '=');
    $a_condOper['articulo_rz'] = array(array('=', 'like'), '=');
    $a_condOper['articulo_rx1'] = array(array('=', 'like'), '=');
    $a_condOper['articulo_rz1'] = array(array('=', 'like'), '=');
    $a_condOper['paciente4'] = array(array('like', 'like'));
    $a_condOper['cie4'] = array(array('like', 'like'));
    $a_condOper['cie5'] = array(array('like', 'like'));
    $a_condOper['autofirma'] = array(array('like', 'like'));
    $a_condOper['guia'] = array(array('like', 'like'));
    $a_condOper['refiere'] = array(array('like', 'like'));
    $a_condOper['medicamento_urg'] = array(array('like', 'like'));
    $a_condOper['medicamento_urg2'] = array(array('like', 'like'));
    $a_condOper['medicamento_urg3'] = array(array('like', 'like'));
	$a_condOper['presta'] = array(array('like', 'like'));






    $a_Order = array();
    $a_Order['partida'] = array('desPar');
    $a_Order['unidad'] = array('des_uni');
    $a_Order['paciente'] = array('nombre');
    $a_Order['paciente2'] = array('nombre');
    $a_Order['paciente3'] = array('nombre');
    $a_Order['paciente_cit'] = array('nombre,app_pat,app_mat');
    $a_Order['cie'] = array('descied');
    $a_Order['cie2'] = array('ce.descied');
    $a_Order['cie21'] = array('f.descied');
    $a_Order['cie100'] = array('ce.descie');
    $a_Order['cie22'] = array('ce.descie');

    $a_Order['cieh2'] = array('descied2');
    $a_Order['cieh3'] = array('descied3');
    $a_Order['cieh4'] = array('descied4');
    $a_Order['cieh5'] = array('descied5');
    $a_Order['cieh6'] = array('descied6');
    $a_Order['cieh7'] = array('descied7');
    $a_Order['cieh8'] = array('descied8');
    $a_Order['cieh9'] = array('descied9');
    $a_Order['cieh10'] = array('descied10');
    $a_Order['cieh11'] = array('descied11');
    $a_Order['cieh12'] = array('descied12');
    $a_Order['cieh13'] = array('descied13');
    $a_Order['cieh14'] = array('descied14');
    $a_Order['cieh15'] = array('descied15');
    $a_Order['cieh16'] = array('descied16');
    $a_Order['cieh17'] = array('descied17');
    $a_Order['cieh18'] = array('descied18');
    $a_Order['cieh19'] = array('descied19');

    $a_Order['element'] = array('r.des_medico');
    $a_Order['paciente_1'] = array('p.nombre');
    $a_Order['cuota'] = array('p.descripcion');
    $a_Order['causes'] = array('p.des_inter_causes');
    $a_Order['articulo_urg'] = array('a.des_articulo');
    $a_Order['articulo_urg2'] = array('des_articulo2');
    $a_Order['articulo_urg3'] = array('des_articulo3');
    $a_Order['articulo_r'] = array('a.des_articulo');
    $a_Order['articulo_enf'] = array('a.des_articulo');
    $a_Order['articulo_rx'] = array('a.des_articulo');
    $a_Order['articulo_ry'] = array('a.des_articulo');
    $a_Order['articulo_rz'] = array('a.des_articulo');
    $a_Order['articulo_rx1'] = array('a.des_articulo');
    $a_Order['articulo_rz1'] = array('a.des_articulo');
    $a_Order['paciente4'] = array('nombre');
    $a_Order['cie4'] = array('descie');
    $a_Order['cie5'] = array('descie');
    $a_Order['autofirma'] = array('des_autofirma');
    $a_Order['guia'] = array('des_guia_practica');
    $a_Order['refiere'] = array('des_uni_refiere');
    $a_Order['medicamento_urg'] = array('a.descripcion');
    $a_Order['medicamento_urg2'] = array('a.descripcion');
    $a_Order['medicamento_urg3'] = array('a.descripcion');
	$a_Order['presta'] = array('e.cve_expediente');






    $a_strWhere = array();
    $a_strWhere['partida'] = "";
    $a_strWhere['unidad'] = "";
    $a_strWhere['paciente'] = " p.cve_sexo=s.cve_sexo ";
    $a_strWhere['paciente2'] = " p.cve_sexo=s.cve_sexo and p.cve_parentesco=r.cve_parentesco";
    $a_strWhere['paciente3'] = "  p.cve_sexo=s.cve_sexo
 and p.cve_paciente=e.cve_paciente
 and e.cve_prefijo=j.cve_prefijo
 and e.cve_area=a.cve_area
 -- and a.cve_area=4";
    $a_strWhere['paciente_cit'] = " p.cve_sexo=s.cve_sexo and p.cve_estatus=2 and p.cve_paciente=e.cve_paciente";
    $a_strWhere['cie'] = " cie10=1";


    if (isset($_POST['causes'])) {
        $a_strWhere['cie2'] = " ce.cie9=1 and ce.cvecied=de.cve_cied 
and cat.id_inter_causes=de.id_inter_causes";
    } else {
        $a_strWhere['cie2'] = " ce.cie9=1 ";
    }


    if (isset($_POST['causes'])) {
        $a_strWhere['cie21'] = " f.cie10=1 and ce.CLAVE_CIE=f.cvecie collate latin1_swedish_ci

and de.cve_cied=f.cvecie collate latin1_swedish_ci
and cat.id_inter_causes=de.id_inter_causes collate latin1_swedish_ci
and ce.ID_PADECIMIENTO=de.id_padecimiento collate latin1_swedish_ci";
    } else {
        $a_strWhere['cie21'] = " f.cie10=1 ";
    }

    $a_strWhere['cie100'] = " ce.cie10=1 ";

    $a_strWhere['cie22'] = " ce.cie9=1 ";
    $a_strWhere['cieh2'] = "";
    $a_strWhere['cieh3'] = "";
    $a_strWhere['cieh4'] = "";
    $a_strWhere['cieh5'] = "";
    $a_strWhere['cieh6'] = "";
    $a_strWhere['cieh7'] = "";
    $a_strWhere['cieh8'] = "";
    $a_strWhere['cieh9'] = "";
    $a_strWhere['cieh10'] = "";
    $a_strWhere['cieh11'] = "";
    $a_strWhere['cieh12'] = "";
    $a_strWhere['cieh13'] = "";
    $a_strWhere['cieh14'] = "";
    $a_strWhere['cieh15'] = "";
    $a_strWhere['cieh16'] = "";
    $a_strWhere['cieh17'] = "";
    $a_strWhere['cieh18'] = "";
    $a_strWhere['cieh19'] = "";


    $a_strWhere['element'] = " r.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and r.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and r.status=1 ";
    $a_strWhere['paciente_1'] = " p.cve_sexo=s.cve_sexo ";
    
    if (isset($_POST['$prio']))
        $a_strWhere['cuota'] = " p.cveclasificacionCuotas= " . $_POST['cveclasificacionCuotas'];
    
    $a_strWhere['causes'] = "";


    $a_strWhere['articulo_urg'] = " a.cve_articulo = an.cve_articulo " .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            "   and u2.cvenivel=anh.cve_nivel " .
            " AND anh.fec_baja ) " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel";
##################################################################################################################################
    $a_strWhere['articulo_urg2'] = " a.cve_articulo = an.cve_articulo " .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            "   and u2.cvenivel=anh.cve_nivel " .
            " AND anh.fec_baja ) " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel";
##################################################################################################################################
    $a_strWhere['articulo_urg3'] = " a.cve_articulo = an.cve_articulo " .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            "   and u2.cvenivel=anh.cve_nivel " .
            " AND anh.fec_baja ) " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel";
##################################################################################################################################


    $a_strWhere['articulo_r'] = " a.cve_articulo = an.cve_articulo " .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha_elaboracion BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_receta='" . (addslashes($_POST['cve_receta']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel";

#################################################################################################################################
    $a_strWhere['articulo_enf'] = " a.cve_articulo = an.cve_articulo " .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, registro_enfermeria r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_registro_enfermeria='" . (addslashes($_POST['cve_registro_enfermeria']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel";
    /*     * ********************************************************************************************************************************************************* */
    $a_strWhere['articulo_rx'] = " a.cve_suministro=1 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_colectiva r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recolectiva='" . (addslashes($_POST['cve_recolectiva']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel ";
    /*     * ********************************************************************************************************************************************************* */
    $a_strWhere['articulo_ry'] = " a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, pastilleo r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_pastilleo='" . (addslashes($_POST['cve_pastilleo']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel ";


    $a_strWhere['articulo_rz'] = " a.cve_suministro=1 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_urgencias r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recurgencias='" . (addslashes($_POST['cve_recurgencias']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel ";

    $a_strWhere['articulo_rx1'] = " a.cve_suministro=2 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_mat_curacion r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recmaterial='" . (addslashes($_POST['cve_recmaterial']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel ";



    $a_strWhere['articulo_rz1'] = " a.cve_suministro=2 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
            " and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion" .
            " and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_urg_material r2, unidad u2 where " .
            " u2.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u2.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' " .
            " and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel " .
            "and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recurgmaterial='" . (addslashes($_POST['cve_recurgmaterial']) * 1) . "') " .
            " and u.cveuni='" . $__SESSION->getValueSession('cveunidad') . "' and u.cve_jurisdiccion='" . $__SESSION->getValueSession('cvejurisdiccion') . "' and u.cvenivel=an.cve_nivel ";
    $a_strWhere['paciente4'] = " p.cve_sexo=s.cve_sexo ";
    $a_strWhere['cie4'] = "";
    $a_strWhere['cie5'] = "";
    $a_strWhere['autofirma'] = "";
    $a_strWhere['guia'] = "";
    $a_strWhere['refiere'] = "";
    $a_strWhere['medicamento_urg'] = " a.n5=1";
    $a_strWhere['medicamento_urg2'] = " a.n5=1";
    $a_strWhere['medicamento_urg3'] = " a.n5=1";
	$a_strWhere['presta'] = "";



    $a_strGroup = array();
    $a_strGroup['partida'] = "";
    $a_strGroup['unidad'] = "";
    $a_strGroup['paciente'] = "";
    $a_strGroup['paciente2'] = "";
    $a_strGroup['paciente3'] = "";
    $a_strGroup['paciente_cit'] = "";
    $a_strGroup['cie'] = "";
    $a_strGroup['cie2'] = "";
    $a_strGroup['cie21'] = "  group by f.cvecie";
    $a_strGroup['cie100'] = "  ";
    $a_strGroup['cie22'] = "";

    $a_strGroup['cieh2'] = "";
    $a_strGroup['cieh3'] = "";
    $a_strGroup['cieh4'] = "";
    $a_strGroup['cieh5'] = "";
    $a_strGroup['cieh6'] = "";
    $a_strGroup['cieh7'] = "";
    $a_strGroup['cieh8'] = "";
    $a_strGroup['cieh9'] = "";
    $a_strGroup['cieh10'] = "";
    $a_strGroup['cieh11'] = "";
    $a_strGroup['cieh12'] = "";
    $a_strGroup['cieh13'] = "";
    $a_strGroup['cieh14'] = "";
    $a_strGroup['cieh15'] = "";
    $a_strGroup['cieh16'] = "";
    $a_strGroup['cieh17'] = "";
    $a_strGroup['cieh18'] = "";
    $a_strGroup['cieh19'] = "";


    $a_strGroup['element'] = "";
    $a_strGroup['paciente_1'] = "";
    $a_strGroup['cuota'] = "";
    $a_strGroup['causes'] = "";
    $a_strGroup['articulo_r'] = "";
    $a_strGroup['articulo_urg'] = "";
    $a_strGroup['articulo_urg2'] = "";
    $a_strGroup['articulo_urg3'] = "";
    $a_strGroup['articulo_enf'] = "";
    $a_strGroup['articulo_rx'] = "";
    $a_strGroup['articulo_ry'] = "";
    $a_strGroup['articulo_rz'] = "";
    $a_strGroup['articulo_rx1'] = "";
    $a_strGroup['articulo_rz1'] = "";
    $a_strGroup['paciente4'] = "";
    $a_strGroup['cie4'] = "";
    $a_strGroup['cie5'] = "";
    $a_strGroup['autofirma'] = "";
    $a_strGroup['guia'] = "";
    $a_strGroup['refiere'] = "";
    $a_strGroup['medicamento_urg'] = "";
    $a_strGroup['medicamento_urg2'] = "";
    $a_strGroup['medicamento_urg3'] = "";
	$a_strGroup['presta'] = "";

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

    /* echo "<pre>";	
      print_r($_POST);
      echo "</pre>"; */
    $strWhere = $a_strWhere[$_POST['entvalue']];
    $classind = new Entidad($a_fields[$_POST['entvalue']], $a_fieldsValDef[$_POST['entvalue']]);
    foreach ($a_fieldsCond0[$_POST['entvalue']] as $cnt_afield => $afield) {
        if (strlen($strWhere) > 0) {
            $strWhere.=" and ";
        }
        switch ($a_fieldsConTtype[$_POST['entvalue']][$cnt_afield]) {
            case 'text':
                if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])) {
                    $strWhere.=" (";
                    foreach ($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1) {
                        if ($countCond1 > 0) {
                            $strWhere.=" or ";
                        }
                        if ($a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] == 'like') {
                            $strWhere.=" " . $itemCond1 . " " . $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] . " '%" . addslashes($_POST[$afield]) . "%'";
                        } else {
                            $strWhere.=" " . $itemCond1 . " " . $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] . " '" . addslashes($_POST[$afield]) . "'";
                        }
                    }
                    $strWhere.=" )";
                } else {
                    if ($a_condOper[$_POST['entvalue']][$cnt_afield] == 'like') {
                        $strWhere.=" " . $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " '%" . addslashes($_POST[$afield]) . "%'";
                    } else {
                        $strWhere.=" " . $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " '" . addslashes($_POST[$afield]) . "'";
                    }
                }
                break;
            case 'num':
                if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])) {
                    $strWhere.=" (";
                    foreach ($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1) {
                        if ($countCond1 > 0) {
                            $strWhere.=" or ";
                        }
                        $strWhere.=" " . $itemCond1 . " " . $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] . " " . addslashes($_POST[$afield]);
                    }
                    $strWhere.=" )";
                } else {
                    $strWhere.=" " . $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " " . $a_condOper[$_POST['entvalue']][$cnt_afield] . " " . addslashes($_POST[$afield]);
                }


                break;
        }
    }
    if (strlen($strWhere) > 0)
        $strWhere = " Where " . $strWhere;
    $strWhere .= $a_strGroup[$_POST['entvalue']];
    //die($strWhere);
    if ($_POST['entvalue'] == "cie100") {

        $arrayquery = explode("=", $_POST['queryc']);

        $strWhere .=" and ce." . $arrayquery[0] . " = '" . $arrayquery[1] . "'";

        //echo ''.$strWhere;
    }

    $xml = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
    $xml .= '<datos>';

    $classind->ListaEntidades($a_Order[$_POST['entvalue']], $a_table[$_POST['entvalue']], $strWhere, $a_strFields[$_POST['entvalue']]);
    /*echo "<pre>";
	print_r($classind);
	die();*/
    for ($i = 0; $i < $classind->NumReg; $i++) {/////##########################################///////////
        $classind->VerDatosEntidad($i, $a_fields[$_POST['entvalue']], FALSE);
        $xml .= '<elemento>';
        foreach ($a_fields[$_POST['entvalue']] as $cnt_field => $item_field) {
            if ($cnt_field > 0) {
                $xml .='@:::@';
            }
            $xml .= $item_field . "@===@" . str_replace(array("&", ">", "<"), array(" ", "&gt;", "&lt;"), $classind->$item_field);
        }
        $xml .= '</elemento>';
    }
    if ($_POST['entvalue'] == "cie100") {
        if ($classind->NumReg == 0) {
            $arrayq = explode("=", $_POST['queryc']);
            $anios = "";
            $arrayq[0] = str_replace("`", '', $arrayq[0]);
            for ($i = 0; $i < strlen($arrayq[0]) - 1; $i++) {
                $anios.=$arrayq[0][$i];
            }
            $sexo = $arrayq[0][strlen($arrayq[0]) - 1];
            $sexo = $sexo != 'M' ? ' Masculino' : ' Femenino';

            $anios = str_replace("<", ' menor que ', $anios);
            $anios = str_replace(">=", ' mayor o igual ', $anios);

            $xml .= '<elemento>campo_dato||@===@no hay datos para el paciente que esta en el rango "' . $anios . '" año (s) con genero ' . $sexo;
            $xml .= '</elemento>';
        }
    }
    // print_r($classind);
    $xml .= '</datos>';
    header('Content-type: text/xml');
    echo $xml;
} else {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/i_refresh.php");
}
?>
