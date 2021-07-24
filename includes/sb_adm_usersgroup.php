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
		
		$sel=0;
		$a_search=array();
		$a_search[0]=array('u.nom_usuario','u.des_usuario');
		$a_search[1]=array('Usuario','Descripcion');
		$a_search[2]=array('text','text');
		$field=array();
		$allf=array();
		$allv=array();
	
/*	echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
		
		
		$usergroup_val=array();
		$usergroup_des=array();
		$strPcWhere=" where g.cve_usergroup=". $_SESSION['cveusergroup'];
		//$strPcWhere="";
		$classconsul = new Entidad(array('cve_usergroup','des_usergroup'),array(0,''));
		$classconsul->ListaEntidades(array('des_usergroup'),'usergroup g',$strPcWhere," g.cve_usergroup, g.des_usergroup ",'');
		if($classconsul->NumReg>0){
		for ($i=0; $i<$classconsul->NumReg; $i++) {
			$classconsul->VerDatosEntidad($i,array('cve_usergroup','des_usergroup'));
			$usergroup_val[]=$classconsul->cve_usergroup;
			$usergroup_des[]=$classconsul->des_usergroup;
		}
		}
			
	$per_val=array();
	$per_des=array();
	$per_val[]='';
	$per_des[]='- SELECCIONAR PERFIL -';
	$strPcWhere=" where cve_perfil <>1 ";
	$classconsul = new Entidad(array('cve_perfil','des_perfil'),array(0,''));
	$classconsul->ListaEntidades(array('cve_perfil'),'perfil p',$strPcWhere," p.cve_perfil, p.des_perfil ");
	if($classconsul->NumReg>0){
	for ($i=0; $i<$classconsul->NumReg; $i++) {
		$classconsul->VerDatosEntidad($i,array('cve_perfil','des_perfil'));
		$per_val[]=$classconsul->cve_perfil;
		$per_des[]=$classconsul->des_perfil;
	}	
	}
	
		$servicio_atencion_val=array();
		$servicio_atencion_des=array();
		$servicio_atencion_val[]='0';
		$servicio_atencion_des[]='- SIN SERVICIO -';			
		$classconsul= new Entidad(array('cve_servicio','des_servicio'),array('',''));
		$consulWhere="select sa.cve_servicio, sa.des_servicio from servicio_atencion sa where sa.cve_unidad='".$_SESSION['cveunidad']."'";
		$classconsul->ListaEntidades(array(''),'servicio_atencion','','','no','',$consulWhere);	
	//	$classconsul->VerDatosEntidad(0,array('cve_servicio','des_servicio'));
	if($classconsul->NumReg>0){
		for ($i=0; $i<$classconsul->NumReg; $i++) {
				$classconsul->VerDatosEntidad($i,array('cve_servicio','des_servicio'));
				if ($i==0)$intXTmp004=$classconsul->cve_servicio;
				$servicio_atencion_val[]=$classconsul->cve_servicio;
				$servicio_atencion_des[]=$classconsul->des_servicio;
			
		}
	}
	
//	echo "<pre>";
//print_r($servicio_atencion_val);
//echo "</pre>";
	
		$pcWhere="";
		if($intXTmp004==''){
			$pcWhere="";
		}else{	
			if(isset($_SESSION['opc']) && ($_SESSION['opc']==3 || $_SESSION['opc']==2))
			$pcWhere="Where cve_servicio=".$intXTmp004;
			
			}
	
			$consultorio_val=array();
			$consultorio_des=array();
			$consultorio_val[]='0';
			$consultorio_des[]='- SIN CONSULTORIO -';
			$classconsul = new Entidad(array('cve_consultorio','no_consultorio'),array('',''));
			$classconsul->ListaEntidades(array('no_consultorio'),'consultorios con',$pcWhere);
			if($classconsul->NumReg>0){
			for ($i=0; $i<$classconsul->NumReg; $i++) {
				$classconsul->VerDatosEntidad($i,array('cve_consultorio','no_consultorio'));
				if ($i==0)$intXTmp005=$classconsul->cve_consultorio;				
				$consultorio_val[]=$classconsul->cve_consultorio;
				$consultorio_des[]=$classconsul->no_consultorio;
			}

				}
			if ($_SESSION['opc']==0){
			$str_iconos="<span style=\"color:#356191;font-family:arial; background-color:#FEFFDF;font-size: 11px;line-height:10px;height:11px;border:#A9C472 1px solid;\">".
		"<img alt=' Nuevo ' height='16' width='16' border='0' src='img/img05.gif'> Nuevo  &nbsp; &nbsp; ".
		"<img alt=' Editar' height='16' width='16' border='0' src='img/img02.gif'> Editat   ".
		"</span>";		
		}else if($_SESSION['opc']==3 || $_SESSION['opc']==2){
			$str_iconos="<span style=\"color:#356191;font-family:arial; background-color:#FEFFDF;font-size: 11px;line-height:10px;height:11px;border:#A9C472 1px solid;\">".
		"<img alt=' Guardar ' height='16' width='16' border='0' src='img/img07.gif'> Guardar  &nbsp; &nbsp; ".
		"<img alt=' Cancelar' height='16' width='16' border='0' src='img/img08.gif'> Cancelar   ".
		"</span>";	
		}
		
		/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
		'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
		'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
		'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
		$entidad='- USUARIOS -';
		$id_prin='cve_usuario';
		$strWhere="Where u.cve_usuario=pu.cve_usuario and u.cve_usergroup='".$_SESSION['cveusergroup']."' and p.cve_perfil=pu.cve_perfil ";
		$a_order=array();
		$a_order[]='u.cve_usuario';
	
		$tablas_c='usuario u, perfil_usuario pu, perfil p';
	
		//if ($_SESSION['cveusergroup']>0){
//			if (in_array($_SESSION['cveperfil'],array('507','509','510','511','512'))){
				//$strWhere.="  u.cve_usergroup = ".$_SESSION['cveusergroup'];

//			}else{
//				$strWhere.=" u.cve_usuario=".$_SESSION['cveusuario'];
//			}	
	//	} else {
			//$strWhere.=" 1=2 ";
		//}
		//$strWhere.=" and pu.cve_usuario = u.cve_usuario and pu.cve_perfil = p.cve_perfil and u.cve_usergroup = ug.cve_usergroup";
		

	/******inicia condicion de busqueda*/
				if (isset($_SESSION['valSearch'])){
					foreach($a_search[0] as $cont_search => $itemTmpSearch){
						if($_SESSION['itemSearch']==$itemTmpSearch){
							if ($strWhere<>"Where ")
								$strWhere.=" and ";
							if($a_search[2][$cont_search]=='num'){
								$strWhere.=$_SESSION['itemSearch']." = ".($_SESSION['valSearch']*1);
							}else{
								$strWhere.='upper('.$_SESSION['itemSearch'].") like upper('%".trim($_SESSION['valSearch'])."%')";
							}
							break;
						}
					}
				}
	/******termina condicion de busqueda*/
		if ($strWhere=="Where ")
			$strWhere="";
		//$strWhere.=" prioridad.estado <> FALSE";
		$tabla='usuario';
		$tabla_c_prefix='u.';
		if ($_SESSION['opc']==2 || $_SESSION['opc']==3 || (isset($_POST['op']) && $_POST['op']==1)){
			if ($_SESSION['opc']==3){
			$items1=" and u.cve_usuario=pu.cve_usuario and u.cve_usergroup='".$_SESSION['cveusergroup']."' and p.cve_perfil=pu.cve_perfil";
					$items0='select u.cve_usuario, u.nom_usuario, u.des_usuario, u.cve_usergroup, u.sta_usuario, u.email, u.adv_email, u.adv_asigna, u.cve_servicio, u.cve_consultorio, pu.cve_perfil, p.cve_perfil, p.des_perfil'.
					' from usuario u, perfil_usuario pu, perfil p ';

			}
			
			}else{
		$items0=' u.cve_usuario, u.nom_usuario, u.des_usuario, u.cve_usergroup, u.sta_usuario, u.email, u.adv_email, u.adv_asigna, u.cve_servicio, u.cve_consultorio, pu.cve_perfil, p.cve_perfil, p.des_perfil';
		}
		
		$strDistintic="SELECT count(*) as count_r FROM ".$tablas_c." ".$strWhere;
		$intlimit=20;
		$a_separs=array();
		$a_separs[]=array(1,'Datos Generales',4,$CFG_BGC[10]);
	
		//$a_separs[]=array(2,'EL USUARIO DEBE ENPEZAR POR LA CLUE DE LA UNDIAD SEGUIDO POR UN NUMERO QUE IDENTIFICARA LA CUENTA',4,$CFG_BGC[7]);
