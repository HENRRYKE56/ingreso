<?php
/*-------------------------------------------------------
  -------------------------------------------------------
  -------------------------------------------------------
*/
if (!isset($_SESSION['nomusuario'])){
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}else{

include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
include_once("rep/lib/lib32.php");
if (function_exists('fnValidateFiatRegistroMD')){
	fnValidateFiatRegistroMD();
}

$afields=array();
$widthEditable=40;
if (!isset($boolNoUpdate))
	$boolNoUpdate=false;
if (!isset($boolNoNew))
	$boolNoNew=false;
if (!isset($boolNoDelete))
	$boolNoDelete=false;
if ($boolNoEditable || ($a_key[1]<>'100' && $a_key[2]<>'100') || ($boolNoUpdate && $boolNoDelete)){
	$widthEditable=0;
}else{
	if ($a_key[1]<>'100' || $a_key[2]<>'100' || $boolNoUpdate || $boolNoDelete)
		$widthEditable=20;
}
$widthEditableIni=$widthEditable;
$classent = new Entidad($allfields,$allvalues);
foreach ($field as $afield)
	if ($afield[2]=='1' || $afield[2]=='2')
		$afields[]=$afield[0];
$classent->ListaEntidades($a_order,$tablas_c,$strWhere,(isset($items0)?$items0:''),'','',"",(isset($tipo_order)?$tipo_order:''));
$str_closeform="";
$b_printline=0;
foreach ($a_key as $num_perm => $accion){
	if (trim($accion)=='100' and $num_perm > 0) {
		$b_printline=1;
		$str_closeform="</form>";
	}
}

//echo "<pre>";
//print_r($classent);
//echo "</pre>";

echo genOTable('0',$suma_width+$widthEditable,'','','',1,0,'top');

/* < --- Inicia mensaje de error --- >*/

if (isset($_SESSION['msg']) && strlen($_SESSION['msg'])>1){
	echo genORen();
	echo genOCol('100');
		$str_msg_red="";
		$i_intstyle=19;
		$i_intcolor=6;
		for ($i=0; $i<(strlen($_SESSION['msg'])/3);$i++){
			if (strlen($str_msg_red)>0)
				$str_msg_red.=',&nbsp;&nbsp;';
			$str_msg_red.=$CFG_MSG[(substr($_SESSION['msg'],$i*3,3)*1)];
		}
		$_SESSION['msg']='0';
		include("includes/i_msg_red.php");
	echo genCCol();
	echo genCRen();
}
/* < --- Termina mensaje de error --- >*/



/* < --- Inicia mensaje de error --- >*/

if (isset($_SESSION['msg']) && strlen($_SESSION['msg'])>1){
	echo genORen();
	echo genOCol('100');
		$str_msg_red="";
		$i_intstyle=19;
		$i_intcolor=6;
		for ($i=0; $i<(strlen($_SESSION['msg'])/3);$i++){
			if (strlen($str_msg_red)>0)
				$str_msg_red.=',&nbsp;&nbsp;';
			$str_msg_red.=$CFG_MSG[(substr($_SESSION['msg'],$i*3,3)*1)];
		}
		$_SESSION['msg']='0';
		include("includes/i_msg_red.php");
	echo genCCol();
	echo genCRen();
}
/* < --- Termina mensaje de error --- >*/
/*Linea de titulo de cabecera*/
echo genORen();
echo genOCol('','','','',$suma_width+$widthEditable);
echo genOTable('0',$suma_width+$widthEditable,'','',$CFG_BGC[1],'0','0');
echo genORen();

echo genCol("<img border='0' src='img/latizq.jpg'>",'','','',$CFG_BGC[0],'10','',$CFG_LBL[31]);
echo genCol("<span style='background-color: #5F6556;'>&nbsp;".$entidad."&nbsp;</span>",'','','',$CFG_BGC[0],450,'',$CFG_LBL[8],'','valign="bottom" background="img/bg03.jpg"');
echo genCol("<img border='0' src='img/latder.jpg'>",'','','',$CFG_BGC[1],'10','',$CFG_LBL[31]);
echo genCol("&nbsp;".(function_exists('fnSetRowColors')?fnSetRowColors():''),'','','',$CFG_BGC[1],$suma_width+$widthEditable-250,'',$CFG_LBL[31],'','background="img/bg04.jpg"');
echo genCol("<img border='0' src='img/supder.jpg'>",'','','',$CFG_BGC[1],'','',$CFG_LBL[31]);
echo genCRen();
echo genCTable().genCCol().genCRen();
		foreach ($_SESSION['niveles'] as $cont => $item){
			//echo $item."|".$strSelf."|".$cont; //die();
			if ($cont >0 ){ 
					$strfields_prin2="";//cambiar los arreglos de session 
					
//	echo $cont."<pre>";	
//	print_r($_SESSION['mdTFields']);
//	echo "</pre>";	
					foreach ($_SESSION['mdFields'][$cont] as $cont2 => $afield){
						if (strlen($strfields_prin2)>0)
							$strfields_prin2.=", ";
						$strfields_prin2.=$afield;
						if ($_SESSION['mdTFields'][$cont][$cont2]=='num'){
							$avalues_prin2[]=0;
						}else{
							$avalues_prin2[]='';
						}
						
					}
					$strWherePrin2="";
					foreach ($_SESSION['mdKeyFields'][$cont] as $cont2 => $afield){
						if (strlen($strWherePrin2)>0)
							$strWherePrin2.=" and ";
						if ($_SESSION['mdKeyTFields'][$cont][$cont2]=='num'){
							$strWherePrin2.=$afield . "=". $_SESSION['mdValFields'][$cont][$cont2];
						}else{
							$strWherePrin2.=$afield . "='". $_SESSION['mdValFields'][$cont][$cont2]."'";
						}
					}
					$strWherePrin2='Where '. $strWherePrin2;
					$classconsul = new Entidad($_SESSION['mdFields'][$cont],$avalues_prin2);
					$classconsul->ListaEntidades(array(),$_SESSION['mdTable'][$cont],$strWherePrin2,$strfields_prin2,"no");
					$classconsul->VerDatosEntidad(0,$_SESSION['mdFields'][$cont]);
					echo genORen();
					echo genOCol('','','','',$suma_width+$widthEditable);
					echo genOTable('0',$suma_width+$widthEditable,'','',$CFG_BGC[6],'1','0');
					echo genORen();//.str_repeat('&nbsp;',(isset($a_mdLabel)?4:2))
					$strvalcol=(str_repeat('&nbsp;',($cont*2))).'+'.(isset($a_mdLabel)?str_repeat('&nbsp;',2).$a_mdLabel[$cont-1].'&nbsp;':'')
								."<br>".str_repeat('&nbsp;',($cont*2)).str_repeat('&nbsp;',4);//
					foreach ($_SESSION['mdFields'][$cont] as $cont2 => $afield){
						if ($cont2>0)
							$strvalcol.= " * ";//<br>
							
							$str_value_field=($_SESSION['mdTFields'][$cont][$cont2]=='money')?number_format((($classconsul->$afield)*1), 0):$classconsul->$afield;
							if (strlen($classconsul->$afield)>16){$strvalcol.="<span style='text-align:left;width:700;background-color:#F8F9D9; border:1px #A9C472 solid;'>".$str_value_field."</span>";}
						else{$strvalcol.="<span ".(in_array($afield,$keyFields)?("class=\"" . $CFG_LBL[28] . "\" style=\"width:120;border:1px #A9C472 solid; background-color:".$CFG_BGC[21].";\""):"style=\"width:120;border:1px #A9C472 solid; background-color:#F8F9D9;\"")."'>".$str_value_field."</span>";}
					}
					if (isset($astr_MDIcon) and (sizeof($astr_MDIcon)>0))$strvalcol.=$astr_MDIcon[$cont];
					echo genCol($strvalcol,'2','','',$CFG_BGC[11],'','',$CFG_LBL[25]);
					echo genCRen();
					echo genCTable().genCCol().genCRen();
					//
				/*termina primer renglon en blanco*/
			}
			if ($item==$strSelf)
				break;
		}

/*termina renglon master*/

if (trim($a_key[0])=='100' && !$boolNoEditable && !$boolNoNew){
	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0',$suma_width+$widthEditable,'','',$CFG_BGC[6],'0','0');
	echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
	echo genORen();
	echo genCol(genOTable('0','44','','',$CFG_BGC[6],'0','1','left').genORen()
			.genOCol('','center','',$CFG_BGC[1],'40','',$CFG_LBL[14],'',"valign='middle' onMouseOver=\"this.style.backgroundColor='".
						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			
		 genInput('hidden','op','1').
		 genInput('hidden','nivPo',(isset($_SESSION['niv']) && strlen($_SESSION['niv'])>0)?$_SESSION['niv']:'0').
		  genInput('hidden','btnAddDetalle','btnAddDetalle').
		 "<input type=\"image\" alt=\"Actualizar Registro\"  src=\"img/editar.gif\" border='0'> \n".
		 genCCol().
		 genCRen().genCTable(),'','','',$CFG_BGC[10],'','',$CFG_LBL[14]);
	echo genCRen();
	echo "</form>";
	echo genCTable().genCCol().genCRen();
}

	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0',$suma_width+$widthEditable,'','',$CFG_BGC[10],'2','1');
	/*titulos de entidad*/
	echo genORen('','','','',$CFG_BGC[1]);
	foreach ($field as $afield)
			if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
				echo genCol(isset($afield[17])?$afield[17]:$afield[1],'','','',(isset($afield[20]) && strlen($afield[20])>0)?$afield[20]:'',
								$afield[8],'',$CFG_LBL[28],'',(isset($afield[29]) && strlen($afield[29])>0)?$afield[29]:'background="img/bg02.jpg"');
		echo genCRen();	
	/*terminan titulos*/
	
$tmp_boolNoUpdate=$boolNoUpdate;
$tmp_boolNoDelete=$boolNoDelete;
$tmp_widthEditable=$widthEditable;
for ($i=0; $i<$classent->NumReg; $i++) {
	$boolNoUpdate=$tmp_boolNoUpdate;
	$boolNoDelete=$tmp_boolNoDelete;
	$widthEditable=$tmp_widthEditable;
	$classent->VerDatosEntidad($i,$afields);
	$boolSetColor=false;
	$strSetColor="";

	if (function_exists('fnSetRowColor')){
		fnSetRowColor($classent);
	}
//		echo "<pre>";
//		print_r($classent);
//		echo "</pre>";   
	$str_onclick="";
	$str_href="";

	
// --- COMIENZA RENGLON
	if ($boolSetColor){
		$strColorRow1=$strSetColor;
		$strColorRow2=$strSetColor;
	}else{
		$strColorRow1=$CFG_BGC[27];
		$strColorRow2=$CFG_BGC[6];
	}
	if (function_exists('addRowSepar')){
		addRowSepar($classent);
	}
	
	echo genORen('','','','',($i%2)?$strColorRow1:$strColorRow2,"id=\"row_".$i."\" onClick=\"A(this,
					".$i.",'".$CFG_BGC[7]."','".$strColorRow2."','".$strColorRow1."','".$CFG_STRRGB[1]."');\" onMouseOver=\"B(this,
					".$i.",'".$CFG_BGC[7]."','".$CFG_BGC[25]."','".$CFG_STRRGB[1]."'); "."\" onMouseOut=\"C(this,
					".$i.",'".$CFG_BGC[7]."','".$strColorRow2."','".$strColorRow1."','".$CFG_STRRGB[1]."');\"");
	

