<?php
	session_start(); 
	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("inc/funciones.php");
	include_once("conexionli.php");
	
	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy); 
	$Periodo = $fp[1].'-'.$fp[0];
	
	//cuentaEnsayosActivos($Periodo);
	//$horaAct = '11:05';
	$respaldar = false;
	//if($horaAct >= "13:30" and $horaAct <= "14:00") {
	$hrespaldo = '11';
	if($horaAct >= "11:00" and $horaAct <= "11:30") {
		//echo $horaAct;
		$hrespaldo = '11';
		$respaldar = true;
		//echo $respaldar;
	}else{
		if($horaAct >= "15:00" and $horaAct <= "15:15") {
			$hrespaldo = '15';
			$respaldar = true;
		}else{
			if($horaAct >= "18:00" and $horaAct <= "18:15") {
				$hrespaldo = '18';
				$respaldar = true;
			}
		}

	}
	
	if($horaAct >= "20:00" and $horaAct <= "20:30") {
		$hrespaldo = 'FOR 20 ';
		$respaldar = true;
	}


	//echo $horaAct;
	//$respaldar = false;
	if($respaldar == true) {
		//echo $horaAct.' Entra';
		$fd = explode('-', $fechaHoy);
		$carpetaRespaldo = 'z:backup-'.$fd[2].'-'.$fd[1].'-'.$fd[0].'-'.$hrespaldo.'Hrs';
		// $carpetaRespaldo = 'AAA/Backup/:backup-'.$fd[2].'-'.$fd[1].'-'.$fd[0].'-'.$hrespaldo.'Hrs';


		if(!file_exists($carpetaRespaldo)) {
			mkdir($carpetaRespaldo, 0777, true);
		}else{

		}
		$link=Conectarse();
		$tables = array();
		$result = $link->query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}



		foreach($tables as $table){
			$return = '';
			$result = $link->query('SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE '.$table));
			$return = 'DELETE FROM '.$table.' WHERE 1';
			$return.= ";\n";
			for ($i = 0; $i < $num_fields; $i++){
				while($row = mysqli_fetch_row($result)){
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++){
						//$row[$j] = utf8_decode($row[$j]);
						$row[$j] = ($row[$j]);
						$Obs = str_replace("'","Â´",$row[$j]);
						$row[$j] = $Obs;
						if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$ficheroRespaldo = $carpetaRespaldo.'/'.$table.'.sql';
			$archivoBackup	= $ficheroRespaldo;
			$handle = fopen($ficheroRespaldo,'w+');
			fwrite($handle,$return);
			fclose($handle);
		}

		$link->close();

		
	}

	$maxCpo = '81%';

	if(isset($_GET['CAM'])) 		{	$CAM 	= $_GET['CAM']; 		}
	if(isset($_GET['RAM'])) 		{	$RAM 	= $_GET['RAM']; 		}
	if(isset($_GET['accion'])) 		{	$accion = $_GET['accion']; 		}
	
	if(isset($_POST['CAM'])) 		{	$CAM 	= $_POST['CAM']; 		}
	if(isset($_POST['RAM'])) 		{	$RAM 	= $_POST['RAM']; 		}
	if(isset($_POST['accion'])) 	{	$accion = $_POST['accion']; 	}
/*	
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
*/	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="300" http-equiv="REFRESH"> </meta>

	<link rel="shortcut icon" href="favicon.ico" /> 
	<title>InfoTV</title>

	<link href="css/tpv.css" 		rel="stylesheet" type="text/css">
	<link href="css/stylesTv.css" 	rel="stylesheet" type="text/css">

	<!-- BootStrap -->
	<link rel="stylesheet" type="text/css" href="cssboot/bootstrap.min.css">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<script type="text/javascript" src="jquery/libs/1/jquery.min.js"></script>	
</head>

