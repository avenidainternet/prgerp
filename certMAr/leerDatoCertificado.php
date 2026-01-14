<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
include("../conexioncert.php");  
include_once("../conexionli.php");
$res = '';

if($dato->accion == 'informarLE'){


	$link=Conectarse();

	$SQLc = "SELECT * FROM cotizaciones where RAM = '$dato->RAMAR'"; 
	$bdc=$link->query($SQLc);
	if($rsc = mysqli_fetch_array($bdc)){
		$CAM 		= $rsc['CAM']; 
		$RAM 		= $rsc['RAM']; 
		$nServicio 	= 1201;
		$ValorUF 	= 0;
		$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
		$bdser=$link->query($SQLser);
		if($rsser = mysqli_fetch_array($bdser)){
			$ValorUF = $rsser['ValorUF'];
		}	

		$linkc=ConectarseCert();
		$nColadas40 	= 0;
		$nColadas80 	= 0;
		$nColadas120 	= 0;
		$SQLcerAR = "SELECT * FROM certificado where CodCertificado like '%$dato->ar%'"; 
		$bdcerAR=$linkc->query($SQLcerAR);
		while($rscerAR = mysqli_fetch_array($bdcerAR)){
			if($rscerAR['Peso'] <= 40000){
				$nColadas40++;
			}
			if($rscerAR['Peso'] > 40000 and $rscerAR['Peso'] <= 80000){
				$nColadas80++;
			}
			if($rscerAR['Peso'] > 80000){
				$nColadas120++;
			}
		}	
		$linkc->close();

		$NetoUF40 	= 0;
		$NetoUF80 	= 0;
		$NetoUF120 	= 0;

		$ValorUF40 	= 0;
		$ValorUF80 	= 0;
		$ValorUF120 = 0;
		if($nColadas40 > 0){
			$nServicio 	= 1201;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF40 = $rsser['ValorUF'];
			}
			$NetoUF40				= $ValorUF40 * $nColadas40;

		}
		if($nColadas80 > 0){
			$nServicio 	= 1203;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF80 = $rsser['ValorUF'];
			}
			$NetoUF80				= $ValorUF80 * $nColadas80;
		}
		if($nColadas120 > 0){
			$nServicio 	= 1202;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF120 = $rsser['ValorUF'];
			}
			$NetoUF120				= $ValorUF120 * $nColadas120;
		}

		$NetoUF				= $NetoUF40 + $NetoUF80 + $NetoUF120;
		$IvaUF				= $NetoUF * 0.19;
		$BrutoUF			= $NetoUF + $IvaUF; 



		$Observacion 		= $dato->ar;

		$obsServicios 		= 'Certificación '.$dato->ar.' con '.$dato->nColadas.' coladas ';
		$Obs 				= 'Certificación '.$dato->ar.' con '.$dato->nColadas.' coladas ';
		$Descripcion 		= 'Certificación '.$dato->ar.' con '.$dato->nColadas.' coladas ';

		$Estado			 	= 'E';
		$usrCotizador 		= 'GRC';
		$usrResponzable 	= 'GRC';

		$NetoUF 			= $ValorUF * $dato->nColadas;
		$IvaUF				= $NetoUF * 0.19;
		$BrutoUF			= $NetoUF + $IvaUF;

		$fechaInicio = date('Y-m-d');

		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="Observacion   	= '".$Observacion. 		"', ";
		$actSQL.="obsServicios   	= '".$obsServicios. 	"', ";
		$actSQL.="fechaInicio  		= '".$fechaInicio. 		"', ";
		$actSQL.="fechaAceptacion	= '".$fechaInicio. 		"', ";
		$actSQL.="Descripcion  		= '".$Descripcion. 		"', ";
		$actSQL.="NetoUF  			= '".$NetoUF. 			"', ";
		$actSQL.="IvaUF  			= '".$IvaUF. 			"', ";
		$actSQL.="BrutoUF  			= '".$BrutoUF. 			"' ";
		$actSQL.="WHERE CAM			= '$CAM'";
		$bdAct = $link->query($actSQL);

		$actSQL="UPDATE formram SET ";
		$actSQL.="nMuestras   		= '".$dato->nColadas. 	"', ";
		$actSQL.="Obs  				= '".$Obs. 				"' ";
		$actSQL.="WHERE CAM			= '$CAM'";
		$bdAct = $link->query($actSQL);

		$bdCot = $link->query("Delete From dcotizacion Where CAM = '$CAM'");

		$nLin 		= 0;
		if($nColadas40 >0){
			$nLin++;
			$nServicio40 	= 1201;
			$NetoUF 		= $NetoUF40;
			$IvaUF			= $NetoUF40 * 1.19;
			$TotalUF		= $NetoUF40 + $IvaUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$CAM'						,
														'$nLin'						,
														'$nColadas40'			,
														'$nServicio40'				,
														'$ValorUF40'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}
		if($nColadas80 > 0){
			$nLin++;
			$nServicio80 	= 1203;
			$NetoUF 		= $NetoUF80;
			$NetoUF 		= $NetoUF80;
			$IvaUF			= $NetoUF80 * 1.19;
			$TotalUF		= $NetoUF80 + $IvaUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$CAM'						,
														'$nLin'						,
														'$nColadas80'			,
														'$nServicio80'				,
														'$ValorUF80'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}
		if($nColadas120 > 0){
			$nLin++;
			$nServicio120 	= 1202;
			$NetoUF 		= $NetoUF120;
			$NetoUF 		= $NetoUF120;
			$IvaUF			= $NetoUF120 * 1.19;
			$TotalUF		= $NetoUF120 + $IvaUF;

			$link->query("insert into dcotizacion(		CAM					,
														nLin				,
														Cantidad			,
														nServicio			,
														unitarioUF			,
														NetoUF				,
														IvaUF				,
														TotalUF
													) 
											values 	(	'$CAM'						,
														'$nLin'						,
														'$nColadas120'			,
														'$nServicio120'				,
														'$ValorUF120'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}
		
	}
	if($dato->RAMAR > 0){
		$bdCot = $link->query("Delete From ammuestras Where idItem 		like '%$dato->RAMAR%'");
		$bdCot = $link->query("Delete From aminformes Where CodInforme 	like '%$dato->RAMAR%'");
	}

	$link->close();

	if($dato->RAMAR > 0){
		$linkc=ConectarseCert();
		$SQLar = "SELECT * FROM ar Where RAMAR = '$dato->RAMAR'"; 
		$bdar=$linkc->query($SQLar);
		if($rsar = mysqli_fetch_array($bdar)){
			
			$ar 		= $rsar['ar'];
			$i 			= 0;
			$nLote 		= 0;
			$nroMuestra = 0;

			$SQLcer = "SELECT * FROM certificado Where CodCertificado like '%$ar%'"; 
			$bdcer=$linkc->query($SQLcer);
			while($rscer = mysqli_fetch_array($bdcer)){
				$nLote++;

				$tColadas = $dato->nColadas;
				if($dato->nColadas < 10){ $tColadas = '0'.$dato->nColadas; }
				$CodInforme = 'AM-'.$dato->RAMAR.'-'.$nLote.$tColadas;
				if($nLote<10){
					$CodInforme = 'AM-'.$dato->RAMAR.'-0'.$nLote.$tColadas;
				}
				$conEnsayo = 'on';
				$Taller 	= 'on';

				$nMuestrasLote = 1;
				if($rscer['Peso'] <= 40000){
					$nMuestrasLote = 1;
				}
				if($rscer['Peso'] > 40000 and $rscer['Peso'] <= 80000){
					$nMuestrasLote = 2;
				}
				if($rscer['Peso'] > 80000 and $rscer['Peso'] <= 120000){
					$nMuestrasLote = 3;
				}
				for($i=1; $i <= $nMuestrasLote; $i++){
					$nroMuestra++;
					$idItem = $dato->RAMAR.'-'.$nroMuestra; // 18400-1
					if($nroMuestra<10){
						$idItem = $dato->RAMAR.'-0'.$nroMuestra; // 18400-01 18400-02 18400-03
					}
	
					$CodMuestraAr = 'R'.$ar.'-'.$nLote; // RAR-18400-1
					if($nLote<10){
						$CodMuestraAr = 'R'.$ar.'-0'.$nLote; // RAR-18400-01
					}
	
					if($i<10){
						$CodMuestraAr = $CodMuestraAr.'-0'.$i; // RAR-18400-01-01
					}else{
						$CodMuestraAr = $CodMuestraAr.'-'.$i; // RAR-18400-01-1
					}
	
					if($nMuestrasLote<10){
						$CodMuestraAr = $CodMuestraAr.'0'.$nMuestrasLote; // RAR-18400-01-0101
					}else{
						$CodMuestraAr = $CodMuestraAr.$nMuestrasLote; // RAR-18400-01-011
					}
					$Prod = '';
					$SQLtp = "SELECT * FROM tipoproductos Where nProducto = '".$rscer['nProducto']."'"; 
					$bdtp=$linkc->query($SQLtp);
					if($rstp = mysqli_fetch_array($bdtp)){
						$Prod = $rstp['Producto'];
					}
					$idMuestra =  'Certificado OCP SIMET '.$CodMuestraAr.' '.$Prod.' '.$rscer['Dimension'].' Colada '.$rscer['Lote'];
					
					$link=Conectarse();

					$link->query("insert into ammuestras(	idItem		,
															idMuestra	,
															Taller		,
															conEnsayo
													) 
											values 	(		'$idItem'	,
															'$idMuestra',
															'$Taller'	,
															'$conEnsayo'
					)");
					$link->close();
	

				}

				$link=Conectarse();

				$tpEnsayo 		= 5;
				$nroInformes 	= $dato->nColadas;
				$nMuestras 		= 1;

				$link->query("insert into aminformes(	CodInforme		,
														tpEnsayo		,
														nroInformes		,
														RutCli			,
														nMuestras
												) 
										values 	(		'$CodInforme'	,
														'$tpEnsayo'		,
														'$nroInformes'	,
														'$dato->RutCli'	,
														'$nMuestras'
				)");
				$link->close();
	
			}

			$link=Conectarse();
			$actSQL="UPDATE formram SET ";
			$actSQL.="nMuestras  		= '".$nroMuestra. 			"' ";
			$actSQL.="WHERE RAM			= '$dato->RAMAR'";
			$bdAct = $link->query($actSQL);
			$link->close();
	
		}
		$linkc->close();
	}



}


