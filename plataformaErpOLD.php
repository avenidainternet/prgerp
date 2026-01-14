<?php
	session_start(); 
	include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	$maxCpo = '100%';
	$dBuscar = '';

	$colorHead = "degradadoRojo";
	$nomservidor = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	if($nomservidor == 'servidordata'){
		$colorHead = "degradadoRojo";
	}

	include_once("conexionli.php"); 

		$link=Conectarse();
		$bdCli=$link->query("SELECT * FROM SolFactura Where valorUF > 0 Order By valorUF Desc");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUF'];
		}
		$bdCli=$link->query("SELECT * FROM tablaregform");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$ultUF = $rowCli['valorUFRef'];
		}
		
		$link->close();

	$accion = '';
	$CAM = '';
	$RAM = '';
	$Rev = '';
	$Cta = '';
	$nPerfil = 0;


	$link=Conectarse();
	$CodInforme 	= '';
	$infoNumero 	= 0;
	$infoSubidos 	= 0;
	$CAM 			= 0;
	$SQL = "Select * From cotizaciones Where infoNumero = 0 and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		$CodInforme = 'AM-'.$rs['RAM'];
		$infoNumero 	= 0;
		$infoSubidos 	= 0;
	
		$CAM = $rs['CAM'];
		$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
		while($rowInf=mysqli_fetch_array($bdInf)){
			$infoNumero++;
			if($rowInf['informePDF']){
				$infoSubidos++;
			}
		}	
		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="infoNumero	 	= '".$infoNumero."',";
		$actSQL.="nInforme	 		= '".$infoNumero."',";
		$actSQL.="infoSubidos 		= '".$infoSubidos."'";
		$actSQL.="WHERE CAM 		= '".$CAM."'";
		$bdCot=$link->query($actSQL);

	}	
	$link->close();

	$link=Conectarse();
	$CodInforme 	= '';
	$infoNumero 	= 0;
	$infoSubidos 	= 0;
	$CAM 			= 0;
	$SQL = "Select * From cotizaciones Where infoNumero > infoSubidos and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		$CodInforme = 'AM-'.$rs['RAM'];
		$infoNumero 	= 0;
		$infoSubidos 	= 0;
	
		$CAM = $rs['CAM'];
		$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
		while($rowInf=mysqli_fetch_array($bdInf)){
			$infoNumero++;
			if($rowInf['informePDF']){
				$infoSubidos++;
			}
		}	
		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="infoNumero	 	= '".$infoNumero."',";
		$actSQL.="nInforme	 		= '".$infoNumero."',";
		$actSQL.="infoSubidos 		= '".$infoSubidos."'";
		$actSQL.="WHERE CAM 		= '".$CAM."'";
		$bdCot=$link->query($actSQL);

	}	
	$link->close();
	$CAM = 0;




	$horaAct = date('H:i');
	if($horaAct >= "7:00" and $horaAct <= "9:00") {

		$sDeuda = 0;
		$cFact	= 0;
		$link=Conectarse();
		
		$RutCli = '';  
		$fechaHoy = date('Y-m-d');
		$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
		$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
		$bdDe=$link->query("SELECT * FROM solfactura Where fechaPago = '0000-00-00'  Order By RutCli");
		while($rowDe=mysqli_fetch_array($bdDe)){
			if($RutCli != $rowDe['RutCli']){
				$RutCli = $rowDe['RutCli'];
				$sDeuda = 0;
				$cFact  = 0;
			}
			if($RutCli == $rowDe['RutCli']){

				if($rowDe['fechaFactura'] > '0000-00-00'){
					if($rowDe['fechaFactura'] <= $fecha90dias){
						if($rowDe['Saldo'] > 0){
							$sDeuda += $rowDe['Saldo'];
							$cFact++;

							//echo ' RUT Comprar '.$RutCli .' RUT BD '. $rowDe['RutCli'].' $ '.$rowDe['Bruto'].'<br>';
							//echo '<br>';
			
							$actSQL="UPDATE clientes SET ";
							$actSQL.="nFactPend	 		= '".$cFact."',";
							$actSQL.="sDeuda 			= '".$sDeuda."'";
							$actSQL.="WHERE RutCli 		= '".$RutCli."'";
							$bdCot=$link->query($actSQL);
						}
					}
				}
			}
		}
		$link->close();

	}





	if(isset($_GET['CAM'])) 	{	$CAM 	= $_GET['CAM']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['Rev'])) 	{	$Rev 	= $_GET['Rev']; 	}
	if(isset($_GET['Cta'])) 	{	$Cta 	= $_GET['Cta']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['CAM'])) 	{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['Rev'])) 	{	$Rev 	= $_POST['Rev']; 	}
	if(isset($_POST['Cta'])) 	{	$Cta 	= $_POST['Cta']; 	}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; }
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
	if($accion == "VolverPAM"){
		$Rev = '';
		
		if(isset($_POST['CAM'])) { $CAM = $_POST['CAM']; }
		if(isset($_POST['RAM'])) { $RAM = $_POST['RAM']; }
		if(isset($_POST['Rev'])) { $Rev = $_POST['Rev']; }
		if(isset($_POST['Cta'])) { $Cta	= $_POST['Cta']; }

		if(isset($_GET['CAM'])) { $CAM = $_GET['CAM']; }
		if(isset($_GET['RAM'])) { $RAM = $_GET['RAM']; }
		if(isset($_GET['Rev'])) { $Rev = $_GET['Rev']; }
		if(isset($_GET['Cta'])) { $Cta	= $_GET['Cta']; }
		
		
		$Estado				= 'P';
		
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Estado	 		='".$Estado."'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
		//header("Location: cotizaciones/plataformaCotizaciones.php");
	}
	if(isset($_POST['activarRAMam'])){
		if(isset($_POST['activarRAM'])) { $activarRAM = $_POST['activarRAM']; }
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where RAM = '".$activarRAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$blancoArchivo 	= '';
			$fechaArchivo	= '0000-00-00';
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Archivo	 		= '".$blancoArchivo."',";
			$actSQL.="fechaArchivo 		= '".$fechaArchivo."'";
			$actSQL.="WHERE RAM 		= '".$activarRAM."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
	}
	if(isset($_POST['guardarSeguimientoAM'])){
		$Facturacion 		= '';
		$Archivo 			= '';
		$informeUP			= '';
		$infUP				= '';
		$Fact				= '';
		$fechaFacturacion 	= '0000-00-00';
		$nSolicitud			= '';
		$HES 				= '';
		if(isset($_POST['CAM'])) { $CAM = $_POST['CAM']; }
		if(isset($_POST['HES'])) { $HES = $_POST['HES']; }
		if(isset($_POST['RAM'])) 				{ $RAM 			 	= $_POST['RAM'];				}
		if(isset($_POST['Rev'])) 				{ $Rev 			 	= $_POST['Rev'];				}
		if(isset($_POST['Cta'])) 				{ $Cta 			 	= $_POST['Cta'];				}
		if(isset($_POST['nOC'])) 				{ $nOC 			 	= $_POST['nOC'];				}
		if(isset($_POST['informeUP'])) 			{ $informeUP 		= $_POST['informeUP'];			}
		if(isset($_POST['infUP'])) 				{ $infUP 			= $_POST['infUP'];				}
		if(isset($_POST['fechaInformeUP'])) 	{ $fechaInformeUP	= $_POST['fechaInformeUP'];		}
		if(isset($_POST['Facturacion'])) 		{ $Facturacion 	 	= $_POST['Facturacion'];		}
		if(isset($_POST['Fact'])) 				{ $Fact 	 		= $_POST['Fact'];				}
		if(isset($_POST['fechaFacturacion'])) 	{ $fechaFacturacion = $_POST['fechaFacturacion'];	}
		if(isset($_POST['Archivo'])) 			{ $Archivo	 	 	= $_POST['Archivo'];			}
		if(isset($_POST['fechaArchivo'])) 		{ $fechaArchivo	 	= $_POST['fechaArchivo'];		}
		if(isset($_POST['nSolicitud'])) 		{ $nSolicitud	 	= $_POST['nSolicitud'];			}
		if(isset($_POST['accion'])) 			{ $accion			= $_POST['accion'];				}
		if($Archivo != 'on') 		{ $fechaArchivo 	= '0000-00-00'; }
		$descargarInforme = '';
		$link=Conectarse();
		$bdCot=$link->query("Select * From Cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			if($informeUP == '' and $rowCot['informeUP'] == 'on'){
				$descargarInforme = 'Si';
			}
			$fd = explode('-', $fechaArchivo);
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="informeUP	 		='".$informeUP.			"',";
			$actSQL.="nOC		 		='".$nOC.			"',";
			$actSQL.="HES		 		='".$HES.			"',";
			$actSQL.="fechaInformeUP	='".$fechaInformeUP.	"',";
			$actSQL.="Facturacion	 	='".$Facturacion.		"',";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="Archivo		 	='".$Archivo.			"',";
			$actSQL.="fechaArchivo		='".$fechaArchivo.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
			if($Facturacion != 'on'){
				$bdSFac=$link->query("Select * From SolFactura Where nSolicitud = '".$nSolicitud."'");
				if($rowSFac=mysqli_fetch_array($bdSFac)){
					// Consultar si Anular o Eliminar Solicitud
					$Nula = 'on';
					$actSQL="UPDATE SolFactura SET ";
					$actSQL.="Nula	   			= '".$Nula."'";
					//$actSQL.="WHERE nSolicitud 	= '".$nSolicitud."'";
					//$SQLsf = "Delete From SolFactura Where nSolicitud = '".$nSolicitud."'";
				}	
			}
		}
		$link->close();
		if($descargarInforme == 'Si'){
			$link=Conectarse();
			$bdInf=$link->query("Select * From Informes Where CodInforme Like '%".$RAM."%'");
			if($rowInf=mysqli_fetch_array($bdInf)){
				do{
					
					$informePDF = $rowInf['informePDF'];
					$host="ftp.simet.cl";
					$login="simet";
					$password="alf.artigas";
					$ftp=ftp_connect($host) or die ("no puedo conectar");
					ftp_login($ftp,$login,$password) or die ("Conexión rechazada");
					ftp_chdir($ftp,"/public_html/intranet/informes/");
					if (ftp_delete($ftp,$informePDF)){
						echo "$informePDF se ha eliminado satisfactoriamente\n";
					}else{
						echo "Error al subir el archivo<br>"; 
					}
					ftp_quit($ftp);

				}while($rowInf=mysqli_fetch_array($bdInf));
			}
			$informePDF = '';
			$fechaUp = '0000-00-00';
			
			$actSQL="UPDATE Informes SET ";
			$actSQL.="informePDF	   	='".$informePDF."',";
			$actSQL.="fechaUp	   		='".$fechaUp.	"'";
			$actSQL.="WHERE CodInforme Like	'%".$RAM."%'";
			$bdCot=$link->query($actSQL);

			$link->close();
		}
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';


	}

	// Crear Carpetas
	$periodoActual = date('Y');
	$directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual;
	if(!file_exists($directorioDoc)){
		mkdir($directorioDoc);
	}
	$directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/GASTOS/';
	if(!file_exists($directorioDoc)){
		mkdir($directorioDoc);
	}
	$directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/HONORARIOS/';
	if(!file_exists($directorioDoc)){
		mkdir($directorioDoc);
	}
	$directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/SOLICITUD-FACTURA/';
	if(!file_exists($directorioDoc)){
		mkdir($directorioDoc);
	}

	$directorioDoc = 'Y://AAA/LE/LABORATORIO/'.$periodoActual;
	if(!file_exists($directorioDoc)){
		mkdir($directorioDoc);
	}

	// Fin Crear Carpetas

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="cssboot/bootstrap.min.css">

  

  	<!-- BAJAR ESTA LIBRERIA -->	
	<script src="jquery/jquery-1.10.2.js"></script>

	<script src="jquery/jquery-3.3.1.min.js"></script>
	<script src="jquery/ajax/popper.min.js"></script>
	<script type="text/javascript" src="jquery/libs/1/jquery.min.js"></script>
	<script type="text/javascript" src="angular/angular.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
	<script language="javascript" src="validaciones.js"></script> 
	

	
	
	<script>
	function seguimientoAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'segAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoAM").html(response); 
			}
		});
	}
	</script>

