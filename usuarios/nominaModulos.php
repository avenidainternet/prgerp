<?php
	//header('Content-Type: text/html; charset=iso-8859-1');

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
	
	$Login 	= $_GET['Login'];
	$accion = $_GET['accion'];

	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
				<img src="../imagenes/subst_student.png" width="28" height="28" align="middle">
				<span style="font-size:22px; font-family:"Courier New", Courier, mono; "><?php echo 'Usuario... '.$usrLogin; ?></span>
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaUsuarios.php" title="Usuarios">
						<img src="../imagenes/class_128.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Perfiles">
					<a href="Perfiles.php" title="Perfiles de Usuarios">
						<img src="../imagenes/single_class.png">
					</a>
				</div>
				<?php if($_SESSION['Perfil'] == 'WebMaster'){?>
					<div id="ImagenBarraLeft" title="Módulos">
						<a href="Modulos.php" title="Módulos">
							<img src="../imagenes/soft.png">
						</a>
					</div>
				<?php } ?>
				
			</div>
			
			<script>
				var Login 	= "<?php echo $Login; ?>";
				var accion 	= "<?php echo $accion; ?>";
				realizaProceso(Login, accion);
			</script>
			
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>