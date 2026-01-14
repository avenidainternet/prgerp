<?php
	session_start(); 
	
	include_once("../../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
	$codigo 						= 0;
	$accion 						= '';
	$fechaVerificacion 				= '0000-00-00';
	$nFormVD						= 0;
	$MaterialSec					= "";
	
	$MaterialRef_SRB20				= "";
	$nFormCal_20					= '';
	$nFormCal_36					= '';
	$nFormCal_51					= '';
	$DurezaMaterial_SRB20			= '';
	$IncertidumbreMaterial_SRB20 	= '';

	$MaterialRef_SRM36				= "";
	$DurezaMaterial_SRM36			= '';
	$IncertidumbreMaterial_SRM36 	= '';

	$MaterialRef_SRA51				= "";
	$DurezaMaterial_SRA51			= '';
	$IncertidumbreMaterial_SRA51 	= '';

	$MaterialRef_SRA56				= "";
	$DurezaMaterial_SRA56			= '';
	$IncertidumbreMaterial_SRA51 	= '';

	$DurezaMaterial_PRB20			= '';
	$ErrorMaterial_PRB20 			= '';
	
	$DurezaMaterial_PRM36			= '';
	$ErrorMaterial_PRM36 			= '';

	$DurezaMaterial_PRA51			= '';
	$ErrorMaterial_PRA51 			= '';

	$nFormCalInsert					= '';
	$MaterialPri					= "";
	
	$Indentacion1_BD120				= '';
	$Indentacion2_BD120				= '';
	$Indentacion3_BD120				= '';
	$Error1_BD120					= '';
	$Repetitividad1_BD120			= '';

	$Indentacion1_BD220				= '';
	$Indentacion2_BD220				= '';
	$Indentacion3_BD220				= '';
	$Error1_BD220					= '';
	$Repetitividad1_BD220			= '';

	$Indentacion1_BD320				= '';
	$Indentacion2_BD320				= '';
	$Indentacion3_BD320				= '';
	$Error1_BD320					= '';
	$Repetitividad1_BD320			= '';

	$Indentacion1_MD136				= '';
	$Indentacion2_MD136				= '';
	$Indentacion3_MD136				= '';
	$Error1_MD136					= '';
	$Repetitividad1_MD136			= '';

	$Indentacion1_MD236				= '';
	$Indentacion2_MD236				= '';
	$Indentacion3_MD236				= '';
	$Error1_MD236					= '';
	$Repetitividad1_MD236			= '';

	$Indentacion1_MD336				= '';
	$Indentacion2_MD336				= '';
	$Indentacion3_MD336				= '';
	$Error1_MD336					= '';
	$Repetitividad1_MD336			= '';
	
	$Indentacion1_AD151				= '';
	$Indentacion2_AD151				= '';
	$Indentacion3_AD151				= '';
	$Error1_AD151					= '';
	$Repetitividad1_AD151			= '';

	$Indentacion1_AD251				= '';
	$Indentacion2_AD251				= '';
	$Indentacion3_AD251				= '';
	$Error1_AD251					= '';
	$Repetitividad1_AD251			= '';

	$Indentacion1_AD351				= '';
	$Indentacion2_AD351				= '';
	$Indentacion3_AD351				= '';
	$Error1_AD351					= '';
	$Repetitividad1_AD351			= '';
	
	$Observaciones					= '';
	$Cumple							= '';
	
	
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 		= $_SESSION['usuario'];
	
	if(isset($_GET['codigo']))				{ $codigo				= $_GET['codigo']; 				}
	if(isset($_GET['accion']))				{ $accion				= $_GET['accion']; 				}
	if(isset($_GET['fechaVerificacion']))	{ $fechaVerificacion	= $_GET['fechaVerificacion']; 	}

	if(isset($_POST['codigo']))				{ $codigo				= $_POST['codigo']; 			}
	if(isset($_POST['accion']))				{ $accion				= $_POST['accion']; 			}
	if(isset($_POST['fechaVerificacion']))	{ $fechaVerificacion	= $_POST['fechaVerificacion']; 	}
	if(isset($_POST['nFormVD']))			{ $nFormVD				= $_POST['nFormVD']; 			}

	$nomEquipo 	= '';
	$SQL = "Select * From equipos Where codigo = '$codigo'";
	$link=Conectarse();
	$bdEq=$link->query($SQL);
	if($rowEq=mysqli_fetch_array($bdEq)){
		//$nSerie = $rowdCot['nSerie'];
		$nomEquipo 		= $rowEq['nomEquipo'];
		$usrResponsable = $rowEq['usrResponsable'];
	}

	if(isset($_POST['GuardarVerificacion'])){
		if(isset($_POST['Observaciones']))				{ $Observaciones				= $_POST['Observaciones'];					}
		if(isset($_POST['Cumple']))						{ $Cumple						= $_POST['Cumple'];							}
		
		if(isset($_POST['MaterialRef_SRB20']))			{ $MaterialRef_SRB20			= $_POST['MaterialRef_SRB20'];				}
		if(isset($_POST['DurezaMaterial_SRB20']))		{ $DurezaMaterial_SRB20			= $_POST['DurezaMaterial_SRB20'];			}
		if(isset($_POST['IncertidumbreMaterial_SRB20'])){ $IncertidumbreMaterial_SRB20	= $_POST['IncertidumbreMaterial_SRB20'];	}
		if(isset($_POST['MaterialRef_SRM36']))			{ $MaterialRef_SRM36			= $_POST['MaterialRef_SRM36'];				}
		if(isset($_POST['DurezaMaterial_SRM36']))		{ $DurezaMaterial_SRM36			= $_POST['DurezaMaterial_SRM36'];			}
		if(isset($_POST['IncertidumbreMaterial_SRM36'])){ $IncertidumbreMaterial_SRM36	= $_POST['IncertidumbreMaterial_SRM36'];	}
		if(isset($_POST['MaterialRef_SRA51']))			{ $MaterialRef_SRA51			= $_POST['MaterialRef_SRA51'];				}
		if(isset($_POST['DurezaMaterial_SRA51']))		{ $DurezaMaterial_SRA51			= $_POST['DurezaMaterial_SRA51'];			}
		if(isset($_POST['IncertidumbreMaterial_SRA51'])){ $IncertidumbreMaterial_SRA51	= $_POST['IncertidumbreMaterial_SRA51'];	}
		if(isset($_POST['DurezaMaterial_PRB20']))		{ $DurezaMaterial_PRB20			= $_POST['DurezaMaterial_PRB20'];			}
		if(isset($_POST['ErrorMaterial_PRB20']))		{ $ErrorMaterial_PRB20			= $_POST['ErrorMaterial_PRB20'];			}
		if(isset($_POST['DurezaMaterial_PRM36']))		{ $DurezaMaterial_PRM36			= $_POST['DurezaMaterial_PRM36'];			}
		if(isset($_POST['ErrorMaterial_PRM36']))		{ $ErrorMaterial_PRM36			= $_POST['ErrorMaterial_PRM36'];			}
		
		if(isset($_POST['DurezaMaterial_PRA51']))		{ $DurezaMaterial_PRA51			= $_POST['DurezaMaterial_PRA51'];			}
		if(isset($_POST['ErrorMaterial_PRA51']))		{ $ErrorMaterial_PRA51			= $_POST['ErrorMaterial_PRA51'];			}
		if(isset($_POST['Indentacion1_BD120']))			{ $Indentacion1_BD120			= $_POST['Indentacion1_BD120'];				}
		if(isset($_POST['Error1_BD120']))				{ $Error1_BD120					= $_POST['Error1_BD120'];					}
		if(isset($_POST['Indentacion2_BD120']))			{ $Indentacion2_BD120			= $_POST['Indentacion2_BD120'];				}
		if(isset($_POST['Repetitividad1_BD120']))		{ $Repetitividad1_BD120			= $_POST['Repetitividad1_BD120'];			}
		if(isset($_POST['Indentacion3_BD120']))			{ $Indentacion3_BD120			= $_POST['Indentacion3_BD120'];				}
		if(isset($_POST['Indentacion1_BD220']))			{ $Indentacion1_BD220			= $_POST['Indentacion1_BD220'];				}
		if(isset($_POST['Error1_BD220']))				{ $Error1_BD220					= $_POST['Error1_BD220'];					}
		if(isset($_POST['Indentacion2_BD220']))			{ $Indentacion2_BD220			= $_POST['Indentacion2_BD220'];				}
		if(isset($_POST['Repetitividad1_BD220']))		{ $Repetitividad1_BD220			= $_POST['Repetitividad1_BD220'];			}
		if(isset($_POST['Indentacion3_BD220']))			{ $Indentacion3_BD220			= $_POST['Indentacion3_BD220'];				}
		if(isset($_POST['Indentacion1_BD320']))			{ $Indentacion1_BD320			= $_POST['Indentacion1_BD320'];				}
		if(isset($_POST['Error1_BD320']))				{ $Error1_BD320					= $_POST['Error1_BD320'];					}
		if(isset($_POST['Indentacion2_BD320']))			{ $Indentacion2_BD320			= $_POST['Indentacion2_BD320'];				}
		if(isset($_POST['Repetitividad1_BD320']))		{ $Repetitividad1_BD320			= $_POST['Repetitividad1_BD320'];			}
		if(isset($_POST['Indentacion3_BD320']))			{ $Indentacion3_BD320			= $_POST['Indentacion3_BD320'];				}
		if(isset($_POST['Indentacion1_MD136']))			{ $Indentacion1_MD136			= $_POST['Indentacion1_MD136'];				}
		if(isset($_POST['Error1_MD136']))				{ $Error1_MD136					= $_POST['Error1_MD136'];					}
		if(isset($_POST['Indentacion2_MD136']))			{ $Indentacion2_MD136			= $_POST['Indentacion2_MD136'];				}
		if(isset($_POST['Repetitividad1_MD136']))		{ $Repetitividad1_MD136			= $_POST['Repetitividad1_MD136'];			}
		if(isset($_POST['Indentacion3_MD136']))			{ $Indentacion3_MD136			= $_POST['Indentacion3_MD136'];				}
		if(isset($_POST['Indentacion1_MD236']))			{ $Indentacion1_MD236			= $_POST['Indentacion1_MD236'];				}
		if(isset($_POST['Error1_MD236']))				{ $Error1_MD236					= $_POST['Error1_MD236'];					}
		if(isset($_POST['Indentacion2_MD236']))			{ $Indentacion2_MD236			= $_POST['Indentacion2_MD236'];				}
		if(isset($_POST['Repetitividad1_MD236']))		{ $Repetitividad1_MD236			= $_POST['Repetitividad1_MD236'];			}
		if(isset($_POST['Indentacion3_MD236']))			{ $Indentacion3_MD236			= $_POST['Indentacion3_MD236'];				}
		if(isset($_POST['Indentacion1_MD336']))			{ $Indentacion1_MD336			= $_POST['Indentacion1_MD336'];				}
		if(isset($_POST['Error1_MD336']))				{ $Error1_MD336					= $_POST['Error1_MD336'];					}
		if(isset($_POST['Indentacion2_MD336']))			{ $Indentacion2_MD336			= $_POST['Indentacion2_MD336'];				}
		if(isset($_POST['Repetitividad1_MD336']))		{ $Repetitividad1_MD336			= $_POST['Repetitividad1_MD336'];			}
		if(isset($_POST['Indentacion3_MD336']))			{ $Indentacion3_MD336			= $_POST['Indentacion3_MD336'];				}
		if(isset($_POST['Indentacion1_AD151']))			{ $Indentacion1_AD151			= $_POST['Indentacion1_AD151'];				}
		if(isset($_POST['Error1_AD151']))				{ $Error1_AD151					= $_POST['Error1_AD151'];					}
		if(isset($_POST['Indentacion2_AD151']))			{ $Indentacion2_AD151			= $_POST['Indentacion2_AD151'];				}
		if(isset($_POST['Repetitividad1_AD151']))		{ $Repetitividad1_AD151			= $_POST['Repetitividad1_AD151'];			}
		if(isset($_POST['Indentacion3_AD151']))			{ $Indentacion3_AD151			= $_POST['Indentacion3_AD151'];				}
		if(isset($_POST['Indentacion1_AD251']))			{ $Indentacion1_AD251			= $_POST['Indentacion1_AD251'];				}
		if(isset($_POST['Error1_AD251']))				{ $Error1_AD251					= $_POST['Error1_AD251'];					}
		if(isset($_POST['Indentacion2_AD251']))			{ $Indentacion2_AD251			= $_POST['Indentacion2_AD251'];				}
		if(isset($_POST['Repetitividad1_AD251']))		{ $Repetitividad1_AD251			= $_POST['Repetitividad1_AD251'];			}
		if(isset($_POST['Indentacion3_AD251']))			{ $Indentacion3_AD251			= $_POST['Indentacion3_AD251'];				}
		if(isset($_POST['Indentacion1_AD351']))			{ $Indentacion1_AD351			= $_POST['Indentacion1_AD351'];				}
		if(isset($_POST['Error1_AD351']))				{ $Error1_AD351					= $_POST['Error1_AD351'];					}
		if(isset($_POST['Indentacion2_AD351']))			{ $Indentacion2_AD351			= $_POST['Indentacion2_AD351'];				}
		if(isset($_POST['Repetitividad1_AD351']))		{ $Repetitividad1_AD351			= $_POST['Repetitividad1_AD351'];			}
		if(isset($_POST['Indentacion3_AD351']))			{ $Indentacion3_AD351			= $_POST['Indentacion3_AD351'];				}
		if(isset($_POST['Observaciones']))				{ $Observaciones				= $_POST['Observaciones'];					}
		if(isset($_POST['Cumple']))						{ $Cumple						= $_POST['Cumple'];							}
		
		$actSQL="UPDATE equipovd SET ";
		$actSQL.="fechaVerificacion	='".$fechaVerificacion.	"',";
		$actSQL.="Observaciones		='".$Observaciones.		"',";
		$actSQL.="Cumple			='".$Cumple.			"'";
		$actSQL.="WHERE 	nFormVD	= '".$nFormVD."'";
		$bdCot=$link->query($actSQL);
		
		$SQL = "Select * From equipos Where codigo = '$codigo'";
		$bdEq=$link->query($SQL);
		if($rowEq=mysqli_fetch_array($bdEq)){
			$actSQL="UPDATE equipos SET ";
			$actSQL.="fechaProxVer	='".$fechaVerificacion.	"'";
			$actSQL.="WHERE codigo	= '".$codigo."'";
			$bdCot=$link->query($actSQL);
		}
		$SQL = "Select * From equipovdres Where nFormVD = '$nFormVD'";
		$bdEv=$link->query($SQL);
		if($rowEv=mysqli_fetch_array($bdEv)){
			$actSQL="UPDATE equipovdres SET ";
			$actSQL.="MaterialRef_SRB20				='".$MaterialRef_SRB20.				"',";
			$actSQL.="DurezaMaterial_SRB20			='".$DurezaMaterial_SRB20.			"',";
			$actSQL.="IncertidumbreMaterial_SRB20	='".$IncertidumbreMaterial_SRB20.	"',";
			$actSQL.="MaterialRef_SRM36				='".$MaterialRef_SRM36.				"',";
			$actSQL.="DurezaMaterial_SRM36			='".$DurezaMaterial_SRM36.			"',";
			$actSQL.="IncertidumbreMaterial_SRM36	='".$IncertidumbreMaterial_SRM36.	"',";
			$actSQL.="MaterialRef_SRA51				='".$MaterialRef_SRA51.				"',";
			$actSQL.="DurezaMaterial_SRA51			='".$DurezaMaterial_SRA51.			"',";
			$actSQL.="IncertidumbreMaterial_SRA51	='".$IncertidumbreMaterial_SRA51.	"',";
			$actSQL.="DurezaMaterial_PRB20			='".$DurezaMaterial_PRB20.			"',";
			$actSQL.="ErrorMaterial_PRB20			='".$ErrorMaterial_PRB20.			"',";
			$actSQL.="DurezaMaterial_PRM36			='".$DurezaMaterial_PRM36.			"',";
			$actSQL.="ErrorMaterial_PRM36			='".$ErrorMaterial_PRM36.			"',";
			$actSQL.="DurezaMaterial_PRA51			='".$DurezaMaterial_PRA51.			"',";
			$actSQL.="ErrorMaterial_PRA51			='".$ErrorMaterial_PRA51.			"',";
			$actSQL.="Indentacion1_BD120			='".$Indentacion1_BD120.			"',";
			$actSQL.="Error1_BD120					='".$Error1_BD120.					"',";
			$actSQL.="Indentacion2_BD120			='".$Indentacion2_BD120.			"',";
			$actSQL.="Repetitividad1_BD120			='".$Repetitividad1_BD120.			"',";
			$actSQL.="Indentacion3_BD120			='".$Indentacion3_BD120.			"',";
			$actSQL.="Indentacion1_BD220			='".$Indentacion1_BD220.			"',";
			$actSQL.="Error1_BD220					='".$Error1_BD220.					"',";
			$actSQL.="Indentacion2_BD220			='".$Indentacion2_BD220.			"',";
			$actSQL.="Repetitividad1_BD220			='".$Repetitividad1_BD220.			"',";
			$actSQL.="Indentacion3_BD220			='".$Indentacion3_BD220.			"',";
			$actSQL.="Indentacion1_BD320			='".$Indentacion1_BD320.			"',";
			$actSQL.="Error1_BD320					='".$Error1_BD320.					"',";
			$actSQL.="Indentacion2_BD320			='".$Indentacion2_BD320.			"',";
			$actSQL.="Repetitividad1_BD320			='".$Repetitividad1_BD320.			"',";
			$actSQL.="Indentacion3_BD320			='".$Indentacion3_BD320.			"',";
			$actSQL.="Indentacion1_MD136			='".$Indentacion1_MD136.			"',";
			$actSQL.="Error1_MD136					='".$Error1_MD136.					"',";
			$actSQL.="Indentacion2_MD136			='".$Indentacion2_MD136.			"',";
			$actSQL.="Repetitividad1_MD136			='".$Repetitividad1_MD136.			"',";
			$actSQL.="Indentacion3_MD136			='".$Indentacion3_MD136.			"',";
			$actSQL.="Indentacion1_MD236			='".$Indentacion1_MD236.			"',";
			$actSQL.="Error1_MD236					='".$Error1_MD236.					"',";
			$actSQL.="Indentacion2_MD236			='".$Indentacion2_MD236.			"',";
			$actSQL.="Repetitividad1_MD236			='".$Repetitividad1_MD236.			"',";
			$actSQL.="Indentacion3_MD236			='".$Indentacion3_MD236.			"',";
			$actSQL.="Indentacion1_MD336			='".$Indentacion1_MD336.			"',";
			$actSQL.="Error1_MD336					='".$Error1_MD336.					"',";
			$actSQL.="Indentacion2_MD336			='".$Indentacion2_MD336.			"',";
			$actSQL.="Repetitividad1_MD336			='".$Repetitividad1_MD336.			"',";
			$actSQL.="Indentacion3_MD336			='".$Indentacion3_MD336.			"',";
			$actSQL.="Indentacion1_AD151			='".$Indentacion1_AD151.			"',";
			$actSQL.="Error1_AD151					='".$Error1_AD151.					"',";
			$actSQL.="Indentacion2_AD151			='".$Indentacion2_AD151.			"',";
			$actSQL.="Repetitividad1_AD151			='".$Repetitividad1_AD151.			"',";
			$actSQL.="Indentacion3_AD151			='".$Indentacion3_AD151.			"',";
			$actSQL.="Indentacion1_AD251			='".$Indentacion1_AD251.			"',";
			$actSQL.="Error1_AD251					='".$Error1_AD251.					"',";
			$actSQL.="Indentacion2_AD251			='".$Indentacion2_AD251.			"',";
			$actSQL.="Repetitividad1_AD251			='".$Repetitividad1_AD251.			"',";
			$actSQL.="Indentacion3_AD251			='".$Indentacion3_AD251.			"',";
			$actSQL.="Indentacion1_AD351			='".$Indentacion1_AD351.			"',";
			$actSQL.="Error1_AD351					='".$Error1_AD351.					"',";
			$actSQL.="Indentacion2_AD351			='".$Indentacion2_AD351.			"',";
			$actSQL.="Repetitividad1_AD351			='".$Repetitividad1_AD351.			"',";
			$actSQL.="Indentacion3_AD351			='".$Indentacion3_AD351.			"'";
			$actSQL.="WHERE nFormVD	= '$nFormVD'";
			$bdCot=$link->query($actSQL);

		}else{
			$link->query("insert into equipovdres(	
											codigo,
											nFormVD,
											MaterialRef_SRB20,
											DurezaMaterial_SRB20,
											IncertidumbreMaterial_SRB20,
											MaterialRef_SRM36,
											DurezaMaterial_SRM36,
											IncertidumbreMaterial_SRM36,
											MaterialRef_SRA51,
											DurezaMaterial_SRA51,
											IncertidumbreMaterial_SRA51,
											DurezaMaterial_PRB20,
											ErrorMaterial_PRB20,
											DurezaMaterial_PRM36,
											ErrorMaterial_PRM36,
											DurezaMaterial_PRA51,
											ErrorMaterial_PRA51,
											Indentacion1_BD120,
											Error1_BD120,
											Indentacion2_BD120,
											Repetitividad1_BD120,
											Indentacion3_BD120,
											Indentacion1_BD220,
											Error1_BD220,
											Indentacion2_BD220,
											Repetitividad1_BD220,
											Indentacion3_BD220,
											Indentacion1_BD320,
											Error1_BD320,
											Indentacion2_BD320,
											Repetitividad1_BD320,
											Indentacion3_BD320,
											Indentacion1_MD136,
											Error1_MD136,
											Indentacion2_MD136,
											Repetitividad1_MD136,
											Indentacion3_MD136,
											Indentacion1_MD236,
											Error1_MD236,
											Indentacion2_MD236,
											Repetitividad1_MD236,
											Indentacion3_MD236,
											Indentacion1_MD336,
											Error1_MD336,
											Indentacion2_MD336,
											Repetitividad1_MD336,
											Indentacion3_MD336,
											Indentacion1_AD151,
											Error1_AD151,
											Indentacion2_AD151,
											Repetitividad1_AD151,
											Indentacion3_AD151,
											Indentacion1_AD251,
											Error1_AD251,
											Indentacion2_AD251,
											Repetitividad1_AD251,
											Indentacion3_AD251,
											Indentacion1_AD351,
											Error1_AD351,
											Indentacion2_AD351,
											Repetitividad1_AD351,
											Indentacion3_AD351
											) 
									values 	(	
											'$codigo',
											'$nFormVD',
											'$MaterialRef_SRB20',
											'$DurezaMaterial_SRB20',
											'$IncertidumbreMaterial_SRB20',
											'$MaterialRef_SRM36',
											'$DurezaMaterial_SRM36',
											'$IncertidumbreMaterial_SRM36',
											'$MaterialRef_SRA51',
											'$DurezaMaterial_SRA51',
											'$IncertidumbreMaterial_SRA51',
											'$DurezaMaterial_PRB20',
											'$ErrorMaterial_PRB20',
											'$DurezaMaterial_PRM36',
											'$ErrorMaterial_PRM36',
											'$DurezaMaterial_PRA51',
											'$ErrorMaterial_PRA51',
											'$Indentacion1_BD120',
											'$Error1_BD120',
											'$Indentacion2_BD120',
											'$Repetitividad1_BD120',
											'$Indentacion3_BD120',
											'$Indentacion1_BD220',
											'$Error1_BD220',
											'$Indentacion2_BD220',
											'$Repetitividad1_BD220',
											'$Indentacion3_BD220',
											'$Indentacion1_BD320',
											'$Error1_BD320',
											'$Indentacion2_BD320',
											'$Repetitividad1_BD320',
											'$Indentacion3_BD320',
											'$Indentacion1_MD136',
											'$Error1_MD136',
											'$Indentacion2_MD136',
											'$Repetitividad1_MD136',
											'$Indentacion3_MD136',
											'$Indentacion1_MD236',
											'$Error1_MD236',
											'$Indentacion2_MD236',
											'$Repetitividad1_MD236',
											'$Indentacion3_MD236',
											'$Indentacion1_MD336',
											'$Error1_MD336',
											'$Indentacion2_MD336',
											'$Repetitividad1_MD336',
											'$Indentacion3_MD336',
											'$Indentacion1_AD151',
											'$Error1_AD151',
											'$Indentacion2_AD151',
											'$Repetitividad1_AD151',
											'$Indentacion3_AD151',
											'$Indentacion1_AD251',
											'$Error1_AD251',
											'$Indentacion2_AD251',
											'$Repetitividad1_AD251',
											'$Indentacion3_AD251',
											'$Indentacion1_AD351',
											'$Error1_AD351',
											'$Indentacion2_AD351',
											'$Repetitividad1_AD351',
											'$Indentacion3_AD351'
						)");
		}
	}

	$SQL = "Select * From equipovd Where codigo = '$codigo' and fechaVerificacion = '$fechaVerificacion'";
	$bdEqV=$link->query($SQL);
	if(!$rowEqV=mysqli_fetch_array($bdEqV)){
		$nFormVD = 1;
		$SQL = "Select * From equipovd Where codigo = '$codigo' Order By fechaVerificacion Desc";
		$bdEqV=$link->query($SQL);
		if($rowEqV=mysqli_fetch_array($bdEqV)){
			$nFormVD = $rowEqV['nFormVD'];
			$nFormVD++;
		}
		$link->query("insert into equipovd(	
											codigo,
											nFormVD,
											fechaVerificacion,
											usrResponsable
											) 
									values 	(	
											'$codigo',
											'$nFormVD',
											'$fechaVerificacion',
											'$usrResponsable'
						)");
	}else{
		$nFormVD 			= $rowEqV['nFormVD'];
		$fechaVerificacion 	= $rowEqV['fechaVerificacion'];
		$Observaciones 		= $rowEqV['Observaciones'];
		$Cumple 			= $rowEqV['Cumple'];
	}
	$SQL = "Select * From equipovdres Where nFormVD = '$nFormVD'";
	$bdEv=$link->query($SQL);
	if($rowEv=mysqli_fetch_array($bdEv)){
		$MaterialRef_SRB20 				= $rowEv['MaterialRef_SRB20'];
		$DurezaMaterial_SRB20 			= $rowEv['DurezaMaterial_SRB20'];
		$IncertidumbreMaterial_SRB20	= $rowEv['IncertidumbreMaterial_SRB20'];
		$MaterialRef_SRM36				= $rowEv['MaterialRef_SRM36'];
		$DurezaMaterial_SRM36			= $rowEv['DurezaMaterial_SRM36'];
		$IncertidumbreMaterial_SRM36	= $rowEv['IncertidumbreMaterial_SRM36'];
		$MaterialRef_SRA51				= $rowEv['MaterialRef_SRA51'];
		$DurezaMaterial_SRA51			= $rowEv['DurezaMaterial_SRA51'];
		$IncertidumbreMaterial_SRA51	= $rowEv['IncertidumbreMaterial_SRA51'];
		$DurezaMaterial_PRB20			= $rowEv['DurezaMaterial_PRB20'];
		$ErrorMaterial_PRB20			= $rowEv['ErrorMaterial_PRB20'];
		$DurezaMaterial_PRM36			= $rowEv['DurezaMaterial_PRM36'];
		$ErrorMaterial_PRM36			= $rowEv['ErrorMaterial_PRM36'];
		$DurezaMaterial_PRA51			= $rowEv['DurezaMaterial_PRA51'];
		$ErrorMaterial_PRA51			= $rowEv['ErrorMaterial_PRA51'];
		$Indentacion1_BD120				= $rowEv['Indentacion1_BD120'];
		$Error1_BD120					= $rowEv['Error1_BD120'];
		$Indentacion2_BD120				= $rowEv['Indentacion2_BD120'];
		$Repetitividad1_BD120			= $rowEv['Repetitividad1_BD120'];
		$Indentacion3_BD120				= $rowEv['Indentacion3_BD120'];
		$Indentacion1_BD220				= $rowEv['Indentacion1_BD220'];
		$Error1_BD220					= $rowEv['Error1_BD220'];
		$Indentacion2_BD220				= $rowEv['Indentacion2_BD220'];
		$Repetitividad1_BD220			= $rowEv['Repetitividad1_BD220'];
		$Indentacion3_BD220				= $rowEv['Indentacion3_BD220'];
		$Indentacion1_BD320				= $rowEv['Indentacion1_BD320'];
		$Error1_BD320					= $rowEv['Error1_BD320'];
		$Indentacion2_BD320				= $rowEv['Indentacion2_BD320'];
		$Repetitividad1_BD320			= $rowEv['Repetitividad1_BD320'];
		$Indentacion3_BD320				= $rowEv['Indentacion3_BD320'];
		$Indentacion1_MD136				= $rowEv['Indentacion1_MD136'];
		$Error1_MD136					= $rowEv['Error1_MD136'];
		$Indentacion2_MD136				= $rowEv['Indentacion2_MD136'];
		$Repetitividad1_MD136			= $rowEv['Repetitividad1_MD136'];
		$Indentacion3_MD136				= $rowEv['Indentacion3_MD136'];
		$Indentacion1_MD236				= $rowEv['Indentacion1_MD236'];
		$Error1_MD236					= $rowEv['Error1_MD236'];
		$Indentacion2_MD236				= $rowEv['Indentacion2_MD236'];
		$Repetitividad1_MD236			= $rowEv['Repetitividad1_MD236'];
		$Indentacion3_MD236				= $rowEv['Indentacion3_MD236'];
		$Indentacion1_MD336				= $rowEv['Indentacion1_MD336'];
		$Error1_MD336					= $rowEv['Error1_MD336'];
		$Indentacion2_MD336				= $rowEv['Indentacion2_MD336'];
		$Repetitividad1_MD336			= $rowEv['Repetitividad1_MD336'];
		$Indentacion3_MD336				= $rowEv['Indentacion3_MD336'];
		$Indentacion1_AD151				= $rowEv['Indentacion1_AD151'];
		$Error1_AD151					= $rowEv['Error1_AD151'];
		$Indentacion2_AD151				= $rowEv['Indentacion2_AD151'];
		$Repetitividad1_AD151			= $rowEv['Repetitividad1_AD151'];
		$Indentacion3_AD151				= $rowEv['Indentacion3_AD151'];
		$Indentacion1_AD251				= $rowEv['Indentacion1_AD251'];
		$Error1_AD251					= $rowEv['Error1_AD251'];
		$Indentacion2_AD251				= $rowEv['Indentacion2_AD251'];
		$Repetitividad1_AD251			= $rowEv['Repetitividad1_AD251'];
		$Indentacion3_AD251				= $rowEv['Indentacion3_AD251'];
		$Indentacion1_AD351				= $rowEv['Indentacion1_AD351'];
		$Error1_AD351					= $rowEv['Error1_AD351'];
		$Indentacion2_AD351				= $rowEv['Indentacion2_AD351'];
		$Repetitividad1_AD351			= $rowEv['Repetitividad1_AD351'];
		$Indentacion3_AD351				= $rowEv['Indentacion3_AD351'];
	}
	$link->close();

	if($accion=='Imprimir'){
		header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}
	
	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['codigo']))				{ $codigo			= $_POST['codigo']; 			}
		if(isset($_POST['realizadaCal']))		{ $realizadaCal 	= $_POST['realizadaCal'];		}
		if(isset($_POST['fechaAccionCal']))		{ $fechaAccionCal	= $_POST['fechaAccionCal'];		}
		if(isset($_POST['registradaCal']))		{ $registradaCal	= $_POST['registradaCal'];		}
		if(isset($_POST['fechaRegCal']))		{ $fechaRegCal		= $_POST['fechaRegCal'];		}

		if(isset($_POST['realizadaVer']))		{ $realizadaVer 	= $_POST['realizadaVer'];		}
		if(isset($_POST['fechaAccionVer']))		{ $fechaAccionVer	= $_POST['fechaAccionVer'];		}
		if(isset($_POST['registradaVer']))		{ $registradaVer	= $_POST['registradaVer'];		}
		if(isset($_POST['fechaRegVer']))		{ $fechaRegVer		= $_POST['fechaRegVer'];		}

		if(isset($_POST['realizadaMan']))		{ $realizadaMan 	= $_POST['realizadaMan'];		}
		if(isset($_POST['fechaAccionMan']))		{ $fechaAccionMan	= $_POST['fechaAccionMan'];		}
		if(isset($_POST['registradaMan']))		{ $registradaMan	= $_POST['registradaMan'];		}
		if(isset($_POST['fechaRegMan']))		{ $fechaRegMan		= $_POST['fechaRegMan'];		}

		$link=Conectarse();
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$usrResponsable 	= $rowCot['usrResponsable'];
			$fechaTentativaCal 	= $rowCot['fechaProxCal'];
			$fechaTentativaVer 	= $rowCot['fechaProxVer'];
			$fechaTentativaMan 	= $rowCot['fechaProxMan'];
			
			if($realizadaCal=='on'){
				$tpoProxCal 	= $rowCot['tpoProxCal'];
				$fechaProxCal 	= strtotime ( '+'.$tpoProxCal.' day' , strtotime ( $fechaAccionCal ) );
				$fechaProxCal 	= date ( 'Y-m-d' , $fechaProxCal );
			}
			$actSQL="UPDATE equipos SET ";
			$actSQL.="realizadaCal		='".$realizadaCal.	"',";
			$actSQL.="fechaAccionCal	='".$fechaAccionCal."',";
			$actSQL.="registradaCal		='".$registradaCal.	"',";
			$actSQL.="fechaRegCal		='".$fechaRegCal.	"',";

			if($realizadaCal=='on'){
				$actSQL.="fechaCal		='".$fechaAccionCal	."',";
				$actSQL.="fechaProxCal	='".$fechaProxCal	."',";
			}

			if($realizadaVer=='on'){
				$tpoProxVer 	= $rowCot['tpoProxVer'];
				$fechaProxVer 	= strtotime ( '+'.$tpoProxVer.' day' , strtotime ( $fechaAccionVer ) );
				$fechaProxVer 	= date ( 'Y-m-d' , $fechaProxVer );
			}
			$actSQL.="realizadaVer		='".$realizadaVer.	"',";
			$actSQL.="fechaAccionVer	='".$fechaAccionVer."',";
			$actSQL.="registradaVer		='".$registradaVer.	"',";
			$actSQL.="fechaRegVer		='".$fechaRegVer.	"',";


			if($realizadaVer=='on'){
				$actSQL.="fechaVer		='".$fechaAccionVer	."',";
				$actSQL.="fechaProxVer	='".$fechaProxVer	."',";
			}
			if($realizadaMan=='on'){
				$tpoProxMan 	= $rowCot['tpoProxMan'];
				$fechaProxMan 	= strtotime ( '+'.$tpoProxMan.' day' , strtotime ( $fechaAccionMan ) );
				$fechaProxMan 	= date ( 'Y-m-d' , $fechaProxMan );
			}
			if($realizadaMan=='on'){
				$actSQL.="fechaMan		='".$fechaAccionMan	."',";
				$actSQL.="fechaProxMan	='".$fechaProxMan	."',";
			}
			$actSQL.="realizadaMan		='".$realizadaMan.	"',";
			$actSQL.="fechaAccionMan	='".$fechaAccionMan."',";
			$actSQL.="registradaMan		='".$registradaMan.	"',";
			$actSQL.="fechaRegMan		='".$fechaRegMan.	"'";

			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);

			if($fechaRegCal > '000-00-00'){
				$Accion = 'Cal';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaCal."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaCal',
																'$fechaAccionCal',
																'$Accion',
																'$fechaRegCal',
																'$usrResponsable'
						)");
				}
			}

			if($fechaRegVer > '000-00-00'){
				$Accion = 'Ver';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaVer."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaVer',
																'$fechaAccionVer',
																'$Accion',
																'$fechaRegVer',
																'$usrResponsable'
						)");
				}
			}
			
			if($fechaRegMan > '000-00-00'){
				$Accion = 'Man';
				$bdHis=$link->query("Select * From equiposHistorial Where nSerie = '".$nSerie."' and fechaTentativa = '".$fechaTentativaMan."' and Accion = '".$Accion."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into equiposHistorial(	
																nSerie,
																fechaTentativa,
																fechaAccion,
																Accion,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$nSerie',
																'$fechaTentativaMan',
																'$fechaAccionMan',
																'$Accion',
																'$fechaRegMan',
																'$usrResponsable'
						)");
				}
			}
			
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
	}
	
	if(isset($_POST['guardarEquipo'])){
		$Acreditado = '';
		
		if(isset($_POST['nSerie'])) 		{ $nSerie 			= $_POST['nSerie'];			}
		if(isset($_POST['nomEquipo'])) 		{ $nomEquipo 		= $_POST['nomEquipo'];		}
		if(isset($_POST['lugar'])) 			{ $lugar	 		= $_POST['lugar'];			}
		if(isset($_POST['tipoEquipo'])) 	{ $tipoEquipo		= $_POST['tipoEquipo'];		}
		if(isset($_POST['Acreditado'])) 	{ $Acreditado		= $_POST['Acreditado'];		}

		if(isset($_POST['necesitaCal']))	{ $necesitaCal 		= $_POST['necesitaCal'];	}
		if(isset($_POST['fechaCal'])) 		{ $fechaCal	 		= $_POST['fechaCal'];		}
		if(isset($_POST['tpoProxCal'])) 	{ $tpoProxCal	 	= $_POST['tpoProxCal'];		}
		if(isset($_POST['tpoAvisoCal']))	{ $tpoAvisoCal		= $_POST['tpoAvisoCal'];	}
		if(isset($_POST['fechaProxCal'])) 	{ $fechaProxCal		= $_POST['fechaProxCal'];	}

		if(isset($_POST['necesitaVer'])) 	{ $necesitaVer 		= $_POST['necesitaVer'];	}
		if(isset($_POST['fechaVer'])) 		{ $fechaVer	 		= $_POST['fechaVer'];		}
		if(isset($_POST['tpoProxVer'])) 	{ $tpoProxVer	 	= $_POST['tpoProxVer'];		}
		if(isset($_POST['tpoAvisoVer'])) 	{ $tpoAvisoVer		= $_POST['tpoAvisoVer'];	}
		if(isset($_POST['fechaProxVer'])) 	{ $fechaProxVer		= $_POST['fechaProxVer'];	}
		
		if(isset($_POST['necesitaMan'])) 	{ $necesitaMan 		= $_POST['necesitaMan'];	}
		if(isset($_POST['fechaMan'])) 		{ $fechaMan	 		= $_POST['fechaMan'];		}
		if(isset($_POST['tpoProxMan'])) 	{ $tpoProxMan	 	= $_POST['tpoProxMan'];		}
		if(isset($_POST['tpoAvisoMan'])) 	{ $tpoAvisoMan		= $_POST['tpoAvisoMan'];	}
		if(isset($_POST['fechaProxMan'])) 	{ $fechaProxMan		= $_POST['fechaProxMan'];	}
		
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE equipos SET ";
			$actSQL.="nomEquipo			='".$nomEquipo.		"',";
			$actSQL.="lugar				='".$lugar.			"',";
			$actSQL.="tipoEquipo		='".$tipoEquipo.	"',";
			$actSQL.="Acreditado		='".$Acreditado.	"',";
			$actSQL.="necesitaCal		='".$necesitaCal.	"',";
			$actSQL.="fechaCal			='".$fechaCal.		"',";
			$actSQL.="tpoProxCal		='".$tpoProxCal.	"',";
			$actSQL.="tpoAvisoCal		='".$tpoAvisoCal.	"',";
			$actSQL.="fechaProxCal		='".$fechaProxCal.	"',";
			$actSQL.="necesitaVer		='".$necesitaVer.	"',";
			$actSQL.="fechaVer			='".$fechaVer.		"',";
			$actSQL.="tpoProxVer		='".$tpoProxVer.	"',";
			$actSQL.="tpoAvisoVer		='".$tpoAvisoVer.	"',";
			$actSQL.="fechaProxVer		='".$fechaProxVer.	"',";
			$actSQL.="necesitaMan		='".$necesitaMan.	"',";
			$actSQL.="fechaMan			='".$fechaMan.		"',";
			$actSQL.="tpoProxMan		='".$tpoProxMan.	"',";
			$actSQL.="tpoAvisoMan		='".$tpoAvisoMan.	"',";
			$actSQL.="fechaProxMan		='".$fechaProxMan.	"',";
			$actSQL.="usrResponsable	='".$usrResponsable."'";
			$actSQL.="WHERE 	nSerie	= '".$nSerie."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into equipos(	
															nSerie,
															nomEquipo,
															lugar,
															tipoEquipo,
															Acreditado,
															necesitaCal,
															fechaCal,
															tpoProxCal,
															tpoAvisoCal,
															fechaProxCal,
															necesitaVer,
															fechaVer,
															tpoProxVer,
															tpoAvisoVer,
															fechaProxVer,
															necesitaMan,
															fechaMan,
															tpoProxMan,
															tpoAvisoMan,
															fechaProxMan,
															usrResponsable
															) 
												values 	(	
															'$nSerie',
															'$nomEquipo',
															'$lugar',
															'$tipoEquipo',
															'$Acreditado',
															'$necesitaCal',
															'$fechaCal',
															'$tpoProxCal',
															'$tpoAvisoCal',
															'$fechaProxCal',
															'$necesitaVer',
															'$fechaVer',
															'$tpoProxVer',
															'$tpoAvisoVer',
															'$fechaProxVer',
															'$necesitaMan',
															'$fechaMa',
															'$tpoProxMan',
															'$tpoAvisoMan',
															'$fechaProxMan',
															'$usrResponsable'
					)");
		}
		$link->close();
		$nSerie	= '';
		$accion	= '';
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Intranet Simet -> Verificación</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../../jquery/jquery-1.6.4.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../../css/tpv.css" rel="stylesheet" type="text/css">

	<script>
	function realizaProceso(usrRes, tpAccion){
		var parametros = {
			"usrRes" 	: usrRes,
			"tpAccion"  : tpAccion
		};
		//alert(tpAccion);
		$.ajax({
			data: parametros,
			url: 'muestraEquipos.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraEquipo(nSerie, accion){
		var parametros = {
			"nSerie"	: nSerie,
			"accion"	: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regEquipo.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function buscarContactos(Cliente){
		var parametros = {
			"Cliente" 	: Cliente
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
	
	function datosContactos(Cliente, Atencion){
		var parametros = {
			"Cliente" 	: Cliente,
			"Atencion"	: Atencion
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

	function seguimientoEquipo(nSerie, accion, tpAccion){
		var parametros = {
			"nSerie" 	: nSerie,
			"accion"	: accion,
			"tpAccion"	: tpAccion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segEquipo.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoRAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segRAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function seguimientoAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function cambiarMoneda(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segCAMvalores.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	function verObservaciones(Descripcion, Observaciones){
		var parametros = {
			"Descripcion"	: Descripcion,
			"Observaciones" : Observaciones
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'verDesObs.php',
			type: 'get',
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
				<img src="../../imagenes/equipamiento.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Arial; font-size:14px; ">
					Verificación Equipo <?php echo $nomEquipo; ?> 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>

			<form name="form" action="index.php" method="post">

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../../plataformaErp.php" title="Menú Principal">
						<img src="../../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="../plataformaEquipos.php" title="Equipos"">
						<img src="../../imagenes/equipamiento.png"><br>
					</a>
					Equipos
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<button name="GuardarVerificacion">
						<img src="../../imagenes/guardar.png"><br>
						Equipos
					</button>
				</div>
				<div id="ImagenBarraLeft" title="Descargar Formulario Verificación">
					<a href="exportarFormulario.php?nFormVD=<?php echo $nFormVD; ?>" title="Verificación"">
						<img src="../../imagenes/boton_word_descarga.png"><br>
					</a>
					Formulario
				</div>
			</div>
			
			<?php include_once('regVerificacion.php'); ?>
			
			</form>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>
	
	
</body>
</html>
