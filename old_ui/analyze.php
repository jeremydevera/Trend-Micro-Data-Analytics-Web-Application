<?php
  include 'pass.php';
?>
<!DOCTYPE html>
<html lang="en">
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
<body>

    <?php
      include 'navbar.php';
    ?>


    <div class="col-sm-offset-2 col-sm-10">
    <h3 class="text-center">ANALYZE</h3>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <a href='create_analyze.php' class='btn btn-success btn-sm' data-toggle='tooltip' title='Create'><span class='glyphicon glyphicon-plus'></span> CREATE</a>
        <?php
          $page = 0;

          if(isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
            $page = ($_POST['page']-1)*10;
          }

          $conn = mysqli_connect("localhost", "root", "", "charles_db");
          $query_count = "SELECT * FROM charles_table_analyze ORDER by id desc";
          $result_count = mysqli_query($conn, $query_count);
          $row_count = mysqli_num_rows($result_count);

          $query = "SELECT * FROM charles_table_analyze ORDER by id desc LIMIT $page, 10";
          $result = mysqli_query($conn, $query);
          echo "
          <div class='table-responsive'>
              <table class='table table-hover'>
                <thead>
                  <tr>
                    <th></th>
                    <th>NAME</th>
                    <th>VALUE</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>";
          while($row = mysqli_fetch_assoc($result)){
            echo "<td>" .
              "<div class='dropdown'>
                <button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'><span class='caret'></span></button>
                <ul class='dropdown-menu'>
                  <li><a href='update_analyze.php?update=$row[id]'>Update</a></li>
                  <li><a href='delete_analyze.php?delete=$row[id]'>Delete</a></li>
                </ul>
              </div>" . "</td><td>" . $row['name'] . "</td><td>" . $row['value'] . "</td><td>"
             . "</td></tr>";
          }
          echo "</tbody></table></div>";
          echo "<br><br><br>";
          echo "<div class='col-sm-12'>";
          echo "<select name='page' class='btn btn-default btn-sm'>";
          echo "<option value='1'>Page</option>";
          for($p=1; $p<=ceil($row_count/10); $p++){
            echo "<option value='$p' $pick>$p</option>";
          }
          echo "</select>";
          echo "<button type='submit' class='btn btn-default btn-sm' name='page_select' data-toggle='tooltip' title='Submit Page'><span class='glyphicon glyphicon-ok'></span></button>";
          echo " Page " . ((($page)/10)+1) . " of " . ceil($row_count/10);
          echo " ($row_count Results)";
          echo "</div>";
          echo "</form>";
        ?>
    </div>
  </div>
</div>

</body>
</html>
