<?
	session_start();
	if (!$_SESSION['usr']){
		header("Location: index.php");
	}
	if (isset ($_POST['Volver'])) {
		header("Location: informes.php");
	}

	$IdProyecto=$_GET['IdProyecto'];
	$CodInforme=$_GET['CodInforme'];
	
	include("conexion.php");
	$MsgUsr="";
	
		?>
		<script>
			//alert("<?php echo $tamano_archivo;?>");
			alert("Entra");
		</script>
		<?php

	if (isset ($_POST['Subir'])) {

		$CodInforme = $_POST['CodInforme'];
		
		$link=Conectarse();
		$bdProv=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
		if ($row=mysql_fetch_array($bdProv)){
			$CodInforme=$row['CodInforme'];
		}

		$nombre_archivo = $_FILES['Informe']['name'];
		$tipo_archivo 	= $_FILES['Informe']['type'];
		$tamano_archivo = $_FILES['Informe']['size'];
		$desde 			= $_FILES['Informe']['tmp_name'];
		
		echo 'Nombre Archivo: '.$_FILES['Informe']['name'].'<br>';
		echo 'Type   Archivo: '.$_FILES['Informe']['type'].'<br>';
		echo 'Tamaño Archivo: '.$_FILES['Informe']['size'].'<br>';
		

		$directorio="informes";
		if (!file_exists($directorio)){
			mkdir($directorio,0755);
		}
		if ($tipo_archivo == "application/pdf" && $tamano_archivo <= 1024000) {
    		if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
   				
				//$MsgUsr="El Informe ".$nombre_archivo." ha sido cargado correctamente....";
				
				$bdpos=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
				if ($rowpos=mysql_fetch_array($bdpos)){
					$actSQL="UPDATE Informes SET ";
					$actSQL.="informePDF		='".$nombre_archivo."'";
					$actSQL.="WHERE CodInforme 	= '".$CodInforme."'";
					$bdpos=mysql_query($actSQL);
				}

				$CodInforme 	= substr($CodInforme,0,6);
				$infoNumero 	= 0;
				$infoSubidos 	= 0;
				$bdInf=mysql_query("SELECT * FROM Informes Where CodInforme Like '%".$CodInforme."%'");
				if($rowInf=mysql_fetch_array($bdInf)){
					do{
						$infoNumero++;
						if($rowInf[informePDF]){
							$infoSubidos++;
						}
					}while ($rowInf=mysql_fetch_array($bdInf));
				}

				$MsgUsr="Informe ".$CodInforme.': '$infoNumero."/".$infoSubidos;

				
    		}else{ 
   				$MsgUsr="Ocurrió algún error al subir el fichero ".$nombre_archivo." No pudo guardar.... ";
    		} 
		}else{
    		$MsgUsr="Se permite subir un documento PDF <br>"; 
		}
		mysql_close($link);
	}

	
	$link=Conectarse();
	$bdProv=mysql_query("SELECT * FROM Informes WHERE CodInforme = '".$CodInforme."'");
	if ($row=mysql_fetch_array($bdProv)){
		$CodInforme=$row['CodInforme'];
		$informePDF=$row['informePDF'];
	}
	mysql_close($link);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../css/intranet.css" rel="stylesheet" type="text/css">
<title>Subir Informe PDF</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 14px}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center" class="titulopromocion">
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#CCD8E6"><div align="center" class="tituloficha">Subir Informe PDF <? echo $CodInforme; ?></div></td>
    </tr>
  </table>
</div>

<table width="80%"  border="1" align="center" cellpadding="0" cellspacing="0" class="textoformulario">
	<tr>
		<td>
<form action="<?=$PHP_SELF."?".SID?>" method="post" enctype="multipart/form-data">
  <table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0" class="textoformulario">
  		<tr>
  		  <td>&nbsp;</td>
  		  <td height="50"><input name="CodInforme" type="hidden" id="CodInforme" size="10" maxlength="10" value="<? echo $CodInforme; ?>"></td>
		  </tr>
  		<tr>
  		  <td width="36%" class="usrpwd"><div align="right">Informe PDF :</div></td>
  		  <td width="64%" height="50">
    			<input type="hidden" name="MAX_FILE_SIZE" value="1024000"> 
				<input name="Informe" type="file" id="Informe">
		  </td>
		  </tr>
  		<tr>
  		  <td>&nbsp;</td>
  		  <td>&nbsp;</td>
		</tr>
  		<tr>
  		  <td>&nbsp;</td>
  		  <td>&nbsp;</td>
		  </tr>
  		<tr>
    		<td colspan="2">			<div align="right" class="cajausr"><? echo $MsgUsr; ?></div></td>
   		  </tr>
  </table>
    <input name="Subir" type="submit" class="titulopromocion" id="Subir" value="Subir"> 
    <input name="Volver" type="submit" id="Volver" value="Volver">
</form> 
		</td>
	</tr>
</table>
</body>
</html>