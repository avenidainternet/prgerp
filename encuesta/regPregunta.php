<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php 	
	include_once("conexion.php"); 
	$Consulta = '';
	$nCon = 1;
	
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['nItem'])) 	{ $nItem	= $_GET['nItem'];	}
	if(isset($_GET['nCon'])) 	{ $nCon		= $_GET['nCon'];	}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}
	
	if($nCon == 0) { $nCon = 1; }
	
	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc 	= $rowEnc['nomEnc'];
		$infoEnc 	= $rowEnc['infoEnc'];
	}
	mysql_close($link);

	$encNew = 'Si';
	if($accion == 'Agrega'){
		$link=Conectarse();
		$bdPr=mysql_query("Select * From prEncuesta Where nEnc = '".$nEnc."' and nItem = '".$nItem."' Order By nCon Desc");
		if($rowPr=mysql_fetch_array($bdPr)){
			$nCon = $rowPr['nCon'] + 1;
		}
		mysql_close($link);
		$accion = 'Guardar';
	}else{
		$link=Conectarse();
		$bdPr=mysql_query("SELECT * FROM prEncuesta Where nEnc = '".$nEnc."' and nItem = '".$nItem."' and nCon = '".$nCon."'");
		if($rowPr=mysql_fetch_array($bdPr)){
			$Consulta 	= $rowPr['Consulta'];
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="preguntasEncuesta.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Items (<?php echo $nomEnc; ?>)
						<div id="botonImagen">
							<a href="preguntasEncuesta.php?nEnc=<?php echo $nEnc; ?>&nItem=<?php echo $nItem; ?>" style="float:right;"><img src="../imagenes/no_32.png"></a>
						</div>
					</span>
				</td>
			</tr>
			<tr>
				<td align="center"><img src="../imagenes/logoSimetEnc.png"></td>
				<td align="center">
					<span style="font-size:24px; font-weight:700;">
					<?php echo $nomEnc; ?>
					</span>
					<input name="nEnc" 		id="nEnc" 	type="hidden" value="<?php echo $nEnc; ?>">
					<input name="nItem" 	id="nItem" 	type="hidden" value="<?php echo $nItem; ?>">
					<input name="nCon" 		id="nCon" 	type="hidden" value="<?php echo $nCon; ?>">
					<input name="accion" 	id="accion" type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="justify" style="padding:20px; font-size:24px; ">
			  		<?php
						echo $infoEnc;
					?>
			  	</td>
		   	</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  	</tr>
			<tr>
				<td>N° Consulta :</td>
				<td>
					<input name="nCon" id="nCon" type="text" size="2" maxlength="2" value="<?php echo $nCon; ?>">
				</td>
			</tr>
			<tr>
				<td>Consulta :</td>
				<td>
					<textarea name="Consulta" id="Consulta" cols="60" rows="5"><?php echo $Consulta; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="40" height="40">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="40" height="40">
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