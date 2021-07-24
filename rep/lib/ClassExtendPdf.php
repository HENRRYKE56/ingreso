<?php
//require('fpdf.php');
$dir?require('./rep/lib/mem_image.php'):require('lib/mem_image.php');
//require('./rep/lib/mem_image.php');
//Creación del objeto de la clase heredada
global $tamaños;
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
					case 'legal':
						$this->maxLines=316;
						break;
				}
				break;
			case 'L':
				$this->maxLines=240;
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
	function buildTable ($rows=array(),$myposX=10,$myposY=10,$border=9,$myposYD=20,$draw_Color,$intLn=0,$aXtmpHeader=array()){
		global $countHeadGroup;
		global $array_RowH;
                global $tamaños;
		$draw_Color==array(255,255,255);
			$this->SetDrawColor(255,255,255);
			if (is_array($draw_Color))
                           // $this->SetDrawColor(233,138,29);
				$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);//color de bordes
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
                    $mayor=0;
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
					$this->SetTextColor(255,255,255);// set font to withe
					/*<--- identificar el alto de celda */
						$b_again=false;
						if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}//echo "<pre>"; print_r($arrayRow[2]); die();
						else{$this->SetFont($arrayRow[2]);}
						$this->SetFontSize($arrayRow[3]);
					foreach ($arrayRow[1] as $col){ 
                                            if($col[5]==1)
                                            if(strlen($col[1])>$mayor){
                                                $mayor=strlen($col[1]);
                                            }
                                                $this->SetXY($inix,$y);
					//	$this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],0);
                                                if($col[5]==1 || $col[5]==1.1){
                                                    if($col[5]==1)$this->SetFontSize(3.5);else$this->SetFontSize($arrayRow[3]);
         
                                                   // echo '<pre>';print_r($arrayRow[0]);echo '</pre>';die();////////////////////////////////////giarar
                                                    $aumentox=0;
                                                    $aumentoy=0;
                                                    if(($col[0]%2)==0)$aumentox=$col[0];else$aumentox=$col[0]-2;
                                                    if(($arrayRow[0]%2)==0)$aumentoy=$arrayRow[0]/2;else$aumentoy=($arrayRow[0]-1)/2;
                                                   $dato=$this->Rotate(-90, $inix+(.4), $y+(.4));
                                                   $dato=$this->Text($inix+(.4), $y+(.4), $col[1]);
                                                   $dato=$this->Rotate(0);   
                                                   $tamaños[]=$this->MultiCell($col[0],$arrayRow[0],($dato),0,$col[2],0); 
                                                }else if($col[5]==2){
                                                $this->SetXY($inix,$y+$col[5]);
                                                    $tamaños[]=$this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  
                                                }else if($col[5]==3){//pintar abahjo
                                                    $this->SetDrawColor(255,255,255);// $this->SetDrawColor(126,214,66);VERDE
                                                    $this->SetXY($inix,$y-.4);
                                                    $tamaños[]=$this->MultiCell($col[0],$arrayRow[0],($col[1]),'0',$col[2],0);  //pos 3 es borde
                                                }
                                                else if($col[5]==4){//pintar abahjo
                                                    $this->SetDrawColor(255,255,255);//MORADO $this->SetDrawColor(161,18,196);
                                                    $this->SetXY($inix,$y);
                                                    $tamaños[]=$this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  //pos 3 es borde
                                                }else{$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                    $tamaños[]=$this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);                                                   
                                                }                                              
						$inix=$inix+intval($col[0]);
						if ($this->GetY()<$y){
							$b_again=true;
							$inix=$myposX;
							$y=$myposYD;
							$yReal=$y;
							break;
						}
//                                                echo '</br>yreant='.$yReal; 
						$yReal=($this->GetY()>$yReal)?$this->GetY():$yReal;
//                                                echo '</br>yredes='.$yReal; 
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
							$this->SetTextColor(255,255,255);// set font to withe
							$this->SetXY($inix,$y);
