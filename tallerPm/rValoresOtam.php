<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');

	include_once("../conexionli.php"); 
	$Otam 		= $_GET[Otam];
	$accion  	= $_GET[accion];
	$tEns		= explode('-',$Otam);
	
	$fechaApertura 	= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();

	$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
	if($rowOT=mysqli_fetch_array($bdOT)){
		$ObsOtam		= $rowOT[ObsOtam];
		$tpMuestra		= $rowOT[tpMuestra];
		$Ind			= $rowOT[Ind];
		$Tem			= $rowOT[Tem];
		$rTaller		= $rowOT[rTaller];
	}
	
	$link->close();
?>

<style>
.Estilo3 {color: #FFFFFF}
</style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<script>
function myFunction()
{
	var x=document.getElementById("Ind");
	var nInd	= $("#Ind").val();
	var vOtam	= $("#Otam").val();
	var n		= 0;
	var sSuma	= 0;
	var vMedia	= 0;
	var valInd  = 0;

	for(n = 1; n<=nInd; n++) { 
		 var el_vIndenta = 'vIndenta_' + String(n) + '-' + vOtam;
		 var vIndenta = $(el_vIndenta).val();
		 
/*
		 var sSuma = sSuma + parseFloat(vIndenta);
		 var vMedia = sSuma/n;
		 alert(vIndenta);
*/		 
	}
	var vMedia=Math.round(vMedia*10)/10;
	document.form.Media.value 		= vMedia;
/*
	var vValorUF	= $("#ValorUF").val();
	var vTotal		= vCantidad * vValorUF;
*/
}

function myImpactos()
{
	var x=document.getElementById("Ind");
	var nInd	= $("#Ind").val();
	var vItem	= $("#Item").val();
	var n		= 0;
	var sSuma	= 0;
	var vMedia	= 0;
	var valInd  = 0;

	for(n = 1; n<=nInd; n++) { 
		 var el_vIndenta	= 'vImpacto_'+n+'-'+vItem;
		 var vIndenta = $("#"+el_vIndenta).val();
		 var sSuma = sSuma + parseFloat(vIndenta);
		 var vMedia = sSuma/n;
	}
	//alert(sSuma);
	var vMedia=Math.round(vMedia*10)/10;
	document.form.Media.value 		= vMedia;
/*
	var vValorUF	= $("#ValorUF").val();
	var vTotal		= vCantidad * vValorUF;
*/
}

</script>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="pTallerPM.php" method="get">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/talleres.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Identificación Muestra <span style=" color:#FFFF00; font-weight:700; "> <?php echo $Otam; ?>	</span>
								- 			<span style=" color:#FFFF00; font-weight:700; "> 
												<?php 
													$tm = explode('-',$Otam);
													if(substr($tm[1],0,1) == 'T'){ echo 'Tracción'; }
													if(substr($tm[1],0,1) == 'Q'){ echo 'Químico'; 	}
													if(substr($tm[1],0,1) == 'C'){ echo 'Charpy'; 	}
													if(substr($tm[1],0,1) == 'D'){ echo 'Dureza'; 	}
													if(substr($tm[1],0,1) == 'O'){ echo 'Otro'; 	}
												?>
											</span>
							<?php echo $Existe;?>
							<div id="botonImagen">
								<?php 
									$prgLink = 'pTallerPM.php';
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
					  </span>
				  </td>
				</tr>
				<tr>
				  	<td colspan="4" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							<input name="Otam" 			id="Otam" 		type="hidden" value="<?php echo $Otam; 			?>" />
							<input name="accion" 		id="accion" 	type="hidden" value="<?php echo $accion; 		?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td height="93">
					
					
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="77%" height="40" valign="top">

									<?php
										if(substr($tm[1],0,1) == 'T'){
											$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$bdRegTra=$link->query("SELECT * FROM regTraccion Where idItem = '".$Otam."'");
												if($rowRegTra=mysqli_fetch_array($bdRegTra)){
													$aIni  = $rowRegTra[aIni];
													$cFlu  = $rowRegTra[cFlu];
													$cMax  = $rowRegTra[cMax];
													$tFlu  = $rowRegTra[tFlu];
													$tMax  = $rowRegTra[tMax];
													$aSob  = $rowRegTra[aSob];
													$rAre  = $rowRegTra[rAre];
												}
												if($rowOT['tpMuestra'] == 'Pl'){
													?>
													<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
														<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
															<td align="center" width="15%">ID<br>ITEM</td>
															<td align="center" width="8%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
															<td align="center" width="8%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
															<td align="center" width="8%">Carga<br>Máxima<br>(Kgf) 						</td>
															<td align="center" width="8%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
															<td align="center" width="8%">Tensión<br>Máxima<br>(MPa) 					</td>
															<td align="center" width="8%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">
																<strong><?php echo $Otam; //$campoidItem; ?>
																	<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
																</strong>
															</td>
															<td><input style="text-align:center;" name="aIni" 	type="text" size="9" maxlength="9" value="<?php echo $aIni; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cFlu" 	type="text" size="9" maxlength="9" value="<?php echo $cFlu; ?>" />				</td>
															<td><input style="text-align:center;" name="cMax" 	type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>" />				</td>
															<td><input style="text-align:center;" name="tFlu" 	type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>" />				</td>
															<td><input style="text-align:center;" name="tMax" 	type="text" size="9" maxlength="9" value="<?php echo $tMax; ?>" />				</td>
															<td><input style="text-align:center;" name="aSob" 	type="text" size="9" maxlength="9" value="<?php echo $aSob; ?>" />				</td>
														</tr>
													</table>
													<?php
												}
												if($rowOT['tpMuestra'] == 'Re'){
													?>
													<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
														<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
															<td align="center" width="15%">ID<br>ITEM</td>
															<td align="center" width="8%">Área<br>Inicial<br>(mm<sup>2</sup>)			</td>
															<td align="center" width="8%">Carga Fluencia<br>0,2 % Def,<br>(Kgf)			</td>
															<td align="center" width="8%">Carga<br>Máxima<br>(Kgf) 						</td>
															<td align="center" width="8%">Tensión de<br>Fluencia<br>0,2% Def,<br>(MPa) 	</td>
															<td align="center" width="8%">Tensión<br>Máxima<br>(MPa) 					</td>
															<td align="center" width="8%">Alarg,<br>Sobre 50<br>mm<br>(%) 				</td>
															<td align="center" width="8%">Red.<br>de Área<br>%) 						</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">
																<strong><?php echo $Otam; //$campoidItem; ?>
																	<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
																</strong>
															</td>
															<td><input style="text-align:center;" name="aIni" 	type="text" size="9" maxlength="9" value="<?php echo $aIni; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cFlu" 	type="text" size="9" maxlength="9" value="<?php echo $cFlu; ?>" />				</td>
															<td><input style="text-align:center;" name="cMax" 	type="text" size="9" maxlength="9" value="<?php echo $cMax; ?>" />				</td>
															<td><input style="text-align:center;" name="tFlu" 	type="text" size="9" maxlength="9" value="<?php echo $tFlu; ?>" />				</td>
															<td><input style="text-align:center;" name="tMax" 	type="text" size="9" maxlength="9" value="<?php echo $tMax; ?>" />				</td>
															<td><input style="text-align:center;" name="aSob" 	type="text" size="9" maxlength="9" value="<?php echo $aSob; ?>" />				</td>
															<td><input style="text-align:center;" name="rAre" 	type="text" size="9" maxlength="9" value="<?php echo $rAre; ?>" />				</td>
														</tr>
													</table>
													<?php
												}
											}
										}
										$link->close();
									?>

									<?php
										if(substr($tm[1],0,1) == 'Q'){
											$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$bdRegQui=$link->query("SELECT * FROM regQuimico Where idItem = '".$Otam."'");
												if($rowRegQui=mysqli_fetch_array($bdRegQui)){
													$cC  = $rowRegQui[cC];
													$cSi = $rowRegQui[cSi];
													$cMn = $rowRegQui[cMn];
													$cP  = $rowRegQui[cP];
													$cS  = $rowRegQui[cS];
													$cCr = $rowRegQui[cCr];
													$cNi = $rowRegQui[cNi];
													$cMo = $rowRegQui[cMo];
													$cAl = $rowRegQui[cAl];
													$cCu = $rowRegQui[cCu];
													$cCo = $rowRegQui[cCo];
													$cTi = $rowRegQui[cTi];
													$cNb = $rowRegQui[cNb];
													$cV  = $rowRegQui[cV];
													$cW  = $rowRegQui[cW];
													$cPb = $rowRegQui[cPb];
													$cB  = $rowRegQui[cB];
													$cSb = $rowRegQui[cSb];
													$cSn = $rowRegQui[cSn];
													$cZn = $rowRegQui[cZn];
													$cAs = $rowRegQui[cAs];
													$cBi = $rowRegQui[cBi];
													$cTa = $rowRegQui[cTa];
													$cCa = $rowRegQui[cCa];
													$cCe = $rowRegQui[cCe];
													$cZr = $rowRegQui[cZr];
													$cLa = $rowRegQui[cLa];
													$cSe = $rowRegQui[cSe];
													$cN  = $rowRegQui[cN];
													$cFe = $rowRegQui[cFe];
													$cMg = $rowRegQui[cMg];
													$cTe = $rowRegQui[cTe];
													$cCd = $rowRegQui[cCd];
													$cAg = $rowRegQui[cAg];
													$cAu = $rowRegQui[cAu];
													$cAi = $rowRegQui[cAi];
												}
												if($rowOT['tpMuestra'] == 'Ac'){
													?>
													<table width="70%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="15%">ID<br>ITEM</td>
															<td align="center" width="05%">%C</td>
															<td align="center" width="05%">%Si</td>
															<td align="center" width="05%">%Mn</td>
															<td align="center" width="05%">%P</td>
															<td align="center" width="05%">%S</td>
															<td align="center" width="05%">%Cr</td>
															<td align="center" width="05%">%Ni</td>
															<td align="center" width="05%">%Mo</td>
															<td align="center" width="05%">%Al</td>
															<td align="center" width="05%">%Cu</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><?php echo $Otam; ?></td>
															<td><input style="text-align:center;" name="cC" 	type="text" size="5" maxlength="5" value="<?php echo $cC;  ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cSi" 	type="text" size="5" maxlength="5" value="<?php echo $cSi; ?>" />			</td>
															<td><input style="text-align:center;" name="cMn" 	type="text" size="5" maxlength="5" value="<?php echo $cMn; ?>" />			</td>
															<td><input style="text-align:center;" name="cP" 	type="text" size="5" maxlength="5" value="<?php echo $cP;  ?>" />			</td>
															<td><input style="text-align:center;" name="cS" 	type="text" size="5" maxlength="5" value="<?php echo $cS;  ?>" />			</td>
															<td><input style="text-align:center;" name="cCr" 	type="text" size="5" maxlength="5" value="<?php echo $cCr; ?>" />			</td>
															<td><input style="text-align:center;" name="cNi" 	type="text" size="5" maxlength="5" value="<?php echo $cNi; ?>" />			</td>
															<td><input style="text-align:center;" name="cMo" 	type="text" size="5" maxlength="5" value="<?php echo $cMo; ?>" />			</td>
															<td><input style="text-align:center;" name="cAl" 	type="text" size="5" maxlength="5" value="<?php echo $cAl; ?>" />			</td>
															<td><input style="text-align:center;" name="cCu" 	type="text" size="5" maxlength="5" value="<?php echo $cCu; ?>" />			</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#FFFFFF">
																<strong>
																	<?php echo $tq; //$campoidItem; ?>
																	<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
																</strong>
															</td>
															<td align="center" bgcolor="#E6E6E6">%Co</td>
															<td align="center" bgcolor="#E6E6E6">%Ti</td>
															<td align="center" bgcolor="#E6E6E6">%Nb</td>
															<td align="center" bgcolor="#E6E6E6">%V</td>
															<td align="center" bgcolor="#E6E6E6">%W</td>
															<td align="center" bgcolor="#E6E6E6">%Sn</td>
															<td align="center" bgcolor="#E6E6E6">%B</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Fe</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">&nbsp;</td>
															<td><input style="text-align:center;" name="cCo" 	type="text" size="5" maxlength="5" value="<?php echo $cCo; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cTi" 	type="text" size="5" maxlength="5" value="<?php echo $cTi; ?>" />			</td>
															<td><input style="text-align:center;" name="cNb" 	type="text" size="5" maxlength="5" value="<?php echo $cNb; ?>" />			</td>
															<td><input style="text-align:center;" name="cV" 	type="text" size="5" maxlength="5" value="<?php echo $cV;  ?>" />			</td>
															<td><input style="text-align:center;" name="cW" 	type="text" size="5" maxlength="5" value="<?php echo $cW;  ?>" />			</td>
															<td><input style="text-align:center;" name="cSn" 	type="text" size="5" maxlength="5" value="<?php echo $cSn;  ?>" />			</td>
															<td><input style="text-align:center;" name="cB" 	type="text" size="5" maxlength="5" value="<?php echo $cB;  ?>" />			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input style="text-align:center; font-size:12px;" name="cFe" 	type="text" size="5" maxlength="5" value="<?php echo 'Resto';  ?>" />		</td>
														</tr>
													</table>
													<?php
												}
												if($rowOT['tpMuestra'] == 'Co'){
													?>
													<table width="70%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="15%">ID<br>ITEM</td>
															<td align="center" width="08%">%Zn</td>
															<td align="center" width="08%">%Pb</td>
															<td align="center" width="08%">%Sn</td>
															<td align="center" width="08%">%P</td>
															<td align="center" width="08%">%Mn</td>
															<td align="center" width="08%">%Fe</td>
															<td align="center" width="08%">%Ni</td>
															<td align="center" width="08%">%Si</td>
															<td align="center" width="08%">%Mg</td>
															<td align="center" width="08%">%Cr</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">&nbsp;</td>
															<td><input name="cZn" 	type="text" id="cZn" style="text-align:center;" value="<?php echo $cZn;  ?>" size="5" maxlength="5" autofocus />	</td>
															<td><input name="cPb" 	type="text" id="cPb" style="text-align:center;" value="<?php echo $cPb; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cSn" 	type="text" id="cSn" style="text-align:center;" value="<?php echo $cSn; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cP" 	type="text" id="cP"  style="text-align:center;" value="<?php echo $cP;  ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cMn" 	type="text" id="cMn" style="text-align:center;" value="<?php echo $cMn;  ?>" size="5" maxlength="5" />			</td>
															<td><input name="cFe" 	type="text" id="cFe" style="text-align:center;" value="<?php echo $cFe; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cNi" 	type="text" id="cNi" style="text-align:center;" value="<?php echo $cNi; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cSi" 	type="text" id="cSi" style="text-align:center;" value="<?php echo $cSi; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cMg" 	type="text" id="cMg" style="text-align:center;" value="<?php echo $cMg; ?>"  size="5" maxlength="5" />			</td>
															<td><input name="cCr" 	type="text" id="cCr" style="text-align:center;" value="<?php echo $cCr; ?>"  size="5" maxlength="5" />			</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#FFFFFF">
																<strong>								</strong>
															</td>
															<td align="center" bgcolor="#E6E6E6">%Te</td>
															<td align="center" bgcolor="#E6E6E6">%As</td>
															<td align="center" bgcolor="#E6E6E6">%Sb</td>
															<td align="center" bgcolor="#E6E6E6">%Cd</td>
															<td align="center" bgcolor="#E6E6E6">%Bi</td>
															<td align="center" bgcolor="#E6E6E6">%Ag</td>
															<td align="center" bgcolor="#E6E6E6">%Co</td>
															<td align="center" bgcolor="#E6E6E6">%Ai</td>
															<td align="center" bgcolor="#E6E6E6">%S</td>
															<td align="center" bgcolor="#E6E6E6">%Zr</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30"><strong><?php echo $tq; //$campoidItem; ?>
																<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
															</strong></td>
															<td><input name="cTe" 	type="text" id="cTe" style="text-align:center;" value="<?php echo $cTe; ?>" 	size="5" maxlength="5" autofocus />	</td>
															<td><input name="cAs" 	type="text" id="cAs" style="text-align:center;" value="<?php echo $cAs; ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cSb" 	type="text" id="cSb" style="text-align:center;" value="<?php echo $cSb; ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cCd" 	type="text" id="cCd" style="text-align:center;" value="<?php echo $cCd;  ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cBi" 	type="text" id="cBi" style="text-align:center;" value="<?php echo $cBi;  ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cAg" 	type="text" id="cAg" style="text-align:center;" value="<?php echo $cAg;  ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cCo" 	type="text" id="cCo" style="text-align:center;" value="<?php echo $cCo;  ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cAi" 	type="text" id="cAi" style="text-align:center;" value="<?php echo $cAi;  ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cS" 	type="text" id="cS"  style="text-align:center;" value="<?php echo $cS;  ?>"  	size="5" maxlength="5" />			</td>
															<td><input name="cZr" 	type="text" id="cZ" style="text-align:center;" value="<?php echo $cZr;  ?>" 	size="5" maxlength="5" />			</td>
														</tr>
								
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#FFFFFF">&nbsp;
															</td>
															<td align="center" bgcolor="#E6E6E6">%Au</td>
															<td align="center" bgcolor="#E6E6E6">%B</td>
															<td align="center" bgcolor="#E6E6E6">%Ti</td>
															<td align="center" bgcolor="#E6E6E6">%Se</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Cu</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">&nbsp;</td>
															<td><input name="cAu" 	type="text" id="cAu" 	style="text-align:center;" value="<?php echo $cAu; ?>" 	size="5" maxlength="5" autofocus />	</td>
															<td><input name="cB" 	type="text" id="cB" 	style="text-align:center;" value="<?php echo $cB; ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cTi" 	type="text" id="cTi" 	style="text-align:center;" value="<?php echo $cTi; ?>" 	size="5" maxlength="5" />			</td>
															<td><input name="cSe" 	type="text" id="cSe" 	style="text-align:center;" value="<?php echo $cSe;  ?>" size="5" maxlength="5" />			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input name="cCu" 	type="text" id="cCu" 	style="text-align:center;" value="<?php echo $cCu;  ?>" size="5" maxlength="5" />			</td>
														</tr>
													</table>
													<?php
												}
												if($rowOT['tpMuestra'] == 'Al'){
													?>
													<table width="70%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center" class="regMuestras">
														<tr bgcolor="#E6E6E6" align="center">
															<td align="center" width="15%">ID<br>ITEM</td>
															<td align="center" width="08%">%Si</td>
															<td align="center" width="08%">%Fe</td>
															<td align="center" width="08%">%Cu</td>
															<td align="center" width="08%">%Mn</td>
															<td align="center" width="08%">%Mg</td>
															<td align="center" width="08%">%Cr</td>
															<td align="center" width="08%">%Ni</td>
															<td align="center" width="08%">%Zn</td>
															<td align="center" width="08%">%Ti</td>
															<td align="center" width="08%">%Pb</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">&nbsp;</td>
															<td><input style="text-align:center;" name="cSi" 	type="text" size="5" maxlength="5" value="<?php echo $cSi;  ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cFe" 	type="text" size="5" maxlength="5" value="<?php echo $cFe; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cCu" 	type="text" size="5" maxlength="5" value="<?php echo $cCu; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cMn" 	type="text" size="5" maxlength="5" value="<?php echo $cMn;  ?>" />				</td>
															<td><input style="text-align:center;" name="cMg" 	type="text" size="5" maxlength="5" value="<?php echo $cMg;  ?>" />				</td>
															<td><input style="text-align:center;" name="cCr" 	type="text" size="5" maxlength="5" value="<?php echo $cCr; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cNi" 	type="text" size="5" maxlength="5" value="<?php echo $cNi; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cZn" 	type="text" size="5" maxlength="5" value="<?php echo $cZn; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cTi" 	type="text" size="5" maxlength="5" value="<?php echo $cTi; ?>" 	/>				</td>
															<td><input style="text-align:center;" name="cPb" 	type="text" size="5" maxlength="5" value="<?php echo $cPb; ?>" 	/>				</td>
														</tr>
														<tr style="font-weight:700;" align="center">
															<td height="28" align="center" bgcolor="#FFFFFF">
																<strong>
																	<?php echo $tq; //$campoidItem; ?>
																	<input name="<?php echo $campoidItem; ?>" type="hidden" 	value="<?php echo $tq; 	?>" />
																</strong>
															</td>
															<td align="center" bgcolor="#E6E6E6">%Sn</td>
															<td align="center" bgcolor="#E6E6E6">%Bi</td>
															<td align="center" bgcolor="#E6E6E6">%Zr</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">-</td>
															<td align="center" bgcolor="#E6E6E6">%Al</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">&nbsp;</td>
															<td><input style="text-align:center;" name="cSn" 	type="text" size="5" maxlength="5" value="<?php echo $cSn; ?>" autofocus />	</td>
															<td><input style="text-align:center;" name="cBi" 	type="text" size="5" maxlength="5" value="<?php echo $cBi; ?>" />			</td>
															<td><input style="text-align:center;" name="cZr" 	type="text" size="5" maxlength="5" value="<?php echo $cZr; ?>" />			</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td><input style="text-align:center;" name="cAl" 	type="text" size="5" maxlength="5" value="<?php echo $cAl;  ?>" />		</td>
														</tr>
													</table>
													<?php
												}

												
											}
										}
										$link->close();
									?>

									<?php
										if(substr($tm[1],0,1) == 'C'){
											$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$Ind = $rowOT['Ind'];
													?>

													<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
														<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
															<td width="15%" rowspan="2" align="center">
																ID<br>
																ITEM
															</td>
															<td colspan="<?php echo $Ind+1; ?>" align="center">Energía de impacto a <?php echo $Tem; ?><br>
																(Joule) 
															</td>
														</tr>
														<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
															<?php for($in=1; $in<=$Ind; $in++) { ?>
																<td align="center">
																	Muestra <?php echo 'N° '.$in; ?>
																</td>
															<?php } ?>
															<td align="center">
																Promedio
															</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">
																<strong>
																	<?php 
																		echo $Otam; //$campoidItem; 
																	?>
																	<input name="Ind" id="Ind" type="hidden" 	value="<?php echo $Ind; 	?>" />
																</strong>
															</td>
															<?php
																$sImpactos 	= 0;
																$Media 		= 0;
																for($in=1; $in<=$Ind; $in++) { 
																	$el_vImpacto	= 'vImpacto_'.$in.'-'.$Otam;
																	$el_nImpacto 	= 'nImpacto_'.$in.'-'.$Otam;
																	$link=Conectarse();
																	$bdRegCh=$link->query("SELECT * FROM regCharpy Where idItem = '".$Otam."' and nImpacto = '".$in."'");
																	if($rowRegCh=mysqli_fetch_array($bdRegCh)){
																		$nImpacto  = $rowRegCh[nImpacto];
																		$vImpacto  = $rowRegCh[vImpacto];
																	}
																	$link->close();
																	$sImpactos += $vImpacto;
																	$Media = $sImpactos / $in;
																	?>
																	<td>
																		<input style="text-align:center;" name="<?php echo $el_vImpacto; ?>" id="<?php echo $el_vImpacto; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $vImpacto; ?>" autofocus onKeyUp="myFunction();" />
																	</td>
																	<?php
																}
															?>
															<td>
																<?php //echo number_format($mDureza, 1, '.', ','); ?>
																<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
															</td>
														</tr>
													</table>
													<?php


											}
										}
										$link->close();
									?>


									<?php
										if(substr($tm[1],0,1) == 'D'){
											$link=Conectarse();
											$bdOT=$link->query("SELECT * FROM OTAMs Where Otam = '".$Otam."'");
											if($rowOT=mysqli_fetch_array($bdOT)){
												$Ind = $rowOT['Ind'];
													?>

													<table width="95%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc; margin-top:5px;" align="center">
														<tr bgcolor="#E6E6E6" style="font-weight:700;" align="center">
															<td width="15%" align="center">
																ID<br>
																ITEM
															</td>
														  	<td colspan="<?php echo $Ind+1; ?>" align="center">Dureza<br>
														    	Rockwell <?php echo $Tem; ?></td>
															<td>
																Promedio															</td>
														</tr>
														<tr bgcolor="#FFFFFF" align="center">
															<td height="30">
																<strong>
																	<?php 
																		echo $Otam; //$campoidItem; 
																	?>
																	<input name="Ind" id="Ind" type="hidden" 	value="<?php echo $Ind; 	?>" />
																</strong>
															</td>
															<?php
																$sIndenta 	= 0;
																$Media 		= 0;
																for($in=1; $in<=$Ind; $in++) { 
																	$el_vIndenta	= 'vIndenta_'.$in.'-'.$Otam;
																	$el_nIndenta 	= 'nIndenta_'.$in.'-'.$Otam;
																	$link=Conectarse();
																	$bdRegDu=$link->query("SELECT * FROM regDoblado Where idItem = '".$Otam."' and nIndenta = '".$in."'");
																	if($rowRegDu=mysqli_fetch_array($bdRegDu)){
																		$nIndenta  = $rowRegDu[nIndenta];
																		$vIndenta  = $rowRegDu[vIndenta];
																	}
																	$link->close();
																	$sIndenta += $vIndenta;
																	$Media = $sIndenta / $in;
																	?>
																	<td>
																		<input style="text-align:center;" name="<?php echo $el_vIndenta; ?>" id="<?php echo $el_vIndenta; ?>" 	type="text" size="5" maxlength="5" value="<?php echo $vIndenta; ?>" autofocus onKeyUp="myFunction();" />
																	</td>
																	<?php
																}
															?>
															<td>
																<?php //echo number_format($mDureza, 1, '.', ','); ?>
																<input style="text-align:center;" name="Media" id="Media" 	type="text" size="9" maxlength="9" value="<?php echo number_format($Media, 1, '.', ','); ?>" readonly />
															</td>
														</tr>
													</table>
													<?php


											}
										}
										$link->close();
									?>

									
								</td>
								<td width="23%">
									<table align="center" width="30%" style="border:1px solid #ccc;">
										<tr bgcolor="#666666">
										  <td height="40" colspan="2"><div align="center"><span class="Estilo3">Descripci&oacute;n Ensayo</span></div></td>
									  </tr>
										<tr>
										  	<td height="40">Tp.Ensayo</td>
										  	<td>
												<select name="tpMuestra">
												<?php
													$tm = explode('-',$Otam);
													if(substr($tm[1],0,1) == 'T'){ $idEnsayo = 'Tr'; }
													if(substr($tm[1],0,1) == 'Q'){ $idEnsayo = 'Qu'; }
													if(substr($tm[1],0,1) == 'C'){ $idEnsayo = 'Ch'; }
													if(substr($tm[1],0,1) == 'D'){ $idEnsayo = 'Du'; }
													if(substr($tm[1],0,1) == 'O'){ $idEnsayo = 'Ot'; }
													
													$SQL = "SELECT * FROM amTpsMuestras Where idEnsayo = '".$idEnsayo."'";
													
													$link=Conectarse();
													$bdTm=$link->query($SQL);
													if($rowTm=mysqli_fetch_array($bdTm)){
														do{?>
																<?php if($tpMuestra == $rowTm[tpMuestra]){?>
																		<option selected 	value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php }else{ ?>
																		<option  			value="<?php echo $rowTm[tpMuestra]; ?>"><?php echo $rowTm[Muestra]; ?></option>
																<?php } ?>
															<?php
														}while($rowTm=mysqli_fetch_array($bdTm));
													}
													$link->close();
												?>
												</select>
											</td>
										</tr>
										<?php
											if(substr($tm[1],0,1) == 'D' or substr($tm[1],0,1) == 'C'){?>
												<tr>
													<td height="40">
														<?php
														if(substr($tm[1],0,1) == 'D'){
															echo 'Indentaciones';
														}
														if(substr($tm[1],0,1) == 'C'){
															echo 'Impactos';
														}
														?>
													</td>
													<td>
														<input type="text" name="Ind" id="Ind" maxlength="5" size="5" value="<?php echo $Ind; ?>">
													</td>
												</tr>
										<?php
										}
										?>
										<?php
											if(substr($tm[1],0,1) == 'C'){?>
												<tr>
												  <td height="40">T&deg;</td>
													<td>
														<input type="text" name="Tem" id="Tem" maxlength="10" size="10" value="<?php echo $Tem; ?>">
													</td>
												</tr>
										<?php
										}
										?>
									</table>
								
								</td>
							</tr>
						</table>
						
						
						
						
						
					</td>
				</tr>
		  		<tr>
					<td colspan="3" height="50" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Registrar' || $accion == 'Editar' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarIdOtam" style="float:right;" title="Guardar Identificación OTAM">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
					</td>
		  		</tr>
		</table>
		</form>
		</center>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
