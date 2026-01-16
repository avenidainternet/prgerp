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
	
	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  	= $_POST['dBuscado']; 	}
	if(isset($_GET['RAM']))  		{ $RAM 			= $_GET['RAM']; 		}
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
<!--
				<div id="ImagenBarraLeft">
					<a href="pOtams.php" title="RAMs">
						<img src="../imagenes/consulta.png"></a>
					<br>
					RAMs
				</div>
-->				
				<div id="ImagenBarraLeft">
					<a href="../cotizaciones/plataformaCotizaciones.php" title="Procesos">
						<img src="../imagenes/other_48.png"></a>
					<br>
					Proceso
				</div>
				
				<!--
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="mInforme.php?accion=Agregar&CodInforme=" title="Nuevo Informe">
						<img src="../imagenes/newPdf.png"></a>
					<br>
					Cód.QR
				</div>
				-->
				
			</div>
			
			<?php 
				if($accion != 'Nuevo'){
					include_once('muestraOTAMs.php'); 
				}
			?>
			<span id="resultadoRegistro"></span>
			<span id="resultadoSubir"></span>
			