<body>
	<?php
		$nRams = 0; 
		$link=Conectarse();
		$sql 	= "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'";  // sentencia sql
		$result = $link->query($sql);
		$nRams 	= $result->num_rows; // obtenemos el nùmero de filas

        $fechaHoy = date('Y-m-d');
        $treinta = 30;
        $fecha30    = strtotime ( '-'.$treinta.' day' , strtotime ( $fechaHoy ) );
        $fecha30    = date ( 'Y-m-d' , $fecha30 );

        $nFactPend = 0;
        $actSQL="UPDATE Clientes SET ";
        $actSQL.="nFactPend     = '".$nFactPend."'";
        $bdCli=$link->query($actSQL);
        $RutCliCorte = '';

        $bdCot=$link->query("SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'T' and Facturacion != 'on' Order By RutCli");
        while($row=mysqli_fetch_array($bdCot)){
            if($RutCliCorte == ''){
                $RutCliCorte = $row['RutCli'];
            }
            if($RutCliCorte == $row['RutCli']){
                if($row['fechaInicio'] < $fecha30){
                    $nFactPend++;
                }
            }else{
                $actSQL="UPDATE Clientes SET ";
                $actSQL.="nFactPend     = '".$nFactPend."'";
                $actSQL.="WHERE RutCli  = '".$RutCliCorte."'";
                $bdCli=$link->query($actSQL);
                $RutCliCorte = $row['RutCli'];
                $nFactPend = 0;
                if($row['fechaInicio'] < $fecha30){ 
                    $nFactPend++;
                }
            }
        }


		$nregistrosTr = 0;
		$bdEnc=$link->query("SELECT * FROM cotizaciones Where tpEnsayo > 2 and RAM > 0 and Estado = 'P' and usrResponzable in ('ACA', 'MRR', 'SCM', 'MMG') Order By RAM Asc");
		while ($row=mysqli_fetch_array($bdEnc)){
			$nregistrosTr++;
		}
		$nPegas = 12;
		$nCol = ceil($nregistrosTr / $nPegas);


		$link->close();

		include_once('headTv.php');
	?>

	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin:0px;">
		<tr>
		<?php
			$nRegIni = 0;
			for($i=1; $i<=$nCol; $i++){
				echo '<td valign="top" align="left" width="10%">';
						// echo $i.'. '.$nRegIni.'/'.$nPegas.'<br>';
						mRAMs($nRegIni, $nPegas);
				 		$nRegIni += $nPegas;
				echo '</td>';
			}
			?>
			<td valign="top" align="left" width="10%">
				<?php
					//mRAMs(36,12);

					mRAMsAF(0,12);
				if($nCols>3){
				}
				?>
			</td>
			<td valign="top" align="left" width="10%">
				<?php
					mRAMsAF(12,12);

					//verEnsayosenProceso($Periodo);
				if($nCols>3){
				}
				?>
			</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div>
	<br>
	<script src="jsboot/bootstrap.min.js"></script>	
	<script>
	$(document).ready(function(){
	  $('.toast').toast('show');
	});
	</script>

