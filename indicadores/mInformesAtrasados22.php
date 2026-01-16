	<?php

	$tEnsMes = array(
					1 => 0, 
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 0
				);
/*
										
    $fechaTermino 	= strtotime ( '+'.$rowCp['dHabiles'].' day' , strtotime ( $rowCp['fechaInicio'] ) );
    $fechaTermino 	= date ( 'Y-m-d' , $fechaTermino );
*/

	
	?>
<h3 class="bg-light text-dark">Tabla Indicador Informes Atrasados </h3>
<table class="table table-hover table-bordered">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">
                Informes Atrasados
            </th>
            <?php
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">'.substr($Mes[$i],0,3).'.'.'</td>';
                }
            ?>
            <td class="text-center">Tot.</td>
        </tr>
	</thead>
	<tbody>
        <?php
            $cuentaAtrasosMesual  = array(
                1 => 0, 
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0
            );
            $cuentaInformesMesuales  = array(
                1 => 0, 
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0
            );
        
        	$link=Conectarse();
        	$bd=$link->query("SELECT * FROM amtpensayo Order By tpEnsayo");
            while($rs=mysqli_fetch_array($bd)){?>
                <tr>
                    <td>
                        <?php echo $rs['Ensayo']; ?>
                    </td>
                    <?php 
                        $sumaInformesAnuales    = 0;
                        $sumaAtrasadosAnuales   = 0;
                        $promedioAtrasadasAnual = 0;
                        for($i=1; $i<=12; $i++){
                            echo '<td class="text-center">';
                                $cuentaInformes     = 0;
                                $cuentaAtrasadas    = 0;
                                $promedioAtrasadas  = 0;
                                // $pAgno = 2025;
                                $SQL = "SELECT * FROM cotizaciones Where Estado = 'T' and (Fan = 1 or Fan = 0) and tpEnsayo = '".$rs['tpEnsayo']."' and year(fechaInicio) = '".$pAgno."' and month(fechaInicio) = '".$i."' Order By tpEnsayo";
                                // echo $SQL;
                                $bdc=$link->query($SQL);
                                while($rsc=mysqli_fetch_array($bdc)){
                                    // echo 'RAM:'.$rsc['RAM'].' <br';



                                    $fechaInicio = $rsc['fechaInicio'];
                                    $dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
                                    $ft = $fechaInicio;
                                    $dh	= $rsc['dHabiles'] - 1;
                        
                                    $dd	= 0;
                                    for($j=1; $j<=$dh; $j++){
                                        $ft	= strtotime ( '+'.$j.' day' , strtotime ( $fechaInicio ) );
                                        $ft	= date ( 'Y-m-d' , $ft );
                                        //echo $ft.'<br>';
                                        $dia_semana = date("w",strtotime($ft));
                                        if($dia_semana == 0 or $dia_semana == 6){
                                            $dh++;
                                            $dd++;
                                        }
                                        $SQLf = "SELECT * FROM diasferiados Where fecha = '".$ft."'";
                                        $bdDf=$link->query($SQLf);
                                        if($row=mysqli_fetch_array($bdDf)){
                                            $dh++;
                                            $dd++;
                                        }
                                    }

                                    $fechaTermino = $ft;
                                    $fechaEntrega = $ft;
                        

                                    $nFeriados = 0;
                                    // if($rsc['Fan'] == 1 or $rsc['Fan'] == 0){
                                        $cuentaInformes         +=$rsc['nInforme'];
                                        $sumaInformesAnuales    +=$rsc['nInforme'];
                                        $cuentaInformesMesuales[$i] +=$rsc['nInforme'];
                                    // }
                                    

                                    //$fechaEntrega 	= strtotime ( '+'.$rsc['dHabiles'].' day' , strtotime ( $rsc['fechaInicio'] ) );
                                    //$fechaEntrega 	= date ( 'Y-m-d' , $fechaEntrega );




                                    // $nFeriados = 0;
                                    // $SQLf = "SELECT * FROM diasferiados Where Periodo = '".$pAgno."' and month(fecha) = '".$i."' and fecha >= '".$fechaEntrega."' and fecha <= '".$fechaEntrega."'";
                                    // $bdf=$link->query($SQLf);
                                    // while($rsf=mysqli_fetch_array($bdf)){
                                    //     $nFeriados++;
                                    // }
    

                                    //echo $rsc['RAM'].' '.$rsc['fechaInformeUP'] . ' ' . $fechaEntrega.'<br>';
                                    if($rsc['fechaTermino'] > $fechaEntrega){
                                    // if($rsc['fechaInformeUP'] > $rsc['fechaTermino']){
                                        //$cuentaAtrasadas -= $nFeriados;
                                        //$sumaAtrasadosAnuales -= $nFeriados;
                                        $cuentaAtrasadas            +=$rsc['nInforme'] ;
                                        $sumaAtrasadosAnuales       +=$rsc['nInforme'];
                                        $cuentaAtrasosMesual[$i]    +=$rsc['nInforme'];
                                    }
                                }
                                if($cuentaAtrasadas > 0){
                                    if($cuentaInformes > 0){
                                        $promedioAtrasadas = $cuentaAtrasadas / $cuentaInformes;
                                    }
                                }
                                if($cuentaInformes > 0){
                                    if($cuentaInformes > 0){
                                        echo $cuentaAtrasadas.'/'.$cuentaInformes.'<br>';
                                        if($promedioAtrasadas > 0){
    
                                            echo '<a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadas,2) .'</b></a>';
                                        }
                                    }
                                }
                            echo '</td>';
                        }
                    ?>
                    <td class="text-center">
                        <?php
                            if($sumaInformesAnuales > 0){
                                if($sumaAtrasadosAnuales > 0){
                                    echo $sumaAtrasadosAnuales. '/' .$sumaInformesAnuales.'<br>';
                                    $promedioAtrasadasAnual = $sumaAtrasadosAnuales / $sumaInformesAnuales;
                                    echo '<a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasAnual,2) .'</b></a>';
                                }else{
                                    echo $sumaAtrasadosAnuales. '/' .$sumaInformesAnuales.'<br>';
                                }
                            }
                        ?>
                    </td>
                </tr>
            <?php
            }
            $link->close();
        ?>
        <tr class="table-info">
            <td>
                Atrasos Mesuales
            </td>
            <?php 
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                        if($cuentaAtrasosMesual[$i] > 0){
                            echo $cuentaAtrasosMesual[$i].'/'.$cuentaInformesMesuales[$i];
                            $promedioAtrasadasMensual = $cuentaAtrasosMesual[$i] / $cuentaInformesMesuales[$i];
                            echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasMensual,2) .'</b></a>';

                        }
                    echo '</td>';
                }
            ?>
            <td class="text-center">
                <?php
                    $totalAtrasosAnuales = 0;
                    $totalInformesAnuales = 0;
                    for($i=1; $i<=12; $i++){
                        $totalAtrasosAnuales += $cuentaAtrasosMesual[$i];
                        $totalInformesAnuales += $cuentaInformesMesuales[$i];
                    }
                    if($totalAtrasosAnuales > 0){
                        echo $totalAtrasosAnuales.'/'.$totalInformesAnuales;
                        $promedioAtrasadasAnual = $totalAtrasosAnuales / $totalInformesAnuales;
                        echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasAnual,2) .'</b></a>';

                    }
                ?>
            </td>
        </tr>

	</tbody>
