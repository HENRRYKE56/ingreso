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
  function Entidad($allitems,$allvalues) {
   	foreach ($allitems as $c_item => $item){
      $this->$item = $allvalues[$c_item];
	}
  $this->Con = new Pgsql;
  $this->Lista = null;
  $this->NumReg = 0;
  $this->RowsAfected=0;
  $this->Info="";
   }
   
   //Asigna atributos de la clase Entidad
   function Set_Entidad($avalues,$afields) {
   	foreach ($afields as $c_item => $item)
      $this->$item = $avalues[$c_item];
   }
  
  //funcion que asigna valor a un item de la clase
   function Set_Item($item, $value) {
      $this->$item = $value;
   }
  
   //M?todo para adicionar un registro de la Entidad a la Base de Datos
   function Adicionar($avalues,$afields,$atypes,$tabla) {
        $this->Con->Conectarse();
		$cont=0;
		$this->Con->Sql = "INSERT INTO $tabla (";
		foreach ($afields as $item){
			if ($cont>0){$this->Con->Sql .= ", ";}
			$this->Con->Sql .= $item;
			$cont+=1;
		}
		$cont=0;
		$this->Con->Sql .=") VALUES (";
		foreach ($avalues as $value){
			if ($cont>0){$this->Con->Sql .= ", ";}
			if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int'){
				$strtmpint=str_replace(array('$',','),array('',''), $value);
				$value = $strtmpint * 1;
				//$value=(strstr($strtmpint, '.')? number_format($strtmpint, 2, '.', ''):$strtmpint)*1;
			}
			if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int'){$this->Con->Sql .= $value;
			}else{
				if ($atypes[$cont] == 'char'){$this->Con->Sql .= "'" . addslashes($value) . "'";}
				else{$this->Con->Sql .= "'" . addslashes($value) . "'";}
			}
			$cont+=1;
		}
		$this->Con->Sql .=")";
//		echo $this->Con->Sql;
//		die();
		$this->Con->Actualizar();
		$this->Con->Desconectarse();
   }
//M?todo para adicionar un registro de la Entidad a la Base de Datos
   function AdicionarSelf($afields,$tabla,$strvalues='') {
        $this->Con->Conectarse();
		$cont=0;
		$this->Con->Sql = "INSERT INTO $tabla (";
		foreach ($afields as $item){
			if ($cont>0){$this->Con->Sql .= ", ";}
			$this->Con->Sql .= $item;
			$cont+=1;
		}
		$cont=0;
		$this->Con->Sql .=") " . $strvalues;
		//echo $this->Con->Sql;
		//die();
		$this->Con->Actualizar();
		$this->Con->Desconectarse();
   }
