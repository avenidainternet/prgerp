<?php

//path to  the CreateDocx class within your PHPDocX installation
require_once '../phpdocx/classes/CreateDocx.inc';

$docx = new CreateDocx();
$docx->modifyPageLayout('letter');
$docx->importHeadersAndFooters('plantilla.docx');
$docx->addText('Documento.');
//You may import only the header with
//$docx->importHeadersAndFooters('TemplateHeaderAndFooter.docx', 'header');
//and only the footer with
//$docx->importHeadersAndFooters('TemplateHeaderAndFooter.docx', 'footer');
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

$docx->addText('Este es un Fragmento del Texto.');

//create a simple Word fragment to insert into the table
$textFragment = new WordFragment($docx);
$text = array();
$text[] = array('text' => 'Fit text and ');
$text[] = array('text' => 'Word fragment', 'bold' => true);
$textFragment->addText($text);

//stablish some row properties for the first row
$trProperties = array();
$trProperties[0] = array('minHeight' => 700,'tableHeader' => true);

$col_1_1 = array( 	'rowspan' => 4,
					'value' => 'Uno',
					'backgroundColor' => 'cccccc',
					'borderColor' => 'b70000',
					'border' => 'single',
					'borderTopColor' => '0000FF',
					'borderWidth' => 16,
					'cellMargin' => 200,
				);
				
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
				
//set teh global table properties
$options = array(	'columnWidths' 		=> array(400,1400,400,400,400),
					'border' 			=> 'single',
					'borderWidth' 		=> 4,
					'borderColor' 		=> 'cccccc',
					'borderSettings' 	=> 'inside',
					'float' 			=> array(	'align' => 'right',
													'textMargin_top' => 300,
													'textMargin_right' => 400,
													'textMargin_bottom' => 300,
													'textMargin_left' => 400
												),
				);

$values = array( 	array($col_1_1, '1_2', '1_3', '1_4', '1_5'),
					array($col_2_2, $col_2_4, '2_5'),
					array('3_5'),
					array('4_2', '4_3', '4_5'),
				);
				
$docx->addTable($values, $options, $trProperties);
$docx->addText('Otro Trozo de Texto.');

$docx->createDocxAndDownload('AM-1000');
?>
