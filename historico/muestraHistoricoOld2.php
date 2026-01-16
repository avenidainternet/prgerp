	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script>
  		$(function() {
    		$( "#accordion" ).accordion();
  		});
  	</script>
<?php
	include_once("conexion.php");

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	if(isset($_GET['Mm'])) { 
		$Mm 			= $_GET['Mm']; 
		$PeriodoPago 	= $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm 			= $Mes[ intval($fd[1]) ];
		$PeriodoPago 	= $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	//$MesFiltro  = "Mes";
	$Situacion 	= "Estado";
	$Agno     	= date('Y');
	
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	if(isset($_GET['dBuscar'])) 	{ $dBuscar  = $_GET['dBuscar']; 	}

				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N°	</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha 			</strong></td>';
				echo '			<td  width="08%" align="center"><strong>Proyecto		</strong></td>';
				echo '			<td  width="15%" align="center"><strong>Cliente			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fotocopia		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Factura			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Monto			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Acumulado		</strong></td>';
				echo '			<td  width="15%" ><strong>Estado 						</strong></td>';
				echo '			<td  width="15%" >&nbsp;</td>';
				echo '		</tr>';
				echo '	</table>';

				$link=Conectarse();
				$bdRank=mysql_query("Delete From Rank");
				
				$bdSol=mysql_query("SELECT * FROM SolFactura Order By RutCli");
				if ($row=mysql_fetch_array($bdSol)){
					do{
						$RutCli = $row[RutCli];
						$bdRank=mysql_query("SELECT * FROM Rank Where RutCli = '".$RutCli."'");
						if($rowRank=mysql_fetch_array($bdRank)){
							$MontoTotal = $MontoTotal + $row[Bruto];
							$nSol++;
							
							$actSQL="UPDATE Rank SET ";
							$actSQL.="Ene			='".$nSol."',";
							$actSQL.="MontoTotal	='".$MontoTotal."'";
							$actSQL.="WHERE RutCli	= '".$RutCli."'";
							$bdRank=mysql_query($actSQL);
						}else{
							$nSol = 1;
							$MontoTotal = 0;
							$MontoTotal = $row[Bruto];
							mysql_query("insert into Rank(	RutCli,
															Agno,
															Ene,
															MontoTotal
														) 
												values 	(	'$RutCli',
															'$Agno',
															'$nSol',
															'$MontoTotal'
														)",$link);
						}
					}while ($row=mysql_fetch_array($bdSol));
				}
				
				echo '<div id="accordion">';
						$bdRank=mysql_query("SELECT * FROM Rank");
						if($rowRank=mysql_fetch_array($bdRank)){
							do{
								$bdPer=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowRank['RutCli']."'");
								if ($rowP=mysql_fetch_array($bdPer)){
									echo '<h3>'.$rowP[Cliente].'Total '.$rowRank[MontoTotal].'</h3>';
									echo '<div><p>';
									echo '	<table width="100%" border="0" cellpadding="0" cellspacing="0">';
											$bdSol=mysql_query("SELECT * FROM SolFactura Where RutCli = '".$rowRank['RutCli']."' Order By RutCli");
											if ($row=mysql_fetch_array($bdSol)){
												do{?>
													<tr>
														<td><?php echo 	number_format($row['Bruto'], 0, ',', '.');?></td>
													</tr>
													<?php
												}while ($row=mysql_fetch_array($bdSol));
											}
									echo '	</table>';
									echo '</p></div>';
								}
							}while ($rowRank=mysql_fetch_array($bdRank));
						}
				echo '</div>';
				mysql_close($link);
			?>
		