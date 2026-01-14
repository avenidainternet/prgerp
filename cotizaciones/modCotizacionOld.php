<?php
	session_start(); 
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: ../index.php");
	}
	$nCot = 1;
	$BrutoUF = 0;
	$link=Conectarse();
	$sql = "SELECT * FROM Cotizaciones";  // sentencia sql
	$result = mysql_query($sql);
	$nCot = mysql_num_rows($result); // obtenemos el número de filas
	mysql_close($link);

	$CAM 	= '';
	$nLin 	= 0;
	$accion	= '';
	
	if(isset($_GET[CAM])) 		{	$CAM 		= $_GET[CAM]; 		}
	if(isset($_GET[Rev])) 		{	$Rev 		= $_GET[Rev]; 		}
	if(isset($_GET[Cta])) 		{	$Cta 		= $_GET[Cta]; 		}
	if(isset($_GET[nServicio])) {	$nServicio 	= $_GET[nServicio]; }
	if(isset($_GET[nLin])) 		{	$nLin 		= $_GET[nLin]; 		}
	if(isset($_GET[accion])) 	{	$accion 	= $_GET[accion]; 	}
	
	if(isset($_POST[CAM])) 		{	$CAM 		= $_POST[CAM]; 	}
	if(isset($_POST[Rev])) 		{	$Rev 		= $_POST[Rev]; 	}
	if(isset($_POST[Cta])) 		{	$Cta 		= $_POST[Cta]; 	}
	if(isset($_POST[nServicio])){	$nServicio 	= $_POST[nServicio]; }
	if(isset($_POST[nLin]))		{	$nLin 		= $_POST[nLin]; }
	if(isset($_POST[accion])) 	{	$accion 	= $_POST[accion]; 	}

