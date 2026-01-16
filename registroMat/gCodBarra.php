<?php
	include_once('../codigoqr/phpqrcode/qrlib.php');
    $PNG_TEMP_DIR 	= dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR 	= 'temp/';

	$RutCli 	= $_GET[RutCli];
	$RAM 		= $_GET[RAM];

	if(strlen($RutCli)<10){
		$cCli = '0'.substr($RutCli,0,8);
	}else{
		$cCli = substr($RutCli,0,8);
	}
	$codBarra	= $cCli.$RAM;
	
	$dirinfo  = "http://simet.cl/erp/registroMat/regMuestras.php?RAM=".$RAM;

    if(!file_exists($PNG_TEMP_DIR))
    	mkdir($PNG_TEMP_DIR);
	    $filename 				= $PNG_TEMP_DIR.'test.png';
		$matrixPointSize 		= 4;
		$errorCorrectionLevel 	= 'L';
		
		QRcode::png($dirinfo, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    

		echo '<img width="120" src="http://barcode.tec-it.com/barcode.ashx?code=EAN13&modulewidth=fit&data='.$codBarra.'&dpi=96&imagetype=png&rotation=0&color=&bgcolor=&fontcolor=&quiet=0&qunit=mm&download=true" alt="Generador de código de barras TEC-IT"/>';
		echo '<img width="60" src="'.$PNG_WEB_DIR.basename($filename).'" />';

?>