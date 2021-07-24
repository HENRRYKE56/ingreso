<?php

session_start();
//define('FPDF_FONTPATH','lib/font/');
Header('Pragma: public');
include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/ClassExtendPdf.php");
include_once("lib/lib32.php");


if (isset($_GET['fparam']) && !is_null($_GET['fparam']) and isset($_GET['cve_cita']) and strval($_GET['cve_cita']) < 100000) {
    include_once($_GET['fparam'] . '.php');
//<---  #### Variables
    $left = $LEFT_ROW;
    $top = 30;
    $top_postprint = 30;
    $array_RowGroups = array();
    $countHeadGroup = 0;
    $array_Sub_Row = array();
//$getValorCell - en uso
//#### Variables --->
    /**/

    $arrayRep = array();
    $classent = new Entidad($a_getn_fields, $a_getv_fields);
    $classent->ListaEntidades(array(), "", "", "", "no", "", $str_Qry);
//echo "<pre>";
//print_r($classent);
//echo "</pre>";

    $NUM_DRAW_ROW = 1;
    if ($classent->NumReg > 0) {
        $classent->VerDatosEntidad(0, $a_getn_fields);
        //$array_Row=array();//inicalizar row
        $array_Cols_Vals = array();
        $array_Cols_Lbls = array();
        $int_first_row = 0;
        foreach ($field_rep as $cnt_element_rep => $element_rep) {
            $getValorCell = '';
            if ($element_rep[3] == 1) {
                $str_Cell_Value = "";
                if ($element_rep[1] <> 0) {
                    foreach ($element_rep[0] as $cnt_item_f => $item_f) {
                        if ($cnt_item_f > 0)
                            $str_Cell_Value.=" ";
                        if (isset($element_rep[18]) && ($element_rep[18] == 1)) {
                            $str_Cell_Value.=$classent->$element_rep[19][$cnt_item_f];
                        } else {
                            $str_Cell_Value.=$classent->$item_f;
                        }
                    }
                } else {
                    if (isset($element_rep[18]) && ($element_rep[18] == 1)) {
                        $str_Cell_Value = $classent->$element_rep[19];
                    } else {
                        $str_Cell_Value = $classent->$element_rep[0];
                    }
                }
                $getValorCell = $str_Cell_Value;
                if ($element_rep[13] <> '') {//aplicar funcion en la posicion 13
                    eval("\$getValorCell=" . $element_rep[13] . '(' . $str_Cell_Value . ');');
                } else {
                    if ($element_rep[14] == 1)//aplicar funcion con valores alternos
                        $getValorCell = getDescript($str_Cell_Value, $element_rep[15][0], $element_rep[15][1]);
                }

                /* inicia insertar renglones de lbls libres */
                $found_pos = array_search($cnt_element_rep, $items_lblsrow);
                if ($found_pos === false)
                    $found_pos = -1;
                if ($found_pos >= 0) {
                    $array_Cols_Lbls2 = array();
                    foreach ($LBLSROW[$found_pos] as $item_LBLSROW) {
                        if ($item_LBLSROW[5] == 'new') {
                            $array_Cols_Lbls2[] = array($item_LBLSROW[2], $item_LBLSROW[0], $item_LBLSROW[3], $item_LBLSROW[1]);
                            if ($item_LBLSROW[4] == 1) {
                                $array_Row2 = array();
                                $array_Row2[] = array($HGT_ALL, $array_Cols_Lbls2, $FONT_ALL, $FONT_ALL_SZ, $CFG_RGB[10]);
                                $arrayRep[] = array($array_Row2, $items_lblsborder[$found_pos], 0, ($int_first_row == 1 ? 2 : 0), ($int_first_row == 1 ? 2 : 0),
                                    $LEFT_ROW, $top_postprint, $top_postprint, $DRW_ROW[$NUM_DRAW_ROW]);
                                $array_Cols_Lbls2 = array();
                                $int_first_row = 1;
                            }
                        } else {
                            $array_Cols_Vals[] = array($item_LBLSROW[2], $item_LBLSROW[0], $item_LBLSROW[3], $item_LBLSROW[1]);
                            if ($element_rep[16] == 0 || $element_rep[16] == 2 || $element_rep[16] == 2)
                                $array_Cols_Lbls[] = array($item_LBLSROW[2], '', $item_LBLSROW[3], $item_LBLSROW[1]);
                        }
                    }
                }
                /* termina insertar renglones de lbls libres */
                switch ($element_rep[16]) {
                    case 0:
                        $array_Cols_Lbls[] = array($element_rep[7], $element_rep[2], $element_rep[12], $element_rep[10]);
                        $array_Cols_Vals[] = array($element_rep[7], $getValorCell, $element_rep[12], $element_rep[10]);
                        break;
                    case 1:
                        $array_Cols_Vals[] = array($element_rep[16], $element_rep[2], $element_rep[11], $element_rep[10]);
                        $array_Cols_Vals[] = array($element_rep[7], $getValorCell, $element_rep[12], $element_rep[10]);
                        break;
                    case 2:
                        $array_Cols_Lbls[] = array($element_rep[7], $element_rep[2], $element_rep[12], $element_rep[10]);
                        $array_Cols_Vals[] = array($element_rep[7], $getValorCell, $element_rep[12], $element_rep[10]);
                        break;
                    case 3:
                        $array_Cols_Vals[] = array($element_rep[7], $getValorCell, $element_rep[12], $element_rep[10]);
                        $array_Cols_Vals[] = array(196 - $element_rep[7], $element_rep[2], $element_rep[11], $element_rep[10]);
                        break;
                    default:
                        $array_Cols_Vals[] = array($element_rep[16], $element_rep[2], $element_rep[11], $element_rep[10]);
                        $array_Cols_Vals[] = array($element_rep[7], $getValorCell, $element_rep[12], $element_rep[10]);
                        break;
                }
                if ($element_rep[17] == 1) {//salto de renglon
                    $array_Row = array();
                    $array_Row[] = array($HGT_ALL, $array_Cols_Vals, $FONT_ALL, $FONT_ALL_SZ, $CFG_RGB[10]);
                    $arrayRep[] = array($array_Row, ($element_rep[16] == 0 ? 'RBL' : ($element_rep[16] == 2 ? '0' : '1')),
                        0, ($int_first_row == 1 ? 2 : 0), ($int_first_row == 1 ? 2 : 0), $LEFT_ROW, $top_postprint, $top_postprint, $DRW_ROW[$NUM_DRAW_ROW]);
                    $array_Row = array();
                    $array_Row[] = array($HGT_LBL, $array_Cols_Lbls, $FONT_LBL, $FONT_LBL_SZ, $CFG_RGB[10]);
                    $arrayRep[] = array($array_Row, 0, 0, 2, 2, $LEFT_ROW, $top_postprint, $top_postprint, $DRW_ROW[$NUM_DRAW_ROW]);
                    $array_Cols_Vals = array();
                    $array_Cols_Lbls = array();
                    $int_first_row = 1;
                }
            }
        }
        //$arrayRep[]=array($array_Row,1,0,0,0,$LEFT_ROW,$top_postprint,$top_postprint,$DRW_ROW[$NUM_DRAW_ROW]);
    }

    /*
      Crear arreglo de encabezado ##########################################################################
     */
    $array_RowH = array(); //conjunto de tablas celda a pintar en el encabezado
    //$array_RowH[]=array(0.-<array> tabla a pintar, 1.-borde ,2.-valor inicial en x (0|1), 3.-valor inicial en y(0|1|2), 4.-valor por default en (0|1|2),
    //					  5.-valor x, 6.-valor y, 7.-valor default)
    //				   ###(0|1|2) 0: toma el valor inicial, 1: toma el valor despues de pintar una tabla, 2: toma el valor despues de un salto de linea despues de pintar una tabla
    $array_ColLbls = array();
    $array_Sub_ColLbls = array();
    $array_Row = array();
    $array_Sub_Row = array();

//	foreach ($field_rep as $cnt_element => $element_rep){
//		$array_ColLbls[]=array($element_rep[7],$element_rep[2],$element_rep[11],$element_rep[9]);
//		if ($cnt_element>10)
//			break;
//	}
    $array_ColLbls[] = array(100, "SERVICIO DE CONSULTA EXTERNA", 'C', $CFG_RGB[1]);
    $array_Row[] = array(3, $array_ColLbls, $FONT_LBL, 7, $CFG_RGB[1]);
    $array_RowH[] = array($array_Row, 0, 0, 0, 0, 58, 15, 15, $DRW_ROW[0]);
    $array_Row = array();
    $array_ColLbls = array();
    $array_ColLbls[] = array(100, "FICHA DE CITA", 'C', $CFG_RGB[1]);
    $array_Row[] = array(4, $array_ColLbls, $FONT_LBL, 5, $CFG_RGB[1]);

    //$array_RowH[]=array(<array> tabla a pintar, borde, valor inicial en x (0|1), valor inicial en y(0|1|2), valor por default en (0|1|2), valor x, valor y, valor default)

    $array_RowH[] = array($array_Row, 0, 0, 2, 0, 58, 15, 15, $DRW_ROW[0]);

    $array_Row = array(); //inicalizar row
    /*

      termina de crear arreglo de encabezado  #################################################################

     */

//Creación del objeto de la clase heredada
    class PDF extends ClassExtendPdf {

//Cabecera de página
        function Header() {
            global $countHeadGroup;
            global $array_RowGroups;
            global $left;
            global $top;
            global $top_postprint;
            global $array_RowH;
            $arrayPosXY = array();
            $this->SetFont('Arial', 'B', 6);
            $this->SetXY(18, 16);
            $this->Cell(40, 3, 'GOBIERNO DEL', 0, 1);
            $this->SetXY(18, 19);
            $this->Cell(40, 3, 'ESTADO DE MEXICO', 0, 1);
//		$this->SetXY(18,22);
//		$this->Cell(40,3,'SISTEMA INTEGRAL DE ACTIVO DE TECNOLOGIAS DE INFORMACION',0,1);
            $this->image("../img/gem1.jpg", 10, 12, 9, 10);
            $this->image("../img/isem.jpg", 171, 15, 22, 5);
//echo "<pre>";
//print_r($array_RowH);
//echo "</pre>";
//die();		
            foreach ($array_RowH as $element_RowH) {
                $arrayPosXY = $this->buildTable($element_RowH[0], ($element_RowH[2] == 0 ? $element_RowH[5] : $arrayPosXY[0]), ($element_RowH[3] == 0 ? $element_RowH[6] : ($element_RowH[3] == 1 ? $arrayPosXY[1] : $arrayPosXY[2])), $element_RowH[1], ($element_RowH[4] == 0 ? $element_RowH[7] : ($element_RowH[4] == 1 ? $arrayPosXY[1] : $arrayPosXY[2])), $element_RowH[8]);
            }
            $top_postprint = $arrayPosXY[2] + 5;
        }

        function genBody() {

            global $left;
            global $arrayRep;
            global $top_postprint;
            $arrayPosXY = array();
            //<------  ####### imprime body #######          
            $this->AddPage();
            foreach ($arrayRep as $element_RowB) {
                $arrayPosXY = $this->buildTable($element_RowB[0], ($element_RowB[2] == 0 ? $element_RowB[5] : $arrayPosXY[0]), ($element_RowB[3] == 0 ? $top_postprint : ($element_RowB[3] == 1 ? $arrayPosXY[1] : $arrayPosXY[2] + 1)), $element_RowB[1], ($element_RowB[4] == 0 ? $top_postprint : ($element_RowB[4] == 1 ? $arrayPosXY[1] : $arrayPosXY[2])), $element_RowB[8]);
            }
//		$this->Code39(10,36,$_GET['cve_cita'],1,7);
            //####### termina imprime body #######      -------->
        }

        function Footer() {
            global $__SESSION;
            $this->SetTextColor(0);
            //Posición: a 1,5 cm del final
            $this->SetY(-20);
            //Arial italic 8
            $this->SetFont('Arial', '', 4);
            //Número de página
            $this->Cell(0, 5, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
            //Posición: a 1,5 cm del final
            $this->SetY(-20);
            $strCode = base64_encode($_GET['fparam'] . $__SESSION->getValueSession('nomusuario') . date('Y/m/d') . $_GET['cve_ticket']);
            $this->Cell(0, 5, $strCode, 0, 0, 'L');
            $this->SetY(-20);
            $this->Cell(0, 5, date('d/m/Y'), 0, 0, 'R');
        }

    }

//$pdf=new PDF('P','mm',array(216,355));
    $pdf = new PDF('P', 'mm', array(210, 150));
    $pdf->AliasNbPages();
    $pdf->genBody();
    $pdf->Output();
}
?>