//	echo "<pre>";
//print_r($per_val);
//echo "</pre>";
		
	if ($_SESSION['opc']==2  || $_SESSION['opc']==3 || isset($_POST['btnActualiza']) || isset($_POST['btnGuarda'])){	
		
		$field[]=array('cve_usuario','Clave','2','hidden','0','','int',0,50,20,0,'',0,1,4);
		
		//$field[]=array('nom_usuario','Usuario','1','hidden','0','','char','',50,20,10,'',0,1,array(1,1,0));
		//$field[]=array('nom_usuario','Usuario','1','text','2','','char',"MCSSA002720-",100,100,16,'',1,1,array(1,1,4));
		$field[]=array('des_usuario','Descripcion de Cuenta','1','text','1','','char',"",400,100,60,'',1,1,array(1,1,4));
		if (isset($_POST['btnActualiza']) && isset($_POST['passwd']) && strlen(trim($_POST['passwd']))>0 ){	
			$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',1,1,array(1,1,4));
		}else{
			if ($_SESSION['opc']==2 || isset($_POST['btnGuarda'])){
				$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',1,1,array(1,1,4));
			}else{
				if ($_SESSION['opc']==3){
					$field[]=array('passwd','Contrase&ntilde;a','1','text','1','','char',"",100,100,16,'',0,1,array(1,1,4));
				}
			}
		}
		
		$field[]=array('cve_usergroup','unidad','1','select','2',array($usergroup_val,$usergroup_des),'int',0,200,20,2,'',1,1,array(1,1,4));
		$field[]=array('sta_usuario','Status','1','check','1','','char',"",100,200,0,'',1,1,array(1,1,4));;
		$field[]=array('id_session','id_session','2','hidden','2','','char',((session_id()<>"")?session_id():rand(5642, 9826)),35,20,0,'',0,1,3,'',0,'');
		$field[]=array('cve_agrego','agrego','2','hidden','2','','char',$_SESSION['cveusuario'],100,20,0,'',1);
		if (isset($_SESSION['opc']) and ($_SESSION['opc']==2 or $_SESSION['opc']==3) ){	
			$field[]=array('cve_perfil','Perfil','1','select','2',array($per_val,$per_des,0,'onChange="funval();"'),'int',0,200,20,4,'',1,1,array(1,1,4));	
		}
		
		$field[]=array('cve_servicio','especialidad:','1','select','2',array($servicio_atencion_val,$servicio_atencion_des,0,' onChange="getSelectXiniX(\'cve_consultorio\',\'content_cmb7\',0,0,\'cve_servicio\');"'),'int',0,100,50,50,'',0,1,array(1,1,4));
		$field[]=array('cve_consultorio','Consultorio:','1','select','2',array($consultorio_val,$consultorio_des),'int',0,100,50,50,'',0,1,array(1,1,4));
	
	}else{
		$field[]=array('cve_usuario','Clave','2','hidden','2','','int',0,50,20,0,'',1,1);
		$field[]=array('nom_usuario','Usuario','1','text','2','','char',"MCSSA002720-",100,100,16,'',1,1,4);;
		$field[]=array('des_usuario','Descripcion de Cuenta','1','text','1','','char',"",200,100,60,'',1,1,4);
		$field[]=array('cve_perfil','Perfil','1','select','2',array($per_val,$per_des),'int',0,200,20,2,'',1,1,5);	
		$field[]=array('cve_usergroup','unidad','1','select','2',array($usergroup_val,$usergroup_des),'int',0,200,20,2,'',1,1,4);
		$field[]=array('sta_usuario','Status','1','check','1','','char',"",100,200,0,'',1,1,4);
	
		$field[]=array('cve_servicio','especialidad:','1','select','2',array($servicio_atencion_val,$servicio_atencion_des,0,' onChange="getSelectXiniX(\'cve_consultorio\',\'content_cmb5\',0,0,\'cve_servicio\');"'),'int',0,100,50,50,'',0,1,3,'');
		$field[]=array('cve_consultorio','Consultorio:','1','select','2',array($consultorio_val,$consultorio_des),'int',0,100,50,50,'',0,0,1,'',0,'Consultorio');
	}
		


