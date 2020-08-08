<?php include 'auth.php' ?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $sample_ids = explode(',', $_POST['update_ids']);
    $hid = $sample_ids;
    $hid_count = count($sample_ids);
    $update_query = "";
    if ($_POST['source'] or $_POST['tester'] or $_POST['date_sourced'] or $_POST['adc'] or $_POST['sha1'] or $_POST['trigger'] or $_POST['prevalence'] or $_POST['other_detection'] or $_POST['file_detection'] or $_POST['trendx'] or $_POST['path'] or $_POST['analyze'] or $_POST['date_tested'] or $_POST['notes']) {
        $update_query = "UPDATE charles_table_primary SET ";
        if ($_POST['source']) {
            $update_query .= " source = '" . $_POST['source'] . "',";
        }
        if ($_POST['date_sourced']) {
            $update_query .= " date_sourced = '" . $_POST['date_sourced'] . "',";
        }
        if ($_POST['adc']) {
            $update_query .= " adc = '" . $_POST['adc'] . "',";
        }
        if ($_POST['trigger']) {
            $update_query .= " trig = '" . $_POST['trigger'] . "',";
        }
        if ($_POST['prevalence']) {
            $update_query .= " prev = '" . $_POST['prevalence'] . "',";
        }
        if ($_POST['other_detection']) {
            $update_query .= " other_detection = '" . $_POST['other_detection'] . "',";
        }
        if ($_POST['file_detection']) {
            $update_query .= " file_detection = '" . $_POST['file_detection'] . "',";
        }
        if ($_POST['trendx']) {
            $update_query .= " trendx = '" . $_POST['trendx'] . "',";
        }
        if ($_POST['path']) {
            $update_query .= " path = '" . $_POST['path'] . "',";
        }
        if ($_POST['analyze']) {
            $update_query .= " analyze_analyze = '" . $_POST['analyze'] . "',";
        }
        if ($_POST['date_tested']) {
            $update_query .= " date_tested = '" . $_POST['date_tested'] . "',";
        }
        if ($_POST['notes']) {
            $update_query .= " notes = '" . $_POST['notes'] . "',";
        }
        $update_query .= " tester = '" . $_SESSION['username'] . "',";

        $update_query=rtrim($update_query,", ");
        for($i = 0; $i < count($sample_ids); $i++) {
            $temp = $update_query;
            $temp .= " WHERE id = " . $sample_ids[$i];
            $result = mysqli_query($conn, $temp);
        }
        $log = date("Y-m-d (h:ia)");
        for($i = 0; $i < $hid_count; $i++) {
            $query = " SELECT * FROM charles_table_primary where id='$hid[$i]' ";
            $query = mysqli_query($conn, $query);
            while($result = mysqli_fetch_assoc($query)) {
                $sql = "INSERT INTO charles_table_history(source, date_sourced, sha1, adc, other_detection, file_detection, trendx, trig, prev, path, analyze_analyze, date_tested, tester, log, notes)
                VALUES('".$result['source']."', '".$result['date_sourced']."', '".$result['sha1']."', '".$result['adc']."', '".$result['other_detection']."', '".$result['file_detection']."', '".$result['trendx']."', '".$result['trig']."', '".$result['prev']."', '".$result['path']."', '".$result['analyze_analyze']."', '".$result['date_tested']."', '".$result['tester']."', '$log', '".$result['notes']."')";
                $result = mysqli_query($conn, $sql);
                echo mysqli_error($conn);
            }
        }
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "adc.php";';
        echo '</script>';
    }
?>