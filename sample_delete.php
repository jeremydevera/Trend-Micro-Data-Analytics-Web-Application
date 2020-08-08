<?php include 'auth.php' ?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $id = explode(',', $_POST['delete_id']);
    for($i = 0; $i < count($id); $i++) {
        $query = " DELETE FROM charles_table_primary WHERE id='$id[$i]' ";
        $result = mysqli_query($conn, $query);
    }
    echo '<script type="text/javascript">'; 
    echo '      alert("Succesfully Deleted!");'; 
    echo '      window.location.href = "adc.php";';
    echo '</script>';
?>