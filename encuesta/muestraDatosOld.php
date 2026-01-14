	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; }
				
	$link=Conectarse();
	$bdRes=mysql_query("SELECT * FROM Encuestas Where nEnc = $nEnc");
	if($rowRes=mysql_fetch_array($bdRes)){
		$nResp = $rowRes[nResp];
	}
	$bdEnc=mysql_query("SELECT * FROM itEncuesta Where nEnc = $nEnc Order By nItem");
	if($row=mysql_fetch_array($bdEnc)){
		do{?>
			<div style="margin:10px;">
			<table border="1" width="90%" cellspacing="0" cellpadding="0" id="tablaDatosEncuesta">
				<tr>
					<td colspan="8" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<span style="color:#FFFFFF; font-size:16px; font-weight:700; padding: 10px;">
							<?php echo $row[titItem]; ?>
						</span>
					</td>
				</tr>
				<?php if($row[nItem] == 1){?>
					<tr bgcolor="#006666" align="center">
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Consulta
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								NP
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								1
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								2
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								3
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								4
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Media
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Gráfico
							</span>
						</td>
					<?php } ?>
				<?php if($row[nItem] == 2){?>
					<tr bgcolor="#006666" align="center">
						<td style="color:#FFFFFF; font-size:16px;" colspan="2">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Consulta
							</span>
						</td>
						<td colspan="3" style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Si
							</span>
						</td>
						<td colspan="3" style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								No
							</span>
						</td>
					<?php } ?>
					
				</tr>
				<?php
				$nItem 		= $row[nItem];
				$sEscalas	= array(0, 0, 0, 0, 0, 0);
				$sSiNo		= array(0, 0, 0, 0, 0, 0);
				
				$bdPr=mysql_query("SELECT * FROM prEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nCon");
				if($rowPr=mysql_fetch_array($bdPr)){
					do{
						$bg = '#ccc';
						if( ($rowPr[nCon]/2) == intval($rowPr[nCon]/2)){
							$bg = '#669999';
						}
						$slEscalas	= array(0, 0, 0, 0, 0, 0);
						?>
						<tr bgcolor="<?php echo $bg; ?>" align="center" style="font-size:16px; ">
							<?php if($nItem == 1){?>
								<td width="30%" align="left" style="padding:10px; "><?php echo $rowPr[nCon].'.- '.$rowPr[Consulta]; ?></td>
							<?php } ?>
							<?php if($nItem == 2){?>
								<td colspan="2" width="30%" align="left" style="padding:10px; "><?php echo $rowPr[nCon].'.- '.$rowPr[Consulta]; ?></td>
							<?php } ?>
							<?php if($nItem == 1){?>
								<td width="10%" style="font-size:24px;">
									<?php
										$result  = mysql_query("SELECT sum(rEscala) as Np FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rEscala = 0");
										$row 	 = mysql_fetch_array($result);
										$Np = $row['Np'];
										if($Np > 0){
											echo $Np;
										}
										$sEscalas[0]  += $Np;
										$slEscalas[0] += $Np;
									?>
								</td>
								<td width="10%" style="font-size:24px;">
									<?php
										$result  = mysql_query("SELECT sum(rEscala) as Uno FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rEscala = 1");
										$row 	 = mysql_fetch_array($result);
										$Uno = $row['Uno'];
										if($Uno > 0){
											echo $Uno;
										}
										$sEscalas[1]  += $Uno;
										$slEscalas[1] += $Uno;
									?>
								</td>
								<td width="10%" style="font-size:24px;">
									<?php
										$result  = mysql_query("SELECT sum(rEscala) as Dos FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rEscala = 2");
										$row 	 = mysql_fetch_array($result);
										$Dos = $row['Dos'];
										if($Dos > 0){
											echo $Dos;
										}
										$sEscalas[2]  += $Dos;
										$slEscalas[2] += $Dos;
									?>
								</td>
								<td width="10%" style="font-size:24px;">
									<?php
										$result  = mysql_query("SELECT sum(rEscala) as Tres FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rEscala = 3");
										$row 	 = mysql_fetch_array($result);
										$Tres = $row['Tres'];
										if($Tres > 0){
											echo $Tres;
										}
										$sEscalas[3]  += $Tres;
										$slEscalas[3] += $Tres;
									?>
								</td>
								<td width="10%" style="font-size:24px;">
									<?php
										$result  = mysql_query("SELECT sum(rEscala) as Cuatro FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rEscala = 4");
										$row 	 = mysql_fetch_array($result);
										$Cuatro = $row['Cuatro'];
										if($Cuatro > 0){
											echo $Cuatro;
										}
										$sEscalas[4]  += $Cuatro;
										$slEscalas[4] += $Cuatro;
									?>
								</td>
								<td width="20%" style="font-size:24px;">
									<?php
									$ssEscalas = 0;
									for($i=0; $i<=4; $i++){
										$ssEscalas += $slEscalas[$i];
									}
									if($ssEscalas > 0){
										$media = $ssEscalas/$nResp;
										echo number_format($media , 2, ',', '.');
									}
									?>
									
								</td>
								<td bgcolor="#FFFFFF">
									<?php
									if($ssEscalas > 0){
										grafico($slEscalas, $media, $nResp, $ssEscalas);
									}
									?>
									
								</td>
							<?php } ?>
							<?php if($nItem == 2){?>
								<td colspan="3" width="10%">
									<?php
										$result  = mysql_query("SELECT count(rSiNo) as rSi FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rSiNo = 1");
										$row 	 = mysql_fetch_array($result);
										$rSi = $row['rSi'];
										if($rSi > 0){
											echo $rSi;
										}
										$sSiNo[0] += $rSi;
									?>
								</td>
								<td colspan="3" width="10%">
									<?php
										$result  = mysql_query("SELECT count(rSiNo) as rNo FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr[nCon]."' && rSiNo = 0");
										$row 	 = mysql_fetch_array($result);
										$rNo = $row['rNo'];
										if($rNo > 0){
											echo $rNo;
										}
										$sSiNo[1] += $rNo;
									?>
								</td>
							<?php } ?>
						</tr>
						<?php
					}while ($rowPr=mysql_fetch_array($bdPr));
					if($nItem == 1){
						echo '<tr align="center" bgcolor="#66CCCC">';
						echo '	<td>Totales</td>';
						for($i=0; $i<=5; $i++){
								echo '<td  style="font-size:24px;">';
										if($sEscalas[$i] <> 0){
											echo $sEscalas[$i];
										}
								echo '</td>';
						}
						echo '	</td>';
						echo '	<td>';
									$ssEscalas = 0;
									for($i=0; $i<=4; $i++){
										$ssEscalas += $sEscalas[$i];
									}
									if($ssEscalas > 0){
										$media = $ssEscalas/$nResp;
									}
						
									if($ssEscalas > 0){
										grafico($sEscalas, $media, $nResp, $ssEscalas);
									}
						echo '</tr>';
					}
					if($nItem == 2){
						echo '<tr bgcolor="#66CCCC" align="center">';
						echo '	<td colspan="2">Totales</td>';
						for($i=0; $i<=1; $i++){
								echo '<td colspan="3" style="font-size:24px;">';
										echo $sSiNo[$i];
								echo '</td>';
						}
						echo '</tr>';
						echo '<tr bgcolor="#fff" align="center">';
						echo '	<td colspan="6">';
									$ssEscalas = 0;
									for($i=0; $i<=1; $i++){
										$ssEscalas += $sSiNo[$i];
									}
									graficoSiNo($sSiNo, $ssEscalas);
						echo '	</td>';
						echo '</tr>';
					}
				}
				?>
				<?php if($nItem == 3){
						$bdRes=mysql_query("SELECT * FROM respEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nFolio");
						if($rowRes=mysql_fetch_array($bdRes)){
							do{
								if($rowRes[rTexto]){
								?>
								<tr>
									<td colspan="6" width="10%" style="padding:10px; font-size:14px;" align="justify">
										<?php
											echo '<li type="scuare">'.$rowRes[rTexto].'</li>';
											echo '<span style="float:right; font-weight:700;">';
													$bdFol=mysql_query("SELECT * FROM foliosEncuestas Where nFolio = '".$rowRes[nFolio]."'");
													if($rowFol=mysql_fetch_array($bdFol)){
														echo $rowFol[Cumplimentado];
													}
											echo '</span>';
										?>
									</td>
								</tr>
								<?php
								}
							}while ($rowRes=mysql_fetch_array($bdRes));
						}?>
				<?php } ?>
			</table>
			</div>
			<?php
		}while ($row=mysql_fetch_array($bdEnc));
	}
	function grafico($e, $media, $nRes, $ss){
		$colores = array("FF0000","e57e0f","FFFF00","00FF00","00CC33","54380c","e50f28","a3129e","082454","f6f830","838383");
		$texto = array();
		$reporte_votos = array();
		$nvotos = array();

		for($i=0; $i<=4; $i++){
			//if($e[$i]>0){
				$porcentaje = round(($e[$i]/$ss) * 100);
				if($i  == 0){
					array_push($texto,urlencode(utf8_encode('NP')));
				}else{
					array_push($texto,urlencode(utf8_encode($i)));
				}
				array_push($reporte_votos, urlencode(utf8_encode($porcentaje . "%")));
				array_push($nvotos, $porcentaje);
		}
	
		$url_api_chart = "http://chart.apis.google.com/chart?chs=400x100";
		$tpGr = 'Torta';
		if($tpGr == 'Torta'){
			$url_api_chart .= "&cht=p";
			$colores_utilizados = array_slice($colores, 0, count($texto));
			$url_api_chart .= "&chco=". implode($colores_utilizados, ",");
			$url_api_chart .= "&chl=" . implode($reporte_votos, "|");
			$url_api_chart .= "&chdl=" . implode($texto, "|");
			$url_api_chart .= "&chd=t:" . implode($nvotos, ",");
		}
		if($tpGr == 'Barra'){
			$url_api_chart .= "&cht=bhg";
			$colores_utilizados = array_slice($colores, 0, count($texto));
			$url_api_chart .= "&chco=". implode($colores_utilizados, "|");
			$url_api_chart .= "&chd=t:" . implode($nvotos, ",");
			$url_api_chart .= "&chdl=" . implode($texto, "|");
		}

		
		echo "<img src='$url_api_chart' width=400 height=100 border=0>";
		
		return;
	}



	function graficoSiNo($e, $ss){
		$colores = array("FF0000","e57e0f","FFFF00","00FF00","00CC33","54380c","e50f28","a3129e","082454","f6f830","838383");
		$texto = array();
		$reporte_votos = array();
		$nvotos = array();

		for($i=0; $i<=1; $i++){
			//if($e[$i]>0){
				$porcentaje = round(($e[$i]/$ss) * 100);
				if($i  == 0){
					array_push($texto,urlencode(utf8_encode('Si')));
				}else{
					array_push($texto,urlencode(utf8_encode('No')));
				}
				array_push($reporte_votos, urlencode(utf8_encode($porcentaje . "%")));
				array_push($nvotos, $porcentaje);
		}
	
		$url_api_chart = "http://chart.apis.google.com/chart?chs=800x200";
		$tpGr = 'Torta';
		if($tpGr == 'Torta'){
			$url_api_chart .= "&cht=p";
			$colores_utilizados = array_slice($colores, 0, count($texto));
			$url_api_chart .= "&chco=". implode($colores_utilizados, ",");
			$url_api_chart .= "&chl=" . implode($reporte_votos, "|");
			$url_api_chart .= "&chdl=" . implode($texto, "|");
			$url_api_chart .= "&chd=t:" . implode($nvotos, ",");
		}
		if($tpGr == 'Barra'){
			$url_api_chart .= "&cht=bhg";
			$colores_utilizados = array_slice($colores, 0, count($texto));
			$url_api_chart .= "&chco=". implode($colores_utilizados, "|");
			$url_api_chart .= "&chd=t:" . implode($nvotos, ",");
			$url_api_chart .= "&chdl=" . implode($texto, "|");
		}

		
		echo "<img src='$url_api_chart' width=800 height=200 border=0>";
		
		return;
	}
	?>
