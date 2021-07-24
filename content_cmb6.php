<?php
session_start();
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");

$StrMsgErrorAll=array();
$StrMsgErrorAll[]="NO se encontraron coincidencias ";

$a_vals=explode("::",trim($_POST['varval']));
//
/*echo "<pre>";
print_r($a_vals);
echo "</pre>";
die();*/
/**HORARIOS DE CADA CONSULTORIO*/
if ($a_vals[0]!=''){
		$pcWhere= " WHERE cve_consultorio=".$a_vals[2]." and cve_unidad='".$_SESSION['cveunidad']."'";
		$classconsultorio = new Entidad(array('inicio','fin',),array('',''));
		$classconsultorio->ListaEntidades(array('inicio'),'consultorios cons',$pcWhere);//order
		$classconsultorio->VerDatosEntidad(0,array('inicio','fin'));			
		$c_h_inicio=$classconsultorio->inicio;
		$c_h_fin=$classconsultorio->fin;
		
		$inicio=str_replace(':', '',$c_h_inicio);
		//	echo "aaa<br/>";
		$final=str_replace(':', '',$c_h_fin);
		
		
		$inicio = substr($inicio,0,4);		
		$final= substr($final,0,4);
		
		//$inicio1=substr($inicio,1,1);
		$inicio2=substr($inicio,0,2);		
		$final2=substr($final,0,2);
		$final3=$final2-01;//final de hora sin registro
		
		/*Horas y minutos el mismo dia*/
		
$fecha_max=date('Y-m-d');
$fecha_max2=date('Y-m-d H:i:s');
//hora
$hini2=substr($fecha_max2,11,2);
$hini22=0;
$hini22=$hini2;

//minuto
$mini2=substr($fecha_max2,14,2);
$mini22=0;

$mini22=$mini2;
//$mini22=41;
/*fin de horas y minutos el mismo dia*/

//echo $mini22;
//die();

if($hini22<$inicio2){
	$mini22=0;
	}
else if($mini22>0 && $mini22<19 ){
	$mini22=20;
	}
else if($mini22>19 && $mini22<39){
	$mini22=40;
	}
else if($mini22>40 && $mini22<59){
	$mini22=59;
	}
	
/*FIN DE HORRARIOS DE CADA CONSULTORIO*/

		//$pcWhere= " where fecha_cita=".'\''.$a_vals[0].'\' and cve_consultorio='.'\''.$a_vals[2].'\' and cve_servicio='.'\''.$a_vals[1].'\''.'\' and cve_unidad='.'\''.$_SESSION['cveunidad'].'\'';
		
			/**********REGISTRO EN TBL CITAS*************/
		
		$pcWhere= " WHERE fecha_cita ='".$a_vals[0]."'"." and cve_consultorio=".$a_vals[2]." and cve_servicio=".$a_vals[1]." and cve_unidad='".$_SESSION['cveunidad']."'";
		$classconsul0 = new Entidad(array('fecha_ini','fecha_cita',),array('',''));
		$classconsul0->ListaEntidades(array('fecha_ini'),'citas',$pcWhere);//order
		
		/***********************/		


if($fecha_max != $a_vals[0]){	//fecha no es actual *1
		/**********HORARIOS DISPONIBLES*************/
		
		$pcWhere= " WHERE fecha ='".$a_vals[0]."'"." and cve_consultorio=".$a_vals[2]." and cve_servicio=".$a_vals[1]." and cve_unidad='".$_SESSION['cveunidad']."'";
		$classconsul1 = new Entidad(array('fecha_ini','fecha',),array('',''));
		$classconsul1->ListaEntidades(array('fecha_ini'),'horarios',$pcWhere);//order
		
		
		
	
		/*******SI EXITEN REGISTROS PARA LA FECHA EN LA TABLA DE CITAS Y EN LA DE HORARIOS***********/
		
		if( $classconsul0->NumReg>0){//*2
				
				if( $classconsul1->NumReg>0){//*3
										
					for ($i=0; $i<$classconsul1->NumReg; $i++) {//*4
					$classconsul1->VerDatosEntidad($i,array('fecha_ini'));	
					$hora_val[]=substr($classconsul1->fecha_ini,10,18);
					$hora_des[]=substr($classconsul1->fecha_ini,10,18);		
					}//*4
		
				}//3
				else{
					/*no hay fechas*/
					$hora_val[0]='';
					$hora_des[0]='No dispoble';
					}
			}//2

		
		/**********SI NO EXISTEN REGISTROS PARA LAS TBLS DE HORARRIOS Y CITAS*************/	
		if( $classconsul0->NumReg==0){
			
			if( $classconsul1->NumReg==0){
			
					for ($h = $inicio2; $h <= $final3; $h++) {
							if($h<10){
								if($h!=$inicio2) $h2='0'.$h;						
									else $h2=$h;					
							}
							else {
								$h2=$h;
							}
							$mfin=59;
						for ($m = 0; $m <= $mfin; $m=$m+20) {	
							if($m<10){
							$m2='0'.$m;
							}
							else {
								$m2=$m;}
						
						$hora_val[]=$h2.":".$m2.":00";
						$hora_des[]=$h2.":".$m2;
						}
					}
			}
		}
//*1			
}else{//fecha es hoy
		$pcWhere= " WHERE fecha ='".$a_vals[0]."'"." and cve_consultorio=".$a_vals[2]." and cve_servicio=".$a_vals[1]." and cve_unidad='".$_SESSION['cveunidad']."' and fecha_ini > '".$fecha_max2."'";
		$classconsul1 = new Entidad(array('fecha_ini','fecha',),array('',''));
		$classconsul1->ListaEntidades(array('fecha_ini'),'horarios',$pcWhere);
		
		
		
			if( $classconsul0->NumReg>0){
					
					if( $classconsul1->NumReg>0){
						
					for ($i=0; $i<$classconsul1->NumReg; $i++) {
					$classconsul1->VerDatosEntidad($i,array('fecha_ini'));	
					$hora_val[]=substr($classconsul1->fecha_ini,10,18);
					$hora_des[]=substr($classconsul1->fecha_ini,10,18);		
					}
			
					}else{
						/*no hay fechas*/
						$hora_val[0]='';
						$hora_des[0]='No dispoble';
						}
			}
			
/*--------------------------------------------------*/
		/**********SI NO EXISTEN REGISTROS PARA LAS TBLS DE HORARRIOS Y CITAS*************/	
				if( $classconsul0->NumReg==0){
					
					if( $classconsul1->NumReg==0){
					if( $mini22 >40){
					$hini22=$hini22+1;
					$mini22=0;
					//echo $hini22;
					//echo $final3;
					//die();
					}
					$chi=0;
					if($hini22>$inicio2){//validar al tomar la hora incial del copnsultorio
						
						$chi=$chi+$hini22;
						}else{
							$chi=$chi+$inicio2;
							}
													for ($h = $chi; $h <= $final3; $h++) {
															if($h<10){
																
																if($h!=$hini22) $h2='0'.$h;						
																	else $h2=$h;					
															}
															else {
																$h2=$h;
															}
															$mfin=59;
														
														
														for ($m = $mini22; $m <= $mfin; $m=$m+20) {																
																if($m<10){
																$m2='0'.$m;									
																}
																else {
																	$m2=$m;
																	}
															
															$mini22=0;		
															$hora_val[]=$h2.":".$m2.":00";
															$hora_des[]=$h2.":".$m2;												
															
														}
														
														
													}
																if($hora_val == '' ){
																$hora_val=array(' ');
																$hora_des=array('No disponible');
																}
							
							//}else{
							//$hora_val=array(' ');
							//$hora_des=array('No disponible');
							//}
							
							
					}
				}
				
	
}

}else{
		$hora_val=array(' ');
		$hora_des=array('No disponible');
	}
