<!DOCTYPE html>
<html>
	<?php
		include 'read_settings.php';
		$curr = $_SESSION['current_graph'];
		for($i = 1; $i < 10; $i++) {
			$temp = (($i + $curr) % 10);
            if($line[$temp] == "1") {
				if($temp == 0) {
					echo '<script> setTimeout(function(){ window.open("adc_pie.php"); }, ';
					if($line[9] != 1) {
						$duration = $saved_interval;
					}
					echo  $duration;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo  $duration;
					echo '000);</script>';
				} elseif($temp == 1) {
					echo '<script> setTimeout(function(){ window.open("monthly.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 2) {
					echo '<script> setTimeout(function(){ window.open("overall.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 3) {
					echo '<script> setTimeout(function(){ window.open("trendx_weekly.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 4) {
					echo '<script> setTimeout(function(){ window.open("trendx_monthly.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 5) {
					echo '<script> setTimeout(function(){ window.open("adc_bar1.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 6) {
					echo '<script> setTimeout(function(){ window.open("adc_bar2.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 7) {
					echo '<script> setTimeout(function(){ window.open("adc_bar.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				} elseif($temp == 8) {
					echo '<script> setTimeout(function(){ window.open("bar.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				}  else {
					echo '<script> setTimeout(function(){ window.open("video.php"); }, ';
					echo $saved_interval;
					echo '000); </script>';
					echo '<script type="text/javascript">setTimeout("window.close();", ';
					echo $saved_interval;
					echo '000);</script>';
				}
				break;
			}
		}
	?>
</html>