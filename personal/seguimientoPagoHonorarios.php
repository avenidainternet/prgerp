<?php
		$Cancelado 	= '';
		$Periodo	= '';

		if(isset($_GET['Run'])) 		{ $Run   	= $_GET['Run']; 		}
		if(isset($_GET['nBoleta'])) 	{ $nBoleta  = $_GET['nBoleta']; 	}
		if(isset($_GET['Periodo'])) 	{ $Periodo  = $_GET['Periodo']; 	}
		
		if(isset($_POST['Guardar'])){
			if(isset($_POST['Run']))  		{ $Run   	= $_POST['Run']; 		}
			if(isset($_POST['nBoleta'])) 	{ $nBoleta  = $_POST['nBoleta']; 	}
			if(isset($_POST['Periodo'])) 	{ $Periodo  = $_POST['Periodo']; 	}

			if(isset($_POST['Cancelado'])) 	 { 
				$Cancelado   = $_POST['Cancelado']; 		
				$Estado 	= 'P';
				if(isset($_POST['fechaCancelacion'])) { $fechaCancelacion  = $_POST['fechaCancelacion']; }
			}else{
				$fechaCancelacion  	= "0000-00-00";
				$Estado				= ' ';
			}

			$link=Conectarse();
			$bdFac=$link->query("SELECT * FROM Honorarios Where Run = '".$Run."' && nBoleta = '".$nBoleta."'");
			if ($rowFac=mysqli_fetch_array($bdFac)){
				$actSQL="UPDATE Honorarios SET ";
				$actSQL.="Estado			='".$Estado."',";
				$actSQL.="Cancelado			='".$Cancelado."',";
				$actSQL.="fechaCancelacion	='".$fechaCancelacion."'";
				$actSQL.="WHERE Run = '".$Run."' && nBoleta = '".$nBoleta."'";
				$bdFac=$link->query($actSQL);
			}
			$link->close();
		}
		
		$link=Conectarse();
		$bdFm=$link->query("SELECT * FROM Honorarios Where Run = '".$Run."' && nBoleta = '".$nBoleta."'");
		if ($rowFm=mysqli_fetch_array($bdFm)){
			$Cancelado 			= $rowFm['Cancelado'];
			$fechaCancelacion 	= $rowFm['fechaCancelacion'];
			$Descripcion 		= $rowFm['Descripcion'];
		}
		$bdPh=$link->query("SELECT * FROM PersonalHonorarios Where Run = '".$Run."'");
		if ($rowPh=mysqli_fetch_array($bdPh)){
			$Paterno 	= $rowPh['Paterno'];
			$Materno 	= $rowPh['Materno'];
			$Nombres 	= $rowPh['Nombres'];
		}
		$link->close();
?>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<form name="form" action="seguimientoHonorarios.php" method="post">
	<table width="60%"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<div id="CuerpoEncuesta">
					<div id="ImagenBarra">
						<a href="CalculoHonorarios.php" title="Cerrar">
							<img src="../gastos/imagenes/no_32.png" width="24" height="24">
						</a>
					</div>
					<div id="titulocaja">
						<img src="../gastos/imagenes/group_48.png" align="absmiddle">
						<strong style="font-size:20px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF;">
							Control de Seguimiento Honorarios
						</strong>
					</div>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td colspan="5" align="center" class="txtGrandeSub">
								Boleta N° <?php echo $nBoleta; ?><br>
								<?php echo $Nombres.' '.$Paterno.' '.$Materno; ?><br>
								<?php echo '<span style="font-size:16px;">('.$Descripcion.')</span>'; ?><br>
								<input type="hidden" name="Run" 		style="font-size:18px;" value="<?php echo $Run; 	?>">
								<input type="hidden" name="nBoleta" 	style="font-size:18px;" value="<?php echo $nBoleta; ?>">
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
							<?php if($Cancelado == 'on'){ ?>
								<input name="Cancelado" type="checkbox" checked>
							<?php }else{ ?>
								<input name="Cancelado" type="checkbox">
							<?php } ?>
						</td>
						<td width="15%" align="center">&nbsp;</td>
						<td width="37%">
							<input type="date" name="fechaCancelacion" style="font-size:18px;" value="<?php echo $fechaCancelacion; ?>">
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