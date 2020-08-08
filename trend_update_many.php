<?php include 'auth.php' ?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
    $sample_ids = explode(',', $_POST['update_ids']);
    $hid = $sample_ids;
    $hid_count = count($sample_ids);
    $update_query = "";
    if ($_POST['date_sourced'] or $_POST['vsdt'] or $_POST['trendx'] or $_POST['notes'] or $_POST['mtf'] or $_POST['suggested'] or $_POST['falcon']) {
        $update_query = "UPDATE jeremy_table_trend SET ";
        if ($_POST['date_sourced']) {
            $update_query .= " date_sourced = '" . $_POST['date_sourced'] . "',";
        }
        if ($_POST['vsdt']) {
            $update_query .= " vsdt = '" . $_POST['vsdt'] . "',";
        }
        if ($_POST['trendx']) {
            $update_query .= " trendx = '" . $_POST['trendx'] . "',";
        }
        if ($_POST['notes']) {
            $update_query .= " notes = '" . $_POST['notes'] . "',";
        }
        if ($_POST['mtf']) {
            $update_query .= " mtf = '" . $_POST['mtf'] . "',";
        }
        if ($_POST['suggested']) {
            $update_query .= " suggested = '" . $_POST['suggested'] . "',";
        }
        if ($_POST['falcon']) {
            $update_query .= " falcon = '" . $_POST['falcon'] . "',";
        }
        

        $update_query=rtrim($update_query,", ");
        for($i = 0; $i < count($sample_ids); $i++) {
            $temp = $update_query;
            $temp .= " WHERE id = " . $sample_ids[$i];
            $result = mysqli_query($conn, $temp);
        }
        $log = date("Y-m-d (h:ia)");
        for($i = 0; $i < $hid_count; $i++) {
            $query = " SELECT * FROM jeremy_table_trend where id='$hid[$i]' ";
            $query = mysqli_query($conn, $query);
        }
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "index.php";';
        echo '</script>';
    }
    
?>