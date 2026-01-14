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

	$nEns				= '';
	$Nota 				= '';
	$idEnsayo 			= '';
	$Ensayo				= '';
	$txtIntroduccion	= '';
	$Suf				= '';
	$Status				= 'on';
	$Estadistica		= 'on';

	if(isset($_GET['nEns'])) 			{ $nEns  			= $_GET['nEns']; 			}
	
	if(isset($_POST['nEns'])) 			{ $nEns  			= $_POST['nEns']; 			}
	if(isset($_POST['idEnsayo'])) 		{ $idEnsayo    		= $_POST['idEnsayo']; 		}
	if(isset($_POST['Ensayo'])) 		{ $Ensayo    		= $_POST['Ensayo']; 		}
	if(isset($_POST['txtIntroduccion'])){ $txtIntroduccion  = $_POST['txtIntroduccion'];}
	if(isset($_POST['Status']))			{ $Status 	 		= $_POST['Status'];			}
	if(isset($_POST['Estadistica']))	{ $Estadistica 		= $_POST['Estadistica'];	}
	if(isset($_POST['Suf']))			{ $Suf  			= $_POST['Suf'];			}

	if(isset($_POST['confirmarBorrar'])){ 
		$link=Conectarse();
		$BorrarDir = 'SI';
		
		$bdDoc=$link->query("SELECT * FROM amEnsayos WHERE nEns = '".$_POST['nEns']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$bdProv=$link->query("DELETE FROM amEnsayos WHERE nEns = '".$_POST['nEns']."'");
		}
		$link->close();
		$linkVolver = "Location: index.php";
		header($linkVolver);
	}

	if(isset($_POST['confirmarGuardar'])){ 
	
		$rBD 				= true;
		$nEns 				= $_POST['nEns'];
		$txtIntroduccion	= $_POST['txtIntroduccion'];
		$idEnsayo 			= $_POST['idEnsayo'];
		$Ensayo 			= $_POST['Ensayo'];

		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM amEnsayos WHERE nEns = '".$_POST['nEns']."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$actSQL="UPDATE amEnsayos SET ";
			$actSQL.="txtIntroduccion	= '".$txtIntroduccion.	"',";
			$actSQL.="Ensayo			= '".$Ensayo.			"',";
			$actSQL.="idEnsayo			= '".$idEnsayo.			"',";
			$actSQL.="Status			= '".$Status.			"',";
			$actSQL.="Estadistica		= '".$Estadistica.		"',";
			$actSQL.="Suf				= '".$Suf.				"'";
			$actSQL.="WHERE nEns 		= '".$_POST['nEns'].	"'";
			$bdDoc=$link->query($actSQL);
		}else{
			$link->query("insert into amEnsayos		(	nEns,
														idEnsayo,
														Ensayo,
														Status,
														Estadistica,
														Suf,
														txtIntroduccion
													)	 
										  values 	(	'$nEns',
										  				'$idEnsayo',
										  				'$Ensayo',
										  				'$Status',
										  				'$Estadistica',
										  				'$Suf',
														'$txtIntroduccion'
										  			)");
			
		}
		$link->close();
		//header("Location: archivos.php");
	}
	
	if(isset($_GET['nEns'])) 		{ $nEns    		= $_GET['nEns']; 	}
	if(isset($_GET['accion'])) 		{ $accion    	= $_GET['accion']; 	}
	if($nEns){
		$link=Conectarse();
		$bdDoc=$link->query("SELECT * FROM amEnsayos WHERE nEns = '".$nEns."'");
		if($rowDoc=mysqli_fetch_array($bdDoc)){
			$txtIntroduccion	= $rowDoc['txtIntroduccion'];
			$idEnsayo 			= $rowDoc['idEnsayo'];
			$Ensayo 			= $rowDoc['Ensayo'];
			$Status 			= $rowDoc['Status'];
			$Estadistica		= $rowDoc['Estadistica'];
			$Suf 				= $rowDoc['Suf'];
		}
		$link->close();
	}else{
		$link=Conectarse();
			$bdDoc=$link->query("SELECT * FROM amEnsayos Where Ensayo != 'Otro' Order By nEns Desc");
			if($rowDoc=mysqli_fetch_array($bdDoc)){
				$nEns = $rowDoc['nEns'] + 1;
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
			Ensayos
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
					<span style="padding-left:15px;">Formulario de Registro de Ensayos</span>
				</td>
			</tr>
			<tr>
			  <td style="border-right:1px solid #ccc;">N&deg; Nota</td>
			  <td style="font-size:16px;">
				<input name="nEns" type="hidden" value="<?php echo $nEns; ?>">
			  	<?php echo $nEns; ?>
			  </td>
			</tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Ensayo</td>
			  	<td width="85%"><input name="Ensayo" type="text" size="50" maxlength="50" value="<?php echo $Ensayo; ?>" autofocus></td>
		  	</tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Nemotecnico Ensayo</td>
			  	<td width="85%"><input name="idEnsayo" type="text" size="3" maxlength="3" value="<?php echo $idEnsayo; ?>" ></td>
		  	</tr>
			<tr>
				<td width="15%" style="border-right:1px solid #ccc;">Sufijo Ensayo</td>
			  	<td width="85%"><input name="Suf" type="text" size="2" maxlength="2" value="<?php echo $Suf; ?>" ></td>
		  	</tr>
			<tr>
				<td style="border-right:1px solid #ccc;">Texto Introducción</td>
			  	<td>
					<textarea name="txtIntroduccion" id="txtIntroduccion" cols=150 rows=10 ><?php echo $txtIntroduccion; ?></textarea>
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