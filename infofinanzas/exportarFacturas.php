<?php
include_once("../conexionli.php");
if(isset($_GET['Agno'])) 	{ $Agno 	= $_GET['Agno'];}
if(isset($_GET['Mes']))		{ $Mes 		= $_GET['Mes'];	}

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SolicitudesFacturas.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportación de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan=9 height="40" align="center"><span style="font-size:18px;">INFORME DE SOLICITUDES DE FACTURAS</span></td>
			</tr>

			<tr>
				<td colspan=9 height="40">&nbsp;</td>
			</tr>

			<tr>
				<td colspan=9 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>


			<tr>
				<td colspan=9 height="40">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=9 height="30" style="color:#FFFFFF; background-color:#006699; font-size:18px;">Solicitudes Facturadas Sin Cancelar</td>
			</tr>
			<tr style="font-weight:700; font-size:12px;" height="25">
			  	<td width="60" align="center">RAMs	</td>
			  	<td>N° Solicitud					</td>
			  	<td>Fecha<br> Solicitud				</td>
			  	<td>Proyecto						</td>
    			<td>Factura							</td>
    			<td>Fecha<br> Factura				</td>
    			<td>RUT								</td>
    			<td>Clientes						</td>
    			<td>Bruto							</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=$link->query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				//$bdFac=$link->query("SELECT * FROM SolFactura Where nFactura > 0 && pagoFactura = '' Order By fechaFactura Asc");
				$bdFac=$link->query("SELECT * FROM SolFactura Where nFactura > 0 and pagoFactura <> 'on' Order By fechaFactura Asc");
				if($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$bdCli=$link->query("SELECT * FROM clientes Where RutCli = '".$rowFac['RutCli']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							if($rowCli['cFree'] != 'on' or $rowCli['Docencia'] != 'on'){
							?>
							<tr>
								<td align="justify"><?php echo $rowFac['informesAM']; 			?></td>
								
								<td><?php echo $rowFac['nSolicitud']; 			?></td>
								<td><?php echo $rowFac['fechaSolicitud']; 		?></td>
								<td><?php echo $rowFac['IdProyecto']; 			?></td>
								<td><?php echo $rowFac['nFactura']; 			?></td>
								<td>
									<?php 
										if($rowFac['fechaFactura']=='0000-00-00'){
											echo ' ';
										}else{
											echo $rowFac['fechaFactura'];
										}
									?>
								</td>
								<td>
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['RutCli'];
										}
									?>
								</td>
								<td>
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['Cliente'];
										}
									?>
								</td>
								<td><?php echo number_format($rowFac['Bruto'], 0, ',', '.'); 	?></td>
   							</tr>
							<?php
							}
						}
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>

				
			<tr>
				<td colspan=9 height="40">&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan=9 height="30" style="background-color:#FFCC00; font-size:18px;">Solicitudes con Fotocopia y sin Factura</td>
			</tr>
			<tr style="font-weight:700; font-size:12px;" height="25">
			  	<td width="60" align="center">RAMs	</td>
			  	<td>N° Solicitud					</td>
			  	<td>Fecha<br> Solicitud				</td>
			  	<td>Proyecto						</td>
    			<td>Fotocopia						</td>
    			<td>Fecha<br> Fotocopia				</td>
    			<td>RUT								</td>
    			<td>Clientes						</td>
    			<td>Bruto							</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=$link->query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				//$bdFac=$link->query("SELECT * FROM SolFactura Where nFactura = 0 and Fotocopia = 'on' && Estado = 'I' Order By fechaFactura Asc");
				$bdFac=$link->query("SELECT * FROM SolFactura Where nFactura = 0 and Fotocopia = 'on' && Estado = 'I' Order By fechaFactura Asc");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							if($rowCli['cFree'] != 'on' or $rowCli['Docencia'] != 'on'){
							?>
							<tr>
								<td align="justify"><?php echo $rowFac['informesAM']; 	?></td>
								<td><?php echo $rowFac['nSolicitud']; 					?></td>
								<td><?php echo $rowFac['fechaSolicitud']; 				?></td>
								<td><?php echo $rowFac['IdProyecto']; 					?></td>
								<td><?php echo $rowFac['Fotocopia']; 					?></td>
								<td>
									<?php 
										if($rowFac['fechaFotocopia']=='0000-00-00'){
											echo ' ';
										}else{
											echo $rowFac['fechaFotocopia'];
										}
									?>
								</td>
								<td>
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['RutCli'];
										}
									?>
								</td>
								<td>
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['Cliente'];
										}
									?>
								</td>
								<td><?php echo number_format($rowFac['Bruto'], 0, ',', '.'); 	?></td>
							</tr>
							<?php
							}
						}
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>

			<tr>
				<td colspan=9 height="40">&nbsp;</td>
			</tr>

			<tr>
				<td colspan=9 height="30" style="background-color:#FFFF00; font-size:18px;">Solicitudes Informadas</td>
			</tr>
			<tr style="font-weight:700; font-size:16px;" height="25">
			  	<td width="60" align="center">RAMs	</td>
			  	<td>N° Solicitud					</td>
			  	<td>Fecha<br> Solicitud				</td>
			  	<td>Proyecto						</td>
    			<td>RUT								</td>
    			<td colspan="3">Clientes			</td>
    			<td>Bruto							</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=$link->query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				$bdFac=$link->query("SELECT * FROM SolFactura Where nFactura = 0 and Fotocopia = ' ' and Estado = 'I' Order By fechaFactura Asc");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$bdCli=$link->query("SELECT * FROM clientes Where RutCli = '".$rowFac['RutCli']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							if($rowCli['cFree'] != 'on' or $rowCli['Docencia'] != 'on'){
							?>
							<tr>
								<td align="justify"><?php echo $rowFac['informesAM']; 	?></td>
								<td><?php echo $rowFac['nSolicitud']; 			?></td>
								<td><?php echo $rowFac['fechaSolicitud']; 		?></td>
								<td><?php echo $rowFac['IdProyecto']; 			?></td>
								<td>
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['RutCli'];
										}
									?>
								</td>
								<td colspan="3">
									<?php 
										$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
										if ($rowCli=mysqli_fetch_array($bdCli)){
											echo $rowCli['Cliente'];
										}
									?>
								</td>
								<td><?php echo number_format($rowFac['Bruto'], 0, ',', '.'); 	?></td>
							</tr>
							<?php
							}
						}
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>

				
				
				</table>
</body>
</html>