<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexioncert.php"); 
$linkc=ConectarseCert();
$outp = "";
$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
$bd=$linkc->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$fechaUpLoad = date("Y-m-d");

	$actSQL="UPDATE certificado SET ";
	$actSQL.="fechaUpLoad            	= '".$fechaUpLoad. 				"' ";
	$actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado. "'";
	$bdAct=$linkc->query($actSQL);
}

$SQL = "SELECT * FROM certificado Where CodCertificado = '$dato->CodCertificado'";
$bd=$linkc->query($SQL);
while($rs=mysqli_fetch_array($bd)){
	$Cliente = '';
	
	$SQLc = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
	$bdc=$linkc->query($SQLc);
	if($rsc=mysqli_fetch_array($bdc)){
		$Cliente = $rsc['Cliente'];
	}

  	if ($outp != "") {$outp .= ",";}
  	$outp .= '{"RutCli":"'  			. $rs["RutCli"] 			. '",'; 
  	$outp .= '"nCliente":"'  			. $rs["nCliente"] 			. '",';
  	$outp .= '"fechaUpLoad":"'  		. $rs["fechaUpLoad"] 		. '",';
  	$outp .= '"CodCertificado":"' 		. $rs["CodCertificado"] 	. '",';
  	$outp .= '"CodigoVerificacion":"' 	. $rs["CodigoVerificacion"] . '",';
  	$outp .= '"Lote":"' 				. $rs["Lote"] 				. '",';
  	$outp .= '"nDescargas":"' 			. $rs["nDescargas"] 		. '",';
  	$outp .= '"upLoad":"' 				. $rs["upLoad"] 			. '",';
  	$outp .= '"Estado":"' 				. $rs["Estado"] 			. '",';
  	$outp .= '"Cliente":"' 				. $Cliente 					. '",';
  	$outp .= '"pdf":"'	    			. $rs["pdf"]  				. '"}';
}
//$outp ='{"records":['.$outp.']}';
$linkc->close();

$json_string = $outp;
$file = '../certificados/certificado.json'; 
file_put_contents($file, $json_string);

	
					$host="ftp.simet.cl";
					$login="simet";
					$password="Alf.86382165";
					$ftp=ftp_connect($host) or die ("no puedo conectar");
					ftp_login($ftp,$login,$password) or die ("Conexión rechazada");

					ftp_chdir($ftp,"/public_html/certificados/certificados");

					if (ftp_put($ftp,$dato->pdf,"../certificados/".$dato->pdf,FTP_BINARY)){
					}else{
						echo "Error al subir el archivo<br>"; 
					}

					if (ftp_put($ftp,$file,"../certificados/".$file,FTP_BINARY)){
					}else{
						echo "Error al subir el archivo<br>"; 
					}
					ftp_quit($ftp);

// header("Location: https://simet.cl/certificados/certificados/leerbd.php");					

?>