<script language="javascript">
    function=NoBack(){
        history.go(1)
    }
</script>	
<style type="text/css">
		* {
  			box-sizing: border-box;
		}
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
</style>

</head>

<body OnLoad="NoBack();" ng-app="myApp" ng-controller="personCtrl" ng-init="loadConfig('<?php echo $_SESSION['usr']; ?>')" ng-cloak>

	<?php 
		include_once('head.php');
		//echo $_SESSION['usr'];
	?>
	<input type="hidden" ng-model="usr" ng-init="leerCotizacionesCAM('<?php echo $_SESSION['usr']; ?>')">
	<!-- <table width="99%"  border="0" cellspacing="0" cellpadding="0" style="margin:5px;"> -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" rowspan="5" valign="top">
				<?php include_once('menulateral.php')?>
			</td>
			<td width="<?php echo $maxCpo; ?>" valign="top">
				
				<?php
				if($_SESSION['IdPerfil'] == '1'){
					mCAMs();
				}
				if($_SESSION['Perfil'] == 'Acreditación'){
					$nAC = 0;
					$fechaHoyDia = date('Y-m-d');
					$link=Conectarse();
					$bdAC=$link->query("Select * From equipos Where fechaProxCal <= '".$fechaHoyDia."'");
					while($rowAC=mysqli_fetch_array($bdAC)){
						$nAC++;
					}
					$link->close();
					
					if($nAC>0){
						mEquipamiento($_SESSION['usr'], 'Seguimiento');
					}
				}
					muestraPreCAM($_SESSION['usr']);
					$nAC = 0;
					$fechaHoyDia = date('Y-m-d');
					$link=Conectarse();
					$bdAC=$link->query("Select * From actividades Where usrResponsable = '".$_SESSION['usr']."' and Estado = 'P' or Estado = ''");
					while($rowAC=mysqli_fetch_array($bdAC)){
						if($rowAC['usrResponsable'] == $_SESSION['usr']){
							$nAC++;
						}
					}
					$link->close();
					
					if($nAC>0){
						mActividades($_SESSION['usr'], 'Seguimiento');
					}



					if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437'){
						include_once('resumenGeneral.php');
					}?>
					<div ng-show="enProceso">
						<img src="imagenes/ajax-loader.gif"> MOMENTO PROCESANDO DATOS...
					</div>

					<div ng-show="tablasAM">
						<div class="row" style="margin: 10px;">
							<div class="col-md-2">
								Filtrar :
							</div>
							<div class="col-md-4">
								<input class="form-control" type="text" ng-model="search">
							</div>
							<div class="col-md-4">
								<a href="cotizaciones/exportarAM.php" title="Descargar AM..." style="padding:15p; float:right; ">
									<img src="imagenes/AM.png" width="50" height="50">
								</a>
								
							</div>

						</div>

						<?php
						
						include_once("trabajosAM.php");
						include_once("trabajosAMrosados.php"); 
						include_once("trabajosAMAmarillos.php");
						

						//include_once("trabajosAMVerde.php");
						//include_once("trabajosAMAzul.php");
						
						?>
					</div>

					<?php
					if(intval($_SESSION['IdPerfil'])===1 or $_SESSION['IdPerfil']=='WM' or $_SESSION['IdPerfil']==='01' or $_SESSION['IdPerfil']==='02'){
						//mRAMs();
						//mCAMs();
					}

					if($accion == 'SeguimientoAM'){?>
						<script>
							var CAM 	= "<?php echo $CAM; ?>" ;
							var RAM 	= "<?php echo $RAM; ?>" ;
							var Rev 	= "<?php echo $Rev; ?>" ;
							var Cta 	= "<?php echo $Cta; ?>" ;
							var accion 	= "<?php echo $accion; ?>" ;
							seguimientoAM(CAM, RAM, Rev, Cta, accion);
						</script>
						<?php
					}
				

				?>
				<span id="resultadoAM"></span>
			</td>
	  	</tr>
	  	<tr>
			<td>
				<?php
				if($_SESSION['IdPerfil']==0 or $_SESSION['IdPerfil']==2){
					?>
<!--
					<div style="float:left; display:inline; ">
						<?php //include_once('resumenIngresos.php');?>
					</div>
					<div style="float:left; display:inline; ">
						<?php //include_once('resumenIva.php');?>
					</div>
					<div style="float:left; display:inline; ">
						<?php //include_once('resumensueldos.php');?>
					</div>
					<div style="float:left; display:inline; ">
						<?php //include_once('resumenGastos.php');?>
					</div>
-->					
					<?php
					if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437'){
						//include_once('terminadosAM.php');
					}
				}
				?>
			</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>&nbsp;</td>
	  	</tr>
	</table>
	<div style="clear:both; "></div> 
	<br>

	<script src="jsboot/bootstrap.min.js"></script>
	<script src="plataforma.js"></script>

