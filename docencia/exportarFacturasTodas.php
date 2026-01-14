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
			  	<td>N° Solicitud	</td>
			  	<td>Fecha Solicitud	</td>
			  	<td>Proyecto		</td>
			  	<td>Fotocopia		</td>
    			<td>Fecha			</td>
    			<td>Factura			</td>
    			<td>Fecha			</td>
    			<td>RUT				</td>
    			<td>Clientes		</td>
    			<td>Neto UF			</td>
    			<td>IVA	 UF			</td>
    			<td>Bruto UF		</td>
    			<td>Neto			</td>
    			<td>IVA				</td>
    			<td>Bruto			</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=mysql_query("SELECT * FROM SolFactura Where year(fechaPago) = $Agno && month(fechaPago) = $Mes Order By fechaPago Asc");
				$bdFac=mysql_query("SELECT * FROM SolFactura Order By nSolicitud Asc");
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