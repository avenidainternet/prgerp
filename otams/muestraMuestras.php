<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	//session_start(); 
	//include_once("conexion.php");
	$tEns = 0;
	if(isset($_GET['CAM']))  		{ $CAM		= $_GET['CAM']; 		}
	if(isset($_GET['RAM']))  		{ $RAM		= $_GET['RAM']; 		}
	if(isset($_GET['dBuscar']))  	{ $dBuscar  = $_GET['dBuscar']; 	}
	if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 	}
	$txtEnsayos = '';
?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td  width="08%" align="center" height="40"><strong>Id.SIMET				</strong></td>
			<td  width="40%" align="center">			<strong>Identificación Cliente 	</strong></td>
			<td  width="10%">							<strong>Serv.<br>Taller 		</strong></td>
			<td  width="20%">							<strong>OTAMs 					</strong></td>
			<td  width="22%" align="center" colspan="3"><strong>Acciones				</strong></td>
		</tr>
		<?php
		$link=Conectarse();
		$bdfRAM=mysql_query("SELECT * FROM amMuestras Where idItem Like '%".$RAM."%' Order By idItem");
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			do{
				$tr = "bBlanca";
				if($rowfRAM['idMuestra'] != ''){
					$tr = "bRoja";
					$i = 0;
					$txtEnsayos = '';
					$bdCot=mysql_query("Select * From amTabEnsayos Where idItem = '".$rowfRAM['idItem']."'");
					if($rowCot=mysql_fetch_array($bdCot)){
						do{
							$tr = "bVerde";
							$i++;
							if($i > 1){ 
								$txtEnsayos .= ', '.$rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].')';
							}else{
								$txtEnsayos = $rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].')';
							}
						}while($rowCot=mysql_fetch_array($bdCot));
					}

				}
				?>
				<tr id="<?php echo $tr; ?>" class="seleccion">
					<td width="08%" style="font-size:16px;"  align="center">
						<?php echo $rowfRAM['idItem']; ?>
					</td>
					<td width="40%" style="font-size:16px;">
						<?php echo $rowfRAM['idMuestra']; ?>
					</td>
					<td width="10%" style="font-size:16px;">
						<?php
							if($rowfRAM['Taller'] == 'on'){
								$bdCot=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
								if($rowCot=mysql_fetch_array($bdCot)){
									echo $rowCot['nSolTaller'];
								}
							}
						?>
					</td>
					<td width="20%" style="font-size:12px;" align="left">
						<?php echo $txtEnsayos; ?>
					</td>
					<td width="18%" colspan="3" align="center">
						<a href="idMuestras2.php?accion=Editar&RAM=<?php echo $RAM; ?>&idItem=<?php echo $rowfRAM['idItem']; ?>"><img src="../imagenes/actividades.png" 	width="50" title="Identificar Muestra y Definir Ensayos"	>	</a>
					</td>
				</tr>
				<?php
			}while($rowfRAM=mysql_fetch_array($bdfRAM));
		}
		mysql_close($link);
		?>
	</table>
</div>
