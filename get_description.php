<?php 
session_start();
$str_check=FALSE;
include_once("includes/i_check.php");
if ($str_check) {
	include_once("config/cfg.php");
	include_once("lib/lib_pgsql.php");
	include_once("lib/lib_entidad.php");
	include_once("lib/lib_function.php");
	include_once("rep/lib/lib32.php");
$a_table=array();
$a_table['equipo']=array('equipoe','impresora','regula_nobreak','asesorios','equipo');
$a_lbl=array();
$a_lbl['equipo']='';

//	$field[]=array('cveuni','ID','2','text','1','','char','','e',20,0,'',0,0,0,'','',1,1,1);	
	$field[]=array('num_serie','n&uacute;mero de serie','2','text','1','','char',"",'e',25,0,'',1,1,1,'',0,'sn',0,'','','','','','');		
	$field[]=array('num_inventa','n&uacute;mero de inventario','2','text','1','','char',"",'e',25,0,'',0,0,3,'','num. inventario');
	$field[]=array('des_hw_tipo','tipo de hardware','2','select','1','','int','','e',20,2,'',1,1,5,'','tipo de hardware');
	$field[]=array('des_marca','marca','2','select','1','','int','','e',20, 2, '',1, 1, 2,'','marca');
	$field[]=array('modelo','modelo','2','text','1','','char',"",'e',60,0,'',0,0,2,'','modelo');
//	$field[]=array('desuni','ID','1','label','1','','char','','u',20,0,'',0,0,0,'','',1,1,1);	

$a_fieldsXtmp=array();

$sqlQryFields="select e.num_serie,e.num_inventa,hw.des_hw_tipo,m.des_marca,e.modelo";
$sqlQryFrom=" from hw_tipo hw, marca m";
$sqlQryWhere=" where e.cve_hw_tipo=hw.cve_hw_tipo and e.cve_marca=m.cve_marca ";
$sqlQryOrder=" order by e.cve_hw_tipo";

//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	

//$a_fieldsXtmp['equipo']='num_serie,num_inventa,cve_cp_tipo,cve_marca,modelo,cve_procesador,cve_sys_op,version_so';
//$afields=$a_fieldsXtmp[$_POST['entvalue']];
	$allfields=array();
	$allvalues=array();
	foreach ($field as $afield){
		$allfields[]=$afield[0];
		$allvalues[]=$afield[7];
	}
	$bdate=0;
	$strCondConsul="";
   $classind = new Entidad($allfields,$allvalues);
   $avalues=array();
   $afields=array();
	foreach ($field as $afield){
		if ($afield[4]=='1'){
			$afields[]=$afield[0];
			if (isset($_POST[$afield[0]]) && strlen(trim($_POST[$afield[0]]))>0){
				if (strlen($strCondConsul)>0) 
					$strCondConsul.=" and ";
				switch ($afield[6]){
					case in_array($afield[6],array('char','mail','nombre','ip','date')):
						$strCondConsul.=$afield[8].'.'.$afield[0]." like '%".$_POST[$afield[0]]."%'";
					break;
					case in_array($afield[6],array('int','money')):
						$strCondConsul.=$afield[8].'.'.$afield[0]."=".$_POST[$afield[0]];
					break;
				}
			}
		}
	}
	//$strCondConsul="Where ".$strCondConsul;
//	echo $strCondConsul;
//	echo "<pre>";	
//	print_r($classind);
//	echo "</pre>";	//$classconsul->NumReg; &amp;

$xml  = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';
foreach ($a_table[$_POST['entvalue']] as $tableItem){
	$sqlQry= $sqlQryFields.$sqlQryFrom . ', ' . $tableItem . ' e' .$sqlQryWhere. ' and '. $strCondConsul . $sqlQryOrder;
	$classind->Consultar($afields,$IdPrin,$tableItem,'',$sqlQry);
	$classind->ListaEntidades(array(),$tableItem,"",'','','',$sqlQry,'');
	for ($i=0; $i<$classind->NumReg; $i++) {/////##########################################///////////
		$classind->VerDatosEntidad($i,$afields);
		$xml .= '<elemento>';
		foreach ($field as $cnt_field => $item_field){
			//if ($cnt_field>4) {$xml .=', ';}
			if ($item_field[2]==2){$xml .=$classind->$item_field[0].'@:::@';}else{$xml .= str_replace(array("&",">","<"),array("&amp;","&gt;","&lt;"),$classind->$item_field[0]);}
		}
		$xml .= '</elemento>';
	}
	if ($classind->NumReg > 20) break;
}

$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;		

		/*validaci&oacute;n de cajss de texto*/

} else{
	include_once("config/cfg.php");
	include_once("lib/lib_function.php");
	include_once("includes/i_refresh.php");
}
?>