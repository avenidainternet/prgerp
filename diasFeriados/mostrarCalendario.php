<?php
	
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
	
	$diaSemana = array(
					1 => 'Lun.', 
					2 => 'Mar.',
					3 => 'Mie.',
					4 => 'Jue.',
					5 => 'Vie.',
					6 => 'Sab.',
					7 => 'Dom.',
				);
				
				
	$fd 	= explode('-', date('Y-m-d'));
	$Agno = date('Y');
	$fecha = '';
	if(isset($_GET['Agno'])){
		$Agno = $_GET['Agno'];
	}
	
	if(isset($_GET['fecha'])){
		$fecha 	 = $_GET['fecha'];
		$fd		 = explode('-', $fecha);
		$Periodo = $fd[0];

		$link=Conectarse();
		$SQL = "SELECT * FROM diasferiados WHERE fecha = '".$_GET['fecha']."'";
		$bdDf=$link->query($SQL);
		if($row=mysqli_fetch_array($bdDf)){
			$bdDf=$link->query("DELETE FROM diasferiados WHERE fecha = '".$_GET['fecha']."'");
		}else{
			$link->query("insert into diasferiados(	Periodo,
													fecha
												)	 
									  values 	(	'$Periodo',
													'$fecha'
									  			)");
			
		}
		$link->close();
		
	}
	//echo 'fecha '.$fecha;
	$dBuscado 	= '';
	$filtroSQL 	= '';
	
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="../plataformaErp.php" title="Menú Principal">
				<img src="../gastos/imagenes/Menu.png"></a>
			<br>
			Principal
		</div>
		<select name="Agno" Id="Agno" onChange="window.location = this.options[this.selectedIndex].value; return true;">
			<option value="index.php?Agno=<?php echo $Agno; ?>"><?php echo $Agno; ?></option>
			<?php
				for($i=date('Y'); $i <= date('Y')+6; $i++){
					?><option value="index.php?Agno=<?php echo $i; ?>"><?php echo $i; ?></option><?php
				}
			?>
			
		</select>
	</div>

	<?php
		for($mes=1; $mes<=12; $mes++){
			?>
			<div id="cuadroMes">
				<div class="idMes">
					<?php echo $Mes[$mes];?>
					<table width="100%" cellpadding="0" cellspacing="0" border=1>
						<tr>
							<?php for($ds=1; $ds<=7; $ds++){?>
								<td>
									<?php echo $diaSemana[$ds]; ?>
								</td>
							<?php } ?>
						</tr>
						<?php 
							$tDiasMes = 31;
							if($mes == 1 or $mes == 3 or $mes == 5 or $mes == 7 or $mes == 8 or $mes == 10 or $mes == 12){
								$tDiasMes = 31;
							}
							if($mes == 4 or $mes == 6 or $mes == 9 or $mes == 11){
								$tDiasMes = 30;
							}
							if($mes == 2){
								$tDiasMes = 28;
								if($fd[0] == (intval($fd[0]/4))*4){
									$tDiasMes = 29;
								}
							}
							
							for($dias = 1; $dias<=$tDiasMes; $dias++){
								$dd = $dias;
								if($dias < 10) { $dd = '0'.$dias; }
								$mm = $mes;
								if($mes < 10) { $mm = '0'.$mes; }
								$fecha = strtotime("$Agno-$mm-$dd");
								$fecha = date('Y-m-d',$fecha);
								$td = 'diaNormal';

								$link=Conectarse();
								$SQL = "SELECT * FROM diasferiados Where fecha = '".$fecha."'";
								//echo $SQL;
								$bdDf=$link->query($SQL);
								if($row=mysqli_fetch_array($bdDf)){
									$td = 'diaFeriado';
								}
								//echo $dFeriado;
								if(date('N', strtotime($fecha)) > 1 and $dias == 1){
									echo '<tr style="background-color:#fff;">';
									for($i=1; $i<date('N', strtotime($fecha)); $i++){
										echo '	<td> </td>';
									}
								}
								if(date('N', strtotime($fecha)) == 1){?>
									<tr style="background-color:#fff;">
										<td>
											<a class="<?php echo $td;?>" href="index.php?fecha=<?php echo $fecha; ?>"><?php echo $dias; ?></a>
										</td>
									<?php
								}
								if(date('N', strtotime($fecha)) > 1 and date('N', strtotime($fecha)) < 7){
									if(date('N', strtotime($fecha)) == 6){
										echo '	<td style="color:red;">'.$dias.'</td>';
									}else{?>
										<td>
											<a class="<?php echo $td;?>" href="index.php?fecha=<?php echo $fecha; ?>" ><?php echo $dias; ?></a>
										</td>
									<?php
									}
								}
								if(date('N', strtotime($fecha)) == 7){
									echo '	<td style="color:red;">'.$dias.'</td>';
									echo '</tr>';
								}
								
							} 
						?>
					</table>
				</div>
			</div>
			<?php
		}
	?>
