<?php
	include_once("../conexionli.php");
	$link=Conectarse();
	$bdMu=$link->query("Select * From regtraccion Where year(fechaRegistro) = 2019");
	while($rowMu=mysqli_fetch_array($bdMu)){
		$fd = explode('-', $rowMu['idItem']);
		$RAM = $fd[0];
		echo $rowMu['idItem'].' '.$rowMu['fechaRegistro'].' '.$RAM.'<br>';

		
		$bdCot=$link->query("Select * From otams Where RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
				$fechaCreaRegistro = $rowMu['fechaRegistro'];
				$actSQL="UPDATE otams SET ";
				$actSQL.="fechaCreaRegistro	='".$fechaCreaRegistro."'";
				$actSQL.="WHERE RAM = '".$RAM."'";
				$bdT=$link->query($actSQL);
		}


	}
	$link->close();
