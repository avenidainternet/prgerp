<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	
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
    $CAM = '';

	if(isset($_GET['nSolicitud']))  { $nSolicitud   = $_GET['nSolicitud'];  }
	if(isset($_GET['RutCli']))      { $RutCli       = $_GET['RutCli'];      }
    if(isset($_GET['accion'])){ $accion = $_GET['accion']; }

	if(isset($_POST['nSolicitud'])) { $nSolicitud   = $_POST['nSolicitud']; }
	if(isset($_POST['RutCli']))     { $RutCli       = $_POST['RutCli'];     }
    if(isset($_POST['accion'])){ $accion = $_POST['accion']; }

    $link=Conectarse();
    $bd=$link->query("SELECT * FROM cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
    if ($rs=mysqli_fetch_array($bd)){
        $CAM = $rs['CAM'];
    }
    $link->close();

	if(isset($_POST['SubirDocumentos'])){
        $directorioDoc="../tmp";
        if(!file_exists($directorioDoc)){
            mkdir($directorioDoc);
        }

		/* Documento PDF */
        if(isset($_FILES['pdfOC']['name'])){
            $nom_PdfOC 	= $_FILES['pdfOC']['name'];
            $tip_PdfOC 	= $_FILES['pdfOC']['type'];
            $tam_PdfOC 	= $_FILES['pdfOC']['size'];
            $des_PdfOC	= $_FILES['pdfOC']['tmp_name'];

            $link=Conectarse();
            $bd=$link->query("SELECT * FROM cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
            if ($rs=mysqli_fetch_array($bd)){
                $CAM = $rs['CAM'];
            }
            $link->close();

            $agnoActual = date('Y'); 
            $vDirTmp    = '../tmp/';
            $newPdfOC = 'OC-'.$CAM.'.pdf';
            // BORRAR DESPUES
            /*
            $directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/';
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc);
            }
            */
            // FIN BORRAR DESPUES

            $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/';
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc);
            }
            $directorioSol = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
            if(!file_exists($directorioSol)){
                mkdir($directorioSol);
            }
            //$directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/'; // BORRAR DESPUES

            move_uploaded_file($des_PdfOC, $vDirTmp."/".$newPdfOC);
            copy($vDirTmp."/".$newPdfOC, $directorioDoc."/".$newPdfOC);
            copy($vDirTmp."/".$newPdfOC, $directorioSol."/".$newPdfOC);
        }

        if(isset($_FILES['pdfHES']['name'])){
            if($_FILES['pdfHES']['name']){
                $nom_PdfHES 	= $_FILES['pdfHES']['name'];
                $tip_PdfHES 	= $_FILES['pdfHES']['type'];
                $tam_PdfHES 	= $_FILES['pdfHES']['size'];
                $des_PdfHES	    = $_FILES['pdfHES']['tmp_name'];
    
                $agnoActual = date('Y'); 
                $vDirTmp    = '../tmp/';
                $newPdfHES = 'HES-'.$CAM.'.pdf';
                // BORRAR DESPUES
                /*
                $directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/';
                if(!file_exists($directorioDoc)){
                    mkdir($directorioDoc);
                }
                */
                // FIN BORRAR DESPUES

                $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/';
                if(!file_exists($directorioDoc)){
                    mkdir($directorioDoc);
                }
                $directorioSol = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
                if(!file_exists($directorioSol)){
                    mkdir($directorioSol);
                }

                // $directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/'; // BORRAR DESPUES

                move_uploaded_file($des_PdfHES, $vDirTmp."/".$newPdfHES);
                copy($vDirTmp."/".$newPdfHES, $directorioDoc."/".$newPdfHES);
                copy($vDirTmp."/".$newPdfHES, $directorioSol."/".$newPdfHES);

            }

        }
        if(isset($_FILES['pdfANE']['name'])){
            if($_FILES['pdfANE']['name']){
                $nom_PdfANE 	= $_FILES['pdfANE']['name'];
                $tip_PdfANE 	= $_FILES['pdfANE']['type'];
                $tam_PdfANE 	= $_FILES['pdfANE']['size'];
                $des_PdfANE	    = $_FILES['pdfANE']['tmp_name'];
    
                $agnoActual = date('Y'); 
                $vDirTmp    = '../tmp/';
                $newPdfANE = 'ANE-'.$CAM.'.pdf';
                // BORRAR DESPUES
                /*
                $directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/';
                if(!file_exists($directorioDoc)){
                    mkdir($directorioDoc);
                }
                */
                // FIN BORRAR DESPUES

                $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/';
                if(!file_exists($directorioDoc)){
                    mkdir($directorioDoc);
                }
                $directorioSol = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud;
                if(!file_exists($directorioSol)){
                    mkdir($directorioSol);
                }
    
                //$directorioDoc = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/'; // BORRAR DESPUES

                move_uploaded_file($des_PdfANE, $vDirTmp."/".$newPdfANE);
                copy($vDirTmp."/".$newPdfANE, $directorioDoc."/".$newPdfANE);
                copy($vDirTmp."/".$newPdfANE, $directorioSol."/".$newPdfANE);

            }

        }

        
    }
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

