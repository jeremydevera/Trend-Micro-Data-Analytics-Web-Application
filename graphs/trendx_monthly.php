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
  $interval = "7 day ago";
  $conn = mysqli_connect("localhost", "root", "", "charles_db");
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));
?>

<?php
  $_SESSION['current_graph'] = 4;
  date_default_timezone_set("Asia/Manila");
  $interval = "1 month ago";
  $conn = mysqli_connect("localhost", "root", "", "charles_db");
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));
  $total = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to'";
  $total = mysqli_query($conn, $total);
  $total = mysqli_fetch_array($total);        //Total
  $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND (trendx = 'Undeteceted' OR trendx = 'Undet' OR trendx = 'undet')";
  $result = mysqli_query($conn, $query);
  $undet = mysqli_fetch_array($result);        //Unetected
  $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND (trendx != 'Undetected' AND trendx != 'Undet' AND trendx != 'undet' AND trendx != '')";
  $result = mysqli_query($conn, $query);
  $det = mysqli_fetch_array($result);
  // $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND (trendx != 'Undetected' AND trendx != 'Undet' AND trendx != 'undet' AND trendx != '' AND trig != 'wscript')";
  // $result = mysqli_query($conn, $query);
  // $det1 = mysqli_fetch_array($result);                //Detected and without trigger
  // $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND (trendx != 'Undetected' AND trendx != 'Undet' AND trendx != 'undet' AND trendx != '' AND trig = 'wscript')";
  // $result = mysqli_query($conn, $query);
  // $det2 = mysqli_fetch_array($result);                //Detected and without trigger
  $query = "SELECT DISTINCT trig, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND (trendx != 'Undetected' AND trendx != 'Undet' AND trendx != 'undet' AND trendx != '') GROUP BY trig";
  $triggers = mysqli_query($conn, $query);
?>

<center><h1>Competitive Intelligence</h1>
  <h1>TrendX and Trigger Internal Benchmarking</h1>
  <h1>Monthly (<?php echo $date_from ?> to <?php echo $date_to ?>)</h1>
</center><br>
<table>
  <tr>
    <th><div id="chartdiv1"></div></th>
    <th><div id="chartdiv2"></div></th>
  </tr>
</table>

<script>
  var chart;
  var legend;

  function addSub() {
      var subtrig = [];
      <?php while($row = mysqli_fetch_array($triggers)): ?>
          subtrig.push({
              type: "<?php echo $row['trig'] ?>",
              percent: <?php echo $row['counter']; ?>,
          });
      <?php endwhile;?>
      return subtrig;
  }

  var types = [
    {
    type: "Undetected",
    percent: <?php echo $undet['counter']?>,
    color: "#ed4747",
  }, {
    type: "Detected",
    percent: <?php echo $det['counter']?>,
    color: "#d1cbd3",
    subs: addSub()
  }];

  function generateChartData1() {
  var chartData = [];
  chartData.push({
    type: types[0].type,
    percent: types[0].percent,
    color: types[0].color,
    id: 0,
    pulled: true,
  });
  chartData.push({
    type: types[1].type,
    percent: types[1].percent,
    color: types[1].color,
    id: 1,
  });
  return chartData;
}

  function generateChartData2() {
      var chartData = [];
      chartData.push({
        type: types[0].type,
        percent: types[0].percent,
        color: "#000000",
        id: 0,
        pulled: true,
      });
      var dettrig = types[1].subs;
      for (var i = 0; i < dettrig.length; i++) {
          if(dettrig[i].type == "") {
              dettrig[i].type = "Not\nSpecified";
          }
          chartData.push({

            type: dettrig[i].type,
            percent: dettrig[i].percent,
          });
      }
      return chartData;
    }

AmCharts.makeChart("chartdiv1", {
  "type": "pie",
  "theme": "black",
  "startDuration": 0,
  "dataProvider": generateChartData1(),
  "labelText": "[[title]]: [[value]]",
  "balloonText": "[[title]]: [[value]]",
  "titleField": "type",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.8,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "legend":{
    "fontSize":15,
    "align": "center"
  },
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
            chart.legend.color = "#000000";
            chart.legend.fontSize = 20;
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.div.style.width = "100%";
                chart.marginLeft = "0%";
                chart.marginTop = "0%";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.legend.color = "#FFF";
                chart.legend.fontSize = 15;
                chart.validateNow();
            }, 10);
        }
    }
});

AmCharts.makeChart("chartdiv2", {
  "type": "pie",
  "theme": "black",
  "startDuration": 0,
  "dataProvider": generateChartData2(),
  "labelText": "[[title]]: [[value]]",
  "balloonText": "[[title]]: [[value]]",
  "titleField": "type",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.5,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "legend":{
    "fontSize":15,
    "align": "center"
  },
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
            chart.legend.color = "#000000";
            chart.legend.fontSize = 20;
            chart.validateNow();
        },
        "afterCapture": function() {
            var chart = this.setup.chart;
            setTimeout(function() {
                chart.color = "#FFF";
                chart.div.style.width = "100%";
                chart.marginLeft = "0%";
                chart.marginTop = "0%";
                chart.fontSize = 11;
                chart.labelTickAlpha = 0.2;
                chart.labelTickColor = "#FFF";
                chart.legend.color = "#FFF";
                chart.legend.fontSize = 15;
                chart.validateNow();
            }, 10);
        }
    }
});
</script>

<?php
	include 'nextgraph.php';
?>