<?php
// Include the PHPWord.php, all other classes were loaded by an autoloader
require_once 'PHPWord.php';

// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();

// After creating a section, you can append elements:
$section->addText('Hola Mundo!');

// You can directly style your text by giving the addText function an array:
$section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:
$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');

// You can also putthe appended element to local object an call functions like this:
$myTextElement = $section->addText('Hello World!');
//$myTextElement->setBold();
//$myTextElement->setName('Verdana');
//$myTextElement->setSize(22);
$header = $section->createHeader();

$header->addPreserveText('Página {PAGE} de {NUMPAGES}.');


$footer = $section->createFooter();
$footer->addPreserveText('Página {PAGE} de {NUMPAGES}.');

// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('helloWorld.docx');
?>