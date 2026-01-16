<?php
	include("conexion.php");
	$link=Conectarse();
	$bdInf=mysql_query("SELECT * FROM Informes");
	if($rowInf=mysql_fetch_array($bdInf)){
		do{
			$informePDF	= $rowInf['informePDF'];
			echo 'Entra...';
			if($informePDF){
				$nombre_archivo = "../../intranet/informes/".$informePDF;
				$fechaUp = '0000-00-00';
				if(file_exists($nombre_archivo)) {
					echo $nombre_archivo.' -> ';
					echo date("Y-m-d", filectime($nombre_archivo));
					$fechaUp = date("Y-m-d", filectime($nombre_archivo));
					echo '<br>';
	
					$actSQL="UPDATE Informes SET ";
					$actSQL.="fechaUp		='".$fechaUp."'";
					$actSQL.="WHERE CodInforme 	= '".$rowInf[CodInforme]."'";
					$bdpos=mysql_query($actSQL);
					
				}else{
					echo $nombre_archivo.' -> No Existe... <br>';
				}
			}
		}while($rowInf=mysql_fetch_array($bdInf));
	}
	mysql_close($link);
	
?>
