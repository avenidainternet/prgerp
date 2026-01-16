<?
function ErrorType($Type) {
  $MsgError = "";
  if ($Type==1) {
    $MsgError = $MsgError . "Fallo permanente<br>\n";
    $MsgError = $MsgError . "Fallo permanente que no es probable que se resuelva por reenviar el mensaje de la forma actual. Se deben realizar algunos cambios en el mensaje o el destino para el éxito de la entrega.\n";
  } 

  if ($Type==2) {
    $MsgError = $MsgError . "Fallo persistente transitorio<br>\n";
    $MsgError = $MsgError . "Un fallo persistente transitorio es aquel en el cual el mensaje enviado es válido, pero algunos eventos temporales impiden el éxito de envío del mensaje. Enviandolo en el futuro puede tener éxito.<br>\n";
  }
  return $MsgError;
}


function ErrorSubType($SubType) {
  $cadena = "";
  switch ($SubType) {
    case "5.1.1":
      $cadena = $cadena . "Dirección erronea del buzón de destino<br>\n";
      $cadena = $cadena . "El buzón especificado especificado en la dirección no existe.  Esto significa que la porción de la dirección a la izquierda del símbolo @ no es válido. Este código es sólo útil para fallos permanentes.<br>\n";
	  break;	  
    case "5.1.2":
      $cadena = $cadena . "Destinación erronea de dirección de sistema<br>\n";
      $cadena = $cadena . "La destinación del sistema especificado en la dirección no existe o es incapaz de aceptar correos.  Esto significa que la porción de la dirección a la derecha del símbolo @ no es válido para el correo. Este código es sólo útil para fallos permanentes.<br>\n";
	  break;	  
    case "4.2.2":
      $cadena = $cadena . "Buzón entrada lleno<br>\n";
      $cadena = $cadena . "El buzón está lleno porque el usuario ha excedido la cuota administrativa marcada por buzón o espacio físico.  Esto implica que el receptor puede eliminar mensajes para crear espacio disponible. Este código deberia usarse como fallo persistente transitorio.<br>\n";
	  break;	  
    case "4.2.0":
      $cadena = $cadena . "Estado indefinido u otro status del buzón de entrada<br>\n";
      $cadena = $cadena . "El buzón existe, pero alguna razón sobre el buzón de destino ha causado el envío de este DSN.<br>\n";
	  break;	  
    case "5.2.0":
      $cadena = $cadena . "Estado indefinido u otro status del buzón de entrada<br>\n";
      $cadena = $cadena . "El buzón existe, pero alguna razón sobre el buzón de destino ha causado el envío de este DSN.<br>\n";
	  break;	  
    case "5.4.4":
      $cadena = $cadena . "Incapaz de enrutar<br>\n";
      $cadena = $cadena . "El sistema de correo no ha podido determinar el siguiente salto para el mensaje porque no se encuentra disponible la información necesaria para el enrutamiento dsde el directorio del servidor. Este mensaje se puede usar tanto para los fallos persistentes como para los transitorios. Ejecutando un DNS lookup deberia devolver solo un SOA (Start of Administration) este registro para un nombre de dominio es un ejemplo del error de ruta desconocida.<br>\n";
	  break;	  
    case "4.4.7":
      $cadena = $cadena . "Tiempo de entrega expirado<br>\n";
      $cadena = $cadena . "El mensaje ha sido considerado demasiado viejo por el sistema de devolución, porque ha sido retenido demasiado tiempo en el host o porque el tiempo de vida especificado por el remitente ha sido excedido. Se usa este error con los fallos persistentes transitorios.<br>\n";
	  break;	  
    case "5.2.0":
      $cadena = $cadena . "Estado indefinido u otro status del buzón de entrada<br>\n";
      $cadena = $cadena . "El buzón existe, pero alguna razón sobre el buzón de destino ha causado el envío de este DSN.<br>\n";
	  break;	  
    case "5.5.4":
      $cadena = $cadena . "Argumentos de comando no válidos<br>\n";
      $cadena = $cadena . "Un protocolo de comando válido de transacción de correo ha sido enviado con argumentos no válidos, puede que porque los argumentos se encontraban fuera de rango o con características representadas no reconocidas. Se usa este error con los fallos permanentes.<br>\n";
	  break;	  
    case "4.4.1":
      $cadena = $cadena . "No se ha recibido respuesta del Host<br>\n";
      $cadena = $cadena . "La conexión exterior se ha intentado sin obtener respuesta, producido porque el sistema remoto se encuentre ocupado, o no ha sido posible realizar la llamada. Se usa este error con los fallos persistentes transitorios.<br>\n";
	  break;	  
    case "5.5.0":
      $cadena = $cadena . "Estado indefinido u otro status del protocolo<br>\n";
      $cadena = $cadena . "Existe alguna cosa erronea necesaria en el protocolo para enviar el mensaje hacia el siguiente salto y el problema no puede ser bien expresado con ningún código detallado.<br>\n";
	  break;	  
    case "5.1.2":
      $cadena = $cadena . "Destinación erronea de dirección de sistema<br>\n";
      $cadena = $cadena . "La destinación del sistema especificado en la dirección no existe o es incapaz de aceptar correos.  Esto significa que la porción de la dirección a la derecha del símbolo @ no es válido para el correo. Este código es sólo útil para fallos permanentes.<br>\n";
	  break;	  
    case "4.2.0":
      $cadena = $cadena . "Estado indefinido u otro status del buzón de entrada<br>\n";
      $cadena = $cadena . "El buzón existe, pero alguna razón sobre el buzón de destino ha causado el envío de este DSN.<br>\n";
	  break;	  
    case "5.5.4":
      $cadena = $cadena . "Argumentos de comando no válidos<br>\n";
      $cadena = $cadena . "Un protocolo de comando válido de transacción de correo ha sido enviado con argumentos no válidos, puede que porque los argumentos se encontraban fuera de rango o con características representadas no reconocidas. Se usa este error con los fallos permanentes.<br>\n";
	  break;	  
    case "5.1.1":
      $cadena = $cadena . "Dirección erronea del buzón de destino<br>\n";
      $cadena = $cadena . "El buzón especificado especificado en la dirección no existe.  Esto significa que la porción de la dirección a la izquierda del símbolo @ no es válido. Este código es sólo útil para fallos permanentes.<br>\n";
      break;	  
  }
  return $cadena;
}


function ErrorMailLog($num_linies,$marca,$line) {
  $cadena = "";
  //$cadena = $num_linies." : ".$marca.":".$line."\n";
  return $cadena;
}

function PintaTaulaRes($ErrorTypeVar,$ErrorSubTypeVar,$UserMail_Array,$indice) {
  if ($indice>0) {
    $strRes = $strRes . "<table border='1'>\n";
    $strRes = $strRes . "<tr><td bgcolor='#DDDDDD'><span class='NormalFont'>".ErrorType($ErrorTypeVar)."</span></tr></td>\n";
    $strRes = $strRes . "<tr><td bgcolor='#CCCDDD'><span class='NormalFont'>".ErrorSubType($ErrorSubTypeVar)."</span></tr></td>\n";
    foreach ($UserMail_Array as $value) {
      $strRes = $strRes . "<tr><td bgcolor='#CCFFFF'><span class='NormalFont'>".$value."</span></tr></td>\n";
    } 
      $strRes = $strRes . "<tr><td bgcolor='#FFFFCC'><span class='NormalFont'>Mails afectados:".$indice."</span></tr></td>\n";
    $strRes = $strRes . "</table><br>\n";
  }	

  return $strRes;
}
?>