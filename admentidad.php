<?php

include_once("config/cfg.php");
//session_start();
//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	
//	die();

$str_check = FALSE;
include_once("includes/sb_iii_check.php");
if ($str_check) {
    $opc = 0;
    $msg = '0';
    if (isset($_POST['btnAdd'])) {
        $opc = 2;
        if (isset($keyFields0)) {
            $__SESSION->unsetSession('s_keyNameValFields0');

            $a_keyValFields = array();
            foreach ($keyFields0 as $cont => $item) {
                $a_keyValFields[$item] = $_POST[$item];
            }
            $__SESSION->setValueSession('s_keyNameValFields0', $a_keyValFields);
        }
//	echo "<pre>";	
//	print_r($a_keyValFields);
//	echo "</pre>";	die();
        $__SESSION->unsetSession('msgval');
    }
    if (isset($_POST['btnUpd'])) {
        $opc = 3;
        /* <-----incorporar values de fields key a _SESSION------> */
        $__SESSION->unsetSession('s_keyFields');
        $a_keyValFields = array();
        foreach ($keyFields as $cont => $item)
            $a_keyValFields[] = $_POST[$item];
//	echo "<pre>";	
//	print_r($a_keyValFields);
//	echo "</pre>";	die();
        $__SESSION->setValueSession('s_keyFields', $a_keyValFields);
        //$_SESSION['msgval']=NULL;
        $__SESSION->unsetSession('msgval');
    }
    if (isset($_POST['btnUpd2'])) {
        $opc = 4;
        /* <-----incorporar values de fields key a _SESSION------> */
        $__SESSION->unsetSession('s_keyFields');
        $a_keyValFields = array();
        foreach ($keyFields as $cont => $item)
            $a_keyValFields[] = $_POST[$item];
//	echo "<pre>";	
//	print_r($a_keyValFields);
//	echo "</pre>";	die();
        $__SESSION->setValueSession('s_keyFields', $a_keyValFields);
        //$_SESSION['msgval']=NULL;
        $__SESSION->unsetSession('msgval');
    }
    if (isset($_POST['btnAddDetalle'])) {
        $opc = 10;
        /* <-----incorporar values de fields key a _SESSION------> */
        $__SESSION->unsetSession('msgval');
    }
    if (isset($_POST['btnAddDetalle2'])) {
        $opc = 11;
        /* <-----incorporar values de fields key a _SESSION------> */
        $__SESSION->unsetSession('msgval');
    }
	
    if (isset($_POST['btnSearch'])) {
//	echo "<pre>";	
//	print_r($_POST);
//	echo "</pre>";	die();
        /* <-----incorporar value de busqueda a search _SESSION------> */
        if (strlen(trim($_POST['txtsearch'])) > 0) {
            $__SESSION->setValueSession('valSearch', $_POST['txtsearch']);
            $__SESSION->setValueSession('itemSearch', $_POST['selsearch']);
        } else {
            $__SESSION->unsetSession('valSearch');
            $__SESSION->unsetSession('itemSearch');
            $msg = '007';
            $opc = 0;
        }
        if (isset($_POST['chkperiodo'])) {
            $__SESSION->setValueSession('asrchperiodo', array("inicio" => $_POST['txtinicio'], "fin" => $_POST['txtfin']));
        } else {
            $__SESSION->unsetSession('asrchperiodo');
        }
    }
if (isset($_GET['btnGenerico'])) {
	if (function_exists('fnBtnGenerico')){fnBtnGenerico();}

}    
    if (isset($_GET['btnCancela'])) {
        $msg = '002';
        $opc = 0;
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";   
//die();
    }
    $findSubmit = 0;
    foreach ($_POST as $name => $value) {
        if (strpos($name, "submit") === false) {
            $findSubmit = 0;
        } else {
            $findSubmit = 1;
            break;
        }
    }
    if (isset($_POST['btnGuarda'])) {
//        echo '<pre>';
//        print_r($_POST);die();


        if ($findSubmit == 1) {
            //Logica para adicionar un registro
            if (trim($a_key[0]) == '100') {

                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");

                $avalues = array();
                $afields = array();
                $atypes = array();
                $files = array();
                $str_msgval = '';
                
                foreach ($field as $contField => $afield) {
                    if ($afield[3] == 'lst2') {
                        $_POST[$afield[0]] = implode('@|', $_POST[$afield[0]] );
                    }
                }                
                //$_SESSION['msgval']=NULL;
                $__SESSION->unsetSession('msgval');
                foreach ($field as $contField => $afield) {
                    if (($afield[3] == 'text' || $afield[3] == 'textarea' || $afield[3] == 'select' || $afield[3] == 'hidden' || $afield[3] == 'label') && $afield[12] == '1') {
                        if (strlen(trim($_POST[$afield[0]])) == 0 or ( $afield[3] == 'select' && (!isset($_POST[$afield[0]]) or $_POST[$afield[0]] == -1))) {
                            if (strlen($str_msgval) > 0) {
                                $str_msgval = $str_msgval . ',';
                            }
                            $str_msgval = $str_msgval . $contField;
                        }
                    }
                }
//			
                if (strlen(trim($str_msgval)) == 0 && isset($keyFieldsUnique)) {
                    $consulWhere = "";
                    $a_valiniUnique = array();
                    foreach ($keyFieldsUnique as $countUnique => $itemUnique) {
                        if (strlen($consulWhere) > 0)
                            $consulWhere.=" and ";
                        if ($keyTypeFieldsUnique[$countUnique] == 'num') {
                            $a_valiniUnique[] = 0;
                            $consulWhere.= $itemUnique . "=" . $_POST[$itemUnique];
                        }else if ($keyTypeFieldsUnique[$countUnique] == 'opc') {
                            if($_POST[$itemUnique] <> "" and $_POST[$itemUnique] <> null){
                            $a_valiniUnique[] = 0;
                            $consulWhere.= $itemUnique . "=" . $_POST[$itemUnique];                                
                            }
                        }
                        else {
                            $a_valiniUnique[] = '';
                            $consulWhere.= $itemUnique . "='" . $_POST[$itemUnique] . "'";
                        }
                    }
                    $classconsul = new Entidad($keyFieldsUnique, $a_valiniUnique);
                    $consulWhere = " where " . $consulWhere;
                    $classconsul->ListaEntidades(array(''), $tabla, $consulWhere, '', 'no');
                    
//                    echo '<pre>';
//                    print_r($classconsul);die();

                    if ($classconsul->NumReg > 0)
                        $msg = '008';
                }


                if (function_exists('fnValidBeforeAdd')) {
                    fnValidBeforeAdd($__SESSION->getValueSession('nomusuario'));
                }
               
//				echo"<pre>";
//				print_r($_POST);
//				echo"</pre>";
//				die();
                
                //echo strlen(trim($str_msgval)).' @ '.strlen(trim($msg));
                if (isset($m_keyFields2))
                    $m_keyFields = $m_keyFields2;
                if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                    foreach ($field as $afield) {
                        if ($afield[29] != true) {
                            $item = $afield[0];
                            if ($afield[3] <> 'select' or ( $afield[3] == 'select' && $_POST[$item] <> '-1')) {
                                if ($afield[4] == '1' || $afield[4] == '2' || ((isset($boolkeyValNiv) && $boolkeyValNiv && in_array($afield[0], $m_keyFields))) || ((isset($keyFields0) && sizeof($keyFields0) > 0 && in_array($afield[0], $keyFields0)))) {
                                    $item = $afield[0];
//						echo $afield[0]. " = " . $_POST[$item]."<br>";
                                    if (isset($_POST[$item]) && strlen(trim($_POST[$item])) > 0) {
                                        if ($afield[3] == 'date2') {
                                            $last_day_of_month = date("d", mktime(0, 0, 0, $_POST['cmbmes'] + 1, 0, $_POST['cmbaaa']));
                                            $avalues[] = $_POST['cmbaaa'] . '-' . $_POST['cmbmes'] . '-' . $last_day_of_month;
                                        } else {
                                            if ($afield[6] == 'date' || $afield[6]=='jdate') {
                                                $a_date= str_replace(" ", "", $_POST[$item]);
                                                $avalues[] = implode('-', array_reverse(explode('/', $a_date)));
                                            } else if ($afield[6] == 'datetime') {
                                                $a_date=  explode(" ", $_POST[$item]);
                                                $avalues[] = implode('-', array_reverse(explode('/', $a_date[0])))." ".$a_date[1];
                                            } else {
                                                if ($afield[3] == 'check') {
                                                    $avalues[] = isset($_POST[$item]) ? $_POST[$item] : 0;
                                                } else {
                                                    $avalues[] = $_POST[$item];
                                                }
                                            }
                                        }
                                        $afields[] = $afield[0];
                                        $atypes[] = $afield[6];
                                    }
                                }
                            }
                        }
                    }

                    //print_r($avalues);die();

                    $xFieldName = "null";
                    foreach ($field as $afield) {
                        if ($afield[3] == 'file') {
                            $xFieldName = $afield[0];
                            break;
                        }
                    }

                    if ($xFieldName <> "null") {
//                                    echo sizeof($_FILES).'<pre>';
//                                    print_r($_FILES);
//                                    echo '</pre>';die();

                        if (sizeof($_FILES) > 0 and $_FILES['file_name']["error"] == "0") {
                            $fileXTmp = $_FILES['file_name']["tmp_name"];
                            $file_size = $_FILES['file_name']["size"];
                            $file_type = $_FILES['file_name']["type"];
                            $file_name = $_FILES['file_name']["name"];
//                            echo '<pre>';
//                            print_r($file_type);
//                            echo '</pre>';die();
                            if ($file_size > $CFG_MAX_FILE_UPLOAD_SIZE) {
                                $msg = '016014';
                            }
                            if (!in_array($file_type, $CFG_MIME_TYPE)) {
                                $msg = '016015';
                            }

                            if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                                if ($fileXTmp != "none") {
                                    $fp = fopen($fileXTmp, "rb");
                                    $contenido = fread($fp, $file_size);
                                    //$contenido = addslashes($contenido);
                                    fclose($fp);
                                    $avalues[] = $file_type;
                                    $avalues[] = isset($no_guardar) && $no_guardar?'':$contenido;
                                    $avalues[] = $file_name;
                                    $afields[] = 'file_type';
                                    $afields[] = 'content_file';
                                    $afields[] = $xFieldName;
                                    $atypes[] = 'char';
                                    $atypes[] = 'char';
                                    $atypes[] = 'char';
                                }
                            }
                        } else {
//                            print_r($_FILES);
//                            echo '@existe.'.isset($_FILES['file_name']);die();  
                            if (isset($_FILES['file_name']) and strlen(trim($_FILES['file_name']))>0)
                                $msg = '016015';
                        }
                    }
//        echo 'ssss<pre>';
//        print_r($avalues);die();                    

                    if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                        if (function_exists('fnImplementBeforeAdd')) {
                            fnImplementBeforeAdd();
                        }

                        if(isset($msg_guardia) and $msg_guardia=="nada"){
									
                        }else{
                            $classent = new Entidad($allfields, $allvalues);
                            //$classent->Set_Entidad($avalues,$afields);
                            $classent->Adicionar($avalues, $afields, $atypes, $tabla);
                         }
//                        echo '<pre>';
//                        print_r($classent);die();

                        $msg = '000003';
                        if (function_exists('fnImplementInAdd')) {
                            fnImplementInAdd();
                        }
                        if (isset($selrowadd) && $selrowadd == 1 && isset($_POST['hiddrowadd']))
                            $opc = 2;
                    } else {
                        if (strlen(trim($str_msgval)) > 0)
                            $__SESSION->setValueSession('msgval', $str_msgval);
                        $opc = 2;

                        /* <-----incorporar values de fields  a _SESSION------> */
                        //$_SESSION['a_tmpValues']=array();
                        $a_tmpValues = array();
                        foreach ($field as $afield) {
                            if ($afield[4] == '1' || $afield[4] == '2') {
                                if ($afield[3] == 'check') {
                                    if ($afield[3] == 'check' && strlen($afield[5]) > 0 && !isset($_POST[$item])) {
                                        
                                    } else {
                                        $avalues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                                    }
                                } else {
                                    $a_tmpValues[] = $_POST[$afield[0]];
                                }
                            }
                        }
                        $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                        /* ---------------------------------------- */
                    }
                } else {
                    if (strlen(trim($str_msgval)) > 0)
                        $__SESSION->setValueSession('msgval', $str_msgval);

                    $opc = 2;

                    /* <-----incorporar values de fields  a _SESSION------> */
                    //$_SESSION['a_tmpValues']=array();
                    $a_tmpValues = array();
                    if (!isset($field0002))
                        $field0002 = $field;
                    foreach ($field0002 as $afield) {
                        if ($afield[4] == '1' || $afield[4] == '2') {
                            if ($afield[3] == 'check') {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                            } else {
                                $a_tmpValues[] = $_POST[$afield[0]];
                            }
                        }
                    }
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                }
            }
        } else {
            //$__SESSION->setValueSession('msgval',$str_msgval);
            $opc = 2;

            /* <-----incorporar values de fields  a _SESSION------> */
            //$_SESSION['a_tmpValues']=array();
            $a_tmpValues = array();
            foreach ($field as $afield) {
                if ($afield[4] == '1' || $afield[4] == '2') {
                    if ($afield[3] == 'check') {
                        $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                    } else {
                        $a_tmpValues[] = $_POST[$afield[0]];
                    }
                }
            }
            //die();
            if (isset($_POST['sel']))
                $a_tmpValues[] = $_POST['sel'];
            $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
            /* ---------------------------------------- */
        }
    }
    if (isset($_POST['btnActualiza'])) {
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";   die();
        
        if ($findSubmit == 1) {
            //Logica para actualizar la informacion de un registro
            if (trim($a_key[1]) == '100') {
                include_once("config/cfg.php");
                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");
                $classent = new Entidad($allfields, $allvalues);
                $avalues = array();
                $afields = array();
                $atypes = array();
                $msgval = '';
                //$_SESSION['msgval']=NULL;
                $__SESSION->unsetSession('msgval');
                //  if($aux_niv)$field=$field_aux;
//                        echo '<pre>';
//                        print_r($_POST);
//                        echo '</pre>';
                foreach ($field as $contField => $afield) {
                    if ($afield[3] == 'lst2') {
                        $_POST[$afield[0]] = implode('@|', $_POST[$afield[0]]);
                    }
                }              
                foreach ($field as $contField => $afield) {
                    //   echo '@'.$afield[0];
                    if (($afield[3] == 'text' || $afield[3] == 'select') && $afield[4] == '1' && $afield[12] == '1') {

                        if (strlen(trim($_POST[$afield[0]])) == 0) {
                            if (strlen($msgval) > 0)
                                $msgval = $msgval . ',';

                            $msgval = $msgval . $contField . $afield[0];
                        }//echo '</br>'.$afield[0].'?'.$_POST[$afield[0]];  
                    }
                }
                if (function_exists('fnValidBeforeUpd')) {
                    fnValidBeforeUpd();
                }//die("asdasda");
               
                //echo '</br> msgval:  '.strlen($msgval).' & '.$msg.'msg: '.strlen(trim($msg)).' _';die();
                if (strlen($msgval) == 0 && strlen(trim($msg)) == 1) {
                    foreach ($field as $afield) {
                        if ($afield[4] == '1' and $afield[3] != 'file') {
                            //				$item=$afield[0];
                            //				$avalues[]=$_POST[$item];
                            $item = $afield[0];
                            if ($afield[3] == 'date2') {
                                $last_day_of_month = date("d", mktime(0, 0, 0, $_POST['cmbmes'] + 1, 0, $_POST['cmbaaa']));
                                $avalues[] = $_POST['cmbaaa'] . '-' . $_POST['cmbmes'] . '-' . $last_day_of_month;
                            } else {
                                if ($afield[3] == 'check') {
                                    if ($afield[3] == 'check' && strlen($afield[5]) > 0 && !isset($_POST[$item])) {
                                        
                                    } else {
                                        $avalues[] = isset($_POST[$item]) ? $_POST[$item] : 0;
                                    }
                                } else {
                                            if ($afield[6] == 'date' || $afield[6]=='jdate') {
                                                $a_date= str_replace(" ", "", $_POST[$item]);
                                                $avalues[] = implode('-', array_reverse(explode('/', $a_date)));
                                            } else if ($afield[6] == 'datetime') {
                                                $a_date=  explode(" ", $_POST[$item]);
                                                $avalues[] = implode('-', array_reverse(explode('/', $a_date[0])))." ".$a_date[1];
                                            } else {
                                                if ($afield[3] == 'check') {
                                                    $avalues[] = isset($_POST[$item]) ? $_POST[$item] : 0;
                                                } else {
                                                    $avalues[] = $_POST[$item];
                                                }
                                            }
                                }
                            }
                            if ($afield[3] == 'check' && strlen($afield[5]) > 0 && !isset($_POST[$item])) {
                                
                            } else {
                                $afields[] = $afield[0];
                                $atypes[] = $afield[6];
                            }
                        }
                    }
//	echo "<pre>";	
//	print_r($afields);
//	print_r($avalues);
//	echo "</pre>";	die();
                    if (isset($_POST['chk_upd_file']) and $_POST['chk_upd_file'] == 1) {
                        foreach ($field as $afield) {
                            if ($afield[3] == 'file') {
                                $xFieldName = $afield[0];
                                break;
                            }
                        }
                        if (sizeof($_FILES) > 0 and $_FILES['file_name']["error"] == "0") {


                            $fileXTmp = $_FILES['file_name']["tmp_name"];
                            $file_size = $_FILES['file_name']["size"];
                            $file_type = $_FILES['file_name']["type"];
                            $file_name = $_FILES['file_name']["name"];
                            if ($fileXTmp != "none") {
                                $fp = fopen($fileXTmp, "rb");
                                $contenido = fread($fp, $file_size);
                                //$contenido = addslashes($contenido);
                                fclose($fp);
                                $avalues[] = $file_type;
                                $avalues[] = isset($no_guardar) && $no_guardar?'':$contenido;
                                $avalues[] = $file_name;
                                $afields[] = 'file_type';
                                $afields[] = 'content_file';
                                $afields[] = $xFieldName;
                                $atypes[] = 'char';
                                $atypes[] = 'char';
                                $atypes[] = 'char';
                            }
                        } else {
                            $avalues[] = "";
                            $avalues[] = "";
                            $avalues[] = "";
                            $afields[] = 'file_type';
                            $afields[] = 'content_file';
                            $afields[] = $xFieldName;
                            $atypes[] = 'char';
                            $atypes[] = 'char';
                            $atypes[] = 'char';
                        }
                    }
                    //
                    $strConUpd = "";
                    foreach ($keyFields as $cont => $item) {
                        if (strlen($strConUpd) > 0)
                            $strConUpd.=" and ";
                        switch ($keyTypeFields[$cont]) {
                            case 'text':
                                $strConUpd.=$item . "='" . $_POST[$item] . "'";
                                break;
                            case 'num':
                                $strConUpd.=$item . "=" . $_POST[$item];
                                break;
                        }
                    }
                    //$classent->Set_Item($id_prin,$$id_prin);
                    if (function_exists('fnImplementBeforeUpd')) {
                        fnImplementBeforeUpd();
                    }

                    //$classent->Set_Entidad($avalues,$afields);
                    $classent->Modificar($avalues, $afields, $atypes, $tabla, $strConUpd);
//                    echo '<pre>';
//                    print_r($classent);die();
                    $msg = '000004';
                    if (function_exists('fnImplementInUpd')) {
                        fnImplementInUpd();
                    }
                } else {                          //  echo 'entra en else';die();
                    $__SESSION->setValueSession('msgval', $msgval);

                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    $opc = 3;
                    if (isset($_POST['up2']) && $_POST['up2'] == 'up2')
                        $opc = 4;
                    /* <-----incorporar values de fields key a _SESSION------> */
                    //$_SESSION['s_keyFields']=array();
                    $a_keyValFields = array();
                    foreach ($keyFields as $cont => $item)
                        $a_keyValFields[] = $_POST[$item];
                    $__SESSION->setValueSession('s_keyFields', $a_keyValFields);
                    /* <-----incorporar values de fields  a _SESSION------> */
                    //$_SESSION['a_tmpValues']=array();
                    $a_tmpValues = array();
                    foreach ($field as $afield)
                        if ($afield[4] == '1') {
                            if ($afield[3] == 'check') {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                            } else {
                                $a_tmpValues[] = $_POST[$afield[0]];
                            }
                        }
                    //if(isset($_POST['sel']))$a_tmpValues[]=$_POST['sel'];
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                }
            }
        } else {
//		$__SESSION->setValueSession('msgval',$msgval);
            $opc = 3;
            if (isset($_POST['up2']) && $_POST['up2'] == 'up2')
                $opc = 4;
            /* <-----incorporar values de fields key a _SESSION------> */
            //$_SESSION['s_keyFields']=array();
            $a_keyValFields = array();
            foreach ($keyFields as $cont => $item)
                $a_keyValFields[] = $_POST[$item];
            $__SESSION->setValueSession('s_keyFields', $a_keyValFields);
            /* <-----incorporar values de fields  a _SESSION------> */
            //$_SESSION['a_tmpValues']=array();
            $a_tmpValues = array();
            foreach ($field as $afield)
                if ($afield[4] == '1') {
                    if ($afield[3] == 'check') {
                        $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                    } else {
                        $a_tmpValues[] = $_POST[$afield[0]];
                    }
                }
            if (isset($_POST['sel']))
                $a_tmpValues[] = $_POST['sel'];
            $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
            /* ---------------------------------------- */
        }
    }

    if (isset($_POST['btnDel'])) {
        if (trim($a_key[2]) == '100') {
            //Logica para actualizar la informacion de un registro
            include_once("config/cfg.php");
            include_once("lib/lib_pgsql.php");
            include_once("lib/lib_entidad.php");
//	echo "<pre>";
            $classent = new Entidad($allfields, $allvalues);
            //$classent->Set_Item($id_prin,$_POST[$id_prin]);
//	echo "<pre>";	
//	print_r($keyTypeFields);
//	echo "</pre>";	die();
            $msg = '0';
            if (function_exists('fnValidBeforeDel')) {
                fnValidBeforeDel();
            }
            if (strlen($msg) == 1) {

                $strConDel = "";
                foreach ($keyFields as $cont => $item) {
                    if (strlen($strConDel) > 0)
                        $strConDel.=" and ";
                    switch ($keyTypeFields[$cont]) {
                        case 'text':
                            $strConDel.=$item . "='" . $_POST[$item] . "'";
                            break;
                        case 'num':
                            $strConDel.=$item . "=" . $_POST[$item];
                            break;
                    }
                }
                ////////////////////////////////////////////////////////////////////////////esto es lo que agrego Angelika
                if (function_exists('fnBeforeDel')) {
                    fnBeforeDel();
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////////
                $classent->Eliminar($tabla, $setdel, $id_prin, 1, $strConDel);
                $msg = '000005';

                if (function_exists('fnImplementInDel')) {
                    fnImplementInDel();
                }
                //$msg='000005';
            }
        }
    }
    if (isset($_POST['btnGuardaDetalle'])) {
        if ($findSubmit == 1) {
            //Logica para actualizar la informacion de un registro
            if (trim($a_key[1]) == '100') {
                include_once("config/cfg.php");
                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");
                $msgval = '';
                destroy_session('msgval');
                $a_fields_post = array();
                $cont_item_post = 0;
                
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';
//                                die();
                foreach ($_POST as $name_obj_post => $value_post) {
                    $name_post = str_replace("*", '.', $name_obj_post);
                    $pos = strpos($name_post, '@!');
                    if ($pos === false) {
                        
                    } else {
                        $a_fields = explode("@!", $name_post);
                        for ($i = 0; $i < (sizeof($a_fields)); $i++) {
                            if (isset($a_insert_key)) {
                                $a_explode_pn = explode(":", $a_fields[$i]);
                                if (in_array($a_explode_pn[0], $a_insert_key)) {
                                    if ($i == 0) {
                                        $a_fields_post[$cont_item_post]['key_name'] = "";
                                        $a_fields_post[$cont_item_post]['key_value'] = "";
                                    } else {
                                        $a_fields_post[$cont_item_post]['key_name'].=",";
                                        $a_fields_post[$cont_item_post]['key_value'].=",";
                                    }

                                    $a_fields_post[$cont_item_post]['key_name'].=$a_explode_pn[0];
                                    $a_fields_post[$cont_item_post]['key_value'].=$a_explode_pn[1];
                                }
                            } else {
                                if ($i == 0) {
                                    $a_fields_post[$cont_item_post]['key_name'] = "";
                                    $a_fields_post[$cont_item_post]['key_value'] = "";
                                } else {
                                    $a_fields_post[$cont_item_post]['key_name'].=",";
                                    $a_fields_post[$cont_item_post]['key_value'].=",";
                                }
                                $a_explode_pn = explode(":", $a_fields[$i]);
                                $a_fields_post[$cont_item_post]['key_name'].=$a_explode_pn[0];
                                $a_fields_post[$cont_item_post]['key_value'].=$a_explode_pn[1];
                            }
                            $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $a_explode_pn[1];
                        }
                        $a_explode_pn = explode(":", $a_fields[sizeof($a_fields) - 1]);
                        $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $value_post;
                        $cont_item_post++;
                    }
//                    if ($pos === false) {
//                        
//                    } else {
//                        $a_fields = explode("@!", $name_post);
//                        for ($i = 0; $i < (sizeof($a_fields)); $i++) {
//                            if ($i == 0) {
//                                $a_fields_post[$cont_item_post]['key_name'] = "";
//                                $a_fields_post[$cont_item_post]['key_value'] = "";
//                            } else {
//                                $a_fields_post[$cont_item_post]['key_name'].=",";
//                                $a_fields_post[$cont_item_post]['key_value'].=",";
//                            }
//                            $a_explode_pn = explode(":", $a_fields[$i]);
//                            $a_fields_post[$cont_item_post]['key_name'].=$a_explode_pn[0];
//                            $a_fields_post[$cont_item_post]['key_value'].=$a_explode_pn[1];
//                            $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $a_explode_pn[1];
//                        }
//                        $a_explode_pn = explode(":", $a_fields[sizeof($a_fields) - 1]);
//                        $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $value_post;
//                        $cont_item_post++;
//                    }
                }


//					echo "<pre>";
//					print_r($a_fields_post);
//					echo "</pre>";   
//					die();
//			$a_fields_post_ordered=array();

                $borrapost = array();
                $con_vac = 0;
                $con_array = array();
                foreach ($a_fields_post as $num_field => $values_field) {
                    $count_items_array = 0;
                    foreach ($values_field as $name_field => $value_field) {
                        //if($count_items_array==sizeof($values_field)-1){
                        //  echo $values_field['key_name'].',';
//                       if(strlen(trim($value_field))==0){
//                           echo $value_field.'vacio</br>';
//                       }                                        
                        $a_fields_post_ordered[$values_field['key_name']][$values_field['key_value']][$name_field] = $value_field;
                        if (isset($obligatoriosfield) && count($obligatoriosfield) > 0 && in_array($name_field, $obligatoriosfield) && strlen(trim($value_field)) == 0) {
                            $borrapost[$con_vac][$values_field['key_name']] = $values_field['key_value'];
                            $con_array[] = $con_vac;
                        }

                        //}
                        $count_items_array++;
                    }
                    $con_vac++;
                }
//					echo "<pre>";
//					print_r($borrapost[2]);
//					echo "</pre>";   
//					die();                 
                $tipo_men = '000004';
                for ($index = 0; $index < count($borrapost); $index++) {
                    foreach ($borrapost[$con_array[$index]] as $claveborra => $borra) {
                        if (isset($a_fields_post_ordered[$claveborra][$borra])) {
                            //  echo '<pre>';
                            print_r($a_fields_post_ordered[$claveborra][$borra]['lote']);
                            if ($a_fields_post_ordered[$claveborra][$borra]['lote'] == "" && $a_fields_post_ordered[$claveborra][$borra]['fecha_caducidad'] == "") {
                                //       echo 'no mensaje';
                            } else if ($a_fields_post_ordered[$claveborra][$borra]['lote'] == "" || $a_fields_post_ordered[$claveborra][$borra]['fecha_caducidad'] == "") {
//                            if($a_fields_post_ordered[$claveborra][$borra]['lote']=="")$_SESSION['mensaje_total'].='la fecha de caducidad: "'.$a_fields_post_ordered[$claveborra][$borra]['fecha_caducidad'].'" requiere lote </br>';
//                            else if($a_fields_post_ordered[$claveborra][$borra]['fecha_caducidad']=="")$_SESSION['mensaje_total'].='el lote: "'.$a_fields_post_ordered[$claveborra][$borra]['lote'].'" requiere fecha de caducidad </br>';
                                $tipo_men = '51';
                                //  $opc=9;
                            }
                            unset($a_fields_post_ordered[$claveborra][$borra]);
                        }
                    }
                }
//					echo "<pre>";
//					print_r($a_fields_post_ordered);
//					echo "</pre>";   
//					die();                
                if (function_exists('fnOnSaveDetalle')) {
                    fnOnSaveDetalle();
                }
                if (sizeof($a_fields_post_ordered) > 0) {

                    foreach ($a_fields_post_ordered as $knames => $a_kvalue) {
                        foreach ($a_kvalue as $kvalues => $a_fieldsPost) {
                            $avalues = array();
                            $afields = array();
                            $atypes = array();
                            $classent = new Entidad($allfields, $allvalues);
                            foreach ($field as $afield) {
                                if ($afield[4] == '3') {
                                    $item = $afield[0];
                                    if ($afield[3] == 'check') {
                                        $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : 0;
                                    } else {

                                        if ($afield[3] <> 'select' or ( $afield[3] == 'select' && $a_fieldsPost[$item] <> '-1')) {
                                            // $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : $afield[7];
                                            $avalues[] = ($afield[6] == 'date' ? implode("-", array_reverse(explode("/", $a_fieldsPost[$item]))) : (isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : $afield[7]));
                                        } else {
                                            $avalues[] = '';
                                        }
                                    }
                                    $afields[] = $afield[0];
                                    $atypes[] = $afield[6];
                                }
                            }
                            foreach ($fieldGeneral as $itemGeneral) {
                                $avalues[] = ($itemGeneral[6] == 'date' ? implode("-", array_reverse(explode("/", $_POST[$itemGeneral[0]]))) : $_POST[$itemGeneral[0]]);
                                $afields[] = $itemGeneral[0];
                                $atypes[] = $itemGeneral[6];
                            }
                            $valores = "";
                            foreach ($afields as $ctafields => $nomafields) {
                                if ($ctafields == 0)
                                    $valores.=" where " . $afields[$ctafields] . "= '" . $avalues[$ctafields] . "'";
                                else
                                    $valores.=" and " . $afields[$ctafields] . "= '" . $avalues[$ctafields] . "'";
                            }

                            $classconsul = new Entidad($afields, array(0));
                            $classconsul->ListaEntidades(array($afields[0]), $tabla, $valores);   //****  <---- Colocar el filtro paara elegir conforme el grupo seleccionado... ****
                            $classconsul->VerDatosEntidad(0, $afields);
//                            echo '<pre>';
//                            print_r($classconsul);
//                            echo '</pre>';die();
                            if ($classconsul->NumReg < 1) {
                                $classent->Set_Entidad($avalues, $afields);
                                $classent->Adicionar($avalues, $afields, $atypes, $tabla);
                            }
                        }
                    }
//                    die();
                    $msg = $tipo_men;
                }
            }
        }
    }
    if (isset($_POST['btnActualizaDetalle'])) {

//        	echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";   die();
        if ($findSubmit == 1) {
            //Logica para actualizar la informacion de un registro
            if (trim($a_key[1]) == '100') {
                include_once("config/cfg.php");
                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");
                $msgval = '';
                $__SESSION->unsetSession('msgval');
                $a_fields_post = array();
                $cont_item_post = 0;

                //	echo "<pre>";
//					print_r($_POST);
//					echo "</pre>";   
//					die();
                foreach ($_POST as $name_obj_post => $value_post) {
                    $name_post = str_replace("*", '.', $name_obj_post);
                    $pos = strpos($name_post, '@!');
                    if ($pos === false) {
                        
                    } else {
                        $a_fields = explode("@!", $name_post);
                        for ($i = 0; $i < (sizeof($a_fields)); $i++) {
                            $a_explode_pn = explode(":", $a_fields[$i]);
                            if (in_array($a_explode_pn[0], $keyFields)) {
                                if ($i == 0) {
                                    $a_fields_post[$cont_item_post]['key_name'] = "";
                                    $a_fields_post[$cont_item_post]['key_value'] = "";
                                } else {
                                    $a_fields_post[$cont_item_post]['key_name'].=",";
                                    $a_fields_post[$cont_item_post]['key_value'].=",";
                                }
                                $a_fields_post[$cont_item_post]['key_name'].=$a_explode_pn[0];
                                $a_fields_post[$cont_item_post]['key_value'].=$a_explode_pn[1];
                            }
                            $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $a_explode_pn[1];
                        }
                        $a_explode_pn = explode(":", $a_fields[sizeof($a_fields) - 1]);
                        $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $value_post;
                        $cont_item_post++;
                    }
                }
//					echo "<pre>";
//					print_r($a_fields_post);
//					echo "</pre>";   
//					die();
                $a_fields_post_ordered = array();
                foreach ($a_fields_post as $num_field => $values_field) {
                    $count_items_array = 0;
                    foreach ($values_field as $name_field => $value_field) {
                        //if($count_items_array==sizeof($values_field)-1){
                        $a_fields_post_ordered[$values_field['key_name']][$values_field['key_value']][$name_field] = $value_field;
                        //}
                        $count_items_array++;
                    }
                }
                if (function_exists('fnOnSaveDetalle')) {
                    fnOnSaveDetalle();
                }
                if (sizeof($a_fields_post_ordered) > 0) {

                    foreach ($a_fields_post_ordered as $knames => $a_kvalue) {
                        foreach ($a_kvalue as $kvalues => $a_fieldsPost) {
//					echo "<pre>";
//					print_r($a_fieldsPost);
//					echo "</pre>";   
                
                            $avalues = array();
                            $afields = array();
                            $atypes = array();
                            $classent = new Entidad($allfields, $allvalues);
                            foreach ($field as $afield) {
                                $strConUpd = "";
//                                echo '<pre>';
//                                print_r($keyFields);
//                                echo '</pre>';
//                                die();
                                
                                foreach ($keyFields as $cont => $item) {
                                    if (strlen($strConUpd) > 0)
                                        $strConUpd.=" and ";
                                    switch ($keyTypeFields[$cont]) {
                                        case 'text':
                                            $strConUpd.=$item . "='" . $a_fieldsPost[$item] . "'";
                                            break;
                                        case 'num':
                                            $strConUpd.=$item . "=" . $a_fieldsPost[$item];
                                            break;
                                    }
                                }
                                if ($afield[4] == '3') {
                                    $item = $afield[0];
                                    if ($afield[3] == 'check') {
                                        $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : 0;
                                    } else {
                                        if ($afield[3] <> 'select' or ( $afield[3] == 'select' && $a_fieldsPost[$item] <> '-1')) {
                                            $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : $afield[7];
                                        } else {
                                            $avalues[] = '';
                                        }
                                    }
                                    $afields[] = $afield[0];
                                    $atypes[] = $afield[6];
                                }
                            }
                           
                                                        
                            if (function_exists('fnnuevoedita')) {
                                $classent->Set_Entidad($avalues, $afields);
                                    if(fnnuevoedita($avalues,$afields)) $classent->Adicionar($avalues,$afields,$atypes,$tabla);
                                    else  $classent->Modificar($avalues, $afields, $atypes, $tabla, $strConUpd);  
                                    
                                    $avalues=array();
                                    $afields=array();
                            }else{
                            $classent->Set_Entidad($avalues, $afields);
                            //$classent->Adicionar($avalues,$afields,$atypes,$tabla);
                            $classent->Modificar($avalues, $afields, $atypes, $tabla, $strConUpd);                                
                            }
                                                        
                            

                            
                        }
                    }
                    $msg = '000004';
                }
            }
        }
        if (function_exists('fnAfterSaveDetalle')) {
            fnAfterSaveDetalle();
        }
    }
    if (isset($_POST['btnGuardaDetalleMD'])) {
        if ($findSubmit == 1) {
            //Logica para actualizar la informacion de un registro
            if (trim($a_key[1]) == '100') {
                include_once("config/cfg.php");
                include_once("lib/lib_pgsql.php");
                include_once("lib/lib_entidad.php");
                $msgval = '';
                $__SESSION->unsetSession('msgval');
                $a_fields_post = array();
                $cont_item_post = 0;
				
					/* echo "<pre>";
					print_r($_POST);
					echo "</pre>";   
					die();  */
				
                foreach ($_POST as $name_obj_post => $value_post) {
                    $name_post = str_replace("*", '.', $name_obj_post);
                    $pos = strpos($name_post, '@!');
                    if ($pos === false) {
                        
                    } else {
                        $a_fields = explode("@!", $name_post);
                        for ($i = 0; $i < (sizeof($a_fields)); $i++) {
                            if ($i == 0) {
                                $a_fields_post[$cont_item_post]['key_name'] = "";
                                $a_fields_post[$cont_item_post]['key_value'] = "";
                            } else {
                                $a_fields_post[$cont_item_post]['key_name'].=",";
                                $a_fields_post[$cont_item_post]['key_value'].=",";
                            }
                            $a_explode_pn = explode(":", $a_fields[$i]);
                            $a_fields_post[$cont_item_post]['key_name'].=$a_explode_pn[0];
                            $a_fields_post[$cont_item_post]['key_value'].=$a_explode_pn[1];
                            $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $a_explode_pn[1];
                        }
                        $a_explode_pn = explode(":", $a_fields[sizeof($a_fields) - 1]);
                        $a_fields_post[$cont_item_post][$a_explode_pn[0]] = $value_post;
                        $cont_item_post++;
                    }
                }
				/* 	echo "<pre>";
					print_r($a_fields_post);
					echo "</pre>";   
					die(); */
                $a_fields_post_ordered = array();
                foreach ($a_fields_post as $num_field => $values_field) {
                    $count_items_array = 0;
                    foreach ($values_field as $name_field => $value_field) {
                        //if($count_items_array==sizeof($values_field)-1){
                        $a_fields_post_ordered[$values_field['key_name']][$values_field['key_value']][$name_field] = $value_field;
                        //}
                        $count_items_array++;
                    }
                }
                if (function_exists('fnOnSaveDetalle')) {
                    fnOnSaveDetalle();
                }
                if (sizeof($a_fields_post_ordered) > 0) {

                    foreach ($a_fields_post_ordered as $knames => $a_kvalue) {
                        foreach ($a_kvalue as $kvalues => $a_fieldsPost) {
                            $avalues = array();
                            $afields = array();
                            $atypes = array();
                            $classent = new Entidad($allfields, $allvalues);
                            foreach ($field as $afield) {
                                if ($afield[4] == '3') {
                                    $item = $afield[0];
                                    if ($afield[3] == 'check') {
                                        $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : 0;
                                    } else {
                                        if ($afield[3] <> 'select' or ( $afield[3] == 'select' && $a_fieldsPost[$item] <> '-1')) {
                                            $avalues[] = isset($a_fieldsPost[$item]) ? $a_fieldsPost[$item] : $afield[7];
                                        } else {
                                            $avalues[] = '';
                                        }
                                    }
                                    $afields[] = $afield[0];
                                    $atypes[] = $afield[6];
                                }
                            }
                            $classent->Set_Entidad($avalues, $afields);
                            $classent->Adicionar($avalues, $afields, $atypes, $tabla);
							
                        }
                    }
                    $msg = '000004';
                }
            }
        }
        if (function_exists('fnAfterSaveDetalle')) {
            fnAfterSaveDetalle();
        }
    }
    if (isset($_POST['moveUp'])) {
        $msg = '000004';
        if (function_exists('fnMoveUp')) {
            fnMoveUp();
        }
    }

    if (isset($_POST['moveDown'])) {
        $msg = '000004';
        if (function_exists('fnMoveDown')) {
            fnMoveDown();
        }
    }
    if (isset($_POST['btnProcInf'])) {
        $msg = '000';
        if (function_exists('fnProcessAction')) {
            fnProcessAction();
        }
    }
    /* reportes */
    if (isset($_POST['btnGenRep'])) {

        if (trim($a_key[4]) == '100') {
            if ($findSubmit == 1) {
//			echo "<pre>";
//			print_r($_POST);
//                        echo "</pre>";
//			die();                    
                $str_msgval = '';
                //$_SESSION['msgval']=NULL;
                $__SESSION->unsetSession('msgval');
                foreach ($field as $contField => $afield) {
                    if ($afield[3] == 'text' && $afield[12] == '1') {
                        if (strlen(trim($_POST[$afield[0]])) == 0) {
                            if (strlen($str_msgval) > 0) {
                                $str_msgval = $str_msgval . ',';
                            }
                            $str_msgval = $str_msgval . $contField;
                        }
                    }
                }
                if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                    $opc = 5;
                    /* <-----incorporar values de fields  a _SESSION------> */
                    $a_tmpValues = array();
                    foreach ($field as $afield) {
                        if ($afield[3] == 'check') {
                            $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                        } else {
                            $a_tmpValues[] = $_POST[$afield[0]];
                        }
                    }
//				foreach ($a_check as $contchk => $itemchk){
//					if (isset($_POST['chk'.$contchk]))
//						$a_tmpValues[]='chk'.$contchk;
//				}
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                } else {
                    if (strlen(trim($str_msgval)) > 0)
                        $__SESSION->setValueSession('msgval', $str_msgval);
                    /* <-----incorporar values de fields  a _SESSION------> */
                    $a_tmpValues = array();
                    foreach ($field as $afield) {
                        if ($afield[4] == '1' || $afield[4] == '2') {
                            if ($afield[3] == 'check') {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                            } else {
                                $a_tmpValues[] = $_POST[$afield[0]];
                            }
                        }
                    }
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                }
            } else {
                /* <-----incorporar values de fields  a _SESSION------> */
                $a_tmpValues = array();
                foreach ($field as $afield) {
                    if ($afield[4] == '1' || $afield[4] == '2') {
                        if ($afield[3] == 'check') {
                            $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                        } else {
                            $a_tmpValues[] = $_POST[$afield[0]];
                        }
                    }
                }
                //die();
                if (isset($_POST['sel']))
                    $a_tmpValues[] = $_POST['sel'];
                $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                /* ---------------------------------------- */
            }
        }
    }
    /* termina reportes */
    /* upload */
    if (isset($_POST['btnUpload'])) {
//			echo "<pre>";
//			print_r($_FILES);
//			die();
        if (trim($a_key[4]) == '100') {
            //if($findSubmit==1){
            $str_msgval = '';
            //$_SESSION['msgval']=NULL;
            $__SESSION->unsetSession('msgval');
            $xStrFieldFileName = "file_name";

            foreach ($field as $contField => $afield) {
                if ($afield[3] == 'file' && $afield[12] == '1') {
                    $xStrFieldFileName = $afield[0];
                    if (strlen(trim($_FILES[$afield[0]]['name'])) == 0) {
                        if (strlen($str_msgval) > 0) {
                            $str_msgval = $str_msgval . ',';
                        }
                        $str_msgval = $str_msgval . $contField;
                    }
                    //echo $_FILES[$afield[0]]['name'];die();
                }
            }
            if (sizeof($_FILES) > 0 and $_FILES[$xStrFieldFileName]["error"] == "0") {
                if (isset($a_mime)) {
                    $CFG_MIME_TYPE = $$a_mime;
                }
                $fileXTmp = $_FILES[$xStrFieldFileName]["tmp_name"];
                $file_size = $_FILES[$xStrFieldFileName]["size"];
                $file_type = $_FILES[$xStrFieldFileName]["type"];
                $str_xfile_name = trim($_FILES[$xStrFieldFileName]['name']);
                if ($file_size > $CFG_MAX_FILE_UPLOAD_SIZE) {
                    $msg = '016014';
                }
                if (!in_array($file_type, $CFG_MIME_TYPE)) {
                    $msg = '016015';
                }

                if (!preg_match((isset($ereg_extension_file) ? $ereg_extension_file : '/\.pdf$/'), strtolower($str_xfile_name))) {
                    $msg.='031';
                }

                if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                    $msg = '';
                    /* <-----incorporar values de fields  a _SESSION------> */
                    //$replacements = array();
                    //  Reference file for ease
                    $f = &$_FILES[$xStrFieldFileName];
                    //$str_xfile = trim($_FILES[$xStrFieldFileName]['name']);
                    if (function_exists('override_fnupload')) {
                        override_fnupload();
                    } else {
                        //  Check to make sure a file has been uploaded
                        if (!is_file($f['tmp_name'])) {
                            $msg.='030';
                        } else {
                            //  All appears to be ok, so let's set up the data and preview the file
                            //  Save settings to session so we can remember them.
                            //$a_fname=explode('.xml',safe_filename($f['name']));
                            //$_SESSION['xml_file'] = _DIR_HOME . _DIR_UPLOAD .$a_fname[0].'_'.date("Y.m.d.H.i.s").'.xml';
                            //$_SESSION['zip_file'] = $_SESSION['nomusuario'].'_'.date("Y.m.d.H.i.s").'.zip';
                            $__SESSION->setValueSession($xStrFieldFileName, $str_xfile_name);


                            //  Make sure directory exists for upload, if it doesn't, create it
                            if (!is_dir(_DIR_HOME . _DIR_UPLOAD)) {

                                //  If directory can't be made
                                if (!@mkdir(_DIR_HOME . _DIR_UPLOAD)) {
                                    //  Set error message and output
                                    $msg.='032';
                                }
                                if (!copy($f['tmp_name'], _DIR_HOME . _DIR_UPLOAD . $__SESSION->getValueSession($xStrFieldFileName))) {
                                    //  Set error message and output
                                    $msg.='033';
                                } else {
                                    $msg = '000040';
                                    $opc = 8;
                                }
                            } else {

                                //  Try to copy file to server
                                if (!copy($f['tmp_name'], _DIR_HOME . _DIR_UPLOAD . $__SESSION->getValueSession($xStrFieldFileName))) {

                                    //  Set error message and output
                                    $msg.='033';
                                } else {
                                    $msg = '000040';
                                    $opc = 8;
                                }
                            }
                        }
                    }
                    /* ---------------------------------------- */
                } else {
                    if (strlen(trim($str_msgval)) > 0)
                        $__SESSION->setValueSession('msgval', $str_msgval);
                    /* <-----incorporar values de fields  a _SESSION------> */
                    $a_tmpValues = array();
                    foreach ($field as $afield) {
                        if ($afield[4] == '1' || $afield[4] == '2') {
                            if ($afield[3] == 'check') {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                            } else {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : '';
                            }
                        }
                    }
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                }
            } else {
                if (isset($_FILES[$xStrFieldFileName]))
                    $msg = '016015';
                if (strlen(trim($str_msgval)) > 0)
                    $__SESSION->setValueSession('msgval', $str_msgval);
                /* <-----incorporar values de fields  a _SESSION------> */
                $a_tmpValues = array();
                foreach ($field as $afield) {
                    if ($afield[4] == '1' || $afield[4] == '2') {
                        if ($afield[3] == 'check') {
                            $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                        } else {
                            $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : '';
                        }
                    }
                }
                $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
            }

//		} else{
//					/*<-----incorporar values de fields  a _SESSION------>*/
//					$a_tmpValues=array();
//					foreach ($field as $afield){
//						if ($afield[4]=='1' || $afield[4]=='2'){
//								if ($afield[3]=='check'){
//									$a_tmpValues[]=isset($_POST[$afield[0]])?$_POST[$afield[0]]:0;
//								} else {
//									$a_tmpValues[]=$_POST[$afield[0]];
//								}
//						}
//					}
//					//die();
//					if(isset($_POST['sel']))$a_tmpValues[]=$_POST['sel'];
//					$__SESSION->setValueSession('a_tmpValues',$a_tmpValues);
//					/*----------------------------------------*/
//		}
        }
