<?php

/**
  -----------------------------------------------------------------
  Definici&oacute;n de clase: Entidad
  Utilizada para controlar las operaciones de gesti&oacute;n de una
  Entidad del Sistema en la Base de Datos en PGSQL.
  -----------------------------------------------------------------
 */
class Entidad {

    //Constructor de la clase Entidad
    function Entidad($allitems, $allvalues, $num_con = 0) {
        foreach ($allitems as $c_item => $item) {
            $this->$item = isset($allvalues[$c_item]) ? $allvalues[$c_item] : '';
        }
        $this->Con = new Pgsql($num_con);
        $this->Lista = null;
        $this->NumReg = 0;
        $this->RowsAfected = 0;
        $this->Info = "";
        $this->Error = 0;
    }

    //Asigna atributos de la clase Entidad
    function Set_Entidad($avalues, $afields) {
        foreach ($afields as $c_item => $item)
            $this->$item = $avalues[$c_item];
    }

    //funcion que asigna valor a un item de la clase
    function Set_Item($item, $value) {
        if (isset($this->$item)) {
            $this->$item = $value;
        }
    }

    //Método para adicionar un registro de la Entidad a la Base de Datos
    function Adicionar($avalues, $afields, $atypes, $tabla, $operation = "INSERT") {
        global $pasword_encript;
        $a_p_encript=array();
        $this->Con->Conectarse();
        $cont = 0;
        $this->Con->Sql = $operation . " INTO $tabla (";
        foreach ($afields as $key => $item) {
            if ($cont > 0) {
                $this->Con->Sql .= ", ";
            }
            if(substr($item,-8)=="_encript"){
                $a_p_encript[$key]=$key;
                $item=  str_replace("_encript", "", $item);
            }
            $this->Con->Sql .= $item;
            $cont+=1;
        }
        $cont = 0;
        $valor_c="";        
        $this->Con->Sql .=") VALUES (";
        foreach ($avalues as $key => $value) {
            if ($cont > 0) {
                $valor_c.= ", ";
            }
            if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int') {
                $strtmpint = str_replace(array('$', ','), array('', ''), $value);
                $value = $strtmpint * 1;
                //$value=(strstr($strtmpint, '.')? number_format($strtmpint, 2, '.', ''):$strtmpint)*1;
            }
            $valor_unico="";
            if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int') {
                $valor_unico= $value;
            } else {
                if ($atypes[$cont] == 'char') {
                    $valor_unico="'" . ($afields[$cont] == "passwd" ? md5(addslashes($value)) : addslashes($value)) . "'";
                } else {
                    $valor_unico= "'" . addslashes($value) . "'";
                }
            }
            if(isset($a_p_encript[$key])){
                $valor_unico="AES_ENCRYPT(".$valor_unico.",'".$pasword_encript[$tabla]."')";
            }
            $valor_c.=$valor_unico;
            $cont+=1;
        }
        $this->Con->Sql.=$valor_c;        
        $this->Con->Sql .=")";
//		echo $this->Con->Sql;
//		die();
        $this->Con->Actualizar();
        $this->Con->Desconectarse();
    }

//Método para adicionar un registro de la Entidad a la Base de Datos
    function AdicionarSelf($afields, $tabla, $strvalues = '') {
        $this->Con->Conectarse();
        $cont = 0;
        $this->Con->Sql = "INSERT INTO $tabla (";
        foreach ($afields as $item) {
            if ($cont > 0) {
                $this->Con->Sql .= ", ";
            }
            $this->Con->Sql .= $item;
            $cont+=1;
        }
        $cont = 0;
        $this->Con->Sql .=") " . $strvalues;
        $this->Con->Actualizar();
        $this->Con->Desconectarse();
    }

