<link rel="stylesheet" href="css/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="css/datatables-buttons/css/buttons.bootstrap4.min.css">
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
	$widthEditable=20;
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
$array_key_add=array();


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
		$__SESSION->setValueSession('msg', 0);
        include("includes/sb_msg_bob.php");
	
}

		foreach ($__SESSION->getValueSession('niveles') as $cont => $item){
		//echo $item."|".$strSelf."|".$cont; //die();
			if ($cont >0 ){ 
					$strfields_prin2="";//cambiar los arreglos de session 
					
		
					foreach ($__SESSION->getValueSession('mdFields')[$cont] as $cont2 => $afield){
						if (strlen($strfields_prin2)>0)
							$strfields_prin2.=", ";
						$strfields_prin2.=$afield;
						if ($__SESSION->getValueSession('mdTFields')[$cont][$cont2]=='num'){
							$avalues_prin2[]=0;
						}else{
							$avalues_prin2[]='';
						}
						
					}
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
					
					$strvalcol=(str_repeat('&nbsp;',($cont*2))).'+'.(isset($a_mdLabel)?str_repeat('&nbsp;',2).$a_mdLabel[$cont-1].'&nbsp;':'')
								."<br>".str_repeat('&nbsp;&nbsp;&nbsp;',($cont*2)).str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',4);//
					foreach ($__SESSION->getValueSession('mdFields')[$cont] as $cont2 => $afield){
						if ($cont2>0)
							$strvalcol.= " **** ";//<br>
							
							$str_value_field=($__SESSION->getValueSession('mdTFields')[$cont][$cont2]=='money')?number_format((($classconsul->$afield)*1), 0):$classconsul->$afield;
							if (strlen($classconsul->$afield)>16){$strvalcol.="<span style='text-align:left;width:700;background-color:#F8F9D9; border:1px #A9C472 solid;'>".$str_value_field."</span>";}
						else{$strvalcol.="<span ".(in_array($afield,$keyFields)?("class=\"" . $CFG_LBL[12] . "\" style=\"width:120;border:1px #A9C472 solid; background-color:".$CFG_BGC[21].";\""):"style=\"width:120;border:1px #A9C472 solid; background-color:#F8F9D9;\"")."'>".$str_value_field."</span>";}
					}
					if (isset($astr_MDIcon) and (sizeof($astr_MDIcon)>0))$strvalcol.=$astr_MDIcon[$cont];
				
			}
			if ($item==$strSelf)
				break;
		}
		

/*termina renglon master*/
$impresion='
	  <div class="card">';
		
   
	$impresion.='	<div class="card-header">
		  <h3 class="card-title">'.$entidad.'</h3>
		  '.$strvalcol.'
		</div>';

if (trim($a_key[0])=='100' && !$boolNoEditable && !$boolNoNew){
		$impresion.="<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"> \n";
	
		$impresion.= genInput('hidden','op','1');
		$impresion.= genInput('hidden','nivPo',(strlen($__SESSION->getValueSession('niv'))>0)?$__SESSION->getValueSession('niv'):'0');
		$impresion.= genInput('hidden','btnAddDetalle','btnAddDetalle');

	
		 $impresion.=  "<input type=\"image\" alt=\"Actualizar Registro\"  src=\"img/editar.gif\" border='0'> </form>";
	
}



	$encabezado='';
	
		foreach ($field as $afield)
			if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1')
			$encabezado.='<th>'.(isset($afield[17])?$afield[17]:$afield[1]).'</th>';
				
	 $impresion.='<div class="card-body">
				  	<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>'. $encabezado.'</tr>
						</thead>
						<tbody>';
					echo $impresion;


	
			
	/*terminan titulos*/
	$datos="";
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
	$datos.="<tr>";
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
	

/*fin de col de botones*/
	foreach ($field as $count_fields => $afield){
		if (!in_array($afield[0],$array_noprint_ent) && $afield[2]=='1'){
			$style=$CFG_LBL[30];
			switch ($afield[3]){
			
				default:
					if (isset($afield[18]) && $afield[18]==1){
						$str_implodevalues="";
							foreach ($afield[19][0] as $count_int_aafield => $int_aafield){ 
								if ($count_int_aafield>0)
									$str_implodevalues.=$afield[19][1];
								$str_implodevalues.=$classent->$field[$int_aafield][0];
							}
							echo $str_implodevalues;
						
					} else {
					

					
						$strFieldValue=str_replace("\n","<br/>",$classent->$afield[0]);
						if (isset($afield[23]) and strlen(trim($afield[23]))>0)
						{eval("\$strFieldValue=".$afield[23].'('.$classent->$afield[0].');');}
						$datos.="<td>".($strFieldValue)."</td>";
						
							}
				break;
				}

		}
		
	}
	$datos.="</tr>";
}
echo $datos;
echo' 					</tfoot>
				  </table>
				</div>
				<!-- /.card-body -->
			  </div>
			  <!-- /.card -->
		';

}

?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,autoFill: true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
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