<?php
$LinText = "Este es un texto de menos de 10 caracteres";
echo $LinText.strlen($LinText).'<br>';
echo Justifica($LinText).'<br>';


function Justifica($t){
	if(strlen($t)<52){
		$i = 0;
		while (strlen($t)<52){
			echo "Valor de i = ".$i.' - '.substr($t,$i,1).'<br>';
			if(substr($t,$i,1)==" "){
				$t = substr($t,0,$i+1)." ".substr($t,$i+1);
				echo strlen($t).' - '.substr($t,$i,1).'<br>';
				$i++;
			}
			$i++;
			if($i>52){
				   $i = 0;
			}
		}
	}
	return $t.strlen($t);
}
?>