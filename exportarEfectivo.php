<?php
include_once("conexionli.php");

	if(isset($_GET['IdProyecto'])) 		{	$IdProyecto = $_GET['IdProyecto']; 		}
	if(isset($_GET['mesCpra'])) 		{	$mesCpra 	= $_GET['mesCpra']; 		}
	if(isset($_GET['ageCpra'])) 		{	$ageCpra 	= $_GET['ageCpra']; 		}
	if(isset($_GET['periodo'])) 		{	$periodo 	= $_GET['periodo']; 		}

				$filtro = "efectivo = 'on' and year(FechaGasto) = '$ageCpra'";
				if(isset($IdProyecto)){
					$filtro .= " and IdProyecto = '$IdProyecto' ";
				}
				if(isset($mesCpra)){
					$filtro .= " and month(FechaGasto) = '$mesCpra' ";
				}

				$SQL = "SELECT * FROM movgastos Where $filtro Order By FechaGasto Asc";


//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=efectivo.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan=7 height="40" style="font-size:12px; font-weight:700" align="center">	FACTURAS EFECTIVAS AL <?php echo date('Y-m-d');; ?>
				</th>
			</tr>
			<tr>
			  	<th style="color:#FFFFFF; background-color:#006699; font-size:14px;" height="40">
			  	 #						
			  	</th>
			  	<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
			  	 FACTURA					
			  	</th>
			  	<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
			  	 Fecha		
			  	</th>
    			<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
    			 Proveedor	
    			</th>
    			<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
    			 Neto 					
    			</th>
    			<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
    			 Iva					
    			</th>
    			<th style="color:#FFFFFF; background-color:#006699; font-size:14px;">
    			 Total					
    			</th>
   			</tr>
		</thead>
		<tbody>
  			<?php
				$link=Conectarse();
				$n 		= 0;
				$Neto 	= 0;
				$Iva	= 0;
				$Bruto	= 0;
				//$filtro = "efectivo = 'on' and year(FechaGasto) = '$ageCpra'";
				$filtro = " year(FechaGasto) = '$ageCpra'";
				if(isset($IdProyecto)){
					$filtro .= " and IdProyecto = '$IdProyecto' ";
				}
				if(isset($mesCpra)){
					$filtro .= " and month(FechaGasto) = '$mesCpra' ";
				}

				$SQL = "SELECT * FROM movgastos Where $filtro Order By FechaGasto Asc";
				$bdFac=$link->query($SQL);
				while ($rowFac=mysqli_fetch_array($bdFac)){
						$n++;
						$tr = "#FFFFFF";
						?>
  						<tr>
							<td>
								<?php echo $n; ?>
							</td>
  					  		<td>
								<?php echo $rowFac['nDoc']; ?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['FechaGasto']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
    						<td>
								<?php echo $rowFac['Proveedor']; ?>
							</td>
    						<td><?php echo $rowFac['Neto'];  $Neto += $rowFac['Neto']; 		?></td>
    						<td><?php echo $rowFac['Iva'];   $Iva  += $rowFac['Iva'];   	?></td>
    						<td><?php echo $rowFac['Bruto']; $Bruto += $rowFac['Bruto']; 	?></td>
   						</tr>
						<?php
				}
				$link->close();
				?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25"><?php echo $Neto;?> 
					</td>
					<td style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25"><?php echo $Iva;?>
					</td>
					<td style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25"><?php echo $Bruto;?>
					</td>
				</tr>
			</tfoot>
		</table>


</body>
</html>