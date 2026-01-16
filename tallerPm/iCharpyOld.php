<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

	$accion 	= '';
	$Otam		= '';
	$CodInforme = '';
	$Entalle	= 'Con';
	
	$CAM		= 0;
	$RAM		= 0;
	$mm			= 0.0;
	$vImpacto 	= 0;
	if(isset($_GET['accion'])) 		{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Otam'])) 		{	$Otam 		= $_GET['Otam']; 		}
	if(isset($_GET['CodInforme']))	{	$CodInforme	= $_GET['CodInforme'];	}

	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=$link->query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		$link->close();
	}

	if(isset($_GET['guardarIdOtam'])){	
		$link=Conectarse();
		$bdOT=$link->query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysqli_fetch_array($bdOT)){

			$calA = 0.9061;
			//$calB = 2.7885;
			$calB = 0.7885;
			
			$bdCAL=$link->query("Select * From calibraciones Where idEnsayo = 'Ch'");
			if($rowCAL=mysqli_fetch_array($bdCAL)){
					$calA 			= $rowCAL['calA'];
					$calB 			= $rowCAL['calB'];
					$EquilibrioX 	= $rowCAL['EquilibrioX'];
					$calC 			= $rowCAL['calC'];
					$calD 			= $rowCAL['calD'];
			}
			$Estado 	= 'R';
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET['tpMuestra'])) { $tpMuestra = $_GET['tpMuestra']; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			$tReg = 'regCharpy';
			$Ind = 3;
			if(isset($_GET['Ind'])){ $Ind  = $_GET['Ind']; }
			$Ind = $rowOT['Ind'];
			for($in=1; $in<=$Ind; $in++) { 
				$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
				$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
				$el_vAncho		= 'Ancho_'.$in.'-'.$Otam;
				$el_vAlto		= 'Alto_'.$in.'-'.$Otam;
				$el_vresEquipo	= 'resEquipo_'.$in.'-'.$Otam;
				if(isset($_GET[$el_nImpacto]))		{ $el_nImpacto		= $_GET[$el_nImpacto];		}
				if(isset($_GET[$el_vImpacto]))		{ $el_vImpacto		= $_GET[$el_vImpacto];		}
				if(isset($_GET[$el_vAncho]))		{ $el_vAncho		= $_GET[$el_vAncho];		}
				if(isset($_GET[$el_vAlto]))			{ $el_vAlto			= $_GET[$el_vAlto];			}
				if(isset($_GET[$el_vresEquipo]))	{ $el_vresEquipo	= $_GET[$el_vresEquipo];	}
				if(isset($_GET['mm']))				{ $mm				= $_GET['mm'];				}
				if(isset($_GET['Entalle']))			{ $Entalle			= $_GET['Entalle'];			}
				if(isset($_GET['Tem']))				{ $Tem				= $_GET['Tem'];				}
				if(isset($_GET['fechaRegistro']))	{ $fechaRegistro	= $_GET['fechaRegistro'];	}
				
				$y 	= 0;
				$criterio = 80;
				if($mm == 10 ) { $criterio = 80; }
				if($mm == 7.5) { $criterio = 60; }
				if($mm == 6.7) { $criterio = 53.6; }
				if($mm == 5	 ) { $criterio = 40; }
				if($mm == 3.3) { $criterio = 26.4; }
				if($mm == 2.5) { $criterio = 20;  } 

				if($el_vresEquipo <= $EquilibrioX){
					if(($el_vAncho * $el_vAlto) > 0){
						if($mm < 10 and $Entalle == 'Sin'){
							$Entalle = 'Con';
						}
						if($Entalle == 'Con'){
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * ($el_vAlto - 2));
						}
						if($Entalle == 'Sin'){
							$criterio = 100;
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * $el_vAlto);
						}
					}
					$vImpacto = ($calA * $y) + ($calB);
				}
				if($el_vresEquipo > $EquilibrioX){
					if(($el_vAncho * $el_vAlto) > 0){
						if($mm < 10 and $Entalle == 'Sin'){
							$Entalle = 'Con';
						}
						if($Entalle == 'Con'){
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * ($el_vAlto - 2));
						}
						if($Entalle == 'Sin'){
							$criterio = 100;
							$y = ($el_vresEquipo * $criterio) / ($el_vAncho * $el_vAlto);
						}
					}
					$vImpacto = ($calC * $y) + ($calD);
				}
				echo $vImpacto;
				$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
				if($rowRegCh=mysqli_fetch_array($bdRegCh)){
					$actSQL="UPDATE regCharpy SET ";
					$actSQL.="fechaRegistro ='".$fechaRegistro.	"',";
					$actSQL.="Ancho 	   	='".$el_vAncho.		"',";
					$actSQL.="Alto 	   		='".$el_vAlto.		"',";
					$actSQL.="mm   			='".$mm.			"',";
					$actSQL.="Tem			='".$Tem.			"',";
					$actSQL.="Entalle		='".$Entalle.		"',";
					$actSQL.="resEquipo   	='".$el_vresEquipo.	"',";
					$actSQL.="vImpacto 	   	='".$vImpacto.		"'";
					$actSQL.="WHERE idItem 	= '".$Otam."' and nImpacto = '".$in."'";
					$bdRegCh=$link->query($actSQL);
					
					$actSQL="UPDATE regCharpy SET ";
					$actSQL.="Entalle		='".$Entalle.		"'";
					$actSQL.="WHERE idItem 	= '".$Otam."'";
					$bdRegCh=$link->query($actSQL);
				}else{
					$link->query("insert into regCharpy(
															CodInforme,
															idItem,
															tpMuestra,
															fechaRegistro,
															Alto,
															Ancho,
															mm,
															Entalle,
															Tem,
															resEquipo,
															nImpacto,
															vImpacto
															) 
													values 	(	
															'$CodInforme',
															'$Otam',
															'$tpMuestra',
															'$fechaRegistro',
															'$el_vAlto',
															'$el_vAncho',
															'$mm',
															'$Entalle',
															'$Tem',
															'$el_vresEquipo',
															'$in',
															'$vImpacto'
							)");
				}
			}
				
		}
		$link->close();
		$accion = '';
	}
	$fechaRegistro = date('Y-m-d');
	$link=Conectarse();
	$fechaRegistro = date('Y-m-d');
	
	$bdRegDu=$link->query("SELECT * FROM regCharpy Where idItem = '$Otam'");
	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
		if($rowRegDu['fechaRegistro']){
			$fechaRegistro = $rowRegDu['fechaRegistro'];
		}
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
	<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Taller Propiedades Mecánicas</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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
	
	function volver(){
		history.go(-1);
	}

	</script>

