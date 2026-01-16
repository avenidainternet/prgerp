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

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
		$MesFiltro = $Mes[intval($fd[1])];
	}

	$pPago = $Mm.'.'.$fd[0];

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	$MesFiltro  = date('m');;
	$Situacion 	= "Estado";
	$Agno     	= date('Y');
	$AgnoAct	= date('Y');
	
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	$dBuscado = '';
	$nOrden	  = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_POST['MesFiltro'])) 	{ $MesFiltro = $_POST['MesFiltro']; }
	if(isset($_POST['Agno'])) 		{ $Agno 	 = $_POST['Agno']; 		}

	if($dBuscado){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
		if ($rowP=mysqli_fetch_array($bdPer)){
			$RutCli = $rowP['RutCli'];
			}
		$link->close();
	}
?>


<form name="form" action="index.php" method="post" style="display:inline; ">
	<div class="row bg-secondary text-white" style="padding: 5px;">
		<div class="col-2">
			Mes
			<select class="form-control" name='MesFiltro' id='MesFiltro'>
				<?php
					for($i=1; $i <=12 ; $i++){
						if($Mes[$i]==$MesFiltro){
							echo '<option selected 	value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
						}else{
							if($Agno == date('Y')){
								if($i > strval($fd[1])){
									echo '	<option style="opacity:.5; color:#ccc;" value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
								}else{
									echo '<option value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
								}
							}else{
								echo '<option value="'.$Mes[$i].'">'.$Mes[$i].'</option>';
							}
						}
					}
				?>
			</select>
		</div>
		<div class="col-2">
			<!-- Fin Filtro -->
			Año
	  		<select class="form-control" name='Agno' id='Agno'>
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
		</div>
		<div class="col-7">
			<!-- Fin Filtro -->
			Rut Cliente a buscar
			<input class="form-control" name="dBuscado" align="right" maxlength="50" size="50" list="clie" title="Ingrese RUT del Cliente a buscar..." required  >
			<datalist id="clie">
				<?php
					$link=Conectarse();
					$bdProv=$link->query("SELECT * FROM Clientes");
					while($row=mysqli_fetch_array($bdProv)){?>
						<option value="<?php echo $row['Cliente']; ?>">
						<?php
					}
				?>
			</datalist>
		</div>
		<div class="col-1">
			<button class="btn btn-success" name="Buscar">
				Filtrar
			</button>
		</div>
					
	</div>
	<?php
		$Cliente = '';
		if($dBuscado){
			$link=Conectarse();
			$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
			if ($rowP=mysqli_fetch_array($bdPer)){
				$Cliente = $rowP['Cliente'];
			}
			$link->close();
		}
	?>
	</form>
	<?php
		if($Cliente){
			include_once('desplegarInforme.php');
		}
	?>
			