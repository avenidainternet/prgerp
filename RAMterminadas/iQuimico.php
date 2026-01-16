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
								)");
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
	
					if(substr($tm[1],0,1) == 'T'){
						$actSQL="UPDATE $tReg SET ";
						$actSQL.="tpMuestra	='".$tpMuestra.	"',";
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
						echo 'Ensayo de Químico (<span style="color:#000; font-size:20px;">'.$Otam.'</span>)'; 
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
			
			<form name="form" action="iQuimico.php" method="get">

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
												$tpMuestra = $rowOT['tpMuestra'];
												$bdRegQui=mysql_query("SELECT * FROM regQuimico Where idItem = '".$Otam."'");
												if($rowRegQui=mysql_fetch_array($bdRegQui)){
													$cC  = $rowRegQui[cC];
													$cSi = $rowRegQui[cSi];
													$cMn = $rowRegQui[cMn];
													$cP  = $rowRegQui[cP];
													$cS  = $rowRegQui[cS];
													$cCr = $rowRegQui[cCr];
													$cNi = $rowRegQui[cNi];
													$cMo = $rowRegQui[cMo];
													$cAl = $rowRegQui[cAl];
													$cCu = $rowRegQui[cCu];
													$cCo = $rowRegQui[cCo];
													$cTi = $rowRegQui[cTi];
													$cNb = $rowRegQui[cNb];
													$cV  = $rowRegQui[cV];
													$cW  = $rowRegQui[cW];
													$cPb = $rowRegQui[cPb];
													$cB  = $rowRegQui[cB];
													$cSb = $rowRegQui[cSb];
													$cSn = $rowRegQui[cSn];
													$cZn = $rowRegQui[cZn];
													$cAs = $rowRegQui[cAs];
													$cBi = $rowRegQui[cBi];
													$cTa = $rowRegQui[cTa];
													$cCa = $rowRegQui[cCa];
													$cCe = $rowRegQui[cCe];
													$cZr = $rowRegQui[cZr];
													$cLa = $rowRegQui[cLa];
													$cSe = $rowRegQui[cSe];
													$cN  = $rowRegQui[cN];
													$cFe = $rowRegQui[cFe];
													$cMg = $rowRegQui[cMg];
													$cTe = $rowRegQui[cTe];
													$cCd = $rowRegQui[cCd];
													$cAg = $rowRegQui[cAg];
													$cAu = $rowRegQui[cAu];
													$cAi = $rowRegQui[cAi];
												}
												if($rowOT['tpMuestra'] == 'Ac'){
													?>
													<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="05%">%C</td>
															<td align="center" width="05%">%Si</td>
															<td align="center" width="05%">%Mn</td>
															<td align="center" width="05%">%P</td>
															<td align="center" width="05%">%S</td>
															<td align="center" width="05%">%Cr</td>
															<td align="center" width="05%">%Ni</td>
															<td align="center" width="05%">%Mo</td>
															<td align="center" width="05%">%Al</td>
															<td align="center" width="05%">%Cu</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input style="text-align:center;" name="cC" 	type="text" size="6" maxlength="6" value="<?php echo $cC;  ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cSi" 	type="text" size="6" maxlength="6" value="<?php echo $cSi; ?>" />			</td>
															<td><input style="text-align:center;" name="cMn" 	type="text" size="6" maxlength="6" value="<?php echo $cMn; ?>" />			</td>
															<td><input style="text-align:center;" name="cP" 	type="text" size="6" maxlength="6" value="<?php echo $cP;  ?>" />			</td>
															<td><input style="text-align:center;" name="cS" 	type="text" size="6" maxlength="6" value="<?php echo $cS;  ?>" />			</td>
															<td><input style="text-align:center;" name="cCr" 	type="text" size="6" maxlength="6" value="<?php echo $cCr; ?>" />			</td>
															<td><input style="text-align:center;" name="cNi" 	type="text" size="6" maxlength="6" value="<?php echo $cNi; ?>" />			</td>
															<td><input style="text-align:center;" name="cMo" 	type="text" size="6" maxlength="6" value="<?php echo $cMo; ?>" />			</td>
															<td><input style="text-align:center;" name="cAl" 	type="text" size="6" maxlength="6" value="<?php echo $cAl; ?>" />			</td>
															<td><input style="text-align:center;" name="cCu" 	type="text" size="6" maxlength="6" value="<?php echo $cCu; ?>" />			</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#E6E6E6">%Co</td>
															<td align="center" bgcolor="#E6E6E6">%Ti</td>
															<td align="center" bgcolor="#E6E6E6">%Nb</td>
															<td align="center" bgcolor="#E6E6E6">%V</td>
															<td align="center" bgcolor="#E6E6E6">%W</td>
															<td align="center" bgcolor="#E6E6E6">%Sn</td>
															<td align="center" bgcolor="#E6E6E6">%B</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Fe</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input style="text-align:center;" name="cCo" 	type="text" size="6" maxlength="6" value="<?php echo $cCo; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cTi" 	type="text" size="6" maxlength="6" value="<?php echo $cTi; ?>" />			</td>
															<td><input style="text-align:center;" name="cNb" 	type="text" size="6" maxlength="6" value="<?php echo $cNb; ?>" />			</td>
															<td><input style="text-align:center;" name="cV" 	type="text" size="6" maxlength="6" value="<?php echo $cV;  ?>" />			</td>
															<td><input style="text-align:center;" name="cW" 	type="text" size="6" maxlength="6" value="<?php echo $cW;  ?>" />			</td>
															<td><input style="text-align:center;" name="cSn" 	type="text" size="6" maxlength="6" value="<?php echo $cSn;  ?>" />			</td>
															<td><input style="text-align:center;" name="cB" 	type="text" size="6" maxlength="6" value="<?php echo $cB;  ?>" />			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input style="text-align:center; font-size:12px;" name="cFe" 	type="text" size="6" maxlength="6" value="<?php echo 'Resto';  ?>" />		</td>
														</tr>
													</table>
													<?php
												}
												if($rowOT['tpMuestra'] == 'Co'){
													?>
													<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="08%">%Zn</td>
															<td align="center" width="08%">%Pb</td>
															<td align="center" width="08%">%Sn</td>
															<td align="center" width="08%">%P</td>
															<td align="center" width="08%">%Mn</td>
															<td align="center" width="08%">%Fe</td>
															<td align="center" width="08%">%Ni</td>
															<td align="center" width="08%">%Si</td>
															<td align="center" width="08%">%Mg</td>
															<td align="center" width="08%">%Cr</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input name="cZn" 	type="text" id="cZn" style="text-align:center;" value="<?php echo $cZn;  ?>" size="6" maxlength="6" autofocus />	</td>
															<td><input name="cPb" 	type="text" id="cPb" style="text-align:center;" value="<?php echo $cPb; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cSn" 	type="text" id="cSn" style="text-align:center;" value="<?php echo $cSn; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cP" 	type="text" id="cP"  style="text-align:center;" value="<?php echo $cP;  ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cMn" 	type="text" id="cMn" style="text-align:center;" value="<?php echo $cMn;  ?>" size="6" maxlength="6" />			</td>
															<td><input name="cFe" 	type="text" id="cFe" style="text-align:center;" value="<?php echo $cFe; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cNi" 	type="text" id="cNi" style="text-align:center;" value="<?php echo $cNi; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cSi" 	type="text" id="cSi" style="text-align:center;" value="<?php echo $cSi; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cMg" 	type="text" id="cMg" style="text-align:center;" value="<?php echo $cMg; ?>"  size="6" maxlength="6" />			</td>
															<td><input name="cCr" 	type="text" id="cCr" style="text-align:center;" value="<?php echo $cCr; ?>"  size="6" maxlength="6" />			</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#E6E6E6">%Te</td>
															<td align="center" bgcolor="#E6E6E6">%As</td>
															<td align="center" bgcolor="#E6E6E6">%Sb</td>
															<td align="center" bgcolor="#E6E6E6">%Cd</td>
															<td align="center" bgcolor="#E6E6E6">%Bi</td>
															<td align="center" bgcolor="#E6E6E6">%Ag</td>
															<td align="center" bgcolor="#E6E6E6">%Co</td>
															<td align="center" bgcolor="#E6E6E6">%Ai</td>
															<td align="center" bgcolor="#E6E6E6">%S</td>
															<td align="center" bgcolor="#E6E6E6">%Zr</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input name="cTe" 	type="text" id="cTe" style="text-align:center;" value="<?php echo $cTe; ?>" 	size="6" maxlength="6" autofocus />	</td>
															<td><input name="cAs" 	type="text" id="cAs" style="text-align:center;" value="<?php echo $cAs; ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cSb" 	type="text" id="cSb" style="text-align:center;" value="<?php echo $cSb; ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cCd" 	type="text" id="cCd" style="text-align:center;" value="<?php echo $cCd;  ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cBi" 	type="text" id="cBi" style="text-align:center;" value="<?php echo $cBi;  ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cAg" 	type="text" id="cAg" style="text-align:center;" value="<?php echo $cAg;  ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cCo" 	type="text" id="cCo" style="text-align:center;" value="<?php echo $cCo;  ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cAi" 	type="text" id="cAi" style="text-align:center;" value="<?php echo $cAi;  ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cS" 	type="text" id="cS"  style="text-align:center;" value="<?php echo $cS;  ?>"  	size="6" maxlength="6" />			</td>
															<td><input name="cZr" 	type="text" id="cZ" style="text-align:center;" value="<?php echo $cZr;  ?>" 	size="6" maxlength="6" />			</td>
														</tr>
								
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#E6E6E6">%Au</td>
															<td align="center" bgcolor="#E6E6E6">%B</td>
															<td align="center" bgcolor="#E6E6E6">%Ti</td>
															<td align="center" bgcolor="#E6E6E6">%Se</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Cu</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input name="cAu" 	type="text" id="cAu" 	style="text-align:center;" value="<?php echo $cAu; ?>" 	size="6" maxlength="6" autofocus />	</td>
															<td><input name="cB" 	type="text" id="cB" 	style="text-align:center;" value="<?php echo $cB; ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cTi" 	type="text" id="cTi" 	style="text-align:center;" value="<?php echo $cTi; ?>" 	size="6" maxlength="6" />			</td>
															<td><input name="cSe" 	type="text" id="cSe" 	style="text-align:center;" value="<?php echo $cSe;  ?>" size="6" maxlength="6" />			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input name="cCu" 	type="text" id="cCu" 	style="text-align:center;" value="<?php echo $cCu;  ?>" size="6" maxlength="6" />			</td>
														</tr>
													</table>
													<?php
												}
												if($rowOT['tpMuestra'] == 'Al'){
													?>
													<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="08%">%Si</td>
															<td align="center" width="08%">%Fe</td>
															<td align="center" width="08%">%Cu</td>
															<td align="center" width="08%">%Mn</td>
															<td align="center" width="08%">%Mg</td>
															<td align="center" width="08%">%Cr</td>
															<td align="center" width="08%">%Ni</td>
															<td align="center" width="08%">%Zn</td>
															<td align="center" width="08%">%Ti</td>
															<td align="center" width="08%">%Pb</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input style="text-align:center;" name="cSi" 	type="text" size="6" maxlength="6" value="<?php echo $cSi;  ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cFe" 	type="text" size="6" maxlength="6" value="<?php echo $cFe; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cCu" 	type="text" size="6" maxlength="6" value="<?php echo $cCu; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cMn" 	type="text" size="6" maxlength="6" value="<?php echo $cMn;  ?>" />				</td>
															<td><input style="text-align:center;" name="cMg" 	type="text" size="6" maxlength="6" value="<?php echo $cMg;  ?>" />				</td>
															<td><input style="text-align:center;" name="cCr" 	type="text" size="6" maxlength="6" value="<?php echo $cCr; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cNi" 	type="text" size="6" maxlength="6" value="<?php echo $cNi; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cZn" 	type="text" size="6" maxlength="6" value="<?php echo $cZn; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cTi" 	type="text" size="6" maxlength="6" value="<?php echo $cTi; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cPb" 	type="text" size="6" maxlength="6" value="<?php echo $cPb; ?>" 	/>				</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#E6E6E6">%Sn</td>
															<td align="center" bgcolor="#E6E6E6">%Bi</td>
															<td align="center" bgcolor="#E6E6E6">%Zr</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Al</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><input style="text-align:center;" name="cSn" 	type="text" size="6" maxlength="6" value="<?php echo $cSn; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cBi" 	type="text" size="6" maxlength="6" value="<?php echo $cBi; ?>" />			</td>
															<td><input style="text-align:center;" name="cZr" 	type="text" size="6" maxlength="6" value="<?php echo $cZr; ?>" />			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input style="text-align:center;" name="cAl" 	type="text" size="6" maxlength="6" value="<?php echo $cAl;  ?>" />		</td>
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
											<input type="text" name="Ind" id="Ind" maxlength="6" size="6" value="<?php echo $Ind; ?>">
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
