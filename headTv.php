<?php
	$mIndice = date('m');
	$aIndice = date('Y');
	$indMin  = 0;
	$indMeta = 0;
	$indDesc = 0;
	$indDesc2 = 0;
	$indDesc3 = 0;
	$TindDesc = 0;
	$link=Conectarse();
	$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '$mIndice' and agnoInd = '$aIndice'");
	if($rowInd=mysqli_fetch_array($bdInd)){ 
		$indMin  = $rowInd['indMin'];
		$indMeta = $rowInd['indMeta']; 
		$TindDesc = $rowInd['indDesc'] + $rowInd['indDesc2'] + $rowInd['indDesc3'];
	}


	$tDiasMes 	= date('t');
	$fechaAct 	= date('Y-m-d');
	$fdAct 		= explode('-', $fechaAct); 
	$diadeHoy 	= $fdAct[2];
	$tFeriados = 0;
	$bdfer=$link->query("SELECT * FROM diasferiados Where year(fecha) = '$aIndice' and month(fecha) = '$mIndice'");
	while($rowfer=mysqli_fetch_array($bdfer)){
		$tFeriados++;
	}
	$diasFinde = 0;
	$dCorridos = 0;
					
	for($dias = 1; $dias<=$tDiasMes; $dias++){
						
		$dd = $dias; 
		if($dias < 10) { $dd = '0'.$dias; }
		$fecha = strtotime("$aIndice-".$mIndice."-$dd");
		$fecha = date('Y-m-d',$fecha);
		if($fecha <= $fechaAct){
			if(date('N', strtotime($fecha)) == 6 or date('N', strtotime($fecha)) == 7){
			}else{
				$bdfer=$link->query("SELECT * FROM diasferiados Where fecha = '".$fecha."'");
				if($rowfer=mysqli_fetch_array($bdfer)){
				}else{
					$dCorridos++;
				}	
			}
		}	
		if(date('N', strtotime($fecha)) == 6){
			$diasFinde++;
		}
		if(date('N', strtotime($fecha)) == 7){
			$diasFinde++;
		}
	}

	$tDiasMes = $tDiasMes - $diasFinde - $tFeriados;
	$iMin = round((($indMin / $tDiasMes) * $fdAct[2]),2);
	$iMet = round((($indMeta / $tDiasMes) * $fdAct[2]),2);

	$indVtas 	= 0;
	$tNeto 		= 0;

	$bdv = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = '$aIndice' and month(fechaSolicitud) = '$mIndice'");

	while ($rowv=mysqli_fetch_array($bdv)){
		$bdcl=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowv['RutCli']."'");
		if($rowcl=mysqli_fetch_array($bdcl)){
			$cFree = $rowcl['cFree'];
			if($rowcl['cFree'] != 'on'){
				if($rowv['Neto']>0){
					$tNeto += $rowv['Neto'];
				}
			}
		}
	}
	$indVtas  	= round($tNeto/1000000,2);

	$vta3 	= 0;
	$vta6	= 0;
	$mesDesde = $mIndice - 2;



	$agnoActual = $aIndice;
	$agnoInicio = $agnoActual;
	$mesActual	= $mIndice;
	$mesFin		= $mesActual;
	$agnoFin	= $agnoActual;

	if($mesActual == 1 or $mesActual == 2 or $mesActual == 3){ 
		$mesInicio  = $mesActual + 9;
		if($mesActual == 1){ 
			$agnoInicio	= $agnoActual - 1;
			$agnoFin  	= $agnoInicio;
			$mesFin		= 12;
		}
		if($mesActual == 2){ 
			$mesFin 	= 1; 
			$agnoFin  	= $agnoActual;
			$agnoInicio	= $agnoActual - 1;
		}
		if($mesActual == 3){ 
			$mesFin = 2; 
			$agnoFin = $agnoActual; 
			$agnoInicio	= $agnoActual - 1;
		}
	}else{ 
		$mesInicio  = $mesActual - 3;
		$mesFin		= $mesActual -1;
	}
	$fecha3 = strtotime("$agnoInicio-".$mesInicio."-01");
	$fecha3 = date('Y-m-d',$fecha3);

	$uDiaMes = 31;
	if($mesFin == 1 or $mesFin == 3 or $mesFin == 5 or $mesFin == 7 or $mesFin == 8 or $mesFin == 10 or $mesFin == 12){
		$uDiaMes = 31;
	}
	if($mesFin == 4 or $mesFin == 6 or $mesFin == 9 or $mesFin == 11){
		$uDiaMes = 30;
	}
	if($mesFin == 2){
		$uDiaMes = 28;
		if(($agnoFin/4) == intval($agnoFin/4)){
			$uDiaMes = 29;
		}
	}
	$fechaFin = strtotime("$agnoFin-".$mesFin."-$uDiaMes");
	$fechaFin = date('Y-m-d',$fechaFin);

	//echo $fecha3.' '.$fechaFin;
	$iMinHis3 	= 0;
	$iMetaHis3 	= 0;
	for($mesIndice = $mesInicio; $mesIndice < $mesInicio + 3; $mesIndice++){
		$mesIndiceDatos = $mesIndice;
		if($mesIndice == 13) { $mesIndiceDatos = 1; $agnoInicio = date('Y');}
		if($mesIndice == 14) { $mesIndiceDatos = 2; $agnoInicio = date('Y');}
		$SQLv = "SELECT * FROM tabindices WHERE year(fechaIndice) = '$agnoInicio' and month(fechaIndice) = '$mesIndiceDatos' Order By fechaIndice Desc";
		//echo $SQLv.'<br>';
		$bdv = $link->query($SQLv);
		if ($rowv=mysqli_fetch_array($bdv)){
			$SQLi = "SELECT * FROM tablaindicadores WHERE agnoInd = '$agnoInicio' and mesInd = '$mesIndiceDatos'";
			//echo $SQLi.'<br>';
			$bdi = $link->query($SQLi);
			if ($rowi=mysqli_fetch_array($bdi)){
				$vta3 += ($rowv['indVtas'] - ($rowi['indDesc'] + $rowi['indDesc2']+ $rowi['indDesc3']));
				//echo $vta3.'<br>';
				$iMinHis3 += $rowv['iMinimo'];
				$iMetaHis3 += $rowv['iMeta'];
			}else{
				$vta3 += $rowv['indVtas'];
			}
		}
	}

	$agnoActual = $aIndice;
	$agnoInicio = $agnoActual;
	$mesActual	= $mIndice;
	$mesFin		= $mesActual;
	$agnoFin	= $agnoActual;

	//$mesActual = 7;
	if($mesActual == 1 or $mesActual == 2 or $mesActual == 3 or $mesActual == 4 or $mesActual == 5 or $mesActual == 6){ 
		$mesInicio  = $mesActual + 6;
		if($mesActual == 1){ 
			$agnoInicio	= $agnoActual - 1;
			$agnoFin  	= $agnoInicio;
			$mesFin 	= 12;
		}
		if($mesActual == 2){ 
			$mesFin 	= 1; 
			$agnoFin  	= $agnoActual;
			$agnoInicio	= $agnoActual - 1;
		}
		if($mesActual == 3){ 
			$mesFin = 2; 
			$agnoFin = $agnoActual; 
			$agnoInicio	= $agnoActual - 1;
		}
		if($mesActual == 4){ 
			$mesFin = 3; 
			$agnoFin = $agnoActual; 
			$agnoInicio	= $agnoActual - 1;
		}
		if($mesActual == 5){ 
			$mesFin = 4; 
			$agnoFin = $agnoActual; 
			$agnoInicio	= $agnoActual - 1;
		}
		if($mesActual == 6){ 
			$mesFin = 5; 
			$agnoFin = $agnoActual; 
			$agnoInicio	= $agnoActual - 1;
		}
	}else{ 
		$mesInicio  = $mesActual - 6;
		$mesFin		= $mesActual -1;
	}
	$fecha6 = strtotime("$agnoInicio-".$mesInicio."-01");
	$fecha6 = date('Y-m-d',$fecha6);

	$uDiaMes = 31;
	if($mesFin == 1 or $mesFin == 3 or $mesFin == 5 or $mesFin == 7 or $mesFin == 8 or $mesFin == 10 or $mesFin == 12){
		$uDiaMes = 31;
	}
	if($mesFin == 4 or $mesFin == 6 or $mesFin == 9 or $mesFin == 11){
		$uDiaMes = 30;
	}
	if($mesFin == 2){
		$uDiaMes = 28;
		if(($agnoFin/4) == intval($agnoFin/4)){
			$uDiaMes = 29;
		}
	}
	$fechaFin = strtotime("$agnoFin-".$mesFin."-$uDiaMes");
	$fechaFin = date('Y-m-d',$fechaFin);

	$vta6	= 0;
	$mesDesde = $mIndice - 5;

	$iMinHis6 	= 0;
	$iMetaHis6 	= 0;
	for($mesIndice = $mesInicio; $mesIndice < $mesInicio + 6; $mesIndice++){
		$mesIndiceDatos = $mesIndice;
		if($mesIndice == 13) { $mesIndiceDatos = 1; $agnoInicio = date('Y');}
		if($mesIndice == 14) { $mesIndiceDatos = 2; $agnoInicio = date('Y');}
		if($mesIndice == 15) { $mesIndiceDatos = 3; $agnoInicio = date('Y');}
		if($mesIndice == 16) { $mesIndiceDatos = 4; $agnoInicio = date('Y');}
		if($mesIndice == 17) { $mesIndiceDatos = 5; $agnoInicio = date('Y');}
		if($mesIndice == 18) { $mesIndiceDatos = 6; $agnoInicio = date('Y');}
		$SQLv = "SELECT * FROM tabindices WHERE year(fechaIndice) = '$agnoInicio' and month(fechaIndice) = '$mesIndiceDatos' Order By fechaIndice Desc";
		//echo $SQLv.'<br>';
		$bdv = $link->query($SQLv);
		if ($rowv=mysqli_fetch_array($bdv)){
			$SQLi = "SELECT * FROM tablaindicadores WHERE agnoInd = '$agnoInicio' and mesInd = '$mesIndiceDatos'";
			//echo $SQLi.'<br>';
			$bdi = $link->query($SQLi);
			if ($rowi=mysqli_fetch_array($bdi)){
				$vta6 += ($rowv['indVtas'] - ($rowi['indDesc']+ $rowi['indDesc2'] + $rowi['indDesc3']));
				$iMinHis6 += $rowv['iMinimo'];
				$iMetaHis6 += $rowv['iMeta'];
			}else{
				$vta6 += $rowv['indVtas'];
			}
		}
	}


	$bgver 	= "bg-success text-white text-white border";
	$bgama	= "bg-warning text-dark text-white border";
	$bgroj	= "bg-danger text-white border";
	$bginf 	= "bg-info text-white border";

	$link->close();
