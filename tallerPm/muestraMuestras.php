<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET[CAM]))  		{ $CAM		= $_GET[CAM]; 		}
	if(isset($_GET[RAM]))  		{ $RAM		= $_GET[RAM]; 		}
	if(isset($_GET[dBuscar]))  	{ $dBuscar  = $_GET[dBuscar]; 	}
	if(isset($_GET[accion]))  	{ $accion	= $_GET[accion]; 	}
?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td  width="08%" align="center" height="40"><strong>Id.SIMET				</strong></td>
			<td  width="50%" align="center">			<strong>Identificación Cliente 	</strong></td>
			<td  width="10%">							<strong>Serv.<br>Taller 		</strong></td>
			<td  width="20%">							<strong>OTAMs 					</strong></td>
			<td  width="12%" align="center" colspan="3"><strong>Acciones				</strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
		<?php
		$link=Conectarse();
		$filtroSQL .= " idItem Like '%".$RAM."%'";
		
		$SQL = "SELECT * FROM amMuestras Where $filtroSQL Order By idItem";
		
		$bdfRAM=mysql_query($SQL);
		if($rowfRAM=mysql_fetch_array($bdfRAM)){
			do{
				$tr = "bBlanca";
				if($rowfRAM[idMuestra] !=''){
					$tr = 'bAmarilla';
					
					$bdOT=mysql_query("SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."'");
					if($rowOT=mysql_fetch_array($bdOT)){
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and tpMuestra = ''";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tBl 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion
						if($tBl == 0){
							$tr = "bVerde";
						}
					}else{
						$tr = "bRoja";
					}
					
				}
				echo '<tr id="'.$tr.'">';
				echo '	<td width="06%" style="font-size:16px;"  align="center">';
							echo $rowfRAM[idItem];
				echo '	</td>';
				echo '	<td width="50%" style="font-size:16px;">';
							echo $rowfRAM[idMuestra];
				echo '	</td>';
				echo '	<td width="10%" style="font-size:16px;">';
							if($rowfRAM[Taller] == 'on'){
								$bdCot=mysql_query("Select * From formRAM Where RAM = '".$RAM."'");
								if($rowCot=mysql_fetch_array($bdCot)){
									echo $rowCot[nSolTaller];
								}
							}
				echo '	</td>';
				echo '	<td width="20%" style="font-size:16px;">';

						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tOtams 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						$OT_Tr = $RAM.'-T';
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and Otam Like '%".$OT_Tr."%'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tTrac 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						$OT_Q = $RAM.'-Q';
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and Otam Like '%".$OT_Q."%'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tQuim 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						$OT_Ch = $RAM.'-Ch';
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and Otam Like '%".$OT_Ch."%'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tChar 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						$OT_D = $RAM.'-D';
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and Otam Like '%".$OT_D."%'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tDure 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						$OT_O = $RAM.'-O';
						$sqlOtams	= "SELECT * FROM OTAMs Where idItem = '".$rowfRAM[idItem]."' and Otam Like '%".$OT_O."%'";  // sentencia sql
						$result 	= mysql_query($sqlOtams);
						$tOtra 	= mysql_num_rows($result); // obtenemos el número de Otams Traccion

						if($tOtams>0){
							echo ' Tr = '.$tTrac.' Q = '.$tQuim.' Ch = '.$tChar.' D = '.$tDure.' O = '.$tOtra;
						}
						
				echo '	</td>';
				echo '	<td width="6%">';
							echo '<a href="idMuestras.php?accion=Editar&RAM='.$RAM.'&idItem='.$rowfRAM[idItem].'"	><img src="../imagenes/actividades.png" 	width="50" title="Identificar Muestra y Definir Ensayos"	>	</a>';
				echo '	</td>';
				echo '	<td width="6%">';
							if($tOtams>0){
								echo '<a href="idOtams.php?accion=Muesta&RAM='.$RAM.'&idItem='.$rowfRAM[idItem].'"	><img src="../imagenes/OTAM.png"   	width="50" title="OTAMs"	>	</a></td>';
							}
				echo '</tr>';
			}while($rowfRAM=mysql_fetch_array($bdfRAM));
		}
		mysql_close($link);
		?>
	</table>
</div>
