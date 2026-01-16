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
<h3 class="bg-light text-dark">Tabla Indicador Informes Procesos </h3>
<table class="table table-hover table-bordered">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">
                Informes Procesos
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
            $cuentaProcesosMesuales  = array(
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
            while($rs=mysqli_fetch_array($bd)){
    
                
                ?>
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

                                $SQL = "SELECT * FROM cotizaciones Where Estado = 'T' and tpEnsayo = '".$rs['tpEnsayo']."' and year(fechaInicio) = '".$pAgno."' and month(fechaInicio) = '".$i."' Order By tpEnsayo";
                                //echo $SQL;
                                $bdc=$link->query($SQL);
                                while($rsc=mysqli_fetch_array($bdc)){



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
                        


                                    $cuentaInformes++;
                                    $sumaInformesAnuales++;
                                    $cuentaProcesosMesuales[$i]++;

                                    //$fechaEntrega 	= strtotime ( '+'.$rsc['dHabiles'].' day' , strtotime ( $rsc['fechaInicio'] ) );
                                    //$fechaEntrega 	= date ( 'Y-m-d' , $fechaEntrega );




                                    $nFeriados = 0;
                                    $SQLf = "SELECT * FROM diasferiados Where Periodo = '".$pAgno."' and month(fecha) = '".$i."' and fecha >= '".$fechaEntrega."' and fecha <= '".$fechaEntrega."'";
                                    $bdf=$link->query($SQLf);
                                    while($rsf=mysqli_fetch_array($bdf)){
                                        $nFeriados++;
                                    }
    

                                    //echo $rsc['RAM'].' '.$rsc['fechaInformeUP'] . ' ' . $fechaEntrega.'<br>';
                                    if($rsc['fechaTermino'] > $fechaEntrega){
                                        //$cuentaAtrasadas -= $nFeriados;
                                        //$sumaAtrasadosAnuales -= $nFeriados;
                                        $cuentaAtrasadas++;
                                        $sumaAtrasadosAnuales++;
                                        $cuentaAtrasosMesual[$i]++;
                                    }
                                }
                                if($cuentaAtrasadas > 0){
                                    $promedioAtrasadas = $cuentaAtrasadas / $cuentaInformes;
                                }
                                if($cuentaInformes > 0){
                                    echo $cuentaAtrasadas.'/'.$cuentaInformes.'<br>';
                                    if($promedioAtrasadas > 0){

                                        echo '<a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadas,2) .'</b></a>';
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
                Procesos Mesuales
            </td>
            <?php 
                for($i=1; $i<=12; $i++){
                    echo '<td class="text-center">';
                        if($cuentaAtrasosMesual[$i] > 0){
                            echo $cuentaAtrasosMesual[$i].'/'.$cuentaProcesosMesuales[$i];
                            $promedioAtrasadasMensual = $cuentaAtrasosMesual[$i] / $cuentaProcesosMesuales[$i];
                            echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasMensual,2) .'</b></a>';

                        }
                    echo '</td>';
                }
            ?>
            <td class="text-center">
                <?php
                    $totalAtrasosAnuales = 0;
                    $totalProcesosAnuales = 0;
                    for($i=1; $i<=12; $i++){
                        $totalAtrasosAnuales += $cuentaAtrasosMesual[$i];
                        $totalProcesosAnuales += $cuentaProcesosMesuales[$i];
                    }
                    if($totalAtrasosAnuales > 0){
                        echo $totalAtrasosAnuales.'/'.$totalProcesosAnuales;
                        $promedioAtrasadasAnual = $totalAtrasosAnuales / $totalProcesosAnuales;
                        echo '<br><a href="" class="btn btn-danger"><b>'. number_format($promedioAtrasadasAnual,2) .'</b></a>';

                    }
                ?>
            </td>
        </tr>
        
	</tbody>
</table>