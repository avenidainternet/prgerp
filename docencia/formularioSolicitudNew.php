<?php
	if($_GET['Proceso']==4){ 
		if($_GET['nSolicitud']) { $nSolicitud   = $_GET['nSolicitud']; 	}
		if($_GET['nItems']) 	{ $nItems   	= $_GET['nItems']; 		}
					
		$link=Conectarse();
		$bdDet=mysql_query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		if($rowDet=mysql_fetch_array($bdDet)){
			$bdDet=mysql_query("DELETE FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		}
		mysql_close($link);
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
	$Email			= "";
	$Contacto		= "";
	$nSolicitud		= "";
	$nItems			= 1;
	$tipoValor		= 'U';
	$Exenta			= "";
	$fechaSolicitud	= date('Y-m-d');
	
	$Proceso = 1;
	if($_GET['Proceso']==4){ 
		$Proceso = 2;
	}else{
		if($_GET['Proceso']) 	{ $Proceso  	= $_GET['Proceso']; 	}
	}
	
	if($_GET['RutCli'])  				{ $RutCli   	= $_GET['RutCli']; 		}
	if($_GET['Contacto'])				{ $Contacto  	= $_GET['Contacto']; 	}
	if($_GET['nSolicitud']) 			{ $nSolicitud   = $_GET['nSolicitud']; 	}
	if($_GET['CAM'])  					{ $CAM   		= $_GET['CAM']; 		}

	if($_POST['Proceso']) 	 			{ $Proceso  	 	= $_POST['Proceso']; 		}
	if($_POST['RutCli'])  	 			{ $RutCli   	 	= $_POST['RutCli']; 		}
	if($_POST['Contacto'])	 			{ $Contacto  	 	= $_POST['Contacto']; 		}
	if($_POST['nSolicitud']) 			{ $nSolicitud   	= $_POST['nSolicitud']; 	}
	if($_POST['CAM'])  		 			{ $CAM   		 	= $_POST['CAM']; 			}
	if(isset($_POST['fechaSolicitud']))	{ $fechaSolicitud 	= $_POST['fechaSolicitud']; }
	echo $Contacto;

	if($RutCli){
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM Clientes WHERE RutCli = '".$RutCli."'");
		if($row=mysql_fetch_array($bdProv)){
   			$Cliente 		= $row['Cliente'];
			$Giro			= $row['Giro'];
			$Direccion		= $row['Direccion'];
   			$Telefono  		= $row['Telefono'];
   			$Celular  		= $row['Celular'];
			$Email 			= $row['Email'];
			$Sitio 			= $row['Sitio'];
			$Publicar		= $row['Publicar'];
		}
		mysql_close($link);
	}
	
	if(isset($_GET[CAM])){
		$Facturacion = 'on';
		$link=Conectarse();
		$fechaFacturacion = date('Y-m-d');
		$actSQL="UPDATE Cotizaciones SET ";
		$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
		$actSQL.="Facturacion		='".$Facturacion."'";
		$actSQL.="WHERE CAM		= '".$_GET[CAM]."'";
		$bddSol=mysql_query($actSQL);
		mysql_close($link);
		if($nSolicitud){
			$link=Conectarse();
			$bdSol=mysql_query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
			if($rowSol=mysql_fetch_array($bdSol)){
				if($rowSol[cotizacionesCAM]){
					$cotizacionesCAM = $rowSol[cotizacionesCAM].'-'.$CAM;
				}else{
					$cotizacionesCAM = $CAM;
				}
				$actSQL="UPDATE SolFactura SET ";
				$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
				$bddSol=mysql_query($actSQL);
			}
			mysql_close($link);
		}
	}	

	if(isset($_POST[GuardarFacturacion])){
		$nSolicitud = 0;		
		if(isset($_POST['nSolicitud']))	{ $nSolicitud 	= $_POST['nSolicitud']; }
		$link=Conectarse();
		if($nSolicitud == 0){
			$bdSol=mysql_query("SELECT * FROM SolFactura Order By nSolicitud Desc");
			if($rowSol=mysql_fetch_array($bdSol)){
				$nSolicitud = $rowSol['nSolicitud'] + 1;
			}
		
/*
				$bdPr=mysql_query("SELECT * FROM tablaRegForm");
				if ($row=mysql_fetch_array($bdPr)){
					$nSolicitud = $row['nSolFactura'] + 1;
				}
*/				
		}
		mysql_close($link);
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
		if(isset($_POST['Exenta']))					{ $Exenta				= $_POST['Exenta']; 				}

		if(isset($_POST['nItems']))					{ $nItems				= $_POST['nItems']; 				}
		if(isset($_POST['Cantidad']))				{ $Cantidad				= $_POST['Cantidad']; 				}
		if(isset($_POST['Especificacion']))			{ $Especificacion		= $_POST['Especificacion']; 		}
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
			if($tipoValor=='U'){
				$valorTotalUF 	= $Cantidad * $valorUnitarioUF;
			}else{
				$valorTotal 	= $Cantidad * $valorUnitario;
			}			
			$bddSol=mysql_query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
			if ($rowdSol=mysql_fetch_array($bddSol)){
				$actSQL="UPDATE detSolFact SET ";
				$actSQL.="Cantidad		 	='".$Cantidad."',";
				$actSQL.="RutCli 			='".$RutCli."',";
				$actSQL.="Especificacion 	='".$Especificacion."',";
				$actSQL.="valorUnitarioUF  	='".$valorUnitarioUF."',";
				$actSQL.="valorTotalUF     	='".$valorTotalUF."'";
				$actSQL.="valorUnitario  	='".$valorUnitario."',";
				$actSQL.="valorTotal     	='".$valorTotal."'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && nItems = '".$nItems."'";
				$bddSol=mysql_query($actSQL);
			}else{
				mysql_query("insert into detSolFact(	nSolicitud,
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
				)",$link);
			}
		}		
		$Neto   = 0;
		$netoUF = 0;
		$bddSol=mysql_query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
		if ($rowdSol=mysql_fetch_array($bddSol)){
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
			}while ($rowdSol=mysql_fetch_array($bddSol));
		}

		$bdProv=mysql_query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($row=mysql_fetch_array($bdProv)){
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="fechaSolicitud		='".$fechaSolicitud."',";
			$actSQL.="IdProyecto			='".$Proyecto."',";
			$actSQL.="Contacto				='".$Contacto."',";
			$actSQL.="vencimientoSolicitud 	='".$vencimientoSolicitud."',";
			$actSQL.="valorUF 				='".$valorUF."',";
			$actSQL.="fechaUF 				='".$fechaUF."',";
			$actSQL.="nOrden				='".$nOrden."',";
			$actSQL.="Fotocopia				='".$Fotocopia."',";
			if($Fotocopia=='on'){
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
			}else{
				$fechaFotocopia = "0000-00-00";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia."',";
			}
			$actSQL.="tipoValor				='".$tipoValor."',";
			$actSQL.="Exenta				='".$Exenta."',";
			$actSQL.="Factura				='".$Factura."',";
			$actSQL.="fechaFactura	    	='".$fechaFactura."',";
			$actSQL.="pagoFactura	    	='".$pagoFactura."',";
			$actSQL.="fechaPago				='".$fechaPago."',";
			$actSQL.="enviarFactura			='".$enviarFactura."',";
			$actSQL.="informesAM	    	='".$informesAM."',";
			$actSQL.="cotizacionesCAM		='".$cotizacionesCAM."',";
			$actSQL.="Observa				='".$Observa."',";
			$actSQL.="Redondear				='".$Redondear."',";
			$actSQL.="Neto					='".$Neto."',";
			$actSQL.="Iva	    			='".$Iva."',";
			$actSQL.="Bruto					='".$Bruto."',";
			$actSQL.="netoUF				='".$netoUF."',";
			$actSQL.="ivaUF	    			='".$ivaUF."',";
			$actSQL.="brutoUF				='".$brutoUF."'";
			$actSQL.="WHERE nSolicitud		= '".$nSolicitud."' && RutCli = '".$RutCli."'";
			$bdProv=mysql_query($actSQL);
		}else{
				$bdTab=mysql_query("SELECT * FROM tablaRegForm");
				if ($row=mysql_fetch_array($bdTab)){
					$actSQL="UPDATE tablaRegForm SET ";
					$actSQL.="nSolFactura	='".$nSolicitud."'";
					$bdTab=mysql_query($actSQL);
				}
				mysql_query("insert into SolFactura(	nSolicitud,
														RutCli,
														fechaSolicitud,
														IdProyecto,
														Contacto,
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
														enviarFactura
														) 
										values 		(	'$nSolicitud',
														'$RutCli',
														'$fechaSolicitud',
														'$Proyecto',
														'$Contacto',
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
														'$enviarFactura'
														)",$link);
   				$MsgUsr = 'Se ha registrado un nueva Solicitud de Facturación ...';
		}
		mysql_close($link);
	}
//	if($Proceso==2){
		$link=Conectarse();
		$bdSol=mysql_query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($rowSol=mysql_fetch_array($bdSol)){
   			$fechaSolicitud 		= $rowSol['fechaSolicitud'];
   			$Proyecto 				= $rowSol['IdProyecto'];
   			$Fotocopia 				= $rowSol['Fotocopia'];
   			$fechaFotocopia 		= $rowSol['fechaFotocopia'];
   			$nOrden 				= $rowSol['nOrden'];
   			$FechaOrden 			= $rowSol['FechaOrden'];
   			$Contacto				= $rowSol['Contacto'];
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
		mysql_close($link);
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
				
		document.form.valorTotal.value 	= vCan * vUni;
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
		<div id="CajaCpo">
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<span class="tituloFormulario"><strong>FORMULARIO N&deg; 4 - SOLICITUD DE FACTURA</strong></span>
						</td>
					</tr>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
					<tr>
						<td height="30" width="20%">N&deg; Solicitud: </td>
						<td width="31%" height="30">
							<?php
/*
							$link=Conectarse();
							if($nSolicitud==""){
								$bdPr=mysql_query("SELECT * FROM tablaRegForm");
								if ($row=mysql_fetch_array($bdPr)){
									$nSolicitud = $row['nSolFactura'] + 1;
								}
							}
*/
							$link=Conectarse();
							$bdDepto=mysql_query("SELECT * FROM Departamentos");
							if ($rowDepto=mysql_fetch_array($bdDepto)){
								$EmailDepto = $rowDepto['EmailDepto'];
							}
							mysql_close($link);
							?>
							<input name="nSolicitud" style="font-size:24px; " 	type="text" size="5" maxlength="5" value="<?php echo $nSolicitud; ?>" readonly>
						</td>
					    <td width="49%" align="right">
							Fecha Solicitud:<strong>
							<?php 
								$fd 	= explode('-', $fechaSolicitud);
								echo $fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0];
							?>
							</strong> 
							<input name="fechaSolicitud" type="date" size="10" maxlength="10" value="<?php echo $fechaSolicitud; ?>">
						</td>
					</tr>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<span class="tituloFormulario"><strong>DATOS DE LA EMPRESA CLIENTE</strong></span>
						</td>
					</tr>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
					<tr>
						<td  height="30" width="20%">Rut Cliente: </td>
						<td width="50%"  height="30">
							<input name="RutCli" 	type="text" size="10" maxlength="10" value="<?php echo $RutCli; ?>">								
							<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
							<select name="Cliente" id="Cliente" onChange="window.location = this.options[this.selectedIndex].value; return true;">
							<?php 
								echo "<option value='formSolicitaFacturaNew.php?RutCli=&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>Cliente</option>";
								$link=Conectarse();
								$bdPr=mysql_query("SELECT * FROM Clientes Order By Cliente");
								if ($row=mysql_fetch_array($bdPr)){
									do{
										$bdAM=mysql_query("SELECT * FROM Cotizaciones Where RutCli = '".$row[RutCli]."' and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
										if($rowAM=mysql_fetch_array($bdAM)){
											if($RutCli == $row['RutCli']){
												echo "	<option selected 	value='formSolicitaFacturaNew.php?RutCli=".$row['RutCli']."&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>".$row['Cliente']."</option>";
											}else{
												echo "	<option  			value='formSolicitaFacturaNew.php?RutCli=".$row['RutCli']."&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>".$row['Cliente']."</option>";
											}
										}
									}while ($row=mysql_fetch_array($bdPr));
								}
								mysql_close($link);
							?>
							</select>

						</td>
					    <td width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Razon Social </td>
						<td  height="30">
							<input name="Cliente" 	type="text" size="50" maxlength="50" value="<?php echo $Cliente; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Giro </td>
						<td  height="30">
							<input name="Giro" 	type="text" size="80" maxlength="100" value="<?php echo $Giro; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Atención </td>
						<td  height="30">
							<select name="Contacto" id="Contacto">
								<?php
								
//								if($ContactoSol){
									$link=Conectarse();
									$bdCC=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
									if($rowCC=mysql_fetch_array($bdCC)){
										do{
											if($rowCC[Contacto]===$Contacto){
												echo "<option selected 	value='".$rowCC[Contacto]."'>".$rowCC[Contacto]."</option>";
												$Email 			= $rowCC[Email].', '.$EmailDepto;
												$Departamento 	= $rowCC[Depto];
												$Telefono 		= $rowCC[Telefono];
												//$Contacto 	= $rowCC[Contacto];
											}else{
												echo "<option  			value='".$rowCC[Contacto]."'>".$rowCC[Contacto]."</option>";
												//$Email 			= $rowCC[Email].', '.$EmailDepto;
												//$Departamento 	= $rowCC[Depto];
												//$Contacto 	= $rowCC[Contacto];
											}
										}while ($rowCC=mysql_fetch_array($bdCC));
									}
									mysql_close($link);
//								}
								?>
							</select>
							<input name="Contactos" 	type="text" size="50" maxlength="50" value="<?php echo $Contacto; ?>"> 
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Departamento </td>
						<td  height="30">
							<input name="Departamento" 	type="text" size="50" maxlength="50" value="<?php echo $Departamento; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Dirección / Comuna </td>
						<td  height="30">
							<input name="Direccion" 	type="text" size="50" maxlength="50" value="<?php echo $Direccion; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Fono </td>
						<td  height="30">
							<input name="Telefono" 	type="text" size="30" maxlength="30" value="<?php echo $Telefono; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" width="20%">Correo Electrónico </td>
						<td  height="30">
							<input name="Email" 	type="text" size="50" maxlength="50" value="<?php echo $Email; ?>">								
						</td>
					    <td  height="30">&nbsp;</td>
					</tr>
				</table>
				<?php
					if($Cliente){?>
						<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
							<tr>
								<td>
									<span class="tituloFormulario"><strong>DATOS PARA FACTURACIÓN</strong></span>
									<button name="GuardarFacturacion" title="Guardar datos de Facturación" style="float:right; ">
										<img src="../gastos/imagenes/guardar.png" width="50" height="50">
									</button>
								</td>
							</tr>
						</table>
						<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
							<tr>
							  <td  height="40">Proyecto:					  </td>
							  <td  height="40" colspan="7">
								<select name="Proyecto" id="Proyecto">
									<?php 
										$link=Conectarse();
										$bdPr=mysql_query("SELECT * FROM Proyectos");
										if ($row=mysql_fetch_array($bdPr)){
											do{
												if($Proyecto == $row['IdProyecto']){
													echo "<option selected>".$row['IdProyecto']."</option>";
												}else{
													echo "<option>".$row['IdProyecto']."</option>";
												}
											}while ($row=mysql_fetch_array($bdPr));
										}
										mysql_close($link);
									?>
							  </select>				      </td>
						  </tr>
							<tr>
								<td  height="40">N&deg; Orden de Compra:					    </td>
								<td colspan="7"><input name="nOrden" 	type="text" id="nOrden" value="<?php echo $nOrden; ?>" size="50" maxlength="50"> 				        </td>
							</tr>
							<tr>
								<td  height="39">Vencimiento</td>
								<td>
									<?php if($nSolicitud){?>
										<input name="vencimientoSolicitud" 	type="text" size="5" maxlength="5" value="<?php echo $vencimientoSolicitud; ?>" />
									<?php }else{ ?>
										<input name="vencimientoSolicitud" 	type="text" size="5" maxlength="5" value="<?php echo $vencimientoSolicitud; ?>" autofocus />
									<?php } ?>
								Días
								</td>
								<td>Factura Exenta: </td>
								<td>
									<?php
									if($Exenta=='on'){
										echo '<input name="Exenta" type="checkbox" checked>';
									}else{
										echo '<input name="Exenta" type="checkbox">';
									}
									?>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
							  <td  height="39">Valores en:					  </td>
							  <td>
								<select name="tpValor" id="tpValor">
									<?php
										switch ($tipoValor) {
											case 'U':
												echo '<option selected 	value="U">UF</option>';
												echo '<option 			value="P">Pesos</option>';
												break;
											case 'P':
												echo '<option 			value="U">UF</option>';
												echo '<option selected  value="P">Pesos</option>';
												break;
											default:
												echo '<option selected 	value="U">UF</option>';
												echo '<option  			value="P">Pesos</option>';
												break;
										}								
										?>
								</select>
								<input name="tipoValor" type="hidden" id="tipoValor" value="<?php echo $tipoValor; ?>">
							  </td>
							  <td>UF Referencial: </td>
							  <td><input name="valorUF" 	type="text" size="10" maxlength="10" value="<?php echo $valorUF; ?>"></td>
							  <td>Fecha UF: </td>
							  <td colspan="3"><input name="fechaUF" type="date" id="fechaUF" value="<?php echo $fechaUF; ?>" size="10" maxlength="10"></td>
							</tr>
							<tr bgcolor="#999999">
							  <td  height="19" colspan="8">&nbsp;</td>
							</tr>
							<tr>
								<td  height="44">Enviar Factura:</td>
								<td width="15%"  height="44">USACH
								</td>
								<td width="14%"><?php
									if($enviarFactura==1){
										echo '<input name="enviarFactura" type="radio" value="1" checked>';
									}else{
										echo '<input name="enviarFactura" type="radio" value="1">';
									}
									?></td>
								<td width="14%">Empresa
								</td>
								<td width="14%"><?php
									if($enviarFactura==2){
										echo '<input name="enviarFactura" type="radio" value="2" checked>';
									}else{
										echo '<input name="enviarFactura" type="radio" value="2">';
									}
									?></td>
								<td width="9%">Otra</td>
								<td width="9%">
									<?php
									if($enviarFactura==3){
										echo '<input name="enviarFactura" type="radio" value="3" checked>';
									}else{
										echo '<input name="enviarFactura" type="radio" value="3">';
									}
									?>
								</td>
								<td width="4%">&nbsp;</td>
							</tr>
						</table>				
						<?php if($nSolicitud > 0){?>
							<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
								<tr>
									<td>
										<span class="tituloFormulario"><strong>DETALLE FACTURACIÓN</strong></span>
									</td>
								</tr>
							</table>


								<!-- AM Cotizaciones en Proceso de la Empresa -->
								<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
									<tr>
										<td colspan="3" height="40" style="border-bottom:1px solid #000;">
											Registro de Trabajos Terminados para Facturar (AM) <?php echo $RAM; ?>
										</td>
									</tr>
									<tr bgcolor="#CCCCCC" style=" font-size:20px; color:#000000; font-weight:700; padding:10px;">
										<td height="30" style="border-bottom:1px solid #000;">AM Para Facturar</td>
										<td style="border-bottom:1px solid #000;">Valor</td>
										<td style="border-bottom:1px solid #000;">Acción</td>
									</tr>
									<?php
										$link=Conectarse();
										//$bdPr=mysql_query("SELECT * FROM Cotizaciones Where RutCli = $RutCli and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
										$bdPr=mysql_query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
										if ($row=mysql_fetch_array($bdPr)){
											do{?>
												<tr>
													<td style="padding:10px; border-bottom:1px solid #000;"><?php echo 'RAM-'.$row[RAM].'<br>CAM-'.$row[CAM]?></td>
													<td style="border-bottom:1px solid #000;">
														<strong style="font-size:12px;">
															<?php echo 			number_format($row[BrutoUF], 2, ',', '.').' UF'; ?>
														</strong>
													</td>
													<td style="border-bottom:1px solid #000;">
														<?php if($CAM == $row[CAM]){
															$cotizacionesCAM .= $CAM;
															?>
															<a href="formSolicitaFacturaNew.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row[CAM];?>"><img src="../imagenes/delete_32.png"></a>
														<?php
														}else{?>
															<a href="formSolicitaFacturaNew.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row[CAM];?>"><img src="../imagenes/add_32.png"></a>
														<?php 
														}
														?>
													</td>
												</tr>
												<?php
											}while ($row=mysql_fetch_array($bdPr));
										}
										mysql_close($link);
									?>
								</table>
								<!-- AM Cotizaciones en Proceso de la Empresa -->
						
							<table width="100%"  border="1" cellspacing="0" cellpadding="0" id="CajaDocumentos">
								<tr class="tituloDetFact">
								  <td width="6%" height="30" align="center">ITEMS</td>
								  <td width="11%"  height="30" align="center">CANTIDAD</td>
								  <td width="35%" align="center">ESPECIFICACION</td>
								  <td align="center" width="11%">Valor Unitario</td>
								  <td align="center" width="18%">VALOR TOTAL</td>
								  <td align="center" width="17%">Acciones</td>
								</tr>
								<?php
								$nItems = 0;
								$Neto 	= 0;
								$netoUF = 0;
								$link=Conectarse();
								$bddSol=mysql_query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
								if ($rowdSol=mysql_fetch_array($bddSol)){
									do{?>
										<tr>
											<td  height="30" align="center">
												<?php 
													echo $rowdSol['nItems'];
													$nItems = $rowdSol['nItems'];
												?>
											</td>
											<td  height="30" align="center">
												<?php echo $rowdSol['Cantidad'];?>
											</td>
											<td>
												<?php echo $rowdSol['Especificacion'];?>
											</td>
											<td align="right">
												<?php 
													if($tipoValor=='U'){
														echo $rowdSol['valorUnitarioUF'];
													}else{
														echo $rowdSol['valorUnitario'];
													}
												?>
											<td align="right">
												<?php 
													if($tipoValor=='U'){
														echo $rowdSol['valorTotalUF'];
														if($Exenta=='on'){
															$netoUF 	+= $rowdSol['valorTotalUF'];
															$ivaUF		= 0;
															$brutoUF	= $netoUF;
														}else{
															$netoUF 	+= $rowdSol['valorTotalUF'];
															$ivaUF		= $netoUF * 0.19;
															$brutoUF	= $netoUF * 1.19;
														}
													}else{
														echo $rowdSol['valorTotal'];
														if($Exenta=='on'){
															$Neto 	+= $rowdSol['valorTotal'];
															$Iva	= 0;
															$Bruto	= $Neto;
														}else{
															$Neto 	+= $rowdSol['valorTotal'];
															$Iva	= intval($Neto * 0.19);
															$Bruto	= intval($Neto * 1.19);
															if($Redondear=='on'){
																$Iva	= round(($Neto * 0.19),0);
																$Bruto	= round(($Neto * 1.19),0);
															}
														}
													}
												?>
											</td>
											<td align="center">
												<?php
													echo '<a href="formSolicitaFactura.php?Proceso=4&RutCli='.$rowdSol['RutCli'].'&nSolicitud='.$rowdSol['nSolicitud'].'&nItems='.$rowdSol['nItems'].'"><img src="../gastos/imagenes/delete_32.png" width="32" height="32" title="Eliminar Items">	</a>';
												?>
											</td>
										</tr>
										<?php
									}while ($rowdSol=mysql_fetch_array($bddSol));
								}
								mysql_close($link);
								?>
								<tr>
									<td  height="30" align="center">
										<?php 
											$nItems++;
											echo $nItems;
											$Cantidad 		= "";
											$Especificacion = "";
											$valorUnitarioUF= "";
											$valorTotalUF	= "";
											$valorUnitario	= "";
											$valorTotal		= "";
										?>
										<input name="nItems" 	type="hidden" id="nItems" value="<?php echo $nItems;?>" size="3" maxlength="3">
									</td>
									<td  height="30" align="center">
										<input name="Cantidad" tabindex="1"	type="text" id="Cantidad" value="<?php echo $Cantidad;?>" size="4" maxlength="4">
									</td>
									<td>
										<textarea onchange="myFunction()" name="Especificacion" id="Especificacion" tabindex="2" cols="35" rows="2"><?php echo $Especificacion; ?></textarea>
									</td>
									<td align="right">
										<?php if($tipoValor=='U'){ ?>
											<input name="valorUnitarioUF" tabindex="3"	type="text" id="valorUnitarioUF" value="<?php echo $valorUnitarioUF;?>" size="10" maxlength="10"></td>
										<?php }else{?>
											<input name="valorUnitario" tabindex="3"	type="text" id="valorUnitario" value="<?php echo $valorUnitario;?>" size="10" maxlength="10"></td>
										<?php } ?>
									<td align="right">
										<?php if($tipoValor=='U'){?>
											<input name="valorTotalUF" tabindex="4"	type="text" id="valorTotalUF" value="<?php echo $valorTotalUF;?>" size="10" maxlength="10">
										<?php }else{?>
											<input name="valorTotal" tabindex="4"	type="text" id="valorTotal" value="<?php echo $valorTotal;?>" size="10" maxlength="10">
										<?php } ?>
									</td>
									<td width="2%" align="center">
										<?php
										//echo '<a href="registrafacturas.php?Proceso=2&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Items"></a>&nbsp;';
										//echo '<a href="registrafacturas.php?Proceso=3&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar">	</a>';
										?>
									</td>
								</tr>
								<tr>
								  <td  height="30" colspan="2" align="right">Informe(s) AM </td>
								  <td><input name="informesAM" 	type="text" id="informesAM" value="<?php echo $informesAM; ?>" size="45" maxlength="45"></td>
								  <td align="right">MONTO NETO </td>
								  <td align="right">
										Redondear
										<?php
											if($Redondear=='on'){
												echo '<input name="Redondear" type="checkbox" checked title="Redondeado" id="Redondear">';
											}else{
												echo '<input name="Redondear" type="checkbox" title="Sin Redondear" id="Redondear">';
											}
										?>
										<?php if($tipoValor=='U'){?>
											<input name="netoUF" 	tabindex="5" 	type="text" id="netoUF" value="<?php echo $netoUF; ?>" size="10" maxlength="10">
										<?php }else{ ?>
											<input name="Neto" 		tabindex="5"	type="text" id="Neto" value="<?php echo $Neto; ?>" size="10" maxlength="10">
										<?php } ?>
								  </td>
									<td width="17%" rowspan="3" align="center">
										<div id="ImagenBarra" style="float:none; display:inline;">
											<a href="formularios/iFormulario4.php?nSolicitud=<?php echo $nSolicitud;?>" title="Imprimir Formulario N° 4">
												<img src="../gastos/imagenes/printer_128_hot.png">
											</a>
										</div>
									</td>
								</tr>
								<tr>
									<td  height="30" colspan="2" align="right">Cotizacion(es) CAM </td>
									<td><input name="cotizacionesCAM" 	type="text" id="cotizacionesCAM" value="<?php echo $cotizacionesCAM; ?>" size="45" maxlength="45"></td>
									<td align="right">IVA</td>
									<td align="right">
										<?php if($tipoValor=='U'){?>
											<input name="ivaUF" tabindex="6" 	type="text" id="ivaUF" value="<?php echo $ivaUF; ?>" size="10" maxlength="10">
										<?php }else{ ?>
											<input name="Iva" 	tabindex="6"	type="text" id="Iva" value="<?php echo $Iva; ?>" size="10" maxlength="10">
										<?php } ?>
									</td>
								</tr>
								<tr>
								  <td  height="30" colspan="3" valign="top">
								  <br>
								  </td>
								  <td width="11%" align="right">TOTAL</td>
									<td width="18%" align="right">
										<?php if($tipoValor=='U'){?>
											<input name="brutoUF" 	tabindex="7"	type="text" id="brutoUF" value="<?php echo $brutoUF; ?>" size="10" maxlength="10">
										<?php }else{ ?>
											<input name="Bruto" 	tabindex="7"	type="text" id="Bruto" value="<?php echo $Bruto; ?>" size="10" maxlength="10">
										<?php } ?>
								  </td>
								</tr>
								<tr>
									<td height="30" colspan="6">
										Observaciones:<br>
										<!-- <textarea onchange="myFunction()" name="Observa" id="Observa" cols="110" rows="5"><?php echo $Observa; ?></textarea> -->
										<textarea name="Observa" id="Observa" cols="110" rows="5"><?php echo $Observa; ?></textarea>
									</td>
								</tr>
							</table>
							<?php 
						}
					}
					?>
			</div>
		</div>
		</form>