//                                                        if($col[5]==1){
//                                                            $this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],true);
//                                                        }else{
//                                                            
//                                                        }
							//$this->MultiCell($col[0],$arrayRow[0],$col[1],0,$col[2],0);
                                                if($col[5]==1 || $col[5]==1.1){
                                                    if($col[5]==1)$this->SetFontSize(3.5);else$this->SetFontSize($arrayRow[3]);
                                                   // echo '<pre>';print_r($arrayRow[0]);echo '</pre>';die();////////////////////////////////////giarar
                                                    $aumentox=0;
                                                    $aumentoy=0;
                                                    if(($col[0]%2)==0)$aumentox=$col[0];else$aumentox=$col[0]-2;
                                                    if(($arrayRow[0]%2)==0)$aumentoy=$arrayRow[0]/2;else$aumentoy=($arrayRow[0]-1)/2;
                                                   $dato=$this->Rotate(-90, $inix+(.4), $y+(.4));
                                                   $dato=$this->Text($inix+(.4), $y+(.4), $col[1]);
                                                   $dato=$this->Rotate(0);   
                                                   $this->MultiCell($col[0],$arrayRow[0],($dato),0,$col[2],0); 
                                                }else if($col[5]==2){
                                                $this->SetXY($inix,$y+$col[5]);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  
                                                }else if($col[5]==3){//pintar abahjo
                                                    $this->SetDrawColor(255,255,255);//$this->SetDrawColor(126,214,66);VERDE
                                                    $this->SetXY($inix,$y);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  //pos 3 es borde
                                                }
                                                else if($col[5]==4){//pintar abahjo
                                                    $this->SetDrawColor(255,255,255);//ROJO
                                                    $this->SetXY($inix,$y);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  //pos 3 es borde
                                                }else{$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);                                                   
                                                }                                                        
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
                                                if($col[6]==3 || $col[6]==4){
                                                    $this->setFillColor(255,255,255);
                                                }else{
                                                    $this->setFillColor($col[3][0],$col[3][1],$col[3][2]);
                                                }
                                                $this->Cell($col[0],$yReal-$y,'',$border,0,'R',$fill);//pos 1 alto de la celda
                                               // echo $yReal.'-'.$y.'@';
					}
                                                                                  
					/* pintar bordes de celda ---!>*/
					/*<--- obtiene la posicion despues de pintar la ultima celda*/
					$xFinal=$this->GetX();
					$yFinal=$this->GetY();
					/* obtiene la posicion despues de pintar la ultima celda ---!>*/
					/*<--- pinta el renglon real */
					$inix=$myposX;
					$this->SetTextColor(0,0,0);//set font to black
					
					if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
					else{$this->SetFont($arrayRow[2]);}
					$this->SetFontSize($arrayRow[3]);
					foreach ($arrayRow[1] as $col){
						if (isset($col[4]) && is_array($col[4])){
								$this->SetFontSize($col[4][1]);
								$this->SetFont($col[4][2],$col[4][3]);
								//$this->SetTextColor($col[4][0][0],$col[4][0][1],$col[4][0][2]);
						}else{
							//$this->SetTextColor(0,0,0);//set font to black
							if (is_array($arrayRow[2])){$this->SetFont($arrayRow[2][0],$arrayRow[2][1]);}
							else{$this->SetFont($arrayRow[2]);}
							$this->SetFontSize($arrayRow[3]);
						}
                                                        if (isset($col[5]) && is_array($col[5]))$this->SetTextColor($col[5][0],$col[5][1],$col[5][2]);
							else $this->SetTextColor(0,0,0);						
						$this->SetXY($inix,$y);
                                                $dato=NULL;
                                                $tam_al=$arrayRow[0];$aumento=0; 
                                                if($col[5]==1 || $col[5]==1.1){
                                                    if($col[5]==1)$this->SetFontSize(3.5);else$this->SetFontSize($arrayRow[3]);
                                                   // echo '<pre>';print_r($arrayRow[0]);echo '</pre>';die();////////////////////////////////////giarar
                                                    
                                                    $aumentoy=0;
                                                    if(($col[0]%2)==0)$aumentox=$col[0];else$aumentox=$col[0]-2;
                                                    if(($arrayRow[0]%2)==0)$aumentoy=$arrayRow[0]/2;else$aumentoy=($arrayRow[0]-1)/2;
                                                   $t_borde="";
                                                   if($col[6]==1){
                                                       $t_borde=0;
                                                       $this->SetDrawColor(239,239,239); 
                                                   }if($col[6]==2){
//                                                       echo '@'.$col[1].':'.$col[6];
                                                       $t_borde="T";
                                                      $this->SetDrawColor(236,236,236); 
                                                      $aumento=-3.5;
                                                   }else{   
                                                       $t_borde="TLR";
                                                       $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                       if($col[1]=='                      GENERO'){$tam_al=$arrayRow[0]*3;
                                                       $t_borde="B";
                                                       $this->SetDrawColor(236,236,236); 
                                                       }
                                                       //$this->SetDrawColor(239,239,239);
                                                      //$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                   }
                                                   $dato=$this->Rotate(-90, $inix+(.4), $y+(.4));
                                                   $dato=$this->Text($inix+(.4+$aumento), $y+(.4), $col[1]);
                                                   $dato=$this->Rotate(0);         
                                                   if($col[6]==9){$this->MultiCell($col[0],$tam_al,($dato),$t_borde,$col[2],0); }
                                                   else$this->MultiCell($col[0],$tam_al,($dato),$t_borde,$col[2],0); 
                                                   
                                                }else if($col[5]==2){$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                $this->SetXY($inix,$y+$col[5]);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);  //pos 3 es borde
                                                }else if($col[5]==3){//pintar abahjo
                                                    $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                    $this->SetXY($inix,$y);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),"L",$col[2],0);  //pos 3 es borde
                                                }
                                                else if($col[5]==4){//pintar abahjo
                                                    $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);//ANARANJADO
                                                    $this->SetXY($inix,$y);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),"LRB",$col[2],0);  //pos 3 es borde
                                                }else if($col[5]==5){
                                                    //pintar abahjo
                                                    $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),1,$col[2],0); 
                                                }else{
                                                    if($col[5]==6){
                                                    //pintar abahjo
                                                    $this->setFillColor(255,255,255);
                                                    $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                    $this->MultiCell($col[0],$arrayRow[0],($col[1]),1,$col[2],true);  
                                                    $this->setFillColor($col[3][0],$col[3][1],$col[3][2]);   
                                                    $this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
  
                                                }else{$this->SetDrawColor($draw_Color[0],$draw_Color[1],$draw_Color[2]);
                                                $this->MultiCell($col[0],$arrayRow[0],($col[1]),0,$col[2],0);
                                               // $this->Cell(5.6,3,'OOOO','','','C','');
                                             //   $this->MultiCell($col[0],$arrayRow[0],($col[1]),1,$col[2],true);
                                                }                                               
                                                }                                                
						
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
				}
                               // echo '</br>yreal='.$yReal;
			}
			/*
				<xFinal> regresa la posicion x despues de pintar la ultima celda
				<yFinal> regresa la posicion y despues de pintar la ultima celda
				<y> regresa la posicion de y despues de pintar el conjunto de renglones
			*///echo '</br>'.$yFinal;
                   
			return array($xFinal,$yFinal,$y);  
		}

	}
	function generaConstancia(){
      
	}        
}

?>