/*
	if(isset($_POST[bajarEnvio])){
		header("Location: formularios/iCAM.php?CAM=$CAM&Rev=$Rev&Cta=$Cta");
	}
*/
	
	if(isset($_POST[confirmarBorrar])){
		$link=Conectarse();
		$bdEnc=mysql_query("Delete From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		mysql_close($link);
		$CAM 	= '';
		$accion	= '';
		header("Location: plataformaCotizaciones.php");
	}
	if(isset($_POST[BorrarServicio])){
		$link=Conectarse();
		$bddCot=mysql_query("Delete From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");

		$bddCot=mysql_query("SELECT * FROM dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Asc");
		if($rowdCot=mysql_fetch_array($bddCot)){
			do{
				$NetoUF += $rowdCot[NetoUF];
				$NetoP 	+= $rowdCot[Neto];
			}while ($rowdCot=mysql_fetch_array($bddCot));
		}

		$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$pDescuento = $rowCot[pDescuento];
			$vDscto 	= $NetoUF * ($pDescuento/100);
			
			$NetoUF		= $NetoUF - $vDscto;
			$IvaUF		= $NetoUF * 0.19;
			$TotalUF	= $NetoUF * 1.19;

			$NetoPesos 	= $NetoP *((100-$pDescuento)/100);
			$IvaPesos	= $NetoPesos * 0.19;
			$BrutoPesos	= round($NetoPesos,0) + round($IvaPesos,0);

			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Neto			='".$NetoPesos.	"',";
			$actSQL.="Iva			='".$IvaPesos.	"',";
			$actSQL.="Bruto			='".$BrutoPesos."',";
			$actSQL.="NetoUF		='".$NetoUF.	"',";
			$actSQL.="IvaUF			='".$IvaUF.		"',";
			$actSQL.="BrutoUF		='".$NetoUF.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=mysql_query($actSQL);
		}

		mysql_close($link);
		$accion	= '';
	}

	if(isset($_POST[guardarValorUF])){
		$fechaUF	= $_POST[fechaUF];
		$valorUF 	= $_POST[valorUF];
		$Moneda 	= $_POST[Moneda];
		$link=Conectarse();
		$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$Neto	= $rowCot[NetoUF] 	* $valorUF;
			$Iva	= intval($Neto * 0.19);
			$Bruto	= $Neto + $Iva;
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="Neto			='".$Neto.		"',";
			$actSQL.="Iva			='".$Iva.		"',";
			$actSQL.="Bruto			='".$Bruto.		"',";
			$actSQL.="fechaUF		='".$fechaUF.	"',";
			$actSQL.="valorUF		='".$valorUF.	"',";
			$actSQL.="Moneda		='".$Moneda.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdCot=mysql_query($actSQL);

			$bddCot=mysql_query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Desc");
			if($rowdCot=mysql_fetch_array($bddCot)){
				$tLin = $rowdCot[nLin];
			}

			for($nLin=1; $nLin <= $tLin; $nLin++){
				$bddCot=mysql_query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");
				if($rowdCot=mysql_fetch_array($bddCot)){
					$unitarioP	= round(($rowdCot[unitarioUF] 	* $valorUF),0);
					$Neto		= $rowdCot[NetoUF] 	* $valorUF;
					$Iva		= intval($Neto * 0.19);
					$Bruto		= $Neto + $Iva;
					
					$actSQL="UPDATE dCotizacion SET ";
					$actSQL.="unitarioP	='".$unitarioP.		"',";
					$actSQL.="Neto		='".$Neto.			"',";
					$actSQL.="Iva		='".$Iva.			"',";
					$actSQL.="Bruto		='".$Bruto.			"'";
					$actSQL.="WHERE CAM	= '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'";
					$bddCot=mysql_query($actSQL);
				}
			}
		}
		mysql_close($link);
	}
	
	if(isset($_POST[guardarServicio])){
		$Cantidad 	= $_POST[Cantidad];
		$nServicio	= $_POST[nServicio];
		$ValorUF 	= $_POST[ValorUF];
		$Total 		= $_POST[Total];
		$NetoUFDet	= $_POST[Total];
		$nLin 		= $_POST[nLin];

		if($Total){
			
			$NetoUF 	= $Total;
			$IvaUF		= $NetoUF * .19;
			$TotalUF	= $NetoUF * 1.19;
			
			$link=Conectarse();
			$bdCot=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
			if($rowCot=mysql_fetch_array($bdCot)){
				$NetoUFOld 	= $rowCot[NetoUF];
				
				$NetoUF		= $NetoUF * ((100-$rowCot[pDescuento])/100);
				$NetoUFCot 	= $NetoUFOld + $NetoUF;
				$IvaUFCot	= $NetoUFCot * .19;
				$BrutoUFCot	= $NetoUFCot * 1.19;

				
				$UF	= $rowCot[valorUF];
				
				//$Neto 	= ($NetoUFCot * $rowCot[valorUF])*((100-$rowCot[pDescuento])/100);
				
				$NetoP		= $Total * $rowCot[valorUF];
				$NetoP		= round($NetoP,0) * ((100-$rowCot[pDescuento])/100);
				$NetoOld 	= $rowCot[Neto];
				$Neto 		= $NetoP +  $NetoOld;
				
				// $Neto 		= $NetoUFCot *  $rowCot[valorUF];
				$Iva		= $Neto * 0.19;
				$Bruto		= round($Neto,0) + round($Iva,0);

				$actSQL="UPDATE Cotizaciones SET ";
				$actSQL.="Neto			='".$Neto.		"',";
				$actSQL.="Iva			='".$Iva.		"',";
				$actSQL.="Bruto			='".$Bruto.		"',";
				$actSQL.="NetoUF		='".$NetoUFCot.	"',";
				$actSQL.="IvaUF			='".$IvaUFCot.	"',";
				$actSQL.="BrutoUF		='".$BrutoUFCot."'";
				$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
				$bdCot=mysql_query($actSQL);
				
				if($nLin == 0){
					$bddCot=mysql_query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By nLin Desc");
					if($rowdCot=mysql_fetch_array($bddCot)){
						$nLin = $rowdCot[nLin]+1;
					}else{
						$nLin = 1;
					}
				}

				$bddCot=mysql_query("Select * From dCotizacion Where CAM = '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'");
				if($rowdCot=mysql_fetch_array($bddCot)){
					$NetoPesos	= $NetoUFDet * $UF;
					$IvaPesos	= $NetoPesos * 0.19;
					$BrutoPesos	= round($NetoPesos + $IvaPesos,0);
					
					$actSQL="UPDATE dCotizacion SET ";
					$actSQL.="Cantidad		='".$Cantidad.			"',";
					$actSQL.="nServicio		='".$nServicio.			"',";
					$actSQL.="unitarioUF	='".$ValorUF.			"',";
					$actSQL.="Neto			='".$NetoPesos.			"',";
					$actSQL.="Iva			='".$IvaPesos.			"',";
					$actSQL.="Bruto			='".$BrutoPesos.		"',";
					$actSQL.="NetoUF		='".$NetoUFDet.			"',";
					$actSQL.="IvaUF			='".$IvaUF.				"',";
					$actSQL.="TotalUF		='".$TotalUF.			"'";
					$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."' and nLin = '".$nLin."'";
					$bddCot=mysql_query($actSQL);
					
				}else{
				
					$unitarioP	= $ValorUF * $UF;
					$NetoPesos	= $NetoUFDet * $UF;
					$IvaPesos	= $NetoPesos * 0.19;
					$BrutoPesos	= round($NetoPesos + $IvaPesos,0);
					mysql_query("insert into dCotizacion(	CAM,
															Rev,
															Cta,
															nLin,
															Cantidad,
															nServicio,
															unitarioUF,
															unitarioP,
															Neto,
															Iva,
															Bruto,
															NetoUF,
															IvaUF,
															TotalUF
															) 
												values 	(	'$CAM',
															'$Rev',
															'$Cta',
															'$nLin',
															'$Cantidad',
															'$nServicio',
															'$ValorUF',
															'$unitarioP',
															'$NetoPesos',
															'$IvaPesos',
															'$BrutoPesos',
															'$NetoUFDet',
															'$IvaUF',
															'$TotalUF'
					)");
				}							
			}
			mysql_close($link);
			$accion = '';
		}else{
			echo '
				<script>
					alert("Debe ingresar la Cantidad de Servicios...");
				</script>
			';
		}
	}
	if(isset($_POST[confirmarGuardar])){
		if($_POST[CAM]==0){
			$link=Conectarse();
			$sql = "SELECT * FROM tablaRegForm";  // sentencia sql
			$bdTab=mysql_query("SELECT * FROM tablaRegForm");
			if($rowTab=mysql_fetch_array($bdTab)){
				$CAM = $rowTab[CAM]+1;
				$actSQL="UPDATE tablaRegForm SET ";
				$actSQL.="CAM	='".$CAM.	"'";
				$bdTab=mysql_query($actSQL);
			}
			mysql_close($link);
		}else{
			$CAM 			 = $_POST[CAM];
		}
		$Rev 			 = $_POST[Rev];
		$Cta 			 = $_POST[Cta];
		$fechaCotizacion = $_POST[fechaCotizacion];
		$usrCotizador	 = $_POST[usrCotizador];
		$Cliente 		 = $_POST[Cliente];
		$nContacto 		 = $_POST[nContacto];
		$Atencion 		 = $_POST[Atencion];
		$correoAtencion  = $_POST[correoAtencion];
		$Telefono  		 = $_POST[Telefono];
		$Descripcion	 = $_POST[Descripcion];
		$Observacion	 = $_POST[Observacion];
		$obsServicios	 = $_POST[obsServicios];
		$Validez		 = $_POST[Validez];
		$dHabiles		 = $_POST[dHabiles];
		$proxRecordatorio 	= strtotime ( '+10 day' , strtotime ( $fechaCotizacion ) );
		$proxRecordatorio 	= date ( 'Y-m-d' , $proxRecordatorio );

		$Cta = 0;
		if($oCtaCte=='on'){
			$Cta = 1;
		}

		$link=Conectarse();

		$bdEnc=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="RutCli			='".$Cliente.			"',";
			$actSQL.="Rev				='".$Rev.				"',";
			$actSQL.="Cta				='".$Cta.				"',";
			$actSQL.="fechaCotizacion	='".$fechaCotizacion.	"',";
			$actSQL.="proxRecordatorio	='".$proxRecordatorio.	"',";
			$actSQL.="Descripcion		='".$Descripcion.		"',";
			$actSQL.="Observacion		='".$Observacion.		"',";
			$actSQL.="obsServicios		='".$obsServicios.		"',";
			$actSQL.="usrCotizador		='".$usrCotizador.		"',";
			$actSQL.="Validez			='".$Validez.			"',";
			$actSQL.="dHabiles			='".$dHabiles.			"',";
			$actSQL.="nContacto			='".$nContacto.			"',";
			$actSQL.="Atencion			='".$Atencion.			"',";
			$actSQL.="correoAtencion	='".$correoAtencion.	"'";
			$actSQL.="WHERE CAM		= '".$CAM."' and Cta = '".$Cta."'";
			$bdEnc=mysql_query($actSQL);
		}else{
			mysql_query("insert into Cotizaciones(	CAM,
													Rev,
													Cta,
													RutCli,
													nContacto,
													Atencion,
													correoAtencion,
													fechaCotizacion,
													Descripcion,
													Observacion,
													obsServicios,
													usrCotizador,
													Validez,
													dHabiles
													) 
										values 	(	'$CAM',
													'$Rev',
													'$Cta',
													'$Cliente',
													'$nContacto',
													'$Atencion',
													'$correoAtencion',
													'$fechaCotizacion',
													'$Descripcion',
													'$Observacion',
													'$obsServicios',
													'$usrCotizador',
													'$Validez',
													'$dHabiles'
			)");
			
			//$CAM 	= '';
			$accion	= '';
		}

		$bdCon=mysql_query("Select * From contactosCli Where RutCli = '".$Cliente."' and nContacto Like '%".$nContacto."%'");
		if($rowCon=mysql_fetch_array($bdCon)){
			$actSQL="UPDATE contactosCli SET ";
			$actSQL.="nContacto			='".$nContacto.			"',";
			$actSQL.="Contacto			='".$Atencion.			"',";
			$actSQL.="Email				='".$correoAtencion.	"',";
			$actSQL.="Telefono			='".$Telefono.			"'";
			$actSQL.="WHERE RutCli 		= '".$Cliente."' and nContacto Like '%".$nContacto."'";
			$bdCon=mysql_query($actSQL);
		}else{
			$sql = "SELECT * FROM contactosCli Where RutCli = '".$Cliente."'";  // sentencia sql
			$result = mysql_query($sql);
			$nContacto = mysql_num_rows($result)+1; // obtenemos el número de filas
			
			mysql_query("insert into contactosCli(	RutCli,
													nContacto,
													Contacto,
													Email,
													Telefono
													) 
										values 	(	'$Cliente',
													'$nContacto',
													'$Atencion',
													'$correoAtencion',
													'$Telefono'
			)");
		}
		mysql_close($link);
		//$CAM 	= '';
		$accion	= '';
	}
	if($CAM){
		$link=Conectarse();

		$bdCAM=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."' Order By Rev Asc");
		if($rowCAM=mysql_fetch_array($bdCAM)){
			do{
				$NetoUF += $rowdCot[NetoUF];
			}while ($rowCAM=mysql_fetch_array($bdCAM));
		}
		
		
		$bdCAM=mysql_query("Select * From Cotizaciones Where CAM = '".$CAM."' and Cta = '".$Cta."'");
		if($rowCAM=mysql_fetch_array($bdCAM)){
				$Rev 			 = $rowCAM[Rev];
				$Cta 			 = $rowCAM[Cta];
				$fechaCotizacion = $rowCAM[fechaCotizacion];
				$usrCotizador	 = $rowCAM[usrCotizador];
				$Cliente 		 = $rowCAM[RutCli];
				$nContacto 		 = $rowCAM[nContacto];
				$Atencion 		 = $rowCAM[Atencion];
				$correoAtencion  = $rowCAM[correoAtencion];
				$Descripcion	 = $rowCAM[Descripcion];
				$Observacion	 = $rowCAM[Observacion];
				$obsServicios	 = $rowCAM[obsServicios];
				$EstadoCot		 = $rowCAM[Estado];
				$Validez		 = $rowCAM[Validez];
				$dHabiles		 = $rowCAM[dHabiles];
				$enviadoCorreo	 = $rowCAM[enviadoCorreo];
				$pDescuento	 	 = $rowCAM[pDescuento];
				$fechaEnvio		 = $rowCAM[fechaEnvio];
				$NetoUF		 	 = $rowCAM[NetoUF];
				$IvaUF		 	 = $rowCAM[IvaUF];
				$BrutoUF		 = $rowCAM[BrutoUF];
				$Moneda		 	 = $rowCAM[Moneda];
		}		
		mysql_close($link);
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

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
	<script>
	  $(function() {
		$( "#accordion" ).accordion({
		  collapsible: true,
		  icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
		  active: false
		});
	  });
	</script>
	<script>
	function envioExitoso(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev" 	: Rev,
			"Cta" 	: Cta
		};
		//alert(CAM);
		$.ajax({
			data: parametros,
			url: 'eExito.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function realizaProceso(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev"	: Rev,
			"Cta" 	: Cta
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'verDetCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'regCotizacion.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function buscarContactos(Cliente, Atencion, nContacto){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion,
			"nContacto"	: nContacto
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'listaContactos.php',
			type: 'get',
			success: function (response) {
				$("#resultadoContacto").html(response);
			}
		});
	}

	function datosContactos(Cliente, Atencion, nContacto){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion,
			"nContacto"	: nContacto
		};
		//alert(Atencion);
		$.ajax({
			data: parametros,
			url: 'datosDelContacto.php',
			type: 'get',
			success: function (response) {
				$("#rDatosContacto").html(response);
			}
		});
	}

	function asociarSituacion(EstadoCot){
		var parametros = {
			"EstadoCot" 	: EstadoCot
		};
		//alert(Cliente);
		$.ajax({
			data: parametros,
			url: 'mostrarEstadosCAM.php',
			type: 'get',
			success: function (response) {
				$("#activaSituaciones").html(response);
			}
		});
	}

	function enviarCotizacion(CAM, Rev, Cta){
		var parametros = {
			"CAM" 	: CAM,
			"Rev" 	: Rev,
			"Cta" 	: Cta
		};
		//alert(Rev);
		//header("Location: formularios/iCAM.php?CAM=$CAM&Rev=$Rev&Cta=$Cta");
			//url: 'enviarCotizaciones.php',
		$.ajax({
			data: parametros,
			url: 'formularios/iCAM.php',
			type: 'get',
			success: function (response) {
				$("#cajaDeEnvio").html(response);
			}
		});
	}

	function abrirCarro(CAM, Rev, Cta, nServicio, nLin, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"nServicio"	: nServicio,
			"nLin"		: nLin,
			"accion"	: accion
		};
		//alert(nServicio);
		$.ajax({
			data: parametros,
			url: 'calculaServicio.php',
			type: 'get',
			success: function (response) {
				$("#cajaServicios").html(response);
			}
		});
	}

	function calculaDescuento(CAM, Rev, Cta, pDescuento){
		var parametros = {
			"CAM" 			: CAM,
			"Rev" 			: Rev,
			"Cta" 			: Cta,
			"pDescuento"	: pDescuento
		};
		//alert(pDescuento);
		$.ajax({
			data: parametros,
			url: 'calculaDescuento.php',
			type: 'get',
			success: function (response) {
				$("#resultadoDescuento").html(response);
			}
		});
	}


	</script>

	<script>
	function cDescuentoSSSSSSS()
	{
		var x=document.getElementById("pDescuento");
			var vpDescuento	= $("#pDescuento").val();
			alert(vpDescuento);
			var vCantidad	= $("#Cantidad").val();
			var vValorUF	= $("#ValorUF").val();
			var vTotal		= vCantidad * vValorUF;
					
			document.form.Total.value 		= 0;// vTotal;
	}

	function cambiarMoneda(CAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'segCAMvalores.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function nominadeServicios(CAM, buscar){
		var parametros = {
			"CAM"		: CAM,
			"buscar"	: buscar
		};
		//alert(buscar);
		$.ajax({
			data: parametros,
			url: 'mostrarServicios.php',
			type: 'get',
			success: function (response) {
				$("#mostrarListaServicios").html(response);
			}
		});
	}
	
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/other_48.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					COTIZACIÓN 
					<?php if($CAM){
							$fechaxVencer 	= strtotime ( '+'.$Validez.' day' , strtotime ( $fechaCotizacion ) );
							$fechaxVencer 	= date ( 'Y-m-d' , $fechaxVencer );

							$fd = explode('-', $fechaxVencer);
							$fc = explode('-', $fechaCotizacion);
							if($Rev<10){
								$Revision = '0'.$Rev;
							}else{
								$Revision = $Rev;
							}
							echo '<span style="font-size:18px; color:#FFFFFF; ">CAM-'.$CAM.'-'.$Revision.'-'.$Cta.' ('.$fc[2].'/'.$fc[1].'/'.$fc[0].' - '.$fd[2].'/'.$fd[1].'/'.$fd[0].')</span>';
					}
					?>
				</strong>
				<?php //include('barramenu.php'); ?>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				
				<!-- +++ registraEncuesta(CAM, Rev, Cta, 'Agrega') +++ OJO      -->
				<div id="ImagenBarra">
					<a href="#" title="Agregar Cotización" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
					</a>
				</div>
				
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Descargar Cotizaciones...">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('itemsCotizacion.php'); 
			if($CAM == 0){?>
				<script>
					var CAM 	= "<?php echo $CAM; ?>" ;
					var Rev 	= "<?php echo $Rev; ?>" ;
					var Cta 	= "<?php echo $Cta; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(CAM, Rev, Cta, accion);
				</script>
				<?php
			}
			if($accion == 'Borrar'){?>
				<script>
					var CAM 	= "<?php echo $CAM; ?>" ;
					var Rev 	= "<?php echo $Rev; ?>" ;
					var Cta 	= "<?php echo $Cta; ?>" ;
					var accion 	= "<?php echo $accion; ?>" ;
					registraEncuesta(CAM, Rev, Cta, accion);
				</script>
				<?php
			}
			if($accion == 'AgregarServ' or $accion == 'ActualizarServ' or $accion == 'BorrarServ'){?>
				<script>
					var CAM 		= "<?php echo $CAM; 		?>" ;
					var Rev 		= "<?php echo $Rev; 		?>" ;
					var Cta 		= "<?php echo $Cta; 		?>" ;
					var nServicio 	= "<?php echo $nServicio; 	?>" ;
					var nLin 		= "<?php echo $nLin; 		?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					abrirCarro(CAM, Rev, Cta, nServicio, nLin, accion);
				</script>
				<?php
			}
			if(isset($_POST[confirmarEnvio])){?>
				<script>
					var CAM = "<?php echo $CAM; ?>";
					var Rev = "<?php echo $Rev; ?>";
					var Cta = "<?php echo $Cta; ?>";
					envioExitoso(CAM, Rev, Cta);
				</script>
			<?php
			}
			?>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
