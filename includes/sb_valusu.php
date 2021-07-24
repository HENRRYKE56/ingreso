<?php 
//session_start();
include_once("lib/lib_function.php");
include_once("config/cfg.php");
$str_session='SIN_SESSION';
$field=array();
/*$field[]=array('0 - nombre','1 - tabla',
'2 - posicion en el registro','3 - valor inicial'*/
$field[]=array('cve_usuario','usuario','1',0);
$field[]=array('nom_usuario','usuario','0',"");
$field[]=array('des_usuario','usuario','1',"");
$field[]=array('sta_usuario','usuario','1',"");
$field[]=array('cve_perfil','perfil','0',0);
$field[]=array('des_perfil','perfil','1',"");
$field[]=array('sta_perfil','perfil','1',"");
$allf=array();
$allv=array();
//$_SESSION['user']='alex';
//$_SESSION['pwd']='123';
//$_SESSION['perfil']='500';
foreach ($field as $afield){
	$allf[]=$afield[0];
	$allv[]=$afield[3];
}
$IdPrin='';
foreach ($field as $afield)
	if($afield[2]=='0'){
		$IdPrin=$afield[0];
		break;
	}
//	echo session_name()."<br>";
//	echo session_id()."<br>";
//	foreach($_SESSION as $k => $v) echo($k."=".$v."<br>");
//if (isset($_SESSION['nomusuario']) && isset($_SESSION['passwd']) && isset($_SESSION['cveperfil'])) {
	if ($__SESSION->getValueSession('nomusuario')<>"" && $__SESSION->getValueSession('passwd')<>"" && $__SESSION->getValueSession('cveperfil')<>"") {	
			include_once("lib/lib_pgsql.php");
			include_once("lib/lib_entidad.php");
		if (fnIdentifySession($__SESSION->getAll())){
			$$IdPrin=$__SESSION->getValueSession('nomusuario');
			$pwd=$__SESSION->getValueSession('passwd');
			$perfil=$__SESSION->getValueSession('cveperfil');
			$tabla='sb_usuario,sb_perfil_usuario,sb_perfil';
			$strWhere="Where sb_usuario.nom_usuario='".$$IdPrin."'";
			$strWhere.=" and sb_usuario.sta_usuario <> 0";
			$strWhere.=" and sb_usuario.passwd = '".$pwd."'";
			$strWhere.=" and sb_usuario.cve_usuario = sb_perfil_usuario.cve_usuario";
			$strWhere.=" and sb_perfil.cve_perfil = sb_perfil_usuario.cve_perfil";
			//$strWhere.=" and sb_perfil_usuario.cve_perfil = sb_perfil.cve_perfil";
			$strWhere.=" and sb_perfil.cve_perfil = ".$perfil;
			$strWhere.=" and sb_perfil.sta_perfil <> 0";
			$classval = new Entidad($allf,$allv);
			$classval->Set_Item($IdPrin,$$IdPrin);
			$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
			if ($classval->NumReg>0){
				$str_session='SESSION_OK';
//				echo genOTable(0,'','','',$CFG_BGC[6],'2','1'); /*,'right'*/
//				foreach ($allf as $item)
//								echo genORen().genCol($item . " :",'','','',$CFG_BGC[7],'','',$CFG_LBL[1]).
//									 genCol($classval->$item,'','','',$CFG_BGC[4],'','',$CFG_LBL[1]).genCRen()." \n";
//				echo genCTable(); die();
			}
		}
	}else{$str_session='SIN_DATOS';}
//}else{$str_session='SIN_DATOS';}
// Destruye todas las variables de la sesi&oacute;n
//$_SESSION = array();
// Finalmente, destruye la sesi&oacute;n
//session_destroy();
//if (!session_is_registered('user')){
function fnIdentifySession($obj){
		$retVal=false;
		$classent = new Entidad(array('idmax'),array(0));
		$classent->Consultar(array('idmax'),'','','',"Select max(cve_audit_session) as idmax from sb_audit_session where cve_usuario=".$obj['cveusuario'] . 
													" and cve_perfil=".$obj['cveperfil'] . " and id_session='".session_id()."'");
		$xCveSession=($classent->idmax==""?0:$classent->idmax);
		$classent = new Entidad(array('status_session'),array(0));
		$classent->Consultar(array('status_session'),'','','',"Select status_session from sb_audit_session where cve_audit_session=".$xCveSession);
		if ($classent->status_session==1)
			$retVal=true;
		return $retVal;
}
?>