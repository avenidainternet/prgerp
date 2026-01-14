<?php
	include_once("../conexionli.php");
	
	if(isset($_GET['CAM'])) 		{ $CAM 		= $_GET['CAM']; 		}
	if(isset($_GET['Rev'])) 		{ $Rev 		= $_GET['Rev'];			}
	if(isset($_GET['Cta'])) 		{ $Cta 		= $_GET['Cta'];			}
	if(isset($_GET['pDescuento'])) 	{ $pDescuento = $_GET['pDescuento'];}

	$link=Conectarse();

	$NetoUF	= 0;
	$NetoP	= 0;
	
	$bddCot=$link->query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
	if($rowdCot=mysqli_fetch_array($bddCot)){
		do{
			$NetoUF += $rowdCot['NetoUF'];
			$NetoP 	+= $rowdCot['Neto'];
		}while ($rowdCot=mysqli_fetch_array($bddCot));
	}

	$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
	if($rowCot=mysqli_fetch_array($bdCot)){

		//$NetoUF 	= $rowCot[NetoUF] / (1+($pDescuento/100));
		//$NetoUF 	= $NetoUF / (1+($pDescuento/100));
		$vDscto 	= intval($NetoUF * $pDescuento)/100;

			//$Neto 	= $NetoUF * $rowCot[valorUF];
		if($rowCot['exentoIva']=='on'){
			$Neto 	= $NetoP *((100-$pDescuento)/100);
			$Iva	= 0;
			$Bruto	= $Neto;

			$NetoUF		= $NetoUF - $vDscto;
			$IvaUF		= 0;
			$TotalUF	= $NetoUF;
		}else{
			$Neto 	= $NetoP *((100-$pDescuento)/100);
			$Iva	= $Neto * 0.19;
			$Bruto	= round($Neto,0) + round($Iva,0);

			$NetoUF		= $NetoUF - $vDscto;
			$IvaUF		= round($NetoUF * 0.19,2);
			$TotalUF	= $NetoUF + $IvaUF;
		}

		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="pDescuento	='".$pDescuento."',";
		$actSQL.="Neto			='".$Neto.		"',";
		$actSQL.="Iva			='".$Iva.		"',";
		$actSQL.="Bruto			='".$Bruto.		"',";
		$actSQL.="NetoUF		='".$NetoUF.	"',";
		$actSQL.="IvaUF			='".$IvaUF.		"',";
		$actSQL.="BrutoUF		='".$TotalUF.	"'";
		$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
		$bdCot=$link->query($actSQL);
	}
	$link->close();

	header("Location: modCotizacion.php?CAM=$CAM&Rev=$Rev&Cta=$Cta");
?>