</body>
</html>
<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios Terminados
*
*
****************************************************************************************************************

-->
		<?php
		function sTerminados(){
				global $ultUF;
				?>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#CCCCCC">
						<tr>
							<td height="60">
								<div id="BarraOpciones">
									<div id="ImagenBarraLeft">
										<div style="float:right; display: inline-block;">
											<form action="plataformaErp.php" method="post">
												Desarchivar AM <input name="activarRAM" type="text" size="5" size="5" >
												<button name="activarRAMam">
													Activar AM
												</button>
											</form>
										</div>
										<a href="cotizaciones/exportarAM.php" title="Descargar AM..." style="padding:15p; float:right; ">
											<img src="imagenes/AM.png" width="50" height="50">
										</a>
									</div>
								</div>							
							</td>
						</tr>
					</table>

				<?php
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="5%" align="center" height="40">&nbsp;				</td>';
				echo '			<td  width="10%" align="center" height="40">AM					</td>';
				echo '			<td  width="10%">							Tipo Cot<br>Resp.	</td>';
				echo '			<td  width="17%">							Clientes			</td>';
				echo '			<td  width="14%">							Valor<br>			</td>';
				echo '			<td  width="10%">							Fecha AM<br>Fecha Up<br>Factura</td>';
				echo '			<td  width="10%">							Informes<br>Sub/N°	</td>';
				echo '			<td  width="10%">							Estado 				</td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				$tAMsUFsinF = 0;
				$tAMsPesinF = 0;
				$HEScli = 'off';

				$SQLam = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' and usrCotizador = '".$_SESSION['usr']."' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";

				if(intval($_SESSION['IdPerfil'])===2 or $_SESSION['IdPerfil']=='WM' or $_SESSION['usr']=='Alfredo.Artigas'){
					$SQLam = "SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'T' and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
				}

				$bdEnc=$link->query($SQLam);
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						if($row['informeUP'] == 'on'){ 
							if($row['Facturacion'] != 'on'){ 
								$tAMsUFsinF += $row['NetoUF'];
								$tAMsPesinF += $row['Neto'];
							}
						}
						
						$tr = "bBlanca";
						if($row['Estado'] == 'T'){ 
							$tr = "bBlanca";
						}
						if($row['informeUP'] == 'on'){ 
							$tr = "bAmarilla";
							if($row['nOC'] == ''){ 
								$tr = "bRosado";
							}
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								if($rowCli['HES'] == 'on'){
									if($row['HES'] == ''){ 
										$tr = "bRosado";
										$HEScli = $rowCli['HES'];
									}
								}
							}
						}
						if($row['nSolicitud'] > 0){ 
							$tr = "bVerde";
						}
						if($row['Archivo'] == 'on'){ 
							$tr = "bAzul";
						}
						if($row['nSolicitud'] > 0 and $row['informeUP'] == 'on' and $row['Facturacion'] == 'on'){
							$bdSol=$link->query("SELECT * FROM SolFactura Where nSolicitud = '".$row['nSolicitud']."'");
							if($rowSol=mysqli_fetch_array($bdSol)){
								if($rowSol['nFactura'] > 0){
									$tr = "bAzul";
								}
							}
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="5%" style="font-size:12px;" align="center">';
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['nFactPend'] > 0){
											echo '<br><br>';
											echo '<img src="imagenes/gener_32.png" align="left" width="16">'.$rowCli['nFactPend'];
										}
									}
									if($row['Fan'] > 0){
										echo '<img src="imagenes/extra_column.png" align="left" width="32" title="CLON">';
									}
									$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
									if($rowCli=mysqli_fetch_array($bdCli)){
										if($rowCli['Clasificacion'] == 1){
											echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											echo '<img src="imagenes/Estrella_Azul.png" width=10>';
										}else{	
											if($rowCli['Clasificacion'] == 2){
												echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												echo '<img src="imagenes/Estrella_Azul.png" width=10>';
											}else{
												if($rowCli['Clasificacion'] == 3){
													echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
												}
											}
										}
										
									}
									
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700"></strong>';
									if($row['Fan'] > 0){
										echo '<br>RAM-'.$row['RAM'].'-'.$row['Fan'];
									}else{
										echo '<br>RAM-'.$row['RAM'];
									}
									echo '<br>CAM-'.$row['CAM'];
									if($row['Cta']){
										echo '<br>CC';
									}
									echo '<br>';
									// Verificar si tiene Facturas Pendientes de Pago
									$sDeuda = 0;
									$cFact	= 0;
									$fechaHoy = date('Y-m-d');
									$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
									$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
									$bdDe=$link->query("SELECT * FROM SolFactura Where RutCli = '".$row['RutCli']."' and fechaPago = '0000-00-00'");
									if($rowDe=mysqli_fetch_array($bdDe)){
										do{
											if($rowDe['fechaFactura'] > '0000-00-00'){
												if($rowDe['fechaFactura'] < $fecha90dias){
													$sDeuda += $rowDe['Bruto'];
													$cFact++;
												}
											}
										}while ($rowDe=mysqli_fetch_array($bdDe));
									}
									if($sDeuda > 0){
										?>
										<script>
											var RutCli = '<?php echo $row["RutCli"]; ?>';
										</script>
										<?php
										echo '<br><div onClick="verDeuda(RutCli)"><img src="imagenes/bola_amarilla.png"></div>';
										echo '<br><span style="color:#000; font-weight:800;">$ '.number_format($sDeuda, 0, ',', '.').'</span>';
										//echo '<br><span style="color:#FFFF00;">'.$fecha90dias.'</span>';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row['oMail']=='on'){
										echo 'Confirma x Mail';
									}
									/*
									if($row['oCtaCte']=='on'){
										echo 'Cta.Cte';
									}
									*/
									echo '<br> OC: ';
									if($row['nOC']){
										echo $row['nOC'];
									}
									if($HEScli == 'on'){
										echo '<br> HES: ';
										if($row['HES']){
											echo $row['HES'];
										}
									}
									echo '<br>'.$row['usrResponzable'];
						echo '	</td>';
						echo '	<td width="17%" style="font-size:12px;">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	$rowCli['Cliente'];
							}
						echo '	</td>';
						echo '	<td width="14%">';
						echo '		<strong style="font-size:12px;">';
						echo 			number_format($row['BrutoUF'], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '  <td width="10%">';
									$fd = explode('-', $row['fechaTermino']);
									echo $fd[2].'/'.$fd[1].'/'.$fd[0];
									//echo 'I'.$row[fechaInicio];
									$CodInforme 	= 'AM-'.$row['RAM'];
									$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%' and RutCli = '".$row['RutCli']."'");
									if($rowInf=mysqli_fetch_array($bdInf)){
										if($rowInf['informePDF']){
											echo '<br>';
											$fd = explode('-', $rowInf['fechaUp']);
											echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										}
									}
									if($row['Facturacion'] == 'on'){
										if($row['nSolicitud'] > 0){
											echo '<br>Sol.'.$row['nSolicitud'];
											$bdSol=$link->query("SELECT * FROM SolFactura Where nSolicitud = '".$row['nSolicitud']."'");
											if($rowSol=mysqli_fetch_array($bdSol)){
												if($rowSol['nFactura'] > 0){
													echo '<br>Fact. '.$rowSol['nFactura'];
												}
											}
										}else{
											$bdSol=$link->query("SELECT * FROM SolFactura Where cotizacionesCAM Like '%".$row['CAM']."%' and RutCli = '".$row['RutCli']."'");
											if($rowSol=mysqli_fetch_array($bdSol)){
												echo '<br>Sol. '.$rowSol['nSolicitud'];
												if($rowSol['Factura'] == 'on'){
													echo '<br>Fact. '.$rowSol['nFactura'];
												}
											}else{
												$bdSol=$link->query("SELECT * FROM SolFactura Where informesAM Like '%".$row['RAM']."%' and RutCli = '".$row['RutCli']."'");
												if($rowSol=mysqli_fetch_array($bdSol)){
													echo '<br>Sol. '.$rowSol['nSolicitud'];
													if($rowSol['Factura'] == 'on'){
														echo '<br>Fact. '.$rowSol['nFactura'];
													}
												}
											}
										}
									}
						echo '  <td>';
						echo '  <td width="10%">';
							$CodInforme 	= 'AM-'.$row['RAM'];
							$infoNumero 	= 0;
							$infoSubidos 	= 0;
							$fechaUp		= '';
							$bdInf=$link->query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
							if($rowInf=mysqli_fetch_array($bdInf)){
								do{
									$infoNumero++;
									if($rowInf['informePDF']){
										$infoSubidos++;
									}
								}while ($rowInf=mysqli_fetch_array($bdInf));
							}
							echo '<strong>'.$infoSubidos.'/'.$infoNumero.'</strong>';
						echo '  <td>';
						echo '	<td width="10%">';
									$imgEstado = 'upload2.png';
									$msgEstado = 'Esperando Seguimiento';
									$fd[0] = 0;
									if($row['Estado'] == 'T'){ // En Espera
										$imgEstado = 'upload2.png';
										$msgEstado = 'Subir Informe';
									}
									if($row['informeUP'] == 'on'){ // Cerrada
										$imgEstado = 'informeUP.png';
										$msgEstado = 'Informe Subido';
										$fd = explode('-', $row['fechaInformeUP']);
									}
									if($row['Facturacion'] == 'on'){ // Cerrada
										$imgEstado = 'crear_certificado.png';
										$msgEstado = 'Facturado';
										$fd = explode('-', $row['fechaFacturacion']);
									}
									if($row['Archivo'] == 'on'){ // Cerrada
										$imgEstado = 'consulta.png';
										$msgEstado = 'Archivado';
										$fd = explode('-', $row['fechaArchivo']);
									}
									if($row['Estado'] == 'T' and $row['informeUP'] != 'on'){ // En Espera
										$CodInforme = 'AM-'.$row['RAM'];
										echo '<a href="informes/plataformaInformes.php?CodInforme='.$CodInforme.'"><img src="imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'"></a>';
									}else{
										if($row['Estado'] == 'T' and $row['informeUP'] == 'on' and $row['Facturacion'] != 'on'){ // En Espera
											if($tr == "bRosado"){

											}else{
												if($row['nSolicitud'] == 0){
													echo '<a href="facturacion/formSolicitaFactura.php?RutCli='.$row['RutCli'].'&Proceso=&nSolicitud="><img src="imagenes/tpv.png"	width="40" height="40" title="Facturación..."></a>';
												}
											}
										}else{
											echo '<img src="imagenes/'.$imgEstado.'"	width="40" height="40" title="'.$msgEstado.'">';
										}
									}
									if($fd[0]>0){
										if($tr != "bRosado"){
											echo '<br>'.$fd[2].'/'.$fd[1];
										}
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
									if($tr == "bBlanca"){
										echo '<a href="plataformaErp.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=VolverPAM"		><img src="imagenes/volver.png" 			width="40" height="40" title="Volver a PAM">			</a>';
									}else{
										if($row['Estado'] == 'T'){ // En Proceso
											echo '<a href="plataformaErp.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&Rev='.$row['Rev'].'&Cta='.$row['Cta'].'&accion=SeguimientoAM"		><img src="imagenes/actividades.png" 			width="40" height="40" title="Seguimiento">			</a>';
										}else{
											echo '<img src="imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
										}
									}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();

					echo '<tr id="bAzul">';
					echo '	<td colspan=10 style="font-size: 16px; font-weight:700">';
								echo 'Última UF de Referencia '.number_format($ultUF, 2, ',', '.');
								
								$sTotales = 0;
								$txt = 'Total NO Facturado ';
								if($tAMsUFsinF>0){
									$txt .= number_format($tAMsUFsinF, 2, ',', '.').' UF';
									$sTotales += $ultUF * $tAMsUFsinF;
									echo '<br>'.$txt.' = $ '.number_format($sTotales, 0, ',', '.');
								}
								
					echo '	</td>';
					echo '</tr>';

				echo '	</table>';
			}
			?>

		<?php
?>

<!-- 
****************************************************************************************************************
*
*             Nominas de Servicios en Procesos RAM
*
*
****************************************************************************************************************

-->
		<?php
		function mRAMs(){
				$dBuscar = '';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">PAM			 </td>';
				echo '			<td  width="10%">							Inicio		 </td>';
				echo '			<td  width="10%">							Término		 </td>';
				echo '			<td  width="18%">							Clientes	 </td>';
				echo '			<td  width="28%">							Observaciones</td>';
				echo '			<td  width="10%">							Estado 		 </td>';
				echo '			<td  width="14%" align="center">Seguimiento	</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;
				$link=Conectarse();
				
				if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or substr($_SESSION['IdPerfil'],0,1) == 0){
					if($dBuscar){
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' and CAM Like '%".$dBuscar."%' Order By CAM Desc");
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}else{
					if($dBuscar){
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION['usr']."' and RAM > 0 and Estado = 'P' and CAM Like '%".$dBuscar."%' Order By CAM Desc");
					}else{
						$bdEnc=$link->query("SELECT * FROM Cotizaciones Where usrResponzable = '".$_SESSION['usr']."' and RAM > 0 and Estado = 'P' Order By RAM Asc");
					}
				}
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
						$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );

						$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
						$ft = $row['fechaInicio'];
						$dh	= $row['dHabiles']-1;
						$dd	= 0;
						for($i=1; $i<=$dh; $i++){
							$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
							$ft	= date ( 'Y-m-d' , $ft );
							$dia_semana = date("w",strtotime($ft));
							if($dia_semana == 0 or $dia_semana == 6){
								$dh++;
								$dd++;
							}
						}

						$fd = explode('-', $ft);
										
						$fechaHoy = date('Y-m-d');
						$start_ts = strtotime($fechaHoy); 
						$end_ts   = strtotime($ft); 
										
						$tDias = 1;
						$nDias = $end_ts - $start_ts;

						$nDias = round($nDias / 86400)+1;
						if($ft < $fechaHoy){
							$nDias = $nDias - $dd;
						}

						$tr = "bBlanca";
						if($row['Estado']=='P' and $nDias <= 2){ // Enviada
							$tr = "bAmarilla";
							if($nDias < 0){ // En Proceso
								$tr = 'bRoja';
							}
						}else{
							if($row['Estado'] == 'P'){ // Aceptada
								$tr = 'bVerde';
							}
						}

						$OTAM = 'NO';
						$bRAM = $row['RAM'];
						$bdfRAM=$link->query("SELECT * FROM formRAM Where CAM = '".$row['CAM']."' and RAM = '".$row['RAM']."'");
						if($rowfRAM=mysqli_fetch_array($bdfRAM)){
							$OTAM = 'SI';
						}else{
							//$tr = 'bMorado';
							$OTAM = 'NO';
						}
						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">R'.$row['RAM'].'</strong><br>C'.$row['CAM'];
									if($row['Cta']){
										echo '<br>CC';
									}
						$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
						if($rowCli=mysqli_fetch_array($bdCli)){
							if($rowCli['Clasificacion'] == 1){
								echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
								echo '<img src="imagenes/Estrella_Azul.png" width=10>';
								echo '<img src="imagenes/Estrella_Azul.png" width=10>';
							}else{	
								if($rowCli['Clasificacion'] == 2){
									echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
									echo '<img src="imagenes/Estrella_Azul.png" width=10>';
								}else{
									if($rowCli['Clasificacion'] == 3){
										echo '<br><img src="imagenes/Estrella_Azul.png" width=10>';
									}
								}
							}
							
						}
									
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row['fechaInicio'] != 0){
										$fd = explode('-', $row['fechaInicio']);
										echo $fd[2].'/'.$fd[1];
										echo '<br>'.$row['usrResponzable'];
									}else{
										echo 'NO Asignado';
									}
						echo '	</td>';
						echo '	<td width="10%" style="font-size:12px;">';
									if($row['fechaInicio'] != 0){


										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
										$ft = $row['fechaInicio'];
										if($row['horaPAM'] >= '12:00'){
											$dh	= $row['dHabiles'];
										}else{
											$dh	= $row['dHabiles']-1;
										}
										$dd	= 0;
										$cDias = 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}
										}
										$fd = explode('-', $ft);

										$dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
										$fechaHoy = date('Y-m-d');

										$fechaTermino = $ft;
										echo '<br>'.$dSem[$dia_semana].'<br>'.$fd[2].'/'.$fd[1];
										
										$atrazado = 'No';
										if($fechaHoy <= $fechaTermino) {
											$start_ts 	= strtotime($fechaHoy); 
											$end_ts 	= strtotime($ft); 
				
											$tDias = 1;
											
											if($ft<$fechaHoy){

												$fIni = $ft;
	
												$ft = $fIni;
	
												$start_ts 	= strtotime($fechaHoy); 
												$end_ts 	= strtotime($fIni); 
												
												$dh	= $row['dHabiles']-1;
												$dh = $start_ts - $end_ts;
												$dh = round($dh / 86400);
												
												$ddAtrazo	= 0;
												$cDias = 1;
												for($i=1; $i<=$dh; $i++){
													$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fIni ) );
													$ft	= date ( 'Y-m-d' , $ft );
													$dia_semana = date("w",strtotime($ft));
													if($dia_semana == 0 or $dia_semana == 6){
														$dh++;
														$dd++;
													}else{
														$cDias++;
													}
												}
												$nDias = $end_ts - $start_ts;
											}else{
												$fechaEntrega 	= $ft;
												$j 				= 1;
												$nFaltan		= 1;
												
												while($fechaHoy < $fechaEntrega) {
													$fechaHoy 	= strtotime ( '+'.$j.' day' , strtotime ( $fechaHoy ) );
													$fechaHoy	= date ( 'Y-m-d' , $fechaHoy );
													$dia_semana 	= date("w",strtotime($fechaHoy));
													if($dia_semana == 0 or $dia_semana == 6){
													}else{
														$nFaltan++;
													}
												}

												$nDias = $end_ts - $start_ts;
											}
											if($ft < $fechaHoy){
												$nDias = round($nDias / 86400);
												//$nDias = $nDias - $dd;
											}else{
												$nDias = round($nDias / 86400)+1;
											}
											echo '<br>';
											if($nDias <= $tDias or $ft<$fechaHoy){ // En Proceso
												echo '<div class="pVencer" title="Días de Plazo RAM">';
												echo 	$nDias;
												echo '</div';
											}else{
												echo '<div class="sVencer" title="Días plazo RAM">';
												echo 	$nFaltan;
												echo '</div';
											}



										}else{

											$fechaEntrega 	= $ft;
											$j 				= 1;
											$cuentaAtrazo 	= 1;
												
											while($fechaEntrega < $fechaHoy) {
												$fechaEntrega 	= strtotime ( '+'.$j.' day' , strtotime ( $fechaEntrega ) );
												$fechaEntrega	= date ( 'Y-m-d' , $fechaEntrega );
												$dia_semana 	= date("w",strtotime($fechaEntrega));
												if($dia_semana == 0 or $dia_semana == 6){
												}else{
													$cuentaAtrazo++;
												}
											}

											$fIni 	= $ft;
											$ft 	= $fIni;
	
											$start_ts 	= strtotime($fechaHoy); 
											$end_ts 	= strtotime($fIni); 
												
											$dh = $start_ts - $end_ts;
											$dh = round($dh / 86400);
												
											$ddAtrazo	= 0;
											$cDias 		= 1;
											$dAtr		= 0;
											for($i=1; $i<=$dh; $i++){
												$ft	= strtotime ( '+'.$i.' day' , strtotime ( $fIni ) );
												$ft	= date ( 'Y-m-d' , $ft );
												$dia_semana = date("w",strtotime($ft));
												if($dia_semana == 0 or $dia_semana == 6){
													$dh++;
													$ddAtrazo++;
												}else{
													$cDias++;
												}
											}
											$nDias = $end_ts - $start_ts;
											$nDias = round($nDias / 86400);
											$nDias = $nDias + $ddAtrazo;
											echo '<br>';
											if($nDias <= $tDias){ // En Proceso
												echo '<div class="pVencer" title="Días de Plazo RAM">';
												echo 	$cuentaAtrazo;
												echo '</div';
											}else{
												echo '<div class="sVencer" title="Días plazo RAM">';
												echo 	$nDias;
												echo '</div';
											}
										}


									}else{
										echo number_format($row['dHabiles'], 0, ',', '.').' días';
										echo '<br>Sin asignar';
									}
						echo ' 	</td>';
						echo '	<td width="18%" style="font-size:12px;">';
							$bdCli=$link->query("SELECT * FROM Clientes Where RutCli = '".$row['RutCli']."'");
							if($rowCli=mysqli_fetch_array($bdCli)){
								echo 	$rowCli['Cliente'];
							}
						echo '	</td>';
						echo '	<td width="28%">';
						echo '		<strong style="font-size:10px;">';
										if($row['Observacion']){
											echo substr($row['Observacion'],0,100).'...';
										}
						//echo 			number_format($row[BrutoUF], 2, ',', '.').' UF';
						echo '		</strong>';
						echo ' 	</td>';
						echo '	<td width="10%">';
									if($row['Estado'] == 'P'){ // En Proceso
										echo '<img src="imagenes/machineoperator_128.png" 		width="40" height="40" title="En Proceso">';
										//echo '<img src="../imagenes/settings_128.png" 		width="32" height="32" title="En Proceso">';
									}
									if($row['Estado'] == 'C'){ // Cerrada
										echo '<img src="imagenes/tpv.png" 				width="32" height="32" title="Cerrada para Cobranza">';
									}
						echo ' 	</td>';
						echo '	<td width="14%" align="center">';
								if($row['Estado'] == 'P'){ // En Proceso
									echo '<a href="cotizaciones/plataformaCotizaciones.php?CAM='.$row['CAM'].'&RAM='.$row['RAM'].'&accion=SeguimientoRAM"		><img src="gastos/imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a>';
								}else{
									echo '<img src="gastos/imagenes/klipper.png" width="40" height="40" title="Seguimiento" style="opacity:0;">';
								}
						echo '	</td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			}
			?>
