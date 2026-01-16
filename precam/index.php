<?php
	session_start();
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	$dias = array(
		0 => 'Domingo', 
		1 => 'Lunes', 
		2 => 'Martes',
		3 => 'Miércoles',
		4 => 'Jueves',
		5 => 'Viernes',
		6 => 'Sábado'
	);

	 


















	// Old
	$idPreCAM = '';
	if(isset($_GET['idPreCAM'])){
		$idPreCAM = $_GET['idPreCAM'];
	} 

	if(isset($_GET['fechaSigSemana'])){ 
		$_SESSION['fechaSigSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaAntSemana'] = $_GET['fechaSigSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaSigSemana']);
	}
	if(isset($_GET['fechaAntSemana'])){ 
		$_SESSION['fechaAntSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaSigSemana'] = $_GET['fechaAntSemana'];
		$_SESSION['fechaHoy'] = date('Y-m-d');
	}else{
		$_SESSION['fechaHoy'] = date('Y-m-d');
		unset($_SESSION['fechaAntSemana']);
	}

	//nclude_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	//$Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php");

	$horaAct = date('H:i');
	$fechaHoy = date('Y-m-d');
	$fp = explode('-', $fechaHoy);
	$Periodo = $fp[1].'-'.$fp[0];
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de PreCAM</title>

	<meta name="description" 	content="Laboratorio Universidad Santiago de Chile Metalurgica" />
	<meta name="keywords" 		content="Laboratorio Materiales, USACH, Simet, Ensayos de Traccóon, Ensayos de Impacto, " />
	<meta name="author" 		content="Francisco Olivares">
	<meta name="robots" 		content="índice, siga" />
	<meta name="revisit-after" 	content="3 mes" />

	<link rel="shortcut icon" href="favicon.ico" />

	<title>PreCam</title>

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script src="../jquery/jquery-migrate-1.2.1.min.js"></script>	
	<script type="text/javascript" src="../jquery/libs/1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
	<script src="../angular/angular.min.js"></script>

    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        .verde-class{
            background-color : green;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif; 
        }
        .verdechillon-class{
            background-color : #33FFBE;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
        }
        .azul-class{
            background-color : blue;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
        }
        .amarillo-class{
            background-color : yellow;
            color : black;
            font-size: 18px;
        }
        .rojo-class{
            background-color : red;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .default-color{
            background-color : #fff;
            color : black;
            font-size: 18px;
        }
    </style>



<script>
	function muestraResultados(){
		$.ajax({
			url: 'mTallerboot.php',
			beforeSend: function () {
				$("#resultado").html("<div id='tablaDatosAjax'><img src='img/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#info").html(response);
			}
		});
	}
</script>
<script type="text/javascript">
	var int=self.setInterval("refresh()",5000);
	function refresh()
	{
		muestraResultados();
	}	
</script>
</head>

<body ng-app="myApp" ng-controller="ctrlPreCam" ng-init="leerPreCAM('<?php echo $idPreCAM; ?>')"> 

<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
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
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>





	<div class="row bg-primary text-white">
		<div class="col-sm-2">
			<a class="btn btn-danger btn-lg btn-block" ng-click="semanaAnterior()" href="#">Anterior</a>
		</div>
		<!-- <div class="col-sm-2">
			<a class="btn btn-primary btn-lg btn-block" ng-click="primeraPreCam()" href="#">Primera PreCAM</a>
		</div>
		<div class="col-sm-2">
			<a class="btn btn-warning btn-lg btn-block fa fa-home"  href="../plataformaErp.php">Menú Principal</a>
		</div>
		-->
		<div class="col-sm-2">
			<a class="btn btn-primary btn-lg btn-block" ng-click="semanaActual()" href="#">Semana Actual</a>
		</div>
		<div class="col-sm-6">
			<a class="btn btn-primary btn-lg btn-block" href="#" data-bs-toggle="modal" ng-click="nuevaPreCam()" data-bs-target="#newPreCAM">Agregar PreCAM</a>
		</div>
		<div class="col-sm-2">
			<a class="btn btn-success btn-lg btn-block" ng-click="semanaSiguiente()" href="#">Siguiente</a>
		</div>
	</div>
<hr>
	<div class="container-fluid">
		<table class="table table-bordered">
			<thead class="table-dark">
      			<tr>
      			  <th class="text-center" ng-repeat="x in semanaHead">
					<b>{{x.diaSemana}}</b><br>
					<b>{{x.fSem}}</b>
				  </th>
      			</tr>
    		</thead>
    		<tbody>
      			<tr>
      			  	<td class="text-center">
						<div ng-repeat="x in dataPreCAM" ng-if="x.diaSem=='Monday'">
							<div ng-if="x.Estado == 'off' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}}  btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
							<div ng-if="x.Estado == 'on' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}} btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
						</div>
					</td>
      			  	<td class="text-center">
						<div ng-repeat="x in dataPreCAM" ng-if="x.diaSem=='Tuesday'">
							<div ng-if="x.Estado == 'off' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}}  btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
							<div ng-if="x.Estado == 'on' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}} btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button>
							</div>
						</div>
					</td>
      			  	<td class="text-center">
						<div ng-repeat="x in dataPreCAM" ng-if="x.diaSem=='Wednesday'">
							<div ng-if="x.Estado == 'off' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}}  btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
							<div ng-if="x.Estado == 'on' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}} btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button>
							</div>
						</div>
					</td>
      			  	<td class="text-center">
						<div ng-repeat="x in dataPreCAM" ng-if="x.diaSem=='Thursday'">
							<div ng-if="x.Estado == 'off' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}}  btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
							<div ng-if="x.Estado == 'on' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}} btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button>
							</div>
						</div>
					</td>
      			  	<td class="text-center">
						<div ng-repeat="x in dataPreCAM" ng-if="x.diaSem=='Friday'">
							<div ng-if="x.Estado == 'off' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}}  btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button> 
							</div>
							<div ng-if="x.Estado == 'on' ">
								<button type="button" data-bs-toggle="modal" ng-click="editarPreCamPublicada(x.idPreCAM)" data-bs-target="#oldPreCAM" class="btn {{x.EstadoPreCAM}} btn-block m-2">{{x.idPreCAM}}<br><b>{{x.idCliente}}</b><br>{{x.usrResponsable}}</button>
							</div>
						</div>
					</td>
      			</tr>
    		</tbody>
		</table>
  
	</div>



	<!-- The Modal -->
	<div class="modal" id="newPreCAM">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

		<!-- Modal Header -->
		<div class="modal-header">
			<h4 class="modal-title">Registro de nuevaPreCAM</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		</div>

		<!-- Modal body -->
		<div class="modal-body">
			<div class="row">
                <div class="col-md-3">
                    <label for="usrResponsable"> Responsable </label><br>
                    <select class="form-control" name="usrResponsable" id="usrResponsable" ng-model="usrResponsable">
                        <option ng-repeat="x in dataUsrs" value="{{x.usr}}">{{x.usuario}}</option>
                    </select>
                </div>
				<div class="col-md-3">
                    <label for="seguimiento"> Cliente </label><br>
					<input class = "form-control" ng-model = 'idCliente' id='idCliente' name='idCliente' type='text'>
					<!--
                    <select class 	= "form-control"
                        ng-change   = "fechaSeguimiento()"
                        ng-model	= "seguimiento" 
                        ng-options 	= "seguimiento.codEstado as seguimiento.descripcion for seguimiento in estadoSeguimiento" >
                        <option value="seguimiento">{{seguimiento}}</option>
                    </select>
					-->
                </div>
                <div class="col-md-2">
                    <label for="fechaPreCAM">  Inicio </label><br>
                    <input class="form-control" ng-model="fechaPreCAM" type="date">
                </div>
				<div class="col-md-2">
                    <label for="fechaSeg">  Seguimiento </label><br>
                    <input class="form-control" ng-model="fechaSeg" type="date">
                </div>
                <div class="col-md-2">
                    <label for="Tipo"> Tipo </label><br>
                    <select class 	= "form-control"
                        ng-model	= "Tipo" 
                        ng-options 	= "Tipo.codEstado as Tipo.descripcion for Tipo in tipoTipo" >
                        <option value="Tipo">{{Tipo}}</option>
                    </select>
                </div>

			</div>
			<hr>
			<div class="row">
				<div class="col">
					<textarea class="form-control" ng-model="Correo" name="Correo" id="Correo" cols="100" rows="20"></textarea>
				</div>
			</div>



		</div>

		<!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarNuevaPreCAM()" data-bs-dismiss="modal">Guardar</button>
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
		</div>

		</div>
	</div>
	</div>
	<!-- Fin PreCAM Nueva -->

	<!-- PreCAM ya Publicada -->
	<div class="modal" id="oldPreCAM">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

		<!-- Modal Header -->
		<div class="modal-header">
			<h4 class="modal-title">Mantención PreCAM Nº <b>{{idPreCAM}}</b></h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		</div>

		<!-- Modal body -->
		<div class="modal-body">

			<div class="row">
                <div class="col-md-3">
                    <label for="usrResponsable"> Responsable </label><br>
                    <select class="form-control" name="usrResponsable" id="usrResponsable" ng-model="usrResponsable">
                        <option ng-repeat="x in dataUsrs" value="{{x.usr}}">{{x.usuario}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="seguimiento"> Cliente </label><br>
					<input class = "form-control" ng-model = 'idCliente' id='idCliente' name='idCliente' type='text'>
					<!--
                    <select class 	= "form-control"
                        ng-change   = "fechaSeguimiento()"
                        ng-model	= "seguimiento" 
                        ng-options 	= "seguimiento.codEstado as seguimiento.descripcion for seguimiento in estadoSeguimiento" >
                        <option value="seguimiento">{{seguimiento}}</option>
                    </select>
					-->
                </div>
                <div class="col-md-2">
                    <label for="fechaPreCAM">  Inicio </label><br>
                    <input class="form-control" ng-model="fechaPreCAM" type="date">
                </div>
                <div class="col-md-2">
                    <label for="fechaSeg">  Seguimiento </label><br>
                    <input class="form-control" ng-model="fechaSeg" type="date">
                </div>
                <div class="col-md-2">
                    <label for="Tipo"> Tipo </label><br>
                    <select class 	= "form-control"
                        ng-model	= "Tipo" 
                        ng-options 	= "Tipo.codEstado as Tipo.descripcion for Tipo in tipoTipo" >
                        <option value="Tipo">{{Tipo}}</option>
                    </select>
                </div>
			</div>
			<hr>
			<div class="row">
				<div class="col">
					<textarea class="form-control" ng-model="Correo" name="Correo" id="Correo" cols="100" rows="20"></textarea>
				</div>
			</div>
		<div>
		<!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" ng-click="cerrarPreCAM()" data-bs-dismiss="modal">Terminar</button>
			<button type="button" class="btn btn-warning" ng-click="grabarSeguimientoPreCAM()" data-bs-dismiss="modal">Seguimiento</button>
			<button type="button" class="btn btn-primary" ng-click="grabarOldPreCAM()" data-bs-dismiss="modal">Actualizar</button>
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
		</div>

		</div>
	</div>
	</div>






<!--
	<div id="info"></div>
	<script>muestraResultados()</script> 
-->
	<script src="../bootstrap/js/bootstrap.min.js"></script>	
	<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

	<script src="precamtv.js"></script> 





</body>
</html>

