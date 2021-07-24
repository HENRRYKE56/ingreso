<?php 

function getDescript($value,$optValues,$optDescript){
$strRet=" ";
foreach ($optValues as $count_isel => $isel)
	if (trim($isel)==trim($value))
		return $optDescript[$count_isel];
return $strRet;	
}


?>