if($dato->accion == 'L'){    
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM ar Where ar = '$dato->ar'"; 
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Situacion 		= 'Old';
		$Bloqueo 		= 'No';
		$certAsociado 	= 'No';
		$RAMAR 			= 0;
		if($rs['RAMAR'] > 0){
			//$certAsociado 	= 'Si';
		}

		$SQLcc = "SELECT * FROM certificado Where CodCertificado like '%$dato->ar%'";
		$bdcc=$linkc->query($SQLcc);
		while($rscc = mysqli_fetch_array($bdcc)){
			/*
			if($rscc['CodInforme']){
				$fd = explode('-', $rscc['CodInforme']);
				$RAMAR = $fd[1];

				$link=Conectarse();
				$SQLcam = "SELECT * FROM cotizaciones Where RAM = '$RAMAR'";
				$bdcam=$link->query($SQLcam);
				if($rscam = mysqli_fetch_array($bdcam)){
					$certAsociado 	= 'Si';
				}
				$link->close();

			}
			*/
			if($rscc['fechaUpLoad'] != '0000-00-00'){
				$Bloqueo = 'Si';
			}
		}
	

		$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
		$bdcl=$linkc->query($SQLcl);
		if($rscl = mysqli_fetch_array($bdcl)){

		}
		$res.= '{"RutCli":"'.				$rs["RutCli"].				'",';
		$res.= '"ar":"'. 					$rs["ar"]. 					'",';
		$res.= '"codAr":"'. 				$rs["codAr"]. 				'",';
		$res.= '"RAMAR":"'. 				$rs["RAMAR"]. 				'",';
		$res.= '"CAMAR":"'. 				$rs["CAMAR"]. 				'",';
		$res.= '"Situacion":"'. 			$Situacion. 				'",';
		$res.= '"Bloqueo":"'. 				$Bloqueo. 					'",';
		$res.= '"certAsociado":"'. 			$certAsociado. 				'",';
		$res.= '"fechaInspeccion":"'. 		$rs["fechaInspeccion"]. 	'",';
		$res.= '"usrInspector":"'. 			$rs["usrInspector"]. 		'",';
		$res.= '"nColadas":"'. 				$rs["nColadas"]. 			'"}';
	}else{
		$nColadas 			= 1;
		$fechaInspeccion 	= date('Y-m-d');
		$ar 				= 'AR-0001';
		$SQL = "SELECT * FROM ar Order By codAr Desc";
		$bd=$linkc->query($SQL);
		if($rs = mysqli_fetch_array($bd)){
			$codAr 		= $rs['codAr'] + 1;
			if($codAr < 1000){
				$ar 		= 'AR-0'.$codAr;
			}
			$Situacion 	= 'New';

			$res.= '{"codAr":"'.				$codAr.						'",';
			$res.= '"ar":"'. 					$ar. 						'",';
			$res.= '"Situacion":"'. 			$Situacion. 				'",';
			$res.= '"fechaInspeccion":"'. 		$fechaInspeccion. 			'",';
			$res.= '"nColadas":"'. 				$nColadas. 					'"}';		
		}
	}
	$linkc->close();
	echo $res;	
}


