<?php 

include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'>";
$StrAdd=array();
$StrStyle=array();
$arrNames=array();
$arrNames[]=array('cve','');
$StrAdd[]='';
$StrStyle[]='style="color:#669900;"';
$array_val=array();
$array_des=array();
$initial_value='0';

$consulWhere='';
$strlimit="";

//print_r($_POST['numpar']);
//die();

if (trim($_POST['numpar']) && in_array($_POST['numpar'],array('2','4','6','8'))){
	switch (trim($_POST['numpar'])){
		case '2':
			switch (trim($_POST['varval'])){
				
				
				
				case 'cve_medico': 
					$_POST['entvalue']='medico';
				break;
				case 'cveCentro': 
					$_POST['entvalue']='centro';
				break;
				case 'idPuesto': 
					$_POST['entvalue']='puesto';
				break;
				case 'cveRama': 
					$_POST['entvalue']='rama';
				break;
				case 'cveSeccion': 
					$_POST['entvalue']='seccion';
				break;
				case 'cveCaracter':
					$_POST['entvalue']='caracter';
				break;
				case 'pieRama':
					$_POST['entvalue']='pierama';
				break;
				case 'cve_fuente':
					
					$_POST['entvalue']='Fuente';
					//echo "entro";
				break;
				default:
					echo genInput('text','txtsearch','','','30','50','txtbox','','','0','Valor','','','');
					exit(0);
				break;
			}
			break;
	}
	
	if(trim($_POST['varval'])=='cveJurisdiccion'){		
			$classconsul = new Entidad(array('cveEstatal','desJurisdiccion'),array('',''));
			$varname1='cveEstatal';
				$varname2='desJurisdiccion';
			$classconsul->ListaEntidades(array('cveJurisdiccion'),trim($_POST['entvalue']),$consulWhere,'','',$strlimit);
			
			for ($i=0; $i<$classconsul->NumReg; $i++) {
				$classconsul->VerDatosEntidad($i,array('cveEstatal','desJurisdiccion'));		
				$array_val[]=$classconsul->$varname1;
				$array_des[]=$classconsul->$varname2;// .' - ' . $classconsul->$varname1;
			}

		
		}else{

			if(trim($_POST['varval'])=='cveJurReg'){		
				$classconsul = new Entidad(array('cveJurReg','desJurReg'),array('',''));
				$varname1='cveJurReg';
					$varname2='desJurReg';
				$classconsul->ListaEntidades(array('desJurReg'),trim($_POST['entvalue']),$consulWhere,'','',$strlimit);
				
				for ($i=0; $i<$classconsul->NumReg; $i++) {
					$classconsul->VerDatosEntidad($i,array('cveJurReg','desJurReg'));		
					$array_val[]=$classconsul->$varname1;
					$array_des[]=$classconsul->$varname2;// .' - ' . $classconsul->$varname1;
				}
			
			}
			
			
			if(trim($_POST['varval'])=='cve_fuente'){		
				$classconsul = new Entidad(array('cve_fuente','des_fuente'),array('',''));
				$varname1='cve_fuente';
					$varname2='des_fuente';
				$classconsul->ListaEntidades(array('des_fuente'),trim($_POST['entvalue']),$consulWhere,'','',$strlimit);
				
				for ($i=0; $i<$classconsul->NumReg; $i++) {
					$classconsul->VerDatosEntidad($i,array('cve_fuente','des_fuente'));		
					$array_val[]=$classconsul->$varname1;
					$array_des[]=$classconsul->$varname2;// .' - ' . $classconsul->$varname1;
				}
			
			}
			
			if(trim($_POST['varval'])=='cveCentro'){		
				$classconsul = new Entidad(array('cveCentro','centro_resp'),array('',''));
				$varname1='cveCentro';
					$varname2='centro_resp';
				$classconsul->ListaEntidades(array('centro_resp'),trim($_POST['entvalue']),$consulWhere,'','',$strlimit);
				
				for ($i=0; $i<$classconsul->NumReg; $i++) {
					$classconsul->VerDatosEntidad($i,array('cveCentro','centro_resp'));		
					$array_val[]=$classconsul->$varname1;
					$array_des[]=$classconsul->$varname2;// .' - ' . $classconsul->$varname1;
				}
			
			}
			
				
			else{
			if(trim($_POST['varval'])=='pieRama'){
					$array_val=array(0,1);
					$array_des=array('No','Si');
					$numRegistros=2;
				}else{
					
					if(trim($_POST['varval'])=='idPuesto'){
						$classconsul = new Entidad(array('cvePuesto','desPuesto','idPuesto'),array('','',0));						
						$classconsul->ListaEntidades(array('desPuesto'),'puesto','','','',$strlimit);
						
						for ($i=0; $i<$classconsul->NumReg; $i++) {
							$classconsul->VerDatosEntidad($i,array('cvePuesto','desPuesto','idPuesto'));		
							$array_des[]=$classconsul->cvePuesto ." ".$classconsul->desPuesto ;
							$array_val[]=$classconsul->idPuesto;// .' - ' . $classconsul->$varname1;
						}
				}else{

			$classconsul = new Entidad(array('cve_'.trim($_POST['entvalue']),'des_'.trim($_POST['entvalue'])),array('',''));
			//echo "<pre>";
			//print_r($_classconsul);
			//echo "</pre>";
				$classconsul->ListaEntidades(array('des_'.trim($_POST['entvalue'])),trim($_POST['entvalue']),$consulWhere,'','',$strlimit);
				for ($i=0; $i<$classconsul->NumReg; $i++) {
					$classconsul->VerDatosEntidad($i,array('cve_'.trim($_POST['entvalue']),'des_'.trim($_POST['entvalue'])));
					$varname1='cve_'.trim($_POST['entvalue']);
					$varname2='des_'.trim($_POST['entvalue']);
					$array_val[]=$classconsul->$varname1;
					$array_des[]=$classconsul->$varname2;// .' - ' . $classconsul->$varname1;
				}
				}
			}
			}
		}
////	
////	echo "<pre>";
////	print_r($array_des);
////	echo "</pre>";
//
$registros=0;
if(isset($classconsul->NumReg)){
	$registros=$classconsul->NumReg;
	}else{
		$registros=$numRegistros;
		}

	echo genSelect(trim($_POST['objname']),'','',$array_val,$array_des,$initial_value,'','',$StrAdd[$_POST['numAdd']],$StrStyle[$_POST['numAdd']],($registros)-1);
	//echo genSelect(trim($_POST['objname']),'','',$array_val,$array_des,$initial_value,'','',$StrAdd[$_POST['numAdd']],
	//(trim($_POST['numpar'])==8 or $boolStyle)?$StrStyle[$_POST['numAdd']]:'',(trim($_POST['numpar'])==8 or $boolStyle)?($classconsul->NumReg)-1:'');
	
//	echo "<pre>";
//	print_r($classconsul);
//	echo "</pre>";

}
?>