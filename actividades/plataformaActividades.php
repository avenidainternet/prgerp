<?php
	ini_set("session.cookie_lifetime",60);
	ini_set("session.gc_maxlifetime",60);
	session_start(); 
	
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 		= $_SESSION['usuario'];
	
	$idActividad	= '';
	$accion			= '';
	$actRepetitiva 	= '';
	$Acreditado 	= '';
	$realizadaAct 	= '';
	$fechaProxAct 	= '0000-00-00';
	$registradaAct 	= '';
	$Estado 		= '';
	
	$usrApertura 	= $_SESSION['usr'];
	$usrRes 		= $_SESSION['usr'];
	
	if(isset($_GET['idActividad']))	{ $idActividad	= $_GET['idActividad']; 	}
	if(isset($_GET['accion']))	 	{ $accion		= $_GET['accion']; 			}
	if(isset($_GET['tpAccion']))	{ $tpAccion		= $_GET['tpAccion']; 		}

	if(isset($_POST['idActividad'])){ $idActividad 	= $_POST['idActividad'];	}
	if(isset($_POST['accion']))	  	{ $accion		= $_POST['accion']; 		}
	if(isset($_POST['tpAccion']))	{ $tpAccion		= $_POST['tpAccion']; 		}

	$link=Conectarse();
	$bddCot=$link->query("Select * From Actividades Order By idActividad");
	if($rowdCot=mysqli_fetch_array($bddCot)){
		//$nSerie = $rowdCot[nSerie];
	}else{
		$accion = 'Vacio';
	}
	$link->close();

	if($accion=='Imprimir'){
		//header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		$bdCot =$link->query("Delete From Actividades Where idActividad = '".$idActividad."'");
		$link->close();
		$idActividad = '';
		$accion		 = '';
	}
	
	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['idActividad'])) 	{ $idActividad		= $_POST['idActividad'];	}
		if(isset($_POST['realizadaAct'])) 	{ $realizadaAct 	= $_POST['realizadaAct'];	}
		if(isset($_POST['fechaAccionAct'])) { $fechaAccionAct	= $_POST['fechaAccionAct'];	}
		if(isset($_POST['registradaAct'])) 	{ $registradaAct	= $_POST['registradaAct'];	}
		if(isset($_POST['idActividad'])) 	{ $fechaRegAct		= $_POST['fechaRegAct'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From Actividades Where idActividad = '".$idActividad."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Actividad 			= $rowCot['Actividad'];
			$usrResponsable 	= $rowCot['usrResponsable'];
			$fechaTentativaAct 	= $rowCot['fechaProxAct'];
			$prgHistorial 		= $rowCot['fechaProxAct'];
			$prgActividad 		= date('Y-m-d');
			
			if($realizadaAct=='on'){
				$Estado = 'T';
				if($rowCot['actRepetitiva']=='on'){
					$Estado = 'P';
					$tpoProx 		= $rowCot['tpoProx'];
					$fechaProxAct 	= strtotime ( '+'.$tpoProx.' day' , strtotime ( $fechaRegAct ) );
					$fechaProxAct 	= date ( 'Y-m-d' , $fechaProxAct );
				}
			}

			$actSQL="UPDATE Actividades SET ";
			$actSQL.="realizadaAct		='".$realizadaAct.	"',";
			$actSQL.="fechaAccionAct	='".$fechaAccionAct."',";
			$actSQL.="registradaAct		='".$registradaAct.	"',";
			$actSQL.="fechaRegAct		='".$fechaRegAct.	"',";
			$actSQL.="prgActividad		='".$fechaRegAct.	"',";
			$actSQL.="fechaProxAct		='".$fechaProxAct.	"',";
			$actSQL.="Estado			='".$Estado.		"'";
			$actSQL.="Where idActividad	= '".$idActividad."'";
			$bdCot=$link->query($actSQL);

			if($fechaRegAct > '000-00-00'){
				$bdHis=$link->query("Select * From actividadesHistorial Where idActividad = '".$idActividad."' and prgActividad = '".$prgHistorial."'");
				if($rowHis=mysqli_fetch_array($bdHis)){

				}else{
					$link->query("insert into actividadesHistorial(	
																idActividad,
																prgActividad,
																fechaActividad,
																Actividad,
																fechaRegistro,
																usrResponsable
																) 
													values 	(	
																'$idActividad',
																'$prgHistorial',
																'$fechaAccionAct',
																'$Actividad',
																'$fechaRegAct',
																'$usrResponsable'
						)");
				}
			}
		}
		$link->close();
		$idActividad	= '';
		$accion			= '';
	}
	
	if(isset($_POST['guardarActividad'])){
		if(isset($_POST['idActividad'])) 	{ $idActividad		= $_POST['idActividad'];	}
		if(isset($_POST['Actividad'])) 		{ $Actividad 		= $_POST['Actividad'];		}

		if(isset($_POST['actRepetitiva'])) 	{ $actRepetitiva 	= $_POST['actRepetitiva'];	}
		if(isset($_POST['Acreditado'])) 	{ $Acreditado	 	= $_POST['Acreditado'];		}
		if(isset($_POST['prgActividad'])) 	{ $prgActividad 	= $_POST['prgActividad'];	}
		if(isset($_POST['tpoProx'])) 		{ $tpoProx			= $_POST['tpoProx'];		}
		if(isset($_POST['tpoAvisoAct'])) 	{ $tpoAvisoAct		= $_POST['tpoAvisoAct'];	}
		if(isset($_POST['fechaProxAct'])) 	{ $fechaProxAct 	= $_POST['fechaProxAct'];	}
		
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From Actividades Where idActividad = '".$idActividad."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE Actividades SET ";
			$actSQL.="Actividad			='".$Actividad.		"',";
			$actSQL.="actRepetitiva		='".$actRepetitiva.	"',";
			$actSQL.="Acreditado		='".$Acreditado.	"',";
			$actSQL.="prgActividad		='".$prgActividad.	"',";
			$actSQL.="tpoProx			='".$tpoProx.		"',";
			$actSQL.="tpoAvisoAct		='".$tpoAvisoAct.	"',";
			$actSQL.="fechaProxAct		='".$fechaProxAct.	"',";
			$actSQL.="usrResponsable	='".$usrResponsable."'";
			$actSQL.="WHERE idActividad	= '".$idActividad."'";
			$bdCot=$link->query($actSQL);
		}else{
			$link->query("insert into Actividades(	
															idActividad,
															Actividad,
															actRepetitiva,
															Acreditado,
															prgActividad,
															tpoProx,
															tpoAvisoAct,
															fechaProxAct,
															usrResponsable
															) 
												values 	(	
															'$idActividad',
															'$Actividad',
															'$actRepetitiva',
															'$Acreditado',
															'$prgActividad',
															'$tpoProx',
															'$tpoAvisoAct',
															'$fechaProxAct',
															'$usrResponsable'
					)");
		}
		$link->close();
		$idActividad	= '';
		$accion			= '';
	}

