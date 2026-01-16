<?php 	
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$nLin = 0;
	
	$CAM 		= $_GET[CAM];
	$Rev 		= $_GET[Rev];
	$Cta 		= $_GET[Cta];
	$nServicio 	= $_GET[nServicio];
	$nLin 		= $_GET[nLin];
	$accion 	= $_GET[accion];

	$link=Conectarse();
	$bdSer=mysql_query("SELECT * FROM Servicios Where nServicio = '".$nServicio."'");
	if($rowSer=mysql_fetch_array($bdSer)){
		$Servicio 	= $rowSer[Servicio];
		$ValorUF 	= $rowSer[ValorUF];
		$ValorPesos	= $rowSer[ValorPesos];
		$tpServicio	= $rowSer[tpServicio];
	}

	if($nLin > 0){
		$Cantidad = 0.00;
		$bddCot=mysql_query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Rev = '".$Rev."' and Cta = '".$Cta."' && nLin = '".$nLin."'");
		if($rowdCot=mysql_fetch_array($bddCot)){
			$Cantidad 	= $rowdCot[Cantidad];
			$Total 		= $rowdCot[NetoUF];
		}
	}else{
		$Cantidad = 1;
		$Total = $Cantidad * $ValorUF;
	}
	mysql_close($link);
	
?>
<script>
function myFunction()
{
	var x=document.getElementById("Cantidad");
		var vCantidad	= $("#Cantidad").val();
		var vValorUF	= $("#ValorUF").val();
		var vTotal		= vCantidad * vValorUF;
		document.form.Total.value 		= vTotal;
}

</script>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="modCotizacion.php" method="post">
		<table width="54%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td width="80%" colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:20px; font-weight:700;">
						<img src="../imagenes/settings_128.png" width="50" align="middle">
						
						<?php 
							if($accion == 'BorrarServ') 	{ $tAccion = 'Eliminar '; 	}
							if($accion == 'AgregarServ')	{ $tAccion = 'Agregar '; 	}
							if($accion == 'ActualizarServ')	{ $tAccion = 'Actualizar '; }
							
							echo $tAccion.' Items CAM-'.$CAM; 
						?>
						<div id="botonImagen">
							<a href="modCotizacion.php?CAM=<?php echo $CAM; ?>&Rev=<?php echo $Rev; ?>&Cta=<?php echo $Cta; ?>" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">
					<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
						<tr bgcolor="#333333" style="color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:700;">
							<td width="13%" align="center">Cantidad</td>
						  	<td width="50%" align="center">Servicio</td>
						  	<td width="20%" align="center">Unitario</td>
						  	<td width="17%" align="center">Total</td>
						</tr>
						<tr>
						  	<td>
								<input style="font-size:14px; font-weight:700;" name="Cantidad" id="Cantidad" type="text" size="10" maxlength="10" value="<?php echo $Cantidad; ?>" onKeyUp="myFunction();" autofocus/>
								<script>
									 if( ! ("autofocus" in document.createElement( "input" ) ) )
									 {
									 document.getElementById( "Cantidad" ).focus();
									 }
								</script>
							</td>
						  	<td>
								<span style="font-size:14px; font-weight:700;">
									<?php echo $Servicio; ?>
								</span>
								<input name="CAM" 		id="CAM" 		type="hidden" 	value="<?php echo $CAM; ?>">
								<input name="Rev" 		id="Rev" 		type="hidden" 	value="<?php echo $Rev; ?>">
								<input name="Cta" 		id="Cta" 		type="hidden" 	value="<?php echo $Cta; ?>">
								<input name="nServicio" id="nServicio" 	type="hidden" 	value="<?php echo $nServicio; ?>">
								<input name="nLin" 		id="nLin" 		type="hidden" 	value="<?php echo $nLin; ?>">
								<input name="accion" 	id="accion" 	type="hidden" 	value="<?php echo $accion; ?>">
							</td>
						  	<td>
								<input style="font-size:18px; font-weight:700;" name="ValorUF" id="ValorUF" type="text" size="10" maxlength="10" value="<?php echo $ValorUF; ?>" onKeyUp="myFunction();">
							</td>
						  	<td><input style="font-size:18px; font-weight:700;" name="Total" id="Total" type="text" size="10" maxlength="10" value="<?php echo $Total; ?>" readonly></td>
						</tr>
						<tr>
						  	<td>&nbsp;</td>
						  	<td>&nbsp;</td>
						  	<td>&nbsp;</td>
						  	<td>&nbsp;</td>
						</tr>
				  </table>
			  </td>
		  </tr>
			<tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						if($accion == 'GuardarServ' or $accion == 'AgregarServ' or $accion == 'ActualizarServ'){
							if($accion == 'AgregarServ'){
								$img 	= '../imagenes/carroCompras2.png';
								$Titulo = 'Agregar Items a la Cotización';
							}
							if($accion == 'GuardarServ'){
								$img 	= '../imagenes/guardar.png';
								$Titulo = 'Actualizar Items';
							}
							if($accion == 'ActualizarServ'){
								$img 	= '../imagenes/guardar.png';
								$Titulo = 'Actualizar Items';
							}
							?>
							
							<div id="botonImagen">
								<button name="guardarServicio" style="float:right;">
									<img src="<?php echo $img; ?>" width="60" height="60" title="<?php echo $Titulo; ?>">
								</button>
							</div>
							<?php
						}
						if($accion == 'BorrarServ'){
							$img 	= '../imagenes/inspektion.png';
							$Titulo = 'Borrar Items';?>
							<button name="BorrarServicio" style="float:right;">
									<img src="<?php echo $img; ?>" width="60" height="60" title="<?php echo $Titulo; ?>">
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
