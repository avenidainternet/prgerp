<?php
	include_once("../conexionli.php");

	if(isset($_GET['CodInforme'])) 			{ $CodInforme 			= $_GET['CodInforme']; 			}
	if(isset($_GET['RutCli'])) 				{ $RutCli 				= $_GET['RutCli']; 				}
	if(isset($_GET['CodigoVerificacion'])) 	{ $CodigoVerificacion 	= $_GET['CodigoVerificacion'];	}

	if($CodInforme){
		$directorio="../../intranet/informes";
		$link=Conectarse();
		$bdInf=$link->query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if ($rowInf=mysqli_fetch_array($bdInf)){
			$informePDF	= $rowInf['informePDF'];
			chmod($directorio.'/'.$informePDF, 0755);
	
			$id = $rowInf[informePDF];
			$path_a_tu_doc = $directorio;
			$enlace = $path_a_tu_doc."/".$id; 
			header ("Content-Disposition: attachment; filename=".$id." "); 
			header ("Content-Type: application/octet-stream");
			header ("Content-Length: ".filesize($enlace));
			readfile($enlace);
	
			chmod($directorio.'/'.$informePDF, 0400);
		}
		$link->close();
	}
	
?>
