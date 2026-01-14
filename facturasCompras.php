<?php
	session_start(); 
	include_once("conexionli.php");


	if(isset($_GET['IdProyecto'])) 		{	$IdProyecto = $_GET['IdProyecto']; 		}
	if(isset($_GET['mesCpra'])) 		{	$mesCpra 	= $_GET['mesCpra']; 		}
	if(isset($_GET['ageCpra'])) 		{	$ageCpra 	= $_GET['ageCpra']; 		}
	if(isset($_GET['periodo'])) 		{	$periodo 	= $_GET['periodo']; 		}
		
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}
	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/libs/1/jquery.min.js"></script>
<!--		
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
-->
	<link rel="stylesheet" type="text/css" href="cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="datatables/datatables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
</head>

<body ng-app="myApp" ng-controller="myCtrl">
	<?php include_once('head.php');	?>
	<div id="linea"></div>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-download" href="exportarEfectivo.php?IdProyecto=<?php echo $IdProyecto; ?>&ageCpra=<?php echo $ageCpra; ?>&mesCpra=<?php echo $mesCpra; ?>"> Descargar</a>
	        		</li>

	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
	
	<table id="FacCompras" class="display table table-dark table-hover" style="width:100%">
		<thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Efectivo</th>
                <th>Factura</th>
                <th>Neto</th>
                <th>Iva</th>
                <th>Bruto</th>
                <th>Solicitud</th>
                <th>Reembolso</th>
            </tr>
        </thead>
        <tbody>
        <?php
        	$opciones = '';
        	if(!$opciones){
	        	if(isset($IdProyecto)){ 
	        		$opciones = "IdProyecto = '$IdProyecto'";	
			        if(isset($mesCpra))	{ $opciones .= " and month(FechaGasto) = '$mesCpra'"; }
			        if($ageCpra)	{ $opciones .= " and year(FechaGasto) = '$ageCpra'"; }
	        	}elseif(isset($mesCpra)){ 
					    if($mesCpra)	{ $opciones = " month(FechaGasto) = '$mesCpra'"; 	 }
					    if($ageCpra)	{ $opciones .= " and year(FechaGasto) = '$ageCpra'"; }
				}elseif(isset($ageCpra)){ $opciones = " year(FechaGasto) = '$ageCpra'"; }
        	}
        	$i = 0;
        	$sIva = 0;
  			$link=Conectarse();
        	$sql = "SELECT * FROM movgastos WHERE TpDoc = 'F' and Iva > 0 and $opciones";
        	//echo $sql;
			$bd  = $link->query($sql);
			while($row=mysqli_fetch_array($bd)){
				$i++;
				$sIva += $row['Iva'];
				$class = "table-ligh text-dark";
				if($row['fechaReembolso'] != '0000-00-00'){
					$class = "table-success text-dark";
				}
				?>
				<tr class="<?php echo $class; ?>">
					<td><?php echo $i; ?></td>
					<td>
						<?php 
							$fd = explode('-',$row['FechaGasto']);
							echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
						?>
					</td>
					<td><?php echo $row['Proveedor']; ?></td>
					<td>
						<?php 
							$ve = 'No';
							if($row['efectivo'] == 'on'){?>
								<button type="button" class="btn btn-success" 
								ng-click="cambiaropcion(<?php echo $row['nGasto']; ?>)">Si</button>
								<?php
							}else{?>
								<button type="button" class="btn btn-secondary" 
								ng-click="cambiaropcion(<?php echo $row['nGasto']; ?>)">No</button>
								<?php
							}
						?>
						
						{{res}}

					</td>
					<td><?php echo $row['nDoc']; ?></td>
					<td><?php echo number_format($row['Neto'], 0, ',', '.'); ?></td>
					<td><b>
						<?php 
							echo number_format($row['Iva'], 0, ',', '.'); 
							if($row['efectivo'] == 'on'){?>
								<div class="far fa-check-square"></div>
								<?php
							}
						?>
						</b>
					</td>
					<td><?php echo number_format($row['Bruto'], 0, ',', '.'); ?></td>
					<td>
						<?php 
							if($row['FechaInforme'] != '0000-00-00'){
								$fd = explode('-',$row['FechaInforme']);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
							}
						?>
					</td>
					<td>
						<b>
						<?php 
							if($row['fechaReembolso'] != '0000-00-00'){
								$fd = explode('-',$row['fechaReembolso']);
								echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
							}
						?>
						</b>
					</td>
				</tr>
				<?php
			}
			$link->close();
        ?>
        </tbody>
		<tfoot>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Factura</th>
                <th>Neto</th>
                <th><?php echo number_format($sIva, 0, ',', '.'); ?></th>
                <th>Bruto</th>
                <th>Solicitud</th>
                <th>Reembolso</th>
            </tr>
        </tfoot>

	</table>

	<div style="clear:both; "></div>

	<script src="jquery/jquery-3.3.1.js"></script>
	<script src="datatables/datatables.min.js"></script>
	<script src="jsboot/bootstrap.min.js"></script>	

	<script type="text/javascript" src="angular/angular.js"></script>

	<script>
		$(document).ready(function() {
		    $('#FacCompras').DataTable( {
				"lengthMenu": [[-1,10, 25, 50], ["Todas",10, 25, 50]],
		        "order": [[ 1, "asc" ]],
				"language": {
					            "lengthMenu": "Mostrar _MENU_ Reg. por Página",
					            "zeroRecords": "Nothing found - sorry",
					            "info": "Mostrando Pág. _PAGE_ de _PAGES_",
					            "infoEmpty": "No records available",
					            "infoFiltered": "(de _MAX_ tot. Reg.)",
					            "loadingRecords": "Cargando...",
					            "search":         "Buscar:",
								"paginate": {
								        "first":      "Ultimo",
								        "last":       "Anterior",
								        "next":       "Siguiente",
								        "previous":   "Anterior"
								    },        		
								}
		    } );
		} );
	</script>

	<script>
		var app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {
	  		$scope.cambiaropcion = function(ve){
	            $http.post('modelo.php',{nGasto:ve})
	            .then(function (res) {
		  			window.location.reload();
	            });
	  		}
		});
	</script>

</body>
</html>
