<?
include("conexion.php");
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
		
		<table border="1" cellpadding="0" cellspacing="0">

			<tr>
				<td colspan=9 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>

			<tr>
				<td colspan=9 height="40">&nbsp;</td>
			</tr>
			
			<tr style="color:#FFFFFF; background-color:#006699; font-size:18px;" height="25">
			  	<td>						</td>
			  	<td>AM						</td>
			  	<td>Tipo Cor<br>Resp		</td>
    			<td>Clientes				</td>
    			<td>Neto UF					</td>
<!--
    			<td>IVA	 UF					</td>
    			<td>Bruto UF				</td>
    			<td>Neto					</td>
    			<td>IVA						</td>
    			<td>Bruto					</td>
-->				
    			<td>Fecha RAM				</td>
    			<td>Fecha PAM				</td>
    			<td>Fecha AM				</td>
    			<td>Informe	UP				</td>
    			<td>Facturación				</td>
    			<td>Archivado				</td>
   			</tr>
  			<?php
				$link=Conectarse();
				$n = 0;
				//$bdFac=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc, fechaTermino Desc");
				$bdFac=mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By fechaTermino Asc, Facturacion, Archivo, informeUP, oCtaCte, oCompra Desc");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ 
						$n++;
						$tr = "#FFFFFF";
						?>
  						<tr>
							<td>
								<?php
									$imgBola = '';
									if($rowFac[informeUP] == 'on'){
										$imgBola = "http://erp.simet.cl/imagenes/bola_amarilla.png";
									}
									if($rowFac[Facturacion] == 'on'){
										$imgBola = "http://erp.simet.cl/imagenes/bola_verde.png";
									}
									if($rowFac[Archivo] == 'on'){
										$imgBola = "http://erp.simet.cl/imagenes/bola_azul.png";
									}
									if($rowFac[oCtaCte] == 'on'){
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
									if($rowFac[Cta]){
										echo '<br>CC';
									}
								?>
							</td>
							<td style="font-size:12px;">
								<?php
									if($rowFac[oCompra]=='on'){
										echo 'OC';
									}
									if($rowac[oMail]=='on'){
										echo 'Mail';
									}
									if($rowFac[oCtaCte]=='on'){
										echo 'Cta.Cte';
									}
									if($rowFac[nOC]){
										echo '<br>'.$rowFac[nOC];
									}
									echo '<br>'.$rowFac[usrResponzable];
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
    						<td><?php echo $rowFac['NetoUF']; 				?></td>
<!--
    						<td><?php echo $rowFac['IvaUF']; 				?></td>
    						<td><?php echo $rowFac['BrutoUF']; 				?></td>
    						<td><?php echo $rowFac['Neto']; 				?></td>
    						<td><?php echo $rowFac['Iva']; 					?></td>
    						<td><?php echo $rowFac['Bruto']; 				?></td>
-->
  					  		<td>
								<?php 
									$bdRM=mysql_query("SELECT * FROM registroMuestras Where RutCli = '".$rowFac['RutCli']."'");
									if ($rowRM=mysql_fetch_array($bdRM)){
										$fd = explode('-', $rowRM[fechaRegistro]);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
									}
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac[fechaInicio]);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
  					  		<td>
								<?php 
									$fd = explode('-', $rowFac[fechaTermino]);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0]; 		
								?>
							</td>
    						<td>
								<?php 
									$CodInforme 	= 'AM-'.$rowFac['RAM'];
									echo '<br>';
									$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
									if($rowInf=mysql_fetch_array($bdInf)){
										if($rowInf[informePDF]){
											if($rowInf[fechaUp] > '0000-00-00'){
												$fd = explode('-', $rowInf[fechaUp]);
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
										}
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac[Facturacion]=='on'){
										$fd = explode('-', $rowFac[fechaFacturacion]);
										echo $fd[2].'/'.$fd[1]; 		
									}
								?>
							</td>
    						<td>
								<?php 
									if($rowFac[Archivo]=='on'){
										echo 'OK';
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