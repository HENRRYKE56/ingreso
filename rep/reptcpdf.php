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
        global $gotham;
        global $TITULO;
        //die($gotham);
        $this->setColorArray('text',array( 128 , 128 , 128 ));
        $this->SetFont($gotham, '', 12, '', false);
       // $this->SetFont('helvetica', '', 12);
        // Title
        $this->SetAbsXY(12, 32);        
        $this->Cell(271, 1, utf8_encode(''), "B", false, 'C', 0, '', 1, false, 'M', 'M');            
        $this->SetAbsXY(0, 17);
      //  $this->Cell(296, 10, utf8_encode('Secretaría de Sssssalud'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $this->SetAbsXY(0, 22);
//        $this->Cell(296, 10, utf8_encode('INSTITUTO MEXIQUENSE CONTRA LAS ADICCIONES'), 0, false, 'C', 0, '', 1, false, 'M', 'M');
        $this->SetFont($gotham, '', 8, '', false);
        //$this->SetFont('times', '', 8);        
        $this->SetAbsXY(12, 23);
   //     $this->Cell(57, 12, utf8_encode('GOBIERNO DEL'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAbsXY(12, 26);
    //    $this->Cell(57, 12, utf8_encode('ESTADO DE MÉXICO'), 0, false, 'C', 0, '', 1, false, 'M', 'M');        
        $this->SetAbsXY(12, 30);
        $this->Image("../img/gob_es_mex.jpg", 12, 11, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetAbsXY(12, 1);
        $this->Image("../images/logofondo.jpg", 262, 10, 20, '', 'JPG', '', 'T', false, 600, '', false, false, 0, false, false, false);
      //  $this->Image("../img/isem.jpg", 263, 25.5, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetAbsXY(15, 11);
        $this->setColorArray('text',array( 0 , 0 , 0 ));
        $this->SetFont($gotham, '', 10, '', false);
$html=$TITULO;
$imprime = <<<EOD
        
$html
EOD;

// print a block of text using Write()
$this->writeHTML($html, false, false, false, false, "");            
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
    global $ultimahoja;       
    global $gotham;
  //  echo '@'.$ultimahoja;
        if($ultimahoja<>true){
        $this->SetAbsXY(15, 187);        //barra separador
        $this->Cell(267, 1, utf8_encode(''),array('T' => array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))) , false, 'C', 0, '', 1, false, 'M', 'M');
        }        
        $this->SetY(-15);
        // Set font
        $this->SetFont($gotham, '', 8, '', false);
        //$this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Pagina ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF($p_orientacion,'mm',$p_tamano, true, 'ISO-8859-1', false); //l para horizontal  2 vertical
$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ingenieria');
$pdf->SetTitle('Actividades');
$pdf->SetSubject('Actividades');
$pdf->SetKeywords('Actividades');

$gothamb = TCPDF_FONTS::addTTFfont('lib/font/makefont/Gotham-Bold.ttf', 'TrueTypeUnicode', '', 32);
$gotham =  TCPDF_FONTS::addTTFfont('lib/font/makefont/gotham-book.ttf', 'TrueTypeUnicode', '', 32);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);

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
$pdf->AddPage();

//generar tabla principal
// set some text to print
$pdf->SetAbsXY(15, 40);
$pdf->SetFont($gotham, '', 10);

$html=$tabla_pintar2;
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
$ultimahoja=true;
$pdf->Output('reporte.pdf', 'I');