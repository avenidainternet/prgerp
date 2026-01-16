<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET[CAM]))  		{ $CAM		= $_GET[CAM]; 		}
	if(isset($_GET[RAM]))  		{ $RAM		= $_GET[RAM]; 		}
	if(isset($_GET[idItem]))  	{ $idItem	= $_GET[idItem]; 	}
	if(isset($_GET[dBuscar]))  	{ $dBuscar  = $_GET[dBuscar]; 	}
	if(isset($_GET[accion]))  	{ $accion	= $_GET[accion]; 	}
?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td  width="10%" align="center" height="40"><strong>OTAMs 					</strong></td>
			<td  width="38%">							<strong>Objetivo	 			</strong></td>
			<td  width="10%">							<strong>Tipo <br>Muestra		</strong></td>
			<td  width="10%">							<strong>Ind. <br>Imp.			</strong></td>
			<td  width="10%">							<strong>T°						</strong></td>
			<td  width="10%">							<strong>Serv. <br>Taller 		</strong></td>
			<td  width="12%" align="center" colspan="3"><strong>Acciones				</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
		$link=Conectarse();
		$filtroSQL .= " idItem = '".$idItem."'";
		
		$SQL = "SELECT * FROM OTAMs Where $filtroSQL Order By Otam";
		
		$bdfRAM=mysql_query($SQL);
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			do{
				$tr = "bVerde";
				if($rowfRAM[tpMuestra]==''){
					$tr = 'bAmarilla';
				}
				echo '<tr id="'.$tr.'">';
				echo '	<td width="09%" style="font-size:16px;"  align="center">';
							echo $rowfRAM[Otam];
				echo '	</td>';
				echo '	<td width="38%" style="font-size:16px;">';
							echo $rowfRAM[ObsOtam];
				echo '	</td>';
				echo '	<td width="10%" style="font-size:16px;">';
							$tm = explode('-',$rowfRAM[Otam]);
							if(substr($tm[1],0,1) == 'T'){ $idEnsayo = 'Tr'; }
							if(substr($tm[1],0,1) == 'Q'){ $idEnsayo = 'Qu'; }
							if(substr($tm[1],0,1) == 'C'){ $idEnsayo = 'Ch'; }
							if(substr($tm[1],0,1) == 'D'){ $idEnsayo = 'Du'; }
							
							$bdTm=mysql_query("SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."' and tpMuestra = '".$rowfRAM[tpMuestra]."'");
							if($rowTm=mysql_fetch_array($bdTm)){
								echo $rowTm[Muestra];
							}
							
				echo '	</td>';
				echo '	<td width="10%" style="font-size:16px;">';
							$fd=explode('-', $rowfRAM[Otam]);
							if(substr($fd[1],0,1) == 'D' or substr($fd[1],0,1) == 'C'){
								echo $rowfRAM[Ind];
							}else{
								echo '-';
							}
				echo '	</td>';
				echo '	<td width="10%" style="font-size:16px;">';
							$fd=explode('-', $rowfRAM[Otam]);
							if(substr($fd[1],0,1) == 'C'){
								echo $rowfRAM[Tem];
							}else{
								echo '-';
							}
				echo '	</td>';
				echo '	<td width="10%" style="font-size:16px;">';

							if($rowfRAM[rTaller] == 'on'){
								$bdST=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
								if($rowST=mysql_fetch_array($bdST)){
									echo $rowST[nSolTaller];
								}
							}else{
								echo 'NO';
							}
							
				echo '	</td>';
				echo '	<td width="6%">';
							echo '<a href="idOtams.php?accion=Editar&RAM='.$RAM.'&idItem='.$rowfRAM[idItem].'&Otam='.$rowfRAM[Otam].'"	><img src="../imagenes/actividades.png" 	width="50" title="Identificar Muestra y Definir Ensayos"	>	</a>';
				echo '	</td>';
				echo '	<td width="6%">';
							//echo '<a href="asInforme.php?accion=Editar&RAM='.$RAM.'&idItem='.$rowfRAM[idItem].'"	><img src="../imagenes/extra_column.png"   	width="50" title="Asociar a Informe"	>	</a></td>';
				echo '</tr>';
			}while($rowfRAM=mysql_fetch_array($bdfRAM));
		}
		mysql_close($link);
		?>
	</table>
</div>
