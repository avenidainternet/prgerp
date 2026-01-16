<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}
	
	$ValorUF  = 0;
	
	if(isset($_POST['valorUFRef'])){
		$valorUFRef = $_POST['valorUFRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUFRef	='".$valorUFRef."'";
		$bd=$link->query($actSQL);
		$link->close();
	}
	

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	$fechaHoy = date('Y-m-d');
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8"> 
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">



</head>

<body>
<body ng-app="myApp" ng-controller="CtrlFinanzas">
	<?php include('head.php'); ?>
	<div class="row p-2 bg-primary text-white">
		<div class="col">
			Mes
		</div>
		<div class="col">
			Año
		</div>
		<div class="col">
			RUT / Cliente
		</div>
		<div class="col">
			Contacto
		</div>
	</div>
	<div class="row p-2 bg-primary text-white">
		<div class="col">
			<select class     = "form-control"
                      ng-model  = "MesFiltro" 
                      ng-options  = "MesFiltro.codMes as MesFiltro.descripcion for MesFiltro in Meses" >
                <option value="E">{{MesFiltro}}</option>
            </select>
		</div>
		<div class="col">
			<select class     = "form-control"
					  ng-model  = "AgnosFiltro" 
					  ng-options  = "AgnosFiltro.codAgno as AgnosFiltro.descripcion for AgnosFiltro in Agnos" >
				<option value="E">{{AgnosFiltro}}</option>
			</select>
		</div>
		<div class="col">
			<select ng-model="Cliente" class="form-control" ng-change="cargarContactos()" required>
	            <option value="">Selecionar Cliente</option>
	            <option ng-repeat="cli in dataClientes | filter: bCliente" value="{{cli.Cliente}}">
	            {{cli.Cliente}} {{cli.nSolicitud}}
	            </option>
	        </select>
		</div>
		<div class="col">
			<select ng-model="Contacto" class="form-control" ng-change="leerDatosFacturas(Cliente, Contacto)" required>
	            <option ng-repeat="cl in dataContactos">{{cl.Contacto}}</option>
	        </select>
		</div>
	</div>
	<div ng-show="enProceso">
		<img src="../imagenes/ajax-loader.gif"> MOMENTO PROCESOANDO DATOS...
	</div>
	<div class="container-xxl" ng-show="tablaFacturas">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th scope="col">Fecha CAM</th>
					<th scope="col">Nº Sol.</th>
					<th scope="col">Factura</th>
					<th scope="col">OC</th>
					<th scope="col">HES</th>
					<th scope="col">Contactos</th>
					<th scope="col">CAM/RAM</th>
					<th scope="col">Informes</th>
					<th scope="col">Total</th>
					<th scope="col">Estado</th>
					<th scope="col">Pago</th>
					<th scope="col">Saldo</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="x in dataFacturas">
					<th scope="row"> {{x.fechaCotizacion}} </th>
					<td> {{x.nSolicitud}} </td>
					<td> {{x.nFactura}} </td>
					<td> {{x.nOC}}</td>
					<td> {{x.HES}}</td>
					<td> {{x.nContacto}} {{x.nomContacto}} </td>
					<td> {{x.CAM}}/{{x.RAM}}</td>
					<td> {{x.infoNumero}} / {{x.infoSubidos}}</td>
					<td> 
						<div ng-if="x.brutoUF > 0">
							UF {{x.brutoUF}}
						</div>
						<div ng-if="x.Bruto > 0">
							$ {{x.Bruto}}
						</div>
					</td>
					<td> {{x.Estado}}</td>
					<td> 
						<div ng-if="x.Saldo == 0">
							{{x.fechaPago}}
						</div>
					</td>
					<td>{{x.Saldo}}</td>
				</tr>
			</tbody>
		</table>
	</div>















<!--
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<?php //include_once('muestraInforme.php'); ?> 
		</div>
		<div style="clear:both;"></div>		
	</div>
	<br>
-->
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> 
	<script src="infofinanciero.js"></script>

	
</body>
</html>
