<?php
	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8'); 

	if(isset($_GET['Otam'])) 	{ $Otam 	= $_GET['Otam'];	}
	$fd = explode('-', $Otam);
	$RAM = $fd[0];
	if(isset($_GET['CAM'])) 	{ $CAM 		= $_GET['CAM'];		}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
		
	$Mes = array(
					'Enero', 
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				);
	$RutCli = '';
	$CAM 	= '';
	
	$link=Conectarse();
	$bdRAM=$link->query("SELECT * FROM formRAM WHERE RAM = '".$RAM."'");
	if($rowRAM=mysqli_fetch_array($bdRAM)){
		if($rowRAM['CAM'] > 0){
			$CAM = $rowRAM['CAM'];
		}
		$pdf=new FPDF('P','mm','A4');

		// Encabezado 
		$nContacto = 0;
		$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE RAM = '".$RAM."'");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			$RutCli 		= $rowCAM['RutCli'];
			$Atencion 		= $rowCAM['Atencion'];
			$nContacto 		= $rowCAM['nContacto'];
			$RutCli			= $rowCAM['RutCli'];
			$usrResponsable	= $rowCAM['usrResponzable'];
			if($Atencion > 0 and $nContacto == 0){
				$nContacto = $rowCAM['Atencion'];
			}
		}
		
		$ln = 25;
		$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowCli=mysqli_fetch_array($bdCli)){

			$ln += 8;

		}
		$ln += 15;

		// Siguientes Registros de OTAMs
	
		$sqlOtams	= "SELECT * FROM OTAMs Where Otam = '".$Otam."'";  // sentencia sql
		$result 	= $link->query($sqlOtams);
		$tOtams 	= mysqli_num_rows($result); // obtenemos el número de Otams

        //Imprimir Otam Dureza
		$nPag = 0;
		$nDur = 5;

		/* ++++ */
        $SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
        $bdMm=$link->query($SQLMm);
        while($rowMm=mysqli_fetch_array($bdMm)){
            $Sw	  = false;
            //$Otam = $RAM;
            $SQL = "SELECT * FROM OTAMs Where Otam = '".$Otam."' and idEnsayo = 'Du' Order By idItem";
            $bdMu=$link->query($SQL);
            while($rowMu=mysqli_fetch_array($bdMu)){
                $Ind = $rowMu['Ind'];
                if($nDur == 5){
                    $nPag++;
                    $nDur = 0;
                    $Sw   = true;
                    $tecRes = $rowMu['tecRes'];
                    // Encabezado 
                    $pdf->AddPage();
                    $pdf->SetXY(10,5);
                    $pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
                    $pdf->SetFont('Arial','B',18);
                    $pdf->SetXY(90,12);
                    $pdf->Cell(40,5,'OTAM-'.$RAM.'-PD',0,0,'C');
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(50,17);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(10,5,'',0,0);
                    $pdf->SetXY(10,17);
                    $pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
                    $pdf->SetDrawColor(0, 0, 0);
                    $pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
                    $pdf->SetXY(197,30);
                    $pdf->Cell(30,4,$CAM,0,0,'L');
                    $pdf->SetDrawColor(200, 200, 200);
                    $pdf->Line(190, 30, 190, 270);
                    $pdf->SetDrawColor(0, 0, 0);
                    // Fin Encabezado
                    $ln = 5;
                    // Pie
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetXY(10,220);
                    $pdf->Cell(30,4, utf8_decode('Técnico responsable') ,0,0,'L');
                    $pdf->SetXY(100,220);
                    $pdf->Cell(30,4,'Solicitante',0,0,'L');
                    $pdf->SetXY(10,225);
                    $pdf->Cell(15,10,utf8_decode(substr($tecRes,0,1)),1,0,'C');
                    $pdf->Cell(15,10,utf8_decode(substr($tecRes,1,1)),1,0,'C');
                    $pdf->Cell(15,10,utf8_encode(substr($tecRes,2,1)),1,0,'C');
                    $pdf->SetXY(100,225);
                    $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
                    $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
                    $pdf->Cell(15,10,utf8_encode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
                    $pdf->SetFont('Arial','',9);
                    $pdf->SetXY(150,245);
                    // Fin Pie
                }
                if($nPag >= 1) { $ln += 18; }
                $nDur++;
                $lnTxt = "ID";
                $pdf->SetFont('Arial','B',11);
                $pdf->SetXY(10,$ln); 
                $pdf->Cell(25,5,$lnTxt,0,0,'C');
                $pdf->SetXY(10,$ln);
                $pdf->MultiCell(25,5,"",1,'L');
                $pdf->SetXY(35,$ln);
                $pd = explode('-',$rowMu['Otam']);
                $pdOtam = $pd[0].'-'.$pd[1].'-P'.$pd[2];
                $pdf->MultiCell(80,5,$pdOtam,1,'C');
                $pdf->SetTextColor(0,0,0);
                $fechaRegistro = "";
                $SQLd = "SELECT * FROM regdoblado Where idItem = '".$rowMu['Otam']."' Order By nIndenta";
                $bdd=$link->query($SQLd);
                while($rs=mysqli_fetch_array($bdd)){
                    if($rs['nIndenta'] == 1){
                        $fechaRegistro = $rs['fechaRegistro'];
                    }
                }
                $pdf->SetXY(115,$ln);
                $pdf->MultiCell(70,5,"DIAGRAMA DE PIEZA",1,'C');
                $ln += 5;
                $pdf->SetFont('Arial','',11);
                $pdf->SetXY(10,$ln);
                $pdf->MultiCell(25,5,"FECHA",1,'C');
                $pdf->SetXY(35,$ln);
                if($fechaRegistro != '0000-00-00'){
                    $fdd = explode('-',$fechaRegistro);
                    $pdf->MultiCell(80,5,$fdd[2].'/'.$fdd[1].'/'.$fdd[0],1,'C');
                }else{
                    $pdf->MultiCell(80,5,"",1,'C');
                }
                $pdf->SetXY(115,$ln);
                $pdf->MultiCell(70,170,"",1,'C');
                $ln += 5;
                $pdf->SetFont('Arial','',11);
                $pdf->SetXY(10,$ln);
                $pdf->MultiCell(25,5, utf8_decode("T(°C)"),1,'C');
                $pdf->SetXY(35,$ln);
                $pdf->MultiCell(28,5,$rowMu['Tem'],1,'C');
                $pdf->SetXY(63,$ln);
                $pdf->MultiCell(25,5,"H(%)",1,'C');
                $pdf->SetXY(88,$ln);
                $pdf->MultiCell(27,5,$rowMu['Hum'],1,'C');
                $ln += 5;
                $lnTxt = 'RESULTADOS';
                $pdf->SetXY(10,$ln);
                $pdf->Cell(105,5, utf8_decode($lnTxt),1,0,'C');
                $ln += 5;
                $pdf->SetXY(10,$ln);
                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(15,5,"#",1,0,'C');
                $pdf->Cell(45,5,"DISTANCIA(mm)",1,0,'C');
                $pdf->Cell(45,5,"DUREZA(ESCALA)",1,0,'C');
                $pdf->SetFont('Arial','',11);
            }
    
        }

        $pdf->SetFont('Arial','',12);
        $maxMuestra = (25 * $nPag) + 1;
        $cc = 0;
        $iMuestra = 0;

        for($i=1; $i<=$Ind; $i++){
            $cc++;
            if($cc == $maxMuestra){
                //$pdf->AddPage();

                $ln = 25;
                $nDur = 5;
                $SQLMm = "SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and conEnsayo != 'off' Order By idItem";
                $bdMm=$link->query($SQLMm);
                while($rowMm=mysqli_fetch_array($bdMm)){
                    $Sw	  = false;
                    //$Otam = $RAM;
                    $SQL = "SELECT * FROM OTAMs Where Otam = '".$Otam."' and idEnsayo = 'Du' Order By idItem";
                    $bdMu=$link->query($SQL);
                    while($rowMu=mysqli_fetch_array($bdMu)){
                        $Ind = $rowMu['Ind'];
                        if($nDur == 5){
                            $nPag++;
                            $maxMuestra = (25 * $nPag) + 1;

                            $nDur = 0;
                            $Sw   = true;
                            $tecRes = $rowMu['tecRes'];
                            // Encabezado 
                            $pdf->AddPage();
                            $pdf->SetXY(10,5);
                            $pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
                            $pdf->SetFont('Arial','B',18);
                            $pdf->SetXY(90,12);
                            $pdf->Cell(40,5,'OTAM-'.$RAM.'-PD',0,0,'C');
                            $pdf->SetTextColor(0,0,0);
                            $pdf->SetFont('Arial','',10);
                            $pdf->SetXY(50,17);
                            $pdf->SetFont('Arial','B',8);
                            $pdf->Cell(10,5,'',0,0);
                            $pdf->SetXY(10,17);
                            $pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
                            $pdf->SetDrawColor(0, 0, 0);
                            $pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
                            $pdf->SetXY(197,30);
                            $pdf->Cell(30,4,$CAM,0,0,'L');
                            $pdf->SetDrawColor(200, 200, 200);
                            $pdf->Line(190, 30, 190, 270);
                            $pdf->SetDrawColor(0, 0, 0);
                            // Fin Encabezado
                            $ln = 5;
                            // Pie
                            $pdf->SetFont('Arial','B',10);
                            $pdf->SetXY(10,220);
                            $pdf->Cell(30,4, utf8_decode('Técnico responsable') ,0,0,'L');
                            $pdf->SetXY(100,220);
                            $pdf->Cell(30,4,'Solicitante',0,0,'L');
                            $pdf->SetXY(10,225);
                            $pdf->Cell(15,10,utf8_decode(substr($tecRes,0,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_decode(substr($tecRes,1,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_encode(substr($tecRes,2,1)),1,0,'C');
                            $pdf->SetXY(100,225);
                            $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_encode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->SetXY(150,245);
                            // Fin Pie
                        }
                        if($nPag >= 1) { $ln += 18; }
                        $nDur++;
                        $lnTxt = "ID";
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetXY(10,$ln); 
                        $pdf->Cell(25,5,$lnTxt,0,0,'C');
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(25,5,"",1,'L');
                        $pdf->SetXY(35,$ln);
                        $pd = explode('-',$rowMu['Otam']);
                        $pdOtam = $pd[0].'-'.$pd[1].'-P'.$pd[2];
                        $pdf->MultiCell(80,5,$pdOtam,1,'C');
                        $pdf->SetTextColor(0,0,0);
                        $fechaRegistro = "";
                        $SQLd = "SELECT * FROM regdoblado Where idItem = '".$rowMu['Otam']."' Order By nIndenta";
                        $bdd=$link->query($SQLd);
                        while($rs=mysqli_fetch_array($bdd)){
                            if($rs['nIndenta'] == 1){
                                $fechaRegistro = $rs['fechaRegistro'];
                            }
                        }
                        $pdf->SetXY(115,$ln);
                        $pdf->MultiCell(70,5,"DIAGRAMA DE PIEZA",1,'C');
                        $ln += 5;
                        $pdf->SetFont('Arial','',11);
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(25,5,"FECHA",1,'C');
                        $pdf->SetXY(35,$ln);
                        if($fechaRegistro != '0000-00-00'){
                            $fdd = explode('-',$fechaRegistro);
                            $pdf->MultiCell(80,5,$fdd[2].'/'.$fdd[1].'/'.$fdd[0],1,'C');
                        }else{
                            $pdf->MultiCell(80,5,"",1,'C');
                        }
                        $pdf->SetXY(115,$ln);
                        $pdf->MultiCell(70,170,"",1,'C');
                        $ln += 5;
                        $pdf->SetFont('Arial','',11);
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(25,5, utf8_decode("T(°C)"),1,'C');
                        $pdf->SetXY(35,$ln);
                        $pdf->MultiCell(28,5,$rowMu['Tem'],1,'C');
                        $pdf->SetXY(63,$ln);
                        $pdf->MultiCell(25,5,"H(%)",1,'C');
                        $pdf->SetXY(88,$ln);
                        $pdf->MultiCell(27,5,$rowMu['Hum'],1,'C');
                        $ln += 5;
                        $lnTxt = 'RESULTADOS';
                        $pdf->SetXY(10,$ln);
                        $pdf->Cell(105,5, utf8_decode($lnTxt),1,0,'C');
                        $ln += 5;
                        $pdf->SetXY(10,$ln);
                        $pdf->SetFont('Arial','B',11);
                        $pdf->Cell(15,5,"#",1,0,'C');
                        $pdf->Cell(45,5,"DISTANCIA(mm)",1,0,'C');
                        $pdf->Cell(45,5,"DUREZA(ESCALA)",1,0,'C');
                        $pdf->SetFont('Arial','',11);
                    }
            
                }
                $ln += 5;
        
            }
            if($i==1){
                $ln += 5;
            }

            $pdf->SetXY(10,$ln);
            $pdf->Cell(15,6,$i,1,0,'C');
            $SQL = "SELECT * FROM regdoblado Where idItem = '".$Otam."' and nIndenta = '$i'";
			$bd=$link->query($SQL);
			if($rs=mysqli_fetch_array($bd)){
                $pdf->Cell(45,6,number_format($rs['Distancia'], 2, ',', '.'),1,0,'C');
                $pdf->Cell(45,6,number_format($rs['vIndenta'], 2, ',', '.'),1,0,'C');
            }else{
                $pdf->Cell(45,6,"-",1,0,'C');
                $pdf->Cell(45,6,"-",1,0,'C');
            }
            $iMuestra = $i+1;
            $ln += 6;
        }

        if($nPag > 1){
            $Dif = (25 * $nPag) - $Ind;
            for($i=1; $i<=$Dif; $i++){
                $pdf->SetXY(10,$ln);
                $pdf->Cell(15,6,$iMuestra,1,0,'C');
                $pdf->Cell(45,6,"-",1,0,'C');
                $pdf->Cell(45,6,"-",1,0,'C');    
                $ln += 6;
                $iMuestra++;
            }
        }else{
            $Dif = (25 * $nPag) - $Ind;
            for($i=1; $i<=$Dif; $i++){
                $pdf->SetXY(10,$ln);
                $pdf->Cell(15,6,$iMuestra,1,0,'C');
                $pdf->Cell(45,6,"-",1,0,'C');
                $pdf->Cell(45,6,"-",1,0,'C');    
                $ln += 6;
                $iMuestra++;
            }

        }
		
		//Fin Imprimir Otam Dureza

		

	}

	
	$agnoActual = date('Y'); 
	$vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Du';
	if(!file_exists($vDir)){
		mkdir($vDir);
	}

	$NombreFormulario = "Otam-PerfilDureza-".$Otam.".pdf";
	// unlink($vDir.'/'.$NombreFormulario);
	// unlink('../tmp/'.$NombreFormulario);

	$pdf->Output($NombreFormulario,'D'); //Guarda en un Fichero
	$pdf->Output($vDir.'/'.$NombreFormulario,'F'); //Guarda en un Fichero

	// copy('../tmp/'.$NombreFormulario, $vDir.'/'.$NombreFormulario);




	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	// $NombreFormulario = "RAM-".$RAM.".pdf";
	// $pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');




    

?>
