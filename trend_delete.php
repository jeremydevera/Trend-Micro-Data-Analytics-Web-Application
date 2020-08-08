<?php include 'auth.php' ?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
    $id = explode(',', $_POST['delete_id']);
    ini_set('max_execution_time', 5000);
    for($i = 0; $i < count($id); $i++) {
        $query = " DELETE FROM jeremy_table_trend WHERE id='$id[$i]' ";
        $result = mysqli_query($conn, $query);
    }
    echo '<script type="text/javascript">'; 
    echo '      alert("Succesfully Deleted!");'; 
    echo '      window.location.href = "index.php";';
    echo '</script>';
?>