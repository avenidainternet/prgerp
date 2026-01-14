<?php
		date_default_timezone_set("America/Santiago");
		include("Mobile-Detect-2.3/Mobile_Detect.php");
 		$Detect = new Mobile_Detect();
		
		//if ($_GET['usr'] != 'RAUL') {
		//	header("Location: http://servidordata/erperp");
		//}
		

	$colorHead = "degradado";
	$nomservidor = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	if($nomservidor == 'servidordata'){
		$colorHead = "degradadoRojo";
	}

	include_once("conexionli.php");
	$usr 	= "";
	$Login 	= '';
	if(isset($_POST['acceso'])){
		if(isset($_POST['Login'])){
			$link=Conectarse();
			$bdusr=$link->query("SELECT * FROM Usuarios Where usr Like '%".$_POST['Login']."%' && pwd = '".$_POST['pwd']."'");
			if($row=mysqli_fetch_array($bdusr)){
  				session_start(); 
    			$_SESSION['usr']		= $row['usr']; 
    			$_SESSION['pwd']		= $row['pwd'];
    			$_SESSION['usuario']	= $row['usuario'];
    			$_SESSION['IdPerfil']	= $row['nPerfil'];
				$nPerfil 				= $row['nPerfil'];
				
				$usuario = $row['usr'];
				
				$fechaHoy = date('Y-m-d');
				$horaIngreso = date('H:i:s');
				$fc = explode('-',$fechaHoy);
				// Consultar por el cierre del dia anterior 19:00 Cierre
				
				$bdCtl  = $link->query("SELECT * FROM relojControl Where usr = '".$row['usr']."' and month(fecha) = '".$fc[1]."' and horaSalida = '00:00:00'");
				if($rowCtl=mysqli_fetch_array($bdCtl)){
					do{
						$horaSalida = '19:00:00';
						$fecha = $rowCtl['fecha'];
						$hi = explode(':',$rowCtl['horaIngreso']);
						$hs = explode(':',$horaSalida);
						$thd = $hs[0] - $hi[0];
						$tmd = $hs[1] + $hi[1];
						$tsd = $hs[2] + $hi[2];
						if($tsd >= 60){
							$tsd = $tsd - 60;
							$tmd++;
						}
						if($tmd >= 60){
							$tmd = $tmd - 60;
							$thd++;
						}
						if($thd < 10){ $thd = '0'.$thd; }
						if($tmd < 10){ $tmd = '0'.$tmd; }
						if($tsd < 10){ $tsd = '0'.$tsd; }
				
						$td = $thd.':'.$tmd.':'.$tsd;
						//$td = $thd.':'.$hi[1].':'.$hi[2];

						$actSQL="UPDATE relojControl SET ";
						$actSQL.="horaSalida	= '".$horaSalida."',";
						$actSQL.="horasDia		= '".$td."'";
						$actSQL.="WHERE usr = '".$row['usr']."' and fecha = '".$fecha."'";
						$bdProc=$link->query($actSQL);
					}while($rowCtl=mysqli_fetch_array($bdCtl));
				}

				$bdCtl  = $link->query("SELECT * FROM relojControl Where usr = '".$row['usr']."' and fecha = '".$fechaHoy."'");
				if($rowCtl=mysqli_fetch_array($bdCtl)){
/*				
					$actSQL="UPDATE relojControl SET ";
					$actSQL.="horaIngreso		= '".$horaIngreso."'";
					$actSQL.="WHERE usr = '".$row['usr']."' and fecha = '".$fechaHoy."'";
					$bdProc=$link->query($actSQL);
*/					
				}else{
					$link->query("insert into relojControl(	usr,
															fecha,
															horaIngreso
													) 
										values 		(		'$usuario',
															'$fechaHoy',
															'$horaIngreso'
													)");
				}
				
			}
			$link->close();
			if(isset($_SESSION['usr'])){
				if(intval($nPerfil)===6){
					header("Location: infoTv.php");
				}else{
					if(intval($nPerfil)===4){
						header("Location: registroMat/recepcionMuestras.php");
					}else{
						if(intval($nPerfil)===5){
							header("Location: tallerPM/pTallerPM.php");
						}else{
							header("Location: plataformaErp.php");
						}
					}
				}
			}
		}
	}
?>

<?php
/* CREACION CARPETAS EN EL DATA */
$agnoActual = date('Y'); 

$directorioAM = 'Y://AAA/Archivador-'.$agnoActual;
$directorioAM = 'Y://AAA/LE';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

// Finanzas
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas';
$directorioAM = 'Y://AAA/LE/FINANZAS/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion';
$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual;
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/COTIZACIONES/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/HONORARIOS/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
// Fin Creación Carpeta FINANZAS

// Creación Carpeta LABORATORIO

$directorioAM = 'Y://AAA/LE/LABORATORIO/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/LABORATORIO/'.$agnoActual;
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

// Creación Carpeta LABORATORIO
// Creación Carpeta CALIDAD

$directorioAM = 'Y://AAA/LE/CALIDAD/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/CALIDAD/AC/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/CALIDAD/ARO/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/CALIDAD/POC-IOC-REG/';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

// Creación Carpeta CALIDAD

/*
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}

$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Honorarios';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/PagoFacturas';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/Gastos/Reembolsos';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
*/
// Laboratorio
/*
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AR';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Actividades';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoEspectrometro';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/LE/LABORATORIO/'.$agnoActual.'/RespaldoEspectrometro';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/INN-17025';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
$directorioAM = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/INN-17065';
if(!file_exists($directorioAM)){
	mkdir($directorioAM);
}
*/
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />


	<title>Plataforma ERP Local de Simet</title> 

	<link href="estilos2.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="validaciones.js"></script> 
	
</head>

<body onLoad="document.acceso.usr.focus();">
	<?php include('head.php'); ?>

	<div id="CuerpoPagina">

		<div id="CajaCpoIzq">
			<form name="acceso" action="index.php" method="post">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		        	<tr>
		            	<td width="12%">&nbsp;</td>
		                <td width="82%">&nbsp;</td>
		                <td width="6%">&nbsp;</td>
		            </tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td><div align="left" class="titulomodulo">Acceso a Plataforma </div></td>
		                <td>&nbsp;</td>
		         	</tr>
		            <tr>
		            	<td>&nbsp;</td>
		               	<td>&nbsp;</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td class="usrpwd">Usuario</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td><input name="Login" type="text" id="usr" value='<?php echo $Login; ?>'></td>
		                <td>&nbsp;</td>
		          	</tr>
		           	<tr>
		            	<td>&nbsp;</td>
		               	<td class="msgejazul">&nbsp;</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		            	<td>&nbsp;</td>
		                <td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            </tr>
		           	<tr>
		              	<td>&nbsp;</td>
		                <td class="usrpwd">Contrase&ntilde;a</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td><input name="pwd" type="password" id="pwd"></td>
		                <td>&nbsp;</td>
		        	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		           	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td><input type="submit" name="acceso" value="Enviar"></td>
		                <td>&nbsp;</td>
		         	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		            </tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td class="alertaazul">&iquest;Olvido Contrase&ntilde;a?</td>
		                <td>&nbsp;</td>
		          	</tr>
		            <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		           	</tr>
				</table>
			</form>
		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>
