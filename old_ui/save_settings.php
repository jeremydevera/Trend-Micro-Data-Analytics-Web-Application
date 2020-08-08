<?php
    include 'pass.php';
?>

<!DOCTYPE html>
<html>
    <?php
        $file = fopen("settings.ini", "w+");
        $id = $_SESSION['id_array'];
        $id_last = count($id);
        $graphs = array("adc_daily", "adc_monthly", "adc_overall", "trendx_weekly", "trendx_monthly", "adc_3bars", "adc_2bars", "adc_1bar", "samples_bar", "video");
        $j = 0;
        for($i = 0; $i < 10; $i++) {
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
        fwrite($file, $_SESSION['graph_interval']);
        fwrite($file, "\n");
        fwrite($file, $_SESSION['video_name']);
        fwrite($file, "\n");
        fwrite($file, $_SESSION['video_duration']);

        echo "<script type='text/javascript'>;";
        echo "   alert('Settings Saved!');";
        echo "   window.location.href = 'index.php';";
        echo "</script>";
    ?>
</html>