<body ng-app="myApp" ng-controller="TodoCtrl" ng-init="RutCli='<?php echo $RutCli; ?>'">
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
			<h5>SUBIR DOCUMENTOS SOLICITUD DE FACTURACIÓN Nº <?php echo $nSolicitud; ?></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container">
        <form name="myForm" enctype="multipart/form-data" action="mDocumentos.php" method="post">

		<div class="card" style="margin: 10px; margin: 10px 50px 50px;">
			<div class="card-header">Identificación de Documentos Asociados</div>
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

		  		<div class="row">
		  			<div class="col-md-2">
				    	<label for="Informes">Informe(s):  </label> 
				    </div>
		  			<div class="col-md-10">
                        <div class="form-group">
                            <h4>{{informesAM}}</h4>
                        </div>
					</div>
				</div>

		  		<div class="row">
		  			<div class="col-md-2">
				    	<label for="Cliente">Cotizaciones :  </label> 
				    </div>
		  			<div class="col-md-10">
                        <div class="form-group">
                            <h4>{{cotizacionesCAM}}</h4>
                        </div>
					</div>
				</div>

                <hr>

                <div class="row">
                    <div class="col-6">

                        <div class="row">
                            <div class="col-md-3">
                                <label for="pdf">PDF OC:  </label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input name="pdfOC" type="file" id="pdfOC">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="pdfHES">PDF HES:  </label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input id="pdfHES" name="pdfHES"  type="file">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="pdfHES">PDF Anexo:  </label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input id="pdfANE" name="pdfANE"  type="file">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 text-center">
                                Documentación Asociada Anexada
                            </div>
                            <div class="col-12">
                            <?php
                                            $link=Conectarse();

                                            $agnoActual = date('Y'); 
                        
                                            $bd=$link->query("SELECT * FROM cotizaciones WHERE CAM = '".$CAM."'");
                                            if($rs=mysqli_fetch_array($bd)){

                                                $ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/';
                                                $ruta = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/';
                                                //$ruta = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/'; // BORRAR DESPUES

                                                if(file_exists($ruta)){
                                                    $gestorDir = opendir($ruta);
                                                    while(false !== ($nombreDir = readdir($gestorDir))){
                                                        if($nombreDir != 'Thumbs.db' and $nombreDir != '.' and $nombreDir != '..'){
                                                            $fd = explode('-',$nombreDir); // OC-17760.xlsx
                                                            $fd = explode('.', $fd[1]);
                                                            $CAMb = $fd[0];
                                                            // echo $nombreDir;
                                                            if($CAM == $CAMb){?>
                                                                <div class="row">
                                                                    <div class="col m-1">
                                                                        <a href="<?php echo '../tmp/'.$nombreDir; ?>" class="btn btn-primary  btn-block" target="_blank" role="button">
                                                                            <b><?php echo $nombreDir; ?></b>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col m-1">
                                                                        <a href="#" ng-click="borrarDoc('<?php echo $nombreDir;?>','<?php echo $nSolicitud;?>')" class="btn btn-danger" role="button">
                                                                            <b>X</b>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            //break;
                                                            }
                                                        }
                                                    }
                                                }


                                                $agnoActual = date('Y'); 
                                                $vDir       = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$rs['CAM'].'.xlsx';
                                                $vDir       = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp/OC-'.$rs['CAM'].'.xlsx';
                                                // $vDir       = 'Y://AAA/Archivador-'.$agnoActual.'/Finanzas/SolicitudesFacturacion/octmp/OC-'.$rs['CAM'].'.xlsx'; // BORRAR DESPUES
                                                $vDirTmp    = '../tmp/OC-'.$rs['CAM'].'.xlsx';
                                            }
                                            $link->close();
                            ?>

                            </div>
                        </div>

                    </div>
                </div>
			
		  	</div>
		  	<div class="card-footer">
		  		
                <button type="submit" 
                            name="SubirDocumentos" 
                            class="btn btn-info">
                            Subir Documentos
                </button>

                <a class="btn btn-primary" href="formSolicitaFactura.php?nSolicitud=<?php echo $nSolicitud; ?>&RutCli=<?php echo $RutCli; ?>"> Volver</a>

		  	</div>

		</div>
        </form>
	</div>


	<script src="moduloFacturacion.js"></script>
</body>
</html>