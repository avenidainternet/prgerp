<?php
/*
header('Content-Type: text/html; charset=utf-8');

$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
			);

include_once("../../conexionli.php");
require_once '../../phpdocx/classes/CreateDocx.inc';
$fechaHoy = date('Y-m-d');

$docx = new CreateDocx();
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('A4');
$docx = new CreateDocxFromTemplate('F2701VD01.docx');

$docy = new CreateDocx();
$docy = new CreateDocxFromTemplate('F2707ME01.docx');

$docz = new CreateDocx();
$docz = new CreateDocxFromTemplate('F2801CID02.docx');

$Formulario = 'Formularios1';
$docx->createDocxAndDownload($Formulario);
unlink($Formulario.'.docx');
$Formulario = 'Formularios2';
$docy->createDocxAndDownload($Formulario);
$Formulario = 'Formularios3';
$docz->createDocxAndDownload($Formulario);
*/
$enlace = "FormulariosDureza.pdf";
header ("Content-Disposition: attachment; filename=FormulariosDureza.pdf"); 
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>