if($dato->accion == 'leerCertificadosConformidad'){
	$output = [];
	$link=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM certificado Where CodCertificado like '%$dato->ar%' Order By CodCertificado";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."'";
		$Cliente = '';
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$Cliente = trim($rsc['Cliente']); 
		}
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
		$outp .= '"Cliente":"'. 			$Cliente. 					'",';
		$outp .= '"fechaUpLoad":"'. 		$rs["fechaUpLoad"]. 		'",';
		$outp .= '"CodCertificado":"'. 		$rs["CodCertificado"]. 		'",';
		$outp .= '"CodigoVerificacion":"'. 	$rs["CodigoVerificacion"]. 	'",';
		$outp .= '"Lote":"'. 				$rs["Lote"]. 				'",';
		$outp .= '"Peso":"'. 				$rs["Peso"]. 				'",';
		$outp .= '"nDescargas":"'. 			$rs["nDescargas"]. 			'",';
		$outp .= '"upLoad":"'. 				$rs["upLoad"]. 				'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
		$outp .= '"pdf":"'. 				$rs["pdf"]. 				'"}';
	}
	$link->close();
	$outp ='{"records":['.$outp.']}';
	echo ($outp);	
}

if($dato->accion == 'grabarFechaInspeccion'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM ar Where ar = '$dato->ar'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
	    $actSQL="UPDATE ar SET ";
	    $actSQL.="fechaInspeccion       = '".$dato->fechaInspeccion. 		"' ";
	    $actSQL.="WHERE ar 				= '".$dato->ar. "'";
	    $bdAct = $linkc->query($actSQL);
	}
	$linkc->close();
}

