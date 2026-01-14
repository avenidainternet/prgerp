<?php
	session_start();
	date_default_timezone_set("America/Santiago");
	include_once("conexionli.php");
	$link=Conectarse();
	
	$fechaHoy 	= date('Y-m-d');
	$horaSalida = date('H:i:s');
	
	$bdCtl  = $link->query("SELECT * FROM relojControl Where usr = '".$_SESSION['usr']."' and fecha = '".$fechaHoy."'");
	if($rowCtl=mysqli_fetch_array($bdCtl)){
		$hi = explode(':',$rowCtl['horaIngreso']);
		$hs = explode(':',$horaSalida);
		$thd = $hs[0] - $hi[0];
		$tsd = $hs[2] + $hi[2];
		$tmd = $hs[1] + $hi[1];
		if($tsd >= 60){
			$tsd = $tsd - 60;
			$tmd++;
		}
		if($tmd >= 60){
			$tmd = $tmd - 60;
			$thd++;
		}
		if($thd < 10){ $thd = '0'.$thd; }
		if($tmd < 10){ $tmd = '0'.$tmd; }
		if($tsd < 10){ $tsd = '0'.$tsd; }

		$td = $thd.':'.$tmd.':'.$tsd;

		$actSQL="UPDATE relojControl SET ";
		$actSQL.="horaSalida	= '".$horaSalida."',";
		$actSQL.="diferencia	= '".$td."',";
		$actSQL.="horasDia		= '".$td."'";
		$actSQL.="WHERE usr = '".$_SESSION['usr']."' and fecha = '".$fechaHoy."'";
		$bdProc=$link->query($actSQL);
	}
	$link->close();
	session_unset();
	session_destroy();
	header("Location: index.php");
?>
