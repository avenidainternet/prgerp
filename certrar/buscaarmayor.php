<?php
	date_default_timezone_set("America/Santiago");

	include_once("../conexioncert.php");
	$link=ConectarseCert();
	$bd=$link->query("SELECT * FROM ar");
	while ($rs=mysqli_fetch_array($bd)){
        $fd = explode('-',$rs['ar']);
        $ar = $fd[1];
        echo $ar.'<br>';

        $actSQL="UPDATE ar SET ";
        $actSQL.="codAr			    ='".$ar.		            "'";
        $actSQL.="WHERE ar	        ='".$rs['ar']."'";
        $bdCot=$link->query($actSQL);

	}
	$link->close();	
?>
