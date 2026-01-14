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
		header("Location: index.php");
	}
	$nEnc 	= '';
	$nItem 	= '';
	$accion	= '';
	
	if(isset($_GET[nEnc])) 		{	$nEnc 	= $_GET[nEnc]; 		}
	if(isset($_GET[RutCli])) 	{	$RutCli = $_GET[RutCli]; 	}
	
	if(isset($_POST[nEnc])) 	{	$nEnc 	= $_POST[nEnc]; 	}
	if(isset($_POST[RutCli])) 	{	$RutCli	= $_POST[RutCli]; 	}
	if(isset($_POST[nFolio])) 	{	$nFolio	= $_POST[nFolio]; 	}
	
	if(isset($_POST[enviarCorreoEncuesta])){
		$Contacto 		= $_POST[Contacto];
		$EmailContacto 	= $_POST[EmailContacto];
		$Contacto2 		= $_POST[Contacto2];
		$EmailContacto2 = $_POST[EmailContacto2];
		$Contacto3 		= $_POST[Contacto3];
		$EmailContacto3 = $_POST[EmailContacto3];
		$Contacto4 		= $_POST[Contacto4];
		$EmailContacto4 = $_POST[EmailContacto4];
		$fechaEnvio 	= date('Y-m-d');
		
		$link=Conectarse();
		$bdDp=mysql_query("Select * From Departamentos");
		if($rowDp=mysql_fetch_array($bdDp)){
			$EmailDepto = $rowDp[EmailDepto];
		}

		$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
		if($rowEnc=mysql_fetch_array($bdEnc)){
			$nomEnc = $rowEnc[nomEnc];
		}

		$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
		if($rowCli=mysql_fetch_array($bdCli)){
			$Cliente = $rowCli[Cliente];
		}
		
		for($i=1; $i<=4; $i++){
			if($i==1){ $Correo = $EmailContacto;  $Contacto = $Contacto; }
			if($i==2){ $Correo = $EmailContacto2; $Contacto = $Contacto2;}
			if($i==3){ $Correo = $EmailContacto3; $Contacto = $Contacto3;}
			if($i==4){ $Correo = $EmailContacto4; $Contacto = $Contacto4;}
			if($Correo){
				$bdFol=mysql_query("Select * From foliosEncuestas Where nEnc = '".$nEnc."' && RutCli = '".$RutCli."' && Email = '".$Correo."'");
				if($rowFol=mysql_fetch_array($bdFol)){
					$fechaRespuesta = '0000-00-00';
					$nFolio 		= $rowFol[nFolio];
					
					$actSQL="UPDATE foliosEncuestas SET ";
					$actSQL.="fechaRespuesta	='".$fechaRespuesta."',";
					$actSQL.="fechaEnvio		='".$fechaEnvio."'";
					$actSQL.="WHERE nEnc 		= '".$nEnc."' && RutCli = '".$RutCli."' && Email = '".$Correo."'";
					$bdFol=mysql_query($actSQL);
				}else{
					$sql = "SELECT * FROM foliosEncuestas";  // sentencia sql
					$result = mysql_query($sql);
					$nFolio = mysql_num_rows($result)+1; // obtenemos el número de filas

					mysql_query("insert into foliosEncuestas(	nFolio,
																nEnc,
																RutCli,
																Cumplimentado,
																Email,
																fechaEnvio
															) 
													values 	(	'$nFolio',
																'$nEnc',
																'$RutCli',
																'$Contacto',
																'$Correo',
																'$fechaEnvio'
					)",$link);
					
				}
			}
		}

		$emails 	= $EmailContacto;
		if($EmailContacto2){ $emails .= ','.$EmailContacto2; }
		if($EmailContacto3){ $emails .= ','.$EmailContacto3; }
		if($EmailContacto4){ $emails .= ','.$EmailContacto4; }
					
		$to 		= $emails;
					
		$titulo = 'SIMET-USACH';
		
		$msgCorreo  = 'Estimado Cliente: <br>';
		// $msgCorreo .= '<strong>'.$Contacto.'</strong>:<br>';
		$msgCorreo .= $Cliente.':<br><br>';
		$msgCorreo .= ' Laboratorio SIMET-USACH estamos interesados en evaluar la eficiencia de nuestos procesos, ';
		$msgCorreo .= 'para esto les solicitamos su ayuda contestando la siguiente encuesta:<br><br>';
		$msgCorreo .= '
						<a style="font-size:30px; text-decoration:none;" href="http://erp.simet.cl/encuesta/verEncuesta.php?nEnc='.$nEnc.'&RutCli='.$RutCli.'" title="Haz clic aquí...">
							[Contestar Encuesta]
						</a><br>
					';
		$msgCorreo .= 'Agradecemos desde ya su tiempo y disposición.<br><br>';
		$msgCorreo .= 'SIMET-USACH<br>';
		$msgCorreo .= 'Attn.: Héctor Alejandro Bruna Rivera<br>';
		$msgCorreo .= 'Cargo: Encargado(a) de Calidad<br>';
		$msgCorreo .= 'hector.bruna@usach.cl<br>';
		$msgCorreo .= 'Fono/Fax: 02-2323 47 80<br>';
		$msgCorreo .= 'Celular: 585 92 730<br>';
		
		$cabeceras .= "From: SIMET-USACH <".$EmailDepto."> \r\n"; 
		$cabeceras .= "Bcc: franciscoolivares@hotmail.com \r\n"; 
		$cabeceras .= "Content-Type: text/html; charset=iso-8859-1\n";

		if(mail ($to, $titulo, stripcslashes ($msgCorreo), $cabeceras )){
			echo '<script>alert("ENVIADO...")</script>';
			header("Location: enviarEncuesta.php");
		}else{
			echo '<script>alert("ERROR DE ENVIO...")</script>';
		}
		
		mysql_close($link);
	}

	$link=Conectarse();
	$bdEnc=mysql_query("Select * From Encuestas Where nEnc = '".$nEnc."'");
	if($rowEnc=mysql_fetch_array($bdEnc)){
		$nomEnc = $rowEnc[nomEnc];
	}
	mysql_close($link);
	
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

	<script>
	function realizaProceso(nEnc, dBuscar){
		var parametros = {
			"nEnc" 		: nEnc,
			"dBuscar" 	: dBuscar
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'muestraClientes.php',
			type: 'get',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEncuesta(nEnc, RutCli){
		var parametros = {
			"nEnc" 		: nEnc,
			"RutCli" 	: RutCli
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'mandarEncuesta.php',
			type: 'get',
			beforeSend: function () {
				$("#resultadoRegistro").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultadoRegistro").html(response);
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
				<img src="../imagenes/enviarConsulta.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Envio de Encuestas
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
				<div id="ImagenBarra">
					<script>
						var nEnc 	= "<?php echo $nEnc; ?>" ;
					</script>
					<a href="#" title="Agregar Items" onClick="registraEncuesta(nEnc, 0, 'Agrega')">
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
					<a href="clientes.php" title="Clientes">
						<img src="../gastos/imagenes/contactus_128.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaEncuesta.php" title="Nominas de Encuestas">
						<img src="../imagenes/consulta.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Descargar Resultado Encuestas...">
						<img src="../gastos/imagenes/excel_icon.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaEnviar.php'); 

			if($RutCli){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var RutCli 	= "<?php echo $RutCli; ?>" ;
					registraEncuesta(nEnc,  RutCli);
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
