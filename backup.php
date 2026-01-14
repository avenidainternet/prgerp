<?php
	include("conexion.php");
	include("conexionBak.php");
	echo 'Inicio Respaldo... <br>';
	$link	= Conectarse();
	$linkBak= ConectarseBak();
	$result  = mysql_query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && nInforme > 0  && IdProyecto = 'IGT-1118'");
	if($row=mysql_fetch_array($result)){
		do{
			$Run 			= $row[Run];
			$PeriodoPago 	= $row[PeriodoPago];
			echo 'Rut : '.$Run.'<br>';
			mysql_query("insert into honorarios(	Run,
													PeriodoPago
												) 
									values 		(	'$Run',
													'$PeriodoPago'
												)",$linkBak);
		}while ($row=mysql_fetch_array($result));
	}
	mysql_close($linkBak);
	mysql_close($link);
	echo 'Termino Respaldo...<br>';
?>