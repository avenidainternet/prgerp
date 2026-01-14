<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="Despues de registrar e ingresar todos los datos de la Boleta se podrá IMPRIMIR CONTRATO...";	
	include("conexion.php");
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

	/* Variables Gets*/	
	$Periodo 	= $_GET['Periodo'];
	$Proyecto 	= $_GET['Proyecto'];
	$nLinea		= 1;

	$link=Conectarse();
	$bdPer=mysql_query("SELECT * FROM PersonalHonorarios");
	if($rowPer=mysql_fetch_array($bdPer)){
		DO{
			if($rowPer['PeriodoPago']=="M"){
				$bdHon=mysql_query("SELECT * FROM Honorarios WHERE Run = '".$rowPer['Run']."' && PeriodoPago = '".$Periodo."'");
				if ($rowHon=mysql_fetch_array($bdHon)){
			
				}else{
					$Run			= $rowPer['Run'];
					$nBoleta		= $rowPer['UltimaBoleta'] + 1;
					$LugarTrabajo	= $rowPer['LugarTrabajo'];
					$FuncionCargo	= $rowPer['FuncionCargo'];
					$Descripcion	= $rowPer['FuncionCargo'];
					$TpCosto		= "M";
					$Liquido		= $rowPer['SueldoBase'];
					if($rowPer['IdProyecto']){
						$Proyecto	= $rowPer['IdProyecto'];
					}
					$fd 	= explode('-', date('Y-m-d'));
					$PerIniServ = $fd[0].'-'.$fd[1].'-01';
					if(intval($fd[1])==1 || intval($fd[1])==3 || intval($fd[1])==5 || intval($fd[1])==7 || intval($fd[1])==8 || intval($fd[1])==10 || intval($fd[1])==12){
						$f = '31';
					}											
					if(intval($fd[1])==4 || intval($fd[1])==6 || intval($fd[1])==9 || intval($fd[1])==11){
						$f = '30';
					}
					if(intval($fd[1])==2){
						$f = '28';
						$d = intval($fd[0]);
						if( (intval($d/4)*4) == $d ){
							$f = '29';
						}
					}
					$PerTerServ = $fd[0].'-'.$fd[1].'-'.$f;
					$Total		= round(($Liquido/0.9),0);
					$Retencion 	= round(($Total * 0.1),0);
					mysql_query("insert into Honorarios(
														Run,
														PeriodoPago,
														nBoleta,
														nLinea,
														IdProyecto,
														PerIniServ,
														PerTerServ,
														LugarTrabajo,
														FuncionCargo,
														Descripcion,
														Total,
														Retencion,
														Liquido,
														TpCosto
														) 
										values 		(	
														'$Run',
														'$Periodo',
														'$nBoleta',
														'$nLinea',
														'$Proyecto',
														'$PerIniServ',
														'$PerTerServ',
														'$LugarTrabajo',
														'$FuncionCargo',
														'$Descripcion',
														'$Total',
														'$Retencion',
														'$Liquido',
														'$TpCosto'
														)",$link);
				}
			}
		}WHILE ($rowPer=mysql_fetch_array($bdPer));
	}
	mysql_close($link);
	
	/* Actualiza Boletas Honoraris en Personal Honorarios*/
	$link=Conectarse();
	$bdHon=mysql_query("SELECT * FROM Honorarios WHERE TpCosto = 'M' && PeriodoPago = '".$Periodo."'");
	if ($rowHon=mysql_fetch_array($bdHon)){
		DO{
			$bdPer=mysql_query("SELECT * FROM PersonalHonorarios Where Run = '".$rowHon['Run']."'");
			if($rowPer=mysql_fetch_array($bdPer)){
				$actSQL="UPDATE PersonalHonorarios SET ";
				$actSQL.="UltimaBoleta	='".$rowHon['nBoleta']."'";
				$actSQL.="WHERE Run		= '".$rowHon['Run']."'";
				$bdPer=mysql_query($actSQL);
				
			}
		}WHILE ($rowHon=mysql_fetch_array($bdHon));
	}
	mysql_close($link);

	header("Location: CalculoHonorarios.php");
	
?>
