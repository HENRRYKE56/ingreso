<?php
function genTArea($name,$value,$makeReadOnly='',$cols='', $rows='', $estilo='',$intobj='',$upname='',$validini='') 
{ 
    $read='';
	if(strlen(trim($makeReadOnly))>0)
		if ($makeReadOnly=='yes')
        	$read='readonly'; 
    $cls='';
	if(strlen(trim($cols))>0) 
        $cls="cols='$cols'";
    $rws='';
	if(strlen(trim($rows))>0) 
        $rws="rows='$rows'";
    $clase='';
	if(strlen(trim($estilo))>0) 
        $clase="class='$estilo'";
		
		if ($intobj=='5'){
			return "<textarea id='$name' name='$name' $cls $rws $clase $read onblur=\"obj_valObj(".
						"'".$name."','".$validini."','RisTxt','".$upname."');return document.obj_retVal\">". $value."</textarea> \n"; 
		} else {
			return "<textarea id='$name' name='$name' $cls $rws $clase $read>". $value."</textarea> \n"; 
		}
		
    
}
function genInput($type,$name,$value='',$makeReadOnly='',$size='', $mlen='', $estilo='',$disabled='',$checked='',$intobj='',$upname='',$validini='',$strvalid='',$id='0',$onBlurAdd='',$strAdd='') 
{ 
    $read='';
	if(strlen(trim($makeReadOnly))>0)
		if ($makeReadOnly=='yes')
        	$read='readonly'; 
    $sz='';
	if(strlen(trim($size))>0) 
        $sz="size='$size'";
    $maxlength='';
	if(strlen(trim($mlen))>0) 
        $maxlength="maxlength='$mlen'";
    $clase='';
	if(strlen(trim($estilo))>0) 
        $clase="class='$estilo'";
	if (strlen($strvalid)>0){
		$strvalid=",'".$strvalid."'";}
	else{
		$strvalid=",''";}
	$strcal='';
        
	if ($intobj=='1'){
		$strcal="onfocus=\"objcal.select(document.getElementById('$name'),'00901010a".$id."','dd/MM/yyyy'); return false;\"";
		        // "TITLE=\"objcal.select(document.$upname.$name,'00901010a".$id."','yyyy-MM-dd'); return false;\"";
		return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled $strcal onClick=\"".$onBlurAdd."\" onblur=\"obj_valObj(".
						"'".$name."','".$validini."','isDate','".$name."');return document.obj_retVal;\" $strAdd> \n".
				//"<span><A HREF=\"#\" onClick=\"objcal.select(document.getElementById($name),'00901010a".$id."','yyyy-MM-dd'); return false;\" TITLE=\"objcal.select(document.$upname.$name,'00901010a".$id."','yyyy-MM-dd'); return false;\" NAME=\"00901010a".$id."\" ID=\"00901010a".$id."\" style= \"color:#666699; font-size:11px; font-family:Arial; text-decoration:none\">[-]</A></span>"; 
                                "<span><A HREF=\"#\" onClick=\"objcal.select(document.getElementById('$name'),'00901010a".$id."','dd/MM/yyyy'); return false;\" NAME=\"00901010a".$id."\" ID=\"00901010a".$id."\" style= \"color:#666699; font-size:11px; font-family:Arial; text-decoration:none\">[-]</A></span>"; 
	}else{
		switch ($intobj){
			case '2':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','isNum','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n"; 
			break;
			case '3':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','RisNum','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n";	
			break;
			case '4':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','RisTxt','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n";	
			break;
			case '5':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','isEmail','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n";	
			break;
			case '6':
				return "<input type='$type' id='$name' name='$name' $sz value='$value' $clase $read $strAdd> \n";
			break;
			case '7':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','isNombre','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n";	
			break;
			case '8':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled $strAdd> \n"; 
			break;
			case '9':
				return "<input type='$type' id='$name' name='$name' $sz value='$value' $clase $read $strAdd> \n";
			break;
			case '10':
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','isIP','".$upname."'$strvalid);return document.obj_retVal;\" $strAdd> \n";	
			break;
			default:
				$onblur="";
				if ($type!='hidden'){
				if (strlen($strvalid)>0){$onblur="onblur=\"".$onBlurAdd."obj_valObj(".
						"'".$name."','".$validini."','isTxt','".$upname."'$strvalid);return document.obj_retVal;\"";}
				else {if (strlen($onBlurAdd)>0){$onblur="onblur=\"".$onBlurAdd."\"";}}}
				return "<input type='$type' id='$name' name='$name' value='$value' $sz $maxlength $clase $read $checked $disabled $onblur $strAdd > \n"; 
			
		}
		
	}
}
function genSelect($name,$size='',$makemultiple='',$optvalue,$optdisplay,$sel='',$disabled='', $estilo='',$stradd='',$classadd='',$maxRows='') 
{ 
    $sz="size='1'";
	if(strlen(trim($size))>0) 
        $sz="size='$size'";
    if(strlen(trim($makemultiple))>0){
		if($makemultiple=='yes'){
        	$make='MULTIPLE ' . $sz;
    	} else { 
        	$make=$sz; 
		}
    } else {
		$make=$sz;
	}
	$dsbld='';
    if(strlen(trim($disabled))>0)
        if ($disabled=='yes')
			$dsbld='DISABLED';
    if(!array($optdisplay)) { 
        return false; 
    } 
    if(!array($optvalue)) { 
        return false; 
    }
	$clase='';
    if(strlen(trim($estilo))>0)
        $clase="class='$estilo'";
    $output="<select id='$name' name='$name' $make $dsbld $stradd> \n"; 
	
    for($i=0;$i<sizeof($optvalue);$i++) { 
		$selected='';
		if ($optvalue[$i]==$sel)
			$selected='SELECTED';
        $output.="<option value='$optvalue[$i]' $selected ".(($i>$maxRows && strlen($classadd)>0)?$classadd:$clase).">$optdisplay[$i]</option> \n"; 
    } 
    $output.="</select> \n"; 
    return $output; 
} 
function genOTable($border='', $width='',$heigth='', $estilo='', $bgcolor='', $cellpadding='', $cellspacing='', $align='', $stradd="") 
{ 
    if(strlen(trim($border))>0) { 
        $br="border='$border'"; 
    } else { 
        $br=''; 
    } 
    if(strlen(trim($align))>0) { 
        $ag="align='$align'"; 
    } else { 
        $ag=''; 
    } 
    if(strlen(trim($cellpadding))>0) { 
        $cp="cellpadding='$cellpadding'"; 
    } else { 
        $cp="cellpadding='0'"; 
    } 
    if(strlen(trim($cellspacing))>0) { 
        $cs="cellspacing='$cellspacing'"; 
    } else { 
        $cs="cellspacing='0'"; 
    } 
    if(strlen(trim($bgcolor))>0) { 
        $bg="bgcolor='$bgcolor'"; 
    } else { 
        $bg=""; 
    } 
    if(strlen(trim($width))>0) { 
        $wd="width='$width'"; 
    } else { 
        $wd=''; 
    } 
    if(strlen(trim($heigth))>0) { 
        $hg="heigth='$heigth'"; 
    } else { 
        $hg=''; 
    } 
    if(strlen(trim($estilo))>0) { 
        $clase="class='$estilo'"; 
    } else { 
        $clase=''; 
    } 
    return "<table $wd $hg $br $cp $cs $bg $clase $ag $stradd> \n"; 
}
function genCTable(){return "</table> \n";}
function genORen($rowspan='', $width='', $heigth='', $estilo='', $bgcolor='', $other='') 
{ 
    if(strlen(trim($width))>0) { 
        $wd="width='$width'"; 
    } else { 
        $wd=''; 
    } 
    if(strlen(trim($heigth))>0) { 
        $hg="heigth='$heigth'"; 
    } else { 
        $hg=''; 
    } 
    if(strlen(trim($rowspan))>0) { 
        $rw="rowspan='$rowspan'"; 
    } else { 
        $rw=''; 
    } 
    if(strlen(trim($bgcolor))>0) { 
        $bg="bgcolor='$bgcolor'"; 
    } else { 
        $bg=""; 
    } 
    if(strlen(trim($estilo))>0) { 
        $clase="class='$estilo'"; 
    } else { 
        $clase=''; 
    } 
    return "<tr $wd $hg $rw $bg $clase $other> \n"; 
}
function genCRen(){return "</tr> \n";}
function genCol($value, $colspan='', $align='', $valign='', $bgcolor='', $width='', $heigth='', $estilo='', $rowspan='', $strAdd='') 
{ 
    $colspan.=' ';
//echo 'a'.strlen(trim($colspan));
    
    if(strlen(trim($colspan))>0) { 
        $cs="colspan='$colspan'"; 
    } else { 
        $cs=''; 
    } 
	$rs='';
    if(strlen(trim($rowspan))>0) { 
		if ($rowspan>0)
        	$rs="rowspan='$rowspan'"; 
    } 
    if(strlen(trim($align))>0) { 
        $ag="align='$align'"; 
    } else { 
        $ag=''; 
    } 
    if(strlen(trim($valign))>0) { 
        $vag="valign='$valign'"; 
    } else { 
        $vag=''; 
    } 
    if(strlen(trim($bgcolor))>0) { 
        $bg="bgcolor='$bgcolor'"; 
    } else { 
        $bg=""; 
    } 
    if(strlen(trim($width))>0) { 
        $wd="width='$width'"; 
    } else { 
        $wd=''; 
    } 
    if(strlen(trim($heigth))>0) { 
        $hg="heigth='$heigth'"; 
    } else { 
        $hg=''; 
    } 
    if(strlen(trim($estilo))>0) { 
        $clase="class='$estilo'"; 
    } else { 
        $clase=''; 
    } 
    return "<td $wd $hg $ag $vag $cs $rs $bg $clase $strAdd> \n".$value."</td> \n"; 
}
function genOCol($colspan='', $align='', $valign='', $bgcolor='', $width='', $heigth='', $estilo='', $rowspan='', $strAdd='') 
{ 
    if(strlen(trim($colspan))>0) { 
        $cs="colspan='$colspan'"; 
    } else { 
        $cs=''; 
    } 
	$rs='';
    if(strlen(trim($rowspan))>0) { 
		if ($rowspan>0)
        	$rs="rowspan='$rowspan'"; 
    } 
    if(strlen(trim($align))>0) { 
        $ag="align='$align'"; 
    } else { 
        $ag=''; 
    } 
    if(strlen(trim($valign))>0) { 
        $vag="valign='$valign'"; 
    } else { 
        $vag=''; 
    } 
    if(strlen(trim($bgcolor))>0) { 
        $bg="bgcolor='$bgcolor'"; 
    } else { 
        $bg=""; 
    } 
    if(strlen(trim($width))>0) { 
        $wd="width='$width'"; 
    } else { 
        $wd=''; 
    } 
    if(strlen(trim($heigth))>0) { 
        $hg="heigth='$heigth'"; 
    } else { 
        $hg=''; 
    } 
    if(strlen(trim($estilo))>0) { 
        $clase="class='$estilo'"; 
    } else { 
        $clase=''; 
    } 
    return "<td $wd $hg $ag $vag $cs $rs $bg $clase $strAdd> \n"; 
}
function genCCol(){return "</td> \n";}
function cmp_date($fecha1,$fecha2){
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=explode("/",$fecha1);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=explode("-",$fecha1);
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=explode("/",$fecha2);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=explode("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
        return ($dif);                         
}
function b_avance($intAvance=10, $intTotal=100, $intWidth=50, $intHeigth=15, $strTexto='%', 
		 $array_color, $array_ranges, $class='', $more100='#98E72E'){
	$intPercent=($intAvance*100)/$intTotal;
	$intAbs=intval(($intPercent*$intWidth)/100);
	if ($intPercent==0)
		$b_bgcolor="#FFFFFF";
	if ($intPercent>100)
		$b_bgcolor=$more100;
	foreach ($array_ranges as $intCnt => $strRange){
		$a_range=explode('-',$strRange);
		if ($intPercent > $a_range[0] && $intPercent <= $a_range[1])
			$b_bgcolor=$array_color[$intCnt];
	}
	//$intPercent=intval($intPercent);
	$strDiv="<div style=\"width:".$intWidth."px; height:" .($intHeigth+1)."px;overflow:hidden;\"><div style=\"position:relative; top:0px; left:0px; width:".$intAbs."px; height:" .$intHeigth."px;".
	        "px;background-color:".$b_bgcolor."; font-size:11px\" ></div> \n";
	$strDiv.="<div style=\"position:relative; top:-".$intHeigth."px; left:0px; width:".$intWidth."px; height:" .$intHeigth."px;".
	        "px;border:1px #000000 solid; font-size:11px\" ".(strlen(trim($class))>0?'class='.$class:'').">";
	$strDiv.=(strstr($intPercent, '.')? number_format($intPercent, 2):$intPercent).$strTexto ."\n";
	$strDiv.="</div></div> \n";
	return $strDiv;
}
function safe_filename($filename) {

	//  Convert to lower case
	$filename = strtolower($filename);

	//  Replace spaces with underscores
	$filename = str_replace(' ', '_', $filename);

	//  Remove anything not a-z, 0-9, _ or .
	$filename = preg_replace('/[^[a-z0-9_\.]/', '', $filename);

	//  Send filename back
	return $filename;

}
function destroy_session($varname){
	if (isset($_SESSION[$varname]))
		unset($_SESSION[$varname]);
}
function calcularFecha($dias){
 
$calculo = strtotime("$dias days");
return date("Y-m-d", $calculo);
}
?>