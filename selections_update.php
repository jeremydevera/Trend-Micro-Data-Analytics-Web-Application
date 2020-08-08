<?php include 'auth.php' ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['sel_id'];
        $name = str_replace("'", '', $_POST['sel_name']);
        $type = $_POST['sel_type'];
        $conn = mysqli_connect("localhost", "root", "", "charles_db");
        $sql = " UPDATE charles_table_" . $type . " SET name='$name' ";
        if($type == "source" or $type == "adc") {
            $sql .= ", value='$name' ";
        }
        $sql .= "WHERE id='$id' ";
        $result = mysqli_query($conn, $sql);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "selections.php";';
        echo '</script>';
    }
?>