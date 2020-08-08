<!-- Styles -->
<style>
body {
    background-color: #000;
    color: #fff;
}
#chartdiv {
	width: 100%;
	height: 70%;
    font-size: 11px;
}
[title="JavaScript charts"] {
    visibility: hidden;
}
</style>

<?php
  $_SESSION['current_graph'] = 6;
  date_default_timezone_set("Asia/Manila");
  $conn = mysqli_connect("localhost", "root", "", "charles_db");
  $query = "SELECT * FROM (SELECT DISTINCT date_sourced, COUNT(*) as counter FROM charles_table_primary GROUP BY date_sourced ORDER by date_sourced DESC LIMIT 7) AS temp GROUP BY date_sourced ORDER by date_sourced";
  $result = mysqli_query($conn, $query);
?>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container-fluid">
  <center><h1>Competitive Intelligence</h1>
    <h1>ADC/Behavioral Module Internal Benchmarking</h1>
    <h1>Daily / Weekly Bar Graph</h1>
  </center>
  <div id="chartdiv"></div>
</div>

<script>
/**
 * Plugin to add automatic stack sum values and labels
 */
AmCharts.addInitHandler(function(chart) {

  // iterate through data
  for(var i = 0; i < chart.dataProvider.length; i++ ) {
    var dp = chart.dataProvider[i];
    dp.total = 0;
    dp.totalText = 0;
    for(var x = 2; x < chart.graphs.length; x++ ) {
      var g = chart.graphs[x];
      dp.totalText += dp[g.valueField];
      if (dp[g.valueField] > 0)
        dp.total += dp[g.valueField];
    }
    dp.total += 1;
  }

  // add additional graph
  var graph = new AmCharts.AmGraph();
  graph.valueField = "total";
  graph.labelText = "[[totalText]]";
  graph.visibleInLegend = false;
  graph.labelPosition = "right";
  graph.labelOffset = 38;
  graph.showBalloon = false;
  graph.lineAlpha = 0;
  graph.fontSize = 20;
  chart.addGraph(graph);

}, ["serial"]);

var chart = AmCharts.makeChart("chartdiv", {
    "theme": "black",
    "type": "serial",
    "startDuration": 0,
    "dataProvider":
  [
    <?php while($row = mysqli_fetch_array($result)) {
        $expdate = $row['date_sourced'];
        $timestamp = date("D", strtotime($expdate. ''));
        if($timestamp == "Fri"){
            $date = date('Y-m-d',strtotime($expdate.' +3 days'));
        }else if($timestamp != "Sat" || $timestamp != "Sun"){
            $date = date('Y-m-d',strtotime($expdate.' +1 day'));
        }
        echo '{';
        echo '  "Date": "' . date('M-d', strtotime($row['date_sourced'])) . '",';
        echo '  "sourced": ' . $row['counter'] . ',';
        
        $query_adc = " SELECT * FROM charles_table_adc";
        $query_adc = mysqli_query($conn, $query_adc);
        while($row1 = mysqli_fetch_array($query_adc)) {
            $curr_adc = $row1['value'];
            $adc_count = " SELECT date_tested FROM charles_table_primary WHERE date_tested = '$date' AND adc = '$curr_adc' ";
            $adc_count = mysqli_query($conn, $adc_count);
            $adc_count = mysqli_num_rows($adc_count);
            echo '  "' . $curr_adc . '": ' . $adc_count . ',';
        }
        echo '},';
    } ?>
  ],
  "valueAxes": [{
      "stackType": "regular",
      "axisAlpha": 0.3,
      "gridAlpha": 0
  }],
  "graphs": [{
      "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
      "fillAlphas": 0.8,
      "labelText": "[[value]]",
      "lineAlpha": 0.3,
      "title": "Sample Sourced",
      "type": "column",
      "valueField": "sourced"
  }, 
  {
      "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
      "fillAlphas": 0.8,
      "labelText": "[[value]]",
      "lineAlpha": 0.3,
      "title": "Sample Tested",
      "type": "column",
      "valueField": "Tested",
      "fillColors": "#000",
      "lineColor": "#000",
  },
  <?php 
    $query_adc = " SELECT * FROM charles_table_adc";
    $query_adc = mysqli_query($conn, $query_adc);
    $i = 0;
    $colors = array("#5fcace", "#b674c1", "#73d872", "#6484d1");
    while($row1 = mysqli_fetch_array($query_adc)) {
        $curr_adc = $row1['value'];
        echo '{';
            echo '"fillAlphas": 0.8,';
            echo '"labelText": "[[value]]",';
            echo '"lineAlpha": 0.3,';
            echo '"title": "' . $curr_adc . '",';
            echo '"type": "column",';
            echo '"valueField": "' . $curr_adc . '",';
            echo '"fillColors": "' . $colors[$i] . '",';
            if($i == 0) {
                echo '"newStack": true,';
            }
        echo '},';
        $i += 1;
    }
  ?>
  ],
  "legend": {
        "horizontalGap": 10,
        "useGraphSettings": true,
        "markerSize": 30,
        "position": "left",
        "labelWidth": "85",
    },
  "plotAreaFillAlphas": 0.1,
  "categoryField": "Date",
  "categoryAxis": {
      "gridPosition": "start"
  },
  "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.graphs[0].color = "#000000";
            chart.graphs[1].color = "#000000";
            chart.color = "#000000";
            chart.plotAreaFillColors = ["#A0A0A0"];
            chart.plotAreaFillAlphas = 0.1,
            chart.valueAxes[0].gridAlpha = 0.3;
            chart.valueAxes[0].gridColor = "#000000";
            chart.graphs[1].fillColors = "#FFF";
            chart.graphs[1].lineColor = "#FFF";
            chart.legend.color = "#000";
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.graphs[0].color = "#FFF";
                chart.graphs[1].color = "#FFF";
                chart.color = "#FFF";
                chart.plotAreaFillColors = ["#FFF"];
                chart.plotAreaFillAlphas = 0.1,
                chart.valueAxes[0].gridAlpha = 0.0;
                chart.valueAxes[0].gridColor = "#FFF";
                chart.legend.color = "#FFF";
                chart.graphs[1].fillColors = "#000";
                chart.graphs[1].lineColor = "#000";
                chart.validateNow();
            }, 10);
        }
    }
});
</script>

<?php
	include 'nextgraph.php';
?>