<?php
	//ini_set("session.cookie_lifetime","36000");
	//ini_set("session.gc_maxlifetime","36000");
	date_default_timezone_set("America/Santiago");
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<!-- <link href="../css/tpv.css" rel="stylesheet" type="text/css"> -->
	<link href="styles.css" rel="stylesheet" type="text/css">

</head>

<body>
<p><a href="#" onclick="Sexy.alert('<h1>SexyAlertBox</h1><em>versión 1.1</em><br/><p>No te olvides de visitar <a href=\'http://www.coders.me/\'>www.coders.me</a> está lleno de artículos de programación.</p>');return false;">Mostrar alerta</a></p>

<p><a href="#" onclick="Sexy.info('<h1>SexyAlertBox</h1><em>versión 1.1</em><br/><p>&copy;2008-2009 Todos los derechos reservados.</p><p>Sexy Alert Box está basado en PBBAcpBox.</p><p>Visita <a href=\'http://www.coders.me/\'>www.coders.me</a> para obtener la última versión de este script.</p>');return false;">Acerca de...</a></p>

<p><a href="#" onclick="Sexy.error('<h1>Error al intentar entrar al sistema</h1><p>Inténtalo de nuevo.</p>');return false;">Mostrar error</a></p></body>

<script>
function test() {
  Sexy.prompt('<h1>Registro de usuarios</h1>Ingresa tu nombre para poder identificarte en el sistema.','Eduardo' ,{ onComplete: 
    function(returnvalue) {
      if(returnvalue)
      {
        Sexy.confirm('<h1>Bienvenido '+returnvalue+',</h1><p>¿Deseas ver el about us?</p><p>Pulsa "Ok" para continuar, o pulsa "Cancelar" para salir.</p>', {onComplete: 
          function(returnvalue) { 
            if(returnvalue)
            {
              Sexy.info('<h1>SexyAlertBox</h1><em>versión 1.2</em><br/><p>&copy;2008-2009 Todos los derechos reservados.</p><p>Sexy Alert Box está basado en PBBAcpBox.</p><p>Visita <a href="http://www.coders.me/">www.coders.me</a> para obtener la última versión de este script.</p>');
            }
            else
            {
            Sexy.alert('<h1>SexyAlertBox</h1><em>versión 1.2</em><br/><p>No te olvides de visitar <a href="http://www.coders.me/">www.coders.me</a> está lleno de artículos de programación.</p>');
            }
          }
        });
      }
      else
      {
        Sexy.error('<h1>Error al intentar entrar al sistema</h1><p>Para continuar, debes ingresar un nombre en la casilla de Nombre.</p><p>Inténtalo de nuevo.</p>');
      }
    }
  });
}
</script>
<a href="#" onclick="test();return false;">Click Here</a>

</html>