////--   termina columna de botones de edicion
//

/*fin de col de botones*/
	foreach ($field as $count_fields => $afield){
		if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1'){
			$style=$CFG_LBL[30];
			switch ($afield[3]){
				case 'select':
					$cont=0;
					$intFound=true;
					foreach ($afield[5][0] as $isel){
						if ($isel==$classent->$afield[0]){
							echo genCol($afield[5][1][$cont],'','','','',$afield[8],'',$CFG_LBL[30]);
							$intFound=false;
						}
						$cont+=1;
					}
					if ($intFound){echo genCol('&nbsp;','','','','',$afield[8],'',$CFG_LBL[30]);}
				break;
				case 'check':
						echo genCol(genInput('checkbox',$afield[0],'','','','','','DISABLED',($classent->$afield[0]>0?'checked':''),'5')
						,'','','','',$afield[8],'',$style);
				break;
				case 'file':
						$strlnk_getfile="";
						if (isset($file_get) and strlen(trim($file_get))>0 and ($classent->$afield[0]<>"")){
							$strlnk_getfile="<a href='files/getfile.php?".$strGetValues."&file_get=".$file_get."' target='_blank'>" . $classent->$afield[0] . "</a>";
						}else{$strlnk_getfile=($classent->$afield[0]<>""?$classent->$afield[0]:'');}
						echo genCol(($strlnk_getfile<>""?$strlnk_getfile:''),'','','','',$afield[8],'',$style);
				break;
				default:
					if (isset($afield[18]) && $afield[18]==1){
						$str_implodevalues="";
						echo genOCol('','','','',$afield[8],'',$CFG_LBL[30]);
							foreach ($afield[19][0] as $count_int_aafield => $int_aafield){ 
								if ($count_int_aafield>0)
									$str_implodevalues.=$afield[19][1];
								$str_implodevalues.=$classent->$field[$int_aafield][0];
							}
							echo $str_implodevalues;
						echo genCCol();
					} else {
					
						//$strFieldValue=$classent->$afield[0];
						$strFieldValue=str_replace("\n","<br/>",$classent->$afield[0]);
						if (isset($afield[23]) and strlen(trim($afield[23]))>0){eval("\$strFieldValue=".$afield[23].'('.$classent->$afield[0].');');}
//						if (strlen($strFieldValue)>70){
//							$strFieldValue=substr($strFieldValue,0,60).
//							"&nbsp;&nbsp;<a href=\"javascript:ver('id_col".$afield[0]."_div".$i."')\" style=\"font-size:10px;text-decoration:none;\" >[+/-]</a>".
//							formatDiv('id_col'.$afield[0].'_div'.$i,str_replace("\n","<br/>",$strFieldValue),$afield[1],$i,"div11px");
//						}
						echo genCol($strFieldValue,'','','',(isset($afield[21]) && strlen($afield[21])>0)?$afield[21]:'',$afield[8],'',
							(isset($afield[22]) && strlen($afield[22])>0)?
								$afield[22]:(($afield[6]=='money' or $afield[6]=='int')?
									$CFG_LBL[45]:(($afield[6]=='date' or $afield[6]=='email')?
										$CFG_LBL[41]:$CFG_LBL[30])));
					}
				break;
				}

		}
		
	}
	echo genCRen()." \n";
}
echo genCTable().genCCol().genCRen();
	//
	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditableIni);
	echo genOTable('0',$suma_width+$widthEditableIni,'','',$CFG_BGC[1],'0','0');
	echo genORen();
	echo genCol("<img height='10' width='20' border='0' src='img/infizq.jpg'>",'','','',$CFG_BGC[3],'20','10',$CFG_LBL[2]);
	echo genCol('','','','',$CFG_BGC[1],"".($suma_width+100-40)."",'20',$CFG_LBL[2]);
	echo genCol("<img height='10' width='20' border='0' src='img/infder.jpg'>",'','','',$CFG_BGC[3],'20','10',$CFG_LBL[2]);
	echo genCRen();
	echo genCTable().genCCol().genCRen();
echo genCTable();
}
function formatDiv($target,$data,$label,$idrow,$classDiv){
return "<div id=\"" . $target . "\" class=\"".$classDiv."\"><div style='font-weight:bold;font-variant:small-caps'>".$label.":</div>".$data."</div>";
}

?>
<script language="JavaScript">
var visto = null;
function ver(objname) {
  obj = document.getElementById(objname);
  obj.style.display = (obj==visto) ? 'none' : 'block';
  if (visto != null)
    visto.style.display = 'none';
  visto = (obj==visto) ? null : obj;
}

</script>