?>

									<style>
									.floating-box {
										display: 			inline-block;
										width: 				70px;
										height: 			70px;
										border: 			1px solid #000;
										background-color: 	#FE9A2E;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		normal;
										color:				#000;
									}
									.textoDiv {
										color:				#000;
										font-size:			18px;
										font-family:		Arial;
										font-weight: 		bold;
									}	
									.textoDivDiv {
										color:				#000;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		bold;
									}	
									.textoDivTit {
										color:				#fff;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		normal;
									}	
									.after-box {
										border: 3px solid red; 
									}
									</style>									






									<?php 
										$nCols = round($nRams/12);
									?>
				<?php
					$Mes = array(
						1 => 'Enero', 
						2 => 'Febrero',
						3 => 'Marzo',
						4 => 'Abril',
						5 => 'Mayo',
						6 => 'Junio',
						7 => 'Julio',
						8 => 'Agosto',
						9 => 'Septiembre',
						10 => 'Octubre',
						11 => 'Noviembre',
						12 => 'Diciembre'
					);

					$indOld = array(
						1 	=> 0, 
						2	=> 0,
						3 	=> 0,
						4 	=> 0,
						5 	=> 0,
						6 	=> 0,
						7 	=> 0,
						8 	=> 0,
						9	=> 0,
						10 	=> 0,
						11 	=> 0,
						12	=> 0
					);
					
					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);
					
					$fdInicial	= $fd[1] - 3;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					$link=Conectarse();
					$tNeto	= 0;
					$vUF	= 0;

					$bdUfRef=$link->query("Select * From tablaRegForm");
					if($rowUfRef=mysqli_fetch_array($bdUfRef)){
						$vUF = $rowUfRef['valorUFRef'];
					}

					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fdInicial	= $fd[1] - 2;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fdInicial	= $fd[1] - 1;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);

					$Agno 	= $fd[0];
					$tNeto 	= 0;
					$tProdIC = 0;
					$tProdAF = 0;
					$tProdCF = 0;
					$tProdIR = 0;
					$tProdIO = 0;
					$nInfoIC = 0;
					$nInfoAF = 0;
					$nInfoCE = 0;
					$nInfoIR = 0;
					$nInfoIO = 0;
					$link=Conectarse();
					$result  = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fd[1]."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
										$fdr = explode('-', $rowGas['informesAM']);
										$nEn = 0;
										foreach ($fdr as $valor){
											//echo $valor.'<br>';
											$nEn++;
											$bdc  = $link->query("SELECT * FROM Cotizaciones Where RAM = '$valor'" );
											if($rs=mysqli_fetch_array($bdc)){


												if($rs['tpEnsayo'] == 1){
													if($nEn == 1){
														$tProdIC += $rowGas['Neto'];
													}
													$nInfoIC++;
												}
												if($rs['tpEnsayo'] == 2){
													if($nEn == 1){
														$tProdAF += $rowGas['Neto'];
													}
													$nInfoAF++;
												}
												if($rs['tpEnsayo'] == 3){
													if($nEn == 1){
														$tProdCF += $rowGas['Neto'];
													}
													$nInfoCE++;
												}
												if($rs['tpEnsayo'] == 4){
													if($nEn == 1){
														$tProdIR += $rowGas['Neto'];
													}
													$nInfoIR++;
												}
												if($rs['tpEnsayo'] == 5){
													if($nEn == 1){
														$tProdIO += $rowGas['Neto'];
													}
													$nInfoIO++;
												}


											}

										}
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));


					}
					$actSQL="UPDATE tablaindicadores SET ";
					$actSQL.="nInfoIC			= '".$nInfoIC.	"',";
					$actSQL.="nInfoAF			= '".$nInfoAF.	"',";
					$actSQL.="nInfoCE			= '".$nInfoCE.	"',";
					$actSQL.="nInfoIR			= '".$nInfoIR.	"',";
					$actSQL.="nInfoIO			= '".$nInfoIO.	"',";
					$actSQL.="ProductividadIC	= '".$tProdIC.	"',";
					$actSQL.="ProductividadAF	= '".$tProdAF.	"',";
					$actSQL.="ProductividadCF	= '".$tProdCF.	"',";
					$actSQL.="ProductividadIR	= '".$tProdIR.	"',";
					$actSQL.="ProductividadIO	= '".$tProdIO.	"'";
					$actSQL.="WHERE agnoInd = $Agno and mesInd = '".$fd[1]."'";
					$bdProc=$link->query($actSQL);

					$indVtas  = round($tNeto/1000000,2);
					$link->close();

					
					//$bdInd=$link->query("SELECT * FROM tablaRegForm");
					$indMin 	= 0;
					$indMeta 	= 0;
					$link=Conectarse();
					$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$fd[1]."' and agnoInd = '".$fd[0]."'");
					if($row=mysqli_fetch_array($bdInd)){
						$indMin  = $row['indMin'];
						$indMeta = $row['indMeta'];
					}
					
					$tDiasMes 	= date('t');
					$fechaAct 	= date('Y-m-d');
					$fdAct 		= explode('-', $fechaAct);
					$diadeHoy 	= $fdAct[2];
					
					$tFeriados = 0;
					$bd=$link->query("SELECT * FROM diasferiados Where year(fecha) = '".$fd[0]."' and month(fecha) = '".$fd[1]."'");
					if($row=mysqli_fetch_array($bd)){
						do{
							$tFeriados++;
						}while ($row=mysqli_fetch_array($bd));
					}
					$diasFinde = 0;
					$dCorridos = 0;
					
					for($dias = 1; $dias<=$tDiasMes; $dias++){
						
					//for($dias = 1; $dias<=$tDiasMes; $dias++){
						$dd = $dias;
						if($dias < 10) { $dd = '0'.$dias; }
						$fecha = strtotime("$Agno-".$fd[1]."-$dd");
						$fecha = date('Y-m-d',$fecha);
						if($fecha <= $fechaAct){
							if(date('N', strtotime($fecha)) == 6 or date('N', strtotime($fecha)) == 7){
							}else{
								$bd=$link->query("SELECT * FROM diasferiados Where fecha = '".$fecha."'");
								if($row=mysqli_fetch_array($bd)){
								}else{
									$dCorridos++;
								}	
							}
						}	
						if(date('N', strtotime($fecha)) == 6){
							$diasFinde++;
						}
						if(date('N', strtotime($fecha)) == 7){
							$diasFinde++;
						}
					}

					$tDiasMes = $tDiasMes - $diasFinde - $tFeriados;
					$iMin = round((($indMin / $tDiasMes) * $fdAct[2]),2);
					$iMet = round((($indMeta / $tDiasMes) * $fdAct[2]),2);
					$link->close();

					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);

					$Agno 			= $fd[0];
					$tProductividad	= 0;
					$tProduccionP	= 0;

					$tProdUFPesos	= 0;
					$tProdIC		= 0;
					$tProdAF		= 0;
					$tProdCF		= 0;
					$tProdIR		= 0;
					$tProIR 		= 0;

					$link	= Conectarse();
					$result  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio != '0000-00-00' and year(fechaTermino) = '".$Agno."' and month(fechaTermino) = '".$fd[1]."'" );
					while($rowGas=mysqli_fetch_array($result)){
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['NetoUF']>0 and $rowGas['Neto'] == 0){
										$tProductividad += $rowGas['NetoUF'];
										if($rowGas['tpEnsayo'] == 1){
											$tProdIC += ($rowGas['NetoUF'] * $vUF);
										}
										if($rowGas['tpEnsayo'] == 2){
											$tProdAF += ($rowGas['NetoUF'] * $vUF);
											//$tProdAF += $rowGas['NetoUF'];
										}
										if($rowGas['tpEnsayo'] == 3){
											$tProdCF += ($rowGas['NetoUF'] * $vUF);
											//$tProdAF += $rowGas['NetoUF'];
										}
										if($rowGas['tpEnsayo'] == 4){
											$tProdIR += ($rowGas['NetoUF'] * $vUF);
											//$tProdAF += $rowGas['NetoUF'];
										}
									}else{
										$tProduccionP += $rowGas['Neto'];
										if($rowGas['tpEnsayo'] == 1){
											$tProdIC += $rowGas['Neto'];
										}
										if($rowGas['tpEnsayo'] == 2){
											$tProdAF += $rowGas['Neto'];
										}
										if($rowGas['tpEnsayo'] == 3){
											$tProdCF += $rowGas['Neto'];
										}
										if($rowGas['tpEnsayo'] == 4){
											$tProIR += $rowGas['Neto'];
										}
									}
								}
							}
					}
