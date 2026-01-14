<?php
/*
	ini_set("session.cookie_lifetime","7200");
	ini_set("session.gc_maxlifetime","7200");
*/	
	session_start(); 
	include_once("../conexionli.php");
	
	date_default_timezone_set("America/Santiago");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

	$CAM 			= 0;
	$nLin 			= 0;
	$accion			= '';
	$oCtaCte 		= 0;
	$Rev			= 0;
	$Cliente		= '';
	$Moneda			= '';
	$Atencion		= '';
	$usrCotizador	= '';
	$pDescuento 	= 0;
	$NetoUF 		= 0;
	$IvaUF 			= 0;
	$nContacto		= 0;
	$correoAtencion	= '';
	$Correo 		= '';
	$BrutoUF		= 0;
	
	$Validez	= 30;
	$fechaCotizacion = date('Y-m-d');

	if(isset($_GET['CAM'])) 		{	$CAM 		= $_GET['CAM']; 		}
	if(isset($_GET['Rev'])) 		{	$Rev 		= $_GET['Rev']; 		}
	if(isset($_GET['Cta'])) 		{	$Cta 		= $_GET['Cta']; 		}
	if(isset($_GET['nServicio'])) 	{	$nServicio 	= $_GET['nServicio']; 	}
	if(isset($_GET['nLin'])) 		{	$nLin 		= $_GET['nLin']; 		}
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Correo'])) 		{	$Correo 	= $_GET['Correo']; 		}


	$nCot = 1;
	$link=Conectarse();
	$sql = "SELECT * FROM Cotizaciones";  // sentencia sql
	$result = $link->query($sql);
	$nCot = $result->num_rows; // obtenemos el número de filas
	$link->close();

	
	if(isset($_POST['CAM'])) 		{	$CAM 		= $_POST['CAM']; 		}
	if(isset($_POST['Rev'])) 		{	$Rev 		= $_POST['Rev']; 		}
	if(isset($_POST['Cta'])) 		{	$Cta 		= $_POST['Cta']; 		}
	if(isset($_POST['nServicio']))	{	$nServicio 	= $_POST['nServicio']; 	}
	if(isset($_POST['nLin']))		{	$nLin 		= $_POST['nLin']; 		}
	if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; 	}

/*
	if(isset($_POST[bajarEnvio])){
		header("Location: formularios/iCAM.php?CAM=$CAM&Rev=$Rev&Cta=$Cta");
	}
*/
	if($Correo == 'OK'){
		$correoAutomatico= 'on';
		$link=Conectarse();
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="correoAutomatico	='".$correoAutomatico.	"'";
		$actSQL.="WHERE CAM			= '".$CAM."'";
		$bdCot=$link->query($actSQL);
		$link->close();
	}
	if(isset($_POST['calDescuento'])){
		if(isset($_POST['CAM'])) 		{ $CAM 			= $_POST['CAM']; 		}
		if(isset($_POST['Rev'])) 		{ $Rev 			= $_POST['Rev'];		}
		if(isset($_POST['Cta'])) 		{ $Cta 			= $_POST['Cta'];		}
		if(isset($_POST['pDescuento'])) { $pDescuento 	= $_POST['pDescuento'];	}
	
		$link=Conectarse();
	
		$NetoUF	= 0;
		$NetoP	= 0;
		
		$bddCot=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			do{
				$NetoUF += $rowdCot['NetoUF'];
				$NetoP 	+= $rowdCot['Neto'];
			}while ($rowdCot=mysqli_fetch_array($bddCot));
		}
	
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
	
			//$NetoUF 	= $rowCot[NetoUF] / (1+($pDescuento/100));
			//$NetoUF 	= $NetoUF / (1+($pDescuento/100));
			$vDscto 	= intval($NetoUF * $pDescuento)/100;
	
				//$Neto 	= $NetoUF * $rowCot[valorUF];
			if($rowCot['exentoIva']=='on'){
				$Neto 	= $NetoP *((100-$pDescuento)/100);
				$Iva	= 0;
				$Bruto	= $Neto;
	
				$NetoUF		= $NetoUF - $vDscto;
				$IvaUF		= 0;
				$TotalUF	= $NetoUF;
			}else{
				$Neto 	= $NetoP *((100-$pDescuento)/100);
				$Iva	= $Neto * 0.19;
				$Bruto	= round($Neto,0) + round($Iva,0);
	
				$NetoUF		= $NetoUF - $vDscto;
				$IvaUF		= round($NetoUF * 0.19,2);
				$TotalUF	= $NetoUF + $IvaUF;
			}
	
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="pDescuento	='".$pDescuento."',";
			$actSQL.="Neto			='".$Neto.		"',";
			$actSQL.="Iva			='".$Iva.		"',";
			$actSQL.="Bruto			='".$Bruto.		"',";
			$actSQL.="NetoUF		='".$NetoUF.	"',";
			$actSQL.="IvaUF			='".$IvaUF.		"',";
			$actSQL.="BrutoUF		='".$TotalUF.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
	}	
	
	
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From Cotizaciones 	Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		$bddCot=$link->query("Delete From dCotizacion 	Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		$link->close();
		$CAM 	= '';
		$accion	= '';
		header("Location: plataformaCotizaciones.php");
	}
	if(isset($_POST['BorrarServicio'])){
		$link=Conectarse();
		$bddCot=$link->query("Delete From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");
		
		$NetoUF = 0;
		$NetoP	= 0;
		
		$bddCot=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			do{
				$NetoUF += $rowdCot['NetoUF'];
				$NetoP 	+= $rowdCot['Neto'];
			}while ($rowdCot=mysqli_fetch_array($bddCot));
		}

		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$pDescuento = $rowCot['pDescuento'];
			$vDscto 	= $NetoUF * ($pDescuento/100);
			
			$IvaUF 	= 0;
			
			$NetoUF		= $NetoUF - $vDscto;
			$IvaUF		= round($NetoUF * 0.19,2);
			$TotalUF	= $NetoUF + $IvaUF;

			$NetoPesos 	= $NetoP *((100-$pDescuento)/100);
			if($rowCot['exentoIva']=='on'){
				$IvaPesos 	= 0;
				$BrutoPesos	= $NetoPesos;

				$IvaUF		= 0;
				$TotalUF	= $NetoUF;
			}else{
				$IvaPesos	= $NetoPesos * 0.19;
				$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);
			}

				$IvaPesos	= $NetoPesos * 0.19;
				$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);


