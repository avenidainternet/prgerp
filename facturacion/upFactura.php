<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	$agnoActual = date('Y'); 

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

	$nSolicitud = '';
    $RutCli     = '';
    $pdf = '';
	if(isset($_GET['nSolicitud']))  { $nSolicitud   = $_GET['nSolicitud'];  }
	if(isset($_GET['RutCli']))      { $RutCli       = $_GET['RutCli'];      }
    if(isset($_GET['accion'])){ $accion = $_GET['accion']; }

	if(isset($_POST['nSolicitud']))     { $nSolicitud       = $_POST['nSolicitud'];     }
	if(isset($_POST['RutCli']))         { $RutCli           = $_POST['RutCli'];         }
	if(isset($_POST['nFactura']))       { $nFactura         = $_POST['nFactura'];       }
	if(isset($_POST['fechaFactura']))   { $fechaFactura     = $_POST['fechaFactura'];   }
    if(isset($_POST['accion'])){ $accion = $_POST['accion']; }
    
	if(isset($_POST['SubirDocumentos'])){
        if(isset($_POST['nFactura'])){
            $link=Conectarse();
            $SQLs = "SELECT * FROM solfactura Where nSolicitud = '$nSolicitud'";
            $bds=$link->query($SQLs);
            if($rows=mysqli_fetch_array($bds)){
                $Factura = 'on';
                $actSQL="UPDATE solfactura SET ";
                $actSQL.="nFactura          = '".$nFactura.          "', ";
                $actSQL.="fechaFactura      = '".$fechaFactura.      "', ";
                $actSQL.="Factura           = '".$Factura.           "'  ";
                $actSQL.="Where nSolicitud  = '$nSolicitud'";
                $bdAct=$link->query($actSQL);
            }
            $link->close();
        }

        $agnoActual = date('Y'); 

        $directorioSOL = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud;
        $directorioSOL = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
		//$directorioSOL = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud; // BORRAR DESPUES

        if(!file_exists($directorioSOL)){
            mkdir($directorioSOL);
        }
    
		/* Documento PDF */
        if(isset($_FILES['pdfFA']['name'])){
            $nom_PdfFA 	= $_FILES['pdfFA']['name'];
            $tip_PdfFA 	= $_FILES['pdfFA']['type'];
            $tam_PdfFA 	= $_FILES['pdfFA']['size'];
            $des_PdfFA	= $_FILES['pdfFA']['tmp_name'];

            $directorioFAC = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud.'/';
			$directorioFAC = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
            //$directorioFAC = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/SOL-'.$nSolicitud.'/'; // BORRAR DESPUES

            if($tip_PdfFA == "application/pdf") {
                $newPdfFA = 'FA-'.$nSolicitud.'.pdf';
                if(move_uploaded_file($des_PdfFA, $directorioFAC."/".$newPdfFA)) {
                    $vDir = "../tmp";
					/*
                    copy($directorioFAC."/".$newPdfFA, $vDir.'/'.$newPdfFA);
                    $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp';
					$vDir = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
                    copy($directorioFAC."/".$newPdfFA, $vDir.'/'.$newPdfFA);
					*/
                }
                
            }
            // if($tip_PdfFA == "application/pdf") {
            //     if(copy($directorioDocFA."/".$newPdfFA, $directorioDocFAPr."/".$newPdfFA)) {

            //     }
                
            // }
        }

        
    }
    $fechaFactura = date('Y-m-d');
    $link=Conectarse();
    $SQLs = "SELECT * FROM solfactura Where nSolicitud = '$nSolicitud'";
    $bds=$link->query($SQLs);
    if($rows=mysqli_fetch_array($bds)){
        $nFactura       = $rows['nFactura'];
        $fechaFactura   = $rows['fechaFactura'];
    }
    $link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mantención de Anexos Solicitud <?php echo $nSolicitud; ?></title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script type="text/javascript" src="../angular/angular.js"></script>



