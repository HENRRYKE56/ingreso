<?php 
$str_check=FALSE;
include_once("sb_ii_check.php");
//echo $_SERVER['PHP_SELF'].$str_check.'hola'; die();
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
$tabla='sb_perfil_modulo,sb_modulo';
$strWhere="Where sb_perfil_modulo.cve_perfil=".$__SESSION->getValueSession('cveperfil');
$strWhere.=" and sb_perfil_modulo.cve_modulo=".$__SESSION->getValueSession('mod');
$strWhere.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
$strWhere.=" and sb_modulo.sta_modulo<>0";
$classval = new Entidad($allf,$allv);
$classval->Consultar($allf,$IdPrin,$tabla,$strWhere);
$str_valmodulo="MOD_NOVALIDO";
if ($classval->NumReg>0){
	$str_valmodulo="MOD_VALIDO";
	$a_key=explode(',',$classval->key_modulo);
	$a_search=array();
	$a_search[0]=array('file_name');
	$a_search[1]=array('Nombre');
	$a_search[2]=array('text');
	$field=array();
	$allf=array();
	$allv=array();
	/*$field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
	'3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
	'5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
	'10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered);*/
	$entidad='IMAGENES CORRUSEL';
	$id_prin='id_ima_carousel';
	$strWhere="Where ";
	$a_order=array('id_ima_carousel desc');
/******inicia condicion de busqueda*/
						if ($__SESSION->getValueSession('valSearch')<>""){
							foreach($a_search[0] as $cont_search => $itemTmpSearch){
								if($__SESSION->getValueSession('itemSearch')==$itemTmpSearch){
									if ($strWhere<>"Where ")
										$strWhere.=" and ";
									if($a_search[2][$cont_search]=='num'){
										$strWhere.=$__SESSION->getValueSession('itemSearch')." = ".($__SESSION->getValueSession('valSearch')*1);
									}else{
										$strWhere.='upper('.$__SESSION->getValueSession('itemSearch').") like upper('%".trim($__SESSION->getValueSession('valSearch'))."%')";
									}
									break;
								}
							}
						}
			/******termina condicion de busqueda*/
                      //        die("234523556  4554 ");    
        $a_key_session_usuario = $__SESSION->getValueSession('cveusuario');
        $a_key_session_id = ((session_id() <> "") ? session_id() : rand(5642, 9826));               
        
        $orden_val=array(1,2,3,4,5);
        $orden_des=array('1','2','3','4','5');
                                                
	if ($strWhere=="Where ")
		$strWhere="";
	//$strWhere.=" prioridad.estado <> FALSE";
	//$items0='perfil.*';
	$tablas_c='sb_carousel';
        $tabla='sb_carousel';
	$strDistintic="SELECT count(*) as count_r  FROM ".$tablas_c." ".$strWhere;
	$intlimit=8;
	$a_separs=array();
	$a_separs[]=array(0,'Datos',9,'bg-dark');
	$field[]=array('id_ima_carousel','id_ima_carousel','1','label','0','','int',0,100,20,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),5);
        if (($__SESSION->getValueSession('opc') == 2 ) || isset($_POST['btnGuarda'])) {
            $field[]=array('file_name','Archivo 1089x451','1','file','1','','char',null,200,83,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo');  
        }else{
            if (($__SESSION->getValueSession('opc') == 3 ) || isset($_POST['btnActualiza'])) {
                $field[]=array('file_name','Archivo','1','text','2','','char',null,200,83,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo'); 
            }else{
                $field[]=array('file_name','Archivo','1','f_archivo','1','','char',null,200,83,2,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),5,'',0,'Archivo'); 
            }
        }
        
        $field[]=array('ruta','Ruta','1','text','2','','char',"images/carousel/",200,100,90,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));       
        $field[] = array('orden', 'Orden', '1', 'select', '1', array($orden_val, $orden_des), 'int', '', 50, 20, 5, '', 1, array(1,'col-12 col-md-12','col-12 col-md-6'), array(1, 1, 6));
        $field[] = array('id_session', 'id_session', '1', 'hidden', '1', '', 'char', $a_key_session_id, 35, 20, 30, '', 0, 1, 3, '', 0, '');
        $field[] = array('cve_agrego', 'usuario', '1', 'hidden', '1', '', 'char', $a_key_session_usuario, 100, 20, 30, '', 1);        
	$field[]=array('estatus','Status','1','check','1','','int',"",100,200,0,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6),'',1);
        $field[]=array('href','Link','1','text','1','','char',"",200,100,90,'',0,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));   
        $field[]=array('desc_ima','Descripcion alt','1','text','1','','char',"Descripcion",200,100,90,'',1,array(1,'col-12 col-md-12','col-12 col-md-6'),array(1,1,6));  
	$setdel='';
	$keyFields=array('id_ima_carousel');
	$keyTypeFields=array('num');	//int,text
	$array_noprint_ent=array('id_ima_carousel','id_session','cve_agrego');
	$rwitem='null';
	$suma_width=0;
	$strwentidad="entidad35.php";
	$ent_add="addentidad0002.php";
	$ent_upd="updentidad0002.php";	
	$boolNoEditable=FALSE;
        $boolNoDelete=TRUE;

	$strSelf="i_carousel.php";
       $no_guardar=true;

	$suma_width=0;
	$numcols=0;
	foreach ($field as $afield){
		if ($afield[2]=='1'){
			$suma_width+=$afield[8];
			$numcols+=1;
		}
	}
	$awidths=array('300','250','650');        
	}
} else{
	include_once("../config/cfg.php");
	include_once("../lib/lib_function.php");
	include_once("sb_ii_refresh.php");
}
function fnValidBeforeAdd(){
    global $msg;
    
    if(isset($_FILES['file_name'])){

    $tipo_ar=$_FILES['file_name']["type"];
    $tipo_ar=  explode("/", $tipo_ar);
if ($_FILES['file_name']["error"] > 0){
    $msg='123';
}else if($tipo_ar[0]=='image'){
    move_uploaded_file($_FILES['file_name']['tmp_name'],$_POST['ruta']."" . $_FILES['file_name']['name']);    

}else{
    $msg='123';
}
}
    
    
}
function fnValidBeforeUpd(){
    fnValidBeforeAdd();
}
?>