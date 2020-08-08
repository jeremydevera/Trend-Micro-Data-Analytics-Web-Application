
<!DOCTYPE html>
<html>
<head>
  <title>CI - Samples Index</title>
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
      background-color: #263643;
      height: 100%;
      position: fixed;
    }
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
</head>


  <?php
    session_start();
    $source_search = $date_sourced_search1 = $date_sourced_search2 = $sha1_search = $adc_search = $other_detection_search = $file_detection_search = $trendx_search = $trigger_search = $prev_search1 = $prev_search2  = $path_search = $analyze_analyze_search = $date_tested_search1 = $date_tested_search2 = $tester_search = $notes_search = "";
    $count = 10;
    $search_query = "";
    $page = 0; $filter=''; $markall = "";

    $_SESSION['query'] = $search_query;
    if(isset($_POST['create'])){
      header("Location:create.php");
    }
    else if(isset($_POST['update_many'])){
      $_SESSION['id_array'] = $_POST['check_box'];
      header("Location:update_many.php");
    }
    else if(isset($_POST['delete_many'])){
      $_SESSION['id_array'] = $_POST['check_box'];
      header("Location:delete_many_verify.php");
    }
    if(isset($_POST['search']) || isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
      if(isset($_POST['count_per_page'])) {
        $count = $_POST['count_per_page'];
      }
      $page = ($_POST['page']-1)*$count;
      $pass = true;
      $source_search = $_POST['source_search'];
      $date_sourced_search1 = $_POST['date_sourced_search1'];
      $date_sourced_search2 = $_POST['date_sourced_search2'];
      $sha1_search = $_POST['sha1_search'];
      $adc_search = $_POST['adc_search'];
      $other_detection_search = $_POST['other_detection_search'];
      $notes_search = $_POST['notes_search'];
      $file_detection_search = $_POST['file_detection_search'];
      $trendx_search = $_POST['trendx_search'];
      $trigger_search = $_POST['trigger_search'];
      $prev_search1 = $_POST['prev_search1'];
      $prev_search2 = $_POST['prev_search2'];
      $path_search = addslashes(addslashes($_POST['path_search']));
      $analyze_analyze_search = $_POST['analyze_analyze_search'];
      $date_tested_search1 = $_POST['date_tested_search1'];
      $date_tested_search2 = $_POST['date_tested_search2'];
      $tester_search = $_POST['tester_search'];

      if($source_search && $pass){
        $source_query = "source='$source_search'";
        $pass = false;
        $filter++;
      }else if($source_search && !$pass){
        $source_query = "AND source='$source_search'";
        $filter++;
      }else{
        $source_query = "";
      }

      if($date_sourced_search1 && $date_sourced_search2 && $pass){
        $date_sourced_query = "date_sourced BETWEEN '$date_sourced_search1' AND '$date_sourced_search2'";
        $pass = false;
        $filter++;
      }else if($date_sourced_search1 && $date_sourced_search2 && !$pass){
        $date_sourced_query = "AND date_sourced BETWEEN '$date_sourced_search1' AND '$date_sourced_search2'";
        $filter++;
      }else{
        $date_sourced_query = "";
      }

      if($sha1_search && $pass){
        $sha1_query = "sha1='$sha1_search'";
        $pass = false;
        $filter++;
      }else if($sha1_search && !$pass){
        $sha1_query = "AND sha1='$sha1_search'";
        $filter++;
      }else{
        $sha1_query = "";
      }

      if($adc_search && $pass){
        $adc_query = "adc='$adc_search'";
        $pass = false;
        $filter++;
      }else if($adc_search && !$pass){
        $adc_query = "AND adc='$adc_search'";
        $filter++;
      }else{
        $adc_query = "";
      }

      if($other_detection_search && $pass){
        $other_detection_query = "other_detection LIKE '%$other_detection_search%'";
        $pass = false;
        $filter++;
      }else if($other_detection_search && !$pass){
        $other_detection_query = "AND other_detection LIKE '%$other_detection_search%'";
        $filter++;
      }else{
        $other_detection_query = "";
      }

      if($file_detection_search && $pass){
        $file_detection_query = "file_detection LIKE '%$file_detection_search%'";
        $pass = false;
        $filter++;
      }else if($file_detection_search && !$pass){
        $file_detection_query = "AND file_detection LIKE '%$file_detection_search%'";
        $filter++;
      }else{
        $file_detection_query = "";
      }

      if($trendx_search && $pass){
        $trendx_query = "trendx LIKE '%$trendx_search%'";
        $pass = false;
        $filter++;
      }else if($trendx_search && !$pass){
        $trendx_query = "AND trendx LIKE '%$trendx_search%'";
        $filter++;
      }else{
        $trendx_query = "";
      }

      if($trigger_search && $pass){
        $trigger_query = "trig LIKE '%$trigger_search%'";
        $pass = false;
        $filter++;
      }else if($trigger_search && !$pass){
        $trigger_query = "AND trig LIKE '%$trigger_search%'";
        $filter++;
      }else{
        $trigger_query = "";
      }

      if($prev_search1 && $prev_search2 && $pass){
        $prev_query = "prev BETWEEN '$prev_search1' AND '$prev_search2'";
        $pass = false;
        $filter++;
      }else if($prev_search1 && $prev_search2 && !$pass){
        $prev_query = "AND prev BETWEEN '$prev_search1' AND '$prev_search2'";
        $filter++;
      }else{
        $prev_query = "";
      }

      if($path_search && $pass){
        $path_query = "path LIKE '%$path_search%'";
        $pass = false;
        $filter++;
      }else if($path_search && !$pass){
        $path_query = "AND path LIKE '%$path_search%'";
        $filter++;
      }else{
        $path_query = "";
      }

      if($analyze_analyze_search && $pass){
        $analyze_analyze_query = "analyze_analyze='$analyze_analyze_search'";
        $pass = false;
        $filter++;
      }else if($analyze_analyze_search && !$pass){
        $analyze_analyze_query = "AND analyze_analyze='$analyze_analyze_search'";
        $filter++;
      }else{
        $analyze_analyze_query = "";
      }

      if($date_tested_search1 && $date_tested_search2 && $pass){
        $date_tested_query = "date_tested BETWEEN '$date_tested_search1' AND '$date_tested_search2'";
        $pass = false;
        $filter++;
      }else if($date_tested_search1 && $date_tested_search2 && !$pass){
        $date_tested_query = "AND date_tested BETWEEN '$date_tested_search1' AND '$date_tested_search2'";
        $filter++;
      }else{
        $date_tested_query = "";
      }

      if($tester_search && $pass){
        $tester_query = "tester='$tester_search'";
        $pass = false;
        $filter++;
      }else if($tester_search && !$pass){
        $tester_query = "AND tester='$tester_search'";
        $filter++;
      }else{
        $tester_query = "";
      }

      if($notes_search && $pass){
        $notes_query = "notes LIKE '%$notes_search%'";
        $pass = false;
        $filter++;
      }else if($notes_search && !$pass){
        $notes_query = "AND notes LIKE '%$notes_search%'";
        $filter++;
      }else{
        $notes_query = "";
      }

        if(!$source_search && (!$date_sourced_search1 || !$date_sourced_search2) && !$sha1_search && !$adc_search && !$other_detection_search && !$trendx_search && !$trigger_search && !$file_detection_search && (!$prev_search1 || !$prev_search2) && !$path_search && !$analyze_analyze_search && (!$date_tested_search1 || !$date_tested_search2) && !$tester_search && !$notes_search){
          $search_query = "";
          $_SESSION['query'] = $search_query;
        }else{
          $search_query = "WHERE $source_query $date_sourced_query $sha1_query $adc_query $other_detection_query $trendx_query $trigger_query $file_detection_query $prev_query $path_query $analyze_analyze_query $date_tested_query $tester_query $notes_query";
          $_SESSION['query'] = $search_query;
        }
    }
    else if(isset($_POST['search_clear']) || isset($_POST['page_select'])){
      $page = ($_POST['page']-1)*10;
      $search_query = "";
      $_SESSION['query'] = $search_query;
    }
  ?>


