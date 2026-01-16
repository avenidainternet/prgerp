<?php
	session_start(); 

	include_once("../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $fechaHoy = date('Y-m-d');    
    if(!isset($_GET['up'])){
        $agnoActual = date('Y'); 
        $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoEspectrometro'; 
        $archivo = $vDir.'/Espectrometro-'.$fechaHoy.'.xlsx';
        if(file_exists($archivo)){
            unlink($archivo);
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

    <link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
</head>
<body ng-app="myApp" ng-controller="ctrlEspectometro" ng-cloak>

    <?php include('head.php'); ?>
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
					<?php
					if($_SESSION['IdPerfil'] != 5){?>
		        		<li class="nav-item active">
                        <a class="nav-link fa fa-home" href="http://servidorerp/erp/plataformaErp.php"> Principal
		                	<span class="sr-only">(current)</span>
		              		</a>
		        		</li>
		        		<?php
		        	}
		        	?>
	          			<!-- <a class="nav-link fas fa-power-off" href="http://servidordata/erperp/tallerPM/pTallerPM.php"> Ensayos</a> -->
	          			<a class="nav-link fas fa-power-off" href="http://servidorerp/erp/tallerPM/pTallerPM.php"> Ensayos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div> 
	  	</div>
	</nav>



    <div class="container-fluid">
        <h2>Resultados Espectrometro</h2>
        <div class="row">
            <div class="col-5">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Archivos Asociados al Ensayo</b>
                    </div>
                    <div class="card-body">
                        <input id="archivosSeguimiento" multiple type="file"> {{pdf}}
                        <button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
                            Subir Archivos
                        </button>
                    </div>
                </div>
            </div>


            <div class="col-7">
                <div class="card">
                    <div class="card-header font-weight-bold bg-primary text-white">
                        <b>Data Asociada al Ensayo</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="Temperatura" class="form-label">Temperatura</label>
                                    <input type="text" class="form-control" id="Temperatura" ng-model="Temperatura" name="Temperatura" placeholder="19">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="Humedad" class="form-label">Humedad</label>
                                    <input type="text" class="form-control" id="Humedad" ng-model="Humedad" name="Humedad" placeholder="55">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="Temperatura" class="form-label">Fecha Ensayo(s)</label>
                                <input type="date" class="form-control" id="fechaRegistro" ng-model="fechaRegistro" name="fechaRegistro">
                            </div>
                            <div class="col-3">
                                <label for="Temperatura" class="form-label">Técnico Responsable</label>
								<select tabindex="10" class="form-control" ng-model="tecRes" name="tecRes">
									<option value="GRC">GRC </option> 
									<option value="SML">SML </option>
									<option value="RPM">RPM </option>
									<option value="AVR">AVR	</option>
									<option value="AVR">CCE	</option>
								</select>	
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-2">
                                <button ng-disabled="statusBtnRegistrar"  type="button" class="btn btn-success" ng-click="registrarDatos()" >Registrar Datos</button>
                            </div>
                            <!-- <div class="col-md-3" ng-show="respaldarOtams"> -->
                            <div class="col-md-3">
                                <a href="respaldoOtams.php" type="button" class="btn btn-danger" ng-click="respaldaOtam()" >Respaldar OTAM Ensayos</a>
                            </div>
                            <div class="row m-2">
                                <div class="col">
                                    <div class="alert alert-success" ng-show="msgUsr">
                                        <h2>Información!</h2> <h4>{{msg}}</h4> 
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        


        <div class="card m-2" >
            <div class="card-title bg-primary text-white">
                <h3 class="panel-title">Resultados del Ensayo</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="alert alert-warning" ng-show="procesando">
                        <strong>Estado!</strong> ESPERE PROCESANDO DATOS....
                    </div>
                <?php
                require_once '../PHPExcel/Classes/PHPExcel.php';
                $archivo = "resultadosQu/prueba.xlsx";

                // $agnoActual = date('Y'); 
                // $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/RespaldoEspectrometro'; 

                $archivo = 'tmp/Espectrometro-'.$fechaHoy.'.xlsx';
                
                if(file_exists($archivo)){
                    // echo 'Existe ........'.$archivo;
                    // $archivo = "resultadosQu/prueba.xlsx";
                    $inputFileType = PHPExcel_IOFactory::identify($archivo);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($archivo);
                    $sheet = $objPHPExcel->getSheet(0); 
                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();

                    $cl     = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
                    $fd     = explode('-',$cl);
                    $num    = 0;
                    $fila   = 0;
                    $outp   = '';

                    for ($row = 1; $row <= $highestRow; $row++){ 
                        // Leer encabezado
                        if($sheet->getCell("A".$row)->getValue() == 'Sample Result Name'){
                            $i = $row + 1;
                            $tpMuestra = $sheet->getCell('F'.$i)->getValue();
                            $Programa = $tpMuestra;

                        }
                        $busqueda = 'Al';
                        switch ($tpMuestra) {
                            case '614-05':
                                $tpMuestra = 'Al';
                                break;
                            case '136-03':
                                $tpMuestra = 'Al';
                                break;
                            case 'P1':
                                $tpMuestra = 'Ac';
                                break;
                            case 'P2':
                                $tpMuestra = 'Ac';
                                break;
                            case 'P3':
                                $tpMuestra = 'Ac';
                                break;
                            case 'Fe-30+N': // Fe-01+N Esos son Orientación
                                $tpMuestra = 'Ac';
                                break;
                            case 'Cu-20':
                                $tpMuestra = 'Co';
                                break;
                        }
                        if($sheet->getCell("A".$row)->getValue() == 'Sample Name'){
                            $i = $row + 1;
                            $idItem = $sheet->getCell('A'.$i)->getValue();
                            $r = $row + 1;
                            if($idItem == ''){ continue; }
                            $Repetido = '';
                            if($ultimosTres = substr($idItem, -3) == 'REP'){
                                // echo 'Repetido...'. substr($idItem, 0, 13).' ';
                                $Repetido = 'SI';
                                $idItem = trim(substr($idItem, 0, 13));
                            }
                            $ultimosTres = substr($idItem, -3);
                            // echo ' Tres '.substr($ultimosTres,0,1);
                            if(substr($ultimosTres,0,1) != 'Q'){ continue; }
                            $RAM = substr($idItem, 0, 5);
                            $link=Conectarse();
                    
                            $SQL = "Select * From regquimico Where idItem = '$idItem'";
                            // echo $SQL.'<br>';
                            $bd=$link->query($SQL);
                            if($rs = mysqli_fetch_array($bd)){
                                if ($outp != "") {$outp .= ",";}
                                $outp .= '{"RAM":"'  			    . $RAM 			. '",'; 
                                $outp .= '"Programa":"'  			. $Programa	    . '",';
                                $outp .= '"tpMuestra":"'  			. $tpMuestra	. '",';
                                $outp .= '"idItem":"'  			    . $idItem	    . '"}';

                                ?>
                                <div class="alert alert-success">
                                    <strong>Ensayo OK!</strong> <?php echo $Repetido.'<b>PROGRAMA -> '.$Programa.' - Muestra->'.$tpMuestra.' - CodEnsayo-> '.$idItem.' </b>'; ?>
                                </div>
                                <?php
                            }else{?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <?php echo '<b>ERROR: Ensayo NO REGISTRADO... PROGRAMA -> '.$Programa.' - Muestra-> '.$tpMuestra.' - CodEnsayo-> '.$idItem.' </b>'; ?>
                                </div>
                                <?php
                            }
                                
                            
                            ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <?php
                                    $fila = $row;
                                    for($j=1; $j<=sizeof($fd); $j++){
                                        $r = $row + 2;
                                        if($sheet->getCell($fd[$j-1].$r)->getValue() != ''){
                                            echo '<th>'.$sheet->getCell($fd[$j-1].$r)->getValue().'</th>';
                                        }
                                    }
                                    ?>
                                    </tr>
                                </thead>
                            <?php
                        } 
                        if($sheet->getCell("A".$row)->getValue() == 'Rep'){
                            ?>
                                </tbody>
                                    </tr>
                                    <?php
                                    $fila += 2;
                                    $actSQL = ''; 
                                    $Simbolo = '';
                                    $link=Conectarse();

                                    for($i=1; $i<=sizeof($fd); $i++){
                
                                        if($sheet->getCell($fd[$i-1].$r)->getValue() != ''){
                                            echo '<td>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</td>';
                                            $Simbolo = $sheet->getCell($fd[$i-1].$fila)->getValue();
                                            $cC     = 0;
                                            $cSi	= 0;
                                            $cMn	= 0;
                                            $cP		= 0;
                                            $cS		= 0;
                                            $cCr	= 0;
                                            $cMo	= 0;
                                            $cNi	= 0;
                                            $cAl	= 0;
                                            $cCo	= 0;
                                            $cNb	= 0;
                                            $cCu	= 0;
                                            $cTi	= 0;
                                            $cV		= 0;
                                            $cW		= 0;
                                            $cPb	= 0;
                                            $cSn	= 0;
                                            $cAs	= 0;
                                            $cZr	= 0;
                                            $cBi 	= 0;
                                            $cCa	= 0;
                                            $cCe	= 0;
                                            $cSb 	= 0;
                                            $cSe    = 0;
                                            $cTe    = 0;
                                            $cTa    = 0;
                                            $cB	    = 0;
                                            $cZn    = 0;
                                            $cAg    = 0;
                                            $cN     = 0;
                                            $cFe    = 0;
                                            $cMg    = 0;
                                            $cBa    = 0;
                                            $cBe    = 0;
                                            $cCd    = 0;
                                            $cGa    = 0;
                                            $cHg    = 0;
                                            $cIn    = 0;
                                            $cLa    = 0;
                                            $cNa    = 0;
                                            $cSr    = 0;
                                            $cTl    = 0;
                                            $cHf    = 0;
                                            $cSc    = 0;
                                            $cY     = 0;
                                            $cBg    = 0;
                                            $cAu    = 0;
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'C')   { $cC = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Si')  { $cSi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Mn')  { $cMn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'P')   { $cP = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'S')   { $cS = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Cr')  { $cCr = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Mo')  { $cMo = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ni')  { $cNi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Al')  { $cAl = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Co')  { $cCo = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Cu')  { $cCu = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Nb')  { $cNb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ti')  { $cTi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'V')   { $cV  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'W')   { $cW  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Pb')  { $cPb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Sn')  { $cSn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'As')  { $cAs = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Zr')  { $cZr = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Bi')  { $cBi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ca')  { $cCa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ce')  { $cCe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Sb')  { $cSb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Se')  { $cSe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Te')  { $cTe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ta')  { $cTa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'B')   { $cB  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Zn')  { $cZn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ag')  { $cAg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'N')   { $cN  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Fe')  { $cFe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Mg')  { $cMg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ba')  { $cBa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Be')  { $cBe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Cd')  { $cCd = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Ga')  { $cGa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Hg')  { $cHg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'In')  { $cIn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'La')  { $cLa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Na')  { $cNa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Sr')  { $cSr = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Tl')  { $cTl = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Hf')  { $cHf = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Sc')  { $cSc = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Y')   { $cY  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                            if($sheet->getCell($fd[$i-1].$fila)->getValue()   == 'Bg')  { $cBg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                                    

                                                // echo $Simbolo.'<br>';
                                            if($Simbolo == 'C'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
            
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'C'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cC = comparaValor($cC, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cC = comparaValor($cC, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    $actSQL.="cC		        = '".$cC.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);

                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    // $SQL = "Select * From regquimico Where idItem = '$idItem'";
                                                    // $bd=$link->query($SQL);
                                                    // if($rs = mysqli_fetch_array($bd)){

                                                    // }else{
                                                    //     continue;
                                                    // }

                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Si'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Si'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cSi = comparaValor($cSi, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cSi = comparaValor($cSi, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cSi		        = '".$cSi.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Mn'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mn'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cMn = comparaValor($cMn, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cMn = comparaValor($cMn, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cMn		        = '".$cMn.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'P'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'P'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cP = comparaValor($cP, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cP = comparaValor($cP, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cP		        = '".$cP.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'S'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'S'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cS = comparaValor($cS, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cS = comparaValor($cS, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cS.' '.$Simbolo.'<br>';
                                                    $actSQL.="cS		        = '".$cS.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>';
                                            }
                                            if($Simbolo == 'Cr'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cr'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCr = comparaValor($cCr, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cCr = comparaValor($cCr, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCr		        = '".$cCr.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>';
                                            }
                                            if($Simbolo == 'Mo'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mo'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cMo = comparaValor($cMo, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cMo = comparaValor($cMo, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cMo.' '.$Simbolo.'<br>';
                                                    $actSQL.="cMo		        = '".$cMo.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>';
                                            }
                                            if($Simbolo == 'Ni'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ni'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cNi = comparaValor($cNi, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cNi = comparaValor($cNi, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' Defecto '.$valorDefecto.' '.$cNi.' '.$Simbolo.'<br>';
                                                    $actSQL.="cNi		        = '".$cNi.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Al'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Al'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cAl = comparaValor($cAl, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cAl = comparaValor($cAl, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cAl.' '.$Simbolo.'<br>';
                                                    $actSQL.="cAl		        = '".$cAl.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>';
                                            }
                                            if($Simbolo == 'Co'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Co'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCo = comparaValor($cCo, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cCo = comparaValor($cCo, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCo		        = '".$cCo.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Cu'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cu'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        // echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCu = comparaValor($cCu, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if(substr($cCu,0,1) == '>'){ // >
                                                                $cCu = $cCu;
                                                            }else{
                                                                if($rsd['valorDefecto'] == 0){
                                                                }else{
                                                                    $cCu = comparaValor($cCu, $valorDefecto);
                                                                }    
                                                            }
                                                            // echo $tpMuestra.' VALOR '.$cCu.'<br>';
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cCu.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCu		        = '".$cCu.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>';
                                            }
                                            if($Simbolo == 'Nb'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Nb'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cNb = comparaValor($cNb, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cNb = comparaValor($cNb, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cNb		        = '".$cNb.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ti'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ti'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cTi = comparaValor($cTi, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cTi = comparaValor($cTi, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cTi		        = '".$cTi.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'V'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'V'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cV = comparaValor($cV, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cV = comparaValor($cV, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cV		        = '".$cV.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'W'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'W'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cW = comparaValor($cW, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cW = comparaValor($cW, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cW		        = '".$cW.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Pb'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Pb'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cPb = comparaValor($cPb, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cPb = comparaValor($cPb, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cPb		        = '".$cPb.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Sn'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sn'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cSn = comparaValor($cSn, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cSn = comparaValor($cSn, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cSn		        = '".$cSn.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'As'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'As'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cAs = comparaValor($cAs, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cAs = comparaValor($cAs, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cAs		        = '".$cAs.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Zr'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zr'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cZr = comparaValor($cZr, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cZr = comparaValor($cZr, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cZr		        = '".$cZr.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Bi'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bi'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cBi = comparaValor($cBi, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cBi = comparaValor($cBi, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cBi		        = '".$cBi.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ca'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ca'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCa = comparaValor($cCa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cCa = comparaValor($cCa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCa		        = '".$cCa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ce'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ce'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCe = comparaValor($cCe, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cCe = comparaValor($cCe, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCe		        = '".$cCe.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Sb'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sb'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cSb = comparaValor($cSb, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cSb = comparaValor($cSb, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cSb		        = '".$cSb.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Te'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Te'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cTe = comparaValor($cTe, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cTe = comparaValor($cTe, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cTe		        = '".$cTe.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ta'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ta'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cTa = comparaValor($cTa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cTa = comparaValor($cTa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cTa		        = '".$cTa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'B'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'B'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cB = comparaValor($cB, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cB = comparaValor($cB, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cB		        = '".$cB.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Zn'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zn'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cZn = comparaValor($cZn, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cZn = comparaValor($cZn, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cZn		        = '".$cZn.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ag'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ag'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cAg = comparaValor($cAg, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cAg = comparaValor($cAg, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cAg		        = '".$cAg.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Mg'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mg'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cMg = comparaValor($cMg, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cMg = comparaValor($cMg, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cMg		        = '".$cMg.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ba'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ba'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cBa = comparaValor($cBa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cBa = comparaValor($cBa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cBa		        = '".$cBa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Cd'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cd'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cCd = comparaValor($cCd, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cCd = comparaValor($cCd, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cCd		        = '".$cCd.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Ga'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ga'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cGa = comparaValor($cGa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cGa = comparaValor($cGa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cGa		        = '".$cGa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Hg'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hg'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cHg = comparaValor($cHg, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cHg = comparaValor($cHg, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cHg		        = '".$cHg.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'In'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'In'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cIn = comparaValor($cIn, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cIn = comparaValor($cIn, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cIn		        = '".$cIn.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'La'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'La'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cLa = comparaValor($cLa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cLa = comparaValor($cLa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cLa		        = '".$cLa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Na'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Na'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cNa = comparaValor($cNa, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cNa = comparaValor($cNa, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cNa		        = '".$cNa.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Sr'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sr'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cSr = comparaValor($cSr, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cSr = comparaValor($cSr, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cSr		        = '".$cSr.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Tl'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Tl'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cTl = comparaValor($cTl, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cTl = comparaValor($cTl, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cTl		        = '".$cTl.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Hf'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hf'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cHf = comparaValor($cHf, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cHf = comparaValor($cHf, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cHf		        = '".$cHf.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Sc'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sc'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cSc = comparaValor($cSc, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cSc = comparaValor($cSc, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cSc		        = '".$cSc.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Y'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Y'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cY = comparaValor($cY, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cY = comparaValor($cY, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cY		        = '".$cY.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Bg'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bg'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cBg = comparaValor($cBg, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cBg = comparaValor($cBg, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cBg		        = '".$cBg.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'N'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'N'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cN = comparaValor($cN, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cN = comparaValor($cN, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cN		        = '".$cN.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Au'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo ='Au'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cAu = comparaValor($cAu, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cAu = comparaValor($cAu, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cAu		        = '".$cAu.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            if($Simbolo == 'Fe'){
                                                    $actSQL="UPDATE regquimico SET ";
                                                    $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                                    $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                                    $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Fe'";
                                                    $bdd=$link->query($SQLs);
                                                    if($rsd=mysqli_fetch_array($bdd)){
                                                        $valorDefecto = $rsd['valorDefecto'];
                                                        //  echo $SQLs.'<br>';
                                                        if($tpMuestra == 'Ac'){
                                                            if($Programa == 'Fe-30+N'){
                                                                $valorDefecto = $rsd['valorDefectoFe'];
                                                            }
                                                            $cFe = comparaValor($cFe, $valorDefecto);
                                                        }
                                                        if($tpMuestra != 'Co'){
                                                            if($rsd['valorDefecto'] == 0){
                                                            }else{
                                                                $cFe = comparaValor($cFe, $valorDefecto);
                                                            }
                                                        }
                                                    }
                                                    // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                                    $actSQL.="cFe		        = '".$cFe.	                    "' ";
                                                    $actSQL.="Where idItem 	    = '$idItem'";
                                                    $bdfRAM=$link->query($actSQL);
                                                    // echo $actSQL.'<br>'
                                            }
                                            // if($Simbolo == 'Fe'){
                                            //         $actSQL="UPDATE regquimico SET ";
                                            //         $actSQL.="Programa		        = '".$Programa.	                        "', ";
                                            //         $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "', ";
                                            //         $SQLs = "SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Fe'";
                                            //         $bdd=$link->query($SQLs);
                                            //         if($rsd=mysqli_fetch_array($bdd)){
                                            //             $valorDefecto = $rsd['valorDefecto'];
                                            //             //  echo $SQLs.'<br>';
                                            //             if($tpMuestra == 'Ac'){
                                            //                 if($Programa == 'Fe-30+N'){
                                            //                     $valorDefecto = $rsd['valorDefectoFe'];
                                            //                 }
                                            //                 $cFe = comparaValor($cFe, $valorDefecto);
                                            //             }
                                            //             if($tpMuestra != 'Co'){
                                            //                 $cFe = comparaValor($cFe, $valorDefecto);
                                            //             }
                                            //         }
                                            //         // echo $tpMuestra.' '.$Simbolo.' '.$valorDefecto.' '.$cC.' '.$Simbolo.'<br>';
                                            //         $actSQL.="cFe		        = '".$cFe.	                    "' ";
                                            //         $actSQL.="Where idItem 	    = '$idItem'";
                                            //         $bdfRAM=$link->query($actSQL);
                                            //         echo $actSQL.'<br>';
                                            // }
                                                
                                                

                                            
                    










                                            
                                        }
                                        
                                    }
                                    // echo '<a  href="formularios/otamQuimicoEsp.php?idItem='.$idItem.'" type="button" class="btn btn-danger">Respaldar OTAM '.$idItem.'</a>';

                                    echo $idItem.'<br>';
                                    $link->close();
                                    
                                    ?>
                                    </tr>
                                </tbody>
                            </table>
                          <?php
                        }
                    }
                    $outp ='{"records":['.$outp.']}';
                    $json_string = $outp;
                    $file = 'resultadosQu\vEspectrometro.json'; 
                    file_put_contents($file, $json_string);

                }
                if(file_exists($archivo)){
                    ?>
                    <div ng-load="cerrarProcesamiento()"></div>
                    <?php
                    unlink($archivo);
                }
            
            ?>
            </div>	
        </div>	
    </div>
    
    <script src="../bootstrap/css/bootstrap.min.js"></script> 
    <script src="../angular/angular.min.js"></script>
	<script src="espectrometroXXX.js"></script>

</body>
</html>

<?php

function comparaValor($valor, $valorDefecto) {
        // Extraer el valor numérico de $valorDefecto (quitar el '<' y convertir coma a punto)
        $valorDefectoLimpio = ltrim($valorDefecto, '<');
        $valorDefectoNumerico = (float) str_replace(',', '.', $valorDefectoLimpio);
        
        // Calcular cantidad de decimales en $valorDefecto
        $partes = explode(',', $valorDefectoLimpio);
        if (count($partes) == 1) {
            $partes = explode('.', $valorDefectoLimpio);
        }
        $decimales = isset($partes[1]) ? strlen($partes[1]) : 0;
        
        // Convertir $valor a número (cambiar coma a punto si es necesario)
        $valorNumerico = (float) str_replace(',', '.', $valor);
        
        // Si el valor es menor que el valor por defecto, devolver el valor por defecto
        if ($valorNumerico < $valorDefectoNumerico) {
            return $valorDefecto;
        }
        
        // Si no, aproximar (redondear) el valor a la misma cantidad de decimales y devolverlo
        $valorAproximado = round($valorNumerico, $decimales);
        
        // Formatear con la misma notación (coma o punto) que tenía el valor original
        if (strpos($valor, ',') !== false) {
            return number_format($valorAproximado, $decimales, ',', '');
        } else {
            return number_format($valorAproximado, $decimales, '.', '');
        }    
}
function comparaValor22($valor, $valorDefecto) {
    // Extraer el valor numérico de $valorDefecto (quitar el '<' y convertir coma a punto)
    $valorDefectoLimpio = ltrim($valorDefecto, '<');
    $valorDefectoNumerico = (float) str_replace(',', '.', $valorDefectoLimpio);
    
    // Calcular cantidad de decimales en $valorDefecto
    $partes = explode(',', $valorDefectoLimpio);
    if (count($partes) == 1) {
        $partes = explode('.', $valorDefectoLimpio);
    }
    $decimales = isset($partes[1]) ? strlen($partes[1]) : 0;
    
    // Convertir $valor a número (cambiar coma a punto si es necesario)
    $valorNumerico = (float) str_replace(',', '.', $valor);
    
    // Si el valor es menor que el valor por defecto, devolver el valor por defecto
    if ($valorNumerico < $valorDefectoNumerico) {
        return $valorDefecto;
    }
    
    // Si no, truncar el valor a la misma cantidad de decimales y devolverlo
    $valorTruncado = floor($valorNumerico * pow(10, $decimales)) / pow(10, $decimales);
    
    // Formatear con la misma notación (coma o punto) que tenía el valor original
    if (strpos($valor, ',') !== false) {
        return number_format($valorTruncado, $decimales, ',', '');
    } else {
        return number_format($valorTruncado, $decimales, '.', '');
    }
}


function comparaValoressss($valor, $valorDefecto) {
    // Extraer el valor numérico de $valorDefecto (quitar el '<' y convertir coma a punto)
    $valorDefectoNumerico = (float) str_replace(',', '.', ltrim($valorDefecto, '<'));
    
    // Convertir $valor a número (cambiar coma a punto si es necesario)
    $valorNumerico = (float) str_replace(',', '.', $valor);
    
    // Si el valor es menor que el valor por defecto, devolver el valor por defecto
    if ($valorNumerico < $valorDefectoNumerico) {
        return $valorDefecto;
    }
    
    // Si no, devolver el valor original
    return $valor;
}


function comparaValorrrrrrr($vExcel, $vDefecto){
    $resultado      = '';
    $vDefectoBd     = $vDefecto;
    $vExcelOrigen   = $vExcel;

    $vDec       = 0;
    $vDef       = '';
    $iConteo    = 'No';
    // if($vDefecto = ''){
    //     $resultado = $vExcel;
    //     return $resultado;
    // }
    for($i = 0; $i < strlen($vDefecto); $i++){
        if(substr($vDefecto, $i, 1) != '<'){
            if(substr($vDefecto, $i, 1) == ',' or substr($vDefecto, $i, 1) == '.'){
                $vDef .= '.';
                $vDec = 0;
            }else{
                $vDef .= substr($vDefecto, $i, 1);
                if(intval(substr($vDefecto, $i, 1)) >= 0){
                    $vDec++;
                }
            }
        }
    }

    $vExe = '';
    for($i = 0; $i < strlen($vExcel); $i++){
        if(substr($vExcel, $i, 1) != '<'){
            if(substr($vExcel, $i, 1) == ',' or substr($vExcel, $i, 1) == '.'){
                $vExe .= '.';
            }else{
                $vExe .= substr($vExcel, $i, 1);
            }
        }
    }

    if($vExe > $vDef){
        $vExe = number_format($vExe, $vDec, '.', ',');
        if(substr($vExcel, 0, 1) == '<'){
            $vExe = '<'.number_format($vExe, $vDec, '.', ',');
        }
        $resultado = $vExe;

    }else{
        if($vExe == $vDef){
            $vDef = number_format($vExe, $vDec, '.', ',');
        }else{
            $vDef = number_format($vDef, $vDec, '.', ',');
            if(substr($vDefecto, 0, 1) == '<'){
                $vDef = '<'.number_format($vDef, $vDec, '.', ',');
            }
        }

        $resultado = $vDef;

    }

     return $resultado;
 }
 

?>