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
	$accion			= '';

	if(isset($_GET['nCuenta']))  	{ $nCuenta  	= $_GET['nCuenta']; 		}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro 	= $_GET['MesFiltro']; 		}
	if(isset($_GET['Agno'])) 		{ $Agno 	 	= $_GET['Agno']; 		}
	if(isset($_GET['nTransaccion'])){ $nTransaccion = $_GET['nTransaccion'];}
	if(isset($_GET['accion'])) 		{ $accion 	 	= $_GET['accion']; 		}

	if(isset($_GET['MesFiltro'])) {
		if($MesFiltro > 0){
			//$MesFiltro = $Mes[intval($MesFiltro)];
		}
	}
	
	if(isset($_POST['nCuenta'])) 	 { $nCuenta   	 = $_POST['nCuenta']; 		}
	if(isset($_POST['MesFiltro'])) 	 { $MesFiltro 	 = $_POST['MesFiltro']; 	}
	if(isset($_POST['Agno'])) 		 { $Agno 	 	 = $_POST['Agno']; 			}
	if(isset($_POST['nTransaccion'])){ $nTransaccion = $_POST['nTransaccion'];	}
	if(isset($_POST['accion'])) 	 { $accion 	 	 = $_POST['accion']; 		}
	if(isset($_POST['MesFiltro'])) {
		if($MesFiltro > 0){
			$MesFiltro = $Mes[intval($MesFiltro)];
		}
	}

	$Proyecto 	= "Proyectos";
	$Situacion 	= "Estado";
	$AgnoAct	= date('Y');
	
	if(isset($_GET['nCuenta'])){
		$fCta = explode('|',$_GET['nCuenta']);
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM ctasctescargo Where nCuenta Like '".$fCta[0]."%'");
		if ($rowP=mysqli_fetch_array($bdPer)){
			$nombreTitular = $rowP['nombreTitular'];
		}
		$link->close();
	}
?>
		<form name="form" action="index.php" method="get" style="display:inline; ">
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../../plataformaErp.php" title="Menú Principal">
						<img src="../../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<?php if($nCuenta){?>
					<?php if($_SESSION['usr'] == 'Alfredo.Artigas' or $_SESSION['usr'] == '10074437'){ ?>
						<div id="ImagenBarraLeft">
							<a href="../index.php?MesFiltro=<?php echo $MesFiltro; ?>&Agno=<?php echo $Agno; ?>&nCuenta=<?php echo $nCuenta; ?>&Buscar=" title="Estado de Cuenta">
								<img src="../../imagenes/ctacte.png"><br>
							</a>
							Cartola 
						</div>
					<?php } ?>
					
					<?php if($accion == ''){?>
						<div id="ImagenBarraLeft" style="text-align:center;">
							<a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>" title="Registro de Cargos">
								<img src="../../imagenes/gastos.png"><br>
							</a>
							Movimientos 
						</div>
						<div id="ImagenBarraLeft" style="text-align:center;">
							<a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>&nTransaccion=0&accion=Agregar" title="Agregar Cargo">
								<img src="../../imagenes/add_32.png"><br>
							</a>
							+ Agregar 
						</div>
					<?php } ?>
					<?php if($accion == 'Agregar' or $accion == 'Actualizar'){?>
						<div id="ImagenBarraLeft" style="text-align:center;">
							<button name="Guardar">
								<!-- <a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>" title="Registro de Cargos"> -->
									<img src="../../imagenes/guardar.png"><br>
									Guardar 
								<!-- </a> -->
							</button>
						</div>
					<?php } ?>
					<?php if($accion == 'Borrar'){?>
						<div id="ImagenBarraLeft" style="text-align:center;">
							<button name="Borrar">
								<!-- <a href="index.php?nCuenta=<?php echo $nCuenta; ?>&MesFiltro=<?php echo $MesNum[$MesFiltro]; ?>&Agno=<?php echo $Agno; ?>" title="Registro de Cargos"> -->
									<img src="../../imagenes/inspektion.png"><br>
									Borrar 
								<!-- </a> -->
							</button>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div id="BarraFiltro">
				<img src="../../gastos/imagenes/data_filter_128.png" width="28" height="28">

						<!-- Fitra por Fecha -->
	  					<select name='MesFiltro' id='MesFiltro'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($i == $MesNum[$MesFiltro]){
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

						<!-- Fitra por A�o -->
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
						<button name="Filtrar">
							Fltrar
						</button>
						Cuenta Corriente
<!--						<input name="nCuenta" align="right" maxlength="50" size="50" list="ctas" value="<?php echo $nCuenta;?>" title="Ingrese Cuenta Corriente..." required autofocus placeholder="Cuenta Corriente..." /> -->
						<input name="nCuenta" type="hidden" align="right" maxlength="50" size="50" value="<?php echo $nCuenta; ?>"  />
						<?php echo $nCuenta.' ('.$Banco.')'; ?>
			</div>
			
			<?php
				if($nCuenta){
					if($accion == ''){
						include_once('desplegarInforme.php');
					}
					if($accion == 'Agregar' or $accion == "Actualizar" or $accion == "Borrar"){
						include_once('movimientoCuentas.php');
					}
				}
			?>
		</form>
			