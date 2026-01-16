<?php
// add a footer

require_once '../phpdocx/classes/CreateDocx.php';

$docx = new CreateDocx();

// create a Word fragment with an image to be inserted in the header of the document
$imageOptions = array(
	'src' => '../phpdocx/examples/img/image.png', 
	'dpi' => 300,  
);

$footerImage = new WordFragment($docx, 'defaultFooter');
$footerImage->addImage($imageOptions);

$docx->addFooter(array('default' => $footerImage));
// add some text
$docx->addText('This document has a footer with just one image.');

$docx->createDocxAndDownload('example_addFooter_1');
?>