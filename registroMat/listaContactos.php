<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['RutCli'])) 		{ $RutCli  		= $_GET['RutCli']; 		}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto']; 	}
	if(isset($_GET['RAM']))			{ $RAM			= $_GET['RAM']; 		}

	$cCli = substr($RutCli,0,8);
	$codBarra	= $cCli.$RAM;
	//echo '<img width="120" src="http://barcode.tec-it.com/barcode.ashx?code=EAN13&modulewidth=fit&data='.$codBarra.'&dpi=96&imagetype=png&rotation=0&color=&bgcolor=&fontcolor=&quiet=0&qunit=mm&download=true" alt="Generador de código de barras TEC-IT"/><br>';
	//echo $codBarra;?>

	<?php
	$link=Conectarse();
	if($Contacto == ''){
		$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."' and nContacto = '".$nContacto."'");
		if($rowCon=mysql_fetch_array($bdCon)){
			$Contacto  = $rowCon[Contacto];
			$nContacto = $rowCon[nContacto];
			echo 'Contacto... '.$Contacto;
		}
	}
	?>
	<input 	name="RAM" 			id="RAM" 		type="hidden" value="<?php echo $RAM;?>">
	<input 	name="RutCli" 		id="RutCli" 	type="hidden" value="<?php echo $RutCli;?>">
	<select name="nContacto" 	id="nContacto"  style="font-size:12px; font-weight:700;" onChange="datosContactos($('#RutCli').val(), $('#nContacto').val())">
		<option></option>
		<?php
		$bdCon=mysql_query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
		if($rowCon=mysql_fetch_array($bdCon)){
			do{
				if($rowCon[nContacto] == $nContacto){
					echo '	<option selected 	value="'.$rowCon[nContacto].'">'.$rowCon[Contacto].'</option>';
				}else{
					echo '	<option  			value="'.$rowCon[nContacto].'">'.$rowCon[Contacto].'</option>';
				}
			}while ($rowCon=mysql_fetch_array($bdCon));
			
		}
		?>
	</select>
	<?php
	mysql_close($link);
	?>
	<script>
		var RutCli 	= "<?php echo $RutCli; 	?>";
		var RAM 	= "<?php echo $RAM; 	?>";
		verCodigoBarra(RutCli, RAM); 
	</script>
