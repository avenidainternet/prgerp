<?php
function fnDiasHabiles($fInicio, $dHabiles, $hPAM){

	// Calcula Dia de Termino desde la fecha de Inicio
	$j 			= -1;

	if($hPAM >= "12:00:00"){
		$dHabiles--;
		$j 	= 0;

	}else{
		$dHabiles--;
	}

	if($hPAM == "00:00:00"){
	}

	$fechaHoy 	= date('Y-m-d');
	$cdh 		= 0;
	$cds		= 0;
	$dhf		= 0;
	$dha		= 0;
	$ft = '';
	$link=Conectarse();
	// Fecha Inicio = 23/4
	// D.Habiles 	= 8
	// cdh = Cantidad de Dias Habiles
	// cds = Cantidad de Dias Feriados o Fin de Semana
	while($cdh <= $dHabiles) {
																			// cdh 		 =        1    2     3   3     3    4   5    5   6   7   7    7  8   9   5   7
		$j++;																// j		 =        1    2     3   4     5    6   7    8   9   10  11  12  13  14  15  16
		$ft 		= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) ); // ft  		 =  23/4 24/4 25/4 26/5 27/5 28/4 29/4 30/4 1/5 2/5  3/5 4/5 5/5 6/5 7/5 8/5 9/5
																			// Dias 	 =  Mar  Mie  Jue  Vie  Sab   Dom  Lun Mar  Mie Jue  Vie Sab Dom Lun Mar Mie Jue
		$ft			= date ( 'Y-m-d' , $ft );
		$dia_semana = date("w",strtotime($ft));
		$dFeriado   = 'No';
		// $cdh++;
		$dbf=$link->query("SELECT * FROM diasferiados Where fecha = '$ft'");
		if ($rs=mysqli_fetch_array($dbf)){
			// if($dia_semana == 0 or $dia_semana == 6){
				$dFeriado   = 'Si';
			// }
		}
		if($dia_semana == 0 or $dia_semana == 6 or $dFeriado == 'Si'){
			$cds++;
			// $cdh--;
		}else{
			$cdh++;
		}
		if($ft >= $fechaHoy){
			if($dia_semana == 0 or $dia_semana == 6 or $dFeriado == 'Si'){
			}else{
				$dhf++;
			}
		}
	}

	
/*	
	if($hPAM >= "12:00"){
		$j++;
		$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
		$ft	= date ( 'Y-m-d' , $ft );
		$dia_semana 	= date("w",strtotime($ft));
		$dhf++;
		if($dia_semana == 0){
			$j = $j + 2;
			$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
			$ft	= date ( 'Y-m-d' , $ft );
		}
		if($dia_semana == 6){
			$j++;
			$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
			$ft	= date ( 'Y-m-d' , $ft );
		}
	}
*/
	$j 		= 0;
	$dha	= 0;
	$fa		= $ft;
	if($ft < $fechaHoy){
		while($fa < $fechaHoy) {
			$j++;
			$fa 	= strtotime ( '+'.$j.' day' , strtotime ( $ft ) );
			$fa	= date ( 'Y-m-d' , $fa );
			$dia_semana 	= date("w",strtotime($fa));
			$dFeriado   = 'No';
			$dbf=$link->query("SELECT * FROM diasferiados Where fecha = '$ft'"); 
			if ($rs=mysqli_fetch_array($dbf)){
				$dFeriado   = 'Si';
			}
			if($dia_semana == 0 or $dia_semana == 6 or $dFeriado == 'Si'){
				$cds++;
			}else{
				$dha++;
			}
		}
	}
	$link->close();

	return array($ft, $dhf, $dha, $dia_semana, $dHabiles);
}

function fnDiasCorridos($fInicio, $Validez, $hPAM){

	// Calcula Dia de Termino desde la fecha de Inicio
	$fechaHoy 	= date('Y-m-d');
	$j 			= -1;
	$cdh 		= 0;
	$cds		= 0;
	$dhf		= 0;
	$dha		= 0;
	while($cdh < $dHabiles) {
		$j++;
		$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
		$ft	= date ( 'Y-m-d' , $ft );
		$dia_semana 	= date("w",strtotime($ft));
		if($dia_semana == 0 or $dia_semana == 6){
			$cds++;
		}else{
			$cdh++;
		}
		if($ft >= $fechaHoy){
			if($dia_semana == 0 or $dia_semana == 6){
			}else{
				$dhf++;
			}
		}
	}
	if($hPAM >= "12:00"){
		$j++;
		$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
		$ft	= date ( 'Y-m-d' , $ft );
		$dia_semana 	= date("w",strtotime($ft));
		$dhf++;
		if($dia_semana == 0){
			$j = $j + 2;
			$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
			$ft	= date ( 'Y-m-d' , $ft );
		}
		if($dia_semana == 6){
			$j++;
			$ft 	= strtotime ( '+'.$j.' day' , strtotime ( $fInicio ) );
			$ft	= date ( 'Y-m-d' , $ft );
		}
	}

	$j 		= 0;
	$dha	= 0;
	$fa		= $ft;
	if($ft < $fechaHoy){
		while($fa < $fechaHoy) {
			$j++;
			$fa 	= strtotime ( '+'.$j.' day' , strtotime ( $ft ) );
			$fa	= date ( 'Y-m-d' , $fa );
			$dia_semana 	= date("w",strtotime($fa));
			if($dia_semana == 0 or $dia_semana == 6){
				$cds++;
			}else{
				$dha++;
			}
		}
	}

	return array($ft, $dhf, $dha, $dia_semana);
}
?>