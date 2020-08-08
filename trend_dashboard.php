
<?php 
  session_start();
  date_default_timezone_set("Asia/Manila");
  $interval = "1 month ago";
  $date_to = date('Y-m-d');
  $date_from = date("Y-m-d", strtotime($interval));

  ////////////////////////////////////////////////////SHOW OVER ALL FROM TRENDX COLUMN COUNT////////////////////////////////////////////////////////
    $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
    $query = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx LIKE '%Undet%' 
    union all select 'Not Supported', COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx LIKE '%Not Supported%' 
    union all select 'Detected', COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%'
    union all select 'Escalate', COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx LIKE '%Escalate%'";
 $resultpie = mysqli_query($conn, $query);

////////////////////////////////////////////////////////LINE GRAPH//////////////////////////////////////////////
    $query9 = "SELECT DISTINCT date_sourced, COUNT(*) as counter FROM jeremy_table_trend GROUP BY date_sourced";
    $query10 ="SELECT DISTINCT date_sourced, COUNT(*) as counter2 FROM jeremy_table_trend WHERE trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' GROUP BY date_sourced";
    $result = mysqli_query($conn, $query9);
    $result2 = mysqli_query($conn, $query10);
    $query_first = "SELECT date_sourced FROM jeremy_table_trend ORDER BY date_sourced ASC LIMIT 1";
    $result_first = mysqli_query($conn, $query_first);
    $row_first = mysqli_fetch_array($result_first);

    $query_last = "SELECT date_sourced FROM jeremy_table_trend ORDER BY date_sourced DESC LIMIT 1";
    $result_last = mysqli_query($conn, $query_last);
    $row_last = mysqli_fetch_array($result_last);

    ///////////////////////////////////////////////////SLICED UNDET/////////////////////////////////////////////////////
    
  $query1 = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend  WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Undet%'";
  $UNDET = mysqli_query($conn, $query1);

  $query2 = "select 'Not Supported' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx LIKE '%Not Supported%'";
  $NOTSUPORTED = mysqli_query($conn, $query2);
  
  $query3 = "select 'Escalate' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Escalate%'";
  $ESCALATE = mysqli_query($conn, $query3);

  $query4 = "select 'Detected' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%'";
  $DETECTED = mysqli_query($conn, $query4);

  //SHOW DISTINCT FROM TRENDX
  $query5 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Undet%' group by trendx";
  $sub_undet= mysqli_query($conn, $query5);
 

  $query6 = "SELECT DISTINCT vsdt, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Not Supported%' group by vsdt";
  $sub_notsupported= mysqli_query($conn, $query6);


  $query7 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Escalate%' group by trendx";
  $sub_escalate = mysqli_query($conn, $query7);

  $query8 = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' group by trendx";
  $sub_detected = mysqli_query($conn, $query8);
      ///////////////////////////////////////////////////SLICED DETECTED/////////////////////////////////////////////////////
    
      $query1_1 = "select 'Undetected' as trendx , COUNT(*) as counter from jeremy_table_trend  WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Undet%'";
      $UNDET_1 = mysqli_query($conn, $query1_1 );
    
      $query2_1  = "select 'Not Supported' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to') and trendx LIKE '%Not Supported%'";
      $NOTSUPORTED_1  = mysqli_query($conn, $query2_1 );
      
      $query3_1  = "select 'Escalate' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Escalate%'";
      $ESCALATE_1  = mysqli_query($conn, $query3_1 );
    
      $query4_1  = "select 'Detected' as trendx, COUNT(*) as counter from jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%'";
      $DETECTED_1  = mysqli_query($conn, $query4_1 );
    
      //SHOW DISTINCT FROM TRENDX
      $query5_1  = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Undet%' group by trendx";
      $sub_undet_1 = mysqli_query($conn, $query5_1 );
     
    
      $query6_1  = "SELECT DISTINCT vsdt, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Not Supported%' group by vsdt";
      $sub_notsupported_1 = mysqli_query($conn, $query6_1 );
    
    
      $query7_1  = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx LIKE '%Escalate%' group by trendx";
      $sub_escalate_1  = mysqli_query($conn, $query7_1 );
    
      $query8_1  = "SELECT DISTINCT trendx, COUNT(*) as counter FROM jeremy_table_trend WHERE (date_sourced BETWEEN '$date_from' AND '$date_to')  and trendx NOT LIKE '%Not Supported%' AND trendx NOT LIKE '%Undet%' AND trendx NOT LIKE '%Escalate%' group by trendx";
      $sub_detected_1  = mysqli_query($conn, $query8_1 );
    

?>

