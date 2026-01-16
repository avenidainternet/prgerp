<?
require_once("funcions.php");

// Inicializamos variables
$Arxiu = "";
$strRes = "";
$UserMail = "";
$UserMail_Array_1 = array();
$UserMail_Array_2 = array();
$UserMail_Array_3 = array();
$UserMail_Array_4 = array();
$UserMail_Array_5 = array();
$UserMail_Array_6 = array();
$UserMail_Array_7 = array();
$UserMail_Array_8 = array();
$UserMail_Array_9 = array();
$UserMail_Array_10 = array();
$UserMail_Array_11 = array();
$UserMail_Array_12 = array();
$UserMail_Array_13 = array();
$UserMail_Array_14 = array();
$UserMail_Array_15 = array();
$indice_1 = 0;
$indice_2 = 0;
$indice_3 = 0;
$indice_4 = 0;
$indice_5 = 0;
$indice_6 = 0;
$indice_7 = 0;
$indice_8 = 0;
$indice_9 = 0;
$indice_10 = 0;
$indice_11 = 0;
$indice_12 = 0;
$indice_13 = 0;
$indice_14 = 0;
$indice_15 = 0;
$num_linies = 0;
$num_linies_nok = 0;
$num_linies_ok = 0;
$mails_rebotats= 0;
$marca = 0;

// Definimos Fichero entrada
$Arxiu = "/var/www/cemnews/bounce/eml/xaj";

// Controlamos que exista Fichero entrada
if (file_exists($Arxiu)) {
    echo "<span class='NormalFont'>Fichero: $Arxiu. Existe, se procederá a analizar<br><br></span>";
	$ExisteFichero = 1;
} else {
    echo "<span class='NormalFont'>Fichero: $Arxiu. No existe. Abortamos programa<br><br></span>";
	$ExisteFichero = 0;
}

