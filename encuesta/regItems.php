<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php 	
	include_once("conexion.php"); 
	$titItem 	= '';
	$tpEva		= '';
	
	if(isset($_GET['nEnc'])) 	{ $nEnc 	= $_GET['nEnc']; 	}
	if(isset($_GET['nItem'])) 	{ $nItem	= $_GET['nItem'];	}
	if(isset($_GET['accion'])) 	{ $accion 	= $_GET['accion'];	}

	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc 	= $rowEnc['nomEnc'];
		$infoEnc 	= $rowEnc['infoEnc'];
	}
	mysql_close($link);

	$encNew = 'Si';
	if($nItem == 0){
		$link=Conectarse();
		$sql = "SELECT * FROM itEncuesta Where nEnc = '".$nEnc."'";  // sentencia sql
		$result = mysql_query($sql);
		$nItem = mysql_num_rows($result) +1; // obtenemos el número de filas
		mysql_close($link);
		$accion = 'Guardar';
	}else{
		$link=Conectarse();
		$bdIt=mysql_query("SELECT * FROM itEncuesta Where nEnc = '".$nEnc."' && nItem = '".$nItem."'");
		if($rowIt=mysql_fetch_array($bdIt)){
			$titItem 	= $rowIt['titItem'];
			$tpEva 		= $rowIt['tpEva'];
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="ItemsEncuesta.php" method="post">
		<table width="95%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Items (<?php echo $nomEnc; ?>)
						<div id="botonImagen">
							<a href="ItemsEncuesta.php?nEnc=<?php echo $nEnc; ?>" style="float:right;"><img src="../imagenes/no_32.png"></a>
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
				<td>N° Item :</td>
				<td>
					<input name="nItem" id="nItem" type="text" size="2" maxlength="2" value="<?php echo $nItem; ?>">
				</td>
			</tr>
			<tr>
				<td>Titulo Item :</td>
				<td>
					<textarea name="titItem" id="titItem" cols="60" rows="5"><?php echo $titItem; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Tipo de Evaluación :</td>
				<td>
					<select name="tpEva" id="tpEva">
						<option 			value="">Tipo de Evaluación</option>
						<?php 
						$link=Conectarse();
						$bdTp=mysql_query("SELECT * FROM tpEvaluacion Order By tpEva");
						if($rowTp=mysql_fetch_array($bdTp)){
							do{
								if($rowTp['tpEva'] == $tpEva){
									echo '<option selected 	value="'.$rowTp['tpEva'].'">'.$rowTp['nomEva'].'</option>';
								}else{
									echo '<option  			value="'.$rowTp['tpEva'].'">'.$rowTp['nomEva'].'</option>';
								}
							}while ($rowTp=mysql_fetch_array($bdTp));
						}
						mysql_close($link);
						?>
					</select>
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