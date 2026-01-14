<?php
$agnoActual = date('Y'); 

$directorioAM = 'y://AAA/Archivador-'.$agnoActual;
echo 'Año Actual...'.$directorioAM.'<br>';
if(!file_exists($directorioAM)){
    echo 'Crando Carpeta<br>';
	mkdir($directorioAM);
}

?>