</head>

<body>
	<?php include('head.php'); ?>

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
				  	<?php
						if($_SESSION['IdPerfil'] != 5){
						?>
	        			<li class="nav-item active">
	          				<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                		<span class="sr-only">(current)</span>
	              			</a>
	        			</li>
					<?php } ?>
					<!--
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="pTallerPM.php"> Ensayo</a>
	        		</li>
					-->
	        		<li class="nav-item active">
						<?php 
							if($CodInforme){
								$fr = explode('-',$CodInforme);
								$RAM = $fr[1];
								?>
								<a class="nav-link fas fa-undo-alt"  href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $CodInforme; ?>"> Volver</a>
							<?php
							}else{?>
	          					<a class="nav-link fas fa-undo-alt"  href="../tallerPM/pTallerPM.php"> Volver</a>
							<?php
							}
						?>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>


	<div id="Cuerpo">
		<div id="CajaCpo">



			<form name="form" action="iCharpy.php" method="get">


			<div class="card m-2">
    			<div class="card-header">
					<b>Ensayo de Charpy <?php echo $Otam; ?></b>
				</div>
    			<div class="card-body">



				<input name="CodInforme" type="hidden" 	value="<?php echo $CodInforme; ?>" />
				<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" style="padding:5px;">
						<?php
							$link=Conectarse();
							$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
							if($rowOT=mysqli_fetch_array($bdOT)){
								$tpMuestra 	= $rowOT['tpMuestra'];
								$Ind 		= $rowOT['Ind'];
								$Tem 		= $rowOT['Tem'];
								?>
								<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
											(Joule) 
										</td>
									</tr>
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<?php for($in=1; $in<=$Ind; $in++) { ?>
											<td align="center">
												Muestra <?php echo 'N° '.$in; ?>
											</td>
										<?php } ?>
										<td align="center">
											&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor="#FFFFFF" align="center">
										<?php
											$sImpactos 	= 0;
											$Media 		= 0;
											for($in=1; $in<=$Ind; $in++) { 
												$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
												$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
												$el_vAncho 		= 'Ancho_'.$in.'-'.$Otam;
												$el_vAlto 		= 'Alto_'.$in.'-'.$Otam;
												$el_vresEquipo 	= 'resEquipo_'.$in.'-'.$Otam;
												$vAncho = '';
												$vAlto = '';
												$vresEquipo = '';
												$mm = '';
												$Entalle = '';
												$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
												if($rowRegCh=mysqli_fetch_array($bdRegCh)){
													$nImpacto  	= $rowRegCh['nImpacto'];
													$vImpacto  	= $rowRegCh['vImpacto'];
													$vAncho  	= $rowRegCh['Ancho'];
													$vAlto  	= $rowRegCh['Alto'];
													$vresEquipo = $rowRegCh['resEquipo'];
													$mm 		= $rowRegCh['mm'];
													$Entalle 	= $rowRegCh['Entalle'];
													$Tem 		= $rowRegCh['Tem'];
												}
												?>
												<td height="30">
													Ancho<br>
													<input style="text-align:center;" name="<?php echo $el_vAncho; ?>" 		id="<?php echo $el_vAncho; ?>" 		type="text" size="5" maxlength="5" value="<?php echo $vAncho; ?>" autofocus /><br>
													Alto<br>
													<input style="text-align:center;" name="<?php echo $el_vAlto; ?>" 		id="<?php echo $el_vAlto; ?>" 		type="text" size="5" maxlength="5" value="<?php echo $vAlto; ?>"   			/><br>
													Equipo<br>
													<input style="text-align:center;" name="<?php echo $el_vresEquipo; ?>" 	id="<?php echo $el_vresEquipo; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $vresEquipo; ?>"   	/>
												</td>
												<?php
											}
										?>
										<td>
											&nbsp;&nbsp;
										</td>
									</tr>
								</table>

								<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
											(Joule) 
										</td>
									</tr>
									<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
										<?php for($in=1; $in<=$Ind; $in++) { ?>
											<td align="center">
												Muestra <?php echo 'N° '.$in; ?>
											</td>
										<?php } ?>
										<td align="center">
											Promedio
										</td>
									</tr>
									<tr bgcolor="#FFFFFF" align="center">
										<?php
											$sImpactos 	= 0;
											$Media 		= 0;
											for($in=1; $in<=$Ind; $in++) { 
												$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
												$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
												$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
												if($rowRegCh=mysqli_fetch_array($bdRegCh)){
													$nImpacto  = $rowRegCh['nImpacto'];
													$vImpacto  = $rowRegCh['vImpacto'];
												}
												$sImpactos += $vImpacto;
												$Media = $sImpactos / $in;
												?>
												<td height="30" style="font-size:22px; font-weight:700;">
													<?php echo $vImpacto; ?>
												</td>
												<?php
											}
										?>
										<td>
											<?php //echo number_format($mDureza, 1, '.', ','); ?>
											<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
										</td>
									</tr>
								</table>
							<?php
							}
							$link->close();
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
											$idEnsayo = 'Ch';
													
											$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													
											$link=Conectarse();
											$bdTm=$link->query($SQL);
											if($rowTm=mysqli_fetch_array($bdTm)){
												do{
													if($tpMuestra == $rowTm['tpMuestra']){?>
														<option selected 	value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
													<?php 
													}else{ ?>
														<option  			value="<?php echo $rowTm['tpMuestra']; ?>"><?php echo $rowTm['Muestra']; ?></option>
													<?php 
													} 
												}while($rowTm=mysqli_fetch_array($bdTm));
											}
											$link->close();
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">
									Impactos
								</td>
								<td>
									<input type="text" name="Ind" id="Ind" maxlength="5" size="5" value="<?php echo $Ind; ?>">
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">T&deg;</td>
								<td>
									<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
								</td>
							</tr>
							<tr>
								<td height="40" style="color:#333333;">Entalle</td> 
									<td>
										<select name="Entalle" id="Entalle">
											<?php if($Entalle ==  'Con') { ?>
														<option selected 	value="Con">Con Entalle </option>
														<option 			value="Sin">Sin Entalle </option>
											<?php 	}else{
														if($Entalle == 'Sin'){ ?>
															<option  			value="Con">Con Entalle </option>
															<option selected	value="Sin">Sin Entalle </option>
											<?php 		}else{ ?>
															<option value="Con">Con Entalle </option>
															<option value="Sin">Sin Entalle </option>
														<?php
														}
													} 
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td height="40" style="color:#333333;">Tamaño</td> 
									<td>
										<select name="mm" id="mm">
											<?php if($mm ==  10) { ?>
														<option selected 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{ ?>
											<?php if($mm == 7.5){ ?>
														<option 		 	value="10">	10 </option>
														<option selected	value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 6.7){?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option selected	value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{ ?>
											<?php if($mm == 5){ ?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option selected	value="5">	5	</option>
														<option 			value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 3.3) {?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option selected 	value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }else{; ?>
											<?php if($mm == 2.5){?>
														<option 		 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 		 	value="3.3">3.3	</option>
														<option selected	value="2.5">2.5	</option>
											<?php }else{ ?>
														<option selected 	value="10">	10 </option>
														<option 			value="7.5">7.5 </option>
														<option 			value="6.7">6.7	</option>
														<option 			value="5">	5	</option>
														<option 		 	value="3.3">3.3	</option>
														<option 			value="2.5">2.5	</option>
											<?php }}}}}} ?>
										</select>
									</td>
								</tr>
								
								
						</table>
					</td>
				</tr>
			</table>



				<div class="row">
					<div class="col-2">
						<div class="card m-2">
							<div class="card-header"><b>Fecha Ensayo</b></div>
							<div class="card-body">
								<input name="fechaRegistro" type="date" class="form-control" value="<?php echo $fechaRegistro; ?>">
							</div>
						</div>
					</div>
				</div>


				</div>
    			<div class="card-footer">
					<button type="submit" name="guardarIdOtam"  class="btn btn-info">Guardar</button>	
				</div>
			</div>


			</form>
		</div>
		<img src="Charpy.jpg">
				
	</div>
	<br>

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>
	
	
</body>
</html>
