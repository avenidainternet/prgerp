<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$Descripcion 	= $_GET[Descripcion];
	$Observacion 	= $_GET[Observacion];
?>

<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<table width="50%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td width="264%" colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<img src="../imagenes/consultas1.png" width="50" align="middle">
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Descripción / Observaciones
						<div id="botonImagen">
							<?php 
								$prgLink = 'plataformaCotizaciones.php';
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td colspan="4" class="lineaDerBot">
			  <?php
										if($Descripcion){
											echo $Descripcion;
											if($Observacion){
												echo '<br><hr>';
												echo $Observacion;
											}
										}else{
											if(Observacion){
												echo $Observacion;
											}
										}
				?>
			  </td>
		  </tr>
		</table>
		</center>
	</div>
</div>
