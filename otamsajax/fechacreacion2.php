<?php
	include_once("../conexionli.php");
	$link=Conectarse();
	$i = 0;
	$bdMu=$link->query("Select * From ammuestras Where year(fechaTaller) = 2019 Order By fechaTaller");
	while($rowMu=mysqli_fetch_array($bdMu)){
		$fd = explode('-', $rowMu['idItem']);
		$RAM = $fd[0];
		echo $rowMu['idItem'].' '.$rowMu['fechaTaller'].' '.$RAM.'<br>';

	
		$bdCot=$link->query("Select * From otams Where RAM = '".$RAM."' and fechaCreaRegistro = '0000-00-00'");

		if($rowCot=mysqli_fetch_array($bdCot)){
				$i++;
				$fechaCreaRegistro = $rowMu['fechaTaller'];
				$actSQL="UPDATE otams SET ";
				$actSQL.="fechaCreaRegistro	='".$fechaCreaRegistro."'";
				$actSQL.="WHERE RAM = '".$RAM."'";
				$bdT=$link->query($actSQL);
				echo $i.'<br>';
		}


	}
	$link->close();