</body>
</html>

		<?php
		function mRAMs($il, $tl){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">PAM			 </td>';
				echo '			<td  width="10%">							Ini.		 </td>';
				echo '			<td  width="10%">							Tér.		 </td>';
				echo '			<td  width="10%">							Días	 	 </td>';
				echo '			<td  width="20%">							Clientes	 </td>';
				echo '			<td  width="30%">							Observaciones</td>';
				echo '			<td  width="10%">										 </td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTv">';
				$n 		= 0;
				$link=Conectarse();
				
				//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where tpEnsayo != 2 and RAM > 0 and Estado = 'P' Order By RAM Asc Limit $il, $tl");
				$bdEnc=$link->query("SELECT * FROM cotizaciones Where tpEnsayo > 2 and RAM > 0 and Estado = 'P' and usrResponzable in ('ACA', 'MRR', 'SCM', 'MMG') Order By RAM Asc Limit $il, $tl");
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						list($ftermino, $dhf, $dha, $dsemana, $dHabiles) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);


						$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row['fechaInicio'];
						$dh	= $row['dHabiles']-1;
						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
							$ft	= date ( 'Y-m-d' , $ft );
							$dia_semana = date("w",strtotime($ft));
							//echo $ft;
							/*
							$dbf=$link->query("SELECT * FROM diasferiados Where fecha = '$ft'");
							if ($rs=mysqli_fetch_array($bdf)){
								echo $rs['fecha'];
							}
							*/
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
						if($dhf > 0){ // Enviada
							$tr = 'bVerde';
							if($dhf == 2 or $dhf ==1){ // En Proceso
								$tr = "bAmarilla";
							}
						}
						if($dha > 0){ // Enviada
							$tr = 'bRoja';
						}

						
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%">';
								echo 	'R'.$row['RAM'].'<br>';
								echo 	'C'.$row['CAM'];
								if($row['Cta']){
									echo '<br>CC';
								}
									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><img src="imagenes/bola_amarilla.png">';
									}
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['Clasificacion'] == 1){
											echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
										}else{	
											if($rowCli['Clasificacion'] == 2){
												echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											}else{
												if($rowCli['Clasificacion'] == 3){
													echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												}
											}
										}
										
									}
									//Fin Verificación Deuda
								
						echo '	</td>';
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){
										$fd = explode('-', $row['fechaInicio']);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row['usrResponzable'];
									}else{
										echo 'NO Asignado';
									}?>
									<div style="clear:both;"></div>
									<?php
									if($row['tpEnsayo'] == 1){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												IC
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 2){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												AF
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 3){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												CE
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 4){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												IR
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 5){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Informe Oficial">
												IO
											</div>
										<?php
									}
		
						echo '	</td>';
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');
										$dsemana = date("w",strtotime($ft));
										$dsemana = date("w",strtotime($ftermino)); 
										$fdt = explode('-', $ft);
										$fdt = explode('-', $ftermino);
										echo '<br>'.$dSem[$dsemana];
										
										echo '<br>'.$fdt[2].'/'.$fdt[1].'<br>';
										// echo $ftermino.'Ter. <br>';
									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td width="10%">';
									if($row['fechaInicio'] != 0){

										if($dhf > 0 and $dha == 0){ // En Proceso
											if($dhf == 1){ // En Proceso
												echo '<div class="sVencerVerde">';
												echo 	$dhf;
												echo '</div';
											}else{
												echo '<div class="sVencer">';
												echo 	$dhf;
												echo '</div';
											}
										}
										if($dha > 0){ // En Proceso
											echo '<div class="pVencer" title="Atraso">';
											echo 	$dha;
											echo '</div';
										}
									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';

						echo '	<td width="20%">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	'<span style="font-size:10px;">'.substr($rowCli['Cliente'],0,20).'</span>';
							}
						echo '	</td>';
						echo '	<td width="30%">';
									if($row['Descripcion']){
										echo substr($row['Descripcion'],0,50).'...';
									}
						echo ' 	</td>';
						echo '	<td valign="top">';

							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								if($rowCli['nFactPend'] > 0){
									echo '<img src="imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
								}
							}
							if($row['correoInicioPAM'] == 'on'){
								echo '<br><img src="imagenes/draft_16.png" align="left">';
							}
						echo ' 	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}



// AF

