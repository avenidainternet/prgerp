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

	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['nOrden'])) 	{ $nOrden    = $_POST['nOrden']; 	}

	if(isset($_POST['confirmarGuardar'])){ 

		$nDocGes 	= $_POST['nDocGes'];
		$accion 	= $_POST['accion'];
		
		$link=Conectarse();
		$filtroSQL = "Where nPerfil != 'WM'";
		$bdUs=mysql_query("SELECT * FROM Usuarios $filtroSQL Order By nPerfil");
		if($rowUs=mysql_fetch_array($bdUs)){
			do{
				$accDo	= 'accDoc'.$rowUs['usr'];
				$accDoc = $_POST[$accDo];
				$usrDoc	= $rowUs['usr'];
				
				$bdAcc=mysql_query("SELECT * FROM accesoDoc Where nDocGes = '".$nDocGes."' and usr = '".$rowUs['usr']."'");
				if($rowAcc=mysql_fetch_array($bdAcc)){
					if($accDoc != 'on'){
						$bdAcc=mysql_query("DELETE FROM accesoDoc Where nDocGes = '".$nDocGes."' and usr = '".$rowUs['usr']."'");
					}
				}else{
					if($accDoc == 'on'){
						mysql_query("insert into accesoDoc	(	nDocGes,
																usr,
																accDoc
															)	 
													 values (	'$nDocGes',
																'$usrDoc',
																'$accDoc'
															)",$link);
					}
				}
			}while ($rowUs=mysql_fetch_array($bdUs));
		}
		mysql_close($link);

	}
	
	if(isset($_GET['nDocGes'])) 	{ $nDocGes    = $_GET['nDocGes']; 	}
	
	$link=Conectarse();
	$bdDoc=mysql_query("SELECT * FROM Documentacion WHERE nDocGes = '".$nDocGes."'");
	if($rowDoc=mysql_fetch_array($bdDoc)){
		$Referencia 		= $rowDoc['Referencia'];
		$Documento 			= $rowDoc['Documento'];
		$Revision 			= $rowDoc['Revision'];
		$fechaAprobacion 	= $rowDoc['fechaAprobacion'];
		$sinAcceso 			= $rowDoc['sinAcceso'];
	}
	mysql_close($link);
?>
<form name="form" action="accesosDocumentos.php" method="post">
	<div id="BarraOpciones">
		<div id="ImagenBarraLeft">
			<a href="archivos.php" title="Archivos">
				<img src="../imagenes/open_48.png"></a>
			<br>
			Docs
		</div>
	</div>
		<?php
			if($rBD == true){
				?>
					<div class="exito mensajes2">Se ha guardado exitosamente el Registro...</div>
				<?php
			}
		?>
		<table width="50%" border="0" cellspacing="0" cellpadding="0" id="tablaDatosAjax" style="margin-top:15px; " align="center">
			<tr>
				<td colspan="2" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<span style="padding-left:15px;">Acceso a  Documentos - <?php echo $Referencia; ?></span><br>
					<span style="padding-left:20px; color:#CCCCCC; font-weight:700;"> Docto: <?php echo $Documento; ?></span>
					<input name="nDocGes" 	type="hidden" value="<?php echo $nDocGes; ?>">
					<input name="accion"	type="hidden" value="<?php echo $accion; ?>">
				</td>
			</tr>
			<tr>
				<td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;" align="center">
					Acceso al Documento
				</td>
			  	<td align="center" style="border-bottom:1px solid #ccc;">
					Usuarios
				</td>
		  	</tr>
			<?php
				$link=Conectarse();
				$filtroSQL = "Where nPerfil != 'WM'";
				$bdUs=mysql_query("SELECT * FROM Usuarios $filtroSQL Order By nPerfil"); // N° de Documento de Gestión
				if($rowUs=mysql_fetch_array($bdUs)){
					do{
						$muestra = 'Si';
						$bdPr=mysql_query("SELECT * FROM Perfiles Where IdPerfil = '".$rowUs['nPerfil']."'"); // N° de Documento de Gestión
						if($rowPr=mysql_fetch_array($bdPr)){
							if($rowPr['Perfil'] == 'Super Usuario'){
								$muestra = 'No';
							}
						}
						
						if($rowUs['usr'] == ' pantalla'){
							$muestra = 'No';
						}
						if($rowUs['usr'] == 'informes'){
							$muestra = 'No';
						}
						if($rowUs['usr'] == ' muestras'){
							$muestra = 'No';
						}
						
						if($muestra == 'Si'){?>
							<tr>
								<td style=" border-bottom:1px solid #ccc;" align="center">
									<?php
										$accDo = 'accDoc'.$rowUs['usr'];
										$acc = 'off';
										$bdAcc=mysql_query("SELECT * FROM accesoDoc Where nDocGes = '".$nDocGes."' and usr = '".$rowUs['usr']."'");
										if($rowAcc=mysql_fetch_array($bdAcc)){
											$acc = $rowAcc['accDoc'];
										}
									?>
									<?php if($acc == 'on'){?>
											<input name="<?php echo $accDo; ?>" type="checkbox" checked>
									<?php }else{ ?>
											<input name="<?php echo $accDo; ?>" type="checkbox">
									<?php } ?>
								</td>
								<td style=" border-bottom:1px solid #ccc;">
									<?php echo $rowUs['usr']; ?>
								</td>
							</tr>
							<?php
						}
					}while ($rowUs=mysql_fetch_array($bdUs));
				}
				mysql_close($link);
			?>
		  	<tr>
				<td colspan="2" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px;">
					<?php
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualiza'){?>
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