//Método para modificar la informacion de un registro de la Entidad en la Base de Datos
    function CmdSelfDB($avalues, $afields, $atypes, $tabla, $cond) {
        $this->Con->Conectarse();
        $this->Con->Sql = "update $tabla set ";
        $cont = 0;
        foreach ($afields as $item) {
            if ($cont > 0) {
                $this->Con->Sql .= ", ";
            }
            $this->Con->Sql .= $item . "=";
            if (strlen(trim($avalues[$cont])) > 0) {
                $this->Con->Sql .= $avalues[$cont];
            } else {
                $this->Con->Sql .= 'NULL';
            }
            $cont+=1;
        }
        //$this->Con->Sql .= " WHERE " . $cond . "= " . $this->$cond;
        $this->Con->Sql .= " WHERE " . $cond;
        $this->Con->Actualizar();
        $this->Con->Desconectarse();
    }

    function ExecuteQryDB($qry) {
        $this->RowsAfected = 0;
        $this->InfoQry = "";
        $this->Con->Conectarse();
        $this->Con->Sql = $qry;
        $this->Con->Actualizar();
        $this->Info = $this->Con->InfoQry;
        $this->RowsAfected = $this->Con->RowsAfected;
        $this->Con->Desconectarse();
    }

    //Método para modificar la informacion de un registro de la Entidad en la Base de Datos
    function Modificar($avalues, $afields, $atypes, $tabla, $cond) {
        global $pasword_encript;
        $this->Con->Conectarse();
        $this->Con->Sql = "update $tabla set ";
        $cont = 0;
        $encripta=false;
        $campos_e="";
        foreach ($afields as $item) {
            $encripta=false;
            if ($cont > 0) {
                $campos_e .= ", ";
            }
            if(substr($item,-8)=="_encript"){
                $item=  str_replace("_encript", "", $item);
                $encripta=true;
            }    
        
            if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int') {
                $strtmpint = str_replace(array('$', ','), array('', ''), $avalues[$cont]);
                $avalues[$cont] = $strtmpint * 1;
                //$avalues[$cont]=(strstr($strtmpint, '.')? number_format($strtmpint, 2, '.', ''):$strtmpint)*1;
            }
            $campos_u="";
            $campos_u_e="";
            $campos_u= $item . "=";
            if (strlen(trim($avalues[$cont])) > 0) {
                if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int') {
                    $campos_u_e= $avalues[$cont];
                } else {
                    if ($atypes[$cont] == 'char') {
                        $campos_u_e= "'" . ($afields[$cont] == "passwd" ? md5(addslashes($avalues[$cont])) : addslashes($avalues[$cont])) . "'";
                    } else {
                        $campos_u_e= "'" . addslashes($avalues[$cont]) . "'";
                    }
                }
            } else {
                $campos_u_e= 'NULL';
            }
            if($encripta){
                $campos_u_e="AES_ENCRYPT(".$campos_u_e.",'".$pasword_encript[$tabla]."')";
            }
            $campos_e.=$campos_u.$campos_u_e;
            $cont+=1;
        }
        $this->Con->Sql .=$campos_e;
        //$this->Con->Sql .= " WHERE " . $cond . "= " . $this->$cond;
        $this->Con->Sql .= " WHERE " . $cond;
        //echo $this->Con->Sql;
        //die();
        $this->Con->Actualizar();
        $this->Con->Desconectarse();
    }

    //Método para eliminar un registro de la Entidad de la Base de Datos
    function Eliminar($tabla, $setdel, $cond, $set = 0, $strcond = '') {
        $this->Con->Conectarse();
        if ($set == 0) {
            $this->Con->Sql = "update " . $tabla . " set " . $setdel . "='" . $this->$setdel . "' WHERE " . $cond . "= " . $this->$cond;
        } else {
            $this->Con->Sql = "DELETE FROM $tabla WHERE " . $strcond;
        }
        // echo $this->Con->Sql; die();
        $this->Con->Actualizar();
        $this->Con->Desconectarse();
    }

    //Método para consultar la informaci&oacute;n de un registro de la Entidad de la Base de Datos
    function Consultar($afields, $Id, $tabla, $strWhere = "", $strQry = "") {
        global $marcadores_d;
        $this->Con->Conectarse();

   
        if (strlen($strQry) > 0) {
            $this->Con->Sql = $strQry;
        } else {
            if (strlen($strWhere) > 0) {
                $this->Con->Sql = "SELECT * FROM $tabla $strWhere";
            } else {
                $this->Con->Sql = "SELECT * FROM $tabla WHERE " . $Id . "= " . $this->$Id;
            }
        }
        //  print "aaaa". $strQry;
        $this->Con->Consultar();
        $this->NumReg = $this->Con->NumReg;
        if ($this->Con->NumReg > 0) {
            $afielsRet = array();

            for ($i = 0; $i < mysqli_num_fields($this->Con->RtaSql); $i++) {
                $row_nm = mysqli_fetch_assoc($this->Con->RtaSql);
                if(is_array($row_nm)){
                    $afielsRet=array_keys($row_nm);
                }
                
//            if($marcadores_d==1){
//                echo '<pre>';
//                print_r($afielsRet);die();
//            }                   
                foreach ($afields as $item) {
                    if (in_array($item, $afielsRet))
                        $this->$item = str_replace(array('"', '<', '>'), array("&quot;", "&lt;", "&gt;"), stripslashes($this->Con->mysqli_result($this->Con->RtaSql, 0, $item)));
                }
            }
        }
//echo "<pre>";
//print_r($afields);
//echo "</pre>";
        $this->Con->Desconectarse();
    }

    //Método para listar los registros de la Entidad del sistema registrados en la Base de Datos
    function ListaEntidades($order, $tabla = "", $strWhere = "", $strItems = "", $ord = "", $strlimit = "", $strQryAdd = "", $typeOrder = "", $continue = false) {//,$grp=""
        $this->Error = 0;
        if ($ord == "no") {
            $strorder = "";
        } else {
            $strorder = "ORDER BY";
        }
        $this->Con->Conectarse();
        if (strlen($strQryAdd) > 0) {
            $this->Con->Sql = $strQryAdd;
        } else {
            if (strlen(trim($strItems)) > 0) {
                $this->Con->Sql = "SELECT " . $strItems . " FROM $tabla $strWhere $strorder ";
                //echo $this->Con->Sql;
            } else {
                $this->Con->Sql = "SELECT * FROM $tabla $strWhere $strorder ";
            }
        }
//	  if (strlrn(trim($grp))>0)
//	  	$this->Con->Sql .= " $grp ";
        if ($ord <> "no") {
            foreach ($order as $cont => $iorder) {
                if ($cont > 0)
                    $this->Con->Sql .=", ";
                $this->Con->Sql .=$iorder;
            }
            $this->Con->Sql .= $typeOrder;
        }
        $this->Con->Sql .= $strlimit;
//	  print $this->Con->Sql."<br>";
//	  die();
        $this->Con->Consultar($continue);
        $this->Error = $this->Con->Error;
        if ($this->Error == 0) {
            $this->Lista = $this->Con->RtaSql;
            $this->NumReg = $this->Con->NumReg;
        }
        $this->Con->Desconectarse();
    }

    //Método para ver cada uno de los Registros de la Entidad de la lista en la Base de Datos
    function VerDatosEntidad($num, $afields, $speacial_char = true) {
        foreach ($afields as $item)
//		if($valor=mysqli_result($this->Lista,$num,$item)){
        //echo $item.'<br>';
            if (!is_null($this->Con->mysqli_result($this->Lista, $num, $item))) {
                if ($speacial_char) {
                    // print $this->Con->Sql."<br>";
                    $this->$item = str_replace(array('"', '<', '>'), array("&quot;", "&lt;", "&gt;"), stripslashes($this->Con->mysqli_result($this->Lista, $num, $item)));
                } else {
                    $this->$item = stripslashes($this->Con->mysqli_result($this->Lista, $num, $item));
                }
            } else {
                $this->$item = NULL;
            }
    }

    function getRow($fila, $fields, $noprint) {
        $array_result = array();
        foreach ($fields as $i_c => $item) {
            if (!in_array($i_c, $noprint))
                $array_result[] = stripslashes($this->Con->mysqli_result($this->Lista, $fila, $item));
            $this->$item = stripslashes($this->Con->mysqli_result($this->Lista, $fila, $item));
        }
        return $array_result;
    }

    function getRow2($fila, $fields, $allf) {
        $array_result = array();
        foreach ($allf as $item) {
            $this->$item = stripslashes($this->Con->mysqli_result($this->Lista, $fila, $item));
            if (in_array($item, $fields)) {
                $array_result[] = stripslashes($this->Con->mysqli_result($this->Lista, $fila, $item));
            }
        }
//echo "<pre>";
//print_r($array_result);
//echo "</pre>";
        return $array_result;
    }



}

/**
  -----------------------------------------------------------------
  Fin de la definicion de la clase Entidad
  -----------------------------------------------------------------
 */
?>