<body>
  <form class="horizontal" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <?php
        include 'navbar.php';
      ?>


      <div class="col-sm-offset-2 col-sm-10" style="position: static; z-index: -1;">
          <h3 class="text-center" style="margin-top:-1px;">PRIMARY DATA</h3>
              <button type="submit" class='btn btn-success btn-sm' name="create" data-toggle='tooltip' title='Create'><span style="position: static; z-index: -1;" class='glyphicon glyphicon-plus'></span> CREATE</button>
              <button type="submit" class="btn btn-primary btn-sm" name="update_many" data-toggle='tooltip' title='Update Selected'><span style="position: static; z-index: -1;" class="glyphicon glyphicon-pencil"></span> EDIT</button>
              <button type="submit" class="btn btn-danger btn-sm" name="delete_many" data-toggle='tooltip' title='Delete Selected'><span style="position: static; z-index: -1;" class="glyphicon glyphicon-trash"></span> DELETE</button>
              <a href="csv.php" class="btn btn-warning btn-sm" data-toggle='tooltip' title='Import to CSV'><span style="position: static; z-index: -1;" class="glyphicon glyphicon-download-alt"></span> CSV</a>
              <a href="chart.php" class="btn btn-info btn-sm" data-toggle='tooltip' title='Create Chart' target="_blank"><span style="position: static; z-index: -1;" class="glyphicon glyphicon-globe"></span> CHART</a>
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><span style="position: static; z-index: -1;" class="glyphicon glyphicon-search"></span> FILTER <span class="badge" data-toggle="tooltip" title="Filtered"><?php echo $filter;?></span></button>
            <!-- Modal filter start -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title text-center">FILTER RESULTS</h4>
                    </div>
                    <div class="modal-body">
                      <div class="input-group col-xs-12">
                        <select name="source_search" class="form-control">
                            <option value="">- Select Source -</option>
                            <?php
                              $conn = mysqli_connect("localhost", "root", "", "charles_db");
                              $query = "SELECT * FROM charles_table_source";
                              $result = mysqli_query($conn, $query);
                            ?>
                            <?php
                              while($row = mysqli_fetch_array($result)):;
                            ?>
                            <option value="<?php echo $row['value'];?>" <?php if($source_search == $row['value']) echo "selected"; ?> > <?php echo $row['name']; ?></option>
                            <?php
                              endwhile;
                            ?>
                        </select>

                        <div class="input-group col-xs-12">
                          <input type="date" id="date_sourced_search1" name="date_sourced_search1" value="<?php echo $date_sourced_search1; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="date" id="date_sourced_search2" name="date_sourced_search2" value="<?php echo $date_sourced_search2; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" name="sha1_search" id="sha1_search" placeholder="SHA1" value="<?php echo $sha1_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <select name="adc_search" class="form-control">
                              <option value="">- Select ADC -</option>
                              <?php
                                $conn = mysqli_connect("localhost", "root", "", "charles_db");
                                $query = "SELECT * FROM charles_table_adc";
                                $result = mysqli_query($conn, $query);
                              ?>
                              <?php
                                while($row = mysqli_fetch_array($result)):;
                              ?>
                              <option value="<?php echo $row['value'];?>" <?php if($adc_search == $row['value']) echo "selected"; ?> ><?php echo $row['name']; ?></option>
                              <?php
                                endwhile;
                              ?>
                          </select>
                        </div>
                        <div class="input-group col-xs-12">
                          <input type="text" id="other_detection_search" name="other_detection_search" placeholder="Other Detection" value="<?php echo $other_detection_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" id="file_detection_search" name="file_detection_search" placeholder="File Detection" value="<?php echo $file_detection_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" id="trendx_search" name="trendx_search" placeholder="Trend X" value="<?php echo $trendx_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" id="trigger_search" name="trigger_search" placeholder="Trigger" value="<?php echo $trigger_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="number" id="prev_search1" name="prev_search1" placeholder="Prevalence Min" value="<?php echo $prev_search1; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="number" id="prev_search2" name="prev_search2" placeholder="Prevalence Max" value="<?php echo $prev_search2; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" id="path_search" name="path_search" placeholder="Path" value="<?php echo stripslashes(stripslashes($path_search)); ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <select name="analyze_analyze_search" class="form-control">
                              <option value="">- Select Analyze -</option>
                              <?php
                                $conn = mysqli_connect("localhost", "root", "", "charles_db");
                                $query = "SELECT * FROM charles_table_analyze";
                                $result = mysqli_query($conn, $query);
                              ?>
                              <?php
                                while($row = mysqli_fetch_array($result)):;
                              ?>
                              <option value="<?php echo $row['value'];?>" <?php if($analyze_analyze_search == $row['value']) echo "selected"; ?> ><?php echo $row['name']; ?></option>
                              <?php
                                endwhile;
                              ?>
                          </select>
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="date" id="date_tested_search1" name="date_tested_search1" value="<?php echo $date_tested_search1; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="date" id="date_tested_search2" name="date_tested_search2" value="<?php echo $date_tested_search2; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <select name="tester_search" class="form-control">
                              <option value="">- Select Tester -</option>
                              <?php
                                $conn = mysqli_connect("localhost", "root", "", "charles_db");
                                $query = "SELECT * FROM charles_table_users";
                                $result = mysqli_query($conn, $query);
                              ?>
                              <?php
                                while($row = mysqli_fetch_array($result)):;
                              ?>
                              <option value="<?php echo $row['username'];?>" <?php if($tester_search == $row['username']) echo "selected"; ?> ><?php echo $row['username']; ?></option>
                              <?php
                                endwhile;
                              ?>
                          </select>
                        </div>

                        <div class="input-group col-xs-12">
                          <input type="text" id="notes_search" name="notes_search" placeholder="Notes" value="<?php echo $notes_search; ?>" class="form-control">
                        </div>

                        <div class="input-group col-xs-12">
                          <button type="submit" class="btn btn-success btn-block" name="search" data-toggle='tooltip' id='submit_modal' title='Search'><span class="glyphicon glyphicon-search"></span></button>
                          <button type="submit" class="btn btn-danger btn-block" name="search_clear" data-toggle='tooltip' title='Clear Search'><span class="glyphicon glyphicon-repeat"></span></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <!-- Modal filter end -->
          <script>
            function selectAll() {
                var blnChecked = document.getElementById("select_all_invoices").checked;
                var check_invoices = document.getElementsByClassName("check_invoice");
                var intLength = check_invoices.length;
                for(var i = 0; i < intLength; i++) {
                    var check_invoice = check_invoices[i];
                    check_invoice.checked = blnChecked;
                }
            }
          </script>

          <script type="text/javascript">
            $(document).ready(function() {
              $(‘.sg-input-radio’).click(function(){
                $(‘.sg-next-button’).trigger(‘click’);
              });
            });
          </script>

        <?php
          $conn = mysqli_connect("localhost", "root", "", "charles_db");
          $query_count = "SELECT * FROM charles_table_primary $search_query ORDER by id desc";
          $result_count = mysqli_query($conn, $query_count);
          $row_count = mysqli_num_rows($result_count);

          $query = "SELECT * FROM charles_table_primary $search_query ORDER by id desc LIMIT $page, $count";
          $result = mysqli_query($conn, $query);

          echo "
          <br<br><br><br><div class='table' style='position: static; z-index: -1;'>
              <table class='table table-hover'>
                <thead>
                <tr>
                <th><input type='checkbox' id='select_all_invoices' onclick='selectAll()' data-toggle='tooltip' title='Mark All'></th>
                <th></th>
                <th>SOURCE</th>
                <th>DATE SOURCED</th>
                <th>SHA1</th>
                <th>ADC</th>
                <th>OTHER DETECTION</th>
                <th>FILE DETECTION</th>
                <th>TRENDX</th>
                <th>TRIGGER</th>
                <th>PREVALENCE</th>
                <th>PATH</th>
                <th>ANALYZE</th>
                <th>DATE TESTED</th>
                <th>TESTER</th>
                <th style='padding: 0 1200px 8px 0'>NOTES</th>
                </tr>
            </thead>
            <tbody>
            <tr>";
            while($row = mysqli_fetch_assoc($result)){
              echo "<td>" . "<input type='checkbox' name='check_box[]' value='$row[id]' id='myDIV' class='check_invoice' data-toggle='tooltip' title='Mark'>" . "</td><td>" .
              "<div class='dropdown' style='position: static; z-index: -1;'>
                <button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'><span class='caret'></span></button>
                <ul style='position: static; z-index: 0;' class='dropdown-menu'>
                  <li><a href='update.php?update=$row[id]'>Update</a></li>
                  <li><a href='delete_verify.php?delete=$row[id]'>Delete</a></li>
                </ul>
              </div>" . "</td><td title='Source'>"
             . $row['source'] . "</td><td title='Date Sourced'>" . $row['date_sourced'] . "</td><td title='SHA-1'>" . $row['sha1'] . "</td><td title='ADC'>" . $row['adc'] . "</td><td title='Other Detection'>" . $row['other_detection'] . "</td><td title='File Detection'>" .  $row['file_detection'] . "</td><td title='TrendX'>" . $row['trendx'] . "</td><td title='Trigger'>" . $row['trig'] . "</td><td title='Prevalence' align='center'>" . $row['prev'] . "</td><td title='Path'>" . $row['path'] . "</td><td title='Analyze' align='center'>"
             . $row['analyze_analyze'] . "</td><td title='Date Tested'>" . $row['date_tested'] . "</td><td title='Tester'>"  . $row['tester'] . "</td><td title='Notes'>" . $row['notes'] . "</td><td>" . "</td></tr>";
          }
          $current = floor((($page)/$count)+1);
          $total = ceil($row_count/$count);
          echo "</tbody></table></div>";
          echo "<br>";
          echo "<div class='col-sm-12' style='position: static; z-index: -1;'>";
          echo "<input type='button' style='padding: 10px; border: none; background: none;' class='btn btn-default' value='<<' onclick='change_page(1)''></input>";
          echo "<input type='button' style='padding: 10px; border: none; background: none;' class='btn btn-default' value='<' onclick='change_page((($page)/$count))''></input>";
          echo "<select name='page' style='padding: 5px; margin-bottom:10px; class='btn btn-default btn-sm' id='page' onchange='change_page(-1)'>";
          echo "<option value='1'>$current / $total</option>";
          for($p=1; $p<=ceil($row_count/$count); $p++){
            echo "<option id='page$p' class='button' value='$p' $pick>$p</option>";
          }

          echo "</select>";
          echo "<input type='button' style='padding: 10px; border: none; background: none;' class='btn btn-default'' value='>' onclick='change_page(((($page)/$count)+2)%(Math.ceil($row_count/$count)+1))'></input>";
          echo "<input type='button' style='padding: 10px; border: none; background: none;' class='btn btn-default' value='>>' onclick='change_page(Math.ceil($row_count/$count))'></input><br>";
          echo "</div>";
          echo "Showing ";
          echo "<input type='text' style='width: 40px; margin-right: 2px; margin-left: 5px; text-align: center;' value='$count' name='count_per_page' id='count_per_page'></input>";
          echo "<button type='submit' style='margin-right: 5px;' id='button_changepage' class='btn btn-default btn-sm' name='page_select' data-toggle='tooltip' title='Submit Page'><span style='position: static; z-index: -1;' class='glyphicon glyphicon-ok'></span></button>";
          echo "per page. ($row_count Results)";
          echo "</form><br>";
        ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    var input = document.getElementById("count_per_page");
    input.addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            document.getElementById("button_changepage").click();
        }
    });
    var modal_inputs = document.getElementById('myModal').getElementsByTagName('input');
    var i = 0;
    for(i = 0; i < modal_inputs.length; i++) {
      var input = modal_inputs[i]
      input.addEventListener("keyup", function(event) {
          event.preventDefault();
          if (event.keyCode === 13) {
              document.getElementById("submit_modal").click();
          }
      });
    }
  </script>

  <script>
    function change_page(page) {
        if(page > 0) {
          document.getElementById('page').value = page
        }
        document.getElementById("button_changepage").click();
    }
  </script>


</body>
</html>
