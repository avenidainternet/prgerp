<?
include("conexion.php");
$Agno 	= $_GET['Agno'];
$Mes 	= $_GET['Mes'];

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SolicitudesFacturas.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan=14 height="40" align="center"><span style="font-size:24px;">INFORME DE SOLICITUDES DE FACTURAS</span></td>
			</tr>

			<tr>
				<td colspan=14 height="40">&nbsp;</td>
			</tr>

			<tr>
				<td colspan=14 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>


			<tr>
				<td colspan=14 height="40">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=14 height="30" style="color:#FFFFFF; background-color:#006699; font-size:18px;">Solicitudes Facturadas Sin Cancelar</td>
			</tr>
			<tr style="font-weight:700; font-size:16px;" height="25">
			  	<td>N° Solicitud			</td>
			  	<td>Fecha Solicitud			</td>
			  	<td>Proyecto				</td>
    			<td>Factura					</td>
    			<td>Fecha Factura			</td>
    			<td>Cancelación				</td>
    			<td>RUT						</td>
    			<td>Clientes				</td>
    			<td>Neto UF					</td>
    			<td>IVA	 UF					</td>
    			<td>Bruto UF				</td>
    			<td>Neto					</td>
    			<td>IVA						</td>
    			<td>Bruto					</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=mysql_query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				$bdFac=mysql_query("SELECT * FROM SolFactura Where nFactura > 0 && pagoFactura = '' Order By IdProyecto, nSolicitud Asc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++
						?>
  						<tr>
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
							<td>&nbsp;</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['RutCli'];
									}
								?>
							</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['netoUF']; 				?></td>
    						<td><?php echo $rowFac['ivaUF']; 					?></td>
    						<td><?php echo $rowFac['brutoUF']; 				?></td>
    						<td><?php echo $rowFac['Neto']; 				?></td>
    						<td><?php echo $rowFac['Iva']; 					?></td>
    						<td><?php echo $rowFac['Bruto']; 				?></td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

				
			<tr>
				<td colspan=14 height="40">&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan=14 height="30" style="background-color:#FFCC00; font-size:18px;">Solicitudes Solicitadas Con Fotocopia y sin Factura</td>
			</tr>
			<tr style="font-weight:700; font-size:16px;" height="25">
			  	<td>N° Solicitud				</td>
			  	<td>Fecha Solicitud				</td>
			  	<td>Proyecto					</td>
    			<td>Fotocopia					</td>
    			<td>Fecha Fotocopia				</td>
    			<td>Factura						</td>
    			<td>RUT							</td>
    			<td>Clientes					</td>
    			<td>Neto UF						</td>
    			<td>IVA	 UF						</td>
    			<td>Bruto UF					</td>
    			<td>Neto						</td>
    			<td>IVA							</td>
    			<td>Bruto						</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=mysql_query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				$bdFac=mysql_query("SELECT * FROM SolFactura Where nFactura = 0 && Fotocopia = 'on' && Estado = 'I' Order By IdProyecto, nSolicitud Asc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++
						?>
  						<tr>
  					  		<td><?php echo $rowFac['nSolicitud']; 			?></td>
  					  		<td><?php echo $rowFac['fechaSolicitud']; 		?></td>
  					  		<td><?php echo $rowFac['IdProyecto']; 			?></td>
  					  		<td><?php echo $rowFac['Fotocopia']; 			?></td>
  					  		<td>
								<?php 
									if($rowFac['fechaFotocopia']=='0000-00-00'){
										echo ' ';
									}else{
										echo $rowFac['fechaFotocopia'];
									}
								?>
							</td>
							<td>&nbsp;</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['RutCli'];
									}
								?>
							</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['netoUF']; 				?></td>
    						<td><?php echo $rowFac['ivaUF']; 					?></td>
    						<td><?php echo $rowFac['brutoUF']; 				?></td>
    						<td><?php echo $rowFac['Neto']; 				?></td>
    						<td><?php echo $rowFac['Iva']; 					?></td>
    						<td><?php echo $rowFac['Bruto']; 				?></td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

			<tr>
				<td colspan=14 height="40">&nbsp;</td>
			</tr>

			<tr>
				<td colspan=14 height="30" style="background-color:#FFFF00; font-size:18px;">Solicitudes Solicitadas Informadas</td>
			</tr>
			<tr style="font-weight:700; font-size:16px;" height="25">
			  	<td>N° Solicitud				</td>
			  	<td>Fecha Solicitud				</td>
			  	<td>Proyecto					</td>
    			<td>Fotocopia					</td>
    			<td>Factura						</td>
    			<td>Fecha Factura				</td>
    			<td>RUT							</td>
    			<td>Clientes					</td>
    			<td>Neto UF						</td>
    			<td>IVA	 UF						</td>
    			<td>Bruto UF					</td>
    			<td>Neto						</td>
    			<td>IVA							</td>
    			<td>Bruto						</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=mysql_query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				$bdFac=mysql_query("SELECT * FROM SolFactura Where nFactura = 0 && Fotocopia = ' ' && Estado = 'I' Order By IdProyecto, nSolicitud Asc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++
						?>
  						<tr>
  					  		<td><?php echo $rowFac['nSolicitud']; 			?></td>
  					  		<td><?php echo $rowFac['fechaSolicitud']; 		?></td>
  					  		<td><?php echo $rowFac['IdProyecto']; 			?></td>
  					  		<td>&nbsp;</td>
  					  		<td>&nbsp;</td>
  					  		<td>&nbsp;</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['RutCli'];
									}
								?>
							</td>
    						<td>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['netoUF']; 				?></td>
    						<td><?php echo $rowFac['ivaUF']; 					?></td>
    						<td><?php echo $rowFac['brutoUF']; 				?></td>
    						<td><?php echo $rowFac['Neto']; 				?></td>
    						<td><?php echo $rowFac['Iva']; 					?></td>
    						<td><?php echo $rowFac['Bruto']; 				?></td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

				
				
				</table>
</body>
</html>