<?php
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .row.content {
      height: 1500px
    }
    .sidenav {
      background-color: #263643 ;
      height: 100%;
      position: fixed;
    }
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>

</head>

  <?php
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $username = $password = "";
    $username_error = $password_error = "";

    if(isset($_POST['login'])){
      $username = $_POST['username'];
      $password = $_POST['password'];

      if($username){
        $username = check($username);
        if(!preg_match('/[a-z\s]/i', $username)){
          $username_error = "Invalid Character/s";
        }
      }else{
        $username_error = "Empty";
      }

      if($password){
        $password = check($password);
      }else{
        $password_error = "Empty";
      }


        if(empty($username_error) && empty($password_error)){
          $query = "SELECT * FROM charles_table_users WHERE username='$username' and password='$password'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_array($result);
            if(mysqli_num_rows($result)>=1){
              $_SESSION['username'] = ucwords($row['username']);
              echo '<script type="text/javascript">';
              echo 'alert("Your are logged in!");';
              echo 'window.location.href = "index.php";';
              echo '</script>';
              echo $result;
            }else{
              $username_error = $password_error = "Failed";
            }

        }


    }else if(isset($_POST['cancel'])){
      header('Location:index.php');
    }
    function check($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

  ?>

<body>

    <?php
      include 'navbar.php';
    ?>


  <div class="col-sm-offset-2 col-sm-10">

       <div class="col-sm-offset-3 col-sm-6">
       <br><br><br>
        <h3 class="text-center">LOG IN</h3><br>

		  <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	          <div class="input-group <?php if ($username_error) echo "has-error";?> ">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	            <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username;?>" data-toggle="tooltip" title="<?php echo $username_error; ?>">
	            <span class="<?php if ($username_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
	          </div><br>

	           <div class="input-group <?php if ($password_error) echo "has-error";?> ">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	            <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password;?>" data-toggle="tooltip" title="<?php echo $password_error; ?>">
	            <span class="<?php if ($password_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
	          </div><br>

	          <button type="submit" class="btn btn-primary btn-block" name="login">Log In</button>
	          <button type="submit" class="btn btn-danger btn-block" name="cancel">Cancel</button>
		  </form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