//		$field[]=array('email','e-mail','1','text','1','','email',"",100,60,60,'',0);
//		$field[]=array('adv_email','avisos e-mail','1','check','1','','char',"",100,200,0,'',0);
		//$field[]=array('adv_asigna','avisos asignacion','1','check','1','','char',"",100,200,0,'',0);
		$setdel='';
		$keyFields=array('cve_usuario');
		$keyFieldsUnique=array('nom_usuario');
		$keyTypeFieldsUnique=array('text');	//int,text
		$keyTypeFields=array('num');	//int,text
		$array_noprint_ent=array('null');
		$suma_width=0;
	//	$rwitem='';
		$strwentidad="entidad3.php";
		$ent_add="addentidad0002.php";
		$ent_upd="updentidad0002.php";
	//	$boolNoEditable=FALSE;
	//	$boolNoUpdate=FALSE;
		$boolNoDelete=TRUE;
	if($_SESSION['cveperfil']=='515'){
			//$_SESSION['niveles']=array('');
			//$intNivel=1;
	}else{
			$_SESSION['niveles']=array('i_adm_usersgroup.php','i_perfil_usuarios_adm.php');
			$intNivel=1;
	}
		$strSelf="i_adm_usersgroup.php";
	
		$_SESSION['mdKeyFields']=array(array('cve_usuario'));
		$_SESSION['mdFields']=array(array('des_usuario'));
		$_SESSION['mdValFields']=array(array('*'));
		$_SESSION['mdTable']=array('usuario');
		$_SESSION['keyValNiv']=array();
		$_SESSION['keyValNiv'][0]=array('');
		
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


