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

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaCotizaciones.php" title="Cotizaciones">
						<img src="../imagenes/other_48.png"><br>
					</a>
					Proceso
				</div>
				<div id="ImagenBarraLeft" title="Ir a Muestras...">
					<a href="../registroMat/recepcionMuestras.php" title="Ir a Registrar Muestras...">
						<img src="../imagenes/inventarioMuestras.png"></a><br>
					<span>Muestras</span>
				</div>
				<div id="ImagenBarraLeft" title="Servicios">
					<a href="Servicios.php" title="Servicios">
						<img src="../imagenes/Taller.png"></a><br>
					<span>Servicios</span>
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="#" title="Crear Cotización" onClick="registraEncuesta(0, 0, 0, 'Agrega')">
						<img src="../imagenes/cotizacion.png"></a><br>
					<span>+Cot.</span>
				</div>

				<div id="ImagenBarraLeft" title="Descarga Ensayos en PROCESOS PAM" style="text-align:center;">
					<a href="exportarCotizaciones2.php"><img src="../gastos/imagenes/excel_icon.png"></a><br>
					<span>PAM</span>
				</div>
						
				<?php if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or substr($_SESSION['IdPerfil'],0,1) == 0){?>
						<div id="ImagenBarraLeft" title="Descargar AM...">
							<a href="exportarAM.php"><img src="../imagenes/AM.png"></a><br>
							<span>AM</span>
						</div>
						<div id="ImagenBarraLeft" title="Descarga Cotizaciones Premium">
							<a href="formularios/iPremium.php"><img src="../imagenes/icono-descargas.png"></a><br>
							<span>Premium</span>
						</div>
				<?php } ?>
				<div id="ImagenBarraLeft" title="PreCAM" style="text-align:center;">
					<a href="../precam/preCAM.php"><img src="../imagenes/consulta.png"></a><br>
					<span>PRECAM</span>
				</div>
			</div>
			<div id="barraCAM">
				<?php
					$link=Conectarse();
					$bdUsr=$link->query("Select * From Usuarios");
					if($rowUsr=mysqli_fetch_array($bdUsr)){
						do{
							// if($rowUsr[nPerfil]  == 1 or substr($rowUsr[nPerfil],0,1)  == '01' or substr($rowUsr[nPerfil],0,1)  == '02'){
							if($rowUsr['nPerfil'] != 'WM' and intval($rowUsr['nPerfil']) != 0 and $rowUsr['nPerfil'] != 3 and $rowUsr['nPerfil'] != 4){
								echo '<a href="plataformaCotizaciones.php?usrFiltro='.$rowUsr['usr'].'" title="'.$rowUsr['usuario'].'">'.$rowUsr['usr'].'</a>';
							}
						}while($rowUsr=mysqli_fetch_array($bdUsr));
					}
					$link->close();
					echo '<a href="plataformaCotizaciones.php?usrFiltro=Baja" 		title="Dadas de Baja">De Baja</a>';
					echo '<a href="plataformaCotizaciones.php?usrFiltro=" 			title="Todos">Todos</a>';
					echo '<a href="historial.php?usrFiltro=Historial" 				title="Historial">Historial</a>';
				?>
				<?php
					$tabCli = array();
					$link=Conectarse();
					$bdCot=$link->query("Select * From Cotizaciones Where Archivo != 'on' ");
					if($rowCot=mysqli_fetch_array($bdCot)){
						do{
							$bdCli=$link->query("Select * From Clientes Where Estado != 'off' and RutCli = '".$rowCot['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								
								// in_array = Buscar una valor en una array()
								
								if(in_array($rowCli['Cliente'],$tabCli)){
								}else{
									$tabCli[]= $rowCli['Cliente'];
								}
							}
						}while($rowCot=mysqli_fetch_array($bdCot));
					}
					$link->close();
					asort($tabCli);
				?>
				<div style="clear:both;"></div>
				<div style="margin-top:11px; border-top:1px solid #000;">
				<select name="empFiltro" onChange="window.location = this.options[this.selectedIndex].value; return true;">
					<option value="plataformaCotizaciones.php?empFiltro="></option>
					<?php
					foreach ($tabCli as $valor){ 
						if($valor == $_SESSION['empFiltro']){
							echo '<option selected value="plataformaCotizaciones.php?empFiltro='.$valor.'">'.$valor.'</option>';
						}else{
							echo '<option value="plataformaCotizaciones.php?empFiltro='.$valor.'">'.$valor.'</option>';
						}
					}
					?>
				</select>
				</div>
			</div>
			<span id="resultadoRegistro"></span>
