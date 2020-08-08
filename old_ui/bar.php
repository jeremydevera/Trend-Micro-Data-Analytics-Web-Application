<!-- Styles -->
<style>
body {
    background-color: #000;
    color: #fff;
}
#chartdiv {
	width: 100%;
	height: 80%;
    font-size: 11px;
}

[title="JavaScript charts"] {
    visibility: hidden;
}
</style>

<?php
  $_SESSION['current_graph'] = 8;
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

<!-- Chart code -->
<script>
var chart = AmCharts.makeChart("chartdiv", {
    "theme": "black",
    "type": "serial",
    "startDuration": 0,
    "legend": {
    "horizontalGap": 10,
    "useGraphSettings": true,
    "markerSize": 30
    },
    "dataProvider":
    [
  <?php while($row = mysqli_fetch_array($result)):
    $expdate = $row['date_sourced'];
    $timestamp = date("D", strtotime($expdate. ''));
    if($timestamp == "Fri"){
        $date = date('Y-m-d',strtotime($expdate.' +3 days'));
    }else if($timestamp != "Sat" || $timestamp != "Sun"){
        $date = date('Y-m-d',strtotime($expdate.' +1 day'));
    }
    $query_one = " SELECT date_tested FROM charles_table_primary WHERE date_tested = '$date' ";
    $result_one = mysqli_query($conn, $query_one);
    $row_one = mysqli_num_rows($result_one);
  ?>
    {
      "Sample Sourced": "<?php echo date('M-d', strtotime($row['date_sourced']));?>",
      "Counter": <?php echo $row['counter']; ?>,
      "Counter2": <?php echo $row_one; ?>
    },
  <?php endwhile;?>
  ]
  ,
    "valueAxes": [{
        "unit": "",
        "position": "left",
        "title": "",
    }],
    "graphs": [{
        "balloonText": "Sample Sourced [[category]]: <b>[[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Sample Sourced",
        "type": "column",
        "columnWidth":0.7,
        "valueField": "Counter",
        "labelText": "[[value]]",
    }, {
        "balloonText": "Sample Tested [[category]]: <b>[[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Sample Tested",
        "type": "column",
        "clustered":true,
        "columnWidth":0.7,
        "valueField": "Counter2",
        "labelText": "[[value]]",
    }],
    "plotAreaFillAlphas": 0.1,
    "categoryField": "Sample Sourced",
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

<div class="container-fluid"><br>
  <center><h1>Competitive Intelligence</h1>
    <h1>ADC/Behavioral Module Internal Benchmarking</h1>
  </center>
  <div id="chartdiv"></div>
</div>

<?php
	include 'nextgraph.php';
?>