function mRAMsAF($il, $tl){
		echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloTv">';
		echo '		<tr>';
		echo '			<td  width="10%" align="center" height="40">PAM			 </td>';
		echo '			<td  width="10%">							Ini.		 </td>';
		echo '			<td  width="10%">							Tér.		 </td>';
		echo '			<td  width="10%">							Días	 	 </td>';
		echo '			<td  width="20%">							Clientes	 </td>';
		echo '			<td  width="30%">							Observaciones</td>';
		echo '			<td  width="10%">										 </td>';
		echo '		</tr>';
		echo '	</table>';
		echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoTv">';
		$n 		= 0;
		$link=Conectarse();
		
		//$bdEnc=$link->query("SELECT * FROM Cotizaciones Where (tpEnsayo = 2 or tpEnsayo = 1) and RAM > 0 and Estado = 'P' Order By RAM Asc Limit $il, $tl");
		// $bdEnc=$link->query("SELECT * FROM cotizaciones Where tpEnsayo > 2 and RAM > 0 and Estado = 'P' and usrCotizador in ('ACA', 'MRR', 'SCM', 'MMG') Order By RAM Asc Limit $il, $tl");

		$bdEnc=$link->query("SELECT * FROM cotizaciones Where (tpEnsayo = 2 or tpEnsayo = 1) and RAM > 0 and Estado = 'P' and usrResponzable in ('ACA', 'MRR', 'SCM', 'MMG') Order By RAM Asc Limit $il, $tl");
		if ($row=mysqli_fetch_array($bdEnc)){
			do{
				list($ftermino, $dhf, $dha, $dsemana) = fnDiasHabiles($row['fechaInicio'],$row['dHabiles'],$row['horaPAM']);


				$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
				$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

				$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
				$ft = $row['fechaInicio'];
				$dh	= $row['dHabiles']-1;
				$dd	= 0;
				for($i=1; $i<=$dh; $i++){
					$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
					$ft	= date ( 'Y-m-d' , $ft );
					$dia_semana = date("w",strtotime($ft));
					//echo $ft;
					/*
					$dbf=$link->query("SELECT * FROM diasferiados Where fecha = '$ft'");
					if ($rs=mysqli_fetch_array($bdf)){
						echo $rs['fecha'];
					}
					*/
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
				if($dhf > 0){ // Enviada
					$tr = 'bVerde';
					if($dhf == 2 or $dhf ==1){ // En Proceso
						$tr = "bAmarilla";
					}
				}
				if($dha > 0){ // Enviada
					$tr = 'bRoja';
				}

				
				echo '<tr id="'.$tr.'">';
				echo '	<td width="10%">';
						echo 	'R'.$row['RAM'].'<br>';
						echo 	'C'.$row['CAM'];
						if($row['Cta']){
							echo '<br>CC';
						}
							// Verificar si tiene Facturas Pendientes de Pago
							$sDeuda = 0;
							$cFact	= 0;
							$fechaHoy = date('Y-m-d');
							$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
							$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
							$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
							if($rowDe=mysqli_fetch_array($bdDe)){
								do{
									if($rowDe['fechaFactura'] > '0000-00-00'){
										if($rowDe['fechaFactura'] < $fecha90dias){
											$sDeuda += $rowDe['Bruto'];
											$cFact++;
										}
									}
								}while ($rowDe=mysqli_fetch_array($bdDe));
							}
							if($sDeuda > 0){
								?>
								<script>
									var RutCli = '<?php echo $row["RutCli"]; ?>';
								</script>
								<?php
								echo '<br><img src="imagenes/bola_amarilla.png">';
							}
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								if($rowCli['Clasificacion'] == 1){
									echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
									echo '<img src="imagenes/Estrella_Azul.png" width=10>';
									echo '<img src="imagenes/Estrella_Azul.png" width=10>';
								}else{	
									if($rowCli['Clasificacion'] == 2){
										echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
										echo '<img src="imagenes/Estrella_Azul.png" width=10>';
									}else{
										if($rowCli['Clasificacion'] == 3){
											echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
										}
									}
								}
								
							}
							//Fin Verificación Deuda
						
				echo '	</td>';
				echo '	<td width="10%">';
							if($row['fechaInicio'] != 0){
								$fd = explode('-', $row['fechaInicio']);
								echo $fd[2].'/'.$fd[1];
								echo '<br>'.$row['usrResponzable'];
							}else{
								echo 'NO Asignado';
							}?>
							<div style="clear:both;"></div>
							<?php
									if($row['tpEnsayo'] == 1){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												IC
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 2){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												AF
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 3){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												CE
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 4){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Análisis de Falla">
												IR
											</div>
										<?php
									}
									if($row['tpEnsayo'] == 5){
										?>
											<div style="background-color:#666666; color:#FFFFFF; border:1px solid #000; padding:2px;" title="Informe Oficial">
												IO
											</div>
										<?php
									}
				echo '	</td>';
				echo '	<td width="10%">';
							if($row['fechaInicio'] != 0){
								echo number_format($row['dHabiles'], 0, ',', '.').' días';
								$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
								$fechaHoy = date('Y-m-d');
								$dsemana = date("w",strtotime($ftermino));
								$fdt = explode('-', $ftermino);
								echo '<br>'.$dSem[$dsemana];
								echo '<br>'.$fdt[2].'/'.$fdt[1];
							}else{
								echo number_format($row['dHabiles'], 0, ',', '.').' dí­as';
								echo '<br>Sin asignar';
							}
				echo ' 	</td>';
				echo '	<td width="10%">';
							if($row['fechaInicio'] != 0){

								if($dhf > 0 and $dha == 0){ // En Proceso
									if($dhf == 1){ // En Proceso
										echo '<div class="sVencerVerde">';
										echo 	$dhf;
										echo '</div';
									}else{
										echo '<div class="sVencer">';
										echo 	$dhf;
										echo '</div';
									}
								}
								if($dha > 0){ // En Proceso
									echo '<div class="pVencer" title="Atraso">';
									echo 	$dha;
									echo '</div';
								}
							}else{
								echo number_format($row['dHabiles'], 0, ',', '.').' dí­as';
								echo '<br>Sin asignar';
							}
				echo ' 	</td>';

				echo '	<td width="20%">';
					$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
					if($rowCli=mysqli_fetch_array($bdCli)){
						echo 	'<span style="font-size:10px;">'.substr($rowCli['Cliente'],0,20).'</span>';
					}
				echo '	</td>';
				echo '	<td width="30%">';
							if($row['Descripcion']){
								echo substr($row['Descripcion'],0,50).'...';
							}
				echo ' 	</td>';
				echo '	<td valign="top">';

					$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
					if($rowCli=mysqli_fetch_array($bdCli)){
						if($rowCli['nFactPend'] > 0){
							echo '<img src="imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
						}
					}
					if($row['correoInicioPAM'] == 'on'){
						echo '<br><img src="imagenes/draft_16.png" align="left">';
					}
				echo ' 	</td>';
				echo '</tr>';
			}while ($row=mysqli_fetch_array($bdEnc));
		}
		$link->close();
		echo '	</table>';
	}

