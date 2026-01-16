<?php 
			$Pla = 'archivo.jpg';
			if(isset($_POST['guardarIdMuestra222'])) 	{ 
//				$Plano 		= $_POST['sPlano'];		
			
				//echo $Plano;
				$directorio="Planos";
				$nombre_archivo = $_FILES['sPlano']['name'];
				$tipo_archivo 	= $_FILES['sPlano']['type'];
				$tamano_archivo = $_FILES['sPlano']['size'];
				$desde 			= $_FILES['sPlano']['tmp_name'];
				if(move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
				}
			}
?>
<form name="form" action="sImagen.php" method="post" enctype="multipart/form-data">

				Plano:
				</div>
				<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
				<input name="sPlano" type="file" id="sPlano">

				<button name="guardarIdMuestra222"  title="Guardar Muestras Mantención">
					<img src="../gastos/imagenes/guardar.png" width="55" height="55">
				</button>
				
</form>