$StrFisrst=array();
$StrFisrst[]=" - Hora - ";
			$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
			$xml .= '<datos>';
			$xml .= '<elemento value="">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
			foreach($hora_val as $i=>$hora){
				$xml .= '<elemento value="'.$hora.'">'.$hora_des[$i].'</elemento>';
				
				
			}
			$xml .= '</datos>';
			header('Content-type: text/xml');
			echo $xml;	
			
			//echo"<pre>";
			//print_r($hora_val);
			//print_r($hora_des);
			//echo"</pre>";

//$initial_value='0';
////echo "<pre>";
////print_r($_SESSION);
////echo "</pre>";
//if (isset($_POST['numAdd']) && in_array($_POST['numAdd'],array(0,1,2,3,4,5,6,7))){
//if (isset($_POST['initialize']) and $_POST['initialize']==0){
////$classconsul = new Entidad(array($ArrStrCve[$_POST['numAdd']],$ArrStrDes[$_POST['numAdd']]),array('',''));
//$classconsul = new Entidad($ArrFields[$_POST['numAdd']],$ArrDefValues[$_POST['numAdd']]);
//$consulWhere='';
//$strlimit="";
//$a_vals=explode("::",trim($_POST['varval']));
//########//recuerda que debes incluir los numeros adicionales###################
//foreach ($fieldCond[$_POST['numAdd']] as $cont_val=> $item_name ){
//	if ($typeFieldCond[$_POST['numAdd']][$cont_val]=='num'){
//		$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name. " = ".trim($a_vals[$cont_val]);}
//	else{
//		$consulWhere.= (strlen($consulWhere)>0?' and ':'') . " " . $item_name. " = '".trim($a_vals[$cont_val])."'";}
//	
//}
//$consulWhere=" where ". $consulWhere . $StrWhereCond[$_POST['numAdd']];
////echo $consulWhere;
//	$classconsul->ListaEntidades($ArrStrOrd[$_POST['numAdd']],$tablename[$_POST['numAdd']],$consulWhere,'','',$strlimit);
////echo "<pre>";
////print_r($classconsul->ListaEntidades);
////echo "</pre>";
//
////die();
//
/*//$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
//
//$xml .= '<datos>\n';
//if(strlen($StrFisrst[$_POST['numAdd']])>0)
//$xml .= '<elemento value="-1">'.$StrFisrst[$_POST['numAdd']].'</elemento>';
////$xml .= "<datos>\n";
//	for ($i=0; $i<$classconsul->NumReg; $i++) {
//		$classconsul->VerDatosEntidad($i,$ArrFields[$_POST['numAdd']]);
//		$varname1 = $ArrStrCve[$_POST['numAdd']];
//		//$varname2 = $ArrStrDes[$_POST['numAdd']];
//		$xml .= '<elemento value="'.$classconsul->$varname1.'">';
//		if (is_array($ArrStrDes[$_POST['numAdd']])){
//			foreach($ArrStrDes[$_POST['numAdd']] as $cntDes => $itemDes){
//				if ($cntDes > 0) $xml .= " ";
//				$xml .= $classconsul->$itemDes;
//			}
//		}else{$varname2 = $ArrStrDes[$_POST['numAdd']]; $xml .= $classconsul->$varname2;}
//		$xml .= '</elemento>';
//	}
//
//$xml .= "</datos>";
//header('Content-type: text/xml');
//echo $xml;		
//
//}
//
//
//}
*/
?>

