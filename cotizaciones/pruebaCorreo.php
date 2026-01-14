<?php
			$mail_destinatario = 'hector.bruna@usach.cl';
			$msgCorreo  = 'Estimados: <br>';

			$horaPAM 	= date('H:i');
			$fechaHoy 	= date('Y-m-d');
			$RAM = 1000;
			$CAM = 1000;
			$fd = explode('-', $fechaHoy);
			$fe = explode('-', $fechaHoy);
						
			$msgCorreo .= '<b>Cliente</b><br><br>';

			$msgCorreo .= 'En estos momentos con fecha '.$fd[2].'-'.$fd[1].'-'.$fd[0].', hora '.$horaPAM.' ha sido ingresado a ';
			$msgCorreo .= 'proceso su requerimiento con el siguiente detalle:<br><br>';

/*
			$msgCorreo .= '<table width="100%" cellpadding="0" cellspacing="0">
								<tr bgcolor="#F8F8F8">
									<td width="40%" style="padding:10px; border-bottom:1px solid #fff;">Número de requerimiento </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$RAM.'</td>
								</tr>
								<tr bgcolor="#F8F8F8">
									<td width="40%" style="padding:10px; border-bottom:1px solid #fff;">Número de cotización </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$CAM.'</td>
								</tr>
								<tr bgcolor="#F8F8F8">
									<td style="padding:10px; border-bottom:1px solid #fff;">Fecha estimada de entrega: </td>
									<td style="padding:10px; border-bottom:1px solid #fff;">'.$fe[2].'-'.$fe[1].'-'.$fe[0].'</td>
								</tr>
							</table>
							<br>';			
*/

			$msgCorreo .= 'Número de requerimiento : '.$RAM.'<br>';
			$msgCorreo .= 'Número de cotización : '.$CAM.'<br>';
			$msgCorreo .= 'Fecha estimada de entrega : '.$fe[2].'-'.$fe[1].'-'.$fe[0].'<br>';

			$msgCorreo .= '<br><b>Nota:</b>';
			$msgCorreo .= '<ul>';
			$msgCorreo .= '	<li>Si el ingreso del trabajo se realiza posterior a las 12:00 hrs, la fecha es calculada según el dia hábil siguiente</li>';
			$msgCorreo .= '	<li>Este e-mail se genera de manera automática, favor no contestar.</li>';
			$msgCorreo .= '</ul>';
			$msgCorreo .= '<br><br>SIMET-USACH';

/*
			$msgCorreo .= 'Laboratorio SIMET-USACH<br>';
			$msgCorreo .= 'Facultad de Ingeniería<br>';
			$msgCorreo .= 'Universidad de Santiago de Chile';
			$msgCorreo .= '</b>';
*/	
			$cabeceras  = "MIME-Version: 1.0\n";
			$cabeceras .= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabeceras .= "X-Priority: 3\n";
			$cabeceras .= "X-MSMail-Priority: Normal\n";
			$cabeceras .= "X-Mailer: php\n";
			
			$Lab 	= 'SIMET-USACH';
			$Correo = 'simet@usach.cl';
			
			$cabeceras .= "From: \"".$Lab."\" <".$Correo.">\n";

			$emailCotizador = 'alejandro.valdes@usach.cl';
						
			$copiasOcultas = 'francisco.olivares.rodriguez@gmail.com, alfredo.artigas@usach.cl, '.$emailCotizador;
			//$copiasOcultas = 'francisco.olivares.rodriguez@gmail.com, ';
			
			$cabeceras .= "Bcc: ".$copiasOcultas." \r\n"; 
	
			$titulo = 'SIMET-USACH Estado de Requerimiento';
			//$loc = "Location: http://erp.simet.cl/cotizaciones/enviarCorreo.php?mail_destinatario=$mail_destinatario&titulo=$titulo&msgCorreo=$msgCorreo&cabeceras=$cabeceras";
			$loc = "Location: http://erp.simet.cl/cotizaciones/enviarCorreo.php?mail_destinatario=$mail_destinatario&titulo=$titulo&emailCotizador=$emailCotizador&msgCorreo=$msgCorreo";
			header($loc);
			
?>