<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	
	$nContacto = 0;
	$Contacto = '';
	
	if(isset($_GET['Cliente'])) 	{ $Cliente  	= $_GET['Cliente']; 	}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto']; 	}
	if(isset($_GET['Atencion']))	{ $Contacto		= $_GET['Atencion']; 	}
	if(isset($_GET['CAM'])) 		{ $CAM  		= $_GET['CAM']; 		}
	if(isset($_GET['Rev'])) 		{ $Rev  		= $_GET['Rev']; 		}
	if(isset($_GET['Cta'])) 		{ $Cta  		= $_GET['Cta']; 		}
	
	$link=Conectarse();
	if($Cliente == ''){
		$bdCli=$link->query("SELECT * FROM Clientes Where Cliente = '".$Cliente."'");
		if($rowCli=mysqli_fetch_array($bdCli)){
			$RutCli = $rowCli['RutCli'];
		}
	}
	?>
	<input name="nContacto" id="nContacto" type="hidden" value="<?php echo $nContacto;?>">
	<select name="Atencion" id="Atencion"  style="font-size:12px; font-weight:700;" onChange="datosContactos($('#Cliente').val(), $('#Atencion').val(), $('#nContacto').val())">
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
