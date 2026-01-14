<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$link=Conectarse();
	$bdCli=mysql_query("SELECT * FROM Clientes");
	if($rowCli=mysql_fetch_array($bdCli)){
		do{
			echo 'Cliente... '.$rowCli[Cliente];

			if($rowCli[Contacto]){
				$nContacto = 1;
				$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli[RutCli]."' and Contacto Like '".$rowCli[Contacto]."'");
				if($rowCon=mysql_fetch_array($bdCon)){
					$actSQL="UPDATE contactosCli SET ";
					$actSQL.="nContacto	    ='".$nContacto.				"',";
					$actSQL.="Contacto	    ='".$row[Contacto].			"',";
					$actSQL.="Depto			='".$row[DeptoContacto].	"',";
					$actSQL.="Email			='".$row[EmailContacto].	"',";
					$actSQL.="Telefono		='".$row[FonoContacto].		"'";
					$actSQL.="WHERE RutCli	= '".$RutCli."' and Contacto Like '".$rowCli[Contacto]."'";
					$bdCont=mysql_query($actSQL);
				}else{
					mysql_query("insert into contactosCli(	RutCli,
															nContacto,
															Contacto,
															Depto,
															Email,
															Telefono
															) 
												values 	(	'$rowCli[RutCli]',
															'$nContacto',
															'$rowCli[Contacto]',
															'$rowCli[DeptoContacto]',
															'$rowCli[EmailContacto]',
															'$rowCli[FonoContacto]'
					)",$link);
				}
			}
			
			if($rowCli[Contacto2]){
				$nContacto = 2;
				$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli[RutCli]."' and Contacto Like '".$rowCli[Contacto2]."'");
				if($rowCon=mysql_fetch_array($bdCon)){
					$actSQL="UPDATE contactosCli SET ";
					$actSQL.="nContacto	    ='".$nContacto.				"',";
					$actSQL.="Contacto	    ='".$row[Contacto2].		"',";
					$actSQL.="Depto			='".$row[DeptoContacto2].	"',";
					$actSQL.="Email			='".$row[EmailContacto2].	"',";
					$actSQL.="Telefono		='".$row[FonoContacto2].	"'";
					$actSQL.="WHERE RutCli	= '".$RutCli."' and Contacto Like '".$rowCli[Contacto2]."'";
					$bdCont=mysql_query($actSQL);
				}else{
					mysql_query("insert into contactosCli(	RutCli,
															nContacto,
															Contacto,
															Depto,
															Email,
															Telefono
															) 
												values 	(	'$rowCli[RutCli]',
															'$nContacto',
															'$rowCli[Contacto2]',
															'$rowCli[DeptoContacto2]',
															'$rowCli[EmailContacto2]',
															'$rowCli[FonoContacto2]'
					)",$link);
				}
			}
			
			if($rowCli[Contacto3]){
				$nContacto = 3;
				$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli[RutCli]."' and Contacto Like '".$rowCli[Contacto3]."'");
				if($rowCon=mysql_fetch_array($bdCon)){
					$actSQL="UPDATE contactosCli SET ";
					$actSQL.="nContacto	    ='".$nContacto.				"',";
					$actSQL.="Contacto	    ='".$row[Contacto3].		"',";
					$actSQL.="Depto			='".$row[DeptoContacto3].	"',";
					$actSQL.="Email			='".$row[EmailContacto3].	"',";
					$actSQL.="Telefono		='".$row[FonoContacto3].	"'";
					$actSQL.="WHERE RutCli	= '".$RutCli."' and Contacto Like '".$rowCli[Contacto3]."'";
					$bdCont=mysql_query($actSQL);
				}else{
					mysql_query("insert into contactosCli(	RutCli,
															nContacto,
															Contacto,
															Depto,
															Email,
															Telefono
															) 
												values 	(	'$rowCli[RutCli]',
															'$nContacto',
															'$rowCli[Contacto3]',
															'$rowCli[DeptoContacto3]',
															'$rowCli[EmailContacto3]',
															'$rowCli[FonoContacto3]'
					)",$link);
				}
			}

			if($rowCli[Contacto4]){
				$nContacto = 4;
				$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$rowCli[RutCli]."' and Contacto Like '".$rowCli[Contacto4]."'");
				if($rowCon=mysql_fetch_array($bdCon)){
					$actSQL="UPDATE contactosCli SET ";
					$actSQL.="nContacto	    ='".$nContacto.				"',";
					$actSQL.="Contacto	    ='".$row[Contacto4].		"',";
					$actSQL.="Depto			='".$row[DeptoContacto4].	"',";
					$actSQL.="Email			='".$row[EmailContacto4].	"',";
					$actSQL.="Telefono		='".$row[FonoContacto4].	"'";
					$actSQL.="WHERE RutCli	= '".$RutCli."' and Contacto Like '".$rowCli[Contacto4]."'";
					$bdCont=mysql_query($actSQL);
				}else{
					mysql_query("insert into contactosCli(	RutCli,
															nContacto,
															Contacto,
															Depto,
															Email,
															Telefono
															) 
												values 	(	'$rowCli[RutCli]',
															'$nContacto',
															'$rowCli[Contacto4]',
															'$rowCli[DeptoContacto4]',
															'$rowCli[EmailContacto4]',
															'$rowCli[FonoContacto4]'
					)",$link);
				}
			}

			
			
		}while ($rowCli=mysql_fetch_array($bdCli));
	}
	mysql_close($link);
?>