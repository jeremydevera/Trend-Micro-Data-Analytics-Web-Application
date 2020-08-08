<?php include 'auth.php' ?>

<?php
    $id = $_POST['update_id'];
    $source = $_POST['source'];
    $date_sourced = $_POST['date_sourced'];
    $sha1 = str_replace("'", '', $_POST['sha1']);
    $adc = $_POST['adc'];
    $other_detection = str_replace("'", '', $_POST['other_detection']);
    $notes = str_replace("'", '', $_POST['notes']);
    $file_detection = str_replace("'", '', $_POST['file_detection']);
    $trendx = str_replace("'", '', $_POST['trendx']);
    $trigger = $_POST['trigger'];
    $prevalence = $_POST['prevalence'];
    $path = str_replace("'", '', $_POST['path']);
    $analyze = $_POST['analyze'];
    $date_tested = $_POST['date_tested'];
    $tester = $_SESSION['username'];

    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $check = " SELECT id FROM charles_table_primary WHERE sha1='$sha1' AND id!='$id' ";
    $check = mysqli_query($conn, $check);
    if(mysqli_num_rows($check) > 0) {
        echo '<script type="text/javascript">';
        echo '    alert("SHA-1 already exists!");';
        echo '    window.location.href = "adc.php";';
        echo '</script>';
    } else {
        $sql = "UPDATE charles_table_primary SET source='$source', date_sourced='$date_sourced', sha1='$sha1', adc='$adc', other_detection='$other_detection', file_detection='$file_detection', trendx='$trendx', trig='$trigger', prev='$prevalence', path='$path', analyze_analyze='$analyze', date_tested='$date_tested', tester='$tester', notes='$notes' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $log = date("Y-m-d (h:ia)");
        $hist = " INSERT INTO charles_table_history(source, date_sourced, sha1, adc, other_detection, notes, file_detection, trendx, trig, prev, path, analyze_analyze, date_tested, tester, log) VALUES('$source', '$date_sourced', '$sha1', '$adc', '$other_detection', '$notes', '$file_detection', '$trendx', '$trigger', '$prevalence', '$path', '$analyze', '$date_tested', '$tester', '$log') ";
        $result = mysqli_query($conn, $hist);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "adc.php";';
        echo '</script>';
    }
?>