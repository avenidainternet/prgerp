<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	?>
	
	<script>

		// Necesita CalibraciÛn
		$( "#realizadaCal" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			
		  	if($input.is( ":checked" )){
				fCal = new Date(fCal);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fCal = anno+sep+mes+sep+dia;
				rCal = 'on';
		  	}else{
				fCal  = '0000-00-00';
				rCal = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaAccionCal").val(fCal);
		})

		$( "#registradaCal" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var rVer  = $(realizadaCal);
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
						
		  	if($input.is( ":checked" )){
				fCal = new Date(fCal);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fCal = anno+sep+mes+sep+dia;
				regCal = 'on';
		  	}else{
				fCal  = '0000-00-00';
				regCal = 'off';
				//$("#fechaProxCal").hide();
		  	}
		  	if(rVer.is( ":checked" )){
				frCal  = '0000-00-00';
			}else{
				document.form.realizadaCal.checked=1
				$("#fechaAccionCal").val(fCal);
			}
			$("#fechaRegCal").val(fCal);
		})

		// Necesita VerificaciÛn
		$( "#realizadaVer" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			
		  	if($input.is( ":checked" )){
				fVer = new Date(fVer);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fVer = anno+sep+mes+sep+dia;
				rVer = 'on';
		  	}else{
				fVer  = '0000-00-00';
				rVer = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaAccionVer").val(fVer);
		})

		$( "#registradaVer" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var rVer  = $(realizadaVer);
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
						
		  	if($input.is( ":checked" )){
				fVer = new Date(fVer);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fVer = anno+sep+mes+sep+dia;
				regVer = 'on';
		  	}else{
				fVer  = '0000-00-00';
				regVer = 'off';
				//$("#fechaProxCal").hide();
		  	}
		  	if(rVer.is( ":checked" )){
				frVer  = '0000-00-00';
			}else{
				document.form.realizadaVer.checked=1
				$("#fechaAccionVer").val(fVer);
			}
			$("#fechaRegVer").val(fVer);
		})

		// Necesita MantenciÛn
		$( "#realizadaMan" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			
		  	if($input.is( ":checked" )){
				fMan = new Date(fMan);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fMan = anno+sep+mes+sep+dia;
				rMan = 'on';
		  	}else{
				fMan  = '0000-00-00';
				rMan = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaAccionMan").val(fMan);
		})

		$( "#registradaMan" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var rMan  = $(realizadaMan);
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
						
		  	if($input.is( ":checked" )){
				fMan = new Date(fMan);
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fMan = anno+sep+mes+sep+dia;
				regMan = 'on';
		  	}else{
				fMan  = '0000-00-00';
				regMan = 'off';
				//$("#fechaProxCal").hide();
		  	}
		  	if(rMan.is( ":checked" )){
				frMan  = '0000-00-00';
			}else{
				document.form.realizadaMan.checked=1
				$("#fechaAccionMan").val(fMan);
			}
			$("#fechaRegMan").val(fMan);
		})

	</script>
	
	<?php
	include_once("../conexionli.php"); 
	$Rev 	= 0;
	$nSerie 			= $_GET[nSerie];
	$accion 			= $_GET[accion];
	$tpAccion 			= $_GET[tpAccion];

	$fechaApertura 		= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdCot=$link->query("SELECT * FROM equipos Where nSerie = '".$nSerie."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$nomEquipo			= $rowCot[nomEquipo];
		$lugar				= $rowCot[lugar];
		$tipoEquipo			= $rowCot[tipoEquipo];
			
		$necesitaCal		= $rowCot[necesitaCal];
		$fechaCal			= $rowCot[fechaCal];
		$tpoProxCal			= $rowCot[tpoProxCal];
		$tpoAvisoCal		= $rowCot[tpoAvisoCal];
		$fechaProxCal		= $rowCot[fechaProxCal];

		$realizadaCal		= $rowCot[realizadaCal];
		$fechaAccionCal		= $rowCot[fechaAccionCal];
		$registradaCal		= $rowCot[registradaCal];
		$fechaRegCal		= $rowCot[fechaRegCal];

		$necesitaVer		= $rowCot[necesitaVer];
		$fechaVer			= $rowCot[fechaVer];
		$tpoProxVer			= $rowCot[tpoProxVer];
		$tpoAvisoVer		= $rowCot[tpoAvisoVer];
		$fechaProxVer		= $rowCot[fechaProxVer];

		$realizadaVer		= $rowCot[realizadaVer];
		$fechaAccionVer		= $rowCot[fechaAccionVer];
		$registradaVer		= $rowCot[registradaVer];
		$fechaRegVer		= $rowCot[fechaRegVer];

		$necesitaMan		= $rowCot[necesitaMan];
		$fechaMan			= $rowCot[fechaMan];
		$tpoProxMan			= $rowCot[tpoProxMan];
		$tpoAvisoMan		= $rowCot[tpoAvisoMan];
		$fechaProxMan		= $rowCot[fechaProxMan];
			
		$realizadaMan		= $rowCot[realizadaMan];
		$fechaAccionMan		= $rowCot[fechaAccionMan];
		$registradaMan		= $rowCot[registradaMan];
		$fechaRegMan		= $rowCot[fechaRegMan];

		$usrResponsable		 	= $rowCot[usrResponsable];
	}
	$link->close();
?>

