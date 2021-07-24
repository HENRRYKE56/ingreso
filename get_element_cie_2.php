<?php 

/*print_r($_POST);
die("aqui");*/
session_start();
$str_check = FALSE;
include_once("includes/sb_check.php");
if ($str_check) {
    include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");
    include_once("lib/lib_function.php");
    include_once("rep/lib/lib32.php");





//die();
$a_table=array();
$a_table['cie1000']=" rangos_edad d
JOIN cat_diagnosticos ce ON d.LINF=ce.LINF AND d.LSUP=ce.LSUP";



$a_fields=array();
$a_fields['cie1000']=array('cve_cie10','descie10');	

	


$a_fieldsValDef=array();
$a_fieldsValDef['cie1000']=array('','');



$a_strFields=array();
$a_strFields['cie1000']="ce.cve_cie10,ce.descie10";	


$a_fieldsCond0=array();
$a_fieldsCond0['cie1000']=array('descie10');


$a_fieldsCond1=array();
$a_fieldsCond1['cie1000']=array(array('ce.cve_cie10','ce.descie10'));




$a_fieldsConTtype=array();
$a_fieldsConTtype['cie1000']=array('text','text');



$a_condOper=array();
$a_condOper['cie1000']=array(array('like','like'));



$a_Order=array();
$a_Order['cie1000']=array('ce.descie10');



$a_strWhere=array();	
$a_strWhere['cie1000']= str_replace("\'\'","''",$_POST['queryc']." and LENGTH(ce.cve_cie10)=4 and ce.estomatologia=1");


$a_strGroup=array();
$a_strGroup['cie1000']=" ";



//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
	
	/*echo "<pre>";	
	print_r($_POST);
	echo "</pre>";	*/
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
        if($_POST['entvalue']=="cie100ee"){
			
			
		/*	print_r($_POST['queryc']);
		 die();*/
            $arrayquery=explode("=", $_POST['queryc']);
			
		
			
		if($_POST['queryc']=='`>=60H`=YES' || $_POST['queryc']=='`>=60M`=YES'){    
        
		
		  		$arrayquery=explode("=", $_POST['queryc']);
		
         
         		$strWhere .=" and ce.".$arrayquery[0]."=".$arrayquery[1]." = '".$arrayquery[2]."'";
         
        }else{
			
 				$arrayquery=explode("=", $_POST['queryc']);
         
        		 $strWhere .=" and ce.".$arrayquery[0]." = '".$arrayquery[1]."'";

			
			}
		}
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
        if($_POST['entvalue']=="cie100eeee"){
        if($classind->NumReg==0){
            $arrayq=explode("=", $_POST['queryc']);
            $anios="";
            $arrayq[0]=str_replace("`", '', $arrayq[0]);
            for($i=0;$i<strlen($arrayq[0])-1;$i++){
                $anios.=$arrayq[0][$i];
            }
            $sexo=$arrayq[0][strlen($arrayq[0])-1];
            $sexo=$sexo!='M'?' Masculino':' Femenino';
            
            $anios=str_replace("<", ' menor que ', $anios);
            $anios=str_replace(">=", ' mayor o igual ', $anios);
            
            $xml .= '<elemento>campo_dato||@===@no hay datos para el paciente que esta en el rango "'.$anios.'" año (s) con genero '.$sexo;
            $xml .= '</elemento>';
        }
        }
 $xml .= '<elemento>campo_dato||@===@no hay datos para el paciente que esta en el rango "'.$anios.'" año (s) con genero '.$sexo;
            $xml .= '</elemento>';
       // print_r($classind);
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;		


} else{
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}
?>
