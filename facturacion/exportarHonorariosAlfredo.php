<?php
include_once("../conexionli.php");
if(isset($_GET['Agno'])) 	{ $Agno 	= $_GET['Agno'];}
if(isset($_GET['Mes']))		{ $Mes 		= $_GET['Mes'];	}

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Honorarios.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportación de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan=9 height="40" align="center"><span style="font-size:18px;">INFORME DE Honorarios</span></td>
			</tr>

			<tr>
				<td colspan=9 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>


			<tr>
				<td colspan=9 height="30" style="color:#FFFFFF; background-color:#006699; font-size:18px;">Boletas Honorarios</td>
			</tr>
			<tr style="font-weight:700; font-size:12px;" height="25">
			  	<td>Fecha<br> Boleta				</td>
			  	<td>Proyecto						</td>
    			<td>Boleta							</td>
    			<td>RUT								</td>
    			<td>Nombres						    </td>
    			<td>Total							</td>
    			<td>Retención							</td>
    			<td>Liquido							</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=$link->query("SELECT * FROM honorarios Where fechaContrato >= '2020-01-01' and fechaContrato <=  '2025-10-30' and IdProyecto = 'IGT-1118' Order By fechaContrato Asc");
				if($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$bdCli=$link->query("SELECT * FROM personalhonorarios Where Run = '".$rowFac['Run']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							?>
							<tr>
								<td align="justify"><?php echo $rowFac['fechaContrato']; 			?></td>
								<td><?php echo $rowFac['IdProyecto']; 			                    ?></td>
								<td><?php echo $rowFac['nBoleta']; 		                            ?></td>
								<td><?php echo $rowFac['Run']; 			                            ?></td>
								<td><?php echo $rowCli['Paterno'].' '.$rowCli['Materno'].' '.$rowCli['Nombres']; 			                        ?></td>
								<td><?php echo number_format($rowFac['Total'], 0, ',', '.'); 	    ?></td>
								<td><?php echo number_format($rowFac['Retencion'], 0, ',', '.'); 	?></td>
								<td><?php echo number_format($rowFac['Liquido'], 0, ',', '.'); 	    ?></td>
   							</tr>
							<?php
						}
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>

				
		
				</table>
</body>
</html>