<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once("conexion.php"); 
	$RutCli = $_GET[RutCli];
	$RAM 	= $_GET[RAM];
	
	echo 'CAM-';?>
	<select name="CAM" 	id="CAM">
		<option></option>
		<?php
		$link=Conectarse();
		$bdCon=mysql_query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'E'");
		if($rowCon=mysql_fetch_array($bdCon)){
			do{
				if($rowCon[RAM] == $RAM){
					echo '	<option selected 	value="'.$rowCon[CAM].'">'.$rowCon[CAM].'</option>';
				}else{
					echo '	<option  			value="'.$rowCon[CAM].'">'.$rowCon[CAM].'</option>';
				}
			}while ($rowCon=mysql_fetch_array($bdCon));
			
		}
		mysql_close($link);
		?>
	</select>
