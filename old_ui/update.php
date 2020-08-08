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
    $conn = mysqli_connect("localhost", "root", "","charles_db");
    // Initial Values
		$source = $date_sourced = $sha1 = $adc = $other_detection = $file_detection = $trendx = $trigger = $prev = $path = $analyze_analyze = $date_tested = $tester = $notes = "";
		$source_error = $date_sourced_error = $sha1_error = $adc_error = $other_detection_error = $file_detection_error = $trendx_error = $trigger_error = $prev_error = $path_error = $analyze_analyze_error = $date_tested_error = $tester_error = $notes_error = "";
		date_default_timezone_set("Asia/Manila");
		    if(isset($_GET['update'])){
		    	$id = $_GET['update'];
		    	$sql_select = "SELECT * FROM charles_table_primary WHERE id='$id'";
		    	$result_select = mysqli_query($conn, $sql_select);
		    	$row_select = mysqli_fetch_array($result_select);
			  }

		    if(isset($_POST['create'])){
        // Set Sample Values
        $source = $_POST['source'];
        $date_sourced = $_POST['date_sourced'];
        $sha1 = $_POST['sha1'];
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
				$log = date("Y-m-d (h:ia)");
        $notes = $_POST['notes'];
        $notes = str_replace("'", '', $notes);

		      if($source){
		        $source = check($source);
		      }else{
		        $source_error = "Empty";
		      }

		      if($date_sourced){
		        $date_sourced = check($date_sourced);
		      }else{
		        $date_sourced_error = "Empty";
		      }

		      if($sha1){
		        $sha1 = check($sha1);
		        if(!preg_match('/[a-fA-F0-9]{1,8}/', $sha1)){
		          $sha1_error = "Invalid Character/s";
		        }else if(strlen($sha1)!=40){
		          $sha1_error = "Invalid Length";
		        }
		      }else{
		        $sha1_error = "Empty";
		      }

          if($adc){
		        $adc = check($adc);
		      }else{
		        $adc_error = "Empty";
		      }

          $other_detection = check($other_detection);
          $file_detection = check($file_detection);
          $prev = check($prev);
          $path = addslashes($path);

          if($analyze_analyze){
		        $analyze_analyze = check($analyze_analyze);
		      }else{
		        $analyze_analyze_error = "Empty";
		      }

		      if($date_tested){
		        $date_tested = check($date_tested);
		      }else{
		        $date_tested_error = "Empty";
		      }
          //no filter for tester
          $notes = check($notes);
          
          // Filter Checker
				if(empty($source_error) && empty($date_sourced_error) && empty($sha1_error) && empty($adc_error) && empty($analyze_analyze_error) && empty($date_tested_error)){
					if($source!=$row_select['source'] || $date_sourced!=$row_select['date_sourced'] || $sha1!=$row_select['sha1'] || $adc!=$row_select['adc'] || $other_detection!=$row_select['other_detection'] || $file_detection!=$row_select['file_detection'] || $trendx!=$row_select['trendx'] || $trigger!=$row_select['trig'] || $prev!=$row_select['prev'] || $path!=$row_select['path'] || $analyze_analyze!=$row_select['analyze_analyze'] || $date_tested!=$row_select['date_tested'] || $tester!=$row_select['tester'] || $notes!=$row_select['notes']){
						$sql = "INSERT INTO charles_table_history(source, date_sourced, sha1, adc, other_detection, file_detection, trendx, trig, prev, path, analyze_analyze, date_tested, tester, log, notes)
              VALUES('$source', '$date_sourced', '$sha1', '$adc', '$other_detection', '$file_detection', '$trendx', '$trigger', '$prev', '$path', '$analyze_analyze', '$date_tested', '$tester', '$log', '$notes')";
						$result = mysqli_query($conn, $sql);
						echo mysqli_error($conn);
					}
          
					$sql = "UPDATE charles_table_primary SET source='$source', date_sourced='$date_sourced', sha1='$sha1', adc='$adc', other_detection='$other_detection', file_detection='$file_detection', trendx='$trendx', trig='$trigger', prev='$prev', path='$path', analyze_analyze='$analyze_analyze', date_tested='$date_tested', tester='$tester', notes='$notes' WHERE id='$id'";
          $result = mysqli_query($conn, $sql);
					echo '<script type="text/javascript">';
					echo 'alert("Successfully Updated!");';
				 	echo 'window.location.href = "index.php";';
					echo '</script>';
				}

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

    <div class="col-sm-10">

       <div class="col-sm-offset-3 col-sm-6">
        <br><br>
        <h3 class="text-center">UPDATE PRIMARY DATA</h3><br><br>
          <!-- Actual Form -->
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label>Source</label>
                 <div class="input-group <?php if ($source_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-download-alt"></i></span>
                    <select name="source" class="form-control" data-toggle="tooltip" title="<?php echo $source_error;?>">
                  <option value="">- Select Source -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_source";
                    $result = mysqli_query($conn, $query);
                  	?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>" <?php if($row_select['source']==$row['value']) echo "selected";?>><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($source_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Date Sourced</label>
                 <div class="input-group <?php if ($date_sourced_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                   <input type="date" class="form-control" name="date_sourced" value="<?php echo $row_select['date_sourced'] ?>" data-toggle="tooltip" title="<?php echo $date_sourced_error; ?>">
                   <span class="<?php if ($date_sourced_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>SHA-1</label>
                 <div class="input-group <?php if ($sha1_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
                   <input type="text" class="form-control" name="sha1" value="<?php echo $row_select['sha1'] ?>" data-toggle="tooltip" placeholder="SHA1" title="<?php echo $sha1_error;?>">
                   <span class="<?php if ($sha1_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>ADC</label>
                 <div class="input-group <?php if ($adc_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-wrench"></i></span>
                    <select name="adc" class="form-control" data-toggle="tooltip" title="<?php echo $row_select['adc']?>">
                  <option value="">- Select ADC -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_adc";
                    $result = mysqli_query($conn, $query);
                  	?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>" <?php if($row_select['adc']==$row['value']) echo "selected";?>><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($adc_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Other Detection</label>
                <div class="input-group <?php if ($other_detection_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                   <input type="text" class="form-control" name="other_detection" value="<?php echo $row_select['other_detection']; ?>" data-toggle="tooltip" placeholder="Other Detection" title="<?php echo $other_detection_error;?>">
                   <span class="<?php if ($other_detection_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>File Detection</label>
                <div class="input-group <?php if ($file_detection_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
                   <input type="text" class="form-control" name="file_detection" value="<?php echo $row_select['file_detection']; ?>" data-toggle="tooltip" placeholder="File Detection" title="<?php echo $file_detection_error;?>">
                   <span class="<?php if ($file_detection_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>TrendX</label>
                 <div class="input-group <?php if ($trendx_error) echo "has-error";?> ">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
                    <input type="text" class="form-control" name="trendx" value="<?php echo $row_select['trendx']; ?>" data-toggle="tooltip" placeholder="Trend X" title="<?php echo $trendx_error;?>">
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
                       <option value="<?php echo $row['name'];?>" <?php if($row_select['trig']==$row['name']) echo "selected";?>><?php echo $row['name']; ?></option>
                       <?php
                         endwhile;
                       ?>
                   </select>
                   <span class="<?php if ($trigger_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                <label>Prevalence</label>
                <div class="input-group <?php if ($prev_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                   <input type="number" class="form-control" name="prev" value="<?php echo $row_select['prev']; ?>" data-toggle="tooltip" placeholder="Prevalence" title="<?php echo $prev_error;?>">
                   <span class="<?php if ($notes_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                <label>Path</label>
                <div class="input-group <?php if ($path_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class=" glyphicon glyphicon-th-list"></i></span>
                   <input type="text" class="form-control" name="path" value="<?php echo $row_select['path']; ?>" data-toggle="tooltip" placeholder="Path" title="<?php echo $path_error;?>">
                   <span class="<?php if ($path_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Analyze</label>
                 <div class="input-group <?php if ($analyze_analyze_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-zoom-in"></i></span>
                    <select name="analyze_analyze" class="form-control" data-toggle="tooltip" title="<?php echo $analyze_analyze_error;?>">
                  <option value="">- Select Analyze -</option>
                    <?php
                      $query = "SELECT * FROM charles_table_analyze";
                    $result = mysqli_query($conn, $query);
                  	?>
                    <?php
                      while($row = mysqli_fetch_array($result)):;
                    ?>
                    <option value="<?php echo $row['value'];?>" <?php if($row_select['analyze_analyze']==$row['value']) echo "selected";?>><?php echo $row['name']; ?></option>
                    <?php
                      endwhile;
                    ?>
                </select>
                   <span class="<?php if ($analyze_analyze_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

                 <label>Date Tested</label>
                 <div class="input-group <?php if ($date_tested_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                   <input type="date" class="form-control" name="date_tested" value="<?php echo $row_select['date_tested']; ?>" data-toggle="tooltip" title="<?php echo $date_tested_error; ?>">
                   <span class="<?php if ($date_tested_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
                 </div><br>

               <label>Notes</label>
                 <div class="input-group <?php if ($notes_error) echo "has-error";?> ">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                   <input type="text" class="form-control" name="notes" value="<?php echo $row_select['notes']; ?>" data-toggle="tooltip" placeholder="Notes" title="<?php echo $notes_error;?>">
                   <span class="<?php if ($notes_error) echo "glyphicon glyphicon-warning-sign form-control-feedback";?>"></span>
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
