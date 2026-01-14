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
	<!-- <meta content="15" http-equiv="REFRESH"> </meta> -->

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccíon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Simet Ingenieria y Servicios Tecnológicos :: Laboratorio de Materiales</title>

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

		include_once('headTv.php');
	?>

	
	<table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
		<tr>
			<td valign="top" align="left" width="15%">
				<?php
				if($nCols=1){
					mRAMs(0,12);
				}
				?>
			</td>
			<td valign="top" align="left" width="15%">
				<?php
					mRAMs(12,12);
				if($nCols>1 and $nCols<2){
				}
				?>
			</td>
			<td valign="top" align="left" width="15%">
				<?php
					mRAMs(24,12);
				if($nCols>2 and $nCols<3){
				}
				?>
			</td>
			<td valign="top" align="left" width="15%">
				<?php
					mRAMs(36,12);
				if($nCols>3){
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
*             Nominas de Servicios Terminados
*
*
****************************************************************************************************************

-->
		<?php
		function sTerminados(){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">AM					</td>';
				echo '			<td  width="10%">							Tipo Cot<br>Resp.	</td>';
				echo '			<td  width="42%">							Clientes			</td>';
				echo '			<td  width="14%">							Valor				</td>';
				echo '			<td  width="10%">							Estado 				</td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' Order By CAM Desc");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "bBlanca";
						if($row[Estado] == 'T'){ 
							$tr = "bBlanca";
						}
						if($row[informeUP] == 'on'){ 
							$tr = "bAmarilla";
						}
						if($row[Facturacion] == 'on'){ 
							$tr = "bVerde";
						}
						if($row[Archivo] == 'on'){ 
							$tr = "bAzul";
						}
						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700"></strong>';
									echo '<br>RAM-'.$row[RAM];
									echo '<br>CAM-'.$row[CAM];
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row[oCompra]=='on'){
										echo 'OC';
									}
									if($row[oMail]=='on'){
										echo 'Mail';
									}
									if($row[oCtaCte]=='on'){
										echo 'Cta.Cte';
									}
									if($row[nOC]){
										echo '<br>'.$row[nOC];
									}
									echo '<br>'.$row[usrResponzable];
						echo '	</td>';
						echo '	<td width="42%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="14%">';
						echo '		<strong style="font-size:12px;">';
						echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '	<td width="10%">';
									$imgEstado = 'hourglass_clock_256.png';
									$msgEstado = 'Esperando Seguimiento';
									$fd[0] = 0;
									if($row[Estado] == 'T'){ // En Espera
										$imgEstado = 'hourglass_clock_256.png';
										$msgEstado = 'Esperando Seguimiento';
									}
									if($row[informeUP] == 'on'){ // Cerrada
										$imgEstado = 'informeUP.png';
										$msgEstado = 'Informe Subido';
										$fd = explode('-', $row[fechaInformeUP]);
									}
									if($row[Facturacion] == 'on'){ // Cerrada
										$imgEstado = 'crear_certificado.png';
										$msgEstado = 'Facturado';
										$fd = explode('-', $row[fechaFacturacion]);
									}
									if($row[Archivo] == 'on'){ // Cerrada
										$imgEstado = 'consulta.png';
										$msgEstado = 'Archivado';
										$fd = explode('-', $row[fechaArchivo]);
									}
									echo '<img src="../imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'">';
									if($fd[0]>0){
										echo '<br>'.$fd[2].'/'.$fd[1];
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row[Estado] == 'T'){ // En Proceso
									if($row[oCtaCte]=='on'){
										echo '<img src="../gastos/imagenes/open_48.png" width="40" height="40" title="Cuenta Corriente" style="opacity:0;">';
									}else{
										echo '<a href="plataformaErp.php?CAM='.$row[CAM].'&RAM='.$row[RAM].'&accion=SeguimientoAM"		><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
									}
								}else{
									echo '<img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

		<?php
		function mCAMs(){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">CAM			</td>';
				echo '			<td  width="08%">							Fecha		</td>';
				echo '			<td  width="28%">							Clientes	</td>';
				echo '			<td  width="14%">							Total		</td>';
				echo '			<td  width="14%">							Validez		</td>';
				echo '			<td  width="08%">							Est. 		</td>';
				echo '			<td  width="18%" align="center" colspan="3">Acciones	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				if($_SESSION[usr]=='Alfredo.Artigas' or $_SESSION[usr] == '10074437' or substr($_SESSION[IdPerfil],0,1) == 0){
					if($dBuscar){
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 and CAM Like '%".$dBuscar."%' Order By Estado Desc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where Estado != 'C' and RAM = 0 Order By Estado Desc");
					}
				}else{
					if($dBuscar){
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where usrCotizador Like '".$_SESSION[usr]."' and RAM = 0 and CAM Like '%".$dBuscar."%' Order By Estado Desc");
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM = 0 and CAM Like '%".$dBuscar."%' Order By CAM Desc");
					}else{
						$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where usrCotizador Like '".$_SESSION[usr]."' and RAM = 0 Order By Estado Desc");
						//$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM = 0 Order By CAM Desc");
					}
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
						
						$treinta = 30;
						$fechaaCerrar 	= strtotime ( '+'.$treinta.' day' , strtotime ( $row[fechaCotizacion] ) );
						$fechaaCerrar 	= date ( 'Y-m-d' , $fechaaCerrar );

						$fd = explode('-', $fechaxVencer);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts = strtotime($fechaxVencer); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						$tDias = 3;
						
						$tr = "bBlanca";
						if($row[Estado]==' '){
							$tr = "bBlanca";
						}
						if($row[Estado]=='E'){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= $tDias){ // En Proceso
								$tr = 'bRoja';
							}
							if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
								$tr = 'bRoja';
							}
						}
						if($row[Estado] == 'A'){ // Aceptada
							$tr = 'bVerde';
						}
						if($row[fechaAceptacion] != '0000-00-00'){ // Aceptada
							$tr = 'bVerde';
						}
/*
						if($row[Estado] == 'P'){ // En Proceso
							$tr = 'barraVerde';
							if($nDias <= $tDias){ // En Proceso
								$tr = 'barraRoja';
							}
						}



						if($fechaaCerrar >= $fechaHoy){

*/
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
									if($row[Rev]<10){
										$Revision = '0'.$row[Rev]; 
									}else{
										$Revision = $row[Rev]; 
									}
						echo		'<strong style="font-size:14; font-weight:700">'.$row[CAM].'</strong>'.'<br> Rev.'.$Revision;
									if($row[Cta]){
										echo '<br>CC';
									}
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row[fechaCotizacion]);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row[usrCotizador];
									//echo '<br>'.$_SESSION[usr];
						echo '	</td>';
						echo '	<td width="28%" style="font-size:12px;">';
							$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$row[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								echo 	$rowCli[Cliente];
							}
						echo '	</td>';
						echo '	<td width="12%" style="font-size:12px;">';
									if($row[Moneda] == 'P'){
										echo number_format($row[Bruto], 0, ',', '.');
									}else{
										echo number_format($row[BrutoUF], 2, ',', '.').' UF';
									}
						echo ' 	</td>';
						echo '	<td width="14%" style="font-size:12px;">';
									if($row[Validez] == 0){
										echo 'Contado';
									}else{
										//echo number_format($row[Validez], 0, ',', '.').' días';
										$fechaxVencer 	= strtotime ( '+'.$row[Validez].' day' , strtotime ( $row[fechaCotizacion] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

										//echo '<br>';
										$fd = explode('-', $fechaxVencer);
										echo $fd[2].'/'.$fd[1];
										
										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										$end_ts 	= strtotime($fechaxVencer); 
										
										$nDias = $end_ts - $start_ts;
										$nDias = round($nDias / 86400);
										echo '<br>';
										if($nDias <= $tDias){ // En Proceso
											echo '<div class="pVencer" title="Cotización por vencer">';
											echo 	$nDias;
											echo '</div';
											enviarAviso('francisco.olivares.rodriguez@gmail.com', $row[CAM], $nDias);
										}else{
											echo '<div class="sVencer" title="Días por vencer">';
											echo 	$nDias;
											echo '</div';
										}
									}
						echo ' 	</td>';
						echo '	<td width="08%">';
									if($row[enviadoCorreo] == ''){ // Sin Enviar
										echo '<img src="../imagenes/noEnviado.png" 	width="32" height="32" title="Cotización NO Enviada"><br>';
									}
									if($row[enviadoCorreo] == 'on'){ // Enviada
										if($row[proxRecordatorio] <= $fechaHoy){ // En Proceso
											echo '<img src="../imagenes/alerta.gif" 	width="50" title="Contactar con Cliente">';
										}else{
											echo '<img src="../imagenes/enviarConsulta.png" 	width="32" height="32" title="Cotización Enviada">';
										}
										echo '<br>';
										$fd = explode('-', $row[fechaEnvio]);
										echo $fd[2].'-'.$fd[1];
									}
									if($row[Estado] == 'A'){ // Aceptada
										echo '<img src="../imagenes/printing.png" 			width="32" height="32" title="Cotización Aceptada">';
										echo '<br>';
										$fd = explode('-', $row[fechaAceptacion]);
										echo $fd[2].'-'.$fd[1];
									}else{
									}
						echo ' 	</td>';
						if($row[Estado] == 'E' or $row[Estado] == 'A'){ // En Proceso
							echo '<td width="06%" align="center"><a href="cotizaciones/plataformaCotizaciones.php?CAM='.$row[CAM].'&accion=Seguimiento"	><img src="../gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
						}else{
							echo '<td width="06%" align="center"><img src="../gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;"></td>';
						}
						echo '	<td width="06%" align="center"><a href="cotizaciones/modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Cotización">		</a></td>';
						echo '	<td width="06%" align="center"><a href="cotizaciones/modCotizacion.php?CAM='.$row[CAM].'&Rev='.$Rev.'&Cta='.$row[Cta].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

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
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">PAM			 </td>';
				echo '			<td  width="10%">							Ini.		 </td>';
				echo '			<td  width="10%">							Tér.		 </td>';
				echo '			<td  width="10%">							Días	 	 </td>';
				echo '			<td  width="20%">							Clientes	 </td>';
				echo '			<td  width="40%">							Observaciones</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTv">';
				$n 		= 0;
				$link=Conectarse();
				
				$bdEnc=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc Limit $il, $tl");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row[fechaInicio];
						$dh	= $row[dHabiles]-1;
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
						$end_ts 	= strtotime($ft); 
										
						$tDias = 1;
						$nDias = $end_ts - $start_ts;

						$nDias = round($nDias / 86400)+1;
						if($ft < $fechaHoy){
							$nDias = $nDias - $dd;
						}
						
						$tr = "bBlanca";
						if($row[Estado]=='P' and $nDias <= 2){ // Enviada
							$tr = "bAmarilla";
							if($nDias <= 0){ // En Proceso
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
										$fechaTermino 	= strtotime ( '+'.$row[dHabiles].' day' , strtotime ( $row[fechaInicio] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$ft = $row[fechaInicio];
										$dh	= $row[dHabiles]-1;
										$dd	= 0;
										$cDias = 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}else{
												$cDias++;
											}
										}

										$fd = explode('-', $ft);
										echo $dSem[$dia_semana].'<br>'.$fd[2].'/'.$fd[1];

										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										//$end_ts 	= strtotime($fechaTermino); 
										$end_ts 	= strtotime($ft); 

										$tDias = 1;
										if($ft<$fechaHoy){
											$nDias = ($start_ts - $end_ts);
										}else{
											$nDias = $end_ts - $start_ts;
										}
										
										$nDias = round($nDias / 86400)+1;
										if($ft < $fechaHoy){
											$nDias = $nDias - $dd;
										}
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
										$dh	= $row[dHabiles]-1;
										$dd	= 0;
										$cDias = 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row[fechaInicio] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}else{
												$cDias++;
											}
										}
										
										$fd = explode('-', $ft);

										$fechaHoy = date('Y-m-d');
										$start_ts 	= strtotime($fechaHoy); 
										$end_ts 	= strtotime($ft); 
											
										$tDias 		= 1;
										
										if($ft<$fechaHoy){
											$fechaEntrega 	= $ft;
											$j 				= 1;
											$cuentaAtrazo 	= 1;
											
											while($fechaEntrega < $fechaHoy) {
												$fechaEntrega 	= strtotime ( '+'.$j.' day' , strtotime ( $fechaEntrega ) );
												$fechaEntrega	= date ( 'Y-m-d' , $fechaEntrega );
												$dia_semana 	= date("w",strtotime($fechaEntrega));
												if($dia_semana == 0 or $dia_semana == 6){
												}else{
													$cuentaAtrazo++;
												}
											}
										}else{
											$fechaEntrega 	= $ft;
											$j 				= 1;
											$nFaltan		= 1;
											
											while($fechaHoy < $fechaEntrega) {
												$fechaHoy 	= strtotime ( '+'.$j.' day' , strtotime ( $fechaHoy ) );
												$fechaHoy	= date ( 'Y-m-d' , $fechaHoy );
												$dia_semana 	= date("w",strtotime($fechaHoy));
												if($dia_semana == 0 or $dia_semana == 6){
												}else{
													$nFaltan++;
												}
											}
											echo $nFaltan;
										}
										
										if($ft<$fechaHoy){ // En Proceso
											echo '<div class="pVencer" title="Días de Plazo RAM">';
											echo 	$cuentaAtrazo;
											echo '</div';
											//enviarAviso('francisco.olivares.rodriguez@gmail.com', $row[CAM], $nDias);
										}else{
											echo '<div class="sVencer" title="Días plazo RAM">';
											echo 	$nFaltan;
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
								echo 	'<span style="font-size:10px;">'.substr($rowCli[Cliente],0,20).'</span>';
							}
						echo '	</td>';
						echo '	<td width="40%">';
									if($row[Descripcion]){
										echo substr($row[Descripcion],0,50).'...';
									}
						echo ' 	</td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
			}
			?>

