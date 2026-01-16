<?php
include_once("conexion.php");

//$Agno 	= $_GET['Agno'];
//$Mes 	= $_GET['Mes'];

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=RAM.xls");

?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
		
		<table border="1" cellpadding="0" cellspacing="0">

			<tr>
				<td colspan=11 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>

			<tr style="color:#FFFFFF; background-color:#006699; font-size:18px;" height="25">
			  	<td>RAM<br>CAM				</td>
			  	<td>Fecha RAM				</td>
			  	<td>Responsable				</td>
    			<td colspan=3>Clientes		</td>
    			<td>Contacto				</td>
    			<td colspan=3>Descripción	</td>
    			<td>Situación				</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=mysql_query("SELECT * FROM registroMuestras Where RAM > 0 and situacionMuestra != 'B' Order By RAM Desc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++;
						if($rowFac['situacionMuestra']=='B'){
							if($rowFac['CAM']>0){
								$tr = "#009966";
							}else{
								$tr = "#0099CC";
							}
						}
						if($rowFac['situacionMuestra']=='R'){
							$tr = "#FF0000";
						}
						if($rowFac['situacionMuestra']=='P'){
							$tr = "#009966";
						}
						?>
						<tr bgcolor="<?php echo $tr; ?>">
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaRegistro']);
									echo $fd[2].'/'.$fd[1]; 		
								?>
							</td>
  					  		<td><?php echo $rowFac['usrRecepcion']; 		?></td>
    						<td colspan=3>
								<?php 
									$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}
								?>
							</td>
    						<td><?php echo $rowFac['nContacto']; 			?></td>
    						<td colspan=3>
								<?php echo $rowFac['Descripcion']; 			?>
							</td>
    						<td>
								<?php 
									if($rowFac['situacionMuestra']=='B'){
										if($rowFac['CAM']>0){
											echo 'Asignado';
										}else{
											echo 'De Baja';
										}
									}
									if($rowFac['situacionMuestra']=='R'){
										echo 'Recepcionado';
									}
									if($rowFac['situacionMuestra']=='P'){
										echo 'Asignado';
									}
								?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>

				
			<tr>
				<td colspan=10 height="40">&nbsp;</td>
			</tr>

		</table>
</body>
</html>