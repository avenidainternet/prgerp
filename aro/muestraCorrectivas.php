	<script>
		$(document).ready(function() {
    		$('#example').DataTable();
		} );	
	</script>

<?php
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	
	$usrFiltro = '';
	
	if(isset($_GET['usrFiltro'])) { $usrFiltro  = $_GET['usrFiltro']; 	}
	if(isset($_SESSION['empFiltro'])) { 
		//$empFiltro  = $_GET['empFiltro']; 	
		$empFiltro = $_SESSION['empFiltro'];
		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$empFiltro."%'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$filtroCli = $rowCli['RutCli'];
		}
		mysql_close($link);
	}else{
		$filtroCli = '';
	}
	if(isset($_SESSION['usrFiltro'])) { $usrFiltro = $_SESSION['usrFiltro'];	}
	informesAcciones(); 
	?>
		
		<?php
		function informesAcciones(){?>
         <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tabla ARO</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Acciones
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

							<table class="table table-dark table-hover table-bordered" id="example" style="padding-top: 15px;">
								<thead>
									<th>
										<td> N° Acción				</td>
										<td> Fecha<br>Apertura		</td>
										<td> Implem.<br>Resp.		</td>
										<td> Hallazgo				</td>
										<td> Riesgo<br>Oportunidad	</td>
										<td> Fecha<br>Tent.			</td>
										<td> Fecha<br>Verif.		</td>
										<td> Fecha<br>Cierre		</td>
										<td> Acciones				</td>
									</th>
								</thead>
								</tbody>
									<?php
										$n 		= 0;
										$link=Conectarse();
										$sql = "SELECT * FROM accionesPreventivas Order By nInformePreventiva Desc";
										$bdEnc=$link->query($sql);
										if ($row=mysqli_fetch_array($bdEnc)){
											do{
												$fd = explode('-', $row['accFechaTen']);
												$fechaHoy = date('Y-m-d');
												$start_ts = strtotime($fechaHoy); 
												$end_ts = strtotime($row['accFechaTen']); 
												$nDias = $end_ts - $start_ts;
												$nDias = round($nDias / 86400);
												$tr = "bg-light text-dark";
												if($row['accFechaTen']<$fechaHoy){ 
													$tr = "bg-light text-dark"; // Barra Blanca
												}
												if($row['accFechaTen']>=$fechaHoy){ 
													// 22/7 >= 21/7
													$tr = 'bg-danger text-white'; // Barra Roja
												}
												if($row['accFechaTen']>$fechaHoy){ 
													$tr = 'bg-success text-white'; // Barra Verde
												}
												$fechaHoymas = date("d-m-Y",strtotime($fechaHoy."+ 1 days"));
												//echo ' Fecha '.$fechaHoy.' '. $fechaHoymas;
												
												if($row['accFechaTen']==$fechaHoymas){ 
													$tr = "bg-warning text-white"; // Barra Amarilla
												}
												if($nDias==1){ 
													$tr = "bg-warning text-white";
												}
												if($nDias>1){ 
													$tr = "bg-success text-white";
												}
												if($nDias==0 or $nDias < 0){ 
													$tr = "bg-danger text-white";
												}
												if($fd[0]==0){ 
													$tr = "bg-light text-dark";
												}

												if($nDias<=5){ 
													$tr = "bg-warning text-white";
												}
												if($nDias>5){ 
													$tr = "bg-success text-white";
												}
												if($nDias==0 or $nDias < 0){ 
													$tr = "bg-danger text-white";
												}

												if($row['verCierreAccion']=='on'){ 
													$tr = "bg-primary text-whit";
												}?>
												<tr class="bg-primary text-whit">
													<td></td>
													<td>
														<?php echo	$row['nInformePreventiva']; ?>
													</td>
													<td>
														<?php
															$fd = explode('-', $row['fechaApertura']);
															echo $fd[2].'/'.$fd[1];
															echo '<br>'.$row['usrApertura'];
														?>
													</td>
													<td>
														<?php
															$fd = explode('-', $row['accFechaImp']);
															echo $fd[2].'/'.$fd[1];
															echo '<br>'.$row['usrResponsable'];
														?>
													</td>
													<td style="width: 30%;">
														<?php echo $row['desHallazgo']; ?>
													</td>
													<td>
														<?php
														if($row['resultado'] == 'R'){
															echo 'Riesgo';
														}
														if($row['resultado'] == 'O'){
															echo 'Oportunidad';
														}
														?>
													</td>
													<td>
														<?php
															$fd = explode('-', $row['accFechaTen']);
															echo $fd[2].'/'.$fd[1];
															if($nDias > 0){
																echo '<br>'.$nDias;
															}
														?>
													</td>
													<td>
														<?php
															$fd = explode('-', $row['accFechaApli']);
															echo $fd[2].'/'.$fd[1];
														?>
													</td>
													<td>
														<?php
															$fd = explode('-', $row['fechaCierre']);
															echo $fd[2].'/'.$fd[1];
														?>
													</td>
													<td>
														<ul class="nav nav-pills">
															<li class="nav-item" style="padding: 2px;">
																<?php
																echo '<a href="accionesPreventivas.php?nInformePreventiva='.$row['nInformePreventiva'].'&accion=Imprimir"><img src="../imagenes/informes.png" 				width="40" height="40" title="Imprimir Acción Preventiva">		</a>';
																?>
															</li>
															<li class="nav-item" style="padding: 2px;">
																<?php
																echo '<a href="formARO.php?nInformePreventiva='.$row['nInformePreventiva'].'&accion=Actualizar">
																	<img src="../gastos/imagenes/corel_draw_128.png" width="40" title="Editar Formulario ARO">
																	</a>';
																?>
															</li>
															<li class="nav-item" style="padding: 2px;">
																<?php echo '
																<a href="formARO.php?nInformePreventiva='.$row['nInformePreventiva'].'&accion=Borrar">
																	<img src="../gastos/imagenes/del_128.png" width="40"  title="Borrar Acción Preventiva">
																</a>';
																?>
															</li>
													</td>
												</tr>
												<?php
											}while ($row=mysqli_fetch_array($bdEnc));
										}
										$link->close();
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>

