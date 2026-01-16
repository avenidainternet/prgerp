<?php
		$link=Conectarse();
		$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order by idItem");
		if($rowMu=mysql_fetch_array($bdMu)){
			do{
				$idItem		= $rowMu['idItem'];
				$idIt 		= 'idItem-'.$idItem;
				$idMu 		= 'idMuestra-'.$idItem;
				$idTa 		= 'Taller-'.$idItem;
				
				$idMuestra 	= $_GET[$idMu];
				$Taller 	= $_GET[$idTa];
				
				if($idMuestra != $rowMu['idMuestra']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="idMuestra	   = '".$idMuestra."' "; // T04
					$actSQL.="WHERE idItem = '".$idItem."'"; // T06
					$bdOt=mysql_query($actSQL);
				}

				$SQL = "SELECT * FROM amEnsayos Order By nEns";
				$bdEns=mysql_query($SQL);
				if($rowEns=mysql_fetch_array($bdEns)){
					do{
						$idEnsayo	= $rowEns['idEnsayo'];

						$sql 		= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$rowEns['Suf']."%'";  // sentencia sql
						$result 	= mysql_query($sql);
						$tEnsayos 	= mysql_num_rows($result); 
						
						$nEns 		= 'nEnsayos-'.$idItem.'-'.$rowEns['Suf'];
						$tpMu 		= 'tpMuestra-'.$idItem.'-'.$rowEns['Suf'];
						$nInd 		= 'Ind-'.$idItem.'-'.$rowEns['Suf'];
						$nTem 		= 'Tem-'.$idItem.'-'.$rowEns['Suf'];
						$vRef 		= 'Ref-'.$idItem.'-'.$rowEns['Suf'];
						
						$cEnsayos 	= $_GET[$nEns];
						$tpMuestra 	= $_GET[$tpMu];
						$Ind 		= $_GET[$nInd];
						$Tem 		= $_GET[$nTem];
						$Ref 		= $_GET[$vRef];
						
						if($Ref == '') { $Ref = 'SR'; }
						
						$Reg = '';
						if($idEnsayo == 'Qu') { $Reg = 'regQuimico'; 	}
						if($idEnsayo == 'Tr') { $Reg = 'regTraccion'; 	}
						if($idEnsayo == 'Du') { $Reg = 'regDoblado'; 	}
						if($idEnsayo == 'Ch') { $Reg = 'regCharpy'; 	}

						$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'");
						if($rowT=mysql_fetch_array($bdT)){
							if($cEnsayos == 0){
								if($rowT['cEnsayos'] > 0){

									$bdOT = mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam Like '%".$rowEns['Suf']."%'");
									$bdOT = mysql_query("Delete From $Reg  Where idItem Like '%".$rowEns['Suf']."%'");

									if($tEnsayos > 0){
										for($i=1; $i<=$tEnsayos; $i++){
											$OtamA = $RAM.'-'.$rowEns['Suf'].$i;
											if($i<10){
												$OtamA = $RAM.'-'.$rowEns['Suf'].'0'.$i;
											} // T01
											$bdOt=mysql_query("Select * From OTAMs Where Otam = '".$OtamA."'");
											if($rowOt=mysql_fetch_array($bdOt)){
												// Existe
											}else{
												for($j=$i; $j<=$tEnsayos; $j++){
													$OtamB = $RAM.'-'.$rowEns['Suf'].$j;
													if($j<10){
														$OtamB = $RAM.'-'.$rowEns['Suf'].'0'.$j;
													} // T06
													$bdOt=mysql_query("Select * From OTAMs Where Otam = '".$OtamB."'");
													if($rowOt=mysql_fetch_array($bdOt)){
														$actSQL="UPDATE OTAMs SET ";
														$actSQL.="Otam		 = '".$OtamA."' "; // T04
														$actSQL.="WHERE Otam = '".$OtamB."'"; // T06
														$bdOt=mysql_query($actSQL);

														$actSQL="UPDATE $Reg SET ";
														$actSQL.="idItem	   = '".$OtamA."' "; // T04
														$actSQL.="WHERE idItem = '".$OtamB."'"; // T06
														$bdOt=mysql_query($actSQL);
														$j = $tEnsayos + 1;
													}
												} // Fin for j
											}
										} // Fin for i
										$bdT =mysql_query("Delete From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'");
									} // Fin if $cEnsayos > 0
								}
							}
							if($cEnsayos > 0){
								$cEnsayosAct =  $rowT['cEnsayos'];
								if($cEnsayos >= $cEnsayosAct or $cEnsayos <= $cEnsayosAct){
									$actSQL="UPDATE amTabEnsayos SET ";
									$actSQL.="tpMuestra		='".$tpMuestra.	"',";
									$actSQL.="cEnsayos		='".$cEnsayos.	"',";
									$actSQL.="Ind			='".$Ind.		"',";
									$actSQL.="Tem			='".$Tem.		"',";
									$actSQL.="Ref			='".$Ref.		"'";
									$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'";
									$bdT=mysql_query($actSQL);
									if($cEnsayos < $cEnsayosAct){
										$nEnsxB = $cEnsayosAct - $cEnsayos;
										if($nEnsxB == 0){
											$nEnsxB = 1;
										}
										for($i=1; $i<=$nEnsxB; $i++){
											$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$rowEns['Suf']."%' Order By Otam Desc");
											if($rowOT=mysql_fetch_array($bdOT)){
												$uOtam = $rowOT['Otam'];
											}

											$bdOT = mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$uOtam."'");
											$bdOT = mysql_query("Delete From $Reg Where idItem = '".$uOtam."'");

										}
										// Reorganizar Ensayos
										
										for($i=1; $i<=$tEnsayos; $i++){
											$OtamA = $RAM.'-'.$rowEns['Suf'].$i;
											if($i<10){
												$OtamA = $RAM.'-'.$rowEns['Suf'].'0'.$i;
											} // T01
											$bdOt=mysql_query("Select * From OTAMs Where Otam = '".$OtamA."'");
											if($rowOt=mysql_fetch_array($bdOt)){
												// Existe
											}else{
												for($j=$i; $j<=$tEnsayos; $j++){
													$OtamB = $RAM.'-'.$rowEns['Suf'].$j;
													if($j<10){
														$OtamB = $RAM.'-'.$rowEns['Suf'].'0'.$j;
													} // T06
													$bdOt=mysql_query("Select * From OTAMs Where Otam = '".$OtamB."'");
													if($rowOt=mysql_fetch_array($bdOt)){

														$actSQL="UPDATE OTAMs SET ";
														$actSQL.="Otam		 = '".$OtamA."' "; // T04
														$actSQL.="WHERE Otam = '".$OtamB."'"; // T06
														$bdOt=mysql_query($actSQL);

														$actSQL="UPDATE $Reg SET ";
														$actSQL.="idItem	   = '".$OtamA."' "; // T04
														$actSQL.="WHERE idItem = '".$OtamB."'"; // T06
														$bdOt=mysql_query($actSQL);

														$j = $tEnsayos + 1;
													}
												} // Fin for j
											}
										} // Fin for i
									}else{
										if($tEnsayos > 0){
											if($cEnsayosAct == 0){
												$cEnsayosAct = $tEnsayos;
												$cEnsayos	 = $cEnsayosAct + $cEnsayos;
											}else{
												$cAct = 0;
												if($tEnsayos > $cEnsayosAct){   
													$cAct		 = $cEnsayosAct; 				// 1
													$rIns		 = $cEnsayos - $cEnsayosAct; 	// 2 - 1 = 1

													$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$rowEns['Suf']."%' Order By Otam Desc");
													if($rowOT=mysql_fetch_array($bdOT)){
														$uOtam = $rowOT['Otam'];
													}
													
													$tOtam = $RAM.'-'.$rowEns['Suf'].$tEnsayos;
													if($tEnsayos<10){
														$tOtam = $RAM.'-'.$rowEns['Suf'].'0'.$tEnsayos;
													}
													$cActFin 	 = $cEnsayosAct + 1; // 3 + 1 = 4
													if($uOtam != $tOtam){
														for($i=$tEnsayos; $i>=$cActFin; $i--){
															$OtamA = $RAM.'-'.$rowEns['Suf'].$i; // T04
															if($i<10){
																$OtamA = $RAM.'-'.$rowEns['Suf'].'0'.$i;
															}
															
															$n = $i + $rIns;
															$OtamB = $RAM.'-'.$rowEns['Suf'].$n; // T07
															if($n<10){
																$OtamB = $RAM.'-'.$rowEns['Suf'].'0'.$n;
															}

															$actSQL="UPDATE OTAMs SET ";
															$actSQL.="Otam		= '".$OtamB."' ";
															$actSQL.="WHERE RAM = '".$RAM."' and Otam = '".$OtamA."'";
															$bdOT=mysql_query($actSQL);

															$actSQL="UPDATE $Reg SET ";
															$actSQL.="idItem	   = '".$OtamB."' "; // T04
															$actSQL.="WHERE idItem = '".$OtamA."'"; // T06
															$bdOt=mysql_query($actSQL);

														}
														$cEnsayos 	 = $cEnsayosAct + $rIns;
													}else{
														$cEnsayosAct = $tEnsayos;
														$cEnsayos 	 = $cEnsayosAct + $rIns;
													}
												}
											}
										}
										$cEnsayosAct++;
										for($i=$cEnsayosAct; $i<=$cEnsayos; $i++){
											$Otams = $RAM.'-'.$rowEns['Suf'].$i;
											if($i<10){
												$Otams = $RAM.'-'.$rowEns['Suf'].'0'.$i;
											}
											
											if($Ind == 0){
												$Ind = 3;
											}

											mysql_query("insert into OTAMs(	
																			RAM,
																			idItem,
																			Otam,
																			idEnsayo,
																			tpMuestra,
																			Ind,
																			Tem
																			) 
																	values 	(	
																			'$RAM',
																			'$idItem',
																			'$Otams',
																			'$idEnsayo',
																			'$tpMuestra',
																			'$Ind',
																			'$Tem'
											)",$link);

											if($idEnsayo == 'Tr' or $idEnsayo == 'Qu'){

												mysql_query("insert into $Reg(
																				idItem,
																				tpMuestra
																				) 
																		values 	(	
																				'$Otams',
																				'$tpMuestra'
												)",$link);

												// Fin Registra Ensayos
											}

											if($idEnsayo == 'Ch'){
												for($i=1; $i<=$Ind; $i++){

													mysql_query("insert into $Reg(
																					idItem,
																					tpMuestra,
																					nImpacto,
																					Tem
																					) 
																			values 	(	
																					'$Otams',
																					'$tpMuestra',
																					'$i',
																					'$Tem'
													)",$link);

												}
												// Fin Registra Ensayos
											} // Fin Charpy

											if($idEnsayo == 'Du'){
												// Registra Ensayos Doblado
												for($i=1; $i<=$Ind; $i++){

													mysql_query("insert into $Reg(
																					idItem,
																					tpMuestra,
																					nIndenta
																					) 
																			values 	(	
																					'$Otams',
																					'$tpMuestra',
																					'$i'
													)",$link);

												}
												// Fin Registra Ensayos
											} // Fin Dureza

										}
									}
								}
							}
						}else{
							$idEnsayo = $rowEns['idEnsayo'];
							if($cEnsayos>0){

								mysql_query("insert into amTabEnsayos(	
																idItem,
																idEnsayo,
																tpMuestra,
																cEnsayos,
																Ind,
																Tem,
																Ref
																) 
														values 	(	
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$cEnsayos',
																'$Ind',
																'$Tem',
																'$Ref'
								)",$link);

								$cEnsayosAct = 0;
								if($tEnsayos > 0){
									$cEnsayosAct = $tEnsayos;
									$cEnsayos	 = $cEnsayosAct + $cEnsayos;
								}

								$cEnsayosAct++;
								for($i=$cEnsayosAct; $i<=$cEnsayos; $i++){
									$Otams = $RAM.'-'.$rowEns['Suf'].$i;
									if($i<10){
										$Otams = $RAM.'-'.$rowEns['Suf'].'0'.$i;
									}

									mysql_query("insert into OTAMs(	
																	RAM,
																	idItem,
																	Otam,
																	idEnsayo,
																	tpMuestra,
																	Ind,
																	Tem
																	) 
															values 	(	
																	'$RAM',
																	'$idItem',
																	'$Otams',
																	'$idEnsayo',
																	'$tpMuestra',
																	'$Ind',
																	'$Tem'
									)",$link);

									if($idEnsayo == 'Tr' or $idEnsayo == 'Qu'){
										mysql_query("insert into $Reg(
																				idItem,
																				tpMuestra
																				) 
																		values 	(	
																				'$Otams',
																				'$tpMuestra'
										)",$link);
											// Fin Registra Ensayos
									}

									if($idEnsayo == 'Ch'){
										for($i=1; $i<=$Ind; $i++){

											mysql_query("insert into $Reg(
																					idItem,
																					tpMuestra,
																					nImpacto,
																					Tem
																					) 
																			values 	(	
																					'$Otams',
																					'$tpMuestra',
																					'$i',
																					'$Tem'
											)",$link);

										}
										// Fin Registra Ensayos
									} // Fin Charpy

									if($idEnsayo == 'Du'){
										for($i=1; $i<=$Ind; $i++){
											mysql_query("insert into $Reg(
																					idItem,
																					tpMuestra,
																					nIndenta
																					) 
																			values 	(	
																					'$Otams',
																					'$tpMuestra',
																					'$i'
											)",$link);
										}
										// Fin Registra Ensayos
									} // Fin Dureza
								}
							}
						}
					}while($rowEns=mysql_fetch_array($bdEns));
				}
			}while($rowMu=mysql_fetch_array($bdMu));
		}
		mysql_close($link);
		$accion = '';		
?>