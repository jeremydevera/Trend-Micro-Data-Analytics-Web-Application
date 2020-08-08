<style>
body { background-color: #000; color: #fff; }
table {
  table-layout: fixed;
  width: 100%;
  height: 1000px;

}
#chartdiv1 {
  width: 100%;
  height: 100%;
}

#chartdiv2 {
  width: 100%;
  height: 100%;
}

[title="JavaScript charts"] {
    visibility: hidden;
}
</style>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>

<?php
    date_default_timezone_set("Asia/Manila");
    $interval = "1 day ago";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $date_to = date('Y-m-d');
    $date_from = date("Y-m-d", strtotime($interval));
    $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY adc";
    $result1 = mysqli_query($conn, $query);
    date_default_timezone_set("Asia/Manila");
    $interval = "7 day ago";
    $date_from = date("Y-m-d", strtotime($interval));
    $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY adc";
    $result2 = mysqli_query($conn, $query);
    $_SESSION['current_graph'] = 0;
?>

<center><h1>Competitive Intelligence</h1>
  <h1>ADC/Behavioral Module Internal Benchmarking</h1>
  <h1>Daily / Weekly Pie Chart</h1>
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
                "Values": <?php echo $row['counter']; ?>,
                <?php
                    if($row['adc'] == "Supported") {
                        echo "color: '#ed4747'";
                    } elseif($row['adc'] == "Not Encryptor") {
                        echo "color: '#ffb95e'";
                    } elseif($row['adc'] == "Escalation") {
                        echo "color: '#97e58b'";
                    } else {
                        echo "color: '#b674c1'";
                    }
                ?>
            });
        <?php endwhile;?>
        if (chartData === undefined || chartData.length == 0) {
            chartData.push({
                "ADC": "No Samples Today<br>",
                "Values": 1,
                "color": '#000000',
            });
        }
        return chartData;
    }

    function generateChartData2() {
        var chartData = [];
        <?php while($row = mysqli_fetch_array($result2)): ?>
            chartData.push({
                "ADC": "<?php echo $row['adc'] ?>",
                "Values": <?php echo $row['counter']; ?>,
                <?php
                    if($row['adc'] == "Supported") {
                        echo "color: '#ed4747'";
                    } elseif($row['adc'] == "Not Encryptor") {
                        echo "color: '#ffb95e'";
                    } elseif($row['adc'] == "Escalation") {
                        echo "color: '#97e58b'";
                    } else {
                        echo "color: '#b674c1'";
                    }
                ?>
            });
        <?php endwhile;?>
        if (chartData === undefined || chartData.length == 0) {
            chartData.push({
                "ADC": "No Samples<br>This Week",
                "Values": 1,
                "color": '#000000',
            });
        }
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
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.color = "#000000";
            chart.div.style.width = "150%";
            chart.marginLeft = "-35%";
            chart.marginTop = "0%";
            chart.fontSize = 20;
            chart.labelTickAlpha = 0.9;
            chart.labelTickColor = "#000000";
            chart.legend.color = "#000000";
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.legend.color = "#FFF";
                chart.div.style.width = "100%";
                chart.marginLeft = "0%";
                chart.marginTop = "0%";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.validateNow();
            }, 10);
        }
    },
  "legend":{
    "fontSize":15,
    "align": "center"
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
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.color = "#000000";
            chart.div.style.width = "120%";
            chart.marginLeft = "-20%";
            chart.marginTop = "0%";
            chart.fontSize = 20;
            chart.labelTickAlpha = 0.9;
            chart.labelTickColor = "#000000";
            chart.legend.color = "#000000";
            chart.legend.fontSize = 20;
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.legend.color = "#FFF";
                chart.div.style.width = "100%";
                chart.marginLeft = "0%";
                chart.marginTop = "0%";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.legend.fontSize = 15;
                chart.validateNow();
            }, 10);
        }
    },
  "legend":{
    "fontSize":15,
    "align": "center"
  },
});
</script>

<?php
	include 'nextgraph.php';
?>