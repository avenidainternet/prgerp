<?php
$agnoActual = date('Y'); 

$directorioAM = '\\\Servidorerp\\AAA\\Fco';
echo 'Año Actual...'.$directorioAM.'<br>';

if(!file_exists($directorioAM)){ 
    echo 'Crando Carpeta<br>';
	mkdir($directorioAM);
}
echo '<br><br>Nueva linea <br><br>';
$directorioAM = '\\\SERVIDORDATA\\Data\\AAA\\Archivador-'.$agnoActual;
echo 'Carpeta...'.$directorioAM.'<br>';

if(!is_dir($directorioAM)){
    echo 'No existe...';
	echo is_dir($directorioAM);
	//mkdir($directorioAM);
}else{
    echo 'Carpeta Existe...';
}


$directorioAM = 'X://AAA/Archivador-Fco123';
if(!file_exists($directorioAM)){
    echo 'Error';
	mkdir($directorioAM);
}





?>