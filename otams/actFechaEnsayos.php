<?php
	echo 'Inicio...<br>';
	include_once("conexion.php");
	$link=Conectarse();
	$bdPAM=mysql_query("SELECT * FROM Cotizaciones Where Estado = 'P' or Estado = 'T' and RAM > 0");
	if($rowPAM=mysql_fetch_array($bdPAM)){
		do{
			$fechaInicio = '0000-00-00';
			$RAm = $rowPAM['RAM'];
			if($rowPAM['fechaInicio'] != '0000-00-00'){
				$fechaInicio = $rowPAM['fechaInicio'];
			}
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="fechaCreaRegistro	 	= '".$fechaInicio.	"' ";
			$actSQL.="WHERE RAM 			= '".$RAM."'";
			$bdOt=mysql_query($actSQL);
			

		}while($rowPAM=mysql_fetch_array($bdPAM));
	}
	mysql_close($link);
	echo 'Fin';
?>
