<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$CodInforme = $_GET[CodInforme];
	$accion 	= $_GET[accion];
	$fechaUp = date('Y-m-d');
	$encNew = 'Si';

	$link=Conectarse();
	$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme = '".$CodInforme."'");
	if($rowInf=mysql_fetch_array($bdInf)){
		$RutCli = $rowInf[RutCli];
		if($usrResponzable == ''){
			$usrResponzable = $usrCotizador;
		}
	}
	mysql_close($link);
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form action="mInforme.php" method="post" enctype="multipart/form-data">
		<table width="75%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/pdf.png" width="50">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Subir PDF <?php $CodInforme.'pdf';?>
						<div id="botonImagen">
							<?php 
								echo '<a href="archivos.php" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td colspan="4" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					Informe 
					<input name="CodInforme" 	id="CodInforme" type="text" 	size="30"   value="<?php echo $CodInforme; ?>" style="font-size:18px; font-weight:700;" readonly />
					<input name="accion" 		id="accion" 	type="hidden" 				value="<?php echo $accion; ?>">
				</strong>
			  </td>
		  </tr>
			<tr>
				<td width="104%" height="27" colspan="4" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">
					<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
						Empresa / Cliente 
					</strong>
				</td>
			</tr>
			<tr>
				<td height="30" colspan="4" class="lineaDerBot">
					<span>					</span>
			        <?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							echo '<span style="font-size:14px; font-weight:700;">'.$rowCli[Cliente].'</span>';
						}
						mysql_close($link);
					?>
				</td>
			</tr>
			<tr>
				<td height="32" colspan="4" bgcolor="#0099CC" class="lineaDerBot Estilo1">
					<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
						Informe Arraste informe o Buscar Informe...
					</strong>
				</td>
			</tr>
			<tr>
				<td>
					<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
						<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
						<input name="Informe" type="file" id="Informe">
					</strong>
				</td>
			</tr>
		    <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'SubirPdf'){?>
							<div id="botonImagen">
								<button name="subirGuardarInforme" style="float:right;" title="Subir Informe PDF">
									<img src="../imagenes/upload2.png" width="50" height="50">
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
