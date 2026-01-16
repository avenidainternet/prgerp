<?php

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
	
	$dBuscar 	= ' ';
	$Marcar 	= ' ';
	if(isset($_GET['dBuscar'])) 	{ $dBuscar  = $_GET['dBuscar']; 	}
	if(isset($_GET['Marcar'])) 		{ $Marcar 	= $_GET['Marcar']; 	}
	
?>
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">
				<!-- Fin Filtro -->
				Clientes...
				<!-- <input name="dBuscado" id="dBuscar" onKeyUp="realizaProceso($('#dBuscar').val())" align="right" maxlength="20" size="20" title="Ingrese RUT del Cliente a buscar..."> -->
				<input name="dBuscar" id="dBuscar" align="right" maxlength="40" size="40" placeholder="Buscar Cliente" title="Ingrese Nombre Cliente...">
				<button name="Buscar" onClick="realizaProceso($('#dBuscar').val(),$('#Marcar').val())">
					<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
				</button>

			</div>
		<form name="form" action="formCorreoMasivo.php" method="post">
			<div id="BarraOpciones">
				<button name="Enviar" title="Enviar Correo Masivo"> 
					<img src="../imagenes/mail_html.png"  width="40" height="40">
				</button>
			</div>
				<script>
					var dBuscar = "<?php echo $dBuscar; ?>";
					var Marcar 	= "<?php echo $Marcar; ?>";
					realizaProceso(dBuscar, Marcar);
				</script>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>
		</form>