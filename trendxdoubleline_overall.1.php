<!-- Styles -->
<style>
body {
  background-color: #000;
  color: #fff;
}
#chartdiv {
    width   : 100%;
    height  : 80%;
}

[title="JavaScript charts"] {
    top: 0px !important;
    visibility: hidden;
}

</style>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>

<?php
  $_SESSION['current_graph'] = 11;
  date_default_timezone_set("Asia/Manila");
  $conn = mysqli_connect("localhost", "root", "", "jeremy_db");

  $query = "SELECT DISTINCT date_sourced, COUNT(*) as counter FROM jeremy_table_trend GROUP BY date_sourced";
  $query2 ="SELECT DISTINCT date_sourced, COUNT(*) as counter2 FROM jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' GROUP BY date_sourced";
  $result = mysqli_query($conn, $query);
  $result2 = mysqli_query($conn, $query2);
  $query_first = "SELECT date_sourced FROM jeremy_table_trend ORDER BY date_sourced ASC LIMIT 1";
  $result_first = mysqli_query($conn, $query_first);
  $row_first = mysqli_fetch_array($result_first);

  $query_last = "SELECT date_sourced FROM jeremy_table_trend ORDER BY date_sourced DESC LIMIT 1";
  $result_last = mysqli_query($conn, $query_last);
  $row_last = mysqli_fetch_array($result_last);
  $_SESSION['current_graph'] = 2;


?>

<script>
var legend;
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "black",
    "marginRight": 40,
    "marginLeft": 40,
    "autoMarginOffset": 20,
    "mouseWheelZoomEnabled":true,
    "dataDateFormat": "YYYY-MM-DD",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "ignoreAxisWidth":true
    }],
    "legend":{
    "fontSize":13,
    "position":"top",
    "marginLeft":100,
    "autoMargins":false
  },
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "balloon":{
          "drop":true,
          "adjustBorderColor":false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "Total Samples",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
    },
    {
        "id": "g2",
        "balloon":{
          "drop":true,
          "adjustBorderColor":false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#00FF00",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "Detected",
        "useLineColorForBulletBorder": true,
        "valueField": "value2",
        "balloonText": "<span style='font-size:18px;'>[[value2]]</span>"
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
    },
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,
        "valueZoomable":true
    },
    "valueScrollbar":{
      "oppositeAxis":false,
      "offset":50,
      "scrollbarHeight":10
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true
    },
    "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.graphs[0].color = "#000000";
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
                chart.color = "#FFF";
                chart.plotAreaFillColors = ["#FFF"];
                chart.plotAreaFillAlphas = 0.0,
                chart.valueAxes[0].gridAlpha = 0.1;
                chart.valueAxes[0].gridColor = "#FFF";
                chart.validateNow();
            }, 10);
        }
    },
    "dataProvider":
    [
        <?php while($row = mysqli_fetch_array($result) and $row2 = mysqli_fetch_array($result2)): ?>
            {
              "date": "<?php echo $row['date_sourced'] ?>",
              "value": <?php echo $row['counter']; ?>,
              "value2": <?php echo $row2['counter2']; ?>
            },
        <?php endwhile;?>
    ]
});

chart.addListener("rendered", zoomChart);

zoomChart();

function zoomChart() {
    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
}
</script>
<div class="container-fluid"><br>
  <center>
    <h1 class="text-center">Trendx </h1>
    <h1 class="text-center">Over All (<?php echo $row_first['date_sourced'] . " to " .  $row_last['date_sourced']; ?>)</h1>
  </center>
  <div id="chartdiv"></div>
</div>
<?php
	include 'nextgraph.php';
?>
