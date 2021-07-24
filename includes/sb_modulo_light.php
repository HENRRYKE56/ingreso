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
//	
//	$classconsul = new Entidad(array('id_estatus_periodo', 'estatus_periodo'), array(0, ''));
//	$classconsul->ListaEntidades(array('estatus_periodo'), 'cat_estatus_periodo', ' where id_estatus_periodo=2');
//	for ($i = 0; $i < $classconsul->NumReg; $i++) {
//		$classconsul->VerDatosEntidad($i, array('id_estatus_periodo', 'estatus_periodo'));
//		$tipo_val[] = $classconsul->id_estatus_periodo;
//		$tipo_des[] = $classconsul->estatus_periodo;
//	}
	
	$entidad='Modulos';
	$id_prin='cve_modulo';
	$strWhere="Where";
	$a_order=array();
//	switch ($_SESSION['cveperfil']){
//		case '507': 
//		$strWhere.=" cve_clas_activo=2";
//		
//		break;
//		}
			$tablas_c='sb_modulo';
			$a_order[]=$id_prin;
//			break;
//		case $_SESSION['cveperfil']<>1:
//			$strWhere.=" cve_usuario=".$_SESSION['cveusuario'];
//			$tablas_c='usuario';
//			$a_order[]=$id_prin;
//			break;
//	}
	if ($strWhere=="Where")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tabla='sb_modulo';
	$a_separs=array();
	$a_separs[]=array(1,'Estatus modulo',4,"separ_verde");
	$strDistintic="SELECT count(id_periodo) as count_r FROM periodo";
	$intlimit=20;
	$field[]=array('cve_modulo','Clave','1','text','1','','int',0,100,100,0,'',1,array(1,'col-12 col-sm-12','col-12 col-sm-12'));
	$field[]=array('sta_modulo','Estatus del modulo','1','select','1',array(array(0,1),array('Desactivar','Activar')),'int','',120,20,2,'',1,array(1,'col-12 col-sm-12','col-12 col-sm-12'),2,'','clase');	
    $field[]=array('obs','Descripcion de Modulo','1','textarea','1','','char',"",200,100,array(1,5),'',1,array(1,'col-12 col-md-12','col-12 col-md-12'),array(1,1,6));	
	
	$setdel='';
	$keyFields=array('cve_modulo');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('null');
	$keyFieldsUnique=array('cve_modulo');
	$keyTypeFieldsUnique=array('int');	//int,text
	$suma_width=0;
	$rwitem='null';
	//$strwentidad="entidad3.php";
	$boolNoEditable=FALSE;
//	$str_self="i_modulo";
	$strSelf="sb_modulo_light.php";

	$suma_width=0;
	$numcols=0;
	if (isset($intNW)){
			$suma_width+=$intNW;			
	$suma_width_aux+=$intNW;		}
	$a_vals=array();
	if (isset($_POST['numpar'])){  //numpar es el numero de la clave de cedula
		$a_numpar=explode('@:',$_POST['numpar']);//separa los nombres del areglo
		foreach($field as $cntField => $itemField){
			if (in_array($itemField[0],$keyFields)){
				$a_keys_numpar=explode('=',$a_numpar[array_search($itemField[0],$keyFields)]);
				$a_vals[]=$a_keys_numpar[1];
				$field[$cntField][7]=$a_keys_numpar[1];
			}
		}
	}
//        echo '<pre>';
//        print_r($field);die();

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
			echo 'success|Realizado|tu muy bien'; 
                        //echo 'error|mensaje'
 }
?>