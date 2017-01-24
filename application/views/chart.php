<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>test</title>
    <!-- Load Google chart api -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Reqs'],
                <?php
                    $i = 0;
                foreach ($chart_data as $data) {
                    echo '[' . $i++ . ',' . $data->qty . '],';
                }
                ?>
            ]);

            var options = {
                title: 'Company Performance',
                curveType: 'none',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>