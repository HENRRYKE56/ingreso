<?php
session_start();
$str_check=TRUE;
//include_once("includes/iv_check.php");
if ($str_check) {
//			echo "<pre>";
//			print_r($_POST);
//			die();
include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$strMsgErrorAll=array();
$strMsgErrorAll[]="NO se encontraron coincidencias ";
$a_vals=explode("::",trim($_POST['varval']));
$objInclude=array();

$objInclude[1]="sb_modulo_light";
$objInclude[2]="i_asistencia_light";


include_once("includes/".$objInclude[$_POST['numAdd']].".php");

if (isset($_POST['btnGuardaLight'])) {

				$allfields=array();
				$allvalues=array();
				foreach ($field as $afield){
					$allfields[]=$afield[0];
					$allvalues[]=$afield[7];
				}

	//if($findSubmit==1){
	   //Logica para adicionar un registro
		//if (trim($a_key[0])=='100'){
			include_once("config/cfg.php");
			include_once("lib/lib_pgsql.php");
			include_once("lib/lib_entidad.php");
			$classent = new Entidad($allfields,$allvalues);
			$avalues=array();
			$afields=array();
			$atypes=array();
			$str_msgval='';
			$msg='0';
			//$_SESSION['msgval']=NULL;
			//destroy_session('msgval');
			foreach ($field as $contField=>$afield){
				if (($afield[3]=='text' || $afield[3]=='select') && $afield[12]=='1') {
					if (strlen(trim($_POST[$afield[0]]))==0 or ($afield[3]=='select' && $_POST[$afield[0]]==-1)){
						if (strlen($str_msgval)>0){$str_msgval=$str_msgval.',';}
							$str_msgval=$str_msgval.$contField;
							$msg='010';
					}
				}
			}
			
//			
			if (isset($keyFieldsUnique)){
				$consulWhere="";
				$a_valiniUnique=array();
				foreach ($keyFieldsUnique as $countUnique => $itemUnique){
					if(strlen($consulWhere)>0)
						$consulWhere.=" and ";
					if ($keyTypeFieldsUnique[$countUnique]=='num'){
						$a_valiniUnique[]=0;
						$consulWhere.= $itemUnique ."=".$_POST[$itemUnique];
					}else{
						$a_valiniUnique[]='';
						$consulWhere.= $itemUnique ."='".$_POST[$itemUnique]."'";
					}
				}
				$classconsul = new Entidad($keyFieldsUnique,$a_valiniUnique);
				$consulWhere=" where ". $consulWhere;
				$classconsul->ListaEntidades(array(''),$tabla,$consulWhere,'','no');
				if ($classconsul->NumReg > 0){
					$msg='008';
				}
			}
//			echo "<pre>";
//			print_r($classconsul);
//			die();
			if (strlen(trim($str_msgval))==0 && strlen(trim($msg))==1) {
				foreach ($field as $afield){
					$item=$afield[0];
					if ($afield[3] <> 'select' or ($afield[3]=='select' && $_POST[$item]<>'-1')){
					if ($afield[4]=='1' || $afield[4]=='2'){
//						$item=$afield[0];
						if(strlen(trim($_POST[$item]))>0){
							if ($afield[3]=='date2'){
								$last_day_of_month = date( "d", mktime(0, 0, 0, $_POST['cmbmes'] + 1, 0, $_POST['cmbaaa'])) ;
								$avalues[]=$_POST['cmbaaa'].'-'.$_POST['cmbmes'].'-'.$last_day_of_month;
							} else{
								if ($afield[3]=='check'){
									$avalues[]=isset($_POST[$item])?$_POST[$item]:0;
								} else {
									$avalues[]=$_POST[$item];
								}
							}
							$afields[]=$afield[0];
							$atypes[]=$afield[6];
						}
					}}}	
	
	
				//para entidad normal
				$classent->Set_Entidad($avalues,$afields);
				$classent->Adicionar($avalues,$afields,$atypes,$tabla);
				$msg='000';
			}
		//}
	//}
}
if (isset($_POST['btnActualizaLight'])) {
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";   die();
	//if($findSubmit==1){
	   //Logica para actualizar la informacion de un registro
	   //if (trim($a_key[1])=='100'){
				$allfields=array();
				$allvalues=array();
				foreach ($field as $afield){
					$allfields[]=$afield[0];
					$allvalues[]=$afield[7];
				}
			include_once("config/cfg.php");
			include_once("lib/lib_pgsql.php");
			include_once("lib/lib_entidad.php");
			$classent = new Entidad($allfields,$allvalues);
			$avalues=array();
			$afields=array();
			$atypes=array();
			$msgval='';
			$msg='0';
			//$_SESSION['msgval']=NULL;
			//destroy_session('msgval');
			foreach ($field as $contField=>$afield){
				if (($afield[3]=='text' || $afield[3]=='select') && $afield[4]=='1' && $afield[12]=='1'){
				
					if (strlen(trim($_POST[$afield[0]]))==0){
						if (strlen($msgval)>0)
							$msgval=$msgval.',';
							$msgval=$msgval.$contField;
					}
				}
			}
			if (function_exists('fnValidBeforeUpd')){
					fnValidBeforeUpd();
			}
			
			if (strlen($msgval)==0 && strlen(trim($msg))==1) {
				foreach ($field as $afield){
					if ($afield[4]=='1' and !in_array($afield[0],$keyFields)){
		//				$item=$afield[0];
		//				$avalues[]=$_POST[$item];
						$item=$afield[0];
						if ($afield[3]=='date2'){
							$last_day_of_month = date( "d", mktime(0, 0, 0, $_POST['cmbmes'] + 1, 0, $_POST['cmbaaa']));
							$avalues[]=$_POST['cmbaaa'].'-'.$_POST['cmbmes'].'-'.$last_day_of_month;
						} else{
							if ($afield[3]=='check'){
								$avalues[]=isset($_POST[$item])?$_POST[$item]:0;
							} else {
								if ($afield[3] <> 'select' or ($afield[3]=='select' && $_POST[$item]<>'-1')){ 
									$avalues[]=$_POST[$item].(isset($a_datos_registro)&& in_array($item,$a_datos_registro)?$astr_datos_registro[$item]:'');
								}else{
									$avalues[]='';
								}
							}
						}
						$afields[]=$afield[0];
						$atypes[]=$afield[6];
					}
				}
					//
			
				if($_POST['numAdd']==2){
					$strConUpd=$_POST['numpar'];
				}
				else{
					$strConUpd="";
										$key_fields_upd=$keyFields;
										if(isset($keyFields_aux))$key_fields_upd=$keyFields_aux;
						foreach ($key_fields_upd as $cont => $item){
							if (strlen($strConUpd)>0) 
								$strConUpd.=" and ";
							switch ($keyTypeFields[$cont]){
								case 'text':
									$strConUpd.=$item."='".$_POST[$item]."'";
								break;
								case 'num':
									$strConUpd.=$item."=".$_POST[$item];
								break;
							}
						}
				}
				//$classent->Set_Item($id_prin,$$id_prin);
				
				$classent->Set_Entidad($avalues,$afields);
				$classent->Modificar($avalues,$afields,$atypes,$tabla,$strConUpd);
                      
				if (function_exists('fnImplementInUpd')){
					fnImplementInUpd();
			}
				//$msg='000004';
//			echo "<pre>";
//			print_r($classent);
//			echo "</pre>";

			} 
		//}
	//}
}
//die();
//	include_once("config/cfg.php");
//	include_once("lib/lib_function.php");
//	include_once("includes/i_refresh.php");
include_once((isset($cntnt_lst))?$cntnt_lst:"content_lst.php");
if (isset($msg) && strlen($msg)>1){
		$str_msg_red="";
		$i_intstyle=19;
		$i_intcolor=6;
		for ($i=0; $i<(strlen($msg)/3);$i++){
			if (strlen($str_msg_red)>0)
				$str_msg_red.=',&nbsp;&nbsp;';
			$str_msg_red.=$CFG_MSG[(substr($msg,$i*3,3)*1)];
		}
		include("includes/i_msg_red.php");
}
}
?>
