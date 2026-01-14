<?php
	$link=Conectarse();
	$tVtas = 0;
	$bdVta  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = 2015");
	if($rowVta=mysql_fetch_array($bdVta)){
		do{
			$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowVta['RutCli']."'");
			if($rowCli=mysql_fetch_array($bdCli)){
				$cFree = $rowCli['cFree'];
				if($rowCli['cFree'] != 'on'){
					if($rowVta['Neto']>0){
						$tVtas += $rowVta['Neto'];
					}
				}
			}
		}while ($rowVta=mysql_fetch_array($bdVta));
	}
	$v2015 = $tVtas;

	$tGtos = 0;
	$bdGto  = mysql_query("SELECT sum(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = 2015");
	$rowGas	 = mysql_fetch_array($bdGto);
	if($rowGas['tBruto']>0){
		$tGtos += $rowGas['tBruto'];
	}
	
	$Agno 	= 2015;
	$tSue 	= 0;
	$tHon 	= 0;
	$tFac	= 0;
	
	$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago Like '%".$Agno."%'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tLiquido']>0){
		$tSue += $rowGas['tLiquido'];
	}

	$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE PeriodoPago Like '%".$Agno."%' and TpCosto != 'I'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tTotal']>0){
		$tHon += $rowGas['tTotal'];
	}
	
	$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE year(FechaPago) = '".$Agno."'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tBruto']>0){
		$tFac += $rowGas['tBruto'];
	}

	$g2015 = $tGtos + $tSue + $tHon + $tFac;
	
	/**********************************************************************************/
	$tVtas = 0;
	$bdVta  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = 2014");
	if($rowVta=mysql_fetch_array($bdVta)){
		do{
			$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowVta['RutCli']."'");
			if($rowCli=mysql_fetch_array($bdCli)){
				$cFree = $rowCli['cFree'];
				if($rowCli['cFree'] != 'on'){
					if($rowVta['Neto']>0){
						$tVtas += $rowVta['Neto'];
					}
				}
			}
		}while ($rowVta=mysql_fetch_array($bdVta));
	}
	$v2014 = $tVtas;

	$tGtos = 0;
	$bdGto  = mysql_query("SELECT sum(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = 2014");
	$rowGas	 = mysql_fetch_array($bdGto);
	if($rowGas['tBruto']>0){
		$tGtos += $rowGas['tBruto'];
	}

	$Agno = 2014;
	$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago Like '%".$Agno."%'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tLiquido']>0){
		$tSue += $rowGas['tLiquido'];
	}

	$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE PeriodoPago Like '%".$Agno."%' and TpCosto != 'I'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tTotal']>0){
		$tHon += $rowGas['tTotal'];
	}
	
	$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE year(FechaPago) = '".$Agno."'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tBruto']>0){
		$tFac += $rowGas['tBruto'];
	}

	$g2014 = $tGtos + $tSue + $tHon + $tFac;
	
	/**********************************************************************************/
	$tVtas = 0;
	$bdVta  = mysql_query("SELECT * FROM SolFactura WHERE Estado = 'I' and year(fechaSolicitud) = 2013");
	if($rowVta=mysql_fetch_array($bdVta)){
		do{
			$bdCli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowVta['RutCli']."'");
			if($rowCli=mysql_fetch_array($bdCli)){
				$cFree = $rowCli['cFree'];
				if($rowCli['cFree'] != 'on'){
					if($rowVta['Neto']>0){
						$tVtas += $rowVta['Neto'];
					}
				}
			}
		}while ($rowVta=mysql_fetch_array($bdVta));
	}
	$v2013 = $tVtas;

	$bdGto  = mysql_query("SELECT sum(Bruto) as tBruto FROM MovGastos WHERE Modulo = 'G' && year(FechaGasto) = 2013");
	$rowGas	 = mysql_fetch_array($bdGto);
	if($rowGas['tBruto']>0){
		$tGtos += $rowGas['tBruto'];
	}

	$Agno = 2014;
	$result  = mysql_query("SELECT SUM(Liquido) as tLiquido FROM Sueldos WHERE PeriodoPago Like '%".$Agno."%'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tLiquido']>0){
		$tSue += $rowGas['tLiquido'];
	}

	$result  = mysql_query("SELECT SUM(Total) as tTotal FROM Honorarios WHERE PeriodoPago Like '%".$Agno."%' and TpCosto != 'I'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tTotal']>0){
		$tHon += $rowGas['tTotal'];
	}
	
	$result  = mysql_query("SELECT SUM(Bruto) as tBruto FROM Facturas WHERE year(FechaPago) = '".$Agno."'");
	$rowGas	 = mysql_fetch_array($result);
	if($rowGas['tBruto']>0){
		$tFac += $rowGas['tBruto'];
	}

	$g2013 = $tGtos + $tSue + $tHon + $tFac;
	
	/**********************************************************************************/
	
	$vAgnos = array($v2013, $v2014, $v2015);
	
	mysql_close($link);
	echo '
	<table width="40%" border="1" cellpadding="0" cellspacing="0" style=" margin:10px; font-size:20px;">
		<tr style="background-color:#666666; color:#FFFFFF; font-weight:700;" align="center">
			<td width="20%" height="40">Años		</td>
			<td width="40%" height="40">Ventas		</td>
			<td width="40%" height="40">Gastos		</td>
		</tr>
		<tr>
			<td align="center">2013</td>
			<td align="center">'.number_format($v2013, 0, ',', '.').'</td>
			<td align="center">'.number_format($g2013, 0, ',', '.').'</td>
		</tr>
		<tr>
			<td align="center">2014</td>
			<td align="center">'.number_format($v2014, 0, ',', '.').'</td>
			<td align="center">'.number_format($g2014, 0, ',', '.').'</td>
		</tr>
		<tr>
			<td align="center">2015</td>
			<td align="center">'.number_format($v2015, 0, ',', '.').'</td>
			<td align="center">'.number_format($g2015, 0, ',', '.').'</td>
		</tr>
	</table>';
