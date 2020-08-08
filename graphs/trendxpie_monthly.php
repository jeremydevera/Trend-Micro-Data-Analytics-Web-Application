
<?php 
  date_default_timezone_set("Asia/Manila");
  $interval = "1 month ago";
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));

  $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
  $query = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Undet%' and 
   (date_sourced BETWEEN '$date_from' AND '$date_to')
   union all select 'Escalate', COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Escalate%' and 
   (date_sourced BETWEEN '$date_from' AND '$date_to')
   union all select 'Not Supported', COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Not Supported%' and 
   (date_sourced BETWEEN '$date_from' AND '$date_to')
    union all select 'Detected' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' AND
   (date_sourced BETWEEN '$date_from' AND '$date_to')";
  $result = mysqli_query($conn, $query);
?>

<!-- Styles -->
<style>
body { background-color: black; color: #dcdcdc; }
#chartdiv {
  width: 100%;
  height: 80%;
  font-size: 20px;
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
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>


<!-- Chart code -->
<script>
var chart = AmCharts.makeChart("chartdiv", {
  "fontSize":15,
  "type": "pie",
  "startDuration": 0,
   "theme": "black",
  "addClassNames": true,
  "legend":{
    "fontSize":15,
    "position":"right",
    "marginRight":250,
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
      "TRENDX": "<?php echo $row['trendx'] ?>",
      "Values": "<?php echo $row['counter']; ?>"
    },

  <?php endwhile; ?>
  ]
  ,
  "valueField": "Values",
  "titleField": "TRENDX", 
  "outlineAlpha": 0.4,
  "depth3D": 30,
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 20,
  "export": {
    "enabled": true
  }
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
<br>
  <center><!--<h1>Competitive Intelligence</h1>-->
    <h1>TRENDX MONTHLY PIE CHART</h1>
    <h1>Monthly (<?php echo $date_from . " to " . $date_to?>)</h1>
  </center>
<div id="chartdiv"></div>   
