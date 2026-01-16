	<form name="form" action="ramTerminadas.php" method="get">
		<input name="mesAct" type="text" value="<?php $mesAct; ?>">
		<button name="enviar">
			Enviar
		</button>
	</form>
<table cellpadding="0" cellspacing="0" border="0" width="99%">
	<tr>
		<?php
			if(isset($_GET[CAM]))  		{ $CAM		= $_GET[CAM]; 		}
			if(isset($_GET[RAM]))  		{ $RAM		= $_GET[RAM]; 		}
			$mesAct = date('m');
			if(isset($_GET[mesAct]))  	{ $mesAct  = $_GET[mesAct]; 	}
			if(isset($_GET[accion]))  	{ $accion	= $_GET[accion]; 	}
			$year 	= date('Y');
			
			$semana 	= 0;
			$nSemana	= 0;
			$semanaOld 	= 99;
			$pDia		= 0;
			$uDia		= 0;
			
			$ultimoDiaMes=date("t",mktime(0,0,0,$mesAct,1,$year));
			
			for($i=1; $i<=$ultimoDiaMes; $i++){
				$fechaHoy = $year.'-'.$mesAct.'-'.$i;
				$dia_semana = date("w",strtotime($fechaHoy));
				if($dia_semana == 0 or $dia_semana == 6){
				
				}else{
					$semana = date("W",strtotime($fechaHoy));
					$uDia		= $fechaHoy;
					if($semana != $semanaOld){
						$nSemana++;
						$pDia 		= $fechaHoy;
						$fechaWeek 	= $fechaHoy;
						$nDia 		= date("N",strtotime($fechaHoy));
						$n 			= $i;
						
						while ($nDia < 5){
							$n++;
							$fechaWeek	= strtotime ( '+1 day' , strtotime ( $fechaWeek ) );
							$fechaWeek	= date ( 'Y-m-d' , $fechaWeek );
							//$fechaWeek = $year.'-'.$mesAct.'-'.$n;
							$nDia = date("N",strtotime($fechaWeek));
						}?>
						<td width="20%" valign="top">
						
							<table cellpadding="0" cellspacing="0" id="CajaTilulo">
								<tr>
									<td align="center" height="40">
										<?php
											echo 'Semana '.$nSemana.'<br>';
											echo date("d",strtotime($pDia)).' - '.date("d",strtotime($fechaWeek));
											
											$fPdia = $year.'-'.$mesAct.'-'.date(strtotime($pDia));
											$fUdia = $year.'-'.$mesAct.'-'.date("d",strtotime($fechaWeek));
											$semanaOld = $semana;
										?>
									</td>
								</tr>
							</table>
								
							<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
									<?php
										$link=Conectarse();
												
										$filtroSQL ="Estado = 'T' and RAM > 0 and fechaTermino >= '".$pDia."' and fechaTermino <= '".$fechaWeek."' and Archivo != 'on'";
										$SQL = "SELECT * FROM Cotizaciones Where $filtroSQL Order By fechaTermino Asc";
										$bdEns=mysql_query($SQL);
										if($rowEns=mysql_fetch_array($bdEns)){
											do{
												if($rowEns['Estado'] == 'T'){ 
													$tr = "bBlanca";
												}
												if($rowEns['informeUP'] == 'on'){ 
													$tr = "bAmarilla";
												}
												if($rowEns['Facturacion'] == 'on'){ 
													$tr = "bVerde";
												}
												if($rowEns['Archivo'] == 'on'){ 
													$tr = "bAzul";
												}
												if($rowEns['oCtaCte'] == 'on'){ 
													$tr = "barraNaranja";
												}
												$tr = "bBlanca";
												?>
												<tr id="<?php echo $tr; ?>">
													<td height="40">
														<!-- <a href="iTraccion.php?Otam=<?php echo $rowEns['RAM']; ?>"> -->
														<a href="#">
															<?php echo $rowEns['RAM']; ?>
														</a>
													</td>
												</tr>
												<?php
											}while($rowEns=mysql_fetch_array($bdEns));
										} // Fin
												
										mysql_close($link);
									?>
							</table>
							
						</td>													
						<?php
					}
				}
			}
		
		?>
	</tr>
</table>

<?php

	list($primeraSemana,$ultimaSemana)=semanasMes($year,$mesAct);
    echo "<br>Mes: ".$mesAct."/".$year." - Primera semana: ".$primeraSemana." - Ultima semana: ".$ultimaSemana;
	
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