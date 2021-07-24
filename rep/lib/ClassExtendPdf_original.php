<?php
define('FPDF_FONTPATH','lib/font/');
//require('fpdf.php');
require('mem_image.php');
//Creación del objeto de la clase heredada
class ClassExtendPdf extends MEM_IMAGE {
        
	private $maxLines; /*limite de posicion vertical en puntos*/
	/* Metodo constructor de la clase heredada*/
	function __construct($orientation='P',$unit='mm',$format='letter') {
		parent::__construct($orientation,$unit,$format);
		$this->maxLines=192;
		switch ($orientation){
			case 'P':
				switch ($format){
					case 'letter':
						$this->maxLines=274;
						break;
					case 'oficio':
						$this->maxLines=316;
						break;
				}
				break;
			case 'L':
				$this->maxLines=165;
				break;
		}
	}

	/*Metodo Setter de atributos*/
	private function setAttribs($xAttribs){
		foreach ($xAttribs as $xName=>$xValue)
			$this->$xName=$xValue;
	}

	/**
	* Metodo para construir el objeto tabla en un documento pdf
	*/
	function buildTable ($rows=array(),$myposX=10,$myposY=10,$border=0,$myposYD=20,$draw_Color,$intLn=0,$aXtmpHeader=array()){
		global $countHeadGroup;
		global $array_RowH;
			$this->SetDrawColor(125,125,125);
			if (is_array($draw_Color))
				$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
			$inix=$myposX;
			$y=$myposY;
			$yReal=$y;
			$xFinal=$this->GetX();
			$yFinal=$this->GetY();
			
			
					if ($intLn==1){
						if (sizeof($aXtmpHeader)>0){
							$array_RowH=$aXtmpHeader;
						}
						$this->AddPage();
		//				echo $yReal; echo $myposYD; die();
						$inix=$myposX;
						$y=$myposYD;
						$yReal=$y;
					}			
		if (sizeof($rows)>0){
                    $cont=0;
			foreach ($rows as $arrayRow){
				
				if (is_array($arrayRow[1])){
					/*<--- revisa que la posicion del nuevo renglon que no exceda el limite */
					if (intval($yReal)>=$this->maxLines){
						$this->AddPage();
		//				echo $yReal; echo $myposYD; die();
						$inix=$myposX;
						$y=$myposYD;
						$yReal=$y;
					}
					/* revisa que la posicion del nuevo renglon que no exceda el limite ---!>*/
                                        if(!$n_p_n)$this->SetTextColor(255,255,255);
					// set font to withe
					/*<--- identificar el alto de celda */
						$b_again=false;
						if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}//echo "<pre>"; print_r($arrayRow[2]); die();
						else{$this->SetFont($arrayRow[2]);}
						$this->SetFontSize($arrayRow[3]);
					foreach ($arrayRow[1] as $col){
						$this->SetXY($inix,$y);
						$this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],0);
						$inix=$inix+intval($col[0]);
						if ($this->GetY()<$y){
							$b_again=true;
							$inix=$myposX;
							$y=$myposYD;
							$yReal=$y;
							break;
						}
						$yReal=($this->GetY()>$yReal)?$this->GetY():$yReal;
					}
					if ($b_again){
						$this->Header();
						if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
						else{$this->SetFont($arrayRow[2]);}
						$this->SetFontSize($arrayRow[3]);
						foreach ($arrayRow[1] as $col){
							if (isset($col[4]) && is_array($col[4])){
									$this->SetFontSize($col[4][1]);
									$this->SetFont($col[4][2],$col[4][3]);
							}else{
								if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
								else{$this->SetFont($arrayRow[2]);}
								$this->SetFontSize($arrayRow[3]);
							}							
							
							$this->SetXY($inix,$y);
							$this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],0);
							$inix=$inix+intval($col[0]);
							$yReal=($this->GetY()>$yReal)?$this->GetY():$yReal;
						}
					}
					/* identificar el alto de celda ---!>*/
					/*<--- pintar bordes de celda */
					$this->SetXY($myposX,$y);// regresa a pocicion inicial de renglon
					foreach ($arrayRow[1] as $col){
						$fill=0;
						if (is_array($col[3])){
						$this->setFillColor($col[3][0],$col[3][1],$col[3][2]); $fill=1;}
						
						$this->Cell($col[0],$yReal-$y,'',$border,0,'R',$fill);
					}
					/* pintar bordes de celda ---!>*/
					/*<--- obtiene la posicion despues de pintar la ultima celda*/
					$xFinal=$this->GetX();
					$yFinal=$this->GetY();
					/* obtiene la posicion despues de pintar la ultima celda ---!>*/
					/*<--- pinta el renglon real */
					$inix=$myposX;
					$this->SetTextColor(0,0,0 );//set font to black
					
					if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
					else{$this->SetFont($arrayRow[2]);}
					$this->SetFontSize($arrayRow[3]);
					foreach ($arrayRow[1] as $col){
                                            
                                            
						if (isset($col[4]) && is_array($col[4])){
								$this->SetFontSize($col[4][1]);
								$this->SetFont($col[4][2],$col[4][3]);
                                                                if (isset($col[5]) && is_array($col[5]))$this->SetTextColor($col[5][0],$col[5][1],$col[5][2]);
								else $this->SetTextColor(0,0,0);
						}else{
                                                        if (isset($col[5]) && is_array($col[5]))$this->SetTextColor($col[5][0],$col[5][1],$col[5][2]);
							else $this->SetTextColor(0,0,0);
							if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
							else{$this->SetFont($arrayRow[2]);}
							$this->SetFontSize($arrayRow[3]);
						}
						
						$this->SetXY($inix,$y);
						$this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],0);
						$inix=$inix+$col[0];
					}
					/* pinta el renglon real ---!>*/
					$inix=$myposX; // regresa a la posicion inicial en x del renglon siguiente
					$y=$yReal; // asigna valor de la posicion en y del siguiente renglon
					/*<--- revisa que la posicion del nuevo renglon que no exceda el limite */
					if (intval($yReal)>=$this->maxLines){
						$this->AddPage();
						if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
						else{$this->SetFont($arrayRow[2]);}
						$this->SetFontSize($arrayRow[3]);
						$inix=$myposX;
						$y=$myposYD;
						$yReal=$y;
					}/* revisa que la posicion del nuevo renglon que no exceda el limite ---!>*/
				}	else{
						$countHeadGroup++;
	//					$this->SetFont($arrayRow[2]);
	//					$this->SetFontSize($arrayRow[3]);
						$inix=$myposX;
						$y=$myposYD;
						$yReal=$y;
						$this->AddPage();
				}$cont++;
			}
			/*
				<xFinal> regresa la posicion x despues de pintar la ultima celda
				<yFinal> regresa la posicion y despues de pintar la ultima celda
				<y> regresa la posicion de y despues de pintar el conjunto de renglones
			*/
			return array($xFinal,$yFinal,$y);  
		}
	}
	
}
?>
