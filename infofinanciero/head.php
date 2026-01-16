<nav class="navbar navbar-expand-sm bg-dark navbar-dark degradadoNegro">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    <!-- <img src="../imagenes/simet.png" alt="logo" style="width:100px; height: 50px;"> -->
    <img src="../imagenes/simet.png" alt="logo" width="70%">
  </a>
  <h6 class="text-white-50 bg-dar">Servicio de Ingeniería Metalúrgica y Materiales</h6> 
    <span class="text-white-50 bg-dar">(Informe Finianciero 2.0)</span>
</nav>
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<?php
	        			$dBuscado = '';
						if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
						if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}

	        			//if($dBuscado){
							$link=Conectarse();
							$bdPer=$link->query("SELECT * FROM Clientes Where Cliente Like '%".$dBuscado."%' or RutCli = '".$dBuscado."'");
							if ($rowP=mysqli_fetch_array($bdPer)){
								$RutCli = $rowP['RutCli'];
								}
							$link->close();
	        				?>
			        		<li class="nav-item">
			          			<a class="nav-link fas fa-print" href="formularios/estadoCuenta.php?RutCli={{RutCli}}&Contacto={{Contacto}}"> General</a>
			        		</li>
			        		<li class="nav-item">
			          			<a class="nav-link fas fa-print" href="formularios/estadoCuentaParcial.php?RutCli={{RutCli}}&Contacto={{Contacto}}"> Facturas</a>
			        		</li>
			        		<li class="nav-item">
			          			<a class="nav-link fas fa-print" href="formularios/estadoCuentaSolicitudes.php?RutCli={{RutCli}}&Contacto={{Contacto}}"> Solicitudes</a>
			        		</li>
			        		<li class="nav-item">
			          			<a class="nav-link fas fa-print" href="formularios/estadoCuentaSinOC.php?RutCli={{RutCli}}&Contacto={{Contacto}}"> Sin OC</a>
			        		</li>
			        		<li class="nav-item">
			          			<a class="nav-link fas fa-print" href="formularios/estadoCuentaEnProceso.php?RutCli={{RutCli}}&Contacto={{Contacto}}"> En Proceso</a>
			        		</li>
	        				<?php
	        			//}
	        		?>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>

<!--


	<table width="100%" height="74"  border="0" align="center" cellpadding="0" cellspacing="0" class="degradadoNegro" style="opacity:0.9;">
  		<tr>
    		<td width="8%"><div align="center"><img src="../imagenes/simet.png" width="119" height="58"></div></td>
    		<td width="86%"> 
				<div align="center" class="titulos" style="opacity:1;">
      				<div align="left" class="titulo">
        				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	          				<tr>
	            				<td colspan="2">&nbsp;</td>
	          				</tr>
	          				<tr>
	            				<td colspan="2">Servicio de Ingeniería Metalúrgica y Materiales </td>
	          				</tr>
	          				<tr>
    	        				<td>
								    <?php if(isset($_SESSION['usuario'])){ ?>
										<div align="right">
											<span class="txtusr">Usuario: 	<?php echo $_SESSION['usuario']; ?>	- </span> 
											<span class="txtusr">			<?php echo $_SESSION['Perfil']; ?>	  </span>
										</div>									<?php } ?>								
								</td>
	            				<td width="2%">&nbsp;</td>
	          				</tr>
	        			</table>
	      			</div>
    			</div>
			</td>
    		<td width="6%"><div align="left"><img src="../imagenes/Logo-Color-Usach-Web-Ch.png"></div></td>
  		</tr>
	</table>
-->