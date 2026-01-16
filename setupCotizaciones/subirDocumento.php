<?php
	$accion = 'Guardar';
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

	if(isset($_POST['confirmarGuardar'])){ 

		if(isset($_POST['nDocGes'])) 	{ $nDocGes   	= $_POST['nDocGes']; 	}
		if(isset($_POST['Referencia'])) { $Referencia   = $_POST['Referencia']; }
		if(isset($_POST['Revision'])) 	{ $Revision   	= $_POST['Revision']; 	}
		
		/* Documento PDF */
		$nombre_Pdf 	= $_FILES['PDF']['name'];
		$tipo_Pdf 		= $_FILES['PDF']['type'];
		$tamano_Pdf 	= $_FILES['PDF']['size'];
		$desde_Pdf		= $_FILES['PDF']['tmp_name'];

		$directorioPdf="docPdf";
		if(!file_exists($directorioPdf)){
			mkdir($directorioPdf,0755);
		}

		/* Documento PDF */
		$nombre_Word	= $_FILES['WORD']['name'];
		$tipo_Word 		= $_FILES['WORD']['type'];
		$tamano_Word 	= $_FILES['WORD']['size'];
		$desde_Word		= $_FILES['WORD']['tmp_name'];

		$directorioDoc="docDoc";
		if(!file_exists($directorioDoc)){
			mkdir($directorioDoc,0755);
		}

		if($tipo_Pdf == "application/pdf") {
    		//if(move_uploaded_file($desde_Pdf, $directorioPdf."/".$nombre_Pdf)){
			$newPdf = $Referencia.'-'.$Revision.'.pdf';

			$link=Conectarse();
			$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$pdf 				= $rowDoc['pdf'];
			}
			$link->close();
			
			if($pdf){
				if($pdf != $newPdf){
					unlink($directorioPdf.'/'.$pdf);
				}
			}
			
    		if(move_uploaded_file($desde_Pdf, $directorioPdf."/".$newPdf)){ 
				$link=Conectarse();
				$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$_POST['nDocGes']."'");
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					echo 'Entra...';
					$actSQL="UPDATE Documentacion SET ";
					$actSQL.="pdf			= '".$nombre_Pdf.		"'";
					$actSQL.="WHERE nDocGes = '".$_POST['nDocGes'].	"'";
					$bdDoc=$link->query($actSQL);
				}
				$link->close();
			}
		}

		if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $tipo_Word == "application/msword") {
			if($tipo_Word == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				$newWord = $Referencia.'-'.$Revision.'.docx';
			}
			if($tipo_Word == "application/msword") {
				$newWord = $Referencia.'-'.$Revision.'.doc';
			}

			$link=Conectarse();
			$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$word 				= $rowDoc['word'];
			}
			$link->close();
			
			if($word){
				if($word != $newWord){
					unlink($directorioWord.'/'.$word);
				}
			}

    		if(move_uploaded_file($desde_Word, $directorioDoc."/".$newWord)){ 
				$link=Conectarse();
				$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$_POST['nDocGes']."'");
				if($rowDoc=mysqli_fetch_array($bdDoc)){
					$actSQL="UPDATE Documentacion SET ";
					$actSQL.="word			= '".$newWord.			"'";
					$actSQL.="WHERE nDocGes = '".$_POST['nDocGes'].	"'";
					$bdDoc=$link->query($actSQL);
				}
				$link->close();
			}
		}
		
	}
	
	if(isset($_GET['accion'])) 	{ $accion    = $_GET['accion']; 	}
	if(isset($_GET['nDocGes'])) { $nDocGes   = $_GET['nDocGes']; 	}

	if(isset($_POST['accion'])) { $accion    = $_POST['accion']; 	}
	if(isset($_POST['nDocGes'])){ $nDocGes   = $_POST['nDocGes']; 	}

	if(isset($_POST['accion'])) 	{ $accion    = $_POST['accion']; 	}

	$link=Conectarse();
	$bdDoc=$link->query("SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'");
	if($rowDoc=mysqli_fetch_array($bdDoc)){
		$Referencia 		= $rowDoc['Referencia'];
		$Documento 			= $rowDoc['Documento'];
		$Revision 			= $rowDoc['Revision'];
		$fechaAprobacion 	= $rowDoc['fechaAprobacion'];
		$pdf 				= $rowDoc['pdf'];
		$word 				= $rowDoc['word'];
	}
	$link->close();
?>
<form name="form" action="subirDoc.php" method="post" enctype="multipart/form-data">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="archivos.php" title="Archivos">
				<img src="../imagenes/open_48.png"></a>
			<br>
			Docs
		</div>
	</div>
		<table width="95%" border="0" cellspacing="0" cellpadding="0" id="tablaDatosAjax" style="margin-top:15px; " align="center">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="padding-left:15px;">Formulario de Registro de Documentos</span>
				</td>
			</tr>
			<tr>
			  <td style="border-right:1px solid #ccc;">N&deg; Documento</td>
			  <td style="font-size:16px;">
				<input name="accion" 	type="hidden" value="<?php echo $accion; ?>">
				<input name="nDocGes" 	type="hidden" value="<?php echo $nDocGes; ?>">
			  	<?php echo $nDocGes; ?>
			  </td>
		  </tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Referencia</td>
			  	<td width="85%" style="font-size:16px;">
					<input name="Referencia" type="hidden" value="<?php echo $Referencia; ?>">
					<?php echo $Referencia; ?>
				</td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Documento</td>
			  	<td style="font-size:16px;"><?php echo $Documento; ?></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Revisión</td>
			  	<td style="font-size:16px;">
					<input name="Revision" type="hidden" value="<?php echo $Revision; ?>">
					<?php echo $Revision; ?>
				</td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Fecha Aprobación</td>
			  	<td style="font-size:16px;"><?php echo $fechaAprobacion; ?></td>
		  	</tr>
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="14%" height="42">PDF</td>
						  <td width="52%">
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="PDF" type="file" id="PDF">
								<?php 
									if($pdf){
										$dPdf = 'docPdf/'.$pdf;
										?>
										<a href="<?php echo $dPdf; ?>" target="_blank"><img src="../imagenes/informes.png" width="30"></a>
										<?php
										echo $pdf;
									}
								?>
						  </td>
						  <td width="34%" rowspan="2" valign="top">
								<?php
									if($accion == 'Subir'){?>
										<div id="botonImagen">
											<button name="confirmarGuardar" style="float:right;">
												<img src="../imagenes/upload2.png" width="55" height="55">
											</button>
										</div>
										<?php
									}
								?>
						  </td>
					  </tr>
						<tr>
							<td>Word</td>
							<td>
								<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
								<input name="WORD" type="file" id="WORD">
								<?php 
									if($word){
										$dDoc = 'docDoc/'.$word;
										?>
										<a href="<?php echo $dDoc; ?>" target="_blank"><img src="../imagenes/word.png" width="30"></a>
										<?php
										echo $word;
									}
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
</form>