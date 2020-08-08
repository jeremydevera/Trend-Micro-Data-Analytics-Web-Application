<?php include 'auth.php' ?>

<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['sel_id'];
        $type = $_POST['sel_type'];
        $conn = mysqli_connect("localhost", "root", "", "charles_db");
        $sql = " DELETE FROM charles_table_" . $type . " WHERE id='$id' ";
        $result = mysqli_query($conn, $sql);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Deleted!");';
        echo '    window.location.href = "selections.php";';
        echo '</script>';
    }
?>