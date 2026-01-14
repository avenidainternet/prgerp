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
			<td  width="10%" align="center" height="40"><strong>Item<br>Gastos  		</strong></td>
			<td  width="10%" align="center" height="40"><strong>N° Sol.<br>Proy.  		</strong></td>
			<td  width="10%" align="center">			
				<strong>
					Fecha<br> de Gasto	
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					Documento				
				</strong>
			</td>
			<td  width="10%" align="center">
				<strong>
					Reembolso				
				</strong>
			</td>
			<td  width="30%" align="center">			
				<strong>
					Proveedor
				</strong>
			</td>
			<td  width="10%" align="center"> 			<strong>Monto<br>Gasto		</strong></td>
			<td  width="10%" align="center"> 			<strong>Total<br>Gasto		</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
			$tGral 		= 0;
			$tGralpp	= 0;
			$tGralcc	= 0;
			$tSueldos 	= 0;
			$tPersona	= 0;
			$Run		= '';
			
			$filtroSQL = " Where Modulo = 'G' and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) = '".$_GET['mesGastos']."' ";

			if($_GET['Gastos'] == 'AgnoProy'){
				$filtroSQL = " Where Modulo = 'G' and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) <= '".$_GET['mesGastos']."' ";
			}			
			if($_GET['Gastos'] == 'Agno'){
				$filtroSQL = " Where Modulo = 'G' and year(FechaGasto) = '".$_GET['ageGastos']."' and month(FechaGasto) <= '".$_GET['mesGastos']."' ";
			}			
			if(isset($_GET['IdProyecto'])) {
				$IdProyecto = $_GET['IdProyecto'];
				if(!empty($IdProyecto)){
					$filtroSQL .= " and IdProyecto = '".$_GET['IdProyecto']."'";
				}
			}
			if(isset($_GET['nivelDetalle'])) {
				$filtroSQL .= " and Reembolso != 'on'";
			}
			$link=Conectarse();

			$n = 0;
			$SQL = "SELECT * FROM ItemsGastos Order By nItem";
			$bdHon=$link->query($SQL);
			if($row=mysqli_fetch_array($bdHon)){
				do{
					$n 		= 0;
					$tItems = 0;
					$bdGas=$link->query("SELECT * FROM MovGastos $filtroSQL and nItem = '".$row['nItem']."' Order By IdGasto, nInforme");
					if($rowGas=mysqli_fetch_array($bdGas)){
						do{

							$n++;
							$tr = "barraVerde";
							if($rowGas['Reembolso'] == 'on'){
								$tr = 'barraPagada';
							}
							?>
							<tr id="<?php echo $tr; ?>">
								<td width="10%" style="font-size:16px;" align="right">
									<?php 
										if($n == 1){
											echo $row['Items'];
										}
										if($rowGas['IdGasto'] == '2'){
											echo $row['Items'].'<br>INVERSIÓN';
										}
									?>
								</td>
								<td  width="10%" align="center">			
									<?php 
										echo $rowGas['nInforme'].'<br>';
										echo $rowGas['IdProyecto']; 
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php 
										$fd = explode('-', $rowGas['FechaGasto']);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php 
										if($rowGas['TpDoc'] == 'F'){
											echo 'Factura '.'<br> N° '.$rowGas['nDoc']; 
										}else{
											echo 'Boleta '.'<br> N° '.$rowGas['nDoc']; 
										}
									?>
								</td>
								<td width="10%" style="font-size:16px;">
									<?php
										if($rowGas['Reembolso'] == 'on'){ 
											$fd = explode('-', $rowGas['fechaReembolso']);
											echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
										}
									?>
								</td>
								<td width="30%">
									<?php 
										echo $rowGas['Proveedor'].'<br>'; 
										echo '('.$rowGas['Bien_Servicio'].')'; 
									?>
								</td>
								<td width="10%" align="right">
									<?php
										echo number_format($rowGas['Bruto'], 0, ',', '.');
										if($tr == "barraVerde"){
											if($rowGas['IdRecurso'] != 5){
												$bdcc=$link->query("SELECT * FROM recursos Where IdRecurso = '".$rowGas['IdRecurso']."'");
												if($rowcc=mysqli_fetch_array($bdcc)){
													echo '<br>'.$rowcc['Recurso'];
												}
											}
										}
										$tItems 	+= $rowGas['Bruto'];
										$tGral 		+= $rowGas['Bruto'];
										if($tr == "barraVerde"){
											$tGralpp	+= $rowGas['Bruto'];
											if($rowGas['IdRecurso'] != 5){
												$tGralcc	+= $rowGas['Bruto'];
											}
										}
									?>
								</td>
								<td width="10%" align="right">
									<?php
										echo number_format($tItems, 0, ',', '.');
									?>
								</td>
							</tr>
							<?php
						}while ($rowGas=mysqli_fetch_array($bdGas));
						if($tItems > 0){
							?>
							<tr id="barraSubIt">
								<td colspan="6">&nbsp;</td>
								<td>
									<?php echo 'TOTAL <br>'.$row['Items']; ?>
								</td>
								<td width="10%" align="right">
									<?php
										echo number_format($tItems, 0, ',', '.');
									?>
								</td>
							</tr>
							<?php
						}
					}
				}while ($row=mysqli_fetch_array($bdHon));
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
				<br>
				<?php if($tGralcc > 0){ ?>
					<span style="color:#FF0000; font-weight:800;">
					<?php echo 'cc '.number_format($tGralcc, 0, ',', '.'); ?>
					</span>
				<?php } ?>
			</td>
		</tr>
	</table>
		
	<?php
}
?>











