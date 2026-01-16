<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET[CAM]))  		{ $CAM		= $_GET[CAM]; 		}
	if(isset($_GET[RAM]))  		{ $RAM		= $_GET[RAM]; 		}
	if(isset($_GET[dBuscar]))  	{ $dBuscar  = $_GET[dBuscar]; 	}
	if(isset($_GET[accion]))  	{ $accion	= $_GET[accion]; 	}
?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td  width="06%" align="center" height="40"><strong>RAM				</strong></td>
			<td  width="06%" align="center">			<strong>Resp.			</strong></td>
			<td  width="20%" align="center">			<strong>Cliente			</strong></td>
			<td  width="24%">							<strong>Observación		</strong></td>
			<td  width="10%" align="center">			<strong>Serv.<br>Taller	</strong></td>
			<td  width="08%" align="center">			<strong>Fecha<br>Inicio	</strong></td>
			<td  width="08%" align="center">			<strong>N°<br>Muestras	</strong></td>
			<td  width="18%" align="center" colspan="3"><strong>Acciones		</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
		$link=Conectarse();
		$filtroSQL = " Archivada != 'on' ";
		if($accion == 'Filtrar'){
			$filtroSQL .= " and  RAM = '".$RAM."'";
		}
		
		$SQL = "SELECT * FROM formRAM Where $filtroSQL Order By fechaInicio";
		
		$bdfRAM=mysql_query($SQL);
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			do{
				$tr = "bVerde";
				$bdOT=mysql_query("SELECT * FROM OTAMs Where RAM = '".$rowfRAM[RAM]."'");
				if($rowOT=mysql_fetch_array($bdOT)){
					$sqlOtams	= "SELECT * FROM OTAMs Where RAM = '".$rowfRAM[RAM]."' and tpMuestra = ''";  // sentencia sql
					$result 	= mysql_query($sqlOtams);
					$tBl 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
					if($tBl == 0){
						$tr = "bVerde";
					}else{
						$tr = "bAmarilla";
					}
				}else{
					$tr = "bRoja";
				}
				echo '<tr id="'.$tr.'">';
				echo '	<td width="06%" style="font-size:16px;"  align="center">';
							echo 'R'.$rowfRAM[RAM].'<br>'.'C'.$rowfRAM[CAM];
				echo '	</td>';
				echo '	<td width="06%" style="font-size:16px;" align="center">';
							echo $rowfRAM[ingResponsable].'<br>'.$rowfRAM[cooResponsable];
				echo '	</td>';
				echo '	<td width="20%">';
							$bdCot=mysql_query("SELECT * FROM Cotizaciones Where RAM = '".$rowfRAM[RAM]."' and CAM = '".$rowfRAM[CAM]."'");
							if($rowCot=mysql_fetch_array($bdCot)){
								$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowCot[RutCli]."'");
								if($rowCli=mysql_fetch_array($bdCli)){
									echo $rowCli[Cliente];
								}								
							}
				echo '	</td>';
				echo '	<td width="24%">';
							echo $rowfRAM[Obs];
				echo '	</td>';
				echo '	<td width="10%">';
							if($rowfRAM[Taller] == 'on'){
								echo $rowfRAM[nSolTaller];
							}else{
								if($rowfRAM[nSolTaller] > 0){
									echo $rowfRAM[nSolTaller].'<span style="color:#FFFF00;font-weight:700;font-size:12px;"> * </span>';
								}
							}
				echo '	</td>';
				echo '	<td width="08%">';
							$fd = explode('-', $rowfRAM[fechaInicio]);
							echo $fd[2].'-'.$fd[1].'-'.$fd[0];
				echo '	</td>';
				echo '	<td width="04%">';
							if($rowfRAM[nMuestras] == 0){
								echo 'Sin<br>Esp.';
							}else{
								echo $rowfRAM[nMuestras];
							}
				echo ' 	</td>';
				echo '	<td width="6%">';
							if($tr == "bVerde" or $tr == "bAmarilla"){
								echo '<br>';
								echo '<a href="formularios/iRAM.php?accion=Imprimir&RAM='.$rowfRAM[RAM].'&CAM='.$rowfRAM[CAM].'"	><img src="../imagenes/newPdf.png" 	width="50" title="Imprimir Formulario RAM"	>	</a>';
							}
				echo '	</td>';
				echo '	<td width="6%">';
							echo '<a href="pOtams.php?accion=Actualizar&RAM='.$rowfRAM[RAM].'&CAM='.$rowfRAM[CAM].'"	><img src="../imagenes/actividades.png" 	width="50" title="Editar Formulario RAM"	>	</a>';
				echo '	</td>';
				echo '	<td width="6%">';
							echo '<a href="idMuestras.php?accion=Ver&RAM='.$rowfRAM[RAM].'&CAM='.$rowfRAM[CAM].'"	><img src="../imagenes/Tablas.png"   	width="50" title="Identificar Muestras"	>	</a></td>';
				echo '</tr>';
			}while($rowfRAM=mysql_fetch_array($bdfRAM));
		}
		mysql_close($link);
		?>
	</table>
</div>