/*					
					$actSQL="UPDATE tablaindicadores SET ";
					$actSQL.="ProductividadIC	= '".$tProdIC.	"',";
					$actSQL.="ProductividadAF	= '".$tProdAF.	"',";
					$actSQL.="ProductividadCF	= '".$tProdCF.	"',";
					$actSQL.="ProductividadIR	= '".$tProdIR.	"'";
					$actSQL.="WHERE agnoInd = $Agno and mesInd = '".$fd[1]."'";
					$bdProc=$link->query($actSQL);
*/
					$tProdUF = round((($tProductividad * $vUF) + $tProduccionP)/1000000,2);
					if($tProductividad > 0){
						$tProdUFPesos  = $tProductividad * $vUF;
					}
					//echo 'Prod '.$tProductividad.' '.$tProduccionP.' '.$tProdUFPesos.'<br>';
					$tProductividad = round(($tProdUFPesos + $tProduccionP)/1000000,2);
					//$tProductividad = $tProdUF;
					$link->close();
					
					$cIndice = "indIndiceRojo";
					if($iMin > $indMin) { $iMin = $indMin; }
					if($iMet > $indMeta){ $iMet = $indMeta; }
					
					if($indVtas > $iMin and $indVtas > $iMet){
						$cIndice = "indIndiceVerde";
					}
					if($indVtas > $iMin and $indVtas < $iMet){
						$cIndice = "indIndiceAmarillo";
					}
					if($indVtas < $iMin and $indVtas < $iMet){
						$cIndice = "indIndiceRojo";
					}

				// +++ +++	
				?>

				<?php
					$fdInicial	= $fd[1] - 3;
					$fdFinal	= $fd[1] - 1;
					if($fdInicial <= 0){
						$fdInicial  = 12 + $fdInicial;
						$fdFinal	= $fdInicial + 2;
					}
					
					$link=Conectarse();
					$mIndicador	= 0;
					$mMeta		= 0;
					$mMin		= 0;
								
					$mIndicador	= 0;
					$sIndicador	= 0;
					for($i=$fdInicial; $i<=$fdFinal; $i++){
						$cIndiceMin = "indIndiceVerde";
						$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$i."'");
						if($row=mysqli_fetch_array($bdInd)){
							$mIndicador += $indOld[$i];
							$sIndicador += $indOld[$i];
							$mMeta		+= $row['indMeta'];
							$mMin		+= $row['indMin'];
							if($indOld[$i] < $row['indMeta']){
								$cIndiceMin = "indIndiceRojo";
								if($indOld[$i] >= $row['indMin']){
									$cIndiceMin = "indIndiceAmarillo";
								}
							}
						}
					}
					$link->close();
					
					$mIndicador = $mIndicador / 3;
					$mMeta 		= $mMeta / 3;
					$mMin 		= $mMin / 3;
								
					$cIndiceMin = "indIndiceVerde";
					if($mIndicador < $mMeta){
						$cIndiceMin = "indIndiceRojo";
						if($mIndicador >= $mMin){
							$cIndiceMin = "indIndiceAmarillo";
						}
					}
					
					// Indice Productividad
					$cProduc = "indIndice";
						
					$tDiasdelMes = date('t');
					$iMinP = round((($indMin / $tDiasMes) * $dCorridos),2); // +++
					$iMetP = round((($indMeta / $tDiasMes) * $dCorridos),2);
					if($tProductividad >= $iMinP)	{ 
						$cProduc = "indIndiceVerde"; 		
						if($tProductividad >= $iMetP)	{ 
							$cProduc = "indIndiceVerde"; 		
						}else{
							$cProduc = "indIndiceAmarillo";
						}
					}else{
						$cProduc = "indIndiceRojo"; 		
					}
								
				?>


								<?php
									$cIndice = "indIndiceVerde";
									if($indVtas >= $iMinP)	{ 
										$cIndice = "indIndiceVerde"; 		
										if($indVtas >= $iMetP)	{ 
											$cIndice = "indIndiceVerde"; 		
										}else{
											$cIndice = "indIndiceAmarillo";
										}
									}else{
										$cIndice = "indIndiceRojo"; 		
									}
								?>
