<?php
	include_once("conexionli.php");
	$link = Conectarse();
	$sql = "SELECT * FROM clientes Where RutCli = '93077000-0'";
	$bdCli=$link->query($sql);
	if($rowCli=mysqli_fetch_array($bdCli)){
		echo $rowCli['Giro'];
	}
?>