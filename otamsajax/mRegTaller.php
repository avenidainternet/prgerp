<?php 
	include_once("conexion.php");
	$idItem = $_GET['idItem'];
	$fdRAM = explode('-',$idItem);
	$RAM = $fdRAM[0];
	echo 'Actualizado Item '.$idItem;
	$link=Conectarse();
	$SQL = "SELECT * FROM ammuestras Where idItem = '".$idItem."'";
	//echo $SQL;
	$bd=mysql_query($SQL);
	if($row=mysql_fetch_array($bd)){
		$Taller = $row['Taller'];
		echo ' BD = '.$Taller;
		if($Taller == 'on'){
			$Taller = 'off';
		}else{
			$Taller = 'on';
		}
		echo ' BD Resultado = '.$Taller;
		$actSQL  ="UPDATE ammuestras SET ";
		$actSQL .= "Taller 		= '".$Taller."' ";
		$actSQL .="WHERE idItem = '".$idItem."'";
		$bd=mysql_query($actSQL);
	}
	mysql_close($link);
	//header("Location: idMuestras2.php?accion=Editar&RAM=".$RAM."&idItem=".$idItem);
?>
