<?php
	date_default_timezone_set("America/Santiago"); 

	include_once("../conexioncert.php");
	$link=ConectarseCert();
	$bd=$link->query("SELECT * FROM certificado");
	while ($rs=mysqli_fetch_array($bd)){
                $nColadas = 0;
                $fd = explode('-',$rs['CodCertificado']);
                $ar = $fd[0].'-'.$fd[1];
                $codAr = intval($fd[1]);
                $nColadas = substr($fd[2],2,2);
                //echo $ar.' '.substr($fd[2],2,2).'<br>';
                $bdar=$link->query("SELECT * FROM ar Where ar = '$ar'");
                if($rsar=mysqli_fetch_array($bdar)){
                        echo 'Actualiza...'.$codAr.' '.$ar.'<br>';
                        $actSQL="UPDATE ar SET ";
                        $actSQL.="ar			='".$ar.		        "',";
                        $actSQL.="codAr			='".$codAr.		        "',";
                        $actSQL.="nColadas	        ='".$nColadas.                  "',";
                        $actSQL.="RutCli	        ='".$rs['RutCli'].              "'";
                        $actSQL.="WHERE ar	        ='$ar";
                        $bdCot=$link->query($actSQL);
                }else{
                        echo ' Nuevo'.$ar;
                        $link->query("insert into ar(	
                                                        ar                              ,
                                                        codAr                           ,
                                                        nColadas                         ,
                                                        RutCli            
                                                        ) 
                                                values 	(	
                                                        '$ar'                           ,
                                                        '$codAr'                    ,
                                                        '$nColadas'                    ,
                                                        '".$rs['RutCli']."'       
                                )");
                
                }
	}
	$link->close();	
?>
