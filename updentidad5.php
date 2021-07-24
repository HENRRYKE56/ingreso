<?php
include_once("config/cfg.php");
if ($__SESSION->getValueSession('nomusuario') == "") {
    //include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/i_refresh.php");
} else {
    include_once("lib/lib_function.php");
//include_once("config/cfg.php");
    include_once("lib/lib_pgsql.php");
    include_once("lib/lib_entidad.php");

    if (function_exists('fnValidateFiatRegistroMD')) {
        fnValidateFiatRegistroMD();
    }
$lbl_tit_mov="&nbsp; ";
$afields=array();
$widthEditable=40;
if (!isset($boolNoUpdate))
	$boolNoUpdate=false;
if (!isset($boolNoNew))
	$boolNoNew=false;
if (!isset($boolNoDelete))
	$boolNoDelete=false;
if ($boolNoEditable || ($a_key[1]<>'100' && $a_key[2]<>'100') || ($boolNoUpdate && $boolNoDelete)){
	$widthEditable=20;
}else{
	if ($a_key[1]<>'100' || $a_key[2]<>'100' || $boolNoUpdate || $boolNoDelete)
		$widthEditable=20;
}
$widthEditableIni=$widthEditable;
$classent = new Entidad($allfields,$allvalues);
/* echo "<pre>";
print_r($allfields);
print_r($allvalues); */
foreach ($field as $afield)
	if ($afield[2]=='1' || $afield[2]=='2')
		$afields[]=$afield[0];
//$classent->ListaEntidades($a_order,$tablas_c,$strWhere,(isset($items0)?$items0:''),'','',"",(isset($tipo_order)?$tipo_order:''));
$classent->ListaEntidades($a_order,$tablas_c,(isset($strQryAdd10)?'':$strWhere),(isset($strQryAdd10)?"":(isset($items0)?$items0:'')),(isset($strQryAdd10)?'no':''),'',(isset($strQryAdd10)?$strQryAdd10:""),(isset($tipo_order)?$tipo_order:''));

 $primeros = "";
    $segundos = "";
    if ($intpag_s[$pag_id] > 1) {
        $primeros = "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=1" . "'\" ><i class='fa fa-fast-backward'></i></a></li>";
        $primeros.= "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag_s[$pag_id] - 1) . "'\" ><i class='fa fa-backward'></i></a></li>";
    } else {
        $primeros = "<li class='page-item disabled'><a href='#' class='page-link'><i class='fa fa-fast-backward'></i></li>";
        $primeros.= "<li class='page-item disabled'><a href='#' class='page-link'><i class='fa fa-backward'></i></li>";
    }
    if ($intpag_s[$pag_id] < $decdiv) {
        $segundos = "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . ($intpag_s[$pag_id] + 1) . "'\"><i class='fa fa-forward'></i></a></li>";
        $segundos.= "<li class='page-item'><a href='#' class='page-link' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . $decdiv . "'\" ><i class='fa fa-fast-forward'></i></a></li>";
    } else {
        $segundos = "<li class='page-item'><a href='#' class='page-link'><i class='fa fa-forward'></i></a></li>";
        $segundos.= "<li class='page-item'><a href='#' class='page-link'><i class='fa fa-fast-forward'></i></a></li>";
    }
    $paginas = 20;
    $inipag = 1;
    $finpag = $paginas;
    if ($decdiv >= $paginas) {
        if ($intpag_s[$pag_id] - ($paginas / 2) >= 1 && $intpag_s[$pag_id] + ($paginas / 2) <= $decdiv) {//1-10=-9
            $inipag = $intpag_s[$pag_id] - ($paginas / 2);
            $finpag = $intpag_s[$pag_id] + ($paginas / 2);
        } else {
            if ($intpag_s[$pag_id] - ($paginas / 2) < 1) {
                $inipag = 1;
                $finpag = $paginas;
            }
            if (($intpag_s[$pag_id] + ($paginas / 2)) > $decdiv) {
                $inipag = $decdiv - $paginas;
                $finpag = $decdiv;
            }
        }
    } else {
        $finpag = $decdiv;
    }
    $paginas = "";
    for ($i = $inipag; $i <= $finpag; $i++) {
        if ($intpag_s[$pag_id] == $i) {
            $paginas.="<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
        } else {
            $paginas.="<li class='page-item'><a class='page-link' href='#' onClick=\"window.location='" . $_SERVER['PHP_SELF'] . "?intpag_s" . $pag_id . "=" . $i . "'\">" . $i . "</a></li>";
        }
    }
    $paginacion = '<nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm justify-content-left">
			' . $primeros . $paginas . $segundos . '
                        </ul>
                   </nav>  ';

    $str_closeform = "";
    $b_printline = 1;
    $str_closeform = "</form>";


foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
      //  echo $item."|".$strSelf."|".$cont."</br>"; //die();

        if ($cont > 0) {
            /* primer renglon en blanco */
            $strfields_prin2 = ""; //cambiar los arreglos de session 
            $atmp_mdFields = $__SESSION->getValueSession('mdFields');
            $atmp_mdTFields = $__SESSION->getValueSession('mdTFields');
            $atmp_mdKeyFields = $__SESSION->getValueSession('mdKeyFields');
            $atmp_mdKeyFields2 = $__SESSION->getValueSession('mdKeyFields2');
            $atmp_mdKeyTFields = $__SESSION->getValueSession('mdKeyTFields');
            $atmp_mdValFields = $__SESSION->getValueSession('mdValFields');
            $atmp_mdStrFields = $__SESSION->getValueSession('mdStrFields');
            $atmp_mdTable = $__SESSION->getValueSession('mdTable');
            $atmp_m_NokeyFields = $__SESSION->getValueSession('m_NokeyFields');
//            echo '<pre>';
//            print_r($atmp_mdFields);die();
            if (isset($atmp_mdFields[$cont]) && isset($atmp_mdKeyFields[$cont]) && isset($atmp_mdValFields[$cont])) {
                foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                    if (strlen($strfields_prin2) > 0)
                        $strfields_prin2.=", ";
                    $strfields_prin2.=$afield;
                    if ($atmp_mdTFields[$cont][$cont2] == 'num') {
                        $avalues_prin2[] = 0;
                    } else {
                        $avalues_prin2[] = '';
                    }
                }
                $strWherePrin2 = "";
                if (!isset($atmp_m_NokeyFields[$cont]))
                    $atmp_m_NokeyFields[$cont] = array();
                $arraytmpX = $atmp_m_NokeyFields[$cont];
				
				
				
                foreach ($atmp_mdKeyFields[$cont] as $cont2 => $afield) {
                    if (isset($atmp_mdKeyFields2) && is_array($atmp_mdKeyFields2) && count($atmp_mdKeyFields2) == count($atmp_mdKeyFields) && isset($atmp_mdKeyFields2[$cont][$cont2])) {
                        $afield = $atmp_mdKeyFields2[$cont][$cont2];
                    }
                    if (!in_array($afield, $arraytmpX)) {
                        if (strlen($strWherePrin2) > 0)
                            $strWherePrin2.=" and ";
                        if ($atmp_mdKeyTFields[$cont][$cont2] == 'num') {
                            if (isset($cambi_nombre))
                                $strWherePrin2.=$cambi_nombre . "=" . $atmp_mdValFields[$cont][$cont2];
                            else
                                $strWherePrin2.=$afield . "=" . $atmp_mdValFields[$cont][$cont2];
                        } else {
                            $strWherePrin2.=$afield . "='" . $atmp_mdValFields[$cont][$cont2] . "'";
                        }
                    }
                }
            } else {
                $__SESSION->unsetSession('niv');
                $str_msg_red = 'DATOS NO VALIDOS';
                include_once("includes/sb_msg_red.php");
                echo "<meta http-equiv='refresh' content='2;URL=" . $_SERVER['PHP_SELF'] . "'>";
                die();
            }

            if (isset($atmp_mdStrFields[$cont])) {
                $strfields_prin2 = $atmp_mdStrFields[$cont];
                $strfields_prin2 = is_array($strfields_prin2) ? implode(",", $strfields_prin2) : $strfields_prin2;
            }
            if (isset($atmp_mdTable[$cont])) {
                $tmp_tables = $atmp_mdTable[$cont];
                $tmp_tables = is_array($tmp_tables) ? implode(",", $tmp_tables) : $tmp_tables;
            }

			
			
			
			
            $strWherePrin2 = 'Where ' . $strWherePrin2;
			
			
			//            echo '<pre>';
            $classconsul = new Entidad($atmp_mdFields[$cont], $avalues_prin2);
            $classconsul->ListaEntidades(array(), $tmp_tables, $strWherePrin2, $strfields_prin2, "no");
            $classconsul->VerDatosEntidad(0, $atmp_mdFields[$cont]);
         //   echo '<pre>';            
//            print_r($classconsul);die();


            $strvalcol = (isset($a_mdLabel) ? $a_mdLabel[$cont - 1] : '');
            $niveles_s[] = $strvalcol;
            foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                if ($classconsul->$afield <> 'null' && $classconsul->$afield <> "") {
                    $niveles_a[] = $classconsul->$afield;
                }
            }
            /* termina primer renglon en blanco */
        }
        if ($item == $strSelf)
            break;
    }
	
	    $link_niv = array();
    if ($__SESSION->getValueSession('niveles') <> "")
        foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
            if ($cont > 0)
                $link_niv[] = $_SERVER['PHP_SELF'] . '?nivel=' . ($cont - 1);
        }
