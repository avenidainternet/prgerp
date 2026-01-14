<?php
	session_start(); 
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: index.php");
	}

	
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	$Mm = "Junio";
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	$MesSueldo = "";

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	mysql_query("SELECT * FROM Sueldos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		mysql_close($link);
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<script src="../jquery/jquery-1.6.4.js"></script>
<script>
$(document).ready(function(){
	$("#SueldoBase").bind('keydown', function(event)
	{
		//alert(event.keyCode);
		if (event.keyCode == '9')
			{
	  		var Sb   = $(this).val();
			var Rut  = $("#Run").val();
			var Ppa  = $("#PeriodoPago").val();
			var data = 'search='+ Rut;
			var Pr = Math.round(Sb * 0.37);
			var Li = Math.round(Sb * 1.37);
			$("#Prevision").val(Pr);
			$("#Liquido").val(Li);
			
            $.ajax({
                data: data,
                type: "POST",
                url: "guardaSueldo.php",
                beforeSend: function(html) { // this happens before actual call
                    $("#Msg").html('');
               },
               success: function(Respuesta){ // this happens after we get results
					alert(Respuesta.split(",")[0]);
					$("#Liquido").html(Respuesta.split(",")[0]);
              }
            });   

			
			return 0;
			}
	});
});
</script>

<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/purchase_128.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php echo 'Calculo de Sueldos '.'<span id="BoxPeriodo">'.$pPago.'</span>'; ?>
				</strong>
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<?php
					echo '<a href="cSueldo.php?Proceso=1&Periodo='.$PeriodoPago.'" title="Calculo de Sueldo Funcionario">';
					echo '	<img src="../gastos/imagenes/export_32.png" width="28" height="28">';
					echo '</a>'
					?>
				</div>
				<div id="ImagenBarra">
					<a href="sueldos.php" title="Volver">
						<img src="../gastos/imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="sueldos.php" title="Principal">
						<img src="../gastos/imagenes/room_32.png" width="28" height="28">
					</a>
				</div>
			</div>
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 

							$link=Conectarse();
							$bdPr=mysql_query("SELECT * FROM Proyectos");
							if ($row=mysql_fetch_array($bdPr)){
								$Proyecto = $row['Proyecto'];
			    				echo "	<option value='CalculoSueldos.php?Proyecto=".$row['IdProyecto']."&MesSueldo=".$MesSueldo."'>".$row['IdProyecto']."</option>";
							}
							mysql_close($link);
						?>
					</select>

					<!-- Fitra por Fecha -->
	  					<select name='MesSueldo' id='MesSueldo' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$Mm){
										echo '<option selected value="CalculoSueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
									}else{
										if($i > strval($fd[1])){
											echo '<option style="opacity:.5; color:#ccc;" disabled value="CalculoSueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}else{
											echo '<option value="CalculoSueldos.php?Mm='.$Mes[$i].'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->
			</div>

			<?php
				echo '<div >';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center"><strong>N°	 			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>RUT				</strong></td>';
				echo '			<td  width="25%" align="center"><strong>Nombres			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Fecha Pago		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Base			</strong></td>';
				echo '			<td  width="10%" align="center"><strong>H.Extras		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Previsión		</strong></td>';
				echo '			<td  width="10%" align="center"><strong>Líquido		</strong></td>';
				echo '			<td colspan="2"  width="10%" align="center"><strong>Mes.'.$PeriodoPago.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$tSb 	= 0;
				$tEx 	= 0;
				$tPr 	= 0;
				$tLi 	= 0;
				$link=Conectarse();
				$bdProv=mysql_query("SELECT * FROM Personal Where TipoContrato = 'P' Order By Estado, Paterno Limit $inicio, $nRegistros");
				if ($row=mysql_fetch_array($bdProv)){
					DO{
						$bdSue=mysql_query("SELECT * FROM Sueldos Where Run = '".$row['Run']."' && PeriodoPago = '".$PeriodoPago."'");
						if ($rowSue=mysql_fetch_array($bdSue)){
							$n++;
							echo '<tr>';
							echo '	<td width="05%">'.$n.'</td>';
							echo '	<td width="10%">';
							echo 		$row['Run'];
							echo '	</td>';
							echo '	<td width="25%">';
							echo 		$row['Paterno'].' '.$row['Materno'].' '.$row['Nombres'];
							echo '	</td>';
							echo '	<td width="10%">';
										$fd = explode('-', $rowSue['FechaPago']);
										if($fd[1]>0){
											echo $fd[2].'-'.$fd[1].'-'.$fd[0];
											echo '<img src="../gastos/imagenes/Confirmation_32.png" width="20" height="20">';
										}else{
											echo '&nbsp;';
										}
							echo '	</td>';
							echo '	<td width="10%" align="right">'.number_format($rowSue['SueldoBase'], 0, ',', '.').'</td>';
							echo '	<td width="10%" align="right">'.number_format($rowSue['nHorasExtras'], 0, ',', '.').'		</td>';
							echo '	<td width="10%" align="right">'.number_format($rowSue['Prevision'], 0, ',', '.').'		</td>';
							echo '	<td width="10%" align="right">'.number_format($rowSue['Liquido'], 0, ',', '.').'			</td>';
    						echo '	<td width="5%"><a href="cSueldo.php?Proceso=2&Run='.$row['Run'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/corel_draw_128.png"   width="22" height="22" title="Editar y Confirmar Pago"></a></td>';
    						echo '	<td width="5%"><a href="cSueldo.php?Proceso=3&Run='.$row['Run'].'&Periodo='.$PeriodoPago.'"><img src="../gastos/imagenes/delete_32.png" 		 width="22" height="22" title="Eliminar"	></a></td>';
							$tSb += $rowSue['SueldoBase'];
							$tEx += $rowSue['nHorasExtras'];
							$tPr += $rowSue['Prevision'];
							$tLi += $rowSue['Liquido'];
						}
						echo '		</tr>';
					}WHILE ($row=mysql_fetch_array($bdProv));
				}
				mysql_close($link);
				echo '	</table>';
				if($tSb){
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
				echo '			<td width="50%" align="right">Total Mes '.$pPago.'</td>';
				echo '			<td width="10%" align="right">'.number_format($tSb , 0, ',', '.').'			</td>';
				echo '			<td width="10%" align="right">'.number_format($tEx  , 0, ',', '.').'			</td>';
				echo '			<td width="10%" align="right">'.number_format($tPr  , 0, ',', '.').'			</td>';
				echo '			<td width="10%" align="right">'.number_format($tLi, 0, ',', '.').'			</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
				echo '		</tr>';
				echo '	</table>';
				}				
				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
