<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	
	$nContacto 	= 0;
	$CAM 		= '';
	
	if(isset($_GET['CAM'])) 		{ $CAM  		= $_GET['CAM']; 		}
	$link=Conectarse();
	//echo $CAM;
	if($CAM){
		$bdCAM=$link->query("SELECT * FROM cotizaciones Where CAM = '".$CAM."'");
		if($rowCAM=mysqli_fetch_array($bdCAM)){
			$RutCli 	= $rowCAM['RutCli'];
			$nContacto 	= $rowCAM['nContacto'];
		}
	}
	?>
	<input name="nContacto" id="nContacto" type="hidden" value="<?php echo $nContacto;?>">
	<select name="nContacto" id="nContacto"  style="font-size:12px; font-weight:700;" onChange="datosContactos($('#Cliente').val(), $('#Contacto').val(), $('#nContacto').val())">
		<option></option>
		<?php
		$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
		if($rowCon=mysqli_fetch_array($bdCon)){
			do{
				if($rowCon['nContacto'] == $nContacto){
					echo '	<option selected 	value="'.$rowCon['nContacto'].'">'.$rowCon['Contacto'].'</option>';
				}else{
					echo '	<option  			value="'.$rowCon['nContacto'].'">'.$rowCon['Contacto'].'</option>';
				}
			}while ($rowCon=mysqli_fetch_array($bdCon));
		}
	?>
	</select>
	<?php
	$link->close();
	?>
