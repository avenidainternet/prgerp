<?php
	session_start(); 
	include_once("conexion.php");
	$usr = "";
	if(isset($_POST[acceso])){
		if(isset($_POST[Login])){
			$link=Conectarse();
			$bdusr=mysql_query("SELECT * FROM Usuarios Where usr Like '%".$_POST[Login]."%' && pwd = '".$_POST[pwd]."'");
			if($row=mysql_fetch_array($bdusr)){
  				session_start(); 
    			$_SESSION[usr]		= $row[usr]; 
    			$_SESSION[pwd]		= $row[pwd];
    			$_SESSION[usuario]	= $row[usuario];
    			$_SESSION[IdPerfil]	= $row[nPerfil];
				$nPerfil 			= $row[nPerfil];
			}
			mysql_close($link);
		}
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/estilos2.0.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="validaciones.js"></script> 
	
</head>

<body>
				<div id="MenuCuerpo" style="background-color:#FFFFFF; ">
					<div id="MenuCuerpoTitulo" class="degradado">
						<img src="imagenes/other_48.png" style="margin:2px;" align="absmiddle" width="20px" height="20px">				
						Menú <?php echo 'Usr... '.$_SESSION[usr]; ?>
					</div>
					<ul>
						<li><a href="plataformaErp.php" 		title="Inicio">			<img src="imagenes/school_128.png" 			style="margin:2px;" align="absmiddle" width="22px" height="22px"> Inicio</a></li>
						<li><a href="cerrarsesion.php" 			title="Cerrar Sesión">	<img src="imagenes/preview_exit_32.png" 	style="margin:2px;" align="absmiddle" width="20px" height="20px"> Cerrar Sesión</a></li>
					</ul>
					<?php
					$link=Conectarse();
					$bdMenu=mysql_query("SELECT * FROM menuGrupos Where nMenu > 1 Order By nMenu");
					if($rowMenu=mysql_fetch_array($bdMenu)){
						do{
							$swMenu = false;
							if($_SESSION[Perfil] == 'Super Usuario' or $_SESSION[Perfil] == 'WebMaster' ){
								$swMenu = true;
							}
							$bdUs=mysql_query("SELECT * FROM ModUsr Where usr = '".$_SESSION[usr]."'");
							if($rowUs=mysql_fetch_array($bdUs)){
								do{
									$bdMit=mysql_query("SELECT * FROM menuItems Where nModulo = '".$rowUs[nModulo]."' and nMenu = '".$rowMenu[nMenu]."'");
									if($rowMit=mysql_fetch_array($bdMit)){
										$swMenu = true;
									}
								}while($rowUs=mysql_fetch_array($bdUs));
							}
							if($swMenu == true){
								?>
								<div id="MenuCuerpoTitulo" class="degradado">
									<img src="imagenes/params_48.png"	style="margin:2px;" align="absmiddle" width="20px" height="20px">				
									<?php echo $rowMenu[nomMenu]; ?>
								</div>
								<ul>
									<?php 
										$bdMit=mysql_query("SELECT * FROM menuItems Where nMenu = '".$rowMenu[nMenu]."'");
										if($rowMit=mysql_fetch_array($bdMit)){
											do{
												$dirProg = "";
												$bdMod=mysql_query("SELECT * FROM Modulos Where nModulo = '".$rowMit[nModulo]."'");
												if($rowMod=mysql_fetch_array($bdMod)){
													$dirProg = $rowMod[dirProg]; 
												}
												if($_SESSION[Perfil] == 'Super Usuario' or $_SESSION[Perfil] == 'WebMaster' ){
													echo '<li><a href="'.$dirProg.'"><img src="imagenes/marker_2.gif" style="padding:5px;" align="absmiddle">'.$rowMit[titulo].'</a></li>';
												}else{
													$bdUs=mysql_query("SELECT * FROM ModUsr Where usr = '".$_SESSION[usr]."' and nModulo = '".$rowMit[nModulo]."'");
													if($rowUs=mysql_fetch_array($bdUs)){
														echo '<li><a href="'.$dirProg.'"><img src="imagenes/marker_2.gif" style="padding:5px;" align="absmiddle">'.$rowMit[titulo].'</a></li>';
													}
												}
											}while($rowMit=mysql_fetch_array($bdMit));
										}
									?>
								</ul>
								<?php 
							}
						}while($rowMenu=mysql_fetch_array($bdMenu));
					}
					mysql_close($link);
					?>
				</div>
</body>
</html>