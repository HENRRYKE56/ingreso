<?php

session_start();
//include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");

$StrMsgErrorAll = array();
$StrMsgErrorAll[] = "NO se encontraron coincidencias ";

$a_vals = explode("::", trim($_POST['varval']));
//
/* echo "<pre>";
  print_r($a_vals);
  echo "</pre>";
  die(); */


if (isset($a_vals[2]) && $a_vals[2] <> '') {
    //print_r($a_vals[2]);

    /* HORARIOS DE CADA CONSULTORIO */
    if ($a_vals[0] != '') {
        $a_vals[0]=(implode('-', array_reverse(explode('/', $a_vals[0]))));    

        $pcWhere = " WHERE cve_consultorio=" . $a_vals[2] . " and cve_unidad='" . $__SESSION->getValueSession('cveunidad') . "'";
        $classconsultorio = new Entidad(array('inicio', 'fin',), array('', ''));
        $classconsultorio->ListaEntidades(array('inicio'), 'consultorios cons', $pcWhere); //order
        $classconsultorio->VerDatosEntidad(0, array('inicio', 'fin'));
        $c_h_inicio = $classconsultorio->inicio;
        $c_h_fin = $classconsultorio->fin;

        $inicio = str_replace(':', '', $c_h_inicio);
        //	echo "aaa<br/>";
        $final = str_replace(':', '', $c_h_fin);


        $inicio = substr($inicio, 0, 4);
        $final = substr($final, 0, 4);

        //$inicio1=substr($inicio,1,1);
        $inicio2 = substr($inicio, 0, 2);
        $final2 = substr($final, 0, 2);
        $final3 = $final2 - 01; //final de hora sin registro

        /* Horas y minutos el mismo dia */

        $fecha_max = date('Y-m-d');
        $fecha_max2 = date('Y-m-d H:i:s');
//hora
        $hini2 = substr($fecha_max2, 11, 2);
        $hini22 = 0;
        $hini22 = $hini2;

//minuto
        $mini2 = substr($fecha_max2, 14, 2);
        $mini22 = 0;

        $mini22 = $mini2;
//$mini22=41;
        /* fin de horas y minutos el mismo dia */

//echo $mini22;
//die();
    //    echo $hini22.'--'.$inicio2."----".$mini22;DIE();
        if ($hini22 < $inicio2) {
            $mini22 = 0;
        } else if (($mini22*1) > 0 && ($mini22*1) < 59) {
            $mini22 = 59;
        }

        /* FIN DE HORRARIOS DE CADA CONSULTORIO */

        //$pcWhere= " where fecha_cita=".'\''.$a_vals[0].'\' and cve_consultorio='.'\''.$a_vals[2].'\' and cve_servicio='.'\''.$a_vals[1].'\''.'\' and cve_unidad='.'\''.$__SESSION->getValueSession('cveunidad').'\'';

        /*         * ********REGISTRO EN TBL CITAS************ */

        $pcWhere = " WHERE fecha_cita ='" . $a_vals[0] . "'" . " and cve_consultorio=" . $a_vals[2] . " and cve_servicio=" . $a_vals[1] . " and cve_unidad='" . $__SESSION->getValueSession('cveunidad') . "'";
        $classconsul0 = new Entidad(array('fecha_ini', 'fecha_cita',), array('', ''));
        $classconsul0->ListaEntidades(array('fecha_ini'), 'citas_consulta', $pcWhere); //order

        /*         * ******************** */


        if ($fecha_max != $a_vals[0]) { //fecha no es actual *1
            /*             * ********HORARIOS DISPONIBLES************ */


            $pcWhere = " WHERE fecha ='" . $a_vals[0] . "'" . " and cve_consultorio=" . $a_vals[2] . " and cve_servicio=" . $a_vals[1] . " and cve_unidad='" . $__SESSION->getValueSession('cveunidad') . "'";
            $classconsul1 = new Entidad(array('fecha_ini', 'fecha',), array('', ''));
            $classconsul1->ListaEntidades(array('fecha_ini'), 'horarios', $pcWhere); //order

//            echo '<pre>';
//            print_r($classconsul0);die();


            /*             * *****SI EXITEN REGISTROS PARA LA FECHA EN LA TABLA DE CITAS Y EN LA DE HORARIOS********** */

            if ($classconsul0->NumReg > 0) {//*2
                if ($classconsul1->NumReg > 0) {//*3
                    for ($i = 0; $i < $classconsul1->NumReg; $i++) {//*4
                        $classconsul1->VerDatosEntidad($i, array('fecha_ini'));
                        $hora_val[] = substr($classconsul1->fecha_ini, 10, 18);
                        $hora_des[] = substr($classconsul1->fecha_ini, 10, 18);
                    }//*4
                }//3
                else {
                    /* no hay fechas */
                    $hora_val[0] = '';
                    $hora_des[0] = 'No disponible 1';
                }
            }else{
                if ($classconsul1->NumReg > 0) {//*3
                    for ($i = 0; $i < $classconsul1->NumReg; $i++) {//*4
                        $classconsul1->VerDatosEntidad($i, array('fecha_ini'));
                        $hora_val[] = substr($classconsul1->fecha_ini, 10, 18);
                        $hora_des[] = substr($classconsul1->fecha_ini, 10, 18);
                    }//*4
                }//3                
            }


            /*             * ********SI NO EXISTEN REGISTROS PARA LAS TBLS DE HORARRIOS Y CITAS************ */
            if ($classconsul0->NumReg == 0) {

                if ($classconsul1->NumReg == 0) {

                    for ($h = $inicio2; $h <= $final3; $h++) {
                        if ($h < 10) {
                            if ($h != $inicio2)
                                $h2 = '0' . $h;
                            else
                                $h2 = $h;
                        } else {
                            $h2 = $h;
                        }
                        $mfin = 59;
                        for ($m = 0; $m < $mfin; $m = $m + 59) {
                            if ($m < 10) {
                                $m2 = '0' . $m;
                            } else {
                                $m2 = $m;
                            }

                            $hora_val[] = $h2 . ":" . $m2 . ":00";
                            $hora_des[] = $h2 . ":" . $m2;
                        }
                    }
                }
            }
//*1			
        } else {//fecha es hoy
            $pcWhere = " WHERE fecha ='" . $a_vals[0] . "'" . " and cve_consultorio=" . $a_vals[2] . " and cve_servicio=" . $a_vals[1] . " and cve_unidad='" . $__SESSION->getValueSession('cveunidad') . "' and fecha_ini > '" . $fecha_max2 . "'";
            $classconsul1 = new Entidad(array('fecha_ini', 'fecha',), array('', ''));
            $classconsul1->ListaEntidades(array('fecha_ini'), 'horarios', $pcWhere);


            if ($classconsul0->NumReg > 0) {

                if ($classconsul1->NumReg > 0) {

                    for ($i = 0; $i < $classconsul1->NumReg; $i++) {
                        $classconsul1->VerDatosEntidad($i, array('fecha_ini'));
                        if(date("Y-m-d H:i:s",strtotime($classconsul1->fecha_ini) < date("Y-m-d H:i:s"))){
                            $hora_val[] = substr($classconsul1->fecha_ini, 10, 18);
                            $hora_des[] = substr($classconsul1->fecha_ini, 10, 18);                            
                        }
                    }
                } else {
                    /* no hay fechas */
                    $hora_val[0] = '';
                    $hora_des[0] = 'No disponible 2_1';
                }
            }else{
                if ($classconsul1->NumReg > 0) {

                    for ($i = 0; $i < $classconsul1->NumReg; $i++) {
                        $classconsul1->VerDatosEntidad($i, array('fecha_ini'));
                        if(date("Y-m-d H:i:s",strtotime($classconsul1->fecha_ini) < date("Y-m-d H:i:s"))){
                            $hora_val[] = substr($classconsul1->fecha_ini, 10, 18);
                            $hora_des[] = substr($classconsul1->fecha_ini, 10, 18);                            
                        }
                    }
                } else {

                }                
            }

            /* -------------------------------------------------- */
            /*             * ********SI NO EXISTEN REGISTROS PARA LAS TBLS DE HORARRIOS Y CITAS************ */
            if ($classconsul0->NumReg == 0) {

                if ($classconsul1->NumReg == 0) {//die($mini22."----");
                    if ($mini22 >= 59) {
                        $hini22 = $hini22 + 1;
                        $mini22 = 0;
                    }
                    $chi = 0;
                    if ($hini22 > $inicio2) {//validar al tomar la hora incial del copnsultorio
                        $chi = $chi + $hini22;
                    } else {
                        $chi = $chi + $inicio2;
                    }
                    
                    for ($h = $chi; $h <= $final3; $h++) {
                        if ($h < 10) {

                            if ($h != $hini22)
                                $h2 = '0' . $h;
                            else
                                $h2 = $h;
                        }
                        else {
                            $h2 = $h;
                        }
                        $mfin = 60;
                        
                     //   die(($mini22)."asdasda".$mfin);
                        for ($m = $mini22; $m < $mfin; $m = $m + 60) {
                            if ($m < 10) {
                                $m2 = '0' . $m;
                            } else {
                                $m2 = $m;
                            }

                            $mini22 = 0;
                            $hora_val[] = $h2 . ":" . $m2 . ":00";
                            $hora_des[] = $h2 . ":" . $m2;
                        }
                    }
                    if ($hora_val == '') {
                        $hora_val = array(' ');
                        $hora_des = array('No disponible 3');
                    }

                    //}else{
                    //$hora_val=array(' ');
                    //$hora_des=array('No disponible');
                    //}
                } else {
                    if ($classconsul1->NumReg > 0) {

                        for ($i = 0; $i < $classconsul1->NumReg; $i++) {
                            $classconsul1->VerDatosEntidad($i, array('fecha_ini'));
                            $hora_val[] = substr($classconsul1->fecha_ini, 10, 18);
                            $hora_des[] = substr($classconsul1->fecha_ini, 10, 18);
                        }
                    }
                }
            }
        }
    } else {
        $hora_val = array(' ');
        $hora_des = array('No disponible 4');
    }
}
$StrFisrst = array();
$StrFisrst[] = " - Hora - ";
$xml = ("<?xml version='1.0' encoding='ISO-8859-1'?>");
$xml .= '<datos>';
$xml .= '<elemento value="">' . $StrFisrst[$_POST['numAdd']] . '</elemento>';

if (sizeof($hora_val) > 0) {

    foreach ($hora_val as $i => $hora) {



        $xml .= '<elemento value="' . $hora . '">' . $hora_des[$i] . '</elemento>';
    }
}
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;
                    
?>