</table>

<table class="table table-hover table-bordered">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">
                Certificaciones
            </th>
            <?php
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">'.substr($Mes[$i],0,3).'.'.'</td>';
                }
            ?>
            <td class="text-center">Tot.</td>
        </tr>
	</thead>
	<tbody>
        <tr>
            <td>
                Certificaciones
            </td>
            <?php 
                $linkc=ConectarseCert(); 
                $link=Conectarse();

                $cCertificadosAnualesAtrasados  = 0;
                $tCertificadosAnualesAtrasados  = 0;
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                        $tCertificados                  = 0;
                        $tCertificadosAnuales           = 0;
                        $tCertificadosAtrasados         = 0;
                        $cCertificadosAtrasados         = 0;
                        $promedioAtrasadasMensual       = 0;

                        $SQL = "SELECT * FROM cotizaciones Where Estado = 'T' and tpEnsayo = '5' and year(fechaInicio) = '".$pAgno."' and month(fechaInicio) = '".$i."' Order By tpEnsayo";
                        // echo $SQL;
                        $bdc=$link->query($SQL);
                        while($rsc=mysqli_fetch_array($bdc)){
                            $ar = substr($rsc['Observacion'],0,7);

                            $SQL = "SELECT * FROM certificado Where Codcertificado like '%".$ar."%'";
                            // echo $SQL;
                            $bd=$linkc->query($SQL);
                            while($rs=mysqli_fetch_array($bd)){
                                $tCertificados++;
                                $tCertificadosAnuales++;
                                $tCertificadosAnualesAtrasados++;
                                if($rs['fechaUpLoad'] > $rsc['fechaInformeUP']){
                                    $tCertificadosAtrasados++;
                                    $cCertificadosAnualesAtrasados++;
                                }

                                if($tCertificadosAtrasados > 0){
                                    $promedioAtrasadasMensual = $tCertificadosAtrasados / $tCertificados;

                                }

                            }
                        }
                        if($tCertificados > 0){
                            echo $tCertificadosAtrasados.'/'.$tCertificados;
                            echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasMensual,2) .'</b></a>';
                        }
                    echo '</td>';
                }

                $linkc->close();
                $link->close();

            ?>
            <td>
                <?php
                    if($tCertificadosAnualesAtrasados > 0){
                        echo $cCertificadosAnualesAtrasados. '/' .$tCertificadosAnualesAtrasados.'<br>';
                        $promedioAtrasadasAnual = $cCertificadosAnualesAtrasados / $tCertificadosAnualesAtrasados;
                        echo '<a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasAnual,2) .'</b></a>';
                    }
                ?>
            </td>

        </tr>
    </tbody>