<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
input.mayusculas{text-transform:uppercase;}
</style>
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body ng-app="myApp" ng-controller="TodoCtrl">
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
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">

	          			<a class="nav-link fas fa-paste" href="formSolicitaFactura.php?nSolicitud=<?php echo $nSolicitud; ?>&RutCli=<?php echo $RutCli; ?>"> Formulario Solicitud <?php echo $nSolicitud; ?></a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white" style="padding: 10px;">
		<div class="col-12">
			<h5>SUBIR FACTURA SOLICITUD Nº <?php echo $nSolicitud; ?></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container">
        <form name="myForm" enctype="multipart/form-data" action="upFactura.php" method="post">

		<div class="card" style="margin: 10px; margin: 10px 50px 50px;">
			<div class="card-header">Identificación Factura</div>
		  	<div class="card-body">
		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="CAM">Solicitud:  </label>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
                            <input  ng-modal="RutCli"
                                    name="RutCli"
                                    id="RutCli"
                                    value="<?php echo $RutCli; ?>"
                                    type="hidden">

					    	<input 	ng-model="nSolicitud" 
					    			name="nSolicitud"
                                    id="nSolicitud"
                                    value='<?php echo $nSolicitud; ?>'
					    			ng-init="loadRegistro('<?php echo $nSolicitud; ?>')"
					    			type="hidden">
                            <h4>{{nSolicitud}}</h4>
                        </div>
					</div>
                        <div class="col-md-1">
                            <label for="Lote">Cliente:  </label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <h4>{{Cliente}}</h4>
                            </div>
                        </div>
				</div>


                <hr>
		  		<div class="row">
		  			<div class="col-md-2">
				    	<label for="pdf">Nº FACTURA :  </label>
				    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="nFactura" type="text" id="nFactura" class="form-control" value="<?php echo $nFactura; ?>" required>
                        </div>
					</div>
		  			<div class="col-md-2">
				    	<label for="pdf">Fecha :  </label>
				    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="fechaFactura" type="date" id="fechaFactura" class="form-control" value="<?php echo $fechaFactura; ?>" required>
                        </div>
					</div>

		  			<div class="col-md-2">
				    	<label for="pdf">FACTURA :  </label>
				    </div>
		  			<div class="col-md-6">
                        <div class="form-group">
                            <input name="pdfFA" type="file" id="pdfFA" class="form-control">
                        </div>
						<?php 
						$newPdfFA = 'FA-'.$nSolicitud.'.pdf';
						$directorioFAC = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud.'/'.$newPdfFA;
						// echo $directorioFAC;
						if(file_exists($directorioFAC)){
							echo '
							<div class="alert alert-danger">
  								<strong>Precaución!</strong> Ya existe una FACTURA asociada a esta solicitud, con el nombre "'.$newPdfFA.'".
							</div>
							';
						}

						?>

					</div>
                    <div class="col-md-4">
                        <?php
                                $directorioDocFA="Y://AAA/Archivador/SOL-".$nSolicitud."/FAC";
                                $directorioDocFA="Y://AAA/LE/FINANZAS/".$agnoActual."/SOLICITUD-FACTURA/SOL-".$nSolicitud."/FAC";
                                $directorioDocFA="Y://AAA/Archivador/SOL-".$nSolicitud."/FAC"; // BORRAR DESPUES
                                if(file_exists($directorioDocFA)){
                                    $doc = 'Anexos/SOL-'.$nSolicitud.'/FAC/FA-'.$nSolicitud.'.pdf';

                                    if(file_exists($doc)){
                                        echo "<a href='$doc' target='_blank' class='btn btn-primary btn-block'>FACTURA</a>";
                                    }
                                }
                        ?>

                    </div>
				</div>

				
		  	</div>
		  	<div class="card-footer">
		  		
		  		<button type="submit" 
                        name="SubirDocumentos"
		  				class="btn btn-info">
		  				Subir Documentos
		  		</button>

                  <a class="btn btn-primary" href="plataformaFacturas.php"> Volver</a>

		  	</div>
		</div>
        </form>
	</div>


	<script src="moduloFacturacion.js"></script>
</body>
</html>