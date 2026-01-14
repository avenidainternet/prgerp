<?php
	date_default_timezone_set("America/Santiago");
	include_once("inc/funciones.php");
	include_once("conexionli.php");
	
	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy); 
	$Periodo = $fp[1].'-'.$fp[0];
	
	$hrespaldo = 'new';
	$respaldar = true;


	//echo $horaAct;
	$respaldar = true;
	if($respaldar == true) {
		//echo $horaAct.' Entra';
		$fd = explode('-', $fechaHoy);
		$carpetaRespaldo = 'z:backup-'.$fd[2].'-'.$fd[1].'-'.$fd[0].'-'.$hrespaldo.'Hrs';

		if(!file_exists($carpetaRespaldo)) {
			mkdir($carpetaRespaldo, 0777, true);
		}else{

		}
		$link=Conectarse();
		$tables = array();
		$result = $link->query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
		foreach($tables as $table){
			$return = '';
			$result = $link->query('SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE '.$table));
			$return = 'DELETE FROM '.$table.' WHERE 1';
			$return.= ";\n";
			for ($i = 0; $i < $num_fields; $i++){
				while($row = mysqli_fetch_row($result)){
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++){
						//$row[$j] = utf8_decode($row[$j]);
						$row[$j] = ($row[$j]);
						$row[$j] = str_replace("'","Â´",$row[$j]);
						$row[$j] = str_replace("0000-00-00","/*NULL*/",$row[$j]);

						if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$ficheroRespaldo = $carpetaRespaldo.'/'.$table.'.sql';
			$archivoBackup	= $ficheroRespaldo;
			$handle = fopen($ficheroRespaldo,'w+');
			fwrite($handle,$return);
			fclose($handle);
		}

		$link->close();

		
	}
?>
