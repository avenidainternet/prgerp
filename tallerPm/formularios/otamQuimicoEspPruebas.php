<?php
	session_start(); 
	if(isset($_GET['idItem'])) 		{ $idItem 		= $_GET['idItem'];		}

	require_once('../../fpdf/fpdf.php');
	include_once("../../conexionli.php");
	header('Content-Type: text/html; charset=utf-8');
    $pdf=new FPDF('P','mm','Letter');

    // 1. Cargar el contenido del archivo
    $json_data = file_get_contents('../resultadosQu/vEspectrometro.json');

    // 2. Decodificar el JSON a un array asociativo de PHP
    $data = json_decode($json_data, true);

    // 3. Verificar si existen registros y recorrerlos
    if (isset($data['records'])) {
        $idItemOld = '';
        foreach ($data['records'] as $item) {
            // Acceder al valor de idItem
            $idItem = htmlspecialchars($item['idItem']);
            $fd = explode('-', $idItem);
            $RAM = $fd[0];
            $link=Conectarse();
            $bdCAM=$link->query("SELECT * FROM cotizaciones WHERE RAM = '".$RAM."'");
            if($rowCAM=mysqli_fetch_array($bdCAM)){
                $RutCli 		= $rowCAM['RutCli'];
                $CAM 		    = $rowCAM['CAM'];
                $RutCli			= $rowCAM['RutCli'];
                $usrResponsable	= $rowCAM['usrResponzable']; 
                // $cooResponsable	= $rowCAM['cooResponsable']; 
            }
        
            $sqlQu = "SELECT * FROM regquimico Where idItem = '$idItem'";
            $bd=$link->query($sqlQu);
            if($rs=mysqli_fetch_array($bd)){
                if($rs['tpMuestra'] == 'Ac'){ $Aleacion = 'Acero'; }
                if($rs['tpMuestra'] == 'Al'){ $Aleacion = 'Aluminio'; }
                if($rs['tpMuestra'] == 'Co'){ $Aleacion = 'Cobre'; }
                // echo ' RutCli '.$RutCli.'  '.$idItem.' '.$rs['tpMuestra'].'<br>';

                $SQL = "SELECT * FROM otams Where otam = '$idItem'";
				$bdMu=$link->query($SQL);
				if($rowMu=mysqli_fetch_array($bdMu)){
                    if($idItemOld != $idItem){
                        $idItemOld = $idItem;
                        // Inicio encabezado OTAM
                        $cR = 0; $cG = 0; $cB = 0;
                        $pdf->SetTextColor($cR, $cG, $cB);
                        $ln = 25;
                        $pdf->AddPage();
                        $pdf->SetXY(10,5);
                        $pdf->Image('../../imagenes/logonewsimet.jpg',10,5,43,16);
                        $pdf->SetFont('Arial','B',18);
                        $pdf->SetXY(90,12);
                        $pdf->SetTextColor($cR, $cG, $cB);
                        $pdf->Cell(40,5,'OTAM-'.$RAM.'-Q',0,0,'C');
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont('Arial','',10);
                        $pdf->SetXY(50,17);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(10,5,'',0,0);
                        $pdf->SetXY(10,17);
                        $pdf->Image('../../gastos/logos/logousach.png',195,5,15,23);
                        $pdf->SetDrawColor(0, 0, 0);
                        $pdf->Image('../../imagenes/logonewsimet.jpg',185,245,20,8);
                        $pdf->SetXY(197,30);
                        $pdf->Cell(30,4,$CAM,0,0,'L');
                        $pdf->SetDrawColor(200, 200, 200);
                        $pdf->Line(190, 30, 190, 270);
                        $pdf->SetDrawColor(0, 0, 0);
                        // Fin encabezado OTAM
                        
                        // Pie
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetXY(10,220);
                        $pdf->Cell(30,4,utf8_decode('Técnico responsable'),0,0,'L');
                        $pdf->SetXY(100,220);
                        $pdf->Cell(30,4,'Solicitante',0,0,'L');
                        $pdf->SetXY(10,225);
                        $pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],0,1)),1,0,'C');
                        $pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],1,1)),1,0,'C');
                        $pdf->Cell(15,10,utf8_decode(substr($rowMu['tecRes'],2,1)),1,0,'C');
                        $pdf->SetXY(100,225);
                        $bdRAM=$link->query("SELECT * FROM formram WHERE RAM = '".$RAM."'");
                        if($rowRAM=mysqli_fetch_array($bdRAM)){
                            $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],0,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],1,1)),1,0,'C');
                            $pdf->Cell(15,10,utf8_decode(substr($rowRAM['cooResponsable'],2,1)),1,0,'C');
                        }
                        $pdf->SetFont('Arial','',9);
                        $pdf->SetXY(150,245);
                        $pdf->Cell(15,10,'Reg 240205-V.0',0,0,'R');
                        // Fin Pie
                    
                        // Identificación Ensayo
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(50,5,utf8_decode("IDENTIFICACIÓN"),1,'C');
                        $pdf->SetXY(60,$ln);
                        $pdf->MultiCell(50,5,utf8_decode("ALEACIÓN BASE"),1,'C');
                        $pdf->SetXY(110,$ln);
                        $pdf->MultiCell(75,5,"OBSERVACIONES",1,'C');
                        $ln += 5;
                        $pdf->SetXY(10,$ln);
                        $pdf->SetTextColor($cR, $cG, $cB);
                        $pdf->MultiCell(50,5,$rowMu['Otam'],1,'C');
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont('Arial','',11);
                        $pdf->SetXY(60,$ln);
                        $pdf->MultiCell(50,10,$Aleacion,1,'C');
                        $pdf->SetXY(110,$ln);
                        $pdf->MultiCell(75,15,$rs['Observacion'],1,'C');
                        $ln += 5;
                        $pdf->SetFont('Arial','',11);
                        $pdf->SetXY(10,$ln);
                        $fd = explode('-', $rs['fechaRegistro']); 
                        $pdf->MultiCell(50,5,'FECHA: '.$fd[2].'/'.$fd[1].'/'.$fd[0],1,'L');
                        
                        $ln += 5;
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(50,5,'TEMPERATURA',1,'C');
                        $pdf->SetXY(60,$ln);
                        $pdf->MultiCell(50,5,utf8_decode($rs['Temperatura'].'ºC'),1,'C');
                        $pdf->SetXY(110,$ln);
                        $pdf->MultiCell(30,5,'HUMEDAD',1,'L');
                        $pdf->SetXY(140,$ln);
                        $pdf->MultiCell(45,5, utf8_decode($rs['Humedad'].'%'),1,'C');
                        
                        $ln += 5;
                        $lnTxt = 'OBSERVACIONES';
                        $pdf->SetXY(10,$ln);
                        $pdf->Cell(25,5,$lnTxt,0,0,'L');
                        $pdf->SetXY(10,$ln);
                        $pdf->MultiCell(175,14,"",1,'C');

                        // Identificación Ensayo
                    }
                    if($rs['tpMuestra'] == 'Co'){
                        $ln += 18;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetFont('Arial','',8);
                        $pdf->SetFillColor(220,220,220);
    
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Zn',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Pb',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Sn',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%P',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Fe',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Ni',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mg',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'%As',1,'C',true);
                        //$pdf->SetFillColor(0,0,0);
    
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cZn'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cPb'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cSn'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cP'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cFe'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cNi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5, $rs['cMg'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,$rs['cAs'],1,'C');
    
                        // Segunda Linea
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetFont('Arial','',8);
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Sb',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Bi',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Ag',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Co',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%S',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Cu',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'-',1,'C',true);
                        
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cSb'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cBi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cAg'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCo'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cAl'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cS'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCu'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'-',1,'C');
    
                    }
                    if($rs['tpMuestra'] == 'Al'){
                        $ln += 18;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetFont('Arial','',8);
                        $pdf->SetFillColor(220,220,220);
    
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Fe',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Cu',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mg',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Cr',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%B',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Ga',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'%V',1,'C',true);
                        //$pdf->SetFillColor(0,0,0);
    
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cFe'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCu'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cMg'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCr'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cAl'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cB'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5, $rs['cGa'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,$rs['cV'],1,'C');
    
    
                    }
                    if($rs['tpMuestra'] == 'Ac'){
                        $ln += 18;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetFont('Arial','',8);
                        $pdf->SetFillColor(220,220,220);
    
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%C',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Si',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mn',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%P',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%S',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Cr',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Ni',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Mo',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Al',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'%Cu',1,'C',true);
                        //$pdf->SetFillColor(0,0,0);
    
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cC'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cSi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cMn'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cP'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cS'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCr'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cNi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cMo'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5, $rs['cAl'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,$rs['cCu'],1,'C');
    
    
                        // Segunda Linea
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetFont('Arial','',8);
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Co',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Ti',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%Nb',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%V',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'%B',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C',true);
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'%Fe',1,'C',true);
                        
                        $ln += 5;
                        $nEspacios = 18;
                        $nCol = 10;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cCo'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cTi'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cNb'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cV'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,$rs['cB'],1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios,5,'-',1,'C');
                        $nCol += $nEspacios;
                        $pdf->SetXY($nCol,$ln);
                        $pdf->MultiCell($nEspacios -5,5,'RESTO',1,'C');
                    }
        
                }


                
            }


    
        }
        
    }

    $Respaldado  = 'on';
    $actSQL="UPDATE otams SET ";
    $actSQL.="Respaldado        ='".$Respaldado.          "'";
    $actSQL.="WHERE Otam        like '%$RAM%'";
    $bdCot=$link->query($actSQL);

    $link->close();

    $agnoActual = date('Y');
    $vDir = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Qu/';
    if(!file_exists($vDir)){
        mkdir($vDir);
    }

    $NombreFormulario = "Otam-Quimico-".$RAM.".pdf";
    $pdf->Output($vDir.$NombreFormulario,'F'); //Guarda en un Fichero
    // $pdf->Output($NombreFormulario,'D'); //Para Descarga
    header('Location: ../respaldoOtams.php');


?>