<?php
function mCorrectivas(){
			//echo '<div id="BarraOpciones">';
			//echo '<div id="accordion">';
  			//echo '<h3 style="font-size:14px;">ACCIONES CORRECTIVAS</h3>';
			//echo '<div id="infoCotizacion">';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">ACCIÓN			</td>';
				echo '			<td  width="08%">							Apertura			</td>';
				echo '			<td  width="08%">							Implem.				</td>';
				echo '			<td  width="46%">							Hallazgo			</td>';
				echo '			<td  width="08%">							Fecha<br>Tent.		</td>';
				echo '			<td  width="08%">							Fecha<br>Real		</td>';
				echo '			<td  width="12%" align="center" colspan="3">Acciones			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				$sql = "SELECT * FROM accionesCorrectivas Where verCierreAccion != 'on' and usrResponsable = '".$_SESSION['usr']."' Order By fechaApertura Desc";
				$bdEnc=$link->query($sql);
				if ($row=mysqli_fetch_array($bdEnc)){
					do{
						$fd = explode('-', $row['accFechaTen']);
										
						$fechaHoy 	= date('Y-m-d');
						$start_ts 	= strtotime($fechaHoy); 
						$end_ts 	= strtotime($row['accFechaTen']); 
										
						$nDias = $end_ts - $start_ts;
						$nDias = round($nDias / 86400);
						
						$tr = "bBlanca";
						if($row['accFechaTen']<$fechaHoy){ 
							$tr = "bBlanca";
						}
						if($row['accFechaTen']>=$fechaHoy){ 
							$tr = 'bRoja';
						}
						if($row['accFechaTen']>$fechaHoy){ 
							$tr = 'bVerde';
						}

						if($nDias<=5){ 
							$tr = "bAmarilla";
						}
						if($nDias>5){ 
							$tr = "bVerde";
						}
						if($nDias==0 or $nDias < 0){ 
							$tr = "bRoja";
						}

						echo '<tr id="'.$tr.'">';
						echo '	<td width="10%" style="font-size:12px;" align="center">';
						echo		'<strong style="font-size:14; font-weight:700">';
						echo			$row['nInformeCorrectiva'];
						echo 		'</strong>';
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['fechaApertura']);
									echo $fd[2].'/'.$fd[1];
									echo '<br>'.$row['usrApertura'];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['accFechaImp']);
									echo $fd[2].'/'.$fd[1];
						echo '	</td>';
						echo '	<td width="46%" style="font-size:12px;">';
									echo $row['desHallazgo'];
						echo '	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['accFechaTen']);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';
						echo '	<td width="08%" style="font-size:12px;">';
									$fd = explode('-', $row['accFechaApli']);
									echo $fd[2].'/'.$fd[1];
						echo ' 	</td>';
						echo '	<td width="06%" align="center"><a href="correctivas/accionesCorrectivasUsr.php?nInformeCorrectiva='.$row['nInformeCorrectiva'].'&accion=Imprimir"		><img src="imagenes/informes.png" 				width="40" height="40" title="Imprimir Acción Correctiva">		</a></td>';
						echo '	<td width="06%" align="center"><a href="correctivas/accionesCorrectivasUsr.php?nInformeCorrectiva='.$row['nInformeCorrectiva'].'&accion=Actualizar"	><img src="gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Acción Correctiva">		</a></td>';
						echo '</tr>';
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
			//echo '</div>';	
			//echo '</div>';	
			//echo '</div>';	
}

