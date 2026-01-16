<?php
	session_start(); 
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: index.php");
	}

	$fd 	= explode('-', date('Y-m-d'));
	
	$Mes = array(	
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
	}else{
		$Mm = $Mes[intval($fd[1])];
	}
	$Periodo = $MesNum[$Mm].'.'.$fd[0];
	$TotalMes = 0;
				
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Resumen Sueldos</title>
<link href="styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usac.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	
}
-->
</style>

</head>

<body>
<table width="250px;"  border="0" cellspacing="0" cellpadding="0" id="CajaTitInfos">
	<tr>
    	<td>Tabla Resumen Mes: 
			<select name="Mes" onChange="window.location = this.options[this.selectedIndex].value; return true;">
				<?php
				for($i=1; $i <=12 ; $i++){
					if($Mes[$i]==$Mm){
						echo '<option selected value="resumensueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
					}else{
						if($i > $fd[1]){
							echo '<option style="opacity:.5; color:#ccc;" disabled value="resumensueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						}else{
							echo '<option value="resumensueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
						}
					}
				}
				?>
			</select>
		</td>
  	</tr>
</table>
<table width="250px;"  border="0" cellspacing="0" cellpadding="0" id="CajaCpoInfos">
	<tr>
    	<td>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
            	<tr>
                	<td><strong>Sueldos </strong></td>
                    <td>&nbsp;</td>
               	</tr>
                <tr>
                	<td width="36%" align="right">Sueldos : </td>
                    <td width="64%" align="right" style="padding:0 30px;">
						<?php
							$link=Conectarse();
							$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago = '".$Periodo."' && Estado = 'P'");
							$row 	 = mysql_fetch_array($result);
							if($row['tLiquido']>0){
								echo '<strong>$ '.number_format($row['tLiquido'], 0, ',', '.').'</strong>'; 
								$TotalMes += $row['tLiquido'];
							}
							mysql_close($link);
						?>
					</td>
             	</tr>
               	<tr>
                	<td colspan="2" id="TitInfos"><strong>Honorarios </strong></td>
               	</tr>
               	<tr>
                	<td align="right">Mensuales :  </td>
                    <td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
              	</tr>
              	<tr>
               		<td align="right">Esporadicos : </td>
                  	<td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Honorarios WHERE TpCosto = 'E' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
              	</tr>
               	<tr>
             		<td align="right">Inversi&oacute;n : </td>
                  	<td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Honorarios WHERE TpCosto = 'I' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Total'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
              	</tr>
            	<tr>
             		<td><strong>Facturas</strong></td>
              		<td align="right" style="padding:0 30px;">&nbsp;
					</td>
              	</tr>
             	<tr>
               		<td align="right">Mensuales: </td>
                  	<td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Facturas WHERE TpCosto = 'M' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
               	</tr>
              	<tr>
              		<td align="right">Esporadicos : </td>
                   	<td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Facturas WHERE TpCosto = 'E' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
             	</tr>
             	<tr>
              		<td align="right">Inversi&oacute;n : </td>
                  	<td align="right" style="padding:0 30px;">
						<?php
							$tTotal = 0;
							$link=Conectarse();
							//$result  = mysql_query("SELECT * FROM Honorarios WHERE PeriodoPago = '".$Periodo."' && TpCosto = 'I'");
							$result  = mysql_query("SELECT * FROM Facturas WHERE TpCosto = 'I' && Estado = 'P'");
							if ($row=mysql_fetch_array($result)){
								DO{
									$fd = explode('-', $row['FechaPago']);
									//if($fd[1]==$MesNum[$Mm]){
									if($Periodo==$row['PeriodoPago']){
										$tTotal += $row['Bruto'];
									}
								}WHILE ($row=mysql_fetch_array($result));
							}
							mysql_close($link);
							if($tTotal>0){
								echo '<strong>$ '.number_format($tTotal, 0, ',', '.').'</strong>';
								//echo '<strong>'.$MesNum[$Mm].'</strong>';
								$TotalMes += $tTotal;
							}
						?>
					</td>
              	</tr>
        	</table>
		</td>
  	</tr>
</table>
<table width="250px;"  border="0" cellspacing="0" cellpadding="0" id="CajaPieInfos">
	<tr>
		<td width="106">Total</td>
		<td width="192" align="right" style="padding:0 30px;">
			<?php
				echo '<strong>$ '.number_format($TotalMes, 0, ',', '.').'</strong>'; 
			?>
		</td>
	</tr>
</table>

</body>
</html>
