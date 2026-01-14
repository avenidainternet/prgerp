<?php

	//header('Content-Type: text/html; charset=utf-8');
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
					<a href="../../plataformaErp.php" title="Menú Principal">
						<img src="../../gastos/imagenes/Menu.png"><br>
					</a>
					Principal 
				</div>
				<div id="ImagenBarraLeft">
					<a href="../plataformaCotizaciones.php" title="Cotizaciones">
						<img src="../../imagenes/other_48.png"><br>
					</a>
					Proceso
				</div>
				<div id="ImagenBarraLeft" title="Cotización">
					<a href="../modCotizacion.php?CAM=<?php echo $OFE; ?>&Rev=0&Cta=0&accion=Actualizar" title="Servicios">
						<img src="../../imagenes/cotizacion.png"></a><br>
					<span>Cotización</span>
				</div>
				<div id="ImagenBarraLeft" title="Editar Ensayos">
					<a href="mEnsayos.php?OFE=<?php echo $OFE; ?>&accion=OFE" title="Ensayos">
						<img src="../../imagenes/ensayos.png"></a><br>
					<span>Ensayos</span>
				</div>
				<div id="ImagenBarraLeft" title="Descargar Oferta">
					<a href="../formularios/iOF.php?CAM=<?php echo $OFE; ?>" title="Descarga Oferta Económica">
						<img src="../../imagenes/informes.png"></a><br>
					<span>PDF</span>
				</div>
				<div id="ImagenBarraLeft" title="Descargar Oferta">
					<a href="exportarPlantilla.php?CAM=<?php echo $OFE; ?>" title="Descarga Oferta Económica en Word">
						<img src="../../imagenes/docx.png"></a><br>
					<span>WORD</span>
				</div>
				<div id="buttonGuardar" title="Guardar">
					<button name="guardarOferta">
						<img src="../../imagenes/guardar.png"></a><br>
						<span>Guardar</span>
					</button>
				</div>
			</div>
