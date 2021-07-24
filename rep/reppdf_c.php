<?php
session_start();
//define('FPDF_FONTPATH','lib/font/');
include_once("../config/cfg.php");
include_once("../lib/lib_pgsql.php");
include_once("../lib/lib_entidad.php");
include_once("lib/ClassExtendPdf.php");
include_once("lib/lib32.php");
//die("reih".$_GET['fparam']);
if (isset($_GET['fparam']) && !is_null($_GET['fparam'])){
include_once($_GET['fparam'].".php");
//<---  #### Variables
$left=$LEFT_ROW;
$top=50;
$top_postprint=50;
//$getValorCell - en uso
//#### Variables --->
/**/
//Creación del objeto de la clase heredada
class PDF extends ClassExtendPdf {
//Cabecera de página
	function Header(){
		global $countHeadGroup;
		global $array_RowGroups;
		global $left;
		global $top;
		global $top_postprint;
		global $array_RowH;
		global $p_orientacion;
		global $p_tamano;
		global $tiporep;
		
		$arrayPosXY=array();
		
		
//	$this->SetFont('Arial','B',9);
//	$this->SetXY(30,24);
//	$this->Cell(40,4,'GOBIERNO DEL',0,1);
//	$this->SetXY(30,28);
//	$this->Cell(40,4,'ESTADO DE MEXICO',0,1);
//     $this->image("../img/gem1.jpg",10,10,20,22);
//
//	 $this->image("../img/isem.jpg",233,24,33,8);
		

		
//echo "<pre>";
//print_r($array_RowH);
//echo "</pre>";
//die();		
		

		foreach ($array_RowH as $element_RowH){
			$arrayPosXY=$this->buildTable($element_RowH[0],($element_RowH[2]==0?$element_RowH[5]:$arrayPosXY[0]),
										 ($element_RowH[3]==0?$element_RowH[6]:($element_RowH[3]==1?$arrayPosXY[1]:$arrayPosXY[2])),
										  $element_RowH[1],
										 ($element_RowH[4]==0?$element_RowH[7]:($element_RowH[4]==1?$arrayPosXY[1]:$arrayPosXY[2])),$element_RowH[8]);
		}
			
				$top_postprint=$arrayPosXY[2];
			
		
		if(isset($p_orientacion) && $p_orientacion=='P' ){
			if(isset($tiporep) && ($tiporep=='salida' || $tiporep=='entrada')){
					$this->SetTextColor(0,0,0);//set font to black
					$this->SetFont('Arial','B',7);
					$this->SetXY(22,20);
					$this->Cell(40,3,'GOBIERNO DEL ESTADO DE MEXICO',0,1);
					$this->SetXY(22,23);
					$this->Cell(40,3,'INSTITUTO DE SALUD DEL ESTADO DE MEXICO',0,1);
					$this->image("../img/gem1.jpg",10,12,12,14);
					$this->image("../img/isem.jpg",181,18,24,6);			
							       

			}else{
					$this->SetFont('Arial','',9);
					$this->SetXY(30,23);
					$this->Cell(40,4,'GOBIERNO DEL',0,1);
					$this->SetFont('Arial','B',9);
					$this->SetXY(30,26);
					$this->Cell(40,4,'ESTADO DE MEXICO',0,1);
				 $this->image("../img/gem1.jpg",10,10,20,22);
					$this->image("../img/isem.jpg",170,24,33,8);
				}
		}else {
		$this->SetFont('Arial','',9);
		$this->SetFont('Arial','',9);
		$this->SetXY(30,23);
		$this->Cell(30,4,'GOBIERNO DEL',0,1);
		$this->SetFont('Arial','B',9);
		$this->SetXY(30,26);
		$this->Cell(30,4,'ESTADO DE MEXICO',0,1);
		 $this->image("../img/gem1.jpg",10,10,20,22);
		if(isset($p_tamano) && $p_tamano=='letter' ){
			$this->image("../img/isem.jpg",234,24,33,8);
		}else{
		 $this->image("../img/isem.jpg",290,24,33,8);
		}
		}
	}
	function genBody(){
		
		global $left;
		global $arrayRep;
		global $top_postprint;
		$arrayPosXY=array();
		//<------  ####### imprime body #######          
		$this->AddPage();
		foreach ($arrayRep as $element_RowB){
				$arrayPosXY=$this->buildTable($element_RowB[0],($element_RowB[2]==0?$element_RowB[5]:$arrayPosXY[0]),
											 ($element_RowB[3]==0?$top_postprint:($element_RowH[3]==1?$arrayPosXY[1]:$arrayPosXY[2])),
											  $element_RowB[1],
											 ($element_RowB[4]==0?$top_postprint:($element_RowB[4]==1?$arrayPosXY[1]:$arrayPosXY[2])),$element_RowB[8], 
											 (isset($element_RowB[9])?$element_RowB[9]:0),(isset($element_RowB[10])?$element_RowB[10]:array()),isset($element_RowB[11])?$element_RowB[11]:0);
		}
		
		//####### termina imprime body #######      -------->
		
	}	

				function Footer()
				{
					$this->SetTextColor(0);
					//Posición: a 1,5 cm del final
					$this->SetY(-15);
					//Arial italic 8
					$this->SetFont('Arial','',4);
					//Número de página
					$this->Cell(0,5,'Página '.$this->PageNo().' de {nb}',0,0,'C');
					//Posición: a 1,5 cm del final
					$this->SetY(-15);
					$this->Cell(0,5,$_GET['fparam'],0,0,'L');
					$this->SetY(-15);
					$this->Cell(0,5,date('d/m/Y'),0,0,'R');
				}

}	
if(!isset($p_orientacion))
$p_orientacion='L';//P
if(!isset($p_tamano))
$p_tamano='oficio';
$pdf=new PDF($p_orientacion,'mm',$p_tamano);

$pdf->AliasNbPages();
$pdf->genBody();
$pdf->Output("reporte.pdf","I");
}
?>