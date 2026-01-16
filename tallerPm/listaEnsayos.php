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
<?php
if($dBuscado==''){?>
	<script>
		var CAM 	= '<?php echo $CAM; ?>';
		var RAM 	= '<?php echo $RAM; ?>';
		var accion 	= '<?php echo $accion; ?>';
		var dBuscar = '';
		realizaProceso(CAM, RAM, dBuscar, accion);
	</script>					
<?php
}
?>
<span id="resultado"></span>
<span id="resultadoRegistro"></span>
