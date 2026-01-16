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
		header("Location: ../index.php");
	}
	$dBuscar 	= '';
	$Estado		= '';
	$MesFiltro 	= '';
	$Agno 		= date('Y');
	$AgnoHasta	= date('Y');
	if(isset($_POST['Agno'])) 		{ $Agno 	 	= $_POST['Agno']; 		}
	if(isset($_POST['AgnoHasta'])) 	{ $AgnoHasta 	= $_POST['AgnoHasta']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 		= $_GET['Agno']; 		}
	if(isset($_GET['AgnoHasta'])) 	{ $AgnoHasta	= $_GET['AgnoHasta']; 	}
	
	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el n�mero de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ingresocaja.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el n�mero de filas
		$link->close();
		if($numero==0){
			header("Location: registragastos.php");
		}
	}
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
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	$bdGto->num_rows - $nRegistros;
		$limite	=	$bdGto->num_rows;
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  	<link rel="stylesheet" href="/resources/demos/style.css">
  
	<script>
	function realizaProceso(Proyecto, Estado, MesFiltro, Agno, AgnoHasta, RutCli){
		var parametros = {
			"Proyecto" 	: Proyecto,
			"Estado"	: Estado,
			"MesFiltro"	: MesFiltro,
			"Agno"		: Agno,
			"AgnoHasta"	: AgnoHasta,
			"RutCli"	: RutCli
		};
		//alert(Agno);
		$.ajax({
			data: parametros,
			url: 'muestraHistorico.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo de Histórico 
				</strong>
				<?php //include('barramenu.php'); ?>

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
					<a href="clientes.php" title="Clientes">
						<img src="../gastos/imagenes/contactus_128.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<?php
						if(isset($_GET['RutCli'])) {?>
							<a href="exportarFacturas.php?RutCli=<?php echo $_GET['RutCli'];?>&Agno=<?php echo $_GET['Agno']; ?>&AgnoHasta=<?php echo $_GET['AgnoHasta'];?>" title="Descargar Solitudes de Facturas...">
								<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
							</a>
							<?php
						}else{?>
							<a href="exportarFacturas.php" title="Descargar Solitudes de Facturas...">
								<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
							</a>
							<?php
						}
					?>
				</div>
			</div>

			<div id="BarraFiltro">
				<?php 
					$agnoAct 	= date('Y');
					$agnoIni	= date('Y');
					$link=Conectarse();
					$bdFac=$link->query("Select * From SolFactura Where Factura = 'on' Order By fechaSolicitud Asc");
					if($rowFac=mysqli_fetch_array($bdFac)){
						$fd 		= explode('-',$rowFac['fechaSolicitud']);
						$agnoIni 	= $fd[0];
					}
					$link->close();
				?>
				<div class="opcFiltro">
				<form name="form" action="plataformaHistorica.php" method="post">
				Periodo :
					Desde 
					<?php 
						if(isset($_POST['Agno'])){ 
							$Agno 	 	= $_POST['Agno']; 		
						}else{
							$Agno = $agnoAct - 1; 
						}
					?>
					<select name="Agno">
						<?php
							if(isset($_GET['Agno'])){ $Agno = $_GET['Agno']; }
							for($i=$agnoIni; $i<=$agnoAct; $i++){
								if($i == $Agno){
									?>
									<option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
								}else{
									?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
								}
							}
						?>
					</select>
					 Hasta 
					<select name="AgnoHasta">
						<?php
							for($i=$agnoIni; $i<=$agnoAct; $i++){
								if($i == $AgnoHasta){
									?>
									<option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
								}else{
									?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
								}
							}
						?>
					</select>
					<button name="filtrar">
						Filtro
					</button>
					<?php
						$fechaHoy = date('Y-m-d');
						$fechaDesde 	= strtotime ( '-365 day' , strtotime ( $fechaHoy ) );
						$fechaDesde 	= date ( 'Y-m-d' , $fechaDesde );

						$fechaHasta 	= strtotime ( '-30 day' , strtotime ( $fechaHoy ) );
						$fechaHasta 	= date ( 'Y-m-d' , $fechaHasta );
						//echo $fechaDesde.' '.$fechaHasta.'<br>';
					?>
				</form>
				</div>
			</div>

			<?php include_once('solicitudesFacturas.php'); ?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
