<?php
class objFecha {

	function mesAct( $m, $y ){
		$meses = array(
						1  => 'Ene.',
						2  => 'Feb.',
						3  => 'Mar.',
						4  => 'Abr.',
						5  => 'May.',
						6  => 'Jun.',
						7  => 'Jul.',
						8  => 'Ago.',
						9  => 'Sep.',
						10 => 'Oct.',
						11 => 'Nov.',
						12 => 'Dic.'
					);
		$nDias = date("t", $m);
		//echo "Mes " , $nDias.' '.$meses[$m].' de '.$y;
	}
		
	function primerDiaSemana($ns){
		$semana_actual = date("W");
		$dif = $ns - $semana_actual;
		$viernes = date("d-m-Y", strtotime("Monday $dif weeks"));
		return $viernes;
	}
	function ultimoDiaSemana($ns){
		$semana_actual = date("W");
		$dif = $ns - $semana_actual;
		$viernes = date("d-m-Y", strtotime("Friday $dif weeks"));
		return $viernes;
	}
	function uDiaDelMes($m, $y){
		$udm=date("t",mktime(0,0,0,$m,1,$y));
		return $udm;
	}
	function semanaActual(){
		$semana = date("W");
		return $semana;
	}
	function semanaDada($fecha){
		$dia   = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anio = substr($fecha,0,4);  

		$semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));
		return $semana; 
	}
	function primerDiaHabilSemana($ns, $y){
		$semana_actual = date("W")+1;
		$dif = $ns - $semana_actual;
		$lunes = date("d-m-Y", strtotime("Monday $dif week"));
		return $lunes;
	}
	function primerDiaHabilSemanaAnt($fecha, $d){
		$fechaAnt 	= strtotime ( '-'.$d.' day' , strtotime ( $fecha ) );
		$lunes 	= date ( 'Y-m-d' , $fechaAnt );
		return $lunes;
	}
	function ultimoDiaHabilSemanaAnt($fecha, $d){
		$fechaAnt 	= strtotime ( '-'.$d.' day' , strtotime ( $fecha ) );
		$viernes 	= date ( 'Y-m-d' , $fechaAnt );
		return $viernes;
	}
	function ultimoDiaHabilSemana($ns, $y){
		$semana_actual = date("W");
		$dif = $ns - $semana_actual;
		$viernes = date("d-m-Y", strtotime("Friday $dif weeks"));
		return $viernes;
	}
	function NumeroSemanasAno($year){
		$date = new DateTime;
	 
		# Establecemos la fecha segun el estandar ISO 8601 (numero de semana)
		$date->setISODate($year, 53);
	 
		# Si estamos en la semana 53 devolvemos 53, sino, es que estamos en la 52
		if($date->format("W")=="53")
			return 53;
		else
			return 52;
	}
}

?>