<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 


if($dato->accion == "loadTaller"){ 
    $res = '';
    $link=Conectarse();
    $SQL = "Select * From ammuestras Where idItem like '%$dato->RAM%'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $SQLf = "Select * From formram Where RAM = '$dato->RAM'";
        $bdf=$link->query($SQLf);
        if($rsf = mysqli_fetch_array($bdf)){
        }
        $tecRes = '';

        $actSQL="UPDATE otams SET ";
        $actSQL.="tecRes		= '".$dato->tecRes.	"'";
        $actSQL.="Where RAM 	= '".$dato->RAM."'";
        $bdfRAM=$link->query($actSQL);
    
        $SQLot = "Select * From Otams Where RAM = '$dato->RAM'";
        $bdot=$link->query($SQLot);
        if($rsot = mysqli_fetch_array($bdot)){
            $tecRes = $rsot['tecRes'];
        }

        $res.= '{"idItem":"'.			    $rs['idItem'].					    '",';
        $res.= '"idMuestra":"'.	            $rs["idMuestra"]. 				    '",';
        $res.= '"nSolTaller":"'.	        $rsf["nSolTaller"]. 				'",';
        $res.= '"nSolTaller":"'.	        $rsf["nSolTaller"]. 				'",';
        $res.= '"tecRes":"'.	            $tecRes. 				            '",';
        $res.= '"Objetivo":"'.			    $rs['Objetivo'].		            '"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == "regTecRes"){
    $link=Conectarse();
    $actSQL="UPDATE otams SET ";
    $actSQL.="tecRes		= '".$dato->tecRes.	"'";
    $actSQL.="Where RAM 	= '".$dato->RAM."'";
    $bdfRAM=$link->query($actSQL);
    $link->close();
}


if($dato->accion == "LecturaRegImpactos"){
    $outp = "";
    $sImpactos = 0;
    $Media = 0;
    $i = 0;
    $link=Conectarse();
    
    $SQL = "SELECT * FROM regcharpy Where idItem = '$dato->idItem' Order By nImpacto Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){   
        $i++;
        $sImpactos += $rs['vImpacto'];
        $Media = $sImpactos / $i;
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"nImpacto":"'.				$rs["nImpacto"].					'",';
        $outp.= '"idItem":"'.				    $rs["idItem"]. 				        '",';
        $outp.= '"tpMuestra":"'.				$rs["tpMuestra"]. 				    '",';
        $outp.= '"actCheck":"'.				    $rs["actCheck"]. 				    '",';
        $outp.= '"Tem":"'.				        $rs["Tem"]. 				        '",';
        $outp.= '"Ancho":"'.				    $rs["Ancho"]. 				        '",';
        $outp.= '"Alto":"'.				        $rs["Alto"]. 				        '",';
        $outp.= '"resEquipo":"'.				$rs["resEquipo"]. 				    '",';
        $outp.= '"mm":"'.				        $rs["mm"]. 				            '",';
        $outp.= '"Entalle":"'.				    $rs["Entalle"]. 				    '",';
        $outp.= '"CosProbMen4Ra":"'.	        trim($rs["CosProbMen4Ra"]). 	    '",';
        $outp.= '"CarEntMen2Ra":"'.	            trim($rs["CarEntMen2Ra"]). 	        '",';
        $outp.= '"Prob55":"'.	                trim($rs["Prob55"]). 	            '",';
        $outp.= '"CentEnt27":"'.	            trim($rs["CentEnt27"]). 	        '",';
        $outp.= '"AngEnt45":"'.	                trim($rs["AngEnt45"]). 	            '",';
        $outp.= '"ProfEnt2mm":"'.	            trim($rs["ProfEnt2mm"]). 	        '",';
        $outp.= '"RadCorv025":"'.	            trim($rs["RadCorv025"]). 	        '",';
        $outp.= '"eAbs":"'.	                    trim($rs["eAbs"]). 	                '",';
        $outp.= '"vImpacto":"'.	                $rs["vImpacto"]. 	                '",';
        $outp.= '"Media":"'.	                $Media. 	                        '",';
        $outp.= '"fechaRegistro":"'. 		    $rs["fechaRegistro"]. 				'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}



if($dato->accion == "Ultima"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM actividades Order By idActividad Desc";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $idActividad = $rs['idActividad'] + 1;
        $res.= '{"idActividad":"'.			$idActividad.					'"}';
    }
    $link->close();
    echo $res;	
}
if($dato->accion == "Borrar"){
    $link=Conectarse();
    $bdEnc=$link->query("Delete From actividades Where idActividad = '$dato->idActividad'");
    $link->close();
}
if($dato->accion == "respaldaEnsayo"){
    header('Location: formularios/otamCharpy.php?accion=Imprimir&RAM='.$dato->RAM.'&Otam='.$dato->Otam.'&CodInforme='.$dato->CodInforme);
}


?>