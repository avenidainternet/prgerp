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
<body ng-app="myApp" ng-controller="ctrlEspectometro">

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
								</select>	
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success" ng-click="registrarDatos()" >Registrar Datos</button>
                            </div>
                            <div class="col-md-10">
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
                    $row = 2;
                    $tpMuestra = $sheet->getCell("F".$row)->getValue();
                    
                    echo $tpMuestra;

                    $busqueda = 'Al';

                    switch ($tpMuestra) {
                        case '614-05':
                            $busqueda = 'Al';
                            break;
                        case '136-03':
                            $busqueda = 'Al';
                            break;
                        case 'P1':
                            $busqueda = 'Ac';
                            break;
                        case 'P2':
                            $busqueda = 'Ac';
                            break;
                        case 'P3':
                            $busqueda = 'Ac';
                            break;
                        case 'Fe-30+N':
                            $busqueda = 'Ac';
                            break;
                        case 'Cu-20':
                            $busqueda = 'Co';
                            break;
                    }

                    $v = substr($tpMuestra, 0, 2);
                    // echo $tpMuestra.' - ';
                    if ($busqueda == 'Al') {
                        $tpMuestra = 'Al';
                        $Aluminio   = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
                        $fd = explode('-',$Aluminio);

                    }else{
                        if($busqueda == 'Co') {
                            $tpMuestra = 'Co';
                            $Cobre      = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R';
                            $fd = explode('-',$Cobre);

                        }else{
                            $tpMuestra = 'Ac';
                            $Acero      = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG';
                            $fd = explode('-',$Acero);

                        }
                    }
                    $row = 2;
                    $RAM = $sheet->getCell("A".$row)->getValue();
                    $Programa = $sheet->getCell("F".$row)->getValue();
                    ?>
                    <div class="alert alert-success" ng-init="keyOtam('<?php echo $RAM; ?>', '<?php echo $tpMuestra; ?>')">
                        <strong>Resultados </strong> <?php echo '<b>Ensayo : '.$RAM.' Ensayo : '.$tpMuestra.'.</b>';?>
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php
                                    $row = 5;
                                    $elemento = $sheet->getCell("B".$row)->getValue();
                                    $col = 0;
                                    for($i=1; $i<=sizeof($fd); $i++){
                                        $col++;
                                        if($col <= 19){
                                            echo '<th>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</th>';
                                        }
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $row = 10;
                                $col = 0;
                                for($i=1; $i<=sizeof($fd); $i++){
                                    $col++;
                                    if($col <= 19){
                                     echo '<td>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</td>';
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php
                                    $row = 5;
                                    $elemento = $sheet->getCell("B".$row)->getValue();
                                    $col = 0;
                                    for($i=20; $i<=sizeof($fd); $i++){
                                        $col++;
                                        if($col <= 19){
                                            echo '<th>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</th>';
                                        }
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $row = 10;
                                $col = 0;
                                for($i=20; $i<=sizeof($fd); $i++){
                                    $col++;
                                    if($col <= 19){
                                        echo '<td>'.$sheet->getCell($fd[$i-1].$row)->getValue().'</td>';
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                    <?php
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
                    
                        $row = 10;
                        $rs  = 5;
                        for($i=1; $i<=sizeof($fd); $i++){
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'C')   { $cC = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Si')  { $cSi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Mn')  { $cMn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'P')   { $cP = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'S')   { $cS = $sheet->getCell($fd[$i-1].$row)->getValue();    }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Cr')  { $cCr = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Mo')  { $cMo = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ni')  { $cNi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Al')  { $cAl = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Co')  { $cCo = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Cu')  { $cCu = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Nb')  { $cNb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ti')  { $cTi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'V')   { $cV  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'W')   { $cW  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Pb')  { $cPb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Sn')  { $cSn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'As')  { $cAs = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Zr')  { $cZr = $sheet->getCell($fd[$i-1].$row)->getValue();   }

                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Bi')  { $cBi = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ca')  { $cCa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ce')  { $cCe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Sb')  { $cSb = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Se')  { $cSe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Te')  { $cTe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ta')  { $cTa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'B')   { $cB  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Zn')  { $cZn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ag')  { $cAg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'N')   { $cN  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Fe')  { $cFe = $sheet->getCell($fd[$i-1].$row)->getValue();   }

                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Mg')  { $cMg = $sheet->getCell($fd[$i-1].$row)->getValue();   }

                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ba')  { $cBa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Be')  { $cBe = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Cd')  { $cCd = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Ga')  { $cGa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Hg')  { $cHg = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'In')  { $cIn = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'La')  { $cLa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Na')  { $cNa = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Sr')  { $cSr = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Tl')  { $cTl = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Hf')  { $cHf = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Sc')  { $cSc = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Y')   { $cY  = $sheet->getCell($fd[$i-1].$row)->getValue();   }
                            if($sheet->getCell($fd[$i-1].$rs)->getValue() == 'Bg')  { $cBg = $sheet->getCell($fd[$i-1].$row)->getValue();   }

                        }
                        $outp = '';
                        $outp .= '{"RAM":"'  			    . $RAM 			. '",'; 
                        $outp .= '"Programa":"'  			. $Programa	    . '",';
                        $outp .= '"tpMuestra":"'  			. $tpMuestra	. '",';
                        $outp .= '"cC":"'  			        . $cC			. '",';
                        $outp .= '"cSi":"'  			    . $cSi			. '",';
                        $outp .= '"cMn":"'  			    . $cMn			. '",';
                        $outp .= '"cP":"'  			        . $cP			. '",';
                        $outp .= '"cS":"'  			        . $cS			. '",';
                        $outp .= '"cCr":"'  			    . $cCr			. '",';
                        $outp .= '"cMo":"'  			    . $cMo			. '",';
                        $outp .= '"cNi":"'  			    . $cNi			. '",';
                        $outp .= '"cAl":"'  			    . $cAl			. '",';
                        $outp .= '"cCo":"'  			    . $cCo			. '",';
                        $outp .= '"cCu":"'  			    . $cCu			. '",';
                        $outp .= '"cNb":"'  			    . $cNb			. '",';
                        $outp .= '"cTi":"'  			    . $cTi			. '",';
                        $outp .= '"cV":"'  			        . $cV			. '",';
                        $outp .= '"cW":"'  			        . $cW			. '",';
                        $outp .= '"cPb":"'  			    . $cPb			. '",';
                        $outp .= '"cSn":"'  			    . $cSn			. '",';
                        $outp .= '"cAs":"'  			    . $cAs			. '",';
                        $outp .= '"cZr":"'  			    . $cZr			. '",';
                        $outp .= '"cBi":"'  			    . $cBi 			. '",';
                        $outp .= '"cCa":"'  			    . $cCa			. '",';
                        $outp .= '"cCe":"'  			    . $cCe			. '",';
                        $outp .= '"cSb":"'  			    . $cSb 			. '",';
                        $outp .= '"cSe":"'  			    . $cSe 			. '",';
                        $outp .= '"cTe":"'  			    . $cTe			. '",';
                        $outp .= '"cTa":"'  			    . $cTa			. '",';
                        $outp .= '"cB":"'  			        . $cB			. '",';
                        $outp .= '"cZn":"'  			    . $cZn 			. '",';
                        $outp .= '"cAg":"'  			    . $cAg 			. '",';
                        $outp .= '"cN":"'  			        . $cN 			. '",';
                        $outp .= '"cFe":"'  			    . $cFe 			. '",';
                        $outp .= '"cMg":"'  			    . $cMg 			. '",';
                        $outp .= '"cBa":"'  			    . $cBa 			. '",';
                        $outp .= '"cBe":"'  			    . $cBe 			. '",';
                        $outp .= '"cCd":"'  			    . $cCd 			. '",';
                        $outp .= '"cGa":"'  			    . $cGa 			. '",';
                        $outp .= '"cHg":"'  			    . $cHg 			. '",';
                        $outp .= '"cIn":"'  			    . $cIn 			. '",';
                        $outp .= '"cLa":"'  			    . $cLa 			. '",';
                        $outp .= '"cNa":"'  			    . $cNa 			. '",';
                        $outp .= '"cSr":"'  			    . $cSr 			. '",';
                        $outp .= '"cTl":"'  			    . $cTl 			. '",';
                        $outp .= '"cHf":"'  			    . $cHf 			. '",';
                        $outp .= '"cSc":"'  			    . $cSc 			. '",';
                        $outp .= '"cY":"'  			        . $cY 			. '",';
                        $outp .= '"cBg":"'	    			. $cBg  		. '"}';
                        $outp ='{"records":['.$outp.']}';

                        $json_string = $outp;
                        //$file = 'X:\tallerPM\resultadosQu\vEspectrometro.json'; 
                        $file = 'resultadosQu\vEspectrometro.json'; 
                        file_put_contents($file, $json_string);
                        echo 'tpMuestra  '.$tpMuestra;
                        $idItem = $RAM;



                        $link=Conectarse();
                        $SQL = "Select * From regquimico Where idItem = '$idItem' and tpMuestra = '$tpMuestra'";
                        $SQL = "Select * From regquimico Where idItem = '$idItem'";
                        $bd=$link->query($SQL);
                        if($rs = mysqli_fetch_array($bd)){
                            $actSQL="UPDATE regquimico SET ";
                            $actSQL.="Programa		        = '".$Programa.	                    "',";
                            $actSQL.="tpMuestra		        = '".$tpMuestra.	                    "',";

                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'C'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cC = comparaValor($cC, $valorDefecto);
                                }

                            }
                            $actSQL.="cC		        = '".$cC.	                    "',";
                            
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Si'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSi = comparaValor($cSi, $valorDefecto);
                                }

                            }
                            $actSQL.="cSi		        = '".$cSi.	                     "',";
                            
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mn' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cMn = comparaValor($cMn, $valorDefecto);
                                }
                            }
                            $actSQL.="cMn		        = '".$cMn.	            "',";

                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'P' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cP = comparaValor($cP, $valorDefecto);
                                }
                            }
                            $actSQL.="cP		        = '".$cP.	            "',";

                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'S' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cS = comparaValor($cS, $valorDefecto);
                                }
                            }
                            $actSQL.="cS		        = '".$cS.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cr' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCr = comparaValor($cCr, $valorDefecto);
                                }
                            }
                            $actSQL.="cCr		        = '".$cCr.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mo' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cMo = comparaValor($cMo, $valorDefecto);
                                }
                            }
                            $actSQL.="cMo		        = '".$cMo.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ni' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cNi = comparaValor($cNi, $valorDefecto);
                                }
                            }
                            $actSQL.="cNi		        = '".$cNi.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mo' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cMo = comparaValor($cMo, $valorDefecto);
                                }
                            }
                            $actSQL.="cMo		        = '".$cMo.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Al' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cAl = comparaValor($cAl, $valorDefecto);
                                }
                            }
                            $actSQL.="cAl		        = '".$cAl.	            "',";
                                                            
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Co' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCo = comparaValor($cCo, $valorDefecto);
                                }
                            }
                            $actSQL.="cCo		        = '".$cCo.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cu' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCu = comparaValor($cCu, $valorDefecto);
                                }
                            }
                            $actSQL.="cCu		        = '".$cCu.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Nb' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cNb = comparaValor($cNb, $valorDefecto);
                                }
                            }
                            $actSQL.="cNb		        = '".$cNb.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ti' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cTi = comparaValor($cTi, $valorDefecto);
                                }
                            }
                            $actSQL.="cTi		        = '".$cTi.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'V' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cV = comparaValor($cV, $valorDefecto);
                                }
                            }
                            $actSQL.="cV		        = '".$cV.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'W' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cW = comparaValor($cW, $valorDefecto);
                                }
                            }
                            $actSQL.="cW		        = '".$cW.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Pb' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cPb = comparaValor($cPb, $valorDefecto);
                                }
                            }
                            $actSQL.="cPb		        = '".$cPb.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sn' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSn = comparaValor($cSn, $valorDefecto);
                                }
                            }
                            $actSQL.="cSn		        = '".$cSn.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'As' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cAs = comparaValor($cAs, $valorDefecto);
                                }
                            }
                            $actSQL.="cAs		        = '".$cAs.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zr' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cZr = comparaValor($cZr, $valorDefecto);
                                }
                            }
                            $actSQL.="cZr		        = '".$cZr.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bi' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cBi = comparaValor($cBi, $valorDefecto);
                                }
                            }
                            $actSQL.="cBi		        = '".$cBi.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ca' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCa = comparaValor($cCa, $valorDefecto);
                                }
                            }
                            $actSQL.="cCa		        = '".$cCa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ce' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCe = comparaValor($cCe, $valorDefecto);
                                }
                            }
                            $actSQL.="cCe		        = '".$cCe.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sb' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSb = comparaValor($cSb, $valorDefecto);
                                }
                            }
                            $actSQL.="cSb		        = '".$cSb.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Se' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSe = comparaValor($cSe, $valorDefecto);
                                }
                            }
                            $actSQL.="cSe		        = '".$cSe.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Te' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cTe = comparaValor($cTe, $valorDefecto);
                                }
                            }
                            $actSQL.="cTe		        = '".$cTe.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ta' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cTa = comparaValor($cTa, $valorDefecto);
                                }
                            }
                            $actSQL.="cTa		        = '".$cTa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'B' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cB = comparaValor($cB, $valorDefecto);
                                }
                            }
                            $actSQL.="cB		        = '".$cB.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Zn' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cZn = comparaValor($cZn, $valorDefecto);
                                }
                                
                            }
                            $actSQL.="cZn		        = '".$cZn.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ag' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cAg = comparaValor($cAg, $valorDefecto);
                                }
                            }
                            $actSQL.="cAg		        = '".$cAg.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Mg' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cMg = comparaValor($cMg, $valorDefecto);
                                }
                            }
                            $actSQL.="cMg		        = '".$cMg.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ba' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cBa = comparaValor($cBa, $valorDefecto);
                                }
                            }
                            $actSQL.="cBa		        = '".$cBa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Cd' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cCd = comparaValor($cCd, $valorDefecto);
                                }
                            }
                            $actSQL.="cCd		        = '".$cCd.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Ga' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cGa = comparaValor($cGa, $valorDefecto);
                                }
                            }
                            $actSQL.="cGa		        = '".$cGa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hg' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cHg = comparaValor($cHg, $valorDefecto);
                                }
                            }
                            $actSQL.="cHg		        = '".$cHg.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'In' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cIn = comparaValor($cIn, $valorDefecto);
                                }
                            }
                            $actSQL.="cIn		        = '".$cIn.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'La' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cLa = comparaValor($cLa, $valorDefecto);
                                }
                            }
                            $actSQL.="cLa		        = '".$cLa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Na' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cNa = comparaValor($cNa, $valorDefecto);
                                }
                            }
                            $actSQL.="cNa		        = '".$cNa.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sr' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSr = comparaValor($cSr, $valorDefecto);
                                }
                            }
                            $actSQL.="cSr		        = '".$cSr.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Tl' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cTl = comparaValor($cTl, $valorDefecto);
                                }
                            }
                            $actSQL.="cTl		        = '".$cTl.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Hf' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cHf = comparaValor($cHf, $valorDefecto);
                                }
                            }
                            $actSQL.="cHf		        = '".$cHf.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Sc' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cSc = comparaValor($cSc, $valorDefecto);
                                }
                            }
                            $actSQL.="cSc		        = '".$cSc.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Y' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cY = comparaValor($cY, $valorDefecto);
                                }
                            }
                            $actSQL.="cY		        = '".$cY.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Bg' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cBg = comparaValor($cBg, $valorDefecto);
                                }
                            }
                            $actSQL.="cBg		        = '".$cBg.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'N' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cN = comparaValor($cN, $valorDefecto);
                                }
                            }
                            $actSQL.="cN		        = '".$cN.	            "',";
                
                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Au' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cAu = comparaValor($cAu, $valorDefecto);
                                }
                            }
                            $actSQL.="cAu		        = '".$cAu.	            "',";
                
                




                            $bdd=$link->query("SELECT * FROM tabparensayos WHERE idEnsayo = 'Qu' and tpMuestra = '$tpMuestra' and Simbolo = 'Fe' and imprimible = 'on'");
                            if($rsd=mysqli_fetch_array($bdd)){
                                $valorDefecto = $rsd['valorDefecto'];
                                if($tpMuestra == 'Ac'){
                                    if($Programa == 'Fe-30+N'){
                                        $valorDefecto = $rsd['valorDefectoFe'];
                                    }
                                }
                                if($tpMuestra != 'Co'){
                                    $cFe = comparaValor($cFe, $valorDefecto);
                                }
                            }
                            $actSQL.="cFe		        = '".$cFe.	            "'";
                
                            $actSQL.="Where idItem 	    = '$idItem'";
                            // $actSQL.="Where idItem 	    = '$idItem' and tpMuestra = '$tpMuestra'";
                            $bdfRAM=$link->query($actSQL);
                                
                        }
                        $link->close();
                    ?>

                <?php
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
function comparaValor($vExcel, $vDefecto){
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