/*			
			$NetoPesos	= $NetoUF * $rowCot[valorUF];
			$IvaPesos	= $NetoPesos * 0.19;
			$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);
*/	
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Neto			='".$NetoPesos.	"',";
			$actSQL.="Iva			='".$IvaPesos.	"',";
			$actSQL.="Bruto			='".$BrutoPesos."',";
			$actSQL.="NetoUF		='".$NetoUF.	"',";
			$actSQL.="IvaUF			='".$IvaUF.		"',";
			$actSQL.="BrutoUF		='".$NetoUF.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}

		$link->close();
		$accion	= '';
	}

	if(isset($_POST['guardarValorUF'])){
		$fechaUF	= $_POST['fechaUF'];
		$valorUF 	= $_POST['valorUF'];
		$Moneda 	= $_POST['Moneda'];
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Neto	= $rowCot['NetoUF'] 	* $valorUF;
			if($rowCot['exentoIva']=='on'){
				$Iva	= 0;
				$Bruto	= $Neto;
			}else{
				$Iva	= intval($Neto * 0.19);
				$Bruto	= $Neto + $Iva;
			}


				$Iva	= intval($Neto * 0.19);
				$Bruto	= $Neto + $Iva;


			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Neto			='".$Neto.		"',";
			$actSQL.="Iva			='".$Iva.		"',";
			$actSQL.="Bruto			='".$Bruto.		"',";
			$actSQL.="fechaUF		='".$fechaUF.	"',";
			$actSQL.="valorUF		='".$valorUF.	"',";
			$actSQL.="Moneda		='".$Moneda.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);

			$bddCot=$link->query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Desc");
			if($rowdCot=mysqli_fetch_array($bddCot)){
				$tLin = $rowdCot['nLin'];
			}

			for($nLin=1; $nLin <= $tLin; $nLin++){
				$bddCot=$link->query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");
				if($rowdCot=mysqli_fetch_array($bddCot)){
					$unitarioP	= round(($rowdCot['unitarioUF'] 	* $valorUF),0);
					$Neto		= $rowdCot['NetoUF'] 	* $valorUF;
					if($rowCot['exentoIva']=='on'){
						$Iva 	= 0;
						$Bruto 	= $Neto;
					}else{
						$Iva		= intval($Neto * 0.19);
						$Bruto		= $Neto + $Iva;
					}


						$Iva		= intval($Neto * 0.19);
						$Bruto		= $Neto + $Iva;

					$actSQL="UPDATE dCotizacion SET ";
					$actSQL.="unitarioP	='".$unitarioP.		"',";
					$actSQL.="Neto		='".$Neto.			"',";
					$actSQL.="Iva		='".$Iva.			"',";
					$actSQL.="Bruto		='".$Bruto.			"'";
					$actSQL.="WHERE CAM	= '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'";
					$bddCot=$link->query($actSQL);
				}
			}
		}
		$link->close();
	}
	
	if(isset($_POST['guardarServicio'])){
		$Cantidad 	= $_POST['Cantidad'];
		$nServicio	= $_POST['nServicio'];
		$ValorUF 	= $_POST['ValorUF'];
		$Total 		= $_POST['Total'];
		$NetoUFDet	= $_POST['Total'];
		$nLin 		= $_POST['nLin'];

		if($Total){
			
			$IvaUF		= 0;
			
			$NetoUF 	= $Total;
			$IvaUF		= round($NetoUF * .19,2);
			$TotalUF	= $NetoUF + $IvaUF;
			
			$link=Conectarse();
			$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$Moneda 	= 'U';
				if($rowCot['Moneda']){
					$Moneda 	= $rowCot['Moneda'];
				}
				$unitarioUF	= $ValorUF;
				$unitarioP	= round($ValorUF * $rowCot['valorUF']);
					
				//$NetoPesos	= intval($NetoUF * $rowCot[valorUF]);
				$NetoPesos	= intval($Cantidad * $unitarioP);
				if($rowCot['exentoIva']=='on'){
					$IvaPesos	= 0;
					$BrutoPesos	= $NetoPesos;
					
					$IvaUf = 0;
					$TotalUF = $NetoUF;
				}else{
					$IvaPesos	= intval($NetoPesos * 0.19);
					$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);
				}

					$IvaPesos	= intval($NetoPesos * 0.19);
					$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);


				if($nLin == 0){
					$bddCot=$link->query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Desc");
					if($rowdCot=mysqli_fetch_array($bddCot)){
						$nLin = $rowdCot['nLin']+1;
					}else{
						$nLin = 1;
					}
				}

				$bddCot=$link->query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");
				if($rowdCot=mysqli_fetch_array($bddCot)){
					$actSQL="UPDATE dCotizacion SET ";
					$actSQL.="Cantidad		='".$Cantidad.			"',";
					$actSQL.="nServicio		='".$nServicio.			"',";
					$actSQL.="unitarioUF	='".$ValorUF.			"',";
					$actSQL.="unitarioP		='".$unitarioP.			"',";
					$actSQL.="Neto			='".$NetoPesos.			"',";
					$actSQL.="Iva			='".$IvaPesos.			"',";
					$actSQL.="Bruto			='".$BrutoPesos.		"',";
					$actSQL.="NetoUF		='".$NetoUF.			"',";
					$actSQL.="IvaUF			='".$IvaUF.				"',";
					$actSQL.="TotalUF		='".$TotalUF.			"'";
					$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'";
					$bddCot=$link->query($actSQL);
				}else{
					$link->query("insert into dCotizacion(	CAM,
															Rev,
															Cta,
															nLin,
															Cantidad,
															nServicio,
															unitarioUF,
															unitarioP,
															Neto,
															Iva,
															Bruto,
															NetoUF,
															IvaUF,
															TotalUF
															) 
												values 	(	'$CAM',
															'$Rev',
															'$Cta',
															'$nLin',
															'$Cantidad',
															'$nServicio',
															'$ValorUF',
															'$unitarioP',
															'$NetoPesos',
															'$IvaPesos',
															'$BrutoPesos',
															'$NetoUF',
															'$IvaUF',
															'$TotalUF'
					)");
				}							

				$NetoUF	= 0;
				$NetoP	= 0;
				
				$bddCot=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
				if($rowdCot=mysqli_fetch_array($bddCot)){
					do{
						$NetoUF += $rowdCot['NetoUF'];
						$NetoP 	+= $rowdCot['Neto'];
					}while ($rowdCot=mysqli_fetch_array($bddCot));
				}
				
				$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
				if($rowCot=mysqli_fetch_array($bdCot)){
					$pDescuento = $rowCot['pDescuento'];
					$vDscto 	= intval($NetoUF * $pDescuento)/100;

					$Neto 	= $NetoP *((100-$pDescuento)/100);
					if($rowCot['exentoIva']=='on'){
						$Iva	= 0;
						$Bruto	= $Neto;
						
						$IvaUF	= 0;
						$NetoUF = $BrutoUF;
					}else{
						$Iva	= $Neto * 0.19;
						$Bruto	= round($Neto,0) + round($Iva,0);
					}
					
						$Iva	= $Neto * 0.19;
						$Bruto	= round($Neto,0) + round($Iva,0);


					$NetoUF		= $NetoUF - $vDscto;
					if($rowCot['exentoIva']=='on'){
						$IvaUF		= 0;
						$TotalUF	= $NetoUF;
					}else{
						$IvaUF		= round($NetoUF * 0.19,2);
						$TotalUF	= $NetoUF + $IvaUF;
					}
								
					$actSQL="UPDATE Cotizaciones SET ";
					$actSQL.="pDescuento	='".$pDescuento."',";
					$actSQL.="Moneda		='".$Moneda.	"',";
					$actSQL.="Neto			='".$Neto.		"',";
					$actSQL.="Iva			='".$Iva.		"',";
					$actSQL.="Bruto			='".$Bruto.		"',";
					$actSQL.="NetoUF		='".$NetoUF.	"',";
					$actSQL.="IvaUF			='".$IvaUF.		"',";
					$actSQL.="BrutoUF		='".$TotalUF.	"'";
					$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
					$bdCot=$link->query($actSQL);
				}

			}
			$link->close();
			$accion = '';
		}else{
			echo '
				<script>
					alert("Debe ingresar la Cantidad de Servicios...");
				</script>
			';
		}
	}
	if(isset($_POST['confirmarGuardar'])){
		if($_POST['CAM']==0){
			$CAM = 0;
			while ($CAM == 0){
			
				$link=Conectarse();
				$bdCot=$link->query("Select * From Cotizaciones Order By CAM Desc");
				if($rowCot=mysqli_fetch_array($bdCot)){
					$CAM = $rowCot['CAM'] + 1;
				}				
				$link->close();
				
			}
		}else{
			if(isset($_POST['CAM'])) { $CAM = $_POST['CAM']; }
		}
		$exentoIva = '';
		
		if(isset($_POST['Rev'])) 				{ $Rev 			 	= $_POST['Rev'];				}
		if(isset($_POST['Cta'])) 				{ $Cta 			 	= $_POST['Cta'];				}
		if(isset($_POST['fechaCotizacion'])) 	{ $fechaCotizacion 	= $_POST['fechaCotizacion'];	}
		if(isset($_POST['usrCotizador'])) 		{ $usrCotizador	 	= $_POST['usrCotizador'];		}
		if(isset($_POST['Cliente'])) 			{ $Cliente 		 	= $_POST['Cliente'];			}
		if(isset($_POST['nContacto'])) 			{ $nContacto 		= $_POST['nContacto'];			}
		if(isset($_POST['Atencion'])) 			{ $Atencion 		= $_POST['Atencion'];			}
		if(isset($_POST['correoAtencion'])) 	{ $correoAtencion  	= $_POST['correoAtencion'];		}
		if(isset($_POST['Telefono'])) 			{ $Telefono  		= $_POST['Telefono'];			}
		if(isset($_POST['Descripcion'])) 		{ $Descripcion	 	= $_POST['Descripcion'];		}
		if(isset($_POST['Observacion'])) 		{ $Observacion	 	= $_POST['Observacion'];		}
		if(isset($_POST['obsServicios'])) 		{ $obsServicios	 	= $_POST['obsServicios'];		}
		if(isset($_POST['Validez'])) 			{ $Validez		 	= $_POST['Validez'];			}
		if(isset($_POST['dHabiles'])) 			{ $dHabiles		 	= $_POST['dHabiles'];			}
		if(isset($_POST['exentoIva'])) 			{ $exentoIva		= $_POST['exentoIva']; 			}
		if(isset($_POST['tpEnsayo'])) 			{ $tpEnsayo			= $_POST['tpEnsayo']; 			}
		if(isset($_POST['OFE'])) 				{ $OFE				= $_POST['OFE']; 				}
		
		$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $fechaCotizacion ) );
		$proxRecordatorio 	= date ( 'Y-m-d' , $proxRecordatorio );

		$Cta = 0;
		if($oCtaCte=='on'){
			$Cta = 0;
		}

		$link=Conectarse();

		$bdEnc=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowEnc=mysqli_fetch_array($bdEnc)){
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RutCli			='".$Cliente.			"',";
			$actSQL.="Rev				='".$Rev.				"',";
			$actSQL.="Cta				='".$Cta.				"',";
			$actSQL.="fechaCotizacion	='".$fechaCotizacion.	"',";
			$actSQL.="proxRecordatorio	='".$proxRecordatorio.	"',";
			$actSQL.="Descripcion		='".$Descripcion.		"',";
			$actSQL.="Observacion		='".$Observacion.		"',";
			$actSQL.="obsServicios		='".$obsServicios.		"',";
			$actSQL.="usrCotizador		='".$usrCotizador.		"',";
			$actSQL.="Validez			='".$Validez.			"',";
			$actSQL.="dHabiles			='".$dHabiles.			"',";
			$actSQL.="nContacto			='".$nContacto.			"',";
			$actSQL.="Atencion			='".$Atencion.			"',";
			$actSQL.="exentoIva			='".$exentoIva.			"',";
			$actSQL.="tpEnsayo			='".$tpEnsayo.			"',";
			$actSQL.="OFE				='".$OFE.				"',";
			$actSQL.="correoAtencion	='".$correoAtencion.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdEnc=$link->query($actSQL);
			$accion = 'Actualizar';
		}else{
			$link->query("insert into Cotizaciones(	CAM,
													Rev,
													Cta,
													RutCli,
													nContacto,
													Atencion,
													correoAtencion,
													fechaCotizacion,
													Descripcion,
													Observacion,
													obsServicios,
													usrCotizador,
													Validez,
													exentoIva,
													tpEnsayo,
													OFE,
													dHabiles
													) 
										values 	(	'$CAM',
													'$Rev',
													'$Cta',
													'$Cliente',
													'$nContacto',
													'$Atencion',
													'$correoAtencion',
													'$fechaCotizacion',
													'$Descripcion',
													'$Observacion',
													'$obsServicios',
													'$usrCotizador',
													'$Validez',
													'$exentoIva',
													'$tpEnsayo',
													'$OFE',
													'$dHabiles'
			)");
			$accion	= '';
		}
		if($OFE == 'on'){
			$bdOFE=$link->query("Select * From propuestaeconomica Where OFE = '".$CAM."'");
			if($rowOFE=mysqli_fetch_array($bdOFE)){
				$actSQL="UPDATE propuestaeconomica SET ";
				$actSQL.="usrElaborado	 	='".$usrCotizador.		"',";
				$actSQL.="fechaElaboracion 	='".$fechaCotizacion.	"',";
				$actSQL.="RutCli 			='".$Cliente.			"',";
				$actSQL.="nContacto			='".$nContacto.			"',";
				$actSQL.="fechaOferta		='".$fechaCotizacion.	"'";
				$actSQL.="WHERE OFE 		= '".$CAM."'";
				$bdOFE=$link->query($actSQL);
			}else{

				$link->query("insert into propuestaeconomica(
																OFE,
																usrElaborado,
																fechaElaboracion,
																CAM,
																RutCli,
																nContacto,
																fechaOferta
															)	 
													values 	(	
																'$CAM',
																'$usrCotizador',
																'$fechaCotizacion',
																'$CAM',
																'$Cliente',
																'$nContacto',
																'$fechaCotizacion'
															)");
														
			}
		}
		$link->close();
		$accion	= '';
	}
	if($CAM){
		$link=Conectarse();
		$NetoUF = 0;
		$bdCAM=$link->query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By Rev Asc");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			do{
				$NetoUF += $rowCAM['NetoUF'];
			}while ($rowCAM=mysqli_fetch_array($bdCAM));
		}
		
		
		$bdCAM=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
				$Rev 			 	= $rowCAM['Rev'];
				$Cta 			 	= $rowCAM['Cta'];
				$fechaCotizacion 	= $rowCAM['fechaCotizacion'];
				$usrCotizador	 	= $rowCAM['usrCotizador'];
				$Cliente 		 	= $rowCAM['RutCli'];
				$nContacto 		 	= $rowCAM['nContacto'];
				$Atencion 		 	= $rowCAM['Atencion'];
				$correoAtencion  	= $rowCAM['correoAtencion'];
				$Descripcion	 	= $rowCAM['Descripcion'];
				$Observacion	 	= $rowCAM['Observacion'];
				$obsServicios	 	= $rowCAM['obsServicios'];
				$EstadoCot		 	= $rowCAM['Estado'];
				$Validez		 	= $rowCAM['Validez'];
				$dHabiles		 	= $rowCAM['dHabiles'];
				$enviadoCorreo	 	= $rowCAM['enviadoCorreo'];
				$pDescuento	 	 	= $rowCAM['pDescuento'];
				$fechaEnvio		 	= $rowCAM['fechaEnvio'];
				$NetoUF		 	 	= $rowCAM['NetoUF'];
				$IvaUF		 	 	= $rowCAM['IvaUF'];
				$BrutoUF		 	= $rowCAM['BrutoUF'];
				$Moneda		 	 	= $rowCAM['Moneda'];
				$exentoIva	 	 	= $rowCAM['exentoIva'];
				$tpEnsayo	 	 	= $rowCAM['tpEnsayo'];
				$OFE	 	 	 	= $rowCAM['OFE'];
				$correoAutomatico 	= $rowCAM['correoAutomatico'];
		}		
		$link->close();
	}	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cotizaciones</title>

	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="../jquery/libs/jquery/1/jquery.min.js"></script>	

	<link href="stylesTpv.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script type="text/javascript" src="../angular/angular-route.min.js"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
	<script>
	  $(function() {
		$( "#accordion" ).accordion({
		  collapsible: true,
		  icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
		  active: false
		});
	  });
	</script>
	<script>
	function envioExitoso(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev" 	: Rev,
			"Cta" 	: Cta
		};
		//alert(CAM);
		$.ajax({
			data: parametros,
			url: 'eExito.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function realizaProceso(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev"	: Rev,
			"Cta" 	: Cta
		};
		//alert(Cta);
		$.ajax({
			data: parametros,
			url: 'verDetCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}

	function depliegaContacto(CAM){
		var parametros = {
			"CAM" 	: CAM
		};
		//alert(CAM);
		$.ajax({
			data: parametros,
			url: 'mostrarContacto.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}

	function datosContactos(Cliente, Atencion, nContacto){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion,
			"nContacto"	: nContacto
		};
		//alert(Atencion);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}

	function asociarSituacion(EstadoCot){
		var parametros = {
			"EstadoCot" 	: EstadoCot
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'mostrarEstadosCAM.php',
			type: 'get',
			success: function (response) {
				$("#activaSituaciones").html(response);
			}
		});
	}

	function enviarCotizacion(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev" 	: Rev,
			"Cta" 	: Cta
		};
		//alert(Rev);
		//header("Location: formularios/iCAM.php?CAM=$CAM&Rev=$Rev&Cta=$Cta");
			//url: 'enviarCotizaciones.php',
		$.ajax({
			data: parametros,
			url: 'formularios/iCAM.php',
			type: 'get',
			success: function (response) {
				$("#cajaDeEnvio").html(response);
			}
		});
	}

	function abrirCarro(CAM, Rev, Cta, nServicio, nLin, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"nServicio"	: nServicio,
			"nLin"		: nLin,
			"accion"	: accion
		};
		//alert(nServicio);
		$.ajax({
			data: parametros,
			url: 'calculaServicio.php',
			type: 'get',
			success: function (response) {
				$("#cajaServicios").html(response);
			}
		});
	}

	function calculaDescuento(CAM, Rev, Cta, pDescuento){
		var parametros = {
			"CAM" 			: CAM,
			"Rev" 			: Rev,
			"Cta" 			: Cta,
			"pDescuento"	: pDescuento
		};
		//alert(pDescuento);
		$.ajax({
			data: parametros,
			url: 'calculaDescuento.php',
			type: 'get',
			success: function (response) {
				$("#resultadoDescuento").html(response);
			}
		});
	}


	</script>

	<script>
	function cDescuentoSSSSSSS()
	{
		var x=document.getElementById("pDescuento");
			var vpDescuento	= $("#pDescuento").val();
			alert(vpDescuento);
			var vCantidad	= $("#Cantidad").val();
			var vValorUF	= $("#ValorUF").val();
			var vTotal		= vCantidad * vValorUF;
					
			document.form.Total.value 		= 0;// vTotal;
	}

	function cambiarMoneda(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'segCAMvalores.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function nominadeServicios(CAM, Cta, buscar){
		var parametros = {
			"CAM"		: CAM,
			"Cta"		: Cta,
			"buscar"	: buscar
		};
		//alert(buscar);
		$.ajax({
			data: parametros,
			url: 'mostrarServicios.php',
			type: 'get',
			success: function (response) {
				$("#mostrarListaServicios").html(response);
			}
		});
	}
	
	</script>

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
		.default-color:hover {
		  opacity 			: 0.5;
		  color 			: #000;
		}
	</style>



</head>

<body ng-app="myApp" ng-controller="CtrlCotizaciones" ng-cloak>
	<?php include('head.php'); ?>
	<input ng-model="CAM" type="hidden" ng-init="loadCAM('<?php echo $CAM; ?>')">

	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item active">
	          			<a class="nav-link fas fa-paste" href="plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<?php
	        			if($_GET['accion'] == 'Borrar'){
	        				?>
			        		<li class="nav-item active" ng-if="CAM > 0">
			          			<a class="nav-link fas fa-trash-alt" 
			          					href="#" 
			          					ng-click="accionBorrar('<?php echo $CAM;?>')" 
			          					title="Confirmar Borrar">
			          			 		Borrar CAM <?php echo $CAM;?>
			          			</a>
			        		</li>

	        				<?php
	        			}else{
	        				?>
			        		<li class="nav-item active" ng-if="CAM > 0">
			          			<a class="nav-link fas fa-at" href="formularios/subirEnviarPdf.php?CAM=<?php echo $CAM;?>&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" title="Enviar Cotización">
			          			 Enviar
			          			</a>
			        		</li>

			        		<li class="nav-item active" ng-if="CAM > 0">
<!--
			          			<a 	class="nav-link fas fa-at" 
			          				href="#" 
			          				ng-click="descargaCotizacion()"
			          				title="Descargar Cotización">
			          			 Descarga
			          			</a>
-->
			          			<a class="nav-link fas fa-at" href="formularios/iCAM.php?CAM={{CAM}}&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" title="Descargar Cotización">
			          			 Descarga
			          			</a>
			        		</li>
			        		<li class="nav-item active"  ng-if="CAM > 0 && OFE == 'on'">
			          			<a class="nav-link far fa-edit" href="ofe/index.php?OFE=<?php echo $CAM; ?>&accion=OFE" title="Oferta Económica"> OFE</a>
			        		</li>
	        				<?php
	        			}
	        		?>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>
	<!-- <input ng-model="CAM" type="hidden" ng-init="CAM='<?php echo $CAM; ?>'"> -->
	<div class="row bg-info text-white" style="padding: 10px;">
		<div class="col-12">
			<h5>FORMULARIO DE COTIZACIÓN <span ng-if="CAM > 0"><b>{{CAM}} </b></span></h5>
		</div>
	</div>
<!--	<form ng-model="FormularioId" name="FormularioId" ng-show="configuracionInicial" novalidate> -->
	<form ng-model="FormularioId" name="FormularioId" novalidate>
	<div class="row" style="padding: 10px;">
		<div class="col-6">
			<div class="card">
				<div class="card-header">Identificación del Cliente</div>
			  	<div class="card-body">
				  	<div class="form-group" ng-if="CAM == 0 && CAM > 0">
				    	<label for="Cliente">Filtrar Cliente: </label>
				    	<input 	ng-model="bCliente" 
				    			class="form-control" 
				    			type="text">
				    </div>
				  	<div class="form-group">
				    	<label for="Cliente">Cliente:  </label>
				    	
	            		<select ng-model="Cliente" class="form-control" ng-change="cargarContactos()" required>
	                		<option value="">Selecionar Cliente</option>
	                  		<option ng-repeat="cli in dataClientes | filter: bCliente" value="{{cli.Cliente}}">
	                    	{{cli.Cliente}}
	                  		</option>
	              		</select>
						<div class="alert alert-danger" ng-show="showCliente" style="margin-top: 5px;" ng-if="Cliente == ''">
	    					<strong>Precaución!</strong> Debe seleccionar un cliente.
	  					</div>	                

	              	</div>

				  	<div class="form-group" ng-show="showContacto">
				    	<label for="Contacto">Contacto:  </label>
	                	<select ng-model="Contacto" class="form-control" ng-change="buscanContacto()" style="margin-top: 10px;" required>
	                  		<option value="" selected>Seleccionar Contacto</option>
	                  		<option ng-repeat="cl in dataContactos">{{cl.Contacto}}</option>
	                	</select>
	                	{{resCli}}  {{errors}}           
	                </div>
					<div class="alert alert-danger" ng-show="showContactoError" style="margin-top: 5px;" ng-if="Contacto == ''">
						<div class="row">
							<div class="col-6">
    							<strong>Precaución!</strong> Cliente sin contacto.
    						</div>
    						<div class="col-6">
		          				<button class="btn btn-success" ng-click="guardarConfiguracion()">Crear Contacto</button>
		          			</div>
		          		</div>
  					</div>	                
			  	</div> 
			</div>
		</div>
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-5">
							Datos de la Cotización
						</div>
						<div class="col-md-1">
							<button class="btn btn-info" ng-click="activaDesactivaDatos()"> {{btnMuestraDatosCAM}} </button>
						</div>
					</div>
				</div>
			  	<div class="card-body" ng-show="datCAM">

			  		<div class="row">
			  			<div class="col-3">
						  <div class="form-group">
				    			<label for="fechaCotizacion">Fecha Cotización:</label>
				    			<input type="date" class="form-control" ng-model="fechaCotizacion">
				    		</div>
				  		</div>
				  		<input ng-model="usrCotizador" ng-init="usrCotizador='<?php echo $_SESSION['usr']; ?>'" type="hidden">
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="usrCotizador">Cotizador CAM:</label>
				            	<select ng-model="usrCotizador" name="usrCotizador" class="form-control" required >
				                	<option value="">Cotizado por...</option>
				                  	<option ng-repeat="usr in data | filter:'on'" value="{{usr.usr}}">
				                    	{{usr.usr}}
				                  	</option>
				              	</select>
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="Validez">Validez Cotización:</label>
				    			<input type="text" class="form-control" ng-model="Validez" name="Validez" required>
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="dHabiles">Días Habiles:</label>
				    			<input type="text" class="form-control" name="dHabiles" ng-model="dHabiles" required>
				    		</div>
				  		</div>

				  	</div>

			  		<div class="row">
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="fechaCotizacion">Exenta: </label>
				    			<input type="checkbox" class="form-control" ng-model="exentoIva" ng-change="cambioExenta()">
				    		</div>

				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="tpEnsayo">Tipo Informe:</label>
				            	<select ng-model="tpEnsayo" class="form-control">
				                  	<option ng-repeat="tpEnsayo in tipoEnsayo" value="{{tpEnsayo.codEnsayo}}">
				                    	{{tpEnsayo.descripcion}}
				                  	</option>
				              	</select>
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="OFE">Oferta Económica:</label>
				            	<select ng-model="OFE" class="form-control">
				                	<option value="">Oferta</option>
				                  	<option ng-repeat="OFE in tipoOferta" value="{{OFE.codOferta}}">
				                    	{{OFE.descripcion}}
				                  	</option>
				              	</select>
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="Moneda">Moneda:</label>
				            	<select ng-model="Moneda" class="form-control" 
				            			ng-change="activarExentoIva()">
				                  	<option ng-repeat="Mon in tipoMoneda" value="{{Mon.codMoneda}}">
				                    	{{Mon.descripcion}}
				                  	</option>
				              	</select>
				    		</div>
				  		</div>

				  	</div>

			  		<div class="row">
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="fechaUF">Fecha UF:</label>
				    			<input type="date" name="fechaUF" ng-disabled="Moneda == 'D'" class="form-control" ng-model="fechaUF">
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="valorUF">Valor UF:</label>
				    			<input type="text" ng-disabled="Moneda == 'D'" class="form-control" ng-model="valorUF" name="valorUF" ng-change="recalcularUnitario(valorUF)">

				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="valorUS">Valor Dollar:</label>
				    			<input type="text" ng-disabled="Moneda == 'U' || Moneda == 'P' || Moneda == ''" class="form-control" ng-model="valorUS" name="valorUS" ng-change="recalcularUnitario(valorUS)">
				    		</div>
				  		</div>
			  			<div class="col-3">
				  			<div class="form-group">
				    			<label for="pDescuento">% Descuento:</label>
				    			
				    			<input type="text" size="3" maxlength="3" class="form-control" ng-model="pDescuento" name="pDescuento" ng-change="valPorcentaje()">
				    		</div>
				  		</div>

				  	</div>
			  		<div class="row">
			  			<div class="col-12">
					  		<div class="form-group">
					    		<label for="Descripcion">Descripción CAM/RAM:</label>
						  		<div class="col-12">
						  			<textarea 	ng-model="Descripcion" 
						  						name="Descripcion" 
						  						class="form-control">
						  			</textarea> 
						  		</div>
						  	</div>
						</div>
					</div>				  	
			  		<div class="row">
			  			<div class="col-12">
					  		<div class="form-group">
					    		<label for="obsServicios">Observación Servicios:</label>
						  		<div class="col-12">
						  			<textarea 	ng-model="obsServicios" 
						  						name="obsServicios" 
						  						class="form-control">
						  			</textarea> 
						  		</div>
						  	</div>
						</div>
					</div>				  	
			  		<div class="row">
			  			<div class="col-12">
					  		<div class="form-group">
					    		<label for="Observacion">Observación:</label>
						  		<div class="col-12">
						  			<textarea 	ng-model="Observacion" 
						  						name="Observacion" 
						  						class="form-control">
						  			</textarea> 
						  		</div>
						  	</div>
						</div>
					</div>				  	
					  
			  	</div> 

			  	<div class="card-footer"  ng-show="datCAM">
			  		<div ng-if="CAM > 0">

					  <button class="btn btn-success" ng-click="guardarConfiguracion(FormularioId)">Actualizar</button>

	          			<a 	class="btn btn-primary" 
	          				href="formularios/iCAM.php?CAM={{CAM}}&Rev=<?php echo $Rev;?>&Cta=<?php echo $Cta;?>" 
	          				title="Descargar Cotización">
			          			 Descarga
			          	</a>

<!--
			  			<button class="btn btn-success" 
			  					ng-click="descargaCotizacion()">
			  				Descargar
			  			</button>
-->

			  		</div>
			  		<div>
			  			<button class="btn btn-success" ng-click="guardarConfiguracion(FormularioId)" ng-show="btnCreaCot" ng-if="CAM == 0">Crear Cotización</button>
						<div class="alert alert-warning" ng-show="errCreaCot" style="margin-top: 5px;" ng-if="Cliente == ''">
	    					<strong>Información!</strong> Complete todos los datos del formulario.
	  					</div>	                

			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>

	<div ng-if="CAM > 0">
		
		<div ng-if="Moneda == 'U'">
			<?php include_once('itemsDetalle.php'); ?>
		</div>
		<div ng-if="Moneda == 'P'">
			<?php include_once('itemsDetallePesos.php'); ?>
		</div>
		<div ng-if="Moneda == 'D'">
			<?php include_once('itemsDetalleDollar.php'); ?>
		</div>
	</div>
			<?php
			if($accion == 'AgregarServ' or $accion == 'ActualizarServ' or $accion == 'BorrarServ'){?>
				<script>
					var CAM 		= "<?php echo $CAM; 		?>" ;
					var Rev 		= "<?php echo $Rev; 		?>" ;
					var Cta 		= "<?php echo $Cta; 		?>" ;
					var nServicio 	= "<?php echo $nServicio; 	?>" ;
					var nLin 		= "<?php echo $nLin; 		?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					abrirCarro(CAM, Rev, Cta, nServicio, nLin, accion);
				</script>
				<?php
			}
			if(isset($_POST['confirmarEnvio'])){?>
				<script>
					var CAM = "<?php echo $CAM; ?>"; 
					var Rev = "<?php echo $Rev; ?>";
					var Cta = "<?php echo $Cta; ?>";
					envioExitoso(CAM, Rev, Cta);
				</script>
			<?php
			}
			?>
	
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="procesacotizacion.js"></script>
	
</body>
</html>
