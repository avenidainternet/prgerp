		<?php
			if(isset($_GET['CAM']))  		{ $CAM		= $_GET['CAM']; 	}
			if(isset($_GET['RAM']))  		{ $RAM		= $_GET['RAM']; 	}
			$mesAct = date('m');
			if(isset($_GET['mesAct']))  	{ $mesAct  = $_GET['mesAct']; 	}
			if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 	}


		?>
<table cellpadding="0" cellspacing="0" border="0" width="99%">
	<tr>
		<?php
			$year 	= date('Y');
			$oFecha = new objFecha();

			$nAct = $oFecha -> semanaActual(); 
			$nActual = $oFecha -> semanaActual();
			$year = date('Y');
			for($i=1; $i<=5; $i++){
				?>
				<td width="20%" valign="top">
					<table class="table table-dark table-hover table-bordered table-sm text-center">
						<thead>
							<tr>
								<th>
									<?php
									echo 'Semana '.$i;
									$n = ($i-1) * 7;
									// 0, 7, 14, 21, 35
									$pd = $oFecha -> primerDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), ($n+4));
									$ud = $oFecha -> ultimoDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), $n-2);
									echo '<br>'.$oFecha -> primerDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), ($n+4)).' '.$oFecha -> ultimoDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), $n-2);
									$pDia 		= $oFecha -> primerDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), ($n+4));
									$fechaWeek 	= $oFecha -> ultimoDiaHabilSemanaAnt($oFecha -> ultimoDiaSemana($nActual), $n-2);
									$nAct--;
									if($nAct<=0){
										$year--;
										$nAct = $oFecha -> NumeroSemanasAno($year);
									}?>
									<!--
									<button type="button" 
											class="btn btn-info btn-sm btn-block"
											ng-click="imprimeRamsDia('<?php echo $pd; ?>', '<?php echo $ud; ?>')"> 
										<h5>Impimir Día Semana</h5>
									</button>
								-->
									<a class="btn btn-info btn-sm btn-block" href="imprimeRams.php?fd=<?php echo $pd; ?>&fh=<?php echo $ud;?>">Imprimir</a>
								</th>
							</tr>
						</thead>
					<!-- </table>
					 	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado"> -->
					 	<tbody>
					 		
						<?php
							$link=Conectarse();
												
							//$filtroSQL ="Estado = 'T' and RAM > 0 and fechaTermino >= '".$pDia."' and fechaTermino <= '".$fechaWeek."' and Archivo != 'on'";
							$filtroSQL ="Estado = 'T' and RAM > 0 and fechaTermino >= '".$pDia."' and fechaTermino <= '".$fechaWeek."'";
							$SQL = "SELECT * FROM Cotizaciones Where $filtroSQL Order By fechaTermino Asc";
							$bdEns=$link->query($SQL);
							while($rowEns=mysqli_fetch_array($bdEns)){
									$tr = "table-light";
									$btn = "btn btn-light btn-block";
									if($rowEns['RAMarchivada'] == 'on'){ 
										$tr = "table-success";
										$btn = "btn btn-success btn-block";
									}
									?>
									<tr class="<?php echo $tr; ?>">
										<td height="40">
											<a 	class="<?php echo $btn; ?>" 
												href="ramTerminadas.php?RAM=<?php echo $rowEns['RAM']; ?>">
												<b style='font-size:20px;'><?php echo $rowEns['RAM']; ?></b><br>
												<?php
													$tEnsayos = array(	
																	'Fr' 	=> 0, 
																	'Mg' 	=> 0,
																	'S' 	=> 0,
																	'Qu' 	=> 0,
																	'Tr' 	=> 0,
																	'Do' 	=> 0,
																	'Du' 	=> 0,
																	'Md' 	=> 0,
																	'Ch'	=> 0,
																	'M' 	=> 0,
																	'El' 	=> 0,
																	'Pl'	=> 0,
																	'Qv'	=> 0,
																	'DFX'	=> 0,
																	'Ot'	=> 0
																);
												

													$sqlm = "SELECT idEnsayo, cEnsayos FROM amtabensayos Where IdItem like  '%".$rowEns['RAM']."%'";
													//echo $sqlm;
													$bdm=$link->query($sqlm);
													while($rowm=mysqli_fetch_array($bdm)){
														$tEnsayos[$rowm['idEnsayo']] += $rowm['cEnsayos'];
													}
													foreach ($tEnsayos as $key => $valor) {
														if($valor > 0){
															echo "<span style='font-size:14px;'>$key=($valor)</span>";
														}
													}
													
												?>
											</a>
										</td>
									</tr>
									<?php
							} // Fin
												
							$link->close();
						?>
						</tbody>

					</table>

					
				</td>
				<?php
			}
			?>
		</tr>

</table>

<?php

	//list($primeraSemana,$ultimaSemana)=semanasMes($year,$mesAct);
    //echo "<br>Mes: ".$mesAct."/".$year." - Primera semana: ".$primeraSemana." - Ultima semana: ".$ultimaSemana;
	
function semanasMes($year,$month)
{
    # Obtenemos el ultimo dia del mes
    $ultimoDiaMes=date("t",mktime(0,0,0,$month,1,$year));
 
    # Obtenemos la semana del primer dia del mes
    $primeraSemana=date("W",mktime(0,0,0,$month,1,$year));
 
    # Obtenemos la semana del ultimo dia del mes
    $ultimaSemana=date("W",mktime(0,0,0,$month,$ultimoDiaMes,$year));
 
    # Devolvemos en un array los dos valores
    return array($primeraSemana,$ultimaSemana);
}

?>