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
      height: 1200px
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

    $name = $value = "";
    $name_error = $value_error = "";
    $conn=mysqli_connect("localhost", "root", "","charles_db");


        if(isset($_GET["update"])){
            $id = $_GET["update"];
            $sql_select = "SELECT * FROM charles_table_analyze WHERE id='$id'";
            $result_select = mysqli_query($conn, $sql_select);
            $row = mysqli_fetch_array($result_select);
        }
        if(isset($_POST["create"])){
          $name = $_POST['name'];
          $value = $_POST['value'];
          $query = "SELECT * FROM charles_table_analyze WHERE name='$name'";
          $result = mysqli_query($conn, $query);

          if($name){
            $name = check($name);
            if(mysqli_num_rows($result)>=1){
              $name_error = "Data Exists";
            }
          }else{
            $name_error = "Empty";
          }

          $query = "SELECT * FROM charles_table_analyze WHERE name='$value'";
          $result = mysqli_query($conn, $query);

          if($value){
            $value = check($value);
            if(mysqli_num_rows($result)>=1){
              $value_error = "Data Exists";
            }
          }else{
            $value_error = "Empty";
          }


          if(empty($name_error) && empty($value_error)){
            $query = "INSERT INTO charles_table_analyze(name, value)
            VALUES('$name', '$value')";
            $result = mysqli_query($conn, $query);
            echo '<script type="text/javascript">';
            echo 'alert("Successfully Created!");';
            echo 'window.location.href = "analyze.php";';
            echo '</script>';
          }

        }else if(isset($_POST["cancel"])){
          header('Location:analyze.php');
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
        <h3 class="text-center">CREATE ANALYZE</h3><br>
        <form method="post" action=""<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">

          <div class="input-group <?php if ($name_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $name;?>" data-toggle="tooltip" title="<?php echo $name_error; ?>">
            <span class="<?php if ($name_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>

          <div class="input-group <?php if ($value_error) echo "has-error";?> ">
            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
            <input type="text" class="form-control" placeholder="Value" name="value" value="<?php echo $value;?>" data-toggle="tooltip" title="<?php echo $value_error; ?>">
            <span class="<?php if ($value_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
          </div><br>
            <button type="submit" class="btn btn-primary btn-block" name="create">Create</button>
            <button type="submit" class="btn btn-danger btn-block" name="cancel">Cancel</button>
        </form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
