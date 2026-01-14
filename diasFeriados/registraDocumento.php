<?php
	$accion = 'Guardar';
	$rBD 	= false;
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
	$sinAcceso 	= '';

	$nNota			= 0;
	$Nota 			= '';

	if(isset($_GET['nNota'])) 		{ $nNota  		= $_GET['nNota']; 	}
	
	if(isset($_POST['nNota'])) 		{ $nNota  		= $_POST['nNota']; 	}
	if(isset($_POST['Nota'])) 		{ $Nota   		= $_POST['Nota']; 	}
	if(isset($_POST['confirmarBorrar'])){ 
		$link=Conectarse();
		$BorrarDir = 'SI';
		
		$bdDoc=$link->query("SELECT * FROM cotizaNotas WHERE nNota = '".$_POST['nNota']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$bdProv=$link->query("DELETE FROM cotizaNotas WHERE nNota = '".$_POST['nNota']."'");
		}
		$link->close();
		$linkVolver = "Location: index.php";
		header($linkVolver);
	}

	if(isset($_POST['confirmarGuardar'])){ 
		$rBD 				= true;
		if(isset($_POST['nNota'])) { $nNota = $_POST['nNota']; }
		$Nota 				= $_POST['Nota'];
		
		$link=Conectarse();
		$SQL = "SELECT * FROM cotizaNotas WHERE nNota = '".$_POST['nNota']."'";
		$bdDoc=$link->query($SQL);
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$actSQL="UPDATE cotizaNotas SET ";
			$actSQL.="Nota				= '".$Nota.				"'";
			$actSQL.="WHERE nNota 		= '".$_POST['nNota'].	"'";
			$bdDoc=$link->query($actSQL);
		}else{
			$bdDoc=$link->query("SELECT * FROM cotizaNotas Order By nNota Desc");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$nNota = $rowDoc['nNota'] + 1;
			}
			$link->query("insert into cotizaNotas(	nNota,
													Nota
												)	 
									  values 	(	'$nNota',
													'$Nota'
									  			)");
			
		}
		$link->close();
		$linkVolver = "Location: index.php";
		//header($linkVolver);
	}
	
	if(isset($_GET['nNota'])) 		{ $nNota    	= $_GET['nNota']; 	}
	if(isset($_GET['accion'])) 		{ $accion    	= $_GET['accion']; 	}
	if($nNota){
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM cotizaNotas WHERE nNota = '".$nNota."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$Nota 				= $rowDoc['Nota'];
		}
		$link->close();
	}else{
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM cotizaNotas Order By nNota Desc");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$nNota = $rowDoc['nNota'] + 1;
		}
		if($nNota == 0){
			$nNota = 1;
		}
		$link->close();
	}
?>
<form name="form" action="agregaDoc.php" method="post" enctype="multipart/form-data">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="index.php" title="Notas">
				<img src="../imagenes/desactivadoPdf.png"></a>
			<br>
			Notas
		</div>
	</div>
		<?php
			if($rBD == true){
				?>
					<div class="exito mensajes2">Se ha guardado exitosamente el Registro...</div>
				<?php
			}
		?>
		<table width="95%" border="0" cellspacing="0" cellpadding="0" id="tablaDatosAjax" style="margin-top:15px; " align="center">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="padding-left:15px;">Formulario de Registro de Notas</span>
				</td>
			</tr>
			<tr>
			  <td style="border-right:1px solid #ccc;">N&deg; Nota</td>
			  <td style="font-size:16px;">
				<input name="nNota" type="hidden" value="<?php echo $nNota; ?>">
			  	<?php echo $nNota; ?>
			  </td>
			</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Notas</td>
			  	<td>
					<textarea name="Nota" cols=150 rows=10 id="Nota" ><?php echo $Nota; ?> </textarea>
					<script>
						CKEDITOR.replace( 'Notas' );
					</script>
				</td>
		  	</tr>
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<?php
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Eliminar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
</form>