function muestraPreCAM($usrRes){
	$link=Conectarse();
	$fechaHoyDia = date('Y-m-d');
	$nPreCam = 0;
	$salto = '';

	$SQL = "SELECT Count(*) as nPre FROM precam Where usrResponsable = '".$usrRes."' and Estado = 'on'";
	$result  = $link->query($SQL);  
	$rowRev	 = mysqli_fetch_array($result);
	$nPreCam = $rowRev['nPre'];
	
	if($nPreCam > 0){?>
		<div style="background-color:#CCCCCC; padding:5px; font-size:14px; border-bottom:2px solid #000; border-top:1px solid #000; font-family:Geneva, Arial, Helvetica, sans-serif; color:#FFFFFF;">
			<img src='imagenes/important.png' width=40 align="absmiddle">
			<span style="padding-left:20px;">SEGUIMIENTO PRECAM</span>
		</div>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:arial;">
			<tr style="background-color:#000; color:#fff; font-size:12px; padding:15px;">
				<td  width="10%" align="center" height="30">Fecha<br>PRECAM		</td>
				<td  width="80%">							Correo				</td>
				<td  width="10%">												</td>
			</tr>
			<?php
			$sql = "SELECT * FROM precam Where usrResponsable = '".$usrRes."' and Estado = 'on'";
			$bdPc=$link->query($sql);
			if($rowPc=mysqli_fetch_array($bdPc)){
				do{
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');

						$fechaVencida 	= strtotime ( '-30 day' , strtotime ( $fechaHoy ) );
						$fechaVencida 	= date ( 'Y-m-d' , $fechaVencida );

						if($rowPc['fechaPreCAM'] == '0000-00-00'){
							$tr = "bRoja";
						}						
						if($rowPc['seguimiento'] == 'on'){
							$tr = "bAmarilla";
						}
						if($rowPc['fechaPreCAM'] <= $fechaVencida){
							$tr = "bRoja";
						}						
					?>
					<tr id="<?php echo $tr; ?>">
						<td><?php echo $rowPc['fechaPreCAM']; ?></td>
						<td><?php echo $rowPc['Correo']; ?>		</td>
						<td align="center"><a href="precam?idPreCAM=<?php echo $rowPc['idPreCAM']; ?>"	><img src="imagenes/other_48.png" 		width="40" height="40" title="ir a Proceso">	</a></td>
					</tr>
					<?php
				}while ($rowPc=mysqli_fetch_array($bdPc));
			}?>
		</table>
		<?php
	}
	$link->close();
}