if($dato->accion == 'crearCertificadoConformidad'){
	$Solicitante 		= 0;
	$ote 				= 0;
	$muestreo 			= 'off';
	$reMuestreo 		= 'off';
	$huinchaVerificada 	= 0;
	$upLoad 			= 'off';


	$fc = explode('-', $dato->ar);
	$codAr = intval($fc[1]);

	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM ar Where ar = '$dato->ar'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		
		$nColadasActual = $rs['nColadas'];
	    $actSQL="UPDATE ar SET ";
	    $actSQL.="nColadas            	= '".$dato->nColadas. 				"', ";
	    $actSQL.="fechaInspeccion       = '".$dato->fechaInspeccion. 		"', ";
	    $actSQL.="RutCli       			= '".$dato->RutCli. 				"', ";
	    $actSQL.="usrInspector       	= '".$dato->usrInspector. 			"' ";
	    $actSQL.="WHERE ar 				= '".$dato->ar. "'";
	    $bdAct = $linkc->query($actSQL);
		//$bdCot = $linkc->query("Delete From certificado Where CodCertificado like '%$dato->ar%'");
		for($i=1; $i<=$dato->nColadas; $i++){
			$nInf = '-'.$i;
			if($i<10){
				$nInf = '-0'.$i;
			}
			$CodCertificadoConsulta = $dato->ar.$nInf;

			if($dato->nColadas<10){
				$nInf .= '0'.$dato->nColadas;
			}else{
				$nInf .= $dato->nColadas;
			}
			$CodCertificado = $dato->ar.$nInf;
			$SQL = "SELECT * FROM certificado Where CodCertificado like '%$CodCertificadoConsulta%'";
			$bd=$linkc->query($SQL);
			if($rs = mysqli_fetch_array($bd)){
				$upLoad = $rs['upLoad'];
				if($upLoad == ''){
					$upLoad ='off';
				}
				$actSQL="UPDATE certificado SET ";
				$actSQL.="CodCertificado        = '".$CodCertificado. 			"', ";
				$actSQL.="upLoad        		= '".$upLoad. 					"', ";
				$actSQL.="RutCli       			= '".$dato->RutCli. 			"' ";
				$actSQL.="WHERE CodCertificado	like '%$CodCertificadoConsulta%'";
				$bdAct = $linkc->query($actSQL);		
			}else{
				$linkc->query("insert into certificado (
											CodCertificado				,
											RutCli 						,
											upLoad 						,
											Estado			
										) 
								values (	
											'$CodCertificado' 			,
											'$dato->RutCli' 			,
											'$upLoad' 					,
											'on'				
										)"
				);
			}
		}

		if($nColadasActual > $dato->nColadas){
			// 9 > 8
			$SQLdel = "SELECT * FROM certificado Where CodCertificado like '%$dato->ar%'";
			$bddel=$linkc->query($SQLdel);
			while($rsdel = mysqli_fetch_array($bddel)){
				$CodCerDelete = $rsdel['CodCertificado'];
				
				if(intval(substr($CodCerDelete, -2)) == $nColadasActual){
					// $Lote = $CodCerDelete;
					// $actSQL="UPDATE certificado SET ";
					// $actSQL.="Lote        = '".$Lote. 				"' ";
					// $actSQL.="WHERE CodCertificado	= '$CodCerDelete'";
					// $bdAct = $linkc->query($actSQL);		
	
					$bdCot = $linkc->query("Delete From certificado Where CodCertificado = '$CodCerDelete'");
				}
			}
		}

	}else{
		$linkc->query("insert into ar (
										ar							,
										codAr						,
										nColadas 					,
										fechaInspeccion 			,
			   							RutCli 						,
			   							usrInspector				,
										Solicitante					,
										ote							,
										muestreo					,
										reMuestreo					,
										huinchaVerificada			
									) 
							values (	
										'$dato->ar' 				,
										'$codAr' 					,
										'$dato->nColadas' 			,
										'$dato->fechaInspeccion' 	,
										'$dato->RutCli' 			,
										'$dato->usrInspector'		,
										'$Solicitante'				,
										'$ote'						,
										'$muestreo'					,
										'$reMuestreo'				,
										'$huinchaVerificada'				
									)"
		);
		
		for($i=1; $i<=$dato->nColadas; $i++){

			$nInf = '-'.$i;
			if($i<10){
				$nInf = '-0'.$i;
			}
			if($dato->nColadas<10){
				$nInf .= '0'.$dato->nColadas;
			}else{
				$nInf .= $dato->nColadas;
			}
			$CodCertificado = $dato->ar.$nInf;
			$linkc->query("insert into certificado (
										CodCertificado				,
			   							RutCli 						,
			   							upLoad 						,
										Estado			
									) 
							values (	
										'$CodCertificado' 			,
										'$upLoad' 					,
										'$dato->RutCli' 			,
										'on'				
									)"
			);

		}
		
	}
	$linkc->close();

	
}

