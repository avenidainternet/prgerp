<?php
	$link=Conectarse();
	$nPreCam 	= 0;
	$bdEq=$link->query("SELECT * FROM precam Where Estado = 'on'");
	if($rowEq=mysqli_fetch_array($bdEq)){
		do{
			$nPreCam++;
		}while ($rowEq=mysqli_fetch_array($bdEq));
	}
	$link->close();
	
	switch ($_SESSION['Perfil']) {
		case 'Super Usuario':
		?>
			<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Menú
				</div>
				<ul>
					<li><a href="plataformaErp.php" 	title="Inicio">			<img src="imagenes/school_128.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
					<li><a href="cerrarsesion.php" 		title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Acreditación
				</div>
				<ul>
					<li><a href="archivo/archivos.php" 					title="Archivos">					<img src="imagenes/open_48.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Documentación		</a></li>

					<?php
						$link=Conectarse();
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM accionesCorrectivas");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaCierre'] == '0000-00-00'){
									if($rowEq['accFechaTen'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['accFechaTen']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="correctivas/accionesCorrectivas.php"		title="Correctiva">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
							AC.
							<?php
							if($cActividades > 0){?>
								<img src="imagenes/bola_amarilla.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cActividades; ?></sup>
								</span>
								<?php
							}
							if($cVencidas > 0){?>
								<img src="imagenes/bola_roja.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cVencidas; ?></sup>
								</span>
								<?php
							}
							?>
						</a>
					</li>


					<?php
						$link=Conectarse();
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM accionesPreventivas");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaCierre'] == '0000-00-00'){
									$cVencidas++;
									
/*									
									if($rowEq['accFechaTen'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['accFechaTen']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
*/									
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="preventivas/accionesPreventivas.php"		title="Preventivas">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
							AP.
							<?php
							if($cActividades > 0){?>
								<img src="imagenes/bola_amarilla.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cActividades; ?></sup>
								</span>
								<?php
							}
							if($cVencidas > 0){?>
								<img src="imagenes/bola_roja.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cVencidas; ?></sup>
								</span>
								<?php
							}
							?>
						</a>
					</li>



					<?php
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM equipos");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaProxCal']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoCal'].' day' , strtotime ( $rowEq['fechaProxCal'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxCal']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}

								if($rowEq['fechaProxMan']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoMan'].' day' , strtotime ( $rowEq['fechaProxMan'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxMan']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}

								if($rowEq['fechaProxVer']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoVer'].' day' , strtotime ( $rowEq['fechaProxVer'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxVer']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="equipamiento/plataformaEquipos.php?tpAccion=mantencion"		title="Equipamiento">				
						<img src="imagenes/equipamiento.png" align="absmiddle" width="22px" height="22px">
							Equip.
							<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
							?>
							</a>
						</li>

						<?php
							$cActividades 	= 0;
							$cVencidas		= 0;
									
							$fechaHoyDia = date('Y-m-d');
							$bdEq=$link->query("SELECT * FROM Actividades Where Estado != 'T'");
							if($rowEq=mysqli_fetch_array($bdEq)){
								do{
									if($rowEq['fechaProxAct'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['fechaProxAct']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}while ($rowEq=mysqli_fetch_array($bdEq));
							}
						?>
						<li>
							<a href="actividades/plataformaActividades.php"		title="Actividades">
								<img src="imagenes/actividades.png"	align="absmiddle" width="22px" height="22px">
								Act.
								<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
								?>
							</a>
						</li>
					<?php $link->close(); ?>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Módulos
				</div>
				<ul>
					<li><a href="clientes/clientes.php" 		 					title="Mantención de Clientes">		<img src="imagenes/send_48.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes			</a></li>
					<li><a href="precam/preCAM.php" 		 						title="Pre Cotización">				
						<img src="imagenes/newPdf.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> 
						PRECAM 
						</a>
						<img src="imagenes/bola_amarilla.png">
						<span style="font-size:12px; font-weight:700;">
							<sup><?php echo $nPreCam; ?></sup>
						</span>
					</li>
					<li><a href="registroMat/recepcionMuestras.php" 				title="Registro de Muestras">		<img src="imagenes/machineoperator_128.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM				</a></li>
					<li><a href="RAMterminadas/ramTerminadas.php" 					title="RAM Terminadas">				<img src="imagenes/machineoperator_128.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM Terminadas	</a></li>
					<li><a href="otams/pOtams.php" 									title="Archivo de RAMs">			<img src="imagenes/consulta.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Archivo de RAMs	</a></li>
					<li><a href="cotizaciones/plataformaCotizaciones.php" 			title="Módulo de Procesos">			<img src="imagenes/other_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos			</a></li>
					<li><a href="generarinformes/plataformaGenInf.php" 				title="Generación de Informes">		<img src="imagenes/Tablas.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Generar Informes 	</a></li>
					<li><a href="informes/plataformaInformes.php" 					title="Módulo de Informes">			<img src="imagenes/informeUP.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes 			</a></li>
					<li><a href="gastos/plataformaintranet.php" 					title="Módulo de Gastos">			<img src="imagenes/group_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos			</a></li>
					<li><a href="personal/sueldos.php" 								title="Módulo de Sueldos">			<img src="imagenes/subst_student.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos			</a></li>
					<li><a href="sinfacturar/plataformaFacturas.php"				title="Sin Facturar">				<img src="imagenes/AlertaSeguimiento.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sin Facturar		</a></li>
					<li><a href="facturacion/plataformaFacturas.php"				title="Módulo de Facturación">		<img src="imagenes/crear_certificado.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación		</a></li>
					<li><a href="cobranza/plataformaFacturas.php"					title="Módulo de Cobranza">			<img src="imagenes/gastos.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Cobranza			</a></li>
					<li><a href="infofinanzas"										title="Informe Financiero">			<img src="imagenes/estadoFinanciero.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informe Financiero	</a></li>
					<li><a href="historico/plataformaHistorica.php"					title="Módulo Historico">			<img src="imagenes/summary_leassons.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico			</a></li>

					<li><a href="infoTv.php"										title="Módulo Programación">		<img src="imagenes/Preguntas.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pantalla		</a></li>
					<li><a href="pegasTv.php"										title="Módulo Pegas">				<img src="imagenes/inventarioMuestras.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Programación				</a></li>
					<li><a href="usrtv.php"											title="Módulo Pizarra">				<img src="imagenes/seguimiento.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pizarra			</a></li>
						
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/talleres.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Talleres
				</div>
				<ul>
					<li><a href="tallerPM/pTallerPM.php" title="Taller Ensayos Mecánicos">	<img src="imagenes/ensayos.png" style="margin:2px;" align="absmiddle" width="22px" height="22px"> Ensayos Mecánicos	</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/settings_32.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Configuraciones
				</div>
				<ul>
					<li><a href="datosEmpresa.php" 	 								title="Datos de la Institución">	<img src="imagenes/of.png" 							style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Institución		</a></li>
					<li><a href="docencia/plataformaFacturas.php"					title="Módulo de Docencia">			<img src="imagenes/acreditacion.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Docencia				</a></li>
					<li><a href="tablaRangos.php" 	 								title="Rangos">						<img src="imagenes/indicadores.png" 				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Rango Metas			</a></li>
					<li><a href="calibraciones" 									title="Calibraciones">				<img src="imagenes/calibraciones.png" 				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Calibraciones			</a></li>
					<li><a href="usuarios/plataformaUsuarios.php" 					title="Usuarios">					<img src="imagenes/class_32.png" 					style="margin:2px;" align="absmiddle" width="20px" height="20px"> Usuarios				</a></li>
					<li><a href="estadistica" 										title="Estadística">				<img src="imagenes/Mostrar.png" 					style="margin:2px;" align="absmiddle" width="20px" height="20px"> Estadísticas			</a></li>
					<li><a href="indicadores" 										title="Indicadores">				<img src="imagenes/indicador.png" 					style="margin:2px;" align="absmiddle" width="20px" height="20px"> Indicadores			</a></li>
					<li><a href="http://simet.cl/erp/limpiarDir.php" 				title="Descargar Informes">			<img src="imagenes/icono-descargas.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Descarga Informes		</a></li>
					<li><a href="vales" 											title="Registro de Vales">			<img src="imagenes/carpeta-negra.png" 				style="margin:2px;" align="absmiddle" width="20px" height="20px"> Registro de Vales		</a></li>
					<li><a href="http://simet.cl/erp/informes/lecturaInformes.php" 	title="Descarga de Informes">		<img src="imagenes/pdf_download.png" 				style="margin:2px;" align="absmiddle" width="20px" height="20px"> Informes Descargados 	</a></li>
					<li><a href="infoctacte" 										title="Cartola Ctas Corrientes">	<img src="imagenes/ctacte.png" 						style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cartola Cuentas 		</a></li>
					<li><a href="notas" 											title="Notas Informes">				<img src="imagenes/desactivadoPdf.png" 				style="margin:2px;" align="absmiddle" width="20px" height="20px"> Notas Informes		</a></li>
					<li><a href="ensayos" 											title="Ensayos">					<img src="imagenes/ensayos.png" 					style="margin:2px;" align="absmiddle" width="20px" height="20px"> Ensayos				</a></li>
					<li><a href="setupCotizaciones"									title="Notas Cotizaciones">			<img src="imagenes/desactivadoPdf.png" 				style="margin:2px;" align="absmiddle" width="20px" height="20px"> Notas Cotizaciones	</a></li>
					<li><a href="diasFeriados"										title="Feriados">					<img src="imagenes/poster_teachers.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Días Feriados			</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/seguridad.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Seguridad
				</div>
				<ul>
					<li><a href="respaldos/backup.php" 		title="Respaldo">			<img src="imagenes/Respaldar.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Respaldo			</a></li>
					<!-- <li><a href="upload/upload.php" 		title="UpLoad">				<img src="imagenes/upload-40.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> UpLoad			</a></li>-->
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Antiguo
				</div>
				<ul>
					<li><a href="encuesta/plataformaEncuesta.php"		title="Módulo Encuesta">			<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			</a></li>
						<?php
							$link=Conectarse();
							$cActividades 	= 0;
							$cVencidas		= 0;
									
							$fechaHoyDia = date('Y-m-d');
							$bdEq=$link->query("SELECT * FROM Visitas Where Estado = 'T'");
							if($rowEq=mysqli_fetch_array($bdEq)){
								do{
									if($rowEq['fechaProxAct'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['fechaProxAct']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}while ($rowEq=mysqli_fetch_array($bdEq));
							}
						?>
						<li>
							<a href="visitas/plataformaActividades.php"		title="Visitas">
								<img src="imagenes/contactus_128.png"	align="absmiddle" width="22px" height="22px">
								Visitas
								<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
								?>
							</a>
						</li>
					<li><a href="masivos/plataformaMasivos.php"						title="Correos Masivos">			<img src="imagenes/mail_html.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos		</a></li>
				</ul>
			</div>
			<?php
			break;
		case 'WebMaster':
			?>
			<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Menú
				</div>
				<ul>
					<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
					<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Acreditación
				</div>
				<ul>
					<li><a href="archivo/archivos.php" 				title="Archivos">					<img src="imagenes/open_48.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Documentación			</a></li>
					


					<?php
						$link=Conectarse();
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM accionesCorrectivas");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaCierre'] == '0000-00-00'){
									if($rowEq['accFechaTen'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['accFechaTen']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="correctivas/accionesCorrectivas.php"		title="Correctivas">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
							AC.
							<?php
							if($cActividades > 0){?>
								<img src="imagenes/bola_amarilla.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cActividades; ?></sup>
								</span>
								<?php
							}
							if($cVencidas > 0){?>
								<img src="imagenes/bola_roja.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cVencidas; ?></sup>
								</span>
								<?php
							}
							?>
						</a>
					</li>




					<?php
						$link=Conectarse();
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM accionesPreventivas");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaCierre'] == '0000-00-00'){
									$cVencidas++;
/*
									if($rowEq['accFechaTen'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['accFechaTen']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
*/										
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="preventivas/accionesPreventivas.php"		title="Preventivas">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
							AP.
							<?php
							if($cActividades > 0){?>
								<img src="imagenes/bola_amarilla.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cActividades; ?></sup>
								</span>
								<?php
							}
							if($cVencidas > 0){?>
								<img src="imagenes/bola_roja.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $cVencidas; ?></sup>
								</span>
								<?php
							}
							?>
						</a>
					</li>












					<?php
						$cActividades 	= 0;
						$cVencidas		= 0;
						$fechaHoyDia 	= date('Y-m-d');
									
						$bdEq=$link->query("SELECT * FROM equipos");
						if($rowEq=mysqli_fetch_array($bdEq)){
							do{
								if($rowEq['fechaProxCal']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoCal'].' day' , strtotime ( $rowEq['fechaProxCal'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxCal']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}

								if($rowEq['fechaProxMan']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoMan'].' day' , strtotime ( $rowEq['fechaProxMan'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxMan']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}

								if($rowEq['fechaProxVer']>'0000-00-00'){
									$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoVer'].' day' , strtotime ( $rowEq['fechaProxVer'] ) );
									$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
									if($fechaHoyDia >= $rowEq['fechaProxVer']){
										$cVencidas++;
									}else{
										if($fechaHoyDia >= $fechaxVencer){
											$cActividades++;
										}
									}
								}
							}while ($rowEq=mysqli_fetch_array($bdEq));
						}
					?>
					<li>
						<a href="equipamiento/plataformaEquipos.php?tpAccion=mantencion"		title="Equipamiento">				
						<img src="imagenes/equipamiento.png" align="absmiddle" width="22px" height="22px">
							Equip.
							<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
							?>
							</a>
						</li>

						<?php
							$cActividades 	= 0;
							$cVencidas		= 0;
									
							$fechaHoyDia = date('Y-m-d');
							$bdEq=$link->query("SELECT * FROM Actividades Where Estado != 'T'");
							if($rowEq=mysqli_fetch_array($bdEq)){
								do{
									if($rowEq['fechaProxAct'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['fechaProxAct']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}while ($rowEq=mysqli_fetch_array($bdEq));
							}
						?>
						<li>
							<a href="actividades/plataformaActividades.php"		title="Actividades">
								<img src="imagenes/actividades.png"	align="absmiddle" width="22px" height="22px">
								Act.
								<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
								?>
							</a>
						</li>
					<?php $link->close(); ?>

				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Módulos
				</div>
				<ul>
					<li><a href="clientes/clientes.php" 		 					title="Mantención de Clientes">		<img src="imagenes/send_48.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes				</a></li>
					<li><a href="precam/preCAM.php" 		 						title="Pre Cotización">				
						<img src="imagenes/newPdf.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> 
						PRECAM 
						</a>
						<img src="imagenes/bola_amarilla.png">
						<span style="font-size:12px; font-weight:700;">
							<sup><?php echo $nPreCam; ?></sup>
						</span>
					</li>
					<li><a href="registroMat/recepcionMuestras.php" 				title="Registro de Muestras">		<img src="imagenes/machineoperator_128.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM					</a></li>
					<li><a href="RAMterminadas/ramTerminadas.php" 					title="RAM Terminadas">				<img src="imagenes/machineoperator_128.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM Terminadas		</a></li>
					<li><a href="otams/pOtams.php" 									title="Archivo de RAMs">			<img src="imagenes/consulta.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Archivo de RAMs		</a></li>
					<li><a href="cotizaciones/plataformaCotizaciones.php" 			title="Módulo de Procesos">			<img src="imagenes/other_48.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos				</a></li>
					<li><a href="generarinformes/plataformaGenInf.php" 				title="Generación de Informes">		<img src="imagenes/Tablas.png"						style="margin:2px;" align="absmiddle" width="22px" height="22px"> Generar Informes 		</a></li>
					<li><a href="informes/plataformaInformes.php" 					title="Módulo de Informes">			<img src="imagenes/pdf.png"							style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes 				</a></li>
					<li><a href="gastos/plataformaintranet.php" 					title="Módulo de Gastos">			<img src="imagenes/group_48.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos				</a></li>
					<li><a href="personal/sueldos.php" 								title="Módulo de Sueldos">			<img src="imagenes/subst_student.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos				</a></li>
					<li><a href="sinfacturar/plataformaFacturas.php"				title="Sin Facturar">				<img src="imagenes/AlertaSeguimiento.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sin Facturar			</a></li>
					<li><a href="facturacion/plataformaFacturas.php"				title="Módulo de Facturación">		<img src="imagenes/crear_certificado.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación			</a></li>
					<li><a href="cobranza/plataformaFacturas.php"					title="Módulo de Cobranza">			<img src="imagenes/gastos.png"						style="margin:2px;" align="absmiddle" width="22px" height="22px"> Cobranza				</a></li>
					<li><a href="infofinanzas"										title="Informe Financiero">			<img src="imagenes/estadoFinanciero.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informe Financiero	</a></li>
					<li><a href="historico/plataformaHistorica.php"					title="Módulo Historico">			<img src="imagenes/summary_leassons.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico				</a></li>

					<li><a href="infoTv.php"										title="Módulo Programación">		<img src="imagenes/Preguntas.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pantalla		</a></li>
					<li><a href="pegasTv.php"										title="Módulo Pegas">				<img src="imagenes/inventarioMuestras.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Programación				</a></li>
					<li><a href="usrtv.php"											title="Módulo Pizarra">				<img src="imagenes/seguimiento.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pizarra			</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/talleres.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Talleres
				</div>
				<ul>
					<li><a href="tallerPM/pTallerPM.php" title="Taller Ensayos Mecánicos">	<img src="imagenes/probeta.png" style="margin:2px;" align="absmiddle" width="22px" height="22px"> Ensayos Mecánicos	</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/settings_32.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Configuraciones
				</div>
				<ul>
					<li><a href="datosEmpresa.php" 	 								title="Datos de la Institución">	<img src="imagenes/of.png" 					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Institución		</a>	</li>
					<li><a href="docencia/plataformaFacturas.php"					title="Módulo de Docencia">			<img src="imagenes/acreditacion.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Docencia				</a></li>
					<li><a href="proyectos/plataformaProyectos.php" 				title="Datos de los Proyectos">		<img src="imagenes/viewtimetables_48.png" 	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Proyectos		</a></li>
					<li><a href="tablaRangos.php" 	 								title="Rangos">						<img src="imagenes/indicadores.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Rango Metas			</a></li>
					<li><a href="calibraciones" 									title="Calibraciones">				<img src="imagenes/calibraciones.png" 		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Calibraciones			</a></li>
					<li><a href="usuarios/plataformaUsuarios.php" 					title="Usuarios">					<img src="imagenes/class_32.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Usuarios				</a></li>
					<li><a href="estadistica" 										title="Estadística">				<img src="imagenes/Mostrar.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Estadísticas			</a></li>
					<li><a href="indicadores" 										title="Indicadores">				<img src="imagenes/indicador.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Indicadores			</a></li>
					<li><a href="http://simet.cl/erp/limpiarDir.php" 				title="Descargar Informes">			<img src="imagenes/icono-descargas.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Descarga Informes		</a></li>
					<li><a href="vales" 											title="Registro de Vales">			<img src="imagenes/carpeta-negra.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Registro de Vales		</a></li>
					<li><a href="http://simet.cl/erp/informes/lecturaInformes.php" 	title="Descarga de Informes">		<img src="imagenes/pdf_download.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Informes Descargados </a></li>
					<li><a href="infoctacte" 										title="Cartola Ctas Corrientes">	<img src="imagenes/ctacte.png" 				style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cartola Cuentas 		</a></li>
					<li><a href="notas" 											title="Notas Informes">				<img src="imagenes/desactivadoPdf.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Notas Informes		</a></li>
					<li><a href="ensayos" 											title="Ensayos">					<img src="imagenes/ensayos.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Ensayos				</a></li>
					<li><a href="setupCotizaciones"									title="Notas Cotizaciones">			<img src="imagenes/desactivadoPdf.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Notas Cotizaciones	</a></li>
					<li><a href="diasFeriados"										title="Días Feriados">				<img src="imagenes/poster_teachers.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Días Feriados			</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/seguridad.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Seguridad
				</div>
				<ul>
					<li><a href="respaldos/backup.php" 		title="Respaldo">			<img src="imagenes/Respaldar.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Respaldo			</a></li>
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Antiguo
				</div>
				<ul>
					<li>
								<a href="encuesta/plataformaEncuesta.php"	title="Módulo Encuesta">			
									<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			
								</a>
					</li>
					<li>
						<?php
							$link=Conectarse();
							$cActividades 	= 0;
							$cVencidas		= 0;
									
							$fechaHoyDia = date('Y-m-d');
							$bdEq=$link->query("SELECT * FROM Visitas Where Estado = 'T'");
							if($rowEq=mysqli_fetch_array($bdEq)){
								do{
									if($rowEq['fechaProxAct'] > '0000-00-00'){
										$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['fechaProxAct']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
									}
								}while ($rowEq=mysqli_fetch_array($bdEq));
							}
						?>
							<a href="visitas/plataformaActividades.php" title="Visitas">
								<img src="imagenes/contactus_128.png"	align="absmiddle" width="22px" height="22px">
								Visitas
								<?php
								if($cActividades > 0){?>
									<img src="imagenes/bola_amarilla.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cActividades; ?></sup>
									</span>
									<?php
								}
								if($cVencidas > 0){?>
									<img src="imagenes/bola_roja.png">
									<span style="font-size:12px; font-weight:700;">
										<sup><?php echo $cVencidas; ?></sup>
									</span>
									<?php
								}
								?>
							</a>
					</li>
					<li><a href="masivos/plataformaMasivos.php"						title="Correos Masivos">			<img src="imagenes/mail_html.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos			</a></li>
				</ul>
			</div>
			<?php
			break;
		case 'Administrativo':
		case 'Secretaria':
		case 'Sub Gerente Técnico':
		case 'Sub Gerente de Desarrollo':
		?>
				<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
					<div id="MenuCuerpoTitulo" class="degradado">
						<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
						Menú <?php echo 'Usr... '.$_SESSION['usr']; ?>
					</div>
					<ul>
						<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
						<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
					</ul>
					<?php
							$link=Conectarse();
							$tAcre = false;
							$u = $_SESSION['usr'];
							$bdm=$link->query("SELECT * FROM modusr where usr = '".trim($_SESSION['usr'])."' and nModulo = 8");
							if($rowm=mysqli_fetch_array($bdm)){
								$tAcre = true;
							}
							if($tAcre == true){
							   //echo $_SESSION['usr'];
								?>
								<div id="MenuCuerpoTitulo" class="degradado">
									<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
									Acreditación
								</div>
								<ul>
									<li><a href="archivo/archivos.php" 					title="Archivos">					<img src="imagenes/open_48.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> Documentación			</a></li>

									<?php
									$cActividades 	= 0;
									$cVencidas		= 0;
									$fechaHoyDia 	= date('Y-m-d');
									
									$bdEq=$link->query("SELECT * FROM accionesCorrectivas");
									if($rowEq=mysqli_fetch_array($bdEq)){
										do{
											if($rowEq['fechaCierre'] == '0000-00-00'){
												if($rowEq['accFechaTen'] > '0000-00-00'){
													$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
													$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
													if($fechaHoyDia >= $rowEq['accFechaTen']){
														$cVencidas++;
													}else{
														if($fechaHoyDia >= $fechaxVencer){
															$cActividades++;
														}
													}
												}
											}
										}while ($rowEq=mysqli_fetch_array($bdEq));
									}
									?>
									<li>
											<a href="correctivas/accionesCorrectivas.php"		title="Correctivas">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
												AC.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
									</li>
									<?php
										$link=Conectarse();
										$cActividades 	= 0;
										$cVencidas		= 0;
										$fechaHoyDia 	= date('Y-m-d');
													
										$bdEq=$link->query("SELECT * FROM accionesPreventivas");
										if($rowEq=mysqli_fetch_array($bdEq)){
											do{
												if($rowEq['fechaCierre'] == '0000-00-00'){
													$cVencidas++;
												}
											}while ($rowEq=mysqli_fetch_array($bdEq));
										}
									?>
									<li>
										<a href="preventivas/accionesPreventivas.php"		title="Preventivas">				<img src="imagenes/accionesCorrectivas.png"  align="absmiddle" width="22px" height="22px"> 
											AP.
											<?php
											if($cActividades > 0){?>
												<img src="imagenes/bola_amarilla.png">
												<span style="font-size:12px; font-weight:700;">
													<sup><?php echo $cActividades; ?></sup>
												</span>
												<?php
											}
											if($cVencidas > 0){?>
												<img src="imagenes/bola_roja.png">
												<span style="font-size:12px; font-weight:700;">
													<sup><?php echo $cVencidas; ?></sup>
												</span>
												<?php
											}
											?>
										</a>
									</li>
									<?php
									$cActividades 	= 0;
									$cVencidas		= 0;
									$fechaHoyDia 	= date('Y-m-d');
									
									$bdEq=$link->query("SELECT * FROM equipos");
									if($rowEq=mysqli_fetch_array($bdEq)){
										do{
											if($rowEq['fechaProxCal']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoCal'].' day' , strtotime ( $rowEq['fechaProxCal'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $rowEq['fechaProxCal']){
													$cVencidas++;
												}else{
													if($fechaHoyDia >= $fechaxVencer){
														$cActividades++;
													}
												}
											}

											if($rowEq['fechaProxMan']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoMan'].' day' , strtotime ( $rowEq['fechaProxMan'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $rowEq['fechaProxMan']){
													$cVencidas++;
												}else{
													if($fechaHoyDia >= $fechaxVencer){
														$cActividades++;
													}
												}
											}

											if($rowEq['fechaProxVer']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoVer'].' day' , strtotime ( $rowEq['fechaProxVer'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $rowEq['fechaProxVer']){
													$cVencidas++;
												}else{
													if($fechaHoyDia >= $fechaxVencer){
														$cActividades++;
													}
												}
											}
										}while ($rowEq=mysqli_fetch_array($bdEq));
									}
									?>
									<ul>
										<!-- <li><a href="equipamiento/plataformaEquipos.php?usrRes=<?php echo $_SESSION['usr']; ?>"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> Equipamiento		</a></li> -->
										<li>
											<a href="equipamiento/plataformaEquipos.php?tpAccion=mantencion"		title="Equipamiento">				
											<img src="imagenes/equipamiento.png" align="absmiddle" width="22px" height="22px">
												Equip.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
										</li>
									</ul>


									<?php
									$cActividades 	= 0;
									$cVencidas		= 0;
									
									$fechaHoyDia = date('Y-m-d');
									$bdEq=$link->query("SELECT * FROM Actividades Where Estado = 'T'");
									if($rowEq=mysqli_fetch_array($bdEq)){
										do{
											if($rowEq['fechaProxAct'] > '0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $rowEq['fechaProxAct']){
													$cVencidas++;
												}else{
													if($fechaHoyDia >= $fechaxVencer){
														$cActividades++;
													}
												}
											}
										}while ($rowEq=mysqli_fetch_array($bdEq));
									}
									?>
									<li>
											<a href="actividades/plataformaActividades.php"		title="Actividades">
											<img src="imagenes/actividades.png"	align="absmiddle" width="22px" height="22px">
												Act.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
									</li>
								</ul>
							<?php
							}else{
								/* Todos los usuarios */
								?>
								<div id="MenuCuerpoTitulo" class="degradado">
									<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
									Acreditación
								</div>
								<?php
								$cActividades 	= 0;
								$cVencidas		= 0;
								$fechaHoyDia 	= date('Y-m-d');
								
								$bdEq=$link->query("SELECT * FROM accionesCorrectivas Where usrResponsable = '".$_SESSION['usr']."'");
								if($rowEq=mysqli_fetch_array($bdEq)){
									do{
										if($rowEq['fechaCierre'] == '0000-00-00'){
											if($rowEq['accFechaTen'] > '0000-00-00'){
												$fechaxVencer 	= strtotime ( '-1 day' , strtotime ( $rowEq['accFechaTen'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $rowEq['accFechaTen']){
													$cVencidas++;
												}else{
													if($fechaHoyDia >= $fechaxVencer){
														$cActividades++;
													}
												}
											}
										}
									}while ($rowEq=mysqli_fetch_array($bdEq));
								}

								if($cActividades > 0 or $cVencidas > 0){
									?>
									<ul>
										<!-- <li><a href="equipamiento/plataformaEquipos.php?usrRes=<?php echo $_SESSION['usr']; ?>"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> Equipamiento		</a></li> -->
										<li>
											<a href="equipamiento/plataformaEquipos.php?tpAccion=Seguimiento"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> 
												AC.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
										</li>
									</ul>
									<?php
								}

								$cActividades 	= 0;
								$cVencidas		= 0;
								$fechaHoyDia 	= date('Y-m-d');
								
								$bdEq=$link->query("SELECT * FROM equipos Where usrResponsable = '".$_SESSION['usr']."'");
								if($rowEq=mysqli_fetch_array($bdEq)){
									do{
										if($rowEq['fechaProxCal']>'0000-00-00'){
											$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoCal'].' day' , strtotime ( $rowEq['fechaProxCal'] ) );
											$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
											if($fechaHoyDia >= $rowEq['fechaProxCal']){
												$cVencidas++;
											}else{
												if($fechaHoyDia >= $fechaxVencer){
													$cActividades++;
												}
											}
										}

										if($rowEq['fechaProxMan']>'0000-00-00'){
											$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoMan'].' day' , strtotime ( $rowEq['fechaProxMan'] ) );
											$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
											if($fechaHoyDia >= $rowEq['fechaProxMan']){
												$cVencidas++;
											}else{
												if($fechaHoyDia >= $fechaxVencer){
													$cActividades++;
												}
											}
										}

										if($rowEq['fechaProxVer']>'0000-00-00'){
											$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoVer'].' day' , strtotime ( $rowEq['fechaProxVer'] ) );
											$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
											if($fechaHoyDia >= $rowEq['fechaProxVer']){
												$cVencidas++;
											}else{
												if($fechaHoyDia >= $fechaxVencer){
													$cActividades++;
												}
											}
										}
									}while ($rowEq=mysqli_fetch_array($bdEq));
								}

								if($cActividades > 0 or $cVencidas > 0){
									?>
									<ul>
										<!-- <li><a href="equipamiento/plataformaEquipos.php?usrRes=<?php echo $_SESSION['usr']; ?>"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> Equipamiento		</a></li> -->
										<li>
											<a href="equipamiento/plataformaEquipos.php?tpAccion=Seguimiento"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> 
												Equip.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
										</li>
									</ul>
									<?php
								}

								$cActividades 	= 0;
								$cVencidas		= 0;
								
								$fechaHoyDia = date('Y-m-d');
								$bdEq=$link->query("SELECT * FROM Actividades Where usrResponsable = '".$_SESSION['usr']."'");
								if($rowEq=mysqli_fetch_array($bdEq)){
									do{
										$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
										$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
										if($fechaHoyDia >= $rowEq['fechaProxAct']){
											$cVencidas++;
										}else{
											if($fechaHoyDia >= $fechaxVencer){
												$cActividades++;
											}
										}
										/* Arreglar */
										if($fechaHoyDia >= $rowEq['prgActividad']){
											$cVencidas++;
											$cActividades++;
										}
									}while ($rowEq=mysqli_fetch_array($bdEq));
									

								}
								
								if($cActividades > 0 or $cVencidas > 0){
									?>
									<ul>
										<!-- <li><a href="equipamiento/plataformaEquipos.php?usrRes=<?php echo $_SESSION['usr']; ?>"		title="Equipamiento">				<img src="imagenes/marker_2.gif"			style="margin:2px;" align="absmiddle"							> Equipamiento		</a></li> -->
										<li>
											<a href="actividades/plataformaActividades.php?tpAccion=Seguimiento"		title="Actividades">				<img src="imagenes/actividades.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> 
												Act.
												<?php
												if($cActividades > 0){?>
													<img src="imagenes/bola_amarilla.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cActividades; ?></sup>
													</span>
													<?php
												}
												if($cVencidas > 0){?>
													<img src="imagenes/bola_roja.png">
													<span style="font-size:12px; font-weight:700;">
														<sup><?php echo $cVencidas; ?></sup>
													</span>
													<?php
												}
												?>
											</a>
										</li>
									</ul>
									<?php
								}

							}
							$link->close();
					?>


					<?php
						$tMod = array(
										1 => 'clientes/clientes.php', 
										2 => 'registroMat/recepcionMuestras.php',
										3 => 'cotizaciones/plataformaCotizaciones.php',
										4 => 'generarinformes/plataformaGenInf.php',
										5 => 'informes/plataformaInformes.php',
										6 => 'gastos/plataformaintranet.php',
										7 => 'personal/sueldos.php',
										8 => 'facturacion/plataformaFacturas.php',
										9 => 'historico/plataformaHistorica.php',
										10 => 'masivos/plataformaMasivos.php',
										11 => 'cobranza/plataformaFacturas.php',
									);

						$tApl = array(
										1 => '<a href="clientes/clientes.php" 		 											title="Mantención de Clientes">				<img src="imagenes/send_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes				</a>', 
										2 => '<a href="registroMat/recepcionMuestras.php" 										title="Registro de Muestras">				<img src="imagenes/machineoperator_128.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM					</a>',
										3 => '<a href="cotizaciones/plataformaCotizaciones.php?usrFiltro='.$_SESSION['usr'].'" 	title="Módulo de Cotizaciones">				<img src="imagenes/other_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos				</a>',
										4 => '<a href="generarinformes/plataformaGenInf.php" 									title="Módulo de Generación de Informes">	<img src="imagenes/Tablas.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Generar Informes		</a>',
										5 => '<a href="informes/plataformaInformes.php" 										title="Módulo de Informes">					<img src="imagenes/informeUP.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes				</a>',
										6 => '<a href="gastos/plataformaintranet.php" 											title="Módulo de Gastos">					<img src="imagenes/group_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos				</a>',
										7 => '<a href="personal/sueldos.php" 													title="Módulo de Sueldos">					<img src="imagenes/subst_student.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos				</a>',
										8 => '<a href="facturacion/plataformaFacturas.php"										title="Módulo de Facturación">				<img src="imagenes/crear_certificado.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación			</a>',
										9 => '<a href="historico/plataformaHistorica.php"										title="Módulo Historico">					<img src="imagenes/summary_leassons.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico				</a>',
										10 => '<a href="masivos/plataformaMasivos.php"											title="Correos Masivos">					<img src="imagenes/mail_html.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos			</a>',
										11 => '<a href="cobranza/plataformaFacturas.php"										title="Módulo de Cobranza">					<img src="imagenes/gastos.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Cobranza				</a>'
									);
									
					$link=Conectarse();
					$bdMods=$link->query("SELECT * FROM ModUsr Where usr = '".$_SESSION['usr']."'");
					if($rowMods=mysqli_fetch_array($bdMods)){
						?>
						<div id="MenuCuerpoTitulo" class="degradado">
							<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
							Módulos
						</div>
						<ul>
							<li><a href="precam/preCAM.php" 		 						title="Pre Cotización">				
								<img src="imagenes/newPdf.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> 
								PRECAM 
								</a>
								<img src="imagenes/bola_amarilla.png">
								<span style="font-size:12px; font-weight:700;">
									<sup><?php echo $nPreCam; ?></sup>
								</span>
							</li>
						
							<?php
								for($i=1; $i<=11; $i++){
									if($i != 10){
										$bdMod=$link->query("SELECT * FROM Modulos Where dirProg = '".$tMod[$i]."'");
										if($rowMod=mysqli_fetch_array($bdMod)){
											$bdMods=$link->query("SELECT * FROM ModUsr Where usr = '".$_SESSION['usr']."' and nModulo = '".$rowMod['nModulo']."'");
											if($rowMods=mysqli_fetch_array($bdMods)){
													echo '<li>'.$tApl[$i].'</li>';
											}
										}
									}
								
								}
							//<li><a href="informes/plataformaInformes.php" 					title="M�dulo de Informes">			<img src="imagenes/informeUP.png"					style="margin:2px;" align="absmiddle" width="32px" height="32px"> <strong>Informes 2.0</strong>		</a></li>
							?>

							<?php
								$link=Conectarse();
								$cActividades 	= 0;
								$cVencidas		= 0;
										
								$fechaHoyDia = date('Y-m-d');
								$bdEq=$link->query("SELECT * FROM Visitas Where Estado = 'T'");
								if($rowEq=mysqli_fetch_array($bdEq)){
									do{
										if($rowEq['fechaProxAct'] > '0000-00-00'){
											$fechaxVencer 	= strtotime ( '-'.$rowEq['tpoAvisoAct'].' day' , strtotime ( $rowEq['fechaProxAct'] ) );
											$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
											if($fechaHoyDia >= $rowEq['fechaProxAct']){
												$cVencidas++;
											}else{
												if($fechaHoyDia >= $fechaxVencer){
													$cActividades++;
												}
											}
										}
									}while ($rowEq=mysqli_fetch_array($bdEq));
								}
							?>
							<?php if($_SESSION['usr'] == 'CMS'){ ?>
								<li><a href="infoctacte/movctas/index.php?nCuenta=76884210|BCI&MesFiltro=<?php echo date('m'); ?>" 	title="RedBank">	<img src="imagenes/ctacte.png" 			style="margin:2px;" align="absmiddle" width="20px" height="20px"> RedBank 		</a></li>
							<?php } ?>
							<?php if($_SESSION['usr'] == 'ACA' or $_SESSION['usr'] == 'AVR' or $_SESSION['usr'] == 'Adm'){ ?>
								<li><a href="infofinanzas"										title="Informe Financiero">			<img src="imagenes/estadoFinanciero.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informe Financiero	</a></li>
							<?php } ?>

							<li><a href="infoTv.php"										title="Módulo Programación">		<img src="imagenes/Preguntas.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pantalla		</a></li>
							<li><a href="pegasTv.php"										title="Módulo Pegas">				<img src="imagenes/inventarioMuestras.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Programación				</a></li>
							<li><a href="usrtv.php"											title="Módulo Pizarra">				<img src="imagenes/seguimiento.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Pizarra			</a></li>
							<?php if($_SESSION['usr'] == 'AVR' or $_SESSION['usr'] == 'Adm'){ ?>
							<li><a href="masivos/plataformaMasivos.php"						title="Correos Masivos">			<img src="imagenes/mail_html.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos			</a></li>
							<?php } ?>
							
						</ul>
						<?php 
					}
					$link->close();
					?>
					
					<?php if($_SESSION['usr'] == 'AVR' or $_SESSION['usr'] == 'DPG' or $_SESSION['usr'] == 'CMS'){ ?>
						<div id="MenuCuerpoTitulo" class="degradado">
							<img src="imagenes/talleres.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
							Talleres
						</div>
						<ul>
							<li><a href="tallerPM/pTallerPM.php"								title="Taller Ensayos Mecánicos">	<img src="imagenes/ensayos.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Ensayos Mecánicos	</a></li>
						</ul>
					<?php } ?>
					<?php if($_SESSION['usr'] == 'MCV'){ ?>
						<div id="MenuCuerpoTitulo" class="degradado">
							<img src="imagenes/talleres.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
							Talleres
						</div>
						<ul>
							<li><a href="tallerPM/pTallerPM.php"								title="Taller Ensayos Mecánicos">	<img src="imagenes/ensayos.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Ensayos Mecánicos	</a></li>
						</ul>
					<?php } ?>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Antiguo
				</div>
				<ul>
					<?php if($tAcre==true){?>
							<li><a href="encuesta/plataformaEncuesta.php"		title="Módulo Encuesta">			<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			</a></li>
					<?php } ?>
							<li>
								<a href="visitas/plataformaActividades.php"		title="Visitas">
									<img src="imagenes/contactus_128.png"	align="absmiddle" width="22px" height="22px">
									Visitas
									<?php
									if($cActividades > 0){?>
										<img src="imagenes/bola_amarilla.png">
										<span style="font-size:12px; font-weight:700;">
											<sup><?php echo $cActividades; ?></sup>
										</span>
										<?php
									}
									if($cVencidas > 0){?>
										<img src="imagenes/bola_roja.png">
										<span style="font-size:12px; font-weight:700;">
											<sup><?php echo $cVencidas; ?></sup>
										</span>
										<?php
									}
									?>
								</a>
							</li>
							<?php
							/*
										$i = 10;
										$bdMod=$link->query("SELECT * FROM Modulos Where dirProg = '".$tMod[$i]."'");
										if($rowMod=mysqli_fetch_array($bdMod)){
											$bdMods=$link->query("SELECT * FROM ModUsr Where usr = '".$_SESSION['usr']."' and nModulo = '".$rowMod['nModulo']."'");
											if($rowMods=mysqli_fetch_array($bdMods)){
													echo '<li>'.$tApl[$i].'</li>';
											}
										}
							*/		
							?>
				</ul>
					
				</div>
				<?php
			break;

		case 'Editor':
				?>
				<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
					<div id="MenuCuerpoTitulo" class="degradado">
						<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
						Menú <?php echo 'Usr... '.$_SESSION['IdPerfil']; ?>
					</div>
					<ul>
						<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
						<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
					</ul>
				</div>
				<?php
			break;
				
}
?>