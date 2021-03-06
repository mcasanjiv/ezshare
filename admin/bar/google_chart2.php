<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["imagebarchart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var chart = new google.visualization.ImageBarChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 400, height: 240, min: 0});
      }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>