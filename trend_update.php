<?php include 'auth.php' ?>

<?php
    $id = $_POST['update_id'];
    $date_sourced = $_POST['date_sourced'];
    $sha1 = str_replace("'", '', $_POST['sha1']);
    $vsdt = $_POST['vsdt'];
    $notes = str_replace("'", '', $_POST['notes']);
    $falcon = str_replace("'", '', $_POST['falcon']);
    $trendx = str_replace("'", '', $_POST['trendx']);
    $suggested = str_replace("'", '', $_POST['suggested']);
    $mtf = str_replace("'", '', $_POST['mtf']);

    $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
    $check = " SELECT id FROM jeremy_table_trend WHERE sha1='$sha1' AND id!='$id' ";
    $check = mysqli_query($conn, $check);
    if(mysqli_num_rows($check) > 0) {
        echo '<script type="text/javascript">';
        echo '    alert("SHA-1 already exists!");';
        echo '    window.location.href = "index.php";';
        echo '</script>';
    } else {
        $sql = "UPDATE jeremy_table_trend SET  date_sourced='$date_sourced', mtf = '$mtf', sha1='$sha1', suggested='$suggested', vsdt='$vsdt', trendx='$trendx', falcon='$falcon', notes='$notes' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $log = date("Y-m-d (h:ia)");
        $hist = " INSERT INTO jeremy_table_trend(date_sourced, sha1, suggested, vsdt, notes, trendx, falcon, mtf) VALUES($date_sourced', '$sha1','$suggested', '$vsdt', '$notes', '$trendx','$falcon','$mtf') ";
        $result = mysqli_query($conn, $hist);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "index.php";';
        echo '</script>';
    }
?>