<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
	
include("../conexioncert.php");  
include_once("../conexionli.php"); 
$res = '';

if($dato->accion == 'asignarRAMAR'){
	$RAMAR 				= 0;
	$fechaInspeccion 	= date('Y-m-d'); 

	$link=Conectarse();
	$Descripcion 		= 'Certificación '.$dato->nColadas.' Coladas CAMAR '.$dato->CAMAR;
	$situacionMuestra 	= 'R';
	
	
	$SQLram = "SELECT * FROM registromuestras Order By RAM Desc"; 
	$bdram=$link->query($SQLram);
	if($rsram = mysqli_fetch_array($bdram)){
		$RAM 	= $rsram['RAM'] + 1;
		$RAMAR 	= $RAM;
		
		$Estado = 'P';
		$link->query("insert into registromuestras(	CAM,
													RAM,
													RutCli,
													Descripcion,
													situacionMuestra
												) 
									values 		(	'$dato->CAMAR',
													'$RAM',
													'$dato->RutCli',
													'$Descripcion',
													'$situacionMuestra'
		)");

		$fechaInicio = date('Y-m-d');

		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="RAM   			= '".$RAMAR. 				"', ";
		$actSQL.="fechaInicio		= '".$fechaInicio. 			"', ";
		$actSQL.="fechaAceptacion	= '".$fechaInicio. 			"', ";
		$actSQL.="Estado   			= '".$Estado. 				"' ";
		$actSQL.="WHERE CAM			= '$dato->CAMAR'";
		$bdAct = $link->query($actSQL);
		
		// Crea Muestras y AM en LE

		$fechaInicio 	= date('Y-m-d');
		$Archivada 		= 'off';
		$Taller 		= 'on';
		$idItem 		= 'Vacio';

		$SQLtr = "SELECT * FROM tablaregform"; 
		$bdtr=$link->query($SQLtr);
		if($rstr = mysqli_fetch_array($bdtr)){
			$nSolTaller = $rstr['nTaller'] + 1;

			$actSQL="UPDATE tablaregform SET ";
			$actSQL.="nTaller   		= '".$nSolTaller. 				"' ";
			$bdAct = $link->query($actSQL);
	
		}

		$link->query("insert into formram(	CAM,
											RAM,
											fechaInicio,
											Obs,
											nMuestras,
											Taller,
											nSolTaller,
											Archivada
										) 
								values 	(	'$dato->CAMAR',
											'$RAMAR',
											'$fechaInicio',
											'$Descripcion',
											'$dato->nColadas',
											'$Taller',
											'$nSolTaller',
											'$Archivada'
		)");



	}
	$link->close();

	$linkc=ConectarseCert();
	$SQLar = "SELECT * FROM ar Order By codAr Desc"; 
	$bdar=$linkc->query($SQLar);
	if($rsar = mysqli_fetch_array($bdar)){
		
		$codAr 	= $rsar['codAr'] + 1;
		$ar 	= 'AR-'.$codAr;
		if($codAr < 1000){ 
			$ar 	= 'AR-0'.$codAr;
		}
		
		$linkc->query("insert into ar(	ar						,
										codAr					,
										nColadas				,
										RAMAR					,
										CAMAR					,
										RutCli					,
										fechaInspeccion			,
										usrInspector
									) 
						values 		(	'$ar'					,
										'$codAr'				,
										'$dato->nColadas'		,
										'$RAMAR'				,
										'$dato->CAMAR'			,
										'$dato->RutCli'			,
										'$fechaInspeccion'		,
										'$dato->usrResponsable'
		)");

		$actSQL="UPDATE camar SET ";
		$actSQL.="RAMAR   			= '".$RAMAR. 				"' ";
		$actSQL.="WHERE CAMAR		= '$dato->CAMAR'";
		$bdAct = $linkc->query($actSQL);
		$tCol = 0;
		for($i=1; $i<=$dato->nColadas; $i++){
			$nCol = $i;
			$tCol =  $dato->nColadas;
			if($i < 10)				{ $nCol = '0'.$i; }
			if($dato->nColadas < 10){ $tCol = '0'.$dato->nColadas; }

			$CodCertificado = $ar.'-'.$nCol.$tCol;
			$upLoad = 'off';
			$Estado = 'on';

			$SQLpre = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$i'"; 
			$bdpre=$linkc->query($SQLpre);
			if($rspre = mysqli_fetch_array($bdpre)){
				$Lote 		= $rspre['Lote'];
				$Peso 		= $rspre['Peso'];
				$nProducto 	= $rspre['nProducto'];
				$nAcero 	= $rspre['nAcero'];
				$Dimension 	= $rspre['Dimension'];
			}
					
			$linkc->query("insert into certificado(	
										RutCli					,
										CodCertificado			,
										Lote					,
										Peso					,
										nProducto				,
										nAcero					,
										Dimension				,
										upLoad					,
										Estado					
									) 
						values 		(	'$dato->RutCli'			,
										'$CodCertificado'		,
										'$Lote'					,
										'$Peso'					,
										'$nProducto'			,
										'$nAcero'				,
										'$Dimension'			,
										'$upLoad'				,
										'$Estado'
			)");
			
		}

	}

	$linkc->Close();


	$linkc=ConectarseCert();
	$SQLar = "SELECT * FROM ar Where RAMAR = '$RAMAR'"; 
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
			$CodInforme = 'AM-'.$RAMAR.'-'.$nLote.$tColadas;
			if($nLote<10){
				$CodInforme = 'AM-'.$RAMAR.'-0'.$nLote.$tColadas;
			}
			$conEnsayo = 'on';

						/*
			NOTA:
				SI EL LOTE "$i":
				pesa <= 40000 					son 1 muestra
				pesa > 40000 	and <= 80000 	son 2 muestra
				pesa > 80000 	and <= 120000 	son 3 muestra
				pesa > 120000 	and <= 160000 	son 4 muestra
				.
				.
				.
				.
			*/

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
				$idItem = $RAMAR.'-'.$nroMuestra; // 18400-1
				if($nroMuestra<10){
					$idItem = $RAMAR.'-0'.$nroMuestra; // 18400-01 18400-02 18400-03
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





			// $idMuestra =  'Certificado OCP SIMET '.$rscer['CodCertificado'].' PL.'.$rscer['Dimension'].' Colada '.$rscer['Lote'];
			// $idMuestra =  'Certificado OCP SIMET AR';






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
		$actSQL.="WHERE RAM			= '$RAMAR'";
		$bdAct = $link->query($actSQL);
		$link->close();
		

	}
	$linkc->close();


	// Fin




	$res = '';
	$res.= '{"RAMAR":"'.				$RAMAR.						'",';
	$res.= '"CAMAR":"'. 				$dato->CAMAR. 				'",';
	$res.= '"ar":"'. 					$ar. 						'",';
	$res.= '"codAr":"'. 				$codAr. 					'",';
	$res.= '"idItem":"'. 				$idItem. 					'",';
	$res.= '"RutCli":"'. 				$dato->RutCli. 				'"}';
	echo $res;

}

