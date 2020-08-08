<?php include 'auth.php' ?>

<?php
    $password = $_POST['delete_password'];
    $id = $_POST['id_delete'];
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $conn2 = mysqli_connect("localhost", "root", "", "jeremy_db");
    $create = " DELETE FROM charles_table_users WHERE id='$id' ";
    $create2 = " DELETE FROM jeremy_table_users WHERE id='$id' ";
    $create = mysqli_query($conn, $create);
    $create2 = mysqli_query($conn2, $create2);
    echo '<script type="text/javascript">';
    echo '    alert("Successfully Deleted!");';
    echo '    window.location.href = "users.php";';
    echo '</script>';
?>