<?php include 'auth.php' ?>

<?php
    $sample_ids = explode(',', $_POST['sample_ids']);
    $username = $_SESSION['username'];
    for($i = 0; $i < count($sample_ids); $i++) {
        $query = " DELETE FROM charles_table_history WHERE id='$sample_ids[$i]' ";
        $result = mysqli_query($conn, $query);
        echo '<script type="text/javascript">'; 
        echo '      alert("Succesfully Deleted!");'; 
        echo '      window.location.href = "history.php";';
        echo '</script>';
    }
?>