// Fin AF			







function verEnsayosenProceso($Periodo){
	?>


  <div class="toast" data-autohide="false">
    <div class="toast-header">
      <strong class="mr-auto text-primary">Ensayos en Procesos</strong>
      <small class="text-muted">5 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
			<?php
				$link=Conectarse();
				$bdEn=$link->query("SELECT * FROM amEnsayos Where Status = 'on' Order By nEns");
				while($rowEn=mysqli_fetch_array($bdEn)){
						if($rowEn['idEnsayo'] == 'Tr'){
							$bdTp=$link->query("SELECT * FROM amTpsMuestras where idEnsayo = 'Tr' Order By idEnsayo Desc");
							while($rowTp=mysqli_fetch_array($bdTp)){
								?>
											<?php 
												$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowEn['idEnsayo']."' and tpMuestra = '".$rowTp['tpMuestra']."'");
												if($rowEp=mysqli_fetch_array($bdEp)){?>
													<span class="badge badge-secondary">
													<b><?php echo $rowEn['idEnsayo'].' '.$rowTp['tpMuestra']; ?> </b>
													<?php
													echo $rowEp['enProceso'].'('.$rowEp['conRegistro'].')'; 
													?>
													</span>
													<?php
												}
											?>
										
									
								

									<?php
							}
						}else{
							 
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowEn['idEnsayo']."'");
							if($rowEp=mysqli_fetch_array($bdEp)){?>
								<span class="badge badge-secondary">
								<b><?php echo $rowEn['idEnsayo']; ?> </b>
								<?php
								echo $rowEp['enProceso'].'('.$rowEp['conRegistro'].')'; 
								?>
								</span>
								<?php
							}
							
							
						}
				}
				$link->close();
			?>
		</div>
	</div>

  	<div class="toast" data-autohide="false">
    	<div class="toast-header">
      		<strong class="mr-auto text-primary">PreCAM</strong>
      		<button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    	</div>
    	<div class="toast-body">
			<?php
				$link=Conectarse();
				$bdEn=$link->query("SELECT * FROM precam Where Estado = 'on'");
				while($rs=mysqli_fetch_array($bdEn)){?>
					<div class="alert alert-danger">
				    	<strong>
				    		<?php echo $rs['usrResponsable']; ?><sup><?php echo $rs['fechaPreCAM']; ?></sup> 
				    	</strong> 
				    	<?php echo substr($rs['Correo'],0,50); ?>...
				  	</div>					
				  	<?php
				}
				$link->close();
			?>

    	</div>
	</div>

		
	<?php
}
			
			
function cuentaEnsayosActivos($Periodo){
	$link=Conectarse();
/*	
	$bd=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."'");
	if($row = mysqli_fetch_array($bd)){
		
		
		
		
		
	}else{
*/		
		$cuentaEnsayos 	= 0;
		$enProceso 		= 0;
		$conRegistro	= 0;
		$bdCAM=$link->query("DELETE FROM ensayosProcesos Where Periodo = '".$Periodo."'");
		$bdCAM=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P'"); //     or RAM = 10292 or RAM = 10536 or RAM = 10666
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			do{
				$sumaEnsayos = 0;
				$RAM = $rowCAM['RAM'];
				
				$bdOtam=$link->query("SELECT * FROM Otams Where RAM = '".$rowCAM['RAM']."'");
				if($rowOtam=mysqli_fetch_array($bdOtam)){
					do{
						
						$sumaEnsayos++;
						
						if($rowOtam['idEnsayo'] == 'Tr'){
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'");
						}else{
							$bdEp=$link->query("SELECT * FROM ensayosProcesos Where Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'");
						}
						if($rowEp=mysqli_fetch_array($bdEp)){
							if($rowCAM['Estado'] == 'P'){
								$enProceso 		= $rowEp['enProceso'];
								$conRegistro	= $rowEp['conRegistro'];
							
								$enProceso += 1;
								if($rowOtam['Estado'] == 'R'){
									$conRegistro++;
								}
								$actSQL  ="UPDATE ensayosProcesos SET ";
								$actSQL .= "enProceso 	= '".$enProceso.	"', ";
								$actSQL .= "conRegistro = '".$conRegistro.	"' ";
								if($rowOtam['idEnsayo'] == 'Tr'){
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."' and tpMuestra = '".$rowOtam['tpMuestra']."'";
								}else{
									$actSQL .="WHERE Periodo = '".$Periodo."' and idEnsayo = '".$rowOtam['idEnsayo']."'";
								}
								$bdProc=$link->query($actSQL);
							}
						}else{
							$idEnsayo 		= $rowOtam['idEnsayo'];
							$tpMuestra 		= $rowOtam['tpMuestra'];
							$enProceso  	= 1;
							$conRegistro 	= 0;
							if($rowOtam['Estado'] == 'R') {
								$conRegistro = 1;
							}
							$link->query("insert into ensayosProcesos	(	Periodo,
																			idEnsayo,
																			tpMuestra,
																			enProceso,
																			conRegistro
																		) 
																values 	(	'$Periodo',
																			'$idEnsayo',
																			'$tpMuestra',
																			'$enProceso',
																			'$conRegistro'
																		)"
										);
						}							
					}while ($rowOtam=mysqli_fetch_array($bdOtam));
					
				}
			}while ($rowCAM=mysqli_fetch_array($bdCAM));
		}
	//}
	$link->close();
}
?>
