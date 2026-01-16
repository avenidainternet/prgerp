<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  	var v2013 = 700;
	  	var v2014 = 800;
	  	var v2015 = 900;
        var data = google.visualization.arrayToDataTable([
          ['Años', 'Ventas', 'Gastos', 'Utilidad'],
          ['2013', v2013, 400, 200],
          ['2014', v2014, 460, 250],
          ['2015', v2015, 1120, 300]
        ]);

        var options = {
          chart: {
            title: 'SIMET USACH',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
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
  </head>
  <body>
    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
  </body>
</html>