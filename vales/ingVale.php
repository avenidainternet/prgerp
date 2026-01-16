<?php
	include_once("conexion.php");
	
	$link=Conectarse();
	$bdUs=mysql_query("SELECT * FROM usuarios Where usr = '".$usrResponsable."'");
	if ($rowUs=mysql_fetch_array($bdUs)){
		$Usuario = $rowUs['usuario'];
	}
	mysql_close($link);
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="registraDatos">
	<tr class="CabTit">
		<td class="Ficha">Registro de Vales</td>
	    <td colspan="3">&nbsp;</td>
    </tr>
	<tr class="trDatos">
	  <td>N&deg; Vale 	</td>
	  <td>Fecha			</td>
	  <td>Usuario<br>Responsable del Registro	</td>
  	  <td>Monto</td>
	</tr>
	<tr class="trIngDatos">
		<td width="15%" align="center">
			<?php echo $nVale; ?>
			<input name="nVale" type="hidden" value="<?php echo $nVale; ?>">
		</td>
	    <td width="35%" align="center">
			<input name="fechaVale" type="date" value="<?php echo $fechaVale; ?>" requiere>
		</td>
	    <td width="25%" align="center">
			<?php echo $Usuario; ?>
			<input name="usrResponsable" type="hidden" value="<?php echo $usrResponsable; ?>">
		</td>
        <td width="25%" align="center">
			<input name="Ingreso" type="text" maxlength="8" size="8" value="<?php echo $Ingreso; ?>">
		</td>
	</tr>
	<tr class="trDatos">
		<td colspan="4" align="left">Descripci&oacute;n</td>
    </tr>
	<tr class="trIngDatos">
		<td colspan="4">
			<textarea name="Descripcion" rows="7" cols="130" requiere><?php echo $Descripcion; ?></textarea>
		</td>
    </tr>
</table>
