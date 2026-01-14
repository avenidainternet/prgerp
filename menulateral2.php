<?php
	switch ($_SESSION[Perfil]) {
		case 'Super Usuario':
		?>
			<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Menú
				</div>
				<ul>
					<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
					<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Módulos
				</div>
				<ul>
					<li><a href="clientes/clientes.php" 		 					title="Mantención de Clientes">		<img src="imagenes/send_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes			</a></li>
					<li><a href="registroMat/recepcionMuestras.php" 				title="Registro de Muestras">		<img src="imagenes/machineoperator_128.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM				</a></li>
					<li><a href="cotizaciones/plataformaCotizaciones.php" 			title="Módulo de Procesos">			<img src="imagenes/other_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos			</a></li>
					<li><a href="informes/plataformaInformes.php" 					title="Módulo de Informes">			<img src="imagenes/informeUP.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes 			</a></li>
					<li><a href="gastos/plataformaintranet.php" 					title="Módulo de Gastos">			<img src="imagenes/group_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos			</a></li>
					<li><a href="personal/sueldos.php" 								title="Módulo de Sueldos">			<img src="imagenes/subst_student.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos			</a></li>
					<li><a href="facturacion/plataformaFacturas.php"				title="Módulo de Facturación">		<img src="imagenes/crear_certificado.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación		</a></li>
					<li><a href="historico/plataformaHistorica.php"					title="Módulo Historico">			<img src="imagenes/summary_leassons.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico			</a></li>
					<li><a href="masivos/plataformaMasivos.php"						title="Correos Masivos">			<img src="imagenes/mail_html.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos		</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Acreditación
				</div>
				<ul>
					<li><a href="encuesta/plataformaEncuesta.php"			title="Módulo Encuesta">			<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			</a></li>
					<li><a href="correctivas/accionesCorrectivas.php"		title="Acciones Correctivas">		<img src="imagenes/accionesCorrectivas.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Acc. Correctivas	</a></li>
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/settings_32.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Configuraciones
				</div>
				<ul>
					<li><a href="datosEmpresa.php" 	 				title="Datos de la Institución">	<img src="imagenes/of.png" 				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Institución</a>	</li>
					<li><a href="tablaRangos.php" 	 				title="Rangos">						<img src="imagenes/indicadores.png" 	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Rango Metas		</a></li>
					<li><a href="usuarios/plataformaUsuarios.php" 	title="Usuarios">					<img src="imagenes/class_32.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Usuarios			</a></li>
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
					<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
					<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Módulos
				</div>
				<ul>
					<li><a href="clientes/clientes.php" 		 					title="Mantención de Clientes">		<img src="imagenes/send_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes				</a></li>
					<li><a href="registroMat/recepcionMuestras.php" 				title="Registro de Muestras">		<img src="imagenes/machineoperator_128.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> RAM				</a></li>
					<li><a href="cotizaciones/plataformaCotizaciones.php" 			title="Módulo de Procesos">			<img src="imagenes/other_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos				</a></li>
					<li><a href="informes/plataformaInformes.php" 					title="Módulo de Informes">			<img src="imagenes/pdf.png"					style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes 				</a></li>
					<li><a href="gastos/plataformaintranet.php" 					title="Módulo de Gastos">			<img src="imagenes/group_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos				</a></li>
					<li><a href="personal/sueldos.php" 								title="Módulo de Sueldos">			<img src="imagenes/subst_student.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos				</a></li>
					<li><a href="facturacion/plataformaFacturas.php"				title="Módulo de Facturación">		<img src="imagenes/crear_certificado.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación			</a></li>
					<li><a href="historico/plataformaHistorica.php"					title="Módulo Historico">			<img src="imagenes/summary_leassons.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico				</a></li>
					<li><a href="masivos/plataformaMasivos.php"						title="Correos Masivos">			<img src="imagenes/mail_html.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos			</a></li>
				</ul>

				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Acreditación
				</div>
				<ul>
					<li><a href="encuesta/plataformaEncuesta.php"			title="Módulo Encuesta">			<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			</a></li>
					<li><a href="correctivas/accionesCorrectivas.php"		title="Acciones Correctivas">		<img src="imagenes/accionesCorrectivas.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Acc. Correctivas	</a></li>
				</ul>
				<div id="MenuCuerpoTitulo" class="degradado">
					<img src="imagenes/settings_32.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
					Configuraciones
				</div>
				<ul>
					<li><a href="datosEmpresa.php" 	 				title="Datos de la Institución">	<img src="imagenes/of.png" 				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Datos Institución</a>	</li>
					<li><a href="tablaRangos.php" 	 				title="Rangos">						<img src="imagenes/indicadores.png" 	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Rango Metas		</a></li>
					<li><a href="usuarios/plataformaUsuarios.php" 	title="Usuarios">					<img src="imagenes/class_32.png" 		style="margin:2px;" align="absmiddle" width="20px" height="20px"> Usuarios			</a></li>
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
						Menú <?php echo 'Usr... '.$_SESSION[usr]; ?>
					</div>
					<ul>
						<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
						<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
					</ul>
					<?php
						$tMod = array(
										1 => 'clientes/clientes.php', 
										2 => 'cotizaciones/plataformaCotizaciones.php',
										3 => 'informes/plataformaInformes.php',
										4 => 'gastos/plataformaintranet.php',
										5 => 'personal/sueldos.php',
										6 => 'facturacion/plataformaFacturas.php',
										7 => 'historico/plataformaHistorica.php',
										8 => 'masivos/plataformaMasivos.php'
									);

						$tApl = array(
										1 => '<a href="clientes/clientes.php" 		 											title="Mantención de Clientes">			<img src="imagenes/send_48.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Clientes				</a>', 
										2 => '<a href="cotizaciones/plataformaCotizaciones.php?usrFiltro='.$_SESSION[usr].'" 	title="Módulo de Cotizaciones">			<img src="imagenes/other_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Procesos				</a>',
										3 => '<a href="informes/plataformaInformes.php" 										title="Módulo de Informes">				<img src="imagenes/informeUP.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Informes				</a>',
										4 => '<a href="gastos/plataformaintranet.php" 											title="Módulo de Gastos">				<img src="imagenes/group_48.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Gastos				</a>',
										5 => '<a href="personal/sueldos.php" 													title="Módulo de Sueldos">				<img src="imagenes/subst_student.png"		style="margin:2px;" align="absmiddle" width="22px" height="22px"> Sueldos				</a>',
										6 => '<a href="facturacion/plataformaFacturas.php"										title="Módulo de Facturación">			<img src="imagenes/crear_certificado.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Facturación			</a>',
										7 => '<a href="historico/plataformaHistorica.php"										title="Módulo Historico">				<img src="imagenes/summary_leassons.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Historico				</a>',
										8 => '<a href="masivos/plataformaMasivos.php"											title="Correos Masivos">				<img src="imagenes/mail_html.png"			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Mail Masivos			</a>'
									);
									
					$link=Conectarse();
					$bdMods=mysql_query("SELECT * FROM ModUsr Where usr = '".$_SESSION[usr]."'");
					if($rowMods=mysql_fetch_array($bdMods)){
						?>
						<div id="MenuCuerpoTitulo" class="degradado">
							<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
							Módulos
						</div>
						<ul>
							<?php
								for($i=1; $i<=8; $i++){
								
									$bdMod=mysql_query("SELECT * FROM Modulos Where dirProg = '".$tMod[$i]."'");
									if($rowMod=mysql_fetch_array($bdMod)){
										$bdMods=mysql_query("SELECT * FROM ModUsr Where usr = '".$_SESSION[usr]."' and nModulo = '".$rowMod[nModulo]."'");
										if($rowMods=mysql_fetch_array($bdMods)){
												echo '<li>'.$tApl[$i].'</li>';
										}
									}
								
								}
							//<li><a href="informes/plataformaInformes.php" 					title="Módulo de Informes">			<img src="imagenes/informeUP.png"					style="margin:2px;" align="absmiddle" width="32px" height="32px"> <strong>Informes 2.0</strong>		</a></li>
							?>
						</ul>
						<?php 
							$tAcre = false;
							$bdMods=mysql_query("SELECT * FROM ModUsr Where usr = '".$_SESSION[usr]."'");
							if($rowMods=mysql_fetch_array($bdMods)){
								do{
									if($rowMods[nModulo]==8)	{ $tAcre = true; }
									if($rowMods[nModulo]==12)	{ $tAcre = true; }
								}while ($rowMods=mysql_fetch_array($bdMods));
							}
						
							if($tAcre==true){?>
							<div id="MenuCuerpoTitulo" class="degradado">
								<img src="imagenes/acreditacion.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
								Acreditación
							</div>
							<ul>
								<li><a href="encuesta/plataformaEncuesta.php"			title="Módulo Encuesta">			<img src="imagenes/todo.png"				style="margin:2px;" align="absmiddle" width="22px" height="22px"> Encuesta			</a></li>
								<li><a href="correctivas/accionesCorrectivas.php"		title="Acciones Correctivas">		<img src="imagenes/accionesCorrectivas.png"	style="margin:2px;" align="absmiddle" width="22px" height="22px"> Acc. Correctivas	</a></li>
							</ul>
							<?php
						}
					}
					mysql_close($link);
					?>
				</div>
				<?php
			break;

		case 'Editor':
				?>
				<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
					<div id="MenuCuerpoTitulo" class="degradado">
						<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
						Menú <?php echo 'Usr... '.$_SESSION[IdPerfil]; ?>
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