//	echo $msg; die();
    }
    /* termina upload */
    /* import */
    if (isset($_POST['btnImport'])) {
//			echo "<pre>";
//			print_r($_FILES);
//			die();
        if (trim($a_key[4]) == '100') {
            if ($findSubmit == 1) {
                $str_msgval = '';
                //$_SESSION['msgval']=NULL;
                $__SESSION->unsetSession('msgval');
                if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                    $msg = '';
                    $opc = 9;

                    /* <-----recuperar valores de _SESSION------> */
                    require("lib/class.xml.php");
                    require("lib/class.mysql_xml.php");
                    require("lib/inc.date_functions.php");
                    require_once('lib/pclzip.lib.php');
                    require_once ("lib/dUnzip2.inc.php");
                    $zip = new PclZip(_DIR_HOME . _DIR_UPLOAD . $__SESSION->getValueSession('zip_file'));
                    if (($list = $zip->listContent()) == 0) {
                        die("Error : " . $zip->errorInfo(true));
                    }



                    $xml_file = trim($list[0]['filename']);
                    $zip = new dUnzip2(_DIR_HOME . _DIR_UPLOAD . $__SESSION->getValueSession('zip_file'));
                    $zip->unzipAll(_DIR_UPLOAD);

//				echo $xml_file; die();
//				if ($zip->extract(PCLZIP_OPT_ADD_TEMP_FILE_ON) == 0) {
//					die("Error : ".$zip->errorInfo(true));
//				}
//				echo "hola!";
                    # Clear table only for example
                    $table = new recordset;
                    //$table->exec("Delete From registro_var");
                    # Clear table only for example
                    $conv = new mysql2xml;
                    $__SESSION->setValueSession('inserted_rows', 0);
                    $__SESSION->setValueSession('replaced_rows', 0);
                    $__SESSION->setValueSession('all_affected_rows', 0);
                    $conv->insertIntoMySQL(_DIR_HOME . _DIR_UPLOAD . $xml_file, "registro_var");

                    //if ($_SESSION['all_affected_rows']>0)
                    $msg.='045';
                    //if ($_SESSION['inserted_rows']>0)
                    $msg.='046';
                    //if ($_SESSION['replaced_rows']>0)
                    $msg.='047';
                    //die();
                    /* ---------------------------------------- */
                }
            }
        }
    }
    /* termina import */

    /* export */
    if (isset($_POST['btnGenInf'])) {
//			echo "<pre>";
//			print_r($_POST);
//			die();
        if (trim($a_key[4]) == '100') {
            if ($findSubmit == 1) {
                $str_msgval = '';
                //$_SESSION['msgval']=NULL;
                $__SESSION->unsetSession('msgval');
                foreach ($field as $contField => $afield) {
                    if ($afield[3] == 'text' && $afield[12] == '1') {
                        if (strlen(trim($_POST[$afield[0]])) == 0) {
                            if (strlen($str_msgval) > 0) {
                                $str_msgval = $str_msgval . ',';
                            }
                            $str_msgval = $str_msgval . $contField;
                        }
                    }
                }
                if (strlen(trim($str_msgval)) == 0 && strlen(trim($msg)) == 1) {
                    $opc = 6;
                    $str_pcWhere = "";
                    /* <-----incorporar values de fields  a _SESSION------> */
                    if (sizeof($a_qry) > 0) {/* crea cadena de qry $_POST */
                        foreach ($a_qry as $element_aqry) {
                            if (isset($_POST[$element_aqry[1]]) and $_POST[$element_aqry[1]] <> 'ALL') {
//						echo $_POST[$element_aqry[1]];
                                if (strlen(trim($str_pcWhere)) > 0)
                                    $str_pcWhere.=" and ";
                                if ($element_aqry[2] == 'num') {
                                    $str_pcWhere.=$element_aqry[7] . $element_aqry[$NTU] . "." . $element_aqry[0] . $element_aqry[8] . " " . $element_aqry[4] . " " . $element_aqry[9] . ($_POST[$element_aqry[1]] * 1) . $element_aqry[9];
                                } else {
                                    $str_pcWhere.=$element_aqry[7] . $element_aqry[$NTU] . "." . $element_aqry[0] . $element_aqry[8] . " " . $element_aqry[4] . " "
                                            . (strlen(trim($element_aqry[9])) == 0 ? "'" : $element_aqry[9]) . $_POST[$element_aqry[1]] . (strlen(trim($element_aqry[10])) == 0 ? "'" : $element_aqry[10]);
                                }
                            }
                        }
                    }/* fin de cadena de qry $_GET */
                    $str_pcWhere .=$strWhereAdd;

                    require("lib/class.xml.php");
                    require("lib/class.mysql_xml.php");

                    $conv = new mysql2xml;
                    $__SESSION->setValueSession('regout', 0);
                    $conv->convertToXML("Select " . $fields_exp . " From " . $tables_exp . " where " . $str_pcWhere, _DIR_UPLOAD . $filename_xml);
                    $msg = '048049';
                    $_SESSION['filename_ok'] = "OK";
                    include_once('lib/pclzip.lib.php');
                    $archive = new PclZip(_DIR_UPLOAD . $filename_exp);
                    $v_list = $archive->create(_DIR_UPLOAD . $filename_xml, PCLZIP_OPT_REMOVE_PATH, _DIR_UPLOAD);
                    if ($v_list == 0) {
                        die("Error : " . $archive->errorInfo(true));
                    } else {
                        $_SESSION['filename_exp'] = $filename_exp;
                    }



//			echo "<pre>";
//			print_r($_POST);
//			die();
                    /* ---------------------------------------- */
                } else {
                    if (strlen(trim($str_msgval)) > 0)
                        $__SESSION->setValueSession('msgval', $str_msgval);
                    /* <-----incorporar values de fields  a _SESSION------> */
                    $a_tmpValues = array();
                    foreach ($field as $afield) {
                        if ($afield[4] == '1' || $afield[4] == '2') {
                            if ($afield[3] == 'check') {
                                $a_tmpValues[] = isset($_POST[$afield[0]]) ? $_POST[$afield[0]] : 0;
                            } else {
                                $a_tmpValues[] = $_POST[$afield[0]];
                            }
                        }
                    }
                    $__SESSION->setValueSession('a_tmpValues', $a_tmpValues);
                    /* ---------------------------------------- */
                }
            }
        }
    }
    /* termina export */


//die('hola');
    $__SESSION->setValueSession('opc', $opc);
    $__SESSION->setValueSession('msg', $msg);
//$str_refresh=$_SERVER['PHP_SELF'];
//		header('Status: 301 Moved Permanently', false, 301);
//		header('Location: '.$str_refresh);
//		exit();
    echo "<meta http-equiv='refresh' content='0;URL=" . $_SERVER['PHP_SELF'] . "'>";
} else {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/sb_refresh.php");
}
?>

