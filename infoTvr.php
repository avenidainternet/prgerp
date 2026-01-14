<?php
	session_start(); 
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
		//if ($Detect->IsMobile()) {
		//	header("Location: http://simet.cl/mobil/");
		//}
	$maxCpo = '81%';
	include_once("conexion.php");

	if(isset($_GET[CAM])) 		{	$CAM 	= $_GET[CAM]; 		}
	if(isset($_GET[RAM])) 		{	$RAM 	= $_GET[RAM]; 		}
	if(isset($_GET[accion])) 	{	$accion = $_GET[accion]; 	}
	
	if(isset($_POST[CAM])) 		{	$CAM 	= $_POST[CAM]; 	}
	if(isset($_POST[RAM])) 		{	$RAM 	= $_POST[RAM]; 	}
	if(isset($_POST[accion])) 	{	$accion = $_POST[accion]; 	}
	
	if(isset($_SESSION[usr])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION[IdPerfil]."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION[Perfil]	= $rowPer[Perfil];
			$_SESSION[IdPerfil]	= $rowPer[IdPerfil];
		}
		mysql_close($link);
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
	<meta content="15" http-equiv="REFRESH"> </meta>

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>SIMET - Info TV</title>

	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/stylesTv.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<script language="javascript" src="validaciones.js"></script> 
	
</head>

<body>
	<?php 
		$link=Conectarse();
		$sql = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'";  // sentencia sql
		$result = mysql_query($sql);
		$nRams = mysql_num_rows($result); // obtenemos el número de filas
		mysql_close($link);
		if(isset($_SESSION[tRams])){
			$_SESSION[cRams] = $_SESSION[cRams] + 1;
			if($_SESSION[cRams]>$_SESSION[tRams]){
				$_SESSION[cRams] = 1;
				$_SESSION[tRams] = round($nRams/10);
			}
		}else{
			$_SESSION[cRams] = 1;
			$_SESSION[tRams] = round($nRams/10);
		}

		include_once('headTv.php');
	?>

	
	<table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
		<tr>
			<td valign="top" align="center" width="15%">
				<?php
				if($nCols=1){
					mRAMs(0,10);
				}
				?>
			</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div>
	<br>
</body>
</html>

<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios en Procesos RAM
*
*
****************************************************************************************************************

-->
		<?php
		function mRAMs($il, $tl){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTvr">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">RAM			 </td>';
				echo '			<td  width="10%">							Ini.		 </td>';
				echo '			<td  width="10%">							Tér.		 </td>';
				echo '			<td  width="10%">							Días	 	 </td>';
				echo '			<td  width="20%">							Clientes	 </td>';
				echo '			<td  width="40%">							Observaciones</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTvr">';
				$n 		= 0;
				$link=Conectarse();
				
				$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc Limit $il, $tl");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

						$fd = explode('-', $fechaTermino);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts   = strtotime($fechaTermino); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 1;
						
						$tr = "bBlanca";
						if($row[Estado]=='P' and $nDias <= 1){ // Enviada
							$tr = "bAmarilla";
							if($nDias < 0){ // En Proceso
								$tr = 'bRoja';
							}
						}else{
							if($row[Estado] == 'P'){ // Aceptada
								$tr = 'bVerde';
							}
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%">';
								echo 	'R'.$row[RAM].'<br>';
								echo 	'C'.$row[CAM];
								if($row[Cta]){
									echo '<br>CC';
								}
						echo '	</td>';
						echo '	<td width="10%">';
									if($row[fechaInicio] != 0){
										$fd = explode('-', $row[fechaInicio]);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row[usrResponzable];
									}else{
										echo 'NO Asignado';
									}
						echo '	</td>';
						echo '	<td width="10%">';
									if($row[fechaInicio] != 0){
										//echo number_format($row[dHabiles], 0, ',', '.').' días';
										$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $row[fechaInicio];
										$dh	= $row[dHabiles];
										$dd	= 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}
										}

										$fd = explode('-', $ft);
										echo $dSem[$dia_semana].'<br>'.$fd[2].'/'.$fd[1];
										
										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										//$end_ts 	= strtotime($fechaTermino); 
										$end_ts 	= strtotime($ft); 
										
										$tDias = 1;
										$nDias = $end_ts - $start_ts;
										$dd--;
										$nDias = round($nDias / 86400)-$dd;
									}else{
										echo number_format($row[dHabiles], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td width="10%">';
									if($row[fechaInicio] != 0){
										$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $row[fechaInicio];
										$dh	= $row[dHabiles];
										$dd	= 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}
										}

										$fd = explode('-', $ft);
										
										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										//$end_ts 	= strtotime($fechaTermino); 
										$end_ts 	= strtotime($ft); 
										
										$tDias = 1;
										$nDias = $end_ts - $start_ts;
										$dd--;
										$nDias = round($nDias / 86400)-$dd;
										if($nDias <= $tDias){ // En Proceso
											echo '<div class="pVencer" title="Días de Plazo RAM">';
											echo 	$nDias;
											echo '</div';
											enviarAviso('francisco.olivares.rodriguez@gmail.com', $row[CAM], $nDias);
										}else{
											echo '<div class="sVencer" title="Días plazo RAM">';
											echo 	$nDias;
											echo '</div';
										}
									}else{
										echo number_format($row[dHabiles], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';

						echo '	<td width="20%">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="40%">';
									if($row[Descripcion]){
										echo $row[Descripcion];
									}
						echo ' 	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

