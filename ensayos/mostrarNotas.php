<?php
	
	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));

	$dBuscado 	= '';
	$filtroSQL 	= '';
	
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>

	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="../plataformaErp.php" title="Menú Principal">
				<img src="../gastos/imagenes/Menu.png"></a>
			<br>
			Principal
		</div>
		<div id="ImagenBarraLeft">
			<a href="agregaDoc.php" title="Agregar Nota">
				<img src="../imagenes/agragarEquipo.png"></a>
			<br>
			+Nota
		</div>
	</div>
	<div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="20%" height="40"  align="center"><strong>Ensayos Asociado(s)	</strong></td>
				<td  width="64%" align="center"><strong>Notas								</strong></td>
				<td  width="13%" colspan="2" rowspan="2" align="center"><strong>Acciones	</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$link=Conectarse();

				$filSQL = "Where 1";
				
				$bdDoc=$link->query("SELECT * FROM amNotas $filtroSQL Order By nNota"); 
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					do{
						$tr = "barraBlanca";
						if($rowDoc['idEnsayo']){
							$tr = 'barraVerde';
						}?>
						<tr id="<?php echo $tr; ?>">
							<td width="20%">
								<?php 
									if($rowDoc['idEnsayo']){
										echo $rowDoc['idEnsayo'];
									}else{
										echo 'Todos';
									}
								?>
							</td>
							<td width="64%">
								<?php echo $rowDoc['Nota']; ?>
							</td>
							<td width="7%"><a href="agregaDoc.php?accion=Actualizar&nNota=<?php echo $rowDoc['nNota']; 	?>"><img src="../gastos/imagenes/corel_draw_128.png"   		width="32" height="32" title="Editar Nota">	</a></td>
							<td width="6%"><a href="agregaDoc.php?accion=Eliminar&nNota=<?php echo $rowDoc['nNota']; 	?>"><img src="../imagenes/inspektion.png"   		width="32" height="32" title="Eliminar Nota">		</a></td>
						</tr>
						<?php
					}while ($rowDoc=mysqli_fetch_array($bdDoc));
				}
				$link->close();
				?>
	  </table>
</div>
		