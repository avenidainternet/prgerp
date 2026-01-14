<?php
ini_set('SMTP','mail.google.com');
ini_set('smtp_port',465);

$para      = 'francisco.olivares.rodriguez@gmail.com';
$titulo    = 'El título';
$mensaje   = 'Hola';
$cabeceras = 'From: francisco.olivares@liceotecnologico.cl' . "\r\n" .
    'Reply-To: francisco.olivares@liceotecnologico.cl' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail($para, $titulo, $mensaje, $cabeceras)){
	echo 'ENVIADO CON EXITO...';
}else{
	echo 'ERROR...';
}
?>
