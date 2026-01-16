<?php

	$Estado = array(
					1 => 'Todos', 
					2 => 'Pendientes',
					3 => 'Terminados',
					4 => 'Sin Informe'
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
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	$Situacion 	= "Estado";
	$CodInforme = '';
	//$MesFiltro  = "Mes";
	$Agno     	= date('Y');
	
	$MesFiltro = $Mes[intval($fd[1])];
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_GET['CodInforme']))  { $CodInforme= $_GET['CodInforme']; }
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaInformes.php" title="Informes">
						<img src="../imagenes/pdf.png"></a>
					<br>
					Informes
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<!-- <a href="mInforme.php" title="Nuevo Informe" onClick="registraEncuesta(0, 'Agrega')"> -->
					<a href="mInforme.php?accion=Agregar&CodInforme=" title="Nuevo Informe">
						<img src="../imagenes/newPdf.png"></a>
					<br>
					Cód.QR
				</div>
			</div>


			<div id="BarraFiltro" style="padding-bottom:5px; ">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<!-- Fitra por Proyecto -->
						<select name="Proyecto" id="Proyecto" onchange="realizaProceso($('#CodInforme').val(),$('#dBuscar').val(), $('#Proyecto').val(), $('#Estado').val(), $('#MesFiltro').val(), $('#Agno').val())">
							<?php 
								$link=Conectarse();
								$bdPr=$link->query("SELECT * FROM Proyectos");
								if ($row=mysqli_fetch_array($bdPr)){
									do{
										if($Proyecto == $row['IdProyecto']){
											echo "	<option selected 	value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
										}else{
											echo "	<option  			value='".$row['IdProyecto']."'>".$row['IdProyecto']."</option>";
										}
									}while ($row=mysqli_fetch_array($bdPr));
								}
								$link->close();
							?>
						</select>

					<!-- Fitra por Fecha -->
	  					<select name='MesFiltro' id='MesFiltro' onchange="realizaProceso($('#CodInforme').val(),$('#dBuscar').val(), $('#Proyecto').val(), $('#Estado').val(), $('#MesFiltro').val(), $('#Agno').val())">
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$MesFiltro){
										echo '		<option selected 									value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
									}else{
										if($i > strval($fd[1])){
											//echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
											echo '	<option   			value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
										}else{
											echo '	<option 											value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->

					<!-- Fitra por A�o -->
	  					<select name='Agno' id='Agno' onchange="realizaProceso($('#CodInforme').val(),$('#dBuscar').val(), $('#Proyecto').val(), $('#Estado').val(), $('#MesFiltro').val(), $('#Agno').val())">
							<?php
								$AgnoAct = date('Y');
								for($a=2013; $a<=$AgnoAct; $a++){
									if($a == $Agno){
										echo "<option selected 	value='".$a."'>".$a."</option>";
									}else{
										echo "<option  			value='".$a."'>".$a."</option>";
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->

					<!-- Fitra Estado -->
	  					<select name='Estado' id='Estado' onchange="realizaProceso($('#CodInforme').val(),$('#dBuscar').val(), $('#Proyecto').val(), $('#Estado').val(), $('#MesFiltro').val(), $('#Agno').val())">
							<?php
								for($i=1; $i <=4 ; $i++){
									if($Estado[$i]==$Situacion){
										echo '<option selected  value="'.$Estado[$i].'">'.$Estado[$i].'</option>';
									}else{
										echo '<option   		value="'.$Estado[$i].'">'.$Estado[$i].'</option>';
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->
						Rut Cliente a buscar
						<!-- <input name="dBuscado" id="dBuscar" onKeyUp="realizaProceso($('#dBuscar').val())" align="right" maxlength="20" size="20" title="Ingrese RUT del Cliente a buscar..."> -->
						<input name="dBuscado" id="dBuscar" align="right" maxlength="40" size="40" placeholder="Buscar por nombre Cliente o RUT" title="Ingrese RUT del Cliente a buscar...">
						AM
						<?php
							$cInf = explode('-',$CodInforme);
							if($cInf[0] == 'AM'){ 
								$CodInforme = $cInf[1]; 
							}
						?>
						<input name="CodInforme" id="CodInforme" align="right" maxlength="10" size="10" placeholder="0000-0000" title="N° Informe..." value="<?php echo $CodInforme; ?>">
						<button name="Buscar" onClick="realizaProceso($('#CodInforme').val(),$('#dBuscar').val(), $('#Proyecto').val(), $('#Estado').val(), $('#MesFiltro').val(), $('#Agno').val())">
							<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
						</button>
					
			</div>

			<?php
			if($dBuscado==''){?>
				<script>
					var CodInforme = '<?php echo $CodInforme; ?>';
					var dBuscar = '';
					realizaProceso(CodInforme, dBuscar);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoSubir"></span>
