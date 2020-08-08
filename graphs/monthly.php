<style>
body { background-color: black; color: #dcdcdc; }
#chartdiv {
  width: 100%;
  height: 80%;
  font-size: 20px;
  margin-left: -10%;
}
.amcharts-pie-slice {
  transform: scale(1);
  transform-origin: 50% 50%;
  transition-duration: 0.3s;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -o-transition: all .3s ease-out;
  cursor: pointer;
  box-shadow: 0 0 30px 0 #000;
}
.amcharts-pie-slice:hover {
  transform: scale(1.1);
  filter: url(#shadow);
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
  $interval = "1 month ago";
  $conn = mysqli_connect("localhost", "root", "", "charles_db");
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));
  $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' GROUP BY adc";
  $result = mysqli_query($conn, $query);
  $_SESSION['current_graph'] = 1;
?>

<script>
var chart = AmCharts.makeChart("chartdiv", {
  "fontSize":17,
  "marginLeft": "-10%",
  "type": "pie",
  "startDuration": 0,
   "theme": "black",
  "addClassNames": true,
  "legend":{
    "fontSize":20,
    "position":"right",
    "autoMargins":false
  },
  "innerRadius": "0",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider":
  [
  <?php while($row = mysqli_fetch_array($result)): ?>
    {
      "ADC": "<?php echo $row['adc'] ?>",
      "Values": <?php echo $row['counter']; ?>
    },
  <?php endwhile;?>
  ]
  ,
  "valueField": "Values",
  "titleField": "ADC",
  "outlineAlpha": 0.4,
  "depth3D": 30,
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 20,
  "export": {
        "enabled": true,
        "beforeCapture": function() {
            var chart = this.setup.chart;
            chart.color = "#000000";
            chart.labelTickAlpha = 0.9;
            chart.labelTickColor = "#000000";
            chart.legend.color = "#000000";
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.legend.color = "#FFF";
                chart.validateNow();
            }, 10);
        }
    },
});
chart.addListener("init", handleInit);
chart.addListener("rollOverSlice", function(e) {
  handleRollOver(e);
});
function handleInit(){
  chart.legend.addListener("rollOverItem", handleRollOver);
}
function handleRollOver(e){
  var wedge = e.dataItem.wedge.node;
  wedge.parentNode.appendChild(wedge);
}
</script>
<div class="container-fluid"><br>
  <center><h1>Competitive Intelligence</h1>
    <h1>ADC/Behavioral Module Internal Benchmarking</h1>
    <h1>Monthly (<?php echo $date_from . " to " . $date_to?>)</h1>
  </center>
  <div id="chartdiv"></div>
</div>

<?php
	include 'nextgraph.php';
?>
