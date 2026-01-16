<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
date_default_timezone_set('America/Santiago');

include("../conexionli.php");  
//$fechaHoy = date('Y-m-d'); 
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

$bColor = 'Normal';

if($dato->accion=="buscarPrimera"){
    $link=Conectarse();
    $sql = "SELECT * FROM precam Where Estado = 'on' and fechaSeg = '0000-00-00' Order By fechaPreCAM Asc";
    $bd = $link->query($sql);
    if($rs=mysqli_fetch_array($bd)){
        $fechaHoy = $rs['fechaPreCAM'];
    }
    $link->close();

    $res = '';
    $res.= '{"fechaHoy":"'.	            $fechaHoy.				'"}';
    echo $res;

}

if($dato->accion=="diasHead"){

    $strFecha = strtotime($dato->fechaHoy);

    $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
    $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
    $outp = "";

	if(date("l",$strFecha)==$diaInicio){
        $fechaInicio= date("Y-m-d",$strFecha);
     }
     if(date("l",$strFecha)==$diaFin){
         $fechaFin= date("Y-m-d",$strFecha);
     }			
     for($i=0; $i<=4; $i++){
         $fSem = date("d-m-Y",strtotime($fechaInicio."+ $i days"));
         
         if ($outp != "") {$outp .= ",";}
         $outp .= '{"fSem":"'  	        . $fSem 		    . '",'; 
         $outp .= '"diaSemana":"'  	    . $dias[$i+1] 		. '",';
         $outp .= '"diaFin":"'          . $diaFin 		    . '",';
         $outp .= '"fechaFin":"'	    . $fechaFin         . '"}';
 
     }
    $outp ='{"records":['.$outp.']}';
    echo($outp);

}


if($dato->accion=="semanaAnterior"){
    $fechaHoy = date("Y-m-d",strtotime($dato->fechaHoy."- 7 days"));
    $res = '';
    $res.= '{"fechaHoy":"'.	            $fechaHoy.				'"}';
    echo $res;
}
if($dato->accion=="semanaSiguiente"){
    $fechaHoy = date("Y-m-d",strtotime($dato->fechaHoy."+ 7 days"));
    $res = '';
    $res.= '{"fechaHoy":"'.	            $fechaHoy.				'"}';
    echo $res;
}

if($dato->accion=="leerPreCAM"){
    $strFecha = strtotime($dato->fechaHoy);
    $fechaActual = date('Y-m-d');
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
         $diaSem = date("l",strtotime($fSem));
         $link=Conectarse();
         $sql = "SELECT * FROM precam Where fechaPreCAM >= '$fechaInicio' or fechaPreCAM <= 'fechaFin' or fechaSeg >= 'fechaFin'";
         /*
         if($dato->idPreCAM != ''){
             $sql = "SELECT * FROM precam Where idPreCAM = '$dato->idPreCAM'";
         }
         */
         $bd = $link->query($sql);
         while($rs=mysqli_fetch_array($bd)){
            $fecha = $rs['fechaPreCAM'];
            if($rs['fechaSeg'] != '0000-00-00'){
                 $fecha = $rs['fechaSeg'];
            }
                
            if($fecha == $fSem){
                $EstadoPreCAM = 'btn-success';
                if($rs['fechaPreCAM'] < $fechaActual){
                    $EstadoPreCAM = 'btn-danger';
                }
                if($rs['fechaSeg'] >= $fechaActual){
                    $EstadoPreCAM = 'btn-warning';
                }
                if($rs['Estado'] == 'off'){
                    $EstadoPreCAM = ' border';
                }
                if ($outp != "") {$outp .= ",";}
                $outp .= '{"fSem":"'  	        . $fSem 		                . '",'; 
                $outp .= '"idPreCAM":"'  	    . $rs['idPreCAM'] 		        . '",';
                $outp .= '"Estado":"'  	        . $rs['Estado'] 		        . '",';
                $outp .= '"Tipo":"'  	        . $rs['Tipo'] 		            . '",';
                $outp .= '"idCliente":' 		. json_encode($rs['idCliente'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
                $outp .= '"EstadoPreCAM":"'  	. $EstadoPreCAM 		        . '",';
                $outp .= '"diaSem":"'  	        . $diaSem 		                . '",';
                $outp .= '"Correo":' 		    . json_encode($rs['Correo'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
                $outp .= '"usrResponsable":"'	. $rs['usrResponsable']         . '"}';
            }
        }
     }
    $outp ='{"records":['.$outp.']}';
    echo($outp);


}

if($dato->accion == 'cerrarPreCAM'){
    $link=Conectarse();
    $SQL = "SELECT * FROM precam where idPreCAM = '$dato->idPreCAM'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $Estado = 'off';
        $actSQL="UPDATE precam SET ";
        $actSQL.="Estado			='".$Estado.                "'";
        $actSQL.="WHERE idPreCAM	='".$dato->idPreCAM."'";
        $bdCot=$link->query($actSQL);
    }
}

if($dato->accion == 'actualizarDatos'){
    $link=Conectarse();
    $SQL = "SELECT * FROM precam where idPreCAM = '$dato->idPreCAM'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $Estado = 'on';
        if($rs['Estado'] != ''){
            $Estado = $rs['Estado'];
        }
        $actSQL="UPDATE precam SET ";
        $actSQL.="Correo			='".$dato->Correo.		    "',";
        $actSQL.="fechaPreCAM		='".$dato->fechaPreCAM.	    "',";
        $actSQL.="idCliente		    ='".$dato->idCliente.	    "',";
        $actSQL.="fechaSeg			='".$dato->fechaSeg.		"',";
        $actSQL.="usrResponsable	='".$dato->usrResponsable.  "',";
        $actSQL.="Tipo	            ='".$dato->Tipo.            "',";
        $actSQL.="Estado			='".$Estado.                "'";
        $actSQL.="WHERE idPreCAM	='".$dato->idPreCAM."'";
        $bdCot=$link->query($actSQL);
    }
}

if($dato->accion == 'guardarDatos'){
    $link=Conectarse();
    $SQL = "SELECT * FROM precam Order By idPreCAM Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $idPreCAM = $rs['idPreCAM'] + 1;
        $Estado	= 'on';
        $link->query("insert into precam(	
                                        idPreCAM            ,
                                        fechaPreCAM         ,
                                        Tipo                ,
                                        idCliente           ,
                                        Correo              ,
                                        usrResponsable      ,
                                        Estado
                                        ) 
                                values 	(	
                                        '$idPreCAM'             ,
                                        '$dato->fechaPreCAM'    ,
                                        '$dato->Tipo'           ,
                                        '$dato->idCliente'      ,
                                        '$dato->Correo'         ,
                                        '$dato->usrResponsable' ,
                                        '$Estado'
                )");
    }
    $link->close();
}



