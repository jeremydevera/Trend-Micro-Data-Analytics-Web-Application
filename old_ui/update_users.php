<?php
  include 'pass.php';
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
    }
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
</head>

	<?php

		$username = $old_password = $password =  $confirm = "";
		$username_error = $old_password_error = $password_error =  $confirm_error = "";
		$conn = mysqli_connect("localhost", "root", "", "charles_db");


		    if(isset($_GET["update"])){
		        $id = $_GET["update"];
		        $sql_select = "SELECT * FROM charles_table_users WHERE id='$id'";
		        $result_select = mysqli_query($conn, $sql_select);
		        $row = mysqli_fetch_array($result_select);
		    }
		    if(isset($_POST["create"])){
		        $username = $_POST['username'];
		        $old_password = $_POST['old_password'];
				$password = $_POST['password'];
				$confirm = $_POST['confirm'];
				$query = "SELECT * FROM charles_table_users WHERE username='$username'";
				$result = mysqli_query($conn, $query);

				if($username){
					$username = check($username);
					if(strlen($username)<5){
						$username_error = "Too short";
					}
					else if(mysqli_num_rows($result)>=1 && $row['username']!=$username){
						$username_error = "Username Exists";
					}
					else if(!preg_match("/^[a-zA-Z ]*$/", $username)){
						$username_error = "Invalid Character/s";
					}
				}else{
					$username_error = "Empty";
				}

				if($old_password){
					$old_password = check($old_password);
					if($old_password != $row['password']){
						$old_password_error = "Incorrect";
					}
				}else{
					$old_password_error = "Empty";
				}

				if($password){
					$password = check($password);
					if(strlen($password)<9){
						$password_error = "Weak Password";
					}
				}else{
					$password_error = "Empty";
				}

				if($confirm){
					$confirm = check($confirm);
					if(strlen($confirm)<9){
						$confirm_error = "Weak Password";
					}
				}else{
					$confirm_error = "Empty";
				}

				if(($confirm != $password) && (empty($password_error) && empty($confirm_error)) ){
					$password_error = $confirm_error = " *Did not match";
				}

				if(empty($username_error) && empty($old_password_error) && empty($password_error) && empty($confirm_error)){
			        $sql_update = "UPDATE charles_table_users SET username='$username', password='$password' WHERE id='$id'";
			        $result_update=mysqli_query($conn, $sql_update);
			        echo '<script type="text/javascript">';
					echo 'alert("Successfully Updated!");';
					echo 'window.location.href = "users.php";';
					echo '</script>';
					mysqli_error($conn);
				}

		    }else if(isset($_POST["cancel"])){
		    	header('Location:users.php');
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

    <div class="col-sm-10">

       <div class="col-sm-offset-3 col-sm-6">
        <br><br><br>
        <h3 class="text-center">UPDATE ACCOUNT</h3><br>

		<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="input-group <?php if ($username_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $row['username'];?>" data-toggle="tooltip" title="<?php echo $username_error; ?>">
            <span class="<?php if ($username_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>

          <div class="input-group <?php if ($old_password_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" placeholder="Old Password" name="old_password" value="<?php echo $old_password;?>" data-toggle="tooltip" title="<?php echo $old_password_error; ?>">
            <span class="<?php if ($old_password_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>

          <div class="input-group <?php if ($password_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password;?>" data-toggle="tooltip" title="<?php echo $password_error; ?>">
            <span class="<?php if ($password_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>

          <div class="input-group <?php if ($confirm_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" placeholder="Confrim New Password" name="confirm" value="<?php echo $confirm;?>" data-toggle="tooltip" title="<?php echo $confirm_error; ?>">
            <span class="<?php if ($confirm_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>

          <button type="submit" class="btn btn-primary btn-block" name="create">Update</button>
          <button type="submit" class="btn btn-danger btn-block" name="cancel">Cancel</button>
		</form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
