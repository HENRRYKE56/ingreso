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
        global $tabla_pintarxls;
      

       
       // $this->SetFont('helvetica', '', 12);
        // Title
        $this->SetAbsXY(12, 32);        
        $this->Cell(271, 1, utf8_encode(''), "B", false, 'C', 0, '', 1, false, 'M', 'M');            
        $this->SetAbsXY(0, 17);
        $this->Cell(296, 10, utf8_encode('Escuela Normal Superior del Valle de Toluca'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAbsXY(0, 22);
        $this->Cell(296, 10, utf8_encode('Reporte de Examen de Ingreso 2021'), 0, false, 'C', 0, '', 1, false, 'M', 'M');
        //$this->SetFont('times', '', 8);        
        $this->SetAbsXY(115, 27);
        $this->Cell(57, 12, date("d-m-Y "), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAbsXY(12, 26);
    //    $this->Cell(57, 12, utf8_encode('ESTADO DE M�XICO'), 0, false, 'C', 0, '', 1, false, 'M', 'M');        
    
        $this->SetAbsXY(15, 11);
        $this->setColorArray('text',array( 0 , 0 , 0 ));


        
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


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font


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
//echo $tabla_pintarxls;
$html=$tabla_pintarxls;


//$pdf->SetFont($gotham, '', 5);
//$pdf->SetFont('times', '', 10);
// print a block of text using Write()
$pdf->writeHTML($html, false, false, false, false, "");
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
$ultimahoja=true;
$pdf->Output('reporte.pdf', 'I');