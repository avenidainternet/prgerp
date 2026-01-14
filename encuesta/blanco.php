<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php
	$EmailB = 'Blanco No';
	if(EmailB){
		echo 'Blanco No'.'<br>';
	}
	$Email = $_GET[Email];
	if($Email){
		echo 'Correo '.$Email;
	}
	
?>
</body>
</html>
