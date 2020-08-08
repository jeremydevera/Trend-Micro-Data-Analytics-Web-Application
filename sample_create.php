<?php include 'auth.php' ?>

<?php 
    $source = $_POST['source'];
    $date_sourced = $_POST['date_sourced'];
    $sha1 = $_POST['sha1'];
    $adc = $_POST['adc'];
    $other_detection = $_POST['other_detection'];
    $notes = $_POST['notes'];
    $file_detection = $_POST['file_detection'];
    $trendx = $_POST['trendx'];
    $trigger = $_POST['trigger'];
    $prevalence = $_POST['prevalence'];
    $path = $_POST['path'];
    $analyze = $_POST['analyze'];
    $date_tested = $_POST['date_tested'];
    $tester = $_SESSION['username'];

    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $check = " SELECT id from charles_table_primary where sha1='$sha1' ";
    $check = mysqli_query($conn, $check);
    if(mysqli_num_rows($check) > 0) {
        echo '<script type="text/javascript">';
        echo '    alert("SHA-1 already exists!");';
        echo '    window.location.href = "adc.php";';
        echo '</script>';
    } else {
        $query = " INSERT INTO charles_table_primary(source, date_sourced, sha1, adc, other_detection, notes, file_detection, trendx, trig, prev, path, analyze_analyze, date_tested, tester) VALUES('$source', '$date_sourced', '$sha1', '$adc', '$other_detection', '$notes', '$file_detection', '$trendx', '$trigger', '$prevalence', '$path', '$analyze', '$date_tested', '$tester') ";
        $result = mysqli_query($conn, $query);
        echo mysqli_error($conn);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Created!");';
        echo '    window.location.href = "adc.php";';
        echo '</script>';
    }
?>