function fnImplementInAdd(){
	
	global $avalues;
	global $afields;
	global $atypes;
	global $msg;
	
	

	
			$intMaxId1=0;
			$classent = new Entidad(array('maxid'),array(0));
			$classent->Set_Entidad(array(0),array('maxid'));
			$classent->Consultar(array('maxid'),'','','',"Select max(cve_usuario) as maxid from usuario where cve_usergroup='".$_SESSION['cveusergroup']."'  and cve_agrego=".$_POST['cve_agrego'] . " and id_session='".$_POST['id_session'] . "'");
			$intMaxId1=$classent->maxid;	
	
			$array_namesxTmp=array('cve_perfil','cve_usuario');
			$array_typetxTmp=array('int','int');
			$array_defaultxTmp=array(' ');
			$array_valuesxTmp=array($_POST['cve_perfil'],$intMaxId1);
			$classent = new Entidad($array_namesxTmp,$array_defaultxTmp);
			$classent->Adicionar($array_valuesxTmp,$array_namesxTmp,$array_typetxTmp,'perfil_usuario');

	
	
	
		
			$intMaxId=1;
			$idactualizar=0;
			$classent = new Entidad(array('maxid'),array(0));
			$classent->Set_Entidad(array(0),array('maxid'));
			$classent->Consultar(array('maxid'),'','','',"Select max(secuencial)+1 as maxid from usuario where cve_usergroup='".$_SESSION['cveusergroup']."' ");



if(strlen($classent->maxid)>0)
			$intMaxId=$classent->maxid;
			
$classent = new Entidad(array('maxid'),array(0));
			$classent->Set_Entidad(array(0),array('maxid'));
			$classent->Consultar(array('maxid'),'','','',"Select max(cve_usuario) as maxid from usuario where cve_usergroup='".$_SESSION['cveusergroup']."'  and cve_agrego=".$_POST['cve_agrego'] . " and id_session='".$_POST['id_session'] . "'");
			
			if(strlen($classent->maxid)>0)
			$idactualizar=$classent->maxid;

/*echo"<pre>";
print_r($intMaxId);
echo"</pre>";
die();	
*/

			$strResult=$_SESSION['cveunidad'].str_pad($intMaxId, 3, "0", STR_PAD_LEFT);
			$array_namesxTmp=array('nom_usuario','secuencial');
			$array_typetxTmp=array('char','int');
			$array_valuesxTmp=array($strResult,$intMaxId);
			$classent->Modificar($array_valuesxTmp,$array_namesxTmp,$array_typetxTmp,'usuario'," cve_usuario=".$idactualizar);

					

		$_SESSION['valAlert']=$strResult;
$msg.='022';
	
}

