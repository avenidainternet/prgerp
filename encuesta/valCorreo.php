<?php
	session_start(); 
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET[Correo])) 	{	$Correo 	= $_GET[Correo]; 		}

		$link=Conectarse();
		$bdFol=mysql_query("Select * From foliosEncuestas Where Email = '".$Correo."'");
		if($rowFol=mysql_fetch_array($bdFol)){
			echo $rowFol[Cumplimentado];
		}else{
			echo 'No encontrado...';
		}
		mysql_close($link);
		
?>