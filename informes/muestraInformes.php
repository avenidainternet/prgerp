	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("../conexionli.php");

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

	$Proyecto 	= "IGT-1118";
	$Estado 	= "Todos";
	$Agno     	= $fd[0];
	$MesFiltro = $Mes[intval($fd[1])];

	if(isset($_GET['CodInforme']))  { $CodInforme= 'AM-'.$_GET['CodInforme']; }
	if(isset($_GET['dBuscar']))  	{ $dBuscar   = $_GET['dBuscar']; 	}
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado'])) 		{ $Estado 	 = $_GET['Estado']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>Informes	'.$CodInforme.'		</strong></td>';
				echo '			<td  width="10%" align="center">			<strong>Fecha<br>Informe</strong></td>';
				echo '			<td  width="10%" align="center">			<strong>Proyecto		</strong></td>';
				echo '			<td  width="36%" align="center">			<strong>Cliente			</strong></td>';
				echo '			<td  width="10%" align="center">			<strong>Estado 			</strong></td>';
				echo '			<td  width="24%" align="center" colspan="4"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tBruto = 0;
				$link=Conectarse();
				$filtroSQL = " RutCli != '' and informePDF = '' and IdProyecto = '".$Proyecto."'";
/*
				if($Estado <> 'Todos'){
					if($Estado == 'Pendientes'){
						$filtroSQL = ' Estado = 1 and ';
					}
					if($Estado == 'Terminados'){
						$filtroSQL = ' Estado = 2 and ';
					}
					if($Estado == 'Sin Informe'){
						$filtroSQL = ' informePDF = "" and ';
					}
				}
				if($MesFiltro){
					$MesFiltro = intval($MesNum[ $MesFiltro ]);
				}
*/				
				echo '<span style="color:#000;"'.$MesFiltro.'</span>';
				$filtroCAM = "RAM > 0 and Estado = 'T' and Archivo != 'on' and informeUP != 'on'";
				if($CodInforme){
					$filtroSQL = " CodInforme Like '%".$CodInforme."%'";
					$fdCAM = explode('-', $CodInforme);
					$filtroCAM = "RAM = '".$fdCAM[1]."'";
				}
				//echo $filtroCAM;
				$bdCAM=$link->query("SELECT * FROM Cotizaciones Where $filtroCAM");
				if($rowCAM=mysqli_fetch_array($bdCAM)){
					//do{
						$filtroSQL = "CodInforme Like '%".$rowCAM['RAM']."%'";
						$bdHon=$link->query("SELECT * FROM Informes Where $filtroSQL Order By CodInforme, DiaInforme Desc, informePDF Desc");
						if($row=mysqli_fetch_array($bdHon)){
							do{
								$muestraInf = 'NO';
									$muestraInf = 'SI';
								if($muestraInf == 'SI'){
									$tr = "barraBlanca";
									if($row['Estado']==1){
										$tr = 'barraBlanca';
									}else{
										if($row['Estado']==2){
											$tr = 'barraVerde';
										}
									}
									if($row['informePDF']==''){
										$tr = 'barraAmarilla';
									}
									if($row['Estado']==''){
										$tr = 'barraRoja';
									}
									
									echo '	<tr id="'.$tr.'">';
													$CodInforme = $row['CodInforme'];
									echo '			<td width="10%" style="font-size:16px;">'.$row['CodInforme'].'</td>';
									echo '			<td width="10%">';
														$fechaInforme = '';
														$bdAMINF=$link->query("SELECT * FROM AmInformes Where CodInforme = '".$CodInforme."'");
														if($rowAMINF=mysqli_fetch_array($bdAMINF)){
															if($rowAMINF['fechaInforme'] > '0000-00-00'){
																$fam = explode('-',$rowAMINF['fechaInforme']);
																$fechaInforme = $fam[2].'/'.$Mes[intval($fam[1])].'/'.$fam[0];
															}
														}
														//echo 'Estado '.$row['Estado'];
/*														
														$d = $row['DiaInforme'];
														if(intval($row['DiaInforme'])<10){
															$d = '0'.$row['DiaInforme'];
														}
														$fechaInforme = $d.'/'.substr($Mes[intval($row['MesInforme'])],0,3).'.';
*/														
														echo $fechaInforme;
									echo '			</td>';
									echo '			<td width="10%">'.$row['IdProyecto'].'</td>';
									echo '			<td width="36%">';
														$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
														if ($rowP=mysqli_fetch_array($bdPer)){
															echo '<strong>'.$rowP['Cliente'].'</strong>';
														}
									echo '			</td>';
									echo '			<td width="10%" align="center">';
														if($row['Estado'] == '1'){
															echo 'Pendiente';
														}
														if($row['Estado'] == '2'){
															echo 'Terminado';
														}
														if($row['informePDF'] == ''){
															echo '<br>Sin Informe';
														}
									echo ' 			</td>';
									echo '			<td width="6%">';
														
														if($row['informePDF'] != '' and $row['fechaUp'] != '0000-00-00'){
															echo '<a href="mostrarPdfLocal.php?accion=Actualizar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/informeUP.png" 		width="32" height="32" title="Informe Subido"		>	</a>';
															
															if($row['informePDF']){
																$nombre_archivo = "../../intranet/informes/".$row['informePDF'];
																if(file_exists($nombre_archivo)) {
																}else{
																	echo '<a href="https://simet.cl/erp/informes/plataformaSubeInformes.php?accion=SubirPdf&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'&IdProyecto='.$row['IdProyecto'].'&CodigoVerificacion='.$row['CodigoVerificacion'].'&servidor='.gethostname().'"	><img src="../imagenes/upload2.png" width="50" height="50" title="SUBIR INFORME">	</a>';
																}
															}
															
														}else{
															echo '<a href="https://simet.cl/erp/informes/plataformaSubeInformes.php?accion=SubirPdf&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'&IdProyecto='.$row['IdProyecto'].'&CodigoVerificacion='.$row['CodigoVerificacion'].'&servidor='.gethostname().'"	><img src="../imagenes/upload2.png" width="50" height="50" title="SUBIR INFORME">	</a>';
															//echo '<a href="plataformaInformes.php?accion=SubirPdf&CodInforme='.$row['CodInforme'].'"	><img src="../imagenes/upload2.png" width="50" height="50" title="SUBIR INFORME">	</a>';
															//<a href="" onClick="subirInformePDF($('#CodInforme').val())"><img src="../imagenes/upload2.png" 		width="50" height="50" title="SUBIR INFORME"></a>
														}
									echo '			<td>';
									echo '			<td width="6%">';
														if($row['informePDF'] != '' and $row['fechaUp'] != '0000-00-00'){
															echo '<a href="mInforme.php?accion=Descargar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/pdf_download.png" 	width="32" height="32" title="Bajar Informe AM"	>	</a>';
														}else{
															echo '&nbsp;';
														}
									echo '			</td>';
									echo '			<td width="6%"><a href="mInforme.php?accion=Actualizar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/corel_draw_128.png" 	width="32" height="32" title="Editar Informe AM"	>	</a></td>';
									echo '			<td width="6%"><a href="mInforme.php?accion=Eliminar&CodInforme='.$row['CodInforme'].'&RutCli='.$row['RutCli'].'"	><img src="../imagenes/inspektion.png"   	width="32" height="32" title="Eliminar Informe AM"	>	</a></td>';
									echo '		</tr>';
								}
							}while ($row=mysqli_fetch_array($bdHon));
						}
					//} while ($rowCAM=mysqli_fetch_array($bdCAM));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
		</div>
		