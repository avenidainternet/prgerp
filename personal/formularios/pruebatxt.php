<?php
$LinText  = "desarrollo, coordinación, promoción y apoyo a las actividades que realice la";
$LinText2 = "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345";
//echo Justifica($LinText).'<br>';
//echo $LinText2.'<br>';
echo '<div style="width:500px;">';
echo "Imprime texto: $LinText\n";
echo '</div>';

function Justifica($t){
	if(strlen($t)<85){
		$i = 0;
		while (strlen($t)<85){
			echo "Valor de i = ".$i.' - '.substr($t,$i,1).'<br>';
			if(substr($t,$i,1)==" "){
				$t = substr($t,0,$i+1)."-".substr($t,$i+1);
				echo strlen($t).' - '.substr(ltrim($t),$i,1).' - '.$t.'<br>';
				$i++;
			}
			$i++;
			if(strlen($t)<=$i){
				   $i = 0;
			}
		}
	}
	return $t.strlen($t);
}
?>