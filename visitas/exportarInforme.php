<?
include_once("conexion.php");
$idVisita	= $_GET['idVisita'];
$accion 	= $_GET['accion'];
$nomInforme = 'RegistoVisita_'.$idVisita.'.doc';

//Exportar datos de php a Word
header("Content-Type: application/vnd.ms-word");
header("content-disposition: attachment;filename=$nomInforme");
/*
header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
*/

$link=Conectarse();
$bdInf=mysql_query("Select * From Visitas Where idVisita = '".$idVisita."'");
if($rowInf=mysql_fetch_array($bdInf)){
	$RutCli 			= $rowInf['RutCli'];
	$Actividad			= $rowInf['Actividad'];
	$uRes				= $rowInf['usrResponsable'];
	$fechaRegAct	 	= $rowInf['fechaRegAct'];
	$fechaInforme 		= $rowInf['fechaInforme'];
	$Conclusion			= $rowInf['Conclusion'];
}

$bdCli=mysql_query("Select * From Clientes Where RutCli = '".$RutCli."'");
if($rowCli=mysql_fetch_array($bdCli)){
	$Cliente 	= $rowCli[Cliente];
	$Direccion 	= $rowCli[Direccion];
}
$bdCli=mysql_query("Select * From Usuarios Where usr = '".$uRes."'");
if($rowCli=mysql_fetch_array($bdCli)){
	$uRes 	= $rowCli['usuario'];
}
	$Impresa = 'on';
	$actSQL="UPDATE Visitas SET ";
	$actSQL.="Impresa		 ='".$Impresa.	"'";
	$actSQL.="Where idVisita = '".$idVisita."'";
	$bdCot=mysql_query($actSQL);

mysql_close($link);
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<style>
body {
	font-family:Arial;
	font-size:0.85em;
}

.blanco {
	display:block;
	margin:0% 0;
}
/* +++ */
.ftoTablaResultado {
	font-size		:0.8em; 
	width			:35.44em;
	border			:1px double #000;
	background-color:#E6E6E6;
}
.ftoTablaResultado td{
	height			:1.65em;
}
.tResQ1 {
	width			:6em;
}
.tResQ2-10 {
	width			:4.2em;
}
.tResT2-6 {
	font-size		:12px; 
	width			:4.2em;
}
/* +++ */

.tablaId {
	width			:35.44em;
	border			:1px double #000;
	background-color:#E6E6E6;
}
.tablaId td{
	height			:2.13em;
	/* height:30px; */
}
.tablaIdCol1{
	width			:5.15em;
	font-size		:12px; 
}

.tablaExternaNegra{
	font-family:Arial;
	border:2px solid #000; 
	background-color:#000000; 
	width:96%;
}
.tablaInternaNegra{
	font-family:Arial;
	width:100%;
	border:1px double #000; 
	background-color:#FFFFFF;
}

#tablaExternaNegra2{
	border:4px solid #000; 
	width:35.44em;
}
#tablaExternaNegra2 td{
	font-family:Arial;
	font-size:13,5px;
}
.c1{
	width		:10.5em;
	height		:0.97em;
}
.c2{
	width:1.48em;
}
.c3{
	width:13.55em;
}
.c4{
	width:14.95em;
}
.c5{
	width:1.48em;
}
.c6{
	width:5.8em;
}
.inter15{
	text-indent: 60px; 
	line-height:150%;
	text-align:justify;
	margin: 0 auto;	
}
</style>

</head>
<body>

	<center><span style="font-size:18px;"><b>Registo de Visita N° <?php echo $idVisita; ?></b></center>
	<br><br>
	<table cellpadding="0" cellspacing="0" width="800px" style="border:1px solid #ccc;" align="center">
		<tr>
			<td width="168" height="40" style="padding-left:10px;"><b>Cliente</b></td>
			<td width="24"><b>:</b></td>
			<td width="706" style="padding-left:10px;"><b><?php echo $Cliente; ?></b></td>
		</tr>
		<tr>
			<td height="40" style="padding-left:10px;"><b>Direcci&oacute;n</b></td>
			<td class="c2"><b>:</b></td>
			<td style="padding-left:10px;"><?php echo $Direccion; ?></td>
		</tr>
		<tr>
			<td height="40" style="padding-left:10px;"><b>Responsable</b></td>
			<td class="c2"><b>:</b></td>
			<td class="c3" style="padding-left:10px;">
				<?php echo $uRes; ?>
			</td>
		</tr>
	</table>
	
	<p class="blanco" >&nbsp;</p>
			
	<p class="blanco">
		<span style="text-decoration:underline; font-weight:700;">Registro de la Visita</span>
	</p>

	<p class="blanco" >&nbsp;</p>

	<b>Objetivo Visita:</b><br><br>
	
	<span style="font-size:12px;"><?php echo stripcslashes(nl2br($Actividad)); ?></span>

	<p class="blanco" >&nbsp;</p>
	
	<b>Conclusi&oacute;n:</b><br><br>
	
	<span style="font-size:12px;"><?php echo stripcslashes(nl2br($Conclusion)); ?><span style="font-size:12px;">

</body>
</html>