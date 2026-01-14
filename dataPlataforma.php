<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");

if($dato->accion == 'grabarProyecto'){
    $Grabado = 'Error';

    $link=Conectarse();
    $SQL = "SELECT * FROM proyectos Where IdProyecto = '$dato->IdProyecto'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE proyectos SET ";
        $actSQL.="Proyecto	            ='".$dato->Proyecto.	            "',";
        $actSQL.="Rut_JefeProyecto      ='".$dato->Rut_JefeProyecto.	    "',";
        $actSQL.="JefeProyecto          ='".$dato->JefeProyecto.	        "',";
        $actSQL.="Email                 ='".$dato->Email.	                "',";
        $actSQL.="Banco                 ='".$dato->Banco.	                "',";
        $actSQL.="Cta_Corriente	        ='".$dato->Cta_Corriente.	        "'";
        $actSQL.="WHERE IdProyecto	    = '$dato->IdProyecto'";
        $bdCot=$link->query($actSQL);
        $Grabado = 'Actualizado';
    }else{
        $link->query("insert into proyectos(	IdProyecto                      ,
                                                Proyecto                        ,
                                                Rut_JefeProyecto                ,
                                                JefeProyecto                    ,
                                                Email                           ,
                                                Banco                           ,
                                                Cta_Corriente
                                            ) 
                                    values 	(	'$dato->IdProyecto'             ,
                                                '$dato->Proyecto'               ,
                                                '$dato->Rut_JefeProyecto'       ,
                                                '$dato->JefeProyecto'           ,
                                                '$dato->Email'                  ,
                                                '$dato->Banco'                  ,
                                                '$dato->Cta_Corriente'
        )");
        $Grabado = 'Agregado';

    }

    $link->close();
    $res = '';
    $res.= '{"IdProyecto":"'            .	$dato->IdProyecto       .   '",';
    $res.= '"Grabado":"'                .	$Grabado                .   '"}';
    echo $res;

}

if($dato->accion == 'grabarSupervisor'){
    $link=Conectarse();
    if($dato->estadoSuper == 'New'){
        $SQL = "SELECT * FROM supervisor Where rutSuper = '$dato->rutSuper'"; 
        $bd=$link->query($SQL);
        if($rs=mysqli_fetch_array($bd)){
            $actSQL="UPDATE supervisor SET ";
            $actSQL.="rutSuper	        ='".$dato->rutSuper.	    "',";
            $actSQL.="nombreSuper       ='".$dato->nombreSuper.	    "',";
            $actSQL.="cargoSuper	    ='".$dato->cargoSuper.	    "'";
            $actSQL.="WHERE rutSuper	= '$dato->rutSuper'";
            $bdCot=$link->query($actSQL);
        }else{
            $link->query("insert into supervisor(	rutSuper,
                                                    nombreSuper,
                                                    cargoSuper
                                                ) 
                                        values 	(	'$dato->rutSuper',
                                                    '$dato->nombreSuper',
                                                    '$dato->cargoSuper'
            )");
        }
    }else{
        $actSQL="UPDATE supervisor SET ";
        $actSQL.="rutSuper	        ='".$dato->rutSuper.	    "',";
        $actSQL.="nombreSuper       ='".$dato->nombreSuper.	    "',";
        $actSQL.="cargoSuper	    ='".$dato->cargoSuper.	    "'";
        $bdCot=$link->query($actSQL);
    }

    $link->close();

}

if($dato->accion == 'leerProyectos'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM proyectos";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"IdProyecto":"'          . $rs["IdProyecto"]. 				'",';
        $outp .= '"Proyecto":"'             . $rs["Proyecto"]. 				    '",';
        $outp .= '"JefeProyecto":"'         . $rs["JefeProyecto"]. 				'",';
        $outp .= '"firmaJefe":"'            . $rs["firmaJefe"]. 				'",';
        $outp .= '"Banco":"'                . $rs["Banco"]. 				    '",';
        $outp .= '"Cta_Corriente":"'        . $rs["Cta_Corriente"]. 		    '",';
        $outp .= '"Email":"'                . $rs["Email"]. 		            '",';
	    $outp .= '"Rut_JefeProyecto":"'     . $rs["Rut_JefeProyecto"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);

}

if($dato->accion == 'cargarDatosSupervisor'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM supervisor"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"rutSuper":"'          .	$rs['rutSuper']         .   '",';
        $res.= '"nombreSuper":"'        .	$rs['nombreSuper']      .   '",';
        $res.= '"cargoSuper":"'         .	$rs['cargoSuper']       .   '",';
        $res.= '"firmaSuper":"'         .	$rs['firmaSuper']       .   '",';
        $res.= '"imgFirma":"'           .	$rs['imgFirma']         .   '"}';
    }else{
        $res.= '{"rutSuper":"'          .	'Error'         .   '"}';
    }

    $link->close();
    echo $res;

}





?>