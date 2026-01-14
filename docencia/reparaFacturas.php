<?php
	echo 'Inicio....<br>';
	include("conexion.php");
	$link=Conectarse();
	$bdPer=mysql_query("SELECT * FROM detSolFact Order By nSolicitud");
	if ($rowPer=mysql_fetch_array($bdPer)){
		do{
		echo 'nSolicitud....'.$rowPer['nSolicitud'].'<br>';
			$bdFac=mysql_query("SELECT * FROM SolFactura where nSolicitud = '".$rowPer['nSolicitud']."'");
			if ($rowFac=mysql_fetch_array($bdFac)){
				if($rowFac['RutCli']==0){
					$actSQL="UPDATE SolFactura SET ";
					$actSQL.="RutCli 			='".$rowPer['RutCli']."'";
					$actSQL.="WHERE nSolicitud	= '".$rowPer['nSolicitud']."'";
					$bddFac=mysql_query($actSQL);
				}
			}
		}while ($rowPer=mysql_fetch_array($bdPer));
	}
	mysql_close($link);
	echo 'Fin....';
?>