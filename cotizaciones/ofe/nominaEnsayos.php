<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tablaEnsayos">
	<tr>
    	<td class="titLisEnsayos" colspan=4>Ensayos de Laboratorio</td>
  	</tr>
		<?php
			$bdIee=$link->query("SELECT * FROM ofensayos");
			if($rowIee=mysqli_fetch_array($bdIee)){
				do{ 
						?>
						<tr class="nominaEnsayos"> 
							<td width="20%" style="padding-left:5px;">
								<a href="edEnsayo.php?OFE=<?php echo $OFE; ?>&accion=OFE&nDescEnsayo=<?php echo $rowIee['nDescEnsayo']; ?>&accionEnsayo=Editar"><?php echo $rowIee['nomEnsayo']; ?></a>
							</td>
							<td width="68%">
								<a href="edEnsayo.php?OFE=<?php echo $OFE; ?>&accion=OFE&nDescEnsayo=<?php echo $rowIee['nDescEnsayo']; ?>&accionEnsayo=Editar"><?php echo $rowIee['Descripcion']; ?></a>
							</td>
							<td width="06%" align="center" class="eImg">
								<a href="edEnsayo.php?OFE=<?php echo $OFE; ?>&accion=OFE&nDescEnsayo=<?php echo $rowIee['nDescEnsayo']; ?>&accionEnsayo=Editar"><img src="../../imagenes/corel_draw_128.png" 	width="30" title="Editar Ensayo"></a>
							</td>
							<td width="06%" align="center" class="eImg">
								<a href="edEnsayo.php?OFE=<?php echo $OFE; ?>&accion=OFE&nDescEnsayo=<?php echo $rowIee['nDescEnsayo']; ?>&accionEnsayo=Borrar"><img src="../../imagenes/del_128.png" 		width="30" title="Borrar Ensayo"></a>
							</td>
						</tr>
						<?php
				}while ($rowIee=mysqli_fetch_array($bdIee));
			}
		?>
</table>
