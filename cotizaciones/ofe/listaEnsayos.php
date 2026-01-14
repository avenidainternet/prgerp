<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaEnsayos">
	<tr>
    	<td class="titTabEnsayos">Ensayos de Laboratorio</td> 
  	</tr>
		<?php
			$bdIee=$link->query("SELECT * FROM ofensayos ORDER BY nDescEnsayo, Generico DESC ");
			if($rowIee=mysqli_fetch_array($bdIee)){
				do{ 
					$bdEns=$link->query("SELECT * FROM ensayosOFE Where nDescEnsayo = '".$rowIee['nDescEnsayo']."' and OFE = '".$OFE."'");
					if($rowEns=mysqli_fetch_array($bdEns)){
					}else{
						$cTd = 'noGenerico';
						if($rowIee['Generico'] == 'on'){
							$cTd = 'nominaEnsayos';
						}
						?>
						<tr>
							<td class="<?php echo $cTd; ?>" style="border-bottom:1px solid #fff; border-top:1px solid #fff">
								<a href="index.php?OFE=<?php echo $OFE; ?>&accion=OFE&nDescEnsayo=<?php echo $rowIee['nDescEnsayo']; ?>&accionEnsayo=Agregar"><?php echo $rowIee['nomEnsayo']; ?></a>
							</td>
						</tr>
						<?php
					}
				}while ($rowIee=mysqli_fetch_array($bdIee));
			}
		?>
</table>
