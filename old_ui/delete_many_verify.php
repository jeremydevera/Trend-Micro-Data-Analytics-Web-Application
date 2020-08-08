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
      position: fixed;
    }
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
</head>


<?php
    $password = "";
    $password_error = "";
    $conn = mysqli_connect("localhost", "root", "","charles_db");

	if(isset($_POST['delete'])){
		$password = $_POST['password'];
		$query = "SELECT * FROM charles_table_users WHERE username='$_SESSION[username]' and password='$password'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result)>=1){
			header("Location:delete_many.php");
		}else{
			$password_error = "Wrong Password";
		}

	}
	else if(isset($_POST['cancel'])){
		header("Location:index.php");
	}
?>


<body>

<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    <div class="collapse navbar-collapse" id="myNavbar">
       <ul class="nav nav-bar"><br>

        <li><a href="index.php">Home</a></li>

        <li><a data-target="#demo3" data-toggle="collapse">Selections <span class="glyphicon glyphicon-chevron-down"></span></a></li>
          <ul class="collapse nav nav-pills nav-stacked" id="demo3">
            <li class="active"><a href="source.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Source</a></li>
            <li><a href="adc.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage ADC</a></li>
            <li><a href="analyze.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Analyze</a></li>
          </ul>

        <li><a data-target="#demo4" data-toggle="collapse">Users <span class="glyphicon glyphicon-chevron-down"></span></a></li>
          <ul class="collapse nav nav-pills nav-stacked" id="demo4">
            <li><a href="users.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Accounts</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-chevron-right"></span> Log In</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-chevron-right"></span> Log Out</a></li>
          </ul>
        <li><a href="daily.php" target="_blank">Dashboard</a></li>
        <li><a href="history.php">History</a></li>
      </ul>

    </div>
  </div>
</nav>


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-2 sidenav hidden-xs">
      <div class="row">
        <br><img class="img-responsive" src="trend_micro.jpg"><br>
      </div>
      <img src="image.jpg" class="img-responsive">
      <ul class="nav nav-pills nav-stacked"><br>

        <li><a href="index.php">Home</a></li>

        <li><a data-target="#demo1" data-toggle="collapse">Selections <span class="glyphicon glyphicon-chevron-down"></span></a></li>
          <ul class="collapse nav nav-pills nav-stacked" id="demo1">
            <li class="active"><a href="source.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Source</a></li>
            <li><a href="adc.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage ADC</a></li>
            <li><a href="analyze.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Analyze</a></li>
          </ul>


        <li><a data-target="#demo2" data-toggle="collapse">Users <span class="glyphicon glyphicon-chevron-down"></span></a></li>
          <ul class="collapse nav nav-pills nav-stacked" id="demo2">
            <li><a href="users.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Accounts</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-chevron-right"></span> Log In</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-chevron-right"></span> Log Out</a></li>
          </ul>
        <li><a href="daily.php" target="_blank">Dashboard</a></li>
        <li><a href="history.php">History</a></li>
      </ul>
      <br>
    </div>
    <br>

    <div class="col-sm-offset-2 col-sm-10">

       <div class="col-sm-offset-3 col-sm-6">
        <br><br><br>
        <h3 class="text-center">DELETE MULTIPLE</h3><br>
        <form method="post" action=""<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">

          <div class="input-group <?php if ($password_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" placeholder="Password" name="password" data-toggle="tooltip" title="<?php echo $password_error; ?>">
            <span class="<?php if ($password_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>
            <button type="submit" class="btn btn-primary btn-block" name="delete">Delete</button>
            <button type="submit" class="btn btn-danger btn-block" name="cancel">Cancel</button>
        </form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
