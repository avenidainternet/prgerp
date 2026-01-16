<?php
	session_start(); 
	include_once("conexion.php");
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	if(isset($_GET[accion])) 	{	$accion 	= $_GET[accion]; 	}
	if(isset($_GET[RAM])) 		{	$RAM 		= $_GET[RAM]; 		}
	if(isset($_GET[CAM])) 		{	$CAM 		= $_GET[CAM]; 		}
	if(isset($_GET[prg])) 		{	$prg 		= $_GET[prg]; 		}
	if(isset($_GET[RuCli])) 	{	$RutCli 	= $_GET[RutCli]; 	}

	if(isset($_GET[idItem])) 	{	$idItem		= $_GET[idItem]; 	}
	if(isset($_GET[idMuestra])) {	$idMuestra	= $_GET[idMuestra]; }
	if(isset($_GET[nTraccion])) {	$nTraccion	= $_GET[nTraccion]; }
	if(isset($_GET[nQuimico]))  {	$nQuimico	= $_GET[nQuimico]; 	}
	if(isset($_GET[nCharpy]))   {	$nCharpy	= $_GET[nCharpy]; 	}
	if(isset($_GET[nDureza]))   {	$nDureza	= $_GET[nDureza]; 	}
	if(isset($_GET[nOtra]))   	{	$nOtra		= $_GET[nOtra]; 	}

	if(isset($_GET[tpMuestraTr]))	{	$tpMuestraTr	= $_GET[tpMuestraTr]; 	}
	if(isset($_GET[tpMuestraQu]))	{	$tpMuestraQu	= $_GET[tpMuestraQu]; 	}
	if(isset($_GET[tpMuestraCh]))	{	$tpMuestraCh	= $_GET[tpMuestraCh]; 	}
	if(isset($_GET[Imp]))			{	$Imp			= $_GET[Imp]; 			}
	if(isset($_GET[Tem]))			{	$Tem			= $_GET[Tem]; 			}
	if(isset($_GET[tpMuestraDu]))	{	$tpMuestraDu	= $_GET[tpMuestraDu]; 	}
	if(isset($_GET[Ind]))			{	$Ind			= $_GET[Ind]; 			}
	if(isset($_GET[RefTr]))			{	$RefTr			= $_GET[RefTr]; 		}
	if(isset($_GET[RefQu]))			{	$RefQu			= $_GET[RefQu]; 		}
	if(isset($_GET[RefCh]))			{	$RefCh			= $_GET[RefCh]; 		}
	if(isset($_GET[RefDu]))			{	$RefDu			= $_GET[RefDu]; 		}
	if(isset($_GET[RefOt]))			{	$RefOt			= $_GET[RefOt]; 		}

	if(isset($_GET[accion])) 		{ $accion 	 		= $_GET[accion]; 		}
	if(isset($_GET[Taller])) 		{ $Taller 			= $_GET[Taller]; 		}
	if(isset($_GET[Obs])) 			{ $Obs 	 			= $_GET[Obs]; 			}
	if(isset($_GET[nMuestras])) 	{ $nMuestras		= $_GET[nMuestras];		}
	if(isset($_GET[fechaInicio]))	{ $fechaInicio 		= $_GET[fechaInicio];	}
	if(isset($_GET[ingResponsable])){ $ingResponsable 	= $_GET[ingResponsable];}
	if(isset($_GET[cooResponsable])){ $cooResponsable 	= $_GET[cooResponsable];}

	if(isset($_POST[RAM])) 		{	$RAM 		= $_POST[RAM]; 		}
	
	if(isset($_POST[guardarIdMuestra22])){
		$link=Conectarse();
		$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order by idItem");
		if($rowMu=mysql_fetch_array($bdMu)){
			do{
				// idItem = 1000-01 - 1000-02 - 1000-03 - 1000-04 - 1000-05
				// Asignamos Variables
				$idItem		= $rowMu['idItem'];
				$idIt 		= 'idItem-'.$idItem;
				$idMu 		= 'idMuestra-'.$idItem;
				$idTa 		= 'Taller-'.$idItem;
				$conEns		= 'conEnsayo-'.$idItem;
				
				// Recogemos Variables del Formulario
				$idMuestra 	= $_POST[$idMu];
				$Taller 	= $_POST[$idTa];
				$conEnsayo 	= $_POST[$conEns];

				// Consultar si ha cambiado algún valor de idMuestra = Uno, Taller = off, conEnsayo = on, Ref = 
				if($idMuestra != $rowMu['idMuestra']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="idMuestra	   = '".$idMuestra.	"' ";
					$actSQL.="WHERE idItem = '".$idItem.	"'";
					$bdOt=mysql_query($actSQL);
				}
				if($conEnsayo != $rowMu['conEnsayo']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="conEnsayo	   = '".$conEnsayo.	"' ";
					$actSQL.="WHERE idItem = '%".$idItem."%'";
					$bdOt=mysql_query($actSQL);
				}
				if($Taller != $rowMu['Taller']){

					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="Taller	   = '".$Taller.	"' ";
					$actSQL.="WHERE idItem = '".$idItem."'";
					$bdOt=mysql_query($actSQL);
					
					// Si Taller = on 
					// Consultar si tiene asignado NUMERO DE TALLER
					if($Taller == 'on'){
						$bdRAM=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
						if($rowRAM=mysql_fetch_array($bdRAM)){
							if($rowRAM['nSolTaller'] == 0){
								$bdNform=mysql_query("Select * From tablaRegForm");
								if($rowNform=mysql_fetch_array($bdNform)){
									$nSolTaller = $rowNform[nTaller] + 1;
									
									$actSQL="UPDATE tablaRegForm SET ";
									$actSQL.="nTaller		='".$nSolTaller."'";
									$bdNform=mysql_query($actSQL);
									
									$actSQL="UPDATE formRAM SET ";
									$actSQL.="Taller		='".$Taller.   "', ";
									$actSQL.="nSolTaller	='".$nSolTaller."'";
									$actSQL.="WHERE RAM 	= '".$RAM."'";
									$bdRAM=mysql_query($actSQL);
								
								} // Fin if
							} // Fin If nSolTaller = 
						}  // Fin Buscar en formRAM
					} // Fin Taller = on
				} // $Taller != $rowMu['Taller']
				// Loop Tipos de Ensayos Qu - Tr - Du - Ch
				
				$bdEns=mysql_query("SELECT * FROM amEnsayos Order By nEns");
				if($rowEns=mysql_fetch_array($bdEns)){
					do{
						$idEnsayo	= $rowEns['idEnsayo'];

						$nEns 		= 'nEnsayos-'.$idItem.'-'.$rowEns['Suf'];
						$tpMu 		= 'tpMuestra-'.$idItem.'-'.$rowEns['Suf'];
						$nInd 		= 'Ind-'.$idItem.'-'.$rowEns['Suf'];
						$nTem 		= 'Tem-'.$idItem.'-'.$rowEns['Suf'];
						$vRef 		= 'Ref-'.$idItem.'-'.$rowEns['Suf'];
						
						$Ind 		= 0;
						$cEnsayos	= 0;
						$tpMuestra	= '';
						$Ind		= 0;
						$Tem		= 0;
						$Ref		= 'SR';
						
						if(isset($_POST[$nEns])) 		{ $cEnsayos 	= $_POST[$nEns]; } // cEnsayos = 1
						if(isset($_POST[$tpMu])) 		{ $tpMuestra 	= $_POST[$tpMu]; }
						if(isset($_POST[$nInd])) 		{ $Ind			= $_POST[$nInd]; }
						if(isset($_POST[$nTem])) 		{ $Tem 			= $_POST[$nTem]; }
						if(isset($_POST[$vRef])) 		{ $Ref			= $_POST[$vRef]; }

						// Si La muestra esta en Blanco Busca el 1er Tipo de Muestra
						if($tpMuestra == ''){
							$bdTm=mysql_query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'");
							if($rowTm=mysql_fetch_array($bdTm)){
								$tpMuestra = $rowTm['tpMuestra'];
							}
						}
						
						if($idEnsayo == 'Qu') { $Reg = 'regQuimico'; 	}
						if($idEnsayo == 'Tr') { $Reg = 'regTraccion'; 	}
						if($idEnsayo == 'Du') { $Reg = 'regDoblado'; 	}
						if($idEnsayo == 'Ch') { $Reg = 'regCharpy'; 	}
						
						$actRegistro = 'No';
						$ActcEnsayos = 'No';
						$regNuevo 	 = 'No';
						$ensPrevios  = 0;

						// Actualizar Tabla de Ensayos
						$bdTe=mysql_query("SELECT * FROM amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = '".$idEnsayo."'");
						if($rowTe=mysql_fetch_array($bdTe)){
							$ensPrevios = $rowTe['cEnsayos'];
							
							if($rowTe['cEnsayos'] != $cEnsayos){
								$ActcEnsayos = 'No';
								$actRegistro = 'Si';
							}
							if($rowTe['tpMuestra'] != $tpMuestra){
								$actRegistro = 'Si';
							}
							if($rowTe['Ind'] != $Ind){
								$actRegistro = 'Si';
							}
							if($rowTe['Tem'] != $Tem){
								$actRegistro = 'Si';
							}
							if($rowTe['Ref'] != $Ref){
								$actRegistro = 'Si';
							}
							if($Ref == ''){
								$Ref = 'SR';
								$actRegistro = 'Si';
							}
								//$actSQL.="cEnsayos		='".$cEnsayos.	"', ";
							if($actRegistro == 'Si'){
								$actSQL="UPDATE amTabEnsayos SET ";
								$actSQL.="tpMuestra		='".$tpMuestra.	"', ";
								$actSQL.="Ind			='".$Ind.		"', ";
								//$actSQL.="cEnsayos		='".$cEnsayos.	"', ";
								$actSQL.="Tem			='".$Tem.		"', ";
								$actSQL.="Ref			='".$Ref.		"'";
								$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = '".$idEnsayo."'";
								$bdTe=mysql_query($actSQL);
							}

							// Cuenta el Total de Ensayos existentes
							$tEnsayos = 0;
							$sql 		= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$rowEns['Suf']."%'";  // sentencia sql
							$result 	= mysql_query($sql);
							$tEnsayos 	= mysql_num_rows($result);
							
							if($ensPrevios == $tEnsayos){ 
								if($cEnsayos > $tEnsayos){ 
									// Agregar Ensayos
									$nAgregar = $cEnsayos - $tEnsayos;
									$inicio = $tEnsayos + 1;
									for($i=$inicio; $i<=$cEnsayos; $i++){
										$OtamIns = $RAM.'-'.$rowEns['Suf'].$i;
										if($i<10){
											$OtamIns = $RAM.'-'.$rowEns['Suf'].'0'.$i;
										}
										$fechaCreaRegistro = date('Y-m-d');

										?>
											<script>
												alert('<?php echo $OtamIns; ?>');
											</script>
										<?php


/*
										mysql_query("insert into OTAMs(	
																		RAM,
																		idItem,
																		Otam,
																		idEnsayo,
																		tpMuestra,
																		Ind,
																		Tem,
																		fechaCreaRegistro
																		) 
																values 	(	
																		'$RAM',
																		'$idItem',
																		'$OtamIns',
																		'$idEnsayo',
																		'$tpMuestra',
																		'$Ind',
																		'$Tem',
																		'$fechaCreaRegistro'
											)",$link);
*/											
										} // Fin For
								}else{
									$nBorrar = $tEnsayos - $cEnsayos;

									$inicio = ($tEnsayos - $nBorrar) + 1;
									for($i=$inicio; $i<=$tEnsayos; $i++){
										$OtamBor = $RAM.'-'.$rowEns['Suf'].$i;
										if($i<10){
											$OtamBor = $RAM.'-'.$rowEns['Suf'].'0'.$i;
										}
										//$bdOT = mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$OtamBor."'");
									}
								}
							}else{
								if($cEnsayos > $ensPrevios){
									// Hacer Espacio(s) para 
									// Insertar Ensayos

									$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$rowEns['Suf']."%' Order By Otam Desc");
									if($rowOT=mysql_fetch_array($bdOT)){
										$sOtam = $rowOT['Otam'];
									}
									$sOtam++;
									
									$fOtam = $tEnsayos + ($cEnsayos - $ensPrevios);
									$OtamF = $RAM.'-'.$rowEns['Suf'].$fOtam;
									if($fOtam<10){
										$OtamF = $RAM.'-'.$rowEns['Suf'].'0'.$fOtam;
									}

									$aOtam = $tEnsayos;
									$OtamA = $RAM.'-'.$rowEns['Suf'].$aOtam;
									if($aOtam<10){
										$OtamA = $RAM.'-'.$rowEns['Suf'].'0'.$aOtam;
									}
									
									$Sw = false;
									while($Sw == false){
										if($sOtam == $OtamA){
											$Sw = true;
										}
/*										
										$actSQL="UPDATE OTAMs SET ";
										$actSQL.="Otam		 = '".$OtamF."' "; // T06 - T05
										$actSQL.="WHERE Otam = '".$OtamA."'";  // T04 - T03
										$bdOt=mysql_query($actSQL);
*/										
										?>
											<script>
												alert('<?php echo $sOtam." ".$OtamA." ".$OtamF ?>');
											</script>
										<?php
										
										$fOtam--;
										$OtamF = $RAM.'-'.$rowEns['Suf'].$fOtam;
										if($fOtam<10){
											$OtamF = $RAM.'-'.$rowEns['Suf'].'0'.$fOtam;
										}

										$aOtam--;
										$OtamA = $RAM.'-'.$rowEns['Suf'].$aOtam;
										if($aOtam<10){
											$OtamA = $RAM.'-'.$rowEns['Suf'].'0'.$aOtam;
										}
										
										
									}
								}else{
									if($cEnsayos < $ensPrevios){
										// Borrar Ensayos
										?>
											<script>
												alert('<?php echo "Borrar Otams" ?>');
											</script>
										<?php
									}
								}
							}
							
						}else{
							if($cEnsayos > 0){
								$ActcEnsayos = 'Si';
								$regNuevo 	 = 'Si';
								if($Ref == ''){
									$Ref = 'SR';
								}
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

								$tEnsayos = 0;
								$sql 		= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$rowEns['Suf']."%'";  // sentencia sql
								$result 	= mysql_query($sql);
								$tEnsayos 	= mysql_num_rows($result); 
								// 0
								$ensIni   	= $tEnsayos + 1;
												// 0 + 2 = 2
								if($tEnsayos == 0){
									$ensFin	  = $cEnsayos;
									// 2
								}else{
									$ensFin	  = $tEnsayos + $cEnsayos;
								}
								for($i=$ensIni; $i<=$ensFin; $i++){
									$Otams = $RAM.'-'.$rowEns['Suf'].$i;
									if($i<10){
										$Otams = $RAM.'-'.$rowEns['Suf'].'0'.$i;
									}
									$fechaCreaRegistro = date('Y-m-d');

									mysql_query("insert into OTAMs(	
																		RAM,
																		idItem,
																		Otam,
																		idEnsayo,
																		tpMuestra,
																		Ind,
																		Tem,
																		fechaCreaRegistro
																		) 
																values 	(	
																		'$RAM',
																		'$idItem',
																		'$Otams',
																		'$idEnsayo',
																		'$tpMuestra',
																		'$Ind',
																		'$Tem',
																		'$fechaCreaRegistro'
									)",$link);
								} // Fin For

							}
						}
					}while($rowEns=mysql_fetch_array($bdEns));
				} // Fin amEnsayos
			}while($rowMu=mysql_fetch_array($bdMu));
			
			// Consulta si una Muestra tiene almenos una Muestra en taller
			$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and Taller = 'on' Order by idItem");
			if($rowMu=mysql_fetch_array($bdMu)){
			}else{
				// Si no hay ninguna muestra con taller poner en Off y Numero de Solicitud en Cero
				$Taller 	= 'off';
				$nSolTaller	= 0;
/*
				$actSQL="UPDATE formRAM SET ";
				$actSQL.="Taller		='".$Taller.   "', ";
				$actSQL.="nSolTaller	='".$nSolTaller."'";
				$actSQL.="WHERE RAM 	= '".$RAM."'";
				$bdRAM=mysql_query($actSQL);
*/
			} // Fin Consulta bdMu
		}
	}
	
	if(isset($_POST[guardarIdMuestra2])){
		$link=Conectarse();
		$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order by idItem");
		if($rowMu=mysql_fetch_array($bdMu)){
			do{
				$idItem		= $rowMu['idItem'];
				$idIt 		= 'idItem-'.$idItem;
				$idMu 		= 'idMuestra-'.$idItem;
				$idTa 		= 'Taller-'.$idItem;
				$conEns		= 'conEnsayo-'.$idItem;
				$idMuestra 	= $_POST[$idMu];
				$Taller 	= $_POST[$idTa];
				$conEnsayo 	= $_POST[$conEns];
				
				if($idMuestra != $rowMu['idMuestra']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="idMuestra	   = '".$idMuestra.	"' ";
					$actSQL.="WHERE idItem = '".$idItem."'";
					$bdOt=mysql_query($actSQL);
				}
				
				// Taller = off != off
				// Si Taller es Distinto 
				// La primera ves Entra
				if($Taller != $rowMu['Taller']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="Taller	   = '".$Taller.	"' ";
					$actSQL.="WHERE idItem = '".$idItem."'";
					$bdOt=mysql_query($actSQL);

					if($Taller == 'on'){
						$bdRAM=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
						if($rowRAM=mysql_fetch_array($bdRAM)){
							if($rowRAM['nSolTaller'] == 0){
								$bdNform=mysql_query("Select * From tablaRegForm");
								if($rowNform=mysql_fetch_array($bdNform)){
									$nSolTaller = $rowNform[nTaller] + 1;
									
									$actSQL="UPDATE tablaRegForm SET ";
									$actSQL.="nTaller		='".$nSolTaller."'";
									$bdNform=mysql_query($actSQL);
									
									$actSQL="UPDATE formRAM SET ";
									$actSQL.="Taller		='".$Taller.   "', ";
									$actSQL.="nSolTaller	='".$nSolTaller."'";
									$actSQL.="WHERE RAM 	= '".$RAM."'";
									$bdRAM=mysql_query($actSQL);
								} // Fin if
							} // Fin If nSolTaller = 
						}  // Fin Buscar en formRAM
					} // fin Taller = on
				} // Fin Taller Distinto
				
				if($conEnsayo != $rowMu['conEnsayo']){
					$actSQL="UPDATE amMuestras SET ";
					$actSQL.="conEnsayo	   = '".$conEnsayo.	"' ";
					$actSQL.="WHERE idItem = '".$idItem."'";
					$bdOt=mysql_query($actSQL);
				}

				$SQL = "SELECT * FROM amEnsayos Order By nEns";
				$bdEns=mysql_query($SQL);
				if($rowEns=mysql_fetch_array($bdEns)){
					do{
						// idEnsayo = Qu - Tr - Du - Ch
						$idEnsayo	= $rowEns['idEnsayo'];

						$nEns 		= 'nEnsayos-'.$idItem.'-'.$rowEns['Suf'];
						$tpMu 		= 'tpMuestra-'.$idItem.'-'.$rowEns['Suf'];
						$nInd 		= 'Ind-'.$idItem.'-'.$rowEns['Suf'];
						$nTem 		= 'Tem-'.$idItem.'-'.$rowEns['Suf'];
						$vRef 		= 'Ref-'.$idItem.'-'.$rowEns['Suf'];
						
						$Ind 		= 0;
						
						$cEnsayos 	= $_POST[$nEns]; // cEnsayos = 1
						$tpMuestra 	= $_POST[$tpMu];
						$Ind 		= $_POST[$nInd];
						$Tem 		= $_POST[$nTem];
						$Ref 		= $_POST[$vRef];

						$Registra  	= 'No';
						$regNew		= 'Si';
						$cEnsayosReg = 0;

						$Reg = '';
						if($idEnsayo == 'Qu') { $Reg = 'regQuimico'; 	}
						if($idEnsayo == 'Tr') { $Reg = 'regTraccion'; 	}
						if($idEnsayo == 'Du') { $Reg = 'regDoblado'; 	}
						if($idEnsayo == 'Ch') { $Reg = 'regCharpy'; 	}
						
						// idItem = 1000-01 - idEnsayo = Tr
						$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'");
						if($rowT=mysql_fetch_array($bdT)){
							$cEnsayosReg = $rowT['cEnsayos']; // cEnsayosReg = 0
							$regNew		 = 'No';
							if($Ref != $rowT['Ref']){
								$actSQL="UPDATE amTabEnsayos SET ";
								$actSQL.="Ref		 	= '".$Ref."' ";
								$actSQL.="Where idItem 	= '".$idItem."' and idEnsayo = '".$rowEns['idEnsayo']."'";
								$bdT=mysql_query($actSQL);
							}
						}
						if($cEnsayos != $cEnsayosReg){
							$Registra = 'Si';
						}
						
						// Registra = Si Registrado, regNew = Si
						if($Registra == 'Si' and $regNew == 'No'){
							$sql 		= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$rowEns['Suf']."%'";  // sentencia sql
							$result 	= mysql_query($sql);
							$tEnsayos 	= mysql_num_rows($result); 
							// tEnsayos = 0
							// cEnsayos = 1
							
							if($Ref == '') { $Ref = 'SR'; }
								
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
									$cEnsayosAct = 0;
									$cEnsayosAct =  $rowT['cEnsayos'];
									// cEnsayos 	= 1
									// cEnsayosAct 	= 1
									
									if($cEnsayos >= $cEnsayosAct or $cEnsayos <= $cEnsayosAct){
									    // 1 >= 0   or 1 <= 0
										//  Si            No
										//        Si         

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
												
												$fechaCreaRegistro = date('Y-m-d');
												
												mysql_query("insert into OTAMs(	
																				RAM,
																				idItem,
																				Otam,
																				idEnsayo,
																				tpMuestra,
																				Ind,
																				Tem,
																				fechaCreaRegistro
																				) 
																		values 	(	
																				'$RAM',
																				'$idItem',
																				'$Otams',
																				'$idEnsayo',
																				'$tpMuestra',
																				'$Ind',
																				'$Tem',
																				'$fechaCreaRegistro'
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
													if($Ind == 0){
														$Ind = 3;
													}
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
													if($Ind == 0){
														$Ind = 3;
													}
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
								if($Registra == 'No'){
									
									$sql 		= "SELECT * FROM OTAMs Where RAM = '".$RAM."' and Otam Like '%".$rowEns['Suf']."%'";  // sentencia sql
									$result 	= mysql_query($sql);
									$tEnsayo 	= mysql_num_rows($result); 
									
									for($i=1; $i<=$tEnsayos; $i++){
										$Otams = $RAM.'-'.$rowEns['Suf'].$i;
										if($i<10){
											$Otams = $RAM.'-'.$rowEns['Suf'].'0'.$i;
										}
										$bdOt=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otams."'");
										if($rowOt=mysql_fetch_array($bdOt)){
											if($Ind != $rowOt['Ind']){
												$actSQL="UPDATE OTAMs SET ";
												$actSQL.="Ind			= '".$Ind."', ";
												$actSQL.="Tem			= '".$Tem."'  ";
												$actSQL.="WHERE idItem 	= '".$idItem."' and Otam = '".$Otams."'";
												$bdOT=mysql_query($actSQL);
											}
										}else{
										}
									} // Fin For
								} // Fin Registra = No Registrado
								if($Registra == 'Si'){
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
											
											$fechaCreaRegistro = date('Y-m-d');
											
											mysql_query("insert into OTAMs(	
																		RAM,
																		idItem,
																		Otam,
																		idEnsayo,
																		tpMuestra,
																		Ind,
																		Tem,
																		fechaCreaRegistro
																		) 
																values 	(	
																		'$RAM',
																		'$idItem',
																		'$Otams',
																		'$idEnsayo',
																		'$tpMuestra',
																		'$Ind',
																		'$Tem',
																		'$fechaCreaRegistro'
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
												if($Ind == 0){
													$Ind = 3;
											}
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
											if($Ind == 0){
												$Ind = 3;
											}
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
					}while($rowEns=mysql_fetch_array($bdEns));
				}
			}while($rowMu=mysql_fetch_array($bdMu));
			
			$bdMu=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' and Taller = 'on' Order by idItem");
			if($rowMu=mysql_fetch_array($bdMu)){

			}else{
			
				$Taller 	= 'off';
				$nSolTaller	= 0;
				
				$actSQL="UPDATE formRAM SET ";
				$actSQL.="Taller		='".$Taller.   "', ";
				$actSQL.="nSolTaller	='".$nSolTaller."'";
				$actSQL.="WHERE RAM 	= '".$RAM."'";
				$bdRAM=mysql_query($actSQL);
			}
		}
		mysql_close($link);
		$accion = '';		
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Administración de RAMs</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(CAM, RAM, dBuscar, accion){
		var parametros = {
			"CAM" 			: CAM,
			"RAM" 			: RAM,
			"dBuscar" 		: dBuscar,
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'muestraMuestras.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function registraEnsayos(RAM, idItem, accion){
		var parametros = {
			"RAM"			: RAM,
			"idItem"		: idItem,
			"accion"		: accion,
		};
		//alert(idItem);
		$.ajax({
			data: parametros,
			url: 'idMuestraEnsayos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/Tablas.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Identificación de Muestras
						<span style="font-size:18px; font-weight:700;">
							<?php
							$link=Conectarse();
							$bdNS=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
							if($rowNS=mysql_fetch_array($bdNS)){
								$nSolTaller = $rowNS[nSolTaller];
							}
							mysql_close($link);
						 	echo 'RAM: '.$RAM;
							if($nSolTaller > 0){
								echo ' - N° Sol. Taller: '.$nSolTaller;
							}
							?>
						</span>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
			</div>
			<?php 
				include_once('editarMuestras.php');
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
