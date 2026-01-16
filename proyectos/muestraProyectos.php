<?php
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');

	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	$usrRes		= $_GET['usrRes'];
	$tpAccion	= $_GET['tpAccion'];
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php 
						desplegarProyectos($usrRes, $tpAccion); 
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function desplegarProyectos($usrRes, $tpAccion){?>
			<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">
				<tr>
					<td  width="15%" align="center" height="40">Proyectos			</td>
					<td  width="22%">							Nombre Proyecto		</td>
					<td  width="15%">							Jéfe<br>Proyecto	</td>
					<td  width="15%">							Email				</td>
					<td  width="15%">							Bancos				</td>
					<td  width="18%" align="center">Acciones						</td>
					</tr>
			</table>
			
			<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">
				<?php
					$tr = "bVerde";
					$link=Conectarse();
					$bdEnc=mysql_query("SELECT * FROM Proyectos");
					if($row=mysql_fetch_array($bdEnc)){
						do{?>
						<tr id="<?php echo $tr; ?>">
							<td width="15%" style="font-size:12px;" align="center">
								<strong style="font-size:25; font-weight:700">
									<?php echo $row['IdProyecto']; ?>
								</strong>
							</td>
							<td width="22%" style="font-size:12px;">
								<?php echo $row['Proyecto']; ?>
							</td>
							<td width="15%" style="font-size:12px;">
								<?php echo $row['JefeProyecto']; ?>
							</td>
							<td width="15%" style="font-size:12px;">
								<?php echo $row['Email']; ?>
							</td>
							<td width="15%" style="font-size:12px;">
								<?php echo $row['Banco']; ?>
							</td>
							<td width="09%" align="center"><a href="actualizaProyecto.php?IdProyecto=<?php echo $row['IdProyecto']; ?>&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Proyecto">	</a></td>
							<td width="09%" align="center"><a href="actualizaProyecto.php?IdProyecto=<?php echo $row['IdProyecto']; ?>&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Proyecto">	</a></td>
						</tr>
						<?php
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				?>
			</table>
			<?php
		}
		?>