//M?todo para modificar la informacion de un registro de la Entidad en la Base de Datos
   function CmdSelfDB($avalues,$afields,$atypes,$tabla,$cond) {
      $this->Con->Conectarse();
      $this->Con->Sql = "update $tabla set ";
		$cont=0;
		foreach ($afields as $item){
			if ($cont>0){$this->Con->Sql .= ", ";}
			$this->Con->Sql .= $item."=";
			if (strlen(trim($avalues[$cont]))>0){
				$this->Con->Sql .=   $avalues[$cont] ;
			} else {
				$this->Con->Sql .= 'NULL';
			}
			$cont+=1;
		}
	  //$this->Con->Sql .= " WHERE " . $cond . "= " . $this->$cond;
	  $this->Con->Sql .= " WHERE " . $cond;
//	  echo $this->Con->Sql;
//	  die();
      $this->Con->Actualizar();
      $this->Con->Desconectarse();
   }
	function ExecuteQryDB($qry) {
	  $this->RowsAfected=0;
	  $this->InfoQry="";
      $this->Con->Conectarse();
	  $this->Con->Sql = $qry;
      $this->Con->Actualizar();
	  $this->Info=$this->Con->InfoQry;
	  $this->RowsAfected=$this->Con->RowsAfected;
      $this->Con->Desconectarse();
   }
   //M?todo para modificar la informacion de un registro de la Entidad en la Base de Datos
   function Modificar($avalues,$afields,$atypes,$tabla,$cond) {
      $this->Con->Conectarse();
      $this->Con->Sql = "update $tabla set ";
		$cont=0;
		foreach ($afields as $item){
			if ($cont>0){$this->Con->Sql .= ", ";}
			if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int'){
				$strtmpint=str_replace(array('$',','),array('',''), $avalues[$cont]);
				$avalues[$cont] = $strtmpint * 1;
				//$avalues[$cont]=(strstr($strtmpint, '.')? number_format($strtmpint, 2, '.', ''):$strtmpint)*1;
			}
			$this->Con->Sql .= $item."=";
			if (strlen(trim($avalues[$cont]))>0){
				if ($atypes[$cont] == 'money' || $atypes[$cont] == 'int'){$this->Con->Sql .= $avalues[$cont];
				}else{
					if ($atypes[$cont] == 'char'){$this->Con->Sql .= "'" . addslashes($avalues[$cont]) . "'";}
					else{$this->Con->Sql .= "'" . addslashes($avalues[$cont]) . "'";}
				}
			} else {
				$this->Con->Sql .= 'NULL';
			}
			$cont+=1;
		}
	  //$this->Con->Sql .= " WHERE " . $cond . "= " . $this->$cond;
	  $this->Con->Sql .= " WHERE " . $cond;
	  //echo $this->Con->Sql;
	  //die();
      $this->Con->Actualizar();
      $this->Con->Desconectarse();
   }

   //M?todo para eliminar un registro de la Entidad de la Base de Datos
   function Eliminar($tabla,$setdel,$cond,$set=0,$strcond='') {
      $this->Con->Conectarse();
	  if ($set==0){
		  $this->Con->Sql = "update " . $tabla . " set " . $setdel . "='" . $this->$setdel . "' WHERE " . $cond . "= " . $this->$cond;
	  }else{
        $this->Con->Sql = "DELETE FROM $tabla WHERE ".$strcond;
	  }
	 // echo $this->Con->Sql; die();
	  $this->Con->Actualizar();
	  $this->Con->Desconectarse();
   }

   //M?todo para consultar la informaci&oacute;n de un registro de la Entidad de la Base de Datos
   function Consultar($afields,$Id,$tabla,$strWhere="",$strQry="") {
      $this->Con->Conectarse();
		if (strlen($strQry)>0) {
			$this->Con->Sql = $strQry;
		}else{
		  if (strlen($strWhere)>0){
			$this->Con->Sql = "SELECT * FROM $tabla $strWhere";
		  } else {
			$this->Con->Sql = "SELECT * FROM $tabla WHERE " . $Id . "= " . $this->$Id;
		  }
		} 
//	  print $this->Con->Sql;
      $this->Con->Consultar();
	  $this->NumReg = $this->Con->NumReg;
      if ($this->Con->NumReg > 0) {
			$afielsRet=array();
			for ( $i=0; $i<mysql_num_fields($this->Con->RtaSql); $i++)
				$afielsRet[]=mysql_field_name($this->Con->RtaSql, $i);
			
			foreach ($afields as $item){
			if (in_array($item,$afielsRet))
			   $this->$item = str_replace(array('"','<','>'),array("&quot;","&lt;","&gt;"),stripslashes(mysql_result($this->Con->RtaSql,0,$item)));
			}
		}
//echo "<pre>";
//print_r($afields);
//echo "</pre>";
      $this->Con->Desconectarse();
   }

   //M?todo para listar los registros de la Entidad del sistema registrados en la Base de Datos
   function ListaEntidades($order,$tabla="",$strWhere="",$strItems="",$ord="", $strlimit="",$strQryAdd="", $typeOrder="") {//,$grp=""
   		if ($ord=="no"){
			$strorder="";
		} else{
			$strorder="ORDER BY";
		}
      $this->Con->Conectarse();
	  if (strlen($strQryAdd)>0){
	  	$this->Con->Sql = $strQryAdd;
	  } else{
		  if (strlen(trim($strItems))>0){
			$this->Con->Sql = "SELECT $strItems FROM $tabla $strWhere $strorder ";
		  } else {
			$this->Con->Sql = "SELECT * FROM $tabla $strWhere $strorder ";
		  }
	  }
//	  if (strlrn(trim($grp))>0)
//	  	$this->Con->Sql .= " $grp ";
	  if ($ord<>"no"){
		  foreach ($order as $cont => $iorder){
			if ($cont>0)
				$this->Con->Sql .=", ";
			$this->Con->Sql .=$iorder;
		  }
		  $this->Con->Sql .= $typeOrder;
		}
	  $this->Con->Sql .= $strlimit;
//	  print $this->Con->Sql."<br>";
//	  die();
      $this->Con->Consultar();
      $this->Lista = $this->Con->RtaSql;
      $this->NumReg = $this->Con->NumReg;
      $this->Con->Desconectarse();
   }
   //M?todo para ver cada uno de los Registros de la Entidad de la lista en la Base de Datos
   function VerDatosEntidad($num,$afields,$speacial_char=true) {	  
   	foreach ($afields as $item)
//		if($valor=mysql_result($this->Lista,$num,$item)){
		if(!is_null(mysql_result($this->Lista,$num,$item))){	
		if ($speacial_char){
			$this->$item = str_replace(array('"','<','>'),array("&quot;","&lt;","&gt;"),stripslashes(mysql_result($this->Lista,$num,$item)));}else{
			$this->$item = stripslashes(mysql_result($this->Lista,$num,$item));
			}
		}else{
			$this->$item = NULL;
		//	print_r($afields);
		//	echo("aqui". $num);
			
			}
   }
   function getRow($fila,$fields,$noprint){
		$array_result=array();
		foreach ($fields as $i_c => $item){
			if (!in_array($i_c,$noprint))
				$array_result[]= stripslashes(mysql_result($this->Lista,$fila,$item));
			$this->$item = stripslashes(mysql_result($this->Lista,$fila,$item));
			}
		return $array_result;
	}
   function getRow2($fila,$fields,$allf){
		$array_result=array();
		foreach ($allf as $item){
			$this->$item = stripslashes(mysql_result($this->Lista,$fila,$item));
			if (in_array($item,$fields)){
				$array_result[]= stripslashes(mysql_result($this->Lista,$fila,$item));}
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