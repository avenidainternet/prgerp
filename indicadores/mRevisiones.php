<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	//header('Content-Type: text/html; charset=utf-8'); 
	
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
/*
	if($_SESSION['Perfil'] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 	= $_SESSION['usuario'];
	$accion 	= '';
	

	$fechaHoy 	= date('Y-m-d');
	$fd 		= explode('-', $fechaHoy);
	$pAgno 		= 0;
	$pMes		= 0;
	$porMes		= 'No';
	$nMod		= 0;
	
	if(isset($_GET['nMod'])) 		{ $nMod 	= $_GET['nMod']; 	}
	if(isset($_GET['agnoMod'])) 	{ $pAgno 	= $_GET['agnoMod']; }
	if(isset($_GET['mesMod'])) 		{ $pMes 	= $_GET['mesMod']; 	}
	if(isset($_GET['porMes'])) 		{ $porMes 	= $_GET['porMes']; 	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Indicadores</title>
	
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">

</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/indicador.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					INDICADORES: ( 
					<?php
						$link=Conectarse();
						$bdIm=$link->query("SELECT * FROM ItemsMod Where nMod = $nMod");
						if($rowIm=mysqli_fetch_array($bdIm)){
							echo $rowIm['Modificacion'];
						}
						$link->close();
					?>
					 )
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('barraSupIconosRev.php'); ?>
		</div>
	</div>
	
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloSel">
		<tr>
			<td  width="10%" align="center" height="40">Fecha<br>Revisión			</td>
			<td  width="20%">							Revisión						</td>
			<td  width="10%">							Informe						</td>
			<td  width="20%">							Cliente						</td>
			<td  width="40%" align="center">			Descripción					</td>
		</tr>
		<?php
			$tr = 'bVerdeSel';
			$link=Conectarse();
			if($pAgno > 0 and $pMes > 0 and $porMes == 'No'){
				$SQL = "SELECT * FROM regRevisiones Where nMod = $nMod and year(fechaMod) = $pAgno and month(fechaMod) = $pMes Order By fechaMod Desc";
			}
			if($pAgno > 0 and $pMes == 0 and $porMes == 'No'){
				$SQL = "SELECT * FROM regRevisiones Where nMod = $nMod and year(fechaMod) = $pAgno Order By fechaMod Desc";
			}
			if($pAgno > 0 and $pMes > 0 and $porMes == 1 and $nMod == 0){
				$SQL = "SELECT * FROM regRevisiones Where year(fechaMod) = $pAgno and month(fechaMod) = $pMes Order By fechaMod Desc";
			}
			if($pAgno > 0 and $pMes == 0 and $porMes == 'No' and $nMod == 0){
				$SQL = "SELECT * FROM regRevisiones Where year(fechaMod) = $pAgno Order By fechaMod Desc";
			}
			if($pAgno > 0 and $pMes == 0 and $porMes == 'No' and $nMod > 0){
				$SQL = "SELECT * FROM regRevisiones Where year(fechaMod) = $pAgno and nMod = $nMod Order By fechaMod Desc";
			}
			$bdIm=$link->query($SQL);
			if($rowIm=mysqli_fetch_array($bdIm)){
				do{?>
					<tr class="<?php echo $tr; ?>">
						<td>
							<?php echo $rowIm['fechaMod']; ?>
						</td>
						<td>
							<?php  
								$bdIR=$link->query("SELECT * FROM ItemsMod Where nMod = '".$rowIm['nMod']."'");
								if($rowIR=mysqli_fetch_array($bdIR)){
									echo $rowIR['Modificacion'];
								}
							?>
						</td>
						<td>
							<?php echo $rowIm['CodInforme']; ?>
						</td>
						<td>
							<?php 
								$bdInf=$link->query("SELECT * FROM Informes Where CodInforme = '".$rowIm['CodInforme']."'");
								if($rowInf=mysqli_fetch_array($bdInf)){
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$rowInf['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										echo $rowCli['Cliente']; 
									}
								}
							?>
						</td>
						<td>
							<?php 
								$bdInf=$link->query("SELECT * FROM Informes Where CodInforme = '".$rowIm['CodInforme']."'");
								if($rowInf=mysqli_fetch_array($bdInf)){
									echo $rowInf['Detalle']; 
								}
							?>
						</td>
					</tr>
					<?php
				}while ($rowIm=mysqli_fetch_array($bdIm));
			} 
			$link->close();
		?>
		
	</table>
</body>
</html>


