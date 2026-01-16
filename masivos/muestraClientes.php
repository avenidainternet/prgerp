	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("../conexionli.php");
	$Marcar  = '';
	$dBuscar = '';
	if(isset($_GET['Marcar']))  { $Marcar  	= $_GET['Marcar']; 	}
	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; }
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40"><strong>RUT				</strong></td>';
				echo '			<td  width="40%">							<strong>Clientes		</strong></td>';
				echo '			<td  width="40%">							<strong>Emails			</strong></td>';
				echo '			<td  width="10%">';
				echo '				<strong>';
										if($Marcar=='on' or $Marcar == ''){?>
											<input name="Marcar" id="Marcar" type="checkbox" checked value="off" onClick="realizaProceso($('#dBuscar').val(),$('#Marcar').val())">
										<?php
										}else{
										?>
											<input name="Marcar" id="Marcar" type="checkbox"  		 value="on" onClick="realizaProceso($('#dBuscar').val(),$('#Marcar').val())">
										<?php
										}
				echo '				</strong>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=$link->query("SELECT * FROM Clientes Where Estado != 'off' and cFree != 'on' and Docencia != 'on' and Cliente Like '%".$dBuscar."%' Order By Cliente");
				}else{
					$bdEnc=$link->query("SELECT * FROM Clientes Where cFree != 'on' or Docencia != 'on' and Estado != 'off' Order By Cliente");
				}
				if($row=mysqli_fetch_array($bdEnc)){
					do{
						$tr = 'barraVerde';
						$Correos = '';
							echo '<tr id="'.$tr.'">';
							echo '	<td width="10%" style="font-size:16px;">';
							echo		$row['RutCli'];
							echo '	</td>';
							echo '	<td width="40%" style="font-size:20px;">'.$row['Cliente'].'</td>';
							echo '	<td width="40%">';
										echo '<strong style="font-size:20px;">'.$Correos.'</strong>';
							echo ' 	</td>';
							echo '	<td width="10%">';
										if($Marcar=='on' or $Marcar == ''){
											echo '<input name="Reg[]" id="Reg" style="font-size:20px;" type="checkbox" value="'.$row['RutCli'].'" title="Seleccionar" checked>';
										}else{
											echo '<input name="Reg[]" id="Reg" style="font-size:20px;" type="checkbox" value="'.$row['RutCli'].'" title="Seleccionar">';
										}
							echo '	</td>';
							echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>