if($dato->accion == 'informarLE'){
	$link=Conectarse();
	if($dato->RAMAR > 0){
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



			$Observacion 		= $dato->ar;
			$obsServicios 		= 'Certificación '.$dato->ar.' '.$dato->nColadas.' coladas '.$dato->fechaInspeccion;
			$Descripcion 		= 'Certificación '.$dato->ar.' '.$dato->nColadas.' coladas '.$dato->fechaInspeccion;
	
			$Estado			 	= 'E';
			$usrCotizador 		= 'GRC';
			$usrResponzable 	= 'GRC';
		
			$NetoUF 			= $ValorUF * $dato->nColadas;
			$IvaUF				= $NetoUF * 1.19;
			$BrutoUF			= $NetoUF + $IvaUF;
	
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

			// $NetoUF 			= $ValorUF * $dato->nColadas;
			$IvaUF				= $NetoUF * 0.19;
			$BrutoUF			= $NetoUF + $IvaUF;

			$actSQL="UPDATE cotizaciones SET ";
			$actSQL.="RutCli  			= '".$RutCli. 			"', ";
			$actSQL.="CAM   			= '".$CAM. 				"', ";
			$actSQL.="RAM   			= '".$RAM. 				"', ";
			$actSQL.="Observación   	= '".$Observación. 		"', ";
			$actSQL.="obsServicios  	= '".$obsServicios. 	"', ";
			$actSQL.="Descripcion  		= '".$Descripcion. 		"', ";
			$actSQL.="NetoUF  			= '".$NetoUF. 			"', ";
			$actSQL.="IvaUF  			= '".$IvaUF. 			"', ";
			$actSQL.="BrutoUF  			= '".$BrutoUF. 			"' ";
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


			// $nServicio 	= 1201;
			// $NetoUF 	= $ValorUF * $dato->nColadas;
			// $actSQL="UPDATE dcotizacion SET ";
			// $actSQL.="CAM   			= '".$CAM. 				"', ";
			// $actSQL.="Cantidad  		= '".$dato->nColadas. 	"', ";
			// $actSQL.="nServicio  		= '".$nServicio. 		"', ";
			// $actSQL.="NetoUF  			= '".$NetoUF. 			"', ";
			// $actSQL.="IvaUF  			= '".$IvaUF. 			"', ";
			// $actSQL.="TotalUF  			= '".$BrutoUF. 			"' ";
			// $actSQL.="WHERE CAM			= '$CAM'";
			// $bdAct = $link->query($actSQL);
			
		}

	}else{
		$SQL = "SELECT * FROM tablaregform"; 
		$bd=$link->query($SQL);
		if($rs = mysqli_fetch_array($bd)){

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
			$SQLcerAR = "SELECT * FROM certificado where CodCertificado like '%$dato->CAMAR%'"; 
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

			$RAM 				= 0;
			$Descripcion 		= 'Certificación '.$dato->ar.' '.$dato->nColadas.' '.$dato->fechaInspeccion;
			$situacionMuestra 	= 'R';

			$SQLram = "SELECT * FROM registromuestras Order By RAM Desc"; 
			$bdram=$link->query($SQLram);
			if($rsram = mysqli_fetch_array($bdram)){
				$RAM = $rsram['RAM'] + 1;
				$link->query("insert into registromuestras(	CAM,
															RAM,
															RutCli,
															Descripcion,
															situacionMuestra
														) 
											values 		(	'$CAM',
															'$RAM',
															'$dato->RutCli',
															'$Descripcion',
															'$situacionMuestra'
				)");

			}


			$Observacion 		= $dato->ar;
			$obsServicios 		= 'Certificación '.$dato->ar.' '.$dato->nColadas.' coladas '.$dato->fechaInspeccion;
			$Descripcion 		= 'Certificación '.$dato->ar.' '.$dato->nColadas.' coladas '.$dato->fechaInspeccion;
			$tpEnsayo 			= 5;
			$OFE 				= 'off';
			$fechaCotizacion 	= date('Y-m-d'); 
			$RutCli 			= $dato->RutCli;
			$nContacto 			= 1;
			$Validez 			= 30;
			$dHabiles 			= 10;
			$Moneda 			= 'U';
			$exentoIva 			= 'off';
			$valorUF 			= $rs['valorUFRef']; 

			$Estado			 	= 'E';
			$usrCotizador 		= 'GRC';
			$usrResponzable 	= 'GRC';

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

			// $NetoUF 			= $ValorUF * $dato->nColadas;
			$IvaUF				= $NetoUF * 0.19;
			$BrutoUF			= $NetoUF + $IvaUF;

			$link->query("insert into cotizaciones(		CAM					,
														RAM					,
														Estado				,
														RutCli				,
														nContacto			,
														usrCotizador		,
														usrResponzable		,
														tpEnsayo			,
														Validez				,
														dHabiles			,
														Moneda				,
														exentoIva			,
														valorUF				,
														OFE					,
														fechaCotizacion		,
														Observacion			,
														obsServicios		,
														Descripcion			,
														NetoUF				,
														IvaUF				,
														BrutoUF
													) 
											values 	(	'$CAM'						,
														'$RAM'						,
														'$Estado'					,
														'$dato->RutCli'				,
														'$nContacto'				,
														'$usrCotizador'				,
														'$usrResponzable'			,
														'$tpEnsayo'					,
														'$Validez'					,
														'$dHabiles'					,
														'$Moneda'					,
														'$exentoIva'				,
														'$valorUF'					,
														'$OFE'						,
														'$fechaCotizacion'			,
														'$Observacion'				,
														'$obsServicios'				,
														'$Descripcion'				,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		
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

			$linkc=ConectarseCert();

			$actSQL="UPDATE ar SET ";
			$actSQL.="RAMAR   			= '".$RAM. 				"' ";
			$actSQL.="WHERE ar			= '$dato->ar'";
			$bdAct = $linkc->query($actSQL);

			$actSQL="UPDATE certificado SET ";
			$actSQL.="RAMAR   				= '".$RAM. 				"' ";
			$actSQL.="WHERE CodCertificado Like '%".$dato->ar."%'";
			$bdAct = $linkc->query($actSQL);

			$linkc->close();

		}

	}
	$link->close();

}  