<!-- Styles -->
<style>
body { background-color: #30303d; color: #fff;  font-family: Arial, Helvetica, sans-serif;}


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
<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/black.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/chalk.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


<!-- Chart code -->
<script>
/*-----------------------------------------------PIE CHART-----------------------------------------------------*/
var chartpie = AmCharts.makeChart("chartContainer1", {
  "fontSize":9,
  "type": "pie",
  "startDuration": 0,
  "theme": "dark",
  "addClassNames": true,
  "innerRadius": "0",
  "radius": 150,
  "legend":{
    "fontSize":9,
    "marginLeft":250,
    "position":"bottom",
    "autoMargins":false
  },
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
  <?php while($row = mysqli_fetch_array($resultpie)): ?>
  
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
  "titles": [{
    "text": "Trendx Monthly"
  }],
  "depth3D": 15,
  "balloonText": "[[title]]<br><span style='font-size:20px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 20,
  "export": {
    "enabled": true
  }
});


chartpie.addListener('rollOverSlice', function(e) {
    chartpie.clickSlice(e.dataItem.index);
});
chartpie.addListener('rollOutSlice', function(e) {
    chartpie.clickSlice(e.dataItem.index);
});

var counter = 0;
timer = setInterval(function() {
  //check if the previous slice is pulled out in order
  //to simulate a mouseout action to pull it back in for this chart
  if (chartpie.chartData[(counter + (chartpie.dataProvider.length - 1)) % chartpie.dataProvider.length].pulled) {
    chartpie.rollOutSlice((counter + (chartpie.dataProvider.length - 1)) % chartpie.dataProvider.length);
  }else if(chartpie.dataProvider.length >= 0 ){
    counter = 0;
  }
  chartpie.rollOverSlice(counter);
  counter = (counter + 1) % chartpie.dataProvider.length;
}, 2000);


/*------------------------------------------------------LINE GRAPH------------------------------------------------------*/ 
var legend;
var chart = AmCharts.makeChart("chartContainer2", {
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
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "titles": [{
    "text": "LINE GRAPH - OVERALL SAMPLES"
  }],
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

/**-----------------------------------------PIE CHART UNDET VSDT------------------------------------------------------- */
var chart;
var legend;
var selected = true;

var types1 = [  
    <?php while($row = mysqli_fetch_array($UNDET)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>"
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
    "percent": "<?php echo $row['counter']; ?>"
  },

    <?php endwhile; ?> 



    <?php while($row = mysqli_fetch_array($DETECTED)): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>"
  },

    <?php endwhile; ?> 


];

/////////////////////////////////////////////////////////////////////////////SECOND DATA//////////////////////////////////////////////////////////////////////////////
var types2 = [  
    <?php while($row = mysqli_fetch_array($UNDET_1 )): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>"
  },

    <?php endwhile; ?> 



    <?php while($row = mysqli_fetch_array($DETECTED_1 )): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>",
    "subs": [
        <?php while($row = mysqli_fetch_array($sub_detected_1 )): ?>
  
        {
            "type": "<?php echo $row['trendx'] ?>",
            "percent": <?php echo $row['counter']; ?>,
        },

        <?php endwhile; ?>
    ]
  },

    <?php endwhile; ?> 

    <?php while($row = mysqli_fetch_array($NOTSUPORTED_1 )): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>"
  },

    <?php endwhile; ?> 


    <?php while($row = mysqli_fetch_array($ESCALATE_1 )): ?>
  
  {
    "type": "<?php echo $row['trendx'] ?>",
    "percent": "<?php echo $row['counter']; ?>"
  },

    <?php endwhile; ?> 





];

function generateChartData(types) {
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

AmCharts.makeChart("chartContainer3", {
"type": "pie",
"outlineAlpha": 0.4,
"innerRadius": "30",
"radius": 150,
"theme": "black",
"startDuration": 0,
"marginTop":-100,
"color": "white",
"depth3D": 15,
"angle": 20,
"fontSize":9,
  "dataProvider": generateChartData(types1),
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
    "text": "Not Supported - VSDT"
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
///////////////////////////////////////////////////////DETECTED///////////////////////////////////////////////////


AmCharts.makeChart("chartContainer4", {
"type": "pie",
"outlineAlpha": 0.4,
"innerRadius": "30",
"radius": 150,
"theme": "light",
"startDuration": 0,
"marginTop":-100,
"color": "white",
"depth3D": 15,
"angle": 20,
"fontSize":9,
  "dataProvider": generateChartData(types2),
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
    "text": "DETECTED"
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
      chart.dataProvider = generateChartData(types2);
      chart.validateData();
    }
  }],
  "export": {
  "enabled": true
  }
});

</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<center><!--<h1>Competitive Intelligence</h1>-->
    <h1>TRENDX</h1>
    <h1>Monthly (<?php echo $date_from . " to " . $date_to?>)</h1>
  </center>
  <br>
<div id="chartContainer2" style="width: 50%; height: 500px;display: inline-block;" ></div>
<div id="chartContainer1" style="width: 45%; height: 500px;display: inline-block;" ></div>
<div id="chartContainer3" style="width: 49%; height: 700px;display: inline-block;" ></div>
<div id="chartContainer4" style="width: 48%; height: 700px;display: inline-block;" ></div>