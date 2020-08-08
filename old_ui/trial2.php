<style>
body { background-color: #000; color: #fff; overflow-x: hidden;}
table {
  table-layout: fixed;
  width: 105%;
  height: 1000px;

}
#chartdiv1 {
  width: 110%;
  height: 100%;
}

#chartdiv2 {
  width: 100%;
  height: 100%;
}
</style>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>

<?php
    date_default_timezone_set("Asia/Manila");
    $interval = "7 day ago";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $date_to = date('Y-m-d');
    $date_from = date("Y-m-d", strtotime($interval));
    $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY adc";
    $result1 = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query);
    $_SESSION['current_graph'] = 0;
?>

<center><h1>Competitive Intelligence</h1>
  <h1>ADC/Behavioral Module Internal Benchmarking</h1>
  <h1>Sources - Weekly Pie Chart</h1>
</center><br>
<table>
  <tr>
    <th><div id="chartdiv1"></div></th>
    <th><div id="chartdiv2"></div></th>
  </tr>
</table>

<script>
    var chart;

    function generateChartData1() {
        var chartData = [];
        <?php while($row = mysqli_fetch_array($result1)): ?>
            chartData.push({
                "ADC": "<?php echo $row['adc'] ?>",
                <?php
                    if($row['adc'] == "Supported") {
                        echo '"Values": ' . $row['counter'] . ',';
                        echo "color: '#ed4747'";
                    } elseif($row['adc'] == "Not Encryptor") {
                        echo '"Values": ' . $row['counter'] . ',';
                        echo "color: '#ffb95e'";
                    } elseif($row['adc'] == "Escalation") {
                        echo '"Values": ' . $row['counter'] . ',';
                        echo "color: '#97e58b'";
                    } else {
                        echo '"Values": ' . $row['counter'] . ',';
                        echo "color: '#b674c1'";
                    }
                ?>
            });
        <?php endwhile;?>
        return chartData;
    }

    function generateChartData2() {
        var chartData = [];
        <?php 
            $adcs = array("Escalation", "Not Encryptor", "Not Supported", "Supported");
            for($i = 0; $i < 4; $i++) {
                $sources = "SELECT * FROM charles_table_source";
                $sources = mysqli_query($conn, $sources);
                while($row1 = mysqli_fetch_array($sources)) {
                    $curr_adc = $adcs[$i];
                    $curr_source = $row1['value'];
                    $source_type = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = '$curr_source' AND adc = '$curr_adc'";
                    $source_type = mysqli_query($conn, $source_type);
                    $source_type = mysqli_fetch_array($source_type);
                    echo 'chartData.push({';
                    echo    '"ADC": "' . $curr_source . '",';
                    echo    '"Values": ' . $source_type['counter'] . ',';
                    if($curr_adc == "Supported") {
                        echo "color: '#ed4747'";
                    } elseif($curr_adc == "Not Encryptor") {
                        echo "color: '#ffb95e'";
                    } elseif($curr_adc == "Escalation") {
                        echo "color: '#97e58b'";
                    } else {
                        echo "color: '#b674c1'";
                    }
                    echo '});';
                }
            } 
        ?>
        return chartData;
    }

AmCharts.makeChart("chartdiv1", {
  "type": "pie",
  "theme": "black",
  "startDuration": 0,
  "dataProvider": generateChartData1(),
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.8,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "valueField": "Values",
  "titleField": "ADC",
  "labelText": "[[percents]]%<br>[[value]] Samples",
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "export": {
    "enabled": true,
    },
    "legend": {
        "align": "center",
        "position": "right",
        "markerType": "circle",
        "labelText": "[[title]]",
        "valueText": "",
        "valueWidth": 0,
        "fontSize":15,
    },
});


AmCharts.makeChart("chartdiv2", {
  "type": "pie",
  "theme": "black",
  "startDuration": 0,
  "dataProvider": generateChartData2(),
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.8,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "valueField": "Values",
  "titleField": "ADC",
  "labelText": "[[Values]] from<br>[[ADC]]",
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "export": {
    "enabled": true
    },
});
</script>
