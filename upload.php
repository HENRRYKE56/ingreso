<?php session_start();
$output_dir = "uploads/";
if(isset($_FILES["myfile"]))
{
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");

	$ret = array();
	
//	This is for custom errors;	
/*	$custom_error= array();
	$custom_error['jquery-upload-file-error']="File already exists";
	echo json_encode($custom_error);
	die();
*/
	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 		//move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
		if(sizeof($_FILES)>0 and $_FILES['myfile']["error"] == "0"){
				$avalues=array($__SESSION->getValueSession('cveusuario'));//,$_POST['tipo_documento']
				$afields=array('cve_usuario');//,'tipoDocumento'
				$atypes=array('char');
				$xFieldName='file_name';
				$fileXTmp = $_FILES['myfile']["tmp_name"]; 
				$file_size = $_FILES['myfile']["size"];
				$file_type    = $_FILES['myfile']["type"];
				$file_name  = $_FILES['myfile']["name"];
				if ( $fileXTmp != "none" )
				{
					$fp = fopen($fileXTmp, "rb");
					$contenido = fread($fp, $file_size);
					fclose($fp);									
					
					$avalues[]=$file_type;
					$avalues[]=$contenido;
					$avalues[]=$file_name;
					$afields[]='file_type';
					$afields[]='content_file';
					$afields[]=$xFieldName;
					$atypes[]='char';
					$atypes[]='char';
					$atypes[]='char';
				}
			$classent = new Entidad(array('maxid'),array(0));
			$classent->Set_Entidad(array(0),array('maxid'));
			$classent->Adicionar($avalues,$afields,$atypes,'sb_foto_usuario','REPLACE');
			$a_idfoto=implode('::',array(('cve_usuario='.$__SESSION->getValueSession('cveusuario')),('file_get=img_usuario')));
			$str_print_foto="rowid=" .rand(5642, 9826).'1'.base64_encode($a_idfoto);
    	$ret[]= $fileName;
		}
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }
	
	}
	echo "<img class='img-fluid rounded-circle' src=\"./files/getfoto.php?".$str_print_foto."\">";
	//echo "<img src=\"".$output_dir.$fileName."\">";
   // echo json_encode($ret);
 }
 ?>