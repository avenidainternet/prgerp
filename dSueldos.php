<?php
	session_start(); 
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
		//if ($Detect->IsMobile()) {
		//	header("Location: http://simet.cl/mobil/");
		//}
	$maxCpo = '100%';
	include_once("conexionli.php");

		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUF'];
		}
		$link->close();

	if(isset($_GET['CAM'])) 	{	$CAM 	= $_GET['CAM']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['CAM'])) 	{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; }
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
</head>

<body>
	<?php 
		include_once('head.php');
	?>
	<!-- <table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:5px;"> -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" rowspan="5" valign="top">
				<?php include_once('menulateral.php')?>
			</td>
			<td width="<?php echo $maxCpo; ?>" valign="top">
				<span id="resultadoAM"></span>
			</td>
	  	</tr>
	  	<tr>
			<td valign="top">
				<?php listaVentas(); ?>
			</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div>
	<br>
</body>
</html>
<?php
function listaVentas(){

	$Orden = 'Asc';
	$Campo = 'Run';
	if(isset($_GET['Orden']))  	{ $Orden  	= $_GET['Orden']; 	}
	if(isset($_GET['Campo']))  	{ $Campo  	= $_GET['Campo']; 	}
	if($Orden == 'Asc'){
		$Orden = 'Desc';
	}else{
		$Orden = 'Asc';
	}
	?>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo" style="margin-top:10px;">
		<tr>
			<td  width="10%" align="center" height="40"><strong>Item<br>Sueldos  		</strong></td>
			<td  width="10%" align="center">			
				Proyecto
			</td>
			<td  width="10%" align="center">			
				<strong>
					Fecha<br> de Pago	
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					N° <br> Documento				
				</strong>
			</td>
			<td  width="40%" align="center">			
				<strong>
					Id.<br> Personal
				</strong>
			</td>
			<td  width="10%" align="center"> 			<strong>Pago<br>Liquido		</strong></td>
			<td  width="10%" align="center"> 			<strong>Total<br>Pagado		</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
			$tGral 		= 0;
			$tGralpp	= 0;
			$tSueldos 	= 0;
			$tPersona	= 0;
			$subTSue	= 0;
			$Run		= '';
			$nivelDetalle = 1;
			
			$PeriodoPago 	= $_GET['mesSueldos'].'.'.$_GET['ageSueldos'];
			if(isset($_GET['nivelDetalle'])){ $nivelDetalle = $_GET['nivelDetalle']; }
			
			$filtroSQL = " Where PeriodoPago = '".$PeriodoPago."'";

			if($_GET['Sueldos'] == 'AgnoProy'){
				$filtroSQL = " Where PeriodoPago <= '".$PeriodoPago."' and PeriodoPago Like '%".$_GET['ageSueldos']."%'";
			}			
			if($_GET['Sueldos'] == 'Agno'){
				$filtroSQL = " Where PeriodoPago <= '".$PeriodoPago."' and PeriodoPago Like '%".$_GET['ageSueldos']."%'";
			}			
			if(isset($_GET['IdProyecto'])) {
				$IdProyecto = $_GET['IdProyecto'];
				if(!empty($IdProyecto)){
					$filtroSQL .= " and IdProyecto = '".$_GET['IdProyecto']."'";
				}
			}
			if(isset($_GET['nivelDetalle'])){
				if($_GET['nivelDetalle'] == 2){
					$SQL = "SELECT * FROM sueldos $filtroSQL and Estado != 'P' Order By Run, PeriodoPago";
				}
			}else{
					$SQL = "SELECT * FROM sueldos $filtroSQL Order By Run, PeriodoPago";
			}
			$link=Conectarse();
			// Sueldos
			$n = 0;
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n++;
					$tr 	= "barraVerde";
					if($row['Estado']=='P'){
						$tr = 'barraPagada';
					}
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="10%" style="font-size:16px;" align="center">
							<?php 
								if($n == 1){
									echo 'SUELDOS';
								}
							?>
						</td>
						<td  width="10%" align="center">			
							<?php echo $row['IdProyecto']; ?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php 
								$fd = explode('-', $row['FechaPago']);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
							?>
						</td>
						<td width="10%" style="font-size:16px;">&nbsp;
							
						</td>
						<td width="40%">
							<?php
								$bdPer=$link->query("SELECT * FROM Personal Where Run = '".$row['Run']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'].'</strong>';
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($row['Liquido'], 0, ',', '.');
								$tSueldos 	+= $row['Liquido'];
								$tGral 		+= $row['Liquido'];
								$subTSue	+= $row['Liquido'];
								if($Run != $row['Run']){
									$tPersona = 0;
									$Run	  = $row['Run'];
								}
								$tPersona		+= $row['Liquido'];
								if($tr 	== "barraVerde"){
									$tGralpp	+= $row['Liquido'];
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								//echo number_format($tSueldos, 0, ',', '.');
								echo number_format($tPersona, 0, ',', '.');
							?>
						</td>
					</tr>
					<?php
				}while ($row=mysqli_fetch_array($bdHon));
				?>
					<tr id="barraSubIt">
						<td colspan="5">&nbsp;</td>
						<td>
							<?php echo 'TOTAL <br> Sueldos'; ?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($subTSue, 0, ',', '.');
							?>
						</td>
					</tr>
				<?php
			}

			// Honorarios
			$tHonorarios = 0;
			$tPersona	 = 0;
			$subTSue	 = 0;
			$Run		 = '';
			$n = 0;
			$Campo = 'TpCosto';
			$Orden = 'Desc';
			$TpCosto = '';
			if(isset($_GET['nivelDetalle'])){
				if($_GET['nivelDetalle'] == 2){
					$SQL = "SELECT * FROM Honorarios $filtroSQL and Cancelado != 'on' Order By TpCosto Desc, Run, PeriodoPago";
				}
			}else{
					$SQL = "SELECT * FROM Honorarios $filtroSQL Order By TpCosto Desc, Run, PeriodoPago";
			}

			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n++;
					$tr 	= "barraVerde";
					if($row['Cancelado']=='on'){
						$tr = 'barraPagada';
					}
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="10%" style="font-size:16px;" align="center">
							<?php 
								if($n == 1){
									echo 'HONORARIOS ';
								}
								if($TpCosto != $row['TpCosto']){
									$TpCosto = $row['TpCosto'];
									
									if($TpCosto == 'M') { $TpCostoTxt = 'Mensual'; }
									if($TpCosto == 'I') { $TpCostoTxt = 'Inversi�n'; }
									if($TpCosto == 'E') { $TpCostoTxt = 'Esporadicos'; }
									
									echo '<span style="float:right;">'.$TpCostoTxt.'</span>';
								}
							?>
						</td>
						<td  width="10%" align="center">			
							<?php echo $row['IdProyecto']; ?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php 
								if($row['FechaPago'] != '0000-00-00'){
									$fd = explode('-', $row['FechaPago']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
								}
							?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php
								echo number_format($row['nBoleta'], 0, ',', '.');
							?>
						</td>
						<td width="40%">
							<?php
								$bdPer=$link->query("SELECT * FROM PersonalHonorarios Where Run = '".$row['Run']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Paterno'].' '.$rowP['Materno'].' '.$rowP['Nombres'].'</strong>';
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								$tHonorarios 	+= $row['Total'];
								$tGral 			+= $row['Total'];
								$subTSue		+= $row['Total'];
								if($Run != $row['Run']){
									$tPersona = 0;
									$Run	  = $row['Run'];
								}
								$tPersona		+= $row['Total'];
								if($tr 	== "barraVerde"){
									$tGralpp	+= $row['Total'];
								}
								
								echo number_format($row['Total'], 0, ',', '.');
								
							?>
						</td>
						<td width="10%" align="center">
							<?php
								//echo number_format($tHonorarios, 0, ',', '.');
								echo number_format($tPersona, 0, ',', '.');
							?>
						</td>
					</tr>
					<?php
				}while ($row=mysqli_fetch_array($bdHon));
				?>
					<tr id="barraSubIt">
						<td colspan="5">&nbsp;</td>
						<td>
							<?php echo 'TOTAL <br> Honorarios'; ?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($subTSue, 0, ',', '.');
							?>
						</td>
					</tr>
				<?php
			}

			// Facturas
			$tFacturas  = 0;
			$tProveedor = 0;
			$subTSue	= 0;
			$RutProv 	= '';
			
			$n = 0;
			$Campo = 'TpCosto';
			$Orden = 'Desc';
			$TpCosto = '';

			if(isset($_GET['nivelDetalle'])){
				if($_GET['nivelDetalle'] == 2){
					$SQL = "SELECT * FROM Facturas $filtroSQL and Estado != 'P' Order By RutProv";
				}
			}else{
					$SQL = "SELECT * FROM Facturas $filtroSQL Order By RutProv";
			}

			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n++;
					$tr 	= "barraVerde";
					if($row['Estado']=='P'){
						$tr = 'barraPagada';
					}
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="10%" style="font-size:16px;" align="center">
							<?php 
								if($n == 1){
									echo 'FACTURAS';
								}
								if($TpCosto != $row['TpCosto']){
									$TpCosto = $row['TpCosto'];
									
									if($TpCosto == 'M') { $TpCostoTxt = 'Mensual'; }
									if($TpCosto == 'I') { $TpCostoTxt = 'Inversi�n'; }
									if($TpCosto == 'E') { $TpCostoTxt = 'Esporadicos'; }
									
									echo '<span style="float:right;">'.$TpCostoTxt.'</span>';
								}
							?>
						</td>
						<td  width="10%" align="center">			
							<?php echo $row['IdProyecto']; ?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php 
								if($row['FechaPago'] != '0000-00-00'){
									$fd = explode('-', $row['FechaPago']);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
								}
							?>
						</td>
						<td width="10%" style="font-size:16px;">
							<?php
								echo number_format($row['nFactura'], 0, ',', '.');
							?>
						</td>
						<td width="40%">
							<?php
								$bdPer=$link->query("SELECT * FROM Proveedores Where RutProv = '".$row['RutProv']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									echo '<strong>'.$rowP['Proveedor'].'</strong>';
								}
							?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($row['Bruto'], 0, ',', '.');
								$tFacturas 	+= $row['Bruto'];
								$tGral 		+= $row['Bruto'];
								$subTSue	+= $row['Bruto'];
								if($RutProv != $row['RutProv']){
									$tProveedor = 0;
									$RutProv    = $row['RutProv'];
								}
								$tProveedor	+= $row['Bruto'];
								if($tr 	== "barraVerde"){
									$tGralpp	+= $row['Bruto'];
								}
								
							?>
						</td>
						<td width="10%" align="center">
							<?php
								//echo number_format($tFacturas, 0, ',', '.');
								echo number_format($tProveedor, 0, ',', '.');
							?>
						</td>
					</tr>
					<?php
				}while ($row=mysqli_fetch_array($bdHon));
				?>
					<tr id="barraSubIt">
						<td colspan="5">&nbsp;</td>
						<td>
							<?php echo 'TOTAL <br> Facturas'; ?>
						</td>
						<td width="10%" align="center">
							<?php
								echo number_format($subTSue, 0, ',', '.');
							?>
						</td>
					</tr>
				<?php
			}

			$link->close();
		?>
	</table>
	<table width="99%"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
		<tr>
			<td  width="10%" align="center" height="40">&nbsp;</td>
			<td  width="10%" align="center">&nbsp;</td>
			<td  width="10%" align="center">&nbsp;</td>
			<td  width="40%" align="center">&nbsp;</td>
			<td  width="10%" align="center"> 			
				<strong>
					<?php echo number_format($tGral, 0, ',', '.'); ?>
				</strong>
				<br>
				<?php if($tGralpp > 0){ ?>
					<span style="color:#FF0000; font-weight:800;">
					<?php echo number_format($tGralpp, 0, ',', '.'); ?>
					</span>
				<?php } ?>
			</td>
		</tr>
	</table>
		
	<?php
}
?>











