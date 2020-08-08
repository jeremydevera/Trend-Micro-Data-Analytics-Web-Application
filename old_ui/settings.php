<html>
    <head>
        <title>CI - Dashboard Settings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .sidenav {
                background-color: #263643;
                height: 100%;
                position: fixed;
            }
            @media screen and (max-width: 767px) {
                .row.content {height: auto;}
            }
        </style>
    </head>

    <?php
        session_start();
        if(isset($_POST['save_button'])){
            $_SESSION['id_array'] = $_POST['check_box'];
            $_SESSION['graph_interval'] = $_POST['graph_interval'];
            $_SESSION['video_name'] = $_POST['video_name'];
            $_SESSION['video_duration'] = $_POST['video_duration'];
            header("Location:save_settings.php");
        }
        $file = fopen("settings.ini", "r");
        $line = fgets($file);
        $saved_interval = fgets($file);
        $saved_interval = rtrim($saved_interval,"\n");
        $vidname = fgets($file);
        $duration = fgets($file);
    ?>

    <body style="background-color: #e8f3ff;">
        <?php
          include 'navbar.php';
        ?>
        <br>

                <div class="col-sm-offset-2 col-sm-10">
                    <div class="col-sm-offset-3 col-sm-6"><div>
                    <div>
                        <div class="container ui segment" style="text-align: center; width: 100%; float: right; background-color: #fff; padding-left: 10%; padding-right: 10%">
                            <form class="ui form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <br><h2>DASHBOARD SETTINGS</h2><br>
                                <h2 class="ui dividing header">ADC/Behavioral Module Internal Benchmarking</h2>
                                <div class="three fields">
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="adc_daily" value="adc_daily">
                                            <label style="font-size: 150%;">DAILY/WEEKLY</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="adc_monthly" value="adc_monthly">
                                            <label style="font-size: 150%;">MONTHLY</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="adc_overall" value="adc_overall">
                                            <label style="font-size: 150%;">OVERALL</label>
                                        </div>
                                    </div>
                                </div><br>
                                <h2 class="ui dividing header">TrendX Module Internal Benchmarking</h2>
                                <div class="two fields">
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="trendx_weekly" value="trendx_weekly">
                                            <label style="font-size: 150%;">WEEKLY</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="trendx_monthly" value="trendx_monthly">
                                            <label style="font-size: 150%;">MONTHLY</label>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="two fields">
                                    <div class="fifteen wide field">
                                        <h2 class="ui dividing header">ADC/Behavioral Module<br>Bar Graph</h2>
                                        <div class="three fields">
                                            <div class="field">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="check_box[]" id="adc_3bars" value="adc_3bars">
                                                    <label style="font-size: 150%;">3 Bars</label>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="check_box[]" id="adc_2bars" value="adc_2bars">
                                                    <label style="font-size: 150%;">2 Bars</label>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="check_box[]" id="adc_1bar" value="adc_1bar">
                                                    <label style="font-size: 150%;">1 Bar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <h2 class="ui dividing header">Samples<br>Bar Graph</h2>
                                        <div class="checkbox"><br>
                                            <input type="checkbox" name="check_box[]" id="samples_bar" value="samples_bar">
                                            <label style="font-size: 150%;">Show</label>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="ui dividing header">Video</h2>
                                <div class="three fields">
                                    <div class="field">
                                        <div class="checkbox">
                                            <input type="checkbox" name="check_box[]" id="video" value="video">
                                            <label style="font-size: 150%;">Play</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui input">
                                            <input style="margin-right: 20px; font-size: 150%;" type="text" placeholder="Video Name" id="video_name" name="video_name" value="<?php echo $vidname?>">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui right labeled input">
                                            <input style="font-size: 150%;" type="number" placeholder="Duration" id="video_duration" name="video_duration" value="<?php echo $duration?>">
                                            <label class="ui basic label" style="font-size: 150%;">seconds</label>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="field">
                                    <div class="ui right labeled input">
                                        <label for="graph_interval" class="ui grey label" style="font-size: 150%;"><i class="clock outline icon"></i>Interval Time</label>
                                        <input style="font-size: 150%; text-align: right;" type="number" min="0" step="1" id="graph_interval" name="graph_interval" value="<?php echo $saved_interval?>">
                                        <label class="ui basic label" style="font-size: 150%;">seconds</label>
                                    </div>
                                </div><br>
                                <div class="column">
                                    <button type="submit" class="ui green button" id="save_button" name="save_button" style="font-size: 150%;" onclick="SaveSettings()">
                                        <i class="check icon"></i> SAVE
                                    </button>
                                    <a class="ui red button" href="index.php" id="cancel_button"  style="font-size: 150%;">
                                        <i class="ban icon"></i> CANCEL
                                    </a>
                                </div><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.onload = onPageLoad();
            function onPageLoad() {
                <?php
                    $file = fopen("settings.ini", "r");
                    $line = fgets($file);
                    if($line[0] == "1") {
                        echo "document.getElementById('adc_daily').checked = true;";
                    } 
                    if($line[1] == "1") {
                        echo "document.getElementById('adc_monthly').checked = true;";
                    } 
                    if($line[2] == "1") {
                        echo "document.getElementById('adc_overall').checked = true;";
                    } 
                    if($line[3] == "1") {
                        echo "document.getElementById('trendx_weekly').checked = true;";
                    } 
                    if($line[4] == "1") {
                        echo "document.getElementById('trendx_monthly').checked = true;";
                    } 
                    if($line[5] == "1") {
                        echo "document.getElementById('adc_3bars').checked = true;";
                    } 
                    if($line[6] == "1") {
                        echo "document.getElementById('adc_2bars').checked = true;";
                    } 
                    if($line[7] == "1") {
                        echo "document.getElementById('adc_1bar').checked = true;";
                    } 
                    if($line[8] == "1") {
                        echo "document.getElementById('samples_bar').checked = true;";
                    }
                    if($line[9] == "1") {
                        echo "document.getElementById('video').checked = true;";
                    }
                    fclose($file);
                ?>
            }
        </script>
    </body>
</html>
