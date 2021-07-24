<?php
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("config/cfg.php");
    include_once("lib/lib_function.php");
    include_once("includes/sb_ii_refresh.php");
} else {
        include_once("config/cfg.php");
        include_once("lib/lib_pgsql.php");
        include_once("lib/lib_entidad.php");
        $lbl_tit_mov = ""; //"[ Criterios de Reporte ]";

        /* < --- Inicia mensaje de error de accion--- > */

        if (strlen($__SESSION->getValueSession('msg')) > 1) {
            $str_msg_red = "";
            $i_intstyle = 19;
            $i_intcolor = 6;
            for ($i = 0; $i < (strlen($__SESSION->getValueSession('msg')) / 3); $i++) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red.=',&nbsp;&nbsp;';
                $str_msg_red.=$CFG_MSG[(substr($__SESSION->getValueSession('msg'), $i * 3, 3) * 1)];
            }
            $__SESSION->setValueSession('msg', 0);
            include("includes/sb_msg_bob.php");
        }
        /* < --- Termina mensaje de error --- > */

        /* < --- Inicia mensaje de error de validacion --- > */

        if ($__SESSION->getValueSession('msgval') && strlen($__SESSION->getValueSession('msgval')) > 0) {
            $str_msg_red = "";
            $i_intstyle = 29;
            $i_intcolor = 6;
            $a_msgval = explode(',', $__SESSION->getValueSession('msgval'));
            foreach ($a_msgval as $ifield) {
                if (strlen($str_msg_red) > 0)
                    $str_msg_red.=',<br>';
                $str_msg_red.=$field[$ifield][1] . ": " . $CFG_MSG[6];
            }
            $__SESSION->setValueSession('msgval', '');
            include("includes/sb_msg_bob.php");

        }
        /* < --- Termina mensaje de error --- > */


        /* -------------valores de session, si es que los hay------------- */
        if ($__SESSION->getValueSession('a_tmpValues')) {
            if (!is_null($__SESSION->getValueSession('a_tmpValues'))) {
                $add_tmpValues = $__SESSION->getValueSession('a_tmpValues');
                //print_r($_SESSION['a_tmpValues']);
                $__SESSION->getValueSession('a_tmpValues') == "";
                $allvalues = array();
                $cont = 0;
                //print_r($a_tmpValues);
                foreach ($field as $afield) {
                    if ($afield[4] == '1' || $afield[4] == '2') {
                        $allvalues[] = $add_tmpValues[$cont];
                        $cont++;
                    } else {
                        $allvalues[] = $afield[7];
                    }
                }
            }
        }
        //print_r($allvalues);
        $classind = new Entidad($allfields, $allvalues);

        /* ------------------------------- */
        $twidth = ($awidths[1] + $awidths[2] > 800 ? ($awidths[1] + $awidths[2]) : 800);


        $vars_obj = "";
        $array_obj = $field;

        $bdate = 0;
        $vars_post = "";
        if (isset($a_check)) {
            foreach ($a_check as $cont_chk => $afield) {
                if (strlen($vars_post) > 0)
                    $vars_post.=",";
                $vars_post.="'chk" . $cont_chk . "'";
                foreach ($afield[1] as $afield2) {
                    if (strlen($vars_post) > 0)
                        $vars_post.=",";
                    $vars_post.="'" . $afield2 . "'";
                }
            }
        }

        if (isset($vparitem)) {
            //$str_vparfile='vparfile'.$field[$vparitem][7];
            $str_vparfile = $field[$vparitem][0];
        }
//
//    echo' <div class="breadcrumb-holder container-fluid">
//            <ul class="breadcrumb text-center" style="margin-bottom: 0px;padding: 0.1rem 1rem;">
//              <li class="breadcrumb-item active h5 font-weight-bold text-center text-dark">'.$entidad.'</li>
//            </ul>
//          </div>
//          ';     


        echo '<div class="content m-1">
                <div class="animated fadeIn">
                    <div class="row">';
        echo '        <div class="col-12 col-sm-2">
                        <div class="row">
                            <div class="col-12"><div class="alert alert-success text-danger text-center bg-white">
  <strong>'.$entidad.'</strong>
</div>
                            </div>
                            <div class="col-12">
                                '.$botones.'
                            </div>
                            '.$select_div.'
                            <div class="col-12">
                                '.$botones1.'
                            </div>                                
                        </div>
     
                      </div>';     
        echo '        <div class="col-12 col-sm-9 bg-white rounded border border-light">
                        <div class="box box-primary">
                            <div class="box-body no-padding">
                                <div id="calendar"></div>
                            </div>
                        </div>
                      </div>';
 
        echo '      </div>'
        . '     </div>'
        . '   </div>';

}

?>

