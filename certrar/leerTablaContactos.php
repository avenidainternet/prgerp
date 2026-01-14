<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../conexionli.php");
$Periodo = date('Y');
$output = [];
$outp = "";
$link=Conectarse();
$SQL = "SELECT * FROM contactoscli where RutCli != '' Order By RutCli, nContacto";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	$Cliente = '';
	$SQLc = "SELECT * FROM clientes where RutCli = '".$rs['RutCli']."' and Estado != 'off' and cFree != 'on' and Docencia != 'on'";
	$bdc=$link->query($SQLc);
	while($rsc = mysqli_fetch_array($bdc)){
		$Cliente = trim($rsc['Cliente']);
	    if ($outp != "") {$outp .= ",";}
	    $outp .= '{"RutCli":"'  . 	$rs["RutCli"]. 			'",';
	    $outp .= '"nContacto":"'. 	$rs["nContacto"]. 		'",';
	    $outp .= '"cCliente":"'. 	$Cliente. 				'",';
	    $outp .= '"Contacto":"'. 	trim($rs["Contacto"]). 	'",';
	    $outp .= '"Email":"'. 		$rs["Email"]. 			'",';
	    $outp .= '"Telefono":"'. 	trim($rs["Telefono"]). 	'"}';
	}
}
$outp ='{"records":['.$outp.']}';

/*
while($rs=mysqli_fetch_array($bd)){
	$output[] = $rs;
}
*/
$link->close();

//echo json_encode($output);
echo ($outp);
?>