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
	$tEns = 0;
	if(isset($_GET['accion'])) 	{	$accion 	= $_GET['accion']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 		= $_GET['RAM']; 	}
	if(isset($_GET['CAM'])) 	{	$CAM 		= $_GET['CAM']; 	}
	if(isset($_GET['prg'])) 	{	$prg 		= $_GET['prg']; 	}
	if(isset($_GET['RuCli'])) 	{	$RutCli 	= $_GET['RutCli']; 	}

	if(isset($_GET['idItem'])) 		{	$idItem		= $_GET['idItem']; 		}
	if(isset($_GET['idMuestra'])) 	{	$idMuestra	= $_GET['idMuestra']; 	}
	if(isset($_GET['nTraccion'])) 	{	$nTraccion	= $_GET['nTraccion']; 	}
	if(isset($_GET['nQuimico']))  	{	$nQuimico	= $_GET['nQuimico']; 	}
	if(isset($_GET['nCharpy']))   	{	$nCharpy	= $_GET['nCharpy']; 	}
	if(isset($_GET['nDureza']))   	{	$nDureza	= $_GET['nDureza']; 	}
	if(isset($_GET['nOtra']))   	{	$nOtra		= $_GET['nOtra']; 		}

	if(isset($_GET['tpMuestraTr']))	{	$tpMuestraTr	= $_GET['tpMuestraTr']; }
	if(isset($_GET['tpMuestraQu']))	{	$tpMuestraQu	= $_GET['tpMuestraQu']; }
	if(isset($_GET['tpMuestraCh']))	{	$tpMuestraCh	= $_GET['tpMuestraCh']; }
	if(isset($_GET['Imp']))			{	$Imp			= $_GET['Imp']; 		}
	if(isset($_GET['Tem']))			{	$Tem			= $_GET['Tem']; 		}
	if(isset($_GET['tpMuestraDu']))	{	$tpMuestraDu	= $_GET['tpMuestraDu']; }
	if(isset($_GET['Ind']))			{	$Ind			= $_GET['Ind']; 		}
	if(isset($_GET['RefTr']))		{	$RefTr			= $_GET['RefTr']; 		}
	if(isset($_GET['RefQu']))		{	$RefQu			= $_GET['RefQu']; 		}
	if(isset($_GET['RefCh']))		{	$RefCh			= $_GET['RefCh']; 		}
	if(isset($_GET['RefDu']))		{	$RefDu			= $_GET['RefDu']; 		}
	if(isset($_GET['RefOt']))		{	$RefOt			= $_GET['RefOt']; 		}

	if(isset($_GET['accion'])) 			{ $accion 	 		= $_GET['accion']; 			}
	if(isset($_GET['Taller'])) 			{ $Taller 			= $_GET['Taller']; 			}
	if(isset($_GET['Obs'])) 			{ $Obs 	 			= $_GET['Obs']; 			}
	if(isset($_GET['nMuestras'])) 		{ $nMuestras		= $_GET['nMuestras'];		}
	if(isset($_GET['fechaInicio']))		{ $fechaInicio 		= $_GET['fechaInicio'];		}
	if(isset($_GET['ingResponsable']))	{ $ingResponsable 	= $_GET['ingResponsable'];	}
	if(isset($_GET['cooResponsable']))	{ $cooResponsable 	= $_GET['cooResponsable'];	}

	if(isset($_GET['guardarIdMuestra'])){	
		$link=Conectarse();
		$bdMu=mysql_query("Select * From amMuestras Where idItem = '".$idItem."'");
		if($rowMu=mysql_fetch_array($bdMu)){
			$bdCot=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
			if($rowCot=mysql_fetch_array($bdCot)){
				$nSolTaller = $rowCot['nSolTaller'];
			}
			if($RefTr) {
			
				$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Tr'");
				if($rowT=mysql_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefTr."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Tr'";
					$bdT=mysql_query($actSQL);
				}else{
					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra,
													Ref
													) 
											values 	(	
													'$idItem',
													'Tr',
													'$tpMuestraTr',
													'$RefTr'
					)",$link);
				}
				
			}
			if($RefQu) {

				$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Qu'");
				if($rowT=mysql_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefQu."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Qu'";
					$bdT=mysql_query($actSQL);
				}else{
					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra,
													Ref
													) 
											values 	(	
													'$idItem',
													'Qu',
													'$tpMuestraQu',
													'$RefQu'
					)",$link);
				}

			}
			if($RefCh) {
			
				$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Ch'");
				if($rowT=mysql_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefCh."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Ch'";
					$bdT=mysql_query($actSQL);
				}else{
					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra,
													Ref
													) 
											values 	(	
													'$idItem',
													'Ch',
													'$tpMuestraCh',
													'$RefCh'
					)",$link);
				}
				
			}
			if($RefDu) {
			
				$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Du'");
				if($rowT=mysql_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefDu."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Du'";
					$bdT=mysql_query($actSQL);
				}else{
					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra,
													Ref
													) 
											values 	(	
													'$idItem',
													'Du',
													'$tpMuestraDu',
													'$RefDu'
					)",$link);
				}
				
			}
			if($nOtra) {
			
				$bdT=mysql_query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Ot'");
				if($rowT=mysql_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefOt."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Ot'";
					$bdT=mysql_query($actSQL);
				}else{
					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra,
													Ref
													) 
											values 	(	
													'$idItem',
													'Ot',
													'$tpMuestraOt',
													'$RefOt'
					)",$link);
				}
				
			}
			
			if($Taller == 'on'){
				if($nSolTaller == 0){
					$bdNform=mysql_query("Select * From tablaRegForm");
					if($rowNform=mysql_fetch_array($bdNform)){
						$nSolTaller = $rowNform['nTaller'] + 1;
						$actSQL="UPDATE tablaRegForm SET ";
						$actSQL.="nTaller		='".$nSolTaller."'";
						$bdNform=mysql_query($actSQL);
						
						$actSQL="UPDATE formRAM SET ";
						$actSQL.="nSolTaller	='".$nSolTaller."'";
						$actSQL.="WHERE RAM = '".$RAM."'";
						$bdfRAM=mysql_query($actSQL);
						
					}
				}
			}


			$actSQL="UPDATE amMuestras SET ";
			$actSQL.="Taller		='".$Taller.	"',";
			$actSQL.="idMuestra		='".$idMuestra.	"'";
			$actSQL.="WHERE idItem = '".$idItem."'";
			$bdMu=mysql_query($actSQL);
		}
		
		// Registrar Tracciones
		if($nTraccion > 0){
			$Reg = 'regTraccion';
			$OtamsT 	= $RAM.'-T';
			$idEnsayo	= 'Tr';
			$tTraccion = 0;

			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysql_num_rows($result); 
			// $tTraccion++;
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysql_num_rows($result); 
			$swBorrar = false;
			/********** Si tTraccion = 0 no hay Ning煤n Ensayo de Tracci贸n Crearlo(s)  *******/

			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.'-T'.$i;
					if($i<10) { $Otam = $RAM.'-T0'.$i; }
					mysql_query("insert into OTAMs(	
													CAM,
													RAM,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$idItem',
													'$idEnsayo',
													'$tpMuestraTr',
													'$Otam'
					)",$link);

					mysql_query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra
													) 
											values 	(	
													'$idItem',
													'$idEnsayo',
													'$tpMuestraTr'
					)",$link);

					mysql_query("insert into $Reg(
														idItem,
														tpMuestra
														) 
												values 	(	
														'$Otam',
														'$tpMuestraTr'
					)",$link);
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracci髇  *******/
			if($tTraccion > 0){
				$Reg = 'regTraccion';
				
				/********** Si tTracItem = 0 NO hay Ensayo de Tracci髇 para un Items *******/
				if($tTracItem == 0){
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.'-T'.$i;
						if($i<10) { $Otam = $RAM.'-T0'.$i; }
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$tpMuestraTr',
														'$Otam'
						)",$link);
							
						mysql_query("insert into $Reg(
															idItem,
															tpMuestra
															) 
													values 	(	
															'$Otam',
															'$tpMuestraTr'
						)",$link);
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.'-T';
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestraTr. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=mysql_query($actSQL);
	
						$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysql_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestraTr. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=mysql_query($actSQL);
							}while($rowOT=mysql_fetch_array($bdOT));
						}
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.'-T';
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* 趌tima Otam de Tracci髇 ingresada */
							$ultOtam = $RAM.'-T'.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.'-T0'.$tTraccion;}

							/* Otam de Tracci髇 a Asignar */
							$nOtam = $tTraccion + $tIns;
							$newOtam = $RAM.'-T'.$nOtam;
							if($nOtam<10) { $newOtam = $RAM.'-T0'.$nOtam;}

							for($i=$nOtam; $i>($uTra+$tIns); $i--){
								$OtamAnt = $RAM.'-T'.($i-$tIns); 	// 6
								if(($i-$tIns)<10) { $OtamAnt = $RAM.'-T0'.($i-$tIns); }
								
								$OtamAct = $RAM.'-T'.$i;			// 8
								if($i<10) { $OtamAct = $RAM.'-T0'.$i; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
							}
							$uTra++;
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.'-T'.$i;			// 8
								if($i<10) { $OtamNew = $RAM.'-T0'.$i; }

								mysql_query("insert into OTAMs(	
																CAM,
																RAM,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$idItem',
																'$idEnsayo',
																'$tpMuestraTr',
																'$OtamNew'
								)",$link);
								
								mysql_query("insert into $Reg(
																	idItem,
																	tpMuestra
																	) 
															values 	(	
																	'$OtamNew',
																	'$tpMuestraTr'
								)",$link);
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.'-T';
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =mysql_query("Delete From $Reg Where idItem = '".$Otam."'");
								}
							}
							for($i=$fTra+1; $i<=$tTraccion; $i++){
								$iTra++;
								$Otam = $RAM.'-T'.$i;
								if($i<10) { $Otam = $RAM.'-T0'.$i; }

								$OtamAct = $RAM.'-T'.$iTra;
								if($iTra<10) { $OtamAct = $RAM.'-T0'.$iTra; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$Otam."'";
								$bdOT=mysql_query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=mysql_query($actSQL);

							}

						}
					}
				}
			}
			
			/********** Si tTraccion = tTracItem   *******/
			
		}else{
				$Reg = 'regTraccion';
		
				$OtamsT 	= $RAM.'-T';
				$idEnsayo	= 'Tr';
					
				$tTraccion = 0;
				$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
				$result 	= mysql_query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysql_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =mysql_query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		
		// FIN Registrar Tracciones

		// Registrar Qu韒icos
		if($nQuimico > 0){
			$lEnsayo	= '-Q';
			$Reg 		= 'regQuimico';
			$OtamsT 	= $RAM.$lEnsayo;
			$idEnsayo	= 'Qu';
			$tpMuestra 	= $tpMuestraQu;
			$nTraccion 	= $nQuimico;
			
			$tTraccion = 0;
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysql_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysql_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ning鷑 Ensayo de Tracci髇 Crearlo(s)  *******/
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					mysql_query("insert into OTAMs(	
													CAM,
													RAM,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam'
					)",$link);
						
					mysql_query("insert into $Reg(
														idItem,
														tpMuestra
														) 
												values 	(	
														'$Otam',
														'$tpMuestra'
					)",$link);
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracci髇  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracci髇 para un Items *******/
				if($tTracItem == 0){
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam'
						)",$link);
							
						mysql_query("insert into $Reg(
															idItem,
															tpMuestra
															) 
													values 	(	
															'$Otam',
															'$tpMuestra'
						)",$link);
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=mysql_query($actSQL);
	
						$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysql_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=mysql_query($actSQL);
							}while($rowOT=mysql_fetch_array($bdOT));
						}
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* 趌tima Otam de Tracci髇 ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracci髇 a Asignar */
							$nOtam = $tTraccion + $tIns;
							$newOtam = $RAM.$lEnsayo.$nOtam;
							if($nOtam<10) { $newOtam = $RAM.$lEnsayo.'0'.$nOtam;}

							for($i=$nOtam; $i>($uTra+$tIns); $i--){
								$OtamAnt = $RAM.$lEnsayo.($i-$tIns); 	// 6
								if(($i-$tIns)<10) { $OtamAnt = $RAM.$lEnsayo.'0'.($i-$tIns); }
								
								$OtamAct = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamAct = $RAM.$lEnsayo.'0'.$i; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
							}
							$uTra++;
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								mysql_query("insert into OTAMs(	
																CAM,
																RAM,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew'
								)",$link);
								
								mysql_query("insert into $Reg(
																	idItem,
																	tpMuestra
																	) 
															values 	(	
																	'$OtamNew',
																	'$tpMuestra'
								)",$link);
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =mysql_query("Delete From $Reg Where idItem = '".$Otam."'");
								}
							}
							for($i=$fTra+1; $i<=$tTraccion; $i++){
								$iTra++;
								$Otam = $RAM.$lEnsayo.$i;
								if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }

								$OtamAct = $RAM.$lEnsayo.$iTra;
								if($iTra<10) { $OtamAct = $RAM.$lEnsayo.'0'.$iTra; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$Otam."'";
								$bdOT=mysql_query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=mysql_query($actSQL);

							}

						}
					}
				}
			}
			/********** Si tTraccion = tTracItem   *******/
			
		}else{
				$Reg = 'regQuimico';
		
				$OtamsT 	= $RAM.'-Q';
				$idEnsayo	= 'Qu';
					
				$tTraccion = 0;
				$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
				$result 	= mysql_query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysql_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =mysql_query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Qu韒icos

		// Registrar Charpy
		if($nCharpy > 0){
			$lEnsayo	= '-Ch';
			$Reg 		= 'regCharpy';
			$OtamsT 	= $RAM.$lEnsayo;
			$idEnsayo	= 'Ch';
			$tpMuestra 	= $tpMuestraCh;
			$nTraccion 	= $nCharpy;
			
			$tTraccion = 0;
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysql_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysql_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ning鷑 Ensayo de Tracci髇 Crearlo(s)  *******/
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					mysql_query("insert into OTAMs(	
													CAM,
													RAM,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam,
													Ind,
													Tem
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam',
													'$Imp',
													'$Tem'
					)",$link);
					if($Ind == 0){ $Ind = 3; }
					for($j=1; $j<=$Ind; $j++){
						mysql_query("insert into $Reg(
															idItem,
															tpMuestra,
															nImpacto,
															Tem
															) 
													values 	(	
															'$Otam',
															'$tpMuestra',
															'$j',
															'$Tem'
						)",$link);
					}
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracci髇  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracci髇 para un Items *******/
				if($tTracItem == 0){
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam,
														Ind,
														Tem
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam',
														'$Ind',
														'$Tem'
						)",$link);
						if($Ind == 0){ $Ind = 3; }
						for($j=1; $j<=$Ind; $j++){
							mysql_query("insert into $Reg(
																idItem,
																tpMuestra,
																nImpacto,
																Tem
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$j',
																'$Tem'
							)",$link);
						}
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=mysql_query($actSQL);
	
						$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysql_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=mysql_query($actSQL);
							}while($rowOT=mysql_fetch_array($bdOT));
						}
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* 趌tima Otam de Tracci髇 ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracci髇 a Asignar */
							$nOtam = $tTraccion + $tIns;
							$newOtam = $RAM.$lEnsayo.$nOtam;
							if($nOtam<10) { $newOtam = $RAM.$lEnsayo.'0'.$nOtam;}

							for($i=$nOtam; $i>($uTra+$tIns); $i--){
								$OtamAnt = $RAM.$lEnsayo.($i-$tIns); 	// 6
								if(($i-$tIns)<10) { $OtamAnt = $RAM.$lEnsayo.'0'.($i-$tIns); }
								
								$OtamAct = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamAct = $RAM.$lEnsayo.'0'.$i; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
							}
							$uTra++;
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								mysql_query("insert into OTAMs(	
																CAM,
																RAM,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam,
																Ind,
																Tem
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew',
																'$Ind',
																'$Tem'
								)",$link);
								
								if($Ind == 0){ $Ind = 3; }
								for($j=1; $j<=$Ind; $j++){
									mysql_query("insert into $Reg(
																		idItem,
																		tpMuestra,
																		nImpacto,
																		Tem
																		) 
																values 	(	
																		'$OtamNew',
																		'$tpMuestra',
																		'$j',
																		'$Tem'
									)",$link);
								}
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =mysql_query("Delete From $Reg Where idItem = '".$Otam."'");
								}
							}
							for($i=$fTra+1; $i<=$tTraccion; $i++){
								$iTra++;
								$Otam = $RAM.$lEnsayo.$i;
								if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }

								$OtamAct = $RAM.$lEnsayo.$iTra;
								if($iTra<10) { $OtamAct = $RAM.$lEnsayo.'0'.$iTra; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$Otam."'";
								$bdOT=mysql_query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=mysql_query($actSQL);

							}

						}
					}
				}
			}
			/********** Si tTraccion = tTracItem   *******/
			
		}else{
				$Reg = 'regCharpy';
		
				$OtamsT 	= $RAM.'-Ch';
				$idEnsayo	= 'Ch';
					
				$tTraccion = 0;
				$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
				$result 	= mysql_query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysql_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =mysql_query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Charpy

		// Registrar Dureza
		if($nDureza > 0){
			$lEnsayo	= '-D';
			$Reg 		= 'regDoblado';
			$OtamsT 	= $RAM.$lEnsayo;
			$idEnsayo	= 'Du';
			$tpMuestra 	= $tpMuestraDu;
			$nTraccion 	= $nDureza;
			
			$tTraccion = 0;
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysql_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysql_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ning鷑 Ensayo de Tracci髇 Crearlo(s)  *******/
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					mysql_query("insert into OTAMs(	
													CAM,
													RAM,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam,
													Ind
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam',
													'$Ind'
					)",$link);
					if($Ind == 0){ $Ind = 3; }
					for($j=1; $j<=$Ind; $j++){
						mysql_query("insert into $Reg(
															idItem,
															tpMuestra,
															nIndenta
															) 
													values 	(	
															'$Otam',
															'$tpMuestra',
															'$j'
						)",$link);
					}
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracci髇  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracci髇 para un Items *******/
				if($tTracItem == 0){
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam,
														Ind
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam',
														'$Ind'
						)",$link);
						if($Ind == 0){ $Ind = 3; }
						for($j=1; $j<=$Ind; $j++){
							mysql_query("insert into $Reg(
																idItem,
																tpMuestra,
																nIndenta
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$j'
							)",$link);
						}
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=mysql_query($actSQL);
	
						$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysql_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=mysql_query($actSQL);
							}while($rowOT=mysql_fetch_array($bdOT));
						}
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* 趌tima Otam de Tracci髇 ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracci髇 a Asignar */
							$nOtam = $tTraccion + $tIns;
							$newOtam = $RAM.$lEnsayo.$nOtam;
							if($nOtam<10) { $newOtam = $RAM.$lEnsayo.'0'.$nOtam;}

							for($i=$nOtam; $i>($uTra+$tIns); $i--){
								$OtamAnt = $RAM.$lEnsayo.($i-$tIns); 	// 6
								if(($i-$tIns)<10) { $OtamAnt = $RAM.$lEnsayo.'0'.($i-$tIns); }
								
								$OtamAct = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamAct = $RAM.$lEnsayo.'0'.$i; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
							}
							$uTra++;
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								mysql_query("insert into OTAMs(	
																CAM,
																RAM,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam,
																Ind
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew',
																'$Ind'
								)",$link);
								
								if($Ind == 0){ $Ind = 3; }
								for($j=1; $j<=$Ind; $j++){
									mysql_query("insert into $Reg(
																		idItem,
																		tpMuestra,
																		nIndenta
																		) 
																values 	(	
																		'$OtamNew',
																		'$tpMuestra',
																		'$j'
									)",$link);
								}
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =mysql_query("Delete From $Reg Where idItem = '".$Otam."'");
								}
							}
							for($i=$fTra+1; $i<=$tTraccion; $i++){
								$iTra++;
								$Otam = $RAM.$lEnsayo.$i;
								if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }

								$OtamAct = $RAM.$lEnsayo.$iTra;
								if($iTra<10) { $OtamAct = $RAM.$lEnsayo.'0'.$iTra; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$Otam."'";
								$bdOT=mysql_query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=mysql_query($actSQL);

							}

						}
					}
				}
			}
			/********** Si tTraccion = tTracItem   *******/
			
		}else{
				$Reg = 'regDoblado';
		
				$OtamsT 	= $RAM.'-D';
				$idEnsayo	= 'Do';
					
				$tTraccion = 0;
				$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
				$result 	= mysql_query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysql_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =mysql_query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Dureza

		// Registrar Otra
		if($nOtra > 0){
			$lEnsayo	= '-O';
			$OtamsT 	= $RAM.$lEnsayo;
			$idEnsayo	= 'Ot';
			$tpMuestra 	= 'Ot';
			$nTraccion 	= $nOtra;
			
			$tTraccion = 0;
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysql_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysql_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ning鷑 Ensayo de Tracci髇 Crearlo(s)  *******/
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					mysql_query("insert into OTAMs(	
													CAM,
													RAM,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam'
					)",$link);
						
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracci髇  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracci髇 para un Items *******/
				if($tTracItem == 0){
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam'
						)",$link);
							
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=mysql_query($actSQL);
	
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* 趌tima Otam de Tracci髇 ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracci髇 a Asignar */
							$nOtam = $tTraccion + $tIns;
							$newOtam = $RAM.$lEnsayo.$nOtam;
							if($nOtam<10) { $newOtam = $RAM.$lEnsayo.'0'.$nOtam;}

							for($i=$nOtam; $i>($uTra+$tIns); $i--){
								$OtamAnt = $RAM.$lEnsayo.($i-$tIns); 	// 6
								if(($i-$tIns)<10) { $OtamAnt = $RAM.$lEnsayo.'0'.($i-$tIns); }
								
								$OtamAct = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamAct = $RAM.$lEnsayo.'0'.$i; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								
							}
							$uTra++;
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								mysql_query("insert into OTAMs(	
																CAM,
																RAM,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew'
								)",$link);
								
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysql_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =mysql_query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
								}
							}
							for($i=$fTra+1; $i<=$tTraccion; $i++){
								$iTra++;
								$Otam = $RAM.$lEnsayo.$i;
								if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }

								$OtamAct = $RAM.$lEnsayo.$iTra;
								if($iTra<10) { $OtamAct = $RAM.$lEnsayo.'0'.$iTra; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamAct."'";
								$actSQL.="WHERE Otam = '".$Otam."'";
								$bdOT=mysql_query($actSQL);

							}

						}
					}
				}
			}
			/********** Si tTraccion = tTracItem   *******/
			
		}else{
				$Reg = 'regOtra';
		
				$OtamsT 	= $RAM.'-O';
				$idEnsayo	= 'Ot';
					
				$tTraccion = 0;
				$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
				$result 	= mysql_query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysql_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =mysql_query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =mysql_query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Otra
		
		mysql_close($link);
		$accion = '';
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Administraci贸n de RAMs</title>
	
<!--
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
-->
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
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'muestraMuestras.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='Layer1' style='position:absolute; left:209px; top:350px; width:406px; height:216px; z-index:1'><img src='../imagenes/enProceso.gif' width='50'>Cargando...</div>");
			},
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
					Identificaci贸n de Muestras
						<span style="font-size:18px; font-weight:700;">
							<?php
							$link=Conectarse();
							$bdNS=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
							if($rowNS=mysql_fetch_array($bdNS)){
								$nSolTaller = $rowNS['nSolTaller'];
							}
							mysql_close($link);
						 	echo 'RAM: '.$RAM;
							if($nSolTaller > 0){
								echo ' - N掳 Sol. Taller: '.$nSolTaller;
							}
							?>
						</span>
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesi贸n">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Men煤 Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
			</div>
			<?php 
				include_once('listaMuestras.php');
				if($accion == 'Nuevo' and $RAM > 0){
					?>
					<script>
						var RAM			= "<?php echo $RAM; 		?>" ;
						var idItem		= "<?php echo $idItem; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						registraEnsayos(RAM, idItem, accion);
					</script>
					<?php
				}
				if($accion == 'Editar' and $RAM > 0){
					?>
					<script>
						var RAM			= "<?php echo $RAM; 		?>" ;
						var idItem		= "<?php echo $idItem; 		?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						registraEnsayos(RAM, idItem, accion);
					</script>
					<?php
				}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
