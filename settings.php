
<?php include 'base.php' ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $file = fopen("graphs/settings.ini", "w+");
        $id = $_POST['check_box'];
        $id_last = count($id);
        $graphs = array("adc_daily", "adc_monthly", "adc_overall", "trendx_weekly", "trendx_monthly", "adc_3bars","adc_2bars", "adc_1bar", "samples_bar","trendxpie_monthly","trendxpie_overall","trendxline_overall","trend_dashboard","video");
        $j = 0;
        for($i = 0; $i < count($graphs); $i++) {
            if($graphs[$i] == $id[$j]) {
                fwrite($file, "1");
                if($j + 1 < $id_last)  {
                    $j += 1;
                }
            } else {
                fwrite($file, "0");
            }
        }
        fwrite($file, "\n");
        fwrite($file, $_POST['graph_interval']);
        fwrite($file, "\n");
        fwrite($file, $_POST['video_name']);
        fwrite($file, "\n");
        fwrite($file, $_POST['video_duration']);

        echo "<script type='text/javascript'>;";
        echo "   alert('Settings Saved!');";
        echo "   window.location.href = 'settings.php';";
        echo "</script>";
    }
?>

<?php
    $file = fopen("graphs/settings.ini", "r");
    $line = fgets($file);
    $saved_interval = fgets($file);
    $saved_interval = rtrim($saved_interval,"\n");
    $vidname = fgets($file);
    $duration = fgets($file);
?>

<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') startblock('extrastyle') ?>
    <title> CI - Settings </title>
    <style>
        html {
            /* padding: 20px; */
            /* background-color: rgba(255, 210, 210, 0.692); */
            background-color: rgba(182, 225, 253, 0.493);
            /* rgba(206, 206, 206, 0.322); */
        }
        body {
            /* background-color: rgba(122, 47, 47, 0); */
            background-color: rgba(17, 58, 97, 0);
            padding: 10px;
        }
    </style>
<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') endblock() ?>

<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') startblock('body') ?>
    <div class="container ui segment" style="text-align: center; width: 50%; background-color: #fff; padding-left: 50px; padding-right: 50px;">
    <br><form class="ui form" action="settings.php" method="post">
        <h1>DASHBOARD SETTINGS</h1><br>
        <h3 class="ui dividing header">ADC/Behavioral Module Internal Benchmarking</h3>
        <div class="three fields">
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="adc_daily" value="adc_daily">
                    <label>DAILY/WEEKLY</label>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="adc_monthly" value="adc_monthly">
                    <label>MONTHLY</label>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="adc_overall" value="adc_overall">
                    <label>OVERALL</label>
                </div>
            </div>
        </div>
        <h3 style="margin-top: 40px;" class="ui dividing header">TrendX Module Internal Benchmarking</h3>
        <div class="two fields">
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trendx_weekly" value="trendx_weekly">
                    <label>WEEKLY</label>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trendx_monthly" value="trendx_monthly">
                    <label>MONTHLY</label>
                </div>
            </div>
        </div><br>
        <div class="two fields">
            <div class="fifteen wide field">
                <h3 style="margin-top: 10px;"class="ui dividing header">ADC/Behavioral Module Bar Graph</h3>
                <div class="three fields">
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="check_box[]" id="adc_3bars" value="adc_3bars">
                            <label>3 Bars</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="check_box[]" id="adc_2bars" value="adc_2bars">
                            <label>2 Bars</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="check_box[]" id="adc_1bar" value="adc_1bar">
                            <label>1 Bar</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <h3 style="margin-top: 10px;" class="ui dividing header">Samples Bar Graph</h3>
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="samples_bar" value="samples_bar">
                    <label>Show</label>
                </div>
            </div>
        </div>

        <h3 style="margin-top: 40px;" class="ui dividing header">TrendX Monthly and Overall and Samples</h3>
        <div class="two fields">
        <div class="field">
            <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trendxpie_monthly" value="trendxpie_monthly">
                    <label>MONTHLY</label>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trendxpie_overall" value="trendxpie_overall">
                    <label>OVERALL</label>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trendxline_overall" value="trendxline_overall">
                    <label>SAMPLE OVERALL</label>
                </div>
            </div>

              <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="trend_dashboard" value="trend_dashboard">
                    <label>TREND DASHBOARD</label>
                </div>
            </div>
        </div><br>

        <h3 class="ui dividing header">Video</h3>
        <div class="three fields">
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="check_box[]" id="video" value="video">
                    <label>Play</label>
                </div>
            </div>
            <div class="field">
                <div class="ui input">
                    <input type="text" placeholder="Video Name" id="video_name" name="video_name" value="<?php echo $vidname?>">
                </div>
            </div>
            <div class="field">
                <div class="ui right labeled input">
                    <input type="number" placeholder="Duration" id="video_duration" name="video_duration" value="<?php echo $duration?>">
                    <label class="ui basic label">seconds</label>
                </div>
            </div>
        </div><br><br>
        <div class="field">
            <div style="width: 50%;" class="ui right labeled input">
                <label for="graph_interval" class="ui grey label"><i class="clock outline icon"></i>Interval Time</label>
                <input style="text-align: right;" type="number" min="0" step="1" id="graph_interval" name="graph_interval" value="<?php echo $saved_interval?>">
                <label class="ui basic label">seconds</label>
            </div>
        </div><br>
        <div class="column">
            <button type="submit" class="ui green button" id="save_button" name="save_button" onclick="SaveSettings()">
                <i class="check icon"></i> SAVE
            </button>
            <a class="ui red button" href="index.php" id="cancel_button" >
                <i class="ban icon"></i> CANCEL
            </a>
        </div>
    </form>
</div>
<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') endblock() ?>

<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') startblock('extrascripts') ?>
    <script>
        window.onload = onPageLoad();
        function onPageLoad() {
            <?php
                $file = fopen("graphs/settings.ini", "r");
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
                    echo "document.getElementById('trendxpie_monthly').checked = true;";
                }
                if($line[10] == "1") {
                    echo "document.getElementById('trendxpie_overall').checked = true;";
                }
                if($line[11] == "1") {
                    echo "document.getElementById('trendxline_overall').checked = true;";
                }
                if($line[12] == "1") {
                    echo "document.getElementById('trend_dashboard').checked = true;";
                }
                if($line[13] == "1") {
                    echo "document.getElementById('video').checked = true;";
                }
                fclose($file);
            ?>
        }
    </script>
<?php if(isset($_SESSION['username']) and $_SERVER['REQUEST_METHOD'] === 'GET') endblock() ?>