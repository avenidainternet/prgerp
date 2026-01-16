<html>
<head>
<script src="../../jquery/jquery-1.6.4.js"></script>
<script>
$(document).ready(function(){
  	$("#ver").click(function(){
		$("#ventanita").css({"visibility":"visible"});  
	});
  	$("#cerrarventanita").click(function(){
		$("#ventanita").css({"visibility":"hidden"});  
	});
});
</script>

</head>

<body>
<input name="datos" id="datos" type="text" />
<input name="datos2" id="datos2" type="text" />
<input name="datos3" id="datos3" type="text" />
<input name="ver" id="ver" type="button" value="ver" />
<!-- <input name="ver" id="ver" type="button" value="ver" onclick="mifuncion('<?php echo $nombre ?>', '<?php echo $estado ?>', '<?php echo $tipo ?>')" /> -->
<div id="ventanita" style="visibility:hidden; position:absolute; top: 300px; left: 400px; background-color: #CCCCCC">
	<input name="nuevafase" type="text">
	<input name="aceptarnueva" id="cerrarventanita" type="submit" value="Aceptar">
</div> 
<script>
function mifuncion(nombre, estado, tipo){
    document.getElementById("datos").value = "Nombre: " + nombre;
	document.getElementById("datos2").value = "Estado: " + estado;
	document.getElementById("datos3").value = "Tipo: " + tipo;
	
}  
</script>
</body>
</html> 