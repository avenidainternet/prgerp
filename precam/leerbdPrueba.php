<?php
include("../conexionli.php");  
$fechaHoy = date('Y-m-d'); 
$dias = array(
    0 => 'Domingo', 
    1 => 'Lunes', 
    2 => 'Martes',
    3 => 'Miércoles',
    4 => 'Jueves',
    5 => 'Viernes',
    6 => 'Sábado'
);
$diaInicio="Monday";
$diaFin="Friday";

$strFecha = strtotime($fechaHoy);

$fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
$fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
$outp = "";

if(date("l",$strFecha)==$diaInicio){
    $fechaInicio= date("Y-m-d",$strFecha);
 }
 if(date("l",$strFecha)==$diaFin){
     $fechaFin= date("Y-m-d",$strFecha);
 }
 $Blanco = '';
 for($i=0; $i<=4; $i++){
     $fSem = date("Y-m-d",strtotime($fechaInicio."+ $i days"));
     $link=Conectarse();
     $sql = "SELECT * FROM precam Where Estado = 'on' and fechaPreCAM >= '$fechaInicio' or fechaPreCAM <= 'fechaFin'";
     //$sql = "SELECT * FROM precam Where Estado = 'on' and fechaPreCAM = '$fSem'";
     //$sql = "SELECT * FROM precam Where Estado = 'on'";
     $bd = $link->query($sql);
     while($rs=mysqli_fetch_array($bd)){
        if($rs['fechaPreCAM'] == $fSem){
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"fSem":"'  	        . $fSem 		                . '",'; 
            $outp .= '"idPreCAM":"'  	    . $rs['idPreCAM'] 		        . '",';
            $outp .= '"Correo":' 		    . json_encode($rs['Correo'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
            $outp .= '"usrResponsable":"'	. $rs['usrResponsable']         . '"}';
        }else{
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"fSem":"'  	        . $fSem 		                . '",'; 
            $outp .= '"idPreCAM":"'  	    . $Blanco 		                . '",';
            $outp .= '"Correo":"'  	        . $Blanco 		                . '",';
            $outp .= '"usrResponsable":"'	. $Blanco                       . '"}';
        }
    }
 }
$outp ='{"records":['.$outp.']}';
echo($outp);

?>