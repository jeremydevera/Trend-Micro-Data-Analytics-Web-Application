<?php include 'auth.php' ?>

<?php 
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $sel_type = $_POST['sel_type'];
    $sel_name = str_replace("'", '', $_POST['sel_name']);
    $exists = " SELECT * FROM charles_table_" . $sel_type . " WHERE ";
    if ($sel_type == "source" or $sel_type == "adc") $exists .= " value='$sel_name'";
    else $exists .= " name='$sel_name'";
    $exists = mysqli_query($conn, $exists);
    if(mysqli_num_rows($exists)) {
        echo '<script type="text/javascript">';
        echo '    alert("Creation failed!\nInput already exists!");';
        echo '    window.location.href = "selections.php";';
        echo '</script>';
    } else {
        $query = "INSERT INTO charles_table_" . $sel_type . "(name";
        if ($sel_type == "source" or $sel_type == "adc") $query .= ", value";
        $query .= ") VALUES('$sel_name'";
        if ($sel_type == "source" or $sel_type == "adc") $query .= ", '$sel_name'";
        $query .= ")";
        // echo $query;
        $result = mysqli_query($conn, $query);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Created!");';
        echo '    window.location.href = "selections.php";';
        echo '</script>';
    }
?>