<?php
$Otam       = $_GET["Otam"];
date_default_timezone_set("America/Santiago");

$fp = fopen("resultadoTr/".$Otam."/Resultados.htm", "r");
$i          = 0;
$probeta    = 'Re';
$j          = 0;
$inicia     = 'No';
$Campo      = '';
$tpMuestra  = 'Re';

while(!feof($fp)) {
    $linea = utf8_encode(fgets($fp)); 
    $ln = trim(strip_tags($linea));
    if(substr_count($ln,'OTAM') > 0 ){
        $j = 0;
        $inicia = 'Si';
    }

    if($ln != ''){
        $i++;
        //echo $i.' => '.$ln.'<br>';

        if($i >= 6 and $i <= 19){
            if($i == 7){
                $Otam = $ln;
                echo 'Otam : '.$Otam.'<br>';
            }
            if($i == 9){
                $Operador = $ln;
                echo 'Operador : '.$Operador.'<br>';
            }
            if($i == 11){
                $Humedad = $ln;
                echo 'Humedad : '.$Humedad.'<br>';
            }
            if($i == 13){
                $Temperatura = $ln;
                echo 'Temperatura : '.$Temperatura.'<br>';
            }
            if($i == 17){
                //echo 'Temperatura : '.$Temperatura.'<br>';
                if(substr_count($ln,'Plana') > 0 ){
                    $tpMuestra = 'Pl';
                }
                if(substr_count($ln,'Redonda') > 0 ){
                    $tpMuestra = 'Re';
                }
                if(substr_count($ln,'Cilindrica') > 0 ){
                    $tpMuestra = 'Pl';
                }
                echo 'Muestra :'.$tpMuestra.'<br>';

            }
            if($i == 19){
                $fechaRegistro = $ln;
                $fd = explode('-', $fechaRegistro);
                $fechaRegistro = $fd[1].'-'.$fd[0].'-'.$fd[2];
                echo 'Fecha : '.$fechaRegistro.'<br>';
            }
        }
        if($i >= 21){
            //echo $i.' => '.$ln.'<br>';

            if($tpMuestra == 'Pl'){
                if($i == 22){
                    $Espesor = $ln;
                    echo 'Espesor : '.$Espesor.'<br>';
                }
                if($i == 24){
                    $Ancho = $ln;
                    echo 'Ancho : '.$Ancho.'<br>';
                }
                if($i == 26){
                    $aIni = $ln;
                    echo 'Área : '.$aIni.'<br>';
                }
                if($i == 28){
                    $Modulo = $ln;
                    echo 'Modulo : '.$Modulo.'<br>';
                }
                if($i == 30){
                    $cFlu = $ln;
                    echo 'Carga de Fluencia : '.$cFlu.'<br>';
                }
                if($i == 32){
                    $UTS = $ln;
                    echo 'Carga de UTS : '.$UTS.'<br>';
                }
                if($i == 34){
                    $tFlu = $ln;
                    echo 'Tensión de Fluencia : '.$tFlu.'<br>';
                }
                if($i == 36){
                    $tMax = $ln;
                    echo 'Tension UTS : '.$tMax.'<br>';
                }
                if($i == 38){
                    $aSob = $ln;
                    echo 'Alargamiento : '.$aSob.'<br>';
                }
                if($i == 40){
                    $Li = $ln;
                    echo 'Largo Inicial : '.$Li.'<br>';
                }
                if($i == 42){
                    $Lf = $ln;
                    echo 'Largo Final : '.$Lf.'<br>';
                }
    
            }
            if($tpMuestra == 'Re'){
                if($i == 22){
                    $Di = $ln;
                    echo 'Diámetro : '.$Di.'<br>';
                }
                if($i == 24){
                    $aIni = $ln;
                    echo 'Área : '.$aIni.'<br>';
                }
                if($i == 26){
                    $Modulo = $ln;
                    echo 'Modulo : '.$Modulo.'<br>';
                }
                if($i == 28){
                    $cFlu = $ln;
                    echo 'Carga de Fluencia : '.$cFlu.'<br>';
                }
                if($i == 30){
                    $UTS = $ln;
                    echo 'Carga de UTS : '.$UTS.'<br>';
                }
                if($i == 32){
                    $tFlu = $ln;
                    echo 'Tensión de Fluencia : '.$tFlu.'<br>';
                }
                if($i == 34){
                    $tMax = $ln;
                    echo 'Tension UTS : '.$tMax.'<br>';
                }
                if($i == 36){
                    $aSob = $ln;
                    echo 'Alargamiento : '.$aSob.'<br>';
                }
                if($i == 38){
                    $rAre = $ln;
                    echo 'Reducción de Área : '.$rAre.'<br>';
                }
                if($i == 40){
                    $Li = $ln;
                    echo 'Largo Inicial : '.$Li.'<br>';
                }
                if($i == 42){
                    $Lf = $ln;
                    echo 'Largo Final : '.$Lf.'<br>';
                }
                if($i == 44){
                    $Df = $ln;
                    echo 'Diametro Final : '.$Df.'<br>';
                }
    
            }

        }

    }

    /*
    if($inicia == 'Si'){
        if($ln != ''){
            if(strlen($ln) != 6){
                $j++;
                if($j == 1){
                     //echo 'Campo : '.$ln.'<br>';
                    $Campo = $ln;               
                }
                if($j == 2){
                    if(substr_count($Campo,'OTAM') > 0 ){
                        $idItem = $ln;
                        echo 'OTAM : '.$idItem.'<br>';

                    }
                    if(substr_count($Campo,'Operador') > 0 ){
                        $Operador = $ln;
                        echo 'Operador : '.$Operador.'<br>';

                    }

                    if(substr_count($Campo,'Humedad') > 0 ){
                        $Humedad = $ln;
                        echo 'Humedad : '.$Humedad.'<br>';

                    }
                    if(substr_count($Campo,'Temperatura') > 0 ){
                        $Temperatura = $ln;
                        echo 'Tem : '.$Temperatura.'<br>';

                    }
                    $tpMuestra = 'Re';
                    if(substr_count($Campo,'Programa') > 0 ){
                        // echo $ln.'<br>';
                        if(substr_count($ln,'Plana') > 0 ){
                            $tpMuestra = 'Pl';
                        }
                        if(substr_count($ln,'Redonda') > 0 ){
                            $tpMuestra = 'Re';
                        }
                        echo 'Muestra :'.$tpMuestra.'<br>';
                    }
                    if(substr_count($Campo,'Fecha') > 0 ){
                        $fechaRegistro = $ln;
                        $fd = explode('-', $fechaRegistro);
                        $fechaRegistro = $fd[1].'-'.$fd[0].'-'.$fd[2];
                        echo 'Fecha : '.$fechaRegistro.'<br>';
                    }
                    if(substr_count($Campo,'Espesor') > 0 ){
                        $Espesor = $ln;
                        echo 'Espesor : '.$Espesor.'<br>';

                    }
                    if(substr_count($Campo,'Ancho') > 0 ){
                        $Ancho = $ln;
                        echo 'Ancho : '.$Ancho.'<br>';
                    }
                    
                    if(substr_count($Campo,'Área, mm²:') > 0 ){
                        $aIni = $ln;
                        echo 'Área : '.$aIni.'<br>';
                        
                    }
                    
                    if(substr_count($Campo,'Módulo, GPa') > 0 ){
                        $Modulo = $ln;
                        echo 'Modulo : '.$Modulo.'<br>';

                    }
                    
                    if(substr_count($Campo,'Carga de Fluencia') > 0 ){
                        $cFlu = $ln;
                        echo 'Carga Flu : '.$cFlu.'<br>';

                    }
                    if(substr_count($Campo,'UTS') > 0 ){
                        $UTS = $ln;
                        echo 'UTS : '.$UTS.'<br>';

                    }
                    if(substr_count($Campo,'Tensión ') > 0 ){
                        $tFlu = $ln;
                        echo 'Tension  : '.$tFlu.'<br>';

                    }
                    if(substr_count($Campo,'Alargamiento') > 0 ){
                        $aSob = $ln;
                        echo 'Alargamiento : '.$aSob.'<br>';

                    }
                    if(substr_count($Campo,'Gage Length Inicial') > 0 ){
                        $Li = $ln;
                        echo 'Largo Inicial : '.$Li.'<br>';
                    }
                    if(substr_count($Campo,'Gage Length Final') > 0 ){
                        $Lf = $ln;
                        echo 'Final : '.$Lf.'<br>';

                    }

                    $j = 0;
                }

            }
        }
    }
    */
}
fclose($fp);


# La respuesta que recibe $http.post en el then de la promesa
?>
