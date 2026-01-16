<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Emisi&oacute;n de Formularios</title>

<script>
    function open_factura(){
		window.open("F3B-00001.pdf");
	}
</script>
<script>
		open_factura();
</script>

</head>
<body>
<?php 
 header("Pragma: public"); 
 header("Expires: 0"); 
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
 header("Content-Type: application/force-download"); 
 header("Content-Type: application/pdf"); header("Content-Type: application/download");
 header("Content-Disposition: attachment; filename=\"F3B-00001.pdf\""); 
 header("Content-Transfer-Encoding: binary"); 
 $handle=fopen("F3B-00001.pdf","r"); 
 $contents=''; 
 while (!feof($handle)) { 
 	$contents.=fread($handle, 8192); 
 } 
 fclose($handle); 
 echo $contents; 
 ?>
</body>
</html>