// Control Existe Fichero. Si no existe no realizamos obertura fichero ni tareas de busqueda 
if ($ExisteFichero==1) {
  // Abrimos Fichero de lectura
  $ArxiuMail = fopen ($Arxiu, "r");
 
  // Recorremos Fichero
  while (!feof ($ArxiuMail)) {
    $num_linies++;   // Incrementamos contador de numero de lineas Fichero Entrada

    // Cargamos cada linia del fichero en una posicion de un array
    $line = fgets($ArxiuMail);

    // Un correo empieza si si encuentra la cabecera  'From MAILER-DAEMON'
    if (substr($line,0,18)=="From MAILER-DAEMON") {  
      $marca = 1;
      $mails_rebotats++;
    }

    // Recortamos la linia para extraer la direccion el correo electronico
    if ($marca==1) {
      if ( (substr($line,0,1)=="<") || (substr($line,0,1)=="@") ){  
  	    $marca = 2;
  	    $recorte = split("<",$line); 
  	    $recorte2 = split(">",$recorte[1]);	  
 	    $UserMail = $recorte2[0];
      }
    }

    // Control Errores correo
    if ($marca==2) {   
           if(    stristr($line, 'no such address')!==FALSE
               || stristr($line, 'Recipient address rejected')!==FALSE
               || stristr($line, 'User unknown in virtual alias table')!==FALSE ) {
			     // 5.1.1
				 $UserMail_Array_1[$indice_1] = $UserMail;
				 $indice_1++;
	             $marca = 0;
			} else if (stristr($line, 'unrouteable mail domain')!==FALSE
				 || stristr($line, 'Esta casilla ha expirado por falta de uso')!==FALSE){
				 // 5.1.2
				 $UserMail_Array_2[$indice_2] = $UserMail;
				 $indice_2++;
	             $marca = 0;
			} else if (stristr($line, 'mailbox is full')!==FALSE
				||  stristr($line, 'Mailbox quota usage exceeded')!==FALSE
				||  stristr($line, 'User mailbox exceeds allowed size')!==FALSE){
				 // 4.2.2
				 $UserMail_Array_3[$indice_3] = $UserMail;
				 $indice_3++;
	             $marca = 0;
			} else if (stristr($line, 'not yet been delivered')!==FALSE){
				 // 4.2.0
				 $UserMail_Array_4[$indice_4] = $UserMail;
				 $indice_4++;
	             $marca = 0;
			} else if (stristr($line, 'mailbox unavailable')!==FALSE){
				 // 5.2.0
				 $UserMail_Array_5[$indice_5] = $UserMail;
				 $indice_5++;
	             $marca = 0;
			} else if (stristr($line, 'Unrouteable address')!==FALSE){
				 // 5.4.4
				 $UserMail_Array_6[$indice_6] = $UserMail;
				 $indice_6++;
	             $marca = 0;
			} else if (stristr($line, 'retry timeout exceeded')!==FALSE){
				 // 4.4.7
				 $UserMail_Array_7[$indice_7] = $UserMail;
				 $indice_7++;
	             $marca = 0;
			} else if (stristr($line, 'The account or domain may not exist, they may be blacklisted, or missing the proper dns entries.')!==FALSE
			     || stristr($line, 'Account disabled')!==FALSE ){
				 // 5.2.0
				 $UserMail_Array_8[$indice_8] = $UserMail;
				 $indice_8++;
	             $marca = 0;
			} else if (stristr($line, '554 TRANSACTION FAILED')!==FALSE){
				 // 5.5.4
				 $UserMail_Array_9[$indice_9] = $UserMail;
				 $indice_9++;
	             $marca = 0;
			} else if (stristr($line, 'Status: 4.4.1')!==FALSE
				 || stristr($line, 'delivery temporarily suspended')!==FALSE){
				 // 4.4.1
				 $UserMail_Array_10[$indice_10] = $UserMail;
				 $indice_10++;
	             $marca = 0;
			} else if (stristr($line, '550 OU-002')!==FALSE
				 || stristr($line, 'Mail rejected by Windows Live Hotmail for policy reasons')!==FALSE){
				 // 5.5.0
				 $UserMail_Array_11[$indice_11] = $UserMail;
				 $indice_11++;
	             $marca = 0;
			} else if (stristr($line, 'PERM_FAILURE: DNS Error: Domain name not found')!==FALSE
   			     || strstr ($line, '550 5.1.2')!==FALSE){
				 // 5.1.2
				 $UserMail_Array_12[$indice_12] = $UserMail;
				 $indice_12++;
	             $marca = 0;
			} else if (stristr($line, 'Delivery attempts will continue to be made for')!==FALSE){
				 // 4.2.0
				 $UserMail_Array_13[$indice_13] = $UserMail;
				 $indice_13++;
	             $marca = 0;
			} else if (stristr($line, '554 delivery error:')!==FALSE){
				 // 5.5.4
				 $UserMail_Array_14[$indice_14] = $UserMail;
				 $indice_14++;
	             $marca = 0;
			} else if (strstr ($line, '550-5.1.1')!==FALSE
			     || strstr ($line, '550 5.1.1')!==FALSE
				 || stristr($line, 'This Gmail user does not exist.')!==FALSE){
				 // 5.1.1
				 $UserMail_Array_15[$indice_15] = $UserMail;
				 $indice_15++;
	             $marca = 0;
			}
    }
  } 

  // Cerramos Fichero de lectura
  fclose($ArxiuMail);

  // Pintamos resultados
  $strRes = $strRes . PintaTaulaRes("1","5.1.1",$UserMail_Array_1,$indice_1);
  $strRes = $strRes . PintaTaulaRes("1","5.1.1",$UserMail_Array_15,$indice_15);
  $strRes = $strRes . PintaTaulaRes("1","5.1.2",$UserMail_Array_2,$indice_2);
  $strRes = $strRes . PintaTaulaRes("1","5.1.2",$UserMail_Array_12,$indice_12);
  $strRes = $strRes . PintaTaulaRes("1","5.2.0",$UserMail_Array_5,$indice_5);
  $strRes = $strRes . PintaTaulaRes("1","5.2.0",$UserMail_Array_8,$indice_8);
  $strRes = $strRes . PintaTaulaRes("1","5.4.4",$UserMail_Array_6,$indice_6);
  $strRes = $strRes . PintaTaulaRes("1","5.5.0",$UserMail_Array_11,$indice_11);
  $strRes = $strRes . PintaTaulaRes("1","5.5.4",$UserMail_Array_9,$indice_9);
  $strRes = $strRes . PintaTaulaRes("1","5.5.4",$UserMail_Array_14,$indice_14);
  $strRes = $strRes . PintaTaulaRes("2","4.2.0",$UserMail_Array_4,$indice_4);
  $strRes = $strRes . PintaTaulaRes("2","4.2.0",$UserMail_Array_13,$indice_13);
  $strRes = $strRes . PintaTaulaRes("2","4.2.2",$UserMail_Array_3,$indice_3);
  $strRes = $strRes . PintaTaulaRes("2","4.4.1",$UserMail_Array_10,$indice_10);
  $strRes = $strRes . PintaTaulaRes("2","4.4.7",$UserMail_Array_7,$indice_7);

  // Mostramos resumen
  $strRes = $strRes . "<span class='NormalFont'>"."Fichero analizado: ".$Arxiu."</span>";
  $strRes = $strRes . "<br><span class='NormalFont'>"."mails rebotats: ".$mails_rebotats."</span>";
  $strRes = $strRes . "<br><span class='NormalFont'>"."Num Linies total arxiu: ".$num_linies."</span>";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Control errores mails rebotados</title>
  <style>
  .NormalFont {
     font-family:Verdana, Arial, Helvetica, sans-serif;
	 font-size:10px;
	 color:#000000;
  }
  </style>
</head>

<body>
<?  echo $strRes; ?>
</body>
</html>



