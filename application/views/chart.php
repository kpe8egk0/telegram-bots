<?php
function JSdate($in,$type){
    if($type=='date'){
        //Dates are patterned 'yyyy-MM-dd'
        preg_match('/(\d{4})-(\d{2})-(\d{2})/', $in, $match);
    } elseif($type=='datetime'){
        //Datetimes are patterned 'yyyy-MM-dd hh:mm:ss'
        preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/', $in, $match);
    }

    $year = (int) $match[1];
    $month = (int) $match[2] - 1; // Month conversion between indexes
    $day = (int) $match[3];

    if ($type=='date'){
        return "Date($year, $month, $day)";
    } elseif ($type=='datetime'){
        $hours = (int) $match[4];
        $minutes = (int) $match[5];
        $seconds = (int) $match[6];
        return "Date($year, $month, $day, $hours, $minutes, $seconds)";
    }
}
?>
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
                        echo "['" . $i . "'," . $data->qty . '],';
                        $i++;
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

        function JSdate($in,$type){
            if($type=='date'){
                //Dates are patterned 'yyyy-MM-dd'
                preg_match('/(\d{4})-(\d{2})-(\d{2})/', $in, $match);
            } elseif($type=='datetime'){
                //Datetimes are patterned 'yyyy-MM-dd hh:mm:ss'
                preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/', $in, $match);
            }

            $year = (int) $match[1];
            $month = (int) $match[2] - 1; // Month conversion between indexes
            $day = (int) $match[3];

            if ($type=='date'){
                return "Date($year, $month, $day)";
            } elseif ($type=='datetime'){
                $hours = (int) $match[4];
                $minutes = (int) $match[5];
                $seconds = (int) $match[6];
                return "Date($year, $month, $day, $hours, $minutes, $seconds)";
            }
        }
    </script>
</head>
<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
<?php var_dump($chart_data)?>
</body>
</html>