<?php 
$str_check=FALSE;
include_once("ii_check.php");
if ($str_check) {
	$field[]=array('cve_perfil','perfil_modulo','0',0);

$field[]=array('cve_modulo','perfil_modulo','1',"");
$field[]=array('key_modulo','perfil_modulo','1',"");
$allf=array();
$allv=array();
foreach ($field as $afield){
	$allf[]=$afield[0];
	$allv[]=$afield[3];
}
$IdPrin='';
$tabla='perfil_modulo,modulo';
$strWhere="Where perfil_modulo.cve_perfil=".$_SESSION['cveperfil'];
$strWhere.=" and perfil_modulo.cve_modulo=".$_SESSION['mod'];
$strWhere.=" and perfil_modulo.cve_modulo=modulo.cve_modulo";
$strWhere.=" and modulo.sta_modulo<>0";
$classval = new Entidad($allf,$allv);
$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
$str_valmodulo="MOD_NOVALIDO";
if ($classval->NumReg>0){
	$str_valmodulo="MOD_VALIDO";
	$a_key=explode(',',$classval->key_modulo);
	
	
	$per_val=array();
	$per_des=array();
	$strPcWhere=" where pg.cve_usergroup=". $_SESSION['cveusergroup'] . " and p.cve_perfil=pg.cve_perfil";
	$classconsul = new Entidad(array('cve_perfil','des_perfil'),array(0,''));
	$classconsul->ListaEntidades(array('cve_perfil'),'perfil p, perfil_usergroup pg',$strPcWhere," p.cve_perfil, p.des_perfil ");
	for ($i=0; $i<$classconsul->NumReg; $i++) {
		$classconsul->VerDatosEntidad($i,array('cve_perfil','des_perfil'));
		$per_val[]=$classconsul->cve_perfil;
		$per_des[]=$classconsul->des_perfil;
	}
	
	
	
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	$entidad='PERFIL USUARIO';
	$strSelf="i_perfil_usuarios_adm.php";
	$id_prin='cve_usuario';
	$strWhere="Where";
	$a_order=array();
//	switch ($_SESSION['cveperfil']){
//		case 1:
			$tablas_c='perfil_usuario pu, usuario u';
			$a_order[]=$id_prin;
//			break;
//		case $_SESSION['cveperfil']<>1:
			$strWhere.=" u.cve_usuario=pu.cve_usuario and u.cve_usergroup=".$_SESSION['cveusergroup'];
//			$tablas_c='perfil_usuario';
//			$a_order[]=$id_prin;
//			break;
//	}
	$boolkeyValNiv=TRUE;
	$a_mdLabel=array('Usuario');
	$m_keyFields=array('cve_usuario');
	$m_Table='usuario';
	$m_Fields=array('nom_usuario','des_usuario');
	$m_keyTypeFields=array('num');	//num,text
	$m_TypeFields=array('text','text');	//num,text
	$a_keyValNiv=array();
	
	/*SI EXISTEN IT SE CREA CONDICION*/
	if (isset($_GET['it0'])){
		foreach ($m_keyFields as $cont => $item){
			$a_keyValNiv[]=$_GET['it'.$cont];
			if ($strWhere!="Where")
				$strWhere.=" and ";
				if ($m_keyTypeFields[$cont]=='num'){
					$strWhere.=" pu.".$item."=".$_GET['it'.$cont];
				}
				else{
					$strWhere.=" pu.".$item."='".$_GET['it'.$cont]."'";
				}
		}
		/*asignar el arreglo de valores en el nivel que corresponde*/
		foreach ($_SESSION['niveles'] as $cont => $item){
		//echo $item."|".$strSelf."|".$cont;
			if ($item==$strSelf){
				$_SESSION['mdKeyFields'][$cont]=$m_keyFields;
				$_SESSION['mdKeyTFields'][$cont]=$m_keyTypeFields;
				$_SESSION['mdFields'][$cont]=$m_Fields;
				$_SESSION['mdTFields'][$cont]=$m_TypeFields;
				$_SESSION['mdValFields'][$cont]=$a_keyValNiv;
				$_SESSION['mdTable'][$cont]=$m_Table;
				$_SESSION['keyValNiv'][$cont]=$a_keyValNiv;
				$_SESSION['intSelfNivel']=$cont;
				break;
			}
		}
	} else{
		foreach ($_SESSION['niveles'] as $cont => $item){
			if ($item==$strSelf){
                                                                $_SESSION['intSelfNivel']=$cont;
				if (isset($_SESSION['keyValNiv'][$cont])){
					foreach ($m_keyFields as $contVal => $itemVal){
						if ($strWhere!="Where")
							$strWhere.=" and ";
						if ($m_keyTypeFields[$contVal]=='num'){
							$strWhere.=" pu.".$itemVal."=".$_SESSION['keyValNiv'][$cont][$contVal];
						}
						else{
							$strWhere.=" pu.".$itemVal."='".$_SESSION['keyValNiv'][$cont][$contVal]."'";
						}
						//break;
					}
				}else{
						if (isset($_SESSION['niv']))
							$_SESSION['niv']=NULL;
						echo "<meta http-equiv='refresh' content='0;URL=". $_SERVER['PHP_SELF'] ."'>";
						die();
				}
				break;	
			}
			
		}
	}
	//echo $strWhere;
	if ($strWhere=="Where")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	$items0='pu.cve_usuario, pu.cve_perfil';
	$tabla='perfil_usuario';
	$intWLblEntidad=500;
	$intlimit=1000;
	$a_separs=array();
	$a_separs[]=array(1,'datos generales - solo se permite un perfil por usuario',6,$CFG_BGC[10]);
	$field[]=array('cve_usuario','Usuario','2','label','0','','int',0,50,20,0,'',1,1,5);
	$field[]=array('cve_perfil','Perfil','1','select','2',array($per_val,$per_des),'int',0,700,20,2,'',1,1,5);
	$setdel='';
	$strdistintic="perfil_usuario.cve_usuario, perfil_usuario.cve_perfil";
	
	$keyFields=array('cve_usuario','cve_perfil');
	$keyFieldsUnique=array('cve_usuario');
	$keyTypeFieldsUnique=array('num');	//int,text
	$keyTypeFields=array('num','num');	//int,text
	$array_noprint_ent=array('null');
	$rwitem='null';
	$suma_width=0;
	$strwentidad="md_entidad4.php";
	$boolNoEditable=FALSE;
	$boolNoUpdate=TRUE;
	$boolNoDelete=FALSE;
	
	//$_SESSION['niveles']=array('i_wp_usuario.php');
	//$intNivel=0;
	
	
	$suma_width=0;
	$numcols=0;
	foreach ($field as $afield){
		if ($afield[2]=='1'){
			$suma_width+=$afield[8];
			$numcols+=1;
		}
	}
	$awidths=array('300','150','650');
	//	$str_ent=$PHP_SELF."?ent=i_indicador&id=";
	//	if (isset($_GET['opccal']) && $_GET['opccal']==1)
	//		$str_ent=$PHP_SELF."?opccal=".$_GET['opccal']."&ent=i_proyecto&id=";
	//	}
	}
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("ii_refresh.php");
}
function fnValidateFiatRegistroMD(){
	if ((isset($_GET['it0']) and strlen(trim($_GET['it0']))>0) || (isset($_SESSION['keyValNiv'][1]) && strlen(trim($_SESSION['keyValNiv'][1][0])) > 0)){
		$strWherePrin2='Where cve_usuario='. (isset($_GET['it0'])?$_GET['it0']:$_SESSION['keyValNiv'][1][0]) . " and cve_usergroup=".$_SESSION['cveusergroup'];//valida condicion normalmente de propietario de registro
		$classconsul = new Entidad(array('cont'),array(0));
		$classconsul->ListaEntidades(array('cont'),'usuario',$strWherePrin2,'count(cve_usuario) as cont',"no");
		$classconsul->VerDatosEntidad(0,array('cont'));
		if ($classconsul->cont==0){
			if (isset($_SESSION['niv']))
				$_SESSION['niv']=NULL;
			echo "<meta http-equiv='refresh' content='0;URL=". $_SERVER['PHP_SELF'] ."'>";
			die();
		}
	}else{
			if (isset($_SESSION['niv']))
				$_SESSION['niv']=NULL;
			echo "<meta http-equiv='refresh' content='0;URL=". $_SERVER['PHP_SELF'] ."'>";
			die();
	}
}
?>