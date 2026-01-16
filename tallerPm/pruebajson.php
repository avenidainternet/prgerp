<?php
include_once("../conexionli.php");

$link=Conectarse();
$RAMold = '';
$outp = '';
$SQL = "Select * From tablaorientacion Order By idItem Asc";
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
         
    $id = explode('-', $rs['idItem']);
    $RAM = $id[0];

    if($RAMold != $RAM){
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"RAM":"'             . $RAM. 		            '",';
        $outp .= '"pdfOrientacion":"'   . $rs['pdfOrientacion']. 	'"}';
        $RAMold = $RAM;
    }
    
}

$outp ='{"records":['.$outp.']}';
echo ($outp);
$link->close();
?>