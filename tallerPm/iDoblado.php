<?php
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
	$accion 		= '';
	$Otam			= '';
	$CodInforme		= '';
	$Tipo			= '';
	$Observaciones 	= '';
	$Condicion 		= '';
	
	$RAM 	= 0;
	$CAM	= 0;
	
	if(isset($_GET['accion'])) 			{	$accion 	= $_GET['accion']; 		}
	if(isset($_GET['Otam'])) 			{	$Otam 		= $_GET['Otam']; 		}
	if(isset($_GET['CodInforme']))		{	$CodInforme	= $_GET['CodInforme'];	}
	if(isset($_GET['fechaRegistro']))	{	$fechaRegistro	= $_GET['fechaRegistro'];	}
	if(isset($_GET['Tipo']))			{	$Tipo			= $_GET['Tipo'];			}
	if(isset($_GET['Observaciones']))	{	$Observaciones	= $_GET['Observaciones'];	}
	if(isset($_GET['Condicion']))		{	$Condicion		= $_GET['Condicion'];		}

	if($accion != 'Actualizar'){
		$link=Conectarse();
		$bdCot=$link->query("Select * From formRAM Where CAM = '".$CAM."' and RAM = '".$RAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$accion = 'Filtrar';
		}
		$link->close();
	}

	$link=Conectarse();
	$SQL = "SELECT * FROM otams Where Otam = '$Otam'";
	$bd=$link->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		$tpMuestra 	= $rs['tpMuestra'];
		$CodInforme = $rs['CodInforme'];
		$SQLr = "SELECT * FROM regdobladosreal Where idItem = '$Otam'";
		$bdr=$link->query($SQLr);
		if($rsr=mysqli_fetch_array($bdr)){
		}else{
			$link->query("insert into regdobladosreal (
				CodInforme,
				idItem,
				tpMuestra
				) 
		values 	(	
				'$CodInforme',
				'$Otam',
				'$tpMuestra'
				)");
		}
	}
	$link->close();


	if(isset($_GET['guardarIdOtam'])){	
		$link=Conectarse();
		$bdOT=$link->query("Select * From OTAMs Where Otam = '".$Otam."'");
		if($rowOT=mysqli_fetch_array($bdOT)){
			$Estado 	= 'R';
			$tpMuestra 	= $rowOT['tpMuestra'];

			if(isset($_GET['tpMuestra'])) { $tpMuestra = $_GET['tpMuestra']; }
			
			$actSQL="UPDATE OTAMs SET ";
			$actSQL.="tpMuestra		='".$tpMuestra.	"',";
			$actSQL.="Estado		='".$Estado.	"'";
			$actSQL.="WHERE Otam 	= '".$Otam."'";
			$bdfRAM=$link->query($actSQL);

			$tm = explode('-',$Otam);
			$SQL = "SELECT * FROM regdobladosreal Where idItem = '".$Otam."'";
			$bdRegDo=$link->query($SQL);
			if($rowRegDo=mysqli_fetch_array($bdRegDo)){
				$actSQL="UPDATE regdobladosreal SET ";
				$actSQL.="Tipo 			= '".$Tipo.			"',";
				$actSQL.="fechaRegistro = '".$fechaRegistro."',";
				$actSQL.="Observaciones	= '".$Observaciones."',";
				$actSQL.="Condicion		= '".$Condicion.	"'";
				$actSQL.="Where idItem 	= '".$Otam."'";
				$bdRegDo=$link->query($actSQL);
			}
		}
		$link->close();
		$accion = '';
	}
	
	$link=Conectarse();
	$SQL = "SELECT * FROM regdobladosreal Where idItem = '".$Otam."'";
	$bdRegDo=$link->query($SQL);
	if($rowRegDo=mysqli_fetch_array($bdRegDo)){
		$Tipo 			= $rowRegDo['Tipo'];
		$Observaciones 	= $rowRegDo['Observaciones'];
		$Condicion 		= $rowRegDo['Condicion'];
		$fechaRegistro 	= $rowRegDo['fechaRegistro'];
	}
	$link->close();
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Taller Propiedades Mecánicas</title>
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>