function mEquipamiento($usrRes, $tpAccion){
				?>
				<div style="background-color:#CCCCCC; padding:18px; font-size:14px; border-bottom:2px solid #000; border-top:1px solid #000; font-family:Geneva, Arial, Helvetica, sans-serif; color:#FFFFFF;">
					<img src='imagenes/important.png' width=40 align="absmiddle">
					<span style="padding-left:20px;">SEGUIMIENTO EQUIPAMIENTO</span>
				</div>
				<?php
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="10%" align="center" height="40">Código<br>Equipo		</td>';
				echo '			<td  width="20%">							Nombre<br>Equipo		</td>';
				echo '			<td  width="08%">							Tipo<br>Equipo			</td>';
				echo '			<td  width="13%">							Ubicación.<br>Equipo	</td>';
				echo '			<td  width="08%">							Fecha<br>Calibración	</td>';
				echo '			<td  width="08%">							Fecha<br>Verificación	</td>';
				echo '			<td  width="08%">							Fecha<br>Mantención		</td>';
				echo '			<td  width="07%">							Responsable<br>Equipo	</td>';
				if($tpAccion == 'Seguimiento'){
					echo '		<td  width="18%" align="center">Acciones							</td>';
				}else{
					echo '		<td  width="18%" align="center" colspan="3">Acciones				</td>';
				}
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				//$sql = "SELECT * FROM accionesCorrectivas Where verCierreAccion != 'on' Order By fechaApertura Desc";
				$fechaHoyDia = date('Y-m-d');
				$sql = "SELECT * FROM equipos Where fechaProxCal > '0000-00-00' Order By fechaProxCal, fechaProxVer, fechaProxMan";
				$bdEnc=$link->query($sql);
				if($row=mysqli_fetch_array($bdEnc)){
					do{
						$fechaHoy = date('Y-m-d');
						$muestra	 = 'NO';

											if($row['fechaProxCal']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoCal'].' day' , strtotime ( $row['fechaProxCal'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $row['fechaProxCal']){
													$muestra = 'SI';
												}
											}

											if($row['fechaProxMan']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoMan'].' day' , strtotime ( $row['fechaProxMan'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $row['fechaProxMan']){
													$muestra = 'SI';
												}
											}

											if($row['fechaProxVer']>'0000-00-00'){
												$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoVer'].' day' , strtotime ( $row['fechaProxVer'] ) );
												$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
												if($fechaHoyDia >= $row['fechaProxVer']){
													$muestra = 'SI';
												}
											}

						if($muestra == 'SI'){
							$tr = "bBlanca";
							$td = $tr;
							echo '<tr id="'.$tr.'">';
							echo '	<td width="10%" style="font-size:12px;" align="center">';
							echo		'<strong style="font-size:14; font-weight:700">';
							echo			$row['nSerie'];
							echo 		'</strong>';
							echo '	</td>';
							echo '	<td width="20%" style="font-size:12px;">';
										if($row['Acreditado'] == 'on'){
											echo '<span style="font-weight:700;">'.$row['nomEquipo'].' (A)</span>';
										}else{
											echo $row['nomEquipo'];
										}
							echo '	</td>';
							echo '	<td width="08%" style="font-size:12px;">';
										if($row['tipoEquipo']=='E'){
											echo 'Equipo';
										}else{
											if($row['tipoEquipo']=='I'){
												echo 'Instrumento';
											}
										}
							echo '	</td>';
							echo '	<td width="13%" style="font-size:12px;">';
										echo $row['lugar'];
							echo '	</td>';
							$td = 'bBlanca';
							if($row['fechaProxCal'] != '0000-00-00'){ 
								$td = 'bVerde';
								$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoCal'].' day' , strtotime ( $row['fechaProxCal'] ) );
								$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
								if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
									$td = 'bAmarilla';
								}
								if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy > $row['fechaProxCal']){ 
									$td = 'bRoja';
								}
							}
							
							//echo '	<td width="08%" style="font-size:12px;" id="'.$td.'">';
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaProxCal']);
										if($fd[2] > 0){
											if($row['fechaProxCal'] != '0000-00-00' and $fechaHoy > $row['fechaProxCal']){ 
												echo '<span class="atrazoEquipo">';
												echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
												echo '</span>';
											}else{
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
											if($td == 'bAmarilla'){
												echo '<img src="imagenes/bola_amarilla.png" style="padding-left:5px;">';
											}
											if($td == 'bRoja'){
												echo '<img src="imagenes/bola_roja.png" style="padding-left:5px;">';
											}
											if($td == 'bVerde'){
												echo '<img src="imagenes/bola_verde.png" style="padding-left:5px;">';
											}
										}
							echo ' 	</td>';
							$td = 'bBlanca';
							if($row['fechaProxVer'] != '0000-00-00'){ 
								$td = 'bVerde';
								$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoVer'].' day' , strtotime ( $row['fechaProxVer'] ) );
								$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
								if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
									$td = 'bAmarilla';
								}
								if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy > $row['fechaProxVer']){ 
									$td = 'bRoja';
								}
							}
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaProxVer']);
										if($fd[2] > 0){
											if($row['fechaProxVer'] != '0000-00-00' and $fechaHoy > $row['fechaProxVer']){ 
												echo '<span class="atrazoEquipo">';
												echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
												echo '</span>';
											}else{
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
											if($td == 'bAmarilla'){
												echo '<img src="imagenes/bola_amarilla.png" style="padding-left:5px;">';
											}
											if($td == 'bRoja'){
												echo '<img src="imagenes/bola_roja.png" style="padding-left:5px;">';
											}
											if($td == 'bVerde'){
												echo '<img src="imagenes/bola_verde.png" style="padding-left:5px;">';
											}
										}
							echo ' 	</td>';
							$td = 'bBlanca';
							if($row['fechaProxMan'] != '0000-00-00'){ 
								$td = 'bVerde';
								$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoMan'].' day' , strtotime ( $row['fechaProxMan'] ) );
								$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );
								if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy >= $fechaxVencer){ 
									$td = 'bAmarilla';
								}
								if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy > $row['fechaProxMan']){ 
									$td = 'bRoja';
								}
							}
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaProxMan']);
										if($fd[2] > 0){
											if($row['fechaProxMan'] != '0000-00-00' and $fechaHoy > $row['fechaProxMan']){ 
												echo '<span class="atrazoEquipo">';
												echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
												echo '</span>';
											}else{
												echo $fd[2].'/'.$fd[1].'/'.$fd[0];
											}
											if($td == 'bAmarilla'){
												echo '<img src="imagenes/bola_amarilla.png" style="padding-left:5px;">';
											}
											if($td == 'bRoja'){
												echo '<img src="imagenes/bola_roja.png" style="padding-left:5px;">';
											}
											if($td == 'bVerde'){
												echo '<img src="imagenes/bola_verde.png" style="padding-left:5px;">';
											}
										}
							echo ' 	</td>';
							echo '	<td width="07%" style="font-size:12px;">';
										echo $row['usrResponsable'];
							echo ' 	</td>';
							if($tpAccion == 'Seguimiento'){
								echo '	<td width="09%" align="center"><a href="equipamiento/plataformaEquipos.php?nSerie='.$row['nSerie'].'&accion=Seguimiento&tpAccion='.$tpAccion.'"><img src="imagenes/klipper.png" 				width="40" height="40" title="Seguimiento">						</a></td>';
							}
							echo '</tr>';
						}
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				?>
				<br>
				<?php
			}

