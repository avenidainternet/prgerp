<?php
	echo 'IP del Server: <b>'.$_SERVER[SERVER_ADDR].'</b><br>';
	echo 'Nombre Server: <b>'.$_SERVER[SERVER_NAME].'</b><br>';
	echo 'Ubicación Server: <b>'.$_SERVER[DOCUMENT_ROOT].'</b><br>';
	echo 'Tu IP: <b>'.$_SERVER[REMOTE_ADDR].'</b><br>';
	echo 'PC: <b>'.gethostbyaddr($_SERVER[REMOTE_ADDR]).'</b><br>';
	echo 'PC: <b>'.php_uname('n').'</b><br>';
	
					$indOld = array(	
						1 	=> 0, 
						2	=> 0,
						3 	=> 0,
						4 	=> 0,
						5 	=> 0,
						6 	=> 0,
						7 	=> 0,
						8 	=> 0,
						9	=> 0,
						10 	=> 0,
						11 	=> 0,
						12	=> 0
					);
					$indOld[1]++;
					$indOld[1]++;
					echo $indOld[1];
					$fdInicial = 8;
					$fd = 10;
					for($i=$fdInicial; $i<=$fd; $i++){
						echo $i;
					}
	
?>