if($dato->accion == 'G'){
	$Estado = 'on';
	$upLoad = 'off';
	$pdf	= '';
	if(isset($dato->pdf)){
		$pdf = $dato->pdf;
	}
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){

		$CodigoVerificacion = '';
		if($rs['CodigoVerificacion']){
			$CodigoVerificacion = $rs['CodigoVerificacion'];
		}else{
			$i=0; 
			$password=""; 
			$pw_largo = 12; 
			$desde_ascii = 50; // "2" 
			$hasta_ascii = 122; // "z" 
			$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
			while ($i < $pw_largo) { 
				mt_srand ((double)microtime() * 1000000); 
				$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
				if (!in_array ($numero_aleat, $no_usar)) { 
					$password = $password . chr($numero_aleat); 
					$i++; 
				} 
			}
			$CodigoVerificacion = $password;
		}
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="RutCli               	= '".$dato->RutCli.                	"', ";
	    $actSQL.="CodigoVerificacion    = '".$CodigoVerificacion.     		"', ";
	    $actSQL.="pdf               	= '".$pdf.                			"', ";
	    $actSQL.="Lote        			= '".$dato->Lote.         			"' ";
	    $actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado. 		"'";
	    $bdAct=$linkc->query($actSQL);
	}else{
		$i=0; 
		$password=""; 
		$pw_largo = 12; 
		$desde_ascii = 50; // "2" 
		$hasta_ascii = 122; // "z" 
		$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
		while ($i < $pw_largo) { 
			mt_srand ((double)microtime() * 1000000); 
			$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
			if (!in_array ($numero_aleat, $no_usar)) { 
				$password = $password . chr($numero_aleat); 
				$i++; 
			} 
		}
		$CodigoVerificacion = $password;

     	$linkc->query("insert into certificado (
												CodCertificado				,
												CodigoVerificacion			,
	                                            Lote 						,
	                                           	RutCli 						,
	                                           	Estado						,
	                                           	pdf							,
	                                           	upLoad
                                        ) 
                                 values (	
	                                            '$dato->CodCertificado' 	,
	                                            '$CodigoVerificacion' 		,
	                                            '$dato->Lote' 				,
	                                            '$dato->RutCli' 			,
	                                            '$Estado' 					,
	                                            '$pdf' 						,
	                                            '$upLoad'
                                        )"
                        );
	}
	$linkc->close();
}

if($dato->accion == 'D'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'off';
	    $actSQL="UPDATE certificado SET ";
	    $actSQL.="Estado            	= '".$Estado. 				"' ";
	    $actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado. "'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'H'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Estado = 'on';
	    $actSQL="UPDATE clientes SET ";
	    $actSQL.="Estado            	= '".$Estado. 		"' ";
	    $actSQL.="WHERE CodCertificado  = '".$dato->CodCertificado. "'";
	    $bdAct=$linkc->query($actSQL);
	}
	$linkc->close();
}
if($dato->accion == 'E'){
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$bdAct=$linkc->query("Delete From certificado Where CodCertificado = '$dato->CodCertificado'");	
	}
	$linkc->close();
}
?>