<!--								
							<td class="<?php echo $cIndice; ?>">
								<span style="font-size:12px; ">Indice</span>
								<?php //echo number_format($indVtas, 2, ',', '.');?>
							</td>
-->							
						</tr>
					
					<?php
						$link=Conectarse();
						$result  = $link->query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaHoy."'");
						if($rowGas=mysqli_fetch_array($result)){
							$actSQL="UPDATE tabIndices SET ";
							$actSQL.="iProductividad	 ='".$tProductividad."',";
							$actSQL.="iMinimo			 ='".$indMin."',";
							$actSQL.="iMeta				 ='".$indMeta."',";
							$actSQL.="indVtas			 ='".$indVtas."'";
							$actSQL.="WHERE fechaIndice = '".$fechaHoy."'";
							$bdGas=$link->query($actSQL);
						}else{
							$link->query("insert into tabIndices(	fechaIndice,
																	iProductividad,
																	iMinimo,
																	iMeta,
																	indVtas
																) 
													values 		(	'$fechaHoy',
																	'$tProductividad',
																	'$indMin',
																	'$indMeta',
																	'$indVtas'
																	)");
						}
						$link->close();
					?>


<!-- New -->

<div class="row degradado">
	<div class="col-1">
		<img src="imagenes/simet.png" width="100" height="50">
	</div>
	<div class="col-3">
		<table class="table text-center">
			<tbody>
				<tr>
					<td class="bg-warning text-white border">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<?php
							$AgnoCat  = date('Y');
							$MesCat   = date('m');
							$tCot 	  = 0;
							$tCotAtr  = 0;
							$tClas1	  = 0;
							$totClas1 = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '1'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									if($rowCp['Estado'] == 'T'){
										$tCot++;
										$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

										$fechaInicio = $rowCp['fechaInicio'];
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $fechaInicio;
										$dh	= $rowCp['dHabiles'] - 1;

										$dd	= 0;
										for($j=1; $j<=$dh; $j++){
											$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}
											$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
											$bdDf=$link->query($SQL);
											if($row=mysqli_fetch_array($bdDf)){
												$dh++;
												$dd++;
											}
										}
										$fechaTermino = $ft;
										if($rowCp['fechaTermino'] > '0000-00-00'){
											if($rowCp['fechaTermino'] > $fechaTermino){
												$tCotAtr++;
											}
										}
									}
									$totClas1 = $tCot;
								}
												
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCotAtr > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php
								echo $tCotAtr. '/'. $totClas1;
							?>
						</div>



					</td>
					<td class="bg-warning text-white border">
						<img src="imagenes/Estrella_Azul.png" width="10">
						<img src="imagenes/Estrella_Azul.png" width="10">
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '2'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>

					</td>

					<td class="bg-warning text-white border">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '3'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>
					</td>
					<td class="bg-warning text-white border">
						GENERAL
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$tCot++;
								$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
								$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
								$fechaInicio = $rowCp['fechaInicio'];
								$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
								$ft = $fechaInicio;
								$dh	= $rowCp['dHabiles'] - 1;
								$dd	= 0;
								for($j=1; $j<=$dh; $j++){
									$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
									$ft	= date ( 'Y-m-d' , $ft );
									$dia_semana = date("w",strtotime($ft));
									if($dia_semana == 0 or $dia_semana == 6){
										$dh++;
										$dd++;
									}
									$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
									$bdDf=$link->query($SQL);
									if($row=mysqli_fetch_array($bdDf)){
										$dh++;
										$dd++;
									}
								}
								$fechaTermino = $ft;
								if($rowCp['fechaTermino'] > '0000-00-00'){
									if($rowCp['fechaTermino'] > $fechaTermino){
										$tCotAtr++;
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
							
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>

					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-3">
		<table class="table text-center">
			<tbody>
				<tr>
					<td class="bg-info text-white border">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '1'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>
					</td>
					<td class="bg-info text-white border">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '2'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>
					</td>
					<td class="bg-info text-white border">
						<img src="imagenes/Estrella_Azul.png"" width="10">
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '3'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php echo $tCotAtr.' / '.$tCot; ?>
						</div>
					</td>
					<td class="bg-info text-white border">
						GENERAL
						<?php
							$AgnoCat = date('Y');
							$MesCat  = date('m');
							$tCot 	 = 0;
							$tCotAtr = 0;
							$link=Conectarse();
							$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
							$bdCp=$link->query($SQLt);
							while($rowCp=mysqli_fetch_array($bdCp)){
								$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."'";
								$bdCli=$link->query($SQLCli);
								if($rowCli=mysqli_fetch_array($bdCli)){
									$tCot++;
									$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
									$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
									$fechaInicio = $rowCp['fechaInicio'];
									$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
									$ft = $fechaInicio;
									$dh	= $rowCp['dHabiles'] - 1;
									$dd	= 0;
									for($j=1; $j<=$dh; $j++){
										$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
										$ft	= date ( 'Y-m-d' , $ft );
										$dia_semana = date("w",strtotime($ft));
										if($dia_semana == 0 or $dia_semana == 6){
											$dh++;
											$dd++;
										}
										$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
										$bdDf=$link->query($SQL);
										if($row=mysqli_fetch_array($bdDf)){
											$dh++;
											$dd++;
										}
									}
									$fechaTermino = $ft;
									if($rowCp['fechaTermino'] > '0000-00-00'){
										if($rowCp['fechaTermino'] > $fechaTermino){
											$tCotAtr++;
										}
									}
								}
							}
							$link->close();
						?>
						<div class="textoDiv">
							<?php
								//echo 'Cot '.$tCot.'<br>';

								if($tCot > 0){
									echo number_format(($tCotAtr/$tCot), 2, ',', '.');
								}else{
									echo number_format('0.00', 2, ',', '.');
								}
							?>
						</div> 
						<div class="textoDivDiv">
							<?php
								echo $tCotAtr.' / '.$tCot;
							?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-2">
		<table class="table text-center">
			<tbody>
				<tr>
					<?php
						$pVta3 = $vta3/3;
						$clase = $bgroj;
						$iMinHis3 = $iMinHis3 / 3;
						$iMetaHis3 = $iMetaHis3 / 3;

						if($pVta3 >= $iMinHis3 and $pVta3 < $iMetaHis3) { $clase = $bgama; }
						if($pVta3 >= $iMetaHis3)						{ $clase = $bgver; }
					?>
					<td class="<?php echo $clase; ?>">
						Últ. 3
						<div>
							<?php echo number_format(($vta3)/3, 2, ',', '.'); 
							?>
						</div>
						<div>&nbsp;</div>
					</td>
					<?php
						$pVta6 = $vta6/6;
						$clase = $bgroj;
						$iMinHis6 = $iMinHis6 / 6;
						$iMetaHis6 = $iMetaHis6 / 6;
						if($pVta6 >= $iMinHis6 and $pVta6 < $iMetaHis6) { $clase = $bgama; }
						if($pVta6 >= $iMetaHis6)						{ $clase = $bgver; }
					?>
					<td class="<?php echo $clase; ?>">
						Últ. 6
						<div>
							<?php echo number_format($vta6/6, 2, ',', '.'); 
							?>
						</div>
						<div> </div>
					</td>

						<?php
							$fdInicial	= $fd[1] - 3;
							$fdFinal	= $fd[1] - 1;
							if($fdInicial <= 0){
								$fdInicial  = 12 + $fdInicial;
								$fdFinal	= $fdInicial + 2;
							}
							$link=Conectarse();
							$mIndicador	= 0;
							$mMeta		= 0;
							$mMin		= 0;
							$mIndicador	= 0;
							$sIndicador	= 0;
							for($i=$fdInicial; $i<=$fdFinal; $i++){
								$cIndiceMin = "indIndiceVerde";
								$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$i."'");
								if($row=mysqli_fetch_array($bdInd)){
									$mIndicador += $indOld[$i];
									$sIndicador += $indOld[$i];
									$mMeta		+= $row['indMeta'];
									$mMin		+= $row['indMin'];
									if($indOld[$i] < $row['indMeta']){
										$cIndiceMin = "indIndiceRojo";
										if($indOld[$i] >= $row['indMin']){
											$cIndiceMin = "indIndiceAmarillo";
										}
									}
								}
							}
							$link->close();
							$mIndicador = $mIndicador / 3;
							$mMeta 		= $mMeta / 3;
							$mMin 		= $mMin / 3;
							$cIndiceMin = "indIndiceVerde";
							if($mIndicador < $mMeta){
								$cIndiceMin = "indIndiceRojo";
								if($mIndicador >= $mMin){
									$cIndiceMin = "indIndiceAmarillo";
								}
							}
							// Indice Productividad
							$cProduc = "indIndice";
							$clase = $bgroj;
							$tDiasdelMes = date('t');
							$iMinP = round((($indMin / $tDiasMes) * $dCorridos),2); // +++
							$iMetP = round((($indMeta / $tDiasMes) * $dCorridos),2);
							if($tProductividad >= $iMinP)	{ 
								$cProduc = "indIndiceVerde"; 
								$clase = $bgver;		
								if($tProductividad >= $iMetP)	{ 
									$cProduc = "indIndiceVerde"; 
									$clase = $bgver;		
								}else{
									$cProduc = "indIndiceAmarillo";
									$clase = $bgama;
								}
							}else{
								$cProduc = "indIndiceRojo";
								$clase = $bgroj;  		
							}
						?>


					<td class="<?php echo $bginf; ?>">
						Prod.AF
						<div>									
							<?php 
								$link=Conectarse();
								$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$i."' and agnoInd = '$aIndice'");
								if($row=mysqli_fetch_array($bdInd)){
									//echo number_format($tProdAF/1000000, 2, ',', '.');
									echo number_format($row['ProductividadAF']/1000000, 2, ',', '.');
								}
								$link->close();
							?>
						</div>
						
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-3">
		<table class="table text-center">
			<tbody>
				<tr>
					
					<td class="<?php echo $clase; ?>">
						Producción
						<div><?php echo number_format($tProductividad, 2, ',', '.'); ?></div>
						<div> </div>
					</td>
					<?php 
						$cIndiceMin = "indIndice";
						$clase = $bgroj;
						if($indVtas >= $iMinP)	{ 
							$cIndiceMin = "indIndiceVerde";
							$clase = $bgver;
						}else{
							$cIndiceMin = "indIndiceRojo";
							$clase = $bgroj; 
						}
					?>
					<td class="<?php echo $clase; ?>">
						Mínimo
						<div><?php echo number_format($indMin, 2, ',', '.'); ?></div>
						<div>&nbsp;</div>
					</td>

					<?php 
						$clase = $bgroj;
						if($indVtas >= $iMetP)	{ 
							$clase = $bgver;		
						}else{
							$clase = $bgroj; 		
						}
					?>
					<td class="<?php echo $clase; ?>">
						Meta
						<div><?php echo number_format($indMeta, 2, ',', '.'); ?></div>
						<div></div>
					</td>

					<?php 
						$clase = $bgroj;
						if($indVtas != null){
							if($indVtas > $rowInd['indMin'] and $indVtas < $rowInd['indMeta']){ 
								$clase = $bgama; 
							}
							if($indVtas >= $rowInd['indMeta']){ $clase = $bgver; }
							
							$clase = $bgroj;
							if($indVtas >= $iMinP)	{ 
								$clase = $bgver; 		
								if($indVtas >= $iMetP)	{ 
									$clase = $bgver; 		
								}else{
									$clase = $bgama;
								}
							}else{
								$clase = $bgroj; 		
							}
	
						}
						
						//echo $indMin. ' '. $tDiasMes.' '.$dCorridos.' '.$iMinP.'<br>';		
						//echo $indMeta. ' '. $tDiasMes.' '.$dCorridos.' '.$iMetP.' '.$indVtas;		

					?>
					<td class="<?php echo $clase; ?>">
						Indice
						<div><?php echo number_format($indVtas - $TindDesc, 2, ',', '.'); ?></div>
						<div></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
