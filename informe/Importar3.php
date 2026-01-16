<?php

//path to  the CreateDocx class within your PHPDocX installation
require_once '../phpdocx/classes/CreateDocx.inc';
$docx = new CreateDocxFromTemplate('myTestTemplate.docx');
$docx->replaceVariableByText(array('NAME' => 'John Smith'));
$docx->createDocxAndDownload('AM-1000');
?>
