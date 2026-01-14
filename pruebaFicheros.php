<?php
session_start(); 
include_once("conexion.php");
date_default_timezone_set("America/Santiago");

$fechaHoy = date('Y-m-d');
$dos = 2;
$f2 	= strtotime ( '-'.$dos.' year' , strtotime ( $fechaHoy ) );
$f2 	= date ( 'Y-m-d' , $f2 );
echo $f2.'<br>';

/*
$link=Conectarse();
$bdIn=mysql_query("SELECT * FROM Informes Where fechaUp <= '".$f2."' Order By fechaUp Desc");
if($rowIn=mysql_fetch_array($bdIn)){
	do{
		$fdRAM = explode('-',$rowIn['CodInforme']);
		$Muestra = 'Si';
		$swInf = 'Borrar';
		$bdCAM=mysql_query("SELECT * FROM cotizaciones Where RAM = '".$fdRAM[1]."'");
		if($rowCAM=mysql_fetch_array($bdCAM)){
			//if($rowCAM['fechaInformeUP'] == '0000-00-00'){
				if($rowCAM['fechaCotizacion'] > $f2){
					$swInf = 'No Borrar';
				}
			//}
			$swInf = ' RAM : Cotización = '.$rowCAM['fechaCotizacion'].' Informe UP = '.$rowCAM['fechaInformeUP'].' '.$swInf;
		}
		if($swInf == 'Borrar'){
			echo '<br>'.$rowIn['fechaUp'].' Inf. '.$rowIn['CodInforme'].' FdRAM = '.$fdRAM[1].$swInf;
		}
	}while ($rowIn=mysql_fetch_array($bdIn));
}
mysql_close($link);

$link=Conectarse();
$bdIn=mysql_query("SELECT * FROM Informes Where fechaUp = '0000-00-00' Order By fechaUp Desc");
if($rowIn=mysql_fetch_array($bdIn)){
	do{
		$fdRAM = explode('-',$rowIn['CodInforme']);
		$Muestra = 'Si';
		$swInf = 'Borrar';
		$bdCAM=mysql_query("SELECT * FROM cotizaciones Where RAM = '".$fdRAM[1]."'");
		if($rowCAM=mysql_fetch_array($bdCAM)){
			//if($rowCAM['fechaInformeUP'] == '0000-00-00'){
			//}
			if($rowCAM['fechaInformeUP'] > '0000-00-00' ){
				$fechaUp = $rowCAM['fechaInformeUP'];
				$actSQL="UPDATE Informes SET ";
				$actSQL.="fechaUp			='".$fechaUp."'";
				$actSQL.="WHERE CodInforme Like '%".$fdRAM[1]."%'";
				$bdEnc=mysql_query($actSQL);
			}
			$swInf = ' RAM : Cotización = '.$rowCAM['fechaCotizacion'].' Informe UP = '.$rowCAM['fechaInformeUP'].' '.$rowCAM['Estado'].' '.$rowCAM['fechaTermino'];
		}
		echo '<br>'.$fdRAM[1].' --- '.$rowIn['DiaInforme'].'-'.$rowIn['MesInforme'].'-'.$rowIn['AgnoInforme'].' Inf. '.$rowIn['CodInforme'].' '.$swInf;
	}while ($rowIn=mysql_fetch_array($bdIn));
}
mysql_close($link);
*/

$ruta = '../intranet/informes/';
$file = 'AM-4844-0101.pdf';
$archivo = $ruta.$file;
$actual =  date("m/d/Y",filemtime($archivo));
//echo $actual;

$RAM = 6813;
if (is_dir($ruta)) { 
      if ($dh = opendir($ruta)) { 
	  	while (($file = readdir($dh)) !== false) { 
			if(!is_dir($file)){
				$fd = explode('-', $file);
				if($fd[0] == 'AM'){
					if($fd[1] <= $RAM){
						$archivo = $ruta.$file;
						$actual =  date("m/d/Y",filemtime($archivo));
						//echo $file.' '.date("Y-m-i.", filectime($file)).'<br>';
						//$n = fileinode($file);
						echo $file.' Fecha '.$actual.'<br>';
					}
				}
			}
		}
	  }
}

?>