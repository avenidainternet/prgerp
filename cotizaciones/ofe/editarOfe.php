	<input name="OFE" 		type="hidden" value="<?php echo $OFE; ?>"	>
	<input name="accion" 	type="hidden" value="<?php echo $accion; ?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaOferta">
		<tr>
			<td class="titTabOferta">Oferta Económica</td> 
		</tr>
		<tr>
			<td width="30%">
				<div>
					<img src="../../imagenes/UDS-CNRJ.png">
				</div>
			</td>
			<td width="70%">
				<div>
					<img src="../../imagenes/TRANSPARENTE.png" width="100%">
				</div>
			</td>
		</tr>
		<tr>
			<td class="titOferta">
				<?php
					$bdCo=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$OFE."'");
					if($rowCo=mysqli_fetch_array($bdCo)){
						$nContacto 	= $rowCo['nContacto'];
						$RutCli 	= $rowCo['RutCli'];
					}
					$bdOF=$link->query("SELECT * FROM propuestaeconomica Where OFE = '".$OFE."'");
					if($rowOF=mysqli_fetch_array($bdOF)){
						$tituloOferta = $rowOF['tituloOferta'];
						$usrElaborado 		= $rowOF['usrElaborado'];
						$usrAprobado 		= $rowOF['usrAprobado'];
						$fechaElaboracion 	= $rowOF['fechaElaboracion'];
						$fechaAprobacion 	= $rowOF['fechaAprobacion'];
					}
				?>
				<textarea name="tituloOferta" rows="5"><?php echo $tituloOferta; ?></textarea>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="idCliente" colspan="2">
				<span style="color:#000000;">Empresa: </span>
				<?php
					$bdCli=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
					if($rowCli=mysqli_fetch_array($bdCli)){
						echo $rowCli['Cliente'];
						$Cliente = $rowCli['Cliente'];
					}
				?>					
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" id="idOferta">
					<tr>
						<td class="linDobleBotSimpleDer" width="60%">Ref:OFE-<?php echo $OFE; ?></td>
						<td class="linDobleBot" width="40%"			>N° Páginas: </td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #000; border-right:1px solid #000;">
							<div>Elaborado:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php
								$bdUs=$link->query("SELECT * FROM usuarios WHERE usr = '".$usrElaborado."'");
								if($rowUs=mysqli_fetch_array($bdUs)){
									echo $rowUs['usuario'];
								}
								?>
							</div>
						</td>
						<td style="border-bottom:1px solid #000;">
							<div>Fecha:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php 
									$fd = explode('-', $fechaElaboracion);
									echo $fd[2].'-'.$fd[1].'-'.$fd[0];
								?>
							</div>
						</td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #000; border-right:1px solid #000;">
							<div>Revisado y Aprobado:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php
									$bdUs=$link->query("SELECT * FROM usuarios Where apruebaOfertas = 'on' and usr = '".$_SESSION['usr']."'");
									if($rowUs=mysqli_fetch_array($bdUs)){ ?>
										<select name="usrAprobado">
											<option></option>								
											<?php
											//$bdUs=$link->query("SELECT * FROM usuarios Where apruebaOfertas = 'on' and usr != '".$_SESSION['usr']."'");
											$bdUs=$link->query("SELECT * FROM usuarios Where apruebaOfertas = 'on'");
											if($rowUs=mysqli_fetch_array($bdUs)){ 
												do{
													if($usrElaborado != $rowUs['usr']){
														if($usrAprobado == $rowUs['usr']){
															?>
															<option selected 	value="<?php echo $rowUs['usr']; ?>"><?php echo $rowUs['usuario']; ?></option>
															<?php
														}else{
															?>
															<option 			value="<?php echo $rowUs['usr']; ?>"><?php echo $rowUs['usuario']; ?></option>
															<?php
														}
													}
												}while($rowUs=mysqli_fetch_array($bdUs));
											}
										?>
										</select>
										<?php
									}else{
										?>Solicitar Aprobación<?php
									}
								?>
							</div>
						</td>
						<td style="border-bottom:1px solid #000;">
							<div>Fecha:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php 
									if($fechaAprobacion != '0000-00-00'){
										$fd = explode('-', $fechaAprobacion);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0];
									}
								?>
							</div>
						</td>
					</tr>
					<tr>
						<td style="border-right:1px solid #000;">
							<div>Empresa Destinataria:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php echo $Cliente; ?>
							</div>
						</td>
						<td>
							<div>Atención:</div>
							<div style="padding-top:10px; text-align:center; color:#FFCC00;">
								<?php
								$bdCc=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCli['RutCli']."' and nContacto = '".$nContacto."'");
								if($rowCc=mysqli_fetch_array($bdCc)){
									echo $rowCc['Contacto'];
								}
								?>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
