<?php

/*-------------------------------------------------------
  -------------------------------------------------------
  -------------------------------------------------------
*/

if ($__SESSION->getValueSession('nomusuario') == ""){
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}else{

include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
//include_once("rep/lib/lib32.php");
if (function_exists('fnValidateFiatRegistroMD')){
	fnValidateFiatRegistroMD();
}
$classent = new Entidad($allfields,$allvalues);
foreach ($field as $afield)
	if ($afield[2]=='1' || $afield[2]=='2')
		$afields[]=$afield[0];
$classent->ListaEntidades($a_order,$tablas_c,$strWhere,(isset($items0)?$items0:''),'','',"",(isset($tipo_order)?$tipo_order:''));

$lbl_tit_mov="&nbsp; [ edicion ]";
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

$str_closeform="";
$b_printline=0;
foreach ($a_key as $num_perm => $accion){
	if (trim($accion)=='100' and $num_perm > 0) {
		$b_printline=1;
		$str_closeform="</form>";
	}
}

$lis = "";

if (isset($_SESSION['msg']) && strlen($_SESSION['msg'])>1){

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
	
}
/* < --- Termina mensaje de error --- >*/



/* < --- Inicia mensaje de error --- >*/
if (strlen($__SESSION->getValueSession('msg'))>1){

		$str_msg_red="";
		$i_intstyle=19;
		$i_intcolor=6;
		for ($i=0; $i<(strlen($__SESSION->getValueSession('msg'))/3);$i++){
			if (strlen($str_msg_red)>0)
				$str_msg_red.=',&nbsp;&nbsp;';
			$str_msg_red.=$CFG_MSG[(substr($__SESSION->getValueSession('msg'),$i*3,3)*1)];
		}
		$__SESSION->SetValueSession('msg',0);
		include("includes/sb_msg_bob.php");
	
}
/* < --- Termina mensaje de error --- >*/
/*Linea de titulo de cabecera*/
if (isset($niveles_s) || isset($niveles_a)) {
	$icono = "";
	for ($index = 0; $index < count($niveles_a); $index++) {
		if ($index == 0) {
			$icono = '<i class="fa fa-home" style="font-size:1.3em;color:#7fffd4;"></i>&nbsp;';
		} else {
			$icono = '';
		}
		$lis.= '<li class="breadcrumb-item"><a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' style="color:#f5f5dc;" data-toggle="tooltip" title="' . $niveles_a[$index] . '">' . $icono . $niveles_s[$index] . '</a></li>';
		//  $lis.= '<a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' class="tip-bottom text-secondary" data-toggle="tooltip" title="' . $niveles_a[$index] . '" style="font-size:17px;text-decoration: none;">&nbsp;' . $icono . $niveles_s[$index] . '</a>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i>';
	}
}

/*termina linea de titulo de cabecera*/
/*inicia  renglon de master*/


		foreach ($__SESSION->getValueSession('niveles') as $cont => $item){
			if ($cont >0 ){ 
				/*primer renglon en blanco*/
								
	
//	print_r(getValueSession('mdTFields'));
//	echo "</pre>";	
					foreach ($__SESSION->getValueSession('mdFields')[$cont] as $cont2 => $afield){
						if (strlen($strfields_prin2)>0)
							$strfields_prin2.=", ";
						$strfields_prin2.=$afield;
						if ($__SESSION->getValueSession('mdFields')[$cont][$cont2]=='num'){
							$avalues_prin2[]=0;
						}else{
							$avalues_prin2[]='';
						}
						
					}
//$strfields_prin2="";//cambiar los arreglos de session 
$strvalcol="";
					$strWherePrin2="";
					foreach ($__SESSION->getValueSession('mdKeyFields')[$cont] as $cont2 => $afield){
						if (strlen($strWherePrin2)>0)
							$strWherePrin2.=" and ";
						if ($__SESSION->getValueSession('mdKeyTFields')[$cont][$cont2]=='num'){
							$strWherePrin2.=$afield . "=". $__SESSION->getValueSession('mdValFields')[$cont][$cont2];
						}else{
							$strWherePrin2.=$afield . "='". $__SESSION->getValueSession('mdValFields')[$cont][$cont2]."'";
						}
					}
				
					$strWherePrin2='Where '. $strWherePrin2;
					$classconsul = new Entidad($__SESSION->getValueSession('mdFields')[$cont],$avalues_prin2);
					$classconsul->ListaEntidades(array(),$__SESSION->getValueSession('mdTable')[$cont],$strWherePrin2,$strfields_prin2,"no");
					$classconsul->VerDatosEntidad(0,$__SESSION->getValueSession('mdFields')[$cont]);
					
					$strvalcol='<br>'.(isset($a_mdLabel)?str_repeat('&nbsp;',2).$a_mdLabel[$cont-1].'&nbsp; -->':'');//
					foreach ($__SESSION->getValueSession('mdFields')[$cont] as $cont2 => $afield){
						if ($cont2>0)
							$strvalcol.= " * ";//<br>
							
							$str_value_field=($__SESSION->getValueSession('mdTFields')[$cont][$cont2]=='money')?number_format((($classconsul->$afield)*1), 0):$classconsul->$afield;
							if (strlen($classconsul->$afield)>16){
								$strvalcol.="<span >".$str_value_field."</span>";}
						else{$strvalcol.="<span ><b>".$str_value_field."</b></span>";}
					}
					if (isset($astr_MDIcon) and (sizeof($astr_MDIcon)>0))$strvalcol.=$astr_MDIcon[$cont];
				
					//
				/*termina primer renglon en blanco*/
			}
			if ($item==$strSelf)
				break;
		}
	
					
/*termina renglon master*/
echo '<nav aria-label="breadcrumb">
<ol class="breadcrumb" style="background-color:#4c4c4c;">
	' . $lis . '
	<li class="breadcrumb-item active" style="color:#ffffff;" aria-current="page">' . $entidad . $lbl_tit_mov .'<br/>' . $strvalcol . '</li>
	
</ol>
</nav>';
$frmname = 'frmadd';
echo '<div id="espacio_' . $frmname . '" class="alert alert-dismissible fade show rounded" role="alert" style="display:none;background-color: #ffd700;margin-bottom: 1rem !important;margin-top: -.7rem !important;">
<p id="texto_' . $frmname . '" class="color_negro"></p>
</div>  ';

if (trim($a_key[1])=='100' && !$boolNoEditable){
	echo "<form name=\"$frmname\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" > \n";
}
echo '<div class="card-body" style="padding: 0rem;">';
        echo '<div class="table-responsive" id="tabla_datos_entidad">';
        echo genOTable('0', '', '', 'table table-hover  color_negro', '#FFFFFF', '0', '3', '', ((($i + 1) == $classent->NumReg) ? '' : 'margin-bottom:' . (isset($str_margin_reg) ? $str_margin_reg : "10px") . ';'));
        echo "<caption class='color_negro' style='caption-side: top;padding-top: .1rem;padding-bottom: .1rem;height:40px;'>" . $barra_busqueda_only . "<h1 class='h5 font-weight-bold rounded' style='" . (strlen($barra_busqueda_only) > 0 ? 'position: relative;top: -27px;left:110px;' : '') . "background-color:#ffffe0;color:#000000;padding-top:.15em;padding-bottom: 7px;'>Listado de: " . $entidad . "</h1></caption>";
        //echo "<form action='#' method='post'>Renglones: <input id='intlimit' name='intlimit' type='number' min='1'  required='required'><input type='submit' value='<->'> </form>";

    	echo '<thead>' . genORen('', '', '', 'success', '', ' background-color:#008000; ');
      
		
		$conta=0;
			foreach ($field as $afield1){
			$conta++;
			}
					
	
			
			
	///////////////
	echo genORen('','','','',$CFG_BGC[0]);
		//	echo genCRen();
	
			$cont=0;
			foreach ($field as $afield1){
			$cont++;
			}
			$cont1=$cont;
			if (!in_array($afield[0],$array_noprint_ent) && $afield1[2]=='1')
				
				echo genCol(isset($afield[17])?$afield[17]:' ','','','success',(isset($afield[20]) && strlen($afield[20])>0)?$afield[20]:'',
								'','',$CFG_LBL[22],'',(isset($afield[29]) && strlen($afield[29])>0)?$afield[29]:'background="img/bg02.jpg"');
				
							
	
	
	echo genORen('','','','success',$CFG_BGC[11]);


		foreach ($field as $afield)
			if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
				echo genCol(isset($afield[17])?$afield[17]:$afield[1],'','','success',(isset($afield[20]) && strlen($afield[20])>0)?$afield[20]:'',
								'','','','',(isset($afield[29]) && strlen($afield[29])>0)?$afield[29]:'background="img/bg02.jpg"');
		echo genCRen();	
	/*terminan titulos*/


	
$tmp_boolNoUpdate=$boolNoUpdate;
$tmp_boolNoDelete=$boolNoDelete;
$tmp_widthEditable=$widthEditable;
echo"<pre>";
print_r(	$classent->VerDatosEntidad(0,$afields)
);
die();
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
	
	echo genORen('','','','',($i%2)?$strColorRow1:$strColorRow2,"id=\"row_".$i."\" ");

////--   termina columna de botones de edicion
//
	//echo "<pre>";	
//	print_r($name_obj);
//	print_r($_SESSION['s_keyFields']);
//	echo "</pre>";	
$name_obj="";
foreach ($keyFields as $cont => $item){
	if (strlen($name_obj)>0){$name_obj.="@!";}
			$name_obj.= $item . ":" . $__SESSION->getValueSession('s_keyFields')[$cont];
			
	//echo "<pre>";	
//	print_r($cont);
//	echo "</pre>";		
}
foreach ($array_key_add as $cont => $item){
	if (strlen($name_obj)>0){$name_obj.="@!";}
			$name_obj.= $item . ":" . $classent-> $item;
}
//$name_obj="";
$name_obj=str_replace(".","*",$name_obj);
/*fin de col de botones*/
	$tmp_keyReg="";
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
				case 'text':
					if ($afield[6] == 'money') {
						$classind->$afield[0] = number_format(str_replace(array('$', ','), array('', ''), $classind->$afield[0]) * 1, 2, '.', '');
					}
					$valor = $classind->$afield[0];
					if ($afield[6] == 'date') {
						$valor = (implode('/', array_reverse(explode('-', $classind->$afield[0]))));
					} else if ($afield[6] == 'datetime') {
						//print_r($afield[0]);
						$a_date = explode(" ", $classind->$afield[0]);
						$valor = implode('/', array_reverse(explode('-', $a_date[0]))) . " " . $a_date[1];
					}
					if ($afield[4] == 1) {
						$str_obj_jsrpt.=(strlen($str_obj_jsrpt) > 0 ? ', ' : '');
						$str_obj_jsrpt.="{'name':'" . $afield[0] . "','type':'" . $afield[3] . "'}";
						$pinta_form.=
								genInput($afield[3], $afield[0], ($valor)
								, '', $afield[9], (($afield[10] == 0) ? '250' : $afield[10]), 'form-control', (($afield[10] == 0) ? 'readonly' : ''), '', ($afield[6] == 'date' || $afield[6] == 'datetime' ? '1' : ($afield[6] == 'int' || $afield[6] == 'money' ? '2' : ($afield[6] == 'email' ? '5' : ($afield[6] == 'nombre' ? '7' : ($afield[6] == 'ip' ? '10' : ($afield[12] == 1 ? '11' : '0'))))))
								, ($afield[6] == 'date' ? $frmname : $descripcion), ($afield[6] == 'int' || $afield[6] == 'money' ? $afield[7] : ''), (isset($afield[11]) ? $afield[11] : ''), $cont, (isset($afield[15]) ? $afield[15] : ''), ((isset($afield[24]) && strlen($afield[24]) > 0) ? $afield[24] . (' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') : ' onKeyPress="' . (isset($afield[28]) ? $afield[28] : '') . 'return objKeyPressed(event,this,\'' . $frmname . '\');"') . " " . $tags_acce)
						;
					} else {
						$pinta_form.= "<span tabindex='0' >" . $classind->$afield[0] . "</span>";
					}
					$pinta_form.='<small style="" class="form-text" id="e_' . $afield[0] . '">&nbsp;</small>';
					break;


				/*****************************************************/
				case 'hidden':
				
						if ($afield[6]=='money'){
							$classind->$afield[0]=number_format(str_replace(array('$',','),array('',''), $classind->$afield[0])*1,  2, '.', '');
						}
						
						
						if ($afield[4]==3){
							 echo genCol(genInput($afield[3],$name_obj.$tmp_keyReg."@!".$afield[0],((strlen($classent->$afield[0])==0 && $afield[5]==1)?$afield[7]:($afield[5]==2?$afield[7]:$classent->$afield[0]))
							 ,'',$afield[9],(($afield[10]==0)?'250':$afield[10]),'hidden',(($afield[10]==0)?'readonly':''),'',
							 		($afield[6]=='date'?'1':($afield[6]=='int' || $afield[6]=='money'?'2':($afield[6]=='email'?'5':($afield[6]=='nombre'?'7':($afield[6]=='ip'?'10':'0')))))
							 ,($afield[6]=='date'?$frmname:$afield[1]),
							 ($afield[6]=='int' || $afield[6]=='money'?$afield[7]:''),'',$cont,(isset($afield[15])?$afield[15]:''),(isset($afield[24])?$afield[24]:'')),(isset($afield[14])?$afield[14]:''),'','',$bgstyle,
							 	(isset($afield[14])?'':$awidths[2]))." \n";
						}else{echo genCol($classent->$afield[0],(isset($afield[14])?$afield[14]:''),'','',$bgstyle, (isset($afield[14])?'':$awidths[2]),'',$CFG_LBL[1]);}
						break;
				/*******************************************************/
				case 'check':
					if ($afield[4]==3){
						$tmp_keyReg="@!".$afield[0].':'.$classent->$afield[7];
						echo genCol(genInput('checkbox',$name_obj."@!".$afield[0].':'.$classent->$afield[7],$classent->$afield[7],'','','','','',($classent->$afield[0]>=1?'checked':''),'8'),'','','','',$afield[8],'',$style);
					}else{echo genCol(genInput('checkbox',$name_obj."@!".$afield[0],'','','','','','DISABLED',($classent->$afield[0]==1?'checked':''),'8'),'','','','',$afield[8],'',$CFG_LBL[30]);}	
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
	//$fg++;
}
echo genCTable().genCCol().genCRen();
	//
		echo genORen().genCol(genOTable('0','70','','','','3','0','left').genORen()
				.genOCol('','','','','35','',$CFG_LBL[16],'',"valign=\"bottom\" onMouseOver=\"this.style.backgroundColor='".
						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
//			 $strhidden.
//			 $strFieldsInput.
			 genInput('hidden','op','1').
			 genInput('hidden','nivPo',(isset($_SESSION['niv']) && strlen($_SESSION['niv'])>0)?$_SESSION['niv']:'0').
			 genInput('hidden','sel','0').
			 genInput('hidden','btnGuardaDetalle','btnGuardaDetalle','','','','').
			 "<input type=\"image\" alt=\"Guardar Registro\" src=\"img/img07.gif\" border='0' name=\"submit\" value=\"0\"". "> \n".
			 genCCol().
			 //"</form>".
			 //"<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n".
			 genOCol('','','','','35','',$CFG_LBL[16],'',"valign=\"bottom\" onMouseOver=\"this.style.backgroundColor='".
						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			 //genInput('hidden','op','1').
			 //genInput('hidden','nivPo',(isset($_SESSION['niv']) && strlen($_SESSION['niv'])>0)?$_SESSION['niv']:'0').
			 //genInput('hidden','btnCancela','btnCancela','','','','').
			 //"<input type=\"image\" alt=\"Cancelar\" src=\"img/img08.gif\" border='0'> \n".
			 "<a href=\"".$_SERVER['PHP_SELF']."?op=1&btnCancela=btnCancela\" ><div style=\"font-size:8px; text-decoration:none;\" ><img src=\"img/img08.gif\" alt=\"Cancelar\" border=\"0\"/></div></a>".
			 genCCol().genCRen().genCTable(),'70','','',$CFG_BGC[1],'','',$CFG_LBL[5],'','valign="bottom" background="img/bg05.jpg"').genCRen()." \n";
		echo "</form>";
		echo genCTable();
		echo genCCol().genCRen().genCTable();
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