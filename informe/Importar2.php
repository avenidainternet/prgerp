<?php

//path to  the CreateDocx class within your PHPDocX installation
require_once '../phpdocx/classes/CreateDocx.inc';

$docx = new CreateDocx();

$docx->modifyPageLayout('letter');
 
//$docx->importHeadersAndFooters('plantilla.docx');
//You may import only the header with
//$docx->importHeadersAndFooters('plantilla.docx', 'header');
//and only the footer with
//$docx->importHeadersAndFooters('plantilla.docx', 'footer');
$docx = new CreateDocxFromTemplate('plantilla.docx');
$options = array(
				'target' 		=> 'header',
				'firstMatch' 	=> false,
				);
$docx->replaceVariableByText(array('NAME' => 'CESMEC'), $options);

//$docx->addText('Documento.');
/*
$valuesTable = array(
					array(' ','INFORME DE RESULTADOS','Fecha: '),
    				array(' ','AM-6604-0102','Revisión: 00'),
    				array(' ','CESMEC','Página 1 de 1'),
					);
*/
$valuesTable = array(
					array("","INFORME DE RESULTADOS","Fecha:"),
    				array("",5,6),
    				array("",8,9),
					);
					
$paramsTable = array(
    'tableAlign' 		=> 'center',
	'colspan' 			=> array(3, 0, 0),
    'border' 			=> 'single',
	'columnWidths' 		=> array(2000, 3500, 3200),
    'borderWidth' 		=> 10,
    'borderColor' 		=> 'cccccc',
    'textProperties' 	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 10),
);
$docx->addTable($valuesTable, $paramsTable);



//stablish some row properties for the first row
$trProperties = array();
$trProperties[0] = array('minHeight' => 20,'tableHeader' => true);


$col_2_2 = array(	'rowspan' => 2,
					'colspan' => 2,
					'width' => 200,
					'value' => $textFragment,
					'backgroundColor' => 'ffff66',
					'borderColor' => 'b70000',
					'border' => 'single',
					'cellMargin' => 200,
					'fitText' => 'on',
					'vAlign' => 'bottom',
				);
$col_2_4 = array( 	'rowspan' => 3,
					'value' => 'Some rotated text',
					'backgroundColor' => 'eeeeee',
					'borderColor' => 'b70000',
					'border' => 'single',
					'borderWidth' => 16,
					'textDirection' => 'tbRl',
				);



$col_1_1 = array( 	'rowspan' 			=> 3,
					'value' 			=> 'Uno',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);

$col_1_2 = array( 	'rowspan' 			=> 3,
					'value' 			=> 'INFORME DE RESULTADOS',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'dashed',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);

$col_1_3 = array( 	'value' 			=> 'Fecha: ',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$tit = 'INFORME DE RESULTADOS';
$colImg = array( 	'rowspan' 			=> 3,
					'value' 			=> 'Simet',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colTit = array( 	'rowspan' 			=> 1,
					'value' 			=> $tit,
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderBottom' 		=> 'none',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colAM = array( 	'rowspan' 			=> 1,
					'value' 			=> 'AM-1000',
					'borderColor' 		=> 'cccccc',
					'border' 			=> 'none',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colEmp = array( 	'rowspan' 			=> 1,
					'value' 			=> 'CESMEC',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'none',
					'borderBottom' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colFec = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Fecha:',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colRev = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Revision: 00',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
$colPag = array( 	'rowspan' 			=> 1,
					'value' 			=> 'Pagina: 1 de 1',
					'borderColor' 		=> 'cccccc',
					'borderTop' 		=> 'single',
					'borderWidth' 		=> 1,
					'cellMargin' 		=> 15,
				);
				
				
//set teh global table properties
$options = array(	'columnWidths' 		=> array(2000, 3500, 3200),
				);

$values = array( 	array($colImg, $colTit, $colFec),
					array($colAM,  $colRev),
					array($colEmp, $colPag),
				);

				
$docx->addTable($values, $options, $trProperties);
$docx->replaceVariableByText(array("NOMBRE" => "John Smith"));
$docx->createDocxAndDownload('AM-1000');
?>
