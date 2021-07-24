<?php 


session_start();
$str_check=FALSE;
include_once("includes/i_check.php");
if ($str_check) {
	include_once("config/cfg.php");
	include_once("lib/lib_pgsql.php");
	include_once("lib/lib_entidad.php");
	include_once("lib/lib_function.php");
	include_once("rep/lib/lib32.php");

//die();
$a_table=array();
$a_table['partida']=' partidas p';
$a_table['unidad']=' unidad u';
$a_table['paciente']=' paciente p, sexo s, area a';
$a_table['paciente2']=' paciente p, sexo s, parentesco r';
$a_table['paciente3']=' paciente p, sexo s, expediente e, prefijos j, area a';
$a_table['cie']='catenf ce';
$a_table['cie2']='catenf ce';
$a_table['element']='medico r';
$a_table['articulo_r']='articulo a, receta_individual r, articulonivel an, unidad u'; //, '.
$a_table['articulo_rx']='articulo a, receta_colectiva r, articulonivel an, unidad u'; //, '
$a_table['paciente_1']=' paciente p, sexo s ';
$a_table['cuota']=' cuotas p';
$a_table['articulo_ry']='articulo a, pastilleo r, articulonivel an, unidad u'; //, '.
$a_table['articulo_rz']='articulo a, receta_urgencias r, articulonivel an, unidad u'; //, '.
$a_table['articulo_rx1']='articulo a, receta_mat_curacion r, articulonivel an, unidad u'; //, '.
$a_table['articulo_rz1']='articulo a, receta_urg_material r, articulonivel an, unidad u'; //, '.
$a_table['paciente4']=' paciente p, sexo s ';
$a_table['cie4']='catenf ce';



$a_fields=array();
$a_fields['partida']=array('cvePar','desPar');
$a_fields['unidad']=array('cve_uni','des_uni');
$a_fields['paciente']=array('cve_paciente','nombre','app_pat','app_mat','fecha_nacimiento','sexo', 'cve_sexo');
$a_fields['paciente2']=array('cve_paciente','nombre','app_pat','app_mat','edad','fecha_nacimiento','sexo', 'cve_sexo', 'telefono_particular','telefono_celular','parentesco','cve_parentesco','nombre_parentesco ');
$a_fields['paciente3']=array('cve_paciente','nombre','app_pat','app_mat','poliza','p.calle','p.num_ext','sexo', 'cve_sexo', 'num_expediente','cve_expediente', 'prefijo', 'cve_prefijo', 'area', 'cve_area');
$a_fields['cie']=array('cvecie','cvecied','descied');
$a_fields['cie2']=array('cvecie','cvecied','descied');
$a_fields['element']=array('des_medico','cve_medico','cedula','rfc');
$a_fields['paciente_1']=array('cve_paciente','nombre','app_pat','app_mat','fecha_nacimiento','poliza','sexo', 'cve_sexo');
$a_fields['cuota']=array('noIdentificacion','descripcion','nivel5');
$a_fields['articulo_r']=array('des_articulo','cve_articulo','preart','unmed');
$a_fields['articulo_rx']=array('des_articulo','cve_articulo','preart','unmed');
$a_fields['articulo_ry']=array('des_articulo','cve_articulo');
$a_fields['articulo_rz']=array('des_articulo','cve_articulo','preart');
$a_fields['articulo_rx1']=array('des_articulo','cve_articulo','preart');
$a_fields['articulo_rz1']=array('des_articulo','cve_articulo','preart');
$a_fields['paciente4']=array('cve_paciente','nombre','app_pat','app_mat','fecha_nacimiento','poliza','sexo', 'cve_sexo');
$a_fields['cie4']=array('cvecie','cvecied','descied','valcie');



$a_fieldsValDef=array();
$a_fieldsValDef['partida']=array('',' ');
$a_fieldsValDef['unidad']=array('',' ');
$a_fieldsValDef['paciente']=array(0,'','','','','','',0);
$a_fieldsValDef['paciente2']=array(0,'','','','','','','','','');
$a_fieldsValDef['paciente3']=array(0,'','','','','','','','','','','');
$a_fieldsValDef['cie']=array('',0,0,'');
$a_fieldsValDef['cie2']=array('',0,0,'');
$a_fieldsValDef['element']=array('',0,'','');
$a_fieldsValDef['paciente_1']=array(0,'','','','','','',0);
$a_fieldsValDef['cuota']=array('',' ','');
$a_fieldsValDef['articulo_r']=array('',0,'','');
$a_fieldsValDef['articulo_rx']=array('',0,'','');
$a_fieldsValDef['articulo_ry']=array('',0);
$a_fieldsValDef['articulo_rz']=array('',0);
$a_fieldsValDef['articulo_rx1']=array('',0,'','');
$a_fieldsValDef['articulo_rz1']=array('',0);
$a_fieldsValDef['paciente4']=array(0,'','','','','','',0);
$a_fieldsValDef['cie4']=array('',0,0,'');


$a_strFields=array();
$a_strFields['partida']=' p.cvePar, p.desPar';
$a_strFields['unidad']=' u.cve_uni, u.des_uni';
$a_strFields['paciente']='p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.fecha_nacimiento,s.sexo,s.cve_sexo ';
$a_strFields['paciente2']='p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.edad,p.fecha_nacimiento,s.sexo, s.cve_sexo, p.telefono_particular, p.telefono_celular, r.parentesco, r.cve_parentesco,p.nombre_parentesco ';
$a_strFields['paciente3']='p.cve_paciente,p.nombre,p.app_pat,p.app_mat,p.poliza,concat(p.calle,"#",p.num_ext) as domicilio,s.sexo, s.cve_sexo, e.num_expediente, e.cve_expediente, j.prefijo, j.cve_prefijo, a.area, a.cve_area';
$a_strFields['cie']=" ce.cvecie, ce.cvecied, ce.descied ";
$a_strFields['cie2']=" ce.cvecie , ce.cvecied  , ce.descied  ";	
$a_strFields['element']=' r.des_medico, r.cve_medico, r.cedula, r.rfc';
$a_strFields['paciente_1']='p.cve_paciente,p.nombre ,p.app_pat, p.app_mat,p.fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo ';
$a_strFields['cuota']=' p.noIdentificacion, p.descripcion, p.nivel5';
$a_strFields['articulo_r']='distinct(a.cve_articulo), a.des_articulo, a.preart, a.unmed';
$a_strFields['articulo_rx']='distinct(a.cve_articulo), a.des_articulo, a.preart, a.unmed';
$a_strFields['articulo_ry']='distinct(a.cve_articulo), a.des_articulo, a.preart';
$a_strFields['articulo_rx1']='distinct(a.cve_articulo), a.des_articulo, a.preart';
$a_strFields['articulo_rz1']='distinct(a.cve_articulo), a.des_articulo, a.preart';
$a_strFields['articulo_rz']='distinct(a.cve_articulo), a.des_articulo, a.preart';
$a_strFields['paciente4']='p.cve_paciente,p.nombre ,p.app_pat, p.app_mat,p.fecha_nacimiento,p.poliza,s.sexo,s.cve_sexo ';
$a_strFields['cie4']=" ce.cvecie, ce.cvecied, ce.descied, concat(if(valcie11='yes',1,0),if(valcie12='yes',1,0),if(valcie13='yes',1,0),if(valcie14='yes',1,0),if(valcie15='yes',1,0),if(valcie16='yes',1,0),if(valcie17='yes',1,0),if(valcie18='yes',1,0),if(valcie19='yes',1,0),if(valcie20='yes',1,0),if(valcie11='yes',1,0),if(valcie12='yes',1,0),if(valcie13='yes',1,0),if(valcie14='yes',1,0),if(valcie15='yes',1,0),if(valcie16='yes',1,0),if(valcie17='yes',1,0),if(valcie18='yes',1,0),if(valcie19='yes',1,0),if(valcie20='yes',1,0)) as valcie ";	


$a_fieldsCond0=array();
$a_fieldsCond0['partida']=array('desPar');
$a_fieldsCond0['unidad']=array('des_uni');
$a_fieldsCond0['paciente']=array('nombre');
$a_fieldsCond0['paciente2']=array('nombre');
$a_fieldsCond0['paciente3']=array('nombre');
$a_fieldsCond0['cie']=array('descied');
$a_fieldsCond0['cie2']=array('descied');
$a_fieldsCond0['element']=array('des_medico');
$a_fieldsCond0['paciente_1']=array('nombre');
$a_fieldsCond0['cuota']=array('descripcion');
$a_fieldsCond0['articulo_r']=array('des_articulo','cve_receta');
$a_fieldsCond0['articulo_rx']=array('des_articulo','cve_recolectiva');
$a_fieldsCond0['articulo_ry']=array('des_articulo','cve_pastilleo');
$a_fieldsCond0['articulo_rz']=array('des_articulo','cve_recurgencias');
$a_fieldsCond0['articulo_rx1']=array('des_articulo','cve_recmaterial');
$a_fieldsCond0['articulo_rz1']=array('des_articulo','cve_recurgmaterial');
$a_fieldsCond0['paciente4']=array('nombre');
$a_fieldsCond0['cie4']=array('descied');


$a_fieldsCond1=array();
$a_fieldsCond1['partida']=array(array('p.cvePar','p.desPar'));
$a_fieldsCond1['unidad']=array(array('u.cve_uni','u.des_uni'));
$a_fieldsCond1['paciente']=array(array('p.cve_paciente','p.nombre'));
$a_fieldsCond1['paciente2']=array(array('p.cve_paciente','p.nombre'));
$a_fieldsCond1['paciente3']=array(array('p.cve_paciente','p.nombre'));
$a_fieldsCond1['cie']=array(array('ce.cvecied','ce.descied'));
$a_fieldsCond1['cie2']=array(array('ce.cvecied','ce.descied'));
$a_fieldsCond1['element']=array(array('r.des_medico'));
$a_fieldsCond1['paciente_1']=array(array('p.cve_paciente','p.nombre'));
$a_fieldsCond1['cuota']=array(array('p.noIdentificacion','p.descripcion'));
$a_fieldsCond1['articulo_r']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_receta');
$a_fieldsCond1['articulo_rx']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_recolectiva');
$a_fieldsCond1['articulo_ry']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_pastilleo');
$a_fieldsCond1['articulo_rz']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_recurgencias');
$a_fieldsCond1['articulo_rx1']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_recmaterial');
$a_fieldsCond1['articulo_rz1']=array(array('a.cve_articulo','a.des_articulo'),'r.cve_recurgmaterial');
$a_fieldsCond1['paciente4']=array(array('p.cve_paciente','p.nombre'));
$a_fieldsCond1['cie4']=array(array('ce.cvecied'));




$a_fieldsConTtype=array();
$a_fieldsConTtype['partida']=array('text', 'num');
$a_fieldsConTtype['unidad']=array('text');
$a_fieldsConTtype['paciente']=array('text');
$a_fieldsConTtype['paciente2']=array('text');
$a_fieldsConTtype['paciente3']=array('text');
$a_fieldsConTtype['cie']=array('text','text');
$a_fieldsConTtype['cie2']=array('text','text');
$a_fieldsConTtype['element']=array('text');
$a_fieldsConTtype['paciente_1']=array('text');
$a_fieldsConTtype['cuota']=array('text','text');
$a_fieldsConTtype['articulo_r']=array('text','text');
$a_fieldsConTtype['articulo_rx']=array('text','text');
$a_fieldsConTtype['articulo_ry']=array('text','text');
$a_fieldsConTtype['articulo_rz']=array('text','text');
$a_fieldsConTtype['articulo_rx1']=array('text','text');
$a_fieldsConTtype['articulo_rz1']=array('text','text');
$a_fieldsConTtype['paciente4']=array('text');
$a_fieldsConTtype['cie4']=array('text');





$a_condOper=array();
$a_condOper['partida']=array(array('like','like'));
$a_condOper['unidad']=array(array('like','like'));
$a_condOper['paciente']=array(array('like','like'));
$a_condOper['paciente2']=array(array('like','like'));
$a_condOper['paciente3']=array(array('like','like'));
$a_condOper['cie']=array(array('like','like'));
$a_condOper['cie2']=array(array('like','like'));
$a_condOper['element']=array(array('like'));
$a_condOper['paciente_1']=array(array('like','like'));
$a_condOper['cuota']=array(array('=','like'));
$a_condOper['articulo_r']=array(array('=','like'),'=');
$a_condOper['articulo_rx']=array(array('=','like'),'=');
$a_condOper['articulo_ry']=array(array('=','like'),'=');
$a_condOper['articulo_rz']=array(array('=','like'),'=');
$a_condOper['articulo_rx1']=array(array('=','like'),'=');
$a_condOper['articulo_rz1']=array(array('=','like'),'=');
$a_condOper['paciente4']=array(array('like','like'));
$a_condOper['cie4']=array(array('like','like'));





$a_Order=array();
$a_Order['partida']=array('desPar');
$a_Order['unidad']=array('des_uni');
$a_Order['paciente']=array('nombre');
$a_Order['paciente2']=array('nombre');
$a_Order['paciente3']=array('nombre');
$a_Order['cie']=array('descied');
$a_Order['cie2']=array('descied');
$a_Order['element']=array('r.des_medico');
$a_Order['paciente_1']=array('nombre');
$a_Order['cuota']=array('descripcion');
$a_Order['articulo_r']=array('a.des_articulo');
$a_Order['articulo_rx']=array('a.des_articulo');
$a_Order['articulo_ry']=array('a.des_articulo');
$a_Order['articulo_rz']=array('a.des_articulo');
$a_Order['articulo_rx1']=array('a.des_articulo');
$a_Order['articulo_rz1']=array('a.des_articulo');
$a_Order['paciente4']=array('nombre');
$a_Order['cie4']=array('descied');





$a_strWhere=array();
$a_strWhere['partida']="";
$a_strWhere['unidad']="";
$a_strWhere['paciente']=" p.cve_sexo=s.cve_sexo and p.cve_area=a.cve_area";
$a_strWhere['paciente2']=" p.cve_sexo=s.cve_sexo and p.cve_parentesco=r.cve_parentesco";
$a_strWhere['paciente3']="  p.cve_sexo=s.cve_sexo
 and p.cve_paciente=e.cve_paciente
 and e.cve_prefijo=j.cve_prefijo
 and e.cve_area=a.cve_area
 -- and a.cve_area=4";
$a_strWhere['cie']=" cie10=1";
$a_strWhere['cie2']=" cie9=1";
$a_strWhere['element']=" r.cveuni='".$_SESSION['cveunidad']."' and r.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and r.status=1 ";
$a_strWhere['paciente_1']=" p.cve_sexo=s.cve_sexo ";
if(isset($_POST['cveclasificacionCuotas']))
$a_strWhere['cuota']="p.cveclasificacionCuotas= ".$_POST['cveclasificacionCuotas'];													
$a_strWhere['articulo_r']=" a.cve_articulo = an.cve_articulo and r.fecha_elaboracion >= an.fec_alta and r.fecha_elaboracion <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_individual r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha_elaboracion BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_receta='".(addslashes($_POST['cve_receta']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";

/************************************************************************************************************************************************************/
$a_strWhere['articulo_rx']=" a.cve_suministro=1 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_colectiva r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recolectiva='".(addslashes($_POST['cve_recolectiva']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";	
/************************************************************************************************************************************************************/
$a_strWhere['articulo_ry']=" a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, pastilleo r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_pastilleo='".(addslashes($_POST['cve_pastilleo']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";	


$a_strWhere['articulo_rz']=" a.cve_suministro=1 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_urgencias r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recurgencias='".(addslashes($_POST['cve_recurgencias']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";																						

$a_strWhere['articulo_rx1']=" a.cve_suministro=2 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_mat_curacion r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recmaterial='".(addslashes($_POST['cve_recmaterial']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";	
							
							
							
$a_strWhere['articulo_rz1']=" a.cve_suministro=2 and a.cve_articulo = an.cve_articulo and r.fecha >= an.fec_alta and r.fecha <= an.fec_baja" .
							" and r.cveuni=u.cveuni and r.cve_jurisdiccion=u.cve_jurisdiccion".
							" and a.cve_articulo <> ALL (select distinct(anh.cve_articulo) from articulonivelnohabilitado anh, receta_urg_material r2, unidad u2 where ". 
							" u2.cveuni='".$_SESSION['cveunidad']."' and u2.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' ". 
							" and r2.cveuni=u2.cveuni and r2.cve_jurisdiccion=u2.cve_jurisdiccion and u2.cvenivel=anh.cve_nivel ".
							"and r2.fecha BETWEEN anh.fec_alta AND anh.fec_baja and r2.cve_recurgmaterial='".(addslashes($_POST['cve_recurgmaterial']) * 1)."') ".
							" and u.cveuni='".$_SESSION['cveunidad']."' and u.cve_jurisdiccion='".$_SESSION['cvejurisdiccion']."' and u.cvenivel=an.cve_nivel ";	
$a_strWhere['paciente4']=" p.cve_sexo=s.cve_sexo ";
$a_strWhere['cie4']="";
	


$a_strGroup=array();
$a_strGroup['partida']="";
$a_strGroup['unidad']="";
$a_strGroup['paciente']="";
$a_strGroup['paciente2']="";
$a_strGroup['paciente3']="";
$a_strGroup['cie']="";
$a_strGroup['cie2']="";
$a_strGroup['element']="";
$a_strGroup['paciente_1']="";
$a_strGroup['cuota']="";
$a_strGroup['articulo_r']="";
$a_strGroup['articulo_rx']="";
$a_strGroup['articulo_ry']="";
$a_strGroup['articulo_rz']="";
$a_strGroup['articulo_rx1']="";
$a_strGroup['articulo_rz1']="";
$a_strGroup['paciente4']="";
$a_strGroup['cie4']="";


//	
//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	
	$strWhere= $a_strWhere[$_POST['entvalue']];
    $classind = new Entidad($a_fields[$_POST['entvalue']],$a_fieldsValDef[$_POST['entvalue']]);
	foreach ($a_fieldsCond0[$_POST['entvalue']] as $cnt_afield => $afield){
		if (strlen($strWhere)>0){$strWhere.=" and ";}
		switch( $a_fieldsConTtype[$_POST['entvalue']][$cnt_afield]){
			case 'text':
				if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])){
					$strWhere.=" (";
					foreach($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1){
						if ($countCond1>0){$strWhere.=" or ";}
						if  ($a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1]=='like'){$strWhere.=" ".  $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." '%" .  addslashes($_POST[$afield]) . "%'";}
						else{$strWhere.=" ". $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." '" . addslashes($_POST[$afield]) . "'";}
						}
					$strWhere.=" )";
				}else{
					if  ($a_condOper[$_POST['entvalue']][$cnt_afield]=='like'){$strWhere.=" ".  $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '%" .  addslashes($_POST[$afield]) . "%'";}
					else{$strWhere.=" ". $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." '" . addslashes($_POST[$afield]) . "'";}
				}
			break;
			case 'num':
				if (is_array($a_fieldsCond1[$_POST['entvalue']][$cnt_afield])){
					$strWhere.=" (";
					foreach($a_fieldsCond1[$_POST['entvalue']][$cnt_afield] as $countCond1 => $itemCond1){
						if ($countCond1>0){$strWhere.=" or ";}
						$strWhere.=" ". $itemCond1 . " ". $a_condOper[$_POST['entvalue']][$cnt_afield][$countCond1] ." " .  addslashes($_POST[$afield]);
						}
					$strWhere.=" )";
				}else{
					$strWhere.=" ". $a_fieldsCond1[$_POST['entvalue']][$cnt_afield] . " ". $a_condOper[$_POST['entvalue']][$cnt_afield] ." " .  addslashes($_POST[$afield]);
				}			
			
				
			break;
		}
		
	}
	if (strlen($strWhere)>0) $strWhere = " Where " . $strWhere;
	$strWhere .= $a_strGroup[$_POST['entvalue']];
	//die($strWhere);
	
$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';

	$classind->ListaEntidades($a_Order[$_POST['entvalue']],$a_table[$_POST['entvalue']],$strWhere,$a_strFields[$_POST['entvalue']]);
//echo "<pre>";
//	print_r($classind);
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$a_fields[$_POST['entvalue']], FALSE);
		$xml .= '<elemento>';
		foreach ($a_fields[$_POST['entvalue']] as $cnt_field => $item_field){
				if ($cnt_field>0) {$xml .='@:::@';}
			$xml .= $item_field."@===@".str_replace(array("&",">","<"),array(" ","&gt;","&lt;"),$classind->$item_field);
		}
		$xml .= '</elemento>';
	}
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;		


} else{
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}
?>
