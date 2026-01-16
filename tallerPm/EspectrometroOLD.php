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
                    $highestColumn = $sheet->getHighestColumn();?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Cód.    </th>
                                <th>
                                    <?php 
                                        $row = 5; 
                                        echo $sheet->getCell("B".$row)->getValue(); 
                                    ?>       
                                </th>
                                <th>
                                    <?php 
                                        $row = 5; 
                                        echo $sheet->getCell("C".$row)->getValue(); 
                                    ?>       
                                </th>
                                <th>Mn      </th>
                                <th>P       </th>
                                <th>S       </th>
                                <th>Cr      </th>
                                <th>Mo      </th>
                                <th>Ni      </th>
                                <th>Al      </th>
                                <th>Co      </th>
                                <th>Cu      </th>
                                <th>Nb      </th>
                                <th>Ti      </th>
                                <th>V       </th>
                                <th>W       </th>
                                <th>Pb       </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $num=0;
                                $row = 2;
                                $RAM = $sheet->getCell("A".$row)->getValue();
                                $Programa = $sheet->getCell("F".$row)->getValue();
                                $row = 10;
                                $cC     = $sheet->getCell("B".$row)->getValue();
                                $cSi    = $sheet->getCell("C".$row)->getValue();
                                $cMn    = $sheet->getCell("D".$row)->getValue();
                                $cP     = $sheet->getCell("E".$row)->getValue();
                                $cS     = $sheet->getCell("F".$row)->getValue();
                                $cCr    = $sheet->getCell("G".$row)->getValue();
                                $cMo    = $sheet->getCell("H".$row)->getValue();
                                $cNi    = $sheet->getCell("I".$row)->getValue();
                                $cAl    = $sheet->getCell("J".$row)->getValue();
                                $cCo    = $sheet->getCell("K".$row)->getValue();
                                $cCu    = $sheet->getCell("L".$row)->getValue();
                                $cNb    = $sheet->getCell("M".$row)->getValue();
                                $cTi    = $sheet->getCell("N".$row)->getValue();
                                $cV     = $sheet->getCell("O".$row)->getValue();
                                $cW     = $sheet->getCell("P".$row)->getValue();
                                $cPb    = $sheet->getCell("Q".$row)->getValue();
                                $cSn    = $sheet->getCell("R".$row)->getValue();
                                $cAs    = $sheet->getCell("S".$row)->getValue();
                                $cZr    = $sheet->getCell("T".$row)->getValue();
                                $cBi    = $sheet->getCell("U".$row)->getValue();
                                $cCa    = $sheet->getCell("V".$row)->getValue();
                                $cCe    = $sheet->getCell("W".$row)->getValue();
                                $cSb    = $sheet->getCell("X".$row)->getValue();
                                $cSe    = $sheet->getCell("Y".$row)->getValue();
                                $cTe    = $sheet->getCell("Z".$row)->getValue();
                                $cTa    = $sheet->getCell("AA".$row)->getValue();
                                $cB     = $sheet->getCell("AB".$row)->getValue();
                                $cZn    = $sheet->getCell("AC".$row)->getValue();
                                $cLa    = $sheet->getCell("AD".$row)->getValue();
                                $cAg    = $sheet->getCell("AE".$row)->getValue();
                                $cN     = $sheet->getCell("AF".$row)->getValue();
                                $cFe    = $sheet->getCell("AG".$row)->getValue();

                                $outp = '';
                                $outp .= '{"RAM":"'  			    . $RAM 			. '",'; 
                                $outp .= '"Programa":"'  			. $Programa	    . '",';
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
                                $outp .= '"cLa":"'  			    . $cLa 			. '",';
                                $outp .= '"cAg":"'  			    . $cAg 			. '",';
                                $outp .= '"cN":"'  			        . $cN 			. '",';
                                $outp .= '"cFe":"'	    			. $cFe  		. '"}';
                                $outp ='{"records":['.$outp.']}';
                                ?>
                                <tr>
                                    <td><b><?php echo $RAM;?></b>           </td>
                                    <td><?php echo $cC;?>                   </td>
                                    <td><?php echo $cSi?>                   </td>
                                    <td><?php echo $cMn?>                   </td>
                                    <td><?php echo $cP?>                    </td>
                                    <td><?php echo $cS?>                    </td>
                                    <td><?php echo $cCr?>                   </td>
                                    <td><?php echo $cMo?>                   </td>
                                    <td><?php echo $cNi?>                   </td>
                                    <td><?php echo $cAl?>                   </td>
                                    <td><?php echo $cCo?>                   </td>
                                    <td><?php echo $cCu?>                   </td>
                                    <td><?php echo $cNb?>                   </td>
                                    <td><?php echo $cTi?>                   </td>
                                    <td><?php echo $cV?>                    </td>
                                    <td><?php echo $cW?>                    </td>
                                    <td><?php echo $cPb?>                    </td>
                                </tr>
                                <tr>
                                    <th>Programa    </th>
                                    <th>Sn          </th>
                                    <th>As          </th>
                                    <th>Zr          </th>
                                    <th>Bi          </th>
                                    <th>Ca          </th>
                                    <th>Ce          </th>
                                    <th>Sb          </th>
                                    <th>Se          </th>
                                    <th>Te          </th>
                                    <th>Ta          </th>
                                    <th>B           </th>
                                    <th>Zn          </th>
                                    <th>La          </th>
                                    <th>Ag          </th>
                                    <th>N           </th>
                                    <th>Fe          </th>
                                </tr>
                                <tr>
                                    <td><?php echo $Programa;?>             </td>
                                    <td><?php echo $cSn;?>                  </td>
                                    <td><?php echo $cAs?>                   </td>
                                    <td><?php echo $cZr?>                   </td>
                                    <td><?php echo $cBi?>                   </td>
                                    <td><?php echo $cCa?>                   </td>
                                    <td><?php echo $cCe?>                   </td>
                                    <td><?php echo $cSb?>                   </td>
                                    <td><?php echo $cSe?>                   </td>
                                    <td><?php echo $cTe?>                   </td>
                                    <td><?php echo $cTa?>                   </td>
                                    <td><?php echo $cB?>                    </td>
                                    <td><?php echo $cZn?>                   </td>
                                    <td><?php echo $cLa?>                   </td>
                                    <td><?php echo $cAg?>                   </td>
                                    <td><?php echo $cN?>                    </td>
                                    <td><?php echo $cFe?>                   </td>
                                </tr>

                            <?php
                            
                            $json_string = $outp;
                            //$file = 'X:\tallerPM\resultadosQu\vEspectrometro.json'; 
                            $file = 'resultadosQu\vEspectrometro.json'; 
                            file_put_contents($file, $json_string);
                            ?>
                            <script>
                            //    window.location.href = 'lectorEspectrometroJSON.php';
                            </script>

                        </tbody>
                    </table>
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