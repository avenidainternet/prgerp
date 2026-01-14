	<table width="100%" height="10"  border="0" align="center" cellpadding="0" cellspacing="0" class="degradado" id="Transparente">
  		<tr>
    		<td width="8%">
				<div align="center">
					<img src="imagenes/simet.png" width="100" height="50">
				</div>
			</td>
    		<td width="86%"> 
				<div align="center" class="titulos">
      				<div align="left" class="titulo">
        				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	          				<tr>
	            				<td colspan="3">&nbsp;</td>
	          				</tr>
	          				<tr>
	            				<td colspan="2">
									Servicio de Ingeniería Metalúrgica y Materiales
									<style>
									.floating-box {
										display: 			inline-block;
										width: 				70px;
										height: 			70px;
										border: 			1px solid #000;
										background-color: 	#FE9A2E;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		normal;
										color:				#000;
									}
									.textoDiv {
										color:				#000;
										font-size:			18px;
										font-family:		Arial;
										font-weight: 		bold;
									}	
									.textoDivDiv {
										color:				#000;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		bold;
									}	
									.textoDivTit {
										color:				#fff;
										font-size:			12px;
										font-family:		Arial;
										font-weight: 		normal;
									}	
									.after-box {
										border: 3px solid red; 
									}
									</style>									
									<div class="floating-box" style="text-align: center;">
										<img src="imagenes/Estrella_Azul.png"" width="10">
										<img src="imagenes/Estrella_Azul.png"" width="10">
										<img src="imagenes/Estrella_Azul.png"" width="10">
										<?php
											$AgnoCat  = date('Y');
											$MesCat   = date('m');
											$tCot 	  = 0;
											$tCotAtr  = 0;
											$tClas1	  = 0;
											$totClas1 = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
											//$SQLt = "SELECT * FROM Cotizaciones Where year(fechaCotizacion) = $AgnoCat and month(fechaCotizacion) = $MesCat";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '1'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
														if($rowCp['Estado'] == 'T'){
															$tCot++;
															$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
															$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

															
															if($rowCp['fechaTermino'] > '0000-00-00'){
																if($rowCp['fechaTermino'] > $fechaTermino){
																	$tCotAtr++;
																}
															}
														}
														$totClas1 = $tCot;
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCotAtr > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												//echo $tCotAtr.' / '.$tCot;
												echo $tCotAtr. '/'. $totClas1;
											?>
										</div>
									</div>
									<div class="floating-box" style="text-align: center;">
										<img src="imagenes/Estrella_Azul.png"" width="10">
										<img src="imagenes/Estrella_Azul.png"" width="10">
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '2'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

																	$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

														
														if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									<div class="floating-box" style="text-align: center;">
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '3'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
														
														
														if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									<div class="floating-box" style="text-align: center;">
											GENERAL 
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) = $MesCat";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$tCot++;
													$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
													$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;
													
													
													if($rowCp['fechaTermino'] > '0000-00-00'){
														if($rowCp['fechaTermino'] > $fechaTermino){
															$tCotAtr++;
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									
									
									
									
									<div class="floating-box" style="text-align: center; background-color: #ccc;">
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '1'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

														
														if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>

									<div class="floating-box" style="text-align: center; background-color: #ccc;">
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '2'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

														
														if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									
									<div class="floating-box" style="text-align: center; background-color: #ccc;">
										<img src="imagenes/Estrella_Azul.png"" width="10"> 
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."' and Clasificacion = '3'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;

														
														if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									
									<div class="floating-box" style="text-align: center; background-color: #ccc;">
										GENERAL
										<?php
											$AgnoCat = date('Y');
											$MesCat  = date('m');
											$tCot 	 = 0;
											$tCotAtr = 0;
											$link=Conectarse();
											$SQLt = "SELECT * FROM Cotizaciones Where Estado = 'T' and year(fechaInicio) = $AgnoCat and month(fechaInicio) >= 1";
											$bdCp=$link->query($SQLt);
											if($rowCp=mysqli_fetch_array($bdCp)){
												do{
													$SQLCli = "SELECT * FROM Clientes Where RutCli = '".$rowCp['RutCli']."'";
													$bdCli=$link->query($SQLCli);
													if($rowCli=mysqli_fetch_array($bdCli)){
													
														$tCot++;
														$fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
														$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
																	
			$fechaInicio = $rowCp['fechaInicio'];
			$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
			$ft = $fechaInicio;
			$dh	= $rowCp['dHabiles'] - 1;

			$dd	= 0;
			for($j=1; $j<=$dh; $j++){
				$ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
				$ft	= date ( 'Y-m-d' , $ft );
				//echo $ft.'<br>';
				$dia_semana = date("w",strtotime($ft));
				if($dia_semana == 0 or $dia_semana == 6){
					$dh++;
					$dd++;
				}
				$SQL = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
				$bdDf=$link->query($SQL);
				if($row=mysqli_fetch_array($bdDf)){
					$dh++;
					$dd++;
				}
			}
			$fechaTermino = $ft;


															if($rowCp['fechaTermino'] > '0000-00-00'){
															if($rowCp['fechaTermino'] > $fechaTermino){
																$tCotAtr++;
															}
														}
													}
												}while ($rowCp=mysqli_fetch_array($bdCp));
											}
											$link->close();
										?>
										<div class="textoDiv">
											<?php
											if($tCot > 0){
												echo number_format(($tCotAtr/$tCot), 2, ',', '.');
											}else{
												echo number_format('0.00', 2, ',', '.');
											}
											?>
										</div> 
										<div class="textoDivDiv">
											<?php
												echo $tCotAtr.' / '.$tCot;
											?>
										</div>
									</div>
									
									
									
								</td>
	          				</tr>
	          				<tr>
    	        				<td>
								
									<?php 
										//$nCols = round($nRams/12);
										//$nCols = round($_SESSION['nRams']/12);
										//echo $_SESSION[nPantalla].'/'.$nCols.'-'.$_SESSION[nRams]; 
									?>
								</td>
	            				<td width="2%">&nbsp;</td>
	          				</tr>
	        			</table>
	      			</div>
    			</div>
			</td>
    		<td width="6%">
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

					$indOld = array(
						1 	=> 0, 
						2	=> 0,
						3 	=> 0,
						4 	=> 0,
						5 	=> 0,
						6 	=> 0,
						7 	=> 0,
						8 	=> 0,
						9	=> 0,
						10 	=> 0,
						11 	=> 0,
						12	=> 0
					);
					
					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);
					
					$fdInicial	= $fd[1] - 3;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					$link=Conectarse();
					$tNeto	= 0;
					$vUF	= 0;

					$bdUfRef=$link->query("Select * From tablaRegForm");
					if($rowUfRef=mysqli_fetch_array($bdUfRef)){
						$vUF = $rowUfRef['valorUFRef'];
					}

/*					
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = '".$fd[0]."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							if($rowGas['valorUF'] > $vUF){
								$vUF = $rowGas['valorUF'];
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
*/					
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fdInicial	= $fd[1] - 2;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fdInicial	= $fd[1] - 1;
					if($fdInicial <= 0){
						$fdInicial 	= 12 + $fdInicial;
						$Agno 		= $fd[0] - 1;
					}else{
						$Agno 	= $fd[0];
					}
					
					$link=Conectarse();
					$tNeto	= 0;
					$result  = $link->query("SELECT * FROM SolFactura WHERE year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fdInicial."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indOld[$fdInicial] = round($tNeto/1000000,2);
					$link->close();

					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);

					$Agno 	= $fd[0];
					$tNeto 	= 0;
					$link=Conectarse();
					$result  = $link->query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = $Agno and month(fechaSolicitud) = '".$fd[1]."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['Neto']>0){
										$tNeto += $rowGas['Neto'];
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$indVtas  = round($tNeto/1000000,2);
					$link->close();

					
					//$bdInd=$link->query("SELECT * FROM tablaRegForm");
					$indMin 	= 0;
					$indMeta 	= 0;
					$link=Conectarse();
					$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$fd[1]."' and agnoInd = '".$fd[0]."'");
					if($row=mysqli_fetch_array($bdInd)){
						$indMin  = $row['indMin'];
						$indMeta = $row['indMeta'];
					}
					
					$tDiasMes = date('t');
					$tFeriados = 0;
					$bd=$link->query("SELECT * FROM diasferiados Where year(fecha) = '".$fd[0]."' and month(fecha) = '".$fd[1]."'");
					if($row=mysqli_fetch_array($bd)){
						do{
							$tFeriados++;
						}while ($row=mysqli_fetch_array($bd));
					}
					$tDiasMes = $tDiasMes - $tFeriados;

					for($dias = 1; $dias<=$tDiasMes; $dias++){
						$dd = $dias;
						if($dias < 10) { $dd = '0'.$dias; }
						$fecha = strtotime("$Agno-".$fd[1]."-$dd");
						$fecha = date('Y-m-d',$fecha);
						if(date('N', strtotime($fecha)) == 6){
							$tDiasMes = $tDiasMes - 1;
						}
						if(date('N', strtotime($fecha)) == 7){
							$tDiasMes = $tDiasMes - 1;
						}
					}
					
					
					$iMin = round((($indMin / $tDiasMes) * $fd[2]),2);
					$iMet = round((($indMeta / $tDiasMes) * $fd[2]),2);
					$link->close();


					$fechaHoy 	= date('Y-m-d');
					$fd 		= explode('-', $fechaHoy);

					$Agno 			= $fd[0];
					$tProductividad	= 0;
					$tProduccionP	= 0;
					$tProdAF		= 0;
					$link	= Conectarse();
					//$result  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio != '0000-00-00' and year(fechaTermino) = '".$Agno."' and month(fechaTermino) = '".$fd[1]."'");
					$result  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio != '0000-00-00' and year(fechaTermino) = '".$Agno."' and month(fechaTermino) = '".$fd[1]."'");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								$cFree = $rowP['cFree'];
								if($rowP['cFree'] != 'on'){
									if($rowGas['NetoUF']>0){
										$tProductividad += $rowGas['NetoUF'];
										if($rowGas['tpEnsayo'] == 2){
											$tProdAF += ($rowGas['NetoUF'] * $vUF);
										}
									}else{
										$tProduccionP += $rowGas['Neto'];
										if($rowGas['tpEnsayo'] == 2){
											$tProdAF += $rowGas['Neto'];
										}
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					if($tProductividad > 0){
						$tProductividad  = $tProductividad * $vUF;
					}
					if($tProduccionP > 0){
						$tProductividad  =+ tProduccionP;
					}
					if($tProductividad > 0){
						$tProductividad  = round($tProductividad/1000000,2);
					}
					if($tProdAF > 0){
						$tProdAF  = round($tProdAF/1000000,2);
					}
					$link->close();
					
					$cIndice = "indIndiceRojo";
					if($iMin > $indMin) { $iMin = $indMin; }
					if($iMet > $indMeta){ $iMet = $indMeta; }
					
					if($indVtas > $iMin and $indVtas > $iMet){
						$cIndice = "indIndiceVerde";
					}
					if($indVtas > $iMin and $indVtas < $iMet){
						$cIndice = "indIndiceAmarillo";
					}
					if($indVtas < $iMin and $indVtas < $iMet){
						$cIndice = "indIndiceRojo";
					}

					
				?>
				
				<div align="left">
					<table>
						<tr>
							<?php
								$fdInicial	= $fd[1] - 3;
								$fdFinal	= $fd[1] - 1;
								if($fdInicial <= 0){
									$fdInicial  = 12 + $fdInicial;
									$fdFinal	= $fdInicial + 2;
								}
								$link=Conectarse();
								$mIndicador	= 0;
								$mMeta		= 0;
								$mMin		= 0;
								
								$mIndicador	= 0;
								$sIndicador	= 0;
								for($i=$fdInicial; $i<=$fdFinal; $i++){
									$cIndiceMin = "indIndiceVerde";
									$bdInd=$link->query("SELECT * FROM tablaIndicadores Where mesInd = '".$i."'");
									if($row=mysqli_fetch_array($bdInd)){
										$mIndicador += $indOld[$i];
										$sIndicador += $indOld[$i];
										$mMeta		+= $row['indMeta'];
										$mMin		+= $row['indMin'];
										if($indOld[$i] < $row['indMeta']){
											$cIndiceMin = "indIndiceRojo";
											if($indOld[$i] >= $row['indMin']){
												$cIndiceMin = "indIndiceAmarillo";
											}
										}
									}
								}

								$link->close();
								$mIndicador = $mIndicador / 3;
								$mMeta 		= $mMeta / 3;
								$mMin 		= $mMin / 3;
								
								$cIndiceMin = "indIndiceVerde";
								if($mIndicador < $mMeta){
									$cIndiceMin = "indIndiceRojo";
									if($mIndicador >= $mMin){
										$cIndiceMin = "indIndiceAmarillo";
									}
								}
								
								// Indice Productividad
								$cProduc = "indIndice";
								if($tProductividad >= $iMin)	{ 
									$cProduc = "indIndiceVerde"; 		
									if($tProductividad >= $iMet)	{ 
										$cProduc = "indIndiceVerde"; 		
									}else{
										$cProduc = "indIndiceAmarillo";
									}
								}else{
									$cProduc = "indIndiceRojo"; 		
								}
								
								?>
								<td class="indIndiceCeleste" align="center">
									<span style="font-size:12px;">Prod.AF</span>
									<?php 
										echo number_format($tProdAF, 2, ',', '.').'<br>';
									?>
								</td>
								<td style="padding-right:50px;">&nbsp;</td>
								<td class="<?php echo $cProduc; ?>" align="center">
									<!--<span style="font-size:12px; "><?php //echo substr($Mes[$i],0,3).'.';?></span> -->
									<!-- <span style="font-size:12px;">Indicador</span> -->
									<?php 
										//echo number_format($mIndicador, 2, ',', '.');
										//echo $indOld[10];
										//echo $fdIniciali;
									?>
									<span style="font-size:12px;">Producción</span>
									<?php 
										echo number_format($tProductividad, 2, ',', '.').'<br>';
										//echo '<br>'.$tDiasMes;
										//echo $vUF;
										//echo $fdIniciali;
									?>
								</td>
								<td style="padding-right:30px;">&nbsp;</td>
							<?php
								$cIndiceMin = "indIndice";
								if($indVtas >= $iMin)	{ 
									$cIndiceMin = "indIndiceVerde";
								}else{
									$cIndiceMin = "indIndiceRojo"; 
								}
							?>
							<td class="<?php echo $cIndiceMin; ?>">
								<span style="font-size:12px; ">Mínimo</span>
								<?php echo number_format($indMin, 2, ',', '.');?>
							</td>
							<?php
								$cIndiceMin = "indIndice";
											if($indVtas >= $iMet)	{ 
												$cIndiceMin = "indIndiceVerde"; 		
											}else{
												$cIndiceMin = "indIndiceRojo"; 		
											}
/*
								if($indVtas >  $iMet)	{ $cIndiceMin = "indIndiceVerde"; 		}
								if($indVtas == $iMet)	{ $cIndiceMin = "indIndiceAmarillo"; 	}
								if($indVtas <  $iMet)	{ $cIndiceMin = "indIndiceRojo"; 		}
*/
							?>
							<td class="<?php echo $cIndiceMin; ?>">
								<span style="font-size:12px; ">Meta</span>
								<?php echo number_format($indMeta, 2, ',', '.');?>
							</td>
								<?php
									$cIndice = "indIndice";
									if($indVtas >= $iMin)	{ 
										$cIndice = "indIndiceVerde"; 		
										if($indVtas >= $iMet)	{ 
											$cIndice = "indIndiceVerde"; 		
										}else{
											$cIndice = "indIndiceAmarillo";
										}
									}else{
										$cIndice = "indIndiceRojo"; 		
									}
								?>
							<td class="<?php echo $cIndice; ?>">
								<span style="font-size:12px; ">Indice</span>
								<?php echo number_format($indVtas, 2, ',', '.');?>
							</td>
						</tr>
					</table>
					<?php
						$link=Conectarse();
						$result  = $link->query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaHoy."'");
						if($rowGas=mysqli_fetch_array($result)){
							$actSQL="UPDATE tabIndices SET ";
							$actSQL.="iProductividad	 ='".$tProductividad."',";
							$actSQL.="iMinimo			 ='".$indMin."',";
							$actSQL.="iMeta				 ='".$indMeta."',";
							$actSQL.="indVtas			 ='".$indVtas."'";
							$actSQL.="WHERE fechaIndice = '".$fechaHoy."'";
							$bdGas=$link->query($actSQL);
						}else{
							$link->query("insert into tabIndices(	fechaIndice,
																	iProductividad,
																	iMinimo,
																	iMeta,
																	indVtas
																) 
													values 		(	'$fechaHoy',
																	'$tProductividad',
																	'$indMin',
																	'$indMeta',
																	'$indVtas'
																	)");
						}
						$link->close();
					?>
				</div>
				<!--
				<div align="left">
					<img src="imagenes/Logo-Color-Usach-Web-Ch.png" >
				</div>
				-->
			</td>
  		</tr>
	</table>