<style>
/*body {overflow-y:hidden;}*/
</style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaEquipos.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/herramientas.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Seguimiento Equipamiento - Instrumentos
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaEquipos.php?tpAccion='.$tpAccion;
									}
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
				  	<td colspan="3" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Equ&iacute;po  
							<?php
								if($accion == 'Seguimiento'){ 
									?>
									<input name="nSerie" 	id="nSerie" type="hidden" value="<?php echo $nSerie; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" />
									<?php
									echo $nSerie.' '.$nomEquipo.' - '.$lugar.' ('.$usrResponsable.')';
								}
							?>
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; 	?>">
							<input name="tpAccion" 				id="tpAccion" 			type="hidden" value="<?php echo $tpAccion; 	?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
			  	<td colspan="3" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" class="tablaRegEquipo" width="100%">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight:700;">
							<td colspan="6">
								Acciones Necesarias 
							</td>
						</tr>
						<tr style="background-color:#CCCCCC;" align="center">
							<td width="17%" class="lineaDerBot" style="font-size:18px;">Acciones						</td>
							<td width="14%" class="lineaDerBot" style="font-size:18px;">Fecha<br>Tentativa  				</td>
							<td width="12%" class="lineaDerBot" style="font-size:18px;">Acci√≥n<br>Realizada<br>(Si/No)	</td>
							<td width="22%" class="lineaDerBot" style="font-size:18px;">Fecha<br>Acci√≥n 				</td>
							<td width="12%" class="lineaDerBot" style="font-size:18px;">Acci√≥n<br>Registrada 			</td>
							<td width="23%" class="lineaDerBot" style="font-size:18px;">Fecha<br>Registro 				</td>
				      	</tr>
						<?php if($necesitaCal=='on'){?>
							<tr>
								<td class="lineaDerBot" height="60" style="font-size:18px;">Calibraci&oacute;n</td>
								<td class="lineaDerBot" style="font-size:18px;" align="center">
									<?php 
										$fd = explode('-', $fechaProxCal);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									?>
								</td>
								<td class="lineaDerBot" align="center">
									<?php
									if($realizadaCal=='on'){?>
										<input type="checkbox" name="realizadaCal" id="realizadaCal" checked>
									<?php }else{ ?>
										<input type="checkbox" name="realizadaCal" id="realizadaCal">
									<?php } ?>
								</td>
								<td class="lineaDerBot">
									<input name="fechaAccionCal" id="fechaAccionCal" type="date" value="<?php echo $fechaAccionCal; ?>" style="font-size:12px; font-weight:700;" />
								</td>
								<td class="lineaDerBot" align="center">
									<?php
									if($registradaCal=='on'){?>
										<input type="checkbox" name="registradaCal" id="registradaCal" checked>
									<?php }else{ ?>
										<input type="checkbox" name="registradaCal" id="registradaCal">
									<?php } ?>
								</td>
								<td class="lineaDerBot"><input name="fechaRegCal" id="fechaRegCal" type="date" value="<?php echo $fechaRegCal; ?>" style="font-size:12px; font-weight:700;" /></td>
							</tr>
						<?php } ?>
												
						<?php if($necesitaVer=='on'){?>
							<tr>
								<td class="lineaDerBot" style="font-size:18px;">Verificaci&oacute;n</td>
								<td class="lineaDerBot" style=" font-size:18px;" align="center">
									<?php 
										$fd = explode('-', $fechaProxVer);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									?>
								</td>
								<td class="lineaDerBot" style=" font-size:18px;" align="center">
									<?php
									if($realizadaVer=='on'){?>
										<input name="realizadaVer" type="checkbox" id="realizadaVer" checked>
									<?php }else{ ?>
										<input name="realizadaVer" type="checkbox" id="realizadaVer">
									<?php } ?>
								</td>
								<td class="lineaDerBot">
									<input name="fechaAccionVer" id="fechaAccionVer" type="date" value="<?php echo $fechaAccionVer; ?>" style="font-size:12px; font-weight:700;" />
								</td>
								<td class="lineaDerBot" align="center">
									<?php
										if($registradaVer=='on'){?>
											<input type="checkbox" name="registradaVer" id="registradaVer" checked>
									<?php }else{ ?>
											<input type="checkbox" name="registradaVer" id="registradaVer">
									<?php } ?>
								</td>
								<td class="lineaDerBot"><input name="fechaRegVer" id="fechaRegVer" type="date" value="<?php echo $fechaRegVer; ?>" style="font-size:12px; font-weight:700;" />
								</td>
							</tr>
						<?php } ?>

						<?php if($necesitaMan=='on'){?>
							<tr>
								<td class="lineaDerBot" style="font-size:18px;">
									Mantenci&oacute;n
								</td>
								<td class="lineaDerBot" style=" font-size:18px;" align="center">
									<?php 
										$fd = explode('-', $fechaProxMan);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									?>
								</td>
								<td class="lineaDerBot" align="center">
									<?php
									if($realizadaMan=='on'){?>
										<input name="realizadaMan" type="checkbox" id="realizadaMan" checked>
									<?php }else{ ?>
										<input name="realizadaMan" type="checkbox" id="realizadaMan">
									<?php } ?>
								</td>
								<td class="lineaDerBot">
									<input name="fechaAccionMan" id="fechaAccionMan" type="date" value="<?php echo $fechaAccionMan; ?>" style="font-size:12px; font-weight:700;" />
								</td>
								<td class="lineaDerBot" align="center">
									<?php
										if($registradaMan=='on'){?>
											<input type="checkbox" name="registradaMan" id="registradaMan" checked>
									<?php }else{ ?>
											<input type="checkbox" name="registradaMan" id="registradaMan">
									<?php } ?>
								</td>
								<td class="lineaDerBot"><input name="fechaRegMan" id="fechaRegMan" type="date" value="<?php echo $fechaRegMan; ?>" style="font-size:12px; font-weight:700;" />
								</td>
							</tr>
						<?php } ?>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="3" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Seguimiento'){?>
							<div id="botonImagen">
								<button name="guardarSeguimiento" style="float:right;" title="Guardar Seguimiento">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
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
