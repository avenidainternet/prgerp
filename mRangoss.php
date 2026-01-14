<?php
	include("../conexion.php");
	$link=Conectarse();

		$sql = "DROP TABLE movProc";
		$bd=mysql_query($sql);

		$sql = 'CREATE TABLE  movProc  (
									   fechaProc  		varchar(7) 		NOT NULL,
									   enProceso  		decimal(12,2) 	NOT NULL,
									   noFacturado 		decimal(12,2)	NOT NULL,
									   sinInforme  		decimal(12,2)	NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=mysql_query($sql);

	$bdCot  = mysql_query("SELECT * FROM Cotizaciones Where RAM > 0 and Estado != 'C' and Estado != 'N' and Estado != 'E' and fechaInicio < fechaTermino Order By fechaInicio Asc");
	if($rowCot=mysql_fetch_array($bdCot)){
		do{
			$fd = explode('-',$rowCot['fechaInicio']);
			$ft = explode('-',$rowCot['fechaTermino']);
			$fechaProc = $fd[1].'.'.$fd[0];
			$bdProc  = mysql_query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
			if($rowProc=mysql_fetch_array($bdProc)){
				$enProceso 	= $rowProc['enProceso'];
				$enProceso	+= $rowCot['NetoUF'];
				echo $fechaProc.' '.$NetoUF.'<br>';
				$actSQL="UPDATE movProc SET ";
				$actSQL.="enProceso			= '".$enProceso."'";
				$actSQL.="WHERE fechaProc 	= '".$fechaProc."'";
				$bdProc=mysql_query($actSQL);

				if($ft[1] > $fd[1]){
					$fechaProc = $ft[1].'.'.$ft[0];
					$bdProc  = mysql_query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
					if($rowProc=mysql_fetch_array($bdProc)){
						$enProceso 	= $rowProc['enProceso'];
						$enProceso	+= $rowCot['NetoUF'];
						echo $fechaProc.' '.$NetoUF.'<br>';
						$actSQL="UPDATE movProc SET ";
						$actSQL.="enProceso			= '".$enProceso."'";
						$actSQL.="WHERE fechaProc 	= '".$fechaProc."'";
						$bdProc=mysql_query($actSQL);
					}else{
						$NetoUF		= $rowCot['NetoUF'];
						mysql_query("insert into movProc(	fechaProc,
															enProceso
														) 
											values 		(	'$fechaProc',
															'$NetoUF'
														)",$link);
					}
				}

			}else{
				$NetoUF		= $rowCot['NetoUF'];
				mysql_query("insert into movProc(	fechaProc,
													enProceso
												) 
									values 		(	'$fechaProc',
													'$NetoUF'
												)",$link);
			}

			if($ft[1] > $fd[1]){
				$fechaProc = $ft[1].'.'.$ft[0];
				$bdProc  = mysql_query("SELECT * FROM movProc Where fechaProc = '".$fechaProc."'");
				if($rowProc=mysql_fetch_array($bdProc)){
					$enProceso 	= $rowProc['enProceso'];
					$enProceso	+= $rowCot['NetoUF'];
					$actSQL="UPDATE movProc SET ";
					$actSQL.="enProceso			= '".$enProceso."'";
					$actSQL.="WHERE fechaProc 	= '".$fechaProc."'";
					$bdProc=mysql_query($actSQL);
				}else{
					$NetoUF		= $rowCot['NetoUF'];
					mysql_query("insert into movProc(	fechaProc,
														enProceso
													) 
										values 		(	'$fechaProc',
														'$NetoUF'
													)",$link);
				}
			}

		}while ($rowCot=mysql_fetch_array($bdCot));
	}
		
	mysql_close($link);
	
?>