function mActividades($usrRes, $tpAccion){
				?>
				<div style="background-color:#CCCCCC; padding:18px; font-size:14px; border-bottom:2px solid #000; border-top:1px solid #000; font-family:Geneva, Arial, Helvetica, sans-serif; color:#FFFFFF;">
					<img src='imagenes/important.png' width=40 align='middle'>
					<span style="padding-left:20px;">SEGUIMIENTO ACTIVIDADES</span>
				</div>
				<?php
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="03%" align="center" height="40">&nbsp;					</td>';
				echo '			<td  width="10%" align="center" height="40">N°<br>Actividad			</td>';
				echo '			<td  width="23%">							Descripción Actividad	</td>';
				echo '			<td  width="08%">							Fecha<br>Prog.			</td>';
				echo '			<td  width="08%">							Fecha<br>Actividad		</td>';
				echo '			<td  width="23%">							Acreditación			</td>';
				echo '			<td  width="07%">							Responsable<br>Actividad</td>';
				echo '		<td  width="18%" align="center">Acciones								</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$fechaHoy = date('Y-m-d');
				$link=Conectarse();
				$sql = "SELECT * FROM Actividades Where usrResponsable = '".$usrRes."' and Estado != 'T' Order By fechaProxAct";
				$bdEnc=$link->query($sql);
				if($row=mysqli_fetch_array($bdEnc)){
					do{
						$Mostrar = 'Si';
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');
						
						$fechaxVencer 	= strtotime ( '-'.$row['tpoAvisoAct'].' day' , strtotime ( $row['fechaProxAct'] ) );
						$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

						if($fechaHoy == $row['fechaProxAct']){
							$tr = "bAmarilla";
						}
						
						if($fechaHoy >= $fechaxVencer){
							$tr = "bAmarilla";
						}

						if($fechaHoy > $row['fechaProxAct']){
							$tr = "bRoja";
						}

						if($tr == "bVerde"){
							$Mostrar = 'No';
						}
						$fd = explode('-', $fechaHoy);
						
						if($row['Estado'] == 'T'){
							$tr = "bAzul";
							$fdAct = explode('-', $row['fechaAccionAct']);
							if($fdAct[0] < $fd[0]){
								$Mostrar = 'No';
							}
						}
						
						if($Mostrar == 'Si'){
							echo '<tr id="'.$tr.'">';
							echo '	<td width="03%" align="center">';
										echo '&nbsp;';
							echo '	</td>';
							echo '	<td width="10%" style="font-size:12px;" align="center">';
							echo		'<strong style="font-size:25; font-weight:700">';
							echo			$row['idActividad'];
							echo 		'</strong>';
							echo '	</td>';
							echo '	<td width="23%" style="font-size:12px;">';
										echo $row['Actividad'];
							echo '	</td>';
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['prgActividad']);
										echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
							echo ' 	</td>';
							echo '	<td width="08%" style="font-size:12px;">';
										$fd = explode('-', $row['fechaProxAct']);
										echo	$fd[2].'/'.$fd[1].'/'.$fd[0];
							echo ' 	</td>';
							echo '	<td width="23%" style="font-size:12px;">';
										if($row['Acreditado'] == 'on'){
											echo 'SI';
										}
										//echo $row[Comentarios];
							echo ' 	</td>';
							echo '	<td width="07%" style="font-size:12px;">';
										echo $row['usrResponsable'];
							echo ' 	</td>';
							if($tpAccion == 'Seguimiento'){
								echo '	<td width="09%" align="center"><a href="actividades/plataformaActividades.php?idActividad='.$row['idActividad'].'&accion=Seguimiento&tpAccion='.$tpAccion.'">	<img src="imagenes/klipper.png" 			width="40" height="40" title="Seguimiento">			</a></td>';
							}
							echo '</tr>';
						}
					}while ($row=mysqli_fetch_array($bdEnc));
				}
				$link->close();
				echo '	</table>';
				echo '<br>';
}

