<?php
	session_start(); 
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	if(isset($_GET[accion])) 	{	$accion 	= $_GET[accion]; 	}
	if(isset($_GET[Otam])) 		{	$Otam 		= $_GET[Otam]; 		}
	if(isset($_GET[CodInforme])){	$CodInforme	= $_GET[CodInforme];}

	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=mysql_query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		mysql_close($link);
	}

	if(isset($_GET[guardarIdOtam])){	
		$link=Conectarse();
		$bdOT=mysql_query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysql_fetch_array($bdOT)){
			$Estado 	= 'R';
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET[tpMuestra])) { $tpMuestra = $_GET[tpMuestra]; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=mysql_query($actSQL);

			$tm = explode('-',$Otam);
			if(substr($tm[1],0,1) == 'T'){ $tReg = 'regTraccion';; }
			if(substr($tm[1],0,1) == 'Q'){ $tReg = 'regQuimico';; 	}
			if(substr($tm[1],0,1) == 'C'){ $tReg = 'regCharpy';; 	}
			if(substr($tm[1],0,1) == 'D'){ $tReg = 'regDureza';; 	}
			
			if(isset($_GET[aIni])) 			{ $aIni 	 		= $_GET[aIni]; 			}
			if(isset($_GET[cFlu])) 			{ $cFlu 	 		= $_GET[cFlu]; 			}
			if(isset($_GET[cMax])) 			{ $cMax 	 		= $_GET[cMax]; 			}
			if(isset($_GET[tFlu])) 			{ $tFlu 	 		= $_GET[tFlu]; 			}
			if(isset($_GET[tMax])) 			{ $tMax 	 		= $_GET[tMax]; 			}
			if(isset($_GET[aSob])) 			{ $aSob 	 		= $_GET[aSob]; 			}
			if(isset($_GET[rAre])) 			{ $rAre 	 		= $_GET[rAre]; 			}
			if(isset($_GET[Espesor])) 		{ $Espesor 	 		= $_GET[Espesor]; 		}
			if(isset($_GET[Ancho])) 		{ $Ancho 	 		= $_GET[Ancho]; 		}
			if(isset($_GET[Li])) 			{ $Li 	 			= $_GET[Li]; 			}
			if(isset($_GET[Lf])) 			{ $Lf 	 			= $_GET[Lf]; 			}
			if(isset($_GET[Di])) 			{ $Di 	 			= $_GET[Di]; 			}
			if(isset($_GET[Df])) 			{ $Df 	 			= $_GET[Df]; 			}

			if(isset($_GET[cC])) { $cC 	 = $_GET[cC]; }
			if(isset($_GET[cSi])){ $cSi  = $_GET[cSi];}
			if(isset($_GET[cMn])){ $cMn  = $_GET[cMn];}
			if(isset($_GET[cP])) { $cP 	 = $_GET[cP]; }
			if(isset($_GET[cS])) { $cS 	 = $_GET[cS]; }
			if(isset($_GET[cCr])){ $cCr  = $_GET[cCr];}
			if(isset($_GET[cNi])){ $cNi  = $_GET[cNi];}
			if(isset($_GET[cMo])){ $cMo  = $_GET[cMo];}
			if(isset($_GET[cAl])){ $cAl  = $_GET[cAl];}
			if(isset($_GET[cCu])){ $cCu  = $_GET[cCu];}
			if(isset($_GET[cCo])){ $cCo  = $_GET[cCo];}
			if(isset($_GET[cTi])){ $cTi  = $_GET[cTi];}
			if(isset($_GET[cNb])){ $cNb  = $_GET[cNb];}
			if(isset($_GET[cV])) { $cV   = $_GET[cV]; }
			if(isset($_GET[cW])) { $cW   = $_GET[cW]; }
			if(isset($_GET[cPb])){ $cPb  = $_GET[cPb];}
			if(isset($_GET[cB])) { $cB   = $_GET[cB]; }
			if(isset($_GET[cSb])){ $cSb  = $_GET[cSb];}
			if(isset($_GET[cSn])){ $cSn  = $_GET[cSn];}
			if(isset($_GET[cZn])){ $cZn  = $_GET[cZn];}
			if(isset($_GET[cAs])){ $cAs  = $_GET[cAs];}
			if(isset($_GET[cBi])){ $cBi  = $_GET[cBi];}
			if(isset($_GET[cTa])){ $cTa  = $_GET[cTa];}
			if(isset($_GET[cCa])){ $cCa  = $_GET[cCa];}
			if(isset($_GET[cCe])){ $cCe  = $_GET[cCe];}
			if(isset($_GET[cZr])){ $cZr  = $_GET[cZr];}
			if(isset($_GET[cLa])){ $cLa  = $_GET[cLa];}
			if(isset($_GET[cSe])){ $cSe  = $_GET[cSe];}
			if(isset($_GET[cN])) { $cN   = $_GET[cN]; }
			if(isset($_GET[cFe])){ $cFe  = $_GET[cFe];}
			if(isset($_GET[cMg])){ $cMg  = $_GET[cMg];}
			if(isset($_GET[cTe])){ $cTe  = $_GET[cTe];}
			if(isset($_GET[cCd])){ $cCd  = $_GET[cCd];}
			if(isset($_GET[cAg])){ $cAg  = $_GET[cAg];}
			if(isset($_GET[cAu])){ $cAu  = $_GET[cAu];}
			if(isset($_GET[cAi])){ $cAi  = $_GET[cAi];}

			if(isset($_GET[Ind])){ $Ind  = $_GET[Ind];}
			
			if(substr($tm[1],0,1) == 'C'){
				for($in=1; $in<=$Ind; $in++) { 
					$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
					$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
					if(isset($_GET[$el_nImpacto]))		{ $el_nImpacto		= $_GET[$el_nImpacto];		}
					if(isset($_GET[$el_vImpacto]))		{ $el_vImpacto		= $_GET[$el_vImpacto];		}

					$link=Conectarse();
					$bdRegCh=mysql_query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
					if($rowRegCh=mysql_fetch_array($bdRegCh)){
						$actSQL="UPDATE regCharpy SET ";
						$actSQL.="vImpacto 	   ='".$el_vImpacto.	"'";
						$actSQL.="WHERE idItem = '".$Otam."' and nImpacto = '".$in."'";
						$bdRegCh=mysql_query($actSQL);
					}else{
						mysql_query("insert into regCharpy(
																CodInforme,
																idItem,
																tpMuestra,
																nImpacto,
																vImpacto
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$in',
																'$el_vImpacto'
								)",
						$link);
					}
					mysql_close($link);
				}
			}

			if(substr($tm[1],0,1) == 'D'){
				for($in=1; $in<=$Ind; $in++) { 
					$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
					$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
					if(isset($_GET[$el_nIndenta]))		{ $el_nIndenta		= $_GET[$el_nIndenta];		}
					if(isset($_GET[$el_vIndenta]))		{ $el_vIndenta		= $_GET[$el_vIndenta];		}

					$link=Conectarse();
					$bdRegDo=mysql_query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
					if($rowRegDo=mysql_fetch_array($bdRegDo)){
						$actSQL="UPDATE regDoblado SET ";
						$actSQL.="vIndenta 		='".$el_vIndenta.	"'";
						$actSQL.="WHERE idItem 	= '".$Otam."' and nIndenta = '".$in."'";
						$bdRegDo=mysql_query($actSQL);
					}else{
						mysql_query("insert into regDoblado(
																CodInforme,
																idItem,
																tpMuestra,
																nIndenta,
																vIndenta
																) 
														values 	(	
																'$CodInforme',
																'$Otam',
																'$tpMuestra',
																'$in',
																'$el_vIndenta'
								)",
						$link);
					}
					mysql_close($link);
				}
			}

			if(substr($tm[1],0,1) == 'T' or substr($tm[1],0,1) == 'Q'){
			
				$bdRdM=mysql_query("Select * From $tReg Where idItem = '".$Otam."'");
				if($rowRdM=mysql_fetch_array($bdRdM)){
					/* Cálculo de Tracción*/
					$g 	= 9.80665;
					$pi = 3.1416;
					
					if($tpMuestra == 'Pl'){
						$aIni 	= $Espesor * $Ancho;
						$aIni 	= number_format($aIni, 2, ',', '.');
						
						$cFlu	= (($tFlu * $Espesor * $Ancho) / $g);
						$cFlu 	= number_format($cFlu, 0, ',', '.');
						
						$tMax	= (($cMax / ($Espesor * $Ancho)) * $g);
						$tMax 	= number_format($tMax, 0, ',', '.');
						
						$aSob	= ((($Lf - $Li) / $Li) * 100);
						$aSob 	= number_format($aSob, 2, ',', '.');
					}
					if($tpMuestra == 'Re'){
						$aIni 	= (pow($Di, 2) / 4) * $pi;
						$aIni 	= number_format($aIni, 2, ',', '.');
						
						$cFlu	= ($tFlu * ((pow($Di, 2) / 4) * $pi)) / $g;
						$cFlu 	= number_format($cFlu, 0, ',', '.');
						
						$tMax	= ((4 * $cMax) / (pow($Di, 2) * $pi)) * $g ;
						$tMax 	= number_format($tMax, 0, ',', '.');
						
						$aSob	= ((($Lf - $Li) / $Li) * 100);
						$aSob 	= number_format($aSob, 0, ',', '.');
						
						$rAre	= (((pow($Di, 2) - pow($Df, 2)) / pow($Di, 2)) * 100);
						$rAre 	= number_format($rAre, 2, ',', '.');
					}
					/* Fin Cálculo de Tracción*/
					if(substr($tm[1],0,1) == 'T'){
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra	='".$tpMuestra.	"',";
						$actSQL.="Espesor	='".$Espesor.	"',";
						$actSQL.="Ancho		='".$Ancho.		"',";
						$actSQL.="Li		='".$Li.		"',";
						$actSQL.="Lf		='".$Lf.		"',";
						$actSQL.="Di		='".$Di.		"',";
						$actSQL.="Df		='".$Df.		"',";
						$actSQL.="aIni		='".$aIni.		"',";
						$actSQL.="cFlu		='".$cFlu.		"',";
						$actSQL.="cMax		='".$cMax.		"',";
						$actSQL.="tFlu		='".$tFlu.		"',";
						$actSQL.="tMax		='".$tMax.		"',";
						$actSQL.="aSob		='".$aSob.		"',";
						$actSQL.="rAre		='".$rAre.		"'";
						$actSQL.="WHERE idItem = '".$Otam."'";
						$bdRdM=mysql_query($actSQL);
					}
	
					if(substr($tm[1],0,1) == 'Q'){
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra	='".$tpMuestra.	"',";
						$actSQL.="cC		='".$cC.		"',";
						$actSQL.="cSi		='".$cSi.		"',";
						$actSQL.="cMn		='".$cMn.		"',";
						$actSQL.="cP		='".$cP.		"',";
						$actSQL.="cS		='".$cS.		"',";
						$actSQL.="cCr		='".$cCr.		"',";
						$actSQL.="cNi		='".$cNi.		"',";
						$actSQL.="cMo		='".$cMo.		"',";
						$actSQL.="cAl		='".$cAl.		"',";
						$actSQL.="cCu		='".$cCu.		"',";
						$actSQL.="cCo		='".$cCo.		"',";
						$actSQL.="cTi		='".$cTi.		"',";
						$actSQL.="cNb		='".$cNb.		"',";
						$actSQL.="cV		='".$cV.		"',";
						$actSQL.="cW		='".$cW.		"',";
						$actSQL.="cPb		='".$cPb.		"',";
						$actSQL.="cB		='".$cB.		"',";
						$actSQL.="cSb		='".$cSb.		"',";
						$actSQL.="cSn		='".$cSn.		"',";
						$actSQL.="cZn		='".$cZn.		"',";
						$actSQL.="cAs		='".$cAs.		"',";
						$actSQL.="cBi		='".$cBi.		"',";
						$actSQL.="cTa		='".$cTa.		"',";
						$actSQL.="cCa		='".$cCa.		"',";
						$actSQL.="cCe		='".$cCe.		"',";
						$actSQL.="cZr		='".$cZr.		"',";
						$actSQL.="cLa		='".$cLa.		"',";
						$actSQL.="cSe		='".$cSe.		"',";
						$actSQL.="cN		='".$cN.		"',";
						$actSQL.="cFe		='".$cFe.		"',";
						$actSQL.="cMg		='".$cMg.		"',";
						$actSQL.="cTe		='".$cTe.		"',";
						$actSQL.="cCd		='".$cCd.		"',";
						$actSQL.="cAg		='".$cAg.		"',";
						$actSQL.="cAu		='".$cAu.		"',";
						$actSQL.="cAi		='".$cAi.		"'";
						$actSQL.="WHERE idItem = '".$Otam."'";
						$bdRdM=mysql_query($actSQL);
					}
				}else{
				
					/* Inicio Guarda Tracción */
					
					if(substr($tm[1],0,1) == 'T'){
						mysql_query("insert into $tReg (
																idItem,
																tpMuestra,
																Espesor,
																Ancho,
																Li,
																Lf,
																Di,
																Df,
																aIni,
																cFlu,
																cMax,
																tFlu,
																tMax,
																aSob,
																rAre
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$Espesor',
																'$Ancho',
																'$Li',
																'$Lf',
																'$Di',
																'$Df',
																'$aIni',
																'$cFlu',
																'$cMax',
																'$tFlu',
																'$tMax',
																'$aSob',
																'$rAre'
																)",
						$link);
					}
					/* Fin Tracción */
	
					/* Inicio Químicos */
	
					if(substr($tm[1],0,1) == 'Q'){
						mysql_query("insert into $tReg (
																idItem,
																tpMuestra,
																cC,
																cSi,
																cMn,
																cP,
																cS,
																cCr,
																cNi,
																cMo,
																cAl,
																cCu,
																cCo,
																cTi,
																cNb,
																cV,
																cW,
																cPb,
																cB,
																cSb,
																cSn,
																cZn,
																cAs,
																cBi,
																cTa,
																cCa,
																cCe,
																cZr,
																cLa,
																cSe,
																cN,
																cFe,
																cMg,
																cTe,
																cCd,
																cAg,
																cAu,
																cAi
																) 
														values 	(	
																'$Otam',
																'$tpMuestra',
																'$cC',
																'$cSi',
																'$cMn',
																'$cP',
																'$cS',
																'$cCr',
																'$cNi',
																'$cMo',
																'$cAl',
																'$cCu',
																'$cCo',
																'$cTi',
																'$cNb',
																'$cV',
																'$cW',
																'$cPb',
																'$cB',
																'$cSb',
																'$cSn',
																'$cZn',
																'$cAs',
																'$cBi',
																'$cTa',
																'$cCa',
																'$cCe',
																'$cZr',
																'$cLa',
																'$cSe',
																'$cN',
																'$cFe',
																'$cMg',
																'$cTe',
																'$cCd',
																'$cAg',
																'$cAu',
																'$cAi'
																)",
						$link);
					}
					/* Fin Químico */
				}
				
				
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
<title>Taller Propiedades Mecánicas</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	


	<script>
	function realizaProceso(accion){
		var parametros = {
			"accion" 		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'mSolEnsayos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function registraOtams(Otam, accion){
		var parametros = {
			"Otam"			: Otam,
			"accion"		: accion
		};
		//alert(RAM);
		$.ajax({
			data: parametros,
			url: 'rValoresOtam.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
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
				<img src="../imagenes/talleres.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; ">
					<?php 
						echo 'Ensayo de Tracción (<span style="color:#000; font-size:20px;">'.$Otam.'</span>)'; 
					?>
				</strong>
				
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>

				<?php
				if($_SESSION['IdPerfil'] != 5){
					?>
					<div id="ImagenBarra">
						<a href="../plataformaErp.php" title="Menú Principal">
							<img src="../gastos/imagenes/Menu.png" width="28" height="28">
						</a>
					</div>
				<?php
				}
				?>
			</div>
			
			<form name="form" action="iTraccion.php" method="get">

			<div id="BarraOpciones" style="padding-top:5px; padding-bottom:5px; ">
				<?php if($CodInforme){?>
					<input name="CodInforme" type="hidden" value="<?php echo $CodInforme; ?>">
					<div id="ImagenBarraLeft">
						<a href="../generarinformes/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>" title="Volver a Informe <?php echo $CodInforme; ?>">
							<img src="../imagenes/Tablas.png"></a>
						<br>
						<?php echo '<span style="font-size:10px;">'.$CodInforme.'<span>'; ?>
					</div>
				<?php }else{ ?>
					<div id="ImagenBarraLeft">
						<a href="pTallerPM.php" title="Volver a Ensayos">
							<img src="../imagenes/probeta.png"></a>
						<br>
						Ensayos
					</div>
				<?php } ?>
				<div id="ImagenBarraLeft">
					<button name="guardarIdOtam" style="float:right; padding-top:5px;" title="Guardar Identificación OTAM">
						<img src="../gastos/imagenes/guardar.png" width="55" height="55">
						<br>
						Guardar
					</button>
				</div>
			</div>
			<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" style="padding:5px;">
						<?php
							$link=Conectarse();
							$bdOT=mysql_query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysql_fetch_array($bdOT)){
								$tpMuestra 	= $rowOT['tpMuestra'];
								$ObsOtam 	= $rowOT['ObsOtam'];
								$bdRegTra=mysql_query("SELECT * FROM regTraccion Where idItem = '".$Otam."'");
								if($rowRegTra=mysql_fetch_array($bdRegTra)){
									$aIni  		= $rowRegTra[aIni];
									$cFlu  		= $rowRegTra[cFlu];
									$cMax  		= $rowRegTra[cMax];
									$tFlu  		= $rowRegTra[tFlu];
									$tMax  		= $rowRegTra[tMax];
									$aSob  		= $rowRegTra[aSob];
									$rAre  		= $rowRegTra[rAre];
									$Espesor  	= $rowRegTra[Espesor];
									$Ancho  	= $rowRegTra[Ancho];
									$Li  		= $rowRegTra[Li];
									$Lf  		= $rowRegTra[Lf];
									$Di  		= $rowRegTra[Di];
									$Df  		= $rowRegTra[Df];
								}
								if($rowOT['tpMuestra'] == 'Pl'){
									?>
									<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
										<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
											<td align="center" width="17" height="40">	Espesor 							</td>
											<td align="center" width="17%">				Ancho								</td>
											<td align="center" width="16%"> Tensi&oacute;n	de			<br>
											   Fluencia 					</td>
											<td align="center" width="16%">				Carga<br> Máxima 					</td>
											<td align="center" width="17%">				Largo<br> Inicial 					</td>
											<td align="center" width="17%">				Largo<br> Final 					</td>
										</tr>
										<tr bgcolor="#FFFFFF" align="center">
											<td height="30" width="40"><input style="text-align:center;" name="Espesor" 	type="text" size="9" maxlength="9" value="<?php echo $Espesor; ?>"  autofocus 	/> 	</td>
											<td><input style="text-align:center;" name="Ancho" 					type="text" size="9" maxlength="9" value="<?php echo $Ancho; ?>"  				/>	</td>
											<td><input style="text-align:center;" name="tFlu" 					type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>"  				/>	</td>
											<td><input style="text-align:center;" name="cMax" 					type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>"  				/>	</td>
											<td><input style="text-align:center;" name="Li" 					type="text" size="9" maxlength="9" value="<?php echo $Li; ?>"  					/>	</td>
											<td><input style="text-align:center;" name="Lf" 					type="text" size="9" maxlength="9" value="<?php echo $Lf; ?>"  					/>	</td>
										</tr>
									</table>
									<br>
									<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
										<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
											<td align="center" width="8%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
											<td align="center" width="8%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
											<td align="center" width="8%">Carga<br>Máxima<br>(Kgf) 						</td>
											<td align="center" width="8%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
											<td align="center" width="8%">Tensión<br>Máxima<br>(MPa) 					</td>
											<td align="center" width="8%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
										</tr>
										<tr bgcolor="#FFFFFF" align="center" style="font-size:22px; font-weight:700;">
											<td height="30" width="40"><?php echo $aIni; ?> 	</td>
											<td><?php echo $cFlu; ?>							</td>
											<td><?php echo number_format($cMax, 0, ',', '.'); ?>							</td>
											<td><?php echo number_format($tFlu, 0, ',', '.'); ?>							</td>
											<td><?php echo number_format($tMax, 0, ',', '.'); ?>							</td>
											<td><?php echo number_format($aSob, 0, ',', '.'). '%'; ?>							</td>
										</tr>
									</table>
									<?php
								}
								if($rowOT['tpMuestra'] == 'Re'){
									?>
									<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
										<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
											<td align="center" width="17%">Diametro<br>Inicial		</td>
											<td align="center" width="17%">Tensión de <br>Fluencia		</td>
											<td align="center" width="16%">Carga<br>Máxima 			</td>
											<td align="center" width="17%">Largo<br>Inicial 		</td>
											<td align="center" width="17%">Largo<br>Final 			</td>
											<td align="center" width="16%">Diametro<br>Final		</td>
										</tr>
										<tr bgcolor="#FFFFFF" align="center">
											<td height="30"><input style="text-align:center;" name="Di" 	type="text" size="9" maxlength="9" value="<?php echo $Di; ?>" autofocus />	</td>
											<td><input style="text-align:center;" name="tFlu" 	type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>" />						</td>
											<td><input style="text-align:center;" name="cMax" 	type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>" />						</td>
											<td><input style="text-align:center;" name="Li" 	type="text" size="9" maxlength="9" value="<?php echo $Li; ?>"   />						</td>
											<td><input style="text-align:center;" name="Lf" 	type="text" size="9" maxlength="9" value="<?php echo $Lf; ?>"   />						</td>
											<td><input style="text-align:center;" name="Df" 	type="text" size="9" maxlength="9" value="<?php echo $Df; ?>"   />						</td>
										</tr>
									</table>
									<br>
									<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
										<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
											<td align="center" width="14%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
											<td align="center" width="14%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)		</td>
											<td align="center" width="14%">Carga<br>Máxima<br>(Kgf) 					</td>
											<td align="center" width="14%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) </td>
											<td align="center" width="14%">Tensión<br>Máxima<br>(MPa) 					</td>
											<td align="center" width="14%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
											<td align="center" width="14%">Red.<br>de Área<br>%) 						</td>
										</tr>
										<tr bgcolor="#FFFFFF" align="center" style="font-size:22px; font-weight:700;">
											<td height="30"><?php echo $aIni; ?>	</td>
											<td><?php echo $cFlu; ?>				</td>
											<td><?php echo number_format($cMax, 0, ',', '.'); ?>				</td>
											<td><?php echo number_format($tFlu, 0, ',', '.'); ?>				</td>
											<td><?php echo $tMax; ?>				</td>
											<td><?php echo number_format($aSob, 0, ',', '.'). '%'; ?>							</td>
											<td><?php echo number_format($rAre, 0, ',', '.'). '%'; ?>							</td>
										</tr>
									</table>
									<?php
								}
							}
							mysql_close($link);
							?>
					</td>
					<td valign="top" style="padding:5px; ">
						<table align="center" width="100%" style="border:1px solid #999; color:#FFFFFF;">
							<tr bgcolor="#666666">
								<td height="40" colspan="2" align="center">Descripci&oacute;n Ensayo</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">Tp.Ensayo</td>
								<td>
									<select name="tpMuestra">
										<?php
											$tm = explode('-',$Otam);
											if(substr($tm[1],0,1) == 'T'){ $idEnsayo = 'Tr'; }
											if(substr($tm[1],0,1) == 'Q'){ $idEnsayo = 'Qu'; }
											if(substr($tm[1],0,1) == 'C'){ $idEnsayo = 'Ch'; }
											if(substr($tm[1],0,1) == 'D'){ $idEnsayo = 'Du'; }
											if(substr($tm[1],0,1) == 'O'){ $idEnsayo = 'Ot'; }
													
											$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													
											$link=Conectarse();
											$bdTm=mysql_query($SQL);
											if($rowTm=mysql_fetch_array($bdTm)){
												do{
													if($tpMuestra == $rowTm[tpMuestra]){?>
														<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
													<?php 
													}else{ ?>
														<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
													<?php 
													} 
												}while($rowTm=mysql_fetch_array($bdTm));
											}
											mysql_close($link);
										?>
									</select>
								</td>
							</tr>
							<?php
								if(substr($tm[1],0,1) == 'D' or substr($tm[1],0,1) == 'C'){?>
									<tr>
										<td height="40">
											<?php
												if(substr($tm[1],0,1) == 'D'){
													echo 'Indentaciones';
												}
												if(substr($tm[1],0,1) == 'C'){
													echo 'Impactos';
												}
											?>
										</td>
										<td>
											<input type="text" name="Ind" id="Ind" maxlength="5" size="5" value="<?php echo $Ind; ?>">
										</td>
									</tr>
								<?php
								}
								if(substr($tm[1],0,1) == 'C'){?>
									<tr>
										<td height="40">T&deg;</td>
										<td>
											<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
										</td>
									</tr>
									<?php
								}
								?>
						</table>
					</td>
				</tr>
			</table>
			
			</form>
		
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