//    echo '<pre>';        
//    print_r($niveles_a);die();
    if (isset($niveles_s) || isset($niveles_a)) {
        $icono = "";
        for ($index = 0; $index < count($niveles_a); $index++) {
            if ($index == 0) {
                $icono = '<i class="fa fa-home text-info" style="font-size:1.3em;"></i>&nbsp;';
            } else {
                $icono = '';
            }
            $lis.= '&nbsp;<a href="#" ' . " onClick=\"window.location='" . $link_niv[$index] . "'\"" . ' class="tip-bottom text-secondary" data-toggle="tooltip" title="' . $niveles_a[$index] . '" style="font-size:17px;text-decoration: none;">&nbsp;' . $icono . $niveles_s[$index] . '</a>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i>';
        }
    }
    $lis.= '&nbsp;<a href="#" class="tip-bottom text-dark" style="font-size:14px;font-weight: bold;text-decoration: none;">' . $entidad . $lbl_tit_mov . '</a>';
    echo' <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb" style="margin-bottom: 12px;padding: 0.5rem 1rem;">
              <li class="breadcrumb-item active h5 font-weight-bold">' . $str_a_onclick . "" . $lis . '</li>
            </ul>
          </div>
          ';
    echo $barra_busqueda;

    echo '<div class="card">
      <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12" style="overflow:auto;">';
	