function mCAMs(){
				global $ultUF;
				?>

<div class="container-fluid m-2">

<div class="card">
	<div class="card-header">
		<h3>COTIZACIONES</h3>
		<!--
    	<button class="btn btn-success" ng-click="activaCAM()" ng-show="btnMuestraCAM"">MOSTRAR COTIZACIONES</button>	
    	<button class="btn btn-success" ng-click="ocultaCAM()" ng-show="btnOcultaCAM">OCULTAR COTIZACIONES</button>	
		-->
	</div>
  	<div class="card-body" ng-show="swCotizaciones">

				<div ng-show="cargaDatos">
					<img src="../imagenes/enProceso.gif" width="50">
				</div>
				<!-- <table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaCAM"> -->

				<table class="table table-dark table-hover" style="margin-top: 5px; font-size: 12px;">
					<thead>
						<tr>
							<th>CAM			</th>
							<th>Fecha		</th>
							<th>Clientes	</th>
							<th>Total		</th>
							<th>Valida Hasta		</th>
							<th>Est. 		</th>
							<!-- <th>Acciones	</th> -->
						</tr>
					</thead>
					<tbody>
			
						<tr ng-repeat="Cam in CotizacionesCAM"  
							ng-class="verColorLinea(Cam.Estado, Cam.RAM, Cam.BrutoUF, Cam.nDias, Cam.rCot, Cam.fechaAceptacion, Cam.proxRecordatorio, Cam.colorCam)">
			
							<td>
								<span ng-if="Cam.Fan > 0">
									<span class="badge badge-pill badge-danger">
										<h6 title="Facturas Pendientes">CLON</h6>
									</span>
								</span> 
								C{{Cam.CAM}}
								<span ng-if="Cam.RAM > 0">
									/ R{{Cam.RAM}}<span ng-if="Cam.Fan > 0">-{{Cam.Fan}}</span>
									<span ng-if="Cam.fechaAceptacion != '0000-00-00'">
										<span class="badge badge-warning">Aceptada</span> 
									</span>
								</span>
								<span ng-if="Cam.sDeuda > 0">
									<img class="p-2" src="imagenes/bola_amarilla.png">
									<span class="badge badge-warning" title="Moroso">{{Cam.sDeuda | currency:"$ ":0}}</span>
								</span>
			
							</td>
							<td>
								{{Cam.fechaCotizacion | date:'dd/MM/yyyy'}}<br>
							</td>
							<td>{{Cam.Cliente}}</td>
							<td>
								<div ng-if="Cam.Bruto > 0">
									{{Cam.Bruto | currency:"$ ":0}}
								</div>
								<div ng-if="Cam.BrutoUF > 0">
									{{Cam.BrutoUF | currency:"UF "}}
								</div>
			
							</td>
							<td>
								<!-- 
									{{Cam.fechaEstimadaTermino | date:'dd/MM'}} 


									fechaxVencer = fechaCotizacion + Validez
									fechaTermino = fechaCotizacion + Dias Habiles Validez

									{{Cam.fechaxVencer | date:'dd/MM'}} - 
								-->
								{{Cam.fechaTermino | date:'dd/MM/yyyy'}}
								<span class="badge badge-pill badge-danger" ng-if="Cam.nDias < 0">
									<b>{{Cam.nDias}}</b>
								</span>
								<span class="badge badge-pill badge-primary" ng-if="Cam.nDias > 0">
									<b>{{Cam.nDias}}</b>
								</span>
								<br>
							</td>
							<td>
								
								<span ng-if="Cam.enviadoCorreo == ''">
									<img style="padding:5px;" src="imagenes/noEnviado.png" align="left" width="40" title="Cotización NO Enviada">
									{{Cam.fechaEnvio | date:'dd/MM/yy'}}
								</span>
								
								<span ng-if="Cam.enviadoCorreo == 'on' && Cam.Contactar == 'No'">
									Email <!-- <img style="padding:5px;" src="imagenes/enviarConsulta.png" align="left" width="40" title="Cotización enviado en correo automatico"> -->
									{{Cam.fechaEnvio | date:'dd/MM/yy'}}
								</span>
								
								<span ng-if="Cam.proxRecordatorio != '0000-00-00'">
									<!-- <img style="padding:5px;" src="imagenes/alerta.gif" align="left" width="50" title="Contactar con Cliente"> -->
									Contactar {{Cam.proxRecordatorio | date:'dd/MM/yy'}}
								</span>
								
							</td>
							<!--
							<td>
								<button type="button" 
											class="btn btn-light"
											data-toggle="modal" 
											data-target="#modal_seguimiento" 
											title="Seguimiento"
											ng-click="editarSeguimiento(Cam.CAM)"> 
									<i class="fas fa-project-diagram"></i> 
								</button>				
								<a 	style="margin-top: 5px;"
											type="button"
											href="modCotizacion.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Actualizar"
											class="btn btn-warning"
											title="Editar"> 
									<i class="fas fa-edit"></i> 
								</a>
								<button type="button" 
											class="btn btn-danger"
											data-toggle="modal" 
											data-target="#modal_borrar" 
											title="Borrar"
											ng-click="editarBorrar(Cam.CAM)" 
											style="margin-top: 5px;">
									<i class="fas fa-trash-alt"></i> 
								</button>	
								<a 	style="margin-top: 5px;"
											type="button"
											href="mDocumentos.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Up"
											class="btn btn-secondary"
											title="Up Documentos"> 
									<i class="far fa-file-pdf"></i> 
								</a>
			
							</td>
							-->
						</tr>
					</tbody>
<!--					
					<tfoot>
						<tr>
							<td colspan="5">
								<h5>
								Total :
								{{ getTotalCAMs() | currency : "UF " : 2 }} UF Ref.	{{ultUF = <?php echo $ultUF; ?>}}
								 {{ultUF * getTotalCAMs() | currency : " $ " : 0}}
								 </h5>
							</td>
						</tr>
					</tfoot>
-->					
				</table>
	</div>	
</div>	
</div>

				<?php
			}			
			
?>

