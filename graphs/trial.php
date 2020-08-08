<style>
body { background-color: #000; color: #fff; overflow-x: hidden; overflow-y: hidden;}
table {
  table-layout: fixed;
  width: 105%;
  height: 1000px;
  margin-left: -10%;
}
#chartdiv1 {
  width: 100%;
  height: 100%;
  margin-left: 0;
}

#chartdiv2 {
  width: 120%;
  height: 50%;
  margin-top: -60%;
  margin-left: -10%;
}

[title="JavaScript charts"] {
    visibility: hidden;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<?php
    date_default_timezone_set("Asia/Manila");
    $interval = "7 day ago";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $date_to = date('Y-m-d');
    $date_from = date("Y-m-d", strtotime($interval));
    $query = "SELECT DISTINCT source, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY source";
    $result1 = mysqli_query($conn, $query);
?>

<center><h1>Competitive Intelligence</h1>
  <h1>ADC/Behavioral Module Internal Benchmarking</h1>
  <h1>Sources - Weekly Pie Chart</h1>
</center><br><br><br>
<div id="html-content-holder" style="background-color: #000000; color: #FFFFFF;">
    <table>
    <tr>
        <th><div id="chartdiv1"></div></th>
        <th><div id="chartdiv2"></div></th>
    </tr>
    </table>
</div>

<script>
    var chart;

    function generateChartData1() {
        var chartData = [];
        <?php while($row = mysqli_fetch_array($result1)): ?>
            chartData.push({
                "Source": "<?php echo $row['source'] ?>",
                "Values": "<?php echo $row['counter'] ?>",
            });
        <?php endwhile;?>
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
  "titleField": "Source",
  "marginTop": "-50%",
  "labelText": "[[percents]]%<br>[[Source]]",
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.color = "#000000";
            chart.div.style.width = "130%";
            chart.marginLeft = "-20%";
            chart.marginTop = "0%";
            chart.fontSize = 20;
            chart.labelTickAlpha = 0.9;
            chart.labelTickColor = "#000000";
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.div.style.width = "100%";
                chart.marginLeft = "0%";
                chart.marginTop = "-50%";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.validateNow();
            }, 10);
        }
    }
});

AmCharts.makeChart("chartdiv2", {
    "theme": "black",
    "type": "serial",
    "startDuration": 0,
    "legend": {
        "align": "center",
        "position": "left",
        "markerType": "circle",
        "labelText": "[[title]]",
        "valueText": "",
        "valueWidth": 0,
        "fontSize":15,
    },
    "dataProvider":[
        <?php 
            $query = "SELECT * FROM charles_table_adc";
            $adc = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($adc)) {
                $query = "SELECT * FROM charles_table_source";
                $sources = mysqli_query($conn, $query);
                $curr_adc = $row['value'];
                echo '{';
                echo '"adc": "' . $curr_adc . '",';
                while($row1 = mysqli_fetch_array($sources)) {
                    $curr_source =  $row1['value'];
                    $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = '$curr_source' AND adc = '$curr_adc'";
                    $source = mysqli_query($conn, $query);
                    $source = mysqli_fetch_array($source);
                    echo '"' . $curr_source . '": ' . $source['counter'] . ',';
                }
                echo '},';
            }
        ?>
    ],
    "valueAxes": [{
        "unit": "",
        "position": "left",
        "title": "",
    }],
    "graphs": [
        <?php
            $query = "SELECT DISTINCT source, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY source";
            $sources = mysqli_query($conn, $query);
            $i = 0;
            while($row1 = mysqli_fetch_array($sources)) {
                $curr_source = $row1['source'];
                echo '{';
                echo '    "fillAlphas": 0.9,';
                echo '    "lineAlpha": 0.2,';
                echo '    "title": "'.$curr_source.'",';
                echo '    "type": "column",';
                echo '    "columnWidth": 0.7,';
                echo '    "valueField": "'.$curr_source.'",';
                echo '    "labelText": "[[value]]",';
                if($i > 0) {
                    echo '"clustered": true,';
                }
                echo '},';
                $i += 1;
            }
        ?>
    ],
    "plotAreaFillAlphas": 0.1,
    "categoryField": "adc",
    "categoryAxis": {
        "gridPosition": "start"
    },
    "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.graphs[0].color = "#000000";
            chart.graphs[1].color = "#000000";
            chart.legend.color = "#000000";
            chart.color = "#000000";
            chart.plotAreaFillColors = ["#A0A0A0"];
            chart.plotAreaFillAlphas = 0.1,
            chart.valueAxes[0].gridAlpha = 0.3;
            chart.valueAxes[0].gridColor = "#000000";
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.graphs[0].color = "#FFF";
                chart.graphs[1].color = "#FFF";
                chart.legend.color = "#FFF";
                chart.color = "#FFF";
                chart.plotAreaFillColors = ["#FFF"];
                chart.plotAreaFillAlphas = 0.1,
                chart.valueAxes[0].gridAlpha = 0.1;
                chart.valueAxes[0].gridColor = "#FFF";
                chart.validateNow();
            }, 10);
        }
    }
});

</script>

<script>
$(document).ready(function() {	
    $("#btn-Preview-Image").on('click', function () {
        html2canvas($("#html-content-holder"), {
                scale: 0.1
            }).then(function(canvas) {
                var a = document.createElement('a');
                a.href = canvas.toDataURL("image/png");
                a.download = 'myfile.png';
                a.click();
        });
    });
});

</script>