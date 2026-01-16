<?php
		$Estado 	= '';
		$Periodo	= '';

		if(isset($_GET['RutProv'])) 	{ $RutProv  	= $_GET['RutProv']; 	}
		if(isset($_GET['nFactura'])) 	{ $nFactura  	= $_GET['nFactura']; 	}
		if(isset($_GET['Periodo'])) 	{ $Periodo  	= $_GET['Periodo']; 	}
		if(isset($_POST['Guardar'])){
			if(isset($_POST['RutProv']))  	{ $RutProv   	= $_POST['RutProv']; 	}
			if(isset($_POST['nFactura'])) 	{ $nFactura  	= $_POST['nFactura']; 	}
			if(isset($_POST['Periodo'])) 	{ $Periodo  	= $_POST['Periodo']; 	}

			$FechaPago  	= "0000-00-00";
			$Estado			= ' ';
			if(isset($_POST['Estado'])) 	 { 
				if($_POST['Estado'] == 'on') 	 { 
					$Estado 	= 'P';
					if(isset($_POST['FechaPago'])) { $FechaPago  = $_POST['FechaPago']; }
				}
			}
			$link=Conectarse();
			$bdFac=$link->query("SELECT * FROM Facturas Where RutProv = '".$RutProv."' and nFactura = '".$nFactura."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE Facturas SET ";
				$actSQL.="Estado			='".$Estado."',";
				$actSQL.="FechaPago			='".$FechaPago."'";
				$actSQL.="WHERE RutProv = '".$RutProv."' and nFactura = '".$nFactura."'";
				$bdFac=$link->query($actSQL);
			}
			$link->close();
			header("Location: CalculoFacturas.php");
		}

		if(isset($_POST['Volver'])){
			header("Location: CalculoFacturas.php");
		}
		
		$link=Conectarse();
		$bdFm=$link->query("SELECT * FROM Facturas Where RutProv = '".$RutProv."' and nFactura = '".$nFactura."'");
		if ($rowFm=mysqli_fetch_array($bdFm)){
			$FechaPago 		= $rowFm['FechaPago'];
			$Estado 		= $rowFm['Estado'];
			$Descripcion 	= $rowFm['Descripcion'];
		}
		$link->close();
?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<form name="form" action="seguimientoFacturas.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="CalculoFacturas.php" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../gastos/imagenes/group_48.png" align="absmiddle">
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Seguimiento Pago con Factura
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td colspan="5" align="center" class="txtGrandeSub">
								Factura N° <?php echo $nFactura; ?><br>
								<?php
								$link=Conectarse();
								$bdPr=$link->query("SELECT * FROM Proveedores Where RutProv = '".$RutProv."'");
								if($rowPr=mysqli_fetch_array($bdPr)){
									echo $rowPr['Proveedor'];
								}
								$link->close();
								?>
								<?php echo '<span style="font-size:16px;">('.$Descripcion.')</span>'; ?><br>
								<input type="hidden" name="RutProv" 	value="<?php echo $RutProv; 	?>">
								<input type="hidden" name="nFactura" 	value="<?php echo $nFactura; ?>">
						</td>
					  </tr>
					  <tr>
						<td colspan="5"><hr></td>
					  </tr>
					  <tr>
						<td width="8%" align="center" class="numeroGrande">&nbsp;</td>
						<td width="25%" class="txtGrande">
								Cancelado</td>
						<td width="15%" align="center">
							<?php if($Estado == 'P'){ ?>
								<input name="Estado" type="checkbox" checked>
							<?php }else{ ?>
								<input name="Estado" type="checkbox">
							<?php } ?>
						</td>
						<td width="15%" align="center">&nbsp;</td>
						<td width="37%">
							<input type="date" name="FechaPago" style="font-size:18px;" value="<?php echo $FechaPago; ?>">
						</td>
					  </tr>
					<tr>
						<td colspan="5"><hr></td>
					</tr>
					  <tr>
						<td colspan="5" class="txtGrandeSub" align="right">
							<button name="Volver" style="padding:10px;" onclick="goBack()">
								<img src="../gastos/imagenes/room_48.png" width="48" height="48">
							</button>
							<button name="Guardar" style="padding:10px;">
								<img src="../gastos/imagenes/guardar.png" width="48" height="48">
							</button>
						</td>
					  </tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</form>