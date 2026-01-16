	<table width="100%" height="74"  border="0" align="center" cellpadding="0" cellspacing="0" class="degradado" id="Transparente">
  		<tr>
    		<td width="8%">
				<div align="center">
					<img src="../imagenes/simet.png" width="119" height="58">
				</div>
			</td>
    		<td width="86%"> 
				<div align="center" class="titulos">
      				<div align="left" class="titulo">
        				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	          				<tr>
	            				<td colspan="3">&nbsp;</td>
	          				</tr>
	          				<tr>
	            				<td colspan="2">Servicio de Ingeniería Metalúrgica y Materiales</td>
	          				</tr>
	          				<tr>
    	        				<td>
									<?php 
										$nCols = round($nRams/10);
										echo $_SESSION[tRams]; 
									?>
								</td>
	            				<td width="2%">&nbsp;</td>
	          				</tr>
	        			</table>
	      			</div>
    			</div>
			</td>
    		<td width="6%">
				<?php
					$link=Conectarse();
					$fechaHoy = date('Y-m-d');
					$fd 	= explode('-', $fechaHoy);
					
/*
					$result   = mysql_query("SELECT SUM(Neto) as tNeto FROM SolFactura WHERE month(fechaSolicitud) = '".$fd[1]."'");
					$rowInd	  = mysql_fetch_array($result);
					$indVtas  = round($rowInd['tNeto']/1000000,2);
*/

					$bdSol   = mysql_query("SELECT * FROM SolFactura Where month(fechaSolicitud) = '".$fd[1]."'");
					if($rowSol=mysql_fetch_array($bdSol)){
						do{
								$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowSol[RutCli]."'");
								if ($rowP=mysql_fetch_array($bdPer)){
									$cFree = $rowP[cFree];
									if($rowP[cFree] != 'on' or $rowP[Docencia] != 'on'){
										if($rowSol[Neto]>0){
											$tNeto += $rowSol[Neto];
										}
									}
								}
							}while ($rowSol=mysql_fetch_array($bdSol));
					}
					$indVtas  = round($tNeto/1000000,2);
					
					$mesInd   = intval($fd[1]);
					$agnoInd  = intval($fd[0]);
					
					$bdInd=mysql_query("Select * From tablaIndicadores Where mesInd	= '".$mesInd."' and agnoInd = '".$agnoInd."'");
					//$bdInd=mysql_query("SELECT * FROM tablaRegForm");
					if($row=mysql_fetch_array($bdInd)){
						$indMin  = $row[indMin];
						$indMeta = $row[indMeta];
					}
					$iMin = round((($indMin / 30) * $fd[2]),2);
					$iMet = round((($indMeta / 30) * $fd[2]),2);
					mysql_close($link);
					
					$cIndice = "indIndiceRojo";
					if($iMin > $indMin) { $iMin = $indMin; }
					if($iMet > $indMeta){ $iMet = $indMeta; }
					
					if($indVtas > $iMin and $indVtas > $iMet){
						$cIndice = "indIndiceVerde";
					}
					if($indVtas > $iMin and $indVtas < $iMet){
						$cIndice = "indIndiceAmarillo";
					}
					if($indVtas < $iMin and $indVtas < $iMet){
						
						$cIndice = "indIndiceRojo";
					}

					
				?>
				
				<div align="left">
					<table>
						<tr>
							<?php
								$cIndiceMin = "indIndice";
											if($indVtas >= $iMin)	{ 
												$cIndiceMin = "indIndiceVerde";
											}else{
												$cIndiceMin = "indIndiceRojo"; 
											}
/*
								if($indVtas >  $iMin)	{ $cIndiceMin = "indIndiceVerde"; 		}
								if($indVtas == $iMin)	{ $cIndiceMin = "indIndiceAmarillo"; 	}
								if($indVtas <  $iMin)	{ $cIndiceMin = "indIndiceRojo"; 		}
*/
							?>
							<td class="<?php echo $cIndiceMin; ?>">
								<span style="font-size:12px; ">Mínimo</span>
								<?php echo number_format($indMin, 2, ',', '.');?>
							</td>
							<?php
								$cIndiceMin = "indIndice";
											if($indVtas >= $iMet)	{ 
												$cIndiceMin = "indIndiceVerde"; 		
											}else{
												$cIndiceMin = "indIndiceRojo"; 		
											}
/*
								if($indVtas >  $iMet)	{ $cIndiceMin = "indIndiceVerde"; 		}
								if($indVtas == $iMet)	{ $cIndiceMin = "indIndiceAmarillo"; 	}
								if($indVtas <  $iMet)	{ $cIndiceMin = "indIndiceRojo"; 		}
*/
							?>
							<td class="<?php echo $cIndiceMin; ?>">
								<span style="font-size:12px; ">Meta</span>
								<?php echo number_format($indMeta, 2, ',', '.');?>
							</td>
								<?php
											$cIndice = "indIndice";
											if($indVtas >= $iMin)	{ 
												$cIndice = "indIndiceVerde"; 		
												if($indVtas >= $iMet)	{ 
													$cIndice = "indIndiceVerde"; 		
												}else{
													$cIndice = "indIndiceAmarillo";
												}
											}else{
												$cIndice = "indIndiceRojo"; 		
											}
								?>
							<td class="<?php echo $cIndice; ?>">
								<span style="font-size:12px; ">Indice</span>
								<?php echo number_format($indVtas, 2, ',', '.');?>
							</td>
						</tr>
					</table>
				</div>
				<!--
				<div align="left">
					<img src="imagenes/Logo-Color-Usach-Web-Ch.png" >
				</div>
				-->
			</td>
  		</tr>
	</table>
