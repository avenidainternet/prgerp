<?php
include_once("../conexionli.php");
//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SolicitudesFacturas.xls");
$fechaHoy = date('Y-m-d');
$fd = explode('-',$fechaHoy);
$RutCli 	= '';
$Agno		= date('Y') -1;
$AgnoHasta	= date('Y');

if(isset($_GET['RutCli']))		{ $RutCli		= $_GET['RutCli']; 		}
if(isset($_GET['Agno']))		{ $Agno			= $_GET['Agno']; 		}
if(isset($_GET['AgnoHasta']))	{ $AgnoHasta	= $_GET['AgnoHasta']; 	}

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
				$filtro = " year(fechaSolicitud) >= '".$Agno."' and year(fechaSolicitud) <= '".$AgnoHasta."'";
				if($RutCli){ $filtro .= " and RutCli = $RutCli "; }
				$sql = "SELECT * FROM solfactura Where $filtro Order By nSolicitud Asc";
				$totales = array(0,0,0,0,0,0);
				$bdFac=$link->query($sql);
				while($rowFac=mysqli_fetch_array($bdFac)){
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
    						<td>
								<?php 
									if($rowFac['netoUF'] > 0){
										echo number_format($rowFac['netoUF'], 2, ',', '.'); 				
										$totales[0] += $rowFac['netoUF'];
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['ivaUF'] > 0){
										echo number_format($rowFac['ivaUF'], 2, ',', '.'); 				
										$totales[1] += $rowFac['ivaUF'];
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['brutoUF'] > 0){
										echo number_format($rowFac['brutoUF'], 2, ',', '.'); 				
										$totales[2] += $rowFac['brutoUF'];
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['Neto'] > 0){
										echo number_format($rowFac['Neto'], 0, ',', '.'); 				
										$totales[3] += $rowFac['Neto'];
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['Iva'] > 0){
										echo number_format($rowFac['Iva'], 0, ',', '.'); 					
										$totales[4] += $rowFac['Iva'];
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac['Bruto'] > 0){
										echo number_format($rowFac['Bruto'], 0, ',', '.'); 				
										$totales[5] += $rowFac['Bruto'];
									}
								?>
							</td>
   						</tr>
						<?php
				}?>
  						<tr>
  					  		<td></td>
  					  		<td></td>
  					  		<td></td>
  					  		<td></td>
  					  		<td></td>
  					  		<td></td>
  					  		<td></td>
    						<td></td>
    						<td></td>
    						<td><?php 
									echo number_format($totales[0], 2, ',', '.'); 				
								?>
							</td>
    						<td>
								<?php 
									echo number_format($totales[1], 2, ',', '.'); 				
								?>
							</td>
    						<td>
								<?php 
									echo number_format($totales[2], 2, ',', '.'); 				
								?>
							</td>
    						<td>
								<?php 
									echo number_format($totales[3], 0, ',', '.'); 				
								?>
							</td>
    						<td>
								<?php 
									echo number_format($totales[4], 0, ',', '.'); 					
								?>
							</td>
    						<td>
								<?php 
									echo number_format($totales[5], 0, ',', '.'); 				
								?>
							</td>
   						</tr>
					<?php
				$link->close();
				?>
		</table>
</body>
</html>