?>

<!doctype html>
 
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Intranet Simet -> Gestión de Actividades</title>


	<script src="../jquery/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<style type="text/css">
		.verde-class{
		  background-color 	: green;
		  color 			: #000;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		  font-weight 		: bold;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		  font-weight 		: bold;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>

	<script>
	function realizaProceso(usrRes, tpAccion){
		var parametros = {
			"usrRes" 	: usrRes,
			"tpAccion"  : tpAccion
		};
		//alert(tpAccion);
		$.ajax({
			data: parametros,
			url: 'muestraActividades.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraActividad(idActividad, accion){
		var parametros = {
			"idActividad"	: idActividad,
			"accion"		: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regActividad.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function seguimientoActividad(idActividad, accion, tpAccion){
		var parametros = {
			"idActividad" 	: idActividad,
			"accion"		: accion,
			"tpAccion"		: tpAccion
		};
		//alert(Proyecto);
		$.ajax({
			data: parametros,
			url: 'segActividad.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	</script>

</head>

<body ng-app="myApp" ng-controller="CtrlActividades">

		<?php include('head.php'); ?>


		<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">

					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
							<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link far fa-calendar-plus" href="" data-toggle="modal" ng-click="buscaActividad()" data-target="#programarActividad"> Programar</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>


		<div class="container-fluid">

		<table class="table table-hover m-2 table-bordered">
			<thead class="thead-dark text-center">
				<tr>
					<th scope="col">ID Act. 		</th>
					<th scope="col">Actividad 		</th>
					<th scope="col">Fecha Prog.		</th>
					<th scope="col">Fecha Act. 		</th>
					<th scope="col">Acreditación	</th>
					<th scope="col">Responsable		</th>
					<th scope="col">Actividades 	</th>
				</tr>
			</thead>
			<tbody class="table-striped">
				<tr ng-repeat="reg in regActividades"
					ng-class="verColorLinea(reg.prgActividad, reg.tpoAvisoAct)">
					<th>{{reg.idActividad}} 						</th>
					<td>{{reg.Actividad}}							</td>
					<td>{{reg.prgActividad | date:'dd/MM/yyyy'}} 	</td>
					<td>{{reg.fechaProxAct | date:'dd/MM/yyyy'}}	</td>
					<td>
						<div ng-if="reg.Acreditado == 'on'">
							Alcance
						</div>						
						<div ng-if="reg.Acreditado != 'on'">
							---
						</div>						
					</td>
					<td>{{reg.usrResponsable}}</td>
					<td class="text-center">
						<a href="Actividades/{{reg.idActividad}}-{{reg.Actividad}}/Plantilla-{{reg.idActividad}}.pdf" target='_blank'  class="btn btn-secondary" title="Descargar Plantilla"><i class="fas fa-download"></i></a>
						<button type="button" class="btn btn-secondary" title="Seguimiento" ng-click="seguimientoActividad(reg.idActividad)" data-toggle="modal" data-target="#seguimientoActividad">		
							<i class="fas fa-calendar-check"></i>
						</button>
						<!-- <button type="button" class="btn btn-secondary" title="Seguimiento"><i class="far fa-file-pdf">	</i></button> -->
						<!-- <a href="Actividades/{{reg.idActividad}}-{{reg.Actividad}}/Actividad-{{reg.idActividad}}.pdf" target='_blank'  class="btn btn-secondary" title="Descargar Plantilla"><i class="far fa-file-pdf"></i></a> -->
						<button type="button" class="btn btn-secondary" title="Editar" ng-click="editarActividad(reg.idActividad)" data-toggle="modal" data-target="#editarActividad">		
							<i class="fas fa-edit">	</i>
						</button>
						<button type="button" class="btn btn-secondary" title="Eliminar" ng-click="eliminarActividad(reg.idActividad, reg.Actividad)">	<i class="far fa-trash-alt">		</i></button>
					</td>
				</tr>
			</tbody>
		</table>



		<?php //include_once('listaActividad.php'); 

				if($accion == 'Seguimiento'){?>
					<script>
						var idActividad	= "<?php echo $idActividad; ?>" ;
						var accion 		= "<?php echo $accion; 		?>" ;
						var tpAccion 	= "<?php echo $tpAccion; 	?>" ;
						seguimientoActividad(idActividad, accion, tpAccion);
					</script>
					<?php
				}
				if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'Vacio'){
					?>
					<script>
						var idActividad	= "<?php echo $idActividad; ?>" ;
						var accion 		= "<?php echo $accion; ?>" ;
						registraActividad(idActividad, accion);
					</script>
					<?php
				}
				?>

	</div>
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src="../jquery/jquery-3.3.1.min.js"></script>
	<script src="actividades.js"></script>



<!-- Modal -->
<div class="modal fade" id="programarActividad" tabindex="-1" aria-labelledby="programarActividad" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="exampleModalLabel">Programar Actividad Nº <b>{{idActividad}}</b> </h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body">
			  <div class="row">
					<div class="col">
						<b>Descripción de la Actividad</b>
					</div>
				</div>
				<div class="row text-center">
					<div class="col">
						<textarea class="form-control"  ng-model="Actividad" id="Actividad" /></textarea>
					</div>
				</div>
				<hr>

				<div class="row text-center">
					<div class="col">Actividad Repetitiva		</div>
					<div class="col">Alcance de Acreditación 	</div>
					<div class="col">Responsable Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col"><input class="form-control" type="checkbox" ng-model="actRepetitiva">			</div>
					<div class="col"><input class="form-control" type="checkbox" ng-model="Acreditado"> 			</div>
					<div class="col">
						<select ng-model="usr" id="usr">
							<option ng-repeat="x in regUsuarios" value="{{x.usr}}">{{x.usr}}</option>
						</select>
					</div>
			  	</div>
				<hr>
				<div class="row text-center">
					<div class="col">Fecha Programación		</div>
					<div class="col">Proxima (días)			</div>
					<div class="col">Avisar (días) 			</div>
					<div class="col">Fecha Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col">
						<input class="form-control" type="date" ng-model="prgActividad" id="prgActividad" ng-change="fechaProgAct()">		
					</div>
					<div class="col">
						<input class="form-control" type="text" ng-model="tpoProx" id="tpoProx" ng-change="diasPrgAct()">
					</div>
					<div class="col"><input class="form-control" type="text" ng-model="tpoAvisoAct" id="tpoAvisoAct"> 			</div>
					<div class="col">
						<input class="form-control" type="date" ng-model="fechaProxAct" id="fechaProxAct">
					</div>
			  	</div>
				<hr>
				<div class="row">
					<div class="col">Plantilla</div>
					<div class="col"><input id="archivos" multiple type="file"></div>
				</div>
				<hr>
				<div class="row" ng-show="msg">
					<div class="col">
						<div class="alert alert-success">
    						<strong>Programación Actividad!</strong> Se creo una nueva actividad.
  						</div>
					</div>
				</div>

      		</div>
      		<div class="modal-footer">
      			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      	  		<button type="button" class="btn btn-primary" ng-click="guardarActividad('Nueva')">Guardar</button>
      		</div>
    	</div>
  	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editarActividad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
      		<div class="modal-header">
	  			<h5 class="modal-title" id="exampleModalLabel">Actividad Nº <b>{{idActividad}}</b> </h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body">
				<div class="row">
					<div class="col">
						<b>Descripción de la Actividad</b>
					</div>
				</div>
				<div class="row text-center">
					<div class="col">
						<textarea class="form-control"  ng-model="Actividad" id="Actividad" /></textarea>
					</div>
				</div>
				<hr>
	  			<div class="row text-center">
					<div class="col">Actividad Repetitiva		</div>
					<div class="col">Alcance de Acreditación 	</div>
					<div class="col">Responsable Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col"><input class="form-control" type="checkbox" ng-model="actRepetitiva"> {{actRepetitiva}}			</div>
					<div class="col"><input class="form-control" type="checkbox" ng-model="Acreditado"> {{Acreditado}}			</div>
					<div class="col">
						<select ng-model="usr" id="usr">
							<option ng-repeat="x in regUsuarios" value="{{x.usr}}">{{x.usr}}</option>
						</select>
					</div>
			  	</div>
				<hr>
				<div class="row text-center">
					<div class="col">Fecha Programación		</div>
					<div class="col">Proxima (días)			</div>
					<div class="col">Avisar (días) 			</div>
					<div class="col">Fecha Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col">
						<input class="form-control" type="date" ng-model="prgActividad" value="prgActividad"  id="prgActividad" name="prgActividad">	
					</div>
					<div class="col">
						<input class="form-control" type="text" ng-model="tpoProx" id="tpoProx" ng-change="diasPrgAct()">
					</div>
					<div class="col"><input class="form-control" type="text" ng-model="tpoAvisoAct" id="tpoAvisoAct"> 			</div>
					<div class="col">
						<input class="form-control" type="date" ng-model="fechaProxAct" id="fechaProxAct">
					</div>
			  	</div>
				<!--
				<hr>
				<div class="row">
					<div class="col">Actualizar Plantilla</div>
					<div class="col"><input id="archivosActividad" multiple type="file"></div>
				</div>
				-->
				<hr>
				<div class="row" ng-show="msg">
					<div class="col">
						<div class="alert alert-success">
    						<strong>Guardado!</strong> Se acualizó correctamente.
  						</div>
					</div>
				</div>
      		</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" ng-click="actualizarActividad('Guardar')">Guardar</button>
      	</div>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- Modal Seguimiento -->
<div class="modal fade" id="seguimientoActividad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
      		<div class="modal-header">
	  			<h5 class="modal-title" id="exampleModalLabel">Seguimiento Actividad Nº <b>{{idActividad}}</b> </h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body">
				<div class="row">
					<div class="col">
						<b>Descripción de la Actividad</b>
					</div>
				</div>
				<div class="row text-center">
					<div class="col">
						<textarea class="form-control"  ng-model="Actividad" id="Actividad" readonly /></textarea>
					</div>
				</div>
				<hr>
	  			<div class="row text-center">
					<div class="col">Actividad Repetitiva		</div>
					<div class="col">Alcance de Acreditación 	</div>
					<div class="col">Responsable Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col">
						<span ng-if="actRepetitiva == true"><b>Si</b></span>		
					</div>
					<div class="col"> 
						<span ng-if="Acreditado == true"><b>Si</b></span>		
					</div>
					<div class="col">
						<b>{{usr}}</b>
					</div>
			  	</div>
				<hr>
				<div class="row text-center">
					<div class="col">Fecha Programación		</div>
					<div class="col">Proxima (días)			</div>
					<div class="col">Avisar (días) 			</div>
					<div class="col">Fecha Actividad 		</div>
			  	</div>
			  	<div class="row text-center">
					<div class="col">
						<input class="form-control" type="date" ng-model="prgActividad" value="prgActividad"  id="prgActividad" name="prgActividad" readonly />	
					</div>
					<div class="col">
						<input class="form-control" type="text" ng-model="tpoProx" id="tpoProx" ng-change="diasPrgAct()" readonly />
					</div>
					<div class="col"><input class="form-control" type="text" ng-model="tpoAvisoAct" id="tpoAvisoAct" readonly /> 			</div>
					<div class="col">
						<input class="form-control" type="date" ng-model="fechaProxAct" id="fechaProxAct" readonly />
					</div>
			  	</div>
				<hr>
				<div class="row">
					<div class="col">PDF Actividad</div>
					<div class="col"><input id="archivosSeguimiento" multiple type="file"></div>
				</div>
				<hr>
				<div class="row" ng-show="msg">
					<div class="col">
						<div class="alert alert-success">
    						<strong>Seguimiento!</strong> Se subió correctamente el informe.
  						</div>
					</div>
				</div>

      		</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" ng-click="subirActividad('Seguimiento')">Subir registro de actividad</button>
      	</div>
    </div>
  </div>
</div>

<!-- Modal Seguimiento -->




</body>
</html>