function fnBeforeLoad(){
	echo'<script language="JavaScript"> funval();  </script>';
}
function fnValidBeforeAdd(){
global $msg;
if (addslashes(trim($_POST['cve_perfil']))==''){
	$_SESSION['valAlert']='perfil de usuario';
	$msg='011';
	return;
	}

if (addslashes(trim($_POST['cve_perfil']))=='513' && addslashes(trim($_POST['cve_servicio']))==''){
	$_SESSION['valAlert']='servicio';
	$msg='011';
	return;
	}
if (addslashes(trim($_POST['cve_perfil']))=='514' && (addslashes(trim($_POST['cve_servicio']))=='-1' || addslashes(trim($_POST['cve_servicio']))=='')){
	$_SESSION['valAlert']='servicio';
	$msg='011';
	return;
	}
	
if (addslashes(trim($_POST['cve_perfil']))=='514' && (addslashes(trim($_POST['cve_consultorio']))=='-1' || addslashes(trim($_POST['cve_consultorio']))=='')){
	$_SESSION['valAlert']='consultorio';
	$msg='011';
	return;
	}
}
?>
<!--codigo para desplazamiento con enter-->
<script language="javascript">
  document.notBussyKeyEnter=true;
  document.reTKey=true;
</script>
<script language="JavaScript">
function getKeyFalse(e){
	document.reTKey=true;
	if(window.event){keynum = e.keyCode;}else if(e.which){keynum = e.which;}
	if(keynum==13) {if (document.notBussyKeyEnter==false){document.reTKey=false;}}}//return reTKey;}
			
</script>
<!--/codigo para desplazamiento con enter-->
<script language="javascript">
function getSelectXiniX(){
	args=getSelectXiniX.arguments; target=args[0]; liga=args[1]; numAdd=args[2]; initialize=args[3];
	var varval=""; var xPos=0;
	for (i=4; i<=(args.length-1); i++) { 
		if (args[i].indexOf("objIni_")==-1 && args[i].indexOf("objGet_")==-1){val=findObj(args[i]);
			if (val) {if ((val=val.value.trim())!="") {
				if (i>4) varval+="::"; varval+=val;
			}else{return;}}else{return;}
		}else{xPos=args[i].indexOf("objIni_"); if (xPos==-1) xPos=args[i].indexOf("objGet_");
			disableSelect(document.getElementById(args[i].substring(xPos + 7)),"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");}
	}
	cadena='';
	cadena='varval=' + varval + '&numAdd=' + numAdd + '&initialize=' + initialize;
	selflink = liga + '.php';
	cargar_xml(target, selflink,cadena);
	for (i=4; i<=(args.length-1); i++) { 
		if (args[i].indexOf("objGet_")!=-1){varval=""; xPos=0; cadena="";
			for (j=4; j<=(args.length-1); j++) { 
				if (args[j].indexOf("objIni_")==-1 && args[j].indexOf("objGet_")==-1){val=findObj(args[j]);
					if (val) {if ((val=val.value.trim())!="") {
						if (j>4) varval+="::"; varval+=val;
					}else{return;}}else{return;}
				}
			}			
			
			xPos=args[i].indexOf("objGet_");
			cadena='varval=' + varval + '&numAdd=' + args[i].substring(0,xPos - 1) + '&initialize=' + initialize;
			cargar_xml(args[i].substring(xPos + 7), selflink, cadena);
		}
	}
}			


function funval(){
	if(document.getElementById('cve_perfil').value ==511 || document.getElementById('cve_perfil').value ==512 || document.getElementById('cve_perfil').value ==515 ){
		document.getElementById('cve_servicio').style.display='none';
		document.getElementById('cve_servicio').value='0';
		document.getElementById('cve_consultorio').style.display='none';
		document.getElementById('cve_consultorio').value='0';
		
	}else if(document.getElementById('cve_perfil').value ==513  ) {
		 document.getElementById('cve_servicio').style.display='';
		 document.getElementById('cve_servicio').value='';
		document.getElementById('cve_consultorio').style.display='none';
		document.getElementById('cve_consultorio').value='0';
		
	}else if(document.getElementById('cve_perfil').value ==514 ) {
		document.getElementById('cve_servicio').style.display='';
		 document.getElementById('cve_servicio').value='';
		document.getElementById('cve_consultorio').style.display='';
		 document.getElementById('cve_consultorio').value='';
	}
	
	
}
</script>