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
  $_SESSION['current_graph'] = 5;
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
            "Date": "<?php echo date('M-d', strtotime($row['date_sourced']));?>",
            "sourced": <?php echo $row['counter']; ?>,
            "tested": <?php echo $row_one; ?>,
            <?php 
                $query_adc = " SELECT * FROM charles_table_adc";
                $query_adc = mysqli_query($conn, $query_adc);
                while($row1 = mysqli_fetch_array($query_adc)) {
                    $curr_adc = $row1['value'];
                    $adc_count = " SELECT date_tested FROM charles_table_primary WHERE date_tested = '$date' AND adc = '$curr_adc' ";
                    $adc_count = mysqli_query($conn, $adc_count);
                    $adc_count = mysqli_num_rows($adc_count);
                    echo '  "' . $curr_adc . '": ' . $adc_count . ',';
                }
            ?>
        },
  <?php endwhile;?>
  ]
  ,
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
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Sample Tested",
        "type": "column",
        "newStack": true,
        "valueField": "tested",
        "fillColors": "#f2b752",
    }, <?php 
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
    ?>],
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