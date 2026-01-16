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
	$RutCli		= '';
	
	if(isset($_GET['RutCli'])) { $RutCli 	 = $_GET['RutCli']; }
	//$MesFiltro  = "Mes";
	//$Agno     	= date('Y');
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	if(isset($_GET['RutCli'])) 		{ $RutCli 	 = $_GET['RutCli']; 	}
	
	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	
?>



			<?php
			$Situacion 	= "Estado";
			$MesFiltro 	= "";
			if(isset($_GET['RutCli'])){ $RutCli 	= $_GET['RutCli']; }
			
			if($dBuscado==''){?>
				<script>
					var Proyecto 	= 'Proyectos';
					var Estado 		= 'Estado';
					var MesFiltro	= '';
					var Agno		= '<?php echo $Agno; ?>';
					var AgnoHasta	= '<?php echo $AgnoHasta; ?>';
					var RutCli 		= '<?php echo $RutCli; ?>';
					realizaProceso(Proyecto,Estado,MesFiltro,Agno, AgnoHasta, RutCli);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