if($dato->accion == 'L'){    
	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM camar Where camar = '$dato->CAMAR'"; 
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$Situacion 		= 'Old';
		$Bloqueo 		= 'No';
		$certAsociado 	= 'No';
		$RAMAR 			= 0;


		$SQLcl = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
		$bdcl=$linkc->query($SQLcl);
		if($rscl = mysqli_fetch_array($bdcl)){

		}
		$res.= '{"RutCli":"'.				$rs["RutCli"].				'",';
		$res.= '"CAMAR":"'. 				$rs["CAMAR"]. 				'",';
		$res.= '"RAMAR":"'. 				$rs["RAMAR"]. 				'",';
		$res.= '"Situacion":"'. 			$Situacion. 				'",';
		$res.= '"Bloqueo":"'. 				$Bloqueo. 					'",';
		$res.= '"fechaPreCAM":"'. 			$rs["fechaPreCAM"]. 		'",';
		$res.= '"usrResponsable":"'. 		$rs["usrResponsable"]. 		'",';
		$res.= '"nColadas":"'. 				$rs["nColadas"]. 			'"}';
	}else{
		$nColadas 			= 1;
		$fechaPreCAM 		= date('Y-m-d');
		$ar 				= 'AR-0001';
		$SQL = "SELECT * FROM camar Order By camar Desc";
		$bd=$linkc->query($SQL);
		if($rs = mysqli_fetch_array($bd)){
			$CAMAR 		= $rs['CAMAR'] + 1;
			$Situacion 	= 'New';

			$res.= '{"RAMAR":"'.				$RAMAR.						'",';
			$res.= '"CAMAR":"'. 				$CAMAR. 					'",';
			$res.= '"Situacion":"'. 			$Situacion. 				'",';
			$res.= '"fechaPreCAM":"'. 			$fechaPreCAM. 				'",';
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
	$SQL = "SELECT * FROM dCAMAR Where CAMAR = '$dato->CAMAR' Order By Colada";
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
		$outp .= '"Colada":"'. 				$rs["Colada"]. 		'",';
		$outp .= '"Lote":"'. 				$rs["Lote"]. 				'",';
		$outp .= '"Peso":"'. 				$rs["Peso"]. 				'",';
		$outp .= '"nDescargas":"'. 			$rs["nDescargas"]. 			'",';
		$outp .= '"upLoad":"'. 				$rs["upLoad"]. 				'",';
		$outp .= '"Estado":"'. 				$rs["Estado"]. 				'"}';
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

if($dato->accion == 'crearPreCAM'){
	$RAMAR 			= 0;
	$CAMAR 			= 0;
	$Estado 		= 'E';
	$tpEnsayo 		= 5;
	$nLin 			= 1;
	$Validez		= 30;
	$dHabiles		= 30;
	$Moneda			= 'U';
	$exentoIva 		= 'off';
	$OFE 			= 'off';

	$RutCli 		= '12345678-5';
	$nColadas 		= '1';
	$usrResponsable = 'AVR';

	$link=Conectarse();

	$nServicio 	= 1201;
	$ValorUF 	= 0;
	$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
	$bdser=$link->query($SQLser);
	if($rsser = mysqli_fetch_array($bdser)){
		$ValorUF = $rsser['ValorUF'];
	}	

	$Descripcion 	= 'Certificación '.$dato->nColadas.' Coladas';
	$Observacion 	= 'Certificación '.$dato->nColadas.' Coladas';
	$obsServicios 	= 'Certificación '.$dato->nColadas.' Coladas';


	$SQL = "SELECT * FROM tablaregform"; 
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$CAM 		= $rs['CAM'] + 1;

		$actSQL="UPDATE tablaregform SET ";
		$actSQL.="CAM   = '".$CAM. 		"' ";
		$bdAct = $link->query($actSQL);

		$CAMAR 		= $CAM;
		$valorUF 	= $rs['valorUFRef']; 

		// Calculo Costo por Colada
		$NetoUF		= $ValorUF * $dato->nColadas;
		$IvaUF		= $NetoUF * 0.19;
		$BrutoUF	= $NetoUF + $IvaUF;

		$link->query("insert into cotizaciones(		CAM							,
													RAM							,
													Estado						,
													RutCli						,
													usrCotizador				,
													usrResponzable				,
													tpEnsayo					,
													Validez						,
													dHabiles					,
													Moneda						,
													exentoIva					,
													valorUF						,
													OFE							,
													fechaCotizacion				,
													Observacion					,
													obsServicios				,
													Descripcion					,
													NetoUF						,
													IvaUF						,
													BrutoUF
												) 
										values 	(	'$CAMAR'					,
													'$RAMAR'					,
													'$Estado'					,
													'$dato->RutCli'				,
													'$dato->usrResponsable'		,
													'$dato->usrResponsable'		,
													'$tpEnsayo'					,
													'$Validez'					,
													'$dHabiles'					,
													'$Moneda'					,
													'$exentoIva'				,
													'$ValorUF'					,
													'$OFE'						,
													'$dato->fechaPreCAM'		,
													'$Observacion'				,
													'$obsServicios'				,
													'$Descripcion'				,
													'$NetoUF'					,
													'$IvaUF'					,
													'$BrutoUF'
		)");

		
		$link->query("insert into dcotizacion(		CAM							,
													nLin						,
													nServicio					,
													Cantidad					,
													unitarioUF					,
													NetoUF						,
													IvaUF						,
													TotalUF
												) 
										values 	(	'$CAMAR'					,
													'$nLin'						,
													'$nServicio'				,
													'$dato->nColadas'			,
													'$ValorUF'					,
													'$NetoUF'					,
													'$IvaUF'					,
													'$BrutoUF'
		)");
		
	}
	




	$link->close();

	$linkc=ConectarseCert();

	$linkc->query("insert into camar(	CAMAR					,
										RAMAR					,
										fechaPreCAM				,
										RutCli					,
										nColadas				,
										usrResponsable
									) 
						values 		(	'$CAMAR'				,
										'$RAMAR'				,
										'$dato->fechaPreCAM'	,
										'$dato->RutCli'			,
										'$dato->nColadas'		,
										'$dato->usrResponsable'
				)");

	for($i=1; $i<=$dato->nColadas; $i++){
		$linkc->query("insert into dcamar(	CAMAR					,
											Colada					,
											RutCli
									) 
						values 		(		'$CAMAR'				,
											'$i'					,
											'$dato->RutCli'
				)");
	}


	$res = '';

	$SQL = "SELECT * FROM camar Where camar = '$CAMAR'"; 
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$res.= '{"RutCli":"'.				$rs["RutCli"].				'",';
		$res.= '"CAMAR":"'. 				$rs["CAMAR"]. 				'",';
		$res.= '"usrResponsable":"'. 		$rs["usrResponsable"]. 		'",';
		$res.= '"nColadas":"'. 				$rs["nColadas"]. 			'"}';
	}

	$linkc->close();

	echo $res;	


}

