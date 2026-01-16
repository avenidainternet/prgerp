<?php
	session_start(); 

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                      // Expira en fecha pasada 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");        // Siempre página modificada 
    header("Cache-Control: no-cache, must-revalidate");                   // HTTP/1.1 
    header("Pragma: no-cache");  
	date_default_timezone_set("America/Santiago");

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
	$valorUSRef = 0;
	
	if(isset($_POST['valorUFRef'])){
		$valorUFRef = $_POST['valorUFRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUFRef	='".$valorUFRef."'";
		$bd=$link->query($actSQL);
		$link->close();
	}
	if(isset($_POST['valorUSRef'])){
		$valorUSRef = $_POST['valorUSRef'];
		$link=Conectarse();
		$actSQL="UPDATE tablaRegForm SET ";
		$actSQL.="valorUSRef	='".$valorUSRef."'";
		$bd=$link->query($actSQL);
		$link->close();
	}
	
	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$RegIngresos = $result->num_rows; // obtenemos el número de filas
	$link->close();

	if($RegIngresos==0){
		header("Location: ingresocaja.php");
	}else{
		$link=Conectarse();
		$sql = "SELECT * FROM MovGastos";  // sentencia sql
		$result = $link->query($sql);
		$numero = $result->num_rows; // obtenemos el número de filas
		$link->close();
		if($numero==0){
			header("Location: registragastos.php");
		}
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
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
	}
	$fechaHoy = date('Y-m-d');
	$link=Conectarse();
	$bdUf=$link->query("Select * From UF Where fechaUF = '".$fechaHoy."'");
	if($rowUf=mysqli_fetch_array($bdUf)){
		$ValorUF = $rowUf['ValorUF'];
	}
	$valorUFRef = 0;
	$valorUSRef = 0;
	$bdUfRef=$link->query("Select * From tablaRegForm");
	if($rowUfRef=mysqli_fetch_array($bdUfRef)){
		$valorUFRef = $rowUfRef['valorUFRef'];
		$valorUSRef = $rowUfRef['valorUSRef'];
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intranet Simet</title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>
</head>

<body ng-app="myApp" ng-controller="CtrlFacturas">
	<?php include('head.php'); ?> 
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>
				<div class="row">
					<div class="col-2">
						<b>UF Ref.:</b>
					</div>
					<div class="col-3">
						<input type="text" class="form-control" ng-model="valorUFRef">
					</div>
					<div class="col-2">
						<b>US Ref.:</b>
					</div>
					<div class="col-3">
						<input type="text" class="form-control" ng-model="valorUSRef">
					</div>
					<div class="col-2">
						<a ng-click="guardarReferencias()" class="{{bRefClase}}" role="button">{{bGuardaRef}}</a>
					</div>
				</div>
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-address-card" href="../clientes/clientes.php"> Clientes</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-book" href="exportarFacturas.php"> Exportar</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white" style="padding: 20px;">
		<div class="col-4">
			<h4>Total Facturado: {{tFacturadas | number:0 }} </h4>
		</div>
		<div class="col-4">
			<h5>Sin Facturar: {{tSinFacturar | number:0}}</h5>
		</div>
		<div class="col-4">
			<h5>Por Facturar: {{facturasSP | number:0}}</h5>
		</div>
	</div>

	<div ng-show="loading" style="margin-bottom: 20px;"><h2>Cargando Valores...<h2></div>

	<style type="text/css">
		.custom-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.default-color{
		  background-color: light;
		  color 			: black;
		}	
	</style>

	<div class="container-fluid">
		<h3><i class="fas fa-paperclip"></i> Solicitudes de Facturación</h3>
		{{respuesta}}
	  	<table 	class="table table-hover table-bordered table-responsive" 
	  			ng-show="tSolicitudes"
	  			ng-if="Solicitudes.length > 0">
	    	<thead>
	      		<tr class="table-active">
			        <th>N°</th>
			        <th>N° Sol.</th>
			        <th>Fecha Sol.</th>
			        <th>Proyecto</th>
			        <th width="20%">Cliente</th>
			        <th>Fotocopia</th>
			        <th>Factura</th>
			        <th>Bruto</th>
			        <th>Saldo</th>
			        <th>RAM/CAM</th>
			        <th>Acciones</th>
	      		</tr>
	    	</thead>
	    	<tbody>
	      		<tr ng-repeat="Solicitud in Solicitudes | orderBy : ['nFactura','-fechaSolicitud', 'nSolicitud']"
	      			ng-class="{'custom-class': Solicitud.Estado == 'I', 'amarillo-class': Solicitud.Factura == 'on' && Solicitud.pagoFactura == '', 'azul-class': Solicitud.pagoFactura == 'on'}">
	      		    <td><b>{{$index+1}}</b> 		</td>
	      		    <td><b>{{Solicitud.nSolicitud}}</b> 		</td>
			        <td><b>{{Solicitud.fechaSolicitud}}</b> 	</td>
			        <td>{{Solicitud.IdProyecto}} 				</td>
			        <td>{{Solicitud.Cliente}} 					</td>
			        <td>
			        	<div ng-if="Solicitud.fechaFotocopia != '0000-00-00'">{{Solicitud.fechaFotocopia}}
			        	</div>  		
			        </td>
			        <td>
			        	<div ng-if="Solicitud.nFactura > 0">{{Solicitud.nFactura}}</div>
			        </td>
			        <td class="text-center">
			        	<div ng-if="Solicitud.Bruto == 0 && Solicitud.brutoUF == 0 && Solicitud.BrutoUS > 0">
			        		{{Solicitud.BrutoUS | currency:"US$ "}}
			        	</div>
			        	<div ng-if="Solicitud.Bruto == 0 && Solicitud.BrutoUS == 0 && Solicitud.brutoUF > 0">
			        		{{Solicitud.brutoUF | currency:"UF "}}<br>
			        		{{Solicitud.valorUF | currency:"UF "}}
			        	</div>
			        	<div ng-if="Solicitud.Bruto > 0">{{Solicitud.Bruto | currency:"$ ":0}}</div>
			        	<div ng-if="Solicitud.Bruto == 0 && Solicitud.brutoUF == 0 && Solicitud.BrutoUS == 0">
						  <div class="alert alert-danger">
						    <strong>NO VALORIZADO!</strong>
						  </div>
			        		
			        	</div>
			        	
			        </td>
			        <td>
			        	<div ng-if="Solicitud.Saldo > 0">{{Solicitud.Saldo}}</div> 					
			        </td>
			        <td>{{Solicitud.pagoFactura}} 				</td>
			        <td>
<!--			        	
-->
		        		<button type="button" 
		        				ng-disabled = "Solicitud.Bruto == 0 && Solicitud.brutoUF == 0 && Solicitud.BrutoUS == 0"
		        				class="btn btn-light"
		        				data-toggle="modal" 
		        				data-target="#modal_seguimiento" 
		        				ng-click="editarSeguimientoOld(Solicitud.nSolicitud)"> 
		        			<i class="fas fa-project-diagram"></i> 
		        			Seguimiento
		        		</button>
		        		<!--
		        		<button type="button" 
		        				class="btn btn-danger"
		        				data-toggle="modal" 
		        				data-target="#modal_seguimiento" 
		        				ng-click="editarSeguimiento($index)">
		        			<i class="fas fa-project-diagram"></i> 
		        			Seguimiento
		        		</button>
		        		-->
			        	<a 	class="btn btn-warning" role="button"
	        				href="formSolicitaFactura.php?nSolicitud={{Solicitud.nSolicitud}}&RutCli={{Solicitud.RutCli}} "><i class="fas fa-edit"></i> Editar</a>
	        		</td>
	      		</tr>
	    	</tbody>
	  </table>
	</div>


	<!-- Modals -->
	<div class="modal fade" id="modal_seguimiento2">
	    <div class="modal-dialog modal-lg" role="document">
	      	<div class="modal-content">
	      
	        	<!-- Modal Header -->
	        	<div class="modal-header">
	          		<h4 class="modal-title">Seguimiento Solicitud {{nSolicitud}}  </h4>
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	</div>
	        	<div class="modal-footer">
	          		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	          		<a type="button" 
	          				class="btn btn-primary" 
	          				on-click="guardarSolicitud()">
	          				Guardar
	          		</a>
	        	</div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal_seguimiento">
	    <div class="modal-dialog modal-lg" role="document">
	      	<div class="modal-content">
	      
	        	<!-- Modal Header -->
	        	<div class="modal-header">
	          		<h4 class="modal-title">Seguimiento Solicitud {{nSolicitud}}  </h4>
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	</div>
	        
	        	<!-- Modal body -->
	        	<div class="modal-body">
	        		{{Cliente}}
	        		<div class="alert alert-danger" ng-if="errors.length > 0">
	        			{{errors}}
	        		</div>
	        		<div class="row">
	        			<div class="col-3">
	        				<h4>1. Fotocopia</h4>
	        			</div>
	        			<div class="col-3">
	        				<input type="checkbox" ng-model="Fotocopia" ng-change="actSeguimiento()">
	        			</div>
	        			<div class="col-3">
	        			</div>
	        			<div class="col-3">
	        				<input type="date" ng-model="fechaFotocopia">
	        			</div>
	        		</div>
	        		<div class="row">
	        			<div class="col-3">
	        				<h4>2. Factura</h4>
	        			</div>
	        			<div class="col-3">
	        				<input 	type="checkbox" 
	        						ng-model="Factura"  
	        						ng-change="actSeguimiento()">
	        			</div>
	        			<div class="col-3">
	        				<input type="text" ng-model="nFactura">
	        			</div>
	        			<div class="col-3">
	        				<input type="date" ng-model="fechaFactura">
	        			</div>
	        		</div>
	        		<div class="row">
	        			<div class="col-3">
	        				<h4>3. Pagos </h4>
	        			</div>
	        			<div class="col-3">
	        				<input type="checkbox" ng-model="pagoFactura" ng-change="actSeguimiento()">
	        			</div>
	        			<div class="col-3">
	        			</div>
	        			<div class="col-3">
	        				<input type="date" ng-model="fechaPago">
	        			</div>
	        			<div class="col-3" ng-if="brutoUF > 0">
	        				Valor UF Referencial
	        			</div>
	        			<div class="col-3" ng-if="brutoUF > 0">
	        				<input type="type" ng-model="valorUF" ng-change="modiTotales(valorUF)">
	        			</div>
	        			<div class="col-3" ng-if="BrutoUS > 0">
	        				Valor US$ Referencial
	        			</div>
	        			<div class="col-3" ng-if="BrutoUS > 0">
	        				<input type="type" ng-model="valorUS" ng-change="modiTotalesUS(valorUS)">
	        			</div>
	        			<div class="col-3">
	        			</div>
	        			<div class="col-3">
	        			</div>
	        		</div>


	        		<div class="bg-secondary text-white" style="margin: 10px; padding: 5px;"  ng-if="brutoUF > 0">
		        		<div class="row  text-center" >
		        			<div class="col-4">
		        				Neto
		        			</div>
		        			<div class="col-4">
		        				Iva
		        			</div>
		        			<div class="col-4">
		        				Total
		        			</div>
		        		</div>
		        		<div class="row  text-center bg-light text-dark" >
		        			<div class="col-4">
		        				{{netoUF | currency:"UF "}}
		        			</div>
		        			<div class="col-4">
		        				{{ivaUF | currency:"UF "}}
		        			</div>
		        			<div class="col-4">
		        				{{brutoUF | currency:"UF "}}
		        			</div>
		        		</div>
		        		<div class="row  text-center bg-light text-dark" >
		        			<div class="col-4">
		        				{{Neto | currency:"$ ":0}}
		        			</div>
		        			<div class="col-4">
		        				{{Iva | currency:"$ ":0}}
		        			</div>
		        			<div class="col-4">
		        				{{Bruto | currency:"$ ":0}}
		        			</div>
		        		</div>
		        	</div>

	        		<div class="bg-secondary text-white" style="margin: 10px; padding: 5px;"  ng-if="BrutoUS > 0">
		        		<div class="row  text-center" >
		        			<div class="col-4">
		        				Neto
		        			</div>
		        			<div class="col-4">
		        				Iva
		        			</div>
		        			<div class="col-4">
		        				Total
		        			</div>
		        		</div>
		        		<div class="row  text-center bg-light text-dark" >
		        			<div class="col-4">
		        				{{NetoUS | currency:"US$ "}}
		        			</div>
		        			<div class="col-4">
		        				{{IvaUS | currency:"US$ "}}
		        			</div>
		        			<div class="col-4">
		        				{{BrutoUS | currency:"US$ "}}
		        			</div>
		        		</div>
		        		<div class="row  text-center bg-light text-dark" >
		        			<div class="col-4">
		        				{{Neto | currency:"$ ":0}}
		        			</div>
		        			<div class="col-4">
		        				{{Iva | currency:"$ ":0}}
		        			</div>
		        			<div class="col-4">
		        				{{Bruto | currency:"$ ":0}}
		        			</div>
		        		</div>
		        	</div>

	        		<div class="bg-info text-white" style="margin: 10px; padding: 5px;">
		        		<div class="row  text-center" >
		        			<div class="col-2">
		        				Facturado
		        			</div>
		        			<div class="col-2">
		        				Último Abono
		        			</div>
		        			<div class="col-3">
		        				Fecha Pago
		        			</div>
		        			<div class="col-3">
		        				Abono
		        			</div>
		        			<div class="col-2">
		        				Saldo
		        			</div>
		        		</div>
		        	</div>
	        		<div class="bg-light text-dark" style="margin: 10px; padding: 5px;">
		        		<div class="row text-center">
		        			<div class="col-2">
		        				{{Bruto | currency:"$ ":0}}
		        			</div>
		        			<div class="col-2">
		        				{{Abono | currency:"$ ":0}}
		        			</div>
		        			<div class="col-3">
		        				<input type="date" ng-modal="fechaTransaccion" class="form-control">
		        				
		        			</div>
		        			<div class="col-3">
		        				<input 	type="text"
		        						ng-modal="montoAbonar"
		        						class="form-control">
		        			</div>
		        			<div class="col-2">
		        				{{Saldo | currency:"$ ":0}}<br> {{Saldo - montoAbonar}}
		        			</div>
		        		</div>
	        		</div>
	        		<div class="row">
	        			<div class="col-4">
	        				<h4>4. Transferencia</h4>
	        			</div>
	        			<div class="col-2">
	        				<input 	type="checkbox" 
	        						ng-model="Transferencia"  
	        						ng-change="actSeguimiento()">
	        			</div>
	        			<div class="col-2">
	        			</div>
	        			<div class="col-4">
	        				<input type="date" ng-model="fechaTransferencia">
	        			</div>
	        		</div>
	        	</div>
	        
	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	          		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	          		<button type="button" 
	          				class="btn btn-primary" 
	          				on-click="guardarSolicitud()">
	          				Guardar
	          		</button>
	          		{{resSol}}
	        	</div>
     
	      	</div>
	    </div>
	</div>


	<!-- Modals -->


	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>

	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../datatables/datatables.min.js"></script>
	<?php //include_once('solicitudesFacturas.php'); ?> 

	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>
	<script src="facturacion.js"></script>

	
</body>
</html>
