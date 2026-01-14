<?php 
	$nomEnsayo = '';
	$bdEn=$link->query("Select * From ofensayos Where nDescEnsayo = '".$nDescEnsayo."'");
	if($rowEn=mysqli_fetch_array($bdEn)){
		$nomEnsayo = $rowEn['nomEnsayo']; 
	}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaOferta" style="border-top:4px solid#000;">
	<tr>
		<td class="titTabOferta" width="30%">
			<?php 
				if($nomEnsayo){
					echo $nomEnsayo;
				}else{
					echo 'Registrando Nuevo Ensayo...';
				}
			?>
		</td>
		<td width="70%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="font-weight:800;"></div>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-left:5%;" width="20%"><b>Ensayo</b></td>
					<td>:</td>
					<td>
						<input name="nomEnsayo" size="50" maxlength="50" value="<?php echo $rowEn['nomEnsayo']; ?>" autofocus />
					</td>
				</tr>
				<tr>
					<td style="padding-left:5%;"><li><b>Descripción</b></li></td>
					<td>:</td>
					<td>
						<textarea name="Descripcion" rows="7" cols="100" style="font-size:14px; color:#333333;"><?php echo $rowEn['Descripcion']; ?></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>	

