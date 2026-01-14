<?php
include_once("../conexionli.php");
$Agno 	= $_GET['Agno'];
$Mes 	= $_GET['Mes'];

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=AM.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>


		<table border="1" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr>
				<td colspan=9 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>
			<tr>
				<td colspan=9 height="40" style="font-size:12px; font-weight:700" align="center">
					Trabajos Terminados sin informes subidos
				</td>
			</tr>
			<tr style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25">
			  	<td>						</td>
			  	<td>AM						</td>
			  	<td width="50">Resp			</td>
    			<td width="100">Clientes	</td>
    			<td>Neto UF					</td>
    			<td>Fecha<br> RAM			</td>
    			<td>Fecha<br> PAM			</td>
    			<td>Fecha<br> AM			</td>
    			<td>Informe<br>	UP			</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' and informeUP != 'on' and Facturacion != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$tr = "#FFFFFF";
						?>
  						<tr>
							<td>
								<?php
									$imgBola = '';
									if($rowFac['informeUP'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_amarilla.png";
									}
									if($rowFac['Facturacion'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_verde.png";
									}
									if($rowFac['Archivo'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_azul.png";
									}
									if($rowFac['oCtaCte'] == 'on'){
										echo 'Cta.Cte.';
										//$tr = "#FFCC00"; //Naranja
									}
									if($imgBola){?>
										<img src="<?php echo $imgBola; ?>">
										<?php
									}
								?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
									if($rowFac['Cta']){
										echo '<br>CC';
									}
								?>
							</td>
							<td style="font-size:12px;">
								<?php
									if($rowFac['oCompra']=='on'){
										echo 'OC';
									}
									if($rowFac['oMail']=='on'){
										echo 'Mail';
									}
									if($rowFac['oCtaCte']=='on'){
										echo 'Cta.Cte';
									}
									if($rowFac['nOC']){
										echo '<br>'.$rowFac['nOC'];
									}
									echo '<br>'.$rowFac['usrResponzable'];
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
    						<td><?php echo $rowFac['BrutoUF']; 				?></td>
  					  		<td>
								<?php 
									$bdRM=$link->query("SELECT * FROM registroMuestras Where RAM = '".$rowFac['RAM']."'");
									if ($rowRM=mysqli_fetch_array($bdRM)){
										$fd = explode('-', $rowRM['fechaRegistro']);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
									}
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaInicio']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaTermino']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
    						<td>
								<?php 
									$CodInforme 	= 'AM-'.$rowFac['RAM'];
									echo '<br>';
									$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
									if($rowInf=mysqli_fetch_array($bdInf)){
										if($rowInf['informePDF']){
											if($rowInf['fechaUp'] > '0000-00-00'){
												$fd = explode('-', $rowInf['fechaUp']);
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
										}
									}
								?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>
		</table>





		
		<table border="1" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr>
				<td colspan=9 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>
			<tr>
				<td colspan=9 height="40" style="font-size:12px; font-weight:700" align="center">
					Trabajos sin HES y/o sin OC
				</td>
			</tr>
			<tr style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25">
			  	<td>						</td>
			  	<td>AM						</td>
			  	<td width="50">Resp			</td>
    			<td width="100">Clientes	</td>
    			<td>Neto UF					</td>
    			<td>Fecha<br> RAM			</td>
    			<td>Fecha<br> PAM			</td>
    			<td>Fecha<br> AM			</td>
    			<td>Informe<br>	UP			</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				$bdFac=$link->query("SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' and informeUP = 'on' and Facturacion != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc");
				if ($rowFac=mysqli_fetch_array($bdFac)){
					do{ 
						$n++;
						$tr = "#FFFFFF";
						?>
  						<tr>
							<td>
								<?php
									$imgBola = '';
									if($rowFac['informeUP'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_amarilla.png";
									}
									if($rowFac['Facturacion'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_verde.png";
									}
									if($rowFac['Archivo'] == 'on'){
										$imgBola = "http://servidorerp/erp/imagenes/bola_azul.png";
									}
									if($rowFac['oCtaCte'] == 'on'){
										echo 'Cta.Cte.';
										//$tr = "#FFCC00"; //Naranja
									}
									if($imgBola){?>
										<img src="<?php echo $imgBola; ?>">
										<?php
									}
								?>
							</td>
  					  		<td>
								<?php 
									echo 'R'.$rowFac['RAM'].'<br>';
									echo 'C'.$rowFac['CAM'];
									if($rowFac['Cta']){
										echo '<br>CC';
									}
								?>
							</td>
							<td style="font-size:12px;">
								<?php
									if($rowFac['oCompra']=='on'){
										echo 'OC';
									}
									if($rowFac['oMail']=='on'){
										echo 'Mail';
									}
									if($rowFac['oCtaCte']=='on'){
										echo 'Cta.Cte';
									}
									if($rowFac['nOC']){
										echo '<br>'.$rowFac['nOC'];
									}
									echo '<br>'.$rowFac['usrResponzable'];
								?>
							</td>
    						<td>
								<?php 
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowCli=mysqli_fetch_array($bdCli)){
										echo utf8_decode($rowCli['Cliente']);
									}
								?>
							</td>
    						<td><?php echo $rowFac['NetoUF']; 				?></td>
  					  		<td>
								<?php 
									$fd = "";
									$bdRM=$link->query("SELECT * FROM registroMuestras Where RAM = '".$rowFac['RAM']."'");
									if ($rowRM=mysqli_fetch_array($bdRM)){
										$fd = explode('-', $rowRM['fechaRegistro']);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
									}
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaInicio']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac['fechaTermino']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
    						<td>
								<?php 
									$CodInforme 	= 'AM-'.$rowFac['RAM'];
									echo '<br>';
									$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
									if($rowInf=mysqli_fetch_array($bdInf)){
										if($rowInf['informePDF']){
											if($rowInf['fechaUp'] > '0000-00-00'){
												$fd = explode('-', $rowInf['fechaUp']);
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
										}
									}
								?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysqli_fetch_array($bdFac));
				}
				$link->close();
				?>
		</table>


</body>
</html>