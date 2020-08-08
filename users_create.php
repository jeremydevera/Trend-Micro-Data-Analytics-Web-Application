<?php include 'auth.php' ?>

<?php
    $username = $_POST['create_username'];
    $password = $_POST['create_password'];
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $conn2 = mysqli_connect("localhost", "root", "", "jeremy_db");
    $create = " SELECT * FROM charles_table_users WHERE username='$username' ";
    $create2 = " SELECT * FROM jeremy_table_users WHERE username='$username' ";
    $create = mysqli_query($conn, $create);
    if(mysqli_num_rows($create)) {
        echo '<script type="text/javascript">';
        echo '    alert("Username Exists!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    } else {
        $query = "INSERT INTO charles_table_users(username, password) VALUES('$username', '$password')";
        $result = mysqli_query($conn, $query);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Created!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    }

    if(mysqli_num_rows($create2)) {
        echo '<script type="text/javascript">';
        echo '    alert("Username Exists!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    } else {
        $query = "INSERT INTO jeremy_table_users(username, password) VALUES('$username', '$password')";
        $result = mysqli_query($conn2, $query);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Created!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    }
?>