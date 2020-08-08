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
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    // Initial Values
    $source = $date_sourced = $sha1 = $adc = $other_detection = $file_detection = $trendx = $trigger = $prev = $path = $analyze_analyze = $date_tested = $tester = $notes = "";
		$source_error = $date_sourced_error = $sha1_error = $adc_error = $other_detection_error = $file_detection_error = $trendx_error = $trigger_error = $prev_error = $path_error = $analyze_analyze_error = $date_tested_error = $tester_error = $notes_error = "";

        if(isset($_POST['update'])){
          // Set Sample Values
          $source = $_POST['source'];
          $date_sourced = $_POST['date_sourced'];
          $adc = $_POST['adc'];
          $other_detection = $_POST['other_detection'];
          $file_detection = $_POST['file_detection'];
          $trendx = $_POST['trendx'];
          $trigger = $_POST['trigger'];
          $prev = $_POST['prev'];
          $path = $_POST['path'];
          $analyze_analyze = $_POST['analyze_analyze'];
          $date_tested = $_POST['date_tested'];
          $tester = $_SESSION['username'];
          $notes = $_POST['notes'];
          $notes = str_replace("'", '', $notes);

          $id = $_SESSION['id_array'];
          $id_last = count($id);
          $hid = $_SESSION['id_array'];
          $hid_last = count($id);

          // Retrieval of Samples Array
          for($i=0; $i<=$id_last; $i++){ //multiple times depends on id
              if($source){
                $source = check($source);
                if(!preg_match("/^[a-zA-Z ]*$/", $source)){
                  $source_error = "Source = Invalid Character/s ";
                }else{
                  $query = "UPDATE charles_table_primary SET source='$source' WHERE id='$id[$i]' ";
                  $result = mysqli_query($conn, $query);
                }
              }

              if($date_sourced){
                $date_sourced = check($date_sourced);
                $query = "UPDATE charles_table_primary SET date_sourced='$date_sourced' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($adc){
                $adc = check($adc);
                if(!preg_match("/^[a-zA-Z ]*$/", $adc)){
                  $adc_error = "ADC = Invalid Character/s ";
                }else{
                  $query = "UPDATE charles_table_primary SET adc='$adc' WHERE id='$id[$i]' ";
                  $result = mysqli_query($conn, $query);
                }
              }
              if($other_detection){
                $other_detection = check($other_detection);
                $query = "UPDATE charles_table_primary SET other_detection='$other_detection' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($file_detection){
                $file_detection = check($file_detection);
                $query = "UPDATE charles_table_primary SET file_detection='$file_detection' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($trendx){
                $trendx = check($trendx);
                $query = "UPDATE charles_table_primary SET trendx='$trendx' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($trigger){
                $trigger = check($trigger);
                $query = "UPDATE charles_table_primary SET trig='$trigger' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($prev){
                $prev = check($prev);
                $query = "UPDATE charles_table_primary SET prev='$prev' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($path){
                $path = addslashes($path);
                $query = "UPDATE charles_table_primary SET path='$path' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($analyze_analyze){
                $analyze_analyze = check($analyze_analyze);
                if(!preg_match("/^[a-zA-Z ]*$/", $analyze_analyze)){
                  $analyze_analyze_error = "Analyze = Invalid Character/s ";
                }else{
                  $query = "UPDATE charles_table_primary SET analyze_analyze='$analyze_analyze' WHERE id='$id[$i]' ";
                  $result = mysqli_query($conn, $query);
                }
              }

              if($date_tested){
                $date_tested = check($date_tested);
                $query = "UPDATE charles_table_primary SET date_tested='$date_tested' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              if($notes){
                $notes = check($notes);
                $query = "UPDATE charles_table_primary SET notes='$notes' WHERE id='$id[$i]' ";
                $result = mysqli_query($conn, $query);
              }

              $query = "UPDATE charles_table_primary SET tester='$_SESSION[username]' WHERE id='$id[$i]' ";
              $result = mysqli_query($conn, $query);
          } // end of for loop
          $log = date("Y-m-d (h:ia)");
          for($i=0; $i<=$hid_last; $i++){
            $query = " SELECT * FROM charles_table_primary where id='$hid[$i]' ";
            $query = mysqli_query($conn, $query);
            while($result = mysqli_fetch_assoc($query)) {
              $sql = "INSERT INTO charles_table_history(source, date_sourced, sha1, adc, other_detection, file_detection, trendx, trig, prev, path, analyze_analyze, date_tested, tester, log, notes)
                VALUES('".$result['source']."', '".$result['date_sourced']."', '".$result['sha1']."', '".$result['adc']."', '".$result['other_detection']."', '".$result['file_detection']."', '".$result['trendx']."', '".$result['trig']."', '".$result['prev']."', '".$result['path']."', '".$result['analyze_analyze']."', '".$result['date_tested']."', '".$result['tester']."', '$log', '".$result['notes']."')";
              $result = mysqli_query($conn, $sql);
              echo mysqli_error($conn);
            }
          }
          
          echo '<script type="text/javascript">';
          echo 'alert("Updated! ' . $source_error . $date_sourced_error . $sha1_error . $adc_error . $analyze_analyze_error . '");';
          echo 'window.location.href = "index.php";';
          echo '</script>';

        }else if(isset($_POST["cancel"])){
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
        <br><br>
        <h3 class="text-center">UPDATE MULTIPLE PRIMARY DATA</h3><br><br>
        <!-- Actual Form -->
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label>Source</label>
                 <div class="input-group <?php if ($source_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-download-alt"></i></span>
                    <select name="source" class="form-control">
                  <option value="">- Select Source -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_source";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>"><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($source_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Date Sourced</label>
                 <div class="input-group <?php if ($date_sourced_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                   <input type="date" class="form-control" name="date_sourced">
                   <span class="<?php if ($date_sourced_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>ADC</label>
                 <div class="input-group <?php if ($adc_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-wrench"></i></span>
                    <select name="adc" class="form-control">
                  <option value="">- Select ADC -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_adc";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>"><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($adc_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Other Detection</label>
                <div class="input-group <?php if ($other_detection_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                   <input type="text" class="form-control" name="other_detection" placeholder="Other Detection">
                   <span class="<?php if ($other_detection_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>File Detection</label>
                <div class="input-group <?php if ($file_detection_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
                   <input type="text" class="form-control" name="file_detection" placeholder="File Detection">
                   <span class="<?php if ($file_detection_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>TrendX</label>
                 <div class="input-group <?php if ($trendx_error) echo "has-error";?> ">
                    <span class="input-group-addon"><i class=" glyphicon glyphicon-remove"></i></span>
                    <input type="text" class="form-control" name="trendx" placeholder="Trend X">
                    <span class="<?php if ($trendx_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                  </div><br>

                  <label>Trigger</label>
                  <div class="input-group <?php if ($trigger_error) echo "has-error";?> ">
                     <span class="input-group-addon"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                     <!-- <input type="text" class="form-control" name="trigger" value="<?php echo $trigger; ?>" data-toggle="tooltip" placeholder="Trigger" title="<?php echo $trigger_error;?>"> -->
                     <select name="trigger" class="form-control" data-toggle="tooltip" placeholder="Trigger" title="<?php echo $trigger_error;?>">
                         <option value="">- Select Trigger -</option>
                         <?php
                           $query = "SELECT * FROM charles_table_trig";
                           $result = mysqli_query($conn, $query);
                         ?>
                         <?php
                           while($row = mysqli_fetch_array($result)):;
                         ?>
                         <option value="<?php echo $row['name'];?>"><?php echo $row['name']; ?></option>
                         <?php
                           endwhile;
                         ?>
                     </select>
                     <span class="<?php if ($trigger_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                   </div><br>

                   <label>Prevalence</label>
                <div class="input-group <?php if ($prev_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                   <input type="number" class="form-control" name="prev" placeholder="Prevalence" >
                   <span class="<?php if ($notes_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Path</label>
                <div class="input-group <?php if ($path_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class=" glyphicon glyphicon-th-list"></i></span>
                   <input type="text" class="form-control" name="path" placeholder="Path">
                   <span class="<?php if ($path_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Analyze</label>
                 <div class="input-group <?php if ($analyze_analyze_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-zoom-in"></i></span>
                    <select name="analyze_analyze" class="form-control">
                  <option value="">- Select Analyze -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_analyze";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>"><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($analyze_analyze_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Date Tested</label>
                 <div class="input-group <?php if ($date_tested_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                   <input type="date" class="form-control" name="date_tested">
                   <span class="<?php if ($date_tested_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Notes</label>
                 <div class="input-group <?php if ($notes_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                   <input type="text" class="form-control" name="notes" placeholder="Notes">
                   <span class="<?php if ($notes_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                    <button type="submit" class="btn btn-primary btn-block" name="update">Update</button>
                    <button type="submit" class="btn btn-danger btn-block" name="cancel">Cancel</button>
                </form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
