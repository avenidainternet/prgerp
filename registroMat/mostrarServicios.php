<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['Cliente'])) 	{ $Cliente  	= $_GET['Cliente']; 	}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto']; 	}
	if(isset($_GET['Atencion']))	{ $Contacto		= $_GET['Atencion']; 	}
	if(isset($_GET['CAM'])) 		{ $CAM  		= $_GET['CAM']; 		}
	if(isset($_GET['Rev'])) 		{ $Rev  		= $_GET['Rev']; 		}
	if(isset($_GET['Cta'])) 		{ $Cta  		= $_GET['Cta']; 		}
	echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="cajaItemsListado">';
	$n 		= 0;
	$link=Conectarse();

	$buscar = $_GET[buscar];
	if($buscar!=''){
		//echo $buscar;
		$bdEnc=mysql_query("SELECT * FROM Servicios Where Servicio Like '%".$buscar."%' Order By Servicio");
	}else{
		$bdEnc=mysql_query("SELECT * FROM Servicios Order By Servicio");
	}		
//		$bdEnc=mysql_query("SELECT * FROM Servicios Order By tpServicio Desc");
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = "barraVerde";
						if($row[tpServicio]=='E'){ // Enviada
							$tr = 'barraAmarilla';
						}

						echo '<tr id="'.$tr.'">';
						echo '	<td width="35%">';
						echo 		$row[Servicio];
						echo '	</td>';
						echo '	<td width="10%">';
									echo '<strong>';
									echo number_format($row[ValorUF], 2, ',', '.');
									echo '</strong>';
						echo ' 	</td>';
						echo '	<td width="10%" align="center"><a href="modCotizacion.php?CAM='.$CAM.'&Cta='.$Cta.'&nServicio='.$row[nServicio].'&nLin=0&accion=AgregarServ"		><img src="../imagenes/carroCompras2.png"   		width="50" height="50" title="Agregar a Cotización">		</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
		mysql_close($link);
		echo '	</table>';
	?>
