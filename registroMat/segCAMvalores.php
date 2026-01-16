<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$Rev 	= 0;
	$CAM 	= $_GET[CAM];
	$RAM 	= $_GET[RAM];
	$Rev 	= $_GET[Rev];
	$Cta 	= $_GET[Cta];
	$accion = $_GET[accion];
	$Estado = '';
	$fechaCotizacion = date('Y-m-d');
	$encNew = 'Si';

	if($CAM == 0){
		$accion 	= 'Guardar';
		$Atencion 	= 'Seleccionar';
	}else{
		$link=Conectarse();
		$bdCot=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$Rev 		= $rowCot[Rev];
			$Cta 		= $rowCot[Cta];
			$valorUF 	= $rowCot[valorUF];
			$fechaUF	= $rowCot[fechaUF];
			$Cliente	= $rowCot[RutCli];
			$Atencion	= $rowCot[Atencion];
			$Moneda		= $rowCot[Moneda];
		}
		mysql_close($link);
		$encNew = 'No';
	}
	$Moneda = 'U';
	if($accion == 'Pesos'){
		$Moneda = 'P';
	}
?>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>


<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="modCotizacion.php" method="post">
		<table width="50%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
			<tr>
				<td colspan="4" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
					<?php 
						if($accion == 'Pesos'){?>
							<img src="../imagenes/pesos.png" width="50" align="middle">
							<?php
						}else{?>
							<img src="../imagenes/uf.png" width="50" align="middle">
							<?php
						}
					?>
					<span style="color:#FFFFFF; font-size:18px; font-weight:700;">
						Mostrar CAM en <?php echo $accion; ?>
						<?php 
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
						?>
						<div id="botonImagen">
							<?php 
								$prgLink = 'modCotizacion.php?CAM='.$CAM.'&Rev='.$Rev.'&Cta='.$Cta;
								echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
							?>
						</div>
					</span>
				</td>
			</tr>
			<tr>
			  <td colspan="4" class="lineaDerBot">
			  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
					CAM-<?php echo $CAM.' Rev. '.$Revision; ?>
					<?php
					if($Cta > 0){
						echo 'Cta.Cte.';
					}
					?>
					<input name="CAM" 	 	id="CAM" 	 type="hidden" value="<?php echo $CAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" readonly />
					<input name="accion" 	id="accion"  type="hidden" value="<?php echo $accion; ?>">
	                <input  name="Cta"   	id="Cta" 	 type="hidden" value="<?php echo $Cta; ?>" size="2" maxlength="2" />
	                <input  name="Rev"   	id="Rev" 	 type="hidden" value="<?php echo $Rev; ?>" size="2" maxlength="2" />
	                <input  name="Moneda"   id="Moneda"  type="hidden" value="<?php echo $Moneda; ?>" />
				</strong>
			  </td>
		  </tr>
			<tr>
				<td height="27" colspan="2" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Empresa / Cliente </td>
				<td width="58%" bordercolor="#FFFFFF" bgcolor="#0099CC" class="lineaDerBot">Atenci&oacute;n:</td>
				<td width="3%" rowspan="5" class="lineaBot">&nbsp;		  		</td>
		    </tr>
			<tr>
				<td height="30" colspan="2" class="lineaDerBot">
					<span>					</span>
			        <?php
						$link=Conectarse();
						$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$Cliente."'");
						if($rowCli=mysql_fetch_array($bdCli)){
							echo '<span style="font-size:14px; font-weight:700;">'.$rowCli[Cliente].'</span>';
						}
						mysql_close($link);
					?>
				</td>
				<td class="lineaDerBot"><?php echo '<span style="font-size:14px; font-weight:700;">'.$Atencion.'</span>'; ?></td>
			</tr>
			<tr>
				<td height="32" colspan="3" bgcolor="#0099CC" class="lineaDerBot Estilo1">Indicador...</td>
			</tr>
			<tr>
			  <td width="29%" height="29" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Fecha UF Referencia </strong></td>
			  <td colspan="2" valign="top" bgcolor="#CCCCCC" class="lineaDerBot"><strong>Valor UF </strong><strong><!-- 					<input name="Atencion" 		id="Atencion" 		type="text" size="50" value="<?php echo $Atencion; ?>" 		style="font-size:12px; font-weight:700;"> -->    			  
              </strong></td>
		    </tr>
			<tr>
			  <td height="38" valign="top" class="lineaDerBot">
			    	<input name="fechaUF" 	id="fechaUF" type="date"  value="<?php echo $fechaUF; ?>" style="font-size:12px; font-weight:700;" autofocus />
		  	  </td>
				<td colspan="2" valign="top" class="lineaDerBot"><span class="lineaBot">
                 	<input name="valorUF" 	id="valorUF" type="text" size="10" maxlength="10"  value="<?php echo $valorUF; ?>" style="font-size:12px; font-weight:700;" placeholder="UF (99999.99)...">
				</td>
			</tr>
		  <tr>
				<td colspan="4" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Pesos' or $accion == 'UF'){?>
							<div id="botonImagen">
								<button name="guardarValorUF" style="float:right;">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		</form>
		</center>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
