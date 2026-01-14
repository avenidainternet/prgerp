<?php
	
	include_once("../conexionli.php");

	$link=Conectarse();
	$bd=$link->query("SELECT * FROM cotizaciones Where RutCli != '' and Estado != 'N' and Estado != '' Order By RutCli, fechaCotizacion Desc");
	while ($rs=mysqli_fetch_array($bd)){
        $RutCli =  $rs['RutCli'];
        $bdc=$link->query("SELECT * FROM clientes Where RutCli = '$RutCli'");
        if ($rsc=mysqli_fetch_array($bdc)){
            // echo $rsc['Cliente'].'<br>';
        }else{
            echo $rs['RutCli'].' '.$rs['Estado'].' '.$rs['RAM'].' '.$rs['CAM'].' '.$rs['fechaCotizacion'].' Cliente => ';
            echo '*********** SIN DATO ********* <br>';
        }
    
	}
	$link->close();

?>