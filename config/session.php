<?php
class Session
{
  public $existe_sessxjo;  
  public $SESIONID;      // RIGHT - Works INSIDE of a class definition.
  public $SCOPEBASE="NOIDENTIFIED";      // RIGHT - Works INSIDE of a class definition.
	function __construct($name) {
       $this->SCOPEBASE=$name;
	   $this->SESIONID=session_id();
           $this->existe_sessxjo++;
           $existe_sessxjo=$this->existe_sessxjo;
   }
   public function getSessionID()
  {
    return $this->SESIONID;
  }
  
  public function getValueSession($name,$type=false)
  {
      $retorna="";
      $bool_pasa=false;
      $bool_pasa_a=false;
      if( is_array($name)){
          $idname=($name);
          $bool_pasa=true;
          $bool_pasa_a=false;
      }else{
          $idname=trim($name."");
          if($idname<>"")$bool_pasa=true;
          $bool_pasa_a=isset($_SESSION[$this->SCOPEBASE][$idname]);
      }
	  
	  if ($bool_pasa and $bool_pasa_a)$retorna=$_SESSION[$this->SCOPEBASE][$idname];
	  else{
		if (!$type) $retorna= "";
		 else $retorna=false;
	  }
      return $retorna;
  }
  public function setValueSession($name,$value)
  {
	  $idname=trim($name);
	  if ($idname<>"")
	  $_SESSION[$this->SCOPEBASE][$idname]=$value;

  }
  public function unsetSession($name)
  {

	  $idname=trim($name);
	  if ($idname<>"" and isset($_SESSION[$this->SCOPEBASE][$idname]))
	  unset($_SESSION[$this->SCOPEBASE][$idname]);
    	
  }
   public function getAll($type=false)
  {	  
	  if (isset($_SESSION[$this->SCOPEBASE]))
    	return  $_SESSION[$this->SCOPEBASE];
	  else{
		if (!$type) return "";
		 else return false;
	  }
  }
    public function setValueItemSession($name,$item,$value)
  {

	  $idname=trim($name); $idiname=trim($item);	  
	  if ($idname<>"" && $idiname <> ""){
		  if (!isset($_SESSION[$this->SCOPEBASE][$name]))$_SESSION[$this->SCOPEBASE][$name]=array();
	  	$_SESSION[$this->SCOPEBASE][$idname][$item]=$value;
	  }
  }
   public function setAll($_SESSION_AUX)
  {	  
	  if (isset($_SESSION[$this->SCOPEBASE]))
            $_SESSION[$this->SCOPEBASE]=$_SESSION_AUX;
  }  
}

?>