<?php 
	$intNW = 80;
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	
	$sel=0; //valor inicial del combo

	$entidad='Listado de Alumnos';
	$id_prin='cve_alumno';
	$strWhere=" Where ";

	
	$a_order=array();

			$tablas_c='alumnos_ingreso ';
			$a_order[]=$id_prin;



	$tabla='alumnos_ingreso ';
	$a_separs=array();
	$a_separs[]=array(1,'Pase de Lista',4,"separ_verde");
	$strDistintic="SELECT count(cve_alumno) as count_r FROM alumnos_ingreso";
	
	$field[]=array('cve_alumno','cve_alumno','1','label','1','','char','',100,100,0,'','',array(1,'col-12 col-sm-12','col-12 col-sm-6'));
	$field[]=array('nombre','Nombre','1','label','1','','char','',120,20,2,'','',array(1,'col-12 col-sm-12','col-12 col-sm-6'),2,'','clase');	
    $field[]=array('asistencia','Asistencia','1','check','1','','char',"",200,100,array(1,5),'',1,array(1,'col-12 col-md-12','col-12 col-md-3'),array(1,1,6));	
	$field[]=array('observaciones','Observaciones','1','text','1','','char',"",200,100,array(5,50),'','',array(1,'col-12 col-md-12','col-12 col-md-12'),array(1,1,6));	
	
	$setdel='';
	$keyFields=array('cve_alumno');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('cve_alumno');
	$keyFieldsUnique=array('cve_alumno');
	$keyTypeFieldsUnique=array('text');	//int,text
	$suma_width=0;
	$rwitem='null';
	//$strwentidad="entidad3.php";
	$boolNoEditable=FALSE;
//	$str_self="i_modulo";
	$strSelf="i_asistencia_light.php";

	$suma_width=0;
	$numcols=0;
	if (isset($intNW)){
			$suma_width+=$intNW;			
	$suma_width_aux+=$intNW;		}
	$a_vals=array();


////////////////////////

	$suma_width=0;
	$rwitem='null';
	//$cntnt_lst='content_lst2.php';
	//$strwentidad="entidad3.php";
	$boolNoEditable=FALSE;
//	$str_self="i_modulo";
//	$strSelf="i_hw_tipo.php";

	$suma_width=0;
	$numcols=0;
	foreach ($field as $afield){
		if ($afield[2]=='1' && !in_array($afield[0],$array_noprint_ent)){
			$suma_width+=$afield[8];
			$numcols+=1;
		}
	}
	$suma_width_aux=0;
	if (isset($a_print))
		foreach ($a_print as $aa_print){
			$suma_width+=$aa_print[3];
			$suma_width_aux+=$aa_print[3];
		}
	if (isset($intNW)){
			$suma_width+=$intNW;			
	$suma_width_aux+=$intNW;		}	
	$awidths=array('100','100','200');



function fnImplementInUpd(){
    //type:success or error|text show column|optional mensaje alert
                        //echo 'success'; 
                        //echo 'success|Realizado'; 
			echo 'success|Realizado|Se paso Asistencia'; 
                        //echo 'error|mensaje'
 }
?>