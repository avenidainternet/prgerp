<?php
	date_default_timezone_set("America/Santiago");
	include_once("conexion.php");
	$link=Conectarse();
	$fechaHoy = date('Y-m-d');
	$horaSalida = date('H:i:s');
	$bdCtl  = mysql_query("SELECT * FROM relojControl Where usr = '10074437' and fecha = '".$fechaHoy."'");
	if($rowCtl=mysql_fetch_array($bdCtl)){
		$hi = explode(':',$rowCtl['horaIngreso']);
		echo $hi[0].'<br>';
		echo $hi[1].'<br>';
		echo $hi[2].'<br><br>';

		$hs = explode(':',$horaSalida);
		echo $hs[0].'<br>';
		echo $hs[1].'<br>';
		echo $hs[2].'<br><br>';
		
		$thd = $hs[0] - $hi[0];
		$tmd = $hs[1] + $hi[1];
		if($tmd > 60){
			$tmd = $tmd - 60;
			$thd++;
		}
		$tsd = $hs[2] + $hi[2];
		if($tsd > 60){
			$tsd = $tsd - 60;
			$tmd++;
		}
		if($thd < 10){ $thd = '0'.$thd; }
		if($tmd < 10){ $tmd = '0'.$tmd; }
		if($tsd < 10){ $tsd = '0'.$tsd; }
		
		$td = $thd.':'.$tmd.':'.$tsd;
		echo 'Total '.$td;
		
		$actSQL="UPDATE relojControl SET ";
		$actSQL.="horaSalida	= '".$horaSalida."',";
		$actSQL.="diferencia	= '".$td."',";
		$actSQL.="horasDia		= '".$td."'";
		$actSQL.="WHERE usr = '10074437' and fecha = '".$fechaHoy."'";
		$bdProc=mysql_query($actSQL);
	}
	mysql_close($link);
?>
