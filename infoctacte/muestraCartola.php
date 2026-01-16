<?php 
	$Proceso = '';
	
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

	$fechaHoy 	= date('Y-m-d');
	$fd 		= explode('-', $fechaHoy);
	$MesFiltro  = $fd[1];
	$Agno     	= $fd[0];
	
	$nCuenta 		= '';
	$nOrden	 		= '';
	$fCta	 		= '';
	$nombreTitular 	= '';

	if(isset($_GET['nCuenta']))  	{ $nCuenta  = $_GET['nCuenta']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	if(isset($_GET['MesFiltro'])) { 
		$MesFiltro = $MesNum[$MesFiltro];
	}

	if(isset($_POST['nCuenta'])) 	{ $nCuenta   = $_POST['nCuenta']; 	}
	if(isset($_POST['MesFiltro'])) 	{ $MesFiltro = $_POST['MesFiltro']; }
	if(isset($_POST['Agno'])) 		{ $Agno 	 = $_POST['Agno']; 		}

	$Proyecto 	= "Proyectos";
	$Situacion 	= "Estado";
	$AgnoAct	= date('Y');
	
	if($nCuenta){
		$fCta = explode('|',$nCuenta);
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM ctasctescargo Where nCuenta Like '".$fCta[0]."%'");
		if ($rowP=mysqli_fetch_array($bdPer)){
			$nombreTitular = $rowP['nombreTitular'];
		}
		$link->close();
	}
?>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<?php if($nCuenta){?>
					<div id="ImagenBarraLeft">
						<a href="formularios/estadoCuenta.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesFiltro; ?>&Agno=<?php echo $Agno; ?>" title="Estado de Cuenta">
							<img src="../imagenes/newPdf.png"><br>
						</a>
						Cartola 
					</div>
					<div id="ImagenBarraLeft" style="text-align:center;">
						<a href="movctas?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesFiltro; ?>&Agno=<?php echo $Agno; ?>" title="Estado de Cuenta">
							<img src="../imagenes/ctacte.png"><br>
						</a>
						Movimientos 
					</div>
				<?php } ?>
			</div>
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
					<form name="form" action="index.php" method="get" style="display:inline; ">

						<!-- Fitra por Fecha -->
	  					<select name='MesFiltro' id='MesFiltro'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$Mes[intval($MesFiltro)]){
										echo '		<option selected 	value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
									}else{
										if($Agno == date('Y')){
											if($i > strval($fd[1])){
												echo '	<option style="opacity:.5; color:#ccc;" value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
											}else{
												echo '	<option 								value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
											}
										}else{
											echo '	<option 									value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
						<!-- Fin Filtro -->

						<!-- Fitra por Año -->
	  					<select name='Agno' id='Agno'>
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

						Cuenta Corriente
<!--						<input name="nCuenta" align="right" maxlength="50" size="50" list="ctas" value="<?php echo $nCuenta;?>" title="Ingrese Cuenta Corriente..." required autofocus placeholder="Cuenta Corriente..." /> -->
						<input name="nCuenta" align="right" maxlength="50" size="50" list="ctas" title="Ingrese Cuenta Corriente..." required autofocus placeholder="Seleccione Cuenta Corriente..." />
							<datalist id="ctas">
								<?php
									$link=Conectarse();
									$bdProv=$link->query("SELECT * FROM ctasctescargo");
									if($row=mysqli_fetch_array($bdProv)){
										do{?>
											<option value="<?php echo $row['nCuenta'].' | '.$row['Banco']; ?>">
											<?php
										}while ($row=mysqli_fetch_array($bdProv));
									}
								?>
							</datalist>
						<button name="Buscar">
							<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
						</button>
					</form>
					
			</div>
			
			<?php
			if($nCuenta){
				include_once('desplegarInforme.php');
			}
			?>
			