echo genOTable('0','100%','','','',1,0,'top');

/* < --- Inicia mensaje de error --- >*/

if (isset($_SESSION['SYS_ECEI']['msg']) && strlen($_SESSION['SYS_ECEI']['msg'])>1){
	echo genORen();
	echo genOCol('100');
		$str_msg_red="";
		$i_intstyle=19;
		$i_intcolor=6;
		for ($i=0; $i<(strlen($_SESSION['SYS_ECEI']['msg'])/3);$i++){
			if (strlen($str_msg_red)>0)
				$str_msg_red.=',&nbsp;&nbsp;';
			$str_msg_red.=$CFG_MSG[(substr($_SESSION['SYS_ECEI']['msg'],$i*3,3)*1)];
		}
		$_SESSION['SYS_ECEI']['msg']='0';
		include("includes/i_msg_red.php");
	echo genCCol();
	echo genCRen();
}
/* < --- Termina mensaje de error --- >*/



/* < --- Inicia mensaje de error --- >*/


/* < --- Termina mensaje de error --- >*/
/*Linea de titulo de cabecera*/
echo genORen();
echo genOCol('','','','','100%');
echo genOTable('0','100%','','','#FFFFF','0','0');
echo genORen();

echo genCol("",'','','','#FFFFFF','20','',$CFG_LBL[31]);
//echo genCol($str_a_onclick,'','','',$CFG_BGC[0],'20','20',$CFG_LBL[31]);
echo genCol("<span style='background-color: #ffffff;font-size: 20px;font-weight: 800;'>&nbsp;Información de la unidad&nbsp;</span>" .$lbl_tit_mov,'','','','#FFFFFF',250,'',$CFG_LBL[8],'','valign="bottom" bgcolor="#FFFFF"');
//echo genCol("<img border='0' src='img/latder.jpg'>",'','','',$CFG_BGC[1],'10','',$CFG_LBL[31]);
//echo genCol("&nbsp;".(function_exists('fnSetRowColors')?fnSetRowColors():''),'','','',$CFG_BGC[1],'100%','',$CFG_LBL[31],'','background="img/bg04.jpg"');
//echo genCol("<img border='0' src='img/supder.jpg'>",'','','',$CFG_BGC[1],'20','',$CFG_LBL[31]);
echo genCRen();
echo genCTable().genCCol().genCRen();
/*termina linea de titulo de cabecera*/
/*inicia  renglon de master*/



		foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
        //echo $item."|".$strSelf."|".$cont; //die();
        if ($cont > 0) {
              $strfields_prin2 = ""; //cambiar los arreglos de session 
			
			if (isset($atmp_mdFields[$cont]) && isset($atmp_mdKeyFields[$cont]) && isset($atmp_mdValFields[$cont])) {
                foreach ($atmp_mdFields[$cont] as $cont2 => $afield) {
                    if (strlen($strfields_prin2) > 0)
                        $strfields_prin2.=", ";
                    $strfields_prin2.=$afield;
                    if ($atmp_mdTFields[$cont][$cont2] == 'num') {
                        $avalues_prin2[] = 0;
                    } else {
                        $avalues_prin2[] = '';
                    }
                }
                $strWherePrin2 = "";
                if (!isset($atmp_m_NokeyFields[$cont]))
                    $atmp_m_NokeyFields[$cont] = array();
                $arraytmpX = $atmp_m_NokeyFields[$cont];
				
				
				
                foreach ($atmp_mdKeyFields[$cont] as $cont2 => $afield) {
                    if (isset($atmp_mdKeyFields2) && is_array($atmp_mdKeyFields2) && count($atmp_mdKeyFields2) == count($atmp_mdKeyFields) && isset($atmp_mdKeyFields2[$cont][$cont2])) {
                        $afield = $atmp_mdKeyFields2[$cont][$cont2];
                    }
                    if (!in_array($afield, $arraytmpX)) {
                        if (strlen($strWherePrin2) > 0)
                            $strWherePrin2.=" and ";
                        if ($atmp_mdKeyTFields[$cont][$cont2] == 'num') {
                            if (isset($cambi_nombre))
                                $strWherePrin2.=$cambi_nombre . "=" . $atmp_mdValFields[$cont][$cont2];
                            else
                                $strWherePrin2.=$afield . "=" . $atmp_mdValFields[$cont][$cont2];
                        } else {
                            $strWherePrin2.=$afield . "='" . $atmp_mdValFields[$cont][$cont2] . "'";
                        }
                    }
                }
            }
			
			
			
			
			
			  if (isset($atmp_mdStrFields[$cont])) {
                $strfields_prin2 = $atmp_mdStrFields[$cont];
                $strfields_prin2 = is_array($strfields_prin2) ? implode(",", $strfields_prin2) : $strfields_prin2;
            }
            if (isset($atmp_mdTable[$cont])) {
                $tmp_tables = $atmp_mdTable[$cont];
                $tmp_tables = is_array($tmp_tables) ? implode(",", $tmp_tables) : $tmp_tables;
            }
			
			
            $strWherePrin2 = 'Where ' . $strWherePrin2;
			
			
			
         	$classconsul = new Entidad($atmp_mdFields[$cont], $avalues_prin2);
            $classconsul->ListaEntidades(array(), $tmp_tables, $strWherePrin2, $strfields_prin2, "no");
            $classconsul->VerDatosEntidad(0, $atmp_mdFields[$cont]);
					
					/* echo "<pre>";
					print_r($classconsul); */
					
					
					echo genORen();
					echo genOCol('','','','',$suma_width+$widthEditable);
					echo genOTable('0','100%','','',$CFG_BGC[6],'1','0');
					echo genORen();//.str_repeat('&nbsp;',(isset($a_mdLabel)?4:2))
					$strvalcol=(str_repeat('&nbsp;',($cont*2))).'<i class="fa fa-arrow-right" style="font-size: 1.5rem;" aria-hidden="true"></i>'.(isset($a_mdLabel)?str_repeat('&nbsp;',2).$a_mdLabel[$cont-1].'&nbsp;':'')
								."".str_repeat('&nbsp;',($cont*2)).str_repeat('&nbsp;',4);//
					foreach ($_SESSION['SYS_ECEI']['mdFields'][$cont] as $cont2 => $afield){
						if ($cont2>0)
							$strvalcol.= " * ";//<br>
							
							$str_value_field=($_SESSION['SYS_ECEI']['mdTFields'][$cont][$cont2]=='money')?number_format((($classconsul->$afield)*1), 0):$classconsul->$afield;
							if (strlen($classconsul->$afield)>16){$strvalcol.="<span style='text-align:left;width:300;background-color:#F8F9D9; border:1px #A9C472 solid;'>".$str_value_field."</span>";}
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
$frmname="frmupd";

//$btnInput='btnGuardaDetalle';
//$lblInput='Guardar';
//$strimg='img07';
if (trim($a_key[1])=='100' && !$boolNoEditable){
	echo "<form name=\"$frmname\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" > \n";
}


	echo genORen();
	echo genOCol('','','','',$suma_width+$widthEditable);
	echo genOTable('0','100%','','',$CFG_BGC[10],'2','1');
	/*titulos de entidad*/
	echo genORen('','','','',$CFG_BGC[1]);


	foreach ($field as $afield)
			if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
				echo genCol(isset($afield[17])?$afield[17]:$afield[1],'','','','#208637',
								$afield[8],'','text-white cell_titulo fsize07em fontblack border_tlr','',(isset($afield[29]) && strlen($afield[29])>0)?$afield[29]:'style="
    text-align: center;
    font-size: 25px;
    font-weight: 600;
"');
		echo genCRen();	
	/*terminan titulos*/
	$tmp_style=$CFG_LBL[30];
$tmp_boolNoUpdate=$boolNoUpdate;
$tmp_boolNoDelete=$boolNoDelete;
$tmp_widthEditable=$widthEditable;
/* echo "<pre>";
print_r($afields); */
for ($i=0; $i<$classent->NumReg; $i++) {
	$boolNoUpdate=$tmp_boolNoUpdate;
	$boolNoDelete=$tmp_boolNoDelete;
	$widthEditable=$tmp_widthEditable;
	$classent->VerDatosEntidad($i,$afields);
	$boolSetColor=false;
	$strSetColor="";
	$strSetStyle="";
	$CFG_LBL[30]=$tmp_style;
	$strColorRow1=$CFG_BGC[31];
	$strColorRow2=$CFG_BGC[6];


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
		if (isset($a_filed_bg_color) and sizeof($a_filed_bg_color)>0){}else{
			$CFG_LBL[30]=$strSetStyle;
			$strColorRow1=$strSetColor;
			$strColorRow2=$strSetColor;
		}
	}else{
		$CFG_LBL[30]=$tmp_style;
		$strColorRow1=$CFG_BGC[31];
		$strColorRow2=$CFG_BGC[6];
	}
	if (function_exists('addRowSepar')){
		addRowSepar($classent);
	}
	
	echo genORen('','','','',($i%2)?$strColorRow1:$strColorRow2,"id=\"row_".$i."\" ");

////--   termina columna de botones de edicion
//
//	echo "<pre>";	
//	print_r($_SESSION['s_keyFields']);
//	echo "</pre>";	
$name_obj="";
foreach ($keyFields as $cont => $item){
	if (strlen($name_obj)>0){$name_obj.="@!";}
			$name_obj.= $item . ":" . $_SESSION['SYS_ECEI']['s_keyFields'][$cont];
			
	//echo "<pre>";	
//	print_r($cont);
//	echo "</pre>";		
}
foreach ($array_key_add as $cont => $item){
	if (strlen($name_obj)>0){$name_obj.="@!";}
			$name_obj.= $item . ":" . $classent-> $item;
}
$name_obj=str_replace(".","*",$name_obj);
/*fin de col de botones*/
	foreach ($field as $count_fields => $afield){


		
		if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1'){
			$style=$CFG_LBL[30];
			
			switch ($afield[3]){
				
				case 'select':
					if ($afield[4]==3){
							//$str_obj_jsrpt.=(strlen($str_obj_jsrpt)>0?', ': ''); $str_obj_jsrpt.="{'name':'".$afield[0]."','type':'".$afield[3]."'}";
							echo genOCol('','','','#EAEDE0',$afield[8],'',$style,'');
							if (isset($afield[5][8]) && $classent->$afield[5][8] == 5){
								
								if (strlen(trim($classent->$afield[0]))>0) $asplit_valselect=split(',',$classent->$afield[0]);
								else $asplit_valselect=array();
								foreach(${$afield[5][0].$classent->$afield[5][7]} as $count_eselect => $val_eselect){
									if ($count_eselect>0){
										$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
										if (($count_eselect%2)==0){$strsstyle="background-color:#FFFFCC;border: 1px solid  #DADADA;";}
									echo "<span style=\"".$strsstyle."\">".
										genInput('checkbox',$name_obj."@!".$afield[0].':'.$val_eselect,$val_eselect,'','','','','',(in_array($val_eselect,$asplit_valselect)?'checked':''),'8') .
										${$afield[5][1].$classent->$afield[5][7]}[$count_eselect].
										"</span>";
									}}
								}
							else if (isset($afield[5][8]) && $classent->$afield[5][8] == 3){
											if (isset($afield[5][10]) && strlen($afield[5][10])>0 && $classent->$afield[5][9]==1){
														$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
													echo "<span style=\"".$strsstyle."\">".
														genInput('txtbox',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',30,(isset($afield[5][11])?$classent->$afield[5][11]:30),
															'txtbox','','',0,'texto','','',$cont,'','') .
														"</span>";
												}
								
									}
							else if (isset($afield[5][8]) && $classent->$afield[5][8] == 4){
											if (isset($afield[5][10]) && strlen($afield[5][10])>0 && $classent->$afield[5][9]==1){
														$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
													echo "<span style=\"".$strsstyle."\">".
														genInput('txtbox',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',30,(isset($afield[5][11])?$classent->$afield[5][11]:30),
															'txtbox','','',2,'texto numerico','','',$cont,'','') .
														"</span>";
												}
								
									}
							else {
//								die("hiola");
/*   echo "<pre>";
print_r($classent);
die();  */ 

									
									if (isset($afield[5][10]) && strlen($afield[5][10])>0 && $classent->$afield[5][9]==1){
											$strsstyle="background-color:#D7E3BB;border: 1px solid  #EEEEEE;";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										
										if($classent->cve_clas == 2){
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";
										echo "<span style=\"".$strsstyle."\">".
											genInput('textarea',$name_obj."@!".$afield[5][10],$classent->$afield[5][10],'',$classent->size,$classent->maxlen,
												'textarea','','',0,'texto adicional','','',$cont,'','') .
											"</span>";	
										}
											
									}
							}
							echo genCCol();
					}else{echo genCol(getDescript($classind->$afield[0],${$afield[5][0].$classent->$afield[5][7]},${$afield[5][1].$classent->$afield[5][7]}),'','','','',$afield[8],'',$CFG_LBL[30]);}
					
					
				//print_r($classent->maxlen);
				//die();	
					
				break;
				case 'text':
				
						if ($afield[6]=='money'){
							$classind->$afield[0]=number_format(str_replace(array('$',','),array('',''), $classind->$afield[0])*1,  2, '.', '');
						}
						
						// $validini = '', $strvalid = '', $id = '0', $onBlurAdd = '', $strAdd = '', $ob = 0
						if ($afield[4]==1){
							 echo genCol(genInput(
										$afield[3],//$tipo,
										$name_obj."@!".$afield[0],//nombre
										((strlen($classent->$afield[0])==0 && $afield[5]==1)?$afield[7]:($afield[5]==2?$afield[7]:$classent->$afield[0])),//valor
										'',//mascara
										$afield[9],//tamaño
										(($afield[10]==0)?'250':$afield[10]),//longitud
										'txtbox',//estilo
										(($afield[10]==0)?'readonly':''),//habilidado o deshabilitado
										'',//seleccionado
										($afield[6]=='date'?'1':($afield[6]=='int' || $afield[6]=='money'?'2':($afield[6]=='email'?'5':($afield[6]=='nombre'?'7':($afield[6]=='ip'?'10':'0'))))),//$intobj
										($afield[6]=='date'?$frmname:$afield[1]),//$upname
										($afield[6]=='int' || $afield[6]=='money'?$afield[7]:''),//$validini 
										'',//$strvalid
										$cont,//$id
										(isset($afield[15])?$afield[15]:''),//$onBlurAdd
										(isset($afield[24])?$afield[24]:'')// $strAdd
									),
							//
								(isset($afield[14])?$afield[14]:''),
								'',
								'',
								$bgstyle,
							 	(isset($afield[14])?'':$awidths[2]))." \n";
							
							

								
						}else{$strFieldValue=str_replace("\n","<br/>",$classent->$afield[0]); echo genCol($strFieldValue,(isset($afield[14])?$afield[14]:''),'','',(isset($afield[21]) && strlen($afield[21])>0)?
														((isset($a_filed_bg_color) and sizeof($a_filed_bg_color)>0 and in_array($afield[0],$a_filed_bg_color) and $boolSetColor)?$strSetColor:$afield[21]):
								(isset($a_alertas) and (in_array($afield[0],$a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1])?$a_bg_alertas[$afield[0]][2]:''), '40%','',(isset($afield[22]) && strlen($afield[22])>0)?
								$afield[22]:(($afield[6]=='money' or $afield[6]=='int')?
									$CFG_LBL[45]:(($afield[6]=='date' or $afield[6]=='email')?
										$CFG_LBL[41]:$CFG_LBL[30])));}
						break;
				case 'check':
					if ($afield[4]==3){
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
					
						$strFieldValue=$classent->$afield[0];
						$strFieldValue=str_replace("\n","<br/>",$strFieldValue);
						if (isset($afield[23]) and strlen(trim($afield[23]))>0){eval("\$strFieldValue=".$afield[23].'('.$classent->$afield[0].');');}
						echo genCol($strFieldValue,'','','',(isset($afield[21]) && strlen($afield[21])>0)?
														((isset($a_filed_bg_color) and sizeof($a_filed_bg_color)>0 and in_array($afield[0],$a_filed_bg_color) and $boolSetColor)?$strSetColor:$afield[21]):
								(isset($a_alertas) and (in_array($afield[0],$a_alertas) && $classent->$afield[0] > $a_bg_alertas[$afield[0]][1])?$a_bg_alertas[$afield[0]][2]:''),$afield[8],'',
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
		echo genORen().genCol(genOTable('0','100%','','','','3','0','left').genORen()
			 .'<button id="submit" class="btn btn-success" type="submit" alt="Guardar Registro" border="0" name="submit" value="Guardar"> 
			 <i id="ocultar_load" class="fa fa-upload"></i> Guardar</button>'.
			 genInput('hidden','op','1').
			 genInput('hidden','nivPo',(strlen($__SESSION->getValueSession('niv'))>0)?$__SESSION->getValueSession('niv'):'0').
			 genInput('hidden','sel','0').
			 genInput('hidden','btnGuardaDetalleMD','btnGuardaDetalleMD','','','','').
			 genCCol().
			 '<a id="" class="btn btn-danger" href="/ecei/index.php?op=1&amp;btnCancela=btnCancela">Cancelar&nbsp;<i class="fa fa-window-close"></i></a>'.
			 genCCol().genCRen().genCTable(),'70','','',"#FFFFFF",'','',$CFG_LBL[5],'','valign="bottom" ').genCRen()." \n";
		echo "</form>";
		echo genCTable();
		echo genCCol().genCRen().genCTable();
		


/* echo genCTable().genCCol().genCRen();
		echo genORen().genCol(genOTable('0','100%','','','','3','0','left').genORen()
				.genOCol('','','','','35','',$CFG_LBL[16],'',"valign=\"bottom\" onMouseOver=\"this.style.backgroundColor='".
						 $CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			 genInput('hidden','op','1').
			 genInput('hidden','nivPo',(isset($_SESSION['SYS_ECEI']['niv']) && strlen($_SESSION['SYS_ECEI']['niv'])>0)?$_SESSION['SYS_ECEI']['niv']:'0').
			 genInput('hidden','sel','0').
			 genInput('hidden','btnGuardaDetalleMD','btnGuardaDetalleMD','','','','').
			 "<input type=\"image\" alt=\"Guardar Registro\" src=\"img/img07.gif\" border='0' name=\"submit\" value=\"0\"". "> \n".
			 genCCol().
			 genOCol('','','','','35','',$CFG_LBL[16],'',"valign=\"bottom\" onMouseOver=\"this.style.backgroundColor='".
			$CFG_BGC[12]. "'; "."\" onMouseOut=\"this.style.backgroundColor='';\"").
			 "<a href=\"".$_SERVER['PHP_SELF']."?op=1&btnCancela=btnCancela\" ><div style=\"font-size:8px; text-decoration:none;\" ><img src=\"img/img08.gif\" alt=\"Cancelar\" border=\"0\"/></div></a>".
			 genCCol().genCRen().genCTable(),'70','','',$CFG_BGC[1],'','',$CFG_LBL[5],'','valign="bottom" background="img/bg05.jpg"').genCRen()." \n";
		echo "</form>";
		echo genCTable();
		echo genCCol().genCRen().genCTable(); */


			/* $btnInput = 'btnActualiza';
            $lblInput = 'Guardar';
            $strimg = 'img07';
            $strHiden = "";
            foreach ($keyFields as $cont => $item) {
                if (!in_array($item, $arreglo_hidden_label)) {
                    $strHiden.=genInput('hidden', $item, $a_keyValFields[$cont]);
                }
            }

            echo '          
            <div class="card"><div class="form-group row" style="padding:.5rem .5rem .5rem 1rem; margin-bottom: 0rem;">
                          <div class="col-12 col-sm-12">'
            . $strHiden . $strFieldsInput .
            genInput('hidden', 'op', '1') .
            genInput('hidden', 'nivPo', ((strlen($__SESSION->getValueSession('niv')) > 0) ? $__SESSION->getValueSession('niv') : '0')) .
            genInput('hidden', 'sel', '0') .
            genInput('hidden', $btnInput, $btnInput) .
            "<button id=\"submit\" class=\"btn btn-success\" type=\"submit\" alt=\"" . $lblInput . "\" border='0' name=\"submit\" value=\"Guardar\"" . " $vars_obj>Guardar&nbsp;<i id='ocultar_load' class='fa fa-upload'></i></button>&nbsp;" .
            "<a id=\"\" class=\"btn btn-danger\" href=\"" . $_SERVER['PHP_SELF'] . "?op=1&btnCancela=btnCancela\" >" . "Cancelar&nbsp;<i class='fa fa-window-close'></i>" . "</a>" .
            '</div>
                      </div>
                      </div>';	 */

		
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