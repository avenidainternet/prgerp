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

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaRAM.php" title="Registro de Materiales">
						<img src="../imagenes/machineoperator_128.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="#" title="Agregar Materiales" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/herramientas.png">
					</a>
				</div>
			</div>
			<div id="barraCAM">
				<?php
/*
					$link=Conectarse();
					$bdUsr=mysql_query("Select * From Usuarios");
					if($rowUsr=mysql_fetch_array($bdUsr)){
						do{
							// if($rowUsr[nPerfil]  == 1 or substr($rowUsr[nPerfil],0,1)  == '01' or substr($rowUsr[nPerfil],0,1)  == '02'){
							if($rowUsr[nPerfil] != 'WM' and intval($rowUsr[nPerfil]) != 0 and $rowUsr[nPerfil] != 3){
								echo '<a href="plataformaCotizaciones.php?usrFiltro='.$rowUsr[usr].'" title="'.$rowUsr[usuario].'">'.$rowUsr[usr].'</a>';
							}
						}while($rowUsr=mysql_fetch_array($bdUsr));
					}
					mysql_close($link);
					echo '<a href="plataformaCotizaciones.php?usrFiltro=" title="Todos">Todos</a>';
*/
				?>
				Filtrar por cliente
					<?php
					$tabCli = array();
					$link=Conectarse();
					$bdCot=mysql_query("Select * From Cotizaciones");
					if($rowCot=mysql_fetch_array($bdCot)){
						do{
							$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$rowCot[RutCli]."'");
							if($rowCli=mysql_fetch_array($bdCli)){
								
								// in_array = Buscar una valor en una array()
								
								if(in_array($rowCli[Cliente],$tabCli)){
								}else{
									$tabCli[]= $rowCli[Cliente];
								}
							}
						}while($rowCot=mysql_fetch_array($bdCot));
					}
					mysql_close($link);
					asort($tabCli);
					?>
				<select name="empFiltro" onChange="window.location = this.options[this.selectedIndex].value; return true;">
					<option value="plataformaCotizaciones.php?empFiltro="></option>
					<?php
					foreach ($tabCli as $valor){ 
						if($valor == $_SESSION[empFiltro]){
							echo '<option selected value="plataformaCotizaciones.php?empFiltro='.$valor.'">'.$valor.'</option>';
						}else{
							echo '<option value="plataformaCotizaciones.php?empFiltro='.$valor.'">'.$valor.'</option>';
						}
					}
					?>
				</select>
			</div>
			<?php
			if($dBuscado==''){?>
				<script>
					var dBuscar = '';
					realizaProceso(dBuscar);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>