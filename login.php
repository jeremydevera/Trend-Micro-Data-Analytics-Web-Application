<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM charles_table_users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    if($username and $password and mysqli_num_rows($result)==1) {
        if($password == $row['password']) {
            $_SESSION['username'] = $row['username'];
            echo '<script type="text/javascript">';
            echo 'alert("Your are logged in!");';
            echo 'window.location.href = "adc.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Login Failed!");';
            echo 'window.location.href = "adc.php";';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Login Failed!");';
        echo 'window.location.href = "adc.php";';
        echo '</script>';
    }
?>