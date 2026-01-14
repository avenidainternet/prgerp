			if($rowCAM[oCtaCte] == 'on'){
			
				$bdCAM=mysql_query("SELECT * FROM Cotizaciones Where CAM = '".$CAM."' Order By Rev Asc");
				if($rowCAM=mysql_fetch_array($bdCAM)){
					do{
						$RAM 			 = $rowCAM[RAM];
						$Rev 			 = $rowCAM[Rev];
						$fechaCotizacion = $rowCAM[fechaCotizacion];
						$usrCotizador	 = $rowCAM[usrCotizador];
						$Cliente 		 = $rowCAM[RutCli];
						$Atencion 		 = $rowCAM[Atencion];
						$correoAtencion  = $rowCAM[correoAtencion];
						$Descripcion	 = $rowCAM[Descripcion];
						$Observacion	 = $rowCAM[Observacion];
						$obsServicios	 = $rowCAM[obsServicios];
						$EstadoCot		 = $rowCAM[Estado];
						$Validez		 = $rowCAM[Validez];
						$dHabiles		 = $rowCAM[dHabiles];
						$fechaAceptacion = $rowCAM[fechaAceptacion];
						$oCompra		 = $rowCAM[oCompra];
						$oMail			 = $rowCAM[oMail];
						$oCtaCte		 = $rowCAM[oCtaCte];
						$nOC			 = $rowCAM[nOC];
						$enviadoCorreo	 = $rowCAM[enviadoCorreo];
						$pDescuento	 	 = $rowCAM[pDescuento];
						$fechaEnvio		 = $rowCAM[fechaEnvio];
						
						if($rowCAM[Rev] == $Rev){
							$RAM 			 = $rowCAM[RAM];
							$Rev 			 = $rowCAM[Rev];
							$fechaCotizacion = $rowCAM[fechaCotizacion];
							$usrCotizador	 = $rowCAM[usrCotizador];
							$Cliente 		 = $rowCAM[RutCli];
							$Atencion 		 = $rowCAM[Atencion];
							$correoAtencion  = $rowCAM[correoAtencion];
							$Descripcion	 = $rowCAM[Descripcion];
							$Observacion	 = $rowCAM[Observacion];
							$obsServicios	 = $rowCAM[obsServicios];
							$EstadoCot		 = $rowCAM[Estado];
							$Validez		 = $rowCAM[Validez];
							$dHabiles		 = $rowCAM[dHabiles];
							$fechaAceptacion = $rowCAM[fechaAceptacion];
							$oCompra		 = $rowCAM[oCompra];
							$oMail			 = $rowCAM[oMail];
							$oCtaCte		 = $rowCAM[oCtaCte];
							$nOC			 = $rowCAM[nOC];
							$enviadoCorreo	 = $rowCAM[enviadoCorreo];
							$pDescuento	 	 = $rowCAM[pDescuento];
							$fechaEnvio		 = $rowCAM[fechaEnvio];
						}
					}while ($rowCAM=mysql_fetch_array($bdCAM));
				}
				
			}else{
