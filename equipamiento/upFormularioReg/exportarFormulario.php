<?php
header('Content-Type: text/html; charset=utf-8');

$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
			);

include_once("../../conexionli.php");
require_once '../../phpdocx/classes/CreateDocx.inc';

if(isset($_GET['nFormVD'])){ $nFormVD = $_GET['nFormVD']; };

$Responsable 	= '';
$Observaciones 	= '';
$Cumple			= '';
$nCumple		= '';

$link=Conectarse();
$bdEq=$link->query("SELECT * FROM equipovd Where nFormVD = '".$nFormVD."'");
if($rowEq=mysqli_fetch_array($bdEq)){
	$fechaVerificacion	= $rowEq['fechaVerificacion'];
	$fd = explode('-',$fechaVerificacion);
	$fechaRecepcion	= $fd[2].'-'.$fd[1].'-'.$fd[0];
	$Observaciones	= $rowEq['Observaciones'];
	if($rowEq['Cumple'] == 'on'){
		$Cumple 	= 'X';
		$nCumple 	= ' ';
	}
	if($rowEq['Cumple'] == 'off'){
		$Cumple 	= ' ';
		$nCumple 	= 'X';
	}
	$bdUs=$link->query("SELECT * FROM usuarios Where usr = '".$rowEq['usrResponsable']."'");
	if($rowUs=mysqli_fetch_array($bdUs)){
		$Responsable = $rowUs['usuario'];
	}
}
$link->close();

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter');
$docx = new CreateDocxFromTemplate('F2701VD01.docx');

$link=Conectarse();
$bdVer=$link->query("SELECT * FROM equipovdres Where nFormVD = '".$nFormVD."'");
if($rowVer=mysqli_fetch_array($bdVer)){
	$MaterialRef_SRB20	= $rowVer['MaterialRef_SRB20'];

	$options = array(
					'target' 		=> 'header',
					'firstMatch' 	=> false,
					);
	$docx->replaceVariableByText(array(
										'nFormVD' 						=> $nFormVD,
										'dia' 							=> $fd[2],
										'mes' 							=> $Mes[intval($fd[1])],
										'agno' 							=> $fd[0],
										'Responsable' 					=> $Responsable,
										'MaterialRef_SRB20' 			=> $rowVer['MaterialRef_SRB20'],
										'DurezaMaterial_SRB20' 			=> $rowVer['DurezaMaterial_SRB20'],
										'IncertidumbreMaterial_SRB20' 	=> $rowVer['IncertidumbreMaterial_SRB20'],
										'MaterialRef_SRM36' 			=> $rowVer['MaterialRef_SRM36'],
										'DurezaMaterial_SRM36' 			=> $rowVer['DurezaMaterial_SRM36'],
										'IncertidumbreMaterial_SRM36'	=> $rowVer['IncertidumbreMaterial_SRM36'],
										'MaterialRef_SRA51'				=> $rowVer['MaterialRef_SRA51'],
										'DurezaMaterial_SRA51'			=> $rowVer['DurezaMaterial_SRA51'],
										'IncertidumbreMaterial_SRA51'	=> $rowVer['IncertidumbreMaterial_SRA51'],
										'DurezaMaterial_PRB20'			=> $rowVer['DurezaMaterial_PRB20'],
										'ErrorMaterial_PRM36'			=> $rowVer['ErrorMaterial_PRM36'],
										
										'DurezaMaterial_PRM36'			=> $rowVer['DurezaMaterial_PRM36'],
										'ErrorMaterial_PRM36'			=> $rowVer['ErrorMaterial_PRM36'],
										'DurezaMaterial_PRA51'			=> $rowVer['DurezaMaterial_PRA51'],
										'ErrorMaterial_PRA51'			=> $rowVer['ErrorMaterial_PRA51'],
										
										'I1BD120'						=> $rowVer['Indentacion1_BD120'],
										'Error1_BD120'					=> $rowVer['Error1_BD120'],
										'I2BD120'						=> $rowVer['Indentacion2_BD120'],
										'R1BD120'						=> $rowVer['Repetitividad1_BD120'],
										'I3BD120'						=> $rowVer['Indentacion3_BD120'],
										
										'I1BD220'						=> $rowVer['Indentacion1_BD220'],
										'E1BD220'						=> $rowVer['Error1_BD220'],
										'I2BD220'						=> $rowVer['Indentacion2_BD220'],
										'R1BD220'						=> $rowVer['Repetitividad1_BD220'],
										'I3BD220'						=> $rowVer['Indentacion3_BD220'],
										
										'I1BD320'						=> $rowVer['Indentacion1_BD320'],
										'E1BD320'						=> $rowVer['Error1_BD320'],
										'I2BD320'						=> $rowVer['Indentacion2_BD320'],
										'R1BD320'						=> $rowVer['Repetitividad1_BD320'],
										'I3BD320'						=> $rowVer['Indentacion3_BD320'],

										'I1MD136'						=> $rowVer['Indentacion1_MD136'],
										'E1MD136'						=> $rowVer['Error1_MD136'],
										'I2MD136'						=> $rowVer['Indentacion2_MD136'],
										'R1MD136'						=> $rowVer['Repetitividad1_MD136'],
										'I3MD136'						=> $rowVer['Indentacion3_MD136'],
										
										'I1MD236'						=> $rowVer['Indentacion1_MD236'],
										'E1MD236'						=> $rowVer['Error1_MD236'],
										'I2MD236'						=> $rowVer['Indentacion2_MD236'],
										'R1MD236'						=> $rowVer['Repetitividad1_MD236'],
										'I3MD236'						=> $rowVer['Indentacion3_MD236'],
										
										'I1MD336'						=> $rowVer['Indentacion1_MD336'],
										'E1MD336'						=> $rowVer['Error1_MD336'],
										'I2MD336'						=> $rowVer['Indentacion2_MD336'],
										'R1MD336'						=> $rowVer['Repetitividad1_MD336'],
										'I3MD336'						=> $rowVer['Indentacion3_MD336'],

										'I1AD151'						=> $rowVer['Indentacion1_AD151'],
										'E1AD151'						=> $rowVer['Error1_AD151'],
										'I2AD151'						=> $rowVer['Indentacion2_AD151'],
										'R1AD151'						=> $rowVer['Repetitividad1_AD151'],
										'I3AD151'						=> $rowVer['Indentacion3_AD151'],
										
										'I1AD251'						=> $rowVer['Indentacion1_AD251'],
										'E1AD251'						=> $rowVer['Error1_AD251'],
										'I2AD251'						=> $rowVer['Indentacion2_AD251'],
										'R1AD251'						=> $rowVer['Repetitividad1_AD251'],
										'I3AD251'						=> $rowVer['Indentacion3_AD251'],
										
										'I1AD351'						=> $rowVer['Indentacion1_AD351'],
										'E1AD351'						=> $rowVer['Error1_AD351'],
										'I2AD351'						=> $rowVer['Indentacion2_AD351'],
										'R1AD351'						=> $rowVer['Repetitividad1_AD351'],
										'I3AD351'						=> $rowVer['Indentacion3_AD351'],

										'Observaciones'					=> $Observaciones,
										'C'								=> $Cumple,
										'NC'							=> $nCumple,
										
										)
								);

}
$link->close();

$Formulario = 'From-'.$nFormVD;
$docx->createDocxAndDownload($Formulario);
?>