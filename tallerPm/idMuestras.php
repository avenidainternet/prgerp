<?php
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
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

	if(isset($_GET[accion])) 		{ $accion 	 		= $_GET[accion]; 		}
	if(isset($_GET[Taller])) 		{ $Taller 			= $_GET[Taller]; 		}
	if(isset($_GET[Obs])) 			{ $Obs 	 			= $_GET[Obs]; 			}
	if(isset($_GET[nMuestras])) 	{ $nMuestras		= $_GET[nMuestras];		}
	if(isset($_GET[fechaInicio]))	{ $fechaInicio 		= $_GET[fechaInicio];	}
	if(isset($_GET[ingResponsable])){ $ingResponsable 	= $_GET[ingResponsable];}
	if(isset($_GET[cooResponsable])){ $cooResponsable 	= $_GET[cooResponsable];}
	
/*
	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=mysql_query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		//$bdCot=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$accion = 'Filtrar';
			$nSolTaller = $rowCot[nSolTaller];
		}
		mysql_close($link);
	}
*/

	if(isset($_GET[guardarIdMuestra])){	
		$link=Conectarse();
		$bdMu=mysql_query("Select * From amMuestras Where idItem = '".$idItem."'");
		if($rowMu=mysql_fetch_array($bdMu)){
			$bdCot=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
			if($rowCot=mysql_fetch_array($bdCot)){
				$nSolTaller = $rowCot[nSolTaller];
			}

			if($Taller == 'on'){
				if($nSolTaller == 0){
					$bdNform=mysql_query("Select * From tablaRegForm");
					if($rowNform=mysql_fetch_array($bdNform)){
						$nSolTaller = $rowNform[nTaller] + 1;
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
			?>
			<script>
				alert('<php echo $nTraccion; ?>');
			</script>
			<?php
			$OtamsT 	= $RAM.'-T';
			$idEnsayo 	= 'Tr';
			
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tTraccion 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$tTraccion++;
			
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsT."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tTracItem 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$swBorrar = false;
			
			if($tTracItem == 0){
				$nTraccion = ($tTraccion + $nTraccion) - 1;
			}else{
				if(($nTraccion-1) == $tTracItem){
					$tTraccion = $nTraccion;
				}else{
					if($nTraccion > $tTracItem){
						$nTrac 		= $nTraccion;
						$Diferencia = $nTraccion - $tTracItem;
						$nTraccion  = ($tTraccion + $Diferencia) - 1;
						// Insertar Registro(s)
						if($tTraccion > $nTrac){
							$pInsert = $tTracItem + 1;
							$i		 = $tTraccion + 1;
							while($i>$pInsert){
								$iAnt	 = $i - 1;
								$OtamAnt = $RAM.'-T'.$iAnt;
								if($iAnt<10) { $OtamAnt	= $RAM.'-T0'.$iAnt; }
								
								$OtamIns = $RAM.'-T'.$i;
								if($i<10) 	 { $OtamIns = $RAM.'-T0'.$i; 	}

								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamIns. "'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								$i--;
							}
							$nTraccion = $pInsert;
							$Otam = $RAM.'-T'.$pInsert;
							if($pInsert<10){ $Otam = $RAM.'-T0'.$pInsert; }
							
							mysql_query("insert into OTAMs(	
															CAM,
															RAM,
															idItem,
															idEnsayo,
															Otam
															) 
													values 	(	
															'$CAM',
															'$RAM',
															'$idItem',
															'$idEnsayo',
															'$Otam'
							)",$link);
							
						}
					}else{
						// Borrar y Recalcular...

						$nTraccion++;
						$swBorrar 	= true;
						$Diferencia = 0;
						for($i=$nTraccion; $i<=$tTracItem; $i++){
							$Diferencia++;
							$Otam = $RAM.'-T'.$i;
							if($i<10) { $Otam = $RAM.'-T0'.$i; }
							$bdOT =mysql_query("Delete From OTAMs Where Otam = '".$Otam."'");
						}

						$tTraccion--;
						for($i=1; $i<=$tTraccion; $i++){
							$Otam = $RAM.'-T'.$i;
							if($i<10) { $Otam = $RAM.'-T0'.$i; }
							$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
							
							}else{
								$iDif = $i + $Diferencia;
								$OtamOld = $RAM.'-T'.$iDif;
								if($iDif<10) { $OtamOld = $RAM.'-T0'.$iDif; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		='".$Otam.	"'";
								$actSQL.="WHERE Otam = '".$OtamOld."'";
								$bdOT=mysql_query($actSQL);
							}
						}
						
					}
				}
			}
			if($swBorrar == false){
				for($i=$tTraccion; $i<=$nTraccion; $i++){
					$Otam = $RAM.'-T'.$i;
					$idEnsayo = 'Tr';
					
					if($i<10) { $Otam = $RAM.'-T0'.$i; }
					
					$bdOtam=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
					if($rowOtam=mysql_fetch_array($bdOtam)){
						
					}else{
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$Otam'
						)",$link);
					}
				}
			}
		}
		// FIN Registrar Tracciones

		// Registrar Químicos
		if($nQuimico > 0){
			
			$OtamsQ 	= $RAM.'-Q';
			$idEnsayo 	= 'Qu':
			
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsQ."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tQuimico 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$tQuimico++;
			
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsQ."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tQuiItem 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$swBorrar = false;
			
			if($tQuiItem == 0){
				$nQuimico = ($tQuimico + $nQuimico) - 1;
			}else{
				if(($nQuimico-1) == $tQuiItem){
					$tQuimico = $nQuimico;
				}else{
					if($nQuimico > $tQuiItem){
						$nQui 		= $nQuimico;
						$Diferencia = $nQuimico - $tQuiItem;
						$nQuimico   = ($tQuimico + $Diferencia) - 1;
						// Insertar Registro(s)
						if($tQuimico > $nQui){
							$pInsert = $tQuiItem + 1;
							$i		 = $tQuimico + 1;
							while($i>$pInsert){
								$iAnt	 = $i - 1;
								$OtamAnt = $RAM.'-Q'.$iAnt;
								if($iAnt<10) { $OtamAnt	= $RAM.'-Q0'.$iAnt; }
								
								$OtamIns = $RAM.'-Q'.$i;
								if($i<10) 	 { $OtamIns = $RAM.'-Q0'.$i; 	}

								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamIns. "'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								$i--;
							}
							$nQuimico = $pInsert;
							$Otam = $RAM.'-Q'.$pInsert;
							if($pInsert<10){ $Otam = $RAM.'-Q0'.$pInsert; }
							
							mysql_query("insert into OTAMs(	
															CAM,
															RAM,
															idItem,
															idEnsayo,
															Otam
															) 
													values 	(	
															'$CAM',
															'$RAM',
															'$idItem',
															'$idEnsayo',
															'$Otam'
							)",$link);
							
						}
					}else{
						// Borrar y Recalcular...

						$nQuimico++;
						$swBorrar 	= true;
						$Diferencia = 0;
						for($i=$nQuimico; $i<=$tQuiItem; $i++){
							$Diferencia++;
							$Otam = $RAM.'-Q'.$i;
							if($i<10) { $Otam = $RAM.'-Q0'.$i; }
							$bdOT =mysql_query("Delete From OTAMs Where Otam = '".$Otam."'");
						}

						$tQuimico--;
						for($i=1; $i<=$tQuimico; $i++){
							$Otam = $RAM.'-Q'.$i;
							if($i<10) { $Otam = $RAM.'-Q0'.$i; }
							$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
							
							}else{
								$iDif = $i + $Diferencia;
								$OtamOld = $RAM.'-Q'.$iDif;
								if($iDif<10) { $OtamOld = $RAM.'-Q0'.$iDif; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		='".$Otam.	"'";
								$actSQL.="WHERE Otam = '".$OtamOld."'";
								$bdOT=mysql_query($actSQL);
							}
						}
						
					}
				}
			}
			if($swBorrar == false){
				for($i=$tQuimico; $i<=$nQuimico; $i++){
					$Otam = $RAM.'-Q'.$i;
					if($i<10) { $Otam = $RAM.'-Q0'.$i; }
					
					$bdOtam=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
					if($rowOtam=mysql_fetch_array($bdOtam)){
						
					}else{
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$Otam'
						)",$link);
					}
				}
			}
		}
		// FIN Registrar Químicos

		// Registrar Charpy
		if($nCharpy > 0){
			
			$OtamsCh 	= $RAM.'-Ch';
			$idEnsayo	= 'Ch';
			
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsCh."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tCharpy 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$tCharpy++;
			
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsCh."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tChaItem 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$swBorrar = false;
			
			if($tChaItem == 0){
				$nCharpy = ($tCharpy + $nCharpy) - 1;
			}else{
				if(($nCharpy-1) == $tChaItem){
					$tCharpy = $nCharpy;
				}else{
					if($nCharpy > $tChaItem){
						$nCha 		= $nCharpy;
						$Diferencia = $nCharpy - $tChaItem;
						$nCharpy    = ($tCharpy + $Diferencia) - 1;
						// Insertar Registro(s)
						if($tCharpy > $nCha){
							$pInsert = $tChaItem + 1;
							$i		 = $tCharpy + 1;
							while($i>$pInsert){
								$iAnt	 = $i - 1;
								$OtamAnt = $RAM.'-Ch'.$iAnt;
								if($iAnt<10) { $OtamAnt	= $RAM.'-Ch0'.$iAnt; }
								
								$OtamIns = $RAM.'-Ch'.$i;
								if($i<10) 	 { $OtamIns = $RAM.'-Ch0'.$i; 	}

								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamIns. "'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								$i--;
							}
							$nQuimico = $pInsert;
							$Otam = $RAM.'-Ch'.$pInsert;
							if($pInsert<10){ $Otam = $RAM.'-Ch0'.$pInsert; }
							
							mysql_query("insert into OTAMs(	
															CAM,
															RAM,
															idItem,
															idEnsayo,
															Otam
															) 
													values 	(	
															'$CAM',
															'$RAM',
															'$idItem',
															'$idEnsayo',
															'$Otam'
							)",$link);
							
						}
					}else{
						// Borrar y Recalcular...

						$nCharpy++;
						$swBorrar 	= true;
						$Diferencia = 0;
						for($i=$nCharpy; $i<=$tChaItem; $i++){
							$Diferencia++;
							$Otam = $RAM.'-Ch'.$i;
							if($i<10) { $Otam = $RAM.'-Ch0'.$i; }
							$bdOT =mysql_query("Delete From OTAMs Where Otam = '".$Otam."'");
						}

						$tCharpy--;
						for($i=1; $i<=$tCharpy; $i++){
							$Otam = $RAM.'-Ch'.$i;
							if($i<10) { $Otam = $RAM.'-Ch0'.$i; }
							$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
							
							}else{
								$iDif = $i + $Diferencia;
								$OtamOld = $RAM.'-Ch'.$iDif;
								if($iDif<10) { $OtamOld = $RAM.'-Ch0'.$iDif; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		='".$Otam.	"'";
								$actSQL.="WHERE Otam = '".$OtamOld."'";
								$bdOT=mysql_query($actSQL);
							}
						}
						
					}
				}
			}
			if($swBorrar == false){
				for($i=$tCharpy; $i<=$nCharpy; $i++){
					$Otam = $RAM.'-Ch'.$i;
					if($i<10) { $Otam = $RAM.'-Ch0'.$i; }
					
					$bdOtam=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
					if($rowOtam=mysql_fetch_array($bdOtam)){
						
					}else{
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$Otam'
						)",$link);
					}
				}
			}
		}
		// FIN Registrar Charpy

		// Registrar Dureza
		if($nDureza > 0){
			
			$OtamsD 	= $RAM.'-D';
			$idEnsayo	= 'Du';
			
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsD."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tDureza 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$tDureza++;
			
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsD."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tDurItem 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$swBorrar = false;
			
			if($tDurItem == 0){
				$nDureza = ($tDureza + $nDureza) - 1;
			}else{
				if(($nDureza-1) == $tDurItem){
					$tDureza = $nDureza;
				}else{
					if($nDureza > $tDurItem){
						$nDur 		= $nDureza;
						$Diferencia = $nDureza - $tDurItem;
						$nDureza    = ($tDureza + $Diferencia) - 1;
						// Insertar Registro(s)
						if($tDureza > $nDur){
							$pInsert = $tDurItem + 1;
							$i		 = $tDureza + 1;
							while($i>$pInsert){
								$iAnt	 = $i - 1;
								$OtamAnt = $RAM.'-D'.$iAnt;
								if($iAnt<10) { $OtamAnt	= $RAM.'-D0'.$iAnt; }
								
								$OtamIns = $RAM.'-D'.$i;
								if($i<10) 	 { $OtamIns = $RAM.'-D0'.$i; 	}

								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamIns. "'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								$i--;
							}
							$nDureza = $pInsert;
							$Otam = $RAM.'-D'.$pInsert;
							if($pInsert<10){ $Otam = $RAM.'-D0'.$pInsert; }
							
							mysql_query("insert into OTAMs(	
															CAM,
															RAM,
															idItem,
															idEnsayo,
															Otam
															) 
													values 	(	
															'$CAM',
															'$RAM',
															'$idItem',
															'$idEnsayo',
															'$Otam'
							)",$link);
							
						}
					}else{
						// Borrar y Recalcular...

						$nDureza++;
						$swBorrar 	= true;
						$Diferencia = 0;
						for($i=$nDureza; $i<=$tDurItem; $i++){
							$Diferencia++;
							$Otam = $RAM.'-D'.$i;
							if($i<10) { $Otam = $RAM.'-D0'.$i; }
							$bdOT =mysql_query("Delete From OTAMs Where Otam = '".$Otam."'");
						}

						$tDureza--;
						for($i=1; $i<=$tDureza; $i++){
							$Otam = $RAM.'-D'.$i;
							if($i<10) { $Otam = $RAM.'-D0'.$i; }
							$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
							
							}else{
								$iDif = $i + $Diferencia;
								$OtamOld = $RAM.'-D'.$iDif;
								if($iDif<10) { $OtamOld = $RAM.'-D0'.$iDif; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		='".$Otam.	"'";
								$actSQL.="WHERE Otam = '".$OtamOld."'";
								$bdOT=mysql_query($actSQL);
							}
						}
						
					}
				}
			}
			if($swBorrar == false){
				for($i=$tDureza; $i<=$nDureza; $i++){
					$Otam = $RAM.'-D'.$i;
					if($i<10) { $Otam = $RAM.'-D0'.$i; }
					
					$bdOtam=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
					if($rowOtam=mysql_fetch_array($bdOtam)){
						
					}else{
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$Otam'
						)",$link);
					}
				}
			}
		}
		// FIN Registrar Dureza

		// Registrar Otra
		if($nOtra > 0){
			
			$OtamsO 	= $RAM.'-O';
			$idEnsayo	= 'Ot';
			
			$sql 		= "SELECT * FROM OTAMs Where Otam Like '%".$OtamsO."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tOtra 	= mysql_num_rows($result); // obtenemos el número de Otams Otra
			$tOtra++;
			
			$sql 		= "SELECT * FROM OTAMs Where idItem = '".$idItem."' and Otam Like '%".$OtamsO."%'";  // sentencia sql
			$result 	= mysql_query($sql);
			$tOtrItem 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
			$swBorrar = false;
			
			if($tOtrItem == 0){
				$nOtra = ($tOtra + $nOtra) - 1;
			}else{
				if(($nOtra-1) == $tOtrItem){
					$tOtra = $nOtra;
				}else{
					if($nOtra > $tOtrItem){
						$nOtr 		= $nOtra;
						$Diferencia = $nOtra - $tOtrItem;
						$nOtra     = ($tOtra + $Diferencia) - 1;
						// Insertar Registro(s)
						if($tOtra > $nOtr){
							$pInsert = $tOtrItem + 1;
							$i		 = $tOtra + 1;
							while($i>$pInsert){
								$iAnt	 = $i - 1;
								$OtamAnt = $RAM.'-O'.$iAnt;
								if($iAnt<10) { $OtamAnt	= $RAM.'-O0'.$iAnt; }
								
								$OtamIns = $RAM.'-O'.$i;
								if($i<10) 	 { $OtamIns = $RAM.'-O0'.$i; 	}

								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		 = '".$OtamIns. "'";
								$actSQL.="WHERE Otam = '".$OtamAnt."'";
								$bdOT=mysql_query($actSQL);
								$i--;
							}
							$nOtra = $pInsert;
							$Otam = $RAM.'-O'.$pInsert;
							if($pInsert<10){ $Otam = $RAM.'-O0'.$pInsert; }
							
							mysql_query("insert into OTAMs(	
															CAM,
															RAM,
															idItem,
															idEnsayo,
															Otam
															) 
													values 	(	
															'$CAM',
															'$RAM',
															'$idItem',
															'$idEnsayo',
															'$Otam'
							)",$link);
							
						}
					}else{
						// Borrar y Recalcular...

						$nOtra++;
						$swBorrar 	= true;
						$Diferencia = 0;
						for($i=$nOtra; $i<=$tOtrItem; $i++){
							$Diferencia++;
							$Otam = $RAM.'-O'.$i;
							if($i<10) { $Otam = $RAM.'-O0'.$i; }
							$bdOT =mysql_query("Delete From OTAMs Where Otam = '".$Otam."'");
						}

						$tOtra--;
						for($i=1; $i<=$tOtra; $i++){
							$Otam = $RAM.'-O'.$i;
							if($i<10) { $Otam = $RAM.'-O0'.$i; }
							$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
							
							}else{
								$iDif = $i + $Diferencia;
								$OtamOld = $RAM.'-O'.$iDif;
								if($iDif<10) { $OtamOld = $RAM.'-O0'.$iDif; }
								
								$actSQL="UPDATE OTAMs SET ";
								$actSQL.="Otam		='".$Otam.	"'";
								$actSQL.="WHERE Otam = '".$OtamOld."'";
								$bdOT=mysql_query($actSQL);
							}
						}
						
					}
				}
			}
			if($swBorrar == false){
				for($i=$tOtra; $i<=$nOtra; $i++){
					$Otam = $RAM.'-O'.$i;
					if($i<10) { $Otam = $RAM.'-O0'.$i; }
					
					$bdOtam=mysql_query("Select * From OTAMs Where idItem = '".$idItem."' and Otam = '".$Otam."'");
					if($rowOtam=mysql_fetch_array($bdOtam)){
						
					}else{
						mysql_query("insert into OTAMs(	
														CAM,
														RAM,
														idItem,
														idEnsayo,
														Otam
														) 
												values 	(	
														'$CAM',
														'$RAM',
														'$idItem',
														'$idEnsayo',
														'$Otam'
						)",$link);
					}
				}
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
