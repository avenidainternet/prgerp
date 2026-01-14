<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexionli.php"); 
	$link=Conectarse();
	$bdCli=$link->query("SELECT * FROM Clientes");
	if($rowCli=mysqli_fetch_array($bdCli)){
		do{
			echo 'Cliente... '.$rowCli[Cliente];
			$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$rowCli[RutCli]."'");
			if($rowCon=mysqli_fetch_array($bdCon)){
			}else{
				echo 'Creado Contacto... Ok<br>';
				for($nContacto = 1; $nContacto <=4 ; $nContacto++){
					if($nContacto==1){
						$cContacto 	= 'Contacto';
						$cDepto 	= 'DeptoContacto';
						$cEmail 	= 'EmailContacto';
						$cTelefono	= 'FonoContacto';
					}else{
						$cContacto 	= 'Contacto'.$nContacto;
						$cDepto 	= 'DeptoContacto'.$nContacto;
						$cEmail 	= 'EmailContacto'.$nContacto;
						$cTelefono	= 'FonoContacto'.$nContacto;
					}
					if($rowCli[$cContacto]){
						echo 'Contacto... '.$rowCli[$cContacto].'<br>';
						echo 'Depto...... '.$rowCli[$cDepto].'<br>';
						echo 'Email...... '.$rowCli[$cEmail].'<br>';
						echo 'cTelefono.. '.$rowCli[$cTelefono].'<br>';
						echo '<hr>';
						
						$link->query("insert into contactosCli(	RutCli,
																nContacto,
																Contacto,
																Depto,
																Email,
																Telefono
																) 
													values 	(	'$rowCli[RutCli]',
																'$nContacto',
																'$rowCli[$cContacto]',
																'$rowCli[$cDepto]',
																'$rowCli[$cEmail]',
																'$rowCli[$cTelefono]'
						)",$link);
					}
				}				
			}
		}while ($rowCli=mysqli_fetch_array($bdCli));
	}
	$link->close();
?>