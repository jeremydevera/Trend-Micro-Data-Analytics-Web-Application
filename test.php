
<?php 
  session_start();
  date_default_timezone_set("Asia/Manila");
  $interval = "1 month ago";
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));

  //SHOW OVER ALL FROM TRENDX COLUMN COUNT
  $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
  $query = "SELECT
  CASE
      WHEN trendx LIKE '%Undet%' THEN 'Undetected'
      WHEN trendx LIKE '%Escalate%' THEN 'Escalate'
      WHEN trendx LIKE '%Not Supported%' THEN 'Not Supported'
      ELSE 'Detected'
  END
  AS trendx
  , COUNT(*) AS counter
FROM jeremy_table_trend $_SESSION[current_query]
GROUP BY
  CASE
      WHEN trendx LIKE '%Undet%' THEN 'Undet'
      WHEN trendx LIKE '%Escalate%' THEN 'Escalate'
      WHEN trendx LIKE '%Not Supported%' THEN 'Not Supported'
      ELSE 'Supported'
  END";
  
  $result = mysqli_query($conn, $query);

  $query1 = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend  WHERE trendx LIKE '%Undet%'";
  $UNDET = mysqli_query($conn, $query1);

  $query2 = "select 'Not Supported' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Not Supported%'";
  $NOTSUPORTED = mysqli_query($conn, $query2);
  
  $query3 = "select 'Escalate' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Escalate%'";
  $ESCALATE = mysqli_query($conn, $query3);

  $query4 = "select 'Detected' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%'";
  $DETECTED = mysqli_query($conn, $query4);

  //SHOW DISTINCT FROM TRENDX
  $query5 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Undet%' group by trendx";
  $sub_undet= mysqli_query($conn, $query5);
 

  $query6 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Not Supported%' group by trendx";
  $sub_notsupported= mysqli_query($conn, $query6);


  $query7 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Escalate%' group by trendx";
  $sub_escalate = mysqli_query($conn, $query7);

  $query8 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' group by trendx";
  $sub_detected = mysqli_query($conn, $query8);

?>

<!-- Styles -->
<style>
body { background-color: white;}
#chartdiv {
  width: 100%;
  height: 100%;
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
          
</style>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<script>
var chart;
var legend;
var selected;

var types = [  
    <?php while($row = mysqli_fetch_array($result)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_undet)): ?>
  
        {
            "type": "<?php echo $row['trendx'] ?>",
            "percent": <?php echo $row['counter']; ?>
        },

        <?php endwhile; ?>
    ]
  },

    <?php endwhile; ?> 




    <?php while($row = mysqli_fetch_array($result)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_notsupported)): ?>
  
        {
            "type": "<?php echo $row['trendx'] ?>",
            "percent": <?php echo $row['counter']; ?>
        },

        <?php endwhile; ?>
    ]
  },

    <?php endwhile; ?> 


    <?php while($row = mysqli_fetch_array($ESCALATE)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_escalate)): ?>
  
        {
            "type": "<?php echo $row['trendx'] ?>",
            "percent": <?php echo $row['counter']; ?>
        },

        <?php endwhile; ?>
    ]
  },

    <?php endwhile; ?> 



    <?php while($row = mysqli_fetch_array($DETECTED)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_detected)): ?>
  
        {
            "type": "<?php echo $row['trendx'] ?>",
            "percent": <?php echo $row['counter']; ?>
        },

        <?php endwhile; ?>
    ]
  },

    <?php endwhile; ?> 


];

function generateChartData() {
  var chartData = [];
  for (var i = 0; i < types.length; i++) {
    if (i == selected) {
      for (var x = 0; x < types[i].subs.length; x++) {
        chartData.push({
          type: types[i].subs[x].type,
          percent: types[i].subs[x].percent,
          color: types[i].color,
          pulled: true
        });
      }
    } else {
      chartData.push({
        type: types[i].type,
        percent: types[i].percent,
        color: types[i].color,
        id: i
      });
    }
  }
  return chartData;
}

AmCharts.makeChart("chartdiv", {
"type": "pie",
"theme": "light",
"color": "black",
"fontSize":10,
  "dataProvider": generateChartData(),
  "labelText": "[[title]]: [[value]]",
  "balloonText": "[[title]]: [[value]]",
  "titleField": "type",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.8,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "titles": [{
    "text": "TRENDX SLICED PIE"
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(event) {
      var chart = event.chart;
      if (event.dataItem.dataContext.id != undefined) {
        selected = event.dataItem.dataContext.id;
      } else {
        selected = undefined;
      }
      chart.dataProvider = generateChartData();
      chart.validateData();
    }
  }],
  "export": {
    "enabled": true
  }
});
</script>
<br><br><br><br><br><br><br><br>
<!-- HTML -->
<div id="chartdiv"></div>
<br><br><br><br>