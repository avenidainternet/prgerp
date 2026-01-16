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
                <div class="card" ng-show="resultadosSubidos">
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

        <div class="card m-2" ng-show="resultadosSubidos">
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
                    $busqueda = 'Al';
                    $v = substr($tpMuestra, 0, 2);
                    // echo $tpMuestra.' - ';
                    if (substr($tpMuestra, 0,2) == $busqueda) {
                        $tpMuestra = 'Al';
                        $Aluminio   = 'B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z-AA-AB-AC-AD-AE-AF-AG-AH-AI-AJ-AK-AL-AM-AN';
                        $fd = explode('-',$Aluminio);

                    }else{
                        $busqueda = 'Cu';
                        if (substr($tpMuestra, 0,2) == $busqueda) {
                            $tpMuestra = 'Cu';
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
                    <div class="alert alert-success">
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

                        }
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
   $resultado = '';
   $vDefectoBd = $vDefecto;
   $vDefecto = substr($vDefecto,1);
   if($vExcel == $vDefecto){
        $resultado = $vExcel;
        // $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
    }
    if($vExcel < $vDefecto){
        $resultado = $vDefectoBd;
        // $actSQL.="cC		    ='".$rsd['valorDefecto'].	"',";
    }
    if($vExcel > $vDefecto){
        $resultado = $vExcel;
        // $actSQL.="cC		    ='".$sheet->getCell("E".$row)->getValue().	"',";
    }
    return $resultado;
}
?>