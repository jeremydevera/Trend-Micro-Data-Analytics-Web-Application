
<?php 
  session_start();
  date_default_timezone_set("Asia/Manila");
  $interval = "1 month ago";
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));

  //SHOW OVER ALL FROM TRENDX COLUMN COUNT
  $conn = mysqli_connect("localhost", "root", "", "jeremy_db");


  $query = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend  WHERE trendx LIKE '%Undet%'";
  $UNDET = mysqli_query($conn, $query);

  $query2 = "select 'Not Supported' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Not Supported%'";
  $NOTSUPORTED = mysqli_query($conn, $query2);
  
  $query3 = "select 'Escalate' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx LIKE '%Escalate%'";
  $ESCALATE = mysqli_query($conn, $query3);

  $query4 = "select 'Detected' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%'";
  $DETECTED = mysqli_query($conn, $query4);

  //SHOW DISTINCT FROM TRENDX
  $query5 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Undet%' group by trendx";
  $sub_undet= mysqli_query($conn, $query5);
 

  $query6 = "SELECT DISTINCT vsdt, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Not Supported%' group by vsdt";
  $sub_notsupported= mysqli_query($conn, $query6);


  $query7 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx LIKE '%Escalate%' group by trendx";
  $sub_escalate = mysqli_query($conn, $query7);

  $query8 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' group by trendx";
  $sub_detected = mysqli_query($conn, $query8);

?>

<!-- Styles -->
<style>
body { background-color: black; color: #dcdcdc; }

#chartdiv {
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

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>



<!-- Chart code -->
<script>
var chart;
var legend;
var selected;

var types = [  
    <?php while($row = mysqli_fetch_array($UNDET)): ?>
  
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




    <?php while($row = mysqli_fetch_array($NOTSUPORTED)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_notsupported)): ?>
  
        {
            "type": "<?php echo $row['vsdt'] ?>",
            "percent": <?php echo $row['counter']; ?>,
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
            "percent": <?php echo $row['counter']; ?>,
        },

        <?php endwhile; ?>
    ],
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


var chart = AmCharts.makeChart("chartdiv", {
"type": "pie",
"outlineAlpha": 0.4,
"innerRadius": "0",
"radius": 200,
"theme": "black",
"startDuration": 0,
"marginTop":-300,
"color": "white",
"depth3D": 30,
"angle": 20,
"legend":{
    "fontSize":13,
    "position":"right",
    "marginRight":50,
    "marginBottom":300,
    "autoMargins":false
  },
"fontSize":9,
  "dataProvider": generateChartData(),
  "labelText": "[[title]]: [[value]]",
  "balloonText": "[[title]]: [[value]]",
  "titleField": "type",
  "pulledField": "pulled",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "labelsEnabled": true,
  "outlineAlpha": 0.8,
  "outlineThickness": 1,
  "colorField": "color",
  "titles": [{
    "text": ""
  }],
  "responsive": {
      enabled: true
    },

  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "fontSize": 13,
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

chart.addListener('rollOverSlice', function(e) {
  chart.clickSlice(e.dataItem.index);
});
chart.addListener('rollOutSlice', function(e) {
  chart.clickSlice(e.dataItem.index);
});
var counter = 0;
setInterval(function() {
  //check if the previous slice is pulled out in order
  //to simulate a mouseout action to pull it back in for this chart
  if (chart.chartData[(counter + (chart.dataProvider.length - 1)) % chart.dataProvider.length].pulled) {
    chart.rollOutSlice((counter + (chart.dataProvider.length - 1)) % chart.dataProvider.length);
  }
  chart.rollOverSlice(counter);
  counter = (counter + 1) % chart.dataProvider.length;
}, 3000);

</script>
<br>
<center><!--<h1>Competitive Intelligence</h1>-->
    <h1>TRENDX SLICED</h1>
    <h1>Overall Results</h1>
</center>
<!-- HTML -->

<div id="chartdiv" style = "height:1000px" ></div>