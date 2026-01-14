<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
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
		$( "#realizadaAct" ).change(function() {
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
			$("#fechaAccionAct").val(fVer);
		})

		$( "#registradaAct" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var rVer  = $(realizadaAct);
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
				document.form.realizadaAct.checked=1
				$("#fechaAccionAct").val(fVer);
			}
			$("#fechaRegAct").val(fVer);
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
	$idActividad 		= $_GET[idActividad];
	$accion 			= $_GET[accion];
	$tpAccion 			= $_GET[tpAccion];

	$fechaApertura 		= date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdCot=$link->query("SELECT * FROM Actividades Where idActividad = '".$idActividad."'");
	if($rowCot=mysqli_fetch_array($bdCot)){
		$Actividad			= $rowCot[Actividad];

		$fechaProxAct		= $rowCot[fechaProxAct];

		$realizadaAct		= $rowCot[realizadaAct];
		$fechaAccionAct		= $rowCot[fechaAccionAct];
		$registradaAct		= $rowCot[registradaAct];
		$fechaRegAct		= $rowCot[fechaRegAct];

		$usrResponsable		 	= $rowCot[usrResponsable];
	}
	$link->close();
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaActividades.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/Preguntas.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Seguimiento Actividades
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaActividades.php?tpAccion='.$tpAccion;
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
							Actividad
							<?php
								if($accion == 'Seguimiento'){ 
									?>
									<input name="idActividad" 	id="idActividad" type="hidden" value="<?php echo $idActividad; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" />
									<?php
									echo $Actividad.' ('.$usrResponsable.')';
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
								Control de Actividad 
							</td>
						</tr>
						<tr style="background-color:#CCCCCC;" align="center">
							<td width="17%" class="lineaDerBot" style="font-size:18px;">Actividad</td>
							<td width="14%" class="lineaDerBot" style="font-size:18px;">Fecha<br>
							Programaci&oacute;n</td>
							<td width="12%" class="lineaDerBot" style="font-size:18px;">Acci√≥n<br>Realizada<br>(Si/No)	</td>
							<td width="22%" class="lineaDerBot" style="font-size:18px;">Fecha<br>Acci√≥n 				</td>
							<td width="12%" class="lineaDerBot" style="font-size:18px;">Acci√≥n<br>Registrada 			</td>
							<td width="23%" class="lineaDerBot" style="font-size:18px;">Fecha<br>Registro 				</td>
				      	</tr>
						<tr>
							<td class="lineaDerBot" height="60" style="font-size:18px;">
								<?php 
									echo $Actividad;
								?>
							</td>
							<td class="lineaDerBot" style="font-size:18px;" align="center">
								<?php 
									$fd = explode('-', $fechaProxAct);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0];
								?>
							</td>
							<td class="lineaDerBot" align="center">
								<?php
								if($realizadaAct=='on'){?>
									<input type="checkbox" name="realizadaAct" id="realizadaAct" checked>
								<?php }else{ ?>
									<input type="checkbox" name="realizadaAct" id="realizadaAct">
								<?php } ?>
							</td>
							<td class="lineaDerBot">
								<input name="fechaAccionAct" id="fechaAccionAct" type="date" value="<?php echo $fechaAccionAct; ?>" style="font-size:12px; font-weight:700;" />
							</td>
							<td class="lineaDerBot" align="center">
								<?php
								if($registradaAct=='on'){?>
									<input type="checkbox" name="registradaAct" id="registradaAct" checked>
								<?php }else{ ?>
									<input type="checkbox" name="registradaAct" id="registradaAct">
								<?php } ?>
							</td>
							<td class="lineaDerBot"><input name="fechaRegAct" id="fechaRegAct" type="date" value="<?php echo $fechaRegAct; ?>" style="font-size:12px; font-weight:700;" /></td>
						</tr>
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
