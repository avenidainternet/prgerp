<?php
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
$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('F2707ME01.docx');
$Formulario = 'F2707-'.$fechaHoy;
$docx->createDocxAndDownload($Formulario);
unlink($Formulario.'.docx');

?>