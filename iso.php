<?php
	include("conexion.php");
	echo 'Inicio Respaldo... <br>';
	$link	= Conectarse();
	$result  = mysql_query("SELECT * FROM Cotizaciones");
	if($row=mysql_fetch_array($result)){
		do{
			if($row['Atencion']){
				$CAM = $row['CAM'];
				$Obs = str_replace('ÃƒÂ¡','á',$row['Atencion']);
				$Obs = str_replace('ÃƒÂ³','é',$Obs);
				$Obs = str_replace('ÃƒÂ','í',$Obs);
				$Obs = str_replace('ÃƒÂ³','ó',$Obs);
				$Obs = str_replace('ÃƒÂº','ú',$Obs);
				$Obs = str_replace('ÃƒÂ±','ñ',$Obs);
				$Obs = str_replace('º','ú',$Obs);
				$Obs = str_replace('í±','ñ',$Obs);
				//echo 'Observacion : '.str_replace('ÃƒÂ¡','á',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('ÃƒÂ³','é',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('ÃƒÂ','í',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('ÃƒÂ³','ó',$row['Observacion']).'<br>';
				//echo 'Observacion : '.str_replace('ÃƒÂº','ú',$row['Observacion']).'<br>';
/*
				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="Atencion	= '".$Obs."'";
				$actSQL.="WHERE CAM 	= '".$CAM."'";
				$bdInf=mysql_query($actSQL);
*/
				//echo 'Observacion : '.$Obs.'<br>';
				echo 'Observacion : '.$row['Atencion'].'<br>';
			}
		}while ($row=mysql_fetch_array($result));
	}
	mysql_close($link);
	echo 'Termino ...<br>';
?>