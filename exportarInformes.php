<?php
include_once("conexionli.php");
$Agno 	= $_GET['Agno'];
$Mes 	= $_GET['Mes'];

//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=informes.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>


		<table border="1" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr>
				<td colspan=18 height="40">Fecha :&nbsp;<?php echo date('Y-m-d'); ?>  </td>
			</tr>
			<tr>
				<td colspan=18 height="40" style="font-size:12px; font-weight:700" align="center">
					Informes realizados desde 01/07/2019 al 31/07/2020
				</td>
			</tr>
			<tr>
			  	<td style="color:#FFFFFF; background-color:#006699; font-size:12px;" height="25">				</td>
			  	<td>Informes		</td>
			  	<td>Clientes	    </td>
                <?php
                        $link=Conectarse();
                        $SQL = "SELECT * FROM amensayos Order By nEns Asc";
				        $bd=$link->query($SQL);
				        while ($rs=mysqli_fetch_array($bd)){
                            ?>
                                <td><?php echo $rs['idEnsayo']; ?></td>
                            <?php
                        }
                        $link->close();
                ?>
   			</tr>

            <?php
				$link=Conectarse();
                $n = 0;
                $SQL = "SELECT * FROM cotizaciones Where RAM > 0 and Fan = 0 and informeUP = 'on' and fechaInformeUP >= '2019-07-01' and fechaInformeUP <= '2020-07-31'";
				$bd=$link->query($SQL);
				while ($rs=mysqli_fetch_array($bd)){
                    $SQLc = "SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'";
                    $bdc=$link->query($SQLc);
                    if ($rsc=mysqli_fetch_array($bdc)){
                        $SQLi = "SELECT * FROM aminformes Where CodInforme like '%".$rs['RAM']."%'";
                        $bdi=$link->query($SQLi);
                        while ($rsi=mysqli_fetch_array($bdi)){
                            $n++;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $n; ?>
                                    </td>
                                    <td>
                                        <?php echo $rsi['CodInforme']; ?>
                                    </td>
                                    <td>
                                        <?php echo utf8_decode($rsc['Cliente']); ?>
                                    </td>
                                    <?php
                                        $SQLe = "SELECT * FROM amensayos Order By nEns Asc";
				                        $bde=$link->query($SQLe);
				                        while ($rse=mysqli_fetch_array($bde)){
                                            ?>
                                            <td>
                                                <?php 
                                                    $ne = 0;
                                                    
                                                    $SQLce = "SELECT * FROM amtabensayos Where CodInforme = '".$rsi['CodInforme']."' and idEnsayo = '".$rse['idEnsayo']."'";
				                                    $bdce=$link->query($SQLce);
				                                    while ($rsce=mysqli_fetch_array($bdce)){
                                                        $ne += $rsce['cEnsayos'];
                                                    }
                                                    
                                                    if($ne>0){
                                                        echo $ne;
                                                    }
                                                ?>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            <?php
                        }
                    }
				}
				$link->close();
			?>

		</table>
</body>
</html>