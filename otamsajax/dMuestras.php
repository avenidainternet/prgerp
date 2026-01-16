<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	

				<?php
					include_once("conexion.php");
					$nFicha = 0;
					$firstRAM = 0;
					$link=Conectarse();
					$bdCot=mysql_query("SELECT * FROM cotizaciones Where RAM > 0 and Estado = 'P' and Archivo != 'on' and Eliminado != 'on'");
					
					if($rowCot=mysql_fetch_array($bdCot)){
						do{
							if($firstRAM == 0){
								$firstRAM = $rowCot['RAM'];
							}
							?>
							<tr class="table-light text-dark">
								<td>
									<?php 
										echo $rowCot['RAM'];
									?>
								</td>
								<td>
									<?php 
									$bdCli=mysql_query("SELECT * FROM clientes Where RutCli = '".$rowCot['RutCli']."'");
									if($rowCli=mysql_fetch_array($bdCli)){
										echo $rowCli['Cliente'];
									}								
									?>
								</td>
								<td>
									<?php
									$bdCli=mysql_query("SELECT * FROM formram Where RAM = '".$rowCot['RAM']."'");
									if($rowCli=mysql_fetch_array($bdCli)){
										echo '<a class="btn btn-info" role="button" href="pOtams.php?RAM='.$rowCot['RAM'].'&CAM='.$rowCot['CAM'].'"	>Ver	</a>';
									}else{
										echo '<a class="btn btn-danger" role="button" href="pOtams.php?RAM='.$rowCot['RAM'].'&CAM='.$rowCot['CAM'].'"	>Crear	</a>';
									}
									?>
								</td>

							</tr>
						<?php
						}while($rowCot=mysql_fetch_array($bdCot));
					}
					mysql_close($link);
				?>
