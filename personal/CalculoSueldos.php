<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	$Mm = "Junio";
	$Agno = $fd[0];
	if(isset($_GET['Agno'])) { 
		$Agno 	= $_GET['Agno']; 
	}
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$Agno;
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$Agno;
	}

	$pPago = $Mm.'.'.$Agno;

	$MesSueldo = "";

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM Sueldos");
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<script src="../jquery/jquery-1.6.4.js"></script>
<script>
$(document).ready(function(){
	$("#SueldoBase").bind('keydown', function(event)
	{
		//alert(event.keyCode);
		if (event.keyCode == '9')
			{
	  		var Sb   = $(this).val();
			var Rut  = $("#Run").val();
			var Ppa  = $("#PeriodoPago").val();
			var data = 'search='+ Rut;
			var Pr = Math.round(Sb * 0.37);
			var Li = Math.round(Sb * 1.37);
			$("#Prevision").val(Pr);
			$("#Liquido").val(Li);
			
            $.ajax({
                data: data,
                type: "POST",
                url: "guardaSueldo.php",
                beforeSend: function(html) { // this happens before actual call
                    $("#Msg").html('');
               },
               success: function(Respuesta){ // this happens after we get results
					alert(Respuesta.split(",")[0]);
					$("#Liquido").html(Respuesta.split(",")[0]);
              }
            });   

			
			return 0;
			}
	});
});
</script>

</head>

<body>
	<?php include_once('head.php'); ?>
	<?php
		$pp = explode('.',$PeriodoPago);
		$pp = $pp[1].'-'.$pp[0].'-01';
		if($pp < "2017-01-01"){
			include_once('calculoSueldos2016.php');
		}else{
			include_once('calculoSueldos2017.php');
		}
	?>
	
</body>
</html>