?>

    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  	var v2013 = '<?php echo $v2013; ?>';
	  	var v2014 = '<?php echo $v2014; ?>';
	  	var v2015 = '<?php echo $v2015; ?>';
		v2013 = parseInt(v2013/1000000);
		v2014 = parseInt(v2014/1000000);
		v2015 = parseInt(v2015/1000000);

	  	var g2013 = '<?php echo $g2013; ?>';
	  	var g2014 = '<?php echo $g2014; ?>';
	  	var g2015 = '<?php echo $g2015; ?>';
		g2013 = parseInt(g2013/1000000);
		g2014 = parseInt(g2014/1000000);
		g2015 = parseInt(g2015/1000000);

		var vAgnos=<?php echo json_encode($vAgnos);?>;

		/*
		for(i=0; i<vAgnos.length; i++){
			alert(vAgnos[i]);
		}
		*/

		var vTit = ['Años','Ventas','Gastos'];
		var vReg = new Array();
/*
		for(i=0; i<vAgnos.length; i++){
			for(v=0; v=3; v++){
				for(g=0; g=3; g++){
					vReg[i,v,g] = vAgnos[i];
				}
			}
		}
*/
		var vTabla = [
					 vTit,
					 vReg
					 ];

        var data = google.visualization.arrayToDataTable([
          ['Años', 'Ventas', 'Gastos'],
          ['2013', v2013, g2013],
          ['2014', v2014, g2014],
          ['2015', v2015, g2015]
        ]);

//        var data = google.visualization.arrayToDataTable(vTabla);

        var options = {
          chart: {
            title: 'SIMET USACH',
            subtitle: 'Estadística de Ventas y Gastos por años',
          },
		  annotations: {
		  	fontSize: 30,
			opacity: 0.2,
		  },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, options);
      }
    </script>

    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
