<?php
    $fd = explode('-','15660-01-T01');
    $Otam = '15660-01-T01';
    $RAM = $fd[0];
    $res = '';
    $agnoActual = date('Y'); 
    $ruta = 'Y://AAA/Archivador-AM/'.$agnoActual.'/'.$RAM; 

    $gestorDir = opendir($ruta);
    while(false !== ($nombreDir = readdir($gestorDir))){
        $dirActual = explode('-', $nombreDir);
        if($nombreDir != '.' and $nombreDir != '..'){
            $res.= '{"Otam":"'          .$Otam.				'",';
            $res.= '"ficheros":' 	    .json_encode($nombreDir, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
            $res.= '"idItem":"'         .$Otam. 		    '"}';
        }
    }
    echo $res;	

?>