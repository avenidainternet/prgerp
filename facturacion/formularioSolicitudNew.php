<?php
	$Excepcion 	= 'off';
	$Contactos	= '';
	$nOC 		= '';
	if(isset($_GET['nSolicitud'])) 	{ $nSolicitud   = $_GET['nSolicitud']; 	}
	if(isset($_GET['RutCli'])) 		{ $RutCli   	= $_GET['RutCli']; 		}
	if(isset($_GET['nItems'])) 		{ $nItems   	= $_GET['nItems']; 		}
	if(isset($_GET['nOC'])) 		{ $nOC   		= $_GET['nOC']; 		}
	if(isset($_GET['nOrden'])) 		{ $nOrden   	= $_GET['nOrden']; 		}
	if(isset($_GET['CAM'])) 		{ $CAM   		= $_GET['CAM']; 		} 

	if(isset($_GET['Proceso']) == 4){ 

		$nItems 			= 0;
		$valorUnitarioUF 	= 0;
		$Departamento 		= '';
		$Contacto			= '';
		$Proyecto 			= '';
		$nOrden				= '';
		$nOC				= '';
		$CAM				= '';
		
					
		$link=Conectarse();
		$bdDet=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		if($rowDet=mysqli_fetch_array($bdDet)){
			$bdDet=$link->query("DELETE FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		}
		$link->close();
	}


	$Mes = array(
					'Enero', 
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				);

	$RutCli 		= "";
	$Cliente 		= "";
	$Giro 			= "";
	$Direccion		= "";
	$Telefono		= "";
	$Celular		= "";
	$Contacto		= "";
	$Atencion		= '';
	$Email			= "";
	$correosFactura	= '';
	$nSolicitud		= "";
	$nItems			= 1;
	$tipoValor		= 'U';
	$Exenta			= "";
	$fechaSolicitud	= date('Y-m-d');
	$CAM			= 0;
	$RAM			= 0;
	$Proceso 		= '';
	
	$valorUnitarioUF 	= 0;
	$valorTotalUF 		= 0;
	$Redondear 			= 0;
	$Fotocopia 			= '';
	$Factura 			= 0;
	$fechaFactura 		= date('Y-m-d');
	$pagoFactura 		= '';
	$fechaPago 			= date('Y-m-d');
	$Especificacion 	= '';
	$fechaFotocopia 	= '0000-00-00';
	$FechaOrden 		= '0000-00-00';
	$ivaUF 				= 0;
	$brutoUF 			= 0;
	$Iva 				= 0;
	$Bruto 				= 0;
	$informesAM 		= '';
	$cotizacionesCAM 	= '';
	$Observa 			= '';
	$enviarFactura 		= '';
	$valorUnitario 		= 0;
	$valorTotal 		= 0;
	
	$Proceso = 1;
	if(isset($_GET['Proceso']) == 4){ 
		$Proceso = 2;
	}else{
		if(isset($_GET['Proceso'])) 	{ $Proceso  	= $_GET['Proceso']; 	}
	}
	
	if(isset($_GET['RutCli']))			{ $RutCli   	= $_GET['RutCli']; 		}
	if(isset($_GET['Contacto']))		{ $Contacto  	= $_GET['Contacto']; 	}
	if(isset($_GET['nSolicitud'])) 		{ $nSolicitud   = $_GET['nSolicitud']; 	}
	if(isset($_GET['CAM']))  			{ $CAM   		= $_GET['CAM']; 		}
	if(isset($_GET['nOC'])) 		{ $nOC   		= $_GET['nOC']; 		}

	if(isset($_POST['Proceso'])) 	 	{ $Proceso  	 	= $_POST['Proceso']; 		}
	if(isset($_POST['RutCli']))  	 	{ $RutCli   	 	= $_POST['RutCli']; 		}
	if(isset($_POST['Contacto']))	 	{ $Contacto  	 	= $_POST['Contacto']; 		}
	if(isset($_POST['nSolicitud'])) 	{ $nSolicitud   	= $_POST['nSolicitud']; 	}
	if(isset($_POST['CAM']))  		 	{ $CAM   		 	= $_POST['CAM']; 			}
	if(isset($_POST['fechaSolicitud']))	{ $fechaSolicitud 	= $_POST['fechaSolicitud']; }
	if(isset($_POST['nOC'])) 			{ $nOC   			= $_POST['nOC']; 		}

	if($RutCli){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		if($row=mysqli_fetch_array($bdProv)){
   			$Cliente 		= $row['Cliente'];
			$Giro			= $row['Giro'];
			$Direccion		= $row['Direccion'];
   			$Telefono  		= $row['Telefono'];
   			$Celular  		= $row['Celular'];
			$Email 			= $row['Email'];
			$Sitio 			= $row['Sitio'];
			$Publicar		= $row['Publicar'];
		}
		$link->close();
	}
	
		//echo 'CAM '.$_POST['CAM'];
	if(isset($_GET['accionCAM'])){
		if($_GET['accionCAM']=="Quitar"){
			$Facturacion 		= '';
			$fechaFacturacion	= '0000-00-00';
			$nSolicitudCero			= 0;
			$link=Conectarse();
			$fechaFacturacion = date('Y-m-d');
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="nSolicitud		='".$nSolicitudCero.	"',";
			$actSQL.="Facturacion		='".$Facturacion."'";
			$actSQL.="WHERE CAM		= '".$_GET['CAM']."'";
			$bddSol=$link->query($actSQL);

			$cotizacionesCAM 	= '';
			$informesAM			= '';
			$bdSol=$link->query("SELECT * FROM Cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
			while($rowSol=mysqli_fetch_array($bdSol)){
				if(!$cotizacionesCAM){
					$cotizacionesCAM 	= $rowSol['CAM'];
					$informesAM			= $rowSol['RAM'];
				}else{
					$cotizacionesCAM 	.= '-'.$rowSol['CAM'];
					$informesAM			.= '-'.$rowSol['RAM'];
				}
			}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="informesAM		='".$informesAM.		"',";
			$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
			$bddSol=$link->query($actSQL);
			$link->close();
		}
		if($_GET['accionCAM']=="Agregar"){
			$Facturacion = 'on';
			$link=Conectarse();
			$fechaFacturacion = date('Y-m-d');
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="nSolicitud		='".$nSolicitud.		"',";
			$actSQL.="Facturacion		='".$Facturacion."'";
			$actSQL.="WHERE CAM		= '".$_GET['CAM']."'";
			$bddSol=$link->query($actSQL);

			$cotizacionesCAM 	= '';
			$informesAM			= '';
			$bdSol=$link->query("SELECT * FROM Cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
			while($rowSol=mysqli_fetch_array($bdSol)){
				if(!$cotizacionesCAM){
					$cotizacionesCAM 	= $rowSol['CAM'];
					$informesAM			= $rowSol['RAM'];
				}else{
					$cotizacionesCAM 	.= '-'.$rowSol['CAM'];
					$informesAM			.= '-'.$rowSol['RAM'];
				}
			}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="informesAM		='".$informesAM.		"',";
			$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
			$bddSol=$link->query($actSQL);

			$link->close();
		}
	}	

	if(isset($_POST['GuardarFacturacion'])){
		$nSolicitud = 0;		
		if(isset($_POST['nSolicitud']))	{ $nSolicitud 	= $_POST['nSolicitud']; }
		$link=Conectarse();
		if($nSolicitud == 0){
			$bdPr=$link->query("SELECT * FROM tablaRegForm");
				if ($row=mysqli_fetch_array($bdPr)){
					$nSolicitud = $row['nSolFactura'] + 1;
				}
		}
		$Contacto  = '';
		$Contacto2 = '';
		$Contacto3 = '';
		$Contacto4 = '';
		$link->close();
		if(isset($_POST['fechaSolicitud']))			{ $fechaSolicitud 		= $_POST['fechaSolicitud']; 		}
		if(isset($_POST['Proyecto']))				{ $Proyecto 			= $_POST['Proyecto']; 				}
		if(isset($_POST['vencimientoSolicitud']))	{ $vencimientoSolicitud = $_POST['vencimientoSolicitud']; 	}
		if(isset($_POST['valorUF']))				{ $valorUF 				= $_POST['valorUF']; 				}
		if(isset($_POST['fechaUF']))				{ $fechaUF 				= $_POST['fechaUF']; 				}
		if(isset($_POST['nOrden']))					{ $nOrden 				= $_POST['nOrden']; 				}
		if(isset($_POST['Fotocopia']))				{ $Fotocopia 			= $_POST['Fotocopia']; 				}
		if(isset($_POST['fechaFotocopia']))			{ $fechaFotocopia 		= $_POST['fechaFotocopia']; 		}
		if(isset($_POST['Factura']))				{ $Factura 				= $_POST['Factura']; 				}
		if(isset($_POST['fechaFactura']))			{ $fechaFactura 		= $_POST['fechaFactura']; 			}
		if(isset($_POST['pagoFactura']))			{ $pagoFactura 			= $_POST['pagoFactura']; 			}
		if(isset($_POST['fechaPago']))				{ $fechaPago 			= $_POST['fechaPago']; 				}
		if(isset($_POST['enviarFactura']))			{ $enviarFactura		= $_POST['enviarFactura']; 			}
		if(isset($_POST['informesAM']))				{ $informesAM			= $_POST['informesAM']; 			}
		if(isset($_POST['cotizacionesCAM']))		{ $cotizacionesCAM		= $_POST['cotizacionesCAM']; 		}
		if(isset($_POST['Neto']))					{ $Neto					= $_POST['Neto']; 					}
		if(isset($_POST['Iva']))					{ $Iva					= $_POST['Iva']; 					}
		if(isset($_POST['Bruto']))					{ $Bruto				= $_POST['Bruto']; 					}
		if(isset($_POST['Observa']))				{ $Observa				= $_POST['Observa']; 				}
		if(isset($_POST['Contacto']))				{ $Contacto				= $_POST['Contacto']; 				}
		if(isset($_POST['Contacto2']))				{ $Contacto2			= $_POST['Contacto2']; 				}
		if(isset($_POST['Contacto3']))				{ $Contacto3			= $_POST['Contacto3']; 				}
		if(isset($_POST['Contacto4']))				{ $Contacto4			= $_POST['Contacto4']; 				}
		if(isset($_POST['Contactos']))				{ $Contactos			= $_POST['Contactos']; 				}
		if(isset($_POST['Exenta']))					{ $Exenta				= $_POST['Exenta']; 				}

		if(isset($_POST['nItems']))					{ $nItems				= $_POST['nItems']; 				}
		if(isset($_POST['Cantidad']))				{ $Cantidad				= $_POST['Cantidad']; 				}
		if(isset($_POST['Especificacion']))			{ $Especificacion		= $_POST['Especificacion']; 		}
		if(isset($_POST['Excepcion']))				{ $Excepcion			= $_POST['Excepcion']; 				}
		if(isset($_POST['Email']))					{ $correosFactura		= $_POST['Email']; 					}
		if(isset($_POST['valorUnitario']))			{ $valorUnitario		= $_POST['valorUnitario']; 			}
		if(isset($_POST['valorTotal']))				{ $valorTotal			= $_POST['valorTotal']; 			}
		
		if(isset($_POST['tipoValor']))				{ $tipoValor 			= $_POST['tipoValor']; 				}
		if(isset($_POST['valorUnitarioUF']))		{ $valorUnitarioUF		= $_POST['valorUnitarioUF']; 			}
		if(isset($_POST['valorTotalUF']))			{ $valorTotalUF			= $_POST['valorTotalUF']; 
		if(isset($_POST['netoUF']))					{ $netoUF				= $_POST['netoUF']; 				}
		if(isset($_POST['ivaUF']))					{ $ivaUF				= $_POST['ivaUF']; 					}
		if(isset($_POST['brutoUF']))				{ $brutoUF				= $_POST['brutoUF']; 				}
					}
		if(isset($_POST['Redondear']))				{ $Redondear			= $_POST['Redondear']; 			}

		$link=Conectarse();
		if($Especificacion){
			if($Excepcion != 'on'){
				if($tipoValor=='U'){
					$valorTotalUF 	= $Cantidad * $valorUnitarioUF;
				}else{
					$valorTotal 	= $Cantidad * $valorUnitario;
				}
			}
			$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
			if ($rowdSol=mysqli_fetch_array($bddSol)){
				$actSQL="UPDATE detSolFact SET ";
				$actSQL.="Cantidad		 	='".$Cantidad."',";
				$actSQL.="RutCli 			='".$RutCli."',";
				$actSQL.="Especificacion 	='".$Especificacion."',";
				$actSQL.="valorUnitarioUF  	='".$valorUnitarioUF."',";
				$actSQL.="valorTotalUF     	='".$valorTotalUF."'";
				$actSQL.="valorUnitario  	='".$valorUnitario."',";
				$actSQL.="valorTotal     	='".$valorTotal."'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && nItems = '".$nItems."'";
				$bddSol=$link->query($actSQL);
			}else{
				$link->query("insert into detSolFact(	nSolicitud,
														nItems,
														RutCli,
														Cantidad,
														Especificacion,
														valorUnitario,
														valorTotal,
														valorUnitarioUF,
														valorTotalUF
													) 
											values 	(	'$nSolicitud',
														'$nItems',
														'$RutCli',
														'$Cantidad',
														'$Especificacion',
														'$valorUnitario',
														'$valorTotal',
														'$valorUnitarioUF',
														'$valorTotalUF'
				)");
			}
		}		
		$Neto   = 0;
		$netoUF = 0;
		$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
		if ($rowdSol=mysqli_fetch_array($bddSol)){
			do{
				if($tipoValor=='U'){
					$Neto		= 0;
					$Iva		= 0;
					$Bruto		= 0;
					if($Exenta=='on'){
						$netoUF  	+= $rowdSol['valorTotalUF'];
						$ivaUF		 = 0;
						$brutoUF 	= $netoUF;
					}else{
						$netoUF  	+= $rowdSol['valorTotalUF'];
						$ivaUF		 = $netoUF * 0.19;
						$brutoUF	 = $netoUF * 1.19;
					}
				}else{
					$netoUF		= 0;
					$ivaUF		= 0;
					$brutoUF	= 0;

					if($Exenta=='on'){
						$Neto  += $rowdSol['valorTotal'];
						$Iva	= 0;
						$Bruto = $Neto;
					}else{
						$Neto  += $rowdSol['valorTotal'];
						$Iva	= intval($Neto * 0.19);
						$Bruto	= intval($Neto * 1.19);
						if($Redondear=='on'){
							$Iva	= round(($Neto * 0.19),0);
							$Bruto	= round(($Neto * 1.19),0);
						}
					}
				}
			}while ($rowdSol=mysqli_fetch_array($bddSol));
		}
		if($Excepcion == 'on'){
			if(isset($_POST['Neto']))					{ $Neto					= $_POST['Neto']; 					}
			if(isset($_POST['Iva']))					{ $Iva					= $_POST['Iva']; 					}
			if(isset($_POST['Bruto']))					{ $Bruto				= $_POST['Bruto']; 					}
		}
		$bdProv=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($row=mysqli_fetch_array($bdProv)){
			if($valorUF > 0){
				$actSQL="UPDATE tablaRegForm SET ";
				$actSQL.="valorUFRef	='".$valorUF."'";
				$bd=$link->query($actSQL);
			}
			if($Contacto)  { $Contactos = $Contacto; 		}
			if($Contacto2) { $Contactos .= ','.$Contacto2; 	}
			if($Contacto3) { $Contactos .= ','.$Contacto3; 	}
			if($Contacto4) { $Contactos .= ','.$Contacto4; 	}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="fechaSolicitud		='".$fechaSolicitud.		"',";
			$actSQL.="IdProyecto			='".$Proyecto.				"',";
			$actSQL.="Contacto				='".$Contacto.				"',";
			$actSQL.="Atencion				='".$Contactos.				"',";
			$actSQL.="correosFactura		='".$correosFactura.		"',";
			$actSQL.="vencimientoSolicitud 	='".$vencimientoSolicitud.	"',";
			$actSQL.="valorUF 				='".$valorUF.				"',";
			$actSQL.="fechaUF 				='".$fechaUF.				"',";
			$actSQL.="nOrden				='".$nOrden.				"',";
			$actSQL.="Fotocopia				='".$Fotocopia.				"',";
			if($Fotocopia=='on'){
				$actSQL.="fechaFotocopia	='".$fechaFotocopia.		"',";
			}else{
				$fechaFotocopia = "0000-00-00";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia.		"',";
			}
			$actSQL.="tipoValor				= '".$tipoValor.			"',";
			$actSQL.="Exenta				= '".$Exenta.				"',";
			$actSQL.="Factura				= '".$Factura.				"',";
			$actSQL.="fechaFactura	    	= '".$fechaFactura.			"',";
			$actSQL.="pagoFactura	    	= '".$pagoFactura.			"',";
			$actSQL.="fechaPago				= '".$fechaPago.			"',";
			$actSQL.="enviarFactura			= '".$enviarFactura.		"',";
			$actSQL.="informesAM	    	= '".$informesAM.			"',";
			$actSQL.="cotizacionesCAM		= '".$cotizacionesCAM.		"',";
			$actSQL.="Observa				= '".$Observa.				"',";
			$actSQL.="Redondear				= '".$Redondear.			"',";
			$actSQL.="Excepcion				= '".$Excepcion.			"',";
			$actSQL.="Neto					= '".$Neto.					"',";
			$actSQL.="Iva	    			= '".$Iva.					"',";
			$actSQL.="Bruto					= '".$Bruto.				"',";
			$actSQL.="netoUF				= '".$netoUF.				"',";
			$actSQL.="ivaUF	    			= '".$ivaUF.				"',";
			$actSQL.="brutoUF				= '".$brutoUF.				"'";
			$actSQL.="WHERE nSolicitud		= '".$nSolicitud."' && RutCli = '".$RutCli."'";
			$bdProv=$link->query($actSQL);
		}else{
				$bdTab=$link->query("SELECT * FROM tablaRegForm");
				if ($row=mysqli_fetch_array($bdTab)){
					$actSQL="UPDATE tablaRegForm SET ";
					$actSQL.="nSolFactura	='".$nSolicitud."'";
					$bdTab=$link->query($actSQL);
				}
				if($Contacto)  { $Contactos = $Contacto; 		}
				if($Contacto2) { $Contactos .= ','.$Contacto2; 	}
				if($Contacto3) { $Contactos .= ','.$Contacto3; 	}
				if($Contacto4) { $Contactos .= ','.$Contacto4; 	}
				$link->query("insert into SolFactura(	nSolicitud,
														RutCli,
														fechaSolicitud,
														IdProyecto,
														Contacto,
														Atencion,
														correosFactura,
														Fotocopia,
														fechaFotocopia,
														nOrden,
														FechaOrden,
														Factura,
														fechaFactura,
														pagoFactura,
														fechaPago,
														vencimientoSolicitud,
														valorUF,
														fechaUF,
														tipoValor,
														Exenta,
														netoUF,
														ivaUF,
														brutoUF,
														Neto,
														Iva,
														Bruto,
														informesAM,
														cotizacionesCAM,
														Observa,
														Redondear,
														Excepcion,
														enviarFactura
														) 
										values 		(	'$nSolicitud',
														'$RutCli',
														'$fechaSolicitud',
														'$Proyecto',
														'$Contacto',
														'$Contactos',
														'$Email',
														'$Fotocopia',
														'$fechaFotocopia',
														'$nOrden',
														'$FechaOrden',
														'$Factura',
														'$fechaFactura',
														'$pagoFactura',
														'$fechaPago',
														'$vencimientoSolicitud',
														'$valorUF',
														'$fechaUF',
														'$tipoValor',
														'$Exenta',
														'$netoUF',
														'$ivaUF',
														'$brutoUF',
														'$Neto',
														'$Iva',
														'$Bruto',
														'$informesAM',
														'$cotizacionesCAM',
														'$Observa',
														'$Redondear',
														'$Excepcion',
														'$enviarFactura'
														)");
   				$MsgUsr = 'Se ha registrado un nueva Solicitud de Facturación ...';
		}
		$link->close();
	}
//	if($Proceso==2){
		$nOrden		= '';
		$vencimientoSolicitud = 0;
		$valorUF = 0;
		$fechaUF = '0000-00-00';
		$enviarFactura = '';
		
		$link=Conectarse();
		$bdSol=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($rowSol=mysqli_fetch_array($bdSol)){
   			$fechaSolicitud 		= $rowSol['fechaSolicitud'];
   			$Proyecto 				= $rowSol['IdProyecto'];
   			$Fotocopia 				= $rowSol['Fotocopia'];
   			$fechaFotocopia 		= $rowSol['fechaFotocopia'];
   			$nOrden 				= $rowSol['nOrden'];
   			$FechaOrden 			= $rowSol['FechaOrden'];
   			$Contacto				= $rowSol['Contacto'];
   			$Atencion				= $rowSol['Atencion'];
   			$Contactos				= $rowSol['Atencion'];
   			$correosFactura			= $rowSol['correosFactura'];
   			//$ContactoSol			= $rowSol['Contacto'];
   			$Factura				= $rowSol['Factura'];
   			$fechaFactura			= $rowSol['fechaFactura'];
   			$pagoFactura			= $rowSol['pagoFactura'];
   			$fechaPago				= $rowSol['fechaPago'];
   			$vencimientoSolicitud	= $rowSol['vencimientoSolicitud'];
   			$valorUF				= $rowSol['valorUF'];
   			$fechaUF				= $rowSol['fechaUF'];
   			$tipoValor				= $rowSol['tipoValor'];
   			$Exenta					= $rowSol['Exenta'];
   			$netoUF					= $rowSol['netoUF'];
   			$ivaUF					= $rowSol['ivaUF'];
   			$brutoUF				= $rowSol['brutoUF'];
   			$Neto					= $rowSol['Neto'];
   			$Iva					= $rowSol['Iva'];
   			$Bruto					= $rowSol['Bruto'];
   			$informesAM				= $rowSol['informesAM'];
   			$cotizacionesCAM		= $rowSol['cotizacionesCAM'];
   			$Observa				= $rowSol['Observa'];
   			$Redondear				= $rowSol['Redondear'];
   			$enviarFactura			= $rowSol['enviarFactura'];
		}
		if($CAM) { 
			$CAM   			= $_GET['CAM']; 			
			$bd=$link->query("SELECT * FROM cotizaciones WHERE CAM = '$CAM'");
			if($rs=mysqli_fetch_array($bd)){
				$nSolicitud = $rs['nSolicitud'];
				$CAM 		= $rs['CAM'];
			}
		}
		// echo $CAM.' '.$_GET['CAM'];
		if($nSolicitud) { 
			$nSolicitud   	= $_GET['nSolicitud']; 		
			$bd=$link->query("SELECT * FROM cotizaciones WHERE nSolicitud = '$nSolicitud'");
			if($rs=mysqli_fetch_array($bd)){
				$CAM 		= $rs['CAM'];
				$nSolicitud = $rs['nSolicitud'];
			}
		}


		$link->close();
	
//	}
?>

<script>
function myFunction()
{
	var x=document.getElementById("Observa");
	x.value=x.value.toUpperCase();
	var x=document.getElementById("Especificacion");
	x.value=x.value.toUpperCase();
	var x=document.getElementById("valorUnitario");
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
		var vTotal	= vCan * vUni;
		
		//document.form.valorTotal.value 	= vCan * vUni;
		document.form.valorTotal.value 	= vTotal;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;
}
</script>

<script>
$(document).ready(function(){
	$("#tpValor").change(function() {
		var vtValor	= $("#tpValor").val();
		document.form.tipoValor.value 	= vtValor;
	});
	
	$("#Redondear").change(function() {
		var vRed	= $("#Redondear").val();
		var vNet	= $("#Neto").val();
		var vIva	= parseInt(vNet * 0.19);
		var vBru	= parseInt(vNet * 1.19);
		if (vRed == 'on')
		{
			var vIva	= Math.round((vNet * 0.19));
			var vBru	= Math.round((vNet * 1.19));
		}
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;
		return;
	});
	$("#Cantidad").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotal.value 	= vCan * vUni;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;

		return;
	});
	$("#valorUnitario").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotal.value 	= vCan * vUni;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;

		return;
	});
	$("#valorUnitarioUF").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitarioUF").val();
		var vNet	= $("#netoUF").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotalUF.value 	= vCan * vUni;
		document.form.ivaUF.value 			= vIva;
		document.form.brutoUF.value 		= vBru;

		return;
	});
	
	$("#Can").bind('keydown', function(event)
	{
	alert(event.keyCode);
	if (event.keyCode == '13')
		{
		neto  = document.form.NetoF.value;
		iva	  = neto * 0.19;
		bruto = neto * 1.19;
		document.form.IvaF.value 	= iva;
		document.form.BrutoF.value 	= bruto;
		// document.form.Iva.focus();
		return 0;
		}
	});
});
</script>
<form name="form" action="formSolicitaFacturaNew.php" method="post">
	<div class="container-fluid" style="margin-top: 5px;">
		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h5>FORMULARIO N° 4 - SOLICITUD DE FACTURA {{nSolicitud}}</h5>
			</div>
		  	<div class="card-body">
		  		<div class="row">
		  			<div class="col-lg-1">
		  				<label for="nSolicitud">Solicitud:</label>
		  			</div>
		  			<div class="col-lg-2">
		  				<?php
							$link=Conectarse();
							$bdDepto=$link->query("SELECT * FROM Departamentos");
							if ($rowDepto=mysqli_fetch_array($bdDepto)){
								$EmailDepto = $rowDepto['EmailDepto'];
							}
							$link->close();
						?>
						{{res}}
						<input 	ng-model 	= "RutCli" 
								name 		= "RutCli"
								class 		= "form-control" 
								ng-init 	= "RutCli = '<?php echo $RutCli; ?>'"
								type 		= "hidden">

						<input 	ng-model 	= "Rut" 
								name 		= "Rut"
								class 		= "form-control" 
								ng-init 	= "buscarCliente(<?php echo $RutCli; ?>)"
								type 		= "hidden">

						<!-- ng-init="nSolicitud = '<?php echo $nSolicitud; ?>'" -->
						<input 	ng-model	= "nSol" 
								type 		= "hidden"
								ng-init 	= "nSol = '<?php echo $nSolicitud; ?>'">

						<input 	ng-model 	= "nSolicitud" 
								name 		= "nSolicitud"
								class 		= "form-control" 
								ng-init 	= "loadSolicitud()"
								style 	 	= "font-size:24px;">
		  			</div>
		  			<div class="col-lg-4">
		  			</div>
		  			<div class="col-lg-1">
		  				Fecha Solicitud:
		  			</div>
		  			<div class="col-lg-2">
		  			</div>
		  			<div class="col-lg-2">
						<input 	name 	= "fechaSolicitud" 
								ng-model= "fechaSolicitud" 
								class 	= "form-control"
								ng-init = "fechaSolicitud='<?php echo $fechaSolicitud; ?>'"
								value 	= "<?php echo $fechaSolicitud; ?>"
								type 	= "date">
		  			</div>
		  		</div>
		  	</div> 
		</div>
	</div>

	<div class="container-fluid" style="margin-top: 5px;">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white"><h5>Datos del Cliente</h5></div>
				  	<div class="card-body">
				  		<div class="row">
				  			<div class="col-2">
				  				Cliente:
				  			</div>
				  			<div class="col-2">
				  				{{RutCli}}
				  			</div>
				  			<div class="col-8">
								<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
                                <select    	name="tabCliente" 
                                        	ng-model="tabCliente" 
                                            class="form-control" 
                                            ng-click="cargarCliente()"
                                            ng-init="loadClientes()">   
                                            <option value="">{{Cliente}}</option>  
                                            <option ng-repeat="regCli in tabClientes" value="{{regCli.RutCli}}">{{regCli.Cliente}}</option>  
                                </select>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Razon Social:
				  			</div>
				  			<div class="col-10">
								<input name="Cliente" ng-model="Cliente" class="form-control" type="text" size="50" maxlength="50">								
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Giro:
				  			</div>
				  			<div class="col-10">
				  				<input name="Giro" ng-model="Giro" class="form-control"	type="text" size="80" maxlength="100">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Atención: {{resCon}}
				  			</div>
				  			<div class="col-10">
				  				<div class="row">
				  					<div class="col-6">
				  						Contactos para incluir:
		                                <select    	name="tabContactosCli" 
		                                        	ng-model="tabContactosCli" 
		                                            class="form-control" 
		                                            ng-change="agregarContacto()"
		                                            ng-init="loadContactos()">  
		                                            <option value="">{{tabContacto}}</option>  
		                                            <option ng-repeat="regCli in tabContactos" value="{{regCli.nContacto}}">{{regCli.Contacto}}</option>  
		                                </select>
                                	</div>
                                	<div class="col-6">
                                		Incluidos:
		                                <select    	name="tabContactosFac" 
		                                        	ng-model="tabContactosFac" 
		                                            class="form-control" 
		                                            ng-change="quitarContacto()"
		                                            ng-init="loadContactosInc()">  
		                                            <option value="">{{Incluidos}}</option>  
		                                            <option ng-repeat="regCliInc in tabContactosInc" value="{{regCliInc.nContacto}}">{{regCliInc.Contacto}}</option>  
		                                </select>


                            		</div>
                            	</div>
								<div class="input-group mb-3">
									<input ng-model="Atencion" class="form-control" type="text" size="100" maxlength="100"> 
								</div>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Depto. :
				  			</div>
				  			<div class="col-10">
				  				<input name="Departamento" class="form-control" 	type="text" size="50" maxlength="50" ng-model="Departamento">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Dirección:
				  			</div>
				  			<div class="col-10">
				  				<input name="Direccion" ng-model="Direccion" class="form-control" 	type="text" size="50" maxlength="50">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Teléfono:
				  			</div>
				  			<div class="col-10">
				  				<input ng-model="Telefono" class="form-control" type="text" size="50" maxlength="50">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Correo:
				  			</div>
				  			<div class="col-10">
								<input ng-model="correosFactura" class="form-control" type="text" size="100" maxlength="100">	
				  			</div>
				  		</div>

					</div>
				</div>
			</div>
			<?php
			if($Cliente){?>

			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white"><h5>Datos para Facturación</h5></div>
				  	<div class="card-body">
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Proyecto:
				  			</div>
				  			<div class="col-9">
                                <select    	name="IdProyecto" 
                                        	ng-model="IdProyecto" 
                                            class="form-control" 
                                            ng-click="cargarProyecto()"
                                            ng-init="loadProyectos()" required>  
                                            <option value="">{{IdProyecto}}</option>  
                                            <option ng-repeat="regProy in tabProyectos" value="{{regProy.IdProyecto}}">{{regProy.IdProyecto}}</option>  
                                </select>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Orden de Compra:
				  			</div>
				  			<div class="col-9">
				  				<input name="nOrden" ng-model="nOrden" ng-init 	= "nOrden = '<?php echo $nOC; ?>'" class="form-control" type="text" size="50" maxlength="50">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Vencimiento:
				  			</div>
				  			<div class="col-9">
				  				<div class="row">
				  					<div class="col-3">
										<input 	name="vencimientoSolicitud" 
												ng-model="vencimientoSolicitud" 
												class="form-control"	
												type="text" 
												size="5" 
												maxlength="5" />
									</div>
									<div class="col-9">
										Días
									</div>
								</div>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				{{tituloExenta}}:
				  			</div>
				  			<div class="col-9">
				  				<input type="checkbox" ng-change="estadoExenta()" ng-model="Exenta">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Redondear:
				  			</div>
				  			<div class="col-9">
				  				<input type="checkbox" ng-change="Redondea()" ng-model="Redondear">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Valores en: Valores 
				  			</div>
				  			<div class="col-9">
                            	<select class 		= "form-control"
                                		ng-model	= "tipoValor" 
                                		ng-change 	= "activadesactivaValor()"
                                    	ng-options 	= "tipoValor.codMoneda as tipoValor.descripcion for tipoValor in monedas" >
                                	<option value="P">{{moneda}}</option>
                                </select>
				  			</div>
				  		</div>
				  		<div ng-show="valUF">
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				UF Referencial:
				  			</div>
				  			<div class="col-9">
				  				<input name="valorUF" ng-model="valorUF" class="form-control" type="text" size="10" maxlength="10">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Fecha Referencia:
				  			</div>
				  			<div class="col-9">
				  				<input name="fechaUF" ng-model="fechaUF" class="form-control" type="date" id="fechaUF" size="10" maxlength="10">
				  			</div>
				  		</div>
				  		</div>
				  		<div class="row" style="margin-top: 4px;">
				  			<div class="col-3">
				  				Enviar Factura:
				  			</div>
				  			<div class="col-9">
				  				<div class="row">
				  					<div class="col-4 text-center">
				  						<div class="form-group">
  											<label for="enviarFactura">USACH:</label>
  											<input type="radio" ng-model="enviarFactura" value="1"> 
										</div>
				  					</div>
				  					<div class="col-4 text-center">
  											<label for="enviarFactura">EMPRESA:</label>
  											<input type="radio" ng-model="enviarFactura" value="2"> 
				  					</div>
				  					<div class="col-4 text-center">
  											<label for="enviarFactura">OTRA:</label>
  											<input type="radio" ng-model="enviarFactura" value="3"> 
				  					</div>

				  				</div>
				  			</div>
				  		</div>
				  		<div class="row">
				  			<div class="col-8">
								<div class="alert alert-success alert-dismissible" ng-show="msgGraba">
								  <strong>{{resGuardar}}!</strong>
								</div>
				  			</div>
				  			<div class="col-4">
						  		<a type="button" ng-click="guardardatos()" class="btn btn-warning" name="guardardatos" style="float:right; ">Guardar Datos</a>
				  			</div>
						</div>			  		
				  		
					</div>
				</div>
				<div class="card mt-2">
					<div  class="card-header bg-secondary text-white"><h5>Documentación Asociada</h5></div>
				  	<div class="card-body">

					  	<!-- <div class="btn-group" ng-init="copiaCAM()"> -->
					  	<div class="btn-group">
  							<a type="button" class="btn btn-warning m-1" href="../procesosangular/formularios/iCAMArchivaFacturacion.php?CAM=<?php echo $CAM; ?>&Rev=0&Cta=0&accion=Reimprime" title="Imprimir Cotización Asociada">CAM-<?php echo $CAM; ?>.pdf</a>

							<?php
								// echo $iCAM;
								// header();
                                            $link=Conectarse();

                                            $agnoActual = date('Y'); 
											$disabled = "disabled";
                                            $bd=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
                                            if($rs=mysqli_fetch_array($bd)){
												$idCotizacion = 'CAM-'.$CAM.' Rev-00.pdf';
												$docAne		= 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/ANE-'.$CAM.'.pdf';;
												$docAne		= 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/ANE-'.$CAM.'.pdf';;
												$vDirAne 	= 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/Factura.pdf';
												if(file_exists($docAne)){
													copy($docAne, $vDirAne);
												} 
												$vDirSOL = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
												if(!file_exists($vDirSOL)){
													mkdir($vDirSOL);
												}

												$vDirCAMOri = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/COTIZACIONES/'.$idCotizacion;
												$vDirCAMDes = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud.'/'.$idCotizacion;
												// $docAne		= 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/ANE-'.$CAM.'.pdf'; // BORRAR DESPUES
												//echo $vDirCAMOri,'<br>';
												//echo $vDirCAMDes,'<br>';
												if(file_exists($vDirCAMOri)){
													copy($vDirCAMOri, $vDirCAMDes);
												} 

                                                $ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/';
                                                $ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/';

                                                if(file_exists($ruta)){
                                                    $gestorDir = opendir($ruta);
                                                    while(false !== ($nombreDir = readdir($gestorDir))){
														$CAMb = 0;
                                                        if($nombreDir != 'Thumbs.db' and $nombreDir != '.' and $nombreDir != '..' and $nombreDir != ''){
															$fd = explode('-',$nombreDir); // OC-17760.xlsx
															if($fd[0] == 'OC') {
																$disabled = '';
                                                            	$fd = explode('.', $fd[1]);
                                                            	$CAMb = $fd[0];
                                                            	if($CAM == $CAMb or $CAMb == $rs['nSolicitud']){
																	$vDirNew = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$rs['nSolicitud'].'/';
																	if(!file_exists($vDirNew)){
																		mkdir($vDirNew);
																	}
																	copy($ruta.$nombreDir, $vDirNew.$nombreDir);
																	copy($vDirNew.$nombreDir, '../tmp/'.$nombreDir);
																	?>
																	<a type="button" class="btn btn-info m-1" href="<?php echo '../tmp/'.$nombreDir; ?>" target="_blank" title="Imprimir Orden de Compra"><?php echo $nombreDir; ?></a>
                                                            		<?php
                                                            	//break;
                                                            	}
                                                            }
                                                        }
                                                    }
                                                }


                                                $agnoActual = date('Y'); 
                                                $vDir       = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$rs['CAM'].'.xlsx';
                                                $vDir       = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/OC-'.$rs['CAM'].'.xlsx';
                                                //$vDir       = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$rs['CAM'].'.xlsx';
                                                $vDirTmp    = '../tmp/OC-'.$rs['CAM'].'.xlsx';
                                            }
                                            $link->close();
                        	?>
						</div>







					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>



<div ng-show="verDetalle">
	<div class="container-fluid" style="margin-top: 5px;">
		<div class="card">
			<div class="card-header bg-secondary text-white"><h5>Asociar CAMs y RAMs</h5></div>
				<div class="card-body">
					Registro de Trabajos Terminados para Facturar (AM)
					<div class="row">
						<div class="col-6">
			                <table class="table table-dark table-hover">
			                    <thead>
			                        <tr>
			                            <th>TRABAJOS DISPONIBLES </th>
			                            <th>Ordenes       	</th>
			                            <th>HES       		</th>
			                            <th>UF       		</th>
			                            <th>Pesos       	</th>
			                            <th>Acciones    	</th>
			                        </tr>
			                    </thead>
			                    <tbody>
								  	<tr ng-repeat="x in informes" class="table-light text-dark">
								    	<td>RAM-{{ x.RAM }} CAM-{{ x.CAM }}</td>
								    	<td><b>{{ x.nOC }}</b>	</td>
								    	<td><b>{{ x.HES }}</b>	</td>
								    	<td>{{ x.BrutoUF }} 	</td>
								    	<td>{{ x.Bruto }} 		</td>
								    	<td>
											<div ng-show="x.nOC == nOrden">
												<a type="button" 
													class="btn btn-info"
													ng-click="agregaPega(x.CAM, nSolicitud, RutCli)">
													Agregar
												</a>
											</div>
								    	</td>
								  	</tr>			                    	
			                    </tbody>
			                </table>
			            </div>
						<div class="col-6">
			                <table class="table table-dark table-hover ">
			                    <thead>
			                        <tr>
			                            <th>TRABAJOS A SER FACTURADOS   	</th>
			                            <th>Ordenes       	</th>
			                            <th>HES       		</th>
			                            <th>UF       		</th>
			                            <th>Pesos       	</th>
			                            <th>Acciones    	</th>
			                        </tr>
			                    </thead>
			                    <tbody>
								  	<tr ng-repeat="x in informesAfacturar" class="table-success text-dark">
								    	<td>RAM-{{ x.RAM }} CAM-{{ x.CAM }}</td>
								    	<td>{{ x.nOC }}		</td>
								    	<td>{{ x.HES }}		</td>
								    	<td>{{ x.BrutoUF }}	</td>
								    	<td>{{ x.Bruto }}	</td>
								    	<td>
								    		<a type="button" 
								    			class="btn btn-warning"
								    			ng-click="quitarPega(x.CAM, nSolicitud, RutCli)">
								    			Quitar
								    		</a>
								    	</td>
								  	</tr>			                    	
			                    </tbody>
			                </table>
			            </div>
			        </div>
			    </div>
			</div>


			<div class="card" style="margin-top: 5px;">
				<div class="card-header bg-secondary text-white"><h5>Detalle Facturación </h5></div>
					<div class="card-body">
						Factura Exenta <input type="checkbox" ng-model="Exenta">
						<table  class="table table-dark table-hover table-bordered">
							<thead>
								<tr>
							  		<th width="10%">ITEMS</td>
							  		<th width="10%">CANTIDAD</td>
							  		<th width="45%">ESPECIFICACION</td>
							  		<th width="10%">Valor Unitario</td>
							  		<th width="10%">VALOR TOTAL</td>
							  		<th width="15%">Acciones</td>
								</tr>
							</thead>
							<tbody>
							  	<tr ng-repeat="x in dFacturacion" class="table-success text-dark">
								    	<td>{{ x.nItems }} </td>
								    	<td>
								    		<input type="type" ng-model="x.Cantidad" class="form-control" />
								    	</td>
								    	<td>
								    		<textarea type="type" ng-model="x.Especificacion" class="form-control"></textarea>
								    	</td>
								    	<td>
										    <input type="type" ng-if="tipoValor == 'U'" ng-model="x.valorUnitarioUF" class="form-control">

										    <input type="type" ng-if="tipoValor == 'P'" ng-model="x.valorUnitario" class="form-control"> 

										    <input type="type" ng-if="tipoValor == 'D'" ng-model="x.valorUnitarioUS" class="form-control"> 										    								    		
								    	</td>
								    	<td>
								    		<div ng-if="tipoValor == 'U'">
								    			{{ x.valorTotalUF }}
								    		</div>
								    		<div ng-if="tipoValor == 'P'">
								    			{{ x.valorTotal }}
								    		</div>
								    		<div ng-if="tipoValor == 'D'">
								    			{{ x.valorTotalUS }}
								    		</div>
								    	</td>
								    	<td>
								    		<a 
								    			type="button" 
								    			class="btn btn-warning"
								    			ng-click="recalcular(nSolicitud, RutCli, x.nItems, x.Cantidad, x.Especificacion, x.valorUnitario, x.valorUnitarioUF, x.valorUnitarioUS)">
								    			Actualizar
								    		</a>
								    		<a 
								    			type="button" 
								    			class="btn btn-danger"
								    			ng-click="quitarItems(nSolicitud, RutCli, x.nItems, x.Cantidad, x.Especificacion, x.valorUnitario, x.valorUnitarioUF, x.valorUnitarioUS)">
								    			Quitar
								    		</a>
								    	</td>
								  	</tr>			                    	
							</tbody>
							<tfoot>
							  	<tr class="table-success text-dark">
								    <td>Nueva línea  </td>
								    <td>
								    	<input type="type" ng-model="Cantidad" class="form-control" autofocus>
								    </td>
								    <td>
								    	<textarea type="type" ng-model="Especificacion" class="form-control"></textarea>
								    </td>
								    <td>
										<input 	type="type" 
												ng-model="Unitario"
												class="form-control"> 								    
									</td>
								    <td>
								    	<div ng-if="tipoValor == 'U'">
								    		{{ valorTotalUF }}
								   		</div>
								   		<div ng-if="tipoValor == 'P'">
								   			{{ valorTotal }}
								   		</div>
								   		<div ng-if="tipoValor == 'D'">
								   			{{ valorTotalUS }}
								   		</div>
									</td>
								    <td>
								    	<a 
								    		type="button" 
								   			class="btn btn-info"
								   			ng-click="agregaLinea()">
								   			Agregar
								   		</a>
							    	</td>
							  	</tr>			                    	
								<tr class="table-info text-dark">
									<td colspan="2">Informes Asociados</td>
									<td>
										<textarea ng-model="informesAM" class="form-control"></textarea>
									</td>
									<td>NETO: </td>
									<td>
								    	<div ng-if="tipoValor == 'U'">
									    	{{netoUF}}
									    </div>
								    	<div ng-if="tipoValor == 'P'">
									    	{{Neto}}
									    </div>
								    	<div ng-if="tipoValor == 'D'">
									    	{{NetoUS}}
									    </div>
									</td>
									<td class="table-light" rowspan="3">  </td>
								</tr>
								
								<tr class="table-info text-dark">
									<td colspan="2">Cotizaciones Asociadas</td>
									<td>
										<textarea ng-model="cotizacionesCAM" class="form-control"></textarea>
									</td>
									<td>IVA: </td>
									<td>
								    	<div ng-if="tipoValor == 'U'">
									    	{{ivaUF}}
									    </div>
								    	<div ng-if="tipoValor == 'P'">
									    	{{Iva}}
									    </div>
								    	<div ng-if="tipoValor == 'D'">
									    	{{IvaUS}}
									    </div>
									</td>
								</tr>
								<tr>
									<td class="table-light text-dark" colspan="3"></td>
									<td class="table-info text-dark">TOTAL: </td>
									<td class="table-info text-dark">
								    	<div ng-if="tipoValor == 'U'">
									    	{{brutoUF}}
									    </div>
								    	<div ng-if="tipoValor == 'P'">
									    	{{Bruto}}
									    </div>
								    	<div ng-if="tipoValor == 'D'">
									    	{{BrutoUS}}
									    </div>
									</td>
								</tr>
							</tfoot>
						</table>
						<div class="card" style="margin-top: 5px;">
							<div class="card-header bg-secondary text-white">
								<h5>Observaciones Generales a la solicitud</h5></div>
								<div class="card-body">
									<textarea ng-model="Observa" rows="6" class="form-control"></textarea>
								</div>
								<div class="card-footer">
							  		<a type="button" ng-click="guardardatos()" class="btn btn-warning" name="guardardatos" style="float:right; ">Guardar Datos</a>

									<a 	class="btn btn-info" 
										role="button" 
										href="formularios/iFormulario4.php?nSolicitud={{nSolicitud}}" 
										title="Imprimir Formulario N° 4">	
										Imprimir
									</a>
									<?php
										// $disabled = "disabled";
										// $directorioDocOC="Y://AAA/Archivador/SOL-".$nSolicitud."/OC";
    									// if(file_exists($directorioDocOC)){
        								// 	$doc = 'Anexos/SOL-'.$nSolicitud.'/OC/OC-'.$nSolicitud.'.pdf';
        								// 	if(file_exists($doc)){
										// 		$disabled = "";
										// 	}
										// }
										
										// if($disabled == 'disabled'){
										// 	$directorioDocOC="Y://AAA/Archivador/SOL-".$nSolicitud."/HES";
										// 	if(file_exists($directorioDocOC)){
										// 		$doc = 'Anexos/SOL-'.$nSolicitud.'/HES/HES-'.$nSolicitud.'.pdf';
										// 		if(file_exists($doc)){
										// 			$disabled = "";
										// 		}
										// 	}
	
										// }

										// if($disabled == 'disabled'){
										// 	$directorioDocOC="Y://AAA/Archivador/SOL-".$nSolicitud."/ANE";
										// 	if(file_exists($directorioDocOC)){
										// 		$doc = 'Anexos/SOL-'.$nSolicitud.'/ANE/ANE-'.$nSolicitud.'.pdf';
										// 		if(file_exists($doc)){
										// 			$disabled = "";
										// 		}
										// 	}
										// }
									?>
									<!-- <a 	class="btn btn-primary <?php echo $disabled; ?>" -->
									<a 	class="btn btn-primary" 
										role="button" 
										href="formularios/iForms.php?nSolicitud={{nSolicitud}}" 
										title="Imprimir Formulario N° 4" >	
										Imprimir con Doc.Adjuntos
									</a>
									<a 	class="btn btn-danger" 
										role="button" 
										href="mDocumentos.php?nSolicitud={{nSolicitud}}&RutCli={{RutCli}}" 
										title="Imprimir Formulario N° 4">	
										Documentos Anexos
									</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>
