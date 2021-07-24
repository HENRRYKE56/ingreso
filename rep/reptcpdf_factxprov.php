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

        $this->SetAbsXY(15, 19);
        $this->setColorArray('text', array(0, 0, 0));
        $this->SetFont('helvetica ', '', 7);
        $html = $TITULO;
        $imprime = <<<EOD
        
$html
EOD;

// print a block of text using Write()
        $this->writeHTML($html, false, false, false, false, "");
        $this->SetAbsXY(6, 35);
        $this->SetFont('helvetica ', '', 9);
        $this->Cell(286, 1, utf8_encode(''), "B", false, 'L', 0, '', 1, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        global $ultimahoja;
        global $gotham;
        global $arreglo_firmas;
        global $referencia;
        if ($ultimahoja <> true) {
            $this->SetAbsXY(15, 187);
            $this->Cell(267, 1, utf8_encode(''), array('T' => array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))), false, 'C', 0, '', 1, false, 'M', 'M');
        }
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 6);
        $this->Cell(0, 10, '' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, '' . date('H:i:s    d/m/Y          '), 0, false, 'R', 0, '', 0, false, 'T', 'M');


        if ($referencia) {
            $this->SetFont('helvetica', '', 8);
            $aumento = 0;
            foreach ($arreglo_firmas as $key => $value) {
                $this->SetY(-25);
                $this->SetX(12 + $aumento);
                $this->Cell(82, 7, utf8_encode($key), 'T', false, 'C', 0, '', 0, false, 'T', 'M');

                $this->SetY(-36);
                $this->SetX(12 + $aumento);
                $this->Cell(82, 7, utf8_encode($value), '', false, 'C', 0, '', 0, false, 'T', 'M');
                $aumento += 94;
            }
        }
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
$pdf->SetMargins(6, 35, 5);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
// add a page
//generar tabla principal
// set some text to print
$pdf->SetAbsXY(6, 40);
$pdf->SetFont('helvetica ', '', 7);

for ($index = 0; $index < count($ar_tabs_pdf); $index++) {
    $pdf->AddPage();
    $html = $ar_tabs_pdf[$index];
    $imprime = <<<EOD
$html
EOD;
    $pdf->writeHTML($html, false, false, false, false, "");
}

$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
$ultimahoja = true;
$pdf->Output('reporte.pdf', 'I');
