<?php
	session_start(); 
	include_once("../conexionli.php");
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$tEns = 0;
	$OCP = '';

	if(isset($_GET['OCP'])) 	{	$OCP 		= $_GET['OCP']; 	}
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

	if(isset($_POST['RAM']))  		{ $RAM		= $_POST['RAM']; 		}

	if(isset($_GET['guardarIdMuestra'])){	
		$link=Conectarse();
		$bdMu=$link->query("Select * From amMuestras Where idItem = '".$idItem."'");
		if($rowMu=mysqli_fetch_array($bdMu)){
			$bdCot=$link->query("Select * From formRAM Where RAM = '".$RAM."'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$nSolTaller = $rowCot['nSolTaller'];
			}
			if($RefTr) {
			
				$bdT=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Tr'");
				if($rowT=mysqli_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefTr."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Tr'";
					$bdT=$link->query($actSQL);
				}else{
					$link->query("insert into amTabEnsayos(	
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
					)");
				}
				
			}
			if($RefQu) {

				$bdT=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Qu'");
				if($rowT=mysqli_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefQu."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Qu'";
					$bdT=$link->query($actSQL);
				}else{
					$link->query("insert into amTabEnsayos(	
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
					)");
				}

			}
			if($RefCh) {
			
				$bdT=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Ch'");
				if($rowT=mysqli_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefCh."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Ch'";
					$bdT=$link->query($actSQL);
				}else{
					$link->query("insert into amTabEnsayos(	
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
					)");
				}
				
			}
			if($RefDu) {
			
				$bdT=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Du'");
				if($rowT=mysqli_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefDu."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Du'";
					$bdT=$link->query($actSQL);
				}else{
					$link->query("insert into amTabEnsayos(	
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
					)");
				}
				
			}
			if($nOtra) {
			
				$bdT=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."' and idEnsayo = 'Ot'");
				if($rowT=mysqli_fetch_array($bdT)){
					$actSQL="UPDATE amTabEnsayos SET ";
					$actSQL.="Ref			='".$RefOt."'";
					$actSQL.="WHERE idItem = '".$idItem."' and idEnsayo = 'Ot'";
					$bdT=$link->query($actSQL);
				}else{
					$link->query("insert into amTabEnsayos(	
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
					)");
				}
				
			}
			
			if($Taller == 'on'){
				if($nSolTaller == 0){
					$bdNform=$link->query("Select * From tablaRegForm");
					if($rowNform=mysqli_fetch_array($bdNform)){
						$nSolTaller = $rowNform['nTaller'] + 1;
						$actSQL="UPDATE tablaRegForm SET ";
						$actSQL.="nTaller		='".$nSolTaller."'";
						$bdNform=$link->query($actSQL);
						
						$actSQL="UPDATE formRAM SET ";
						$actSQL.="nSolTaller	='".$nSolTaller."'";
						$actSQL.="WHERE RAM = '".$RAM."'";
						$bdfRAM=$link->query($actSQL);
						
					}
				}
			}


			$actSQL="UPDATE amMuestras SET ";
			$actSQL.="Taller		='".$Taller.	"',";
			$actSQL.="idMuestra		='".$idMuestra.	"'";
			$actSQL.="WHERE idItem = '".$idItem."'";
			$bdMu=$link->query($actSQL);
		}
		
		// Registrar Tracciones
		if($nTraccion > 0){
			$Reg = 'regTraccion';
			$OtamsT 	= $RAM.'-T';
			$idEnsayo	= 'Tr';
			$tTraccion = 0;

			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);
			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysqli_num_rows($result); 
			// $tTraccion++;
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);
			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysqli_num_rows($result); 
			$swBorrar = false;
			/********** Si tTraccion = 0 no hay NingÃºn Ensayo de TracciÃ³n Crearlo(s)  *******/
			$fechaCreaRegistro = date('Y-m-d');
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){ 
					$Otam = $RAM.'-T'.$i;
					if($i<10) { $Otam = $RAM.'-T0'.$i; }
					$link->query("insert into OTAMs(	
													CAM,
													RAM,
													fechaCreaRegistro,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$fechaCreaRegistro',
													'$idItem',
													'$idEnsayo',
													'$tpMuestraTr',
													'$Otam'
					)");

					$link->query("insert into amTabEnsayos(	
													idItem,
													idEnsayo,
													tpMuestra
													) 
											values 	(	
													'$idItem',
													'$idEnsayo',
													'$tpMuestraTr'
					)");

					$link->query("insert into $Reg(
														idItem,
														tpMuestra
														) 
												values 	(	
														'$Otam',
														'$tpMuestraTr'
					)");
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracción  *******/
			if($tTraccion > 0){
				$Reg = 'regTraccion';
				
				/********** Si tTracItem = 0 NO hay Ensayo de Tracción para un Items *******/
				if($tTracItem == 0){
					$fechaCreaRegistro = date('Y-m-d');
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.'-T'.$i;
						if($i<10) { $Otam = $RAM.'-T0'.$i; }
						$link->query("insert into OTAMs(	
														CAM,
														RAM,
														fechaCreaRegistro,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$fechaCreaRegistro',
														'$idItem',
														'$idEnsayo',
														'$tpMuestraTr',
														'$Otam'
						)");
							
						$link->query("insert into $Reg(
															idItem,
															tpMuestra
															) 
													values 	(	
															'$Otam',
															'$tpMuestraTr'
						)");
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.'-T';
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestraTr. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=$link->query($actSQL);
	
						$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestraTr. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=$link->query($actSQL);
							}while($rowOT=mysqli_fetch_array($bdOT));
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
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* Última Otam de Tracción ingresada */
							$ultOtam = $RAM.'-T'.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.'-T0'.$tTraccion;}

							/* Otam de Tracción a Asignar */
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
								$bdOT=$link->query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=$link->query($actSQL);
								
							}
							$uTra++;
							$fechaCreaRegistro = date('Y-m-d');
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.'-T'.$i;			// 8
								if($i<10) { $OtamNew = $RAM.'-T0'.$i; }

								$link->query("insert into OTAMs(	
																CAM,
																RAM,
																fechaCreaRegistro,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$fechaCreaRegistro',
																'$idItem',
																'$idEnsayo',
																'$tpMuestraTr',
																'$OtamNew'
								)");
								
								$link->query("insert into $Reg(
																	idItem,
																	tpMuestra
																	) 
															values 	(	
																	'$OtamNew',
																	'$tpMuestraTr'
								)");
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.'-T';
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =$link->query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =$link->query("Delete From $Reg Where idItem = '".$Otam."'");
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
								$bdOT=$link->query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=$link->query($actSQL);

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
				$result 	= $link->query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysqli_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =$link->query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		
		// FIN Registrar Tracciones

		// Registrar Químicos
		if($nQuimico > 0){
			$lEnsayo	= '-Q';
			$Reg 		= 'regQuimico';
			$OtamsT 	= $RAM.$lEnsayo;
			$idEnsayo	= 'Qu';
			$tpMuestra 	= $tpMuestraQu;
			$nTraccion 	= $nQuimico;
			
			$tTraccion = 0;
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysqli_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysqli_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ningún Ensayo de Tracción Crearlo(s)  *******/
			if($tTraccion == 0){
				$fechaCreaRegistro = date('Y-m-d');
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					$link->query("insert into OTAMs(	
													CAM,
													RAM,
													fechaCreaRegistro,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$fechaCreaRegistro',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam'
					)");
						
					$link->query("insert into $Reg(
														idItem,
														tpMuestra
														) 
												values 	(	
														'$Otam',
														'$tpMuestra'
					)");
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracción  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracción para un Items *******/
				if($tTracItem == 0){
					$fechaCreaRegistro = date('Y-m-d');
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						$link->query("insert into OTAMs(	
														CAM,
														RAM,
														fechaCreaRegistro,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$fechaCreaRegistro',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam'
						)");
							
						$link->query("insert into $Reg(
															idItem,
															tpMuestra
															) 
													values 	(	
															'$Otam',
															'$tpMuestra'
						)");
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=$link->query($actSQL);
	
						$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=$link->query($actSQL);
							}while($rowOT=mysqli_fetch_array($bdOT));
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
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* Última Otam de Tracción ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracción a Asignar */
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
								$bdOT=$link->query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=$link->query($actSQL);
								
							}
							$uTra++;
							$fechaCreaRegistro = date('Y-m-d');
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								$link->query("insert into OTAMs(	
																CAM,
																RAM,
																fechaCreaRegistro,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$fechaCreaRegistro',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew'
								)");
								
								$link->query("insert into $Reg(
																	idItem,
																	tpMuestra
																	) 
															values 	(	
																	'$OtamNew',
																	'$tpMuestra'
								)");
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =$link->query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =$link->query("Delete From $Reg Where idItem = '".$Otam."'");
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
								$bdOT=$link->query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=$link->query($actSQL);

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
				$result 	= $link->query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysqli_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =$link->query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Químicos

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
			$result 	= $link->query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysqli_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysqli_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ningún Ensayo de Tracción Crearlo(s)  *******/
			if($tTraccion == 0){
				$fechaCreaRegistro = date('Y-m-d');
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					$link->query("insert into OTAMs(	
													CAM,
													RAM,
													fechaCreaRegistro,
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
													'$fechaCreaRegistro',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam',
													'$Imp',
													'$Tem'
					)");
					if($Ind == 0){ $Ind = 3; }
					for($j=1; $j<=$Ind; $j++){
						$link->query("insert into $Reg(
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
						)");
					}
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracción  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracción para un Items *******/
				if($tTracItem == 0){
					$fechaCreaRegistro = date('Y-m-d');
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						$link->query("insert into OTAMs(	
														CAM,
														RAM,
														fechaCreaRegistro,
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
														'$fechaCreaRegistro',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam',
														'$Ind',
														'$Tem'
						)");
						if($Ind == 0){ $Ind = 3; }
						for($j=1; $j<=$Ind; $j++){
							$link->query("insert into $Reg(
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
							)");
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
						$bdOT=$link->query($actSQL);
	
						$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=$link->query($actSQL);
							}while($rowOT=mysqli_fetch_array($bdOT));
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
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* Última Otam de Tracción ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracción a Asignar */
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
								$bdOT=$link->query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=$link->query($actSQL);
								
							}
							$uTra++;
							$fechaCreaRegistro = date('Y-m-d');
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								$link->query("insert into OTAMs(	
																CAM,
																RAM,
																fechaCreaRegistro,
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
																'$fechaCreaRegistro',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew',
																'$Ind',
																'$Tem'
								)");
								
								if($Ind == 0){ $Ind = 3; }
								for($j=1; $j<=$Ind; $j++){
									$link->query("insert into $Reg(
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
									)");
								}
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =$link->query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =$link->query("Delete From $Reg Where idItem = '".$Otam."'");
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
								$bdOT=$link->query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=$link->query($actSQL);

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
				$result 	= $link->query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysqli_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =$link->query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
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
			$result 	= $link->query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysqli_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysqli_num_rows($result); 
			
			$swBorrar = false;
			$fechaCreaRegistro = date('Y-m-d');
			/********** Si tTraccion = 0 no hay Ningún Ensayo de Tracción Crearlo(s)  *******/
			if($tTraccion == 0){
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					$link->query("insert into OTAMs(	
													CAM,
													RAM,
													fechaCreaRegistro,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam,
													Ind
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$fechaCreaRegistro',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam',
													'$Ind'
					)");
					if($Ind == 0){ $Ind = 3; }
					for($j=1; $j<=$Ind; $j++){
						$link->query("insert into $Reg(
															idItem,
															tpMuestra,
															nIndenta
															) 
													values 	(	
															'$Otam',
															'$tpMuestra',
															'$j'
						)");
					}
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracción  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracción para un Items *******/
				if($tTracItem == 0){
					$fechaCreaRegistro = date('Y-m-d');
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						$link->query("insert into OTAMs(	
														CAM,
														RAM,
														fechaCreaRegistro,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam,
														Ind
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$fechaCreaRegistro',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam',
														'$Ind'
						)");
						if($Ind == 0){ $Ind = 3; }
						for($j=1; $j<=$Ind; $j++){
							$link->query("insert into $Reg(
																idItem,
																tpMuestra,
																nIndenta
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$j'
							)");
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
						$bdOT=$link->query($actSQL);
	
						$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%'");
						if($rowOT=mysqli_fetch_array($bdOT)){
							do{
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
								$actSQL.="WHERE idItem = '".$rowOT['Otam']."'";
								$bdReg=$link->query($actSQL);
							}while($rowOT=mysqli_fetch_array($bdOT));
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
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* Última Otam de Tracción ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracción a Asignar */
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
								$bdOT=$link->query($actSQL);
								
								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$OtamAnt."'";
								$bdOT=$link->query($actSQL);
								
							}
							$uTra++;
							$fechaCreaRegistro = date('Y-m-d');
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								$link->query("insert into OTAMs(	
																CAM,
																RAM,
																fechaCreaRegistro,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam,
																Ind
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$fechaCreaRegistro',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew',
																'$Ind'
								)");
								
								if($Ind == 0){ $Ind = 3; }
								for($j=1; $j<=$Ind; $j++){
									$link->query("insert into $Reg(
																		idItem,
																		tpMuestra,
																		nIndenta
																		) 
																values 	(	
																		'$OtamNew',
																		'$tpMuestra',
																		'$j'
									)");
								}
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =$link->query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
									//$bdOT =$link->query("Delete From $Reg Where idItem = '".$Otam."'");
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
								$bdOT=$link->query($actSQL);

								$actSQL="UPDATE $Reg SET ";
								$actSQL.="idItem		= '".$OtamAct."'";
								$actSQL.="WHERE idItem 	= '".$Otam."'";
								$bdOT=$link->query($actSQL);

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
				$result 	= $link->query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysqli_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =$link->query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
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
			$result 	= $link->query($sql);

			/********** Total General de Tracciones   *******/
			$tTraccion 	= mysqli_num_rows($result); 
			// $tTraccion++;
			
			$tTracItem = 0;
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= $link->query($sql);

			/********** Total de Tracciones x Item   *******/
			$tTracItem 	= mysqli_num_rows($result); 
			
			$swBorrar = false;
			
			/********** Si tTraccion = 0 no hay Ningún Ensayo de Tracción Crearlo(s)  *******/
			if($tTraccion == 0){
				$fechaCreaRegistro = date('Y-m-d');
				for($i=1; $i<=$nTraccion; $i++){
					$Otam = $RAM.$lEnsayo.$i;
					if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
					$link->query("insert into OTAMs(	
													CAM,
													RAM,
													fechaCreaRegistro,
													idItem,
													idEnsayo,
													tpMuestra,
													Otam
													) 
											values 	(	
													'$CAM',
													'$RAM',
													'$fechaCreaRegistro',
													'$idItem',
													'$idEnsayo',
													'$tpMuestra',
													'$Otam'
					)");
						
				}
			}
			
			/********** Si tTraccion > 0 almenos hay un Ensayo de Tracción  *******/
			if($tTraccion > 0){
				/********** Si tTracItem = 0 NO hay Ensayo de Tracción para un Items *******/
				if($tTracItem == 0){
					$fechaCreaRegistro = date('Y-m-d');
					for($i=$tTraccion+1; $i<=($tTraccion+$nTraccion); $i++){
						$Otam = $RAM.$lEnsayo.$i;
						if($i<10) { $Otam = $RAM.$lEnsayo.'0'.$i; }
						$link->query("insert into OTAMs(	
														CAM,
														RAM,
														fechaCreaRegistro,
														idItem,
														idEnsayo,
														tpMuestra,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$fechaCreaRegistro',
														'$idItem',
														'$idEnsayo',
														'$tpMuestra',
														'$Otam'
						)");
							
					}
				}else{
					/********** Actualiza Items *******/
					/********** Si tTracItem = nTraccion Actualiza Muestras *******/
					if($tTracItem == $nTraccion){
						$Otam = $RAM.$lEnsayo;
						$actSQL="UPDATE OTAMs SET ";
						$actSQL.="tpMuestra		= '".$tpMuestra. 	"'";
						$actSQL.="WHERE idItem = '".$idItem."' and Otam Like '%".$Otam."%'";
						$bdOT=$link->query($actSQL);
	
					}else{
						/********** Si nTracItem <> nTraccion Se Elimino o se Agrego un ensayo *******/
						/********** Si nTracItem > nTraccion SE AGREGO AL MENOS UN ENSAYO AL ITEM *******/
						if($nTraccion > $tTracItem){
							/********** Reasignar Numero *******/
							/* Total de Ensayos a Insertar  Ej. 2 */
							$tIns = $nTraccion - $tTracItem;
							/* Hacer el Espacio*/
							$Otam = $RAM.$lEnsayo;
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$ultOtamItem = $rowOT['Otam'];
								$uTra = intval(substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
							}
							/* Última Otam de Tracción ingresada */
							$ultOtam = $RAM.$lEnsayo.$tTraccion;
							if($tTraccion<10) { $ultOtam = $RAM.$lEnsayo.'0'.$tTraccion;}

							/* Otam de Tracción a Asignar */
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
								$bdOT=$link->query($actSQL);
								
							}
							$uTra++;
							$fechaCreaRegistro = date('Y-m-d');
							for($i=$uTra; $i<($uTra+$tIns); $i++){
								$OtamNew = $RAM.$lEnsayo.$i;			// 8
								if($i<10) { $OtamNew = $RAM.$lEnsayo.'0'.$i; }

								$link->query("insert into OTAMs(	
																CAM,
																RAM,
																fechaCreaRegistro,
																idItem,
																idEnsayo,
																tpMuestra,
																Otam
																) 
														values 	(	
																'$CAM',
																'$RAM',
																'$fechaCreaRegistro',
																'$idItem',
																'$idEnsayo',
																'$tpMuestra',
																'$OtamNew'
								)");
								
							}

							/********** Fin Reasignar Numero *******/

						}else{
							/********** SE ELIMINO UN ENSAYO AL ITEM *******/
							$bTra = $tTracItem - $nTraccion;
							$Otam = $RAM.$lEnsayo;
							$bdOT=$link->query("SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$Otam."%' Order By Otam Desc");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$fTra = (substr($rowOT['Otam'],strlen($rowOT['Otam'])-2,strlen($rowOT['Otam'])));
								$iTra = $fTra - $bTra;
								for($i=intval($fTra); $i>$iTra; $i--){
									$Otam = $RAM.'-T'.$i;
									if($i<10) { $Otam = $RAM.'-T0'.$i; }
									//$bdOT =$link->query("Delete From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
									
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
								$bdOT=$link->query($actSQL);

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
				$result 	= $link->query($sql);
				/********** Total General de Tracciones   *******/
				$tTraccion 	= mysqli_num_rows($result); 
				if($tTraccion > 0){
					//$bdOT =$link->query("Delete From OTAMs 			Where idEnsayo = '".$idEnsayo."' and Otam 	Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From amTabEnsayos 	Where idEnsayo = '".$idEnsayo."' and idItem Like '%".$RAM."%'");
					//$bdOT =$link->query("Delete From $Reg		 	Where idItem Like '%".$RAM."%'");
				}
		}
		// FIN Registrar Otra


		$link->close();
		$accion = '';

	}
	$tpEnsayo = '';
	$link=Conectarse();
	$bd=$link->query("SELECT * FROM cotizaciones Where RAM = '".$RAM."'");
	if($rs=mysqli_fetch_array($bd)){
		$tpEnsayo = $rs['tpEnsayo'];
	}
	$link->close();
		


	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Identificación de Muestras</title>
	
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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


	<style type="text/css">
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>


</head>
<body ng-app="myApp" ng-controller="CtrlMuestras">
	<?php include('head.php'); ?>
	

	<input ng-model="RAM" type="hidden" ng-init="loadMuestras('<?php echo $RAM; ?>')">
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesosangular/plataformaCotizaciones.php"> Proceso</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-print" href="formularios/iRAM.php?accion=Imprimir&RAM=<?php echo $RAM; ?>" title="Imprimir RAM"> RAM</a>
	        		</li>
					<?php 
						if($tpEnsayo == 5){?>
							<li class="nav-item">
								<a class="nav-link fas fa-print" href="formularios/iRAMAR.php?accion=Imprimir&RAM=<?php echo $RAM; ?>" title="Form. Informe Oficial"> RAM Inf.Oficial</a>
							</li>
						<?php
						}
					?>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="pOtams.php?RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>&OCP=<?php echo $OCP; ?>"> Volver</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../prgtaller"> Progama Taller</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
	<?php
		$link=Conectarse();
		$bdNS=$link->query("Select * From formRAM Where RAM = '".$RAM."'");
		if($rowNS=mysqli_fetch_array($bdNS)){
			$nSolTaller = $rowNS['nSolTaller'];
		}
		$link->close();

	?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo"> 
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
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="muestras.js"></script>

	<script>
		$(document).ready(function() {
		    $('#Muestras').DataTable( {
		        "order": [[ 0, "asc" ]],
				"language": {
					            "lengthMenu": "Mostrar _MENU_ Reg. por Página",
					            "zeroRecords": "Nothing found - sorry",
					            "info": "Mostrando Pág. _PAGE_ de _PAGES_",
					            "infoEmpty": "No records available",
					            "infoFiltered": "(de _MAX_ tot. Reg.)",
					            "search":         "Buscar:",
        		}
		    } );
		} );
	</script>
	
	
</body>
</html>
