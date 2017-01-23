<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>test</title>
    <!-- Load Google chart api -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Reqs'],
                <?php
                foreach ($chart_data as $data) {
                    echo '[' . $data->day . ',' . $data->qty . '],';
                }
                ?>
            ]);

            var options = {
                chart: {
                    title: 'Reqs per Date',
                    subtitle: 'todo:',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>