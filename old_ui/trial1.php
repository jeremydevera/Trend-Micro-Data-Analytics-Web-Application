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
</style>

<?php
    $_SESSION['current_graph'] = 8;
    date_default_timezone_set("Asia/Manila");
    $interval = "7 day ago";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $date_to = date('Y-m-d');
    $date_from = date("Y-m-d", strtotime($interval));
    $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = 'Email' GROUP BY adc";
    $result1 = mysqli_query($conn, $query);
    $query = "SELECT DISTINCT adc, COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = 'Threat Hunting' GROUP BY adc";
    $result2 = mysqli_query($conn, $query);
    $query = "SELECT DISTINCT adc FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to'";
    $adc = mysqli_query($conn, $query);
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
        "dataProvider":[
            <?php 
                while($row = mysqli_fetch_array($adc)):
                    $curr_adc = $row['adc'];
                    $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = 'Email' AND adc = '$curr_adc'";
                    $emails = mysqli_query($conn, $query);
                    $emails = mysqli_fetch_array($emails);
                    $query = "SELECT COUNT(*) as counter FROM charles_table_primary WHERE date_tested BETWEEN '$date_from' AND '$date_to' AND source = 'Threat Hunting' AND adc = '$curr_adc'";
                    $thunting = mysqli_query($conn, $query);
                    $thunting = mysqli_fetch_array($thunting);
                    ?>
                    {
                        "adc": "<?php echo $curr_adc; ?>",
                        "emails": <?php echo $emails['counter']; ?>,
                        "thunting": <?php echo $thunting['counter']; ?>,
                    },
            <?php endwhile;?>
        ],
        "valueAxes": [{
            "unit": "",
            "position": "left",
            "title": "",
        }],
        "graphs": [{
                "balloonText": "[[category]] from Emails: <b>[[value]]</b>",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "title": "Emails",
                "type": "column",
                "columnWidth": 0.7,
                "valueField": "emails",
                "labelText": "[[value]]",
            }, {
                "balloonText": "[[category]] from Threat Hunting: <b>[[value]]</b>",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "title": "Threat Hunting",
                "type": "column",
                "clustered": true,
                "columnWidth": 0.7,
                "valueField": "thunting",
                "labelText": "[[value]]",
        }],
        "plotAreaFillAlphas": 0.1,
        "categoryField": "adc",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "export": {
            "enabled": true
        }
    });
</script>

<div class="container-fluid"><br>
  <center>
    <h1>Competitive Intelligence</h1>
    <h1>ADC/Behavioral Module Internal Benchmarking</h1>
    <h1>Weekly (<?php echo $date_from . " to " . $date_to?>)</h1>
  </center>
  <div id="chartdiv"></div>
</div>
