<?php include 'auth.php' ?>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo $_SESSION['username'] . " ---> " . str_replace("'", '', $_POST['new_username'];)
    if($_POST['update_type'] == 'update') {
        $exists = " SELECT * FROM charles_table_users WHERE username='" . $_POST['new_username'] . "' ";
        $exists = mysqli_query($conn, $exists);
        $exists2 = " SELECT * FROM jeremy_table_users WHERE username='" . $_POST['new_username'] . "' ";
        $exists2 = mysqli_query($conn2, $exists2);
        if(mysqli_num_rows($exists and $exists2)) {
            echo '<script type="text/javascript">';
            echo '    alert("Username Exists!\nUpdate failed!");';
            echo '    window.location.href = "users.php";';
            echo '</script>';
        } else {
            $user = " UPDATE charles_table_users SET username='" . str_replace("'", '', $_POST['new_username']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
            $result = mysqli_query($conn, $user);
            $samples = " UPDATE charles_table_primary SET tester='" . str_replace("'", '', $_POST['new_username']) . "' WHERE tester='" . str_replace("'", '', $_POST['update_user']) . "' ";
            $result = mysqli_query($conn, $samples);

            $user2 = " UPDATE jeremy_table_users SET username='" . str_replace("'", '', $_POST['new_username']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
            $result2 = mysqli_query($conn2, $user2);
            $_SESSION['username'] = $_POST['new_username'];
            echo '<script type="text/javascript">';
            echo '    alert("Successfully Updated!");';
            echo '    window.location.href = "users.php";';
            echo '</script>';
        }
    } elseif($_POST['update_type'] == 'password') {
        $user = " UPDATE charles_table_users SET password='" . str_replace("'", '', $_POST['new_password']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
        $result = mysqli_query($conn, $user);
        $user2 = " UPDATE jeremy_table_users SET password='" . str_replace("'", '', $_POST['new_password']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
        $result2 = mysqli_query($conn2, $user2);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    } elseif($_POST['update_type'] == "delete") {
        $user = " DELETE FROM charles_table_users WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
        $result = mysqli_query($conn, $user);

        $user2 = " DELETE FROM jeremy_table_users WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
        $result2 = mysqli_query($conn2, $user2);
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Deleted!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    } elseif($_POST['update_type'] == 'account') {
        $proceed = 1;
        if($_POST['acct_username'] != "") {
            $exists = " SELECT * FROM charles_table_users WHERE username='" . $_POST['acct_username'] . "' ";
            $exists = mysqli_query($conn, $exists);

            $exists2 = " SELECT * FROM jeremy_table_users WHERE username='" . $_POST['acct_username'] . "' ";
            $exists2 = mysqli_query($conn2, $exists2);
            if(mysqli_num_rows($exists AND $exists2)) {
                $proceed = 0;
                echo '<script type="text/javascript">';
                echo '    alert("Username Exists!\nUpdate failed!");';
                echo '    window.location.href = "users.php";';
                echo '</script>';
            } else {
                $user = " UPDATE charles_table_users SET username='" . str_replace("'", '', $_POST['acct_username']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
                $result = mysqli_query($conn, $user);
                $samples = " UPDATE charles_table_primary SET tester='" . str_replace("'", '', $_POST['acct_username']) . "' WHERE tester='" . str_replace("'", '', $_POST['update_user']) . "' ";
                $result = mysqli_query($conn, $samples);

                $user2 = " UPDATE jeremy_table_users SET username='" . str_replace("'", '', $_POST['acct_username']) . "' WHERE username='" . str_replace("'", '', $_POST['update_user']) . "' ";
                $result2 = mysqli_query($conn2, $user2);
                $result2 = mysqli_query($conn2, $samples2);
            }
        }
        if($_POST['new_password'] != "" AND $proceed == 1) {
            $user = " UPDATE charles_table_users SET password='" . str_replace("'", '', $_POST['new_password']) . "' WHERE username='" . str_replace("'", '', $_POST['acct_username']) . "' ";
            $result = mysqli_query($conn, $user);

            $user2 = " UPDATE jeremy    _table_users SET password='" . str_replace("'", '', $_POST['new_password']) . "' WHERE username='" . str_replace("'", '', $_POST['acct_username']) . "' ";
            $result2 = mysqli_query($conn2, $user2);
        }
        echo '<script type="text/javascript">';
        echo '    alert("Successfully Updated!");';
        echo '    window.location.href = "users.php";';
        echo '</script>';
    }
} ?>