<body ng-app="myApp" ng-controller="controlDoblados" ng-init="loadDoblado('<?php echo $Otam; ?>')">

	<?php include('head.php'); ?>
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
	        		<li class="nav-item active">
						<?php 
							if($CodInforme){
								$fr = explode('-',$CodInforme);
								$RAM = $fr[1];
								?>
								<a class="nav-link fas fa-undo-alt"  href="../generarinformes2/edicionInformes.php?accion=Editar&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $CodInforme; ?>"> Volver</a>
							<?php
							}else{?>
	          					<a class="nav-link fas fa-undo-alt"  href="../tallerPM/pTallerPM.php"> Volver</a>
							<?php
							}
						?>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div id="Cuerpo">
		<div id="CajaCpo">
			
			<form name="form" action="iDoblado.php" method="get">

			<input name="CodInforme" ng-model="CodInforme" id="CodInforme"	type="hidden" value="<?php echo $CodInforme; ?>">

			<input name="Otam" type="hidden" 	value="<?php echo $Otam; ?>" />
			<div class="card m-2">
    			<div class="card-header"><b>Ensayo de Doblado <span ng-if="CodInforme != ''">{{CodInforme}} -></span> {{Otam}}  </b></div>
    			<div class="card-body">

					<div class="row p-3">
						<div class="col">
							<div class="form-group">
  								<label for="usr">Fecha Ensayo:</label>
								<input name="fechaRegistro" ng-model="fechaRegistro" type="date" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Temperatura:</label>
								<input name="Tem" ng-model="Tem" type="text" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Humedad:</label>
								<input name="Hum" ng-model="Hum" type="text" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Responsable:</label>
								<select class="form-control" id="usrResponsable" ng-model="usrResponsable">
                        			<option value=""></option>
                        			<option ng-repeat="x in responsable" value="{{x.usrResponsable}}">{{x.descripcion}}</option>
                    			</select>
							</div>
						</div>
					</div>

					<div class="row p-3">
						<div class="col">
							<div class="form-group">
  								<label for="usr">Separación entre apoyos(mm):</label>
								<input name="separacionApoyos" name="separacionApoyos" ng-model="separacionApoyos" type="text" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Diámetro de apoyos(mm):</label>
								<select class="form-control" id="nDiametroDoblado" ng-model="nDiametroDoblado">
                       			  	<option value=""></option>
                       			  	<option ng-repeat="x in dataDiametro" value="{{x.nDiametroDoblado}}">{{x.diametroDoblado}}</option>
                    			</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Diámetro punzón(mm):</label>
								<input name="diametroPunzon" name="diametroPunzon" ng-model="diametroPunzon" type="text" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Ángulo alcanzado:</label>
								<input name="anguloAlcanzado" name="anguloAlcanzado" ng-model="anguloAlcanzado" type="text" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Dimensión fisuras(mm):</label>
								<input name="diametroFisuras" name="diametroFisuras" ng-model="diametroFisuras" type="text" class="form-control">
							</div>
						</div>

					</div>

					<div class="row p-3">
						<div class="col">
							<div class="form-group">
  								<label for="usr">Norma Ref.:</label>
								<select class="form-control" id="normaRefDoblado" ng-model="normaRefDoblado">
                       			  	<option ng-repeat="x in dataNormaRef" value="{{x.normaRefDoblado}}">{{x.normaRef}}</option>
                    			</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Tipo:</label>
								<select class="form-control" id="Tipo" ng-model="Tipo">
                       			  	<option value=""></option>
                       			  	<option ng-repeat="x in dataTipo" value="{{x.tipoDoblado}}">{{x.Tipo}}</option>
                    			</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Observaciones:</label>
								<select class="form-control" id="Observaciones" ng-model="Observaciones">
                       			  	<option value=""></option>
                       			  	<option ng-repeat="x in dataObservaciones" value="{{x.nObsDoblado}}">{{x.obsDoblado}}</option>
                    			</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
  								<label for="usr">Condición:</label>
								<select class="form-control" id="Condicion" ng-model="Condicion">
                       			  	<option value=""></option>
                       			  	<option ng-repeat="x in dataCondicion" value="{{x.Condicion}}">{{x.descripcion}}</option>
                    			</select>
							</div>
						</div>

					</div>

				</div> 
    			<div class="card-footer">
					<a class="btn btn-primary" ng-click="grabarDoblado()" role="button">
						<i class="fas fa-calculator"></i> 
						Actualizar registro Doblado
					</a>

					<!-- <button type="submit" ng-click="grabarDoblado()"  class="btn btn-info">Guardar</button> -->
				</div>
  			</div>
			
			</form>
		</div>
		<div style="clear:both;"></div>
				
	</div>
	<br>

	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>
	<script src= "Doblados.js"></script>

	
</body>
</html>
