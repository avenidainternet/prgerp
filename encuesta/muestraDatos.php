	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");
	$nItem = 0;
	
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; }
				
	$link=Conectarse();
	$bdRes=mysql_query("SELECT * FROM Encuestas Where nEnc = $nEnc");
	if($rowRes=mysql_fetch_array($bdRes)){
		$nResp = $rowRes['nResp'];
	}
	$bdEnc=mysql_query("SELECT * FROM itEncuesta Where nEnc = $nEnc Order By nItem");
	if($row=mysql_fetch_array($bdEnc)){
		do{?>
			<div style="margin:10px;">
			<table border="1" width="90%" cellspacing="0" cellpadding="0" id="tablaDatosEncuesta">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<span style="color:#FFFFFF; font-size:16px; font-weight:700; padding: 10px;">
							<?php echo $row['titItem']; ?>
						</span>
					</td>
				</tr>
				<?php if($row['nItem'] == 1){?>
					<tr bgcolor="#006666" align="center">
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Consulta
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Valoración
							</span>
						</td>
						<td style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Gráfico
							</span>
						</td>
					<?php } ?>
				<?php if($row['nItem'] == 2){?>
					<tr bgcolor="#006666" align="center">
						<td style="color:#FFFFFF; font-size:16px;" colspan="2">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Consulta
							</span>
						</td>
						<td colspan="3" style="color:#FFFFFF; font-size:16px; ">
							<span style="color:#FFFFFF; font-size:16px; font-weight:700;">
								Gráfico
							</span>
						</td>
					<?php } ?>
					
				</tr>
				<?php
				$nItem 		= 0;
				$nItem 		= $row['nItem'];
				$sEscalas	= array(0, 0, 0, 0, 0, 0);
				$sSiNo		= array(0, 0, 0, 0, 0, 0);
				
				$bdPr=mysql_query("SELECT * FROM prEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nCon");
				if($rowPr=mysql_fetch_array($bdPr)){
					do{
						$bg = '#ccc';
						if( ($rowPr['nCon']/2) == intval($rowPr['nCon']/2)){
							$bg = '#669999';
						}
						
						$slEscalas	= array(0, 0, 0, 0, 0, 0);
						$nPer		= array(0, 0, 0, 0, 0, 0);
						$mVal		= array(0, 0, 0, 0, 0, 0);
						$sVal		= 0;
						$Valoracion = 0;
						$cPer		= 0;
						
						?>
						<tr bgcolor="<?php echo $bg; ?>" align="center" style="font-size:16px; ">
							<?php if($nItem == 1){?>
								<td width="30%" align="left" style="padding:10px; "><?php echo $rowPr['nCon'].'.- '.$rowPr['Consulta']; ?></td>
							<?php } ?>
							<?php if($nItem == 2){?>
								<td colspan="2" width="30%" align="left" style="padding:10px; "><?php echo $rowPr['nCon'].'.- '.$rowPr['Consulta']; ?></td>
							<?php } ?>
							<?php if($nItem == 1){

										$result=mysql_query("SELECT * FROM respEncuesta Where nEnc = $nEnc && nItem = $nItem &&  nCon = '".$rowPr['nCon']."'");
										if($row=mysql_fetch_array($result)){
											do{
												$nPer[$row['rEscala']]++;
												$cPer += $nPer[$row['rEscala']];
												$mVal[$row['rEscala']] = $nPer[$row['rEscala']] * $row['rEscala'];
												$sVal += $mVal[$row['rEscala']];
												$Valoracion = $sVal / $cPer;
											}while ($row=mysql_fetch_array($result));
										}

									?>
								<td width="20%" style="font-size:24px;">
									<?php
									$ssEscalas = 0;
									for($i=0; $i<=4; $i++){
										$ssEscalas += $slEscalas[$i];
									}
									if($ssEscalas > 0){
										$media = $ssEscalas/$nResp;
										//echo number_format($media , 2, ',', '.');
									}
									echo number_format($Valoracion , 2, ',', '.');
									?>
									
								</td>
								<td bgcolor="#FFFFFF">
									<?php
									if($nPer > 0){
										//grafico($slEscalas, $media, $nResp, $ssEscalas);
										grafico($nPer, $nResp);
									}
									?>
									
								</td>
							<?php } ?>
							<?php if($nItem == 2){
										$result  = mysql_query("SELECT count(rSiNo) as rSi FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr['nCon']."' && rSiNo = 1");
										$row 	 = mysql_fetch_array($result);
										$rSi = $row['rSi'];
										$sSiNo[1] = $rSi;
									?>
								<td colspan="3" width="10%">
									<?php
										$result  = mysql_query("SELECT count(rSiNo) as rNo FROM respEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."' && nCon = '".$rowPr['nCon']."' && rSiNo = 0");
										$row 	 = mysql_fetch_array($result);
										$rNo = $row['rNo'];
										$sSiNo[0] = $rNo;
										graficoSiNo($sSiNo, $nResp);
										
									?>
								</td>
							<?php } ?>
						</tr>
						<?php
					}while ($rowPr=mysql_fetch_array($bdPr));
				}
				?>
				<?php if($nItem == 3){
						$bdRes=mysql_query("SELECT * FROM respEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nFolio");
						if($rowRes=mysql_fetch_array($bdRes)){
							do{
//								if($rowRes[rTexto]){
								?>
								<tr>
									<td colspan="6" width="10%" style="padding:10px; font-size:14px;" align="justify">
										<?php
											echo '<li type="scuare">'.$rowRes['rTexto'].'</li><br>';
											echo '<span style="float:right; font-weight:700;">';
													$bdFol=mysql_query("SELECT * FROM foliosEncuestas Where nFolio = '".$rowRes['nFolio']."'");
													if($rowFol=mysql_fetch_array($bdFol)){
														$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFol['RutCli']."'");
														if($rowCli=mysql_fetch_array($bdCli)){
															echo $rowCli['Cliente'].'<br> <span style="float:right;">'.$rowFol['Cumplimentado'].'</span><br><span style="float:right;">'.$rowFol['Cargo'].'</span>';
															echo '<br><span style="float:right;"><a href="verFormularioRes.php?nFolio='.$rowRes['nFolio'].'&nEnc='.$nEnc.'" target="_blank"	><img src="../imagenes/Preguntas.png" width="50" height="50" title="Vista Formulario Encuesta"></a></span>';
														}
													}
											echo '</span>';
										?>
									</td>
								</tr>
								<?php
//								}
							}while ($rowRes=mysql_fetch_array($bdRes));
						}?>
				<?php } ?>
			</table>
			</div>
			<?php
		}while ($row=mysql_fetch_array($bdEnc));
	}
	
	function grafico($e, $nRes){
		$colores = array("FF0000","e57e0f","FFFF00","00FF00","00CC33","54380c","e50f28","a3129e","082454","f6f830","838383");
		$texto = array();
		$reporte_votos = array();
		$nvotos = array();

		for($i=0; $i<=4; $i++){
			//if($e[$i]>0){
				$porcentaje = round(($e[$i]/$nRes) * 100);
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
			$url_api_chart .= "&cht=p3";
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

	function graficoSiNo($e, $nRes){
		$colores = array("00CC33","FF0000","FFFF00","00FF00","00CC33","54380c","e50f28","a3129e","082454","f6f830","838383");
		$texto = array();
		$reporte_votos = array();
		$nvotos = array();

		for($i=1; $i>=0; $i--){
				$porcentaje = round(($e[$i]/$nRes) * 100);
				if($i == 1){
					array_push($texto,urlencode(utf8_encode('Si')));
				}else{
					array_push($texto,urlencode(utf8_encode('No')));
				}
				array_push($reporte_votos, urlencode(utf8_encode($porcentaje . "%")));
				array_push($nvotos, $porcentaje);
		}
		$url_api_chart = "http://chart.apis.google.com/chart?chs=400x100";
		$tpGr = 'Torta';
		if($tpGr == 'Torta'){
			$url_api_chart .= "&cht=p3";
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
