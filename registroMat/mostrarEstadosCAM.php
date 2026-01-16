<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['EstadoCot'])) { $EstadoCot  = $_GET['EstadoCot']; }
	?>
	<?php
	if($EstadoCot<>"E"){?>
		Orden de Compra 	<input name="oCompra" 	type="checkbox" checked>
		Correo Electrónico 	<input name="oMail"  	type="checkbox">
		Cuenta Corriente	<input name="oCtaCte"  	type="checkbox">
		<?php
	}
?>