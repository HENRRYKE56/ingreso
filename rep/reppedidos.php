<?php

session_start();
include_once("../config/cfg.php");
require_once('tcpdf/tcpdf_include.php');
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once($_GET['fparam'] . ".php");
global $ultimahoja;

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        global $TITULO;
        global $nombre;
        global $arreglo_en;
        global $tabla_titulos;
        $this->SetFont('helvetica ', 'B', 10);
		
        // Title
        $this->SetAbsXY(29, 19);
        $this->Cell(0, 1, utf8_encode('Gobierno del Estado de México'), "", false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(29, 24);
        $this->SetFont('helvetica ', 'B', 9);
        $this->Cell(0, 1, utf8_encode('Instituto de Salud del Estado de México'), "", false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(29, 29);
        $this->SetFont('helvetica ', '', 9);
        $this->Cell(0, 1, utf8_encode($nombre), "", false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(12, 30);
        $this->Image("../img/gem1.jpg", 11, 11, 17, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetAbsXY(12, 1);
        $this->Image("../img/isem.jpg", 261, 19, 24, '', 'JPG', '', 'T', false, 600, '', false, false, 0, false, false, false);

        //$ar_cms=array('CVEPED','CVEPROV','NOMPRO','Dirprov','CONDIPAG','CONDIENTRE','LUGENTRE','MONTO','CVEUNI','nomuni','cvelic','FECPED','FECLIM');        
//        echo '<pre>';
//        print_r( $arreglo_en);die();
        $bor_en = 0;
        $this->SetFont('helvetica ', 'B', 8);
        $this->SetAbsXY(14, 35);
        $this->Cell(0, 3, utf8_encode('PEDIDO DE COMPRAS DE MEDICAMENTOS Y MATERIAL DE CURACIÓN'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(130, 39);
        $this->Cell(27, 3, utf8_encode('Clave'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(157, 39);
        $this->Cell(80, 3, utf8_encode('Unidad'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(237, 39);
        $this->Cell(0, 3, utf8_encode('HOJA') . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), $bor_en, false, 'R', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(130, 43);
        $this->Cell(27, 3, utf8_encode('' . $arreglo_en['CVEUNI']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->SetAbsXY(157, 43);
        $this->Cell(80, 3, utf8_encode('' . $arreglo_en['nomuni']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(11, 47);
        $this->Cell(35, 3, utf8_encode('No. de Pedido'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(111, 3, utf8_encode('' . $arreglo_en['CVEPROV'] . '   ' . $arreglo_en['NOMPRO']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(25, 3, utf8_encode('Licitación'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(40, 3, utf8_encode($arreglo_en['cvelic']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(11, 51);
        $this->Cell(35, 3, utf8_encode('Domicilio'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(111, 3, utf8_encode('' . $arreglo_en['Dirprov']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(25, 3, utf8_encode('Fecha de Pedido'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(40, 3, utf8_encode($arreglo_en['FECPED']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(11, 55);
        $this->Cell(35, 3, utf8_encode('Condiciones de Pago'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(111, 3, utf8_encode('' . $arreglo_en['CONDIPAG']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(25, 3, utf8_encode('Fecha de Entrega'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(40, 3, utf8_encode($arreglo_en['FECLIM']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(11, 59);
        $this->Cell(35, 3, utf8_encode('Condiciones de Entrega'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(111, 3, utf8_encode('' . $arreglo_en['CONDIENTRE']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(11, 63);
        $this->Cell(35, 3, utf8_encode('Lugar de Entrega'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(111, 3, utf8_encode('' . $arreglo_en['LUGENTRE']), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $cant = explode(".", $arreglo_en['MONTO']);
        $can_dec = "";


        $this->SetAbsXY(11, 67);
        $this->Cell(35, 3, utf8_encode('Monto Global'), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');
        $this->Cell(0, 3, utf8_encode('$' . $arreglo_en['MONTO'] . "     " . convertir($cant[0]) . " pesos " . $cant[1] . "/100 M.N."), $bor_en, false, 'L', 0, '', 1, false, 'M', 'M');

        $this->SetAbsXY(6, 75);

        $html = $tabla_titulos;
//echo ''.$html;die();
        $imprime = <<<EOD
        
$html
EOD;

        $this->writeHTML($html, false, false, false, false, "");
        $this->SetAbsXY(6, 76);
        $this->Cell(0, 4, utf8_encode(''), 1, false, 'L', 0, '', 1, false, 'M', 'M');  
        $this->SetAbsXY(6, 126);
        $this->Cell(0, 96, utf8_encode(''), 1, false, 'L', 0, '', 1, false, 'M', 'M');        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        global $ultimahoja;
        global $gotham;
        global $arreglo_firmas;
        global $referencia;
        $this->SetY(-22.5);
        $this->Cell(0, 27, utf8_encode(''), 1, false, 'L', 0, '', 1, false, 'M', 'M');           
        
        
        
        if ($referencia) {
            $this->SetFont('helvetica', '', 8);
            $aumento = 0;
            $ar_t_f=array("ELABORO","VO.BO","AUTORIZA","RECIBE");
            $conta=0;
            foreach ($arreglo_firmas as $key => $value) {
                $this->SetY(-19);
                $this->SetX(12 + $aumento);                
                $this->Cell(60, 7,"NOMBRE Y FIRMA", 'T', false, 'C', 0, '', 0, false, 'T', 'M');
                $this->SetY(-16);
                $this->SetX(12 + $aumento); 
                $this->Cell(60, 7, utf8_encode($key), '', false, 'C', 0, '', 0, false, 'T', 'M');

                $this->SetY(-36);
                $this->SetX(12 + $aumento);
                $this->Cell(60, 7, utf8_encode($ar_t_f[$conta]), 'T', false, 'C', 0, '', 0, false, 'T', 'M');
                $this->SetY(-25);
                $this->SetX(12 + $aumento);                
                $this->Cell(60, 7, utf8_encode($value), '', false, 'C', 0, '', 0, false, 'T', 'M');
                $aumento += 71;
                $conta++;
            }
        }
        $this->SetFont('helvetica', '', 6);
        $this->SetY(-7);
        $this->SetX(6);
        $this->Cell(0, 4,date('d/m/Y H:i:s'), 0, false, 'R', 0, '', 1, false, 'M', 'M');          
    }

}

// create new PDF document
$pdf = new MYPDF($p_orientacion, 'mm', $p_tamano, true, 'ISO-8859-1', false); //l para horizontal  2 vertical
//$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ingenieria');
$pdf->SetTitle('Actividades');
$pdf->SetSubject('Actividades');
$pdf->SetKeywords('Actividades');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(6, 78, 5);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 35);
//die(PDF_MARGIN_BOTTOM."fdsfsdfsd ");
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
// add a page
$pdf->AddPage();

//generar tabla principal
// set some text to print
$pdf->SetAbsXY(6, 78);
$pdf->SetFont('helvetica ', '', 7);

$html = $tabla_pintar2;
//echo ''.$html;die();
$imprime = <<<EOD
        
$html
EOD;
//$pdf->SetFont($gotham, '', 5);
//$pdf->SetFont('times', '', 10);
// print a block of text using Write()
$pdf->writeHTML($html, false, false, false, false, "");
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
$ultimahoja = true;
$pdf->Output('reporte.pdf', 'I');

function basico($numero) {
    $valor = array('uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho',
        'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidos', 'veintitres', 'veinticuatro', 'veinticinco',
        'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve');
    return $valor[$numero - 1];
}

function decenas($n) {
    $decenas = array(30 => 'treinta', 40 => 'cuarenta', 50 => 'cincuenta', 60 => 'sesenta',
        70 => 'setenta', 80 => 'ochenta', 90 => 'noventa');
    if ($n <= 29)
        return basico($n);
    $x = $n % 10;
    if ($x == 0) {
        return $decenas[$n];
    } else
        return $decenas[$n - $x] . ' y ' . basico($x);
}

function centenas($n) {
    $cientos = array(100 => 'cien', 200 => 'doscientos', 300 => 'trecientos',
        400 => 'cuatrocientos', 500 => 'quinientos', 600 => 'seiscientos',
        700 => 'setecientos', 800 => 'ochocientos', 900 => 'novecientos');
    if ($n >= 100) {
        if ($n % 100 == 0) {
            return $cientos[$n];
        } else {
            $u = (int) substr($n, 0, 1);
            $d = (int) substr($n, 1, 2);
            return (($u == 1) ? 'ciento' : $cientos[$u * 100]) . ' ' . decenas($d);
        }
    } else
        return decenas($n);
}

function miles($n) {
    if ($n > 999) {
        if ($n == 1000) {
            return 'mil';
        } else {
            $l = strlen($n);
            $c = (int) substr($n, 0, $l - 3);
            $x = (int) substr($n, -3);
            if ($c == 1) {
                $cadena = 'mil ' . centenas($x);
            } else if ($x != 0) {
                $cadena = centenas($c) . ' mil ' . centenas($x);
            } else
                $cadena = centenas($c) . ' mil';
            return $cadena;
        }
    } else
        return centenas($n);
}

function millones($n) {
    if ($n == 1000000) {
        return 'un millón';
    } else {
        $l = strlen($n);
        $c = (int) substr($n, 0, $l - 6);
        $x = (int) substr($n, -6);
        if ($c == 1) {
            $cadena = ' millón ';
        } else {
            $cadena = ' millones ';
        }
        return miles($c) . $cadena . (($x > 0) ? miles($x) : '');
    }
}

function convertir($n) {
    switch (true) {
        case ( $n >= 1 && $n <= 29) : return basico($n);
            break;
        case ( $n >= 30 && $n < 100) : return decenas($n);
            break;
        case ( $n >= 100 && $n < 1000) : return centenas($n);
            break;
        case ($n >= 1000 && $n <= 999999): return miles($n);
            break;
        case ($n >= 1000000): return millones($n);
    }
}
