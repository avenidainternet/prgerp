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
<h3 class="bg-light text-dark">Tabla Indicador Informes Emitidos </h3>
<table class="table table-hover table-bordered">
	<thead class="thead-light">
        <tr>
            <th style="padding-left:10px;" width="20%">
                Informes Emitidos
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
                                $SQL = "SELECT * FROM aminformes Where tpEnsayo = '".$rs['tpEnsayo']."' and year(fechaInforme) = '".$pAgno."' and month(fechaInforme) = '".$i."' Order By CodInforme";
                                //echo $SQL;
                                $bdc=$link->query($SQL);
                                while($rsc=mysqli_fetch_array($bdc)){

                                    $cuentaInformes++;
                                    $sumaInformesAnuales++;

                                }
                                if($cuentaInformes > 0){
                                    echo $cuentaInformes.'<br>';
                                }
                            echo '</td>';
                        }
                    ?>
                    <td class="text-center">
                        <?php
                            if($sumaInformesAnuales > 0){
                                echo $sumaInformesAnuales.'<br>';
                            }
                        ?>
                    </td>
                </tr>
            <?php
            }
            $link->close();
        ?>
	</tbody>
</table>