if($dato->accion=="leerPreCAMMMMMMMM"){
    $link=Conectarse();
    $outp = "";
    $SQL = "SELECT * FROM precam where Estado = 'on' Order By fechaPreCAM Desc"; 
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){ 
    
      $fechaVencida 	= strtotime ( '-1 day' , strtotime ( $fechaHoy ) );
      $fechaVencida 	= date ( 'Y-m-d' , $fechaVencida );
    
      if($rs['fechaPreCAM'] == '0000-00-00'){
        $bColor = "Atrazado";
      }						
      if($rs['seguimiento'] == 'on'){
        $bColor = "Precaucion";
      }
    
    
      if($rs["fechaPreCAM"] == $fechaVencida){ $bColor = 'Precaucion'; }
      if($rs["fechaPreCAM"] < $fechaVencida){ $bColor = 'Atrazado'; }
      $fechaSeg = 'Sin Seg.';
      if($rs["fechaSeg"] > '0000-00-00'){ $fechaSeg = $rs["fechaSeg"]; }
      if($rs['seguimiento'] == 'on'){
        $bColor = "Precaucion";
      }
    
      $diaInicio="Monday";
      $diaFin="Friday";
  
      $strFecha = strtotime($fechaHoy);
  
      $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
      $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
  

      $largo = 300;
      $Correo = substr($rs["Correo"], 0, $largo);
      if(strlen($rs["Correo"]) > $largo){ $Correo .= "..."; }
    
      if ($outp != "") {$outp .= ",";}
      $outp .= '{"idPreCAM":"'  		. $rs["idPreCAM"] 		    . '",'; 
      $outp .= '"idCliente":"'  	. $rs["idCliente"] 		  . '",';
      $outp .= '"Correo":' 		      . json_encode($Correo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
      $outp .= '"fechaPreCAM":"'    . $rs["fechaPreCAM"] 		  . '",';
      //$outp .= '"fechaPreCAM":"'    . $fechaVencida 		  . '",';
      $outp .= '"bColor":"'         . $bColor 		            . '",';
      $outp .= '"Tipo":"'           . $rs["Tipo"] 		        . '",';
      $outp .= '"fechaSeg":"'       . $fechaSeg 		          . '",';
      $outp .= '"usrResponsable":"'	. $rs["usrResponsable"]   . '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo($outp);
}
?>