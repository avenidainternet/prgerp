<?php
										$fechaTermino 	= strtotime ( '+'.$row['dHabiles'].' day' , strtotime ( $row['fechaInicio'] ) );
										$fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
										
										$ft = $row['fechaInicio'];
										if($row['horaPAM'] >= '12:00'){
											$dh	= $row['dHabiles'];
										}else{
											$dh	= $row['dHabiles']-1;
										}
										$dd	= 0;
										$cDias = 0;
										for($i=1; $i<=$dh; $i++){
											$ft	= strtotime ( '+'.$i.' day' , strtotime ( $row['fechaInicio'] ) );
											$ft	= date ( 'Y-m-d' , $ft );
											$dia_semana = date("w",strtotime($ft));
											if($dia_semana == 0 or $dia_semana == 6){
												$dh++;
												$dd++;
											}else{
												$cDias++;
											}
										}
?>