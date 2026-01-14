<style>
#tablaEst{
	text-align		:center; 
	font-family		:Arial, Helvetica, sans-serif;
}
#tablaEst .titEst{
	background-color: #006699;
	color			: #FFFFFF;
	height			: 50px;
	border-bottom	:2px solid #000;
}
#tablaEst .titEst>td{
	border:1px solid #000;
}
#tablaEst .detEst{
	background-color: #CCCCCC;
	color			: #000;
	height			: 30px;
}
#tablaEst .detEst>td{
	border			: 1px solid #fff;
}
#tablaEst .izqMes{
	float:left;
	padding-left:5px;
}
#tablaEst .izqMes:hover{
     width: 0; 
     height: 0; 
     border-left: 25px solid #f0ad4e;
     border-top: 12px solid transparent;
     border-bottom: 12px solid transparent;
	 float:right;
}

</style>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" id="tablaEst">
	<tr class="titEst">
    	<td width="25%" rowspan="2">Mes</td>
		<?php 
			$sTotales = array(0,0,0,0,0,0,0);
			for($a=$agnoDesde; $a<=$AgnoTabla; $a++){?>
    			<td colspan="2"><?php echo $a; ?></td>
			<?php
			}
		?>
  	</tr>
	<tr class="titEst">
    	<td width="12%">Ventas</td>
    	<td width="13%">Productividad</td>
    	<td width="12%">Ventas</td>
    	<td width="13%">Productividad</td>
    	<td width="12%">Ventas</td>
    	<td width="13%">Productividad</td>
  	</tr>
	<?php
		$fechaHoy = date('Y-m-d');
		$fd = explode('-',$fechaHoy);
		$prAgno = $agnoDesde;
		$sgAgno	= $agnoDesde + 1;
		$trAgno	= $agnoDesde + 2;
		$sVtas = array(
						$prAgno => 0, 
						$sgAgno => 0,
						$trAgno => 0
					);
	
		$sProd = array(
						$prAgno => 0, 
						$sgAgno => 0,
						$trAgno => 0
					);
		for($m=1; $m<=12; $m++){?>
			<tr class="detEst">
				<td><span class="izqMes"><?php echo $Mes[$m]; ?></span></td>
				<?php
					for($a=$agnoDesde; $a<=$AgnoTabla; $a++){
						$link=Conectarse();
						$bd=$link->query("SELECT * FROM tabindices Where month(fechaIndice) = '".$m."' and year(fechaIndice) = '".$a."' Order By fechaIndice Desc");
						if($row=mysqli_fetch_array($bd)){
						}
						if($fd[0] == $a and $fd[1] == $m){
						}else{
						}
						if(!empty($row['indVtas'])){
							$sVtas[$a] += $row['indVtas'];
						}
						if(!empty($row['iProductividad'])){
							$sProd[$a] += $row['iProductividad'];
						}
							

						?>
						<td>
							<?php 
								if(!empty($row['indVtas'])){
									echo $row['indVtas'];
								}
							?>
						</td>
						<td>
							<?php 
								if(!empty($row['iProductividad'])){
									echo $row['iProductividad']; 
								}
							?>
						</td>
						<?php
					}
				?>
			</tr>
		<?php
		}
	?>
  	<tr>
    	<td>&nbsp;</td>
    	<td><?php echo $sVtas[$prAgno]; ?></td>
    	<td><?php echo $sProd[$prAgno]; ?></td>
    	<td><?php echo $sVtas[$sgAgno]; ?></td>
    	<td><?php echo $sProd[$sgAgno]; ?></td>
    	<td><?php echo $sVtas[$trAgno]; ?></td>
  	    <td><?php echo $sProd[$trAgno]; ?></td>
  	</tr>
</table>
