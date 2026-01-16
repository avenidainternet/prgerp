<?php
		$valorUF 		= 0;
		$Factura 		= 0;
		$pagoFactura 	= 0;
		$Fotocopia		= '';
		$txtSeguimiento = '';
		$recepcionada	= 'off';
		
		if(isset($_GET['CAM'])) 		{ $CAM   		= $_GET['CAM']; 		}
		if(isset($_GET['RutCli'])) 		{ $RutCli   	= $_GET['RutCli']; 		}
		if(isset($_GET['rango'])) 		{ $rango   		= $_GET['rango']; 		}

		if(isset($_POST['CAM'])) 		{ $CAM  		= $_POST['CAM']; 		}
		if(isset($_POST['RutCli'])) 	{ $RutCli   	= $_POST['RutCli']; 	}
		if(isset($_POST['rango'])) 		{ $rango   		= $_POST['rango']; 		}


/*      Recalcular */

		$link=Conectarse();
		$bdDet=$link->query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($rowDet=mysqli_fetch_array($bdDet)){
			$Cliente = $rowDet['Cliente'];
		}

/*      Guardar */
		if(isset($_POST['Eliminar'])){
			if(isset($_POST['CAM'])) 	 		{ $CAM		   		= $_POST['CAM']; 			}
			if(isset($_POST['RutCli'])) 	 	 { $RutCli   		= $_POST['RutCli']; 		}
			$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE cotizaciones SET ";
				$actSQL.="Eliminado	= 'on'";
				$actSQL.="WHERE CAM	= '".$CAM."'";
				$bdFac=$link->query($actSQL);
			}
			header("Location: plataformaFacturas.php?rango=$rango");
		}
		if(isset($_POST['SinSeguimiento'])){
			if(isset($_POST['CAM'])) 	{ $CAM   	= $_POST['CAM']; 	}
			if(isset($_POST['RutCli'])) { $RutCli   = $_POST['RutCli']; }
			$fechaHoy = date('Y-m-d');
			$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE cotizaciones SET ";
				$actSQL.="Seguimiento			= 'on',";
				$actSQL.="fechaSeguimiento		='".$fechaHoy."'";
				$actSQL.="WHERE CAM				= '".$CAM."'";
				$bdFac=$link->query($actSQL);
			}
			
		}
		if(isset($_POST['ConSeguimiento'])){
			if(isset($_POST['CAM'])) 	 { $CAM   	= $_POST['CAM']; 	}
			if(isset($_POST['RutCli']))	 { $RutCli	= $_POST['RutCli']; }
			$fechaHoy = '0000-00-00';
			$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE cotizaciones SET ";
				$actSQL.="Seguimiento		= 'off',";
				$actSQL.="fechaSeguimiento	='".$fechaHoy."'";
				$actSQL.="WHERE CAM			= '".$CAM."'";
				$bdFac=$link->query($actSQL);
			}
			
		}
		if(isset($_POST['Activar'])){
			if(isset($_POST['CAM'])) 	{ $CAM   	= $_POST['CAM']; 	}
			if(isset($_POST['RutCli'])) { $RutCli   = $_POST['RutCli']; 		}
			$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE cotizaciones SET ";
				$actSQL.="Eliminado			= ''";
				$actSQL.="WHERE CAM	= '".$CAM."'";
				$bdFac=$link->query($actSQL);
			}
			header("Location: plataformaFacturas.php?rango=$rango");
			
		}
		
		if(isset($_POST['Guardar'])){
			if(isset($_POST['CAM'])) 	 		 { $CAM   			= $_POST['CAM']; 			}
			if(isset($_POST['RutCli'])) 	 	 { $RutCli   		= $_POST['RutCli']; 		}
			if(isset($_POST['recepcionada'])) 	 { $recepcionada	= $_POST['recepcionada'];	}
			if(isset($_POST['fechaRecepcion']))  { $fechaRecepcion	= $_POST['fechaRecepcion'];	}
			if(isset($_POST['fechaProxContacto']))  { $fechaProxContacto	= $_POST['fechaProxContacto'];	}

			$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$CAM = $rowFac['CAM'];
				$actSQL="UPDATE cotizaciones SET ";
				$actSQL.="recepcionada		='".$recepcionada.	"',";
				$actSQL.="fechaRecepcion	='".$fechaRecepcion."'";
				$actSQL.="WHERE CAM	= '".$CAM."'";
				$bdFac=$link->query($actSQL);
			}
			
			$fechaContacto = '0000-00-00';
			if(isset($_POST['fechaContacto']))  	{ $fechaContacto		= $_POST['fechaContacto'];		}
			if(isset($_POST['txtContacto']))  		{ $txtContacto			= $_POST['txtContacto'];		}
			if(isset($_POST['fechaProxContacto']))  { $fechaProxContacto	= $_POST['fechaProxContacto'];	}

			if($fechaContacto > '0000-00-00' and $txtContacto){
				$bdFac=$link->query("SELECT * FROM seguimientoAM Where CAM = '".$CAM."' and fechaContacto = $fechaContacto");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					$actSQL="UPDATE seguimientoAM SET ";
					$actSQL.="txtContacto	='".$txtContacto.		"'";
					$actSQL.="WHERE CAM		= '".$CAM."' and fechaContacto = '".$fechaContacto."'";
					$bdFac=$link->query($actSQL);
				}else{
						$link->query("insert into seguimientoAM		(	CAM,
																		fechaContacto,
																		txtContacto,
																		fechaProxContacto
																	) 
														values 		(	'$CAM',
																		'$fechaContacto',
																		'$txtContacto',
																		'$fechaProxContacto'
																)");
				}
			}
			header("Location: plataformaFacturas.php?rango=$rango");
			
		}

		$bdFac=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
		if ($rowFac=mysqli_fetch_array($bdFac)){
			$recepcionada		= $rowFac['recepcionada'];
			$fechaRecepcion		= $rowFac['fechaRecepcion'];
			$Eliminado			= $rowFac['Eliminado'];
			$Seguimiento		= $rowFac['Seguimiento'];
			$fechaSeguimiento	= $rowFac['fechaSeguimiento'];
		}
		$link->close();

		?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<form name="form" action="seguimientoSolicitudes.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoCobranza">
					<div id="ImagenBarra">
						<a href="plataformaFacturas.php?rango=<?php echo $rango; ?>" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../imagenes/conSeguimiento.png" width="50" height="50" align="absmiddle">
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Seguimiento AM 
						</strong>
					</div> 
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td colspan="5" align="center" class="txtGrandeSub">
								<?php echo $Cliente; ?><br>
								CAM-<?php echo $CAM; ?>
								<input type="hidden" name="RutCli" 			style="font-size:18px;" value="<?php echo $RutCli; 			?>">
								<input type="hidden" name="CAM" 			style="font-size:18px;" value="<?php echo $CAM; 			?>">
								<input type="hidden" name="rango" 			style="font-size:18px;" value="<?php echo $rango; 			?>">
								<input type="hidden" name="fechaRecepcion"  style="font-size:18px;" value="<?php echo $fechaRecepcion; 	?>">
							</td>
						</tr>
						<tr>
							<td colspan="5"><hr></td>
						</tr>
						<?php if($rango == 5) {?>
							<tr>
								<td class="numeroGrande">1</td>
								<td class="txtGrande">Recepcionado</td>
								<td align="center">
									<?php if($recepcionada == 'on'){ ?>
										<input name="recepcionada" type="checkbox" checked>
									<?php }else{ ?>
										<input name="recepcionada" type="checkbox">
									<?php } ?>
								</td>
								<td align="center">&nbsp;</td>
								<td>
									<input type="date" name="fechaRecepcion"  style="font-size:18px;" value="<?php echo $fechaRecepcion; ?>">
								</td>
							</tr>
							<tr>
								<td colspan="5"><hr></td>
							</tr>
							<tr>
								<td class="numeroGrande">2</td>
								<td class="txtGrande">
								   <?php 
									if($Seguimiento == 'on'){?>
										Con Seguimiento
										<?php
									}else{?>
										Sin Seguimiento
										<?php
									}
									?>
								</td>
								<td align="center">&nbsp;</td>
								<td align="center">&nbsp;</td>
								<td>
								   <?php 
									if($Seguimiento == 'on'){?>
										<button name="ConSeguimiento">
											<img src="../imagenes/conSeguimiento.png" width="48" height="48">
										</button>
										<?php
									}else{?>
										<button name="SinSeguimiento">
											<img src="../imagenes/AlertaSeguimiento.png" width="48" height="48">
										</button>
										<?php
									}
									?>
								</td>
							</tr>
							<tr>
								<td colspan="5"><hr></td>
							</tr>
						<?php } ?>
						<tr>
							<td class="numeroGrande">3</td>
							<td class="txtGrande" colspan="4">Seguimiento CAM</td>
						</tr>
						<tr>
							<td colspan=5 style="font-family:Arial; font-size:18px;">
								<table border=1 width='100%' cellspacing="0" cellpadding="0" bgcolor="#fff">
									<tr>
										<td width='20%' style="padding:5px;">Fecha<br>Contacto</td>
										<td width='60%' style="padding:5px;">Descripción</td>
										<td width='20%' style="padding:5px;">Seguimiento</td>
									</tr>
									
									<?php
									$link=Conectarse();
									$bd=$link->query("SELECT * FROM seguimientoAM Where CAM = $CAM Order By fechaContacto Asc" );
									if($row=mysqli_fetch_array($bd)){
										do{?>
											<tr>
												<td align="center" style="padding:5px;">
													<?php echo $row['fechaContacto']; ?>
												</td>
												<td align="center" style="padding:5px;">
													<?php echo $row['txtContacto']; ?>
												</td>
												<td align="center" style="padding:5px;">
													<?php echo $row['fechaProxContacto']; ?>
												</td>
											</tr>
										<?php
										}while ($row=mysqli_fetch_array($bd));
									}
									$link->close();
									?>
									
									<tr>
										<td align="center" style="padding:5px;">
											<?php $fechaContacto = date('Y-m-d'); ?>
											<input name="fechaContacto" type="date" value="<?php echo $fechaContacto; ?>">
										</td>
										<td align="center" style="padding:5px;">
											<input name="txtContacto" type="text" size="80">
										</td>
										<td align="center" style="padding:5px;">
											<?php $fechaProxContacto = date('Y-m-d'); ?>
											<input name="fechaProxContacto" type="date" value="<?php echo $fechaProxContacto; ?>">
										</td>
									</tr>
								</table>
								<?php echo $txtSeguimiento; ?>
							</td>
						</tr>
						
						<tr>
							<td>&nbsp;<td>
						</tr>

						<tr>
							<td colspan="5" class="txtGrandeSub" align="right">
								<?php if($Eliminado == 'on'){?>
									<button name="Activar" style="padding:10px;" title="Activar">
										<img src="../gastos/imagenes/todo.png" width="48" height="48">
									</button>
								<?php }else{ ?>
									<button name="Eliminar" style="padding:10px;" title="Dar de Baja">
										<img src="../gastos/imagenes/open_edupage_64.png" width="48" height="48">
									</button>
								<?php } ?>
								<button name="Guardar" style="padding:10px;">
									<img src="../gastos/imagenes/guardar.png" width="48" height="48">
								</button>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</form>