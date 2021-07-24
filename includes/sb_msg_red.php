<?php 
echo genOTable(0,'100%','','','','2','0');
echo genORen().genCol($str_msg_red,'','','',$CFG_BGC[isset($i_intcolor)?$i_intcolor:8],'','',$CFG_LBL[isset($i_intstyle)?$i_intstyle:10]).genCRen()." \n";
echo genCTable();
?>