</table>


<!-- <table class="table table-hover table-bordered">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">
                Certificaciones
            </th>
            <?php
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">'.substr($Mes[$i],0,3).'.'.'</td>';
                }
            ?>
            <td class="text-center">Tot.</td>
        </tr>
	</thead>
	<tbody>
        <tr>
            <td>
                Certificaciones
            </td>
            <?php 
                $linkc=ConectarseCert(); 
                $link=Conectarse();

                $cCertificadosAnualesAtrasados  = 0;
                $tCertificadosAnualesAtrasados  = 0;
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                        $tCertificados                  = 0;
                        $tCertificadosAnuales           = 0;
                        $tCertificadosAtrasados         = 0;
                        $cCertificadosAtrasados         = 0;
                        $promedioAtrasadasMensual       = 0;
                        $SQL = "SELECT * FROM certificado Where CodInforme != '' and year(fechaUpLoad) = '".$pAgno."' and month(fechaUpLoad) = '".$i."' Order By fechaUpLoad desc";
                        // echo $SQL;
                        $bd=$linkc->query($SQL);
                        while($rs=mysqli_fetch_array($bd)){
                            if($rs['fechaUpLoad'] != '0000-00-00'){
                                $fd = explode('-', $rs['CodInforme']);

                                if($fd[1] != ''){
                                    $RAM = $fd[1]; 
                                }

                                $tCertificados++;
                                $tCertificadosAnuales++;
                                $tCertificadosAnualesAtrasados++;
                                $fc = explode('-', $rs['CodCertificado']);
                                $ar = $fc[0].'-'.$fc[1];
                                $SQLc = "SELECT * FROM cotizaciones Where RAM = '".$RAM."' and Observacion like '%".$ar."%'";
                                $bdcr=$link->query($SQLc);
                                if($rscr=mysqli_fetch_array($bdcr)){
                                    // echo $SQL.'<br>';
                                    if($rs['fechaUpLoad'] > $rscr['fechaInformeUP']){
                                        $tCertificadosAtrasados++;
                                        $cCertificadosAnualesAtrasados++;
                                    }

                                }
                                if($tCertificadosAtrasados > 0){
                                    $promedioAtrasadasMensual = $tCertificadosAtrasados / $tCertificados;

                                }

                            }
                        }
                        if($tCertificados > 0){
                            echo $tCertificadosAtrasados.'/'.$tCertificados;
                            echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasMensual,2) .'</b></a>';
                        }
                    echo '</td>';
                }

                $linkc->close();
                $link->close();

            ?>
            <td>
                <?php
                    if($tCertificadosAnualesAtrasados > 0){
                        echo $cCertificadosAnualesAtrasados. '/' .$tCertificadosAnualesAtrasados.'<br>';
                        $promedioAtrasadasAnual = $cCertificadosAnualesAtrasados / $tCertificadosAnualesAtrasados;
                        echo '<a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasAnual,2) .'</b></a>';
                    }
                ?>
            </td>

        </tr>
    </tbody>
</table> -->
