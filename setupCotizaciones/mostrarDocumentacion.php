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

	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}
	
?>

	<div>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
			<tr>
				<td  width="15%" height="40" 	align="center"><strong>Referencia			</strong></td>
				<td  width="58%"  				align="center"><strong>Documento			</strong></td>
				<td  width="05%"  				align="center"><strong>Revisión			</strong></td>
				<td  width="12%"  				align="center"><strong>Fecha<br>Aprobación	</strong></td>
				<td  width="10%"  				align="center"><strong>Pdf					</strong></td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
			<?php
				$link=Conectarse();

				$filSQL = "Where 1";
				
				$bdDoc=mysql_query("SELECT * FROM Documentacion $filtroSQL Order By nDocGes"); // N° de Documento de Gestión
				if($rowDoc=mysql_fetch_array($bdDoc)){
					do{
						$bdAcc=mysql_query("SELECT * FROM accesoDoc Where nDocGes = '".$rowDoc['nDocGes']."' and usr = '".$_SESSION['usr']."'"); // N° de Documento de Gestión
						if($rowAcc=mysql_fetch_array($bdAcc)){
						
							$tr = "barraVerde";
							?>
							<tr id="<?php echo $tr; ?>">
								<td width="15%" align="center">
									<?php echo $rowDoc['Referencia']; ?>
								</td>
								<td width="58%">
									<?php echo $rowDoc['Documento']; ?>
								</td>
								<td width="05%">
									<?php echo $rowDoc['Revision']; ?>
								</td>
								<td width="12%" align="center">
									<?php 
										$fd = explode('-',$rowDoc['fechaAprobacion']);
										echo $fd[1].'/'.$fd[0]; 
									?>
								</td>
								<td width="10%" align="center">
									<?php $docPdf = 'docPdf/'.$rowDoc['pdf']; ?>
									<a href="<?php echo $docPdf; ?>" target="_blank" title="Ver PDF"> 
										<img src="../imagenes/informeUP.png" width="50">
									</a>
								</td>
							</tr>
							<?php
						}
					}while ($rowDoc=mysql_fetch_array($bdDoc));
				}
				mysql_close($link);
				?>
	  </table>
</div>
		