if($dato->accion == 'actualizaPreCAM'){ 
	$Solicitante 		= 0;
	$ote 				= 0;
	$muestreo 			= 'off';
	$reMuestreo 		= 'off';
	$huinchaVerificada 	= 0;
	$RAMAR 				= 0;


	$linkc=ConectarseCert();
	$SQL = "SELECT * FROM camar Where camar = '$dato->CAMAR'";
	$bd=$linkc->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$nColadasActual = $rs['nColadas'];
	    $actSQL="UPDATE camar SET ";
	    $actSQL.="nColadas            	= '".$dato->nColadas. 				"', ";
	    $actSQL.="fechaPreCAM       	= '".$dato->fechaPreCAM. 			"', ";
	    $actSQL.="RutCli       			= '".$dato->RutCli. 				"', ";
	    $actSQL.="usrResponsable       	= '".$dato->usrResponsable. 		"' ";
	    $actSQL.="WHERE camar 			= '".$dato->CAMAR. "'";
	    $bdAct = $linkc->query($actSQL);


		for($i=1; $i<=$dato->nColadas; $i++){
			$SQLd = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR' and Colada = '$i'";
			$bdd=$linkc->query($SQLd);
			if($rsd = mysqli_fetch_array($bd)){

			}else{
				$linkc->query("insert into dcamar (
											CAMAR						,
											Colada						,
											   RutCli 						
										) 
								values (	
											'$dato->CAMAR' 				,
											'$i' 						,
											'$dato->RutCli' 			
										)"
				);
			}
		}
		if($dato->nColadas < $nColadasActual){
			$bdCot = $linkc->query("Delete From dcamar Where CAMAR like '%$dato->CAMAR%' and Colada > '$dato->nColadas'");
		}

	}
	$linkc->close();
	
	
	$link=Conectarse();
	$nServicio 	= 1201;
	$ValorUF 	= 0;
	$NetoUF 	= 0;
	$IvaUF 		= 0;
	$BrutoUF	= 0;

	$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
	$bdser=$link->query($SQLser);
	if($rsser = mysqli_fetch_array($bdser)){
		$ValorUF = $rsser['ValorUF'];
	}	
	
	$Descripcion 	= 'Certificación '.$dato->nColadas.' Coladas';
	$Observacion 	= 'Certificación '.$dato->nColadas.' Coladas';
	$obsServicios 	= 'Certificación '.$dato->nColadas.' Coladas';
	
	$SQLcam = "SELECT * FROM cotizaciones where CAM = '$dato->CAMAR'"; 
	$bdcam=$link->query($SQLcam);
	if($rscam = mysqli_fetch_array($bdcam)){
		// Calculo Costo por Colada
		$NetoUF		= $ValorUF * $dato->nColadas;
		$IvaUF		= $NetoUF * 0.19;
		$BrutoUF	= $NetoUF + $IvaUF;
		

		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="Observacion   = '".$Observacion. 				"', ";
		$actSQL.="Descripcion   = '".$Descripcion. 				"', ";
		$actSQL.="obsServicios  = '".$obsServicios. 			"', ";
		$actSQL.="usrCotizador  = '".$dato->usrResponsable. 	"', ";
		$actSQL.="valorUF   	= '".$ValorUF. 					"', ";
		$actSQL.="NetoUF   		= '".$NetoUF. 					"', ";
		$actSQL.="IvaUF   		= '".$IvaUF. 					"', ";
		$actSQL.="BrutoUF   	= '".$BrutoUF. 					"' ";
		$actSQL.="WHERE CAM 	= '$dato->CAMAR'";
		$bdAct = $link->query($actSQL);

		$bdCot = $link->query("Delete From dcotizacion Where CAM = '$dato->CAMAR'");

		$linkc=ConectarseCert();

		$lotesMenos40  = 0;
		$lotesMenos80  = 0;
		$lotesMenos120 = 0;

		$SQLd = "SELECT * FROM dcamar Where CAMAR = '$dato->CAMAR'";
		$bdd=$linkc->query($SQLd);
		while($rsd = mysqli_fetch_array($bdd)){
			if($rsd['Peso']<=40000)  { $lotesMenos40++;  }
			if($rsd['Peso']>40000 and $rsd['Peso']<=80000)  { $lotesMenos80++;  }
			if($rsd['Peso']>80000 and $rsd['Peso']<=120000) { $lotesMenos120++; }
		}

		if($lotesMenos40>0){
			$nLin = 0;
			$nServicio 	= 1201;
			$ValorUF 	= 0;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}	
	
			$nLin++;
			$NetoUF		= $ValorUF * $lotesMenos40;
			$IvaUF		= $NetoUF * 0.19;
			$BrutoUF	= $NetoUF + $IvaUF;
	
			$link->query("insert into dcotizacion(		CAM							,
														nLin						,
														nServicio					,
														Cantidad					,
														unitarioUF					,
														NetoUF						,
														IvaUF						,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'					,
														'$nLin'						,
														'$nServicio'				,
														'$lotesMenos40'			,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}	
		if($lotesMenos80>0){
			$nLin = 0;
			$nServicio 	= 1203;
			$ValorUF 	= 0;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}	
	
			$nLin++;
			$NetoUF		= $ValorUF * $lotesMenos80;
			$IvaUF		= $NetoUF * 0.19;
			$BrutoUF	= $NetoUF + $IvaUF;
	
			$link->query("insert into dcotizacion(		CAM							,
														nLin						,
														nServicio					,
														Cantidad					,
														unitarioUF					,
														NetoUF						,
														IvaUF						,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'					,
														'$nLin'						,
														'$nServicio'				,
														'$lotesMenos80'			,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}	
		if($lotesMenos120>0){
			$nLin = 0;
			$nServicio 	= 1202;
			$ValorUF 	= 0;
			$SQLser = "SELECT * FROM servicios where nServicio = '$nServicio'"; 
			$bdser=$link->query($SQLser);
			if($rsser = mysqli_fetch_array($bdser)){
				$ValorUF = $rsser['ValorUF'];
			}	
	
			$nLin++;
			$NetoUF		= $ValorUF * $lotesMenos120;
			$IvaUF		= $NetoUF * 0.19;
			$BrutoUF	= $NetoUF + $IvaUF;
	
			$link->query("insert into dcotizacion(		CAM							,
														nLin						,
														nServicio					,
														Cantidad					,
														unitarioUF					,
														NetoUF						,
														IvaUF						,
														TotalUF
													) 
											values 	(	'$dato->CAMAR'					,
														'$nLin'						,
														'$nServicio'				,
														'$lotesMenos120'			,
														'$ValorUF'					,
														'$NetoUF'					,
														'$IvaUF'					,
														'$BrutoUF'
			)");
		}	

		$linkc->close();
/*
		$actSQL="UPDATE dcotizacion SET ";
		$actSQL.="Cantidad   	= '".$dato->nColadas. 	"', ";
		$actSQL.="unitarioUF   	= '".$ValorUF. 			"', ";
		$actSQL.="NetoUF   		= '".$NetoUF. 			"', ";
		$actSQL.="IvaUF   		= '".$IvaUF. 			"', ";
		$actSQL.="TotalUF   	= '".$BrutoUF. 			"' ";
		$actSQL.="WHERE CAM 	= '$dato->CAMAR'";
		$bdAct = $link->query($actSQL);
*/
	}	

	$link->close();
	
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