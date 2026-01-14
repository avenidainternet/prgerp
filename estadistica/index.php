<?php
	session_start(); 
	include("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

/*
					$link=Conectarse();
					$tNeto	= 0;
					$fd 	= '';
					$agnoAct = 0;
					$mesAct	 = 0;
					$fechaIndice = '0000-00-00';
					
					$result  = $link->query("SELECT * FROM SolFactura Where pagoFactura = 'on' Order By fechaSolicitud Asc");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							if($rowGas['fechaSolicitud'] < '2015-08-01'){
								$fd = explode('-',$rowGas['fechaSolicitud']);
								$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
								if($rowP=mysqli_fetch_array($bdPer)){
									$cFree = $rowP['cFree'];
									if($rowP['cFree'] != 'on'){
										if($rowGas['Neto'] > 0){
											$tNeto += $rowGas['Neto'];
										}
									}
								}
	
								if($mesAct == 0){
									$mesAct = $fd[1];
								}
								if($mesAct != $fd[1]){
									$mesAct 		= $fd[1];
									$vNeto 			= round($tNeto/1000000,2);
									$fechaIndice 	= $fd[0].'-'.$fd[1].'-01';
									$indVtas 		= $vNeto;
									$tNeto			= 0;
									$bdPer=$link->query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaIndice."'");
									if($rowP=mysqli_fetch_array($bdPer)){
									}else{
										$link->query("insert into tabIndices(	fechaIndice,
																				indVtas
																			) 
																values 		(	'$fechaIndice',
																				'$indVtas'
																				)",$link);
									}
								}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$tNeto = round($tNeto/1000000,2);


					$tProductividad = 0;
					$vProd 	= 0;
					$vNeto	= 0;
					$mesAct = 0;
					$vUF	= 25000;
					$result  = $link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and fechaInicio != '0000-00-00' and fechaInicio < '2015-08-01' Order By fechaInicio Asc");
					if($rowGas=mysqli_fetch_array($result)){
						do{
							$fd = explode('-',$rowGas['fechaInicio']);
							$bdPer=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowGas['RutCli']."'");
							if($rowP=mysqli_fetch_array($bdPer)){
								if($rowP['cFree'] != 'on'){
									if($rowGas['NetoUF']>0){
										$vNeto = ($rowGas['NetoUF'] * $vUF);
									}else{
										$vNeto = $rowGas['Neto'];
									}
									$tProductividad += $vNeto;
								}
							}
							if($mesAct == 0){
								$mesAct = $fd[1];
							}
							if($mesAct != $fd[1]){
									$mesAct 		= $fd[1];
									$vProd 			= round($tProductividad/1000000,2);
									$fechaIndice 	= $fd[0].'-'.$fd[1].'-01';
									$iProductividad	= $vProd;
									$tProductividad	= 0;
									$bdPer=$link->query("SELECT * FROM tabIndices Where fechaIndice = '".$fechaIndice."'");
									if($rowP=mysqli_fetch_array($bdPer)){
										$actSQL="UPDATE tabIndices SET ";
										$actSQL.="iProductividad	 ='".$iProductividad."'";
										$actSQL.="WHERE fechaIndice = '".$fechaIndice."'";
										$bd=$link->query($actSQL);
									}else{
										$link->query("insert into tabIndices(	fechaIndice,
																				iProductividad
																			) 
																values 		(	'$fechaIndice',
																				'$iProductividad'
																				)",$link);
									}
							}
						}while ($rowGas=mysqli_fetch_array($result));
					}
					$link->close();
*/

	
	
	$agnoHasta = date('Y');

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

	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo Estadísticas
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Descargar Estadística">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>

			
			</div>
			
			<form name"form" action="index.php" method="get">
			<div id="BarraFiltro">
				Filtro 
				<div style="padding-left:15px; display:inline;">
					<?php
						$fechaHoy = date('Y-m-d');
						$dos = 2;
						$f2 	= strtotime ( '-'.$dos.' year' , strtotime ( $fechaHoy ) );
						$f2 	= date ( 'Y-m-d' , $f2 );
						$f2		= explode('-',$f2);
						
						
						$agnoHasta = date('Y');
						$agnoDesde = $f2[0];
						$Agno 		= date('Y');
						$AgnoTabla	= date('Y');

						if(isset($_GET['agnoHasta'])) { 
							$agnoHasta = $_GET['agnoHasta'];
							$agnoDesde = $agnoHasta - 2; 
							$AgnoTabla = $agnoHasta;
						}
						
					?>
	  				<input name='agnoDesde' id='agnoDesde' size=5 maxlength=5 value="<?php echo $agnoDesde; ?>" readonly>
					-
	  				<input name='agnoHasta' id='agnoHasta' size=5 maxlength=5 value="<?php echo $agnoHasta; ?>">
					<button>
						Filtrar
					</button>
				</div>
			</div>
			</form>
			<?php include_once('estadisticaProduccion.php'); ?>
			<?php //include_once('estadisticaVentas.php'); ?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
