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

	$nNota				= '';
	$Nota 				= '';
	$idEnsayo 			= '';

	if(isset($_GET['nNota'])) 		{ $nNota  		= $_GET['nNota']; 	}
	
	if(isset($_POST['nNota'])) 		{ $nNota  		= $_POST['nNota']; 	}
	if(isset($_POST['idEnsayo'])) 	{ $idEnsayo    	= $_POST['idEnsayo']; 	}
	if(isset($_POST['Nota'])) 		{ $Nota   		= $_POST['Nota']; 	}

	if(isset($_POST['confirmarBorrar'])){ 
		$link=Conectarse();
		$BorrarDir = 'SI';
		
		$bdDoc=$link->query("SELECT * FROM amNotas WHERE nNota = '".$_POST['nNota']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$bdProv=$link->query("DELETE FROM amNotas WHERE nNota = '".$_POST['nNota']."'");
		}
		$link->close();
		$linkVolver = "Location: index.php";
		header($linkVolver);
	}

	if(isset($_POST['confirmarGuardar'])){ 

		$rBD 				= true;
		$nNota 				= $_POST['nNota'];
		$Nota 				= $_POST['Nota'];
		$idEnsayo 			= $_POST['idEnsayo'];

		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM amNotas WHERE nNota = '".$_POST['nNota']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$actSQL="UPDATE amNotas SET ";
			$actSQL.="Nota				= '".$Nota.				"',";
			$actSQL.="idEnsayo			= '".$idEnsayo.			"'";
			$actSQL.="WHERE nNota 		= '".$_POST['nNota'].	"'";
			$bdDoc=$link->query($actSQL);
		}else{
			$bdDoc=$link->query("SELECT * FROM amNotas Order By nNota Desc");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$nNota = $rowDoc['nNota'] + 1;
			}
			$link->query("insert into amNotas		(	nNota,
														idEnsayo,
														Nota
													)	 
										  values 	(	'$nNota',
										  				'$idEnsayo',
														'$Nota'
										  			)");
			
		}
		$link->close();
		//header("Location: archivos.php");
	}
	
	if(isset($_GET['nNota'])) 		{ $nNota    	= $_GET['nNota']; 	}
	if(isset($_GET['accion'])) 		{ $accion    	= $_GET['accion']; 	}
	if($nNota or $nNota == 0){
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM amNotas WHERE nNota = '".$nNota."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$Nota 				= $rowDoc['Nota'];
			$idEnsayo 			= $rowDoc['idEnsayo'];
		}
		$link->close();
	}
	if($accion == 'Agregar'){
		$Nota = '';
		$idEnsayo = '';
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM amNotas Order By nNota Desc");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$nNota = $rowDoc['nNota'] + 1;
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
				<td width="15%" style="border-right:1px solid #ccc;">Ensayo Asociado</td>
			  	<td width="85%">
					<select name="idEnsayo">
						<option></option>
					<?php
						$link=Conectarse();
						$bd=$link->query("SELECT * FROM amensayos Order By nEns Desc");
						while($row=mysqli_fetch_array($bd)){
							if($row['idEnsayo'] == $idEnsayo){?>
								<option selected value="<?php echo $row['idEnsayo']; ?>"><?php echo $row['idEnsayo']; ?></option>
								<?php
							}else{?>
								<option value="<?php echo $row['idEnsayo']; ?>"><?php echo $row['idEnsayo']; ?></option>
								<?php
							}
						}
						$link->close();
					?>
					</select>
					Dejar vacio para que se incluya en todos.
				</td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Nota</td>
			  	<td>
					<textarea name="Nota" cols=150 rows=10 ><?php echo $Nota; ?> </textarea>
				</td>
		  	</tr>
			
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<?php
						if($accion == 'Guardar' || $accion == 'Agregar' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="confirmarGuardar" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
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